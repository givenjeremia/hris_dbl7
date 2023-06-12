-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 12 Jun 2023 pada 16.17
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_penggajian_karyawan_2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lat_masuk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long_masuk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat_pulang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long_pulang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `masuk` time DEFAULT NULL,
  `pulang` time DEFAULT NULL,
  `date` date NOT NULL,
  `lokasi_masuk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi_pulang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pegawai_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bpjs`
--

CREATE TABLE `bpjs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bpjs_tk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bpjs_kes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bpjs_ht` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pegawai_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bpjs`
--

INSERT INTO `bpjs` (`id`, `bpjs_tk`, `bpjs_kes`, `bpjs_ht`, `created_at`, `updated_at`, `pegawai_id`) VALUES
(1, '2', '6', '3', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `client`
--

CREATE TABLE `client` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `delete_at` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `client`
--

INSERT INTO `client` (`id`, `nama`, `email`, `alamat`, `lokasi`, `lat`, `long`, `created_at`, `updated_at`, `delete_at`) VALUES
(1, 'UBAYA', 'ubaya.campus@gmail.com', 'Jl. raya tenggilis', 'Surabaya', '-7.320026364797896', '112.76720133798248', NULL, NULL, 0),
(2, 'Mc Donald', 'mcdonald@gmail.com', 'Jl.Dr.Ir.H.Soekarno', 'Surabaya', '-7.2949588269199594', '112.78097879565335', NULL, NULL, 0),
(3, 'Rumah', 'rumah@gmail.com', 'Jalan raya majapahit', 'Sidoarjo', '-7.362302683528497', '112.70413464905468', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cutis`
--

CREATE TABLE `cutis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mulai` date NOT NULL,
  `akhir` date NOT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subjek` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pegawai_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

CREATE TABLE `divisi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal_tunjangan` int(11) DEFAULT NULL,
  `delete_at` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `divisi`
--

INSERT INTO `divisi` (`id`, `nama`, `nominal_tunjangan`, `delete_at`) VALUES
(1, 'HRD', 1000000, 0),
(2, 'IT Support', 500000, 0),
(3, 'OB', 50000, 0),
(4, 'Tim keamanan', 20000, 0),
(5, 'Staff OB 3', 200000000, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal_gaji` int(11) DEFAULT NULL,
  `divisi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delete_at` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama`, `nominal_gaji`, `divisi_id`, `delete_at`) VALUES
(1, 'General Manager', 10000000, 1, 0),
(2, 'Vice Manager', 7000000, 1, 0),
(3, 'Leader', 7000000, 2, 0),
(4, 'Asisten Leader', 6000000, 2, 0),
(5, 'Staff', 4500000, 4, 0),
(6, 'Leader', 2500000, 3, 0),
(7, 'Staff OB', 2000000, 3, 0),
(8, 'Staff HRD', 5000000, 1, 0),
(11, 'asdasda', 1001231, 3, 0),
(12, 'DSADAS3DSADA', 2147483647, 4, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontrak`
--

