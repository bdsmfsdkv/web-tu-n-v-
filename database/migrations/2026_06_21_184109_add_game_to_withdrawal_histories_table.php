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
        Schema::table('withdrawal_histories', function (Blueprint $table) {
            $table->string('game')->nullable()->after('type');
            $table->string('server')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('withdrawal_histories', function (Blueprint $table) {
            $table->dropColumn('game');
            $table->integer('server')->nullable(false)->change();
        });
    }
};
