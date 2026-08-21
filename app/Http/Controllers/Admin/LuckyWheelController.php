<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LuckyWheel;
use App\Models\LuckyWheelHistory;
use App\Helpers\UploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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

        $rewardItems = \App\Models\RewardItem::where('active', 1)->orderBy('priority', 'asc')->get();

        $defaultConfig = [
            ['content' => '19999 Kim Cương', 'probability' => 0.5, 'trial_probability' => 1.5, 'reward_type' => 'item', 'reward_item_id' => '', 'amount' => '19999'],
            ['content' => '999 Kim Cương', 'probability' => 15, 'trial_probability' => 20, 'reward_type' => 'item', 'reward_item_id' => '', 'amount' => '999'],
            ['content' => '15555 Kim Cương', 'probability' => 0.5, 'trial_probability' => 1.5, 'reward_type' => 'item', 'reward_item_id' => '', 'amount' => '15555'],
            ['content' => '19 Kim Cương', 'probability' => 29, 'trial_probability' => 20, 'reward_type' => 'item', 'reward_item_id' => '', 'amount' => '19'],
            ['content' => '9999 Kim Cương', 'probability' => 1, 'trial_probability' => 5, 'reward_type' => 'item', 'reward_item_id' => '', 'amount' => '9999'],
            ['content' => 'Mất lượt', 'probability' => 30, 'trial_probability' => 10, 'reward_type' => 'empty', 'reward_item_id' => '', 'amount' => ''],
            ['content' => '20000 VNĐ', 'probability' => 4, 'trial_probability' => 20, 'reward_type' => 'money', 'reward_item_id' => '', 'amount' => '20000'],
            ['content' => 'Nick VIP', 'probability' => 20, 'trial_probability' => 22, 'reward_type' => 'random_account', 'reward_item_id' => '', 'amount' => '1']
        ];

        return view('admin.lucky-wheels.create', compact('title', 'rewardItems', 'defaultConfig'));
    }

    /**
     * Lưu vòng quay may mắn mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_spin' => 'required|numeric|min:1000',
            'thumbnail' => 'nullable|image',
            'wheel_image' => 'nullable|image',
            'description' => 'nullable|string',
            'rules' => 'nullable|string',
            'active' => 'nullable|boolean',
            'config' => 'required|array|size:8',
            'config.*.reward_type' => 'required|in:item,empty,money,random_account',
            'config.*.content' => 'required|string|max:255',
            'config.*.amount' => 'nullable|string|max:255',
            'config.*.reward_item_id' => 'nullable|exists:reward_items,id',
            'config.*.probability' => 'required|numeric|min:0|max:100',
            'config.*.trial_probability' => 'nullable|numeric|min:0|max:100',
        ]);

        try {

            $totalProbability = 0;
            foreach ($request->config as $item) {
                $totalProbability += $item['probability'];
            }

            if ($totalProbability != 100) {
                return back()->withInput()->withErrors(['config' => 'Tổng xác suất phải bằng 100%']);
            }

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

            $luckyWheel->description = $request->description;
            $luckyWheel->rules = $request->rules;
            $luckyWheel->active = $request->boolean('active');
            $luckyWheel->config = $request->config;
            $luckyWheel->save();

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

        $config = is_array($luckyWheel->config) ? $luckyWheel->config : [];
        if (count($config) < 8) {
            for ($i = count($config); $i < 8; $i++) {
                $config[] = [
                    'reward_item_id' => null,
                    'probability' => 0
                ];
            }
        }

        $rewardItems = \App\Models\RewardItem::where('active', 1)->orderBy('priority', 'asc')->get();

        return view('admin.lucky-wheels.edit', compact('luckyWheel', 'title', 'config', 'rewardItems'));
    }

    /**
     * Cập nhật vòng quay may mắn
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_spin' => 'required|numeric|min:1000',
            'thumbnail' => 'nullable|image',
            'remove_thumbnail' => 'nullable|boolean',
            'wheel_image' => 'nullable|image',
            'remove_wheel_image' => 'nullable|boolean',
            'description' => 'nullable|string',
            'rules' => 'nullable|string',
            'active' => 'nullable|boolean',
            'config' => 'required|array|size:8',
            'config.*.reward_type' => 'required|in:item,empty,money,random_account',
            'config.*.content' => 'required|string|max:255',
            'config.*.amount' => 'nullable|string|max:255',
            'config.*.reward_item_id' => 'nullable|exists:reward_items,id',
            'config.*.probability' => 'required|numeric|min:0|max:100',
            'config.*.trial_probability' => 'nullable|numeric|min:0|max:100',
        ]);

        try {

            $totalProbability = 0;
            foreach ($request->config as $item) {
                $totalProbability += $item['probability'];
            }

            if ($totalProbability != 100) {
                return back()->withInput()->withErrors(['config' => 'Tổng xác suất phải bằng 100%']);
            }

            DB::beginTransaction();

            $luckyWheel = LuckyWheel::findOrFail($id);
            $luckyWheel->name = $request->name;
            $luckyWheel->slug = Str::slug($request->name);
            $luckyWheel->price_per_spin = $request->price_per_spin;

            // Xử lý upload ảnh đại diện nếu có
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($luckyWheel->thumbnail) {
                    UploadHelper::deleteByUrl($luckyWheel->thumbnail);
                }
                $luckyWheel->thumbnail = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR . '/thumbnails');
            } elseif ($request->boolean('remove_thumbnail')) {
                if ($luckyWheel->thumbnail) {
                    UploadHelper::deleteByUrl($luckyWheel->thumbnail);
                }
                $luckyWheel->thumbnail = null;
            }

            // Xử lý upload ảnh vòng quay nếu có
            if ($request->hasFile('wheel_image')) {
                // Delete old wheel image if exists
                if ($luckyWheel->wheel_image) {
                    UploadHelper::deleteByUrl($luckyWheel->wheel_image);
                }
                $luckyWheel->wheel_image = UploadHelper::upload($request->file('wheel_image'), self::UPLOAD_DIR . '/wheel-images');
            } elseif ($request->boolean('remove_wheel_image')) {
                if ($luckyWheel->wheel_image) {
                    UploadHelper::deleteByUrl($luckyWheel->wheel_image);
                }
                $luckyWheel->wheel_image = null;
            }

            $luckyWheel->description = $request->description;
            $luckyWheel->rules = $request->rules;
            $luckyWheel->active = $request->boolean('active');
            $luckyWheel->config = $request->config;
            $luckyWheel->save();

            DB::commit();

            return redirect()->route('admin.lucky-wheels.index')
                ->with('success', 'Cập nhật vòng quay may mắn thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()->withInput()->withErrors(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
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
}