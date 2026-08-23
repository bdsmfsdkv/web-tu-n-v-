<?php

namespace Tests\Unit;

use App\Models\BankAccount;
use App\Services\Bank\SepayApiException;
use App\Services\Bank\SepayProvider;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Test cho SePay adapter. KHÔNG gọi API SePay thật: toàn bộ dùng Http::fake().
 */
class SepayProviderTest extends TestCase
{
    protected function config(array $overrides = []): array
    {
        return array_merge([
            'enabled' => true,
            'env' => 'sandbox',
            'base_urls' => [
                'sandbox' => 'https://userapi-sandbox.sepay.vn/v2',
                'production' => 'https://userapi.sepay.vn/v2',
            ],
            'base_url' => null,
            'token' => 'test-token',
            'limit' => 50,
            'max_pages' => 3,
            'timeout' => 5,
            'connect_timeout' => 5,
            'retries' => 1,
            'retry_delay_ms' => 0,
            'transaction_id_prefix' => 'SEPAY-',
            'transaction_id_source' => 'auto',
            'filter_account_number' => true,
            'use_since_id' => false,
            'cursor_store' => 'array',
        ], $overrides);
    }

    protected function provider(array $overrides = []): SepayProvider
    {
        return new SepayProvider($this->config($overrides));
    }

    protected function account(array $attributes = []): BankAccount
    {
        $account = new BankAccount(array_merge([
            'bank_name' => 'MBBank',
            'account_name' => 'TEST',
            'account_number' => '0123456789',
            'prefix' => 'naptien',
            'access_token' => null,
        ], $attributes));

        $account->id = 99;

        return $account;
    }

    protected function row(array $overrides = []): array
    {
        return array_merge([
            'id' => 1001,
            'reference_number' => 'FT24001',
            'amount_in' => 50000,
            'amount_out' => 0,
            'transfer_type' => 'in',
            'transaction_content' => 'naptien123',
            'account_number' => '0123456789',
            'bank_account_id' => 7,
            'transaction_date' => '2026-08-22 10:00:00',
        ], $overrides);
    }

    public function test_sandbox_base_url_is_used_by_default(): void
    {
        $this->assertSame('https://userapi-sandbox.sepay.vn/v2', $this->provider()->baseUrl());
        $this->assertTrue($this->provider()->isSandbox());
    }

    public function test_production_base_url_when_env_is_production(): void
    {
        $provider = $this->provider([
            'env' => 'production',
            'base_url' => 'https://userapi.sepay.vn/v2',
        ]);

        $this->assertSame('https://userapi.sepay.vn/v2', $provider->baseUrl());
        $this->assertFalse($provider->isSandbox());
    }

    public function test_sandbox_token_cannot_be_used_against_production_url(): void
    {
        $provider = $this->provider([
            'env' => 'sandbox',
            'base_url' => 'https://userapi.sepay.vn/v2',
        ]);

        $this->expectException(SepayApiException::class);
        $provider->baseUrl();
    }

    public function test_request_hits_sandbox_transactions_endpoint_with_bearer_token(): void
    {
        Http::fake([
            'userapi-sandbox.sepay.vn/*' => Http::response([
                'status' => 'success',
                'data' => [$this->row()],
                'meta' => ['pagination' => ['current_page' => 1, 'total_pages' => 1]],
            ], 200),
        ]);

        $this->provider()->fetchTransactions($this->account());

        Http::assertSent(function (Request $request) {
            return str_starts_with($request->url(), 'https://userapi-sandbox.sepay.vn/v2/transactions')
                && $request->hasHeader('Authorization', 'Bearer test-token');
        });
    }

    public function test_maps_reference_number_and_content_and_amount_in(): void
    {
        Http::fake([
            '*' => Http::response([
                'status' => 'success',
                'data' => [$this->row()],
                'meta' => ['pagination' => ['current_page' => 1, 'total_pages' => 1]],
            ], 200),
        ]);

        $transactions = $this->provider()->fetchTransactions($this->account());

        $this->assertCount(1, $transactions);
        $this->assertSame('SEPAY-FT24001', $transactions[0]['magiaodich']);
        $this->assertSame(50000.0, $transactions[0]['sotien']);
        $this->assertSame('naptien123', $transactions[0]['noidung']);
    }

    public function test_falls_back_to_id_when_reference_number_missing(): void
    {
        $normalized = $this->provider()->normalizeOne($this->row(['reference_number' => '']));

        $this->assertSame('SEPAY-1001', $normalized['magiaodich']);
    }

    public function test_transaction_id_has_prefix_so_it_cannot_collide_with_spay5s(): void
    {
        $normalized = $this->provider()->normalizeOne($this->row(['reference_number' => 'FT999']));

        $this->assertStringStartsWith('SEPAY-', $normalized['magiaodich']);
    }

    public function test_outgoing_transaction_is_ignored(): void
    {
        $row = $this->row([
            'amount_in' => 0,
            'amount_out' => 75000,
            'transfer_type' => 'out',
        ]);

        $this->assertNull($this->provider()->normalizeOne($row));
    }

    public function test_transaction_with_both_amounts_is_ignored(): void
    {
        $row = $this->row(['amount_in' => 50000, 'amount_out' => 50000]);

        $this->assertNull($this->provider()->normalizeOne($row));
    }

    public function test_unknown_transfer_type_is_ignored(): void
    {
        $row = $this->row(['transfer_type' => 'out']);

        $this->assertNull($this->provider()->normalizeOne($row));
    }

    public function test_zero_amount_in_is_ignored(): void
    {
        $this->assertNull($this->provider()->normalizeOne($this->row(['amount_in' => 0])));
    }

