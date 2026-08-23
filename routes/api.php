<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CardDepositController;
use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\Api\SepayWebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Tên route phải khác bản không có tiền tố /api khai báo trong web.php, nếu không
// route:cache sẽ báo trùng tên và không cache được.
Route::match(['GET', 'POST'], '/callback/card', [CardDepositController::class, 'handleCallback'])->name('api.callback.card');

// Discount code validation
Route::post('/discount-codes/validate', [DiscountCodeController::class, 'validateCode']);

// SePay Webhook
Route::post('/webhook/sepay', [SepayWebhookController::class, 'handle'])->name('api.webhook.sepay');
