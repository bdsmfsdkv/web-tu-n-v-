<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('game_categories', function (Blueprint $table) {
            $table->string('platform')->nullable()->after('slug');
        });

        Schema::table('random_categories', function (Blueprint $table) {
            $table->string('platform')->nullable()->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('game_categories', function (Blueprint $table) {
            $table->dropColumn('platform');
        });

        Schema::table('random_categories', function (Blueprint $table) {
            $table->dropColumn('platform');
        });
    }
};
