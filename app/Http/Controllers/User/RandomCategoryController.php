<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\RandomCategory;
use App\Models\RandomCategoryAccount;
use App\Models\DiscountCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RandomCategoryController extends Controller
{
    public function index(string $slug, Request $request)
    {
        $category = RandomCategory::where("slug", $slug)->firstOrFail();

        // Kiểm tra nếu là category_type == 'account_list' (Loại 2: chọn mua từng acc)
        if ($category->category_type === 'account_list') {
            $accounts = RandomCategoryAccount::where('random_category_id', $category->id);
            if (!$request->filled('status')) {
                $accounts->where('status', 'available');
            }

            if ($request->hasAny(['code', 'price_range', 'price_from', 'price_to', 'status'])) {
                if ($request->filled('code')) {
                    $accounts->where('id', $request->code);
                }
                if ($request->filled('price_range')) {
                    $range = explode('-', $request->price_range);
                    if (count($range) == 2) {
                        $accounts->whereBetween('price', [(float)$range[0], (float)$range[1]]);
                    } else {
                        $accounts->where('price', '>=', (float)$range[0]);
                    }
                } else {
                    if ($request->filled('price_from')) {
                        $accounts->where('price', '>=', (float)$request->price_from);
                    }
                    if ($request->filled('price_to')) {
                        $accounts->where('price', '<=', (float)$request->price_to);
                    }
                }
                if ($request->filled('status')) {
                    $accounts->where('status', $request->status);
                }
            }

            $accounts = $accounts->orderBy('id', 'DESC')->paginate(12)->withQueryString();

            $flashSalePrice = \App\Models\FlashSale::getActivePrice('random', $category->id);
            if ($flashSalePrice !== null) {
                $accounts->each(function($acc) use ($flashSalePrice) {
                    $acc->price = $flashSalePrice;
                });
            }

            $title = mb_strtoupper($category->name, 'UTF-8');
            return view('user.random.category-list', compact('category', 'accounts', 'title', 'flashSalePrice'));
        }

        // Count available accounts
        $availableCount = RandomCategoryAccount::where('random_category_id', $category->id)
            ->where('status', 'available')
            ->count();
            
        // Get sample account to determine price
        $sampleAccount = RandomCategoryAccount::where('random_category_id', $category->id)
            ->where('status', 'available')
            ->first();
            
        $price = $sampleAccount ? $sampleAccount->price : 0;
        
        $flashSalePrice = \App\Models\FlashSale::getActivePrice('random', $category->id);
        if ($flashSalePrice !== null) {
            $price = $flashSalePrice;
        }
        
        $title = mb_strtoupper($category->name, 'UTF-8');
        return view('user.random.category', compact('category', 'availableCount', 'price', 'title', 'flashSalePrice'));
    }

    public function showAll()
    {
        // withCount gộp thống kê vào 1 query thay vì 2 query COUNT cho mỗi danh mục (2N+1).
        $categories = RandomCategory::where('active', true)
            ->withCount([
                'accounts as soldCount' => fn ($query) => $query->where('status', 'sold'),
                'accounts as allAccount',
            ])
            ->get();

        return view('user.random.show-all', compact('categories'));
    }
    
    public function purchase(Request $request, string $slug)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để mua hàng.']);
        }

        try {
            DB::beginTransaction();

            $category = RandomCategory::where("slug", $slug)->firstOrFail();
            $quantity = (int)$request->input('quantity', 1);

            if ($quantity < 1) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng mua không hợp lệ.'
                ]);
            }

            $user = \App\Models\User::whereKey(Auth::id())->lockForUpdate()->firstOrFail();
            $totalSpent = $user->total_spent ?? 0;

            // Lock and get available accounts filtered ngầm bởi min_spent <= user.total_spent
            $accounts = RandomCategoryAccount::where('random_category_id', $category->id)
                ->where('status', 'available')
                ->where('min_spent', '<=', $totalSpent)
                ->inRandomOrder()
                ->lockForUpdate()
                ->limit($quantity)
                ->get();

            if ($accounts->count() < $quantity) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng tài khoản trong kho không đủ để thực hiện giao dịch này.'
                ]);
            }
            
            $flashSalePrice = \App\Models\FlashSale::getActivePrice('random', $category->id);
            if ($flashSalePrice !== null) {
                $accounts->each(function($acc) use ($flashSalePrice) {
                    $acc->price = $flashSalePrice;
                });
            }
            
            $totalPrice = $accounts->sum('price');
            $finalPrice = $totalPrice;
            $discountAmount = 0;
            $discountCode = null;

            // Check discount code if provided (tính theo tổng giá trị giỏ hàng hoặc min_purchase_amount)
            if ($request->filled('discount_code')) {
                $discountCode = DiscountCode::where('code', $request->discount_code)
                    ->where('is_active', '1')
                    ->lockForUpdate()
                    ->first();

                if (!$discountCode) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn']);
                }

                if ($discountCode->expire_date && now() > $discountCode->expire_date) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Mã giảm giá đã hết hạn']);
                }

                if ($discountCode->usage_limit && $discountCode->usage_count >= $discountCode->usage_limit) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Mã giảm giá đã đạt giới hạn sử dụng']);
                }

                if ($discountCode->applicable_to && $discountCode->applicable_to !== 'random_account') {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Mã giảm giá không áp dụng cho danh mục này']);
                }

                if ($discountCode->item_ids) {
                    $itemIds = is_array($discountCode->item_ids) ? $discountCode->item_ids : json_decode($discountCode->item_ids, true);
                    if (!in_array($category->id, $itemIds ?? [])) {
                        DB::rollBack();
                        return response()->json(['success' => false, 'message' => 'Mã giảm giá không áp dụng cho danh mục random này']);
                    }
                }

                if ($discountCode->min_purchase_amount > 0 && $totalPrice < $discountCode->min_purchase_amount) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Giá trị đơn hàng không đủ để áp dụng mã giảm giá này']);
                }

                if ($discountCode->per_user_limit) {
                    $userUsageCount = DB::table('discount_code_usages')
                        ->where('discount_code_id', $discountCode->id)
                        ->where('user_id', $user->id)
                        ->count();
                    if ($userUsageCount >= $discountCode->per_user_limit) {
                        DB::rollBack();
                        return response()->json(['success' => false, 'message' => 'Bạn đã sử dụng mã giảm giá này đủ số lần cho phép']);
                    }
                }

                if ($discountCode->discount_type === 'percentage') {
                    $discountAmount = ($totalPrice * $discountCode->discount_value) / 100;
                    if ($discountCode->max_discount_value && $discountAmount > $discountCode->max_discount_value) {
                        $discountAmount = $discountCode->max_discount_value;
                    }
                } else {
                    $discountAmount = $discountCode->discount_value;
                }

                $finalPrice = $totalPrice - $discountAmount;
                if ($finalPrice < 0) $finalPrice = 0;

                DB::table('discount_codes')->where('id', $discountCode->id)->increment('usage_count');
                
                DB::table('discount_code_usages')->insert([
                    'discount_code_id' => $discountCode->id,
                    'user_id' => $user->id,
                    'context' => 'random_account',
                    'item_id' => $category->id,
                    'original_price' => $totalPrice,
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
                    'message' => 'Số dư không đủ để mua ' . $quantity . ' tài khoản này'
                ]);
            }

            $balanceBefore = $user->balance;
            $balanceAfter = $balanceBefore - $finalPrice;

            DB::table('users')->where('id', $user->id)->update(['balance' => $balanceAfter]);

            $discountPerAccount = $quantity > 0 ? ($discountAmount / $quantity) : 0;
            $batchId = uniqid('ORD-');

            foreach ($accounts as $account) {
                DB::table('random_category_accounts')
                    ->where('id', $account->id)
                    ->update([
                        'status' => 'sold',
                        'buyer_id' => $user->id,
                        'batch_id' => $batchId
                    ]);
                
                $accPrice = $account->price - $discountPerAccount;
                
                DB::table('money_transactions')->insert([
                    'user_id' => $user->id,
                    'type' => 'purchase',
                    'amount' => -$accPrice,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceBefore - $accPrice,
                    'description' => 'Mua tài khoản random từ danh mục ' . $category->name . ' (Đơn: ' . $batchId . ')',
                    'reference_id' => 'RA-' . $account->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $balanceBefore -= $accPrice;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đã mua thành công ' . $quantity . ' tài khoản ngẫu nhiên!',
                'redirect_url' => route('profile.purchased-random-accounts')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Lỗi khi mua danh mục random', [
                'user_id' => Auth::id(),
                'slug' => $slug,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình xử lý đơn hàng. Vui lòng thử lại sau.'
            ], 500);
        }
    }
}
