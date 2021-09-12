-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.25 - MySQL Community Server (GPL)
-- Операционная система:         Win32
-- HeidiSQL Версия:              10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных laravel_todo
CREATE DATABASE IF NOT EXISTS `laravel_todo` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `laravel_todo`;

-- Дамп структуры для таблица laravel_todo.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы laravel_todo.failed_jobs: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Дамп структуры для таблица laravel_todo.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы laravel_todo.migrations: ~9 rows (приблизительно)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
	(4, '2019_08_19_000000_create_failed_jobs_table', 1),
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2021_09_10_201601_create_task_lists_table', 1),
	(7, '2021_09_11_115233_create_tasks_table', 1),
	(8, '2021_09_12_081327_create_tags_table', 2),
	(9, '2021_09_12_081620_create_task_tags_table', 2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Дамп структуры для таблица laravel_todo.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы laravel_todo.password_resets: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Дамп структуры для таблица laravel_todo.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы laravel_todo.personal_access_tokens: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Дамп структуры для таблица laravel_todo.tags
CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы laravel_todo.tags: ~16 rows (приблизительно)
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` (`id`, `title`, `created_at`, `updated_at`) VALUES
	(1, 'Тег 1', '2021-09-11 19:41:15', '2021-09-11 19:41:15'),
	(2, 'Тег 2', '2021-09-12 10:01:50', '2021-09-12 10:01:50'),
	(3, 'Тег 3', '2021-09-12 10:01:50', '2021-09-12 10:01:50'),
	(4, 'Тег 4', '2021-09-12 10:03:40', '2021-09-12 10:03:40'),
	(5, 'Тег 5', '2021-09-12 10:44:14', '2021-09-12 10:44:14'),
	(6, 'Тег 6', '2021-09-12 10:45:06', '2021-09-12 10:45:06'),
	(7, 'Тег 7', '2021-09-12 11:22:54', '2021-09-12 11:22:54'),
	(8, 'Тег 8', '2021-09-12 14:19:08', '2021-09-12 14:19:08'),
	(9, 'Тег 9', '2021-09-12 14:21:45', '2021-09-12 14:21:45'),
	(10, 'Музыка', '2021-09-12 15:24:22', '2021-09-12 15:24:22'),
	(11, 'Задание', '2021-09-12 15:25:00', '2021-09-12 15:25:00'),
	(12, 'docker', '2021-09-12 15:25:46', '2021-09-12 15:25:46'),
	(13, 'docker-container', '2021-09-12 15:25:46', '2021-09-12 15:25:46'),
	(14, 'Уборка в доме', '2021-09-12 15:27:43', '2021-09-12 15:27:43'),
	(15, 'Посуда', '2021-09-12 15:27:56', '2021-09-12 15:27:56'),
	(16, 'Важно', '2021-09-12 15:29:43', '2021-09-12 15:29:43');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;

-- Дамп структуры для таблица laravel_todo.tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_list_id` bigint(20) unsigned NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_task_list_id_foreign` (`task_list_id`),
  CONSTRAINT `tasks_task_list_id_foreign` FOREIGN KEY (`task_list_id`) REFERENCES `task_lists` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы laravel_todo.tasks: ~9 rows (приблизительно)
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` (`id`, `title`, `task_list_id`, `image`, `state`, `created_at`, `updated_at`) VALUES
	(1, 'Сходить в магазин', 1, '1631378520-photo1.png', 0, '2021-09-11 13:10:52', '2021-09-12 15:22:05'),
	(12, 'Купить стол и стулья на кухню', 1, '1631460182-photo2.png', 0, '2021-09-11 16:10:10', '2021-09-12 15:23:02'),
	(13, 'Выполнить тестовое задание', 2, '1631460300-avatar5.png', 0, '2021-09-11 16:31:07', '2021-09-12 15:25:00'),
	(15, 'Послушать музыку', 1, '', 0, '2021-09-11 16:43:23', '2021-09-12 15:24:22'),
	(17, 'Собеседование', 10, '1631460595-AdminLTELogo.png', 0, '2021-09-11 19:22:19', '2021-09-12 15:29:55'),
	(18, 'Прогулка', 10, '1631460535-photo4.jpg', 0, '2021-09-11 19:41:15', '2021-09-12 15:28:55'),
	(21, 'Разобраться с докером', 4, '', 0, '2021-09-12 15:25:46', '2021-09-12 15:25:46'),
	(22, 'Пропылесосить', 5, '', 0, '2021-09-12 15:27:43', '2021-09-12 15:27:43'),
	(23, 'Помыть посуду', 5, '', 0, '2021-09-12 15:27:56', '2021-09-12 15:27:56');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;

-- Дамп структуры для таблица laravel_todo.task_lists
CREATE TABLE IF NOT EXISTS `task_lists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_lists_uid_foreign` (`uid`),
  CONSTRAINT `task_lists_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы laravel_todo.task_lists: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `task_lists` DISABLE KEYS */;
INSERT INTO `task_lists` (`id`, `title`, `uid`, `created_at`, `updated_at`) VALUES
	(1, 'Мой день', 1, '2021-09-11 12:10:17', '2021-09-11 12:10:17'),
	(2, 'Важно', 1, '2021-09-11 12:10:21', '2021-09-11 12:10:21'),
	(3, 'Запланировано', 1, '2021-09-11 12:10:23', '2021-09-11 12:10:23'),
	(4, 'Работа', 1, '2021-09-11 12:10:28', '2021-09-11 12:10:28'),
	(5, 'Домашние дела', 1, '2021-09-11 12:10:30', '2021-09-11 12:10:30'),
	(10, 'Мой день', 2, '2021-09-11 19:21:34', '2021-09-11 19:21:34');
/*!40000 ALTER TABLE `task_lists` ENABLE KEYS */;

-- Дамп структуры для таблица laravel_todo.task_tags
CREATE TABLE IF NOT EXISTS `task_tags` (
  `task_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  KEY `task_tags_task_id_foreign` (`task_id`),
  KEY `task_tags_tag_id_foreign` (`tag_id`),
  CONSTRAINT `task_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`),
  CONSTRAINT `task_tags_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы laravel_todo.task_tags: ~9 rows (приблизительно)
/*!40000 ALTER TABLE `task_tags` DISABLE KEYS */;
INSERT INTO `task_tags` (`task_id`, `tag_id`) VALUES
	(1, 3),
	(12, 2),
	(15, 10),
	(13, 11),
	(21, 12),
	(21, 13),
	(22, 14),
	(23, 15),
	(17, 16);
/*!40000 ALTER TABLE `task_tags` ENABLE KEYS */;

-- Дамп структуры для таблица laravel_todo.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы laravel_todo.users: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'testuser1', 'testuser1@todo.com', NULL, '$2y$10$UWiPWQEu6QECB6/VuhDL9OZ.eXyfVDtMPRE095Ir/c968nS/ZEGjy', NULL, NULL, NULL, '2021-09-11 12:09:25', '2021-09-11 12:09:25'),
	(2, 'testuser2', 'testuser2@todo.com', NULL, '$2y$10$q3B0gP5PmWr0fsgIa12oTOHvCtJKqa9W5RCflDsehyBz.JV46lHtq', NULL, NULL, NULL, '2021-09-11 12:37:37', '2021-09-11 12:37:37'),
	(3, 'testuser3', 'testuser3@todo.com', NULL, '$2y$10$m.bOES1PmAevu3g/9W5DSeMTaTOCraqxP8uBjPGvm.6BmK71N7962', NULL, NULL, NULL, '2021-09-12 15:33:51', '2021-09-12 15:33:51');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
