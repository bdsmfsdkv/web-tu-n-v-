<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchased_account_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('original_game_account_id')->nullable()->index();
            $table->unsignedBigInteger('game_category_id')->nullable()->index();
            $table->string('category_name')->nullable();
            $table->string('order_code', 64)->nullable()->index();
            $table->string('account_name');
            $table->text('password');
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('original_price', 15, 2)->nullable();
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->json('details')->nullable();
            $table->text('note')->nullable();
            $table->timestamp('purchased_at')->useCurrent();
            $table->timestamps();

            $table->index(['user_id', 'purchased_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchased_account_histories');
    }
};
