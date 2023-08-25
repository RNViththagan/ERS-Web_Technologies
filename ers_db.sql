-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: ers_db
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `ers_db`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `ers_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `ers_db`;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `email` varchar(100) NOT NULL,
  `password` varchar(155) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Student',
  `status` varchar(100) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES ('admin_master@nexus.com','$2y$10$9D28If.TzaiX6I3ZoMBVYOuJsMAFu06/8AaGj9rYUvHpx./OmcIO2','Admin_Master','active'),('stud_admin1@nexus.com','$2y$10$IUzrF9GhBdTzDXXbmxA19.XZuxKo9le3hETfrRsqKG35goK4w1npS','Admin_Student','active'),('subj_admin1@nexus.com','$2y$10$6IniUusMCkDLxZFhTVWyL.Nk0BBkFuzzLUzSCdFOqy32NexOPRNvi','Admin_Subject','active');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `combination`
--

DROP TABLE IF EXISTS `combination`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `combination` (
  `combinationID` int(11) NOT NULL AUTO_INCREMENT,
  `combinationName` varchar(50) NOT NULL,
  PRIMARY KEY (`combinationID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `combination`
--

LOCK TABLES `combination` WRITE;
/*!40000 ALTER TABLE `combination` DISABLE KEYS */;
INSERT INTO `combination` VALUES (1,'CSC - Direct Intake'),(2,'BOT, ZOO, FSC'),(3,'CHE, BOT, FSC'),(4,'CHE, BOT, ZOO'),(5,'CHE, ZOO, FSC'),(6,'CHE, PMM, AMM'),(7,'CSC, AMM, CHE'),(8,'CSC, AMM, PHY'),(9,'CSC, AMM, STA'),(10,'CSC, PMM, AMM'),(11,'CSC, PMM, CHE'),(12,'CSC, STA, PMM'),(13,'PHY, PMM, AMM');
/*!40000 ALTER TABLE `combination` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `combination_subjects`
--

DROP TABLE IF EXISTS `combination_subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `combination_subjects` (
  `combinationID` int(11) NOT NULL,
  `subject` varchar(50) NOT NULL,
  PRIMARY KEY (`combinationID`,`subject`),
  KEY `subject` (`subject`),
  CONSTRAINT `combination_subjects_ibfk_1` FOREIGN KEY (`combinationID`) REFERENCES `combination` (`combinationID`),
  CONSTRAINT `combination_subjects_ibfk_2` FOREIGN KEY (`subject`) REFERENCES `subject` (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `combination_subjects`
--

LOCK TABLES `combination_subjects` WRITE;
/*!40000 ALTER TABLE `combination_subjects` DISABLE KEYS */;
INSERT INTO `combination_subjects` VALUES (1,'CSC - Direct Intake'),(2,'BOT'),(2,'FSC'),(2,'ZOO'),(3,'BOT'),(3,'CHE'),(3,'FSC'),(4,'CHE'),(5,'CHE'),(6,'CHE'),(7,'CSC'),(8,'CSC'),(9,'AMM'),(9,'CSC'),(9,'STA'),(10,'AMM'),(10,'CSC'),(10,'PMM'),(11,'CHE'),(11,'CSC'),(11,'PMM'),(12,'CSC'),(12,'PMM'),(12,'STA'),(13,'AMM'),(13,'PHY'),(13,'PMM');
/*!40000 ALTER TABLE `combination_subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `regNo` varchar(12) NOT NULL,
  `indexNumber` varchar(10) NOT NULL,
  `title` varchar(5) NOT NULL,
  `nameWithIniial` varchar(60) NOT NULL,
  `fullName` varchar(150) NOT NULL,
  `district` varchar(30) NOT NULL,
  `mobileNo` varchar(11) NOT NULL,
  `landlineNo` varchar(11) NOT NULL,
  `homeAddress` varchar(300) NOT NULL,
  `addressInJaffna` varchar(300) NOT NULL,
  `profile_img` varchar(255) NOT NULL,
  PRIMARY KEY (`regNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_check`
--

DROP TABLE IF EXISTS `student_check`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_check` (
  `regNo` varchar(12) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'unregisterd',
  `verificationCode` int(6) NOT NULL,
  `verificationStatus` varchar(15) NOT NULL DEFAULT 'not_verified',
  PRIMARY KEY (`regNo`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_check`
--

LOCK TABLES `student_check` WRITE;
/*!40000 ALTER TABLE `student_check` DISABLE KEYS */;
INSERT INTO `student_check` VALUES ('2020/CSC/051','viththagan1999@gmail.com','$2y$10$r2yaIo09V86NfT8kvmmX3ehl.BHs/ru9u.iFmysz8k0YtKHOSYP1S','active',330432,'verified');
/*!40000 ALTER TABLE `student_check` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subject` (
  `subject` varchar(50) NOT NULL,
  PRIMARY KEY (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES ('AMM'),('BOT'),('CHE'),('CSC'),('CSC - Direct Intake'),('FSC'),('PHY'),('PMM'),('STA'),('ZOO');
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-26  0:17:23