CREATE TABLE `kontrak` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kontrak`
--

INSERT INTO `kontrak` (`id`, `nama`, `tanggal_mulai`, `tanggal_akhir`, `client_id`, `created_at`, `updated_at`) VALUES
(9, 'TESTING KORUPSI', '2023-05-28', '2023-08-16', 2, NULL, NULL),
(10, 'TESTING TAMBAH', '2023-06-04', '2023-06-12', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `lemburs`
--

CREATE TABLE `lemburs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lama_lembur` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pegawai_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `lemburs`
--

INSERT INTO `lemburs` (`id`, `tanggal`, `keterangan`, `lama_lembur`, `created_at`, `updated_at`, `pegawai_id`) VALUES
(1, '2023-05-21', 'makan makan', 2, '2023-05-24 12:18:57', '2023-05-24 12:18:57', 1),
(2, '2023-05-08', 'k', 9, '2023-05-24 13:14:17', '2023-05-24 13:14:17', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2021_07_21_062729_create_permission_tables', 1),
(10, '2021_11_07_122500_create_settings_table', 1),
(11, '2022_09_13_151158_client_tabel', 1),
(12, '2022_09_15_155538_created_pegawailogin_model', 1),
(13, '2022_09_16_143545_create_login_pegawais_table', 1),
(14, '2022_09_17_142105_cutis', 1),
(15, '2022_09_17_173856_create_cutis_table', 1),
(16, '2022_09_18_160201_absensi', 1),
(17, '2022_09_22_124952_terlambat', 1),
(18, '2022_09_23_183820_create_jadwal_shifts_table', 1),
(19, '2022_10_07_012209_slug_jadwal_shift', 1),
(20, '2022_10_26_104146_devisi', 1),
(21, '2022_10_26_104203_pegawai', 1),
(22, '2022_10_26_104221_shift', 1),
(23, '2022_10_26_104239_jabatan', 1),
(24, '2022_11_06_005704_setting_absen', 1),
(25, '2022_11_19_125404_create_pendapatangajis_table', 1),
(26, '2022_11_19_125418_create_potongangajis_table', 1),
(27, '2022_11_19_125448_create_mastergajis_table', 1),
(28, '2022_11_19_125501_create_potongans_table', 1),
(29, '2022_11_19_125512_create_pendapatans_table', 1),
(30, '2022_11_19_135538_create_bpjs_table', 1),
(31, '2022_11_29_194138_test', 1),
(32, '2022_11_29_212643_create_newshifts_table', 1),
(33, '2022_12_04_150056_create_lemburs_table', 1),
(34, '2023_01_17_125140_create_reports_table', 1),
(35, '2023_03_13_145736_add_pegawaiid_column', 1),
(36, '2023_03_13_145752_add_shiftid_column', 1),
(37, '2023_03_20_190513_add_clientid_column', 1),
(38, '2023_03_20_190931_add_divisiid_column', 1),
(39, '2023_03_20_191412_add_pendapatansid_column', 1),
(40, '2023_03_20_192539_add_pendapatangajis_column', 1),
(41, '2023_03_25_143209_add_jabatanid_column', 1),
(42, '2023_05_11_143250_add_rolesid_column', 1),
(43, '2023_06_11_191345_create_kontrak_table', 2),
(44, '2023_06_11_191413_add_delete_status_column', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\User', 1),
(2, 'App\\User', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `new_jadwal_shifts`
--

CREATE TABLE `new_jadwal_shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pegawai_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shift_id` bigint(20) UNSIGNED DEFAULT NULL,
  `divisi_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `new_jadwal_shifts`
--

