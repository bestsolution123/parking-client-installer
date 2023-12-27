-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 27 Des 2023 pada 11.19
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dispenser_parking`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `manless_payments`
--

CREATE TABLE `manless_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `payment_bank` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `manless_payments`
--

INSERT INTO `manless_payments` (`id`, `name`, `payment_type`, `payment_bank`, `is_deleted`, `created_at`, `updated_at`) VALUES
(2, 'pembayaran e wallet', 'emoney', 'emoney', 0, '2023-12-13 03:34:43', '2023-12-13 03:34:43'),
(3, 'pembayara qris', 'qris', 'qris', 0, '2023-12-13 03:34:43', '2023-12-13 03:34:43'),
(4, 'pembayara qris', 'qris', 'qris', 0, '2023-12-13 03:34:43', '2023-12-13 03:34:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `Nama` varchar(255) NOT NULL,
  `Periode` varchar(255) NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `Max_Kendaraan` int(11) NOT NULL,
  `Tarif` varchar(255) NOT NULL,
  `Biaya_Kartu` varchar(255) NOT NULL,
  `Biaya_Ganti_Plat_Number` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `members`
--

INSERT INTO `members` (`id`, `user_id`, `Nama`, `Periode`, `vehicle_id`, `Max_Kendaraan`, `Tarif`, `Biaya_Kartu`, `Biaya_Ganti_Plat_Number`, `Status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'member 1', '3', 1, 2, 'Rp. 30.000', 'Rp. 5.000', 'Rp. 15.000', 'Aktif', 0, '2023-12-13 03:25:00', '2023-12-13 03:25:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `member_plat_numbers`
--

CREATE TABLE `member_plat_numbers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_member_id` bigint(20) UNSIGNED NOT NULL,
  `plat_number` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `member_plat_numbers`
--

INSERT INTO `member_plat_numbers` (`id`, `transaction_member_id`, `plat_number`, `is_deleted`, `created_at`, `updated_at`) VALUES
(3, 1, '5acv890', 0, '2023-12-13 03:25:00', '2023-12-13 09:30:50'),
(4, 1, '5acv891', 0, '2023-12-13 03:25:00', '2023-12-13 09:30:50'),
(5, 1, '5acv892', 0, '2023-12-13 03:25:00', '2023-12-13 09:30:50'),
(6, 2, 'f341fhj', 0, '2023-12-13 03:25:00', '2023-12-13 09:30:40'),
(7, 2, 'f555mkn', 0, '2023-12-13 03:25:00', '2023-12-13 09:30:40'),
(8, 2, 'f908lpo', 0, '2023-12-13 03:25:00', '2023-12-13 09:30:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_10_18_071233_create_transactions_table', 1),
(6, '2023_10_18_071258_create_site_gate_parkings_table', 1),
(7, '2023_10_20_033859_create_vehicle_initials_table', 1),
(8, '2023_10_20_033911_create_vehicles_table', 1),
(9, '2023_10_23_234536_create_serial_comunications_table', 1),
(10, '2023_10_24_091938_create_printers_table', 1),
(11, '2023_10_27_181717_create_printer_settings_table', 1),
(12, '2023_11_03_165936_create_punishments_table', 1),
(13, '2023_11_07_101536_create_printer_settings_flexes_table', 1),
(14, '2023_11_07_111849_create_members_table', 1),
(15, '2023_11_07_113451_create_transaction_members_table', 1),
(16, '2023_11_07_114051_create_transaction_vouchers_table', 1),
(17, '2023_11_07_114152_create_vouchers_table', 1),
(18, '2023_11_16_213314_create_member_plat_numbers_table', 1),
(19, '2023_11_16_213444_create_voucher_plat_numbers_table', 1),
(20, '2023_11_27_095801_create_manless_payments_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 2, 'auth-sanctum', 'b0b38514d5d1aa2f3c436db06762218046d3f2319d9bd2190c2e9f881b58ea06', '[\"*\"]', NULL, '2023-11-27 10:19:55', '2023-11-27 10:19:55'),
(2, 'App\\Models\\User', 2, 'auth-sanctum', '7fc3e3fe15e1c0887a0561074df3dda2c895cd1c11f58e570f924865d1dcd974', '[\"*\"]', NULL, '2023-11-27 10:24:56', '2023-11-27 10:24:56'),
(3, 'App\\Models\\User', 2, 'auth-sanctum', 'f1bd6d27b3a41ac6e123c307348a09663592e0dc73aa5ee297915bce37a5d24d', '[\"*\"]', NULL, '2023-11-27 10:27:57', '2023-11-27 10:27:57'),
(4, 'App\\Models\\User', 2, 'auth-sanctum', '1b6f003303dc5cf568f0c481b1b4283c92d1698ceb7de883b9b029ed320ed892', '[\"*\"]', NULL, '2023-11-27 10:31:20', '2023-11-27 10:31:20'),
(5, 'App\\Models\\User', 2, 'auth-sanctum', '1133f26628b3c0128deb916e5ba30da71f4eec78dd7c22c81d60ada88029068c', '[\"*\"]', NULL, '2023-11-27 10:32:21', '2023-11-27 10:32:21'),
(6, 'App\\Models\\User', 2, 'auth-sanctum', '161f3d8e57394a2847544de96148bfc132d7573057a35c92538ec611aafd7c84', '[\"*\"]', NULL, '2023-11-27 10:34:04', '2023-11-27 10:34:04'),
(7, 'App\\Models\\User', 2, 'auth-sanctum', '853e3b5919af3ada1f847f7e13efb6afe535e5445d4cb7de8a5fcb6058005c3a', '[\"*\"]', NULL, '2023-11-27 10:36:44', '2023-11-27 10:36:44'),
(8, 'App\\Models\\User', 2, 'auth-sanctum', '83f2e26a9c422d1059e0cfcc1088e2558f4b3cb1c4eb0694dce6e620755cea07', '[\"*\"]', NULL, '2023-11-27 10:38:03', '2023-11-27 10:38:03'),
(9, 'App\\Models\\User', 2, 'auth-sanctum', '0c2e63bf6791d15539c5c5c19b1577e0bb803376b01f0f9a28d07368bbabf711', '[\"*\"]', NULL, '2023-11-27 10:49:05', '2023-11-27 10:49:05'),
(10, 'App\\Models\\User', 7, 'auth-sanctum', '28c457a863f6623cf3ddf5f3cb5d7b8698a22aa7dc7f85afa4e0fa343791b79e', '[\"*\"]', NULL, '2023-11-27 10:49:29', '2023-11-27 10:49:29'),
(11, 'App\\Models\\User', 7, 'auth-sanctum', 'b778a92d47a0ba0a2fe814da649cf82338f2bc19b0ad9ecb74480eefe95fb66c', '[\"*\"]', NULL, '2023-12-01 02:46:20', '2023-12-01 02:46:20'),
(12, 'App\\Models\\User', 2, 'auth-sanctum', '7f4db4c12340095d92704af869fa9d8fb5efc0cf4632a18842f3a66fe460b40e', '[\"*\"]', '2023-12-01 07:25:45', '2023-12-01 02:46:34', '2023-12-01 07:25:45'),
(13, 'App\\Models\\User', 7, 'auth-sanctum', '4cec94c2e9c588e814689c914d1e3ab7877d98eecbbc87c917ec37f2f551e6d9', '[\"*\"]', '2023-12-01 08:17:55', '2023-12-01 07:47:01', '2023-12-01 08:17:55'),
(14, 'App\\Models\\User', 2, 'auth-sanctum', '21d2ea2fea1524f4b9739b0873e040fb0714c04316b2e787364a434ac6058787', '[\"*\"]', NULL, '2023-12-01 08:44:55', '2023-12-01 08:44:55'),
(15, 'App\\Models\\User', 2, 'auth-sanctum', '3f3d488aea5d561fbc18115f76e9a1dcd5a2cc8a6cbb0696c02265b8b3519e61', '[\"*\"]', NULL, '2023-12-01 12:35:13', '2023-12-01 12:35:13'),
(16, 'App\\Models\\User', 7, 'auth-sanctum', '13a2e3cbd8d9aae87398c8b2aae02c54c2ef30e8e9431c6d86667537055efaf8', '[\"*\"]', NULL, '2023-12-01 12:35:25', '2023-12-01 12:35:25'),
(17, 'App\\Models\\User', 2, 'auth-sanctum', 'f1775fe86f3be8b5aea90ebe512932cb361cef05aa76c34a85386056865e14da', '[\"*\"]', NULL, '2023-12-01 12:56:17', '2023-12-01 12:56:17'),
(18, 'App\\Models\\User', 7, 'auth-sanctum', 'db6df27964a6f764b9022e682fd90dd4dc3471e9b850b52c6f0e94477c430fa9', '[\"*\"]', NULL, '2023-12-01 13:18:23', '2023-12-01 13:18:23'),
(19, 'App\\Models\\User', 2, 'auth-sanctum', '12a5ba81fffb1ca14f2b0e13ffccf4975098e4480b92e523830f12bc935cd7ed', '[\"*\"]', '2023-12-02 02:18:37', '2023-12-01 13:19:03', '2023-12-02 02:18:37'),
(20, 'App\\Models\\User', 7, 'auth-sanctum', '7b85f368b76a0fc258bbd75ced54f629c7214b545677abd1bb764f50fbee994b', '[\"*\"]', '2023-12-04 06:14:21', '2023-12-02 02:21:01', '2023-12-04 06:14:21'),
(21, 'App\\Models\\User', 2, 'auth-sanctum', '25d522ea0b8fa3264cdb95d1733b07db65829e304d4986b7863911bb44732988', '[\"*\"]', '2023-12-04 06:16:26', '2023-12-04 06:16:01', '2023-12-04 06:16:26'),
(22, 'App\\Models\\User', 7, 'auth-sanctum', '71665c1446c3219157462089e8a7daee0d191160a2db05fa1d1647ab1b6de22d', '[\"*\"]', '2023-12-04 06:18:00', '2023-12-04 06:17:03', '2023-12-04 06:18:00'),
(23, 'App\\Models\\User', 7, 'auth-sanctum', '9378d3f273ab33bb398176be6dc8ec1686687b7331799d134cbb5e29fc2d1e94', '[\"*\"]', '2023-12-04 06:20:18', '2023-12-04 06:19:21', '2023-12-04 06:20:18'),
(24, 'App\\Models\\User', 7, 'auth-sanctum', '1f6539b4e03a362b2f89ef489abb44b3d5b3557e7c62aff40daf7286eeee9348', '[\"*\"]', '2023-12-04 11:58:29', '2023-12-04 07:37:46', '2023-12-04 11:58:29'),
(25, 'App\\Models\\User', 7, 'auth-sanctum', 'cc8245197d14b8b10ce02e781a56482765a804de7d020846266309df3ff894b4', '[\"*\"]', '2023-12-09 10:31:05', '2023-12-05 00:12:07', '2023-12-09 10:31:05'),
(26, 'App\\Models\\User', 2, 'auth-sanctum', 'ca3a0a3380225a64d9296c3b934666a9f3aed55cbcbb723334e3fad160a86156', '[\"*\"]', NULL, '2023-12-09 13:05:58', '2023-12-09 13:05:58'),
(27, 'App\\Models\\User', 7, 'auth-sanctum', '1d65591b6bb03fe6d8c7f3bfaa6cd76d5a4108d4440941080cfecfb36fb92d65', '[\"*\"]', '2023-12-09 13:08:36', '2023-12-09 13:06:11', '2023-12-09 13:08:36'),
(28, 'App\\Models\\User', 7, 'auth-sanctum', '349ce19e1950654e3000055a79298b68d37c84d8b8f1c6f35145ad36970b5d07', '[\"*\"]', '2023-12-09 13:18:14', '2023-12-09 13:18:06', '2023-12-09 13:18:14'),
(29, 'App\\Models\\User', 7, 'auth-sanctum', 'f8562577329536dac691ae81f2198bd99d60322ac7d364e18b3bd48326a7a1b2', '[\"*\"]', '2023-12-11 04:35:44', '2023-12-11 02:32:27', '2023-12-11 04:35:44'),
(30, 'App\\Models\\User', 7, 'auth-sanctum', 'fff7c07ae79b71bec5b40f826ee51595f00b4749a610ab2b5e9f91865e271b49', '[\"*\"]', '2023-12-11 04:46:32', '2023-12-11 04:36:05', '2023-12-11 04:46:32'),
(31, 'App\\Models\\User', 2, 'auth-sanctum', 'a31af8765249cd65e711cae025e42e96c91cc71f07dabf2d3749d72e2fe2313a', '[\"*\"]', '2023-12-11 08:23:00', '2023-12-11 04:55:55', '2023-12-11 08:23:00'),
(32, 'App\\Models\\User', 2, 'auth-sanctum', '0e89b7cbdbd1606fcae4b12cba538f51acbbd71b39332dd55e22110f2660813c', '[\"*\"]', '2023-12-11 08:31:29', '2023-12-11 08:23:31', '2023-12-11 08:31:29'),
(33, 'App\\Models\\User', 7, 'auth-sanctum', 'bf64ecb981f9b12f5a4167bb9140885c8f5409fbe8df0aa26bba82dcd5b2b10e', '[\"*\"]', '2023-12-12 04:30:44', '2023-12-11 08:32:26', '2023-12-12 04:30:44'),
(34, 'App\\Models\\User', 2, 'auth-sanctum', '2fbc2a93e5980ff8fa9114a5b1eedb4206eb2d802f89ad5000fb77ab38ccb54e', '[\"*\"]', '2023-12-12 07:55:13', '2023-12-12 04:53:29', '2023-12-12 07:55:13'),
(35, 'App\\Models\\User', 7, 'auth-sanctum', '5885a6054ebfe244613412e1b9bfbb57f05ecde6875302c004a2009edf0efcdf', '[\"*\"]', '2023-12-12 08:53:54', '2023-12-12 07:59:56', '2023-12-12 08:53:54'),
(36, 'App\\Models\\User', 7, 'auth-sanctum', 'f99a4c8eab95738d0a01f19b00effe80e08230c5b26e0f468f8cd1442d29e942', '[\"*\"]', NULL, '2023-12-12 09:18:32', '2023-12-12 09:18:32'),
(37, 'App\\Models\\User', 2, 'auth-sanctum', '704908ce9ff082611367b0beb5dbb279a3532b7a0e6b1964ae9b527ac86fa74f', '[\"*\"]', '2023-12-12 09:34:11', '2023-12-12 09:18:46', '2023-12-12 09:34:11'),
(38, 'App\\Models\\User', 2, 'auth-sanctum', 'ad1c1645d91a0fe78eed71a4c68321691effb57f0e3a6ef4d49643c7fc17ed96', '[\"*\"]', NULL, '2023-12-12 09:34:40', '2023-12-12 09:34:40'),
(39, 'App\\Models\\User', 7, 'auth-sanctum', 'a3af18312f26b226db002084e97c161e654b433285045c192386eda4fa9d1e28', '[\"*\"]', NULL, '2023-12-12 09:35:04', '2023-12-12 09:35:04'),
(40, 'App\\Models\\User', 7, 'auth-sanctum', '9e361b3a94458f589b0148b7bd43489e8e1ae49121bf7f0030564195ffb3a32e', '[\"*\"]', '2023-12-12 09:37:33', '2023-12-12 09:37:11', '2023-12-12 09:37:33'),
(41, 'App\\Models\\User', 7, 'auth-sanctum', '2896dcf98eb38d9fa0fb6457cec4c5b1fb30d77e29e474ade77ce452852b400b', '[\"*\"]', NULL, '2023-12-12 10:43:09', '2023-12-12 10:43:09'),
(42, 'App\\Models\\User', 7, 'auth-sanctum', 'f9bc8782e254af31acaad0f07f46a6a76ff223d4a26cc93057535f96243a4ca0', '[\"*\"]', '2023-12-12 11:23:19', '2023-12-12 10:43:57', '2023-12-12 11:23:19'),
(43, 'App\\Models\\User', 2, 'auth-sanctum', 'cafb9b2d27f0135c2c6e4f9528ffcb480a3cb6efb8e7519fe4bc4e37c3957fc7', '[\"*\"]', NULL, '2023-12-12 11:35:13', '2023-12-12 11:35:13'),
(44, 'App\\Models\\User', 7, 'auth-sanctum', 'd4bc4aa65c3e6ca2ac3a1609746a452f16f683385f6c3d1e93fe82ba2a768eb3', '[\"*\"]', '2023-12-13 06:42:24', '2023-12-12 11:36:32', '2023-12-13 06:42:24'),
(45, 'App\\Models\\User', 7, 'auth-sanctum', '14f224e6a55f312238df73f40f6d168ba7bdcfdc9f4f8936d5d48bc6b836e6ca', '[\"*\"]', NULL, '2023-12-13 06:42:51', '2023-12-13 06:42:51'),
(46, 'App\\Models\\User', 2, 'auth-sanctum', 'e1e8655886feb894cc31c74024f0ec81c8971a008185c191b792b683c7b2a07e', '[\"*\"]', '2023-12-13 06:44:12', '2023-12-13 06:43:03', '2023-12-13 06:44:12'),
(47, 'App\\Models\\User', 7, 'auth-sanctum', 'c80d81d362f551b581c9f814b52ec84d8a515d5a83b9ee637be1e3446ff6f80e', '[\"*\"]', '2023-12-13 06:57:03', '2023-12-13 06:50:46', '2023-12-13 06:57:03'),
(48, 'App\\Models\\User', 2, 'auth-sanctum', 'db1e182688501bd620906c802b81166c1f999f04f4067fdc6aaa524b63e7d6e6', '[\"*\"]', '2023-12-13 07:00:59', '2023-12-13 06:58:07', '2023-12-13 07:00:59'),
(49, 'App\\Models\\User', 7, 'auth-sanctum', '7113ce02e47eafb5fed132fdb88799d7c83ee5ac99c3884ae14e15c5102e0b25', '[\"*\"]', NULL, '2023-12-13 07:03:02', '2023-12-13 07:03:02'),
(50, 'App\\Models\\User', 7, 'auth-sanctum', 'ecebdd9465a2a1a2a0c96321bb89cf0ff97bf28f0471429e4c0089df42541803', '[\"*\"]', NULL, '2023-12-13 07:06:22', '2023-12-13 07:06:22'),
(51, 'App\\Models\\User', 2, 'auth-sanctum', '47c68e06e35a1f1e67f684e619155216cd655f209c1e9b2aa2c170e027160689', '[\"*\"]', '2023-12-13 07:13:12', '2023-12-13 07:07:13', '2023-12-13 07:13:12'),
(52, 'App\\Models\\User', 7, 'auth-sanctum', 'd792da8111ff07a811f1034ccb894b15b65c630d581bc581949f6f813513d646', '[\"*\"]', '2023-12-13 07:20:00', '2023-12-13 07:19:51', '2023-12-13 07:20:00'),
(53, 'App\\Models\\User', 2, 'auth-sanctum', '27614565e9e90396c39de38d195adcc689190622100306a9fab27bb9624d5a4d', '[\"*\"]', NULL, '2023-12-13 07:21:28', '2023-12-13 07:21:28'),
(54, 'App\\Models\\User', 2, 'auth-sanctum', '02b521567b520bee1142d2026b58d233ed35eae117af96f13a4990e38783b7e6', '[\"*\"]', NULL, '2023-12-13 07:31:56', '2023-12-13 07:31:56'),
(55, 'App\\Models\\User', 2, 'auth-sanctum', 'a0975f0ec15d52c64be868e3e0581832a5f78d8916cf5906790d71b176f87028', '[\"*\"]', NULL, '2023-12-13 07:38:13', '2023-12-13 07:38:13'),
(56, 'App\\Models\\User', 7, 'auth-sanctum', '25be3302d8f5a69e994f83bb00cafe58abf632e916bae2aade3b39cb66e3f779', '[\"*\"]', '2023-12-13 07:59:55', '2023-12-13 07:38:32', '2023-12-13 07:59:55'),
(57, 'App\\Models\\User', 7, 'auth-sanctum', '51ce34e5b6fe550e642320b127a110b1cf6421c3d8aa6558b07db05a15f976e9', '[\"*\"]', '2023-12-13 08:45:28', '2023-12-13 08:10:58', '2023-12-13 08:45:28'),
(58, 'App\\Models\\User', 1, 'auth-sanctum', '54071f2996663fe4efad61e65d92121a2850dee5332f2cd046a0b544167cfaa1', '[\"*\"]', NULL, '2023-12-13 08:56:22', '2023-12-13 08:56:22'),
(59, 'App\\Models\\User', 13, 'auth-sanctum', '431ba777c9f3bef0b060e9b669e389de146cb104e62c23b18a18e5ca9a526555', '[\"*\"]', '2023-12-13 09:18:44', '2023-12-13 08:57:16', '2023-12-13 09:18:44'),
(60, 'App\\Models\\User', 7, 'auth-sanctum', 'ee5bfd31fee787907d6c764c83d5d0effb402f21eafd0b10a71cc56bf315a678', '[\"*\"]', '2023-12-13 09:21:48', '2023-12-13 09:20:27', '2023-12-13 09:21:48'),
(61, 'App\\Models\\User', 2, 'auth-sanctum', 'fdeccce62d964d5cfa2686222047eec035a386cdda91c0835f39fc81f0985553', '[\"*\"]', NULL, '2023-12-13 09:57:44', '2023-12-13 09:57:44'),
(62, 'App\\Models\\User', 2, 'auth-sanctum', '01479cc65fb9ad10990d6356755ef346dcfe84f1426e61382b40f15f9af9b7e3', '[\"*\"]', '2023-12-13 10:23:07', '2023-12-13 10:18:05', '2023-12-13 10:23:07'),
(63, 'App\\Models\\User', 14, 'auth-sanctum', '8f0d93933a88421d19df70998e20b4231d9a42766f2fd05a1bde786a520345ce', '[\"*\"]', '2023-12-13 10:28:53', '2023-12-13 10:23:22', '2023-12-13 10:28:53'),
(64, 'App\\Models\\User', 2, 'auth-sanctum', 'a289c82a00646859dbae7362d39ec33f26279570bc56c862edd68459c736d37b', '[\"*\"]', '2023-12-13 10:53:39', '2023-12-13 10:46:54', '2023-12-13 10:53:39'),
(65, 'App\\Models\\User', 7, 'auth-sanctum', 'a7ef119679bb7040b7e6ff2feeefb6aa6e4a20246a7b12be58eb56ca02e880b8', '[\"*\"]', '2023-12-13 11:33:31', '2023-12-13 11:30:14', '2023-12-13 11:33:31'),
(66, 'App\\Models\\User', 13, 'auth-sanctum', '2f940a2926c61f459bec7a13864864f6f3dc861500bcccaed0c38926338bdb87', '[\"*\"]', '2023-12-13 11:35:27', '2023-12-13 11:33:47', '2023-12-13 11:35:27'),
(67, 'App\\Models\\User', 2, 'auth-sanctum', '385576b9abdcabc828752748f277e7f7975a1555e472d60ffe084a1c229f6c3e', '[\"*\"]', '2023-12-13 11:35:55', '2023-12-13 11:35:47', '2023-12-13 11:35:55'),
(68, 'App\\Models\\User', 7, 'auth-sanctum', '8890134a6cbfed4efe84be669bedaf7f73493963c0535faca5222d7ea7b46b4b', '[\"*\"]', '2023-12-13 11:37:41', '2023-12-13 11:37:05', '2023-12-13 11:37:41'),
(69, 'App\\Models\\User', 13, 'auth-sanctum', '5632a4beebd817133f6f48caaeea57140ee1a9b26f3d0c01dbe01a04db9982bb', '[\"*\"]', '2023-12-13 11:40:17', '2023-12-13 11:38:22', '2023-12-13 11:40:17'),
(70, 'App\\Models\\User', 7, 'auth-sanctum', '513490e293bb6a08332e2bf15e86d156ed0e07276590161d54e36599096222e5', '[\"*\"]', '2023-12-13 11:44:06', '2023-12-13 11:42:35', '2023-12-13 11:44:06'),
(71, 'App\\Models\\User', 13, 'auth-sanctum', 'da9564cac7cb11524ff3c6aef4ee4c01aec83cebaf43fceb125169e1f9db8bc4', '[\"*\"]', '2023-12-13 11:45:17', '2023-12-13 11:44:31', '2023-12-13 11:45:17'),
(72, 'App\\Models\\User', 13, 'auth-sanctum', '57ee6eaefcfcc69b6bdbac22231d32ce951f61eb733c94396e627112d2c48b4d', '[\"*\"]', '2023-12-13 11:46:01', '2023-12-13 11:45:30', '2023-12-13 11:46:01'),
(73, 'App\\Models\\User', 7, 'auth-sanctum', '7940cc26ce20dd904c407dcf3abe18bef2bf85ec25bee50be63cc665ba1a347b', '[\"*\"]', NULL, '2023-12-13 11:51:03', '2023-12-13 11:51:03'),
(74, 'App\\Models\\User', 7, 'auth-sanctum', 'd71eba17fd00d87ef883e76d623e546563b42dfff48858728f95d238d8c64c8e', '[\"*\"]', '2023-12-13 11:51:15', '2023-12-13 11:51:04', '2023-12-13 11:51:15'),
(75, 'App\\Models\\User', 13, 'auth-sanctum', '7fd7c4cd8465384feee4a02aa61d5107b4ad425cbdd4a570be7abdd3f593b587', '[\"*\"]', '2023-12-13 11:51:56', '2023-12-13 11:51:46', '2023-12-13 11:51:56'),
(76, 'App\\Models\\User', 7, 'auth-sanctum', '994da412f8b95ea400660ab9cc9ca58f891b85724107fca2a6141089d1cf7619', '[\"*\"]', '2023-12-13 11:52:23', '2023-12-13 11:52:17', '2023-12-13 11:52:23'),
(77, 'App\\Models\\User', 13, 'auth-sanctum', '39b4de2e64f67c2a4d579ce5f99a076b1d25c4d70899f7d26fab69223a74b2f9', '[\"*\"]', '2023-12-13 11:52:50', '2023-12-13 11:52:44', '2023-12-13 11:52:50'),
(78, 'App\\Models\\User', 7, 'auth-sanctum', 'a69992cb48cbcd48ec10a840aa59e0c50a34cc154f678ca602ba6f5cc7bf291b', '[\"*\"]', NULL, '2023-12-13 11:53:51', '2023-12-13 11:53:51'),
(79, 'App\\Models\\User', 2, 'auth-sanctum', 'f3eef5bacedc9a8da17ae353e98d4e2d1cf71b113aec6456abedae9e3aaf75b2', '[\"*\"]', '2023-12-13 11:56:54', '2023-12-13 11:55:27', '2023-12-13 11:56:54'),
(80, 'App\\Models\\User', 14, 'auth-sanctum', 'a92e9690181250d8136b43c47439cec53f2d9f90402ea927190f64a8770545d7', '[\"*\"]', '2023-12-13 12:02:05', '2023-12-13 11:57:18', '2023-12-13 12:02:05'),
(81, 'App\\Models\\User', 13, 'auth-sanctum', '74ef52f8102366381a494e3921a2fe47bb1ed6d9d3b1a2396ee8a1c30d1b28fe', '[\"*\"]', '2023-12-13 12:12:06', '2023-12-13 12:07:37', '2023-12-13 12:12:06'),
(82, 'App\\Models\\User', 14, 'auth-sanctum', '1d91115a7eea5f9d5303c6e4b0da531641f46dc26d868108dcfd677f5863ceb6', '[\"*\"]', '2023-12-13 12:14:44', '2023-12-13 12:12:55', '2023-12-13 12:14:44'),
(83, 'App\\Models\\User', 13, 'auth-sanctum', 'e8ac1b4ddbae44cd19962da6d9aeff68a39c28fbd5db191a0a5b4014e3cd6097', '[\"*\"]', NULL, '2023-12-13 12:19:04', '2023-12-13 12:19:04'),
(84, 'App\\Models\\User', 7, 'auth-sanctum', 'daae5f1098ec1c3a939d5ed8e31926952b172fd5fe667cc8e6bf7c74f1d27650', '[\"*\"]', '2023-12-13 12:20:55', '2023-12-13 12:19:45', '2023-12-13 12:20:55'),
(85, 'App\\Models\\User', 2, 'auth-sanctum', '5d371e7756d7b9aa40afb44a37fe2399366b5cffa6f2f0f312d500e5f2e3d01a', '[\"*\"]', '2023-12-13 12:21:43', '2023-12-13 12:21:34', '2023-12-13 12:21:43'),
(86, 'App\\Models\\User', 13, 'auth-sanctum', 'fef948664372c9c7aee04ee64881cfc87ebca5d45c066d83264aba7b7059eba1', '[\"*\"]', NULL, '2023-12-13 12:21:56', '2023-12-13 12:21:56'),
(87, 'App\\Models\\User', 14, 'auth-sanctum', '7eb845b5609282b9678a8356c970cf8e2e171cd5f9d501d10a18a8bde85b53ea', '[\"*\"]', '2023-12-13 12:28:35', '2023-12-13 12:22:16', '2023-12-13 12:28:35'),
(88, 'App\\Models\\User', 7, 'auth-sanctum', 'b08334cb8f0d8427b66fe6fd2a285303c8e0d3b59bae68b065907c17f1e45837', '[\"*\"]', '2023-12-14 05:37:22', '2023-12-14 05:31:05', '2023-12-14 05:37:22'),
(89, 'App\\Models\\User', 13, 'auth-sanctum', 'd15c3474460985db921a9c7a13bfcc6fa00fc2c707885a6eabd031affc332538', '[\"*\"]', '2023-12-14 05:43:53', '2023-12-14 05:37:37', '2023-12-14 05:43:53'),
(90, 'App\\Models\\User', 7, 'auth-sanctum', 'da3597d13584567286212ab496178e786592760c1ed95bb312e1cfcec644094e', '[\"*\"]', '2023-12-14 05:44:34', '2023-12-14 05:44:27', '2023-12-14 05:44:34'),
(91, 'App\\Models\\User', 13, 'auth-sanctum', '02e48c486d4badcb34e3b7f636a428a7685f2bc17b2c5cff004da331091cc408', '[\"*\"]', '2023-12-14 05:45:55', '2023-12-14 05:45:06', '2023-12-14 05:45:55'),
(92, 'App\\Models\\User', 7, 'auth-sanctum', '4d35b4af6d550cda349c2e0fe13465591e59239b5e7f429604ee3421178eba91', '[\"*\"]', '2023-12-14 05:46:44', '2023-12-14 05:46:08', '2023-12-14 05:46:44'),
(93, 'App\\Models\\User', 13, 'auth-sanctum', 'a31326dd180e028c3277fe69f832009ebd1e3bf6eea0fe33c40a58c99a644b25', '[\"*\"]', '2023-12-14 05:47:48', '2023-12-14 05:47:01', '2023-12-14 05:47:48'),
(94, 'App\\Models\\User', 2, 'auth-sanctum', 'c056f5f70c05ba1d5101a648acb87c0e801aa4cbc002fc9ff5d647e6a8337f25', '[\"*\"]', '2023-12-14 05:49:00', '2023-12-14 05:48:49', '2023-12-14 05:49:00'),
(95, 'App\\Models\\User', 14, 'auth-sanctum', '20b1fde6020df031b6eadf73c2027200ee1eb8470e2b422788b3f093f84c190e', '[\"*\"]', '2023-12-14 05:56:37', '2023-12-14 05:49:27', '2023-12-14 05:56:37'),
(96, 'App\\Models\\User', 14, 'auth-sanctum', '87efd9f05b5b5c93c899b44cd58e7cbb9fb9af15e15c2e31fe75a6142600fd42', '[\"*\"]', '2023-12-14 06:00:20', '2023-12-14 05:57:04', '2023-12-14 06:00:20'),
(97, 'App\\Models\\User', 2, 'auth-sanctum', 'f6d6464a2b1aed8965f4973f53088043fea1fe2ada525ebb7bd59261710bf83b', '[\"*\"]', '2023-12-14 06:01:24', '2023-12-14 06:00:47', '2023-12-14 06:01:24'),
(98, 'App\\Models\\User', 2, 'auth-sanctum', '2fadfb898352ae3ea9649c8e83397349ba4de13b6364306c04f917d0270b3374', '[\"*\"]', '2023-12-14 06:02:45', '2023-12-14 06:01:56', '2023-12-14 06:02:45'),
(99, 'App\\Models\\User', 14, 'auth-sanctum', '4446960c0e478c3f8b7d01946e6049d8d54aa624b04b33b0bc0516bc175acab8', '[\"*\"]', '2023-12-14 06:27:32', '2023-12-14 06:02:55', '2023-12-14 06:27:32'),
(100, 'App\\Models\\User', 2, 'auth-sanctum', '5bdff0af529365e3d5f1588d3adbcbcd41e6afcaff355a1279e055bbae0f5c0d', '[\"*\"]', '2023-12-14 06:29:10', '2023-12-14 06:28:52', '2023-12-14 06:29:10'),
(101, 'App\\Models\\User', 14, 'auth-sanctum', '50aff0272a5845996915292097b2d71416c707385db2aa96853eadc39c446aa6', '[\"*\"]', '2023-12-14 06:31:18', '2023-12-14 06:29:22', '2023-12-14 06:31:18'),
(102, 'App\\Models\\User', 2, 'auth-sanctum', '482ebccd8f2d791976e2c921cb7e78963dd386a8dd1d5fc870fc7f75eb3390ef', '[\"*\"]', '2023-12-14 06:32:35', '2023-12-14 06:31:58', '2023-12-14 06:32:35'),
(103, 'App\\Models\\User', 14, 'auth-sanctum', '176418794ea679d7f1d2694bfefdd69f2f2dbda7e9c5b26aa12d8c16ea718a9d', '[\"*\"]', '2023-12-14 06:33:03', '2023-12-14 06:32:51', '2023-12-14 06:33:03'),
(104, 'App\\Models\\User', 2, 'auth-sanctum', '3b20e725449a58c4e76e7a04ecd7465b255d1d1c8f0312df52df98e94fa8d3ac', '[\"*\"]', '2023-12-14 06:33:36', '2023-12-14 06:33:20', '2023-12-14 06:33:36'),
(105, 'App\\Models\\User', 14, 'auth-sanctum', '108368ba6669be07bdc290a6c3b3bbd156e598952728869a2cdcb0d7bc5c838f', '[\"*\"]', '2023-12-14 06:34:44', '2023-12-14 06:34:11', '2023-12-14 06:34:44'),
(106, 'App\\Models\\User', 2, 'auth-sanctum', '67107b8fb4b3c0a877a3b17e01369a11e563d580e300354d1763b353261b6c7d', '[\"*\"]', '2023-12-14 06:35:16', '2023-12-14 06:34:59', '2023-12-14 06:35:16'),
(107, 'App\\Models\\User', 14, 'auth-sanctum', 'fe77a79047d3faf8240ce4ba5d1d038fb302300b0587c633d9d090c40626af52', '[\"*\"]', '2023-12-14 06:36:23', '2023-12-14 06:35:28', '2023-12-14 06:36:23'),
(108, 'App\\Models\\User', 2, 'auth-sanctum', 'cd934595636038cb50120f45522cae22d02b14b96c370d974b91286fc050fe17', '[\"*\"]', '2023-12-14 06:41:31', '2023-12-14 06:36:34', '2023-12-14 06:41:31'),
(109, 'App\\Models\\User', 14, 'auth-sanctum', '1cb9637f175877ebca84b7ecc8e108fdb6c70a382e39bcff11920363a5cc498f', '[\"*\"]', '2023-12-14 06:42:12', '2023-12-14 06:41:53', '2023-12-14 06:42:12'),
(110, 'App\\Models\\User', 13, 'auth-sanctum', 'ca43668735c858778e53815bc68adb032a01a77e06385d138f200301c90215d5', '[\"*\"]', '2023-12-14 09:31:27', '2023-12-14 08:38:40', '2023-12-14 09:31:27'),
(111, 'App\\Models\\User', 2, 'auth-sanctum', '155e8810e5dbe65d13c0c9d234614dbab33833d293f32882bcf2b0fd66e5ad21', '[\"*\"]', '2023-12-14 10:19:12', '2023-12-14 09:32:51', '2023-12-14 10:19:12'),
(112, 'App\\Models\\User', 14, 'auth-sanctum', '6e997f97a0772586248da8ab84ed87aa3806ad549412d41e46fe2c0ee53863ee', '[\"*\"]', '2023-12-14 10:19:40', '2023-12-14 10:19:25', '2023-12-14 10:19:40'),
(113, 'App\\Models\\User', 14, 'auth-sanctum', '9233caa6b18eaea9383add1152ccc72a440b0ee3a83f6855e59d33d7f71ea3d8', '[\"*\"]', '2023-12-14 10:36:10', '2023-12-14 10:35:28', '2023-12-14 10:36:10'),
(114, 'App\\Models\\User', 7, 'auth-sanctum', '23b297a93eea3e42e3d2bda0a2b0cc0d5caff5794898f5a5a8df243e08e04abc', '[\"*\"]', '2023-12-14 11:06:47', '2023-12-14 11:06:33', '2023-12-14 11:06:47'),
(115, 'App\\Models\\User', 13, 'auth-sanctum', '46ae6f5b0a7a9e1471dcb91241aa6ab736f5e78a81f3d9cee1c50bea54fdfda8', '[\"*\"]', '2023-12-14 11:07:53', '2023-12-14 11:07:04', '2023-12-14 11:07:53'),
(116, 'App\\Models\\User', 13, 'auth-sanctum', '50ce1a4388056014bfcee86e01cf535ddf982750d02560dd6d0c39c8e7e4bcf7', '[\"*\"]', '2023-12-14 11:11:03', '2023-12-14 11:10:23', '2023-12-14 11:11:03'),
(117, 'App\\Models\\User', 13, 'auth-sanctum', '963f6e0dbfd6f668f63eaa65c1e0110cc26322b82a1526dd0ab6e57b0b9bd103', '[\"*\"]', NULL, '2023-12-14 11:11:13', '2023-12-14 11:11:13'),
(118, 'App\\Models\\User', 7, 'auth-sanctum', 'd92b47f2a081b2df49cfc08c4d3763160fc271faad8da6a2fe601e94ad9c7990', '[\"*\"]', '2023-12-14 11:16:20', '2023-12-14 11:11:27', '2023-12-14 11:16:20'),
(119, 'App\\Models\\User', 13, 'auth-sanctum', '2c01ab7019e35169cc42e2a657930882d997414b5484c566b3500dadc9b283c5', '[\"*\"]', NULL, '2023-12-14 11:16:32', '2023-12-14 11:16:32'),
(120, 'App\\Models\\User', 14, 'auth-sanctum', 'e2cc8e66261b16f0c087f0874d9b11457804a6c11ff9e3f19e4c81833505e615', '[\"*\"]', '2023-12-14 11:17:41', '2023-12-14 11:16:48', '2023-12-14 11:17:41'),
(121, 'App\\Models\\User', 13, 'auth-sanctum', 'c76c29fc7101bef45dd8c5235183e8179ed4ab3337891b7064bdac606831dd38', '[\"*\"]', '2023-12-14 11:19:20', '2023-12-14 11:18:07', '2023-12-14 11:19:20'),
(122, 'App\\Models\\User', 7, 'auth-sanctum', '03c9edcea8d4ce4b4aab616ee3cb4db60ff4bebf377d03fa2a6ed52af28092ec', '[\"*\"]', '2023-12-14 11:51:54', '2023-12-14 11:46:48', '2023-12-14 11:51:54'),
(123, 'App\\Models\\User', 13, 'auth-sanctum', '2e088e8ca4c86c8abf1efb79ddebfd05dd13ff740f9c82c95da8beb5d418ea57', '[\"*\"]', '2023-12-14 12:02:54', '2023-12-14 11:59:55', '2023-12-14 12:02:54'),
(124, 'App\\Models\\User', 7, 'auth-sanctum', '34aef7902a41178c76e171a3b754ec286adbfb3eb5012421a7ae367296743ac1', '[\"*\"]', '2023-12-14 12:10:09', '2023-12-14 12:03:12', '2023-12-14 12:10:09'),
(125, 'App\\Models\\User', 2, 'auth-sanctum', '5d06cbd12fadee4864a01ac0acfc45c41a0b6199e218364c8012297828ac1d01', '[\"*\"]', NULL, '2023-12-15 07:30:06', '2023-12-15 07:30:06'),
(126, 'App\\Models\\User', 2, 'auth-sanctum', 'd2438f865df0e156bfb406bd585cbdbc3aafd851e4b939f60a7d3a139e6b380a', '[\"*\"]', NULL, '2023-12-15 07:30:10', '2023-12-15 07:30:10'),
(127, 'App\\Models\\User', 2, 'auth-sanctum', '263c329600d3eefb84add8184eb6c348a31ff9bb1b62a1f9ae2f09d5884b9611', '[\"*\"]', '2023-12-15 08:41:24', '2023-12-15 07:30:14', '2023-12-15 08:41:24'),
(128, 'App\\Models\\User', 7, 'auth-sanctum', 'd5816639ff4b58f69cd5de456bca3bef8660133b758858768f68c3f02178ac59', '[\"*\"]', '2023-12-15 07:34:18', '2023-12-15 07:32:46', '2023-12-15 07:34:18'),
(129, 'App\\Models\\User', 14, 'auth-sanctum', 'a3e7c5fe68bb622f83197b6652b50b45724231645403c2305e393e40f8099caa', '[\"*\"]', '2023-12-15 08:40:09', '2023-12-15 07:53:55', '2023-12-15 08:40:09'),
(130, 'App\\Models\\User', 14, 'auth-sanctum', 'bd39abf3e18b9b4e7069de5e6fda83ac836aab9b3ab889686d4caf7cfd23212e', '[\"*\"]', NULL, '2023-12-15 08:41:40', '2023-12-15 08:41:40'),
(131, 'App\\Models\\User', 14, 'auth-sanctum', '60d90233ae7b728167b94f1608a09af71d158e848ff12e24f0d821d015c66c61', '[\"*\"]', '2023-12-15 11:18:25', '2023-12-15 08:41:43', '2023-12-15 11:18:25'),
(132, 'App\\Models\\User', 2, 'auth-sanctum', 'e0f92525310367a6230e1525ee8a77587e34857ea32ab98bc150e96b17c981be', '[\"*\"]', '2023-12-15 11:54:35', '2023-12-15 11:19:05', '2023-12-15 11:54:35'),
(133, 'App\\Models\\User', 14, 'auth-sanctum', '40e8217587f863028f9f1dfe17e6eeed72e10bade19a277e707207225eb912b1', '[\"*\"]', '2023-12-16 10:44:30', '2023-12-16 10:14:28', '2023-12-16 10:44:30'),
(134, 'App\\Models\\User', 7, 'auth-sanctum', 'a3415c478c911943ea7dcf7a60cd3ccd329fd1c79f73a7a2527ef16c51daba36', '[\"*\"]', '2023-12-16 10:44:40', '2023-12-16 10:44:37', '2023-12-16 10:44:40'),
(135, 'App\\Models\\User', 2, 'auth-sanctum', '1f2350d75433c53cab30aff55c7a8a4592c2a375fa9a178a460eb19ae25b4950', '[\"*\"]', '2023-12-16 10:45:01', '2023-12-16 10:44:49', '2023-12-16 10:45:01'),
(136, 'App\\Models\\User', 2, 'auth-sanctum', 'c4044e58877f0be1fc77622ae3df2d6330841ce26d48e04807eeb867af596790', '[\"*\"]', '2023-12-16 11:10:03', '2023-12-16 11:09:29', '2023-12-16 11:10:03'),
(137, 'App\\Models\\User', 7, 'auth-sanctum', '32239da3025f3f3a956a70e24fce0efb0f5c4c4578c716682e561f099868e3d3', '[\"*\"]', '2023-12-16 11:44:51', '2023-12-16 11:38:37', '2023-12-16 11:44:51'),
(138, 'App\\Models\\User', 2, 'auth-sanctum', '7067eee6a8442017a7a10b164dbc534018326375098dc6483a6291cf5cfdd591', '[\"*\"]', NULL, '2023-12-17 22:34:44', '2023-12-17 22:34:44'),
(139, 'App\\Models\\User', 13, 'auth-sanctum', '633bf318f1d5037cd4153025f34861f5c9cd177e0eb4275141bbbcb08a5ce1d3', '[\"*\"]', NULL, '2023-12-18 04:32:23', '2023-12-18 04:32:23'),
(140, 'App\\Models\\User', 14, 'auth-sanctum', '114866ba3a73b668f844e1ff4fb0ae26bfd010b810684f152f1eedf29311f869', '[\"*\"]', '2023-12-18 04:38:28', '2023-12-18 04:32:39', '2023-12-18 04:38:28'),
(141, 'App\\Models\\User', 2, 'auth-sanctum', '20d2298655c583c92dc6f9c00eea2430a86be3e57348db1095b1c31dba2eecb3', '[\"*\"]', '2023-12-18 04:41:51', '2023-12-18 04:39:21', '2023-12-18 04:41:51'),
(142, 'App\\Models\\User', 2, 'auth-sanctum', '0833556aadfe7c76e9183f04ef9ada39fc36161178366e1cf54854665a4ffeb8', '[\"*\"]', '2023-12-18 04:47:37', '2023-12-18 04:42:11', '2023-12-18 04:47:37'),
(143, 'App\\Models\\User', 14, 'auth-sanctum', 'ace1a09e4ae241a8b7f952153b7b3d6a07cfd0c561be6e6e44cb756b0ca5fd08', '[\"*\"]', '2023-12-18 05:26:58', '2023-12-18 04:47:52', '2023-12-18 05:26:58'),
(144, 'App\\Models\\User', 2, 'auth-sanctum', 'af808c6401a176efb83e893940a4561b674b1c860b19dd0c2c4a742d587eb942', '[\"*\"]', '2023-12-22 07:47:53', '2023-12-18 05:27:38', '2023-12-22 07:47:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `printers`
--

CREATE TABLE `printers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `type_connection` varchar(255) NOT NULL,
  `paper_size` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `printers`
--

INSERT INTO `printers` (`id`, `user_id`, `name`, `address`, `type_connection`, `paper_size`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'epson', '192.168.1.90', 'LAN', '80', 0, '2023-12-13 03:25:00', '2023-12-13 03:25:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `printer_settings`
--

CREATE TABLE `printer_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_gate_parking_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_on` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `printer_settings`
--

INSERT INTO `printer_settings` (`id`, `site_gate_parking_id`, `user_id`, `name`, `is_on`, `is_deleted`, `created_at`, `updated_at`) VALUES
(104, 12, 1, 'Logo', 1, 0, '2023-12-13 03:25:00', '2023-12-13 03:25:00'),
(105, 12, 1, 'QRCode', 1, 0, '2023-12-13 03:25:00', '2023-12-13 03:25:00'),
(106, 12, 1, 'Plat Kendaraan', 1, 0, '2023-12-13 03:25:00', '2023-12-13 03:25:00'),
(107, 12, 1, 'Tanggal Masuk', 1, 0, '2023-12-13 03:25:00', '2023-12-13 03:25:00'),
(108, 12, 1, 'Alamat', 1, 0, '2023-12-13 03:25:00', '2023-12-13 03:25:00'),
(109, 12, 1, 'Catatan', 1, 0, '2023-12-13 03:25:00', '2023-12-13 03:25:00'),
(110, 13, 1, 'Logo', 1, 0, '2023-12-13 03:25:00', '2023-12-13 07:04:51'),
(111, 13, 1, 'QRCode', 1, 0, '2023-12-13 03:25:00', '2023-12-13 07:04:51'),
(112, 13, 1, 'Plat Kendaraan', 1, 0, '2023-12-13 03:25:00', '2023-12-13 07:04:51'),
(113, 13, 1, 'Tanggal Masuk', 1, 0, '2023-12-13 03:25:00', '2023-12-13 07:04:51'),
(114, 13, 1, 'Alamat', 1, 0, '2023-12-13 03:25:00', '2023-12-13 07:04:51'),
(115, 13, 1, 'Catatan', 1, 0, '2023-12-13 03:25:00', '2023-12-13 07:04:51'),
(176, 24, 1, 'Logo', 1, 0, '2023-12-13 08:56:15', '2023-12-13 08:56:15'),
(177, 24, 1, 'QRCode', 1, 0, '2023-12-13 08:56:15', '2023-12-13 08:56:15'),
(178, 24, 1, 'Plat Kendaraan', 1, 0, '2023-12-13 08:56:15', '2023-12-13 08:56:15'),
(179, 24, 1, 'Tanggal Masuk', 1, 0, '2023-12-13 08:56:15', '2023-12-13 08:56:15'),
(180, 24, 1, 'Alamat', 1, 0, '2023-12-13 08:56:15', '2023-12-13 08:56:15'),
(181, 24, 1, 'Catatan', 1, 0, '2023-12-13 08:56:15', '2023-12-13 08:56:15'),
(182, 25, 1, 'Logo', 1, 0, '2023-12-13 10:15:37', '2023-12-13 10:15:37'),
(183, 25, 1, 'QRCode', 1, 0, '2023-12-13 10:15:37', '2023-12-13 10:15:37'),
(184, 25, 1, 'Plat Kendaraan', 1, 0, '2023-12-13 10:15:37', '2023-12-13 10:15:37'),
(185, 25, 1, 'Tanggal Masuk', 1, 0, '2023-12-13 10:15:37', '2023-12-13 10:15:37'),
(186, 25, 1, 'Alamat', 1, 0, '2023-12-13 10:15:37', '2023-12-13 10:15:37'),
(187, 25, 1, 'Catatan', 1, 0, '2023-12-13 10:15:37', '2023-12-13 10:15:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `printer_settings_flexes`
--

CREATE TABLE `printer_settings_flexes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `punishments`
--

CREATE TABLE `punishments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `punishments`
--

INSERT INTO `punishments` (`id`, `user_id`, `name`, `price`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'STNK hilang', 'Rp. 20.000', 0, '2023-12-13 03:25:00', '2023-12-13 03:25:00'),
(7, 1, 'struk hilang', 'Rp. 100.000', 0, '2023-12-13 07:10:12', '2023-12-13 07:10:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `serial_comunications`
--

CREATE TABLE `serial_comunications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `site_gate_parkings`
--

CREATE TABLE `site_gate_parkings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `printer_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `type_payment` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `is_print` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `site_gate_parkings`
--

INSERT INTO `site_gate_parkings` (`id`, `user_id`, `printer_id`, `vehicle_id`, `type_payment`, `name`, `type`, `address`, `is_print`, `is_deleted`, `created_at`, `updated_at`) VALUES
(12, 1, 1, 1, 'Manual', 'gerbang 1', 'Masuk', 'Gedung Pusat Niaga Arena JIEXPO Kemayoran Jakarta Pusat 10620 DKI Jakarta, Indonesia', 0, 0, '2023-12-13 03:30:01', '2023-12-13 03:30:01'),
(13, 1, 1, 1, 'Manless', 'gerbang 2', 'Masuk', 'Gedung Pusat Niaga Arena JIEXPO Kemayoran Jakarta Pusat 10620 DKI Jakarta, Indonesia', 0, 0, '2023-12-13 03:30:01', '2023-12-13 07:04:51'),
(24, 1, 1, 1, 'Manless', 'gerbang keluar 1', 'Keluar', 'Gedung Pusat Niaga Arena JIEXPO Kemayoran Jakarta Pusat 10620 DKI Jakarta, Indonesia', 0, 0, '2023-12-13 08:56:15', '2023-12-13 08:56:15'),
(25, 1, 1, 1, 'Manual', 'gerbang 3', 'Keluar', 'Gedung Pusat Niaga Arena JIEXPO Kemayoran Jakarta Pusat 10620 DKI Jakarta, Indonesia', 0, 0, '2023-12-13 10:15:37', '2023-12-13 10:15:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `site_gate_parking_payments`
--

CREATE TABLE `site_gate_parking_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `manless_payment_id` bigint(20) UNSIGNED NOT NULL,
  `site_gate_parking_id` bigint(20) UNSIGNED NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `site_gate_parking_payments`
--

INSERT INTO `site_gate_parking_payments` (`id`, `manless_payment_id`, `site_gate_parking_id`, `is_deleted`, `created_at`, `updated_at`) VALUES
(6, 2, 5, 0, '2023-12-13 03:30:01', '2023-12-13 03:30:01'),
(7, 3, 5, 0, '2023-12-13 03:30:01', '2023-12-13 03:30:01'),
(8, 2, 5, 0, '2023-12-13 03:30:01', '2023-12-13 03:30:01'),
(12, 3, 13, 0, '2023-12-13 03:30:01', '2023-12-13 07:04:51'),
(13, 4, 13, 0, '2023-12-13 03:30:01', '2023-12-13 07:04:51'),
(39, 4, 24, 0, '2023-12-13 08:56:15', '2023-12-13 08:56:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `site_gate_parking_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_voucher_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_member_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `serial` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `plat_number` varchar(255) NOT NULL,
  `in_photo` varchar(255) NOT NULL,
  `out_photo` varchar(255) NOT NULL,
  `visitor_type` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `gate_out` varchar(255) NOT NULL,
  `date_out` datetime NOT NULL,
  `timeZone` varchar(255) NOT NULL,
  `date_in` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `site_gate_parking_id`, `transaction_voucher_id`, `transaction_member_id`, `vehicle_id`, `serial`, `number`, `plat_number`, `in_photo`, `out_photo`, `visitor_type`, `payment_method`, `payment_type`, `status`, `gate_out`, `date_out`, `timeZone`, `date_in`, `is_deleted`, `created_at`, `updated_at`) VALUES
(237, 1, 13, 0, 1701058009983, 1, '2312180001210013', '1', '5acv890', '55520231218123652-cctv-captures.png', '81620231218123652-cctv-captures.png', 'Member', 'Manless', 'Cash', 'Selesai', 'gerbang 2', '2023-12-18 13:41:07', 'Asia/Makassar', '2023-12-18 13:39:29', 0, '2023-12-18 05:36:33', '2023-12-18 05:50:41'),
(238, 1, 13, 1701057814656, 0, 1, '2312180002210013', '2', '5acv000', '54820231218123652-cctv-captures.png', '63320231218123652-cctv-captures.png', 'Voucher', 'Manless', 'Cash', 'STNK hilang', 'gerbang 2', '2023-12-18 13:40:42', 'Asia/Makassar', '2023-12-18 13:39:36', 0, '2023-12-18 05:36:42', '2023-12-18 05:50:41'),
(239, 1, 13, 0, 1701058009983, 1, '2312180003210013', '3', '5acv890', '87120231218123652-cctv-captures.png', '92920231218123652-cctv-captures.png', 'Member', 'Manless', 'qris', 'Selesai', 'gerbang 2', '2023-12-18 13:53:38', 'Asia/Makassar', '2023-12-18 13:43:00', 0, '2023-12-18 05:40:04', '2023-12-18 05:50:41'),
(240, 1, 13, 1701057814656, 0, 1, '2312180004210013', '4', '5acv000', '25920231218123652-cctv-captures.png', '69720231218123652-cctv-captures.png', 'Voucher', 'Manless', 'qris', 'Selesai', 'gerbang 2', '2023-12-18 13:50:43', 'Asia/Makassar', '2023-12-18 13:43:06', 0, '2023-12-18 05:40:12', '2023-12-18 05:50:41'),
(241, 1, 13, 0, 0, 1, '2312180005210013', '5', '-', '29020231218123652-cctv-captures.png', '-', 'Regular', '-', '-', '-', '-', '2023-12-18 13:43:14', 'Asia/Makassar', '2023-12-18 13:43:14', 0, '2023-12-18 05:40:22', '2023-12-18 05:50:41'),
(242, 1, 12, 0, 0, 1, '2312220006250012', '6', '-', '67720231222144712-cctv-captures.png', '-', 'Regular', '-', '-', '-', '-', '2023-12-22 14:47:13', 'Asia/Jakarta', '2023-12-22 14:47:13', 0, '2023-12-22 07:47:13', '2023-12-22 07:47:13'),
(243, 1, 12, 0, 0, 1, '2312220007250012', '7', '-', '14220231222144752-cctv-captures.png', '-', 'Regular', '-', '-', '-', '-', '2023-12-22 14:47:53', 'Asia/Jakarta', '2023-12-22 14:47:53', 0, '2023-12-22 07:47:53', '2023-12-22 07:47:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_members`
--

CREATE TABLE `transaction_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `serial` varchar(255) NOT NULL,
  `Nama` varchar(255) NOT NULL,
  `Akses` varchar(255) NOT NULL,
  `Hp` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Tarif_Dasar_Member` varchar(255) NOT NULL,
  `Tarif_Member` varchar(255) NOT NULL,
  `Tarif_Kartu` varchar(255) NOT NULL,
  `Awal_Aktif` varchar(255) NOT NULL,
  `Akhir_Aktif` varchar(255) NOT NULL,
  `Total_Biaya` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaction_members`
--

INSERT INTO `transaction_members` (`id`, `user_id`, `member_id`, `serial`, `Nama`, `Akses`, `Hp`, `Email`, `Tarif_Dasar_Member`, `Tarif_Member`, `Tarif_Kartu`, `Awal_Aktif`, `Akhir_Aktif`, `Total_Biaya`, `Status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '1701058009983', 'member 1', 'No Polisi', '085881231231', 'member1@gmail.com', 'Rp. 30.000', 'Rp. 90.000', 'Rp. 5.000', '2023-11-27', '2024-02-25', 'Rp. 95.000', '1', 0, '2023-12-13 03:30:01', '2023-12-18 09:26:10'),
(2, 1, 1, '1701706585485', 'member 2', 'No Polisi', '12312312312312', 'test2@test', 'Rp. 30.000', 'Rp. 90.000', 'Rp. 5.000', '2023-12-3', '2028-5-18', 'Rp. 95.000', '1', 0, '2023-12-13 03:30:01', '2023-12-18 09:26:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_member_logs`
--

CREATE TABLE `transaction_member_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `serial` varchar(255) NOT NULL,
  `Nama` varchar(255) NOT NULL,
  `Akses` varchar(255) NOT NULL,
  `Hp` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Tarif_Dasar_Member` varchar(255) NOT NULL,
  `Tarif_Member` varchar(255) NOT NULL,
  `Tarif_Kartu` varchar(255) NOT NULL,
  `Awal_Aktif` varchar(255) NOT NULL,
  `Akhir_Aktif` varchar(255) NOT NULL,
  `Total_Biaya` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaction_member_logs`
--

INSERT INTO `transaction_member_logs` (`id`, `user_id`, `serial`, `Nama`, `Akses`, `Hp`, `Email`, `Tarif_Dasar_Member`, `Tarif_Member`, `Tarif_Kartu`, `Awal_Aktif`, `Akhir_Aktif`, `Total_Biaya`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, '1701706585485', 'member 2', 'No Polisi', '12312312312312', 'test2@test', 'Rp. 30.000', 'Rp. 90.000', 'Rp. 5.000', '2023-12-12', '2023-12-29', 'Rp. 242.000', 0, '2023-12-05 01:19:05', '2023-12-05 01:19:05'),
(2, 1, '1701706585485', 'member 2', 'No Polisi', '12312312312312', 'test2@test', 'Rp. 30.000', 'Rp. 90.000', 'Rp. 5.000', '2023-12-3', '2024-5-18', 'Rp. 141.000', 0, '2023-12-05 01:19:50', '2023-12-05 01:19:50'),
(3, 1, '1701706585485', 'member 2', 'No Polisi', '12312312312312', 'test2@test', 'Rp. 30.000', 'Rp. 90.000', 'Rp. 5.000', '2023-12-3', '2024-9-13', 'Rp. 118.000', 0, '2023-12-06 14:07:18', '2023-12-06 14:07:18'),
(4, 1, '1701706585485', 'member 2', 'No Polisi', '12312312312312', 'test2@test', 'Rp. 30.000', 'Rp. 90.000', 'Rp. 5.000', '2023-12-3', '2025-2-7', 'Rp. 147.000', 0, '2023-12-12 04:26:40', '2023-12-12 04:26:40'),
(5, 1, '1701706585485', 'member 2', 'No Polisi', '12312312312312', 'test2@test', 'Rp. 30.000', 'Rp. 90.000', 'Rp. 5.000', '2023-12-3', '2028-5-18', 'Rp. 1.196.000', 0, '2023-12-18 09:01:39', '2023-12-18 09:01:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_vouchers`
--

CREATE TABLE `transaction_vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `voucher_id` bigint(20) UNSIGNED NOT NULL,
  `serial` varchar(255) NOT NULL,
  `Produk` varchar(255) NOT NULL,
  `Tarif` varchar(255) NOT NULL,
  `Tarif_Dasar_Voucher` varchar(255) NOT NULL,
  `Total_Biaya` varchar(255) NOT NULL,
  `Awal_Aktif` varchar(255) NOT NULL,
  `Akhir_Aktif` varchar(255) NOT NULL,
  `Keterangan` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaction_vouchers`
--

INSERT INTO `transaction_vouchers` (`id`, `user_id`, `voucher_id`, `serial`, `Produk`, `Tarif`, `Tarif_Dasar_Voucher`, `Total_Biaya`, `Awal_Aktif`, `Akhir_Aktif`, `Keterangan`, `Status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '1701057814656', 'voucher 1', 'Rp. 50.000', 'Rp. 5.000', 'Rp. 50.000', '2023-11-1', '2025-12-18', 'voucher event 17 agustus', '1', 0, '2023-12-13 03:30:01', '2023-12-18 09:01:23'),
(2, 1, 1, '1701707849285', 'voucher 2', 'Rp. 50.000', 'Rp. 5.000', 'Rp. 50.000', '2023-12-7', '2026-12-18', 'voucher event 19 agustus', '1', 0, '2023-12-13 03:30:01', '2023-12-18 09:01:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_voucher_logs`
--

CREATE TABLE `transaction_voucher_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `serial` varchar(255) NOT NULL,
  `Produk` varchar(255) NOT NULL,
  `Tarif` varchar(255) NOT NULL,
  `Tarif_Dasar_Voucher` varchar(255) NOT NULL,
  `Total_Biaya` varchar(255) NOT NULL,
  `Awal_Aktif` varchar(255) NOT NULL,
  `Akhir_Aktif` varchar(255) NOT NULL,
  `Keterangan` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaction_voucher_logs`
--

INSERT INTO `transaction_voucher_logs` (`id`, `user_id`, `serial`, `Produk`, `Tarif`, `Tarif_Dasar_Voucher`, `Total_Biaya`, `Awal_Aktif`, `Akhir_Aktif`, `Keterangan`, `is_deleted`, `created_at`, `updated_at`) VALUES
(2, 1, '1701707849285', 'voucher 2', 'Rp. 50.000', 'Rp. 5.000', 'Rp. 2.100.000', '2023-12-12', '2024-4-19', 'voucher event 19 agustus', 0, '2023-12-05 01:33:19', '2023-12-05 01:33:19'),
(3, 1, '1701707849285', 'voucher 2', 'Rp. 50.000', 'Rp. 5.000', 'Rp. 6.300.000', '2023-12-12', '2024-8-23', 'voucher event 19 agustus', 0, '2023-12-05 01:33:28', '2023-12-05 01:33:28'),
(4, 1, '1701707849285', 'voucher 2', 'Rp. 50.000', 'Rp. 5.000', 'Rp. 0', '2023-12-12', '2023-12-28', 'voucher event 19 agustus', 0, '2023-12-11 05:06:30', '2023-12-11 05:06:30'),
(5, 1, '1701707849285', 'voucher 2', 'Rp. 50.000', 'Rp. 5.000', 'Rp. 5.250.000', '2023-12-12', '2024-4-11', 'voucher event 19 agustus', 0, '2023-12-11 05:06:47', '2023-12-11 05:06:47'),
(6, 1, '1701707849285', 'voucher 2', 'Rp. 50.000', 'Rp. 5.000', 'Rp. 12.900.000', '2023-12-12', '2024-12-25', 'voucher event 19 agustus', 0, '2023-12-11 05:07:17', '2023-12-11 05:07:17'),
(7, 1, '1701707849285', 'voucher 2', 'Rp. 50.000', 'Rp. 5.000', 'Rp. 36.150.000', '2023-12-7', '2026-12-18', 'voucher event 19 agustus', 0, '2023-12-18 09:01:03', '2023-12-18 09:01:03'),
(8, 1, '1701057814656', 'voucher 1', 'Rp. 50.000', 'Rp. 5.000', 'Rp. 0', '2023-11-1', '2023-12-14', 'voucher event 17 agustus', 0, '2023-12-18 09:01:15', '2023-12-18 09:01:15'),
(9, 1, '1701057814656', 'voucher 1', 'Rp. 50.000', 'Rp. 5.000', 'Rp. 36.750.000', '2023-11-1', '2025-12-18', 'voucher event 17 agustus', 0, '2023-12-18 09:01:23', '2023-12-18 09:01:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_gate_parking_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `timeZone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `site_gate_parking_id`, `name`, `role`, `timeZone`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 12, 'admin', 'admin', 'Asia/Bangkok', 'admin@gmail.com', NULL, '$2y$10$dMyJc5MjPq2vx7gZ3pMLW.t8JE1bCrNS8yToW8zgDNoSqGKRdgph6', NULL, '2023-12-13 03:30:01', '2023-12-13 03:30:01'),
(2, 12, 'gerbang masuk barat', 'author', 'Asia/Jakarta', 'asd@gmail.com', NULL, '$2y$10$dMyJc5MjPq2vx7gZ3pMLW.t8JE1bCrNS8yToW8zgDNoSqGKRdgph6', NULL, '2023-12-13 03:30:01', '2023-12-13 12:21:17'),
(6, 12, 'admin2', 'admin', 'Asia/Bangkok', 'admin2@gmail.com', NULL, '$2y$10$dMyJc5MjPq2vx7gZ3pMLW.t8JE1bCrNS8yToW8zgDNoSqGKRdgph6', NULL, '2023-12-13 03:30:01', '2023-12-13 03:30:01'),
(7, 13, 'gerbang masuk timur', 'author', 'Asia/Makassar', 'jnjnjn@fdfd', NULL, '$2y$10$pIByIUSOtKYakJlfDi0//Ox3u7H3mqQw8JXC/naBEa7aPgZXJBytu', NULL, '2023-12-13 03:30:01', '2023-12-13 09:20:16'),
(13, 24, 'gerbang keluar timur', 'author', 'Asia/Makassar', 'asdas@asdasd', NULL, '$2y$10$PMOaxiiCeL6BSYlMOdvKo.g98I.MUJnygRK0oyEXa0pEDtIHSAwEC', NULL, '2023-12-13 08:57:03', '2023-12-13 08:57:03'),
(14, 25, 'gerbang keluar barat', 'author', 'Asia/Jakarta', 'xzczxc@dasdasd', NULL, '$2y$10$AA2EDXo4EA.AEQrDBEecKeiRgnogPux6T5oZNBGyuDcKkq8RV/uX2', NULL, '2023-12-13 10:16:10', '2023-12-13 12:21:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_initial_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `serial` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `time_price_1` varchar(255) NOT NULL,
  `time_price_2` varchar(255) NOT NULL,
  `time_price_3` varchar(255) NOT NULL,
  `grace_time` varchar(255) NOT NULL,
  `grace_time_duration` varchar(255) NOT NULL,
  `limitation_time_duration` varchar(255) NOT NULL,
  `maximum_daily` tinyint(1) NOT NULL DEFAULT 0,
  `maximum_daily_price` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_initial_id`, `user_id`, `serial`, `name`, `time_price_1`, `time_price_2`, `time_price_3`, `grace_time`, `grace_time_duration`, `limitation_time_duration`, `maximum_daily`, `maximum_daily_price`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '1701057110823', 'Sedan', 'Rp. 3.000', 'Rp. 3.500', 'Rp. 3.500', 'Rp. 2.500', '30', '30', 1, 'Rp. 70.000', 0, '2023-12-13 03:30:01', '2023-12-13 03:30:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vehicle_initials`
--

CREATE TABLE `vehicle_initials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `vehicle_initials`
--

INSERT INTO `vehicle_initials` (`id`, `user_id`, `name`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'Motor', 0, '2023-12-13 03:30:01', '2023-12-13 03:30:01'),
(2, 1, 'Mobil', 0, '2023-12-13 03:30:01', '2023-12-13 03:30:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `Nama` varchar(255) NOT NULL,
  `Periode` varchar(255) NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `Tarif` varchar(255) NOT NULL,
  `Model_Pembayaran` varchar(255) NOT NULL,
  `Metode_Verifikasi` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `vouchers`
--

INSERT INTO `vouchers` (`id`, `user_id`, `Nama`, `Periode`, `vehicle_id`, `Tarif`, `Model_Pembayaran`, `Metode_Verifikasi`, `Status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'voucher 1', '10', 1, 'Rp. 5.000', 'Check In', 'No Polisi', 'Aktif', 0, '2023-12-13 03:30:01', '2023-12-13 03:30:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `voucher_plat_numbers`
--

CREATE TABLE `voucher_plat_numbers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_voucher_id` bigint(20) UNSIGNED NOT NULL,
  `plat_number` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `voucher_plat_numbers`
--

INSERT INTO `voucher_plat_numbers` (`id`, `transaction_voucher_id`, `plat_number`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, '5acv000', 0, '2023-12-13 03:30:01', '2023-12-13 09:28:52'),
(2, 1, '5acv001', 0, '2023-12-13 03:30:01', '2023-12-13 09:28:52'),
(3, 2, '5acv890', 0, '2023-12-13 03:30:01', '2023-12-13 09:29:00'),
(4, 2, '5acv890', 0, '2023-12-13 03:30:01', '2023-12-13 09:29:00'),
(5, 2, '5acv892', 0, '2023-12-13 03:30:01', '2023-12-13 09:29:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `manless_payments`
--
ALTER TABLE `manless_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `member_plat_numbers`
--
ALTER TABLE `member_plat_numbers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `printers`
--
ALTER TABLE `printers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `printer_settings`
--
ALTER TABLE `printer_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `printer_settings_flexes`
--
ALTER TABLE `printer_settings_flexes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `punishments`
--
ALTER TABLE `punishments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `serial_comunications`
--
ALTER TABLE `serial_comunications`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `site_gate_parkings`
--
ALTER TABLE `site_gate_parkings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `site_gate_parking_payments`
--
ALTER TABLE `site_gate_parking_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaction_members`
--
ALTER TABLE `transaction_members`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaction_member_logs`
--
ALTER TABLE `transaction_member_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaction_vouchers`
--
ALTER TABLE `transaction_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaction_voucher_logs`
--
ALTER TABLE `transaction_voucher_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `vehicle_initials`
--
ALTER TABLE `vehicle_initials`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `voucher_plat_numbers`
--
ALTER TABLE `voucher_plat_numbers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `manless_payments`
--
ALTER TABLE `manless_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `member_plat_numbers`
--
ALTER TABLE `member_plat_numbers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT untuk tabel `printers`
--
ALTER TABLE `printers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `printer_settings`
--
ALTER TABLE `printer_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT untuk tabel `printer_settings_flexes`
--
ALTER TABLE `printer_settings_flexes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `punishments`
--
ALTER TABLE `punishments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `serial_comunications`
--
ALTER TABLE `serial_comunications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `site_gate_parkings`
--
ALTER TABLE `site_gate_parkings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `site_gate_parking_payments`
--
ALTER TABLE `site_gate_parking_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT untuk tabel `transaction_members`
--
ALTER TABLE `transaction_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `transaction_member_logs`
--
ALTER TABLE `transaction_member_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `transaction_vouchers`
--
ALTER TABLE `transaction_vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `transaction_voucher_logs`
--
ALTER TABLE `transaction_voucher_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `vehicle_initials`
--
ALTER TABLE `vehicle_initials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `voucher_plat_numbers`
--
ALTER TABLE `voucher_plat_numbers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
