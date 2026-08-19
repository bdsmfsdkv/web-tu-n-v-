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
        Schema::table('game_categories', function (Blueprint $table) {
            $table->string('tag_image')->nullable()->after('thumbnail');
        });

        Schema::table('random_categories', function (Blueprint $table) {
            $table->string('tag_image')->nullable()->after('thumbnail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_categories', function (Blueprint $table) {
            $table->dropColumn('tag_image');
        });

        Schema::table('random_categories', function (Blueprint $table) {
            $table->dropColumn('tag_image');
        });
    }
};
