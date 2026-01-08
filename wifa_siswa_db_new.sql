-- New database dump for CompLearn
-- Database: `wifa_siswa_db`

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `wifa_siswa_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `wifa_siswa_db`;

-- Table structure for table `materi`
CREATE TABLE `materi` (
  `id_materi` int(11) NOT NULL AUTO_INCREMENT,
  `judul_materi` varchar(150) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tipe_konten` enum('video','h5p','dokumen') DEFAULT 'video',
  `url_konten` varchar(500) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_materi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `siswa`
CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL AUTO_INCREMENT,
  `nim` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `nomor_hp` varchar(15) DEFAULT NULL,
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  PRIMARY KEY (`id_siswa`),
  UNIQUE KEY `nim` (`nim`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `progress_siswa`
CREATE TABLE `progress_siswa` (
  `id_progress` int(11) NOT NULL AUTO_INCREMENT,
  `id_siswa` int(11) NOT NULL,
  `id_materi` int(11) NOT NULL,
  `tanggal_akses` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_selesai` tinyint(1) DEFAULT 0,
  `skor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_progress`),
  KEY `id_siswa` (`id_siswa`),
  KEY `id_materi` (`id_materi`),
  CONSTRAINT `progress_siswa_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `progress_siswa_ibfk_2` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `admin`
CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Sample data for `siswa` (copied from original dump)
INSERT INTO `siswa` (`id_siswa`, `nim`, `nama_lengkap`, `email`, `password`, `kelas`, `nomor_hp`, `tanggal_daftar`, `status`) VALUES
(1, '2283', 'ridwan', 'ridwansayang040603@gmail.com', '$2y$10$PZDdaoQWdyRrYD0u6JFSMO4/yHggqPmnCp5VfdajdocbMmAVlKOuC', '12a', '', '2026-01-06 22:35:06', 'aktif');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
