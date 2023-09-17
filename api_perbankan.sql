-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2023 at 07:27 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api_perbankan`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun_bank`
--

CREATE TABLE `akun_bank` (
  `id_akun` int(11) NOT NULL,
  `nomor_rekening` varchar(20) NOT NULL,
  `nama_pemilik` varchar(255) NOT NULL,
  `saldo` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun_bank`
--

INSERT INTO `akun_bank` (`id_akun`, `nomor_rekening`, `nama_pemilik`, `saldo`) VALUES
(1, '46-752-4665', 'Adrien', 279878.58),
(2, '90-630-6239', 'Olympia', 339176.68),
(3, '28-015-3120', 'Waylan', 179745.44),
(4, '98-412-2772', 'Mace', 467242.13),
(5, '76-735-9062', 'Nicola', 911214.25),
(6, '71-187-7404', 'Wiatt', 664643.95),
(7, '32-788-5546', 'Nathan', 398935.91),
(8, '63-197-2953', 'Asher', 527530.35),
(9, '20-821-4403', 'Angel', 165099.84),
(10, '98-580-6718', 'Che', 412773.24);

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `id_transfer` int(11) NOT NULL,
  `id_pengirim` int(11) NOT NULL,
  `id_penerima` int(11) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `tanggal_transfer` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transfer`
--

INSERT INTO `transfer` (`id_transfer`, `id_pengirim`, `id_penerima`, `jumlah`, `tanggal_transfer`) VALUES
(1, 5, 6, 91586.76, '2023-09-15 00:08:09'),
(2, 5, 1, 23886.36, '2023-09-04 03:11:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun_bank`
--
ALTER TABLE `akun_bank`
  ADD PRIMARY KEY (`id_akun`),
  ADD UNIQUE KEY `unique_nomor_rekening` (`nomor_rekening`);

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`id_transfer`),
  ADD KEY `id_pengirim` (`id_pengirim`),
  ADD KEY `id_penerima` (`id_penerima`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun_bank`
--
ALTER TABLE `akun_bank`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transfer`
--
ALTER TABLE `transfer`
  MODIFY `id_transfer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transfer`
--
ALTER TABLE `transfer`
  ADD CONSTRAINT `transfer_ibfk_1` FOREIGN KEY (`id_pengirim`) REFERENCES `akun_bank` (`id_akun`),
  ADD CONSTRAINT `transfer_ibfk_2` FOREIGN KEY (`id_penerima`) REFERENCES `akun_bank` (`id_akun`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
