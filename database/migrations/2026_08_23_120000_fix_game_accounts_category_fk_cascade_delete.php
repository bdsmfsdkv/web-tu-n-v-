<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('game_accounts', function (Blueprint $table) {
            $table->dropForeign(['game_category_id']);
        });

        Schema::table('game_accounts', function (Blueprint $table) {
            $table->foreign('game_category_id')
                ->references('id')
                ->on('game_categories')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('game_accounts', function (Blueprint $table) {
            $table->dropForeign(['game_category_id']);
        });

        Schema::table('game_accounts', function (Blueprint $table) {
            $table->foreign('game_category_id')
                ->references('id')
                ->on('game_categories');
        });
    }
};
