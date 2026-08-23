<?php

namespace Tests\Feature;

use App\Models\BankAccount;
use App\Models\BankDeposit;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SepayWebhookFeatureTest extends TestCase
{
    use DatabaseTransactions;

    protected string $webhookToken = 'TEST_WEBHOOK_SECRET_KEY_123';

    protected function setUp(): void
    {
        parent::setUp();

        if (function_exists('config_set')) {
            config_set('sepay_token', $this->webhookToken);
            config_set('sepay_enabled', 1);
        }
        config(['sepay.token' => $this->webhookToken]);
    }

    protected function makeUser(string $role = 'member'): User
    {
        return User::create([
            'username' => 'webhook_u_' . uniqid(),
            'password' => bcrypt('secret'),
            'email' => 'webhook_' . uniqid() . '@example.com',
            'balance' => 0,
            'total_deposited' => 0,
            'role' => $role,
        ]);
    }

    protected function makeAccount(string $accountNumber = '216989'): BankAccount
    {
        return BankAccount::create([
            'bank_name' => 'MBBank',
            'account_name' => 'VO DINH KIET',
            'account_number' => $accountNumber,
            'prefix' => 'naptien',
            'is_active' => true,
            'auto_confirm' => true,
            'access_token' => 'SEPAY_PER_BANK_API_TOKEN_XYZ',
            'provider' => BankAccount::PROVIDER_SEPAY,
        ]);
    }

    public function test_webhook_unauthorized_with_wrong_token(): void
    {
        $response = $this->postJson('/api/webhook/sepay', [
            'transferType' => 'in',
            'transferAmount' => 50000,
            'referenceCode' => 'WH_' . uniqid(),
            'content' => 'naptien1',
        ], [
            'Authorization' => 'Apikey WRONG_TOKEN_VALUE',
        ]);

        $response->assertStatus(401);
    }

    public function test_webhook_success_credits_balance_with_valid_syntax(): void
    {
        $user = $this->makeUser();
        $account = $this->makeAccount('ACC_' . uniqid());
        $ref = 'REF_' . uniqid();

        $response = $this->postJson('/api/webhook/sepay', [
            'transferType' => 'in',
            'transferAmount' => 200000,
            'referenceCode' => $ref,
            'content' => 'naptien' . $user->id . ' chuyen tien',
            'accountNumber' => $account->account_number,
            'gateway' => 'MBBank',
        ], [
            'Authorization' => 'Apikey ' . $this->webhookToken,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $user->refresh();
        $this->assertEquals(200000, $user->balance);
        $this->assertEquals(200000, $user->total_deposited);

        $deposit = BankDeposit::where('transaction_id', 'SEPAY-' . $ref)->first();
        $this->assertNotNull($deposit);
        $this->assertEquals(200000, $deposit->amount);
    }

    public function test_webhook_invalid_content_does_not_credit_balance(): void
    {
        $user = $this->makeUser();
        $account = $this->makeAccount('ACC_' . uniqid());
        $ref = 'REF_INVALID_' . uniqid();

        $response = $this->postJson('/api/webhook/sepay', [
            'transferType' => 'in',
            'transferAmount' => 150000,
            'referenceCode' => $ref,
            'content' => 'Chuyen tien khong cu phap hop le',
            'accountNumber' => $account->account_number,
        ], [
            'Authorization' => 'Apikey ' . $this->webhookToken,
        ]);

        $response->assertStatus(422);

        $user->refresh();
        $this->assertEquals(0, $user->balance);
        $this->assertNull(BankDeposit::where('transaction_id', 'SEPAY-' . $ref)->first());
    }

    public function test_bank_account_admin_edit_persists_token_and_provider(): void
    {
        $account = $this->makeAccount('ACC_EDIT_' . uniqid());

        $this->assertEquals('SEPAY_PER_BANK_API_TOKEN_XYZ', $account->access_token);
        $this->assertEquals(BankAccount::PROVIDER_SEPAY, $account->providerName());

        $account->update([
            'access_token' => 'NEW_UPDATED_TOKEN_123',
            'provider' => BankAccount::PROVIDER_SEPAY,
            'sepay_env' => 'sandbox',
        ]);

        $account->refresh();
        $this->assertEquals('NEW_UPDATED_TOKEN_123', $account->access_token);
        $this->assertEquals('sandbox', $account->sepayEnv());
        $this->assertTrue($account->usesSepay());
    }

    public function test_admin_check_config_and_test_auth_endpoints(): void
    {
        $admin = $this->makeUser('admin');
        $account = $this->makeAccount('ACC_TEST_AUTH_' . uniqid());

        // Test check-config endpoint
        $checkRes = $this->actingAs($admin)->postJson(route('admin.bank-accounts.check-config', $account->id));
        $checkRes->assertStatus(200);
        $checkRes->assertJsonStructure([
            'success',
            'all_pass',
            'checks' => ['token', 'bank_account', 'webhook_route', 'authorization', 'prefix', 'database']
        ]);

        // Test test-auth endpoint
        $authRes = $this->actingAs($admin)->postJson(route('admin.bank-accounts.test-auth', $account->id));
        $authRes->assertStatus(200);
        $authRes->assertJson([
            'status' => 'success',
            'no_token' => ['result' => 'PASS'],
            'wrong_token' => ['result' => 'PASS'],
            'valid_token' => ['result' => 'PASS'],
        ]);

        // Test webhook-logs endpoint
        $logsRes = $this->actingAs($admin)->getJson(route('admin.bank-accounts.webhook-logs', $account->id));
        $logsRes->assertStatus(200);
        $logsRes->assertJsonStructure(['success', 'logs']);
    }

    public function test_duplicate_webhook_does_not_credit_twice(): void
    {
        $user = $this->makeUser();
        $account = $this->makeAccount('ACC_DUP_' . uniqid());
        $ref = 'REF_DUP_' . uniqid();

        $payload = [
            'transferType' => 'in',
            'transferAmount' => 50000,
            'referenceCode' => $ref,
            'content' => 'naptien' . $user->id,
            'accountNumber' => $account->account_number,
            'gateway' => 'MBBank',
        ];

        // Lần 1
        $res1 = $this->postJson('/api/webhook/sepay', $payload, [
            'Authorization' => 'Apikey ' . $this->webhookToken,
        ]);
        $res1->assertStatus(200);

        $user->refresh();
        $this->assertEquals(50000, $user->balance);

        // Lần 2 (Duplicate)
        $res2 = $this->postJson('/api/webhook/sepay', $payload, [
            'Authorization' => 'Apikey ' . $this->webhookToken,
        ]);
        $res2->assertStatus(200);
        $res2->assertJson(['message' => 'Transaction already processed']);

        $user->refresh();
        $this->assertEquals(50000, $user->balance);
    }
}
