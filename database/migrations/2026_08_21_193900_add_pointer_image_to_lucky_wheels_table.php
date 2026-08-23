<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lucky_wheels', function (Blueprint $table) {
            $table->string('pointer_image')->nullable()->after('wheel_image');
        });
    }

    public function down(): void
    {
        Schema::table('lucky_wheels', function (Blueprint $table) {
            $table->dropColumn('pointer_image');
        });
    }
};
