-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Фев 25 2025 г., 12:53
-- Версия сервера: 8.0.39-30
-- Версия PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cq44491_sbmtestt`
--

-- --------------------------------------------------------

--
-- Структура таблицы `avtos`
--

CREATE TABLE IF NOT EXISTS `avtos` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `codds`
--

CREATE TABLE IF NOT EXISTS `codds` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cod` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `codds`
--

INSERT INTO `codds` (`id`, `created_at`, `updated_at`, `cod`) VALUES
(1, '2024-11-19 02:59:34', '2025-02-24 05:58:09', 73350);

-- --------------------------------------------------------

--
-- Структура таблицы `details`
--

CREATE TABLE IF NOT EXISTS `details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `inn` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kpp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bik` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `check` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bank_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `details_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `menus`
--

INSERT INTO `menus` (`id`, `created_at`, `updated_at`, `name`, `url`) VALUES
(1, NULL, NULL, 'Главная', '/'),
(2, NULL, NULL, 'Регистрация поставщика', '/reg_provider/'),
(3, NULL, NULL, 'Регистрация заказчика', '/registration/'),
(5, NULL, NULL, 'Кабинет менеджера', '/manager_office/'),
(6, NULL, NULL, 'Кабинет поставщика', '/provider_office/'),
(7, NULL, NULL, 'Кабинет заказчика', '/customer_office/'),
(8, NULL, NULL, 'Кабинет администратора', '/admin_office/'),
(9, NULL, NULL, 'Регистрация менеджера', '/reg_manager/'),
(10, NULL, NULL, 'Авторизация', '/auth/');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_01_035536_create_tech_table', 2),
(6, '2024_11_01_035536_create_techs_table', 3),
(7, '2024_11_01_050249_create_avtos_table', 4),
(8, '2024_11_01_082648_create_menus_table', 5),
(9, '2024_11_05_031547_change_users_table', 6),
(10, '2024_11_05_033631_change_users_table', 7),
(11, '2024_11_05_034159_create_roles_table', 8),
(12, '2024_11_05_050951_change_roles_table', 9),
(13, '2024_11_15_060900_change_users_table', 10),
(14, '2024_11_19_084133_create_cods_table', 11),
(15, '2024_11_19_085954_create_codds_table', 12),
(16, '2024_11_21_053840_change_users_table', 13),
(17, '2024_11_22_042752_create_statuses_table', 14),
(18, '2024_11_22_045203_create_orders_table', 15),
(19, '2024_11_27_053706_change_orders_table', 16),
(20, '2024_11_27_074205_change_orders_table', 17),
(21, '2024_12_02_043657_change_orders_table', 18),
(22, '2024_12_02_044206_change_users_table', 19),
(23, '2024_12_02_060656_change_users_table', 20),
(24, '2024_12_02_061028_create_details_table', 21),
(25, '2024_12_02_074324_change_orders_table', 22),
(26, '2024_12_02_075441_change_users_table', 23),
(27, '2024_12_02_112242_change_details_table', 24),
(28, '2024_12_09_075306_change_users_table', 25),
(29, '2024_12_09_075907_change_users_table', 26),
(30, '2024_12_09_082734_change_orders_table', 27),
(31, '2024_12_09_093344_change_users_table', 28),
(32, '2024_12_09_093851_change_orders_table', 29),
(33, '2024_12_11_053234_create_techs_table', 30),
(34, '2024_12_11_054423_change_techs_table', 31),
(35, '2024_12_11_054542_create_techs_table', 32),
(36, '2024_12_11_055218_change_techs_table', 33),
(37, '2024_12_11_060509_create_technics_table', 34),
(38, '2024_12_17_052358_change_orders_table', 35),
(39, '2024_12_23_095251_create_providers_table', 36),
(40, '2024_12_25_041556_create_provider_order_table', 37),
(41, '2024_12_25_044746_change_provider_order_table', 38),
(42, '2024_12_25_044939_create_provider_orders_table', 39),
(43, '2024_12_25_082136_change_provider_orders_table', 40),
(44, '2024_12_25_093216_change_orders_table', 41),
(45, '2025_01_13_082532_change_technics_table', 42),
(46, '2025_01_20_082349_change_technics_table', 43),
(47, '2025_01_20_082801_create_provider_tech_table', 44),
(48, '2025_01_21_075718_change_provider_tech_table', 45),
(49, '2025_01_21_075926_create_provider_teches_table', 46),
(50, '2025_01_22_111847_create_statistics_orders_table', 47),
(51, '2025_02_19_035806_change_orders_table', 48);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tech` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `interval` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `where` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `job` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `money` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `status_id` bigint UNSIGNED DEFAULT NULL,
  `manager_id` bigint UNSIGNED DEFAULT NULL,
  `price` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `detail_id` bigint UNSIGNED DEFAULT NULL,
  `find_supplier` int DEFAULT NULL,
  `money_provider` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price_provider` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `provider_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_status_id_foreign` (`status_id`),
  KEY `orders_manager_id_foreign` (`manager_id`),
  KEY `orders_detail_id_foreign` (`detail_id`),
  KEY `orders_provider_id_foreign` (`provider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `created_at`, `updated_at`, `tech`, `date`, `time`, `interval`, `where`, `job`, `money`, `photo_name`, `user_id`, `status_id`, `manager_id`, `price`, `detail_id`, `find_supplier`, `money_provider`, `price_provider`, `provider_id`) VALUES
