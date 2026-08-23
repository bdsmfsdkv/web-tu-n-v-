<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UsdtDeposit;
use App\Models\User;
use App\Models\MoneyTransaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckUsdtDeposits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deposit:check-usdt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra lịch sử nạp USDT từ ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $accounts = \App\Models\UsdtAccount::where('is_active', true)->get();

        if ($accounts->isEmpty()) {
            $this->error('Không có tài khoản USDT nào đang hoạt động.');
            return;
        }

        foreach ($accounts as $account) {
            $token = $account->api_token;
            if (empty($token)) continue;

            $url = $account->type === 'binance' 
                ? 'https://api.spay5s.com/historybinance' 
                : 'https://api.spay5s.com/historytrc20';

            try {
                $response = Http::get($url, ['token' => $token]);
                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['status']) && $data['status'] == 200 && isset($data['data'])) {
                        foreach ($data['data'] as $transaction) {
                            $this->processTransaction($transaction);
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('CheckUsdtDeposits Error (Account ' . $account->name . '): ' . $e->getMessage());
            }
        }
        $this->info('Hoàn tất kiểm tra nạp USDT tự động.');
    }

    private function processTransaction($tx)
    {
        $amount = isset($tx['amount']) ? (float)$tx['amount'] : 0;
        $description = $tx['description'] ?? '';
        $transactionID = $tx['transactionID'] ?? '';

        if (empty($transactionID)) return;

        // Bỏ qua nếu đã xử lý giao dịch này
        if (UsdtDeposit::where('transaction_id', $transactionID)->exists()) {
            return;
        }

        // Tìm các yêu cầu đang chờ
        $pendingDeposits = UsdtDeposit::where('status', 'pending')->orderBy('created_at', 'desc')->get();

        foreach ($pendingDeposits as $deposit) {
            $isMatch = false;

            // 1. Nếu có description (Memo của Binance), check xem có chứa mã yêu cầu không
            $simpleMemo = 'Nap' . $deposit->user_id;
            $simpleMemo2 = 'USDT' . $deposit->user_id; // Support old simple memos if any
            
            if (!empty($description)) {
                $descUpper = strtoupper($description);
                if (strpos($descUpper, strtoupper($deposit->request_code)) !== false ||
                    strpos($descUpper, strtoupper($simpleMemo)) !== false ||
                    strpos($descUpper, strtoupper($simpleMemo2)) !== false) {
                    $isMatch = true;
                }
            }

            // 2. Nếu không có mã yêu cầu (TRC20), check khớp đúng số USDT hoặc khớp số VND (đề phòng API trả về tiền Việt)
            if (!$isMatch) {
                // API có thể trả về số USDT lẻ hoặc số VND đã quy đổi. Khớp 1 trong 2.
                if (abs($amount - (float)$deposit->usdt_amount) < 0.01) {
                    $isMatch = true;
                } else if (abs($amount - (float)$deposit->vnd_amount) < 1) {
                    $isMatch = true;
                }
            }

            if ($isMatch) {
                DB::beginTransaction();
                try {
                    $lockedDeposit = UsdtDeposit::where('id', $deposit->id)->lockForUpdate()->first();
                    if (!$lockedDeposit || $lockedDeposit->status !== 'pending' || UsdtDeposit::where('transaction_id', $transactionID)->exists()) {
                        DB::rollBack();
                        break;
                    }

                    $lockedDeposit->status = 'completed';
                    $lockedDeposit->transaction_id = $transactionID;
                    $lockedDeposit->save();

                    // Cộng tiền cho user
                    $user = User::where('id', $lockedDeposit->user_id)->lockForUpdate()->first();
                    if ($user) {
                        $balanceBefore = (float) $user->balance;
                        $user->balance += $lockedDeposit->vnd_amount;
                        $user->total_deposited += $lockedDeposit->vnd_amount;
                        $user->save();

                        // Lưu lịch sử biến động số dư
                        MoneyTransaction::create([
                            'user_id' => $user->id,
                            'type' => 'usdt_deposit',
                            'amount' => $lockedDeposit->vnd_amount,
                            'balance_before' => $balanceBefore,
                            'balance_after' => $user->balance,
                            'description' => 'Nạp tiền qua USDT (Tự động) - ' . $lockedDeposit->request_code,
                            'reference_id' => $lockedDeposit->id,
                            'reference_type' => UsdtDeposit::class,
                            'status' => 'completed',
                        ]);
                    }

                    DB::commit();
                    $this->info("Đã duyệt thành công yêu cầu: {$lockedDeposit->request_code}");
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Lỗi khi duyệt nạp USDT: ' . $e->getMessage());
                }
                break; // Duyệt thành công thì thoát vòng lặp pendingDeposits để check giao dịch API tiếp theo
            }
        }
    }
}