INSERT INTO `new_jadwal_shifts` (`id`, `tanggal`, `keterangan`, `created_at`, `updated_at`, `pegawai_id`, `shift_id`, `divisi_id`) VALUES
(1, '2023-05-07', 'Membersihkan GUdang', NULL, NULL, 2, 1, NULL),
(2, '2023-05-08', 'Membersihkan Makanan', NULL, NULL, 2, 1, NULL),
(3, '2023-05-14', 'Interview ( Jenie )', NULL, NULL, NULL, 2, 1),
(4, '2023-05-15', 'Interview ( Santi )', NULL, NULL, NULL, 2, 1),
(5, '2023-05-16', 'Interview ( Salmon )', NULL, NULL, NULL, 2, 1),
(6, '2023-05-16', 'Susu Sapi', NULL, NULL, NULL, 1, 2),
(7, '2023-05-15', 'Mengurus Server', NULL, NULL, NULL, 3, 3),
(8, '2023-05-16', 'Pagi Pagi Happy', NULL, NULL, 2, 1, NULL),
(9, '2023-05-16', 'Pagi Kuy', NULL, NULL, 1, 1, NULL),
(19, '2023-05-17', 'Pagi Test', '2023-05-16 08:24:13', '2023-05-16 08:24:13', NULL, 1, 1),
(20, '2023-05-18', 'Siang Test', '2023-05-16 08:24:13', '2023-05-16 08:24:13', NULL, 2, 1),
(21, '2023-05-19', 'Malam Test', '2023-05-16 08:24:13', '2023-05-16 08:24:13', NULL, 3, 1),
(22, '2023-05-20', 'Pagi Test 2', '2023-05-16 08:24:13', '2023-05-16 08:24:13', NULL, 1, 1),
(23, '2023-05-01', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(24, '2023-05-02', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(25, '2023-05-03', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(26, '2023-05-04', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(27, '2023-05-05', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(28, '2023-05-06', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(29, '2023-05-07', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(30, '2023-05-08', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(31, '2023-05-09', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(32, '2023-05-10', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(33, '2023-05-11', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(34, '2023-05-12', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(35, '2023-05-13', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(36, '2023-05-14', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(37, '2023-05-15', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(39, '2023-05-17', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(40, '2023-05-18', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL),
(41, '2023-05-19', NULL, '2023-05-16 08:30:27', '2023-05-16 08:30:27', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_lahir` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_rekening` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kantor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jabatan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `roles_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `delete_at` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id`, `nik`, `nama`, `tgl_lahir`, `alamat`, `no_rekening`, `kantor_id`, `jabatan_id`, `roles_id`, `created_at`, `updated_at`, `delete_at`) VALUES
(1, '1111111111111111', 'Suparno 21', '2023-05-01', 'Jl. SBY SDA No 5 Surabaya a', '100000222', 1, 8, 3, '2023-04-01 06:46:12', NULL, 0),
(2, '1121111111111112', 'Hilmi', '2023-05-01', 'Jl Kalibokor Selatan 29', '2131231', 3, 2, 3, '2023-04-01 06:46:12', NULL, 0),
(3, '1113311111111113', 'pp', '2023-06-01', 'ps', 'p1231', 1, 12, 3, '2023-06-07 11:57:42', '2023-06-07 11:59:47', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendapatans`
--

CREATE TABLE `pendapatans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nominal` int(100) DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pegawai_id` bigint(20) UNSIGNED DEFAULT NULL,
  `potongangajis_id` bigint(20) UNSIGNED DEFAULT NULL,
  `potonganbpjs_id` bigint(20) DEFAULT NULL,
  `nominal_tlb` int(100) NOT NULL,
  `nominal_lembur` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pendapatans`
--

INSERT INTO `pendapatans` (`id`, `nominal`, `status`, `created_at`, `updated_at`, `pegawai_id`, `potongangajis_id`, `potonganbpjs_id`, `nominal_tlb`, `nominal_lembur`) VALUES
(1, 5000000, 0, '2023-03-11 09:45:14', NULL, 2, 2, 1, 350000, 0),
(2, 6000000, 1, '2023-03-11 09:45:19', NULL, 1, 4, 3, 400000, 0),
(13, 5302685, 0, '2023-04-25 08:50:44', '2023-05-25 08:50:40', 1, 25, 26, 5000, 47685),
(14, 7021759, 0, '2023-04-25 08:50:40', '2023-05-25 08:50:40', 2, 27, 28, 5000, 66759),
(35, 5260000, 0, '2023-05-12 14:09:06', '2023-06-12 14:09:06', 1, 69, 70, 10000, 0),
(36, 6960000, 0, '2023-05-12 14:09:06', '2023-06-12 14:09:06', 2, 71, 72, 10000, 0),
(47, 5260000, 0, '2023-06-12 14:14:18', '2023-06-12 14:14:18', 1, 93, 94, 10000, 0),
(48, 6960000, 0, '2023-06-12 14:14:18', '2023-06-12 14:14:18', 2, 95, 96, 10000, 0),
(49, 1825381100, 0, '2023-06-12 14:14:18', '2023-06-12 14:14:18', 3, 97, 98, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view-users', 'web', NULL, NULL),
(2, 'create-users', 'web', NULL, NULL),
(3, 'edit-users', 'web', NULL, NULL),
(4, 'delete-users', 'web', NULL, NULL),
(5, 'view-roles', 'web', NULL, NULL),
(6, 'create-roles', 'web', NULL, NULL),
(7, 'edit-roles', 'web', NULL, NULL),
(8, 'delete-roles', 'web', NULL, NULL),
(9, 'setting-web', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `potongangajis`
--

CREATE TABLE `potongangajis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nominal` int(11) DEFAULT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `potongangajis`
--

INSERT INTO `potongangajis` (`id`, `nominal`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 500000, 'bpjs', NULL, NULL),
(2, 200000, 'gaji', NULL, NULL),
(3, 800000, 'bpjs', NULL, NULL),
(4, 600000, 'gaji', NULL, NULL),
(25, 200000, 'gaji', '2023-05-25 08:50:40', '2023-05-25 08:50:40'),
(26, 550000, 'bpjs', '2023-05-25 08:50:40', '2023-05-25 08:50:40'),
(27, 280000, 'gaji', '2023-05-25 08:50:40', '2023-05-25 08:50:40'),
(28, 770000, 'bpjs', '2023-05-25 08:50:40', '2023-05-25 08:50:40'),
(69, 200000, 'gaji', '2023-06-12 14:09:06', '2023-06-12 14:09:06'),
(70, 550000, 'bpjs', '2023-06-12 14:09:06', '2023-06-12 14:09:06'),
(71, 280000, 'gaji', '2023-06-12 14:09:06', '2023-06-12 14:09:06'),
(72, 770000, 'bpjs', '2023-06-12 14:09:06', '2023-06-12 14:09:06'),
(93, 200000, 'gaji', '2023-06-12 14:14:18', '2023-06-12 14:14:18'),
(94, 550000, 'bpjs', '2023-06-12 14:14:18', '2023-06-12 14:14:18'),
(95, 280000, 'gaji', '2023-06-12 14:14:18', '2023-06-12 14:14:18'),
(96, 770000, 'bpjs', '2023-06-12 14:14:18', '2023-06-12 14:14:18'),
(97, 85899346, 'gaji', '2023-06-12 14:14:18', '2023-06-12 14:14:18'),
(98, 236223201, 'bpjs', '2023-06-12 14:14:18', '2023-06-12 14:14:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uniq` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', NULL, NULL),
(2, 'super admin', 'web', NULL, NULL),
(3, 'pegawai', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_program` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `singkatan_nama_program` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instansi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_program` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_absen`
--

CREATE TABLE `setting_absen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `palingcepat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `palinglambat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_create_gaji` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `shift`
--

CREATE TABLE `shift` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_masuk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_pulang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_at` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `shift`
--

INSERT INTO `shift` (`id`, `nama`, `jam_masuk`, `jam_pulang`, `delete_at`) VALUES
(1, 'Pagi', '07.00', '15.00', 0),
(2, 'Siang', '14.00', '21.00', 0),
(3, 'Malam', '17.00', '08.00', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gambar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_pegawai` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `telp`, `gambar`, `id_pegawai`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'devasatrio', 'deva', 'deva@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$rib2HT.ZuiSlhysQdGoRl.Agkkg/v2.soiAOCyQ450sfhtN13Quxu', 'VI89zx0hqfrjbUrKSsZ87dmjclvQIxRtLpo3whtWbHEOByLwD99apOQBEObR', '2021-11-06 23:43:27', '2021-11-06 23:43:27'),
(2, 'admin', 'admin', 'admin@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$z/RDzlDkqyGPCiNgdOYO3.dqYGcOQHs07AX6pVIyGDhZqbzL14ZBO', 'YDuMvHDkGbAXcEPAi7aVazwvA0PdBJs9fElQeWvAs1uKVch13qHMM5iNhO6J', '2022-05-12 15:38:32', '2022-05-12 15:38:32'),
(3, 'Suparno', 'Suparno', 'suparno@gmail.com', NULL, NULL, '1', NULL, '$2y$10$byuRvWktvOnuA2jB3NlnV.bH5EPBvY//ojZL1.X6N5WZqVJXK/eAm', NULL, '2023-05-15 08:13:27', '2023-05-15 08:13:27'),
(4, 'Hilmi', 'Hilmi', 'hilmi@gmail.com', NULL, NULL, '2', NULL, '$2y$10$d1viWTK//zQ/C5L2tuCzLusN4ds2mnMnx9ot6TYuwyjQCny83Dkpi', NULL, '2023-05-16 06:30:00', '2023-05-16 06:30:00'),
(5, 'p', 'p', 'p@gmail.com', NULL, NULL, '3', NULL, '$2y$10$cOit974Ypcr2qyeX4wE6L.yaUjYWqYQQiVua/oZjQrIp0FUel.Jpa', NULL, '2023-06-07 11:57:43', '2023-06-07 11:57:43');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absensi_pegawai_id_foreign` (`pegawai_id`),
  ADD KEY `absensi_client_id_foreign` (`client_id`);

--
-- Indeks untuk tabel `bpjs`
--
ALTER TABLE `bpjs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bpjs_pegawai_id_foreign` (`pegawai_id`);

--
-- Indeks untuk tabel `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cutis`
--
ALTER TABLE `cutis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cutis_pegawai_id_foreign` (`pegawai_id`);

--
-- Indeks untuk tabel `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jabatan_divisi_id_foreign` (`divisi_id`);

--
-- Indeks untuk tabel `kontrak`
--
ALTER TABLE `kontrak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kontrak_client_id_foreign` (`client_id`);

--
-- Indeks untuk tabel `lemburs`
--
ALTER TABLE `lemburs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lemburs_pegawai_id_foreign` (`pegawai_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `new_jadwal_shifts`
--
ALTER TABLE `new_jadwal_shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `new_jadwal_shifts_pegawai_id_foreign` (`pegawai_id`),
  ADD KEY `new_jadwal_shifts_shift_id_foreign` (`shift_id`),
  ADD KEY `new_jadwal_shifts_divisi_id_foreign` (`divisi_id`);

--
-- Indeks untuk tabel `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indeks untuk tabel `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indeks untuk tabel `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indeks untuk tabel `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `jabatan_id` (`jabatan_id`),
  ADD UNIQUE KEY `jabatan_id_3` (`jabatan_id`),
  ADD KEY `pegawai_kantor_id_foreign` (`kantor_id`),
  ADD KEY `pegawai_roles_id_foreign` (`roles_id`),
  ADD KEY `jabatan_id_2` (`jabatan_id`);

--
-- Indeks untuk tabel `pendapatans`
--
ALTER TABLE `pendapatans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendapatans_pegawai_id_foreign` (`pegawai_id`),
  ADD KEY `pendapatans_potongangajis_id_foreign` (`potongangajis_id`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `potongangajis`
--
ALTER TABLE `potongangajis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `setting_absen`
--
ALTER TABLE `setting_absen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `bpjs`
--
ALTER TABLE `bpjs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `client`
--
ALTER TABLE `client`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `cutis`
--
ALTER TABLE `cutis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `kontrak`
--
ALTER TABLE `kontrak`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `lemburs`
--
ALTER TABLE `lemburs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `new_jadwal_shifts`
--
ALTER TABLE `new_jadwal_shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pendapatans`
--
ALTER TABLE `pendapatans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `potongangajis`
--
ALTER TABLE `potongangajis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT untuk tabel `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `setting_absen`
--
ALTER TABLE `setting_absen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `shift`
--
ALTER TABLE `shift`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `absensi_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`);

--
-- Ketidakleluasaan untuk tabel `bpjs`
--
ALTER TABLE `bpjs`
  ADD CONSTRAINT `bpjs_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`);

--
-- Ketidakleluasaan untuk tabel `cutis`
--
ALTER TABLE `cutis`
  ADD CONSTRAINT `cutis_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`);

--
-- Ketidakleluasaan untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD CONSTRAINT `jabatan_divisi_id_foreign` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`);

--
-- Ketidakleluasaan untuk tabel `kontrak`
--
ALTER TABLE `kontrak`
  ADD CONSTRAINT `kontrak_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

--
-- Ketidakleluasaan untuk tabel `lemburs`
--
ALTER TABLE `lemburs`
  ADD CONSTRAINT `lemburs_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`);

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `new_jadwal_shifts`
--
ALTER TABLE `new_jadwal_shifts`
  ADD CONSTRAINT `new_jadwal_shifts_divisi_id_foreign` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`),
  ADD CONSTRAINT `new_jadwal_shifts_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`),
  ADD CONSTRAINT `new_jadwal_shifts_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shift` (`id`);

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`),
  ADD CONSTRAINT `pegawai_kantor_id_foreign` FOREIGN KEY (`kantor_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `pegawai_roles_id_foreign` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`);

--
-- Ketidakleluasaan untuk tabel `pendapatans`
--
ALTER TABLE `pendapatans`
  ADD CONSTRAINT `pendapatans_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`),
  ADD CONSTRAINT `pendapatans_potongangajis_id_foreign` FOREIGN KEY (`potongangajis_id`) REFERENCES `potongangajis` (`id`);

--
-- Ketidakleluasaan untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
