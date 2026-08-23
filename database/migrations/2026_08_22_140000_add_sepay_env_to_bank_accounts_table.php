<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Thêm cột `sepay_env` vào bảng `bank_accounts` để cấu hình môi trường SePay (sandbox/production) riêng cho từng tài khoản.
 */
return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasColumn('bank_accounts', 'sepay_env')) {
            return;
        }

        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->string('sepay_env', 20)
                ->nullable()
                ->default('production')
                ->after('provider');
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('bank_accounts', 'sepay_env')) {
            return;
        }

        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropColumn('sepay_env');
        });
    }
};
