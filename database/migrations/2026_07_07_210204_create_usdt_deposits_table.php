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
        Schema::create('usdt_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('request_code')->unique();
            $table->decimal('usdt_amount', 10, 2);
            $table->decimal('exchange_rate', 15, 0);
            $table->decimal('vnd_amount', 15, 0);
            $table->string('status')->default('pending'); // pending, completed, cancelled
            $table->string('transaction_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usdt_deposits');
    }
};
