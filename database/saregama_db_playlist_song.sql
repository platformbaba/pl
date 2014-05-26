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
-- Table structure for table `playlist_song`
--

DROP TABLE IF EXISTS `playlist_song`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playlist_song` (
  `song_id` int(11) NOT NULL DEFAULT '0',
  `playlist_id` bigint(20) NOT NULL DEFAULT '0',
  `rank` int(11) DEFAULT '200',
  PRIMARY KEY (`song_id`,`playlist_id`),
  KEY `playlist_id` (`playlist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlist_song`
--

LOCK TABLES `playlist_song` WRITE;
/*!40000 ALTER TABLE `playlist_song` DISABLE KEYS */;
INSERT INTO `playlist_song` VALUES (1,8,1),(2,7,2),(2,8,3),(3,2,200),(3,6,1),(3,7,1),(3,8,2),(3431,14,1),(5828,14,1),(6194,14,1),(6884,15,1),(8044,5,9),(8045,5,8),(8046,5,7),(8047,5,6),(8048,5,5),(8049,5,4),(8050,5,3),(8051,5,2),(8052,5,1),(8120,14,1),(9980,14,1),(9981,14,1),(10137,15,1),(10702,15,1),(24936,15,1),(24991,14,1),(25011,15,1),(25013,15,1),(25014,15,1),(25015,15,1),(25892,15,1),(26158,15,1),(28383,15,1),(28390,15,1),(28403,15,1),(28439,15,1),(28461,15,1),(28464,15,1),(28465,15,1),(28531,15,1),(28537,15,1),(28588,15,1),(28817,15,1),(28818,15,1),(28820,15,1),(28827,15,1),(28829,15,1),(28832,15,1),(28837,15,1),(28882,15,1),(28883,15,1),(28915,15,1),(28920,15,1),(28921,15,1),(35134,15,1),(36163,15,1),(45597,4,13),(45598,4,8),(45811,4,1),(46305,15,1),(49656,15,1),(49918,15,1),(50024,15,1),(50988,15,1),(51185,15,1),(51792,15,1),(54234,15,1),(55021,15,1),(56702,15,1),(60884,15,1),(60892,15,1),(60894,15,1),(60949,15,1),(61068,15,1),(61184,15,1),(61200,15,1),(61266,15,1),(64712,15,1),(65586,15,1),(66353,15,1),(75295,15,1),(77597,15,1),(77619,15,1),(78588,15,1),(80459,15,1),(82848,15,1),(82893,15,1),(83254,15,1),(84082,15,1),(84428,15,1),(84432,15,1),(84433,15,1),(86613,14,1),(89007,15,1),(89009,15,1),(89043,15,1),(89044,15,1),(89045,15,1),(89046,15,1),(89047,15,1),(89056,15,1),(89088,15,1),(89273,15,1),(89275,15,1),(89276,15,1),(89278,15,1),(89281,15,1),(89388,15,1),(92457,15,1),(97919,14,1),(99416,14,1),(100912,15,1),(101096,15,1),(102316,15,1),(102317,15,1),(102318,15,1),(102319,15,1),(102320,15,1),(102321,15,1),(102322,15,1),(102323,15,1),(102324,15,1),(102330,15,1),(109746,14,1),(113633,15,1),(114425,15,1),(115069,15,1),(116545,15,1),(118148,15,1),(118688,14,1),(118853,14,1),(119069,5,1),(119107,4,12),(119108,4,6),(119189,13,1),(119193,13,1),(119228,4,2),(119252,4,9),(119253,4,5),(119257,3,2),(119261,3,1),(119261,4,14),(119262,4,10),(119263,4,4),(119265,3,5),(119265,12,1),(119266,3,4),(119266,4,11),(119267,3,3),(119267,4,3),(119267,5,3),(119268,3,1),(119268,4,7),(119268,5,2),(119268,12,1),(119269,1,200),(119269,2,200),(119269,3,1),(119269,5,1);
/*!40000 ALTER TABLE `playlist_song` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:29:50