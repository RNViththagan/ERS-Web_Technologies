-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2023 at 10:32 PM
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
-- Database: `ers_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `email` varchar(100) NOT NULL,
  `password` varchar(155) NOT NULL,
  `name` varchar(25) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Student',
  `status` varchar(100) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`email`, `password`, `name`, `role`, `status`) VALUES
('admin_master@nexus.com', '$2y$10$9D28If.TzaiX6I3ZoMBVYOuJsMAFu06/8AaGj9rYUvHpx./OmcIO2', 'master1', 'Admin_Master', 'active'),
('stud_admin1@nexus.com', '$2y$10$IUzrF9GhBdTzDXXbmxA19.XZuxKo9le3hETfrRsqKG35goK4w1npS', 'stud1', 'Admin_Student', 'active'),
('subj_admin1@nexus.com', '$2y$10$6IniUusMCkDLxZFhTVWyL.Nk0BBkFuzzLUzSCdFOqy32NexOPRNvi', 'subj1', 'Admin_Subject', 'active'),
('viththagan@nexus.com', '$2y$10$HrF7DQS3U0xzZ5Xaom37LO4EAWXBK9zhhPBOsD.YqeIMvE4.kHgyG', 'viththagan', 'Admin_Subject', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `combination`
--

CREATE TABLE `combination` (
  `combinationID` int(11) NOT NULL,
  `combinationName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `combination`
--

INSERT INTO `combination` (`combinationID`, `combinationName`) VALUES
(1, 'CSC - Direct Intake'),
(2, 'BOT, ZOO, FSC'),
(3, 'CHE, BOT, FSC'),
(4, 'CHE, BOT, ZOO'),
(5, 'CHE, ZOO, FSC'),
(6, 'CHE, PMM, AMM'),
(7, 'CSC, AMM, CHE'),
(8, 'CSC, AMM, PHY'),
(9, 'CSC, AMM, STA'),
(10, 'CSC, PMM, AMM'),
(11, 'CSC, PMM, CHE'),
(12, 'CSC, STA, PMM'),
(13, 'PHY, PMM, AMM');

-- --------------------------------------------------------

--
-- Table structure for table `combination_subjects`
--

CREATE TABLE `combination_subjects` (
  `combinationID` int(11) NOT NULL,
  `subject` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `combination_subjects`
--

INSERT INTO `combination_subjects` (`combinationID`, `subject`) VALUES
(1, 'CSC - Direct Intake'),
(2, 'BOT'),
(2, 'FSC'),
(2, 'ZOO'),
(3, 'BOT'),
(3, 'CHE'),
(3, 'FSC'),
(4, 'CHE'),
(5, 'CHE'),
(6, 'CHE'),
(7, 'CSC'),
(8, 'CSC'),
(9, 'AMM'),
(9, 'CSC'),
(9, 'STA'),
(10, 'AMM'),
(10, 'CSC'),
(10, 'PMM'),
(11, 'CHE'),
(11, 'CSC'),
(11, 'PMM'),
(12, 'CSC'),
(12, 'PMM'),
(12, 'STA'),
(13, 'AMM'),
(13, 'PHY'),
(13, 'PMM');

-- --------------------------------------------------------

--
-- Table structure for table `exam_reg`
--

CREATE TABLE `exam_reg` (
  `exam_id` int(11) NOT NULL,
  `academic_year` varchar(10) NOT NULL,
  `semester` enum('1','2') NOT NULL,
  `status` enum('draft','registration','closed') DEFAULT 'draft',
  `closing_date` date NOT NULL DEFAULT current_timestamp(),
  `date_created` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_reg`
--

INSERT INTO `exam_reg` (`exam_id`, `academic_year`, `semester`, `status`, `closing_date`, `date_created`) VALUES
(1, '2020', '1', 'closed', '2023-08-28', '2023-08-28');

-- --------------------------------------------------------

--
-- Table structure for table `student_check`
--

CREATE TABLE `student_check` (
  `regNo` varchar(12) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'unregisterd',
  `verificationCode` int(11) DEFAULT NULL,
  `verificationStatus` varchar(15) NOT NULL DEFAULT 'not_verified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_check`
--

INSERT INTO `student_check` (`regNo`, `email`, `password`, `status`, `verificationCode`, `verificationStatus`) VALUES
('2020/CSC/007', 'cnilwakka@gmail.com', NULL, 'unregisterd', NULL, 'not_verified'),
('2020/CSC/028', 'lahiruishan400@gmail.com', NULL, 'unregisterd', NULL, 'not_verified'),
('2020/CSC/046', 'audeshitha@gmail.com', NULL, 'unregisterd', NULL, 'not_verified'),
('2020/CSC/051', 'viththagan1999@gmail.com', '$2y$10$UheeVt7LhSXc6zO6NT5R2Oaa.gzgxcAK8G/M71M7zPMJrHrbN8IaC', 'active', 0, 'verified'),
('2020/CSC/057', 'sivavithu15@live.com', NULL, 'unregisterd', NULL, 'not_verified'),
('2020/CSC/074', 'saaru27kesan@gmail.com', '$2y$10$7VyessXmkub2uhLKG5NezulQNzjdJQVWoEv7G8ivHJA4DMUtZ/3De', 'active', 0, 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject`) VALUES
('AMM'),
('BOT'),
('CHE'),
('CSC'),
('CSC - Direct Intake'),
('FSC'),
('PHY'),
('PMM'),
('STA'),
('ZOO');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `unitId` int(11) NOT NULL,
  `unitCode` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `level` int(1) NOT NULL,
  `addAcYear` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `combination`
--
ALTER TABLE `combination`
  ADD PRIMARY KEY (`combinationID`);

--
-- Indexes for table `combination_subjects`
--
ALTER TABLE `combination_subjects`
  ADD PRIMARY KEY (`combinationID`,`subject`),
  ADD KEY `subject` (`subject`);

--
-- Indexes for table `exam_reg`
--
ALTER TABLE `exam_reg`
  ADD PRIMARY KEY (`exam_id`),
  ADD UNIQUE KEY `academic_year` (`academic_year`,`semester`);

--
-- Indexes for table `student_check`
--
ALTER TABLE `student_check`
  ADD PRIMARY KEY (`regNo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`unitId`),
  ADD UNIQUE KEY `unitCode` (`unitCode`,`addAcYear`),
  ADD KEY `subject` (`subject`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `combination`
--
ALTER TABLE `combination`
  MODIFY `combinationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `exam_reg`
--
ALTER TABLE `exam_reg`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `unitId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `combination_subjects`
--
ALTER TABLE `combination_subjects`
  ADD CONSTRAINT `combination_subjects_ibfk_1` FOREIGN KEY (`combinationID`) REFERENCES `combination` (`combinationID`),
  ADD CONSTRAINT `combination_subjects_ibfk_2` FOREIGN KEY (`subject`) REFERENCES `subject` (`subject`);

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `unit_ibfk_1` FOREIGN KEY (`subject`) REFERENCES `subject` (`subject`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
