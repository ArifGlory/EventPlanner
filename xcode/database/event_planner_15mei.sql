-- -------------------------------------------------------------
-- TablePlus 5.3.4(492)
--
-- https://tableplus.com/
--
-- Database: event_planner
-- Generation Time: 2023-05-15 15:01:28.8290
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE `activity_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `log_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `causer_id` int DEFAULT NULL,
  `causer_type` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `batch_uuid` int DEFAULT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` int DEFAULT NULL,
  `subject_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=191 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `berita`;
CREATE TABLE `berita` (
  `berita_id` int NOT NULL AUTO_INCREMENT,
  `berita_title` varchar(255) DEFAULT NULL,
  `berita_category_id` int DEFAULT NULL,
  `berita_content` text,
  `berita_tag` varchar(255) DEFAULT NULL,
  `berita_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `berita_hit` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`berita_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `event_id` int NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) DEFAULT NULL,
  `event_category_id` int DEFAULT NULL,
  `event_waktu` datetime DEFAULT NULL,
  `event_talent` text,
  `event_lokasi` text,
  `event_harga_tiket` int DEFAULT '0',
  `event_stok_tiket` int NOT NULL DEFAULT '0',
  `event_poster` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `event_latitude` double DEFAULT NULL,
  `event_longitude` double DEFAULT NULL,
  `event_has_discount` tinyint(1) NOT NULL DEFAULT '0',
  `event_discount` double DEFAULT NULL,
  `event_description` text,
  `created_by` int DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_var` varchar(200) DEFAULT NULL,
  `setting_val` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `store`;
CREATE TABLE `store` (
  `store_id` int NOT NULL AUTO_INCREMENT,
  `store_pemilik` int DEFAULT NULL,
  `store_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_type` enum('offline','online') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'online',
  `store_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `store_tags` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_logo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `user_has_role`;
