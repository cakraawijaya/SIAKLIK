-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Nov 2025 pada 15.20
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
('pasien3@gmail.com', 'user_6916e97c4de5a.png', 'pasien3', 'Cecillia Putri Sagara', '$2y$10$CE4sH2JCZv/rVEUPQR3ScOEXicjU.HcuIzMsLHmyF8JqRMoXMh76i', 3),
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
('pekerja1@poliklinik.upnvjatim.ac.id', 'user_69170e8f2690c.jpg', 'pekerja1', 'Sugeng Raharjo', '$2y$10$uwNQOxF24/jQiJr/JW1NKuM1ibE3qSc7Cxyrs3f5kloX73MN0Fyi.', 2),
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
CREATE TRIGGER `trg_antrean_clean_invalid` AFTER INSERT ON `antrean` FOR EACH ROW BEGIN
    IF NOT EXISTS (SELECT 1 FROM akun_pasien WHERE username = NEW.username)
       AND NOT EXISTS (SELECT 1 FROM akun_pekerja WHERE username = NEW.username) THEN
        DELETE FROM antrean WHERE kode_antrean = NEW.kode_antrean;
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

    -- Jika antrean kosong dan sudah lewat hari baru, reset last_number
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
('INTERNAL', 20, '2025-11-14'),
('BPJS', 30, '2025-11-14'),
('UMUM', 30, '2025-11-14');

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
('PS-2025', 0);

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

--
-- Trigger `riwayat_antrean`
--
DELIMITER $$
CREATE TRIGGER `trg_riwayat_antrean_before_insert` BEFORE INSERT ON `riwayat_antrean` FOR EACH ROW BEGIN
    IF NOT EXISTS (SELECT 1 FROM akun_pasien WHERE username = NEW.username)
       AND NOT EXISTS (SELECT 1 FROM akun_pekerja WHERE username = NEW.username)
       AND NOT EXISTS (
           SELECT 1 
           FROM akun_pekerja w
           JOIN hak_akses h ON w.role_id = h.id
           WHERE h.level='admin' AND w.username = NEW.username
       )
    THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Username tidak ditemukan di akun manapun';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_riwayat_antrean_clean_invalid` AFTER INSERT ON `riwayat_antrean` FOR EACH ROW BEGIN
    IF NOT EXISTS (SELECT 1 FROM akun_pasien WHERE username = NEW.username)
       AND NOT EXISTS (SELECT 1 FROM akun_pekerja WHERE username = NEW.username) THEN
        DELETE FROM riwayat_antrean WHERE id = NEW.id;
    END IF;
