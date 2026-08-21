<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE lucky_wheel_histories MODIFY reward_type VARCHAR(50) NOT NULL');
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE lucky_wheel_histories MODIFY reward_type ENUM('gold', 'gem') NOT NULL");
    }
};
