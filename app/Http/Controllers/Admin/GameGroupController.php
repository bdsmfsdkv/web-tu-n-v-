<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameGroup;
use App\Helpers\UploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameGroupController extends Controller
{
    private const UPLOAD_DIR = 'game-groups';

    public function index(\Illuminate\Http\Request $request)
    {
        $title = "Danh sách danh mục mẹ";
        $groups = GameGroup::orderBy('order', 'ASC')->orderBy('id', 'DESC')->adminFilter(request())->paginate(request("per_page", 25))->withQueryString();
        return view('admin.game-groups.index', compact('title', 'groups'));
    }

    public function create()
    {
        $title = "Thêm danh mục mẹ mới";
        return view('admin.game-groups.create', compact('title'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:game_groups,name',
                'order' => 'nullable|integer|min:0|unique:game_groups,order',
                'active' => 'boolean',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ], [
                'order.unique' => 'Thứ tự hiển thị này đã tồn tại, vui lòng chọn số khác.',
            ]);

            DB::beginTransaction();

            $data = $request->all();
            $data['slug'] = Str::slug($request->name);
            $data['active'] = $request->boolean('active');
            
            if (!isset($data['order']) || $data['order'] === '' || $data['order'] === null) {
                $maxOrder = GameGroup::max('order') ?? 0;
                $data['order'] = $maxOrder + 1;
            }

            // Không để UploadedFile/null từ $request->all() lọt vào mass assignment
            unset($data['thumbnail']);

            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR);
            }

            GameGroup::create($data);

            DB::commit();

            return redirect()->route('admin.game-groups.index')
                ->with('success', 'Danh mục mẹ đã được thêm thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating game group: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit(GameGroup $gameGroup)
    {
        $title = 'Chỉnh sửa danh mục mẹ';
        return view('admin.game-groups.edit', compact('title', 'gameGroup'));
    }

    public function update(Request $request, GameGroup $gameGroup)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:game_groups,name,' . $gameGroup->id,
                'order' => 'nullable|integer|min:0|unique:game_groups,order,' . $gameGroup->id,
                'active' => 'boolean',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'remove_thumbnail' => 'nullable|boolean',
            ], [
                'order.unique' => 'Thứ tự hiển thị này đã tồn tại, vui lòng chọn số khác.',
            ]);

            DB::beginTransaction();

            $data = $request->except(['thumbnail', 'remove_thumbnail']);
            $data['slug'] = Str::slug($request->name);
            $data['active'] = $request->boolean('active');
            
            if (!isset($data['order']) || $data['order'] === '' || $data['order'] === null) {
                $data['order'] = $gameGroup->order;
            }

            if ($request->hasFile('thumbnail')) {
                if ($gameGroup->thumbnail) {
                    UploadHelper::deleteByUrl($gameGroup->thumbnail);
                }

                $data['thumbnail'] = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR);
            } elseif ($request->boolean('remove_thumbnail')) {
                if ($gameGroup->thumbnail) {
                    UploadHelper::deleteByUrl($gameGroup->thumbnail);
                }
                $data['thumbnail'] = null;
            }

            $gameGroup->update($data);

            DB::commit();

            return redirect()->route('admin.game-groups.index')
                ->with('success', 'Cập nhật danh mục mẹ thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating game group: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(GameGroup $gameGroup)
    {
        try {
            DB::beginTransaction();

            if ($gameGroup->thumbnail) {
                UploadHelper::deleteByUrl($gameGroup->thumbnail);
            }

            $gameGroup->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Xóa danh mục mẹ thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting game group: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa: ' . $e->getMessage()
            ], 500);
        }
    }
}
