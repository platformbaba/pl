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
-- Table structure for table `playlist_mstr`
--

DROP TABLE IF EXISTS `playlist_mstr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playlist_mstr` (
  `playlist_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `playlist_name` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT '0',
  `image` varbinary(255) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0',
  `language_id` int(11) DEFAULT '0',
  `content_type` tinyint(2) DEFAULT '4' COMMENT '4=song,15=video,17=image',
  `insert_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`playlist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlist_mstr`
--

LOCK TABLES `playlist_mstr` WRITE;
/*!40000 ALTER TABLE `playlist_mstr` DISABLE KEYS */;
INSERT INTO `playlist_mstr` VALUES (1,'Playlist 1',1,NULL,1,0,4,'2013-12-30 18:33:50','2013-12-30 18:33:50'),(2,'Playlist 2',1,NULL,1,0,4,'2013-12-30 18:36:21','2013-12-30 18:36:21'),(3,'Playlist 3',1,'5/3e/d3/hydrangeas_1388486188.jpg',1,6,4,'2013-12-30 18:37:01','2013-12-31 16:06:31'),(4,'Playlist :4',1,'7/d6/b8/red_1392363492.jpg',1,25,4,'2014-01-02 11:45:19','2014-02-14 13:09:17'),(5,'Raaz Playlist',1,'3/24/e8/penguins_1388653312.jpg',1,0,4,'2014-01-02 12:06:57','2014-01-02 14:31:57'),(6,'Video Playlist 1',1,NULL,1,0,15,'2014-01-02 16:20:44','2014-01-02 16:20:44'),(7,'Video Playlist 2',1,NULL,1,0,15,'2014-01-02 16:31:38','2014-01-02 16:31:38'),(8,'Video Playlist 3',1,'4/1e/43/tulips_1388665932.jpg',1,39,15,'2014-01-02 16:36:22','2014-02-16 18:42:41'),(9,'Image Play on 50',1,'4/1e/43/tulips_1388665932.jpg',1,6,17,'2014-01-02 18:19:20','2014-02-12 14:08:36'),(10,'Image Playlist 2',1,'c/d1/66/packshot_1390829364.jpg',0,0,17,'2014-01-02 18:48:06','2014-02-14 16:43:09'),(11,'Desh ki awaaz',1,NULL,0,0,4,'2014-02-13 17:39:49','2014-02-13 17:39:49'),(12,'Pongal',1,NULL,1,0,4,'2014-02-19 15:08:48','2014-02-19 15:08:48'),(13,'Pongal Tamil',1,NULL,1,0,4,'2014-02-19 15:10:21','2014-02-19 15:10:21'),(14,'Holi_Mobile_App_Playlist',1,NULL,1,0,4,'2014-02-25 16:27:28','2014-02-25 16:27:28'),(15,'Ganesh_Mobile_App',1,NULL,1,0,4,'2014-02-26 17:58:38','2014-02-26 17:58:38');
/*!40000 ALTER TABLE `playlist_mstr` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:28:22
