-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2024 at 10:18 PM
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
-- Database: `db_tubes_spk`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `alternatif_id` int(11) NOT NULL,
  `alternatif_kode` varchar(50) NOT NULL,
  `alternatif_nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`alternatif_id`, `alternatif_kode`, `alternatif_nama`) VALUES
(0, 'A1', 'Sapi Limousinn'),
(2, 'A3', 'Sapi Madura'),
(3, 'A4', 'Sapi PO'),
(4, 'A5', 'Sapi FH'),
(5, 'A6', 'Sapi Simental');

-- --------------------------------------------------------

--
-- Table structure for table `hewan`
--

CREATE TABLE `hewan` (
  `hewan_id` int(11) NOT NULL,
  `hewan_foto` varchar(255) DEFAULT NULL,
  `alternatif_id` int(11) DEFAULT NULL,
  `kriteria_id` int(11) DEFAULT NULL,
  `opsi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hewan`
--

INSERT INTO `hewan` (`hewan_id`, `hewan_foto`, `alternatif_id`, `kriteria_id`, `opsi_id`) VALUES
(1, 'limousin.jpeg', 0, 7, 1),
(3, 'madura.jpeg', 2, 2, 1),
(4, 'PO.jpeg', 3, 5, 1),
(5, 'Simental.jpeg', 5, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `kriteria_id` int(11) NOT NULL,
  `kriteria_kode` varchar(50) NOT NULL,
  `kriteria_nama` varchar(255) DEFAULT NULL,
  `bobot` float DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`kriteria_id`, `kriteria_kode`, `kriteria_nama`, `bobot`, `status`) VALUES
(1, 'C1', 'Umur', 2, 'benefit'),
(2, 'C2', 'Berat', 1.5, 'benefit'),
(3, 'C3', 'Kesehatan', 0.25, 'benefit'),
(5, 'C5', 'Lingkungan', 0.15, 'benefit'),
(6, 'C6', 'Perawatan Hewan Kurban', 0.1, 'benefit'),
(7, 'C7', 'Metode Pembayaran', 0.05, 'benefit'),
(8, 'C4', 'Harga', 1, 'cost');

-- --------------------------------------------------------

--
-- Table structure for table `opsi_kriteria`
--

CREATE TABLE `opsi_kriteria` (
  `opsi_id` int(11) NOT NULL,
  `opsi_nama` varchar(255) NOT NULL,
  `nilai` int(11) NOT NULL,
  `kriteria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `opsi_kriteria`
--

INSERT INTO `opsi_kriteria` (`opsi_id`, `opsi_nama`, `nilai`, `kriteria_id`) VALUES
(1, 'Muda', 3, 1),
(2, 'Ideal', 5, 1),
(3, 'Tua', 3, 1),
(4, 'Kurang', 1, 2),
(5, 'Ideal', 3, 2),
(6, 'Lebih', 5, 2),
(7, 'Sehat', 5, 3),
(8, 'Sakit ringan', 3, 3),
(12, 'Bersih', 5, 5),
(13, 'Cukup bersih', 3, 5),
(14, 'Kotor', 1, 5),
(15, 'Rutin', 5, 6),
(16, 'Cukup Rutin', 4, 6),
(17, 'Jarang', 3, 6),
(18, 'Tunai & Non-tunai', 5, 7),
(19, 'Hanya Tunai / Non-tunai', 3, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`alternatif_id`);

--
-- Indexes for table `hewan`
--
ALTER TABLE `hewan`
  ADD PRIMARY KEY (`hewan_id`),
  ADD KEY `alternatif_id` (`alternatif_id`),
  ADD KEY `kriteria_id` (`kriteria_id`),
  ADD KEY `opsi_id` (`opsi_id`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`kriteria_id`);

--
-- Indexes for table `opsi_kriteria`
--
ALTER TABLE `opsi_kriteria`
  ADD PRIMARY KEY (`opsi_id`),
  ADD KEY `kriteria_id` (`kriteria_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `alternatif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hewan`
--
ALTER TABLE `hewan`
  MODIFY `hewan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `kriteria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `opsi_kriteria`
--
ALTER TABLE `opsi_kriteria`
  MODIFY `opsi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hewan`
--
ALTER TABLE `hewan`
  ADD CONSTRAINT `hewan_ibfk_1` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`kriteria_id`),
  ADD CONSTRAINT `hewan_ibfk_2` FOREIGN KEY (`alternatif_id`) REFERENCES `alternatif` (`alternatif_id`),
  ADD CONSTRAINT `penilaian_ibfk_3` FOREIGN KEY (`opsi_id`) REFERENCES `opsi_kriteria` (`opsi_id`);

--
-- Constraints for table `opsi_kriteria`
--
ALTER TABLE `opsi_kriteria`
  ADD CONSTRAINT `opsi_kriteria_ibfk_1` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`kriteria_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
