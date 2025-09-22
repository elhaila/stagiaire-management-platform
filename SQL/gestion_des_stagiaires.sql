-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2025 at 10:55 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestion_des_stagiaires`
--

-- --------------------------------------------------------

--
-- Table structure for table `absences`
--

CREATE TABLE `absences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `internship_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'unjustified',
  `justification` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absences`
--

INSERT INTO `absences` (`id`, `internship_id`, `date`, `reason`, `status`, `justification`, `created_at`, `updated_at`) VALUES
(2, 2, '2025-09-15', NULL, 'unjustified', NULL, NULL, NULL),
(3, 2, '2025-09-16', 'test', 'justified', 'justifications/test10_absence_2025_09_16_084429.pdf', '2025-09-16 07:44:29', '2025-09-16 07:44:29'),
(4, 3, '2025-09-16', 'hbshd vhsd v sdhbhsd sdhbvhdsb v sdvbshbh vhbvh dvsdh vhd vd vzdhv dshvsdh ds  jhsbhb dsh ds hf sd vhsdbsd dsh fhsd hjsd hf  d', 'justified', 'justifications/aicha_mansouri_absence_2025_09_16_090251.pdf', '2025-09-16 08:02:51', '2025-09-16 08:02:51');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demandes`
--

CREATE TABLE `demandes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `person_id` bigint(20) UNSIGNED NOT NULL,
  `university_id` bigint(20) UNSIGNED NOT NULL,
  `diplome_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `demandes`
--

INSERT INTO `demandes` (`id`, `person_id`, `university_id`, `diplome_id`, `type`, `cv`, `start_date`, `end_date`, `status`, `description`, `created_at`, `updated_at`) VALUES
(21, 1, 1, 1, 'PFE', '', '2025-06-01', '2026-02-18', 'rejected', NULL, '2025-08-06 09:03:17', '2025-09-12 13:32:10'),
(22, 2, 2, 2, 'Stage', '', '2025-07-01', '2025-08-01', 'expired', 'Summer observation stage', '2025-08-04 09:03:29', '2025-09-11 09:46:43'),
(23, 3, 3, 3, 'Technique', '', '2025-05-15', '2025-06-15', 'expired', 'Technical internship application', '2025-08-04 09:03:29', '2025-09-11 09:46:43'),
(24, 4, 4, 4, 'PFE', '', '2025-06-10', '2025-09-10', 'expired', 'Second semester internship', '2025-08-04 09:03:29', '2025-09-11 09:46:43'),
(25, 5, 5, 5, 'Stage', '', '2025-07-05', '2025-08-05', 'expired', 'Short-term observation', '2025-08-04 09:03:29', '2025-09-11 09:46:43'),
(26, 6, 1, 6, 'Technique', '', '2025-05-20', '2025-06-20', 'expired', 'Technical project request', '2025-08-04 09:03:29', '2025-09-11 09:46:43'),
(27, 7, 2, 7, 'PFE', 'cvs/aicha_jabari_cv1757924546.pdf', '2025-09-16', '2025-11-20', 'accepted', NULL, '2025-08-04 09:03:29', '2025-09-17 07:24:08'),
(28, 8, 3, 8, 'Stage', '', '2025-07-10', '2025-08-10', 'expired', 'Observation internship', '2025-08-04 09:03:29', '2025-09-11 09:46:43'),
(29, 9, 4, 9, 'Technique', '', '2025-05-25', '2025-06-25', 'expired', 'Technical assignment', '2025-08-04 09:03:29', '2025-09-11 09:46:43'),
(30, 10, 5, 10, 'PFE', '', '2025-06-20', '2025-09-20', 'expired', 'PFE request', '2025-08-04 09:03:29', '2025-09-22 07:26:52'),
(31, 11, 1, 2, 'Stage', '', '2025-07-15', '2025-08-15', 'expired', 'Summer observation', '2025-08-04 09:03:29', '2025-09-11 09:51:14'),
(32, 12, 2, 3, 'Technique', '', '2025-05-30', '2025-06-30', 'expired', 'Technical internship', '2025-08-04 09:03:29', '2025-09-11 09:51:14'),
(33, 13, 3, 4, 'PFE', '', '2025-06-25', '2025-09-25', 'pending', 'Final project application', NULL, NULL),
(34, 14, 4, 5, 'Stage', '', '2025-07-20', '2025-08-20', 'expired', 'Observation internship', NULL, '2025-09-11 09:51:14'),
(35, 15, 5, 6, 'Technique', '', '2025-06-05', '2025-07-05', 'expired', 'Technical stage request', NULL, '2025-09-11 09:51:14'),
(36, 16, 1, 7, 'PFE', '', '2025-06-30', '2025-09-30', 'rejected', 'End-of-year project', NULL, '2025-09-16 08:19:04'),
(37, 17, 2, 8, 'Stage', 'cvs/aicha_mansouri_cv1758098448.pdf', '2025-07-25', '2025-12-24', 'rejected', NULL, NULL, '2025-09-19 07:18:41'),
(38, 18, 3, 9, 'Technique', '', '2025-06-10', '2025-07-10', 'expired', 'Technical assignment', NULL, '2025-09-11 09:51:14'),
(39, 19, 4, 10, 'PFE', '', '2025-07-01', '2025-10-01', 'rejected', 'PFE internship', NULL, '2025-09-16 08:18:47'),
(40, 20, 5, 1, 'Stage', '', '2025-07-05', '2025-08-05', 'expired', 'Observation internship request', NULL, '2025-09-11 09:51:14'),
(41, 4, 4, 3, 'PFE', 'cvs/khalid_chakib_cv.pdf', '2025-09-12', '2025-11-27', 'pending', NULL, '2025-09-11 08:59:04', '2025-09-11 08:59:04'),
(42, 1, 1, 3, 'Stage', 'cvs/hamza_el_amrani_cv1757685175.pdf', '2025-09-12', '2025-10-31', 'accepted', NULL, '2025-09-11 09:23:43', '2025-09-16 08:15:38'),
(43, 17, 3, 1, 'PFE', 'cvs/aicha_mansouri_cv.pdf', '2025-09-12', '2026-08-20', 'accepted', NULL, '2025-09-11 09:46:43', '2025-09-16 08:00:01'),
(44, 5, 3, 2, 'PFE', 'cvs/omar_el_ghazali_cv_1757684636.pdf', '2025-09-13', '2025-11-13', 'rejected', 'test edit', '2025-09-11 10:16:02', '2025-09-12 14:10:15'),
(45, 5, 3, 1, 'PFE', 'cvs/omar_el_ghazali_cv1757692245.pdf', '2025-09-13', '2025-12-18', 'rejected', NULL, '2025-09-12 14:45:09', '2025-09-12 14:55:07'),
(46, 35, 1, 1, 'PFE', 'cvs/test10_cv.pdf', '2025-09-15', '2025-11-19', 'accepted', NULL, '2025-09-14 13:22:58', '2025-09-14 19:27:20'),
(47, 10, 2, 3, 'PFE', 'cvs/khadija_zouari_cv.pdf', '2025-09-18', '2025-12-29', 'pending', NULL, '2025-09-17 07:37:29', '2025-09-17 07:37:29'),
(48, 5, 3, 9, 'Stage', 'cvs/omar_el_ghazali_cv.pdf', '2025-09-18', '2026-02-19', 'pending', 'test', '2025-09-17 07:45:51', '2025-09-17 07:45:51'),
(49, 20, 5, 3, 'PFE', 'cvs/khadija_hassani_cv.pdf', '2025-09-20', '2025-12-24', 'rejected', NULL, '2025-09-19 07:12:46', '2025-09-19 13:41:13');

-- --------------------------------------------------------

--
-- Table structure for table `diplomes`
--

CREATE TABLE `diplomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diplomes`
--

INSERT INTO `diplomes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'development Informatique', NULL, '2025-09-17 14:17:39'),
(2, 'Gestion', NULL, NULL),
(3, 'Marketing', NULL, NULL),
(4, 'Droit', NULL, '2025-09-17 14:26:18'),
(5, 'Finance', NULL, NULL),
(6, 'Génie Civil', NULL, NULL),
(7, 'Biologie', NULL, NULL),
(8, 'Chimie', NULL, NULL),
(9, 'Physique', NULL, NULL),
(10, 'Economie', NULL, NULL),
(11, 'test', '2025-09-11 13:00:53', '2025-09-11 13:00:53');

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
-- Table structure for table `internships`
--

