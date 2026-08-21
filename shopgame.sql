-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 20, 2026 lúc 10:19 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shopgame`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `affiliate_histories`
--

CREATE TABLE `affiliate_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `referrer_id` bigint(20) UNSIGNED NOT NULL,
  `referred_id` bigint(20) UNSIGNED NOT NULL,
  `commission_amount` bigint(20) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'deposit',
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `auto_confirm` tinyint(1) NOT NULL DEFAULT 0,
  `prefix` varchar(255) NOT NULL DEFAULT 'naptien',
  `access_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bank_deposits`
--

CREATE TABLE `bank_deposits` (
  `transaction_id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `bank` enum('VPBank','TPBank','VietinBank','ACB','BIDV','MBBank','OCB','KienLongBank','MSB') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `card_deposits`
--

CREATE TABLE `card_deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `telco` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `received_amount` int(11) NOT NULL,
  `serial` varchar(255) NOT NULL,
  `pin` varchar(255) NOT NULL,
  `request_id` bigint(20) NOT NULL,
  `status` enum('success','error','processing') NOT NULL DEFAULT 'processing',
  `response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `configs`
--

CREATE TABLE `configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `configs`
--

INSERT INTO `configs` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'payment.card.active', '1', '2026-08-19 06:23:23', '2026-08-19 06:23:23'),
(2, 'payment.card.partner_id', NULL, '2026-08-19 06:23:23', '2026-08-19 06:23:23'),
(3, 'payment.card.partner_key', NULL, '2026-08-19 06:23:23', '2026-08-19 06:23:23'),
(4, 'payment.card.discount_percent', '0', '2026-08-19 06:23:23', '2026-08-19 06:23:23'),
(5, 'payment.card.partner_website', 'thesieure.com', '2026-08-19 06:23:23', '2026-08-19 06:23:23'),
(6, 'payment.usdt.active', '0', '2026-08-19 06:23:23', '2026-08-19 06:23:23'),
(7, 'spay5s_token', NULL, '2026-08-19 06:23:23', '2026-08-19 06:23:23'),
(8, 'usdt_wallet_address', NULL, '2026-08-19 06:23:23', '2026-08-19 06:23:23'),
(9, 'usdt_rate', NULL, '2026-08-19 06:23:23', '2026-08-19 06:23:23'),
(10, 'payment.bank.active', '0', '2026-08-19 06:23:23', '2026-08-19 06:23:23'),
(11, 'payment.momo.active', '0', '2026-08-19 06:23:23', '2026-08-19 06:23:23'),
(12, 'site_logo', '/storage/config/1787198639_4a4782eb49bb81ed1f57eed1db81d4d6.jpg', '2026-08-20 04:03:59', '2026-08-20 04:03:59'),
(13, 'site_logo_footer', '/storage/config/1787198640_2296d4c22844c5f72ba77b456c90285a.jpg', '2026-08-20 04:04:00', '2026-08-20 04:04:00'),
(14, 'site_favicon', '/storage/config/1787198640_e318a933691db07e5fb57823f51dd569.png', '2026-08-20 04:04:00', '2026-08-20 04:04:00'),
(15, 'site_share_image', '/storage/config/1787198640_2ec5e9accfbbf071d50904c31651a987.jpg', '2026-08-20 04:04:00', '2026-08-20 04:04:00'),
(16, 'site_banner', '[\"\\/storage\\/config\\/1787198640_2296d4c22844c5f72ba77b456c90285a.jpg\",\"\\/storage\\/config\\/1787198668_cfc951504618e0cc8453fbb5f19cc04b.jpg\",\"\\/storage\\/config\\/1787198675_cfc951504618e0cc8453fbb5f19cc04b.jpg\"]', '2026-08-20 04:04:00', '2026-08-20 04:04:35'),
(17, 'site_name', 'ShopGame', '2026-08-20 04:04:00', '2026-08-20 04:04:00'),
(18, 'site_keywords', 'Mua bán tài khoản game Ngọc Rồng', '2026-08-20 04:04:00', '2026-08-20 04:04:00'),
(19, 'site_description', 'Mua bán tài khoản game Ngọc Rồng', '2026-08-20 04:04:00', '2026-08-20 04:04:00'),
(20, 'address', NULL, '2026-08-20 04:04:00', '2026-08-20 04:04:00'),
(21, 'phone', '0123456789', '2026-08-20 04:04:00', '2026-08-20 04:04:00'),
(22, 'email', NULL, '2026-08-20 04:04:00', '2026-08-20 04:04:00'),
(23, 'top_deposit_reward', '<p>Phần thưởng nạp thẻ đang được cập nhật...</p>', '2026-08-20 04:04:00', '2026-08-20 04:04:00'),
(24, 'min_withdraw_gold', '1000', '2026-08-20 04:04:00', '2026-08-20 04:04:00'),
(25, 'max_withdraw_gold', '1000000000', '2026-08-20 04:04:00', '2026-08-20 04:04:00'),
(26, 'site_view_all_image', '/storage/config/1787199888_0c5afd4c6925f761e273af06c9e8a0d5.gif', '2026-08-20 04:24:48', '2026-08-20 04:24:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount_codes`
--

CREATE TABLE `discount_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `discount_type` enum('percentage','fixed_amount') NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_discount_value` decimal(10,2) DEFAULT NULL,
  `min_purchase_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `is_active` enum('1','0') NOT NULL DEFAULT '1',
  `usage_limit` int(11) DEFAULT NULL,
  `usage_count` int(11) NOT NULL DEFAULT 0,
  `per_user_limit` int(11) DEFAULT NULL,
  `applicable_to` enum('account','random_account','service') DEFAULT NULL,
  `item_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`item_ids`)),
  `expire_date` timestamp NULL DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `discount_codes`
--

