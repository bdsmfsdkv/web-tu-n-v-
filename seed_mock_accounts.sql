-- Procedure tao tai khoan ao game_accounts
DELIMITER $$

DROP PROCEDURE IF EXISTS `SeedMockGameAccounts`$$

CREATE PROCEDURE `SeedMockGameAccounts`()
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE catId INT;
    DECLARE catPlatform VARCHAR(50);
    DECLARE done INT DEFAULT FALSE;
    
    DECLARE cur CURSOR FOR 
        SELECT id, platform FROM game_categories WHERE active = 1 AND id != 10;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO catId, catPlatform;
        IF done THEN
            LEAVE read_loop;
        END IF;

        SET i = 1;
        WHILE i <= 350 DO
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
                CONCAT('acc_', IFNULL(catPlatform, 'game'), '_', SUBSTRING(MD5(RAND()), 1, 8)),
                CONCAT('Pass@', FLOOR(100000 + RAND() * 900000)),
                ELT(FLOOR(1 + RAND() * 10), 30000, 50000, 80000, 120000, 150000, 200000, 250000, 350000, 500000, 1000000),
                IF(RAND() <= 0.85, 'available', 'sold'),
                NULL,
                CONCAT('Tài khoản VIP #', i),
                CASE 
                    WHEN catPlatform = 'lien-quan' THEN
                        JSON_ARRAY(
                            JSON_OBJECT('key', 'Rank', 'value', ELT(FLOOR(1 + RAND() * 5), 'Bạch Kim', 'Kim Cương', 'Tinh Anh', 'Cao Thủ', 'Chiến Tướng')),
                            JSON_OBJECT('key', 'Tướng', 'value', CAST(FLOOR(40 + RAND() * 75) AS CHAR)),
                            JSON_OBJECT('key', 'Trang Phục', 'value', CAST(FLOOR(30 + RAND() * 300) AS CHAR)),
                            JSON_OBJECT('key', 'Bậc Ngọc', 'value', IF(RAND() > 0.3, 'Ngọc 90 (Full)', 'Ngọc 60 - 89')),
                            JSON_OBJECT('key', 'Đăng ký', 'value', IF(RAND() > 0.4, 'Trắng thông tin', 'Garena sạch'))
                        )
                    WHEN catPlatform = 'free-fire' THEN
                        JSON_ARRAY(
                            JSON_OBJECT('key', 'Rank', 'value', ELT(FLOOR(1 + RAND() * 4), 'Bạch Kim', 'Kim Cương', 'Huyền Thoại', 'Đại Cao Thủ')),
                            JSON_OBJECT('key', 'Skin Súng VIP', 'value', ELT(FLOOR(1 + RAND() * 5), 'AK Rồng Xanh', 'Scar Cá Mập', 'MP40 Mãng Xà', 'XM8 Lôi Thần', 'Nhiều súng VIP Lv7')),
                            JSON_OBJECT('key', 'Đăng ký', 'value', IF(RAND() > 0.4, 'Trắng thông tin', 'Facebook sạch')),
                            JSON_OBJECT('key', 'Pet', 'value', IF(RAND() > 0.3, 'Full Pet', 'Có Pet trợ thủ')),
                            JSON_OBJECT('key', 'Thẻ Vô Cực', 'value', IF(RAND() > 0.5, 'Nhiều mùa cũ (Mùa 1-5)', 'Một vài mùa'))
                        )
                    WHEN catPlatform = 'blox-fruits' THEN
                        JSON_ARRAY(
                            JSON_OBJECT('key', 'Level', 'value', IF(RAND() > 0.3, 'Max (2550)', '2000+')),
                            JSON_OBJECT('key', 'Trái Ác Quỷ', 'value', ELT(FLOOR(1 + RAND() * 6), 'Kitsune', 'Dragon', 'Dough (Bánh Quy V2)', 'Buddha (Phật V2)', 'T-Rex', 'Leopard')),
                            JSON_OBJECT('key', 'Melee V2', 'value', ELT(FLOOR(1 + RAND() * 3), 'Godhuman (Full Melee)', 'Superhuman', 'Electric Claw')),
                            JSON_OBJECT('key', 'Kiếm Mythical', 'value', ELT(FLOOR(1 + RAND() * 3), 'Cursed Dual Katana (CDK)', 'True Triple Katana (TTK)', 'Dark Blade (Yoru)')),
                            JSON_OBJECT('key', 'Tộc V4', 'value', ELT(FLOOR(1 + RAND() * 4), 'Human V4 (Full Gear)', 'Mink V4 (Full Gear)', 'Fishman V4 (Full Gear)', 'Cyborg V4 (Full Gear)')),
                            JSON_OBJECT('key', 'Beli & Fragments', 'value', CONCAT(FLOOR(10 + RAND() * 80), 'M+ Beli / ', FLOOR(10 + RAND() * 50), 'k Frag'))
                        )
                    WHEN catPlatform = 'roblox' THEN
                        JSON_ARRAY(
                            JSON_OBJECT('key', 'Số dư Robux', 'value', ELT(FLOOR(1 + RAND() * 4), '500 - 1,000 Robux', '2,000 - 5,000 Robux', '10,000+ Robux', '0 Robux')),
                            JSON_OBJECT('key', 'Năm tạo Acc', 'value', IF(RAND() > 0.5, 'Acc Cổ (2008 - 2015)', '2019 - 2021')),
                            JSON_OBJECT('key', 'Gamepass', 'value', IF(RAND() > 0.4, 'Blox Fruits VIP/2x', 'Nhiều Gamepass')),
                            JSON_OBJECT('key', 'Tình trạng Pin / Mail', 'value', 'Trắng Email / Chưa cài PIN')
                        )
                    WHEN catPlatform = 'fc-mobile' THEN
                        JSON_ARRAY(
                            JSON_OBJECT('key', 'OVR Đội Hình', 'value', ELT(FLOOR(1 + RAND() * 3), '106+ (Siêu VIP)', '101 - 105', '96 - 100')),
                            JSON_OBJECT('key', 'Giá trị đội hình', 'value', CONCAT(FLOOR(1 + RAND() * 8), 'B - ', FLOOR(9 + RAND() * 10), 'B Coins')),
                            JSON_OBJECT('key', 'Cầu thủ nổi bật', 'value', ELT(FLOOR(1 + RAND() * 5), 'Ronaldo Nazario (R9)', 'Gullit', 'Zidane', 'Messi', 'Cristiano Ronaldo (CR7)')),
                            JSON_OBJECT('key', 'Đăng nhập', 'value', 'EA Account (Trắng mail)')
                        )
                    WHEN catPlatform = 'toc-chien' THEN
                        JSON_ARRAY(
                            JSON_OBJECT('key', 'Rank', 'value', ELT(FLOOR(1 + RAND() * 4), 'Kim Cương', 'Cao Thủ', 'Đại Cao Thủ', 'Thách Đấu')),
                            JSON_OBJECT('key', 'Số Tướng', 'value', CAST(FLOOR(50 + RAND() * 45) AS CHAR)),
                            JSON_OBJECT('key', 'Số Skin', 'value', CAST(FLOOR(40 + RAND() * 140) AS CHAR)),
                            JSON_OBJECT('key', 'Skin Tối Thượng / Thần Thoại', 'value', IF(RAND() > 0.4, 'Có nhiều Skin Thần Thoại', 'Có 1-2 Skin Tối Thượng')),
                            JSON_OBJECT('key', 'Đăng nhập', 'value', 'Riot Games (Trắng mail)')
                        )
                    WHEN catPlatform = 'pubg-mobile' THEN
                        JSON_ARRAY(
                            JSON_OBJECT('key', 'Rank', 'value', ELT(FLOOR(1 + RAND() * 4), 'Kim Cương', 'Cao Thủ (Crown)', 'Quán Quân (Ace)', 'Chí Tôn (Conqueror)')),
                            JSON_OBJECT('key', 'Skin Nâng Cấp (Súng Lab)', 'value', ELT(FLOOR(1 + RAND() * 4), 'M416 Băng (Glacier) Max', 'M416 Băng Lv4+', 'AWM Godzilla', 'AKM Băng')),
                            JSON_OBJECT('key', 'Bộ Trang Phục VIP', 'value', IF(RAND() > 0.5, 'X-Suit Pharaoh 6-7 sao', 'Bộ Đồ Thần Thoại')),
                            JSON_OBJECT('key', 'Liên kết', 'value', 'Trắng thông tin (Mail/SĐT)')
                        )
                    WHEN catPlatform = 'ngoc-rong-online' THEN
                        JSON_ARRAY(
                            JSON_OBJECT('key', 'Máy Chủ (Server)', 'value', CONCAT('Vũ Trụ ', FLOOR(1 + RAND() * 13))),
                            JSON_OBJECT('key', 'Hành Tinh', 'value', ELT(FLOOR(1 + RAND() * 3), 'Trái Đất', 'Namếc', 'Xayda')),
                            JSON_OBJECT('key', 'Sức Mạnh', 'value', ELT(FLOOR(1 + RAND() * 3), '40 tỷ - 80 tỷ', '100 tỷ+ (Max Sức Mạnh)', '1.5 tỷ - 20 tỷ')),
                            JSON_OBJECT('key', 'Đệ Tử', 'value', ELT(FLOOR(1 + RAND() * 3), 'Đệ Skill 2 Kamejoko / Masenko', 'Đệ Ma Bư', 'Đệ Berus / Fide')),
                            JSON_OBJECT('key', 'Bông Tai Porata', 'value', IF(RAND() > 0.3, 'Porata Cấp 2', 'Porata Cấp 1')),
                            JSON_OBJECT('key', 'Đăng ký', 'value', 'Nick ảo (Trắng thông tin)')
                        )
                    ELSE
                        JSON_ARRAY(
                            JSON_OBJECT('key', 'Loại tài khoản', 'value', 'VIP'),
                            JSON_OBJECT('key', 'Thông tin', 'value', 'Trắng thông tin')
                        )
                END,
                'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg',
                JSON_ARRAY('https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg'),
                NOW(),
                NOW()
            );
            SET i = i + 1;
        END WHILE;
    END LOOP;
    CLOSE cur;
