-- MySQL dump 10.13  Distrib 5.6.12, for Win32 (x86)
--
-- Host: localhost    Database: cake
-- ------------------------------------------------------
-- Server version	5.6.12-log

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
-- Table structure for table `blocks`
--

DROP TABLE IF EXISTS `blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocks`
--

LOCK TABLES `blocks` WRITE;
/*!40000 ALTER TABLE `blocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cake_sessions`
--

DROP TABLE IF EXISTS `cake_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cake_sessions` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `data` text,
  `expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cake_sessions`
--

LOCK TABLES `cake_sessions` WRITE;
/*!40000 ALTER TABLE `cake_sessions` DISABLE KEYS */;
INSERT INTO `cake_sessions` VALUES ('34du00b9i77lmlui0u89lf14n4','Config|a:3:{s:9:\"userAgent\";s:32:\"9fde3dd81f14f613692212a542a99ddf\";s:4:\"time\";i:1397499613;s:9:\"countdown\";i:10;}Message|a:0:{}Auth|a:1:{s:4:\"User\";a:19:{s:2:\"id\";s:1:\"4\";s:8:\"username\";s:9:\"luc123456\";s:4:\"role\";s:7:\"teacher\";s:4:\"mail\";s:13:\"luc@gmail.com\";s:8:\"fullname\";s:9:\"Luc Luong\";s:13:\"date_of_birth\";s:10:\"2000-03-17\";s:3:\"sex\";s:3:\"man\";s:7:\"address\";s:6:\"Ha Tay\";s:14:\"credit_card_No\";N;s:9:\"mobile_No\";s:8:\"12345678\";s:6:\"verify\";s:40:\"d56784559ed74d4178ebc40de9848b17e6e5d2e8\";s:8:\"bank_acc\";s:10:\"AA12345678\";s:7:\"created\";s:19:\"2014-03-17 11:28:43\";s:8:\"modified\";s:19:\"2014-04-14 16:32:17\";s:5:\"state\";s:6:\"normal\";s:6:\"prevIP\";N;s:8:\"failedNo\";s:1:\"0\";s:14:\"first_password\";s:40:\"d56784559ed74d4178ebc40de9848b17e6e5d2e8\";s:12:\"first_verify\";s:40:\"d56784559ed74d4178ebc40de9848b17e6e5d2e8\";}}',1397499613),('52m4eq1m9pu82dhu1eakud4tu7','Config|a:3:{s:9:\"userAgent\";s:32:\"9fde3dd81f14f613692212a542a99ddf\";s:4:\"time\";i:1397538380;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:19:{s:2:\"id\";s:1:\"4\";s:8:\"username\";s:9:\"luc123456\";s:4:\"role\";s:7:\"teacher\";s:4:\"mail\";s:13:\"luc@gmail.com\";s:8:\"fullname\";s:9:\"Luc Luong\";s:13:\"date_of_birth\";s:10:\"2000-03-17\";s:3:\"sex\";s:3:\"man\";s:7:\"address\";s:6:\"Ha Tay\";s:14:\"credit_card_No\";N;s:9:\"mobile_No\";s:8:\"12345678\";s:6:\"verify\";s:40:\"d56784559ed74d4178ebc40de9848b17e6e5d2e8\";s:8:\"bank_acc\";s:10:\"AA12345678\";s:7:\"created\";s:19:\"2014-03-17 11:28:43\";s:8:\"modified\";s:19:\"2014-04-14 16:32:22\";s:5:\"state\";s:6:\"normal\";s:6:\"prevIP\";N;s:8:\"failedNo\";s:1:\"0\";s:14:\"first_password\";s:40:\"d56784559ed74d4178ebc40de9848b17e6e5d2e8\";s:12:\"first_verify\";s:40:\"d56784559ed74d4178ebc40de9848b17e6e5d2e8\";}}Message|a:0:{}',1397538381),('eiic69v1tbct8kj4l9qnf66042','Config|a:3:{s:9:\"userAgent\";s:32:\"dfcfbfebd487bc4f882fc4c714de965b\";s:4:\"time\";i:1397583479;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:19:{s:2:\"id\";s:1:\"4\";s:8:\"username\";s:9:\"luc123456\";s:4:\"role\";s:7:\"teacher\";s:4:\"mail\";s:13:\"luc@gmail.com\";s:8:\"fullname\";s:9:\"Luc Luong\";s:13:\"date_of_birth\";s:10:\"2000-03-17\";s:3:\"sex\";s:3:\"man\";s:7:\"address\";s:6:\"Ha Tay\";s:14:\"credit_card_No\";N;s:9:\"mobile_No\";s:8:\"12345678\";s:6:\"verify\";s:40:\"d56784559ed74d4178ebc40de9848b17e6e5d2e8\";s:8:\"bank_acc\";s:10:\"AA12345678\";s:7:\"created\";s:19:\"2014-03-17 11:28:43\";s:8:\"modified\";s:19:\"2014-04-15 04:06:15\";s:5:\"state\";s:6:\"normal\";s:6:\"prevIP\";N;s:8:\"failedNo\";s:1:\"0\";s:14:\"first_password\";s:40:\"d56784559ed74d4178ebc40de9848b17e6e5d2e8\";s:12:\"first_verify\";s:40:\"d56784559ed74d4178ebc40de9848b17e6e5d2e8\";}}Message|a:0:{}',1397583479),('fi4ljkdtk9aq7bnef3o0bk3155','Config|a:3:{s:9:\"userAgent\";s:32:\"dfcfbfebd487bc4f882fc4c714de965b\";s:4:\"time\";i:1397499275;s:9:\"countdown\";i:10;}Message|a:0:{}Auth|a:1:{s:4:\"User\";a:19:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:10:\"quan123456\";s:4:\"role\";s:7:\"student\";s:4:\"mail\";s:20:\"ntquan3291@gmail.com\";s:8:\"fullname\";s:18:\"Nguyen Trung  Quan\";s:13:\"date_of_birth\";s:10:\"1991-02-03\";s:3:\"sex\";s:3:\"man\";s:7:\"address\";s:9:\"Tan Cuong\";s:14:\"credit_card_No\";N;s:9:\"mobile_No\";s:10:\"1663541466\";s:6:\"verify\";s:0:\"\";s:8:\"bank_acc\";s:10:\"AA11324yu3\";s:7:\"created\";s:19:\"2014-03-17 10:45:47\";s:8:\"modified\";s:19:\"2014-04-13 20:17:24\";s:5:\"state\";s:6:\"normal\";s:6:\"prevIP\";s:9:\"127.0.0.2\";s:8:\"failedNo\";s:1:\"0\";s:14:\"first_password\";N;s:12:\"first_verify\";N;}}',1397499275),('khp09k6mlcj68vseda10c06l12','Config|a:3:{s:9:\"userAgent\";s:32:\"dfcfbfebd487bc4f882fc4c714de965b\";s:4:\"time\";i:1397538499;s:9:\"countdown\";i:10;}Auth|a:1:{s:4:\"User\";a:19:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:10:\"quan123456\";s:4:\"role\";s:7:\"student\";s:4:\"mail\";s:20:\"ntquan3291@gmail.com\";s:8:\"fullname\";s:18:\"Nguyen Trung  Quan\";s:13:\"date_of_birth\";s:10:\"1991-02-03\";s:3:\"sex\";s:3:\"man\";s:7:\"address\";s:9:\"Tan Cuong\";s:14:\"credit_card_No\";N;s:9:\"mobile_No\";s:10:\"1663541466\";s:6:\"verify\";s:0:\"\";s:8:\"bank_acc\";s:10:\"AA11324yu3\";s:7:\"created\";s:19:\"2014-03-17 10:45:47\";s:8:\"modified\";s:19:\"2014-04-14 16:29:41\";s:5:\"state\";s:6:\"normal\";s:6:\"prevIP\";s:9:\"127.0.0.2\";s:8:\"failedNo\";s:1:\"0\";s:14:\"first_password\";N;s:12:\"first_verify\";N;}}Message|a:0:{}',1397538499);
/*!40000 ALTER TABLE `cake_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,4,3,0,'duoc','2014-03-17 11:30:56'),(2,4,0,1,'bt','2014-03-17 11:31:12'),(3,1,4,0,'fadjaskf','2014-03-17 14:20:08'),(4,1,4,0,'fdjkfadsjf','2014-03-17 14:20:31'),(5,6,5,0,'fasfjerk','2014-03-17 15:50:48'),(6,6,0,5,'jfkawjdf','2014-03-17 15:50:59'),(7,1,1,0,'fdj','2014-03-25 15:28:44'),(8,1,3,0,'fadsfj','2014-03-25 15:31:00'),(9,12,6,0,'kjfasd','2014-04-06 14:40:12'),(10,12,6,0,'dskfjs','2014-04-06 14:40:18'),(11,1,1,0,'ã‚djf','2014-04-06 21:03:06'),(12,1,0,7,'dfã‹sd','2014-04-06 21:03:14'),(13,4,29,0,'hay','2014-04-08 23:19:06'),(14,4,3,0,'vl','2014-04-12 20:41:21'),(15,1,2,0,'hay','2014-04-12 21:34:03'),(16,1,2,0,'bÃ¬nh thÆ°á»ng','2014-04-12 21:45:24'),(17,1,2,0,'tÃ m táº¡m','2014-04-12 21:45:31'),(18,1,0,16,'ok','2014-04-12 21:45:44'),(19,1,0,15,'háº¥p','2014-04-14 16:30:11');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `constants`
--

DROP TABLE IF EXISTS `constants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `constants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `constants`
--

LOCK TABLES `constants` WRITE;
/*!40000 ALTER TABLE `constants` DISABLE KEYS */;
INSERT INTO `constants` VALUES (1,'login ',4),(2,'paging',15),(3,'MAX',3),(4,'blockTime',1000),(5,'rate',60),(6,'cost',15000),(7,'expire_time',7);
/*!40000 ALTER TABLE `constants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lecture_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

LOCK TABLES `favorites` WRITE;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` VALUES (2,'1','1','2014-03-17 14:40:40'),(3,'1','13','2014-04-06 11:40:48'),(4,'1','2','2014-04-06 11:41:18'),(6,'1','9','2014-04-12 23:42:10');
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ips`
--

DROP TABLE IF EXISTS `ips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(32) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ips`
--

LOCK TABLES `ips` WRITE;
/*!40000 ALTER TABLE `ips` DISABLE KEYS */;
INSERT INTO `ips` VALUES (1,'127.0.0.1',2),(2,'127.0.0.1',3),(3,'127.0.0.1',14),(4,'::1',2);
/*!40000 ALTER TABLE `ips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lectures`
--

DROP TABLE IF EXISTS `lectures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lectures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `cost` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `tag` text,
  `refer_times` int(11) DEFAULT '0',
  `reported` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lectures`
--

LOCK TABLES `lectures` WRITE;
/*!40000 ALTER TABLE `lectures` DISABLE KEYS */;
INSERT INTO `lectures` VALUES (1,'Toan1','toan 1 created by quan32',NULL,1,1,'2014-03-17 10:48:17','2014-04-14 16:48:42',NULL,27,0),(2,'Van1','van 1 created by quan',NULL,1,2,'2014-03-17 10:55:37','2014-04-14 16:29:55',NULL,8,0),(3,'Tieng Nhat 1','tieng nhat 1 created by luc luong',NULL,4,3,'2014-03-17 11:29:53','2014-04-15 16:40:22','',14,0),(4,'Toan 2','toan 2 created by quan',NULL,1,1,'2014-03-17 14:18:35','2014-04-12 20:32:06',NULL,9,0),(5,'Toan 1','Toan 1 created by 1uan',NULL,6,1,'2014-03-17 15:45:53','2014-04-12 20:56:24',NULL,11,0),(6,'Anh van 3','Anh van 3 created by hung',NULL,12,3,'2014-03-24 01:38:49','2014-04-12 20:56:29',NULL,16,0),(8,'toan3','toan3 created by quan',NULL,12,1,'2014-03-24 03:54:33','2014-04-10 16:35:33',NULL,8,0),(9,'Anh van 5','created by quan32',NULL,12,1,'2014-04-01 10:04:48','2014-04-12 23:41:58',NULL,10,0),(10,'Toan 1','Toan 1 created by luc',NULL,4,1,'2014-04-06 09:13:37','2014-04-10 16:29:30',NULL,1,0),(11,'Van 1','Van 1 created by luc123456',NULL,4,2,'2014-04-06 09:14:51','2014-04-12 20:32:15',NULL,1,0),(12,'Toan cao cap 1','toan cao cap 1 , danh cho sinh vien dai hoc bach khao',NULL,4,1,'2014-04-06 11:14:08','2014-04-10 16:18:58',NULL,1,0),(13,'toan cao cap 2','danh cho hoc sinh gioi hoc qua toan 1',NULL,4,1,'2014-04-06 11:15:23','2014-04-06 11:15:23',NULL,0,0),(14,'Xuan van 1','tac gia vu huy xuan',NULL,4,2,'2014-04-06 11:18:49','2014-04-12 20:43:23',NULL,1,0),(15,'bat dang thuc','bat dang thuc danh cho hoc sinh thi dai hoc bach khoa',NULL,4,1,'2014-04-06 11:22:16','2014-04-12 23:41:53',NULL,4,0),(16,'vovan','vovan created by luc',NULL,4,2,'2014-04-06 21:53:33','2014-04-06 21:53:33',NULL,0,0),(17,'Van 212345678','1234567890dfghjkdfghjkl2345678',NULL,4,1,'2014-04-08 22:02:41','2014-04-08 22:02:41','',0,0),(18,'123456789fgh','w3e4rtyuidsfjhasdfjhadsfjhasjd',NULL,4,1,'2014-04-08 22:04:19','2014-04-08 22:04:19','',0,0),(19,'234567890dafsk','dsjafkdjaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaajfs',NULL,4,1,'2014-04-08 22:04:52','2014-04-08 22:04:52','',0,0),(20,'VAn234567890','ajjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjdsansdkfansdkfands',NULL,4,1,'2014-04-08 22:28:27','2014-04-08 22:28:27','Ngo Tat To, The Lu, Van hoc hien dai',0,0),(21,'van23456789034','acxcfaewwwwwwwwwwwwwwwwwwwwwwcxnriiiiiiiiiiiewu',NULL,4,1,'2014-04-08 22:34:52','2014-04-08 22:34:52','Ngo Tat To, The Lu, Van hoc hien dai',0,0),(22,'toan 34567890','afksssssssssssssssssssssssssssssssssssssssssssss ',NULL,4,1,'2014-04-08 22:35:45','2014-04-08 22:35:45','Ngo Tat To, The Lu, Van hoc hien dai',0,0),(23,'53urpofsadfhaj','dfjakdjfffffffffffffffffasjaffffffffffffffffff',NULL,4,1,'2014-04-08 22:38:22','2014-04-08 22:38:22','Ngo Tat To, The Lu, Van hoc hien dai',0,0),(24,'32458790asdfasjdfk','ajsfaskdfjasssssssssssssssssssssssss',NULL,4,1,'2014-04-08 22:39:11','2014-04-08 22:39:11','Ngo Tat To, The Lu, Van hoc hien dai',0,0),(29,'Cac bai tho can dai va anh huong toi gioi tre','Mot cong trinh nghien cuu ket hop cua sinh vien HESDPI K54',NULL,4,1,'2014-04-08 23:18:29','2014-04-12 23:41:47','HEDSPI, K54, nghien cuu, gioi tre, sinh vien',11,0),(30,'jfsdkfjaskfjaskdfjaksdfjj','askdfjaskdfjaskdfjaksdjfaksdjfaksdjfkasdjf',NULL,4,1,'2014-04-08 23:48:18','2014-04-10 16:17:14','Toan cao cap, Vat ly dai cuong, Hoa hoc',4,0),(31,'bai test cua linh','áº¡odasdaskld fdfs  fsdfs  fsdfsd sf',NULL,4,1,'2014-04-15 15:52:34','2014-04-15 15:52:34','abc, linh, hom nay',0,0);
/*!40000 ALTER TABLE `lectures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (11,4,10,'2014-04-15 14:32:28','2014-04-15 14:32:28','あなたの講義はCopyrightの問題に侵害するのでレポートさせました. この講義を編集することが必要です！'),(12,4,14,'2014-04-15 14:32:36','2014-04-15 14:32:36','あなたの講義はCopyrightの問題に侵害するのでレポートさせました. この講義を編集することが必要です！'),(13,4,14,'2014-04-15 14:37:43','2014-04-15 14:37:43','あなたの講義はCopyrightの問題に侵害するのでレポートさせました. この講義を編集することが必要です！');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registers`
--

DROP TABLE IF EXISTS `registers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `lecture_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registers`
--

LOCK TABLES `registers` WRITE;
/*!40000 ALTER TABLE `registers` DISABLE KEYS */;
INSERT INTO `registers` VALUES (1,1,1,3,'2014-03-17 14:39:29','2014-03-17 14:39:29'),(2,1,2,3,'2014-03-17 14:40:02','2014-03-17 14:40:02'),(3,1,1,3,'2014-03-25 15:28:10','2014-03-25 15:28:10'),(4,1,2,3,'2014-03-25 15:29:21','2014-03-25 15:29:21'),(5,1,3,3,'2014-03-25 15:29:51','2014-03-25 15:29:51'),(6,1,1,0,'2014-03-06 11:28:06','2014-04-06 11:28:06'),(7,1,2,0,'2014-04-06 11:28:10','2014-04-06 11:28:10'),(8,1,3,0,'2014-04-06 11:28:13','2014-04-06 11:28:13'),(9,1,4,0,'2014-04-06 11:28:17','2014-04-06 11:28:17'),(10,1,5,0,'2014-04-06 11:28:21','2014-04-06 11:28:21'),(11,1,12,0,'2014-04-06 11:28:33','2014-04-06 11:28:33'),(12,1,14,0,'2014-04-06 11:29:47','2014-04-06 11:29:47'),(13,1,13,0,'2014-04-06 11:30:01','2014-04-06 11:30:01'),(14,1,15,0,'2014-04-06 11:30:08','2014-04-06 11:30:08'),(15,1,9,0,'2014-04-10 14:50:13','2014-04-10 14:50:13'),(16,1,29,0,'2014-04-10 14:54:19','2014-04-10 14:54:19'),(17,1,1,0,'2014-04-12 21:23:21','2014-04-12 21:23:21'),(18,1,2,0,'2014-04-14 16:29:51','2014-04-14 16:29:51'),(19,1,3,0,'2014-04-14 17:01:26','2014-04-14 17:01:26');
/*!40000 ALTER TABLE `registers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lecture_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `lec_idx` (`lecture_id`),
  KEY `us_idx` (`user_id`),
  CONSTRAINT `lec` FOREIGN KEY (`lecture_id`) REFERENCES `lectures` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `us` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (8,1,4,'2014-04-12 13:14:28','2014-04-12 13:14:28',1),(9,2,4,'2014-04-12 13:14:34','2014-04-12 13:14:34',1),(10,8,4,'2014-04-12 19:41:05','2014-04-12 19:41:05',1),(11,5,4,'2014-04-13 20:11:02','2014-04-13 20:11:02',1),(12,4,4,'2014-04-13 20:11:12','2014-04-13 20:11:12',1);
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `results`
--

DROP TABLE IF EXISTS `results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `results`
--

LOCK TABLES `results` WRITE;
/*!40000 ALTER TABLE `results` DISABLE KEYS */;
INSERT INTO `results` VALUES (1,1,1,0,'2014-03-17 10:57:55'),(2,2,4,0,'2014-03-17 14:22:12'),(3,1,1,0,'2014-03-17 14:44:16'),(4,4,3,50,'2014-03-17 21:02:41'),(5,1,5,0,'2014-04-06 11:38:52'),(6,1,2,50,'2014-04-06 11:40:12'),(7,1,2,0,'2014-04-06 11:42:09'),(8,4,3,0,'2014-04-06 15:52:14'),(9,1,6,0,'2014-04-10 11:16:07'),(10,1,15,8,'2014-04-14 17:13:44');
/*!40000 ALTER TABLE `results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sources`
--

DROP TABLE IF EXISTS `sources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) DEFAULT NULL,
  `lecture_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL,
  `state` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sources`
--

LOCK TABLES `sources` WRITE;
/*!40000 ALTER TABLE `sources` DISABLE KEYS */;
INSERT INTO `sources` VALUES (6,'application/pdf',2,'2014-03-17 10:55:50','2014-03-17 10:55:50','598108_04_Working_with_Arrays.pdf',NULL,''),(7,'video/x-flv',2,'2014-03-17 10:56:06','2014-03-17 10:56:06','947094_xxx.flv',NULL,''),(8,'image/jpeg',2,'2014-03-17 10:56:14','2014-03-17 10:56:14','431463_nozomisasaki.jpg',NULL,''),(9,'application/pdf',3,'2014-03-17 11:30:02','2014-03-17 11:30:02','730678_Lab_4_Working_with_Arrays.pdf',NULL,''),(11,'image/jpeg',3,'2014-03-17 11:30:19','2014-03-17 11:30:19','622889_sasaki.jpg',NULL,''),(12,'image/jpeg',3,'2014-03-17 11:30:23','2014-03-17 11:30:23','57259_nozomisasaki.jpg',NULL,''),(13,'application/pdf',4,'2014-03-17 14:18:54','2014-03-17 14:18:54','381921_Lab_4_Working_with_Arrays.pdf',NULL,''),(14,'video/x-flv',4,'2014-03-17 14:19:06','2014-03-17 14:19:06','333618_xxx.flv',NULL,''),(15,'image/jpeg',4,'2014-03-17 14:19:14','2014-03-17 14:19:14','570951_nozomisasaki.jpg',NULL,''),(16,'image/jpeg',4,'2014-03-17 14:19:18','2014-03-17 14:19:18','661615_sasaki.jpg',NULL,''),(17,'application/pdf',5,'2014-03-17 15:46:01','2014-03-17 15:46:01','623595_Lab_3_1_Conditional_Statements.pdf',NULL,''),(18,'image/jpeg',5,'2014-03-17 15:46:11','2014-03-17 15:46:11','450115_nozomisasaki.jpg',NULL,''),(20,'video/x-flv',5,'2014-03-17 15:48:59','2014-03-17 15:48:59','380868_xxx.flv',NULL,''),(21,'video/x-flv',5,'2014-03-17 15:49:08','2014-03-17 15:49:08','245402_xxx.flv',NULL,''),(22,'image/jpeg',5,'2014-03-17 15:50:26','2014-03-17 15:50:26','362544_download.jpg',NULL,''),(24,'application/pdf',8,'2014-03-24 03:54:55','2014-03-24 03:54:55','837609_Lab_4_Working_with_Arrays.pdf',NULL,''),(25,'video/x-flv',8,'2014-03-24 03:55:43','2014-03-24 03:55:43','86589_xxx.flv',NULL,''),(26,'image/jpeg',8,'2014-03-24 03:55:52','2014-03-24 03:55:52','746397_nozomisasaki.jpg',NULL,''),(27,'image/jpeg',8,'2014-03-24 03:56:13','2014-03-24 03:56:13','45058_sasaki.jpg',NULL,''),(28,'image/jpeg',8,'2014-03-24 04:02:54','2014-03-24 04:02:54','583124_sasaki.jpg',NULL,''),(29,'application/pdf',6,'2014-03-25 13:45:14','2014-03-25 13:45:14','290680_05W_01_???????????.pdf',NULL,''),(30,'application/pdf',9,'2014-04-01 10:22:21','2014-04-01 10:22:21','16252_120437_02_PHP_Variables_and_HTML_Input_Forms.pdf',NULL,''),(31,'application/pdf',10,'2014-04-06 09:13:46','2014-04-06 09:13:46','843864_02_PHP_Variables_and_HTML_Input_Forms.pdf',NULL,''),(32,'video/x-flv',10,'2014-04-06 09:13:55','2014-04-06 09:13:55','688608_xxx.flv',NULL,''),(33,'image/jpeg',10,'2014-04-06 09:14:02','2014-04-06 09:14:02','846143_sasaki.jpg',NULL,''),(34,'image/jpeg',10,'2014-04-06 09:14:09','2014-04-06 09:14:09','203345_no_zo_mi_sa_sa_ki.jpg',NULL,''),(35,'application/pdf',11,'2014-04-06 09:15:21','2014-04-06 09:15:21','55737_02_PHP_Variables_and_HTML_Input_Forms.pdf',NULL,''),(36,'image/jpeg',11,'2014-04-06 09:16:13','2014-04-06 09:16:13','816897_download.jpg',NULL,''),(37,'image/jpeg',11,'2014-04-06 09:16:19','2014-04-06 09:16:19','185473_sasaki.jpg',NULL,''),(38,'application/pdf',12,'2014-04-06 11:14:34','2014-04-06 11:14:34','945650_04W_02_è²¬ä»»ã«ã¤ã„ã¦.pdf',NULL,''),(39,'application/pdf',14,'2014-04-06 11:19:05','2014-04-06 11:19:05','93487_04W_02_è²¬ä»»ã«ã¤ã„ã¦.pdf',NULL,''),(40,'application/pdf',16,'2014-04-06 22:07:43','2014-04-06 22:07:43','264462_Lab_2_PHP_Variables_HTML_Input_Form.pdf',NULL,''),(41,'image/jpeg',16,'2014-04-06 22:18:10','2014-04-06 22:18:10','426275_download.jpg',NULL,''),(51,'application/pdf',29,'2014-04-08 23:18:36','2014-04-08 23:18:36','668094_02_PHP_Variables_and_HTML_Input_Forms.pdf',NULL,''),(52,'image/jpeg',29,'2014-04-08 23:18:47','2014-04-08 23:18:47','562970_sasaki.jpg',NULL,''),(53,'image/jpeg',29,'2014-04-08 23:18:53','2014-04-08 23:18:53','806534_no_zo_mi_sa_sa_ki.jpg',NULL,''),(54,'application/pdf',30,'2014-04-08 23:48:25','2014-04-08 23:48:25','906661_02_PHP_Variables_and_HTML_Input_Forms.pdf',NULL,''),(55,'image/jpeg',30,'2014-04-08 23:48:36','2014-04-08 23:48:36','208641_download.jpg',NULL,''),(56,'image/jpeg',30,'2014-04-08 23:48:41','2014-04-08 23:48:41','20549_no_zo_mi_sa_sa_ki.jpg',NULL,''),(59,'audio/mpeg',3,'2014-04-02 00:00:00','2014-04-09 00:00:00','mp3.mp3',NULL,'');
/*!40000 ALTER TABLE `sources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3802 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (3786,'Ngo Tat To'),(3787,'The Lu'),(3788,'Tho Moi'),(3789,'Ho Chi Minh'),(3790,'HEDSPI'),(3791,'K54'),(3792,'nghien cuu'),(3793,'gioi tre'),(3794,'sinh vien'),(3795,'Toan cao cap'),(3796,'Vat ly dai cuong'),(3797,'Hoa hoc'),(3798,'abc'),(3799,'linh'),(3800,'hom nay'),(3801,'');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tests`
--

DROP TABLE IF EXISTS `tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tests`
--

LOCK TABLES `tests` WRITE;
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;
INSERT INTO `tests` VALUES (1,'Test 1 _ Van 1',34,2,'2014-03-17 10:57:05','2014-03-17 10:57:05'),(2,'Test 2 _ Van 2',12,2,'2014-03-17 10:57:37','2014-03-17 10:57:37'),(3,'Test1 _ Tieng Anh 1',45,3,'2014-03-17 11:32:13','2014-03-17 11:32:13'),(4,'Test 2 _ Tieng Anh 2',45,3,'2014-03-17 11:32:39','2014-03-17 11:32:39'),(5,'Toan 2',23,4,'2014-03-17 14:21:27','2014-03-17 14:21:27'),(6,'Toan 3',23,4,'2014-03-17 14:21:53','2014-03-17 14:21:53'),(7,'Test1',13,8,'2014-03-25 14:08:56','2014-03-25 14:08:56'),(8,'Test2',12,8,'2014-03-25 14:09:11','2014-03-25 14:09:11'),(9,'Test 3',23,8,'2014-03-25 14:09:29','2014-03-25 14:09:29'),(10,'Tieng anh 1',12345,10,'2014-04-06 09:21:18','2014-04-06 09:21:18'),(11,'test toan 2',111,13,'2014-04-06 11:16:37','2014-04-06 11:16:37'),(12,'test 2 toan 2',1,13,'2014-04-06 11:17:08','2014-04-06 11:17:08'),(13,'test van xuan',1,14,'2014-04-06 11:20:01','2014-04-06 11:20:01'),(14,'test van 2',1,14,'2014-04-06 11:20:26','2014-04-06 11:20:26'),(15,'Bai test moi tao',0,3,'2014-04-14 17:13:19','2014-04-14 17:13:19');
/*!40000 ALTER TABLE `tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tsv_files`
--

DROP TABLE IF EXISTS `tsv_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tsv_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `id_code` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `test_id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tsv_files`
--

LOCK TABLES `tsv_files` WRITE;
/*!40000 ALTER TABLE `tsv_files` DISABLE KEYS */;
INSERT INTO `tsv_files` VALUES (1,'[Test][2][1395028625].tsv','TSV',0,'',1,0),(2,'[Test][2][1395028657].tsv','TSV',0,'',2,0),(3,'[Test][3][1395030733].tsv','TSV',0,'',3,0),(4,'[Test][3][1395030759].tsv','TSV',0,'',4,0),(5,'[Test][4][1395040887].tsv','TSV',0,'',5,0),(6,'[Test][4][1395040913].tsv','TSV',0,'',6,0),(7,'[Test][8][1395731336].tsv','TSV',0,'',7,0),(8,'[Test][8][1395731351].tsv','TSV',0,'',8,0),(9,'[Test][8][1395731369].tsv','TSV',0,'',9,0),(10,'[Test][10][1396750878].tsv','TSV',0,'',10,0),(11,'[Test][13][1396757797].tsv','TSV',0,'',11,0),(12,'[Test][13][1396757828].tsv','TSV',0,'',12,0),(13,'[Test][14][1396758001].tsv','TSV',0,'',13,0),(14,'[Test][14][1396758026].tsv','TSV',0,'',14,0),(15,'[Test][3][1397495599].tsv','TSV',0,'',15,0);
/*!40000 ALTER TABLE `tsv_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `sex` varchar(6) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `credit_card_No` varchar(50) DEFAULT NULL,
  `mobile_No` int(12) DEFAULT NULL,
  `verify` varchar(255) DEFAULT NULL,
  `bank_acc` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `state` varchar(10) DEFAULT 'new',
  `prevIP` varchar(30) DEFAULT NULL,
  `failedNo` int(11) DEFAULT '0',
  `first_password` varchar(255) DEFAULT NULL,
  `first_verify` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'quan123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','student','ntquan3291@gmail.com','Nguyen Trung  Quan','1991-02-03','man','Tan Cuong',NULL,1663541466,'','AA11324yu3','2014-03-17 10:45:47','2014-04-15 15:37:22','normal','127.0.0.2',0,NULL,NULL),(2,'cuong123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','manager','cuong@gmail.com','Hoang Cuong','1984-03-17','woman','Hai Duong',NULL,166645348,'12345','AA12345678','2014-03-17 11:05:55','2014-04-17 10:11:20','normal','127.0.0.1',0,NULL,NULL),(3,'xuan123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','manager','xuanvh@gmail.com','Vu Huy Xuan','1999-03-17','man','Bac ninh',NULL,12345678,'12345','AA11324yu3','2014-03-17 11:16:00','2014-03-25 14:40:23','locked',NULL,0,NULL,NULL),(4,'luc123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','teacher','luc@gmail.com','Luc Luong','2000-03-17','man','Ha Tay',NULL,12345678,'d56784559ed74d4178ebc40de9848b17e6e5d2e8','AA12345678','2014-03-17 11:28:43','2014-04-15 16:40:07','normal',NULL,0,'d56784559ed74d4178ebc40de9848b17e6e5d2e8','d56784559ed74d4178ebc40de9848b17e6e5d2e8'),(5,'linh123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','teacher','linh@gmail.com','Nguyen Van Linh','1998-05-06','man','Hai Phong',NULL,12345678,'12345','AA11324yu3','2014-03-17 11:33:58','2014-04-13 12:38:21','deleted','127.0.0.1',0,NULL,NULL),(6,'duy123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','teacher','duy@abc.com','Le Duy','2000-03-17','man','Vinh Phuc',NULL,12345678,'12345','AA12345678','2014-03-17 11:35:26','2014-03-30 20:32:49','deleted','127.0.0.1',0,NULL,NULL),(7,'viet123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','teacher','viet@example.com','Hoang Quoc Viet','2000-03-17','man','Vinh Phuc',NULL,12345678,'12345','AA11324yu3','2014-03-17 11:36:34','2014-03-25 14:40:36','locked','127.0.0.1',0,NULL,NULL),(8,'hieu123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','teacher','hieu@yahoo.com','Le Minh Hieu','2000-03-17','man','Vinh Phuc',NULL,12345678,'12345','AA11324yu3','2014-03-17 11:37:29','2014-03-24 00:03:07','locked','127.0.0.1',0,NULL,NULL),(9,'thang123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','teacher','thang@gmail.com','Lo Tat Thang','2000-03-17','man','Vinh Phuc',NULL,123456789,'12345','AA11324yu3','2014-03-17 11:39:50','2014-03-23 23:27:14','deleted','127.0.0.1',1,NULL,NULL),(10,'nghia123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','teacher','nghia@example.com','Nguyen Trung Nghia','2000-03-17','man','Ha Tay',NULL,12345678,'123456789','AA11324yu3','2014-03-17 11:55:38','2014-03-17 20:36:03','locked','127.0.0.1',0,NULL,NULL),(11,'fumi123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','teacher','fumi@gmail.com','Fumi Fujita','2000-03-17','man','Japan',NULL,123456789,'12345','AA11324yu3','2014-03-17 14:49:01','2014-03-17 20:35:32','locked','127.0.0.1',0,NULL,NULL),(12,'hung123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','teacher','hung@gmail.com','Nguyen Ngoc Phi Hung','1992-03-23','man','Tan Cuong',NULL,12345678,'4731a16e89b07737f482af8b30efa24ba75f9071','abc123456','2014-03-23 22:02:03','2014-04-06 14:39:44','normal','::1',0,'d56784559ed74d4178ebc40de9848b17e6e5d2e8','4731a16e89b07737f482af8b30efa24ba75f9071'),(13,'tuan123456','6b5b31c681153a3c3c28a4c5559af1b07455175b','student','tuan@gmail.com','Le Tuan','2000-03-23','man','Tan Cuong','AA123456',123456789,NULL,NULL,'2014-03-23 23:26:41','2014-03-24 00:02:53','locked','127.0.0.1',0,'6b5b31c681153a3c3c28a4c5559af1b07455175b',NULL),(14,'abc123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','manager','abc@gmail.com','ABC','2014-03-25','man','Tan Cuong',NULL,1234567,'bc09d6f4158b4659f842aeb3e1b8aab61a1ca947','abc123456','2014-03-25 14:45:05','2014-03-25 14:47:15','normal',NULL,0,'d56784559ed74d4178ebc40de9848b17e6e5d2e8','bc09d6f4158b4659f842aeb3e1b8aab61a1ca947'),(15,'ba123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','student','ba@example.com','Van Linh','2000-03-30','man','Tan Cuong','AA123456',12345678,NULL,NULL,'2014-03-30 21:02:18','2014-04-13 10:26:08','deleted','127.0.0.1',0,'d56784559ed74d4178ebc40de9848b17e6e5d2e8',NULL),(16,'me123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','student','me@example.com','Cao Thi Tam','2000-03-30','man','Tan Cuong','AA123456',123456789,NULL,NULL,'2014-03-30 22:09:53','2014-04-13 10:26:00','locked','127.0.0.1',0,'d56784559ed74d4178ebc40de9848b17e6e5d2e8',NULL),(17,'bo123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','teacher','bo@example.com','Nguyen Trung Chuong','2000-03-30','man','Tan Cuong',NULL,123456789,'bc09d6f4158b4659f842aeb3e1b8aab61a1ca947','abc123456','2014-03-30 22:11:18','2014-03-30 22:11:18','new','127.0.0.1',0,'d56784559ed74d4178ebc40de9848b17e6e5d2e8','bc09d6f4158b4659f842aeb3e1b8aab61a1ca947'),(18,'cha123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','teacher','cha@example.com','Nguyen Trung Chuong','2000-03-30','man','Tan Cuong',NULL,123456789,'bc09d6f4158b4659f842aeb3e1b8aab61a1ca947','AA12345678','2014-03-30 22:13:39','2014-03-30 22:14:51','normal','192.168.1.1',0,'d56784559ed74d4178ebc40de9848b17e6e5d2e8','bc09d6f4158b4659f842aeb3e1b8aab61a1ca947'),(19,'cha1123456789','d56784559ed74d4178ebc40de9848b17e6e5d2e8','teacher','cha1@example.com','Nguyen Trung Chuong','2000-03-30','man','Tan Cuong',NULL,123456789,'bc09d6f4158b4659f842aeb3e1b8aab61a1ca947','AA12345678','2014-03-30 22:29:59','2014-03-30 22:29:59','0','127.0.0.1',0,'d56784559ed74d4178ebc40de9848b17e6e5d2e8','bc09d6f4158b4659f842aeb3e1b8aab61a1ca947'),(20,'cha2123456789','d56784559ed74d4178ebc40de9848b17e6e5d2e8','teacher','cha2@example.com','Nguyen Trung Chuong','2000-03-30','man','Tan Cuong',NULL,123456789,'d56784559ed74d4178ebc40de9848b17e6e5d2e8','AA12345678','2014-03-30 22:34:08','2014-03-30 22:38:14','normal','127.0.0.1',0,'d56784559ed74d4178ebc40de9848b17e6e5d2e8','d56784559ed74d4178ebc40de9848b17e6e5d2e8'),(21,'bang123456','d56784559ed74d4178ebc40de9848b17e6e5d2e8','teacher','bang@gmail.com','Nguyen Van Bang','2000-04-12','man','Tan Cuong',NULL,1234568230,'d56784559ed74d4178ebc40de9848b17e6e5d2e8','AA12345678','2014-04-12 12:50:32','2014-04-12 19:43:45','blocked','127.0.0.1',0,'d56784559ed74d4178ebc40de9848b17e6e5d2e8','d56784559ed74d4178ebc40de9848b17e6e5d2e8');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vovans`
--

DROP TABLE IF EXISTS `vovans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vovans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lecture_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vovans`
--

LOCK TABLES `vovans` WRITE;
/*!40000 ALTER TABLE `vovans` DISABLE KEYS */;
INSERT INTO `vovans` VALUES (14,29,3790),(15,29,3791),(16,29,3792),(17,29,3793),(18,29,3794),(19,30,3795),(20,30,3796),(21,30,3797),(22,30,3790),(23,31,3798),(24,31,3799),(25,31,3800),(28,3,3801);
/*!40000 ALTER TABLE `vovans` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-17 20:07:27
