<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Thêm cột `provider` để chọn nguồn API lấy giao dịch cho từng tài khoản ngân hàng.
 *
 * - Cột nullable, default 'spay5s'.
 * - Dữ liệu cũ (NULL hoặc 'spay5s') vẫn chạy đúng luồng SPAY5S như trước.
 * - Không migrate/ghi đè dữ liệu hiện có.
 */
return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasColumn('bank_accounts', 'provider')) {
            return;
        }

        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->string('provider', 32)
                ->nullable()
                ->default('spay5s')
                ->after('access_token');
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('bank_accounts', 'provider')) {
            return;
        }

        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropColumn('provider');
        });
    }
};