CREATE TABLE `internships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `demand_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `date_fiche_fin_stage` date DEFAULT NULL,
  `date_depot_rapport_stage` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `internships`
--

INSERT INTO `internships` (`id`, `demand_id`, `user_id`, `start_date`, `end_date`, `status`, `date_fiche_fin_stage`, `date_depot_rapport_stage`, `created_at`, `updated_at`) VALUES
(2, 46, 1, '2025-09-01', '2025-09-15', 'finished', NULL, NULL, '2025-09-14 19:27:20', '2025-09-16 10:39:41'),
(3, 43, 1, '2025-09-16', '2025-12-26', 'active', NULL, NULL, '2025-09-16 08:00:01', '2025-09-16 08:02:00'),
(4, 42, 1, '2025-06-10', '2025-09-15', 'terminated', '2025-09-16', '2025-09-16', '2025-09-16 08:15:38', '2025-09-16 08:45:36'),
(5, 27, 1, '2025-09-18', '2025-10-30', 'active', NULL, NULL, '2025-09-17 07:24:08', '2025-09-18 07:19:13');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_04_142301_create_people_table', 1),
(5, '2025_09_04_142446_create_university_table', 1),
(6, '2025_09_04_142629_create_diplomes_table', 1),
(7, '2025_09_04_142853_create_demandes_table', 1),
(8, '2025_09_04_143340_create_internships_table', 1),
(9, '2025_09_04_143905_create_absences_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `cin` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `fullname`, `cin`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Hamza Amrani', 'AA12345', 'hamza.elamrani@example.com', '0600000001', '2025-09-18 09:48:46', '2025-09-14 15:35:46'),
(2, 'Youssef Bennani', 'BB23456', 'youssef.bennani@example.com', '0600000002', '2025-09-16 13:47:13', '2025-09-16 13:47:21'),
(3, 'Mohamed Belaid', 'CC34567', 'mohamed.belaid@example.com', '0600000003', '2025-09-16 13:47:24', '2025-09-16 13:47:26'),
(4, 'Khalid Chakib', 'DD45678', 'khalid.chakib@example.com', '0600000004', '2025-09-16 13:47:28', '2025-09-16 13:47:30'),
(5, 'Omar El Ghazali', 'EE56789', 'omar.elghazali@example.com', '0600000005', '2025-09-16 13:47:32', '2025-09-16 13:47:34'),
(6, 'Fatima Hassani', 'FF67890', 'fatima.hassani@example.com', '0600000006', '2025-09-16 13:47:36', '2025-09-16 13:47:38'),
(7, 'Aicha el Jabari', 'GG78901', 'aicha.jabari@example.com', '0600000007', '2025-09-11 09:42:10', '2025-09-19 07:13:13'),
(8, 'Zineb Khalfi', 'HH89012', 'zineb.khalfi@example.com', '0600000008', '2025-09-16 13:47:44', '2025-09-16 13:47:46'),
(9, 'Sara Mansouri', 'II90123', 'sara.mansouri@example.com', '0600000009', '2025-09-16 13:47:50', '2025-09-16 13:47:53'),
(10, 'Khadija Zouari', 'JJ01234', 'khadija.zouari@example.com', '0600000010', '2025-09-16 13:47:55', '2025-09-16 13:47:58'),
(11, 'Hamza Bennani', 'KK12345', 'hamza.bennani@example.com', '0600000011', '2025-09-16 13:48:01', '2025-09-16 13:48:03'),
(12, 'Youssef El Amrani', 'LL23456', 'youssef.elamrani@example.com', '0600000012', '2025-09-16 13:48:05', '2025-09-16 13:48:07'),
(13, 'Mohamed Chakib', 'MM34567', 'mohamed.chakib@example.com', '0600000013', '2025-09-16 13:48:09', '2025-09-16 13:48:11'),
(14, 'Khalid Belaid', 'NN45678', 'khalid.belaid@example.com', '0600000014', '2025-09-16 13:48:13', '2025-09-16 13:48:15'),
(15, 'Omar Jabari', 'OO56789', 'omar.jabari@example.com', '0600000015', '2025-09-16 13:48:17', '2025-09-16 13:48:19'),
(16, 'Fatima Khalfi', 'PP67890', 'fatima.khalfi@example.com', '0600000016', '2025-09-16 13:48:21', '2025-09-16 13:48:23'),
(17, 'Aicha Mansouri', 'QQ78901', 'aicha.mansouri@example.com', '0600000017', '2025-09-16 13:48:25', '2025-09-16 13:48:27'),
(18, 'Zineb Zouari', 'RR89012', 'zineb.zouari@example.com', '0600000018', '2025-09-16 13:48:29', '2025-09-16 13:48:31'),
(19, 'Sara El Ghazali', 'SS90123', 'sara.elghazali@example.com', '0600000019', '2025-09-16 13:48:33', '2025-09-16 13:48:36'),
(20, 'Khadija Hassani', 'TT01234', 'khadija.hassani@example.com', '0600000020', '2025-09-16 13:48:38', '2025-09-16 13:48:40'),
(21, 'ziada shimi', 'EE936827', 'satohamza4@gmail.com', '+212671746344', '2025-09-09 15:14:33', '2025-09-09 15:14:33'),
(22, 'youssef ababou', 'EE2514689', 'youssef@gmail.com', '0648512485', '2025-09-09 15:17:10', '2025-09-09 15:17:10'),
(23, 'ihssan charaq', 'EE2514685', 'ihssan@gmail.com', '0642153546', '2025-09-09 15:19:32', '2025-09-09 15:19:32'),
(25, 'test', 'EE545455', 'test@gmail.com', '0654859525', '2025-09-10 16:45:41', '2025-09-10 16:45:41'),
(26, 'test2', 'test2', 'test2@gmail.com', '0654259536', '2025-09-10 16:47:31', '2025-09-10 16:47:31'),
(27, 'test3', 'EEtest3', 'test3@gmail.com', '+212 658-942562', '2025-09-11 10:23:17', '2025-09-11 10:23:17'),
(28, 'hamza el hhhhhhhhh', 'EEjsdsd', 'hamza@gmail.com', '+212 671-746344', '2025-09-11 10:39:31', '2025-09-11 10:39:31'),
(29, 'test4', 'test4', 'test4@gmail.com', '+212 654-215958', '2025-09-11 10:47:41', '2025-09-11 10:47:41'),
(30, 'test5', 'test5', 'test5@gmail.com', '+212 671-746344', '2025-09-11 13:19:07', '2025-09-11 13:19:07'),
(31, 'test6', 'test6', 'test6@gmail.com', '+212 671-746344', '2025-09-11 13:20:07', '2025-09-11 13:20:07'),
(32, 'test7', 'test7', 'test7@gmail.com', '+212 671-746344', '2025-09-11 13:25:16', '2025-09-11 13:25:16'),
(33, 'test8', 'test8', 'test8@gmail.com', '+212 671-746344', '2025-09-11 13:30:58', '2025-09-11 13:30:58'),
(34, 'test9', 'test9', 'test9@gmail.com', '+212 671-746344', '2025-09-11 14:00:18', '2025-09-11 14:00:18'),
(35, 'test10', 'test10', 'test10@gmail.com', '+212 671-746344', '2025-09-14 13:18:05', '2025-09-14 13:18:05'),
(36, 'test11', 'test11', 'test11@gmail.com', '+212 654-235895', '2025-09-16 10:47:32', '2025-09-16 10:47:32'),
(37, 'test12', 'test12', 'test12@gmail.com', '+212 671-746344', '2025-09-19 07:11:40', '2025-09-19 07:11:40');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('AA73LfSWZJtpTzSUE75qR0WduOMPTMnQ1GYBaOqf', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWlVyd2pkVHdRNU9xUUFtaVc5ZUJ5YmV4T1B5WlNNTkFqQTBacWNRSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW9wbGVMaXN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1758530981);

