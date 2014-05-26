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
-- Table structure for table `song_edit_config`
--

DROP TABLE IF EXISTS `song_edit_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `song_edit_config` (
  `song_edit_id` int(10) NOT NULL AUTO_INCREMENT,
  `format` varchar(120) DEFAULT NULL,
  `sample_size` varchar(120) DEFAULT NULL COMMENT 'bit',
  `audio_bitrate` varchar(120) DEFAULT NULL COMMENT 'kbps',
  `sample_rate` varchar(120) DEFAULT NULL COMMENT 'Hz',
  `audio_channel` varchar(120) DEFAULT NULL,
  `duration_limit` char(18) DEFAULT NULL,
  `codec` varchar(120) DEFAULT NULL,
  `file_size_limit` varchar(120) DEFAULT NULL,
  `platform` varchar(150) DEFAULT NULL,
  `known_as` varchar(150) DEFAULT NULL,
  `insert_date` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `ffmpeg_code` text,
  PRIMARY KEY (`song_edit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `song_edit_config`
--

LOCK TABLES `song_edit_config` WRITE;
/*!40000 ALTER TABLE `song_edit_config` DISABLE KEYS */;
INSERT INTO `song_edit_config` VALUES (1,'MP3','1','32','32000','STEREO','00',NULL,NULL,NULL,'Mp3 FL 32 32 Stereo','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec libmp3lame -ab 32k -ar 32000 -ac 2 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(2,'MP3','8','320','44100','STEREO','00',NULL,NULL,NULL,'Mp3 FL 320 Stereo','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec libmp3lame -ab 320k -ar 44100 -ac 2 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(3,'MP3','3','128','44100','STEREO','30',NULL,NULL,NULL,'Mp3 30 Sec 128 Stereo','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec libmp3lame -ab 128k -ar 44100 -ac 2 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(4,'MP3','4','192','44100','STEREO','40',NULL,NULL,NULL,'Mp3 40 Sec 192 Stereo','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec libmp3lame -ab 192k -ar 44100 -ac 2 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(6,'WAV','16','128','8000','MONO','45','PCM',NULL,NULL,'Wav 45 Sec  8 16 Bit','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_s16le -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(8,'WAV','8','64','8000','MONO','30','U LAW',NULL,NULL,'Wav 30 Sec U Law','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_u8 -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(9,'WAV','8','64','8000','MONO','40','PCM','313','','Wav 40 Sec 8 8 Mono','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_u8 -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(10,'WAV','16','128','8000','MONO','40','PCM','626',NULL,'Wav 40 Sec 8 16 Mono','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_s16le -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(11,'WAV','8','64','8000','MONO','60','PCM','469',NULL,'Wav 60 Sec 8 8 Mono','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_u8 -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(12,'WAV','8','64','8000','MONO','00','PCM','3750',NULL,'Wav FL 8 8 Mono','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_s16le -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(13,'WAV','8','64','8000','MONO','45','A LAW',NULL,NULL,'Wav 45 Sec A Law','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_alaw -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(15,'MP3','3','128','44100','MONO','00',NULL,NULL,NULL,'MP3 FL 128','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_u8 -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(19,'WAV','16','128','8000','MONO','60',NULL,NULL,NULL,'Wav 60 Sec 8 16 Mono','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec pcm_u8 -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(20,'AMR','16','12.80','8000','MONO','00','AMR NB','750','Reliance','AMR FL','2012-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec libopencore_amrnb -ab 12200 -ar 8000 -ac 1 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(21,'MP3','16','128','44100','STEREO','00','MPEG Layer-3','7500','Reliance','MP3 FL 128 Stereo','2013-09-13',1,'ffmpeg -i @@INPUT_PATH@@ -acodec libmp3lame -ab 128k -ar 44100 -ac 2 @@CUT_DURATION@@ @@OUTPUT_PATH@@'),(22,'AMR','16','12','8000','MONO','25','AMR NB','40','Reliance','AMR 25 sec','2013-10-21',1,NULL),(23,'MP3','16','64','22050','STEREO','25','MPEG Layer-3','200','Reliance','MP3 25 sec-22050 Hz-64Kbps-stereo','2013-10-21',1,NULL),(24,'WAV','16','1411','44100','STEREO','00','PCM',NULL,'Nokia','WAV FL 16 44100 Stereo','2014-01-20',1,NULL),(26,'AWB','32','256','8000','MONO','00','AMR Narrow Band',NULL,'WAP','AWB Default',NULL,1,NULL),(27,'MP3','64','2816','44100','MONO','30','MPEG Layer-3',NULL,'WAP','Mp3 30 Sec 64 44 Mono',NULL,1,NULL),(28,'WMA','32','512','16000','MONO','00','WMA2',NULL,'WAP','WMA FL 16 16 Mono',NULL,1,NULL),(29,'MP3','16','96','16000','MONO','00',NULL,NULL,'WAP','MP3_1MB 16 16 Mono',NULL,1,NULL),(30,'WAV','8','64','8000','MONO','30','PCM',NULL,'WAP','WAV 30 Sec 8 8 Mono',NULL,1,NULL);
/*!40000 ALTER TABLE `song_edit_config` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:23:51
