# Host: localhost  (Version: 5.5.16)
# Date: 2013-12-16 16:10:01
# Generator: MySQL-Front 5.3  (Build 4.75)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "tblperusahaan"
#

DROP TABLE IF EXISTS `tblperusahaan`;
CREATE TABLE `tblperusahaan` (
  `idPerusahaan` int(11) NOT NULL AUTO_INCREMENT,
  `kodeperusahaan` varchar(10) NOT NULL DEFAULT '',
  `namaperusahaan` varchar(100) DEFAULT NULL,
  `creator` char(10) DEFAULT NULL,
  `modifier` char(10) DEFAULT NULL,
  `tgl_creator` datetime DEFAULT NULL,
  `tgl_modifier` datetime DEFAULT NULL,
  PRIMARY KEY (`idPerusahaan`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Data for table "tblperusahaan"
#

INSERT INTO `tblperusahaan` VALUES (1,'SUPERADMIN','SUPERADMIN',NULL,NULL,NULL,NULL),(2,'KDL','PT. Krakatau Daya Listrik',NULL,NULL,NULL,NULL),(3,'KE','PT. Krakatau Enginering',NULL,NULL,NULL,NULL),(4,'KHI','PT. KHI Pipe & Coating',NULL,NULL,NULL,NULL),(5,'KIEC','PT. Krakatau Industrial Estate',NULL,NULL,NULL,NULL),(6,'KIT','PT. Krakatau Information Technology',NULL,NULL,NULL,NULL),(7,'KM','PT. Krakatau Medika Hospital',NULL,NULL,NULL,NULL),(8,'KNR','PT. Krakatau Nasional Resources',NULL,NULL,NULL,NULL),(9,'KS','PT. Krakatau Steel Tbk.',NULL,NULL,NULL,NULL),(10,'KBS','PT. Krakatau Bandar Samudra',NULL,NULL,NULL,NULL),(11,'KTI','PT. Krakatau Tirta Industri',NULL,NULL,NULL,NULL),(12,'KW','PT. Krakatau Wajatama',NULL,NULL,NULL,NULL),(13,'MJIS','PT. Meratus Jaya Iron Steel',NULL,NULL,NULL,NULL),(14,'DPKS','Dana Pensiun KS',NULL,NULL,NULL,NULL),(15,'YPKS','Yayasan Pensiun KS',NULL,NULL,NULL,NULL);
