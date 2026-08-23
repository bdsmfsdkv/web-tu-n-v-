<?php

namespace Tests\Feature;

use App\Models\BankAccount;
use App\Models\BankDeposit;
use App\Models\MoneyTransaction;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Integration test cho command fetch:mb-transactions ở nhánh SePay.
 *
 * - Không gọi API thật: Http::fake() chặn toàn bộ outbound request.
 * - DatabaseTransactions: mọi thay đổi được rollback sau mỗi test.
 */
class FetchSepayTransactionsTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'sepay.enabled' => true,
            'sepay.env' => 'sandbox',
            'sepay.base_url' => 'https://userapi-sandbox.sepay.vn/v2',
            'sepay.token' => 'test-token',
            'sepay.use_since_id' => false,
            'sepay.retries' => 1,
            'sepay.retry_delay_ms' => 0,
        ]);

        if (function_exists('config_set')) {
            config_set('sepay_enabled', 1);
            config_set('sepay_env', 'sandbox');
            config_set('sepay_token', 'test-token');
        }
    }

    protected function makeUser(): User
    {
        return User::create([
            'username' => 'sepay_test_' . uniqid(),
            'password' => bcrypt('secret'),
            'email' => 'sepay_test_' . uniqid() . '@example.test',
            'balance' => 0,
            'total_deposited' => 0,
        ]);
    }

    protected function makeAccount(string $provider): BankAccount
    {
        return BankAccount::create([
            'bank_name' => 'MBBank',
            'account_name' => 'SEPAY TEST',
            'account_number' => '0' . random_int(100000000, 999999999),
            'prefix' => 'naptien',
            'is_active' => true,
            'auto_confirm' => true,
            'access_token' => $provider === BankAccount::PROVIDER_SEPAY ? null : 'spay5s-token',
            'provider' => $provider,
            'sepay_env' => 'sandbox',
        ]);
    }

    protected function fakeSepay(array $rows): void
    {
        Http::fake([
            '*' => Http::response([
                'status' => 'success',
                'data' => $rows,
                'meta' => ['pagination' => ['current_page' => 1, 'total_pages' => 1]],
            ], 200),
        ]);
    }

    public function test_sepay_incoming_transaction_credits_balance_once(): void
    {
        $user = $this->makeUser();
        $account = $this->makeAccount(BankAccount::PROVIDER_SEPAY);
        $reference = 'FT' . uniqid();

        $this->fakeSepay([
            [
                'id' => 5001,
                'reference_number' => $reference,
                'amount_in' => 100000,
                'amount_out' => 0,
                'transfer_type' => 'in',
                'transaction_content' => 'naptien' . $user->id,
                'account_number' => $account->account_number,
                'bank_account_id' => 1,
                'transaction_date' => '2026-08-22 10:00:00',
            ],
            [
                // Giao dịch tiền ra: phải bị bỏ qua.
                'id' => 5002,
                'reference_number' => 'FT-OUT-' . uniqid(),
                'amount_in' => 0,
                'amount_out' => 250000,
                'transfer_type' => 'out',
                'transaction_content' => 'naptien' . $user->id,
                'account_number' => $account->account_number,
                'bank_account_id' => 1,
                'transaction_date' => '2026-08-22 10:05:00',
            ],
        ]);

        $this->artisan('fetch:mb-transactions')->assertExitCode(0);

        $user->refresh();
        $this->assertEquals(100000, $user->balance);
        $this->assertEquals(100000, $user->total_deposited);

        $deposit = BankDeposit::where('transaction_id', 'SEPAY-' . $reference)->first();
        $this->assertNotNull($deposit);
        $this->assertEquals($user->id, $deposit->user_id);
        $this->assertEquals(100000, $deposit->amount);

        $this->assertSame(
            1,
            MoneyTransaction::where('reference_id', 'SEPAY-' . $reference)->where('type', 'deposit')->count()
        );

        // Chạy lại: không được cộng tiền lần hai.
        $this->artisan('fetch:mb-transactions')->assertExitCode(0);

        $user->refresh();
        $this->assertEquals(100000, $user->balance);
        $this->assertSame(
            1,
            MoneyTransaction::where('reference_id', 'SEPAY-' . $reference)->where('type', 'deposit')->count()
        );
    }

    public function test_sepay_content_without_prefix_is_skipped(): void
    {
        $user = $this->makeUser();
        $account = $this->makeAccount(BankAccount::PROVIDER_SEPAY);
        $reference = 'FT' . uniqid();

        $this->fakeSepay([
            [
                'id' => 6001,
                'reference_number' => $reference,
                'amount_in' => 100000,
                'amount_out' => 0,
                'transfer_type' => 'in',
                'transaction_content' => 'CHUYEN KHOAN KHONG CO CU PHAP',
                'account_number' => $account->account_number,
                'transaction_date' => '2026-08-22 10:00:00',
            ],
        ]);

        $this->artisan('fetch:mb-transactions')->assertExitCode(0);

        $user->refresh();
        $this->assertEquals(0, $user->balance);
        $this->assertFalse(BankDeposit::where('transaction_id', 'SEPAY-' . $reference)->exists());
    }

    public function test_sepay_401_does_not_credit_anything(): void
    {
        $user = $this->makeUser();
        $this->makeAccount(BankAccount::PROVIDER_SEPAY);

        Http::fake(['*' => Http::response(['status' => 'error', 'message' => 'Unauthorized'], 401)]);

        $this->artisan('fetch:mb-transactions')->assertExitCode(0);

        $user->refresh();
        $this->assertEquals(0, $user->balance);
    }

    public function test_spay5s_account_still_uses_spay5s_endpoint(): void
    {
        // Tắt các tài khoản khác ngoài DB để tránh gọi SePay của tài khoản khác
        BankAccount::where('provider', '!=', BankAccount::PROVIDER_SPAY5S)->update(['is_active' => false]);

        $user = $this->makeUser();
        $account = $this->makeAccount(BankAccount::PROVIDER_SPAY5S);
        $reference = 'SPAY' . uniqid();

        Http::fake([
            'api.spay5s.com/*' => Http::response([
                'status' => 2,
                'data' => [
                    [
                        'magiaodich' => $reference,
                        'sotien' => 30000,
                        'noidung' => 'naptien' . $user->id,
                    ],
                ],
            ], 200),
            '*' => Http::response([], 500),
        ]);

        $this->artisan('fetch:mb-transactions')->assertExitCode(0);

        Http::assertSent(fn ($request) => str_contains($request->url(), 'api.spay5s.com/historymbbank'));
        Http::assertNotSent(fn ($request) => str_contains($request->url(), 'sepay.vn'));

        $user->refresh();
        $this->assertEquals(30000, $user->balance);

        // Mã giao dịch SPAY5S giữ nguyên, không bị thêm prefix SEPAY-.
        $this->assertTrue(BankDeposit::where('transaction_id', $reference)->exists());
        $this->assertSame($account->account_number, BankDeposit::find($reference)->account_number);
    }

    public function test_sepay_account_is_ignored_when_integration_disabled(): void
    {
        config(['sepay.enabled' => false]);
        if (function_exists('config_set')) {
            config_set('sepay_enabled', 0);
        }

        $user = $this->makeUser();
        $this->makeAccount(BankAccount::PROVIDER_SEPAY);

        Http::fake(['*' => Http::response([], 500)]);

        $this->artisan('fetch:mb-transactions')->assertExitCode(0);

        Http::assertNotSent(fn ($request) => str_contains($request->url(), 'sepay.vn'));

        $user->refresh();
        $this->assertEquals(0, $user->balance);
    }
}
