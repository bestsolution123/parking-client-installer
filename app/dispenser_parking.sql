-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 17 Nov 2023 pada 09.35
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
(1, 1, 'member1', '3', 1, 3, 'Rp. 50.000', 'Rp. 5.000', 'Rp. 10.000', '0', 0, '2023-11-16 07:51:21', '2023-11-16 08:44:25');

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
(10, 1, '1ABC', 0, '2023-11-16 16:37:31', '2023-11-16 16:38:26'),
(11, 1, '2ABC', 0, '2023-11-16 16:37:31', '2023-11-16 16:38:26'),
(12, 1, '3ABC', 0, '2023-11-16 16:37:31', '2023-11-16 16:38:26'),
(13, 1, '4ABC', 0, '2023-11-16 16:37:31', '2023-11-16 16:38:26');

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
(18, '2023_11_16_213314_create_member_plat_numbers_table', 2),
(19, '2023_11_16_213444_create_voucher_plat_numbers_table', 2);

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
(1, 'App\\Models\\User', 2, 'auth-sanctum', 'f6263129906f928702b9f9e509d5e8f38adf32c1c9519a755bc8dbb54165276a', '[\"*\"]', NULL, '2023-11-16 05:13:15', '2023-11-16 05:13:15'),
(2, 'App\\Models\\User', 2, 'auth-sanctum', '5206db35566f3e0f690e9336e1e5d78b12451f1a306b2b85cc7797348af43424', '[\"*\"]', NULL, '2023-11-16 05:14:08', '2023-11-16 05:14:08'),
(3, 'App\\Models\\User', 2, 'auth-sanctum', 'afaa0eb1f2a4cebdb7054038e9f39b3576b0e30fdc632bb003bbca52532a470b', '[\"*\"]', NULL, '2023-11-16 05:16:08', '2023-11-16 05:16:08'),
(4, 'App\\Models\\User', 2, 'auth-sanctum', 'e4104477b487efcaf20d4a7a3a0453b3a54b23263ea3829f2710f87502f57a00', '[\"*\"]', NULL, '2023-11-16 05:20:21', '2023-11-16 05:20:21'),
(5, 'App\\Models\\User', 2, 'auth-sanctum', '9f599858b14204f3421f55c7371128985e8df9f9c69be7d6ae3a601acbd6083e', '[\"*\"]', NULL, '2023-11-16 05:20:54', '2023-11-16 05:20:54'),
(6, 'App\\Models\\User', 2, 'auth-sanctum', '80c73baee4d69e1880cbe499c3a8f4b4302ee3204c492fb91ccc5477dc70313e', '[\"*\"]', NULL, '2023-11-16 05:21:05', '2023-11-16 05:21:05'),
(7, 'App\\Models\\User', 2, 'auth-sanctum', 'd04611f957ae4c94a4f3c4a54270553d23255b932c72842ecc7dd2dbb6d9fef9', '[\"*\"]', NULL, '2023-11-16 05:21:18', '2023-11-16 05:21:18'),
(8, 'App\\Models\\User', 2, 'auth-sanctum', 'eb209a7238feccacda3aa384e6a1a907727e409f20b7f085c492dabcd63d5c1f', '[\"*\"]', NULL, '2023-11-16 05:21:30', '2023-11-16 05:21:30'),
(9, 'App\\Models\\User', 2, 'auth-sanctum', 'b080c067eef02009c99b4264e4b248a3ac9bc55fcb4fbeeac5ed30b747d219e3', '[\"*\"]', NULL, '2023-11-16 05:21:35', '2023-11-16 05:21:35'),
(10, 'App\\Models\\User', 2, 'auth-sanctum', 'c6a75fb505d95da3c929f87cc64e991ec6d6f3f1ecfd309dcedeef80249ecef8', '[\"*\"]', NULL, '2023-11-16 05:22:17', '2023-11-16 05:22:17'),
(11, 'App\\Models\\User', 2, 'auth-sanctum', '0334dcbc1eb010f65fcb4cdba753652b40819a373784bc2facb83548fccab7c7', '[\"*\"]', NULL, '2023-11-16 05:22:47', '2023-11-16 05:22:47'),
(12, 'App\\Models\\User', 2, 'auth-sanctum', 'fdc2dd8755e61cad2a09d793d60ab82ebe78b786628ded2c214fcffe76aab4c1', '[\"*\"]', NULL, '2023-11-16 05:23:48', '2023-11-16 05:23:48'),
(13, 'App\\Models\\User', 2, 'auth-sanctum', '3bbfb7cb0db2c420391129811d42ba4340df3852bea92e567b8e39909888ccc7', '[\"*\"]', NULL, '2023-11-16 05:25:33', '2023-11-16 05:25:33'),
(14, 'App\\Models\\User', 2, 'auth-sanctum', '2d582b82453c758c676481feda2dd12a7e67f7732d7a1cc61c89271c6f7fc8cb', '[\"*\"]', NULL, '2023-11-16 05:27:27', '2023-11-16 05:27:27'),
(15, 'App\\Models\\User', 2, 'auth-sanctum', '65d3172aa0fb96b0b065a99af65447d63f9f9842635cc4461605a7246f2f73b4', '[\"*\"]', NULL, '2023-11-16 05:27:58', '2023-11-16 05:27:58'),
(16, 'App\\Models\\User', 2, 'auth-sanctum', '6ca573ebd637b9786f03069d7b6b51573db88121a18292cdc269378670ffc524', '[\"*\"]', NULL, '2023-11-16 05:28:18', '2023-11-16 05:28:18'),
(17, 'App\\Models\\User', 2, 'auth-sanctum', 'fef875db17025b8da1bd292611858555107646ebb03e43d1fe592a0bc201cf96', '[\"*\"]', NULL, '2023-11-16 05:29:47', '2023-11-16 05:29:47'),
(18, 'App\\Models\\User', 2, 'auth-sanctum', '9e2407442e492a5aa9f2674c40583f0932b23d1fbf5720ceacec97d0fa82a502', '[\"*\"]', NULL, '2023-11-16 05:30:23', '2023-11-16 05:30:23'),
(19, 'App\\Models\\User', 2, 'auth-sanctum', '61d1257b3bc07c25ed84c7ae542f64b88e1300cfd49d1b8d13bb78b37400576d', '[\"*\"]', '2023-11-16 05:31:03', '2023-11-16 05:30:46', '2023-11-16 05:31:03'),
(20, 'App\\Models\\User', 2, 'auth-sanctum', '0b131f523cbabbbc7f95dc37263df484e996d058cf664165d4cb4931868658e9', '[\"*\"]', '2023-11-17 05:42:11', '2023-11-16 18:28:03', '2023-11-17 05:42:11'),
(21, 'App\\Models\\User', 2, 'auth-sanctum', '6a97cb8f75f70a2a6b5b404279ed3824fea93211268b669cee2ad82c9fc03774', '[\"*\"]', NULL, '2023-11-17 07:09:49', '2023-11-17 07:09:49'),
(22, 'App\\Models\\User', 2, 'auth-sanctum', '0700ce7fa5667a8ee7e54282d5e12c979329facfb0138a45d260bb2aec101d91', '[\"*\"]', '2023-11-17 07:30:13', '2023-11-17 07:10:01', '2023-11-17 07:30:13'),
(23, 'App\\Models\\User', 2, 'auth-sanctum', '157a57cd57b2b1e0c9c5a59acd539a43513956d61e375f12cadb4fb94e2286b1', '[\"*\"]', '2023-11-17 07:33:01', '2023-11-17 07:32:24', '2023-11-17 07:33:01');

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
(1, 1, 'gerbang1', '192.168.1.90', 'LAN', '80', 0, '2023-11-16 04:57:16', '2023-11-16 04:57:16');

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
(1, 1, 1, 'Logo', 1, 0, '2023-11-16 05:01:50', '2023-11-16 05:01:50'),
(2, 1, 1, 'QRCode', 1, 0, '2023-11-16 05:01:50', '2023-11-16 05:01:50'),
(3, 1, 1, 'Plat Kendaraan', 1, 0, '2023-11-16 05:01:50', '2023-11-16 05:01:50'),
(4, 1, 1, 'Tanggal Masuk', 1, 0, '2023-11-16 05:01:50', '2023-11-16 05:01:50'),
(5, 1, 1, 'Alamat', 1, 0, '2023-11-16 05:01:50', '2023-11-16 05:01:50'),
(6, 1, 1, 'Catatan', 1, 0, '2023-11-16 05:01:50', '2023-11-16 05:01:50');

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
(1, 1, 'STNK hilang', 'Rp. 30.000', 0, '2023-11-16 05:02:04', '2023-11-16 05:02:04');

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
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `site_gate_parkings`
--