-- --------------------------------------------------------

--
-- Table structure for table `university`
--

CREATE TABLE `university` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `university`
--

INSERT INTO `university` (`id`, `name`, `city`, `created_at`, `updated_at`) VALUES
(1, 'Cadi Ayyad University', 'Marrakech', NULL, NULL),
(2, 'Mohammed V University', 'Rabat', NULL, NULL),
(3, 'Hassan II University', 'Casablanca', NULL, NULL),
(4, 'Ibn Zohr University', 'Agadir', NULL, NULL),
(5, 'Sidi Mohamed Ben Abdellah University', 'Fes', NULL, NULL),
(6, 'upm', 'marrakech', '2025-09-11 12:52:57', '2025-09-11 12:52:57'),
(7, 'The Grand Hotel', 'casablanca', '2025-09-11 13:12:01', '2025-09-11 13:12:01');

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
  `role` varchar(255) NOT NULL DEFAULT 'superviseur',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Hamza elhaila', 'hamza@g.com', NULL, '$2y$12$sO7swviKgGhz7VX86XazTu.n0GkcBOK82i/vrhcn7UjNosyV3TPpa', 'superviseur', NULL, '2025-09-09 14:51:16', '2025-09-09 14:51:16'),
(2, 'test User', 'test.User@gmail.com', NULL, '$2y$12$n6NX0HRbKys/mC418H5FBu2UN2mN5UWpO0DTRySnrbDpJPHCkA.dm', 'superviseur', NULL, '2025-09-16 10:27:45', '2025-09-16 10:27:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absences_internship_id_foreign` (`internship_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `demandes`
--
ALTER TABLE `demandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `demandes_person_id_foreign` (`person_id`),
  ADD KEY `demandes_university_id_foreign` (`university_id`),
  ADD KEY `demandes_diplome_id_foreign` (`diplome_id`);

--
-- Indexes for table `diplomes`
--
ALTER TABLE `diplomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `internships`
--
ALTER TABLE `internships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internships_demand_id_foreign` (`demand_id`),
  ADD KEY `internships_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `people_cin_unique` (`cin`),
  ADD UNIQUE KEY `people_email_unique` (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `university`
--
ALTER TABLE `university`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absences`
--
ALTER TABLE `absences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `demandes`
--
ALTER TABLE `demandes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `diplomes`
--
ALTER TABLE `diplomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internships`
--
ALTER TABLE `internships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `university`
--
ALTER TABLE `university`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absences`
--
ALTER TABLE `absences`
  ADD CONSTRAINT `absences_internship_id_foreign` FOREIGN KEY (`internship_id`) REFERENCES `internships` (`id`);

--
-- Constraints for table `demandes`
--
ALTER TABLE `demandes`
  ADD CONSTRAINT `demandes_diplome_id_foreign` FOREIGN KEY (`diplome_id`) REFERENCES `diplomes` (`id`),
  ADD CONSTRAINT `demandes_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `demandes_university_id_foreign` FOREIGN KEY (`university_id`) REFERENCES `university` (`id`);

--
-- Constraints for table `internships`
--
ALTER TABLE `internships`
  ADD CONSTRAINT `internships_demand_id_foreign` FOREIGN KEY (`demand_id`) REFERENCES `demandes` (`id`),
  ADD CONSTRAINT `internships_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
