<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;
    protected $table = 'bank_accounts';
    protected $fillable = [
        'bank_name',        // Tên ngân hàng
        'account_name',     // Tên chủ tài khoản
        'account_number',   // Số tài khoản
        'branch',           // Chi nhánh
        'note',             // Ghi chú
        'is_active',        // Trạng thái hiển thị
        'auto_confirm',      // Trạng thái tự động xác nhận chuyển tiền
        'prefix',            // Cú pháp nạp tiền,
        'access_token',      // Access Token bên SePay.VN
        'provider',          // Nguồn API lấy giao dịch: spay5s (mặc định) hoặc sepay
        'sepay_env',         // Môi trường SePay của tài khoản: production hoặc sandbox
        'image'              // Ảnh QR code hoặc logo ngân hàng
    ];

    public const PROVIDER_SPAY5S = 'spay5s';
    public const PROVIDER_SEPAY = 'sepay';

    /**
     * Môi trường SePay của tài khoản (production / sandbox).
     */
    public function sepayEnv(): string
    {
        $env = strtolower(trim((string) ($this->attributes['sepay_env'] ?? '')));
        if ($env === 'sandbox' || $env === 'production') {
            return $env;
        }

        return 'sandbox';
    }

    /**
     * Provider đang dùng của tài khoản.
     *
     * Dữ liệu cũ (cột chưa tồn tại, NULL hoặc rỗng) luôn trả về spay5s
     * để không phá integration SPAY5S hiện tại.
     */
    public function providerName(): string
    {
        $provider = strtolower(trim((string) ($this->attributes['provider'] ?? '')));

        return $provider === self::PROVIDER_SEPAY ? self::PROVIDER_SEPAY : self::PROVIDER_SPAY5S;
    }

    public function usesSepay(): bool
    {
        return $this->providerName() === self::PROVIDER_SEPAY;
    }
}
