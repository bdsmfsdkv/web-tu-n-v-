<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reward_items', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->foreignId('lucky_wheel_id')
                ->nullable()
                ->after('id')
                ->constrained('lucky_wheels')
                ->cascadeOnDelete();
            $table->unique(['lucky_wheel_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::table('reward_items', function (Blueprint $table) {
            $table->dropUnique(['lucky_wheel_id', 'code']);
            $table->dropConstrainedForeignId('lucky_wheel_id');
            $table->unique('code');
        });
    }
};
