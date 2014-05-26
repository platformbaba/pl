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
-- Table structure for table `video_bulk_temp`
--

DROP TABLE IF EXISTS `video_bulk_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_bulk_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_title` varchar(255) DEFAULT NULL,
  `song_isrc` varchar(45) DEFAULT NULL,
  `video_language` varchar(45) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `video_duration` int(11) DEFAULT NULL,
  `album_name` varchar(255) DEFAULT NULL,
  `subject_parody` varchar(255) DEFAULT NULL,
  `singer` varchar(255) DEFAULT NULL,
  `director` varchar(255) DEFAULT NULL,
  `lyricist` varchar(255) DEFAULT NULL,
  `starcast` varchar(255) DEFAULT NULL,
  `mimicked_star` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `mood` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `raag` varchar(255) DEFAULT NULL,
  `taal` varchar(255) DEFAULT NULL,
  `time_of_day` varchar(45) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `saint` varchar(255) DEFAULT NULL,
  `instrument` varchar(255) DEFAULT NULL,
  `festival` varchar(255) DEFAULT NULL,
  `occasion` varchar(255) DEFAULT NULL,
  `grade` char(4) DEFAULT NULL,
  `video_file_path` varchar(255) DEFAULT NULL,
  `image_file_path` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `remarks` text,
  `batch_id` bigint(20) DEFAULT '0',
  `update_date` datetime DEFAULT NULL,
  `insert_date` datetime DEFAULT NULL,
  `gotodb` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_bulk_temp`
--

LOCK TABLES `video_bulk_temp` WRITE;
/*!40000 ALTER TABLE `video_bulk_temp` DISABLE KEYS */;
INSERT INTO `video_bulk_temp` VALUES (1,'Gata Rahe Mera Dil','INH100235730','Hindi','2014-02-11',200,'Guide','x','Rajat Nandy,Y S Moolky','S D Burman','Shailendra','salman khan','dev anand','original','Bhajan','Happy','Parents','Abheri','Khut','Dawn','islam','Shiva','banjo','aadi','parents day',NULL,'santosh.mp4','Penguins.jpg','1','[]',20140312143923,'2014-03-12 15:12:09','2014-03-12 14:39:24',1),(2,'Geet Gaata chal','INH100330010','Marathi','2014-02-21',400,'Guide','y','Asha Bhosle ','A. R. Rahman (0000-00-00)','Gulzar ','aamir khan','shashi kapoor','remix','Bhakti','Peppy','Father','Atana','Adi','Night','hinduism','Allah','bongo','naga','Rainy Song',NULL,'AUDIO LAUNCH - DESTINY 2.30SEC.mp4','Tulips.jpg','1','[]',20140312143923,'2014-03-12 15:12:08','2014-03-12 14:39:24',1);
/*!40000 ALTER TABLE `video_bulk_temp` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:27:55
