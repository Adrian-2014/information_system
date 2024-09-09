-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 09, 2024 at 03:46 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `information_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `nama` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `email`, `password`) VALUES
(1, 'Adrians', 'adminku@gmail.com', '111');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int NOT NULL,
  `nama` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `usia` varchar(30) NOT NULL,
  `nomor_telepon` varchar(30) NOT NULL,
  `tanggal_ditambahkan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nama`, `email`, `password`, `usia`, `nomor_telepon`, `tanggal_ditambahkan`) VALUES
(1, 'Rafi Ardian Saputra', 'rafi@gmail.com', '222', '29', '082134756692', '2024-09-04 12:44:46');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int NOT NULL,
  `pelapor` varchar(30) NOT NULL,
  `id_pelapor` varchar(30) NOT NULL,
  `email_pelapor` varchar(50) NOT NULL,
  `no_telp_pelapor` varchar(50) NOT NULL,
  `produk` varchar(30) NOT NULL,
  `kode_produk` varchar(30) NOT NULL,
  `terjual` varchar(30) NOT NULL,
  `tanggal_laporan` date NOT NULL,
  `tanggal_ditambahkan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `pelapor`, `id_pelapor`, `email_pelapor`, `no_telp_pelapor`, `produk`, `kode_produk`, `terjual`, `tanggal_laporan`, `tanggal_ditambahkan`) VALUES
(1, 'Rafi Ardian Saputra', '1', 'rafi@gmail.com', '082134756692', 'Tisu', 'a1234b', '10', '2024-09-09', '2024-09-09 02:22:08'),
(2, 'Seto', '4', 'setio4nj4y@gmail.com', '00000000000', 'Pasta Gigi', '1y6rrv', '5', '2024-09-05', '2024-09-09 02:25:08');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int NOT NULL,
  `nama` varchar(30) NOT NULL,
  `kode` varchar(30) NOT NULL,
  `stok` varchar(30) NOT NULL,
  `harga` varchar(30) NOT NULL,
  `gambar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `kode`, `stok`, `harga`, `gambar`) VALUES
(1, 'Coklat Mr. Beast', '0987A5', '75', '25000', 'Mr Beast chocolate_1725455022.jpeg'),
(7, 'Pasta Gigi', '1y6rrv', '40', '13000', 'pasta gigi_1725847257.jpg'),
(4, 'Cornetto', '3AB345S', '135', '5000', 'cornetto_1725501488.jpg'),
(5, 'Minyak Goreng', '755GF1', '50', '21000', 'minyak_1725607087.jpg'),
(2, 'Silver Queen', '97HSG5', '120', '25000', 'silver-queen_1725455792.jpg'),
(8, 'Tisu', 'a1234b', '30', '5000', 'tisu_1725847443.jpg'),
(6, 'Indomie Goreng', 'f79ge4', '20', '20000', 'indomie_1725846915.jpeg'),
(3, 'Doritos', 'Z5VV4N', '0', '12000', 'doritos_1725455974.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`kode`) USING BTREE,
  ADD UNIQUE KEY `UNIK` (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
