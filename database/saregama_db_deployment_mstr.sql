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
-- Table structure for table `deployment_mstr`
--

DROP TABLE IF EXISTS `deployment_mstr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deployment_mstr` (
  `deployment_id` int(11) NOT NULL AUTO_INCREMENT,
  `deployment_name` varchar(100) DEFAULT NULL,
  `service_provider` varchar(100) DEFAULT NULL,
  `editor_id` int(11) DEFAULT '0',
  `status` tinyint(2) DEFAULT NULL,
  `is_ready` tinyint(1) DEFAULT '0',
  `insert_date` datetime DEFAULT NULL,
  PRIMARY KEY (`deployment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deployment_mstr`
--

LOCK TABLES `deployment_mstr` WRITE;
/*!40000 ALTER TABLE `deployment_mstr` DISABLE KEYS */;
INSERT INTO `deployment_mstr` VALUES (32,'Salim Spice.xlsx','SPICE',39,1,1,'2014-01-31 17:10:42'),(33,'All Final.xlsx','SPICE',39,0,1,'2014-02-11 12:30:07'),(34,'Punjabi.xlsx','SPICE',39,0,1,'2014-02-11 13:06:07'),(35,'Tamil.xlsx','SPICE',39,0,1,'2014-02-11 14:32:55'),(36,'Telugu.xlsx','SPICE',39,0,1,'2014-02-11 14:49:30'),(37,'Kannada.xlsx','SPICE',39,0,1,'2014-02-11 15:15:52'),(38,'Gujarati.xlsx','SPICE',39,0,1,'2014-02-11 15:30:38'),(40,'Ami Aar Amar Girl Friends','IMI',1,1,1,'2014-02-18 17:17:15'),(41,'APNI AZADI KO HUM','NOKIA',1,1,2,'2014-02-18 18:49:56'),(42,'test Deployemt','NOKIA',1,0,0,'2014-02-24 11:34:09'),(43,'Purachi Thalaivarin Puratchi Thalivai','WAPSONG',1,1,1,'2014-03-26 13:28:47'),(44,'5 Albums.xlsx','SPICE',1,0,0,'2014-05-20 15:19:23'),(45,'5 Albums.xlsx','SPICE',1,0,0,'2014-05-20 15:19:36'),(46,'5 Albums.xlsx','SPICE',1,0,0,'2014-05-20 15:26:42'),(47,'5 Albums.xlsx','SPICE',1,0,1,'2014-05-20 15:44:19'),(48,'5 Albums.xlsx','SPICE',1,0,1,'2014-05-20 15:45:51');
/*!40000 ALTER TABLE `deployment_mstr` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:26:07
