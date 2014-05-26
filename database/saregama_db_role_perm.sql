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
-- Table structure for table `role_perm`
--

DROP TABLE IF EXISTS `role_perm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_perm` (
  `role_id` int(10) unsigned NOT NULL,
  `perm_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `role_id_3` (`role_id`,`perm_id`),
  KEY `role_id` (`role_id`),
  KEY `perm_id` (`perm_id`),
  KEY `role_id_2` (`role_id`,`perm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_perm`
--

LOCK TABLES `role_perm` WRITE;
/*!40000 ALTER TABLE `role_perm` DISABLE KEYS */;
INSERT INTO `role_perm` VALUES (1,1),(1,2),(1,3),(1,5),(1,6),(1,7),(1,8),(1,14),(1,15),(1,16),(1,18),(1,19),(1,20),(1,26),(1,27),(1,28),(1,30),(1,31),(1,32),(1,35),(1,36),(1,37),(1,38),(1,39),(1,40),(1,42),(1,43),(1,44),(1,46),(1,47),(1,48),(1,54),(1,55),(1,56),(1,58),(1,59),(1,60),(1,62),(1,63),(1,64),(1,66),(1,67),(1,68),(1,69),(1,70),(1,71),(1,72),(1,73),(1,74),(1,75),(1,76),(1,77),(1,78),(1,79),(1,81),(1,82),(1,84),(1,85),(1,87),(1,88),(1,89),(1,91),(1,92),(1,93),(1,94),(1,95),(1,96),(1,97),(1,98),(1,100),(1,101),(1,102),(1,103),(1,105),(1,106),(1,107),(1,109),(1,110),(1,111),(1,112),(1,114),(1,115),(1,116),(1,118),(1,119),(1,121),(1,123),(1,124),(1,127),(1,128),(1,129),(1,130),(1,131),(1,132),(1,133),(1,134),(1,136),(1,137),(1,138),(1,139),(1,140),(1,143),(1,145),(1,146),(1,148),(1,150),(1,151),(1,152),(1,154),(1,156),(1,157),(1,158),(1,159),(1,162),(1,163),(1,164),(1,166),(1,167),(1,168),(1,169),(1,171),(1,172),(1,173),(1,175),(1,176),(1,177),(1,178),(1,180),(1,181),(1,182),(1,183),(1,185),(1,186),(1,187),(1,189),(3,1),(3,5),(3,6),(3,7),(3,8),(3,18),(3,19),(3,20),(3,26),(3,27),(3,28),(3,30),(3,31),(3,32),(3,35),(3,36),(3,37),(3,38),(3,39),(3,40),(3,42),(3,43),(3,44),(3,46),(3,47),(3,48),(3,54),(3,55),(3,56),(3,58),(3,59),(3,60),(3,78),(3,79),(3,88),(3,89),(3,91),(3,115),(4,5),(4,6),(4,42),(4,66),(5,5),(6,5),(7,5),(7,6),(7,67),(7,73),(8,5),(8,38),(8,42),(8,46),(8,96),(8,97),(8,98),(8,100),(9,5),(9,101),(9,102),(9,103),(9,105),(10,5),(10,106),(10,107),(10,109),(10,110),(11,5),(11,42),(11,43),(11,44),(11,46),(11,47),(11,48),(11,54),(11,55),(11,56),(11,58),(11,59),(11,60),(11,77),(11,78),(11,79),(11,88),(11,111),(11,112),(11,114),(11,116),(11,118),(11,119),(11,121),(11,123),(11,124),(12,5),(12,42),(12,44),(12,46),(12,48),(12,55),(12,56),(12,58),(12,60),(12,77),(12,79),(12,88),(12,111),(12,114),(12,115),(12,116),(12,119),(12,121),(12,124),(12,127),(12,128),(12,129),(12,130),(12,131),(13,5),(13,42),(13,46),(13,55),(13,58),(13,73),(13,77),(13,82),(13,88),(13,89),(13,91),(13,92),(13,93),(13,95),(13,115),(14,5),(14,38),(14,42),(14,46),(14,55),(14,58),(14,77),(14,84),(14,85),(14,87),(14,88),(14,111),(14,115),(14,116),(14,121),(14,133),(14,134),(14,136),(14,137),(14,138),(14,139),(14,140),(15,5),(15,42),(15,46),(15,111),(15,112),(15,114),(15,143),(15,145),(15,146),(15,148),(16,5),(16,6),(16,18),(16,26),(16,38),(16,42),(16,46),(16,55),(16,58),(16,77),(16,87),(16,88),(16,96),(16,109),(16,111),(16,115),(16,116),(16,121),(16,136),(16,138),(16,148),(17,5),(17,42),(17,46),(17,55),(17,58),(17,72),(17,75),(17,76),(17,77),(17,81),(17,87),(17,88),(17,94),(17,111),(17,115),(17,116),(17,121),(17,132),(17,133),(17,134),(17,136),(17,137),(17,138),(17,139),(17,140);
/*!40000 ALTER TABLE `role_perm` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-23 14:28:32
