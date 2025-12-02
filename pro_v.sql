

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


SET FOREIGN_KEY_CHECKS = 0;


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



INSERT INTO `courses` (`id`, `title`, `image`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'bvbv', 'courses/cgRf7jS54ZSV5kAWjHykWI9EBADI59TwED32ZiUP.jpg', 'rr', '2025-09-26 09:53:30', '2025-10-08 06:08:45', NULL),
(4, 'Μαθηματικά I', '', 'dfgdfgf', '2025-09-26 09:53:32', '2025-10-10 04:54:01', NULL),
(5, 'Χημεία', NULL, 'dfgdfgdf', '2025-09-26 10:16:06', '2025-10-08 05:54:15', NULL),
(6, 'Φυσική', '', 'δφσδφσ', '2025-09-26 10:35:39', '2025-10-08 05:58:56', NULL),
(7, 'Ιστορία', NULL, 'vbnvbnvb', '2025-09-26 10:45:20', '2025-09-26 10:45:20', NULL),
(8, 'Θρησκευτικά', NULL, 'fbvbvbv', '2025-09-29 05:11:47', '2025-09-29 05:11:47', NULL),
(15, 'Ηλεκτρονικά', NULL, 'vxcvxc', '2025-10-08 09:43:30', '2025-10-08 09:43:30', NULL),
(16, 'Μαθηματικά II', NULL, 'cxxcxc', '2025-10-08 09:43:33', '2025-10-08 09:43:33', NULL);



INSERT INTO `course_user` (`id`, `user_id`, `course_id`, `created_at`, `updated_at`) VALUES
(2, 4, 4, NULL, NULL),
(3, 2, 8, NULL, NULL),
(4, 2, 5, NULL, NULL),
(5, 4, 5, NULL, NULL),
(6, 4, 6, NULL, NULL),
(18, 24, 4, NULL, NULL);


INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Διαχειριστής', 'web', '2025-10-13 10:31:37', '2025-10-13 10:31:37'),
(2, 'Φοιτητής', 'web', '2025-10-13 10:31:37', '2025-10-13 10:31:37'),
(3, 'Καθηγητής', 'web', '2025-10-13 10:31:37', '2025-10-13 10:31:37');


INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 3),
(1, 'App\\Models\\User', 4),
(1, 'App\\Models\\User', 7),
(1, 'App\\Models\\User', 24),
(3, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 21);


SET FOREIGN_KEY_CHECKS = 1;