END
$$
DELIMITER ;

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
  `keterangan` enum('Pihak Internal','Pihak Eksternal') NOT NULL DEFAULT 'Pihak Eksternal',
  `waktu` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayat_pasien`
--

INSERT INTO `riwayat_pasien` (`id`, `nama`, `umur`, `alamat`, `pekerjaan`, `status`, `jenis_kelamin`, `nim_nip`, `no_bpjs`, `layanan`, `keterangan`, `waktu`) VALUES
('PS-2025-001', 'Bambang Nugroho Hadi', 35, 'Jl. Merdeka 10, Surabaya', 'Pegawai', 'Rawat Jalan', 'L', '19800101-01', NULL, 'Poli Gigi', 'Pihak Internal', '2025-11-14 18:59:35'),
('PS-2025-002', 'Nurlaili Fatimah', 28, 'Jl. Diponegoro 15, Surabaya', 'Pegawai', 'Rawat Inap', 'P', '19850205-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 19:07:33'),
('PS-2025-003', 'Sugeng Raharjo', 40, 'Jl. Ahmad Yani 23, Surabaya', 'Dokter', '', 'L', '19790110-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 19:12:02'),
('PS-2025-004', 'Andreas Angkasa Wirabumi', 32, 'Jl. Pahlawan 45, Surabaya', 'Dokter', '', 'L', '19890312-01', NULL, 'Poli Gigi', 'Pihak Internal', '2025-11-14 19:15:38'),
('PS-2025-005', 'Nicko Syahputra', 29, 'Jl. Kenanga 12, Surabaya', 'Dokter', '', 'L', '19950120-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 19:25:20'),
('PS-2025-006', 'Wiranto Santoso', 45, 'Jl. Kencana 7, Surabaya', 'Dokter', 'Rawat Jalan', 'L', '19781111-01', NULL, 'Poli Gigi', 'Pihak Internal', '2025-11-14 19:27:10'),
('PS-2025-007', 'Miranda Oktaviani', 30, 'Jl. Melati 8, Surabaya', 'Perawat', '', 'P', '19930303-01', NULL, 'Poli Gigi', 'Pihak Internal', '2025-11-14 19:28:46'),
('PS-2025-008', 'Lidya Wistyawati', 27, 'Jl. Anggrek 5, Surabaya', 'Perawat', '', 'P', '19960115-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 19:32:45'),
('PS-2025-009', 'Mutmainah Zahra Nur Jannah', 31, 'Jl. Sakura 11, Surabaya', 'Pegawai', '', 'P', '19920122-01', NULL, 'Poli Gigi', 'Pihak Internal', '2025-11-14 19:34:48'),
('PS-2025-010', 'Nanda Pricila Yustianingrum', 29, 'Jl. Flamboyan 3, Surabaya', 'Pegawai', 'Rawat Inap', 'P', '19940130-01', NULL, 'Poli Gigi', 'Pihak Internal', '2025-11-14 19:38:58'),
('PS-2025-011', 'Nabilla Nur Hidayah', 26, 'Jl. Cemara 9, Surabaya', 'Perawat', '', 'P', '19980112-01', NULL, 'Poli Gigi', 'Pihak Internal', '2025-11-14 19:49:29'),
('PS-2025-012', 'Ellyana Puspita Sari', 33, 'Jl. Kenanga 20, Surabaya', 'Perawat', '', 'P', '19920120-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 19:55:37'),
('PS-2025-013', 'Adit Setya Budi', 36, 'Jl. Dahlia 4, Surabaya', 'Dokter', 'Rawat Jalan', 'L', '19890101-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 19:57:44'),
('PS-2025-014', 'Millati Putri Setya Cahyaningsih', 29, 'Jl. Anggrek 12, Surabaya', 'Perawat', '', 'P', '19940315-01', NULL, 'Poli Gigi', 'Pihak Internal', '2025-11-14 19:59:22'),
('PS-2025-015', 'Hidayat Rahman', 31, 'Jl. Melati 6, Surabaya', 'Dokter', '', 'L', '19920110-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:00:36'),
('PS-2025-016', 'Robbi Jatinagara', 38, 'Jl. Mawar 2, Surabaya', 'Pegawai', '', 'L', '19870112-01', NULL, 'Poli Gigi', 'Pihak Internal', '2025-11-14 20:02:54'),
('PS-2025-017', 'Reza Adi Bwahana', 34, 'Jl. Teratai 6, Surabaya', 'Pegawai', 'Rawat Jalan', 'L', '19890123-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:03:51'),
('PS-2025-018', 'Kurnia Mega', 28, 'Jl. Kenanga 3, Surabaya', 'Pegawai', '', 'P', '19950215-01', NULL, 'Poli Gigi', 'Pihak Internal', '2025-11-14 20:06:40'),
('PS-2025-019', 'Muhammad Sholeh Alrizky', 30, 'Jl. Flamboyan 10, Surabaya', 'Pegawai', '', 'L', '19940102-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:07:47'),
('PS-2025-020', 'Dito Alfredo', 37, 'Jl. Merpati 7, Surabaya', 'Pegawai', '', 'L', '19860105-01', NULL, 'Poli Gigi', 'Pihak Internal', '2025-11-14 20:09:57'),
('PS-2025-021', 'Alam Santoso', 33, 'Jl. Melati 14, Surabaya', 'Mahasiswa', 'Rawat Jalan', 'L', NULL, '1234567890123', 'Poli Gigi', 'Pihak Eksternal', '2025-11-14 19:03:22'),
('PS-2025-022', 'David Junanto Putra', 25, 'Jl. Kenari 21, Surabaya', 'Mahasiswa', 'Rawat Inap', 'L', NULL, '1234567890124', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 19:04:49'),
('PS-2025-023', 'Cecillia Putri Sagara', 27, 'Jl. Anggrek 2, Surabaya', 'Mahasiswa', '', 'P', NULL, '1234567890125', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 19:17:50'),
('PS-2025-024', 'Zairah Yana Humairoh', 26, 'Jl. Melati 9, Surabaya', 'Mahasiswa', '', 'P', NULL, '1234567890126', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 19:20:03'),
('PS-2025-025', 'Parjo Winarno', 38, 'Jl. Kenanga 15, Surabaya', 'Mahasiswa', '', 'L', NULL, '1234567890127', 'Poli Gigi', 'Pihak Eksternal', '2025-11-14 19:23:30'),
('PS-2025-026', 'Zahra Amanda Wijaya', 24, 'Jl. Dahlia 8, Surabaya', 'Mahasiswa', 'Rawat Jalan', 'P', NULL, '1234567890128', 'Poli Gigi', 'Pihak Eksternal', '2025-11-14 19:41:31'),
('PS-2025-027', 'Hanifah Rahma Yulia', 29, 'Jl. Melati 12, Surabaya', 'Mahasiswa', 'Rawat Inap', 'P', NULL, '1234567890129', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 19:43:29'),
('PS-2025-028', 'Putra Ardiansyah', 31, 'Jl. Anggrek 6, Surabaya', 'Mahasiswa', '', 'L', NULL, '1234567890130', 'Poli Gigi', 'Pihak Eksternal', '2025-11-14 19:44:56'),
('PS-2025-029', 'Christie Agatha', 27, 'Jl. Kenanga 8, Surabaya', 'Mahasiswa', '', 'P', NULL, '1234567890131', 'Poli Gigi', 'Pihak Eksternal', '2025-11-14 19:45:53'),
('PS-2025-030', 'Junaedi Tito Bagaswara', 35, 'Jl. Melati 1, Surabaya', 'Mahasiswa', '', 'L', NULL, '1234567890132', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 19:47:19'),
('PS-2025-031', 'Hadi Prasetyo', 28, 'Jl. Anggrek 9, Surabaya', 'Pegawai', 'Rawat Jalan', 'L', '19950228-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:11:45'),
('PS-2025-032', 'Siti Aisyah', 26, 'Jl. Melati 5, Surabaya', 'Pegawai', 'Rawat Inap', 'P', '19970103-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:13:10'),
('PS-2025-033', 'Rian Aditya', 30, 'Jl. Kenanga 16, Surabaya', 'Pegawai', '', 'L', '19940114-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:14:55'),
('PS-2025-034', 'Dewi Lestari', 32, 'Jl. Merpati 8, Surabaya', 'Perawat', '', 'P', '19920119-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:16:12'),
('PS-2025-035', 'Agus Santoso', 40, 'Jl. Melati 3, Surabaya', 'Dokter', '', 'L', '19831202-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:17:45'),
('PS-2025-036', 'Vina Oktaviani', 29, 'Jl. Anggrek 11, Surabaya', 'Perawat', 'Rawat Jalan', 'P', '19940120-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:19:01'),
('PS-2025-037', 'Herman Wijaya', 36, 'Jl. Kenanga 17, Surabaya', 'Pegawai', 'Rawat Inap', 'L', '19890105-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:20:15'),
('PS-2025-038', 'Rizki Maulana', 27, 'Jl. Melati 7, Surabaya', 'Mahasiswa', '', 'L', NULL, '1234567890133', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:21:28'),
('PS-2025-039', 'Nadia Putri', 25, 'Jl. Anggrek 13, Surabaya', 'Mahasiswa', '', 'P', NULL, '1234567890134', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:22:35'),
('PS-2025-040', 'Fajar Pratama', 30, 'Jl. Kenanga 18, Surabaya', 'Mahasiswa', '', 'L', NULL, '1234567890135', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:23:47'),
('PS-2025-041', 'Anisa Salsabila', 28, 'Jl. Dahlia 9, Surabaya', 'Pegawai', 'Rawat Jalan', 'P', '19950122-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:24:50'),
('PS-2025-042', 'Galih Prasetya', 35, 'Jl. Kenanga 19, Surabaya', 'Pegawai', 'Rawat Inap', 'L', '19890112-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:25:44'),
('PS-2025-043', 'Siska Amalia', 27, 'Jl. Anggrek 14, Surabaya', 'Perawat', '', 'P', '19940215-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:26:39'),
('PS-2025-044', 'Yoga Pratama', 31, 'Jl. Melati 10, Surabaya', 'Dokter', '', 'L', '19900102-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:27:55'),
('PS-2025-045', 'Fitria Handayani', 29, 'Jl. Kenanga 21, Surabaya', 'Perawat', '', 'P', '19940303-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:28:47'),
('PS-2025-046', 'Denny Santoso', 33, 'Jl. Melati 11, Surabaya', 'Pegawai', 'Rawat Jalan', 'L', '19890228-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:29:50'),
('PS-2025-047', 'Cahya Anggraini', 26, 'Jl. Dahlia 10, Surabaya', 'Pegawai', 'Rawat Inap', 'P', '19960215-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:30:44'),
('PS-2025-048', 'Rafli Ramadhan', 30, 'Jl. Anggrek 15, Surabaya', 'Mahasiswa', '', 'L', NULL, '1234567890136', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:31:33'),
('PS-2025-049', 'Melati Putri', 28, 'Jl. Melati 13, Surabaya', 'Mahasiswa', '', 'P', NULL, '1234567890137', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:32:27'),
('PS-2025-050', 'Fadli Pratama', 31, 'Jl. Kenanga 22, Surabaya', 'Mahasiswa', '', 'L', NULL, '1234567890138', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:33:19'),
('PS-2025-051', 'Rina Sari', 27, 'Jl. Dahlia 11, Surabaya', 'Mahasiswa', 'Rawat Jalan', 'P', NULL, '1234567890139', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:34:10'),
('PS-2025-052', 'Fadlan Akbar', 29, 'Jl. Anggrek 16, Surabaya', 'Mahasiswa', 'Rawat Inap', 'L', NULL, '1234567890140', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:35:01'),
('PS-2025-053', 'Tasya Amalia', 26, 'Jl. Melati 14, Surabaya', 'Mahasiswa', '', 'P', NULL, '1234567890141', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:35:52'),
('PS-2025-054', 'Bayu Adi', 33, 'Jl. Kenanga 23, Surabaya', 'Pegawai', '', 'L', '19890105-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:36:43'),
('PS-2025-055', 'Citra Permata', 28, 'Jl. Dahlia 12, Surabaya', 'Pegawai', '', 'P', '19950228-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:37:35'),
('PS-2025-056', 'Rendi Santoso', 36, 'Jl. Anggrek 17, Surabaya', 'Pegawai', 'Rawat Jalan', 'L', '19890111-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:38:24'),
('PS-2025-057', 'Nadia Fitri', 25, 'Jl. Melati 15, Surabaya', 'Perawat', 'Rawat Inap', 'P', '19960402-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:39:15'),
('PS-2025-058', 'Fikri Ramadhan', 30, 'Jl. Kenanga 24, Surabaya', 'Pegawai', '', 'L', '19940110-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:40:03'),
('PS-2025-059', 'Viona Melati', 27, 'Jl. Dahlia 13, Surabaya', 'Perawat', '', 'P', '19950305-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:40:54'),
('PS-2025-060', 'Rizal Fauzan', 32, 'Jl. Anggrek 18, Surabaya', 'Pegawai', '', 'L', '19890215-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:41:46'),
('PS-2025-061', 'Cindy Putri', 28, 'Jl. Melati 16, Surabaya', 'Mahasiswa', 'Rawat Jalan', 'P', NULL, '1234567890142', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:42:39'),
('PS-2025-062', 'Denny Prasetya', 35, 'Jl. Kenanga 25, Surabaya', 'Mahasiswa', 'Rawat Inap', 'L', NULL, '1234567890143', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:43:28'),
('PS-2025-063', 'Rika Amalia', 26, 'Jl. Dahlia 14, Surabaya', 'Mahasiswa', '', 'P', NULL, '1234567890144', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:44:10'),
('PS-2025-064', 'Fadil Ramadhan', 31, 'Jl. Anggrek 19, Surabaya', 'Mahasiswa', '', 'L', NULL, '1234567890145', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:44:55'),
('PS-2025-065', 'Intan Sari', 27, 'Jl. Melati 17, Surabaya', 'Mahasiswa', '', 'P', NULL, '1234567890146', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:45:47'),
('PS-2025-066', 'Rifqi Maulana', 30, 'Jl. Kenanga 26, Surabaya', 'Mahasiswa', 'Rawat Jalan', 'L', NULL, '1234567890147', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:46:36'),
('PS-2025-067', 'Nina Amalia', 28, 'Jl. Dahlia 15, Surabaya', 'Mahasiswa', 'Rawat Inap', 'P', NULL, '1234567890148', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:47:28'),
('PS-2025-068', 'Aditya Prasetyo', 32, 'Jl. Anggrek 20, Surabaya', 'Pegawai', '', 'L', '19890120-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:48:14'),
('PS-2025-069', 'Tasya Amirah', 27, 'Jl. Melati 18, Surabaya', 'Perawat', '', 'P', '19950228-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:49:02'),
('PS-2025-070', 'Fajar Nugroho', 33, 'Jl. Kenanga 27, Surabaya', 'Pegawai', '', 'L', '19890103-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:49:52'),
('PS-2025-071', 'Lina Salsabila', 26, 'Jl. Dahlia 16, Surabaya', 'Perawat', 'Rawat Jalan', 'P', '19960310-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:50:47'),
('PS-2025-072', 'Rizal Maulana', 30, 'Jl. Anggrek 21, Surabaya', 'Pegawai', 'Rawat Inap', 'L', '19940205-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:51:36'),
('PS-2025-073', 'Maya Putri', 28, 'Jl. Melati 19, Surabaya', 'Perawat', '', 'P', '19950112-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:52:22'),
('PS-2025-074', 'Dani Pratama', 32, 'Jl. Kenanga 28, Surabaya', 'Pegawai', '', 'L', '19890118-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:53:11'),
('PS-2025-075', 'Fitria Salsabila', 27, 'Jl. Dahlia 17, Surabaya', 'Perawat', '', 'P', '19950205-01', NULL, 'Poli Umum', 'Pihak Internal', '2025-11-14 20:54:02'),
('PS-2025-076', 'Galih Ramadhan', 30, 'Jl. Anggrek 22, Surabaya', 'Mahasiswa', 'Rawat Jalan', 'L', NULL, '1234567890149', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:54:55'),
('PS-2025-077', 'Nabila Putri', 28, 'Jl. Melati 20, Surabaya', 'Mahasiswa', 'Rawat Inap', 'P', NULL, '1234567890150', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:55:42'),
('PS-2025-078', 'Reza Aditya', 31, 'Jl. Kenanga 29, Surabaya', 'Mahasiswa', '', 'L', NULL, '1234567890151', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:56:31'),
('PS-2025-079', 'Citra Melati', 27, 'Jl. Dahlia 18, Surabaya', 'Mahasiswa', '', 'P', NULL, '1234567890152', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:57:20'),
('PS-2025-080', 'Fikri Prasetya', 30, 'Jl. Anggrek 23, Surabaya', 'Mahasiswa', 'Rawat Jalan', 'L', '129391240292321231', '1234567890123', 'Poli Umum', 'Pihak Eksternal', '2025-11-14 20:58:12');

--
-- Trigger `riwayat_pasien`
--
DELIMITER $$
CREATE TRIGGER `trg_riwayat_before_insert` BEFORE INSERT ON `riwayat_pasien` FOR EACH ROW BEGIN
    DECLARE v_layanan ENUM('Poli Umum','Poli Gigi');

    -- Ambil layanan terbaru dari antrean berdasarkan nama
    SELECT layanan INTO v_layanan
    FROM antrean
    WHERE nama = NEW.nama
    ORDER BY waktu_daftar DESC
    LIMIT 1;

    -- Jika tidak ada antrian, gunakan default 'Poli Umum'
    IF v_layanan IS NULL THEN
        SET NEW.layanan = 'Poli Umum';
    ELSE
        SET NEW.layanan = v_layanan;
    END IF;
END
$$
DELIMITER ;
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

CREATE DEFINER=`root`@`localhost` EVENT `hapus_antrean_harian` ON SCHEDULE EVERY 1 DAY STARTS '2025-11-04 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DELETE FROM antrean
    WHERE status_antrean = 'Selesai'
      AND waktu_daftar < CURDATE();
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
