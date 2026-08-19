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
        Schema::create('reward_items', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('game_name');
            $table->string('name');
            $table->string('unit');
            $table->string('code')->unique();
            $table->integer('min_withdraw')->default(0);
            $table->integer('max_withdraw')->default(0);
            $table->integer('priority')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reward_items');
    }
};