(1, '2025-02-20 00:37:16', '2025-02-20 01:53:18', 'Длинномер; 20 тонн; ширина кузова 2,35-2,45 метров; длина кузова 12-13,6 метров', '2025-02-20', '12:21', '1', '1', '1', 'Безналичные с НДС', NULL, NULL, 2, NULL, '1', NULL, NULL, NULL, NULL, NULL),
(3, '2025-02-24 05:48:39', '2025-02-24 06:02:48', 'Буроям; глубина 2 метра; диаметр 350 мм 500 мм', '2025-02-24', '12:00', '1', '1', '1', 'Безналичные с НДС', NULL, 7, 1, 7, '1', NULL, 1, 'Наличные', 'Стоимость (поставщик)', 8);

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `providers`
--

CREATE TABLE IF NOT EXISTS `providers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `phone` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tech` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `provider_orders`
--

CREATE TABLE IF NOT EXISTS `provider_orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `status_id` bigint UNSIGNED DEFAULT NULL,
  `manager_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provider_orders_user_id_foreign` (`user_id`),
  KEY `provider_orders_order_id_foreign` (`order_id`),
  KEY `provider_orders_status_id_foreign` (`status_id`),
  KEY `provider_orders_manager_id_foreign` (`manager_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `provider_orders`
--

