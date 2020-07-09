# Host: 10.0.1.41  (Version: 5.5.27)
# Date: 2013-12-16 15:37:35
# Generator: MySQL-Front 5.3  (Build 4.75)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "tbldirektorat"
#

DROP TABLE IF EXISTS `tbldirektorat`;
CREATE TABLE `tbldirektorat` (
  `kodedirektorat` char(15) NOT NULL DEFAULT '',
  `namadirektorat` char(40) NOT NULL DEFAULT '',
  `kodeperusahaan` char(8) NOT NULL DEFAULT '',
  `creator` char(10) DEFAULT NULL,
  `modifier` char(10) DEFAULT NULL,
  `tgl_creator` datetime DEFAULT NULL,
  `tgl_modifier` datetime DEFAULT NULL,
  PRIMARY KEY (`kodedirektorat`,`kodeperusahaan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "tbldirektorat"
#

INSERT INTO `tbldirektorat` VALUES ('1','Non Direktorat','KIT',NULL,NULL,NULL,NULL),('1','DIREKTUR UTAMA','KS',NULL,NULL,NULL,NULL),('2','Direktorat Komersial','KIT',NULL,NULL,NULL,NULL),('2','DIREKTUR  LOGISTIK','KS',NULL,NULL,NULL,NULL),('3','Direktorat Keuangan','KIT',NULL,NULL,NULL,NULL),('3','DIREKTUR  PRODUKSI','KS',NULL,NULL,NULL,NULL),('4','DIREKTUR PEMASARAN','KS',NULL,NULL,NULL,NULL),('5','DIREKTUR  KEUANGAN','KS',NULL,NULL,NULL,NULL),('6','DIREKTUR SUMBER DAYA MANUSIA & UMUM','KS',NULL,NULL,NULL,NULL),('7','DIREKTUR TEKNOLOGI & PENGEMBANGAN USAHA','KS',NULL,NULL,NULL,NULL);
