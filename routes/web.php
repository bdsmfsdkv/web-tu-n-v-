<?php
use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\User\CardDepositController;
use App\Http\Controllers\User\GameAccountController;
use App\Http\Controllers\User\GameCategoryController;
use App\Http\Controllers\User\GameServiceController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\LuckyCategoryController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ServiceOrderController;
use App\Http\Controllers\User\RandomCategoryController;
use App\Http\Controllers\User\RandomAccountController;
use App\Http\Controllers\User\WithdrawalController;
use App\Http\Controllers\User\NewsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
require __DIR__ . '/auth.php';
// KHÔNG require routes/api.php ở đây: RouteServiceProvider đã load file đó với prefix
// "api", require thêm lần nữa sẽ đăng ký trùng tên route và làm `route:cache` thất bại.
// Hai URL không có prefix bên dưới được giữ lại nguyên trạng để không phá link callback
// đã cấu hình ở cổng thanh toán.
Route::match(['GET', 'POST'], '/callback/card', [CardDepositController::class, 'handleCallback'])->name('callback.card');
Route::post('/discount-codes/validate', [DiscountCodeController::class, 'validateCode']);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/nhan-xet', [HomeController::class, 'reviews'])->name('reviews');
Route::get('/cau-hoi-thuong-gap', [HomeController::class, 'faq'])->name('faq');
Route::get('/dieu-khoan-su-dung', [HomeController::class, 'terms'])->name('terms');
Route::get('/chinh-sach-bao-mat', [HomeController::class, 'privacy'])->name('privacy');
Route::middleware('auth')->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name(name: 'index');
        Route::get('/change-password', [ProfileController::class, 'viewChangePassword'])->name('change-password');
        Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password.update');

        Route::get('/services-history', [ProfileController::class, 'servicesHistory'])->name('services-history');
        Route::get('/transaction-history', [ProfileController::class, 'transactionHistory'])->name('transaction-history');
        Route::get('/purchased-accounts', [ProfileController::class, 'purchasedAccounts'])->name('purchased-accounts');
        Route::get('/purchased-accounts/{id}', [ProfileController::class, 'purchasedAccountDetail'])->name('purchased-account-detail');

        Route::get('/purchased-random-accounts', [ProfileController::class, 'purchasedRandomAccounts'])->name('purchased-random-accounts');
        Route::get('/purchased-random-accounts/{batchId}', [ProfileController::class, 'purchasedRandomAccountDetail'])->name('purchased-random-account-detail');

       
        Route::get('/deposit/card', [ProfileController::class, 'depositCard'])->name('deposit-card');
        Route::get('/deposit/atm', [ProfileController::class, 'depositAtm'])->name('deposit-atm');
        Route::get('/deposit/atm/check', [ProfileController::class, 'checkDepositAtm'])->name('deposit-atm.check');
        Route::get('/deposit/check-unread', [ProfileController::class, 'checkUnreadDeposit'])->name('deposit.check-unread');
        Route::get('/deposit/usdt', [ProfileController::class, 'depositUsdt'])->name('deposit-usdt');
        Route::post('/deposit/usdt', [ProfileController::class, 'processDepositUsdt']);
        Route::post('/deposit/card', [CardDepositController::class, 'processCardDeposit']);


        Route::get('/withdraw-gold', [ProfileController::class, 'withdrawGold'])->name('withdraw-gold');
        Route::post('/withdraw-gold', [ProfileController::class, 'processWithdrawGold']);
        Route::get('/withdraw-gem', [ProfileController::class, 'withdrawGem'])->name('withdraw-gem');
        Route::post('/withdraw-gem', [ProfileController::class, 'processWithdrawGem']);
        Route::get('/withdrawal-history/{id}', [ProfileController::class, 'getWithdrawalDetail'])
            ->name('withdrawal.detail');

        Route::get('/service-history/{id}', [ProfileController::class, 'getServiceDetail'])
            ->name('service.detail');
        Route::get('/wheels-history', [ProfileController::class, 'luckyWheelHistory'])->name('wheels-history');
        Route::get('/wheel-history/{id}', [ProfileController::class, 'getLuckyWheelDetail'])
            ->name('wheel-history.detail');
        Route::get('/affiliate', [ProfileController::class, 'affiliate'])->name('affiliate');

        Route::prefix('withdraw')->name('withdraw.')->group(function () {
            Route::get('/', [WithdrawalController::class, 'create'])->name('create');
            Route::post('/', [WithdrawalController::class, 'store'])->name('store');
            Route::get('/history', [WithdrawalController::class, 'history'])->name('history');
        });

    });
    
    // Trả góp
    Route::get('/profile/installments', [\App\Http\Controllers\User\InstallmentController::class, 'index'])->name('profile.installments');
    Route::post('/installment/{id}/create', [\App\Http\Controllers\User\InstallmentController::class, 'create'])->name('installment.create');
    Route::post('/installment/{id}/pay', [\App\Http\Controllers\User\InstallmentController::class, 'pay'])->name('installment.pay');
});
Route::prefix('category')->name('category.')->group(function () {
    Route::get('/', fn () => redirect()->route('home'))->name('show-all');
    Route::get('/group', fn () => redirect()->route('home'));
    Route::get('/group/{slug}', [GameCategoryController::class, 'showGroup'])->name('group');
    Route::get('/{slug}', [GameCategoryController::class, 'index'])->name('index');
});
Route::prefix('account')->name('account.')->group(function () {
    Route::get('/', fn () => redirect()->route('home'));
    Route::get('/{id}', [GameAccountController::class, 'show'])->name(name: 'show');
    Route::post('/{id}/purchase', [GameAccountController::class, 'purchase'])->middleware('auth')->name('purchase');
});
Route::prefix('service')->name('service.')->group(function () {
    Route::get('/', fn () => redirect()->route('home'))->name('show-all');
    Route::get('/{slug}', [GameServiceController::class, 'show'])->name('show');
    Route::post('/{slug}/order', [ServiceOrderController::class, 'processOrder'])->middleware('auth')->name('order');
});

