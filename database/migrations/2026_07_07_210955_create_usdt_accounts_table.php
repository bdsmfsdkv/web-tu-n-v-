<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usdt_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // binance, trc20
            $table->string('name')->nullable(); // Tên hiển thị (vd: Binance Pay, Ví TRC20)
            $table->string('wallet_address')->nullable();
            $table->string('api_token');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usdt_accounts');
    }
};