INSERT INTO `site_gate_parkings` (`id`, `user_id`, `printer_id`, `vehicle_id`, `name`, `type`, `address`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'Gerbang Timur', 'Masuk', 'Pengadilan Agama Jakarta Timur. Alamat, : Jalan Raya PKP No. 24 Kelapa Dua Wetan, Ciracas, jakarta TImur.', 0, '2023-11-16 05:01:50', '2023-11-16 05:01:50');

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
  `serial` varchar(255) NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(255) NOT NULL,
  `plat_number` varchar(255) NOT NULL,
  `in_photo` varchar(255) NOT NULL,
  `out_photo` varchar(255) NOT NULL,
  `visitor_type` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `gate_out` varchar(255) NOT NULL,
  `date_out` datetime NOT NULL,
  `date_in` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `site_gate_parking_id`, `transaction_voucher_id`, `transaction_member_id`, `serial`, `vehicle_id`, `number`, `plat_number`, `in_photo`, `out_photo`, `visitor_type`, `payment_method`, `status`, `gate_out`, `date_out`, `date_in`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 0, '1700112664436', 1, '1', 'asuuuuuuu', '-', '-', 'Regular', 'Tunai', 'STNK hilang', '-', '2023-11-17 12:52:03', '2023-11-16 12:31:04', 0, '2023-11-16 05:31:04', '2023-11-17 05:52:03'),
