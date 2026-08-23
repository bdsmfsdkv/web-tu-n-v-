<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\BankDeposit;
use App\Models\MoneyTransaction;
use App\Models\SepayWebhookLog;
use App\Models\User;
use App\Models\AffiliateHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SepayWebhookController extends Controller
{
    /**
     * Xử lý webhook từ SePay gửi về
     *
     * URL: POST /api/webhook/sepay
     */
    public function handle(Request $request)
    {
        $rawAmount = $request->input('transferAmount');
        $content = trim((string) $request->input('content', ''));
        $referenceNumber = trim((string) ($request->input('referenceCode') ?: $request->input('id', '')));
        $accountNumber = trim((string) $request->input('accountNumber', ''));
        $gateway = trim((string) $request->input('gateway', ''));
        $transferType = strtolower(trim((string) $request->input('transferType', '')));
        $ip = $request->ip();

        // Lấy token cấu hình: ưu tiên database config_get('sepay_token'), fallback config('sepay.token') (.env SEPAY_TOKEN)
        $expectedToken = trim((string) (config_get('sepay_token', config('sepay.token', ''))));

        // Bắt buộc xác thực nếu token đã được cấu hình trong hệ thống
        if ($expectedToken !== '') {
            $authHeader = (string) $request->header('Authorization', '');
            if ($authHeader === '') {
                Log::warning('SePay Webhook: Missing Authorization header', ['ip' => $ip]);
                $this->logWebhook($gateway, $accountNumber, $content, $rawAmount, null, $referenceNumber, 'UNAUTHORIZED', 'Missing Authorization header', $ip);
                return response()->json(['success' => false, 'message' => 'Unauthorized: Missing Authorization header'], 401);
            }

            // Hỗ trợ cả Authorization: Apikey <TOKEN> và Authorization: Bearer <TOKEN> hoặc Token thô
            $token = trim(preg_replace('/^(Bearer|Apikey)\s+/i', '', $authHeader));

            if (!hash_equals($expectedToken, $token)) {
                Log::warning('SePay Webhook: Invalid token', ['ip' => $ip]);
                $this->logWebhook($gateway, $accountNumber, $content, $rawAmount, null, $referenceNumber, 'UNAUTHORIZED', 'Invalid token', $ip);
                return response()->json(['success' => false, 'message' => 'Unauthorized: Invalid token'], 401);
            }
        }

        // Lấy dữ liệu giao dịch từ payload SePay
        if (!in_array($transferType, ['in', 'credit', 'money_in', 'incoming', 'deposit'], true)) {
            $this->logWebhook($gateway, $accountNumber, $content, $rawAmount, null, $referenceNumber, 'IGNORED', 'Ignored outgoing transfer', $ip);
            return response()->json(['success' => true, 'message' => 'Ignored outgoing transfer']);
        }

        // Validate amount chặt chẽ: số nguyên dương, tránh float precision & bypass
        if (!is_numeric($rawAmount)) {
            $this->logWebhook($gateway, $accountNumber, $content, 0, null, $referenceNumber, 'INVALID_AMOUNT', 'Invalid amount format', $ip);
            return response()->json(['success' => false, 'message' => 'Invalid amount format'], 400);
        }

        $amountIn = (int) round(floatval($rawAmount));
        if ($amountIn <= 0 || $amountIn > 2000000000) {
            $this->logWebhook($gateway, $accountNumber, $content, $amountIn, null, $referenceNumber, 'INVALID_AMOUNT', 'Invalid amount', $ip);
            return response()->json(['success' => false, 'message' => 'Invalid amount'], 400);
        }

        if (empty($referenceNumber)) {
            $this->logWebhook($gateway, $accountNumber, $content, $amountIn, null, '', 'ERROR', 'Missing transaction id', $ip);
            return response()->json(['success' => false, 'message' => 'Missing transaction id'], 400);
        }

        // Tạo transaction id chuẩn SePay chống trùng
        $prefixId = config('sepay.transaction_id_prefix', 'SEPAY-');
        $transactionId = str_starts_with($referenceNumber, $prefixId) ? $referenceNumber : $prefixId . $referenceNumber;

        // Chống xử lý trùng giao dịch sớm
        if (BankDeposit::where('transaction_id', $transactionId)->exists()) {
            $this->logWebhook($gateway, $accountNumber, $content, $amountIn, null, $referenceNumber, 'DUPLICATE', 'Transaction already processed', $ip);
            return response()->json(['success' => true, 'message' => 'Transaction already processed']);
        }

        // Tìm tài khoản ngân hàng khớp (hoặc lấy prefix mặc định 'naptien')
        $bankAccount = BankAccount::where('account_number', $accountNumber)->first();
        $prefix = $bankAccount->prefix ?? 'naptien';

        $userId = function_exists('get_id_bank') ? get_id_bank($prefix, $content) : 0;

        if ($userId <= 0) {
            Log::warning('SePay Webhook: Không tìm thấy User ID từ nội dung', ['ip' => $ip]);
            $this->logWebhook($gateway, $accountNumber, $content, $amountIn, null, $referenceNumber, 'USER_NOT_FOUND', 'User ID not found in content', $ip);
            return response()->json(['success' => false, 'message' => 'User ID not found in content'], 422);
        }

        try {
            return DB::transaction(function () use ($transactionId, $userId, $amountIn, $content, $accountNumber, $gateway, $bankAccount, $referenceNumber, $ip) {
                // Lock row chống race condition
                if (BankDeposit::where('transaction_id', $transactionId)->lockForUpdate()->exists()) {
                    $this->logWebhook($gateway, $accountNumber, $content, $amountIn, $userId, $referenceNumber, 'DUPLICATE', 'Transaction already processed', $ip);
                    return response()->json(['success' => true, 'message' => 'Transaction already processed']);
                }

                $user = User::where('id', $userId)->lockForUpdate()->first();
                if (!$user) {
                    $this->logWebhook($gateway, $accountNumber, $content, $amountIn, $userId, $referenceNumber, 'USER_NOT_FOUND', 'User not found', $ip);
                    return response()->json(['success' => false, 'message' => 'User not found'], 404);
                }

                $bankName = $gateway ?: ($bankAccount->bank_name ?? 'MBBank');
                $allowedBanks = ['VPBank', 'TPBank', 'VietinBank', 'ACB', 'BIDV', 'MBBank', 'OCB', 'KienLongBank', 'MSB'];
                if (!in_array($bankName, $allowedBanks, true)) {
                    $bankName = 'MBBank';
                }

                BankDeposit::create([
                    'transaction_id' => $transactionId,
                    'user_id' => $userId,
                    'account_number' => $accountNumber ?: ($bankAccount->account_number ?? 'SEPAY'),
                    'amount' => $amountIn,
                    'content' => $content,
                    'bank' => $bankName,
                    'status' => 'completed',
                ]);

                $balanceBefore = (int) $user->balance;
                $user->balance += $amountIn;
                $user->total_deposited += $amountIn;
                $user->save();

                MoneyTransaction::create([
                    'user_id' => $userId,
                    'type' => 'deposit',
                    'amount' => $amountIn,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $user->balance,
                    'description' => "Nạp tiền tự động qua SePay Webhook ({$bankName}) - Mã: {$transactionId}",
                    'reference_id' => $transactionId,
                ]);

                // Hoa hồng Affiliate nếu có
                if ($user->referrer_id) {
                    $referrer = User::where('id', $user->referrer_id)->lockForUpdate()->first();
                    if ($referrer) {
                        $commission = (int) ($amountIn * 0.10);
                        $referrer->balance += $commission;
                        $referrer->total_commission += $commission;
                        $referrer->save();

                        AffiliateHistory::create([
                            'referrer_id' => $referrer->id,
                            'referred_id' => $user->id,
                            'commission_amount' => $commission,
                            'type' => 'deposit',
                            'description' => 'Hoa hồng nạp thẻ từ ' . $user->username
                        ]);
                    }
                }

                $this->logWebhook($bankName, $accountNumber ?: ($bankAccount->account_number ?? 'SEPAY'), $content, $amountIn, $userId, $referenceNumber, 'SUCCESS', 'Deposit processed successfully', $ip);

                return response()->json([
                    'success' => true,
                    'message' => 'Deposit processed successfully',
                    'data' => [
                        'user_id' => $userId,
                        'amount' => $amountIn,
                        'transaction_id' => $transactionId
                    ]
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('SePay Webhook Error: ' . $e->getMessage(), ['ip' => $ip]);
            $this->logWebhook($gateway, $accountNumber, $content, $amountIn, $userId, $referenceNumber, 'ERROR', 'Internal server error: ' . $e->getMessage(), $ip);
            return response()->json(['success' => false, 'message' => 'Internal server error'], 500);
        }
    }

    /**
     * Ghi nhận log webhook an toàn - KHÔNG BAO GIỜ lưu token/secret
     */
    protected function logWebhook(?string $bank, ?string $accountNumber, ?string $content, $amount, ?int $userId, ?string $reference, string $status, ?string $message, ?string $ip): void
    {
        try {
            $parsedAmount = is_numeric($amount) ? (float) $amount : 0;
            SepayWebhookLog::create([
                'bank_name' => substr((string) ($bank ?: 'SePay'), 0, 50),
                'account_number' => substr((string) ($accountNumber ?: ''), 0, 50),
                'content' => substr((string) ($content ?: ''), 0, 255),
                'amount' => $parsedAmount,
                'user_id' => ($userId && $userId > 0) ? $userId : null,
                'reference_code' => substr((string) ($reference ?: ''), 0, 100),
                'status' => $status,
                'message' => substr((string) ($message ?: ''), 0, 255),
                'ip_address' => substr((string) ($ip ?: ''), 0, 45),
            ]);
        } catch (\Throwable $e) {
            // Không làm gián đoạn webhook nếu lỗi log
            Log::error('SePay Log Error: ' . $e->getMessage());
        }
    }
}
