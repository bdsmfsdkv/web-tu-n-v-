-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 28, 2026 lúc 02:03 PM
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
(2, 2, '434535', '32545', 100000, 'sold', 1, '5454', '[{\"key\":\"rank\",\"value\":\"Kim C\\u01b0\\u01a1ng\"},{\"key\":\"T\\u01af\\u1edaNG\",\"value\":\"100\"},{\"key\":\"Trang Ph\\u1ee5c\",\"value\":\"200\"},{\"key\":\"Ng\\u1ecdc\",\"value\":\"Full\"}]', '/storage/accounts/thumbnails/1782051466_493bcdbbcc5d7927a2dc29b80f8cee49.jpg', '\"[\\\"\\\\\\/storage\\\\\\/accounts\\\\\\/images\\\\\\/1782051466_1466f7bb91e18660647c5444eb7ca3f1.jpg\\\"]\"', '2026-06-21 14:17:46', '2026-06-22 10:42:33'),
(3, 2, '1213', '414', 100000, 'available', NULL, '2432', '[{\"key\":\"Rank\",\"value\":\"Kim C\\u01b0\\u01a1ng\"},{\"key\":\"T\\u01af\\u1edaNG\",\"value\":\"100\"},{\"key\":\"Trang Ph\\u1ee5c\",\"value\":\"200\"},{\"key\":\"Ng\\u1ecdc\",\"value\":\"Full\"}]', '/storage/accounts/thumbnails/1783476448_493bcdbbcc5d7927a2dc29b80f8cee49.jpg', '\"[\\\"\\\\\\/storage\\\\\\/accounts\\\\\\/images\\\\\\/1783476448_493bcdbbcc5d7927a2dc29b80f8cee49.jpg\\\",\\\"\\\\\\/storage\\\\\\/accounts\\\\\\/images\\\\\\/1783476448_1466f7bb91e18660647c5444eb7ca3f1.jpg\\\",\\\"\\\\\\/storage\\\\\\/accounts\\\\\\/images\\\\\\/1783476448_ce99c50c1ded9b396a083a5a992a38d6.jpg\\\"]\"', '2026-07-08 02:07:28', '2026-07-08 02:07:28');

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
(4, 'Acc Free Fire VIP', 'acc-free-fire-vip', 'Free Fire', '', '/storage/categories/1782146078_4f628121d15a22b14bf2fcf3366ab6f5.png', '42345235', 1, '2026-06-22 16:34:38', '2026-06-22 16:34:38', 2, 0, 50000, NULL, NULL);

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
(1, 'Liên Quân', 'lien-quan', '/storage/game-groups/1782031086_0c5afd4c6925f761e273af06c9e8a0d5.gif', 0, 1, '2026-06-21 08:38:06', '2026-06-21 08:38:06', NULL),
(2, 'Free Fire', 'free-fire', NULL, 1, 1, '2026-06-21 08:43:39', '2026-06-21 08:43:39', NULL);

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

--
-- Đang đổ dữ liệu cho bảng `installments`
--

