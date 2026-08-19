<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Installment;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Installment::with(['user', 'gameAccount.category'])->orderBy('id', 'desc');

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('game_account_id', $search);
        }

        $installments = $query->paginate(20);

        return view('admin.installments.index', compact('installments'));
    }

    // Optional: Cancel an installment manually
    public function cancel($id)
    {
        $installment = Installment::findOrFail($id);
        
        if ($installment->status !== 'active') {
            return back()->with('error', 'Chỉ có thể hủy hợp đồng đang hoạt động!');
        }

        $installment->status = 'cancelled';
        $installment->save();

        // Release the game account back to 'available'
        $account = $installment->gameAccount;
        if ($account && $account->status === 'installment') {
            $account->status = 'available';
            $account->buyer_id = null;
            $account->save();
        }

        return back()->with('success', 'Đã hủy hợp đồng trả góp và mở khóa tài khoản thành công!');
    }
}
