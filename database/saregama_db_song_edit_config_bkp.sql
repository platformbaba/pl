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
-- Table structure for table `song_edit_config_bkp`
--

DROP TABLE IF EXISTS `song_edit_config_bkp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `song_edit_config_bkp` (
  `song_edit_id` int(10) NOT NULL DEFAULT '0',
  `platform` varchar(100) NOT NULL,
  `format` varchar(40) NOT NULL,
  `audio_bitrate` varchar(40) NOT NULL COMMENT 'bit',
  `sample_rate` varchar(40) NOT NULL COMMENT 'kHz',
  `audio_channel` varchar(40) DEFAULT NULL,
  `duration_limit` int(20) DEFAULT NULL,
  `codec` varchar(40) DEFAULT NULL,
  `file_size_limit` varchar(40) DEFAULT NULL,
  `insert_date` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ffmpeg_code` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `song_edit_config_bkp`
--

LOCK TABLES `song_edit_config_bkp` WRITE;
/*!40000 ALTER TABLE `song_edit_config_bkp` DISABLE KEYS */;
INSERT INTO `song_edit_config_bkp` VALUES (1,'Idea','MP3','32 kbps Stereo','32000',NULL,NULL,NULL,NULL,'2013-09-13',0,'ffmpeg -i @@INPUT_PATH@@ -acodec libmp3lame -ab 32k -ar 32000 -ac 2 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(2,'vodafone','MP3','320 kbps Stereo','44100',NULL,NULL,NULL,NULL,'2013-09-13',0,'ffmpeg -i @@INPUT_PATH@@ -acodec libmp3lame -ab 320k -ar 44100 -ac 2 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(3,'Tach Zone ','MP3','128 kbps Stereo','44100',NULL,30,NULL,NULL,'2013-09-13',0,'ffmpeg -i @@INPUT_PATH@@ -acodec libmp3lame -ab 128k -ar 44100 -ac 2 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(4,'Tach Zone ','MP3','192 kbps Stereo','44100',NULL,40,NULL,NULL,'2013-09-13',0,'ffmpeg -i @@INPUT_PATH@@ -acodec libmp3lame -ab 192k -ar 44100 -ac 2 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(6,'Airtel','WAV','16BIT MONO PCM','8000',NULL,40,NULL,NULL,'2013-09-13',0,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_s16le -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(8,'Idea','WAV','8BIT MONO U LAW','8000',NULL,30,NULL,NULL,'2013-09-13',0,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_u8 -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(9,'IMI','WAV','8','8','MONO',40,'PCM','313','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_u8 -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(10,'IMI','WAV','16','16','MONO',40,'PCM','626','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_s16le -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(11,'IMI','WAV','8','8','MONO',60,'PCM','469','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_u8 -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(12,'IMI','WAV','8','8','MONO',0,'PCM','3750','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_s16le -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(13,'Uninor','WAV','8BIT MONO A LAW','8000',NULL,40,NULL,NULL,'2013-09-13',0,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_alaw -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(15,'BSNL South','WAV','8BIT MONO U LAW','8000',NULL,30,NULL,NULL,'2013-09-13',0,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_u8 -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(16,'BSNL East','WAV','8BIT MONO U LAW','8000',NULL,30,NULL,NULL,'2013-09-13',0,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_u8 -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(17,'Virgin','WAV','8BIT MONO U LAW','8000',NULL,30,NULL,NULL,'2013-09-13',0,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_u8 -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(18,'vodafone','WAV','8BIT MONO U LAW','8000',NULL,30,NULL,NULL,'2013-09-13',0,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_u8 -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(19,'viva','WAV','8BIT MONO U LAW','8000',NULL,60,NULL,NULL,'2013-09-13',0,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_u8 -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(20,'Fijilive','AMR','12200kbps','8000',NULL,30,NULL,NULL,'2012-09-13',0,'ffmpeg -i @@INPUT_PATH@@ -acodec libopencore_amrnb -ab 12200 -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(21,'Fijilive','MP3','128kbps','44100',NULL,30,NULL,NULL,'2013-09-13',0,'ffmpeg -i @@INPUT_PATH@@ -acodec libmp3lame -ab 128k -ar 44100 -ac 2 @@CUT_DURATION@@ @@OUTPUT_PATH@@');
/*!40000 ALTER TABLE `song_edit_config_bkp` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:29:10