INSERT INTO `discount_codes` (`id`, `code`, `discount_type`, `discount_value`, `max_discount_value`, `min_purchase_amount`, `is_active`, `usage_limit`, `usage_count`, `per_user_limit`, `applicable_to`, `item_ids`, `expire_date`, `description`, `created_at`, `updated_at`) VALUES
(1, 'VMDQJ7UM', 'percentage', 5.00, 0.00, 0.00, '1', NULL, 0, NULL, 'random_account', NULL, '2026-06-21 17:00:00', '343', '2026-06-21 14:08:47', '2026-06-21 14:08:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount_code_usages`
--

CREATE TABLE `discount_code_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `discount_code_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `context` enum('account','random_account','service') NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `original_price` decimal(10,2) NOT NULL,
  `discounted_price` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `used_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `flash_sales`
--

CREATE TABLE `flash_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campaign_name` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `flash_sales`
--

INSERT INTO `flash_sales` (`id`, `campaign_name`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Sale Cuối Tuần', '2026-07-28 18:58:00', '2026-08-07 20:58:00', 1, '2026-07-28 11:59:09', '2026-07-28 11:59:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `flash_sale_items`
--

CREATE TABLE `flash_sale_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flash_sale_id` bigint(20) UNSIGNED NOT NULL,
  `item_type` varchar(255) NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `old_price` int(11) NOT NULL,
  `new_price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `flash_sale_items`
--

INSERT INTO `flash_sale_items` (`id`, `flash_sale_id`, `item_type`, `item_id`, `old_price`, `new_price`, `created_at`, `updated_at`) VALUES
(2, 2, 'game', 2, 100000, 50000, '2026-07-28 11:59:09', '2026-07-28 11:59:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `game_accounts`
--

CREATE TABLE `game_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_category_id` bigint(20) UNSIGNED NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `price` bigint(20) UNSIGNED NOT NULL,
  `status` enum('available','sold','installment') NOT NULL DEFAULT 'available',
  `buyer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `note` text DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Dynamic attributes for different game types' CHECK (json_valid(`details`)),
  `thumb` text NOT NULL,
  `images` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `game_accounts`
--

INSERT INTO `game_accounts` (`id`, `game_category_id`, `account_name`, `password`, `price`, `status`, `buyer_id`, `note`, `details`, `thumb`, `images`, `created_at`, `updated_at`) VALUES
(4, 5, 'lq_vip01', 'pass123456', 250000, 'available', NULL, 'Tài khoản mẫu cấu hình chuẩn Liên Quân Mobile', '[{\"key\":\"Rank\",\"value\":\"Chi\\u1ebfn T\\u01b0\\u1edbng\"},{\"key\":\"T\\u01b0\\u1edbng\",\"value\":\"115\"},{\"key\":\"Trang Ph\\u1ee5c\",\"value\":\"320\"},{\"key\":\"B\\u1eadc Ng\\u1ecdc\",\"value\":\"Ng\\u1ecdc 90 (Full)\"},{\"key\":\"\\u0110\\u0103ng k\\u00fd\",\"value\":\"Tr\\u1eafng th\\u00f4ng tin\"}]', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', '\"[\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\"]\"', '2026-08-20 03:46:52', '2026-08-20 03:46:52'),
(5, 5, 'lq_starter02', 'pass123456', 80000, 'available', NULL, 'Tài khoản mẫu cấu hình chuẩn Liên Quân Mobile', '[{\"key\":\"Rank\",\"value\":\"Tinh Anh\"},{\"key\":\"T\\u01b0\\u1edbng\",\"value\":\"65\"},{\"key\":\"Trang Ph\\u1ee5c\",\"value\":\"80\"},{\"key\":\"B\\u1eadc Ng\\u1ecdc\",\"value\":\"Ng\\u1ecdc 90 (Full)\"},{\"key\":\"\\u0110\\u0103ng k\\u00fd\",\"value\":\"Tr\\u1eafng th\\u00f4ng tin\"}]', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', '\"[\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\"]\"', '2026-08-20 03:46:52', '2026-08-20 03:46:52'),
(6, 5, 'lq_budget03', 'pass123456', 45000, 'available', NULL, 'Tài khoản mẫu cấu hình chuẩn Liên Quân Mobile', '[{\"key\":\"Rank\",\"value\":\"Kim C\\u01b0\\u01a1ng\"},{\"key\":\"T\\u01b0\\u1edbng\",\"value\":\"40\"},{\"key\":\"Trang Ph\\u1ee5c\",\"value\":\"35\"},{\"key\":\"B\\u1eadc Ng\\u1ecdc\",\"value\":\"Ch\\u01b0a full 90\"},{\"key\":\"\\u0110\\u0103ng k\\u00fd\",\"value\":\"Garena s\\u1ea1ch\"}]', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', '\"[\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\"]\"', '2026-08-20 03:46:52', '2026-08-20 03:46:52'),
(7, 6, 'ff_vip01', 'pass123456', 550000, 'available', NULL, 'Tài khoản mẫu cấu hình chuẩn Free Fire', '[{\"key\":\"Rank\",\"value\":\"Huy\\u1ec1n Tho\\u1ea1i\"},{\"key\":\"Skin S\\u00fang VIP\",\"value\":\"AK R\\u1ed3ng Xanh\"},{\"key\":\"\\u0110\\u0103ng k\\u00fd\",\"value\":\"Tr\\u1eafng th\\u00f4ng tin\"},{\"key\":\"Pet\",\"value\":\"Full Pet\"},{\"key\":\"Th\\u1ebb V\\u00f4 C\\u1ef1c\",\"value\":\"Nhi\\u1ec1u m\\u00f9a c\\u0169 (M\\u00f9a 1-5)\"}]', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', '\"[\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\"]\"', '2026-08-20 03:46:52', '2026-08-20 03:46:52'),
(8, 6, 'ff_mid02', 'pass123456', 180000, 'available', NULL, 'Tài khoản mẫu cấu hình chuẩn Free Fire', '[{\"key\":\"Rank\",\"value\":\"Kim C\\u01b0\\u01a1ng\"},{\"key\":\"Skin S\\u00fang VIP\",\"value\":\"MP40 M\\u00e3ng X\\u00e0\"},{\"key\":\"\\u0110\\u0103ng k\\u00fd\",\"value\":\"Facebook s\\u1ea1ch\"},{\"key\":\"Pet\",\"value\":\"C\\u00f3 Pet tr\\u1ee3 th\\u1ee7\"},{\"key\":\"Th\\u1ebb V\\u00f4 C\\u1ef1c\",\"value\":\"M\\u1ed9t v\\u00e0i m\\u00f9a\"}]', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', '\"[\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\"]\"', '2026-08-20 03:46:52', '2026-08-20 03:46:52'),
(9, 7, 'bf_godhuman01', 'pass123456', 350000, 'available', NULL, 'Tài khoản mẫu cấu hình chuẩn Blox Fruits & Roblox', '[{\"key\":\"Level\",\"value\":\"Max (2550)\"},{\"key\":\"Tr\\u00e1i \\u00c1c Qu\\u1ef7\",\"value\":\"Kitsune\"},{\"key\":\"Melee V2\",\"value\":\"Godhuman (Full Melee)\"},{\"key\":\"Ki\\u1ebfm Mythical\",\"value\":\"Cursed Dual Katana (CDK)\"},{\"key\":\"T\\u1ed9c V4\",\"value\":\"Human V4 (Full Gear)\"},{\"key\":\"Beli & Fragments\",\"value\":\"50M+ Beli \\/ 50k Frag\"}]', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', '\"[\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\"]\"', '2026-08-20 03:46:52', '2026-08-20 03:46:52'),
(10, 7, 'bf_buddha02', 'pass123456', 120000, 'available', NULL, 'Tài khoản mẫu cấu hình chuẩn Blox Fruits & Roblox', '[{\"key\":\"Level\",\"value\":\"Max (2550)\"},{\"key\":\"Tr\\u00e1i \\u00c1c Qu\\u1ef7\",\"value\":\"Buddha (Ph\\u1eadt V2)\"},{\"key\":\"Melee V2\",\"value\":\"Superhuman\"},{\"key\":\"Ki\\u1ebfm Mythical\",\"value\":\"Dark Blade (Yoru)\"},{\"key\":\"T\\u1ed9c V4\",\"value\":\"Fishman V4 (Full Gear)\"},{\"key\":\"Beli & Fragments\",\"value\":\"10M+ Beli \\/ 20k Frag\"}]', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', '\"[\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\"]\"', '2026-08-20 03:46:52', '2026-08-20 03:46:52'),
(11, 8, 'rbx_clean01', 'pass123456', 200000, 'available', NULL, 'Tài khoản mẫu cấu hình chuẩn Blox Fruits & Roblox', '[{\"key\":\"S\\u1ed1 d\\u01b0 Robux\",\"value\":\"2,000 - 5,000 Robux\"},{\"key\":\"N\\u0103m t\\u1ea1o Acc\",\"value\":\"2016 - 2018\"},{\"key\":\"Gamepass\",\"value\":\"Blox Fruits VIP\\/2x\"},{\"key\":\"T\\u00ecnh tr\\u1ea1ng Pin \\/ Mail\",\"value\":\"Tr\\u1eafng Email \\/ Ch\\u01b0a c\\u00e0i PIN\"}]', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', '\"[\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\"]\"', '2026-08-20 03:46:52', '2026-08-20 03:46:52'),
(12, 9, 'fcm_ovr106', 'pass123456', 600000, 'available', NULL, 'Tài khoản mẫu cấu hình chuẩn FC Mobile', '[{\"key\":\"OVR \\u0110\\u1ed9i H\\u00ecnh\",\"value\":\"106+ (Si\\u00eau VIP)\"},{\"key\":\"Gi\\u00e1 tr\\u1ecb \\u0111\\u1ed9i h\\u00ecnh\",\"value\":\"3B - 5B Coins\"},{\"key\":\"C\\u1ea7u th\\u1ee7 n\\u1ed5i b\\u1eadt\",\"value\":\"Ronaldo Nazario (R9)\"},{\"key\":\"\\u0110\\u0103ng nh\\u1eadp\",\"value\":\"EA Account (Tr\\u1eafng mail)\"}]', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', '\"[\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\"]\"', '2026-08-20 03:46:52', '2026-08-20 03:46:52'),
(13, 9, 'fcm_starter', 'pass123456', 90000, 'available', NULL, 'Tài khoản mẫu cấu hình chuẩn FC Mobile', '[{\"key\":\"OVR \\u0110\\u1ed9i H\\u00ecnh\",\"value\":\"96 - 100\"},{\"key\":\"Gi\\u00e1 tr\\u1ecb \\u0111\\u1ed9i h\\u00ecnh\",\"value\":\"500M - 1B Coins\"},{\"key\":\"C\\u1ea7u th\\u1ee7 n\\u1ed5i b\\u1eadt\",\"value\":\"Messi\"},{\"key\":\"\\u0110\\u0103ng nh\\u1eadp\",\"value\":\"EA Account (Tr\\u1eafng mail)\"}]', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', '\"[\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\"]\"', '2026-08-20 03:46:52', '2026-08-20 03:46:52'),
(14, 10, 'wr_challenger', 'pass123456', 450000, 'available', NULL, 'Tài khoản mẫu cấu hình chuẩn LMHT Tốc Chiến', '[{\"key\":\"Rank\",\"value\":\"Cao Th\\u1ee7\"},{\"key\":\"S\\u1ed1 T\\u01b0\\u1edbng\",\"value\":\"80+\"},{\"key\":\"S\\u1ed1 Skin\",\"value\":\"150+\"},{\"key\":\"Skin T\\u1ed1i Th\\u01b0\\u1ee3ng \\/ Th\\u1ea7n Tho\\u1ea1i\",\"value\":\"C\\u00f3 nhi\\u1ec1u Skin Th\\u1ea7n Tho\\u1ea1i\"},{\"key\":\"\\u0110\\u0103ng nh\\u1eadp\",\"value\":\"Riot Games (Tr\\u1eafng mail)\"}]', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', '\"[\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\"]\"', '2026-08-20 03:46:52', '2026-08-20 03:46:52'),
(15, 11, 'pubg_ice_max', 'pass123456', 1200000, 'available', NULL, 'Tài khoản mẫu cấu hình chuẩn PUBG Mobile', '[{\"key\":\"Rank\",\"value\":\"Qu\\u00e1n Qu\\u00e2n (Ace)\"},{\"key\":\"Skin N\\u00e2ng C\\u1ea5p (S\\u00fang Lab)\",\"value\":\"M416 B\\u0103ng (Glacier) Max\"},{\"key\":\"B\\u1ed9 Trang Ph\\u1ee5c VIP\",\"value\":\"X-Suit Pharaoh 6-7 sao\"},{\"key\":\"Li\\u00ean k\\u1ebft\",\"value\":\"Tr\\u1eafng th\\u00f4ng tin (Mail\\/S\\u0110T)\"}]', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', '\"[\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\"]\"', '2026-08-20 03:46:52', '2026-08-20 03:46:52'),
(16, 12, 'nro_server1_vip', 'pass123456', 300000, 'available', NULL, 'Tài khoản mẫu cấu hình chuẩn Ngọc Rồng Online', '[{\"key\":\"M\\u00e1y Ch\\u1ee7 (Server)\",\"value\":\"V\\u0169 Tr\\u1ee5 1\"},{\"key\":\"H\\u00e0nh Tinh\",\"value\":\"Tr\\u00e1i \\u0110\\u1ea5t\"},{\"key\":\"S\\u1ee9c M\\u1ea1nh\",\"value\":\"40 t\\u1ef7 - 80 t\\u1ef7\"},{\"key\":\"\\u0110\\u1ec7 T\\u1eed\",\"value\":\"\\u0110\\u1ec7 Skill 2 Kamejoko \\/ Masenko\"},{\"key\":\"B\\u00f4ng Tai Porata\",\"value\":\"Porata C\\u1ea5p 2\"},{\"key\":\"\\u0110\\u0103ng k\\u00fd\",\"value\":\"Nick \\u1ea3o (Tr\\u1eafng th\\u00f4ng tin)\"}]', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', '\"[\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\"]\"', '2026-08-20 03:46:52', '2026-08-20 03:46:52'),
(17, 12, 'nro_sosinh02', 'pass123456', 30000, 'available', NULL, 'Tài khoản mẫu cấu hình chuẩn Ngọc Rồng Online', '[{\"key\":\"M\\u00e1y Ch\\u1ee7 (Server)\",\"value\":\"V\\u0169 Tr\\u1ee5 2\"},{\"key\":\"H\\u00e0nh Tinh\",\"value\":\"Xayda\"},{\"key\":\"S\\u1ee9c M\\u1ea1nh\",\"value\":\"S\\u01a1 sinh (D\\u01b0\\u1edbi 1.5tr)\"},{\"key\":\"\\u0110\\u1ec7 T\\u1eed\",\"value\":\"Ch\\u01b0a c\\u00f3 \\u0111\\u1ec7\"},{\"key\":\"B\\u00f4ng Tai Porata\",\"value\":\"Ch\\u01b0a c\\u00f3\"},{\"key\":\"\\u0110\\u0103ng k\\u00fd\",\"value\":\"Nick \\u1ea3o (Tr\\u1eafng th\\u00f4ng tin)\"}]', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', '\"[\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\",\\\"https:\\\\\\/\\\\\\/i.postimg.cc\\\\\\/8kJvtYgW\\\\\\/20250328090315screenshot-2025-03-26-091731.jpg\\\"]\"', '2026-08-20 03:46:52', '2026-08-20 03:46:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `game_categories`
--

CREATE TABLE `game_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `tag_image` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `game_group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_flash_sale` tinyint(1) NOT NULL DEFAULT 0,
  `flash_sale_old_price` int(11) DEFAULT NULL,
  `flash_sale_new_price` int(11) DEFAULT NULL,
  `flash_sale_end_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `game_categories`
--

INSERT INTO `game_categories` (`id`, `name`, `slug`, `platform`, `thumbnail`, `tag_image`, `description`, `active`, `created_at`, `updated_at`, `game_group_id`, `is_flash_sale`, `flash_sale_old_price`, `flash_sale_new_price`, `flash_sale_end_time`) VALUES
(2, 'Acc Liên Quân 100k', 'acc-lien-quan-100k', 'Liên Quân', '/storage/categories/1782031765_493bcdbbcc5d7927a2dc29b80f8cee49.jpg', '/storage/categories/1782031765_4f628121d15a22b14bf2fcf3366ab6f5.png', 'et5r56', 1, '2026-06-21 08:49:25', '2026-06-21 08:49:25', 1, 0, NULL, NULL, NULL),
(4, 'Acc Free Fire VIP', 'acc-free-fire-vip', 'Free Fire', '/storage/categories/1787197976_9468edeb422624119368c8b9ba6a2930.jpg', '/storage/categories/1782146078_4f628121d15a22b14bf2fcf3366ab6f5.png', '42345235', 1, '2026-06-22 16:34:38', '2026-08-20 03:52:56', 2, 0, 50000, NULL, NULL),
(5, 'Nick Liên Quân Full Tướng & Skin VIP', 'nick-lien-quan-full-tuong-skin-vip', 'lien-quan', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', NULL, 'Tài khoản Liên Quân Mobile rank cao, nhiều tướng và trang phục giới hạn.', 1, '2026-08-20 03:46:52', '2026-08-20 03:46:52', 4, 0, NULL, NULL, NULL),
(6, 'Nick Free Fire Skin Súng Nâng Cấp VIP', 'nick-free-fire-skin-sung-nang-cap-vip', 'free-fire', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', NULL, 'Tài khoản Free Fire sở hữu nhiều skin súng huyền thoại Lv7 và rank cao.', 1, '2026-08-20 03:46:52', '2026-08-20 03:46:52', 2, 0, NULL, NULL, NULL),
(7, 'Nick Blox Fruits Max Level & Trái Mythical', 'nick-blox-fruits-max-level-trai-mythical', 'blox-fruits', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', NULL, 'Tài khoản Blox Fruits Max Level 2550, Kitsune, Melee Godhuman, CDK.', 1, '2026-08-20 03:46:52', '2026-08-20 03:46:52', 5, 0, NULL, NULL, NULL),
(8, 'Nick Roblox Chung (Acc Cổ & Robux Clean)', 'nick-roblox-chung-acc-co-robux-clean', 'roblox', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', NULL, 'Tài khoản Roblox cổ, có sẵn Robux sạch và Gamepass.', 1, '2026-08-20 03:46:52', '2026-08-20 03:46:52', 5, 0, NULL, NULL, NULL),
(9, 'Nick FC Mobile OVR Khủng & Icon VIP', 'nick-fc-mobile-ovr-khung-icon-vip', 'fc-mobile', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', NULL, 'Tài khoản FC Mobile đội hình OVR 100+ nhiều cầu thủ Icon huyền thoại.', 1, '2026-08-20 03:46:52', '2026-08-20 03:46:52', 6, 0, NULL, NULL, NULL),
(10, 'Nick Tốc Chiến Rank Cao Thủ Full Skin', 'nick-toc-chien-rank-cao-thu-full-skin', 'toc-chien', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', NULL, 'Tài khoản LMHT: Wild Rift rank cao, nhiều skin Thần Thoại.', 1, '2026-08-20 03:46:52', '2026-08-20 03:46:52', 7, 0, NULL, NULL, NULL),
(11, 'Nick PUBG Mobile M416 Băng & X-Suit', 'nick-pubg-mobile-m416-bang-x-suit', 'pubg-mobile', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', NULL, 'Tài khoản PUBG Mobile súng nâng cấp Glacier và X-Suit cực VIP.', 1, '2026-08-20 03:46:52', '2026-08-20 03:46:52', 8, 0, NULL, NULL, NULL),
(12, 'Nick NRO Sức Mạnh Khủng & Có Đệ Tử VIP', 'nick-nro-suc-manh-khung-co-de-tu-vip', 'ngoc-rong-online', '/storage/categories/1787197955_df93f79a1e7fef6c8bfa89d9658eb8cb.jpg', NULL, 'Tài khoản Chú Bé Rồng Online các vũ trụ, đệ tử kame, bông tai Porata.', 1, '2026-08-20 03:46:52', '2026-08-20 03:52:35', 9, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `game_groups`
--

CREATE TABLE `game_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `game_groups`
--

INSERT INTO `game_groups` (`id`, `name`, `slug`, `thumbnail`, `order`, `active`, `created_at`, `updated_at`, `link`) VALUES
(1, 'Liên Quân', 'lien-quan', '/storage/game-groups/1787202128_0c5afd4c6925f761e273af06c9e8a0d5.gif', 0, 1, '2026-06-21 08:38:06', '2026-08-20 05:02:08', NULL),
(2, 'Free Fire', 'free-fire', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', 2, 1, '2026-06-21 08:43:39', '2026-08-20 03:46:52', NULL),
(4, 'Liên Quân Mobile', 'lien-quan-mobile', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', 1, 1, '2026-08-20 03:46:52', '2026-08-20 03:46:52', NULL),
(5, 'Blox Fruits & Roblox', 'blox-fruits-roblox', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', 3, 1, '2026-08-20 03:46:52', '2026-08-20 03:46:52', NULL),
(6, 'FC Mobile', 'fc-mobile', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', 4, 1, '2026-08-20 03:46:52', '2026-08-20 03:46:52', NULL),
(7, 'LMHT Tốc Chiến', 'lmht-toc-chien', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', 5, 1, '2026-08-20 03:46:52', '2026-08-20 03:46:52', NULL),
(8, 'PUBG Mobile', 'pubg-mobile', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', 6, 1, '2026-08-20 03:46:52', '2026-08-20 03:46:52', NULL),
(9, 'Ngọc Rồng Online', 'ngoc-rong-online', 'https://i.postimg.cc/8kJvtYgW/20250328090315screenshot-2025-03-26-091731.jpg', 7, 1, '2026-08-20 03:46:52', '2026-08-20 03:46:52', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `game_services`
--

CREATE TABLE `game_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('gold','gem','leveling') NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `installments`
--

CREATE TABLE `installments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `game_account_id` bigint(20) UNSIGNED NOT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `paid_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `duration_days` int(11) NOT NULL,
  `expire_date` datetime NOT NULL,
  `status` enum('active','completed','cancelled','expired') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `iso_code` varchar(10) NOT NULL,
  `flag_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `languages`
--

INSERT INTO `languages` (`id`, `name`, `iso_code`, `flag_path`, `is_active`, `is_default`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Vietnamese', 'vi', NULL, 1, 1, 0, '2026-06-22 08:47:52', '2026-06-22 08:48:39'),
(3, 'English', 'en', NULL, 1, 0, 2, '2026-06-22 08:48:19', '2026-06-22 08:48:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lucky_wheels`
--

CREATE TABLE `lucky_wheels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `wheel_image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `rules` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `price_per_spin` bigint(20) NOT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`config`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lucky_wheels`
--

INSERT INTO `lucky_wheels` (`id`, `name`, `slug`, `thumbnail`, `wheel_image`, `description`, `rules`, `active`, `price_per_spin`, `config`, `created_at`, `updated_at`) VALUES
(2, 'Vòng Quay XM8 Thần Sấm', 'vong-quay-xm8-than-sam', '/storage/lucky-wheels/thumbnails/1782100555_d40e2da1aea33c76fc9af4a35c4259df.webp', '/storage/lucky-wheels/wheel-images/1782100555_bbaf5a09c7fb7b6f252840933aa03a85.png', '<p>545643</p>', '<p>656756</p>', 1, 10000, '[{\"content\":\"19999 Kim C\\u01b0\\u01a1ng\",\"probability\":\"0.5\",\"trial_probability\":\"1.5\",\"reward_type\":\"item\",\"reward_item_id\":null,\"amount\":\"19999\"},{\"content\":\"999 Kim C\\u01b0\\u01a1ng\",\"probability\":\"15\",\"trial_probability\":\"20\",\"reward_type\":\"item\",\"reward_item_id\":null,\"amount\":\"999\"},{\"content\":\"15555 Kim C\\u01b0\\u01a1ng\",\"probability\":\"0.5\",\"trial_probability\":\"1.5\",\"reward_type\":\"item\",\"reward_item_id\":null,\"amount\":\"15555\"},{\"content\":\"19 Kim C\\u01b0\\u01a1ng\",\"probability\":\"29\",\"trial_probability\":\"20\",\"reward_type\":\"item\",\"reward_item_id\":null,\"amount\":\"19\"},{\"content\":\"9999 Kim C\\u01b0\\u01a1ng\",\"probability\":\"1\",\"trial_probability\":\"5\",\"reward_type\":\"item\",\"reward_item_id\":null,\"amount\":\"9999\"},{\"content\":\"M\\u1ea5t l\\u01b0\\u1ee3t\",\"probability\":\"30\",\"trial_probability\":\"10\",\"reward_type\":\"empty\",\"reward_item_id\":null,\"amount\":null},{\"content\":\"20000 VN\\u0110\",\"probability\":\"4\",\"trial_probability\":\"20\",\"reward_type\":\"money\",\"reward_item_id\":null,\"amount\":\"20000\"},{\"content\":\"Nick VIP\",\"probability\":\"20\",\"trial_probability\":\"22\",\"reward_type\":\"random_account\",\"reward_item_id\":null,\"amount\":\"1\"}]', '2026-06-22 03:55:55', '2026-06-22 03:55:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lucky_wheel_histories`
--

CREATE TABLE `lucky_wheel_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lucky_wheel_id` bigint(20) UNSIGNED NOT NULL,
  `spin_count` int(11) NOT NULL,
  `total_cost` bigint(20) NOT NULL,
  `reward_type` varchar(50) NOT NULL,
  `reward_amount` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2025_03_28_181908_create_users_table', 1),
(3, '2025_03_28_181914_create_game_categories_table', 1),
(4, '2025_03_28_181917_create_game_accounts_table', 1),
(5, '2025_03_28_181929_create_purchase_history_table', 1),
(6, '2025_03_28_181932_create_money_transactions_table', 1),
(7, '2025_03_29_015110_create_card_deposits_table', 1),
(8, '2025_03_29_154334_create_game_services_table', 1),
(9, '2025_03_29_154343_create_service_packages_table', 1),
(10, '2025_03_29_154350_create_service_histories_table', 1),
(11, '2025_03_30_231218_create_configs_table', 1),
(12, '2025_03_31_050014_create_bank_deposits_table', 1),
(13, '2025_03_31_065843_create_bank_accounts_table', 1),
(14, '2025_04_01_031303_create_random_categories_table', 1),
(15, '2025_04_01_031307_create_random_category_accounts_table', 1),
(16, '2025_04_01_035918_create_discount_codes_table', 1),
(17, '2025_04_01_040223_create_discount_code_usages_table', 1),
(18, '2025_04_02_060346_create_lucky_wheels_table', 1),
(19, '2025_04_02_060438_create_lucky_wheel_histories_table', 1),
(20, '2025_04_02_060504_create_withdrawal_histories_table', 1),
(21, '2025_04_04_043941_create_money_withdrawal_histories_table', 1),
(22, '2025_04_05_101214_create_notifications_table', 1),
(23, '2025_04_07_022109_create_password_reset_tokens_table', 1),
(24, '2026_06_20_215722_create_attributes_table', 2),
(25, '2026_06_20_215743_add_details_to_game_accounts_table', 2),
(26, '2026_06_20_220229_drop_nro_fields_from_game_accounts_table', 3),
(27, '2026_06_20_230436_add_batch_id_to_random_category_accounts', 4),
(28, '2026_06_20_233640_add_tag_image_to_categories_table', 5),
(29, '2026_06_20_234303_create_game_groups_table', 6),
(30, '2026_06_20_234304_add_game_group_id_to_categories_tables', 6),
(31, '2026_06_21_000001_add_platform_to_game_and_random_categories_table', 7),
(32, '2026_06_21_153728_add_link_to_game_groups_table', 8),
(33, '2026_06_21_160823_add_image_to_bank_accounts_table', 9),
(34, '2026_06_21_164415_add_flash_sale_to_random_categories_table', 10),
(35, '2026_06_21_164704_add_flash_sale_end_time_to_random_categories_table', 11),
(36, '2026_06_21_164946_add_flash_sale_to_game_categories_table', 12),
(37, '2026_06_21_174022_create_news_table', 13),
(38, '2026_06_21_184109_add_game_to_withdrawal_histories_table', 14),
(39, '2026_06_21_203803_create_flash_sales_table', 15),
(40, '2026_06_21_203809_create_flash_sale_items_table', 15),
(41, '2026_06_21_212340_create_installments_table', 16),
(42, '2026_06_21_212435_alter_status_on_game_accounts_table', 17),
(43, '2026_06_22_103014_create_reward_items_table', 18),
(44, '2026_06_22_111804_create_affiliate_system_tables', 19),
(45, '2025_11_16_043251_create_languages_table', 20),
(46, '2026_06_22_234903_add_price_to_random_categories_table', 21),
(47, '2026_07_07_210204_create_usdt_deposits_table', 22),
(48, '2026_07_07_210955_create_usdt_accounts_table', 23),
(49, '2026_07_07_213617_add_qr_image_to_usdt_accounts_table', 24);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `money_transactions`
--

CREATE TABLE `money_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('deposit','withdraw','purchase','refund') NOT NULL,
  `amount` bigint(20) NOT NULL,
  `balance_before` bigint(20) NOT NULL,
  `balance_after` bigint(20) NOT NULL,
  `description` text DEFAULT NULL,
  `reference_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `money_transactions`
--

INSERT INTO `money_transactions` (`id`, `user_id`, `type`, `amount`, `balance_before`, `balance_after`, `description`, `reference_id`, `created_at`, `updated_at`) VALUES
(43, 6, 'deposit', 99999999, 0, 99999999, 'Admin cập nhật số dư', NULL, '2026-08-20 05:56:27', '2026-08-20 05:56:27'),
(44, 6, 'purchase', -20000, 99999999, 99979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3490', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(45, 6, 'purchase', -20000, 99979999, 99959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3491', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(46, 6, 'purchase', -20000, 99959999, 99939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3492', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(47, 6, 'purchase', -20000, 99939999, 99919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3493', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(48, 6, 'purchase', -20000, 99919999, 99899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3494', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(49, 6, 'purchase', -20000, 99899999, 99879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3495', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(50, 6, 'purchase', -20000, 99879999, 99859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3496', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(51, 6, 'purchase', -20000, 99859999, 99839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3497', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(52, 6, 'purchase', -20000, 99839999, 99819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3498', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(53, 6, 'purchase', -20000, 99819999, 99799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3499', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(54, 6, 'purchase', -20000, 99799999, 99779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3500', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(55, 6, 'purchase', -20000, 99779999, 99759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3501', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(56, 6, 'purchase', -20000, 99759999, 99739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3502', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(57, 6, 'purchase', -20000, 99739999, 99719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3503', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(58, 6, 'purchase', -20000, 99719999, 99699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3504', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(59, 6, 'purchase', -20000, 99699999, 99679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3505', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(60, 6, 'purchase', -20000, 99679999, 99659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3506', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(61, 6, 'purchase', -20000, 99659999, 99639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3507', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(62, 6, 'purchase', -20000, 99639999, 99619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3508', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(63, 6, 'purchase', -20000, 99619999, 99599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3509', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(64, 6, 'purchase', -20000, 99599999, 99579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3510', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(65, 6, 'purchase', -20000, 99579999, 99559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3511', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(66, 6, 'purchase', -20000, 99559999, 99539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3512', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(67, 6, 'purchase', -20000, 99539999, 99519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3513', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(68, 6, 'purchase', -20000, 99519999, 99499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3514', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(69, 6, 'purchase', -20000, 99499999, 99479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3515', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(70, 6, 'purchase', -20000, 99479999, 99459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3516', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(71, 6, 'purchase', -20000, 99459999, 99439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3517', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(72, 6, 'purchase', -20000, 99439999, 99419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3518', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(73, 6, 'purchase', -20000, 99419999, 99399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3519', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(74, 6, 'purchase', -20000, 99399999, 99379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3520', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(75, 6, 'purchase', -20000, 99379999, 99359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3521', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(76, 6, 'purchase', -20000, 99359999, 99339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3522', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(77, 6, 'purchase', -20000, 99339999, 99319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3523', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(78, 6, 'purchase', -20000, 99319999, 99299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3524', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(79, 6, 'purchase', -20000, 99299999, 99279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3525', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(80, 6, 'purchase', -20000, 99279999, 99259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3526', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(81, 6, 'purchase', -20000, 99259999, 99239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3527', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(82, 6, 'purchase', -20000, 99239999, 99219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3528', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(83, 6, 'purchase', -20000, 99219999, 99199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3529', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(84, 6, 'purchase', -20000, 99199999, 99179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3530', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(85, 6, 'purchase', -20000, 99179999, 99159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3531', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(86, 6, 'purchase', -20000, 99159999, 99139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3532', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(87, 6, 'purchase', -20000, 99139999, 99119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3533', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(88, 6, 'purchase', -20000, 99119999, 99099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3534', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(89, 6, 'purchase', -20000, 99099999, 99079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3535', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(90, 6, 'purchase', -20000, 99079999, 99059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3536', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(91, 6, 'purchase', -20000, 99059999, 99039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3537', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(92, 6, 'purchase', -20000, 99039999, 99019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3538', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(93, 6, 'purchase', -20000, 99019999, 98999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3539', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(94, 6, 'purchase', -20000, 98999999, 98979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3540', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(95, 6, 'purchase', -20000, 98979999, 98959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3541', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(96, 6, 'purchase', -20000, 98959999, 98939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3542', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(97, 6, 'purchase', -20000, 98939999, 98919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3543', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(98, 6, 'purchase', -20000, 98919999, 98899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3544', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(99, 6, 'purchase', -20000, 98899999, 98879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3545', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(100, 6, 'purchase', -20000, 98879999, 98859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3546', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(101, 6, 'purchase', -20000, 98859999, 98839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3547', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(102, 6, 'purchase', -20000, 98839999, 98819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3548', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(103, 6, 'purchase', -20000, 98819999, 98799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3549', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(104, 6, 'purchase', -20000, 98799999, 98779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3550', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(105, 6, 'purchase', -20000, 98779999, 98759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3551', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(106, 6, 'purchase', -20000, 98759999, 98739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3552', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(107, 6, 'purchase', -20000, 98739999, 98719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3553', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(108, 6, 'purchase', -20000, 98719999, 98699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3554', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(109, 6, 'purchase', -20000, 98699999, 98679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3555', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(110, 6, 'purchase', -20000, 98679999, 98659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3556', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(111, 6, 'purchase', -20000, 98659999, 98639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3557', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(112, 6, 'purchase', -20000, 98639999, 98619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3558', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(113, 6, 'purchase', -20000, 98619999, 98599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3559', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(114, 6, 'purchase', -20000, 98599999, 98579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3560', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(115, 6, 'purchase', -20000, 98579999, 98559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3561', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(116, 6, 'purchase', -20000, 98559999, 98539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3562', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(117, 6, 'purchase', -20000, 98539999, 98519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3563', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(118, 6, 'purchase', -20000, 98519999, 98499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3564', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(119, 6, 'purchase', -20000, 98499999, 98479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3565', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(120, 6, 'purchase', -20000, 98479999, 98459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3566', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(121, 6, 'purchase', -20000, 98459999, 98439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3567', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(122, 6, 'purchase', -20000, 98439999, 98419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3568', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(123, 6, 'purchase', -20000, 98419999, 98399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3569', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(124, 6, 'purchase', -20000, 98399999, 98379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3570', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(125, 6, 'purchase', -20000, 98379999, 98359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3571', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(126, 6, 'purchase', -20000, 98359999, 98339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3572', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(127, 6, 'purchase', -20000, 98339999, 98319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3573', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(128, 6, 'purchase', -20000, 98319999, 98299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3574', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(129, 6, 'purchase', -20000, 98299999, 98279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3575', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(130, 6, 'purchase', -20000, 98279999, 98259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3576', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(131, 6, 'purchase', -20000, 98259999, 98239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3577', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(132, 6, 'purchase', -20000, 98239999, 98219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3578', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(133, 6, 'purchase', -20000, 98219999, 98199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3579', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(134, 6, 'purchase', -20000, 98199999, 98179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3580', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(135, 6, 'purchase', -20000, 98179999, 98159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3581', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(136, 6, 'purchase', -20000, 98159999, 98139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3582', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(137, 6, 'purchase', -20000, 98139999, 98119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3583', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(138, 6, 'purchase', -20000, 98119999, 98099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3584', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(139, 6, 'purchase', -20000, 98099999, 98079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3585', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(140, 6, 'purchase', -20000, 98079999, 98059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3586', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(141, 6, 'purchase', -20000, 98059999, 98039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3587', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(142, 6, 'purchase', -20000, 98039999, 98019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3588', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(143, 6, 'purchase', -20000, 98019999, 97999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3589', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(144, 6, 'purchase', -20000, 97999999, 97979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3590', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(145, 6, 'purchase', -20000, 97979999, 97959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3591', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(146, 6, 'purchase', -20000, 97959999, 97939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3592', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(147, 6, 'purchase', -20000, 97939999, 97919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3593', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(148, 6, 'purchase', -20000, 97919999, 97899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3594', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(149, 6, 'purchase', -20000, 97899999, 97879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3595', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(150, 6, 'purchase', -20000, 97879999, 97859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3596', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(151, 6, 'purchase', -20000, 97859999, 97839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3597', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(152, 6, 'purchase', -20000, 97839999, 97819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3598', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(153, 6, 'purchase', -20000, 97819999, 97799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3599', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(154, 6, 'purchase', -20000, 97799999, 97779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3600', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(155, 6, 'purchase', -20000, 97779999, 97759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3601', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(156, 6, 'purchase', -20000, 97759999, 97739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3602', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(157, 6, 'purchase', -20000, 97739999, 97719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3603', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(158, 6, 'purchase', -20000, 97719999, 97699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3604', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(159, 6, 'purchase', -20000, 97699999, 97679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3605', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(160, 6, 'purchase', -20000, 97679999, 97659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3606', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(161, 6, 'purchase', -20000, 97659999, 97639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3607', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(162, 6, 'purchase', -20000, 97639999, 97619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3608', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(163, 6, 'purchase', -20000, 97619999, 97599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3609', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(164, 6, 'purchase', -20000, 97599999, 97579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3610', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(165, 6, 'purchase', -20000, 97579999, 97559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3611', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(166, 6, 'purchase', -20000, 97559999, 97539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3612', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(167, 6, 'purchase', -20000, 97539999, 97519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3613', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(168, 6, 'purchase', -20000, 97519999, 97499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3614', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(169, 6, 'purchase', -20000, 97499999, 97479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3615', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(170, 6, 'purchase', -20000, 97479999, 97459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3616', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(171, 6, 'purchase', -20000, 97459999, 97439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3617', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(172, 6, 'purchase', -20000, 97439999, 97419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3618', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(173, 6, 'purchase', -20000, 97419999, 97399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3619', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(174, 6, 'purchase', -20000, 97399999, 97379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3620', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(175, 6, 'purchase', -20000, 97379999, 97359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3621', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(176, 6, 'purchase', -20000, 97359999, 97339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3622', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(177, 6, 'purchase', -20000, 97339999, 97319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3623', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(178, 6, 'purchase', -20000, 97319999, 97299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3624', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(179, 6, 'purchase', -20000, 97299999, 97279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3625', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(180, 6, 'purchase', -20000, 97279999, 97259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3626', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(181, 6, 'purchase', -20000, 97259999, 97239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3627', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(182, 6, 'purchase', -20000, 97239999, 97219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3628', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(183, 6, 'purchase', -20000, 97219999, 97199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3629', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(184, 6, 'purchase', -20000, 97199999, 97179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3630', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(185, 6, 'purchase', -20000, 97179999, 97159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3631', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(186, 6, 'purchase', -20000, 97159999, 97139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3632', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(187, 6, 'purchase', -20000, 97139999, 97119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3633', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(188, 6, 'purchase', -20000, 97119999, 97099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3634', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(189, 6, 'purchase', -20000, 97099999, 97079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3635', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(190, 6, 'purchase', -20000, 97079999, 97059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3636', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(191, 6, 'purchase', -20000, 97059999, 97039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3637', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(192, 6, 'purchase', -20000, 97039999, 97019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3638', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(193, 6, 'purchase', -20000, 97019999, 96999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3639', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(194, 6, 'purchase', -20000, 96999999, 96979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3640', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(195, 6, 'purchase', -20000, 96979999, 96959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3641', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(196, 6, 'purchase', -20000, 96959999, 96939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3642', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(197, 6, 'purchase', -20000, 96939999, 96919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3643', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(198, 6, 'purchase', -20000, 96919999, 96899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3644', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(199, 6, 'purchase', -20000, 96899999, 96879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3645', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(200, 6, 'purchase', -20000, 96879999, 96859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3646', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(201, 6, 'purchase', -20000, 96859999, 96839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3647', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(202, 6, 'purchase', -20000, 96839999, 96819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3648', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(203, 6, 'purchase', -20000, 96819999, 96799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3649', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(204, 6, 'purchase', -20000, 96799999, 96779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3650', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(205, 6, 'purchase', -20000, 96779999, 96759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3651', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(206, 6, 'purchase', -20000, 96759999, 96739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3652', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(207, 6, 'purchase', -20000, 96739999, 96719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3653', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(208, 6, 'purchase', -20000, 96719999, 96699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3654', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(209, 6, 'purchase', -20000, 96699999, 96679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3655', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(210, 6, 'purchase', -20000, 96679999, 96659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3656', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(211, 6, 'purchase', -20000, 96659999, 96639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3657', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(212, 6, 'purchase', -20000, 96639999, 96619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3658', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(213, 6, 'purchase', -20000, 96619999, 96599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3659', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(214, 6, 'purchase', -20000, 96599999, 96579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3660', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(215, 6, 'purchase', -20000, 96579999, 96559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3661', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(216, 6, 'purchase', -20000, 96559999, 96539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3662', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(217, 6, 'purchase', -20000, 96539999, 96519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3663', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(218, 6, 'purchase', -20000, 96519999, 96499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3664', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(219, 6, 'purchase', -20000, 96499999, 96479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3665', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(220, 6, 'purchase', -20000, 96479999, 96459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3666', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(221, 6, 'purchase', -20000, 96459999, 96439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3667', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(222, 6, 'purchase', -20000, 96439999, 96419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3668', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(223, 6, 'purchase', -20000, 96419999, 96399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3669', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(224, 6, 'purchase', -20000, 96399999, 96379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3670', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(225, 6, 'purchase', -20000, 96379999, 96359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3671', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(226, 6, 'purchase', -20000, 96359999, 96339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3672', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(227, 6, 'purchase', -20000, 96339999, 96319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3673', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(228, 6, 'purchase', -20000, 96319999, 96299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3674', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(229, 6, 'purchase', -20000, 96299999, 96279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3675', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(230, 6, 'purchase', -20000, 96279999, 96259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3676', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(231, 6, 'purchase', -20000, 96259999, 96239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3677', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(232, 6, 'purchase', -20000, 96239999, 96219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3678', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(233, 6, 'purchase', -20000, 96219999, 96199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3679', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(234, 6, 'purchase', -20000, 96199999, 96179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3680', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(235, 6, 'purchase', -20000, 96179999, 96159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3681', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(236, 6, 'purchase', -20000, 96159999, 96139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3682', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(237, 6, 'purchase', -20000, 96139999, 96119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3683', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(238, 6, 'purchase', -20000, 96119999, 96099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3684', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(239, 6, 'purchase', -20000, 96099999, 96079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3685', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(240, 6, 'purchase', -20000, 96079999, 96059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3686', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(241, 6, 'purchase', -20000, 96059999, 96039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3687', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(242, 6, 'purchase', -20000, 96039999, 96019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3688', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(243, 6, 'purchase', -20000, 96019999, 95999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3689', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(244, 6, 'purchase', -20000, 95999999, 95979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3690', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(245, 6, 'purchase', -20000, 95979999, 95959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3691', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(246, 6, 'purchase', -20000, 95959999, 95939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3692', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(247, 6, 'purchase', -20000, 95939999, 95919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3693', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(248, 6, 'purchase', -20000, 95919999, 95899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3694', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(249, 6, 'purchase', -20000, 95899999, 95879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3695', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(250, 6, 'purchase', -20000, 95879999, 95859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3696', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(251, 6, 'purchase', -20000, 95859999, 95839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3697', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(252, 6, 'purchase', -20000, 95839999, 95819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3698', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(253, 6, 'purchase', -20000, 95819999, 95799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3699', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(254, 6, 'purchase', -20000, 95799999, 95779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3700', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(255, 6, 'purchase', -20000, 95779999, 95759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3701', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(256, 6, 'purchase', -20000, 95759999, 95739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3702', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(257, 6, 'purchase', -20000, 95739999, 95719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3703', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(258, 6, 'purchase', -20000, 95719999, 95699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3704', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(259, 6, 'purchase', -20000, 95699999, 95679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3705', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(260, 6, 'purchase', -20000, 95679999, 95659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3706', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(261, 6, 'purchase', -20000, 95659999, 95639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3707', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(262, 6, 'purchase', -20000, 95639999, 95619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3708', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(263, 6, 'purchase', -20000, 95619999, 95599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3709', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(264, 6, 'purchase', -20000, 95599999, 95579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3710', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(265, 6, 'purchase', -20000, 95579999, 95559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3711', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(266, 6, 'purchase', -20000, 95559999, 95539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3712', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(267, 6, 'purchase', -20000, 95539999, 95519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3713', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(268, 6, 'purchase', -20000, 95519999, 95499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3714', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(269, 6, 'purchase', -20000, 95499999, 95479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3715', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(270, 6, 'purchase', -20000, 95479999, 95459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3716', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(271, 6, 'purchase', -20000, 95459999, 95439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3717', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(272, 6, 'purchase', -20000, 95439999, 95419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3718', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(273, 6, 'purchase', -20000, 95419999, 95399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3719', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(274, 6, 'purchase', -20000, 95399999, 95379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3720', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(275, 6, 'purchase', -20000, 95379999, 95359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3721', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(276, 6, 'purchase', -20000, 95359999, 95339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3722', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(277, 6, 'purchase', -20000, 95339999, 95319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3723', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(278, 6, 'purchase', -20000, 95319999, 95299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3724', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(279, 6, 'purchase', -20000, 95299999, 95279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3725', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(280, 6, 'purchase', -20000, 95279999, 95259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3726', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(281, 6, 'purchase', -20000, 95259999, 95239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3727', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(282, 6, 'purchase', -20000, 95239999, 95219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3728', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(283, 6, 'purchase', -20000, 95219999, 95199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3729', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(284, 6, 'purchase', -20000, 95199999, 95179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3730', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(285, 6, 'purchase', -20000, 95179999, 95159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3731', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(286, 6, 'purchase', -20000, 95159999, 95139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3732', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(287, 6, 'purchase', -20000, 95139999, 95119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3733', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(288, 6, 'purchase', -20000, 95119999, 95099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3734', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(289, 6, 'purchase', -20000, 95099999, 95079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3735', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(290, 6, 'purchase', -20000, 95079999, 95059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3736', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(291, 6, 'purchase', -20000, 95059999, 95039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3737', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(292, 6, 'purchase', -20000, 95039999, 95019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3738', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(293, 6, 'purchase', -20000, 95019999, 94999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3739', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(294, 6, 'purchase', -20000, 94999999, 94979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3740', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(295, 6, 'purchase', -20000, 94979999, 94959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3741', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(296, 6, 'purchase', -20000, 94959999, 94939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3742', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(297, 6, 'purchase', -20000, 94939999, 94919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3743', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(298, 6, 'purchase', -20000, 94919999, 94899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3744', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(299, 6, 'purchase', -20000, 94899999, 94879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3745', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(300, 6, 'purchase', -20000, 94879999, 94859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3746', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(301, 6, 'purchase', -20000, 94859999, 94839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3747', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(302, 6, 'purchase', -20000, 94839999, 94819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3748', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(303, 6, 'purchase', -20000, 94819999, 94799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3749', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(304, 6, 'purchase', -20000, 94799999, 94779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3750', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(305, 6, 'purchase', -20000, 94779999, 94759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3751', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(306, 6, 'purchase', -20000, 94759999, 94739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3752', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(307, 6, 'purchase', -20000, 94739999, 94719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3753', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(308, 6, 'purchase', -20000, 94719999, 94699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3754', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(309, 6, 'purchase', -20000, 94699999, 94679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3755', '2026-08-20 06:04:33', '2026-08-20 06:04:33'),
(310, 6, 'purchase', -20000, 94679999, 94659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3756', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(311, 6, 'purchase', -20000, 94659999, 94639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3757', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(312, 6, 'purchase', -20000, 94639999, 94619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3758', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(313, 6, 'purchase', -20000, 94619999, 94599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3759', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(314, 6, 'purchase', -20000, 94599999, 94579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3760', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(315, 6, 'purchase', -20000, 94579999, 94559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3761', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(316, 6, 'purchase', -20000, 94559999, 94539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3762', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(317, 6, 'purchase', -20000, 94539999, 94519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3763', '2026-08-20 06:04:34', '2026-08-20 06:04:34');
INSERT INTO `money_transactions` (`id`, `user_id`, `type`, `amount`, `balance_before`, `balance_after`, `description`, `reference_id`, `created_at`, `updated_at`) VALUES
(318, 6, 'purchase', -20000, 94519999, 94499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3764', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(319, 6, 'purchase', -20000, 94499999, 94479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3765', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(320, 6, 'purchase', -20000, 94479999, 94459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3766', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(321, 6, 'purchase', -20000, 94459999, 94439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3767', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(322, 6, 'purchase', -20000, 94439999, 94419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3768', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(323, 6, 'purchase', -20000, 94419999, 94399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3769', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(324, 6, 'purchase', -20000, 94399999, 94379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3770', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(325, 6, 'purchase', -20000, 94379999, 94359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3771', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(326, 6, 'purchase', -20000, 94359999, 94339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3772', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(327, 6, 'purchase', -20000, 94339999, 94319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3773', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(328, 6, 'purchase', -20000, 94319999, 94299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3774', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(329, 6, 'purchase', -20000, 94299999, 94279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3775', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(330, 6, 'purchase', -20000, 94279999, 94259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3776', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(331, 6, 'purchase', -20000, 94259999, 94239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3777', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(332, 6, 'purchase', -20000, 94239999, 94219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3778', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(333, 6, 'purchase', -20000, 94219999, 94199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3779', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(334, 6, 'purchase', -20000, 94199999, 94179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3780', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(335, 6, 'purchase', -20000, 94179999, 94159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3781', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(336, 6, 'purchase', -20000, 94159999, 94139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3782', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(337, 6, 'purchase', -20000, 94139999, 94119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3783', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(338, 6, 'purchase', -20000, 94119999, 94099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3784', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(339, 6, 'purchase', -20000, 94099999, 94079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3785', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(340, 6, 'purchase', -20000, 94079999, 94059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3786', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(341, 6, 'purchase', -20000, 94059999, 94039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3787', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(342, 6, 'purchase', -20000, 94039999, 94019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3788', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(343, 6, 'purchase', -20000, 94019999, 93999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3789', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(344, 6, 'purchase', -20000, 93999999, 93979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3790', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(345, 6, 'purchase', -20000, 93979999, 93959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3791', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(346, 6, 'purchase', -20000, 93959999, 93939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3792', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(347, 6, 'purchase', -20000, 93939999, 93919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3793', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(348, 6, 'purchase', -20000, 93919999, 93899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3794', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(349, 6, 'purchase', -20000, 93899999, 93879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3795', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(350, 6, 'purchase', -20000, 93879999, 93859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3796', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(351, 6, 'purchase', -20000, 93859999, 93839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3797', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(352, 6, 'purchase', -20000, 93839999, 93819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3798', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(353, 6, 'purchase', -20000, 93819999, 93799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3799', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(354, 6, 'purchase', -20000, 93799999, 93779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3800', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(355, 6, 'purchase', -20000, 93779999, 93759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3801', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(356, 6, 'purchase', -20000, 93759999, 93739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3802', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(357, 6, 'purchase', -20000, 93739999, 93719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3803', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(358, 6, 'purchase', -20000, 93719999, 93699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3804', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(359, 6, 'purchase', -20000, 93699999, 93679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3805', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(360, 6, 'purchase', -20000, 93679999, 93659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3806', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(361, 6, 'purchase', -20000, 93659999, 93639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3807', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(362, 6, 'purchase', -20000, 93639999, 93619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3808', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(363, 6, 'purchase', -20000, 93619999, 93599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3809', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(364, 6, 'purchase', -20000, 93599999, 93579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3810', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(365, 6, 'purchase', -20000, 93579999, 93559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3811', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(366, 6, 'purchase', -20000, 93559999, 93539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3812', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(367, 6, 'purchase', -20000, 93539999, 93519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3813', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(368, 6, 'purchase', -20000, 93519999, 93499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3814', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(369, 6, 'purchase', -20000, 93499999, 93479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3815', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(370, 6, 'purchase', -20000, 93479999, 93459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3816', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(371, 6, 'purchase', -20000, 93459999, 93439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3817', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(372, 6, 'purchase', -20000, 93439999, 93419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3818', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(373, 6, 'purchase', -20000, 93419999, 93399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3819', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(374, 6, 'purchase', -20000, 93399999, 93379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3820', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(375, 6, 'purchase', -20000, 93379999, 93359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3821', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(376, 6, 'purchase', -20000, 93359999, 93339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3822', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(377, 6, 'purchase', -20000, 93339999, 93319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3823', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(378, 6, 'purchase', -20000, 93319999, 93299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3824', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(379, 6, 'purchase', -20000, 93299999, 93279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3825', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(380, 6, 'purchase', -20000, 93279999, 93259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3826', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(381, 6, 'purchase', -20000, 93259999, 93239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3827', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(382, 6, 'purchase', -20000, 93239999, 93219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3828', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(383, 6, 'purchase', -20000, 93219999, 93199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3829', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(384, 6, 'purchase', -20000, 93199999, 93179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3830', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(385, 6, 'purchase', -20000, 93179999, 93159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3831', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(386, 6, 'purchase', -20000, 93159999, 93139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3832', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(387, 6, 'purchase', -20000, 93139999, 93119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3833', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(388, 6, 'purchase', -20000, 93119999, 93099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3834', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(389, 6, 'purchase', -20000, 93099999, 93079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3835', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(390, 6, 'purchase', -20000, 93079999, 93059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3836', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(391, 6, 'purchase', -20000, 93059999, 93039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3837', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(392, 6, 'purchase', -20000, 93039999, 93019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3838', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(393, 6, 'purchase', -20000, 93019999, 92999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3839', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(394, 6, 'purchase', -20000, 92999999, 92979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3840', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(395, 6, 'purchase', -20000, 92979999, 92959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3841', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(396, 6, 'purchase', -20000, 92959999, 92939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3842', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(397, 6, 'purchase', -20000, 92939999, 92919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3843', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(398, 6, 'purchase', -20000, 92919999, 92899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3844', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(399, 6, 'purchase', -20000, 92899999, 92879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3845', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(400, 6, 'purchase', -20000, 92879999, 92859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3846', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(401, 6, 'purchase', -20000, 92859999, 92839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3847', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(402, 6, 'purchase', -20000, 92839999, 92819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3848', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(403, 6, 'purchase', -20000, 92819999, 92799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3849', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(404, 6, 'purchase', -20000, 92799999, 92779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3850', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(405, 6, 'purchase', -20000, 92779999, 92759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3851', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(406, 6, 'purchase', -20000, 92759999, 92739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3852', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(407, 6, 'purchase', -20000, 92739999, 92719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3853', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(408, 6, 'purchase', -20000, 92719999, 92699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3854', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(409, 6, 'purchase', -20000, 92699999, 92679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3855', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(410, 6, 'purchase', -20000, 92679999, 92659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3856', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(411, 6, 'purchase', -20000, 92659999, 92639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3857', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(412, 6, 'purchase', -20000, 92639999, 92619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3858', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(413, 6, 'purchase', -20000, 92619999, 92599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3859', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(414, 6, 'purchase', -20000, 92599999, 92579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3860', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(415, 6, 'purchase', -20000, 92579999, 92559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3861', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(416, 6, 'purchase', -20000, 92559999, 92539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3862', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(417, 6, 'purchase', -20000, 92539999, 92519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3863', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(418, 6, 'purchase', -20000, 92519999, 92499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3864', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(419, 6, 'purchase', -20000, 92499999, 92479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3865', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(420, 6, 'purchase', -20000, 92479999, 92459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3866', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(421, 6, 'purchase', -20000, 92459999, 92439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3867', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(422, 6, 'purchase', -20000, 92439999, 92419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3868', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(423, 6, 'purchase', -20000, 92419999, 92399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3869', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(424, 6, 'purchase', -20000, 92399999, 92379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3870', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(425, 6, 'purchase', -20000, 92379999, 92359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3871', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(426, 6, 'purchase', -20000, 92359999, 92339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3872', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(427, 6, 'purchase', -20000, 92339999, 92319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3873', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(428, 6, 'purchase', -20000, 92319999, 92299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3874', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(429, 6, 'purchase', -20000, 92299999, 92279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3875', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(430, 6, 'purchase', -20000, 92279999, 92259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3876', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(431, 6, 'purchase', -20000, 92259999, 92239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3877', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(432, 6, 'purchase', -20000, 92239999, 92219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3878', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(433, 6, 'purchase', -20000, 92219999, 92199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3879', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(434, 6, 'purchase', -20000, 92199999, 92179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3880', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(435, 6, 'purchase', -20000, 92179999, 92159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3881', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(436, 6, 'purchase', -20000, 92159999, 92139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3882', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(437, 6, 'purchase', -20000, 92139999, 92119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3883', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(438, 6, 'purchase', -20000, 92119999, 92099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3884', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(439, 6, 'purchase', -20000, 92099999, 92079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3885', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(440, 6, 'purchase', -20000, 92079999, 92059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3886', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(441, 6, 'purchase', -20000, 92059999, 92039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3887', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(442, 6, 'purchase', -20000, 92039999, 92019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3888', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(443, 6, 'purchase', -20000, 92019999, 91999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3889', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(444, 6, 'purchase', -20000, 91999999, 91979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3890', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(445, 6, 'purchase', -20000, 91979999, 91959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3891', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(446, 6, 'purchase', -20000, 91959999, 91939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3892', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(447, 6, 'purchase', -20000, 91939999, 91919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3893', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(448, 6, 'purchase', -20000, 91919999, 91899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3894', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(449, 6, 'purchase', -20000, 91899999, 91879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3895', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(450, 6, 'purchase', -20000, 91879999, 91859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3896', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(451, 6, 'purchase', -20000, 91859999, 91839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3897', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(452, 6, 'purchase', -20000, 91839999, 91819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3898', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(453, 6, 'purchase', -20000, 91819999, 91799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3899', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(454, 6, 'purchase', -20000, 91799999, 91779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3900', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(455, 6, 'purchase', -20000, 91779999, 91759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3901', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(456, 6, 'purchase', -20000, 91759999, 91739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3902', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(457, 6, 'purchase', -20000, 91739999, 91719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3903', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(458, 6, 'purchase', -20000, 91719999, 91699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3904', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(459, 6, 'purchase', -20000, 91699999, 91679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3905', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(460, 6, 'purchase', -20000, 91679999, 91659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3906', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(461, 6, 'purchase', -20000, 91659999, 91639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3907', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(462, 6, 'purchase', -20000, 91639999, 91619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3908', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(463, 6, 'purchase', -20000, 91619999, 91599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3909', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(464, 6, 'purchase', -20000, 91599999, 91579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3910', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(465, 6, 'purchase', -20000, 91579999, 91559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3911', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(466, 6, 'purchase', -20000, 91559999, 91539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3912', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(467, 6, 'purchase', -20000, 91539999, 91519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3913', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(468, 6, 'purchase', -20000, 91519999, 91499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3914', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(469, 6, 'purchase', -20000, 91499999, 91479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3915', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(470, 6, 'purchase', -20000, 91479999, 91459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3916', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(471, 6, 'purchase', -20000, 91459999, 91439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3917', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(472, 6, 'purchase', -20000, 91439999, 91419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3918', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(473, 6, 'purchase', -20000, 91419999, 91399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3919', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(474, 6, 'purchase', -20000, 91399999, 91379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3920', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(475, 6, 'purchase', -20000, 91379999, 91359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3921', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(476, 6, 'purchase', -20000, 91359999, 91339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3922', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(477, 6, 'purchase', -20000, 91339999, 91319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3923', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(478, 6, 'purchase', -20000, 91319999, 91299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3924', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(479, 6, 'purchase', -20000, 91299999, 91279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3925', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(480, 6, 'purchase', -20000, 91279999, 91259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3926', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(481, 6, 'purchase', -20000, 91259999, 91239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3927', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(482, 6, 'purchase', -20000, 91239999, 91219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3928', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(483, 6, 'purchase', -20000, 91219999, 91199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3929', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(484, 6, 'purchase', -20000, 91199999, 91179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3930', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(485, 6, 'purchase', -20000, 91179999, 91159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3931', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(486, 6, 'purchase', -20000, 91159999, 91139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3932', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(487, 6, 'purchase', -20000, 91139999, 91119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3933', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(488, 6, 'purchase', -20000, 91119999, 91099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3934', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(489, 6, 'purchase', -20000, 91099999, 91079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3935', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(490, 6, 'purchase', -20000, 91079999, 91059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3936', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(491, 6, 'purchase', -20000, 91059999, 91039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3937', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(492, 6, 'purchase', -20000, 91039999, 91019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3938', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(493, 6, 'purchase', -20000, 91019999, 90999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3939', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(494, 6, 'purchase', -20000, 90999999, 90979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3940', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(495, 6, 'purchase', -20000, 90979999, 90959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3941', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(496, 6, 'purchase', -20000, 90959999, 90939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3942', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(497, 6, 'purchase', -20000, 90939999, 90919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3943', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(498, 6, 'purchase', -20000, 90919999, 90899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3944', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(499, 6, 'purchase', -20000, 90899999, 90879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3945', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(500, 6, 'purchase', -20000, 90879999, 90859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3946', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(501, 6, 'purchase', -20000, 90859999, 90839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3947', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(502, 6, 'purchase', -20000, 90839999, 90819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3948', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(503, 6, 'purchase', -20000, 90819999, 90799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3949', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(504, 6, 'purchase', -20000, 90799999, 90779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3950', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(505, 6, 'purchase', -20000, 90779999, 90759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3951', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(506, 6, 'purchase', -20000, 90759999, 90739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3952', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(507, 6, 'purchase', -20000, 90739999, 90719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3953', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(508, 6, 'purchase', -20000, 90719999, 90699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3954', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(509, 6, 'purchase', -20000, 90699999, 90679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3955', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(510, 6, 'purchase', -20000, 90679999, 90659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3956', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(511, 6, 'purchase', -20000, 90659999, 90639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3957', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(512, 6, 'purchase', -20000, 90639999, 90619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3958', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(513, 6, 'purchase', -20000, 90619999, 90599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3959', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(514, 6, 'purchase', -20000, 90599999, 90579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3960', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(515, 6, 'purchase', -20000, 90579999, 90559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3961', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(516, 6, 'purchase', -20000, 90559999, 90539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3962', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(517, 6, 'purchase', -20000, 90539999, 90519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3963', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(518, 6, 'purchase', -20000, 90519999, 90499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3964', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(519, 6, 'purchase', -20000, 90499999, 90479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3965', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(520, 6, 'purchase', -20000, 90479999, 90459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3966', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(521, 6, 'purchase', -20000, 90459999, 90439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3967', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(522, 6, 'purchase', -20000, 90439999, 90419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3968', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(523, 6, 'purchase', -20000, 90419999, 90399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3969', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(524, 6, 'purchase', -20000, 90399999, 90379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3970', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(525, 6, 'purchase', -20000, 90379999, 90359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3971', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(526, 6, 'purchase', -20000, 90359999, 90339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3972', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(527, 6, 'purchase', -20000, 90339999, 90319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3973', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(528, 6, 'purchase', -20000, 90319999, 90299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3974', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(529, 6, 'purchase', -20000, 90299999, 90279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3975', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(530, 6, 'purchase', -20000, 90279999, 90259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3976', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(531, 6, 'purchase', -20000, 90259999, 90239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3977', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(532, 6, 'purchase', -20000, 90239999, 90219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3978', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(533, 6, 'purchase', -20000, 90219999, 90199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3979', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(534, 6, 'purchase', -20000, 90199999, 90179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3980', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(535, 6, 'purchase', -20000, 90179999, 90159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3981', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(536, 6, 'purchase', -20000, 90159999, 90139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3982', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(537, 6, 'purchase', -20000, 90139999, 90119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3983', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(538, 6, 'purchase', -20000, 90119999, 90099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3984', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(539, 6, 'purchase', -20000, 90099999, 90079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3985', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(540, 6, 'purchase', -20000, 90079999, 90059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3986', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(541, 6, 'purchase', -20000, 90059999, 90039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3987', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(542, 6, 'purchase', -20000, 90039999, 90019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3988', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(543, 6, 'purchase', -20000, 90019999, 89999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3989', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(544, 6, 'purchase', -20000, 89999999, 89979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3990', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(545, 6, 'purchase', -20000, 89979999, 89959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3991', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(546, 6, 'purchase', -20000, 89959999, 89939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3992', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(547, 6, 'purchase', -20000, 89939999, 89919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3993', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(548, 6, 'purchase', -20000, 89919999, 89899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3994', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(549, 6, 'purchase', -20000, 89899999, 89879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3995', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(550, 6, 'purchase', -20000, 89879999, 89859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3996', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(551, 6, 'purchase', -20000, 89859999, 89839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3997', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(552, 6, 'purchase', -20000, 89839999, 89819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3998', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(553, 6, 'purchase', -20000, 89819999, 89799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-3999', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(554, 6, 'purchase', -20000, 89799999, 89779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4000', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(555, 6, 'purchase', -20000, 89779999, 89759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4001', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(556, 6, 'purchase', -20000, 89759999, 89739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4002', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(557, 6, 'purchase', -20000, 89739999, 89719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4003', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(558, 6, 'purchase', -20000, 89719999, 89699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4004', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(559, 6, 'purchase', -20000, 89699999, 89679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4005', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(560, 6, 'purchase', -20000, 89679999, 89659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4006', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(561, 6, 'purchase', -20000, 89659999, 89639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4007', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(562, 6, 'purchase', -20000, 89639999, 89619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4008', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(563, 6, 'purchase', -20000, 89619999, 89599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4009', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(564, 6, 'purchase', -20000, 89599999, 89579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4010', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(565, 6, 'purchase', -20000, 89579999, 89559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4011', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(566, 6, 'purchase', -20000, 89559999, 89539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4012', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(567, 6, 'purchase', -20000, 89539999, 89519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4013', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(568, 6, 'purchase', -20000, 89519999, 89499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4014', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(569, 6, 'purchase', -20000, 89499999, 89479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4015', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(570, 6, 'purchase', -20000, 89479999, 89459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4016', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(571, 6, 'purchase', -20000, 89459999, 89439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4017', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(572, 6, 'purchase', -20000, 89439999, 89419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4018', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(573, 6, 'purchase', -20000, 89419999, 89399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4019', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(574, 6, 'purchase', -20000, 89399999, 89379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4020', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(575, 6, 'purchase', -20000, 89379999, 89359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4021', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(576, 6, 'purchase', -20000, 89359999, 89339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4022', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(577, 6, 'purchase', -20000, 89339999, 89319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4023', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(578, 6, 'purchase', -20000, 89319999, 89299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4024', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(579, 6, 'purchase', -20000, 89299999, 89279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4025', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(580, 6, 'purchase', -20000, 89279999, 89259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4026', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(581, 6, 'purchase', -20000, 89259999, 89239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4027', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(582, 6, 'purchase', -20000, 89239999, 89219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4028', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(583, 6, 'purchase', -20000, 89219999, 89199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4029', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(584, 6, 'purchase', -20000, 89199999, 89179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4030', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(585, 6, 'purchase', -20000, 89179999, 89159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4031', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(586, 6, 'purchase', -20000, 89159999, 89139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4032', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(587, 6, 'purchase', -20000, 89139999, 89119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4033', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(588, 6, 'purchase', -20000, 89119999, 89099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4034', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(589, 6, 'purchase', -20000, 89099999, 89079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4035', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(590, 6, 'purchase', -20000, 89079999, 89059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4036', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(591, 6, 'purchase', -20000, 89059999, 89039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4037', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(592, 6, 'purchase', -20000, 89039999, 89019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4038', '2026-08-20 06:04:34', '2026-08-20 06:04:34');
INSERT INTO `money_transactions` (`id`, `user_id`, `type`, `amount`, `balance_before`, `balance_after`, `description`, `reference_id`, `created_at`, `updated_at`) VALUES
(593, 6, 'purchase', -20000, 89019999, 88999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4039', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(594, 6, 'purchase', -20000, 88999999, 88979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4040', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(595, 6, 'purchase', -20000, 88979999, 88959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4041', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(596, 6, 'purchase', -20000, 88959999, 88939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4042', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(597, 6, 'purchase', -20000, 88939999, 88919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4043', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(598, 6, 'purchase', -20000, 88919999, 88899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4044', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(599, 6, 'purchase', -20000, 88899999, 88879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4045', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(600, 6, 'purchase', -20000, 88879999, 88859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4046', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(601, 6, 'purchase', -20000, 88859999, 88839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4047', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(602, 6, 'purchase', -20000, 88839999, 88819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4048', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(603, 6, 'purchase', -20000, 88819999, 88799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4049', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(604, 6, 'purchase', -20000, 88799999, 88779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4050', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(605, 6, 'purchase', -20000, 88779999, 88759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4051', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(606, 6, 'purchase', -20000, 88759999, 88739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4052', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(607, 6, 'purchase', -20000, 88739999, 88719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4053', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(608, 6, 'purchase', -20000, 88719999, 88699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4054', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(609, 6, 'purchase', -20000, 88699999, 88679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4055', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(610, 6, 'purchase', -20000, 88679999, 88659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4056', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(611, 6, 'purchase', -20000, 88659999, 88639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4057', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(612, 6, 'purchase', -20000, 88639999, 88619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4058', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(613, 6, 'purchase', -20000, 88619999, 88599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4059', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(614, 6, 'purchase', -20000, 88599999, 88579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4060', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(615, 6, 'purchase', -20000, 88579999, 88559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4061', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(616, 6, 'purchase', -20000, 88559999, 88539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4062', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(617, 6, 'purchase', -20000, 88539999, 88519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4063', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(618, 6, 'purchase', -20000, 88519999, 88499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4064', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(619, 6, 'purchase', -20000, 88499999, 88479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4065', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(620, 6, 'purchase', -20000, 88479999, 88459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4066', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(621, 6, 'purchase', -20000, 88459999, 88439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4067', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(622, 6, 'purchase', -20000, 88439999, 88419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4068', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(623, 6, 'purchase', -20000, 88419999, 88399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4069', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(624, 6, 'purchase', -20000, 88399999, 88379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4070', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(625, 6, 'purchase', -20000, 88379999, 88359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4071', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(626, 6, 'purchase', -20000, 88359999, 88339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4072', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(627, 6, 'purchase', -20000, 88339999, 88319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4073', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(628, 6, 'purchase', -20000, 88319999, 88299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4074', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(629, 6, 'purchase', -20000, 88299999, 88279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4075', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(630, 6, 'purchase', -20000, 88279999, 88259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4076', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(631, 6, 'purchase', -20000, 88259999, 88239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4077', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(632, 6, 'purchase', -20000, 88239999, 88219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4078', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(633, 6, 'purchase', -20000, 88219999, 88199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4079', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(634, 6, 'purchase', -20000, 88199999, 88179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4080', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(635, 6, 'purchase', -20000, 88179999, 88159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4081', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(636, 6, 'purchase', -20000, 88159999, 88139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4082', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(637, 6, 'purchase', -20000, 88139999, 88119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4083', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(638, 6, 'purchase', -20000, 88119999, 88099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4084', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(639, 6, 'purchase', -20000, 88099999, 88079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4085', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(640, 6, 'purchase', -20000, 88079999, 88059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4086', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(641, 6, 'purchase', -20000, 88059999, 88039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4087', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(642, 6, 'purchase', -20000, 88039999, 88019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4088', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(643, 6, 'purchase', -20000, 88019999, 87999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4089', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(644, 6, 'purchase', -20000, 87999999, 87979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4090', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(645, 6, 'purchase', -20000, 87979999, 87959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4091', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(646, 6, 'purchase', -20000, 87959999, 87939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4092', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(647, 6, 'purchase', -20000, 87939999, 87919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4093', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(648, 6, 'purchase', -20000, 87919999, 87899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4094', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(649, 6, 'purchase', -20000, 87899999, 87879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4095', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(650, 6, 'purchase', -20000, 87879999, 87859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4096', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(651, 6, 'purchase', -20000, 87859999, 87839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4097', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(652, 6, 'purchase', -20000, 87839999, 87819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4098', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(653, 6, 'purchase', -20000, 87819999, 87799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4099', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(654, 6, 'purchase', -20000, 87799999, 87779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4100', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(655, 6, 'purchase', -20000, 87779999, 87759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4101', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(656, 6, 'purchase', -20000, 87759999, 87739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4102', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(657, 6, 'purchase', -20000, 87739999, 87719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4103', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(658, 6, 'purchase', -20000, 87719999, 87699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4104', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(659, 6, 'purchase', -20000, 87699999, 87679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4105', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(660, 6, 'purchase', -20000, 87679999, 87659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4106', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(661, 6, 'purchase', -20000, 87659999, 87639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4107', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(662, 6, 'purchase', -20000, 87639999, 87619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4108', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(663, 6, 'purchase', -20000, 87619999, 87599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4109', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(664, 6, 'purchase', -20000, 87599999, 87579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4110', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(665, 6, 'purchase', -20000, 87579999, 87559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4111', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(666, 6, 'purchase', -20000, 87559999, 87539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4112', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(667, 6, 'purchase', -20000, 87539999, 87519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4113', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(668, 6, 'purchase', -20000, 87519999, 87499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4114', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(669, 6, 'purchase', -20000, 87499999, 87479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4115', '2026-08-20 06:04:34', '2026-08-20 06:04:34'),
(670, 6, 'purchase', -20000, 87479999, 87459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4116', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(671, 6, 'purchase', -20000, 87459999, 87439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4117', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(672, 6, 'purchase', -20000, 87439999, 87419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4118', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(673, 6, 'purchase', -20000, 87419999, 87399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4119', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(674, 6, 'purchase', -20000, 87399999, 87379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4120', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(675, 6, 'purchase', -20000, 87379999, 87359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4121', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(676, 6, 'purchase', -20000, 87359999, 87339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4122', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(677, 6, 'purchase', -20000, 87339999, 87319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4123', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(678, 6, 'purchase', -20000, 87319999, 87299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4124', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(679, 6, 'purchase', -20000, 87299999, 87279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4125', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(680, 6, 'purchase', -20000, 87279999, 87259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4126', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(681, 6, 'purchase', -20000, 87259999, 87239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4127', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(682, 6, 'purchase', -20000, 87239999, 87219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4128', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(683, 6, 'purchase', -20000, 87219999, 87199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4129', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(684, 6, 'purchase', -20000, 87199999, 87179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4130', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(685, 6, 'purchase', -20000, 87179999, 87159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4131', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(686, 6, 'purchase', -20000, 87159999, 87139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4132', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(687, 6, 'purchase', -20000, 87139999, 87119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4133', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(688, 6, 'purchase', -20000, 87119999, 87099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4134', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(689, 6, 'purchase', -20000, 87099999, 87079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4135', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(690, 6, 'purchase', -20000, 87079999, 87059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4136', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(691, 6, 'purchase', -20000, 87059999, 87039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4137', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(692, 6, 'purchase', -20000, 87039999, 87019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4138', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(693, 6, 'purchase', -20000, 87019999, 86999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4139', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(694, 6, 'purchase', -20000, 86999999, 86979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4140', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(695, 6, 'purchase', -20000, 86979999, 86959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4141', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(696, 6, 'purchase', -20000, 86959999, 86939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4142', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(697, 6, 'purchase', -20000, 86939999, 86919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4143', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(698, 6, 'purchase', -20000, 86919999, 86899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4144', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(699, 6, 'purchase', -20000, 86899999, 86879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4145', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(700, 6, 'purchase', -20000, 86879999, 86859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4146', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(701, 6, 'purchase', -20000, 86859999, 86839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4147', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(702, 6, 'purchase', -20000, 86839999, 86819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4148', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(703, 6, 'purchase', -20000, 86819999, 86799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4149', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(704, 6, 'purchase', -20000, 86799999, 86779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4150', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(705, 6, 'purchase', -20000, 86779999, 86759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4151', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(706, 6, 'purchase', -20000, 86759999, 86739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4152', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(707, 6, 'purchase', -20000, 86739999, 86719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4153', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(708, 6, 'purchase', -20000, 86719999, 86699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4154', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(709, 6, 'purchase', -20000, 86699999, 86679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4155', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(710, 6, 'purchase', -20000, 86679999, 86659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4156', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(711, 6, 'purchase', -20000, 86659999, 86639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4157', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(712, 6, 'purchase', -20000, 86639999, 86619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4158', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(713, 6, 'purchase', -20000, 86619999, 86599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4159', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(714, 6, 'purchase', -20000, 86599999, 86579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4160', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(715, 6, 'purchase', -20000, 86579999, 86559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4161', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(716, 6, 'purchase', -20000, 86559999, 86539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4162', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(717, 6, 'purchase', -20000, 86539999, 86519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4163', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(718, 6, 'purchase', -20000, 86519999, 86499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4164', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(719, 6, 'purchase', -20000, 86499999, 86479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4165', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(720, 6, 'purchase', -20000, 86479999, 86459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4166', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(721, 6, 'purchase', -20000, 86459999, 86439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4167', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(722, 6, 'purchase', -20000, 86439999, 86419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4168', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(723, 6, 'purchase', -20000, 86419999, 86399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4169', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(724, 6, 'purchase', -20000, 86399999, 86379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4170', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(725, 6, 'purchase', -20000, 86379999, 86359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4171', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(726, 6, 'purchase', -20000, 86359999, 86339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4172', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(727, 6, 'purchase', -20000, 86339999, 86319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4173', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(728, 6, 'purchase', -20000, 86319999, 86299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4174', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(729, 6, 'purchase', -20000, 86299999, 86279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4175', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(730, 6, 'purchase', -20000, 86279999, 86259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4176', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(731, 6, 'purchase', -20000, 86259999, 86239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4177', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(732, 6, 'purchase', -20000, 86239999, 86219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4178', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(733, 6, 'purchase', -20000, 86219999, 86199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4179', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(734, 6, 'purchase', -20000, 86199999, 86179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4180', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(735, 6, 'purchase', -20000, 86179999, 86159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4181', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(736, 6, 'purchase', -20000, 86159999, 86139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4182', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(737, 6, 'purchase', -20000, 86139999, 86119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4183', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(738, 6, 'purchase', -20000, 86119999, 86099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4184', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(739, 6, 'purchase', -20000, 86099999, 86079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4185', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(740, 6, 'purchase', -20000, 86079999, 86059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4186', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(741, 6, 'purchase', -20000, 86059999, 86039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4187', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(742, 6, 'purchase', -20000, 86039999, 86019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4188', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(743, 6, 'purchase', -20000, 86019999, 85999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4189', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(744, 6, 'purchase', -20000, 85999999, 85979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4190', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(745, 6, 'purchase', -20000, 85979999, 85959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4191', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(746, 6, 'purchase', -20000, 85959999, 85939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4192', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(747, 6, 'purchase', -20000, 85939999, 85919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4193', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(748, 6, 'purchase', -20000, 85919999, 85899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4194', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(749, 6, 'purchase', -20000, 85899999, 85879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4195', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(750, 6, 'purchase', -20000, 85879999, 85859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4196', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(751, 6, 'purchase', -20000, 85859999, 85839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4197', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(752, 6, 'purchase', -20000, 85839999, 85819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4198', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(753, 6, 'purchase', -20000, 85819999, 85799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4199', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(754, 6, 'purchase', -20000, 85799999, 85779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4200', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(755, 6, 'purchase', -20000, 85779999, 85759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4201', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(756, 6, 'purchase', -20000, 85759999, 85739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4202', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(757, 6, 'purchase', -20000, 85739999, 85719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4203', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(758, 6, 'purchase', -20000, 85719999, 85699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4204', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(759, 6, 'purchase', -20000, 85699999, 85679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4205', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(760, 6, 'purchase', -20000, 85679999, 85659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4206', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(761, 6, 'purchase', -20000, 85659999, 85639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4207', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(762, 6, 'purchase', -20000, 85639999, 85619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4208', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(763, 6, 'purchase', -20000, 85619999, 85599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4209', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(764, 6, 'purchase', -20000, 85599999, 85579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4210', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(765, 6, 'purchase', -20000, 85579999, 85559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4211', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(766, 6, 'purchase', -20000, 85559999, 85539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4212', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(767, 6, 'purchase', -20000, 85539999, 85519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4213', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(768, 6, 'purchase', -20000, 85519999, 85499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4214', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(769, 6, 'purchase', -20000, 85499999, 85479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4215', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(770, 6, 'purchase', -20000, 85479999, 85459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4216', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(771, 6, 'purchase', -20000, 85459999, 85439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4217', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(772, 6, 'purchase', -20000, 85439999, 85419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4218', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(773, 6, 'purchase', -20000, 85419999, 85399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4219', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(774, 6, 'purchase', -20000, 85399999, 85379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4220', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(775, 6, 'purchase', -20000, 85379999, 85359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4221', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(776, 6, 'purchase', -20000, 85359999, 85339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4222', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(777, 6, 'purchase', -20000, 85339999, 85319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4223', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(778, 6, 'purchase', -20000, 85319999, 85299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4224', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(779, 6, 'purchase', -20000, 85299999, 85279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4225', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(780, 6, 'purchase', -20000, 85279999, 85259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4226', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(781, 6, 'purchase', -20000, 85259999, 85239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4227', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(782, 6, 'purchase', -20000, 85239999, 85219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4228', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(783, 6, 'purchase', -20000, 85219999, 85199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4229', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(784, 6, 'purchase', -20000, 85199999, 85179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4230', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(785, 6, 'purchase', -20000, 85179999, 85159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4231', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(786, 6, 'purchase', -20000, 85159999, 85139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4232', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(787, 6, 'purchase', -20000, 85139999, 85119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4233', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(788, 6, 'purchase', -20000, 85119999, 85099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4234', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(789, 6, 'purchase', -20000, 85099999, 85079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4235', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(790, 6, 'purchase', -20000, 85079999, 85059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4236', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(791, 6, 'purchase', -20000, 85059999, 85039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4237', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(792, 6, 'purchase', -20000, 85039999, 85019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4238', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(793, 6, 'purchase', -20000, 85019999, 84999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4239', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(794, 6, 'purchase', -20000, 84999999, 84979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4240', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(795, 6, 'purchase', -20000, 84979999, 84959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4241', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(796, 6, 'purchase', -20000, 84959999, 84939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4242', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(797, 6, 'purchase', -20000, 84939999, 84919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4243', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(798, 6, 'purchase', -20000, 84919999, 84899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4244', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(799, 6, 'purchase', -20000, 84899999, 84879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4245', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(800, 6, 'purchase', -20000, 84879999, 84859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4246', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(801, 6, 'purchase', -20000, 84859999, 84839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4247', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(802, 6, 'purchase', -20000, 84839999, 84819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4248', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(803, 6, 'purchase', -20000, 84819999, 84799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4249', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(804, 6, 'purchase', -20000, 84799999, 84779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4250', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(805, 6, 'purchase', -20000, 84779999, 84759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4251', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(806, 6, 'purchase', -20000, 84759999, 84739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4252', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(807, 6, 'purchase', -20000, 84739999, 84719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4253', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(808, 6, 'purchase', -20000, 84719999, 84699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4254', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(809, 6, 'purchase', -20000, 84699999, 84679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4255', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(810, 6, 'purchase', -20000, 84679999, 84659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4256', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(811, 6, 'purchase', -20000, 84659999, 84639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4257', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(812, 6, 'purchase', -20000, 84639999, 84619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4258', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(813, 6, 'purchase', -20000, 84619999, 84599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4259', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(814, 6, 'purchase', -20000, 84599999, 84579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4260', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(815, 6, 'purchase', -20000, 84579999, 84559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4261', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(816, 6, 'purchase', -20000, 84559999, 84539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4262', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(817, 6, 'purchase', -20000, 84539999, 84519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4263', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(818, 6, 'purchase', -20000, 84519999, 84499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4264', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(819, 6, 'purchase', -20000, 84499999, 84479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4265', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(820, 6, 'purchase', -20000, 84479999, 84459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4266', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(821, 6, 'purchase', -20000, 84459999, 84439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4267', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(822, 6, 'purchase', -20000, 84439999, 84419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4268', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(823, 6, 'purchase', -20000, 84419999, 84399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4269', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(824, 6, 'purchase', -20000, 84399999, 84379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4270', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(825, 6, 'purchase', -20000, 84379999, 84359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4271', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(826, 6, 'purchase', -20000, 84359999, 84339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4272', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(827, 6, 'purchase', -20000, 84339999, 84319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4273', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(828, 6, 'purchase', -20000, 84319999, 84299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4274', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(829, 6, 'purchase', -20000, 84299999, 84279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4275', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(830, 6, 'purchase', -20000, 84279999, 84259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4276', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(831, 6, 'purchase', -20000, 84259999, 84239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4277', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(832, 6, 'purchase', -20000, 84239999, 84219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4278', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(833, 6, 'purchase', -20000, 84219999, 84199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4279', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(834, 6, 'purchase', -20000, 84199999, 84179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4280', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(835, 6, 'purchase', -20000, 84179999, 84159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4281', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(836, 6, 'purchase', -20000, 84159999, 84139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4282', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(837, 6, 'purchase', -20000, 84139999, 84119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4283', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(838, 6, 'purchase', -20000, 84119999, 84099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4284', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(839, 6, 'purchase', -20000, 84099999, 84079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4285', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(840, 6, 'purchase', -20000, 84079999, 84059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4286', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(841, 6, 'purchase', -20000, 84059999, 84039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4287', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(842, 6, 'purchase', -20000, 84039999, 84019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4288', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(843, 6, 'purchase', -20000, 84019999, 83999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4289', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(844, 6, 'purchase', -20000, 83999999, 83979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4290', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(845, 6, 'purchase', -20000, 83979999, 83959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4291', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(846, 6, 'purchase', -20000, 83959999, 83939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4292', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(847, 6, 'purchase', -20000, 83939999, 83919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4293', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(848, 6, 'purchase', -20000, 83919999, 83899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4294', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(849, 6, 'purchase', -20000, 83899999, 83879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4295', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(850, 6, 'purchase', -20000, 83879999, 83859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4296', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(851, 6, 'purchase', -20000, 83859999, 83839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4297', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(852, 6, 'purchase', -20000, 83839999, 83819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4298', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(853, 6, 'purchase', -20000, 83819999, 83799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4299', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(854, 6, 'purchase', -20000, 83799999, 83779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4300', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(855, 6, 'purchase', -20000, 83779999, 83759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4301', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(856, 6, 'purchase', -20000, 83759999, 83739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4302', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(857, 6, 'purchase', -20000, 83739999, 83719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4303', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(858, 6, 'purchase', -20000, 83719999, 83699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4304', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(859, 6, 'purchase', -20000, 83699999, 83679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4305', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(860, 6, 'purchase', -20000, 83679999, 83659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4306', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(861, 6, 'purchase', -20000, 83659999, 83639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4307', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(862, 6, 'purchase', -20000, 83639999, 83619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4308', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(863, 6, 'purchase', -20000, 83619999, 83599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4309', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(864, 6, 'purchase', -20000, 83599999, 83579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4310', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(865, 6, 'purchase', -20000, 83579999, 83559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4311', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(866, 6, 'purchase', -20000, 83559999, 83539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4312', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(867, 6, 'purchase', -20000, 83539999, 83519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4313', '2026-08-20 06:04:35', '2026-08-20 06:04:35');
INSERT INTO `money_transactions` (`id`, `user_id`, `type`, `amount`, `balance_before`, `balance_after`, `description`, `reference_id`, `created_at`, `updated_at`) VALUES
(868, 6, 'purchase', -20000, 83519999, 83499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4314', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(869, 6, 'purchase', -20000, 83499999, 83479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4315', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(870, 6, 'purchase', -20000, 83479999, 83459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4316', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(871, 6, 'purchase', -20000, 83459999, 83439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4317', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(872, 6, 'purchase', -20000, 83439999, 83419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4318', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(873, 6, 'purchase', -20000, 83419999, 83399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4319', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(874, 6, 'purchase', -20000, 83399999, 83379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4320', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(875, 6, 'purchase', -20000, 83379999, 83359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4321', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(876, 6, 'purchase', -20000, 83359999, 83339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4322', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(877, 6, 'purchase', -20000, 83339999, 83319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4323', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(878, 6, 'purchase', -20000, 83319999, 83299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4324', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(879, 6, 'purchase', -20000, 83299999, 83279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4325', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(880, 6, 'purchase', -20000, 83279999, 83259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4326', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(881, 6, 'purchase', -20000, 83259999, 83239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4327', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(882, 6, 'purchase', -20000, 83239999, 83219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4328', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(883, 6, 'purchase', -20000, 83219999, 83199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4329', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(884, 6, 'purchase', -20000, 83199999, 83179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4330', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(885, 6, 'purchase', -20000, 83179999, 83159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4331', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(886, 6, 'purchase', -20000, 83159999, 83139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4332', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(887, 6, 'purchase', -20000, 83139999, 83119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4333', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(888, 6, 'purchase', -20000, 83119999, 83099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4334', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(889, 6, 'purchase', -20000, 83099999, 83079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4335', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(890, 6, 'purchase', -20000, 83079999, 83059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4336', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(891, 6, 'purchase', -20000, 83059999, 83039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4337', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(892, 6, 'purchase', -20000, 83039999, 83019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4338', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(893, 6, 'purchase', -20000, 83019999, 82999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4339', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(894, 6, 'purchase', -20000, 82999999, 82979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4340', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(895, 6, 'purchase', -20000, 82979999, 82959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4341', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(896, 6, 'purchase', -20000, 82959999, 82939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4342', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(897, 6, 'purchase', -20000, 82939999, 82919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4343', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(898, 6, 'purchase', -20000, 82919999, 82899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4344', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(899, 6, 'purchase', -20000, 82899999, 82879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4345', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(900, 6, 'purchase', -20000, 82879999, 82859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4346', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(901, 6, 'purchase', -20000, 82859999, 82839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4347', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(902, 6, 'purchase', -20000, 82839999, 82819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4348', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(903, 6, 'purchase', -20000, 82819999, 82799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4349', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(904, 6, 'purchase', -20000, 82799999, 82779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4350', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(905, 6, 'purchase', -20000, 82779999, 82759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4351', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(906, 6, 'purchase', -20000, 82759999, 82739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4352', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(907, 6, 'purchase', -20000, 82739999, 82719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4353', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(908, 6, 'purchase', -20000, 82719999, 82699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4354', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(909, 6, 'purchase', -20000, 82699999, 82679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4355', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(910, 6, 'purchase', -20000, 82679999, 82659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4356', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(911, 6, 'purchase', -20000, 82659999, 82639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4357', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(912, 6, 'purchase', -20000, 82639999, 82619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4358', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(913, 6, 'purchase', -20000, 82619999, 82599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4359', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(914, 6, 'purchase', -20000, 82599999, 82579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4360', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(915, 6, 'purchase', -20000, 82579999, 82559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4361', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(916, 6, 'purchase', -20000, 82559999, 82539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4362', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(917, 6, 'purchase', -20000, 82539999, 82519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4363', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(918, 6, 'purchase', -20000, 82519999, 82499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4364', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(919, 6, 'purchase', -20000, 82499999, 82479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4365', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(920, 6, 'purchase', -20000, 82479999, 82459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4366', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(921, 6, 'purchase', -20000, 82459999, 82439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4367', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(922, 6, 'purchase', -20000, 82439999, 82419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4368', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(923, 6, 'purchase', -20000, 82419999, 82399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4369', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(924, 6, 'purchase', -20000, 82399999, 82379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4370', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(925, 6, 'purchase', -20000, 82379999, 82359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4371', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(926, 6, 'purchase', -20000, 82359999, 82339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4372', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(927, 6, 'purchase', -20000, 82339999, 82319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4373', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(928, 6, 'purchase', -20000, 82319999, 82299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4374', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(929, 6, 'purchase', -20000, 82299999, 82279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4375', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(930, 6, 'purchase', -20000, 82279999, 82259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4376', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(931, 6, 'purchase', -20000, 82259999, 82239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4377', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(932, 6, 'purchase', -20000, 82239999, 82219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4378', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(933, 6, 'purchase', -20000, 82219999, 82199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4379', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(934, 6, 'purchase', -20000, 82199999, 82179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4380', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(935, 6, 'purchase', -20000, 82179999, 82159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4381', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(936, 6, 'purchase', -20000, 82159999, 82139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4382', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(937, 6, 'purchase', -20000, 82139999, 82119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4383', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(938, 6, 'purchase', -20000, 82119999, 82099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4384', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(939, 6, 'purchase', -20000, 82099999, 82079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4385', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(940, 6, 'purchase', -20000, 82079999, 82059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4386', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(941, 6, 'purchase', -20000, 82059999, 82039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4387', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(942, 6, 'purchase', -20000, 82039999, 82019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4388', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(943, 6, 'purchase', -20000, 82019999, 81999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4389', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(944, 6, 'purchase', -20000, 81999999, 81979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4390', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(945, 6, 'purchase', -20000, 81979999, 81959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4391', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(946, 6, 'purchase', -20000, 81959999, 81939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4392', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(947, 6, 'purchase', -20000, 81939999, 81919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4393', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(948, 6, 'purchase', -20000, 81919999, 81899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4394', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(949, 6, 'purchase', -20000, 81899999, 81879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4395', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(950, 6, 'purchase', -20000, 81879999, 81859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4396', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(951, 6, 'purchase', -20000, 81859999, 81839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4397', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(952, 6, 'purchase', -20000, 81839999, 81819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4398', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(953, 6, 'purchase', -20000, 81819999, 81799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4399', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(954, 6, 'purchase', -20000, 81799999, 81779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4400', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(955, 6, 'purchase', -20000, 81779999, 81759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4401', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(956, 6, 'purchase', -20000, 81759999, 81739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4402', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(957, 6, 'purchase', -20000, 81739999, 81719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4403', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(958, 6, 'purchase', -20000, 81719999, 81699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4404', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(959, 6, 'purchase', -20000, 81699999, 81679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4405', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(960, 6, 'purchase', -20000, 81679999, 81659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4406', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(961, 6, 'purchase', -20000, 81659999, 81639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4407', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(962, 6, 'purchase', -20000, 81639999, 81619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4408', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(963, 6, 'purchase', -20000, 81619999, 81599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4409', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(964, 6, 'purchase', -20000, 81599999, 81579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4410', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(965, 6, 'purchase', -20000, 81579999, 81559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4411', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(966, 6, 'purchase', -20000, 81559999, 81539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4412', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(967, 6, 'purchase', -20000, 81539999, 81519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4413', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(968, 6, 'purchase', -20000, 81519999, 81499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4414', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(969, 6, 'purchase', -20000, 81499999, 81479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4415', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(970, 6, 'purchase', -20000, 81479999, 81459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4416', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(971, 6, 'purchase', -20000, 81459999, 81439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4417', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(972, 6, 'purchase', -20000, 81439999, 81419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4418', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(973, 6, 'purchase', -20000, 81419999, 81399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4419', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(974, 6, 'purchase', -20000, 81399999, 81379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4420', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(975, 6, 'purchase', -20000, 81379999, 81359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4421', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(976, 6, 'purchase', -20000, 81359999, 81339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4422', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(977, 6, 'purchase', -20000, 81339999, 81319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4423', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(978, 6, 'purchase', -20000, 81319999, 81299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4424', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(979, 6, 'purchase', -20000, 81299999, 81279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4425', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(980, 6, 'purchase', -20000, 81279999, 81259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4426', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(981, 6, 'purchase', -20000, 81259999, 81239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4427', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(982, 6, 'purchase', -20000, 81239999, 81219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4428', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(983, 6, 'purchase', -20000, 81219999, 81199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4429', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(984, 6, 'purchase', -20000, 81199999, 81179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4430', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(985, 6, 'purchase', -20000, 81179999, 81159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4431', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(986, 6, 'purchase', -20000, 81159999, 81139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4432', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(987, 6, 'purchase', -20000, 81139999, 81119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4433', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(988, 6, 'purchase', -20000, 81119999, 81099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4434', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(989, 6, 'purchase', -20000, 81099999, 81079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4435', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(990, 6, 'purchase', -20000, 81079999, 81059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4436', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(991, 6, 'purchase', -20000, 81059999, 81039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4437', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(992, 6, 'purchase', -20000, 81039999, 81019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4438', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(993, 6, 'purchase', -20000, 81019999, 80999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4439', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(994, 6, 'purchase', -20000, 80999999, 80979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4440', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(995, 6, 'purchase', -20000, 80979999, 80959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4441', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(996, 6, 'purchase', -20000, 80959999, 80939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4442', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(997, 6, 'purchase', -20000, 80939999, 80919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4443', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(998, 6, 'purchase', -20000, 80919999, 80899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4444', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(999, 6, 'purchase', -20000, 80899999, 80879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4445', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1000, 6, 'purchase', -20000, 80879999, 80859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4446', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1001, 6, 'purchase', -20000, 80859999, 80839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4447', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1002, 6, 'purchase', -20000, 80839999, 80819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4448', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1003, 6, 'purchase', -20000, 80819999, 80799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4449', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1004, 6, 'purchase', -20000, 80799999, 80779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4450', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1005, 6, 'purchase', -20000, 80779999, 80759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4451', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1006, 6, 'purchase', -20000, 80759999, 80739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4452', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1007, 6, 'purchase', -20000, 80739999, 80719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4453', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1008, 6, 'purchase', -20000, 80719999, 80699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4454', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1009, 6, 'purchase', -20000, 80699999, 80679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4455', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1010, 6, 'purchase', -20000, 80679999, 80659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4456', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1011, 6, 'purchase', -20000, 80659999, 80639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4457', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1012, 6, 'purchase', -20000, 80639999, 80619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4458', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1013, 6, 'purchase', -20000, 80619999, 80599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4459', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1014, 6, 'purchase', -20000, 80599999, 80579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4460', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1015, 6, 'purchase', -20000, 80579999, 80559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4461', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1016, 6, 'purchase', -20000, 80559999, 80539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4462', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1017, 6, 'purchase', -20000, 80539999, 80519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4463', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1018, 6, 'purchase', -20000, 80519999, 80499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4464', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1019, 6, 'purchase', -20000, 80499999, 80479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4465', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1020, 6, 'purchase', -20000, 80479999, 80459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4466', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1021, 6, 'purchase', -20000, 80459999, 80439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4467', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1022, 6, 'purchase', -20000, 80439999, 80419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4468', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1023, 6, 'purchase', -20000, 80419999, 80399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4469', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1024, 6, 'purchase', -20000, 80399999, 80379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4470', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1025, 6, 'purchase', -20000, 80379999, 80359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4471', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1026, 6, 'purchase', -20000, 80359999, 80339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4472', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1027, 6, 'purchase', -20000, 80339999, 80319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4473', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1028, 6, 'purchase', -20000, 80319999, 80299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4474', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1029, 6, 'purchase', -20000, 80299999, 80279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4475', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1030, 6, 'purchase', -20000, 80279999, 80259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4476', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1031, 6, 'purchase', -20000, 80259999, 80239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4477', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1032, 6, 'purchase', -20000, 80239999, 80219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4478', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1033, 6, 'purchase', -20000, 80219999, 80199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4479', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1034, 6, 'purchase', -20000, 80199999, 80179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4480', '2026-08-20 06:04:35', '2026-08-20 06:04:35'),
(1035, 6, 'purchase', -20000, 80179999, 80159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4481', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1036, 6, 'purchase', -20000, 80159999, 80139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4482', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1037, 6, 'purchase', -20000, 80139999, 80119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4483', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1038, 6, 'purchase', -20000, 80119999, 80099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4484', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1039, 6, 'purchase', -20000, 80099999, 80079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4485', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1040, 6, 'purchase', -20000, 80079999, 80059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4486', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1041, 6, 'purchase', -20000, 80059999, 80039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4487', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1042, 6, 'purchase', -20000, 80039999, 80019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4488', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1043, 6, 'purchase', -20000, 80019999, 79999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4489', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1044, 6, 'purchase', -20000, 79999999, 79979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4490', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1045, 6, 'purchase', -20000, 79979999, 79959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4491', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1046, 6, 'purchase', -20000, 79959999, 79939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4492', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1047, 6, 'purchase', -20000, 79939999, 79919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4493', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1048, 6, 'purchase', -20000, 79919999, 79899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4494', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1049, 6, 'purchase', -20000, 79899999, 79879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4495', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1050, 6, 'purchase', -20000, 79879999, 79859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4496', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1051, 6, 'purchase', -20000, 79859999, 79839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4497', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1052, 6, 'purchase', -20000, 79839999, 79819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4498', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1053, 6, 'purchase', -20000, 79819999, 79799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4499', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1054, 6, 'purchase', -20000, 79799999, 79779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4500', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1055, 6, 'purchase', -20000, 79779999, 79759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4501', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1056, 6, 'purchase', -20000, 79759999, 79739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4502', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1057, 6, 'purchase', -20000, 79739999, 79719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4503', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1058, 6, 'purchase', -20000, 79719999, 79699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4504', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1059, 6, 'purchase', -20000, 79699999, 79679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4505', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1060, 6, 'purchase', -20000, 79679999, 79659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4506', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1061, 6, 'purchase', -20000, 79659999, 79639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4507', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1062, 6, 'purchase', -20000, 79639999, 79619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4508', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1063, 6, 'purchase', -20000, 79619999, 79599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4509', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1064, 6, 'purchase', -20000, 79599999, 79579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4510', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1065, 6, 'purchase', -20000, 79579999, 79559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4511', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1066, 6, 'purchase', -20000, 79559999, 79539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4512', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1067, 6, 'purchase', -20000, 79539999, 79519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4513', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1068, 6, 'purchase', -20000, 79519999, 79499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4514', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1069, 6, 'purchase', -20000, 79499999, 79479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4515', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1070, 6, 'purchase', -20000, 79479999, 79459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4516', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1071, 6, 'purchase', -20000, 79459999, 79439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4517', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1072, 6, 'purchase', -20000, 79439999, 79419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4518', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1073, 6, 'purchase', -20000, 79419999, 79399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4519', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1074, 6, 'purchase', -20000, 79399999, 79379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4520', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1075, 6, 'purchase', -20000, 79379999, 79359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4521', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1076, 6, 'purchase', -20000, 79359999, 79339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4522', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1077, 6, 'purchase', -20000, 79339999, 79319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4523', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1078, 6, 'purchase', -20000, 79319999, 79299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4524', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1079, 6, 'purchase', -20000, 79299999, 79279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4525', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1080, 6, 'purchase', -20000, 79279999, 79259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4526', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1081, 6, 'purchase', -20000, 79259999, 79239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4527', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1082, 6, 'purchase', -20000, 79239999, 79219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4528', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1083, 6, 'purchase', -20000, 79219999, 79199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4529', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1084, 6, 'purchase', -20000, 79199999, 79179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4530', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1085, 6, 'purchase', -20000, 79179999, 79159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4531', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1086, 6, 'purchase', -20000, 79159999, 79139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4532', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1087, 6, 'purchase', -20000, 79139999, 79119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4533', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1088, 6, 'purchase', -20000, 79119999, 79099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4534', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1089, 6, 'purchase', -20000, 79099999, 79079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4535', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1090, 6, 'purchase', -20000, 79079999, 79059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4536', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1091, 6, 'purchase', -20000, 79059999, 79039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4537', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1092, 6, 'purchase', -20000, 79039999, 79019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4538', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1093, 6, 'purchase', -20000, 79019999, 78999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4539', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1094, 6, 'purchase', -20000, 78999999, 78979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4540', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1095, 6, 'purchase', -20000, 78979999, 78959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4541', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1096, 6, 'purchase', -20000, 78959999, 78939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4542', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1097, 6, 'purchase', -20000, 78939999, 78919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4543', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1098, 6, 'purchase', -20000, 78919999, 78899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4544', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1099, 6, 'purchase', -20000, 78899999, 78879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4545', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1100, 6, 'purchase', -20000, 78879999, 78859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4546', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1101, 6, 'purchase', -20000, 78859999, 78839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4547', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1102, 6, 'purchase', -20000, 78839999, 78819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4548', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1103, 6, 'purchase', -20000, 78819999, 78799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4549', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1104, 6, 'purchase', -20000, 78799999, 78779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4550', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1105, 6, 'purchase', -20000, 78779999, 78759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4551', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1106, 6, 'purchase', -20000, 78759999, 78739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4552', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1107, 6, 'purchase', -20000, 78739999, 78719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4553', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1108, 6, 'purchase', -20000, 78719999, 78699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4554', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1109, 6, 'purchase', -20000, 78699999, 78679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4555', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1110, 6, 'purchase', -20000, 78679999, 78659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4556', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1111, 6, 'purchase', -20000, 78659999, 78639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4557', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1112, 6, 'purchase', -20000, 78639999, 78619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4558', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1113, 6, 'purchase', -20000, 78619999, 78599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4559', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1114, 6, 'purchase', -20000, 78599999, 78579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4560', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1115, 6, 'purchase', -20000, 78579999, 78559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4561', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1116, 6, 'purchase', -20000, 78559999, 78539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4562', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1117, 6, 'purchase', -20000, 78539999, 78519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4563', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1118, 6, 'purchase', -20000, 78519999, 78499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4564', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1119, 6, 'purchase', -20000, 78499999, 78479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4565', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1120, 6, 'purchase', -20000, 78479999, 78459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4566', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1121, 6, 'purchase', -20000, 78459999, 78439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4567', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1122, 6, 'purchase', -20000, 78439999, 78419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4568', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1123, 6, 'purchase', -20000, 78419999, 78399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4569', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1124, 6, 'purchase', -20000, 78399999, 78379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4570', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1125, 6, 'purchase', -20000, 78379999, 78359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4571', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1126, 6, 'purchase', -20000, 78359999, 78339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4572', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1127, 6, 'purchase', -20000, 78339999, 78319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4573', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1128, 6, 'purchase', -20000, 78319999, 78299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4574', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1129, 6, 'purchase', -20000, 78299999, 78279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4575', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1130, 6, 'purchase', -20000, 78279999, 78259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4576', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1131, 6, 'purchase', -20000, 78259999, 78239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4577', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1132, 6, 'purchase', -20000, 78239999, 78219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4578', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1133, 6, 'purchase', -20000, 78219999, 78199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4579', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1134, 6, 'purchase', -20000, 78199999, 78179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4580', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1135, 6, 'purchase', -20000, 78179999, 78159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4581', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1136, 6, 'purchase', -20000, 78159999, 78139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4582', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1137, 6, 'purchase', -20000, 78139999, 78119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4583', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1138, 6, 'purchase', -20000, 78119999, 78099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4584', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1139, 6, 'purchase', -20000, 78099999, 78079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4585', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1140, 6, 'purchase', -20000, 78079999, 78059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4586', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1141, 6, 'purchase', -20000, 78059999, 78039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4587', '2026-08-20 06:04:36', '2026-08-20 06:04:36');
INSERT INTO `money_transactions` (`id`, `user_id`, `type`, `amount`, `balance_before`, `balance_after`, `description`, `reference_id`, `created_at`, `updated_at`) VALUES
(1142, 6, 'purchase', -20000, 78039999, 78019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4588', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1143, 6, 'purchase', -20000, 78019999, 77999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4589', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1144, 6, 'purchase', -20000, 77999999, 77979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4590', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1145, 6, 'purchase', -20000, 77979999, 77959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4591', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1146, 6, 'purchase', -20000, 77959999, 77939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4592', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1147, 6, 'purchase', -20000, 77939999, 77919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4593', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1148, 6, 'purchase', -20000, 77919999, 77899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4594', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1149, 6, 'purchase', -20000, 77899999, 77879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4595', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1150, 6, 'purchase', -20000, 77879999, 77859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4596', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1151, 6, 'purchase', -20000, 77859999, 77839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4597', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1152, 6, 'purchase', -20000, 77839999, 77819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4598', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1153, 6, 'purchase', -20000, 77819999, 77799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4599', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1154, 6, 'purchase', -20000, 77799999, 77779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4600', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1155, 6, 'purchase', -20000, 77779999, 77759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4601', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1156, 6, 'purchase', -20000, 77759999, 77739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4602', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1157, 6, 'purchase', -20000, 77739999, 77719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4603', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1158, 6, 'purchase', -20000, 77719999, 77699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4604', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1159, 6, 'purchase', -20000, 77699999, 77679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4605', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1160, 6, 'purchase', -20000, 77679999, 77659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4606', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1161, 6, 'purchase', -20000, 77659999, 77639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4607', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1162, 6, 'purchase', -20000, 77639999, 77619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4608', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1163, 6, 'purchase', -20000, 77619999, 77599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4609', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1164, 6, 'purchase', -20000, 77599999, 77579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4610', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1165, 6, 'purchase', -20000, 77579999, 77559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4611', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1166, 6, 'purchase', -20000, 77559999, 77539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4612', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1167, 6, 'purchase', -20000, 77539999, 77519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4613', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1168, 6, 'purchase', -20000, 77519999, 77499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4614', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1169, 6, 'purchase', -20000, 77499999, 77479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4615', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1170, 6, 'purchase', -20000, 77479999, 77459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4616', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1171, 6, 'purchase', -20000, 77459999, 77439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4617', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1172, 6, 'purchase', -20000, 77439999, 77419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4618', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1173, 6, 'purchase', -20000, 77419999, 77399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4619', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1174, 6, 'purchase', -20000, 77399999, 77379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4620', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1175, 6, 'purchase', -20000, 77379999, 77359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4621', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1176, 6, 'purchase', -20000, 77359999, 77339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4622', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1177, 6, 'purchase', -20000, 77339999, 77319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4623', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1178, 6, 'purchase', -20000, 77319999, 77299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4624', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1179, 6, 'purchase', -20000, 77299999, 77279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4625', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1180, 6, 'purchase', -20000, 77279999, 77259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4626', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1181, 6, 'purchase', -20000, 77259999, 77239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4627', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1182, 6, 'purchase', -20000, 77239999, 77219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4628', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1183, 6, 'purchase', -20000, 77219999, 77199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4629', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1184, 6, 'purchase', -20000, 77199999, 77179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4630', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1185, 6, 'purchase', -20000, 77179999, 77159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4631', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1186, 6, 'purchase', -20000, 77159999, 77139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4632', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1187, 6, 'purchase', -20000, 77139999, 77119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4633', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1188, 6, 'purchase', -20000, 77119999, 77099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4634', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1189, 6, 'purchase', -20000, 77099999, 77079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4635', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1190, 6, 'purchase', -20000, 77079999, 77059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4636', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1191, 6, 'purchase', -20000, 77059999, 77039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4637', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1192, 6, 'purchase', -20000, 77039999, 77019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4638', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1193, 6, 'purchase', -20000, 77019999, 76999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4639', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1194, 6, 'purchase', -20000, 76999999, 76979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4640', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1195, 6, 'purchase', -20000, 76979999, 76959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4641', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1196, 6, 'purchase', -20000, 76959999, 76939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4642', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1197, 6, 'purchase', -20000, 76939999, 76919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4643', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1198, 6, 'purchase', -20000, 76919999, 76899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4644', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1199, 6, 'purchase', -20000, 76899999, 76879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4645', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1200, 6, 'purchase', -20000, 76879999, 76859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4646', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1201, 6, 'purchase', -20000, 76859999, 76839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4647', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1202, 6, 'purchase', -20000, 76839999, 76819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4648', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1203, 6, 'purchase', -20000, 76819999, 76799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4649', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1204, 6, 'purchase', -20000, 76799999, 76779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4650', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1205, 6, 'purchase', -20000, 76779999, 76759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4651', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1206, 6, 'purchase', -20000, 76759999, 76739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4652', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1207, 6, 'purchase', -20000, 76739999, 76719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4653', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1208, 6, 'purchase', -20000, 76719999, 76699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4654', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1209, 6, 'purchase', -20000, 76699999, 76679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4655', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1210, 6, 'purchase', -20000, 76679999, 76659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4656', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1211, 6, 'purchase', -20000, 76659999, 76639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4657', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1212, 6, 'purchase', -20000, 76639999, 76619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4658', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1213, 6, 'purchase', -20000, 76619999, 76599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4659', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1214, 6, 'purchase', -20000, 76599999, 76579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4660', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1215, 6, 'purchase', -20000, 76579999, 76559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4661', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1216, 6, 'purchase', -20000, 76559999, 76539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4662', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1217, 6, 'purchase', -20000, 76539999, 76519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4663', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1218, 6, 'purchase', -20000, 76519999, 76499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4664', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1219, 6, 'purchase', -20000, 76499999, 76479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4665', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1220, 6, 'purchase', -20000, 76479999, 76459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4666', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1221, 6, 'purchase', -20000, 76459999, 76439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4667', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1222, 6, 'purchase', -20000, 76439999, 76419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4668', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1223, 6, 'purchase', -20000, 76419999, 76399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4669', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1224, 6, 'purchase', -20000, 76399999, 76379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4670', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1225, 6, 'purchase', -20000, 76379999, 76359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4671', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1226, 6, 'purchase', -20000, 76359999, 76339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4672', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1227, 6, 'purchase', -20000, 76339999, 76319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4673', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1228, 6, 'purchase', -20000, 76319999, 76299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4674', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1229, 6, 'purchase', -20000, 76299999, 76279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4675', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1230, 6, 'purchase', -20000, 76279999, 76259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4676', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1231, 6, 'purchase', -20000, 76259999, 76239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4677', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1232, 6, 'purchase', -20000, 76239999, 76219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4678', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1233, 6, 'purchase', -20000, 76219999, 76199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4679', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1234, 6, 'purchase', -20000, 76199999, 76179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4680', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1235, 6, 'purchase', -20000, 76179999, 76159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4681', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1236, 6, 'purchase', -20000, 76159999, 76139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4682', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1237, 6, 'purchase', -20000, 76139999, 76119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4683', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1238, 6, 'purchase', -20000, 76119999, 76099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4684', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1239, 6, 'purchase', -20000, 76099999, 76079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4685', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1240, 6, 'purchase', -20000, 76079999, 76059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4686', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1241, 6, 'purchase', -20000, 76059999, 76039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4687', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1242, 6, 'purchase', -20000, 76039999, 76019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4688', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1243, 6, 'purchase', -20000, 76019999, 75999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4689', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1244, 6, 'purchase', -20000, 75999999, 75979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4690', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1245, 6, 'purchase', -20000, 75979999, 75959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4691', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1246, 6, 'purchase', -20000, 75959999, 75939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4692', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1247, 6, 'purchase', -20000, 75939999, 75919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4693', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1248, 6, 'purchase', -20000, 75919999, 75899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4694', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1249, 6, 'purchase', -20000, 75899999, 75879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4695', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1250, 6, 'purchase', -20000, 75879999, 75859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4696', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1251, 6, 'purchase', -20000, 75859999, 75839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4697', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1252, 6, 'purchase', -20000, 75839999, 75819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4698', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1253, 6, 'purchase', -20000, 75819999, 75799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4699', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1254, 6, 'purchase', -20000, 75799999, 75779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4700', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1255, 6, 'purchase', -20000, 75779999, 75759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4701', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1256, 6, 'purchase', -20000, 75759999, 75739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4702', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1257, 6, 'purchase', -20000, 75739999, 75719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4703', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1258, 6, 'purchase', -20000, 75719999, 75699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4704', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1259, 6, 'purchase', -20000, 75699999, 75679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4705', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1260, 6, 'purchase', -20000, 75679999, 75659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4706', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1261, 6, 'purchase', -20000, 75659999, 75639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4707', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1262, 6, 'purchase', -20000, 75639999, 75619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4708', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1263, 6, 'purchase', -20000, 75619999, 75599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4709', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1264, 6, 'purchase', -20000, 75599999, 75579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4710', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1265, 6, 'purchase', -20000, 75579999, 75559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4711', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1266, 6, 'purchase', -20000, 75559999, 75539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4712', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1267, 6, 'purchase', -20000, 75539999, 75519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4713', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1268, 6, 'purchase', -20000, 75519999, 75499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4714', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1269, 6, 'purchase', -20000, 75499999, 75479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4715', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1270, 6, 'purchase', -20000, 75479999, 75459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4716', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1271, 6, 'purchase', -20000, 75459999, 75439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4717', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1272, 6, 'purchase', -20000, 75439999, 75419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4718', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1273, 6, 'purchase', -20000, 75419999, 75399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4719', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1274, 6, 'purchase', -20000, 75399999, 75379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4720', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1275, 6, 'purchase', -20000, 75379999, 75359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4721', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1276, 6, 'purchase', -20000, 75359999, 75339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4722', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1277, 6, 'purchase', -20000, 75339999, 75319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4723', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1278, 6, 'purchase', -20000, 75319999, 75299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4724', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1279, 6, 'purchase', -20000, 75299999, 75279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4725', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1280, 6, 'purchase', -20000, 75279999, 75259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4726', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1281, 6, 'purchase', -20000, 75259999, 75239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4727', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1282, 6, 'purchase', -20000, 75239999, 75219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4728', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1283, 6, 'purchase', -20000, 75219999, 75199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4729', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1284, 6, 'purchase', -20000, 75199999, 75179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4730', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1285, 6, 'purchase', -20000, 75179999, 75159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4731', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1286, 6, 'purchase', -20000, 75159999, 75139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4732', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1287, 6, 'purchase', -20000, 75139999, 75119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4733', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1288, 6, 'purchase', -20000, 75119999, 75099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4734', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1289, 6, 'purchase', -20000, 75099999, 75079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4735', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1290, 6, 'purchase', -20000, 75079999, 75059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4736', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1291, 6, 'purchase', -20000, 75059999, 75039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4737', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1292, 6, 'purchase', -20000, 75039999, 75019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4738', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1293, 6, 'purchase', -20000, 75019999, 74999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4739', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1294, 6, 'purchase', -20000, 74999999, 74979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4740', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1295, 6, 'purchase', -20000, 74979999, 74959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4741', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1296, 6, 'purchase', -20000, 74959999, 74939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4742', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1297, 6, 'purchase', -20000, 74939999, 74919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4743', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1298, 6, 'purchase', -20000, 74919999, 74899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4744', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1299, 6, 'purchase', -20000, 74899999, 74879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4745', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1300, 6, 'purchase', -20000, 74879999, 74859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4746', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1301, 6, 'purchase', -20000, 74859999, 74839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4747', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1302, 6, 'purchase', -20000, 74839999, 74819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4748', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1303, 6, 'purchase', -20000, 74819999, 74799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4749', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1304, 6, 'purchase', -20000, 74799999, 74779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4750', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1305, 6, 'purchase', -20000, 74779999, 74759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4751', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1306, 6, 'purchase', -20000, 74759999, 74739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4752', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1307, 6, 'purchase', -20000, 74739999, 74719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4753', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1308, 6, 'purchase', -20000, 74719999, 74699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4754', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1309, 6, 'purchase', -20000, 74699999, 74679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4755', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1310, 6, 'purchase', -20000, 74679999, 74659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4756', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1311, 6, 'purchase', -20000, 74659999, 74639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4757', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1312, 6, 'purchase', -20000, 74639999, 74619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4758', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1313, 6, 'purchase', -20000, 74619999, 74599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4759', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1314, 6, 'purchase', -20000, 74599999, 74579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4760', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1315, 6, 'purchase', -20000, 74579999, 74559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4761', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1316, 6, 'purchase', -20000, 74559999, 74539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4762', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1317, 6, 'purchase', -20000, 74539999, 74519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4763', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1318, 6, 'purchase', -20000, 74519999, 74499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4764', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1319, 6, 'purchase', -20000, 74499999, 74479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4765', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1320, 6, 'purchase', -20000, 74479999, 74459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4766', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1321, 6, 'purchase', -20000, 74459999, 74439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4767', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1322, 6, 'purchase', -20000, 74439999, 74419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4768', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1323, 6, 'purchase', -20000, 74419999, 74399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4769', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1324, 6, 'purchase', -20000, 74399999, 74379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4770', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1325, 6, 'purchase', -20000, 74379999, 74359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4771', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1326, 6, 'purchase', -20000, 74359999, 74339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4772', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1327, 6, 'purchase', -20000, 74339999, 74319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4773', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1328, 6, 'purchase', -20000, 74319999, 74299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4774', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1329, 6, 'purchase', -20000, 74299999, 74279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4775', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1330, 6, 'purchase', -20000, 74279999, 74259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4776', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1331, 6, 'purchase', -20000, 74259999, 74239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4777', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1332, 6, 'purchase', -20000, 74239999, 74219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4778', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1333, 6, 'purchase', -20000, 74219999, 74199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4779', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1334, 6, 'purchase', -20000, 74199999, 74179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4780', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1335, 6, 'purchase', -20000, 74179999, 74159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4781', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1336, 6, 'purchase', -20000, 74159999, 74139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4782', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1337, 6, 'purchase', -20000, 74139999, 74119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4783', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1338, 6, 'purchase', -20000, 74119999, 74099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4784', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1339, 6, 'purchase', -20000, 74099999, 74079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4785', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1340, 6, 'purchase', -20000, 74079999, 74059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4786', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1341, 6, 'purchase', -20000, 74059999, 74039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4787', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1342, 6, 'purchase', -20000, 74039999, 74019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4788', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1343, 6, 'purchase', -20000, 74019999, 73999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4789', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1344, 6, 'purchase', -20000, 73999999, 73979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4790', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1345, 6, 'purchase', -20000, 73979999, 73959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4791', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1346, 6, 'purchase', -20000, 73959999, 73939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4792', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1347, 6, 'purchase', -20000, 73939999, 73919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4793', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1348, 6, 'purchase', -20000, 73919999, 73899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4794', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1349, 6, 'purchase', -20000, 73899999, 73879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4795', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1350, 6, 'purchase', -20000, 73879999, 73859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4796', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1351, 6, 'purchase', -20000, 73859999, 73839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4797', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1352, 6, 'purchase', -20000, 73839999, 73819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4798', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1353, 6, 'purchase', -20000, 73819999, 73799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4799', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1354, 6, 'purchase', -20000, 73799999, 73779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4800', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1355, 6, 'purchase', -20000, 73779999, 73759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4801', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1356, 6, 'purchase', -20000, 73759999, 73739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4802', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1357, 6, 'purchase', -20000, 73739999, 73719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4803', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1358, 6, 'purchase', -20000, 73719999, 73699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4804', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1359, 6, 'purchase', -20000, 73699999, 73679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4805', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1360, 6, 'purchase', -20000, 73679999, 73659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4806', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1361, 6, 'purchase', -20000, 73659999, 73639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4807', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1362, 6, 'purchase', -20000, 73639999, 73619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4808', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1363, 6, 'purchase', -20000, 73619999, 73599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4809', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1364, 6, 'purchase', -20000, 73599999, 73579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4810', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1365, 6, 'purchase', -20000, 73579999, 73559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4811', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1366, 6, 'purchase', -20000, 73559999, 73539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4812', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1367, 6, 'purchase', -20000, 73539999, 73519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4813', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1368, 6, 'purchase', -20000, 73519999, 73499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4814', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1369, 6, 'purchase', -20000, 73499999, 73479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4815', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1370, 6, 'purchase', -20000, 73479999, 73459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4816', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1371, 6, 'purchase', -20000, 73459999, 73439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4817', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1372, 6, 'purchase', -20000, 73439999, 73419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4818', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1373, 6, 'purchase', -20000, 73419999, 73399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4819', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1374, 6, 'purchase', -20000, 73399999, 73379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4820', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1375, 6, 'purchase', -20000, 73379999, 73359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4821', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1376, 6, 'purchase', -20000, 73359999, 73339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4822', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1377, 6, 'purchase', -20000, 73339999, 73319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4823', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1378, 6, 'purchase', -20000, 73319999, 73299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4824', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1379, 6, 'purchase', -20000, 73299999, 73279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4825', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1380, 6, 'purchase', -20000, 73279999, 73259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4826', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1381, 6, 'purchase', -20000, 73259999, 73239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4827', '2026-08-20 06:04:36', '2026-08-20 06:04:36'),
(1382, 6, 'purchase', -20000, 73239999, 73219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4828', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1383, 6, 'purchase', -20000, 73219999, 73199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4829', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1384, 6, 'purchase', -20000, 73199999, 73179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4830', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1385, 6, 'purchase', -20000, 73179999, 73159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4831', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1386, 6, 'purchase', -20000, 73159999, 73139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4832', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1387, 6, 'purchase', -20000, 73139999, 73119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4833', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1388, 6, 'purchase', -20000, 73119999, 73099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4834', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1389, 6, 'purchase', -20000, 73099999, 73079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4835', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1390, 6, 'purchase', -20000, 73079999, 73059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4836', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1391, 6, 'purchase', -20000, 73059999, 73039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4837', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1392, 6, 'purchase', -20000, 73039999, 73019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4838', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1393, 6, 'purchase', -20000, 73019999, 72999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4839', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1394, 6, 'purchase', -20000, 72999999, 72979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4840', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1395, 6, 'purchase', -20000, 72979999, 72959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4841', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1396, 6, 'purchase', -20000, 72959999, 72939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4842', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1397, 6, 'purchase', -20000, 72939999, 72919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4843', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1398, 6, 'purchase', -20000, 72919999, 72899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4844', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1399, 6, 'purchase', -20000, 72899999, 72879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4845', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1400, 6, 'purchase', -20000, 72879999, 72859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4846', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1401, 6, 'purchase', -20000, 72859999, 72839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4847', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1402, 6, 'purchase', -20000, 72839999, 72819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4848', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1403, 6, 'purchase', -20000, 72819999, 72799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4849', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1404, 6, 'purchase', -20000, 72799999, 72779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4850', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1405, 6, 'purchase', -20000, 72779999, 72759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4851', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1406, 6, 'purchase', -20000, 72759999, 72739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4852', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1407, 6, 'purchase', -20000, 72739999, 72719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4853', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1408, 6, 'purchase', -20000, 72719999, 72699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4854', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1409, 6, 'purchase', -20000, 72699999, 72679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4855', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1410, 6, 'purchase', -20000, 72679999, 72659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4856', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1411, 6, 'purchase', -20000, 72659999, 72639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4857', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1412, 6, 'purchase', -20000, 72639999, 72619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4858', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1413, 6, 'purchase', -20000, 72619999, 72599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4859', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1414, 6, 'purchase', -20000, 72599999, 72579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4860', '2026-08-20 06:04:37', '2026-08-20 06:04:37');
INSERT INTO `money_transactions` (`id`, `user_id`, `type`, `amount`, `balance_before`, `balance_after`, `description`, `reference_id`, `created_at`, `updated_at`) VALUES
(1415, 6, 'purchase', -20000, 72579999, 72559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4861', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1416, 6, 'purchase', -20000, 72559999, 72539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4862', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1417, 6, 'purchase', -20000, 72539999, 72519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4863', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1418, 6, 'purchase', -20000, 72519999, 72499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4864', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1419, 6, 'purchase', -20000, 72499999, 72479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4865', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1420, 6, 'purchase', -20000, 72479999, 72459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4866', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1421, 6, 'purchase', -20000, 72459999, 72439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4867', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1422, 6, 'purchase', -20000, 72439999, 72419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4868', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1423, 6, 'purchase', -20000, 72419999, 72399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4869', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1424, 6, 'purchase', -20000, 72399999, 72379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4870', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1425, 6, 'purchase', -20000, 72379999, 72359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4871', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1426, 6, 'purchase', -20000, 72359999, 72339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4872', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1427, 6, 'purchase', -20000, 72339999, 72319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4873', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1428, 6, 'purchase', -20000, 72319999, 72299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4874', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1429, 6, 'purchase', -20000, 72299999, 72279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4875', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1430, 6, 'purchase', -20000, 72279999, 72259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4876', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1431, 6, 'purchase', -20000, 72259999, 72239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4877', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1432, 6, 'purchase', -20000, 72239999, 72219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4878', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1433, 6, 'purchase', -20000, 72219999, 72199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4879', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1434, 6, 'purchase', -20000, 72199999, 72179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4880', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1435, 6, 'purchase', -20000, 72179999, 72159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4881', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1436, 6, 'purchase', -20000, 72159999, 72139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4882', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1437, 6, 'purchase', -20000, 72139999, 72119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4883', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1438, 6, 'purchase', -20000, 72119999, 72099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4884', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1439, 6, 'purchase', -20000, 72099999, 72079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4885', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1440, 6, 'purchase', -20000, 72079999, 72059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4886', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1441, 6, 'purchase', -20000, 72059999, 72039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4887', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1442, 6, 'purchase', -20000, 72039999, 72019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4888', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1443, 6, 'purchase', -20000, 72019999, 71999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4889', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1444, 6, 'purchase', -20000, 71999999, 71979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4890', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1445, 6, 'purchase', -20000, 71979999, 71959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4891', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1446, 6, 'purchase', -20000, 71959999, 71939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4892', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1447, 6, 'purchase', -20000, 71939999, 71919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4893', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1448, 6, 'purchase', -20000, 71919999, 71899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4894', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1449, 6, 'purchase', -20000, 71899999, 71879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4895', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1450, 6, 'purchase', -20000, 71879999, 71859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4896', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1451, 6, 'purchase', -20000, 71859999, 71839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4897', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1452, 6, 'purchase', -20000, 71839999, 71819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4898', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1453, 6, 'purchase', -20000, 71819999, 71799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4899', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1454, 6, 'purchase', -20000, 71799999, 71779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4900', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1455, 6, 'purchase', -20000, 71779999, 71759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4901', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1456, 6, 'purchase', -20000, 71759999, 71739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4902', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1457, 6, 'purchase', -20000, 71739999, 71719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4903', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1458, 6, 'purchase', -20000, 71719999, 71699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4904', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1459, 6, 'purchase', -20000, 71699999, 71679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4905', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1460, 6, 'purchase', -20000, 71679999, 71659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4906', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1461, 6, 'purchase', -20000, 71659999, 71639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4907', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1462, 6, 'purchase', -20000, 71639999, 71619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4908', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1463, 6, 'purchase', -20000, 71619999, 71599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4909', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1464, 6, 'purchase', -20000, 71599999, 71579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4910', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1465, 6, 'purchase', -20000, 71579999, 71559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4911', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1466, 6, 'purchase', -20000, 71559999, 71539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4912', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1467, 6, 'purchase', -20000, 71539999, 71519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4913', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1468, 6, 'purchase', -20000, 71519999, 71499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4914', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1469, 6, 'purchase', -20000, 71499999, 71479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4915', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1470, 6, 'purchase', -20000, 71479999, 71459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4916', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1471, 6, 'purchase', -20000, 71459999, 71439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4917', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1472, 6, 'purchase', -20000, 71439999, 71419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4918', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1473, 6, 'purchase', -20000, 71419999, 71399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4919', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1474, 6, 'purchase', -20000, 71399999, 71379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4920', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1475, 6, 'purchase', -20000, 71379999, 71359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4921', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1476, 6, 'purchase', -20000, 71359999, 71339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4922', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1477, 6, 'purchase', -20000, 71339999, 71319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4923', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1478, 6, 'purchase', -20000, 71319999, 71299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4924', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1479, 6, 'purchase', -20000, 71299999, 71279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4925', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1480, 6, 'purchase', -20000, 71279999, 71259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4926', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1481, 6, 'purchase', -20000, 71259999, 71239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4927', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1482, 6, 'purchase', -20000, 71239999, 71219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4928', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1483, 6, 'purchase', -20000, 71219999, 71199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4929', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1484, 6, 'purchase', -20000, 71199999, 71179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4930', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1485, 6, 'purchase', -20000, 71179999, 71159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4931', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1486, 6, 'purchase', -20000, 71159999, 71139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4932', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1487, 6, 'purchase', -20000, 71139999, 71119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4933', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1488, 6, 'purchase', -20000, 71119999, 71099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4934', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1489, 6, 'purchase', -20000, 71099999, 71079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4935', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1490, 6, 'purchase', -20000, 71079999, 71059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4936', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1491, 6, 'purchase', -20000, 71059999, 71039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4937', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1492, 6, 'purchase', -20000, 71039999, 71019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4938', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1493, 6, 'purchase', -20000, 71019999, 70999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4939', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1494, 6, 'purchase', -20000, 70999999, 70979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4940', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1495, 6, 'purchase', -20000, 70979999, 70959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4941', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1496, 6, 'purchase', -20000, 70959999, 70939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4942', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1497, 6, 'purchase', -20000, 70939999, 70919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4943', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1498, 6, 'purchase', -20000, 70919999, 70899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4944', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1499, 6, 'purchase', -20000, 70899999, 70879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4945', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1500, 6, 'purchase', -20000, 70879999, 70859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4946', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1501, 6, 'purchase', -20000, 70859999, 70839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4947', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1502, 6, 'purchase', -20000, 70839999, 70819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4948', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1503, 6, 'purchase', -20000, 70819999, 70799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4949', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1504, 6, 'purchase', -20000, 70799999, 70779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4950', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1505, 6, 'purchase', -20000, 70779999, 70759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4951', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1506, 6, 'purchase', -20000, 70759999, 70739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4952', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1507, 6, 'purchase', -20000, 70739999, 70719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4953', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1508, 6, 'purchase', -20000, 70719999, 70699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4954', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1509, 6, 'purchase', -20000, 70699999, 70679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4955', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1510, 6, 'purchase', -20000, 70679999, 70659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4956', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1511, 6, 'purchase', -20000, 70659999, 70639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4957', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1512, 6, 'purchase', -20000, 70639999, 70619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4958', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1513, 6, 'purchase', -20000, 70619999, 70599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4959', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1514, 6, 'purchase', -20000, 70599999, 70579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4960', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1515, 6, 'purchase', -20000, 70579999, 70559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4961', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1516, 6, 'purchase', -20000, 70559999, 70539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4962', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1517, 6, 'purchase', -20000, 70539999, 70519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4963', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1518, 6, 'purchase', -20000, 70519999, 70499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4964', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1519, 6, 'purchase', -20000, 70499999, 70479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4965', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1520, 6, 'purchase', -20000, 70479999, 70459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4966', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1521, 6, 'purchase', -20000, 70459999, 70439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4967', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1522, 6, 'purchase', -20000, 70439999, 70419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4968', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1523, 6, 'purchase', -20000, 70419999, 70399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4969', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1524, 6, 'purchase', -20000, 70399999, 70379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4970', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1525, 6, 'purchase', -20000, 70379999, 70359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4971', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1526, 6, 'purchase', -20000, 70359999, 70339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4972', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1527, 6, 'purchase', -20000, 70339999, 70319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4973', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1528, 6, 'purchase', -20000, 70319999, 70299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4974', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1529, 6, 'purchase', -20000, 70299999, 70279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4975', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1530, 6, 'purchase', -20000, 70279999, 70259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4976', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1531, 6, 'purchase', -20000, 70259999, 70239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4977', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1532, 6, 'purchase', -20000, 70239999, 70219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4978', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1533, 6, 'purchase', -20000, 70219999, 70199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4979', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1534, 6, 'purchase', -20000, 70199999, 70179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4980', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1535, 6, 'purchase', -20000, 70179999, 70159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4981', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1536, 6, 'purchase', -20000, 70159999, 70139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4982', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1537, 6, 'purchase', -20000, 70139999, 70119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4983', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1538, 6, 'purchase', -20000, 70119999, 70099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4984', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1539, 6, 'purchase', -20000, 70099999, 70079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4985', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1540, 6, 'purchase', -20000, 70079999, 70059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4986', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1541, 6, 'purchase', -20000, 70059999, 70039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4987', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1542, 6, 'purchase', -20000, 70039999, 70019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4988', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1543, 6, 'purchase', -20000, 70019999, 69999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4989', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1544, 6, 'purchase', -20000, 69999999, 69979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4990', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1545, 6, 'purchase', -20000, 69979999, 69959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4991', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1546, 6, 'purchase', -20000, 69959999, 69939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4992', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1547, 6, 'purchase', -20000, 69939999, 69919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4993', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1548, 6, 'purchase', -20000, 69919999, 69899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4994', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1549, 6, 'purchase', -20000, 69899999, 69879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4995', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1550, 6, 'purchase', -20000, 69879999, 69859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4996', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1551, 6, 'purchase', -20000, 69859999, 69839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4997', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1552, 6, 'purchase', -20000, 69839999, 69819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4998', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1553, 6, 'purchase', -20000, 69819999, 69799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-4999', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1554, 6, 'purchase', -20000, 69799999, 69779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5000', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1555, 6, 'purchase', -20000, 69779999, 69759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5001', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1556, 6, 'purchase', -20000, 69759999, 69739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5002', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1557, 6, 'purchase', -20000, 69739999, 69719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5003', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1558, 6, 'purchase', -20000, 69719999, 69699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5004', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1559, 6, 'purchase', -20000, 69699999, 69679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5005', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1560, 6, 'purchase', -20000, 69679999, 69659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5006', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1561, 6, 'purchase', -20000, 69659999, 69639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5007', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1562, 6, 'purchase', -20000, 69639999, 69619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5008', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1563, 6, 'purchase', -20000, 69619999, 69599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5009', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1564, 6, 'purchase', -20000, 69599999, 69579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5010', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1565, 6, 'purchase', -20000, 69579999, 69559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5011', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1566, 6, 'purchase', -20000, 69559999, 69539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5012', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1567, 6, 'purchase', -20000, 69539999, 69519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5013', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1568, 6, 'purchase', -20000, 69519999, 69499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5014', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1569, 6, 'purchase', -20000, 69499999, 69479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5015', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1570, 6, 'purchase', -20000, 69479999, 69459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5016', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1571, 6, 'purchase', -20000, 69459999, 69439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5017', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1572, 6, 'purchase', -20000, 69439999, 69419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5018', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1573, 6, 'purchase', -20000, 69419999, 69399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5019', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1574, 6, 'purchase', -20000, 69399999, 69379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5020', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1575, 6, 'purchase', -20000, 69379999, 69359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5021', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1576, 6, 'purchase', -20000, 69359999, 69339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5022', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1577, 6, 'purchase', -20000, 69339999, 69319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5023', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1578, 6, 'purchase', -20000, 69319999, 69299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5024', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1579, 6, 'purchase', -20000, 69299999, 69279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5025', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1580, 6, 'purchase', -20000, 69279999, 69259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5026', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1581, 6, 'purchase', -20000, 69259999, 69239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5027', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1582, 6, 'purchase', -20000, 69239999, 69219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5028', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1583, 6, 'purchase', -20000, 69219999, 69199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5029', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1584, 6, 'purchase', -20000, 69199999, 69179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5030', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1585, 6, 'purchase', -20000, 69179999, 69159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5031', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1586, 6, 'purchase', -20000, 69159999, 69139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5032', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1587, 6, 'purchase', -20000, 69139999, 69119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5033', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1588, 6, 'purchase', -20000, 69119999, 69099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5034', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1589, 6, 'purchase', -20000, 69099999, 69079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5035', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1590, 6, 'purchase', -20000, 69079999, 69059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5036', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1591, 6, 'purchase', -20000, 69059999, 69039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5037', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1592, 6, 'purchase', -20000, 69039999, 69019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5038', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1593, 6, 'purchase', -20000, 69019999, 68999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5039', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1594, 6, 'purchase', -20000, 68999999, 68979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5040', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1595, 6, 'purchase', -20000, 68979999, 68959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5041', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1596, 6, 'purchase', -20000, 68959999, 68939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5042', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1597, 6, 'purchase', -20000, 68939999, 68919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5043', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1598, 6, 'purchase', -20000, 68919999, 68899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5044', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1599, 6, 'purchase', -20000, 68899999, 68879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5045', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1600, 6, 'purchase', -20000, 68879999, 68859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5046', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1601, 6, 'purchase', -20000, 68859999, 68839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5047', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1602, 6, 'purchase', -20000, 68839999, 68819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5048', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1603, 6, 'purchase', -20000, 68819999, 68799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5049', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1604, 6, 'purchase', -20000, 68799999, 68779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5050', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1605, 6, 'purchase', -20000, 68779999, 68759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5051', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1606, 6, 'purchase', -20000, 68759999, 68739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5052', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1607, 6, 'purchase', -20000, 68739999, 68719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5053', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1608, 6, 'purchase', -20000, 68719999, 68699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5054', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1609, 6, 'purchase', -20000, 68699999, 68679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5055', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1610, 6, 'purchase', -20000, 68679999, 68659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5056', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1611, 6, 'purchase', -20000, 68659999, 68639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5057', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1612, 6, 'purchase', -20000, 68639999, 68619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5058', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1613, 6, 'purchase', -20000, 68619999, 68599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5059', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1614, 6, 'purchase', -20000, 68599999, 68579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5060', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1615, 6, 'purchase', -20000, 68579999, 68559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5061', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1616, 6, 'purchase', -20000, 68559999, 68539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5062', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1617, 6, 'purchase', -20000, 68539999, 68519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5063', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1618, 6, 'purchase', -20000, 68519999, 68499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5064', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1619, 6, 'purchase', -20000, 68499999, 68479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5065', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1620, 6, 'purchase', -20000, 68479999, 68459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5066', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1621, 6, 'purchase', -20000, 68459999, 68439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5067', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1622, 6, 'purchase', -20000, 68439999, 68419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5068', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1623, 6, 'purchase', -20000, 68419999, 68399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5069', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1624, 6, 'purchase', -20000, 68399999, 68379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5070', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1625, 6, 'purchase', -20000, 68379999, 68359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5071', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1626, 6, 'purchase', -20000, 68359999, 68339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5072', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1627, 6, 'purchase', -20000, 68339999, 68319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5073', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1628, 6, 'purchase', -20000, 68319999, 68299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5074', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1629, 6, 'purchase', -20000, 68299999, 68279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5075', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1630, 6, 'purchase', -20000, 68279999, 68259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5076', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1631, 6, 'purchase', -20000, 68259999, 68239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5077', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1632, 6, 'purchase', -20000, 68239999, 68219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5078', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1633, 6, 'purchase', -20000, 68219999, 68199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5079', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1634, 6, 'purchase', -20000, 68199999, 68179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5080', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1635, 6, 'purchase', -20000, 68179999, 68159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5081', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1636, 6, 'purchase', -20000, 68159999, 68139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5082', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1637, 6, 'purchase', -20000, 68139999, 68119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5083', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1638, 6, 'purchase', -20000, 68119999, 68099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5084', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1639, 6, 'purchase', -20000, 68099999, 68079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5085', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1640, 6, 'purchase', -20000, 68079999, 68059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5086', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1641, 6, 'purchase', -20000, 68059999, 68039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5087', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1642, 6, 'purchase', -20000, 68039999, 68019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5088', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1643, 6, 'purchase', -20000, 68019999, 67999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5089', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1644, 6, 'purchase', -20000, 67999999, 67979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5090', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1645, 6, 'purchase', -20000, 67979999, 67959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5091', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1646, 6, 'purchase', -20000, 67959999, 67939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5092', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1647, 6, 'purchase', -20000, 67939999, 67919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5093', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1648, 6, 'purchase', -20000, 67919999, 67899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5094', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1649, 6, 'purchase', -20000, 67899999, 67879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5095', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1650, 6, 'purchase', -20000, 67879999, 67859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5096', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1651, 6, 'purchase', -20000, 67859999, 67839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5097', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1652, 6, 'purchase', -20000, 67839999, 67819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5098', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1653, 6, 'purchase', -20000, 67819999, 67799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5099', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1654, 6, 'purchase', -20000, 67799999, 67779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5100', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1655, 6, 'purchase', -20000, 67779999, 67759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5101', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1656, 6, 'purchase', -20000, 67759999, 67739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5102', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1657, 6, 'purchase', -20000, 67739999, 67719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5103', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1658, 6, 'purchase', -20000, 67719999, 67699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5104', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1659, 6, 'purchase', -20000, 67699999, 67679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5105', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1660, 6, 'purchase', -20000, 67679999, 67659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5106', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1661, 6, 'purchase', -20000, 67659999, 67639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5107', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1662, 6, 'purchase', -20000, 67639999, 67619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5108', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1663, 6, 'purchase', -20000, 67619999, 67599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5109', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1664, 6, 'purchase', -20000, 67599999, 67579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5110', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1665, 6, 'purchase', -20000, 67579999, 67559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5111', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1666, 6, 'purchase', -20000, 67559999, 67539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5112', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1667, 6, 'purchase', -20000, 67539999, 67519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5113', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1668, 6, 'purchase', -20000, 67519999, 67499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5114', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1669, 6, 'purchase', -20000, 67499999, 67479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5115', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1670, 6, 'purchase', -20000, 67479999, 67459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5116', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1671, 6, 'purchase', -20000, 67459999, 67439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5117', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1672, 6, 'purchase', -20000, 67439999, 67419999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5118', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1673, 6, 'purchase', -20000, 67419999, 67399999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5119', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1674, 6, 'purchase', -20000, 67399999, 67379999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5120', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1675, 6, 'purchase', -20000, 67379999, 67359999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5121', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1676, 6, 'purchase', -20000, 67359999, 67339999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5122', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1677, 6, 'purchase', -20000, 67339999, 67319999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5123', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1678, 6, 'purchase', -20000, 67319999, 67299999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5124', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1679, 6, 'purchase', -20000, 67299999, 67279999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5125', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1680, 6, 'purchase', -20000, 67279999, 67259999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5126', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1681, 6, 'purchase', -20000, 67259999, 67239999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5127', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1682, 6, 'purchase', -20000, 67239999, 67219999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5128', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1683, 6, 'purchase', -20000, 67219999, 67199999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5129', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1684, 6, 'purchase', -20000, 67199999, 67179999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5130', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1685, 6, 'purchase', -20000, 67179999, 67159999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5131', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1686, 6, 'purchase', -20000, 67159999, 67139999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5132', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1687, 6, 'purchase', -20000, 67139999, 67119999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5133', '2026-08-20 06:04:37', '2026-08-20 06:04:37');
INSERT INTO `money_transactions` (`id`, `user_id`, `type`, `amount`, `balance_before`, `balance_after`, `description`, `reference_id`, `created_at`, `updated_at`) VALUES
(1688, 6, 'purchase', -20000, 67119999, 67099999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5134', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1689, 6, 'purchase', -20000, 67099999, 67079999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5135', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1690, 6, 'purchase', -20000, 67079999, 67059999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5136', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1691, 6, 'purchase', -20000, 67059999, 67039999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5137', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1692, 6, 'purchase', -20000, 67039999, 67019999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5138', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1693, 6, 'purchase', -20000, 67019999, 66999999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5139', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1694, 6, 'purchase', -20000, 66999999, 66979999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5140', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1695, 6, 'purchase', -20000, 66979999, 66959999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5141', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1696, 6, 'purchase', -20000, 66959999, 66939999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5142', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1697, 6, 'purchase', -20000, 66939999, 66919999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5143', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1698, 6, 'purchase', -20000, 66919999, 66899999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5144', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1699, 6, 'purchase', -20000, 66899999, 66879999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5145', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1700, 6, 'purchase', -20000, 66879999, 66859999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5146', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1701, 6, 'purchase', -20000, 66859999, 66839999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5147', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1702, 6, 'purchase', -20000, 66839999, 66819999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5148', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1703, 6, 'purchase', -20000, 66819999, 66799999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5149', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1704, 6, 'purchase', -20000, 66799999, 66779999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5150', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1705, 6, 'purchase', -20000, 66779999, 66759999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5151', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1706, 6, 'purchase', -20000, 66759999, 66739999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5152', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1707, 6, 'purchase', -20000, 66739999, 66719999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5153', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1708, 6, 'purchase', -20000, 66719999, 66699999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5154', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1709, 6, 'purchase', -20000, 66699999, 66679999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5155', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1710, 6, 'purchase', -20000, 66679999, 66659999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5156', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1711, 6, 'purchase', -20000, 66659999, 66639999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5157', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1712, 6, 'purchase', -20000, 66639999, 66619999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5158', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1713, 6, 'purchase', -20000, 66619999, 66599999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5159', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1714, 6, 'purchase', -20000, 66599999, 66579999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5160', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1715, 6, 'purchase', -20000, 66579999, 66559999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5161', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1716, 6, 'purchase', -20000, 66559999, 66539999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5162', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1717, 6, 'purchase', -20000, 66539999, 66519999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5163', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1718, 6, 'purchase', -20000, 66519999, 66499999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5164', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1719, 6, 'purchase', -20000, 66499999, 66479999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5165', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1720, 6, 'purchase', -20000, 66479999, 66459999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5166', '2026-08-20 06:04:37', '2026-08-20 06:04:37'),
(1721, 6, 'purchase', -20000, 66459999, 66439999, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a8698f150ffd)', 'RA-5167', '2026-08-20 06:04:37', '2026-08-20 06:04:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `money_withdrawal_histories`
--

CREATE TABLE `money_withdrawal_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` bigint(20) NOT NULL,
  `user_note` text DEFAULT NULL,
  `admin_note` text DEFAULT NULL,
  `status` enum('processing','success','error') NOT NULL DEFAULT 'processing',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `thumbnail`, `description`, `content`, `views`, `active`, `created_at`, `updated_at`) VALUES
(1, 'new', 'new', '/storage/uploads/news/1782038720_ef0874ddbfb2bd2ab0561c14397002c7.png', 'e6t4567547', '75675678', 12, 1, '2026-06-21 10:45:20', '2026-07-07 15:08:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_favicon` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `class_favicon`, `content`, `created_at`, `updated_at`) VALUES
(2, 'fa-fas fa-upload', 'Vui lòng đọc kĩ thông báo trước khi mua để tránh những sai lầm không mong muốn nhé', '2026-06-22 10:25:59', '2026-08-20 07:07:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('vodinhkiet130@gmail.com', '$2y$12$MK4Nofl27pdLH1iWHsSwbeCNMBr8tC.YmC/gnUUngFnzccyZQlGgK', '2026-08-20 06:52:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `purchase_history`
--

CREATE TABLE `purchase_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `game_account_id` bigint(20) UNSIGNED NOT NULL,
  `amount` bigint(20) NOT NULL,
  `account_details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `random_categories`
--

CREATE TABLE `random_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `tag_image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Giá mặc định của danh mục',
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `game_group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_flash_sale` tinyint(1) NOT NULL DEFAULT 0,
  `flash_sale_old_price` int(11) DEFAULT NULL,
  `flash_sale_new_price` int(11) DEFAULT NULL,
  `flash_sale_end_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `random_categories`
--

INSERT INTO `random_categories` (`id`, `name`, `slug`, `platform`, `thumbnail`, `tag_image`, `description`, `price`, `active`, `created_at`, `updated_at`, `game_group_id`, `is_flash_sale`, `flash_sale_old_price`, `flash_sale_new_price`, `flash_sale_end_time`) VALUES
(1, 'ACC RAMDUM 20K', 'acc-ramdum-20k', 'Liên Quân', '/storage/random-categories/1781970561_86cba7abfcbb137bb811d21169b95521.jpg', '/storage/random-categories/1782031394_4f628121d15a22b14bf2fcf3366ab6f5.png', 'RAMDUM', 20000.00, 1, '2026-06-20 15:49:21', '2026-06-22 17:13:14', 1, 0, 20000, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `random_category_accounts`
--

CREATE TABLE `random_category_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `random_category_id` bigint(20) UNSIGNED NOT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `price` bigint(20) NOT NULL,
  `status` enum('available','sold') NOT NULL DEFAULT 'available',
  `server` int(11) NOT NULL,
  `buyer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `batch_id` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `note_buyer` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `random_category_accounts`
--

INSERT INTO `random_category_accounts` (`id`, `random_category_id`, `account_name`, `password`, `price`, `status`, `server`, `buyer_id`, `batch_id`, `note`, `note_buyer`, `thumbnail`, `created_at`, `updated_at`) VALUES
(3490, 1, '61585778573693', 'TongTanAnh2222', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3491, 1, '61585777344533', 'KhuatQuanBao52', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3492, 1, '61585881085644', 'MaiMyHuy4892', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3493, 1, '61585709731181', 'MaiVyPhuc49', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3494, 1, '61585414573760', 'PhamMinhHuy85', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3495, 1, '61585586104233', 'VuMinhSon70', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3496, 1, '61585723530262', 'HoangChiThien4105', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3497, 1, '61585394172481', 'HoTamAn0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3498, 1, '61585811784748', 'DinhMinhThien29794', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3499, 1, '61585502678516', 'ToUyenYen42632', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3500, 1, '61585860081321', 'NguyenPhuPhuc0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3501, 1, '61585596272927', 'ToKienHan4054', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3502, 1, '61585822012594', 'LyQuanNgoc38565', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3503, 1, '61585706730201', 'PhungUyenAn19236', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3504, 1, '61585428373402', 'VoXuanAn5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3505, 1, '61585580044716', 'LyVySon144', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3506, 1, '61585517346124', 'DuongDuyen7475', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3507, 1, '61585391712442', 'VoLinhPhuc73', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3508, 1, '61585563994623', 'VuMaiPhu5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3509, 1, '61585764297931', 'AuVanThao62331', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3510, 1, '61585845593368', 'LyMyQuan31', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3511, 1, '61585472858504', 'KhuatTruongNgan8422', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3512, 1, '61585834042816', 'DoKyNgan702', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3513, 1, '61585503520285', 'DoNamThao1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3514, 1, '61585510927399', 'QuachLanVan9978', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3515, 1, '61585424383431', 'LaLongNgoc1164', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3516, 1, '61585507327147', 'DoanAnhKhoa7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3517, 1, '61585414153895', 'MacTrungAn1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3518, 1, '61585602515084', 'MaiVanPhu83270', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3519, 1, '61585787155881', 'QuachTriQuan1897', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3520, 1, '61585692117656', 'LyVanAn945', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3521, 1, '61585762105096', 'HoVanKhanh78', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3522, 1, '61585458431768', 'DinhHuuVan603', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3523, 1, '61585466889786', 'AuQuanVan6292', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3524, 1, '61585602752585', 'DangThienKhoa7314', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3525, 1, '61585388292806', 'ChauXuanThinh670', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3526, 1, '61585726675898', 'DauYenNgan36699', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3527, 1, '61585612562046', 'MaiTriDuy44460', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3528, 1, '61585466112670', 'MaiTriVan84059', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3529, 1, '61585804439384', 'HoangLinhDuy65', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3530, 1, '61585391202279', 'DoanThanhDuy29', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3531, 1, '61585625643945', 'TranMyThao1085', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3532, 1, '61585643613192', 'LyKhoiThinh77684', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3533, 1, '61585644000302', 'TranThinh98', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3534, 1, '61585370953148', 'PhamKienBao415', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3535, 1, '61585534175209', 'DuongVanKhoa66', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3536, 1, '61585665002108', 'CaoLuuVan9840', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3537, 1, '61585462839687', 'LyPhuDuy37', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3538, 1, '61585710148022', 'VoDinhMinh120', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3539, 1, '61585404222868', 'AuDinhVinh226', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3540, 1, '61585600593431', 'DoKyNgan85124', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3541, 1, '61585700518501', 'DuongThaiTri203', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3542, 1, '61585380013778', 'TrinhThanhLong92378', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3543, 1, '61585736188618', 'TongVanYen55016', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3544, 1, '61585839353765', 'ToLuuKhoa6369', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3545, 1, '61585416523772', 'LyQuocNgoc9365', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3546, 1, '61585569366684', 'NgoPhucNam3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3547, 1, '61585701447277', 'DangLuuAnh8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3548, 1, '61585604286388', 'TranMinhPhu8604', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3549, 1, '61585833325284', 'MaiQuanTri56', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3550, 1, '61585697848746', 'TrinhMaiAn2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3551, 1, '61585660379508', 'HuynhLeLinh510', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3552, 1, '61585863622385', 'QuachMyPhu85', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3553, 1, '61585440586761', 'PhungTruongVan200', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3554, 1, '61585730612937', 'VoLeUyen412', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3555, 1, '61585841004717', 'LyXuanKhoa66', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3556, 1, '61585858374129', 'TranHienQuan3312', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3557, 1, '61585560274592', 'PhanYenTri4100', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3558, 1, '61585858882558', 'ChauTrungHuy41311', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3559, 1, '61585800089408', 'DuongVyAn2022', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3560, 1, '61585654230696', 'TranPhuMinh185', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3561, 1, '61585666919533', 'HoangHoangPhuc2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3562, 1, '61585422883629', 'KhuatLienKhanh93', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3563, 1, '61585397682591', 'MaiPhatThien75', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3564, 1, '61585464825314', 'DauNganAn31001', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3565, 1, '61585441152682', 'PhungPhuongNgoc176', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3566, 1, '61585679009610', 'ChauDuyThai85', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3567, 1, '61585467640706', 'BuiThanhNgan1810', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3568, 1, '61585662450454', 'LeTriThinh9869', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3569, 1, '61585422223488', 'QuachAnhThu796', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3570, 1, '61585474718402', 'CaoLeBao9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3571, 1, '61585866892366', 'BuiUyenVy0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3572, 1, '61585443970249', 'TranQuocThinh75939', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3573, 1, '61585863680152', 'VuYenPhuc3251', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3574, 1, '61585447903466', 'QuachThinhUyen15', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3575, 1, '61585768194655', 'QuachTriPhat7252', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3576, 1, '61585805695095', 'TaNamTri16', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3577, 1, '61585711437587', 'DauMinhDuy76192', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3578, 1, '61585524339708', 'TongLeNam758', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3579, 1, '61585489240474', 'DangKhanh1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3580, 1, '61585482672061', 'HoangDiemPhuong940', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3581, 1, '61585484981608', 'KhuatAnhDung2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3582, 1, '61585633953593', 'DoanTruongTri45917', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3583, 1, '61585549359097', 'VoYenPhuc4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3584, 1, '61585377643891', 'QuachTanNgan73700', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3585, 1, '61585464608606', 'TrinhHienMinh23', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3586, 1, '61585657710375', 'VuKyPhat3483', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3587, 1, '61585882431369', 'DauHuuPhu9107', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3588, 1, '61585488880216', 'PhanVanTri2691', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3589, 1, '61585615232115', 'NgoCongTri757', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3590, 1, '61585465992485', 'MaiKienThanh54', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3591, 1, '61585468362528', 'DoanTrungThinh303', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3592, 1, '61585390752485', 'DuongTanHuy15', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3593, 1, '61585862423593', 'TranHuuVan444', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3594, 1, '61585759827286', 'MacMyMinh61', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3595, 1, '61585714200717', 'ToPhuongAn50', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3596, 1, '61585404461941', 'VuTanLong29', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3597, 1, '61585447120127', 'PhanLuuThanh653', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3598, 1, '61585626005311', 'AuGiaQuan18', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3599, 1, '61585677838467', 'DoKimHuy15797', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3600, 1, '61585615384644', 'QuachHoangBao487', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3601, 1, '61585633774839', 'PhanLePhu660', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3602, 1, '61585459751370', 'PhanThinhNam1652', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3603, 1, '61585611335813', 'VuPhuongThao8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3604, 1, '61585360906909', 'KhuatLienNgoc1888', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3605, 1, '61585420781534', 'PhanTrungNgoc746', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3606, 1, '61585606084948', 'TranThaoPhu52', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3607, 1, '61585749384697', 'DinhLongAnh5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3608, 1, '61585568767007', 'ToThaiThanh57', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3609, 1, '61585837494899', 'CaoQuang8123', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3610, 1, '61585701208856', 'HoangSonAn432', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3611, 1, '61585671359248', 'DuongKimHuy3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3612, 1, '61585465182930', 'HaKhanhDuy1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3613, 1, '61585799335127', 'ToQuocKhanh9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3614, 1, '61585718010187', 'DoVyNgan84', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3615, 1, '61585409771610', 'DangDuyViet99', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3616, 1, '61585783195986', 'HuynhThanhDuy6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3617, 1, '61585726379873', 'LaNgocPhu2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3618, 1, '61585661579860', 'DauKhanhLong6369', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3619, 1, '61585380915978', 'HoangThaoLong6282', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3620, 1, '61585675412769', 'MaiThaoMy8724', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3621, 1, '61585798343389', 'AuQuyen1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3622, 1, '61585558538475', 'PhamMinhKhanh30037', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3623, 1, '61585574524797', 'HoangThaoLinh36484', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3624, 1, '61585531236478', 'DuongTanHan89', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3625, 1, '61585369574557', 'TaTamSon29', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3626, 1, '61585649826942', 'TranThinhHan28399', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3627, 1, '61585730936922', 'CaoSonPhuc2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3628, 1, '61585598586537', 'DoKienLinh37', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3629, 1, '61585960371802', 'TaHaQuan4124', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3630, 1, '61585723436250', 'LeDiemHan21', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3631, 1, '61585715788326', 'HaVinhPhuc10', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3632, 1, '61585453779393', 'HoangSonBao91', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3633, 1, '61585732533017', 'PhanAnhMinh1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3634, 1, '61585559795968', 'PhamQuocKhoa5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3635, 1, '61585551513200', 'DinhLanHan303', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3636, 1, '61585737989202', 'MacHaThien94', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3637, 1, '61585360603982', 'MaiTruongPhat32075', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3638, 1, '61585868062309', 'LyLeThien0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3639, 1, '61585902051994', 'NguyenKienThao42015', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3640, 1, '61585565524770', 'DuongHaLinh6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3641, 1, '61585741377171', 'ChauPhuPhuc90', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3642, 1, '61585607463481', 'DoHaKhanh45', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3643, 1, '61585721580102', 'TrinhVanMinh753', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3644, 1, '61585558745767', 'NguyenLuuAnh61', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3645, 1, '61585393725044', 'QuachMyLinh4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3646, 1, '61585501210858', 'QuachQuocLinh2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3647, 1, '61585595915853', 'KhuatTriPhat112', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3648, 1, '61585787215437', 'VuThanhPhat157', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3649, 1, '61585749836071', 'KhuatNgocUyen172', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3650, 1, '61585722027342', 'MaiHuuSon8702', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3651, 1, '61585845471382', 'DoLienNgoc9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3652, 1, '61585713299377', 'TaVanKhanh16425', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3653, 1, '61585393782536', 'AuLeSon529', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3654, 1, '61585714497873', 'AuVanHuy47766', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3655, 1, '61585881022813', 'CaoHaLinh63', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3656, 1, '61585492449856', 'PhungDiemHan91', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3657, 1, '61585722327117', 'PhanHung723', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3658, 1, '61585386466777', 'LyGiaThuan3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3659, 1, '61585759854296', 'MacKienHan50', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3660, 1, '61585592825919', 'DinhDuyThanh8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3661, 1, '61585493437989', 'DoUyenMinh51', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3662, 1, '61585804735077', 'VuVan3581', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3663, 1, '61585871030352', 'ToBinhAn111', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3664, 1, '61585763158336', 'ToNhatThao146', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3665, 1, '61585349027276', 'HuynhNam197', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3666, 1, '61585792464031', 'TranNgan902', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3667, 1, '61585407165655', 'HaNganAn80715', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3668, 1, '61585434400854', 'TongVanPhat98075', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3669, 1, '61585358175521', 'ToVanThanh5779', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3670, 1, '61585482578735', 'AuTanTri12363', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3671, 1, '61585655043760', 'HaHoangThien44', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3672, 1, '61585835873984', 'TrinhThaiAn401', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3673, 1, '61585584035334', 'TranPhatPhu6085', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3674, 1, '61585498059876', 'TranNgocQuan3722', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3675, 1, '61585686718602', 'HoangVanAn37', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3676, 1, '61585599305264', 'VuKhanhAnh236', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3677, 1, '61585543301839', 'MaiKyNgoc16', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3678, 1, '61585551662387', 'HuynhQuocKhoa5092', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3679, 1, '61585722837429', 'KhuatNgocMy8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3680, 1, '61585543448828', 'NgoTriLong5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3681, 1, '61585700009623', 'LePhatNgan6564', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3682, 1, '61585665989239', 'TonNhatKhoa1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3683, 1, '61585782266083', 'VuHoangPhuc45850', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3684, 1, '61585609262005', 'PhanUyenTri2992', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3685, 1, '61585571974662', 'LeLeUyen509', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3686, 1, '61585361926741', 'NguyenYenMinh481', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3687, 1, '61585459659082', 'HoangXuanMinh5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3688, 1, '61585680808852', 'AuNhatMy7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3689, 1, '61585864283922', 'CaoLongNgoc9618', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3690, 1, '61585445709732', 'ChauKyLinh6360', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3691, 1, '61585792463790', 'DuongQuocAn783', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3692, 1, '61585592734272', 'DangTanQuan1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3693, 1, '61585561928491', 'TongTriThien3440', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3694, 1, '61585443942463', 'NgoMinh74', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3695, 1, '61585726677242', 'DoTruongKhoa8406', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3696, 1, '61585836263709', 'LyThaoAnh72285', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3697, 1, '61585472621249', 'HuynhTrungThanh97', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3698, 1, '61585847180653', 'DoanTamHan6621', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3699, 1, '61585822101788', 'ToKhoiVan27', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3700, 1, '61585551813510', 'MacQuanKhanh86645', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3701, 1, '61585870671888', 'TonAnhDung941', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3702, 1, '61585358836246', 'QuachTrungLinh137', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3703, 1, '61585370386549', 'HoNamDuy34', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3704, 1, '61585473490922', 'AuHaHuy647', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3705, 1, '61585633411315', 'VuThinhPhat93924', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3706, 1, '61585798012490', 'DoHanh9067', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3707, 1, '61585669143119', 'ToMaiPhat169', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3708, 1, '61585663470533', 'TongKimPhuc316', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3709, 1, '61585750135035', 'QuachPhuThien494', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3710, 1, '61585797653011', 'NgoTriPhu7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3711, 1, '61585342457636', 'DinhTriBao447', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3712, 1, '61585852970392', 'MaiVanDuy427', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3713, 1, '61585722176501', 'DauKhanhBao91267', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3714, 1, '61585575123775', 'TrinhTanYen62132', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3715, 1, '61585349144679', 'HoangTrungHuy835', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3716, 1, '61585638481501', 'HaKienVy38', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3717, 1, '61585513326303', 'TaVanMy8141', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3718, 1, '61585428610644', 'AuHoangUyen7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3719, 1, '61585449912192', 'DinhNganDuy55578', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3720, 1, '61585774586338', 'LeVyTri8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3721, 1, '61585421981780', 'HoNganHuy5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3722, 1, '61585855732815', 'HoangThienThao2041', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3723, 1, '61585865780491', 'DoanYenThien46', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3724, 1, '61585629633873', 'QuachHaNgoc243', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3725, 1, '61585670106027', 'DinhThaiAnh872', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3726, 1, '61585667969481', 'TranXuanVy5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3727, 1, '61585860832462', 'QuachSonLong7627', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3728, 1, '61585677330045', 'TongKyBao91', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3729, 1, '61585544529022', 'HoangPhatDuy4577', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3730, 1, '61585568827977', 'LaMinhPhu55498', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3731, 1, '61585688458243', 'DauLanHan915', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3732, 1, '61585913450095', 'TaVinhNam34984', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3733, 1, '61585749268911', 'LyLongBao7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3734, 1, '61585642594499', 'DuongKimHan16963', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3735, 1, '61585457832064', 'KhuatVinhBao33379', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3736, 1, '61585428463481', 'QuachTrungPhu7781', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3737, 1, '61585345787387', 'LyMaiBao0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3738, 1, '61585734598277', 'DoMaiThao7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3739, 1, '61585756734467', 'PhungKhanhUyen27', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3740, 1, '61585380613265', 'VuThinhMinh4844', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3741, 1, '61585496947753', 'TaTrungThao492', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3742, 1, '61585797745507', 'DauVanUyen29497', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3743, 1, '61585758774933', 'LaMai5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3744, 1, '61585848323211', 'VuMyPhuc71', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3745, 1, '61585707957980', 'QuachDiemPhuong144', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3746, 1, '61585418651477', 'HaLeSon47', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3747, 1, '61585717707534', 'BuiUyenKhanh48036', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3748, 1, '61585462361469', 'DangTrungVy34996', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3749, 1, '61585355175620', 'TrinhMinhNgan74', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3750, 1, '61585867853351', 'LyKimMinh7982', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3751, 1, '61585530875611', 'DauThanhPhuc74', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3752, 1, '61585853420325', 'PhungVanThao88531', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3753, 1, '61585412414299', 'QuachLinh605', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3754, 1, '61585851562101', 'LeKhoiQuan33849', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3755, 1, '61585520078696', 'CaoThaiPhat847', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3756, 1, '61585954252105', 'TrinhUyenThanh62679', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3757, 1, '61585831854068', 'LaPhuNam47', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3758, 1, '61585598259517', 'QuachTamTri547', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3759, 1, '61585530335972', 'NgoThaiAnh15', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3760, 1, '61585577766238', 'TranHaiNgoc21316', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3761, 1, '61585441060136', 'HoangLinhBao20144', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3762, 1, '61585641870256', 'MaiLinhBao219', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3763, 1, '61585566634848', 'HuynhHaiUyen204', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3764, 1, '61585360573903', 'KhuatVinhNgoc922', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3765, 1, '61585757097457', 'PhanTruongNgoc99', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3766, 1, '61585664791811', 'KhuatKimThinh78883', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3767, 1, '61585444662570', 'DoanHaPhu216', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3768, 1, '61585755894706', 'KhuatNgocKhoa55', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3769, 1, '61585818054435', 'ToVinhBao3341', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3770, 1, '61585776265294', 'TonLongThinh63439', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3771, 1, '61585649970401', 'DangTruongSon75', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3772, 1, '61585617692391', 'PhanMySon60320', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3773, 1, '61585789042854', 'PhanMyThao5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3774, 1, '61585452969514', 'ToUyenVy12', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3775, 1, '61585765494459', 'DauKyVy545', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3776, 1, '61585356554049', 'DinhTamPhu88', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3777, 1, '61585793874298', 'LePhatKhanh186', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3778, 1, '61585441307133', 'ChauDuyTrung34', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3779, 1, '61585385804193', 'MacThaoMy76', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3780, 1, '61585553737382', 'NguyenBinhYen461', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3781, 1, '61585371707361', 'QuachKyKhanh536', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3782, 1, '61585725688002', 'TrinhTanPhat64605', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3783, 1, '61585756168727', 'PhanTamThanh103', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3784, 1, '61585348697448', 'HaVinhUyen314', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3785, 1, '61585500133807', 'PhamLinhKhoa46', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3786, 1, '61585478137835', 'VoTamThanh3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3787, 1, '61585716749001', 'TonQuanMinh73', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3788, 1, '61585659573351', 'KhuatNgocThien57695', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3789, 1, '61585747825520', 'VoLinhThien57325', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3790, 1, '61585373773523', 'MacTrungKhoa0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3791, 1, '61585896200599', 'HoangVinhThien62', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3792, 1, '61585842351268', 'BuiPhuongThien202', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3793, 1, '61585792526785', 'PhungQuocQuan957', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3794, 1, '61585650662474', 'DuongLuuThanh9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3795, 1, '61585829035250', 'DuongThaiPhu83', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3796, 1, '61585503967963', 'TranMaiThinh23416', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3797, 1, '61585863022513', 'VoTuan29', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3798, 1, '61585626031366', 'PhungVanMy252', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3799, 1, '61585813673378', 'TrinhLongYen752', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3800, 1, '61585355207203', 'MacYenMy298', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3801, 1, '61585897370698', 'PhanThuan98', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3802, 1, '61585525625787', 'VoPhuongYen3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3803, 1, '61585794325516', 'PhanLongHan34812', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3804, 1, '61585728718743', 'LaTrungThao1048', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3805, 1, '61585721547304', 'DoLanThien663', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3806, 1, '61585378603532', 'DoanLinhKhanh57581', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3807, 1, '61585679251208', 'HuynhThuy39', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3808, 1, '61585431191883', 'HoMySon3170', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3809, 1, '61585416645269', 'NguyenBich47987', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3810, 1, '61585614602413', 'QuachVanMy10666', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3811, 1, '61585719477481', 'KhuatPhuongQuan82046', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3812, 1, '61585787513472', 'ToPhuongLong77', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3813, 1, '61585771525122', 'DauVinhKhanh982', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3814, 1, '61585634490714', 'KhuatNganPhu476', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3815, 1, '61585856392674', 'PhamTamMinh21', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3816, 1, '61585471961964', 'LyVanThien6370', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3817, 1, '61585839500699', 'MaiHoangNgoc681', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3818, 1, '61585416372750', 'TongTruongVan5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3819, 1, '61585754065299', 'AuQuocVan43311', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02');
INSERT INTO `random_category_accounts` (`id`, `random_category_id`, `account_name`, `password`, `price`, `status`, `server`, `buyer_id`, `batch_id`, `note`, `note_buyer`, `thumbnail`, `created_at`, `updated_at`) VALUES
(3820, 1, '61585648231520', 'HoangVanThien17', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3821, 1, '61585683808764', 'DinhGiaLinh94675', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3822, 1, '61585714557960', 'DoKyBao98', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3823, 1, '61585902260710', 'PhungLeThanh46', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3824, 1, '61585522418348', 'DauBaoNgoc41927', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3825, 1, '61585463468677', 'KhuatDiemHang78862', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3826, 1, '61585369633540', 'HuynhTriPhu4876', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3827, 1, '61585434073627', 'CaoTruongNgoc983', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3828, 1, '61585438809638', 'ChauLanTri80186', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3829, 1, '61585799722524', 'AuCongLy57428', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3830, 1, '61585752447604', 'HoangPhucAnh5358', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3831, 1, '61585713356845', 'QuachPhucLinh85642', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3832, 1, '61585785510210', 'DangYenAnh7375', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3833, 1, '61585550854825', 'HaHienKhoa30', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3834, 1, '61585859752533', 'QuachDuyMinh13677', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3835, 1, '61585735527382', 'PhamQuocNgoc99153', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3836, 1, '61585404401957', 'CaoKhanhYen4407', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3837, 1, '61585394352977', 'DuongHaiUyen7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3838, 1, '61585437466922', 'ToLeDuy961', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3839, 1, '61585607944744', 'DinhSonDuy8221', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3840, 1, '61585360007719', 'DangHienKhanh55', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3841, 1, '61585355264472', 'HuynhLong34423', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3842, 1, '61585801073384', 'DoTruongDuy789', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3843, 1, '61585611244784', 'QuachHaiPhu99', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3844, 1, '61585751485995', 'NguyenVanAn456', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3845, 1, '61585797595248', 'TrinhNgocTri453', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3846, 1, '61585437160812', 'LeHoangNgoc3497', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3847, 1, '61585627561163', 'MacLienKhoa334', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3848, 1, '61585653872339', 'DauNamThinh99871', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3849, 1, '61585671151643', 'DinhHuuSon8515', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3850, 1, '61585443159442', 'PhungHaiVy591', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3851, 1, '61585651112810', 'MacHaThai586', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3852, 1, '61585550194580', 'PhungMinhHuy4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3853, 1, '61585450841776', 'TrinhPhuThien0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3854, 1, '61585497127599', 'MaiUyenYen76', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3855, 1, '61585696534742', 'VoNganLong9879', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3856, 1, '61585664731759', 'BuiXuanVan1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3857, 1, '61585482310784', 'MaiThienPhuc19738', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3858, 1, '61585509188638', 'DoanYenSon8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3859, 1, '61585406113140', 'MacMaiPhu1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3860, 1, '61585688638141', 'DauNamMinh81287', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3861, 1, '61585593726626', 'DauCongTri609', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3862, 1, '61585646492837', 'HuynhYenXuan3551', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3863, 1, '61585491670277', 'PhanMyBao10', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3864, 1, '61585560905261', 'PhungTamAn8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3865, 1, '61585844783403', 'VoKyThanh44798', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3866, 1, '61585780707363', 'HuynhSonHuy93013', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3867, 1, '61585741225430', 'HuynhNganPhat139', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3868, 1, '61585885762437', 'MaiGiaLong80', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3869, 1, '61585617095531', 'LyMaiSon8201', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3870, 1, '61585340806477', 'TonTruongNgoc2738', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3871, 1, '61585802395415', 'AuVanThien36', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3872, 1, '61585882611524', 'TrinhKhanhPhuc28', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3873, 1, '61585742756996', 'TranQuanVy876', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3874, 1, '61585387062484', 'LyHuuUyen6774', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3875, 1, '61585870670044', 'PhamLinhThien5047', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3876, 1, '61585562854430', 'LeLeLinh1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3877, 1, '61585686959218', 'LaDuyKhoi9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3878, 1, '61585592886519', 'KhuatViet11', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3879, 1, '61585790157075', 'LeTanMinh14392', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3880, 1, '61585357276843', 'MacVinhNam940', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3881, 1, '61585711769547', 'TrinhChiTrung76825', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3882, 1, '61585772156383', 'NguyenKyAn80', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3883, 1, '61585471358730', 'LyPhuongPhu2424', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3884, 1, '61585476667663', 'DoThanhVy7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3885, 1, '61585716867641', 'LaThanhVan90', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3886, 1, '61585737057156', 'AuKyNgoc9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3887, 1, '61585837581342', 'TranThinhTri5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3888, 1, '61585842022636', 'HoangQuocKhoa24', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3889, 1, '61585846370925', 'BuiThaoVy164', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3890, 1, '61585466918840', 'QuachThienDuy78', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3891, 1, '61585723288228', 'VuKhoiPhu4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3892, 1, '61585661159405', 'VoThinhTri47774', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3893, 1, '61585716960609', 'LyNamLong39', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3894, 1, '61585514556913', 'ChauPhuongHuy83810', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3895, 1, '61585533938164', 'ToBaoYen5943', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3896, 1, '61585772186500', 'VuSonKhoa28', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3897, 1, '61585681952147', 'AuThanhLong41751', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3898, 1, '61585667279069', 'NguyenNhatNgan99733', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3899, 1, '61585716146878', 'DangLanAnh6897', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3900, 1, '61585800923733', 'TonLeThinh25', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3901, 1, '61585712188026', 'MacHienQuan1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3902, 1, '61585770987015', 'VuLongThinh3969', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3903, 1, '61585803772263', 'DauUyenTri9143', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3904, 1, '61585542005959', 'DauPhucThao132', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3905, 1, '61585700487512', 'PhungTanLong6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3906, 1, '61585405662508', 'DoXuanNam45798', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3907, 1, '61585443643201', 'HoYenLinh74', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3908, 1, '61585495479844', 'DoTamThanh11', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3909, 1, '61585606563207', 'QuachLongVy5018', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3910, 1, '61585369725710', 'PhungPhuc5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3911, 1, '61585501207689', 'LaXuanHuy3048', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3912, 1, '61585519988836', 'NgoKienBao636', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3913, 1, '61585554577773', 'LeKyThao48154', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3914, 1, '61585373536017', 'CaoVyMy166', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3915, 1, '61585538497654', 'ChauPhuongSon1259', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3916, 1, '61585555115471', 'TonHoangQuan46924', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3917, 1, '61585778785489', 'TonKyPhat4153', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3918, 1, '61585724490328', 'HoangGiaVi49057', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3919, 1, '61585350077654', 'HuynhLanThanh7809', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3920, 1, '61585521756772', 'QuachChiThanh27917', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3921, 1, '61585840013740', 'DangVinhHan1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3922, 1, '61585587727219', 'TranVinhThao69', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3923, 1, '61585996100010', 'NgoHienThinh96', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3924, 1, '61585699768578', 'LaYenKhoa0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3925, 1, '61585677481130', 'LyThinhNam22', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3926, 1, '61585570266936', 'DuongQuocThanh968', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3927, 1, '61585733936954', 'DoanHaiHan36504', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3928, 1, '61585465989062', 'BuiHienThanh0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3929, 1, '61585492449999', 'DinhNgocThien7902', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3930, 1, '61585447299815', 'CaoLongYen87159', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3931, 1, '61585830144306', 'HoNhatNgan680', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3932, 1, '61585814693554', 'HaHoangDuy9602', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3933, 1, '61585380195654', 'DuongQuocLong96', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3934, 1, '61585440703783', 'PhanKyLong706', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3935, 1, '61585558537320', 'NgoDuyThinh136', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3936, 1, '61585478468507', 'HaNhatAn40616', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3937, 1, '61585687499214', 'LeAn52332', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3938, 1, '61585472171802', 'NguyenThaiHuy0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3939, 1, '61585830145437', 'HoKienHuy812', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3940, 1, '61585485367634', 'ToMyBao40833', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3941, 1, '61585499529619', 'LyHoangKhoa74', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3942, 1, '61585890800170', 'DangDuyHung3351', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3943, 1, '61585861160009', 'PhamLien372', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3944, 1, '61585911020054', 'DuongTruongUyen7855', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3945, 1, '61585645862542', 'LaThienUyen73', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3946, 1, '61585504987012', 'BuiLinhBao4745', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3947, 1, '61585732437562', 'ToDiemChau19495', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3948, 1, '61585688518805', 'HuynhLeHan19', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3949, 1, '61585643463236', 'PhanNganLinh505', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3950, 1, '61585365733967', 'TranPhuongSon2878', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3951, 1, '61585358507158', 'DoanTruongBao8948', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3952, 1, '61585521998666', 'NguyenLeAnh0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3953, 1, '61585797982544', 'DuongDinhLong63415', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3954, 1, '61585875861891', 'MaiChiDung4508', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3955, 1, '61585732382927', 'BuiDat9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3956, 1, '61585526499910', 'TranNganThinh18', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3957, 1, '61585864552632', 'HoTruongDuy71090', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3958, 1, '61585720886888', 'AuVanYen929', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3959, 1, '61585704656971', 'LyNamHan6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3960, 1, '61585519178956', 'PhanKhanhHan56954', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3961, 1, '61585585686091', 'TranDuyBao5286', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3962, 1, '61585580553711', 'HoNgocThien141', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3963, 1, '61585389013559', 'VuLienNam0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3964, 1, '61585664129603', 'NgoDinhThang1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3965, 1, '61585423817592', 'BuiTanYen67', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3966, 1, '61585769874626', 'CaoLanDuy5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3967, 1, '61585823908474', 'DoanMaiThien8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3968, 1, '61585471119993', 'QuachLienLong41081', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3969, 1, '61585899321798', 'LeHaHan84481', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3970, 1, '61585840370895', 'ToTamPhu3376', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3971, 1, '61585820488714', 'LyKhoiPhat152', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3972, 1, '61585917980728', 'DauHoangThien95148', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3973, 1, '61585510418929', 'TonMaiTri2627', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3974, 1, '61585730816354', 'CaoMy529', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3975, 1, '61585798193117', 'DoanKhoiThao5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3976, 1, '61585510088158', 'QuachMinhBao65648', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3977, 1, '61585426480493', 'PhanPhucQuan3192', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3978, 1, '61585861910622', 'BuiMinhDuy2065', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3979, 1, '61585671931527', 'DangLuuVan94361', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3980, 1, '61585909404401', 'LeHoangLinh95006', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3981, 1, '61585728416097', 'PhamKyBao11', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3982, 1, '61585448773053', 'ToTanLinh50456', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3983, 1, '61585499586830', 'NgoThienYen70', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3984, 1, '61585868300411', 'DangThienLong50', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3985, 1, '61585423481968', 'VoHuong62', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3986, 1, '61585783013633', 'TranHaiMinh0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3987, 1, '61585632421858', 'DoanQuanMinh69', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3988, 1, '61585489540063', 'LyKhoiKhanh90660', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3989, 1, '61585358594749', 'DuongKimThien0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3990, 1, '61585748847593', 'TaTamThinh2775', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3991, 1, '61585844510843', 'NguyenKimPhat2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3992, 1, '61585427922992', 'TongYenDuy4646', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3993, 1, '61585339127944', 'DoanVinhSon8377', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3994, 1, '61585390994111', 'HaKienQuan959', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3995, 1, '61585666803254', 'HoNhatBao66', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3996, 1, '61585417963907', 'TranPhatBao419', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3997, 1, '61585663410387', 'DoNhatTri730', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3998, 1, '61585453962063', 'NguyenKhanhLinh9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3999, 1, '61585842203589', 'PhamHuuKhanh25069', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4000, 1, '61585752025351', 'QuachCongHieu9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4001, 1, '61585476040119', 'NgoPhuongQuan1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4002, 1, '61585935353035', 'KhuatTrinh729', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4003, 1, '61585696170526', 'PhanCongMinh29233', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4004, 1, '61585738826004', 'TonPhuLong3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4005, 1, '61585361597846', 'TonPhucSon399', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4006, 1, '61585856151351', 'BuiKienThao0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4007, 1, '61585834161848', 'DinhThienDuy30', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4008, 1, '61585582445984', 'PhungKimSon79738', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4009, 1, '61585726078906', 'TongDuyPhu186', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4010, 1, '61585776203361', 'TonMyMinh29', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4011, 1, '61585795764186', 'MaiHoangKhanh8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4012, 1, '61585453270151', 'PhanLongNam9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4013, 1, '61585439290390', 'DinhMyNgan29', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4014, 1, '61585662902289', 'LaLien2488', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4015, 1, '61585730638874', 'LyXuanThanh36', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4016, 1, '61585829001963', 'PhamPhucThanh13', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4017, 1, '61585839593840', 'AuLinhThinh38', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4018, 1, '61585831315499', 'DuongPhuongAnh80', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4019, 1, '61585784606079', 'HoangHienVan266', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4020, 1, '61585638120850', 'BuiKhanhQuan91918', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4021, 1, '61585431971706', 'VoNganBao8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4022, 1, '61585605336204', 'DinhNganThanh5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4023, 1, '61585776204456', 'TrinhTruongMy189', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4024, 1, '61585865213362', 'NguyenTruongThanh35', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4025, 1, '61585793243387', 'TranHaHan9596', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4026, 1, '61585756711431', 'HaTruongTri1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4027, 1, '61585914170737', 'AuTriQuan943', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4028, 1, '61585670698740', 'QuachBaoYen977', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4029, 1, '61585663922039', 'PhamGiaYen5951', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4030, 1, '61585388175345', 'TrinhKyThanh50345', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4031, 1, '61585386612630', 'TrinhKimUyen61', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4032, 1, '61585692628713', 'VuSonNgan8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4033, 1, '61585449883207', 'PhamVanUyen97514', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4034, 1, '61585811782806', 'KhuatPhuongQuan8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4035, 1, '61585421503803', 'LaLanPhat9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4036, 1, '61585391142205', 'HaKienLinh94', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4037, 1, '61585742396220', 'PhanTruongNgoc54', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4038, 1, '61585670639093', 'BuiThanh83711', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4039, 1, '61585604913406', 'HoKhanhNgan64052', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4040, 1, '61585382025696', 'DoPhuNgoc903', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4041, 1, '61585501778575', 'BuiTruongUyen67050', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4042, 1, '61585568197060', 'NgoVinhHan19758', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4043, 1, '61585525299888', 'DauVyDuy68511', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4044, 1, '61585773897478', 'PhanLanMy86', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4045, 1, '61585844240501', 'PhanHaiLong58', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4046, 1, '61585525116376', 'CaoThienKhanh10097', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4047, 1, '61585771464165', 'MaiHienAn551', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4048, 1, '61585722837543', 'TongChiDung8150', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4049, 1, '61585475620729', 'TongHaiPhu30078', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4050, 1, '61585682969441', 'PhamLuuNam397', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4051, 1, '61585565916895', 'HaGiang1066', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4052, 1, '61585405002600', 'PhungPhuongMy9073', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4053, 1, '61585585717412', 'DauNganThanh16831', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4054, 1, '61585808931929', 'DoVanAn98', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4055, 1, '61585850695217', 'PhanNganAn28', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4056, 1, '61585774705751', 'HaVanNgoc9924', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4057, 1, '61585338647894', 'QuachLongPhuc575', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4058, 1, '61585676729231', 'LaHaThinh96', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4059, 1, '61585584034274', 'DangChiTai706', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4060, 1, '61585906911490', 'ToThienSon7874', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4061, 1, '61585620278205', 'MacHaAn7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4062, 1, '61585649912930', 'DangPhatKhanh66', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4063, 1, '61585384216946', 'VuThienSon3662', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4064, 1, '61585627532247', 'MacVyThinh97497', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4065, 1, '61585382476665', 'DinhPhuKhoa5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4066, 1, '61585409862633', 'BuiNgocThanh12', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4067, 1, '61585500096956', 'DoGiaHuy1120', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4068, 1, '61585466142299', 'BuiTamAnh57', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4069, 1, '61585755715720', 'PhanKienVy92', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4070, 1, '61585413282650', 'CaoThienNam610', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4071, 1, '61585771915672', 'DauQuocHuy96', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4072, 1, '61585564148321', 'PhungNamNgan93841', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4073, 1, '61585784033205', 'TonThaoSon854', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4074, 1, '61585599303243', 'QuachDuyQuang8431', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4075, 1, '61585577284913', 'VuKhoiLinh2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4076, 1, '61585591623496', 'TongTrungNgan7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4077, 1, '61585758837283', 'PhamNhatDuy10', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4078, 1, '61585860206827', 'HuynhNamNgan526', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4079, 1, '61585684739263', 'DoanPhuongVy799', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4080, 1, '61585402633259', 'TranVinhPhu8668', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4081, 1, '61585722266123', 'HoVyPhat7873', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4082, 1, '61585795164126', 'DangYen82', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4083, 1, '61585730577660', 'DuongThienHuy3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4084, 1, '61585479495029', 'KhuatPhucBao57', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4085, 1, '61585781636312', 'QuachVanAn90418', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4086, 1, '61585451711818', 'TonSonKhanh55', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4087, 1, '61585367774848', 'DangThinhYen13', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4088, 1, '61585672532073', 'TaKimKhanh1149', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4089, 1, '61585553705649', 'TrinhThienHan82', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4090, 1, '61585642380636', 'VoHaKhang9984', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4091, 1, '61585471448200', 'ChauDiemHang3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4092, 1, '61585376086499', 'VuPhuongSon299', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4093, 1, '61585338736485', 'ToTuan8149', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4094, 1, '61585343445746', 'DoKyThanh64', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4095, 1, '61585604492186', 'QuachHaiHan21', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4096, 1, '61585433652958', 'DangNgocLinh3668', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4097, 1, '61585721759107', 'DangLoan2257', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4098, 1, '61585882431701', 'MacXuanThanh9563', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4099, 1, '61585717766294', 'DinhNamMy4607', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4100, 1, '61585737118445', 'TranUyenVy8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4101, 1, '61585834198235', 'BuiDinhKhang1128', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4102, 1, '61585449970709', 'MaiTruongThien11325', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4103, 1, '61585756915346', 'MacMaiPhat7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4104, 1, '61585700758376', 'TonKienHuy65', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4105, 1, '61585585862944', 'PhamVanTri6010', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4106, 1, '61585856272794', 'DinhTruc921', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4107, 1, '61585647962947', 'HuynhQuanHuy713', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4108, 1, '61585577974189', 'TaKhanhYen0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4109, 1, '61585370983521', 'NguyenLanHuy213', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4110, 1, '61585446639825', 'MaiThaoTri37083', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4111, 1, '61585370624188', 'LaLien11666', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4112, 1, '61585722926645', 'HoangPhucKhanh3222', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4113, 1, '61585791745723', 'DangHoangHuy35850', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4114, 1, '61585516985888', 'DuongVanNgan6735', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4115, 1, '61585573026373', 'DinhPhuMy84885', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4116, 1, '61585396425363', 'LaThaiThanh67', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4117, 1, '61585390123304', 'DoDaThu93', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4118, 1, '61585817842824', 'NgoVanKhoa9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4119, 1, '61585668659397', 'TranLeVy5405', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4120, 1, '61585910390370', 'HuynhTriSon21133', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4121, 1, '61585500759978', 'HoThinhKhoa875', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4122, 1, '61585353104302', 'PhungDuySon41', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4123, 1, '61585741796396', 'LyChiBao4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4124, 1, '61585417691236', 'DoXuanQuan22', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4125, 1, '61585618595086', 'TranPhucPhat599', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4126, 1, '61585610074734', 'PhamVinhQuan1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4127, 1, '61585574074608', 'DinhNganThanh71975', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4128, 1, '61585437941393', 'CaoVyNgoc74', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4129, 1, '61585625585326', 'LaLienKhanh8390', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4130, 1, '61585412231335', 'LePhuongBao61', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4131, 1, '61585756284720', 'VuLeDuy7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4132, 1, '61585430500803', 'CaoPhucPhu2731', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4133, 1, '61585510686256', 'KhuatNhatBao52463', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4134, 1, '61585563635224', 'PhungPhucQuan8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4135, 1, '61585700428169', 'AuKimAnh717', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4136, 1, '61585460561895', 'TranKhanhVy42', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4137, 1, '61585753017942', 'DoanNgocBao183', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4138, 1, '61585597235544', 'MacChau401', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4139, 1, '61585773594909', 'TonTamPhuc10260', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4140, 1, '61585780494280', 'AuHuuNam9513', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4141, 1, '61585612952810', 'QuachThaoVy23', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4142, 1, '61585446672241', 'PhanMinhAn953', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4143, 1, '61585575634474', 'ChauHaiThinh4325', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4144, 1, '61585505857768', 'TongHienVan9031', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4145, 1, '61585631852727', 'NgoPhatBao85341', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4146, 1, '61585628671178', 'PhungDuyKhang94992', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4147, 1, '61585922750833', 'KhuatYenSon10237', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4148, 1, '61585832573121', 'ChauQuocHan6253', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4149, 1, '61585881295608', 'TongMaiAnh93272', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03');
INSERT INTO `random_category_accounts` (`id`, `random_category_id`, `account_name`, `password`, `price`, `status`, `server`, `buyer_id`, `batch_id`, `note`, `note_buyer`, `thumbnail`, `created_at`, `updated_at`) VALUES
(4150, 1, '61585849644342', 'TongQuanPhat424', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4151, 1, '61585446282520', 'AuLeQuan790', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4152, 1, '61585889211081', 'HaHaAn16465', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4153, 1, '61585652613879', 'LaHaHuy36', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4154, 1, '61585563005830', 'DinhLienNgan4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4155, 1, '61585721876843', 'DauQuanKhanh344', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4156, 1, '61585800085369', 'HuynhTrungVy987', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4157, 1, '61585466349438', 'TrinhHienNgan6784', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4158, 1, '61585621591437', 'TaPhuongPhu764', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4159, 1, '61585454861857', 'LaKhoiHuy897', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4160, 1, '61585811512925', 'TonKyHan863', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4161, 1, '61585415893691', 'LyPhucKhoa438', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4162, 1, '61585434793120', 'DangLienBao31225', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4163, 1, '61585632061842', 'HaHienPhat29331', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4164, 1, '61585414783898', 'ChauLinhVy3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4165, 1, '61585377613841', 'TranThaoUyen1231', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4166, 1, '61585550163348', 'LeNgocKhoa5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4167, 1, '61585717527479', 'ToPhucThanh5605', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4168, 1, '61585723023279', 'HaLuuBao22', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4169, 1, '61585754277155', 'HaLanSon5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4170, 1, '61585709819966', 'LyKimNam2142', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4171, 1, '61585701118924', 'TrinhNhatHuy885', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4172, 1, '61585405095621', 'DoanHoangLinh42', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4173, 1, '61585588204113', 'HoHienKhoa779', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4174, 1, '61585744709401', 'NguyenKimUyen16686', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4175, 1, '61585475378088', 'PhungYenXuan51', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4176, 1, '61585714290792', 'LeKhoiThinh30728', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4177, 1, '61585732496643', 'CaoKyAnh98', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4178, 1, '61585341977689', 'KhuatQuanThao873', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4179, 1, '61585416763961', 'PhanKhoiHan69654', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4180, 1, '61585435330182', 'CaoQuanKhoa993', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4181, 1, '61585659902378', 'DangUyenNgan87303', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4182, 1, '61585382624145', 'DoanDuyNhan3282', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4183, 1, '61585846013460', 'ChauThaiHuy36703', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4184, 1, '61585877991657', 'HoangVyThao4346', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4185, 1, '61585581306346', 'PhungLienKhanh84', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4186, 1, '61585941592672', 'VuLuuPhuc25', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4187, 1, '61585468898616', 'TrinhDinhNgoc8760', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4188, 1, '61585408840773', 'HuynhPhuMinh5846', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4189, 1, '61585695118839', 'NguyenThaoDuy782', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4190, 1, '61585734836192', 'PhungVanMy42160', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4191, 1, '61585559764567', 'NguyenPhucThanh1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4192, 1, '61585679280961', 'HaKienTri83461', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4193, 1, '61585563606087', 'HoKyPhat7910', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4194, 1, '61585723346427', 'TrinhKimSon16287', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4195, 1, '61585717046725', 'HaHaThanh99410', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4196, 1, '61585857650540', 'TongGiaAn425', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4197, 1, '61585804526129', 'VoQuanSon70654', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4198, 1, '61585847963217', 'PhanHaiMy61', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4199, 1, '61585618082476', 'NgoLongBao8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4200, 1, '61585478172077', 'HoangLeHuy8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4201, 1, '61585339996412', 'VuTanHan8745', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4202, 1, '61585857260842', 'TrinhPhuThanh276', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4203, 1, '61585909104331', 'QuachHienUyen95', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4204, 1, '61585747224997', 'DinhMyThinh48', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4205, 1, '61585393783003', 'PhamLinhNgan9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4206, 1, '61585410941447', 'DoanMy7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4207, 1, '61585380196929', 'QuachNgocDuy3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4208, 1, '61585695270366', 'HoangKimThao16', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4209, 1, '61585506397451', 'ChauVanNam7058', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4210, 1, '61585370204406', 'QuachLuuYen750', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4211, 1, '61585533012410', 'ToDuyNhan92591', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4212, 1, '61585479010544', 'MacTrungThinh3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4213, 1, '61585662210672', 'VuVinhVan8942', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4214, 1, '61585618832539', 'VuMyPhu66010', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4215, 1, '61585641607386', 'BuiMaiMinh81777', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4216, 1, '61585625133904', 'PhungVanHan11', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4217, 1, '61585383495590', 'HuynhMyYen11', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4218, 1, '61585416072205', 'TrinhHaoNhien1121', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4219, 1, '61585634102027', 'VuSonVan93', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4220, 1, '61585872443292', 'NguyenTruongLinh483', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4221, 1, '61585790665869', 'LeTriAnh31', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4222, 1, '61585591352758', 'BuiHuuBao676', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4223, 1, '61585698177611', 'DoanTanPhat2387', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4224, 1, '61585692717831', 'ToGiaHuy69118', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4225, 1, '61585669081815', 'PhamPhuongSon616', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4226, 1, '61585520196809', 'DangMinhSon678', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4227, 1, '61585399602343', 'DoanNamKhanh7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4228, 1, '61585896922086', 'MaiHuuVy8555', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4229, 1, '61585616344332', 'NguyenLuuYen24', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4230, 1, '61585475978120', 'DoQuanPhat99', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4231, 1, '61585357184431', 'HoangGiaKhang86', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4232, 1, '61585716209433', 'QuachBaoHan83', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4233, 1, '61585759615119', 'QuachAnhKhoa6432', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4234, 1, '61585352594565', 'TonXuanPhu6584', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4235, 1, '61585593665456', 'QuachKimDuy36704', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4236, 1, '61585425041760', 'DauLeHuy9462', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4237, 1, '61585850454143', 'DauTung25', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4238, 1, '61585750375743', 'HuynhKienVan8714', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4239, 1, '61585794113390', 'VoThienVy33', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4240, 1, '61585383346520', 'QuachThaoDuy5347', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4241, 1, '61585968080228', 'DuongNganPhat9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4242, 1, '61585734865786', 'ChauThanh3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4243, 1, '61585719990666', 'HoKhoa209', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4244, 1, '61585678591093', 'PhungGiaQuan380', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4245, 1, '61585978190803', 'PhamLanKhoa3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4246, 1, '61585532316347', 'PhamNganThanh56', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4247, 1, '61585617008703', 'DangNgocKhoa30', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4248, 1, '61585761476960', 'QuachTrungKhanh606', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4249, 1, '61585404044289', 'MacVanThinh6264', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4250, 1, '61585691732677', 'LeHong89846', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4251, 1, '61585780553586', 'HoThinhLinh68', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4252, 1, '61585384063707', 'DinhHaThien261', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4253, 1, '61585830534195', 'AuKyPhat568', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4254, 1, '61585825554334', 'NguyenGiaYen86', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4255, 1, '61585592673922', 'DoanThaoUyen203', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4256, 1, '61585504721880', 'DoThaoPhu30', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4257, 1, '61585491307516', 'TaAnKhanh18708', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4258, 1, '61585553558787', 'PhamThaiHuy7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4259, 1, '61585384932654', 'DinhThaoVan79665', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4260, 1, '61585676189641', 'ToKimNam10', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4261, 1, '61585734871027', 'HoangThanhThinh87450', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4262, 1, '61585783019594', 'ToHoangYen69224', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4263, 1, '61585457379347', 'NguyenPhuKhoa2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4264, 1, '61585595316764', 'DoKyNgan4161', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4265, 1, '61585902864545', 'PhungNamKhoa83920', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4266, 1, '61585441904772', 'HaQuocThien94369', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4267, 1, '61585652556089', 'HoThienThanh6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4268, 1, '61585442986373', 'LeTrungKhoa624', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4269, 1, '61585407886441', 'MaiYenNam10', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4270, 1, '61585615926457', 'LeUyenLong245', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4271, 1, '61585667135488', 'BuiHoangUyen0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4272, 1, '61585865754704', 'VuPhuLong1558', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4273, 1, '61585527012638', 'BuiHuuPhu21', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4274, 1, '61585974860581', 'CaoTruongYen7629', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4275, 1, '61585710661849', 'ToTanThao24852', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4276, 1, '61585727370870', 'DuongPhuMy2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4277, 1, '61585875023974', 'DangPhatAnh86', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4278, 1, '61585444936182', 'DoanLienNam1496', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4279, 1, '61585401616627', 'DauHuuKhoa16187', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4280, 1, '61585754431946', 'KhuatQuanAn66870', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4281, 1, '61585453304120', 'QuachHienNgan1727', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4282, 1, '61585969461378', 'DoNamLong46', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4283, 1, '61585415687918', 'KhuatVinhTri95879', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4284, 1, '61585691313007', 'QuachChiTrung5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4285, 1, '61585442565145', 'VuLinhNam917', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4286, 1, '61585465064545', 'LyQuanPhat6634', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4287, 1, '61585846255698', 'DoanPhatNam874', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4288, 1, '61585914504300', 'BuiNganLong54627', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4289, 1, '61585883663947', 'TrinhKyKhanh0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4290, 1, '61585737601020', 'LaHuuThanh936', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4291, 1, '61585892394171', 'PhamThanhVy1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4292, 1, '61585951490667', 'QuachNgocThinh7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4293, 1, '61585886753430', 'TaNganKhanh98', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4294, 1, '61585418087686', 'AuHaiNam45293', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4295, 1, '61585818926847', 'BuiQuocNam30339', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4296, 1, '61585521160608', 'TaPhuHuy38', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4297, 1, '61585817758992', 'HoPhucAnh7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4298, 1, '61585484352635', 'BuiXuanHuy5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4299, 1, '61585922693295', 'TrinhNganHan23', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4300, 1, '61585624297935', 'PhanNganUyen9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4301, 1, '61585786498162', 'VuKhoiNgan810', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4302, 1, '61585942161303', 'TonNgocThinh7250', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4303, 1, '61585700373715', 'PhanQuanNam52', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4304, 1, '61585404707264', 'PhungLanPhat32', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4305, 1, '61585632906296', 'ToTruongPhat2698', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4306, 1, '61585889153654', 'QuachKhoiThanh5699', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4307, 1, '61585564331236', 'NgoVanYen344', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4308, 1, '61585477725127', 'HaCongThinh83', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4309, 1, '61585661855862', 'DinhSonMy706', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4310, 1, '61585815717125', 'AuUyenLinh56468', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4311, 1, '61585944262474', 'NgoLuuHuy557', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4312, 1, '61585531572176', 'DangQuocUyen9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4313, 1, '61585869684783', 'PhanDiemThuy94860', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4314, 1, '61585710182227', 'LaVanDuy26986', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4315, 1, '61585931271362', 'AuNhatKhanh832', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4316, 1, '61585567449138', 'TaKhanhPhuc405', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4317, 1, '61585755121326', 'BuiLeQuan67547', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4318, 1, '61585620156812', 'VuLanPhuc51', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4319, 1, '61585615836706', 'NguyenHung94724', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4320, 1, '61585931931388', 'QuachTruongThao95', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4321, 1, '61585578160619', 'ToThaoMy226', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4322, 1, '61585801977116', 'TongThienTri6739', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4323, 1, '61585569549103', 'TrinhVanNgan2730', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4324, 1, '61585476553183', 'VuNganDuy305', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4325, 1, '61585526260978', 'LaThaiDuy6984', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4326, 1, '61585498272017', 'TongVanThinh64018', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4327, 1, '61585677275126', 'LyKhanhNam26909', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4328, 1, '61585566579134', 'LyHaiTri226', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4329, 1, '61585577528511', 'QuachLinhSon377', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4330, 1, '61585694043726', 'TranKimKhoa458', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4331, 1, '61585676284113', 'CaoKyNgoc619', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4332, 1, '61585485824581', 'HuynhLinhThinh59', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4333, 1, '61585589289224', 'KhuatNamNgoc421', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4334, 1, '61585610527026', 'KhuatLinhKhanh3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4335, 1, '61585567571116', 'TaQuocThinh1935', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4336, 1, '61585405697493', 'NgoQuocAn87396', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4337, 1, '61585944440914', 'NgoLongDuy5681', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4338, 1, '61585534090714', 'HoThinhPhu7039', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4339, 1, '61585671063930', 'HaYenPhat713', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4340, 1, '61585423817360', 'QuachKhanhHan5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4341, 1, '61585603777563', 'HoangTamVan7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4342, 1, '61585433207275', 'TongKimLong6110', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4343, 1, '61585465755032', 'DuongThaoHan20', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4344, 1, '61585958751967', 'NguyenUyenMy22', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4345, 1, '61585966041550', 'DangPhatHuy7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4346, 1, '61585533582095', 'DoThinhVan7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4347, 1, '61585852196976', 'MacBinhMinh6354', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4348, 1, '61585741200900', 'HoangHaLinh77712', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4349, 1, '61585424507910', 'MacKhoiThien62536', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4350, 1, '61585910363744', 'BuiKienHan588', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4351, 1, '61585635217752', 'MaiMinhLong1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4352, 1, '61585449464677', 'HoHuuSon6224', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4353, 1, '61585483243272', 'DoanDiemTrang509', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4354, 1, '61585646105394', 'PhanUyenVan430', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4355, 1, '61585871515834', 'DuongLienTri90875', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4356, 1, '61585666506053', 'ToHaMy55', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4357, 1, '61585640526771', 'QuachNamLinh132', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4358, 1, '61585452855248', 'MaiQuanNam411', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4359, 1, '61585768800622', 'DauKienMy2997', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4360, 1, '61585772760116', 'TrinhLuuLong44', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4361, 1, '61585479374720', 'AuNganLong20619', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4362, 1, '61585471873314', 'QuachThaiHan28', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4363, 1, '61585855886549', 'DuongThaiMy7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4364, 1, '61585485643573', 'QuachYenThien67228', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4365, 1, '61585467824987', 'TaLePhuc9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4366, 1, '61585924731415', 'HoangThaiQuan6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4367, 1, '61585457535889', 'HuynhQuanUyen52108', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4368, 1, '61585528000407', 'PhamKhanhThao97176', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4369, 1, '61585878925809', 'MacYenSon5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4370, 1, '61585859486773', 'PhungThaiAnh35607', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4371, 1, '61585485912953', 'QuachTanNgan481', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4372, 1, '61585677303497', 'PhungXuanYen8608', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4373, 1, '61585465093638', 'TaTriPhat58', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4374, 1, '61585574949846', 'HoangTriLong315', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4375, 1, '61585759080929', 'BuiDinhVinh67657', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4376, 1, '61585758301327', 'NgoTanPhat42', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4377, 1, '61585903854240', 'TrinhNam8910', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4378, 1, '61585775608827', 'PhamKimHuy7027', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4379, 1, '61585762231213', 'QuachVanUyen465', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4380, 1, '61585898242770', 'TongBaoYen97', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4381, 1, '61585925331504', 'MacKienThanh66', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4382, 1, '61585924373556', 'TonPhuongKhanh6813', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4383, 1, '61585872564211', 'BuiHoangNam15', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4384, 1, '61585435516951', 'BuiVanPhuc78285', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4385, 1, '61585463025628', 'KhuatQuocKhanh1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4386, 1, '61585759709216', 'DuongMaiThao624', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4387, 1, '61585555391170', 'MacLuuHuy2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4388, 1, '61585549090349', 'DoDiemMy996', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4389, 1, '61585922783587', 'VuYenSon9472', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4390, 1, '61585602428880', 'BuiHoangHuy74', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4391, 1, '61585791989599', 'MacHuuAnh22389', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4392, 1, '61585621928129', 'LeLanHan70', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4393, 1, '61585624868248', 'VoLeThinh255', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4394, 1, '61585671033927', 'DoDinhThinh839', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4395, 1, '61585713811975', 'AuPhatNgoc2307', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4396, 1, '61585578070679', 'AuVinhKhoa17407', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4397, 1, '61585587279522', 'PhungThinhYen61598', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4398, 1, '61585600358924', 'DoSonDuy579', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4399, 1, '61585850786504', 'DoLienMinh567', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4400, 1, '61585621236460', 'DoanThaoHuy824', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4401, 1, '61585694822748', 'MacPhuDuy3827', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4402, 1, '61585669355256', 'LaKhanhMinh202', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4403, 1, '61585689063200', 'AuPhuongMy82', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4404, 1, '61585534332500', 'QuachThanhDuy85', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4405, 1, '61585833268433', 'DoanTruongNam71032', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4406, 1, '61585779208498', 'PhamTrungMinh8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4407, 1, '61585428315189', 'PhamMyPhuc4074', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4408, 1, '61585421715961', 'BuiHaVy59246', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4409, 1, '61585919721751', 'DangLongPhuc8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4410, 1, '61585673584785', 'VoLanLong33707', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4411, 1, '61585613076696', 'TrinhNamMy2091', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4412, 1, '61585711861995', 'DoQuanBao22', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4413, 1, '61585657535275', 'KhuatBaoMinh8979', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4414, 1, '61585420967499', 'VoThaoLinh20', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4415, 1, '61585610528262', 'VuVinhSon15', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4416, 1, '61585713901846', 'QuachPhucAn3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4417, 1, '61585747382340', 'MacThang4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4418, 1, '61585741620134', 'VuTrungPhuc394', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4419, 1, '61585482013101', 'HoBaoThy961', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4420, 1, '61585424835872', 'AuPhuongAnh373', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4421, 1, '61585702023951', 'CaoTruongBao556', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4422, 1, '61585752300928', 'DuongLanMy1884', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4423, 1, '61585475924624', 'DoanBaoThy60', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4424, 1, '61585889514707', 'VuUyen6158', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4425, 1, '61585687355353', 'HaKhanhHan6118', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4426, 1, '61585718491669', 'HaLongVy623', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4427, 1, '61585826157900', 'PhamDuyViet936', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4428, 1, '61585840226051', 'LeVanQuan545', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4429, 1, '61585916212028', 'HoangNganMinh9521', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4430, 1, '61585659814295', 'VoTanThinh8547', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4431, 1, '61585640255227', 'LeTanMinh4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4432, 1, '61585523981827', 'LaVanBao2827', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4433, 1, '61585580140804', 'LaGiaLinh9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4434, 1, '61585452165690', 'CaoUyenTri3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4435, 1, '61585774558650', 'PhungMinhThinh0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4436, 1, '61585768680513', 'TongHung8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4437, 1, '61585562679320', 'PhamThaoTri9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4438, 1, '61585783379726', 'LeLongVan4785', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4439, 1, '61585860684857', 'BuiThienBao87', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4440, 1, '61585669205916', 'TongMyMinh2918', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4441, 1, '61585687984520', 'QuachNhatTri42', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4442, 1, '61585749211287', 'TonHuong729', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4443, 1, '61585579239635', 'BuiHuuPhu35', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4444, 1, '61585660356571', 'HoDinhKhoi589', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4445, 1, '61585449374080', 'TaVyThien54', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4446, 1, '61585656246379', 'HuynhKhanh2528', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4447, 1, '61585725392507', 'NgoVanKhanh7948', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4448, 1, '61585624597920', 'PhungVanMinh23', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4449, 1, '61585770028795', 'TrinhLuuThanh3712', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4450, 1, '61585668216213', 'CaoLongQuan378', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4451, 1, '61585642536641', 'LeLeLong26', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4452, 1, '61585632067768', 'MacPhucThien6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4453, 1, '61585813496672', 'QuachLinhPhu29', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4454, 1, '61585413017610', 'DauNamKhanh82', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4455, 1, '61585575400189', 'VoLanPhat37', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4456, 1, '61585439265619', 'PhungLeHuy12', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4457, 1, '61585711232564', 'HuynhDuyPhat259', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4458, 1, '61585975131188', 'QuachLienTri58', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4459, 1, '61585564690582', 'DuongHaKhanh84902', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4460, 1, '61585906044087', 'AuCongThanh20075', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4461, 1, '61585397567046', 'VuTamHuy5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4462, 1, '61585726531471', 'BuiKimThinh504', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4463, 1, '61585691883372', 'HaKienPhu753', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4464, 1, '61585811907080', 'LeVinhVan9828', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4465, 1, '61585596457499', 'DoanYenThao3045', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4466, 1, '61585894855167', 'TranKySon1537', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4467, 1, '61585779598336', 'PhungYenLinh6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4468, 1, '61585717471442', 'DangThaoKhoa3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4469, 1, '61585622467725', 'DuongCuong2696', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4470, 1, '61585425405290', 'LeMaiQuan53', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4471, 1, '61585437766549', 'DinhQuocVan7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4472, 1, '61585696862521', 'QuachTanNam453', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4473, 1, '61585576389092', 'TrinhHuuUyen24863', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4474, 1, '61585639026899', 'MaiThinhLinh25995', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4475, 1, '61585798769253', 'DoMyHuy29', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4476, 1, '61585959891980', 'DangPhucThao61', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4477, 1, '61585734662176', 'AuVinhNgoc3037', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4478, 1, '61585571439334', 'TaTanHuy214', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4479, 1, '61585823996345', 'HuynhNganPhuc1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03');
INSERT INTO `random_category_accounts` (`id`, `random_category_id`, `account_name`, `password`, `price`, `status`, `server`, `buyer_id`, `batch_id`, `note`, `note_buyer`, `thumbnail`, `created_at`, `updated_at`) VALUES
(4480, 1, '61585401737954', 'VuKyTri68007', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4481, 1, '61585706914222', 'ChauLanTri0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4482, 1, '61585829516208', 'HaVyMy16875', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4483, 1, '61585777800519', 'AuSonKhoa594', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4484, 1, '61585445266590', 'LaQuanLong829', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4485, 1, '61585546119940', 'PhungVinhVan4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4486, 1, '61585553110205', 'ToKienHuy107', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4487, 1, '61585911352190', 'TrinhMinhAnh9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4488, 1, '61585525541050', 'TranTrungLinh0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4489, 1, '61585609808720', 'HoangYenHuy5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4490, 1, '61585614216584', 'DinhQuocMinh213', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4491, 1, '61585494612382', 'DangPhucNgoc39', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4492, 1, '61585636957662', 'HoangThinhUyen9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4493, 1, '61585573208711', 'NguyenMaiNgan824', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4494, 1, '61585964451100', 'TrinhNgocVan691', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4495, 1, '61585489812195', 'LePhucThao14', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4496, 1, '61585980740196', 'LyHienSon932', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4497, 1, '61585919331758', 'QuachDiemThuy7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4498, 1, '61585753351569', 'QuachQuocVy5820', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4499, 1, '61585412687953', 'VuTruongThao9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4500, 1, '61585644817270', 'ChauUyen66', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4501, 1, '61585918491961', 'PhamPhuPhat5422', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4502, 1, '61585628526245', 'VuNganQuan74', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4503, 1, '61585712762222', 'QuachTuan9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4504, 1, '61585923893501', 'KhuatLanSon87476', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4505, 1, '61585706073629', 'DoanHienKhoa7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4506, 1, '61585717711305', 'CaoNgocPhuc96', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4507, 1, '61585917323490', 'BuiLanLinh720', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4508, 1, '61585685645056', 'QuachUyenAn3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4509, 1, '61585634285737', 'TranTruongVy60076', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4510, 1, '61585516211070', 'PhanNgocSon1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4511, 1, '61585435815369', 'TranLinhHuy378', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4512, 1, '61585394237724', 'MacLanYen42', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4513, 1, '61585525780632', 'MacLanDuy5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4514, 1, '61585862514775', 'ChauHaiYen541', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4515, 1, '61585951820128', 'TaGiaQuan4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4516, 1, '61585380557942', 'ChauGiaTri4426', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4517, 1, '61585585300010', 'TaVanLong4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4518, 1, '61585718642941', 'DauHaThao29743', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4519, 1, '61585886753725', 'VoKhanhNgoc636', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4520, 1, '61585833447656', 'PhanKhoiSon914', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4521, 1, '61585741022313', 'LaLongTri2013', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4522, 1, '61585500193294', 'BuiPhuongLong72', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4523, 1, '61585500973332', 'MacLanNam899', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4524, 1, '61585944800545', 'VoVinhYen2347', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4525, 1, '61585476192410', 'PhanVyThao3768', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4526, 1, '61585559981279', 'MaiVinhSon3597', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4527, 1, '61585805008584', 'DinhMaiNam0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4528, 1, '61585681115056', 'VuNganThao6248', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4529, 1, '61585965171008', 'DoanPhuongKhanh15319', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4530, 1, '61585933163105', 'KhuatDiemMy676', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4531, 1, '61585921703836', 'CaoKhoiKhanh68', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4532, 1, '61585663325855', 'AuNganSon94', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4533, 1, '61585887563233', 'TonVyNam9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4534, 1, '61585417337751', 'BuiMinhPhuc11', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4535, 1, '61585610797485', 'VuNamThinh7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4536, 1, '61585450304464', 'VoNhatVy614', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4537, 1, '61585451235941', 'BuiMyThanh354', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4538, 1, '61585712371861', 'ToBaoTran84', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4539, 1, '61585432005398', 'TongLeLinh387', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4540, 1, '61585785629600', 'NgoPhatUyen8617', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4541, 1, '61585458733758', 'ToHoangYen98', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4542, 1, '61585532351596', 'HuynhQuanLinh2400', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4543, 1, '61585746511446', 'PhamPhatPhuc79173', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4544, 1, '61585626156418', 'DuongVanKhanh82', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4545, 1, '61585880873777', 'LyVyVan85', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4546, 1, '61585903074690', 'PhamPhucDuy4789', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4547, 1, '61585434465534', 'DauHienQuan598', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4548, 1, '61585512073085', 'MacTamThien9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4549, 1, '61585667704274', 'PhanNhatNgan9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4550, 1, '61585606267051', 'VuHaiDang63396', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4551, 1, '61585671093937', 'DoanPhuongDuy19', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4552, 1, '61585922632830', 'HaLeThien432', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4553, 1, '61585611636843', 'PhamLongNam8581', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4554, 1, '61585936760766', 'DinhLienThanh85708', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4555, 1, '61585723711397', 'HaPhuQuan1083', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4556, 1, '61585433207314', 'QuachQuocVy2085', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4557, 1, '61585647877043', 'CaoMaiAn1316', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4558, 1, '61585906404754', 'HoVanThanh51', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4559, 1, '61585730280768', 'LeDuyKhanh587', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4560, 1, '61585770900062', 'ToBinh55124', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4561, 1, '61585623157695', 'ChauNamDuy86', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4562, 1, '61585669354571', 'VoXuanYen49', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4563, 1, '61585689484023', 'PhanSonBao340', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4564, 1, '61585729351506', 'MaiLanSon5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4565, 1, '61585966971541', 'TongVyNam53324', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4566, 1, '61585895183571', 'ChauHuuQuan5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4567, 1, '61585489332635', 'ToQuanDuy1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4568, 1, '61585694434167', 'DauVanPhuc51', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4569, 1, '61585480784201', 'DoanThanhVy95', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4570, 1, '61585898723007', 'PhamHanh2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4571, 1, '61585690714447', 'LyKhoiThinh3978', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4572, 1, '61585619166250', 'TrinhBaoHan15698', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4573, 1, '61585936521143', 'TranTriLong3353', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4574, 1, '61585890954416', 'DangLanLong9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4575, 1, '61585942851002', 'QuachPhuHan78448', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4576, 1, '61585515433197', 'QuachKienQuan1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4577, 1, '61585603929133', 'TranSonMy77531', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4578, 1, '61585960071338', 'DangHuuPhu7181', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4579, 1, '61585653274907', 'CaoMyKhoa47822', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4580, 1, '61585537540893', 'ChauHoa6639', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4581, 1, '61585816887131', 'AuVinhMy54', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4582, 1, '61585424596241', 'TrinhPhucMinh359', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4583, 1, '61585658884919', 'NguyenLanLinh254', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4584, 1, '61585604467500', 'DuongQuocVy967', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4585, 1, '61585429605307', 'TranUyenHuy34739', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4586, 1, '61585887624956', 'QuachHaNam2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4587, 1, '61585955632144', 'MacHaAnh43893', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4588, 1, '61585893832972', 'VoVyThao77203', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4589, 1, '61585476282706', 'DuongQuocKhoa78', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4590, 1, '61585691943071', 'VoQuocNam104', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4591, 1, '61585421985565', 'ToTanHuy158', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4592, 1, '61585512252713', 'DuongMaiBao716', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4593, 1, '61585505651587', 'NguyenThienNam5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4594, 1, '61585883243619', 'TongMyNgan75140', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4595, 1, '61585495212034', 'DinhKhanhPhat88', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4596, 1, '61585577259182', 'QuachLan6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4597, 1, '61585755541653', 'QuachXuanPhu82', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4598, 1, '61585851445097', 'VoThanhQuan58', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4599, 1, '61585875505447', 'HoVanKhanh7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4600, 1, '61585700793920', 'QuachBaoVy56', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4601, 1, '61585429846321', 'TrinhHaiNgan2248', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4602, 1, '61585405787749', 'DauTruongAn107', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4603, 1, '61585778968991', 'NgoVanPhuc7940', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4604, 1, '61585586139669', 'ChauNhatQuan57', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4605, 1, '61585639297027', 'NgoKimAn40', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4606, 1, '61585563699649', 'HaVyUyen956', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4607, 1, '61585608997090', 'QuachMinhPhu29', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4608, 1, '61585680063779', 'AuThaoKhoa4789', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4609, 1, '61585469293611', 'PhungVanUyen83236', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4610, 1, '61585504842923', 'ToNgocKhanh2308', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4611, 1, '61585842597471', 'DinhVanThao476', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4612, 1, '61585875774555', 'TaThinhPhuc8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4613, 1, '61585699892314', 'LeMaiNgoc7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4614, 1, '61585924792591', 'ChauHaiLinh856', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4615, 1, '61585503073879', 'LyThuan51', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4616, 1, '61585940212268', 'QuachVyHuy6714', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4617, 1, '61585419557946', 'HoSonQuan1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4618, 1, '61585691043355', 'NgoDinhLong3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4619, 1, '61585481834798', 'HoangHaiYen47', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4620, 1, '61585695064540', 'MaiThaiKhoa60370', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4621, 1, '61585665095618', 'ToDuyThai12297', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4622, 1, '61585817488974', 'DinhKhanhMy173', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4623, 1, '61585614787336', 'HoVySon97908', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4624, 1, '61585469713423', 'PhungMaiHuy0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4625, 1, '61585799487426', 'KhuatKyLinh3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4626, 1, '61585813077037', 'LeLuuUyen579', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4627, 1, '61585430625713', 'TrinhMyTri6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4628, 1, '61585834346177', 'ToHaKhang24', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4629, 1, '61585535230727', 'PhanThaoThien5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4630, 1, '61585471724474', 'PhungPhatVy132', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4631, 1, '61585510422663', 'DuongPhatNgan60', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4632, 1, '61585574829866', 'BuiPhuVan33508', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4633, 1, '61585621626834', 'MacPhuNgan14282', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4634, 1, '61585553381631', 'MacMyMinh802', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4635, 1, '61585924193461', 'QuachSonPhuc6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4636, 1, '61585591028486', 'MacVanQuan6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4637, 1, '61585755449583', 'ChauLongQuan995', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4638, 1, '61585923713578', 'HoangTanMy562', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4639, 1, '61585600147322', 'TrinhTruongTri270', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4640, 1, '61585642476923', 'DoNamVy7115', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4641, 1, '61585839357199', 'DinhKimHan41021', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4642, 1, '61585550262238', 'QuachMyBao776', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4643, 1, '61585910212675', 'PhamQuocThao224', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4644, 1, '61585738680788', 'KhuatLongKhanh770', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4645, 1, '61585550892102', 'DoMyBao0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4646, 1, '61585629997492', 'AuCongSon459', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4647, 1, '61585924373481', 'TaVinhHan18034', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4648, 1, '61585785659568', 'MaiVinhKhoa898', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4649, 1, '61585428885396', 'BuiNhatNgoc49238', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4650, 1, '61585427235498', 'DangKimUyen80', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4651, 1, '61585832936230', 'QuachYen6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4652, 1, '61585958841654', 'PhungHoangThao5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4653, 1, '61585559379523', 'QuachKyTri30014', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4654, 1, '61585623188093', 'MaiTriHuy4600', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4655, 1, '61585695602708', 'DinhSonVan7806', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4656, 1, '61585750442102', 'KhuatAnhKhoa1551', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4657, 1, '61585695934300', 'MacKhoiThanh9688', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4658, 1, '61585706794461', 'AuHuuKhanh4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4659, 1, '61585855166629', 'HuynhDinhDuy419', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4660, 1, '61585571141083', 'VuBaoKhang6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4661, 1, '61585740002312', 'VoVinhMinh69851', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4662, 1, '61585653426424', 'DuongDiemPhuong7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4663, 1, '61585672743688', 'DoanBaoYen353', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4664, 1, '61585884654001', 'ChauLanPhu11', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4665, 1, '61585413976347', 'HuynhNhatMy39', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4666, 1, '61585551459269', 'DinhLinhNgan4706', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4667, 1, '61585756290088', 'HuynhLongThanh34184', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4668, 1, '61585794419714', 'LaVanYen9995', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4669, 1, '61585645774955', 'ChauNganThien23525', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4670, 1, '61585719751381', 'DoTruongAn42', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4671, 1, '61585795229593', 'CaoNganPhuc43995', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4672, 1, '61585727580777', 'LeSonNgoc4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4673, 1, '61585516150905', 'NguyenThaiMy3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4674, 1, '61585699472258', 'QuachPhuongLong578', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4675, 1, '61585444484597', 'ChauXuanThao90940', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4676, 1, '61585563671614', 'KhuatNgocAn8982', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4677, 1, '61585448204710', 'HoangThaiPhu592', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4678, 1, '61585802487319', 'PhanDinhBao24', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4679, 1, '61585928333656', 'LaPhuongTri28264', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4680, 1, '61585964840708', 'AuHuuQuan355', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4681, 1, '61585521640435', 'DinhNhatKhanh664', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4682, 1, '61585417037755', 'DauTruongYen9711', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4683, 1, '61585926292912', 'DangNhatUyen46', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4684, 1, '61585635187089', 'NgoDinhTuan38166', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4685, 1, '61585473794993', 'BuiThaiThao1588', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4686, 1, '61585583379940', 'DauLienNgan8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4687, 1, '61585901904604', 'TrinhQuanNgan85', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4688, 1, '61585788869394', 'VuThaoThanh5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4689, 1, '61585838785866', 'NguyenTanLinh0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4690, 1, '61585839625888', 'TonMinhHuy50', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4691, 1, '61585980980257', 'LyNganPhat9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4692, 1, '61585519271392', 'TongHoangHan801', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4693, 1, '61585954221620', 'TranNgocSon7385', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4694, 1, '61585955750312', 'HoangKyUyen34633', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4695, 1, '61585511562398', 'VuMinhVan3344', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4696, 1, '61585776328875', 'NguyenThaiYen60150', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4697, 1, '61585603297749', 'ChauKyThien60', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4698, 1, '61585485494904', 'QuachNgocKhanh1294', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4699, 1, '61585889213814', 'BuiGiaPhu90', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4700, 1, '61585814398306', 'TonLuuUyen9694', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4701, 1, '61585505382031', 'DinhHung3451', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4702, 1, '61585963011119', 'DauPhuongPhat4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4703, 1, '61585656876120', 'PhungThinh4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4704, 1, '61585556379915', 'MaiPhucNgan46', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4705, 1, '61585910844494', 'NguyenHaLong988', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4706, 1, '61585837585894', 'LeDuy121', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4707, 1, '61585945162831', 'LyHienAn593', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4708, 1, '61585668936211', 'AuKhanhAn732', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4709, 1, '61585734031129', 'HoangKhanhNgan28081', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4710, 1, '61585755901096', 'TrinhGiaVi607', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4711, 1, '61585661976547', 'PhungKimKhanh17249', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4712, 1, '61585735350410', 'KhuatMinhThanh46460', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4713, 1, '61585889124924', 'QuachHoangUyen21', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4714, 1, '61585951312068', 'ToThinhPhat366', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4715, 1, '61585722751591', 'TranPhucNgoc145', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4716, 1, '61585527582186', 'HuynhXuan30', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4717, 1, '61585571139938', 'DinhGiaVi3348', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4718, 1, '61585714142188', 'TrinhAnhDuc71', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4719, 1, '61585956502122', 'LaLuuThao55085', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4720, 1, '61585854986202', 'LaKimKhoa8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4721, 1, '61585854806577', 'HoLinhHuy6853', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4722, 1, '61585531001619', 'HoangKyTri4868', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4723, 1, '61585450064189', 'TranQuocLinh13635', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4724, 1, '61585461854140', 'CaoHienDuy632', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4725, 1, '61585488733784', 'LaMinhQuan2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4726, 1, '61585720651252', 'PhungThienDuy3184', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4727, 1, '61585713571999', 'DinhLongVan528', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4728, 1, '61585432186869', 'TonKimThanh7057', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4729, 1, '61585885193665', 'PhanDiep2804', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4730, 1, '61585779628365', 'MaiHaTrang45', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4731, 1, '61586000690012', 'QuachTanPhuc5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4732, 1, '61585729351424', 'MaiPhuongNam85970', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4733, 1, '61585816797973', 'DoanVanLinh6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4734, 1, '61585587638103', 'MacSonYen437', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4735, 1, '61585426335321', 'TranDuyLong9288', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4736, 1, '61585571680855', 'QuachLongKhanh4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4737, 1, '61585800807339', 'LyNamThao10', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4738, 1, '61585983530609', 'TaHuuNgoc16', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4739, 1, '61585677485654', 'PhamHaiVan4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4740, 1, '61585452646166', 'TaLinhAn68669', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4741, 1, '61585402967281', 'ToVanKhoa111', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4742, 1, '61585920621850', 'VuLanLong825', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4743, 1, '61585478113166', 'PhamGiaThuan15721', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4744, 1, '61585527582189', 'BuiHaPhuc416', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4745, 1, '61585588689012', 'PhungGiaNhi13494', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4746, 1, '61585895844815', 'MaiBaoChau4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4747, 1, '61585592257951', 'TaNhatKhanh46', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4748, 1, '61585889393363', 'CaoKhoi307', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4749, 1, '61585817366688', 'TrinhSonThien78', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4750, 1, '61585885733510', 'TaLongThinh64', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4751, 1, '61585916333318', 'LaMyDuy535', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4752, 1, '61585568829048', 'HoKhanh78', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4753, 1, '61585738290707', 'HuynhAnhThu55560', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4754, 1, '61585735141879', 'PhamLy12', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4755, 1, '61585556619941', 'KhuatVinhMinh55', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4756, 1, '61585614307153', 'PhamSonThinh26483', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4757, 1, '61585941382487', 'LaChiMinh85215', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4758, 1, '61585833056050', 'DuongChiBao9053', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4759, 1, '61585901182567', 'ToKyUyen9782', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4760, 1, '61585429636843', 'NgoQuanVan7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4761, 1, '61585805159263', 'QuachCongTri9740', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4762, 1, '61585922841762', 'LyXuanNam6312', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4763, 1, '61585845567657', 'TaHienKhanh96600', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4764, 1, '61585452283798', 'HuynhPhatThao57933', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4765, 1, '61585517261045', 'TranHuuKhanh0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4766, 1, '61585521492090', 'TonDuyTung9321', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4767, 1, '61585410316273', 'ChauBaoVy7003', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4768, 1, '61585913242053', 'QuachKienNam2442', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4769, 1, '61585720171633', 'DoanMinhLong89', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4770, 1, '61585735410797', 'DauHaiNgan65', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4771, 1, '61585850876347', 'KhuatVanAnh802', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4772, 1, '61585654714630', 'QuachLuuSon0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4773, 1, '61585865035208', 'NgoTanNgoc93581', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4774, 1, '61585453125756', 'LaNamMinh63753', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4775, 1, '61585717472684', 'BuiHienYen49', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4776, 1, '61585455825605', 'TranLienYen356', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4777, 1, '61585938652491', 'MaiThaiTri6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4778, 1, '61585720111381', 'BuiBinhMinh7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4779, 1, '61585894883200', 'TonYenThien6388', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4780, 1, '61585459515621', 'TongDuyKhanh51', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4781, 1, '61585774769142', 'VuTrungYen92292', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4782, 1, '61585674154178', 'DinhKhanhQuan1403', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4783, 1, '61585817517731', 'TonHaoNhien15617', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4784, 1, '61585978760635', 'DangKienYen9455', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4785, 1, '61585796909804', 'PhanNamMinh9814', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4786, 1, '61585433086776', 'MaiPhucUyen5988', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4787, 1, '61585471694928', 'PhamYenLong42', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4788, 1, '61585406597011', 'VuAnh300', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4789, 1, '61585931123208', 'ChauLinhThien2446', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4790, 1, '61585449256567', 'BuiSonMy3864', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4791, 1, '61585944500631', 'KhuatDuyTri4407', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4792, 1, '61585766309084', 'HaLanLong4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4793, 1, '61585832128194', 'TongKienThanh54711', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4794, 1, '61585405966467', 'ToViet88', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4795, 1, '61585580680048', 'LeThanhThien4793', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4796, 1, '61585585450504', 'HuynhPhuongSon6204', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4797, 1, '61585898574648', 'ToPhuPhat49', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4798, 1, '61585810498156', 'NgoQuocMinh4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4799, 1, '61585624776268', 'BuiNamPhat4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4800, 1, '61585687832875', 'TranLeThinh7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4801, 1, '61585605127750', 'CaoVyVan7003', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4802, 1, '61585759949803', 'QuachNganNgoc4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4803, 1, '61585780119248', '9Ns5GC7BuJ', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4804, 1, '61585778518504', 'ChauVyPhuc5583', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4805, 1, '61585565200485', 'MacDiemTu75', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4806, 1, '61585584759271', 'LeQuanHan90068', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4807, 1, '61585946002248', 'LePhucLong73072', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4808, 1, '61585556949511', 'LeQuocSon12', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4809, 1, '61585403086716', 'HuynhKhoiTri6809', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03');
INSERT INTO `random_category_accounts` (`id`, `random_category_id`, `account_name`, `password`, `price`, `status`, `server`, `buyer_id`, `batch_id`, `note`, `note_buyer`, `thumbnail`, `created_at`, `updated_at`) VALUES
(4810, 1, '61585518373031', 'HoVanSon449', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4811, 1, '61585839535597', 'TongDiemVy1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4812, 1, '61585728301200', 'LaNamPhuc76202', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4813, 1, '61585693654450', 'PhungLienDuy5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4814, 1, '61585398257508', 'NgoMinhLinh404', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4815, 1, '61585836746003', 'TongTruongVan9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4816, 1, '61585899714887', 'VuAnKhang5244', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4817, 1, '61585515073386', 'KhuatPhuongMy2980', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4818, 1, '61585500523058', 'DinhLinhPhuc726', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4819, 1, '61585417247684', 'TranQuanAnh53', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4820, 1, '61585688764985', 'DuongVanNgoc8574', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4821, 1, '61585948880335', 'QuachThaoHuy554', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4822, 1, '61585582569564', 'QuachVanSon7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4823, 1, '61585946840592', 'HaLanMinh51', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4824, 1, '61585563549258', 'MaiNhatBao878', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4825, 1, '61585618777947', 'MaiNamTri810', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4826, 1, '61585676585382', 'LyNamTri2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4827, 1, '61586079144318', 'CXXMfXIbek', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4828, 1, '61585787640137', 'ToNhatVan2059', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4829, 1, '61585377347965', 'VuTrungKhoa1794', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4830, 1, '61585466445323', 'TonThienMy264', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4831, 1, '61585918884190', 'TonVanLong37454', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4832, 1, '61585721761775', 'PhungVinh46', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4833, 1, '61585728452410', 'DangThienThao9942', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4834, 1, '61585580320410', 'NguyenMyVy665', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4835, 1, '61585760519301', 'LaHaiBinh7588', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4836, 1, '61585822558459', 'PhanChiCong5559', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4837, 1, '61585961181233', 'TranPhucPhu762', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4838, 1, '61585880665040', 'KhuatKimHan21', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4839, 1, '61585856885705', 'PK8DHWZfvJ', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4840, 1, '61585630416067', 'TonDiemTrang3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4841, 1, '61585983110522', 'LaThanhVan9519', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4842, 1, '61585424596120', 'DoanLongThien83', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4843, 1, '61585669985688', 'HoVinhAn6127', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4844, 1, '61585571710247', 'HaLuuUyen20610', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4845, 1, '61585961211827', 'MacHienKhanh8531', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4846, 1, '61585799667442', 'DuongVySon7450', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4847, 1, '61585804139221', 'QuachTrungPhu93', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4848, 1, '61585474994775', 'HuynhVanKhoa6049', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4849, 1, '61585881685093', 'ChauPhucPhu4135', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4850, 1, '61585844515620', 'MaiVanPhu6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4851, 1, '61585418536223', 'AuLuuPhu4679', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4852, 1, '61585578098207', 'NguyenPhatPhuc38710', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4853, 1, '61585525810667', 'MaiQuanKhanh7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4854, 1, '61585926923656', 'KhuatHaiAn50108', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4855, 1, '61585580408398', 'DauLuuQuan5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4856, 1, '61585634317805', 'ChauThienSon2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4857, 1, '61585831196435', 'HoPhuHuy35', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4858, 1, '61585425047117', 'KhuatKhoiHuy14098', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4859, 1, '61585567629464', 'VuLuuNgoc2861', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4860, 1, '61585627386074', 'MacHienKhoa9815', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4861, 1, '61585701693862', 'DauMinhDuy64125', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4862, 1, '61585521340951', 'TrinhVinhAn7063', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4863, 1, '61585812807135', 'BuiSonThao991', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4864, 1, '61585608908355', 'HoangTanLinh661', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4865, 1, '61585722751339', 'VuLeVan5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4866, 1, '61585551158431', 'BuiTanThao465', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4867, 1, '61586123302158', 'dVKJSF1SIP', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4868, 1, '61585761540322', 'TaLinhPhu4795', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4869, 1, '61585673523603', 'ToMyLinh714', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4870, 1, '61585717443252', 'QuachLanThao25', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4871, 1, '61585421807721', 'ChauSonThien0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4872, 1, '61585390547435', 'TranHienBao22169', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4873, 1, '61585423035982', 'HuynhKhanhThao5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4874, 1, '61585738080907', 'MaiHaMy1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4875, 1, '61585851567274', 'HuynhHaAn74040', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4876, 1, '61585550351751', 'QuachPhatPhu791', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4877, 1, '61585915284211', 'QuachMinhPhu88', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4878, 1, '61585567570305', 'CaoHaiNgan8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4879, 1, '61585676165161', 'DoYenKhoa96', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4880, 1, '61585499292282', 'TaNganKhoa6962', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4881, 1, '61585483574145', 'DoLinhHuy4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4882, 1, '61585695722655', 'NguyenThaiMy54904', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4883, 1, '61585846166966', 'VoThanhThinh42550', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4884, 1, '61585575070531', 'QuachPhat10', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4885, 1, '61585946332179', 'HoangHienThanh9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4886, 1, '61585426215932', 'TaPhuSon5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4887, 1, '61585753229626', 'TaDuyThai10533', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4888, 1, '61585759739638', 'NgoCongHau4485', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4889, 1, '61585432967046', 'HaMyAnh87725', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4890, 1, '61585787039991', 'LeThaiKhanh91', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4891, 1, '61585857266891', 'CaoVanLinh4065', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4892, 1, '61585757580849', 'DoanHaThanh67388', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4893, 1, '61585661194521', 'HoangHienNgan236', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4894, 1, '61585436956342', 'MacDuyCuong48', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4895, 1, '61585535860754', 'CaoXuanDuy618', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4896, 1, '61585493592147', 'MacTruongHuy723', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4897, 1, '61585684354976', 'PhanKienAn973', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4898, 1, '61585527581136', 'HuynhPhucBao7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4899, 1, '61585931902711', 'ToKhanhLinh664', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4900, 1, '61585865576289', 'HaQuocThien13307', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4901, 1, '61585741080741', 'HaHaAn37119', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4902, 1, '61585680275227', 'LaNhatAn393', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4903, 1, '61585878626116', 'PhamPhucTri2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4904, 1, '61585384187801', 'AuThinhPhu7922', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4905, 1, '61585950860164', 'HoNganMy43239', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4906, 1, '61585562740777', 'DuongDinhLong6992', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4907, 1, '61585578789899', 'PhungPhuongTri9175', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4908, 1, '61585766911416', 'HoDiemTrinh5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4909, 1, '61585471693776', 'VuKhoa91', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4910, 1, '61585917744138', 'PhanTanThinh96322', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4911, 1, '61585538832011', 'TonBaoKhang2758', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4912, 1, '61585740310982', '4jbhhfEl6p', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4913, 1, '61585449766499', 'QuachQue47', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4914, 1, '61585763489511', 'VuTrungNgan59883', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4915, 1, '61585558781454', 'HoangUyenPhuc47210', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4916, 1, '61585914983505', 'DoThaoHuy3821', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4917, 1, '61585501453253', 'KhuatThaiNgoc4683', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4918, 1, '61585472985099', 'PhamLuuQuan41616', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4919, 1, '61585699953882', 'ToNamUyen6038', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4920, 1, '61585861796528', 'LaQuocThanh60729', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4921, 1, '61585463445484', 'HoangDiemTrang546', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4922, 1, '61585814877394', 'TranNganTri15937', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4923, 1, '61585947530372', 'MaiThaoPhuc4297', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4924, 1, '61585716123335', 'LaPhucVan44674', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4925, 1, '61585383317842', 'HoangSonDuy52', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4926, 1, '61585928003414', 'DauVinhVan6588', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4927, 1, '61585752869598', 'PhamNamLinh368', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4928, 1, '61585566278173', 'DauPhatNgoc63', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4929, 1, '61585778729452', 'VuTamQuan68', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4930, 1, '61585552751588', 'TongDaThao54', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4931, 1, '61585750981975', 'HuynhTanDuy842', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4932, 1, '61585654354902', 'LyVyMinh296', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4933, 1, '61585741650781', 'DauLongNgoc471', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4934, 1, '61585964091115', 'TranMyVan30003', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4935, 1, '61585538680168', 'MaiPhuongNam379', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4936, 1, '61585774048338', 'TrinhLuuAnh82509', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4937, 1, '61585673523989', 'MacMyVy43', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4938, 1, '61585917711839', 'BuiPhuongNgoc1638', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4939, 1, '61585453544185', 'QuachTamTri83', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4940, 1, '61585569008939', 'NgoKhoiNam913', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4941, 1, '61585895333698', 'DinhLoan974', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4942, 1, '61585814157424', 'PhungThaiMy3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4943, 1, '61585826188705', 'PhamThaoNam622', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4944, 1, '61585644635053', 'HoangSonQuan399', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4945, 1, '61585625016387', 'LePhuongThien5648', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4946, 1, '61585810679280', 'HuynhMyThinh43169', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4947, 1, '61585683935433', 'QuachTriLinh5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4948, 1, '61585574288743', 'BuiDuyQuang4484', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4949, 1, '61585809746971', 'TongPhucTri39657', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4950, 1, '61585923563482', 'PhanLienBao895', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4951, 1, '61585593639753', 'DoTamHuy7086', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4952, 1, '61585450244258', 'DangKhanhBao150', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4953, 1, '61585643677006', 'TranLanVan3984', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4954, 1, '61585942132886', 'KhuatLeHan1112', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4955, 1, '61585582838420', 'QuachKyUyen39', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4956, 1, '61585958360024', 'DoHuuVan521', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4957, 1, '61585631646996', 'LaHienVy133', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4958, 1, '61585941590694', 'DoAnKhanh6140', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4959, 1, '61585708623496', 'TaTruongPhat70532', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4960, 1, '61585610257956', 'HoangDuyMinh6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4961, 1, '61586141421254', 'UN31ChDM3P', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4962, 1, '61586102363230', '9iZC4PCLtx', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4963, 1, '61585772409508', '3Uxr8Stv3A', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4964, 1, '61585876114742', 'H83pj7av59', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4965, 1, '61586011407979', 'Grio9bsdzY', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4966, 1, '61585711512830', 'n7kHco1vsj', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4967, 1, '61585731791581', 'qOqQfdXlXj', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4968, 1, '61585795319015', 'DoNhatNgan6859', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4969, 1, '61585501753758', 'AuTruongAn5922', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4970, 1, '61585631646493', 'TongHaiLong338', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4971, 1, '61585761631020', 'DangUyenHuy25', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4972, 1, '61585385537612', 'LePhatBao41228', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4973, 1, '61585944830618', 'HuynhNhung8600', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4974, 1, '61585461885830', 'BuiNhatHuy0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4975, 1, '61585491582679', 'TrinhMinhVy0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4976, 1, '61585469683544', 'MacLinhNam8973', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4977, 1, '61585508773126', 'LyThienKhanh297', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4978, 1, '61585779628218', 'TaPhuongUyen9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4979, 1, '61585934152592', 'LyVanPhuc5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4980, 1, '61585577198496', 'DuongLienLong16', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4981, 1, '61585815027361', 'HoangHaiKhanh40701', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4982, 1, '61585444186876', 'ChauNamBao70', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4983, 1, '61585585420622', 'LaThienMy117', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4984, 1, '61585792137636', 'DauDuyKhoi7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4985, 1, '61585945372710', 'KhuatDuyNam3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4986, 1, '61585737570564', 'LyLongQuan7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4987, 1, '61585468183530', 'MacDaThu4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4988, 1, '61585458284018', 'BuiNgocVy486', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4989, 1, '61585755691680', 'LaDinhMinh46147', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4990, 1, '61585869534417', 'DoThaoVy2162', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4991, 1, '61585462394430', 'ToNhatAnh3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4992, 1, '61585904992851', 'AuAnKhanh7338', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4993, 1, '61585860024911', 'LeVinhYen1580', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4994, 1, '61585463055372', 'TonChiHieu6122', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4995, 1, '61585729562148', 'DauTruongThinh3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4996, 1, '61585438156451', 'DauKhanhAnh242', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4997, 1, '61585465963336', 'DoMyDuy37', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4998, 1, '61585588119953', 'DauNganThao4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4999, 1, '61585474333625', 'PhanHuuYen44526', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5000, 1, '61585672294210', 'HaKienTri2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5001, 1, '61585418685809', 'DoUyenNgoc62224', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5002, 1, '61585773298486', 'TonHaTri23615', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5003, 1, '61585963910966', 'DoanDuyLong81122', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5004, 1, '61585737062215', 'ToAnhKhoa74229', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5005, 1, '61585512822913', 'DauThaiSon2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5006, 1, '61585467583794', 'DauMyBao2486', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5007, 1, '61585445895454', 'VoPhatThien531', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5008, 1, '61585759441385', 'MacQuocThinh1405', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5009, 1, '61585868304885', 'LeDuyViet191', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5010, 1, '61585676643489', 'TonNhatThanh8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5011, 1, '61585426187874', 'AuThienAnh897', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5012, 1, '61585574409261', 'NgoPhuKhanh7808', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5013, 1, '61585449346017', 'MacHoangHuy855', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5014, 1, '61585613916804', 'VoPhatUyen6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5015, 1, '61585751911410', 'AuPhatNam0', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5016, 1, '61585914682423', 'DangKhoiThien33', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5017, 1, '61585934243006', 'TongLienNgoc2800', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5018, 1, '61585634917620', 'AuNganKhanh1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5019, 1, '61585880994371', 'NguyenThanhHan7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5020, 1, '61585565949899', 'DauKyLinh33', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5021, 1, '61585814696842', 'HoangTanKhanh48', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5022, 1, '61585520473295', 'PhanVinhThao5605', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5023, 1, '61585930731605', 'PhanLienVy7721', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5024, 1, '61585632785715', 'PhanPhuAnh646', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5025, 1, '61585556679972', 'MaiHuuAnh7312', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5026, 1, '61585482043093', 'TrinhTriKhoa8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5027, 1, '61585403717314', 'MaiHuuNgoc55', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5028, 1, '61585805727456', 'NgoGiaNguyen6328', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5029, 1, '61585928241432', 'ChauDuyMinh99', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5030, 1, '61585811877011', 'BuiHienLong47679', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5031, 1, '61585505023797', 'AuNamPhat462', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5032, 1, '61585550830984', 'KhuatTanThinh91', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5033, 1, '61585696832302', 'NguyenCongHau410', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5034, 1, '61585405576930', 'NgoKimPhuc8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5035, 1, '61585434705744', 'NguyenHaNam801', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5036, 1, '61585807288057', 'DoPhuPhat3427', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5037, 1, '61585810497321', 'DoMinhThanh675', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5038, 1, '61585652104830', 'NguyenNganPhat4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5039, 1, '61585756649954', 'BuiKienMinh412', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5040, 1, '61585557281154', 'TaNgocThinh7800', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5041, 1, '61585654805182', 'DauVyKhoa13', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5042, 1, '61585733882097', 'BuiKhanhLinh8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5043, 1, '61585890294672', 'TrinhLongThanh119', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5044, 1, '61585392737913', 'VoLeMy40512', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5045, 1, '61585863924738', 'MacLinhUyen6037', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5046, 1, '61585605608408', 'NgoHoangKhanh52171', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5047, 1, '61585872924055', 'ChauNhat14', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5048, 1, '61585631945925', 'PhanThaoVan7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5049, 1, '61585651206532', 'NgoNhatTri7863', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5050, 1, '61585444184555', 'TranTamKhanh8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5051, 1, '61585833686294', 'AuVinhUyen94338', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5052, 1, '61585890535358', 'DoanNhatHuy15', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5053, 1, '61585463055762', 'NgoPhucNgoc48078', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5054, 1, '61585734092004', 'TranLongVan5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5055, 1, '61585752149910', 'MaiDinhVinh4', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5056, 1, '61585884683611', 'TongNgocThien391', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5057, 1, '61585616528078', 'DoLanKhoa6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5058, 1, '61585621357127', 'QuachKimLinh97232', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5059, 1, '61585558179616', 'TonTruongAn91995', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5060, 1, '61585852165674', 'HuynhDinhTrung2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5061, 1, '61585498332907', 'HaKyAnh65', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5062, 1, '61585930972590', 'TranVanThanh2275', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5063, 1, '61585413106132', 'KhuatPhuongNgoc22', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5064, 1, '61585815807319', 'QuachHaiAn928', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5065, 1, '61585391897541', 'HaTrang97', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5066, 1, '61585895483065', 'PhanMaiThien5910', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5067, 1, '61585437856830', 'DinhLienQuan7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5068, 1, '61585440557081', 'DuongVyThanh6423', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5069, 1, '61585938261895', 'HaKimNgoc612', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5070, 1, '61585703434674', 'DauHaiHuy77', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5071, 1, '61585707451834', 'BuiHuuSon1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5072, 1, '61585944920359', 'KhuatKimNam55', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5073, 1, '61585525660964', 'LaXuanYen37688', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5074, 1, '61585627537613', 'DoNam36', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5075, 1, '61585428285190', 'TrinhVanUyen24', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5076, 1, '61585714412035', 'TrinhKyThao120', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5077, 1, '61585923771798', 'TongKyAn94', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5078, 1, '61585923983783', 'TrinhSonAnh98735', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5079, 1, '61585816018507', 'TongNhatQuan1435', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5080, 1, '61585524520752', 'CaoKhoiNam96741', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5081, 1, '61585636267372', 'HaNam65', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5082, 1, '61585386317999', 'TranKimHan9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5083, 1, '61585900252924', 'HaKyNam1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5084, 1, '61585483094292', 'VuTriKhanh92', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5085, 1, '61585689784813', 'DoYenPhu2', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5086, 1, '61585698634548', 'QuachQuocVan852', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5087, 1, '61585634887115', 'MacPhatPhuc6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5088, 1, '61585436386834', 'QuachTanMy8821', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5089, 1, '61585442356671', 'CaoKienMy57', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5090, 1, '61585766611064', 'MaiLinhBao33', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5091, 1, '61585515670949', 'VoMinhHan17', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5092, 1, '61585875206049', 'LyLuuMy904', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5093, 1, '61585698512991', 'PhanQuanKhoa3706', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5094, 1, '61585676315201', 'DuongNganLong86735', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5095, 1, '61585878534367', 'TranThinhAnh43778', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5096, 1, '61585912882028', 'MaiTanDuy5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5097, 1, '61585826697063', 'DinhThaoLinh2554', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5098, 1, '61585809958502', 'MaiKimNgan4199', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5099, 1, '61585767571314', 'TonVinhThao5507', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5100, 1, '61585389947281', 'TranLeBao746', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5101, 1, '61585520172835', 'HuynhNgocLong77983', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5102, 1, '61585888524911', 'TonXuanHan726', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5103, 1, '61585742610414', 'AuGiaKhanh4608', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5104, 1, '61585425076504', 'QuachQuanKhanh3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5105, 1, '61585538320145', 'HaChiTai38', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5106, 1, '61585573930707', 'HuynhTruongThanh9169', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5107, 1, '61585466175410', 'KhuatThienHuy605', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5108, 1, '61585692273942', 'ChauVanKhanh45485', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5109, 1, '61585691733793', 'TaTrong30350', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5110, 1, '61585583648296', 'LyKienThien284', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5111, 1, '61585613438750', 'DauNgocQuan2455', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5112, 1, '61585483124365', 'LaKimThinh62024', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5113, 1, '61585423007881', 'LyHoangKhanh7618', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5114, 1, '61585413046265', 'HuynhLanPhu61', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5115, 1, '61585720561402', 'PhungPhat337', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5116, 1, '61585836657480', 'PhungLinhUyen22737', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5117, 1, '61585798918701', 'QuachThienBao325', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5118, 1, '61585525212776', 'LeQuocSon2118', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5119, 1, '61585664945952', 'PhanLeThanh6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5120, 1, '61585638097659', 'ToChiDung6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5121, 1, '61585932471140', 'ChauMinhThanh66', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5122, 1, '61585949900334', 'VoThaiYen3220', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5123, 1, '61585903254450', 'ChauLeMy60060', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5124, 1, '61585588268384', 'DangPhuong64547', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5125, 1, '61585574558881', 'DinhMaiSon1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5126, 1, '61585688794651', 'TonThienNam7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5127, 1, '61585811157424', 'DauNga5250', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5128, 1, '61585731632716', 'TrinhMinhKhoa4966', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5129, 1, '61585941140553', 'TrinhLanQuan78925', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5130, 1, '61585822016711', 'NgoQuocAnh9570', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5131, 1, '61585924131678', 'MacVyPhat3116', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5132, 1, '61585782450582', 'HoTanUyen49', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5133, 1, '61585704574329', 'VoKhanhPhuc7207', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5134, 1, '61585819557181', 'QuachLePhat7', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5135, 1, '61585638515371', 'TranSonLinh13867', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5136, 1, '61585939970926', 'DauCongLy9730', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5137, 1, '61585837826021', 'HuynhPhuongMy5', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5138, 1, '61585952150634', 'PhamDiemHan1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5139, 1, '61585601737839', 'DoanThaiKhoa5976', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03');
INSERT INTO `random_category_accounts` (`id`, `random_category_id`, `account_name`, `password`, `price`, `status`, `server`, `buyer_id`, `batch_id`, `note`, `note_buyer`, `thumbnail`, `created_at`, `updated_at`) VALUES
(5140, 1, '61585698692730', 'NguyenVyMinh40', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5141, 1, '61585544770300', 'PhungVanUyen613', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5142, 1, '61585524312524', 'TrinhLinh7644', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5143, 1, '61585756349995', 'DuongUyenNam5086', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5144, 1, '61585621328509', 'HoangMinhTri1264', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5145, 1, '61585658405025', 'TonBaoMinh961', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5146, 1, '61585466205278', 'VoMinh50', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5147, 1, '61585536701173', 'DoanPhuongVan403', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5148, 1, '61585817098648', 'VuVanVy71275', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5149, 1, '61585508352840', 'DauKienHan3', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5150, 1, '61585805547340', 'BuiMyVy8864', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5151, 1, '61585739160427', 'DoSonNgoc56', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5152, 1, '61585614488697', 'DauPhuThinh753', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5153, 1, '61585509671424', 'TranHoangMinh6', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5154, 1, '61585908384212', 'VoKienVan9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5155, 1, '61585630207476', 'PhamTruongThinh118', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5156, 1, '61585880635349', 'TonPhuongSon25698', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5157, 1, '61585943901211', 'VuHoangTri38327', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5158, 1, '61585400476784', 'DauMyLong1', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5159, 1, '61585777799878', 'QuachHaiThanh978', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5160, 1, '61585876644129', 'MaiLinhBao9', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5161, 1, '61585811999241', 'PhungThaoThien994', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5162, 1, '61585586437957', 'TranHaiHan6586', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5163, 1, '61585779448204', 'DinhGiaNhi60', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5164, 1, '61585882406002', 'QuachKimAn911', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5165, 1, '61585604317255', 'CaoDaThu9667', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5166, 1, '61585583230428', 'DoQuocThanh434', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5167, 1, '61585844515555', 'DuongNhatUyen8', 20000, 'sold', 1, 6, 'ORD-6a8698f150ffd', NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reward_items`
--

CREATE TABLE `reward_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `game_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `min_withdraw` int(11) NOT NULL DEFAULT 0,
  `max_withdraw` int(11) NOT NULL DEFAULT 0,
  `priority` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reward_items`
--

INSERT INTO `reward_items` (`id`, `icon`, `game_name`, `name`, `unit`, `code`, `min_withdraw`, `max_withdraw`, `priority`, `active`, `created_at`, `updated_at`) VALUES
(1, '/storage/reward-items/g8c8RCSzO2HvxmZL1N3UCr72utBC9Mlg97DoiTnn.gif', 'Free Fire', 'Kim Cương', 'Kim Cương', 'kc', 10, 5000, 0, 1, '2026-06-22 03:36:36', '2026-06-22 04:33:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `service_histories`
--

CREATE TABLE `service_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `game_service_id` bigint(20) UNSIGNED NOT NULL,
  `service_package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `game_account` varchar(255) NOT NULL,
  `game_password` varchar(255) NOT NULL,
  `server` int(11) NOT NULL,
  `amount` bigint(20) NOT NULL DEFAULT 0,
  `price` bigint(20) NOT NULL,
  `discount_code` varchar(255) DEFAULT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `service_packages`
--

CREATE TABLE `service_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_service_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` bigint(20) NOT NULL,
  `estimated_time` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `usdt_accounts`
--

CREATE TABLE `usdt_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `wallet_address` varchar(255) DEFAULT NULL,
  `qr_image` varchar(255) DEFAULT NULL,
  `api_token` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `usdt_accounts`
--

INSERT INTO `usdt_accounts` (`id`, `type`, `name`, `wallet_address`, `qr_image`, `api_token`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'binance', 'Binance Pay', '189', NULL, '7ec1d1ca11ee788a34c721f1090eab98', 1, '2026-07-07 14:12:36', '2026-07-07 14:12:36'),
(2, 'trc20', 'TRC20', 'TXXMADRkewAoxuwDijt9byS1cRzaFSZoAw', NULL, '435435', 1, '2026-07-07 14:43:57', '2026-07-07 14:57:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `usdt_deposits`
--

CREATE TABLE `usdt_deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `request_code` varchar(255) NOT NULL,
  `usdt_amount` decimal(10,2) NOT NULL,
  `exchange_rate` decimal(15,0) NOT NULL,
  `vnd_amount` decimal(15,0) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `referrer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `role` enum('member','admin') NOT NULL DEFAULT 'member',
  `balance` bigint(20) NOT NULL DEFAULT 0,
  `total_commission` bigint(20) NOT NULL DEFAULT 0,
  `total_deposited` bigint(20) NOT NULL DEFAULT 0,
  `gold` bigint(20) NOT NULL DEFAULT 0,
  `gem` bigint(20) NOT NULL DEFAULT 0,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  `ip_address` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `referrer_id`, `username`, `password`, `email`, `google_id`, `facebook_id`, `role`, `balance`, `total_commission`, `total_deposited`, `gold`, `gem`, `banned`, `ip_address`, `remember_token`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(6, NULL, 'admin', '$2y$12$iuI1DgTRgZygo7kqqxxOteJTdzAkfEYj7uDCBx4EJNu6IpOW28Heu', 'vodinhkiet130@gmail.com', NULL, NULL, 'admin', 66439999, 0, 0, 0, 0, 0, '::1', NULL, NULL, '2026-08-20 05:29:26', '2026-08-20 05:56:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `withdrawal_histories`
--

CREATE TABLE `withdrawal_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL,
  `type` enum('gold','gem') NOT NULL,
  `game` varchar(255) DEFAULT NULL,
  `character_name` varchar(255) NOT NULL,
  `server` varchar(255) DEFAULT NULL,
  `user_note` varchar(255) DEFAULT NULL,
  `admin_note` varchar(255) DEFAULT NULL,
  `status` enum('success','error','processing') NOT NULL DEFAULT 'processing',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `affiliate_histories`
--
ALTER TABLE `affiliate_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliate_histories_referrer_id_foreign` (`referrer_id`),
  ADD KEY `affiliate_histories_referred_id_foreign` (`referred_id`);

--
-- Chỉ mục cho bảng `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `bank_deposits`
--
ALTER TABLE `bank_deposits`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `bank_deposits_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `card_deposits`
--
ALTER TABLE `card_deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_deposits_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `configs_key_unique` (`key`);

--
-- Chỉ mục cho bảng `discount_codes`
--
ALTER TABLE `discount_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discount_codes_code_unique` (`code`);

--
-- Chỉ mục cho bảng `discount_code_usages`
--
ALTER TABLE `discount_code_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discount_code_usages_discount_code_id_foreign` (`discount_code_id`),
  ADD KEY `discount_code_usages_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `flash_sales`
--
ALTER TABLE `flash_sales`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `flash_sale_items`
--
ALTER TABLE `flash_sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flash_sale_items_flash_sale_id_foreign` (`flash_sale_id`);

--
-- Chỉ mục cho bảng `game_accounts`
--
ALTER TABLE `game_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_accounts_game_category_id_foreign` (`game_category_id`),
  ADD KEY `game_accounts_buyer_id_foreign` (`buyer_id`);

--
-- Chỉ mục cho bảng `game_categories`
--
ALTER TABLE `game_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_categories_game_group_id_foreign` (`game_group_id`);

--
-- Chỉ mục cho bảng `game_groups`
--
ALTER TABLE `game_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `game_groups_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `game_services`
--
ALTER TABLE `game_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `game_services_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `installments`
--
ALTER TABLE `installments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `installments_user_id_foreign` (`user_id`),
  ADD KEY `installments_game_account_id_foreign` (`game_account_id`);

--
-- Chỉ mục cho bảng `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_iso_code_unique` (`iso_code`);

--
-- Chỉ mục cho bảng `lucky_wheels`
--
ALTER TABLE `lucky_wheels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lucky_wheels_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `lucky_wheel_histories`
--
ALTER TABLE `lucky_wheel_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lucky_wheel_histories_user_id_foreign` (`user_id`),
  ADD KEY `lucky_wheel_histories_lucky_wheel_id_foreign` (`lucky_wheel_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `money_transactions`
--
ALTER TABLE `money_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `money_transactions_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `money_withdrawal_histories`
--
ALTER TABLE `money_withdrawal_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `money_withdrawal_histories_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_history_user_id_foreign` (`user_id`),
  ADD KEY `purchase_history_game_account_id_foreign` (`game_account_id`);

--
-- Chỉ mục cho bảng `random_categories`
--
ALTER TABLE `random_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `random_categories_slug_unique` (`slug`),
  ADD KEY `random_categories_game_group_id_foreign` (`game_group_id`);

--
-- Chỉ mục cho bảng `random_category_accounts`
--
ALTER TABLE `random_category_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `random_category_accounts_random_category_id_foreign` (`random_category_id`),
  ADD KEY `random_category_accounts_buyer_id_foreign` (`buyer_id`);

--
-- Chỉ mục cho bảng `reward_items`
--
ALTER TABLE `reward_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reward_items_code_unique` (`code`);

--
-- Chỉ mục cho bảng `service_histories`
--
ALTER TABLE `service_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_histories_user_id_foreign` (`user_id`),
  ADD KEY `service_histories_game_service_id_foreign` (`game_service_id`),
  ADD KEY `service_histories_service_package_id_foreign` (`service_package_id`);

--
-- Chỉ mục cho bảng `service_packages`
--
ALTER TABLE `service_packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_packages_game_service_id_foreign` (`game_service_id`);

--
-- Chỉ mục cho bảng `usdt_accounts`
--
ALTER TABLE `usdt_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `usdt_deposits`
--
ALTER TABLE `usdt_deposits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usdt_deposits_request_code_unique` (`request_code`),
  ADD KEY `usdt_deposits_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_referrer_id_foreign` (`referrer_id`);

--
-- Chỉ mục cho bảng `withdrawal_histories`
--
ALTER TABLE `withdrawal_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawal_histories_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `affiliate_histories`
--
ALTER TABLE `affiliate_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `card_deposits`
--
ALTER TABLE `card_deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `configs`
--
ALTER TABLE `configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `discount_codes`
--
ALTER TABLE `discount_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `discount_code_usages`
--
ALTER TABLE `discount_code_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `flash_sales`
--
ALTER TABLE `flash_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `flash_sale_items`
--
ALTER TABLE `flash_sale_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `game_accounts`
--
ALTER TABLE `game_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `game_categories`
--
ALTER TABLE `game_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `game_groups`
--
ALTER TABLE `game_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `game_services`
--
ALTER TABLE `game_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `installments`
--
ALTER TABLE `installments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `lucky_wheels`
--
ALTER TABLE `lucky_wheels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `lucky_wheel_histories`
--
ALTER TABLE `lucky_wheel_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `money_transactions`
--
ALTER TABLE `money_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1722;

--
-- AUTO_INCREMENT cho bảng `money_withdrawal_histories`
--
ALTER TABLE `money_withdrawal_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `random_categories`
--
ALTER TABLE `random_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `random_category_accounts`
--
ALTER TABLE `random_category_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5168;

--
-- AUTO_INCREMENT cho bảng `reward_items`
--
ALTER TABLE `reward_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `service_histories`
--
ALTER TABLE `service_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `service_packages`
--
ALTER TABLE `service_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `usdt_accounts`
--
ALTER TABLE `usdt_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `usdt_deposits`
--
ALTER TABLE `usdt_deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `withdrawal_histories`
--
ALTER TABLE `withdrawal_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `affiliate_histories`
--
ALTER TABLE `affiliate_histories`
  ADD CONSTRAINT `affiliate_histories_referred_id_foreign` FOREIGN KEY (`referred_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `affiliate_histories_referrer_id_foreign` FOREIGN KEY (`referrer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `bank_deposits`
--
ALTER TABLE `bank_deposits`
  ADD CONSTRAINT `bank_deposits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `card_deposits`
--
ALTER TABLE `card_deposits`
  ADD CONSTRAINT `card_deposits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `discount_code_usages`
--
ALTER TABLE `discount_code_usages`
  ADD CONSTRAINT `discount_code_usages_discount_code_id_foreign` FOREIGN KEY (`discount_code_id`) REFERENCES `discount_codes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discount_code_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `flash_sale_items`
--
ALTER TABLE `flash_sale_items`
  ADD CONSTRAINT `flash_sale_items_flash_sale_id_foreign` FOREIGN KEY (`flash_sale_id`) REFERENCES `flash_sales` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `game_accounts`
--
ALTER TABLE `game_accounts`
  ADD CONSTRAINT `game_accounts_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `game_accounts_game_category_id_foreign` FOREIGN KEY (`game_category_id`) REFERENCES `game_categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `game_categories`
--
ALTER TABLE `game_categories`
  ADD CONSTRAINT `game_categories_game_group_id_foreign` FOREIGN KEY (`game_group_id`) REFERENCES `game_groups` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `installments`
--
ALTER TABLE `installments`
  ADD CONSTRAINT `installments_game_account_id_foreign` FOREIGN KEY (`game_account_id`) REFERENCES `game_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `installments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `lucky_wheel_histories`
--
ALTER TABLE `lucky_wheel_histories`
  ADD CONSTRAINT `lucky_wheel_histories_lucky_wheel_id_foreign` FOREIGN KEY (`lucky_wheel_id`) REFERENCES `lucky_wheels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lucky_wheel_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `money_transactions`
--
ALTER TABLE `money_transactions`
  ADD CONSTRAINT `money_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `money_withdrawal_histories`
--
ALTER TABLE `money_withdrawal_histories`
  ADD CONSTRAINT `money_withdrawal_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD CONSTRAINT `purchase_history_game_account_id_foreign` FOREIGN KEY (`game_account_id`) REFERENCES `game_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `random_categories`
--
ALTER TABLE `random_categories`
  ADD CONSTRAINT `random_categories_game_group_id_foreign` FOREIGN KEY (`game_group_id`) REFERENCES `game_groups` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `random_category_accounts`
--
ALTER TABLE `random_category_accounts`
  ADD CONSTRAINT `random_category_accounts_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `random_category_accounts_random_category_id_foreign` FOREIGN KEY (`random_category_id`) REFERENCES `random_categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `service_histories`
--
ALTER TABLE `service_histories`
  ADD CONSTRAINT `service_histories_game_service_id_foreign` FOREIGN KEY (`game_service_id`) REFERENCES `game_services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_histories_service_package_id_foreign` FOREIGN KEY (`service_package_id`) REFERENCES `service_packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `service_packages`
--
ALTER TABLE `service_packages`
  ADD CONSTRAINT `service_packages_game_service_id_foreign` FOREIGN KEY (`game_service_id`) REFERENCES `game_services` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `usdt_deposits`
--
ALTER TABLE `usdt_deposits`
  ADD CONSTRAINT `usdt_deposits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_referrer_id_foreign` FOREIGN KEY (`referrer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `withdrawal_histories`
--
ALTER TABLE `withdrawal_histories`
  ADD CONSTRAINT `withdrawal_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
