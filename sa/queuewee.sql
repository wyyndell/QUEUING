-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2024 at 12:02 PM
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
-- Database: `queuewee`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(90) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `office` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(15) NOT NULL,
  `accessibility` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `fname`, `lname`, `office`, `password`, `status`, `accessibility`) VALUES
(3, '@cashier', 'Ryan', 'Villalon', 'Cashier', '@1234', '', 'enable'),
(12, '@registrar', 'Ednalyn', 'Pureza', 'Registrar', '@1234', '', ''),
(23, '@accounting', 'Jenny', 'Llano', 'Accounting', '@1234', '', 'enable'),
(27, '@lab', 'Don', 'Pescadero', 'Com Lab', '@1234', '', 'enable');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `client_number` int(10) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `selected_office` varchar(255) NOT NULL,
  `selected_services` text DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `name`, `gender`, `address`, `email`, `phone`, `client_number`, `user_type`, `selected_office`, `selected_services`, `reg_date`) VALUES
(1, 'wendell', 'male', 'unisan quezon', 'atienzawendell48@gmail.com', '09167775616', 12, 'visitor', 'Com Lab', 'Designing', '2024-04-28 13:04:09');

-- --------------------------------------------------------

--
-- Table structure for table `review_data`
--

CREATE TABLE `review_data` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `client_number` varchar(255) DEFAULT NULL,
  `request` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `time_arrive` timestamp NOT NULL DEFAULT current_timestamp(),
  `office` text NOT NULL,
  `transaction` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review_data`
--

INSERT INTO `review_data` (`id`, `name`, `gender`, `number`, `address`, `email`, `client_number`, `request`, `occupation`, `time_arrive`, `office`, `transaction`) VALUES
(425, 'Ruszel Saavedra', 'female', '', 'Adia Bitaog', 'wendellatienza7@gmail.com', '025454841', 'Designing', 'student', '2024-04-29 09:46:54', 'Com Lab', '');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `office` varchar(90) NOT NULL,
  `services` varchar(90) NOT NULL,
  `accessibility` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `office`, `services`, `accessibility`) VALUES
(4, 'Cashier', 'Payment', 'enable'),
(6, 'Registrar', 'Transcript of Records TOR', ''),
(7, 'Registrar', 'Diploma', ''),
(9, 'Accounting', 'assessment', ''),
(41, 'Comlab', 'Repairing', ''),
(55, 'Registrar', 'Enrollment', ''),
(63, 'Com Lab', 'Designing', 'enable');

-- --------------------------------------------------------

--
-- Table structure for table `serving`
--

CREATE TABLE `serving` (
  `id` int(11) NOT NULL,
  `client_number` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `office` varchar(255) DEFAULT NULL,
  `transaction` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `serving`
--

INSERT INTO `serving` (`id`, `client_number`, `name`, `office`, `transaction`, `created_at`) VALUES
(261, '90', 'wendell', 'Registrar', 'serving', '2024-04-28 15:33:27'),
(262, '90', 'wendell', 'Registrar', 'serving', '2024-04-28 15:33:54'),
(263, '', NULL, 'Registrar', 'serving', '2024-04-28 15:34:07'),
(264, '32', 'Garry Field', 'Registrar', 'serving', '2024-04-29 08:58:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review_data`
--
ALTER TABLE `review_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `serving`
--
ALTER TABLE `serving`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `review_data`
--
ALTER TABLE `review_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=426;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `serving`
--
ALTER TABLE `serving`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
