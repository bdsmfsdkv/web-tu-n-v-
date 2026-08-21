<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('game_groups', function (Blueprint $table) {
            $table->string('name')->unique()->after('id');
            $table->string('slug')->unique()->after('name');
            $table->string('thumbnail')->nullable()->after('slug');
            $table->unsignedInteger('order')->default(0)->after('thumbnail');
            $table->boolean('active')->default(true)->after('order');
        });
    }

    public function down(): void
    {
        Schema::table('game_groups', function (Blueprint $table) {
            $table->dropColumn(['name', 'slug', 'thumbnail', 'order', 'active']);
        });
    }
};
