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
  `name` varchar(25) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Student',
  `status` varchar(100) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES ('admin_master@nexus.com','$2y$10$9D28If.TzaiX6I3ZoMBVYOuJsMAFu06/8AaGj9rYUvHpx./OmcIO2','master1','Admin_Master','active'),('stud_admin1@nexus.com','$2y$10$IUzrF9GhBdTzDXXbmxA19.XZuxKo9le3hETfrRsqKG35goK4w1npS','stud1','Admin_Student','active'),('subj_admin1@nexus.com','$2y$10$6IniUusMCkDLxZFhTVWyL.Nk0BBkFuzzLUzSCdFOqy32NexOPRNvi','subj1','Admin_Subject','active'),('viththagan@nexus.com','$2y$10$HrF7DQS3U0xzZ5Xaom37LO4EAWXBK9zhhPBOsD.YqeIMvE4.kHgyG','viththagan','Admin_Subject','active');
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
-- Table structure for table `exam_reg`
--

DROP TABLE IF EXISTS `exam_reg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_reg` (
  `exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `academic_year` varchar(10) NOT NULL,
  `semester` enum('1','2') NOT NULL,
  `status` enum('draft','registration','closed') DEFAULT 'draft',
  `closing_date` date NOT NULL DEFAULT current_timestamp(),
  `date_created` date DEFAULT current_timestamp(),
  PRIMARY KEY (`exam_id`),
  UNIQUE KEY `academic_year` (`academic_year`,`semester`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_reg`
--

LOCK TABLES `exam_reg` WRITE;
/*!40000 ALTER TABLE `exam_reg` DISABLE KEYS */;
INSERT INTO `exam_reg` VALUES (1,'2020','1','closed','2023-08-28','2023-08-28');
/*!40000 ALTER TABLE `exam_reg` ENABLE KEYS */;
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
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'unregisterd',
  `verificationCode` int(11) DEFAULT NULL,
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
INSERT INTO `student_check` VALUES ('2020/CSC/007','cnilwakka@gmail.com',NULL,'unregisterd',NULL,'not_verified'),('2020/CSC/028','lahiruishan400@gmail.com',NULL,'unregisterd',NULL,'not_verified'),('2020/CSC/046','audeshitha@gmail.com',NULL,'unregisterd',NULL,'not_verified'),('2020/CSC/051','viththagan1999@gmail.com','$2y$10$UheeVt7LhSXc6zO6NT5R2Oaa.gzgxcAK8G/M71M7zPMJrHrbN8IaC','active',0,'verified'),('2020/CSC/057','sivavithu15@live.com',NULL,'unregisterd',NULL,'not_verified'),('2020/CSC/074','saaru27kesan@gmail.com','$2y$10$7VyessXmkub2uhLKG5NezulQNzjdJQVWoEv7G8ivHJA4DMUtZ/3De','active',0,'verified');
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

--
-- Table structure for table `unit`
--

DROP TABLE IF EXISTS `unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit` (
  `unitId` int(11) NOT NULL AUTO_INCREMENT,
  `unitCode` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `level` int(1) NOT NULL,
  `addAcYear` int(4) NOT NULL,
  PRIMARY KEY (`unitId`),
  UNIQUE KEY `unitCode` (`unitCode`,`addAcYear`),
  KEY `subject` (`subject`),
  CONSTRAINT `unit_ibfk_1` FOREIGN KEY (`subject`) REFERENCES `subject` (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit`
--

LOCK TABLES `unit` WRITE;
/*!40000 ALTER TABLE `unit` DISABLE KEYS */;
/*!40000 ALTER TABLE `unit` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-28  1:53:28
