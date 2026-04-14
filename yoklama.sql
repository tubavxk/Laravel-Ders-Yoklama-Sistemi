-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 14 Nis 2026, 00:27:56
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `yoklama`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `ogrenci_id` int(11) NOT NULL,
  `ders_id` int(11) NOT NULL,
  `tarih` datetime NOT NULL,
  `durum` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `attendance`
--

INSERT INTO `attendance` (`id`, `ogrenci_id`, `ders_id`, `tarih`, `durum`) VALUES
(4, 5, 3, '2026-04-14 00:00:00', 'var'),
(5, 6, 3, '2026-04-14 00:00:00', 'var'),
(6, 5, 8, '2026-04-14 00:00:00', 'var');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `attendance_sessions`
--

CREATE TABLE `attendance_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ogretmen_id` bigint(20) UNSIGNED NOT NULL,
  `ders_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(120) NOT NULL,
  `tarih` date NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `kapanis_zamani` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `attendance_sessions`
--

INSERT INTO `attendance_sessions` (`id`, `ogretmen_id`, `ders_id`, `token`, `tarih`, `aktif`, `kapanis_zamani`, `created_at`, `updated_at`) VALUES
(1, 4, 3, '65e48996-c2ea-46b3-9df0-f9f49867f418', '2026-04-14', 0, '2026-04-13 21:30:56', '2026-04-13 21:30:42', '2026-04-13 21:30:56'),
(2, 4, 8, '6d2e7cae-80bf-49b1-b23b-949269600597', '2026-04-14', 0, '2026-04-13 21:32:35', '2026-04-13 21:32:27', '2026-04-13 21:32:35');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `ders_adi` varchar(100) DEFAULT NULL,
  `ders_kodu` varchar(50) DEFAULT NULL,
  `ogretmen_id` int(11) DEFAULT NULL,
  `gun` varchar(20) DEFAULT NULL,
  `saat` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `courses`
--

INSERT INTO `courses` (`id`, `ders_adi`, `ders_kodu`, `ogretmen_id`, `gun`, `saat`) VALUES
(3, 'Görsel Programlama', 'GÖRSEL101', 4, 'Çarşamba', '13:00'),
(4, 'İnternet Programcılığı', 'İNTERNET101', 7, 'Salı', '10:00'),
(6, 'Yapay Zeka', 'YAPAYZEKA101', 8, 'Cuma', '12:00'),
(7, 'SistemAnaliziTasarımı', 'SAT101', NULL, 'Pazartesi', '10:00'),
(8, 'Mobil Programlama', 'MOBİL101', 4, 'Pazartesi', '13:00'),
(9, 'Nesneye Yönelik Programlama', 'NESNE101', 8, 'Persembe', '10:00'),
(10, 'Sunucu İşletim Sistemleri', 'SUNUCU101', 8, 'Persembe', '13:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_14_210000_create_attendance_sessions_table', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ogrenci_ders`
--

CREATE TABLE `ogrenci_ders` (
  `id` int(11) NOT NULL,
  `ogrenci_id` int(11) NOT NULL,
  `ders_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ogrenci_ders`
--

INSERT INTO `ogrenci_ders` (`id`, `ogrenci_id`, `ders_id`) VALUES
(3, 5, 1),
(4, 5, 3),
(5, 5, 4),
(6, 6, 3),
(7, 6, 4),
(8, 6, 6),
(9, 5, 7),
(10, 5, 8),
(11, 5, 9),
(12, 5, 10);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sessions`
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
-- Tablo döküm verisi `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('44uASgnOqjTUX4TFli6v9wwzLk4F7wARTCnUZwCD', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'eyJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sIl90b2tlbiI6IjZpY2hTQm9Pa0ZIN25FY2dJQWJwUXRaOUZMeEwyV3JRMVlJeVhRaVgiLCJ1c2VyX2lkIjozLCJyb2wiOiJhZG1pbiIsIm5hbWUiOiJUdVx1MDExZmJhIn0=', 1776119130);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `rol`) VALUES
(3, 'Tuğba', 'tuba@okul.com', NULL, '1234', NULL, NULL, NULL, 'admin'),
(4, 'Şevval Yıldırım', 'sevvalyildirim@gmail.com', NULL, '1234', NULL, NULL, NULL, 'ogretmen'),
(5, 'Sevcan Kaya', 'sevcankaya@gmail.com', NULL, '1234', NULL, NULL, NULL, 'ogrenci'),
(6, 'Zeynep Aksan', 'zeynep@gmail.com', NULL, '1234', NULL, NULL, NULL, 'ogrenci'),
(7, 'Hakan Yıldırım', 'hakanyildirim@gmail.com', NULL, '1234', NULL, NULL, NULL, 'ogretmen'),
(8, 'Hande Cavşi Zaim', 'handezaim@gmail.com', NULL, '1234', NULL, NULL, NULL, 'ogretmen');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendance_sessions_token_unique` (`token`),
  ADD KEY `attendance_sessions_ders_id_tarih_index` (`ders_id`,`tarih`),
  ADD KEY `attendance_sessions_ogretmen_id_aktif_index` (`ogretmen_id`,`aktif`);

--
-- Tablo için indeksler `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ogrenci_ders`
--
ALTER TABLE `ogrenci_ders`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `ogrenci_ders`
--
ALTER TABLE `ogrenci_ders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
