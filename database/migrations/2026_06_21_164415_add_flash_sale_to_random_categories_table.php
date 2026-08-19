<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('random_categories', function (Blueprint $table) {
            $table->boolean('is_flash_sale')->default(false);
            $table->integer('flash_sale_old_price')->nullable();
            $table->integer('flash_sale_new_price')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('random_categories', function (Blueprint $table) {
            $table->dropColumn(['is_flash_sale', 'flash_sale_old_price', 'flash_sale_new_price']);
        });
    }
};
