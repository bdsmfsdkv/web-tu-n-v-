<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResourceWithdrawalController extends Controller
{
    /**
     * Display a listing of the resource withdrawal requests.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $query = WithdrawalHistory::with(['user', 'rewardItem']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('character_name', 'like', "%{$search}%")
                  ->orWhere('id', $search)
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('username', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $perPage = (int) $request->input('per_page', 20);
        if (!in_array($perPage, [10, 20, 25, 50, 100])) {
            $perPage = 20;
        }

        $withdrawals = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('admin.history.resource-withdrawal-history', compact('withdrawals'));
    }

    /**
     * Mark a withdrawal request as completed.
     */
    public function approve(WithdrawalHistory $withdrawal, Request $request)
    {
        if ($withdrawal->status !== 'processing') {
            return back()->with('error', 'Yêu cầu rút này không thể duyệt.');
        }

        try {
            DB::beginTransaction();

            $withdrawal->update([
                'status' => 'success',
                'admin_note' => $request->admin_note,
            ]);

            DB::commit();

            return back()->with('success', 'Yêu cầu rút tài nguyên đã được duyệt thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }

    /**
     * Mark a withdrawal request as cancelled.
     */
    public function reject(WithdrawalHistory $withdrawal, Request $request)
    {
        if ($withdrawal->status !== 'processing') {
            return back()->with('error', 'Yêu cầu rút này không thể từ chối.');
        }

        try {
            DB::beginTransaction();

            $lockedWithdrawal = WithdrawalHistory::where('id', $withdrawal->id)->lockForUpdate()->first();
            if (!$lockedWithdrawal || $lockedWithdrawal->status !== 'processing') {
                DB::rollBack();
                return back()->with('error', 'Yêu cầu rút này không thể từ chối.');
            }

            // Get user with lock
            $user = User::whereKey($lockedWithdrawal->user_id)->lockForUpdate()->first();
            if ($user) {
                // Vật phẩm riêng được tính từ lịch sử, yêu cầu lỗi tự động không còn bị trừ.
                if ($lockedWithdrawal->type === 'gold') {
                    $user->gold += $lockedWithdrawal->amount;
                } elseif ($lockedWithdrawal->reward_item_id === null) {
                    $user->gem += $lockedWithdrawal->amount;
                }

                $user->save();
            }

            // Update withdrawal status
            $lockedWithdrawal->update([
                'status' => 'error',
                'admin_note' => $request->admin_note,
            ]);

            DB::commit();

            return back()->with('success', 'Yêu cầu rút tài nguyên đã bị từ chối và đã hoàn trả lại cho người dùng.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }
}
