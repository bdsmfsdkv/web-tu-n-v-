<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lucky_wheel_histories', function (Blueprint $table) {
            $table->foreignId('reward_item_id')
                ->nullable()
                ->after('lucky_wheel_id')
                ->constrained('reward_items')
                ->nullOnDelete();
        });

        Schema::table('withdrawal_histories', function (Blueprint $table) {
            $table->foreignId('reward_item_id')
                ->nullable()
                ->after('user_id')
                ->constrained('reward_items')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('withdrawal_histories', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reward_item_id');
        });

        Schema::table('lucky_wheel_histories', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reward_item_id');
        });
    }
};
