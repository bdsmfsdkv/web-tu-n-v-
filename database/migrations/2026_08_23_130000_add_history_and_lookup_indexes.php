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
        Schema::table('money_transactions', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'idx_money_tx_user_created');
        });

        Schema::table('card_deposits', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'idx_card_dep_user_created');
            $table->index('request_id', 'idx_card_dep_request_id');
        });

        Schema::table('bank_deposits', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'idx_bank_dep_user_created');
        });

        Schema::table('usdt_deposits', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'idx_usdt_dep_user_created');
            $table->index('transaction_id', 'idx_usdt_dep_transaction_id');
        });

        Schema::table('withdrawal_histories', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'idx_with_hist_user_created');
        });

        Schema::table('money_withdrawal_histories', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'idx_mwith_hist_user_created');
        });

        Schema::table('service_histories', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'idx_serv_hist_user_created');
        });

        Schema::table('lucky_wheel_histories', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'idx_lwheel_hist_user_created');
        });

        Schema::table('random_category_accounts', function (Blueprint $table) {
            $table->index('batch_id', 'idx_rand_acc_batch_id');
            $table->index(['buyer_id', 'status', 'created_at'], 'idx_rand_acc_buyer_status_created');
        });

        Schema::table('installments', function (Blueprint $table) {
            $table->index(['user_id', 'status'], 'idx_inst_user_status');
        });

        Schema::table('discount_code_usages', function (Blueprint $table) {
            $table->index(['discount_code_id', 'user_id'], 'idx_disc_usage_code_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('money_transactions', function (Blueprint $table) {
            $table->dropIndex('idx_money_tx_user_created');
        });

        Schema::table('card_deposits', function (Blueprint $table) {
            $table->dropIndex('idx_card_dep_user_created');
            $table->dropIndex('idx_card_dep_request_id');
        });

        Schema::table('bank_deposits', function (Blueprint $table) {
            $table->dropIndex('idx_bank_dep_user_created');
        });

        Schema::table('usdt_deposits', function (Blueprint $table) {
            $table->dropIndex('idx_usdt_dep_user_created');
            $table->dropIndex('idx_usdt_dep_transaction_id');
        });

        Schema::table('withdrawal_histories', function (Blueprint $table) {
            $table->dropIndex('idx_with_hist_user_created');
        });

        Schema::table('money_withdrawal_histories', function (Blueprint $table) {
            $table->dropIndex('idx_mwith_hist_user_created');
        });

        Schema::table('service_histories', function (Blueprint $table) {
            $table->dropIndex('idx_serv_hist_user_created');
        });

        Schema::table('lucky_wheel_histories', function (Blueprint $table) {
            $table->dropIndex('idx_lwheel_hist_user_created');
        });

        Schema::table('random_category_accounts', function (Blueprint $table) {
            $table->dropIndex('idx_rand_acc_batch_id');
            $table->dropIndex('idx_rand_acc_buyer_status_created');
        });

        Schema::table('installments', function (Blueprint $table) {
            $table->dropIndex('idx_inst_user_status');
        });

        Schema::table('discount_code_usages', function (Blueprint $table) {
            $table->dropIndex('idx_disc_usage_code_user');
        });
    }
};
