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
use Illuminate\Support\Facades\Log;

class GameAccountController extends Controller
{
    public function show($id)
    {
        // with('category') tránh lazy-load: view detail dùng $account->category ở nhiều chỗ.
        $account = GameAccount::with('category')->findOrFail($id);

        $images = is_array($account->images) ? $account->images : (json_decode($account->images, true) ?? []);

        $flashSalePrice = \App\Models\FlashSale::getActivePrice('game', $account->game_category_id);
        if ($flashSalePrice !== null) {
            $account->price = $flashSalePrice;
            $account->is_flash_sale = true;
        }

        $relatedAccounts = GameAccount::where('game_category_id', $account->game_category_id)
            ->where('id', '!=', $account->id)
            ->where('status', 'available')
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        if ($flashSalePrice !== null) {
            $relatedAccounts->each(fn ($related) => $related->price = $flashSalePrice);
        }

        return view("user.account.detail", compact('account', 'images', 'relatedAccounts'));
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

            $user = \App\Models\User::whereKey(Auth::id())->lockForUpdate()->firstOrFail();
            $finalPrice = $account->price;
            $discountAmount = 0;
            $discountCode = null;

            // Check for discount code if provided
            if ($request->filled('discount_code')) {
                $discountCode = DiscountCode::where('code', $request->discount_code)
                    ->where('is_active', '1')
                    ->lockForUpdate()
                    ->first();

                if ($discountCode) {
                    // Check expire date
                    if ($discountCode->expire_date && now() > $discountCode->expire_date) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'Mã giảm giá đã hết hạn'
                        ]);
                    }

                    // Check usage limit
                    if ($discountCode->usage_limit && $discountCode->usage_count >= $discountCode->usage_limit) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'Mã giảm giá đã đạt giới hạn sử dụng'
                        ]);
                    }

                    // Check per user limit
                    if ($discountCode->per_user_limit) {
                        $userUsageCount = DB::table('discount_code_usages')
                            ->where('discount_code_id', $discountCode->id)
                            ->where('user_id', $user->id)
                            ->count();
                        if ($userUsageCount >= $discountCode->per_user_limit) {
                            DB::rollBack();
                            return response()->json([
                                'success' => false,
                                'message' => 'Bạn đã sử dụng mã giảm giá này đủ số lần cho phép'
                            ]);
                        }
                    }

                    // Check applicable_to
                    if ($discountCode->applicable_to && $discountCode->applicable_to !== 'account') {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'Mã giảm giá không áp dụng cho loại giao dịch này'
                        ]);
                    }

                    // Check item_ids
                    if ($discountCode->item_ids) {
                        $itemIds = is_array($discountCode->item_ids) ? $discountCode->item_ids : json_decode($discountCode->item_ids, true);
                        if (!in_array($account->id, $itemIds ?? [])) {
                            DB::rollBack();
                            return response()->json([
                                'success' => false,
                                'message' => 'Mã giảm giá không áp dụng cho tài khoản này'
                            ]);
                        }
                    }

                    // Calculate discount
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

                    // Update usage count directly in database
                    DB::table('discount_codes')
                        ->where('id', $discountCode->id)
                        ->increment('usage_count');

                    // Record usage details
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

            // Update user balance
            $balanceBefore = $user->balance;
            $balanceAfter = $balanceBefore - $finalPrice;

            // Use direct DB update instead of model save
            DB::table('users')
                ->where('id', $user->id)
                ->update(['balance' => $balanceAfter]);

            // Update account status
            DB::table('game_accounts')
                ->where('id', $account->id)
                ->update([
                    'status' => 'sold',
                    'buyer_id' => $user->id
                ]);

            // Thêm lịch sử biến động số dư
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

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Game account purchase failed.', [
                'account_id' => $id,
                'user_id' => Auth::id(),
                'exception' => $e,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Không thể mua tài khoản lúc này. Vui lòng thử lại sau.'
            ], 500);
        }
    }
}