(2, 1, 1, 0, 0, '1700112664436', 1, '1', '2ABC', '-', '-', 'Member', 'Tunai', '-', '-', '2023-11-17 04:00:19', '2023-11-16 12:31:04', 0, '2023-11-16 05:31:04', '2023-11-16 21:00:19'),
(3, 1, 1, 0, 0, '1700112664436', 1, '1', '1ABC', '-', '-', 'Member', 'Tunai', 'Selesai', '-', '2023-11-17 12:51:33', '2023-11-16 12:31:04', 0, '2023-11-16 05:31:04', '2023-11-17 05:51:33'),
(4, 1, 1, 0, 0, '1700191768632', 1, '4', 'asuuuuuuu', '-', '-', 'Regular', '-', '-', '-', '2023-11-17 10:29:28', '2023-11-17 10:29:28', 0, '2023-11-17 03:29:28', '2023-11-17 03:29:28'),
(5, 1, 1, 0, 0, '1700199731470', 1, '5', 'asuuuuuuu', '-', '-', 'Regular', '-', '-', '-', '2023-11-17 12:42:11', '2023-11-17 12:42:11', 0, '2023-11-17 05:42:11', '2023-11-17 05:42:11'),
(6, 2, 1, 0, 0, '1700206166970', 1, '6', '123192387891', '-', '-', 'Regular', '-', '-', '-', '2023-11-17 14:29:26', '2023-11-17 14:29:26', 0, '2023-11-17 07:29:26', '2023-11-17 07:29:26'),
(7, 2, 1, 0, 0, '170020621392', 1, '7', 'meonggg', '-', '-', 'Regular', '-', '-', '-', '2023-11-17 14:30:13', '2023-11-17 14:30:13', 0, '2023-11-17 07:30:13', '2023-11-17 07:30:13'),
(8, 2, 1, 0, 0, '170020638111', 1, '8', '123192387891', '-', '-', 'Regular', '-', '-', '-', '2023-11-17 14:33:01', '2023-11-17 14:33:01', 0, '2023-11-17 07:33:01', '2023-11-17 07:33:01');

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
  `Awal_Aktif` varchar(255) NOT NULL,
  `Akhir_Aktif` varchar(255) NOT NULL,
  `Tarif_Member` varchar(255) NOT NULL,
  `Tarif_Dasar_Member` varchar(255) NOT NULL,
  `Tarif_Kartu` varchar(255) NOT NULL,
  `Total_Biaya` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaction_members`
--

INSERT INTO `transaction_members` (`id`, `user_id`, `member_id`, `serial`, `Nama`, `Akses`, `Hp`, `Email`, `Awal_Aktif`, `Akhir_Aktif`, `Tarif_Member`, `Tarif_Dasar_Member`, `Tarif_Kartu`, `Total_Biaya`, `Status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '170012539911', 'adit', 'Plat Number', '231223', 'stiker.id.1@gmail.com', '2023-11-16', '2023-11-30', 'Rp. 150.000', 'Rp. 50.000', 'Rp. 5.000', 'Rp. 155.000', '1', 0, '2023-11-16 09:03:19', '2023-11-16 17:41:05');

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
  `Awal_Aktif` varchar(255) NOT NULL,
  `Akhir_Aktif` varchar(255) NOT NULL,
  `Keterangan` varchar(255) NOT NULL,
  `Tarif` varchar(255) NOT NULL,
  `Tarif_Dasar` varchar(255) NOT NULL,
  `Total_Biaya` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaction_vouchers`
--

INSERT INTO `transaction_vouchers` (`id`, `user_id`, `voucher_id`, `serial`, `Produk`, `Awal_Aktif`, `Akhir_Aktif`, `Keterangan`, `Tarif`, `Tarif_Dasar`, `Total_Biaya`, `Status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '1700127392272', 'adit voucher', '2023-11-16', '2023-11-21', 'voucher event 17 agustus', 'Rp. 250.000', 'Rp. 50.000', 'Rp. 250.000', '0', 0, '2023-11-16 09:36:32', '2023-11-16 17:43:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_gate_parking_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
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

