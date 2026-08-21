<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LuckyWheel;
use App\Models\LuckyWheelHistory;
use App\Models\RandomCategoryAccount;
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
        $categories = LuckyWheel::where('active', 1)->get();

        foreach ($categories as $category) {
            // Tính số lượng đã quay
            $category->soldCount = $category->histories->count();
        }

        return view('user.wheel.show-all', compact('categories', 'title'));
    }

    // Hiển thị chi tiết vòng quay
    public function index($slug)
    {
        $wheel = LuckyWheel::where('slug', $slug)->where('active', 1)->firstOrFail();

        // Lấy lịch sử quay của người dùng hiện tại
        $history = [];

        if (Auth::check()) {
            $history = LuckyWheelHistory::with('user')->where('lucky_wheel_id', $wheel->id)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        return view('user.wheel.detail', compact('wheel', 'history'));
    }

    // Xử lý quay vòng quay
    public function spin(Request $request, $slug)
    {
        $startedAt = hrtime(true);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để có thể quay'
            ]);
        }
        // Validate dữ liệu đầu vào
        try {
            $request->validate([
                'spin_count' => 'required|integer|min:1|max:10',
            ]);

            $user = Auth::user();
            $wheel = LuckyWheel::where('slug', $slug)->where('active', 1)->firstOrFail();
            $spinCount = $request->input('spin_count');
            $totalCost = $wheel->price_per_spin * $spinCount;

            // Kiểm tra số dư
            if ($user->balance < $totalCost) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số dư không đủ để quay. Vui lòng nạp thêm tiền.'
                ]);
            }

            DB::beginTransaction();
            $user = $user->newQuery()->lockForUpdate()->findOrFail($user->id);

            if ($user->balance < $totalCost) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Số dư không đủ để quay. Vui lòng nạp thêm tiền.'
                ]);
            }

            // Lấy config từ wheel
            $config = $wheel->config;

            // Tính toán phần thưởng dựa trên tỷ lệ
            $rewardIndex = $this->calculateReward($config);
            $reward = $config[$rewardIndex];
            $rewardType = $reward['reward_type'] ?? $reward['type'] ?? 'empty';
            
            $rewardAmount = $this->rewardAmount($reward['amount'] ?? null);
            $totalRewardAmount = $rewardAmount * $spinCount;

            // Tạo kết quả phần thưởng
            $rewardResult = [
                'type' => $rewardType,
                'content' => $reward['content'],
                'amount' => $totalRewardAmount,
                'index' => $rewardIndex // Thêm index để frontend biết vị trí trúng
            ];

            // Lưu lịch sử với spin_count
            LuckyWheelHistory::create([
                'user_id' => $user->id,
                'lucky_wheel_id' => $wheel->id,
                'spin_count' => $spinCount,
                'total_cost' => $totalCost,
                'reward_type' => $rewardType,
                'reward_amount' => $totalRewardAmount,
                'description' => $reward['content'],
            ]);

            // Cộng thưởng vào tài khoản
            if ($rewardType === 'money') {
                $user->balance += $totalRewardAmount;
            } else if ($rewardType === 'gold') {
                $user->gold += $totalRewardAmount;
            } else if ($rewardType === 'item' || $rewardType === 'gem') {
                $user->gem += $totalRewardAmount;
            } else if ($rewardType === 'random_account') {
                $accounts = RandomCategoryAccount::where('status', 'available')
                    ->lockForUpdate()
                    ->limit($totalRewardAmount)
                    ->get();

                if ($accounts->count() < $totalRewardAmount) {
                    throw new \RuntimeException('Kho tài khoản thưởng không đủ.');
                }

                $batchId = uniqid('WHEEL-');
                foreach ($accounts as $account) {
                    $account->update([
                        'status' => 'sold',
                        'buyer_id' => $user->id,
                        'batch_id' => $batchId,
                    ]);
                }
            }

            // Trừ tiền từ tài khoản
            $user->balance -= $totalCost;
            $user->save();

            DB::table('money_transactions')->insert([
                'user_id' => $user->id,
                'type' => 'purchase',
                'amount' => -$totalCost,
                'balance_before' => $user->balance + $totalCost - ($rewardType === 'money' ? $totalRewardAmount : 0),
                'balance_after' => $user->balance,
                'description' => 'Quay ' . $wheel->name . ' x' . $spinCount . ' - ' . $reward['content'],
                'reference_id' => 'LW-' . $wheel->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            Log::info('Đo thời gian quay vòng quay', [
                'user_id' => $user->id,
                'slug' => $slug,
                'elapsed_ms' => round((hrtime(true) - $startedAt) / 1e6, 2),
            ]);

            return response()->json([
                'success' => true,
                'rewards' => [$rewardResult], // Vẫn giữ cấu trúc mảng để tương thích với frontend
                'new_balance' => $user->balance,
                'new_gold' => $user->gold ?? 0,
                'new_gem' => $user->gem ?? 0
            ]);
        } catch (ValidationException $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first() ?? 'Dữ liệu quay không hợp lệ.',
            ]); // Mã trạng thái HTTP 422: Unprocessable Entity
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
            throw new \RuntimeException('Vòng quay chưa được cấu hình.');
        }

        $weights = array_map(static fn (array $reward): int => (int) round((float) ($reward['probability'] ?? 0) * 1000), $config);
        $totalProbability = array_sum($weights);
        if ($totalProbability <= 0) {
            throw new \RuntimeException('Xác suất vòng quay không hợp lệ.');
        }

        $random = random_int(1, $totalProbability);
        $currentSum = 0;

        foreach ($config as $index => $reward) {
            $currentSum += $weights[$index];
            if ($random <= $currentSum) {
                return $index;
            }
        }

        // Mặc định trả về phần thưởng đầu tiên nếu có lỗi
        return 0;
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
