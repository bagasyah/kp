-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2023 at 10:19 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laporan_perjalanan`
--

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `alamat_awal` varchar(255) NOT NULL,
  `alamat_tujuan` varchar(255) NOT NULL,
  `km_awal` int(255) NOT NULL,
  `km_akhir` int(255) NOT NULL,
  `no_polisi` varchar(255) NOT NULL,
  `tipe_mobil` enum('innova','triton','avanza putih','avanza veloz') NOT NULL,
  `foto` varchar(255) NOT NULL,
  `foto2` varchar(255) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `lampu_depan` enum('berfungsi','rusak') NOT NULL,
  `lampu_sen_depan` enum('berfungsi','rusak') NOT NULL,
  `lampu_sen_belakang` enum('berfungsi','rusak') NOT NULL,
  `lampu_rem` enum('berfungsi','rusak') NOT NULL,
  `lampu_mundur` enum('berfungsi','rusak') NOT NULL,
  `bodi` enum('baik','rusak') NOT NULL,
  `ban` enum('baik','rusak') NOT NULL,
  `pedal` enum('berfungsi','rusak') NOT NULL,
  `kopling` enum('berfungsi','rusak') NOT NULL,
  `gas_rem` enum('berfungsi','rusak') NOT NULL,
  `klakson` enum('baik','rusak') NOT NULL,
  `weaper` enum('berfungsi','rusak') NOT NULL,
  `air_weaper` enum('terisi','kosong') NOT NULL,
  `air_radiator` enum('terisi','kosong') NOT NULL,
  `oli_mesin` enum('terisi','kosong') NOT NULL,
  `note` varchar(255) NOT NULL,
  `status_lap` enum('approved','pending','rejected') NOT NULL,
  `jenis_perjalanan` enum('luar','dalam') NOT NULL,
  `perkiraan_bbm` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `user_id`, `alamat_awal`, `alamat_tujuan`, `km_awal`, `km_akhir`, `no_polisi`, `tipe_mobil`, `foto`, `foto2`, `tanggal`, `lampu_depan`, `lampu_sen_depan`, `lampu_sen_belakang`, `lampu_rem`, `lampu_mundur`, `bodi`, `ban`, `pedal`, `kopling`, `gas_rem`, `klakson`, `weaper`, `air_weaper`, `air_radiator`, `oli_mesin`, `note`, `status_lap`, `jenis_perjalanan`, `perkiraan_bbm`) VALUES
(65, 64, 'palembang', 'bandar lampung', 34, 65, 'be 4324 fv', 'avanza putih', 'km awal.jpg', 'km akhir.jpeg', '2023-09-10', 'berfungsi', 'rusak', 'berfungsi', 'berfungsi', 'berfungsi', 'baik', 'baik', 'berfungsi', 'berfungsi', 'berfungsi', 'baik', 'berfungsi', 'terisi', 'terisi', 'kosong', '', 'pending', 'luar', '3'),
(72, 64, 'lampung timur', 'bandar lampung', 45, 65, 'be 322 d', 'avanza veloz', 'km awal.jpg', 'km awal.jpg', '2023-12-23', 'berfungsi', 'rusak', 'berfungsi', 'rusak', 'rusak', 'baik', 'baik', 'berfungsi', 'berfungsi', 'berfungsi', 'baik', 'berfungsi', 'terisi', 'terisi', 'terisi', '', 'pending', 'luar', ''),
(74, 2, 'lampung', 'palembang', 34, 56, 'BE 1232 sd', 'triton', 'km awal.jpg', 'km akhir.jpeg', '2023-09-13', 'berfungsi', 'rusak', 'rusak', 'berfungsi', 'berfungsi', 'baik', 'baik', 'berfungsi', 'berfungsi', 'berfungsi', 'baik', 'berfungsi', 'terisi', 'terisi', 'terisi', '', 'pending', 'luar', ''),
(76, 65, 'bandar lampung', 'lampung tengah', 34, 67, 'be 545 op', 'triton', 'km awal.jpg', 'km akhir.jpeg', '2023-09-21', 'berfungsi', 'rusak', 'berfungsi', 'berfungsi', 'berfungsi', 'baik', 'baik', 'berfungsi', 'berfungsi', 'berfungsi', 'baik', 'berfungsi', 'terisi', 'terisi', 'terisi', '', 'pending', 'luar', ''),
(115, 2, 'fdsfd', 'fdsf', 54, 76, 'ferwrr', 'innova', 'km awal.jpg', 'km akhir.jpeg', '2023-10-13', 'berfungsi', 'rusak', 'berfungsi', 'berfungsi', 'berfungsi', 'baik', 'baik', 'berfungsi', 'berfungsi', 'berfungsi', 'baik', 'rusak', '', 'terisi', 'terisi', '', '', 'luar', ''),
(131, 2, 'lampung timur', 'lampung utara', 45, 77, 'BE 1232 sd', 'innova', 'km awal.jpg', 'km akhir.jpeg', '2023-10-13', 'berfungsi', 'rusak', 'berfungsi', 'berfungsi', 'berfungsi', 'baik', 'baik', 'berfungsi', 'berfungsi', 'berfungsi', 'baik', 'berfungsi', 'terisi', 'terisi', 'terisi', '', 'approved', 'luar', ''),
(133, 2, 'lampung timur', 'lampung timur', 34, 54, 'BE 1232 sd', 'innova', 'km awal.jpg', 'none.jpg', '2023-10-14', 'berfungsi', 'berfungsi', 'berfungsi', 'berfungsi', 'berfungsi', 'baik', 'baik', 'berfungsi', 'berfungsi', 'berfungsi', 'baik', 'berfungsi', 'terisi', 'terisi', 'terisi', '', 'approved', 'luar', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `status`) VALUES
(1, 'admin', 'admin', 'admin', 'approved'),
(2, 'bagas', '2345', 'user', 'approved'),
(64, 'zointa', '12345', 'user', 'approved'),
(65, 'user', 'user', 'user', 'approved'),
(66, 'bag', 'bag', 'user', 'approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
