-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2023 at 08:30 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `computer_shop_structure`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akcijos`
--

CREATE TABLE `akcijos` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(50) NOT NULL,
  `kaina` decimal(10,2) NOT NULL,
  `nauja_kaina` decimal(10,2) NOT NULL,
  `aprasymas` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `gamintojas` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akcijos_photos`
--

CREATE TABLE `akcijos_photos` (
  `id` int(11) NOT NULL,
  `akcijos_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kompiuteriu_priedai`
--

CREATE TABLE `kompiuteriu_priedai` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(50) NOT NULL,
  `kaina` decimal(10,2) NOT NULL,
  `aprasymas` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `gamintojas` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kompiuteriu_priedai_photos`
--

CREATE TABLE `kompiuteriu_priedai_photos` (
  `id` int(11) NOT NULL,
  `kompiuteriu_priedai_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monitoriai`
--

CREATE TABLE `monitoriai` (
  `id` int(11) NOT NULL,
  `gamintojas` varchar(50) NOT NULL,
  `ekrano_istrizaine` int(11) NOT NULL,
  `kaina` decimal(10,2) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `rezoliucija` varchar(50) NOT NULL,
  `lieciamas_ekranas` enum('Yes','No') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monitoriai_photos`
--

CREATE TABLE `monitoriai_photos` (
  `id` int(11) NOT NULL,
  `monitoriai_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `ram` varchar(50) NOT NULL,
  `hdd` varchar(50) NOT NULL,
  `kaina` decimal(10,2) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nesiojami_kompiuteriai_photos`
--

CREATE TABLE `nesiojami_kompiuteriai_photos` (
  `id` int(11) NOT NULL,
  `nesiojami_kompiuteriai_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staliniai_kompiuteriai`
--

CREATE TABLE `staliniai_kompiuteriai` (
  `id` int(11) NOT NULL,
  `gamintojas` varchar(50) NOT NULL,
  `procesorius` varchar(50) NOT NULL,
  `vaizdo_plokste` varchar(50) NOT NULL,
  `ram` varchar(50) NOT NULL,
  `hdd` varchar(50) NOT NULL,
  `kaina` decimal(10,2) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akcijos`
--
ALTER TABLE `akcijos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akcijos_photos`
--
ALTER TABLE `akcijos_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `akcijos_id` (`akcijos_id`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `akcijos`
--
ALTER TABLE `akcijos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `akcijos_photos`
--
ALTER TABLE `akcijos_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kompiuteriu_priedai`
--
ALTER TABLE `kompiuteriu_priedai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `kompiuteriu_priedai_photos`
--
ALTER TABLE `kompiuteriu_priedai_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `monitoriai`
--
ALTER TABLE `monitoriai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `monitoriai_photos`
--
ALTER TABLE `monitoriai_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `nesiojami_kompiuteriai`
--
ALTER TABLE `nesiojami_kompiuteriai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `staliniai_kompiuteriai`
--
ALTER TABLE `staliniai_kompiuteriai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akcijos_photos`
--
ALTER TABLE `akcijos_photos`
  ADD CONSTRAINT `akcijos_photos_ibfk_1` FOREIGN KEY (`akcijos_id`) REFERENCES `akcijos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
