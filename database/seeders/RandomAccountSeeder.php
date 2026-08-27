<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RandomCategoryAccount;
use App\Models\RandomCategory;
use Illuminate\Support\Facades\DB;

class RandomAccountSeeder extends Seeder
{
    public function run(): void
    {
        $category = RandomCategory::first();
        if (!$category) {
            $category = RandomCategory::create([
                'name' => 'random',
                'slug' => 'random',
                'thumbnail' => '/storage/random-categories/1787297326_6df2bf576102eef00cf8e49d9076180e.gif',
                'active' => true,
                'category_type' => 'random',
            ]);
        }

        $firstNames = ['nguyen', 'tran', 'le', 'pham', 'hoang', 'huynh', 'phan', 'vu', 'vo', 'dang', 'bui', 'do', 'ho', 'ngo', 'duong', 'ly', 'truong', 'dinh', 'mai', 'dao'];
        $middleNames = ['van', 'thi', 'duc', 'hoang', 'minh', 'anh', 'quang', 'ngoc', 'thanh', 'hai', 'xuan', 'phuc', 'gia', 'tien', 'huu', 'nhat', 'bao', 'tuan'];
        $lastNames = ['long', 'nam', 'hai', 'dung', 'linh', 'huyen', 'trang', 'anh', 'dat', 'khoa', 'phong', 'thao', 'quan', 'son', 'tung', 'hung', 'thang', 'kien', 'viet', 'quynh', 'khang', 'vy', 'khanh', 'loc'];
        $gameWords = ['pro', 'vip', 'gaming', 'boy', 'girl', 'ff', 'roblox', 'god', 'king', 'shadow', 'dragon', 'dark', 'cute', 'alone', 'master', 'sniper', 'killer'];

        $passWordPatterns = [
            'anhyeuem', 'nguoiyuem', 'yeu1nguoi', 'matkhau', 'khongcomatkhau',
            'yeucongchua', 'hoangtu', 'deptrai', 'xinhgai', 'vodich',
            'proplayer', 'khongbiet', 'thichchoigame', 'yeuemnhieu', 'matkhaula'
        ];

        $accounts = [];
        $now = now();

        for ($i = 1; $i <= 149; $i++) {
            $type = rand(1, 4);
            $year = rand(1998, 2011);
            $day = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
            $month = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);

            if ($type === 1) {
                // Họ tên + ngày sinh/năm sinh
                $fn = $firstNames[array_rand($firstNames)];
                $ln = $lastNames[array_rand($lastNames)];
                $num = rand(0, 1) ? $year : ($day . $month);
                $accountName = $fn . $ln . $num;
            } elseif ($type === 2) {
                // Họ + tên đệm + tên + số đuôi
                $fn = $firstNames[array_rand($firstNames)];
                $mn = $middleNames[array_rand($middleNames)];
                $ln = $lastNames[array_rand($lastNames)];
                $accountName = $fn . $mn . $ln . rand(1, 999);
            } elseif ($type === 3) {
                // Nickname game thật
                $gw = $gameWords[array_rand($gameWords)];
                $ln = $lastNames[array_rand($lastNames)];
                $accountName = $ln . '_' . $gw . rand(10, 999);
            } else {
                // Email format ngắn hoặc tên + đuôi sđt
                $fn = $firstNames[array_rand($firstNames)];
                $ln = $lastNames[array_rand($lastNames)];
                $suffix = rand(100, 9999);
                $accountName = $fn . $ln . $suffix;
            }

            // Mật khẩu phong cách người dùng thật
            $passType = rand(1, 4);
            if ($passType === 1) {
                $pWord = $passWordPatterns[array_rand($passWordPatterns)];
                $password = $pWord . rand(123, 999);
            } elseif ($passType === 2) {
                $ln = $lastNames[array_rand($lastNames)];
                $password = ucfirst($ln) . '@' . $year;
            } elseif ($passType === 3) {
                $password = $accountName . '@' . rand(123, 999);
            } else {
                $password = $day . $month . $year;
            }

            $accounts[] = [
                'random_category_id' => $category->id,
                'account_name' => strtolower($accountName),
                'password' => $password,
                'price' => 20000,
                'min_spent' => 0,
                'status' => 'available',
                'server' => 1,
                'buyer_id' => null,
                'batch_id' => null,
                'note' => 'Acc random tỉ lệ trúng VIP cao',
                'note_buyer' => 'Chúc bạn chơi game vui vẻ!',
                'thumbnail' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('random_category_accounts')->insert($accounts);
    }
}
