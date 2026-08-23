<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\BankAccount;
use App\Models\BankDeposit;
use App\Models\CardDeposit;
use App\Models\GameAccount;
use App\Models\MoneyTransaction;
use App\Models\UsdtDeposit;
use App\Models\RandomCategoryAccount;
use App\Models\ServiceHistory;  // Fix the import here
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\LuckyWheelHistory;
use App\Models\WithdrawalHistory;
use App\Models\RewardItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function index(Request $request): View
    {
        return view('user.profile.profile', [
            'user' => $request->user(),
            'title' => 'Thông tin tài khoản'
        ]);
    }

    public function viewChangePassword(Request $request)
    {
        $title = 'Đổi mật khẩu';
        return view('user.profile.change-password', [
            'user' => $request->user(),
            'title' => $title
        ]);
    }

    /**
     * Handle the password change form submission.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (!Hash::check($value, $request->user()->password)) {
                        $fail('Mật khẩu hiện tại không chính xác.');
                    }
                }
            ],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.change-password')->with('success', 'Mật khẩu đã được cập nhật thành công.');
    }

    public function transactionHistory(Request $request)
    {
        $title = 'Lịch sử giao dịch';
        $transactions = MoneyTransaction::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('user.profile.transaction-history', [
            'user' => $request->user(),
            'transactions' => $transactions,
            'title' => $title
        ]);
    }

    public function purchasedAccounts(Request $request)
    {
        $title = 'Tài khoản đã mua';
        // with('category') tránh 10 query lazy-load do view đọc $transaction->category->name.
        $transactions = GameAccount::with('category')
            ->where('buyer_id', Auth::id())
            ->where('status', 'sold')
            ->paginate(perPage: 10);
        return view('user.profile.purchased-accounts', [
            'user' => $request->user(),
            'transactions' => $transactions,
            'title' => $title
        ]);
    }

    public function servicesHistory(Request $request)
    {
        $title = 'Dịch vụ đã thuê';
        $serviceHistories = ServiceHistory::with(['gameService', 'servicePackage'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.profile.services-history', [
            'user' => $request->user(),
            'serviceHistories' => $serviceHistories,
            'title' => $title
        ]);
    }

    public function getServiceDetail($id)
    {
        try {
            $service = ServiceHistory::with(['gameService', 'servicePackage'])
                ->where('user_id', Auth::id())
                ->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'id' => $service->id,
                'created_at' => $service->created_at,
                'game_service' => [
                    'name' => $service->gameService->name
                ],
                'game_account' => $service->game_account,
                'server' => $service->server,
                'service_package' => [
                    'name' => $service->servicePackage->name
                ],
                'price' => $service->price,
                'status_html' => display_status_service($service->status),
                'admin_note' => $service->admin_note ?? 'Không có ghi chú'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể tải thông tin dịch vụ'
            ], 500);
        }
    }

    public function purchasedRandomAccounts(Request $request)
    {
        $title = 'Tài khoản random đã mua';
        
        $orders = RandomCategoryAccount::select(
                DB::raw('COALESCE(batch_id, CONCAT("LEGACY-", id)) as order_batch_id'),
                'random_category_id',
                'buyer_id',
                DB::raw('MAX(updated_at) as purchase_time'),
                DB::raw('COUNT(id) as quantity'),
                DB::raw('SUM(price) as total_price')
            )
            ->with('category')
            ->where('buyer_id', Auth::id())
            ->where('status', 'sold')
            ->groupBy('order_batch_id', 'random_category_id', 'buyer_id')
            ->orderBy('purchase_time', 'desc')
            ->paginate(10);

        // Trước đây mỗi dòng trên trang gọi randomOrderTransactionTotal() riêng, tức 10
        // query SUM với LIKE '%...%' (không dùng được index). Giờ gộp thành 1 query.
        $totals = $this->randomOrderTransactionTotals(
            (int) Auth::id(),
            $orders->getCollection()->pluck('order_batch_id')->all()
        );

        $orders->getCollection()->each(function ($order) use ($totals) {
            if (isset($totals[$order->order_batch_id])) {
                $order->total_price = $totals[$order->order_batch_id];
            }
        });
            
        return view('user.profile.purchased-random-accounts', [
            'user' => $request->user(),
            'orders' => $orders,
            'title' => $title
        ]);
    }

    public function purchasedRandomAccountDetail(Request $request, $batchId)
    {
        $isLegacy = strpos($batchId, 'LEGACY-') === 0;
        
        $query = RandomCategoryAccount::with('category')
            ->where('buyer_id', Auth::id())
            ->where('status', 'sold');
            
        if ($isLegacy) {
            $id = str_replace('LEGACY-', '', $batchId);
            $query->where('id', $id);
        } else {
            $query->where('batch_id', $batchId);
        }
        
        $accounts = $query->get();
        
        if ($accounts->isEmpty()) {
            abort(404);
        }
        
        $firstAcc = $accounts->first();
        $transactionTotal = $this->randomOrderTransactionTotal(Auth::id(), $batchId);
        $order = (object)[
            'batch_id' => $batchId,
            'category' => $firstAcc->category,
            'purchase_time' => $firstAcc->updated_at,
            'quantity' => $accounts->count(),
            'total_price' => $transactionTotal ?? $accounts->sum('price'),
            'accounts' => $accounts
        ];
        
        $title = 'Chi tiết đơn hàng random';
        return view('user.profile.purchased-random-account-detail', [
            'user' => $request->user(),
            'order' => $order,
            'title' => $title
        ]);
    }

    private function randomOrderTransactionTotal(int $userId, string $batchId): ?float
    {
        if (str_starts_with($batchId, 'LEGACY-')) {
            return null;
        }

        $total = MoneyTransaction::where('user_id', $userId)
            ->where('type', 'purchase')
            ->where('description', 'like', '%(Đơn: ' . $batchId . ')')
            ->sum(DB::raw('ABS(amount)'));

        return $total > 0 ? (float) $total : null;
    }

    public function depositCard(Request $request)
    {
        $title = 'Nạp tiền thẻ cào';
        $transactions = CardDeposit::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.profile.deposit-card', [
            'transactions' => $transactions,
            'title' => $title
        ]);
    }

    public function depositAtm(Request $request)
    {
        $title = 'Nạp tiền ATM';
        $transactions = BankDeposit::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get bank accounts from the database
        $bankAccounts = BankAccount::where('is_active', true)
            ->orderBy('id', 'asc')
            ->get();

        // Ensure each bank account has a prefix
        foreach ($bankAccounts as $account) {
            if (empty($account->prefix)) {
                $account->prefix = 'NAP' . $request->user()->id;
            }
        }

        return view('user.profile.deposit-atm', [
            'user' => $request->user(),
            'transactions' => $transactions,
            'bankAccounts' => $bankAccounts,
            'title' => $title
        ]);
    }

    public function checkDepositAtm(Request $request)
    {
        $userId = Auth::id();
        $since = $request->input('since');
        
        $query = BankDeposit::where('user_id', $userId)
            ->orderBy('created_at', 'desc');

        if ($since) {
            try {
                $query->where('created_at', '>=', Carbon::parse($since));
            } catch (\Exception $e) {}
        }

        $latestDeposit = $query->first();

        if ($latestDeposit) {
            $user = User::find($userId) ?? Auth::user();
            return response()->json([
                'success' => true,
                'found' => true,
                'deposit' => [
                    'id' => $latestDeposit->transaction_id,
                    'amount' => $latestDeposit->amount,
                    'amount_formatted' => number_format($latestDeposit->amount) . 'đ',
                    'bank' => $latestDeposit->bank,
                    'content' => $latestDeposit->content,
                    'transaction_id' => $latestDeposit->transaction_id,
                    'created_at' => $latestDeposit->created_at ? $latestDeposit->created_at->format('H:i:s d/m/Y') : '',
                ],
                'new_balance' => $user->balance,
                'new_balance_formatted' => number_format($user->balance),
            ]);
        }

        return response()->json([
            'success' => true,
            'found' => false,
        ]);
    }

    public function depositUsdt(Request $request)
    {
        $title = 'Nạp tiền USDT';
        $transactions = UsdtDeposit::where('user_id', \Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $rate = config_get('usdt_rate', 25000);
        $usdtAccounts = \App\Models\UsdtAccount::where('is_active', true)->get();

        return view('user.profile.deposit-usdt', [
            'user' => $request->user(),
            'transactions' => $transactions,
            'rate' => $rate,
            'usdtAccounts' => $usdtAccounts,
            'title' => $title
        ]);
    }

    public function processDepositUsdt(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:100000',
        ]);

        $amount = $request->amount;
        $rate = config_get('usdt_rate', 25000);
        $vnd_amount = $amount * $rate;

        $deposit = new UsdtDeposit();
        $deposit->user_id = Auth::id();
        $deposit->request_code = 'USDT_' . time() . '_' . Auth::id();
        $deposit->usdt_amount = $amount;
        $deposit->exchange_rate = $rate;
        $deposit->vnd_amount = $vnd_amount;
        $deposit->status = 'pending';
        $deposit->save();

        return back()->with('success', 'Yêu cầu tạo hoá đơn nạp USDT thành công!')
                     ->with('auto_show_modal', [
                         'code' => 'Nap' . Auth::id(),
                         'amount' => $amount
                     ]);
    }

    /**
     * Display the user's lucky wheel history.
     */
    public function luckyWheelHistory(Request $request)
    {
        $title = 'Lịch sử vận may';
        $wheelHistories = LuckyWheelHistory::with('luckyWheel')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.profile.wheels-history', [
            'user' => $request->user(),
            'wheelHistories' => $wheelHistories,
            'title' => $title
        ]);
    }

    /**
     * Get lucky wheel history detail.
     */
    public function getLuckyWheelDetail($id)
    {
        try {
            $history = LuckyWheelHistory::with('luckyWheel')
                ->where('user_id', Auth::id())
                ->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'id' => $history->id,
                'created_at' => $history->created_at,
                'lucky_wheel' => [
                    'name' => $history->luckyWheel->name
                ],
                'spin_count' => $history->spin_count,
                'total_cost' => $history->total_cost,
                'reward_type' => $history->reward_type,
                'reward_amount' => $history->reward_amount,
                'description' => $history->description
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể tải thông tin vòng quay may mắn'
            ], 500);
        }
    }

    /**
     * Show the gold withdrawal page.
     */
    public function withdrawGold()
    {
        $title = "Rút vàng";
        $user = auth()->user();
        $withdrawals = WithdrawalHistory::where('user_id', $user->id)
            ->where('type', 'gold')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $minWithdrawGold = config_get('min_withdraw_gold', 1000);
        $maxWithdrawGold = config_get('max_withdraw_gold', 1000000000);

        return view('user.profile.withdraw-gold', compact('title', 'withdrawals', 'minWithdrawGold', 'maxWithdrawGold'));
    }

    /**
     * Process a gold withdrawal request.
     */
    public function processWithdrawGold(Request $request)
    {
        $minWithdrawGold = config_get('min_withdraw_gold', 1000);
        $maxWithdrawGold = config_get('max_withdraw_gold', 1000000000);

        $request->validate([
            'amount' => "required|integer|min:$minWithdrawGold|max:$maxWithdrawGold",
            'game' => 'required|string|max:100',
            'character_name' => 'required|string|max:50',
            'server' => 'required|string|max:50',
            'user_note' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        if ($user->gold < $request->amount) {
            return back()->with('error', 'Số vàng không đủ để thực hiện giao dịch.')->withInput();
        }

        try {
            DB::beginTransaction();

            // Tạo yêu cầu rút vàng
            WithdrawalHistory::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'gold',
                'game' => $request->game,
                'character_name' => $request->character_name,
                'server' => $request->input('server'),
                'user_note' => $request->user_note,
                'status' => 'processing',
            ]);

            // Trừ vàng từ tài khoản người dùng
            $user->gold -= $request->amount;
            $user->save();

            DB::commit();

            return back()->with('success', 'Yêu cầu rút vàng đã được gửi thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }

    /**
     * Show the gem withdrawal page.
     */
    public function withdrawGem(Request $request)
    {
        $title = "Rút vật phẩm";
        $user = auth()->user();
        $withdrawals = WithdrawalHistory::with('rewardItem')->where('user_id', $user->id)
            ->where('type', 'gem')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $rewardItems = RewardItem::where('active', 1)
            ->withSum(['wheelHistories as won_amount' => fn ($query) => $query->where('user_id', $user->id)], 'reward_amount')
            ->withSum(['withdrawals as withdrawn_amount' => fn ($query) => $query->where('user_id', $user->id)->whereIn('status', ['processing', 'success'])], 'amount')
            ->orderBy('priority', 'asc')
            ->get()
            ->each(fn (RewardItem $item) => $item->available_amount = max(0, (int) $item->won_amount - (int) $item->withdrawn_amount));

        $gemBalance = (int) $user->gem;
        $selectedRewardItemId = $request->integer('item');
        if (!$rewardItems->contains('id', $selectedRewardItemId)) {
            $selectedRewardItemId = null;
        }

        return view('user.profile.withdraw-gem', compact('title', 'withdrawals', 'rewardItems', 'gemBalance', 'selectedRewardItemId'));
    }

    /**
     * Process a gem withdrawal request.
     */
    public function processWithdrawGem(Request $request)
    {
        $request->validate([
            'reward_item_id' => 'nullable|integer',
            'amount' => 'required|integer|min:1',
            'character_name' => 'required|string|max:50',
            'server' => 'required|integer|min:1|max:13',
            'user_note' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();
            $user = auth()->user()->newQuery()->lockForUpdate()->findOrFail(auth()->id());
            $rewardItem = null;

            if ($request->filled('reward_item_id')) {
                $rewardItem = RewardItem::whereKey($request->integer('reward_item_id'))
                    ->where('active', 1)
                    ->lockForUpdate()
                    ->firstOrFail();

                $wonAmount = LuckyWheelHistory::where('user_id', $user->id)
                    ->where('reward_item_id', $rewardItem->id)
                    ->sum('reward_amount');
                $withdrawnAmount = WithdrawalHistory::where('user_id', $user->id)
                    ->where('reward_item_id', $rewardItem->id)
                    ->whereIn('status', ['processing', 'success'])
                    ->sum('amount');
                $availableAmount = max(0, $wonAmount - $withdrawnAmount);

                if ($request->amount > $availableAmount) {
                    DB::rollBack();
                    return back()->with('error', 'Số lượng vật phẩm không đủ để thực hiện giao dịch.')->withInput();
                }

                if ($request->amount < $rewardItem->min_withdraw || ($rewardItem->max_withdraw > 0 && $request->amount > $rewardItem->max_withdraw)) {
                    DB::rollBack();
                    return back()->with('error', 'Số lượng rút không nằm trong giới hạn của vật phẩm.')->withInput();
                }
            } elseif ($request->amount > $user->gem) {
                DB::rollBack();
                return back()->with('error', 'Số dư CC không đủ để thực hiện giao dịch.')->withInput();
            }

            WithdrawalHistory::create([
                'user_id' => $user->id,
                'reward_item_id' => $rewardItem?->id,
                'amount' => $request->amount,
                'type' => 'gem',
                'character_name' => $request->character_name,
                'server' => $request->input('server'),
                'user_note' => $request->user_note,
                'status' => 'processing',
            ]);

            if ($rewardItem === null) {
                $user->gem -= $request->amount;
                $user->save();
            }

            DB::commit();

            return back()->with('success', 'Yêu cầu rút vật phẩm đã được gửi thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }

    /**
     * Get withdrawal detail for AJAX request
     */
    public function getWithdrawalDetail($id)
    {
        try {
            $withdrawal = WithdrawalHistory::findOrFail($id);

            // Check if withdrawal belongs to current user
            if ($withdrawal->user_id !== auth()->id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn không có quyền xem thông tin này'
                ], 403);
            }

            // Get status HTML

            return response()->json([
                'status' => 'success',
                'id' => $withdrawal->id,
                'user_id' => $withdrawal->user_id,
                'amount' => $withdrawal->amount,
                'type' => $withdrawal->type,
                'game' => $withdrawal->game,
                'character_name' => $withdrawal->character_name,
                'server' => $withdrawal->server,
                'user_note' => $withdrawal->user_note,
                'admin_note' => $withdrawal->admin_note,
                'status_html' => display_status($withdrawal->status),
                'created_at' => $withdrawal->created_at,
                'updated_at' => $withdrawal->updated_at
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy thông tin yêu cầu rút'
            ], 404);
        }
    }

    public function affiliate()
    {
        $title = "Tiếp thị liên kết";
        $user = auth()->user();
        
        $referredUsersCount = \App\Models\User::where('referrer_id', $user->id)->count();
        $affiliateHistories = \App\Models\AffiliateHistory::where('referrer_id', $user->id)
            ->with('referred')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('user.profile.affiliate', compact('title', 'user', 'referredUsersCount', 'affiliateHistories'));
    }
}
