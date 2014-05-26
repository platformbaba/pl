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
-- Table structure for table `artist_video`
--

DROP TABLE IF EXISTS `artist_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `artist_video` (
  `artist_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `artist_role` int(11) DEFAULT NULL COMMENT 'Will have binary values',
  PRIMARY KEY (`artist_id`,`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artist_video`
--

LOCK TABLES `artist_video` WRITE;
/*!40000 ALTER TABLE `artist_video` DISABLE KEYS */;
INSERT INTO `artist_video` VALUES (1,3,8),(1,4,9),(9,1,1),(252,16,8),(312,5,8),(746,1,16),(816,1,8),(1936,2,128),(2501,1,4),(3481,19,1),(3588,1,8),(3588,4,8),(3588,6,8),(3588,7,8),(3588,15,9),(3588,18,9),(3588,19,8),(5790,3,1),(6309,2,8),(7019,2,1),(7384,2,16),(7646,1,128),(9077,16,1),(9103,16,16),(9556,2,8),(9798,18,16),(10270,7,1),(10273,6,1),(11003,17,4),(11009,17,1),(16093,6,4),(16093,19,4),(16094,5,4),(16396,18,4),(18696,2,4),(20074,5,1),(24330,3,16),(24330,4,16),(25533,17,16),(25625,15,16),(25699,6,16),(25699,7,16),(25699,19,16),(26657,16,4),(31297,7,4),(33242,17,8),(36691,5,16),(36804,15,4),(37217,3,4),(37217,4,4);
/*!40000 ALTER TABLE `artist_video` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:29:59
