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
-- Table structure for table `album_bulk_temp`
--

DROP TABLE IF EXISTS `album_bulk_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album_bulk_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_name` varchar(255) DEFAULT NULL,
  `catalogue` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `content_type` varchar(255) DEFAULT NULL,
  `title_release_date` varchar(255) DEFAULT NULL,
  `music_release_date` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `primary_artist` varchar(255) DEFAULT NULL,
  `starcast` varchar(255) DEFAULT NULL,
  `director` varchar(255) DEFAULT NULL,
  `producer` varchar(255) DEFAULT NULL,
  `writer` varchar(255) DEFAULT NULL,
  `album_type` varchar(255) DEFAULT NULL,
  `lyricist` varchar(255) DEFAULT NULL,
  `music_director` varchar(255) DEFAULT NULL,
  `album_description` varchar(255) DEFAULT NULL,
  `coupling_ids` varchar(255) DEFAULT NULL,
  `tv_channel` varchar(255) DEFAULT NULL,
  `radio_station` varchar(255) DEFAULT NULL,
  `show_name` varchar(255) DEFAULT NULL,
  `year_broadcast` varchar(4) DEFAULT NULL,
  `grade` varchar(4) DEFAULT NULL,
  `film_rating` varchar(4) DEFAULT NULL,
  `artwork_file_path` varchar(255) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0',
  `insert_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `batch_id` bigint(20) DEFAULT NULL,
  `remarks` text,
  `gotodb` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album_bulk_temp`
--

LOCK TABLES `album_bulk_temp` WRITE;
/*!40000 ALTER TABLE `album_bulk_temp` DISABLE KEYS */;
INSERT INTO `album_bulk_temp` VALUES (1,'Guide us','concerts','hindi','saregama','song','1965-12-31','1965-12-31','Navketan International Films','dev anand','dev anand,waheeda rehman,kishore sahu','vijay anand','dev anand','','film',NULL,NULL,'this is guide!','1,2,3,4','9x','big fm','sawdhan india','2014','A','U','AllAmazingGuruNanak_850x1500.jpg',1,'2014-03-12 14:45:57','2014-03-12 14:47:03',20140312144557,'[]',1);
/*!40000 ALTER TABLE `album_bulk_temp` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:23:47
