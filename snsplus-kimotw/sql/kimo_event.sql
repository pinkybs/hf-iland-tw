/*
SQLyog Ultimate v8.32 
MySQL - 5.1.48-log : Database - kimotw_island_event
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kimotw_island_event` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `kimotw_island_event`;

/*Table structure for table `island_hash_collect` */

DROP TABLE IF EXISTS `island_hash_collect`;

CREATE TABLE `island_hash_collect` (
  `key` varchar(64) NOT NULL,
  `val` text,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `island_teambuy_info` */

DROP TABLE IF EXISTS `island_teambuy_info`;

CREATE TABLE `island_teambuy_info` (
  `gid` varchar(11) NOT NULL COMMENT 'gid-数量',
  `name` varchar(200) DEFAULT NULL COMMENT '名称',
  `start_time` int(11) DEFAULT NULL COMMENT '参加开始时间',
  `ok_time` int(11) DEFAULT NULL COMMENT '参加有效时间长度',
  `buy_time` int(11) DEFAULT NULL COMMENT '购买时间长度',
  `max_price` varchar(200) NOT NULL COMMENT '物品原价*价格类型:1-coin,2-gold',
  `min_price` varchar(200) DEFAULT NULL COMMENT '最低价格*价格类型:1-coin,2-gold',
  `min_num` int(11) DEFAULT NULL COMMENT '最少人数',
  `max_num` int(11) DEFAULT NULL COMMENT '最高人数',
  `start_num` int(11) DEFAULT '0' COMMENT '起始参加人数',
  `bec_num` int(11) DEFAULT NULL COMMENT 'gold变为coin需要人数',
  `bec_price` int(11) DEFAULT NULL COMMENT 'gold变为coin开始价格',
  `scale_gold` varchar(200) DEFAULT NULL COMMENT '降价比例gold',
  `scale_coin` varchar(200) DEFAULT NULL COMMENT '降价比例coin',
  `status` int(2) DEFAULT '1' COMMENT '是否是现在团购的物品:-1不是,1是',
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `island_user_teambuy` */

DROP TABLE IF EXISTS `island_user_teambuy`;

CREATE TABLE `island_user_teambuy` (
  `uid` int(11) NOT NULL,
  `status` int(2) DEFAULT '-1' COMMENT '用户是否已经购买物品:-1没有,1已经购买',
  PRIMARY KEY (`uid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