INSERT INTO `users` (`id`, `site_gate_parking_id`, `name`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 0, 'admin', 'admin', 'admin@gmail.com', NULL, '$2y$10$dMyJc5MjPq2vx7gZ3pMLW.t8JE1bCrNS8yToW8zgDNoSqGKRdgph6', NULL, NULL, NULL),
(2, 1, 'gerbang masuk timur', 'author', 'asd@gmail.com', NULL, '$2y$10$dMyJc5MjPq2vx7gZ3pMLW.t8JE1bCrNS8yToW8zgDNoSqGKRdgph6', NULL, '2023-11-16 05:11:01', '2023-11-16 05:20:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_initial_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `serial` varchar(2255) NOT NULL,
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

INSERT INTO `vehicles` (`id`, `vehicle_initial_id`, `user_id`, `name`, `serial`, `time_price_1`, `time_price_2`, `time_price_3`, `grace_time`, `grace_time_duration`, `limitation_time_duration`, `maximum_daily`, `maximum_daily_price`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Bajaj', '1700199280125', 'Rp. 3.000', 'Rp. 2.500', 'Rp. 2.000', 'Rp. 1.500', '30', '10', 1, 'Rp. 30.000', 0, '2023-11-16 05:01:13', '2023-11-16 05:01:13');

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
(2, 1, 'Mobil', 0, '2023-11-16 04:57:45', '2023-11-16 04:57:45'),
(3, 1, 'Motor', 0, '2023-11-16 04:57:50', '2023-11-16 04:57:50');

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
(1, 1, 'voucher1', '5', 1, 'Rp. 50.000', 'Check In', 'No Polisi', '0', 0, '2023-11-16 08:16:24', '2023-11-16 08:21:26');

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
(12, 1, '1231231', 0, '2023-11-16 17:07:20', '2023-11-16 17:07:20'),
(13, 1, 'asdasd', 0, '2023-11-16 17:07:20', '2023-11-16 17:07:20');

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
-- Indeks untuk tabel `transaction_vouchers`
--
ALTER TABLE `transaction_vouchers`
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
-- AUTO_INCREMENT untuk tabel `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `member_plat_numbers`
--
ALTER TABLE `member_plat_numbers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `printers`
--
ALTER TABLE `printers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `printer_settings`
--
ALTER TABLE `printer_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `printer_settings_flexes`
--
ALTER TABLE `printer_settings_flexes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `punishments`
--
ALTER TABLE `punishments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `serial_comunications`
--
ALTER TABLE `serial_comunications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `site_gate_parkings`
--
ALTER TABLE `site_gate_parkings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `transaction_members`
--
ALTER TABLE `transaction_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `transaction_vouchers`
--
ALTER TABLE `transaction_vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `vehicle_initials`
--
ALTER TABLE `vehicle_initials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `voucher_plat_numbers`
--
ALTER TABLE `voucher_plat_numbers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
