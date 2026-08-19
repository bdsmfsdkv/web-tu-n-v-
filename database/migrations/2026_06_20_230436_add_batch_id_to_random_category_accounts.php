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
        Schema::table('random_category_accounts', function (Blueprint $table) {
            $table->string('batch_id')->nullable()->after('buyer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('random_category_accounts', function (Blueprint $table) {
            $table->dropColumn('batch_id');
        });
    }
};