CREATE TABLE `user_has_role` (
  `id_has_role` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `role_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_has_role`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` enum('admin','superadmin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `store_description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `activity_log` (`id`, `log_name`, `properties`, `causer_id`, `causer_type`, `batch_uuid`, `description`, `event`, `subject_id`, `subject_type`, `updated_at`, `created_at`) VALUES
(1, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-04 21:05:35', '2023-01-04 21:05:35'),
(2, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-04 21:16:44', '2023-01-04 21:16:44'),
(3, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-04 21:16:44', '2023-01-04 21:16:44'),
(4, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-04 21:18:35', '2023-01-04 21:18:35'),
(5, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-04 22:59:46', '2023-01-04 22:59:46'),
(6, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-04 22:59:56', '2023-01-04 22:59:56'),
(7, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-04 23:05:18', '2023-01-04 23:05:18'),
(8, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-05 13:56:01', '2023-01-05 13:56:01'),
(9, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-09 09:13:18', '2023-01-09 09:13:18'),
(10, 'stores', '{\"attributes\":{\"store_name\":\"Hadinata Batik\",\"store_id\":2}}', 46, 'App\\Models\\User', NULL, 'stores created', 'created', 2, 'App\\Models\\Stores', '2023-01-09 09:19:37', '2023-01-09 09:19:37'),
(11, 'stores', '{\"attributes\":{\"store_name\":\"Hadinata Batik updated\"},\"old\":{\"store_name\":\"Hadinata Batik\"}}', 46, 'App\\Models\\User', NULL, 'stores updated', 'updated', 2, 'App\\Models\\Stores', '2023-01-09 10:04:59', '2023-01-09 10:04:59'),
(12, 'stores', '{\"attributes\":{\"store_name\":\"Hadinata Batik\"},\"old\":{\"store_name\":\"Hadinata Batik updated\"}}', 46, 'App\\Models\\User', NULL, 'stores updated', 'updated', 2, 'App\\Models\\Stores', '2023-01-09 10:05:10', '2023-01-09 10:05:10'),
(13, 'stores', '{\"attributes\":{\"store_name\":\"tes\",\"store_id\":3}}', 46, 'App\\Models\\User', NULL, 'stores created', 'created', 3, 'App\\Models\\Stores', '2023-01-09 10:14:16', '2023-01-09 10:14:16'),
(14, 'stores', '{\"old\":{\"store_name\":\"tes\",\"store_id\":3}}', 46, 'App\\Models\\User', NULL, 'stores deleted', 'deleted', 3, 'App\\Models\\Stores', '2023-01-09 10:31:43', '2023-01-09 10:31:43'),
(15, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-09 13:35:35', '2023-01-09 13:35:35'),
(16, 'user', '{\"old\":{\"name\":\"Toko 1\",\"email\":\"user2@gmail.com\",\"avatar\":null}}', 46, 'App\\Models\\User', NULL, 'pengguna Toko 1 deleted', 'deleted', 81, 'App\\Models\\User', '2023-01-09 14:20:29', '2023-01-09 14:20:29'),
(17, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-10 09:51:36', '2023-01-10 09:51:36'),
(18, 'xpoint', '{\"attributes\":{\"kategori\":null,\"status\":null}}', 46, 'App\\Models\\User', NULL, 'kategori  created', 'created', 3, 'App\\Models\\Category', '2023-01-10 10:59:21', '2023-01-10 10:59:21'),
(19, 'xpoint', '{\"attributes\":{\"kategori\":null,\"status\":null}}', 46, 'App\\Models\\User', NULL, 'kategori  created', 'created', 4, 'App\\Models\\Category', '2023-01-10 10:59:34', '2023-01-10 10:59:34'),
(20, 'xpoint', '{\"attributes\":{\"kategori\":null,\"status\":null}}', 46, 'App\\Models\\User', NULL, 'kategori  created', 'created', 5, 'App\\Models\\Category', '2023-01-10 10:59:45', '2023-01-10 10:59:45'),
(21, 'xpoint', '{\"attributes\":{\"kategori\":null,\"status\":null}}', 46, 'App\\Models\\User', NULL, 'kategori  created', 'created', 6, 'App\\Models\\Category', '2023-01-10 10:59:59', '2023-01-10 10:59:59'),
(22, 'xpoint', '{\"old\":{\"kategori\":null,\"status\":null}}', 46, 'App\\Models\\User', NULL, 'kategori  deleted', 'deleted', 1, 'App\\Models\\Category', '2023-01-10 11:01:53', '2023-01-10 11:01:53'),
(23, 'xpoint', '{\"attributes\":{\"subkategori\":null,\"status\":null}}', 46, 'App\\Models\\User', NULL, 'subkategori  created', 'created', 1, 'App\\Models\\SubCategory', '2023-01-10 11:26:14', '2023-01-10 11:26:14'),
(24, 'xpoint', '{\"attributes\":{\"subkategori\":null,\"status\":null}}', 46, 'App\\Models\\User', NULL, 'subkategori  created', 'created', 2, 'App\\Models\\SubCategory', '2023-01-10 11:26:29', '2023-01-10 11:26:29'),
(25, 'xpoint', '{\"attributes\":{\"subkategori\":null,\"status\":null}}', 46, 'App\\Models\\User', NULL, 'subkategori  created', 'created', 3, 'App\\Models\\SubCategory', '2023-01-10 11:26:43', '2023-01-10 11:26:43'),
(26, 'xpoint', '{\"attributes\":{\"subkategori\":null,\"status\":null}}', 46, 'App\\Models\\User', NULL, 'subkategori  created', 'created', 4, 'App\\Models\\SubCategory', '2023-01-10 11:29:48', '2023-01-10 11:29:48'),
(27, 'xpoint', '{\"old\":{\"subkategori\":null,\"status\":null}}', 46, 'App\\Models\\User', NULL, 'subkategori  deleted', 'deleted', 4, 'App\\Models\\SubCategory', '2023-01-10 11:29:52', '2023-01-10 11:29:52'),
(28, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-10 11:36:07', '2023-01-10 11:36:07'),
(29, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-10 11:36:48', '2023-01-10 11:36:48'),
(30, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-16 19:47:06', '2023-01-16 19:47:06'),
(31, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-16 19:53:16', '2023-01-16 19:53:16'),
(32, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-16 19:58:15', '2023-01-16 19:58:15'),
(33, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-16 21:37:20', '2023-01-16 21:37:20'),
(34, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-20 19:21:00', '2023-01-20 19:21:00'),
(35, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-20 21:52:04', '2023-01-20 21:52:04'),
(36, 'stores', '{\"attributes\":{\"product_name\":\"Kemeja flanel pria\",\"product_id\":1}}', 46, 'App\\Models\\User', NULL, 'product created', 'created', 1, 'App\\Models\\Product', '2023-01-20 22:48:23', '2023-01-20 22:48:23'),
(37, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-23 20:22:17', '2023-01-23 20:22:17'),
(38, 'stores', '{\"attributes\":{\"store_name\":\"Jumawa Batik\"},\"old\":{\"store_name\":\"Hadinata Batik\"}}', 46, 'App\\Models\\User', NULL, 'stores updated', 'updated', 4, 'App\\Models\\Stores', '2023-01-23 20:56:27', '2023-01-23 20:56:27'),
(39, 'stores', '{\"attributes\":{\"store_name\":\"Pandawa Batik\"},\"old\":{\"store_name\":\"Jumawa Batik\"}}', 46, 'App\\Models\\User', NULL, 'stores updated', 'updated', 4, 'App\\Models\\Stores', '2023-01-23 20:56:33', '2023-01-23 20:56:33'),
(40, 'stores', '{\"attributes\":{\"store_name\":\"Jumawa Batik\"},\"old\":{\"store_name\":\"Hadinata Batik\"}}', 46, 'App\\Models\\User', NULL, 'stores updated', 'updated', 5, 'App\\Models\\Stores', '2023-01-23 20:56:41', '2023-01-23 20:56:41'),
(41, 'voucher', '{\"attributes\":{\"voucher_name\":\"Cashback 5RB Min. Pembelian 200RB\",\"voucher_id\":1}}', 46, 'App\\Models\\User', NULL, 'voucher created', 'created', 1, 'App\\Models\\Voucher', '2023-01-23 21:07:44', '2023-01-23 21:07:44'),
(42, 'voucher', '{\"attributes\":{\"voucher_name\":\"Tes mau di apus\"},\"old\":{\"voucher_name\":\"Cashback 5RB Min. Pembelian 200RB\"}}', 46, 'App\\Models\\User', NULL, 'voucher updated', 'updated', 2, 'App\\Models\\Voucher', '2023-01-23 21:23:04', '2023-01-23 21:23:04'),
(43, 'voucher', '{\"old\":{\"voucher_name\":\"Tes mau di apus\",\"voucher_id\":2}}', 46, 'App\\Models\\User', NULL, 'voucher deleted', 'deleted', 2, 'App\\Models\\Voucher', '2023-01-23 21:23:07', '2023-01-23 21:23:07'),
(44, 'login', '[]', 80, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-26 10:47:59', '2023-01-26 10:47:59'),
(45, 'logout', '[]', 80, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-26 10:48:52', '2023-01-26 10:48:52'),
(46, 'login', '[]', 80, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-26 10:49:32', '2023-01-26 10:49:32'),
(47, 'logout', '[]', 80, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-26 10:49:35', '2023-01-26 10:49:35'),
(48, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-26 11:03:15', '2023-01-26 11:03:15'),
(49, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-26 11:03:19', '2023-01-26 11:03:19'),
(50, 'login', '[]', 80, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-26 11:03:31', '2023-01-26 11:03:31'),
(51, 'logout', '[]', 80, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-26 11:03:45', '2023-01-26 11:03:45'),
(52, 'login', '[]', 80, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-26 11:04:17', '2023-01-26 11:04:17'),
(53, 'logout', '[]', 80, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-26 11:51:42', '2023-01-26 11:51:42'),
(54, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-26 13:45:02', '2023-01-26 13:45:02'),
(55, 'stores', '{\"attributes\":{\"product_name\":\"Springbed Standar\",\"product_id\":2}}', 46, 'App\\Models\\User', NULL, 'product created', 'created', 2, 'App\\Models\\Product', '2023-01-26 13:51:00', '2023-01-26 13:51:00'),
(56, 'stores', '{\"attributes\":{\"product_name\":\"Springbed Standar aja\"},\"old\":{\"product_name\":\"Springbed Standar\"}}', 46, 'App\\Models\\User', NULL, 'product updated', 'updated', 2, 'App\\Models\\Product', '2023-01-26 13:51:53', '2023-01-26 13:51:53'),
(57, 'stores', '{\"attributes\":{\"product_name\":\"Springbed Standar\"},\"old\":{\"product_name\":\"Springbed Standar aja\"}}', 46, 'App\\Models\\User', NULL, 'product updated', 'updated', 2, 'App\\Models\\Product', '2023-01-26 13:52:00', '2023-01-26 13:52:00'),
(58, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-26 13:52:11', '2023-01-26 13:52:11'),
(59, 'login', '[]', 80, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-26 13:53:11', '2023-01-26 13:53:11'),
(60, 'logout', '[]', 80, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-26 14:11:37', '2023-01-26 14:11:37'),
(61, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-26 22:39:54', '2023-01-26 22:39:54'),
(62, 'mission', '{\"attributes\":{\"mission_name\":\"Join Xomerce Discussion Channel\",\"mission_id\":1}}', 46, 'App\\Models\\User', NULL, 'mission created', 'created', 1, 'App\\Models\\Mission', '2023-01-26 23:01:32', '2023-01-26 23:01:32'),
(63, 'mission', '{\"attributes\":{\"mission_name\":\"Join Xomerce Discussion Channel updated\"},\"old\":{\"mission_name\":\"Join Xomerce Discussion Channel\"}}', 46, 'App\\Models\\User', NULL, 'mission updated', 'updated', 1, 'App\\Models\\Mission', '2023-01-26 23:05:26', '2023-01-26 23:05:26'),
(64, 'mission', '{\"attributes\":{\"mission_name\":\"Join Xomerce Discussion Channel\"},\"old\":{\"mission_name\":\"Join Xomerce Discussion Channel updated\"}}', 46, 'App\\Models\\User', NULL, 'mission updated', 'updated', 1, 'App\\Models\\Mission', '2023-01-26 23:05:33', '2023-01-26 23:05:33'),
(65, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-28 10:33:21', '2023-01-28 10:33:21'),
(66, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-28 10:45:19', '2023-01-28 10:45:19'),
(67, 'login', '[]', 81, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-28 10:46:32', '2023-01-28 10:46:32'),
(68, 'logout', '[]', 81, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-28 10:50:29', '2023-01-28 10:50:29'),
(69, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-28 10:50:38', '2023-01-28 10:50:38'),
(70, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-28 10:56:30', '2023-01-28 10:56:30'),
(71, 'login', '[]', 81, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-28 10:56:38', '2023-01-28 10:56:38'),
(72, 'stores', '{\"attributes\":{\"store_name\":\"Pandawa Batik update\"},\"old\":{\"store_name\":\"Pandawa Batik\"}}', 81, 'App\\Models\\User', NULL, 'stores updated', 'updated', 4, 'App\\Models\\Stores', '2023-01-28 11:12:02', '2023-01-28 11:12:02'),
(73, 'stores', '{\"attributes\":{\"store_name\":\"Pandawa Batik\"},\"old\":{\"store_name\":\"Pandawa Batik update\"}}', 81, 'App\\Models\\User', NULL, 'stores updated', 'updated', 4, 'App\\Models\\Stores', '2023-01-28 11:12:09', '2023-01-28 11:12:09'),
(74, 'stores', '{\"attributes\":{\"store_name\":\"Prima Bike\",\"store_id\":6}}', 81, 'App\\Models\\User', NULL, 'stores created', 'created', 6, 'App\\Models\\Stores', '2023-01-28 11:23:52', '2023-01-28 11:23:52'),
(75, 'logout', '[]', 81, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-28 11:50:14', '2023-01-28 11:50:14'),
(76, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-28 11:50:21', '2023-01-28 11:50:21'),
(77, 'stores', '{\"attributes\":{\"store_name\":\"Prima Bike\",\"store_id\":7}}', 46, 'App\\Models\\User', NULL, 'stores created', 'created', 7, 'App\\Models\\Stores', '2023-01-28 12:04:25', '2023-01-28 12:04:25'),
(78, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-28 12:04:36', '2023-01-28 12:04:36'),
(79, 'login', '[]', 81, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-28 12:04:49', '2023-01-28 12:04:49'),
(80, 'stores', '{\"attributes\":{\"store_name\":\"Prima Bike\",\"store_id\":8}}', 81, 'App\\Models\\User', NULL, 'stores created', 'created', 8, 'App\\Models\\Stores', '2023-01-28 12:06:12', '2023-01-28 12:06:12'),
(81, 'logout', '[]', 81, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-28 12:06:28', '2023-01-28 12:06:28'),
(82, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-28 12:06:33', '2023-01-28 12:06:33'),
(83, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-28 12:08:16', '2023-01-28 12:08:16'),
(84, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-28 12:08:24', '2023-01-28 12:08:24'),
(85, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-28 12:08:32', '2023-01-28 12:08:32'),
(86, 'login', '[]', 81, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-28 12:08:39', '2023-01-28 12:08:39'),
(87, 'stores', '{\"attributes\":{\"product_name\":\"Sepeda Lipat\",\"product_id\":3}}', 81, 'App\\Models\\User', NULL, 'product created', 'created', 3, 'App\\Models\\Product', '2023-01-28 12:10:30', '2023-01-28 12:10:30'),
(88, 'logout', '[]', 81, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-28 12:11:43', '2023-01-28 12:11:43'),
(89, 'login', '[]', 82, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-28 12:12:40', '2023-01-28 12:12:40'),
(90, 'stores', '{\"attributes\":{\"store_name\":\"Girly Store\",\"store_id\":9}}', 82, 'App\\Models\\User', NULL, 'stores created', 'created', 9, 'App\\Models\\Stores', '2023-01-28 12:14:17', '2023-01-28 12:14:17'),
(91, 'stores', '{\"attributes\":{\"product_name\":\"Yukata Wanita\",\"product_id\":4}}', 82, 'App\\Models\\User', NULL, 'product created', 'created', 4, 'App\\Models\\Product', '2023-01-28 12:16:36', '2023-01-28 12:16:36'),
(92, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-28 12:53:48', '2023-01-28 12:53:48'),
(93, 'log_saldo_point', '{\"attributes\":{\"log_saldo_nominal\":1000000,\"log_saldo_status\":\"deposit\",\"log_saldo_description\":\"top up pertama\"}}', 46, 'App\\Models\\User', NULL, 'log saldo created', 'created', 1, 'App\\Models\\LogSaldoPoint', '2023-01-28 13:33:26', '2023-01-28 13:33:26'),
(94, 'log_saldo_point', '{\"attributes\":{\"log_saldo_nominal\":1000000,\"log_saldo_status\":\"deposit\",\"log_saldo_description\":\"top up saldo point pertama\"}}', 46, 'App\\Models\\User', NULL, 'log saldo created', 'created', 2, 'App\\Models\\LogSaldoPoint', '2023-01-28 13:44:39', '2023-01-28 13:44:39'),
(95, 'log_saldo_point', '{\"attributes\":{\"log_saldo_nominal\":1000000,\"log_saldo_status\":\"deposit\",\"log_saldo_description\":\"top up perttama via bni\"}}', 46, 'App\\Models\\User', NULL, 'log saldo created', 'created', 3, 'App\\Models\\LogSaldoPoint', '2023-01-28 13:53:36', '2023-01-28 13:53:36'),
(96, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-29 09:16:48', '2023-01-29 09:16:48'),
(97, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-29 09:17:18', '2023-01-29 09:17:18'),
(98, 'login', '[]', 82, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-29 09:17:25', '2023-01-29 09:17:25'),
(99, 'mission', '{\"attributes\":{\"mission_name\":\"Follow Instagram Santara\",\"mission_id\":2}}', 82, 'App\\Models\\User', NULL, 'mission created', 'created', 2, 'App\\Models\\Mission', '2023-01-29 09:52:03', '2023-01-29 09:52:03'),
(100, 'login', '[]', 80, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-29 10:42:07', '2023-01-29 10:42:07'),
(101, 'logout', '[]', 80, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-29 11:07:15', '2023-01-29 11:07:15'),
(102, 'login', '[]', 83, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-29 11:07:55', '2023-01-29 11:07:55'),
(103, 'logout', '[]', 83, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-29 11:08:16', '2023-01-29 11:08:16'),
(104, 'login', '[]', 80, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-29 11:08:35', '2023-01-29 11:08:35'),
(105, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-30 20:27:59', '2023-01-30 20:27:59'),
(106, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-30 20:28:41', '2023-01-30 20:28:41'),
(107, 'login', '[]', 83, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-30 20:28:59', '2023-01-30 20:28:59'),
(108, 'logout', '[]', 83, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-30 20:29:03', '2023-01-30 20:29:03'),
(109, 'login', '[]', 82, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-30 20:29:20', '2023-01-30 20:29:20'),
(110, 'logout', '[]', 82, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-30 20:35:52', '2023-01-30 20:35:52'),
(111, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-30 20:35:57', '2023-01-30 20:35:57'),
(112, 'login', '[]', 82, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-30 20:36:34', '2023-01-30 20:36:34'),
(113, 'log_saldo_point', '{\"attributes\":{\"log_saldo_nominal\":250000,\"log_saldo_status\":\"used\",\"log_saldo_description\":\"saldo point digunakan untuk pembuatan mission Follow Instagram ALIFE\"}}', 82, 'App\\Models\\User', NULL, 'log saldo created', 'created', 4, 'App\\Models\\LogSaldoPoint', '2023-01-30 20:54:35', '2023-01-30 20:54:35'),
(114, 'mission', '{\"attributes\":{\"mission_name\":\"Follow Instagram ALIFE\",\"mission_id\":3}}', 82, 'App\\Models\\User', NULL, 'mission created', 'created', 3, 'App\\Models\\Mission', '2023-01-30 20:54:36', '2023-01-30 20:54:36'),
(115, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-30 20:55:59', '2023-01-30 20:55:59'),
(116, 'login', '[]', 83, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-30 20:56:12', '2023-01-30 20:56:12'),
(117, 'logout', '[]', 83, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-30 21:04:39', '2023-01-30 21:04:39'),
(118, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-30 21:04:45', '2023-01-30 21:04:45'),
(119, 'log_saldo_point', '{\"attributes\":{\"log_saldo_nominal\":5000,\"log_saldo_status\":\"reward\",\"log_saldo_description\":\"mendapatkan reward dari mission Follow Instagram ALIFE\"}}', 46, 'App\\Models\\User', NULL, 'log saldo created', 'created', 5, 'App\\Models\\LogSaldoPoint', '2023-01-30 21:30:18', '2023-01-30 21:30:18'),
(120, 'log_saldo_point', '{\"attributes\":{\"log_saldo_nominal\":5000,\"log_saldo_status\":\"reward\",\"log_saldo_description\":\"mendapatkan reward dari mission Follow Instagram ALIFE\"}}', 46, 'App\\Models\\User', NULL, 'log saldo created', 'created', 6, 'App\\Models\\LogSaldoPoint', '2023-01-30 21:33:10', '2023-01-30 21:33:10'),
(121, 'log_saldo_point', '{\"attributes\":{\"log_saldo_nominal\":5000,\"log_saldo_status\":\"reward\",\"log_saldo_description\":\"mendapatkan reward dari mission Follow Instagram ALIFE\"}}', 46, 'App\\Models\\User', NULL, 'log saldo created', 'created', 7, 'App\\Models\\LogSaldoPoint', '2023-01-30 21:34:02', '2023-01-30 21:34:02'),
(122, 'log_saldo_point', '{\"attributes\":{\"log_saldo_nominal\":5000,\"log_saldo_status\":\"reward\",\"log_saldo_description\":\"mendapatkan reward dari mission Follow Instagram ALIFE\"}}', 46, 'App\\Models\\User', NULL, 'log saldo created', 'created', 8, 'App\\Models\\LogSaldoPoint', '2023-01-30 21:34:08', '2023-01-30 21:34:08'),
(123, 'logout', '[]', 82, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-30 21:34:22', '2023-01-30 21:34:22'),
(124, 'login', '[]', 83, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-30 21:34:43', '2023-01-30 21:34:43'),
(125, 'logout', '[]', 83, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-30 21:44:12', '2023-01-30 21:44:12'),
(126, 'login', '[]', 82, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-31 20:46:30', '2023-01-31 20:46:30'),
(127, 'login', '[]', 83, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-31 20:58:25', '2023-01-31 20:58:25'),
(128, 'logout', '[]', 83, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-31 21:00:33', '2023-01-31 21:00:33'),
(129, 'login', '[]', 80, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-31 21:00:44', '2023-01-31 21:00:44'),
(130, 'logout', '[]', 82, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-31 21:02:29', '2023-01-31 21:02:29'),
(131, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-31 21:02:34', '2023-01-31 21:02:34'),
(132, 'logout', '[]', 80, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-31 21:29:49', '2023-01-31 21:29:49'),
(133, 'login', '[]', 82, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-01-31 21:29:59', '2023-01-31 21:29:59'),
(134, 'logout', '[]', 82, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-01-31 22:06:39', '2023-01-31 22:06:39'),
(135, 'reward', '{\"attributes\":{\"reward_name\":\"T-Shirt Xomerce\",\"reward_id\":1}}', 46, 'App\\Models\\User', NULL, 'reward created', 'created', 1, 'App\\Models\\Reward', '2023-01-31 22:30:29', '2023-01-31 22:30:29'),
(136, 'reward', '{\"attributes\":{\"reward_name\":\"tes apus\",\"reward_id\":2}}', 46, 'App\\Models\\User', NULL, 'reward created', 'created', 2, 'App\\Models\\Reward', '2023-01-31 22:36:30', '2023-01-31 22:36:30'),
(137, 'reward', '{\"old\":{\"reward_name\":\"tes apus\",\"reward_id\":2}}', 46, 'App\\Models\\User', NULL, 'reward deleted', 'deleted', 2, 'App\\Models\\Reward', '2023-01-31 22:36:55', '2023-01-31 22:36:55'),
(138, 'reward', '{\"old\":{\"reward_name\":\"tes apus\",\"reward_id\":2}}', 46, 'App\\Models\\User', NULL, 'reward deleted', 'deleted', 2, 'App\\Models\\Reward', '2023-01-31 22:37:38', '2023-01-31 22:37:38'),
(139, 'reward', '{\"old\":{\"reward_name\":\"tes apus\",\"reward_id\":2}}', 46, 'App\\Models\\User', NULL, 'reward deleted', 'deleted', 2, 'App\\Models\\Reward', '2023-01-31 22:39:49', '2023-01-31 22:39:49'),
(140, 'reward', '{\"attributes\":{\"reward_name\":\"T-Shirt Xomerce a\"},\"old\":{\"reward_name\":\"T-Shirt Xomerce\"}}', 46, 'App\\Models\\User', NULL, 'reward updated', 'updated', 1, 'App\\Models\\Reward', '2023-01-31 22:41:02', '2023-01-31 22:41:02'),
(141, 'reward', '{\"attributes\":{\"reward_name\":\"T-Shirt Xomerce\"},\"old\":{\"reward_name\":\"T-Shirt Xomerce a\"}}', 46, 'App\\Models\\User', NULL, 'reward updated', 'updated', 1, 'App\\Models\\Reward', '2023-01-31 22:41:07', '2023-01-31 22:41:07'),
(142, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-02-02 17:53:12', '2023-02-02 17:53:12'),
(143, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-02-02 17:53:44', '2023-02-02 17:53:44'),
(144, 'login', '[]', 81, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-02-02 17:53:53', '2023-02-02 17:53:53'),
(145, 'logout', '[]', 81, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-02-02 17:54:41', '2023-02-02 17:54:41'),
(146, 'login', '[]', 82, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-02-02 17:55:02', '2023-02-02 17:55:02'),
(147, 'log_saldo_point', '{\"attributes\":{\"log_saldo_nominal\":350000,\"log_saldo_status\":\"used\",\"log_saldo_description\":\"saldo point digunakan untuk pembuatan mission Follow akun IG\"}}', 82, 'App\\Models\\User', NULL, 'log saldo created', 'created', 9, 'App\\Models\\LogSaldoPoint', '2023-02-02 17:57:44', '2023-02-02 17:57:44'),
(148, 'mission', '{\"attributes\":{\"mission_name\":\"Follow akun IG\",\"mission_id\":4}}', 82, 'App\\Models\\User', NULL, 'mission created', 'created', 4, 'App\\Models\\Mission', '2023-02-02 17:57:45', '2023-02-02 17:57:45'),
(149, 'login', '[]', 80, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-02-02 17:58:49', '2023-02-02 17:58:49'),
(150, 'user', '{\"attributes\":{\"name\":\"Dana Arif Kurniawan\",\"email\":\"dana.arif92@gmail.com\",\"avatar\":null}}', NULL, NULL, NULL, 'pengguna Dana Arif Kurniawan created', 'created', 84, 'App\\Models\\User', '2023-02-15 23:02:11', '2023-02-15 23:02:11'),
(151, 'login', '[]', 84, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-02-15 23:02:11', '2023-02-15 23:02:11'),
(152, 'user', '{\"attributes\":{\"name\":\"Dana Arif Kurniawan\",\"email\":\"dana.arif92@gmail.com\",\"avatar\":null}}', NULL, NULL, NULL, 'pengguna Dana Arif Kurniawan created', 'created', 85, 'App\\Models\\User', '2023-02-15 23:05:55', '2023-02-15 23:05:55'),
(153, 'login', '[]', 85, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-02-15 23:05:55', '2023-02-15 23:05:55'),
(154, 'logout', '[]', 85, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-02-15 23:06:11', '2023-02-15 23:06:11'),
(155, 'login', '[]', 82, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-03-02 21:33:31', '2023-03-02 21:33:31'),
(156, 'logout', '[]', 82, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-03-02 22:22:04', '2023-03-02 22:22:04'),
(157, 'login', '[]', 46, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-03-02 22:22:09', '2023-03-02 22:22:09'),
(158, 'logout', '[]', 46, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-03-02 22:24:22', '2023-03-02 22:24:22'),
(159, 'login', '[]', 82, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-03-02 22:24:28', '2023-03-02 22:24:28'),
(160, 'log_saldo_point', '{\"attributes\":{\"log_saldo_nominal\":200000,\"log_saldo_status\":\"used\",\"log_saldo_description\":\"saldo point digunakan untuk pembuatan mission Follow IG toko\"}}', 82, 'App\\Models\\User', NULL, 'log saldo created', 'created', 10, 'App\\Models\\LogSaldoPoint', '2023-03-02 22:43:41', '2023-03-02 22:43:41'),
(161, 'mission', '{\"attributes\":{\"mission_name\":\"Follow IG toko\",\"mission_id\":5}}', 82, 'App\\Models\\User', NULL, 'mission created', 'created', 5, 'App\\Models\\Mission', '2023-03-02 22:43:41', '2023-03-02 22:43:41'),
(162, 'user', '{\"attributes\":{\"name\":\"Rajabasa EO\",\"email\":\"planner1@gmail.com\",\"avatar\":null}}', NULL, NULL, NULL, 'pengguna Rajabasa EO created', 'created', 86, 'App\\Models\\User', '2023-05-09 10:40:27', '2023-05-09 10:40:27'),
(163, 'login', '[]', 86, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-05-09 10:40:27', '2023-05-09 10:40:27'),
(164, 'logout', '[]', 86, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-05-09 10:46:41', '2023-05-09 10:46:41'),
(165, 'login', '[]', 86, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-05-09 11:03:58', '2023-05-09 11:03:58'),
(166, 'logout', '[]', 86, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-05-09 11:04:34', '2023-05-09 11:04:34'),
(167, 'login', '[]', 86, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-05-09 11:04:43', '2023-05-09 11:04:43'),
(168, 'logout', '[]', 86, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-05-09 11:04:45', '2023-05-09 11:04:45'),
(169, 'login', '[]', 86, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-05-09 11:14:37', '2023-05-09 11:14:37'),
(170, 'logout', '[]', NULL, NULL, NULL, 'logout berhasil', NULL, NULL, NULL, '2023-05-09 14:40:42', '2023-05-09 14:40:42'),
(171, 'login', '[]', 86, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-05-09 14:41:15', '2023-05-09 14:41:15'),
(172, 'user', '{\"attributes\":{\"foto\":\"user\\/1683619463.png\"},\"old\":{\"foto\":null}}', 86, 'App\\Models\\User', NULL, 'pengguna Rajabasa EO updated', 'updated', 86, 'App\\Models\\User', '2023-05-09 15:04:24', '2023-05-09 15:04:24'),
(173, 'user', '{\"attributes\":{\"foto\":\"\\/private\\/var\\/tmp\\/phpLyr9rK\"},\"old\":{\"foto\":\"user\\/1683619463.png\"}}', 86, 'App\\Models\\User', NULL, 'pengguna Rajabasa EO updated', 'updated', 86, 'App\\Models\\User', '2023-05-09 15:04:24', '2023-05-09 15:04:24'),
(174, 'login', '[]', 86, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-05-10 09:50:53', '2023-05-10 09:50:53'),
(175, 'user', '{\"attributes\":{\"foto\":\"user\\/1683688134.png\"},\"old\":{\"foto\":\"\"}}', 86, 'App\\Models\\User', NULL, 'pengguna Rajabasa EO updated', 'updated', 86, 'App\\Models\\User', '2023-05-10 10:08:54', '2023-05-10 10:08:54'),
(176, 'user', '{\"attributes\":{\"foto\":\"\\/private\\/var\\/tmp\\/phpQl0Ok3\"},\"old\":{\"foto\":\"user\\/1683688134.png\"}}', 86, 'App\\Models\\User', NULL, 'pengguna Rajabasa EO updated', 'updated', 86, 'App\\Models\\User', '2023-05-10 10:08:54', '2023-05-10 10:08:54'),
(177, 'user', '{\"attributes\":{\"foto\":\"user\\/1683688305.png\"},\"old\":{\"foto\":\"\\/private\\/var\\/tmp\\/phpQl0Ok3\"}}', 86, 'App\\Models\\User', NULL, 'pengguna Rajabasa EO updated', 'updated', 86, 'App\\Models\\User', '2023-05-10 10:11:45', '2023-05-10 10:11:45'),
(178, 'logout', '[]', 86, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-05-10 10:13:15', '2023-05-10 10:13:15'),
(179, 'login', '[]', 86, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-05-10 10:20:14', '2023-05-10 10:20:14'),
(180, 'login', '[]', 86, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-05-12 10:19:39', '2023-05-12 10:19:39'),
(181, 'event', '{\"attributes\":{\"event_name\":\"Konser Tipe-X di PKOR\",\"event_id\":1}}', 86, 'App\\Models\\User', NULL, 'product created', 'created', 1, 'App\\Models\\Event', '2023-05-12 10:43:54', '2023-05-12 10:43:54'),
(182, 'login', '[]', 86, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-05-12 13:52:52', '2023-05-12 13:52:52'),
(183, 'event', '{\"attributes\":{\"event_name\":\"Konser Sheila on 7\",\"event_id\":2}}', 86, 'App\\Models\\User', NULL, 'product created', 'created', 2, 'App\\Models\\Event', '2023-05-12 14:10:27', '2023-05-12 14:10:27'),
(184, 'logout', '[]', 86, 'App\\Models\\User', NULL, 'logout berhasil', NULL, NULL, NULL, '2023-05-12 14:10:34', '2023-05-12 14:10:34'),
(185, 'login', '[]', 86, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-05-13 13:29:10', '2023-05-13 13:29:10'),
(186, 'login', '[]', 86, 'App\\Models\\User', NULL, 'login berhasil', NULL, NULL, NULL, '2023-05-15 09:57:31', '2023-05-15 09:57:31'),
(187, 'berita', '{\"attributes\":{\"berita_title\":\"Seluruh Peserta event Wajib pakai masker\",\"berita_id\":1}}', 86, 'App\\Models\\User', NULL, 'berita created', 'created', 1, 'App\\Models\\Berita', '2023-05-15 10:57:51', '2023-05-15 10:57:51'),
(188, 'berita', '{\"attributes\":{\"berita_title\":\"Seminar coba\",\"berita_id\":2}}', 86, 'App\\Models\\User', NULL, 'berita created', 'created', 2, 'App\\Models\\Berita', '2023-05-15 11:02:59', '2023-05-15 11:02:59'),
(189, 'berita', '{\"old\":{\"berita_title\":\"Seminar coba\",\"berita_id\":2}}', 86, 'App\\Models\\User', NULL, 'berita deleted', 'deleted', 2, 'App\\Models\\Berita', '2023-05-15 11:03:52', '2023-05-15 11:03:52'),
(190, 'logout', '[]', NULL, NULL, NULL, 'logout berhasil', NULL, NULL, NULL, '2023-05-15 13:54:08', '2023-05-15 13:54:08');

INSERT INTO `berita` (`berita_id`, `berita_title`, `berita_category_id`, `berita_content`, `berita_tag`, `berita_image`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `berita_hit`) VALUES
(1, 'Seluruh Peserta event Wajib pakai masker', 5, '<p>halo semuanya,</p><p>menurut peraturan <b>KEMENKES nomor 1 , kita semua </b>wajib pakai masker saat di event yaa</p>', NULL, 'berita/1684123071.png', '2023-05-15 10:57:51', '2023-05-15 11:02:34', NULL, 86, 0),
(2, 'Seminar coba', 2, '<ol><li>awdawdawda</li><li>dd</li><li>e</li></ol>', NULL, 'berita/1684123379.jpg', '2023-05-15 11:02:59', '2023-05-15 11:03:52', '2023-05-15 11:03:52', 86, 0);

INSERT INTO `category` (`category_id`, `category_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Musik', '2023-05-10 10:30:43', NULL, NULL),
(2, 'Seminar', '2023-05-10 10:30:43', NULL, NULL),
(3, 'Pameran', '2023-05-10 10:30:43', NULL, NULL),
(4, 'Lomba', '2023-05-10 10:30:43', NULL, NULL),
(5, 'Pengumuman', '2023-05-15 10:48:53', NULL, NULL);

INSERT INTO `event` (`event_id`, `event_name`, `event_category_id`, `event_waktu`, `event_talent`, `event_lokasi`, `event_harga_tiket`, `event_stok_tiket`, `event_poster`, `created_at`, `updated_at`, `deleted_at`, `event_latitude`, `event_longitude`, `event_has_discount`, `event_discount`, `event_description`, `created_by`) VALUES
(1, 'Konser Tipe-X di PKOR', 1, '2023-05-30 19:00:00', 'Tipe-X', 'PKOR Way Halim', 200000, 200, 'event/1683863034.jpg', '2023-05-12 10:43:54', '2023-05-12 10:43:54', NULL, NULL, NULL, 0, NULL, 'Ayo datang dan meriahkan konser tipe-x di pkor', 86),
(2, 'Konser Sheila on 7', 1, '2023-06-10 15:00:00', 'Sheila on 7', 'Lapangan Saburai', 150000, 100, 'event/1683875427.jpg', '2023-05-12 14:10:27', '2023-05-12 14:10:27', NULL, NULL, NULL, 0, NULL, 'konser sheila on 7 full album', 86);

INSERT INTO `role` (`id_role`, `role_name`, `role_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'superadmin', 'Super admin dari sistem xpoint', '2023-01-04 21:08:56', NULL, NULL),
(2, 'admin', 'Admin yang mengatur data selain pengguna', '2023-01-04 21:08:56', NULL, NULL),
(3, 'store', 'Role untuk event planner', '2023-01-04 21:09:46', NULL, NULL),
(4, 'user', 'role untuk pengguna biasa', '2023-01-04 21:09:46', NULL, NULL);

INSERT INTO `settings` (`id`, `setting_var`, `setting_val`, `created_at`, `updated_at`) VALUES
(1, 'app_name', 'SIVP', '2022-07-20 13:37:13', '2022-07-20 13:37:13'),
(2, 'app_description', 'Sistem Informasi Event Planner', '2022-12-29 22:14:15', '2022-12-29 22:14:15'),
(3, 'app_keyword', 'event-planner,event planner balam,bandar lampung', '2022-12-29 22:14:15', '2022-12-29 22:14:15'),
(4, 'app_author', 'sivp', '2022-12-29 22:14:31', '2022-12-29 22:14:31'),
(5, 'app_twitter', 'https://twitter.com', '2022-12-29 22:15:11', '2022-12-29 22:15:11'),
(6, 'app_facebook', 'https://facebook.com', '2022-12-29 22:15:11', '2022-12-29 22:15:11'),
(7, 'app_instagram', 'https://instagram.com', '2022-12-29 22:15:37', '2022-12-29 22:15:37'),
(8, 'app_youtube', 'https://youtube.com', '2022-12-29 22:15:37', '2022-12-29 22:15:37'),
(9, 'app_email', 'marketing@event-planner.com', '2022-12-29 22:16:08', '2022-12-29 22:16:08');

INSERT INTO `user_has_role` (`id_has_role`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 46, 1, '2023-01-04 21:13:32', '2023-01-04 21:13:32'),
(2, 27, 2, '2023-01-04 21:13:32', '2023-01-04 21:13:32'),
(3, 80, 4, '2023-01-09 14:00:53', '2023-01-09 14:00:53'),
(6, 83, 4, '2023-01-09 14:00:53', '2023-01-09 14:00:53'),
(7, 85, 4, '2023-02-15 23:05:55', '2023-02-15 23:05:55'),
(8, 86, 3, '2023-05-09 10:40:27', '2023-05-09 10:40:27');

INSERT INTO `users` (`id`, `email`, `password`, `name`, `alamat`, `foto`, `active`, `phone`, `token`, `remember_token`, `level`, `created_at`, `updated_at`, `deleted_at`, `store_description`) VALUES
(27, 'admin@gmail.com', '$2y$10$1qZzCfm0vYLAivPeJdDZ0.oAeCROXA5YMMtTCgtb2aQn6oMV7461m', 'Admin Sistem', 'Teluk betung', NULL, '1', '+6281392339773', '5RBVUp6MRdN7Pkz8HFdI2g3dJrhVdw1K5VTUF5x4EeucUAAsgqLFysdoROHimlrvN19cM0tcHIXdpB48', '', 'admin', '2021-03-17 18:16:58', '2021-04-13 13:36:33', NULL, NULL),
(46, 'super@gmail.com', '$2y$10$1qZzCfm0vYLAivPeJdDZ0.oAeCROXA5YMMtTCgtb2aQn6oMV7461m', 'Superadmin', '-', NULL, '1', '089662240052', 'PfKg6c47dQCPEj8xYSKsHudLdDdVB0qsoRY1MdPnz3MllESu3AIQny84duXinFf0St18O3u9HNS4jhPV', '', 'superadmin', '2021-03-27 22:24:30', '2021-04-05 10:30:13', NULL, NULL),
(80, 'user1@gmail.com', '$2y$10$1qZzCfm0vYLAivPeJdDZ0.oAeCROXA5YMMtTCgtb2aQn6oMV7461m', 'Mahasiwa 1', 'Teluk betung', NULL, '1', '+6281392339773', '5RBVUp6MRdN7Pkz8HFdI2g3dJrhVdw1K5VTUF5x4EeucUAAsgqLFysdoROHimlrvN19cM0tcHIXdpB48', '', 'user', '2021-03-17 18:16:58', '2021-04-13 13:36:33', NULL, NULL),
(81, 'adinata@gmail.com', '$2y$10$1qZzCfm0vYLAivPeJdDZ0.oAeCROXA5YMMtTCgtb2aQn6oMV7461m', 'Adinata Toko', 'Kedaton', NULL, '1', '089211111', NULL, NULL, 'user', '2022-10-12 20:35:57', '2023-01-09 14:20:29', NULL, NULL),
(82, 'azalea@gmail.com', '$2y$10$1qZzCfm0vYLAivPeJdDZ0.oAeCROXA5YMMtTCgtb2aQn6oMV7461m', 'Azalea Toko', 'Rajabasa', '', '1', '08912345678', NULL, NULL, 'user', '2022-10-12 20:35:57', '2023-03-02 22:43:41', NULL, NULL),
(83, 'user2@gmail.com', '$2y$10$1qZzCfm0vYLAivPeJdDZ0.oAeCROXA5YMMtTCgtb2aQn6oMV7461m', 'Mahasiwa Dua', 'Tanjung Karang', NULL, '1', '+6281392339773', '5RBVUp6MRdN7Pkz8HFdI2g3dJrhVdw1K5VTUF5x4EeucUAAsgqLFysdoROHimlrvN19cM0tcHIXdpB48', '', 'user', '2021-03-17 18:16:58', '2023-01-30 21:34:08', NULL, NULL),
(86, 'planner1@gmail.com', '$2y$10$c0zKtegOV49gwP/uQjszv.OLcOR.w3RC6XD2yYPLDDBs.Z7Z9k.VC', 'Rajabasa EO', 'Rajabasa , Bandar Lampung', 'user/1683688305.png', '1', '0812345678', NULL, NULL, 'user', '2023-05-09 10:40:27', '2023-05-10 10:11:45', NULL, NULL);



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;