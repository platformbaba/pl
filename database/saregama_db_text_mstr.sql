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
-- Table structure for table `text_mstr`
--

DROP TABLE IF EXISTS `text_mstr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `text_mstr` (
  `text_id` int(11) NOT NULL AUTO_INCREMENT,
  `text_name` varchar(128) DEFAULT NULL,
  `text_desc` text,
  `insert_date` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `text_type` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) DEFAULT '0',
  `file_path` mediumtext,
  PRIMARY KEY (`text_id`),
  KEY `text_type` (`text_type`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `text_mstr`
--

LOCK TABLES `text_mstr` WRITE;
/*!40000 ALTER TABLE `text_mstr` DISABLE KEYS */;
INSERT INTO `text_mstr` VALUES (1,'Geet Gaata chal','text desc','2014-03-12 14:37:41',0,2,13,'f/9e/d5/chrysanthemum_1394615261.jpg'),(2,'Gata Rahe Mera Dil','txt  desc','2014-03-12 14:37:41',0,1,6,'0/55/91/desert_1394615261.jpg'),(3,'Holi SMS','Rangon se bhi rangeen zindagi hai humari, rangeeli rahe yeh bandagi hai humari,kabhi na bigde ye pyar ki rangoli, aye mere yaar aisi HAPPY HOLI.','2014-03-14 14:59:08',1,1,28,''),(4,'Jo Jeeta Wohi Sikandar','Saroj Khan was the choreographer for this movie but due to some problems she did not turn up when the song \"Pehla Nasha\" was being shot. As a result, Farah Khan, who was assisting the director, offered to step in and choreograph the song. This marked the beginning of her career as a successful choreographer. ','2014-05-19 20:06:40',1,2,6,'');
/*!40000 ALTER TABLE `text_mstr` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:30:01
