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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_account_id')->constrained()->onDelete('cascade');
            $table->decimal('total_price', 15, 2);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->integer('duration_days'); // 7, 30, 60
            $table->datetime('expire_date');
            $table->enum('status', ['active', 'completed', 'cancelled', 'expired'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
