<?php

namespace Tests\Feature;

use App\Helpers\UploadHelper;
use App\Models\DiscountCode;
use App\Models\GameAccount;
use App\Models\GameCategory;
use App\Models\MoneyTransaction;
use App\Models\PurchasedAccountHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PurchasedAccountLifecycleTest extends TestCase
{
    use DatabaseTransactions;

    protected function makeUser(int $balance = 1000000): User
    {
        return User::create([
            'username' => 'testuser_' . uniqid(),
            'name' => 'Test User ' . uniqid(),
            'email' => 'user_' . uniqid() . '@example.com',
            'password' => bcrypt('password123'),
            'role' => 'member',
            'balance' => $balance,
            'gold' => 0,
            'gem' => 0,
        ]);
    }

    protected function makeCategory(): GameCategory
    {
        return GameCategory::create([
            'name' => 'Category ' . uniqid(),
            'slug' => 'category-' . uniqid(),
            'thumbnail' => 'categories/thumb.png',
            'description' => 'Test Category',
            'active' => true,
        ]);
    }

    public function test_purchase_creates_history_deducts_balance_deletes_account_and_cleans_images()
    {
        Storage::fake('public');
        $thumbPath = 'accounts/thumbnails/test_thumb_' . uniqid() . '.jpg';
        $imgPath = 'accounts/images/test_img_' . uniqid() . '.jpg';
        Storage::disk('public')->put($thumbPath, 'fake-thumb-content');
        Storage::disk('public')->put($imgPath, 'fake-img-content');

        $user = $this->makeUser(1000000);
        $category = $this->makeCategory();

        $account = GameAccount::create([
            'game_category_id' => $category->id,
            'account_name' => 'garena_vip_' . uniqid(),
            'password' => 'secretPass123',
            'thumb' => '/storage/' . $thumbPath,
            'images' => ['/storage/' . $imgPath],
            'details' => [['key' => 'Rank', 'value' => 'Cao Thủ']],
            'note' => 'Acc full thong tin',
            'price' => 300000,
            'status' => 'available',
        ]);

        $accountId = $account->id;
        $orderCode = $account->order_code;

        $response = $this->actingAs($user)->postJson(route('account.purchase', $accountId));
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'new_balance' => 700000
            ],
            'redirect_url' => route('profile.purchased-accounts'),
        ]);

        $user->refresh();
        $this->assertEquals(700000, $user->balance);

        // MoneyTransaction ledger created
        $this->assertDatabaseHas('money_transactions', [
            'user_id' => $user->id,
            'type' => 'purchase',
            'amount' => -300000,
            'reference_id' => $accountId,
        ]);

        // Original GameAccount deleted
        $this->assertDatabaseMissing('game_accounts', [
            'id' => $accountId,
        ]);

        // PurchasedAccountHistory exists
        $history = PurchasedAccountHistory::where('user_id', $user->id)
            ->where('original_game_account_id', $accountId)
            ->first();

        $this->assertNotNull($history);
        $this->assertEquals('garena_vip_' . substr($account->account_name, 11), $history->account_name);
        $this->assertEquals('secretPass123', $history->password);
        $this->assertEquals(300000, (float)$history->price);
        $this->assertEquals($category->name, $history->category_name);
        $this->assertEquals($orderCode, $history->order_code);

        // Images cleaned up from storage
        Storage::disk('public')->assertMissing('accounts/thumbnails/' . basename($thumbPath));
        Storage::disk('public')->assertMissing('accounts/images/' . basename($imgPath));
    }

    public function test_purchase_of_unavailable_account_returns_conflict_json(): void
    {
        $user = $this->makeUser();
        $category = $this->makeCategory();
        $account = GameAccount::create([
            'game_category_id' => $category->id,
            'account_name' => 'sold_' . uniqid(),
            'password' => 'secretPass123',
            'thumb' => 'categories/thumb.png',
            'price' => 300000,
            'status' => 'sold',
        ]);

        $response = $this->actingAs($user)->postJson(route('account.purchase', $account->id));

        $response->assertStatus(409)->assertJson([
            'success' => false,
            'message' => 'Tài khoản này đã được mua hoặc không còn tồn tại.',
        ]);
    }

    public function test_purchased_history_page_and_detail_page_isolation_idor()
    {
        $userA = $this->makeUser(500000);
        $userB = $this->makeUser(500000);
        $category = $this->makeCategory();

        $historyA = PurchasedAccountHistory::create([
            'user_id' => $userA->id,
            'original_game_account_id' => 99991,
            'game_category_id' => $category->id,
            'category_name' => $category->name,
            'order_code' => 'ORD-AAA',
            'account_name' => 'userA_account',
            'password' => 'userA_pass',
            'price' => 100000,
            'purchased_at' => now(),
        ]);

        // User A views own list
        $responseA = $this->actingAs($userA)->get(route('profile.purchased-accounts'));
        $responseA->assertStatus(200);
        $responseA->assertSee('userA_account');
        $responseA->assertSee('userA_pass');

        // User A views own detail
        $detailA = $this->actingAs($userA)->get(route('profile.purchased-account-detail', $historyA->id));
        $detailA->assertStatus(200);
        $detailA->assertSee('userA_account');
        $detailA->assertSee('userA_pass');

        // User B cannot view User A's history detail (IDOR check -> 404)
        $detailB = $this->actingAs($userB)->get(route('profile.purchased-account-detail', $historyA->id));
        $detailB->assertStatus(404);
    }

    public function test_external_images_are_not_deleted()
    {
        $user = $this->makeUser(500000);
        $category = $this->makeCategory();

        $account = GameAccount::create([
            'game_category_id' => $category->id,
            'account_name' => 'ext_acc_' . uniqid(),
            'password' => 'pass123',
            'thumb' => 'https://i.postimg.cc/qq3pynYh/external_thumb.jpg',
            'images' => ['https://i.postimg.cc/8kJvtYgW/external_img.jpg'],
            'price' => 100000,
            'status' => 'available',
        ]);

        $res = $this->actingAs($user)->postJson(route('account.purchase', $account->id));
        $res->assertStatus(200);
        $res->assertJson(['success' => true]);

        $this->assertDatabaseMissing('game_accounts', ['id' => $account->id]);
        $this->assertDatabaseHas('purchased_account_histories', [
            'user_id' => $user->id,
            'original_game_account_id' => $account->id,
        ]);
    }

    public function test_purchase_rollback_when_user_has_insufficient_balance()
    {
        $user = $this->makeUser(50000);
        $category = $this->makeCategory();

        $account = GameAccount::create([
            'game_category_id' => $category->id,
            'account_name' => 'pricey_acc_' . uniqid(),
            'password' => 'pass123',
            'thumb' => 'game-accounts/thumb.png',
            'price' => 200000,
            'status' => 'available',
        ]);

        $res = $this->actingAs($user)->postJson(route('account.purchase', $account->id));
        $res->assertJson(['success' => false]);

        $user->refresh();
        $this->assertEquals(50000, $user->balance);
        $this->assertDatabaseHas('game_accounts', [
            'id' => $account->id,
            'status' => 'available',
        ]);
        $this->assertDatabaseMissing('purchased_account_histories', [
            'original_game_account_id' => $account->id,
        ]);
    }

    public function test_category_context_back_url_and_safe_fallback_navigation()
    {
        $user = $this->makeUser(500000);
        $category1 = $this->makeCategory();
        $category2 = $this->makeCategory();

        $account1 = GameAccount::create([
            'game_category_id' => $category1->id,
            'account_name' => 'acc_cat1_' . uniqid(),
            'password' => 'pass123',
            'thumb' => 'game-accounts/thumb1.png',
            'price' => 100000,
            'status' => 'available',
        ]);

        $account2 = GameAccount::create([
            'game_category_id' => $category2->id,
            'account_name' => 'acc_cat2_' . uniqid(),
            'password' => 'pass123',
            'thumb' => 'game-accounts/thumb2.png',
            'price' => 100000,
            'status' => 'available',
        ]);

        // 1. Context Test Category 1
        $this->get(route('category.index', $category1->slug));
        $resDetail1 = $this->get(route('account.show', $account1->id));
        $resDetail1->assertStatus(200);
        $resDetail1->assertSee(route('category.index', ['slug' => $category1->slug]), false);

        // 2. Context Test Category 2
        $this->get(route('category.index', $category2->slug));
        $resDetail2 = $this->get(route('account.show', $account2->id));
        $resDetail2->assertStatus(200);
        $resDetail2->assertSee(route('category.index', ['slug' => $category2->slug]), false);

        // 3. Open Redirect Attack Protection: external back_url fallback
        $resMalicious = $this->get(route('account.show', ['id' => $account1->id, 'back_url' => 'https://evil-site.com']));
        $resMalicious->assertStatus(200);
        $resMalicious->assertDontSee('https://evil-site.com', false);
    }
}
