-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 06, 2023 at 01:36 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `PmfStorage`
--

-- --------------------------------------------------------

--
-- Table structure for table `Direktorijum`
--

CREATE TABLE `Direktorijum` (
  `IDD` int(10) UNSIGNED NOT NULL,
  `RODITELJ` int(10) DEFAULT NULL,
  `IDK` int(10) UNSIGNED NOT NULL,
  `IME` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Direktorijum`
--

INSERT INTO `Direktorijum` (`IDD`, `RODITELJ`, `IDK`, `IME`) VALUES
(1, NULL, 2, 'root'),
(2, NULL, 3, 'root'),
(3, 1, 2, 'fotografije'),
(5, 3, 2, 'zzzz'),
(6, 1, 2, 'novi'),
(7, 3, 2, 'Proba'),
(12, 6, 2, 'Proba1');

-- --------------------------------------------------------

--
-- Table structure for table `Fajl`
--

CREATE TABLE `Fajl` (
  `IDF` int(10) NOT NULL,
  `IDD` int(10) NOT NULL,
  `IME` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Fajl`
--

INSERT INTO `Fajl` (`IDF`, `IDD`, `IME`) VALUES
(1, 1, 'test1.txt'),
(2, 1, 'test2.txt'),
(12, 3, 'pug.jpg'),
(13, 3, 'kurba.jpg'),
(14, 5, 'Screenshot from 2023-01-04 16-52-43.png'),
(18, 1, 'thumb-1920-1062991.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `Korisnik`
--

CREATE TABLE `Korisnik` (
  `IDK` int(10) UNSIGNED NOT NULL,
  `USER` varchar(20) NOT NULL,
  `PASS` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Korisnik`
--

INSERT INTO `Korisnik` (`IDK`, `USER`, `PASS`) VALUES
(2, 'Radovan', 'sifra'),
(3, 'Marko', 'sifra');

-- --------------------------------------------------------

--
-- Table structure for table `Pristup`
--

CREATE TABLE `Pristup` (
  `IDP` int(10) NOT NULL,
  `IDK` int(10) NOT NULL,
  `IDD` int(10) NOT NULL,
  `IDF` int(10) NOT NULL,
  `VREME` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Pristup`
--

INSERT INTO `Pristup` (`IDP`, `IDK`, `IDD`, `IDF`, `VREME`) VALUES
(1, 2, 1, 2, '2023-01-02 16:24:32'),
(2, 2, 3, 12, '2023-01-02 16:25:45'),
(3, 2, 3, 12, '2023-01-02 16:25:52'),
(4, 2, 1, 1, '2023-01-02 16:27:27'),
(5, 2, 1, 1, '2023-01-02 16:52:53'),
(6, 2, 3, 12, '2023-01-02 16:52:57'),
(7, 2, 3, 13, '2023-01-02 17:49:25'),
(8, 2, 3, 13, '2023-01-04 17:30:46'),
(9, 2, 3, 12, '2023-01-04 17:30:52'),
(10, 2, 1, 2, '2023-01-04 17:31:05'),
(11, 2, 5, 14, '2023-01-04 17:34:46'),
(12, 2, 5, 14, '2023-01-04 17:35:11'),
(13, 2, 1, 1, '2023-01-06 00:16:14'),
(14, 2, 1, 2, '2023-01-06 00:17:29'),
(15, 2, 1, 1, '2023-01-06 00:17:41'),
(16, 2, 5, 14, '2023-01-06 00:25:38'),
(17, 2, 1, 1, '2023-01-06 00:26:10'),
(18, 2, 1, 2, '2023-01-06 00:41:18'),
(19, 2, 1, 2, '2023-01-06 00:41:43'),
(20, 2, 1, 2, '2023-01-06 00:43:22'),
(21, 2, 3, 12, '2023-01-06 00:44:08'),
(22, 2, 3, 12, '2023-01-06 00:45:10'),
(23, 2, 1, 2, '2023-01-06 00:45:37'),
(24, 2, 1, 2, '2023-01-06 00:45:46'),
(25, 2, 1, 2, '2023-01-06 00:48:39'),
(26, 2, 3, 12, '2023-01-06 00:48:52'),
(27, 2, 1, 1, '2023-01-06 01:10:21'),
(28, 2, 3, 12, '2023-01-06 01:10:38'),
(29, 2, 3, 12, '2023-01-06 01:11:07'),
(30, 2, 3, 12, '2023-01-06 01:11:18'),
(31, 2, 3, 12, '2023-01-06 01:11:21'),
(32, 2, 1, 1, '2023-01-06 01:11:24'),
(33, 2, 1, 1, '2023-01-06 01:11:30'),
(34, 2, 1, 1, '2023-01-06 01:21:32'),
(35, 2, 1, 1, '2023-01-06 01:21:35'),
(36, 2, 3, 12, '2023-01-06 01:21:41'),
(37, 2, 3, 12, '2023-01-06 01:21:46'),
(38, 2, 1, 15, '2023-01-06 01:23:21'),
(39, 2, 1, 17, '2023-01-06 01:28:08'),
(40, 2, 1, 18, '2023-01-06 01:31:50'),
(41, 2, 1, 1, '2023-01-06 01:33:55'),
(42, 2, 1, 18, '2023-01-06 01:33:57'),
(43, 2, 1, 1, '2023-01-06 01:34:04'),
(44, 2, 1, 18, '2023-01-06 01:34:34'),
(45, 2, 1, 1, '2023-01-06 01:34:39'),
(46, 2, 1, 17, '2023-01-06 01:34:45'),
(47, 2, 1, 17, '2023-01-06 01:34:47'),
(48, 2, 1, 1, '2023-01-06 01:34:55'),
(49, 2, 1, 18, '2023-01-06 01:35:00'),
(50, 2, 1, 2, '2023-01-06 01:35:11'),
(51, 2, 1, 18, '2023-01-06 01:35:15'),
(52, 2, 1, 18, '2023-01-06 01:35:25'),
(53, 2, 3, 13, '2023-01-06 01:35:42'),
(54, 2, 3, 13, '2023-01-06 01:35:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Direktorijum`
--
ALTER TABLE `Direktorijum`
  ADD PRIMARY KEY (`IDD`);

--
-- Indexes for table `Fajl`
--
ALTER TABLE `Fajl`
  ADD PRIMARY KEY (`IDF`,`IDD`);

--
-- Indexes for table `Korisnik`
--
ALTER TABLE `Korisnik`
  ADD PRIMARY KEY (`IDK`);

--
-- Indexes for table `Pristup`
--
ALTER TABLE `Pristup`
  ADD PRIMARY KEY (`IDP`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Direktorijum`
--
ALTER TABLE `Direktorijum`
  MODIFY `IDD` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `Fajl`
--
ALTER TABLE `Fajl`
  MODIFY `IDF` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `Korisnik`
--
ALTER TABLE `Korisnik`
  MODIFY `IDK` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Pristup`
--
ALTER TABLE `Pristup`
  MODIFY `IDP` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
