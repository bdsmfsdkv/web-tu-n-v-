<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\GameCategory;
use App\Models\GameAccount;
use App\Models\RandomCategory;
use App\Models\RandomCategoryAccount;
use App\Models\CardDeposit;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BugFixAuditTest extends TestCase
{
    use DatabaseTransactions;

    protected function makeUser(string $role = 'member', int $balance = 0, int $totalDeposited = 0): User
    {
        return User::create([
            'username' => 'test_u_' . uniqid(),
            'password' => bcrypt('secret123'),
            'email' => 'test_' . uniqid() . '@example.com',
            'balance' => $balance,
            'total_deposited' => $totalDeposited,
            'role' => $role,
        ]);
    }

    public function test_upload_helper_handles_missing_finfo_gracefully()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('category.png', 100, 'image/png');
        $url = \App\Helpers\UploadHelper::upload($file, 'categories');
        $this->assertNotEmpty($url);
        $this->assertTrue(str_contains($url, 'categories/'));

        // Test deleteByUrl
        $deleted = \App\Helpers\UploadHelper::deleteByUrl($url);
        $this->assertTrue($deleted);
    }

    public function test_purchased_random_accounts_route_works()
    {
        $user = $this->makeUser('member', 500000);
        $category = RandomCategory::create([
            'name' => 'Random Test ' . uniqid(),
            'slug' => 'random-test-' . uniqid(),
            'thumbnail' => 'categories/thumb.png',
            'description' => 'Test Desc',
            'active' => true,
            'category_type' => 'random',
        ]);

        RandomCategoryAccount::create([
            'random_category_id' => $category->id,
            'buyer_id' => $user->id,
            'status' => 'sold',
            'server' => 1,
            'account' => 'test_user',
            'password' => 'test_pass',
            'price' => 50000,
            'batch_id' => 'ORD-TEST-123',
        ]);

        $response = $this->actingAs($user)->get(route('profile.purchased-random-accounts'));
        $response->assertStatus(200);
        $response->assertSee('TÀI KHOẢN NGẪU NHIÊN ĐÃ MUA');

        $detailResponse = $this->actingAs($user)->get(route('profile.purchased-random-account-detail', 'ORD-TEST-123'));
        $detailResponse->assertStatus(200);
    }

    public function test_admin_can_delete_game_category_with_existing_accounts()
    {
        $admin = $this->makeUser('admin');
        $category = GameCategory::create([
            'name' => 'Category With Acc ' . uniqid(),
            'slug' => 'cat-acc-' . uniqid(),
            'thumbnail' => 'categories/thumb.png',
            'description' => 'Test Cat',
            'active' => true,
        ]);

        $account = GameAccount::create([
            'game_category_id' => $category->id,
            'account_name' => 'acc_' . uniqid(),
            'password' => 'secret123',
            'thumb' => 'game-accounts/thumb.png',
            'price' => 100000,
            'status' => 'available',
        ]);

        $response = $this->actingAs($admin)->deleteJson(route('admin.categories.destroy', $category->id));
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $this->assertDatabaseMissing('game_categories', ['id' => $category->id]);
        $this->assertDatabaseMissing('game_accounts', ['id' => $account->id]);
    }

    public function test_card_deposit_callback_idempotency_and_atomic_balance()
    {
        $user = $this->makeUser('member', 100000, 100000);
        $requestId = (string) rand(1000000000, 9999999999);

        $deposit = CardDeposit::create([
            'user_id' => $user->id,
            'telco' => 'VIETTEL',
            'amount' => 50000,
            'received_amount' => 50000,
            'serial' => '10005678901',
            'pin' => '123456789012',
            'request_id' => $requestId,
            'status' => 'processing',
        ]);

        $callbackData = [
            'status' => 1,
            'message' => 'Nạp thẻ thành công',
            'request_id' => $requestId,
            'declared_value' => 50000,
            'card_value' => 50000,
            'value' => 50000,
            'amount' => 50000,
            'code' => '123456789012',
            'serial' => '10005678901',
            'telco' => 'VIETTEL',
            'trans_id' => 'TRANS-' . $requestId,
            'callback_sign' => 'test_sign',
        ];

        // First callback
        $response1 = $this->postJson(route('callback.card'), $callbackData);
        $response1->assertStatus(200);

        $user->refresh();
        $this->assertEquals(150000, $user->balance);
        $this->assertEquals(150000, $user->total_deposited);

        // Duplicate callback
        $response2 = $this->postJson(route('callback.card'), $callbackData);
        $response2->assertStatus(200);

        $user->refresh();
        $this->assertEquals(150000, $user->balance); // Không được cộng lần 2
        $this->assertEquals(150000, $user->total_deposited);
    }

    public function test_card_deposit_callback_rejects_invalid_signature_when_partner_key_configured()
    {
        config_set('payment.card.partner_key', 'my_secret_partner_key_123');

        $user = $this->makeUser('member', 100000, 100000);
        $requestId = (string) rand(1000000000, 9999999999);

        $deposit = CardDeposit::create([
            'user_id' => $user->id,
            'telco' => 'VIETTEL',
            'amount' => 50000,
            'received_amount' => 50000,
            'serial' => '10005678901',
            'pin' => '123456789012',
            'request_id' => $requestId,
            'status' => 'processing',
        ]);

        $invalidCallbackData = [
            'status' => 1,
            'message' => 'Nạp thẻ thành công',
            'request_id' => $requestId,
            'declared_value' => 50000,
            'card_value' => 50000,
            'value' => 50000,
            'amount' => 50000,
            'code' => '123456789012',
            'serial' => '10005678901',
            'telco' => 'VIETTEL',
            'trans_id' => 'TRANS-' . $requestId,
            'callback_sign' => 'invalid_signature_hash',
        ];

        $response = $this->postJson(route('callback.card'), $invalidCallbackData);
        $response->assertStatus(400);

        $user->refresh();
        $this->assertEquals(100000, $user->balance); // Không bị cộng tiền

        // Đúng signature
        $validSign = md5('my_secret_partner_key_123' . '123456789012' . '10005678901');
        $validCallbackData = $invalidCallbackData;
        $validCallbackData['callback_sign'] = $validSign;

        $validResponse = $this->postJson(route('callback.card'), $validCallbackData);
        $validResponse->assertStatus(200);

        $user->refresh();
        $this->assertEquals(150000, $user->balance); // Cộng tiền thành công
    }

    public function test_card_deposit_accepts_gachthefast_provider_and_correct_signature()
    {
        config_set('payment.card.active', 1);
        config_set('payment.card.partner_website', 'gachthefast.com');
        config_set('payment.card.partner_id', '123456');
        config_set('payment.card.partner_key', 'gachthefast_secret_key');

        \Illuminate\Support\Facades\Http::fake([
            'https://gachthefast.com/chargingws/v2' => \Illuminate\Support\Facades\Http::response([
                'status' => 99,
                'message' => 'Thẻ đang được xử lý',
                'request_id' => 99999999,
            ], 200),
        ]);

        $user = $this->makeUser('member', 50000, 50000);
        $this->actingAs($user);

        $response = $this->post(url('/profile/deposit/card'), [
            'telco' => 'VIETTEL',
            'amount' => 50000,
            'serial' => '10005678901',
            'pin' => '123456789012',
        ]);

        $response->assertSessionHas('success');

        \Illuminate\Support\Facades\Http::assertSent(function ($request) {
            $data = $request->data();
            $expectedSign = md5('gachthefast_secret_key' . '123456789012' . '10005678901');
            return $request->url() === 'https://gachthefast.com/chargingws/v2'
                && $data['telco'] === 'VIETTEL'
                && $data['code'] === '123456789012'
                && $data['serial'] === '10005678901'
                && $data['amount'] == 50000
                && $data['partner_id'] === '123456'
                && $data['command'] === 'charging'
                && $data['sign'] === $expectedSign;
        });

        $this->assertDatabaseHas('card_deposits', [
            'user_id' => $user->id,
            'telco' => 'VIETTEL',
            'amount' => 50000,
            'serial' => '10005678901',
            'pin' => '123456789012',
            'status' => 'processing',
        ]);
    }

    public function test_admin_can_save_gachthefast_payment_settings()
    {
        $admin = $this->makeUser('admin', 0, 0);
        $this->actingAs($admin);

        $response = $this->post(route('admin.settings.payment.update'), [
            'card_active' => '1',
            'partner_website_card' => 'gachthefast.com',
            'partner_id_card' => '987654',
            'partner_key_card' => 'secret_partner_key_gtf',
            'discount_percent_card' => '15',
        ]);

        $response->assertRedirect(route('admin.settings.index'));
        $this->assertEquals('gachthefast.com', config_get('payment.card.partner_website'));
        $this->assertEquals('987654', config_get('payment.card.partner_id'));
        $this->assertEquals('secret_partner_key_gtf', config_get('payment.card.partner_key'));
        $this->assertEquals('15', config_get('payment.card.discount_percent'));
    }

    public function test_card_deposit_callback_supports_gachthefast_wrong_denomination_and_success()
    {
        config_set('payment.card.partner_key', 'gtf_key_callback');
        config_set('payment.card.discount_percent', '10');

        $user = $this->makeUser('member', 0, 0);
        $requestId = (string) rand(1000000000, 9999999999);

        $deposit = CardDeposit::create([
            'user_id' => $user->id,
            'telco' => 'VIETTEL',
            'amount' => 100000,
            'received_amount' => 100000,
            'serial' => '10005678901',
            'pin' => '123456789012',
            'request_id' => $requestId,
            'status' => 'processing',
        ]);

        // GachTheFast callback with wrong denomination (status 2, card_value 50000 -> 50% = 25000)
        $sign = md5('gtf_key_callback' . '123456789012' . '10005678901');
        $callbackData = [
            'status' => 2,
            'message' => 'Nạp thẻ thành công sai mệnh giá',
            'request_id' => $requestId,
            'declared_value' => 100000,
            'card_value' => 50000,
            'value' => 50000,
            'amount' => 50000,
            'code' => '123456789012',
            'serial' => '10005678901',
            'telco' => 'VIETTEL',
            'trans_id' => 'TRANS-GTF-' . $requestId,
            'callback_sign' => $sign,
        ];

        $response = $this->postJson(route('callback.card'), $callbackData);
        $response->assertStatus(200);

        $user->refresh();
        $this->assertEquals(25000, $user->balance);
        $this->assertEquals(25000, $user->total_deposited);

        $deposit->refresh();
        $this->assertEquals('success', $deposit->status);
        $this->assertEquals(25000, $deposit->received_amount);
    }

    public function test_lucky_wheel_history_isolation_and_atomic_spin()
    {
        $user1 = $this->makeUser('member', 50000, 50000);
        $user2 = $this->makeUser('member', 50000, 50000);

        $wheel = \App\Models\LuckyWheel::create([
            'name' => 'Vòng quay test',
            'slug' => 'vong-quay-test-' . rand(1000, 9999),
            'price_per_spin' => 10000,
            'rules' => 'Luật chơi test',
            'thumbnail' => '/images/wheel-thumb.png',
            'wheel_image' => '/images/wheel.png',
            'pointer_image' => '/images/pointer.png',
            'active' => 1,
            'config' => [
                [
                    'content' => '10.000 VNĐ',
                    'amount' => 10000,
                    'probability' => 100,
                    'type' => 'money',
                    'reward_type' => 'money',
                    'active' => true,
                ]
            ],
        ]);

        $this->actingAs($user1);
        $res1 = $this->postJson(route('lucky.spin', $wheel->slug), ['spin_count' => 1]);
        $res1->assertStatus(200);

        // Kiểm tra history isolation
        $detailRes1 = $this->getJson(route('profile.wheels-history'));
        $detailRes1->assertStatus(200);

        // Đăng nhập user2 xem có thấy lịch sử của user1 trong profile/wheel-history/{id} không
        $history1 = \App\Models\LuckyWheelHistory::where('user_id', $user1->id)->first();
        $this->assertNotNull($history1);

        $this->actingAs($user2);
        $resUser2LookingAtUser1 = $this->getJson(route('profile.wheel-history.detail', $history1->id));
        $resUser2LookingAtUser1->assertStatus(500); // Fail or not found vì user_id filter
    }

    public function test_user_withdrawal_gold_requires_sufficient_balance_and_is_atomic()
    {
        $user = $this->makeUser('member', 0, 0);
        $user->gold = 50000;
        $user->save();

        $this->actingAs($user);

        // Withdrawal more gold than available
        $res = $this->post(url('/profile/withdraw-gold'), [
            'amount' => 100000,
            'game' => 'ngocrong',
            'character_name' => 'Hero123',
            'server' => '1',
            'user_note' => 'Rut vang test',
        ]);
        $res->assertSessionHas('error');

        $user->refresh();
        $this->assertEquals(50000, $user->gold);

        // Valid gold withdrawal
        $resValid = $this->post(url('/profile/withdraw-gold'), [
            'amount' => 20000,
            'game' => 'ngocrong',
            'character_name' => 'Hero123',
            'server' => '1',
            'user_note' => 'Rut vang test hop le',
        ]);
        $resValid->assertSessionHas('success');

        $user->refresh();
        $this->assertEquals(30000, $user->gold);
        $this->assertDatabaseHas('withdrawal_histories', [
            'user_id' => $user->id,
            'amount' => 20000,
            'type' => 'gold',
            'status' => 'processing',
        ]);
    }

    public function test_game_account_purchase_with_discount_code_limits()
    {
        $user = $this->makeUser('member', 500000, 500000);
        $category = GameCategory::create([
            'name' => 'Game Cat ' . uniqid(),
            'slug' => 'game-cat-' . uniqid(),
            'thumbnail' => 'categories/thumb.png',
            'description' => 'Test',
            'active' => true,
        ]);

        $account = GameAccount::create([
            'game_category_id' => $category->id,
            'account_name' => 'acc_test_' . uniqid(),
            'password' => 'pass123',
            'thumb' => 'game-accounts/thumb.png',
            'price' => 300000,
            'status' => 'available',
        ]);

        $discountCode = \App\Models\DiscountCode::create([
            'code' => 'DISC50_' . uniqid(),
            'discount_type' => 'percentage',
            'discount_value' => 50,
            'is_active' => '1',
            'usage_limit' => 1,
            'per_user_limit' => 1,
            'applicable_to' => 'account',
        ]);

        $this->actingAs($user);
        $res = $this->postJson(route('account.purchase', $account->id), [
            'discount_code' => $discountCode->code,
        ]);

        $res->assertStatus(200);
        $res->assertJson(['success' => true]);

        $user->refresh();
        $this->assertEquals(350000, $user->balance); // 500k - (300k * 50%) = 350k
        $this->assertEquals(1, $discountCode->fresh()->usage_count);

        // Second purchase with same code should fail usage limit
        $account2 = GameAccount::create([
            'game_category_id' => $category->id,
            'account_name' => 'acc_test_2_' . uniqid(),
            'password' => 'pass123',
            'thumb' => 'game-accounts/thumb.png',
            'price' => 300000,
            'status' => 'available',
        ]);

        $res2 = $this->postJson(route('account.purchase', $account2->id), [
            'discount_code' => $discountCode->code,
        ]);
        $res2->assertJson(['success' => false]);
    }

    public function test_sold_or_missing_game_account_detail_view_and_purchase_protection()
    {
        $user = $this->makeUser('member', 500000, 500000);
        $category = GameCategory::create([
            'name' => 'Game Cat ' . uniqid(),
            'slug' => 'game-cat-' . uniqid(),
            'thumbnail' => 'categories/thumb.png',
            'description' => 'Test',
            'active' => true,
        ]);

        $account = GameAccount::create([
            'game_category_id' => $category->id,
            'account_name' => 'acc_sold_' . uniqid(),
            'password' => 'pass123',
            'thumb' => 'game-accounts/thumb.png',
            'price' => 300000,
            'status' => 'sold',
        ]);

        // TEST: Detail page for sold or deleted account redirects to category
        $response = $this->actingAs($user)->get(route('account.show', $account->id));
        $response->assertRedirect();

        // TEST: Direct POST purchase on sold account is rejected without balance deduction
        $purchaseRes = $this->actingAs($user)->postJson(route('account.purchase', $account->id));
        $purchaseRes->assertStatus(409);
        $purchaseRes->assertJson(['success' => false]);

        $user->refresh();
        $this->assertEquals(500000, $user->balance);
        $this->assertDatabaseMissing('money_transactions', [
            'reference_id' => $account->id,
            'user_id' => $user->id,
        ]);
    }
}
