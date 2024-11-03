-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2024 at 11:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_cleaning_services_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us_content`
--

CREATE TABLE `about_us_content` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_ar` varchar(200) NOT NULL,
  `title_en` varchar(200) NOT NULL,
  `content_ar` varchar(500) NOT NULL,
  `content_en` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `base_companies_rates`
--

CREATE TABLE `base_companies_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(150) NOT NULL,
  `name_en` varchar(150) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `base_drivers_rates`
--

CREATE TABLE `base_drivers_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(150) NOT NULL,
  `name_en` varchar(150) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `base_orders_rates`
--

CREATE TABLE `base_orders_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(150) NOT NULL,
  `name_en` varchar(150) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_ar`, `name_en`, `img_path`, `active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(5, 'القسم الأول', 'first category', 'images/categories/1721324938353.png', 0, '2024-07-18 18:51:14', '2024-07-18 18:47:27', '2024-07-18 18:51:14');

-- --------------------------------------------------------

--
-- Table structure for table `categories_countries`
--

CREATE TABLE `categories_countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `governorate_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `access_token` text NOT NULL,
  `provider` varchar(100) NOT NULL,
  `provider_id` varchar(50) NOT NULL,
  `provider_name` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `avatar`, `phone`, `email`, `email_verified_at`, `password`, `remember_token`, `access_token`, `provider`, `provider_id`, `provider_name`, `active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'client name', NULL, 'client 333', 'client433@test.com', NULL, '$2y$10$DBCJdWG8VgfTlP98LE8tzejp5jAzXRdgXE522WSxi6SSWhUzy9VWu', NULL, '', '', '', '', 1, NULL, '2024-07-21 17:46:26', '2024-07-21 17:46:26'),
(2, 'client name', NULL, '010212', 'client@test.com', NULL, '$2y$10$qAUmYBeLtGcIzQn3VuZV4ekx9B8fA9YMj.yWDsRilGOMs7omTvf8y', NULL, '', '', '', '', 1, NULL, '2024-07-21 22:07:20', '2024-07-21 22:07:20');

-- --------------------------------------------------------

--
-- Table structure for table `clients_companies_rates`
--

CREATE TABLE `clients_companies_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `base_companies_rate_id` bigint(20) UNSIGNED NOT NULL,
  `value` enum('1','2','3','4','5') NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients_password_resets`
--

CREATE TABLE `clients_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(6) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_drivers_rates`
--

CREATE TABLE `client_drivers_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `base_companies_rate_id` bigint(20) UNSIGNED NOT NULL,
  `value` enum('1','2','3','4','5') NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_general_offer_orders`
--

CREATE TABLE `client_general_offer_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(300) NOT NULL,
  `status` enum('waiting','done') NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `general_offer_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_locations`
--

CREATE TABLE `client_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `lat` decimal(10,8) NOT NULL,
  `long` decimal(10,8) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `location_type` enum('apartment','house','office','other') NOT NULL,
  `street` varchar(50) NOT NULL,
  `building` varchar(10) NOT NULL,
  `floor` varchar(10) NOT NULL,
  `apartment` varchar(10) NOT NULL,
  `additional_instructions` varchar(200) NOT NULL,
  `detailed_address` varchar(200) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_locations`
--

INSERT INTO `client_locations` (`id`, `client_id`, `lat`, `long`, `phone_number`, `telephone`, `location_type`, `street`, `building`, `floor`, `apartment`, `additional_instructions`, `detailed_address`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 21.32433000, 21.32433000, '01097979112', 'phone', 'apartment', 'eltahreer', '92', 'first', '2', 'te', '92 شارع القاضي متفرع من شارع التحرير', '2024-07-22 17:48:34', '2024-07-22 17:47:29', '2024-07-22 17:48:34'),
(2, 2, 21.32433000, 21.32433000, '01097979112', 'phone', 'apartment', 'eltahreer', '92', 'first', '2', 'te', '92 شارع القاضي متفرع من شارع التحرير', NULL, '2024-07-22 17:51:43', '2024-07-22 17:51:43');

-- --------------------------------------------------------

--
-- Table structure for table `client_orders`
--

CREATE TABLE `client_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `delivery_type_id` bigint(20) UNSIGNED NOT NULL,
  `promo_code_id` bigint(20) UNSIGNED NOT NULL,
  `client_location_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(100) NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `logo_path` varchar(80) DEFAULT NULL,
  `cover_path` varchar(80) DEFAULT NULL,
  `orders_per_hour` int(11) NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies_categories`
--

CREATE TABLE `companies_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies_deliver_to_cities`
--

CREATE TABLE `companies_deliver_to_cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies_working_with_drivers_managers`
--

CREATE TABLE `companies_working_with_drivers_managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `drivers_manager_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cooperation_with_us_reasons`
--

CREATE TABLE `cooperation_with_us_reasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_ar` varchar(150) NOT NULL,
  `title_en` varchar(150) NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(150) NOT NULL,
  `name_en` varchar(150) NOT NULL,
  `img_path` varchar(100) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country_managers`
