-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1:3306
-- Χρόνος δημιουργίας: 17 Οκτ 2025 στις 09:59:17
-- Έκδοση διακομιστή: 8.0.31
-- Έκδοση PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `pro_v`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `courses`
--

INSERT INTO `courses` (`id`, `title`, `image`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'bvbv', 'courses/cgRf7jS54ZSV5kAWjHykWI9EBADI59TwED32ZiUP.jpg', 'rr', '2025-09-26 09:53:30', '2025-10-08 06:08:45', NULL),
(4, 'Μαθηματικά I', '', 'dfgdfgf', '2025-09-26 09:53:32', '2025-10-10 04:54:01', NULL),
(5, 'Χημεία', NULL, 'dfgdfgdf', '2025-09-26 10:16:06', '2025-10-08 05:54:15', NULL),
(6, 'Φυσική', '', 'δφσδφσ', '2025-09-26 10:35:39', '2025-10-08 05:58:56', NULL),
(7, 'Ιστορία', NULL, 'vbnvbnvb', '2025-09-26 10:45:20', '2025-09-26 10:45:20', NULL),
(8, 'Θρησκευτικά', NULL, 'fbvbvbv', '2025-09-29 05:11:47', '2025-09-29 05:11:47', NULL),
(15, 'Ηλεκτρονικά', NULL, 'vxcvxc', '2025-10-08 09:43:30', '2025-10-08 09:43:30', NULL),
(16, 'Μαθηματικά II', NULL, 'cxxcxc', '2025-10-08 09:43:33', '2025-10-08 09:43:33', NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `course_user`
--

DROP TABLE IF EXISTS `course_user`;
CREATE TABLE IF NOT EXISTS `course_user` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_user_user_id_foreign` (`user_id`),
  KEY `course_user_course_id_foreign` (`course_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `course_user`
--

INSERT INTO `course_user` (`id`, `user_id`, `course_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, NULL, NULL),
(2, 4, 4, NULL, NULL),
(3, 2, 8, NULL, NULL),
(4, 2, 5, NULL, NULL),
(5, 4, 5, NULL, NULL),
(6, 4, 6, NULL, NULL),
(7, 1, 4, NULL, NULL),
(8, 1, 5, NULL, NULL),
(18, 24, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '0001_01_01_000000_create_users_table', 1),
(4, '2025_09_26_101711_create_courses_table', 2),
(5, '2025_10_08_130749_create_course_user', 3),
(6, '2025_10_13_132604_create_permission_tables', 4),
(7, '2025_10_15_124859_add_column_deleted_at_to_users', 5),
(8, '2025_10_15_124908_add_column_deleted_at_to_courses', 5);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 3),
(1, 'App\\Models\\User', 4),
(1, 'App\\Models\\User', 7),
(1, 'App\\Models\\User', 24),
(3, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 21);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Διαχειριστής', 'web', '2025-10-13 10:31:37', '2025-10-13 10:31:37'),
(2, 'Φοιτητής', 'web', '2025-10-13 10:31:37', '2025-10-13 10:31:37'),
(3, 'Καθηγητής', 'web', '2025-10-13 10:31:37', '2025-10-13 10:31:37');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(24, 'Super Admin', 'admin@admin.com', NULL, '$2y$12$sjwYzXKPZzdGJtxwIOdRMuimUfjX5eIPwHqxFaUpKMIw.AAV9yLwi', NULL, '2025-10-15 10:44:42', '2025-10-15 10:44:42', NULL),
(2, 'wwccc', 'fds@asd.com', NULL, '$2y$12$1clB1IJdvcIzFtwpefUtNeLlzCIJGO215.x0I9R0ifytCLCN1hoBO', NULL, '2025-09-08 05:10:47', '2025-10-14 10:31:45', NULL),
(3, 'qqq', 'tretr@sdfds.com', NULL, '$2y$12$i9vL.ZVw0TKSSqXFM9teoe2U6i9Nu7i2BAH1QA7Yyjc5b6maRKN5S', NULL, '2025-09-08 05:11:24', '2025-10-14 10:31:49', NULL),
(4, 'saas', 'sas@asdas.com', NULL, '$2y$12$Z54fvsJ38MyVNENUdW3bjushkg25Yo.D7nndHh6i/llDgx.KLSHs.', NULL, '2025-09-08 05:11:54', '2025-10-14 10:31:42', NULL),
(7, 'vcvc', 'xcx@xx.gr', NULL, '$2y$12$sjwYzXKPZzdGJtxwIOdRMuimUfjX5eIPwHqxFaUpKMIw.AAV9yLwi', NULL, '2025-09-08 10:21:21', '2025-10-17 04:28:35', NULL),
(21, 'test professor', 'sdsvcvc@sadfs.com', NULL, '$2y$12$luq7UyfApfRsA0QMjs.OqexpE8n4LvVW0Bde9nr8ms6Cn9JXcrNwC', NULL, '2025-10-14 09:56:30', '2025-10-14 10:29:31', NULL),
(22, 'wq', 'wqdsfds@das.com', NULL, '$2y$12$IZfGKMlNynszl8w38zBaCusPsS8ryuBykpxo6lTmFsCCNWY1KbI2C', NULL, '2025-10-14 10:11:56', '2025-10-14 10:11:56', NULL),
(15, 'Group 1', 'cv@admin.com', NULL, '$2y$12$CplCWKQGYxgh6vM2OmIXcu0kqAj6LmRMHTPh/1057LxVK8U6vydQi', NULL, '2025-09-09 04:24:44', '2025-10-16 10:59:31', '2025-10-16 10:59:31'),
(19, 'xcvxcv', 'vxcvxc@xcv.com', NULL, '$2y$12$WMAo9sRPfsRR.IWN9HBaNOS.Q.C1A1JcS.PzNfykDcPQixEvpxZXq', NULL, '2025-10-14 09:37:41', '2025-10-17 04:25:54', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
