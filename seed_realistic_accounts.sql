-- Seed data tai khoan that, tu nhien cho cac danh muc game
DELIMITER $$

DROP PROCEDURE IF EXISTS `SeedRealisticAccounts`$$

CREATE PROCEDURE `SeedRealisticAccounts`()
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE catId INT;
    DECLARE catPlatform VARCHAR(50);
    DECLARE catName VARCHAR(255);
    DECLARE done INT DEFAULT FALSE;
    
    DECLARE v_username VARCHAR(100);
    DECLARE v_pass VARCHAR(100);
    DECLARE v_note TEXT;
    DECLARE v_price BIGINT;
    DECLARE v_thumb VARCHAR(500);
    DECLARE v_images JSON;
    DECLARE v_details JSON;
    DECLARE v_status VARCHAR(20);
    DECLARE v_created DATETIME;
    
    DECLARE cur CURSOR FOR 
        SELECT id, platform, name FROM game_categories WHERE active = 1;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Xoa du lieu acc cu de thay bang acc chuan giong nguoi dung that
    DELETE FROM `game_accounts`;
    DELETE FROM `random_category_accounts`;

    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO catId, catPlatform, catName;
        IF done THEN
            LEAVE read_loop;
        END IF;

        SET i = 1;
        WHILE i <= 350 DO
            -- Random thoi gian tao trong 60 ngay qua cho tu nhien
            SET v_created = DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 86400 * 60) SECOND);
            SET v_status = IF(RAND() <= 0.82, 'available', 'sold');

            -- Xu ly tung loai game
            IF catPlatform = 'lien-quan' OR catName LIKE '%Liên Quân%' THEN
                -- Username giong that
                SET v_username = CONCAT(
                    ELT(FLOOR(1 + RAND() * 20), 'hoanglong', 'tuananh', 'minhduc', 'nguyenquang', 'anhquan', 'tranquoc', 'ducphuc', 'phanthanh', 'thanhdat', 'khanhsky', 'haidang', 'trungduc', 'leminh', 'duchuy', 'vanthang', 'ngocthach', 'quocbao', 'tiendat', 'huynhtan', 'thanhhung'),
                    ELT(FLOOR(1 + RAND() * 10), '2002', '2003', '2004', '2005', '99', 'pro', 'vip', 'boy', 'gaming', 'vn'),
                    FLOOR(10 + RAND() * 90)
                );
                SET v_pass = CONCAT(
                    ELT(FLOOR(1 + RAND() * 10), 'Long', 'Tuan', 'Anh', 'Minh', 'Dat', 'Huy', 'Duc', 'Bao', 'Khang', 'Thanh'),
                    FLOOR(1000 + RAND() * 9000),
                    ELT(FLOOR(1 + RAND() * 4), '@', '#', '!', '')
                );
                SET v_price = ELT(FLOOR(1 + RAND() * 12), 40000, 70000, 100000, 150000, 220000, 350000, 480000, 650000, 850000, 1200000, 1800000, 2500000);
                SET v_note = ELT(FLOOR(1 + RAND() * 10),
                    'Nick chính chủ từ mùa 3, full tướng, ngọc chuẩn 90 mọi vị trí đi rừng/mid/top.',
                    'Acc tâm huyết nhiều skin bậc S+ và Tuyệt Sắc (Nakroth Thứ Nguyên, Raz Muay Thái, Tulen Chí Tôn). Trắng thông tin.',
                    'Nick rank Cao Thủ sao cao, winrate 65%, nhiều trang phục SS hữu hạn, đổi được full thông tin.',
                    'Acc học sinh thanh lý rẻ, có sẵn 15k vàng và 50 vé quay kho báu, test tướng thoải mái.',
                    'Acc leo rank chuẩn, full ngọc 90 phép/công vật lý/xuyên giáp, nhiều thẻ thử tướng.',
                    'Nick đầy đủ dàn skin SSS giới hạn, Raz Siêu Việt, Lauriel Thứ Nguyên Vệ Thần, trắng mail.',
                    'Acc phụ ít chơi bán lại cho ae leo rank, tướng tủ Florentino, Nakroth, Capheny.',
                    'Acc sạch sẽ, chưa từng liên kết FB, bảo hành trọn đời lỗi back.',
                    'Nick cày cuốc mùa này đã lên Chiến Tướng 30 sao, tướng 110+, skin đẹp mắt.',
                    'Acc vip giá học sinh, có sẵn combo skin Nak Lôi Quang + Violet Pháo Hoa.'
                );
                SET v_thumb = ELT(FLOOR(1 + RAND() * 5),
                    'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg',
                    'https://i.postimg.cc/qq3pynYh/20240215164859nickhsnr.jpg',
                    'https://i.postimg.cc/d3kV6g70/Th-V-n-May-Ng-c-R-ng-Vip-3.jpg',
                    'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg',
                    'https://i.postimg.cc/qq3pynYh/20240215164859nickhsnr.jpg'
                );
                SET v_images = JSON_ARRAY(v_thumb, v_thumb, v_thumb);
                SET v_details = JSON_ARRAY(
                    JSON_OBJECT('key', 'Rank', 'value', ELT(FLOOR(1 + RAND() * 6), 'Bạch Kim I', 'Kim Cương III', 'Tinh Anh I', 'Cao Thủ 15 Sao', 'Chiến Tướng 35 Sao', 'Thách Đấu')),
                    JSON_OBJECT('key', 'Tướng', 'value', CONCAT(FLOOR(50 + RAND() * 66), ' Tướng')),
                    JSON_OBJECT('key', 'Trang Phục', 'value', CONCAT(FLOOR(40 + RAND() * 320), ' Trang Phục')),
                    JSON_OBJECT('key', 'Bậc Ngọc', 'value', IF(RAND() > 0.25, 'Ngọc 90 (Full Bảng)', 'Ngọc 85+')),
                    JSON_OBJECT('key', 'Đăng ký', 'value', IF(RAND() > 0.35, 'Trắng thông tin', 'Garena sạch đổi được'))
                );

            ELSEIF catPlatform = 'free-fire' OR catName LIKE '%Free Fire%' THEN
                SET v_username = CONCAT(
                    ELT(FLOOR(1 + RAND() * 15), 'ff_badboy', 'quydaica', 'trumff', 'darklord', 'killer', 'sat_thu', 'shadow', 'hunter', 'dragonff', 'sniper_pro', 'onehit', 'phongba', 'fireking', 'headshot', 'tanff'),
                    '_',
                    FLOOR(100 + RAND() * 900)
                );
                SET v_pass = CONCAT('ff', FLOOR(100000 + RAND() * 900000), '@');
                SET v_price = ELT(FLOOR(1 + RAND() * 10), 30000, 60000, 120000, 250000, 450000, 700000, 1100000, 1600000, 2200000, 3500000);
                SET v_note = ELT(FLOOR(1 + RAND() * 8),
                    'Nick có AK Rồng Xanh Lv7 max hiệu ứng bắn cực đã, kèm MP40 Mãng Xà Lv6.',
                    'Acc full trợ thủ, nhiều gói đồ nam nữ phối cực chất từ SS1 đến SS10.',
                    'Tài khoản đăng ký Facebook sạch gỡ số, nhiều súng tăng dame, thẻ vô cực 15 mùa.',
                    'Acc tâm huyết thanh lý nghỉ game, có Scar Cá Mập Đen Lv7 + M1014 Long Tộc Lv5.',
                    'Nick rank Huyền Thoại mùa này, K/D 4.5, nhiều emote nhảy độc lạ.',
                    'Acc học sinh trắng thông tin, có UMP Phong Cách + XM8 Lôi Thần Lv4.',
                    'Nick giàu skin súng lab nâng cấp, đồ hiphop cổ, pet cáo tuyết, đại bàng full cấp.',
                    'Acc giá rẻ cày rank, nhiều skin súng cam vĩnh viễn, đồ bộ Nam Thần.'
                );
                SET v_thumb = 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg';
                SET v_images = JSON_ARRAY(v_thumb, v_thumb, v_thumb);
                SET v_details = JSON_ARRAY(
                    JSON_OBJECT('key', 'Rank', 'value', ELT(FLOOR(1 + RAND() * 5), 'Bạch Kim', 'Kim Cương IV', 'Huyền Thoại 3200đ', 'Huyền Thoại 4500đ', 'Đại Cao Thủ')),
                    JSON_OBJECT('key', 'Skin Súng VIP', 'value', ELT(FLOOR(1 + RAND() * 6), 'AK Rồng Xanh Lv7', 'MP40 Mãng Xà Lv6', 'Scar Cá Mập Lv7', 'M1014 Long Tộc Lv5', 'XM8 Lôi Thần Lv7', 'Nhiều súng VIP Lv6-7')),
                    JSON_OBJECT('key', 'Đăng ký', 'value', IF(RAND() > 0.4, 'Trắng thông tin', 'Facebook chính chủ (Gỡ SĐT)')),
                    JSON_OBJECT('key', 'Pet', 'value', IF(RAND() > 0.3, 'Full 18/18 Pet', '12 Pet Trợ Thủ')),
                    JSON_OBJECT('key', 'Thẻ Vô Cực', 'value', ELT(FLOOR(1 + RAND() * 4), 'Mùa 1 - Mùa 8 Cổ', 'Full Booyah Pass', '10+ Thẻ Vô Cực', '5 Thẻ Vô Cực'))
                );

            ELSEIF catPlatform = 'blox-fruits' OR catName LIKE '%Blox Fruits%' THEN
                SET v_username = CONCAT(
                    ELT(FLOOR(1 + RAND() * 15), 'roblox_pro', 'dragon_slayer', 'kitsune_user', 'godhuman_king', 'shadow_blade', 'sea3_hunter', 'bloxfruit_master', 'anime_fan', 'cdk_master', 'v4_max', 'dough_v2', 'buddha_farm', 'yoru_king', 'fruit_finder', 'robloxian'),
                    FLOOR(100 + RAND() * 9900)
                );
                SET v_pass = CONCAT('Rb', FLOOR(100000 + RAND() * 900000), '!');
                SET v_price = ELT(FLOOR(1 + RAND() * 10), 50000, 90000, 150000, 250000, 380000, 550000, 850000, 1250000, 1800000, 2400000);
                SET v_note = ELT(FLOOR(1 + RAND() * 8),
                    'Nick Max Level 2550, đã ăn Kitsune vĩnh viễn, võ Godhuman 600 mastery, kiếm CDK.',
                    'Acc Blox Fruits Sea 3, có Dough V2 thức tỉnh full skill, Tộc Human V4 full gear chiến pvp cực gắt.',
                    'Nick cày sẵn Buddha V2 farm siêu nhanh, 80M Beli + 45k Fragments, dư sức đổi chỉ số.',
                    'Acc có Dark Blade (Yoru) V3 + True Triple Katana (TTK), võ Sharkman Karate + Electric Claw.',
                    'Acc trắng thông tin 100% chưa xác minh email/sđt, vào đổi pass ngay, bảo hành trọn đời.',
                    'Nick sở hữu Trái Rồng (Dragon) rework, Tộc Cyborg V4 full gear, súng Soul Guitar.',
                    'Acc vip pvp 30M Bounty hải tặc, full kiếm Mythical, áo choàng râu đen.',
                    'Nick cày cuốc clean không tool script, đầy đủ nguyên liệu nâng cấp đồ.'
                );
                SET v_thumb = 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg';
                SET v_images = JSON_ARRAY(v_thumb, v_thumb, v_thumb);
                SET v_details = JSON_ARRAY(
                    JSON_OBJECT('key', 'Level', 'value', IF(RAND() > 0.15, 'Max (2550)', '2450+ (Sea 3)')),
                    JSON_OBJECT('key', 'Trái Ác Quỷ', 'value', ELT(FLOOR(1 + RAND() * 7), 'Kitsune (Đang dùng)', 'Dragon (Đã thức tỉnh)', 'Dough V2 (Full Skill)', 'Buddha V2 (Max Farm)', 'T-Rex Mythical', 'Leopard (Báo Đốm)', 'Portal V2')),
                    JSON_OBJECT('key', 'Melee V2', 'value', ELT(FLOOR(1 + RAND() * 4), 'Godhuman (600 Mas)', 'Superhuman + E-Claw', 'Dragon Talon 600 Mas', 'Sharkman Karate V2')),
                    JSON_OBJECT('key', 'Kiếm Mythical', 'value', ELT(FLOOR(1 + RAND() * 4), 'Cursed Dual Katana (CDK)', 'True Triple Katana (TTK)', 'Dark Blade (Yoru) V3', 'Hallow Scythe + Shark Anchor')),
                    JSON_OBJECT('key', 'Tộc V4', 'value', ELT(FLOOR(1 + RAND() * 5), 'Human V4 (Full Gear)', 'Mink V4 (Full Gear)', 'Fishman V4 (Full Gear)', 'Cyborg V4 (Full Gear)', 'Ghoul V4 (Full Gear)')),
                    JSON_OBJECT('key', 'Beli & Fragments', 'value', CONCAT(FLOOR(20 + RAND() * 80), 'M Beli / ', FLOOR(20 + RAND() * 60), 'k Fragments'))
                );

            ELSEIF catPlatform = 'roblox' OR catName LIKE '%Roblox%' THEN
                SET v_username = CONCAT(
                    ELT(FLOOR(1 + RAND() * 12), 'x_roblox', 'dev_builder', 'og_account', 'clean_rbx', 'vintage_user', 'avatar_pro', 'gamer_tag', 'roblox_vn', 'blox_legend', 'noob_master', 'cool_kid', 'rich_rbx'),
                    FLOOR(10 + RAND() * 990)
                );
                SET v_pass = CONCAT('Roblox@', FLOOR(10000 + RAND() * 90000));
                SET v_price = ELT(FLOOR(1 + RAND() * 8), 50000, 100000, 200000, 350000, 600000, 1000000, 1500000, 2500000);
                SET v_note = ELT(FLOOR(1 + RAND() * 6),
                    'Tài khoản Roblox cổ tạo từ năm 2016, avatar nhiều item giới hạn (Limited) giá trị cao.',
                    'Acc có sẵn 3,500 Robux Clean nạp từ thẻ cào, trắng email chưa cài mã PIN 4 số.',
                    'Nick sở hữu nhiều Gamepass đắt đỏ trong Blox Fruits, Blade Ball, Pet Sim 99.',
                    'Acc cổ 2018 trắng thông tin hoàn toàn, kèm nhiều badge hiếm của các event cũ.',
                    'Tài khoản sạch, giao dịch an toàn, hỗ trợ hướng dẫn đổi mật khẩu và bảo mật 2 lớp.'
                );
                SET v_thumb = 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg';
                SET v_images = JSON_ARRAY(v_thumb, v_thumb, v_thumb);
                SET v_details = JSON_ARRAY(
                    JSON_OBJECT('key', 'Số dư Robux', 'value', ELT(FLOOR(1 + RAND() * 5), '1,000 Robux Clean', '2,500 Robux Clean', '5,000 Robux Clean', '10,000+ Robux', 'Pending 800 Robux')),
                    JSON_OBJECT('key', 'Năm tạo Acc', 'value', ELT(FLOOR(1 + RAND() * 4), 'Acc Cổ (2015 - 2017)', '2018 - 2020', '2021 - 2023', 'Acc Mới (2024 - 2025)')),
                    JSON_OBJECT('key', 'Gamepass', 'value', ELT(FLOOR(1 + RAND() * 4), 'Blox Fruits 2x Mastery/Money', 'King Legacy VIP', 'Pet Simulator 99 VIP', 'Blade Ball Pass')),
                    JSON_OBJECT('key', 'Tình trạng Pin / Mail', 'value', 'Trắng Email / Chưa cài PIN')
                );

            ELSEIF catPlatform = 'fc-mobile' OR catName LIKE '%FC Mobile%' THEN
                SET v_username = CONCAT(
                    ELT(FLOOR(1 + RAND() * 12), 'fcm_cr7', 'fcm_messi', 'fut_king', 'fifa_master', 'r9_legend', 'fc_champion', 'zidane_team', 'gold_squad', 'ea_sports_vn', 'goat_fc', 'super_team', 'ovr_vip'),
                    FLOOR(10 + RAND() * 990)
                );
                SET v_pass = CONCAT('FcMobile@', FLOOR(1000 + RAND() * 9000));
                SET v_price = ELT(FLOOR(1 + RAND() * 9), 60000, 120000, 250000, 450000, 750000, 1200000, 1800000, 2600000, 3800000);
                SET v_note = ELT(FLOOR(1 + RAND() * 6),
                    'Đội hình OVR 106 siêu khủng, có R9 Icon TOTY rank đỏ, Gullit, Maldini max cấp huấn luyện.',
                    'Tài khoản liên kết EA Sports trắng email, giá trị đội hình hơn 5 tỷ Coins, nhiều thẻ cầu thủ dự bị xịn.',
                    'Đội hình OVR 103 chuẩn meta, Zidane + Messi + Mbappe hàng công siêu tốc độ.',
                    'Acc tâm huyết leo H2H rank Champion, lực chiến mạnh, đá cực mượt không lag.',
                    'Nick thanh lý giá rẻ cho ae yêu thích bóng đá, có sẵn 800 triệu Coins tiền mặt.'
                );
                SET v_thumb = 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg';
                SET v_images = JSON_ARRAY(v_thumb, v_thumb, v_thumb);
                SET v_details = JSON_ARRAY(
                    JSON_OBJECT('key', 'OVR Đội Hình', 'value', ELT(FLOOR(1 + RAND() * 4), '107 (Siêu VIP)', '105 (Khủng)', '102 (Chuẩn Meta)', '98 - 100')),
                    JSON_OBJECT('key', 'Giá trị đội hình', 'value', CONCAT(FLOOR(2 + RAND() * 10), ' Tỷ Coins')),
                    JSON_OBJECT('key', 'Cầu thủ nổi bật', 'value', ELT(FLOOR(1 + RAND() * 5), 'Ronaldo De Lima (R9) + Gullit', 'Zidane Icon + Mbappe', 'Messi TOTY + CR7', 'Maldini + Cruyff Rank Đỏ', 'Full Đội Hình Icon VIP')),
                    JSON_OBJECT('key', 'Đăng nhập', 'value', 'EA Account (Trắng mail)')
                );

            ELSEIF catPlatform = 'toc-chien' OR catName LIKE '%Tốc Chiến%' THEN
                SET v_username = CONCAT(
                    ELT(FLOOR(1 + RAND() * 12), 'wr_faker', 'yasuo_chua', 'zed_shadow', 'wildrift_pro', 'ad_carry', 'sp_god', 'mid_lane', 'challenger_wr', 'lee_sin_vn', 'akali_vip', 'riot_gamer', 'wild_king'),
                    FLOOR(10 + RAND() * 990)
                );
                SET v_pass = CONCAT('Riot@', FLOOR(10000 + RAND() * 90000));
                SET v_price = ELT(FLOOR(1 + RAND() * 8), 50000, 90000, 180000, 320000, 550000, 850000, 1350000, 2100000);
                SET v_note = ELT(FLOOR(1 + RAND() * 6),
                    'Nick Tốc Chiến Rank Cao Thủ, full tướng đi mid/ad, nhiều skin Cao Bồi và Siêu Phẩm.',
                    'Acc Riot Games chính chủ trắng thông tin, đổi được mail và mật khẩu ngay lập tức.',
                    'Sở hữu skin Tối Thượng Lux Thập Đại Nguyên Tố, Ezreal Vũ Khí Tối Thượng, Yasuo Ma Kiếm.',
                    'Nick cày cuốc từ mùa 1, khung viền đẹp, biểu cảm độc quyền nhiều vô số.',
                    'Acc rank Kim Cương giá mềm cho ae leo rank cùng bạn bè, tỷ lệ thắng cao.'
                );
                SET v_thumb = 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg';
                SET v_images = JSON_ARRAY(v_thumb, v_thumb, v_thumb);
                SET v_details = JSON_ARRAY(
                    JSON_OBJECT('key', 'Rank', 'value', ELT(FLOOR(1 + RAND() * 5), 'Kim Cương I', 'Cao Thủ 25 Điểm', 'Đại Cao Thủ 40 Điểm', 'Thách Đấu', 'Lục Bảo II')),
                    JSON_OBJECT('key', 'Số Tướng', 'value', CONCAT(FLOOR(60 + RAND() * 45), ' Tướng')),
                    JSON_OBJECT('key', 'Số Skin', 'value', CONCAT(FLOOR(45 + RAND() * 160), ' Trang Phục')),
                    JSON_OBJECT('key', 'Skin Tối Thượng / Thần Thoại', 'value', IF(RAND() > 0.4, 'Có 3-5 Skin Thần Thoại/Tối Thượng', 'Skin Wild Pass Giới Hạn')),
                    JSON_OBJECT('key', 'Đăng nhập', 'value', 'Riot Games (Trắng mail)')
                );

            ELSEIF catPlatform = 'pubg-mobile' OR catName LIKE '%PUBG%' THEN
                SET v_username = CONCAT(
                    ELT(FLOOR(1 + RAND() * 12), 'pubg_sniper', 'glacier_m4', 'pharaoh_x', 'conqueror_vn', 'headshot_pubg', 'awm_god', 'dynamo_clone', 'pro_player', 'sat_thu_bo', 'top1_squad', 'pubgm_king', 'xsuit_vip'),
                    FLOOR(10 + RAND() * 990)
                );
                SET v_pass = CONCAT('Pubg@', FLOOR(10000 + RAND() * 90000));
                SET v_price = ELT(FLOOR(1 + RAND() * 8), 80000, 180000, 380000, 750000, 1400000, 2500000, 4200000, 6500000);
                SET v_note = ELT(FLOOR(1 + RAND() * 6),
                    'Nick PUBG Mobile có M416 Băng (Glacier) Max Lv7 hiệu ứng hòm xác tuyệt đẹp, AWM Godzilla Lv4.',
                    'Sở hữu X-Suit Pharaoh 6 sao full hiệu ứng xuất hiện + dù bay độc quyền, thẻ đổi tên có sẵn.',
                    'Acc rank Chí Tôn (Conqueror) có khung danh hiệu vĩnh viễn mùa cũ, K/D 5.2 cực khủng.',
                    'Tài khoản liên kết Twitter/X sạch, trắng số điện thoại và Gmail, bảo hành an toàn tuyệt đối.',
                    'Nick nhiều set đồ Thần Thoại cổ, xe Dacia Nâng Cấp, dù lượn và hòm đồ ngập tràn skin.'
                );
                SET v_thumb = 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg';
                SET v_images = JSON_ARRAY(v_thumb, v_thumb, v_thumb);
                SET v_details = JSON_ARRAY(
                    JSON_OBJECT('key', 'Rank', 'value', ELT(FLOOR(1 + RAND() * 4), 'Cao Thủ (Crown I)', 'Quán Quân (Ace Master)', 'Quán Quân 12 Sao', 'Chí Tôn (Conqueror)')),
                    JSON_OBJECT('key', 'Skin Nâng Cấp (Súng Lab)', 'value', ELT(FLOOR(1 + RAND() * 5), 'M416 Băng (Glacier) Max Lv7', 'M416 Băng Lv4 (Hiệu ứng kill)', 'AWM Godzilla Lv4 + AKM Băng', 'M762 Ngựa Hoang Lv5', 'Nhiều súng Lab nâng cấp')),
                    JSON_OBJECT('key', 'Bộ Trang Phục VIP', 'value', ELT(FLOOR(1 + RAND() * 4), 'X-Suit Pharaoh 6 Sao', 'X-Suit Poseidon 5 Sao', 'Set Đồ Thần Thoại Cổ', 'Set Vàng Hoàng Gia')),
                    JSON_OBJECT('key', 'Liên kết', 'value', 'Trắng thông tin (Twitter/X sạch)')
                );

            ELSEIF catPlatform = 'ngoc-rong-online' OR catName LIKE '%Ngọc Rồng%' OR catName LIKE '%NRO%' THEN
                SET v_username = CONCAT(
                    ELT(FLOOR(1 + RAND() * 15), 'nro_server', 'kamejoko', 'quocdat', 'songoku', 'cadic', 'xayda_vip', 'chuberong', 'detu_kame', 'porata_c2', 'nro_namron', 'thanmeo', 'bura', 'fide_dai_ca', 'kiemkhach', 'nro_pro'),
                    FLOOR(10 + RAND() * 990)
                );
                SET v_pass = CONCAT('Nro@', FLOOR(10000 + RAND() * 90000));
                SET v_price = ELT(FLOOR(1 + RAND() * 10), 25000, 50000, 90000, 160000, 280000, 450000, 750000, 1200000, 1800000, 2700000);
                SET v_note = ELT(FLOOR(1 + RAND() * 8),
                    'Nick Ngọc Rồng Online Server 1, sức mạnh 80 tỷ, đệ tử Fide skill 2 Kamejoko cực chuẩn.',
                    'Acc Trái Đất có Bông tai Porata Cấp 2, set đồ Kakarot 15% ki/hp, cải trang Yardrat.',
                    'Nick Namếc 100 tỷ max sức mạnh, đệ Ma Bư max cấp, set thần linh 7 sao ép ngọc rồng.',
                    'Acc sơ sinh cày win doanh trại, có sẵn đệ tử sơ sinh tiềm năng cao, nick ảo trắng thông tin.',
                    'Nick Xayda sức mạnh 65 tỷ, đệ skill 3 Kaioken gõ boss siêu thốn, cải trang Android 20.',
                    'Acc học sinh giá mềm, bông tai Porata c1, đồ họa đẹp mắt, vào test thoải mái.',
                    'Nick có sẵn 500 triệu vàng và 2k ngọc xanh chưa dùng, thích hợp ae mua về đập đồ.',
                    'Acc zin trắng thông tin 100%, không dính SĐT hay Gmail, đổi pass 1 nốt nhạc.'
                );
                SET v_thumb = 'https://i.postimg.cc/qq3pynYh/20240215164859nickhsnr.jpg';
                SET v_images = JSON_ARRAY(v_thumb, v_thumb, v_thumb);
                SET v_details = JSON_ARRAY(
                    JSON_OBJECT('key', 'Máy Chủ (Server)', 'value', CONCAT('Vũ Trụ ', FLOOR(1 + RAND() * 13))),
                    JSON_OBJECT('key', 'Hành Tinh', 'value', ELT(FLOOR(1 + RAND() * 3), 'Trái Đất', 'Namếc', 'Xayda')),
                    JSON_OBJECT('key', 'Sức Mạnh', 'value', ELT(FLOOR(1 + RAND() * 5), '80 Tỷ - 100 Tỷ (Max)', '40 Tỷ - 60 Tỷ', '15 Tỷ - 30 Tỷ', '1.5 Tỷ (Fide)', 'Sơ sinh (Dưới 1.5tr)')),
                    JSON_OBJECT('key', 'Đệ Tử', 'value', ELT(FLOOR(1 + RAND() * 5), 'Đệ Fide Skill 2 Kamejoko', 'Đệ Ma Bư Skill 2 Masenko', 'Đệ Skill 3 Kaioken', 'Đệ Berus VIP', 'Chưa có đệ (Sơ sinh)')),
                    JSON_OBJECT('key', 'Bông Tai Porata', 'value', IF(RAND() > 0.35, 'Porata Cấp 2', 'Porata Cấp 1')),
                    JSON_OBJECT('key', 'Đăng ký', 'value', 'Nick ảo (Trắng thông tin)')
                );

            ELSE
                -- Danh muc khac (Vong Quay May Man, vv)
                SET v_username = CONCAT(
                    ELT(FLOOR(1 + RAND() * 10), 'luckydraw', 'gift_account', 'acc_vip', 'reward_user', 'super_gift', 'spin_winner', 'gamer_pro', 'gold_reward', 'lucky_spin', 'random_vip'),
                    FLOOR(100 + RAND() * 900)
                );
                SET v_pass = CONCAT('Game@', FLOOR(10000 + RAND() * 90000));
                SET v_price = ELT(FLOOR(1 + RAND() * 6), 20000, 50000, 100000, 200000, 350000, 500000);
                SET v_note = ELT(FLOOR(1 + RAND() * 5),
                    'Tài khoản phần thưởng từ Vòng Quay May Mắn, trắng thông tin 100%.',
                    'Acc random giá trị cao, trúng thưởng ngẫu nhiên có nhiều vật phẩm VIP.',
                    'Tài khoản nhận ngay khi trúng thưởng, tự động cấp mã đăng nhập an toàn.',
                    'Nick phần thưởng hỗ trợ bảo hành 1 đổi 1 nếu sai mật khẩu.',
                    'Acc may mắn VIP, hỗ trợ chơi mượt mà trên mọi thiết bị.'
                );
                SET v_thumb = 'https://i.postimg.cc/d3kV6g70/Th-V-n-May-Ng-c-R-ng-Vip-3.jpg';
                SET v_images = JSON_ARRAY(v_thumb, v_thumb, v_thumb);
                SET v_details = JSON_ARRAY(
                    JSON_OBJECT('key', 'Phần thưởng', 'value', ELT(FLOOR(1 + RAND() * 5), 'Nick VIP Trúng Thưởng', 'Acc Thử Vận May 20k', 'Acc 100k Siêu Cấp', 'Acc Thần Thoại Giới Hạn', 'Acc Random Đặc Biệt')),
                    JSON_OBJECT('key', 'Tình trạng', 'value', 'Trắng thông tin 100%'),
                    JSON_OBJECT('key', 'Bảo hành', 'value', 'Đổi trả 1-1 nếu lỗi mật khẩu')
                );
            END IF;

            -- Insert vao database
            INSERT INTO `game_accounts` (
                `game_category_id`,
                `account_name`,
                `password`,
                `price`,
                `status`,
                `buyer_id`,
                `note`,
                `details`,
                `thumb`,
                `images`,
                `created_at`,
                `updated_at`
            ) VALUES (
                catId,
                v_username,
                v_pass,
                v_price,
                v_status,
                NULL,
                v_note,
                v_details,
                v_thumb,
                v_images,
                v_created,
                v_created
            );

            SET i = i + 1;
        END WHILE;
    END LOOP;
    CLOSE cur;

    -- Xu ly cho Random Category (Thu Van May)
    BEGIN
        DECLARE rDone INT DEFAULT FALSE;
        DECLARE rCatId INT;
        DECLARE rCatName VARCHAR(255);
        DECLARE rCatThumb VARCHAR(255);
        DECLARE rCur CURSOR FOR SELECT id, name, thumbnail FROM random_categories WHERE active = 1;
        DECLARE CONTINUE HANDLER FOR NOT FOUND SET rDone = TRUE;

        OPEN rCur;
        r_loop: LOOP
            FETCH rCur INTO rCatId, rCatName, rCatThumb;
            IF rDone THEN
                LEAVE r_loop;
            END IF;

            SET i = 1;
            WHILE i <= 500 DO
                SET v_created = DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 86400 * 60) SECOND);
                SET v_status = IF(RAND() <= 0.85, 'available', 'sold');

                INSERT INTO `random_category_accounts` (
                    `random_category_id`,
                    `account_name`,
                    `password`,
                    `price`,
                    `status`,
                    `server`,
                    `buyer_id`,
                    `batch_id`,
                    `note`,
                    `note_buyer`,
                    `thumbnail`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    rCatId,
                    CONCAT(
                        ELT(FLOOR(1 + RAND() * 15), 'nguyenlong', 'tuanfl', 'minhtri', 'ducphat', 'phucnguyen', 'hoangnam', 'anhkhoa', 'baoloc', 'quanghuy', 'thanhdat', 'trunghieu', 'duytan', 'vietanh', 'quockhanh', 'haidang'),
                        FLOOR(100 + RAND() * 900)
                    ),
                    CONCAT(
                        ELT(FLOOR(1 + RAND() * 8), 'Matkhau@', 'Passwd@', 'Player#', 'Gameacc!', 'Nickgame@', 'Vipgamer#', 'Sieunick!', 'Proacc@'),
                        FLOOR(1000 + RAND() * 9000)
                    ),
                    ELT(FLOOR(1 + RAND() * 6), 20000, 30000, 50000, 80000, 120000, 200000),
                    v_status,
                    FLOOR(1 + RAND() * 10),
                    NULL,
                    CONCAT('DOT_', DATE_FORMAT(v_created, '%Y%m%d')),
                    'Tài khoản ngẫu nhiên tỉ lệ trúng skin VIP cao.',
                    'Chúc bạn chơi game vui vẻ! Đổi mật khẩu ngay sau khi nhận tài khoản.',
                    IFNULL(rCatThumb, 'https://i.postimg.cc/d3kV6g70/Th-V-n-May-Ng-c-R-ng-Vip-3.jpg'),
                    v_created,
                    v_created
                );
                SET i = i + 1;
            END WHILE;
        END LOOP;
        CLOSE rCur;
    END;

END$$

DELIMITER ;
