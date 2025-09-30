-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 30, 2025 at 06:47 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pelindo_arsip`
--

-- --------------------------------------------------------

--
-- Table structure for table `ayam`
--

CREATE TABLE `ayam` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ayam`
--

INSERT INTO `ayam` (`id`, `nama`, `create_at`) VALUES
(1, 'IT', '2025-09-30 00:59:18'),
(2, 'utilitas', '2025-09-30 00:59:18'),
(3, 'teknik', '2025-09-30 01:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `pdf`
--

CREATE TABLE `pdf` (
  `id` int NOT NULL,
  `judul` text,
  `upload_by` varchar(255) NOT NULL,
  `ayam` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'utilitas',
  `lokasi` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `moddified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pdf_tags`
--

CREATE TABLE `pdf_tags` (
  `id` int NOT NULL,
  `pdf_id` int NOT NULL,
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user',
  `ayam` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'un_set',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `pass`, `role`, `ayam`, `create_at`) VALUES
(1, 'admin', '$2y$10$65lT84SKIpa/8USK42K2Iuj4zfNMGD2Xr1PlWRHkNK8hpTwAn7tby', 'bulu_bulul', 'IT', '2025-09-19 04:04:03'),
(7, 'biju', '$2y$10$VmGOt7dk8HvQ9Pu3BFqnm.6qVyKtSAQqJ.luYpVht/B23oQzS1vPC', 'user', 'IT', '2025-09-22 02:13:54'),
(8, 'Prabu', '$2y$10$tlbj.opJY4jukmONMhQrNO1ujcIETJFfVAOITO.hvQsQVzL0LU2M.', 'super_bulu_bulul', 'utilitas', '2025-09-23 08:51:06'),
(9, 'super-admin', '$2y$10$wglgLZ7jaLC5Ih6lS4Mk4e22Hp1ixxGsZZ9XP.y/lybrn35UmidsK', 'super_bulu_bulul', 'IT', '2025-09-29 15:18:26'),
(10, 'wakamoney', '$2y$10$DfGxFnHIqXwf2T4ev902H.tpRtnE6wfSURNmw8A7lemRwrE7Vbl7y', 'user', 'utilitas', '2025-09-30 01:03:50'),
(12, 'tester', '$2y$10$QtP2yC.HCOWqnRgsSnyqgOsTmSuSZdllLhdxRxln5M3HdJ8Z6YL4S', 'user', 'IT', '2025-09-30 04:51:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ayam`
--
ALTER TABLE `ayam`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `pdf`
--
ALTER TABLE `pdf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pdf_tags`
--
ALTER TABLE `pdf_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ayam`
--
ALTER TABLE `ayam`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pdf`
--
ALTER TABLE `pdf`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pdf_tags`
--
ALTER TABLE `pdf_tags`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
