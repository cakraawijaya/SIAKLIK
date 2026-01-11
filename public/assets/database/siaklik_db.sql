-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Jan 2026 pada 08.02
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siaklik_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun_pasien`
--

CREATE TABLE `akun_pasien` (
  `email` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT 'default.png',
  `username` varchar(20) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akun_pasien`
--

INSERT INTO `akun_pasien` (`email`, `foto`, `username`, `nama`, `password`, `role_id`) VALUES
('pasien10@gmail.com', 'default.png', 'pasien10', 'Junaedi Tito Bagaswara', '$2y$10$RkBCT2k0pUHU41xfkBqgiubiNImMpp0GrTHcMJmXS74wniZkP62xC', 3),
('pasien1@gmail.com', 'default.png', 'pasien1', 'Alam Santoso', '$2y$10$eEDzN57vxB09.TI3CC4QVOFyuHtJfVIW0MgChjXU1vvRrrW.yUsB.', 3),
('pasien2@gmail.com', 'default.png', 'pasien2', 'David Junanto Putra', '$2y$10$GcHw9MnyvQch4r82vYehq.q09JAE3.v6mVcV3YYK3SsPNz41BA27K', 3),
('pasien3@gmail.com', 'default.png', 'pasien3', 'Cecillia Putri Sagara', '$2y$10$CE4sH2JCZv/rVEUPQR3ScOEXicjU.HcuIzMsLHmyF8JqRMoXMh76i', 3),
('pasien4@gmail.com', 'default.png', 'pasien4', 'Zairah Yana Humairoh', '$2y$10$eFE1SMXIVRynUdx76pLRceSuI4yX4RWh/c78Id.gzM.a84GtjDpsG', 3),
('pasien5@gmail.com', 'default.png', 'pasien5', 'Parjo Winarno', '$2y$10$ZF3s16C2KFGMmJvGTIOLOuqJNh5IUNguiLWIOjl1BkyDnAAPRQEHy', 3),
('pasien6@gmail.com', 'default.png', 'pasien6', 'Zahra Amanda Wijaya', '$2y$10$nnXNHRpwvb5TZyOsdI/O4O30m1FZZDks9Qw8dbQaRni0vpZo1SVWi', 3),
('pasien7@gmail.com', 'default.png', 'pasien7', 'Hanifah Rahma Yulia', '$2y$10$/WhYQwR0PzNLD8jqvkrLz.b3LyahmSqDJ8BjWR0cK6apKEDFzU5S.', 3),
('pasien8@gmail.com', 'default.png', 'pasien8', 'Putra Ardiansyah', '$2y$10$lskxyJtfCjStQamou1LJ3.X7.inUA/SmKM4rD9LUfgxahi7Ps0/x2', 3),
('pasien9@gmail.com', 'default.png', 'pasien9', 'Christie Agatha', '$2y$10$eBj6e8mFWV6Cv5fMdeeLT.UZDnxqikK8JW0xZt4xOwGA5GMhBzI1u', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun_pekerja`
--

CREATE TABLE `akun_pekerja` (
  `email` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT 'default.png',
  `username` varchar(20) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akun_pekerja`
--

INSERT INTO `akun_pekerja` (`email`, `foto`, `username`, `nama`, `password`, `role_id`) VALUES
('admin10@poliklinik.upnvjatim.ac.id', 'default.png', 'admin10', 'Dito Alfredo', '$2y$10$He36mE/9HpkzQIeL/qThJ.mHRzdmiMVfHqOZdPhjZLA4Pix.ahC82', 1),
('admin1@poliklinik.upnvjatim.ac.id', 'default.png', 'admin1', 'Bambang Nugroho Hadi', '$2y$10$TzMqpIUReds1NiRfJ04Ixug9mA1X/EO5aBPsaBFHbqOyfpr83Vqtu', 1),
('admin2@poliklinik.upnvjatim.ac.id', 'default.png', 'admin2', 'Nurlaili Fatimah', '$2y$10$emThpU23uukGj0mRO9tLDuTQZd6q/cwSE1nqjx1Paya9XWax30tiq', 1),
('admin3@poliklinik.upnvjatim.ac.id', 'default.png', 'admin3', 'Lidya Wistyawati', '$2y$10$uaHZmAFQUl0Yh7C7tKOhKu4a1o6PsZfMfYZiI0/6/o9w0hKjPbqum', 1),
('admin4@poliklinik.upnvjatim.ac.id', 'default.png', 'admin4', 'Mutmainah Zahra Nur Jannah', '$2y$10$Zj0WmrcGiKaZAOcxO1Mg0eGWpvpZBaftLaPVEL/.g0.yqEPF56LnW', 1),
('admin5@poliklinik.upnvjatim.ac.id', 'default.png', 'admin5', 'Nanda Pricila Yustianingrum', '$2y$10$jU55RGmF/5MplYLrrD4unOcRAiBeeqOAfH8znr6EB8YRRsRMo300a', 1),
('admin6@poliklinik.upnvjatim.ac.id', 'default.png', 'admin6', 'Robbi Jatinagara', '$2y$10$JHmGZy172PBF5m8Np9AlrO1LB2RcNcDGUU4jpXz0W337G3NneYNNe', 1),
('admin7@poliklinik.upnvjatim.ac.id', 'default.png', 'admin7', 'Reza Adi Bwahana', '$2y$10$8LbwUFnUnVVy1x7ThxZlSuqPZdwkcyXlKTo7CwziAtlPH5Ztijqgm', 1),
('admin8@poliklinik.upnvjatim.ac.id', 'default.png', 'admin8', 'Kurnia Mega', '$2y$10$7u58nTYDmf3XKnYhGvMm7uvhIOmsgdEVVcuWQb3qq8i/vlqa4rSGa', 1),
('admin9@poliklinik.upnvjatim.ac.id', 'default.png', 'admin9', 'Muhammad Sholeh Alrizky', '$2y$10$hpDLhSfWfUmdXHQyddAjTuXXbSWUW8a1jI59RtuSjvGbdFAcEAODi', 1),
('pekerja10@poliklinik.upnvjatim.ac.id', 'default.png', 'pekerja10', 'Hidayat Rahman', '$2y$10$H3dDqtCBVPshFiRZMCsRAuADYvugCl1Xy5veEmFejZ.WB6nbB634.', 2),
('pekerja1@poliklinik.upnvjatim.ac.id', 'default.png', 'pekerja1', 'Sugeng Raharjo', '$2y$10$uwNQOxF24/jQiJr/JW1NKuM1ibE3qSc7Cxyrs3f5kloX73MN0Fyi.', 2),
('pekerja2@poliklinik.upnvjatim.ac.id', 'default.png', 'pekerja2', 'Andreas Angkasa Wirabumi', '$2y$10$9ky0RDkZpS0w3EAxO8/7XeQVTuP8g5QlrQh4BmKQ1BZjMU.03S8SC', 2),
('pekerja3@poliklinik.upnvjatim.ac.id', 'default.png', 'pekerja3', 'Nicko Syahputra', '$2y$10$PURXyY.qY91h3Yvfi24em.QV/QKhPUXmM3RGqGsm44qJGNWms5hsu', 2),
('pekerja4@poliklinik.upnvjatim.ac.id', 'default.png', 'pekerja4', 'Wiranto Santoso', '$2y$10$pfgqU2vgmAXFocJdm6DXeuT1LsSKUtC4SltZVU34OnXZ6/24i4vzO', 2),
('pekerja5@poliklinik.upnvjatim.ac.id', 'default.png', 'pekerja5', 'Miranda Oktaviani', '$2y$10$rKjqsT8eBrjfSnrX7NQDc.mmlHO9TVbX/m6mfGAqQEZt4LG05a3g6', 2),
('pekerja6@poliklinik.upnvjatim.ac.id', 'default.png', 'pekerja6', 'Nabilla Nur Hidayah', '$2y$10$N52O08EJwZCkOD/yBMnQHeBh5yjMKGhLbidOlq9.x5WHSLKe1nP3q', 2),
('pekerja7@poliklinik.upnvjatim.ac.id', 'default.png', 'pekerja7', 'Ellyana Puspita Sari', '$2y$10$S10eVuTKLS1uABy00PjRLeY/rfL60sEFkviiZZ/W1BQKBOgC.4ezi', 2),
('pekerja8@poliklinik.upnvjatim.ac.id', 'default.png', 'pekerja8', 'Adit Setya Budi', '$2y$10$VibkIXsIXaF5MFxwCEUL3.pGHCpOMNlUp37JLSYiBPq/.2mWwV0ii', 2),
('pekerja9@poliklinik.upnvjatim.ac.id', 'default.png', 'pekerja9', 'Millati Putri Setya Cahyaningsih', '$2y$10$LFgOyTAx4CFaNoiULnSVZ.2uZfq3q0Cq80F3kqY4dpC6/U9QZehV6', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `antrean`
--

CREATE TABLE `antrean` (
  `kode_antrean` varchar(8) NOT NULL,
  `username` varchar(20) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `layanan` enum('Poli Umum','Poli Gigi') NOT NULL DEFAULT 'Poli Umum',
  `kategori` enum('INTERNAL','BPJS','UMUM') NOT NULL DEFAULT 'UMUM',
  `status_antrean` enum('Menunggu','Dilayani','Selesai') NOT NULL DEFAULT 'Menunggu',
  `waktu_daftar` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `antrean`
--

INSERT INTO `antrean` (`kode_antrean`, `username`, `nama`, `layanan`, `kategori`, `status_antrean`, `waktu_daftar`) VALUES
('A0001', 'admin1', 'Bambang Nugroho Hadi', 'Poli Gigi', 'INTERNAL', 'Menunggu', '2025-11-14 18:59:35'),
('A0002', 'admin2', 'Nurlaili Fatimah', 'Poli Umum', 'INTERNAL', 'Menunggu', '2025-11-14 19:07:33'),
('A0003', 'pekerja1', 'Sugeng Raharjo', 'Poli Gigi', 'INTERNAL', 'Menunggu', '2025-11-14 19:12:02'),
('A0004', 'pekerja2', 'Andreas Angkasa Wirabumi', 'Poli Gigi', 'INTERNAL', 'Menunggu', '2025-11-14 19:15:38'),
('A0005', 'pekerja3', 'Nicko Syahputra', 'Poli Gigi', 'INTERNAL', 'Menunggu', '2025-11-14 19:25:20'),
('A0006', 'pekerja4', 'Wiranto Santoso', 'Poli Umum', 'INTERNAL', 'Menunggu', '2025-11-14 19:27:10'),
('A0007', 'pekerja5', 'Miranda Oktaviani', 'Poli Gigi', 'INTERNAL', 'Menunggu', '2025-11-14 19:28:46'),
('A0008', 'admin3', 'Lidya Wistyawati', 'Poli Umum', 'INTERNAL', 'Menunggu', '2025-11-14 19:32:45'),
('A0009', 'admin4', 'Mutmainah Zahra Nur Jannah', 'Poli Umum', 'INTERNAL', 'Menunggu', '2025-11-14 19:34:48'),
('A0010', 'admin5', 'Nanda Pricila Yustianingrum', 'Poli Gigi', 'INTERNAL', 'Menunggu', '2025-11-14 19:38:58'),
('A0011', 'pekerja6', 'Nabilla Nur Hidayah', 'Poli Gigi', 'INTERNAL', 'Menunggu', '2025-11-14 19:49:29'),
('A0012', 'pekerja7', 'Ellyana Puspita Sari', 'Poli Umum', 'INTERNAL', 'Menunggu', '2025-11-14 19:55:37'),
('A0013', 'pekerja8', 'Adit Setya Budi', 'Poli Umum', 'INTERNAL', 'Menunggu', '2025-11-14 19:57:44'),
('A0014', 'pekerja9', 'Millati Putri Setya Cahyaningsih', 'Poli Gigi', 'INTERNAL', 'Menunggu', '2025-11-14 19:59:22'),
('A0015', 'pekerja10', 'Hidayat Rahman', 'Poli Gigi', 'INTERNAL', 'Menunggu', '2025-11-14 20:00:36'),
('A0016', 'admin6', 'Robbi Jatinagara', 'Poli Gigi', 'INTERNAL', 'Menunggu', '2025-11-14 20:02:54'),
('A0017', 'admin7', 'Reza Adi Bwahana', 'Poli Umum', 'INTERNAL', 'Menunggu', '2025-11-14 20:03:51'),
('A0018', 'admin8', 'Kurnia Mega', 'Poli Gigi', 'INTERNAL', 'Menunggu', '2025-11-14 20:06:40'),
('A0019', 'admin9', 'Muhammad Sholeh Alrizky', 'Poli Umum', 'INTERNAL', 'Menunggu', '2025-11-14 20:07:47'),
('A0020', 'admin10', 'Dito Alfredo', 'Poli Umum', 'INTERNAL', 'Menunggu', '2025-11-14 20:09:57'),
('B0001', 'admin1', 'Bambang Nugroho Hadi', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 18:59:42'),
('B0002', 'pasien1', 'Alam Santoso', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 19:03:22'),
('B0003', 'pasien2', 'David Junanto Putra', 'Poli Gigi', 'BPJS', 'Menunggu', '2025-11-14 19:04:49'),
('B0004', 'admin2', 'Nurlaili Fatimah', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 19:07:42'),
('B0005', 'pekerja1', 'Sugeng Raharjo', 'Poli Gigi', 'BPJS', 'Menunggu', '2025-11-14 19:12:09'),
('B0006', 'pekerja2', 'Andreas Angkasa Wirabumi', 'Poli Gigi', 'BPJS', 'Menunggu', '2025-11-14 19:15:42'),
('B0007', 'pasien3', 'Cecillia Putri Sagara', 'Poli Gigi', 'BPJS', 'Menunggu', '2025-11-14 19:17:50'),
('B0008', 'pasien4', 'Zairah Yana Humairoh', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 19:20:03'),
('B0009', 'pasien5', 'Parjo Winarno', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 19:23:30'),
('B0010', 'pekerja3', 'Nicko Syahputra', 'Poli Gigi', 'BPJS', 'Menunggu', '2025-11-14 19:25:24'),
('B0011', 'pekerja4', 'Wiranto Santoso', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 19:27:14'),
('B0012', 'pekerja5', 'Miranda Oktaviani', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 19:28:50'),
('B0013', 'admin3', 'Lidya Wistyawati', 'Poli Gigi', 'BPJS', 'Menunggu', '2025-11-14 19:32:50'),
('B0014', 'admin4', 'Mutmainah Zahra Nur Jannah', 'Poli Gigi', 'BPJS', 'Menunggu', '2025-11-14 19:34:53'),
('B0015', 'admin5', 'Nanda Pricila Yustianingrum', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 19:39:02'),
('B0016', 'pasien6', 'Zahra Amanda Wijaya', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 19:41:31'),
('B0017', 'pasien7', 'Hanifah Rahma Yulia', 'Poli Gigi', 'BPJS', 'Menunggu', '2025-11-14 19:43:29'),
('B0018', 'pasien8', 'Putra Ardiansyah', 'Poli Gigi', 'BPJS', 'Menunggu', '2025-11-14 19:44:56'),
('B0019', 'pasien9', 'Christie Agatha', 'Poli Gigi', 'BPJS', 'Menunggu', '2025-11-14 19:45:53'),
('B0020', 'pasien10', 'Junaedi Tito Bagaswara', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 19:47:19'),
('B0021', 'pekerja6', 'Nabilla Nur Hidayah', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 19:49:37'),
('B0022', 'pekerja7', 'Ellyana Puspita Sari', 'Poli Gigi', 'BPJS', 'Menunggu', '2025-11-14 19:55:41'),
('B0023', 'pekerja8', 'Adit Setya Budi', 'Poli Gigi', 'BPJS', 'Menunggu', '2025-11-14 19:57:52'),
('B0024', 'pekerja9', 'Millati Putri Setya Cahyaningsih', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 19:59:26'),
('B0025', 'pekerja10', 'Hidayat Rahman', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 20:00:40'),
('B0026', 'admin6', 'Robbi Jatinagara', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 20:02:57'),
('B0027', 'admin7', 'Reza Adi Bwahana', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 20:03:55'),
('B0028', 'admin8', 'Kurnia Mega', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 20:06:44'),
('B0029', 'admin9', 'Muhammad Sholeh Alrizky', 'Poli Gigi', 'BPJS', 'Menunggu', '2025-11-14 20:07:52'),
('B0030', 'admin10', 'Dito Alfredo', 'Poli Umum', 'BPJS', 'Menunggu', '2025-11-14 20:10:02'),
('C0001', 'admin1', 'Bambang Nugroho Hadi', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 18:59:50'),
('C0002', 'pasien1', 'Alam Santoso', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 19:03:28'),
('C0003', 'pasien2', 'David Junanto Putra', 'Poli Umum', 'UMUM', 'Menunggu', '2025-11-14 19:04:57'),
('C0004', 'admin2', 'Nurlaili Fatimah', 'Poli Umum', 'UMUM', 'Menunggu', '2025-11-14 19:07:50'),
('C0005', 'pekerja1', 'Sugeng Raharjo', 'Poli Umum', 'UMUM', 'Menunggu', '2025-11-14 19:12:23'),
('C0006', 'pekerja2', 'Andreas Angkasa Wirabumi', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 19:15:47'),
('C0007', 'pasien3', 'Cecillia Putri Sagara', 'Poli Umum', 'UMUM', 'Menunggu', '2025-11-14 19:17:56'),
('C0008', 'pasien4', 'Zairah Yana Humairoh', 'Poli Umum', 'UMUM', 'Menunggu', '2025-11-14 19:20:41'),
('C0009', 'pasien5', 'Parjo Winarno', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 19:23:34'),
('C0010', 'pekerja3', 'Nicko Syahputra', 'Poli Umum', 'UMUM', 'Menunggu', '2025-11-14 19:25:28'),
('C0011', 'pekerja4', 'Wiranto Santoso', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 19:27:20'),
('C0012', 'pekerja5', 'Miranda Oktaviani', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 19:28:55'),
('C0013', 'admin3', 'Lidya Wistyawati', 'Poli Umum', 'UMUM', 'Menunggu', '2025-11-14 19:32:55'),
('C0014', 'admin4', 'Mutmainah Zahra Nur Jannah', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 19:34:58'),
('C0015', 'admin5', 'Nanda Pricila Yustianingrum', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 19:39:08'),
('C0016', 'pasien6', 'Zahra Amanda Wijaya', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 19:41:38'),
('C0017', 'pasien7', 'Hanifah Rahma Yulia', 'Poli Umum', 'UMUM', 'Menunggu', '2025-11-14 19:43:38'),
('C0018', 'pasien8', 'Putra Ardiansyah', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 19:45:00'),
('C0019', 'pasien9', 'Christie Agatha', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 19:45:58'),
('C0020', 'pasien10', 'Junaedi Tito Bagaswara', 'Poli Umum', 'UMUM', 'Menunggu', '2025-11-14 19:47:24'),
('C0021', 'pekerja6', 'Nabilla Nur Hidayah', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 19:49:41'),
('C0022', 'pekerja7', 'Ellyana Puspita Sari', 'Poli Umum', 'UMUM', 'Menunggu', '2025-11-14 19:55:47'),
('C0023', 'pekerja8', 'Adit Setya Budi', 'Poli Umum', 'UMUM', 'Menunggu', '2025-11-14 19:58:00'),
('C0024', 'pekerja9', 'Millati Putri Setya Cahyaningsih', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 19:59:31'),
('C0025', 'pekerja10', 'Hidayat Rahman', 'Poli Umum', 'UMUM', 'Menunggu', '2025-11-14 20:00:44'),
('C0026', 'admin6', 'Robbi Jatinagara', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 20:03:01'),
('C0027', 'admin7', 'Reza Adi Bwahana', 'Poli Umum', 'UMUM', 'Menunggu', '2025-11-14 20:04:00'),
('C0028', 'admin8', 'Kurnia Mega', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 20:06:48'),
('C0029', 'admin9', 'Muhammad Sholeh Alrizky', 'Poli Umum', 'UMUM', 'Menunggu', '2025-11-14 20:07:56'),
('C0030', 'admin10', 'Dito Alfredo', 'Poli Gigi', 'UMUM', 'Menunggu', '2025-11-14 20:10:34');

--
-- Trigger `antrean`
--
DELIMITER $$
CREATE TRIGGER `trg_antrean_before_insert` BEFORE INSERT ON `antrean` FOR EACH ROW BEGIN
    IF (NOT EXISTS (SELECT 1 FROM akun_pasien WHERE username = NEW.username))
       AND (NOT EXISTS (SELECT 1 FROM akun_pekerja WHERE username = NEW.username)) THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Username pada antrian tidak ditemukan di akun_pasien atau akun_pekerja';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_antrean_before_update` BEFORE UPDATE ON `antrean` FOR EACH ROW BEGIN
    IF NEW.username IS NOT NULL AND NEW.username <> OLD.username THEN
        IF (NOT EXISTS (SELECT 1 FROM akun_pasien WHERE username = NEW.username))
           AND (NOT EXISTS (SELECT 1 FROM akun_pekerja WHERE username = NEW.username)) THEN
            SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'Username baru pada antrian tidak ditemukan di akun_pasien atau akun_pekerja';
        END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_antrean_isi_nama` BEFORE INSERT ON `antrean` FOR EACH ROW BEGIN
    DECLARE nama_temp VARCHAR(255);

    -- Cek di akun_pekerja
    SELECT nama INTO nama_temp
    FROM akun_pekerja
    WHERE username = NEW.username
    LIMIT 1;

    -- Jika tidak ditemukan di akun_pekerja, cek di akun_pasien
    IF nama_temp IS NULL THEN
        SELECT nama INTO nama_temp
        FROM akun_pasien
        WHERE username = NEW.username
        LIMIT 1;
    END IF;

    -- Isi nama otomatis (fallback)
    SET NEW.nama = IFNULL(nama_temp, 'Tidak Diketahui');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_antrean_reset_last_number` AFTER DELETE ON `antrean` FOR EACH ROW BEGIN
    DECLARE remaining_count INT;
    DECLARE last_reset_date DATE;

    -- Hitung jumlah antrean tersisa di kategori yang sama
    SELECT COUNT(*) INTO remaining_count
    FROM antrean
    WHERE kategori = OLD.kategori;

    -- Ambil tanggal terakhir reset dari tabel hitung_antrean
    SELECT last_reset INTO last_reset_date
    FROM hitung_antrean
    WHERE kategori = OLD.kategori
    LIMIT 1;

    -- Jika antrean kosong dan sudah lewat hari, baru reset last_number
    IF remaining_count = 0 AND last_reset_date < CURDATE() THEN
        UPDATE hitung_antrean
        SET last_number = 0, last_reset = CURDATE()
        WHERE kategori = OLD.kategori;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id` int(1) NOT NULL,
  `level` enum('admin','pekerja','pasien') NOT NULL DEFAULT 'pasien'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hak_akses`
--

INSERT INTO `hak_akses` (`id`, `level`) VALUES
(1, 'admin'),
(2, 'pekerja'),
(3, 'pasien');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hitung_antrean`
--

CREATE TABLE `hitung_antrean` (
  `kategori` enum('INTERNAL','BPJS','UMUM','') NOT NULL DEFAULT 'UMUM',
  `last_number` int(4) NOT NULL DEFAULT 0,
  `last_reset` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hitung_antrean`
--

INSERT INTO `hitung_antrean` (`kategori`, `last_number`, `last_reset`) VALUES
('INTERNAL', 20, '2025-11-18'),
('BPJS', 30, '2025-11-18'),
('UMUM', 30, '2025-11-18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hitung_pasien`
--

CREATE TABLE `hitung_pasien` (
  `id_pasien` varchar(100) NOT NULL,
  `last_number` int(100) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hitung_pasien`
--

INSERT INTO `hitung_pasien` (`id_pasien`, `last_number`) VALUES
('PS-2025', 25);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_aktivitas`
--

CREATE TABLE `riwayat_aktivitas` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `role` enum('Admin','Pekerja','Pasien') NOT NULL,
  `aksi` varchar(255) NOT NULL,
  `detail` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayat_aktivitas`
--

INSERT INTO `riwayat_aktivitas` (`id`, `username`, `role`, `aksi`, `detail`, `created_at`) VALUES
(1, 'pasien2', 'Pasien', 'Login', 'David Junanto Putra telah Login.', '2026-01-08 20:27:28'),
(2, 'pasien2', 'Pasien', 'Timeout', 'David Junanto Putra telah di Logout paksa oleh Sistem.', '2026-01-08 20:32:41'),
(3, 'pekerja1', 'Pekerja', 'Login', 'Sugeng Raharjo telah Login.', '2026-01-08 20:33:43'),
(4, 'pekerja1', 'Pekerja', 'Timeout', 'Sugeng Raharjo telah di Logout paksa oleh Sistem.', '2026-01-08 20:38:55'),
(5, 'admin2', 'Admin', 'Login', 'Nurlaili Fatimah telah Login.', '2026-01-08 20:40:55'),
(6, 'admin2', 'Admin', 'Timeout', 'Nurlaili Fatimah telah di Logout paksa oleh Sistem.', '2026-01-08 20:46:48'),
(7, 'pasien3', 'Pasien', 'Login', 'Cecillia Putri Sagara telah Login.', '2026-01-09 08:24:22'),
(8, 'pasien3', 'Pasien', 'Logout', 'Cecillia Putri Sagara telah Logout.', '2026-01-09 08:24:31'),
(9, 'pekerja5', 'Pekerja', 'Login', 'Miranda Oktaviani telah Login.', '2026-01-09 08:25:24'),
(10, 'pekerja5', 'Pekerja', 'Logout', 'Miranda Oktaviani telah Logout.', '2026-01-09 08:25:32'),
(11, 'admin3', 'Admin', 'Login', 'Lidya Wistyawati telah Login.', '2026-01-09 08:26:50'),
(12, 'admin3', 'Admin', 'Logout', 'Lidya Wistyawati telah Logout.', '2026-01-09 08:26:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_antrean`
--

CREATE TABLE `riwayat_antrean` (
  `id` int(11) NOT NULL,
  `kode_antrean` varchar(8) NOT NULL,
  `username` varchar(20) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `layanan` enum('Poli Umum','Poli Gigi','','') NOT NULL DEFAULT 'Poli Umum',
  `kategori` enum('INTERNAL','BPJS','UMUM','') NOT NULL DEFAULT 'UMUM',
  `status_antrean` enum('Menunggu','Dilayani','Selesai','') NOT NULL DEFAULT 'Menunggu',
  `waktu_daftar` datetime NOT NULL,
  `waktu_selesai` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_pasien`
--

CREATE TABLE `riwayat_pasien` (
  `id` varchar(100) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `umur` int(3) NOT NULL,
  `alamat` varchar(130) NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `status` enum('Rawat Inap','Rawat Jalan','Observasi','Pasca Rawat Inap') NOT NULL DEFAULT 'Rawat Jalan',
  `jenis_kelamin` enum('L','P') NOT NULL DEFAULT 'L',
  `nim_nip` varchar(18) DEFAULT NULL,
  `no_bpjs` varchar(13) DEFAULT NULL,
  `layanan` enum('Poli Umum','Poli Gigi') NOT NULL DEFAULT 'Poli Umum',
  `kategori` enum('Internal','Eksternal') NOT NULL DEFAULT 'Eksternal',
  `keterangan` varchar(255) DEFAULT NULL,
  `waktu` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayat_pasien`
--

INSERT INTO `riwayat_pasien` (`id`, `nama`, `umur`, `alamat`, `pekerjaan`, `status`, `jenis_kelamin`, `nim_nip`, `no_bpjs`, `layanan`, `kategori`, `keterangan`, `waktu`) VALUES
('PS-2025-0001', 'Bambang Nugroho Hadi', 50, 'Jl. Merdeka 10, Surabaya', 'Admin Poliklinik', 'Rawat Jalan', 'L', '202511140000000001', '2511140000001', 'Poli Gigi', 'Internal', 'Pemasangan Crown', '2025-11-14 18:59:35'),
('PS-2025-0002', 'Nurlaili Fatimah', 50, 'Jl. Diponegoro 15, Sidoarjo', 'Admin Poliklinik', 'Rawat Inap', 'P', '202511140000000002', '2511140000002', 'Poli Umum', 'Internal', 'Tipes', '2025-11-14 19:07:33'),
('PS-2025-0003', 'Sugeng Raharjo', 40, 'Jl. Ahmad Yani 23, Mojokerto', 'Dokter Umum', 'Observasi', 'L', '202511140000000003', '2511140000003', 'Poli Umum', 'Internal', 'Sakit Perut', '2025-11-14 19:12:02'),
('PS-2025-0004', 'Ellyana Puspita Sari', 32, 'Jl. Pahlawan 45, Surabaya', 'Dokter Gigi', 'Rawat Jalan', 'P', '202511140000000004', '2511140000004', 'Poli Gigi', 'Internal', 'Pemasangan Crown', '2025-11-14 19:15:38'),
('PS-2025-0005', 'Nicko Syahputra', 29, 'Jl. Kenanga 12, Jombang', 'Perawat', 'Observasi', 'L', '202511140000000005', '2511140000005', 'Poli Umum', 'Internal', 'Sakit Kepala', '2025-11-14 19:25:20'),
('PS-2025-0006', 'Wiranto Santoso', 30, 'Jl. Kencana 7, Gresik', 'Perawat', 'Rawat Jalan', 'L', '202511140000000006', '2511140000006', 'Poli Gigi', 'Internal', 'Tambal Gigi', '2025-11-14 19:27:10'),
('PS-2025-0007', 'Miranda Oktaviani', 30, 'Jl. Melati 8, Trenggalek', 'Perawat', 'Rawat Jalan', 'P', '202511140000000007', '2511140000007', 'Poli Gigi', 'Internal', 'Pemasangan Crown', '2025-11-14 19:28:46'),
('PS-2025-0008', 'Lidya Wistyawati', 38, 'Jl. Anggrek 5, Kediri', 'Admin Poliklinik', 'Pasca Rawat Inap', 'P', '202511140000000008', '2511140000008', 'Poli Umum', 'Internal', 'DBD', '2025-11-14 19:32:45'),
('PS-2025-0009', 'Mutmainah Zahra Nur Jannah', 42, 'Jl. Sakura 11, Mojokerto', 'Admin Poliklinik', 'Observasi', 'P', '202511140000000009', '2511140000009', 'Poli Gigi', 'Internal', 'Pembersihan Karang Gigi', '2025-11-14 19:34:48'),
('PS-2025-0010', 'Nanda Pricila Yustianingrum', 49, 'Jl. Flamboyan 3, Lamongan', 'Admin Poliklinik', 'Rawat Inap', 'P', '202511140000000010', '2511140000010', 'Poli Umum', 'Internal', 'Tipes', '2025-11-14 19:38:58'),
('PS-2025-0011', 'Nabilla Nur Hidayah', 36, 'Jl. Cemara 9, Banyuwangi', 'Dokter Gigi', 'Rawat Jalan', 'P', '202511140000000011', '2511140000011', 'Poli Gigi', 'Internal', 'Gigi Sensitif', '2025-11-14 19:49:29'),
('PS-2025-0012', 'Andreas Angkasa Wirabumi', 33, 'Jl. Kenanga 20, Jombang', 'Perawat', 'Rawat Inap', 'L', '202511140000000012', '2511140000012', 'Poli Umum', 'Internal', 'Patah Tulang Kaki', '2025-11-14 19:55:37'),
('PS-2025-0013', 'Adit Setya Budi', 36, 'Jl. Dahlia 4, Jombang', 'Dokter Umum', 'Observasi', 'L', '202511140000000013', '2511140000013', 'Poli Umum', 'Internal', 'Sakit Perut', '2025-11-14 19:57:44'),
('PS-2025-0014', 'Millati Putri Setya Cahyaningsih', 29, 'Jl. Anggrek 12, Kediri', 'Dokter Gigi', 'Observasi', 'P', '202511140000000014', '2511140000014', 'Poli Gigi', 'Internal', 'Pembersihan Karang Gigi', '2025-11-14 19:59:22'),
('PS-2025-0015', 'Hidayat Rahman', 31, 'Jl. Melati 6, Trenggalek', 'Dokter Umum', 'Pasca Rawat Inap', 'L', '202511140000000015', '2511140000015', 'Poli Umum', 'Internal', 'Patah Tulang Kaki', '2025-11-14 20:00:36'),
('PS-2025-0016', 'Robbi Jatinagara', 38, 'Jl. Mawar 2, Mojokerto', 'Admin Poliklinik', 'Rawat Jalan', 'L', '202511140000000016', '2511140000016', 'Poli Gigi', 'Internal', 'Tambal Gigi', '2025-11-14 20:02:54'),
('PS-2025-0017', 'Reza Adi Bwahana', 34, 'Jl. Teratai 6, Madiun', 'Admin Poliklinik', 'Rawat Jalan', 'L', '202511140000000017', '2511140000017', 'Poli Umum', 'Internal', 'Kesleo Tangan', '2025-11-14 20:03:51'),
('PS-2025-0018', 'Kurnia Mega', 28, 'Jl. Kenanga 3, Jombang', 'Admin Poliklinik', 'Observasi', 'L', '202511140000000018', '2511140000018', 'Poli Gigi', 'Internal', 'Pembersihan Karang Gigi', '2025-11-14 20:06:40'),
('PS-2025-0019', 'Muhammad Sholeh Alrizky', 30, 'Jl. Flamboyan 10, Lamongan', 'Admin Poliklinik', 'Rawat Jalan', 'L', '202511140000000019', '2511140000019', 'Poli Umum', 'Internal', 'Kesleo Kaki', '2025-11-14 20:07:47'),
('PS-2025-0020', 'Dito Alfredo', 37, 'Jl. Merpati 7, Gresik', 'Admin Poliklinik', 'Rawat Jalan', 'L', '202511140000000020', '2511140000020', 'Poli Gigi', 'Internal', 'Tambal Gigi', '2025-11-14 20:09:57'),
('PS-2025-0021', 'Alam Santoso', 19, 'Jl. Melati 14, Trenggalek', 'Mahasiswa', 'Rawat Jalan', 'L', '202511140000000021', '2511140000021', 'Poli Gigi', 'Internal', 'Pemasangan Crown', '2025-11-14 19:03:22'),
('PS-2025-0022', 'David Junanto Putra', 20, 'Jl. Kenari 21, Malang', 'Mahasiswa', 'Rawat Inap', 'L', '202511140000000022', '2511140000022', 'Poli Umum', 'Internal', 'Tipes', '2025-11-14 19:04:49'),
('PS-2025-0023', 'Cecillia Putri Sagara', 27, 'Jl. Anggrek 2, Kediri', 'Marketing Indihome', 'Observasi', 'P', '202511140000000023', '2511140000023', 'Poli Umum', 'Eksternal', 'Radang Tenggorokan', '2025-11-14 19:17:50'),
('PS-2025-0024', 'Zairah Yana Humairoh', 21, 'Jl. Melati 9, Trenggalek', 'Mahasiswa', 'Rawat Inap', 'P', '202511140000000024', '2511140000024', 'Poli Umum', 'Internal', 'DBD', '2025-11-14 19:20:03'),
('PS-2025-0025', 'Parjo Winarno', 38, 'Jl. Kenanga 15, Jombang', 'Kontraktor', 'Observasi', 'L', '202511140000000025', '2511140000025', 'Poli Gigi', 'Eksternal', 'Cabut Gigi', '2025-11-14 19:23:30');

--
-- Trigger `riwayat_pasien`
--
DELIMITER $$
CREATE TRIGGER `trg_riwayat_pasien_after_delete` AFTER DELETE ON `riwayat_pasien` FOR EACH ROW BEGIN
    DECLARE total INT;

    -- Hitung sisa data
    SELECT COUNT(*) INTO total FROM riwayat_pasien;

    -- Jika sudah kosong, update last_number
    IF total = 0 THEN
        UPDATE hitung_pasien
        SET last_number = 0;
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun_pasien`
--
ALTER TABLE `akun_pasien`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_akun_pasien_hakakses` (`role_id`);

--
-- Indeks untuk tabel `akun_pekerja`
--
ALTER TABLE `akun_pekerja`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_akun_pekerja_hakakses` (`role_id`);

--
-- Indeks untuk tabel `antrean`
--
ALTER TABLE `antrean`
  ADD PRIMARY KEY (`kode_antrean`),
  ADD UNIQUE KEY `uk_antrean_kode` (`kode_antrean`),
  ADD KEY `waktu_daftar` (`waktu_daftar`);

--
-- Indeks untuk tabel `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `level` (`level`);

--
-- Indeks untuk tabel `hitung_antrean`
--
ALTER TABLE `hitung_antrean`
  ADD PRIMARY KEY (`kategori`);

--
-- Indeks untuk tabel `hitung_pasien`
--
ALTER TABLE `hitung_pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `riwayat_aktivitas`
--
ALTER TABLE `riwayat_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `created_at` (`created_at`);

--
-- Indeks untuk tabel `riwayat_antrean`
--
ALTER TABLE `riwayat_antrean`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_riwayat_antrean_akun` (`username`);

--
-- Indeks untuk tabel `riwayat_pasien`
--
ALTER TABLE `riwayat_pasien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waktu_daftar` (`waktu`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `hak_akses`
--
ALTER TABLE `hak_akses`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `riwayat_aktivitas`
--
ALTER TABLE `riwayat_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `riwayat_antrean`
--
ALTER TABLE `riwayat_antrean`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `akun_pasien`
--
ALTER TABLE `akun_pasien`
  ADD CONSTRAINT `fk_akun_pasien_hakakses` FOREIGN KEY (`role_id`) REFERENCES `hak_akses` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `akun_pekerja`
--
ALTER TABLE `akun_pekerja`
  ADD CONSTRAINT `fk_akun_pekerja_hakakses` FOREIGN KEY (`role_id`) REFERENCES `hak_akses` (`id`) ON UPDATE CASCADE;

DELIMITER $$
--
-- Event
--
CREATE DEFINER=`root`@`localhost` EVENT `hapus_riwayat_antrean_harian` ON SCHEDULE EVERY 1 DAY STARTS '2025-11-04 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DELETE FROM riwayat_antrean
    WHERE waktu_daftar < CURDATE();
END$$

CREATE DEFINER=`root`@`localhost` EVENT `hapus_antrean_harian` ON SCHEDULE EVERY 1 DAY STARTS '2026-01-07 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    -- Hapus antrean yang sudah selesai
    -- atau lebih dari 1 hari dari waktu daftar
    -- atau waktu daftar sudah jauh di masa lalu (tahun berbeda dari sekarang)
    DELETE FROM antrean
    WHERE status_antrean = 'Selesai'
       OR waktu_daftar < NOW() - INTERVAL 1 DAY
       OR YEAR(waktu_daftar) < YEAR(NOW());
END$$

CREATE DEFINER=`root`@`localhost` EVENT `hapus_riwayat_aktivitas_mingguan` ON SCHEDULE EVERY 1 DAY STARTS '2026-01-08 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DELETE FROM riwayat_aktivitas
    WHERE created_at < NOW() - INTERVAL 7 DAY;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
