<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RandomCategoryAccount;
use App\Models\RandomCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\UploadHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RandomCategoryAccountController extends Controller
{
    /**
     * Đường dẫn thư mục lưu ảnh
     */
    private const UPLOAD_DIR = 'random-accounts';

    public function index(\Illuminate\Http\Request $request)
    {
        $title = 'Danh sách tài khoản random';
        $query = RandomCategoryAccount::with(['category', 'buyer'])->orderBy('id', "DESC");

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('account_name', 'like', "%{$search}%")
                  ->orWhere('server', 'like', "%{$search}%")
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

        return view('admin.random-accounts.index', compact('title', 'accounts'));
    }

    public function create()
    {
        $title = 'Thêm tài khoản random mới';
        $categories = RandomCategory::where('active', true)->get();
        return view('admin.random-accounts.create', compact('title', 'categories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'random_category_id' => 'required|exists:random_categories,id',
                'accounts' => 'required|string',
                'price' => 'required|numeric|min:0',
                'min_spent' => 'nullable|numeric|min:0',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'note' => 'nullable|string',
                'note_buyer' => 'nullable|string',
            ]);

            DB::beginTransaction();

            $data = $request->all();
            $accounts = explode("\n", trim($data['accounts']));
            $createdAccounts = [];
            $thumbnailPath = null;

            // Xử lý upload ảnh
            if ($request->hasFile('thumbnail')) {
                try {
                    $file = $request->file('thumbnail');

                    // Kiểm tra kích thước file
                    if ($file->getSize() > 2048 * 1024) { // 2MB
                        throw new \Exception('Kích thước ảnh không được vượt quá 2MB');
                    }

                    // Upload file
                    $thumbnailPath = UploadHelper::upload($file, self::UPLOAD_DIR);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Lỗi khi upload ảnh: ' . $e->getMessage());
                }
            }

            // Tạo các tài khoản
            foreach ($accounts as $accountLine) {
                $accountLine = trim($accountLine);
                if (empty($accountLine))
                    continue;

                $parts = explode('|', $accountLine);
                $accountName = trim($parts[0] ?? '');
                $password = isset($parts[1]) ? trim($parts[1]) : null;

                $accountData = [
                    'random_category_id' => $data['random_category_id'],
                    'account_name' => $accountName,
                    'password' => $password,
                    'server' => 1, // Default value since it was removed from UI
                    'price' => $data['price'],
                    'min_spent' => $data['min_spent'] ?? 0,
                    'status' => 'available',
                    'note' => $data['note'] ?? null,
                    'note_buyer' => $data['note_buyer'] ?? null,
                    'thumbnail' => $thumbnailPath,
                ];

                $createdAccounts[] = RandomCategoryAccount::create($accountData);
            }

            if (empty($createdAccounts)) {
                // Nếu không có tài khoản nào được tạo, xóa ảnh đã upload
                if ($thumbnailPath) {
                    UploadHelper::deleteByUrl($thumbnailPath);
                }
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Không có tài khoản hợp lệ nào được tạo!');
            }

            DB::commit();

            return redirect()->route('admin.random-accounts.index')
                ->with('success', count($createdAccounts) . ' tài khoản random đã được thêm thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating random accounts: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit(RandomCategoryAccount $account)
    {
        $title = 'Chỉnh sửa tài khoản random';
        $categories = RandomCategory::where('active', true)->get();
        return view('admin.random-accounts.edit', compact('title', 'account', 'categories'));
    }

    public function update(Request $request, RandomCategoryAccount $account)
    {
        try {
            $request->validate([
                'random_category_id' => 'required|exists:random_categories,id',
                'account_name' => 'nullable|string|max:100',
                'password' => 'nullable|string|max:100',
                'price' => 'required|numeric|min:0',
                'min_spent' => 'nullable|numeric|min:0',
                'note' => 'nullable|string',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'remove_thumbnail' => 'nullable|boolean',
            ]);

            DB::beginTransaction();

            $data = $request->except(['thumbnail', 'remove_thumbnail']);
            $data['min_spent'] = $request->input('min_spent', 0);

            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($account->thumbnail) {
                    UploadHelper::deleteByUrl($account->thumbnail);
                }

                // Upload new thumbnail
                $data['thumbnail'] = UploadHelper::upload($request->file('thumbnail'), self::UPLOAD_DIR);
            } elseif ($request->boolean('remove_thumbnail')) {
                if ($account->thumbnail) {
                    UploadHelper::deleteByUrl($account->thumbnail);
                }
                $data['thumbnail'] = null;
            }

            $account->update($data);

            DB::commit();

            return redirect()->route('admin.random-accounts.index')
                ->with('success', 'Tài khoản random đã được cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating random account: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(RandomCategoryAccount $account)
    {
        try {
            DB::beginTransaction();

            // Delete thumbnail if exists
            if ($account->thumbnail) {
                UploadHelper::deleteByUrl($account->thumbnail);
            }

            $account->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tài khoản random đã được xóa thành công!'
                ]);
            }

            return redirect()->route('admin.random-accounts.index')
                ->with('success', 'Tài khoản random đã được xóa thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting random account: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa tài khoản random. Lỗi: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->route('admin.random-accounts.index')
                ->with('error', 'Không thể xóa tài khoản random. Lỗi: ' . $e->getMessage());
        }
    }
}
