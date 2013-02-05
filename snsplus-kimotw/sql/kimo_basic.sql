/*
SQLyog Community Edition- MySQL GUI v6.14 RC
MySQL - 5.1.49community-log : Database - kimotw_island_basic
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`kimotw_island_0` /*!40100 DEFAULT CHARACTER SET utf8 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kimotw_island_1` /*!40100 DEFAULT CHARACTER SET utf8 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kimotw_island_2` /*!40100 DEFAULT CHARACTER SET utf8 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kimotw_island_3` /*!40100 DEFAULT CHARACTER SET utf8 */;

create database if not exists `kimotw_island_event`;

USE `kimotw_island_event`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `island_user_teambuy` */

DROP TABLE IF EXISTS `island_user_teambuy`;

CREATE TABLE `island_user_teambuy` (
  `uid` int(11) NOT NULL,
  `status` int(2) DEFAULT '-1' COMMENT '用户是否已经购买物品:-1没有,1已经购买',
  PRIMARY KEY (`uid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create database if not exists `kimotw_island_basic`;

USE `kimotw_island_basic`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `island_background` */

DROP TABLE IF EXISTS `island_background`;

CREATE TABLE `island_background` (
  `bgid` int(11) NOT NULL COMMENT '海岛背景id',
  `name` varchar(200) DEFAULT NULL COMMENT '名称',
  `price` int(11) DEFAULT NULL COMMENT '购买价格',
  `price_type` tinyint(4) DEFAULT NULL COMMENT '购买币种,1:coin,2:gold',
  `cheap_price` int(11) DEFAULT '0' COMMENT '折扣价格',
  `cheap_start_time` int(11) DEFAULT '0' COMMENT '开始折扣时间',
  `cheap_end_time` int(11) DEFAULT '0' COMMENT '结束折扣时间',
  `sale_price` int(11) DEFAULT NULL COMMENT '售出价格',
  `introduce` varchar(200) DEFAULT NULL COMMENT '介绍',
  `class_name` varchar(200) DEFAULT NULL COMMENT '图像素材',
  `need_level` int(11) DEFAULT NULL COMMENT '需要等级',
  `add_praise` int(11) DEFAULT '0' COMMENT '好评度增加数',
  `item_type` tinyint(4) DEFAULT NULL COMMENT '11:岛,12:天,13:海,14:船坞',
  `new` tinyint(4) DEFAULT '0' COMMENT '是否新商品,0:非新,1:新  ',
  `can_buy` tinyint(4) DEFAULT '1' COMMENT '是否可以在商店购买,1:可以,0:不可以',
  PRIMARY KEY (`bgid`),
  KEY `need_level` (`need_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_background` */

insert  into `island_background`(`bgid`,`name`,`price`,`price_type`,`cheap_price`,`cheap_start_time`,`cheap_end_time`,`sale_price`,`introduce`,`class_name`,`need_level`,`add_praise`,`item_type`,`new`,`can_buy`) values (22213,'爽藍海水',0,1,0,0,0,0,NULL,'sea.1.shuanglan',1,1,13,0,0),(22313,'海星島-海',5000,1,0,0,0,1000,NULL,'sea.1.wuxing',1,1,13,0,1),(22413,'愛之海',100,2,0,0,0,20000,NULL,'sea.1.aizhihai',1,1,13,0,0),(22513,'彩虹島-海',100,2,0,0,0,20000,NULL,'sea.1.caihong',1,1,13,0,0),(22613,'和式島-海',100,2,0,0,0,20000,NULL,'sea.1.heshi',1,1,13,0,0),(22713,'音符海',100,2,0,0,0,20000,NULL,'sea.1.yinfu',1,1,13,0,0),(22813,'烏龜島-海',100,2,0,0,0,20000,NULL,'sea.1.wugui',1,1,13,0,0),(22913,'外星島-海',100,2,0,0,0,20000,NULL,'sea.1.waixing',1,1,13,0,0),(23013,'救生圈島-海洋',0,2,0,0,0,0,NULL,'sea.1.jiushengquan',1,1,13,0,0),(23113,'遊樂場海洋',0,2,0,0,0,0,NULL,'sea.1.youle',1,1,13,0,0),(23212,'基本天空',0,1,0,0,0,0,NULL,'sky.1.jiben',1,1,12,0,0),(23312,'丘比特天空',100,2,0,0,0,20000,NULL,'sky.1.qiubite',1,1,12,0,0),(23412,'紫色天空',0,2,0,0,0,0,NULL,'sky.1.zise',1,1,12,0,0),(23512,'救生圈島-天',100,2,0,0,0,20000,NULL,'sky.1.jiushengquan',1,1,12,0,0),(23612,'漫天飛雪',100,2,0,0,0,20000,NULL,'sky.1.maitianfeixue',1,1,12,0,0),(23712,'烏龜島-天',5000,1,0,0,0,1000,NULL,'sky.1.wugui',1,1,12,0,1),(23812,'兔月夜',0,2,0,0,0,0,NULL,'sky.1.tuyueye',1,1,12,0,0),(23912,'外星島-天',100,2,0,0,0,20000,NULL,'sky.1.waixing',1,1,12,0,0),(24012,'狼夜',100,2,0,0,0,20000,NULL,'sky.1.langye',1,1,12,0,0),(24112,'祥雲天空',100,2,0,0,0,20000,NULL,'sky.1.xiangyun',1,1,12,0,0),(24212,'雙魚星域',100,2,0,0,0,20000,NULL,'sky.1.shuangyuzuo',1,1,12,0,0),(24312,'水瓶星域',100,2,0,0,0,20000,NULL,'sky.1.shuipingzuo',1,1,12,0,0),(24412,'射手星域',100,2,0,0,0,20000,NULL,'sky.1.sheshouzuo',1,1,12,0,0),(24512,'天蠍星域',100,2,0,0,0,20000,NULL,'sky.1.tianxiezuo',1,1,12,0,0),(24612,'天平星域',100,2,0,0,0,20000,NULL,'sky.1.tianpingzuo',1,1,12,0,0),(24712,'處女星域',100,2,0,0,0,20000,NULL,'sky.1.chunvzuo',1,1,12,0,0),(24812,'獅子星域',100,2,0,0,0,20000,NULL,'sky.1.shizizuo',1,1,12,0,0),(24912,'巨蟹星域',100,2,0,0,0,20000,NULL,'sky.1.juxiezuo',1,1,12,0,0),(25012,'摩羯星域',100,2,0,0,0,20000,NULL,'sky.1.mojiezuo',1,1,12,0,0),(25112,'雙子星域',100,2,0,0,0,20000,NULL,'sky.1.shuangzizuo',1,1,12,0,0),(25212,'金牛星域',100,2,0,0,0,20000,NULL,'sky.1.jinniuzuo',1,1,12,0,0),(25312,'白羊星域',100,2,0,0,0,20000,NULL,'sky.1.baiyangzuo',1,1,12,0,0),(25411,'基本島',0,1,0,0,0,0,NULL,'island.1.001',1,1,11,0,0),(25511,'三葉草島-島皮',5000,1,0,0,0,1000,NULL,'island.1.002',1,1,11,0,1),(25611,'蘋果島-島皮',100,2,0,0,0,20000,NULL,'island.1.003',1,1,11,0,0),(25711,'餅乾島-島皮',100,2,0,0,0,20000,NULL,'island.1.004',1,1,11,0,0),(25811,'外星島-島皮',100,2,0,0,0,20000,NULL,'island.1.005',1,1,11,0,0),(25914,'標準碼頭',0,1,0,0,0,0,NULL,'dock.1.001',1,1,14,0,0),(26014,'藍色碼頭',0,1,0,0,0,0,NULL,'dock.1.002',1,1,14,0,0),(26114,'粉紅碼頭',100,2,0,0,0,20000,NULL,'dock.1.003',1,1,14,0,0),(27211,'阿拉伯島',100,2,0,0,0,20000,NULL,'island.1.006',1,1,11,0,0),(27311,'彩虹島',0,2,0,0,0,0,NULL,'island.1.007',1,1,11,0,0),(27411,'聖誕島',100,2,0,0,0,20000,NULL,'island.1.008',1,1,11,0,0),(27511,'橙色島',100,2,0,0,0,20000,NULL,'island.1.009',1,1,11,0,0),(27611,'黑膠碟島',100,2,0,0,0,20000,NULL,'island.1.010',1,1,11,0,0),(68813,'咖啡海',100,2,0,0,0,20000,NULL,'sea.1.kafei',6,1,13,0,0),(68911,'咖啡島',100,2,0,0,0,20000,NULL,'island.1.019',6,1,11,0,0),(85911,'童話島-島皮',0,0,0,0,0,0,NULL,'island.1.020',0,0,11,0,0),(86011,'遊樂場島-島皮',0,0,0,0,0,0,NULL,'island.1.021',0,0,11,0,0),(86111,'失落世界-島皮',0,0,0,0,0,0,NULL,'island.1.022',0,0,11,0,0),(99714,'粉色條紋碼頭',5,2,0,0,0,1000,NULL,'dock.1.004',1,1,14,0,0),(99814,'聖誕碼頭',5,2,0,0,0,1000,NULL,'dock.1.005',1,1,14,0,0),(99914,'失落世界海',5,2,0,0,0,1000,NULL,'sea.1.shiluoshijie',1,1,14,0,0);

/*Table structure for table `island_bottle` */

DROP TABLE IF EXISTS `island_bottle`;

CREATE TABLE `island_bottle` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `btl_id` int(11) DEFAULT NULL COMMENT '寻宝季, id',
  `btl_name` varchar(128) DEFAULT NULL COMMENT '名字',
  `btl_tips` varchar(128) DEFAULT NULL COMMENT '物品tips',
  `type` varchar(32) DEFAULT NULL COMMENT '类型,COIN,GOLD,PLANT,BUILDING,CARD,STARFISH',
  `coin` int(11) DEFAULT '0' COMMENT '金币',
  `gold` int(11) DEFAULT '0' COMMENT '钻石',
  `starfish` int(11) DEFAULT '0' COMMENT '海星',
  `item_id` int(11) DEFAULT NULL COMMENT '此id可以是, 建筑, 装饰品,卡牌',
  `odds` int(11) DEFAULT '10' COMMENT '概率, 必须是整数',
  `num` int(11) DEFAULT NULL COMMENT '数量,影响建筑, 装饰品, 卡牌',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

/*Data for the table `island_bottle` */

insert  into `island_bottle`(`id`,`btl_id`,`btl_name`,`btl_tips`,`type`,`coin`,`gold`,`starfish`,`item_id`,`odds`,`num`) values (1,0,'海星+5','海星*5','STARFISH',0,0,5,0,600,0),(2,0,'金幣7000','金幣7000','COIN',7000,0,0,0,1100,0),(3,0,'寶石+10','寶石*10','GOLD',0,10,0,0,100,0),(4,0,'海盜旗','海盜旗（裝飾）','BUILDING',0,0,0,91421,600,1),(5,0,'雙倍經驗卡','雙倍經驗卡','CARD',0,0,0,74841,400,1),(6,0,'金幣10000','金幣10000','COIN',10000,0,0,0,800,0),(7,0,'寶石+5','寶石*5','GOLD',0,5,0,0,200,0),(8,0,'金幣5000','金幣5000','COIN',5000,0,0,0,1400,0),(9,0,'船隻加速卡3','船隻加速卡3','CARD',0,0,0,26441,1200,1),(10,0,'傑克船長','傑克船長（建築）','PLANT',0,0,0,91632,100,1),(11,0,'骷髏水手','骷髏水手（建築）','PLANT',0,0,0,91932,50,1),(12,0,'3星建設卡','3星建設卡','CARD',0,0,0,56741,200,1),(13,0,'章魚水手','章魚水手（建築）','PLANT',0,0,0,92132,50,1),(14,0,'4星建設卡','4星建設卡','CARD',0,0,0,56841,10,1),(15,0,'大副吉比斯','大副吉比斯（建築）','PLANT',0,0,0,92332,100,1),(16,0,'5星建设卡','5星建设卡','CARD',0,0,0,56941,5,1),(17,0,'骷髏美人魚','骷髏美人魚（建築）','PLANT',0,0,0,92032,50,1),(18,0,'超級防禦卡','超級防禦卡','CARD',0,0,0,67541,700,1),(19,0,'猴子水手','猴子水手（建築）','PLANT',0,0,0,91532,50,1),(20,0,'寶箱鑰匙','寶箱鑰匙','CARD',0,0,0,86241,500,1),(21,1,'金幣5000','金幣5000','COIN',5000,0,0,0,1350,0),(22,1,'寶石+5','寶石+5','GOLD',0,5,0,0,200,0),(23,1,'花仙子','花仙子','BUILDING',0,0,0,76021,850,1),(24,1,'甲殼蟲變身機器人','甲殼蟲變身機器人（建築）','PLANT',0,0,0,101932,100,1),(25,1,'金幣7000','金幣7000','COIN',7000,0,0,0,1150,0),(26,1,'海星+5','海星+5','STARFISH',0,0,5,0,600,0),(27,1,'4星建設卡','4星建設卡','CARD',0,0,0,56841,10,1),(28,1,'寶箱鑰匙','寶箱鑰匙','CARD',0,0,0,86241,500,1),(29,1,'金幣10000','金幣10000','COIN',10000,0,0,0,600,0),(30,1,'寶石+3','寶石+3','GOLD',0,3,0,0,300,0),(31,1,'賽車變形機器人','賽車變形機器人（建築）','PLANT',0,0,0,102132,100,1),(32,1,'變身手杖店','變身手杖店（建築）','PLANT',0,0,0,100032,600,1),(33,1,'輪胎店','輪胎店（建築）','PLANT',0,0,0,102832,100,1),(34,1,'3星建設卡','3星建設卡','CARD',0,0,0,56741,200,1),(35,1,'一鍵收取卡','一鍵收取卡','CARD',0,0,0,67441,800,1),(36,1,'加油站','加油站（建築）','PLANT',0,0,0,102732,100,1),(37,1,'停車標誌牌','停車標誌牌（裝飾）','BUILDING',0,0,0,103021,1000,1),(38,1,'變裝配飾店','變裝配飾店（建築）','PLANT',0,0,0,101232,600,1),(39,1,'飛機變身機器人','飛機變身機器人（建築）','PLANT',0,0,0,102532,100,1),(40,1,'坦克變身機器人','坦克變身機器人（建築）','PLANT',0,0,0,102332,80,1);

/*Table structure for table `island_building` */

DROP TABLE IF EXISTS `island_building`;

CREATE TABLE `island_building` (
  `cid` int(11) NOT NULL COMMENT '海岛装饰物id',
  `name` varchar(200) DEFAULT NULL COMMENT '名称',
  `class_name` varchar(200) DEFAULT NULL COMMENT '图像素材',
  `map` varchar(200) DEFAULT NULL COMMENT '缩图',
  `content` varchar(200) DEFAULT NULL COMMENT '介绍',
  `add_praise` int(4) DEFAULT '0' COMMENT '好评度增加数',
  `price` int(11) DEFAULT NULL COMMENT '购买价格',
  `price_type` tinyint(4) DEFAULT NULL COMMENT '购买币种,1:coin,2:gold',
  `cheap_price` int(11) DEFAULT '0' COMMENT '折扣价格',
  `cheap_start_time` int(11) DEFAULT '0' COMMENT '开始折扣时间',
  `cheap_end_time` int(11) DEFAULT '0' COMMENT '结束折扣时间',
  `sale_price` int(11) DEFAULT NULL COMMENT '售出价格',
  `need_level` int(11) DEFAULT NULL COMMENT '使用需要等级',
  `nodes` varchar(200) DEFAULT NULL COMMENT '装饰类占地信息',
  `item_type` tinyint(4) DEFAULT NULL COMMENT '21:绿化,22:地面,31:建筑,32:饮食',
  `new` tinyint(4) DEFAULT '0' COMMENT '是否新商品,0:非新,1:新',
  `can_buy` tinyint(4) DEFAULT '1' COMMENT '是否可以在商店购买,1:可以,0:不可以',
  PRIMARY KEY (`cid`),
  KEY `need_level` (`need_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_building` */

insert  into `island_building`(`cid`,`name`,`class_name`,`map`,`content`,`add_praise`,`price`,`price_type`,`cheap_price`,`cheap_start_time`,`cheap_end_time`,`sale_price`,`need_level`,`nodes`,`item_type`,`new`,`can_buy`) values (6221,'垃圾桶','building.2.lajitong1',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(6321,'垃圾桶','building.2.lajitong2',NULL,NULL,1,0,1,0,0,0,0,1,'1*1',21,0,0),(6421,'盆栽','building.2.huapen1',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(6521,'盆栽','building.2.huapen2',NULL,NULL,1,0,1,0,0,0,0,1,'1*1',21,0,0),(6621,'盆栽','building.2.huapen3',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(6721,'雪松','building.2.tree1',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(6821,'柏樹','building.2.tree2',NULL,NULL,1,0,1,0,0,0,0,1,'1*1',21,0,0),(6921,'西瓜樹','building.2.tree3',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(7021,'梧桐樹','building.2.tree4',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(7121,'彩葉樹','building.2.tree5',NULL,NULL,1,900,1,0,0,0,180,1,'1*1',21,0,1),(7221,'白雲樹','building.1.tree6',NULL,NULL,1,900,1,0,0,0,180,1,'1*1',21,0,1),(7321,'星星樹','building.2.tree7',NULL,NULL,1,0,1,0,0,0,0,1,'1*1',21,0,0),(7421,'桃樹','building.2.tree8',NULL,NULL,1,900,1,0,0,0,180,1,'1*1',21,0,1),(7521,'蘑菇頭樹','building.2.dashu1',NULL,NULL,1,1200,1,0,0,0,240,1,'2*2',21,0,1),(7621,'貝殼','building.2.beike',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(7721,'足球','building.2.zuqiu',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(7821,'草坪','building.2.xiaocao',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(7921,'沙包2','building.2.shabao2',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(8021,'沙包1','building.2.shabao1',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(8121,'足球','building.2.paiqiu',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(8221,'籃球','building.2.lanqiu',NULL,NULL,1,0,1,0,0,0,0,1,'1*1',21,0,0),(8321,'8號撞球','building.2.taiqiu8',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(8421,'9號撞球','building.2.taiqiu9',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(8521,'保齡球','building.2.baolingqiu',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(8621,'十字架','building.2.shizijia',NULL,NULL,1,1200,1,0,0,0,240,1,'1*1',21,0,1),(8721,'粉紅小屋','building.2.meiguiwu',NULL,NULL,1,0,1,0,0,0,0,1,'1*1',21,0,0),(8921,'柵欄轉角','building.2.zhalan1_1',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(9021,'柵欄轉角','building.2.zhalan1_2',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(9121,'柵欄轉角','building.2.zhalan1_3',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(9221,'柵欄轉角','building.2.zhalan1_4',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(9321,'柵欄轉角','building.2.zhalan1_5',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(9421,'柵欄轉角','building.2.zhalan1_6',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(9521,'西瓜柵欄轉角','building.2.zhalan3_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(9621,'西瓜柵欄轉角','building.2.zhalan3_2',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(9721,'西瓜柵欄轉角','building.2.zhalan3_3',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(9821,'西瓜柵欄轉角','building.2.zhalan3_4',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(9921,'西瓜柵欄轉角','building.2.zhalan3_5',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(10021,'西瓜柵欄轉角','building.2.zhalan3_6',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(10121,'西瓜柵欄轉角','building.2.zhalan3_7',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(10221,'西瓜柵欄轉角','building.2.zhalan3_8',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(10321,'警告柵欄轉角','building.2.zhalan2_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(10421,'警告柵欄轉角','building.2.zhalan2_2',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(10521,'警告柵欄轉角','building.2.zhalan2_3',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(10621,'警告柵欄轉角','building.2.zhalan2_4',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(10721,'警告柵欄轉角','building.2.zhalan2_5',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(10821,'警告柵欄轉角','building.2.zhalan2_6',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(10921,'警告柵欄轉角','building.2.zhalan2_7',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(11021,'警告柵欄轉角','building.2.zhalan2_8',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(11121,'蘿蔔柵欄轉角','building.2.zhalan4_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(11221,'蘿蔔柵欄轉角','building.2.zhalan4_2',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(11321,'蘿蔔柵欄轉角','building.2.zhalan4_3',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(11421,'蘿蔔柵欄轉角','building.2.zhalan4_4',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(11521,'蘿蔔柵欄轉角','building.2.zhalan4_5',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(11621,'蘿蔔柵欄轉角','building.2.zhalan4_6',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(11721,'蘿蔔柵欄轉角','building.2.zhalan4_7',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(11821,'蘿蔔柵欄轉角','building.2.zhalan4_8',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(12021,'黃筆柵欄轉角','building.2.zhalan6_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(12121,'黃筆柵欄轉角','building.2.zhalan6_2',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(12221,'黃筆柵欄轉角','building.2.zhalan6_3',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(12321,'黃筆柵欄轉角','building.2.zhalan6_4',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(12421,'黃筆柵欄轉角','building.2.zhalan6_5',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(12521,'黃筆柵欄轉角','building.2.zhalan6_6',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(12621,'黃筆柵欄轉角','building.2.zhalan6_7',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(12721,'黃筆柵欄轉角','building.2.zhalan6_8',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(12821,'綠筆柵欄轉角','building.2.zhalan7_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(12921,'綠筆柵欄轉角','building.2.zhalan7_2',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(13021,'綠筆柵欄轉角','building.2.zhalan7_3',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(13121,'綠筆柵欄轉角','building.2.zhalan7_4',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(13221,'綠筆柵欄轉角','building.2.zhalan7_5',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(13321,'綠筆柵欄轉角','building.2.zhalan7_6',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(13421,'綠筆柵欄轉角','building.2.zhalan7_7',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(13521,'綠筆柵欄轉角','building.2.zhalan7_8',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(13621,'紅筆柵欄轉角','building.2.zhalan8_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(13721,'紅筆柵欄轉角','building.2.zhalan8_2',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(13821,'紅筆柵欄轉角','building.2.zhalan8_3',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(13921,'紅筆柵欄轉角','building.2.zhalan8_4',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(14021,'紅筆柵欄轉角','building.2.zhalan8_5',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(14121,'紅筆柵欄轉角','building.2.zhalan8_6',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(14221,'紅筆柵欄轉角','building.2.zhalan8_7',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(14321,'紅筆柵欄轉角','building.2.zhalan8_8',NULL,NULL,1,300,1,0,0,0,60,1,'1*1',21,0,1),(21721,'路燈','building.2.ludeng1',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(21821,'路燈','building.2.ludeng2',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(21921,'路燈','building.2.ludeng3',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(22121,'花燈','building.2.ludeng5',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(27721,'字母-方向1-a','building.2.zimu_a_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(27821,'字母-方向1-b','building.2.zimu_b_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(27921,'字母-方向1-c','building.2.zimu_c_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(28021,'字母-方向1-d','building.2.zimu_d_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(28121,'字母-方向1-e','building.2.zimu_e_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(28221,'字母-方向1-f','building.2.zimu_f_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(28321,'字母-方向1-g','building.2.zimu_g_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(28421,'字母-方向1-h','building.2.zimu_h_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(28521,'字母-方向1-i','building.2.zimu_i_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(28621,'字母-方向1-j','building.2.zimu_j_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(28721,'字母-方向1-k','building.2.zimu_k_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(28821,'字母-方向1-l','building.2.zimu_l_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(28921,'字母-方向1-m','building.2.zimu_m_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(29021,'字母-方向1-n','building.2.zimu_n_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(29121,'字母-方向1-o','building.2.zimu_o_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(29221,'字母-方向1-p','building.2.zimu_p_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(29321,'字母-方向1-q','building.2.zimu_q_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(29421,'字母-方向1-r','building.2.zimu_r_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(29521,'字母-方向1-s','building.2.zimu_s_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(29621,'字母-方向1-t','building.2.zimu_t_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(29721,'字母-方向1-u','building.2.zimu_u_1',NULL,NULL,1,2,2,0,0,0,400,1,'1*1',21,0,1),(29821,'字母-方向1-v','building.2.zimu_v_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(29921,'字母-方向1-w','building.2.zimu_w_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(30021,'字母-方向1-x','building.2.zimu_x_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(30121,'字母-方向1-y','building.2.zimu_y_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(30221,'字母-方向1-z','building.2.zimu_z_1',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(30321,'字母-方向2-a','building.2.zimu_a_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(30421,'字母-方向2-b','building.2.zimu_b_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(30521,'字母-方向2-c','building.2.zimu_c_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(30621,'字母-方向2-d','building.2.zimu_d_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(30721,'字母-方向2-e','building.2.zimu_e_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(30821,'字母-方向2-f','building.2.zimu_f_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(30921,'字母-方向2-g','building.2.zimu_g_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(31021,'字母-方向2-h','building.2.zimu_h_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(31121,'字母-方向2-i','building.2.zimu_i_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(31221,'字母-方向2-j','building.2.zimu_j_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(31321,'字母-方向2-k','building.2.zimu_k_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(31421,'字母-方向2-l','building.2.zimu_l_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(31521,'字母-方向2-m','building.2.zimu_m_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(31621,'字母-方向2-n','building.2.zimu_n_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(31721,'字母-方向2-o','building.2.zimu_o_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(31821,'字母-方向2-p','building.2.zimu_p_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(31921,'字母-方向2-q','building.2.zimu_q_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(32021,'字母-方向2-r','building.2.zimu_r_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(32121,'字母-方向2-s','building.2.zimu_s_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(32221,'字母-方向2-t','building.2.zimu_t_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(32321,'字母-方向2-u','building.2.zimu_u_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(32421,'字母-方向2-v','building.2.zimu_v_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(32521,'字母-方向2-w','building.2.zimu_w_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(32621,'字母-方向2-x','building.2.zimu_x_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(32721,'字母-方向2-y','building.2.zimu_y_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(32821,'字母-方向2-z','building.2.zimu_z_2',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(32921,'紅心氣球','building.2.qiqiu1',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(33021,'藍心氣球','building.2.qiqiu2',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(33121,'綠籬灌木','building.2.caoduo1',NULL,NULL,1,600,1,0,0,0,120,1,'1*1',21,0,1),(33221,'紅玫綠籬灌木','building.2.caoduo2',NULL,NULL,1,800,1,0,0,0,160,1,'1*1',21,0,1),(33321,'白玫綠籬灌木','building.2.caoduo3',NULL,NULL,1,800,1,0,0,0,160,1,'1*1',21,0,1),(33421,'白玫瑰花壇','building.2.caoduo4',NULL,NULL,1,1000,1,0,0,0,200,1,'1*1',21,0,1),(33521,'樹雕','building.2.caoduo5',NULL,NULL,1,800,1,0,0,0,160,1,'1*1',21,0,1),(33621,'粉色長椅','building.2.yizi1',NULL,NULL,1,1200,1,0,0,0,240,1,'1*1',21,0,1),(33721,'白色長椅','building.2.yizi2',NULL,NULL,1,1200,1,0,0,0,240,1,'1*1',21,0,1),(33821,'綠色長椅','building.2.yizi3',NULL,NULL,1,1200,1,0,0,0,240,1,'1*1',21,0,1),(33921,'地燈','building.2.lizhu1',NULL,NULL,1,1800,1,0,0,0,360,1,'1*1',21,0,1),(34021,'木樁','building.2.lizhu2',NULL,NULL,1,900,1,0,0,0,180,1,'1*1',21,0,1),(34121,'天使雕像','building.2.lizhu3',NULL,NULL,1,1800,1,0,0,0,360,1,'1*1',21,0,1),(34221,'黃玫瑰花座','building.2.lizhu4',NULL,NULL,1,1200,1,0,0,0,240,1,'1*1',21,0,1),(34321,'百合花座','building.2.lizhu5',NULL,NULL,1,1200,1,0,0,0,240,1,'1*1',21,0,1),(34421,'小溪流水池','building.2.shuichi1',NULL,NULL,1,4800,1,0,0,0,960,1,'2*2',21,0,1),(34521,'小型噴泉池','building.2.shuichi2',NULL,NULL,1,4800,1,0,0,0,960,1,'2*2',21,0,1),(34621,'荷花水潭','building.2.shuichi3',NULL,NULL,1,4800,1,0,0,0,960,1,'2*2',21,0,1),(35821,'灰色垃圾桶','building.2.lajitong3',NULL,NULL,1,1200,1,0,0,0,240,1,'1*1',21,0,1),(35921,'黃金垃圾桶','building.2.lajitong4',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(36221,'心心路障','building.2.luzhang1',NULL,NULL,1,800,1,0,0,0,160,1,'1*1',21,0,1),(36321,'豎心路障','building.2.luzhang2',NULL,NULL,1,1200,1,0,0,0,240,10,'1*1',21,0,1),(36421,'愛心樹','building.2.tree9',NULL,NULL,1,1200,1,0,0,0,240,10,'1*1',21,0,1),(36521,'粉色愛心樹','building.2.tree10',NULL,NULL,1,1,2,0,0,0,200,1,'1*1',21,0,1),(36621,'兔耳氣球','building.2.qiqiu3',NULL,NULL,1,1200,1,0,0,0,240,10,'1*1',21,0,1),(36721,'祈福天使','building.1.yushu1',NULL,NULL,20,20000,1,0,0,0,4000,1,'3*3',21,0,1),(36821,'紅色郵筒','building.1.youtong',NULL,NULL,1,600,1,0,0,0,120,8,'1*1',21,0,1),(36921,'投票箱','building.2.toupiaoxiang',NULL,NULL,1,600,1,0,0,0,120,9,'1*1',21,0,1),(37021,'UFO','building.1.waixingcang',NULL,NULL,1,1200,1,0,0,0,240,10,'1*1',21,0,1),(37121,'阿拉伯亭','building.1.alabo',NULL,NULL,1,1200,1,0,0,0,240,12,'1*1',21,0,1),(37221,'電話亭','building.2.dianhuating',NULL,NULL,1,800,1,0,0,0,160,11,'1*1',21,0,1),(37321,'紅色指示牌','building.2.hongsepai',NULL,NULL,1,400,1,0,0,0,80,5,'1*1',21,0,1),(37421,'綠色指示牌','building.2.lvsepai',NULL,NULL,1,400,1,0,0,0,80,5,'1*1',21,0,1),(37521,'眼鏡母雞雕像','building.2.muji',NULL,NULL,4,1,2,0,0,0,200,1,'2*2',21,0,1),(38221,'峽穀','building.4.xiagu6',NULL,NULL,20,1200000,1,0,0,0,240000,30,'6*6',21,0,1),(42421,'石墩','building.2.shikuai1',NULL,NULL,1,1200,1,0,0,0,300,15,'1*1',21,0,1),(42521,'救生圈','building.2.shatan1',NULL,NULL,1,600,1,0,0,0,150,16,'1*1',21,0,1),(42921,'藍色搖椅','building.2.yaoyi1',NULL,NULL,1,800,1,0,0,0,200,20,'2*2',21,0,1),(43021,'童話南瓜車','building.2.nanguache1',NULL,NULL,1,2,2,0,0,0,500,25,'2*2',21,0,1),(43221,'童話麒麟馬','building.2.xiaoma1',NULL,NULL,1,4000,1,0,0,0,1000,25,'2*2',21,0,1),(45521,'鼓手小兵','building.2.hutaojiazi1',NULL,NULL,1,2000,1,0,0,0,500,21,'1*1',21,0,0),(45621,'指揮小兵','building.2.hutaojiazi2',NULL,NULL,1,1,2,0,0,0,250,24,'1*1',21,0,1),(45721,'號手小兵','building.2.hutaojiazi3',NULL,NULL,1,2000,1,0,0,0,500,24,'1*1',21,0,0),(45821,'不倒翁','building.2.budaoweng1',NULL,NULL,1,1500,1,0,0,0,375,1,'1*1',21,0,0),(45921,'不倒翁','building.2.budaoweng2',NULL,NULL,1,2,2,0,0,0,500,1,'1*1',21,0,0),(46021,'魔術方塊','building.2.mofang1',NULL,NULL,1,1000,1,0,0,0,250,1,'1*1',21,0,0),(46121,'魔術方塊','building.2.mofang2',NULL,NULL,1,1000,1,0,0,0,250,1,'1*1',21,0,0),(46221,'玩具凳','building.2.dengzi1',NULL,NULL,1,1500,1,0,0,0,375,1,'1*1',21,0,0),(46321,'玩具凳','building.2.dengzi2',NULL,NULL,1,1500,1,0,0,0,375,1,'1*1',21,0,0),(46421,'玩具樹','building.2.tree11',NULL,NULL,1,1000,1,0,0,0,250,1,'1*1',21,0,0),(46521,'人偶','building.2.renou1',NULL,NULL,1,2000,1,0,0,0,500,1,'1*1',21,0,0),(46621,'人偶','building.2.renou2',NULL,NULL,1,1,2,0,0,0,250,1,'1*1',21,0,0),(46821,'小熊','building.2.dongwu1',NULL,NULL,1,0,2,0,0,0,0,1,'1*1',21,0,0),(46921,'河馬','building.2.dongwu2',NULL,NULL,1,0,2,0,0,0,0,1,'1*1',21,0,0),(47021,'熊貓','building.2.dongwu3',NULL,NULL,1,0,2,0,0,0,0,1,'1*1',21,0,0),(47121,'獅子','building.2.dongwu4',NULL,NULL,1,0,2,0,0,0,0,1,'1*1',21,0,0),(47221,'機車','building.2.jiaotong1',NULL,NULL,1,0,2,0,0,0,0,1,'3*2',21,0,0),(47321,'直升機','building.2.jiaotong2',NULL,NULL,1,0,2,0,0,0,0,1,'3*2',21,0,0),(47421,'雙翼飛機','building.2.jiaotong3',NULL,NULL,1,0,2,0,0,0,0,1,'3*2',21,0,0),(47521,'火車頭','building.2.jiaotong4',NULL,NULL,1,0,2,0,0,0,0,1,'3*2',21,0,0),(49721,'燈塔','building.2.dengta',NULL,NULL,1,8000,1,0,0,0,1600,1,'1*1',21,0,0),(49821,'巨錨','building.2.mao',NULL,NULL,1,12000,1,0,0,0,2400,1,'2*2',21,0,0),(49921,'吊床','building.2.diaochuang',NULL,NULL,1,5,2,0,0,0,1000,1,'2*2',21,0,0),(50021,'小樹叢','building.2.haibian1',NULL,NULL,1,1000,1,0,0,0,200,1,'1*1',21,0,0),(50121,'珊瑚','building.2.haibian2',NULL,NULL,1,3000,1,0,0,0,600,1,'1*1',21,0,0),(50221,'衝浪板','building.2.haibian3',NULL,NULL,1,2000,1,0,0,0,400,1,'1*1',21,0,0),(50321,'小水桶','building.2.haibian4',NULL,NULL,1,1200,1,0,0,0,240,1,'1*1',21,0,0),(50421,'海星','building.2.haibian5',NULL,NULL,1,1200,1,0,0,0,240,1,'1*1',21,0,0),(50521,'海星','building.2.haibian6',NULL,NULL,1,1200,1,0,0,0,240,1,'1*1',21,0,0),(53421,'糖果秋千','building.2.tangqiuqian',NULL,NULL,1,4,2,0,0,0,800,35,'1*2',21,0,1),(53521,'棉花糖樹','building.2.miantang',NULL,NULL,1,2000,1,0,0,0,400,35,'1*1',21,0,1),(54321,'兔爺','building.7.tuye',NULL,NULL,1,4,2,0,0,0,800,1,'1*1',21,0,1),(59321,'貓頭鷹','building.7.maotouying',NULL,NULL,1,1700,1,0,0,0,425,8,'1*1',21,0,0),(59821,'蛋蛋鴨','building.7.yazi1',NULL,NULL,1,20,2,0,0,0,0,1,'2*2',21,0,0),(59921,'泳圈鴨','building.7.yazi2',NULL,NULL,1,20,2,0,0,0,0,1,'2*2',21,0,0),(60021,'DJ鴨','building.7.yazi3',NULL,NULL,5,20,2,0,0,0,0,1,'2*2',21,0,0),(61421,'方尖碑','building.7.fjb1',NULL,NULL,1,5,2,0,0,0,1000,1,'1*1',21,0,1),(61521,'方尖碑','building.7.fjb2',NULL,NULL,1,5,2,0,0,0,1000,1,'1*1',21,0,1),(61621,'花壇','building.7.ht3',NULL,NULL,1,1300,1,0,0,0,325,1,'1*1',21,0,1),(61721,'花壇','building.7.ht4',NULL,NULL,1,1500,1,0,0,0,375,1,'1*1',21,0,1),(61821,'伊姆賽特罐','building.7.cg1',NULL,NULL,1,3,2,0,0,0,600,1,'1*1',21,0,1),(61921,'哈碧罐','building.7.cg2',NULL,NULL,1,3,2,0,0,0,600,1,'1*1',21,0,1),(62021,'杜米特夫罐','building.7.cg3',NULL,NULL,1,3,2,0,0,0,600,1,'1*1',21,0,1),(62121,'克布塞努夫罐','building.7.cg4',NULL,NULL,1,3,2,0,0,0,600,1,'1*1',21,0,1),(62221,'埃及城牆','building.7.cq1',NULL,NULL,1,1,2,0,0,0,300,1,'1*1',21,0,1),(62321,'埃及城牆','building.7.cq2',NULL,NULL,1,1,2,0,0,0,300,1,'1*1',21,0,1),(62421,'埃及城牆','building.7.cq3',NULL,NULL,1,1,2,0,0,0,300,1,'1*1',21,0,1),(62521,'埃及城牆','building.7.cq4',NULL,NULL,1,1,2,0,0,0,300,1,'1*1',21,0,1),(62621,'埃及城牆','building.7.cq5',NULL,NULL,1,1,2,0,0,0,300,1,'1*1',21,0,1),(62721,'埃及城牆','building.7.cq6',NULL,NULL,1,1,2,0,0,0,300,1,'1*1',21,0,1),(62821,'埃及城牆','building.7.cq7',NULL,NULL,1,1,2,0,0,0,300,1,'1*1',21,0,1),(62921,'埃及城牆','building.7.cq8',NULL,NULL,1,1,2,0,0,0,300,1,'1*1',21,0,1),(63621,'跳舞草','building.7.zhiwuhuacong3',NULL,NULL,1,2000,1,0,0,0,500,7,'1*1',21,0,1),(63821,'鮮花禮盒','building.7.xianhualihe3',NULL,NULL,1,2000,1,0,0,0,500,7,'1*1',21,0,1),(66421,'薑餅人','building.7.jbr3',NULL,NULL,1,1900,1,0,0,0,475,3,'1*1',21,0,1),(67921,'竹','building.7.zhu1',NULL,NULL,1,2000,1,0,0,0,500,8,'1*1',21,0,1),(68021,'梅','building.7.mei1',NULL,NULL,1,2000,1,0,0,0,500,8,'1*1',21,0,0),(68421,'烤玉米','building.7.yumi1',NULL,NULL,1,1000,1,0,0,0,250,7,'1*1',21,0,1),(68521,'烤火雞','building.7.khj1',NULL,NULL,1,1000,1,0,0,0,250,7,'1*1',21,0,1),(68621,'烤紅薯','building.7.khs1',NULL,NULL,1,1000,1,0,0,0,250,7,'1*1',21,0,1),(71321,'湯元','building.7.tangyuan3',NULL,NULL,1,1300,1,0,0,0,325,13,'1*1',21,0,1),(71421,'麵條','building.7.miantiao3',NULL,NULL,1,2,2,0,0,0,400,13,'1*1',21,0,1),(71521,'餃子','building.7.jiaozi3',NULL,NULL,1,1300,1,0,0,0,325,13,'1*1',21,0,0),(71621,'包子','building.7.baozi3',NULL,NULL,1,2,2,0,0,0,400,13,'1*1',21,0,1),(73821,'藍玫瑰','building.9.mghs1',NULL,NULL,1,10,2,0,0,0,1250,1,'1*1',21,0,1),(75421,'人氣王','building.9.rqw3',NULL,NULL,1,99,2,0,0,0,0,1,'1*2',21,0,0),(75921,'噴水池','building.9.psc03',NULL,NULL,1,8,2,0,0,0,1600,1,'2*2',21,0,1),(76021,'花仙子','building.9.hxz03',NULL,NULL,1,20,2,0,0,0,4000,33,'2*2',21,0,0),(76121,'櫻花','building.9.yh03',NULL,NULL,1,4000,1,0,0,0,1000,1,'2*2',21,0,1),(76221,'天鵝','building.9.tiane03',NULL,NULL,1,3000,1,0,0,0,750,23,'2*2',21,0,1),(76321,'鳥窩','building.9.nw03',NULL,NULL,1,5000,1,0,0,0,1250,26,'2*2',21,0,0),(76421,'水車','building.9.sc01',NULL,NULL,1,8000,1,0,0,0,2000,26,'2*2',21,0,1),(76521,'木橋','building.9.mq01',NULL,NULL,1,8000,1,0,0,0,2000,26,'2*2',21,0,1),(76621,'樹根吊床','building.9.sgdc01',NULL,NULL,1,5000,1,0,0,0,1250,26,'2*2',21,0,1),(81721,'橄欖樹','building.9.gls',NULL,NULL,1,3000,1,0,0,0,750,10,'1*1',21,0,1),(81821,'橫笛少年','building.9.hdsn',NULL,NULL,1,10,2,0,0,0,2500,15,'1*1',21,0,1),(82021,'羅馬柱','building.9.lmz',NULL,NULL,1,5000,1,0,0,0,1250,10,'1*1',21,0,1),(82321,'瞭望塔','building.9.lwt',NULL,NULL,1,10,2,0,0,0,2500,10,'2*2',21,0,1),(91421,'海盜旗','building.11.hdq',NULL,NULL,5,68,2,0,0,0,10000,1,'2*1',21,0,0);

/*Table structure for table `island_card` */

DROP TABLE IF EXISTS `island_card`;

CREATE TABLE `island_card` (
  `cid` int(11) NOT NULL COMMENT '道具id',
  `name` varchar(200) DEFAULT NULL COMMENT '道具名称',
  `class_name` varchar(200) DEFAULT NULL COMMENT '道具类名',
  `introduce` varchar(200) DEFAULT NULL COMMENT '介绍',
  `price` int(11) DEFAULT NULL COMMENT '购买价格',
  `price_type` tinyint(4) DEFAULT NULL COMMENT '购买币种,1:coin,2:gold',
  `cheap_price` int(11) DEFAULT '0' COMMENT '折扣价格',
  `cheap_start_time` int(11) DEFAULT '0' COMMENT '开始折扣时间',
  `cheap_end_time` int(11) DEFAULT '0' COMMENT '结束折扣时间',
  `sale_price` int(11) DEFAULT NULL COMMENT '售出价格',
  `add_exp` int(11) DEFAULT NULL COMMENT '增加经验值',
  `need_level` int(11) DEFAULT NULL COMMENT '需要等级',
  `item_type` tinyint(4) DEFAULT '41' COMMENT '41:功能道具',
  `plant_level` tinyint(4) DEFAULT '0',
  `new` tinyint(4) DEFAULT '0' COMMENT '是否新商品,0:非新,1:新  ',
  `can_buy` tinyint(4) DEFAULT '1' COMMENT '是否可以在商店购买,1:可以,0:不可以',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_card` */

insert  into `island_card`(`cid`,`name`,`class_name`,`introduce`,`price`,`price_type`,`cheap_price`,`cheap_start_time`,`cheap_end_time`,`sale_price`,`add_exp`,`need_level`,`item_type`,`plant_level`,`new`,`can_buy`) values (26241,'船隻加速卡I','itemcard.1.jiasu1','減少自己船的到達時間10分鐘，每船每輪1次。',20,1,0,0,0,4,0,1,41,0,0,1),(26341,'船隻加速卡II','itemcard.1.jiasu2','時間新手禮包',1,2,0,0,0,200,0,1,41,0,0,1),(26441,'船隻加速卡III','itemcard.1.jiasu3','階段升級禮包+每日登陸翻牌',2,2,0,0,0,400,0,1,41,0,0,1),(26541,'設施加時卡I','itemcard.1.yanshi1','延長自己設施結算時間+3小時。',1,2,0,0,0,200,0,1,41,0,0,1),(26641,'設施加時卡II','itemcard.1.yanshi2','延長自己設施結算時間+6小時。',2,2,0,0,0,400,0,1,41,0,0,1),(26741,'設施破壞卡','itemcard.1.pohuai','破壞好友設施，出現故障。',2,2,0,0,0,0,0,10,41,0,0,1),(26841,'道具防禦卡','itemcard.1.fangyu','12小時防禦不利道具卡影響。',2000,1,0,0,0,400,0,10,41,0,0,1),(26941,'流氓搶奪卡','itemcard.1.qiangduo','直接獲取好友當前金幣的1%',4,2,0,0,0,800,0,10,41,0,0,1),(27041,'設施稽查卡','itemcard.1.jiucha','隨機罰好友50,100,500金幣',3,2,0,0,0,1,0,10,41,0,0,1),(27141,'碼頭保安卡','itemcard.1.baoan','6小時防禦好友來船塢拉客',2,2,0,0,0,400,0,1,41,0,0,1),(56641,'2星建設卡','itemcard.1.jianshe2','時間新手禮包',999,2,0,0,0,0,0,3,41,0,0,0),(56741,'3星建設卡','itemcard.1.jianshe3','階段升級禮包',999,2,0,0,0,0,0,6,41,0,0,0),(67141,'送神卡','itemcard.1.songsheng','50%機率幫好友把窮神送走',1000,1,0,0,0,0,0,1,41,0,0,1),(67241,'請神卡','itemcard.1.qingsheng','50%幾率把好友的財神仙請過來',2,2,0,0,0,0,0,7,41,0,0,1),(67341,'財神卡','itemcard.1.caisheng','幫好友使用財神，6小時內收入增加20%',1000,1,0,0,0,0,0,7,41,0,0,1),(67441,'一鍵收取卡','itemcard.1.yijianshou','階段升級禮包+每日登陸翻牌',1,2,0,0,0,250,0,5,41,0,0,0),(67541,'超級防禦卡','itemcard.1.cjfangyu','階段升級禮包',1,2,0,0,0,250,0,10,41,0,0,0),(74841,'雙倍經驗卡','itemcard.1.expdouble','階段升級禮包',999,2,0,0,0,0,0,5,41,0,0,0),(86241,'寶箱鑰匙','itemcard.1.bxyaoshi','用於開啟寶箱的神秘鑰匙',0,0,0,0,0,0,0,1,41,0,0,0);

/*Table structure for table `island_casino_award_type` */

DROP TABLE IF EXISTS `island_casino_award_type`;

CREATE TABLE `island_casino_award_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `name` varchar(1800) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `coin` int(11) DEFAULT NULL,
  `gold` int(11) DEFAULT NULL,
  `lv_point` int(11) DEFAULT NULL,
  `item_cid` int(11) DEFAULT NULL,
  `odds` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `island_casino_award_type` */

insert  into `island_casino_award_type`(`id`,`gid`,`name`,`type`,`coin`,`gold`,`lv_point`,`item_cid`,`odds`,`num`) values (1,1,'寶石+5',20,0,5,0,0,200,100000),(2,2,'卡卡西猴',100,0,0,0,98332,50,100000),(3,3,'金幣3000',10,3000,0,0,0,1000,100000),(4,4,'3星建设卡',200,0,0,0,56741,200,100000),(5,5,'金幣10000',10,10000,0,0,0,700,100000),(6,6,'刨冰店',100,0,0,0,96432,70,100000),(7,7,'金幣5000',10,5000,0,0,0,900,100000),(8,8,'自由女神',100,0,0,0,95832,50,100000),(9,9,'一鍵收取卡',200,0,0,0,67441,500,100000),(10,10,'寶石+3',20,0,3,0,0,250,100000),(11,11,'荷花池',100,0,0,0,97632,70,100000),(12,12,'寶石+1',20,0,1,0,0,500,100000),(13,13,'我愛羅猴',100,0,0,0,99032,65,100000),(14,14,'金幣30000',10,30000,0,0,0,500,100000),(15,15,'泳衣店',100,0,0,0,97032,500,100000),(16,16,'金幣7000',10,7000,0,0,0,800,100000),(17,17,'電風扇',100,0,0,0,96321,500,100000),(18,18,'洛克猴',100,0,0,0,98032,70,100000),(19,19,'小櫻猴',100,0,0,0,99132,65,100000),(20,20,'佐助猴',100,0,0,0,99332,50,100000);

/*Table structure for table `island_casino_point_gift` */

DROP TABLE IF EXISTS `island_casino_point_gift`;

CREATE TABLE `island_casino_point_gift` (
  `point` int(11) NOT NULL COMMENT '需要积分',
  `bid` int(11) DEFAULT NULL COMMENT '兑换物品bid',
  PRIMARY KEY (`point`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `island_casino_point_gift` */

insert  into `island_casino_point_gift`(`point`,`bid`) values (10,1),(30,2),(50,3),(100,4),(150,61521),(200,59821),(300,41721),(500,55921),(800,38732),(1000,57032),(1500,46731),(2000,44631);

/*Table structure for table `island_dock` */

DROP TABLE IF EXISTS `island_dock`;

CREATE TABLE `island_dock` (
  `pid` tinyint(4) unsigned NOT NULL COMMENT '拓展船位id',
  `level` smallint(11) unsigned NOT NULL DEFAULT '0' COMMENT '需要等级',
  `power` smallint(11) unsigned NOT NULL DEFAULT '0' COMMENT '需要好友数',
  `price` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '价格',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_dock` */

insert  into `island_dock`(`pid`,`level`,`power`,`price`) values (4,1,5,2000),(5,1,10,4000),(6,1,15,8000),(7,1,20,16000),(8,1,25,32000);

/*Table structure for table `island_feed_template` */

DROP TABLE IF EXISTS `island_feed_template`;

CREATE TABLE `island_feed_template` (
  `id` int(11) NOT NULL,
  `title` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_feed_template` */

insert  into `island_feed_template`(`id`,`title`) values (0,'{*title*}'),(1,'<font color=\"#379636\">{*actor*}</font>從你的<font color=\"#239FD3\">{*shipName*}</font>上拉走了<font color=\"#FF0000\">{*visitorNum*}個遊客</font>！哎，你要是勤奮些，就不會發生這事了！'),(2,'<font color=\"#379636\">{*actor*}</font>幫你修理了出故障的<font color=\"#FF9900\">{*plantName*}</font>,它又開始正常營業了！'),(3,'交友不慎啊，<font color=\"#379636\">{*actor*}</font>使用了<font color=\"#9F01A0\">設施破壞卡</font>，破壞了你的<font color=\"#FF9900\">{*plantName*}</font>設施！'),(4,'<font color=\"#379636\">{*actor*}</font>在你<font color=\"#FF9900\">{*plantName*}</font>裡，拿走了<font color=\"#FF0000\">{*money*}金幣</font>，下次記得早點來結算哦'),(5,'<font color=\"#379636\">{*actor*}</font>對你使用了<font color=\"#9F01A0\">流氓搶奪卡</font>，你被拿走了<font color=\"#FF0000\">{*plunderCoin*}金幣</font>，還是多做點投資吧，手上少留點現金哦！'),(6,'<font color=\"#379636\">{*actor*}</font>對你使用了<font color=\"#9F01A0\">設施稽查卡</font>，你損失了<font color=\"#FF0000\">{*money*}金幣</font>，這種損人又不利己的事……，想辦法回擊吧~！'),(7,'你成功邀請用戶<font color=\"#379636\">{*target*}</font>，獲得系統獎勵<font color=\"#FF0000\">1000金幣</font> <font color=\"#9F01A0\">{*cardName*}</font>,趕快去道具卡倉庫看下吧！'),(8,'你成功的升級到了<font color=\"#FF0000\">{*level*}</font>級，獲得<font color=\"#9F01A0\">{*giftName*}</font>獎勵。'),(9,'你的好友<font color=\"#379636\">{*actor*}</font>給你發了禮物了，趕快去倉庫裡看一下吧！'),(10,'你成功完成一個建設任務，獲得系統獎勵{*sendStr*}'),(11,'你成功達成一個成就，獲得{*sendStr*}獎勵，並獲得<font color=\"#993300\">{*title*}</font>稱號，趕快點擊頭像設置一下吧，這樣每天只要登錄，可以獲得{*daySend*}！'),(12,'<font color=\"#379636\">{*actor*}</font>在你的島上拿走了<font color=\"#FF0000\">{*money*}金幣</font>！哎，你要是勤奮些，就不會發生這事了！'),(13,'<font color=\"#379636\">{*actor*}</font>幫你修理了<font color=\"#FF9900\">{*manage_num*}次設施故障</font>,又開始正常營業了！'),(17,'到今日你已連續登陸<font color=\"#993300\">{*dayCount*}天</font>，獲得<font color=\"#FF0000\">{*coin*}金幣</font>獎勵。'),(18,'到今日你已連續登陸<font color=\"#993300\">{*dayCount*}天</font>，獲得<font color=\"#FF0000\">{*coin*}金幣</font> <font color=\"#0296FA\">{*gold*}寶石</font>獎勵。'),(19,'好友<font color=\"#379636\">{*actor*}</font>幫助你接遊客，有個遊客給了你一張<font color=\"#FF9900\">{*cardName*}</font>'),(20,'<font color=\"#379636\">{*actor*}</font>幫你接待了遊客,<font color=\"#FF0000\">{*helpNum*}遊客</font>上了你的島，<font color=\"#FF0000\">{*visitorNum*}遊客</font>跟你的好友走了。'),(21,'到今日你已連續登陸<font color=\"#993300\">{*dayCount*}天</font>，獲得<font color=\"#FF0000\">{*coin*}金幣</font> <font color=\"#9F01A0\">{*cardName*}</font>獎勵。'),(25,'<font color=\"#379636\">{*actor*}</font>對你使用了財神卡，你的所有設施收入（在結算時）將會增加10%'),(26,'<font color=\"#379636\">{*actor*}</font>把你的財神請走了,收入沒法上升咯'),(27,'你的好友<font color=\"#379636\">{*actor*}</font>伸出正義之手，幫你送走了窮神，你的設施收入恢復了正常'),(28,'在<font color=\"#379636\">{*actor*}</font>光臨你島時帶來了財神，你的所有設施收入（在結算時候）將會增加10%'),(29,'在<font color=\"#379636\">{*actor*}</font>光臨你島時帶來了窮神，你的所有設施收入（在結算時候）將會減少10%'),(30,'太幸運了，接船的時候財神光臨你的島嶼，所有設施收入（在結算時候）將會增加10%'),(31,'太倒楣了，接船的時候窮神光臨你的島嶼，所有設施收入（在結算時候）將會減少10%'),(32,'恭喜你完成新手引導，獲得<font color=\"#FF0000\">{*coin*}金幣</font> <font color=\"#9F01A0\">{*item*}</font>獎勵！快去禮盒中領取吧'),(33,'恭喜你完成{*feedType*}，獲得<font color=\"#FF0000\">{*coin*}金幣</font><font color=\"#2587AF\">{*exp*}經驗</font><font color=\"#9F01A0\">{*item*}</font>獎勵！快去禮盒中領取吧'),(101,'今日<font color=\"#993300\">{*title*}</font>稱號使你獲得<font color=\"#FF0000\">{*coin*}金幣</font>獎勵。'),(102,'今日<font color=\"#993300\">{*title*}</font>稱號使你獲得<font color=\"#FF0000\">{*exp*}經驗</font>獎勵。'),(103,'今日<font color=\"#993300\">{*title*}</font>稱號使你獲得<font color=\"#FF0000\">{*coin*}金幣</font> <font color=\"#FF0000\">{*exp*}經驗</font>獎勵。'),(104,'恭喜你開啟了<font color=\"#379636\">{*level*}級</font>禮包！獲得<font color=\"#FF0000\">{*coin*}金幣 {*star*}海星 {*gift*}</font>'),(105,'<font color=\"#379636\">{*type*}</font>分鐘到了,你成功的從小女孩手裡獲得一份新手禮物'),(106,'恭喜你參加了快樂島主大團購，花費<font color=\"#379636\">{*info*}</font>購買了<font color=\"#FF0000\">{*name*}</font>'),(107,'恭喜你兌換了<font color=\"#379636\">{*name*}</font>'),(108,'恭喜你開啟了<font color=\"#379636\">{*level*}級</font>禮包！獲得<font color=\"#FF0000\">{*coin*}金幣 {*gold*}寶石 {*star*}海星 {*gift*}</font>');

/*Table structure for table `island_gift` */

DROP TABLE IF EXISTS `island_gift`;

CREATE TABLE `island_gift` (
  `id` smallint(5) unsigned NOT NULL,
  `gid` int(10) unsigned NOT NULL COMMENT '礼物id',
  `name` varchar(100) NOT NULL COMMENT '礼物名称',
  `img` varchar(100) NOT NULL COMMENT '图片',
  `level` tinyint(3) unsigned NOT NULL COMMENT '需要级别',
  `item_type` tinyint(4) unsigned NOT NULL COMMENT '11:岛,12:天,13:海,14:船坞,21:绿化,22:地面,31:建筑,32:饮食,41:功能道具',
  `sort` smallint(5) unsigned NOT NULL COMMENT '显示序列',
  `price` tinyint(4) DEFAULT NULL COMMENT '礼物价格',
  `is_free` tinyint(4) DEFAULT '0' COMMENT '0:免费,1:收费',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_gift` */

insert  into `island_gift`(`id`,`gid`,`name`,`img`,`level`,`item_type`,`sort`,`price`,`is_free`) values (1,47021,'熊貓','021.jpg',10,21,1,NULL,0),(2,47321,'直升機','022.jpg',15,21,2,NULL,0),(3,6321,'垃圾桶','001.jpg',1,21,3,NULL,0),(4,6521,'盆栽','002.jpg',1,21,4,NULL,0),(5,6821,'柏樹','003.jpg',1,21,5,NULL,0),(6,7321,'星星樹','004.jpg',1,21,6,NULL,0),(7,8221,'籃球','005.jpg',1,21,7,NULL,0),(8,8721,'粉紅小屋','006.jpg',1,21,8,NULL,0),(9,23013,'救生圈島-海洋','007.jpg',1,13,9,NULL,0),(10,23113,'遊樂場海洋','008.jpg',1,13,10,NULL,0),(11,23412,'紫色天空','009.jpg',1,12,11,NULL,0),(12,23812,'兔月夜','010.jpg',1,12,12,NULL,0),(13,26014,'藍色碼頭','011.jpg',1,14,13,NULL,0),(14,27311,'彩虹島','012.jpg',1,11,14,NULL,0),(15,27721,'字母-方向1-a','013.jpg',10,21,15,NULL,0),(16,28121,'字母-方向1-e','014.jpg',11,21,16,NULL,0),(17,28521,'字母-方向1-i','015.jpg',12,21,17,NULL,0),(18,29121,'字母-方向1-o','016.jpg',13,21,18,NULL,0),(19,29721,'字母-方向1-u','017.jpg',14,21,19,NULL,0),(20,28221,'字母-方向1-f','018.jpg',15,21,20,NULL,0),(21,28821,'字母-方向1-l','019.jpg',16,21,21,NULL,0),(22,30221,'字母-方向1-z','020.jpg',17,21,22,NULL,0),(23,46821,'小熊','023.jpg',10,21,23,5,1),(24,46921,'河馬','024.jpg',9,21,24,5,1),(25,47121,'獅子','025.jpg',8,21,25,5,1),(26,47221,'摩托','026.jpg',7,21,26,5,1),(27,47421,'雙翼飛機','027.jpg',6,21,27,5,1),(28,47521,'火車頭','028.jpg',5,21,28,5,1);

/*Table structure for table `island_hash` */

DROP TABLE IF EXISTS `island_hash`;

CREATE TABLE `island_hash` (
  `key` varchar(255) NOT NULL COMMENT '键',
  `val` text COMMENT '值',
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_hash` */

insert  into `island_hash`(`key`,`val`) values ('bottle:list','a:2:{i:0;a:4:{s:4:\"name\";s:15:\"尋寶第一季\";s:4:\"tips\";s:15:\"尋寶第一季\";s:6:\"online\";b:1;s:3:\"qid\";s:1:\"1\";}i:1;a:4:{s:4:\"name\";s:15:\"尋寶第二季\";s:4:\"tips\";s:15:\"尋寶第二季\";s:6:\"online\";b:1;s:3:\"qid\";s:1:\"2\";}}');

/*Table structure for table `island_level_gift` */

DROP TABLE IF EXISTS `island_level_gift`;

CREATE TABLE `island_level_gift` (
  `level` int(11) NOT NULL,
  `cid` int(11) DEFAULT NULL COMMENT '升级所送礼物id',
  `name` varchar(200) DEFAULT NULL COMMENT '礼物名称',
  `item_id` int(11) DEFAULT NULL COMMENT '建筑id',
  `item_name` varchar(200) DEFAULT NULL COMMENT '建筑名称',
  `gold` int(11) DEFAULT NULL COMMENT '宝石数',
  KEY `level` (`level`),
  KEY `cid` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_level_gift` */

insert  into `island_level_gift`(`level`,`cid`,`name`,`item_id`,`item_name`,`gold`) values (2,26241,'船隻加速卡I',2132,'速食店',3),(3,26541,'設施加時卡I',132,'廁所',3),(4,26341,'船隻加速卡II',0,NULL,3),(5,26641,'設施加時卡II',5232,'花店',3),(6,26441,'船隻加速卡III',1132,'蛋糕店',3),(7,26841,'道具防禦卡',20532,'水果店',3),(8,26341,'船隻加速卡II',21232,'氣球屋',3),(9,26741,'設施破壞卡',19332,'理髮店',3),(10,26241,'船隻加速卡I',17032,'冰淇淋店',3),(11,26941,'流氓搶奪卡',18832,'茶館',4),(12,26341,'船隻加速卡II',0,NULL,4),(13,26641,'設施加時卡II',0,NULL,4),(14,26441,'船隻加速卡III',0,NULL,4),(15,27041,'設施稽查卡',0,NULL,4),(16,26341,'船隻加速卡II',0,NULL,4),(17,26541,'設施加時卡I',0,NULL,4),(18,26241,'船隻加速卡I',0,NULL,4),(19,27141,'碼頭保安卡',0,NULL,4),(20,26341,'船隻加速卡II',0,NULL,4),(21,26641,'設施加時卡II',0,NULL,5),(22,26441,'船隻加速卡III',0,NULL,5),(23,26841,'道具防禦卡',0,NULL,5),(24,26341,'船隻加速卡II',0,NULL,5),(25,26541,'設施加時卡I',0,NULL,5),(26,26241,'船隻加速卡I',0,NULL,5),(27,26741,'設施破壞卡',0,NULL,5),(28,26341,'船隻加速卡II',0,NULL,5),(29,26641,'設施加時卡II',0,NULL,5),(30,26441,'船隻加速卡III',0,NULL,5),(31,27041,'設施稽查卡',0,NULL,6),(32,26341,'船隻加速卡II',0,NULL,6),(33,26541,'設施加時卡I',0,NULL,6),(34,26241,'船隻加速卡I',0,NULL,6),(35,27141,'碼頭保安卡',0,NULL,6),(36,26341,'船隻加速卡II',0,NULL,6),(37,26641,'設施加時卡II',0,NULL,6),(38,26441,'船隻加速卡III',0,NULL,6),(39,26941,'流氓搶奪卡',0,NULL,6),(40,26341,'船隻加速卡II',0,NULL,7),(41,26541,'設施加時卡I',0,NULL,7),(42,26241,'船隻加速卡I',0,NULL,7),(43,26841,'道具防禦卡',0,NULL,7),(44,26441,'船隻加速卡III',0,NULL,7),(45,26641,'設施加時卡II',0,NULL,7),(46,26341,'船隻加速卡II',0,NULL,7),(47,26441,'船隻加速卡III',0,NULL,7),(48,26941,'流氓搶奪卡',0,NULL,7),(49,26341,'船隻加速卡II',0,NULL,7),(50,26541,'設施加時卡I',0,NULL,8),(51,26241,'船隻加速卡I',0,NULL,8),(52,26841,'道具防禦卡',0,NULL,8),(53,26441,'船隻加速卡III',0,NULL,8),(54,26641,'設施加時卡II',0,NULL,8),(55,26341,'船隻加速卡II',0,NULL,8),(56,26541,'設施加時卡I',0,NULL,8),(57,26241,'船隻加速卡I',0,NULL,8),(58,26841,'道具防禦卡',0,NULL,8),(59,26441,'船隻加速卡III',0,NULL,8),(60,26641,'設施加時卡II',0,NULL,8),(61,26341,'船隻加速卡II',0,NULL,8),(62,26541,'設施加時卡I',0,NULL,8),(63,26241,'船隻加速卡I',0,NULL,8),(64,26841,'道具防禦卡',0,NULL,8),(65,26441,'船隻加速卡III',0,NULL,8),(66,26641,'設施加時卡II',0,NULL,8),(67,26341,'船隻加速卡II',0,NULL,8),(68,26541,'設施加時卡I',0,NULL,8),(69,26241,'船隻加速卡I',0,NULL,8),(70,26841,'道具防禦卡',0,NULL,8),(71,26441,'船隻加速卡III',0,NULL,8),(72,26641,'設施加時卡II',0,NULL,8),(73,26341,'船隻加速卡II',0,NULL,8),(74,26541,'設施加時卡I',0,NULL,8),(75,26241,'船隻加速卡I',0,NULL,8),(76,26841,'道具防禦卡',0,NULL,8),(77,26441,'船隻加速卡III',0,NULL,8),(78,26641,'設施加時卡II',0,NULL,8),(79,26341,'船隻加速卡II',0,NULL,8),(80,26541,'設施加時卡I',0,NULL,8),(81,26241,'船隻加速卡I',0,NULL,8),(82,26841,'道具防禦卡',0,NULL,8),(83,26441,'船隻加速卡III',0,NULL,8),(84,26641,'設施加時卡II',0,NULL,8),(85,26341,'船隻加速卡II',0,NULL,8),(86,26541,'設施加時卡I',0,NULL,8),(87,26241,'船隻加速卡I',0,NULL,8),(88,26841,'道具防禦卡',0,NULL,8),(89,26441,'船隻加速卡III',0,NULL,8),(90,26641,'設施加時卡II',0,NULL,8),(91,26341,'船隻加速卡II',0,NULL,8),(92,26541,'設施加時卡I',0,NULL,8),(93,26241,'船隻加速卡I',0,NULL,8),(94,26841,'道具防禦卡',0,NULL,8),(95,26441,'船隻加速卡III',0,NULL,8),(96,26641,'設施加時卡II',0,NULL,8),(97,26341,'船隻加速卡II',0,NULL,8),(98,26541,'設施加時卡I',0,NULL,8),(99,26241,'船隻加速卡I',0,NULL,8),(100,67241,'請神卡',0,NULL,8),(101,67341,'財神卡',0,NULL,8),(102,67441,'一鍵收取卡',0,NULL,8),(103,67541,'超級防禦卡',0,NULL,8),(104,26841,'道具防禦卡',0,NULL,8),(105,26441,'船隻加速卡III',0,NULL,8),(106,26641,'設施加時卡II',0,NULL,8),(107,26341,'船隻加速卡II',0,NULL,8),(108,26541,'設施加時卡I',0,NULL,8),(109,26241,'船隻加速卡I',0,NULL,8),(110,67241,'請神卡',0,NULL,8),(111,67341,'財神卡',0,NULL,8),(112,67441,'一鍵收取卡',0,NULL,8),(113,67541,'超級防禦卡',0,NULL,8),(114,26841,'道具防禦卡',0,NULL,8),(115,26441,'船隻加速卡III',0,NULL,8),(116,26641,'設施加時卡II',0,NULL,8),(117,26341,'船隻加速卡II',0,NULL,8),(118,26541,'設施加時卡I',0,NULL,8),(119,26241,'船隻加速卡I',0,NULL,8),(120,67241,'請神卡',0,NULL,8),(121,67341,'財神卡',0,NULL,8),(122,67441,'一鍵收取卡',0,NULL,8),(123,67541,'超級防禦卡',0,NULL,8),(124,26841,'道具防禦卡',0,NULL,8),(125,26441,'船隻加速卡III',0,NULL,8),(126,26641,'設施加時卡II',0,NULL,8),(127,26341,'船隻加速卡II',0,NULL,8),(128,26541,'設施加時卡I',0,NULL,8),(129,26241,'船隻加速卡I',0,NULL,8),(130,67241,'請神卡',0,NULL,8),(131,67341,'財神卡',0,NULL,8),(132,67441,'一鍵收取卡',0,NULL,8),(133,67541,'超級防禦卡',0,NULL,8),(134,26841,'道具防禦卡',0,NULL,8),(135,26441,'船隻加速卡III',0,NULL,8),(136,26641,'設施加時卡II',0,NULL,8),(137,26341,'船隻加速卡II',0,NULL,8),(138,26541,'設施加時卡I',0,NULL,8),(139,26241,'船隻加速卡I',0,NULL,8),(140,67241,'請神卡',0,NULL,8),(141,67341,'財神卡',0,NULL,8),(142,67441,'一鍵收取卡',0,NULL,8),(143,67541,'超級防禦卡',0,NULL,8),(144,26841,'道具防禦卡',0,NULL,8),(145,26441,'船隻加速卡III',0,NULL,8),(146,26641,'設施加時卡II',0,NULL,8),(147,26341,'船隻加速卡II',0,NULL,8),(148,26541,'設施加時卡I',0,NULL,8),(149,26241,'船隻加速卡I',0,NULL,8),(150,67241,'請神卡',0,NULL,8),(151,67341,'財神卡',0,NULL,8),(152,67441,'一鍵收取卡',0,NULL,8),(153,67541,'超級防禦卡',0,NULL,8),(154,26841,'道具防禦卡',0,NULL,8),(155,26441,'船隻加速卡III',0,NULL,8),(156,26641,'設施加時卡II',0,NULL,8),(157,26341,'船隻加速卡II',0,NULL,8),(158,26541,'設施加時卡I',0,NULL,8),(159,26241,'船隻加速卡I',0,NULL,8),(160,67241,'請神卡',0,NULL,8),(161,67341,'財神卡',0,NULL,8),(162,67441,'一鍵收取卡',0,NULL,8),(163,67541,'超級防禦卡',0,NULL,8),(164,26841,'道具防禦卡',0,NULL,8),(165,26441,'船隻加速卡III',0,NULL,8),(166,26641,'設施加時卡II',0,NULL,8),(167,26341,'船隻加速卡II',0,NULL,8),(168,26541,'設施加時卡I',0,NULL,8),(169,26241,'船隻加速卡I',0,NULL,8),(170,67241,'請神卡',0,NULL,8),(171,67341,'財神卡',0,NULL,8),(172,67441,'一鍵收取卡',0,NULL,8),(173,67541,'超級防禦卡',0,NULL,8),(174,26841,'道具防禦卡',0,NULL,8),(175,26441,'船隻加速卡III',0,NULL,8),(176,26641,'設施加時卡II',0,NULL,8),(177,26341,'船隻加速卡II',0,NULL,8),(178,26541,'設施加時卡I',0,NULL,8),(179,26241,'船隻加速卡I',0,NULL,8),(180,67241,'請神卡',0,NULL,8),(181,67341,'財神卡',0,NULL,8),(182,67441,'一鍵收取卡',0,NULL,8),(183,67541,'超級防禦卡',0,NULL,8),(184,26841,'道具防禦卡',0,NULL,8),(185,26441,'船隻加速卡III',0,NULL,8),(186,26641,'設施加時卡II',0,NULL,8),(187,26341,'船隻加速卡II',0,NULL,8),(188,26541,'設施加時卡I',0,NULL,8),(189,26241,'船隻加速卡I',0,NULL,8),(190,67241,'請神卡',0,NULL,8),(191,67341,'財神卡',0,NULL,8),(192,67441,'一鍵收取卡',0,NULL,8),(193,67541,'超級防禦卡',0,NULL,8),(194,26841,'道具防禦卡',0,NULL,8),(195,26441,'船隻加速卡III',0,NULL,8),(196,26641,'設施加時卡II',0,NULL,8),(197,26341,'船隻加速卡II',0,NULL,8),(198,26541,'設施加時卡I',0,NULL,8),(199,26241,'船隻加速卡I',0,NULL,8),(200,67241,'請神卡',0,NULL,8);

/*Table structure for table `island_level_gift_step` */

DROP TABLE IF EXISTS `island_level_gift_step`;

CREATE TABLE `island_level_gift_step` (
  `level` int(11) NOT NULL COMMENT '等级',
  `coin` int(11) DEFAULT '0' COMMENT '金币',
  `gold` int(11) DEFAULT '0' COMMENT '宝石',
  `star` int(11) DEFAULT '0' COMMENT '海星',
  `item_id` varchar(200) DEFAULT NULL COMMENT '礼物id',
  `item_num` varchar(200) DEFAULT NULL COMMENT '礼物数量',
  PRIMARY KEY (`level`),
  KEY `level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_level_gift_step` */

insert  into `island_level_gift_step`(`level`,`coin`,`gold`,`star`,`item_id`,`item_num`) values (5,3000,3,5,'67441,74841,37321','1,1,1'),(10,10000,4,5,'26441,74841,36421','2,2,1'),(15,50000,4,5,'67441,74841,42421','3,2,1'),(20,70000,4,10,'67441,42821,74841','4,1,4'),(25,100000,5,10,'67441,26441,43221','5,4,1'),(30,150000,6,10,'74841,67441,45621','5,6,1'),(35,220000,7,20,'67441,67541,53521','7,7,1'),(40,300000,7,20,'74841,67441,63621','6,8,1'),(45,500000,8,20,'74841,67441,66421','6,9,1'),(50,700000,9,30,'74841,67441,37021','8,10,1'),(55,1000000,10,30,'74841,56741,37221','8,1,1'),(60,1500000,0,30,'74841,67441,63821','10,12,1'),(65,2000000,15,50,'74841,61621','10,1'),(70,2500000,20,50,'74841,7721','14,1'),(75,3500000,20,50,'74841,27721','15,1'),(80,4500000,20,50,'74841,34521','16,1'),(85,6000000,20,50,'74841,36721','17,1'),(90,8000000,20,50,'74841,38221','18,1'),(95,10000000,20,50,'67441,41521','19,1'),(100,10000000,20,50,'74841,67921','20,1'),(105,10000000,20,50,'74841,67441,68021','20,20,1'),(110,10000000,20,50,'74841,67441,68421','20,20,1'),(115,10000000,20,50,'74841,67441,68521','20,20,1'),(120,10000000,20,50,'74841,67441,68621','20,20,1'),(125,10000000,20,50,'74841,67441,71321','20,20,1'),(130,10000000,20,50,'74841,67441,71421','20,20,1'),(135,10000000,20,50,'74841,67441,71521','20,20,1'),(140,10000000,20,50,'74841,67441,71621','20,20,1'),(145,10000000,20,50,'74841,67441,75921','20,20,1'),(150,10000000,20,50,'74841,67441,76021','20,20,1'),(155,10000000,20,50,'74841,67441,76121','20,20,1'),(160,10000000,20,50,'74841,67441,76221','20,20,1'),(165,10000000,20,50,'74841,67441,76321','20,20,1'),(170,10000000,20,50,'74841,67441,76421','20,20,1'),(175,10000000,20,50,'74841,67441,76521','20,20,1'),(180,10000000,20,50,'74841,67441,76621','20,20,1'),(185,10000000,20,50,'74841,67441,81721','20,20,1'),(190,10000000,20,50,'74841,67441,81821','20,20,1'),(195,10000000,20,50,'74841,67441,82021','20,20,1'),(200,10000000,20,50,'74841,67441,82321','20,20,1');

/*Table structure for table `island_level_island` */

DROP TABLE IF EXISTS `island_level_island`;

CREATE TABLE `island_level_island` (
  `level` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '岛屿级别',
  `need_user_level` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '升级初始岛需要用户等级',
  `need_user_level_2` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '升级第二岛屿',
  `need_user_level_3` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '升级第三岛屿',
  `need_user_level_4` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '升级第四岛屿',
  `island_size` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '岛屿允许大小',
  `max_visitor` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '岛屿允许最大游客数',
  `gold` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '升级需求宝石数',
  `coin` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '升级需求金币数',
  PRIMARY KEY (`level`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `island_level_island` */

insert  into `island_level_island`(`level`,`need_user_level`,`need_user_level_2`,`need_user_level_3`,`need_user_level_4`,`island_size`,`max_visitor`,`gold`,`coin`) values (1,1,1,1,1,10,20,0,0),(2,1,1,1,1,12,27,0,0),(3,1,1,1,1,14,34,0,0),(4,1,15,1,1,16,41,0,0),(5,6,16,1,1,18,48,4,0),(6,8,17,1,1,20,55,9,0),(7,12,19,1,1,22,62,16,0),(8,14,20,1,1,24,69,25,0),(9,18,23,1,1,26,76,36,0),(10,22,24,25,1,28,83,49,0),(11,27,26,29,1,30,90,65,0),(12,33,28,42,40,32,97,83,0),(13,37,34,44,45,34,104,103,0),(14,39,40,45,50,36,111,125,0);

/*Table structure for table `island_level_user` */

DROP TABLE IF EXISTS `island_level_user`;

CREATE TABLE `island_level_user` (
  `level` int(11) NOT NULL AUTO_INCREMENT COMMENT '玩家级别',
  `exp` int(11) DEFAULT NULL COMMENT '升级需要经验',
  PRIMARY KEY (`level`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8;

/*Data for the table `island_level_user` */

insert  into `island_level_user`(`level`,`exp`) values (1,0),(2,40),(3,260),(4,777),(5,1689),(6,3085),(7,5047),(8,7653),(9,10975),(10,15084),(11,20047),(12,25931),(13,32798),(14,40711),(15,49729),(16,59911),(17,71316),(18,83999),(19,98016),(20,113421),(21,130269),(22,148611),(23,168501),(24,189988),(25,213123),(26,237957),(27,264538),(28,292915),(29,323137),(30,355250),(31,389303),(32,425340),(33,463410),(34,503556),(35,545825),(36,590260),(37,636908),(38,685811),(39,737014),(40,790559),(41,846490),(42,904850),(43,965680),(44,1029022),(45,1094920),(46,1163413),(47,1234543),(48,1308351),(49,1384877),(50,1464163),(51,1546247),(52,1631171),(53,1718973),(54,1809693),(55,1903370),(56,2000043),(57,2099750),(58,2202531),(59,2308424),(60,2417466),(61,2529696),(62,2645151),(63,2763870),(64,2885888),(65,3011244),(66,3139974),(67,3272115),(68,3407705),(69,3546778),(70,3689373),(71,3835524),(72,3985268),(73,4138641),(74,4295678),(75,4456415),(76,4620888),(77,4789131),(78,4961180),(79,5137069),(80,5316834),(81,5500510),(82,5688130),(83,5879730),(84,6075344),(85,6275005),(86,6478748),(87,6686607),(88,6898616),(89,7114808),(90,7335218),(91,7559878),(92,7788821),(93,8022083),(94,8259694),(95,8501689),(96,8748100),(97,8998960),(98,9254302),(99,9514159),(100,9778563),(101,10047546),(102,10321141),(103,10599380),(104,10882295),(105,11169919),(106,11462282),(107,11759418),(108,12061358),(109,12368133),(110,12679775),(111,12996315),(112,13317786),(113,13644218),(114,13975643),(115,14312091),(116,14653594),(117,15000183),(118,15351889),(119,15708742),(120,16070774),(121,16438014),(122,16810495),(123,17188245),(124,17571296),(125,17959678),(126,18353421),(127,18752556),(128,19157112),(129,19567120),(130,19982610),(131,20403611),(132,20830154),(133,21262269),(134,21699984),(135,22143331),(136,22592337),(137,23047034),(138,23507450),(139,23973615),(140,24445558),(141,24923308),(142,25406895),(143,25896348),(144,26391696),(145,26892967),(146,27400191),(147,27913398),(148,28432614),(149,28957871),(150,29489195),(151,30026616),(152,30570163),(153,31119863),(154,31675746),(155,32237840),(156,32806173),(157,33380774),(158,33961671),(159,34548892),(160,35142465),(161,35742419),(162,36348781),(163,36961580),(164,37580843),(165,38206599),(166,38838875),(167,39477699),(168,40123098),(169,40775102),(170,41433736),(171,42099029),(172,42771008),(173,43449702),(174,44135136),(175,44827339),(176,45526338),(177,46232161),(178,46944834),(179,47664385),(180,48390842),(181,49124230),(182,49864577),(183,50611911),(184,51366259),(185,52127646),(186,52896101),(187,53671649),(188,54454319),(189,55244136),(190,56041127),(191,56845320),(192,57656740),(193,58475414),(194,59301370),(195,60134633),(196,60975229),(197,61823186),(198,62678530),(199,63541287),(200,64411483);

/*Table structure for table `island_lottery_item_odds` */

DROP TABLE IF EXISTS `island_lottery_item_odds`;

CREATE TABLE `island_lottery_item_odds` (
  `category_id` tinyint(3) unsigned NOT NULL COMMENT '1-翻牌',
  `order` int(10) unsigned NOT NULL,
  `item_id` int(11) NOT NULL COMMENT '1-金币 2-宝石',
  `item_type` tinyint(3) unsigned NOT NULL COMMENT '1-金币 2-宝石',
  `item_num` int(10) unsigned NOT NULL,
  `item_odds` int(10) unsigned NOT NULL,
  PRIMARY KEY (`category_id`,`order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_lottery_item_odds` */

insert  into `island_lottery_item_odds`(`category_id`,`order`,`item_id`,`item_type`,`item_num`,`item_odds`) values (1,1,2,2,3,10),(1,2,43221,21,1,11),(1,3,73821,21,1,11),(1,4,67441,41,1,10),(1,5,43021,21,1,10),(1,6,26441,41,1,11),(1,7,3,3,2,5),(1,8,1,1,5000,15),(1,9,1,1,2500,11);

/*Table structure for table `island_notice` */

DROP TABLE IF EXISTS `island_notice`;

CREATE TABLE `island_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '',
  `position` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `priority` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `link` varchar(255) NOT NULL DEFAULT '',
  `opened` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `island_notice` */

insert  into `island_notice`(`id`,`title`,`position`,`priority`,`link`,`opened`,`create_time`) values (1,'機器人狂襲、收集任務、寶箱功能上線',1,1,'http://www.facebook.com/note.php?created&&note_id=165172866888201',1,1311074855),(2,'快樂島主版本大升級功能說明',1,2,'http://www.facebook.com/note.php?created&&note_id=162792273792927',1,1310616000),(3,'改版升級好康活動看這裡',1,3,'http://www.facebook.com/note.php?created&&note_id=162814160457405',1,1310616000),(4,'島主改版停機更新作業說明',1,4,'http://goo.gl/JORkr',1,1310529600);

/*Table structure for table `island_plant` */

DROP TABLE IF EXISTS `island_plant`;

CREATE TABLE `island_plant` (
  `cid` int(11) NOT NULL COMMENT '海岛装饰物id',
  `name` varchar(200) DEFAULT NULL COMMENT '名称',
  `class_name` varchar(200) DEFAULT NULL COMMENT '图像素材',
  `map` varchar(200) DEFAULT NULL COMMENT '缩图',
  `content` varchar(200) DEFAULT NULL COMMENT '介绍',
  `add_praise` int(4) DEFAULT '0' COMMENT '好评度增加数',
  `price` int(11) DEFAULT NULL COMMENT '购买价格',
  `price_type` tinyint(4) DEFAULT NULL COMMENT '购买币种,1:coin,2:gold',
  `cheap_price` int(11) DEFAULT '0' COMMENT '折扣价格',
  `cheap_start_time` int(11) DEFAULT '0' COMMENT '开始折扣时间',
  `cheap_end_time` int(11) DEFAULT '0' COMMENT '结束折扣时间',
  `sale_price` int(11) DEFAULT NULL COMMENT '售出价格',
  `need_level` int(11) DEFAULT NULL COMMENT '使用需要等级',
  `nodes` varchar(200) DEFAULT NULL COMMENT '装饰类占地信息',
  `item_type` tinyint(4) DEFAULT NULL COMMENT '31:游乐,32:生活,33:公共',
  `item_id` int(11) DEFAULT NULL COMMENT '设施类型 id，同一设施不同级别的 item_id 相同',
  `new` tinyint(4) DEFAULT '0' COMMENT '是否新商品,0:非新,1:新',
  `can_buy` tinyint(4) DEFAULT '1' COMMENT '是否可以在商店购买,1:可以,0:不可以',
  `ticket` int(4) DEFAULT NULL COMMENT '设施收费',
  `pay_time` int(11) DEFAULT NULL COMMENT '结算时间',
  `safe_time` int(11) DEFAULT NULL COMMENT '保护时间',
  `safe_coin_num` varchar(200) DEFAULT NULL COMMENT '保护钱数',
  `need_praise` int(11) DEFAULT NULL COMMENT '需要好评度',
  `level` tinyint(4) DEFAULT '1' COMMENT '设施等级',
  `next_level_cid` int(11) DEFAULT NULL COMMENT '升级后对应的 bid',
  `act_name` varchar(200) DEFAULT NULL COMMENT '相关活动名',
  PRIMARY KEY (`cid`),
  KEY `need_level` (`need_level`),
  KEY `level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_plant` */

insert  into `island_plant`(`cid`,`name`,`class_name`,`map`,`content`,`add_praise`,`price`,`price_type`,`cheap_price`,`cheap_start_time`,`cheap_end_time`,`sale_price`,`need_level`,`nodes`,`item_type`,`item_id`,`new`,`can_buy`,`ticket`,`pay_time`,`safe_time`,`safe_coin_num`,`need_praise`,`level`,`next_level_cid`,`act_name`) values (132,'廁所','building.1.cesuo1',NULL,NULL,1,1000,1,0,0,0,200,1,'2*2',32,1,0,1,10,3600,NULL,'0.666666666666667',4,1,232,NULL),(232,'廁所','building.3.cesuo2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',32,1,0,0,16,3600,NULL,'0.666666666666667',16,2,332,NULL),(332,'廁所','building.3.cesuo3',NULL,NULL,3,6,2,0,0,0,1800,4,'2*2',32,1,0,0,26,3600,NULL,'0.666666666666667',30,3,432,NULL),(432,'廁所','building.3.cesuo4',NULL,NULL,4,105000,1,0,0,0,22800,8,'2*2',32,1,0,0,42,3600,NULL,'0.666666666666667',118,4,532,NULL),(532,'廁所','building.3.cesuo5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',32,1,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(632,'旅館','building.1.lvguan1',NULL,NULL,1,1000,1,0,0,0,200,1,'2*2',32,6,0,1,10,3600,NULL,'0.666666666666667',4,1,732,NULL),(732,'旅館','building.3.lvguan2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',32,6,0,0,16,3600,NULL,'0.666666666666667',11,2,832,NULL),(832,'旅館','building.3.lvguan3',NULL,NULL,3,6,2,0,0,0,2000,4,'2*2',32,6,0,0,26,3600,NULL,'0.666666666666667',30,3,932,NULL),(932,'旅館','building.3.lvguan4',NULL,NULL,4,105000,1,0,0,0,23000,8,'2*2',32,6,0,0,42,3600,NULL,'0.666666666666667',118,4,1032,NULL),(1032,'旅館','building.3.lvguan5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',32,6,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(1132,'蛋糕店','building.1.dangaodian1',NULL,NULL,1,1000,1,0,0,0,200,1,'2*2',32,11,0,1,10,3600,NULL,'0.666666666666667',10,1,1232,NULL),(1232,'蛋糕店','building.3.dangaodian2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',32,11,0,0,16,3600,NULL,'0.666666666666667',16,2,1332,NULL),(1332,'蛋糕店','building.3.dangaodian3',NULL,NULL,3,6,2,0,0,0,2000,4,'2*2',32,11,0,0,26,3600,NULL,'0.666666666666667',30,3,1432,NULL),(1432,'蛋糕店','building.3.dangaodian4',NULL,NULL,4,105000,1,0,0,0,23000,8,'2*2',32,11,0,0,42,3600,NULL,'0.666666666666667',118,4,1532,NULL),(1532,'蛋糕店','building.3.dangaodian5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',32,11,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(1632,'飲料亭','building.1.yinliaoting1',NULL,NULL,1,1000,1,0,0,0,200,1,'2*2',32,16,0,1,10,3600,NULL,'0.666666666666667',4,1,1732,NULL),(1732,'飲料亭','building.3.yinliaoting2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',32,16,0,0,16,3600,NULL,'0.666666666666667',16,2,1832,NULL),(1832,'飲料亭','building.3.yinliaoting3',NULL,NULL,3,6,2,0,0,0,2000,4,'2*2',32,16,0,0,26,3600,NULL,'0.666666666666667',30,3,1932,NULL),(1932,'飲料亭','building.3.yinliaoting4',NULL,NULL,4,105000,1,0,0,0,23000,8,'2*2',32,16,0,0,42,3600,NULL,'0.666666666666667',118,4,2032,NULL),(2032,'飲料亭','building.3.yinliaoting5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',32,16,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(2132,'速食店','building.1.kuaican1',NULL,NULL,1,1000,1,0,0,0,200,1,'2*2',32,21,0,1,10,3600,NULL,'0.666666666666667',12,1,2232,NULL),(2232,'速食店','building.3.kuaican2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',32,21,0,0,16,3600,NULL,'0.666666666666667',16,2,2332,NULL),(2332,'速食店','building.3.kuaican3',NULL,NULL,3,6,2,0,0,0,2000,4,'2*2',32,21,0,0,26,3600,NULL,'0.666666666666667',30,3,2432,NULL),(2432,'速食店','building.3.kuaican4',NULL,NULL,4,105000,1,0,0,0,23000,8,'2*2',32,21,0,0,42,3600,NULL,'0.666666666666667',118,4,2532,NULL),(2532,'速食店','building.3.kuaican5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',32,21,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(2631,'城堡','building.1.chengbao1',NULL,NULL,1,5000,1,0,0,0,1000,2,'4*4',31,26,0,1,39,43200,NULL,'0.666666666666667',60,1,2731,NULL),(2731,'城堡','building.3.chengbao2',NULL,NULL,2,15000,1,0,0,0,4000,2,'4*4',31,26,0,0,48,43200,NULL,'0.666666666666667',70,2,2831,NULL),(2831,'城堡','building.3.chengbao3',NULL,NULL,3,30,2,0,0,0,10000,4,'4*4',31,26,0,0,60,43200,NULL,'0.666666666666667',80,3,2931,NULL),(2931,'城堡','building.3.chengbao4',NULL,NULL,4,525000,1,0,0,0,115000,20,'4*4',31,26,0,0,73,43200,NULL,'0.666666666666667',176,4,3031,NULL),(3031,'城堡','building.3.chengbao5',NULL,NULL,5,263,2,0,0,0,167500,26,'4*4',31,26,0,0,90,43200,NULL,'0.666666666666667',176,5,0,NULL),(3132,'露營帳篷','building.1.luying1',NULL,NULL,3,6,2,0,0,0,1200,1,'2*2',32,31,0,1,26,3600,NULL,'0.666666666666667',10,3,3232,NULL),(3232,'露營帳篷','building.3.luying2',NULL,NULL,4,105000,1,0,0,0,22200,8,'2*2',32,31,0,0,42,3600,NULL,'0.666666666666667',118,4,3332,NULL),(3332,'露營帳篷','building.3.luying3',NULL,NULL,5,53,2,0,0,0,32700,26,'2*2',32,31,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(3431,'海盜船','building.1.haidaochuan1',NULL,NULL,3,14,2,0,0,0,2700,1,'3*3',31,34,0,1,40,14400,NULL,'0.666666666666667',30,3,3531,NULL),(3531,'海盜船','building.3.haidaochuan2',NULL,NULL,4,236250,1,0,0,0,49950,8,'3*3',31,34,0,0,55,14400,NULL,'0.666666666666667',40,4,3631,NULL),(3631,'海盜船','building.3.haidaochuan3',NULL,NULL,5,118,2,0,0,0,73575,26,'3*3',31,34,0,0,77,14400,NULL,'0.666666666666667',118,5,0,NULL),(3931,'風車','building.1.fengche1',NULL,NULL,1,1000,1,0,0,0,200,1,'2*2',31,39,0,1,10,3600,NULL,'0.666666666666667',4,1,4031,NULL),(4031,'風車','building.3.fengche2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',31,39,0,0,16,3600,NULL,'0.666666666666667',16,2,4131,NULL),(4131,'風車','building.3.fengche3',NULL,NULL,3,6,2,0,0,0,1800,4,'2*2',31,39,0,0,26,3600,NULL,'0.666666666666667',30,3,4231,NULL),(4231,'風車','building.3.fengche4',NULL,NULL,4,105000,1,0,0,0,22800,8,'2*2',31,39,0,0,42,3600,NULL,'0.666666666666667',118,4,4331,NULL),(4331,'風車','building.3.fengche5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',31,39,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(4431,'沙灘排球','building.1.shatanpaiqiu1',NULL,NULL,3,9,2,0,0,0,1800,1,'3*2',31,44,0,1,32,10800,NULL,'0.666666666666667',30,3,4531,NULL),(4531,'沙灘排球','building.3.shatanpaiqiu2',NULL,NULL,4,157500,1,0,0,0,33300,19,'3*2',31,44,0,0,49,10800,NULL,'0.666666666666667',118,4,4631,NULL),(4631,'沙灘排球','building.3.shatanpaiqiu3',NULL,NULL,5,79,2,0,0,0,49050,26,'3*2',31,44,0,0,73,10800,NULL,'0.666666666666667',118,5,0,NULL),(4732,'教堂','building.1.jiaotang1',NULL,NULL,1,2250,1,0,0,0,450,8,'3*3',32,47,0,1,20,14400,NULL,'0.666666666666667',50,1,4832,NULL),(4832,'教堂','building.3.jiaotang2',NULL,NULL,2,6750,1,0,0,0,1800,9,'3*3',32,47,0,0,28,14400,NULL,'0.666666666666667',40,2,4932,NULL),(4932,'教堂','building.3.jiaotang3',NULL,NULL,3,14,2,0,0,0,4500,10,'3*3',32,47,0,0,40,14400,NULL,'0.666666666666667',50,3,5032,NULL),(5032,'教堂','building.3.jiaotang4',NULL,NULL,4,236250,1,0,0,0,51750,11,'3*3',32,47,0,0,55,14400,NULL,'0.666666666666667',118,4,5132,NULL),(5132,'教堂','building.3.jiaotang5',NULL,NULL,5,118,2,0,0,0,75375,26,'3*3',32,47,0,0,77,14400,NULL,'0.666666666666667',118,5,0,NULL),(5232,'花店','building.1.huadian1',NULL,NULL,1,1000,1,0,0,0,200,5,'2*2',32,52,0,1,10,3600,NULL,'0.666666666666667',24,1,5332,NULL),(5332,'花店','building.3.huadian2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',32,52,0,0,16,3600,NULL,'0.666666666666667',28,2,5432,NULL),(5432,'花店','building.4.huadian3',NULL,NULL,3,54000,1,0,0,0,13500,4,'2*2',32,52,0,0,26,3600,NULL,'0.666666666666667',30,3,5532,NULL),(5532,'花店','building.4.huadian4',NULL,NULL,4,105000,1,0,0,0,23000,8,'2*2',32,52,0,0,42,3600,NULL,'0.666666666666667',118,4,5632,NULL),(5632,'花店','building.3.huadian5',NULL,NULL,5,199500,1,0,0,0,49875,26,'2*2',32,52,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(5731,'劇院','building.1.juyuan1',NULL,NULL,1,1000,1,0,0,0,200,10,'2*2',31,57,0,1,10,3600,NULL,'0.666666666666667',40,1,5831,NULL),(5831,'劇院','building.3.juyuan2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',31,57,0,0,16,3600,NULL,'0.666666666666667',44,2,5931,NULL),(5931,'劇院','building.3.juyuan3',NULL,NULL,3,6,2,0,0,0,2000,4,'2*2',31,57,0,0,26,3600,NULL,'0.666666666666667',48,3,6031,NULL),(6031,'劇院','building.4.juyuan4',NULL,NULL,4,105000,1,0,0,0,23000,18,'2*2',31,57,0,0,42,3600,NULL,'0.666666666666667',118,4,6131,NULL),(6131,'劇院','building.3.juyuan5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',31,57,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(14431,'KTV','building.1.kalaok1',NULL,NULL,3,6,2,0,0,0,1200,1,'2*2',31,144,0,1,26,3600,NULL,'0.666666666666667',30,3,14531,NULL),(14531,'KTV','building.3.kalaok2',NULL,NULL,4,105000,1,0,0,0,22200,18,'2*2',31,144,0,0,42,3600,NULL,'0.666666666666667',118,4,14631,NULL),(14631,'KTV','building.3.kalaok3',NULL,NULL,5,53,2,0,0,0,32700,26,'2*2',31,144,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(14732,'禮品店','building.1.lipindian1',NULL,NULL,1,1000,1,0,0,0,200,2,'2*2',32,147,0,1,10,3600,NULL,'0.666666666666667',10,1,14832,NULL),(14832,'禮品店','building.3.lipindian2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',32,147,0,0,16,3600,NULL,'0.666666666666667',16,2,14932,NULL),(14932,'禮品店','building.3.lipindian3',NULL,NULL,3,6,2,0,0,0,2000,4,'2*2',32,147,0,0,26,3600,NULL,'0.666666666666667',30,3,15032,NULL),(15032,'禮品店','building.3.lipindian4',NULL,NULL,4,105000,1,0,0,0,23000,8,'2*2',32,147,0,0,42,3600,NULL,'0.666666666666667',118,4,15132,NULL),(15132,'禮品店','building.3.lipindian5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',32,147,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(15231,'鯨魚館','building.1.jingyuguan1',NULL,NULL,3,14,2,0,0,0,2700,1,'3*3',31,152,0,1,40,14400,NULL,'0.666666666666667',30,3,15331,NULL),(15331,'鯨魚館','building.3.jingyuguan2',NULL,NULL,4,236250,1,0,0,0,49950,8,'3*3',31,152,0,0,55,14400,NULL,'0.666666666666667',118,4,15431,NULL),(15431,'鯨魚館','building.3.jingyuguan3',NULL,NULL,5,118,2,0,0,0,73575,26,'3*3',31,152,0,0,77,14400,NULL,'0.666666666666667',118,5,0,NULL),(15531,'雲霄飛車','building.1.guoshanche1',NULL,NULL,1,5000,1,0,0,0,1000,5,'4*4',31,155,0,1,39,43200,NULL,'0.666666666666667',70,1,15631,NULL),(15631,'雲霄飛車','building.3.guoshanche2',NULL,NULL,2,15000,1,0,0,0,4000,6,'4*4',31,155,0,0,48,43200,NULL,'0.666666666666667',80,2,15731,NULL),(15731,'雲霄飛車','building.3.guoshanche3',NULL,NULL,3,30,2,0,0,0,10000,7,'4*4',31,155,0,0,60,43200,NULL,'0.666666666666667',90,3,15831,NULL),(15831,'雲霄飛車','building.3.guoshanche4',NULL,NULL,4,525000,1,0,0,0,115000,18,'4*4',31,155,0,0,73,43200,NULL,'0.666666666666667',176,4,15931,NULL),(15931,'雲霄飛車','building.4.guoshanche5',NULL,NULL,5,263,2,0,0,0,167500,26,'4*4',31,155,0,0,90,43200,NULL,'0.666666666666667',176,5,0,NULL),(16031,'鬼屋','building.1.guiwu1',NULL,NULL,1,1000,1,0,0,0,200,4,'2*2',31,160,0,1,10,3600,NULL,'0.666666666666667',20,1,16131,NULL),(16131,'鬼屋','building.3.guiwu2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',31,160,0,0,16,3600,NULL,'0.666666666666667',16,2,16231,NULL),(16231,'鬼屋','building.3.guiwu3',NULL,NULL,3,6,2,0,0,0,2000,4,'2*2',31,160,0,0,26,3600,NULL,'0.666666666666667',30,3,16331,NULL),(16331,'鬼屋','building.3.guiwu4',NULL,NULL,4,105000,1,0,0,0,23000,8,'2*2',31,160,0,0,42,3600,NULL,'0.666666666666667',118,4,16431,NULL),(16431,'鬼屋','building.3.guiwu5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',31,160,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(16532,'SPA','building.1.spa1',NULL,NULL,1,1000,1,0,0,0,200,12,'2*2',32,165,0,1,10,3600,NULL,'0.666666666666667',10,1,16632,NULL),(16632,'SPA','building.3.spa2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',32,165,0,0,16,3600,NULL,'0.666666666666667',16,2,16732,NULL),(16732,'SPA','building.3.spa3',NULL,NULL,3,6,2,0,0,0,2000,4,'2*2',32,165,0,0,26,3600,NULL,'0.666666666666667',30,3,16832,NULL),(16832,'SPA','building.3.spa4',NULL,NULL,4,105000,1,0,0,0,23000,8,'2*2',32,165,0,0,42,3600,NULL,'0.666666666666667',118,4,16932,NULL),(16932,'SPA','building.3.spa5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',32,165,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(17032,'霜淇淋店','building.1.bingqilin1',NULL,NULL,1,1000,1,0,0,0,200,3,'2*2',32,170,0,1,10,3600,NULL,'0.666666666666667',10,1,17132,NULL),(17132,'霜淇淋店','building.3.bingqilin2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',32,170,0,0,16,3600,NULL,'0.666666666666667',16,2,17232,NULL),(17232,'霜淇淋店','building.3.bingqilin3',NULL,NULL,3,6,2,0,0,0,2000,4,'2*2',32,170,0,0,26,3600,NULL,'0.666666666666667',30,3,17332,NULL),(17332,'霜淇淋店','building.3.bingqilin4',NULL,NULL,4,105000,1,0,0,0,23000,8,'2*2',32,170,0,0,42,3600,NULL,'0.666666666666667',118,4,17432,NULL),(17432,'霜淇淋店','building.3.bingqilin5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',32,170,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(17532,'沙灘椅','building.1.shatanyi1',NULL,NULL,1,1000,1,0,0,0,200,3,'2*2',32,175,0,1,10,3600,NULL,'0.666666666666667',10,1,17632,NULL),(17632,'沙灘椅','building.3.shatanyi2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',32,175,0,0,16,3600,NULL,'0.666666666666667',16,2,17732,NULL),(17732,'沙灘椅','building.3.shatanyi3',NULL,NULL,3,6,2,0,0,0,2000,4,'2*2',32,175,0,0,26,3600,NULL,'0.666666666666667',30,3,17832,NULL),(17832,'沙灘椅','building.3.shatanyi4',NULL,NULL,4,105000,1,0,0,0,23000,8,'2*2',32,175,0,0,42,3600,NULL,'0.666666666666667',118,4,17932,NULL),(17932,'沙灘椅','building.3.shatanyi5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',32,175,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(18031,'旋轉木馬','building.1.xuanzhuanmuma1',NULL,NULL,3,30,2,0,0,0,6000,6,'4*4',31,180,0,1,60,43200,NULL,'0.666666666666667',30,3,18131,NULL),(18131,'旋轉木馬','building.3.xuanzhuanmuma2',NULL,NULL,4,525000,1,0,0,0,111000,8,'4*4',31,180,0,0,73,43200,NULL,'0.666666666666667',176,4,18231,NULL),(18231,'旋轉木馬','building.3.xuanzhuanmuma3',NULL,NULL,5,263,2,0,0,0,163500,26,'4*4',31,180,0,0,90,43200,NULL,'0.666666666666667',176,5,0,NULL),(18331,'兒童樂園','building.1.ertongleyuan1',NULL,NULL,3,18,2,0,0,0,5000,1,'4*3',31,183,0,1,45,21600,NULL,'0.666666666666667',10,3,18431,NULL),(18431,'兒童樂園','building.3.ertongleyuan2',NULL,NULL,4,315000,1,0,0,0,15750,5,'4*3',31,183,0,0,60,21600,NULL,'0.666666666666667',20,4,18531,NULL),(18531,'兒童樂園','building.3.ertongleyuan3',NULL,NULL,5,615000,1,0,0,0,30750,10,'4*3',31,183,0,0,80,21600,NULL,'0.666666666666667',30,5,18831,NULL),(18832,'茶館','building.1.chaguan1',NULL,NULL,1,1000,1,0,0,0,200,11,'2*2',32,188,0,1,10,3600,NULL,'0.666666666666667',44,1,18932,NULL),(18932,'茶館','building.3.chaguan2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',32,188,0,0,16,3600,NULL,'0.666666666666667',48,2,19032,NULL),(19032,'茶館','building.3.chaguan3',NULL,NULL,3,6,2,0,0,0,1800,4,'2*2',32,188,0,0,26,3600,NULL,'0.666666666666667',52,3,19132,NULL),(19132,'茶館','building.3.chaguan4',NULL,NULL,4,105000,1,0,0,0,22800,8,'2*2',32,188,0,0,42,3600,NULL,'0.666666666666667',118,4,19232,NULL),(19232,'茶館','building.3.chaguan5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',32,188,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(19332,'理髮店','building.1.lifadian1',NULL,NULL,1,1000,1,0,0,0,200,9,'2*2',32,193,0,1,10,3600,NULL,'0.666666666666667',36,1,19432,NULL),(19432,'理髮店','building.3.lifadian2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',32,193,0,0,16,3600,NULL,'0.666666666666667',40,2,19532,NULL),(19532,'理髮店','building.3.lifadian3',NULL,NULL,3,6,2,0,0,0,2000,4,'2*2',32,193,0,0,26,3600,NULL,'0.666666666666667',44,3,19632,NULL),(19632,'理髮店','building.3.lifadian4',NULL,NULL,4,105000,1,0,0,0,23000,8,'2*2',32,193,0,0,42,3600,NULL,'0.666666666666667',118,4,19732,NULL),(19732,'理髮店','building.3.lifadian5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',32,193,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(19832,'爆米花店','building.1.baomihua1',NULL,NULL,3,6,2,0,0,0,1200,4,'2*2',32,198,0,1,26,3600,NULL,'0.666666666666667',20,3,19932,NULL),(19932,'爆米花店','building.3.baomihua2',NULL,NULL,4,105000,1,0,0,0,22200,8,'2*2',32,198,0,0,42,3600,NULL,'0.666666666666667',118,4,20032,NULL),(20032,'爆米花店','building.4.baomihua3',NULL,NULL,5,53,2,0,0,0,32700,26,'2*2',32,198,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(20132,'鐘樓','building.1.zhonglou1',NULL,NULL,3,6,2,0,0,0,1200,1,'2*2',32,201,0,1,26,3600,NULL,'0.666666666666667',30,3,20232,NULL),(20232,'鐘樓','building.3.zhonglou2',NULL,NULL,4,105000,1,0,0,0,22200,8,'2*2',32,201,0,0,42,3600,NULL,'0.666666666666667',118,4,20332,NULL),(20332,'鐘樓','building.3.zhonglou3',NULL,NULL,5,53,2,0,0,0,32700,26,'2*2',32,201,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(20432,'水果店','building.1.shuiguo1',NULL,NULL,1,1000,1,0,0,0,200,7,'2*2',32,204,0,1,10,3600,NULL,'0.666666666666667',32,1,20532,NULL),(20532,'水果店','building.3.shuiguo2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',32,204,0,0,16,3600,NULL,'0.666666666666667',36,2,20632,NULL),(20632,'水果店','building.3.shuiguo3',NULL,NULL,3,6,2,0,0,0,2000,4,'2*2',32,204,0,0,26,3600,NULL,'0.666666666666667',40,3,20732,NULL),(20732,'水果店','building.3.shuiguo4',NULL,NULL,4,105000,1,0,0,0,23000,8,'2*2',32,204,0,0,42,3600,NULL,'0.666666666666667',118,4,20832,NULL),(20832,'水果店','building.3.shuiguo5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',32,204,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(20931,'摩天輪','building.1.motianlun1',NULL,NULL,3,9,2,0,0,0,1800,1,'3*2',31,209,0,1,32,10800,NULL,'0.666666666666667',30,3,21031,NULL),(21031,'摩天輪','building.1.motianlun2',NULL,NULL,4,157500,1,0,0,0,33300,19,'3*2',31,209,0,0,49,10800,NULL,'0.666666666666667',118,4,21131,NULL),(21131,'摩天輪','building.1.motianlun3',NULL,NULL,5,79,2,0,0,0,49050,26,'3*2',31,209,0,0,73,10800,NULL,'0.666666666666667',118,5,0,NULL),(21232,'氣球屋','building.1.qiqiudian1',NULL,NULL,1,1000,1,0,0,0,200,1,'2*2',32,212,0,1,10,3600,NULL,'0.666666666666667',10,1,21332,NULL),(21332,'氣球屋','building.3.qiqiudian2',NULL,NULL,2,3000,1,0,0,0,800,2,'2*2',32,212,0,0,16,3600,NULL,'0.666666666666667',11,2,21432,NULL),(21432,'氣球屋','building.3.qiqiudian3',NULL,NULL,3,6,2,0,0,0,2000,4,'2*2',32,212,0,0,26,3600,NULL,'0.666666666666667',30,3,21532,NULL),(21532,'氣球屋','building.4.qiqiudian4',NULL,NULL,4,105000,1,0,0,0,23000,8,'2*2',32,212,0,0,42,3600,NULL,'0.666666666666667',118,4,21632,NULL),(21632,'氣球屋','building.4.qiqiudian5',NULL,NULL,5,53,2,0,0,0,33500,26,'2*2',32,212,0,0,67,3600,NULL,'0.666666666666667',118,5,0,NULL),(36032,'鐘塔','building.1.zhonglou4',NULL,NULL,4,105000,1,0,0,0,21000,26,'2*2',32,360,0,1,42,3600,NULL,'0.666666666666667',120,4,36132,NULL),(36132,'鐘塔','building.3.zhonglou5',NULL,NULL,5,53,2,0,0,0,31500,35,'2*2',32,360,0,0,67,3600,NULL,'0.666666666666667',160,5,0,NULL),(40932,'西班牙足球館','building.5.zuqiuguan27',NULL,NULL,1,0,1,0,0,0,0,1,'3*3',32,409,0,0,20,14400,NULL,'0.666666666666667',1,1,0,NULL),(41232,'義大利足球館','building.5.zuqiuguan30',NULL,NULL,1,0,1,0,0,0,0,1,'3*3',32,412,0,0,20,14400,NULL,'0.666666666666667',1,1,0,NULL),(41531,'招財小貓-進財','building.5.mao1',NULL,NULL,3,10,2,0,0,0,2000,1,'2*2',31,415,0,0,26,3600,NULL,'0.7',1,3,0,NULL),(41631,'招財小貓-金幣','building.5.mao2',NULL,NULL,3,10,2,0,0,0,2000,1,'2*2',31,416,0,0,26,3600,NULL,'0.7',1,3,0,NULL),(41731,'招財小貓-元寶','building.5.mao3',NULL,NULL,3,10,2,0,0,0,2000,1,'2*2',31,417,0,0,26,3600,NULL,'0.7',1,3,0,NULL),(41831,'馬戲團','building.5.maxituan4',NULL,NULL,3,6,2,0,0,0,1200,13,'2*2',31,418,0,0,26,3600,NULL,'0.7',50,3,41931,NULL),(41931,'馬戲團','building.5.maxituan5',NULL,NULL,4,105000,1,0,0,0,22200,18,'2*2',31,418,0,0,42,3600,NULL,'0.7',80,4,42031,NULL),(42031,'馬戲團','building.5.maxituan6',NULL,NULL,5,53,2,0,0,0,32700,25,'2*2',31,418,0,0,67,3600,NULL,'0.7',120,5,0,NULL),(42131,'火山','building.5.huoshan4',NULL,NULL,3,480000,1,0,0,0,120000,14,'6*6',31,421,0,0,83,72000,NULL,'0.7',200,3,42231,NULL),(42231,'火山','building.5.huoshan5',NULL,NULL,4,2890000,1,0,0,0,842500,25,'6*6',31,421,0,0,94,72000,NULL,'0.7',300,4,42331,NULL),(42331,'火山','building.5.huoshan6',NULL,NULL,5,9200000,1,0,0,0,3142500,45,'6*6',31,421,0,0,107,72000,NULL,'0.7',400,5,0,NULL),(43432,'抓娃娃機','building.5.wawaji3',NULL,NULL,3,6,2,0,0,0,1200,14,'2*2',32,434,0,0,26,3600,NULL,'0.7',90,3,43532,NULL),(43532,'抓娃娃機','building.5.wawaji4',NULL,NULL,4,105000,1,0,0,0,22200,16,'2*2',32,434,0,0,42,3600,NULL,'0.7',90,4,43632,NULL),(43632,'抓娃娃機','building.5.wawaji5',NULL,NULL,5,53,2,0,0,0,32700,18,'2*2',32,434,0,0,67,3600,NULL,'0.7',90,5,0,NULL),(43732,'小熊玩具店','building.5.gongzaidian3',NULL,NULL,3,6,2,0,0,0,1200,9,'2*2',32,437,0,1,26,3600,NULL,'0.7',40,3,43832,NULL),(43832,'小熊玩具店','building.5.gongzaidian4',NULL,NULL,4,105000,1,0,0,0,22200,10,'2*2',32,437,0,0,42,3600,NULL,'0.7',40,4,43932,NULL),(43932,'小熊玩具店','building.5.gongzaidian5',NULL,NULL,5,53,2,0,0,0,32700,11,'2*2',32,437,0,0,67,3600,NULL,'0.7',40,5,0,NULL),(44031,'搖搖馬','building.5.muma3',NULL,NULL,3,6,2,0,0,0,1200,12,'2*2',31,440,0,1,26,3600,NULL,'0.7',70,3,44131,NULL),(44131,'搖搖馬','building.5.muma4',NULL,NULL,4,105000,1,0,0,0,22200,13,'2*2',31,440,0,0,42,3600,NULL,'0.7',70,4,44231,NULL),(44231,'搖搖馬','building.5.muma5',NULL,NULL,5,53,2,0,0,0,32700,15,'2*2',31,440,0,0,67,3600,NULL,'0.7',70,5,0,NULL),(44331,'溜滑梯','building.5.huati3',NULL,NULL,3,9,2,0,0,0,1800,6,'3*2',31,443,0,1,32,10800,NULL,'0.7',40,3,44431,NULL),(44431,'溜滑梯','building.5.huati4',NULL,NULL,4,157500,1,0,0,0,33300,8,'3*2',31,443,0,0,49,10800,NULL,'0.7',40,4,44531,NULL),(44531,'溜滑梯','building.5.huati5',NULL,NULL,5,79,2,0,0,0,49050,10,'3*2',31,443,0,0,73,10800,NULL,'0.7',40,5,0,NULL),(44631,'積木房子','building.5.jimu3',NULL,NULL,3,14,2,0,0,0,2700,1,'3*3',31,446,0,0,40,14400,NULL,'0.7',1,3,44731,NULL),(44731,'積木房子','building.5.jimu4',NULL,NULL,4,236250,1,0,0,0,49950,1,'3*3',31,446,0,0,55,14400,NULL,'0.7',1,4,44831,NULL),(44831,'積木房子','building.5.jimu5',NULL,NULL,5,118,2,0,0,0,73575,1,'3*3',31,446,0,0,77,14400,NULL,'0.7',1,5,0,NULL),(44931,'玩具火車','building.5.xiaohuoche3',NULL,NULL,3,30,2,0,0,0,6000,18,'4*4',31,449,0,0,60,43200,NULL,'0.7',120,3,45031,NULL),(45031,'玩具火車','building.5.xiaohuoche4',NULL,NULL,4,525000,1,0,0,0,111000,20,'4*4',31,449,0,0,73,43200,NULL,'0.7',120,4,45131,NULL),(45131,'玩具火車','building.5.xiaohuoche5',NULL,NULL,5,263,2,0,0,0,163500,23,'4*4',31,449,0,0,90,43200,NULL,'0.7',120,5,0,NULL),(45231,'充氣泳池','building.5.yongchi3',NULL,NULL,3,14,2,0,0,0,2700,16,'3*3',31,452,0,1,40,14400,NULL,'0.7',100,3,45331,NULL),(45331,'充氣泳池','building.5.yongchi4',NULL,NULL,4,236250,1,0,0,0,49950,17,'3*3',31,452,0,0,55,14400,NULL,'0.7',100,4,45431,NULL),(45431,'充氣泳池','building.5.yongchi5',NULL,NULL,5,118,2,0,0,0,73575,19,'3*3',31,452,0,0,77,14400,NULL,'0.7',100,5,0,NULL),(46731,'奶優屋','building.5.guolinaiyou',NULL,NULL,1,1000,1,0,0,0,250,1,'2*2',31,467,0,0,10,3600,NULL,'0.7',1,1,0,NULL),(47632,'沙雕','building.5.shadiao3',NULL,NULL,3,6,2,0,0,0,1200,15,'2*2',32,476,0,0,26,3600,NULL,'0.7',100,3,47732,NULL),(47732,'沙雕','building.5.shadiao4',NULL,NULL,4,105000,1,0,0,0,22200,25,'2*2',32,476,0,0,42,3600,NULL,'0.7',120,4,47832,NULL),(47832,'沙雕','building.5.shadiao5',NULL,NULL,5,53,2,0,0,0,32700,35,'2*2',32,476,0,0,67,3600,NULL,'0.7',160,5,0,NULL),(47932,'果汁店','building.5.guozhi3',NULL,NULL,3,6,2,0,0,0,1200,20,'2*2',32,479,0,0,26,3600,NULL,'0.7',100,3,48032,NULL),(48032,'果汁店','building.5.guozhi4',NULL,NULL,4,105000,1,0,0,0,22200,30,'2*2',32,479,0,0,42,3600,NULL,'0.7',120,4,48132,NULL),(48132,'果汁店','building.5.guozhi5',NULL,NULL,5,53,2,0,0,0,32700,40,'2*2',32,479,0,0,67,3600,NULL,'0.7',160,5,0,NULL),(48232,'貝殼商店','building.5.beike3',NULL,NULL,3,6,2,0,0,0,1200,16,'2*2',32,482,0,0,26,3600,NULL,'0.7',100,3,48332,NULL),(48332,'貝殼商店','building.5.beike4',NULL,NULL,4,105000,1,0,0,0,22200,26,'2*2',32,482,0,0,42,3600,NULL,'0.7',120,4,48432,NULL),(48432,'貝殼商店','building.5.beike5',NULL,NULL,5,53,2,0,0,0,32700,36,'2*2',32,482,0,0,67,3600,NULL,'0.7',160,5,0,NULL),(48532,'海鮮店','building.5.haixian3',NULL,NULL,3,6,2,0,0,0,1200,17,'2*2',32,485,0,0,26,3600,NULL,'0.7',100,3,48632,NULL),(48632,'海鮮店','building.5.haixian4',NULL,NULL,4,105000,1,0,0,0,22200,27,'2*2',32,485,0,0,42,3600,NULL,'0.7',120,4,48732,NULL),(48732,'海鮮店','building.5.haixian5',NULL,NULL,5,53,2,0,0,0,32700,37,'2*2',32,485,0,0,67,3600,NULL,'0.7',160,5,0,NULL),(48831,'寶藏','building.5.haidaobaozang3',NULL,NULL,3,14,2,0,0,0,2700,21,'3*3',31,488,0,0,40,14400,NULL,'0.7',100,3,48931,NULL),(48931,'寶藏','building.5.haidaobaozang4',NULL,NULL,4,236250,1,0,0,0,49950,31,'3*3',31,488,0,0,55,14400,NULL,'0.7',120,4,49031,NULL),(49031,'寶藏','building.5.haidaobaozang5',NULL,NULL,5,118,2,0,0,0,73575,41,'3*3',31,488,0,0,77,14400,NULL,'0.7',160,5,0,NULL),(49132,'船屋','building.5.chuanwu3',NULL,NULL,3,6,2,0,0,0,1200,19,'2*2',32,491,0,0,26,3600,NULL,'0.7',100,3,49232,NULL),(49232,'船屋','building.5.chuanwu4',NULL,NULL,4,105000,1,0,0,0,22200,29,'2*2',32,491,0,0,42,3600,NULL,'0.7',120,4,49332,NULL),(49332,'船屋','building.5.chuanwu5',NULL,NULL,5,53,2,0,0,0,32700,39,'2*2',32,491,0,0,67,3600,NULL,'0.7',160,5,0,NULL),(49432,'度假屋','building.5.dujia3',NULL,NULL,3,6,2,0,0,0,1200,18,'2*2',32,494,0,0,26,3600,NULL,'0.7',100,3,49532,NULL),(49532,'度假屋','building.5.dujia4',NULL,NULL,4,105000,1,0,0,0,22200,28,'2*2',32,494,0,0,42,3600,NULL,'0.7',120,4,49632,NULL),(49632,'度假屋','building.5.dujia5',NULL,NULL,5,53,2,0,0,0,32700,38,'2*2',32,494,0,0,67,3600,NULL,'0.7',160,5,0,NULL),(50932,'巧克力工廠','building.6.qiaokeli3',NULL,NULL,3,18,2,0,0,0,4500,1,'3*3',32,509,0,0,40,14400,NULL,'0.7',20,3,51032,NULL),(51032,'巧克力工廠','building.6.qiaokeli4',NULL,NULL,4,210000,1,0,0,0,17000,5,'3*3',32,509,0,0,55,14400,NULL,'0.7',50,4,51132,NULL),(51132,'巧克力工廠','building.6.qiaokeli5',NULL,NULL,5,50,2,0,0,0,27000,10,'3*3',32,509,0,0,77,14400,NULL,'0.7',80,5,0,NULL),(58431,'南瓜屋','building.6.nanguawu3',NULL,NULL,3,12,2,0,0,0,2400,5,'2*2',31,584,0,0,26,3600,NULL,'0.7',120,3,58531,NULL),(58531,'南瓜屋','building.6.nanguawu4',NULL,NULL,4,210000,1,0,0,0,44400,15,'2*2',31,584,0,0,42,3600,NULL,'0.7',160,4,58631,NULL),(58631,'南瓜屋','building.6.nanguawu5',NULL,NULL,5,105,2,0,0,0,65400,25,'2*2',31,584,0,0,67,3600,NULL,'0.7',220,5,0,NULL),(60231,'金字塔','building.6.jzt3',NULL,NULL,3,480000,1,0,0,0,120000,10,'6*6',31,602,0,1,83,72000,NULL,'0.7',50,3,60331,NULL),(60331,'金字塔','building.6.jzt4',NULL,NULL,4,2890000,1,0,0,0,842500,20,'6*6',31,602,0,0,94,72000,NULL,'0.7',250,4,60431,NULL),(60431,'金字塔','building.6.jzt5',NULL,NULL,5,9200000,1,0,0,0,3142500,30,'6*6',31,602,0,0,107,72000,NULL,'0.7',400,5,0,NULL),(60531,'埃及民居','building.6.ajmj3',NULL,NULL,3,6,2,0,0,0,1200,5,'3*3',31,605,0,1,40,14400,NULL,'0.7',120,3,60631,NULL),(60631,'埃及民居','building.6.ajmj4',NULL,NULL,4,105000,1,0,0,0,22200,15,'3*3',31,605,0,0,55,14400,NULL,'0.7',160,4,60731,NULL),(60731,'埃及民居','building.6.ajmj5',NULL,NULL,5,53,2,0,0,0,32700,25,'3*3',31,605,0,0,77,14400,NULL,'0.7',220,5,0,NULL),(60831,'埃及神像','building.6.ajsx3',NULL,NULL,3,6,2,0,0,0,1200,0,'2*2',31,608,0,0,26,3600,NULL,'0.7',120,3,60931,NULL),(60931,'埃及神像','building.6.ajsx4',NULL,NULL,4,105000,1,0,0,0,22200,10,'2*2',31,608,0,0,42,3600,NULL,'0.7',160,4,61031,NULL),(61031,'埃及神像','building.6.ajsx5',NULL,NULL,5,53,2,0,0,0,32700,20,'2*2',31,608,0,0,67,3600,NULL,'0.7',220,5,0,NULL),(61131,'法老祭壇','building.6.jitan3',NULL,NULL,3,14,2,0,0,0,2700,0,'3*3',31,611,0,1,40,14400,NULL,'0.7',120,3,61231,NULL),(61231,'法老祭壇','building.6.jitan4',NULL,NULL,4,236250,1,0,0,0,49950,10,'3*3',31,611,0,0,55,14400,NULL,'0.7',160,4,61331,NULL),(61331,'法老祭壇','building.6.jitan5',NULL,NULL,5,118,2,0,0,0,73575,20,'3*3',31,611,0,0,77,14400,NULL,'0.7',220,5,0,NULL),(69031,'夢想風車','building.8.mxhy',NULL,NULL,5,30,2,0,0,0,6000,1,'4*4',31,690,0,0,90,43200,NULL,'0.7',30,5,0,NULL),(69531,'中國建築','building.8.zgjz3',NULL,NULL,3,50000,1,0,0,0,2700,6,'3*3',31,695,0,1,40,14400,NULL,'0.7',30,3,69631,NULL),(69631,'中國建築','building.8.zgjz4',NULL,NULL,4,53,2,0,0,0,49950,16,'3*3',31,695,0,0,55,14400,NULL,'0.7',85,4,69731,NULL),(69731,'中國建築','building.8.zgjz5',NULL,NULL,5,118,2,0,0,0,73575,26,'3*3',31,695,0,0,77,14400,NULL,'0.7',155,5,0,NULL),(69831,'生肖兔子館','building.8.tz3',NULL,NULL,3,6,2,0,0,0,5000,1,'2*2',31,698,0,1,26,3600,NULL,'0.7',30,3,69931,NULL),(69931,'生肖兔子館','building.8.tz4',NULL,NULL,4,105000,1,0,0,0,11500,5,'2*2',31,698,0,0,42,3600,NULL,'0.7',85,4,70031,NULL),(70031,'生肖兔子館','building.8.tz5',NULL,NULL,5,53,2,0,0,0,28500,10,'2*2',31,698,0,0,67,3600,NULL,'0.7',155,5,0,NULL),(70131,'燈籠店','building.8.dl3',NULL,NULL,3,50000,1,0,0,0,1200,9,'2*2',31,701,0,0,26,3600,NULL,'0.7',30,3,70231,NULL),(70231,'燈籠店','building.8.dl4',NULL,NULL,4,26,2,0,0,0,22200,19,'2*2',31,701,0,0,42,3600,NULL,'0.7',85,4,70331,NULL),(70331,'燈籠店','building.8.dl5',NULL,NULL,6,63,2,0,0,0,32700,29,'2*2',31,701,0,0,67,3600,NULL,'0.7',155,5,0,NULL),(71832,'恐龍館','building.5.klg3',NULL,NULL,3,14,2,0,0,0,2700,1,'3*3',32,718,0,0,40,14400,NULL,'0.7',30,3,71932,NULL),(71932,'恐龍館','building.5.klg4',NULL,NULL,4,236250,1,0,0,0,49950,5,'3*3',32,718,0,0,55,14400,NULL,'0.7',85,4,72032,NULL),(72032,'恐龍館','building.5.klg5',NULL,NULL,5,50,2,0,0,0,73575,10,'3*3',32,718,0,0,77,14400,NULL,'0.7',155,5,0,NULL),(72731,'聚寶坊','building.8.sdhd3',NULL,NULL,5,60,2,0,0,0,12000,1,'4*4',31,727,0,0,90,43200,NULL,'0.7',80,5,0,NULL),(72831,'丘比特館','building.8.qbt3',NULL,NULL,3,6,2,0,0,0,1200,1,'2*2',31,728,0,0,26,3600,NULL,'0.7',30,3,72931,NULL),(72931,'丘比特館','building.8.qbt4',NULL,NULL,4,105000,1,0,0,0,22200,11,'2*2',31,728,0,0,42,3600,NULL,'0.7',130,4,73031,NULL),(73031,'丘比特館','building.8.qbt5',NULL,NULL,5,53,2,0,0,0,32700,21,'2*2',31,728,0,0,67,3600,NULL,'0.7',280,5,0,NULL),(74632,'摩羯座','building.8.mjz3',NULL,NULL,20,50,2,0,0,0,10000,1,'3*3',32,746,0,0,77,14400,NULL,'0.7',10,5,0,NULL),(74732,'水瓶座','building.8.spz3',NULL,NULL,20,50,2,0,0,0,10000,0,'3*3',32,746,0,0,77,14400,NULL,'0.7',10,5,0,NULL),(75532,'雙魚座','building.8.szz3',NULL,NULL,5,50,2,0,0,0,10000,1,'3*3',32,755,0,0,77,14400,NULL,'0.7',1,5,0,NULL),(78631,'彩色聚仙閣','building.10.flsc03',NULL,NULL,5,100,2,0,0,0,5000,1,'2*2',31,786,0,0,90,43200,NULL,'0.7',30,5,0,NULL),(78931,'兔寶寶','building.10.tz03',NULL,NULL,1,100,2,0,0,0,100,1,'2*2',31,793,0,0,0,3600,NULL,'0.7',1,3,0,NULL),(79031,'兔小傻','building.10.tz04',NULL,NULL,1,20,2,0,0,0,500,1,'2*2',31,0,0,0,0,0,NULL,'0',1,0,0,NULL),(79131,'兔小胖','building.10.tz05',NULL,NULL,1,20,2,0,0,0,500,1,'2*2',31,0,0,0,0,0,NULL,'0',1,0,0,NULL),(79331,'摩天大樓','building.10.101',NULL,NULL,5,53,2,0,0,0,10000,5,'2*2',31,793,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(80432,'白羊座','building.10.byz3',NULL,NULL,5,50,2,0,0,0,0,0,'3*3',32,755,0,0,77,14400,NULL,'0.7',0,5,0,NULL),(85132,'金牛座','building.11.jnz3',NULL,NULL,5,50,2,0,0,0,20000,1,'3*3',32,851,0,0,77,14400,NULL,'0.7',10,5,0,NULL),(85232,'雙子座','building.11.szz3',NULL,NULL,5,50,2,0,0,0,20000,1,'3*3',32,852,0,0,77,14400,NULL,'0.7',10,5,0,NULL),(85332,'巨蟹座','building.11.jxz3',NULL,NULL,5,50,2,0,0,0,20000,1,'3*3',32,853,0,0,77,14400,NULL,'0.7',10,5,0,NULL),(85432,'獅子座','building.13.szz3',NULL,NULL,5,50,2,0,0,0,20000,1,'3*3',32,854,0,0,77,14400,NULL,'0.7',10,5,0,NULL),(87032,'跳舞女孩音樂盒','building.8.bayinhe3',NULL,NULL,0,0,0,0,0,0,0,0,'2*2',32,0,0,0,0,0,NULL,'0',0,0,0,NULL),(87132,'跳舞女孩音樂盒','building.8.bayinhe4',NULL,NULL,0,0,0,0,0,0,0,0,'2*2',32,0,0,0,0,0,NULL,'0',0,0,0,NULL),(87232,'跳舞女孩音樂盒','building.8.bayinhe5',NULL,NULL,0,0,0,0,0,0,0,0,'2*2',32,0,0,0,0,0,NULL,'0',0,0,0,NULL),(87332,'乖乖寶貝','building.9.bzww',NULL,NULL,5,58,2,0,0,0,10000,1,'2*2',32,873,0,0,67,3600,NULL,'0.7',1,5,0,NULL),(87532,'兵馬俑','building.11.bmy03',NULL,NULL,0,0,0,0,0,0,0,0,'2*2',32,0,0,0,0,0,NULL,'0',0,0,0,NULL),(87632,'兵馬俑','building.11.bmy04',NULL,NULL,0,0,0,0,0,0,0,0,'2*2',32,0,0,0,0,0,NULL,'0',0,0,0,NULL),(87732,'兵馬俑','building.11.bmy05',NULL,NULL,0,0,0,0,0,0,0,0,'2*2',32,0,0,0,0,0,NULL,'0',0,0,0,NULL),(87832,'快樂大擺錘','building.11.dbc3',NULL,NULL,0,0,0,0,0,0,0,0,'3*3',32,0,0,0,0,0,NULL,'0',0,0,0,NULL),(87932,'快樂大擺錘','building.11.dbc4',NULL,NULL,0,0,0,0,0,0,0,0,'3*3',32,0,0,0,0,0,NULL,'0',0,0,0,NULL),(88032,'快樂大擺錘','building.11.dbc5',NULL,NULL,0,0,0,0,0,0,0,0,'3*3',32,0,0,0,0,0,NULL,'0',0,0,0,NULL),(88132,'雙子座','building.11.szz3',NULL,NULL,5,50,2,0,0,0,0,1,'3*3',32,881,0,0,77,14400,NULL,'0.7',10,5,0,NULL),(88432,'熱辣電烤雞','building.11.twj3',NULL,NULL,5,61,2,0,0,0,100000,1,'2*2',32,884,0,0,67,3600,NULL,'0.7',30,5,0,NULL),(91532,'猴子水手','building.11.hzss03',NULL,NULL,5,68,2,0,0,0,10000,1,'2*2',32,915,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(91632,'傑克船長','building.11.jkcz03',NULL,NULL,3,68,2,0,0,0,10000,1,'2*2',32,916,0,0,26,3600,NULL,'0.7',50,3,91732,NULL),(91732,'傑克船長','building.11.jkcz04',NULL,NULL,4,16,2,0,0,0,10000,1,'2*2',32,916,0,0,42,3600,NULL,'0.7',80,4,91832,NULL),(91832,'傑克船長','building.11.jkcz05',NULL,NULL,5,48,2,0,0,0,10000,1,'2*2',32,916,0,0,67,3600,NULL,'0.7',100,5,0,NULL),(91932,'骷髏水手','building.11.klb03',NULL,NULL,5,68,2,0,0,0,10000,1,'2*2',32,919,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(92032,'骷髏美人魚','building.11.kuloumeirenyu',NULL,NULL,5,68,2,0,0,0,10000,1,'2*2',32,920,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(92132,'章魚水手','building.11.zhangyushuishou',NULL,NULL,5,68,2,0,0,0,10000,1,'2*2',32,921,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(92332,'大副吉比斯','building.11.zhuangyuchuanzhang01',NULL,NULL,3,50000,1,0,0,0,10000,5,'2*2',32,923,0,0,42,3600,NULL,'0.7',30,3,0,NULL),(98032,'洛克猴','building.12.xiaoli',NULL,NULL,5,60,2,0,0,0,10000,5,'2*2',32,980,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(98132,'大猴丸','building.12.dashewan',NULL,NULL,5,60,2,0,0,0,10000,5,'2*2',32,981,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(98232,'忍術密藏館','building.12.jzd',NULL,NULL,5,50,2,0,0,0,10000,5,'2*2',32,982,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(98332,'卡凱西猴','building.12.kakax',NULL,NULL,5,60,2,0,0,0,10000,5,'2*2',32,983,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(98432,'拉麵店','building.12.lamiandian',NULL,NULL,5,50,2,0,0,0,10000,5,'2*2',32,984,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(98532,'偽裝教室','building.12.mianjudian',NULL,NULL,5,50,2,0,0,0,10000,5,'2*2',32,985,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(98632,'鳴人猴','building.12.mingren',NULL,NULL,5,60,2,0,0,0,10000,5,'2*2',32,986,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(98732,'人偶店','building.12.renoudian',NULL,NULL,5,350000,1,0,0,0,50000,5,'2*2',32,987,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(98832,'忍服專賣','building.12.renzhefuzhuangdian',NULL,NULL,5,50,2,0,0,0,10000,5,'2*2',32,988,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(98932,'暗器學堂','building.12.shoulijiandian',NULL,NULL,5,50,2,0,0,0,10000,5,'2*2',32,989,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(99032,'我愛羅猴','building.12.woailuo',NULL,NULL,5,60,2,0,0,0,10000,5,'2*2',32,990,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(99132,'小櫻猴','building.12.xiaoying',NULL,NULL,5,60,2,0,0,0,10000,5,'2*2',32,991,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(99232,'自來也猴','building.12.zilaiye',NULL,NULL,5,60,2,0,0,0,10000,5,'2*2',32,992,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(99332,'佐助猴','building.12.zuozhu',NULL,NULL,5,60,2,0,0,0,10000,5,'2*2',32,993,0,0,67,3600,NULL,'0.7',50,5,0,NULL),(99431,'搖搖小飛機','building.12.yyxfj3',NULL,NULL,5,10,2,0,0,0,1000,1,'2*2',31,994,0,0,67,3600,NULL,'0.7',1,5,0,NULL),(99531,'蹺蹺板','building.12.qiaoqiaoban',NULL,NULL,5,10,2,0,0,0,1000,1,'1*3',31,995,0,0,67,3600,NULL,'0.7',1,5,0,NULL),(99631,'小熊飛船','building.12.fc3',NULL,NULL,5,10,2,0,0,0,1000,1,'2*2',31,996,0,0,67,3600,NULL,'0.7',1,5,0,NULL),(100332,'美女火星兔','building.13.hx3',NULL,NULL,5,50,2,0,0,0,10000,1,'2*2',32,1003,0,1,67,3600,NULL,'0.7',30,5,0,NULL),(100432,'美女金星兔','building.13.jx3',NULL,NULL,5,50,2,0,0,0,10000,1,'2*2',32,1004,0,1,67,3600,NULL,'0.7',30,5,0,NULL),(100532,'美女木星兔','building.13.mx3',NULL,NULL,5,50,2,0,0,0,10000,1,'2*2',32,1005,0,1,67,3600,NULL,'0.7',30,5,0,NULL),(100632,'美女水冰兔','building.13.sby3',NULL,NULL,5,50,2,0,0,0,10000,1,'2*2',32,1006,0,0,67,3600,NULL,'0.7',30,5,0,NULL),(100732,'美女水星兔','building.1.xx3',NULL,NULL,5,50,2,0,0,0,10000,1,'2*2',32,1007,0,1,67,3600,NULL,'0.7',30,5,0,NULL),(100832,'假面禮服兔','building.13.ylfjm3',NULL,NULL,5,61,2,0,0,0,10000,1,'2*2',32,1008,0,0,67,3600,NULL,'0.7',30,5,0,NULL),(104332,'Yi時代','building.13.moqi3',NULL,NULL,5,88,2,0,0,0,10000,5,'2*2',32,1043,0,0,67,3600,NULL,'0.7',50,5,0,NULL);

/*Table structure for table `island_praise` */

DROP TABLE IF EXISTS `island_praise`;

CREATE TABLE `island_praise` (
  `praise` int(11) NOT NULL COMMENT '装饰度',
  `visitor_count` int(11) DEFAULT NULL COMMENT '增加人数',
  PRIMARY KEY (`praise`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_praise` */

insert  into `island_praise`(`praise`,`visitor_count`) values (15,1),(30,2),(45,3),(60,4),(75,5),(90,6),(105,7),(120,8),(135,9),(150,10),(165,11),(180,12),(195,13),(210,14),(225,15),(240,16),(255,17),(270,18),(285,19),(300,20),(315,21),(330,22),(345,23),(360,24),(375,25),(390,26),(405,27),(420,28),(435,29),(450,30),(465,31),(480,32),(495,33),(510,34),(525,35),(540,36),(555,37),(570,38),(585,39),(600,40);

/*Table structure for table `island_praise_ship` */

DROP TABLE IF EXISTS `island_praise_ship`;

CREATE TABLE `island_praise_ship` (
  `sid` int(11) DEFAULT NULL COMMENT '船只id，对应 island_ship表',
  `praise` int(11) DEFAULT NULL COMMENT '装饰度',
  `num` int(11) DEFAULT NULL COMMENT '增加有游客数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_praise_ship` */

insert  into `island_praise_ship`(`sid`,`praise`,`num`) values (1,31,1),(1,82,2),(1,168,3),(1,344,4),(1,760,5),(1,1815,6),(2,28,2),(2,72,3),(2,142,4),(2,278,5),(2,585,6),(2,1333,7),(3,25,3),(3,63,4),(3,122,5),(3,235,6),(3,488,7),(3,1101,8),(4,22,4),(4,53,5),(4,98,6),(4,174,7),(4,327,8),(4,666,9),(4,1454,10),(5,19,5),(5,44,6),(5,79,7),(5,133,8),(5,235,9),(5,447,10),(5,920,11),(5,1999,12),(6,16,6),(6,36,7),(6,62,8),(6,99,9),(6,163,10),(6,287,11),(6,549,12),(6,1119,13),(7,13,7),(7,28,8),(7,46,9),(7,71,10),(7,108,11),(7,174,12),(7,302,13),(7,566,14),(7,1127,15),(8,10,8),(8,21,9),(8,33,10),(8,48,11),(8,67,12),(8,96,13),(8,147,14),(8,243,15),(8,433,16),(8,821,17),(8,1625,18);

/*Table structure for table `island_rank` */

DROP TABLE IF EXISTS `island_rank`;

CREATE TABLE `island_rank` (
  `uid` int(10) unsigned NOT NULL,
  `type` smallint(1) NOT NULL COMMENT '1为消费，2为收金币，3为邀请好友，4为活动',
  `num` int(10) unsigned NOT NULL DEFAULT '0',
  `date` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1为上上周，2为上周',
  `rank` smallint(4) unsigned DEFAULT NULL,
  `change` smallint(1) DEFAULT NULL COMMENT '整数位上升，负数为下降，0为不变，new为新增',
  PRIMARY KEY (`uid`,`type`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_rank` */

/*Table structure for table `island_server` */

DROP TABLE IF EXISTS `island_server`;

CREATE TABLE `island_server` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL DEFAULT '',
  `pub_ip` varchar(16) NOT NULL DEFAULT '',
  `local_ip` varchar(16) NOT NULL DEFAULT '',
  `type` enum('WEB','DB','CACHE','OTHER') DEFAULT NULL,
  `add_time` int(10) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_server` */

/*Table structure for table `island_ship` */

DROP TABLE IF EXISTS `island_ship`;

CREATE TABLE `island_ship` (
  `sid` int(11) NOT NULL COMMENT '船只id',
  `name` varchar(200) DEFAULT NULL COMMENT '名称',
  `start_visitor_num` int(11) DEFAULT NULL COMMENT '可载乘客数',
  `safe_visitor_num` int(11) DEFAULT NULL COMMENT '保护乘客数',
  `wait_time` int(11) DEFAULT NULL COMMENT '返航时间',
  `safe_time_1` int(11) DEFAULT NULL COMMENT '乘客烦躁时间,比较不耐烦',
  `safe_time_2` int(11) DEFAULT NULL COMMENT '乘客烦躁时间,非常不耐烦',
  `class_name` varchar(100) DEFAULT NULL COMMENT '图像素材',
  `coin` int(11) DEFAULT '0' COMMENT '所需金币',
  `gem` int(11) DEFAULT '0' COMMENT '所需宝石',
  `cheap_price` int(11) DEFAULT '0' COMMENT '折扣价格',
  `cheap_start_time` int(11) DEFAULT '0' COMMENT '开始折扣时间',
  `cheap_end_time` int(11) DEFAULT '0' COMMENT '结束折扣时间',
  `level` int(11) DEFAULT NULL COMMENT '需要等级',
  `getcard` int(11) DEFAULT '0' COMMENT '帮助获得道具卡几率,千分之xx',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_ship` */

insert  into `island_ship`(`sid`,`name`,`start_visitor_num`,`safe_visitor_num`,`wait_time`,`safe_time_1`,`safe_time_2`,`class_name`,`coin`,`gem`,`cheap_price`,`cheap_start_time`,`cheap_end_time`,`level`,`getcard`) values (1,'小木筏',5,2,1200,400,800,'boat.1.mufa1',700,1,0,0,0,1,10),(2,'木舟',16,5,3600,1200,2400,'boat.1.xiaochuan1',4000,2,0,0,0,2,15),(3,'橡皮艇',28,9,6000,2000,4000,'boat.1.xiangpiting1',15000,8,0,0,0,3,20),(4,'帆木舟',41,14,8400,2800,5600,'boat.1.xiaofanchuan1',29000,15,0,0,0,6,25),(5,'大帆船',55,18,10800,3600,7200,'boat.1.dafanchuan1',48000,24,0,0,0,10,30),(6,'白色快艇',70,23,13200,4400,8800,'boat.1.xiaokuaiting1',0,36,0,0,0,10,35),(7,'紅色快艇',86,29,15600,5200,10400,'boat.1.xiaoyoulun1',0,53,0,0,0,10,40),(8,'豪華遊輪',103,34,18000,6000,12000,'boat.1.dayoulun1',0,75,0,0,0,10,45);

/*Table structure for table `island_starfish_externalmall` */

DROP TABLE IF EXISTS `island_starfish_externalmall`;

CREATE TABLE `island_starfish_externalmall` (
  `cid` int(11) NOT NULL COMMENT '特卖物品id',
  `type` varchar(100) DEFAULT NULL COMMENT '物品类型',
  `number` smallint(6) DEFAULT NULL COMMENT '数量',
  `price` smallint(6) DEFAULT NULL COMMENT '价格',
  `sort` smallint(6) DEFAULT NULL COMMENT '顺序',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_starfish_externalmall` */

insert  into `island_starfish_externalmall`(`cid`,`type`,`number`,`price`,`sort`) values (26341,'propCard',3,5,9),(26441,'propCard',3,10,10),(26541,'propCard',3,5,11),(26641,'propCard',3,10,12),(43432,'architecture',1,10,1),(43732,'architecture',1,10,2),(44031,'architecture',1,10,3),(44331,'architecture',1,15,4),(45721,'adorn',1,1,7),(49821,'adorn',1,2,8),(69831,'architecture',1,10,13),(70131,'architecture',1,10,14),(72831,'architecture',1,10,15),(74841,'propCard',1,5,6),(86241,'propCard',1,5,5),(88432,'architecture',1,30,16);

/*Table structure for table `island_task_achievement` */

DROP TABLE IF EXISTS `island_task_achievement`;

CREATE TABLE `island_task_achievement` (
  `id` int(10) unsigned NOT NULL,
  `need_level` int(11) DEFAULT '1' COMMENT '等级条件',
  `need_num` int(11) DEFAULT NULL COMMENT '需求数量',
  `need_field` varchar(200) DEFAULT NULL COMMENT '对应需求字段',
  `name` varchar(200) DEFAULT NULL COMMENT '任务名称',
  `content` varchar(250) DEFAULT NULL COMMENT '任务描述',
  `time` int(11) DEFAULT NULL COMMENT '任务时限',
  `level` int(11) DEFAULT NULL COMMENT '任务等级',
  `coin` int(11) DEFAULT NULL COMMENT '奖励金币',
  `gold` int(11) DEFAULT '0' COMMENT '奖励宝石',
  `exp` int(11) DEFAULT NULL COMMENT '奖励经验',
  `cid` int(11) DEFAULT NULL COMMENT '奖励道具',
  `title` int(11) DEFAULT NULL COMMENT '奖励称号,对应 island_title 表 id',
  `honor` int(11) DEFAULT '0' COMMENT '奖励积分',
  `next_task` int(11) DEFAULT NULL COMMENT '对应下一等级任务id',
  `next_two_task` int(11) DEFAULT NULL COMMENT '对应下下一等级任务id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_task_achievement` */

insert  into `island_task_achievement`(`id`,`need_level`,`need_num`,`need_field`,`name`,`content`,`time`,`level`,`coin`,`gold`,`exp`,`cid`,`title`,`honor`,`next_task`,`next_two_task`) values (3001,0,50000,'14','5萬元，小case啦~','累計消費金已滿50000',86400,1,100,0,0,26241,1,5,3002,3003),(3002,0,1000000,'14','就這個不要，其它統統打包','累計消費金已滿1000000',86400,2,200,0,0,26341,2,10,3003,0),(3003,0,10000000,'14','天啦~我快破產啦~','累計消費金已滿10000000',86400,3,500,0,0,26441,3,20,0,0),(3004,0,50,'2','嘿嘿~敢和我鬥！','累計道具卡使用次數50',86400,1,50,0,50,0,4,5,3005,3006),(3005,0,200,'2','千王不是說出來的！','累計道具卡使用次數200',86400,2,100,0,100,0,5,10,3006,0),(3006,0,500,'2','神說，一切都是我的！','累計道具卡使用次數500',86400,3,300,0,200,0,6,20,0,0),(3007,0,50,'15','今年豐收啦！','島上遊客上限達到50',86400,1,0,0,50,26541,7,3,3033,3008),(3008,0,100,'15','你們都要聽我的！','島上遊客上限達到100',86400,3,0,0,500,26641,8,10,0,0),(3009,0,100,'8','hoho~happy,happy!','在好友島嶼拾錢次數達到100',86400,1,0,0,50,26341,9,3,3010,3011),(3010,0,1000,'8','不是我手快，是你偷懶哦~','在好友島嶼拾錢次數達到1000',86400,2,0,0,100,26841,10,5,3011,0),(3011,0,2000,'8','自由！財富！快加入我們~','在好友島嶼拾錢次數達到2000',86400,3,0,0,200,26941,11,10,0,0),(3012,0,100,'5','我搶的不是新娘，是遊客','在好友島嶼拉遊客船次達到100',86400,1,0,0,20,27041,12,3,3013,3014),(3013,0,1000,'5','發啦~又拉到那麼多人！','在好友島嶼拉遊客船次達到1000',86400,2,0,0,100,27141,13,5,3014,0),(3014,0,2000,'5','自我踏上這個土地，你們就是屬於我的！','在好友島嶼拉遊客船次達到2000',86400,3,0,0,200,26241,14,10,0,0),(3015,0,50,'13','地中海風格？還是混搭？真是頭大呀~','島嶼裝飾度達到50',86400,1,50,0,0,26341,15,3,3016,3017),(3016,0,150,'13','建築與園林的和諧是我的風格','島嶼裝飾度達到150',86400,2,100,0,0,26441,16,5,3017,0),(3017,0,300,'13','設計的真諦是靈魂的感動','島嶼裝飾度達到300',86400,3,300,0,0,26541,17,10,0,0),(3018,0,10,'16','我不要出去~在家就可以啦~','好友數到達10',86400,1,50,0,50,0,18,5,3019,3020),(3019,0,50,'16','小弟們都要看我的臉色！','好友數到達50',86400,2,100,0,100,0,19,10,3020,0),(3020,0,100,'16','兄弟們，以後都跟著我吃香喝辣！','好友數到達100',86400,3,200,0,200,0,20,20,0,0),(3021,0,5,'4','我為人人，人人為我','送禮數到達5',86400,1,100,0,50,0,21,3,3022,3023),(3022,0,20,'4','多做善事多積德~','送禮數到達20',86400,2,200,0,100,0,22,5,3023,0),(3023,0,100,'4','啊哈~~又到耶誕節了嗎？','送禮數到達100',86400,3,500,0,200,0,23,10,0,0),(3024,0,50,'3','狗抓老鼠，愛管閒事','處理故障數50',86400,1,50,0,0,26641,24,3,3025,3026),(3025,0,500,'3','前方火警，緊急出動！','處理故障數500',86400,2,100,0,0,26341,25,5,3026,0),(3026,0,1000,'3','人對社會的價值在於付出多少！','處理故障數1000',86400,3,500,0,0,26841,26,10,0,0),(3027,0,50,'6','隨便逛逛而已~','訪問好友島嶼次數50',86400,1,50,0,0,26941,27,3,3028,3029),(3028,0,500,'6','老朋友~我們又見面啦！','訪問好友島嶼次數500',86400,2,100,0,0,27041,28,5,3029,0),(3029,0,1000,'6','出門在外靠朋友~','訪問好友島嶼次數1000',86400,3,200,0,0,27141,29,10,0,0),(3030,0,50,'17','哇哦~這樣也行啊！','建造50種不同類型的建築',86400,1,50,0,0,26241,30,3,3031,3032),(3031,0,150,'17','我的島，我的家~','建造150種不同類型的建築',86400,2,100,0,0,26341,31,5,3032,0),(3032,0,300,'17','海島由我來保護！','建造300種不同類型的建築',86400,3,200,0,0,26441,32,10,0,0),(3033,0,70,'15','人口持續增長哦~','島上遊客上限達到70',86400,2,0,0,100,26641,33,5,3008,0),(3038,0,300,'31','我是守財奴','在自己島嶼拾錢次數達到300次',86400,1,1000,0,0,0,34,3,3039,3040),(3039,0,600,'31','一分也不浪費','在自己島嶼拾錢次數達到600次',86400,2,3000,0,0,0,35,6,3040,0),(3040,0,1000,'31','有金山啦！','在自己島嶼拾錢次數達到1000次',86400,3,5000,0,0,0,36,10,0,0),(3041,0,100,'1','瘋狂拉客','在自己島嶼上瘋狂的收船拉客100次',86400,1,300,0,100,0,37,3,3042,3043),(3042,0,300,'1','拉客狂人','在自己島嶼上瘋狂的收船拉客300次',86400,2,500,0,300,0,38,6,3043,0),(3043,0,500,'1','人滿為患啊','在自己島嶼上瘋狂的收船拉客500次',86400,3,1000,0,500,0,39,10,0,0),(3044,0,20,'20','完成20個任務','累積完成20個任務',86400,1,0,0,150,0,40,5,3045,3046),(3045,0,60,'20','完成60個任務','累積完成60個任務',86400,2,0,0,300,0,41,10,3046,0),(3046,0,100,'20','完成100個任務','累積完成100個任務',86400,3,0,0,500,0,42,20,0,0),(3050,0,10,'22','等級10級','努力提高自己的等級吧，儘量達到10級',86400,1,0,0,250,0,46,5,3051,3052),(3051,0,25,'22','等級25級','努力提高自己的等級吧，儘量達到25級',86400,2,0,0,500,0,47,20,3052,0),(3052,0,40,'22','等級40級','努力提高自己的等級吧，儘量達到40級',86400,3,0,0,2000,0,48,40,0,0),(3053,0,5,'23','小有名氣','努力增加更多的稱號頭銜吧，達到5個稱號',86400,1,500,0,100,0,49,3,3054,3055),(3054,0,20,'23','家喻戶曉','努力增加更多的稱號頭銜吧，達到20個稱號',86400,2,1000,0,200,26441,50,5,3055,0),(3055,0,50,'23','名垂青史','努力增加更多的稱號頭銜吧，達到50個稱號',86400,3,3000,0,500,0,51,10,0,0),(3059,0,2,'25','財神降臨','幫好友接船，成功累積觸發2次財神',86400,1,500,0,0,0,55,3,3060,3061),(3060,0,10,'25','人見人愛小財神！','幫好友接船，成功累積觸發10次財神',86400,2,1000,0,0,0,56,5,3061,0),(3061,0,20,'25','財神附體','幫好友接船，成功累積觸發20次財神',86400,3,2000,0,0,67341,57,10,0,0),(3062,0,2,'32','窮神降臨','幫好友接船，成功累積觸發2次窮神',86400,1,0,0,200,0,58,3,3063,3064),(3063,0,10,'32','人見人厭小窮神','幫好友接船，成功累積觸發10次窮神',86400,2,0,0,500,0,59,5,3064,0),(3064,0,20,'32','窮神附體','幫好友接船，成功累積觸發20次窮神',86400,3,0,0,800,67141,60,10,0,0),(3065,0,10,'26','消息靈通','回覆好友發過來的消息累積滿10條',86400,1,50,0,50,0,61,3,3066,3067),(3066,0,30,'26','情比金堅','回覆好友發過來的消息累積滿30條',86400,2,100,0,100,0,62,5,3067,0),(3067,0,50,'26','千里眼，順風耳','回覆好友發過來的消息累積滿50條',86400,3,200,0,200,0,63,10,0,0),(3068,0,1000,'19','生活奢侈','成功使用累積滿1000個寶石',86400,1,1000,0,500,0,64,10,3069,3070),(3069,0,10000,'19','紙醉金迷','成功使用累積滿10000個寶石',86400,2,3000,0,2000,0,65,20,3070,0),(3070,0,100000,'19','買房算什麽？','成功使用累積滿100000個寶石',86400,3,10000,0,10000,0,66,30,0,0),(3071,0,1,'27','永久留念','使用拍照功能拍攝1張照片保存',86400,1,100,0,50,0,67,3,3072,3073),(3072,0,5,'27','最美的回憶','使用拍照功能拍攝5張照片保存',86400,2,200,0,50,0,68,5,3073,0),(3073,0,20,'27','精彩瞬間','使用拍照功能拍攝20張照片保存',86400,3,300,0,100,0,69,10,0,0),(3074,0,3,'28','質量太差','成功出售3樣商品，還給商店',86400,1,100,0,50,0,70,1,3075,3076),(3075,0,30,'28','全是次品啊','成功出售30樣商品，還給商店',86400,2,200,0,50,0,71,3,3076,0),(3076,0,100,'28','給我退貨！','成功出售100樣商品，還給商店',86400,3,300,0,50,0,72,5,0,0),(3077,0,1,'29','積極參與','累積參加各種推廣遊戲運營活動1次',86400,1,1000,0,200,0,73,10,3078,3079),(3078,0,4,'29','忙碌的藝人','累積參加各種推廣遊戲運營活動4次',86400,2,2000,0,400,0,74,30,3079,0),(3079,0,8,'29','我的地盤我做主！','累積參加各種推廣遊戲運營活動8次',86400,3,3000,0,600,0,75,50,0,0),(3080,0,5,'30','喂！快收錢！','提醒好友收錢累積達到5次',86400,1,200,0,50,0,76,3,3081,3082),(3081,0,10,'30','好心人啊！','提醒好友收錢累積達到10次',86400,2,300,0,100,0,77,5,3082,0),(3082,0,20,'30','嫌金幣太多嗎？','提醒好友收錢累積達到20次',86400,3,400,0,150,0,78,10,0,0),(3083,0,10,'33','搶劫！','使用搶奪卡，搶奪10次好友島嶼金幣',86400,1,150,0,50,0,79,3,3084,3085),(3084,0,25,'33','職業：土匪','使用搶奪卡，搶奪25次好友島嶼金幣',86400,2,250,0,80,0,80,5,3085,0),(3085,0,50,'33','世紀大盜！','使用搶奪卡，搶奪50次好友島嶼金幣',86400,3,500,0,100,26941,81,10,0,0),(3086,0,1,'34','朋友~！那傢伙眼巴巴的望著你~！','朋友~！那傢伙眼巴巴的望著你~！',86400,3,2000,0,150,0,82,0,0,0),(3096,0,15,'42','海盜獵手','打開海盜寶箱15次',86400,1,500,0,50,0,96,5,3097,3098),(3097,0,40,'42','加勒比海盜','打開海盜寶箱40次',86400,2,1000,0,80,0,97,10,3098,0),(3098,0,80,'42','海賊王','打開海盜寶箱80次',86400,3,1500,0,100,0,98,20,0,0);

/*Table structure for table `island_task_build` */

DROP TABLE IF EXISTS `island_task_build`;

CREATE TABLE `island_task_build` (
  `id` int(11) NOT NULL,
  `need_level` int(11) DEFAULT '1' COMMENT '等级条件',
  `need_num` int(11) DEFAULT '1' COMMENT '需要数量',
  `need_field` int(11) DEFAULT '0' COMMENT '需要条件',
  `need_cid` int(11) DEFAULT '0' COMMENT '需要设施',
  `item_id` int(11) DEFAULT '0' COMMENT '需要设施 item_id,对应 plant 表 item_id',
  `item_level` int(11) DEFAULT '1' COMMENT '需要设施 级别',
  `name` varchar(200) DEFAULT NULL COMMENT '任务名称',
  `content` varchar(250) DEFAULT NULL COMMENT '任务内容',
  `description` varchar(250) DEFAULT NULL COMMENT '任务描述',
  `time` int(11) DEFAULT NULL COMMENT '任务时限',
  `level` int(11) DEFAULT NULL COMMENT '任务等级',
  `coin` int(11) DEFAULT NULL COMMENT '奖励金币',
  `exp` int(11) DEFAULT NULL COMMENT '奖励经验',
  `cid` int(11) DEFAULT NULL COMMENT '奖励道具',
  `title` int(11) DEFAULT '0' COMMENT '奖励称号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_task_build` */

insert  into `island_task_build`(`id`,`need_level`,`need_num`,`need_field`,`need_cid`,`item_id`,`item_level`,`name`,`content`,`description`,`time`,`level`,`coin`,`exp`,`cid`,`title`) values (2001,1,1,10,0,0,1,'遊客上島','引導任務，帶1船遊客上島','第一次上島嶼,快點點擊船隻帶遊客上島吧',86400,1,0,30,26241,0),(2002,2,1,9,2232,21,2,'建速食店','購買1個速食店並升級至2星','遊客都找不到吃飯的地方了，怎麼辦呢？建造個速食店吧！',86400,1,1000,22,26341,0),(2003,3,1,9,232,1,2,'升級廁所','升級1個廁所到2星','方便方便，哪裡有方便的地方？',86400,1,1200,52,26441,0),(2004,3,1,11,2,0,1,'升級木筏','升級1小木筏至木舟','木筏檔次太低了，需要升級了！',86400,1,1200,52,26541,0),(2005,4,1,9,16131,160,2,'建造鬼屋','購買1個鬼屋並升級到2星','遊客強烈要求來點刺激的活動。',86400,1,1300,91,26641,0),(2006,4,4,12,0,0,1,'擴展船位','擴展第4個船位','目前船隻的數量滿足不了遊客需求啦，再擴展點船隻吧。',86400,1,1300,91,26741,0),(2007,5,1,9,5332,52,2,'建造花店','購買1個花店並升級到2星','需要建造一些花店，來滿足女性顧客的需求。',86400,1,1400,140,26841,0),(2008,5,1,9,3132,31,3,'建露營地','購買1個3星露營地','顧客想要野營，可惜找不到露營地，建造1個露營地吧。',86400,1,1400,140,26941,0),(2009,6,1,9,1232,11,2,'建蛋糕店','購買1個蛋糕店並直接升級到2星','好多小朋友想吃蛋糕噢，有蛋糕店嘛？',86400,1,2000,196,27041,0),(2010,6,1,9,14431,144,3,'建卡拉OK','購買1個3星卡拉OK店','招呼大家一起來K歌吧，可惜沒有卡拉OK店。',86400,1,1500,196,27141,0),(2011,7,1,9,20532,204,2,'建水果店','購買1個水果店並升級到2星','有小朋友想吃水果，快建造一個水果店吧。',86400,1,1600,261,26241,0),(2012,7,5,12,0,0,1,'擴展船位','擴展第5個船位','目前船隻的數量滿足不了遊客需求啦，再擴展點船隻吧。',86400,1,1600,261,26341,0),(2013,8,1,9,21332,212,2,'建氣球屋','購買1個氣球屋並升級到2星','很多小朋友想要有氣球，快點建造一個氣球屋吧。',86400,1,1700,332,26441,0),(2014,8,1,9,20132,201,3,'建造鐘樓','購買1個3星鐘樓','時間就是金錢，似乎島嶼上都看不到時間噢！',86400,1,2000,332,26541,0),(2015,9,1,9,732,6,2,'建造旅館','購買1個旅館並升級到2星','似乎住的地方又少了，趕快建造點旅館吧。',86400,1,1800,411,26641,0),(2016,9,1,9,19432,193,2,'建理髮店','購買1個理髮店並升級到2星','有些遊客住了很久，想理髮了，我們去建造一個理髮店吧',86400,1,1800,411,26741,0),(2017,10,1,9,17132,170,2,'冰激凌店','購買1個冰激淩店並升級到2星','小朋友們想吃冰激淩了，怎麼辦？快建造一個冰激淩店吧！',86400,1,1900,496,26841,0),(2018,10,1,9,5831,57,2,'建造劇院','購買1個劇院並升級到2星','如果能在島嶼上欣賞到大片就美滿了，快去建造1個劇院吧。',86400,1,1900,496,26941,0),(2019,10,1,9,20931,209,3,'建摩天輪','購買1個摩天輪','看到迪士尼樂園的摩天輪難道我們能輸給他們嘛？快建造1個大大的摩天輪吧。',86400,1,5000,496,27041,0),(2020,11,1,9,19032,188,3,'建造茶館','購買1個茶館並升級3星','能夠讓老爺爺們一起喝點茶那就更好啦，快建造一個茶館吧。',86400,1,2000,588,27141,0),(2021,11,2,11,5,0,1,'升級帆船','升級2艘大帆船','大帆船已經無法滿足遊客的需求啦，快去升級吧！',86400,1,2000,588,26241,0),(2022,11,1,11,4,0,1,'升級帆木','升級1艘帆木船','帆木船已經無法滿足遊客的需求了，快去升級吧！',86400,1,1500,588,26341,0),(2023,12,1,9,4431,44,3,'建排球場','購買1個沙灘排球場','有沙灘沒有排球場是多麼悲劇的一件事呀，快建造一個沙灘排球場吧。',86400,1,2100,687,26441,0),(2024,12,1,9,16732,165,3,'建造SPA','購買1個SPA並升級到3星','給島嶼上的美女們建造一個美容的SPA吧。',86400,1,2100,687,26541,0),(2025,12,1,9,3431,34,3,'建海盜船','購買1個3星海盜船','想嘗嘗當海盜的滋味嘛？快去建造一個海盜船吧。',86400,1,2100,687,26641,0),(2026,13,1,9,1832,16,3,'升級飲料店','升級1個飲料店到3星','高級飲料去哪裡買呢？滿足不了人們的需求啦！',86400,1,2200,791,26741,0),(2027,13,1,9,832,6,3,'升級旅館','升級1個旅館到3星','低級旅館已經滿足不了人們的需求了，升級個3星旅館吧。',86400,1,2200,791,26841,0),(2028,13,1,9,2332,21,3,'升級速食店','升級1個速食店到3星','低級旅館已經滿足不了人們的需求了，升級個3星旅館吧。',86400,1,2200,791,26941,0),(2029,14,100,13,0,0,1,'提升裝飾度','提升島嶼裝飾度到100','島嶼不夠華麗，再提升點裝飾度吧。',86400,1,2300,902,27041,0),(2030,14,1,9,15231,152,3,'建鯨魚館','購買1個3星鯨魚館','釣了兩條大鯨魚，快建造個鯨魚館來養把！好大哦！',86400,1,2300,902,27141,0),(2031,14,1,9,4932,47,3,'建造教堂','購買1個教堂並升級到3星','來了一批基督教的教徒觀光，人家要求造教堂，加把勁吧。',86400,1,2300,902,26241,0),(2032,15,1,9,19832,198,3,'建爆米花店','購買1個3星爆米花店','小朋友們想吃爆米花了，可以沒有怎麼辦呢？',86400,1,2400,1018,26341,0),(2033,15,3,9,4031,39,2,'建造風車','購買3個風車並全部升級到2星','風車太少了，多建造點風車吧！',86400,1,2000,1018,26441,0),(2034,15,6,12,0,0,1,'擴展船位','擴展第6個船位','船位不夠啦，又要擴展船位啦，擴展第六個船位吧。',86400,1,2400,1018,26541,0),(2035,16,1,9,4131,39,3,'升級風車','升級1個風車到3星','把低級風車升級一下吧，已經無法滿足顧客的需求咯。',86400,1,2500,1140,26641,0),(2036,16,1,9,18331,183,3,'建兒童樂園','購買1個三星的兒童樂園','兒童樂園在哪裡呢？小朋友們沒地方遊樂了。',86400,1,2200,1140,26741,0),(2037,16,1,9,14932,147,3,'升級禮品店','升級1個禮品店到3星','有高檔禮品買嘛？低級禮品店無法滿足顧客的需求了。',86400,1,2500,1140,26841,0),(2038,17,1,9,16231,160,3,'升級鬼屋','升級1個鬼屋到3星','1星2星鬼屋已經無法滿足顧客的刺激程度啦。升級1個鬼屋到3星吧。',86400,1,2600,1268,26941,0),(2039,17,1,9,932,6,4,'建造旅館','旅館滿足不了遊客的需求，再建一座4星旅館吧','低級旅館滿足不了顧客們的需求了，再建造一座4星旅館吧。',86400,1,2600,1268,27041,0),(2040,17,1,9,18031,180,3,'建旋轉木馬','購買1個3星旋轉木馬','低級旋轉木馬滿足不了小朋友的需求了，再建造一個3星旋轉木馬吧。',86400,1,2600,1268,27141,0),(2041,18,1,9,14531,144,4,'升級卡拉OK','升級1個卡拉OK店到4星','遊客們強烈要求一座4星得卡拉OK店呢。',86400,1,2700,1402,26241,0),(2042,18,1,9,6031,57,4,'升級劇院','升級1個劇院到4星','超級大片去哪裡看呢？有高檔的劇院嗎？',86400,1,2700,1402,26341,0),(2043,18,1,9,15831,155,4,'建造過山車','購買1個過山車並升級到4星','有更刺激的娛樂項目嘛？比如過山車？',86400,1,2700,1402,26441,0),(2044,19,1,9,4531,44,4,'升級排球場','升級1個沙灘排球場到4星','沙灘排球可以升級啦，現在太簡陋了。',86400,1,2800,1541,26541,0),(2045,19,1,9,21031,209,4,'升級摩天輪','升級1個摩天輪到4星','摩天輪該升級啦，現在太簡陋了，遊客都不滿足了。',86400,1,2800,1541,26641,0),(2046,19,1,11,6,0,1,'升級快艇','升級1艘白色快艇','普通船隻無法滿足遊客了去升級一搜白色快艇吧。',86400,1,2800,1541,26741,0),(2047,20,1,9,3531,34,4,'升級海盜船','升級一個4星海盜船','海盜船都快沒人玩了，檔次太低了，遊客強烈要求升級呢。',86400,1,2900,1685,26841,0),(2048,20,7,12,0,0,1,'擴展船位','擴展第7個船位','船位又有需求了，現在的六個船位無法滿足了。',86400,1,2900,1685,26941,0),(2049,20,1,9,2931,26,4,'建造城堡','購買1個主題城堡並升級到4星','主題城堡有嘛？小朋友們有需求啦，快建造一個主題城堡吧。',86400,1,2900,1685,27041,0),(2050,21,1,9,432,1,4,'4星廁所','升級一個廁所到4星','遊客對廁所的需求也開始有要求了呢，快升級1個廁所到4星吧。',86400,1,3000,1834,27141,0),(2051,21,1,9,1432,11,4,'4星蛋糕店','升級一個蛋糕店到4星','遊客想吃更高級的蛋糕，有高級蛋糕店嘛？',86400,1,3000,1834,26241,0),(2052,22,1,9,2432,21,4,'4星速食店','升級一個速食店到4星','有更高級的速食店嗎？',86400,1,3100,1989,26341,0),(2053,22,1,9,1932,16,4,'4星飲料亭','升級一個飲料亭到4星','有更高檔的飲料亭嗎？',86400,1,3100,1989,26441,0),(2054,23,1,9,5532,52,4,'4星花店','升級一個花店到4星','有更高檔的花店嗎？',86400,1,3200,2149,26541,0),(2055,23,1,9,15032,147,4,'4星禮品店','升級一個禮品店到4星','有檔次更高級的禮品店嗎？',86400,1,3200,2149,26641,0),(2056,24,1,9,19132,188,4,'4星茶館','升級一個茶館到4星','有檔次更高級的茶館嗎？',86400,1,3300,2314,26741,0),(2057,24,1,9,19632,193,4,'4星理髮店','升級一個理髮店到4星','遊客們想要一個一流的理髮店，能滿足他們需求嗎？',86400,1,3300,2314,26841,0),(2058,25,1,9,19932,198,4,'4星爆米花','升級一個爆米花店到4星','普通的爆米花已經無法吸引小朋友了。',86400,1,3400,2483,26941,0),(2059,25,1,9,20232,201,4,'4星鐘樓','升級一個鐘樓到4星','鐘樓似乎開始不準確了，去把它變的更高級吧。',86400,1,3400,2483,27041,0),(2060,26,1,9,532,1,5,'5星廁所','升級一個廁所到5星','有檔次更高的廁所嗎？',86400,1,3500,2658,27141,0),(2061,26,1,9,20732,204,4,'4星水果店','升級一個水果店到4星','有水果種類更多的水果店嗎？',86400,1,3500,2658,26241,0),(2062,27,1,9,1532,11,5,'5星蛋糕店','升級一個蛋糕店到5星','想要吃更好吃的蛋糕去哪裡買呢？',86400,1,3600,2838,26341,0),(2063,27,1,9,21532,212,4,'4星氣球屋','升級一個氣球屋到4星','小朋友們希望看到有五顏六色的氣球，去哪裡買呢？',86400,1,3600,2838,26441,0),(2064,28,3,11,6,0,1,'升級快艇','升級3艘白色快艇','一般的船隻無法滿足遊客了，去升級白色快艇吧。',86400,1,3700,3022,26541,0),(2065,28,1,9,16331,160,4,'4星鬼屋','升級一個鬼屋到4星','一般的鬼屋已經無法滿足遊客的刺激程度啦。',86400,1,3700,3022,26641,0),(2066,29,8,12,0,0,1,'擴展船位','擴展第8個船位','船位已經無法滿足遊客了，快擴展更多的船位吧。',86400,1,3800,3211,26741,0),(2067,29,1,9,16832,165,4,'4星SPA','升級一個SPA到4星','一般的鬼屋已經無法滿足遊客的刺激程度啦。',86400,1,3800,3211,26841,0),(2068,30,1,9,2532,21,5,'5星速食店','升級一個速食店到5星','一般的速食店已經無法滿足遊客啦，。升級一個更高檔的速食店吧。',86400,1,3900,3405,26941,0),(2069,30,1,9,17332,170,4,'霜淇淋店','升級一個霜淇淋店到4星','一般的霜淇淋店已經無法滿足遊客啦，。升級一個更高檔的霜淇淋店吧。',86400,1,3900,3405,27041,0),(2070,31,1,9,14531,144,5,'卡拉OK','升級一個卡拉OK到5星','一般的卡拉OK店已經無法滿足遊客啦，。升級一個更高檔的卡拉OK店吧。',86400,1,4000,3604,26741,0),(2071,31,1,9,17832,175,4,'4星沙灘椅','升級一個沙灘椅到4星','一般的沙灘椅已經無法滿足遊客啦，。升級一個更高檔的沙灘椅吧。',86400,1,4000,3604,26241,0),(2072,32,1,9,6131,57,5,'5星劇院','升級一個劇院到5星','一般的劇院已經無法滿足遊客啦，。升級一個更高檔的劇院吧。',86400,1,4100,3807,26341,0),(2073,32,1,9,5032,47,4,'4星教堂','升級一個教堂到4星','一般的教堂已經無法滿足基督教的遊客啦，。升級一個更高檔的教堂吧。',86400,1,4100,3807,26441,0),(2074,33,1,9,2032,16,5,'5星飲料亭','升級一個飲料亭到5星','一般的飲料亭已經無法滿足遊客啦，。升級一個更高檔的飲料亭吧。',86400,1,4200,4015,26541,0),(2075,33,1,9,36032,360,4,'4星鐘塔','購買一個4星的鐘塔','有更高級的鐘塔嗎？遊客們在強烈要求建造噢。',86400,1,4200,4015,26641,0),(2076,34,1,9,15132,147,5,'5星禮品店','升級一個禮品店到5星','有更高級的禮品店嗎？遊客們在強烈要求建造噢。',86400,1,4300,4227,26741,0),(2077,34,1,9,21031,209,4,'4星摩天輪','升級一個摩天輪到4星','有更高級的摩天輪嗎？遊客們在強烈要求建造噢。',86400,1,4300,4227,26841,0),(2078,35,1,9,19232,188,5,'5星茶館','升級一個茶館到5星','有更高級的茶館嗎？遊客們在強烈要求建造噢。',86400,1,4400,4444,26941,0),(2079,35,1,9,15331,152,4,'4星鯨魚館','升級一個鯨魚館到4星','有更高級的鯨魚館嗎？遊客們在強烈要求建造噢。',86400,1,4400,4444,27041,0),(2080,36,5,11,7,0,1,'升級快艇','升級5艘紅色快艇','普通船隻無法滿足遊客，升級更高級的遊艇吧。',86400,1,4500,4665,27141,0),(2081,36,1,9,5632,52,5,'5星花店','升級一個花店到5星','有更高級的花店嗎？遊客們在強烈要求建造噢。',86400,1,4500,4665,26241,0),(2082,37,1,9,18131,180,4,'旋轉木馬','升級一個旋轉木馬到4星','有更高級的旋轉木馬嗎？遊客們在強烈要求建造噢。',86400,1,4600,4890,26341,0),(2083,37,1,9,20032,198,5,'爆米花點','升級一個爆米花店到5星','有更高級的爆米花店嗎？遊客們在強烈要求建造噢。',86400,1,4600,4890,26441,0),(2084,38,1,9,18431,183,4,'兒童樂園','升級一個兒童樂園到4星','有更高級的兒童樂園嗎？遊客們在強烈要求建造噢。',86400,1,4700,5120,26541,0),(2085,38,1,9,20332,201,5,'5星鐘樓','升級一個鐘樓到5星','有更高級的鐘樓嗎？遊客們在強烈要求建造噢。',86400,1,4700,5120,26641,0),(2086,39,1,9,19732,193,5,'5星理髮店','升級一個理髮店到5星','有更高級的理髮店嗎？遊客們在強烈要求建造噢。',86400,1,4800,5355,26741,0),(2087,39,7,11,8,0,1,'升級油輪','升級7艘豪華遊輪','普通遊艇已經無法滿足遊客了，升級更高級的豪華遊輪吧。',86400,1,4800,5355,26841,0),(2088,40,1,9,20832,204,5,'5星水果店','升級一個水果店到5星','有更高級的水果店嗎？遊客們在強烈要求建造噢。',86400,1,4900,5593,26941,0),(2089,40,1,9,21632,212,5,'5星氣球屋','升級一個氣球屋到5星','有更高級的氣球屋嗎？遊客們在強烈要求建造噢。',86400,1,4900,5593,27041,0),(2090,41,1,9,16431,160,5,'5星鬼屋','升級一個鬼屋到5星','有更高級的鬼屋嗎？遊客們在強烈要求建造噢。',86400,1,5000,5836,27141,0),(2091,41,1,9,16932,165,5,'5星SPA','升級一個SPA到5星','有更高級的SPA嗎？遊客們在強烈要求建造噢。',86400,1,5000,5836,26241,0),(2092,42,1,9,17432,170,5,'5星霜淇淋','升級一個霜淇淋店到5星','有更高級的霜淇淋店嗎？遊客們在強烈要求建造噢。',86400,1,5100,6083,26341,0),(2093,42,1,9,17932,175,5,'5星沙灘椅','升級一個沙灘椅店到5星','有更高級的沙灘椅店嗎？遊客們在強烈要求建造噢。',86400,1,5100,6083,26441,0),(2094,43,1,9,36132,360,5,'5星鐘塔','升級一個鐘塔到5星','有更高級的鐘塔嗎？遊客們在強烈要求建造噢。',86400,1,5200,6334,26541,0),(2095,43,1,9,4631,44,5,'沙灘排球','升級一個沙灘排球到5星','有更高級的殺他排球嗎？遊客們在強烈要求建造噢。',86400,1,5200,6334,26641,0),(2096,44,1,9,21131,209,5,'5星摩天輪','升級一個摩天輪到5星','有更高級的摩天輪嗎？遊客們在強烈要求建造噢。',86400,1,5300,6590,26741,0),(2097,44,1,9,15431,152,5,'5星鯨魚館','升級一個鯨魚館到5星','有更高級的鯨魚館嗎？遊客們在強烈要求建造噢。',86400,1,5300,6590,26841,0),(2098,45,1,9,3631,34,5,'5星海盜船','升級一個海盜船到5星','有更高級的海盜船嗎？遊客們在強烈要求建造噢。',86400,1,5400,6849,26941,0),(2099,45,1,9,18231,180,5,'旋轉木馬','升級一個旋轉木馬到5星','有更高級的旋轉木馬嗎？遊客們在強烈要求建造噢。',86400,1,5400,6849,27041,0),(2100,46,1,9,15931,155,5,'5星過山車','升級一個過山車到5星','有更高級的過山車嗎？遊客們在強烈要求建造噢。',86400,1,5500,7113,27141,0),(2101,46,1,9,3031,26,5,'5星城堡','升級一個城堡到5星','有更高級的城堡嗎？遊客們在強烈要求建造噢。',86400,1,5500,7113,26241,0),(2102,47,1,9,18531,183,5,'兒童樂園','升級一個兒童樂園到5星','有更高級的兒童樂園嗎？遊客們在強烈要求建造噢。',86400,1,5600,7381,26341,0),(2103,47,1,9,42031,418,5,'5星馬戲團','升级一个马戏团到5星','把馬戲團升級到最華麗的狀態吧。',86400,1,5600,7381,26441,0),(2104,48,1,9,43632,434,5,'5星娃娃機','升级一个抓娃娃机到5星','把抓娃娃機升級到最華麗的狀態吧。',86400,1,5700,7653,26541,0),(2105,48,1,9,43932,437,5,'小熊玩具店','升级一个小熊玩具店到5星','把小熊玩具店升級到最華麗的狀態吧。',86400,1,5700,7653,26641,0),(2106,49,1,9,44231,440,5,'5星搖搖馬','升级一个摇摇马到5星','把搖搖馬升級到最華麗的狀態吧。',86400,1,5800,7929,26741,0),(2107,49,1,9,47832,476,5,'5星沙雕','升级一个沙雕到5星','把沙雕升級到最華麗的狀態吧。',86400,1,5800,7929,26841,0),(2108,50,1,9,48732,485,5,'5星海鮮店','升级一个海鲜店到5星','把海鮮店升級到最華麗的狀態吧。',86400,1,5900,8208,26941,0),(2109,50,1,9,49632,494,5,'5星度假屋','升级一个度假屋到5星','把度假屋升級到最華麗的狀態吧。',86400,1,5900,8208,27041,0),(2110,51,1,9,49332,491,5,'5星船屋','升级一个船屋到5星','把船屋升級到最華麗的狀態吧。',86400,1,6000,8492,27141,0),(2111,51,1,9,48432,482,5,'5星貝殼店','升级一个贝壳商店到5星','把貝殼商店升級到最華麗的狀態吧。',86400,1,6000,8492,26241,0),(2112,52,1,9,44531,443,5,'5星滑滑梯','升级一个滑滑梯到5星','把滑滑梯升級到最華麗的狀態吧。',86400,1,6100,8780,26341,0),(2113,52,1,9,45431,452,5,'5星游泳池','升级一个充气游泳池到5星','把充氣游泳池升級到最華麗的狀態吧。',86400,1,6100,8780,26441,0),(2114,53,1,9,49031,488,5,'海島寶藏','升级一个海岛宝藏到5星','把海島寶藏升級到最華麗的狀態吧。',86400,1,6200,9072,26541,0),(2115,53,1,9,45131,449,5,'5星小火車','升级一个小火车到5星','把小火車升級到最華麗的狀態吧。',86400,1,6200,9072,26641,0),(2116,54,1,9,37831,376,5,'5星瀑布','升级一个瀑布到5星','把瀑布升級到最華麗的狀態吧。',86400,1,6300,9368,26741,0),(2117,55,1,9,38131,379,5,'5星雪山','升级一个雪山到5星','把雪山升級到最華麗的狀態吧。',86400,1,6400,9667,26841,0),(2118,56,1,9,42331,421,5,'5星火山','升级一个火山到5星','把火山升級到最華麗的狀態吧。',86400,1,6500,9971,26941,0);

/*Table structure for table `island_task_condition` */

DROP TABLE IF EXISTS `island_task_condition`;

CREATE TABLE `island_task_condition` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '对应id ',
  `condition` varchar(200) DEFAULT NULL COMMENT '任务条件',
  `content` varchar(200) DEFAULT NULL COMMENT '条件介绍',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

/*Data for the table `island_task_condition` */

insert  into `island_task_condition`(`id`,`condition`,`content`) values (1,'接待船只','游客'),(2,'道具卡使用','道具卡'),(3,'修理设施故障','故障'),(4,'给好友送礼','给好友送礼3个好友'),(5,'拉客船次','拉游客'),(6,'访问好友岛屿','访问好友'),(7,'拉客人数','拉游客'),(8,'拾取金币，次数','拾取金币，次数'),(9,'设施建设','建设1个3星旅馆'),(10,'接待游客','引导任务，带2名游客上岛'),(11,'拥有船只','升级1艘橡皮艇'),(12,'拥有船位','扩展第5个船位'),(13,'装饰度','提升岛屿装饰度到100'),(14,'消费总金额','累计消费金贝满50000'),(15,'岛上游客上限','岛上游客上限达到50'),(16,'好友数','好友数到达20'),(17,'装饰类设施','岛屿装饰类设施50'),(18,'邀请好友','成功邀请好友5人'),(19,'消费宝石金额','累计消费宝石满50'),(20,'完成任务数量','累积完成50个任务，包括日常任务和建设任务'),(21,'持有金币总金额','累积自己金币达到10000000金币'),(22,'等级提升','提升自己等级达到30级'),(23,'称号数量','努力增加更多头衔，累积达到5个称号'),(24,'累积宝石数量','拥有100000个宝石'),(25,'触发各种神卡','累积触发2次财神降临'),(26,'消息回复和发送','回复好友发过来的消息累积满10条'),(27,'拍照数量','累积成功拍摄5张照片并保存'),(28,'出售商品','成功出售3样商品还给商店'),(29,'参加运营推广活动','累积参加各种运营推广活动8次'),(30,'提醒功能','提醒不同好友收钱，累积满10次'),(34,'增加童话王国岛屿','达到15级解锁童话王国岛屿'),(35,'增加失落世界岛屿','达到25级解锁失落世界岛屿'),(36,'增加游乐园岛屿','达到40级解锁游乐园岛屿'),(37,'增加童话王国、失落世界、游乐园3个岛屿','所有岛屿全部解锁'),(38,'登陆排行榜冠军','登陆过1次任意排行榜第一名'),(39,'登陆排行榜亚军','登陆过1次任意排行榜第二名'),(40,'登陆排行榜季军','登陆过1次任意排行榜第三名'),(41,'登陆排行榜前10','登陆过1次任意排行榜进入前10名'),(42,'开海岛宝箱','打开海岛宝箱15次');

/*Table structure for table `island_task_daily` */

DROP TABLE IF EXISTS `island_task_daily`;

CREATE TABLE `island_task_daily` (
  `id` int(11) NOT NULL,
  `need_level` int(11) DEFAULT '1' COMMENT '等级条件',
  `need_num` int(11) DEFAULT NULL COMMENT '数量要求条件',
  `need_field` varchar(200) DEFAULT NULL COMMENT '对应要求字段',
  `name` varchar(200) DEFAULT NULL COMMENT '任务名称',
  `content` varchar(250) DEFAULT NULL COMMENT '任务内容',
  `description` varchar(250) DEFAULT NULL COMMENT '任务描述',
  `time` int(11) DEFAULT NULL COMMENT '任务时限',
  `level` int(11) DEFAULT NULL COMMENT '任务等级',
  `coin` int(11) DEFAULT NULL COMMENT '奖励金币',
  `exp` int(11) DEFAULT NULL COMMENT '奖励经验',
  `cid` int(11) DEFAULT NULL COMMENT '奖励道具',
  `title` int(11) DEFAULT '0' COMMENT '奖励称号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_task_daily` */

insert  into `island_task_daily`(`id`,`need_level`,`need_num`,`need_field`,`name`,`content`,`description`,`time`,`level`,`coin`,`exp`,`cid`,`title`) values (1001,1,10,'1','接待遊客','在自己島嶼接待10船遊客','趕快在自己島嶼接待遊客吧！',24,0,500,200,0,0),(1002,1,10,'2','使用卡片','使用10次道具卡','嘗試一下道具卡的強大力量吧！',24,0,500,0,26941,0),(1003,1,10,'3','處理故障','修理有故障的設施10次','有些建築有故障了，快去修理吧！',24,0,0,200,26441,0),(1004,1,3,'4','好友送禮','給好友送禮3個好友','好友之間互相聯繫才是好習慣嘛！',24,0,0,0,26341,0),(1005,1,15,'5','好友拉客','訪問好友島嶼拉15船遊客','去好友島嶼多拉點遊客吧！',24,0,0,200,26841,0),(1006,1,10,'6','訪問好友','訪問10個好友島嶼','快去不同的好友島嶼逛逛吧！',24,0,50,50,0,0),(1007,1,40,'7','好友拉客','訪問好友島嶼拉40個遊客','朋友夠多嗎？去他們島嶼拉他們的客人吧！',24,0,0,100,27141,0),(1008,1,30,'8','拾取金幣','訪問好友島嶼拾取30次','抓緊時間，快去好友島嶼偷取金幣',24,0,0,100,26541,0);

/*Table structure for table `island_title` */

DROP TABLE IF EXISTS `island_title`;

CREATE TABLE `island_title` (
  `id` smallint(5) unsigned NOT NULL,
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '称号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `island_title` */

insert  into `island_title`(`id`,`title`) values (1,'月光族'),(2,'購物狂'),(3,'敗家子'),(4,'六指琴魔'),(5,'千王之王'),(6,'千手觀音'),(7,'莊主'),(8,'郡主'),(9,'鬼手'),(10,'燕子李三'),(11,'海盜王'),(12,'王老五'),(13,'奴隸販子'),(14,'殖民者'),(15,'小資家'),(16,'設計師'),(17,'風水大師'),(18,'宅一族'),(19,'堂主'),(20,'幫主'),(21,'好心人'),(22,'慈善家'),(23,'聖誕老人'),(24,'愛管閒事'),(25,'救火隊長'),(26,'年度公益'),(27,'過路客'),(28,'熟客'),(29,'社交人士'),(30,'DIY能手'),(31,'園林師'),(32,'建築師'),(33,'村主'),(34,'愛財如命'),(35,'一毛不拔'),(36,'鐵公雞'),(37,'風速'),(38,'神手客'),(39,'雷厲風行'),(40,'能者'),(41,'天能者'),(42,'神能者'),(43,'金庫'),(44,'超級金庫'),(45,'銀行行長'),(46,'高手'),(47,'強力黨'),(48,'天之驕子'),(49,'名人'),(50,'如雷貫耳'),(51,'舉世聞名'),(52,'小康'),(53,'富翁'),(54,'富豪'),(55,'牛運'),(56,'神運'),(57,'財神'),(58,'衰運'),(59,'衰人'),(60,'衰神'),(61,'千里眼'),(62,'順風耳'),(63,'齊天大聖'),(64,'保險箱'),(65,'金庫'),(66,'地下寶藏'),(67,'攝影師'),(68,'攝影家'),(69,'藝術家'),(70,'成功退貨'),(71,'買賣商人'),(72,'奸商'),(73,'熱心者'),(74,'狂熱者'),(75,'瘋狂的人'),(76,'好人'),(77,'好心人'),(78,'活菩薩'),(79,'土匪'),(80,'大盜'),(81,'盜聖'),(82,'感恩之心'),(88,'島主'),(89,'島王'),(90,'島聖'),(91,'快樂島主'),(92,'冠軍'),(93,'亞軍'),(94,'季軍'),(95,'競爭者'),(96,'海盜'),(97,'海賊'),(98,'加勒比');

/*Table structure for table `seq_uid` */

DROP TABLE IF EXISTS `seq_uid`;

CREATE TABLE `seq_uid` (
  `name` char(1) NOT NULL,
  `id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `seq_uid` */

insert  into `seq_uid`(`name`,`id`) values ('0',1010),('1',1001),('2',1012),('3',1003),('4',1004),('5',1005),('6',1006),('7',1017),('8',1008),('9',1009);

/*Table structure for table `uid_map_0` */

DROP TABLE IF EXISTS `uid_map_0`;

CREATE TABLE `uid_map_0` (
  `uid` int(11) unsigned NOT NULL,
  `puid` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `puid` (`puid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `uid_map_0` */

insert  into `uid_map_0`(`uid`,`puid`,`status`,`create_time`) values (1010,'39629460',0,1311583567);

/*Table structure for table `uid_map_1` */

DROP TABLE IF EXISTS `uid_map_1`;

CREATE TABLE `uid_map_1` (
  `uid` int(11) unsigned NOT NULL,
  `puid` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `puid` (`puid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `uid_map_1` */

/*Table structure for table `uid_map_2` */

DROP TABLE IF EXISTS `uid_map_2`;

CREATE TABLE `uid_map_2` (
  `uid` int(11) unsigned NOT NULL,
  `puid` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `puid` (`puid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `uid_map_2` */

insert  into `uid_map_2`(`uid`,`puid`,`status`,`create_time`) values (1012,'39947392',0,1311581596);

/*Table structure for table `uid_map_3` */

DROP TABLE IF EXISTS `uid_map_3`;

CREATE TABLE `uid_map_3` (
  `uid` int(11) unsigned NOT NULL,
  `puid` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `puid` (`puid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `uid_map_3` */

/*Table structure for table `uid_map_4` */

DROP TABLE IF EXISTS `uid_map_4`;

CREATE TABLE `uid_map_4` (
  `uid` int(11) unsigned NOT NULL,
  `puid` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `puid` (`puid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `uid_map_4` */

/*Table structure for table `uid_map_5` */

DROP TABLE IF EXISTS `uid_map_5`;

CREATE TABLE `uid_map_5` (
  `uid` int(11) unsigned NOT NULL,
  `puid` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `puid` (`puid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `uid_map_5` */

/*Table structure for table `uid_map_6` */

DROP TABLE IF EXISTS `uid_map_6`;

CREATE TABLE `uid_map_6` (
  `uid` int(11) unsigned NOT NULL,
  `puid` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `puid` (`puid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `uid_map_6` */

/*Table structure for table `uid_map_7` */

DROP TABLE IF EXISTS `uid_map_7`;

CREATE TABLE `uid_map_7` (
  `uid` int(11) unsigned NOT NULL,
  `puid` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `puid` (`puid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `uid_map_7` */

insert  into `uid_map_7`(`uid`,`puid`,`status`,`create_time`) values (1017,'40145547',0,1311668162);

/*Table structure for table `uid_map_8` */

DROP TABLE IF EXISTS `uid_map_8`;

CREATE TABLE `uid_map_8` (
  `uid` int(11) unsigned NOT NULL,
  `puid` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `puid` (`puid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `uid_map_8` */

/*Table structure for table `uid_map_9` */

DROP TABLE IF EXISTS `uid_map_9`;

CREATE TABLE `uid_map_9` (
  `uid` int(11) unsigned NOT NULL,
  `puid` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `puid` (`puid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `uid_map_9` */

USE `kimotw_island_basic`;
truncate table `uid_map_0`;
truncate table `uid_map_1`;
truncate table `uid_map_2`;
truncate table `uid_map_3`;
truncate table `uid_map_4`;
truncate table `uid_map_5`;
truncate table `uid_map_6`;
truncate table `uid_map_7`;
truncate table `uid_map_8`;
truncate table `uid_map_9`;
update seq_uid set id = 1000+`name`;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
