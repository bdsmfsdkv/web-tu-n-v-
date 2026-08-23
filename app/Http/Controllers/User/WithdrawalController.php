<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MoneyWithdrawalHistory;
use App\Models\MoneyTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    /**
     * Show the withdrawal form.
     */
    public function create()
    {
        $title = "Rút tiền";
        return view('user.profile.withdraw', compact('title'));
    }

    /**
     * Store a new withdrawal request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:100000|max:10000000',
            'user_note' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        if ($user->balance < $request->amount) {
            return back()->with('error', 'Số dư không đủ để thực hiện giao dịch.');
        }

        try {
            DB::beginTransaction();

            $user = User::whereKey(auth()->id())->lockForUpdate()->first();
            if (!$user || $user->balance < $request->amount) {
                DB::rollBack();
                return back()->with('error', 'Số dư không đủ để thực hiện giao dịch.');
            }

            // Tạo yêu cầu rút tiền
            $withdrawal = MoneyWithdrawalHistory::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'user_note' => $request->user_note,
                'status' => 'processing',
            ]);

            // Trừ tiền từ tài khoản người dùng
            $balanceBefore = (int) $user->balance;
            $user->balance -= $request->amount;
            $user->save();

            MoneyTransaction::create([
                'user_id' => $user->id,
                'type' => 'withdrawal',
                'amount' => -$request->amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->balance,
                'description' => 'Yêu cầu rút tiền ATM/Ngân hàng #' . $withdrawal->id,
                'reference_id' => 'WD-' . $withdrawal->id,
            ]);

            DB::commit();

            return redirect()->route('profile.withdraw.history')
                ->with('success', 'Yêu cầu rút tiền đã được gửi thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }

    /**
     * Display the withdrawal history.
     */
    public function history()
    {
        $title = "Lịch sử rút tiền";
        $withdrawals = MoneyWithdrawalHistory::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.profile.withdrawal-history', compact('withdrawals', 'title'));
    }
}