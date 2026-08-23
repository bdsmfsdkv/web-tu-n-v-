<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Models\GameAccount;
use App\Models\MoneyTransaction;
use App\Models\DiscountCode;
use App\Http\Controllers\DiscountCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameAccountController extends Controller
{
    public function show($id)
    {
        $account = GameAccount::with('category')->findOrFail($id);

        // Sold accounts remain viewable only by their buyer. This prevents a user
        // from returning to a stale purchase page and seeing the item as purchasable.
        if ($account->status !== 'available' && (!Auth::check() || $account->buyer_id !== Auth::id())) {
            if ($account->category) {
                return redirect()
                    ->route('category.index', ['slug' => $account->category->slug])
                    ->with('error', 'Tài khoản này đã được bán.');
            }

            abort(404);
        }

        $images = json_decode($account->images) ?? [];

        $flashSalePrice = \App\Models\FlashSale::getActivePrice('game', $account->game_category_id);
        if ($flashSalePrice !== null && $account->status === 'available') {
            $account->price = $flashSalePrice;
            $account->is_flash_sale = true;
        }

        $relatedAccounts = GameAccount::where('game_category_id', $account->game_category_id)
            ->where('id', '!=', $account->id)
            ->where('status', 'available')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        return response()
            ->view('user.account.detail', compact('account', 'images', 'relatedAccounts'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }


    public function purchase(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $account = GameAccount::where('id', $id)
                ->where('status', 'available')
                ->lockForUpdate()
                ->firstOrFail();

            $flashSalePrice = \App\Models\FlashSale::getActivePrice('game', $account->game_category_id);
            if ($flashSalePrice !== null) {
                $account->price = $flashSalePrice;
            }

            $user = Auth::user();
            $finalPrice = $account->price;
            $discountAmount = 0;
            $discountCodeController = new DiscountCodeController();

            if ($request->filled('discount_code')) {
                $discountCode = DiscountCode::where('code', $request->discount_code)
                    ->where('is_active', '1')
                    ->first();

                if ($discountCode) {
                    if ($discountCode->discount_type === 'percentage') {
                        $discountAmount = ($account->price * $discountCode->discount_value) / 100;
                        if ($discountCode->max_discount_value && $discountAmount > $discountCode->max_discount_value) {
                            $discountAmount = $discountCode->max_discount_value;
                        }
                    } else {
                        $discountAmount = $discountCode->discount_value;
                    }

                    $finalPrice = $account->price - $discountAmount;
                    if ($finalPrice < 0) {
                        $finalPrice = 0;
                    }

                    DB::table('discount_codes')
                        ->where('id', $discountCode->id)
                        ->increment('usage_count');

                    DB::table('discount_code_usages')->insert([
                        'discount_code_id' => $discountCode->id,
                        'user_id' => $user->id,
                        'context' => 'account',
                        'item_id' => $account->id,
                        'original_price' => $account->price,
                        'discounted_price' => $finalPrice,
                        'discount_amount' => $discountAmount,
                        'used_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            if ($user->balance < $finalPrice) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Số dư không đủ để mua tài khoản này'
                ]);
            }

            $balanceBefore = $user->balance;
            $balanceAfter = $balanceBefore - $finalPrice;

            DB::table('users')
                ->where('id', $user->id)
                ->update(['balance' => $balanceAfter]);

            DB::table('game_accounts')
                ->where('id', $account->id)
                ->update([
                    'status' => 'sold',
                    'buyer_id' => $user->id
                ]);

            DB::table('money_transactions')->insert([
                'user_id' => $user->id,
                'type' => 'purchase',
                'amount' => -$finalPrice,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => 'Mua tài khoản #' . $account->id . ($discountAmount > 0 ? ' (Giảm giá: ' . number_format($discountAmount) . 'đ)' : ''),
                'reference_id' => $account->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mua tài khoản thành công!',
                'data' => [
                    'new_balance' => $balanceAfter
                ],
                'redirect_url' => route('profile.purchased-accounts')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi mua tài khoản: ' . $e->getMessage()
            ]);
        }
    }
}
