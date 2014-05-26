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
-- Table structure for table `pack_mstr`
--

DROP TABLE IF EXISTS `pack_mstr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pack_mstr` (
  `pack_id` int(11) NOT NULL AUTO_INCREMENT,
  `pack_name` varchar(128) DEFAULT NULL,
  `pack_desc` varchar(255) DEFAULT NULL,
  `image` varchar(128) DEFAULT NULL,
  `cat_id` int(11) NOT NULL DEFAULT '0',
  `insert_date` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`pack_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pack_mstr`
--

LOCK TABLES `pack_mstr` WRITE;
/*!40000 ALTER TABLE `pack_mstr` DISABLE KEYS */;
INSERT INTO `pack_mstr` VALUES (1,'Shukrana','This is the first testing pack','6/d3/42/sparsha-kannada_1400479372.jpg',10115,'2014-05-21 17:42:31',1,'2014-05-22 13:24:35'),(2,'Nazm','This is the description','',10115,'2014-05-21 18:29:26',1,'2014-05-23 12:03:04'),(3,'Legends','testing','0/19/b2/pehla-nasha-pehla-khumar-02_1400509460.jpg',10115,'2014-05-21 19:45:18',1,'2014-05-22 13:23:37'),(4,'The Best Of','Lata Mangeshkar','',10115,'2014-05-22 12:17:50',1,'2014-05-22 13:24:50'),(5,'Flavours of','Kishore Kumar','',10115,'2014-05-22 12:20:01',1,'2014-05-22 12:20:01'),(6,'Navratan','gulzar','',10115,'2014-05-22 12:20:45',1,'2014-05-22 13:24:05'),(7,'Must Have','Must Have','',10115,'2014-05-22 12:21:31',1,'2014-05-22 13:23:52'),(8,'Volume 1-5','Volume 1-5','',10115,'2014-05-22 12:22:17',1,'2014-05-22 13:26:18'),(9,'Volume 6-10','Volume 6-10','',10129,'2014-05-22 12:23:12',1,'2014-05-22 13:25:41'),(10,'Volume 16-20','Volume 16-20','',10129,'2014-05-22 12:23:58',1,'2014-05-22 13:25:29'),(11,'Volume 21-25','h','',10129,'2014-05-22 12:25:10',1,'2014-05-22 13:25:15'),(12,'Volume 16-25','k','',10115,'2014-05-22 17:16:31',1,'2014-05-22 17:16:31'),(13,'geet','r','d/43/9d/pehla-nasha-pehla-khumar-04_1400509563.jpg',10129,'2014-05-23 11:56:14',1,'2014-05-23 11:56:14'),(14,'Kishore Night','w','8/48/9f/pehla-nasha-pehla-khumar-03_1400509515.jpg',10129,'2014-05-23 11:58:39',1,'2014-05-23 11:58:39'),(15,'Lata','w','',10129,'2014-05-23 11:59:08',1,'2014-05-23 11:59:08'),(16,'Rafi','s','',10129,'2014-05-23 11:59:34',1,'2014-05-23 11:59:34'),(17,'Asha','g','',10129,'2014-05-23 12:40:02',1,'2014-05-23 12:40:02');
/*!40000 ALTER TABLE `pack_mstr` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:24:08
