<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Models\GameAccount;
use App\Models\PurchasedAccountHistory;
use App\Models\MoneyTransaction;
use App\Models\DiscountCode;
use App\Helpers\UploadHelper;
use App\Http\Controllers\DiscountCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameAccountController extends Controller
{
    public function show(Request $request, $id)
    {
        // với account đã bán/đã mua (hoặc không còn ở trạng thái available): tự động chuyển hướng an toàn
        try {
            $account = GameAccount::with('category')->where('status', 'available')->find($id);
        } catch (\Throwable $e) {
            $account = null;
        }

        if (!$account) {
            $categoryUrl = null;
            if ($request->filled('back_url')) {
                $candidate = $request->query('back_url');
                if (is_string($candidate) && str_starts_with($candidate, '/') && !str_starts_with($candidate, '//') && !str_contains($candidate, '\\')) {
                    if (!preg_match('#^/account/' . preg_quote((string)$id, '#') . '(\?|$)#', $candidate)) {
                        $categoryUrl = $candidate;
                    }
                }
            }
            if (!$categoryUrl && session()->has('last_category_url')) {
                $lastCat = session('last_category_url');
                if (is_string($lastCat) && !preg_match('#/account/' . preg_quote((string)$id, '#') . '(\?|$)#', $lastCat)) {
                    $categoryUrl = $lastCat;
                }
            }
            if (!$categoryUrl) {
                try {
                    $history = PurchasedAccountHistory::where('original_game_account_id', $id)->latest()->first();
                    if ($history) {
                        if ($history->game_category_id) {
                            $cat = GameCategory::find($history->game_category_id);
                            if ($cat && !empty($cat->slug)) {
                                $categoryUrl = route('category.index', ['slug' => $cat->slug]);
                            }
                        }
                        if (!$categoryUrl && !empty($history->category_name)) {
                            $cat = GameCategory::where('name', $history->category_name)->first();
                            if ($cat && !empty($cat->slug)) {
                                $categoryUrl = route('category.index', ['slug' => $cat->slug]);
                            }
                        }
                    }
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
            $categoryUrl = route('category.index', ['slug' => $account->category->slug]);
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

        return view("user.account.detail", compact('account', 'images', 'relatedAccounts', 'categoryUrl'));
    }


    public function purchase(Request $request, $id)
    {
        $cleanupImages = [];

        try {
            DB::beginTransaction();

            $account = GameAccount::with('category')
                ->where('id', $id)
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

            $flashSalePrice = \App\Models\FlashSale::getActivePrice('game', $account->game_category_id);
            if ($flashSalePrice !== null) {
                $account->price = $flashSalePrice;
            }

            $user = \App\Models\User::whereKey(Auth::id())->lockForUpdate()->firstOrFail();
            $originalPrice = $account->price;
            $finalPrice = $originalPrice;
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

            DB::table('users')
                ->where('id', $user->id)
                ->update(['balance' => $balanceAfter]);

            // Snapshot data for history & cleanup
            $orderCode = $account->order_code;
            $categoryName = $account->category ? $account->category->name : 'Tài khoản Game';
            $parsedDetails = is_array($account->details) ? $account->details : (json_decode($account->details, true) ?? null);
            $parsedImages = is_array($account->images) ? $account->images : (json_decode($account->images, true) ?? []);

            if ($account->thumb) {
                $cleanupImages[] = $account->thumb;
            }
            if (!empty($parsedImages) && is_array($parsedImages)) {
                foreach ($parsedImages as $img) {
                    if (is_string($img) && $img !== '') {
                        $cleanupImages[] = $img;
                    }
                }
            }
            $cleanupImages = array_values(array_unique($cleanupImages));

            // Create history snapshot
            $history = new PurchasedAccountHistory();
            $history->user_id = $user->id;
            $history->original_game_account_id = $account->id;
            $history->game_category_id = $account->game_category_id;
            $history->category_name = $categoryName;
            $history->order_code = $orderCode;
            $history->account_name = $account->account_name;
            $history->password = $account->password;
            $history->price = $finalPrice;
            $history->original_price = $originalPrice;
            $history->discount_amount = $discountAmount;
            $history->details = $parsedDetails;
            $history->note = $account->note;
            $history->purchased_at = now();
            $history->save();

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

            // Delete original game account from active stock
            $account->delete();

            DB::commit();

            \Illuminate\Support\Facades\Cache::forget('home_catalog_data');
            \Illuminate\Support\Facades\Cache::forget('home_recent_transactions');
            \Illuminate\Support\Facades\Cache::forget('home_recent_purchases');

            // Cleanup local images outside transaction
            foreach ($cleanupImages as $imgUrl) {
                try {
                    UploadHelper::deleteByUrl($imgUrl);
                } catch (\Throwable $imgEx) {
                    Log::warning('Failed to delete game account image during purchase cleanup', [
                        'account_id' => $id,
                        'image_url' => $imgUrl,
                        'error' => $imgEx->getMessage(),
                    ]);
                }
            }

            $returnUrl = $this->safeReturnUrl($request->input('return_url'));

            return response()->json([
                'success' => true,
                'message' => 'Mua tài khoản thành công!',
                'data' => [
                    'new_balance' => $balanceAfter
                ],
                'redirect_url' => route('profile.purchased-account-detail', array_filter([
                    'id' => $history->id,
                    'return_url' => $returnUrl,
                ]))
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

    private function safeReturnUrl(mixed $url): ?string
    {
        return is_string($url) && str_starts_with($url, '/') && !str_starts_with($url, '//') && !str_contains($url, '\\')
            ? $url
            : null;
    }
}