    public function test_amount_string_with_separator_is_parsed(): void
    {
        $normalized = $this->provider()->normalizeOne($this->row(['amount_in' => '1,500,000']));

        $this->assertSame(1500000.0, $normalized['sotien']);
    }

    public function test_duplicate_rows_in_same_response_are_collapsed(): void
    {
        $rows = [$this->row(), $this->row(), $this->row(['reference_number' => 'FT24002', 'id' => 1002])];

        $normalized = $this->provider()->normalizeMany($rows, $this->account());

        $this->assertCount(2, $normalized);
        $this->assertSame(['SEPAY-FT24001', 'SEPAY-FT24002'], array_column($normalized, 'magiaodich'));
    }

    public function test_transactions_of_other_account_number_are_filtered_out(): void
    {
        $rows = [$this->row(['account_number' => '9999999999'])];

        $this->assertSame([], $this->provider()->normalizeMany($rows, $this->account()));
    }

    public function test_response_is_not_assumed_to_be_raw_array(): void
    {
        Http::fake([
            '*' => Http::response([
                'status' => 'success',
                'data' => ['transactions' => [$this->row()]],
                'meta' => [],
            ], 200),
        ]);

        $transactions = $this->provider()->fetchTransactions($this->account());

        $this->assertCount(1, $transactions);
    }

    public function test_pagination_is_followed_using_meta(): void
    {
        Http::fakeSequence()
            ->push([
                'status' => 'success',
                'data' => [$this->row()],
                'meta' => ['pagination' => ['current_page' => 1, 'total_pages' => 2]],
            ], 200)
            ->push([
                'status' => 'success',
                'data' => [$this->row(['id' => 1002, 'reference_number' => 'FT24002'])],
                'meta' => ['pagination' => ['current_page' => 2, 'total_pages' => 2]],
            ], 200);

        $transactions = $this->provider()->fetchTransactions($this->account());

        $this->assertCount(2, $transactions);
        Http::assertSentCount(2);
    }

    public function test_http_401_throws_safe_exception_without_token(): void
    {
        Http::fake(['*' => Http::response(['status' => 'error', 'message' => 'Unauthorized'], 401)]);

        try {
            $this->provider()->fetchTransactions($this->account());
            $this->fail('Expected SepayApiException.');
        } catch (SepayApiException $e) {
            $this->assertSame(401, $e->httpStatus());
            $this->assertStringNotContainsString('test-token', $e->getMessage());
            $this->assertStringNotContainsString('Bearer', $e->getMessage());
        }
    }

    public function test_http_403_throws_exception(): void
    {
        Http::fake(['*' => Http::response([], 403)]);

        $this->expectException(SepayApiException::class);
        $this->provider()->fetchTransactions($this->account());
    }

    public function test_http_422_throws_exception(): void
    {
        Http::fake(['*' => Http::response([], 422)]);

        $this->expectException(SepayApiException::class);
        $this->provider()->fetchTransactions($this->account());
    }

    public function test_http_429_throws_exception_and_returns_no_transactions(): void
    {
        Http::fake(['*' => Http::response([], 429)]);

        try {
            $this->provider()->fetchTransactions($this->account());
            $this->fail('Expected SepayApiException.');
        } catch (SepayApiException $e) {
            $this->assertSame(429, $e->httpStatus());
        }
    }

    public function test_http_500_throws_exception(): void
    {
        Http::fake(['*' => Http::response([], 500)]);

        try {
            $this->provider()->fetchTransactions($this->account());
            $this->fail('Expected SepayApiException.');
        } catch (SepayApiException $e) {
            $this->assertSame(500, $e->httpStatus());
        }
    }

    public function test_api_level_error_status_throws_exception(): void
    {
        Http::fake(['*' => Http::response(['status' => 'error', 'message' => 'token=abc123 invalid'], 200)]);

        try {
            $this->provider()->fetchTransactions($this->account());
            $this->fail('Expected SepayApiException.');
        } catch (SepayApiException $e) {
            $this->assertStringNotContainsString('abc123', $e->getMessage());
        }
    }

    public function test_missing_token_throws_exception(): void
    {
        $provider = $this->provider(['token' => null]);

        $this->expectException(SepayApiException::class);
        $provider->tokenFor($this->account());
    }

    public function test_account_token_overrides_env_token(): void
    {
        $provider = $this->provider();

        $this->assertSame('per-account', $provider->tokenFor($this->account(['access_token' => 'per-account'])));
        $this->assertSame('test-token', $provider->tokenFor($this->account()));
    }

    public function test_since_id_is_sent_and_only_stored_after_success(): void
    {
        $provider = $this->provider(['use_since_id' => true]);
        $account = $this->account();

        Http::fake([
            '*' => Http::response([
                'status' => 'success',
                'data' => [$this->row()],
                'meta' => ['pagination' => ['current_page' => 1, 'total_pages' => 1]],
            ], 200),
        ]);

        $this->assertNull($provider->sinceIdFor($account));

        $transactions = $provider->fetchTransactions($account);
        $this->assertNull($provider->sinceIdFor($account), 'Cursor không được lưu trước khi xử lý xong.');

        $provider->rememberSinceId($account, $transactions);
        $this->assertSame('1001', $provider->sinceIdFor($account));

        $provider->fetchTransactions($account);
        Http::assertSent(fn (Request $request) => str_contains($request->url(), 'since_id=1001'));
    }

    public function test_since_id_is_not_stored_when_disabled(): void
    {
        $provider = $this->provider(['use_since_id' => false]);
        $account = $this->account();

        $provider->rememberSinceId($account, [
            ['magiaodich' => 'SEPAY-FT1', 'sotien' => 1000.0, 'noidung' => 'naptien1', 'sepay_id' => '5000', 'sepay_date' => null],
        ]);

        $this->assertNull($provider->sinceIdFor($account));
    }
}
