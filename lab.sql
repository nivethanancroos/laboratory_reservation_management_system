-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2024 at 05:39 PM
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
-- Database: `lab`
--

-- --------------------------------------------------------

--
-- Table structure for table `issued`
--

CREATE TABLE `issued` (
  `issue_id` int(11) NOT NULL,
  `issue_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `due_date` timestamp NULL DEFAULT NULL,
  `return_date` timestamp NULL DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `officer_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issued`
--

INSERT INTO `issued` (`issue_id`, `issue_date`, `due_date`, `return_date`, `item_id`, `officer_id`, `student_id`) VALUES
(85, '2024-05-04 04:15:36', '2024-05-18 00:45:36', '2024-05-04 04:16:32', 43, 3, 39),
(86, '2024-05-04 04:15:43', '2024-05-18 00:45:43', '2024-05-04 04:16:35', 45, 3, 39),
(88, '2024-05-05 12:51:29', '2024-05-19 09:21:29', '2024-05-05 12:53:13', 43, 3, 36),
(89, '2024-05-05 12:51:31', '2024-05-19 09:21:31', NULL, 42, 3, 36),
(90, '2024-05-05 12:51:35', '2024-05-19 09:21:35', '2024-05-05 12:53:15', 46, 3, 36),
(91, '2024-05-05 12:51:37', '2024-05-19 09:21:37', NULL, 44, 3, 36);

-- --------------------------------------------------------

--
-- Table structure for table `lab_item`
--

CREATE TABLE `lab_item` (
  `item_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_item`
--

INSERT INTO `lab_item` (`item_id`, `name`, `price`) VALUES
(42, 'Ammeter', 1538.00),
(43, 'Oscilloscope', 648.00),
(44, 'Microscopes', 269.00),
(45, 'Jumper Wires ', 269.00),
(46, 'Arduino Uno', 3700.00),
(47, 'LED Diode', 73.00),
(48, 'Resistor Kit', 1538.00),
(49, 'Breadboard', 648.00),
(53, 'Multimeter', 73.00),
(54, 'Resistor Kit', 1538.00),
(58, 'Wire', 250.00),
(59, 'Stop watch', 300.00),
(60, 'Digital Calipers', 450.00);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `request_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `student_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`request_id`, `timestamp`, `student_id`, `item_name`) VALUES
(235, '2024-05-05 15:30:32', 37, 'Oscilloscope');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `email`, `password`, `name`) VALUES
(36, 'nivethanancroos14@gmail.com', 'nivethanan123', 'Anton Nivethanan'),
(37, 'Shakithiyan@gmail.com', 'Shaki2000', 'Shakiththiyan'),
(38, 'Keerthikan@gmail.com', 'keerthi123', 'Jeganathan keerthikan'),
(39, 'Kiruthikan@gmail.com', 'Kiruthi2000', 'Kiruthikan'),
(40, 'Mathanraj@gmail.com', 'Mathan234', 'Mathan Raj');

-- --------------------------------------------------------

--
-- Table structure for table `technical_officer`
--

CREATE TABLE `technical_officer` (
  `officer_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `technical_officer`
--

INSERT INTO `technical_officer` (`officer_id`, `email`, `password`, `name`) VALUES
(3, 'uzair@gmail.com', 'uzair123', 'Mohamad Uzair'),
(4, 'Reedas@gmail.com', 'Reedas2000', 'Edwin Reedas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `issued`
--
ALTER TABLE `issued`
  ADD PRIMARY KEY (`issue_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `officer_id` (`officer_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `lab_item`
--
ALTER TABLE `lab_item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `technical_officer`
--
ALTER TABLE `technical_officer`
  ADD PRIMARY KEY (`officer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `issued`
--
ALTER TABLE `issued`
  MODIFY `issue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `lab_item`
--
ALTER TABLE `lab_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `technical_officer`
--
ALTER TABLE `technical_officer`
  MODIFY `officer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `issued`
--
ALTER TABLE `issued`
  ADD CONSTRAINT `issued_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `lab_item` (`item_id`),
  ADD CONSTRAINT `issued_ibfk_2` FOREIGN KEY (`officer_id`) REFERENCES `technical_officer` (`officer_id`),
  ADD CONSTRAINT `issued_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
