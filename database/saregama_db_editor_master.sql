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
-- Table structure for table `editor_master`
--

DROP TABLE IF EXISTS `editor_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `editor_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `insertDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `editor_master`
--

LOCK TABLES `editor_master` WRITE;
/*!40000 ALTER TABLE `editor_master` DISABLE KEYS */;
INSERT INTO `editor_master` VALUES (1,'admin','152f6f1e92206ec409a55c01eebb30c5','Admin','amit.kumar4@rp-sg.in','4/96/4d/euser_1379415518.png','2013-09-01 23:10:42',1,1),(2,'demo','c4ca4238a0b923820dcc509a6f75849b','demo@example.com',NULL,'7/d7/6b/lab_1379415555.png','2013-09-01 23:10:42',0,-1),(3,'ashish','a15f2c0ef7b4bd3c06bfc0ea172a6e78','Ashish Parande','ashish.parande@rp-sg.in','2/9f/a1/1504085_345211502288656_434700661_n_1393321122.jpg','2013-09-01 17:44:42',0,1),(20,'pranay','c4ca4238a0b923820dcc509a6f75849b','pranay1',NULL,'9/4b/f9/headphones_1379415489.png','2013-09-10 02:53:21',0,-1),(25,'santosh','c4ca4238a0b923820dcc509a6f75849b','santosh',NULL,'3/fc/83/box_1379415463.png','2013-09-10 03:22:59',0,-1),(29,'abc','c4ca4238a0b923820dcc509a6f75849b','abc',NULL,'3/fa/21/coding_1379415437.png','2013-09-10 20:22:39',0,-1),(30,'raj','c4ca4238a0b923820dcc509a6f75849b','raj',NULL,'f/15/27/advertising_1379415399.png','2013-09-11 08:27:08',0,-1),(31,'Arun','c4ca4238a0b923820dcc509a6f75849b','Arun',NULL,'1/31/2f/jellyfish_1379415336.jpg','2013-09-13 12:05:39',0,-1),(32,'Priyanka','c4ca4238a0b923820dcc509a6f75849b','priyanka',NULL,'d/17/d6/koala_1379414834.jpg','2013-09-16 12:57:23',0,-1),(33,'shaan','c4ca4238a0b923820dcc509a6f75849b','Shaan',NULL,'e/db/3f/lab_1379415885.png','2013-09-17 11:03:47',0,-1),(34,'ram','c4ca4238a0b923820dcc509a6f75849b','Ram',NULL,'d/f6/33/drawing_1379416049.png','2013-09-17 11:06:31',0,-1),(35,'dummyeditor','e5eb31a7c6fe3fb1b72d7ca90f3bc148','Editor',NULL,'','2013-10-09 10:57:44',0,1),(36,'legal','80c3619b4f2c624c3668b005d12b1239','Legal',NULL,'','2013-10-09 11:01:07',0,1),(37,'qcteam','935d7fcf01ed74f762d1561f539bee98','QC',NULL,'','2013-10-09 11:03:04',0,1),(38,'ujwala','2a919904fd3d8f35672ff610a5e93892','Ujwala',NULL,'','2013-11-11 05:50:30',0,1),(39,'mohit','48418969a4071bf494272463b4e6b324','Mohit',NULL,'','2013-11-21 09:42:33',0,1),(40,'guest','d93cf7ae430162f532673b636b4152c2','Guest Admin','amit.kumar4@rp-sg.in','','2013-12-18 05:22:09',0,1),(41,'qcteammember','c32c0a7588cf37adf777311fc922456c','qc team member',NULL,'','2013-12-20 07:55:40',0,-1),(42,'legalteammember','0a3dbd913119f471b7d41d56be94ad27','legal team member',NULL,'','2013-12-20 07:56:37',0,-1),(43,'planning','56eaec6608d1bcdda0c9a88006b41427','Planning',NULL,'','2013-12-20 07:57:43',0,1),(44,'ganesh','5a6f9dc330737bc545736a270844dd9e','Ganesh',NULL,'','2014-01-28 09:33:16',0,1),(45,'nokia','67f604b363b21c610da2ad7b17d4b6dc','Nokia',NULL,'','2014-02-16 18:18:06',0,1),(46,'imi','f65dad618014469ad01c0e2cd88dc7cf','IMI',NULL,'','2014-02-16 18:18:45',0,1),(47,'spice','aa65b2730e1b2d34692ca639be06c8cd','Spice',NULL,'','2014-02-16 18:19:38',0,1),(48,'publish','a8ade3b4648ad7c4782fed622376ce8a','Admin ( Publish )',NULL,'','2014-02-18 07:29:02',0,1);
/*!40000 ALTER TABLE `editor_master` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:25:00