INSERT INTO `provider_orders` (`id`, `created_at`, `updated_at`, `user_id`, `order_id`, `status_id`, `manager_id`) VALUES
(1, NULL, '2025-02-24 06:02:48', 8, 3, 3, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `provider_teches`
--

CREATE TABLE IF NOT EXISTS `provider_teches` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `provider_id` bigint UNSIGNED DEFAULT NULL,
  `tech_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provider_teches_provider_id_foreign` (`provider_id`),
  KEY `provider_teches_tech_id_foreign` (`tech_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `provider_teches`
--

INSERT INTO `provider_teches` (`id`, `created_at`, `updated_at`, `provider_id`, `tech_id`) VALUES
(1, NULL, NULL, 8, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Администраторы'),
(2, 'Менеджеры'),
(3, 'Поставщики'),
(4, 'Заказчики');

-- --------------------------------------------------------

--
-- Структура таблицы `statistics_orders`
--

CREATE TABLE IF NOT EXISTS `statistics_orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tech_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `statistics_orders`
--

INSERT INTO `statistics_orders` (`id`, `created_at`, `updated_at`, `tech_name`, `quantity`) VALUES
(1, '2025-02-20 00:37:16', '2025-02-20 00:37:16', 'длинномер; 20 тонн; ширина кузова 2,35-2,45 метров; длина кузова 12-13,6 метров', 1),
(2, '2025-02-24 05:40:22', '2025-02-24 05:48:39', 'буроям; глубина 2 метра; диаметр 350 мм 500 мм', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'Активные'),
(2, 'Завершенные'),
(3, 'Архивные');

-- --------------------------------------------------------

--
-- Структура таблицы `technics`
--

CREATE TABLE IF NOT EXISTS `technics` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `char_one` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `char_two` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `char_three` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price_nds` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price_no_nds` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `min_hour` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `technics`
--

INSERT INTO `technics` (`id`, `created_at`, `updated_at`, `type`, `name`, `char_one`, `char_two`, `char_three`, `price_nds`, `price_no_nds`, `min_hour`) VALUES
(1, NULL, NULL, 'Самосвал', 'Камаз', '10 тонн', '', '', '2400', '2200', '8'),
(2, NULL, NULL, 'Самосвал', 'Камаз', '15 тонн', '', '', '2400', '2200', '8'),
(3, NULL, NULL, 'Самосвал', 'Howo', '25 тонн', '', '', '3500', '3000', '8'),
(4, NULL, NULL, 'Самосвал', 'FAW', '30 тонн', '', '', '3500', '3000', '8'),
(5, NULL, NULL, 'Самосвал', '', '20 кубов', '', '', '', '', ''),
(6, NULL, NULL, 'Самосвал', '', '25 кубов', '', '', '', '', ''),
(7, NULL, NULL, 'Самосвал', '', '30 кубов', '', '', '', '', ''),
(8, NULL, NULL, 'Самосвал', '', '3х осный', '', '', '', '', ''),
(9, NULL, NULL, 'Самосвал', '', '4х осный', '', '', '', '', ''),
(10, NULL, NULL, 'Тонар', '', '', '', '', 'Договорная', '', ''),
(11, NULL, NULL, 'Углевоз', '', '', '', '', 'Договорная', '', ''),
(12, NULL, NULL, 'Грузовой автомобиль', '', 'полуприцепом 20 тонн', '12 метров', '', '3200', '', '8'),
(13, NULL, NULL, 'Грузовой автомобиль', 'MAN', 'тралл 20 тонн', '', '', '5000', '', '8'),
(14, NULL, NULL, 'Грузовой автомобиль', 'MAN', 'тралл 60 тонн', '', '', 'Договорная', '', 'Договорная'),
(15, NULL, NULL, 'Длинномер', '', '20 тонн', 'ширина кузова 2,35-2,45 метров', 'длина кузова 12-13,6 метров', '3500', '', '5'),
(16, NULL, NULL, 'Панелевоз', '', '', '', '', 'Договорная', '', 'Договорная'),
(17, NULL, NULL, 'Перевозки негабаритных грузов', '', '', '', '', 'Договорная', '', 'Договорная'),
(18, NULL, NULL, 'Автокран', 'TADANA', '10 тонн', '23 метра', '', '3000', '', '8'),
(19, NULL, NULL, 'Автокран', 'Kato', '10 тонн', '23 метра', '', '3000', '', '8'),
(20, NULL, NULL, 'Автокран', 'Kato', '10 тонн', '21-26 метров', '', '3700', '', '10'),
(21, NULL, NULL, 'Автокран', 'Kato', '16 тонн', '22-26 метров', '', '4300', '', '10'),
(22, NULL, NULL, 'Автокран', 'Като', '16 тонн', '28 метров', '', '3600', '', '8'),
(23, NULL, NULL, 'Автокран', 'TADANO', '16 тонн', '28 метров', '', '3600', '', '8'),
(24, NULL, NULL, 'Автокран', 'Ивановец', '25 тонн', '20-24 метра', '', '4000', '', '10'),
(25, NULL, NULL, 'Автокран', 'Галичанин', '25 тонн', '20-24 метра', '', '4000', '', '10'),
(26, NULL, NULL, 'Автокран', 'Ивановец', '25 тонн', '28-31 метр', '', '4300', '', '10'),
(27, NULL, NULL, 'Автокран', 'Галичанин', '25 тонн', '28-31 метр', '', '4300', '', '10'),
(28, NULL, NULL, 'Автокран', 'Клинцы', '25 тонн', '28-31 метр', '', '4300', '', '10'),
(29, NULL, NULL, 'Автокран', 'XCMG', '25 тонн', '25-30 метров', '', '4900', '', '10'),
(30, NULL, NULL, 'Автокран', 'Kato', '25 тонн', '25-30 метров', '', '4900', '', '10'),
(31, NULL, NULL, 'Автокран', 'TADANA', '25 тонн', '25-30 метров', '', '4900', '', '10'),
(32, NULL, NULL, 'Автокран', 'Kobelko', '25 тонн', '25-30 метров', '', '4900', '', '10'),
(33, NULL, NULL, 'Автокран', 'КС-55713 камаз вездеход', '25 тонн', 'стрела 28 метров', '', '3800', '', '8'),
(34, NULL, NULL, 'Автокран', 'КС-55713 камаз вездеход', '25 тонн', 'стрела 21,3 метра', '', '3800', '', '8'),
(35, NULL, NULL, 'Автокран', 'Галичанин', '25 тонн', 'стрела 21.7 метра', '', '3800', '', '4'),
(36, NULL, NULL, 'Автокран', 'Ивановец', '25 тонн', 'стрела 21.7 метра', '', '3800', '', '4'),
(37, NULL, NULL, 'Автокран', 'Мотовилиха', '25 тонн', 'стрела 21.7 метра', '', '3800', '', '4'),
(38, NULL, NULL, 'Автокран', 'Ивановец', '35 тонн', 'стрела 23-32 метра', '', '3800', '', '10'),
(39, NULL, NULL, 'Автокран', 'Мотовилиха', '35 тонн', 'стрела 23-32 метра', '', '3800', '', ''),
(40, NULL, NULL, 'Автокран', 'Мотовилиха', '35 тонн', 'стрела 23.7 метра', '', '3800', '', '8'),
(41, NULL, NULL, 'Автокран', 'Клинцы', '25 тонн', 'стрела 31 метр', '', '3800', '', '8'),
(42, NULL, NULL, 'Автокран', 'ЗУМЛИОН', '30 тонн', 'стрела 42 метра', '', '5500', '', '10'),
(43, NULL, NULL, 'Автокран', 'Мотовилиха Урал-вездеход', '25 тонн', 'стрела 32 метра', '', '4000', '', '8'),
(44, NULL, NULL, 'Автокран', 'Като', '22 тонны', 'стрела 23 метра', '', '3900', '', '8'),
(45, NULL, NULL, 'Автокран', 'TADANO', '22 тонны', 'стрела 23 метра', '', '3900', '', '8'),
(46, NULL, NULL, 'Автокран', 'Като', '25 тонн', 'стрела 31 метр', '', '4200', '', '8'),
(47, NULL, NULL, 'Автокран', 'TADANO', '25 тонн', 'стрела 31 метр', '', '4200', '', '8'),
(48, NULL, NULL, 'Автокран', 'Като', '30 тонн', 'стрела 32 метра', '', '4500', '', '8'),
(49, NULL, NULL, 'Автокран', 'TADANO', '30 тонн', 'стрела 32 метра', '', '4500', '', '8'),
(50, NULL, NULL, 'Автокран', 'Като', '35 тонн', 'стрела 36 метров', '', '5000', '', '8'),
(51, NULL, NULL, 'Автокран', 'TADANO', '35 тонн', 'стрела 36 метров', '', '5000', '', '8'),
(52, NULL, NULL, 'Автокран', 'Като', '50 тонн', 'стрела 41 метр', '', '6500', '', '8'),
(53, NULL, NULL, 'Автокран', 'TADANO', '50 тонн', 'стрела 41 метр', '', '6500', '', '8'),
(54, NULL, NULL, 'Автокран', 'GROVE', '50 тонн', 'стрела 41 метр', '', '6500', '', '8'),
(55, NULL, NULL, 'Автокран', 'LIEBHERR', '50 тонн', 'стрела 41 метр', '', '6500', '', '8'),
(56, NULL, NULL, 'Автокран', 'Като', '60 тонн', 'стрела 44 метра', '', '7000', '', '8'),
(57, NULL, NULL, 'Автокран', 'TADANO', '60 тонн', 'стрела 44 метра', '', '7000', '', '8'),
(58, NULL, NULL, 'Автокран', 'GROVE', '60 тонн', 'стрела 44 метра', '', '7000', '', '8'),
(59, NULL, NULL, 'Автокран', 'LIEBHERR', '60 тонн', 'стрела 44 метра', '', '7000', '', '8'),
(60, NULL, NULL, 'Автокран', 'Като', '65 тонн', 'стрела 44.5 метра', '', '7500', '', '8'),
(61, NULL, NULL, 'Автокран', 'TADANO', '65 тонн', 'стрела 44.5 метра', '', '7500', '', '8'),
(62, NULL, NULL, 'Автокран', 'GROVE', '65 тонн', 'стрела 44.5 метра', '', '7500', '', '8'),
(63, NULL, NULL, 'Автокран', 'LIEBHERR', '65 тонн', 'стрела 44.5 метра', '', '7500', '', '8'),
(64, NULL, NULL, 'Автокран', 'Като', '70 тонн', 'стрела 44 метра', '', '8500', '', '8'),
(65, NULL, NULL, 'Автокран', 'TADANO', '70 тонн', 'стрела 44 метра', '', '8500', '', '8'),
(66, NULL, NULL, 'Автокран', 'GROVE', '70 тонн', 'стрела 44 метра', '', '8500', '', '8'),
(67, NULL, NULL, 'Автокран', 'LIEBHERR', '70 тонн', 'стрела 44 метра', '', '8500', '', '8'),
(68, NULL, NULL, 'Автокран', 'GROVE', '80 тонн', 'стрела 58 метров', '', '9000', '', '8'),
(69, NULL, NULL, 'Автокран', 'LIEBHER', '80 тонн', 'стрела 58 метров', '', '9000', '', '8'),
(70, NULL, NULL, 'Автокран', 'GROVE', '95 тонн', 'стрела 58 метров', '', '10000', '', '8'),
(71, NULL, NULL, 'Автокран', 'LIEBHER', '95 тонн', 'стрела 58 метров', '', '10000', '', '8'),
(72, NULL, NULL, 'Автокран', 'GROVE', '100 тонн', 'стрела 60 метров', '', '11000', '', '10'),
(73, NULL, NULL, 'Автокран', 'LIEBHER', '100 тонн', 'стрела 60 метров', '', '11000', '', '10'),
(74, NULL, NULL, 'Автокран', 'GROVE', '120 тонн', 'стрела 66 метров', '', '12000', '', '10'),
(75, NULL, NULL, 'Автокран', 'LIEBHER', '120 тонн', 'стрела 66 метров', '', '12000', '', '10'),
(76, NULL, NULL, 'Автокран', 'GROVE', '130 тонн', 'стрела 60 метров', '', '13500', '', '10'),
(77, NULL, NULL, 'Автокран', 'LIEBHER', '130 тонн', 'стрела 60 метров', '', '13500', '', '10'),
(78, NULL, NULL, 'Автокран', 'GROVE', '160 тонн', 'стрела 62 метра', '', '16000', '', '10'),
(79, NULL, NULL, 'Автокран', 'LIEBHER', '160 тонн', 'стрела 62 метра', '', '16000', '', '10'),
(80, NULL, NULL, 'Автокран', 'GROVE', '200 тонн', 'стрела 72 метра', '', '18000', '', '10'),
(81, NULL, NULL, 'Автокран', 'LIEBHER', '200 тонн', 'стрела 72 метра', '', '18000', '', '10'),
(82, NULL, NULL, 'Автокран', 'GROVE', '220 тонн', 'стрела 60 метров', '', '19000', '', '10'),
(83, NULL, NULL, 'Автокран', 'LIEBHER', '220 тонн', 'стрела 60 метров', '', '19000', '', '10'),
(84, NULL, NULL, 'Автокран', 'GROVE', '220 тонн', 'стрела 68 метров', '', '19000', '', '10'),
(85, NULL, NULL, 'Автокран', 'LIEBHER', '220 тонн', 'стрела 68 метров', '', '19000', '', '10'),
(86, NULL, NULL, 'Автокран', 'GROVE', '250 тонн', 'стрела 60 метров', '', '28000', '', '11'),
(87, NULL, NULL, 'Автокран', 'LIEBHER', '250 тонн', 'стрела 60 метров', '', '28000', '', '11'),
(88, NULL, NULL, 'Автокран', 'GROVE', '300 тонн', 'стрела 80 метров', '', '28000', '', '11'),
(89, NULL, NULL, 'Автокран', 'LIEBHER', '300 тонн', 'стрела 80 метров', '', '28000', '', '11'),
(90, NULL, NULL, 'Автокран', 'GROVE', '350 тонн', 'стрела 70 метров', '', '30000', '', '11'),
(91, NULL, NULL, 'Автокран', 'LIEBHER', '350 тонн', 'стрела 70 метров', '', '30000', '', '11'),
(92, NULL, NULL, 'Автокран', 'GROVE', '400 тонн', 'стрела 60 метров', '', '35000', '', '11'),
(93, NULL, NULL, 'Автокран', 'LIEBHER', '400 тонн', 'стрела 60 метров', '', '35000', '', '11'),
(94, NULL, NULL, 'Автокран', 'LIEBHER 1500-8.1', '500 тонн', 'стрела 50 метров', '', '40000', '', '11'),
(95, NULL, NULL, 'Кран', '', '25 тонн', '', 'гусеничный', 'Договорная', '', 'Договорная'),
(96, NULL, NULL, 'Автовышка', '', '16 метров', '', '', '3100', '', '10'),
(97, NULL, NULL, 'Автовышка', '', '20 метров', '', '', '3300', '', '10'),
(98, NULL, NULL, 'Автовышка', '', '28 метров', '', '', '3600', '', '10'),
(99, NULL, NULL, 'Автовышка', '', '30 метров', '', '', '4000', '', '10'),
(100, NULL, NULL, 'Автовышка', '', '40 метров', '', '', '5500', '', '10'),
(101, NULL, NULL, 'Экскаватор', 'Doosan-180', 'ковш 0.9-1.3м3', '', 'полноповоротный', '4300', '', '10'),
(102, NULL, NULL, 'Экскаватор', 'Doosan-190', 'ковш 0.9-1.3м3', '', 'полноповоротный', '4300', '', '10'),
(103, NULL, NULL, 'Экскаватор', 'Doosan-210', 'ковш 0.9-1.3м3', '', 'полноповоротный', '4300', '', '10'),
(104, NULL, NULL, 'Экскаватор', 'JSB-160', 'ковш 0.9-1.3м3', '', 'полноповоротный', '4300', '', '10'),
(105, NULL, NULL, 'Экскаватор', 'Caterpillar 325-365', 'ковш 0.9-1.3м3', '', 'полноповоротный', '4300', '', '10'),
(106, NULL, NULL, 'Экскаватор', 'Doosan-180', 'молот', '', 'полноповоротный', '6000', '', '10'),
(107, NULL, NULL, 'Экскаватор', 'Doosan-190', 'молот', '', 'полноповоротный', '6000', '', '10'),
(108, NULL, NULL, 'Экскаватор', 'Doosan-210', 'молот', '', 'полноповоротный', '6000', '', '10'),
(109, NULL, NULL, 'Экскаватор', 'JSB-160', 'молот', '', 'полноповоротный', '6000', '', '10'),
(110, NULL, NULL, 'Экскаватор', 'Caterpillar 325-365', 'молот', '', 'полноповоротный', '6000', '', '10'),
(111, NULL, NULL, 'Экскаватор', 'JSB-220 Caterpillar 225-265', '1-1.2м3', '', 'гусеничный', '4500', '', '10'),
(112, NULL, NULL, 'Экскаватор', 'DEVELON 190', 'с трамбовкой 1м3', 'с гидромолотом', 'колесный', '5000', '', '9'),
(113, NULL, NULL, 'Экскаватор', 'DEVELON 190', '1м3', '', 'колесный', '4300', '', '9'),
(114, NULL, NULL, 'Экскаватор', 'DEVELON DX360LCA-7M', '2м3', '', 'гусеничный', '5500', '', '10'),
(115, NULL, NULL, 'Экскаватор', 'DEVELON DX360LCA-7M', '2м3', '', 'гусеничный', '5500', '', '10'),
(116, NULL, NULL, 'Экскаватор', 'DX260LCA DOOSAN', '1.3м3', '', 'гусеничный', '4300', '', '10'),
(117, NULL, NULL, 'Экскаватор', 'Komatsu PC-300', '1.3м3', '', 'гусеничный', '4500', '', '10'),
(118, NULL, NULL, 'Экскаватор', 'CATERPILLAR 320Gc Delta F-15', '1400 кг', 'с гидромолотом', 'гусеничный', '5000', '', '10'),
(119, NULL, NULL, 'Экскаватор', 'CATERPILLAR 320Gc', '1м3', '', 'гусеничный', '4200', '', '10'),
(120, NULL, NULL, 'Экскаватор', 'JCB JS205LC', '1м3', '', 'гусеничный', '4000', '', '10'),
(121, NULL, NULL, 'Экскаватор', 'Komatsu PC 220', '1.2м3', '', '', '4200', '', '8'),
(122, NULL, NULL, 'Экскаватор', 'САТ', '1.2м3', '', 'гусеничный', 'Договорная', '', '8'),
(123, NULL, NULL, 'Экскаватор', 'Komatsu PC 270', '1.35м3', '', 'гусеничный', '4400', '', '8'),
(124, NULL, NULL, 'Экскаватор', 'Komatsu PC 300', '1.5м3', '', '', '4600', '', '8'),
(125, NULL, NULL, 'Экскаватор', 'HITACHI', '1.5м3', '', 'гусеничный', 'Договорная', '', '8'),
(126, NULL, NULL, 'Экскаватор', 'Komatsu PC 360', '2м3', '', 'гусеничный', '5000', '', '8'),
(127, NULL, NULL, 'Экскаватор', 'Hitachi', '1.1м3', '', 'пневмо', '4800', '', '8'),
(128, NULL, NULL, 'Экскаватор', 'CAT 318 D', '1м3', '', 'пневмо', '4800', '', '8'),
(129, NULL, NULL, 'Экскаватор', 'Hundai', '0.8м3', '', 'пневмо', '4800', '', '8'),
(130, NULL, NULL, 'Экскаватор', 'Hundai', '1.3м3', '', 'пневмо', '4800', '', '8'),
(131, NULL, NULL, 'Экскаватор', 'Hundai', '1.3м3', 'скальный ковш', '', '4800', '', '8'),
(132, NULL, NULL, 'Экскаватор', 'Hundai', '1.3м3', 'планировочный ковш', '', '4800', '', '8'),
(133, NULL, NULL, 'Экскаватор погрузчик', 'JSB', '1м3', '', 'колесный', '4600', '', '8'),
(134, NULL, NULL, 'Экскаватор погрузчик', 'JCB', '0.4-0.6м3', '', '', '3800', '', '8'),
(135, NULL, NULL, 'Экскаватор погрузчик', 'John Deere', '0.4-0.6м3', '', '', '3800', '', '8'),
(136, NULL, NULL, 'Экскаватор погрузчик', 'Caterpillar', '0.4-0.6м3', '', '', '3800', '', '8'),
(137, NULL, NULL, 'Фронтальный погрузчик', '', '1,3 м3', '', '', '3500', '', '4'),
(138, NULL, NULL, 'Экскаватор', 'NewHolland 115', '0,3м3', '', '', '3500', '', '8'),
(139, NULL, NULL, 'Фронтальный погрузчик', '', '1,3 м3', '', '', '3500', '', '4'),
(140, NULL, NULL, 'Экскаватор', 'Caterpillar 432 Е', '0,3м3', '', '', '3500', '', '8'),
(141, NULL, NULL, 'Фронтальный погрузчик', '', '2м3', '', '', '3500', '', '10'),
(142, NULL, NULL, 'Фронтальный погрузчик', 'LG933L', '2м3', '', '', '3200', '', '8'),
(143, NULL, NULL, 'Фронтальный погрузчик', 'SHANTUI SL 30W', '2м3', '', '', '3000', '', '8'),
(144, NULL, NULL, 'Фронтальный погрузчик', '', '3м3', '', '', '4500', '', '10'),
(145, NULL, NULL, 'Фронтальный погрузчик', 'SHANTUI SL 50 W-2', '3м3', '', '', '3500', '', '8'),
(146, NULL, NULL, 'Минипогрузчик', '', '', '', 'щетка+вода CASE', '2200', '', '8'),
(147, NULL, NULL, 'Компрессор', 'AIRMAN PDS 175 S', '', '', '', '3200', '', '8'),
(148, NULL, NULL, 'Компрессор', 'AIRMAN PDS 185 S', '', '', '', '2500', '', '5'),
(149, NULL, NULL, 'Бульдозер', 'SHANTUI SD-16', '19 тонн', '', 'гусеничный', '3600', '', '10'),
(150, NULL, NULL, 'Бульдозер', 'Шантуй', '22 тонны', '', '', '4500', '', '10'),
(151, NULL, NULL, 'Бульдозер', 'Коматсу-65', '23.5 тонны', '', '', '4500', '', '8'),
(152, NULL, NULL, 'Бульдозер', 'Шантуй-32', '34 тонны', '', '', '6000', '', '8'),
(153, NULL, NULL, 'Бульдозер', 'SHANTUI SD-32', '38 тонн', '', '', '6300', '', '10'),
(154, NULL, NULL, 'Бульдозер', 'Коматсу D-155 A-5', '39 тонн', '', '', '8000', '', '8'),
(155, NULL, NULL, 'Бульдозер', 'CATERPILAR D9R', '', '', '', '8000', '', '10'),
(156, NULL, NULL, 'Бульдозер', 'CATERPILAR D9R', '', '', 'с усиленнйо защитой для валки леса', '', '', '8'),
(157, NULL, NULL, 'Бульдозер', 'CATERPILAR D9R', '', '', 'с широкими гусеницами( болотоход)', '', '', '8'),
(158, NULL, NULL, 'Виброкаток', 'SHANTUI SR2P-5', '12 тонн', '', '', '3500', '', '10'),
(159, NULL, NULL, 'Каток', 'Шантуй', '14 тонн', '', '', '3100', '', '8'),
(160, NULL, NULL, 'Каток', 'САТ', '14 тонн', '', '', '3100', '', '8'),
(161, NULL, NULL, 'Каток', 'Шантуй', '16 тонн', '', '', '3300', '', '8'),
(162, NULL, NULL, 'Каток', 'САТ', '16 тонн', '', '', '3300', '', '8'),
(163, NULL, NULL, 'Каток', 'HAMM', '20 тонн', '', '', '3600', '', '8'),
(164, NULL, NULL, 'Каток', 'НАММ', '25 тонн', '', '', '4000', '', '8'),
(165, NULL, NULL, 'Каток c вибрацией', 'Раскат ДУ 85', '14 тонн', '', '', '3500', '', '10'),
(166, NULL, NULL, 'Каток с вибрацией', 'АММАNN-110', '14 тонн', '', '', '3700', '', '10'),
(167, NULL, NULL, 'Каток c вибрацией', 'Boomag 212b 215b', '16 тонн', '', 'бандаж', '4000', '', '10'),
(168, NULL, NULL, 'Каток c вибрацией', 'Sany', '20 тонн', '', 'бандаж', '4600', '', '10'),
(169, NULL, NULL, 'Самогруз', 'Скания', '11 тонн', '19 метров', '', 'Договорная', '', '8'),
(170, NULL, NULL, 'Самогруз', 'Дизель', '5 тонн', '', '', '2900', '', '8'),
(171, NULL, NULL, 'Самогруз', 'HINO', '5 тонн', '', '', '2900', '', '4'),
(172, NULL, NULL, 'Самогруз', 'Изусу Гига', '3 тонн', '', '', '2900', '', '4'),
(173, NULL, NULL, 'Самогруз', 'Mitsubishi FUSO (Митсубиси Фусо)', '3 тонны', '', '', '2900', '', '4'),
(174, NULL, NULL, 'Самогруз HINO 3 тонны', 'HINO', '3 тонны', '', '', '2900', '', '4'),
(175, NULL, NULL, 'Самогруз', '', '5 тонн', 'стрела 3 тонны/ 5-6.5 метров', '', '2800', '', '5'),
(176, NULL, NULL, 'Самогруз', '', '10 тонн', 'стрела 5 тонны/8-10 метров', '', '4000', '', '8'),
(177, NULL, NULL, 'Самогруз', '', '10 тонн', 'стрела 7 тонн/17-20 метров', '', '4000', '', '8'),
(178, NULL, NULL, 'Самогруз', '', '10 тонн', 'стрела 10 тонн/17-20 метров', '', '5000', '', '8'),
(179, NULL, NULL, 'Самогруз', '', '12 метровый борт', 'стрела 20 тонн', '', 'Договорная', '', ''),
(180, NULL, NULL, 'Гидромолот', 'Delta F-10 (Дельта)', 'ковш 0,9-1,3 м3', '', 'на базе колесного экскаватора', '6000', '', '8'),
(181, NULL, NULL, 'Гидромолот', 'Delta F-5 (Дельта)', '', '', '', '4000', '', '8'),
(182, NULL, NULL, 'Клык', '', '', '', 'на базе колесного и гусеничного экскаватора', '4500', '', '8'),
(183, NULL, NULL, 'Вибропогружатель', '', '', '', 'гусеничный экскаватор', '9000', '', '8'),
(184, NULL, NULL, 'Вибропогружатель', '', '', '', 'автокран', '8000', '', '8'),
(185, NULL, NULL, 'Вибротрамбовка', 'Profbreaker PBC 800', '', '', '', '4000', '', '8'),
(186, NULL, NULL, 'Вибротрамбовка', 'Profbreaker PBC 800', '', '', '', '5000', '', '8'),
(187, NULL, NULL, 'ношницы', '', '', '', '', 'Договорная', '', 'Договорная'),
(188, NULL, NULL, 'крашер', '', '', '', '', 'Договорная', '', 'Договорная'),
(189, NULL, NULL, 'Грейдер', 'XCMG GR-215', '16 тонн', '', 'средний', '4500', '', '10'),
(190, NULL, NULL, 'Грейдер', 'ГС-18.07', '16 тонн', '', 'средний', '4500', '', '10'),
(191, NULL, NULL, 'Грейдер', 'John Deere', '18 тонн', '', 'средний', '5000', '', '10'),
(192, NULL, NULL, 'Грейдер', 'John Deere 772G', '20 тонн', '', 'средний', '5200', '', '10'),
(193, NULL, NULL, 'Буроям', 'БМ-205Д-1', 'глубина 2 метра', 'диаметр 350 мм 500 мм', '', '3200', '', '8'),
(194, NULL, NULL, 'Буроям', '', '', '', '', '4600', '', '8'),
(195, NULL, NULL, 'Буроям, ямобур', '', '100-300 мм.', '2,5-4,5 м', '', '5000', '', '10'),
(196, NULL, NULL, 'Буроям, ямобур', '', '300-600 мм.', '8-12 м', 'вездеход', '6000', '', '10'),
(197, NULL, NULL, 'сваебойная установка', '', '', '', '', 'Договорная', '', 'Договорная'),
(198, NULL, NULL, 'асфальтоукладчик', '', '', '', '', 'Договорная', '', 'Договорная');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` int NOT NULL,
  `cur_detail_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  KEY `users_role_id_foreign` (`role_id`),
  KEY `users_cur_detail_id_foreign` (`cur_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `remember_token`, `created_at`, `updated_at`, `role_id`, `phone`, `activity`, `cur_detail_id`) VALUES
(7, 'менеджер', 'eaOIW2j4lHW3dDAoJkV6oaQy1yQi9bIMKSW2vPVeHuuOZJFmjUJdOLjLG2Y5', '2025-02-24 05:36:31', '2025-02-24 05:36:31', 2, '+7(913) 735-5491', 1, NULL),
(8, 'Иван', 'ttYcSVJNHaelJQhFSeQOBsTZTqIckzvDTeiboYxSSEhSlLmF4xq4jnr5pKWQ', NULL, NULL, 3, '+7(991) 504-8332', 1, NULL);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `details`
--
ALTER TABLE `details`
  ADD CONSTRAINT `details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_detail_id_foreign` FOREIGN KEY (`detail_id`) REFERENCES `details` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `provider_orders`
--
ALTER TABLE `provider_orders`
  ADD CONSTRAINT `provider_orders_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `provider_orders_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `provider_orders_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `provider_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `provider_teches`
--
ALTER TABLE `provider_teches`
  ADD CONSTRAINT `provider_teches_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `provider_teches_tech_id_foreign` FOREIGN KEY (`tech_id`) REFERENCES `technics` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_cur_detail_id_foreign` FOREIGN KEY (`cur_detail_id`) REFERENCES `details` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
