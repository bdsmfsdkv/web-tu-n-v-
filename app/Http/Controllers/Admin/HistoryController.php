<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceOrder;
use App\Models\BankDeposit;
use App\Models\CardDeposit;
use App\Models\DiscountCodeUsage;
use App\Models\MoneyTransaction;
use App\Models\GameAccount;
use App\Models\ServiceHistory;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display the general transaction history
     */
    public function transactions(\Illuminate\Http\Request $request)
    {
        $title = 'Lịch sử giao dịch tiền';
        $transactions = MoneyTransaction::adminFilter($request)->with('user')->orderBy('created_at', 'desc')->paginate($request->input('per_page', 20));

        return view('admin.history.transactions', compact('title', 'transactions'));
    }

    /**
     * Display the account purchase history
     */
    public function accounts(\Illuminate\Http\Request $request)
    {
        $title = 'Lịch sử mua tài khoản';
        $accounts = GameAccount::adminFilter($request)->with(['buyer', 'category'])
            ->where('status', 'sold')
            ->whereNotNull('buyer_id')
            ->orderBy('updated_at', 'desc')
            ->paginate($request->input('per_page', 20));

        return view('admin.history.accounts', compact('title', 'accounts'));
    }

    /**
     * Display the random account purchase history
     */
    public function randomAccounts(\Illuminate\Http\Request $request)
    {
        $title = 'Lịch sử mua tài khoản random';
        $purchases = \App\Models\RandomCategoryAccount::adminFilter($request)->with(['buyer', 'category'])
            ->where('status', 'sold')
            ->whereNotNull('buyer_id')
            ->orderBy('updated_at', 'desc')
            ->paginate($request->input('per_page', 20));

        return view('admin.history.random-accounts', compact('title', 'purchases'));
    }

    /**
     * Display the service order history
     */
    public function services(\Illuminate\Http\Request $request)
    {
        $title = 'Lịch sử đặt dịch vụ';
        $services = ServiceHistory::with(['user', 'gameService', 'servicePackage'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page', 20));

        return view('admin.history.services', compact('title', 'services'));
    }

    /**
     * Display the bank deposit history
     */
    public function bankDeposits(\Illuminate\Http\Request $request)
    {
        $title = 'Lịch sử nạp tiền qua ngân hàng';
        $deposits = BankDeposit::with(['user', 'bankAccount'])->orderBy('created_at', 'desc')->paginate($request->input('per_page', 20));

        return view('admin.history.bank-deposits', compact('title', 'deposits'));
    }

    /**
     * Display the card deposit history
     */
    public function cardDeposits(\Illuminate\Http\Request $request)
    {
        $title = 'Lịch sử nạp thẻ cào';
        $deposits = CardDeposit::adminFilter($request)->with('user')->orderBy('created_at', 'desc')->paginate($request->input('per_page', 20));

        return view('admin.history.card-deposits', compact('title', 'deposits'));
    }

    /**
     * Display the discount code usage history
     */
    public function discountUsages(\Illuminate\Http\Request $request)
    {
        $title = 'Lịch sử sử dụng mã giảm giá';
        $usages = DiscountCodeUsage::adminFilter($request)->with(['user', 'discountCode'])->orderBy('created_at', 'desc')->paginate($request->input('per_page', 20));

        return view('admin.history.discount-usages', compact('title', 'usages'));
    }

    /**
     * Display the USDT deposit history
     */
    public function usdtDeposits(\Illuminate\Http\Request $request)
    {
        $title = 'Lịch sử nạp tiền qua USDT';
        $query = \App\Models\UsdtDeposit::with('user');
        
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('request_code', 'LIKE', "%{$search}%")
                ->orWhereHas('user', function($q) use ($search) {
                    $q->where('username', 'LIKE', "%{$search}%");
                });
        }
        
        $deposits = $query->orderBy('created_at', 'desc')->paginate($request->input('per_page', 20))->withQueryString();

        return view('admin.history.usdt-deposits', compact('title', 'deposits'));
    }
}
