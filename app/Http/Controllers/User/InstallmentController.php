<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameAccount;
use App\Models\Installment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InstallmentController extends Controller
{
    // Cấu hình tỷ lệ trả trước tối thiểu (VD: 20%)
    const MIN_DEPOSIT_PERCENT = 20;

    public function index()
    {
        $installments = Installment::where('user_id', Auth::id())
            ->with(['gameAccount.category'])
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('user.profile.installments', compact('installments'));
    }

    public function create(Request $request, $id)
    {
        $request->validate([
            'duration' => 'required|in:7,30,60',
        ]);

        $duration = (int) $request->duration;
        $user = Auth::user();

        DB::beginTransaction();
        try {
            $account = GameAccount::where('id', $id)
                ->where('status', 'available')
                ->lockForUpdate()
                ->first();

            if (!$account) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Tài khoản không tồn tại hoặc đã bị bán']);
            }

            // Có thể áp dụng mã giảm giá ở đây nếu cần, tạm thời tính giá gốc
            $price = $account->price;
            
            // Check FlashSale
            $flashSalePrice = \App\Models\FlashSale::getActivePrice('game', $account->game_category_id);
            if ($flashSalePrice !== null) {
                $price = $flashSalePrice;
            }

            $depositAmount = ($price * self::MIN_DEPOSIT_PERCENT) / 100;

            $user = User::whereKey(Auth::id())->lockForUpdate()->first();
            if (!$user) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Người dùng không tồn tại']);
            }

            if ($user->balance < $depositAmount) {
                DB::rollBack();
                return response()->json([
                    'success' => false, 
                    'message' => 'Bạn cần tối thiểu ' . number_format($depositAmount) . 'đ để trả góp nick này!'
                ]);
            }

            // Trừ tiền user
            $balanceBefore = (int) $user->balance;
            $user->balance -= $depositAmount;
            $user->save();

            // Ghi nhận biến động số dư
            \App\Models\MoneyTransaction::create([
                'user_id' => $user->id,
                'type' => 'purchase',
                'amount' => -$depositAmount,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->balance,
                'description' => 'Đặt cọc mua trả góp tài khoản #' . $account->id,
                'reference_id' => 'INSTALLMENT-ACC-' . $account->id,
            ]);

            // Khóa acc
            $account->status = 'installment';
            $account->buyer_id = $user->id; // Gắn tạm cho buyer
            $account->save();

            // Tạo installment
            $installment = Installment::create([
                'user_id' => $user->id,
                'game_account_id' => $account->id,
                'total_price' => $price,
                'paid_amount' => $depositAmount,
                'duration_days' => $duration,
                'expire_date' => Carbon::now()->addDays($duration),
                'status' => 'active'
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Đăng ký mua trả góp thành công!',
                'redirect_url' => route('profile.installments')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Lỗi khi đăng ký trả góp', [
                'user_id' => Auth::id(),
                'account_id' => $id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra khi đăng ký trả góp. Vui lòng thử lại sau.'], 500);
        }
    }

    public function pay(Request $request, $id)
    {
        $user = Auth::user();
        
        $request->validate([
            'amount' => 'required|numeric|min:10000'
        ]);

        $amount = $request->amount;

        DB::beginTransaction();
        try {
            $installment = Installment::where('id', $id)
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->lockForUpdate()
                ->first();

            if (!$installment) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Hợp đồng không tồn tại hoặc đã kết thúc']);
            }

            if ($installment->expire_date < now()) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Hợp đồng này đã quá hạn thanh toán']);
            }

            $remaining = $installment->total_price - $installment->paid_amount;
            if ($amount > $remaining) {
                $amount = $remaining;
            }

            $user = User::whereKey(Auth::id())->lockForUpdate()->first();
            if (!$user || $user->balance < $amount) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Số dư không đủ!']);
            }

            // Trừ tiền
            $balanceBefore = (int) $user->balance;
            $user->balance -= $amount;
            $user->save();

            \App\Models\MoneyTransaction::create([
                'user_id' => $user->id,
                'type' => 'purchase',
                'amount' => -$amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->balance,
                'description' => 'Thanh toán đợt trả góp hợp đồng #' . $installment->id,
                'reference_id' => 'INSTALLMENT-PAY-' . $installment->id,
            ]);

            $installment->paid_amount += $amount;
            
            // Nếu đã trả đủ
            if ($installment->paid_amount >= $installment->total_price) {
                $installment->status = 'completed';
                
                // Mở acc
                $account = GameAccount::find($installment->game_account_id);
                $account->status = 'sold';
                $account->save();
            }
            
            $installment->save();

            DB::commit();
            return response()->json([
                'success' => true, 
                'message' => 'Thanh toán thành công ' . number_format($amount) . 'đ',
                'is_completed' => $installment->status === 'completed'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Lỗi khi thanh toán trả góp', [
                'user_id' => Auth::id(),
                'installment_id' => $id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra khi thanh toán. Vui lòng thử lại sau.'], 500);
        }
    }
}
