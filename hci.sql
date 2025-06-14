-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2025 at 05:42 AM
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
-- Database: `hci`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`) VALUES
(3, 'INTEL');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(55) NOT NULL,
  `brand` varchar(55) NOT NULL,
  `stock_left` varchar(55) NOT NULL,
  `price` varchar(55) NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `brand`, `stock_left`, `price`, `archived`) VALUES
(1, 'Ryzen 5 3600g', 'AMD', '4', '6999', 0),
(4, 'Galax GeForce GTX 1650', 'Galax', '3', '7995', 1),
(5, 'MSI NVIDIAÂ® GeForce GTX 1650 D6 Ventus XS OC/XC OC V3 ', 'MSI', '18', '8679', 0),
(6, 'ASRock RX 6600 Challenger D 8GB GDDR6 128-bit Gaming Gr', 'ASRock', '10', '12495.00', 0),
(7, 'MSI GeForce RTX 3060 Ventus 2X OC 12GB GDDR6 Gaming Gra', 'MSI', '13', '16995', 1),
(8, 'GALAX NVIDIAÂ® GeForce RTXÂ™ 4060 Ti 1-Click OC 46ISL8M', 'GALAX', '7', '26705.00', 0),
(9, 'Gigabyte Rx 6600 Eagle GV-R66EAGLE-8GD 8gb 128bit GDdr6', 'Gigabyte', '4', '13795.00', 0),
(10, 'Gigabyte NVIDIAÂ® GeForce RTXÂ™ 4060 Gaming OC GV-N4060', 'Gigabyte', '1', '21228.00', 0),
(11, 'Nvision EG24S1 PRO 180HZ Flat IPS Panel 24\" Gaming Moni', 'Nvision', '5', '5044.00', 0),
(12, 'MSI Pro MP223 21.5\" 100Hz VA Monitor', 'MSI', '3', '3620.00', 0),
(13, 'Gamdias Atlas HD24CII 24\" 180HZ FHD Curved Monitor', 'Gamdias ', '3', '6000.00', 0),
(15, 'Asus VG259Q3A 25\" 180HZ FHD IPS', 'Asus ', '2', '8270.00', 0),
(16, 'Corsair CX650 650 watts 80 Plus Bronze Power Supply', 'Corsair ', '10', '3238.00', 0),
(17, 'Silverstone SST-ST50F-ES230 500 watts 80 Plus Power Sup', 'Silverstone ', '22', '1685.00', 0),
(18, 'Corsair CX550 550 watts 80 Plus Bronze Power Supply', 'Corsair ', '33', '2570.00', 0),
(19, 'MSI B450M-A Pro Max II Socket Am4 Ddr4 Motherboard', 'MSI ', '5', '3195.00', 0),
(20, 'Asrock B550M Pro SE Socket Am4 Ddr4 Motherboard', 'Asrock ', '23', '5750.00', 0),
(21, 'Intel Core I3-10100 1200 3.60GHz Comet Lake Socket Proc', 'Intel ', '23', '5062.00', 0),
(22, 'sunsilk', 'shampoo', '4', '55', 0),
(23, 'Mouse', 'Logitech', '10', '499.99', 0),
(24, 'Mouse', 'Logitech', '10', '499.99', 0),
(25, 'Mouse', 'Logitech', '0', '499.99', 0),
(26, '1', 'AMD', '2', '2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `discount_percent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `title`, `discount_percent`) VALUES
(1, 'PayDay Sale', 55),
(2, 'Black Friday', 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
