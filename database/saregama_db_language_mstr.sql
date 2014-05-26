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
-- Table structure for table `language_mstr`
--

DROP TABLE IF EXISTS `language_mstr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `language_mstr` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(128) DEFAULT NULL,
  `insert_date` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `language_mstr`
--

LOCK TABLES `language_mstr` WRITE;
/*!40000 ALTER TABLE `language_mstr` DISABLE KEYS */;
INSERT INTO `language_mstr` VALUES (1,'Assamese',NULL,1),(2,'Bengali',NULL,1),(3,'Bodo',NULL,-1),(4,'Dogri',NULL,1),(5,'Gujarati',NULL,1),(6,'Hindi',NULL,1),(7,'Kannada',NULL,1),(8,'Kashmiri',NULL,1),(9,'Konkani',NULL,1),(10,'Maithili',NULL,1),(11,'Malayalam',NULL,1),(12,'Manipuri',NULL,1),(13,'Marathi',NULL,1),(14,'Nepali',NULL,1),(15,'Oriya',NULL,1),(16,'Punjabi',NULL,1),(17,'Sanskrit',NULL,1),(18,'Santhali',NULL,-1),(19,'Sindhi',NULL,1),(20,'Tamil',NULL,1),(21,'Telugu',NULL,1),(22,'Urdu',NULL,1),(23,'Arabic',NULL,-1),(24,'Awadhi',NULL,1),(25,'Bhojpuri',NULL,1),(26,'Braj Bhasha',NULL,1),(27,'Chhattisgarhi',NULL,-1),(28,'English',NULL,1),(29,'Haryanvi',NULL,1),(30,'Himachali',NULL,1),(31,'Karbi',NULL,1),(32,'Magadhi',NULL,1),(33,'N/A',NULL,-1),(34,'Naga',NULL,1),(35,'Rajasthani',NULL,1),(37,'Carnatic','2013-09-25 11:04:24',1),(39,'Hindustani','2013-09-25 11:07:05',1),(40,'Arabic and English','2013-09-25 11:08:27',-1),(43,'instrumental','2013-10-03 11:44:40',-1),(46,'hindi/sanskrit','2013-09-25 21:40:36',-1),(47,'Chhatisgarhi',NULL,1),(48,'Arabic & English',NULL,1);
/*!40000 ALTER TABLE `language_mstr` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:28:44