// Routes for random categories
Route::prefix('random')->name('random.')->group(function () {
    Route::get('/', fn () => redirect()->route('home'))->name('show-all');
    Route::get('/group', fn () => redirect()->route('home'));
    Route::get('/account/{id}', [RandomAccountController::class, 'show'])->name('account.show');
    Route::post('/account/{id}/purchase', [RandomAccountController::class, 'purchase'])->middleware('auth')->name('account.purchase');
    Route::get('/{slug}', [RandomCategoryController::class, 'index'])->name('index');
    Route::post('/{slug}/purchase', [RandomCategoryController::class, 'purchase'])->middleware('auth')->name('category.purchase');
});

// Routes for lucky wheel categories
Route::prefix('lucky')->name('lucky.')->group(function () {
    Route::get('/', [LuckyCategoryController::class, 'showAll'])->name('show-all');
    Route::get('/wheel/{slug}', [LuckyCategoryController::class, 'index'])->name('index');
    // Giới hạn tần suất để tránh spam quay bằng script (animation mất ~5s nên 30 lượt/phút là dư).
    Route::post('/wheel/{slug}/spin', [LuckyCategoryController::class, 'spin'])
        ->middleware(['auth', 'throttle:30,1'])
        ->name('spin');
});

// Discount code routes
// Discount code routes
Route::post('/discount-code/validate', [DiscountCodeController::class, 'validateCode'])->name('discount.validate');

// News routes
Route::prefix('tin-tuc')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('show');
});

// Route phục vụ ảnh từ storage khi cPanel chưa tạo symbolic link hoặc bị chặn symlink
Route::get('/storage/{path}', function ($path, \Illuminate\Http\Request $request) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }

    $lastModified = filemtime($filePath);
    $etag = '"' . md5($filePath . $lastModified) . '"';

    $ifNoneMatch = $request->header('If-None-Match');
    $ifModifiedSince = $request->header('If-Modified-Since');

    if (($ifNoneMatch && trim($ifNoneMatch) === $etag) ||
        ($ifModifiedSince && strtotime($ifModifiedSince) >= $lastModified)) {
        return response('', 304);
    }

    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $mimeType = match($extension) {
        'webp' => 'image/webp',
        'png' => 'image/png',
        'jpg', 'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'avif' => 'image/avif',
        default => @mime_content_type($filePath) ?: 'application/octet-stream',
    };

    return response()->file($filePath, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000, immutable',
        'ETag' => $etag,
        'Last-Modified' => gmdate('D, d M Y H:i:s', $lastModified) . ' GMT',
    ]);
})->where('path', '.*')->name('storage.file');

// Route hỗ trợ Admin tạo lại storage:link tự động trực tiếp trên web
Route::get('/admin/fix-storage-link', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        $output = \Illuminate\Support\Facades\Artisan::output();
        return response()->json([
            'success' => true,
            'message' => 'Đã chạy storage:link thành công!',
            'output' => $output
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => 'Không thể tạo symlink tự động: ' . $e->getMessage()
        ], 500);
    }
})->middleware(['auth', 'admin'])->name('admin.fix-storage-link');

// Fallback route: redirect any non-existent route to home
Route::fallback(function () {
    return redirect()->route('home');
});

