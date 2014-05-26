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
-- Table structure for table `radio_stations`
--

DROP TABLE IF EXISTS `radio_stations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radio_stations` (
  `station_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `language_id` int(8) DEFAULT '0',
  `content_url` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 = Draft, 1 = active, -1 = deleted',
  `type` char(1) NOT NULL DEFAULT 'S' COMMENT 'S = Standard station, A = Artist station',
  `artist_id` int(11) DEFAULT NULL,
  `preview_url` varchar(255) DEFAULT NULL COMMENT 'Preview recorded message',
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `state` char(1) NOT NULL DEFAULT 'U' COMMENT ' to check station running status ',
  PRIMARY KEY (`station_id`),
  KEY `status` (`status`),
  KEY `type` (`type`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `radio_stations`
--

LOCK TABLES `radio_stations` WRITE;
/*!40000 ALTER TABLE `radio_stations` DISABLE KEYS */;
INSERT INTO `radio_stations` VALUES (1,'Madhuri ( Malayalam )',11,'http://radio.saregama.com/1','','',1,'S',28575,'','2014-04-21 11:36:52','2014-05-09 20:36:55','R'),(2,'Spandana ( Telugu )',21,'http://radio.saregama.com/2','spandana.jpg',NULL,1,'S',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(3,'Surabhi ( Marathi )',13,'http://radio.saregama.com/3','surabhi.jpg',NULL,1,'S',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(4,'Thenisai ( Tamil )',20,'http://radio.saregama.com/4','thenisai.jpg',NULL,1,'S',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(5,'Umang ( Gujarati )',5,'http://radio.saregama.com/5','umang.jpg',NULL,1,'S',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(6,'Tunak ( Punjabi )',16,'http://radio.saregama.com/6','tunak.jpg',NULL,1,'S',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(7,'Sparsha ( Kannada )',7,'http://radio.saregama.com/7','sparsha.jpg',NULL,1,'S',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(8,'Sonar ( Bengali )',2,'http://radio.saregama.com/8','sonar.jpg',NULL,1,'S',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(9,'Farishta ( Hindi )',6,'http://radio.saregama.com/9','farishta.jpg',NULL,1,'S',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(10,'Asha Bhosale',6,'http://radio.saregama.com/10','10_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(11,'Lata Mangeshkar',6,'http://radio.saregama.com/11','11_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(12,'Mohd Rafi',6,'http://radio.saregama.com/12','12_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(13,'Kishore Kumar',6,'http://radio.saregama.com/13','13_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(14,'DR P B SREENIVAS',7,'http://radio.saregama.com/14','14_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(15,'ILAYARAAJA',20,'http://radio.saregama.com/15','15_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(16,'K J YESUDAS',11,'http://radio.saregama.com/16','16_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(17,'RAJ KAPOOR',6,'http://radio.saregama.com/17','17_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(18,'SP BALASUBRAMANYUM',21,'http://radio.saregama.com/18','18_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(19,'Asha Bhosale',5,'http://radio.saregama.com/19','19_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(20,'DR. Raj Kumar',7,'http://radio.saregama.com/20','20_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(21,'Ghantasala',21,'http://radio.saregama.com/21','21_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(22,'Lata Mangeshkar',5,'http://radio.saregama.com/22','22_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(23,'Manna Dey',6,'http://radio.saregama.com/23','23_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(24,'Mukesh',5,'http://radio.saregama.com/24','24_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(25,'Sivaji Ganesan',20,'http://radio.saregama.com/25','25_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(26,'Talat Mahmood',6,'http://radio.saregama.com/26','26_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(27,'Usha Mangeshkar and Praful Dave',5,'http://radio.saregama.com/27','27_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(28,'Vayalar',11,'http://radio.saregama.com/28','28_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(29,'Dev Anand',6,'http://radio.saregama.com/29','29_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(30,'Hemanta Mukherjee',2,'http://radio.saregama.com/30','30_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(31,'Kishore Kumar',2,'http://radio.saregama.com/31','31_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(32,'Himmatwala (Hindi)',6,'http://radio.saregama.com/32','himmatwala.jpg',NULL,1,'S',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(33,'Vathikuchi (Tamil)',20,'http://radio.saregama.com/33','vathikuchi.jpg',NULL,1,'S',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(34,'The Bartender - B Seventy',6,'http://radio.saregama.com/34','thebartender.jpg',NULL,1,'S',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(35,'Lata Mangeshkar',13,'http://radio.saregama.com/35','35_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(36,'Asha Bhosle',13,'http://radio.saregama.com/36','36_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(37,'Sudhir Phadke',13,'http://radio.saregama.com/37','37_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(38,'Usha Mangeshkar',13,'http://radio.saregama.com/38','38_orignal.jpg',NULL,1,'A',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(39,'Issaq',6,'http://radio.saregama.com/39','39_orignal.jpg',NULL,1,'S',NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','R'),(40,'Nasha',6,'http://radio.saregama.com/40','Nasha_396x251.jpg','',1,'S',0,'','0000-00-00 00:00:00','2014-05-12 13:28:18','R'),(41,'Lucky Kabootar',6,'http://radio.saregama.com/41','1387791723_41.jpg','Lucky Kabootar',1,'S',0,'','0000-00-00 00:00:00','2014-05-12 13:26:40','R');
/*!40000 ALTER TABLE `radio_stations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:23:49
