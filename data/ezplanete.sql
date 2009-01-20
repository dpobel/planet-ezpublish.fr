-- MySQL dump 10.11
--
-- Host: localhost    Database: ezplanete
-- ------------------------------------------------------
-- Server version	5.0.67-0ubuntu6-log

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
-- Table structure for table `ezapprove_items`
--

DROP TABLE IF EXISTS `ezapprove_items`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezapprove_items` (
  `collaboration_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `workflow_process_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezapprove_items`
--

LOCK TABLES `ezapprove_items` WRITE;
/*!40000 ALTER TABLE `ezapprove_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezapprove_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezbasket`
--

DROP TABLE IF EXISTS `ezbasket`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezbasket` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) NOT NULL default '0',
  `productcollection_id` int(11) NOT NULL default '0',
  `session_id` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `ezbasket_session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezbasket`
--

LOCK TABLES `ezbasket` WRITE;
/*!40000 ALTER TABLE `ezbasket` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezbasket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezbinaryfile`
--

DROP TABLE IF EXISTS `ezbinaryfile`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezbinaryfile` (
  `contentobject_attribute_id` int(11) NOT NULL default '0',
  `download_count` int(11) NOT NULL default '0',
  `filename` varchar(255) NOT NULL default '',
  `mime_type` varchar(50) NOT NULL default '',
  `original_filename` varchar(255) NOT NULL default '',
  `version` int(11) NOT NULL default '0',
  PRIMARY KEY  (`contentobject_attribute_id`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezbinaryfile`
--

LOCK TABLES `ezbinaryfile` WRITE;
/*!40000 ALTER TABLE `ezbinaryfile` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezbinaryfile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcollab_group`
--

DROP TABLE IF EXISTS `ezcollab_group`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcollab_group` (
  `created` int(11) NOT NULL default '0',
  `depth` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `is_open` int(11) NOT NULL default '1',
  `modified` int(11) NOT NULL default '0',
  `parent_group_id` int(11) NOT NULL default '0',
  `path_string` varchar(255) NOT NULL default '',
  `priority` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ezcollab_group_depth` (`depth`),
  KEY `ezcollab_group_path` (`path_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcollab_group`
--

LOCK TABLES `ezcollab_group` WRITE;
/*!40000 ALTER TABLE `ezcollab_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezcollab_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcollab_item`
--

DROP TABLE IF EXISTS `ezcollab_item`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcollab_item` (
  `created` int(11) NOT NULL default '0',
  `creator_id` int(11) NOT NULL default '0',
  `data_float1` float NOT NULL default '0',
  `data_float2` float NOT NULL default '0',
  `data_float3` float NOT NULL default '0',
  `data_int1` int(11) NOT NULL default '0',
  `data_int2` int(11) NOT NULL default '0',
  `data_int3` int(11) NOT NULL default '0',
  `data_text1` longtext NOT NULL,
  `data_text2` longtext NOT NULL,
  `data_text3` longtext NOT NULL,
  `id` int(11) NOT NULL auto_increment,
  `modified` int(11) NOT NULL default '0',
  `status` int(11) NOT NULL default '1',
  `type_identifier` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcollab_item`
--

LOCK TABLES `ezcollab_item` WRITE;
/*!40000 ALTER TABLE `ezcollab_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezcollab_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcollab_item_group_link`
--

DROP TABLE IF EXISTS `ezcollab_item_group_link`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcollab_item_group_link` (
  `collaboration_id` int(11) NOT NULL default '0',
  `created` int(11) NOT NULL default '0',
  `group_id` int(11) NOT NULL default '0',
  `is_active` int(11) NOT NULL default '1',
  `is_read` int(11) NOT NULL default '0',
  `last_read` int(11) NOT NULL default '0',
  `modified` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`collaboration_id`,`group_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcollab_item_group_link`
--

LOCK TABLES `ezcollab_item_group_link` WRITE;
/*!40000 ALTER TABLE `ezcollab_item_group_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezcollab_item_group_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcollab_item_message_link`
--

DROP TABLE IF EXISTS `ezcollab_item_message_link`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcollab_item_message_link` (
  `collaboration_id` int(11) NOT NULL default '0',
  `created` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `message_id` int(11) NOT NULL default '0',
  `message_type` int(11) NOT NULL default '0',
  `modified` int(11) NOT NULL default '0',
  `participant_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcollab_item_message_link`
--

LOCK TABLES `ezcollab_item_message_link` WRITE;
/*!40000 ALTER TABLE `ezcollab_item_message_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezcollab_item_message_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcollab_item_participant_link`
--

DROP TABLE IF EXISTS `ezcollab_item_participant_link`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcollab_item_participant_link` (
  `collaboration_id` int(11) NOT NULL default '0',
  `created` int(11) NOT NULL default '0',
  `is_active` int(11) NOT NULL default '1',
  `is_read` int(11) NOT NULL default '0',
  `last_read` int(11) NOT NULL default '0',
  `modified` int(11) NOT NULL default '0',
  `participant_id` int(11) NOT NULL default '0',
  `participant_role` int(11) NOT NULL default '1',
  `participant_type` int(11) NOT NULL default '1',
  PRIMARY KEY  (`collaboration_id`,`participant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcollab_item_participant_link`
--

LOCK TABLES `ezcollab_item_participant_link` WRITE;
/*!40000 ALTER TABLE `ezcollab_item_participant_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezcollab_item_participant_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcollab_item_status`
--

DROP TABLE IF EXISTS `ezcollab_item_status`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcollab_item_status` (
  `collaboration_id` int(11) NOT NULL default '0',
  `is_active` int(11) NOT NULL default '1',
  `is_read` int(11) NOT NULL default '0',
  `last_read` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`collaboration_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcollab_item_status`
--

LOCK TABLES `ezcollab_item_status` WRITE;
/*!40000 ALTER TABLE `ezcollab_item_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezcollab_item_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcollab_notification_rule`
--

DROP TABLE IF EXISTS `ezcollab_notification_rule`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcollab_notification_rule` (
  `collab_identifier` varchar(255) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `user_id` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcollab_notification_rule`
--

LOCK TABLES `ezcollab_notification_rule` WRITE;
/*!40000 ALTER TABLE `ezcollab_notification_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezcollab_notification_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcollab_profile`
--

DROP TABLE IF EXISTS `ezcollab_profile`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcollab_profile` (
  `created` int(11) NOT NULL default '0',
  `data_text1` longtext NOT NULL,
  `id` int(11) NOT NULL auto_increment,
  `main_group` int(11) NOT NULL default '0',
  `modified` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcollab_profile`
--

LOCK TABLES `ezcollab_profile` WRITE;
/*!40000 ALTER TABLE `ezcollab_profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezcollab_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcollab_simple_message`
--

DROP TABLE IF EXISTS `ezcollab_simple_message`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcollab_simple_message` (
  `created` int(11) NOT NULL default '0',
  `creator_id` int(11) NOT NULL default '0',
  `data_float1` float NOT NULL default '0',
  `data_float2` float NOT NULL default '0',
  `data_float3` float NOT NULL default '0',
  `data_int1` int(11) NOT NULL default '0',
  `data_int2` int(11) NOT NULL default '0',
  `data_int3` int(11) NOT NULL default '0',
  `data_text1` longtext NOT NULL,
  `data_text2` longtext NOT NULL,
  `data_text3` longtext NOT NULL,
  `id` int(11) NOT NULL auto_increment,
  `message_type` varchar(40) NOT NULL default '',
  `modified` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcollab_simple_message`
--

LOCK TABLES `ezcollab_simple_message` WRITE;
/*!40000 ALTER TABLE `ezcollab_simple_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezcollab_simple_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcontent_language`
--

DROP TABLE IF EXISTS `ezcontent_language`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcontent_language` (
  `disabled` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL default '0',
  `locale` varchar(20) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `ezcontent_language_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcontent_language`
--

LOCK TABLES `ezcontent_language` WRITE;
/*!40000 ALTER TABLE `ezcontent_language` DISABLE KEYS */;
INSERT INTO `ezcontent_language` VALUES (0,2,'fre-FR','Français (France)');
/*!40000 ALTER TABLE `ezcontent_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcontentbrowsebookmark`
--

DROP TABLE IF EXISTS `ezcontentbrowsebookmark`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcontentbrowsebookmark` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `node_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ezcontentbrowsebookmark_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcontentbrowsebookmark`
--

LOCK TABLES `ezcontentbrowsebookmark` WRITE;
/*!40000 ALTER TABLE `ezcontentbrowsebookmark` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezcontentbrowsebookmark` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcontentbrowserecent`
--

DROP TABLE IF EXISTS `ezcontentbrowserecent`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcontentbrowserecent` (
  `created` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `node_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ezcontentbrowserecent_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcontentbrowserecent`
--

LOCK TABLES `ezcontentbrowserecent` WRITE;
/*!40000 ALTER TABLE `ezcontentbrowserecent` DISABLE KEYS */;
INSERT INTO `ezcontentbrowserecent` VALUES (1232278536,1,'eZ Publish',2,14),(1232408124,5,'Planétarium',140,14),(1232401453,6,'Blogs',141,14);
/*!40000 ALTER TABLE `ezcontentbrowserecent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcontentclass`
--

DROP TABLE IF EXISTS `ezcontentclass`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcontentclass` (
  `always_available` int(11) NOT NULL default '0',
  `contentobject_name` varchar(255) default NULL,
  `created` int(11) NOT NULL default '0',
  `creator_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `identifier` varchar(50) NOT NULL default '',
  `initial_language_id` int(11) NOT NULL default '0',
  `is_container` int(11) NOT NULL default '0',
  `language_mask` int(11) NOT NULL default '0',
  `modified` int(11) NOT NULL default '0',
  `modifier_id` int(11) NOT NULL default '0',
  `remote_id` varchar(100) NOT NULL default '',
  `serialized_name_list` longtext,
  `sort_field` int(11) NOT NULL default '1',
  `sort_order` int(11) NOT NULL default '1',
  `url_alias_name` varchar(255) default NULL,
  `version` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`,`version`),
  KEY `ezcontentclass_version` (`version`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcontentclass`
--

LOCK TABLES `ezcontentclass` WRITE;
/*!40000 ALTER TABLE `ezcontentclass` DISABLE KEYS */;
INSERT INTO `ezcontentclass` VALUES (1,'<short_name|name>',1024392098,14,1,'folder',2,1,3,1232300503,14,'a3d405b81be900468eb153d774f4f0d2','a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:6:\"Folder\";}',1,1,'',0),(1,'<name>',1024392098,14,3,'user_group',2,1,3,1048494743,14,'25b4268cdcd01921b808a0d854b877ef','a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:10:\"User group\";}',1,1,'',0),(1,'<first_name> <last_name>',1024392098,14,4,'user',2,0,3,1082018364,14,'40faa822edc579b02c25f6bb7beec3ad','a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:4:\"User\";}',1,1,'',0),(1,'<name>',1031484992,8,5,'image',2,0,3,1048494784,14,'f6df12aa74e36230eb675f364fccd25a','a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:5:\"Image\";}',1,1,'',0),(1,'<name>',1052385472,14,12,'file',2,0,3,1052385669,14,'637d58bfddf164627bdfd265733280a0','a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:4:\"File\";}',1,1,'',0),(1,'<name>',1081858024,14,14,'common_ini_settings',2,0,3,1081858024,14,'ffedf2e73b1ea0c3e630e42e2db9c900','a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:19:\"Common ini settings\";}',1,1,'',0),(1,'<title>',1081858045,14,15,'template_look',2,0,3,1081858045,14,'59b43cd9feaaf0e45ac974fb4bbd3f92','a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:13:\"Template look\";}',1,1,'',0),(0,'<title>',1231678036,14,16,'planet',2,1,3,1232300555,14,'8720a2d099425334e530e1b301db20e9','a:2:{s:6:\"fre-FR\";s:7:\"Planete\";s:16:\"always-available\";s:6:\"fre-FR\";}',2,0,'',0),(0,'<url>',1231678183,14,17,'site',2,1,3,1232300837,14,'fb2c2cc59c1cbe406c0be0e165d3413f','a:2:{s:6:\"fre-FR\";s:4:\"Site\";s:16:\"always-available\";s:6:\"fre-FR\";}',2,0,'<urlid>',0),(0,'<title>',1231678735,14,18,'post',2,0,3,1232300863,14,'100eccc97f4be45b4528ceffc62bac11','a:2:{s:6:\"fre-FR\";s:9:\"Blog post\";s:16:\"always-available\";s:6:\"fre-FR\";}',1,1,'<urlid>',0),(0,'<title>',1232278172,14,20,'contact',2,0,3,1232300522,14,'91978c8119bc9c482f3ce80b49836a4a','a:2:{s:6:\"fre-FR\";s:21:\"Formulaire de contact\";s:16:\"always-available\";s:6:\"fre-FR\";}',1,1,'',0),(0,'<title>',1232278434,14,21,'page',2,0,3,1232300540,14,'f1e371bec68ba30e6a04d4f32401412c','a:2:{s:6:\"fre-FR\";s:4:\"Page\";s:16:\"always-available\";s:6:\"fre-FR\";}',1,1,'',0);
/*!40000 ALTER TABLE `ezcontentclass` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcontentclass_attribute`
--

DROP TABLE IF EXISTS `ezcontentclass_attribute`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcontentclass_attribute` (
  `can_translate` int(11) default '1',
  `contentclass_id` int(11) NOT NULL default '0',
  `data_float1` float default NULL,
  `data_float2` float default NULL,
  `data_float3` float default NULL,
  `data_float4` float default NULL,
  `data_int1` int(11) default NULL,
  `data_int2` int(11) default NULL,
  `data_int3` int(11) default NULL,
  `data_int4` int(11) default NULL,
  `data_text1` varchar(50) default NULL,
  `data_text2` varchar(50) default NULL,
  `data_text3` varchar(50) default NULL,
  `data_text4` varchar(255) default NULL,
  `data_text5` longtext,
  `data_type_string` varchar(50) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `identifier` varchar(50) NOT NULL default '',
  `is_information_collector` int(11) NOT NULL default '0',
  `is_required` int(11) NOT NULL default '0',
  `is_searchable` int(11) NOT NULL default '0',
  `placement` int(11) NOT NULL default '0',
  `serialized_name_list` longtext NOT NULL,
  `version` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`,`version`),
  KEY `ezcontentclass_attr_ccid` (`contentclass_id`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcontentclass_attribute`
--

LOCK TABLES `ezcontentclass_attribute` WRITE;
/*!40000 ALTER TABLE `ezcontentclass_attribute` DISABLE KEYS */;
INSERT INTO `ezcontentclass_attribute` VALUES (1,1,0,0,0,0,255,0,0,0,'Folder','','','','','ezstring',4,'name',0,1,0,1,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:4:\"Name\";}',0),(1,3,0,0,0,0,255,0,0,0,'','','','','','ezstring',6,'name',0,1,1,1,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:4:\"Name\";}',0),(1,3,0,0,0,0,255,0,0,0,'','','','','','ezstring',7,'description',0,0,1,2,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:11:\"Description\";}',0),(1,4,0,0,0,0,255,0,0,0,'','','','','','ezstring',8,'first_name',0,1,1,1,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:10:\"First name\";}',0),(1,4,0,0,0,0,255,0,0,0,'','','','','','ezstring',9,'last_name',0,1,1,2,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:9:\"Last name\";}',0),(1,4,0,0,0,0,0,0,0,0,'','','','','','ezuser',12,'user_account',0,1,1,3,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:12:\"User account\";}',0),(1,5,0,0,0,0,150,0,0,0,'','','','','','ezstring',116,'name',0,1,1,1,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:4:\"Name\";}',0),(1,5,0,0,0,0,10,0,0,0,'','','','','','ezxmltext',117,'caption',0,0,1,2,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:7:\"Caption\";}',0),(1,5,0,0,0,0,2,0,0,0,'','','','','','ezimage',118,'image',0,0,0,3,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:5:\"Image\";}',0),(1,1,0,0,0,0,5,0,0,0,'','','','','','ezxmltext',119,'short_description',0,0,0,3,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:17:\"Short description\";}',0),(1,12,0,0,0,0,0,0,0,0,'New file','','','','','ezstring',146,'name',0,1,1,1,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:4:\"Name\";}',0),(1,12,0,0,0,0,10,0,0,0,'','','','','','ezxmltext',147,'description',0,0,1,2,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:11:\"Description\";}',0),(1,12,0,0,0,0,0,0,0,0,'','','','','','ezbinaryfile',148,'file',0,1,0,3,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:4:\"File\";}',0),(1,1,0,0,0,0,100,0,0,0,'','','','','','ezstring',155,'short_name',0,0,0,2,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:10:\"Short name\";}',0),(1,1,0,0,0,0,20,0,0,0,'','','','','','ezxmltext',156,'description',0,0,0,4,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:11:\"Description\";}',0),(0,1,0,0,0,0,0,0,1,0,'','','','','','ezboolean',158,'show_children',0,0,0,5,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:13:\"Show children\";}',0),(1,14,0,0,0,0,0,0,0,0,'','','','','','ezstring',159,'name',0,0,1,1,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:4:\"Name\";}',0),(1,14,0,0,0,0,1,0,0,0,'site.ini','SiteSettings','IndexPage','','override;user;admin;demo','ezinisetting',160,'indexpage',0,0,0,2,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:10:\"Index Page\";}',0),(1,14,0,0,0,0,1,0,0,0,'site.ini','SiteSettings','DefaultPage','','override;user;admin;demo','ezinisetting',161,'defaultpage',0,0,0,3,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:12:\"Default Page\";}',0),(1,14,0,0,0,0,2,0,0,0,'site.ini','DebugSettings','DebugOutput','','override;user;admin;demo','ezinisetting',162,'debugoutput',0,0,0,4,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:12:\"Debug Output\";}',0),(1,14,0,0,0,0,2,0,0,0,'site.ini','DebugSettings','DebugByIP','','override;user;admin;demo','ezinisetting',163,'debugbyip',0,0,0,5,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:11:\"Debug By IP\";}',0),(1,14,0,0,0,0,6,0,0,0,'site.ini','DebugSettings','DebugIPList','','override;user;admin;demo','ezinisetting',164,'debugiplist',0,0,0,6,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:13:\"Debug IP List\";}',0),(1,14,0,0,0,0,2,0,0,0,'site.ini','DebugSettings','DebugRedirection','','override;user;admin;demo','ezinisetting',165,'debugredirection',0,0,0,7,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:17:\"Debug Redirection\";}',0),(1,14,0,0,0,0,2,0,0,0,'site.ini','ContentSettings','ViewCaching','','override;user;admin;demo','ezinisetting',166,'viewcaching',0,0,0,8,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:12:\"View Caching\";}',0),(1,14,0,0,0,0,2,0,0,0,'site.ini','TemplateSettings','TemplateCache','','override;user;admin;demo','ezinisetting',167,'templatecache',0,0,0,9,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:14:\"Template Cache\";}',0),(1,14,0,0,0,0,2,0,0,0,'site.ini','TemplateSettings','TemplateCompile','','override;user;admin;demo','ezinisetting',168,'templatecompile',0,0,0,10,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:16:\"Template Compile\";}',0),(1,14,0,0,0,0,6,0,0,0,'image.ini','small','Filters','','override;user;admin;demo','ezinisetting',169,'imagesmall',0,0,0,11,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:16:\"Image Small Size\";}',0),(1,14,0,0,0,0,6,0,0,0,'image.ini','medium','Filters','','override;user;admin;demo','ezinisetting',170,'imagemedium',0,0,0,12,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:17:\"Image Medium Size\";}',0),(1,14,0,0,0,0,6,0,0,0,'image.ini','large','Filters','','override;user;admin;demo','ezinisetting',171,'imagelarge',0,0,0,13,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:16:\"Image Large Size\";}',0),(1,15,0,0,0,0,1,0,0,0,'site.ini','SiteSettings','SiteName','','override;user;admin;demo','ezinisetting',172,'title',0,0,0,1,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:5:\"Title\";}',0),(1,15,0,0,0,0,6,0,0,0,'site.ini','SiteSettings','MetaDataArray','','override;user;admin;demo','ezinisetting',173,'meta_data',0,0,0,2,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:9:\"Meta data\";}',0),(1,15,0,0,0,0,0,0,0,0,'','','','','','ezimage',174,'image',0,0,0,3,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:5:\"Image\";}',0),(1,15,0,0,0,0,0,0,0,0,'sitestyle','','','','','ezpackage',175,'sitestyle',0,0,0,4,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:9:\"Sitestyle\";}',0),(1,15,0,0,0,0,0,0,0,0,'','','','','','ezstring',176,'id',0,0,1,5,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:2:\"id\";}',0),(1,15,0,0,0,0,1,0,0,0,'site.ini','MailSettings','AdminEmail','','override;user;admin;demo','ezinisetting',177,'email',0,0,0,6,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:5:\"Email\";}',0),(1,15,0,0,0,0,1,0,0,0,'site.ini','SiteSettings','SiteURL','','override;user;admin;demo','ezinisetting',178,'siteurl',0,0,0,7,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:8:\"Site URL\";}',0),(1,4,0,0,0,0,10,0,0,0,'','','','','','eztext',179,'signature',0,0,1,4,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:9:\"Signature\";}',0),(1,4,0,0,0,0,1,0,0,0,'','','','','','ezimage',180,'image',0,0,0,5,'a:2:{s:16:\"always-available\";s:6:\"fre-FR\";s:6:\"fre-FR\";s:5:\"Image\";}',0),(1,16,0,0,0,0,0,0,0,0,'','','','','','ezstring',181,'title',0,1,0,1,'a:2:{s:6:\"fre-FR\";s:5:\"Titre\";s:16:\"always-available\";s:6:\"fre-FR\";}',0),(1,17,0,0,0,0,0,0,0,0,'','','','','','ezurl',183,'url',0,1,0,1,'a:2:{s:6:\"fre-FR\";s:3:\"URL\";s:16:\"always-available\";s:6:\"fre-FR\";}',0),(1,18,0,0,0,0,10,0,0,0,'','','','','','eztext',185,'html',0,0,1,3,'a:2:{s:6:\"fre-FR\";s:4:\"HTML\";s:16:\"always-available\";s:6:\"fre-FR\";}',0),(1,18,0,0,0,0,0,0,0,0,'','','','','','ezurl',186,'url',0,1,0,2,'a:2:{s:6:\"fre-FR\";s:3:\"URL\";s:16:\"always-available\";s:6:\"fre-FR\";}',0),(1,17,0,0,0,0,0,0,0,0,'','','','','','ezurl',187,'rss',0,1,0,2,'a:2:{s:6:\"fre-FR\";s:8:\"Flux RSS\";s:16:\"always-available\";s:6:\"fre-FR\";}',0),(1,18,0,0,0,0,0,0,0,0,'','','','','','ezstring',188,'title',0,1,1,1,'a:2:{s:6:\"fre-FR\";s:5:\"Titre\";s:16:\"always-available\";s:6:\"fre-FR\";}',0),(1,20,0,0,0,0,0,0,0,0,'Contact','','','','','ezstring',191,'title',0,1,0,1,'a:2:{s:6:\"fre-FR\";s:5:\"Titre\";s:16:\"always-available\";s:6:\"fre-FR\";}',0),(1,20,0,0,0,0,5,0,0,0,'','','','','','ezxmltext',194,'description',0,0,0,2,'a:2:{s:6:\"fre-FR\";s:11:\"Description\";s:16:\"always-available\";s:6:\"fre-FR\";}',0),(1,20,0,0,0,0,0,0,0,0,'','','','','','ezstring',195,'subject',1,1,0,3,'a:2:{s:6:\"fre-FR\";s:5:\"Sujet\";s:16:\"always-available\";s:6:\"fre-FR\";}',0),(1,20,0,0,0,0,10,0,0,0,'','','','','','eztext',196,'text',1,1,0,5,'a:2:{s:6:\"fre-FR\";s:5:\"Texte\";s:16:\"always-available\";s:6:\"fre-FR\";}',0),(1,21,0,0,0,0,0,0,0,0,'','','','','','ezstring',197,'title',0,1,0,1,'a:2:{s:6:\"fre-FR\";s:5:\"Titre\";s:16:\"always-available\";s:6:\"fre-FR\";}',0),(1,21,0,0,0,0,25,0,0,0,'','','','','','ezxmltext',198,'content',0,1,0,2,'a:2:{s:6:\"fre-FR\";s:7:\"Contenu\";s:16:\"always-available\";s:6:\"fre-FR\";}',0),(1,20,0,0,0,0,0,0,0,0,'','','','','','ezemail',199,'email',1,1,0,4,'a:2:{s:6:\"fre-FR\";s:14:\"Adresse e-mail\";s:16:\"always-available\";s:6:\"fre-FR\";}',0),(1,18,0,0,0,0,1,1,322,0,'','','','','','ezidentifier',200,'urlid',0,1,0,4,'a:2:{s:6:\"fre-FR\";s:15:\"Identifiant URL\";s:16:\"always-available\";s:6:\"fre-FR\";}',0),(1,17,0,0,0,0,1,1,15,0,'','','','','','ezidentifier',201,'urlid',0,1,0,3,'a:2:{s:6:\"fre-FR\";s:15:\"Identifiant URL\";s:16:\"always-available\";s:6:\"fre-FR\";}',0);
/*!40000 ALTER TABLE `ezcontentclass_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcontentclass_classgroup`
--

DROP TABLE IF EXISTS `ezcontentclass_classgroup`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcontentclass_classgroup` (
  `contentclass_id` int(11) NOT NULL default '0',
  `contentclass_version` int(11) NOT NULL default '0',
  `group_id` int(11) NOT NULL default '0',
  `group_name` varchar(255) default NULL,
  PRIMARY KEY  (`contentclass_id`,`contentclass_version`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcontentclass_classgroup`
--

LOCK TABLES `ezcontentclass_classgroup` WRITE;
/*!40000 ALTER TABLE `ezcontentclass_classgroup` DISABLE KEYS */;
INSERT INTO `ezcontentclass_classgroup` VALUES (1,0,1,'Content'),(3,0,2,'Users'),(4,0,2,'Users'),(5,0,3,'Media'),(12,0,3,'Media'),(14,0,4,'Setup'),(15,0,4,'Setup'),(16,0,1,'Content'),(17,0,1,'Content'),(18,0,1,'Content'),(20,0,1,'Content'),(21,0,1,'Content');
/*!40000 ALTER TABLE `ezcontentclass_classgroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcontentclass_name`
--

DROP TABLE IF EXISTS `ezcontentclass_name`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcontentclass_name` (
  `contentclass_id` int(11) NOT NULL default '0',
  `contentclass_version` int(11) NOT NULL default '0',
  `language_id` int(11) NOT NULL default '0',
  `language_locale` varchar(20) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`contentclass_id`,`contentclass_version`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcontentclass_name`
--

LOCK TABLES `ezcontentclass_name` WRITE;
/*!40000 ALTER TABLE `ezcontentclass_name` DISABLE KEYS */;
INSERT INTO `ezcontentclass_name` VALUES (1,0,3,'fre-FR','Folder'),(3,0,3,'fre-FR','User group'),(4,0,3,'fre-FR','User'),(5,0,3,'fre-FR','Image'),(12,0,3,'fre-FR','File'),(14,0,3,'fre-FR','Common ini settings'),(15,0,3,'fre-FR','Template look'),(16,0,3,'fre-FR','Planete'),(17,0,3,'fre-FR','Site'),(18,0,3,'fre-FR','Blog post'),(20,0,3,'fre-FR','Formulaire de contact'),(21,0,3,'fre-FR','Page');
/*!40000 ALTER TABLE `ezcontentclass_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcontentclassgroup`
--

DROP TABLE IF EXISTS `ezcontentclassgroup`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcontentclassgroup` (
  `created` int(11) NOT NULL default '0',
  `creator_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `modified` int(11) NOT NULL default '0',
  `modifier_id` int(11) NOT NULL default '0',
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcontentclassgroup`
--

LOCK TABLES `ezcontentclassgroup` WRITE;
/*!40000 ALTER TABLE `ezcontentclassgroup` DISABLE KEYS */;
INSERT INTO `ezcontentclassgroup` VALUES (1031216928,14,1,1033922106,14,'Content'),(1031216941,14,2,1033922113,14,'Users'),(1032009743,14,3,1033922120,14,'Media'),(1081858024,14,4,1081858024,14,'Setup');
/*!40000 ALTER TABLE `ezcontentclassgroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcontentobject`
--

DROP TABLE IF EXISTS `ezcontentobject`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcontentobject` (
  `contentclass_id` int(11) NOT NULL default '0',
  `current_version` int(11) default NULL,
  `id` int(11) NOT NULL auto_increment,
  `initial_language_id` int(11) NOT NULL default '0',
  `is_published` int(11) default NULL,
  `language_mask` int(11) NOT NULL default '0',
  `modified` int(11) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `owner_id` int(11) NOT NULL default '0',
  `published` int(11) NOT NULL default '0',
  `remote_id` varchar(100) default NULL,
  `section_id` int(11) NOT NULL default '0',
  `status` int(11) default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ezcontentobject_remote_id` (`remote_id`),
  KEY `ezcontentobject_classid` (`contentclass_id`),
  KEY `ezcontentobject_currentversion` (`current_version`),
  KEY `ezcontentobject_lmask` (`language_mask`),
  KEY `ezcontentobject_owner` (`owner_id`),
  KEY `ezcontentobject_pub` (`published`),
  KEY `ezcontentobject_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=481 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcontentobject`
--

LOCK TABLES `ezcontentobject` WRITE;
/*!40000 ALTER TABLE `ezcontentobject` DISABLE KEYS */;
INSERT INTO `ezcontentobject` VALUES (3,1,4,2,0,3,1033917596,'Users',14,1033917596,'f5c88a2209584891056f987fd965b0ba',2,1),(4,2,10,2,0,3,1072180405,'Anonymous User',14,1033920665,'faaeb9be3bd98ed09f606fc16d144eca',2,1),(3,1,11,2,0,3,1033920746,'Guest accounts',14,1033920746,'5f7f0bdb3381d6a461d8c29ff53d908f',2,1),(3,1,12,2,0,3,1033920775,'Administrator users',14,1033920775,'9b47a45624b023b1a76c73b74d704acf',2,1),(3,1,13,2,0,3,1033920794,'Editors',14,1033920794,'3c160cca19fb135f83bd02d911f04db2',2,1),(4,3,14,2,0,3,1232456888,'Administrateur Planet',14,1033920830,'1bb4fe25487f05527efa8bfd394cecc7',2,1),(1,1,41,2,0,3,1060695457,'Media',14,1060695457,'a6e35cbcb7cd6ae4b691f3eee30cd262',3,1),(3,1,42,2,0,3,1072180330,'Anonymous Users',14,1072180330,'15b256dbea2ae72418ff5facc999e8f9',2,1),(1,1,45,2,0,3,1079684190,'Setup',14,1079684190,'241d538ce310074e602f29f49e44e938',4,1),(1,1,49,2,0,3,1080220197,'Images',14,1080220197,'e7ff633c6b8e0fd3531e74c6e712bead',3,1),(1,1,50,2,0,3,1080220220,'Files',14,1080220220,'732a5acd01b51a6fe6eab448ad4138a9',3,1),(1,1,51,2,0,3,1080220233,'Multimedia',14,1080220233,'09082deb98662a104f325aaa8c4933d3',3,1),(14,1,52,2,0,2,1082016591,'Common INI settings',14,1082016591,'27437f3547db19cf81a33c92578b2c89',4,1),(15,1,54,2,0,2,1082016652,'Planète eZ Publish',14,1082016652,'8b8b22fe3c6061ed500fbd2b377b885f',5,1),(1,1,56,2,0,3,1103023132,'Design',14,1103023132,'08799e609893f7aba22f10cb466d9cc8',5,1),(16,1,57,2,0,2,1231679197,'Planète eZ Publish',14,1231679197,'5927afeed574ec27f0bfaeb204ddde45',1,1),(1,2,141,2,0,3,1232214785,'Planétarium',14,1232214695,'3ac01c0c96451156ebaabd3f60fe7d85',1,1),(1,1,142,2,0,3,1232214910,'Blogs',14,1232214910,'59db59b673677031996d3355d66426e6',1,1),(21,7,221,2,0,2,1232319435,'À propos',14,1232278524,'d328566f9a8805b7996cd7af7999ab9d',1,1),(20,2,222,2,0,2,1232293645,'Contact',14,1232278536,'0cf1d751d3a3091ed83c9356e78c8e63',1,1);
/*!40000 ALTER TABLE `ezcontentobject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcontentobject_attribute`
--

DROP TABLE IF EXISTS `ezcontentobject_attribute`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcontentobject_attribute` (
  `attribute_original_id` int(11) default '0',
  `contentclassattribute_id` int(11) NOT NULL default '0',
  `contentobject_id` int(11) NOT NULL default '0',
  `data_float` float default NULL,
  `data_int` int(11) default NULL,
  `data_text` longtext,
  `data_type_string` varchar(50) default '',
  `id` int(11) NOT NULL auto_increment,
  `language_code` varchar(20) NOT NULL default '',
  `language_id` int(11) NOT NULL default '0',
  `sort_key_int` int(11) NOT NULL default '0',
  `sort_key_string` varchar(255) NOT NULL default '',
  `version` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`,`version`),
  KEY `ezcontentobject_attr_id` (`id`),
  KEY `ezcontentobject_attribute_co_id_ver_lang_code` (`contentobject_id`,`version`,`language_code`),
  KEY `ezcontentobject_attribute_contentobject_id` (`contentobject_id`),
  KEY `ezcontentobject_attribute_language_code` (`language_code`),
  KEY `sort_key_int` (`sort_key_int`),
  KEY `sort_key_string` (`sort_key_string`)
) ENGINE=InnoDB AUTO_INCREMENT=1793 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcontentobject_attribute`
--

LOCK TABLES `ezcontentobject_attribute` WRITE;
/*!40000 ALTER TABLE `ezcontentobject_attribute` DISABLE KEYS */;
INSERT INTO `ezcontentobject_attribute` VALUES (0,7,4,NULL,NULL,'Main group','ezstring',7,'fre-FR',3,0,'',1),(0,6,4,NULL,NULL,'Users','ezstring',8,'fre-FR',3,0,'',1),(0,8,10,0,0,'Anonymous','ezstring',19,'fre-FR',3,0,'anonymous',2),(0,9,10,0,0,'User','ezstring',20,'fre-FR',3,0,'user',2),(0,12,10,0,0,'','ezuser',21,'fre-FR',3,0,'',2),(0,6,11,0,0,'Guest accounts','ezstring',22,'fre-FR',3,0,'',1),(0,7,11,0,0,'','ezstring',23,'fre-FR',3,0,'',1),(0,6,12,0,0,'Administrator users','ezstring',24,'fre-FR',3,0,'',1),(0,7,12,0,0,'','ezstring',25,'fre-FR',3,0,'',1),(0,6,13,0,0,'Editors','ezstring',26,'fre-FR',3,0,'',1),(0,7,13,0,0,'','ezstring',27,'fre-FR',3,0,'',1),(0,8,14,0,0,'Administrator','ezstring',28,'fre-FR',3,0,'',1),(0,8,14,0,0,'Damien','ezstring',28,'fre-FR',3,0,'damien',2),(0,8,14,0,0,'Administrateur','ezstring',28,'fre-FR',3,0,'administrateur',3),(0,9,14,0,0,'User','ezstring',29,'fre-FR',3,0,'',1),(0,9,14,0,0,'POBEL','ezstring',29,'fre-FR',3,0,'pobel',2),(0,9,14,0,0,'Planet','ezstring',29,'fre-FR',3,0,'planet',3),(0,12,14,0,0,'','ezuser',30,'fre-FR',3,0,'',1),(0,12,14,0,0,'','ezuser',30,'fre-FR',3,0,'',2),(0,12,14,0,0,'','ezuser',30,'fre-FR',3,0,'',3),(0,4,41,0,0,'Media','ezstring',98,'fre-FR',3,0,'',1),(0,119,41,0,1045487555,'<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\"\n         xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\"\n         xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\" />','ezxmltext',99,'fre-FR',3,0,'',1),(0,6,42,0,0,'Anonymous Users','ezstring',100,'fre-FR',3,0,'anonymous users',1),(0,7,42,0,0,'User group for the anonymous user','ezstring',101,'fre-FR',3,0,'user group for the anonymous user',1),(0,155,41,0,0,'','ezstring',103,'fre-FR',3,0,'',1),(0,156,41,0,1045487555,'','ezxmltext',105,'fre-FR',3,0,'',1),(0,158,41,0,0,'','ezboolean',109,'fre-FR',3,0,'',1),(0,4,45,0,0,'Setup','ezstring',123,'fre-FR',3,0,'setup',1),(0,155,45,0,0,'','ezstring',124,'fre-FR',3,0,'',1),(0,119,45,0,1045487555,'<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\"\n         xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\"\n         xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\" />','ezxmltext',125,'fre-FR',3,0,'',1),(0,156,45,0,1045487555,'<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\"\n         xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\"\n         xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\" />','ezxmltext',126,'fre-FR',3,0,'',1),(0,158,45,0,0,'','ezboolean',128,'fre-FR',3,0,'',1),(0,4,49,0,0,'Images','ezstring',142,'fre-FR',3,0,'images',1),(0,155,49,0,0,'','ezstring',143,'fre-FR',3,0,'',1),(0,119,49,0,1045487555,'<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\"\n         xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\"\n         xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\" />','ezxmltext',144,'fre-FR',3,0,'',1),(0,156,49,0,1045487555,'<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\"\n         xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\"\n         xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\" />','ezxmltext',145,'fre-FR',3,0,'',1),(0,158,49,0,1,'','ezboolean',146,'fre-FR',3,1,'',1),(0,4,50,0,0,'Files','ezstring',147,'fre-FR',3,0,'files',1),(0,155,50,0,0,'','ezstring',148,'fre-FR',3,0,'',1),(0,119,50,0,1045487555,'<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\"\n         xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\"\n         xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\" />','ezxmltext',149,'fre-FR',3,0,'',1),(0,156,50,0,1045487555,'<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\"\n         xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\"\n         xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\" />','ezxmltext',150,'fre-FR',3,0,'',1),(0,158,50,0,1,'','ezboolean',151,'fre-FR',3,1,'',1),(0,4,51,0,0,'Multimedia','ezstring',152,'fre-FR',3,0,'multimedia',1),(0,155,51,0,0,'','ezstring',153,'fre-FR',3,0,'',1),(0,119,51,0,1045487555,'<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\"\n         xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\"\n         xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\" />','ezxmltext',154,'fre-FR',3,0,'',1),(0,156,51,0,1045487555,'<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\"\n         xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\"\n         xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\" />','ezxmltext',155,'fre-FR',3,0,'',1),(0,158,51,0,1,'','ezboolean',156,'fre-FR',3,1,'',1),(0,159,52,0,0,'Common INI settings','ezstring',157,'fre-FR',2,0,'common ini settings',1),(0,160,52,0,0,'/content/view/full/2/','ezinisetting',158,'fre-FR',2,0,'',1),(0,161,52,0,0,'/content/view/full/2','ezinisetting',159,'fre-FR',2,0,'',1),(0,162,52,0,0,'disabled','ezinisetting',160,'fre-FR',2,0,'',1),(0,163,52,0,0,'disabled','ezinisetting',161,'fre-FR',2,0,'',1),(0,164,52,0,0,'','ezinisetting',162,'fre-FR',2,0,'',1),(0,165,52,0,0,'enabled','ezinisetting',163,'fre-FR',2,0,'',1),(0,166,52,0,0,'disabled','ezinisetting',164,'fre-FR',2,0,'',1),(0,167,52,0,0,'enabled','ezinisetting',165,'fre-FR',2,0,'',1),(0,168,52,0,0,'enabled','ezinisetting',166,'fre-FR',2,0,'',1),(0,169,52,0,0,'=geometry/scale=100;100','ezinisetting',167,'fre-FR',2,0,'',1),(0,170,52,0,0,'=geometry/scale=200;200','ezinisetting',168,'fre-FR',2,0,'',1),(0,171,52,0,0,'=geometry/scale=300;300','ezinisetting',169,'fre-FR',2,0,'',1),(0,172,54,0,0,'Planète eZ Publish','ezinisetting',170,'fre-FR',2,0,'',1),(0,173,54,0,0,'author=eZ Systems\ncopyright=eZ Systems\ndescription=Content Management System\nkeywords=cms, publish, e-commerce, content management, development framework','ezinisetting',171,'fre-FR',2,0,'',1),(0,174,54,0,0,'<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<ezimage serial_number=\"1\"\n         is_valid=\"\"\n         filename=\"ez_publish.\"\n         suffix=\"\"\n         basename=\"ez_publish\"\n         dirpath=\"var/storage/images/setup/ez_publish/172-1-eng-GB\"\n         url=\"var/storage/images/setup/ez_publish/172-1-eng-GB/ez_publish.\"\n         original_filename=\"\"\n         mime_type=\"\"\n         width=\"\"\n         height=\"\"\n         alternative_text=\"\"\n         alias_key=\"1293033771\"\n         timestamp=\"1082016632\">\n  <original attribute_id=\"\"\n            attribute_version=\"\"\n            attribute_language=\"\" />\n</ezimage>','ezimage',172,'fre-FR',2,0,'',1),(0,175,54,0,0,'0','ezpackage',173,'fre-FR',2,0,'0',1),(0,176,54,0,0,'sitestyle_identifier','ezstring',174,'fre-FR',2,0,'sitestyle_identifier',1),(0,177,54,0,0,'dpobel@free.fr','ezinisetting',175,'fre-FR',2,0,'',1),(0,178,54,0,0,'planet.loc','ezinisetting',176,'fre-FR',2,0,'',1),(0,179,10,0,0,'','eztext',177,'fre-FR',3,0,'',2),(0,179,14,0,0,'','eztext',178,'fre-FR',3,0,'',1),(0,179,14,0,0,'','eztext',178,'fre-FR',3,0,'',2),(0,179,14,0,0,'','eztext',178,'fre-FR',3,0,'',3),(0,180,10,0,0,'','ezimage',179,'fre-FR',3,0,'',2),(0,180,14,0,0,'','ezimage',180,'fre-FR',3,0,'',1),(0,180,14,0,0,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<ezimage serial_number=\"\" is_valid=\"\" filename=\"\" suffix=\"\" basename=\"\" dirpath=\"\" url=\"\" original_filename=\"\" mime_type=\"\" width=\"\" height=\"\" alternative_text=\"\" alias_key=\"1293033771\" timestamp=\"1231677837\"/>\n','ezimage',180,'fre-FR',3,0,'',2),(0,180,14,0,0,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<ezimage serial_number=\"1\" is_valid=\"\" filename=\"\" suffix=\"\" basename=\"\" dirpath=\"\" url=\"\" original_filename=\"\" mime_type=\"\" width=\"\" height=\"\" alternative_text=\"\" alias_key=\"1293033771\" timestamp=\"1231677837\"><original attribute_id=\"180\" attribute_version=\"3\" attribute_language=\"fre-FR\"/></ezimage>\n','ezimage',180,'fre-FR',3,0,'',3),(0,4,56,0,NULL,'Design','ezstring',181,'fre-FR',3,0,'design',1),(0,155,56,0,NULL,'','ezstring',182,'fre-FR',3,0,'',1),(0,119,56,0,1045487555,'<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\"\n         xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\"\n         xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\" />','ezxmltext',183,'fre-FR',3,0,'',1),(0,156,56,0,1045487555,'<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\"\n         xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\"\n         xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\" />','ezxmltext',184,'fre-FR',3,0,'',1),(0,158,56,0,1,'','ezboolean',185,'fre-FR',3,1,'',1),(0,181,57,0,NULL,'Planète eZ Publish','ezstring',186,'fre-FR',2,0,'planète ez publish',1),(0,4,141,0,NULL,'Liens','ezstring',430,'fre-FR',3,0,'liens',1),(0,4,141,0,NULL,'Planétarium','ezstring',430,'fre-FR',3,0,'planétarium',2),(0,155,141,0,NULL,'','ezstring',431,'fre-FR',3,0,'',1),(0,155,141,0,NULL,'','ezstring',431,'fre-FR',3,0,'',2),(0,119,141,0,1045487555,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\" xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\" xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\"/>\n','ezxmltext',432,'fre-FR',3,0,'',1),(0,119,141,0,1045487555,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\" xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\" xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\"/>\n','ezxmltext',432,'fre-FR',3,0,'',2),(0,156,141,0,1045487555,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\" xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\" xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\"/>\n','ezxmltext',433,'fre-FR',3,0,'',1),(0,156,141,0,1045487555,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\" xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\" xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\"/>\n','ezxmltext',433,'fre-FR',3,0,'',2),(434,158,141,0,1,'','ezboolean',434,'fre-FR',3,1,'',1),(434,158,141,0,1,'','ezboolean',434,'fre-FR',3,1,'',2),(0,4,142,0,NULL,'Blogs','ezstring',435,'fre-FR',3,0,'blogs',1),(0,155,142,0,NULL,'','ezstring',436,'fre-FR',3,0,'',1),(0,119,142,0,1045487555,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\" xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\" xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\"/>\n','ezxmltext',437,'fre-FR',3,0,'',1),(0,156,142,0,1045487555,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\" xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\" xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\"/>\n','ezxmltext',438,'fre-FR',3,0,'',1),(439,158,142,0,1,'','ezboolean',439,'fre-FR',3,1,'',1),(0,197,221,0,NULL,'A propos','ezstring',666,'fre-FR',2,0,'a propos',1),(0,197,221,0,NULL,'A propos','ezstring',666,'fre-FR',2,0,'a propos',2),(0,197,221,0,NULL,'A propos','ezstring',666,'fre-FR',2,0,'a propos',3),(0,197,221,0,NULL,'A propos','ezstring',666,'fre-FR',2,0,'a propos',4),(0,197,221,0,NULL,'A propos','ezstring',666,'fre-FR',2,0,'a propos',5),(0,197,221,0,NULL,'À propos','ezstring',666,'fre-FR',2,0,'à propos',6),(0,197,221,0,NULL,'À propos','ezstring',666,'fre-FR',2,0,'à propos',7),(0,198,221,0,1045487555,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\" xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\" xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\"><paragraph xmlns:tmp=\"http://ez.no/namespaces/ezpublish3/temporary/\"> </paragraph></section>\n','ezxmltext',667,'fre-FR',2,0,'',1),(0,198,221,0,1045487555,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\" xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\" xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\"><section><header>C\'est quoi ?</header><paragraph>zferf</paragraph></section><section><header>Inscription</header><paragraph>fzfze</paragraph></section></section>\n','ezxmltext',667,'fre-FR',2,0,'',2),(0,198,221,0,1045487555,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\" xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\" xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\"><section><header>C\'est quoi ?</header><paragraph><link node_id=\"141\">Planet eZ Publish.fr</link> est un site web de type Planet. <link url_id=\"245\">D\'après Wikipedia</link>, <emphasize>un Planet est un site Web dynamique qui agrège le plus souvent sur une seule page, le contenu de notes, d\'articles ou de billets publiés sur des blogs ou sites Web afin d\'accentuer leur visibilité et de faire ressortir des contenus pertinents aux multiples formats</emphasize>. Ici, il s\'agit évidemment du CMS eZ Publish et des sujets connexes (eZ Components, PHP, MySQL, ...).</paragraph></section><section><header>Inscription</header><paragraph>fzfze</paragraph></section></section>\n','ezxmltext',667,'fre-FR',2,0,'',3),(0,198,221,0,1045487555,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\" xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\" xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\"><section><header>C\'est quoi ?</header><paragraph><link node_id=\"2\">Planet eZ Publish.fr</link> est un site web de type Planet. <link url_id=\"245\">D\'après Wikipedia</link>, <emphasize>un Planet est un site Web dynamique qui agrège le plus souvent sur une seule page, le contenu de notes, d\'articles ou de billets publiés sur des blogs ou sites Web afin d\'accentuer leur visibilité et de faire ressortir des contenus pertinents aux multiples formats</emphasize>. Ici, il s\'agit évidemment du CMS eZ Publish et des sujets connexes (eZ Components, PHP, MySQL, ...).</paragraph></section><section><header>Inscription</header><paragraph>fzfze</paragraph></section></section>\n','ezxmltext',667,'fre-FR',2,0,'',4),(0,198,221,0,1045487555,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\" xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\" xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\"><section><header>C\'est quoi ?</header><paragraph><link node_id=\"2\">Planet eZ Publish.fr</link> est un site web de type Planet. <link url_id=\"245\">D\'après Wikipedia</link>, <emphasize>un Planet est un site Web dynamique qui agrège le plus souvent sur une seule page, le contenu de notes, d\'articles ou de billets publiés sur des blogs ou sites Web afin d\'accentuer leur visibilité et de faire ressortir des contenus pertinents aux multiples formats</emphasize>. Planet eZ Publish.fr reprend les articles de blogs francophone sur le CMS eZ Publish et les sujets connexes (eZ Components, PHP, MySQL, ...)</paragraph></section><section><header>Inscription</header><paragraph>Tout blog francophone peut participer, il faut néanmoins respecter quelques règles simples :</paragraph><paragraph xmlns:tmp=\"http://ez.no/namespaces/ezpublish3/temporary/\"><ol><li><paragraph xmlns:tmp=\"http://ez.no/namespaces/ezpublish3/temporary/\">fournir un flux RSS d\'articles originaux ou de traductions autour d\'eZ Publish</paragraph></li><li><paragraph xmlns:tmp=\"http://ez.no/namespaces/ezpublish3/temporary/\">le flux RSS doit fournir au moins 2 articles</paragraph></li><li><paragraph xmlns:tmp=\"http://ez.no/namespaces/ezpublish3/temporary/\">les articles doivent être rédigés en français</paragraph></li></ol></paragraph><paragraph>Les flux RSS fournissant des articles complets sont vivement appréciés. Si vous remplissez toutes ces conditions, vous êtes invités à vous inscrire <emphasize>via</emphasize> <link node_id=\"220\">le formulaire de contact</link> !</paragraph></section><section><header>Mentions légales</header><paragraph>Les articles publiés sur Planète eZ Publish.fr restent la propriété de leur auteur respectif. Planète eZ Publish.fr ne peut être tenu responsable d\'un quelconque désagrément suite à la publication d\'un article provenant d\'un site externe</paragraph><paragraph>hébergeur : <link url_id=\"246\">Damien POBEL</link></paragraph></section></section>\n','ezxmltext',667,'fre-FR',2,0,'',5),(0,198,221,0,1045487555,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\" xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\" xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\"><section><header>C\'est quoi ?</header><paragraph><link node_id=\"2\">Planet eZ Publish.fr</link> est un site web de type Planet. <link url_id=\"245\">D\'après Wikipedia</link>, <emphasize>un Planet est un site Web dynamique qui agrège le plus souvent sur une seule page, le contenu de notes, d\'articles ou de billets publiés sur des blogs ou sites Web afin d\'accentuer leur visibilité et de faire ressortir des contenus pertinents aux multiples formats</emphasize>. Planet eZ Publish.fr reprend les articles de blogs francophone sur le CMS eZ Publish et les sujets connexes (eZ Components, PHP, MySQL, ...)</paragraph></section><section><header>Inscription</header><paragraph>Tout blog francophone peut participer, il faut néanmoins respecter quelques règles simples :</paragraph><paragraph xmlns:tmp=\"http://ez.no/namespaces/ezpublish3/temporary/\"><ol><li><paragraph xmlns:tmp=\"http://ez.no/namespaces/ezpublish3/temporary/\">fournir un flux RSS d\'articles originaux ou de traductions autour d\'eZ Publish</paragraph></li><li><paragraph xmlns:tmp=\"http://ez.no/namespaces/ezpublish3/temporary/\">le flux RSS doit fournir au moins 2 articles</paragraph></li><li><paragraph xmlns:tmp=\"http://ez.no/namespaces/ezpublish3/temporary/\">les articles doivent être rédigés en français</paragraph></li></ol></paragraph><paragraph>Les flux RSS fournissant des articles complets sont vivement appréciés. Si vous remplissez toutes ces conditions, vous êtes invités à vous inscrire <emphasize>via</emphasize> <link node_id=\"220\">le formulaire de contact</link> !</paragraph></section><section><header>Mentions légales</header><paragraph>Les articles publiés sur Planète eZ Publish.fr restent la propriété de leur auteur respectif. Planète eZ Publish.fr ne peut être tenu responsable d\'un quelconque désagrément suite à la publication d\'un article provenant d\'un site externe</paragraph><paragraph>hébergeur : <link url_id=\"246\">Damien POBEL</link></paragraph></section></section>\n','ezxmltext',667,'fre-FR',2,0,'',6),(0,198,221,0,1045487555,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\" xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\" xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\"><section><header>C\'est quoi ?</header><paragraph><link node_id=\"2\">Planet eZ Publish.fr</link> est un site web de type Planet. <link url_id=\"245\">D\'après Wikipedia</link>, <emphasize>un Planet est un site Web dynamique qui agrège le plus souvent sur une seule page, le contenu de notes, d\'articles ou de billets publiés sur des blogs ou sites Web afin d\'accentuer leur visibilité et de faire ressortir des contenus pertinents aux multiples formats</emphasize>. Sur ce principe, Planet eZ Publish.fr reprend les articles de blogs francophones consacrés au <link url_id=\"388\">CMS eZ Publish</link> et sujets connexes (<link url_id=\"389\">eZ Components</link>, PHP, MySQL, ...)</paragraph></section><section><header>Inscription</header><paragraph>Tout blog francophone peut participer, il faut néanmoins respecter quelques règles simples :</paragraph><paragraph xmlns:tmp=\"http://ez.no/namespaces/ezpublish3/temporary/\"><ol><li><paragraph xmlns:tmp=\"http://ez.no/namespaces/ezpublish3/temporary/\">fournir un flux RSS d\'articles originaux ou de traductions autour d\'eZ Publish</paragraph></li><li><paragraph xmlns:tmp=\"http://ez.no/namespaces/ezpublish3/temporary/\">le flux RSS doit fournir au moins 2 articles</paragraph></li><li><paragraph xmlns:tmp=\"http://ez.no/namespaces/ezpublish3/temporary/\">les articles doivent être rédigés en français</paragraph></li></ol></paragraph><paragraph>Les flux RSS fournissant des articles complets sont vivement appréciés. Si vous remplissez toutes ces conditions, vous êtes invités à vous inscrire <emphasize>via</emphasize> <link node_id=\"220\">le formulaire de contact</link> !</paragraph></section><section><header>Mentions légales</header><paragraph>Les articles publiés sur Planet eZ Publish.fr restent la propriété de leur auteur respectif. Planète eZ Publish.fr ne peut être tenu responsable d\'un quelconque désagrément suite à la publication d\'un article provenant d\'un site externe</paragraph><paragraph>hébergeur : <link url_id=\"246\">Damien POBEL</link></paragraph></section></section>\n','ezxmltext',667,'fre-FR',2,0,'',7),(0,191,222,0,NULL,'Contact','ezstring',668,'fre-FR',2,0,'contact',1),(0,191,222,0,NULL,'Contact','ezstring',668,'fre-FR',2,0,'contact',2),(0,194,222,0,1045487555,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\" xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\" xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\"/>\n','ezxmltext',669,'fre-FR',2,0,'',1),(0,194,222,0,1045487555,'<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<section xmlns:image=\"http://ez.no/namespaces/ezpublish3/image/\" xmlns:xhtml=\"http://ez.no/namespaces/ezpublish3/xhtml/\" xmlns:custom=\"http://ez.no/namespaces/ezpublish3/custom/\"><paragraph>Pour toute question, n\'hésitez pas à utiliser ce formulaire. Si vous souhaitez ajouter votre blog au Planet eZ Publish.fr, merci de vérifier que vous respectez <link node_id=\"219\" anchor_name=\"eztoc667_2\">les règles</link>.</paragraph></section>\n','ezxmltext',669,'fre-FR',2,0,'',2),(0,195,222,0,NULL,'','ezstring',670,'fre-FR',2,0,'',1),(0,195,222,0,NULL,'','ezstring',670,'fre-FR',2,0,'',2),(0,196,222,0,NULL,'','eztext',671,'fre-FR',2,0,'',1),(0,196,222,0,NULL,'','eztext',671,'fre-FR',2,0,'',2),(0,199,222,0,NULL,'','ezemail',895,'fre-FR',2,0,'',1),(0,199,222,0,NULL,'','ezemail',896,'fre-FR',2,0,'',2);
/*!40000 ALTER TABLE `ezcontentobject_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcontentobject_link`
--

DROP TABLE IF EXISTS `ezcontentobject_link`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcontentobject_link` (
  `contentclassattribute_id` int(11) NOT NULL default '0',
  `from_contentobject_id` int(11) NOT NULL default '0',
  `from_contentobject_version` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `op_code` int(11) NOT NULL default '0',
  `relation_type` int(11) NOT NULL default '1',
  `to_contentobject_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ezco_link_from` (`from_contentobject_id`,`from_contentobject_version`,`contentclassattribute_id`),
  KEY `ezco_link_to_co_id` (`to_contentobject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcontentobject_link`
--

LOCK TABLES `ezcontentobject_link` WRITE;
/*!40000 ALTER TABLE `ezcontentobject_link` DISABLE KEYS */;
INSERT INTO `ezcontentobject_link` VALUES (0,221,3,3,0,4,142),(0,221,4,8,0,4,57),(0,221,5,12,0,4,57),(0,221,5,13,0,4,222),(0,222,2,16,0,4,221),(0,221,6,19,0,4,57),(0,221,6,20,0,4,222),(0,221,7,23,0,4,57),(0,221,7,24,0,4,222);
/*!40000 ALTER TABLE `ezcontentobject_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcontentobject_name`
--

DROP TABLE IF EXISTS `ezcontentobject_name`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcontentobject_name` (
  `content_translation` varchar(20) NOT NULL default '',
  `content_version` int(11) NOT NULL default '0',
  `contentobject_id` int(11) NOT NULL default '0',
  `language_id` int(11) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `real_translation` varchar(20) default NULL,
  PRIMARY KEY  (`contentobject_id`,`content_version`,`content_translation`),
  KEY `ezcontentobject_name_co_id` (`contentobject_id`),
  KEY `ezcontentobject_name_cov_id` (`content_version`),
  KEY `ezcontentobject_name_lang_id` (`language_id`),
  KEY `ezcontentobject_name_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcontentobject_name`
--

LOCK TABLES `ezcontentobject_name` WRITE;
/*!40000 ALTER TABLE `ezcontentobject_name` DISABLE KEYS */;
INSERT INTO `ezcontentobject_name` VALUES ('fre-FR',1,4,3,'Users','fre-FR'),('fre-FR',2,10,3,'Anonymous User','fre-FR'),('fre-FR',1,11,3,'Guest accounts','fre-FR'),('fre-FR',1,12,3,'Administrator users','fre-FR'),('fre-FR',1,13,3,'Editors','fre-FR'),('fre-FR',1,14,3,'Administrator User','fre-FR'),('fre-FR',2,14,3,'Damien POBEL','fre-FR'),('fre-FR',3,14,3,'Administrateur Planet','fre-FR'),('fre-FR',1,41,3,'Media','fre-FR'),('fre-FR',1,42,3,'Anonymous Users','fre-FR'),('fre-FR',1,45,3,'Setup','fre-FR'),('fre-FR',1,49,3,'Images','fre-FR'),('fre-FR',1,50,3,'Files','fre-FR'),('fre-FR',1,51,3,'Multimedia','fre-FR'),('fre-FR',1,52,2,'Common INI settings','fre-FR'),('fre-FR',1,54,2,'Planète eZ Publish','fre-FR'),('fre-FR',1,56,3,'Design','fre-FR'),('fre-FR',1,57,2,'Planète eZ Publish','fre-FR'),('fre-FR',1,141,3,'Liens','fre-FR'),('fre-FR',2,141,3,'Planétarium','fre-FR'),('fre-FR',1,142,3,'Blogs','fre-FR'),('fre-FR',1,221,2,'A propos','fre-FR'),('fre-FR',2,221,2,'A propos','fre-FR'),('fre-FR',3,221,2,'A propos','fre-FR'),('fre-FR',4,221,2,'A propos','fre-FR'),('fre-FR',5,221,2,'A propos','fre-FR'),('fre-FR',6,221,2,'À propos','fre-FR'),('fre-FR',7,221,2,'À propos','fre-FR'),('fre-FR',1,222,2,'Contact','fre-FR'),('fre-FR',2,222,2,'Contact','fre-FR');
/*!40000 ALTER TABLE `ezcontentobject_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcontentobject_trash`
--

DROP TABLE IF EXISTS `ezcontentobject_trash`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcontentobject_trash` (
  `contentobject_id` int(11) default NULL,
  `contentobject_version` int(11) default NULL,
  `depth` int(11) NOT NULL default '0',
  `is_hidden` int(11) NOT NULL default '0',
  `is_invisible` int(11) NOT NULL default '0',
  `main_node_id` int(11) default NULL,
  `modified_subnode` int(11) default '0',
  `node_id` int(11) NOT NULL default '0',
  `parent_node_id` int(11) NOT NULL default '0',
  `path_identification_string` longtext,
  `path_string` varchar(255) NOT NULL default '',
  `priority` int(11) NOT NULL default '0',
  `remote_id` varchar(100) NOT NULL default '',
  `sort_field` int(11) default '1',
  `sort_order` int(11) default '1',
  PRIMARY KEY  (`node_id`),
  KEY `ezcobj_trash_co_id` (`contentobject_id`),
  KEY `ezcobj_trash_depth` (`depth`),
  KEY `ezcobj_trash_modified_subnode` (`modified_subnode`),
  KEY `ezcobj_trash_p_node_id` (`parent_node_id`),
  KEY `ezcobj_trash_path` (`path_string`),
  KEY `ezcobj_trash_path_ident` (`path_identification_string`(50))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcontentobject_trash`
--

LOCK TABLES `ezcontentobject_trash` WRITE;
/*!40000 ALTER TABLE `ezcontentobject_trash` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezcontentobject_trash` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcontentobject_tree`
--

DROP TABLE IF EXISTS `ezcontentobject_tree`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcontentobject_tree` (
  `contentobject_id` int(11) default NULL,
  `contentobject_is_published` int(11) default NULL,
  `contentobject_version` int(11) default NULL,
  `depth` int(11) NOT NULL default '0',
  `is_hidden` int(11) NOT NULL default '0',
  `is_invisible` int(11) NOT NULL default '0',
  `main_node_id` int(11) default NULL,
  `modified_subnode` int(11) default '0',
  `node_id` int(11) NOT NULL auto_increment,
  `parent_node_id` int(11) NOT NULL default '0',
  `path_identification_string` longtext,
  `path_string` varchar(255) NOT NULL default '',
  `priority` int(11) NOT NULL default '0',
  `remote_id` varchar(100) NOT NULL default '',
  `sort_field` int(11) default '1',
  `sort_order` int(11) default '1',
  PRIMARY KEY  (`node_id`),
  KEY `ezcontentobject_tree_co_id` (`contentobject_id`),
  KEY `ezcontentobject_tree_depth` (`depth`),
  KEY `ezcontentobject_tree_p_node_id` (`parent_node_id`),
  KEY `ezcontentobject_tree_path` (`path_string`),
  KEY `ezcontentobject_tree_path_ident` (`path_identification_string`(50)),
  KEY `modified_subnode` (`modified_subnode`)
) ENGINE=InnoDB AUTO_INCREMENT=479 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcontentobject_tree`
--

LOCK TABLES `ezcontentobject_tree` WRITE;
/*!40000 ALTER TABLE `ezcontentobject_tree` DISABLE KEYS */;
INSERT INTO `ezcontentobject_tree` VALUES (0,1,1,0,0,0,1,1232456893,1,1,'','/1/',0,'629709ba256fe317c3ddcee35453a96a',1,1),(57,1,1,1,0,0,2,1232456870,2,1,'','/1/2/',0,'f3e90596361e31d496d4026eb624c983',8,1),(4,1,1,1,0,0,5,1232456893,5,1,'users','/1/5/',0,'3f6d92f8044aed134f32153517850f5a',1,1),(11,1,1,2,0,0,12,1081860719,12,5,'users/guest_accounts','/1/5/12/',0,'602dcf84765e56b7f999eaafd3821dd3',1,1),(12,1,1,2,0,0,13,1232456893,13,5,'users/administrator_users','/1/5/13/',0,'769380b7aa94541679167eab817ca893',1,1),(13,1,1,2,0,0,14,1081860719,14,5,'users/editors','/1/5/14/',0,'f7dda2854fc68f7c8455d9cb14bd04a9',1,1),(14,1,3,3,0,0,15,1232456893,15,13,'users/administrator_users/administrateur_planet','/1/5/13/15/',0,'e5161a99f733200b9ed4e80f9c16187b',1,1),(41,1,1,1,0,0,43,1081860720,43,1,'media','/1/43/',0,'75c715a51699d2d309a924eca6a95145',9,1),(42,1,1,2,0,0,44,1081860719,44,5,'users/anonymous_users','/1/5/44/',0,'4fdf0072da953bb276c0c7e0141c5c9b',9,1),(10,1,2,3,0,0,45,1081860719,45,44,'users/anonymous_users/anonymous_user','/1/5/44/45/',0,'2cf8343bee7b482bab82b269d8fecd76',9,1),(45,1,1,1,0,0,48,1184592117,48,1,'setup2','/1/48/',0,'182ce1b5af0c09fa378557c462ba2617',9,1),(49,1,1,2,0,0,51,1081860720,51,43,'media/images','/1/43/51/',0,'1b26c0454b09bb49dfb1b9190ffd67cb',9,1),(50,1,1,2,0,0,52,1081860720,52,43,'media/files','/1/43/52/',0,'0b113a208f7890f9ad3c24444ff5988c',9,1),(51,1,1,2,0,0,53,1081860720,53,43,'media/multimedia','/1/43/53/',0,'4f18b82c75f10aad476cae5adf98c11f',9,1),(52,1,1,2,0,0,54,1184592117,54,48,'setup2/common_ini_settings','/1/48/54/',0,'fa9f3cff9cf90ecfae335718dcbddfe2',1,1),(54,1,1,2,0,0,56,1231677835,56,58,'design/ez_publish','/1/58/56/',0,'772da20ecf88b3035d73cbdfcea0f119',1,1),(56,1,1,1,0,0,58,1231677835,58,1,'design','/1/58/',0,'79f2d67372ab56f59b5d65bb9e0ca3b9',2,0),(141,1,2,2,0,0,140,1232456838,140,2,'planetarium','/1/2/140/',2,'597522a501eecf4167ff53380535134c',1,1),(142,1,1,2,0,0,141,1232456870,141,2,'blogs','/1/2/141/',1,'4efed1d96e5d37b35ca39db194a19d7f',1,1),(221,1,7,2,0,0,219,1232319435,219,2,'a_propos','/1/2/219/',3,'8ff6e94845c454e0249b0ef52ea8308f',1,1),(222,1,2,2,0,0,220,1232293645,220,2,'contact','/1/2/220/',4,'76075d33c0049ab7ae84777a10ee8fba',1,1);
/*!40000 ALTER TABLE `ezcontentobject_tree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcontentobject_version`
--

DROP TABLE IF EXISTS `ezcontentobject_version`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcontentobject_version` (
  `contentobject_id` int(11) default NULL,
  `created` int(11) NOT NULL default '0',
  `creator_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `initial_language_id` int(11) NOT NULL default '0',
  `language_mask` int(11) NOT NULL default '0',
  `modified` int(11) NOT NULL default '0',
  `status` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `version` int(11) NOT NULL default '0',
  `workflow_event_pos` int(11) default '0',
  PRIMARY KEY  (`id`),
  KEY `ezcobj_version_creator_id` (`creator_id`),
  KEY `ezcobj_version_status` (`status`),
  KEY `idx_object_version_objver` (`contentobject_id`,`version`)
) ENGINE=InnoDB AUTO_INCREMENT=1022 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcontentobject_version`
--

LOCK TABLES `ezcontentobject_version` WRITE;
/*!40000 ALTER TABLE `ezcontentobject_version` DISABLE KEYS */;
INSERT INTO `ezcontentobject_version` VALUES (4,0,14,4,2,3,0,1,0,1,1),(11,1033920737,14,439,2,3,1033920746,1,0,1,0),(12,1033920760,14,440,2,3,1033920775,1,0,1,0),(13,1033920786,14,441,2,3,1033920794,1,0,1,0),(14,1033920808,14,442,2,3,1033920830,3,0,1,0),(41,1060695450,14,472,2,3,1060695457,1,0,1,0),(42,1072180278,14,473,2,3,1072180330,1,0,1,0),(10,1072180337,14,474,2,3,1072180405,1,0,2,0),(45,1079684084,14,477,2,3,1079684190,1,0,1,0),(49,1080220181,14,488,2,3,1080220197,1,0,1,0),(50,1080220211,14,489,2,3,1080220220,1,0,1,0),(51,1080220225,14,490,2,3,1080220233,1,0,1,0),(52,1082016497,14,491,2,2,1082016591,1,0,1,0),(54,1082016628,14,492,2,2,1082016652,1,0,1,0),(56,1103023120,14,495,2,3,1103023120,1,0,1,0),(14,1231677835,14,496,2,3,1231677835,3,0,2,0),(57,1231679184,14,497,2,3,1231679197,1,0,1,0),(141,1232214672,14,645,2,3,1232214695,3,0,1,0),(141,1232214768,14,646,2,3,1232214785,1,0,2,0),(142,1232214902,14,647,2,3,1232214910,1,0,1,0),(221,1232278515,14,726,2,3,1232278523,3,0,1,0),(222,1232278530,14,727,2,3,1232278535,3,0,1,0),(221,1232289465,14,805,2,3,1232289555,3,0,2,0),(221,1232289957,14,806,2,3,1232290544,3,0,3,0),(221,1232290585,14,807,2,3,1232290602,3,0,4,0),(221,1232290621,14,808,2,3,1232292050,3,0,5,0),(222,1232293487,14,809,2,3,1232293645,1,0,2,0),(221,1232315035,14,969,2,3,1232315044,3,0,6,0),(221,1232319299,14,977,2,3,1232319435,1,0,7,0),(14,1232456873,14,1021,2,3,1232456888,1,0,3,0);
/*!40000 ALTER TABLE `ezcontentobject_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezcurrencydata`
--

DROP TABLE IF EXISTS `ezcurrencydata`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezcurrencydata` (
  `auto_rate_value` decimal(10,5) NOT NULL default '0.00000',
  `code` varchar(4) NOT NULL default '',
  `custom_rate_value` decimal(10,5) NOT NULL default '0.00000',
  `id` int(11) NOT NULL auto_increment,
  `locale` varchar(255) NOT NULL default '',
  `rate_factor` decimal(10,5) NOT NULL default '1.00000',
  `status` int(11) NOT NULL default '1',
  `symbol` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `ezcurrencydata_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezcurrencydata`
--

LOCK TABLES `ezcurrencydata` WRITE;
/*!40000 ALTER TABLE `ezcurrencydata` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezcurrencydata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezdiscountrule`
--

DROP TABLE IF EXISTS `ezdiscountrule`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezdiscountrule` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezdiscountrule`
--

LOCK TABLES `ezdiscountrule` WRITE;
/*!40000 ALTER TABLE `ezdiscountrule` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezdiscountrule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezdiscountsubrule`
--

DROP TABLE IF EXISTS `ezdiscountsubrule`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezdiscountsubrule` (
  `discount_percent` float default NULL,
  `discountrule_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `limitation` char(1) default NULL,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezdiscountsubrule`
--

LOCK TABLES `ezdiscountsubrule` WRITE;
/*!40000 ALTER TABLE `ezdiscountsubrule` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezdiscountsubrule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezdiscountsubrule_value`
--

DROP TABLE IF EXISTS `ezdiscountsubrule_value`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezdiscountsubrule_value` (
  `discountsubrule_id` int(11) NOT NULL default '0',
  `issection` int(11) NOT NULL default '0',
  `value` int(11) NOT NULL default '0',
  PRIMARY KEY  (`discountsubrule_id`,`value`,`issection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezdiscountsubrule_value`
--

LOCK TABLES `ezdiscountsubrule_value` WRITE;
/*!40000 ALTER TABLE `ezdiscountsubrule_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezdiscountsubrule_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezenumobjectvalue`
--

DROP TABLE IF EXISTS `ezenumobjectvalue`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezenumobjectvalue` (
  `contentobject_attribute_id` int(11) NOT NULL default '0',
  `contentobject_attribute_version` int(11) NOT NULL default '0',
  `enumelement` varchar(255) NOT NULL default '',
  `enumid` int(11) NOT NULL default '0',
  `enumvalue` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`contentobject_attribute_id`,`contentobject_attribute_version`,`enumid`),
  KEY `ezenumobjectvalue_co_attr_id_co_attr_ver` (`contentobject_attribute_id`,`contentobject_attribute_version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezenumobjectvalue`
--

LOCK TABLES `ezenumobjectvalue` WRITE;
/*!40000 ALTER TABLE `ezenumobjectvalue` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezenumobjectvalue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezenumvalue`
--

DROP TABLE IF EXISTS `ezenumvalue`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezenumvalue` (
  `contentclass_attribute_id` int(11) NOT NULL default '0',
  `contentclass_attribute_version` int(11) NOT NULL default '0',
  `enumelement` varchar(255) NOT NULL default '',
  `enumvalue` varchar(255) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `placement` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`,`contentclass_attribute_id`,`contentclass_attribute_version`),
  KEY `ezenumvalue_co_cl_attr_id_co_class_att_ver` (`contentclass_attribute_id`,`contentclass_attribute_version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezenumvalue`
--

LOCK TABLES `ezenumvalue` WRITE;
/*!40000 ALTER TABLE `ezenumvalue` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezenumvalue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezforgot_password`
--

DROP TABLE IF EXISTS `ezforgot_password`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezforgot_password` (
  `hash_key` varchar(32) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `time` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezforgot_password`
--

LOCK TABLES `ezforgot_password` WRITE;
/*!40000 ALTER TABLE `ezforgot_password` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezforgot_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezgeneral_digest_user_settings`
--

DROP TABLE IF EXISTS `ezgeneral_digest_user_settings`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezgeneral_digest_user_settings` (
  `address` varchar(255) NOT NULL default '',
  `day` varchar(255) NOT NULL default '',
  `digest_type` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `receive_digest` int(11) NOT NULL default '0',
  `time` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezgeneral_digest_user_settings`
--

LOCK TABLES `ezgeneral_digest_user_settings` WRITE;
/*!40000 ALTER TABLE `ezgeneral_digest_user_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezgeneral_digest_user_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezimage`
--

DROP TABLE IF EXISTS `ezimage`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezimage` (
  `alternative_text` varchar(255) NOT NULL default '',
  `contentobject_attribute_id` int(11) NOT NULL default '0',
  `filename` varchar(255) NOT NULL default '',
  `mime_type` varchar(50) NOT NULL default '',
  `original_filename` varchar(255) NOT NULL default '',
  `version` int(11) NOT NULL default '0',
  PRIMARY KEY  (`contentobject_attribute_id`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezimage`
--

LOCK TABLES `ezimage` WRITE;
/*!40000 ALTER TABLE `ezimage` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezimage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezimagefile`
--

DROP TABLE IF EXISTS `ezimagefile`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezimagefile` (
  `contentobject_attribute_id` int(11) NOT NULL default '0',
  `filepath` longtext NOT NULL,
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  KEY `ezimagefile_coid` (`contentobject_attribute_id`),
  KEY `ezimagefile_file` (`filepath`(200))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezimagefile`
--

LOCK TABLES `ezimagefile` WRITE;
/*!40000 ALTER TABLE `ezimagefile` DISABLE KEYS */;
INSERT INTO `ezimagefile` VALUES (172,'var/storage/images/setup/ez_publish/172-1-eng-GB/ez_publish.',1);
/*!40000 ALTER TABLE `ezimagefile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezimagevariation`
--

DROP TABLE IF EXISTS `ezimagevariation`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezimagevariation` (
  `additional_path` varchar(255) default NULL,
  `contentobject_attribute_id` int(11) NOT NULL default '0',
  `filename` varchar(255) NOT NULL default '',
  `height` int(11) NOT NULL default '0',
  `requested_height` int(11) NOT NULL default '0',
  `requested_width` int(11) NOT NULL default '0',
  `version` int(11) NOT NULL default '0',
  `width` int(11) NOT NULL default '0',
  PRIMARY KEY  (`contentobject_attribute_id`,`version`,`requested_width`,`requested_height`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezimagevariation`
--

LOCK TABLES `ezimagevariation` WRITE;
/*!40000 ALTER TABLE `ezimagevariation` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezimagevariation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezinfocollection`
--

DROP TABLE IF EXISTS `ezinfocollection`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezinfocollection` (
  `contentobject_id` int(11) NOT NULL default '0',
  `created` int(11) NOT NULL default '0',
  `creator_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `modified` int(11) default '0',
  `user_identifier` varchar(34) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezinfocollection`
--

LOCK TABLES `ezinfocollection` WRITE;
/*!40000 ALTER TABLE `ezinfocollection` DISABLE KEYS */;
INSERT INTO `ezinfocollection` VALUES (222,1232294706,10,1,1232294706,'048deda85eddc14958f5e72e93e0404f'),(222,1232296047,10,3,1232296047,'048deda85eddc14958f5e72e93e0404f'),(222,1232297278,10,25,1232297278,'048deda85eddc14958f5e72e93e0404f'),(222,1232297309,10,26,1232297309,'048deda85eddc14958f5e72e93e0404f'),(222,1232297880,10,27,1232297880,'048deda85eddc14958f5e72e93e0404f'),(222,1232298605,10,28,1232298605,'048deda85eddc14958f5e72e93e0404f'),(222,1232298721,10,29,1232298721,'048deda85eddc14958f5e72e93e0404f'),(222,1232298963,10,30,1232298963,'048deda85eddc14958f5e72e93e0404f'),(222,1232298988,10,32,1232298988,'048deda85eddc14958f5e72e93e0404f');
/*!40000 ALTER TABLE `ezinfocollection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezinfocollection_attribute`
--

DROP TABLE IF EXISTS `ezinfocollection_attribute`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezinfocollection_attribute` (
  `contentclass_attribute_id` int(11) NOT NULL default '0',
  `contentobject_attribute_id` int(11) default NULL,
  `contentobject_id` int(11) default NULL,
  `data_float` float default NULL,
  `data_int` int(11) default NULL,
  `data_text` longtext,
  `id` int(11) NOT NULL auto_increment,
  `informationcollection_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ezinfocollection_attr_co_id` (`contentobject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezinfocollection_attribute`
--

LOCK TABLES `ezinfocollection_attribute` WRITE;
/*!40000 ALTER TABLE `ezinfocollection_attribute` DISABLE KEYS */;
INSERT INTO `ezinfocollection_attribute` VALUES (195,670,222,0,0,'Test',1,1),(199,896,222,0,0,'dpobel@free.fr',2,1),(196,671,222,0,0,'test',3,1),(195,670,222,0,0,'efregfeqs',4,3),(199,896,222,0,0,'dpobel@free.fr',5,3),(196,671,222,0,0,'s<f qef qf egs',6,3),(195,670,222,0,0,'efrfger',7,25),(199,896,222,0,0,'dpobel@free.fr',8,25),(196,671,222,0,0,'zefvzsd',9,25),(195,670,222,0,0,'zefzqegrd',10,26),(199,896,222,0,0,'dpobel@free.fr',11,26),(196,671,222,0,0,'fzefze',12,26),(195,670,222,0,0,'Testsfqeg e ',13,27),(199,896,222,0,0,'dpobel@free.fr',14,27),(196,671,222,0,0,'sgqeg q tegt erg ret',15,27),(195,670,222,0,0,'Test',16,28),(199,896,222,0,0,'dpobel@free.fr',17,28),(196,671,222,0,0,'s dr grg g rth d',18,28),(195,670,222,0,0,'zef e tergr t',19,29),(199,896,222,0,0,'dpobel@free.fr',20,29),(196,671,222,0,0,'ege er gretg rehg rte',21,29),(195,670,222,0,0,'Test',22,30),(199,896,222,0,0,'dpobel@free.fr',23,30),(196,671,222,0,0,'sdf sdg sgd sg sdgb\r\nsr\r\ngb dfsb sgbs d\r\nrg\r\nrt\r\nbrsd',24,30),(195,670,222,0,0,'zefdr rdt hth ty',25,32),(199,896,222,0,0,'dpobel@free.fr',26,32),(196,671,222,0,0,'erg grth reh erthrh eh rthr\r\nhrt\r\nhbrehrshwesehbd',27,32);
/*!40000 ALTER TABLE `ezinfocollection_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezisbn_group`
--

DROP TABLE IF EXISTS `ezisbn_group`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezisbn_group` (
  `description` varchar(255) NOT NULL default '',
  `group_number` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezisbn_group`
--

LOCK TABLES `ezisbn_group` WRITE;
/*!40000 ALTER TABLE `ezisbn_group` DISABLE KEYS */;
INSERT INTO `ezisbn_group` VALUES ('English speaking area',0,1),('English speaking area',1,2),('French speaking area',2,3),('German speaking area',3,4),('Japan',4,5),('Russian Federation',5,6),('Iran',600,7),('Kazakhstan',601,8),('Indonesia',602,9),('Saudi Arabia',603,10),('Vietnam',604,11),('Turkey',605,12),('Romania',606,13),('Mexico',607,14),('Macedonia',608,15),('Lithuania',609,16),('China, People\'s Republic',7,17),('Czech Republic; Slovakia',80,18),('India',81,19),('Norway',82,20),('Poland',83,21),('Spain',84,22),('Brazil',85,23),('Serbia and Montenegro',86,24),('Denmark',87,25),('Italian speaking area',88,26),('Korea',89,27),('Netherlands, Belgium (Flemish)',90,28),('Sweden',91,29),('International Publishers (Unesco, EU), European Community Organizations',92,30),('India - no ranges fixed yet',93,31),('Netherlands',94,32),('Argentina',950,33),('Finland',951,34),('Finland',952,35),('Croatia',953,36),('Bulgaria',954,37),('Sri Lanka',955,38),('Chile',956,39),('Taiwan, China',957,40),('Colombia',958,41),('Cuba',959,42),('Greece',960,43),('Slovenia',961,44),('Hong Kong',962,45),('Hungary',963,46),('Iran',964,47),('Israel',965,48),('Ukraine',966,49),('Malaysia',967,50),('Mexico',968,51),('Pakistan',969,52),('Mexico',970,53),('Philippines',971,54),('Portugal',972,55),('Romania',973,56),('Thailand',974,57),('Turkey',975,58),('Caribbean Community',976,59),('Egypr',977,60),('Nigeria',978,61),('Indonesia',979,62),('Venezuela',980,63),('Singapore',981,64),('South Pacific',982,65),('Malaysia',983,66),('Bangladesh',984,67),('Belarus',985,68),('Taiwan, China',986,69),('Argentina',987,70),('Hongkong',988,71),('Portugal',989,72),('Latvia',9934,73),('Iceland',9935,74),('Afghanistan',9936,75),('Nepal',9937,76),('Tunisia',9938,77),('Armenia',9939,78),('Montenegro',9940,79),('Georgia',9941,80),('Ecuador',9942,81),('Uzbekistan',9943,82),('Turkey',9944,83),('Dominican Republic',9945,84),('Korea, P.D.R.',9946,85),('Algeria',9947,86),('United Arab Emirates',9948,87),('Estonia',9949,88),('Palestine',9950,89),('Kosova',9951,90),('Azerbaijan',9952,91),('Lebanon',9953,92),('Morocco',9954,93),('Lithuania',9955,94),('Cameroon',9956,95),('Jordan',9957,96),('Bosnia and Herzegovina',9958,97),('Libya',9959,98),('Saudi Arabia',9960,99),('Algeria',9961,100),('Panama',9962,101),('Cyprus',9963,102),('Ghana',9964,103),('Kazakhstan',9965,104),('Kenya',9966,105),('Kyrgyzstan',9967,106),('Costa Rica',9968,107),('Uganda',9970,108),('Singapore',9971,109),('Peru',9972,110),('Tunisia',9973,111),('Uruguay',9974,112),('Moldova',9975,113),('Tanzania',9976,114),('Costa Rica',9977,115),('Ecuador',9978,116),('Iceland',9979,117),('Papua New Guinea',9980,118),('Morocco',9981,119),('Zambia',9982,120),('Gambia',9983,121),('Latvia',9984,122),('Estonia',9985,123),('Lithuania',9986,124),('Tanzania',9987,125),('Ghana',9988,126),('Macedonia',9989,127),('Bahrain',99901,128),('Gabon - no ranges fixed yet',99902,129),('Mauritius',99903,130),('Netherlands Antilles; Aruba, Neth. Ant',99904,131),('Bolivia',99905,132),('Kuwait',99906,133),('Malawi',99908,134),('Malta',99909,135),('Sierra Leone',99910,136),('Lesotho',99911,137),('Botswana',99912,138),('Andorra',99913,139),('Suriname',99914,140),('Maldives',99915,141),('Namibia',99916,142),('Brunei Darussalam',99917,143),('Faroe Islands',99918,144),('Benin',99919,145),('Andorra',99920,146),('Qatar',99921,147),('Guatemala',99922,148),('El Salvador',99923,149),('Nicaragua',99924,150),('Paraguay',99925,151),('Honduras',99926,152),('Albania',99927,153),('Georgia',99928,154),('Mongolia',99929,155),('Armenia',99930,156),('Seychelles',99931,157),('Malta',99932,158),('Nepal',99933,159),('Dominican Republic',99934,160),('Haiti',99935,161),('Bhutan',99936,162),('Macau',99937,163),('Srpska',99938,164),('Guatemala',99939,165),('Georgia',99940,166),('Armenia',99941,167),('Sudan',99942,168),('Alsbania',99943,169),('Ethiopia',99944,170),('Namibia',99945,171),('Nepal',99946,172),('Tajikistan',99947,173),('Eritrea',99948,174),('Mauritius',99949,175),('Cambodia',99950,176),('Congo - no ranges fixed yet',99951,177),('Mali',99952,178),('Paraguay',99953,179),('Bolivia',99954,180),('Srpska',99955,181),('Albania',99956,182),('Malta',99957,183),('Bahrain',99958,184),('Luxembourg',99959,185),('Malawi',99960,186);
/*!40000 ALTER TABLE `ezisbn_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezisbn_group_range`
--

DROP TABLE IF EXISTS `ezisbn_group_range`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezisbn_group_range` (
  `from_number` int(11) NOT NULL default '0',
  `group_from` varchar(32) NOT NULL default '',
  `group_length` int(11) NOT NULL default '0',
  `group_to` varchar(32) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `to_number` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezisbn_group_range`
--

LOCK TABLES `ezisbn_group_range` WRITE;
/*!40000 ALTER TABLE `ezisbn_group_range` DISABLE KEYS */;
INSERT INTO `ezisbn_group_range` VALUES (0,'0',1,'5',1,59999),(70000,'7',1,'7',2,79999),(60000,'600',3,'609',3,60999),(95000,'950',3,'989',4,98999),(80000,'80',2,'94',5,94999),(99340,'9934',4,'9968',6,99689),(99700,'9970',4,'9989',7,99899),(99901,'99901',5,'99906',8,99906),(99908,'99908',5,'99960',9,99960);
/*!40000 ALTER TABLE `ezisbn_group_range` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezisbn_registrant_range`
--

DROP TABLE IF EXISTS `ezisbn_registrant_range`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezisbn_registrant_range` (
  `from_number` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `isbn_group_id` int(11) NOT NULL default '0',
  `registrant_from` varchar(32) NOT NULL default '',
  `registrant_length` int(11) NOT NULL default '0',
  `registrant_to` varchar(32) NOT NULL default '',
  `to_number` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=815 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezisbn_registrant_range`
--

LOCK TABLES `ezisbn_registrant_range` WRITE;
/*!40000 ALTER TABLE `ezisbn_registrant_range` DISABLE KEYS */;
INSERT INTO `ezisbn_registrant_range` VALUES (0,1,1,'00',2,'19',19999),(20000,2,1,'200',3,'699',69999),(70000,3,1,'7000',4,'8499',84999),(85000,4,1,'85000',5,'89999',89999),(90000,5,1,'900000',6,'949999',94999),(95000,6,1,'9500000',7,'9999999',99999),(0,7,2,'00',2,'09',9999),(10000,8,2,'100',3,'399',39999),(40000,9,2,'4000',4,'5499',54999),(55000,10,2,'55000',5,'86979',86979),(86980,11,2,'869800',6,'998999',99899),(0,12,3,'00',2,'19',19999),(20000,13,3,'200',3,'349',34999),(35000,14,3,'35000',5,'39999',39999),(40000,15,3,'400',3,'699',69999),(70000,16,3,'7000',4,'8399',83999),(84000,17,3,'84000',5,'89999',89999),(90000,18,3,'900000',6,'949999',94999),(95000,19,3,'9500000',7,'9999999',99999),(0,20,4,'00',2,'02',2999),(3000,21,4,'030',3,'033',3399),(3400,22,4,'0340',4,'0369',3699),(3700,23,4,'03700',5,'03999',3999),(4000,24,4,'04',2,'19',19999),(20000,25,4,'200',3,'699',69999),(70000,26,4,'7000',4,'8499',84999),(85000,27,4,'85000',5,'89999',89999),(90000,28,4,'900000',6,'949999',94999),(95000,29,4,'9500000',7,'9539999',95399),(95400,30,4,'95400',5,'96999',96999),(97000,31,4,'9700000',7,'9899999',98999),(99000,32,4,'99000',5,'99499',99499),(99500,33,4,'99500',5,'99999',99999),(0,34,4,'',0,'',99999),(0,35,5,'00',2,'19',19999),(20000,36,5,'200',3,'699',69999),(70000,37,5,'7000',4,'8499',84999),(85000,38,5,'85000',5,'89999',89999),(90000,39,5,'900000',6,'949999',94999),(95000,40,5,'9500000',7,'9999999',99999),(0,41,6,'00',2,'19',19999),(20000,42,6,'200',3,'420',42099),(42100,43,6,'4210',4,'4299',42999),(43000,44,6,'430',3,'430',43099),(43100,45,6,'4310',4,'4399',43999),(44000,46,6,'440',3,'440',44099),(44100,47,6,'4410',4,'4499',44999),(45000,48,6,'450',3,'699',69999),(70000,49,6,'7000',4,'8499',84999),(85000,50,6,'85000',5,'89999',89999),(90000,51,6,'900000',6,'909999',90999),(91000,52,6,'91000',5,'91999',91999),(92000,53,6,'9200',4,'9299',92999),(93000,54,6,'93000',5,'94999',94999),(95000,55,6,'9500',4,'9799',97999),(98000,56,6,'98000',5,'98999',98999),(99000,57,6,'9900000',7,'9909999',99099),(99100,58,6,'9910',4,'9999',99999),(0,59,7,'00',2,'09',9999),(10000,60,7,'100',3,'499',49999),(50000,61,7,'5000',4,'8999',89999),(90000,62,7,'90000',5,'99999',99999),(0,63,8,'00',2,'19',19999),(20000,64,8,'200',3,'699',69999),(70000,65,8,'7000',4,'7999',79999),(80000,66,8,'80000',5,'84999',84999),(85000,67,8,'85',2,'99',99999),(0,68,9,'00',2,'19',19999),(20000,69,9,'200',3,'799',79999),(80000,70,9,'8000',4,'9499',94999),(95000,71,9,'95000',5,'99999',99999),(0,72,10,'00',2,'04',4999),(50000,73,10,'500',3,'799',79999),(80000,74,10,'8000',4,'8999',89999),(90000,75,10,'90000',5,'99999',99999),(0,76,11,'0',1,'4',49999),(50000,77,11,'50',2,'89',89999),(90000,78,11,'900',3,'979',97999),(98000,79,11,'9800',4,'9999',99999),(0,80,12,'00',2,'09',9999),(10000,81,12,'100',3,'399',39999),(40000,82,12,'4000',4,'5999',59999),(60000,83,12,'60000',5,'89999',89999),(0,84,13,'0',1,'0',9999),(10000,85,13,'10',2,'49',49999),(50000,86,13,'500',3,'799',79999),(80000,87,13,'8000',4,'9199',91999),(92000,88,13,'92000',5,'99999',99999),(0,89,14,'00',2,'39',39999),(40000,90,14,'400',3,'749',74999),(75000,91,14,'7500',4,'9499',94999),(95000,92,14,'95000',5,'99999',99999),(0,93,15,'0',1,'0',9999),(10000,94,15,'10',2,'19',19999),(20000,95,15,'200',3,'449',44999),(45000,96,15,'4500',4,'6499',64999),(65000,97,15,'65000',5,'69999',69999),(70000,98,15,'7',1,'9',99999),(0,99,16,'00',2,'39',39999),(40000,100,16,'400',3,'799',79999),(80000,101,16,'8000',4,'9499',94999),(95000,102,16,'95000',5,'99999',99999),(0,103,17,'00',2,'09',9999),(10000,104,17,'100',3,'499',49999),(50000,105,17,'5000',4,'7999',79999),(80000,106,17,'80000',5,'89999',89999),(90000,107,17,'900000',6,'999999',99999),(0,108,18,'00',2,'19',19999),(20000,109,18,'200',3,'699',69999),(70000,110,18,'7000',4,'8499',84999),(85000,111,18,'85000',5,'89999',89999),(90000,112,18,'900000',6,'999999',99999),(0,113,19,'00',2,'19',19999),(20000,114,19,'200',3,'699',69999),(70000,115,19,'7000',4,'8499',84999),(85000,116,19,'85000',5,'89999',89999),(90000,117,19,'900000',6,'999999',99999),(0,118,20,'00',2,'19',19999),(20000,119,20,'200',3,'699',69999),(70000,120,20,'7000',4,'8999',89999),(90000,121,20,'90000',5,'98999',98999),(99000,122,20,'990000',6,'999999',99999),(0,123,21,'00',2,'19',19999),(20000,124,21,'200',3,'599',59999),(60000,125,21,'60000',5,'69999',69999),(70000,126,21,'7000',4,'8499',84999),(85000,127,21,'85000',5,'89999',89999),(90000,128,21,'900000',6,'999999',99999),(0,129,22,'00',2,'19',19999),(20000,130,22,'200',3,'699',69999),(70000,131,22,'7000',4,'8499',84999),(85000,132,22,'85000',5,'89999',89999),(90000,133,22,'9000',4,'9199',91999),(92000,134,22,'920000',6,'923999',92399),(92400,135,22,'92400',5,'92999',92999),(93000,136,22,'930000',6,'949999',94999),(95000,137,22,'95000',5,'96999',96999),(97000,138,22,'9700',4,'9999',99999),(0,139,23,'00',2,'19',19999),(20000,140,23,'200',3,'599',59999),(60000,141,23,'60000',5,'69999',69999),(70000,142,23,'7000',4,'8499',84999),(85000,143,23,'85000',5,'89999',89999),(90000,144,23,'900000',6,'979999',97999),(98000,145,23,'98000',5,'99999',99999),(0,146,24,'00',2,'29',29999),(30000,147,24,'300',3,'599',59999),(60000,148,24,'6000',4,'7999',79999),(80000,149,24,'80000',5,'89999',89999),(90000,150,24,'900000',6,'999999',99999),(0,151,25,'00',2,'29',29999),(40000,152,25,'400',3,'649',64999),(70000,153,25,'7000',4,'7999',79999),(85000,154,25,'85000',5,'94999',94999),(97000,155,25,'970000',6,'999999',99999),(0,156,26,'00',2,'19',19999),(20000,157,26,'200',3,'599',59999),(60000,158,26,'6000',4,'8499',84999),(85000,159,26,'85000',5,'89999',89999),(90000,160,26,'900000',6,'949999',94999),(95000,161,26,'95000',5,'99999',99999),(0,162,27,'00',2,'24',24999),(25000,163,27,'250',3,'549',54999),(55000,164,27,'5500',4,'8499',84999),(85000,165,27,'85000',5,'94999',94999),(95000,166,27,'950000',6,'999999',99999),(0,167,28,'00',2,'19',19999),(20000,168,28,'200',3,'499',49999),(50000,169,28,'5000',4,'6999',69999),(70000,170,28,'70000',5,'79999',79999),(80000,171,28,'800000',6,'849999',84999),(85000,172,28,'8500',4,'8999',89999),(90000,173,28,'900000',6,'909999',90999),(94000,174,28,'940000',6,'949999',94999),(0,175,29,'0',1,'1',19999),(20000,176,29,'20',2,'49',49999),(50000,177,29,'500',3,'649',64999),(70000,178,29,'7000',4,'7999',79999),(85000,179,29,'85000',5,'94999',94999),(97000,180,29,'970000',6,'999999',99999),(0,181,30,'0',1,'5',59999),(60000,182,30,'60',2,'79',79999),(80000,183,30,'800',3,'899',89999),(90000,184,30,'9000',4,'9499',94999),(95000,185,30,'95000',5,'98999',98999),(99000,186,30,'990000',6,'999999',99999),(0,187,32,'000',3,'599',59999),(60000,188,32,'6000',4,'8999',89999),(90000,189,32,'90000',5,'99999',99999),(0,190,33,'00',2,'49',49999),(50000,191,33,'500',3,'899',89999),(90000,192,33,'9000',4,'9899',98999),(99000,193,33,'99000',5,'99999',99999),(0,194,34,'0',1,'1',19999),(20000,195,34,'20',2,'54',54999),(55000,196,34,'550',3,'889',88999),(89000,197,34,'8900',4,'9499',94999),(95000,198,34,'95000',5,'99999',99999),(0,199,35,'00',2,'19',19999),(20000,200,35,'200',3,'499',49999),(50000,201,35,'5000',4,'5999',59999),(60000,202,35,'60',2,'65',65999),(66000,203,35,'6600',4,'6699',66999),(67000,204,35,'67000',5,'69999',69999),(70000,205,35,'7000',4,'7999',79999),(80000,206,35,'80',2,'94',94999),(95000,207,35,'9500',4,'9899',98999),(99000,208,35,'99000',5,'99999',99999),(0,209,36,'0',1,'0',9999),(10000,210,36,'10',2,'14',14999),(15000,211,36,'150',3,'549',54999),(55000,212,36,'55000',5,'59999',59999),(60000,213,36,'6000',4,'9499',94999),(95000,214,36,'95000',5,'99999',99999),(0,215,37,'00',2,'29',29999),(30000,216,37,'300',3,'799',79999),(80000,217,37,'8000',4,'8999',89999),(90000,218,37,'90000',5,'92999',92999),(93000,219,37,'9300',4,'9999',99999),(0,220,38,'0',1,'0',9999),(10000,221,38,'1000',4,'1999',19999),(20000,222,38,'20',2,'54',54999),(55000,223,38,'550',3,'799',79999),(80000,224,38,'8000',4,'9499',94999),(95000,225,38,'95000',5,'99999',99999),(0,226,39,'00',2,'19',19999),(20000,227,39,'200',3,'699',69999),(70000,228,39,'7000',4,'9999',99999),(0,229,40,'00',2,'02',2999),(3000,230,40,'0300',4,'0499',4999),(5000,231,40,'05',2,'19',19999),(20000,232,40,'2000',4,'2099',20999),(21000,233,40,'21',2,'27',27999),(28000,234,40,'28000',5,'30999',30999),(31000,235,40,'31',2,'43',43999),(44000,236,40,'440',3,'819',81999),(82000,237,40,'8200',4,'9699',96999),(97000,238,40,'97000',5,'99999',99999),(0,239,41,'00',2,'56',56999),(57000,240,41,'57000',5,'59999',59999),(60000,241,41,'600',3,'799',79999),(80000,242,41,'8000',4,'9499',94999),(95000,243,41,'95000',5,'99999',99999),(0,244,42,'00',2,'19',19999),(20000,245,42,'200',3,'699',69999),(70000,246,42,'7000',4,'8499',84999),(0,247,43,'00',2,'19',19999),(20000,248,43,'200',3,'659',65999),(66000,249,43,'6600',4,'6899',68999),(69000,250,43,'690',3,'699',69999),(70000,251,43,'7000',4,'8499',84999),(85000,252,43,'85000',5,'99999',99999),(0,253,44,'00',2,'19',19999),(20000,254,44,'200',3,'599',59999),(60000,255,44,'6000',4,'8999',89999),(90000,256,44,'90000',5,'94999',94999),(0,257,45,'00',2,'19',19999),(20000,258,45,'200',3,'699',69999),(70000,259,45,'7000',4,'8499',84999),(85000,260,45,'85000',5,'86999',86999),(87000,261,45,'8700',4,'8999',89999),(90000,262,45,'900',3,'999',99999),(0,263,46,'00',2,'19',19999),(20000,264,46,'200',3,'699',69999),(70000,265,46,'7000',4,'8499',84999),(85000,266,46,'85000',5,'89999',89999),(90000,267,46,'9000',4,'9999',99999),(0,268,47,'00',2,'14',14999),(15000,269,47,'150',3,'249',24999),(25000,270,47,'2500',4,'2999',29999),(30000,271,47,'300',3,'549',54999),(55000,272,47,'5500',4,'8999',89999),(90000,273,47,'90000',5,'96999',96999),(97000,274,47,'970',3,'989',98999),(99000,275,47,'9900',4,'9999',99999),(0,276,48,'00',2,'19',19999),(20000,277,48,'200',3,'599',59999),(70000,278,48,'7000',4,'7999',79999),(90000,279,48,'90000',5,'99999',99999),(0,280,49,'00',2,'14',14999),(15000,281,49,'1500',4,'1699',16999),(17000,282,49,'170',3,'199',19999),(20000,283,49,'2000',4,'2999',29999),(30000,284,49,'300',3,'699',69999),(70000,285,49,'7000',4,'8999',89999),(90000,286,49,'90000',5,'99999',99999),(0,287,50,'00',2,'29',29999),(30000,288,50,'300',3,'499',49999),(50000,289,50,'5000',4,'5999',59999),(60000,290,50,'60',2,'89',89999),(90000,291,50,'900',3,'989',98999),(99000,292,50,'9900',4,'9989',99899),(99900,293,50,'99900',5,'99999',99999),(1000,294,51,'01',2,'39',39999),(40000,295,51,'400',3,'499',49999),(50000,296,51,'5000',4,'7999',79999),(80000,297,51,'800',3,'899',89999),(90000,298,51,'9000',4,'9999',99999),(0,299,52,'0',1,'1',19999),(20000,300,52,'20',2,'39',39999),(40000,301,52,'400',3,'799',79999),(80000,302,52,'8000',4,'9999',99999),(1000,303,53,'01',2,'59',59999),(60000,304,53,'600',3,'899',89999),(90000,305,53,'9000',4,'9099',90999),(91000,306,53,'91000',5,'96999',96999),(97000,307,53,'9700',4,'9999',99999),(0,308,54,'000',3,'019',1999),(2000,309,54,'02',2,'02',2999),(3000,310,54,'0300',4,'0599',5999),(6000,311,54,'06',2,'09',9999),(10000,312,54,'10',2,'49',49999),(50000,313,54,'500',3,'849',84999),(85000,314,54,'8500',4,'9099',90999),(91000,315,54,'91000',5,'99999',99999),(0,316,55,'0',1,'1',19999),(20000,317,55,'20',2,'54',54999),(55000,318,55,'550',3,'799',79999),(80000,319,55,'8000',4,'9499',94999),(95000,320,55,'95000',5,'99999',99999),(0,321,56,'0',1,'0',9999),(10000,322,56,'100',3,'169',16999),(17000,323,56,'1700',4,'1999',19999),(20000,324,56,'20',2,'54',54999),(55000,325,56,'550',3,'759',75999),(76000,326,56,'7600',4,'8499',84999),(85000,327,56,'85000',5,'88999',88999),(89000,328,56,'8900',4,'9499',94999),(95000,329,56,'95000',5,'99999',99999),(0,330,57,'00',2,'19',19999),(20000,331,57,'200',3,'699',69999),(70000,332,57,'7000',4,'8499',84999),(85000,333,57,'85000',5,'89999',89999),(90000,334,57,'90000',5,'94999',94999),(95000,335,57,'9500',4,'9999',99999),(0,336,58,'00000',5,'00999',999),(1000,337,58,'01',2,'24',24999),(25000,338,58,'250',3,'599',59999),(60000,339,58,'6000',4,'9199',91999),(92000,340,58,'92000',5,'98999',98999),(99000,341,58,'990',3,'999',99999),(0,342,59,'0',1,'3',39999),(40000,343,59,'40',2,'59',59999),(60000,344,59,'600',3,'799',79999),(80000,345,59,'8000',4,'9499',94999),(95000,346,59,'95000',5,'99999',99999),(0,347,60,'00',2,'19',19999),(20000,348,60,'200',3,'499',49999),(50000,349,60,'5000',4,'6999',69999),(70000,350,60,'700',3,'999',99999),(0,351,61,'000',3,'199',19999),(20000,352,61,'2000',4,'2999',29999),(30000,353,61,'30000',5,'79999',79999),(80000,354,61,'8000',4,'8999',89999),(90000,355,61,'900',3,'999',99999),(0,356,62,'000',3,'099',9999),(10000,357,62,'1000',4,'1499',14999),(15000,358,62,'15000',5,'19999',19999),(20000,359,62,'20',2,'29',29999),(30000,360,62,'3000',4,'3999',39999),(40000,361,62,'400',3,'799',79999),(80000,362,62,'8000',4,'9499',94999),(95000,363,62,'95000',5,'99999',99999),(0,364,63,'00',2,'19',19999),(20000,365,63,'200',3,'599',59999),(60000,366,63,'6000',4,'9999',99999),(0,367,64,'00',2,'11',11999),(12000,368,64,'120',3,'299',29999),(30000,369,64,'3000',4,'9999',99999),(0,370,65,'00',2,'09',9999),(10000,371,65,'100',3,'699',69999),(70000,372,65,'70',2,'89',89999),(90000,373,65,'9000',4,'9999',99999),(0,374,66,'00',2,'01',1999),(2000,375,66,'020',3,'199',19999),(20000,376,66,'2000',4,'3999',39999),(40000,377,66,'40000',5,'44999',44999),(45000,378,66,'45',2,'49',49999),(50000,379,66,'50',2,'79',79999),(80000,380,66,'800',3,'899',89999),(90000,381,66,'9000',4,'9899',98999),(99000,382,66,'99000',5,'99999',99999),(0,383,67,'00',2,'39',39999),(40000,384,67,'400',3,'799',79999),(80000,385,67,'8000',4,'8999',89999),(90000,386,67,'90000',5,'99999',99999),(0,387,68,'00',2,'39',39999),(40000,388,68,'400',3,'599',59999),(60000,389,68,'6000',4,'8999',89999),(90000,390,68,'90000',5,'99999',99999),(0,391,69,'00',2,'11',11999),(12000,392,69,'120',3,'559',55999),(56000,393,69,'5600',4,'7999',79999),(80000,394,69,'80000',5,'99999',99999),(0,395,70,'00',2,'09',9999),(10000,396,70,'1000',4,'1999',19999),(20000,397,70,'20000',5,'29999',29999),(30000,398,70,'30',2,'49',49999),(50000,399,70,'500',3,'899',89999),(90000,400,70,'9000',4,'9499',94999),(95000,401,70,'95000',5,'99999',99999),(0,402,71,'00',2,'16',16999),(17000,403,71,'17000',5,'19999',19999),(20000,404,71,'200',3,'799',79999),(80000,405,71,'8000',4,'9699',96999),(97000,406,71,'97000',5,'99999',99999),(0,407,72,'0',1,'1',19999),(20000,408,72,'20',2,'54',54999),(55000,409,72,'550',3,'799',79999),(80000,410,72,'8000',4,'9499',94999),(95000,411,72,'95000',5,'99999',99999),(0,412,73,'0',1,'0',9999),(10000,413,73,'10',2,'49',49999),(50000,414,73,'500',3,'799',79999),(80000,415,73,'8000',4,'9999',99999),(0,416,74,'0',1,'0',9999),(10000,417,74,'10',2,'39',39999),(40000,418,74,'400',3,'899',89999),(90000,419,74,'9000',4,'9999',99999),(0,420,75,'0',1,'1',19999),(20000,421,75,'20',2,'39',39999),(40000,422,75,'400',3,'799',79999),(80000,423,75,'8000',4,'9999',99999),(0,424,76,'0',1,'2',29999),(30000,425,76,'30',2,'49',49999),(50000,426,76,'500',3,'799',79999),(80000,427,76,'8000',4,'9999',99999),(0,428,77,'00',2,'79',79999),(80000,429,77,'800',3,'949',94999),(95000,430,77,'9500',4,'9999',99999),(0,431,78,'0',1,'4',49999),(50000,432,78,'50',2,'79',79999),(80000,433,78,'800',3,'899',89999),(90000,434,78,'9000',4,'9999',99999),(0,435,79,'0',1,'1',19999),(20000,436,79,'20',2,'49',49999),(50000,437,79,'500',3,'899',89999),(90000,438,79,'9000',4,'9999',99999),(0,439,80,'0',1,'0',9999),(10000,440,80,'10',2,'39',39999),(40000,441,80,'400',3,'899',89999),(90000,442,80,'9000',4,'9999',99999),(0,443,81,'00',2,'89',89999),(90000,444,81,'900',3,'994',99499),(99500,445,81,'9950',4,'9999',99999),(0,446,82,'00',2,'29',29999),(30000,447,82,'300',3,'399',39999),(40000,448,82,'4000',4,'9999',99999),(0,449,83,'0',1,'2',29999),(30000,450,83,'300',3,'499',49999),(50000,451,83,'5000',4,'5999',59999),(60000,452,83,'60',2,'89',89999),(90000,453,83,'900',3,'999',99999),(0,454,84,'00',2,'00',999),(1000,455,84,'010',3,'079',7999),(8000,456,84,'08',2,'39',39999),(40000,457,84,'400',3,'569',56999),(57000,458,84,'57',2,'57',57999),(58000,459,84,'580',3,'849',84999),(85000,460,84,'8500',4,'9999',99999),(0,461,85,'0',1,'1',19999),(20000,462,85,'20',2,'39',39999),(40000,463,85,'400',3,'899',89999),(90000,464,85,'9000',4,'9999',99999),(0,465,86,'0',1,'1',19999),(20000,466,86,'20',2,'79',79999),(80000,467,86,'800',3,'999',99999),(0,468,87,'00',2,'39',39999),(40000,469,87,'400',3,'849',84999),(85000,470,87,'8500',4,'9999',99999),(0,471,88,'0',1,'0',9999),(10000,472,88,'10',2,'39',39999),(40000,473,88,'400',3,'899',89999),(90000,474,88,'9000',4,'9999',99999),(0,475,89,'00',2,'29',29999),(30000,476,89,'300',3,'840',84099),(85000,477,89,'8500',4,'9999',99999),(0,478,90,'00',2,'39',39999),(40000,479,90,'400',3,'849',84999),(85000,480,90,'8500',4,'9999',99999),(0,481,91,'0',1,'1',19999),(20000,482,91,'20',2,'39',39999),(40000,483,91,'400',3,'799',79999),(80000,484,91,'8000',4,'9999',99999),(0,485,92,'0',1,'0',9999),(10000,486,92,'10',2,'39',39999),(40000,487,92,'400',3,'599',59999),(60000,488,92,'60',2,'89',89999),(90000,489,92,'9000',4,'9999',99999),(0,490,93,'0',1,'1',19999),(20000,491,93,'20',2,'39',39999),(40000,492,93,'400',3,'799',79999),(80000,493,93,'8000',4,'9999',99999),(0,494,94,'00',2,'39',39999),(40000,495,94,'400',3,'929',92999),(93000,496,94,'9300',4,'9999',99999),(0,497,95,'0',1,'0',9999),(10000,498,95,'10',2,'39',39999),(40000,499,95,'400',3,'899',89999),(90000,500,95,'9000',4,'9999',99999),(0,501,96,'00',2,'39',39999),(40000,502,96,'400',3,'699',69999),(70000,503,96,'70',2,'84',84999),(85000,504,96,'8500',4,'9999',99999),(0,505,97,'0',1,'0',9999),(10000,506,97,'10',2,'49',49999),(50000,507,97,'500',3,'899',89999),(90000,508,97,'9000',4,'9999',99999),(0,509,98,'0',1,'1',19999),(20000,510,98,'20',2,'79',79999),(80000,511,98,'800',3,'949',94999),(95000,512,98,'9500',4,'9999',99999),(0,513,99,'00',2,'59',59999),(60000,514,99,'600',3,'899',89999),(90000,515,99,'9000',4,'9999',99999),(0,516,100,'0',1,'2',29999),(30000,517,100,'30',2,'69',69999),(70000,518,100,'700',3,'949',94999),(95000,519,100,'9500',4,'9999',99999),(0,520,101,'00',2,'54',54999),(55000,521,101,'5500',4,'5599',55999),(56000,522,101,'56',2,'59',59999),(60000,523,101,'600',3,'849',84999),(85000,524,101,'8500',4,'9999',99999),(0,525,102,'0',1,'2',29999),(30000,526,102,'30',2,'54',54999),(55000,527,102,'550',3,'749',74999),(75000,528,102,'7500',4,'9999',99999),(0,529,103,'0',1,'6',69999),(70000,530,103,'70',2,'94',94999),(95000,531,103,'950',3,'999',99999),(0,532,104,'00',2,'39',39999),(40000,533,104,'400',3,'899',89999),(90000,534,104,'9000',4,'9999',99999),(0,535,105,'00',2,'69',69999),(70000,536,105,'7000',4,'7499',74999),(75000,537,105,'750',3,'959',95999),(96000,538,105,'9600',4,'9999',99999),(0,539,106,'00',2,'39',39999),(40000,540,106,'400',3,'899',89999),(90000,541,106,'9000',4,'9999',99999),(0,542,107,'00',2,'49',49999),(50000,543,107,'500',3,'939',93999),(94000,544,107,'9400',4,'9999',99999),(0,545,108,'00',2,'39',39999),(40000,546,108,'400',3,'899',89999),(90000,547,108,'9000',4,'9999',99999),(0,548,109,'0',1,'5',59999),(60000,549,109,'60',2,'89',89999),(90000,550,109,'900',3,'989',98999),(99000,551,109,'9900',4,'9999',99999),(0,552,110,'00',2,'09',9999),(10000,553,110,'1',1,'1',19999),(20000,554,110,'200',3,'249',24999),(25000,555,110,'2500',4,'2999',29999),(30000,556,110,'30',2,'59',59999),(60000,557,110,'600',3,'899',89999),(90000,558,110,'9000',4,'9999',99999),(0,559,111,'0',1,'05',5999),(6000,560,111,'060',3,'089',8999),(9000,561,111,'0900',4,'0999',9999),(10000,562,111,'10',2,'69',69999),(70000,563,111,'700',3,'969',96999),(97000,564,111,'9700',4,'9999',99999),(0,565,112,'0',1,'2',29999),(30000,566,112,'30',2,'54',54999),(55000,567,112,'550',3,'749',74999),(75000,568,112,'7500',4,'9499',94999),(95000,569,112,'95',2,'99',99999),(0,570,113,'0',1,'0',9999),(10000,571,113,'100',3,'399',39999),(40000,572,113,'4000',4,'4499',44999),(45000,573,113,'45',2,'89',89999),(90000,574,113,'900',3,'949',94999),(95000,575,113,'9500',4,'9999',99999),(0,576,114,'0',1,'5',59999),(60000,577,114,'60',2,'89',89999),(90000,578,114,'900',3,'989',98999),(99900,579,114,'9990',4,'9999',99999),(0,580,115,'00',2,'89',89999),(90000,581,115,'900',3,'989',98999),(99000,582,115,'9900',4,'9999',99999),(0,583,116,'00',2,'29',29999),(30000,584,116,'300',3,'399',39999),(40000,585,116,'40',2,'94',94999),(95000,586,116,'950',3,'989',98999),(99000,587,116,'9900',4,'9999',99999),(0,588,117,'0',1,'4',49999),(50000,589,117,'50',2,'64',64999),(65000,590,117,'650',3,'659',65999),(66000,591,117,'66',2,'75',75999),(76000,592,117,'760',3,'899',89999),(90000,593,117,'9000',4,'9999',99999),(0,594,118,'0',1,'3',39999),(40000,595,118,'40',2,'89',89999),(90000,596,118,'900',3,'989',98999),(99000,597,118,'9900',4,'9999',99999),(0,598,119,'00',2,'09',9999),(10000,599,119,'100',3,'159',15999),(16000,600,119,'1600',4,'1999',19999),(20000,601,119,'20',2,'79',79999),(80000,602,119,'800',3,'949',94999),(95000,603,119,'9500',4,'9999',99999),(0,604,120,'00',2,'79',79999),(80000,605,120,'800',3,'989',98999),(99000,606,120,'9900',4,'9999',99999),(80000,607,121,'80',2,'94',94999),(95000,608,121,'950',3,'989',98999),(99000,609,121,'9900',4,'9999',99999),(0,610,122,'00',2,'49',49999),(50000,611,122,'500',3,'899',89999),(90000,612,122,'9000',4,'9999',99999),(0,613,123,'0',1,'4',49999),(50000,614,123,'50',2,'79',79999),(80000,615,123,'800',3,'899',89999),(90000,616,123,'9000',4,'9999',99999),(0,617,124,'00',2,'39',39999),(40000,618,124,'400',3,'899',89999),(90000,619,124,'9000',4,'9399',93999),(94000,620,124,'940',3,'969',96999),(97000,621,124,'97',2,'99',99999),(0,622,125,'00',2,'39',39999),(40000,623,125,'400',3,'879',87999),(88000,624,125,'8800',4,'9999',99999),(0,625,126,'0',1,'2',29999),(30000,626,126,'30',2,'54',54999),(55000,627,126,'550',3,'749',74999),(75000,628,126,'7500',4,'9999',99999),(0,629,127,'0',1,'0',9999),(10000,630,127,'100',3,'199',19999),(20000,631,127,'2000',4,'2999',29999),(30000,632,127,'30',2,'59',59999),(60000,633,127,'600',3,'949',94999),(95000,634,127,'9500',4,'9999',99999),(0,635,128,'00',2,'49',49999),(50000,636,128,'500',3,'799',79999),(80000,637,128,'80',2,'99',99999),(0,638,130,'0',1,'1',19999),(20000,639,130,'20',2,'89',89999),(90000,640,130,'900',3,'999',99999),(0,641,131,'0',1,'5',59999),(60000,642,131,'60',2,'89',89999),(90000,643,131,'900',3,'999',99999),(0,644,132,'0',1,'3',39999),(40000,645,132,'40',2,'79',79999),(80000,646,132,'800',3,'999',99999),(0,647,133,'0',1,'2',29999),(30000,648,133,'30',2,'59',59999),(60000,649,133,'600',3,'699',69999),(70000,650,133,'70',2,'89',89999),(90000,651,133,'9',1,'9',99999),(0,652,134,'0',1,'0',9999),(10000,653,134,'10',2,'89',89999),(90000,654,134,'900',3,'999',99999),(0,655,135,'0',1,'3',39999),(40000,656,135,'40',2,'94',94999),(95000,657,135,'950',3,'999',99999),(0,658,136,'0',1,'2',29999),(30000,659,136,'30',2,'89',89999),(90000,660,136,'900',3,'999',99999),(0,661,137,'00',2,'59',59999),(60000,662,137,'600',3,'999',99999),(0,663,138,'0',1,'3',39999),(40000,664,138,'400',3,'599',59999),(60000,665,138,'60',2,'89',89999),(90000,666,138,'900',3,'999',99999),(0,667,139,'0',1,'2',29999),(30000,668,139,'30',2,'35',35999),(60000,669,139,'600',3,'604',60499),(0,670,140,'0',1,'4',49999),(50000,671,140,'50',2,'89',89999),(90000,672,140,'900',3,'949',94999),(0,673,141,'0',1,'4',49999),(50000,674,141,'50',2,'79',79999),(80000,675,141,'800',3,'999',99999),(0,676,142,'0',1,'2',29999),(30000,677,142,'30',2,'69',69999),(70000,678,142,'700',3,'999',99999),(0,679,143,'0',1,'2',29999),(30000,680,143,'30',2,'89',89999),(90000,681,143,'900',3,'999',99999),(0,682,144,'0',1,'3',39999),(40000,683,144,'40',2,'79',79999),(80000,684,144,'800',3,'999',99999),(0,685,145,'0',1,'2',29999),(40000,686,145,'40',2,'69',69999),(90000,687,145,'900',3,'999',99999),(0,688,146,'0',1,'4',49999),(50000,689,146,'50',2,'89',89999),(90000,690,146,'900',3,'999',99999),(0,691,147,'0',1,'1',19999),(20000,692,147,'20',2,'69',69999),(70000,693,147,'700',3,'799',79999),(80000,694,147,'8',1,'8',89999),(90000,695,147,'90',2,'99',99999),(0,696,148,'0',1,'3',39999),(40000,697,148,'40',2,'69',69999),(70000,698,148,'700',3,'999',99999),(0,699,149,'0',1,'1',19999),(20000,700,149,'20',2,'79',79999),(80000,701,149,'800',3,'999',99999),(0,702,150,'0',1,'2',29999),(30000,703,150,'30',2,'79',79999),(80000,704,150,'800',3,'999',99999),(0,705,151,'0',1,'3',39999),(40000,706,151,'40',2,'79',79999),(80000,707,151,'800',3,'999',99999),(0,708,152,'0',1,'0',9999),(10000,709,152,'10',2,'59',59999),(60000,710,152,'600',3,'999',99999),(0,711,153,'0',1,'2',29999),(30000,712,153,'30',2,'59',59999),(60000,713,153,'600',3,'999',99999),(0,714,154,'0',1,'0',9999),(10000,715,154,'10',2,'79',79999),(80000,716,154,'800',3,'999',99999),(0,717,155,'0',1,'4',49999),(50000,718,155,'50',2,'79',79999),(80000,719,155,'800',3,'999',99999),(0,720,156,'0',1,'4',49999),(50000,721,156,'50',2,'79',79999),(80000,722,156,'800',3,'999',99999),(0,723,157,'0',1,'4',49999),(50000,724,157,'50',2,'79',79999),(80000,725,157,'800',3,'999',99999),(0,726,158,'0',1,'0',9999),(10000,727,158,'10',2,'59',59999),(60000,728,158,'600',3,'699',69999),(70000,729,158,'7',1,'7',79999),(80000,730,158,'80',2,'99',99999),(0,731,159,'0',1,'2',29999),(30000,732,159,'30',2,'59',59999),(60000,733,159,'600',3,'999',99999),(0,734,160,'0',1,'1',19999),(20000,735,160,'20',2,'79',79999),(80000,736,160,'800',3,'999',99999),(0,737,161,'0',1,'2',29999),(70000,738,161,'7',1,'8',89999),(30000,739,161,'30',2,'59',59999),(60000,740,161,'600',3,'699',69999),(90000,741,161,'90',2,'99',99999),(0,742,162,'0',1,'0',9999),(10000,743,162,'10',2,'59',59999),(60000,744,162,'600',3,'999',99999),(0,745,163,'0',1,'1',19999),(20000,746,163,'20',2,'59',59999),(60000,747,163,'600',3,'999',99999),(0,748,164,'0',1,'1',19999),(20000,749,164,'20',2,'59',59999),(60000,750,164,'600',3,'899',89999),(90000,751,164,'90',2,'99',99999),(0,752,165,'0',1,'5',59999),(60000,753,165,'60',2,'89',89999),(90000,754,165,'900',3,'999',99999),(0,755,166,'0',1,'0',9999),(10000,756,166,'10',2,'69',69999),(70000,757,166,'700',3,'999',99999),(0,758,167,'0',1,'2',29999),(30000,759,167,'30',2,'79',79999),(80000,760,167,'800',3,'999',99999),(0,761,168,'0',1,'4',49999),(50000,762,168,'50',2,'79',79999),(80000,763,168,'800',3,'999',99999),(0,764,169,'0',1,'2',29999),(30000,765,169,'30',2,'59',59999),(60000,766,169,'600',3,'999',99999),(0,767,170,'0',1,'4',49999),(50000,768,170,'50',2,'79',79999),(80000,769,170,'800',3,'999',99999),(0,770,171,'0',1,'5',59999),(60000,771,171,'60',2,'89',89999),(90000,772,171,'900',3,'999',99999),(0,773,172,'0',1,'2',29999),(30000,774,172,'30',2,'59',59999),(60000,775,172,'600',3,'999',99999),(0,776,173,'0',1,'2',29999),(30000,777,173,'30',2,'69',69999),(70000,778,173,'700',3,'999',99999),(0,779,174,'0',1,'4',49999),(50000,780,174,'50',2,'79',79999),(80000,781,174,'800',3,'999',99999),(0,782,175,'0',1,'1',19999),(20000,783,175,'20',2,'89',89999),(90000,784,175,'900',3,'999',99999),(0,785,176,'0',1,'4',49999),(50000,786,176,'50',2,'79',79999),(80000,787,176,'800',3,'999',99999),(0,788,178,'0',1,'4',49999),(50000,789,178,'50',2,'79',79999),(80000,790,178,'800',3,'999',99999),(0,791,179,'0',1,'2',29999),(30000,792,179,'30',2,'79',79999),(80000,793,179,'800',3,'999',99999),(0,794,180,'0',1,'2',29999),(30000,795,180,'30',2,'69',69999),(70000,796,180,'700',3,'999',99999),(0,797,181,'0',1,'1',19999),(20000,798,181,'20',2,'59',59999),(60000,799,181,'600',3,'899',89999),(90000,800,181,'90',2,'99',99999),(0,801,182,'00',2,'59',59999),(60000,802,182,'600',3,'999',99999),(0,803,183,'0',1,'1',19999),(20000,804,183,'20',2,'79',79999),(80000,805,183,'800',3,'999',99999),(0,806,184,'0',1,'4',49999),(50000,807,184,'50',2,'94',94999),(95000,808,184,'950',3,'999',99999),(0,809,185,'0',1,'2',29999),(30000,810,185,'30',2,'59',59999),(60000,811,185,'600',3,'999',99999),(0,812,186,'0',1,'0',9999),(10000,813,186,'10',2,'94',94999),(95000,814,186,'950',3,'999',99999);
/*!40000 ALTER TABLE `ezisbn_registrant_range` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezkeyword`
--

DROP TABLE IF EXISTS `ezkeyword`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezkeyword` (
  `class_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `keyword` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `ezkeyword_keyword` (`keyword`),
  KEY `ezkeyword_keyword_id` (`keyword`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezkeyword`
--

LOCK TABLES `ezkeyword` WRITE;
/*!40000 ALTER TABLE `ezkeyword` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezkeyword` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezkeyword_attribute_link`
--

DROP TABLE IF EXISTS `ezkeyword_attribute_link`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezkeyword_attribute_link` (
  `id` int(11) NOT NULL auto_increment,
  `keyword_id` int(11) NOT NULL default '0',
  `objectattribute_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ezkeyword_attr_link_keyword_id` (`keyword_id`),
  KEY `ezkeyword_attr_link_kid_oaid` (`keyword_id`,`objectattribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezkeyword_attribute_link`
--

LOCK TABLES `ezkeyword_attribute_link` WRITE;
/*!40000 ALTER TABLE `ezkeyword_attribute_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezkeyword_attribute_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezmedia`
--

DROP TABLE IF EXISTS `ezmedia`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezmedia` (
  `contentobject_attribute_id` int(11) NOT NULL default '0',
  `controls` varchar(50) default NULL,
  `filename` varchar(255) NOT NULL default '',
  `has_controller` int(11) default '0',
  `height` int(11) default NULL,
  `is_autoplay` int(11) default '0',
  `is_loop` int(11) default '0',
  `mime_type` varchar(50) NOT NULL default '',
  `original_filename` varchar(255) NOT NULL default '',
  `pluginspage` varchar(255) default NULL,
  `quality` varchar(50) default NULL,
  `version` int(11) NOT NULL default '0',
  `width` int(11) default NULL,
  PRIMARY KEY  (`contentobject_attribute_id`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezmedia`
--

LOCK TABLES `ezmedia` WRITE;
/*!40000 ALTER TABLE `ezmedia` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezmedia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezmessage`
--

DROP TABLE IF EXISTS `ezmessage`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezmessage` (
  `body` longtext,
  `destination_address` varchar(50) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `is_sent` int(11) NOT NULL default '0',
  `send_method` varchar(50) NOT NULL default '',
  `send_time` varchar(50) NOT NULL default '',
  `send_weekday` varchar(50) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezmessage`
--

LOCK TABLES `ezmessage` WRITE;
/*!40000 ALTER TABLE `ezmessage` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezmessage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezmodule_run`
--

DROP TABLE IF EXISTS `ezmodule_run`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezmodule_run` (
  `function_name` varchar(255) default NULL,
  `id` int(11) NOT NULL auto_increment,
  `module_data` longtext,
  `module_name` varchar(255) default NULL,
  `workflow_process_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ezmodule_run_workflow_process_id_s` (`workflow_process_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezmodule_run`
--

LOCK TABLES `ezmodule_run` WRITE;
/*!40000 ALTER TABLE `ezmodule_run` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezmodule_run` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezmultipricedata`
--

DROP TABLE IF EXISTS `ezmultipricedata`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezmultipricedata` (
  `contentobject_attr_id` int(11) NOT NULL default '0',
  `contentobject_attr_version` int(11) NOT NULL default '0',
  `currency_code` varchar(4) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `type` int(11) NOT NULL default '0',
  `value` decimal(15,2) NOT NULL default '0.00',
  PRIMARY KEY  (`id`),
  KEY `ezmultipricedata_coa_id` (`contentobject_attr_id`),
  KEY `ezmultipricedata_coa_version` (`contentobject_attr_version`),
  KEY `ezmultipricedata_currency_code` (`currency_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezmultipricedata`
--

LOCK TABLES `ezmultipricedata` WRITE;
/*!40000 ALTER TABLE `ezmultipricedata` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezmultipricedata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eznode_assignment`
--

DROP TABLE IF EXISTS `eznode_assignment`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `eznode_assignment` (
  `contentobject_id` int(11) default NULL,
  `contentobject_version` int(11) default NULL,
  `from_node_id` int(11) default '0',
  `id` int(11) NOT NULL auto_increment,
  `is_main` int(11) NOT NULL default '0',
  `op_code` int(11) NOT NULL default '0',
  `parent_node` int(11) default NULL,
  `parent_remote_id` varchar(100) NOT NULL default '',
  `remote_id` int(11) NOT NULL default '0',
  `sort_field` int(11) default '1',
  `sort_order` int(11) default '1',
  PRIMARY KEY  (`id`),
  KEY `eznode_assignment_co_id` (`contentobject_id`),
  KEY `eznode_assignment_co_version` (`contentobject_version`),
  KEY `eznode_assignment_coid_cov` (`contentobject_id`,`contentobject_version`),
  KEY `eznode_assignment_is_main` (`is_main`),
  KEY `eznode_assignment_parent_node` (`parent_node`)
) ENGINE=InnoDB AUTO_INCREMENT=560 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `eznode_assignment`
--

LOCK TABLES `eznode_assignment` WRITE;
/*!40000 ALTER TABLE `eznode_assignment` DISABLE KEYS */;
INSERT INTO `eznode_assignment` VALUES (8,2,0,4,1,2,5,'',0,1,1),(42,1,0,5,1,2,5,'',0,9,1),(10,2,-1,6,1,2,44,'',0,9,1),(4,1,0,7,1,2,1,'',0,1,1),(12,1,0,8,1,2,5,'',0,1,1),(13,1,0,9,1,2,5,'',0,1,1),(14,1,0,10,1,2,13,'',0,1,1),(41,1,0,11,1,2,1,'',0,1,1),(11,1,0,12,1,2,5,'',0,1,1),(45,1,-1,16,1,2,1,'',0,9,1),(49,1,0,27,1,2,43,'',0,9,1),(50,1,0,28,1,2,43,'',0,9,1),(51,1,0,29,1,2,43,'',0,9,1),(52,1,0,30,1,2,48,'',0,1,1),(54,1,0,31,1,2,58,'',0,1,1),(56,1,0,34,1,2,1,'',0,2,0),(14,2,-1,35,1,2,13,'',0,1,1),(57,1,0,36,1,2,2,'',0,2,0),(141,1,0,183,1,2,2,'',0,1,1),(141,2,-1,184,1,2,2,'',0,1,1),(142,1,0,185,1,2,2,'',0,1,1),(221,1,0,264,1,2,2,'',0,1,1),(222,1,0,265,1,2,2,'',0,1,1),(221,2,-1,343,1,2,2,'',0,1,1),(221,3,-1,344,1,2,2,'',0,1,1),(221,4,-1,345,1,2,2,'',0,1,1),(221,5,-1,346,1,2,2,'',0,1,1),(222,2,-1,347,1,2,2,'',0,1,1),(221,6,-1,507,1,2,2,'',0,1,1),(221,7,-1,515,1,2,2,'',0,1,1),(14,3,-1,559,1,2,13,'',0,1,1);
/*!40000 ALTER TABLE `eznode_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eznotificationcollection`
--

DROP TABLE IF EXISTS `eznotificationcollection`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `eznotificationcollection` (
  `data_subject` longtext NOT NULL,
  `data_text` longtext NOT NULL,
  `event_id` int(11) NOT NULL default '0',
  `handler` varchar(255) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `transport` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `eznotificationcollection`
--

LOCK TABLES `eznotificationcollection` WRITE;
/*!40000 ALTER TABLE `eznotificationcollection` DISABLE KEYS */;
/*!40000 ALTER TABLE `eznotificationcollection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eznotificationcollection_item`
--

DROP TABLE IF EXISTS `eznotificationcollection_item`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `eznotificationcollection_item` (
  `address` varchar(255) NOT NULL default '',
  `collection_id` int(11) NOT NULL default '0',
  `event_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `send_date` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `eznotificationcollection_item`
--

LOCK TABLES `eznotificationcollection_item` WRITE;
/*!40000 ALTER TABLE `eznotificationcollection_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `eznotificationcollection_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eznotificationevent`
--

DROP TABLE IF EXISTS `eznotificationevent`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `eznotificationevent` (
  `data_int1` int(11) NOT NULL default '0',
  `data_int2` int(11) NOT NULL default '0',
  `data_int3` int(11) NOT NULL default '0',
  `data_int4` int(11) NOT NULL default '0',
  `data_text1` longtext NOT NULL,
  `data_text2` longtext NOT NULL,
  `data_text3` longtext NOT NULL,
  `data_text4` longtext NOT NULL,
  `event_type_string` varchar(255) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=939 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `eznotificationevent`
--

LOCK TABLES `eznotificationevent` WRITE;
/*!40000 ALTER TABLE `eznotificationevent` DISABLE KEYS */;
INSERT INTO `eznotificationevent` VALUES (14,2,0,0,'','','','','ezpublish',1,0),(57,1,0,0,'','','','','ezpublish',2,0),(59,1,0,0,'','','','','ezpublish',3,0),(59,2,0,0,'','','','','ezpublish',4,0),(60,1,0,0,'','','','','ezpublish',5,0),(60,3,0,0,'','','','','ezpublish',6,0),(60,4,0,0,'','','','','ezpublish',7,0),(59,3,0,0,'','','','','ezpublish',8,0),(59,5,0,0,'','','','','ezpublish',9,0),(59,6,0,0,'','','','','ezpublish',10,0),(60,5,0,0,'','','','','ezpublish',11,0),(62,1,0,0,'','','','','ezpublish',12,0),(63,1,0,0,'','','','','ezpublish',13,0),(64,1,0,0,'','','','','ezpublish',14,0),(65,1,0,0,'','','','','ezpublish',15,0),(66,1,0,0,'','','','','ezpublish',16,0),(67,1,0,0,'','','','','ezpublish',17,0),(68,1,0,0,'','','','','ezpublish',18,0),(69,1,0,0,'','','','','ezpublish',19,0),(70,1,0,0,'','','','','ezpublish',20,0),(71,1,0,0,'','','','','ezpublish',21,0),(72,1,0,0,'','','','','ezpublish',22,0),(73,1,0,0,'','','','','ezpublish',23,0),(74,1,0,0,'','','','','ezpublish',24,0),(75,1,0,0,'','','','','ezpublish',25,0),(76,1,0,0,'','','','','ezpublish',26,0),(77,1,0,0,'','','','','ezpublish',27,0),(78,1,0,0,'','','','','ezpublish',28,0),(79,1,0,0,'','','','','ezpublish',29,0),(80,1,0,0,'','','','','ezpublish',30,0),(81,1,0,0,'','','','','ezpublish',31,0),(82,1,0,0,'','','','','ezpublish',32,0),(83,1,0,0,'','','','','ezpublish',33,0),(84,1,0,0,'','','','','ezpublish',34,0),(85,1,0,0,'','','','','ezpublish',35,0),(86,1,0,0,'','','','','ezpublish',36,0),(87,1,0,0,'','','','','ezpublish',37,0),(88,1,0,0,'','','','','ezpublish',38,0),(89,1,0,0,'','','','','ezpublish',39,0),(90,1,0,0,'','','','','ezpublish',40,0),(91,1,0,0,'','','','','ezpublish',41,0),(92,1,0,0,'','','','','ezpublish',42,0),(93,1,0,0,'','','','','ezpublish',43,0),(94,1,0,0,'','','','','ezpublish',44,0),(95,1,0,0,'','','','','ezpublish',45,0),(96,1,0,0,'','','','','ezpublish',46,0),(97,1,0,0,'','','','','ezpublish',47,0),(98,1,0,0,'','','','','ezpublish',48,0),(99,1,0,0,'','','','','ezpublish',49,0),(100,1,0,0,'','','','','ezpublish',50,0),(101,1,0,0,'','','','','ezpublish',51,0),(102,1,0,0,'','','','','ezpublish',52,0),(59,7,0,0,'','','','','ezpublish',53,0),(62,2,0,0,'','','','','ezpublish',54,0),(60,6,0,0,'','','','','ezpublish',55,0),(62,3,0,0,'','','','','ezpublish',56,0),(60,7,0,0,'','','','','ezpublish',57,0),(59,8,0,0,'','','','','ezpublish',58,0),(62,4,0,0,'','','','','ezpublish',59,0),(60,8,0,0,'','','','','ezpublish',60,0),(59,9,0,0,'','','','','ezpublish',61,0),(103,1,0,0,'','','','','ezpublish',62,0),(104,1,0,0,'','','','','ezpublish',63,0),(105,1,0,0,'','','','','ezpublish',64,0),(106,1,0,0,'','','','','ezpublish',65,0),(107,1,0,0,'','','','','ezpublish',66,0),(108,1,0,0,'','','','','ezpublish',67,0),(109,1,0,0,'','','','','ezpublish',68,0),(110,1,0,0,'','','','','ezpublish',69,0),(111,1,0,0,'','','','','ezpublish',70,0),(112,1,0,0,'','','','','ezpublish',71,0),(113,1,0,0,'','','','','ezpublish',72,0),(114,1,0,0,'','','','','ezpublish',73,0),(115,1,0,0,'','','','','ezpublish',74,0),(116,1,0,0,'','','','','ezpublish',75,0),(117,1,0,0,'','','','','ezpublish',76,0),(118,1,0,0,'','','','','ezpublish',77,0),(119,1,0,0,'','','','','ezpublish',78,0),(120,1,0,0,'','','','','ezpublish',79,0),(121,1,0,0,'','','','','ezpublish',80,0),(122,1,0,0,'','','','','ezpublish',81,0),(123,1,0,0,'','','','','ezpublish',82,0),(124,1,0,0,'','','','','ezpublish',83,0),(125,1,0,0,'','','','','ezpublish',84,0),(126,1,0,0,'','','','','ezpublish',85,0),(127,1,0,0,'','','','','ezpublish',86,0),(128,1,0,0,'','','','','ezpublish',87,0),(129,1,0,0,'','','','','ezpublish',88,0),(130,1,0,0,'','','','','ezpublish',89,0),(131,1,0,0,'','','','','ezpublish',90,0),(132,1,0,0,'','','','','ezpublish',91,0),(133,1,0,0,'','','','','ezpublish',92,0),(134,1,0,0,'','','','','ezpublish',93,0),(135,1,0,0,'','','','','ezpublish',94,0),(136,1,0,0,'','','','','ezpublish',95,0),(137,1,0,0,'','','','','ezpublish',96,0),(138,1,0,0,'','','','','ezpublish',97,0),(139,1,0,0,'','','','','ezpublish',98,0),(140,1,0,0,'','','','','ezpublish',99,0),(141,1,0,0,'','','','','ezpublish',100,0),(142,1,0,0,'','','','','ezpublish',101,0),(143,1,0,0,'','','','','ezpublish',102,0),(144,1,0,0,'','','','','ezpublish',103,0),(143,2,0,0,'','','','','ezpublish',104,0),(143,3,0,0,'','','','','ezpublish',105,0),(144,2,0,0,'','','','','ezpublish',106,0),(145,2,0,0,'','','','','ezpublish',107,0),(146,1,0,0,'','','','','ezpublish',108,0),(147,1,0,0,'','','','','ezpublish',109,0),(148,1,0,0,'','','','','ezpublish',110,0),(149,1,0,0,'','','','','ezpublish',111,0),(150,1,0,0,'','','','','ezpublish',112,0),(151,1,0,0,'','','','','ezpublish',113,0),(152,1,0,0,'','','','','ezpublish',114,0),(153,1,0,0,'','','','','ezpublish',115,0),(154,1,0,0,'','','','','ezpublish',116,0),(155,1,0,0,'','','','','ezpublish',117,0),(156,1,0,0,'','','','','ezpublish',118,0),(157,1,0,0,'','','','','ezpublish',119,0),(158,1,0,0,'','','','','ezpublish',120,0),(159,1,0,0,'','','','','ezpublish',121,0),(160,1,0,0,'','','','','ezpublish',122,0),(161,1,0,0,'','','','','ezpublish',123,0),(162,1,0,0,'','','','','ezpublish',124,0),(163,1,0,0,'','','','','ezpublish',125,0),(164,1,0,0,'','','','','ezpublish',126,0),(165,1,0,0,'','','','','ezpublish',127,0),(166,1,0,0,'','','','','ezpublish',128,0),(167,1,0,0,'','','','','ezpublish',129,0),(168,1,0,0,'','','','','ezpublish',130,0),(169,1,0,0,'','','','','ezpublish',131,0),(170,1,0,0,'','','','','ezpublish',132,0),(171,1,0,0,'','','','','ezpublish',133,0),(172,1,0,0,'','','','','ezpublish',134,0),(143,4,0,0,'','','','','ezpublish',135,0),(144,3,0,0,'','','','','ezpublish',136,0),(145,3,0,0,'','','','','ezpublish',137,0),(146,2,0,0,'','','','','ezpublish',138,0),(147,2,0,0,'','','','','ezpublish',139,0),(148,2,0,0,'','','','','ezpublish',140,0),(149,2,0,0,'','','','','ezpublish',141,0),(150,2,0,0,'','','','','ezpublish',142,0),(151,2,0,0,'','','','','ezpublish',143,0),(152,2,0,0,'','','','','ezpublish',144,0),(153,2,0,0,'','','','','ezpublish',145,0),(154,2,0,0,'','','','','ezpublish',146,0),(155,2,0,0,'','','','','ezpublish',147,0),(156,2,0,0,'','','','','ezpublish',148,0),(157,2,0,0,'','','','','ezpublish',149,0),(158,2,0,0,'','','','','ezpublish',150,0),(159,2,0,0,'','','','','ezpublish',151,0),(160,2,0,0,'','','','','ezpublish',152,0),(161,2,0,0,'','','','','ezpublish',153,0),(162,2,0,0,'','','','','ezpublish',154,0),(163,2,0,0,'','','','','ezpublish',155,0),(164,2,0,0,'','','','','ezpublish',156,0),(165,2,0,0,'','','','','ezpublish',157,0),(166,2,0,0,'','','','','ezpublish',158,0),(167,2,0,0,'','','','','ezpublish',159,0),(168,2,0,0,'','','','','ezpublish',160,0),(169,2,0,0,'','','','','ezpublish',161,0),(170,2,0,0,'','','','','ezpublish',162,0),(171,2,0,0,'','','','','ezpublish',163,0),(172,2,0,0,'','','','','ezpublish',164,0),(173,1,0,0,'','','','','ezpublish',165,0),(174,1,0,0,'','','','','ezpublish',166,0),(175,1,0,0,'','','','','ezpublish',167,0),(176,1,0,0,'','','','','ezpublish',168,0),(177,1,0,0,'','','','','ezpublish',169,0),(178,1,0,0,'','','','','ezpublish',170,0),(179,1,0,0,'','','','','ezpublish',171,0),(180,1,0,0,'','','','','ezpublish',172,0),(181,1,0,0,'','','','','ezpublish',173,0),(182,1,0,0,'','','','','ezpublish',174,0),(143,5,0,0,'','','','','ezpublish',175,0),(144,4,0,0,'','','','','ezpublish',176,0),(145,4,0,0,'','','','','ezpublish',177,0),(146,3,0,0,'','','','','ezpublish',178,0),(147,3,0,0,'','','','','ezpublish',179,0),(148,3,0,0,'','','','','ezpublish',180,0),(149,3,0,0,'','','','','ezpublish',181,0),(150,3,0,0,'','','','','ezpublish',182,0),(151,3,0,0,'','','','','ezpublish',183,0),(152,3,0,0,'','','','','ezpublish',184,0),(153,3,0,0,'','','','','ezpublish',185,0),(154,3,0,0,'','','','','ezpublish',186,0),(155,3,0,0,'','','','','ezpublish',187,0),(156,3,0,0,'','','','','ezpublish',188,0),(157,3,0,0,'','','','','ezpublish',189,0),(158,3,0,0,'','','','','ezpublish',190,0),(159,3,0,0,'','','','','ezpublish',191,0),(160,3,0,0,'','','','','ezpublish',192,0),(161,3,0,0,'','','','','ezpublish',193,0),(162,3,0,0,'','','','','ezpublish',194,0),(163,3,0,0,'','','','','ezpublish',195,0),(164,3,0,0,'','','','','ezpublish',196,0),(165,3,0,0,'','','','','ezpublish',197,0),(166,3,0,0,'','','','','ezpublish',198,0),(167,3,0,0,'','','','','ezpublish',199,0),(168,3,0,0,'','','','','ezpublish',200,0),(169,3,0,0,'','','','','ezpublish',201,0),(170,3,0,0,'','','','','ezpublish',202,0),(171,3,0,0,'','','','','ezpublish',203,0),(172,3,0,0,'','','','','ezpublish',204,0),(173,2,0,0,'','','','','ezpublish',205,0),(174,2,0,0,'','','','','ezpublish',206,0),(175,2,0,0,'','','','','ezpublish',207,0),(176,2,0,0,'','','','','ezpublish',208,0),(177,2,0,0,'','','','','ezpublish',209,0),(178,2,0,0,'','','','','ezpublish',210,0),(179,2,0,0,'','','','','ezpublish',211,0),(180,2,0,0,'','','','','ezpublish',212,0),(181,2,0,0,'','','','','ezpublish',213,0),(182,2,0,0,'','','','','ezpublish',214,0),(184,1,0,0,'','','','','ezpublish',215,0),(185,1,0,0,'','','','','ezpublish',216,0),(186,1,0,0,'','','','','ezpublish',217,0),(187,1,0,0,'','','','','ezpublish',218,0),(188,1,0,0,'','','','','ezpublish',219,0),(189,1,0,0,'','','','','ezpublish',220,0),(190,1,0,0,'','','','','ezpublish',221,0),(191,1,0,0,'','','','','ezpublish',222,0),(192,1,0,0,'','','','','ezpublish',223,0),(193,1,0,0,'','','','','ezpublish',224,0),(194,1,0,0,'','','','','ezpublish',225,0),(195,1,0,0,'','','','','ezpublish',226,0),(196,1,0,0,'','','','','ezpublish',227,0),(197,1,0,0,'','','','','ezpublish',228,0),(198,1,0,0,'','','','','ezpublish',229,0),(199,1,0,0,'','','','','ezpublish',230,0),(200,1,0,0,'','','','','ezpublish',231,0),(201,1,0,0,'','','','','ezpublish',232,0),(202,1,0,0,'','','','','ezpublish',233,0),(203,1,0,0,'','','','','ezpublish',234,0),(204,1,0,0,'','','','','ezpublish',235,0),(205,1,0,0,'','','','','ezpublish',236,0),(206,1,0,0,'','','','','ezpublish',237,0),(207,1,0,0,'','','','','ezpublish',238,0),(208,1,0,0,'','','','','ezpublish',239,0),(209,1,0,0,'','','','','ezpublish',240,0),(210,1,0,0,'','','','','ezpublish',241,0),(211,1,0,0,'','','','','ezpublish',242,0),(212,1,0,0,'','','','','ezpublish',243,0),(213,1,0,0,'','','','','ezpublish',244,0),(214,1,0,0,'','','','','ezpublish',245,0),(215,1,0,0,'','','','','ezpublish',246,0),(216,1,0,0,'','','','','ezpublish',247,0),(217,1,0,0,'','','','','ezpublish',248,0),(218,1,0,0,'','','','','ezpublish',249,0),(219,1,0,0,'','','','','ezpublish',250,0),(220,1,0,0,'','','','','ezpublish',251,0),(221,1,0,0,'','','','','ezpublish',252,0),(222,1,0,0,'','','','','ezpublish',253,0),(223,1,0,0,'','','','','ezpublish',254,0),(184,2,0,0,'','','','','ezpublish',255,0),(185,2,0,0,'','','','','ezpublish',256,0),(186,2,0,0,'','','','','ezpublish',257,0),(187,2,0,0,'','','','','ezpublish',258,0),(188,2,0,0,'','','','','ezpublish',259,0),(189,2,0,0,'','','','','ezpublish',260,0),(190,2,0,0,'','','','','ezpublish',261,0),(191,2,0,0,'','','','','ezpublish',262,0),(192,2,0,0,'','','','','ezpublish',263,0),(193,2,0,0,'','','','','ezpublish',264,0),(194,2,0,0,'','','','','ezpublish',265,0),(195,2,0,0,'','','','','ezpublish',266,0),(196,2,0,0,'','','','','ezpublish',267,0),(197,2,0,0,'','','','','ezpublish',268,0),(198,2,0,0,'','','','','ezpublish',269,0),(199,2,0,0,'','','','','ezpublish',270,0),(200,2,0,0,'','','','','ezpublish',271,0),(201,2,0,0,'','','','','ezpublish',272,0),(202,2,0,0,'','','','','ezpublish',273,0),(203,2,0,0,'','','','','ezpublish',274,0),(204,2,0,0,'','','','','ezpublish',275,0),(205,2,0,0,'','','','','ezpublish',276,0),(206,2,0,0,'','','','','ezpublish',277,0),(207,2,0,0,'','','','','ezpublish',278,0),(208,2,0,0,'','','','','ezpublish',279,0),(209,2,0,0,'','','','','ezpublish',280,0),(210,2,0,0,'','','','','ezpublish',281,0),(211,2,0,0,'','','','','ezpublish',282,0),(212,2,0,0,'','','','','ezpublish',283,0),(213,2,0,0,'','','','','ezpublish',284,0),(214,2,0,0,'','','','','ezpublish',285,0),(215,2,0,0,'','','','','ezpublish',286,0),(216,2,0,0,'','','','','ezpublish',287,0),(217,2,0,0,'','','','','ezpublish',288,0),(218,2,0,0,'','','','','ezpublish',289,0),(219,2,0,0,'','','','','ezpublish',290,0),(220,2,0,0,'','','','','ezpublish',291,0),(221,2,0,0,'','','','','ezpublish',292,0),(222,2,0,0,'','','','','ezpublish',293,0),(223,2,0,0,'','','','','ezpublish',294,0),(64,1,0,0,'','','','','ezpublish',295,0),(65,1,0,0,'','','','','ezpublish',296,0),(66,1,0,0,'','','','','ezpublish',297,0),(67,1,0,0,'','','','','ezpublish',298,0),(68,1,0,0,'','','','','ezpublish',299,0),(69,1,0,0,'','','','','ezpublish',300,0),(70,1,0,0,'','','','','ezpublish',301,0),(71,1,0,0,'','','','','ezpublish',302,0),(72,1,0,0,'','','','','ezpublish',303,0),(73,1,0,0,'','','','','ezpublish',304,0),(74,1,0,0,'','','','','ezpublish',305,0),(75,1,0,0,'','','','','ezpublish',306,0),(76,1,0,0,'','','','','ezpublish',307,0),(77,1,0,0,'','','','','ezpublish',308,0),(78,1,0,0,'','','','','ezpublish',309,0),(79,1,0,0,'','','','','ezpublish',310,0),(81,1,0,0,'','','','','ezpublish',311,0),(82,1,0,0,'','','','','ezpublish',312,0),(83,1,0,0,'','','','','ezpublish',313,0),(84,1,0,0,'','','','','ezpublish',314,0),(85,1,0,0,'','','','','ezpublish',315,0),(86,1,0,0,'','','','','ezpublish',316,0),(87,1,0,0,'','','','','ezpublish',317,0),(88,1,0,0,'','','','','ezpublish',318,0),(89,1,0,0,'','','','','ezpublish',319,0),(90,1,0,0,'','','','','ezpublish',320,0),(91,1,0,0,'','','','','ezpublish',321,0),(92,1,0,0,'','','','','ezpublish',322,0),(93,1,0,0,'','','','','ezpublish',323,0),(94,1,0,0,'','','','','ezpublish',324,0),(95,1,0,0,'','','','','ezpublish',325,0),(96,1,0,0,'','','','','ezpublish',326,0),(97,1,0,0,'','','','','ezpublish',327,0),(98,1,0,0,'','','','','ezpublish',328,0),(99,1,0,0,'','','','','ezpublish',329,0),(100,1,0,0,'','','','','ezpublish',330,0),(101,1,0,0,'','','','','ezpublish',331,0),(102,1,0,0,'','','','','ezpublish',332,0),(103,1,0,0,'','','','','ezpublish',333,0),(104,1,0,0,'','','','','ezpublish',334,0),(105,1,0,0,'','','','','ezpublish',335,0),(106,1,0,0,'','','','','ezpublish',336,0),(107,1,0,0,'','','','','ezpublish',337,0),(108,1,0,0,'','','','','ezpublish',338,0),(109,1,0,0,'','','','','ezpublish',339,0),(110,1,0,0,'','','','','ezpublish',340,0),(111,1,0,0,'','','','','ezpublish',341,0),(112,1,0,0,'','','','','ezpublish',342,0),(82,2,0,0,'','','','','ezpublish',343,0),(83,2,0,0,'','','','','ezpublish',344,0),(84,2,0,0,'','','','','ezpublish',345,0),(85,2,0,0,'','','','','ezpublish',346,0),(86,2,0,0,'','','','','ezpublish',347,0),(87,2,0,0,'','','','','ezpublish',348,0),(88,2,0,0,'','','','','ezpublish',349,0),(89,2,0,0,'','','','','ezpublish',350,0),(82,3,0,0,'','','','','ezpublish',351,0),(83,3,0,0,'','','','','ezpublish',352,0),(84,3,0,0,'','','','','ezpublish',353,0),(85,3,0,0,'','','','','ezpublish',354,0),(86,3,0,0,'','','','','ezpublish',355,0),(87,3,0,0,'','','','','ezpublish',356,0),(88,3,0,0,'','','','','ezpublish',357,0),(89,3,0,0,'','','','','ezpublish',358,0),(82,4,0,0,'','','','','ezpublish',359,0),(83,4,0,0,'','','','','ezpublish',360,0),(84,4,0,0,'','','','','ezpublish',361,0),(85,4,0,0,'','','','','ezpublish',362,0),(86,4,0,0,'','','','','ezpublish',363,0),(87,4,0,0,'','','','','ezpublish',364,0),(88,4,0,0,'','','','','ezpublish',365,0),(89,4,0,0,'','','','','ezpublish',366,0),(82,5,0,0,'','','','','ezpublish',367,0),(83,5,0,0,'','','','','ezpublish',368,0),(84,5,0,0,'','','','','ezpublish',369,0),(85,5,0,0,'','','','','ezpublish',370,0),(86,5,0,0,'','','','','ezpublish',371,0),(87,5,0,0,'','','','','ezpublish',372,0),(88,5,0,0,'','','','','ezpublish',373,0),(89,5,0,0,'','','','','ezpublish',374,0),(82,6,0,0,'','','','','ezpublish',375,0),(83,6,0,0,'','','','','ezpublish',376,0),(84,6,0,0,'','','','','ezpublish',377,0),(85,6,0,0,'','','','','ezpublish',378,0),(86,6,0,0,'','','','','ezpublish',379,0),(87,6,0,0,'','','','','ezpublish',380,0),(88,6,0,0,'','','','','ezpublish',381,0),(89,6,0,0,'','','','','ezpublish',382,0),(82,7,0,0,'','','','','ezpublish',383,0),(83,7,0,0,'','','','','ezpublish',384,0),(84,7,0,0,'','','','','ezpublish',385,0),(85,7,0,0,'','','','','ezpublish',386,0),(86,7,0,0,'','','','','ezpublish',387,0),(87,7,0,0,'','','','','ezpublish',388,0),(88,7,0,0,'','','','','ezpublish',389,0),(89,7,0,0,'','','','','ezpublish',390,0),(113,1,0,0,'','','','','ezpublish',391,0),(114,1,0,0,'','','','','ezpublish',392,0),(115,1,0,0,'','','','','ezpublish',393,0),(116,1,0,0,'','','','','ezpublish',394,0),(117,1,0,0,'','','','','ezpublish',395,0),(118,1,0,0,'','','','','ezpublish',396,0),(119,1,0,0,'','','','','ezpublish',397,0),(120,1,0,0,'','','','','ezpublish',398,0),(121,1,0,0,'','','','','ezpublish',399,0),(122,1,0,0,'','','','','ezpublish',400,0),(123,1,0,0,'','','','','ezpublish',401,0),(124,1,0,0,'','','','','ezpublish',402,0),(125,1,0,0,'','','','','ezpublish',403,0),(126,1,0,0,'','','','','ezpublish',404,0),(127,1,0,0,'','','','','ezpublish',405,0),(128,1,0,0,'','','','','ezpublish',406,0),(129,1,0,0,'','','','','ezpublish',407,0),(130,1,0,0,'','','','','ezpublish',408,0),(131,1,0,0,'','','','','ezpublish',409,0),(132,1,0,0,'','','','','ezpublish',410,0),(133,1,0,0,'','','','','ezpublish',411,0),(134,1,0,0,'','','','','ezpublish',412,0),(135,1,0,0,'','','','','ezpublish',413,0),(136,1,0,0,'','','','','ezpublish',414,0),(137,1,0,0,'','','','','ezpublish',415,0),(138,1,0,0,'','','','','ezpublish',416,0),(139,1,0,0,'','','','','ezpublish',417,0),(140,1,0,0,'','','','','ezpublish',418,0),(141,1,0,0,'','','','','ezpublish',419,0),(142,1,0,0,'','','','','ezpublish',420,0),(143,1,0,0,'','','','','ezpublish',421,0),(144,1,0,0,'','','','','ezpublish',422,0),(114,2,0,0,'','','','','ezpublish',423,0),(115,2,0,0,'','','','','ezpublish',424,0),(116,2,0,0,'','','','','ezpublish',425,0),(117,2,0,0,'','','','','ezpublish',426,0),(118,2,0,0,'','','','','ezpublish',427,0),(119,2,0,0,'','','','','ezpublish',428,0),(120,2,0,0,'','','','','ezpublish',429,0),(121,2,0,0,'','','','','ezpublish',430,0),(114,3,0,0,'','','','','ezpublish',431,0),(115,3,0,0,'','','','','ezpublish',432,0),(116,3,0,0,'','','','','ezpublish',433,0),(117,3,0,0,'','','','','ezpublish',434,0),(118,3,0,0,'','','','','ezpublish',435,0),(119,3,0,0,'','','','','ezpublish',436,0),(120,3,0,0,'','','','','ezpublish',437,0),(121,3,0,0,'','','','','ezpublish',438,0),(114,4,0,0,'','','','','ezpublish',439,0),(115,4,0,0,'','','','','ezpublish',440,0),(116,4,0,0,'','','','','ezpublish',441,0),(117,4,0,0,'','','','','ezpublish',442,0),(118,4,0,0,'','','','','ezpublish',443,0),(119,4,0,0,'','','','','ezpublish',444,0),(120,4,0,0,'','','','','ezpublish',445,0),(121,4,0,0,'','','','','ezpublish',446,0),(114,5,0,0,'','','','','ezpublish',447,0),(115,5,0,0,'','','','','ezpublish',448,0),(116,5,0,0,'','','','','ezpublish',449,0),(117,5,0,0,'','','','','ezpublish',450,0),(118,5,0,0,'','','','','ezpublish',451,0),(119,5,0,0,'','','','','ezpublish',452,0),(120,5,0,0,'','','','','ezpublish',453,0),(121,5,0,0,'','','','','ezpublish',454,0),(114,6,0,0,'','','','','ezpublish',455,0),(115,6,0,0,'','','','','ezpublish',456,0),(116,6,0,0,'','','','','ezpublish',457,0),(117,6,0,0,'','','','','ezpublish',458,0),(118,6,0,0,'','','','','ezpublish',459,0),(119,6,0,0,'','','','','ezpublish',460,0),(120,6,0,0,'','','','','ezpublish',461,0),(121,6,0,0,'','','','','ezpublish',462,0),(114,7,0,0,'','','','','ezpublish',463,0),(115,7,0,0,'','','','','ezpublish',464,0),(116,7,0,0,'','','','','ezpublish',465,0),(117,7,0,0,'','','','','ezpublish',466,0),(118,7,0,0,'','','','','ezpublish',467,0),(119,7,0,0,'','','','','ezpublish',468,0),(120,7,0,0,'','','','','ezpublish',469,0),(121,7,0,0,'','','','','ezpublish',470,0),(114,8,0,0,'','','','','ezpublish',471,0),(115,8,0,0,'','','','','ezpublish',472,0),(116,8,0,0,'','','','','ezpublish',473,0),(117,8,0,0,'','','','','ezpublish',474,0),(118,8,0,0,'','','','','ezpublish',475,0),(119,8,0,0,'','','','','ezpublish',476,0),(120,8,0,0,'','','','','ezpublish',477,0),(121,8,0,0,'','','','','ezpublish',478,0),(123,1,0,0,'','','','','ezpublish',479,0),(61,1,0,0,'','','','','ezpublish',480,0),(60,9,0,0,'','','','','ezpublish',481,0),(59,10,0,0,'','','','','ezpublish',482,0),(63,1,0,0,'','','','','ezpublish',483,0),(64,1,0,0,'','','','','ezpublish',484,0),(65,1,0,0,'','','','','ezpublish',485,0),(66,1,0,0,'','','','','ezpublish',486,0),(67,1,0,0,'','','','','ezpublish',487,0),(68,1,0,0,'','','','','ezpublish',488,0),(69,1,0,0,'','','','','ezpublish',489,0),(70,1,0,0,'','','','','ezpublish',490,0),(71,1,0,0,'','','','','ezpublish',491,0),(72,1,0,0,'','','','','ezpublish',492,0),(73,1,0,0,'','','','','ezpublish',493,0),(74,1,0,0,'','','','','ezpublish',494,0),(75,1,0,0,'','','','','ezpublish',495,0),(76,1,0,0,'','','','','ezpublish',496,0),(77,1,0,0,'','','','','ezpublish',497,0),(78,1,0,0,'','','','','ezpublish',498,0),(79,1,0,0,'','','','','ezpublish',499,0),(80,1,0,0,'','','','','ezpublish',500,0),(81,1,0,0,'','','','','ezpublish',501,0),(82,1,0,0,'','','','','ezpublish',502,0),(83,1,0,0,'','','','','ezpublish',503,0),(84,1,0,0,'','','','','ezpublish',504,0),(85,1,0,0,'','','','','ezpublish',505,0),(86,1,0,0,'','','','','ezpublish',506,0),(87,1,0,0,'','','','','ezpublish',507,0),(88,1,0,0,'','','','','ezpublish',508,0),(89,1,0,0,'','','','','ezpublish',509,0),(90,1,0,0,'','','','','ezpublish',510,0),(91,1,0,0,'','','','','ezpublish',511,0),(92,1,0,0,'','','','','ezpublish',512,0),(93,1,0,0,'','','','','ezpublish',513,0),(94,1,0,0,'','','','','ezpublish',514,0),(95,1,0,0,'','','','','ezpublish',515,0),(96,1,0,0,'','','','','ezpublish',516,0),(97,1,0,0,'','','','','ezpublish',517,0),(98,1,0,0,'','','','','ezpublish',518,0),(99,1,0,0,'','','','','ezpublish',519,0),(100,1,0,0,'','','','','ezpublish',520,0),(101,1,0,0,'','','','','ezpublish',521,0),(102,1,0,0,'','','','','ezpublish',522,0),(103,1,0,0,'','','','','ezpublish',523,0),(104,1,0,0,'','','','','ezpublish',524,0),(105,1,0,0,'','','','','ezpublish',525,0),(106,1,0,0,'','','','','ezpublish',526,0),(107,1,0,0,'','','','','ezpublish',527,0),(108,1,0,0,'','','','','ezpublish',528,0),(109,1,0,0,'','','','','ezpublish',529,0),(110,1,0,0,'','','','','ezpublish',530,0),(111,1,0,0,'','','','','ezpublish',531,0),(112,1,0,0,'','','','','ezpublish',532,0),(113,1,0,0,'','','','','ezpublish',533,0),(114,1,0,0,'','','','','ezpublish',534,0),(115,1,0,0,'','','','','ezpublish',535,0),(116,1,0,0,'','','','','ezpublish',536,0),(117,1,0,0,'','','','','ezpublish',537,0),(118,1,0,0,'','','','','ezpublish',538,0),(119,1,0,0,'','','','','ezpublish',539,0),(120,1,0,0,'','','','','ezpublish',540,0),(121,1,0,0,'','','','','ezpublish',541,0),(122,1,0,0,'','','','','ezpublish',542,0),(123,1,0,0,'','','','','ezpublish',543,0),(124,1,0,0,'','','','','ezpublish',544,0),(125,1,0,0,'','','','','ezpublish',545,0),(126,1,0,0,'','','','','ezpublish',546,0),(127,1,0,0,'','','','','ezpublish',547,0),(128,1,0,0,'','','','','ezpublish',548,0),(129,1,0,0,'','','','','ezpublish',549,0),(130,1,0,0,'','','','','ezpublish',550,0),(131,1,0,0,'','','','','ezpublish',551,0),(132,1,0,0,'','','','','ezpublish',552,0),(133,1,0,0,'','','','','ezpublish',553,0),(134,1,0,0,'','','','','ezpublish',554,0),(135,1,0,0,'','','','','ezpublish',555,0),(136,1,0,0,'','','','','ezpublish',556,0),(137,1,0,0,'','','','','ezpublish',557,0),(138,1,0,0,'','','','','ezpublish',558,0),(139,1,0,0,'','','','','ezpublish',559,0),(140,1,0,0,'','','','','ezpublish',560,0),(141,1,0,0,'','','','','ezpublish',561,0),(141,2,0,0,'','','','','ezpublish',562,0),(142,1,0,0,'','','','','ezpublish',563,0),(143,1,0,0,'','','','','ezpublish',564,0),(144,1,0,0,'','','','','ezpublish',565,0),(145,1,0,0,'','','','','ezpublish',566,0),(146,1,0,0,'','','','','ezpublish',567,0),(147,1,0,0,'','','','','ezpublish',568,0),(148,1,0,0,'','','','','ezpublish',569,0),(149,1,0,0,'','','','','ezpublish',570,0),(150,1,0,0,'','','','','ezpublish',571,0),(151,1,0,0,'','','','','ezpublish',572,0),(152,1,0,0,'','','','','ezpublish',573,0),(153,1,0,0,'','','','','ezpublish',574,0),(154,1,0,0,'','','','','ezpublish',575,0),(155,1,0,0,'','','','','ezpublish',576,0),(156,1,0,0,'','','','','ezpublish',577,0),(157,1,0,0,'','','','','ezpublish',578,0),(158,1,0,0,'','','','','ezpublish',579,0),(159,1,0,0,'','','','','ezpublish',580,0),(160,1,0,0,'','','','','ezpublish',581,0),(161,1,0,0,'','','','','ezpublish',582,0),(162,1,0,0,'','','','','ezpublish',583,0),(163,1,0,0,'','','','','ezpublish',584,0),(164,1,0,0,'','','','','ezpublish',585,0),(165,1,0,0,'','','','','ezpublish',586,0),(166,1,0,0,'','','','','ezpublish',587,0),(167,1,0,0,'','','','','ezpublish',588,0),(168,1,0,0,'','','','','ezpublish',589,0),(169,1,0,0,'','','','','ezpublish',590,0),(170,1,0,0,'','','','','ezpublish',591,0),(171,1,0,0,'','','','','ezpublish',592,0),(172,1,0,0,'','','','','ezpublish',593,0),(173,1,0,0,'','','','','ezpublish',594,0),(174,1,0,0,'','','','','ezpublish',595,0),(175,1,0,0,'','','','','ezpublish',596,0),(176,1,0,0,'','','','','ezpublish',597,0),(177,1,0,0,'','','','','ezpublish',598,0),(178,1,0,0,'','','','','ezpublish',599,0),(179,1,0,0,'','','','','ezpublish',600,0),(180,1,0,0,'','','','','ezpublish',601,0),(181,1,0,0,'','','','','ezpublish',602,0),(182,1,0,0,'','','','','ezpublish',603,0),(183,1,0,0,'','','','','ezpublish',604,0),(185,1,0,0,'','','','','ezpublish',605,0),(186,1,0,0,'','','','','ezpublish',606,0),(187,1,0,0,'','','','','ezpublish',607,0),(188,1,0,0,'','','','','ezpublish',608,0),(189,1,0,0,'','','','','ezpublish',609,0),(190,1,0,0,'','','','','ezpublish',610,0),(191,1,0,0,'','','','','ezpublish',611,0),(192,1,0,0,'','','','','ezpublish',612,0),(193,1,0,0,'','','','','ezpublish',613,0),(194,1,0,0,'','','','','ezpublish',614,0),(195,1,0,0,'','','','','ezpublish',615,0),(196,1,0,0,'','','','','ezpublish',616,0),(197,1,0,0,'','','','','ezpublish',617,0),(198,1,0,0,'','','','','ezpublish',618,0),(199,1,0,0,'','','','','ezpublish',619,0),(200,1,0,0,'','','','','ezpublish',620,0),(201,1,0,0,'','','','','ezpublish',621,0),(202,1,0,0,'','','','','ezpublish',622,0),(203,1,0,0,'','','','','ezpublish',623,0),(204,1,0,0,'','','','','ezpublish',624,0),(205,1,0,0,'','','','','ezpublish',625,0),(206,1,0,0,'','','','','ezpublish',626,0),(207,1,0,0,'','','','','ezpublish',627,0),(208,1,0,0,'','','','','ezpublish',628,0),(209,1,0,0,'','','','','ezpublish',629,0),(210,1,0,0,'','','','','ezpublish',630,0),(211,1,0,0,'','','','','ezpublish',631,0),(212,1,0,0,'','','','','ezpublish',632,0),(213,1,0,0,'','','','','ezpublish',633,0),(214,1,0,0,'','','','','ezpublish',634,0),(215,1,0,0,'','','','','ezpublish',635,0),(216,1,0,0,'','','','','ezpublish',636,0),(217,1,0,0,'','','','','ezpublish',637,0),(218,1,0,0,'','','','','ezpublish',638,0),(219,1,0,0,'','','','','ezpublish',639,0),(220,1,0,0,'','','','','ezpublish',640,0),(221,1,0,0,'','','','','ezpublish',641,0),(222,1,0,0,'','','','','ezpublish',642,0),(59,11,0,0,'','','','','ezpublish',643,0),(223,1,0,0,'','','','','ezpublish',644,0),(224,1,0,0,'','','','','ezpublish',645,0),(225,1,0,0,'','','','','ezpublish',646,0),(226,1,0,0,'','','','','ezpublish',647,0),(227,1,0,0,'','','','','ezpublish',648,0),(228,1,0,0,'','','','','ezpublish',649,0),(229,1,0,0,'','','','','ezpublish',650,0),(230,1,0,0,'','','','','ezpublish',651,0),(231,1,0,0,'','','','','ezpublish',652,0),(232,1,0,0,'','','','','ezpublish',653,0),(233,1,0,0,'','','','','ezpublish',654,0),(234,1,0,0,'','','','','ezpublish',655,0),(235,1,0,0,'','','','','ezpublish',656,0),(236,1,0,0,'','','','','ezpublish',657,0),(237,1,0,0,'','','','','ezpublish',658,0),(238,1,0,0,'','','','','ezpublish',659,0),(239,1,0,0,'','','','','ezpublish',660,0),(240,1,0,0,'','','','','ezpublish',661,0),(241,1,0,0,'','','','','ezpublish',662,0),(242,1,0,0,'','','','','ezpublish',663,0),(243,1,0,0,'','','','','ezpublish',664,0),(244,1,0,0,'','','','','ezpublish',665,0),(245,1,0,0,'','','','','ezpublish',666,0),(246,1,0,0,'','','','','ezpublish',667,0),(247,1,0,0,'','','','','ezpublish',668,0),(248,1,0,0,'','','','','ezpublish',669,0),(249,1,0,0,'','','','','ezpublish',670,0),(250,1,0,0,'','','','','ezpublish',671,0),(251,1,0,0,'','','','','ezpublish',672,0),(252,1,0,0,'','','','','ezpublish',673,0),(253,1,0,0,'','','','','ezpublish',674,0),(254,1,0,0,'','','','','ezpublish',675,0),(255,1,0,0,'','','','','ezpublish',676,0),(256,1,0,0,'','','','','ezpublish',677,0),(257,1,0,0,'','','','','ezpublish',678,0),(258,1,0,0,'','','','','ezpublish',679,0),(259,1,0,0,'','','','','ezpublish',680,0),(260,1,0,0,'','','','','ezpublish',681,0),(261,1,0,0,'','','','','ezpublish',682,0),(262,1,0,0,'','','','','ezpublish',683,0),(263,1,0,0,'','','','','ezpublish',684,0),(264,1,0,0,'','','','','ezpublish',685,0),(265,1,0,0,'','','','','ezpublish',686,0),(266,1,0,0,'','','','','ezpublish',687,0),(267,1,0,0,'','','','','ezpublish',688,0),(268,1,0,0,'','','','','ezpublish',689,0),(269,1,0,0,'','','','','ezpublish',690,0),(270,1,0,0,'','','','','ezpublish',691,0),(271,1,0,0,'','','','','ezpublish',692,0),(272,1,0,0,'','','','','ezpublish',693,0),(273,1,0,0,'','','','','ezpublish',694,0),(274,1,0,0,'','','','','ezpublish',695,0),(275,1,0,0,'','','','','ezpublish',696,0),(276,1,0,0,'','','','','ezpublish',697,0),(277,1,0,0,'','','','','ezpublish',698,0),(278,1,0,0,'','','','','ezpublish',699,0),(279,1,0,0,'','','','','ezpublish',700,0),(280,1,0,0,'','','','','ezpublish',701,0),(281,1,0,0,'','','','','ezpublish',702,0),(282,1,0,0,'','','','','ezpublish',703,0),(283,1,0,0,'','','','','ezpublish',704,0),(284,1,0,0,'','','','','ezpublish',705,0),(285,1,0,0,'','','','','ezpublish',706,0),(286,1,0,0,'','','','','ezpublish',707,0),(287,1,0,0,'','','','','ezpublish',708,0),(288,1,0,0,'','','','','ezpublish',709,0),(289,1,0,0,'','','','','ezpublish',710,0),(290,1,0,0,'','','','','ezpublish',711,0),(291,1,0,0,'','','','','ezpublish',712,0),(292,1,0,0,'','','','','ezpublish',713,0),(293,1,0,0,'','','','','ezpublish',714,0),(294,1,0,0,'','','','','ezpublish',715,0),(295,1,0,0,'','','','','ezpublish',716,0),(296,1,0,0,'','','','','ezpublish',717,0),(297,1,0,0,'','','','','ezpublish',718,0),(298,1,0,0,'','','','','ezpublish',719,0),(221,2,0,0,'','','','','ezpublish',720,0),(221,3,0,0,'','','','','ezpublish',721,0),(221,4,0,0,'','','','','ezpublish',722,0),(221,5,0,0,'','','','','ezpublish',723,0),(222,2,0,0,'','','','','ezpublish',724,0),(185,2,0,0,'','','','','ezpublish',725,0),(185,3,0,0,'','','','','ezpublish',726,0),(188,2,0,0,'','','','','ezpublish',727,0),(196,2,0,0,'','','','','ezpublish',728,0),(213,2,0,0,'','','','','ezpublish',729,0),(223,2,0,0,'','','','','ezpublish',730,0),(59,12,0,0,'','','','','ezpublish',731,0),(60,10,0,0,'','','','','ezpublish',732,0),(61,2,0,0,'','','','','ezpublish',733,0),(234,2,0,0,'','','','','ezpublish',734,0),(235,2,0,0,'','','','','ezpublish',735,0),(236,2,0,0,'','','','','ezpublish',736,0),(237,2,0,0,'','','','','ezpublish',737,0),(299,1,0,0,'','','','','ezpublish',738,0),(300,1,0,0,'','','','','ezpublish',739,0),(301,1,0,0,'','','','','ezpublish',740,0),(302,1,0,0,'','','','','ezpublish',741,0),(303,1,0,0,'','','','','ezpublish',742,0),(304,1,0,0,'','','','','ezpublish',743,0),(305,1,0,0,'','','','','ezpublish',744,0),(306,1,0,0,'','','','','ezpublish',745,0),(307,1,0,0,'','','','','ezpublish',746,0),(308,1,0,0,'','','','','ezpublish',747,0),(309,1,0,0,'','','','','ezpublish',748,0),(310,1,0,0,'','','','','ezpublish',749,0),(311,1,0,0,'','','','','ezpublish',750,0),(312,1,0,0,'','','','','ezpublish',751,0),(313,1,0,0,'','','','','ezpublish',752,0),(314,1,0,0,'','','','','ezpublish',753,0),(315,1,0,0,'','','','','ezpublish',754,0),(316,1,0,0,'','','','','ezpublish',755,0),(317,1,0,0,'','','','','ezpublish',756,0),(318,1,0,0,'','','','','ezpublish',757,0),(319,1,0,0,'','','','','ezpublish',758,0),(320,1,0,0,'','','','','ezpublish',759,0),(321,1,0,0,'','','','','ezpublish',760,0),(322,1,0,0,'','','','','ezpublish',761,0),(323,1,0,0,'','','','','ezpublish',762,0),(324,1,0,0,'','','','','ezpublish',763,0),(325,1,0,0,'','','','','ezpublish',764,0),(326,1,0,0,'','','','','ezpublish',765,0),(327,1,0,0,'','','','','ezpublish',766,0),(328,1,0,0,'','','','','ezpublish',767,0),(329,1,0,0,'','','','','ezpublish',768,0),(330,1,0,0,'','','','','ezpublish',769,0),(331,1,0,0,'','','','','ezpublish',770,0),(332,1,0,0,'','','','','ezpublish',771,0),(333,1,0,0,'','','','','ezpublish',772,0),(334,1,0,0,'','','','','ezpublish',773,0),(335,1,0,0,'','','','','ezpublish',774,0),(336,1,0,0,'','','','','ezpublish',775,0),(337,1,0,0,'','','','','ezpublish',776,0),(338,1,0,0,'','','','','ezpublish',777,0),(339,1,0,0,'','','','','ezpublish',778,0),(340,1,0,0,'','','','','ezpublish',779,0),(341,1,0,0,'','','','','ezpublish',780,0),(342,1,0,0,'','','','','ezpublish',781,0),(343,1,0,0,'','','','','ezpublish',782,0),(344,1,0,0,'','','','','ezpublish',783,0),(345,1,0,0,'','','','','ezpublish',784,0),(346,1,0,0,'','','','','ezpublish',785,0),(347,1,0,0,'','','','','ezpublish',786,0),(348,1,0,0,'','','','','ezpublish',787,0),(349,1,0,0,'','','','','ezpublish',788,0),(350,1,0,0,'','','','','ezpublish',789,0),(351,1,0,0,'','','','','ezpublish',790,0),(352,1,0,0,'','','','','ezpublish',791,0),(353,1,0,0,'','','','','ezpublish',792,0),(354,1,0,0,'','','','','ezpublish',793,0),(355,1,0,0,'','','','','ezpublish',794,0),(356,1,0,0,'','','','','ezpublish',795,0),(357,1,0,0,'','','','','ezpublish',796,0),(358,1,0,0,'','','','','ezpublish',797,0),(359,1,0,0,'','','','','ezpublish',798,0),(360,1,0,0,'','','','','ezpublish',799,0),(361,1,0,0,'','','','','ezpublish',800,0),(362,1,0,0,'','','','','ezpublish',801,0),(363,1,0,0,'','','','','ezpublish',802,0),(364,1,0,0,'','','','','ezpublish',803,0),(365,1,0,0,'','','','','ezpublish',804,0),(366,1,0,0,'','','','','ezpublish',805,0),(367,1,0,0,'','','','','ezpublish',806,0),(368,1,0,0,'','','','','ezpublish',807,0),(369,1,0,0,'','','','','ezpublish',808,0),(370,1,0,0,'','','','','ezpublish',809,0),(371,1,0,0,'','','','','ezpublish',810,0),(372,1,0,0,'','','','','ezpublish',811,0),(373,1,0,0,'','','','','ezpublish',812,0),(374,1,0,0,'','','','','ezpublish',813,0),(375,1,0,0,'','','','','ezpublish',814,0),(376,1,0,0,'','','','','ezpublish',815,0),(377,1,0,0,'','','','','ezpublish',816,0),(378,1,0,0,'','','','','ezpublish',817,0),(379,1,0,0,'','','','','ezpublish',818,0),(380,1,0,0,'','','','','ezpublish',819,0),(381,1,0,0,'','','','','ezpublish',820,0),(382,1,0,0,'','','','','ezpublish',821,0),(383,1,0,0,'','','','','ezpublish',822,0),(384,1,0,0,'','','','','ezpublish',823,0),(385,1,0,0,'','','','','ezpublish',824,0),(386,1,0,0,'','','','','ezpublish',825,0),(387,1,0,0,'','','','','ezpublish',826,0),(388,1,0,0,'','','','','ezpublish',827,0),(389,1,0,0,'','','','','ezpublish',828,0),(390,1,0,0,'','','','','ezpublish',829,0),(391,1,0,0,'','','','','ezpublish',830,0),(392,1,0,0,'','','','','ezpublish',831,0),(393,1,0,0,'','','','','ezpublish',832,0),(394,1,0,0,'','','','','ezpublish',833,0),(395,1,0,0,'','','','','ezpublish',834,0),(396,1,0,0,'','','','','ezpublish',835,0),(397,1,0,0,'','','','','ezpublish',836,0),(398,1,0,0,'','','','','ezpublish',837,0),(399,1,0,0,'','','','','ezpublish',838,0),(400,1,0,0,'','','','','ezpublish',839,0),(401,1,0,0,'','','','','ezpublish',840,0),(402,1,0,0,'','','','','ezpublish',841,0),(403,1,0,0,'','','','','ezpublish',842,0),(404,1,0,0,'','','','','ezpublish',843,0),(405,1,0,0,'','','','','ezpublish',844,0),(406,1,0,0,'','','','','ezpublish',845,0),(407,1,0,0,'','','','','ezpublish',846,0),(408,1,0,0,'','','','','ezpublish',847,0),(409,1,0,0,'','','','','ezpublish',848,0),(410,1,0,0,'','','','','ezpublish',849,0),(411,1,0,0,'','','','','ezpublish',850,0),(412,1,0,0,'','','','','ezpublish',851,0),(413,1,0,0,'','','','','ezpublish',852,0),(414,1,0,0,'','','','','ezpublish',853,0),(415,1,0,0,'','','','','ezpublish',854,0),(416,1,0,0,'','','','','ezpublish',855,0),(417,1,0,0,'','','','','ezpublish',856,0),(418,1,0,0,'','','','','ezpublish',857,0),(419,1,0,0,'','','','','ezpublish',858,0),(420,1,0,0,'','','','','ezpublish',859,0),(421,1,0,0,'','','','','ezpublish',860,0),(422,1,0,0,'','','','','ezpublish',861,0),(423,1,0,0,'','','','','ezpublish',862,0),(424,1,0,0,'','','','','ezpublish',863,0),(425,1,0,0,'','','','','ezpublish',864,0),(426,1,0,0,'','','','','ezpublish',865,0),(427,1,0,0,'','','','','ezpublish',866,0),(428,1,0,0,'','','','','ezpublish',867,0),(429,1,0,0,'','','','','ezpublish',868,0),(430,1,0,0,'','','','','ezpublish',869,0),(431,1,0,0,'','','','','ezpublish',870,0),(432,1,0,0,'','','','','ezpublish',871,0),(433,1,0,0,'','','','','ezpublish',872,0),(434,1,0,0,'','','','','ezpublish',873,0),(435,1,0,0,'','','','','ezpublish',874,0),(436,1,0,0,'','','','','ezpublish',875,0),(437,1,0,0,'','','','','ezpublish',876,0),(438,1,0,0,'','','','','ezpublish',877,0),(439,1,0,0,'','','','','ezpublish',878,0),(401,1,0,0,'','','','','ezpublish',879,0),(402,1,0,0,'','','','','ezpublish',880,0),(402,2,0,0,'','','','','ezpublish',881,0),(59,13,0,0,'','','','','ezpublish',882,0),(59,14,0,0,'','','','','ezpublish',883,0),(59,15,0,0,'','','','','ezpublish',884,0),(359,1,0,0,'','','','','ezpublish',885,0),(221,6,0,0,'','','','','ezpublish',886,0),(440,1,0,0,'','','','','ezpublish',887,0),(441,1,0,0,'','','','','ezpublish',888,0),(359,2,0,0,'','','','','ezpublish',889,0),(442,1,0,0,'','','','','ezpublish',890,0),(402,3,0,0,'','','','','ezpublish',891,0),(359,3,0,0,'','','','','ezpublish',892,0),(402,4,0,0,'','','','','ezpublish',893,0),(221,7,0,0,'','','','','ezpublish',894,0),(443,1,0,0,'','','','','ezpublish',895,0),(444,1,0,0,'','','','','ezpublish',896,0),(445,1,0,0,'','','','','ezpublish',897,0),(446,1,0,0,'','','','','ezpublish',898,0),(359,4,0,0,'','','','','ezpublish',899,0),(447,1,0,0,'','','','','ezpublish',900,0),(448,1,0,0,'','','','','ezpublish',901,0),(449,1,0,0,'','','','','ezpublish',902,0),(450,1,0,0,'','','','','ezpublish',903,0),(451,1,0,0,'','','','','ezpublish',904,0),(452,1,0,0,'','','','','ezpublish',905,0),(453,1,0,0,'','','','','ezpublish',906,0),(454,1,0,0,'','','','','ezpublish',907,0),(455,1,0,0,'','','','','ezpublish',908,0),(456,1,0,0,'','','','','ezpublish',909,0),(59,16,0,0,'','','','','ezpublish',910,0),(359,5,0,0,'','','','','ezpublish',911,0),(457,1,0,0,'','','','','ezpublish',912,0),(458,1,0,0,'','','','','ezpublish',913,0),(459,1,0,0,'','','','','ezpublish',914,0),(460,1,0,0,'','','','','ezpublish',915,0),(461,1,0,0,'','','','','ezpublish',916,0),(462,1,0,0,'','','','','ezpublish',917,0),(463,1,0,0,'','','','','ezpublish',918,0),(464,1,0,0,'','','','','ezpublish',919,0),(465,1,0,0,'','','','','ezpublish',920,0),(466,1,0,0,'','','','','ezpublish',921,0),(467,1,0,0,'','','','','ezpublish',922,0),(359,6,0,0,'','','','','ezpublish',923,0),(468,1,0,0,'','','','','ezpublish',924,0),(469,1,0,0,'','','','','ezpublish',925,0),(470,1,0,0,'','','','','ezpublish',926,0),(471,1,0,0,'','','','','ezpublish',927,0),(472,1,0,0,'','','','','ezpublish',928,0),(473,1,0,0,'','','','','ezpublish',929,0),(474,1,0,0,'','','','','ezpublish',930,0),(475,1,0,0,'','','','','ezpublish',931,0),(476,1,0,0,'','','','','ezpublish',932,0),(477,1,0,0,'','','','','ezpublish',933,0),(478,1,0,0,'','','','','ezpublish',934,0),(479,1,0,0,'','','','','ezpublish',935,0),(480,1,0,0,'','','','','ezpublish',936,0),(359,7,0,0,'','','','','ezpublish',937,0),(14,3,0,0,'','','','','ezpublish',938,0);
/*!40000 ALTER TABLE `eznotificationevent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezoperation_memento`
--

DROP TABLE IF EXISTS `ezoperation_memento`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezoperation_memento` (
  `id` int(11) NOT NULL auto_increment,
  `main` int(11) NOT NULL default '0',
  `main_key` varchar(32) NOT NULL default '',
  `memento_data` longtext NOT NULL,
  `memento_key` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`,`memento_key`),
  KEY `ezoperation_memento_memento_key_main` (`memento_key`,`main`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezoperation_memento`
--

LOCK TABLES `ezoperation_memento` WRITE;
/*!40000 ALTER TABLE `ezoperation_memento` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezoperation_memento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezorder`
--

DROP TABLE IF EXISTS `ezorder`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezorder` (
  `account_identifier` varchar(100) NOT NULL default 'default',
  `created` int(11) NOT NULL default '0',
  `data_text_1` longtext,
  `data_text_2` longtext,
  `email` varchar(150) default '',
  `id` int(11) NOT NULL auto_increment,
  `ignore_vat` int(11) NOT NULL default '0',
  `is_archived` int(11) NOT NULL default '0',
  `is_temporary` int(11) NOT NULL default '1',
  `order_nr` int(11) NOT NULL default '0',
  `productcollection_id` int(11) NOT NULL default '0',
  `status_id` int(11) default '0',
  `status_modified` int(11) default '0',
  `status_modifier_id` int(11) default '0',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ezorder_is_archived` (`is_archived`),
  KEY `ezorder_is_tmp` (`is_temporary`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezorder`
--

LOCK TABLES `ezorder` WRITE;
/*!40000 ALTER TABLE `ezorder` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezorder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezorder_item`
--

DROP TABLE IF EXISTS `ezorder_item`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezorder_item` (
  `description` varchar(255) default NULL,
  `id` int(11) NOT NULL auto_increment,
  `is_vat_inc` int(11) NOT NULL default '0',
  `order_id` int(11) NOT NULL default '0',
  `price` float default NULL,
  `type` varchar(30) default NULL,
  `vat_value` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ezorder_item_order_id` (`order_id`),
  KEY `ezorder_item_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezorder_item`
--

LOCK TABLES `ezorder_item` WRITE;
/*!40000 ALTER TABLE `ezorder_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezorder_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezorder_status`
--

DROP TABLE IF EXISTS `ezorder_status`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezorder_status` (
  `id` int(11) NOT NULL auto_increment,
  `is_active` int(11) NOT NULL default '1',
  `name` varchar(255) NOT NULL default '',
  `status_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ezorder_status_active` (`is_active`),
  KEY `ezorder_status_name` (`name`),
  KEY `ezorder_status_sid` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezorder_status`
--

LOCK TABLES `ezorder_status` WRITE;
/*!40000 ALTER TABLE `ezorder_status` DISABLE KEYS */;
INSERT INTO `ezorder_status` VALUES (1,1,'Pending',1),(2,1,'Processing',2),(3,1,'Delivered',3);
/*!40000 ALTER TABLE `ezorder_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezorder_status_history`
--

DROP TABLE IF EXISTS `ezorder_status_history`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezorder_status_history` (
  `id` int(11) NOT NULL auto_increment,
  `modified` int(11) NOT NULL default '0',
  `modifier_id` int(11) NOT NULL default '0',
  `order_id` int(11) NOT NULL default '0',
  `status_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ezorder_status_history_mod` (`modified`),
  KEY `ezorder_status_history_oid` (`order_id`),
  KEY `ezorder_status_history_sid` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezorder_status_history`
--

LOCK TABLES `ezorder_status_history` WRITE;
/*!40000 ALTER TABLE `ezorder_status_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezorder_status_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezpackage`
--

DROP TABLE IF EXISTS `ezpackage`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezpackage` (
  `id` int(11) NOT NULL auto_increment,
  `install_date` int(11) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `version` varchar(30) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezpackage`
--

LOCK TABLES `ezpackage` WRITE;
/*!40000 ALTER TABLE `ezpackage` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezpackage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezpaymentobject`
--

DROP TABLE IF EXISTS `ezpaymentobject`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezpaymentobject` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) NOT NULL default '0',
  `payment_string` varchar(255) NOT NULL default '',
  `status` int(11) NOT NULL default '0',
  `workflowprocess_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezpaymentobject`
--

LOCK TABLES `ezpaymentobject` WRITE;
/*!40000 ALTER TABLE `ezpaymentobject` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezpaymentobject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezpdf_export`
--

DROP TABLE IF EXISTS `ezpdf_export`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezpdf_export` (
  `created` int(11) default NULL,
  `creator_id` int(11) default NULL,
  `export_classes` varchar(255) default NULL,
  `export_structure` varchar(255) default NULL,
  `id` int(11) NOT NULL auto_increment,
  `intro_text` longtext,
  `modified` int(11) default NULL,
  `modifier_id` int(11) default NULL,
  `pdf_filename` varchar(255) default NULL,
  `show_frontpage` int(11) default NULL,
  `site_access` varchar(255) default NULL,
  `source_node_id` int(11) default NULL,
  `status` int(11) default NULL,
  `sub_text` longtext,
  `title` varchar(255) default NULL,
  `version` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezpdf_export`
--

LOCK TABLES `ezpdf_export` WRITE;
/*!40000 ALTER TABLE `ezpdf_export` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezpdf_export` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezpending_actions`
--

DROP TABLE IF EXISTS `ezpending_actions`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezpending_actions` (
  `action` varchar(64) NOT NULL default '',
  `param` longtext,
  KEY `ezpending_actions_action` (`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezpending_actions`
--

LOCK TABLES `ezpending_actions` WRITE;
/*!40000 ALTER TABLE `ezpending_actions` DISABLE KEYS */;
INSERT INTO `ezpending_actions` VALUES ('static_store','static/index.html,http://www.planet-ezpublish.fr/'),('static_store','static/(offset)/10/index.html,http://www.planet-ezpublish.fr/(offset)/10'),('static_store','static/(offset)/20/index.html,http://www.planet-ezpublish.fr/(offset)/20'),('static_store','static/(offset)/30/index.html,http://www.planet-ezpublish.fr/(offset)/30'),('static_store','static/(offset)/40/index.html,http://www.planet-ezpublish.fr/(offset)/40'),('static_store','static/(offset)/50/index.html,http://www.planet-ezpublish.fr/(offset)/50'),('static_store','static/blogs/index.html,http://www.planet-ezpublish.fr/blogs'),('static_store','static/planetarium/index.html,http://www.planet-ezpublish.fr/planetarium'),('static_store','static/contact/index.html,http://www.planet-ezpublish.fr/contact'),('static_store','static/contact/(send)/1/index.html,http://www.planet-ezpublish.fr/contact/(send)/1'),('static_store','static/a-propos/index.html,http://www.planet-ezpublish.fr/a-propos'),('static_store','static/index.html,http://www.planet-ezpublish.fr/'),('static_store','static/(offset)/10/index.html,http://www.planet-ezpublish.fr/(offset)/10'),('static_store','static/(offset)/20/index.html,http://www.planet-ezpublish.fr/(offset)/20'),('static_store','static/(offset)/30/index.html,http://www.planet-ezpublish.fr/(offset)/30'),('static_store','static/(offset)/40/index.html,http://www.planet-ezpublish.fr/(offset)/40'),('static_store','static/(offset)/50/index.html,http://www.planet-ezpublish.fr/(offset)/50'),('static_store','static/blogs/index.html,http://www.planet-ezpublish.fr/blogs'),('static_store','static/planetarium/index.html,http://www.planet-ezpublish.fr/planetarium'),('static_store','static/contact/index.html,http://www.planet-ezpublish.fr/contact'),('static_store','static/contact/(send)/1/index.html,http://www.planet-ezpublish.fr/contact/(send)/1'),('static_store','static/a-propos/index.html,http://www.planet-ezpublish.fr/a-propos'),('static_store','static/index.html,http://www.planet-ezpublish.fr/'),('static_store','static/(offset)/10/index.html,http://www.planet-ezpublish.fr/(offset)/10'),('static_store','static/(offset)/20/index.html,http://www.planet-ezpublish.fr/(offset)/20'),('static_store','static/(offset)/30/index.html,http://www.planet-ezpublish.fr/(offset)/30'),('static_store','static/(offset)/40/index.html,http://www.planet-ezpublish.fr/(offset)/40'),('static_store','static/(offset)/50/index.html,http://www.planet-ezpublish.fr/(offset)/50'),('static_store','static/blogs/index.html,http://www.planet-ezpublish.fr/blogs'),('static_store','static/planetarium/index.html,http://www.planet-ezpublish.fr/planetarium'),('static_store','static/contact/index.html,http://www.planet-ezpublish.fr/contact'),('static_store','static/contact/(send)/1/index.html,http://www.planet-ezpublish.fr/contact/(send)/1'),('static_store','static/a-propos/index.html,http://www.planet-ezpublish.fr/a-propos');
/*!40000 ALTER TABLE `ezpending_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezpolicy`
--

DROP TABLE IF EXISTS `ezpolicy`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezpolicy` (
  `function_name` varchar(255) default NULL,
  `id` int(11) NOT NULL auto_increment,
  `module_name` varchar(255) default NULL,
  `role_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=335 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezpolicy`
--

LOCK TABLES `ezpolicy` WRITE;
/*!40000 ALTER TABLE `ezpolicy` DISABLE KEYS */;
INSERT INTO `ezpolicy` VALUES ('*',308,'*',2),('*',317,'content',3),('login',319,'user',3),('*',330,'ezdhtml',3),('read',332,'content',1),('pdf',333,'content',1),('login',334,'user',1);
/*!40000 ALTER TABLE `ezpolicy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezpolicy_limitation`
--

DROP TABLE IF EXISTS `ezpolicy_limitation`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezpolicy_limitation` (
  `id` int(11) NOT NULL auto_increment,
  `identifier` varchar(255) NOT NULL default '',
  `policy_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=258 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezpolicy_limitation`
--

LOCK TABLES `ezpolicy_limitation` WRITE;
/*!40000 ALTER TABLE `ezpolicy_limitation` DISABLE KEYS */;
INSERT INTO `ezpolicy_limitation` VALUES (254,'Section',332),(255,'Section',333),(257,'SiteAccess',334);
/*!40000 ALTER TABLE `ezpolicy_limitation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezpolicy_limitation_value`
--

DROP TABLE IF EXISTS `ezpolicy_limitation_value`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezpolicy_limitation_value` (
  `id` int(11) NOT NULL auto_increment,
  `limitation_id` int(11) default NULL,
  `value` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `ezpolicy_limitation_value_val` (`value`)
) ENGINE=InnoDB AUTO_INCREMENT=484 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezpolicy_limitation_value`
--

LOCK TABLES `ezpolicy_limitation_value` WRITE;
/*!40000 ALTER TABLE `ezpolicy_limitation_value` DISABLE KEYS */;
INSERT INTO `ezpolicy_limitation_value` VALUES (480,254,'1'),(481,255,'1'),(483,257,'1225670231');
/*!40000 ALTER TABLE `ezpolicy_limitation_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezpreferences`
--

DROP TABLE IF EXISTS `ezpreferences`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezpreferences` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `user_id` int(11) NOT NULL default '0',
  `value` varchar(100) default NULL,
  PRIMARY KEY  (`id`),
  KEY `ezpreferences_name` (`name`),
  KEY `ezpreferences_user_id_idx` (`user_id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezpreferences`
--

LOCK TABLES `ezpreferences` WRITE;
/*!40000 ALTER TABLE `ezpreferences` DISABLE KEYS */;
INSERT INTO `ezpreferences` VALUES (1,'admin_navigation_content',14,'1'),(2,'admin_navigation_roles',14,'1'),(3,'admin_navigation_policies',14,'1'),(4,'admin_list_limit',14,'1'),(5,'admin_treemenu',14,'1'),(6,'admin_bookmark_menu',14,'1'),(7,'admin_navigation_class_groups',14,'1'),(8,'admin_children_viewmode',14,'list'),(9,'admin_clearcache_menu',14,'1'),(10,'admin_clearcache_type',14,'ContentNode'),(11,'admin_classlists_limit',14,'3');
/*!40000 ALTER TABLE `ezpreferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezproductcategory`
--

DROP TABLE IF EXISTS `ezproductcategory`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezproductcategory` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezproductcategory`
--

LOCK TABLES `ezproductcategory` WRITE;
/*!40000 ALTER TABLE `ezproductcategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezproductcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezproductcollection`
--

DROP TABLE IF EXISTS `ezproductcollection`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezproductcollection` (
  `created` int(11) default NULL,
  `currency_code` varchar(4) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezproductcollection`
--

LOCK TABLES `ezproductcollection` WRITE;
/*!40000 ALTER TABLE `ezproductcollection` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezproductcollection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezproductcollection_item`
--

DROP TABLE IF EXISTS `ezproductcollection_item`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezproductcollection_item` (
  `contentobject_id` int(11) NOT NULL default '0',
  `discount` float default NULL,
  `id` int(11) NOT NULL auto_increment,
  `is_vat_inc` int(11) default NULL,
  `item_count` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `price` float default '0',
  `productcollection_id` int(11) NOT NULL default '0',
  `vat_value` float default NULL,
  PRIMARY KEY  (`id`),
  KEY `ezproductcollection_item_contentobject_id` (`contentobject_id`),
  KEY `ezproductcollection_item_productcollection_id` (`productcollection_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezproductcollection_item`
--

LOCK TABLES `ezproductcollection_item` WRITE;
/*!40000 ALTER TABLE `ezproductcollection_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezproductcollection_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezproductcollection_item_opt`
--

DROP TABLE IF EXISTS `ezproductcollection_item_opt`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezproductcollection_item_opt` (
  `id` int(11) NOT NULL auto_increment,
  `item_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `object_attribute_id` int(11) default NULL,
  `option_item_id` int(11) NOT NULL default '0',
  `price` float NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `ezproductcollection_item_opt_item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezproductcollection_item_opt`
--

LOCK TABLES `ezproductcollection_item_opt` WRITE;
/*!40000 ALTER TABLE `ezproductcollection_item_opt` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezproductcollection_item_opt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezrole`
--

DROP TABLE IF EXISTS `ezrole`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezrole` (
  `id` int(11) NOT NULL auto_increment,
  `is_new` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `value` char(1) default NULL,
  `version` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezrole`
--

LOCK TABLES `ezrole` WRITE;
/*!40000 ALTER TABLE `ezrole` DISABLE KEYS */;
INSERT INTO `ezrole` VALUES (1,0,'Anonymous','',0),(2,0,'Administrator','*',0),(3,0,'Editor','',0);
/*!40000 ALTER TABLE `ezrole` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezrss_export`
--

DROP TABLE IF EXISTS `ezrss_export`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezrss_export` (
  `access_url` varchar(255) default NULL,
  `active` int(11) default NULL,
  `created` int(11) default NULL,
  `creator_id` int(11) default NULL,
  `description` longtext,
  `id` int(11) NOT NULL auto_increment,
  `image_id` int(11) default NULL,
  `main_node_only` int(11) NOT NULL default '1',
  `modified` int(11) default NULL,
  `modifier_id` int(11) default NULL,
  `number_of_objects` int(11) NOT NULL default '0',
  `rss_version` varchar(255) default NULL,
  `site_access` varchar(255) default NULL,
  `status` int(11) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `url` varchar(255) default NULL,
  PRIMARY KEY  (`id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezrss_export`
--

LOCK TABLES `ezrss_export` WRITE;
/*!40000 ALTER TABLE `ezrss_export` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezrss_export` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezrss_export_item`
--

DROP TABLE IF EXISTS `ezrss_export_item`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezrss_export_item` (
  `class_id` int(11) default NULL,
  `description` varchar(255) default NULL,
  `id` int(11) NOT NULL auto_increment,
  `rssexport_id` int(11) default NULL,
  `source_node_id` int(11) default NULL,
  `status` int(11) NOT NULL default '0',
  `subnodes` int(11) NOT NULL default '0',
  `title` varchar(255) default NULL,
  PRIMARY KEY  (`id`,`status`),
  KEY `ezrss_export_rsseid` (`rssexport_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezrss_export_item`
--

LOCK TABLES `ezrss_export_item` WRITE;
/*!40000 ALTER TABLE `ezrss_export_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezrss_export_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezrss_import`
--

DROP TABLE IF EXISTS `ezrss_import`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezrss_import` (
  `active` int(11) default NULL,
  `class_description` varchar(255) default NULL,
  `class_id` int(11) default NULL,
  `class_title` varchar(255) default NULL,
  `class_url` varchar(255) default NULL,
  `created` int(11) default NULL,
  `creator_id` int(11) default NULL,
  `destination_node_id` int(11) default NULL,
  `id` int(11) NOT NULL auto_increment,
  `import_description` longtext NOT NULL,
  `modified` int(11) default NULL,
  `modifier_id` int(11) default NULL,
  `name` varchar(255) default NULL,
  `object_owner_id` int(11) default NULL,
  `status` int(11) NOT NULL default '0',
  `url` longtext,
  PRIMARY KEY  (`id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezrss_import`
--

LOCK TABLES `ezrss_import` WRITE;
/*!40000 ALTER TABLE `ezrss_import` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezrss_import` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezsearch_object_word_link`
--

DROP TABLE IF EXISTS `ezsearch_object_word_link`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezsearch_object_word_link` (
  `contentclass_attribute_id` int(11) NOT NULL default '0',
  `contentclass_id` int(11) NOT NULL default '0',
  `contentobject_id` int(11) NOT NULL default '0',
  `frequency` float NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `identifier` varchar(255) NOT NULL default '',
  `integer_value` int(11) NOT NULL default '0',
  `next_word_id` int(11) NOT NULL default '0',
  `placement` int(11) NOT NULL default '0',
  `prev_word_id` int(11) NOT NULL default '0',
  `published` int(11) NOT NULL default '0',
  `section_id` int(11) NOT NULL default '0',
  `word_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ezsearch_object_word_link_frequency` (`frequency`),
  KEY `ezsearch_object_word_link_identifier` (`identifier`),
  KEY `ezsearch_object_word_link_integer_value` (`integer_value`),
  KEY `ezsearch_object_word_link_object` (`contentobject_id`),
  KEY `ezsearch_object_word_link_word` (`word_id`)
) ENGINE=InnoDB AUTO_INCREMENT=162098 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezsearch_object_word_link`
--

LOCK TABLES `ezsearch_object_word_link` WRITE;
/*!40000 ALTER TABLE `ezsearch_object_word_link` DISABLE KEYS */;
INSERT INTO `ezsearch_object_word_link` VALUES (6,3,11,0,201,'',0,58,0,0,1033920746,2,57),(6,3,11,0,202,'',0,57,1,57,1033920746,2,58),(6,3,11,0,203,'',0,58,2,58,1033920746,2,57),(6,3,11,0,204,'',0,0,3,57,1033920746,2,58),(6,3,12,0,213,'',0,62,0,0,1033920775,2,61),(6,3,12,0,214,'',0,61,1,61,1033920775,2,62),(6,3,12,0,215,'',0,62,2,62,1033920775,2,61),(6,3,12,0,216,'',0,0,3,61,1033920775,2,62),(6,3,13,0,225,'',0,66,0,0,1033920794,2,66),(6,3,13,0,226,'',0,0,1,66,1033920794,2,66),(6,3,42,0,227,'',0,62,0,0,1072180330,2,67),(6,3,42,0,228,'',0,67,1,67,1072180330,2,62),(6,3,42,0,229,'',0,62,2,62,1072180330,2,67),(6,3,42,0,230,'',0,63,3,67,1072180330,2,62),(7,3,42,0,231,'',0,68,4,62,1072180330,2,63),(7,3,42,0,232,'',0,69,5,63,1072180330,2,68),(7,3,42,0,233,'',0,70,6,68,1072180330,2,69),(7,3,42,0,234,'',0,67,7,69,1072180330,2,70),(7,3,42,0,235,'',0,63,8,70,1072180330,2,67),(7,3,42,0,236,'',0,63,9,67,1072180330,2,63),(7,3,42,0,237,'',0,68,10,63,1072180330,2,63),(7,3,42,0,238,'',0,69,11,63,1072180330,2,68),(7,3,42,0,239,'',0,70,12,68,1072180330,2,69),(7,3,42,0,240,'',0,67,13,69,1072180330,2,70),(7,3,42,0,241,'',0,63,14,70,1072180330,2,67),(7,3,42,0,242,'',0,0,15,67,1072180330,2,63),(8,4,10,0,243,'',0,67,0,0,1033920665,2,67),(8,4,10,0,244,'',0,63,1,67,1033920665,2,67),(9,4,10,0,245,'',0,63,2,67,1033920665,2,63),(9,4,10,0,246,'',0,67,3,63,1033920665,2,63),(12,4,10,0,247,'',0,65,4,63,1033920665,2,67),(12,4,10,0,248,'',0,67,5,67,1033920665,2,65),(12,4,10,0,249,'',0,65,6,65,1033920665,2,67),(12,4,10,0,250,'',0,0,7,67,1033920665,2,65),(4,1,45,0,1485,'',0,85,0,0,1079684190,4,85),(4,1,45,0,1486,'',0,86,1,85,1079684190,4,85),(158,1,45,0,1487,'',0,86,2,85,1079684190,4,86),(158,1,45,0,1488,'',0,0,3,86,1079684190,4,86),(4,1,49,0,2379,'',0,90,0,0,1080220197,3,90),(4,1,49,0,2380,'',0,79,1,90,1080220197,3,90),(158,1,49,0,2381,'',1,79,2,90,1080220197,3,79),(158,1,49,0,2382,'',1,0,3,79,1080220197,3,79),(4,1,50,0,2383,'',0,101,0,0,1080220220,3,101),(4,1,50,0,2384,'',0,79,1,101,1080220220,3,101),(158,1,50,0,2385,'',1,79,2,101,1080220220,3,79),(158,1,50,0,2386,'',1,0,3,79,1080220220,3,79),(4,1,51,0,2387,'',0,102,0,0,1080220233,3,102),(4,1,51,0,2388,'',0,79,1,102,1080220233,3,102),(158,1,51,0,2389,'',1,79,2,102,1080220233,3,79),(158,1,51,0,2390,'',1,0,3,79,1080220233,3,79),(159,14,52,0,2391,'',0,104,0,0,1082016591,4,103),(159,14,52,0,2392,'',0,105,1,103,1082016591,4,104),(159,14,52,0,2393,'',0,103,2,104,1082016591,4,105),(159,14,52,0,2394,'',0,104,3,105,1082016591,4,103),(159,14,52,0,2395,'',0,105,4,103,1082016591,4,104),(159,14,52,0,2396,'',0,0,5,104,1082016591,4,105),(176,15,54,0,2397,'',0,106,0,0,1082016652,4,106),(176,15,54,0,2398,'',0,0,1,106,1082016652,4,106),(4,1,141,0,53927,'name',0,0,0,0,1232214695,1,14145),(4,1,142,0,53928,'name',0,0,0,0,1232214910,1,14146),(191,20,222,0,100856,'title',0,0,0,0,1232278536,1,15968),(8,4,14,0,162093,'first_name',0,23139,0,0,1033920830,2,20318),(9,4,14,0,162094,'last_name',0,393,1,20318,1033920830,2,23139),(12,4,14,0,162095,'user_account',0,28073,2,23139,1033920830,2,393),(12,4,14,0,162096,'user_account',0,28074,3,393,1033920830,2,28073),(12,4,14,0,162097,'user_account',0,0,4,28073,1033920830,2,28074);
/*!40000 ALTER TABLE `ezsearch_object_word_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezsearch_return_count`
--

DROP TABLE IF EXISTS `ezsearch_return_count`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezsearch_return_count` (
  `count` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `phrase_id` int(11) NOT NULL default '0',
  `time` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ezsearch_return_cnt_ph_id_cnt` (`phrase_id`,`count`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezsearch_return_count`
--

LOCK TABLES `ezsearch_return_count` WRITE;
/*!40000 ALTER TABLE `ezsearch_return_count` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezsearch_return_count` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezsearch_search_phrase`
--

DROP TABLE IF EXISTS `ezsearch_search_phrase`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezsearch_search_phrase` (
  `id` int(11) NOT NULL auto_increment,
  `phrase` varchar(250) default NULL,
  `phrase_count` int(11) default '0',
  `result_count` int(11) default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ezsearch_search_phrase_phrase` (`phrase`),
  KEY `ezsearch_search_phrase_count` (`phrase_count`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezsearch_search_phrase`
--

LOCK TABLES `ezsearch_search_phrase` WRITE;
/*!40000 ALTER TABLE `ezsearch_search_phrase` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezsearch_search_phrase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezsearch_word`
--

DROP TABLE IF EXISTS `ezsearch_word`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezsearch_word` (
  `id` int(11) NOT NULL auto_increment,
  `object_count` int(11) NOT NULL default '0',
  `word` varchar(150) default NULL,
  PRIMARY KEY  (`id`),
  KEY `ezsearch_word_obj_count` (`object_count`),
  KEY `ezsearch_word_word_i` (`word`)
) ENGINE=InnoDB AUTO_INCREMENT=28075 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezsearch_word`
--

LOCK TABLES `ezsearch_word` WRITE;
/*!40000 ALTER TABLE `ezsearch_word` DISABLE KEYS */;
INSERT INTO `ezsearch_word` VALUES (57,1,'guest'),(58,1,'accounts'),(61,1,'administrator'),(62,2,'users'),(63,2,'user'),(65,1,'nospam@ez.no'),(66,1,'editors'),(67,2,'anonymous'),(68,3,'group'),(69,9,'for'),(70,21,'the'),(79,26,'1'),(85,1,'setup'),(86,13,'0'),(90,3,'images'),(101,1,'files'),(102,1,'multimedia'),(103,1,'common'),(104,1,'ini'),(105,3,'settings'),(106,1,'sitestyle_identifier'),(393,3,'admin'),(14145,1,'planetarium'),(14146,8,'blogs'),(14148,4,'is'),(14150,8,'and'),(14153,4,'i'),(14157,29,'a'),(14158,12,'new'),(14159,21,'version'),(14160,14,'of'),(14163,11,'ez'),(14164,11,'publish'),(14165,4,'this'),(14168,14,'important'),(14171,11,'documentation'),(14173,2,'alt'),(14174,29,'d'),(14175,25,'on'),(14177,4,'word'),(14178,10,'in'),(14179,8,'template'),(14180,4,'file'),(14181,4,'will'),(14182,15,'online'),(14186,4,'templates'),(14188,2,'smarty'),(14189,4,'one'),(14194,2,'it'),(14198,7,'php'),(14200,2,'class'),(14201,8,'view'),(14203,6,'now'),(14206,7,'extension'),(14209,2,'4.x'),(14210,4,'you'),(14212,4,'need'),(14213,8,'to'),(14216,2,'download'),(14217,4,'please'),(14218,2,'visit'),(14219,2,'project'),(14220,15,'page'),(14221,29,'une'),(14222,14,'idee'),(14224,29,'la'),(14226,29,'de'),(14228,8,'enfin'),(14229,23,'fait'),(14230,19,'son'),(14231,21,'site'),(14232,29,'et'),(14233,29,'avec'),(14234,29,'en'),(14235,27,'plus'),(14236,15,'partie'),(14237,15,'blog'),(14238,10,'assez'),(14239,7,'classique'),(14240,6,'revanche'),(14241,7,'ma'),(14242,29,'est'),(14243,25,'bien'),(14244,29,'le'),(14245,11,'contenu'),(14246,21,'sa'),(14247,2,'qualifie'),(14248,12,'note'),(14252,29,'ce'),(14253,27,'qui'),(14254,7,'donne'),(14255,2,'integration'),(14257,29,'l'),(14258,6,'api'),(14259,6,'google'),(14260,2,'maps'),(14270,27,'s'),(14274,10,'as'),(14275,4,'can'),(14278,2,'content'),(14279,4,'but'),(14287,12,'an'),(14289,15,'simple'),(14290,2,'scripts'),(14293,10,'details'),(14294,6,'or'),(14296,20,'interface'),(14298,15,'source'),(14299,17,'code'),(14301,6,'if'),(14306,2,'debug'),(14310,6,'developer'),(14315,4,'development'),(14318,6,'messages'),(14320,2,'translations'),(14328,2,'site.ini.append.php'),(14329,2,'siteaccess'),(14331,2,'debugsettings'),(14332,2,'debugoutput'),(14333,2,'enabled'),(14334,2,'templatesettings'),(14335,2,'showusedtemplates'),(14343,6,'t'),(14344,2,'show'),(14347,16,'possible'),(14351,6,'id'),(14353,12,'be'),(14355,8,'live'),(14356,9,'sites'),(14358,4,'your'),(14362,2,'with'),(14363,4,'following'),(14370,8,'line'),(14378,2,'debugredirection'),(14381,14,'http'),(14390,4,'workflow'),(14392,2,'edit'),(14393,3,'handler'),(14394,9,'extensions'),(14395,4,'modules'),(14399,5,'pages'),(14402,2,'break'),(14410,6,'at'),(14414,7,'place'),(14417,2,'special'),(14422,7,'comment'),(14425,4,'pagelayout'),(14428,4,'ajax'),(14435,2,'set'),(14438,2,'ez.no'),(14439,7,'forums'),(14440,2,'something'),(14441,8,'from'),(14445,6,'variable'),(14446,2,'message'),(14454,8,'using'),(14455,2,'attribute'),(14458,2,'hash'),(14460,4,'objects'),(14461,4,'list'),(14462,2,'like'),(14464,2,'fetch'),(14467,4,'4.0'),(14469,2,'first'),(14471,12,'4'),(14476,9,'classes'),(14477,4,'three'),(14480,6,'object'),(14481,2,'meta'),(14482,4,'attributes'),(14483,6,'moment'),(14485,2,'change'),(14489,2,'left'),(14490,2,'menu'),(14492,8,'release'),(14495,8,'bug'),(14496,2,'fixes'),(14500,4,'standards'),(14501,2,'my'),(14504,12,'day'),(14505,6,'paris'),(14507,6,'11'),(14508,12,'2008'),(14509,16,'bon'),(14510,27,'cette'),(14511,25,'fois'),(14512,8,'ci'),(14513,21,'je'),(14514,29,'ne'),(14516,11,'m'),(14517,24,'y'),(14518,8,'rendre'),(14519,5,'suis'),(14520,19,'voir'),(14521,29,'que'),(14522,21,'autres'),(14523,23,'ont'),(14524,29,'un'),(14526,6,'7'),(14527,6,'novembre'),(14528,29,'par'),(14531,6,'journee'),(14532,9,'developpeur'),(14533,2,'ezpublish'),(14536,18,'compte'),(14537,10,'rendu'),(14540,5,'merci'),(14541,13,'eux'),(14542,29,'pour'),(14543,2,'seance'),(14546,6,'serait'),(14547,25,'si'),(14548,2,'genre'),(14549,2,'evenement'),(14550,9,'etait'),(14552,6,'diffuse'),(14553,29,'sur'),(14554,2,'ajout'),(14555,29,'du'),(14556,4,'script'),(14558,29,'les'),(14560,29,'des'),(14561,12,'maniere'),(14562,15,'peu'),(14564,6,'ameliorer'),(14565,2,'performances'),(14566,12,'affichage'),(14567,29,'au'),(14568,15,'premier'),(14570,5,'cache'),(14571,6,'navigateur'),(14573,19,'sans'),(14574,16,'trop'),(14575,13,'problemes'),(14578,8,'sujet'),(14579,14,'mode'),(14580,17,'permet'),(14581,14,'facilement'),(14582,2,'donnee'),(14583,3,'probleme'),(14584,25,'qu'),(14585,4,'service'),(14586,26,'peut'),(14588,2,'archive'),(14589,2,'zip'),(14591,25,'mais'),(14594,28,'etre'),(14596,29,'il'),(14597,18,'aussi'),(14598,25,'utiliser'),(14599,8,'firefox'),(14600,13,'toutes'),(14601,11,'application'),(14602,18,'web'),(14603,13,'passer'),(14604,4,'revue'),(14605,29,'sont'),(14606,29,'pas'),(14608,6,'accessibles'),(14609,13,'utilisation'),(14610,17,'sera'),(14611,27,'tout'),(14612,5,'simplement'),(14615,23,'cela'),(14616,15,'j'),(14617,15,'ai'),(14618,5,'ecrit'),(14619,2,'suivant'),(14620,10,'fichiers'),(14624,23,'tous'),(14626,2,'identifie'),(14627,6,'24'),(14628,8,'bits'),(14631,6,'8'),(14633,4,'verification'),(14637,6,'fichier'),(14639,3,'petit'),(14640,15,'agit'),(14641,10,'juste'),(14643,19,'ces'),(14645,6,'selon'),(14646,12,'applications'),(14649,14,'semaine'),(14650,7,'derniere'),(14651,20,'quand'),(14652,2,'etais'),(14657,2,'aime'),(14658,4,'aient'),(14660,4,'seul'),(14661,6,'ailleurs'),(14662,6,'lance'),(14663,10,'nouvel'),(14664,5,'editor'),(14666,4,'futur'),(14667,5,'editeur'),(14669,7,'cms'),(14671,4,'bin'),(14672,4,'bash'),(14684,6,'f'),(14685,2,'dossier'),(14686,2,'modifie'),(14689,27,'ou'),(14690,7,'chercher'),(14696,6,'g'),(14705,4,'do'),(14706,2,'case'),(14708,4,'h'),(14712,6,'z'),(14713,29,'n'),(14714,11,'existe'),(14715,19,'2'),(14717,6,'find'),(14718,6,'name'),(14720,6,'o'),(14723,2,'eq'),(14724,6,'aucune'),(14725,6,'image'),(14727,4,'mkdir'),(14731,4,'p'),(14736,4,'brute'),(14741,8,'lt'),(14745,4,'rm'),(14746,14,'type'),(14753,2,'continue'),(14758,4,'securiser'),(14760,2,'publie'),(14761,16,'deux'),(14762,8,'articles'),(14763,2,'propos'),(14764,14,'securite'),(14765,10,'general'),(14769,8,'defaut'),(14770,5,'objets'),(14771,29,'dans'),(14772,29,'meme'),(14773,3,'lorsque'),(14774,14,'devrait'),(14775,2,'arriver'),(14776,9,'solution'),(14778,27,'faire'),(14781,13,'dernier'),(14783,8,'rien'),(14784,2,'eviter'),(14785,9,'afficher'),(14786,17,'ete'),(14787,7,'prevu'),(14789,15,'toujours'),(14790,10,'mieux'),(14792,14,'droits'),(14793,19,'c'),(14796,3,'informations'),(14797,2,'elements'),(14798,6,'considerer'),(14799,2,'oublie'),(14800,2,'probablement'),(14801,10,'voici'),(14802,15,'ceux'),(14803,9,'me'),(14804,4,'viennent'),(14806,4,'niveau'),(14807,8,'faut'),(14809,2,'operateur'),(14810,2,'wash'),(14811,2,'assurer'),(14812,4,'caracteres'),(14816,2,'xhtml'),(14820,8,'surtout'),(14821,16,'votre'),(14822,10,'propose'),(14823,28,'aux'),(14824,2,'internautes'),(14826,21,'systeme'),(14827,3,'production'),(14828,6,'repertoire'),(14829,7,'permettre'),(14831,8,'serveur'),(14832,21,'utilisateur'),(14833,4,'mysql'),(14834,16,'utilise'),(14836,4,'portee'),(14837,2,'eventuelle'),(14838,4,'mauvaise'),(14842,2,'inutiles'),(14843,20,'exemple'),(14844,15,'mon'),(14848,15,'configuration'),(14849,4,'suivante'),(14851,2,'rules'),(14854,2,'module'),(14859,23,'quelques'),(14862,11,'ainsi'),(14863,15,'utilisateurs'),(14865,14,'alors'),(14866,14,'ils'),(14868,2,'vue'),(14869,6,'particulier'),(14871,7,'savoir'),(14872,11,'quoi'),(14875,9,'cas'),(14876,4,'vaut'),(14877,18,'jour'),(14878,13,'versions'),(14881,2,'3.9.4'),(14888,2,'commentaires'),(14890,10,'toute'),(14891,6,'possibilite'),(14892,4,'lecture'),(14893,9,'via'),(14894,10,'acces'),(14895,2,'direct'),(14896,17,'avoir'),(14899,2,'apporter'),(14901,6,'presque'),(14902,6,'completement'),(14906,20,'donnees'),(14908,15,'avant'),(14910,2,'sql'),(14911,11,'ca'),(14912,2,'specifique'),(14913,6,'methode'),(14915,5,'classe'),(14929,4,'there'),(14938,2,'60'),(14939,10,'000'),(14940,2,'url'),(14942,4,'server'),(14946,7,'install'),(14948,2,'toolbar'),(14954,7,'design'),(14963,18,'article'),(14972,2,'all'),(14976,2,'configure'),(14980,3,'package'),(14997,2,'def'),(15003,2,'is_set'),(15009,5,'import'),(15013,6,'no'),(15021,2,'undef'),(15022,2,'put'),(15036,4,'two'),(15038,4,'override'),(15039,2,'condition'),(15044,3,'instance'),(15053,6,'patch'),(15056,2,'certified'),(15057,12,'passe'),(15058,17,'temps'),(15059,2,'certification'),(15062,7,'migration'),(15063,29,'sous'),(15064,2,'ayant'),(15065,5,'migrer'),(15067,2,'pret'),(15068,2,'sauf'),(15070,2,'php5'),(15073,29,'comme'),(15074,19,'deja'),(15076,4,'rend'),(15077,19,'donc'),(15078,4,'relativement'),(15079,6,'inutile'),(15081,6,'conference'),(15082,16,'apres'),(15083,2,'midi'),(15084,7,'systems'),(15085,4,'organise'),(15086,7,'autour'),(15087,17,'developpement'),(15088,8,'attire'),(15089,13,'mal'),(15090,15,'developpeurs'),(15091,8,'tel'),(15094,2,'3.10'),(15096,18,'depuis'),(15097,20,'nous'),(15098,2,'pouvons'),(15099,8,'configurer'),(15102,14,'petite'),(15103,8,'differentes'),(15104,17,'fonctionnalites'),(15105,2,'ezurl'),(15106,2,'fournit'),(15107,7,'certains'),(15108,2,'operateurs'),(15109,17,'base'),(15111,2,'ezroot'),(15114,24,'tres'),(15116,14,'besoin'),(15117,25,'se'),(15118,6,'font'),(15121,4,'alpha'),(15122,7,'aujourd'),(15123,9,'hui'),(15124,2,'stable'),(15127,3,'permettant'),(15129,3,'datatype'),(15132,10,'grace'),(15133,7,'fonction'),(15135,7,'utilisant'),(15137,2,'attribute_filter'),(15138,2,'veut'),(15139,2,'apparition'),(15143,4,'sortir'),(15144,7,'differents'),(15145,4,'patchs'),(15146,2,'correction'),(15151,4,'actuelle'),(15152,10,'complet'),(15154,2,'souple'),(15156,14,'installer'),(15162,12,'distribution'),(15163,2,'basee'),(15164,14,'debian'),(15166,8,'offre'),(15167,7,'ajouter'),(15170,13,'information'),(15172,10,'mis'),(15173,8,'23'),(15174,2,'juin'),(15175,8,'2007'),(15177,8,'trouve'),(15178,2,'infos'),(15179,2,'futures'),(15180,4,'date'),(15181,2,'sortie'),(15183,8,'fin'),(15184,12,'debut'),(15185,8,'annonce'),(15186,2,'newsletter'),(15188,15,'nouvelle'),(15190,19,'disponible'),(15191,2,'lot'),(15192,6,'nouveautes'),(15193,8,'interessant'),(15195,12,'libre'),(15197,11,'commence'),(15199,14,'elles'),(15201,6,'samedi'),(15202,10,'17'),(15204,4,'malgre'),(15210,2,'boite'),(15212,8,'tant'),(15213,10,'support'),(15214,6,'technique'),(15215,13,'mise'),(15216,2,'faisait'),(15217,2,'bout'),(15220,19,'cet'),(15222,6,'desormais'),(15227,4,'etant'),(15237,2,'types'),(15238,2,'retrouve'),(15239,4,'souvent'),(15240,7,'developper'),(15243,6,'post'),(15244,7,'eu'),(15245,6,'lieu'),(15246,2,'riche'),(15248,9,'notamment'),(15249,16,'ici'),(15250,4,'annee'),(15251,6,'4.1'),(15252,4,'complete'),(15253,24,'vous'),(15254,12,'pouvez'),(15255,2,'opensource'),(15257,4,'news'),(15259,2,'tenu'),(15260,11,'ses'),(15263,4,'rappelle'),(15264,16,'grande'),(15265,4,'evolution'),(15266,19,'elle'),(15268,6,'telecharger'),(15270,4,'candidate'),(15271,17,'encore'),(15274,2,'poster'),(15275,6,'avis'),(15276,6,'forum'),(15277,2,'commentaire'),(15278,4,'components'),(15279,2,'heureux'),(15280,10,'essayer'),(15281,8,'nouvelles'),(15284,6,'erreurs'),(15285,14,'lors'),(15289,2,'framework'),(15290,3,'developpe'),(15291,9,'directement'),(15292,6,'integre'),(15293,2,'soi'),(15294,8,'marche'),(15295,10,'suivre'),(15296,2,'adresse'),(15298,4,'copier'),(15302,8,'avez'),(15304,2,'racine'),(15305,6,'installation'),(15306,2,'index.php'),(15307,17,'creer'),(15309,4,'editer'),(15310,16,'ligne'),(15311,13,'va'),(15312,14,'maintenant'),(15321,16,'mois'),(15322,2,'signaler'),(15323,6,'concernant'),(15324,2,'principales'),(15325,4,'modifications'),(15326,4,'corrections'),(15327,10,'bugs'),(15328,6,'visibilite'),(15329,2,'node'),(15330,2,'tree'),(15332,4,'remarque'),(15333,8,'lorsqu'),(15334,8,'installe'),(15336,13,'dire'),(15342,8,'affiche'),(15343,10,'ceci'),(15344,6,'erreur'),(15345,10,'presente'),(15346,2,'livre'),(15347,4,'suffit'),(15348,10,'supprimer'),(15350,2,'ordre'),(15351,4,'dessous'),(15352,8,'afin'),(15359,6,'creation'),(15360,6,'champs'),(15361,2,'vont'),(15363,13,'ensuite'),(15364,2,'accessible'),(15365,2,'onglet'),(15367,9,'cependant'),(15369,2,'presentent'),(15370,5,'fonctionnalite'),(15371,10,'etaient'),(15374,2,'strictement'),(15376,6,'fonctionner'),(15377,7,'effet'),(15378,4,'saisie'),(15382,3,'fonctionnel'),(15386,2,'attribute_view_gui'),(15391,6,'devez'),(15392,4,'adapter'),(15396,18,'10'),(15399,6,'durant'),(15400,2,'principalement'),(15404,2,'totalement'),(15407,2,'3.x'),(15408,2,'80%'),(15409,6,'90%'),(15410,6,'devraient'),(15412,4,'automatique'),(15413,2,'cluster'),(15414,6,'ameliore'),(15418,2,'laisse'),(15419,14,'lire'),(15422,4,'estime'),(15423,4,'puissant'),(15424,9,'open'),(15425,20,'leur'),(15426,14,'gerer'),(15427,10,'objet'),(15431,11,'pourquoi'),(15432,8,'jamais'),(15433,6,'vraiment'),(15434,4,'voulu'),(15435,2,'investir'),(15437,14,'premiere'),(15442,6,'prise'),(15443,14,'facile'),(15444,3,'doc'),(15446,4,'devient'),(15447,12,'clair'),(15450,6,'chose'),(15454,14,'nouveaux'),(15457,15,'communaute'),(15458,6,'francaise'),(15462,11,'nbsp'),(15465,3,'partenaires'),(15477,7,'france'),(15484,3,'partner'),(15486,13,'cours'),(15487,10,'membres'),(15488,9,'programme'),(15489,5,'partenariat'),(15490,3,'roland'),(15491,3,'benedetti'),(15493,12,'point'),(15496,3,'secteur'),(15497,7,'media'),(15498,3,'entertainment'),(15499,10,'reste'),(15502,5,'prochaine'),(15504,16,'monde'),(15505,3,'finance'),(15506,9,'cf'),(15507,3,'references'),(15509,14,'chez'),(15512,4,'societe'),(15513,3,'generale'),(15514,7,'modele'),(15515,3,'economique'),(15516,3,'consulting'),(15518,7,'maintenance'),(15523,13,'bureau'),(15524,3,'japon'),(15525,5,'9'),(15529,11,'video'),(15531,5,'arrivee'),(15532,19,'egalement'),(15535,18,'plusieurs'),(15536,3,'langues'),(15537,3,'clients'),(15539,7,'europe'),(15540,7,'projet'),(15541,10,'avait'),(15542,7,'rencontre'),(15543,20,'entre'),(15544,3,'participants'),(15545,5,'international'),(15546,5,'meeting'),(15548,11,'janvier'),(15549,3,'dirige'),(15550,3,'maud'),(15551,5,'acheve'),(15552,6,'bientot'),(15557,11,'amp'),(15558,3,'long'),(15561,11,'nouveau'),(15564,7,'points'),(15565,9,'membre'),(15568,9,'solutions'),(15571,3,'permettait'),(15572,21,'autre'),(15574,9,'communautaire'),(15578,15,'peuvent'),(15580,16,'chaque'),(15584,3,'quant'),(15585,7,'developpements'),(15586,21,'dont'),(15591,7,'soumettre'),(15592,21,'non'),(15600,3,'petits'),(15601,12,'soient'),(15602,7,'qualite'),(15604,5,'contributions'),(15606,18,'leurs'),(15608,3,'impliquer'),(15615,7,'activite'),(15616,9,'uniquement'),(15618,16,'nombre'),(15619,3,'annuel'),(15620,5,'atteindre'),(15621,17,'20'),(15624,3,'silver'),(15626,5,'finalement'),(15629,12,'lui'),(15633,5,'pays'),(15635,3,'parmi'),(15636,7,'professionnels'),(15637,7,'integrateurs'),(15638,3,'represente'),(15641,7,'formation'),(15643,18,'projets'),(15644,7,'complexes'),(15645,7,'culture'),(15646,3,'achat'),(15647,3,'premium'),(15648,15,'moins'),(15651,20,'dit'),(15652,3,'roadmap'),(15656,3,'homme'),(15658,5,'re'),(15660,7,'oracle'),(15663,3,'retro'),(15664,9,'compatible'),(15665,6,'contenus'),(15666,6,'existant'),(15667,7,'format'),(15668,5,'xml'),(15669,5,'restera'),(15670,3,'ie'),(15671,5,'vista'),(15672,3,'states'),(15673,5,'distribuer'),(15674,10,'gestion'),(15675,7,'password'),(15676,3,'expiry'),(15678,11,'decembre'),(15679,3,'flow'),(15680,3,'1.1'),(15682,5,'upload'),(15683,12,'car'),(15684,6,'passage'),(15685,7,'flash'),(15686,5,'vu'),(15687,5,'apparaitre'),(15689,5,'apparaitra'),(15693,3,'trimestre'),(15694,11,'2009'),(15695,3,'css'),(15697,3,'attributs'),(15699,22,'5'),(15703,3,'kernel'),(15710,5,'demarche'),(15713,3,'oriented'),(15719,18,'vers'),(15720,15,'pourrait'),(15723,5,'contrairement'),(15724,5,'envisage'),(15725,5,'permettra'),(15727,7,'proprietaires'),(15732,5,'integrant'),(15733,3,'vrai'),(15736,3,'team'),(15744,3,'drag'),(15748,9,'documents'),(15750,5,'groupes'),(15751,7,'ateliers'),(15752,17,'travail'),(15753,11,'chacun'),(15754,9,'sorte'),(15755,3,'mini'),(15757,5,'calendrier'),(15758,6,'bref'),(15761,5,'bases'),(15763,3,'vendue'),(15765,5,'metier'),(15766,3,'2.0'),(15767,5,'nombreuses'),(15769,7,'detail'),(15770,5,'paul'),(15772,9,'ensemble'),(15773,5,'final'),(15778,9,'mettre'),(15779,2,'resultats'),(15780,9,'plutot'),(15788,4,'mots'),(15789,4,'recherches'),(15792,14,'recherche'),(15793,2,'tri'),(15796,2,'lie'),(15797,4,'resultat'),(15798,6,'suggestion'),(15802,3,'indexation'),(15803,6,'externes'),(15804,7,'fils'),(15806,15,'etc'),(15812,11,'presentation'),(15814,2,'tris'),(15816,8,'auteur'),(15818,5,'choix'),(15819,2,'langue'),(15820,2,'integrer'),(15823,6,'capacite'),(15825,3,'jusqu'),(15826,6,'100'),(15827,10,'millions'),(15830,2,'policies'),(15831,4,'3.0'),(15835,6,'wiki'),(15836,3,'apache'),(15838,2,'sections'),(15839,4,'seront'),(15841,12,'entiere'),(15842,5,'gere'),(15844,4,'etat'),(15845,2,'nativement'),(15846,2,'discussion'),(15848,4,'disponibles'),(15857,2,'changement'),(15859,4,'preparer'),(15860,4,'pre'),(15861,6,'lancement'),(15863,3,'communication'),(15865,6,'consulter'),(15866,2,'specifications'),(15868,4,'labs'),(15870,2,'request'),(15873,2,'prochain'),(15876,6,'29'),(15877,2,'30'),(15881,8,'recemment'),(15889,3,'export'),(15902,4,'questions'),(15903,2,'performance'),(15904,2,'servir'),(15907,10,'objectif'),(15909,4,'seconde'),(15915,4,'edition'),(15921,4,'wget'),(15924,13,'soit'),(15925,16,'internet'),(15927,8,'youtube'),(15932,5,'ajoute'),(15937,6,'gens'),(15939,4,'pratiquement'),(15942,7,'bonne'),(15944,7,'cote'),(15945,2,'derriere'),(15946,2,'lesquels'),(15947,12,'entreprise'),(15951,4,'reduite'),(15954,8,'gnu'),(15955,5,'gpl'),(15960,4,'discussions'),(15963,11,'pres'),(15966,4,'moyen'),(15968,7,'contact'),(15971,8,'francais'),(15974,5,'utiles'),(15976,5,'fil'),(15981,7,'gt'),(15991,9,'traduire'),(15992,8,'traductions'),(15993,3,'share'),(16014,5,'global'),(16027,9,'proposer'),(16028,3,'style'),(16034,7,'123'),(16039,7,'directives'),(16046,9,'verifier'),(16052,13,'cree'),(16053,3,'prend'),(16054,5,'createur'),(16056,5,'sudo'),(16057,3,'chmod'),(16069,5,'autoriser'),(16070,3,'saut'),(16075,9,'liste'),(16078,20,'3'),(16082,3,'mod'),(16088,7,'comparer'),(16093,8,'publication'),(16123,11,'forme'),(16132,5,'else'),(16133,3,'section'),(16136,8,'modifier'),(16146,3,'introduire'),(16147,5,'manuellement'),(16148,3,'endroit'),(16149,7,'chaine'),(16156,3,'counter'),(16167,5,'rapidement'),(16168,3,'tests'),(16170,4,'definir'),(16179,3,'jeudi'),(16182,3,'21h00'),(16183,7,'formats'),(16192,13,'attention'),(16193,11,'moteur'),(16195,5,'utile'),(16196,3,'avance'),(16198,18,'celui'),(16203,3,'actualites'),(16229,5,'doivent'),(16230,10,'taille'),(16237,10,'fr'),(16240,5,'ts'),(16245,7,'mot'),(16251,5,'dure'),(16261,8,'puis'),(16265,10,'lancer'),(16271,2,'construire'),(16273,4,'trois'),(16281,3,'avril'),(16290,9,'rendez'),(16294,7,'apple'),(16296,7,'nombreux'),(16299,8,'anglais'),(16300,7,'coup'),(16301,16,'mes'),(16302,3,'notes'),(16303,3,'introduction'),(16306,7,'plateforme'),(16307,3,'opensolaris'),(16309,3,'head'),(16310,5,'pris'),(16313,7,'presentations'),(16321,3,'volonte'),(16322,7,'partager'),(16340,11,'suite'),(16346,9,'train'),(16347,8,'changer'),(16348,7,'facon'),(16350,7,'texte'),(16353,7,'actuel'),(16357,7,'full'),(16367,5,'remplace'),(16369,3,'medias'),(16372,5,'actuellement'),(16373,7,'multi'),(16374,7,'compris'),(16376,5,'200'),(16378,3,'connus'),(16380,3,'integres'),(16381,6,'deuxieme'),(16385,9,'changements'),(16386,3,'importants'),(16388,7,'amelioration'),(16390,3,'execution'),(16392,3,'focus'),(16396,7,'seulement'),(16399,3,'leger'),(16400,3,'ms'),(16404,5,'etapes'),(16405,5,'supplementaires'),(16407,9,'telle'),(16408,5,'etape'),(16412,13,'aura'),(16421,5,'off'),(16423,3,'deviennent'),(16424,3,'lourd'),(16425,5,'depasse'),(16426,10,'grand'),(16427,3,'enregistres'),(16428,7,'bas'),(16429,5,'volee'),(16432,5,'entree'),(16440,12,'pense'),(16442,3,'mecanismes'),(16445,6,'fonctions'),(16448,5,'fortement'),(16449,5,'usages'),(16450,3,'actuels'),(16454,11,'proche'),(16455,3,'allant'),(16456,7,'rapport'),(16457,17,'fort'),(16461,3,'conversion'),(16469,14,'certaines'),(16470,5,'evolutions'),(16473,7,'pistes'),(16478,5,'evoque'),(16481,3,'forcement'),(16483,10,'groupe'),(16484,10,'architecture'),(16485,12,'haut'),(16487,5,'sens'),(16488,5,'troisieme'),(16489,8,'limites'),(16492,4,'importantes'),(16494,6,'pratiques'),(16497,4,'centaines'),(16499,2,'limitations'),(16500,10,'serveurs'),(16503,4,'contenant'),(16511,2,'prevue'),(16512,2,'finale'),(16514,6,'reduction'),(16519,4,'pause'),(16521,8,'bonnes'),(16522,6,'astuces'),(16527,2,'gerant'),(16529,2,'metiers'),(16530,4,'externe'),(16532,3,'login'),(16534,5,'role'),(16540,7,'propres'),(16542,4,'succes'),(16543,8,'partage'),(16544,8,'semble'),(16545,2,'faille'),(16549,2,'reseau'),(16553,6,'principe'),(16565,2,'validation'),(16566,14,'doit'),(16567,4,'enfants'),(16573,4,'openoffice.org'),(16575,2,'consequence'),(16576,2,'difficiles'),(16578,10,'public'),(16580,2,'fini'),(16582,2,'solr'),(16592,2,'oeuvre'),(16594,6,'expose'),(16597,2,'sources'),(16601,14,'equipe'),(16602,2,'paquet'),(16604,2,'plein'),(16607,2,'entendre'),(16608,2,'uns'),(16609,12,'interet'),(16610,4,'rendra'),(16614,4,'tenir'),(16615,4,'souhaite'),(16622,4,'ameliorations'),(16629,2,'hautes'),(16636,4,'definition'),(16640,6,'here'),(16641,6,'home'),(16649,18,'linux'),(16650,2,'command'),(16654,14,'windows'),(16661,13,'systemes'),(16664,3,'reflexion'),(16666,5,'annees'),(16669,3,'logicielle'),(16671,10,'besoins'),(16672,7,'plupart'),(16676,5,'rapide'),(16678,9,'gestionnaire'),(16686,10,'moi'),(16690,5,'connaissent'),(16692,9,'proposes'),(16693,3,'out'),(16694,3,'box'),(16705,7,'chef'),(16707,5,'reussi'),(16710,13,'client'),(16711,8,'specifiques'),(16715,5,'necessitent'),(16718,3,'parce'),(16719,7,'identifies'),(16722,3,'maintenances'),(16728,7,'autant'),(16737,9,'part'),(16739,7,'revient'),(16740,9,'presse'),(16742,5,'arguments'),(16743,13,'contre'),(16745,7,'celle'),(16747,5,'devra'),(16748,5,'mains'),(16752,3,'livraison'),(16753,7,'produit'),(16755,5,'vendre'),(16756,3,'majorite'),(16757,9,'vos'),(16758,7,'permettrait'),(16759,5,'moindre'),(16760,3,'cout'),(16774,3,'stables'),(16778,7,'presenter'),(16782,5,'10%'),(16783,9,'6'),(16786,3,'serieux'),(16791,8,'cause'),(16802,9,'os'),(16805,3,'pose'),(16810,11,'usage'),(16811,5,'innovations'),(16816,4,'domaine'),(16820,11,'logiciel'),(16821,3,'manipule'),(16824,3,'inverse'),(16828,7,'existence'),(16833,5,'importe'),(16834,5,'quel'),(16835,5,'constituer'),(16837,5,'programmation'),(16841,6,'ans'),(16850,14,'logiciels'),(16854,8,'100%'),(16855,3,'esprit'),(16858,11,'equipes'),(16862,3,'innovation'),(16869,7,'lies'),(16870,3,'juridique'),(16871,3,'suivi'),(16876,9,'devenir'),(16879,6,'prendre'),(16881,5,'montre'),(16883,5,'defend'),(16894,3,'pensee'),(16895,3,'cuisine'),(16897,4,'maison'),(16898,7,'options'),(16904,9,'pc'),(16905,7,'carte'),(16906,5,'vendus'),(16907,5,'dell'),(16910,3,'concu'),(16912,3,'depart'),(16913,9,'evoluer'),(16925,6,'venir'),(16927,4,'connaissance'),(16928,2,'offrent'),(16929,4,'caracteristiques'),(16935,2,'commun'),(16936,6,'composants'),(16939,2,'distribues'),(16946,4,'phase'),(16950,6,'microsoft'),(16952,2,'fevrier'),(16963,4,'phases'),(16964,6,'montee'),(16967,8,'notre'),(16971,2,'pouvait'),(16972,4,'donner'),(16977,7,'volume'),(16988,3,'produits'),(16991,7,'top'),(16995,3,'fonds'),(16998,3,'ex'),(17001,5,'novell'),(17009,3,'importance'),(17011,3,'rappel'),(17018,3,'courant'),(17022,9,'commencer'),(17023,5,'gagner'),(17030,3,'tournant'),(17031,3,'java'),(17038,16,'beaucoup'),(17039,11,'autrement'),(17046,3,'papier'),(17047,7,'tele'),(17050,5,'choisi'),(17052,5,'dollars'),(17054,5,'magazines'),(17062,3,'videos'),(17074,7,'us'),(17082,7,'accompagner'),(17084,3,'tot'),(17088,5,'vie'),(17092,5,'dur'),(17096,3,'minutes'),(17100,9,'evenements'),(17102,5,'photos'),(17104,3,'explorer'),(17105,3,'massif'),(17107,5,'future'),(17109,3,'distribue'),(17123,8,'seraient'),(17129,3,'adobe'),(17130,3,'interfaces'),(17143,11,'mises'),(17154,3,'venant'),(17157,5,'fondateur'),(17162,10,'charge'),(17164,3,'interesse'),(17168,3,'assurance'),(17172,3,'vocation'),(17173,4,'occupe'),(17175,6,'software'),(17179,2,'community'),(17181,2,'chargee'),(17204,4,'test'),(17205,2,'system'),(17217,6,'terme'),(17219,8,'longtemps'),(17221,2,'prevues'),(17279,6,'recommande'),(17283,4,'avertissement'),(17288,2,'fraichement'),(17289,16,'ubuntu'),(17291,2,'strict'),(17307,6,'berlin'),(17310,2,'lib'),(17318,6,'centrale'),(17319,2,'terminer'),(17323,10,'8217'),(17325,2,'explication'),(17326,4,'impose'),(17328,4,'bel'),(17333,7,'demande'),(17337,4,'parler'),(17342,4,'mettez'),(17343,6,'actions'),(17346,2,'ajoutant'),(17348,5,'contient'),(17358,4,'disais'),(17359,4,'souhaitez'),(17360,2,'cliquez'),(17363,2,'obtenu'),(17378,6,'decouvrir'),(17385,6,'magazine'),(17388,2,'8220'),(17394,4,'navigateurs'),(17397,3,'charte'),(17398,13,'graphique'),(17404,2,'avancees'),(17405,10,'suivantes'),(17406,2,'plateformes'),(17411,4,'casse'),(17415,2,'histoire'),(17418,2,'commerce'),(17419,4,'possede'),(17423,6,'decide'),(17435,6,'8230'),(17436,4,'80'),(17464,6,'question'),(17467,10,'choisir'),(17470,6,'approches'),(17471,8,'avantages'),(17475,5,'outil'),(17479,10,'journal'),(17482,2,'management'),(17483,5,'derniers'),(17484,9,'jours'),(17485,2,'cite'),(17490,2,'apporte'),(17491,4,'meilleur'),(17497,4,'demarre'),(17498,4,'18'),(17505,12,'parle'),(17514,7,'attente'),(17524,8,'necessaire'),(17529,2,'toutefois'),(17532,4,'etes'),(17533,2,'oubliez'),(17537,6,'telles'),(17539,9,'billet'),(17540,2,'annoncer'),(17541,10,'lequel'),(17542,6,'activites'),(17553,6,'aupres'),(17564,4,'pieds'),(17568,4,'dot'),(17585,2,'face'),(17587,4,'free'),(17591,7,'ni'),(17593,3,'particularite'),(17596,4,'restent'),(17603,4,'tache'),(17604,6,'fonctionne'),(17605,6,'standard'),(17610,6,'passent'),(17616,7,'nom'),(17620,6,'accent'),(17626,6,'recent'),(17630,10,'cles'),(17639,4,'vient'),(17641,6,'droit'),(17657,4,'lecteur'),(17658,2,'officiel'),(17661,6,'aide'),(17662,4,'webcam'),(17677,2,'complexe'),(17678,2,'jeu'),(17687,12,'travers'),(17689,6,'loin'),(17694,2,'avere'),(17700,4,'averer'),(17703,2,'visiteurs'),(17707,4,'voient'),(17708,2,'sondage'),(17709,6,'telechargement'),(17728,2,'corps'),(17729,10,'affichera'),(17734,4,'tard'),(17736,2,'comportement'),(17738,6,'dernieres'),(17742,4,'regarder'),(17748,2,'michael'),(17764,2,'sein'),(17770,2,'doute'),(17771,2,'espere'),(17774,7,'liens'),(17782,4,'revolution'),(17785,4,'remise'),(17793,4,'avons'),(17797,2,'vim'),(17827,2,'person'),(17840,8,'declare'),(17853,6,'get'),(17858,4,'five'),(17860,4,'up'),(17891,6,'chicago'),(17894,2,'control'),(17900,4,'however'),(17903,2,'six'),(17913,2,'event'),(17947,4,'network'),(17955,2,'issue'),(17964,6,'co'),(17996,4,'mechanism'),(18045,2,'16'),(18048,6,'19'),(18051,4,'local'),(18052,6,'21'),(18055,6,'12'),(18060,4,'variables'),(18071,6,'implementation'),(18079,2,'course'),(18085,4,'memes'),(18088,2,'thought'),(18111,2,'pierre'),(18113,2,'tries'),(18124,2,'stefan'),(18136,2,'friend'),(18168,4,'different'),(18179,6,'principal'),(18182,2,'precise'),(18226,2,'utc'),(18243,2,'34'),(18268,4,'zero'),(18270,4,'uk'),(18313,4,'times'),(18350,4,'fixed'),(18376,4,'later'),(18383,4,'2.6.28'),(18385,2,'play'),(18404,4,'1.6'),(18421,2,'plan'),(18424,4,'within'),(18459,2,'marketing'),(18487,2,'follow'),(18506,4,'iis'),(18540,2,'direction'),(18546,4,'wifi'),(18547,7,'traduction'),(18548,4,'apparu'),(18549,6,'circle'),(18552,4,'manipulations'),(18553,8,'ordinateur'),(18554,4,'supporte'),(18556,6,'https'),(18564,8,'terminal'),(18565,4,'tapez'),(18566,10,'commande'),(18572,2,'canal'),(18573,5,'vais'),(18579,4,'proteger'),(18585,12,'allez'),(18590,2,'hesiter'),(18592,2,'sinon'),(18597,2,'allons'),(18600,2,'discours'),(18602,2,'tiree'),(18603,10,'modifiee'),(18608,2,'appele'),(18611,4,'microphone'),(18614,2,'ogg'),(18615,4,'mp3'),(18618,6,'montage'),(18619,2,'reviendrons'),(18620,12,'trouver'),(18621,2,'machine'),(18625,8,'obtenir'),(18626,2,'personnelle'),(18631,2,'comprendre'),(18632,4,'ben'),(18634,3,'francophone'),(18635,2,'ii'),(18636,14,'distributions'),(18639,6,'depots'),(18641,4,'apt'),(18643,4,'paquets'),(18644,6,'demon'),(18646,4,'normal'),(18667,2,'connecte'),(18673,4,'port'),(18679,6,'ait'),(18690,4,'taper'),(18693,2,'aucun'),(18695,4,'ecrire'),(18697,2,'diffuser'),(18704,4,'super'),(18710,4,'mount'),(18717,2,'executable'),(18723,6,'affichees'),(18730,6,'joue'),(18733,2,'absolue'),(18741,4,'musique'),(18742,2,'invite'),(18746,12,'cliquer'),(18748,6,'utilisez'),(18750,6,'pourrez'),(18751,4,'ecouter'),(18753,2,'faudrait'),(18754,4,'aller'),(18756,6,'redige'),(18759,4,'celebre'),(18760,4,'debutant'),(18763,10,'poser'),(18771,5,'peux'),(18772,6,'responsable'),(18776,8,'effectuer'),(18777,4,'commandes'),(18778,4,'internes'),(18790,4,'realise'),(18795,4,'optimisee'),(18799,10,'ecran'),(18803,4,'architectures'),(18807,5,'nomme'),(18809,2,'consiste'),(18816,2,'extraire'),(18823,4,'jaunty'),(18824,4,'jackalope'),(18826,2,'arrive'),(18827,4,'x.org'),(18828,4,'risque'),(18833,6,'notifications'),(18835,4,'nouveaute'),(18836,2,'presence'),(18838,4,'synaptic'),(18840,6,'bouton'),(18842,2,'capture'),(18849,2,'officielle'),(18851,4,'installez'),(18852,4,'demandant'),(18857,4,'films'),(18860,2,'empecher'),(18873,4,'quelles'),(18876,4,'entrez'),(18877,2,'1000'),(18879,6,'touche'),(18889,2,'valeur'),(18892,4,'quatre'),(18894,2,'fasse'),(18895,4,'ajoutez'),(18896,2,'config'),(18898,2,'10000'),(18899,4,'curieux'),(18902,6,'interessantes'),(18904,4,'york'),(18919,10,'mark'),(18920,8,'shuttleworth'),(18924,6,'large'),(18929,9,'nos'),(18944,8,'considere'),(18946,8,'pourraient'),(18952,4,'mountain'),(18953,4,'californie'),(18965,4,'yeux'),(18970,4,'efforts'),(18974,6,'exploitation'),(18981,4,'reunion'),(18983,4,'certain'),(18985,4,'sud'),(19011,4,'pendant'),(19012,4,'sommet'),(19014,4,'argent'),(19015,8,'entreprises'),(19023,6,'fabricants'),(19025,4,'services'),(19031,6,'canonical'),(19035,4,'utilises'),(19040,14,'x'),(19043,4,'librement'),(19047,8,'proprietaire'),(19049,4,'beau'),(19077,4,'agreable'),(19083,8,'messagerie'),(19086,6,'feuilles'),(19087,6,'calcul'),(19090,6,'creees'),(19117,5,'laquelle'),(19120,3,'enthousiasme'),(19125,5,'force'),(19131,7,'contributeurs'),(19132,5,'personnes'),(19135,3,'disposition'),(19148,7,'technologies'),(19156,3,'controle'),(19157,3,'politique'),(19158,7,'ministere'),(19166,7,'espagnol'),(19170,5,'nationale'),(19179,6,'difficile'),(19181,3,'vice'),(19182,3,'president'),(19185,5,'permis'),(19193,5,'beneficie'),(19194,3,'prefere'),(19202,3,'accord'),(19206,3,'belle'),(19213,3,'universite'),(19214,3,'cap'),(19218,7,'conseil'),(19221,9,'puissent'),(19222,7,'tourner'),(19247,3,'promouvoir'),(19250,3,'participation'),(19267,5,'decline'),(19273,7,'26'),(19274,5,'peine'),(19277,3,'regarde'),(19284,5,'offert'),(19285,3,'bord'),(19300,7,'choses'),(19302,5,'impossibles'),(19307,5,'etats'),(19308,5,'unis'),(19311,3,'travailler'),(19312,5,'destine'),(19318,5,'impression'),(19335,5,'acheter'),(19345,5,'chiffre'),(19348,3,'inquieter'),(19351,4,'regulieres'),(19352,3,'auto'),(19354,3,'sommes'),(19364,7,'critiques'),(19369,7,'fournies'),(19370,5,'intel'),(19382,4,'travaille'),(19397,5,'largement'),(19400,5,'croit'),(19407,7,'pourra'),(19410,4,'philosophie'),(19411,2,'pourtant'),(19418,2,'terrain'),(19434,2,'haute'),(19444,5,'personnel'),(19446,2,'photo'),(19457,9,'faites'),(19462,5,'launchpad'),(19489,7,'gnome'),(19500,9,'apparait'),(19501,9,'dessus'),(19506,5,'obligation'),(19522,7,'rejoindre'),(19545,5,'total'),(19591,7,'monter'),(19638,5,'libres'),(19684,8,'cd'),(19686,4,'noyau'),(19701,4,'apparemment'),(19707,4,'souris'),(19708,6,'programmes'),(19712,4,'codecs'),(19714,6,'personne'),(19722,8,'melange'),(19726,4,'couleurs'),(19741,6,'usb'),(19790,6,'64'),(19832,6,'email'),(19875,3,'decouvert'),(19883,5,'sauvegarder'),(19896,5,'sauvegarde'),(19901,5,'accepte'),(19982,3,'corriger'),(20001,3,'designe'),(20088,3,'map'),(20090,5,'double'),(20208,2,'chat'),(20260,6,'u'),(20271,4,'savez'),(20273,4,'raison'),(20278,3,'cle'),(20279,3,'encfs'),(20280,3,'balader'),(20281,3,'personnelles'),(20282,3,'sensibles'),(20283,3,'intime'),(20284,3,'prudent'),(20285,3,'perdue'),(20286,3,'minimiser'),(20287,3,'tombent'),(20288,3,'mauvaises'),(20289,3,'invisibles'),(20290,3,'dir.sh'),(20291,3,'zenity'),(20292,3,'dediee'),(20293,5,'souhaitent'),(20294,3,'transporte'),(20295,3,'dechiffrer'),(20296,3,'chiffres'),(20297,3,'cryptkeeper'),(20298,3,'suffisant'),(20299,3,'suivent'),(20300,3,'root'),(20301,3,'mauvais'),(20302,3,'engendrer'),(20303,3,'effets'),(20304,3,'nefastes'),(20305,3,'inserez'),(20306,3,'cherchons'),(20307,3,'insere'),(20308,3,'memup'),(20309,3,'monte'),(20310,3,'preferez'),(20311,3,'preparatifs'),(20312,3,'coffre'),(20313,3,'executer'),(20314,3,'theorie'),(20315,3,'consacre'),(20316,3,'lancez'),(20317,3,'devenez'),(20318,4,'administrateur'),(20319,3,'su'),(20320,3,'testez'),(20321,3,'serez'),(20322,5,'devenu'),(20323,3,'nom_de_votre_cle'),(20324,3,'creez'),(20325,3,'repertoires'),(20326,3,'pwd'),(20327,3,'creating'),(20328,3,'encrypted'),(20329,3,'choose'),(20330,3,'enter'),(20331,4,'expert'),(20332,3,'configured'),(20333,3,'paranoia'),(20334,3,'anything'),(20335,3,'empty'),(20336,3,'select'),(20337,3,'prenne'),(20338,3,'parano'),(20339,3,'imposera'),(20340,3,'contraintes'),(20341,3,'demandera'),(20342,3,'entrer'),(20343,3,'utiliserez'),(20344,3,'souhaiterez'),(20345,3,'chiffrees'),(20346,3,'visibles'),(20347,3,'filesystem'),(20348,3,'remember'),(20349,3,'absolutely'),(20350,3,'recovery'),(20351,3,'changed'),(20352,3,'encfsctl'),(20353,3,'verify'),(20354,3,'inquietez'),(20355,3,'assise'),(20356,3,'espionne'),(20357,3,'jumelles'),(20358,3,'devinera'),(20359,3,'lettres'),(20360,3,'majuscule'),(20361,3,'minuscule'),(20362,3,'demonter'),(20363,3,'fusermount'),(20364,3,'puisse'),(20365,5,'aurez'),(20366,3,'voudrez'),(20367,3,'plugdev'),(20368,3,'fuse'),(20369,3,'sshfs'),(20370,3,'ajouteront'),(20371,3,'gpasswd'),(20372,3,'votre_utilisateur'),(20373,3,'telechargez'),(20374,3,'achraf.cherti.name'),(20375,3,'sh'),(20376,3,'nautilus'),(20377,3,'acceptez'),(20378,3,'sauvegardes'),(20379,3,'votreuser'),(20380,3,'save_usb_stick'),(20381,3,'precaution'),(20382,4,'personnaliser'),(20383,3,'ayez'),(20384,3,'encouragera'),(20385,3,'monterez'),(20386,3,'demonterez'),(20387,3,'sachez'),(20388,3,'globales'),(20389,3,'aimez'),(20390,3,'graphiquement'),(20391,3,'license'),(20392,3,'achraf'),(20393,3,'cherti'),(20394,3,'mount_dir'),(20395,3,'encrypted_dir'),(20396,3,'.coffre'),(20397,3,'save_dir'),(20398,3,'save_source_dir'),(20399,3,'chiffree'),(20400,3,'mettrez'),(20401,3,'do_save'),(20402,3,'ancienne'),(20403,3,'savegarde'),(20438,2,'demonstrations'),(20466,3,'fedora'),(20472,2,'amis'),(20525,2,'kde'),(20533,2,'profitez'),(20593,3,'tellement'),(20604,3,'resolution'),(20633,3,'tuer'),(20714,2,'player'),(20770,2,'voit'),(20780,2,'valeurs'),(20815,2,'proprio'),(20932,2,'exactement'),(21068,2,'appliquer'),(21185,2,'echelle'),(21411,1,'plugin'),(21450,1,'our'),(21494,1,'we'),(21502,1,'array'),(21567,1,'could'),(21596,1,'info'),(21602,1,'enterprise'),(21607,1,'40'),(21640,1,'function'),(21677,1,'loaded'),(21701,1,'quot'),(21709,1,'internal'),(21718,1,'chance'),(21784,1,'result'),(21815,1,'mail'),(21885,1,'dec'),(21914,1,'speed'),(21935,1,'transition'),(21950,1,'account'),(21974,1,'order'),(21982,1,'01'),(22002,1,'match'),(22019,1,'switch'),(22030,1,'extra'),(22080,1,'count'),(22085,1,'sun'),(22102,1,'path'),(22108,1,'5.3'),(22113,1,'drop'),(22121,1,'1.3'),(22122,1,'beta'),(22130,1,'r'),(22228,1,'wrap'),(22233,1,'experience'),(22302,1,'want'),(22313,1,'resource'),(22345,1,'ad'),(22346,1,'hoc'),(22364,1,'key'),(22366,1,'propre'),(22380,1,'expliquer'),(22385,1,'fonctionnement'),(22386,1,'soins'),(22387,1,'concretement'),(22389,1,'flux'),(22399,1,'connecter'),(22401,1,'avais'),(22404,1,'heure'),(22416,1,'installes'),(22417,1,'pouvoir'),(22423,1,'connect'),(22430,1,'active'),(22444,1,'relai'),(22454,2,'seule'),(22456,1,'voila'),(22464,1,'true'),(22465,1,'modification'),(22498,1,'streaming'),(22500,1,'analyse'),(22524,1,'gros'),(22529,1,'icone'),(22533,1,'explique'),(22540,1,'oriente'),(22548,1,'risques'),(22549,1,'minimes'),(22558,1,'capable'),(22570,1,'renvoie'),(22577,2,'pratique'),(22581,1,'gold'),(22587,1,'conseille'),(22591,1,'langage'),(22601,2,'www'),(22607,1,'ouvert'),(22610,1,'present'),(22620,1,'importante'),(22631,1,'stabilite'),(22641,1,'apprecier'),(22653,1,'attendre'),(22666,1,'limite'),(22690,1,'mesure'),(22794,1,'provoquer'),(22804,1,'aille'),(22813,1,'utilisent'),(22826,1,'technologie'),(23038,1,'technologiques'),(23039,1,'tels'),(23139,2,'planet'),(23243,1,'fr.org'),(23276,1,'tendance'),(23313,1,'professionnel'),(23649,1,'arreter'),(23831,1,'rss'),(23837,1,'annonces'),(23860,1,'partir'),(23893,1,'faite'),(23904,1,'document'),(23936,1,'francophones'),(23948,1,'text'),(23957,1,'v'),(23963,1,'principale'),(23968,1,'fera'),(23981,1,'bons'),(23987,1,'locaux'),(23993,1,'domaines'),(24015,1,'resoudre'),(24032,1,'vogue'),(24035,1,'adapte'),(24078,1,'rc1'),(24094,1,'synchronisation'),(24096,1,'recuperer'),(24100,1,'cesse'),(24143,1,'extrait'),(24281,1,'sert'),(24304,1,'expressions'),(24322,1,'desole'),(24338,1,'relatifs'),(24340,1,'tuto'),(24347,1,'renseigner'),(24378,2,'parametres'),(24387,1,'librairies'),(24390,1,'beneficier'),(24398,1,'interesses'),(24403,1,'lien'),(24405,1,'precedent'),(24406,1,'4.5'),(24428,1,'logo'),(24452,1,'regles'),(24462,1,'remi'),(24468,1,'caching'),(24478,1,'yum'),(24499,1,'stockees'),(24509,1,'voire'),(24513,1,'tenait'),(24542,1,'5.0'),(24550,1,'edite'),(24556,1,'copie'),(24635,1,'unique'),(24644,1,'data'),(24653,1,'logique'),(24672,1,'oblige'),(24673,1,'repondant'),(24674,1,'bot'),(24677,1,'tourne'),(24707,1,'particuliere'),(24721,1,'finir'),(24722,1,'certifie'),(24741,1,'html'),(24754,1,'aurait'),(24758,1,'avaient'),(24790,1,'translation'),(24792,1,'program'),(24797,1,'website'),(24814,1,'dernierement'),(24915,1,'fais'),(24943,1,'avantage'),(24947,1,'revoir'),(24961,1,'odt'),(24964,1,'correspond'),(24966,1,'eau'),(24969,1,'repond'),(24970,1,'problematique'),(24975,1,'necessitant'),(24981,1,'prochains'),(24995,1,'forte'),(25053,1,'parisien'),(25149,1,'inclus'),(25151,1,'refonte'),(25175,1,'portail'),(25252,1,'statique'),(25382,1,'bloc'),(25407,1,'accueil'),(25531,1,'suivie'),(25560,1,'w3c'),(25599,1,'etendre'),(25649,1,'nettoyer'),(25671,1,'pdf'),(25730,1,'perso'),(25739,1,'institutionnels'),(25848,1,'utilisees'),(25895,1,'socle'),(25914,1,'etude'),(26061,1,'extranet'),(26181,1,'svn'),(26230,1,'ezdhtml'),(26317,1,'air'),(26408,1,'manque'),(26415,1,'blocs'),(26701,1,'lignes'),(26822,1,'kaliop'),(27050,1,'regrouper'),(27535,1,'portage'),(27666,1,'reverse'),(27673,1,'reecriture'),(27700,1,'ezfluxbb'),(27705,1,'fluxbb'),(27706,1,'trac'),(27707,1,'telechargeable'),(28073,1,'dpobel'),(28074,1,'free.fr');
/*!40000 ALTER TABLE `ezsearch_word` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezsection`
--

DROP TABLE IF EXISTS `ezsection`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezsection` (
  `id` int(11) NOT NULL auto_increment,
  `locale` varchar(255) default NULL,
  `name` varchar(255) default NULL,
  `navigation_part_identifier` varchar(100) default 'ezcontentnavigationpart',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezsection`
--

LOCK TABLES `ezsection` WRITE;
/*!40000 ALTER TABLE `ezsection` DISABLE KEYS */;
INSERT INTO `ezsection` VALUES (1,'','Standard','ezcontentnavigationpart'),(2,'','Users','ezusernavigationpart'),(3,'','Media','ezmedianavigationpart'),(4,'','Setup','ezsetupnavigationpart'),(5,'','Design','ezvisualnavigationpart');
/*!40000 ALTER TABLE `ezsection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezsession`
--

DROP TABLE IF EXISTS `ezsession`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezsession` (
  `data` longtext NOT NULL,
  `expiration_time` int(11) NOT NULL default '0',
  `session_key` varchar(32) NOT NULL default '',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`session_key`),
  KEY `expiration_time` (`expiration_time`),
  KEY `ezsession_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezsession`
--

LOCK TABLES `ezsession` WRITE;
/*!40000 ALTER TABLE `ezsession` DISABLE KEYS */;
INSERT INTO `ezsession` VALUES ('LastAccessedModifyingURI|s:14:\"/setup/session\";eZUserInfoCache_Timestamp|i:1232457050;eZUserGroupsCache_Timestamp|i:1232457046;eZRoleIDList_Timestamp|i:1232457034;eZRoleLimitationValueList_Timestamp|i:1232457034;AccessArrayTimestamp|i:1232457050;eZUserDiscountRulesTimestamp|i:1232456801;eZUserDiscountRules14|a:0:{}eZGlobalSection|a:1:{s:2:\"id\";s:1:\"1\";}LastAccessesURI|s:0:\"\";CurrentViewMode|s:4:\"full\";ContentNodeID|s:3:\"141\";ContentObjectID|s:3:\"142\";DeleteIDArray|a:9:{i:0;s:3:\"183\";i:1;s:3:\"186\";i:2;s:3:\"194\";i:3;s:3:\"211\";i:4;s:3:\"221\";i:5;s:3:\"465\";i:6;s:2:\"59\";i:7;s:2:\"60\";i:8;s:2:\"61\";}userRedirectURIReverseRelatedList|s:21:\"/content/removeobject\";force_logout|i:1;AccessArray|a:1:{s:1:\"*\";a:1:{s:1:\"*\";a:1:{s:1:\"*\";s:1:\"*\";}}}eZUserLoggedInID|s:2:\"14\";eZUserInfoCache|a:1:{i:14;a:5:{s:16:\"contentobject_id\";s:2:\"14\";s:5:\"login\";s:5:\"admin\";s:5:\"email\";s:14:\"dpobel@free.fr\";s:13:\"password_hash\";s:32:\"e80f9bf12931844ee153b4fe49940afd\";s:18:\"password_hash_type\";s:1:\"2\";}}eZUserGroupsCache|a:2:{i:0;s:2:\"12\";i:1;s:1:\"4\";}eZRoleLimitationValueList|a:1:{i:0;s:0:\"\";}eZRoleIDList|a:1:{i:0;s:1:\"2\";}eZPreferences|a:19:{s:24:\"admin_navigation_content\";s:1:\"1\";s:22:\"admin_navigation_roles\";s:1:\"1\";s:25:\"admin_navigation_policies\";s:1:\"1\";s:16:\"admin_list_limit\";s:1:\"1\";s:14:\"admin_treemenu\";s:1:\"1\";s:19:\"admin_bookmark_menu\";s:1:\"1\";s:29:\"admin_navigation_class_groups\";s:1:\"1\";s:23:\"admin_children_viewmode\";s:4:\"list\";s:21:\"admin_clearcache_menu\";s:1:\"1\";s:21:\"admin_clearcache_type\";s:11:\"ContentNode\";s:22:\"admin_classlists_limit\";s:1:\"3\";s:24:\"admin_navigation_details\";b:0;s:26:\"admin_navigation_locations\";b:0;s:26:\"admin_navigation_relations\";b:0;s:29:\"admin_navigation_translations\";b:0;s:24:\"admin_quicksettings_menu\";b:0;s:21:\"admin_left_menu_width\";b:0;s:25:\"admin_edit_show_locations\";b:0;s:23:\"admin_edit_show_re_edit\";b:0;}',1232716257,'ab5bc84afc2ba757c9455e7ed93d3db2',14);
/*!40000 ALTER TABLE `ezsession` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezsite_data`
--

DROP TABLE IF EXISTS `ezsite_data`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezsite_data` (
  `name` varchar(60) NOT NULL default '',
  `value` longtext NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezsite_data`
--

LOCK TABLES `ezsite_data` WRITE;
/*!40000 ALTER TABLE `ezsite_data` DISABLE KEYS */;
INSERT INTO `ezsite_data` VALUES ('ezpublish-release','1'),('ezpublish-version','4.0.1');
/*!40000 ALTER TABLE `ezsite_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezsubtree_notification_rule`
--

DROP TABLE IF EXISTS `ezsubtree_notification_rule`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezsubtree_notification_rule` (
  `id` int(11) NOT NULL auto_increment,
  `node_id` int(11) NOT NULL default '0',
  `use_digest` int(11) default '0',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ezsubtree_notification_rule_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezsubtree_notification_rule`
--

LOCK TABLES `ezsubtree_notification_rule` WRITE;
/*!40000 ALTER TABLE `ezsubtree_notification_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezsubtree_notification_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eztipafriend_counter`
--

DROP TABLE IF EXISTS `eztipafriend_counter`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `eztipafriend_counter` (
  `count` int(11) NOT NULL default '0',
  `node_id` int(11) NOT NULL default '0',
  `requested` int(11) NOT NULL default '0',
  PRIMARY KEY  (`node_id`,`requested`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `eztipafriend_counter`
--

LOCK TABLES `eztipafriend_counter` WRITE;
/*!40000 ALTER TABLE `eztipafriend_counter` DISABLE KEYS */;
/*!40000 ALTER TABLE `eztipafriend_counter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eztipafriend_request`
--

DROP TABLE IF EXISTS `eztipafriend_request`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `eztipafriend_request` (
  `created` int(11) NOT NULL default '0',
  `email_receiver` varchar(100) NOT NULL default '',
  KEY `eztipafriend_request_created` (`created`),
  KEY `eztipafriend_request_email_rec` (`email_receiver`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `eztipafriend_request`
--

LOCK TABLES `eztipafriend_request` WRITE;
/*!40000 ALTER TABLE `eztipafriend_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `eztipafriend_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eztrigger`
--

DROP TABLE IF EXISTS `eztrigger`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `eztrigger` (
  `connect_type` char(1) NOT NULL default '',
  `function_name` varchar(200) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `module_name` varchar(200) NOT NULL default '',
  `name` varchar(255) default NULL,
  `workflow_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `eztrigger_def_id` (`module_name`(50),`function_name`(50),`connect_type`),
  KEY `eztrigger_fetch` (`name`(25),`module_name`(50),`function_name`(50))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `eztrigger`
--

LOCK TABLES `eztrigger` WRITE;
/*!40000 ALTER TABLE `eztrigger` DISABLE KEYS */;
/*!40000 ALTER TABLE `eztrigger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezurl`
--

DROP TABLE IF EXISTS `ezurl`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezurl` (
  `created` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `is_valid` int(11) NOT NULL default '1',
  `last_checked` int(11) NOT NULL default '0',
  `modified` int(11) NOT NULL default '0',
  `original_url_md5` varchar(32) NOT NULL default '',
  `url` longtext,
  PRIMARY KEY  (`id`),
  KEY `ezurl_url` (`url`(255))
) ENGINE=InnoDB AUTO_INCREMENT=428 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezurl`
--

LOCK TABLES `ezurl` WRITE;
/*!40000 ALTER TABLE `ezurl` DISABLE KEYS */;
INSERT INTO `ezurl` VALUES (1232290544,245,1,0,1232290544,'6f5a1226a33a468640fa1e8e029c45f5','http://fr.wikipedia.org/wiki/Planet'),(1232292050,246,1,0,1232292050,'153440470f712ce353cdd5eeff9cd18f','http://pwet.fr/cv'),(1232319435,388,1,0,1232319435,'d2be3bb903b0b7de8303dfea1cada332','http://ez.no/ezpublish'),(1232319435,389,1,0,1232319435,'1ce3be01518c0b968e3401cc45299cfe','http://ezcomponents.org');
/*!40000 ALTER TABLE `ezurl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezurl_object_link`
--

DROP TABLE IF EXISTS `ezurl_object_link`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezurl_object_link` (
  `contentobject_attribute_id` int(11) NOT NULL default '0',
  `contentobject_attribute_version` int(11) NOT NULL default '0',
  `url_id` int(11) NOT NULL default '0',
  KEY `ezurl_ol_coa_id` (`contentobject_attribute_id`),
  KEY `ezurl_ol_coa_version` (`contentobject_attribute_version`),
  KEY `ezurl_ol_url_id` (`url_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezurl_object_link`
--

LOCK TABLES `ezurl_object_link` WRITE;
/*!40000 ALTER TABLE `ezurl_object_link` DISABLE KEYS */;
INSERT INTO `ezurl_object_link` VALUES (667,3,245),(667,4,245),(667,5,245),(667,5,246),(667,6,245),(667,6,246),(667,7,245),(667,7,388),(667,7,389),(667,7,246);
/*!40000 ALTER TABLE `ezurl_object_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezurlalias`
--

DROP TABLE IF EXISTS `ezurlalias`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezurlalias` (
  `destination_url` longtext NOT NULL,
  `forward_to_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `is_imported` int(11) NOT NULL default '0',
  `is_internal` int(11) NOT NULL default '1',
  `is_wildcard` int(11) NOT NULL default '0',
  `source_md5` varchar(32) default NULL,
  `source_url` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `ezurlalias_desturl` (`destination_url`(200)),
  KEY `ezurlalias_forward_to_id` (`forward_to_id`),
  KEY `ezurlalias_imp_wcard_fwd` (`is_imported`,`is_wildcard`,`forward_to_id`),
  KEY `ezurlalias_source_md5` (`source_md5`),
  KEY `ezurlalias_source_url` (`source_url`(255)),
  KEY `ezurlalias_wcard_fwd` (`is_wildcard`,`forward_to_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezurlalias`
--

LOCK TABLES `ezurlalias` WRITE;
/*!40000 ALTER TABLE `ezurlalias` DISABLE KEYS */;
INSERT INTO `ezurlalias` VALUES ('content/view/full/2',0,12,1,1,0,'d41d8cd98f00b204e9800998ecf8427e',''),('content/view/full/5',0,13,1,1,0,'9bc65c2abec141778ffaa729489f3e87','users'),('content/view/full/12',0,15,1,1,0,'02d4e844e3a660857a3f81585995ffe1','users/guest_accounts'),('content/view/full/13',0,16,1,1,0,'1b1d79c16700fd6003ea7be233e754ba','users/administrator_users'),('content/view/full/14',0,17,1,1,0,'0bb9dd665c96bbc1cf36b79180786dea','users/editors'),('content/view/full/15',0,18,1,1,0,'f1305ac5f327a19b451d82719e0c3f5d','users/administrator_users/administrator_user'),('content/view/full/43',0,20,1,1,0,'62933a2951ef01f4eafd9bdf4d3cd2f0','media'),('content/view/full/44',0,21,1,1,0,'3ae1aac958e1c82013689d917d34967a','users/anonymous_users'),('content/view/full/45',0,22,1,1,0,'aad93975f09371695ba08292fd9698db','users/anonymous_users/anonymous_user'),('content/view/full/48',0,25,1,1,0,'a0f848942ce863cf53c0fa6cc684007d','setup'),('content/view/full/50',0,27,1,1,0,'c60212835de76414f9bfd21eecb8f221','foo_bar_folder/images/vbanner'),('content/view/full/51',0,28,1,1,0,'38985339d4a5aadfc41ab292b4527046','media/images'),('content/view/full/52',0,29,1,1,0,'ad5a8c6f6aac3b1b9df267fe22e7aef6','media/files'),('content/view/full/53',0,30,1,1,0,'562a0ac498571c6c3529173184a2657c','media/multimedia'),('content/view/full/54',0,31,1,1,0,'e501fe6c81ed14a5af2b322d248102d8','setup/common_ini_settings'),('content/view/full/56',0,32,1,1,0,'2dd3db5dc7122ea5f3ee539bb18fe97d','design/ez_publish'),('content/view/full/58',0,33,1,1,0,'31c13f47ad87dd7baa2d558a91e0fbb9','design');
/*!40000 ALTER TABLE `ezurlalias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezurlalias_ml`
--

DROP TABLE IF EXISTS `ezurlalias_ml`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezurlalias_ml` (
  `action` longtext NOT NULL,
  `action_type` varchar(32) NOT NULL default '',
  `alias_redirects` int(11) NOT NULL default '1',
  `id` int(11) NOT NULL default '0',
  `is_alias` int(11) NOT NULL default '0',
  `is_original` int(11) NOT NULL default '0',
  `lang_mask` int(11) NOT NULL default '0',
  `link` int(11) NOT NULL default '0',
  `parent` int(11) NOT NULL default '0',
  `text` longtext NOT NULL,
  `text_md5` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`parent`,`text_md5`),
  KEY `ezurlalias_ml_act_org` (`action`(32),`is_original`),
  KEY `ezurlalias_ml_action` (`action`(32),`id`,`link`),
  KEY `ezurlalias_ml_actt` (`action_type`),
  KEY `ezurlalias_ml_actt_org_al` (`action_type`,`is_original`,`is_alias`),
  KEY `ezurlalias_ml_id` (`id`),
  KEY `ezurlalias_ml_par_act_id_lnk` (`parent`,`action`(32),`id`,`link`),
  KEY `ezurlalias_ml_par_lnk_txt` (`parent`,`link`,`text`(32)),
  KEY `ezurlalias_ml_par_txt` (`parent`,`text`(32)),
  KEY `ezurlalias_ml_text` (`text`(32),`id`,`link`),
  KEY `ezurlalias_ml_text_lang` (`text`(32),`lang_mask`,`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezurlalias_ml`
--

LOCK TABLES `ezurlalias_ml` WRITE;
/*!40000 ALTER TABLE `ezurlalias_ml` DISABLE KEYS */;
INSERT INTO `ezurlalias_ml` VALUES ('nop:','nop',1,14,0,0,1,14,0,'foo_bar_folder','0288b6883046492fa92e4a84eb67acc9'),('eznode:220','eznode',1,166,0,1,2,166,0,'contact','2f8a6bf31f3bd67bd2d9720c58b19c9a'),('eznode:58','eznode',1,25,0,1,3,25,0,'Design','31c13f47ad87dd7baa2d558a91e0fbb9'),('eznode:140','eznode',1,83,0,0,3,82,0,'liens','3565ea81182966096c3cdcbf6d107414'),('eznode:48','eznode',1,13,0,1,3,13,0,'Setup2','475e97c0146bfb1c490339546d9e72ee'),('nop:','nop',1,17,0,0,1,17,0,'media2','50e2736330de124f6edea9b008556fe6'),('eznode:141','eznode',1,84,0,1,3,84,0,'blogs','51704a6cacf71c8d5211445d9e80515f'),('eznode:43','eznode',1,9,0,1,3,9,0,'Media','62933a2951ef01f4eafd9bdf4d3cd2f0'),('nop:','nop',1,21,0,0,1,21,0,'setup3','732cefcf28bf4547540609fb1a786a30'),('nop:','nop',1,3,0,0,1,3,0,'users2','86425c35a33507d479f71ade53a669aa'),('eznode:5','eznode',1,2,0,1,3,2,0,'Users','9bc65c2abec141778ffaa729489f3e87'),('eznode:140','eznode',1,82,0,1,3,82,0,'planetarium','cd93b24c55a6fee602783106e32f1076'),('eznode:2','eznode',1,1,0,1,2,1,0,'','d41d8cd98f00b204e9800998ecf8427e'),('eznode:219','eznode',1,165,0,1,2,165,0,'a-propos','d5e9d68a6c602092ff215af11cc426a9'),('eznode:14','eznode',1,6,0,1,3,6,2,'Editors','a147e136bfa717592f2bd70bd4b53b17'),('eznode:44','eznode',1,10,0,1,3,10,2,'Anonymous-Users','c2803c3fa1b0b5423237b4e018cae755'),('eznode:12','eznode',1,4,0,1,3,4,2,'Guest-accounts','e57843d836e3af8ab611fde9e2139b3a'),('eznode:13','eznode',1,5,0,1,3,5,2,'Administrator-users','f89fad7f8a3abc8c09e1deb46a420007'),('nop:','nop',1,11,0,0,1,11,3,'anonymous_users2','505e93077a6dde9034ad97a14ab022b1'),('eznode:12','eznode',1,26,0,0,1,4,3,'guest_accounts','70bb992820e73638731aa8de79b3329e'),('eznode:14','eznode',1,29,0,0,1,6,3,'editors','a147e136bfa717592f2bd70bd4b53b17'),('nop:','nop',1,7,0,0,1,7,3,'administrator_users2','a7da338c20bf65f9f789c87296379c2a'),('eznode:13','eznode',1,27,0,0,1,5,3,'administrator_users','aeb8609aa933b0899aa012c71139c58c'),('eznode:44','eznode',1,30,0,0,1,10,3,'anonymous_users','e9e5ad0c05ee1a43715572e5cc545926'),('eznode:15','eznode',1,167,0,0,3,36,5,'Administrator-User','5a9d7b0ec93173ef4fedee023209cb61'),('eznode:15','eznode',1,36,0,1,3,36,5,'administrateur-planet','717bea4d21fbcb87fc8288c1e030cfc1'),('eznode:15','eznode',1,8,0,0,3,36,5,'Damien-POBEL','e207082dd2c65803a04719b4525cf530'),('eznode:15','eznode',1,28,0,0,0,8,7,'administrator_user','a3cca2de936df1e2f805710399989971'),('eznode:53','eznode',1,20,0,1,3,20,9,'Multimedia','2e5bc8831f7ae6a29530e7f1bbf2de9c'),('eznode:52','eznode',1,19,0,1,3,19,9,'Files','45b963397aa40d4a0063e0d85e4fe7a1'),('eznode:51','eznode',1,18,0,1,3,18,9,'Images','59b514174bffe4ae402b3d63aad79fe0'),('eznode:45','eznode',1,12,0,1,3,12,10,'Anonymous-User','ccb62ebca03a31272430bc414bd5cd5b'),('eznode:45','eznode',1,31,0,0,1,12,11,'anonymous_user','c593ec85293ecb0e02d50d4c5c6c20eb'),('eznode:54','eznode',1,22,0,1,2,22,13,'Common-INI-settings','4434993ac013ae4d54bb1f51034d6401'),('nop:','nop',1,15,0,0,1,15,14,'images','59b514174bffe4ae402b3d63aad79fe0'),('eznode:50','eznode',1,16,0,1,2,16,15,'vbanner','c54e2d1b93642e280bdc5d99eab2827d'),('eznode:53','eznode',1,34,0,0,1,20,17,'multimedia','2e5bc8831f7ae6a29530e7f1bbf2de9c'),('eznode:52','eznode',1,33,0,0,1,19,17,'files','45b963397aa40d4a0063e0d85e4fe7a1'),('eznode:51','eznode',1,32,0,0,1,18,17,'images','59b514174bffe4ae402b3d63aad79fe0'),('eznode:54','eznode',1,35,0,0,1,22,21,'common_ini_settings','e59d6834e86cee752ed841f9cd8d5baf'),('eznode:56','eznode',1,24,0,1,2,24,25,'eZ-publish','10e4c3cb527fb9963258469986c16240');
/*!40000 ALTER TABLE `ezurlalias_ml` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezurlwildcard`
--

DROP TABLE IF EXISTS `ezurlwildcard`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezurlwildcard` (
  `destination_url` longtext NOT NULL,
  `id` int(11) NOT NULL auto_increment,
  `source_url` longtext NOT NULL,
  `type` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezurlwildcard`
--

LOCK TABLES `ezurlwildcard` WRITE;
/*!40000 ALTER TABLE `ezurlwildcard` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezurlwildcard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezuser`
--

DROP TABLE IF EXISTS `ezuser`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezuser` (
  `contentobject_id` int(11) NOT NULL default '0',
  `email` varchar(150) NOT NULL default '',
  `login` varchar(150) NOT NULL default '',
  `password_hash` varchar(50) default NULL,
  `password_hash_type` int(11) NOT NULL default '1',
  PRIMARY KEY  (`contentobject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezuser`
--

LOCK TABLES `ezuser` WRITE;
/*!40000 ALTER TABLE `ezuser` DISABLE KEYS */;
INSERT INTO `ezuser` VALUES (10,'nospam@ez.no','anonymous','4e6f6184135228ccd45f8233d72a0363',2),(14,'dpobel@free.fr','admin','e80f9bf12931844ee153b4fe49940afd',2);
/*!40000 ALTER TABLE `ezuser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezuser_accountkey`
--

DROP TABLE IF EXISTS `ezuser_accountkey`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezuser_accountkey` (
  `hash_key` varchar(32) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `time` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezuser_accountkey`
--

LOCK TABLES `ezuser_accountkey` WRITE;
/*!40000 ALTER TABLE `ezuser_accountkey` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezuser_accountkey` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezuser_discountrule`
--

DROP TABLE IF EXISTS `ezuser_discountrule`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezuser_discountrule` (
  `contentobject_id` int(11) default NULL,
  `discountrule_id` int(11) default NULL,
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezuser_discountrule`
--

LOCK TABLES `ezuser_discountrule` WRITE;
/*!40000 ALTER TABLE `ezuser_discountrule` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezuser_discountrule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezuser_role`
--

DROP TABLE IF EXISTS `ezuser_role`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezuser_role` (
  `contentobject_id` int(11) default NULL,
  `id` int(11) NOT NULL auto_increment,
  `limit_identifier` varchar(255) default '',
  `limit_value` varchar(255) default '',
  `role_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `ezuser_role_contentobject_id` (`contentobject_id`),
  KEY `ezuser_role_role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezuser_role`
--

LOCK TABLES `ezuser_role` WRITE;
/*!40000 ALTER TABLE `ezuser_role` DISABLE KEYS */;
INSERT INTO `ezuser_role` VALUES (12,25,'','',2),(11,28,'','',1),(42,31,'','',1),(13,32,'Subtree','/1/2/',3),(13,33,'Subtree','/1/43/',3);
/*!40000 ALTER TABLE `ezuser_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezuser_setting`
--

DROP TABLE IF EXISTS `ezuser_setting`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezuser_setting` (
  `is_enabled` int(11) NOT NULL default '0',
  `max_login` int(11) default NULL,
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezuser_setting`
--

LOCK TABLES `ezuser_setting` WRITE;
/*!40000 ALTER TABLE `ezuser_setting` DISABLE KEYS */;
INSERT INTO `ezuser_setting` VALUES (1,1000,10),(1,10,14);
/*!40000 ALTER TABLE `ezuser_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezuservisit`
--

DROP TABLE IF EXISTS `ezuservisit`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezuservisit` (
  `current_visit_timestamp` int(11) NOT NULL default '0',
  `failed_login_attempts` int(11) NOT NULL default '0',
  `last_visit_timestamp` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezuservisit`
--

LOCK TABLES `ezuservisit` WRITE;
/*!40000 ALTER TABLE `ezuservisit` DISABLE KEYS */;
INSERT INTO `ezuservisit` VALUES (1232457034,0,1232456801,14);
/*!40000 ALTER TABLE `ezuservisit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezvatrule`
--

DROP TABLE IF EXISTS `ezvatrule`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezvatrule` (
  `country_code` varchar(255) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `vat_type` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezvatrule`
--

LOCK TABLES `ezvatrule` WRITE;
/*!40000 ALTER TABLE `ezvatrule` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezvatrule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezvatrule_product_category`
--

DROP TABLE IF EXISTS `ezvatrule_product_category`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezvatrule_product_category` (
  `product_category_id` int(11) NOT NULL default '0',
  `vatrule_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`vatrule_id`,`product_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezvatrule_product_category`
--

LOCK TABLES `ezvatrule_product_category` WRITE;
/*!40000 ALTER TABLE `ezvatrule_product_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezvatrule_product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezvattype`
--

DROP TABLE IF EXISTS `ezvattype`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezvattype` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `percentage` float default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezvattype`
--

LOCK TABLES `ezvattype` WRITE;
/*!40000 ALTER TABLE `ezvattype` DISABLE KEYS */;
INSERT INTO `ezvattype` VALUES (1,'Std',0);
/*!40000 ALTER TABLE `ezvattype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezview_counter`
--

DROP TABLE IF EXISTS `ezview_counter`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezview_counter` (
  `count` int(11) NOT NULL default '0',
  `node_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezview_counter`
--

LOCK TABLES `ezview_counter` WRITE;
/*!40000 ALTER TABLE `ezview_counter` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezview_counter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezwaituntildatevalue`
--

DROP TABLE IF EXISTS `ezwaituntildatevalue`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezwaituntildatevalue` (
  `contentclass_attribute_id` int(11) NOT NULL default '0',
  `contentclass_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `workflow_event_id` int(11) NOT NULL default '0',
  `workflow_event_version` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`,`workflow_event_id`,`workflow_event_version`),
  KEY `ezwaituntildateevalue_wf_ev_id_wf_ver` (`workflow_event_id`,`workflow_event_version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezwaituntildatevalue`
--

LOCK TABLES `ezwaituntildatevalue` WRITE;
/*!40000 ALTER TABLE `ezwaituntildatevalue` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezwaituntildatevalue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezwishlist`
--

DROP TABLE IF EXISTS `ezwishlist`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezwishlist` (
  `id` int(11) NOT NULL auto_increment,
  `productcollection_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezwishlist`
--

LOCK TABLES `ezwishlist` WRITE;
/*!40000 ALTER TABLE `ezwishlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezwishlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezworkflow`
--

DROP TABLE IF EXISTS `ezworkflow`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezworkflow` (
  `created` int(11) NOT NULL default '0',
  `creator_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `is_enabled` int(11) NOT NULL default '0',
  `modified` int(11) NOT NULL default '0',
  `modifier_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `version` int(11) NOT NULL default '0',
  `workflow_type_string` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezworkflow`
--

LOCK TABLES `ezworkflow` WRITE;
/*!40000 ALTER TABLE `ezworkflow` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezworkflow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezworkflow_assign`
--

DROP TABLE IF EXISTS `ezworkflow_assign`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezworkflow_assign` (
  `access_type` int(11) NOT NULL default '0',
  `as_tree` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `node_id` int(11) NOT NULL default '0',
  `workflow_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezworkflow_assign`
--

LOCK TABLES `ezworkflow_assign` WRITE;
/*!40000 ALTER TABLE `ezworkflow_assign` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezworkflow_assign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezworkflow_event`
--

DROP TABLE IF EXISTS `ezworkflow_event`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezworkflow_event` (
  `data_int1` int(11) default NULL,
  `data_int2` int(11) default NULL,
  `data_int3` int(11) default NULL,
  `data_int4` int(11) default NULL,
  `data_text1` varchar(50) default NULL,
  `data_text2` varchar(50) default NULL,
  `data_text3` varchar(50) default NULL,
  `data_text4` varchar(50) default NULL,
  `description` varchar(50) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `placement` int(11) NOT NULL default '0',
  `version` int(11) NOT NULL default '0',
  `workflow_id` int(11) NOT NULL default '0',
  `workflow_type_string` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezworkflow_event`
--

LOCK TABLES `ezworkflow_event` WRITE;
/*!40000 ALTER TABLE `ezworkflow_event` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezworkflow_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezworkflow_group`
--

DROP TABLE IF EXISTS `ezworkflow_group`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezworkflow_group` (
  `created` int(11) NOT NULL default '0',
  `creator_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `modified` int(11) NOT NULL default '0',
  `modifier_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezworkflow_group`
--

LOCK TABLES `ezworkflow_group` WRITE;
/*!40000 ALTER TABLE `ezworkflow_group` DISABLE KEYS */;
INSERT INTO `ezworkflow_group` VALUES (1024392098,14,1,1024392098,14,'Standard');
/*!40000 ALTER TABLE `ezworkflow_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezworkflow_group_link`
--

DROP TABLE IF EXISTS `ezworkflow_group_link`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezworkflow_group_link` (
  `group_id` int(11) NOT NULL default '0',
  `group_name` varchar(255) default NULL,
  `workflow_id` int(11) NOT NULL default '0',
  `workflow_version` int(11) NOT NULL default '0',
  PRIMARY KEY  (`workflow_id`,`group_id`,`workflow_version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezworkflow_group_link`
--

LOCK TABLES `ezworkflow_group_link` WRITE;
/*!40000 ALTER TABLE `ezworkflow_group_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezworkflow_group_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ezworkflow_process`
--

DROP TABLE IF EXISTS `ezworkflow_process`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ezworkflow_process` (
  `activation_date` int(11) default NULL,
  `content_id` int(11) NOT NULL default '0',
  `content_version` int(11) NOT NULL default '0',
  `created` int(11) NOT NULL default '0',
  `event_id` int(11) NOT NULL default '0',
  `event_position` int(11) NOT NULL default '0',
  `event_state` int(11) default NULL,
  `event_status` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `last_event_id` int(11) NOT NULL default '0',
  `last_event_position` int(11) NOT NULL default '0',
  `last_event_status` int(11) NOT NULL default '0',
  `memento_key` varchar(32) default NULL,
  `modified` int(11) NOT NULL default '0',
  `node_id` int(11) NOT NULL default '0',
  `parameters` longtext,
  `process_key` varchar(32) NOT NULL default '',
  `session_key` varchar(32) NOT NULL default '0',
  `status` int(11) default NULL,
  `user_id` int(11) NOT NULL default '0',
  `workflow_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ezworkflow_process_process_key` (`process_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ezworkflow_process`
--

LOCK TABLES `ezworkflow_process` WRITE;
/*!40000 ALTER TABLE `ezworkflow_process` DISABLE KEYS */;
/*!40000 ALTER TABLE `ezworkflow_process` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-01-20 13:11:06
