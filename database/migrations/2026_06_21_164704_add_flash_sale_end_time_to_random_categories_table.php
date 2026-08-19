<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('random_categories', function (Blueprint $table) {
            $table->dateTime('flash_sale_end_time')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('random_categories', function (Blueprint $table) {
            $table->dropColumn('flash_sale_end_time');
        });
    }
};
