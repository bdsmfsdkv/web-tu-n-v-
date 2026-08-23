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
        if (!Schema::hasTable('sepay_webhook_logs')) {
            Schema::create('sepay_webhook_logs', function (Blueprint $table) {
                $table->id();
                $table->string('bank_name', 50)->nullable();
                $table->string('account_number', 50)->nullable();
                $table->string('content', 255)->nullable();
                $table->decimal('amount', 15, 2)->default(0);
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->string('reference_code', 100)->nullable()->index();
                $table->string('status', 30)->default('SUCCESS'); // SUCCESS, DUPLICATE, USER_NOT_FOUND, INVALID_AMOUNT, UNAUTHORIZED, IGNORED, ERROR
                $table->string('message', 255)->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sepay_webhook_logs');
    }
};
