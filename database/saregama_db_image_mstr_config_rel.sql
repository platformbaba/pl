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
-- Table structure for table `image_mstr_config_rel`
--

DROP TABLE IF EXISTS `image_mstr_config_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image_mstr_config_rel` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `image_id` int(10) NOT NULL,
  `config_id` int(10) NOT NULL,
  `path` varchar(100) NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL,
  `insert_date` datetime NOT NULL,
  PRIMARY KEY (`image_id`,`config_id`,`path`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `config_id` (`config_id`),
  KEY `image_id` (`image_id`),
  CONSTRAINT `image_mstr_config_rel_ibfk_1` FOREIGN KEY (`config_id`) REFERENCES `image_edit_config` (`image_edit_id`),
  CONSTRAINT `image_mstr_config_rel_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `image_mstr` (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image_mstr_config_rel`
--

LOCK TABLES `image_mstr_config_rel` WRITE;
/*!40000 ALTER TABLE `image_mstr_config_rel` DISABLE KEYS */;
INSERT INTO `image_mstr_config_rel` VALUES (2,6,7,'jpg/1400x1400/te/test-up-3-6-7-1400x1400.jpg',1,1,'2014-04-01 19:34:11'),(1,7,7,'jpg/1400x1400/ap/apni-azadi-ko-hum-7-7-1400x1400.jpg',1,1,'2014-02-18 18:49:10');
/*!40000 ALTER TABLE `image_mstr_config_rel` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:28:16
