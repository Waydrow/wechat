-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: localhost    Database: pets_house
-- ------------------------------------------------------
-- Server version	5.6.24-log

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminaccount` varchar(45) NOT NULL,
  `adminpassword` varchar(45) NOT NULL,
  `adminname` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'222','bcbe3365e6ac95ea2c0343a2395834dd','小胖子');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `application`
--

DROP TABLE IF EXISTS `application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `petid` int(11) NOT NULL,
  `ispass` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `topet_idx` (`petid`),
  KEY `touser_idx` (`userid`),
  CONSTRAINT `topets` FOREIGN KEY (`petid`) REFERENCES `pet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tousers` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application`
--

LOCK TABLES `application` WRITE;
/*!40000 ALTER TABLE `application` DISABLE KEYS */;
INSERT INTO `application` VALUES (2,7,1,1),(3,7,3,-1),(4,7,4,1),(7,7,5,0),(8,1,1,-1),(9,1,3,1),(10,1,4,-1),(11,1,5,0),(12,1,6,0);
/*!40000 ALTER TABLE `application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `careworker`
--

DROP TABLE IF EXISTS `careworker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `careworker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `idcard` char(18) NOT NULL,
  `address` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `careworker`
--

LOCK TABLES `careworker` WRITE;
/*!40000 ALTER TABLE `careworker` DISABLE KEYS */;
INSERT INTO `careworker` VALUES (1,'小红','f','17854201111','372926199500001111','中国海洋大学'),(2,'小明','m','28754442222','389645122532145232','青岛'),(4,'222','f','187213','23','444'),(5,'333','m','137','323','312'),(6,'王凯','m','17854214453','2233444','青岛市崂山区');
/*!40000 ALTER TABLE `careworker` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lookafter`
--

DROP TABLE IF EXISTS `lookafter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lookafter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `careworkerid` int(11) NOT NULL,
  `petid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topet_idx` (`petid`),
  KEY `tocareworker_idx` (`careworkerid`),
  CONSTRAINT `tocareworker` FOREIGN KEY (`careworkerid`) REFERENCES `careworker` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `topet` FOREIGN KEY (`petid`) REFERENCES `pet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lookafter`
--

LOCK TABLES `lookafter` WRITE;
/*!40000 ALTER TABLE `lookafter` DISABLE KEYS */;
INSERT INTO `lookafter` VALUES (32,1,6),(33,4,6),(72,4,5);
/*!40000 ALTER TABLE `lookafter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pet`
--

DROP TABLE IF EXISTS `pet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roomid` int(11) NOT NULL,
  `petname` varchar(45) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `breed` varchar(45) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` varchar(2) NOT NULL,
  `entertime` date NOT NULL,
  `leavetime` date DEFAULT NULL,
  `isback` int(11) NOT NULL DEFAULT '0',
  `backreason` varchar(45) DEFAULT NULL,
  `character` varchar(45) DEFAULT NULL,
  `healthy` varchar(45) DEFAULT NULL,
  `istaken` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `toroom_idx` (`roomid`),
  CONSTRAINT `toroom` FOREIGN KEY (`roomid`) REFERENCES `room` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pet`
--

LOCK TABLES `pet` WRITE;
/*!40000 ALTER TABLE `pet` DISABLE KEYS */;
INSERT INTO `pet` VALUES (1,2,'小黑3','/Pets/Public/webuploader-0.1.5/upload/e0a15a0c76c1d5894516f715908ce6e0.jpg','藏獒',12,'雄性','2016-12-05','2016-12-08',0,NULL,NULL,NULL,1),(3,2,'小黄','','dog',4,'f','2016-02-24','2016-12-08',0,NULL,'123',NULL,1),(4,1,'haha','','55',12,'m','2016-12-06','2016-12-08',0,NULL,NULL,NULL,1),(5,9,'另一个','','dog',44,'f','2016-12-06',NULL,0,NULL,'1234',NULL,0),(6,2,'pet23','','cat',33,'m','2016-12-16',NULL,0,NULL,'12',NULL,0);
/*!40000 ALTER TABLE `pet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `capacity` int(11) NOT NULL,
  `nownum` int(11) NOT NULL DEFAULT '0',
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
INSERT INTO `room` VALUES (1,50,3,'roomTest'),(2,23,3,'room2'),(8,3,3,'ro'),(9,4,1,'123');
/*!40000 ALTER TABLE `room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `realname` varchar(45) NOT NULL,
  `idcard` char(18) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(45) DEFAULT NULL,
  `badrecord` varchar(45) DEFAULT NULL,
  `sex` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'222','bcbe3365e6ac95ea2c0343a2395834dd','张三123','372926199509016072','17854220000','',NULL,'f'),(2,'test2','bcbe3365e6ac95ea2c0343a2395834dd','李四111','372111199509016000','17854220001','',NULL,'m'),(3,'test3','bcbe3365e6ac95ea2c0343a2395834dd','小明','372111199509016022','17854220031',NULL,NULL,'m'),(5,'test4','bcbe3365e6ac95ea2c0343a2395834dd','李华','372111199509016033','17854220021',NULL,NULL,'m'),(7,'111','698d51a19d8a121ce581499d7b701668','Zhengzuowu ','35050219950821153X','11111111111','',NULL,'f'),(8,'11','bcbe3365e6ac95ea2c0343a2395834dd','111','35050219950821153X','11111111111','',NULL,'f');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-08 21:27:19
