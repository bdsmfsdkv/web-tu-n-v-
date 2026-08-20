<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\GameGroup;
use App\Models\GameCategory;
use App\Models\GameAccount;

class PresetGamesSeeder extends Seeder
{
    public function run()
    {
        $defaultThumb = 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg';
        $defaultImages = json_encode([
            $defaultThumb,
            $defaultThumb,
            $defaultThumb
        ]);

        $games = [
            [
                'group' => [
                    'name' => 'Liên Quân Mobile',
                    'slug' => 'lien-quan-mobile',
                    'thumbnail' => $defaultThumb,
                    'order' => 1,
                    'active' => true,
                ],
                'categories' => [
                    [
                        'name' => 'Nick Liên Quân Full Tướng & Skin VIP',
                        'slug' => 'nick-lien-quan-full-tuong-skin-vip',
                        'thumbnail' => $defaultThumb,
                        'description' => 'Tài khoản Liên Quân Mobile rank cao, nhiều tướng và trang phục giới hạn.',
                        'platform' => 'lien-quan',
                        'active' => true,
                        'accounts' => [
                            [
                                'account_name' => 'lq_vip01',
                                'password' => 'pass123456',
                                'price' => 250000,
                                'status' => 'available',
                                'details' => [
                                    ['key' => 'Rank', 'value' => 'Chiến Tướng'],
                                    ['key' => 'Tướng', 'value' => '115'],
                                    ['key' => 'Trang Phục', 'value' => '320'],
                                    ['key' => 'Bậc Ngọc', 'value' => 'Ngọc 90 (Full)'],
                                    ['key' => 'Đăng ký', 'value' => 'Trắng thông tin'],
                                ],
                            ],
                            [
                                'account_name' => 'lq_starter02',
                                'password' => 'pass123456',
                                'price' => 80000,
                                'status' => 'available',
                                'details' => [
                                    ['key' => 'Rank', 'value' => 'Tinh Anh'],
                                    ['key' => 'Tướng', 'value' => '65'],
                                    ['key' => 'Trang Phục', 'value' => '80'],
                                    ['key' => 'Bậc Ngọc', 'value' => 'Ngọc 90 (Full)'],
                                    ['key' => 'Đăng ký', 'value' => 'Trắng thông tin'],
                                ],
                            ],
                            [
                                'account_name' => 'lq_budget03',
                                'password' => 'pass123456',
                                'price' => 45000,
                                'status' => 'available',
                                'details' => [
                                    ['key' => 'Rank', 'value' => 'Kim Cương'],
                                    ['key' => 'Tướng', 'value' => '40'],
                                    ['key' => 'Trang Phục', 'value' => '35'],
                                    ['key' => 'Bậc Ngọc', 'value' => 'Chưa full 90'],
                                    ['key' => 'Đăng ký', 'value' => 'Garena sạch'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'group' => [
                    'name' => 'Free Fire',
                    'slug' => 'free-fire',
                    'thumbnail' => $defaultThumb,
                    'order' => 2,
                    'active' => true,
                ],
                'categories' => [
                    [
                        'name' => 'Nick Free Fire Skin Súng Nâng Cấp VIP',
                        'slug' => 'nick-free-fire-skin-sung-nang-cap-vip',
                        'thumbnail' => $defaultThumb,
                        'description' => 'Tài khoản Free Fire sở hữu nhiều skin súng huyền thoại Lv7 và rank cao.',
                        'platform' => 'free-fire',
                        'active' => true,
                        'accounts' => [
                            [
                                'account_name' => 'ff_vip01',
                                'password' => 'pass123456',
                                'price' => 550000,
                                'status' => 'available',
                                'details' => [
                                    ['key' => 'Rank', 'value' => 'Huyền Thoại'],
                                    ['key' => 'Skin Súng VIP', 'value' => 'AK Rồng Xanh'],
                                    ['key' => 'Đăng ký', 'value' => 'Trắng thông tin'],
                                    ['key' => 'Pet', 'value' => 'Full Pet'],
                                    ['key' => 'Thẻ Vô Cực', 'value' => 'Nhiều mùa cũ (Mùa 1-5)'],
                                ],
                            ],
                            [
                                'account_name' => 'ff_mid02',
                                'password' => 'pass123456',
                                'price' => 180000,
                                'status' => 'available',
                                'details' => [
                                    ['key' => 'Rank', 'value' => 'Kim Cương'],
                                    ['key' => 'Skin Súng VIP', 'value' => 'MP40 Mãng Xà'],
                                    ['key' => 'Đăng ký', 'value' => 'Facebook sạch'],
                                    ['key' => 'Pet', 'value' => 'Có Pet trợ thủ'],
                                    ['key' => 'Thẻ Vô Cực', 'value' => 'Một vài mùa'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'group' => [
                    'name' => 'Blox Fruits & Roblox',
                    'slug' => 'blox-fruits-roblox',
                    'thumbnail' => $defaultThumb,
                    'order' => 3,
                    'active' => true,
                ],
                'categories' => [
                    [
                        'name' => 'Nick Blox Fruits Max Level & Trái Mythical',
                        'slug' => 'nick-blox-fruits-max-level-trai-mythical',
                        'thumbnail' => $defaultThumb,
                        'description' => 'Tài khoản Blox Fruits Max Level 2550, Kitsune, Melee Godhuman, CDK.',
                        'platform' => 'blox-fruits',
                        'active' => true,
                        'accounts' => [
                            [
                                'account_name' => 'bf_godhuman01',
                                'password' => 'pass123456',
                                'price' => 350000,
                                'status' => 'available',
                                'details' => [
                                    ['key' => 'Level', 'value' => 'Max (2550)'],
                                    ['key' => 'Trái Ác Quỷ', 'value' => 'Kitsune'],
                                    ['key' => 'Melee V2', 'value' => 'Godhuman (Full Melee)'],
                                    ['key' => 'Kiếm Mythical', 'value' => 'Cursed Dual Katana (CDK)'],
                                    ['key' => 'Tộc V4', 'value' => 'Human V4 (Full Gear)'],
                                    ['key' => 'Beli & Fragments', 'value' => '50M+ Beli / 50k Frag'],
                                ],
                            ],
                            [
                                'account_name' => 'bf_buddha02',
                                'password' => 'pass123456',
                                'price' => 120000,
                                'status' => 'available',
                                'details' => [
                                    ['key' => 'Level', 'value' => 'Max (2550)'],
                                    ['key' => 'Trái Ác Quỷ', 'value' => 'Buddha (Phật V2)'],
                                    ['key' => 'Melee V2', 'value' => 'Superhuman'],
                                    ['key' => 'Kiếm Mythical', 'value' => 'Dark Blade (Yoru)'],
                                    ['key' => 'Tộc V4', 'value' => 'Fishman V4 (Full Gear)'],
                                    ['key' => 'Beli & Fragments', 'value' => '10M+ Beli / 20k Frag'],
                                ],
                            ],
                        ],
                    ],
                    [
                        'name' => 'Nick Roblox Chung (Acc Cổ & Robux Clean)',
                        'slug' => 'nick-roblox-chung-acc-co-robux-clean',
                        'thumbnail' => $defaultThumb,
                        'description' => 'Tài khoản Roblox cổ, có sẵn Robux sạch và Gamepass.',
                        'platform' => 'roblox',
                        'active' => true,
                        'accounts' => [
                            [
                                'account_name' => 'rbx_clean01',
                                'password' => 'pass123456',
                                'price' => 200000,
                                'status' => 'available',
                                'details' => [
                                    ['key' => 'Số dư Robux', 'value' => '2,000 - 5,000 Robux'],
                                    ['key' => 'Năm tạo Acc', 'value' => '2016 - 2018'],
                                    ['key' => 'Gamepass', 'value' => 'Blox Fruits VIP/2x'],
                                    ['key' => 'Tình trạng Pin / Mail', 'value' => 'Trắng Email / Chưa cài PIN'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'group' => [
                    'name' => 'FC Mobile',
                    'slug' => 'fc-mobile',
                    'thumbnail' => $defaultThumb,
                    'order' => 4,
                    'active' => true,
                ],
                'categories' => [
                    [
                        'name' => 'Nick FC Mobile OVR Khủng & Icon VIP',
                        'slug' => 'nick-fc-mobile-ovr-khung-icon-vip',
                        'thumbnail' => $defaultThumb,
                        'description' => 'Tài khoản FC Mobile đội hình OVR 100+ nhiều cầu thủ Icon huyền thoại.',
                        'platform' => 'fc-mobile',
                        'active' => true,
                        'accounts' => [
                            [
                                'account_name' => 'fcm_ovr106',
                                'password' => 'pass123456',
                                'price' => 600000,
                                'status' => 'available',
                                'details' => [
                                    ['key' => 'OVR Đội Hình', 'value' => '106+ (Siêu VIP)'],
                                    ['key' => 'Giá trị đội hình', 'value' => '3B - 5B Coins'],
                                    ['key' => 'Cầu thủ nổi bật', 'value' => 'Ronaldo Nazario (R9)'],
                                    ['key' => 'Đăng nhập', 'value' => 'EA Account (Trắng mail)'],
                                ],
                            ],
                            [
                                'account_name' => 'fcm_starter',
                                'password' => 'pass123456',
                                'price' => 90000,
                                'status' => 'available',
                                'details' => [
                                    ['key' => 'OVR Đội Hình', 'value' => '96 - 100'],
                                    ['key' => 'Giá trị đội hình', 'value' => '500M - 1B Coins'],
                                    ['key' => 'Cầu thủ nổi bật', 'value' => 'Messi'],
                                    ['key' => 'Đăng nhập', 'value' => 'EA Account (Trắng mail)'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'group' => [
                    'name' => 'LMHT Tốc Chiến',
                    'slug' => 'lmht-toc-chien',
                    'thumbnail' => $defaultThumb,
                    'order' => 5,
                    'active' => true,
                ],
                'categories' => [
                    [
                        'name' => 'Nick Tốc Chiến Rank Cao Thủ Full Skin',
                        'slug' => 'nick-toc-chien-rank-cao-thu-full-skin',
                        'thumbnail' => $defaultThumb,
                        'description' => 'Tài khoản LMHT: Wild Rift rank cao, nhiều skin Thần Thoại.',
                        'platform' => 'toc-chien',
                        'active' => true,
                        'accounts' => [
                            [
                                'account_name' => 'wr_challenger',
                                'password' => 'pass123456',
                                'price' => 450000,
                                'status' => 'available',
                                'details' => [
                                    ['key' => 'Rank', 'value' => 'Cao Thủ'],
                                    ['key' => 'Số Tướng', 'value' => '80+'],
                                    ['key' => 'Số Skin', 'value' => '150+'],
                                    ['key' => 'Skin Tối Thượng / Thần Thoại', 'value' => 'Có nhiều Skin Thần Thoại'],
                                    ['key' => 'Đăng nhập', 'value' => 'Riot Games (Trắng mail)'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'group' => [
                    'name' => 'PUBG Mobile',
                    'slug' => 'pubg-mobile',
                    'thumbnail' => $defaultThumb,
                    'order' => 6,
                    'active' => true,
                ],
                'categories' => [
                    [
                        'name' => 'Nick PUBG Mobile M416 Băng & X-Suit',
                        'slug' => 'nick-pubg-mobile-m416-bang-x-suit',
                        'thumbnail' => $defaultThumb,
                        'description' => 'Tài khoản PUBG Mobile súng nâng cấp Glacier và X-Suit cực VIP.',
                        'platform' => 'pubg-mobile',
                        'active' => true,
                        'accounts' => [
                            [
                                'account_name' => 'pubg_ice_max',
                                'password' => 'pass123456',
                                'price' => 1200000,
                                'status' => 'available',
                                'details' => [
                                    ['key' => 'Rank', 'value' => 'Quán Quân (Ace)'],
                                    ['key' => 'Skin Nâng Cấp (Súng Lab)', 'value' => 'M416 Băng (Glacier) Max'],
                                    ['key' => 'Bộ Trang Phục VIP', 'value' => 'X-Suit Pharaoh 6-7 sao'],
                                    ['key' => 'Liên kết', 'value' => 'Trắng thông tin (Mail/SĐT)'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'group' => [
                    'name' => 'Ngọc Rồng Online',
                    'slug' => 'ngoc-rong-online',
                    'thumbnail' => $defaultThumb,
                    'order' => 7,
                    'active' => true,
                ],
                'categories' => [
                    [
                        'name' => 'Nick NRO Sức Mạnh Khủng & Có Đệ Tử VIP',
                        'slug' => 'nick-nro-suc-manh-khung-co-de-tu-vip',
                        'thumbnail' => $defaultThumb,
                        'description' => 'Tài khoản Chú Bé Rồng Online các vũ trụ, đệ tử kame, bông tai Porata.',
                        'platform' => 'ngoc-rong-online',
                        'active' => true,
                        'accounts' => [
                            [
                                'account_name' => 'nro_server1_vip',
                                'password' => 'pass123456',
                                'price' => 300000,
                                'status' => 'available',
                                'details' => [
                                    ['key' => 'Máy Chủ (Server)', 'value' => 'Vũ Trụ 1'],
                                    ['key' => 'Hành Tinh', 'value' => 'Trái Đất'],
                                    ['key' => 'Sức Mạnh', 'value' => '40 tỷ - 80 tỷ'],
                                    ['key' => 'Đệ Tử', 'value' => 'Đệ Skill 2 Kamejoko / Masenko'],
                                    ['key' => 'Bông Tai Porata', 'value' => 'Porata Cấp 2'],
                                    ['key' => 'Đăng ký', 'value' => 'Nick ảo (Trắng thông tin)'],
                                ],
                            ],
                            [
                                'account_name' => 'nro_sosinh02',
                                'password' => 'pass123456',
                                'price' => 30000,
                                'status' => 'available',
                                'details' => [
                                    ['key' => 'Máy Chủ (Server)', 'value' => 'Vũ Trụ 2'],
                                    ['key' => 'Hành Tinh', 'value' => 'Xayda'],
                                    ['key' => 'Sức Mạnh', 'value' => 'Sơ sinh (Dưới 1.5tr)'],
                                    ['key' => 'Đệ Tử', 'value' => 'Chưa có đệ'],
                                    ['key' => 'Bông Tai Porata', 'value' => 'Chưa có'],
                                    ['key' => 'Đăng ký', 'value' => 'Nick ảo (Trắng thông tin)'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($games as $gameData) {
            $groupData = $gameData['group'];
            $gameGroup = GameGroup::updateOrCreate(
                ['slug' => $groupData['slug']],
                $groupData
            );

            foreach ($gameData['categories'] as $catData) {
                $accounts = $catData['accounts'] ?? [];
                unset($catData['accounts']);

                $catData['game_group_id'] = $gameGroup->id;
                $category = GameCategory::updateOrCreate(
                    ['slug' => $catData['slug']],
                    $catData
                );

                foreach ($accounts as $accData) {
                    $accData['game_category_id'] = $category->id;
                    $accData['thumb'] = $defaultThumb;
                    $accData['images'] = $defaultImages;
                    $accData['note'] = 'Tài khoản mẫu cấu hình chuẩn ' . $gameGroup->name;

                    GameAccount::updateOrCreate(
                        [
                            'game_category_id' => $category->id,
                            'account_name' => $accData['account_name']
                        ],
                        $accData
                    );
                }
            }
        }
    }
}
