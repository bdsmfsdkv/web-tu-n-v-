<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameCategory;
use App\Helpers\UploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameCategoryController extends Controller
{
    /**
     * Đường dẫn thư mục lưu ảnh
     */
    private const UPLOAD_DIR = 'categories';

    public function index(\Illuminate\Http\Request $request)
    {
        $title = "Danh sách danh mục game";
        $query = GameCategory::orderBy('id', 'DESC');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
        }

        $perPage = $request->input('per_page', 10);
        $categories = $query->paginate($perPage)->withQueryString();

        return view('admin.categories.index', compact('title', 'categories'));
    }

    public function create()
    {
        $title = "Thêm danh mục game mới";
        $gameGroups = \App\Models\GameGroup::where('active', true)->get();
        return view('admin.categories.create', compact('title', 'gameGroups'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:game_categories,name',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif',
                'tag_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'description' => 'required|string',
                'active' => 'boolean',
                'platform' => 'nullable|string|max:255',
                'game_group_id' => 'nullable|exists:game_groups,id',
                'is_flash_sale' => 'boolean',
                'flash_sale_old_price' => 'nullable|numeric|min:0',
                'flash_sale_new_price' => 'nullable|numeric|min:0',
                'flash_sale_end_time' => 'nullable|date',
            ]);

            DB::beginTransaction();

            $data = $request->all();
            $data['slug'] = Str::slug($request->name);
            $data['active'] = $request->boolean('active');
            $data['is_flash_sale'] = $request->has('is_flash_sale');

            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR);
            }

            if ($request->hasFile('tag_image')) {
                $data['tag_image'] = UploadHelper::upload($request->file('tag_image'), self::UPLOAD_DIR);
            }

            GameCategory::create($data);

            DB::commit();

            return redirect()->route('admin.categories.index')
                ->with('success', 'Danh mục game đã được thêm thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating game category: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit(GameCategory $category)
    {
        $title = 'Chỉnh sửa danh mục game';
        $gameGroups = \App\Models\GameGroup::where('active', true)->get();
        return view('admin.categories.edit', compact('title', 'category', 'gameGroups'));
    }

    public function update(Request $request, GameCategory $category)
    {
        try {
            // Validate request data
            $request->validate([
                'name' => 'required|string|unique:game_categories,name,' . $category->id,
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'tag_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'description' => 'nullable|string',
                'active' => 'boolean',
                'platform' => 'nullable|string|max:255',
                'game_group_id' => 'nullable|exists:game_groups,id',
                'is_flash_sale' => 'boolean',
                'flash_sale_old_price' => 'nullable|numeric|min:0',
                'flash_sale_new_price' => 'nullable|numeric|min:0',
                'flash_sale_end_time' => 'nullable|date',
            ]);

            DB::beginTransaction();

            $data = $request->all();
            $data['slug'] = Str::slug($request->name);
            $data['active'] = $request->boolean('active');
            $data['is_flash_sale'] = $request->has('is_flash_sale');

            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($category->thumbnail) {
                    UploadHelper::deleteByUrl($category->thumbnail);
                }

                // Upload new thumbnail
                $data['thumbnail'] = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR);
            }

            if ($request->hasFile('tag_image')) {
                // Delete old tag_image if exists
                if ($category->tag_image) {
                    UploadHelper::deleteByUrl($category->tag_image);
                }

                // Upload new tag_image
                $data['tag_image'] = UploadHelper::upload($request->file('tag_image'), self::UPLOAD_DIR);
            }

            // Update category
            if (!$category->update($data)) {
                throw new \Exception('Không thể cập nhật danh mục');
            }

            DB::commit();

            return redirect()->route('admin.categories.index')
                ->with('success', 'Cập nhật danh mục thành công!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating game category: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(GameCategory $category)
    {
        try {
            DB::beginTransaction();

            // Delete thumbnail if exists
            if ($category->thumbnail) {
                UploadHelper::deleteByUrl($category->thumbnail);
            }

            if ($category->tag_image) {
                UploadHelper::deleteByUrl($category->tag_image);
            }

            $category->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Xóa danh mục thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting game category: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa danh mục: ' . $e->getMessage()
            ], 500);
        }
    }
}
