<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MoneyTransaction;
use App\Models\MoneyWithdrawalHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoneyWithdrawalController extends Controller
{
    /**
     * Display a listing of the withdrawal requests.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $withdrawals = MoneyWithdrawalHistory::with('user')
            ->adminFilter($request)
            ->latest()
            ->paginate($request->input('per_page', 20))
            ->withQueryString();

        return view('admin.history.money-withdrawal-history', compact('withdrawals'));
    }

    /**
     * Mark a withdrawal request as success.
     */
    public function approve(MoneyWithdrawalHistory $withdrawal, Request $request)
    {
        if ($withdrawal->status !== 'processing') {
            return back()->with('error', 'Yêu cầu rút tiền này không thể duyệt.');
        }

        try {
            DB::beginTransaction();

            $withdrawal->update([
                'status' => 'success',
                'admin_note' => $request->admin_note,
            ]);

            DB::commit();

            return back()->with('success', 'Yêu cầu rút tiền đã được duyệt thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }

    /**
     * Mark a withdrawal request as error.
     */
    public function reject(MoneyWithdrawalHistory $withdrawal, Request $request)
    {
        if ($withdrawal->status !== 'processing') {
            return back()->with('error', 'Yêu cầu rút tiền này không thể từ chối.');
        }

        try {
            DB::beginTransaction();

            $lockedWithdrawal = MoneyWithdrawalHistory::where('id', $withdrawal->id)->lockForUpdate()->first();
            if (!$lockedWithdrawal || $lockedWithdrawal->status !== 'processing') {
                DB::rollBack();
                return back()->with('error', 'Yêu cầu rút tiền này không thể từ chối.');
            }

            $lockedWithdrawal->update([
                'status' => 'error',
                'admin_note' => $request->admin_note,
            ]);

            // Hoàn tiền cho người dùng
            $user = User::whereKey($lockedWithdrawal->user_id)->lockForUpdate()->first();
            if ($user) {
                $balanceBefore = (int) $user->balance;
                $user->balance += $lockedWithdrawal->amount;
                $user->save();

                // Lưu lịch sử hoàn tiền người dùng
                $moneyTransaction = new MoneyTransaction();
                $moneyTransaction->user_id = $lockedWithdrawal->user_id;
                $moneyTransaction->type = 'refund';
                $moneyTransaction->amount = $lockedWithdrawal->amount;
                $moneyTransaction->balance_before = $balanceBefore;
                $moneyTransaction->balance_after = $user->balance;
                $moneyTransaction->description = $request->input('admin_note') ?? 'Hoàn tiền cho yêu cầu rút tiền bị từ chối ID: ' . $lockedWithdrawal->id;
                $moneyTransaction->reference_id = 'WD-REFUND-' . $lockedWithdrawal->id;
                $moneyTransaction->save();
            }

            DB::commit();

            return back()->with('success', 'Yêu cầu rút tiền đã bị từ chối và tiền đã được hoàn lại cho người dùng.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }
}