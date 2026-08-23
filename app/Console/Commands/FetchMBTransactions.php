<?php

namespace App\Console\Commands;

use App\Models\BankDeposit;
use App\Models\BankAccount;
use App\Models\User;
use App\Models\MoneyTransaction;
use App\Services\Bank\SepayApiException;
use App\Services\Bank\SepayProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class FetchMBTransactions extends Command
{
    protected $signature = 'fetch:mb-transactions';
    protected $description = 'Fetch new transactions from bank accounts via SPAY5S / SePay API';

    public function handle()
    {
        $this->info('===== Bắt đầu quét giao dịch ngân hàng =====');

        $sepay = app(SepayProvider::class);
        $hasProviderColumn = Schema::hasColumn('bank_accounts', 'provider');
        $sepayEnabled = $hasProviderColumn && $sepay->isEnabled();

        // Lấy tất cả tài khoản ngân hàng có tự động cộng tiền
        $query = BankAccount::where('auto_confirm', true)
            ->where('is_active', true);

        if ($sepayEnabled) {
            // Tài khoản SePay có thể dùng token chung từ .env nên không bắt buộc access_token.
            $query->where(function ($q) {
                $q->whereNotNull('access_token')
                    ->orWhere('provider', BankAccount::PROVIDER_SEPAY);
            });
        } else {
            $query->whereNotNull('access_token');
        }

        $bankAccounts = $query->get();

        if ($bankAccounts->isEmpty()) {
            $this->warn('Không có tài khoản ngân hàng nào được cấu hình tự động cộng tiền.');
            return;
        }

        $this->info('Tìm thấy ' . $bankAccounts->count() . ' tài khoản ngân hàng cần quét.');
        if ($sepayEnabled) {
            $this->info('SePay: ĐANG BẬT (môi trường: ' . $sepay->environment() . ')');
        }
        $totalProcessed = 0;

        foreach ($bankAccounts as $bankAccount) {
            $useSepay = $hasProviderColumn && $bankAccount->usesSepay();

            $this->info('------------------------------');
            $this->info('Provider: ' . ($useSepay ? 'SePay' : 'SPAY5S'));
            $this->info('Account: ' . $bankAccount->bank_name . ' - ' . $bankAccount->account_number);

            if ($useSepay && !$sepay->isEnabled()) {
                $this->warn('Tài khoản được cấu hình SePay nhưng SEPAY_ENABLED=false. Bỏ qua.');
                continue;
            }

            // Sử dụng access_token riêng của mỗi tài khoản
            if (!$useSepay && empty($bankAccount->access_token)) {
                $this->error('Tài khoản ' . $bankAccount->bank_name . ' chưa được cấu hình Access Token.');
                continue;
            }

            try {
                $transactions = [];

                if ($useSepay) {
                    // ---------- Nhánh SePay API v2 ----------
                    try {
                        $transactions = $sepay->fetchTransactions($bankAccount);
                    } catch (SepayApiException $e) {
                        $this->error("Lỗi SePay ({$bankAccount->bank_name}): " . $e->getMessage());
                        Log::warning('SePay fetch failed', [
                            'bank_account_id' => $bankAccount->id,
                            'env' => $sepay->environment(),
                            'http_status' => $e->httpStatus(),
                            'reason' => $e->getMessage(),
                        ]);
                        continue;
                    }
                } else {
                    // ---------- Nhánh SPAY5S (giữ nguyên) ----------
                    $bankName = strtolower(trim($bankAccount->bank_name));
                    $apiUrl = '';

                    if (in_array($bankName, ['vcb', 'vietcombank'])) {
                        $apiUrl = 'https://api.spay5s.com/historyapivcb';
                    } elseif (in_array($bankName, ['viettin', 'vietinbank', 'viettinbank'])) {
                        $apiUrl = 'https://api.spay5s.com/historyapiviettin';
                    } elseif (in_array($bankName, ['mb', 'mbbank'])) {
                        $apiUrl = 'https://api.spay5s.com/historymbbank';
                    } elseif ($bankName === 'acb') {
                        $apiUrl = 'https://api.spay5s.com/historyapiacb';
                    } elseif ($bankName === 'ocb') {
                        $apiUrl = 'https://api.spay5s.com/historyocb';
                    } else {
                        $this->warn("Ngân hàng {$bankAccount->bank_name} không được hỗ trợ API tự động qua spay5s.");
                        continue;
                    }

                    $response = Http::get($apiUrl, [
                        'token' => $bankAccount->access_token
                    ]);

                    if (!$response->successful()) {
                        $this->error("Không thể lấy dữ liệu {$bankAccount->bank_name}: " . $response->status() . ' - ' . $response->body());
                        continue;
                    }

                    $responseData = $response->json();

                    if (isset($responseData['status']) && $responseData['status'] == 2) {
                        $transactions = $responseData['data'] ?? [];
                    } elseif (is_array($responseData) && !isset($responseData['status'])) {
                        // Handle raw array format
                        foreach ($responseData as $item) {
                            $transactions[] = [
                                'magiaodich' => $item['reference'] ?? $item['magiaodich'] ?? ($item['id'] ?? ''),
                                'sotien' => $item['sotien'] ?? (isset($item['transactionAmountCurrency']['amount']) ? floatval($item['transactionAmountCurrency']['amount']) : ($item['amount'] ?? 0)),
                                'noidung' => $item['noidung'] ?? $item['description'] ?? '',
                            ];
                        }
                    } else {
                        $this->error("Lỗi API {$bankAccount->bank_name}: " . ($responseData['msg'] ?? 'Unknown error'));
                        continue;
                    }
                }

                $processedCount = 0;
                $skippedCount = 0;
                $failedCount = 0;

                $this->info("Tìm thấy " . count($transactions) . " giao dịch từ {$bankAccount->bank_name}.");

                foreach ($transactions as $transaction) {
                    $prefix = $bankAccount->prefix ?? 'naptien';
                    $content = $transaction['noidung'] ?? '';
                    $amount_in = floatval($transaction['sotien'] ?? 0);
                    $reference_number = $transaction['magiaodich'] ?? '';

                    $id = get_id_bank($prefix, $content);

                    if ($amount_in <= 0) {
                        $skippedCount++;
                        continue;
                    }

                    if ($reference_number === '') {
                        $this->line('Bỏ qua giao dịch không có mã giao dịch.');
                        $skippedCount++;
                        continue;
                    }

                    if ($id == 0) {
                        $this->line('Bỏ qua giao dịch không tìm thấy mã người dùng: ' . $content);
                        $skippedCount++;
                        continue;
                    }

                    if (BankDeposit::where('transaction_id', $reference_number)->exists()) {
                        $this->line('Bỏ qua giao dịch đã xử lý: ' . $reference_number);
                        $skippedCount++;
                        continue;
                    }
                    if (!User::find($id)) {
                        $this->line("Bỏ qua do không tìm thấy user ID=$id (Nội dung: $content)");
                        $skippedCount++;
                        continue;
                    }

                    try {
                        DB::beginTransaction();

                        $bankDeposit = BankDeposit::updateOrCreate(
                            ['transaction_id' => $reference_number],
                            [
                                'user_id' => $id,
                                'account_number' => $bankAccount->account_number,
                                'amount' => $amount_in,
                                'content' => $content,
                                'bank' => $bankAccount->bank_name,
                                'status' => 'completed',
                            ]
                        );

                        if ($bankDeposit->wasRecentlyCreated) {
                            $user = User::find($id);

                            if (!$user) {
                                $this->error("Không tìm thấy người dùng với ID: $id");
                                DB::rollBack();
                                continue;
                            }

                            $balanceBefore = $user->balance;
                            $user->balance += $amount_in;
                            $user->total_deposited += $amount_in;
                            $user->save();

                            MoneyTransaction::create([
                                'user_id' => $id,
                                'type' => 'deposit',
                                'amount' => $amount_in,
                                'balance_before' => $balanceBefore,
                                'balance_after' => $user->balance,
                                'description' => "Nạp tiền qua {$bankAccount->bank_name} - Mã giao dịch: {$reference_number}",
                                'reference_id' => $reference_number
                            ]);

                            // Affiliate Commission Logic (10%)
                            if ($user->referrer_id) {
                                $referrer = User::find($user->referrer_id);
                                if ($referrer) {
                                    $commission = (int) ($amount_in * 0.10);
                                    $refPrevBalance = $referrer->balance;
                                    $referrer->balance += $commission;
                                    $referrer->total_commission += $commission;
                                    $referrer->save();

                                    \App\Models\AffiliateHistory::create([
                                        'referrer_id' => $referrer->id,
                                        'referred_id' => $user->id,
                                        'commission_amount' => $commission,
                                        'type' => 'deposit',
                                        'description' => 'Hoa hồng nạp thẻ từ ' . $user->username
                                    ]);

                                    MoneyTransaction::create([
                                        'user_id' => $referrer->id,
                                        'type' => 'affiliate',
                                        'amount' => $commission,
                                        'balance_before' => $refPrevBalance,
                                        'balance_after' => $referrer->balance,
                                        'description' => 'Hoa hồng 10% từ người được giới thiệu (' . $user->username . ')',
                                    ]);
                                }
                            }

                            $this->info("► Cộng thành công " . number_format($amount_in) . "đ cho người dùng #$id");
                            $processedCount++;
                            $totalProcessed++;
                        }

                        DB::commit();

                    } catch (\Exception $e) {
                        DB::rollBack();
                        $failedCount++;
                        $this->error("Lỗi xử lý giao dịch {$bankAccount->bank_name}: " . $e->getMessage());
                        continue;
                    }
                }

                // Chỉ lưu con trỏ since_id khi toàn bộ giao dịch đã xử lý xong không lỗi.
                if ($useSepay && $failedCount === 0) {
                    $sepay->rememberSinceId($bankAccount, $transactions);
                }

                $this->info("Kết quả {$bankAccount->bank_name}: Đã xử lý {$processedCount} giao dịch, bỏ qua {$skippedCount} giao dịch.");
            } catch (\Exception $e) {
                $this->error('Lỗi kết nối API: ' . $e->getMessage());
            }
        }

        $this->info('===== Kết thúc quét giao dịch ngân hàng =====');
        $this->info("Tổng số giao dịch đã xử lý: $totalProcessed");
    }
}
