<?php

namespace Tests\Unit;

use App\Models\BankAccount;
use Tests\TestCase;

/**
 * Backward compatibility: mọi tài khoản cũ (không có / NULL / rỗng cột provider)
 * phải tiếp tục chạy nhánh SPAY5S.
 */
class BankAccountProviderTest extends TestCase
{
    public function test_legacy_account_without_provider_column_defaults_to_spay5s(): void
    {
        $account = new BankAccount(['bank_name' => 'MBBank', 'account_number' => '001']);

        $this->assertSame(BankAccount::PROVIDER_SPAY5S, $account->providerName());
        $this->assertFalse($account->usesSepay());
    }

    public function test_null_provider_defaults_to_spay5s(): void
    {
        $account = new BankAccount(['bank_name' => 'MBBank', 'provider' => null]);

        $this->assertSame(BankAccount::PROVIDER_SPAY5S, $account->providerName());
        $this->assertFalse($account->usesSepay());
    }

    public function test_empty_provider_defaults_to_spay5s(): void
    {
        $account = new BankAccount(['bank_name' => 'MBBank', 'provider' => '']);

        $this->assertSame(BankAccount::PROVIDER_SPAY5S, $account->providerName());
    }

    public function test_unknown_provider_falls_back_to_spay5s(): void
    {
        $account = new BankAccount(['bank_name' => 'MBBank', 'provider' => 'something-else']);

        $this->assertSame(BankAccount::PROVIDER_SPAY5S, $account->providerName());
        $this->assertFalse($account->usesSepay());
    }

    public function test_sepay_provider_is_detected_case_insensitively(): void
    {
        $account = new BankAccount(['bank_name' => 'MBBank', 'provider' => 'SePay']);

        $this->assertSame(BankAccount::PROVIDER_SEPAY, $account->providerName());
        $this->assertTrue($account->usesSepay());
    }
}
