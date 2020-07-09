# Host: localhost  (Version: 5.5.16)
# Date: 2013-12-17 10:36:02
# Generator: MySQL-Front 5.3  (Build 4.75)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "sys_group"
#

DROP TABLE IF EXISTS `sys_group`;
CREATE TABLE `sys_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) DEFAULT NULL,
  `add` varchar(1) DEFAULT NULL,
  `edit` varchar(30) DEFAULT NULL,
  `delete` varchar(1) DEFAULT NULL,
  `approve` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Data for table "sys_group"
#

INSERT INTO `sys_group` VALUES (1,'Superadmin','1','1','1','0'),(2,'KS Group','1','1','1','0'),(3,'Admin Perusahaan','1','1','1','0'),(4,'Perusahaan','0','0','0','0'),(5,'Sub Direktorat','0','0','0','0'),(6,'Unit','0','0','0','0'),(7,'Personal','1','1','1','0');
