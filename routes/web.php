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
require __DIR__ . '/admin.php';
require __DIR__ . '/api.php';
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

        Route::get('/purchased-random-accounts', [ProfileController::class, 'purchasedRandomAccounts'])->name('purchased-random-accounts');
        Route::get('/purchased-random-accounts/{batchId}', [ProfileController::class, 'purchasedRandomAccountDetail'])->name('purchased-random-account-detail');

       
        Route::get('/deposit/card', [ProfileController::class, 'depositCard'])->name('deposit-card');
        Route::get('/deposit/atm', [ProfileController::class, 'depositAtm'])->name('deposit-atm');
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
    Route::get('/', [GameCategoryController::class, 'showAll'])->name('show-all');
    Route::get('/group/{slug}', [GameCategoryController::class, 'showGroup'])->name('group');
    Route::get('/{slug}', [GameCategoryController::class, 'index'])->name('index');
});
Route::prefix('account')->name('account.')->group(function () {
    Route::get('/{id}', [GameAccountController::class, 'show'])->name(name: 'show');
    Route::post('/{id}/purchase', [GameAccountController::class, 'purchase'])->middleware('auth')->name('purchase');
});
Route::prefix('service')->name('service.')->group(function () {
    Route::get('/', [GameServiceController::class, 'showAll'])->name('show-all');
    Route::get('/{slug}', [GameServiceController::class, 'show'])->name('show');
    Route::post('/{slug}/order', [ServiceOrderController::class, 'processOrder'])->middleware('auth')->name('order');
});

// Routes for random categories
Route::prefix('random')->name('random.')->group(function () {
    Route::get('/', [RandomCategoryController::class, 'showAll'])->name('show-all');
    Route::get('/account/{id}', [RandomAccountController::class, 'show'])->name('account.show');
    Route::post('/account/{id}/purchase', [RandomAccountController::class, 'purchase'])->middleware('auth')->name('account.purchase');
    Route::get('/{slug}', [RandomCategoryController::class, 'index'])->name('index');
    Route::post('/{slug}/purchase', [RandomCategoryController::class, 'purchase'])->middleware('auth')->name('category.purchase');
});

// Routes for lucky wheel categories
Route::prefix('lucky')->name('lucky.')->group(function () {
    Route::get('/', [LuckyCategoryController::class, 'showAll'])->name('show-all');
    Route::get('/wheel/{slug}', [LuckyCategoryController::class, 'index'])->name('index');
    Route::post('/wheel/{slug}/spin', [LuckyCategoryController::class, 'spin'])->middleware('auth')->name('spin');
});

// Discount code routes
// Discount code routes
Route::post('/discount-code/validate', [DiscountCodeController::class, 'validateCode'])->name('discount.validate');

// News routes
Route::prefix('tin-tuc')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('show');
});
