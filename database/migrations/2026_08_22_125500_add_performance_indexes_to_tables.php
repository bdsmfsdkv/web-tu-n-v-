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
        Schema::table('game_accounts', function (Blueprint $table) {
            $table->index(['game_category_id', 'status', 'price'], 'idx_game_acc_cat_status_price');
        });

        Schema::table('random_category_accounts', function (Blueprint $table) {
            $table->index(['random_category_id', 'status', 'price'], 'idx_rand_acc_cat_status_price');
        });

        Schema::table('money_transactions', function (Blueprint $table) {
            $table->index(['type', 'created_at', 'user_id'], 'idx_money_tx_type_created_user');
        });

        Schema::table('service_histories', function (Blueprint $table) {
            $table->index('game_service_id', 'idx_serv_hist_game_service_id');
        });

        Schema::table('lucky_wheel_histories', function (Blueprint $table) {
            $table->index('lucky_wheel_id', 'idx_wheel_hist_lucky_wheel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_accounts', function (Blueprint $table) {
            $table->dropIndex('idx_game_acc_cat_status_price');
        });

        Schema::table('random_category_accounts', function (Blueprint $table) {
            $table->dropIndex('idx_rand_acc_cat_status_price');
        });

        Schema::table('money_transactions', function (Blueprint $table) {
            $table->dropIndex('idx_money_tx_type_created_user');
        });

        Schema::table('service_histories', function (Blueprint $table) {
            $table->dropIndex('idx_serv_hist_game_service_id');
        });

        Schema::table('lucky_wheel_histories', function (Blueprint $table) {
            $table->dropIndex('idx_wheel_hist_lucky_wheel_id');
        });
    }
};
