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
-- Table structure for table `catalogue_mstr`
--

DROP TABLE IF EXISTS `catalogue_mstr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogue_mstr` (
  `catalogue_id` int(11) NOT NULL AUTO_INCREMENT,
  `catalogue_name` varchar(255) DEFAULT NULL,
  `agreement_id` varchar(50) DEFAULT NULL,
  `agreement_file` varchar(200) DEFAULT NULL,
  `internal_contact_details` varchar(500) DEFAULT NULL,
  `contact_details` varchar(500) DEFAULT NULL,
  `is_owned` tinyint(2) DEFAULT '1',
  `banner_id` int(11) DEFAULT NULL,
  `territory_in` varchar(256) NOT NULL,
  `territory_ex` varchar(256) NOT NULL,
  `start_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `physical_rights` tinyint(2) DEFAULT '0',
  `publishing_rights` int(7) DEFAULT '0',
  `digital_rights` int(7) DEFAULT '0',
  `is_exclusive` tinyint(1) NOT NULL,
  `status` tinyint(2) DEFAULT '0',
  `insert_date` datetime NOT NULL,
  PRIMARY KEY (`catalogue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogue_mstr`
--

LOCK TABLES `catalogue_mstr` WRITE;
/*!40000 ALTER TABLE `catalogue_mstr` DISABLE KEYS */;
INSERT INTO `catalogue_mstr` VALUES (1,'Saregama1','','','','',1,0,'0','','1900-05-01','0000-00-00',0,0,0,0,1,'0000-00-00 00:00:00'),(2,'Youtube',NULL,NULL,NULL,NULL,1,NULL,'','','0000-00-00','0000-00-00',0,0,0,0,1,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `catalogue_mstr` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:24:58
