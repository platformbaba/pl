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
-- Table structure for table `video_edit_config_bkp`
--

DROP TABLE IF EXISTS `video_edit_config_bkp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_edit_config_bkp` (
  `video_edit_id` int(10) NOT NULL AUTO_INCREMENT,
  `platform` varchar(50) NOT NULL,
  `format` varchar(40) NOT NULL,
  `dimension` varchar(40) NOT NULL,
  `frame_rate` int(4) NOT NULL,
  `video_codec` varchar(40) NOT NULL,
  `video_bitrate` varchar(50) NOT NULL,
  `audio_codec` varchar(40) NOT NULL,
  `audio_bitrate` int(4) NOT NULL,
  `sample_rate` int(10) NOT NULL,
  `file_size_limit` varchar(20) DEFAULT NULL,
  `duration` varchar(20) NOT NULL,
  `insert_date` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ffmpeg_code` text,
  PRIMARY KEY (`video_edit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_edit_config_bkp`
--

LOCK TABLES `video_edit_config_bkp` WRITE;
/*!40000 ALTER TABLE `video_edit_config_bkp` DISABLE KEYS */;
INSERT INTO `video_edit_config_bkp` VALUES (1,'wap','3gp','128x96',15,'mpeg4','256k','aac Stereo 2Ch',96,32000,'4mb','60 Sec','2013-09-25',0,''),(2,'wap','3gp','176x144',15,'mpeg4','256k','aac Stereo 2Ch',96,32000,'4mb','60 Sec','2013-09-25',0,''),(3,'wap','3gp','240x260',15,'mpeg4','256k','aac Stereo 2Ch',96,32000,'4mb','60 Sec','2013-09-25',0,''),(4,'wap','3gp','240x320',15,'mpeg4','256kbps','aac Stereo 2Ch',96,32000,'4mb','60 Sec','2013-09-25',0,''),(5,'wap','3gp','320x240',15,'mpeg4','256kbps','aac Stereo 2Ch',96,32000,'4mb','60 Sec','2013-09-25',0,''),(6,'wap','3gp','360x480',15,'mpeg4','256kbps','aac Stereo 2Ch',96,32000,'4mb','60 Sec','2013-09-25',0,''),(7,'wap','3gp','480x320',15,'mpeg4','256kbps','aac Stereo 2Ch',96,32000,'4mb','60 Sec','2013-09-25',0,''),(8,'wap','3gp','480x360',15,'mpeg4','256kbps','aac Stereo 2Ch',96,32000,'4mb','60 Sec','2013-09-25',0,''),(9,'wap','flv','320x240',15,'mpeg4','256kbps','mp3',64,44100,'4mb','60 Sec','2013-09-25',0,''),(10,'wap','flv','360x640',15,'mpeg4','256kbps','mp3',64,44100,'4mb','60 Sec','2013-09-25',0,''),(11,'wap','flv','640x480',25,'mpeg4','256kbps','mp3',64,44100,'4mb','60 Sec','2013-09-25',0,''),(12,'wap','m4v','640x480',25,'mpeg4','256kbps','aac Stereo 2Ch',64,22050,'4mb','60 Sec','2013-09-25',0,''),(13,'wap','mp4','240x320',25,'mpeg4','256kbps','aac Stereo 2Ch',96,44100,'4mb','60 Sec','2013-09-25',0,''),(14,'wap','mp4','400x300',25,'mpeg4','256kbps','aac Stereo 2Ch',96,44100,'4mb','60 Sec','2013-09-25',0,''),(15,'wap','mp4','620x480',25,'mpeg4','256kbps','aac Stereo 2Ch',96,44100,'4mb','60 Sec','2013-09-25',0,''),(16,'wap','mp4','640x480',25,'mpeg4','256kbps','aac Stereo 2Ch',96,44100,'4mb','60 Sec','2013-09-25',0,''),(17,'wap','rm','320x240',15,'mpeg4','256kbps','rma',96,44100,'4mb','60 Sec','2013-09-25',0,''),(18,'wap','wmv','240x320',25,'mpeg4','256kbps','wma8',96,44100,'4mb','60 Sec','2013-09-25',0,''),(19,'wap','wmv','640x480',25,'mpeg4','256kbps','wma8',96,44100,'4mb','60 Sec','2013-09-25',0,''),(20,'youtube','mp4','1280x720 ',25,'h264','10000kbps','aac Stereo 2Ch',128,44100,'','','2013-09-25',0,''),(21,'bsb 3g','3gp2','176x144',10,'mpeg4','50 to 90 kbps','aac Stereo 2Ch',96,44100,'3mb','','2013-09-25',0,''),(22,'bsb 3g','3gp2','320x240',15,'mpeg4','Less Then 320k','aac Stereo 2Ch',64,44100,'3mb','','2013-09-25',0,''),(23,'bsb 3g','Mp4','360x280',25,'h264','Less Then 380k','aac Stereo 2Ch',8,8000,'3mb','','2013-09-25',0,''),(24,'bsb 3g','Mp4','360x288',15,'h264 Constrained Baseline','Less Then 120k','aac Stereo 2Ch',64,44100,'3mb','','2013-09-25',0,''),(25,'bsb 2g','3gp','128x96',15,'mpeg4','256k','aac Stereo 2Ch',96,32000,'4mb','','2013-09-25',0,''),(26,'bsb 2g','3gp','176x144',15,'mpeg4','256k','aac Stereo 2Ch',96,32000,'4mb','','2013-09-25',0,''),(27,'vuclip','3gp','128x96',15,'mpeg4','256k','aac Stereo 2Ch',96,32000,'4mb','more then 60 sec','2013-09-25',0,''),(28,'vuclip','3gp','176x144',15,'mpeg4','256k','aac Stereo 2Ch',96,32000,'4mb','more then 60 sec','2013-09-25',0,''),(29,'vuclip','3gp','240x260',15,'mpeg4','256k','aac Stereo 2Ch',96,32000,'4mb','more then 60 sec','2013-09-25',0,''),(30,'vuclip','3gp','240x320',15,'mpeg4','256k','aac Stereo 2Ch',96,32000,'4mb','more then 60 sec','2013-09-25',0,''),(31,'vuclip','3gp','320x240',15,'mpeg4','256k','aac Stereo 2Ch',96,32000,'4mb','more then 60 sec','2013-09-25',0,''),(32,'vuclip','3gp','360x480',15,'mpeg4','256k','aac Stereo 2Ch',96,32000,'4mb','more then 60 sec','2013-09-25',0,''),(33,'vuclip','3gp','480x320',15,'mpeg4','256k','aac Stereo 2Ch',96,32000,'4mb','more then 60 sec','2013-09-25',0,''),(34,'vuclip','3gp','480x360',15,'mpeg4','256k','aac Stereo 2Ch',96,32000,'4mb','more then 60 sec','2013-09-25',0,''),(35,'vuclip','flv','320x240',15,'mpeg4','256k','mp3',64,44100,'4mb','more then 60 sec','2013-09-25',0,''),(36,'vuclip','flv','360x640',15,'mpeg4','256k','mp3',64,44100,'4mb','more then 60 sec','2013-09-25',0,''),(37,'vuclip','flv','640x480',25,'mpeg4','256k','mp3',64,44100,'4mb','more then 60 sec','2013-09-25',0,''),(38,'vuclip','m4v','640x480',25,'mpeg4','256k','aac Stereo 2Ch',64,22050,'4mb','more then 60 sec','2013-09-25',0,''),(39,'vuclip','mp4','240x320',25,'mpeg4','256k','aac Stereo 2Ch',96,44100,'4mb','more then 60 sec','2013-09-25',0,''),(40,'vuclip','mp4','400x300',25,'mpeg4','256k','aac Stereo 2Ch',96,44100,'4mb','more then 60 sec','2013-09-25',0,''),(41,'vuclip','mp4','620x480',25,'mpeg4','256k','aac Stereo 2Ch',96,44100,'4mb','more then 60 sec','2013-09-25',0,''),(42,'vuclip','mp4','640x480',25,'mpeg4','256k','aac Stereo 2Ch',96,44100,'4mb','more then 60 sec','2013-09-25',0,''),(43,'vuclip','rm','320x240',15,'mpeg4','256k','rma',96,44100,'4mb','more then 60 sec','2013-09-25',0,''),(44,'vuclip','wmv','240x320',25,'mpeg4','256k','wma8',96,44100,'4mb','more then 60 sec','2013-09-25',0,''),(45,'vuclip','wmv','640x480',25,'mpeg4','256k','wma8',96,44100,'4mb','more then 60 sec','2013-09-25',0,''),(46,'vuclip','mp4','1280x720 ',25,'h264','500 +Kbps','aac Stereo 2Ch',128,44100,'','more then 60 sec','2013-09-25',0,'');
/*!40000 ALTER TABLE `video_edit_config_bkp` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:28:51
