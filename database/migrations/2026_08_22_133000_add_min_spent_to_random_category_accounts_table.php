<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('random_category_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('min_spent')->default(0)->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('random_category_accounts', function (Blueprint $table) {
            $table->dropColumn('min_spent');
        });
    }
};
