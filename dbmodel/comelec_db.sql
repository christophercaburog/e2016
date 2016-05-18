-- MySQL dump 10.11
--
-- Host: localhost    Database: comelec_db
-- ------------------------------------------------------
-- Server version	5.0.45

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
-- Table structure for table `app_modules`
--

DROP TABLE IF EXISTS `app_modules`;
CREATE TABLE `app_modules` (
  `mnu_id` int(11) NOT NULL auto_increment,
  `mnu_name` varchar(64) collate latin1_general_ci NOT NULL,
  `mnu_desc` varchar(100) collate latin1_general_ci NOT NULL,
  `mnu_icon` varchar(64) collate latin1_general_ci NOT NULL,
  `mnu_parent` int(11) NOT NULL default '0',
  `mnu_ord` int(11) NOT NULL default '1',
  `mnu_link` varchar(255) collate latin1_general_ci NOT NULL,
  `mnu_status` tinyint(2) NOT NULL default '1',
  `mnu_link_info` text collate latin1_general_ci,
  PRIMARY KEY  (`mnu_id`),
  KEY `mnu_parent` (`mnu_parent`,`mnu_ord`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `app_modules`
--

LOCK TABLES `app_modules` WRITE;
/*!40000 ALTER TABLE `app_modules` DISABLE KEYS */;
INSERT INTO `app_modules` VALUES (1,'Setup','','',0,8,'',1,'a:18:{s:8:\"linkpage\";s:0:\"\";s:7:\"statpos\";s:0:\"\";s:11:\"querystring\";s:0:\"\";s:14:\"maincontroller\";s:0:\"\";s:18:\"default_controller\";s:0:\"\";s:19:\"controller_filename\";s:0:\"\";s:14:\"class_filename\";s:0:\"\";s:10:\"class_name\";s:0:\"\";s:17:\"template_filename\";s:0:\"\";s:21:\"templateform_filename\";s:0:\"\";s:7:\"chkmenu\";s:1:\"1\";s:7:\"chkmain\";N;s:13:\"chkcontroller\";N;s:8:\"chkclass\";N;s:11:\"chktemplate\";N;s:15:\"chktemplateform\";N;s:5:\"ud_id\";a:2:{i:0;s:1:\"2\";i:1;s:1:\"1\";}s:9:\"user_type\";a:2:{i:0;s:19:\"Super Administrator\";i:1;s:13:\"Administrator\";}}'),(2,'Manage User','','',1,3,'setup.php?statpos=manageuser',1,'a:18:{s:8:\"linkpage\";s:9:\"setup.php\";s:7:\"statpos\";s:10:\"manageuser\";s:11:\"querystring\";s:0:\"\";s:14:\"maincontroller\";s:0:\"\";s:18:\"default_controller\";s:0:\"\";s:19:\"controller_filename\";s:0:\"\";s:14:\"class_filename\";s:0:\"\";s:10:\"class_name\";s:0:\"\";s:17:\"template_filename\";s:0:\"\";s:21:\"templateform_filename\";s:0:\"\";s:7:\"chkmenu\";s:1:\"1\";s:7:\"chkmain\";N;s:13:\"chkcontroller\";N;s:8:\"chkclass\";N;s:11:\"chktemplate\";N;s:15:\"chktemplateform\";N;s:5:\"ud_id\";a:2:{i:0;s:1:\"2\";i:1;s:1:\"1\";}s:9:\"user_type\";a:2:{i:0;s:19:\"Super Administrator\";i:1;s:13:\"Administrator\";}}'),(3,'Manage Modules','','',1,2,'setup.php?statpos=managemodule',1,'a:18:{s:8:\"linkpage\";s:9:\"setup.php\";s:7:\"statpos\";s:12:\"managemodule\";s:11:\"querystring\";s:0:\"\";s:14:\"maincontroller\";s:0:\"\";s:18:\"default_controller\";s:0:\"\";s:19:\"controller_filename\";s:0:\"\";s:14:\"class_filename\";s:0:\"\";s:10:\"class_name\";s:0:\"\";s:17:\"template_filename\";s:0:\"\";s:21:\"templateform_filename\";s:0:\"\";s:7:\"chkmenu\";s:1:\"1\";s:7:\"chkmain\";N;s:13:\"chkcontroller\";N;s:8:\"chkclass\";N;s:11:\"chktemplate\";N;s:15:\"chktemplateform\";N;s:5:\"ud_id\";a:2:{i:0;s:1:\"2\";i:1;s:1:\"1\";}s:9:\"user_type\";a:1:{i:0;s:19:\"Super Administrator\";}}'),(4,'Manage User Type','','',1,1,'setup.php?statpos=manageusertype',1,'a:18:{s:8:\"linkpage\";s:9:\"setup.php\";s:7:\"statpos\";s:14:\"manageusertype\";s:11:\"querystring\";s:0:\"\";s:14:\"maincontroller\";s:0:\"\";s:18:\"default_controller\";s:0:\"\";s:19:\"controller_filename\";s:0:\"\";s:14:\"class_filename\";s:0:\"\";s:10:\"class_name\";s:0:\"\";s:17:\"template_filename\";s:0:\"\";s:21:\"templateform_filename\";s:0:\"\";s:7:\"chkmenu\";s:1:\"1\";s:7:\"chkmain\";N;s:13:\"chkcontroller\";N;s:8:\"chkclass\";N;s:11:\"chktemplate\";N;s:15:\"chktemplateform\";N;s:5:\"ud_id\";a:2:{i:0;s:1:\"2\";i:1;s:1:\"1\";}s:9:\"user_type\";a:1:{i:0;s:19:\"Super Administrator\";}}'),(5,'Manage Department','','',1,4,'setup.php?statpos=managedept',1,'a:18:{s:8:\"linkpage\";s:9:\"setup.php\";s:7:\"statpos\";s:10:\"managedept\";s:11:\"querystring\";s:0:\"\";s:14:\"maincontroller\";s:15:\"admin/setup.php\";s:18:\"default_controller\";s:15:\"admin/admin.php\";s:19:\"controller_filename\";s:27:\"admin/setup/manage_dept.php\";s:14:\"class_filename\";s:33:\"admin/setup/manage_dept.class.php\";s:10:\"class_name\";s:13:\"clsManageDept\";s:17:\"template_filename\";s:31:\"admin/setup/manage_dept.tpl.php\";s:21:\"templateform_filename\";s:36:\"admin/setup/manage_dept_form.tpl.php\";s:7:\"chkmenu\";s:1:\"1\";s:7:\"chkmain\";N;s:13:\"chkcontroller\";N;s:8:\"chkclass\";N;s:11:\"chktemplate\";N;s:15:\"chktemplateform\";N;s:5:\"ud_id\";a:2:{i:0;s:1:\"2\";i:1;s:1:\"1\";}s:9:\"user_type\";a:1:{i:0;s:19:\"Super Administrator\";}}'),(7,'Home','','',0,1,'index.php',1,'a:18:{s:8:\"linkpage\";s:9:\"index.php\";s:7:\"statpos\";s:0:\"\";s:11:\"querystring\";s:0:\"\";s:14:\"maincontroller\";s:0:\"\";s:18:\"default_controller\";s:0:\"\";s:19:\"controller_filename\";s:0:\"\";s:14:\"class_filename\";s:0:\"\";s:10:\"class_name\";s:0:\"\";s:17:\"template_filename\";s:0:\"\";s:21:\"templateform_filename\";s:0:\"\";s:7:\"chkmenu\";s:1:\"1\";s:7:\"chkmain\";N;s:13:\"chkcontroller\";N;s:8:\"chkclass\";N;s:11:\"chktemplate\";N;s:15:\"chktemplateform\";N;s:5:\"ud_id\";a:2:{i:0;s:1:\"2\";i:1;s:1:\"1\";}s:9:\"user_type\";a:2:{i:0;s:19:\"Super Administrator\";i:1;s:13:\"Administrator\";}}');
/*!40000 ALTER TABLE `app_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_userdept`
--

DROP TABLE IF EXISTS `app_userdept`;
CREATE TABLE `app_userdept` (
  `ud_id` int(10) unsigned NOT NULL auto_increment,
  `ud_name` varchar(45) collate latin1_general_ci default NULL,
  `ud_desc` varchar(45) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`ud_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `app_userdept`
--

LOCK TABLES `app_userdept` WRITE;
/*!40000 ALTER TABLE `app_userdept` DISABLE KEYS */;
INSERT INTO `app_userdept` VALUES (1,'RND','    '),(2,'Admin',NULL);
/*!40000 ALTER TABLE `app_userdept` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_users`
--

DROP TABLE IF EXISTS `app_users`;
CREATE TABLE `app_users` (
  `user_id` int(11) NOT NULL auto_increment,
  `ud_id` int(10) unsigned NOT NULL,
  `user_name` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `user_fullname` varchar(255) character set latin1 collate latin1_general_ci NOT NULL,
  `user_password` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `user_type` varchar(64) character set latin1 collate latin1_general_ci NOT NULL,
  `user_status` tinyint(2) NOT NULL default '1',
  PRIMARY KEY  (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `user_password` (`user_password`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_users`
--

LOCK TABLES `app_users` WRITE;
/*!40000 ALTER TABLE `app_users` DISABLE KEYS */;
INSERT INTO `app_users` VALUES (1,1,'biboy','Arnold Orbista','45d9fad737b0dac55e4a15e33be17178','Super Administrator',1),(2,2,'admin','Administrator','21232f297a57a5a743894a0e4a801fc3','Administrator',2);
/*!40000 ALTER TABLE `app_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_userstypeaccess`
--

DROP TABLE IF EXISTS `app_userstypeaccess`;
CREATE TABLE `app_userstypeaccess` (
  `uta_id` int(11) NOT NULL auto_increment,
  `ud_id` int(10) unsigned NOT NULL,
  `mnu_id` int(11) NOT NULL,
  `user_type` varchar(64) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`uta_id`),
  KEY `mnu_id` (`mnu_id`),
  KEY `user_type` (`user_type`),
  KEY `app_userstypeaccess_FKIndex1` (`user_type`),
  KEY `app_userstypeaccess_FKIndex2` (`mnu_id`),
  KEY `app_userstypeaccess_FKIndex3` (`ud_id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `app_userstypeaccess`
--

LOCK TABLES `app_userstypeaccess` WRITE;
/*!40000 ALTER TABLE `app_userstypeaccess` DISABLE KEYS */;
INSERT INTO `app_userstypeaccess` VALUES (20,2,5,'Super Administrator'),(19,2,2,'Super Administrator'),(18,2,3,'Super Administrator'),(17,2,4,'Super Administrator'),(16,2,1,'Super Administrator'),(46,1,7,'Administrator'),(22,1,1,'Super Administrator'),(45,1,7,'Super Administrator'),(28,2,1,'Administrator'),(23,1,4,'Super Administrator'),(24,1,3,'Super Administrator'),(25,1,2,'Super Administrator'),(26,1,5,'Super Administrator'),(29,2,4,'Administrator'),(30,2,3,'Administrator'),(31,2,2,'Administrator'),(32,2,5,'Administrator'),(44,2,7,'Administrator'),(34,1,1,'Administrator'),(35,1,4,'Administrator'),(36,1,3,'Administrator'),(37,1,2,'Administrator'),(38,1,5,'Administrator'),(43,2,7,'Super Administrator');
/*!40000 ALTER TABLE `app_userstypeaccess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_usertype`
--

DROP TABLE IF EXISTS `app_usertype`;
CREATE TABLE `app_usertype` (
  `user_type` varchar(64) collate latin1_general_ci NOT NULL,
  `user_type_name` varchar(64) collate latin1_general_ci NOT NULL,
  `user_type_ord` int(11) NOT NULL,
  `user_type_status` tinyint(2) NOT NULL default '1',
  `user_type_access` text collate latin1_general_ci,
  `user_type_dept` text collate latin1_general_ci,
  PRIMARY KEY  (`user_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `app_usertype`
--

LOCK TABLES `app_usertype` WRITE;
/*!40000 ALTER TABLE `app_usertype` DISABLE KEYS */;
INSERT INTO `app_usertype` VALUES ('Super Administrator','Super Administrator',1,1,'a:6:{i:7;s:1:\"7\";i:1;s:1:\"1\";i:4;s:1:\"4\";i:3;s:1:\"3\";i:2;s:1:\"2\";i:5;s:1:\"5\";}','a:2:{i:0;s:1:\"2\";i:1;s:1:\"1\";}'),('Administrator','Administrator',2,1,'a:6:{i:7;s:1:\"7\";i:1;s:1:\"1\";i:4;s:1:\"4\";i:3;s:1:\"3\";i:2;s:1:\"2\";i:5;s:1:\"5\";}','a:2:{i:0;s:1:\"2\";i:1;s:1:\"1\";}'),('Web Master','Web Master',3,1,NULL,NULL),('Custom User Type','Custom User Type',4,1,NULL,NULL);
/*!40000 ALTER TABLE `app_usertype` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-03-05 22:33:44
