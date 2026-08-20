<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Game Attributes Preset Configuration
    |--------------------------------------------------------------------------
    |
    | Defines default attributes, labels, input types, and suggested options
    | for the top 8 popular game titles.
    |
    */

    'games' => [
        'lien-quan' => [
            'name' => 'Liên Quân Mobile',
            'aliases' => ['lien-quan', 'lien-quan-mobile', 'lq', 'lqmb', 'aov', 'arena-of-valor'],
            'attributes' => [
                [
                    'key' => 'Rank',
                    'label' => 'Rank',
                    'type' => 'select',
                    'options' => ['Đồng', 'Bạc', 'Vàng', 'Bạch Kim', 'Kim Cương', 'Tinh Anh', 'Cao Thủ', 'Chiến Tướng', 'Thách Đấu'],
                ],
                [
                    'key' => 'Tướng',
                    'label' => 'Số lượng Tướng',
                    'type' => 'text',
                    'placeholder' => 'VD: 115',
                    'suggestions' => ['30', '50', '80', '100', 'Full tướng'],
                ],
                [
                    'key' => 'Trang Phục',
                    'label' => 'Số lượng Skin',
                    'type' => 'text',
                    'placeholder' => 'VD: 250',
                    'suggestions' => ['50', '100', '200', '300', '400+'],
                ],
                [
                    'key' => 'Bậc Ngọc',
                    'label' => 'Bậc Ngọc',
                    'type' => 'select',
                    'options' => ['Ngọc 90 (Full)', 'Ngọc 60 - 89', 'Chưa full 90'],
                ],
                [
                    'key' => 'Đăng ký',
                    'label' => 'Tình trạng Đăng ký',
                    'type' => 'select',
                    'options' => ['Trắng thông tin', 'Garena sạch', 'Facebook', 'SĐT đổi được'],
                ],
            ],
        ],

        'free-fire' => [
            'name' => 'Free Fire',
            'aliases' => ['free-fire', 'ff', 'freefire', 'garena-free-fire'],
            'attributes' => [
                [
                    'key' => 'Rank',
                    'label' => 'Rank',
                    'type' => 'select',
                    'options' => ['Đồng', 'Bạc', 'Vàng', 'Bạch Kim', 'Kim Cương', 'Huyền Thoại', 'Đại Cao Thủ'],
                ],
                [
                    'key' => 'Skin Súng VIP',
                    'label' => 'Skin Súng VIP',
                    'type' => 'select',
                    'options' => ['AK Rồng Xanh', 'Scar Cá Mập', 'MP40 Mãng Xà', 'M1014 Long Tộc', 'XM8 Lôi Thần', 'UMP Phong Cách', 'Nhiều súng VIP Lv7', 'Không có'],
                ],
                [
                    'key' => 'Đăng ký',
                    'label' => 'Tình trạng Đăng ký',
                    'type' => 'select',
                    'options' => ['Trắng thông tin', 'Facebook sạch', 'Google', 'VK', 'Twitter'],
                ],
                [
                    'key' => 'Pet',
                    'label' => 'Pet',
                    'type' => 'select',
                    'options' => ['Full Pet', 'Nhiều Pet', 'Có Pet trợ thủ', 'Không có'],
                ],
                [
                    'key' => 'Thẻ Vô Cực',
                    'label' => 'Thẻ Vô Cực / Booyah Pass',
                    'type' => 'select',
                    'options' => ['Nhiều mùa cũ (Mùa 1-5)', 'Full Booyah Pass', 'Một vài mùa', 'Không có'],
                ],
            ],
        ],

        'blox-fruits' => [
            'name' => 'Blox Fruits (Roblox)',
            'aliases' => ['blox-fruits', 'blox-fruit', 'bloxfruits', 'bloxfruit', 'bf'],
            'attributes' => [
                [
                    'key' => 'Level',
                    'label' => 'Level',
                    'type' => 'select',
                    'options' => ['Max (2550)', '2000+', '1500+ (Sea 3)', '700+ (Sea 2)', 'Dưới 700 (Sea 1)'],
                ],
                [
                    'key' => 'Trái Ác Quỷ',
                    'label' => 'Trái Ác Quỷ chính',
                    'type' => 'select',
                    'options' => ['Kitsune', 'Leopard', 'Dragon', 'Dough (Bánh Quy V2)', 'T-Rex', 'Mammoth', 'Venom', 'Spirit', 'Buddha (Phật V2)', 'Portal', 'Blizzard', 'Magma V2', 'Khác / Random'],
                ],
                [
                    'key' => 'Melee V2',
                    'label' => 'Võ thuật (Melee)',
                    'type' => 'select',
                    'options' => ['Godhuman (Full Melee)', 'Superhuman', 'Electric Claw', 'Dragon Talon', 'Sharkman Karate', 'Death Step', 'Đang cày'],
                ],
                [
                    'key' => 'Kiếm Mythical',
                    'label' => 'Kiếm Mythical',
                    'type' => 'select',
                    'options' => ['Cursed Dual Katana (CDK)', 'True Triple Katana (TTK)', 'Dark Blade (Yoru)', 'Hallow Scythe', 'Shark Anchor', 'Full Kiếm Legendary/Mythical', 'Chưa có'],
                ],
                [
                    'key' => 'Tộc V4',
                    'label' => 'Tộc V4',
                    'type' => 'select',
                    'options' => ['Human V4 (Full Gear)', 'Mink V4 (Full Gear)', 'Fishman V4 (Full Gear)', 'Skypiea V4 (Full Gear)', 'Ghoul V4 (Full Gear)', 'Cyborg V4 (Full Gear)', 'V4 Chưa Full Gear', 'Tộc V3', 'Chưa thức tỉnh'],
                ],
                [
                    'key' => 'Beli & Fragments',
                    'label' => 'Beli & Fragment',
                    'type' => 'text',
                    'placeholder' => 'VD: 50M Beli / 30k Frag',
                    'suggestions' => ['10M+ Beli / 20k Frag', '50M+ Beli / 50k Frag', '100M+ Beli', 'Dưới 10M Beli'],
                ],
            ],
        ],

        'roblox' => [
            'name' => 'Roblox (Chung)',
            'aliases' => ['roblox', 'roblox-chung', 'roblox-account'],
            'attributes' => [
                [
                    'key' => 'Số dư Robux',
                    'label' => 'Số dư Robux',
                    'type' => 'text',
                    'placeholder' => 'VD: 1000 Robux Clean',
                    'suggestions' => ['0 Robux', '500 - 1,000 Robux', '2,000 - 5,000 Robux', '10,000+ Robux', 'Pending Robux'],
                ],
                [
                    'key' => 'Năm tạo Acc',
                    'label' => 'Năm tạo tài khoản',
                    'type' => 'select',
                    'options' => ['Acc Cổ (2008 - 2015)', '2016 - 2018', '2019 - 2021', '2022 - 2024', 'Acc Mới (2025+)'],
                ],
                [
                    'key' => 'Gamepass',
                    'label' => 'Gamepass Nổi Bật',
                    'type' => 'select',
                    'options' => ['Blox Fruits VIP/2x', 'King Legacy', 'Anime Defenders', 'Pet Simulator 99', 'Blade Ball', 'Nhiều Gamepass', 'Không có'],
                ],
                [
                    'key' => 'Tình trạng Pin / Mail',
                    'label' => 'Bảo mật (Pin / Mail)',
                    'type' => 'select',
                    'options' => ['Trắng Email / Chưa cài PIN', 'Đã gỡ Email (Clean)', 'Email Ảo', 'Đã xác minh 13+'],
                ],
            ],
        ],

        'fc-mobile' => [
            'name' => 'FC Mobile (FIFA Mobile)',
            'aliases' => ['fc-mobile', 'fifa-mobile', 'fcmobile', 'fifamobile', 'fifa'],
            'attributes' => [
                [
                    'key' => 'OVR Đội Hình',
                    'label' => 'OVR Đội Hình',
                    'type' => 'select',
                    'options' => ['106+ (Siêu VIP)', '101 - 105', '96 - 100', '90 - 95', 'Dưới 90'],
                ],
                [
                    'key' => 'Giá trị đội hình',
                    'label' => 'Giá trị Đội hình (Coins)',
                    'type' => 'text',
                    'placeholder' => 'VD: 2.5 Tỷ Coins',
                    'suggestions' => ['500M - 1B Coins', '1B - 3B Coins', '3B - 5B Coins', 'Trên 5B Coins'],
                ],
                [
                    'key' => 'Cầu thủ nổi bật',
                    'label' => 'Cầu thủ VIP',
                    'type' => 'select',
                    'options' => ['Ronaldo Nazario (R9)', 'Gullit', 'Zidane', 'Messi', 'Cristiano Ronaldo (CR7)', 'Mbappe', 'Cruyff / Maldini', 'Nhiều Icon VIP'],
                ],
                [
                    'key' => 'Đăng nhập',
                    'label' => 'Liên kết Đăng nhập',
                    'type' => 'select',
                    'options' => ['EA Account (Trắng mail)', 'Facebook sạch', 'Google Play', 'Apple ID'],
                ],
            ],
        ],

        'toc-chien' => [
            'name' => 'LMHT: Tốc Chiến',
            'aliases' => ['toc-chien', 'tocchien', 'wild-rift', 'wildrift', 'wr', 'lmht-toc-chien'],
            'attributes' => [
                [
                    'key' => 'Rank',
                    'label' => 'Rank',
                    'type' => 'select',
                    'options' => ['Sắt / Đồng / Bạc', 'Vàng', 'Bạch Kim', 'Lục Bảo', 'Kim Cương', 'Cao Thủ', 'Đại Cao Thủ', 'Thách Đấu'],
                ],
                [
                    'key' => 'Số Tướng',
                    'label' => 'Số lượng Tướng',
                    'type' => 'text',
                    'placeholder' => 'VD: 80',
                    'suggestions' => ['30+', '50+', '80+', 'Full Tướng'],
                ],
                [
                    'key' => 'Số Skin',
                    'label' => 'Số lượng Skin',
                    'type' => 'text',
                    'placeholder' => 'VD: 120',
                    'suggestions' => ['20+', '50+', '100+', '150+', '200+'],
                ],
                [
                    'key' => 'Skin Tối Thượng / Thần Thoại',
                    'label' => 'Skin Thần Thoại / Tối Thượng',
                    'type' => 'select',
                    'options' => ['Có nhiều Skin Thần Thoại', 'Có 1-2 Skin Tối Thượng', 'Skin Giới Hạn Wild Pass', 'Không có'],
                ],
                [
                    'key' => 'Đăng nhập',
                    'label' => 'Tài khoản Riot / VNG',
                    'type' => 'select',
                    'options' => ['Riot Games (Trắng mail)', 'VNG liên kết sạch', 'Facebook', 'Google Play'],
                ],
            ],
        ],

        'pubg-mobile' => [
            'name' => 'PUBG Mobile',
            'aliases' => ['pubg-mobile', 'pubg', 'pubgm', 'pubg-m'],
            'attributes' => [
                [
                    'key' => 'Rank',
                    'label' => 'Rank',
                    'type' => 'select',
                    'options' => ['Đồng / Bạc / Vàng', 'Bạch Kim', 'Kim Cương', 'Cao Thủ (Crown)', 'Quán Quân (Ace)', 'Chí Tôn (Conqueror)'],
                ],
                [
                    'key' => 'Skin Nâng Cấp (Súng Lab)',
                    'label' => 'Súng Nâng Cấp (Lab Gun)',
                    'type' => 'select',
                    'options' => ['M416 Băng (Glacier) Max', 'M416 Băng Lv4+', 'AWM Godzilla', 'AKM Băng', 'M762 Ngựa Hoang', 'Nhiều súng Lab', 'Không có'],
                ],
                [
                    'key' => 'Bộ Trang Phục VIP',
                    'label' => 'Bộ Trang Phục / X-Suit',
                    'type' => 'select',
                    'options' => ['X-Suit Pharaoh 6-7 sao', 'X-Suit Poseidon / Silvanus', 'Đồ Bape / Cổ Điển', 'Bộ Đồ Thần Thoại', 'Không có X-Suit'],
                ],
                [
                    'key' => 'Liên kết',
                    'label' => 'Tình trạng Liên kết',
                    'type' => 'select',
                    'options' => ['Trắng thông tin (Mail/SĐT)', 'Twitter / X sạch', 'Facebook sạch', 'Game Center / Apple ID'],
                ],
            ],
        ],

        'ngoc-rong-online' => [
            'name' => 'Ngọc Rồng Online (NRO)',
            'aliases' => ['ngoc-rong-online', 'ngoc-rong', 'nro', 'dragon-boy', 'chu-be-rong'],
            'attributes' => [
                [
                    'key' => 'Máy Chủ (Server)',
                    'label' => 'Máy chủ (Server)',
                    'type' => 'select',
                    'options' => ['Vũ Trụ 1', 'Vũ Trụ 2', 'Vũ Trụ 3', 'Vũ Trụ 4', 'Vũ Trụ 5', 'Vũ Trụ 6', 'Vũ Trụ 7', 'Vũ Trụ 8', 'Vũ Trụ 9', 'Vũ Trụ 10', 'Vũ Trụ 11', 'Vũ Trụ 12', 'Vũ Trụ 13', 'Sao Đen', 'Indo'],
                ],
                [
                    'key' => 'Hành Tinh',
                    'label' => 'Hành tinh',
                    'type' => 'select',
                    'options' => ['Trái Đất', 'Namếc', 'Xayda'],
                ],
                [
                    'key' => 'Sức Mạnh',
                    'label' => 'Mức Sức Mạnh',
                    'type' => 'select',
                    'options' => ['Sơ sinh (Dưới 1.5tr)', '1.5tr - 15tr (Nhiệm vụ Fide)', '40tr - 150tr', '1.5 tỷ - 20 tỷ', '40 tỷ - 80 tỷ', '100 tỷ+ (Max Sức Mạnh)'],
                ],
                [
                    'key' => 'Đệ Tử',
                    'label' => 'Đệ Tử',
                    'type' => 'select',
                    'options' => ['Chưa có đệ', 'Đệ Sơ sinh', 'Đệ Skill 2 Kamejoko / Masenko', 'Đệ Skill 3 Ttln / Kaioken', 'Đệ Ma Bư', 'Đệ Berus / Fide'],
                ],
                [
                    'key' => 'Bông Tai Porata',
                    'label' => 'Bông Tai Porata',
                    'type' => 'select',
                    'options' => ['Chưa có', 'Porata Cấp 1', 'Porata Cấp 2'],
                ],
                [
                    'key' => 'Đăng ký',
                    'label' => 'Tình trạng Đăng ký',
                    'type' => 'select',
                    'options' => ['Nick ảo (Trắng thông tin)', 'Gmail ảo (Đổi được)', 'Gmail thật (Chính chủ)', 'SĐT chính chủ'],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Helper function to find game preset key by category or game group
    |--------------------------------------------------------------------------
    */
    'resolve_preset' => function ($identifier) {
        $identifier = \Illuminate\Support\Str::slug($identifier);
        $games = config('game_attributes.games', []);
        
        foreach ($games as $key => $game) {
            if ($key === $identifier) {
                return $key;
            }
            if (isset($game['aliases']) && in_array($identifier, $game['aliases'])) {
                return $key;
            }
            // Substring match
            foreach ($game['aliases'] as $alias) {
                if (str_contains($identifier, $alias) || str_contains($alias, $identifier)) {
                    return $key;
                }
            }
        }
        return null;
    }
];