--

CREATE TABLE `country_managers` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_types`
--

CREATE TABLE `delivery_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `description_ar` varchar(200) NOT NULL,
  `description_en` varchar(200) NOT NULL,
  `added_value` double NOT NULL,
  `added_value_type` enum('percentage','constant') NOT NULL,
  `after_hours` varchar(4) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `manager_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers_app_clients`
--

CREATE TABLE `drivers_app_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `lat` decimal(10,8) NOT NULL,
  `long` decimal(10,8) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers_app_orders`
--

CREATE TABLE `drivers_app_orders` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `delivery_type` enum('normal','fast') NOT NULL,
  `drivers_app_client_id` bigint(20) UNSIGNED NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `discount_value_type` enum('constant','percentage') NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers_app_products`
--

CREATE TABLE `drivers_app_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers_app_product_options`
--

CREATE TABLE `drivers_app_product_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `price` double NOT NULL,
  `drivers_app_product_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers_managers`
--

CREATE TABLE `drivers_managers` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_locations`
--

CREATE TABLE `driver_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` bigint(20) UNSIGNED NOT NULL,
  `lat` decimal(10,8) NOT NULL,
  `long` decimal(10,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_location_stop_points`
--

CREATE TABLE `driver_location_stop_points` (
  `driver_location_id` bigint(20) UNSIGNED NOT NULL,
  `to_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reason` enum('traffic','not_traffic') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `easy_orders`
--

CREATE TABLE `easy_orders` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(500) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frequently_asked_questions`
--

CREATE TABLE `frequently_asked_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_ar` varchar(500) NOT NULL,
  `question_en` varchar(500) NOT NULL,
  `answer_ar` varchar(500) NOT NULL,
  `answer_en` varchar(500) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_offers`
--

CREATE TABLE `general_offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `from` datetime NOT NULL,
  `to` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `governorates`
--

CREATE TABLE `governorates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_page_content`
--

CREATE TABLE `home_page_content` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_ar` varchar(200) NOT NULL,
  `title_en` varchar(200) NOT NULL,
  `content_ar` varchar(500) NOT NULL,
  `content_en` varchar(500) NOT NULL,
  `button_text_ar` varchar(25) NOT NULL,
  `button_text_en` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_slider_images`
--

CREATE TABLE `home_slider_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `client_order_id` bigint(20) UNSIGNED NOT NULL,
  `drivers_app_order_id` bigint(20) UNSIGNED NOT NULL,
  `tax_value` decimal(10,2) NOT NULL,
  `tax_value_type` enum('percentage','constant') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `discount_value_type` enum('percentage','constant') NOT NULL,
  `minimum_charge` decimal(5,2) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2023_11_20_154753_create_base_companies_rates_table', 1),
(5, '2023_11_20_155520_create_base_drivers_rates_table', 1),
(6, '2023_11_20_155705_create_base_orders_rates_table', 1),
(7, '2023_11_20_155816_create_categories_table', 1),
(8, '2023_11_20_162617_create_transportation_periods_table', 1),
(9, '2023_11_20_162807_create_transportation_periods_assigned_to_drivers_table', 1),
(10, '2023_11_20_175751_create_countries_table', 1),
(11, '2023_11_21_161143_create_clients_table', 1),
(12, '2023_11_21_170816_create_companies_table', 1),
(13, '2023_11_21_174421_create_orders_table', 1),
(14, '2023_11_21_175848_create_country_managers_table', 1),
(15, '2023_11_21_190111_create_drivers_app_clients_table', 1),
(16, '2023_11_21_190539_create_drivers_table', 1),
(17, '2023_11_21_191839_create_drivers_app_products_table', 1),
(18, '2023_11_21_192056_create_drivers_app_product_options_table', 1),
(19, '2023_11_21_192343_create_drivers_managers_table', 1),
(20, '2023_11_21_203149_create_governorates_table', 1),
(21, '2023_11_22_153533_create_about_us_content_table', 1),
(22, '2023_11_22_160445_create_categories_countries_table', 1),
(23, '2023_11_22_160638_create_cities_table', 1),
(24, '2023_11_22_162126_create_clients_companies_rates_table', 1),
(25, '2023_11_22_162713_create_clients_password_resets_table', 1),
(26, '2023_11_22_163625_create_client_drivers_rates_table', 1),
(27, '2023_11_22_163900_create_client_general_offer_orders_table', 1),
(28, '2023_11_22_164605_create_client_locations_table', 1),
(29, '2023_11_22_175105_create_companies_categories_table', 1),
(30, '2023_11_22_175238_create_companies_deliver_to_cities_table', 1),
(31, '2023_11_22_175507_create_companies_working_with_drivers_managers_table', 1),
(32, '2023_11_22_175622_create_cooperation_with_us_reasons_table', 1),
(33, '2023_11_22_180029_create_delivery_types_table', 1),
(34, '2023_11_22_191200_create_drivers_app_orders_table', 1),
(35, '2023_11_22_192507_create_driver_locations_table', 1),
(36, '2023_11_22_201459_create_driver_location_stop_points_table', 1),
(37, '2023_11_22_201847_create_products_table', 1),
(38, '2023_11_22_201850_create_easy_orders_table', 1),
(39, '2023_11_22_202419_create_product_options_table', 1),
(40, '2023_11_22_202906_create_frequently_asked_questions_table', 1),
(41, '2023_11_22_203022_create_general_offers_table', 1),
(42, '2023_11_22_203438_create_home_page_content_table', 1),
(43, '2023_11_22_203627_create_home_slider_images_table', 1),
(44, '2023_11_22_204544_create_nav_bar_footer_content_table', 1),
(45, '2023_11_22_205117_create_notifications_table', 1),
(46, '2023_11_22_205758_create_offers_page_content_table', 1),
(47, '2023_11_22_211428_create_orders_have_base_orders_rates_table', 1),
(48, '2023_11_22_211633_create_order_comments_table', 1),
(49, '2023_11_22_212008_create_order_items_table', 1),
(50, '2023_11_22_212228_create_order_locations_table', 1),
(51, '2023_11_22_212411_create_order_location_stop_points_table', 1),
(52, '2023_11_22_212552_create_order_steps_table', 1),
(53, '2023_11_23_151635_create_payment_methods_table', 1),
(54, '2023_11_23_153911_create_promo_codes_table', 1),
(55, '2023_11_23_155919_create_promo_codes_companies_table', 1),
(56, '2023_11_23_160035_create_promo_codes_countries_table', 1),
(57, '2023_11_23_160121_create_promo_codes_products_table', 1),
(58, '2023_11_23_160158_create_promo_code_offers_table', 1),
(59, '2023_11_23_160411_create_settings_table', 1),
(60, '2023_11_23_160718_create_slider_offers_table', 1),
(61, '2023_11_23_161038_create_social_links_table', 1),
(62, '2023_11_23_161256_create_statistics_tags_table', 1),
(63, '2023_11_23_161545_create_suggestion_box_table', 1),
(64, '2023_11_23_161630_create_system_products_table', 1),
(65, '2023_11_23_162337_create_system_product_options_table', 1),
(66, '2023_11_23_162500_create_terms_and_conditions_table', 1),
(67, '2023_11_23_163052_create_users_password_resets_table', 1),
(68, '2023_11_23_163158_create_user_device_tokens_table', 1),
(69, '2023_11_23_163311_create_wallet_credit_offers_table', 1),
(70, '2023_11_23_163618_create_wallet_history_table', 1),
(71, '2023_11_23_175313_create_client_orders_table', 1),
(72, '2023_11_24_203719_create_invoices_table', 1),
(73, '2023_11_24_204406_create_invoice_items_table', 1),
(74, '2023_11_26_175307_add_invoice_id_column_to_client_orders_table', 1),
(75, '2023_11_27_135149_add_general_offer_id_column_to_client_general_offer_orders_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nav_bar_footer_content`
--

CREATE TABLE `nav_bar_footer_content` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `whatsapp_number` varchar(20) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `facebook_link` varchar(100) NOT NULL,
  `instagram_link` varchar(100) NOT NULL,
  `twitter_link` varchar(100) NOT NULL,
  `footer_title_ar` varchar(100) NOT NULL,
  `footer_title_en` varchar(100) NOT NULL,
  `footer_content_ar` varchar(200) NOT NULL,
  `footer_content_en` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title_ar` varchar(50) NOT NULL,
  `title_en` varchar(50) NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `body_ar` varchar(150) NOT NULL,
  `body_en` varchar(150) NOT NULL,
  `action` enum('order_moved','order_created','order_canceled') NOT NULL,
  `action_data` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers_page_content`
--

CREATE TABLE `offers_page_content` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_ar` varchar(200) NOT NULL,
  `title_en` varchar(200) NOT NULL,
  `second_title_ar` varchar(150) NOT NULL,
  `second_title_en` varchar(150) NOT NULL,
  `logo_path` varchar(100) NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `google_play_link` varchar(100) NOT NULL,
  `app_store_link` varchar(100) NOT NULL,
  `content_ar` varchar(500) NOT NULL,
  `content_en` varchar(500) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('in_cart','in_waiting_list','confirmed','in_picking','picked_up','in_processing','processing_done','in_delivery','delivered','done') NOT NULL,
  `special_instructions` varchar(500) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `pickup_driver_id` int(10) UNSIGNED DEFAULT NULL,
  `delivery_driver_id` int(10) UNSIGNED DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `location_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_have_base_orders_rates`
--

CREATE TABLE `orders_have_base_orders_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `base_order_rate_id` bigint(20) UNSIGNED NOT NULL,
  `value` enum('1','2','3','4','5') NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_comments`
--

CREATE TABLE `order_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(500) NOT NULL,
  `show_for_client` enum('yes','no') NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_options_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` varchar(10) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_locations`
--

CREATE TABLE `order_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` bigint(20) UNSIGNED NOT NULL,
  `lat` decimal(10,8) NOT NULL,
  `long` decimal(10,8) NOT NULL,
  `status` enum('in_delivery','in_pickup') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_location_stop_points`
--

CREATE TABLE `order_location_stop_points` (
  `order_location_id` bigint(20) UNSIGNED NOT NULL,
  `to_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reason` enum('traffic','not_traffic') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_steps`
--

CREATE TABLE `order_steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_ar` varchar(100) NOT NULL,
  `title_en` varchar(100) NOT NULL,
  `description_ar` varchar(500) NOT NULL,
  `description_en` varchar(500) NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_ar` varchar(50) NOT NULL,
  `title_en` varchar(50) NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name_ar`, `name_en`, `img_path`, `active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 5, 'منتج 2', 'company product1', 'images/products/1721325498967.png', 1, '2024-07-18 19:02:25', '2024-07-18 18:58:18', '2024-07-18 19:02:25'),
(2, 5, 'منتج 1', 'company product', 'images/products/1721325764542.png', 1, NULL, '2024-07-18 19:02:44', '2024-07-18 19:02:44');

-- --------------------------------------------------------

--
-- Table structure for table `product_options`
--

CREATE TABLE `product_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `price_unit_ar` varchar(50) NOT NULL,
  `price_unit_en` varchar(50) NOT NULL,
  `price` double(8,2) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_options`
--

INSERT INTO `product_options` (`id`, `product_id`, `name_ar`, `name_en`, `price_unit_ar`, `price_unit_en`, `price`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'test', 'test', 'test', 'test', 1.00, '2024-07-18 18:59:30', '2024-07-18 18:58:18', '2024-07-18 18:59:30'),
(2, 1, 'test1', 'test1', 'test1', 'test1', 11.00, '2024-07-18 19:02:25', '2024-07-18 18:59:30', '2024-07-18 19:02:25'),
(3, 2, 'test', 'test', 'test', 'test', 1.00, NULL, '2024-07-18 19:02:44', '2024-07-18 19:02:44');

-- --------------------------------------------------------

--
-- Table structure for table `promo_codes`
--

CREATE TABLE `promo_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `value` decimal(5,2) NOT NULL,
  `value_type` enum('percentage','constant') NOT NULL,
  `type` enum('countries','companies','products') NOT NULL,
  `from` datetime NOT NULL,
  `to` datetime NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promo_codes_companies`
--

CREATE TABLE `promo_codes_companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promo_code_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promo_codes_countries`
--

CREATE TABLE `promo_codes_countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promo_code_id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promo_codes_products`
--

CREATE TABLE `promo_codes_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promo_code_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promo_code_offers`
--

CREATE TABLE `promo_code_offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promo_code_id` bigint(20) UNSIGNED NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_order_cash_back_value` double NOT NULL,
  `first_order_cash_back_value_type` enum('percentage','constant') NOT NULL,
  `invitation_code_owner_cash_value` double NOT NULL,
  `invitation_code_owner_cash_value_type` enum('percentage','constant') NOT NULL,
  `invitation_code_user_cash_value` double NOT NULL,
  `invitation_code_user_cash_value_type` enum('percentage','constant') NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slider_offers`
--

CREATE TABLE `slider_offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `link` varchar(200) NOT NULL,
  `from` datetime NOT NULL,
  `to` datetime NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statistics_tags`
--

CREATE TABLE `statistics_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_ar` varchar(100) NOT NULL,
  `title_en` varchar(100) NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `percentage` double NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suggestion_box`
--

CREATE TABLE `suggestion_box` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(500) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_products`
--

CREATE TABLE `system_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_product_options`
--

CREATE TABLE `system_product_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `system_product_id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms_and_conditions`
--

CREATE TABLE `terms_and_conditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_ar` varchar(200) NOT NULL,
  `title_en` varchar(200) NOT NULL,
  `description_ar` text NOT NULL,
  `description_en` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transportation_periods`
--

CREATE TABLE `transportation_periods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `from` time NOT NULL,
  `to` time NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transportation_periods_assigned_to_drivers`
--

CREATE TABLE `transportation_periods_assigned_to_drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` bigint(20) UNSIGNED NOT NULL,
  `transportation_period_id` bigint(20) UNSIGNED NOT NULL,
  `capacity` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','country_manager','company','drivers_manager','driver') NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `active`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.com', NULL, '$2y$10$dTL0MwiD7O5oeGpKGa0.GOUt2G.qY4H3eqsMpXp.wZRHTWQmJ1lu.', 'admin', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_password_resets`
--

CREATE TABLE `users_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_device_tokens`
--

CREATE TABLE `user_device_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `device_token` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_credit_offers`
--

CREATE TABLE `wallet_credit_offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(100) NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `description_ar` varchar(200) NOT NULL,
  `description_en` varchar(200) NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `value` tinyint(1) NOT NULL,
  `value_type` enum('constant','percentage') NOT NULL,
  `min_amount` double NOT NULL,
  `max_amount` double NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_history`
--

CREATE TABLE `wallet_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us_content`
--
ALTER TABLE `about_us_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `base_companies_rates`
--
ALTER TABLE `base_companies_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `base_drivers_rates`
--
ALTER TABLE `base_drivers_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `base_orders_rates`
--
ALTER TABLE `base_orders_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories_countries`
--
ALTER TABLE `categories_countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_countries_category_id_foreign` (`category_id`),
  ADD KEY `categories_countries_country_id_foreign` (`country_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_governorate_id_foreign` (`governorate_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_email_unique` (`email`);

--
-- Indexes for table `clients_companies_rates`
--
ALTER TABLE `clients_companies_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_companies_rates_client_id_foreign` (`client_id`),
  ADD KEY `clients_companies_rates_company_id_foreign` (`company_id`),
  ADD KEY `clients_companies_rates_base_companies_rate_id_foreign` (`base_companies_rate_id`);

--
-- Indexes for table `clients_password_resets`
--
ALTER TABLE `clients_password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_password_resets_client_id_foreign` (`client_id`);

--
-- Indexes for table `client_drivers_rates`
--
ALTER TABLE `client_drivers_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_drivers_rates_client_id_foreign` (`client_id`),
  ADD KEY `client_drivers_rates_company_id_foreign` (`company_id`),
  ADD KEY `client_drivers_rates_base_companies_rate_id_foreign` (`base_companies_rate_id`);

--
-- Indexes for table `client_general_offer_orders`
--
ALTER TABLE `client_general_offer_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_general_offer_orders_client_id_foreign` (`client_id`),
  ADD KEY `client_general_offer_orders_general_offer_id_foreign` (`general_offer_id`),
  ADD KEY `client_general_offer_orders_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `client_locations`
--
ALTER TABLE `client_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_locations_client_id_foreign` (`client_id`);

--
-- Indexes for table `client_orders`
--
ALTER TABLE `client_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_orders_client_id_foreign` (`client_id`),
  ADD KEY `client_orders_company_id_foreign` (`company_id`),
  ADD KEY `client_orders_delivery_type_id_foreign` (`delivery_type_id`),
  ADD KEY `client_orders_promo_code_id_foreign` (`promo_code_id`),
  ADD KEY `client_orders_client_location_id_foreign` (`client_location_id`),
  ADD KEY `client_orders_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD KEY `companies_user_id_foreign` (`user_id`),
  ADD KEY `companies_country_id_foreign` (`country_id`);

--
-- Indexes for table `companies_categories`
--
ALTER TABLE `companies_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_categories_company_id_foreign` (`company_id`),
  ADD KEY `companies_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `companies_deliver_to_cities`
--
ALTER TABLE `companies_deliver_to_cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_deliver_to_cities_company_id_foreign` (`company_id`),
  ADD KEY `companies_deliver_to_cities_city_id_foreign` (`city_id`);

--
-- Indexes for table `companies_working_with_drivers_managers`
--
ALTER TABLE `companies_working_with_drivers_managers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cooperation_with_us_reasons`
--
ALTER TABLE `cooperation_with_us_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country_managers`
--
ALTER TABLE `country_managers`
  ADD KEY `country_managers_user_id_foreign` (`user_id`),
  ADD KEY `country_managers_country_id_foreign` (`country_id`);

--
-- Indexes for table `delivery_types`
--
ALTER TABLE `delivery_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD KEY `drivers_user_id_foreign` (`user_id`),
  ADD KEY `drivers_manager_id_foreign` (`manager_id`);

--
-- Indexes for table `drivers_app_clients`
--
ALTER TABLE `drivers_app_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `drivers_app_clients_user_id_foreign` (`user_id`);

--
-- Indexes for table `drivers_app_orders`
--
ALTER TABLE `drivers_app_orders`
  ADD KEY `drivers_app_orders_order_id_foreign` (`order_id`),
  ADD KEY `drivers_app_orders_user_id_foreign` (`user_id`),
  ADD KEY `drivers_app_orders_drivers_app_client_id_foreign` (`drivers_app_client_id`);

--
-- Indexes for table `drivers_app_products`
--
ALTER TABLE `drivers_app_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `drivers_app_products_user_id_foreign` (`user_id`);

--
-- Indexes for table `drivers_app_product_options`
--
ALTER TABLE `drivers_app_product_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `drivers_app_product_options_drivers_app_product_id_foreign` (`drivers_app_product_id`);

--
-- Indexes for table `drivers_managers`
--
ALTER TABLE `drivers_managers`
  ADD KEY `drivers_managers_user_id_foreign` (`user_id`),
  ADD KEY `drivers_managers_country_id_foreign` (`country_id`);

--
-- Indexes for table `driver_locations`
--
ALTER TABLE `driver_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_locations_driver_id_foreign` (`driver_id`);

--
-- Indexes for table `driver_location_stop_points`
--
ALTER TABLE `driver_location_stop_points`
  ADD KEY `driver_location_stop_points_driver_location_id_foreign` (`driver_location_id`);

--
-- Indexes for table `easy_orders`
--
ALTER TABLE `easy_orders`
  ADD KEY `easy_orders_order_id_foreign` (`order_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `frequently_asked_questions`
--
ALTER TABLE `frequently_asked_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_offers`
--
ALTER TABLE `general_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `governorates`
--
ALTER TABLE `governorates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `governorates_country_id_foreign` (`country_id`);

--
-- Indexes for table `home_page_content`
--
ALTER TABLE `home_page_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_slider_images`
--
ALTER TABLE `home_slider_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_client_id_foreign` (`client_id`),
  ADD KEY `invoices_client_order_id_foreign` (`client_order_id`),
  ADD KEY `invoices_drivers_app_order_id_foreign` (`drivers_app_order_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nav_bar_footer_content`
--
ALTER TABLE `nav_bar_footer_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`),
  ADD KEY `notifications_order_id_foreign` (`order_id`);

--
-- Indexes for table `offers_page_content`
--
ALTER TABLE `offers_page_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_have_base_orders_rates`
--
ALTER TABLE `orders_have_base_orders_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_have_base_orders_rates_order_id_foreign` (`order_id`),
  ADD KEY `orders_have_base_orders_rates_base_order_rate_id_foreign` (`base_order_rate_id`);

--
-- Indexes for table `order_comments`
--
ALTER TABLE `order_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_comments_order_id_foreign` (`order_id`),
  ADD KEY `order_comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_options_id_foreign` (`product_options_id`);

--
-- Indexes for table `order_locations`
--
ALTER TABLE `order_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_locations_order_id_foreign` (`order_id`),
  ADD KEY `order_locations_driver_id_foreign` (`driver_id`);

--
-- Indexes for table `order_location_stop_points`
--
ALTER TABLE `order_location_stop_points`
  ADD KEY `order_location_stop_points_order_location_id_foreign` (`order_location_id`);

--
-- Indexes for table `order_steps`
--
ALTER TABLE `order_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_options`
--
ALTER TABLE `product_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_options_product_id_foreign` (`product_id`);

--
-- Indexes for table `promo_codes`
--
ALTER TABLE `promo_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promo_codes_code_unique` (`code`);

--
-- Indexes for table `promo_codes_companies`
--
ALTER TABLE `promo_codes_companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promo_codes_companies_promo_code_id_foreign` (`promo_code_id`),
  ADD KEY `promo_codes_companies_order_id_foreign` (`order_id`);

--
-- Indexes for table `promo_codes_countries`
--
ALTER TABLE `promo_codes_countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promo_codes_countries_promo_code_id_foreign` (`promo_code_id`),
  ADD KEY `promo_codes_countries_country_id_foreign` (`country_id`);

--
-- Indexes for table `promo_codes_products`
--
ALTER TABLE `promo_codes_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promo_codes_products_promo_code_id_foreign` (`promo_code_id`),
  ADD KEY `promo_codes_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `promo_code_offers`
--
ALTER TABLE `promo_code_offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promo_code_offers_promo_code_id_foreign` (`promo_code_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider_offers`
--
ALTER TABLE `slider_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statistics_tags`
--
ALTER TABLE `statistics_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suggestion_box`
--
ALTER TABLE `suggestion_box`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_products`
--
ALTER TABLE `system_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_products_category_id_foreign` (`category_id`);

--
-- Indexes for table `system_product_options`
--
ALTER TABLE `system_product_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_product_options_system_product_id_foreign` (`system_product_id`);

--
-- Indexes for table `terms_and_conditions`
--
ALTER TABLE `terms_and_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transportation_periods`
--
ALTER TABLE `transportation_periods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transportation_periods_user_id_foreign` (`user_id`);

--
-- Indexes for table `transportation_periods_assigned_to_drivers`
--
ALTER TABLE `transportation_periods_assigned_to_drivers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transportation_periods_assigned_to_drivers_driver_id_foreign` (`driver_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_password_resets`
--
ALTER TABLE `users_password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_password_resets_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_device_tokens`
--
ALTER TABLE `user_device_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_device_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `wallet_credit_offers`
--
ALTER TABLE `wallet_credit_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet_history`
--
ALTER TABLE `wallet_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_history_client_id_foreign` (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us_content`
--
ALTER TABLE `about_us_content`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `base_companies_rates`
--
ALTER TABLE `base_companies_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `base_drivers_rates`
--
ALTER TABLE `base_drivers_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `base_orders_rates`
--
ALTER TABLE `base_orders_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories_countries`
--
ALTER TABLE `categories_countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clients_companies_rates`
--
ALTER TABLE `clients_companies_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients_password_resets`
--
ALTER TABLE `clients_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_drivers_rates`
--
ALTER TABLE `client_drivers_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_general_offer_orders`
--
ALTER TABLE `client_general_offer_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_locations`
--
ALTER TABLE `client_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client_orders`
--
ALTER TABLE `client_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies_categories`
--
ALTER TABLE `companies_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies_deliver_to_cities`
--
ALTER TABLE `companies_deliver_to_cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies_working_with_drivers_managers`
--
ALTER TABLE `companies_working_with_drivers_managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cooperation_with_us_reasons`
--
ALTER TABLE `cooperation_with_us_reasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_types`
--
ALTER TABLE `delivery_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drivers_app_clients`
--
ALTER TABLE `drivers_app_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drivers_app_products`
--
ALTER TABLE `drivers_app_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drivers_app_product_options`
--
ALTER TABLE `drivers_app_product_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver_locations`
--
ALTER TABLE `driver_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frequently_asked_questions`
--
ALTER TABLE `frequently_asked_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_offers`
--
ALTER TABLE `general_offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `governorates`
--
ALTER TABLE `governorates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_page_content`
--
ALTER TABLE `home_page_content`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_slider_images`
--
ALTER TABLE `home_slider_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `nav_bar_footer_content`
--
ALTER TABLE `nav_bar_footer_content`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offers_page_content`
--
ALTER TABLE `offers_page_content`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders_have_base_orders_rates`
--
ALTER TABLE `orders_have_base_orders_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_comments`
--
ALTER TABLE `order_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_locations`
--
ALTER TABLE `order_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_steps`
--
ALTER TABLE `order_steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_options`
--
ALTER TABLE `product_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `promo_codes`
--
ALTER TABLE `promo_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promo_codes_companies`
--
ALTER TABLE `promo_codes_companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promo_codes_countries`
--
ALTER TABLE `promo_codes_countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promo_codes_products`
--
ALTER TABLE `promo_codes_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promo_code_offers`
--
ALTER TABLE `promo_code_offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slider_offers`
--
ALTER TABLE `slider_offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statistics_tags`
--
ALTER TABLE `statistics_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suggestion_box`
--
ALTER TABLE `suggestion_box`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_products`
--
ALTER TABLE `system_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_product_options`
--
ALTER TABLE `system_product_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms_and_conditions`
--
ALTER TABLE `terms_and_conditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transportation_periods`
--
ALTER TABLE `transportation_periods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transportation_periods_assigned_to_drivers`
--
ALTER TABLE `transportation_periods_assigned_to_drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_password_resets`
--
ALTER TABLE `users_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_device_tokens`
--
ALTER TABLE `user_device_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_credit_offers`
--
ALTER TABLE `wallet_credit_offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_history`
--
ALTER TABLE `wallet_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories_countries`
--
ALTER TABLE `categories_countries`
  ADD CONSTRAINT `categories_countries_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categories_countries_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_governorate_id_foreign` FOREIGN KEY (`governorate_id`) REFERENCES `governorates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `clients_companies_rates`
--
ALTER TABLE `clients_companies_rates`
  ADD CONSTRAINT `clients_companies_rates_base_companies_rate_id_foreign` FOREIGN KEY (`base_companies_rate_id`) REFERENCES `base_companies_rates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clients_companies_rates_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clients_companies_rates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `clients_password_resets`
--
ALTER TABLE `clients_password_resets`
  ADD CONSTRAINT `clients_password_resets_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_drivers_rates`
--
ALTER TABLE `client_drivers_rates`
  ADD CONSTRAINT `client_drivers_rates_base_companies_rate_id_foreign` FOREIGN KEY (`base_companies_rate_id`) REFERENCES `base_companies_rates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_drivers_rates_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_drivers_rates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_general_offer_orders`
--
ALTER TABLE `client_general_offer_orders`
  ADD CONSTRAINT `client_general_offer_orders_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_general_offer_orders_general_offer_id_foreign` FOREIGN KEY (`general_offer_id`) REFERENCES `general_offers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_general_offer_orders_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_locations`
--
ALTER TABLE `client_locations`
  ADD CONSTRAINT `client_locations_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_orders`
--
ALTER TABLE `client_orders`
  ADD CONSTRAINT `client_orders_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_orders_client_location_id_foreign` FOREIGN KEY (`client_location_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_orders_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_orders_delivery_type_id_foreign` FOREIGN KEY (`delivery_type_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_orders_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_orders_promo_code_id_foreign` FOREIGN KEY (`promo_code_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `companies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `companies_categories`
--
ALTER TABLE `companies_categories`
  ADD CONSTRAINT `companies_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `companies_categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `companies_deliver_to_cities`
--
ALTER TABLE `companies_deliver_to_cities`
  ADD CONSTRAINT `companies_deliver_to_cities_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `companies_deliver_to_cities_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `country_managers`
--
ALTER TABLE `country_managers`
  ADD CONSTRAINT `country_managers_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `country_managers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `drivers_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `drivers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `drivers_app_clients`
--
ALTER TABLE `drivers_app_clients`
  ADD CONSTRAINT `drivers_app_clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `drivers_app_orders`
--
ALTER TABLE `drivers_app_orders`
  ADD CONSTRAINT `drivers_app_orders_drivers_app_client_id_foreign` FOREIGN KEY (`drivers_app_client_id`) REFERENCES `drivers_app_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `drivers_app_orders_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `drivers_app_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `drivers_app_products`
--
ALTER TABLE `drivers_app_products`
  ADD CONSTRAINT `drivers_app_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `drivers_app_product_options`
--
ALTER TABLE `drivers_app_product_options`
  ADD CONSTRAINT `drivers_app_product_options_drivers_app_product_id_foreign` FOREIGN KEY (`drivers_app_product_id`) REFERENCES `drivers_app_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `drivers_managers`
--
ALTER TABLE `drivers_managers`
  ADD CONSTRAINT `drivers_managers_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `drivers_managers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `driver_locations`
--
ALTER TABLE `driver_locations`
  ADD CONSTRAINT `driver_locations_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `driver_location_stop_points`
--
ALTER TABLE `driver_location_stop_points`
  ADD CONSTRAINT `driver_location_stop_points_driver_location_id_foreign` FOREIGN KEY (`driver_location_id`) REFERENCES `driver_locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `easy_orders`
--
ALTER TABLE `easy_orders`
  ADD CONSTRAINT `easy_orders_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `governorates`
--
ALTER TABLE `governorates`
  ADD CONSTRAINT `governorates_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_client_order_id_foreign` FOREIGN KEY (`client_order_id`) REFERENCES `client_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_drivers_app_order_id_foreign` FOREIGN KEY (`drivers_app_order_id`) REFERENCES `drivers_app_orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_have_base_orders_rates`
--
ALTER TABLE `orders_have_base_orders_rates`
  ADD CONSTRAINT `orders_have_base_orders_rates_base_order_rate_id_foreign` FOREIGN KEY (`base_order_rate_id`) REFERENCES `base_orders_rates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_have_base_orders_rates_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_comments`
--
ALTER TABLE `order_comments`
  ADD CONSTRAINT `order_comments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_product_options_id_foreign` FOREIGN KEY (`product_options_id`) REFERENCES `product_options` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_locations`
--
ALTER TABLE `order_locations`
  ADD CONSTRAINT `order_locations_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_locations_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_location_stop_points`
--
ALTER TABLE `order_location_stop_points`
  ADD CONSTRAINT `order_location_stop_points_order_location_id_foreign` FOREIGN KEY (`order_location_id`) REFERENCES `order_locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_options`
--
ALTER TABLE `product_options`
  ADD CONSTRAINT `product_options_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `promo_codes_companies`
--
ALTER TABLE `promo_codes_companies`
  ADD CONSTRAINT `promo_codes_companies_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `promo_codes_companies_promo_code_id_foreign` FOREIGN KEY (`promo_code_id`) REFERENCES `promo_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `promo_codes_countries`
--
ALTER TABLE `promo_codes_countries`
  ADD CONSTRAINT `promo_codes_countries_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `promo_codes_countries_promo_code_id_foreign` FOREIGN KEY (`promo_code_id`) REFERENCES `promo_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `promo_codes_products`
--
ALTER TABLE `promo_codes_products`
  ADD CONSTRAINT `promo_codes_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `promo_codes_products_promo_code_id_foreign` FOREIGN KEY (`promo_code_id`) REFERENCES `promo_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `promo_code_offers`
--
ALTER TABLE `promo_code_offers`
  ADD CONSTRAINT `promo_code_offers_promo_code_id_foreign` FOREIGN KEY (`promo_code_id`) REFERENCES `promo_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `system_products`
--
ALTER TABLE `system_products`
  ADD CONSTRAINT `system_products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `system_product_options`
--
ALTER TABLE `system_product_options`
  ADD CONSTRAINT `system_product_options_system_product_id_foreign` FOREIGN KEY (`system_product_id`) REFERENCES `system_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transportation_periods`
--
ALTER TABLE `transportation_periods`
  ADD CONSTRAINT `transportation_periods_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transportation_periods_assigned_to_drivers`
--
ALTER TABLE `transportation_periods_assigned_to_drivers`
  ADD CONSTRAINT `transportation_periods_assigned_to_drivers_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_password_resets`
--
ALTER TABLE `users_password_resets`
  ADD CONSTRAINT `users_password_resets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_device_tokens`
--
ALTER TABLE `user_device_tokens`
  ADD CONSTRAINT `user_device_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wallet_history`
--
ALTER TABLE `wallet_history`
  ADD CONSTRAINT `wallet_history_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
