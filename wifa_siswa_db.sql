-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2026 at 11:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wifa_siswa_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id_materi` int(11) NOT NULL,
  `judul_materi` varchar(150) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tipe_konten` enum('video','h5p','dokumen') DEFAULT 'video',
  `url_konten` varchar(500) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `progress_siswa`
--

CREATE TABLE `progress_siswa` (
  `id_progress` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_materi` int(11) NOT NULL,
  `tanggal_akses` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_selesai` tinyint(1) DEFAULT 0,
  `skor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `nomor_hp` varchar(15) DEFAULT NULL,
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('aktif','nonaktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nim`, `nama_lengkap`, `email`, `password`, `kelas`, `nomor_hp`, `tanggal_daftar`, `status`) VALUES
(1, '2283', 'ridwan', 'ridwansayang040603@gmail.com', '$2y$10$PZDdaoQWdyRrYD0u6JFSMO4/yHggqPmnCp5VfdajdocbMmAVlKOuC', '12a', '', '2026-01-06 22:35:06', 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`);

--
-- Indexes for table `progress_siswa`
--
ALTER TABLE `progress_siswa`
  ADD PRIMARY KEY (`id_progress`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_materi` (`id_materi`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `progress_siswa`
--
ALTER TABLE `progress_siswa`
  MODIFY `id_progress` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `progress_siswa`
--
ALTER TABLE `progress_siswa`
  ADD CONSTRAINT `progress_siswa_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`),
  ADD CONSTRAINT `progress_siswa_ibfk_2` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