INSERT INTO `installments` (`id`, `user_id`, `game_account_id`, `total_price`, `paid_amount`, `duration_days`, `expire_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 100000.00, 100000.00, 7, '2026-06-29 17:42:02', 'completed', '2026-06-22 10:42:02', '2026-06-22 10:42:33');

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

--
-- Đang đổ dữ liệu cho bảng `lucky_wheel_histories`
--

INSERT INTO `lucky_wheel_histories` (`id`, `user_id`, `lucky_wheel_id`, `spin_count`, `total_cost`, `reward_type`, `reward_amount`, `description`, `created_at`, `updated_at`) VALUES
(6, 1, 2, 1, 10000, 'random_account', 1, 'Nick VIP', '2026-06-22 17:25:07', '2026-06-22 17:25:07'),
(7, 1, 2, 1, 10000, 'item', 19, '19 Kim Cương', '2026-06-22 17:25:56', '2026-06-22 17:25:56'),
(8, 1, 2, 1, 10000, 'random_account', 1, 'Nick VIP', '2026-06-22 17:26:10', '2026-06-22 17:26:10'),
(9, 1, 2, 1, 10000, 'item', 19, '19 Kim Cương', '2026-06-22 17:26:19', '2026-06-22 17:26:19'),
(10, 1, 2, 1, 10000, 'random_account', 1, 'Nick VIP', '2026-06-22 17:26:23', '2026-06-22 17:26:23'),
(11, 1, 2, 1, 10000, 'empty', 0, 'Mất lượt', '2026-06-22 17:26:31', '2026-06-22 17:26:31'),
(12, 1, 2, 1, 10000, 'money', 20000, '20000 VNĐ', '2026-06-22 17:26:38', '2026-06-22 17:26:38'),
(13, 1, 2, 1, 10000, 'empty', 0, 'Mất lượt', '2026-06-22 17:27:06', '2026-06-22 17:27:06'),
(14, 1, 2, 1, 10000, 'item', 999, '999 Kim Cương', '2026-06-22 17:27:18', '2026-06-22 17:27:18'),
(15, 1, 2, 1, 10000, 'item', 19, '19 Kim Cương', '2026-06-22 17:27:26', '2026-06-22 17:27:26'),
(16, 1, 2, 1, 10000, 'empty', 0, 'Mất lượt', '2026-06-22 17:27:31', '2026-06-22 17:27:31'),
(17, 1, 2, 1, 10000, 'item', 19, '19 Kim Cương', '2026-06-22 17:27:39', '2026-06-22 17:27:39'),
(18, 1, 2, 1, 10000, 'item', 19, '19 Kim Cương', '2026-06-22 17:28:51', '2026-06-22 17:28:51'),
(19, 1, 2, 1, 10000, 'item', 999, '999 Kim Cương', '2026-06-22 17:29:11', '2026-06-22 17:29:11'),
(20, 1, 2, 1, 10000, 'empty', 0, 'Mất lượt', '2026-06-22 17:57:13', '2026-06-22 17:57:13'),
(21, 1, 2, 1, 10000, 'random_account', 1, 'Nick VIP', '2026-06-23 07:06:41', '2026-06-23 07:06:41'),
(22, 1, 2, 1, 10000, 'random_account', 1, 'Nick VIP', '2026-06-23 07:06:54', '2026-06-23 07:06:54'),
(23, 1, 2, 1, 10000, 'empty', 0, 'Mất lượt', '2026-06-23 07:07:18', '2026-06-23 07:07:18'),
(24, 1, 2, 1, 10000, 'empty', 0, 'Mất lượt', '2026-06-23 07:07:25', '2026-06-23 07:07:25'),
(25, 1, 2, 1, 10000, 'random_account', 1, 'Nick VIP', '2026-06-23 07:07:35', '2026-06-23 07:07:35'),
(26, 1, 2, 1, 10000, 'item', 19, '19 Kim Cương', '2026-06-23 07:07:42', '2026-06-23 07:07:42'),
(27, 1, 2, 1, 10000, 'random_account', 1, 'Nick VIP', '2026-06-23 07:07:50', '2026-06-23 07:07:50'),
(28, 1, 2, 1, 10000, 'empty', 0, 'Mất lượt', '2026-06-23 07:07:58', '2026-06-23 07:07:58'),
(29, 1, 2, 1, 10000, 'item', 999, '999 Kim Cương', '2026-06-23 07:08:05', '2026-06-23 07:08:05'),
(30, 1, 2, 1, 10000, 'random_account', 1, 'Nick VIP', '2026-06-23 07:08:17', '2026-06-23 07:08:17'),
(31, 1, 2, 1, 10000, 'empty', 0, 'Mất lượt', '2026-06-23 07:09:24', '2026-06-23 07:09:24'),
(32, 1, 2, 1, 10000, 'empty', 0, 'Mất lượt', '2026-06-23 07:10:05', '2026-06-23 07:10:05'),
(33, 1, 2, 1, 10000, 'empty', 0, 'Mất lượt', '2026-06-23 07:10:12', '2026-06-23 07:10:12'),
(34, 1, 2, 1, 10000, 'item', 15555, '15555 Kim Cương', '2026-06-23 07:10:19', '2026-06-23 07:10:19'),
(35, 1, 2, 1, 10000, 'random_account', 1, 'Nick VIP', '2026-06-23 07:10:35', '2026-06-23 07:10:35'),
(36, 1, 2, 1, 10000, 'empty', 0, 'Mất lượt', '2026-06-23 07:10:43', '2026-06-23 07:10:43'),
(37, 1, 2, 1, 10000, 'random_account', 1, 'Nick VIP', '2026-06-23 07:10:54', '2026-06-23 07:10:54'),
(38, 1, 2, 1, 10000, 'item', 19, '19 Kim Cương', '2026-06-23 07:11:08', '2026-06-23 07:11:08'),
(39, 1, 2, 1, 10000, 'item', 19, '19 Kim Cương', '2026-06-23 07:11:16', '2026-06-23 07:11:16'),
(40, 1, 2, 1, 10000, 'item', 19, '19 Kim Cương', '2026-07-07 15:18:58', '2026-07-07 15:18:58'),
(41, 1, 2, 1, 10000, 'empty', 0, 'Mất lượt', '2026-07-07 15:19:12', '2026-07-07 15:19:12');

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
(1, 1, 'deposit', 200000, 0, 200000, 'Admin cập nhật số dư', NULL, '2026-06-20 15:34:23', '2026-06-20 15:34:23'),
(2, 1, 'purchase', -20000, 200000, 180000, 'Mua tài khoản #1', '1', '2026-06-20 15:36:18', '2026-06-20 15:36:18'),
(3, 1, 'purchase', -150, 180000, 179850, 'Mua tài khoản random #1 từ danh mục ACC RAMDUM 20K', 'RA-1', '2026-06-20 16:01:09', '2026-06-20 16:01:09'),
(4, 1, 'purchase', -150, 179850, 179700, 'Mua tài khoản random #2 từ danh mục ACC RAMDUM 20K', 'RA-2', '2026-06-20 16:01:09', '2026-06-20 16:01:09'),
(5, 1, 'deposit', 10000, 179700, 189700, 'Nạp tiền qua OCB - Mã giao dịch: FT261732685J', 'FT261732685J', '2026-06-21 09:28:19', '2026-06-21 09:28:19'),
(6, 1, 'deposit', 10000, 189700, 199700, 'Nạp tiền qua OCB - Mã giao dịch: FT261734Q5TW', 'FT261734Q5TW', '2026-06-21 09:28:19', '2026-06-21 09:28:19'),
(7, 1, 'purchase', -20000, 24700, 4700, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a37d059bc5dc)', 'RA-3', '2026-06-21 11:51:53', '2026-06-21 11:51:53'),
(8, 1, 'deposit', 495300, 4700, 500000, 'Admin cập nhật số dư', NULL, '2026-06-22 10:40:56', '2026-06-22 10:40:56'),
(9, 1, 'purchase', -20000, 400000, 380000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a3912075801a)', 'RA-4', '2026-06-22 10:44:23', '2026-06-22 10:44:23'),
(10, 1, 'purchase', -20000, 380000, 360000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a3912075801a)', 'RA-5', '2026-06-22 10:44:23', '2026-06-22 10:44:23'),
(11, 1, 'purchase', -20000, 360000, 340000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a3912075801a)', 'RA-6', '2026-06-22 10:44:23', '2026-06-22 10:44:23'),
(12, 1, 'purchase', -20000, 340000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a39449515288)', 'RA-7', '2026-06-22 14:20:05', '2026-06-22 14:20:05'),
(13, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1803', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(14, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1804', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(15, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1805', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(16, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1806', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(17, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1807', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(18, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1808', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(19, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1809', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(20, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1810', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(21, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1811', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(22, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1812', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(23, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1813', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(24, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1814', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(25, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1815', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(26, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1816', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(27, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1817', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(28, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1818', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(29, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1819', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(30, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1820', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(31, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1821', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(32, 1, 'purchase', 0, 320000, 320000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a396c9d19fc6)', 'RA-1822', '2026-06-22 17:10:53', '2026-06-22 17:10:53'),
(33, 1, 'deposit', 100000, 0, 100000, 'Admin cập nhật số dư', NULL, '2026-07-07 15:18:23', '2026-07-07 15:18:23'),
(34, 1, 'purchase', -20000, 80000, 60000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a4db2f089683)', 'RA-3485', '2026-07-08 02:16:16', '2026-07-08 02:16:16'),
(35, 1, 'purchase', -20000, 60000, 40000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a4db67398a94)', 'RA-3486', '2026-07-08 02:31:15', '2026-07-08 02:31:15'),
(36, 1, 'purchase', -20000, 40000, 20000, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a4db67398a94)', 'RA-3487', '2026-07-08 02:31:15', '2026-07-08 02:31:15'),
(37, 1, 'purchase', -20000, 20000, 0, 'Mua tài khoản random từ danh mục ACC RAMDUM 20K (Đơn: ORD-6a4db67398a94)', 'RA-3488', '2026-07-08 02:31:15', '2026-07-08 02:31:15');

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
(2, 'fa-fas fa-upload', 'test', '2026-06-22 10:25:59', '2026-06-22 10:25:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 1, '1', '2', 150, 'sold', 1, 1, NULL, '4535634', '63467457', '/storage/random-accounts/1781970946_86cba7abfcbb137bb811d21169b95521.jpg', '2026-06-20 15:55:46', '2026-06-20 15:55:46'),
(2, 1, '2', '5', 150, 'sold', 1, 1, NULL, '4535634', '63467457', '/storage/random-accounts/1781970946_86cba7abfcbb137bb811d21169b95521.jpg', '2026-06-20 15:55:46', '2026-06-20 15:55:46'),
(3, 1, '54363456', NULL, 20000, 'sold', 1, 1, 'ORD-6a37d059bc5dc', '32634567575', '747456746587', NULL, '2026-06-21 11:51:27', '2026-06-21 11:51:27'),
(4, 1, '4', NULL, 20000, 'sold', 1, 1, 'ORD-6a3912075801a', '32634567575', '747456746587', NULL, '2026-06-21 11:51:27', '2026-06-21 11:51:27'),
(5, 1, '35', NULL, 20000, 'sold', 1, 1, 'ORD-6a3912075801a', '32634567575', '747456746587', NULL, '2026-06-21 11:51:27', '2026-06-21 11:51:27'),
(6, 1, '436', NULL, 20000, 'sold', 1, 1, 'ORD-6a3912075801a', '32634567575', '747456746587', NULL, '2026-06-21 11:51:27', '2026-06-21 11:51:27'),
(7, 1, '43567', NULL, 20000, 'sold', 1, 1, 'ORD-6a39449515288', '32634567575', '747456746587', NULL, '2026-06-21 11:51:27', '2026-06-21 11:51:27'),
(1803, 1, '61585443820354', 'KhuatXuanLong8', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1804, 1, '61585355536442', 'ChauLienTri6', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1805, 1, '61585736396576', 'HuynhThaiYen669', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1806, 1, '61585692840533', 'TongNgocAn68723', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1807, 1, '61585778573693', 'TongTanAnh2222', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1808, 1, '61585777344533', 'KhuatQuanBao52', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1809, 1, '61585881085644', 'MaiMyHuy4892', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1810, 1, '61585709731181', 'MaiVyPhuc49', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1811, 1, '61585414573760', 'PhamMinhHuy85', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1812, 1, '61585586104233', 'VuMinhSon70', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1813, 1, '61585723530262', 'HoangChiThien4105', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1814, 1, '61585394172481', 'HoTamAn0', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1815, 1, '61585811784748', 'DinhMinhThien29794', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1816, 1, '61585502678516', 'ToUyenYen42632', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1817, 1, '61585860081321', 'NguyenPhuPhuc0', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1818, 1, '61585596272927', 'ToKienHan4054', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1819, 1, '61585822012594', 'LyQuanNgoc38565', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1820, 1, '61585706730201', 'PhungUyenAn19236', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1821, 1, '61585428373402', 'VoXuanAn5', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(1822, 1, '61585580044716', 'LyVySon144', 0, 'sold', 1, 1, 'ORD-6a396c9d19fc6', NULL, NULL, NULL, '2026-06-22 17:10:31', '2026-06-22 17:10:31'),
(3485, 1, 'Tài khoản: agfoqs742@banhgiay.com', '', 20000, 'sold', 1, 1, 'ORD-6a4db2f089683', NULL, NULL, NULL, '2026-06-22 17:14:49', '2026-06-22 17:14:49'),
(3486, 1, '61585443820354', 'KhuatXuanLong8', 20000, 'sold', 1, 1, 'ORD-6a4db67398a94', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3487, 1, '61585355536442', 'ChauLienTri6', 20000, 'sold', 1, 1, 'ORD-6a4db67398a94', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3488, 1, '61585736396576', 'HuynhThaiYen669', 20000, 'sold', 1, 1, 'ORD-6a4db67398a94', NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3489, 1, '61585692840533', 'TongNgocAn68723', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3490, 1, '61585778573693', 'TongTanAnh2222', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3491, 1, '61585777344533', 'KhuatQuanBao52', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3492, 1, '61585881085644', 'MaiMyHuy4892', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3493, 1, '61585709731181', 'MaiVyPhuc49', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3494, 1, '61585414573760', 'PhamMinhHuy85', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3495, 1, '61585586104233', 'VuMinhSon70', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3496, 1, '61585723530262', 'HoangChiThien4105', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3497, 1, '61585394172481', 'HoTamAn0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3498, 1, '61585811784748', 'DinhMinhThien29794', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3499, 1, '61585502678516', 'ToUyenYen42632', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3500, 1, '61585860081321', 'NguyenPhuPhuc0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3501, 1, '61585596272927', 'ToKienHan4054', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3502, 1, '61585822012594', 'LyQuanNgoc38565', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3503, 1, '61585706730201', 'PhungUyenAn19236', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3504, 1, '61585428373402', 'VoXuanAn5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3505, 1, '61585580044716', 'LyVySon144', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3506, 1, '61585517346124', 'DuongDuyen7475', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3507, 1, '61585391712442', 'VoLinhPhuc73', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3508, 1, '61585563994623', 'VuMaiPhu5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3509, 1, '61585764297931', 'AuVanThao62331', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3510, 1, '61585845593368', 'LyMyQuan31', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3511, 1, '61585472858504', 'KhuatTruongNgan8422', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3512, 1, '61585834042816', 'DoKyNgan702', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3513, 1, '61585503520285', 'DoNamThao1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3514, 1, '61585510927399', 'QuachLanVan9978', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3515, 1, '61585424383431', 'LaLongNgoc1164', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3516, 1, '61585507327147', 'DoanAnhKhoa7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3517, 1, '61585414153895', 'MacTrungAn1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3518, 1, '61585602515084', 'MaiVanPhu83270', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3519, 1, '61585787155881', 'QuachTriQuan1897', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3520, 1, '61585692117656', 'LyVanAn945', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3521, 1, '61585762105096', 'HoVanKhanh78', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3522, 1, '61585458431768', 'DinhHuuVan603', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3523, 1, '61585466889786', 'AuQuanVan6292', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3524, 1, '61585602752585', 'DangThienKhoa7314', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3525, 1, '61585388292806', 'ChauXuanThinh670', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3526, 1, '61585726675898', 'DauYenNgan36699', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3527, 1, '61585612562046', 'MaiTriDuy44460', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3528, 1, '61585466112670', 'MaiTriVan84059', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3529, 1, '61585804439384', 'HoangLinhDuy65', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3530, 1, '61585391202279', 'DoanThanhDuy29', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3531, 1, '61585625643945', 'TranMyThao1085', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3532, 1, '61585643613192', 'LyKhoiThinh77684', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3533, 1, '61585644000302', 'TranThinh98', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3534, 1, '61585370953148', 'PhamKienBao415', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3535, 1, '61585534175209', 'DuongVanKhoa66', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3536, 1, '61585665002108', 'CaoLuuVan9840', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3537, 1, '61585462839687', 'LyPhuDuy37', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3538, 1, '61585710148022', 'VoDinhMinh120', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3539, 1, '61585404222868', 'AuDinhVinh226', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3540, 1, '61585600593431', 'DoKyNgan85124', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3541, 1, '61585700518501', 'DuongThaiTri203', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3542, 1, '61585380013778', 'TrinhThanhLong92378', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3543, 1, '61585736188618', 'TongVanYen55016', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3544, 1, '61585839353765', 'ToLuuKhoa6369', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3545, 1, '61585416523772', 'LyQuocNgoc9365', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3546, 1, '61585569366684', 'NgoPhucNam3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3547, 1, '61585701447277', 'DangLuuAnh8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3548, 1, '61585604286388', 'TranMinhPhu8604', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3549, 1, '61585833325284', 'MaiQuanTri56', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3550, 1, '61585697848746', 'TrinhMaiAn2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3551, 1, '61585660379508', 'HuynhLeLinh510', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3552, 1, '61585863622385', 'QuachMyPhu85', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3553, 1, '61585440586761', 'PhungTruongVan200', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3554, 1, '61585730612937', 'VoLeUyen412', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3555, 1, '61585841004717', 'LyXuanKhoa66', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3556, 1, '61585858374129', 'TranHienQuan3312', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3557, 1, '61585560274592', 'PhanYenTri4100', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3558, 1, '61585858882558', 'ChauTrungHuy41311', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3559, 1, '61585800089408', 'DuongVyAn2022', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3560, 1, '61585654230696', 'TranPhuMinh185', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3561, 1, '61585666919533', 'HoangHoangPhuc2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3562, 1, '61585422883629', 'KhuatLienKhanh93', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3563, 1, '61585397682591', 'MaiPhatThien75', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3564, 1, '61585464825314', 'DauNganAn31001', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3565, 1, '61585441152682', 'PhungPhuongNgoc176', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3566, 1, '61585679009610', 'ChauDuyThai85', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3567, 1, '61585467640706', 'BuiThanhNgan1810', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3568, 1, '61585662450454', 'LeTriThinh9869', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3569, 1, '61585422223488', 'QuachAnhThu796', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3570, 1, '61585474718402', 'CaoLeBao9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3571, 1, '61585866892366', 'BuiUyenVy0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3572, 1, '61585443970249', 'TranQuocThinh75939', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3573, 1, '61585863680152', 'VuYenPhuc3251', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3574, 1, '61585447903466', 'QuachThinhUyen15', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3575, 1, '61585768194655', 'QuachTriPhat7252', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3576, 1, '61585805695095', 'TaNamTri16', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3577, 1, '61585711437587', 'DauMinhDuy76192', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3578, 1, '61585524339708', 'TongLeNam758', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3579, 1, '61585489240474', 'DangKhanh1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3580, 1, '61585482672061', 'HoangDiemPhuong940', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3581, 1, '61585484981608', 'KhuatAnhDung2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3582, 1, '61585633953593', 'DoanTruongTri45917', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3583, 1, '61585549359097', 'VoYenPhuc4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3584, 1, '61585377643891', 'QuachTanNgan73700', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3585, 1, '61585464608606', 'TrinhHienMinh23', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3586, 1, '61585657710375', 'VuKyPhat3483', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3587, 1, '61585882431369', 'DauHuuPhu9107', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3588, 1, '61585488880216', 'PhanVanTri2691', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3589, 1, '61585615232115', 'NgoCongTri757', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3590, 1, '61585465992485', 'MaiKienThanh54', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3591, 1, '61585468362528', 'DoanTrungThinh303', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3592, 1, '61585390752485', 'DuongTanHuy15', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3593, 1, '61585862423593', 'TranHuuVan444', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3594, 1, '61585759827286', 'MacMyMinh61', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3595, 1, '61585714200717', 'ToPhuongAn50', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3596, 1, '61585404461941', 'VuTanLong29', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3597, 1, '61585447120127', 'PhanLuuThanh653', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3598, 1, '61585626005311', 'AuGiaQuan18', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3599, 1, '61585677838467', 'DoKimHuy15797', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3600, 1, '61585615384644', 'QuachHoangBao487', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3601, 1, '61585633774839', 'PhanLePhu660', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3602, 1, '61585459751370', 'PhanThinhNam1652', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3603, 1, '61585611335813', 'VuPhuongThao8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3604, 1, '61585360906909', 'KhuatLienNgoc1888', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3605, 1, '61585420781534', 'PhanTrungNgoc746', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3606, 1, '61585606084948', 'TranThaoPhu52', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3607, 1, '61585749384697', 'DinhLongAnh5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3608, 1, '61585568767007', 'ToThaiThanh57', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3609, 1, '61585837494899', 'CaoQuang8123', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3610, 1, '61585701208856', 'HoangSonAn432', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3611, 1, '61585671359248', 'DuongKimHuy3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3612, 1, '61585465182930', 'HaKhanhDuy1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3613, 1, '61585799335127', 'ToQuocKhanh9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3614, 1, '61585718010187', 'DoVyNgan84', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3615, 1, '61585409771610', 'DangDuyViet99', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3616, 1, '61585783195986', 'HuynhThanhDuy6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3617, 1, '61585726379873', 'LaNgocPhu2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3618, 1, '61585661579860', 'DauKhanhLong6369', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3619, 1, '61585380915978', 'HoangThaoLong6282', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3620, 1, '61585675412769', 'MaiThaoMy8724', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3621, 1, '61585798343389', 'AuQuyen1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3622, 1, '61585558538475', 'PhamMinhKhanh30037', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3623, 1, '61585574524797', 'HoangThaoLinh36484', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3624, 1, '61585531236478', 'DuongTanHan89', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3625, 1, '61585369574557', 'TaTamSon29', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3626, 1, '61585649826942', 'TranThinhHan28399', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3627, 1, '61585730936922', 'CaoSonPhuc2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3628, 1, '61585598586537', 'DoKienLinh37', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3629, 1, '61585960371802', 'TaHaQuan4124', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3630, 1, '61585723436250', 'LeDiemHan21', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3631, 1, '61585715788326', 'HaVinhPhuc10', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3632, 1, '61585453779393', 'HoangSonBao91', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3633, 1, '61585732533017', 'PhanAnhMinh1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3634, 1, '61585559795968', 'PhamQuocKhoa5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3635, 1, '61585551513200', 'DinhLanHan303', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3636, 1, '61585737989202', 'MacHaThien94', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3637, 1, '61585360603982', 'MaiTruongPhat32075', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3638, 1, '61585868062309', 'LyLeThien0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3639, 1, '61585902051994', 'NguyenKienThao42015', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3640, 1, '61585565524770', 'DuongHaLinh6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3641, 1, '61585741377171', 'ChauPhuPhuc90', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3642, 1, '61585607463481', 'DoHaKhanh45', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3643, 1, '61585721580102', 'TrinhVanMinh753', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3644, 1, '61585558745767', 'NguyenLuuAnh61', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3645, 1, '61585393725044', 'QuachMyLinh4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3646, 1, '61585501210858', 'QuachQuocLinh2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3647, 1, '61585595915853', 'KhuatTriPhat112', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3648, 1, '61585787215437', 'VuThanhPhat157', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3649, 1, '61585749836071', 'KhuatNgocUyen172', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3650, 1, '61585722027342', 'MaiHuuSon8702', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3651, 1, '61585845471382', 'DoLienNgoc9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3652, 1, '61585713299377', 'TaVanKhanh16425', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3653, 1, '61585393782536', 'AuLeSon529', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3654, 1, '61585714497873', 'AuVanHuy47766', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3655, 1, '61585881022813', 'CaoHaLinh63', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3656, 1, '61585492449856', 'PhungDiemHan91', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3657, 1, '61585722327117', 'PhanHung723', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3658, 1, '61585386466777', 'LyGiaThuan3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3659, 1, '61585759854296', 'MacKienHan50', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3660, 1, '61585592825919', 'DinhDuyThanh8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3661, 1, '61585493437989', 'DoUyenMinh51', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3662, 1, '61585804735077', 'VuVan3581', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3663, 1, '61585871030352', 'ToBinhAn111', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3664, 1, '61585763158336', 'ToNhatThao146', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3665, 1, '61585349027276', 'HuynhNam197', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3666, 1, '61585792464031', 'TranNgan902', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3667, 1, '61585407165655', 'HaNganAn80715', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3668, 1, '61585434400854', 'TongVanPhat98075', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3669, 1, '61585358175521', 'ToVanThanh5779', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3670, 1, '61585482578735', 'AuTanTri12363', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3671, 1, '61585655043760', 'HaHoangThien44', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3672, 1, '61585835873984', 'TrinhThaiAn401', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3673, 1, '61585584035334', 'TranPhatPhu6085', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3674, 1, '61585498059876', 'TranNgocQuan3722', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3675, 1, '61585686718602', 'HoangVanAn37', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3676, 1, '61585599305264', 'VuKhanhAnh236', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3677, 1, '61585543301839', 'MaiKyNgoc16', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3678, 1, '61585551662387', 'HuynhQuocKhoa5092', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3679, 1, '61585722837429', 'KhuatNgocMy8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3680, 1, '61585543448828', 'NgoTriLong5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3681, 1, '61585700009623', 'LePhatNgan6564', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3682, 1, '61585665989239', 'TonNhatKhoa1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3683, 1, '61585782266083', 'VuHoangPhuc45850', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3684, 1, '61585609262005', 'PhanUyenTri2992', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3685, 1, '61585571974662', 'LeLeUyen509', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3686, 1, '61585361926741', 'NguyenYenMinh481', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3687, 1, '61585459659082', 'HoangXuanMinh5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3688, 1, '61585680808852', 'AuNhatMy7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3689, 1, '61585864283922', 'CaoLongNgoc9618', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3690, 1, '61585445709732', 'ChauKyLinh6360', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3691, 1, '61585792463790', 'DuongQuocAn783', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3692, 1, '61585592734272', 'DangTanQuan1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3693, 1, '61585561928491', 'TongTriThien3440', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3694, 1, '61585443942463', 'NgoMinh74', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3695, 1, '61585726677242', 'DoTruongKhoa8406', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3696, 1, '61585836263709', 'LyThaoAnh72285', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3697, 1, '61585472621249', 'HuynhTrungThanh97', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3698, 1, '61585847180653', 'DoanTamHan6621', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3699, 1, '61585822101788', 'ToKhoiVan27', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3700, 1, '61585551813510', 'MacQuanKhanh86645', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3701, 1, '61585870671888', 'TonAnhDung941', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3702, 1, '61585358836246', 'QuachTrungLinh137', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3703, 1, '61585370386549', 'HoNamDuy34', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3704, 1, '61585473490922', 'AuHaHuy647', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3705, 1, '61585633411315', 'VuThinhPhat93924', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3706, 1, '61585798012490', 'DoHanh9067', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3707, 1, '61585669143119', 'ToMaiPhat169', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3708, 1, '61585663470533', 'TongKimPhuc316', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3709, 1, '61585750135035', 'QuachPhuThien494', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3710, 1, '61585797653011', 'NgoTriPhu7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3711, 1, '61585342457636', 'DinhTriBao447', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3712, 1, '61585852970392', 'MaiVanDuy427', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3713, 1, '61585722176501', 'DauKhanhBao91267', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3714, 1, '61585575123775', 'TrinhTanYen62132', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3715, 1, '61585349144679', 'HoangTrungHuy835', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3716, 1, '61585638481501', 'HaKienVy38', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3717, 1, '61585513326303', 'TaVanMy8141', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3718, 1, '61585428610644', 'AuHoangUyen7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3719, 1, '61585449912192', 'DinhNganDuy55578', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3720, 1, '61585774586338', 'LeVyTri8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3721, 1, '61585421981780', 'HoNganHuy5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3722, 1, '61585855732815', 'HoangThienThao2041', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3723, 1, '61585865780491', 'DoanYenThien46', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3724, 1, '61585629633873', 'QuachHaNgoc243', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3725, 1, '61585670106027', 'DinhThaiAnh872', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3726, 1, '61585667969481', 'TranXuanVy5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3727, 1, '61585860832462', 'QuachSonLong7627', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3728, 1, '61585677330045', 'TongKyBao91', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3729, 1, '61585544529022', 'HoangPhatDuy4577', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3730, 1, '61585568827977', 'LaMinhPhu55498', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3731, 1, '61585688458243', 'DauLanHan915', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3732, 1, '61585913450095', 'TaVinhNam34984', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3733, 1, '61585749268911', 'LyLongBao7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3734, 1, '61585642594499', 'DuongKimHan16963', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3735, 1, '61585457832064', 'KhuatVinhBao33379', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3736, 1, '61585428463481', 'QuachTrungPhu7781', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3737, 1, '61585345787387', 'LyMaiBao0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3738, 1, '61585734598277', 'DoMaiThao7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3739, 1, '61585756734467', 'PhungKhanhUyen27', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3740, 1, '61585380613265', 'VuThinhMinh4844', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3741, 1, '61585496947753', 'TaTrungThao492', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3742, 1, '61585797745507', 'DauVanUyen29497', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3743, 1, '61585758774933', 'LaMai5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3744, 1, '61585848323211', 'VuMyPhuc71', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3745, 1, '61585707957980', 'QuachDiemPhuong144', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3746, 1, '61585418651477', 'HaLeSon47', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3747, 1, '61585717707534', 'BuiUyenKhanh48036', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3748, 1, '61585462361469', 'DangTrungVy34996', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3749, 1, '61585355175620', 'TrinhMinhNgan74', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3750, 1, '61585867853351', 'LyKimMinh7982', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3751, 1, '61585530875611', 'DauThanhPhuc74', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3752, 1, '61585853420325', 'PhungVanThao88531', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3753, 1, '61585412414299', 'QuachLinh605', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3754, 1, '61585851562101', 'LeKhoiQuan33849', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3755, 1, '61585520078696', 'CaoThaiPhat847', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3756, 1, '61585954252105', 'TrinhUyenThanh62679', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3757, 1, '61585831854068', 'LaPhuNam47', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3758, 1, '61585598259517', 'QuachTamTri547', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3759, 1, '61585530335972', 'NgoThaiAnh15', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3760, 1, '61585577766238', 'TranHaiNgoc21316', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3761, 1, '61585441060136', 'HoangLinhBao20144', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3762, 1, '61585641870256', 'MaiLinhBao219', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3763, 1, '61585566634848', 'HuynhHaiUyen204', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3764, 1, '61585360573903', 'KhuatVinhNgoc922', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3765, 1, '61585757097457', 'PhanTruongNgoc99', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3766, 1, '61585664791811', 'KhuatKimThinh78883', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3767, 1, '61585444662570', 'DoanHaPhu216', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3768, 1, '61585755894706', 'KhuatNgocKhoa55', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3769, 1, '61585818054435', 'ToVinhBao3341', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3770, 1, '61585776265294', 'TonLongThinh63439', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3771, 1, '61585649970401', 'DangTruongSon75', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3772, 1, '61585617692391', 'PhanMySon60320', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3773, 1, '61585789042854', 'PhanMyThao5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3774, 1, '61585452969514', 'ToUyenVy12', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3775, 1, '61585765494459', 'DauKyVy545', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3776, 1, '61585356554049', 'DinhTamPhu88', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3777, 1, '61585793874298', 'LePhatKhanh186', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3778, 1, '61585441307133', 'ChauDuyTrung34', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3779, 1, '61585385804193', 'MacThaoMy76', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3780, 1, '61585553737382', 'NguyenBinhYen461', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3781, 1, '61585371707361', 'QuachKyKhanh536', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3782, 1, '61585725688002', 'TrinhTanPhat64605', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3783, 1, '61585756168727', 'PhanTamThanh103', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3784, 1, '61585348697448', 'HaVinhUyen314', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3785, 1, '61585500133807', 'PhamLinhKhoa46', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3786, 1, '61585478137835', 'VoTamThanh3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3787, 1, '61585716749001', 'TonQuanMinh73', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3788, 1, '61585659573351', 'KhuatNgocThien57695', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3789, 1, '61585747825520', 'VoLinhThien57325', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3790, 1, '61585373773523', 'MacTrungKhoa0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3791, 1, '61585896200599', 'HoangVinhThien62', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3792, 1, '61585842351268', 'BuiPhuongThien202', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3793, 1, '61585792526785', 'PhungQuocQuan957', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3794, 1, '61585650662474', 'DuongLuuThanh9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3795, 1, '61585829035250', 'DuongThaiPhu83', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3796, 1, '61585503967963', 'TranMaiThinh23416', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3797, 1, '61585863022513', 'VoTuan29', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3798, 1, '61585626031366', 'PhungVanMy252', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3799, 1, '61585813673378', 'TrinhLongYen752', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3800, 1, '61585355207203', 'MacYenMy298', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3801, 1, '61585897370698', 'PhanThuan98', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3802, 1, '61585525625787', 'VoPhuongYen3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02');
INSERT INTO `random_category_accounts` (`id`, `random_category_id`, `account_name`, `password`, `price`, `status`, `server`, `buyer_id`, `batch_id`, `note`, `note_buyer`, `thumbnail`, `created_at`, `updated_at`) VALUES
(3803, 1, '61585794325516', 'PhanLongHan34812', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3804, 1, '61585728718743', 'LaTrungThao1048', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3805, 1, '61585721547304', 'DoLanThien663', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3806, 1, '61585378603532', 'DoanLinhKhanh57581', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3807, 1, '61585679251208', 'HuynhThuy39', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3808, 1, '61585431191883', 'HoMySon3170', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3809, 1, '61585416645269', 'NguyenBich47987', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3810, 1, '61585614602413', 'QuachVanMy10666', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3811, 1, '61585719477481', 'KhuatPhuongQuan82046', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3812, 1, '61585787513472', 'ToPhuongLong77', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3813, 1, '61585771525122', 'DauVinhKhanh982', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3814, 1, '61585634490714', 'KhuatNganPhu476', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3815, 1, '61585856392674', 'PhamTamMinh21', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3816, 1, '61585471961964', 'LyVanThien6370', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3817, 1, '61585839500699', 'MaiHoangNgoc681', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3818, 1, '61585416372750', 'TongTruongVan5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3819, 1, '61585754065299', 'AuQuocVan43311', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3820, 1, '61585648231520', 'HoangVanThien17', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3821, 1, '61585683808764', 'DinhGiaLinh94675', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3822, 1, '61585714557960', 'DoKyBao98', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3823, 1, '61585902260710', 'PhungLeThanh46', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3824, 1, '61585522418348', 'DauBaoNgoc41927', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3825, 1, '61585463468677', 'KhuatDiemHang78862', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3826, 1, '61585369633540', 'HuynhTriPhu4876', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3827, 1, '61585434073627', 'CaoTruongNgoc983', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3828, 1, '61585438809638', 'ChauLanTri80186', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3829, 1, '61585799722524', 'AuCongLy57428', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3830, 1, '61585752447604', 'HoangPhucAnh5358', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3831, 1, '61585713356845', 'QuachPhucLinh85642', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3832, 1, '61585785510210', 'DangYenAnh7375', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3833, 1, '61585550854825', 'HaHienKhoa30', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3834, 1, '61585859752533', 'QuachDuyMinh13677', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3835, 1, '61585735527382', 'PhamQuocNgoc99153', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3836, 1, '61585404401957', 'CaoKhanhYen4407', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3837, 1, '61585394352977', 'DuongHaiUyen7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3838, 1, '61585437466922', 'ToLeDuy961', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3839, 1, '61585607944744', 'DinhSonDuy8221', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3840, 1, '61585360007719', 'DangHienKhanh55', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3841, 1, '61585355264472', 'HuynhLong34423', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3842, 1, '61585801073384', 'DoTruongDuy789', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3843, 1, '61585611244784', 'QuachHaiPhu99', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3844, 1, '61585751485995', 'NguyenVanAn456', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3845, 1, '61585797595248', 'TrinhNgocTri453', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3846, 1, '61585437160812', 'LeHoangNgoc3497', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3847, 1, '61585627561163', 'MacLienKhoa334', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3848, 1, '61585653872339', 'DauNamThinh99871', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3849, 1, '61585671151643', 'DinhHuuSon8515', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3850, 1, '61585443159442', 'PhungHaiVy591', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3851, 1, '61585651112810', 'MacHaThai586', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3852, 1, '61585550194580', 'PhungMinhHuy4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3853, 1, '61585450841776', 'TrinhPhuThien0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3854, 1, '61585497127599', 'MaiUyenYen76', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3855, 1, '61585696534742', 'VoNganLong9879', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3856, 1, '61585664731759', 'BuiXuanVan1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3857, 1, '61585482310784', 'MaiThienPhuc19738', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3858, 1, '61585509188638', 'DoanYenSon8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3859, 1, '61585406113140', 'MacMaiPhu1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3860, 1, '61585688638141', 'DauNamMinh81287', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3861, 1, '61585593726626', 'DauCongTri609', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3862, 1, '61585646492837', 'HuynhYenXuan3551', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3863, 1, '61585491670277', 'PhanMyBao10', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3864, 1, '61585560905261', 'PhungTamAn8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3865, 1, '61585844783403', 'VoKyThanh44798', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3866, 1, '61585780707363', 'HuynhSonHuy93013', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3867, 1, '61585741225430', 'HuynhNganPhat139', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3868, 1, '61585885762437', 'MaiGiaLong80', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3869, 1, '61585617095531', 'LyMaiSon8201', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3870, 1, '61585340806477', 'TonTruongNgoc2738', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3871, 1, '61585802395415', 'AuVanThien36', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3872, 1, '61585882611524', 'TrinhKhanhPhuc28', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3873, 1, '61585742756996', 'TranQuanVy876', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3874, 1, '61585387062484', 'LyHuuUyen6774', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3875, 1, '61585870670044', 'PhamLinhThien5047', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3876, 1, '61585562854430', 'LeLeLinh1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3877, 1, '61585686959218', 'LaDuyKhoi9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3878, 1, '61585592886519', 'KhuatViet11', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3879, 1, '61585790157075', 'LeTanMinh14392', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3880, 1, '61585357276843', 'MacVinhNam940', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3881, 1, '61585711769547', 'TrinhChiTrung76825', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3882, 1, '61585772156383', 'NguyenKyAn80', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3883, 1, '61585471358730', 'LyPhuongPhu2424', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3884, 1, '61585476667663', 'DoThanhVy7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3885, 1, '61585716867641', 'LaThanhVan90', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3886, 1, '61585737057156', 'AuKyNgoc9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3887, 1, '61585837581342', 'TranThinhTri5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3888, 1, '61585842022636', 'HoangQuocKhoa24', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3889, 1, '61585846370925', 'BuiThaoVy164', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3890, 1, '61585466918840', 'QuachThienDuy78', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3891, 1, '61585723288228', 'VuKhoiPhu4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3892, 1, '61585661159405', 'VoThinhTri47774', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3893, 1, '61585716960609', 'LyNamLong39', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3894, 1, '61585514556913', 'ChauPhuongHuy83810', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3895, 1, '61585533938164', 'ToBaoYen5943', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3896, 1, '61585772186500', 'VuSonKhoa28', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3897, 1, '61585681952147', 'AuThanhLong41751', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3898, 1, '61585667279069', 'NguyenNhatNgan99733', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3899, 1, '61585716146878', 'DangLanAnh6897', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3900, 1, '61585800923733', 'TonLeThinh25', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3901, 1, '61585712188026', 'MacHienQuan1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3902, 1, '61585770987015', 'VuLongThinh3969', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3903, 1, '61585803772263', 'DauUyenTri9143', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3904, 1, '61585542005959', 'DauPhucThao132', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3905, 1, '61585700487512', 'PhungTanLong6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3906, 1, '61585405662508', 'DoXuanNam45798', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3907, 1, '61585443643201', 'HoYenLinh74', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3908, 1, '61585495479844', 'DoTamThanh11', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3909, 1, '61585606563207', 'QuachLongVy5018', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3910, 1, '61585369725710', 'PhungPhuc5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3911, 1, '61585501207689', 'LaXuanHuy3048', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3912, 1, '61585519988836', 'NgoKienBao636', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3913, 1, '61585554577773', 'LeKyThao48154', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3914, 1, '61585373536017', 'CaoVyMy166', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3915, 1, '61585538497654', 'ChauPhuongSon1259', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3916, 1, '61585555115471', 'TonHoangQuan46924', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3917, 1, '61585778785489', 'TonKyPhat4153', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3918, 1, '61585724490328', 'HoangGiaVi49057', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3919, 1, '61585350077654', 'HuynhLanThanh7809', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3920, 1, '61585521756772', 'QuachChiThanh27917', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3921, 1, '61585840013740', 'DangVinhHan1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3922, 1, '61585587727219', 'TranVinhThao69', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3923, 1, '61585996100010', 'NgoHienThinh96', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3924, 1, '61585699768578', 'LaYenKhoa0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3925, 1, '61585677481130', 'LyThinhNam22', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3926, 1, '61585570266936', 'DuongQuocThanh968', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3927, 1, '61585733936954', 'DoanHaiHan36504', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3928, 1, '61585465989062', 'BuiHienThanh0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3929, 1, '61585492449999', 'DinhNgocThien7902', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3930, 1, '61585447299815', 'CaoLongYen87159', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3931, 1, '61585830144306', 'HoNhatNgan680', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3932, 1, '61585814693554', 'HaHoangDuy9602', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3933, 1, '61585380195654', 'DuongQuocLong96', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3934, 1, '61585440703783', 'PhanKyLong706', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3935, 1, '61585558537320', 'NgoDuyThinh136', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3936, 1, '61585478468507', 'HaNhatAn40616', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3937, 1, '61585687499214', 'LeAn52332', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3938, 1, '61585472171802', 'NguyenThaiHuy0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3939, 1, '61585830145437', 'HoKienHuy812', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3940, 1, '61585485367634', 'ToMyBao40833', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3941, 1, '61585499529619', 'LyHoangKhoa74', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3942, 1, '61585890800170', 'DangDuyHung3351', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3943, 1, '61585861160009', 'PhamLien372', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3944, 1, '61585911020054', 'DuongTruongUyen7855', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3945, 1, '61585645862542', 'LaThienUyen73', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3946, 1, '61585504987012', 'BuiLinhBao4745', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3947, 1, '61585732437562', 'ToDiemChau19495', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3948, 1, '61585688518805', 'HuynhLeHan19', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3949, 1, '61585643463236', 'PhanNganLinh505', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3950, 1, '61585365733967', 'TranPhuongSon2878', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3951, 1, '61585358507158', 'DoanTruongBao8948', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3952, 1, '61585521998666', 'NguyenLeAnh0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3953, 1, '61585797982544', 'DuongDinhLong63415', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3954, 1, '61585875861891', 'MaiChiDung4508', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3955, 1, '61585732382927', 'BuiDat9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3956, 1, '61585526499910', 'TranNganThinh18', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3957, 1, '61585864552632', 'HoTruongDuy71090', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3958, 1, '61585720886888', 'AuVanYen929', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3959, 1, '61585704656971', 'LyNamHan6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3960, 1, '61585519178956', 'PhanKhanhHan56954', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3961, 1, '61585585686091', 'TranDuyBao5286', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3962, 1, '61585580553711', 'HoNgocThien141', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3963, 1, '61585389013559', 'VuLienNam0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3964, 1, '61585664129603', 'NgoDinhThang1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3965, 1, '61585423817592', 'BuiTanYen67', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3966, 1, '61585769874626', 'CaoLanDuy5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3967, 1, '61585823908474', 'DoanMaiThien8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3968, 1, '61585471119993', 'QuachLienLong41081', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3969, 1, '61585899321798', 'LeHaHan84481', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3970, 1, '61585840370895', 'ToTamPhu3376', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3971, 1, '61585820488714', 'LyKhoiPhat152', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3972, 1, '61585917980728', 'DauHoangThien95148', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3973, 1, '61585510418929', 'TonMaiTri2627', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3974, 1, '61585730816354', 'CaoMy529', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3975, 1, '61585798193117', 'DoanKhoiThao5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3976, 1, '61585510088158', 'QuachMinhBao65648', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3977, 1, '61585426480493', 'PhanPhucQuan3192', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3978, 1, '61585861910622', 'BuiMinhDuy2065', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3979, 1, '61585671931527', 'DangLuuVan94361', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3980, 1, '61585909404401', 'LeHoangLinh95006', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3981, 1, '61585728416097', 'PhamKyBao11', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3982, 1, '61585448773053', 'ToTanLinh50456', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3983, 1, '61585499586830', 'NgoThienYen70', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3984, 1, '61585868300411', 'DangThienLong50', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3985, 1, '61585423481968', 'VoHuong62', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3986, 1, '61585783013633', 'TranHaiMinh0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3987, 1, '61585632421858', 'DoanQuanMinh69', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3988, 1, '61585489540063', 'LyKhoiKhanh90660', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3989, 1, '61585358594749', 'DuongKimThien0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3990, 1, '61585748847593', 'TaTamThinh2775', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3991, 1, '61585844510843', 'NguyenKimPhat2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3992, 1, '61585427922992', 'TongYenDuy4646', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3993, 1, '61585339127944', 'DoanVinhSon8377', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3994, 1, '61585390994111', 'HaKienQuan959', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3995, 1, '61585666803254', 'HoNhatBao66', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3996, 1, '61585417963907', 'TranPhatBao419', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3997, 1, '61585663410387', 'DoNhatTri730', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3998, 1, '61585453962063', 'NguyenKhanhLinh9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(3999, 1, '61585842203589', 'PhamHuuKhanh25069', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4000, 1, '61585752025351', 'QuachCongHieu9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4001, 1, '61585476040119', 'NgoPhuongQuan1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4002, 1, '61585935353035', 'KhuatTrinh729', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4003, 1, '61585696170526', 'PhanCongMinh29233', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4004, 1, '61585738826004', 'TonPhuLong3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4005, 1, '61585361597846', 'TonPhucSon399', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4006, 1, '61585856151351', 'BuiKienThao0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4007, 1, '61585834161848', 'DinhThienDuy30', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4008, 1, '61585582445984', 'PhungKimSon79738', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4009, 1, '61585726078906', 'TongDuyPhu186', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4010, 1, '61585776203361', 'TonMyMinh29', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4011, 1, '61585795764186', 'MaiHoangKhanh8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4012, 1, '61585453270151', 'PhanLongNam9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4013, 1, '61585439290390', 'DinhMyNgan29', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4014, 1, '61585662902289', 'LaLien2488', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4015, 1, '61585730638874', 'LyXuanThanh36', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4016, 1, '61585829001963', 'PhamPhucThanh13', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:02', '2026-06-22 17:19:02'),
(4017, 1, '61585839593840', 'AuLinhThinh38', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4018, 1, '61585831315499', 'DuongPhuongAnh80', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4019, 1, '61585784606079', 'HoangHienVan266', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4020, 1, '61585638120850', 'BuiKhanhQuan91918', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4021, 1, '61585431971706', 'VoNganBao8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4022, 1, '61585605336204', 'DinhNganThanh5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4023, 1, '61585776204456', 'TrinhTruongMy189', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4024, 1, '61585865213362', 'NguyenTruongThanh35', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4025, 1, '61585793243387', 'TranHaHan9596', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4026, 1, '61585756711431', 'HaTruongTri1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4027, 1, '61585914170737', 'AuTriQuan943', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4028, 1, '61585670698740', 'QuachBaoYen977', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4029, 1, '61585663922039', 'PhamGiaYen5951', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4030, 1, '61585388175345', 'TrinhKyThanh50345', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4031, 1, '61585386612630', 'TrinhKimUyen61', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4032, 1, '61585692628713', 'VuSonNgan8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4033, 1, '61585449883207', 'PhamVanUyen97514', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4034, 1, '61585811782806', 'KhuatPhuongQuan8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4035, 1, '61585421503803', 'LaLanPhat9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4036, 1, '61585391142205', 'HaKienLinh94', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4037, 1, '61585742396220', 'PhanTruongNgoc54', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4038, 1, '61585670639093', 'BuiThanh83711', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4039, 1, '61585604913406', 'HoKhanhNgan64052', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4040, 1, '61585382025696', 'DoPhuNgoc903', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4041, 1, '61585501778575', 'BuiTruongUyen67050', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4042, 1, '61585568197060', 'NgoVinhHan19758', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4043, 1, '61585525299888', 'DauVyDuy68511', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4044, 1, '61585773897478', 'PhanLanMy86', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4045, 1, '61585844240501', 'PhanHaiLong58', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4046, 1, '61585525116376', 'CaoThienKhanh10097', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4047, 1, '61585771464165', 'MaiHienAn551', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4048, 1, '61585722837543', 'TongChiDung8150', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4049, 1, '61585475620729', 'TongHaiPhu30078', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4050, 1, '61585682969441', 'PhamLuuNam397', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4051, 1, '61585565916895', 'HaGiang1066', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4052, 1, '61585405002600', 'PhungPhuongMy9073', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4053, 1, '61585585717412', 'DauNganThanh16831', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4054, 1, '61585808931929', 'DoVanAn98', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4055, 1, '61585850695217', 'PhanNganAn28', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4056, 1, '61585774705751', 'HaVanNgoc9924', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4057, 1, '61585338647894', 'QuachLongPhuc575', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4058, 1, '61585676729231', 'LaHaThinh96', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4059, 1, '61585584034274', 'DangChiTai706', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4060, 1, '61585906911490', 'ToThienSon7874', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4061, 1, '61585620278205', 'MacHaAn7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4062, 1, '61585649912930', 'DangPhatKhanh66', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4063, 1, '61585384216946', 'VuThienSon3662', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4064, 1, '61585627532247', 'MacVyThinh97497', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4065, 1, '61585382476665', 'DinhPhuKhoa5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4066, 1, '61585409862633', 'BuiNgocThanh12', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4067, 1, '61585500096956', 'DoGiaHuy1120', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4068, 1, '61585466142299', 'BuiTamAnh57', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4069, 1, '61585755715720', 'PhanKienVy92', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4070, 1, '61585413282650', 'CaoThienNam610', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4071, 1, '61585771915672', 'DauQuocHuy96', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4072, 1, '61585564148321', 'PhungNamNgan93841', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4073, 1, '61585784033205', 'TonThaoSon854', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4074, 1, '61585599303243', 'QuachDuyQuang8431', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4075, 1, '61585577284913', 'VuKhoiLinh2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4076, 1, '61585591623496', 'TongTrungNgan7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4077, 1, '61585758837283', 'PhamNhatDuy10', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4078, 1, '61585860206827', 'HuynhNamNgan526', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4079, 1, '61585684739263', 'DoanPhuongVy799', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4080, 1, '61585402633259', 'TranVinhPhu8668', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4081, 1, '61585722266123', 'HoVyPhat7873', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4082, 1, '61585795164126', 'DangYen82', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4083, 1, '61585730577660', 'DuongThienHuy3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4084, 1, '61585479495029', 'KhuatPhucBao57', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4085, 1, '61585781636312', 'QuachVanAn90418', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4086, 1, '61585451711818', 'TonSonKhanh55', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4087, 1, '61585367774848', 'DangThinhYen13', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4088, 1, '61585672532073', 'TaKimKhanh1149', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4089, 1, '61585553705649', 'TrinhThienHan82', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4090, 1, '61585642380636', 'VoHaKhang9984', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4091, 1, '61585471448200', 'ChauDiemHang3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4092, 1, '61585376086499', 'VuPhuongSon299', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4093, 1, '61585338736485', 'ToTuan8149', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4094, 1, '61585343445746', 'DoKyThanh64', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4095, 1, '61585604492186', 'QuachHaiHan21', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4096, 1, '61585433652958', 'DangNgocLinh3668', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4097, 1, '61585721759107', 'DangLoan2257', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4098, 1, '61585882431701', 'MacXuanThanh9563', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4099, 1, '61585717766294', 'DinhNamMy4607', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4100, 1, '61585737118445', 'TranUyenVy8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4101, 1, '61585834198235', 'BuiDinhKhang1128', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4102, 1, '61585449970709', 'MaiTruongThien11325', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4103, 1, '61585756915346', 'MacMaiPhat7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4104, 1, '61585700758376', 'TonKienHuy65', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4105, 1, '61585585862944', 'PhamVanTri6010', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4106, 1, '61585856272794', 'DinhTruc921', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4107, 1, '61585647962947', 'HuynhQuanHuy713', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4108, 1, '61585577974189', 'TaKhanhYen0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4109, 1, '61585370983521', 'NguyenLanHuy213', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4110, 1, '61585446639825', 'MaiThaoTri37083', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4111, 1, '61585370624188', 'LaLien11666', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4112, 1, '61585722926645', 'HoangPhucKhanh3222', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4113, 1, '61585791745723', 'DangHoangHuy35850', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4114, 1, '61585516985888', 'DuongVanNgan6735', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4115, 1, '61585573026373', 'DinhPhuMy84885', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4116, 1, '61585396425363', 'LaThaiThanh67', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4117, 1, '61585390123304', 'DoDaThu93', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4118, 1, '61585817842824', 'NgoVanKhoa9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4119, 1, '61585668659397', 'TranLeVy5405', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4120, 1, '61585910390370', 'HuynhTriSon21133', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4121, 1, '61585500759978', 'HoThinhKhoa875', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4122, 1, '61585353104302', 'PhungDuySon41', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4123, 1, '61585741796396', 'LyChiBao4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4124, 1, '61585417691236', 'DoXuanQuan22', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4125, 1, '61585618595086', 'TranPhucPhat599', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4126, 1, '61585610074734', 'PhamVinhQuan1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4127, 1, '61585574074608', 'DinhNganThanh71975', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4128, 1, '61585437941393', 'CaoVyNgoc74', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4129, 1, '61585625585326', 'LaLienKhanh8390', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4130, 1, '61585412231335', 'LePhuongBao61', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4131, 1, '61585756284720', 'VuLeDuy7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4132, 1, '61585430500803', 'CaoPhucPhu2731', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4133, 1, '61585510686256', 'KhuatNhatBao52463', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4134, 1, '61585563635224', 'PhungPhucQuan8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4135, 1, '61585700428169', 'AuKimAnh717', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4136, 1, '61585460561895', 'TranKhanhVy42', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4137, 1, '61585753017942', 'DoanNgocBao183', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4138, 1, '61585597235544', 'MacChau401', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4139, 1, '61585773594909', 'TonTamPhuc10260', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4140, 1, '61585780494280', 'AuHuuNam9513', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4141, 1, '61585612952810', 'QuachThaoVy23', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4142, 1, '61585446672241', 'PhanMinhAn953', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4143, 1, '61585575634474', 'ChauHaiThinh4325', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4144, 1, '61585505857768', 'TongHienVan9031', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4145, 1, '61585631852727', 'NgoPhatBao85341', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4146, 1, '61585628671178', 'PhungDuyKhang94992', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4147, 1, '61585922750833', 'KhuatYenSon10237', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4148, 1, '61585832573121', 'ChauQuocHan6253', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03');
INSERT INTO `random_category_accounts` (`id`, `random_category_id`, `account_name`, `password`, `price`, `status`, `server`, `buyer_id`, `batch_id`, `note`, `note_buyer`, `thumbnail`, `created_at`, `updated_at`) VALUES
(4149, 1, '61585881295608', 'TongMaiAnh93272', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4150, 1, '61585849644342', 'TongQuanPhat424', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4151, 1, '61585446282520', 'AuLeQuan790', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4152, 1, '61585889211081', 'HaHaAn16465', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4153, 1, '61585652613879', 'LaHaHuy36', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4154, 1, '61585563005830', 'DinhLienNgan4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4155, 1, '61585721876843', 'DauQuanKhanh344', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4156, 1, '61585800085369', 'HuynhTrungVy987', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4157, 1, '61585466349438', 'TrinhHienNgan6784', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4158, 1, '61585621591437', 'TaPhuongPhu764', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4159, 1, '61585454861857', 'LaKhoiHuy897', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4160, 1, '61585811512925', 'TonKyHan863', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4161, 1, '61585415893691', 'LyPhucKhoa438', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4162, 1, '61585434793120', 'DangLienBao31225', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4163, 1, '61585632061842', 'HaHienPhat29331', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4164, 1, '61585414783898', 'ChauLinhVy3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4165, 1, '61585377613841', 'TranThaoUyen1231', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4166, 1, '61585550163348', 'LeNgocKhoa5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4167, 1, '61585717527479', 'ToPhucThanh5605', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4168, 1, '61585723023279', 'HaLuuBao22', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4169, 1, '61585754277155', 'HaLanSon5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4170, 1, '61585709819966', 'LyKimNam2142', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4171, 1, '61585701118924', 'TrinhNhatHuy885', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4172, 1, '61585405095621', 'DoanHoangLinh42', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4173, 1, '61585588204113', 'HoHienKhoa779', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4174, 1, '61585744709401', 'NguyenKimUyen16686', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4175, 1, '61585475378088', 'PhungYenXuan51', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4176, 1, '61585714290792', 'LeKhoiThinh30728', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4177, 1, '61585732496643', 'CaoKyAnh98', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4178, 1, '61585341977689', 'KhuatQuanThao873', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4179, 1, '61585416763961', 'PhanKhoiHan69654', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4180, 1, '61585435330182', 'CaoQuanKhoa993', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4181, 1, '61585659902378', 'DangUyenNgan87303', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4182, 1, '61585382624145', 'DoanDuyNhan3282', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4183, 1, '61585846013460', 'ChauThaiHuy36703', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4184, 1, '61585877991657', 'HoangVyThao4346', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4185, 1, '61585581306346', 'PhungLienKhanh84', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4186, 1, '61585941592672', 'VuLuuPhuc25', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4187, 1, '61585468898616', 'TrinhDinhNgoc8760', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4188, 1, '61585408840773', 'HuynhPhuMinh5846', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4189, 1, '61585695118839', 'NguyenThaoDuy782', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4190, 1, '61585734836192', 'PhungVanMy42160', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4191, 1, '61585559764567', 'NguyenPhucThanh1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4192, 1, '61585679280961', 'HaKienTri83461', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4193, 1, '61585563606087', 'HoKyPhat7910', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4194, 1, '61585723346427', 'TrinhKimSon16287', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4195, 1, '61585717046725', 'HaHaThanh99410', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4196, 1, '61585857650540', 'TongGiaAn425', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4197, 1, '61585804526129', 'VoQuanSon70654', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4198, 1, '61585847963217', 'PhanHaiMy61', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4199, 1, '61585618082476', 'NgoLongBao8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4200, 1, '61585478172077', 'HoangLeHuy8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4201, 1, '61585339996412', 'VuTanHan8745', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4202, 1, '61585857260842', 'TrinhPhuThanh276', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4203, 1, '61585909104331', 'QuachHienUyen95', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4204, 1, '61585747224997', 'DinhMyThinh48', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4205, 1, '61585393783003', 'PhamLinhNgan9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4206, 1, '61585410941447', 'DoanMy7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4207, 1, '61585380196929', 'QuachNgocDuy3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4208, 1, '61585695270366', 'HoangKimThao16', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4209, 1, '61585506397451', 'ChauVanNam7058', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4210, 1, '61585370204406', 'QuachLuuYen750', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4211, 1, '61585533012410', 'ToDuyNhan92591', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4212, 1, '61585479010544', 'MacTrungThinh3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4213, 1, '61585662210672', 'VuVinhVan8942', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4214, 1, '61585618832539', 'VuMyPhu66010', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4215, 1, '61585641607386', 'BuiMaiMinh81777', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4216, 1, '61585625133904', 'PhungVanHan11', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4217, 1, '61585383495590', 'HuynhMyYen11', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4218, 1, '61585416072205', 'TrinhHaoNhien1121', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4219, 1, '61585634102027', 'VuSonVan93', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4220, 1, '61585872443292', 'NguyenTruongLinh483', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4221, 1, '61585790665869', 'LeTriAnh31', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4222, 1, '61585591352758', 'BuiHuuBao676', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4223, 1, '61585698177611', 'DoanTanPhat2387', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4224, 1, '61585692717831', 'ToGiaHuy69118', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4225, 1, '61585669081815', 'PhamPhuongSon616', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4226, 1, '61585520196809', 'DangMinhSon678', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4227, 1, '61585399602343', 'DoanNamKhanh7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4228, 1, '61585896922086', 'MaiHuuVy8555', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4229, 1, '61585616344332', 'NguyenLuuYen24', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4230, 1, '61585475978120', 'DoQuanPhat99', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4231, 1, '61585357184431', 'HoangGiaKhang86', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4232, 1, '61585716209433', 'QuachBaoHan83', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4233, 1, '61585759615119', 'QuachAnhKhoa6432', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4234, 1, '61585352594565', 'TonXuanPhu6584', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4235, 1, '61585593665456', 'QuachKimDuy36704', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4236, 1, '61585425041760', 'DauLeHuy9462', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4237, 1, '61585850454143', 'DauTung25', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4238, 1, '61585750375743', 'HuynhKienVan8714', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4239, 1, '61585794113390', 'VoThienVy33', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4240, 1, '61585383346520', 'QuachThaoDuy5347', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4241, 1, '61585968080228', 'DuongNganPhat9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4242, 1, '61585734865786', 'ChauThanh3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4243, 1, '61585719990666', 'HoKhoa209', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4244, 1, '61585678591093', 'PhungGiaQuan380', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4245, 1, '61585978190803', 'PhamLanKhoa3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4246, 1, '61585532316347', 'PhamNganThanh56', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4247, 1, '61585617008703', 'DangNgocKhoa30', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4248, 1, '61585761476960', 'QuachTrungKhanh606', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4249, 1, '61585404044289', 'MacVanThinh6264', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4250, 1, '61585691732677', 'LeHong89846', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4251, 1, '61585780553586', 'HoThinhLinh68', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4252, 1, '61585384063707', 'DinhHaThien261', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4253, 1, '61585830534195', 'AuKyPhat568', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4254, 1, '61585825554334', 'NguyenGiaYen86', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4255, 1, '61585592673922', 'DoanThaoUyen203', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4256, 1, '61585504721880', 'DoThaoPhu30', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4257, 1, '61585491307516', 'TaAnKhanh18708', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4258, 1, '61585553558787', 'PhamThaiHuy7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4259, 1, '61585384932654', 'DinhThaoVan79665', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4260, 1, '61585676189641', 'ToKimNam10', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4261, 1, '61585734871027', 'HoangThanhThinh87450', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4262, 1, '61585783019594', 'ToHoangYen69224', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4263, 1, '61585457379347', 'NguyenPhuKhoa2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4264, 1, '61585595316764', 'DoKyNgan4161', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4265, 1, '61585902864545', 'PhungNamKhoa83920', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4266, 1, '61585441904772', 'HaQuocThien94369', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4267, 1, '61585652556089', 'HoThienThanh6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4268, 1, '61585442986373', 'LeTrungKhoa624', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4269, 1, '61585407886441', 'MaiYenNam10', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4270, 1, '61585615926457', 'LeUyenLong245', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4271, 1, '61585667135488', 'BuiHoangUyen0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4272, 1, '61585865754704', 'VuPhuLong1558', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4273, 1, '61585527012638', 'BuiHuuPhu21', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4274, 1, '61585974860581', 'CaoTruongYen7629', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4275, 1, '61585710661849', 'ToTanThao24852', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4276, 1, '61585727370870', 'DuongPhuMy2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4277, 1, '61585875023974', 'DangPhatAnh86', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4278, 1, '61585444936182', 'DoanLienNam1496', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4279, 1, '61585401616627', 'DauHuuKhoa16187', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4280, 1, '61585754431946', 'KhuatQuanAn66870', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4281, 1, '61585453304120', 'QuachHienNgan1727', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4282, 1, '61585969461378', 'DoNamLong46', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4283, 1, '61585415687918', 'KhuatVinhTri95879', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4284, 1, '61585691313007', 'QuachChiTrung5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4285, 1, '61585442565145', 'VuLinhNam917', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4286, 1, '61585465064545', 'LyQuanPhat6634', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4287, 1, '61585846255698', 'DoanPhatNam874', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4288, 1, '61585914504300', 'BuiNganLong54627', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4289, 1, '61585883663947', 'TrinhKyKhanh0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4290, 1, '61585737601020', 'LaHuuThanh936', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4291, 1, '61585892394171', 'PhamThanhVy1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4292, 1, '61585951490667', 'QuachNgocThinh7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4293, 1, '61585886753430', 'TaNganKhanh98', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4294, 1, '61585418087686', 'AuHaiNam45293', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4295, 1, '61585818926847', 'BuiQuocNam30339', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4296, 1, '61585521160608', 'TaPhuHuy38', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4297, 1, '61585817758992', 'HoPhucAnh7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4298, 1, '61585484352635', 'BuiXuanHuy5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4299, 1, '61585922693295', 'TrinhNganHan23', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4300, 1, '61585624297935', 'PhanNganUyen9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4301, 1, '61585786498162', 'VuKhoiNgan810', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4302, 1, '61585942161303', 'TonNgocThinh7250', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4303, 1, '61585700373715', 'PhanQuanNam52', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4304, 1, '61585404707264', 'PhungLanPhat32', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4305, 1, '61585632906296', 'ToTruongPhat2698', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4306, 1, '61585889153654', 'QuachKhoiThanh5699', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4307, 1, '61585564331236', 'NgoVanYen344', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4308, 1, '61585477725127', 'HaCongThinh83', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4309, 1, '61585661855862', 'DinhSonMy706', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4310, 1, '61585815717125', 'AuUyenLinh56468', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4311, 1, '61585944262474', 'NgoLuuHuy557', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4312, 1, '61585531572176', 'DangQuocUyen9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4313, 1, '61585869684783', 'PhanDiemThuy94860', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4314, 1, '61585710182227', 'LaVanDuy26986', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4315, 1, '61585931271362', 'AuNhatKhanh832', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4316, 1, '61585567449138', 'TaKhanhPhuc405', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4317, 1, '61585755121326', 'BuiLeQuan67547', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4318, 1, '61585620156812', 'VuLanPhuc51', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4319, 1, '61585615836706', 'NguyenHung94724', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4320, 1, '61585931931388', 'QuachTruongThao95', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4321, 1, '61585578160619', 'ToThaoMy226', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4322, 1, '61585801977116', 'TongThienTri6739', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4323, 1, '61585569549103', 'TrinhVanNgan2730', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4324, 1, '61585476553183', 'VuNganDuy305', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4325, 1, '61585526260978', 'LaThaiDuy6984', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4326, 1, '61585498272017', 'TongVanThinh64018', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4327, 1, '61585677275126', 'LyKhanhNam26909', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4328, 1, '61585566579134', 'LyHaiTri226', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4329, 1, '61585577528511', 'QuachLinhSon377', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4330, 1, '61585694043726', 'TranKimKhoa458', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4331, 1, '61585676284113', 'CaoKyNgoc619', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4332, 1, '61585485824581', 'HuynhLinhThinh59', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4333, 1, '61585589289224', 'KhuatNamNgoc421', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4334, 1, '61585610527026', 'KhuatLinhKhanh3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4335, 1, '61585567571116', 'TaQuocThinh1935', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4336, 1, '61585405697493', 'NgoQuocAn87396', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4337, 1, '61585944440914', 'NgoLongDuy5681', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4338, 1, '61585534090714', 'HoThinhPhu7039', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4339, 1, '61585671063930', 'HaYenPhat713', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4340, 1, '61585423817360', 'QuachKhanhHan5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4341, 1, '61585603777563', 'HoangTamVan7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4342, 1, '61585433207275', 'TongKimLong6110', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4343, 1, '61585465755032', 'DuongThaoHan20', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4344, 1, '61585958751967', 'NguyenUyenMy22', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4345, 1, '61585966041550', 'DangPhatHuy7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4346, 1, '61585533582095', 'DoThinhVan7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4347, 1, '61585852196976', 'MacBinhMinh6354', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4348, 1, '61585741200900', 'HoangHaLinh77712', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4349, 1, '61585424507910', 'MacKhoiThien62536', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4350, 1, '61585910363744', 'BuiKienHan588', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4351, 1, '61585635217752', 'MaiMinhLong1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4352, 1, '61585449464677', 'HoHuuSon6224', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4353, 1, '61585483243272', 'DoanDiemTrang509', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4354, 1, '61585646105394', 'PhanUyenVan430', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4355, 1, '61585871515834', 'DuongLienTri90875', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4356, 1, '61585666506053', 'ToHaMy55', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4357, 1, '61585640526771', 'QuachNamLinh132', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4358, 1, '61585452855248', 'MaiQuanNam411', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4359, 1, '61585768800622', 'DauKienMy2997', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4360, 1, '61585772760116', 'TrinhLuuLong44', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4361, 1, '61585479374720', 'AuNganLong20619', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4362, 1, '61585471873314', 'QuachThaiHan28', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4363, 1, '61585855886549', 'DuongThaiMy7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4364, 1, '61585485643573', 'QuachYenThien67228', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4365, 1, '61585467824987', 'TaLePhuc9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4366, 1, '61585924731415', 'HoangThaiQuan6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4367, 1, '61585457535889', 'HuynhQuanUyen52108', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4368, 1, '61585528000407', 'PhamKhanhThao97176', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4369, 1, '61585878925809', 'MacYenSon5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4370, 1, '61585859486773', 'PhungThaiAnh35607', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4371, 1, '61585485912953', 'QuachTanNgan481', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4372, 1, '61585677303497', 'PhungXuanYen8608', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4373, 1, '61585465093638', 'TaTriPhat58', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4374, 1, '61585574949846', 'HoangTriLong315', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4375, 1, '61585759080929', 'BuiDinhVinh67657', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4376, 1, '61585758301327', 'NgoTanPhat42', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4377, 1, '61585903854240', 'TrinhNam8910', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4378, 1, '61585775608827', 'PhamKimHuy7027', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4379, 1, '61585762231213', 'QuachVanUyen465', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4380, 1, '61585898242770', 'TongBaoYen97', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4381, 1, '61585925331504', 'MacKienThanh66', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4382, 1, '61585924373556', 'TonPhuongKhanh6813', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4383, 1, '61585872564211', 'BuiHoangNam15', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4384, 1, '61585435516951', 'BuiVanPhuc78285', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4385, 1, '61585463025628', 'KhuatQuocKhanh1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4386, 1, '61585759709216', 'DuongMaiThao624', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4387, 1, '61585555391170', 'MacLuuHuy2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4388, 1, '61585549090349', 'DoDiemMy996', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4389, 1, '61585922783587', 'VuYenSon9472', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4390, 1, '61585602428880', 'BuiHoangHuy74', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4391, 1, '61585791989599', 'MacHuuAnh22389', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4392, 1, '61585621928129', 'LeLanHan70', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4393, 1, '61585624868248', 'VoLeThinh255', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4394, 1, '61585671033927', 'DoDinhThinh839', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4395, 1, '61585713811975', 'AuPhatNgoc2307', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4396, 1, '61585578070679', 'AuVinhKhoa17407', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4397, 1, '61585587279522', 'PhungThinhYen61598', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4398, 1, '61585600358924', 'DoSonDuy579', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4399, 1, '61585850786504', 'DoLienMinh567', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4400, 1, '61585621236460', 'DoanThaoHuy824', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4401, 1, '61585694822748', 'MacPhuDuy3827', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4402, 1, '61585669355256', 'LaKhanhMinh202', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4403, 1, '61585689063200', 'AuPhuongMy82', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4404, 1, '61585534332500', 'QuachThanhDuy85', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4405, 1, '61585833268433', 'DoanTruongNam71032', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4406, 1, '61585779208498', 'PhamTrungMinh8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4407, 1, '61585428315189', 'PhamMyPhuc4074', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4408, 1, '61585421715961', 'BuiHaVy59246', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4409, 1, '61585919721751', 'DangLongPhuc8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4410, 1, '61585673584785', 'VoLanLong33707', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4411, 1, '61585613076696', 'TrinhNamMy2091', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4412, 1, '61585711861995', 'DoQuanBao22', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4413, 1, '61585657535275', 'KhuatBaoMinh8979', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4414, 1, '61585420967499', 'VoThaoLinh20', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4415, 1, '61585610528262', 'VuVinhSon15', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4416, 1, '61585713901846', 'QuachPhucAn3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4417, 1, '61585747382340', 'MacThang4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4418, 1, '61585741620134', 'VuTrungPhuc394', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4419, 1, '61585482013101', 'HoBaoThy961', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4420, 1, '61585424835872', 'AuPhuongAnh373', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4421, 1, '61585702023951', 'CaoTruongBao556', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4422, 1, '61585752300928', 'DuongLanMy1884', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4423, 1, '61585475924624', 'DoanBaoThy60', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4424, 1, '61585889514707', 'VuUyen6158', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4425, 1, '61585687355353', 'HaKhanhHan6118', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4426, 1, '61585718491669', 'HaLongVy623', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4427, 1, '61585826157900', 'PhamDuyViet936', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4428, 1, '61585840226051', 'LeVanQuan545', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4429, 1, '61585916212028', 'HoangNganMinh9521', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4430, 1, '61585659814295', 'VoTanThinh8547', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4431, 1, '61585640255227', 'LeTanMinh4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4432, 1, '61585523981827', 'LaVanBao2827', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4433, 1, '61585580140804', 'LaGiaLinh9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4434, 1, '61585452165690', 'CaoUyenTri3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4435, 1, '61585774558650', 'PhungMinhThinh0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4436, 1, '61585768680513', 'TongHung8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4437, 1, '61585562679320', 'PhamThaoTri9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4438, 1, '61585783379726', 'LeLongVan4785', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4439, 1, '61585860684857', 'BuiThienBao87', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4440, 1, '61585669205916', 'TongMyMinh2918', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4441, 1, '61585687984520', 'QuachNhatTri42', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4442, 1, '61585749211287', 'TonHuong729', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4443, 1, '61585579239635', 'BuiHuuPhu35', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4444, 1, '61585660356571', 'HoDinhKhoi589', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4445, 1, '61585449374080', 'TaVyThien54', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4446, 1, '61585656246379', 'HuynhKhanh2528', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4447, 1, '61585725392507', 'NgoVanKhanh7948', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4448, 1, '61585624597920', 'PhungVanMinh23', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4449, 1, '61585770028795', 'TrinhLuuThanh3712', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4450, 1, '61585668216213', 'CaoLongQuan378', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4451, 1, '61585642536641', 'LeLeLong26', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4452, 1, '61585632067768', 'MacPhucThien6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4453, 1, '61585813496672', 'QuachLinhPhu29', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4454, 1, '61585413017610', 'DauNamKhanh82', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4455, 1, '61585575400189', 'VoLanPhat37', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4456, 1, '61585439265619', 'PhungLeHuy12', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4457, 1, '61585711232564', 'HuynhDuyPhat259', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4458, 1, '61585975131188', 'QuachLienTri58', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4459, 1, '61585564690582', 'DuongHaKhanh84902', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4460, 1, '61585906044087', 'AuCongThanh20075', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4461, 1, '61585397567046', 'VuTamHuy5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4462, 1, '61585726531471', 'BuiKimThinh504', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4463, 1, '61585691883372', 'HaKienPhu753', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4464, 1, '61585811907080', 'LeVinhVan9828', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4465, 1, '61585596457499', 'DoanYenThao3045', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4466, 1, '61585894855167', 'TranKySon1537', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4467, 1, '61585779598336', 'PhungYenLinh6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4468, 1, '61585717471442', 'DangThaoKhoa3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4469, 1, '61585622467725', 'DuongCuong2696', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4470, 1, '61585425405290', 'LeMaiQuan53', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4471, 1, '61585437766549', 'DinhQuocVan7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4472, 1, '61585696862521', 'QuachTanNam453', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4473, 1, '61585576389092', 'TrinhHuuUyen24863', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4474, 1, '61585639026899', 'MaiThinhLinh25995', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4475, 1, '61585798769253', 'DoMyHuy29', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4476, 1, '61585959891980', 'DangPhucThao61', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4477, 1, '61585734662176', 'AuVinhNgoc3037', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4478, 1, '61585571439334', 'TaTanHuy214', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4479, 1, '61585823996345', 'HuynhNganPhuc1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4480, 1, '61585401737954', 'VuKyTri68007', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4481, 1, '61585706914222', 'ChauLanTri0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4482, 1, '61585829516208', 'HaVyMy16875', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4483, 1, '61585777800519', 'AuSonKhoa594', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4484, 1, '61585445266590', 'LaQuanLong829', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4485, 1, '61585546119940', 'PhungVinhVan4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4486, 1, '61585553110205', 'ToKienHuy107', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4487, 1, '61585911352190', 'TrinhMinhAnh9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4488, 1, '61585525541050', 'TranTrungLinh0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4489, 1, '61585609808720', 'HoangYenHuy5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4490, 1, '61585614216584', 'DinhQuocMinh213', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4491, 1, '61585494612382', 'DangPhucNgoc39', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4492, 1, '61585636957662', 'HoangThinhUyen9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4493, 1, '61585573208711', 'NguyenMaiNgan824', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4494, 1, '61585964451100', 'TrinhNgocVan691', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03');
INSERT INTO `random_category_accounts` (`id`, `random_category_id`, `account_name`, `password`, `price`, `status`, `server`, `buyer_id`, `batch_id`, `note`, `note_buyer`, `thumbnail`, `created_at`, `updated_at`) VALUES
(4495, 1, '61585489812195', 'LePhucThao14', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4496, 1, '61585980740196', 'LyHienSon932', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4497, 1, '61585919331758', 'QuachDiemThuy7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4498, 1, '61585753351569', 'QuachQuocVy5820', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4499, 1, '61585412687953', 'VuTruongThao9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4500, 1, '61585644817270', 'ChauUyen66', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4501, 1, '61585918491961', 'PhamPhuPhat5422', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4502, 1, '61585628526245', 'VuNganQuan74', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4503, 1, '61585712762222', 'QuachTuan9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4504, 1, '61585923893501', 'KhuatLanSon87476', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4505, 1, '61585706073629', 'DoanHienKhoa7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4506, 1, '61585717711305', 'CaoNgocPhuc96', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4507, 1, '61585917323490', 'BuiLanLinh720', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4508, 1, '61585685645056', 'QuachUyenAn3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4509, 1, '61585634285737', 'TranTruongVy60076', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4510, 1, '61585516211070', 'PhanNgocSon1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4511, 1, '61585435815369', 'TranLinhHuy378', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4512, 1, '61585394237724', 'MacLanYen42', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4513, 1, '61585525780632', 'MacLanDuy5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4514, 1, '61585862514775', 'ChauHaiYen541', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4515, 1, '61585951820128', 'TaGiaQuan4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4516, 1, '61585380557942', 'ChauGiaTri4426', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4517, 1, '61585585300010', 'TaVanLong4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4518, 1, '61585718642941', 'DauHaThao29743', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4519, 1, '61585886753725', 'VoKhanhNgoc636', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4520, 1, '61585833447656', 'PhanKhoiSon914', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4521, 1, '61585741022313', 'LaLongTri2013', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4522, 1, '61585500193294', 'BuiPhuongLong72', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4523, 1, '61585500973332', 'MacLanNam899', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4524, 1, '61585944800545', 'VoVinhYen2347', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4525, 1, '61585476192410', 'PhanVyThao3768', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4526, 1, '61585559981279', 'MaiVinhSon3597', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4527, 1, '61585805008584', 'DinhMaiNam0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4528, 1, '61585681115056', 'VuNganThao6248', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4529, 1, '61585965171008', 'DoanPhuongKhanh15319', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4530, 1, '61585933163105', 'KhuatDiemMy676', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4531, 1, '61585921703836', 'CaoKhoiKhanh68', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4532, 1, '61585663325855', 'AuNganSon94', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4533, 1, '61585887563233', 'TonVyNam9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4534, 1, '61585417337751', 'BuiMinhPhuc11', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4535, 1, '61585610797485', 'VuNamThinh7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4536, 1, '61585450304464', 'VoNhatVy614', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4537, 1, '61585451235941', 'BuiMyThanh354', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4538, 1, '61585712371861', 'ToBaoTran84', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4539, 1, '61585432005398', 'TongLeLinh387', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4540, 1, '61585785629600', 'NgoPhatUyen8617', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4541, 1, '61585458733758', 'ToHoangYen98', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4542, 1, '61585532351596', 'HuynhQuanLinh2400', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4543, 1, '61585746511446', 'PhamPhatPhuc79173', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4544, 1, '61585626156418', 'DuongVanKhanh82', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4545, 1, '61585880873777', 'LyVyVan85', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4546, 1, '61585903074690', 'PhamPhucDuy4789', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4547, 1, '61585434465534', 'DauHienQuan598', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4548, 1, '61585512073085', 'MacTamThien9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4549, 1, '61585667704274', 'PhanNhatNgan9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4550, 1, '61585606267051', 'VuHaiDang63396', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4551, 1, '61585671093937', 'DoanPhuongDuy19', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4552, 1, '61585922632830', 'HaLeThien432', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4553, 1, '61585611636843', 'PhamLongNam8581', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4554, 1, '61585936760766', 'DinhLienThanh85708', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4555, 1, '61585723711397', 'HaPhuQuan1083', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4556, 1, '61585433207314', 'QuachQuocVy2085', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4557, 1, '61585647877043', 'CaoMaiAn1316', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4558, 1, '61585906404754', 'HoVanThanh51', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4559, 1, '61585730280768', 'LeDuyKhanh587', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4560, 1, '61585770900062', 'ToBinh55124', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4561, 1, '61585623157695', 'ChauNamDuy86', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4562, 1, '61585669354571', 'VoXuanYen49', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4563, 1, '61585689484023', 'PhanSonBao340', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4564, 1, '61585729351506', 'MaiLanSon5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4565, 1, '61585966971541', 'TongVyNam53324', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4566, 1, '61585895183571', 'ChauHuuQuan5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4567, 1, '61585489332635', 'ToQuanDuy1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4568, 1, '61585694434167', 'DauVanPhuc51', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4569, 1, '61585480784201', 'DoanThanhVy95', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4570, 1, '61585898723007', 'PhamHanh2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4571, 1, '61585690714447', 'LyKhoiThinh3978', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4572, 1, '61585619166250', 'TrinhBaoHan15698', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4573, 1, '61585936521143', 'TranTriLong3353', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4574, 1, '61585890954416', 'DangLanLong9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4575, 1, '61585942851002', 'QuachPhuHan78448', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4576, 1, '61585515433197', 'QuachKienQuan1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4577, 1, '61585603929133', 'TranSonMy77531', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4578, 1, '61585960071338', 'DangHuuPhu7181', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4579, 1, '61585653274907', 'CaoMyKhoa47822', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4580, 1, '61585537540893', 'ChauHoa6639', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4581, 1, '61585816887131', 'AuVinhMy54', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4582, 1, '61585424596241', 'TrinhPhucMinh359', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4583, 1, '61585658884919', 'NguyenLanLinh254', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4584, 1, '61585604467500', 'DuongQuocVy967', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4585, 1, '61585429605307', 'TranUyenHuy34739', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4586, 1, '61585887624956', 'QuachHaNam2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4587, 1, '61585955632144', 'MacHaAnh43893', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4588, 1, '61585893832972', 'VoVyThao77203', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4589, 1, '61585476282706', 'DuongQuocKhoa78', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4590, 1, '61585691943071', 'VoQuocNam104', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4591, 1, '61585421985565', 'ToTanHuy158', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4592, 1, '61585512252713', 'DuongMaiBao716', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4593, 1, '61585505651587', 'NguyenThienNam5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4594, 1, '61585883243619', 'TongMyNgan75140', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4595, 1, '61585495212034', 'DinhKhanhPhat88', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4596, 1, '61585577259182', 'QuachLan6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4597, 1, '61585755541653', 'QuachXuanPhu82', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4598, 1, '61585851445097', 'VoThanhQuan58', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4599, 1, '61585875505447', 'HoVanKhanh7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4600, 1, '61585700793920', 'QuachBaoVy56', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4601, 1, '61585429846321', 'TrinhHaiNgan2248', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4602, 1, '61585405787749', 'DauTruongAn107', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4603, 1, '61585778968991', 'NgoVanPhuc7940', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4604, 1, '61585586139669', 'ChauNhatQuan57', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4605, 1, '61585639297027', 'NgoKimAn40', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4606, 1, '61585563699649', 'HaVyUyen956', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4607, 1, '61585608997090', 'QuachMinhPhu29', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4608, 1, '61585680063779', 'AuThaoKhoa4789', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4609, 1, '61585469293611', 'PhungVanUyen83236', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4610, 1, '61585504842923', 'ToNgocKhanh2308', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4611, 1, '61585842597471', 'DinhVanThao476', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4612, 1, '61585875774555', 'TaThinhPhuc8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4613, 1, '61585699892314', 'LeMaiNgoc7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4614, 1, '61585924792591', 'ChauHaiLinh856', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4615, 1, '61585503073879', 'LyThuan51', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4616, 1, '61585940212268', 'QuachVyHuy6714', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4617, 1, '61585419557946', 'HoSonQuan1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4618, 1, '61585691043355', 'NgoDinhLong3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4619, 1, '61585481834798', 'HoangHaiYen47', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4620, 1, '61585695064540', 'MaiThaiKhoa60370', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4621, 1, '61585665095618', 'ToDuyThai12297', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4622, 1, '61585817488974', 'DinhKhanhMy173', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4623, 1, '61585614787336', 'HoVySon97908', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4624, 1, '61585469713423', 'PhungMaiHuy0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4625, 1, '61585799487426', 'KhuatKyLinh3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4626, 1, '61585813077037', 'LeLuuUyen579', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4627, 1, '61585430625713', 'TrinhMyTri6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4628, 1, '61585834346177', 'ToHaKhang24', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4629, 1, '61585535230727', 'PhanThaoThien5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4630, 1, '61585471724474', 'PhungPhatVy132', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4631, 1, '61585510422663', 'DuongPhatNgan60', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4632, 1, '61585574829866', 'BuiPhuVan33508', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4633, 1, '61585621626834', 'MacPhuNgan14282', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4634, 1, '61585553381631', 'MacMyMinh802', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4635, 1, '61585924193461', 'QuachSonPhuc6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4636, 1, '61585591028486', 'MacVanQuan6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4637, 1, '61585755449583', 'ChauLongQuan995', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4638, 1, '61585923713578', 'HoangTanMy562', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4639, 1, '61585600147322', 'TrinhTruongTri270', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4640, 1, '61585642476923', 'DoNamVy7115', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4641, 1, '61585839357199', 'DinhKimHan41021', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4642, 1, '61585550262238', 'QuachMyBao776', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4643, 1, '61585910212675', 'PhamQuocThao224', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4644, 1, '61585738680788', 'KhuatLongKhanh770', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4645, 1, '61585550892102', 'DoMyBao0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4646, 1, '61585629997492', 'AuCongSon459', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4647, 1, '61585924373481', 'TaVinhHan18034', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4648, 1, '61585785659568', 'MaiVinhKhoa898', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4649, 1, '61585428885396', 'BuiNhatNgoc49238', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4650, 1, '61585427235498', 'DangKimUyen80', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4651, 1, '61585832936230', 'QuachYen6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4652, 1, '61585958841654', 'PhungHoangThao5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4653, 1, '61585559379523', 'QuachKyTri30014', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4654, 1, '61585623188093', 'MaiTriHuy4600', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4655, 1, '61585695602708', 'DinhSonVan7806', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4656, 1, '61585750442102', 'KhuatAnhKhoa1551', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4657, 1, '61585695934300', 'MacKhoiThanh9688', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4658, 1, '61585706794461', 'AuHuuKhanh4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4659, 1, '61585855166629', 'HuynhDinhDuy419', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4660, 1, '61585571141083', 'VuBaoKhang6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4661, 1, '61585740002312', 'VoVinhMinh69851', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4662, 1, '61585653426424', 'DuongDiemPhuong7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4663, 1, '61585672743688', 'DoanBaoYen353', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4664, 1, '61585884654001', 'ChauLanPhu11', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4665, 1, '61585413976347', 'HuynhNhatMy39', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4666, 1, '61585551459269', 'DinhLinhNgan4706', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4667, 1, '61585756290088', 'HuynhLongThanh34184', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4668, 1, '61585794419714', 'LaVanYen9995', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4669, 1, '61585645774955', 'ChauNganThien23525', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4670, 1, '61585719751381', 'DoTruongAn42', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4671, 1, '61585795229593', 'CaoNganPhuc43995', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4672, 1, '61585727580777', 'LeSonNgoc4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4673, 1, '61585516150905', 'NguyenThaiMy3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4674, 1, '61585699472258', 'QuachPhuongLong578', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4675, 1, '61585444484597', 'ChauXuanThao90940', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4676, 1, '61585563671614', 'KhuatNgocAn8982', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4677, 1, '61585448204710', 'HoangThaiPhu592', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4678, 1, '61585802487319', 'PhanDinhBao24', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4679, 1, '61585928333656', 'LaPhuongTri28264', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4680, 1, '61585964840708', 'AuHuuQuan355', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4681, 1, '61585521640435', 'DinhNhatKhanh664', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4682, 1, '61585417037755', 'DauTruongYen9711', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4683, 1, '61585926292912', 'DangNhatUyen46', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4684, 1, '61585635187089', 'NgoDinhTuan38166', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4685, 1, '61585473794993', 'BuiThaiThao1588', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4686, 1, '61585583379940', 'DauLienNgan8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4687, 1, '61585901904604', 'TrinhQuanNgan85', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4688, 1, '61585788869394', 'VuThaoThanh5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4689, 1, '61585838785866', 'NguyenTanLinh0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4690, 1, '61585839625888', 'TonMinhHuy50', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4691, 1, '61585980980257', 'LyNganPhat9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4692, 1, '61585519271392', 'TongHoangHan801', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4693, 1, '61585954221620', 'TranNgocSon7385', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4694, 1, '61585955750312', 'HoangKyUyen34633', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4695, 1, '61585511562398', 'VuMinhVan3344', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4696, 1, '61585776328875', 'NguyenThaiYen60150', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4697, 1, '61585603297749', 'ChauKyThien60', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4698, 1, '61585485494904', 'QuachNgocKhanh1294', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4699, 1, '61585889213814', 'BuiGiaPhu90', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4700, 1, '61585814398306', 'TonLuuUyen9694', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4701, 1, '61585505382031', 'DinhHung3451', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4702, 1, '61585963011119', 'DauPhuongPhat4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4703, 1, '61585656876120', 'PhungThinh4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4704, 1, '61585556379915', 'MaiPhucNgan46', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4705, 1, '61585910844494', 'NguyenHaLong988', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4706, 1, '61585837585894', 'LeDuy121', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4707, 1, '61585945162831', 'LyHienAn593', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4708, 1, '61585668936211', 'AuKhanhAn732', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4709, 1, '61585734031129', 'HoangKhanhNgan28081', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4710, 1, '61585755901096', 'TrinhGiaVi607', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4711, 1, '61585661976547', 'PhungKimKhanh17249', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4712, 1, '61585735350410', 'KhuatMinhThanh46460', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4713, 1, '61585889124924', 'QuachHoangUyen21', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4714, 1, '61585951312068', 'ToThinhPhat366', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4715, 1, '61585722751591', 'TranPhucNgoc145', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4716, 1, '61585527582186', 'HuynhXuan30', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4717, 1, '61585571139938', 'DinhGiaVi3348', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4718, 1, '61585714142188', 'TrinhAnhDuc71', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4719, 1, '61585956502122', 'LaLuuThao55085', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4720, 1, '61585854986202', 'LaKimKhoa8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4721, 1, '61585854806577', 'HoLinhHuy6853', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4722, 1, '61585531001619', 'HoangKyTri4868', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4723, 1, '61585450064189', 'TranQuocLinh13635', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4724, 1, '61585461854140', 'CaoHienDuy632', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4725, 1, '61585488733784', 'LaMinhQuan2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4726, 1, '61585720651252', 'PhungThienDuy3184', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4727, 1, '61585713571999', 'DinhLongVan528', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4728, 1, '61585432186869', 'TonKimThanh7057', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4729, 1, '61585885193665', 'PhanDiep2804', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4730, 1, '61585779628365', 'MaiHaTrang45', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4731, 1, '61586000690012', 'QuachTanPhuc5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4732, 1, '61585729351424', 'MaiPhuongNam85970', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4733, 1, '61585816797973', 'DoanVanLinh6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4734, 1, '61585587638103', 'MacSonYen437', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4735, 1, '61585426335321', 'TranDuyLong9288', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4736, 1, '61585571680855', 'QuachLongKhanh4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4737, 1, '61585800807339', 'LyNamThao10', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4738, 1, '61585983530609', 'TaHuuNgoc16', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4739, 1, '61585677485654', 'PhamHaiVan4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4740, 1, '61585452646166', 'TaLinhAn68669', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4741, 1, '61585402967281', 'ToVanKhoa111', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4742, 1, '61585920621850', 'VuLanLong825', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4743, 1, '61585478113166', 'PhamGiaThuan15721', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4744, 1, '61585527582189', 'BuiHaPhuc416', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4745, 1, '61585588689012', 'PhungGiaNhi13494', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4746, 1, '61585895844815', 'MaiBaoChau4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4747, 1, '61585592257951', 'TaNhatKhanh46', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4748, 1, '61585889393363', 'CaoKhoi307', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4749, 1, '61585817366688', 'TrinhSonThien78', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4750, 1, '61585885733510', 'TaLongThinh64', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4751, 1, '61585916333318', 'LaMyDuy535', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4752, 1, '61585568829048', 'HoKhanh78', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4753, 1, '61585738290707', 'HuynhAnhThu55560', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4754, 1, '61585735141879', 'PhamLy12', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4755, 1, '61585556619941', 'KhuatVinhMinh55', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4756, 1, '61585614307153', 'PhamSonThinh26483', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4757, 1, '61585941382487', 'LaChiMinh85215', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4758, 1, '61585833056050', 'DuongChiBao9053', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4759, 1, '61585901182567', 'ToKyUyen9782', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4760, 1, '61585429636843', 'NgoQuanVan7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4761, 1, '61585805159263', 'QuachCongTri9740', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4762, 1, '61585922841762', 'LyXuanNam6312', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4763, 1, '61585845567657', 'TaHienKhanh96600', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4764, 1, '61585452283798', 'HuynhPhatThao57933', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4765, 1, '61585517261045', 'TranHuuKhanh0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4766, 1, '61585521492090', 'TonDuyTung9321', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4767, 1, '61585410316273', 'ChauBaoVy7003', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4768, 1, '61585913242053', 'QuachKienNam2442', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4769, 1, '61585720171633', 'DoanMinhLong89', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4770, 1, '61585735410797', 'DauHaiNgan65', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4771, 1, '61585850876347', 'KhuatVanAnh802', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4772, 1, '61585654714630', 'QuachLuuSon0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4773, 1, '61585865035208', 'NgoTanNgoc93581', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4774, 1, '61585453125756', 'LaNamMinh63753', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4775, 1, '61585717472684', 'BuiHienYen49', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4776, 1, '61585455825605', 'TranLienYen356', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4777, 1, '61585938652491', 'MaiThaiTri6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4778, 1, '61585720111381', 'BuiBinhMinh7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4779, 1, '61585894883200', 'TonYenThien6388', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4780, 1, '61585459515621', 'TongDuyKhanh51', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4781, 1, '61585774769142', 'VuTrungYen92292', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4782, 1, '61585674154178', 'DinhKhanhQuan1403', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4783, 1, '61585817517731', 'TonHaoNhien15617', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4784, 1, '61585978760635', 'DangKienYen9455', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4785, 1, '61585796909804', 'PhanNamMinh9814', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4786, 1, '61585433086776', 'MaiPhucUyen5988', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4787, 1, '61585471694928', 'PhamYenLong42', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4788, 1, '61585406597011', 'VuAnh300', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4789, 1, '61585931123208', 'ChauLinhThien2446', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4790, 1, '61585449256567', 'BuiSonMy3864', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4791, 1, '61585944500631', 'KhuatDuyTri4407', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4792, 1, '61585766309084', 'HaLanLong4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4793, 1, '61585832128194', 'TongKienThanh54711', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4794, 1, '61585405966467', 'ToViet88', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4795, 1, '61585580680048', 'LeThanhThien4793', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4796, 1, '61585585450504', 'HuynhPhuongSon6204', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4797, 1, '61585898574648', 'ToPhuPhat49', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4798, 1, '61585810498156', 'NgoQuocMinh4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4799, 1, '61585624776268', 'BuiNamPhat4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4800, 1, '61585687832875', 'TranLeThinh7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4801, 1, '61585605127750', 'CaoVyVan7003', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4802, 1, '61585759949803', 'QuachNganNgoc4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4803, 1, '61585780119248', '9Ns5GC7BuJ', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4804, 1, '61585778518504', 'ChauVyPhuc5583', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4805, 1, '61585565200485', 'MacDiemTu75', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4806, 1, '61585584759271', 'LeQuanHan90068', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4807, 1, '61585946002248', 'LePhucLong73072', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4808, 1, '61585556949511', 'LeQuocSon12', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4809, 1, '61585403086716', 'HuynhKhoiTri6809', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4810, 1, '61585518373031', 'HoVanSon449', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4811, 1, '61585839535597', 'TongDiemVy1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4812, 1, '61585728301200', 'LaNamPhuc76202', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4813, 1, '61585693654450', 'PhungLienDuy5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4814, 1, '61585398257508', 'NgoMinhLinh404', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4815, 1, '61585836746003', 'TongTruongVan9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4816, 1, '61585899714887', 'VuAnKhang5244', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4817, 1, '61585515073386', 'KhuatPhuongMy2980', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4818, 1, '61585500523058', 'DinhLinhPhuc726', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4819, 1, '61585417247684', 'TranQuanAnh53', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4820, 1, '61585688764985', 'DuongVanNgoc8574', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4821, 1, '61585948880335', 'QuachThaoHuy554', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4822, 1, '61585582569564', 'QuachVanSon7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4823, 1, '61585946840592', 'HaLanMinh51', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4824, 1, '61585563549258', 'MaiNhatBao878', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4825, 1, '61585618777947', 'MaiNamTri810', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4826, 1, '61585676585382', 'LyNamTri2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4827, 1, '61586079144318', 'CXXMfXIbek', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4828, 1, '61585787640137', 'ToNhatVan2059', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4829, 1, '61585377347965', 'VuTrungKhoa1794', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4830, 1, '61585466445323', 'TonThienMy264', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4831, 1, '61585918884190', 'TonVanLong37454', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4832, 1, '61585721761775', 'PhungVinh46', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4833, 1, '61585728452410', 'DangThienThao9942', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4834, 1, '61585580320410', 'NguyenMyVy665', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4835, 1, '61585760519301', 'LaHaiBinh7588', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4836, 1, '61585822558459', 'PhanChiCong5559', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4837, 1, '61585961181233', 'TranPhucPhu762', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4838, 1, '61585880665040', 'KhuatKimHan21', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4839, 1, '61585856885705', 'PK8DHWZfvJ', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4840, 1, '61585630416067', 'TonDiemTrang3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4841, 1, '61585983110522', 'LaThanhVan9519', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03');
INSERT INTO `random_category_accounts` (`id`, `random_category_id`, `account_name`, `password`, `price`, `status`, `server`, `buyer_id`, `batch_id`, `note`, `note_buyer`, `thumbnail`, `created_at`, `updated_at`) VALUES
(4842, 1, '61585424596120', 'DoanLongThien83', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4843, 1, '61585669985688', 'HoVinhAn6127', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4844, 1, '61585571710247', 'HaLuuUyen20610', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4845, 1, '61585961211827', 'MacHienKhanh8531', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4846, 1, '61585799667442', 'DuongVySon7450', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4847, 1, '61585804139221', 'QuachTrungPhu93', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4848, 1, '61585474994775', 'HuynhVanKhoa6049', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4849, 1, '61585881685093', 'ChauPhucPhu4135', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4850, 1, '61585844515620', 'MaiVanPhu6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4851, 1, '61585418536223', 'AuLuuPhu4679', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4852, 1, '61585578098207', 'NguyenPhatPhuc38710', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4853, 1, '61585525810667', 'MaiQuanKhanh7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4854, 1, '61585926923656', 'KhuatHaiAn50108', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4855, 1, '61585580408398', 'DauLuuQuan5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4856, 1, '61585634317805', 'ChauThienSon2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4857, 1, '61585831196435', 'HoPhuHuy35', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4858, 1, '61585425047117', 'KhuatKhoiHuy14098', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4859, 1, '61585567629464', 'VuLuuNgoc2861', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4860, 1, '61585627386074', 'MacHienKhoa9815', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4861, 1, '61585701693862', 'DauMinhDuy64125', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4862, 1, '61585521340951', 'TrinhVinhAn7063', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4863, 1, '61585812807135', 'BuiSonThao991', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4864, 1, '61585608908355', 'HoangTanLinh661', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4865, 1, '61585722751339', 'VuLeVan5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4866, 1, '61585551158431', 'BuiTanThao465', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4867, 1, '61586123302158', 'dVKJSF1SIP', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4868, 1, '61585761540322', 'TaLinhPhu4795', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4869, 1, '61585673523603', 'ToMyLinh714', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4870, 1, '61585717443252', 'QuachLanThao25', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4871, 1, '61585421807721', 'ChauSonThien0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4872, 1, '61585390547435', 'TranHienBao22169', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4873, 1, '61585423035982', 'HuynhKhanhThao5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4874, 1, '61585738080907', 'MaiHaMy1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4875, 1, '61585851567274', 'HuynhHaAn74040', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4876, 1, '61585550351751', 'QuachPhatPhu791', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4877, 1, '61585915284211', 'QuachMinhPhu88', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4878, 1, '61585567570305', 'CaoHaiNgan8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4879, 1, '61585676165161', 'DoYenKhoa96', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4880, 1, '61585499292282', 'TaNganKhoa6962', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4881, 1, '61585483574145', 'DoLinhHuy4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4882, 1, '61585695722655', 'NguyenThaiMy54904', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4883, 1, '61585846166966', 'VoThanhThinh42550', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4884, 1, '61585575070531', 'QuachPhat10', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4885, 1, '61585946332179', 'HoangHienThanh9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4886, 1, '61585426215932', 'TaPhuSon5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4887, 1, '61585753229626', 'TaDuyThai10533', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4888, 1, '61585759739638', 'NgoCongHau4485', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4889, 1, '61585432967046', 'HaMyAnh87725', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4890, 1, '61585787039991', 'LeThaiKhanh91', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4891, 1, '61585857266891', 'CaoVanLinh4065', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4892, 1, '61585757580849', 'DoanHaThanh67388', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4893, 1, '61585661194521', 'HoangHienNgan236', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4894, 1, '61585436956342', 'MacDuyCuong48', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4895, 1, '61585535860754', 'CaoXuanDuy618', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4896, 1, '61585493592147', 'MacTruongHuy723', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4897, 1, '61585684354976', 'PhanKienAn973', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4898, 1, '61585527581136', 'HuynhPhucBao7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4899, 1, '61585931902711', 'ToKhanhLinh664', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4900, 1, '61585865576289', 'HaQuocThien13307', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4901, 1, '61585741080741', 'HaHaAn37119', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4902, 1, '61585680275227', 'LaNhatAn393', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4903, 1, '61585878626116', 'PhamPhucTri2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4904, 1, '61585384187801', 'AuThinhPhu7922', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4905, 1, '61585950860164', 'HoNganMy43239', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4906, 1, '61585562740777', 'DuongDinhLong6992', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4907, 1, '61585578789899', 'PhungPhuongTri9175', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4908, 1, '61585766911416', 'HoDiemTrinh5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4909, 1, '61585471693776', 'VuKhoa91', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4910, 1, '61585917744138', 'PhanTanThinh96322', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4911, 1, '61585538832011', 'TonBaoKhang2758', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4912, 1, '61585740310982', '4jbhhfEl6p', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4913, 1, '61585449766499', 'QuachQue47', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4914, 1, '61585763489511', 'VuTrungNgan59883', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4915, 1, '61585558781454', 'HoangUyenPhuc47210', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4916, 1, '61585914983505', 'DoThaoHuy3821', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4917, 1, '61585501453253', 'KhuatThaiNgoc4683', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4918, 1, '61585472985099', 'PhamLuuQuan41616', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4919, 1, '61585699953882', 'ToNamUyen6038', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4920, 1, '61585861796528', 'LaQuocThanh60729', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4921, 1, '61585463445484', 'HoangDiemTrang546', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4922, 1, '61585814877394', 'TranNganTri15937', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4923, 1, '61585947530372', 'MaiThaoPhuc4297', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4924, 1, '61585716123335', 'LaPhucVan44674', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4925, 1, '61585383317842', 'HoangSonDuy52', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4926, 1, '61585928003414', 'DauVinhVan6588', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4927, 1, '61585752869598', 'PhamNamLinh368', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4928, 1, '61585566278173', 'DauPhatNgoc63', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4929, 1, '61585778729452', 'VuTamQuan68', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4930, 1, '61585552751588', 'TongDaThao54', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4931, 1, '61585750981975', 'HuynhTanDuy842', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4932, 1, '61585654354902', 'LyVyMinh296', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4933, 1, '61585741650781', 'DauLongNgoc471', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4934, 1, '61585964091115', 'TranMyVan30003', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4935, 1, '61585538680168', 'MaiPhuongNam379', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4936, 1, '61585774048338', 'TrinhLuuAnh82509', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4937, 1, '61585673523989', 'MacMyVy43', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4938, 1, '61585917711839', 'BuiPhuongNgoc1638', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4939, 1, '61585453544185', 'QuachTamTri83', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4940, 1, '61585569008939', 'NgoKhoiNam913', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4941, 1, '61585895333698', 'DinhLoan974', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4942, 1, '61585814157424', 'PhungThaiMy3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4943, 1, '61585826188705', 'PhamThaoNam622', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4944, 1, '61585644635053', 'HoangSonQuan399', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4945, 1, '61585625016387', 'LePhuongThien5648', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4946, 1, '61585810679280', 'HuynhMyThinh43169', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4947, 1, '61585683935433', 'QuachTriLinh5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4948, 1, '61585574288743', 'BuiDuyQuang4484', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4949, 1, '61585809746971', 'TongPhucTri39657', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4950, 1, '61585923563482', 'PhanLienBao895', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4951, 1, '61585593639753', 'DoTamHuy7086', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4952, 1, '61585450244258', 'DangKhanhBao150', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4953, 1, '61585643677006', 'TranLanVan3984', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4954, 1, '61585942132886', 'KhuatLeHan1112', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4955, 1, '61585582838420', 'QuachKyUyen39', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4956, 1, '61585958360024', 'DoHuuVan521', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4957, 1, '61585631646996', 'LaHienVy133', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4958, 1, '61585941590694', 'DoAnKhanh6140', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4959, 1, '61585708623496', 'TaTruongPhat70532', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4960, 1, '61585610257956', 'HoangDuyMinh6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4961, 1, '61586141421254', 'UN31ChDM3P', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4962, 1, '61586102363230', '9iZC4PCLtx', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4963, 1, '61585772409508', '3Uxr8Stv3A', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4964, 1, '61585876114742', 'H83pj7av59', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4965, 1, '61586011407979', 'Grio9bsdzY', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4966, 1, '61585711512830', 'n7kHco1vsj', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4967, 1, '61585731791581', 'qOqQfdXlXj', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4968, 1, '61585795319015', 'DoNhatNgan6859', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4969, 1, '61585501753758', 'AuTruongAn5922', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4970, 1, '61585631646493', 'TongHaiLong338', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4971, 1, '61585761631020', 'DangUyenHuy25', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4972, 1, '61585385537612', 'LePhatBao41228', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4973, 1, '61585944830618', 'HuynhNhung8600', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4974, 1, '61585461885830', 'BuiNhatHuy0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4975, 1, '61585491582679', 'TrinhMinhVy0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4976, 1, '61585469683544', 'MacLinhNam8973', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4977, 1, '61585508773126', 'LyThienKhanh297', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4978, 1, '61585779628218', 'TaPhuongUyen9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4979, 1, '61585934152592', 'LyVanPhuc5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4980, 1, '61585577198496', 'DuongLienLong16', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4981, 1, '61585815027361', 'HoangHaiKhanh40701', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4982, 1, '61585444186876', 'ChauNamBao70', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4983, 1, '61585585420622', 'LaThienMy117', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4984, 1, '61585792137636', 'DauDuyKhoi7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4985, 1, '61585945372710', 'KhuatDuyNam3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4986, 1, '61585737570564', 'LyLongQuan7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4987, 1, '61585468183530', 'MacDaThu4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4988, 1, '61585458284018', 'BuiNgocVy486', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4989, 1, '61585755691680', 'LaDinhMinh46147', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4990, 1, '61585869534417', 'DoThaoVy2162', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4991, 1, '61585462394430', 'ToNhatAnh3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4992, 1, '61585904992851', 'AuAnKhanh7338', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4993, 1, '61585860024911', 'LeVinhYen1580', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4994, 1, '61585463055372', 'TonChiHieu6122', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4995, 1, '61585729562148', 'DauTruongThinh3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4996, 1, '61585438156451', 'DauKhanhAnh242', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4997, 1, '61585465963336', 'DoMyDuy37', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4998, 1, '61585588119953', 'DauNganThao4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(4999, 1, '61585474333625', 'PhanHuuYen44526', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5000, 1, '61585672294210', 'HaKienTri2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5001, 1, '61585418685809', 'DoUyenNgoc62224', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5002, 1, '61585773298486', 'TonHaTri23615', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5003, 1, '61585963910966', 'DoanDuyLong81122', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5004, 1, '61585737062215', 'ToAnhKhoa74229', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5005, 1, '61585512822913', 'DauThaiSon2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5006, 1, '61585467583794', 'DauMyBao2486', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5007, 1, '61585445895454', 'VoPhatThien531', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5008, 1, '61585759441385', 'MacQuocThinh1405', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5009, 1, '61585868304885', 'LeDuyViet191', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5010, 1, '61585676643489', 'TonNhatThanh8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5011, 1, '61585426187874', 'AuThienAnh897', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5012, 1, '61585574409261', 'NgoPhuKhanh7808', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5013, 1, '61585449346017', 'MacHoangHuy855', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5014, 1, '61585613916804', 'VoPhatUyen6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5015, 1, '61585751911410', 'AuPhatNam0', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5016, 1, '61585914682423', 'DangKhoiThien33', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5017, 1, '61585934243006', 'TongLienNgoc2800', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5018, 1, '61585634917620', 'AuNganKhanh1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5019, 1, '61585880994371', 'NguyenThanhHan7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5020, 1, '61585565949899', 'DauKyLinh33', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5021, 1, '61585814696842', 'HoangTanKhanh48', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5022, 1, '61585520473295', 'PhanVinhThao5605', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5023, 1, '61585930731605', 'PhanLienVy7721', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5024, 1, '61585632785715', 'PhanPhuAnh646', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5025, 1, '61585556679972', 'MaiHuuAnh7312', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5026, 1, '61585482043093', 'TrinhTriKhoa8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5027, 1, '61585403717314', 'MaiHuuNgoc55', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5028, 1, '61585805727456', 'NgoGiaNguyen6328', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5029, 1, '61585928241432', 'ChauDuyMinh99', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5030, 1, '61585811877011', 'BuiHienLong47679', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5031, 1, '61585505023797', 'AuNamPhat462', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5032, 1, '61585550830984', 'KhuatTanThinh91', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5033, 1, '61585696832302', 'NguyenCongHau410', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5034, 1, '61585405576930', 'NgoKimPhuc8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5035, 1, '61585434705744', 'NguyenHaNam801', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5036, 1, '61585807288057', 'DoPhuPhat3427', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5037, 1, '61585810497321', 'DoMinhThanh675', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5038, 1, '61585652104830', 'NguyenNganPhat4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5039, 1, '61585756649954', 'BuiKienMinh412', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5040, 1, '61585557281154', 'TaNgocThinh7800', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5041, 1, '61585654805182', 'DauVyKhoa13', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5042, 1, '61585733882097', 'BuiKhanhLinh8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5043, 1, '61585890294672', 'TrinhLongThanh119', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5044, 1, '61585392737913', 'VoLeMy40512', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5045, 1, '61585863924738', 'MacLinhUyen6037', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5046, 1, '61585605608408', 'NgoHoangKhanh52171', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5047, 1, '61585872924055', 'ChauNhat14', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5048, 1, '61585631945925', 'PhanThaoVan7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5049, 1, '61585651206532', 'NgoNhatTri7863', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5050, 1, '61585444184555', 'TranTamKhanh8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5051, 1, '61585833686294', 'AuVinhUyen94338', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5052, 1, '61585890535358', 'DoanNhatHuy15', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5053, 1, '61585463055762', 'NgoPhucNgoc48078', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5054, 1, '61585734092004', 'TranLongVan5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5055, 1, '61585752149910', 'MaiDinhVinh4', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5056, 1, '61585884683611', 'TongNgocThien391', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5057, 1, '61585616528078', 'DoLanKhoa6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5058, 1, '61585621357127', 'QuachKimLinh97232', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5059, 1, '61585558179616', 'TonTruongAn91995', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5060, 1, '61585852165674', 'HuynhDinhTrung2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5061, 1, '61585498332907', 'HaKyAnh65', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5062, 1, '61585930972590', 'TranVanThanh2275', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5063, 1, '61585413106132', 'KhuatPhuongNgoc22', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5064, 1, '61585815807319', 'QuachHaiAn928', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5065, 1, '61585391897541', 'HaTrang97', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5066, 1, '61585895483065', 'PhanMaiThien5910', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5067, 1, '61585437856830', 'DinhLienQuan7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5068, 1, '61585440557081', 'DuongVyThanh6423', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5069, 1, '61585938261895', 'HaKimNgoc612', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5070, 1, '61585703434674', 'DauHaiHuy77', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5071, 1, '61585707451834', 'BuiHuuSon1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5072, 1, '61585944920359', 'KhuatKimNam55', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5073, 1, '61585525660964', 'LaXuanYen37688', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5074, 1, '61585627537613', 'DoNam36', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5075, 1, '61585428285190', 'TrinhVanUyen24', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5076, 1, '61585714412035', 'TrinhKyThao120', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5077, 1, '61585923771798', 'TongKyAn94', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5078, 1, '61585923983783', 'TrinhSonAnh98735', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5079, 1, '61585816018507', 'TongNhatQuan1435', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5080, 1, '61585524520752', 'CaoKhoiNam96741', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5081, 1, '61585636267372', 'HaNam65', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5082, 1, '61585386317999', 'TranKimHan9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5083, 1, '61585900252924', 'HaKyNam1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5084, 1, '61585483094292', 'VuTriKhanh92', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5085, 1, '61585689784813', 'DoYenPhu2', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5086, 1, '61585698634548', 'QuachQuocVan852', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5087, 1, '61585634887115', 'MacPhatPhuc6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5088, 1, '61585436386834', 'QuachTanMy8821', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5089, 1, '61585442356671', 'CaoKienMy57', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5090, 1, '61585766611064', 'MaiLinhBao33', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5091, 1, '61585515670949', 'VoMinhHan17', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5092, 1, '61585875206049', 'LyLuuMy904', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5093, 1, '61585698512991', 'PhanQuanKhoa3706', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5094, 1, '61585676315201', 'DuongNganLong86735', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5095, 1, '61585878534367', 'TranThinhAnh43778', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5096, 1, '61585912882028', 'MaiTanDuy5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5097, 1, '61585826697063', 'DinhThaoLinh2554', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5098, 1, '61585809958502', 'MaiKimNgan4199', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5099, 1, '61585767571314', 'TonVinhThao5507', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5100, 1, '61585389947281', 'TranLeBao746', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5101, 1, '61585520172835', 'HuynhNgocLong77983', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5102, 1, '61585888524911', 'TonXuanHan726', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5103, 1, '61585742610414', 'AuGiaKhanh4608', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5104, 1, '61585425076504', 'QuachQuanKhanh3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5105, 1, '61585538320145', 'HaChiTai38', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5106, 1, '61585573930707', 'HuynhTruongThanh9169', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5107, 1, '61585466175410', 'KhuatThienHuy605', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5108, 1, '61585692273942', 'ChauVanKhanh45485', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5109, 1, '61585691733793', 'TaTrong30350', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5110, 1, '61585583648296', 'LyKienThien284', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5111, 1, '61585613438750', 'DauNgocQuan2455', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5112, 1, '61585483124365', 'LaKimThinh62024', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5113, 1, '61585423007881', 'LyHoangKhanh7618', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5114, 1, '61585413046265', 'HuynhLanPhu61', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5115, 1, '61585720561402', 'PhungPhat337', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5116, 1, '61585836657480', 'PhungLinhUyen22737', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5117, 1, '61585798918701', 'QuachThienBao325', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5118, 1, '61585525212776', 'LeQuocSon2118', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5119, 1, '61585664945952', 'PhanLeThanh6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5120, 1, '61585638097659', 'ToChiDung6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5121, 1, '61585932471140', 'ChauMinhThanh66', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5122, 1, '61585949900334', 'VoThaiYen3220', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5123, 1, '61585903254450', 'ChauLeMy60060', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5124, 1, '61585588268384', 'DangPhuong64547', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5125, 1, '61585574558881', 'DinhMaiSon1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5126, 1, '61585688794651', 'TonThienNam7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5127, 1, '61585811157424', 'DauNga5250', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5128, 1, '61585731632716', 'TrinhMinhKhoa4966', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5129, 1, '61585941140553', 'TrinhLanQuan78925', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5130, 1, '61585822016711', 'NgoQuocAnh9570', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5131, 1, '61585924131678', 'MacVyPhat3116', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5132, 1, '61585782450582', 'HoTanUyen49', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5133, 1, '61585704574329', 'VoKhanhPhuc7207', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5134, 1, '61585819557181', 'QuachLePhat7', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5135, 1, '61585638515371', 'TranSonLinh13867', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5136, 1, '61585939970926', 'DauCongLy9730', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5137, 1, '61585837826021', 'HuynhPhuongMy5', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5138, 1, '61585952150634', 'PhamDiemHan1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5139, 1, '61585601737839', 'DoanThaiKhoa5976', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5140, 1, '61585698692730', 'NguyenVyMinh40', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5141, 1, '61585544770300', 'PhungVanUyen613', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5142, 1, '61585524312524', 'TrinhLinh7644', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5143, 1, '61585756349995', 'DuongUyenNam5086', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5144, 1, '61585621328509', 'HoangMinhTri1264', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5145, 1, '61585658405025', 'TonBaoMinh961', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5146, 1, '61585466205278', 'VoMinh50', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5147, 1, '61585536701173', 'DoanPhuongVan403', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5148, 1, '61585817098648', 'VuVanVy71275', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5149, 1, '61585508352840', 'DauKienHan3', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5150, 1, '61585805547340', 'BuiMyVy8864', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5151, 1, '61585739160427', 'DoSonNgoc56', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5152, 1, '61585614488697', 'DauPhuThinh753', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5153, 1, '61585509671424', 'TranHoangMinh6', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5154, 1, '61585908384212', 'VoKienVan9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5155, 1, '61585630207476', 'PhamTruongThinh118', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5156, 1, '61585880635349', 'TonPhuongSon25698', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5157, 1, '61585943901211', 'VuHoangTri38327', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5158, 1, '61585400476784', 'DauMyLong1', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5159, 1, '61585777799878', 'QuachHaiThanh978', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5160, 1, '61585876644129', 'MaiLinhBao9', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5161, 1, '61585811999241', 'PhungThaoThien994', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5162, 1, '61585586437957', 'TranHaiHan6586', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5163, 1, '61585779448204', 'DinhGiaNhi60', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5164, 1, '61585882406002', 'QuachKimAn911', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5165, 1, '61585604317255', 'CaoDaThu9667', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5166, 1, '61585583230428', 'DoQuocThanh434', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03'),
(5167, 1, '61585844515555', 'DuongNhatUyen8', 20000, 'available', 1, NULL, NULL, NULL, NULL, NULL, '2026-06-22 17:19:03', '2026-06-22 17:19:03');

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

--
-- Đang đổ dữ liệu cho bảng `usdt_deposits`
--

INSERT INTO `usdt_deposits` (`id`, `user_id`, `request_code`, `usdt_amount`, `exchange_rate`, `vnd_amount`, `status`, `transaction_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'USDT_1783433402_1', 10.00, 25000, 250000, 'pending', NULL, '2026-07-07 14:10:02', '2026-07-07 14:10:02'),
(2, 1, 'USDT_1783433691_1', 100.00, 25000, 2500000, 'pending', NULL, '2026-07-07 14:14:51', '2026-07-07 14:14:51'),
(3, 1, 'USDT_1783433924_1', 100.00, 25000, 2500000, 'pending', NULL, '2026-07-07 14:18:44', '2026-07-07 14:18:44'),
(4, 1, 'USDT_1783434092_1', 1000.00, 25000, 25000000, 'pending', NULL, '2026-07-07 14:21:32', '2026-07-07 14:21:32'),
(5, 1, 'USDT_1783434359_1', 10.00, 25000, 250000, 'pending', NULL, '2026-07-07 14:25:59', '2026-07-07 14:25:59'),
(6, 1, 'USDT_1783434363_1', 1000.00, 25000, 25000000, 'pending', NULL, '2026-07-07 14:26:03', '2026-07-07 14:26:03'),
(7, 1, 'USDT_1783434885_1', 100.00, 25000, 2500000, 'pending', NULL, '2026-07-07 14:34:45', '2026-07-07 14:34:45'),
(8, 1, 'USDT_1783435032_1', 100.00, 25000, 2500000, 'pending', NULL, '2026-07-07 14:37:12', '2026-07-07 14:37:12'),
(9, 1, 'USDT1', 1.00, 25000, 25000, 'pending', NULL, '2026-07-07 14:40:47', '2026-07-07 14:40:47'),
(10, 1, 'Nap1', 1.00, 25000, 25000, 'pending', NULL, '2026-07-07 14:44:06', '2026-07-07 14:44:06'),
(17, 1, 'USDT_1783435798_1', 123.00, 25000, 3075000, 'pending', NULL, '2026-07-07 14:49:58', '2026-07-07 14:49:58'),
(18, 1, 'USDT_1783435818_1', 22.00, 25000, 550000, 'pending', NULL, '2026-07-07 14:50:18', '2026-07-07 14:50:18'),
(19, 1, 'USDT_1783435903_1', 3.00, 25000, 75000, 'pending', NULL, '2026-07-07 14:51:43', '2026-07-07 14:51:43'),
(20, 1, 'USDT_1783435923_1', 3.00, 25000, 75000, 'pending', NULL, '2026-07-07 14:52:03', '2026-07-07 14:52:03'),
(21, 1, 'USDT_1783435979_1', 145.00, 25000, 3625000, 'pending', NULL, '2026-07-07 14:52:59', '2026-07-07 14:52:59');

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
(1, NULL, 'quyetcoder2k3', '$2y$12$L1OIpY73loCh9m5HUCkSOepuyTfvbTRhiXHU6rnlZrBofQoaL.8C2', 'chaysub.vn@gmail.com', NULL, NULL, 'admin', 0, 0, 20000, 1550000000, 18723, 0, '127.0.0.1', 'U9Zgjr9vp4q1qsNItWaRLL8R3rWJ2gtEr1a3SzuCRLq56eJsPAJVoBYpK6Rz', NULL, '2026-06-20 14:18:43', '2026-07-07 15:19:12'),
(2, NULL, 'administrator', '$2y$12$kzB.3hU2K.ItjqIX6zoPY.JsnsyJY8uUwZObp67snb6YJp/W5alpu', 'administrator@gmail.com', NULL, NULL, 'member', 0, 0, 0, 0, 0, 0, '127.0.0.1', NULL, NULL, '2026-06-21 08:25:48', '2026-06-21 08:25:48'),
(3, NULL, 'testuser123', '$2y$12$UYj8lKqV2csRd0eznDLx2OrMnT67MZFcvg6CkXzBVO9PDCMcZHmx2', 'testuser123@example.com', NULL, NULL, 'member', 0, 0, 0, 0, 0, 0, '127.0.0.1', NULL, NULL, '2026-07-07 14:23:34', '2026-07-07 14:23:34'),
(4, 1, 'cayxusmm', '$2y$12$RyUqvtvKTJRaeDEDm/kZ3.00nxUffRKAqkbIlWW3musCwMkmEYW3q', 'hungrtuithyuh11@gmail.com', NULL, NULL, 'member', 0, 0, 0, 0, 0, 0, '127.0.0.1', NULL, NULL, '2026-07-08 13:05:19', '2026-07-08 13:05:19');

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
-- Đang đổ dữ liệu cho bảng `withdrawal_histories`
--

INSERT INTO `withdrawal_histories` (`id`, `user_id`, `amount`, `type`, `game`, `character_name`, `server`, `user_note`, `admin_note`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1000, 'gem', NULL, '426563', '1', '5767', '5435', 'error', '2026-06-22 17:31:00', '2026-07-07 14:54:18'),
(2, 1, 1000, 'gem', NULL, '-09=09=-0', '1', '=-0=', '3324234', 'error', '2026-06-22 17:53:50', '2026-07-07 14:54:14');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `configs`
--
ALTER TABLE `configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `game_categories`
--
ALTER TABLE `game_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `game_groups`
--
ALTER TABLE `game_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `money_transactions`
--
ALTER TABLE `money_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `money_withdrawal_histories`
--
ALTER TABLE `money_withdrawal_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
