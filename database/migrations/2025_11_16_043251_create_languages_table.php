<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên ngôn ngữ (VD: Vietnamese, English)
            $table->string('iso_code', 10)->unique(); // Mã ISO (VD: vi, en, zh)
            $table->string('flag_path')->nullable(); // Đường dẫn file cờ
            $table->boolean('is_active')->default(true); // Hiển thị công khai
            $table->boolean('is_default')->default(false); // Ngôn ngữ mặc định
            $table->integer('order')->default(0); // Thứ tự sắp xếp
            $table->timestamps();
        });

        // Tự động tạo Vietnamese mặc định sau khi tạo bảng
        // Đảm bảo Vietnamese luôn là ngôn ngữ mặc định
        // Kiểm tra xem đã có Vietnamese chưa
        $vietnameseExists = DB::table('languages')->where('iso_code', 'vi')->exists();
        
        if (!$vietnameseExists) {
            // Tạo Vietnamese mới
            DB::table('languages')->insert([
                'name' => 'Vietnamese',
                'iso_code' => 'vi',
                'flag_path' => null,
                'is_active' => true,
                'is_default' => true,
                'order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            // Đầu tiên, set tất cả ngôn ngữ khác is_default = false
            DB::table('languages')->where('iso_code', '!=', 'vi')->update(['is_default' => false]);
            
            // Update Vietnamese để đảm bảo nó là default
            DB::table('languages')->where('iso_code', 'vi')->update([
                'is_default' => true,
                'is_active' => true,
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