END$$

-- Procedure tao tai khoan ao random_category_accounts
DROP PROCEDURE IF EXISTS `SeedMockRandomAccounts`$$

CREATE PROCEDURE `SeedMockRandomAccounts`()
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE randCatId INT;
    DECLARE randCatName VARCHAR(255);
    DECLARE randCatThumb VARCHAR(255);
    DECLARE done INT DEFAULT FALSE;
    
    DECLARE cur CURSOR FOR 
        SELECT id, name, thumbnail FROM random_categories WHERE active = 1;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO randCatId, randCatName, randCatThumb;
        IF done THEN
            LEAVE read_loop;
        END IF;

        SET i = 1;
        WHILE i <= 500 DO
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
                randCatId,
                CONCAT('rand_', SUBSTRING(MD5(RAND()), 1, 8)),
                CONCAT('Pass@', FLOOR(100000 + RAND() * 900000)),
                ELT(FLOOR(1 + RAND() * 6), 20000, 50000, 100000, 150000, 200000, 300000),
                IF(RAND() <= 0.85, 'available', 'sold'),
                FLOOR(1 + RAND() * 10),
                NULL,
                CONCAT('BATCH_', DATE_FORMAT(NOW(), '%Y%m%d')),
                CONCAT('Tài khoản ngẫu nhiên ', randCatName),
                'Chúc bạn chơi game vui vẻ!',
                IFNULL(randCatThumb, 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg'),
                NOW(),
                NOW()
            );
            SET i = i + 1;
        END WHILE;
    END LOOP;
    CLOSE cur;
END$$

DELIMITER ;

-- Lenh thuc thi:
-- CALL SeedMockGameAccounts();
-- CALL SeedMockRandomAccounts();
-- DROP PROCEDURE IF EXISTS `SeedMockGameAccounts`;
-- DROP PROCEDURE IF EXISTS `SeedMockRandomAccounts`;
