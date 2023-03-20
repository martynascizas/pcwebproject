-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2023 at 10:24 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `computer_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `kompiuteriu_priedai`
--

CREATE TABLE `kompiuteriu_priedai` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(50) NOT NULL,
  `kaina` decimal(10,2) NOT NULL,
  `aprasymas` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kompiuteriu_priedai`
--

INSERT INTO `kompiuteriu_priedai` (`id`, `pavadinimas`, `kaina`, `aprasymas`, `photo`) VALUES
(2, 'rinkinys edited', '20.00', 'mic, and mouse, edited', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kompiuteriu_priedai_photos`
--

CREATE TABLE `kompiuteriu_priedai_photos` (
  `id` int(11) NOT NULL,
  `kompiuteriu_priedai_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kompiuteriu_priedai_photos`
--

INSERT INTO `kompiuteriu_priedai_photos` (`id`, `kompiuteriu_priedai_id`, `filename`) VALUES
(28, 2, 'priedas0.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `monitoriai`
--

CREATE TABLE `monitoriai` (
  `id` int(11) NOT NULL,
  `gamintojas` varchar(50) NOT NULL,
  `ekrano_istrizaine` int(11) NOT NULL,
  `kaina` decimal(10,2) NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `monitoriai`
--

INSERT INTO `monitoriai` (`id`, `gamintojas`, `ekrano_istrizaine`, `kaina`, `photo`) VALUES
(52, 'Dell', 15, '499.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `monitoriai_photos`
--

CREATE TABLE `monitoriai_photos` (
  `id` int(11) NOT NULL,
  `monitoriai_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `monitoriai_photos`
--

INSERT INTO `monitoriai_photos` (`id`, `monitoriai_id`, `filename`) VALUES
(39, 52, 'dell0.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `nesiojami_kompiuteriai`
--

CREATE TABLE `nesiojami_kompiuteriai` (
  `id` int(11) NOT NULL,
  `gamintojas` varchar(50) NOT NULL,
  `ekrano_istrizaine` int(11) NOT NULL,
  `procesorius` varchar(50) NOT NULL,
  `vaizdo_plokste` varchar(50) NOT NULL,
  `ram` int(11) NOT NULL,
  `hdd` int(11) NOT NULL,
  `kaina` decimal(10,2) NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nesiojami_kompiuteriai`
--

INSERT INTO `nesiojami_kompiuteriai` (`id`, `gamintojas`, `ekrano_istrizaine`, `procesorius`, `vaizdo_plokste`, `ram`, `hdd`, `kaina`, `photo`) VALUES
(4, 'Mac Pro', 13, 'M2', 'Mseries', 16, 1, '2599.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `nesiojami_kompiuteriai_photos`
--

CREATE TABLE `nesiojami_kompiuteriai_photos` (
  `id` int(11) NOT NULL,
  `nesiojami_kompiuteriai_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nesiojami_kompiuteriai_photos`
--

INSERT INTO `nesiojami_kompiuteriai_photos` (`id`, `nesiojami_kompiuteriai_id`, `filename`) VALUES
(0, 4, 'macbook_pro_13_in_silver_2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `staliniai_kompiuteriai`
--

CREATE TABLE `staliniai_kompiuteriai` (
  `id` int(11) NOT NULL,
  `gamintojas` varchar(50) NOT NULL,
  `procesorius` varchar(50) NOT NULL,
  `vaizdo_plokste` varchar(50) NOT NULL,
  `ram` int(11) NOT NULL,
  `hdd` int(11) NOT NULL,
  `kaina` decimal(10,2) NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staliniai_kompiuteriai`
--

INSERT INTO `staliniai_kompiuteriai` (`id`, `gamintojas`, `procesorius`, `vaizdo_plokste`, `ram`, `hdd`, `kaina`, `photo`) VALUES
(3, 'Dell works?', 'I5 8gen', 'AMD', 8, 240, '15.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `staliniai_kompiuteriai_photos`
--

CREATE TABLE `staliniai_kompiuteriai_photos` (
  `id` int(11) NOT NULL,
  `staliniai_kompiuteriai_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staliniai_kompiuteriai_photos`
--

INSERT INTO `staliniai_kompiuteriai_photos` (`id`, `staliniai_kompiuteriai_id`, `filename`) VALUES
(0, 2, 'pc.jfif'),
(0, 3, 'pc.jfif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kompiuteriu_priedai`
--
ALTER TABLE `kompiuteriu_priedai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kompiuteriu_priedai_photos`
--
ALTER TABLE `kompiuteriu_priedai_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kompiuteriu_priedai_id` (`kompiuteriu_priedai_id`);

--
-- Indexes for table `monitoriai`
--
ALTER TABLE `monitoriai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monitoriai_photos`
--
ALTER TABLE `monitoriai_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `monitoriai_id` (`monitoriai_id`);

--
-- Indexes for table `nesiojami_kompiuteriai`
--
ALTER TABLE `nesiojami_kompiuteriai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staliniai_kompiuteriai`
--
ALTER TABLE `staliniai_kompiuteriai`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kompiuteriu_priedai`
--
ALTER TABLE `kompiuteriu_priedai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kompiuteriu_priedai_photos`
--
ALTER TABLE `kompiuteriu_priedai_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `monitoriai`
--
ALTER TABLE `monitoriai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `monitoriai_photos`
--
ALTER TABLE `monitoriai_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `nesiojami_kompiuteriai`
--
ALTER TABLE `nesiojami_kompiuteriai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staliniai_kompiuteriai`
--
ALTER TABLE `staliniai_kompiuteriai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kompiuteriu_priedai_photos`
--
ALTER TABLE `kompiuteriu_priedai_photos`
  ADD CONSTRAINT `kompiuteriu_priedai_photos_ibfk_1` FOREIGN KEY (`kompiuteriu_priedai_id`) REFERENCES `kompiuteriu_priedai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `monitoriai_photos`
--
ALTER TABLE `monitoriai_photos`
  ADD CONSTRAINT `monitoriai_photos_ibfk_1` FOREIGN KEY (`monitoriai_id`) REFERENCES `monitoriai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
