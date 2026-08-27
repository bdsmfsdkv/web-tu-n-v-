<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Models\RandomCategoryAccount;
use App\Models\DiscountCode;
use App\Models\MoneyTransaction;
use App\Http\Controllers\DiscountCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RandomAccountController extends Controller
{
    public function show(Request $request, $id)
    {
        try {
            $account = RandomCategoryAccount::with('category')->find($id);
        } catch (\Throwable $e) {
            $account = null;
        }

        if (!$account || $account->status !== 'available') {
            $categoryUrl = null;
            if ($request->filled('back_url')) {
                $candidate = $request->query('back_url');
                if (is_string($candidate) && str_starts_with($candidate, '/') && !str_starts_with($candidate, '//') && !str_contains($candidate, '\\')) {
                    if (!preg_match('#^/random/account/' . preg_quote((string)$id, '#') . '(\?|$)#', $candidate)) {
                        $categoryUrl = $candidate;
                    }
                }
            }
            if (!$categoryUrl && session()->has('last_category_url')) {
                $lastCat = session('last_category_url');
                if (is_string($lastCat) && !preg_match('#/random/account/' . preg_quote((string)$id, '#') . '(\?|$)#', $lastCat)) {
                    $categoryUrl = $lastCat;
                }
            }
            if (!$categoryUrl && $account && $account->category && !empty($account->category->slug)) {
                try {
                    $categoryUrl = route('random.index', ['slug' => $account->category->slug]);
                } catch (\Throwable $e) {
                    $categoryUrl = null;
                }
            }
            if (!$categoryUrl) {
                $categoryUrl = route('home');
            }

            return redirect()->to($categoryUrl);
        }

        $categoryUrl = null;
        if ($request->filled('back_url')) {
            $candidate = $request->query('back_url');
            if (is_string($candidate) && str_starts_with($candidate, '/') && !str_starts_with($candidate, '//') && !str_contains($candidate, '\\')) {
                $categoryUrl = $candidate;
            }
        }
        if (!$categoryUrl && $account->category && !empty($account->category->slug)) {
            $categoryUrl = route('random.index', ['slug' => $account->category->slug]);
        }
        if (!$categoryUrl && session()->has('last_category_url')) {
            $categoryUrl = session('last_category_url');
        }
        if ($categoryUrl) {
            session(['last_category_url' => $categoryUrl]);
        }
        if (!$categoryUrl) {
            $categoryUrl = route('home');
        }

        $flashSalePrice = \App\Models\FlashSale::getActivePrice('random', $account->random_category_id);
        if ($flashSalePrice !== null) {
            $account->price = $flashSalePrice;
            $account->is_flash_sale = true;
        }

        $relatedAccounts = RandomCategoryAccount::where('random_category_id', $account->random_category_id)
            ->where('id', '!=', $account->id)
            ->where('status', 'available')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        return view("user.random.detail", compact('account', 'relatedAccounts', 'categoryUrl'));
    }

    public function purchase(Request $request, $id)
    {
        // : SQLSTATE[42S02]: Base table or view not found: 1146 Table 'gameshop.accounts' doesn't exist (Connection: mysql, SQL: update `accounts` set `status` = sold, `buyer_id` = 1 where `id` = 5)
        try {
            DB::beginTransaction();

            $account = RandomCategoryAccount::where('id', $id)
                ->where('status', 'available')
                ->lockForUpdate()
                ->first();

            if (!$account) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Tài khoản này đã được mua hoặc không còn tồn tại.',
                ], 409);
            }

            $user = \App\Models\User::whereKey(Auth::id())->lockForUpdate()->firstOrFail();

            if ($account->min_spent > 0 && ($user->total_spent ?? 0) < $account->min_spent) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Tài khoản này hiện không khả dụng.'
                ]);
            }

            $flashSalePrice = \App\Models\FlashSale::getActivePrice('random', $account->random_category_id);
            if ($flashSalePrice !== null) {
                $account->price = $flashSalePrice;
            }

            $discountAmount = 0;
            $finalPrice = $account->price;

            // Check discount code if provided
            if ($request->filled('discount_code')) {
                $discountCode = DiscountCode::where('code', $request->discount_code)
                    ->where('is_active', '1')
                    ->lockForUpdate()
                    ->first();

                if (!$discountCode) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn'
                    ]);
                }

                // Check if the code is expired
                if ($discountCode->expire_date && now() > $discountCode->expire_date) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Mã giảm giá đã hết hạn'
                    ]);
                }
               

                // Check if the code has reached its usage limit
                if ($discountCode->usage_limit && $discountCode->usage_count >= $discountCode->usage_limit) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Mã giảm giá đã đạt giới hạn sử dụng'
                    ]);
                }

                // Check if applicable to this context
                if ($discountCode->applicable_to && $discountCode->applicable_to !== 'random_account') {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Mã giảm giá không áp dụng cho loại giao dịch này'
                    ]);
                }

                // Check if the user already used this code, if per user limit is set
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

                // For item-specific discount codes, check if the code applies to this item
                if ($discountCode->item_ids) {
                    $itemIds = is_array($discountCode->item_ids) ? $discountCode->item_ids : json_decode($discountCode->item_ids, true);
                    if (!in_array($account->id, $itemIds ?? [])) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'Mã giảm giá không áp dụng cho tài khoản random này'
                        ]);
                    }
                }

                // Calculate discount
                if ($discountCode->discount_type === 'percentage') {
                    $discountAmount = ($account->price * $discountCode->discount_value) / 100;
                    // Apply max discount if set
                    if ($discountCode->max_discount_value && $discountAmount > $discountCode->max_discount_value) {
                        $discountAmount = $discountCode->max_discount_value;
                    }
                } else {
                    $discountAmount = $discountCode->discount_value;
                }


                // Calculate final price
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
                    'context' => 'random_account',
                    'item_id' => $account->id,
                    'original_price' => $account->price,
                    'discounted_price' => $finalPrice,
                    'discount_amount' => $discountAmount,
                    'used_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
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

            $batchId = uniqid('ORD-');

            // Update account status
            DB::table('random_category_accounts')
                ->where('id', $account->id)
                ->update([
                    'status' => 'sold',
                    'buyer_id' => $user->id,
                    'batch_id' => $batchId
                ]);

            // Add transaction history
            DB::table('money_transactions')->insert([
                'user_id' => $user->id,
                'type' => 'purchase',
                'amount' => -$finalPrice,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => 'Mua tài khoản random #' . $account->id . ($discountAmount > 0 ? ' (Giảm giá: ' . number_format($discountAmount) . 'đ)' : ''),
                'reference_id' => 'RA-' . $account->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            \Illuminate\Support\Facades\Cache::forget('home_catalog_data');
            \Illuminate\Support\Facades\Cache::forget('home_recent_transactions');

            $returnUrl = $this->safeReturnUrl($request->input('return_url'));

            return response()->json([
                'success' => true,
                'message' => 'Mua tài khoản random thành công!',
                'data' => [
                    'new_balance' => $balanceAfter
                ],
                'redirect_url' => route('profile.purchased-random-account-detail', array_filter([
                    'batchId' => $batchId,
                    'return_url' => $returnUrl,
                ]))
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Lỗi khi mua random account', [
                'user_id' => Auth::id(),
                'account_id' => $id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi mua tài khoản. Vui lòng thử lại sau.'
            ], 500);
        }
    }

    private function safeReturnUrl(mixed $url): ?string
    {
        return is_string($url) && str_starts_with($url, '/') && !str_starts_with($url, '//') && !str_contains($url, '\\')
            ? $url
            : null;
    }
}
