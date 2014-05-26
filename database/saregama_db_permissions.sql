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
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `perm_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `perm_desc` varchar(50) NOT NULL,
  PRIMARY KEY (`perm_id`),
  UNIQUE KEY `perm_desc` (`perm_desc`)
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (150,'albumbulk_add'),(153,'albumbulk_delete'),(152,'albumbulk_edit'),(151,'albumbulk_view'),(43,'album_add'),(45,'album_delete'),(44,'album_edit'),(73,'album_legal'),(72,'album_publish'),(127,'album_qc'),(42,'album_view'),(39,'artist_add'),(41,'artist_delete'),(40,'artist_edit'),(74,'artist_publish'),(38,'artist_view'),(22,'audiotools_add'),(25,'audiotools_delete'),(24,'audiotools_edit'),(23,'audiotools_view'),(19,'banner_add'),(21,'banner_delete'),(20,'banner_edit'),(68,'banner_publish'),(18,'banner_view'),(89,'catalogue_add'),(90,'catalogue_delete'),(91,'catalogue_edit'),(132,'catalogue_publish'),(88,'catalogue_view'),(140,'crbt_add'),(142,'crbt_delete'),(139,'crbt_edit'),(138,'crbt_view'),(5,'dashboard_view'),(2,'editor_add'),(4,'editor_delete'),(3,'editor_edit'),(1,'editor_view'),(84,'event_add'),(86,'event_delete'),(85,'event_edit'),(87,'event_view'),(115,'explore_view'),(118,'image-edits_add'),(120,'image-edits_delete'),(119,'image-edits_edit'),(116,'image-edits_view'),(158,'imagebulk_add'),(161,'imagebulk_delete'),(159,'imagebulk_edit'),(162,'imagebulk_view'),(59,'image_add'),(61,'image_delete'),(60,'image_edit'),(93,'image_legal'),(75,'image_publish'),(130,'image_qc'),(58,'image_view'),(97,'imi-deployment_add'),(99,'imi-deployment_delete'),(98,'imi-deployment_edit'),(100,'imi-deployment_publish'),(96,'imi-deployment_view'),(31,'label_add'),(33,'label_delete'),(32,'label_edit'),(69,'label_publish'),(30,'label_view'),(7,'language_add'),(9,'language_delete'),(8,'language_edit'),(67,'language_legal'),(66,'language_publish'),(6,'language_view'),(143,'nokia-deployment_add'),(144,'nokia-deployment_delete'),(145,'nokia-deployment_edit'),(146,'nokia-deployment_publish'),(148,'nokia-deployment_view'),(187,'packs_add'),(188,'packs_delete'),(186,'packs_edit'),(189,'packs_publish'),(185,'packs_view'),(133,'playlist_add'),(135,'playlist_delete'),(134,'playlist_edit'),(137,'playlist_publish'),(136,'playlist_view'),(181,'radioprogram_add'),(184,'radioprogram_delete'),(182,'radioprogram_edit'),(183,'radioprogram_publish'),(180,'radioprogram_view'),(176,'radiostation_add'),(179,'radiostation_delete'),(177,'radiostation_edit'),(178,'radiostation_publish'),(175,'radiostation_view'),(36,'region_add'),(34,'region_delete'),(37,'region_edit'),(70,'region_publish'),(35,'region_view'),(101,'reliance-audio-deployment_add'),(104,'reliance-audio-deployment_delete'),(102,'reliance-audio-deployment_edit'),(105,'reliance-audio-deployment_publish'),(103,'reliance-audio-deployment_view'),(15,'role_add'),(17,'role_delete'),(16,'role_edit'),(14,'role_view'),(112,'song-edits_add'),(113,'song-edits_delete'),(114,'song-edits_edit'),(111,'song-edits_view'),(168,'songbulk-edits_add'),(170,'songbulk-edits_delete'),(169,'songbulk-edits_edit'),(167,'songbulk-edits_view'),(63,'songbulk_add'),(65,'songbulk_delete'),(64,'songbulk_edit'),(62,'songbulk_view'),(47,'song_add'),(49,'song_delete'),(48,'song_edit'),(92,'song_legal'),(76,'song_publish'),(128,'song_qc'),(46,'song_view'),(106,'spice-deployment_add'),(108,'spice-deployment_delete'),(107,'spice-deployment_edit'),(110,'spice-deployment_publish'),(109,'spice-deployment_view'),(27,'tags_add'),(29,'tags_delete'),(28,'tags_edit'),(71,'tags_publish'),(26,'tags_view'),(163,'textbulk_add'),(165,'textbulk_delete'),(164,'textbulk_edit'),(166,'textbulk_view'),(78,'text_add'),(80,'text_delete'),(79,'text_edit'),(82,'text_legal'),(81,'text_publish'),(131,'text_qc'),(77,'text_view'),(123,'video-edits_add'),(125,'video-edits_delete'),(124,'video-edits_edit'),(121,'video-edits_view'),(154,'videobulk_add'),(155,'videobulk_delete'),(156,'videobulk_edit'),(157,'videobulk_view'),(50,'videotools_add'),(53,'videotools_delete'),(52,'videotools_edit'),(51,'videotools_view'),(54,'video_add'),(57,'video_delete'),(56,'video_edit'),(95,'video_legal'),(94,'video_publish'),(129,'video_qc'),(55,'video_view'),(171,'wap-song-deployment_add'),(174,'wap-song-deployment_delete'),(172,'wap-song-deployment_edit'),(173,'wap-song-deployment_view');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:25:31
