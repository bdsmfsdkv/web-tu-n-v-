<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Exceptions\WheelSpinException;
use App\Models\LuckyWheel;
use App\Models\LuckyWheelHistory;
use App\Models\RandomCategoryAccount;
use App\Models\RewardItem;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class LuckyCategoryController extends Controller
{
    // Hiển thị tất cả danh mục vòng quay
    public function showAll()
    {
        $title = 'Vòng Quay May Mắn';
        // Lấy tất cả danh mục vòng quay đang hoạt động
        // withCount tránh N+1: trước đây mỗi vòng quay load toàn bộ bảng lịch sử chỉ để đếm.
        $categories = LuckyWheel::where('active', 1)
            ->withCount('histories')
            ->get();

        foreach ($categories as $category) {
            $category->soldCount = (int) $category->histories_count;
        }

        return view('user.wheel.show-all', compact('categories', 'title'));
    }

    // Hiển thị chi tiết vòng quay
    public function index($slug)
    {
        $wheel = LuckyWheel::where('slug', $slug)->where('active', 1)->first();
        if (!$wheel) {
            return redirect()->route('home');
        }

        // Lấy 10 lượt quay gần nhất của vòng quay này để hiển thị công khai ở khối "NHẬT KÝ"
        $history = LuckyWheelHistory::with('user:id,username')
            ->where('lucky_wheel_id', $wheel->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $inventory = $this->resolveWheelInventory($wheel, Auth::user());
        $linkedItem = $inventory['linked_item'];
        $itemBalance = $inventory['balance'];
        $inventoryUnit = $inventory['unit'];

        return view('user.wheel.detail', compact('wheel', 'history', 'linkedItem', 'itemBalance', 'inventoryUnit'));
    }

    // Xử lý quay vòng quay
    public function spin(Request $request, $slug)
    {
        $startedAt = hrtime(true);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để có thể quay'
            ], 401);
        }
        // Validate dữ liệu đầu vào
        try {
            // Locale 'vi' chưa có file lang nên phải khai báo message tiếng Việt tại đây,
            // nếu không người dùng nhận về chuỗi thô kiểu "validation.max.numeric".
            $request->validate([
                'spin_count' => 'required|integer|min:1|max:10',
            ], [
                'spin_count.required' => 'Vui lòng chọn số lượt quay.',
                'spin_count.integer' => 'Số lượt quay không hợp lệ.',
                'spin_count.min' => 'Phải quay tối thiểu 1 lượt.',
                'spin_count.max' => 'Mỗi lần quay tối đa 10 lượt.',
            ]);

            $user = Auth::user();
            $wheel = LuckyWheel::where('slug', $slug)->where('active', 1)->firstOrFail();
            $spinCount = (int) $request->input('spin_count');
            $totalCost = (int) $wheel->price_per_spin * $spinCount;

            // Kiểm tra số dư sớm để không phải mở transaction khi chắc chắn không quay được.
            if ($user->balance < $totalCost) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số dư không đủ để quay. Vui lòng nạp thêm tiền.'
                ], 422);
            }

            DB::beginTransaction();
            $user = $user->newQuery()->lockForUpdate()->findOrFail($user->id);
            $balanceBefore = (int) $user->balance;

            if ($balanceBefore < $totalCost) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Số dư không đủ để quay. Vui lòng nạp thêm tiền.'
                ], 422);
            }

            // Lấy config từ wheel
            // Keep original config keys so frontend animation points to correct wheel slot.
            $config = collect($wheel->config ?? [])
                ->map(static function (array $reward, int $index): array {
                    $reward['_wheel_index'] = $index;

                    return $reward;
                })
                ->filter(static fn (array $reward): bool => !array_key_exists('active', $reward) || (bool) $reward['active'])
                ->values()
                ->all();

            // Tính toán phần thưởng dựa trên tỷ lệ
            $rewardIndex = $this->calculateReward($config);
            $reward = $config[$rewardIndex];
            $wheelIndex = $reward['_wheel_index'];
            $rewardType = $reward['reward_type'] ?? $reward['type'] ?? 'empty';
            $rewardContent = (string) ($reward['content'] ?? '');
            $rewardItem = null;
            $rewardItemId = null;
            $rewardIcon = null;

            if ($rewardType === 'item') {
                $rewardItemId = $reward['reward_item_id'] ?? null;
                $rewardItem = $rewardItemId ? RewardItem::whereKey($rewardItemId)
                    ->where('active', 1)
                    ->first() : null;

                if (!$rewardItem) {
                    throw new WheelSpinException('Vật phẩm phần thưởng chưa được cấu hình hợp lệ.');
                }

                $rewardItemId = (int) $rewardItem->id;
                $rewardIcon = $rewardItem->icon ? asset($rewardItem->icon) : null;
            }

            $rewardAmount = $this->rewardAmount($reward['amount'] ?? null);
            $totalRewardAmount = $rewardAmount;

            // Tạo kết quả phần thưởng
            $rewardResult = [
                'type' => $rewardType,
                'content' => $rewardContent,
                'amount' => $totalRewardAmount,
                'index' => $wheelIndex,
                'icon' => $rewardIcon,
                'reward_item_id' => $rewardItemId,
                'reward_unit' => $rewardItem->unit ?? null,
            ];

            // Lưu lịch sử với spin_count
            LuckyWheelHistory::create([
                'user_id' => $user->id,
                'lucky_wheel_id' => $wheel->id,
                'reward_item_id' => $rewardItemId,
                'spin_count' => $spinCount,
                'total_cost' => $totalCost,
                'reward_type' => $rewardType,
                'reward_amount' => $totalRewardAmount,
                'description' => $rewardContent,
            ]);

            $balanceAfterCost = $balanceBefore - $totalCost;
            $user->balance = $balanceAfterCost;

            // Cộng thưởng vào tài khoản
            if ($rewardType === 'money') {
                $user->balance += $totalRewardAmount;
            } else if ($rewardType === 'gold') {
                $user->gold += $totalRewardAmount;
            } else if ($rewardType === 'gem') {
                $user->gem += $totalRewardAmount;
            } else if ($rewardType === 'random_account') {
                $accounts = RandomCategoryAccount::where('status', 'available')
                    ->lockForUpdate()
                    ->limit($totalRewardAmount)
                    ->get();

                if ($accounts->count() < $totalRewardAmount) {
                    throw new WheelSpinException('Kho tài khoản thưởng tạm hết, vui lòng thử lại sau.');
                }

                $batchId = uniqid('WHEEL-');
                RandomCategoryAccount::whereKey($accounts->modelKeys())->update([
                    'status' => 'sold',
                    'buyer_id' => $user->id,
                    'batch_id' => $batchId,
                    'updated_at' => now(),
                ]);
            }

            $user->save();

            $now = now();
            $transactionRows = [[
                'user_id' => $user->id,
                'type' => 'purchase',
                'amount' => -$totalCost,
                'balance_before' => $balanceBefore,
                // Chỉ ghi nhận phần trừ tiền vé quay, tiền thưởng tách sang dòng riêng
                // để amount luôn bằng balance_after - balance_before.
                'balance_after' => $balanceAfterCost,
                'description' => 'Quay ' . $wheel->name . ' x' . $spinCount . ' - ' . $rewardContent,
                'reference_id' => 'LW-' . $wheel->id,
                'created_at' => $now,
                'updated_at' => $now,
            ]];

            if ($rewardType === 'money' && $totalRewardAmount > 0) {
                $transactionRows[] = [
                    'user_id' => $user->id,
                    'type' => 'refund',
                    'amount' => $totalRewardAmount,
                    'balance_before' => $balanceAfterCost,
                    'balance_after' => $balanceAfterCost + $totalRewardAmount,
                    'description' => 'Thưởng tiền từ ' . $wheel->name . ' - ' . $rewardContent,
                    'reference_id' => 'LW-' . $wheel->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            DB::table('money_transactions')->insert($transactionRows);

            // Cập nhật số dư "BẠN ĐANG CÓ" chính xác theo loại tài nguyên của vòng quay này
            $inventory = $this->resolveWheelInventory($wheel, $user);
            $linkedItemId = $inventory['linked_item_id'];
            $linkedItemBalance = $inventory['type'] === 'item' ? $inventory['balance'] : null;
            $wonItemBalance = $rewardItemId ? $this->itemBalance((int) $user->id, $wheel->id, $rewardItemId) : null;

            DB::commit();

            Log::debug('Đo thời gian quay vòng quay', [
                'user_id' => $user->id,
                'slug' => $slug,
                'elapsed_ms' => round((hrtime(true) - $startedAt) / 1e6, 2),
            ]);

            return response()->json([
                'success' => true,
                'rewards' => [$rewardResult], // Vẫn giữ cấu trúc mảng để tương thích với frontend
                'new_balance' => $user->balance,
                'new_gold' => $user->gold ?? 0,
                'new_gem' => $user->gem ?? 0,
                'inventory' => [
                    'type' => $inventory['type'],
                    'balance' => $inventory['balance'],
                    'unit' => $inventory['unit'],
                    'linked_item_id' => $inventory['linked_item_id'],
                ],
                'history_entry' => [
                    'username' => \Illuminate\Support\Str::substr($user->username, 0, 4) . '***',
                    'description' => $rewardContent,
                    'spin_count' => $spinCount,
                    'reward_text' => 'Trúng ' . $rewardContent,
                    'time' => 'Vừa xong',
                ],
                'linked_item_id' => $linkedItemId,
                'linked_item_balance' => $linkedItemBalance,
                'won_item_balance' => $wonItemBalance,
                'reward_item_id' => $rewardItemId,
                'reward_unit' => $rewardItem->unit ?? null,
            ]);
        } catch (ValidationException $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first() ?? 'Dữ liệu quay không hợp lệ.',
            ], 422);
        } catch (WheelSpinException $e) {
            // Lỗi nghiệp vụ đã biết: trả nguyên thông báo để người chơi hiểu vì sao không quay được.
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            Log::warning('Không thể quay vòng quay', [
                'user_id' => Auth::id(),
                'slug' => $slug,
                'reason' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (Throwable $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            Log::error('Lỗi quay vòng quay', [
                'user_id' => Auth::id(),
                'slug' => $slug,
                'elapsed_ms' => round((hrtime(true) - $startedAt) / 1e6, 2),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Không thể quay lúc này. Vui lòng thử lại.',
            ], 500);
        }
    }

    // Tính toán phần thưởng dựa trên tỷ lệ
    private function calculateReward($config)
    {
        if (!is_array($config) || $config === []) {
            throw new WheelSpinException('Vòng quay chưa được cấu hình.');
        }

        $weights = array_map(static fn (array $reward): int => max(0, (int) round((float) ($reward['probability'] ?? 0) * 1000)), $config);
        $totalProbability = array_sum($weights);
        if ($totalProbability <= 0) {
            throw new WheelSpinException('Xác suất vòng quay chưa được cấu hình.');
        }

        $random = random_int(1, $totalProbability);
        $currentSum = 0;

        foreach ($config as $index => $reward) {
            $currentSum += $weights[$index];
            if ($random <= $currentSum) {
                return $index;
            }
        }

        // Mặc định trả về phần thưởng cuối cùng có tỉ lệ > 0 nếu số dư lẻ do làm tròn
        for ($index = count($weights) - 1; $index >= 0; $index--) {
            if ($weights[$index] > 0) {
                return $index;
            }
        }

        return 0;
    }

    /**
     * Danh sách reward_item_id xuất hiện trong config (giữ nguyên thứ tự ô trên vòng quay).
     */
    private function configItemIds(LuckyWheel $wheel): \Illuminate\Support\Collection
    {
        return collect($wheel->config ?? [])
            ->filter(static fn ($reward): bool => is_array($reward) && ($reward['reward_type'] ?? $reward['type'] ?? null) === 'item')
            ->pluck('reward_item_id')
            ->filter()
            ->map(static fn ($id): int => (int) $id)
            ->unique()
            ->values();
    }

    private function rewardItemsQuery(LuckyWheel $wheel, \Illuminate\Support\Collection $itemIdsInConfig)
    {
        return RewardItem::where('active', 1)
            ->where(function ($query) use ($wheel, $itemIdsInConfig) {
                $query->where('lucky_wheel_id', $wheel->id);
                if ($itemIdsInConfig->isNotEmpty()) {
                    $query->orWhereIn('id', $itemIdsInConfig);
                }
            });
    }

    /**
     * Xác định loại tài nguyên, vật phẩm liên kết, số dư hiện tại và đơn vị hiển thị ở khối "BẠN ĐANG CÓ".
     */
    private function resolveWheelInventory(LuckyWheel $wheel, ?\App\Models\User $user): array
    {
        $linkedItem = $this->resolveLinkedItemModel($wheel);

        if ($linkedItem) {
            $balance = $user ? $this->itemBalance((int) $user->id, $wheel->id, (int) $linkedItem->id) : 0;

            return [
                'type' => 'item',
                'linked_item' => $linkedItem,
                'linked_item_id' => (int) $linkedItem->id,
                'balance' => $balance,
                'unit' => $linkedItem->unit ?: 'VẬT PHẨM',
            ];
        }

        // Tìm loại tài nguyên chính từ cấu hình vòng quay nếu không có RewardItem
        $types = collect($wheel->config ?? [])
            ->map(static fn ($r): string => (string) ($r['reward_type'] ?? $r['type'] ?? 'empty'))
            ->filter(static fn ($t): bool => in_array($t, ['gold', 'gem', 'money'], true))
            ->values();

        $primaryType = $types->first() ?? 'gem';

        if ($primaryType === 'gold') {
            return [
                'type' => 'gold',
                'linked_item' => null,
                'linked_item_id' => null,
                'balance' => $user ? (int) ($user->gold ?? 0) : 0,
                'unit' => 'VÀNG',
            ];
        }

        if ($primaryType === 'money') {
            return [
                'type' => 'money',
                'linked_item' => null,
                'linked_item_id' => null,
                'balance' => $user ? (int) ($user->balance ?? 0) : 0,
                'unit' => 'VNĐ',
            ];
        }

        return [
            'type' => 'gem',
            'linked_item' => null,
            'linked_item_id' => null,
            'balance' => $user ? (int) ($user->gem ?? 0) : 0,
            'unit' => 'KIM CƯƠNG',
        ];
    }

    private function resolveLinkedItemModel(LuckyWheel $wheel): ?RewardItem
    {
        $itemIdsInConfig = $this->configItemIds($wheel);
        $rewardItems = $this->rewardItemsQuery($wheel, $itemIdsInConfig)
            ->get()
            ->keyBy('id');

        return $itemIdsInConfig->map(fn ($id) => $rewardItems->get($id))->filter()->first()
            ?? $rewardItems->first();
    }

    /**
     * Vật phẩm được hiển thị ở khối "BẠN ĐANG CÓ" trên trang chi tiết vòng quay.
     * Phải khớp với logic trong index() để số dư trả về sau khi quay đúng ô đang hiển thị.
     */
    private function linkedItemId(LuckyWheel $wheel): ?int
    {
        $linkedItem = $this->resolveLinkedItemModel($wheel);

        return $linkedItem ? (int) $linkedItem->id : null;
    }

    /**
     * Số dư vật phẩm = tổng đã trúng - tổng đã/đang rút.
     */
    private function itemBalance(int $userId, int $wheelId, int $rewardItemId): int
    {
        $won = (int) LuckyWheelHistory::where('user_id', $userId)
            ->where('lucky_wheel_id', $wheelId)
            ->where('reward_item_id', $rewardItemId)
            ->sum('reward_amount');

        $withdrawn = (int) \App\Models\WithdrawalHistory::where('user_id', $userId)
            ->where('reward_item_id', $rewardItemId)
            ->whereIn('status', ['processing', 'success'])
            ->sum('amount');

        return max(0, $won - $withdrawn);
    }

    private function rewardAmount(mixed $amount): int
    {
        if ($amount === null || $amount === '') {
            return 0;
        }

        if (preg_match('/^(\d+):(\d+)$/', (string) $amount, $matches)) {
            $min = (int) $matches[1];
            $max = (int) $matches[2];

            return random_int(min($min, $max), max($min, $max));
        }

        return max(0, (int) $amount);
    }
}
