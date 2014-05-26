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
-- Table structure for table `region_mstr`
--

DROP TABLE IF EXISTS `region_mstr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `region_mstr` (
  `region_id` int(11) NOT NULL AUTO_INCREMENT,
  `region_name` varchar(255) DEFAULT NULL,
  `insert_date` datetime DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`region_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region_mstr`
--

LOCK TABLES `region_mstr` WRITE;
/*!40000 ALTER TABLE `region_mstr` DISABLE KEYS */;
INSERT INTO `region_mstr` VALUES (1,'Tamil Nadu','2013-09-26 15:42:41',1),(2,'Andhra Pradesh','2013-09-26 15:45:51',1),(3,'West Bengal','2013-09-26 15:45:51',1),(4,'Gujarat','2013-09-26 15:45:51',1),(5,'Maharashtra','2013-09-26 15:45:52',1),(6,'Punjab','2013-09-26 15:45:52',1),(7,'Kerala','2013-09-26 15:52:25',1),(9,'Delhi','2013-09-26 15:58:11',1),(10,'Goa','2013-09-26 15:58:52',1);
/*!40000 ALTER TABLE `region_mstr` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:29:08
