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
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'tag_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'description' => 'required|string',
                'active' => 'boolean',
                'platform' => 'nullable|string|max:255',
                'game_group_id' => 'nullable|exists:game_groups,id',
                'is_flash_sale' => 'boolean',
                'flash_sale_old_price' => 'nullable|numeric|min:0',
                'flash_sale_new_price' => 'nullable|numeric|min:0',
                'flash_sale_end_time' => 'nullable|date',
                'custom_stock_count' => 'nullable|integer|min:0',
                'custom_sold_count' => 'nullable|integer|min:0',
            ]);

            DB::beginTransaction();

            $data = $request->all();
            $data['slug'] = Str::slug($request->name);
            $data['active'] = $request->boolean('active');
            $data['is_flash_sale'] = $request->has('is_flash_sale');
            $data['custom_stock_count'] = $request->filled('custom_stock_count') ? (int)$request->custom_stock_count : null;
            $data['custom_sold_count'] = $request->filled('custom_sold_count') ? (int)$request->custom_sold_count : null;

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
        } catch (\Throwable $e) {
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
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'remove_thumbnail' => 'nullable|boolean',
                'tag_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'remove_tag_image' => 'nullable|boolean',
                'description' => 'nullable|string',
                'active' => 'boolean',
                'platform' => 'nullable|string|max:255',
                'game_group_id' => 'nullable|exists:game_groups,id',
                'is_flash_sale' => 'boolean',
                'flash_sale_old_price' => 'nullable|numeric|min:0',
                'flash_sale_new_price' => 'nullable|numeric|min:0',
                'flash_sale_end_time' => 'nullable|date',
                'custom_stock_count' => 'nullable|integer|min:0',
                'custom_sold_count' => 'nullable|integer|min:0',
            ]);

            DB::beginTransaction();

            $data = $request->except(['thumbnail', 'remove_thumbnail', 'tag_image', 'remove_tag_image']);
            $data['slug'] = Str::slug($request->name);
            $data['active'] = $request->boolean('active');
            $data['is_flash_sale'] = $request->has('is_flash_sale');
            $data['custom_stock_count'] = $request->filled('custom_stock_count') ? (int)$request->custom_stock_count : null;
            $data['custom_sold_count'] = $request->filled('custom_sold_count') ? (int)$request->custom_sold_count : null;

            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($category->thumbnail) {
                    UploadHelper::deleteByUrl($category->thumbnail);
                }

                // Upload new thumbnail
                $data['thumbnail'] = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR);
            } elseif ($request->boolean('remove_thumbnail')) {
                if ($category->thumbnail) {
                    UploadHelper::deleteByUrl($category->thumbnail);
                }
                $data['thumbnail'] = null;
            }

            if ($request->hasFile('tag_image')) {
                // Delete old tag_image if exists
                if ($category->tag_image) {
                    UploadHelper::deleteByUrl($category->tag_image);
                }

                // Upload new tag_image
                $data['tag_image'] = UploadHelper::upload($request->file('tag_image'), self::UPLOAD_DIR);
            } elseif ($request->boolean('remove_tag_image')) {
                if ($category->tag_image) {
                    UploadHelper::deleteByUrl($category->tag_image);
                }
                $data['tag_image'] = null;
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
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating game category: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($category)
    {
        try {
            $category = $category instanceof GameCategory ? $category : GameCategory::findOrFail($category);
            DB::beginTransaction();

            // Xóa ảnh của các tài khoản game liên quan trước khi cascade delete
            $accounts = $category->accounts()->get(['id', 'thumb', 'images']);
            $imagesToDelete = [];
            foreach ($accounts as $account) {
                if ($account->thumb) {
                    $imagesToDelete[] = $account->thumb;
                }
                if ($account->images) {
                    $images = is_array($account->images) ? $account->images : (json_decode($account->images, true) ?: []);
                    foreach ($images as $img) {
                        if ($img) {
                            $imagesToDelete[] = $img;
                        }
                    }
                }
            }

            // Xóa các tài khoản game thuộc danh mục
            $category->accounts()->delete();

            // Xóa các liên kết flash sale nếu có
            \App\Models\FlashSaleItem::where('item_type', 'game')->where('item_id', $category->id)->delete();

            // Delete thumbnail if exists
            if ($category->thumbnail) {
                $imagesToDelete[] = $category->thumbnail;
            }

            if ($category->tag_image) {
                $imagesToDelete[] = $category->tag_image;
            }

            $category->delete();

            DB::commit();

            // Cleanup images outside transaction
            foreach (array_unique($imagesToDelete) as $imgUrl) {
                try {
                    UploadHelper::deleteByUrl($imgUrl);
                } catch (\Throwable $e) {
                    Log::warning('Failed to delete category/account image during category destroy: ' . $imgUrl);
                }
            }

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

    public function toggleActive(GameCategory $category)
    {
        $category->update(['active' => !$category->active]);
        cache()->forget('nav_categories');

        return back()->with('success', $category->active ? 'Đã hiện danh mục trên web.' : 'Đã ẩn danh mục khỏi web.');
    }
}
