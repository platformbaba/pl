CREATE DATABASE  IF NOT EXISTS `saregama_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `saregama_db`;
-- MySQL dump 10.13  Distrib 5.6.11, for Win32 (x86)
--
-- Host: 192.168.64.122    Database: saregama_db
-- ------------------------------------------------------
-- Server version	5.5.37-35.0-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `song_mstr_temp`
--

DROP TABLE IF EXISTS `song_mstr_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `song_mstr_temp` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `path` varchar(100) NOT NULL,
  `song_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `song_mstr_temp`
--

LOCK TABLES `song_mstr_temp` WRITE;
/*!40000 ALTER TABLE `song_mstr_temp` DISABLE KEYS */;
INSERT INTO `song_mstr_temp` VALUES (1,'Sunn Raha Hai Female Version','Sunn_Raha_Hai_Female_Version.mp3',NULL),(2,'Titli','Titli.mp3',NULL),(3,'Badtameez Dil','Badtameez_Dil.mp3',NULL),(4,'Kabira Arijit Singh And Harshjeep','Kabira_Arijit_Singh_And_Harshjeep.mp3',NULL),(5,'Kabira Tochi Raina And Rekha Bhardwaj','Kabira_Tochi_Raina_And_Rekha_Bhardwaj.mp3',NULL),(6,'Dilliwaali Girlfriend','Dilliwaali_Girlfriend.mp3',NULL),(7,'Ghagra','Ghagra.mp3',NULL),(8,'Kashmir MainTu Kanyakumari','Kashmir_Main_Tu_Kanyakumari.mp3',NULL),(9,'Tu Mere Agal Bagal Hai','Tu_Mere_Agal_Bagal_Hai.mp3',NULL),(10,'Dhating Naach','Dhating_Naach.mp3',NULL);
/*!40000 ALTER TABLE `song_mstr_temp` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:28:56
