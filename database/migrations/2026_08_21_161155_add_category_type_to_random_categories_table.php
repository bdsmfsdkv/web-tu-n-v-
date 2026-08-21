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
        Schema::table('random_categories', function (Blueprint $table) {
            $table->string('category_type')->default('random')->after('slug'); // 'random' (loại 1: mua ngẫu nhiên) hoặc 'account_list' (loại 2: chọn mua từng acc)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('random_categories', function (Blueprint $table) {
            $table->dropColumn('category_type');
        });
    }
};
