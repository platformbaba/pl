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
-- Table structure for table `text_bulk_temp`
--

DROP TABLE IF EXISTS `text_bulk_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `text_bulk_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text_title` varchar(255) DEFAULT NULL,
  `text_type` varchar(255) DEFAULT NULL,
  `text_language` varchar(255) DEFAULT NULL,
  `text_description` varchar(255) DEFAULT NULL,
  `album_name` varchar(255) DEFAULT NULL,
  `artist_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0',
  `insert_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `batch_id` bigint(20) DEFAULT NULL,
  `remarks` text,
  `gotodb` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `text_bulk_temp`
--

LOCK TABLES `text_bulk_temp` WRITE;
/*!40000 ALTER TABLE `text_bulk_temp` DISABLE KEYS */;
INSERT INTO `text_bulk_temp` VALUES (1,'Gata Rahe Mera Dil','Sms Text','hindi','txt  desc','Guide','salman khan','Desert.jpg',1,'2014-03-12 14:37:32','2014-03-12 14:37:41',20140312143732,'[]',1),(2,'Geet Gaata chal','General Text','marathi','text desc','Guide','aamir khan','Chrysanthemum.jpg',1,'2014-03-12 14:37:32','2014-03-12 14:37:41',20140312143732,'[]',1);
/*!40000 ALTER TABLE `text_bulk_temp` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:28:03
