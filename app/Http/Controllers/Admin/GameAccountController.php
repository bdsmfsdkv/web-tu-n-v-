<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\GameAccount;
use App\Models\GameCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\UploadHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameAccountController extends Controller
{
    /**
     * Đường dẫn thư mục lưu ảnh
     */
    private const UPLOAD_DIR = 'accounts';

    public function index(\Illuminate\Http\Request $request)
    {
        $title = 'Danh sách tài khoản game';
        $query = GameAccount::with(['category', 'buyer'])->orderBy('id', "DESC");

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('account_name', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('buyer', function($q) use ($search) {
                      $q->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $perPage = $request->input('per_page', 10);
        $accounts = $query->paginate($perPage)->withQueryString();

        return view('admin.accounts.index', compact('title', 'accounts'));
    }

    public function create()
    {
        $title = 'Thêm tài khoản game mới';
        $categories = GameCategory::with('gameGroup')->where('active', true)->get();
        $gamePresets = config('game_attributes.games', []);
        return view('admin.accounts.create', compact('title', 'categories', 'gamePresets'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'game_category_id' => 'required|exists:game_categories,id',
                'account_name' => 'required|string|max:255',
                'password' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'note' => 'nullable|string',
                'details' => 'nullable|array',
                'thumb' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'status' => 'required|in:available,sold'
            ]);

            DB::beginTransaction();

            $data = $request->except(['thumb', 'images']);

            // Store thumbnail
            if ($request->hasFile('thumb')) {
                $data['thumb'] = UploadHelper::upload($request->file('thumb'), self::UPLOAD_DIR . '/thumbnails');
            }

            // Store multiple images
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $path = UploadHelper::upload($image, self::UPLOAD_DIR . '/images');
                    $imagePaths[] = $path;
                }
                $data['images'] = json_encode($imagePaths);
            }

            GameAccount::create($data);

            DB::commit();

            return redirect()->route('admin.accounts.index')
                ->with('success', 'Tài khoản game đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating game account: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit(GameAccount $account)
    {
        $title = 'Chỉnh sửa tài khoản game';
        $categories = GameCategory::with('gameGroup')->where('active', true)->get();
        $gamePresets = config('game_attributes.games', []);
        return view('admin.accounts.edit', compact('title', 'account', 'categories', 'gamePresets'));
    }

    public function update(Request $request, GameAccount $account)
    {
        try {
            $request->validate([
                'game_category_id' => 'required|exists:game_categories,id',
                'account_name' => 'required|string|max:255',
                'password' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'note' => 'nullable|string',
                'details' => 'nullable|array',
                'thumb' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'remove_thumb' => 'nullable|boolean',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'removed_images' => 'nullable|array',
                'removed_images.*' => 'nullable|string'
            ]);

            DB::beginTransaction();

            $data = $request->except(['thumb', 'remove_thumb', 'images', 'removed_images']);

            if ($request->hasFile('thumb')) {
                // Delete old thumbnail only when a replacement thumbnail is uploaded.
                if ($account->thumb) {
                    UploadHelper::deleteByUrl($account->thumb);
                }
                $data['thumb'] = UploadHelper::upload($request->file('thumb'), self::UPLOAD_DIR . '/thumbnails');
            } elseif ($request->boolean('remove_thumb')) {
                if ($account->thumb) {
                    UploadHelper::deleteByUrl($account->thumb);
                }
                $data['thumb'] = null;
            }

            // Keep current detail images by default. Only images explicitly marked with X are removed.
            $existingImages = is_array($account->images) ? $account->images : (json_decode($account->images, true) ?: []);
            $removedImages = array_values(array_unique($request->input('removed_images', [])));

            $remainingImages = array_values(array_filter($existingImages, function ($image) use ($removedImages) {
                return !in_array($image, $removedImages, true);
            }));

            // Physically delete only paths that actually belong to this account.
            foreach ($removedImages as $image) {
                if (in_array($image, $existingImages, true)) {
                    UploadHelper::deleteByUrl($image);
                }
            }

            // New uploads are appended to the images that were kept instead of replacing all old images.
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = UploadHelper::upload($image, self::UPLOAD_DIR . '/images');
                    $remainingImages[] = $path;
                }
            }

            if (!empty($removedImages) || $request->hasFile('images')) {
                $data['images'] = json_encode(array_values($remainingImages));
            }

            $account->update($data);

            DB::commit();

            return redirect()->route('admin.accounts.index')
                ->with('success', 'Tài khoản game đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating game account: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(GameAccount $account)
    {
        try {
            DB::beginTransaction();

            // Delete thumbnail if exists
            if ($account->thumb) {
                UploadHelper::deleteByUrl($account->thumb);
            }

            // Delete additional images if exists
            if ($account->images) {
                $images = is_array($account->images) ? $account->images : (json_decode($account->images, true) ?: []);
                foreach ($images as $image) {
                    UploadHelper::deleteByUrl($image);
                }
            }

            // Delete the account record
            $account->delete();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting game account: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa tài khoản game: ' . $e->getMessage()
            ]);
        }
    }
}
