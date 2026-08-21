<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('game_categories', function (Blueprint $table) {
            $table->foreignId('game_group_id')->nullable()->after('updated_at')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('game_categories', function (Blueprint $table) {
            $table->dropConstrainedForeignId('game_group_id');
        });
    }
};
