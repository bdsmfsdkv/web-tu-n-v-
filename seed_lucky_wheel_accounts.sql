-- Procedure tao tai khoan ao cho game_category_id = 10 (Vong Quay May Man)
DELIMITER $$

DROP PROCEDURE IF EXISTS `SeedLuckyWheelCategoryAccounts`$$

CREATE PROCEDURE `SeedLuckyWheelCategoryAccounts`()
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE targetCatId INT DEFAULT 10;
    
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
            targetCatId,
            CONCAT('acc_vqmm_', SUBSTRING(MD5(RAND()), 1, 8)),
            CONCAT('Pass@', FLOOR(100000 + RAND() * 900000)),
            ELT(FLOOR(1 + RAND() * 6), 20000, 50000, 100000, 150000, 200000, 500000),
            IF(RAND() <= 0.85, 'available', 'sold'),
            NULL,
            CONCAT('Tài khoản Vòng Quay May Mắn #', i),
            JSON_ARRAY(
                JSON_OBJECT('key', 'Phần thưởng', 'value', ELT(FLOOR(1 + RAND() * 5), 'Nick VIP Trúng Thưởng', 'Acc Thử Vận May 9k', 'Acc 50k Siêu Cấp', 'Acc Thần Thoại', 'Acc Random Đặc Biệt')),
                JSON_OBJECT('key', 'Tình trạng', 'value', 'Trắng thông tin'),
                JSON_OBJECT('key', 'Bảo hành', 'value', 'Đổi trả 1-1 nếu lỗi')
            ),
            'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg',
            JSON_ARRAY('https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg'),
            NOW(),
            NOW()
        );
        SET i = i + 1;
    END WHILE;
END$$

DELIMITER ;
