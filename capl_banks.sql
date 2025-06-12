-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2025 at 01:38 PM
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
-- Database: `dev_tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `capl_banks`
--

CREATE TABLE `capl_banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL COMMENT 'Bank Logo',
  `bank_code` varchar(255) DEFAULT NULL,
  `bank_branch` varchar(255) DEFAULT NULL,
  `account_title` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `iban` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `capl_banks`
--

INSERT INTO `capl_banks` (`id`, `user_id`, `bank_name`, `file`, `bank_code`, `bank_branch`, `account_title`, `account_number`, `iban`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, 1, 'allied', 'http://127.0.0.1:8000/uploads/banks/1749637697-WhatsApp Image 2025-05-19 at 00.13.00_324aeede.jpg', 'asa', 'isb', 'hamza', '2234333', 'sdfsdfe4ewreewr', '2025-06-11 10:22:33', '2025-06-11 10:28:17', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `capl_banks`
--
ALTER TABLE `capl_banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `capl_banks_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `capl_banks`
--
ALTER TABLE `capl_banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `capl_banks`
--
ALTER TABLE `capl_banks`
  ADD CONSTRAINT `capl_banks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `capl_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
