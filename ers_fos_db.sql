-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2023 at 04:34 PM
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
-- Database: `ers_fos_db`
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
('admin_master@nexus.com', '$2y$10$3RXxBIvCklptQmFmbsoBNeiiCIG74twdSSqlRh663cCLkG/1DPJHq', 'Master Admin', 'Admin_Master', 'active'),
('stud_admin1@nexus.com', '$2y$10$IUzrF9GhBdTzDXXbmxA19.XZuxKo9le3hETfrRsqKG35goK4w1npS', 'Student admin 1', 'Admin_Student', 'active'),
('subj_admin1@nexus.com', '$2y$10$6IniUusMCkDLxZFhTVWyL.Nk0BBkFuzzLUzSCdFOqy32NexOPRNvi', 'subj1', 'Admin_Subject', 'active'),
('subj_admin2@nexus.com', '$2y$10$7v728eNqfjD61XwpVjLwvO/o4cNMvUmDW7QeqluimnhJsGNSzaqt.', 'Shankar', 'Admin_Subject', 'active'),
('viththagan@nexus.com', '$2y$10$HrF7DQS3U0xzZ5Xaom37LO4EAWXBK9zhhPBOsD.YqeIMvE4.kHgyG', 'viththagan', 'Admin_Subject', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `admin_details`
--

CREATE TABLE `admin_details` (
  `adminId` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fullName` varchar(255) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `mobileNo` int(10) DEFAULT NULL,
  `profile_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_details`
--

INSERT INTO `admin_details` (`adminId`, `email`, `fullName`, `department`, `mobileNo`, `profile_img`) VALUES
(1, 'admin_master@nexus.com', NULL, NULL, NULL, NULL),
(2, 'stud_admin1@nexus.com', 'John cena', 'CSC', NULL, NULL),
(3, 'subj_admin1@nexus.com', NULL, 'physics', NULL, NULL),
(4, 'viththagan@nexus.com', NULL, NULL, NULL, NULL),
(5, 'subj_admin2@nexus.com', NULL, 'Bio', NULL, NULL);

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
  `status` enum('draft','registration','closed','hidden') DEFAULT 'draft',
  `closing_date` date NOT NULL DEFAULT '2020-01-01',
  `date_created` date DEFAULT '2020-01-01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_reg`
--

INSERT INTO `exam_reg` (`exam_id`, `academic_year`, `semester`, `status`, `closing_date`, `date_created`) VALUES
(1, '2020', '1', 'hidden', '2023-08-28', '2023-08-28'),
(2, '2020', '2', 'draft', '2023-09-30', '2023-09-01');

-- --------------------------------------------------------

--
-- Table structure for table `reg_units`
--

CREATE TABLE `reg_units` (
  `regId` int(11) NOT NULL,
  `exam_unit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reg_units`
--

INSERT INTO `reg_units` (`regId`, `exam_unit_id`) VALUES
(9, 2),
(10, 6),
(10, 7);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `regNo` varchar(12) NOT NULL,
  `title` varchar(5) DEFAULT NULL,
  `nameWithInitial` varchar(60) DEFAULT NULL,
  `fullName` varchar(150) DEFAULT NULL,
  `district` varchar(30) DEFAULT NULL,
  `mobileNo` varchar(11) DEFAULT NULL,
  `landlineNo` varchar(11) DEFAULT NULL,
  `homeAddress` varchar(300) DEFAULT NULL,
  `addressInJaffna` varchar(300) DEFAULT NULL,
  `profile_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`regNo`, `title`, `nameWithInitial`, `fullName`, `district`, `mobileNo`, `landlineNo`, `homeAddress`, `addressInJaffna`, `profile_img`) VALUES
('2018/SB/001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2019/SP/178', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2020/CSC/007', 'Mr', 'C. R. B. Nilwakka', 'Chamod Rashmika Bandara Nilwakka', 'Kandy', '0772684933', '0779472689', 'No 4/56, Matale Rd, Wattegama.', 'Duvarakai, vamas lane, palali Rd, kondavil.', '2020CSC007.jpg'),
('2020/CSC/010', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2020/CSC/027', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2020/CSC/028', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2020/CSC/046', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2020/CSC/051', 'Mr', 'R.N.Viththagan', 'Roy Nesarajah Viththagan', 'Jaffna', '0771234567', '0123456789', 'Jaffna', 'Jaffna', '2020CSC051.jpg'),
('2020/CSC/052', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2020/CSC/055', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2020/CSC/057', 'Mr', 'S. Vithurshan', 'Sivakumar Vithurshan', 'Jaffna', '0123456789', '0123456789', 'kokuvil', 'kokuvil', NULL),
('2020/CSC/061', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2020/CSC/065', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2020/CSC/066', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2020/CSC/074', 'Mr', 'P.Saarukesan', 'Premkumar Saarukesan', 'Batticaloa', '0764722514', '0652054047', 'Chenkalady', 'Kandaramadam', NULL),
('2020/CSC/075', NULL, '', '', '', '', '', '', '', NULL),
('2020/SP/068', 'Miss', 'J.Jeyatheekshy', 'Jeyatheekshy Jeyarajen', 'Batticaloa', '0760586135', '0760586135', 'No.04, Building Quaters, Navalady Road, Kallady ,Batticaloa', 'Thirunelveli, Jaffna', '2020SP068.jpg'),
('2020/SP/129', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_check`
--

CREATE TABLE `student_check` (
  `regNo` varchar(12) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'unregistered',
  `verificationCode` int(11) DEFAULT NULL,
  `verificationStatus` varchar(15) NOT NULL DEFAULT 'not_verified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_check`
--

INSERT INTO `student_check` (`regNo`, `email`, `password`, `status`, `verificationCode`, `verificationStatus`) VALUES
('2018/SB/001', '001sb18@test.com', NULL, 'unregistered', NULL, 'not_verified'),
('2019/SP/178', '178sp19@test.com', NULL, 'unregistered', NULL, 'not_verified'),
('2020/CSC/007', 'cnilwakka@gmail.com', '$2y$10$f64XVozpm4azju5H1fdZKe1QFSLr/U2QWLwojsETCK12/IHniPI9W', 'active', 0, 'verified'),
('2020/CSC/010', 'dharshikagnanaseelan4@gmail.com', '$2y$10$ewPtbft5YqpV6qkGcZjSL.s/hwCgiQjnYLOUjNRisKD9DLP7pHLhe', 'active', 0, 'verified'),
('2020/CSC/027', 'kgobi24lk@gmail.com', NULL, 'unregistered', NULL, 'not_verified'),
('2020/CSC/028', 'lahiruishan400@gmail.com', NULL, 'unregistered', NULL, 'not_verified'),
('2020/CSC/046', 'audeshitha@gmail.com', NULL, 'unregistered', NULL, 'not_verified'),
('2020/CSC/051', 'viththagan1999@gmail.com', '$2y$10$43cjXmjEzaBbdy5aNR/LquaQqXrqVU9r/Hj4tcshbN9UUHhNlCzIO', 'active', 0, 'verified'),
('2020/CSC/052', '52csc20@test.com', NULL, 'unregistered', NULL, 'not_verified'),
('2020/CSC/055', 'sathasivamnerujan35@gmail.com', NULL, 'unregistered', NULL, 'not_verified'),
('2020/CSC/057', 'sivavithu15@live.com', '$2y$10$XhU8xrtIuzrHZXYiNUZbq.yb5zzuJApvAFEt3/TYMVf9QHPJmmgZC', 'active', 0, 'verified'),
('2020/CSC/061', 'vimalanthushani1122@gmail.com', NULL, 'unregistered', NULL, 'not_verified'),
('2020/CSC/065', 'vieronicka27@gmail.com', '$2y$10$NO9stDEgF3lkVlDNTxc4d.BSlqGWzGsU9YvmmN8fWnee56JWy9DGa', 'active', 0, 'verified'),
('2020/CSC/066', 'v.sayanishan.sv@gmail.com', NULL, 'unregistered', NULL, 'not_verified'),
('2020/CSC/074', 'saaru27kesan@gmail.com', '$2y$10$1SqgzSYrm/51NsExtP4cMOLbMk8CZFSij5NcusNmbnqENN3G9AyMO', 'active', 175670, 'verified'),
('2020/CSC/075', 'anathansinega@gmail.com', NULL, 'unregistered', NULL, 'not_verified'),
('2020/SP/068', 'theekshy27@gmail.com', '$2y$10$9IvVe6SXBRE3Pz5qtBvCJ.Evj4fKjN2aJjA4UOPdStrfnNRepRVVq', 'active', 0, 'verified'),
('2020/SP/129', 'kugatharshan26@gmail.com', NULL, 'unregistered', NULL, 'not_verified');

-- --------------------------------------------------------

--
-- Table structure for table `stud_exam_reg`
--

CREATE TABLE `stud_exam_reg` (
  `regId` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `stud_regNo` varchar(12) NOT NULL,
  `indexNo` varchar(10) NOT NULL,
  `level` int(11) NOT NULL,
  `combId` int(11) NOT NULL,
  `type` enum('proper','repeat') NOT NULL,
  `reg_date` DATE DEFAULT '2020-01-01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stud_exam_reg`
--

INSERT INTO `stud_exam_reg` (`regId`, `exam_id`, `stud_regNo`, `indexNo`, `level`, `combId`, `type`, `reg_date`) VALUES
(9, 2, '2020/CSC/051', 's11267', 1, 1, 'proper', '2020-01-01'),
(10, 2, '2020/CSC/051', 's11267', 1, 13, 'proper', '2020-01-01');

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
  `acYearAdded` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`unitId`, `unitCode`, `name`, `subject`, `level`, `acYearAdded`) VALUES
(1, 'CSC101S3', 'Foundations of Computer Science', 'CSC - Direct Intake', 1, 2017),
(2, 'CSC102S3', 'Computer Programming I', 'CSC - Direct Intake', 1, 2017),
(3, 'CSC103S3', 'Introduction to Computer Systems', 'CSC - Direct Intake', 1, 2017),
(4, 'CSC102G3', 'CSC102G3', 'CSC', 1, 2017),
(5, 'CSC104G2', 'CSC104G2', 'CSC', 1, 2017),
(6, 'PMM103G3', 'PMM103G3', 'PMM', 1, 2017),
(7, 'PMM104G2', 'PMM104G2', 'PMM', 1, 2017),
(8, 'AMM103G3', 'AMM103G3', 'AMM', 1, 2017),
(9, 'AMM104G2', 'AMM104G2', 'AMM', 1, 2017),
(10, 'STA103G3', 'STA103G3', 'STA', 1, 2017),
(11, 'STA104G2', 'STA104G2', 'STA', 1, 2017),
(12, 'PHY107G3', 'PHY107G3', 'PHY', 1, 2017),
(13, 'BOA103G2', 'BOA103G2', 'BOT', 1, 2017),
(14, 'BOA104G2', 'BOA104G2', 'BOT', 1, 2017),
(15, 'BOA105G2', 'BOA105G2', 'BOT', 1, 2017),
(16, 'FIS103G2', 'FIS103G2', 'FSC', 1, 2017),
(17, 'FIS104G2', 'FIS104G2', 'FSC', 1, 2017),
(18, 'FIS105G2', 'FIS105G2', 'FSC', 1, 2017),
(19, 'ZOL104G2', 'ZOL104G2', 'ZOO', 1, 2017),
(20, 'ZOL105G2', 'ZOL105G2', 'ZOO', 1, 2017),
(21, 'CSC106S3', 'CSC106S3', 'CSC - Direct Intake', 1, 2017),
(22, 'CSC108S2', 'CSC108S2', 'CSC - Direct Intake', 1, 2017),
(23, 'CSC109S2', 'CSC109S2', 'CSC - Direct Intake', 1, 2017),
(24, 'CSC111S2', 'CSC111S2', 'CSC - Direct Intake', 1, 2017),
(25, 'CSC112S3', 'CSC112S3', 'CSC - Direct Intake', 1, 2017),
(26, 'CHE102G2', 'CHE102G2', 'CHE', 1, 2017),
(27, 'CHE104G3', 'CHE104G3', 'CHE', 1, 2017),
(28, 'CHE106G1', 'CHE106G1', 'CHE', 1, 2017),
(29, 'CSC104S2', 'Mathematics for Computing I', 'CSC - Direct Intake', 1, 2017);

-- --------------------------------------------------------

--
-- Table structure for table `unit_sub_exam`
--

CREATE TABLE `unit_sub_exam` (
  `exam_unit_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `unitId` int(11) NOT NULL,
  `type` enum('proper','repeat') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_sub_exam`
--

INSERT INTO `unit_sub_exam` (`exam_unit_id`, `exam_id`, `unitId`, `type`) VALUES
(7, 2, 1, 'proper'),
(8, 2, 2, 'proper'),
(2, 2, 6, 'proper'),
(3, 2, 7, 'proper'),
(9, 2, 21, 'proper'),
(10, 2, 29, 'proper');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD PRIMARY KEY (`adminId`),
  ADD UNIQUE KEY `email` (`email`);

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
-- Indexes for table `reg_units`
--
ALTER TABLE `reg_units`
  ADD PRIMARY KEY (`regId`,`exam_unit_id`),
  ADD KEY `exam_unit_id` (`exam_unit_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`regNo`);

--
-- Indexes for table `student_check`
--
ALTER TABLE `student_check`
  ADD PRIMARY KEY (`regNo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `stud_exam_reg`
--
ALTER TABLE `stud_exam_reg`
  ADD PRIMARY KEY (`regId`),
  ADD UNIQUE KEY `exam_id` (`exam_id`,`stud_regNo`,`indexNo`,`level`,`combId`,`type`),
  ADD KEY `stud_regNo` (`stud_regNo`),
  ADD KEY `combId` (`combId`);

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
  ADD UNIQUE KEY `unitCode` (`unitCode`,`acYearAdded`),
  ADD KEY `subject` (`subject`);

--
-- Indexes for table `unit_sub_exam`
--
ALTER TABLE `unit_sub_exam`
  ADD PRIMARY KEY (`exam_unit_id`),
  ADD UNIQUE KEY `exam_id` (`exam_id`,`unitId`,`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_details`
--
ALTER TABLE `admin_details`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `combination`
--
ALTER TABLE `combination`
  MODIFY `combinationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `exam_reg`
--
ALTER TABLE `exam_reg`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stud_exam_reg`
--
ALTER TABLE `stud_exam_reg`
  MODIFY `regId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `unitId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `unit_sub_exam`
--
ALTER TABLE `unit_sub_exam`
  MODIFY `exam_unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD CONSTRAINT `admin_details_ibfk_1` FOREIGN KEY (`email`) REFERENCES `admin` (`email`) ON UPDATE CASCADE;

--
-- Constraints for table `combination_subjects`
--
ALTER TABLE `combination_subjects`
  ADD CONSTRAINT `combination_subjects_ibfk_1` FOREIGN KEY (`combinationID`) REFERENCES `combination` (`combinationID`),
  ADD CONSTRAINT `combination_subjects_ibfk_2` FOREIGN KEY (`subject`) REFERENCES `subject` (`subject`);

--
-- Constraints for table `reg_units`
--
ALTER TABLE `reg_units`
  ADD CONSTRAINT `reg_units_ibfk_1` FOREIGN KEY (`exam_unit_id`) REFERENCES `unit_sub_exam` (`unitId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reg_units_ibfk_2` FOREIGN KEY (`regId`) REFERENCES `stud_exam_reg` (`regId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`regNo`) REFERENCES `student_check` (`regNo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stud_exam_reg`
--
ALTER TABLE `stud_exam_reg`
  ADD CONSTRAINT `stud_exam_reg_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam_reg` (`exam_id`),
  ADD CONSTRAINT `stud_exam_reg_ibfk_2` FOREIGN KEY (`stud_regNo`) REFERENCES `student_check` (`regNo`),
  ADD CONSTRAINT `stud_exam_reg_ibfk_3` FOREIGN KEY (`combId`) REFERENCES `combination` (`combinationID`);

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `unit_ibfk_1` FOREIGN KEY (`subject`) REFERENCES `subject` (`subject`);

--
-- Constraints for table `unit_sub_exam`
--
ALTER TABLE `unit_sub_exam`
  ADD CONSTRAINT `unit_sub_exam_ibfk_1` FOREIGN KEY (`unitId`) REFERENCES `unit` (`unitId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `unit_sub_exam_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `exam_reg` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
