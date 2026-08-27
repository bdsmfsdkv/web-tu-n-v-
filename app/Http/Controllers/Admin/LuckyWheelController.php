<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LuckyWheel;
use App\Models\LuckyWheelHistory;
use App\Models\RewardItem;
use App\Helpers\UploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class LuckyWheelController extends Controller
{
    /**
     * Đường dẫn thư mục lưu ảnh
     */
    private const UPLOAD_DIR = 'lucky-wheels';

    /**
     * Hiển thị danh sách vòng quay may mắn
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $title = 'Quản lý vòng quay may mắn';
        $luckyWheels = LuckyWheel::orderBy('created_at', 'desc')->get();
        return view('admin.lucky-wheels.index', compact('luckyWheels', 'title'));
    }

    /**
     * Hiển thị form tạo mới vòng quay may mắn
     */
    public function create()
    {
        $title = 'Thêm vòng quay may mắn';
        $rewardItems = RewardItem::where('active', 1)->orderBy('game_name')->orderBy('priority')->get();

        return view('admin.lucky-wheels.create', compact('title', 'rewardItems'));
    }

    /**
     * Lưu vòng quay may mắn mới
     */
    public function store(Request $request)
    {
        $this->logUploadErrors($request);

        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_spin' => 'required|numeric|min:1000',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
            'wheel_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
            'pointer_image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'rules' => 'nullable|string',
            'active' => 'nullable|boolean',
            'config' => 'required|array|size:8',
            'config.*.reward_type' => 'required|in:gem,gold,item,empty,money,random_account',
            'config.*.active' => 'nullable|boolean',
            'config.*.content' => 'required|string|max:255',
            'config.*.amount' => ['nullable', 'regex:/^\d+(?::\d+)?$/'],
            'config.*.reward_item_id' => ['nullable', 'integer', 'exists:reward_items,id'],
            'config.*.probability' => 'required|numeric|min:0|max:100',
            'config.*.trial_probability' => 'required|numeric|min:0|max:100',
        ]);

        $config = $this->validatedConfig($request);

        try {
            DB::beginTransaction();

            $luckyWheel = new LuckyWheel();
            $luckyWheel->name = $request->name;
            $luckyWheel->slug = Str::slug($request->name);
            $luckyWheel->price_per_spin = $request->price_per_spin;

            // Xử lý upload ảnh đại diện
            if ($request->hasFile('thumbnail')) {
                $luckyWheel->thumbnail = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR . '/thumbnails');
            } else {
                $luckyWheel->thumbnail = '';
            }

            // Xử lý upload ảnh vòng quay
            if ($request->hasFile('wheel_image')) {
                $luckyWheel->wheel_image = UploadHelper::upload($request->file('wheel_image'), self::UPLOAD_DIR . '/wheel-images');
            } else {
                $luckyWheel->wheel_image = '';
            }

            if ($request->hasFile('pointer_image')) {
                $luckyWheel->pointer_image = UploadHelper::upload($request->file('pointer_image'), self::UPLOAD_DIR . '/pointers');
            }

            $luckyWheel->description = $request->description;
            $luckyWheel->rules = $request->rules;
            $luckyWheel->active = $request->boolean('active');
            $luckyWheel->config = $config;
            $luckyWheel->save();

            $rewardItemIds = collect($config)->pluck('reward_item_id')->filter()->unique();
            if ($rewardItemIds->isNotEmpty()) {
                RewardItem::whereIn('id', $rewardItemIds)
                    ->update(['lucky_wheel_id' => $luckyWheel->id]);
            }

            DB::commit();

            return redirect()->route('admin.lucky-wheels.index')
                ->with('success', 'Tạo vòng quay may mắn thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()->withInput()->withErrors(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    /**
     * Hiển thị form chỉnh sửa vòng quay may mắn
     */
    public function edit(LuckyWheel $luckyWheel)
    {
        $title = 'Chỉnh sửa vòng quay may mắn';

        $config = array_map(static function (array $reward): array {
            $reward['reward_type'] = $reward['reward_type'] ?? $reward['type'] ?? 'empty';
            $reward['active'] = array_key_exists('active', $reward) ? (bool) $reward['active'] : true;
            $reward['trial_probability'] = $reward['trial_probability'] ?? $reward['probability'] ?? 0;
            $reward['reward_item_id'] = $reward['reward_item_id'] ?? null;

            return $reward;
        }, is_array($luckyWheel->config) ? $luckyWheel->config : []);
        if (count($config) < 8) {
            for ($i = count($config); $i < 8; $i++) {
                $config[] = [
                    'content' => '',
                    'reward_type' => 'empty',
                    'active' => true,
                    'reward_item_id' => null,
                    'amount' => null,
                    'probability' => 0,
                    'trial_probability' => 0,
                ];
            }
        }
        $config = old('config', $config);

        $rewardItems = RewardItem::where('active', 1)
            ->orderBy('game_name')
            ->orderBy('priority')
            ->get();

        return view('admin.lucky-wheels.edit', compact('luckyWheel', 'title', 'config', 'rewardItems'));
    }

    /**
     * Cập nhật vòng quay may mắn
     */
    public function update(Request $request, $id)
    {
        $this->logUploadErrors($request);

        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_spin' => 'required|numeric|min:1000',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
            'remove_thumbnail' => 'nullable|boolean',
            'wheel_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
            'remove_wheel_image' => 'nullable|boolean',
            'pointer_image' => 'nullable|image|max:2048',
            'remove_pointer_image' => 'nullable|boolean',
            'description' => 'nullable|string',
            'rules' => 'nullable|string',
            'active' => 'nullable|boolean',
            'config' => 'required|array|size:8',
            'config.*.reward_type' => 'required|in:gem,gold,item,empty,money,random_account',
            'config.*.active' => 'nullable|boolean',
            'config.*.content' => 'required|string|max:255',
            'config.*.amount' => ['nullable', 'regex:/^\d+(?::\d+)?$/'],
            'config.*.reward_item_id' => ['nullable', 'integer', 'exists:reward_items,id'],
            'config.*.probability' => 'required|numeric|min:0|max:100',
            'config.*.trial_probability' => 'required|numeric|min:0|max:100',
        ]);

        $config = $this->validatedConfig($request);

        try {
            DB::beginTransaction();

            $luckyWheel = LuckyWheel::findOrFail($id);
            $luckyWheel->name = $request->name;
            $luckyWheel->slug = Str::slug($request->name);
            $luckyWheel->price_per_spin = $request->price_per_spin;

            // Xử lý upload ảnh đại diện nếu có
            if ($request->hasFile('thumbnail')) {
                $oldThumbnail = $luckyWheel->thumbnail;
                $luckyWheel->thumbnail = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR . '/thumbnails');
                if ($oldThumbnail) {
                    UploadHelper::deleteByUrl($oldThumbnail);
                }
            } elseif ($request->boolean('remove_thumbnail')) {
                if ($luckyWheel->thumbnail) {
                    UploadHelper::deleteByUrl($luckyWheel->thumbnail);
                }
                $luckyWheel->thumbnail = null;
            }

            // Xử lý upload ảnh vòng quay nếu có
            if ($request->hasFile('wheel_image')) {
                $oldWheelImage = $luckyWheel->wheel_image;
                $luckyWheel->wheel_image = UploadHelper::upload($request->file('wheel_image'), self::UPLOAD_DIR . '/wheel-images');
                if ($oldWheelImage) {
                    UploadHelper::deleteByUrl($oldWheelImage);
                }
            } elseif ($request->boolean('remove_wheel_image')) {
                if ($luckyWheel->wheel_image) {
                    UploadHelper::deleteByUrl($luckyWheel->wheel_image);
                }
                $luckyWheel->wheel_image = null;
            }

            if ($request->hasFile('pointer_image')) {
                $oldPointerImage = $luckyWheel->pointer_image;
                $luckyWheel->pointer_image = UploadHelper::upload($request->file('pointer_image'), self::UPLOAD_DIR . '/pointers');
                if ($oldPointerImage) {
                    UploadHelper::deleteByUrl($oldPointerImage);
                }
            } elseif ($request->boolean('remove_pointer_image')) {
                if ($luckyWheel->pointer_image) {
                    UploadHelper::deleteByUrl($luckyWheel->pointer_image);
                }
                $luckyWheel->pointer_image = null;
            }

            $luckyWheel->description = $request->description;
            $luckyWheel->rules = $request->rules;
            $luckyWheel->active = $request->boolean('active');
            $luckyWheel->config = $config;
            $luckyWheel->save();

            $rewardItemIds = collect($config)->pluck('reward_item_id')->filter()->unique();
            $availableItems = RewardItem::whereIn('id', $rewardItemIds)->pluck('id');

            if ($availableItems->count() !== $rewardItemIds->count()) {
                throw ValidationException::withMessages([
                    'config' => 'Có vật phẩm không tồn tại.',
                ]);
            }

            RewardItem::where('lucky_wheel_id', $luckyWheel->id)
                ->when($rewardItemIds->isNotEmpty(), fn ($query) => $query->whereNotIn('id', $rewardItemIds))
                ->update(['lucky_wheel_id' => null]);

            if ($rewardItemIds->isNotEmpty()) {
                RewardItem::whereIn('id', $rewardItemIds)
                    ->update(['lucky_wheel_id' => $luckyWheel->id]);
            }

            DB::commit();

            return redirect()->route('admin.lucky-wheels.index')
                ->with('success', 'Cập nhật vòng quay may mắn thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()->withInput()->withErrors(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    private function validatedConfig(Request $request): array
    {
        $config = $request->input('config');
        $activeConfig = array_filter($config, static fn (array $reward): bool => !array_key_exists('active', $reward) || (bool) $reward['active']);
        $totalProbability = array_sum(array_column($activeConfig, 'probability'));
        $totalTrialProbability = array_sum(array_column($activeConfig, 'trial_probability'));

        if (abs($totalProbability - 100) > 0.001) {
            throw ValidationException::withMessages(['config' => 'Tổng tỉ lệ trúng phải bằng 100%.']);
        }

        if (abs($totalTrialProbability - 100) > 0.001) {
            throw ValidationException::withMessages(['config' => 'Tổng tỉ lệ quay thử phải bằng 100%.']);
        }

        foreach ($config as $index => $reward) {
            $isActive = !array_key_exists('active', $reward) || (bool) $reward['active'];
            if ($isActive && $reward['reward_type'] !== 'empty' && empty($reward['amount'])) {
                throw ValidationException::withMessages([
                    "config.$index.amount" => 'Phần thưởng #' . ($index + 1) . ' phải có số lượng nhận.',
                ]);
            }

            if ($isActive && $reward['reward_type'] === 'item' && ($reward['reward_item_id'] === null || $reward['reward_item_id'] === '')) {
                throw ValidationException::withMessages([
                    "config.$index.reward_item_id" => 'Phần thưởng #' . ($index + 1) . ' phải chọn vật phẩm liên kết.',
                ]);
            }
        }

        return array_map(static function (array $reward): array {
            $reward['active'] = array_key_exists('active', $reward) ? (bool) $reward['active'] : true;
            $reward['probability'] = (float) $reward['probability'];
            $reward['trial_probability'] = (float) $reward['trial_probability'];
            $reward['reward_item_id'] = $reward['reward_type'] === 'item' && ($reward['reward_item_id'] !== null && $reward['reward_item_id'] !== '')
                ? (int) $reward['reward_item_id']
                : null;
            $reward['amount'] = $reward['amount'] ?: null;

            return $reward;
        }, $config);
    }

    private function logUploadErrors(Request $request): void
    {
        foreach (['thumbnail', 'wheel_image', 'pointer_image'] as $field) {
            $file = $request->file($field);
            if ($file && !$file->isValid()) {
                Log::warning('Lucky wheel upload failed before validation.', [
                    'field' => $field,
                    'error_code' => $file->getError(),
                    'error_message' => $file->getErrorMessage(),
                    'client_name' => $file->getClientOriginalName(),
                    'client_size' => $file->getSize(),
                ]);
            }
        }
    }

    /**
     * Xóa vòng quay may mắn
     */
    public function destroy(LuckyWheel $luckyWheel)
    {
        try {
            DB::beginTransaction();

            // Delete images if exists
            if ($luckyWheel->thumbnail) {
                UploadHelper::deleteByUrl($luckyWheel->thumbnail);
            }
            if ($luckyWheel->wheel_image) {
                UploadHelper::deleteByUrl($luckyWheel->wheel_image);
            }
            if ($luckyWheel->pointer_image) {
                UploadHelper::deleteByUrl($luckyWheel->pointer_image);
            }

            // Delete lucky wheel
            $luckyWheel->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Xóa vòng quay may mắn thành công'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting lucky wheel: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Hiển thị lịch sử vòng quay
     */
    public function history()
    {
        $title = 'Lịch sử vòng quay may mắn';
        $history = LuckyWheelHistory::with(['user', 'luckyWheel'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.lucky-wheels.history', compact('title', 'history'));
    }

    public function toggleActive(LuckyWheel $luckyWheel)
    {
        $luckyWheel->update(['active' => !$luckyWheel->active]);
        cache()->forget('nav_lucky_wheels');

        return back()->with('success', $luckyWheel->active ? 'Đã hiện vòng quay trên web.' : 'Đã ẩn vòng quay khỏi web.');
    }
}
