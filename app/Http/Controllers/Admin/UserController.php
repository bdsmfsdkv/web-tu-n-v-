<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MoneyTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Danh sách user
    public function index(Request $request)
    {
        $title = 'Danh sách người dùng';
        
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $perPage = $request->input('per_page', 20);
        $users = $query->orderBy('id', 'DESC')->paginate($perPage);
        
        return view('admin.users.index', compact('title', 'users'));
    }

    public function edit($id)
    {
        $title = 'Sửa người dùng #' . $id;
        $user = User::findOrFail($id);
        $transactions = MoneyTransaction::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.edit', compact('title', 'user', 'transactions'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $oldBalance = $user->balance;

            $validated = $request->validate([
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|min:8|confirmed',
                'role' => 'required|in:member,admin',
                'balance' => 'required|numeric|min:0',
                'banned' => 'required|in:0,1'
            ], [
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
                'email.unique' => 'Email đã được sử dụng',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
                'password.confirmed' => 'Xác nhận mật khẩu không khớp',
                'role.required' => 'Vai trò không được để trống',
                'role.in' => 'Vai trò không hợp lệ',
                'balance.required' => 'Số dư không được để trống',
                'balance.numeric' => 'Số dư phải là số',
                'balance.min' => 'Số dư không được âm',
                'banned.required' => 'Trạng thái không được để trống',
                'banned.in' => 'Trạng thái không hợp lệ'
            ]);

            DB::beginTransaction();

            try {
                $updateData = [
                    'email' => $validated['email'],
                    'role' => $validated['role'],
                    'balance' => $validated['balance'],
                    'banned' => $validated['banned']
                ];

                if (!empty($validated['password'])) {
                    $updateData['password'] = $validated['password'];
                }

                $user->update($updateData);

                // Nếu số dư thay đổi, tạo bản ghi transaction
                if ($oldBalance != $validated['balance']) {
                    $status = $validated['balance'] - $oldBalance > 0 ? 'deposit' : 'withdraw';
                    MoneyTransaction::create([
                        'user_id' => $user->id,
                        'type' => $status,
                        'amount' => $validated['balance'] - $oldBalance,
                        'balance_before' => $oldBalance,
                        'balance_after' => $validated['balance'],
                        'description' => 'Admin cập nhật số dư'
                    ]);
                }

                DB::commit();
                return redirect()->route('admin.users.index')
                    ->with('success', 'Cập nhật thông tin người dùng thành công!');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Có lỗi xảy ra khi cập nhật thông tin: ' . $e->getMessage());
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Không tìm thấy người dùng hoặc có lỗi xảy ra!');
        }
    }

    public function destroy($id)
    {
        // Prevent deleting own account
        if ($id == auth()->id()) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa tài khoản của chính mình!'
                ]);
            }
        }

        $user = User::findOrFail($id);
        $user->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa thành viên thành công!'
            ]);
        }
    }
}
