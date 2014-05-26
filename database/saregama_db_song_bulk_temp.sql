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
-- Table structure for table `song_bulk_temp`
--

DROP TABLE IF EXISTS `song_bulk_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `song_bulk_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `song_title` varchar(255) DEFAULT NULL,
  `isrc` varchar(45) DEFAULT NULL,
  `song_language` varchar(45) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `track_duration` int(11) DEFAULT NULL,
  `song_tempo` varchar(45) DEFAULT NULL,
  `subject_parody` varchar(100) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `album_name` varchar(255) DEFAULT NULL,
  `singer` varchar(255) DEFAULT NULL,
  `music_director` varchar(255) DEFAULT NULL,
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
  `region` varchar(45) DEFAULT NULL,
  `grade` char(4) DEFAULT NULL,
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
-- Dumping data for table `song_bulk_temp`
--

LOCK TABLES `song_bulk_temp` WRITE;
/*!40000 ALTER TABLE `song_bulk_temp` DISABLE KEYS */;
INSERT INTO `song_bulk_temp` VALUES (1,'Gata Rahe Mera Dil','INH100906104ashish','Hindi','2014-02-11',200,'22','x','INH100906104.mp3','Guide','Rajat Nandy,Y S Moolky','S D Burman','Shailendra','salman khan','dev anand','original','Bhajan','Happy','Parents','Abheri','Khut','Dawn','islam','Shiva','banjo','aadi','parents day','Punjab','A','0','{\"isrc\":\"ISRC already exist!\"}',20140312151106,'2014-03-12 15:16:06','2014-03-12 15:11:06',0),(2,'Geet Gaata chal','INH100906104parande','Marathi','2014-02-21',400,'44','y','0808mfull_AAAGF_IchheyHoyTai.wav','Geet Gata Chal (1975-12-31)','Asha Bhosle ','A. R. Rahman (0000-00-00)','Gulzar ','aamir khan','shashi kapoor','remix','Bhakti','Peppy','Father','Atana','Adi','Night','hinduism','Allah','bongo','naga','Rainy Song','goa','B','0','{\"isrc\":\"ISRC already exist!\"}',20140312151106,'2014-03-12 15:16:06','2014-03-12 15:11:07',0);
/*!40000 ALTER TABLE `song_bulk_temp` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:27:57
