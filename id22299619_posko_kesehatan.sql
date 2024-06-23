-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 23, 2024 at 03:31 PM
-- Server version: 10.5.20-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id22299619_posko_kesehatan`
--

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `description`, `quantity`, `deleted`) VALUES
(5, 'Agonis Beta (NEW)', 'meredakan atau mengontrol gejala penyempitan saluran pernapasan akibat asma atau penyakit paru obstruktif kronis (PPOK)', 0, 1),
(6, 'paracetamol', 'anti nyeri', 0, 1),
(7, 'bodrex', 'meredakan sakit kepala', 990, 0),
(8, 'antangins', 'anti masuk angin', 1000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `medicine_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `name`, `medicine_id`, `quantity`, `date`) VALUES
(3, 'Imam', 5, 10, '2024-06-10 21:40:41'),
(5, 'fakhar', 6, 100, '2024-06-12 04:37:19'),
(6, 'ando', 7, 10, '2024-06-12 07:43:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'mimamhnf', '$2y$10$daaV3cNJvpCj6uUQlh/dnepoeAt/WkjAhDJxOy3IJNO8HG15bGhkO'),
(2, 'fadhlan', '$2y$10$4p9E0k7pPaQBa0zpR12sTu0qmjLjIem7IESCENMKV3u0GmLkm/qIS'),
(3, 'ajis', '$2y$10$ijj9DbwPgNrH7rL5u6Er5OpfIou4R7hC7/sdq30JvSZXBa3FIRDYq'),
(4, 'aji', '$2y$10$l7mOQq/1072O6LTuodAM2OyyZ3mArk5UVs7KcuOnPvvvGsg.HGMUy'),
(7, 'Rehan', '$2y$10$vbQtHCMe29gYMSzTLneLE.TxCrNqtYymnsc7C/Um3lC9voz3NLELW'),
(8, 'ali', '$2y$10$xBnkAM.HLjyZHIUlpvZ5euYUOwhdlZQ4zVjO07sT5xHCK2E5I2Z9i'),
(9, 'rizal', '$2y$10$/B1c2k4QAt7uIzVNrYoTNedkwl9B0JgtLxSVLEt8Ur7d993DYFfza'),
(10, 'admin', '$2y$10$2NzMsUZANjP9S16/NA8SOObSs6ZY5pc7Qs4idib4m9HqLU8dkJ7/.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
