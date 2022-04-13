﻿# Host: 192.168.1.55  (Version 5.7.34)
# Date: 2022-04-13 13:33:21
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "qc_category"
#

DROP TABLE IF EXISTS `qc_category`;
CREATE TABLE `qc_category` (
  `CateId` int(11) NOT NULL AUTO_INCREMENT,
  `PCateId` int(11) NOT NULL DEFAULT '0' COMMENT '上级栏目',
  `Name` varchar(50) NOT NULL DEFAULT '',
  `Pic` varchar(255) NOT NULL DEFAULT '',
  `ModelId` int(11) NOT NULL DEFAULT '0' COMMENT '名字标识',
  `IsPost` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否支持投稿',
  `IsShow` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `UserLevel` int(11) NOT NULL DEFAULT '0' COMMENT '浏览权限',
  `IsLink` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否外链',
  `LinkUrl` varchar(255) NOT NULL DEFAULT '' COMMENT '外链地址',
  `TempList` varchar(255) NOT NULL DEFAULT '',
  `TempDetail` varchar(255) NOT NULL DEFAULT '',
  `SeoTitle` varchar(255) NOT NULL DEFAULT '',
  `Keywords` varchar(255) NOT NULL DEFAULT '',
  `Description` varchar(255) NOT NULL DEFAULT '',
  `Content` text NOT NULL COMMENT '栏目内容',
  `IsCross` tinyint(3) NOT NULL DEFAULT '2' COMMENT '栏目交叉',
  `Sort` int(11) NOT NULL DEFAULT '99',
  `PinYin` varchar(255) NOT NULL DEFAULT '',
  `PY` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`CateId`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

#
# Data for table "qc_category"
#

INSERT INTO `qc_category` VALUES (1,0,'新闻动态','/Static/images/banner1.jpg',1,1,1,0,2,'','list_article.html','detail_article.html','','','','',0,91,'xinwendongtai','xwdt'),(16,0,'相册展示','/Static/images/banner1.jpg',3,1,1,0,2,'','list_album.html','detail_album.html','产品展示例子，图片摘自互联网','','','',0,93,'xiangcezhanshi','xczs'),(22,0,'联系我们','/Static/images/banner1.jpg',-1,1,1,0,2,'','list_contact.html','detail_page.html','','','','',0,95,'lianxiwomen','lxwm'),(23,0,'产品中心','/Static/images/banner1.jpg',2,1,1,0,2,'','list_product.html','detail_product.html','产品中心所有产品都是演示数据，非真实销售数据','','','',0,92,'chanpinzhongxin','cpzx'),(24,0,'软件下载','/Static/images/banner1.jpg',4,1,1,0,2,'','list_down.html','detail_down.html','','','','',0,94,'ruanjianxiazai','rjxz'),(26,0,'公司介绍','/Static/images/banner1.jpg',-1,1,1,0,2,'','list_page.html','detail_page.html','','','','',0,90,'gongsijieshao','gsjs'),(27,26,'公司简介','/Static/images/banner1.jpg',-1,1,1,0,2,'','list_page.html','detail_page.html','','','','<figure class=\"image\"><img src=\"/Static/images/about.jpg\"></figure><p>公司创立于2008年12月，是国内**企业端信息管理系统整体解决方案供应商，具备深厚的专业咨询服务能力。<br><br>公司自成立以来，一直以“IT+T（信息化+管理服务）”的创新服务模式戮力前行，专注于企业端的信息管理信息化系统建设，为客户提供大企业集团信息管理体系设计与搭建专业咨询、企业端信息管理系统定制化应用开发与系统集成、现有业务系统涉税改造IT咨询、信息管理系统部署实施、专业培训等一站式整体解决方案。<br>公司创立于2008年12月，是国内**企业端信息管理系统整体解决方案供应商，具备深厚的专业咨询服务能力。<br><br>公司自成立以来，一直以“IT+T（信息化+管理服务）”的创新服务模式戮力前行，专注于企业端的信息管理信息化系统建设，为客户提供大企业集团信息管理体系设计与搭建专业咨询、企业端信息管理系统定制化应用开发与系统集成、现有业务系统涉税改造IT咨询、信息管理系统部署实施、专业培训等一站式整体解决方案。<br>公司创立于2008年12月，是国内**企业端信息管理系统整体解决方案供应商，具备深厚的专业咨询服务能力。<br><br>公司自成立以来，一直以“IT+T（信息化+管理服务）”的创新服务模式戮力前行，专注于企业端的信息管理信息化系统建设，为客户提供大企业集团信息管理体系设计与搭建专业咨询、企业端信息管理系统定制化应用开发与系统集成、现有业务系统涉税改造IT咨询、信息管理系统部署实施、专业培训等一站式整体解决方案。<br>公司创立于2008年12月，是国内**企业端信息管理系统整体解决方案供应商，具备深厚的专业咨询服务能力。<br><br>公司自成立以来，一直以“IT+T（信息化+管理服务）”的创新服务模式戮力前行，专注于企业端的信息管理信息化系统建设，为客户提供大企业集团信息管理体系设计与搭建专业咨询、企业端信息管理系统定制化应用开发与系统集成、现有业务系统涉税改造IT咨询、信息管理系统部署实施、专业培训等一站式整体解决方案。<br>公司创立于2008年12月，是国内**企业端信息管理系统整体解决方案供应商，具备深厚的专业咨询服务能力。<br><br>公司自成立以来，一直以“IT+T（信息化+管理服务）”的创新服务模式戮力前行，专注于企业端的信息管理信息化系统建设，为客户提供大企业集团信息管理体系设计与搭建专业咨询、企业端信息管理系统定制化应用开发与系统集成、现有业务系统涉税改造IT咨询、信息管理系统部署实施、专业培训等一站式整体解决方案。</p>',0,99,'gongsijianjie','gsjj'),(28,26,'公司荣誉','/Static/images/banner1.jpg',-1,1,1,0,2,'','list_page.html','detail_page.html','','','','<figure class=\"image\"><img src=\"/Static/images/about.jpg\"></figure><p>公司创立于2008年12月，是国内**企业端信息管理系统整体解决方案供应商，具备深厚的专业咨询服务能力。<br><br>公司自成立以来，一直以“IT+T（信息化+管理服务）”的创新服务模式戮力前行，专注于企业端的信息管理信息化系统建设，为客户提供大企业集团信息管理体系设计与搭建专业咨询、企业端信息管理系统定制化应用开发与系统集成、现有业务系统涉税改造IT咨询、信息管理系统部署实施、专业培训等一站式整体解决方案。<br>公司创立于2008年12月，是国内**企业端信息管理系统整体解决方案供应商，具备深厚的专业咨询服务能力。<br><br>公司自成立以来，一直以“IT+T（信息化+管理服务）”的创新服务模式戮力前行，专注于企业端的信息管理信息化系统建设，为客户提供大企业集团信息管理体系设计与搭建专业咨询、企业端信息管理系统定制化应用开发与系统集成、现有业务系统涉税改造IT咨询、信息管理系统部署实施、专业培训等一站式整体解决方案。<br>公司创立于2008年12月，是国内**企业端信息管理系统整体解决方案供应商，具备深厚的专业咨询服务能力。<br><br>公司自成立以来，一直以“IT+T（信息化+管理服务）”的创新服务模式戮力前行，专注于企业端的信息管理信息化系统建设，为客户提供大企业集团信息管理体系设计与搭建专业咨询、企业端信息管理系统定制化应用开发与系统集成、现有业务系统涉税改造IT咨询、信息管理系统部署实施、专业培训等一站式整体解决方案。<br>公司创立于2008年12月，是国内**企业端信息管理系统整体解决方案供应商，具备深厚的专业咨询服务能力。<br><br>公司自成立以来，一直以“IT+T（信息化+管理服务）”的创新服务模式戮力前行，专注于企业端的信息管理信息化系统建设，为客户提供大企业集团信息管理体系设计与搭建专业咨询、企业端信息管理系统定制化应用开发与系统集成、现有业务系统涉税改造IT咨询、信息管理系统部署实施、专业培训等一站式整体解决方案。<br>公司创立于2008年12月，是国内**企业端信息管理系统整体解决方案供应商，具备深厚的专业咨询服务能力。<br><br>公司自成立以来，一直以“IT+T（信息化+管理服务）”的创新服务模式戮力前行，专注于企业端的信息管理信息化系统建设，为客户提供大企业集团信息管理体系设计与搭建专业咨询、企业端信息管理系统定制化应用开发与系统集成、现有业务系统涉税改造IT咨询、信息管理系统部署实施、专业培训等一站式整体解决方案。</p>',0,99,'gongsirongyu','gsry'),(29,26,'关于我们','/Static/images/banner1.jpg',-1,1,1,0,2,'','list_page.html','detail_page.html','','','','<figure class=\"image\"><img src=\"/Static/images/about.jpg\"></figure><p>公司创立于2008年12月，是国内**企业端信息管理系统整体解决方案供应商，具备深厚的专业咨询服务能力。<br><br>公司自成立以来，一直以“IT+T（信息化+管理服务）”的创新服务模式戮力前行，专注于企业端的信息管理信息化系统建设，为客户提供大企业集团信息管理体系设计与搭建专业咨询、企业端信息管理系统定制化应用开发与系统集成、现有业务系统涉税改造IT咨询、信息管理系统部署实施、专业培训等一站式整体解决方案。<br>公司创立于2008年12月，是国内**企业端信息管理系统整体解决方案供应商，具备深厚的专业咨询服务能力。<br><br>公司自成立以来，一直以“IT+T（信息化+管理服务）”的创新服务模式戮力前行，专注于企业端的信息管理信息化系统建设，为客户提供大企业集团信息管理体系设计与搭建专业咨询、企业端信息管理系统定制化应用开发与系统集成、现有业务系统涉税改造IT咨询、信息管理系统部署实施、专业培训等一站式整体解决方案。<br>公司创立于2008年12月，是国内**企业端信息管理系统整体解决方案供应商，具备深厚的专业咨询服务能力。<br><br>公司自成立以来，一直以“IT+T（信息化+管理服务）”的创新服务模式戮力前行，专注于企业端的信息管理信息化系统建设，为客户提供大企业集团信息管理体系设计与搭建专业咨询、企业端信息管理系统定制化应用开发与系统集成、现有业务系统涉税改造IT咨询、信息管理系统部署实施、专业培训等一站式整体解决方案。<br>公司创立于2008年12月，是国内**企业端信息管理系统整体解决方案供应商，具备深厚的专业咨询服务能力。<br><br>公司自成立以来，一直以“IT+T（信息化+管理服务）”的创新服务模式戮力前行，专注于企业端的信息管理信息化系统建设，为客户提供大企业集团信息管理体系设计与搭建专业咨询、企业端信息管理系统定制化应用开发与系统集成、现有业务系统涉税改造IT咨询、信息管理系统部署实施、专业培训等一站式整体解决方案。<br>公司创立于2008年12月，是国内**企业端信息管理系统整体解决方案供应商，具备深厚的专业咨询服务能力。<br><br>公司自成立以来，一直以“IT+T（信息化+管理服务）”的创新服务模式戮力前行，专注于企业端的信息管理信息化系统建设，为客户提供大企业集团信息管理体系设计与搭建专业咨询、企业端信息管理系统定制化应用开发与系统集成、现有业务系统涉税改造IT咨询、信息管理系统部署实施、专业培训等一站式整体解决方案。</p>',0,99,'guanyuwomen','gywm');

#
# Structure for table "qc_file"
#

DROP TABLE IF EXISTS `qc_file`;
CREATE TABLE `qc_file` (
  `FileId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` bigint(20) NOT NULL DEFAULT '0',
  `Name` varchar(100) NOT NULL DEFAULT '' COMMENT '上传文件名',
  `Img` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Size` int(11) NOT NULL DEFAULT '0',
  `Ext` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `Ts` int(11) NOT NULL DEFAULT '0',
  `FType` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '1系统2内容',
  `IndexId` bigint(20) NOT NULL DEFAULT '-1' COMMENT '内容ID -1未知',
  `RandKey` varchar(50) NOT NULL DEFAULT '' COMMENT '随机串',
  `IsDel` tinyint(3) NOT NULL DEFAULT '2',
  PRIMARY KEY (`FileId`)
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8;

#
# Data for table "qc_file"
#

INSERT INTO `qc_file` VALUES (100,1,'1400x0_1_q95_autohomecar__ChwFlGId4NaAIWbWAAagskVgolo474.jpg','/Static/upload/20220410/3556252e923c01503.jpg',237449,'jpg',1649600803,2,38,'',2),(101,1,'1400x0_1_q95_autohomecar__ChwFlGId4NaAZWOzAAoXI05bPWY061.jpg','/Static/upload/20220410/3356252e923c0c694.jpg',380104,'jpg',1649600803,2,38,'',2),(102,1,'1400x0_1_q95_autohomecar__ChwFlGId4NWACZ45AAc0aHrC-PE023.jpg','/Static/upload/20220410/6116252e923c16c85.jpg',292849,'jpg',1649600803,2,38,'',2),(103,1,'1400x0_1_q95_autohomecar__ChwFlGId4NWAGlSpAAZOKWwYlZ8464.jpg','/Static/upload/20220410/4626252e923c220c1.jpg',208300,'jpg',1649600803,2,38,'',2),(104,1,'1400x0_1_q95_autohomecar__ChwFlGIdlM2AYnfsAFnXyUGYcJw887.jpg','/Static/upload/20220410/4276252e923c2cc97.jpg',640640,'jpg',1649600803,2,38,'',2),(105,1,'1400x0_1_q95_autohomecar__ChwFlGIdlMmAIUacAF2-Y1NYxVs819.jpg','/Static/upload/20220410/6056252e923c38132.jpg',484900,'jpg',1649600803,2,38,'',2),(106,1,'1400x0_1_q95_autohomecar__ChwFlGIdlNKAVSS4AGAi9Y7NoSg877.jpg','/Static/upload/20220410/3026252e923c445a8.jpg',554539,'jpg',1649600803,2,38,'',2),(107,1,'1400x0_1_q95_autohomecar__ChxknGId4NaANEy3AAdCucFus20247.jpg','/Static/upload/20220410/8086252e923c508f2.jpg',292032,'jpg',1649600803,2,38,'',2),(108,1,'1400x0_1_q95_autohomecar__ChxknGId4NWACZaUAAmYhe92cMk312.jpg','/Static/upload/20220410/4736252e923c5d409.jpg',365361,'jpg',1649600803,2,38,'',2),(109,1,'1400x0_1_q95_autohomecar__ChxknGId4NWALtDgAAd5AssEwOk976.jpg','/Static/upload/20220410/2176252e923c6b343.jpg',306943,'jpg',1649600803,2,38,'',2),(110,1,'1400x0_1_q95_autohomecar__ChxknGIdlM-AZdWEAFyyA2CXCjY235.jpg','/Static/upload/20220410/4046252e923c820e9.jpg',522820,'jpg',1649600803,2,38,'',2),(111,1,'1400x0_1_q95_autohomecar__ChxknGIdlMuAAMfWAEHHdZQc03c148.jpg','/Static/upload/20220410/2386252e923c8bca6.jpg',441957,'jpg',1649600803,2,38,'',2),(112,1,'1400x0_1_q95_autohomecar__wKgH0Fi-0DGAJTxbAAL7AafFU0U354.jpg','/Static/upload/20220411/46162539082e15522.jpg',304074,'jpg',1649643650,2,68,'',2),(113,1,'1400x0_1_q95_autohomecar__wKgH1Vi-h_GANdOMAAIpfQIaXf0822.jpg','/Static/upload/20220411/34062539082e2d1f1.jpg',194388,'jpg',1649643650,2,68,'',2),(114,1,'1400x0_1_q95_autohomecar__wKgH1Vi-h-6AU5KMAAMO_GaNGvI291.jpg','/Static/upload/20220411/30562539082e37ad4.jpg',276731,'jpg',1649643650,2,68,'',2),(115,1,'1400x0_1_q95_autohomecar__wKgH1Vi-h-6AUGwLAALNpr-FjYU224.jpg','/Static/upload/20220411/30262539082e449b7.jpg',237811,'jpg',1649643650,2,68,'',2),(116,1,'1400x0_1_q95_autohomecar__wKgH5Fi-h_CAaCcGAAHAza_l0pw299.jpg','/Static/upload/20220411/55762539082e4fc35.jpg',174082,'jpg',1649643650,2,68,'',2),(117,1,'1400x0_1_q95_autohomecar__wKgH5Fi-h_CABZtVAAFRjIyJiiU358.jpg','/Static/upload/20220411/40762539082e58ee3.jpg',125395,'jpg',1649643650,2,68,'',2),(118,1,'1400x0_1_q95_autohomecar__wKgH5Fi-h-2AD_p7AAGEQ3_J-eM733.jpg','/Static/upload/20220411/69162539082e64889.jpg',147867,'jpg',1649643650,2,68,'',2),(119,1,'1400x0_1_q95_autohomecar__wKgH5Fi-h--AIcOQAAKc9-AdBx0878.jpg','/Static/upload/20220411/46962539082e6ea65.jpg',237198,'jpg',1649643650,2,68,'',2),(120,1,'1400x0_1_q95_autohomecar__wKjByVi-h_CAAIVYAAKagRMk7GI126.jpg','/Static/upload/20220411/35962539082e79b55.jpg',234436,'jpg',1649643651,2,68,'',2),(121,1,'1400x0_1_q95_autohomecar__wKjByVi-h--AQf5VAAIepqQwgt4966.jpg','/Static/upload/20220411/16062539083112c81.jpg',187349,'jpg',1649643651,2,68,'',2),(122,1,'1400x0_1_q95_autohomecar__wKjByVi-h--AXm-IAAFLDHgVinM240.jpg','/Static/upload/20220411/1146253908311d738.jpg',125891,'jpg',1649643651,2,68,'',2),(123,1,'1400x0_1_q95_autohomecar__wKjBzli-0DGAJ08jAANPaIaqr9c719.jpg','/Static/upload/20220411/97662539083127d51.jpg',322981,'jpg',1649643651,2,68,'',2),(124,1,'1400x0_1_q95_autohomecar__Chtk3WDUQl6AM36nAD2CHhdawRY627.jpg','/Static/upload/20220411/119625391de383408.jpg',701067,'jpg',1649643998,2,69,'',2),(125,1,'1400x0_1_q95_autohomecar__Chtk3WDUQmaAS_DxADl5QOIL4v8319.jpg','/Static/upload/20220411/606625391de39f172.jpg',648736,'jpg',1649643998,2,69,'',2),(126,1,'1400x0_1_q95_autohomecar__Chtk3WDUQmCAQlVtAC-WipL9r4s431.jpg','/Static/upload/20220411/700625391de3a9dc4.jpg',782299,'jpg',1649643998,2,69,'',2),(127,1,'1400x0_1_q95_autohomecar__Chtk3WDUQmGALHTkADAu2ehtZPI677.jpg','/Static/upload/20220411/925625391de3b4f33.jpg',784594,'jpg',1649643998,2,69,'',2),(128,1,'1400x0_1_q95_autohomecar__Chtk3WDUQmSAPySMAC4HiR1Gmp8386.jpg','/Static/upload/20220411/528625391de3c0b52.jpg',761599,'jpg',1649643998,2,69,'',2),(129,1,'1400x0_1_q95_autohomecar__Chtk3WDUQnGANeJuAD6Q7M4pJs0359.jpg','/Static/upload/20220411/453625391de3ccfc5.jpg',730327,'jpg',1649643998,2,69,'',2),(130,1,'1400x0_1_q95_autohomecar__ChwFjmDUQm2AKtDAADtKD7Xmg9E292.jpg','/Static/upload/20220411/495625391de3d98e2.jpg',675615,'jpg',1649643998,2,69,'',2),(131,1,'1400x0_1_q95_autohomecar__ChwFjmDUQm-AF-tUAD5E4x7H2u8802.jpg','/Static/upload/20220411/783625391de3e8245.jpg',697702,'jpg',1649643998,2,69,'',2),(132,1,'1400x0_1_q95_autohomecar__ChwFjmDUQmeAMJHeADrgQRNQah4931.jpg','/Static/upload/20220411/973625391de5acbb5.jpg',691347,'jpg',1649643998,2,69,'',2),(133,1,'1400x0_1_q95_autohomecar__ChwFjmDUQmOAQnqwAC12oZkauG4234.jpg','/Static/upload/20220411/824625391de5b9858.jpg',758557,'jpg',1649643998,2,69,'',2),(134,1,'1400x0_1_q95_autohomecar__ChwFjmDUQmqAXjI5ACzNLIe8ps0156.jpg','/Static/upload/20220411/543625391de5c59b5.jpg',772283,'jpg',1649643998,2,69,'',2),(135,1,'1400x0_1_q95_autohomecar__ChwFjmDUQmyAelvlADroJv08EqY093.jpg','/Static/upload/20220411/635625391de5d29e2.jpg',669167,'jpg',1649643998,2,69,'',2),(136,1,'1400x0_1_q95_autohomecar__ChsFWWH2AQ6ACFNBACgFcnSKDzE336.jpg','/Static/upload/20220411/3346253932eeda272.jpg',794048,'jpg',1649644334,2,70,'',2),(137,1,'1400x0_1_q95_autohomecar__ChsFWWH2AQyAIxKOACRPfro_plk841.jpg','/Static/upload/20220411/1376253932eee9428.jpg',765601,'jpg',1649644334,2,70,'',2),(138,1,'1400x0_1_q95_autohomecar__ChwFk2H2AQmAMqw-ACaMDKuzAM0558.jpg','/Static/upload/20220411/2176253932eef4f13.jpg',772894,'jpg',1649644334,2,70,'',2),(139,1,'1400x0_1_q95_autohomecar__ChwFk2H2AQuAftuUABe0xjJuf1s374.jpg','/Static/upload/20220411/1316253932ef015b4.jpg',473097,'jpg',1649644334,2,70,'',2),(140,1,'1400x0_1_q95_autohomecar__ChwFk2H2ARGAAplzACDx-JsLFpQ381.jpg','/Static/upload/20220411/7646253932ef0c9b4.jpg',685371,'jpg',1649644334,2,70,'',2),(141,1,'1400x0_1_q95_autohomecar__ChwFkmH2AQ2AHI4JADGy8xqGRgw141.jpg','/Static/upload/20220411/4256253932ef199c4.jpg',979727,'jpg',1649644334,2,70,'',2),(142,1,'1400x0_1_q95_autohomecar__ChwFkmH2ARCAHppTADWCK2stdS0352.jpg','/Static/upload/20220411/2566253932ef27f55.jpg',1051730,'jpg',1649644334,2,70,'',2),(143,1,'1400x0_1_q95_autohomecar__Chxkm2H2AQ-ANvA0ABfgV47kSt0885.jpg','/Static/upload/20220411/3516253932ef35b92.jpg',458113,'jpg',1649644334,2,70,'',2),(144,1,'1400x0_1_q95_autohomecar__Chxkm2H2ARGAc-UfACdsST_BQyI836.jpg','/Static/upload/20220411/9616253932f0012c6.jpg',811774,'jpg',1649644335,2,70,'',2),(145,1,'1400x0_1_q95_autohomecar__Chxkm2H2AROAOm2sABzjSOBoz7w285.jpg','/Static/upload/20220411/4446253932f00f4c5.jpg',576651,'jpg',1649644335,2,70,'',2),(146,1,'1400x0_1_q95_autohomecar__ChxkmmH2AQuAYsbKACHPyXFb4Hw142.jpg','/Static/upload/20220411/7366253932f01b0a5.jpg',702698,'jpg',1649644335,2,70,'',2),(147,1,'1400x0_1_q95_autohomecar__ChxkmmH2ARKAfcf-ACessbsNMxw671.jpg','/Static/upload/20220411/9536253932f026869.jpg',830806,'jpg',1649644335,2,70,'',2),(148,1,'1400x0_1_q95_autohomecar__ChsE4WAza_iATqINAB6W65W3nto470.jpg','/Static/upload/20220411/83462539412af1fd4.jpg',618712,'jpg',1649644562,2,71,'',2),(149,1,'1400x0_1_q95_autohomecar__ChsEfWAza_6AABByABLrZNTFCcg836.jpg','/Static/upload/20220411/68062539412b02452.jpg',384270,'jpg',1649644562,2,71,'',2),(150,1,'1400x0_1_q95_autohomecar__ChsEfWAza_-AKIf8ABYR_Oqa9Sg757.jpg','/Static/upload/20220411/79862539412b0d4d4.jpg',444027,'jpg',1649644562,2,71,'',2),(151,1,'1400x0_1_q95_autohomecar__ChsEfWAza_mAaSyUAB09Vc6D2cQ846.jpg','/Static/upload/20220411/89862539412b17377.jpg',600943,'jpg',1649644562,2,71,'',2),(152,1,'1400x0_1_q95_autohomecar__ChsEmmAza_yAIklhABCbf6vgtTk228.jpg','/Static/upload/20220411/73562539412b24827.jpg',340070,'jpg',1649644562,2,71,'',2),(153,1,'1400x0_1_q95_autohomecar__ChsEnmAza_yAOqNcABqru7nejEc957.jpg','/Static/upload/20220411/80862539412b42505.jpg',526970,'jpg',1649644562,2,71,'',2),(154,1,'1400x0_1_q95_autohomecar__ChsEnmAzbACAdUKbAB9eY33DoDw870.jpg','/Static/upload/20220411/47362539412b4e6d3.jpg',670917,'jpg',1649644562,2,71,'',2),(155,1,'1400x0_1_q95_autohomecar__ChwEoGAza_qABrDbACIaRFjm2gw169.jpg','/Static/upload/20220411/55762539412b5ca91.jpg',624540,'jpg',1649644562,2,71,'',2),(156,1,'1400x0_1_q95_autohomecar__ChwFkmAza_2AOP5mABSe9gEFASk034.jpg','/Static/upload/20220411/19262539412b6ab35.jpg',418695,'jpg',1649644562,2,71,'',2),(157,1,'1400x0_1_q95_autohomecar__ChwFkmAza_6AL_j4ABYEoQ2z7M4355.jpg','/Static/upload/20220411/83162539412b7a504.jpg',416495,'jpg',1649644562,2,71,'',2),(158,1,'1400x0_1_q95_autohomecar__ChwFkmAza_uAWeENAB63cN75Wuk230.jpg','/Static/upload/20220411/54962539412b85ee8.jpg',592242,'jpg',1649644562,2,71,'',2),(159,1,'1400x0_1_q95_autohomecar__ChwFkmAzbAGAGZ5FACD2akYtv2I281.jpg','/Static/upload/20220411/39162539412b91933.jpg',599386,'jpg',1649644562,2,71,'',2),(160,1,'1400x0_1_q95_autohomecar__ChsEf2BkibGAB5poACUfF_q5xU0132.jpg','/Static/upload/20220411/6166253963c50f731.jpg',599635,'jpg',1649645116,2,72,'',2),(161,1,'1400x0_1_q95_autohomecar__ChsEkGBkibCAM952ABarQSTgzvs336.jpg','/Static/upload/20220411/2106253963c525f06.jpg',410218,'jpg',1649645116,2,72,'',2),(162,1,'1400x0_1_q95_autohomecar__ChsEkGBkibiAQEObAB-6r58lnXk292.jpg','/Static/upload/20220411/3186253963c5309b6.jpg',540165,'jpg',1649645116,2,72,'',2),(163,1,'1400x0_1_q95_autohomecar__ChsEkGBkibKAXS6DACpxO7tVRKA166.jpg','/Static/upload/20220411/2686253963c53ba53.jpg',678457,'jpg',1649645116,2,72,'',2),(164,1,'1400x0_1_q95_autohomecar__ChsEkGBkibmAIzkHACZ7NnQ9Imw417.jpg','/Static/upload/20220411/9386253963c546d12.jpg',625581,'jpg',1649645116,2,72,'',2),(165,1,'1400x0_1_q95_autohomecar__ChwFkmBkibeAImudAB-cRBax9xE462.jpg','/Static/upload/20220411/6906253963c554b75.jpg',530981,'jpg',1649645116,2,72,'',2),(166,1,'1400x0_1_q95_autohomecar__ChwFkmBkibiAZXW-ACDSUC1WxPA631.jpg','/Static/upload/20220411/8826253963c560e44.jpg',550712,'jpg',1649645116,2,72,'',2),(167,1,'1400x0_1_q95_autohomecar__ChwFkmBkibuAEvzsACYJkyjTRwk516.jpg','/Static/upload/20220411/9196253963c5705d6.jpg',617242,'jpg',1649645116,2,72,'',2),(168,1,'1400x0_1_q95_autohomecar__ChwFlGBkibSAbloJACGQqpg8d6k702.jpg','/Static/upload/20220411/2536253963c57c767.jpg',583094,'jpg',1649645116,2,72,'',2),(169,1,'1400x0_1_q95_autohomecar__ChwFlGBkibSAPgaTAC1JVygvloU313.jpg','/Static/upload/20220411/3146253963c58c6a7.jpg',716132,'jpg',1649645116,2,72,'',2),(170,1,'1400x0_1_q95_autohomecar__ChwFqmBkibyAKyTCACI6Wn4j-Z8361.jpg','/Static/upload/20220411/5536253963c599338.jpg',596497,'jpg',1649645116,2,72,'',2),(171,1,'1400x0_1_q95_autohomecar__20100424085612781264.jpg','/Static/upload/20220411/9906253978d773974.jpg',125499,'jpg',1649645453,2,73,'',2),(172,1,'1400x0_1_q95_autohomecar__20100525084449936264.jpg','/Static/upload/20220411/8836253978d782c95.jpg',163816,'jpg',1649645453,2,73,'',2),(173,1,'1400x0_1_q95_autohomecar__20100525084451373264.jpg','/Static/upload/20220411/7916253978d78d362.jpg',146497,'jpg',1649645453,2,73,'',2),(174,1,'1400x0_1_q95_autohomecar__20100525084452998264.jpg','/Static/upload/20220411/2226253978d797574.jpg',185954,'jpg',1649645453,2,73,'',2),(175,1,'1400x0_1_q95_autohomecar__20100525084455123264.jpg','/Static/upload/20220411/2136253978d7a5f08.jpg',141314,'jpg',1649645453,2,73,'',2),(176,1,'1400x0_1_q95_autohomecar__20100525084456686264.jpg','/Static/upload/20220411/6306253978d7b2564.jpg',178369,'jpg',1649645453,2,73,'',2),(177,1,'1400x0_1_q95_autohomecar__20100525084458108264.jpg','/Static/upload/20220411/6726253978d7bf218.jpg',217461,'jpg',1649645453,2,73,'',2),(178,1,'1400x0_1_q95_autohomecar__20100525084500592264.jpg','/Static/upload/20220411/2546253978d7c8f82.jpg',190093,'jpg',1649645453,2,73,'',2),(179,1,'1400x0_1_q95_autohomecar__20100525084502217264.jpg','/Static/upload/20220411/9166253978d7d2297.jpg',202928,'jpg',1649645453,2,73,'',2),(180,1,'1400x0_1_q95_autohomecar__20100525084504233264.jpg','/Static/upload/20220411/1136253978d7da783.jpg',199420,'jpg',1649645453,2,73,'',2),(181,1,'1400x0_1_q95_autohomecar__20100525084507264264.jpg','/Static/upload/20220411/4726253978d7e5053.jpg',221674,'jpg',1649645453,2,73,'',2),(182,1,'1400x0_1_q95_autohomecar__20100525084509342264.jpg','/Static/upload/20220411/4596253978d7f0f98.jpg',179513,'jpg',1649645453,2,73,'',2),(183,1,'1400x0_1_q95_autohomecar__201201010859581814020.jpg','/Static/upload/20220411/1816253a206c204a8.jpg',182540,'jpg',1649648134,2,74,'',2),(184,1,'1400x0_1_q95_autohomecar__wKgH1FoOeFCAUebCAAO8qb8CQ-U579.jpg','/Static/upload/20220411/9576253a206c37c27.jpg',249100,'jpg',1649648134,2,74,'',2),(185,1,'1400x0_1_q95_autohomecar__wKgH1FoOeFeAc7F9AAbWDeylTvc510.jpg','/Static/upload/20220411/4666253a206c43ae2.jpg',468307,'jpg',1649648134,2,74,'',2),(186,1,'1400x0_1_q95_autohomecar__wKgH1FoOeFWARI0OAASs6hmV2CQ342.jpg','/Static/upload/20220411/2746253a206c503f4.jpg',343698,'jpg',1649648134,2,74,'',2),(187,1,'1400x0_1_q95_autohomecar__wKgHzFoOeFGAM9mqAASqrYjjmNM031.jpg','/Static/upload/20220411/9746253a206c598a4.jpg',326971,'jpg',1649648134,2,74,'',2),(188,1,'1400x0_1_q95_autohomecar__wKgHzFoOeFOAaOo6AAUA6epRd0A742.jpg','/Static/upload/20220411/4596253a206c64003.jpg',354473,'jpg',1649648134,2,74,'',2),(189,1,'1400x0_1_q95_autohomecar__wKgHzFoOeFqAGcqGAAW77k3tw2E822.jpg','/Static/upload/20220411/9566253a206c76be4.jpg',389055,'jpg',1649648134,2,74,'',2),(190,1,'1400x0_1_q95_autohomecar__wKgHzFoOeFuAXUJ7AAUQ-82lk04722.jpg','/Static/upload/20220411/2386253a206c82e27.jpg',376751,'jpg',1649648134,2,74,'',2),(191,1,'1400x0_1_q95_autohomecar__wKjB0loOeFSAYzboAATRie51-H0289.jpg','/Static/upload/20220411/1726253a206e7f799.jpg',343242,'jpg',1649648134,2,74,'',2),(192,1,'1400x0_1_q95_autohomecar__wKjB0loOeFyAZ1QAAAgqjViqHNo559.jpg','/Static/upload/20220411/2466253a206e89a56.jpg',554419,'jpg',1649648134,2,74,'',2),(193,1,'1400x0_1_q95_autohomecar__wKjByloOeFiATDzwAAjVJY_6e4g502.jpg','/Static/upload/20220411/5346253a206e93f62.jpg',583243,'jpg',1649648134,2,74,'',2),(194,1,'1400x0_1_q95_autohomecar__wKjByloOeFKAH0vLAAMpCf2VnJs051.jpg','/Static/upload/20220411/4296253a206e9e3e8.jpg',218513,'jpg',1649648134,2,74,'',2),(195,1,'1400x0_1_q95_autohomecar__ChcCQF0wIcmAECcrAAcLZk9MCFs081.jpg','/Static/upload/20220411/6466253e9342759f4.jpg',477718,'jpg',1649666356,2,75,'',2),(196,1,'1400x0_1_q95_autohomecar__ChcCR13XwDqAVBKMAAJNkjxKGwE302.jpg','/Static/upload/20220411/9916253e93429bec3.jpg',221817,'jpg',1649666356,2,75,'',2),(197,1,'1400x0_1_q95_autohomecar__ChcCR13XwDuAfk5wAAHFnbVd4nk151.jpg','/Static/upload/20220411/5796253e9342a6583.jpg',171783,'jpg',1649666356,2,75,'',2),(198,1,'1400x0_1_q95_autohomecar__ChcCSV0wIhKALOJTAAW2x-ecSaU382.jpg','/Static/upload/20220411/7806253e9342b15f5.jpg',391110,'jpg',1649666356,2,75,'',2),(199,1,'1400x0_1_q95_autohomecar__ChsEfV3XwDiAP0zdAAL5fxJ8s7U600.jpg','/Static/upload/20220411/9456253e9342c8184.jpg',275479,'jpg',1649666356,2,75,'',2),(200,1,'1400x0_1_q95_autohomecar__ChsEfV3XwDmAOidyAAJujbYNrdM112.jpg','/Static/upload/20220411/2156253e9342d1ba2.jpg',235098,'jpg',1649666356,2,75,'',2),(201,1,'1400x0_1_q95_autohomecar__ChsEj10wID6AGyvWAAZIuU5XYTE962.jpg','/Static/upload/20220411/9776253e9342dd855.jpg',452795,'jpg',1649666356,2,75,'',2),(202,1,'1400x0_1_q95_autohomecar__ChsEkV3XwDqAbGzOAAHWAy1bn2Q077.jpg','/Static/upload/20220411/7966253e9342e9a57.jpg',167971,'jpg',1649666356,2,75,'',2),(203,1,'1400x0_1_q95_autohomecar__ChsEm10wIIaADreDAAbb04ngppk714.jpg','/Static/upload/20220411/6106253e9342f73b1.jpg',493628,'jpg',1649666356,2,75,'',2),(204,1,'1400x0_1_q95_autohomecar__ChsEmV0wIWqAVly4AATZTqEaUhc635.jpg','/Static/upload/20220411/3546253e934301cd4.jpg',352216,'jpg',1649666356,2,75,'',2),(205,1,'1400x0_1_q95_autohomecar__ChsEnl0wINeAKCI2AAb1SqtMfYo867.jpg','/Static/upload/20220411/3796253e93430fe21.jpg',482464,'jpg',1649666356,2,75,'',2),(206,1,'1400x0_1_q95_autohomecar__ChsEoF0wISOAc1wpAAa9eyIpJts492.jpg','/Static/upload/20220411/7186253e93431b687.jpg',465043,'jpg',1649666356,2,75,'',2),(207,1,'1400x0_1_q95_autohomecar__ChcCL1rwJHWAV3RUAAm8vhV9jbs313.jpg','/Static/upload/20220411/4486253ea1ea64533.jpg',622803,'jpg',1649666590,2,76,'',2),(208,1,'1400x0_1_q95_autohomecar__ChcCr1rwJHOAEo-KAAqdMrGRU5c245.jpg','/Static/upload/20220411/4356253ea1ea7a0e3.jpg',645668,'jpg',1649666590,2,76,'',2),(209,1,'1400x0_1_q95_autohomecar__ChsEe1--IMuAbtEAAB1PL9wtvbc548.jpg','/Static/upload/20220411/5426253ea1ea87726.jpg',431085,'jpg',1649666590,2,76,'',2),(210,1,'1400x0_1_q95_autohomecar__ChsEe1--IMWAPafNABqwCj8BxEU145.jpg','/Static/upload/20220411/5746253ea1ea91154.jpg',477603,'jpg',1649666590,2,76,'',2),(211,1,'1400x0_1_q95_autohomecar__ChsEnF--IMaAczVLABotiRd3pLU886.jpg','/Static/upload/20220411/8436253ea1ea9fbc5.jpg',459522,'jpg',1649666590,2,76,'',2),(212,1,'1400x0_1_q95_autohomecar__ChwFkF--IMyAF5b8AB9Gdez8ZfM565.jpg','/Static/upload/20220411/7646253ea1eaab214.jpg',533568,'jpg',1649666590,2,76,'',2),(213,1,'1400x0_1_q95_autohomecar__ChwFkF--IMyAK98WAB0MyoRKLR8767.jpg','/Static/upload/20220411/5486253ea1eab69f6.jpg',515571,'jpg',1649666590,2,76,'',2),(214,1,'1400x0_1_q95_autohomecar__wKgHH1rwJHSASdTTAAx3BscdKGY383.jpg','/Static/upload/20220411/9556253ea1eac1d36.jpg',758271,'jpg',1649666590,2,76,'',2),(215,1,'1400x0_1_q95_autohomecar__wKgHIFrwJHWAcjUWAAqXcfuDrP8657.jpg','/Static/upload/20220411/8936253ea1eacf4b4.jpg',644618,'jpg',1649666590,2,76,'',2),(216,1,'1400x0_1_q95_autohomecar__wKgHIlrwJHaAK02EAAsUwWrTmXY510.jpg','/Static/upload/20220411/8396253ea1eaddb66.jpg',655693,'jpg',1649666590,2,76,'',2),(217,1,'1400x0_1_q95_autohomecar__wKgHIlrwJHKAcfUrAAsT2z5gt0k737.jpg','/Static/upload/20220411/5956253ea1eae9c52.jpg',651894,'jpg',1649666590,2,76,'',2),(218,1,'1400x0_1_q95_autohomecar__wKgHIlrwJHKARcIYAAmDJp3hzRI808.jpg','/Static/upload/20220411/4836253ea1eaf5ab3.jpg',615162,'jpg',1649666590,2,76,'',2),(219,1,'1400x0_1_q95_autohomecar__ChsEvmFN6vqALxVmAHI6RfCNkHo075.jpg','/Static/upload/20220411/3556253eb27ce9244.jpg',825142,'jpg',1649666855,2,77,'',2),(220,1,'1400x0_1_q95_autohomecar__ChsEvmFN6vWAX0uSAHxmdoN4i-U887.jpg','/Static/upload/20220411/9836253eb27d15985.jpg',925321,'jpg',1649666855,2,77,'',2),(221,1,'1400x0_1_q95_autohomecar__ChsF3WEsZOaAE09wABigrZwzp8Q197.jpg','/Static/upload/20220411/6376253eb27d22ed2.jpg',417910,'jpg',1649666855,2,77,'',2),(222,1,'1400x0_1_q95_autohomecar__ChsF3WEsZOSAF1SLABjbyE992TE557.jpg','/Static/upload/20220411/4876253eb27d32c94.jpg',415891,'jpg',1649666855,2,77,'',2),(223,1,'1400x0_1_q95_autohomecar__ChsF3WEsZOWARQFSABocY6HCKpQ116.jpg','/Static/upload/20220411/2556253eb27d517a3.jpg',429046,'jpg',1649666855,2,77,'',2),(224,1,'1400x0_1_q95_autohomecar__ChwEl2EsZOeAZaxCABjgYhsvoSY403.jpg','/Static/upload/20220411/2766253eb27d5d9d5.jpg',411750,'jpg',1649666855,2,77,'',2),(225,1,'1400x0_1_q95_autohomecar__ChwEmWFN6vKAT9C-AG5JZfdbbFs867.jpg','/Static/upload/20220411/9526253eb27d6a358.jpg',823851,'jpg',1649666855,2,77,'',2),(226,1,'1400x0_1_q95_autohomecar__ChwEmWFN6vSATDhyAH_-KkI6B8s621.jpg','/Static/upload/20220411/7966253eb27d785a4.jpg',888639,'jpg',1649666855,2,77,'',2),(227,1,'1400x0_1_q95_autohomecar__ChxkkGEsZOSADnjYABn8SfBI3ZA328.jpg','/Static/upload/20220411/4366253eb27d84ba1.jpg',446927,'jpg',1649666855,2,77,'',2),(228,1,'1400x0_1_q95_autohomecar__Chxks2FN6vCAIQAiAHaXNZIctkA709.jpg','/Static/upload/20220411/9866253eb27d8edb9.jpg',896853,'jpg',1649666855,2,77,'',2),(229,1,'1400x0_1_q95_autohomecar__Chxks2FN6veAUfDqAHLJPGZ07RE930.jpg','/Static/upload/20220411/9836253eb27d9bdb9.jpg',832387,'jpg',1649666855,2,77,'',2),(230,1,'1400x0_1_q95_autohomecar__Chxks2FN6vmABt65AHLFZdx7eOE494.jpg','/Static/upload/20220411/7976253eb27daa934.jpg',870868,'jpg',1649666855,2,77,'',2),(231,1,'1400x0_1_q95_autohomecar__ChsEe2A8S5CAcDBgACBEChyLNGI067.jpg','/Static/upload/20220411/4866253ecc9da9628.jpg',574042,'jpg',1649667273,2,78,'',2),(232,1,'1400x0_1_q95_autohomecar__ChsEe2A8S42AI8vXACAiDAsbac8796.jpg','/Static/upload/20220411/4786253ecc9dc6324.jpg',568946,'jpg',1649667273,2,78,'',2),(233,1,'1400x0_1_q95_autohomecar__ChsEe2A8S46AJ3s7ACDr2u8QiUM365.jpg','/Static/upload/20220411/1736253ecc9dd80d4.jpg',590545,'jpg',1649667273,2,78,'',2),(234,1,'1400x0_1_q95_autohomecar__ChsEfmA0b32AeaX8ACgv72TEG4w066.jpg','/Static/upload/20220411/2536253ecc9de49c8.jpg',480363,'jpg',1649667273,2,78,'',2),(235,1,'1400x0_1_q95_autohomecar__ChsEfmA0b36AcmLdACiQLuCewck834.jpg','/Static/upload/20220411/1636253ecc9defa66.jpg',499573,'jpg',1649667273,2,78,'',2),(236,1,'1400x0_1_q95_autohomecar__ChsEfWA8S42Ae87GAB6bqSo0FRQ238.jpg','/Static/upload/20220411/8686253ecc9dfafc3.jpg',526861,'jpg',1649667273,2,78,'',2),(237,1,'1400x0_1_q95_autohomecar__ChwFk2A0b3-AdwYMACnU96iiLy4628.jpg','/Static/upload/20220411/1616253ecc9e06668.jpg',475368,'jpg',1649667273,2,78,'',2),(238,1,'1400x0_1_q95_autohomecar__ChwFkGA8S4-AfgylABumk8Vtw6A825.jpg','/Static/upload/20220411/7226253ecc9e14269.jpg',513444,'jpg',1649667273,2,78,'',2),(239,1,'1400x0_1_q95_autohomecar__ChwFkGA8S5GAJKa1AB5l9Lmx5Io768.jpg','/Static/upload/20220411/2826253ecc9e1f4f2.jpg',552865,'jpg',1649667273,2,78,'',2),(240,1,'1400x0_1_q95_autohomecar__ChwFqmA0b3uAbjQfACjvl7piHeU478.jpg','/Static/upload/20220411/1356253ecc9e2ce98.jpg',483758,'jpg',1649667273,2,78,'',2),(241,1,'1400x0_1_q95_autohomecar__ChwFqmA0b3yAEhe6ACvb7nk2qvo659.jpg','/Static/upload/20220411/9106253ecc9e386d8.jpg',507287,'jpg',1649667273,2,78,'',2),(242,1,'1400x0_1_q95_autohomecar__ChwFqWA8S5CACIZnAB-SjW-5Hl4746.jpg','/Static/upload/20220411/1356253ecc9e43f67.jpg',564182,'jpg',1649667273,2,78,'',2);

#
# Structure for table "qc_form_form1"
#

DROP TABLE IF EXISTS `qc_form_form1`;
CREATE TABLE `qc_form_form1` (
  `FormListId` bigint(20) NOT NULL AUTO_INCREMENT,
  `FormId` int(11) NOT NULL DEFAULT '0',
  `UserId` bigint(20) NOT NULL DEFAULT '0',
  `State` tinyint(3) NOT NULL DEFAULT '2',
  `TsAdd` bigint(20) NOT NULL DEFAULT '0',
  `Name` varchar(255) NOT NULL DEFAULT '' COMMENT '名字',
  `Phone` varchar(255) NOT NULL DEFAULT '' COMMENT '电话',
  `Message` text NOT NULL COMMENT '留言',
  PRIMARY KEY (`FormListId`)
) ENGINE=InnoDB AUTO_INCREMENT=10009 DEFAULT CHARSET=utf8;

#
# Data for table "qc_form_form1"
#

INSERT INTO `qc_form_form1` VALUES (10000,11,0,1,1648111577,'老钱','15618323440',''),(10001,11,0,1,1648111581,'老钱','15618323440',''),(10003,11,0,1,1648112214,'777','888',''),(10005,11,0,1,1648885068,'111','222',''),(10006,11,0,1,1648889813,'yyy99','15699',''),(10007,11,0,1,1649752204,'ddd','fff','ddd'),(10008,11,0,1,1649762816,'laoqian','15618323440','123456');

#
# Structure for table "qc_group_admin"
#

DROP TABLE IF EXISTS `qc_group_admin`;
CREATE TABLE `qc_group_admin` (
  `GroupAdminId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL DEFAULT '',
  `Permission` text NOT NULL COMMENT '权限',
  `IsSys` tinyint(3) NOT NULL DEFAULT '2',
  PRIMARY KEY (`GroupAdminId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

#
# Data for table "qc_group_admin"
#

INSERT INTO `qc_group_admin` VALUES (1,'超级管理员','',1),(2,'频道管理员','/admin/index.html|/admin/sys/license.html|/admin/admin/index.html|/admin/admin/edit.html|/admin/groupAdmin/index.html|/admin/category/index.html|/admin/category/del.html|/admin/category/move.html|/admin/content/view.html|/admin/user/edit.html|/admin/data/highReplace.html|/admin/other.html',1),(3,'信息发布员','admin/sys|admin/sys/index|admin/sys/license|admin/sys/check|admin/admin/index|admin/admin/add|admin/admin/edit|admin/admin/del|admin/groupAdmin/index|admin/groupAdmin/add|admin/groupAdmin/edit|admin/groupAdmin/del|admin/log/operate|admin/log/login|admin/site/index|admin/site/add|admin/site/edit|admin/site/del|admin/category|admin/category/index|admin/category/add|admin/category/edit|admin/page/del|admin/labelCate/index|admin/content|admin/content/recovery|admin/content/view|admin/content/restore|admin/content/tDelete|admin/content/index?ModelId=1|admin/content/add?ModelId=1|admin/content/edit?ModelId=1|admin/content/del?ModelId=3|admin/index/index',1),(7,'ggg','/admin/index.html|/admin/category/index.html|/admin/content/view.html|/admin/user/edit.html',2),(10,'空数据测试','/admin/index.html|/admin/sys/index.html|/admin/sys/check.html|/admin/admin/add.html|/admin/groupAdmin/index.html|/admin/groupAdmin/edit.html',2),(11,'有数据测试','/admin/index.html|/admin/index/qrCode.html|/admin/admin/add.html|/admin/groupAdmin/index.html|/admin/groupAdmin/edit.html',2),(12,'111','',2);

#
# Structure for table "qc_group_user"
#

DROP TABLE IF EXISTS `qc_group_user`;
CREATE TABLE `qc_group_user` (
  `GroupUserId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL DEFAULT '',
  `IsSys` tinyint(3) NOT NULL DEFAULT '2',
  PRIMARY KEY (`GroupUserId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Data for table "qc_group_user"
#

INSERT INTO `qc_group_user` VALUES (1,'注册会员',1),(2,'中级会员',1),(3,'高级会员',1),(4,'新建会员组',2);

#
# Structure for table "qc_inlink"
#

DROP TABLE IF EXISTS `qc_inlink`;
CREATE TABLE `qc_inlink` (
  `InlinkId` int(11) NOT NULL AUTO_INCREMENT,
  `InlinkCateId` int(11) NOT NULL DEFAULT '0',
  `Name` varchar(100) NOT NULL DEFAULT '',
  `IsBlank` tinyint(3) NOT NULL DEFAULT '2' COMMENT '打开新窗口',
  `Url` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `State` tinyint(3) NOT NULL DEFAULT '0',
  `Sort` int(11) NOT NULL DEFAULT '99',
  PRIMARY KEY (`InlinkId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "qc_inlink"
#


#
# Structure for table "qc_inlink_cate"
#

DROP TABLE IF EXISTS `qc_inlink_cate`;
CREATE TABLE `qc_inlink_cate` (
  `InlinkCateId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL DEFAULT '',
  `Sort` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`InlinkCateId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "qc_inlink_cate"
#

INSERT INTO `qc_inlink_cate` VALUES (1,'系统默认',99);

#
# Structure for table "qc_label"
#

DROP TABLE IF EXISTS `qc_label`;
CREATE TABLE `qc_label` (
  `LabelId` int(11) NOT NULL AUTO_INCREMENT,
  `LabelCateId` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL DEFAULT '',
  `KeyName` varchar(50) NOT NULL DEFAULT '',
  `Content` text NOT NULL,
  `State` tinyint(3) NOT NULL DEFAULT '1',
  `Sort` int(11) NOT NULL DEFAULT '99',
  `IsEditor` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否加载编辑器',
  PRIMARY KEY (`LabelId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "qc_label"
#

INSERT INTO `qc_label` VALUES (1,1,'标签测试','ltexst','<p>12<strong>345</strong>55</p><p>sdsdfs</p>',2,98,2),(4,1,'ere','eee','<p>ertert</p>',2,99,2),(5,2,'yyy','yyy','',2,100,2);

#
# Structure for table "qc_label_cate"
#

DROP TABLE IF EXISTS `qc_label_cate`;
CREATE TABLE `qc_label_cate` (
  `LabelCateId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL DEFAULT '',
  `Sort` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`LabelCateId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "qc_label_cate"
#

INSERT INTO `qc_label_cate` VALUES (1,'默认分类',98),(2,'分类2',99);

#
# Structure for table "qc_link"
#

DROP TABLE IF EXISTS `qc_link`;
CREATE TABLE `qc_link` (
  `LinkId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL DEFAULT '',
  `Logo` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `Link` varchar(255) NOT NULL DEFAULT '',
  `Sort` int(11) NOT NULL DEFAULT '99',
  `Info` varchar(255) DEFAULT NULL,
  `Mail` varchar(50) NOT NULL DEFAULT '' COMMENT '站长邮箱',
  `IsIndex` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否首页',
  `State` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `LinkCateId` int(11) NOT NULL,
  `TsAdd` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`LinkId`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

#
# Data for table "qc_link"
#

INSERT INTO `qc_link` VALUES (1,'百度搜索','','http://www.baidu.com/',99,'','222@qq.zz',1,1,1,1647845903),(2,'苹果中国','','https://www.apple.com.cn/',99,'','',1,1,1,1648908850),(3,'小米官网','','https://www.mi.com/',99,'','',1,1,1,1649749207),(4,'微软中国','','https://www.microsoft.com/',99,'','',1,1,1,1649749256),(5,'华为官网','','https://www.huawei.com/',99,'','',1,1,1,1649749309),(6,'英特尔官网','','https://www.intel.cn/',99,'','',1,1,1,1649749381),(7,'西部数据','','https://www.westerndigital.com/',99,'','',1,1,1,1649749420),(8,'Lenovo联想','','https://www.lenovo.com.cn/',99,'','',1,1,1,1649749473),(9,'DELL官网','','https://www.dell.com/',99,'','',1,1,1,1649749506),(10,'Logitech罗技','','https://www.logitech.com.cn/',99,'','',1,1,1,1649749567),(11,'ASUS 中国','','https://www.asus.com.cn/',99,'','',1,1,1,1649749701),(12,'Sony 索尼','','https://www.sony.com.cn/',99,'','',1,1,1,1649749778),(13,'三星电子','','https://www.samsung.com/',99,'','',1,1,1,1649749807);

#
# Structure for table "qc_link_cate"
#

DROP TABLE IF EXISTS `qc_link_cate`;
CREATE TABLE `qc_link_cate` (
  `LinkCateId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL DEFAULT '',
  `Sort` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`LinkCateId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "qc_link_cate"
#

INSERT INTO `qc_link_cate` VALUES (1,'默认分类',99);

#
# Structure for table "qc_log_login"
#

DROP TABLE IF EXISTS `qc_log_login`;
CREATE TABLE `qc_log_login` (
  `LogLoginId` bigint(20) NOT NULL AUTO_INCREMENT,
  `UserId` bigint(20) NOT NULL,
  `Ua` varchar(255) NOT NULL DEFAULT '',
  `Ts` bigint(20) NOT NULL DEFAULT '0',
  `Ip` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`LogLoginId`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

#
# Data for table "qc_log_login"
#

INSERT INTO `qc_log_login` VALUES (1,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',1647324652,'127.0.0.1'),(2,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',1647324668,'127.0.0.1'),(3,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',1647324698,'127.0.0.1'),(4,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',1647324787,'127.0.0.1'),(5,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',1647324814,'127.0.0.1'),(6,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',1647324817,'127.0.0.1'),(7,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',1647326253,'127.0.0.1'),(8,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',1647326287,'127.0.0.1'),(9,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',1647326361,'127.0.0.1'),(10,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',1647326488,'127.0.0.1'),(11,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',1647326656,'127.0.0.1'),(12,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',1647414917,'127.0.0.1'),(13,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',1647840840,'127.0.0.1'),(14,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',1647840859,'127.0.0.1'),(15,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36',1648279429,'127.0.0.1'),(16,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36',1648800813,'127.0.0.1'),(17,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36',1648801078,'127.0.0.1'),(18,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36',1648801232,'127.0.0.1'),(19,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36',1649052429,'127.0.0.1'),(20,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36',1649052446,'127.0.0.1'),(21,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36',1649053857,'127.0.0.1'),(22,2,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36',1649056364,'127.0.0.1'),(23,2,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36',1649056825,'127.0.0.1'),(24,2,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36',1649056845,'127.0.0.1'),(25,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36',1649126917,'127.0.0.1'),(26,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.82 Safari/537.36',1649132298,'127.0.0.1'),(27,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.75 Safari/537.36',1649318634,'127.0.0.1'),(28,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.75 Safari/537.36',1649471891,'127.0.0.1'),(29,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.75 Safari/537.36',1649471991,'127.0.0.1'),(30,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.75 Safari/537.36',1649471992,'127.0.0.1'),(31,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.75 Safari/537.36',1649820118,'127.0.0.1');

#
# Structure for table "qc_log_operate"
#

DROP TABLE IF EXISTS `qc_log_operate`;
CREATE TABLE `qc_log_operate` (
  `LogOperateId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` bigint(20) NOT NULL DEFAULT '0',
  `Url` varchar(255) NOT NULL DEFAULT '',
  `Method` varchar(10) NOT NULL DEFAULT '',
  `Query` varchar(255) DEFAULT '',
  `Ip` varchar(16) NOT NULL DEFAULT '',
  `Ts` bigint(20) NOT NULL DEFAULT '0',
  `vv` decimal(10,2) DEFAULT '0.00',
  `ff` text NOT NULL,
  PRIMARY KEY (`LogOperateId`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

#
# Data for table "qc_log_operate"
#

INSERT INTO `qc_log_operate` VALUES (1,1,'admin/sys/index.html','GET','','127.0.0.1',1647432204,0.00,''),(2,1,'admin/admin/index.html','GET','','127.0.0.1',1647432205,0.00,''),(3,1,'admin/groupAdmin/index.html','GET','','127.0.0.1',1647432205,0.00,''),(4,1,'admin/admin/index.html','GET','','127.0.0.1',1647432217,0.00,''),(5,1,'admin/admin/edit.html','GET','UserId=2','127.0.0.1',1647432219,0.00,''),(6,1,'admin/admin/edit.html','GET','UserId=2','127.0.0.1',1647432593,0.00,''),(7,1,'admin/log/operate.html','GET','','127.0.0.1',1647432603,0.00,''),(8,1,'admin/log/operate.html','GET','','127.0.0.1',1647432640,0.00,''),(9,1,'admin/log/operate.html','GET','','127.0.0.1',1647432645,0.00,''),(10,1,'admin/log/operate.html','GET','','127.0.0.1',1647432740,0.00,''),(11,1,'admin/log/operate.html','GET','','127.0.0.1',1647432749,0.00,''),(12,1,'admin/log/login.html','GET','','127.0.0.1',1647432806,0.00,''),(13,1,'admin/log/login.html','GET','','127.0.0.1',1647432845,0.00,''),(14,1,'admin/log/login.html','GET','','127.0.0.1',1647432855,0.00,''),(15,1,'admin/log/login.html','GET','','127.0.0.1',1647432901,0.00,''),(16,1,'admin/log/login.html','GET','','127.0.0.1',1647432913,0.00,''),(17,1,'admin/log/login.html','GET','','127.0.0.1',1647432931,0.00,''),(18,1,'admin/log/login.html','GET','','127.0.0.1',1647432933,0.00,''),(19,1,'admin/log/login.html','GET','','127.0.0.1',1647432980,0.00,''),(20,1,'admin/log/operate.html','GET','','127.0.0.1',1647433695,0.00,''),(21,1,'admin/log/operate.html','GET','','127.0.0.1',1647433711,0.00,''),(22,1,'admin/log/login.html','GET','','127.0.0.1',1647433712,0.00,''),(23,1,'admin/log/operate.html','GET','','127.0.0.1',1647433716,0.00,''),(24,1,'admin/log/operate.html','GET','P=2','127.0.0.1',1647433718,0.00,''),(25,1,'admin/sys/index.html','GET','','127.0.0.1',1647433721,0.00,''),(26,1,'admin/sys/index.html','POST','','127.0.0.1',1647433724,0.00,'');

#
# Structure for table "qc_page"
#

DROP TABLE IF EXISTS `qc_page`;
CREATE TABLE `qc_page` (
  `PageId` int(11) NOT NULL AUTO_INCREMENT,
  `PageCateId` int(11) NOT NULL DEFAULT '0',
  `Name` varchar(50) NOT NULL DEFAULT '',
  `TempDetail` varchar(255) NOT NULL DEFAULT '',
  `SeoTitle` varchar(255) NOT NULL DEFAULT '',
  `Keywords` varchar(255) NOT NULL DEFAULT '',
  `Description` varchar(255) NOT NULL DEFAULT '',
  `Content` text NOT NULL COMMENT '栏目内容',
  `Sort` int(11) NOT NULL DEFAULT '99',
  `State` tinyint(3) NOT NULL DEFAULT '1',
  `PinYin` varchar(255) NOT NULL DEFAULT '',
  `PY` varchar(50) NOT NULL DEFAULT '',
  `Pic` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`PageId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Data for table "qc_page"
#

INSERT INTO `qc_page` VALUES (1,1,'单页测试','page_default.html','1','2','3','<p>单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试</p><p>单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试</p><p>&nbsp;</p><p>单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试</p><p>&nbsp;</p><p>单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试</p><p>单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试单页测试</p>',98,1,'danyeceshi','dycs','/Static/images/banner1.jpg');

#
# Structure for table "qc_page_cate"
#

DROP TABLE IF EXISTS `qc_page_cate`;
CREATE TABLE `qc_page_cate` (
  `PageCateId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL DEFAULT '',
  `Sort` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`PageCateId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "qc_page_cate"
#

INSERT INTO `qc_page_cate` VALUES (1,'默认分类',101),(2,'测试分类',99);

#
# Structure for table "qc_photos"
#

DROP TABLE IF EXISTS `qc_photos`;
CREATE TABLE `qc_photos` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Photos` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

#
# Data for table "qc_photos"
#

INSERT INTO `qc_photos` VALUES (38,'[{\"Name\":\"1400x0_1_q95_autohomecar__ChwFlGId4NaAIWbWAAagskVgolo474.jpg\",\"Path\":\"\\/Static\\/upload\\/20220410\\/3556252e923c01503.jpg\",\"Size\":237449},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFlGId4NaAZWOzAAoXI05bPWY061.jpg\",\"Path\":\"\\/Static\\/upload\\/20220410\\/3356252e923c0c694.jpg\",\"Size\":380104},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFlGId4NWACZ45AAc0aHrC-PE023.jpg\",\"Path\":\"\\/Static\\/upload\\/20220410\\/6116252e923c16c85.jpg\",\"Size\":292849},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFlGId4NWAGlSpAAZOKWwYlZ8464.jpg\",\"Path\":\"\\/Static\\/upload\\/20220410\\/4626252e923c220c1.jpg\",\"Size\":208300},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFlGIdlM2AYnfsAFnXyUGYcJw887.jpg\",\"Path\":\"\\/Static\\/upload\\/20220410\\/4276252e923c2cc97.jpg\",\"Size\":640640},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFlGIdlMmAIUacAF2-Y1NYxVs819.jpg\",\"Path\":\"\\/Static\\/upload\\/20220410\\/6056252e923c38132.jpg\",\"Size\":484900},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFlGIdlNKAVSS4AGAi9Y7NoSg877.jpg\",\"Path\":\"\\/Static\\/upload\\/20220410\\/3026252e923c445a8.jpg\",\"Size\":554539},{\"Name\":\"1400x0_1_q95_autohomecar__ChxknGId4NaANEy3AAdCucFus20247.jpg\",\"Path\":\"\\/Static\\/upload\\/20220410\\/8086252e923c508f2.jpg\",\"Size\":292032},{\"Name\":\"1400x0_1_q95_autohomecar__ChxknGId4NWACZaUAAmYhe92cMk312.jpg\",\"Path\":\"\\/Static\\/upload\\/20220410\\/4736252e923c5d409.jpg\",\"Size\":365361},{\"Name\":\"1400x0_1_q95_autohomecar__ChxknGId4NWALtDgAAd5AssEwOk976.jpg\",\"Path\":\"\\/Static\\/upload\\/20220410\\/2176252e923c6b343.jpg\",\"Size\":306943},{\"Name\":\"1400x0_1_q95_autohomecar__ChxknGIdlM-AZdWEAFyyA2CXCjY235.jpg\",\"Path\":\"\\/Static\\/upload\\/20220410\\/4046252e923c820e9.jpg\",\"Size\":522820},{\"Name\":\"1400x0_1_q95_autohomecar__ChxknGIdlMuAAMfWAEHHdZQc03c148.jpg\",\"Path\":\"\\/Static\\/upload\\/20220410\\/2386252e923c8bca6.jpg\",\"Size\":441957}]'),(68,'[{\"Name\":\"1400x0_1_q95_autohomecar__wKgH0Fi-0DGAJTxbAAL7AafFU0U354.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/46162539082e15522.jpg\",\"Size\":304074},{\"Name\":\"1400x0_1_q95_autohomecar__wKgH1Vi-h_GANdOMAAIpfQIaXf0822.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/34062539082e2d1f1.jpg\",\"Size\":194388},{\"Name\":\"1400x0_1_q95_autohomecar__wKgH1Vi-h-6AU5KMAAMO_GaNGvI291.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/30562539082e37ad4.jpg\",\"Size\":276731},{\"Name\":\"1400x0_1_q95_autohomecar__wKgH1Vi-h-6AUGwLAALNpr-FjYU224.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/30262539082e449b7.jpg\",\"Size\":237811},{\"Name\":\"1400x0_1_q95_autohomecar__wKgH5Fi-h_CAaCcGAAHAza_l0pw299.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/55762539082e4fc35.jpg\",\"Size\":174082},{\"Name\":\"1400x0_1_q95_autohomecar__wKgH5Fi-h_CABZtVAAFRjIyJiiU358.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/40762539082e58ee3.jpg\",\"Size\":125395},{\"Name\":\"1400x0_1_q95_autohomecar__wKgH5Fi-h-2AD_p7AAGEQ3_J-eM733.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/69162539082e64889.jpg\",\"Size\":147867},{\"Name\":\"1400x0_1_q95_autohomecar__wKgH5Fi-h--AIcOQAAKc9-AdBx0878.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/46962539082e6ea65.jpg\",\"Size\":237198},{\"Name\":\"1400x0_1_q95_autohomecar__wKjByVi-h_CAAIVYAAKagRMk7GI126.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/35962539082e79b55.jpg\",\"Size\":234436},{\"Name\":\"1400x0_1_q95_autohomecar__wKjByVi-h--AQf5VAAIepqQwgt4966.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/16062539083112c81.jpg\",\"Size\":187349},{\"Name\":\"1400x0_1_q95_autohomecar__wKjByVi-h--AXm-IAAFLDHgVinM240.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/1146253908311d738.jpg\",\"Size\":125891},{\"Name\":\"1400x0_1_q95_autohomecar__wKjBzli-0DGAJ08jAANPaIaqr9c719.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/97662539083127d51.jpg\",\"Size\":322981}]'),(69,'[{\"Name\":\"1400x0_1_q95_autohomecar__Chtk3WDUQl6AM36nAD2CHhdawRY627.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/119625391de383408.jpg\",\"Size\":701067},{\"Name\":\"1400x0_1_q95_autohomecar__Chtk3WDUQmaAS_DxADl5QOIL4v8319.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/606625391de39f172.jpg\",\"Size\":648736},{\"Name\":\"1400x0_1_q95_autohomecar__Chtk3WDUQmCAQlVtAC-WipL9r4s431.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/700625391de3a9dc4.jpg\",\"Size\":782299},{\"Name\":\"1400x0_1_q95_autohomecar__Chtk3WDUQmGALHTkADAu2ehtZPI677.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/925625391de3b4f33.jpg\",\"Size\":784594},{\"Name\":\"1400x0_1_q95_autohomecar__Chtk3WDUQmSAPySMAC4HiR1Gmp8386.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/528625391de3c0b52.jpg\",\"Size\":761599},{\"Name\":\"1400x0_1_q95_autohomecar__Chtk3WDUQnGANeJuAD6Q7M4pJs0359.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/453625391de3ccfc5.jpg\",\"Size\":730327},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFjmDUQm2AKtDAADtKD7Xmg9E292.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/495625391de3d98e2.jpg\",\"Size\":675615},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFjmDUQm-AF-tUAD5E4x7H2u8802.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/783625391de3e8245.jpg\",\"Size\":697702},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFjmDUQmeAMJHeADrgQRNQah4931.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/973625391de5acbb5.jpg\",\"Size\":691347},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFjmDUQmOAQnqwAC12oZkauG4234.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/824625391de5b9858.jpg\",\"Size\":758557},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFjmDUQmqAXjI5ACzNLIe8ps0156.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/543625391de5c59b5.jpg\",\"Size\":772283},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFjmDUQmyAelvlADroJv08EqY093.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/635625391de5d29e2.jpg\",\"Size\":669167}]'),(70,'[{\"Name\":\"1400x0_1_q95_autohomecar__ChsFWWH2AQ6ACFNBACgFcnSKDzE336.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/3346253932eeda272.jpg\",\"Size\":794048},{\"Name\":\"1400x0_1_q95_autohomecar__ChsFWWH2AQyAIxKOACRPfro_plk841.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/1376253932eee9428.jpg\",\"Size\":765601},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFk2H2AQmAMqw-ACaMDKuzAM0558.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2176253932eef4f13.jpg\",\"Size\":772894},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFk2H2AQuAftuUABe0xjJuf1s374.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/1316253932ef015b4.jpg\",\"Size\":473097},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFk2H2ARGAAplzACDx-JsLFpQ381.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/7646253932ef0c9b4.jpg\",\"Size\":685371},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFkmH2AQ2AHI4JADGy8xqGRgw141.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/4256253932ef199c4.jpg\",\"Size\":979727},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFkmH2ARCAHppTADWCK2stdS0352.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2566253932ef27f55.jpg\",\"Size\":1051730},{\"Name\":\"1400x0_1_q95_autohomecar__Chxkm2H2AQ-ANvA0ABfgV47kSt0885.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/3516253932ef35b92.jpg\",\"Size\":458113},{\"Name\":\"1400x0_1_q95_autohomecar__Chxkm2H2ARGAc-UfACdsST_BQyI836.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9616253932f0012c6.jpg\",\"Size\":811774},{\"Name\":\"1400x0_1_q95_autohomecar__Chxkm2H2AROAOm2sABzjSOBoz7w285.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/4446253932f00f4c5.jpg\",\"Size\":576651},{\"Name\":\"1400x0_1_q95_autohomecar__ChxkmmH2AQuAYsbKACHPyXFb4Hw142.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/7366253932f01b0a5.jpg\",\"Size\":702698},{\"Name\":\"1400x0_1_q95_autohomecar__ChxkmmH2ARKAfcf-ACessbsNMxw671.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9536253932f026869.jpg\",\"Size\":830806}]'),(71,'[{\"Name\":\"1400x0_1_q95_autohomecar__ChsE4WAza_iATqINAB6W65W3nto470.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/83462539412af1fd4.jpg\",\"Size\":618712},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEfWAza_6AABByABLrZNTFCcg836.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/68062539412b02452.jpg\",\"Size\":384270},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEfWAza_-AKIf8ABYR_Oqa9Sg757.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/79862539412b0d4d4.jpg\",\"Size\":444027},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEfWAza_mAaSyUAB09Vc6D2cQ846.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/89862539412b17377.jpg\",\"Size\":600943},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEmmAza_yAIklhABCbf6vgtTk228.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/73562539412b24827.jpg\",\"Size\":340070},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEnmAza_yAOqNcABqru7nejEc957.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/80862539412b42505.jpg\",\"Size\":526970},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEnmAzbACAdUKbAB9eY33DoDw870.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/47362539412b4e6d3.jpg\",\"Size\":670917},{\"Name\":\"1400x0_1_q95_autohomecar__ChwEoGAza_qABrDbACIaRFjm2gw169.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/55762539412b5ca91.jpg\",\"Size\":624540},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFkmAza_2AOP5mABSe9gEFASk034.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/19262539412b6ab35.jpg\",\"Size\":418695},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFkmAza_6AL_j4ABYEoQ2z7M4355.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/83162539412b7a504.jpg\",\"Size\":416495},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFkmAza_uAWeENAB63cN75Wuk230.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/54962539412b85ee8.jpg\",\"Size\":592242},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFkmAzbAGAGZ5FACD2akYtv2I281.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/39162539412b91933.jpg\",\"Size\":599386}]'),(72,'[{\"Name\":\"1400x0_1_q95_autohomecar__ChsEf2BkibGAB5poACUfF_q5xU0132.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/6166253963c50f731.jpg\",\"Size\":599635},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEkGBkibCAM952ABarQSTgzvs336.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2106253963c525f06.jpg\",\"Size\":410218},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEkGBkibiAQEObAB-6r58lnXk292.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/3186253963c5309b6.jpg\",\"Size\":540165},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEkGBkibKAXS6DACpxO7tVRKA166.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2686253963c53ba53.jpg\",\"Size\":678457},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEkGBkibmAIzkHACZ7NnQ9Imw417.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9386253963c546d12.jpg\",\"Size\":625581},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFkmBkibeAImudAB-cRBax9xE462.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/6906253963c554b75.jpg\",\"Size\":530981},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFkmBkibiAZXW-ACDSUC1WxPA631.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/8826253963c560e44.jpg\",\"Size\":550712},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFkmBkibuAEvzsACYJkyjTRwk516.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9196253963c5705d6.jpg\",\"Size\":617242},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFlGBkibSAbloJACGQqpg8d6k702.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2536253963c57c767.jpg\",\"Size\":583094},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFlGBkibSAPgaTAC1JVygvloU313.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/3146253963c58c6a7.jpg\",\"Size\":716132},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFqmBkibyAKyTCACI6Wn4j-Z8361.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/5536253963c599338.jpg\",\"Size\":596497}]'),(73,'[{\"Name\":\"1400x0_1_q95_autohomecar__20100424085612781264.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9906253978d773974.jpg\",\"Size\":125499},{\"Name\":\"1400x0_1_q95_autohomecar__20100525084449936264.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/8836253978d782c95.jpg\",\"Size\":163816},{\"Name\":\"1400x0_1_q95_autohomecar__20100525084451373264.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/7916253978d78d362.jpg\",\"Size\":146497},{\"Name\":\"1400x0_1_q95_autohomecar__20100525084452998264.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2226253978d797574.jpg\",\"Size\":185954},{\"Name\":\"1400x0_1_q95_autohomecar__20100525084455123264.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2136253978d7a5f08.jpg\",\"Size\":141314},{\"Name\":\"1400x0_1_q95_autohomecar__20100525084456686264.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/6306253978d7b2564.jpg\",\"Size\":178369},{\"Name\":\"1400x0_1_q95_autohomecar__20100525084458108264.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/6726253978d7bf218.jpg\",\"Size\":217461},{\"Name\":\"1400x0_1_q95_autohomecar__20100525084500592264.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2546253978d7c8f82.jpg\",\"Size\":190093},{\"Name\":\"1400x0_1_q95_autohomecar__20100525084502217264.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9166253978d7d2297.jpg\",\"Size\":202928},{\"Name\":\"1400x0_1_q95_autohomecar__20100525084504233264.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/1136253978d7da783.jpg\",\"Size\":199420},{\"Name\":\"1400x0_1_q95_autohomecar__20100525084507264264.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/4726253978d7e5053.jpg\",\"Size\":221674},{\"Name\":\"1400x0_1_q95_autohomecar__20100525084509342264.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/4596253978d7f0f98.jpg\",\"Size\":179513}]'),(74,'[{\"Name\":\"1400x0_1_q95_autohomecar__wKgH1FoOeFeAc7F9AAbWDeylTvc510.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/4666253a206c43ae2.jpg\",\"Size\":468307},{\"Name\":\"1400x0_1_q95_autohomecar__wKgH1FoOeFWARI0OAASs6hmV2CQ342.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2746253a206c503f4.jpg\",\"Size\":343698},{\"Name\":\"1400x0_1_q95_autohomecar__wKgHzFoOeFGAM9mqAASqrYjjmNM031.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9746253a206c598a4.jpg\",\"Size\":326971},{\"Name\":\"1400x0_1_q95_autohomecar__wKgHzFoOeFOAaOo6AAUA6epRd0A742.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/4596253a206c64003.jpg\",\"Size\":354473},{\"Name\":\"1400x0_1_q95_autohomecar__wKgHzFoOeFqAGcqGAAW77k3tw2E822.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9566253a206c76be4.jpg\",\"Size\":389055},{\"Name\":\"1400x0_1_q95_autohomecar__wKgHzFoOeFuAXUJ7AAUQ-82lk04722.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2386253a206c82e27.jpg\",\"Size\":376751},{\"Name\":\"1400x0_1_q95_autohomecar__wKjB0loOeFSAYzboAATRie51-H0289.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/1726253a206e7f799.jpg\",\"Size\":343242},{\"Name\":\"1400x0_1_q95_autohomecar__wKjB0loOeFyAZ1QAAAgqjViqHNo559.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2466253a206e89a56.jpg\",\"Size\":554419},{\"Name\":\"1400x0_1_q95_autohomecar__wKjByloOeFiATDzwAAjVJY_6e4g502.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/5346253a206e93f62.jpg\",\"Size\":583243},{\"Name\":\"1400x0_1_q95_autohomecar__wKjByloOeFKAH0vLAAMpCf2VnJs051.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/4296253a206e9e3e8.jpg\",\"Size\":218513},{\"Name\":\"1400x0_1_q95_autohomecar__wKgH1FoOeFCAUebCAAO8qb8CQ-U579.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9576253a206c37c27.jpg\",\"Size\":249100},{\"Name\":\"1400x0_1_q95_autohomecar__201201010859581814020.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/1816253a206c204a8.jpg\",\"Size\":182540}]'),(75,'[{\"Name\":\"1400x0_1_q95_autohomecar__ChcCQF0wIcmAECcrAAcLZk9MCFs081.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/6466253e9342759f4.jpg\",\"Size\":477718},{\"Name\":\"1400x0_1_q95_autohomecar__ChcCR13XwDqAVBKMAAJNkjxKGwE302.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9916253e93429bec3.jpg\",\"Size\":221817},{\"Name\":\"1400x0_1_q95_autohomecar__ChcCR13XwDuAfk5wAAHFnbVd4nk151.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/5796253e9342a6583.jpg\",\"Size\":171783},{\"Name\":\"1400x0_1_q95_autohomecar__ChcCSV0wIhKALOJTAAW2x-ecSaU382.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/7806253e9342b15f5.jpg\",\"Size\":391110},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEfV3XwDiAP0zdAAL5fxJ8s7U600.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9456253e9342c8184.jpg\",\"Size\":275479},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEfV3XwDmAOidyAAJujbYNrdM112.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2156253e9342d1ba2.jpg\",\"Size\":235098},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEj10wID6AGyvWAAZIuU5XYTE962.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9776253e9342dd855.jpg\",\"Size\":452795},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEkV3XwDqAbGzOAAHWAy1bn2Q077.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/7966253e9342e9a57.jpg\",\"Size\":167971},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEm10wIIaADreDAAbb04ngppk714.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/6106253e9342f73b1.jpg\",\"Size\":493628},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEmV0wIWqAVly4AATZTqEaUhc635.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/3546253e934301cd4.jpg\",\"Size\":352216},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEnl0wINeAKCI2AAb1SqtMfYo867.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/3796253e93430fe21.jpg\",\"Size\":482464},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEoF0wISOAc1wpAAa9eyIpJts492.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/7186253e93431b687.jpg\",\"Size\":465043}]'),(76,'[{\"Name\":\"1400x0_1_q95_autohomecar__ChcCL1rwJHWAV3RUAAm8vhV9jbs313.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/4486253ea1ea64533.jpg\",\"Size\":622803},{\"Name\":\"1400x0_1_q95_autohomecar__ChcCr1rwJHOAEo-KAAqdMrGRU5c245.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/4356253ea1ea7a0e3.jpg\",\"Size\":645668},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEe1--IMuAbtEAAB1PL9wtvbc548.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/5426253ea1ea87726.jpg\",\"Size\":431085},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEe1--IMWAPafNABqwCj8BxEU145.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/5746253ea1ea91154.jpg\",\"Size\":477603},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEnF--IMaAczVLABotiRd3pLU886.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/8436253ea1ea9fbc5.jpg\",\"Size\":459522},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFkF--IMyAF5b8AB9Gdez8ZfM565.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/7646253ea1eaab214.jpg\",\"Size\":533568},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFkF--IMyAK98WAB0MyoRKLR8767.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/5486253ea1eab69f6.jpg\",\"Size\":515571},{\"Name\":\"1400x0_1_q95_autohomecar__wKgHH1rwJHSASdTTAAx3BscdKGY383.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9556253ea1eac1d36.jpg\",\"Size\":758271},{\"Name\":\"1400x0_1_q95_autohomecar__wKgHIFrwJHWAcjUWAAqXcfuDrP8657.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/8936253ea1eacf4b4.jpg\",\"Size\":644618},{\"Name\":\"1400x0_1_q95_autohomecar__wKgHIlrwJHaAK02EAAsUwWrTmXY510.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/8396253ea1eaddb66.jpg\",\"Size\":655693},{\"Name\":\"1400x0_1_q95_autohomecar__wKgHIlrwJHKAcfUrAAsT2z5gt0k737.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/5956253ea1eae9c52.jpg\",\"Size\":651894},{\"Name\":\"1400x0_1_q95_autohomecar__wKgHIlrwJHKARcIYAAmDJp3hzRI808.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/4836253ea1eaf5ab3.jpg\",\"Size\":615162}]'),(77,'[{\"Name\":\"1400x0_1_q95_autohomecar__ChsEvmFN6vqALxVmAHI6RfCNkHo075.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/3556253eb27ce9244.jpg\",\"Size\":825142},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEvmFN6vWAX0uSAHxmdoN4i-U887.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9836253eb27d15985.jpg\",\"Size\":925321},{\"Name\":\"1400x0_1_q95_autohomecar__ChsF3WEsZOaAE09wABigrZwzp8Q197.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/6376253eb27d22ed2.jpg\",\"Size\":417910},{\"Name\":\"1400x0_1_q95_autohomecar__ChsF3WEsZOSAF1SLABjbyE992TE557.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/4876253eb27d32c94.jpg\",\"Size\":415891},{\"Name\":\"1400x0_1_q95_autohomecar__ChsF3WEsZOWARQFSABocY6HCKpQ116.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2556253eb27d517a3.jpg\",\"Size\":429046},{\"Name\":\"1400x0_1_q95_autohomecar__ChwEl2EsZOeAZaxCABjgYhsvoSY403.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2766253eb27d5d9d5.jpg\",\"Size\":411750},{\"Name\":\"1400x0_1_q95_autohomecar__ChwEmWFN6vKAT9C-AG5JZfdbbFs867.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9526253eb27d6a358.jpg\",\"Size\":823851},{\"Name\":\"1400x0_1_q95_autohomecar__ChwEmWFN6vSATDhyAH_-KkI6B8s621.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/7966253eb27d785a4.jpg\",\"Size\":888639},{\"Name\":\"1400x0_1_q95_autohomecar__ChxkkGEsZOSADnjYABn8SfBI3ZA328.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/4366253eb27d84ba1.jpg\",\"Size\":446927},{\"Name\":\"1400x0_1_q95_autohomecar__Chxks2FN6vCAIQAiAHaXNZIctkA709.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9866253eb27d8edb9.jpg\",\"Size\":896853},{\"Name\":\"1400x0_1_q95_autohomecar__Chxks2FN6veAUfDqAHLJPGZ07RE930.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9836253eb27d9bdb9.jpg\",\"Size\":832387},{\"Name\":\"1400x0_1_q95_autohomecar__Chxks2FN6vmABt65AHLFZdx7eOE494.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/7976253eb27daa934.jpg\",\"Size\":870868}]'),(78,'[{\"Name\":\"1400x0_1_q95_autohomecar__ChsEe2A8S5CAcDBgACBEChyLNGI067.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/4866253ecc9da9628.jpg\",\"Size\":574042},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEe2A8S42AI8vXACAiDAsbac8796.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/4786253ecc9dc6324.jpg\",\"Size\":568946},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEe2A8S46AJ3s7ACDr2u8QiUM365.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/1736253ecc9dd80d4.jpg\",\"Size\":590545},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEfmA0b32AeaX8ACgv72TEG4w066.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2536253ecc9de49c8.jpg\",\"Size\":480363},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEfmA0b36AcmLdACiQLuCewck834.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/1636253ecc9defa66.jpg\",\"Size\":499573},{\"Name\":\"1400x0_1_q95_autohomecar__ChsEfWA8S42Ae87GAB6bqSo0FRQ238.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/8686253ecc9dfafc3.jpg\",\"Size\":526861},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFk2A0b3-AdwYMACnU96iiLy4628.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/1616253ecc9e06668.jpg\",\"Size\":475368},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFkGA8S4-AfgylABumk8Vtw6A825.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/7226253ecc9e14269.jpg\",\"Size\":513444},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFkGA8S5GAJKa1AB5l9Lmx5Io768.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/2826253ecc9e1f4f2.jpg\",\"Size\":552865},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFqmA0b3uAbjQfACjvl7piHeU478.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/1356253ecc9e2ce98.jpg\",\"Size\":483758},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFqmA0b3yAEhe6ACvb7nk2qvo659.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/9106253ecc9e386d8.jpg\",\"Size\":507287},{\"Name\":\"1400x0_1_q95_autohomecar__ChwFqWA8S5CACIZnAB-SjW-5Hl4746.jpg\",\"Path\":\"\\/Static\\/upload\\/20220411\\/1356253ecc9e43f67.jpg\",\"Size\":564182}]');

#
# Structure for table "qc_site"
#

DROP TABLE IF EXISTS `qc_site`;
CREATE TABLE `qc_site` (
  `SiteId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL DEFAULT '',
  `WebSite` varchar(255) NOT NULL DEFAULT '' COMMENT '网址',
  `Secret` varchar(255) NOT NULL DEFAULT '',
  `Sort` int(11) NOT NULL DEFAULT '99',
  `Ts` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`SiteId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Data for table "qc_site"
#

INSERT INTO `qc_site` VALUES (4,'ddd','http://q6.demo.com/','123456',101,1649132258);

#
# Structure for table "qc_stat_flow"
#

DROP TABLE IF EXISTS `qc_stat_flow`;
CREATE TABLE `qc_stat_flow` (
  `Date` date NOT NULL DEFAULT '0000-00-00',
  `FlowNum` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "qc_stat_flow"
#

INSERT INTO `qc_stat_flow` VALUES ('2022-04-01',8),('2022-04-02',29),('2022-04-03',2),('2022-04-04',2),('2022-04-07',198),('2022-04-08',397),('2022-04-09',324),('2022-04-10',278),('2022-04-11',179),('2022-04-12',376),('2022-04-13',2);

#
# Structure for table "qc_swiper"
#

DROP TABLE IF EXISTS `qc_swiper`;
CREATE TABLE `qc_swiper` (
  `SwiperId` int(11) NOT NULL AUTO_INCREMENT,
  `SwiperCateId` int(11) NOT NULL DEFAULT '0',
  `Pic` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `Title` varchar(100) NOT NULL DEFAULT '',
  `Link` varchar(255) NOT NULL DEFAULT '',
  `Sort` int(11) NOT NULL DEFAULT '99',
  PRIMARY KEY (`SwiperId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Data for table "qc_swiper"
#

INSERT INTO `qc_swiper` VALUES (3,1,'/Static/images/banner1.jpg','Banner1','#',99),(4,1,'/Static/images/banner2.jpg','Banner2','#',99),(5,1,'/Static/images/banner3.jpg','Banner3','#',99),(6,1,'/Static/images/banner4.jpg','Banner4','#',99);

#
# Structure for table "qc_swiper_cate"
#

DROP TABLE IF EXISTS `qc_swiper_cate`;
CREATE TABLE `qc_swiper_cate` (
  `SwiperCateId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(10) NOT NULL DEFAULT '',
  `Code` text NOT NULL,
  `Sort` int(11) NOT NULL DEFAULT '99',
  PRIMARY KEY (`SwiperCateId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "qc_swiper_cate"
#

INSERT INTO `qc_swiper_cate` VALUES (1,'网站首页轮播','',99);

#
# Structure for table "qc_sys"
#

DROP TABLE IF EXISTS `qc_sys`;
CREATE TABLE `qc_sys` (
  `Name` varchar(50) NOT NULL DEFAULT '' COMMENT '属性名',
  `Info` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `AttrValue` text NOT NULL COMMENT '内容',
  `GroupId` tinyint(3) NOT NULL DEFAULT '0' COMMENT '字段组',
  `AttrType` varchar(10) NOT NULL DEFAULT 'input' COMMENT '类型',
  `Sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `IsSys` tinyint(3) NOT NULL DEFAULT '2',
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "qc_sys"
#

INSERT INTO `qc_sys` VALUES ('AllowAdminSpace','允许访问管理员空间','1',9,'radio',2006,1),('AllowReg','是否允许注册','1',9,'radio',2001,1),('AllowUploadType','允许上传类型','jpg|jpeg|gif|png|webp|bmp|svg',3,'input',3000,1),('AuditMode','会员注册自动审核','1',9,'radio',2008,1),('CdnHost','Cdn地址','http://www.baidu.com/',3,'input',3013,1),('CdnIsOpen','是否开启CDN','2',3,'radio',3012,1),('Copyright','版权信息','©CopyRight 2002-2022 Q-cms.Cn, All Rights Reserved。',1,'textarea',1009,1),('Description','SEO简介','QCMS网站管理系统',1,'input',1008,1),('Editor','富文本编辑器','ckeditor',2,'select',2011,1),('Email','站长邮箱','admin@admin.com',1,'input',1004,1),('Icp','备案号','沪ICP备08080808号',1,'input',1005,1),('ImgViewType','图片浏览类型','jpg|gif|png',3,'input',3001,1),('IsOpenInLink','是否开启内链','2',2,'radio',2001,1),('Keywords','SEO关键字','QCMS网站管理系统',1,'input',1007,1),('License','授权码','mWhFTP9QxmpzlcKREk9qXx9k36z03q1wnKWjeXa1jzjlnjAOf3bbLtlde+YLrmWw4PkH7RL2vj3pZ1IaJ/5dh7XEP8eCa4lHUj18hDhGS6vaxUCdGz9wvZlLf7P3X2lL7JFup8EDwmtElkMN2hIb++Wskp57ZvFYndJweRbr7FQA4raAMkPIsf1oJaNYaHf7VXamH7gOIT3r3zyB68hFBldodrsMA9sY1H+KYtdVEPDoIpgQei59OyPeax5tpKVKTh319lK2MB4AdBNf3KZYPvzOHcaJeNe4zz8uCmahynL5rGOkBOHzxeACJiE1dp6Cx/DGd9QsyyuE3fUzqHVeTA==',9,'input',9002,1),('Logo','网站Logo','/Static/images/logo.svg',1,'upload',1001,1),('MultistationIsOpen','开启站点管理','1',4,'radio',4001,1),('NotAllowReg','不允许注册名','www,bbs,ftp,mail,user,users,admin,administrator,qcms',9,'input',2005,1),('OpenLog','开启日志','2',2,'radio',2014,1),('OpenRecycle','开启回收站','1',9,'radio',2013,1),('OpenRegDetails','注册需要完成详细资料','2',9,'radio',2002,1),('RegLenMax','注册最大长度','',9,'input',2004,1),('RegLenMin','注册最小长度','',9,'input',2003,1),('Secret','站点秘钥(用于多站点管理和接口API)','123456',4,'input',4002,1),('StatsCode','统计代码','<script type=\"text/javascript\">document.write(unescape(\"%3Cspan id=\'cnzz_stat_icon_1281045441\'%3E%3C/span%3E%3Cscript src=\'https://v1.cnzz.com/stat.php%3Fid%3D1281045441%26show%3Dpic\' type=\'text/javascript\'%3E%3C/script%3E\"));</script>',2,'textarea',2012,1),('ThumbSize','允许缩略图尺寸(240x180|360x120)','240x180',3,'input',3003,1),('TmpIndex','首页模板','index_main.html',1,'select',1002,1),('TmpPath','模板路径','default',2,'select',2010,1),('TmpSearch','搜索页模板','search_default.html',1,'select',1003,1),('UrlDetail','详情地址命名规则','{Id}.html',2,'input',2061,1),('UrlList','分类地址命名规则','list_{CateId}.html',2,'input',2060,1),('UrlPage','单页地址命名规则','page_{PageId}.html',2,'input',2062,1),('Version','版本号','6.0.0',9,'input',9001,1),('WaBeian','网安备案号','',1,'input',1006,1),('WaterMaskFontColor','水印文字颜色','0,0,0',3,'input',3009,1),('WaterMaskFontOpacity','水印透明度','50',3,'input',3010,1),('WaterMaskFontSize','水印文字大小','20',3,'input',3008,1),('WaterMaskIsOpen','是否开启水印','2',3,'radio',3004,1),('WaterMaskPic','水印图片','',3,'upload',3006,1),('WaterMaskPostion','水印位置','5',3,'select',3011,1),('WaterMaskTxt','水印文字','www.q-cms.cn',3,'input',3007,1),('WaterMaskType','水印图片类型','2',3,'radio',3005,1),('WebName','网站名字','QCMS网站管理系统',1,'input',1000,1),('WebOpen','开启网站','1',1,'radio',1010,1);

#
# Structure for table "qc_sys_attr"
#

DROP TABLE IF EXISTS `qc_sys_attr`;
CREATE TABLE `qc_sys_attr` (
  `Key` varchar(10) NOT NULL DEFAULT '',
  `Name` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`Key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "qc_sys_attr"
#

INSERT INTO `qc_sys_attr` VALUES ('n1','特推'),('n2','头条'),('n3','推荐'),('n4','幻灯'),('n5','滚动'),('n6','加粗'),('n7','图片'),('n8','跳转');

#
# Structure for table "qc_sys_form"
#

DROP TABLE IF EXISTS `qc_sys_form`;
CREATE TABLE `qc_sys_form` (
  `FormId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL DEFAULT '',
  `KeyName` varchar(50) NOT NULL DEFAULT '' COMMENT '调用名',
  `TempDetail` varchar(255) NOT NULL DEFAULT '' COMMENT '模板',
  `IsLogin` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否需要登陆',
  `StateDefault` tinyint(2) NOT NULL DEFAULT '0' COMMENT '默认状态',
  `FieldJson` text NOT NULL,
  `Sort` int(11) NOT NULL DEFAULT '99',
  `State` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`FormId`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

#
# Data for table "qc_sys_form"
#

INSERT INTO `qc_sys_form` VALUES (11,'测试表单','form1','form_default.html',2,1,'[{\"Name\":\"Name\",\"Comment\":\"\\u540d\\u5b57\",\"Type\":\"input\",\"Content\":\"\",\"NotNull\":\"1\",\"Data\":\"\"},{\"Name\":\"Phone\",\"Comment\":\"\\u7535\\u8bdd\",\"Type\":\"input\",\"Content\":\"\",\"NotNull\":\"1\",\"Data\":\"\"},{\"Name\":\"Message\",\"Comment\":\"\\u7559\\u8a00\",\"Type\":\"textarea\",\"Content\":\"\",\"NotNull\":\"1\",\"Data\":\"\"}]',99,1);

#
# Structure for table "qc_sys_model"
#

DROP TABLE IF EXISTS `qc_sys_model`;
CREATE TABLE `qc_sys_model` (
  `ModelId` int(11) NOT NULL AUTO_INCREMENT,
  `KeyName` varchar(50) NOT NULL DEFAULT '' COMMENT '名字标识',
  `Name` varchar(50) NOT NULL DEFAULT '',
  `IsSys` tinyint(3) NOT NULL DEFAULT '2',
  `FieldJson` text NOT NULL,
  PRIMARY KEY (`ModelId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

#
# Data for table "qc_sys_model"
#

INSERT INTO `qc_sys_model` VALUES (1,'article','文章',1,''),(2,'product','产品',1,'[{\"Name\":\"factory\",\"Comment\":\"\\u5382\\u5546\",\"Type\":\"input\",\"Content\":\"\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"level\",\"Comment\":\"\\u7ea7\\u522b\",\"Type\":\"input\",\"Content\":\"\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"energy\",\"Comment\":\"\\u80fd\\u6e90\\u7c7b\\u578b\",\"Type\":\"input\",\"Content\":\"\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"environment\",\"Comment\":\"\\u73af\\u4fdd\\u6807\\u51c6\",\"Type\":\"input\",\"Content\":\"\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"marketTime\",\"Comment\":\"\\u4e0a\\u5e02\\u65f6\\u95f4\",\"Type\":\"date\",\"Content\":\"\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"maxpower\",\"Comment\":\"\\u6700\\u5927\\u529f\\u7387(kW)\",\"Type\":\"input\",\"Content\":\"\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"maxtorque\",\"Comment\":\"\\u6700\\u5927\\u626d\\u77e9(N\\u00b7m)\",\"Type\":\"input\",\"Content\":\"\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"engine\",\"Comment\":\"\\u53d1\\u52a8\\u673a\",\"Type\":\"input\",\"Content\":\"\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"transmission\",\"Comment\":\"\\u53d8\\u901f\\u7bb1\",\"Type\":\"input\",\"Content\":\"\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"size\",\"Comment\":\"\\u957f*\\u5bbd*\\u9ad8(mm)\",\"Type\":\"input\",\"Content\":\"\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"Price\",\"Comment\":\"\\u4ef7\\u683c\",\"Type\":\"money\",\"Content\":\"\",\"NotNull\":\"1\",\"IsList\":\"1\",\"Data\":\"\"}]'),(3,'album','相册',1,''),(4,'down','下载',1,'[{\"Name\":\"Size\",\"Comment\":\"\\u8f6f\\u4ef6\\u5927\\u5c0f\",\"Type\":\"input\",\"Content\":\"\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"Lang\",\"Comment\":\"\\u8f6f\\u4ef6\\u8bed\\u8a00\",\"Type\":\"input\",\"Content\":\"\\u7b80\\u4f53\\u4e2d\\u6587\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"Level\",\"Comment\":\"\\u8f6f\\u4ef6\\u8bc4\\u7ea7\",\"Type\":\"input\",\"Content\":\"5\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"Company\",\"Comment\":\"\\u8f6f\\u4ef6\\u5382\\u5546\",\"Type\":\"input\",\"Content\":\"\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"Auth\",\"Comment\":\"\\u8f6f\\u4ef6\\u6388\\u6743\",\"Type\":\"input\",\"Content\":\"\\u514d\\u8d39\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"Platform\",\"Comment\":\"\\u5e94\\u7528\\u5e73\\u53f0\",\"Type\":\"input\",\"Content\":\"windows\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"WebSite\",\"Comment\":\"\\u5b98\\u65b9\\u7f51\\u7ad9\",\"Type\":\"input\",\"Content\":\"\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"},{\"Name\":\"Address\",\"Comment\":\"\\u4e0b\\u8f7d\\u5730\\u5740\",\"Type\":\"input\",\"Content\":\"\",\"NotNull\":\"1\",\"IsList\":\"2\",\"Data\":\"\"}]');

#
# Structure for table "qc_table"
#

DROP TABLE IF EXISTS `qc_table`;
CREATE TABLE `qc_table` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ModelId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;

#
# Data for table "qc_table"
#

INSERT INTO `qc_table` VALUES (38,3),(43,4),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,2),(56,2),(57,2),(58,2),(59,2),(60,2),(61,2),(62,2),(63,2),(64,2),(65,2),(66,2),(67,2),(68,3),(69,3),(70,3),(71,3),(72,3),(73,3),(74,3),(75,3),(76,3),(77,3),(78,3),(79,4),(80,4),(81,4),(82,4),(83,4),(84,4),(85,4),(86,4),(87,4),(88,4),(89,4);

#
# Structure for table "qc_table_album"
#

DROP TABLE IF EXISTS `qc_table_album`;
CREATE TABLE `qc_table_album` (
  `Id` bigint(20) NOT NULL DEFAULT '0',
  `ModelId` int(11) NOT NULL DEFAULT '0',
  `CateId` int(11) NOT NULL DEFAULT '0',
  `Title` varchar(100) NOT NULL DEFAULT '',
  `STitle` varchar(60) NOT NULL DEFAULT '' COMMENT '短标题',
  `Tag` varchar(100) NOT NULL DEFAULT '' COMMENT 'Tag',
  `Pic` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `Source` varchar(50) NOT NULL DEFAULT '' COMMENT '来源',
  `Author` varchar(50) NOT NULL DEFAULT '' COMMENT '作者',
  `Sort` tinyint(3) NOT NULL DEFAULT '99',
  `Keywords` varchar(255) NOT NULL DEFAULT '',
  `Description` varchar(255) NOT NULL DEFAULT '',
  `TsAdd` bigint(20) NOT NULL DEFAULT '0',
  `TsUpdate` bigint(20) NOT NULL DEFAULT '0',
  `ReadNum` int(11) NOT NULL DEFAULT '0',
  `Coins` int(11) NOT NULL DEFAULT '0' COMMENT '需消费金币',
  `Money` int(11) NOT NULL DEFAULT '0' COMMENT '支付费用',
  `UserLevel` int(11) NOT NULL DEFAULT '0' COMMENT '浏览权限',
  `Color` varchar(10) NOT NULL DEFAULT '' COMMENT '颜色',
  `UserId` bigint(20) NOT NULL DEFAULT '0',
  `Good` int(11) NOT NULL DEFAULT '0',
  `Bad` int(11) NOT NULL DEFAULT '0',
  `State` tinyint(3) NOT NULL DEFAULT '1',
  `Content` text,
  `IsLink` tinyint(3) NOT NULL DEFAULT '2',
  `LinkUrl` varchar(255) NOT NULL DEFAULT '' COMMENT '外链地址',
  `IsBold` tinyint(3) NOT NULL DEFAULT '2',
  `IsPic` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否有缩略图',
  `IsSpuerRec` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否特推',
  `IsHeadlines` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否头条',
  `IsRec` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否推荐',
  `IsPost` tinyint(3) NOT NULL DEFAULT '1' COMMENT '允许评论',
  `IsDelete` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否删除',
  `PinYin` varchar(255) NOT NULL DEFAULT '',
  `PY` varchar(255) NOT NULL DEFAULT '',
  `Summary` varchar(255) DEFAULT '' COMMENT '摘要',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "qc_table_album"
#

INSERT INTO `qc_table_album` VALUES (38,0,16,'宝马X5  xDrive 40Li 尊享型M运动套装','','','/Static/upload/20220410/3556252e923c01503.jpg','','',99,'','',1649167983,1649167977,0,0,0,0,'',1,0,0,1,'<p>宝马X5 &nbsp;xDrive 40Li 尊享型M运动套装</p>',2,'',2,1,2,2,2,1,2,'baomax5xdrive40lizunxiangxingmyundongtaozhuang','bmx5xdrive40lizxxmydtz',''),(68,0,16,'梅赛德斯-AMG GT Concept','','','/Static/upload/20220411/55762539082e4fc35.jpg','','',99,'','',1649643635,1649643622,0,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'meisaidesiamggtconcept','msdsamggtconcept',''),(69,0,16,'迈凯伦 Artura  2021款 澳大利亚版','','','/Static/upload/20220411/453625391de3ccfc5.jpg','','',99,'','',1649643983,1649643971,0,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'maikailunartura2021kuanaodaliyaban','mklartura2021kadlyb',''),(70,0,16,'保时捷911  2021款 GT3 澳大利亚版','','','/Static/upload/20220411/3346253932eeda272.jpg','','',99,'','',1649644320,1649644315,3,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'baoshijie9112021kuangt3aodaliyaban','bsj9112021kgt3adlyb',''),(71,0,16,'玛莎拉蒂 总裁  2021款 3.0T S Q4 豪华版','','','/Static/upload/20220411/19262539412b6ab35.jpg','','',99,'','',1649644543,1649644534,0,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'mashaladizongcai2021kuan30tsq4haohuaban','msldzc2021k30tsq4hhb',''),(72,0,16,'宾利 欧陆  2018款 6.0T GT W12','','','/Static/upload/20220411/6166253963c50f731.jpg','','',99,'','',1649644953,1649644942,0,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'binlioulu2018kuan60tgtw12','blol2018k60tgtw12',''),(73,0,16,'兰博基尼 Murcielago  2007款 LP 640','','','/Static/upload/20220411/9166253978d7d2297.jpg','','',99,'','',1649645438,1649645434,0,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'lanbojinimurcielago2007kuanlp640','lbjnmurcielago2007klp640',''),(74,0,16,'特斯拉 Roadster  2019款 创始人系列','','','/Static/upload/20220411/2746253a206c503f4.jpg','','',99,'','',1649648116,1649648111,2,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'tesilaroadster2019kuanchuangshirenxilie','tslroadster2019kcsrxl',''),(75,0,16,'路特斯 Evija  2020款 基本型','','','/Static/upload/20220411/7186253e93431b687.jpg','','',99,'','',1649666338,1649666333,0,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'lutesievija2020kuanjibenxing','ltsevija2020kjbx',''),(76,0,16,'劳斯莱斯 幻影  2018款 6.7T 长轴距版','','','/Static/upload/20220411/8396253ea1eaddb66.jpg','','',99,'','',1649666444,1649666428,1,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'laosilaisihuanying2018kuan67tchangzhoujuban','lslshy2018k67tczjb',''),(77,0,16,'路虎卫士新能源  2022款 110 P400e','','','/Static/upload/20220411/3556253eb27ce9244.jpg','','',99,'','',1649666841,1649666836,3,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'luhuweishixinnengyuan2022kuan110p400e','lhwsxny2022k110p400e',''),(78,0,16,'凯迪拉克XT6  2021款 2.0T 六座四驱豪华型','','','/Static/upload/20220411/1616253ecc9e06668.jpg','','',99,'','',1649667258,1649667252,69,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'kaidilakext62021kuan20tliuzuosiquhaohuaxing','kdlkxt62021k20tlzsqhhx','');

#
# Structure for table "qc_table_article"
#

DROP TABLE IF EXISTS `qc_table_article`;
CREATE TABLE `qc_table_article` (
  `Id` bigint(20) NOT NULL DEFAULT '0',
  `ModelId` int(11) NOT NULL DEFAULT '0',
  `CateId` int(11) NOT NULL DEFAULT '0',
  `Title` varchar(100) NOT NULL DEFAULT '',
  `STitle` varchar(60) NOT NULL DEFAULT '' COMMENT '短标题',
  `Tag` varchar(100) NOT NULL DEFAULT '' COMMENT 'Tag',
  `Pic` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `Source` varchar(50) NOT NULL DEFAULT '' COMMENT '来源',
  `Author` varchar(50) NOT NULL DEFAULT '' COMMENT '作者',
  `Sort` tinyint(3) NOT NULL DEFAULT '99',
  `Keywords` varchar(255) NOT NULL DEFAULT '',
  `Description` varchar(255) NOT NULL DEFAULT '',
  `TsAdd` bigint(20) NOT NULL DEFAULT '0',
  `TsUpdate` bigint(20) NOT NULL DEFAULT '0',
  `ReadNum` int(11) NOT NULL DEFAULT '0',
  `Coins` int(11) NOT NULL DEFAULT '0' COMMENT '需消费金币',
  `Money` int(11) NOT NULL DEFAULT '0' COMMENT '支付费用',
  `UserLevel` int(11) NOT NULL DEFAULT '0' COMMENT '浏览权限',
  `Color` varchar(10) NOT NULL DEFAULT '' COMMENT '颜色',
  `UserId` bigint(20) NOT NULL DEFAULT '0',
  `Good` int(11) NOT NULL DEFAULT '0',
  `Bad` int(11) NOT NULL DEFAULT '0',
  `State` tinyint(3) NOT NULL DEFAULT '1',
  `Content` text,
  `IsLink` tinyint(3) NOT NULL DEFAULT '2',
  `LinkUrl` varchar(255) NOT NULL DEFAULT '' COMMENT '外链地址',
  `IsBold` tinyint(3) NOT NULL DEFAULT '2',
  `IsPic` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否有缩略图',
  `IsSpuerRec` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否特推',
  `IsHeadlines` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否头条',
  `IsRec` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否推荐',
  `IsPost` tinyint(3) NOT NULL DEFAULT '1' COMMENT '允许评论',
  `IsDelete` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否删除',
  `PinYin` varchar(255) NOT NULL DEFAULT '',
  `PY` varchar(255) NOT NULL DEFAULT '',
  `Summary` varchar(255) DEFAULT '' COMMENT '摘要',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "qc_table_article"
#

INSERT INTO `qc_table_article` VALUES (44,0,1,'售23.69-33.19万元 国产2系旅行车上市','','宝马,旅行车,国产','/Static/images/n1.jpg','新华网','钱大帅',99,'','',1649506586,1649506511,0,0,0,0,'',1,0,0,1,'<p>&nbsp;　国产宝马2系旅行车将提供两种不同动力供消费者选择，分别为搭载B38系列三缸1.5T发动机的宝马218i（136马力）以及搭载B48系列四缸2.0T发动机的220i（192马力）。传动方面，与1.5T发动机匹配的是6速手自一体变速箱，与2.0T发动机匹配的是8速手自一体变速箱。</p><p>&nbsp;</p><p>● 新车历史：</p><p>&nbsp;</p><p>&nbsp;宝马2系旅行车（海外市场称宝马2系Active Tourer）曾于2014年日内瓦车展首发，这也是宝马品牌首次使用UKL+平台打造的车型，同时这也是近年来首款采用B38系列三缸涡轮增压发动机以及首款前驱布局的宝马车型。新车定位也相比其他宝马车型更加偏向于实用性与居家旅行。 　国产宝马2系旅行车将提供两种不同动力供消费者选择，分别为搭载B38系列三缸1.5T发动机的宝马218i（136马力）以及搭载B48系列四缸2.0T发动机的220i（192马力）。传动方面，与1.5T发动机匹配的是6速手自一体变速箱，与2.0T发动机匹配的是8速手自一体变速箱。</p><p>&nbsp;</p><p>● 新车历史：</p><p>&nbsp;</p><p>&nbsp;宝马2系旅行车（海外市场称宝马2系Active Tourer）曾于2014年日内瓦车展首发，这也是宝马品牌首次使用UKL+平台打造的车型，同时这也是近年来首款采用B38系列三缸涡轮增压发动机以及首款前驱布局的宝马车型。新车定位也相比其他宝马车型更加偏向于实用性与居家旅行。 　国产宝马2系旅行车将提供两种不同动力供消费者选择，分别为搭载B38系列三缸1.5T发动机的宝马218i（136马力）以及搭载B48系列四缸2.0T发动机的220i（192马力）。传动方面，与1.5T发动机匹配的是6速手自一体变速箱，与2.0T发动机匹配的是8速手自一体变速箱。</p><p>&nbsp;</p><p>● 新车历史：</p><p>&nbsp;</p><p>&nbsp;宝马2系旅行车（海外市场称宝马2系Active Tourer）曾于2014年日内瓦车展首发，这也是宝马品牌首次使用UKL+平台打造的车型，同时这也是近年来首款采用B38系列三缸涡轮增压发动机以及首款前驱布局的宝马车型。新车定位也相比其他宝马车型更加偏向于实用性与居家旅行。 　国产宝马2系旅行车将提供两种不同动力供消费者选择，分别为搭载B38系列三缸1.5T发动机的宝马218i（136马力）以及搭载B48系列四缸2.0T发动机的220i（192马力）。传动方面，与1.5T发动机匹配的是6速手自一体变速箱，与2.0T发动机匹配的是8速手自一体变速箱。</p><p>&nbsp;</p><p>● 新车历史：</p><p>&nbsp;</p><p>&nbsp;宝马2系旅行车（海外市场称宝马2系Active Tourer）曾于2014年日内瓦车展首发，这也是宝马品牌首次使用UKL+平台打造的车型，同时这也是近年来首款采用B38系列三缸涡轮增压发动机以及首款前驱布局的宝马车型。新车定位也相比其他宝马车型更加偏向于实用性与居家旅行。 　国产宝马2系旅行车将提供两种不同动力供消费者选择，分别为搭载B38系列三缸1.5T发动机的宝马218i（136马力）以及搭载B48系列四缸2.0T发动机的220i（192马力）。传动方面，与1.5T发动机匹配的是6速手自一体变速箱，与2.0T发动机匹配的是8速手自一体变速箱。</p><p>&nbsp;</p><p>● 新车历史：</p><p>&nbsp;</p><p>&nbsp;宝马2系旅行车（海外市场称宝马2系Active Tourer）曾于2014年日内瓦车展首发，这也是宝马品牌首次使用UKL+平台打造的车型，同时这也是近年来首款采用B38系列三缸涡轮增压发动机以及首款前驱布局的宝马车型。新车定位也相比其他宝马车型更加偏向于实用性与居家旅行。 　国产宝马2系旅行车将提供两种不同动力供消费者选择，分别为搭载B38系列三缸1.5T发动机的宝马218i（136马力）以及搭载B48系列四缸2.0T发动机的220i（192马力）。传动方面，与1.5T发动机匹配的是6速手自一体变速箱，与2.0T发动机匹配的是8速手自一体变速箱。</p><p>&nbsp;</p><p>● 新车历史：</p><p>&nbsp;</p><p>&nbsp;宝马2系旅行车（海外市场称宝马2系Active Tourer）曾于2014年日内瓦车展首发，这也是宝马品牌首次使用UKL+平台打造的车型，同时这也是近年来首款采用B38系列三缸涡轮增压发动机以及首款前驱布局的宝马车型。新车定位也相比其他宝马车型更加偏向于实用性与居家旅行。 　国产宝马2系旅行车将提供两种不同动力供消费者选择，分别为搭载B38系列三缸1.5T发动机的宝马218i（136马力）以及搭载B48系列四缸2.0T发动机的220i（192马力）。传动方面，与1.5T发动机匹配的是6速手自一体变速箱，与2.0T发动机匹配的是8速手自一体变速箱。</p><p>&nbsp;</p><p>● 新车历史：</p><p>&nbsp;</p><p>&nbsp;宝马2系旅行车（海外市场称宝马2系Active Tourer）曾于2014年日内瓦车展首发，这也是宝马品牌首次使用UKL+平台打造的车型，同时这也是近年来首款采用B38系列三缸涡轮增压发动机以及首款前驱布局的宝马车型。新车定位也相比其他宝马车型更加偏向于实用性与居家旅行。</p>',2,'',2,1,2,2,2,1,2,'shou23693319wanyuanguochan2xiluxingcheshangshi','s23693319wygc2xlxcss','国产宝马2系旅行车将提供两种不同动力供消费者选择，分别为搭载B38系列三缸1.5T发动机的宝马218i（136马力）以及搭载B48系列四缸2.0T发动机的220i（192马力）。'),(45,0,1,'荷尔蒙作祟 测试2016款奔驰G 500 4.0T','','奔驰,荷尔蒙','/Static/images/n3.jpg','新华网','钱大帅',99,'','',1649559981,1649559813,0,0,0,0,'',1,0,0,1,'<p>对于这样一辆特点鲜明且售价高高在上的车来说，理性和感性之间的天平似乎很容易倾斜，买它的人不用过多去考虑什么性价比、实用性，喜欢就够了，这也是我翻看了论坛里几十篇提车作业后得出的结论。至于理性层面的东西，则是我未来几天需要探究的。对于这样一辆特点鲜明且售价高高在上的车来说，理性和感性之间的天平似乎很容易倾斜，买它的人不用过多去考虑什么性价比、实用性，喜欢就够了，这也是我翻看了论坛里几十篇提车作业后得出的结论。至于理性层面的东西，则是我未来几天需要探究的。对于这样一辆特点鲜明且售价高高在上的车来说，理性和感性之间的天平似乎很容易倾斜，买它的人不用过多去考虑什么性价比、实用性，喜欢就够了，这也是我翻看了论坛里几十篇提车作业后得出的结论。至于理性层面的东西，则是我未来几天需要探究的。</p><p>对于这样一辆特点鲜明且售价高高在上的车来说，理性和感性之间的天平似乎很容易倾斜，买它的人不用过多去考虑什么性价比、实用性，喜欢就够了，这也是我翻看了论坛里几十篇提车作业后得出的结论。至于理性层面的东西，则是我未来几天需要探究的。</p><p>对于这样一辆特点鲜明且售价高高在上的车来说，理性和感性之间的天平似乎很容易倾斜，买它的人不用过多去考虑什么性价比、实用性，喜欢就够了，这也是我翻看了论坛里几十篇提车作业后得出的结论。至于理性层面的东西，则是我未来几天需要探究的。</p><p>对于这样一辆特点鲜明且售价高高在上的车来说，理性和感性之间的天平似乎很容易倾斜，买它的人不用过多去考虑什么性价比、实用性，喜欢就够了，这也是我翻看了论坛里几十篇提车作业后得出的结论。至于理性层面的东西，则是我未来几天需要探究的。</p><p>对于这样一辆特点鲜明且售价高高在上的车来说，理性和感性之间的天平似乎很容易倾斜，买它的人不用过多去考虑什么性价比、实用性，喜欢就够了，这也是我翻看了论坛里几十篇提车作业后得出的结论。至于理性层面的东西，则是我未来几天需要探究的。对于这样一辆特点鲜明且售价高高在上的车来说，理性和感性之间的天平似乎很容易倾斜，买它的人不用过多去考虑什么性价比、实用性，喜欢就够了，这也是我翻看了论坛里几十篇提车作业后得出的结论。至于理性层面的东西，则是我未来几天需要探究的。</p><p>对于这样一辆特点鲜明且售价高高在上的车来说，理性和感性之间的天平似乎很容易倾斜，买它的人不用过多去考虑什么性价比、实用性，喜欢就够了，这也是我翻看了论坛里几十篇提车作业后得出的结论。至于理性层面的东西，则是我未来几天需要探究的。对于这样一辆特点鲜明且售价高高在上的车来说，理性和感性之间的天平似乎很容易倾斜，买它的人不用过多去考虑什么性价比、实用性，喜欢就够了，这也是我翻看了论坛里几十篇提车作业后得出的结论。至于理性层面的东西，则是我未来几天需要探究的。</p><p>对于这样一辆特点鲜明且售价高高在上的车来说，理性和感性之间的天平似乎很容易倾斜，买它的人不用过多去考虑什么性价比、实用性，喜欢就够了，这也是我翻看了论坛里几十篇提车作业后得出的结论。至于理性层面的东西，则是我未来几天需要探究的。对于这样一辆特点鲜明且售价高高在上的车来说，理性和感性之间的天平似乎很容易倾斜，买它的人不用过多去考虑什么性价比、实用性，喜欢就够了，这也是我翻看了论坛里几十篇提车作业后得出的结论。至于理性层面的东西，则是我未来几天需要探究的。对于这样一辆特点鲜明且售价高高在上的车来说，理性和感性之间的天平似乎很容易倾斜，买它的人不用过多去考虑什么性价比、实用性，喜欢就够了，这也是我翻看了论坛里几十篇提车作业后得出的结论。至于理性层面的东西，则是我未来几天需要探究的。</p><p>对于这样一辆特点鲜明且售价高高在上的车来说，理性和感性之间的天平似乎很容易倾斜，买它的人不用过多去考虑什么性价比、实用性，喜欢就够了，这也是我翻看了论坛里几十篇提车作业后得出的结论。至于理性层面的东西，则是我未来几天需要探究的。</p>',2,'',2,1,2,2,2,1,2,'heermengzuosuiceshi2016kuanbenchig50040t','hemzscs2016kbcg50040t','当我拿到奔驰G 500车钥匙的时候，一遍又一遍的问自己，如果我有200万，会选择它吗？我的大脑在理性思考和感性冲动之间摇摆不定，即使我已经非常克制自己，但仍无法冷静的作出选择。'),(46,0,1,'售60.5-77.5万元 国产宝马X5正式上市','','宝马,X5','/Static/images/n4.jpg','新华网','钱大帅',99,'','',1649560229,1649560127,0,0,0,0,'',1,0,0,1,'<p>　　外观方面，国产宝马X5延续进口版车型设计，但在细节处有所调整，比如，新车保险杠两侧的进气口重新设计，倒置L型布局点缀的镀铬装饰，平添一份精致。新车提供包含M运动排气和蓝色M运动卡钳的M Performance套件。与进口版车型相同，国产版车型仍然拥有大尺寸双肾型进气格栅以及宝马标志性特点的激光大灯，灯内隐藏蓝色“X”造型。</p><p>　　车身尺寸是国产宝马X5最大的不同之处，国产宝马X5车身长度和轴距均比进口版车型增加130mm，最终国产车型长宽高分别为5060mm/2004mm/1779mm，轴距达到3105mm。后车门明显更宽大，这将使得国产宝马X5有着更为出色的后排腿部空间。车身腰线从后门位置上扬并与尾灯相连，国产版车型前翼子板的空气动力学套件还增加了镀铬装饰。</p><p>　　外观方面，国产宝马X5延续进口版车型设计，但在细节处有所调整，比如，新车保险杠两侧的进气口重新设计，倒置L型布局点缀的镀铬装饰，平添一份精致。新车提供包含M运动排气和蓝色M运动卡钳的M Performance套件。与进口版车型相同，国产版车型仍然拥有大尺寸双肾型进气格栅以及宝马标志性特点的激光大灯，灯内隐藏蓝色“X”造型。</p><p>　　车身尺寸是国产宝马X5最大的不同之处，国产宝马X5车身长度和轴距均比进口版车型增加130mm，最终国产车型长宽高分别为5060mm/2004mm/1779mm，轴距达到3105mm。后车门明显更宽大，这将使得国产宝马X5有着更为出色的后排腿部空间。车身腰线从后门位置上扬并与尾灯相连，国产版车型前翼子板的空气动力学套件还增加了镀铬装饰。</p><p>　　外观方面，国产宝马X5延续进口版车型设计，但在细节处有所调整，比如，新车保险杠两侧的进气口重新设计，倒置L型布局点缀的镀铬装饰，平添一份精致。新车提供包含M运动排气和蓝色M运动卡钳的M Performance套件。与进口版车型相同，国产版车型仍然拥有大尺寸双肾型进气格栅以及宝马标志性特点的激光大灯，灯内隐藏蓝色“X”造型。</p><p>　　车身尺寸是国产宝马X5最大的不同之处，国产宝马X5车身长度和轴距均比进口版车型增加130mm，最终国产车型长宽高分别为5060mm/2004mm/1779mm，轴距达到3105mm。后车门明显更宽大，这将使得国产宝马X5有着更为出色的后排腿部空间。车身腰线从后门位置上扬并与尾灯相连，国产版车型前翼子板的空气动力学套件还增加了镀铬装饰。</p><p>　　外观方面，国产宝马X5延续进口版车型设计，但在细节处有所调整，比如，新车保险杠两侧的进气口重新设计，倒置L型布局点缀的镀铬装饰，平添一份精致。新车提供包含M运动排气和蓝色M运动卡钳的M Performance套件。与进口版车型相同，国产版车型仍然拥有大尺寸双肾型进气格栅以及宝马标志性特点的激光大灯，灯内隐藏蓝色“X”造型。</p><p>　　车身尺寸是国产宝马X5最大的不同之处，国产宝马X5车身长度和轴距均比进口版车型增加130mm，最终国产车型长宽高分别为5060mm/2004mm/1779mm，轴距达到3105mm。后车门明显更宽大，这将使得国产宝马X5有着更为出色的后排腿部空间。车身腰线从后门位置上扬并与尾灯相连，国产版车型前翼子板的空气动力学套件还增加了镀铬装饰。</p><p>　　外观方面，国产宝马X5延续进口版车型设计，但在细节处有所调整，比如，新车保险杠两侧的进气口重新设计，倒置L型布局点缀的镀铬装饰，平添一份精致。新车提供包含M运动排气和蓝色M运动卡钳的M Performance套件。与进口版车型相同，国产版车型仍然拥有大尺寸双肾型进气格栅以及宝马标志性特点的激光大灯，灯内隐藏蓝色“X”造型。</p><p>　　车身尺寸是国产宝马X5最大的不同之处，国产宝马X5车身长度和轴距均比进口版车型增加130mm，最终国产车型长宽高分别为5060mm/2004mm/1779mm，轴距达到3105mm。后车门明显更宽大，这将使得国产宝马X5有着更为出色的后排腿部空间。车身腰线从后门位置上扬并与尾灯相连，国产版车型前翼子板的空气动力学套件还增加了镀铬装饰。</p><p>　　外观方面，国产宝马X5延续进口版车型设计，但在细节处有所调整，比如，新车保险杠两侧的进气口重新设计，倒置L型布局点缀的镀铬装饰，平添一份精致。新车提供包含M运动排气和蓝色M运动卡钳的M Performance套件。与进口版车型相同，国产版车型仍然拥有大尺寸双肾型进气格栅以及宝马标志性特点的激光大灯，灯内隐藏蓝色“X”造型。</p><p>　　车身尺寸是国产宝马X5最大的不同之处，国产宝马X5车身长度和轴距均比进口版车型增加130mm，最终国产车型长宽高分别为5060mm/2004mm/1779mm，轴距达到3105mm。后车门明显更宽大，这将使得国产宝马X5有着更为出色的后排腿部空间。车身腰线从后门位置上扬并与尾灯相连，国产版车型前翼子板的空气动力学套件还增加了镀铬装饰。</p>',2,'',2,1,2,2,2,1,2,'shou605775wanyuanguochanbaomax5zhengshishangshi','s605775wygcbmx5zsss','新车定位于中大型SUV，此前进口版宝马X5售价为69.99-83.99万元（xDrive 30i、xDrive 40i），相比于进口版车型，国产版宝马X5进一步满足中国消费者需求'),(47,0,1,'售14.99万起 全新大众凌渡L正式上市','','大众,凌渡L','/Static/images/n5.jpg','新华网','钱大帅',99,'','',1649560414,1649560288,0,0,0,0,'',1,0,0,1,'<p>作为一款换代产品，全新凌渡L将基于大众MQB Evo平台打造。新车前脸设计十分大胆，采用大曲率的发动机舱盖营造出低矮的视觉效果，前方大灯造型犀利，并与贯穿式灯带和可发光LOGO融为一体，颇有一番新能源车的风格。中网采用大尺寸的点阵式格栅设计，将视觉重心再次下降了不少。</p><p>　　来到侧面，新车配备了无框式车门和溜背式造型很受年轻人追捧，另外官方还推出了官方改色服务，包括绿、粉、蓝、青等共5种哑光配色。车身尺寸方面，新车的长宽高分别为4784/1831/1469mm，轴距2731mm，依旧定位为紧凑型轿车。</p><p>　　车尾部分，时下流行的贯穿式尾灯继续出现在全新凌渡L上，尾灯连同中心的LOGO一同点亮，与前脸形成呼应。后备厢配备一体式扰流板设计，增添了运动感。另外值得一提的是，新车采用掀背式尾门设计，开启后同样十分吸睛，不过仅有顶配车型配备电动尾门。</p><p>作为一款换代产品，全新凌渡L将基于大众MQB Evo平台打造。新车前脸设计十分大胆，采用大曲率的发动机舱盖营造出低矮的视觉效果，前方大灯造型犀利，并与贯穿式灯带和可发光LOGO融为一体，颇有一番新能源车的风格。中网采用大尺寸的点阵式格栅设计，将视觉重心再次下降了不少。</p><p>　　来到侧面，新车配备了无框式车门和溜背式造型很受年轻人追捧，另外官方还推出了官方改色服务，包括绿、粉、蓝、青等共5种哑光配色。车身尺寸方面，新车的长宽高分别为4784/1831/1469mm，轴距2731mm，依旧定位为紧凑型轿车。</p><p>　　车尾部分，时下流行的贯穿式尾灯继续出现在全新凌渡L上，尾灯连同中心的LOGO一同点亮，与前脸形成呼应。后备厢配备一体式扰流板设计，增添了运动感。另外值得一提的是，新车采用掀背式尾门设计，开启后同样十分吸睛，不过仅有顶配车型配备电动尾门。</p><p>作为一款换代产品，全新凌渡L将基于大众MQB Evo平台打造。新车前脸设计十分大胆，采用大曲率的发动机舱盖营造出低矮的视觉效果，前方大灯造型犀利，并与贯穿式灯带和可发光LOGO融为一体，颇有一番新能源车的风格。中网采用大尺寸的点阵式格栅设计，将视觉重心再次下降了不少。</p><p>　　来到侧面，新车配备了无框式车门和溜背式造型很受年轻人追捧，另外官方还推出了官方改色服务，包括绿、粉、蓝、青等共5种哑光配色。车身尺寸方面，新车的长宽高分别为4784/1831/1469mm，轴距2731mm，依旧定位为紧凑型轿车。</p><p>　　车尾部分，时下流行的贯穿式尾灯继续出现在全新凌渡L上，尾灯连同中心的LOGO一同点亮，与前脸形成呼应。后备厢配备一体式扰流板设计，增添了运动感。另外值得一提的是，新车采用掀背式尾门设计，开启后同样十分吸睛，不过仅有顶配车型配备电动尾门。</p><p>作为一款换代产品，全新凌渡L将基于大众MQB Evo平台打造。新车前脸设计十分大胆，采用大曲率的发动机舱盖营造出低矮的视觉效果，前方大灯造型犀利，并与贯穿式灯带和可发光LOGO融为一体，颇有一番新能源车的风格。中网采用大尺寸的点阵式格栅设计，将视觉重心再次下降了不少。</p><p>　　来到侧面，新车配备了无框式车门和溜背式造型很受年轻人追捧，另外官方还推出了官方改色服务，包括绿、粉、蓝、青等共5种哑光配色。车身尺寸方面，新车的长宽高分别为4784/1831/1469mm，轴距2731mm，依旧定位为紧凑型轿车。</p><p>　　车尾部分，时下流行的贯穿式尾灯继续出现在全新凌渡L上，尾灯连同中心的LOGO一同点亮，与前脸形成呼应。后备厢配备一体式扰流板设计，增添了运动感。另外值得一提的是，新车采用掀背式尾门设计，开启后同样十分吸睛，不过仅有顶配车型配备电动尾门。</p>',2,'',2,1,2,2,2,1,2,'shou1499wanqiquanxindazhonglingdulzhengshishangshi','s1499wqqxdzldlzsss','作为一款换代产品，全新凌渡L将基于大众MQB Evo平台打造。新车前脸设计十分大胆，采用大曲率的发动机舱盖营造出低矮的视觉效果，前方大灯造型犀利，并与贯穿式灯带和可发光LOGO融为一体'),(48,0,1,'沃尔沃(进口)-沃尔沃XC90新能源上市','','沃尔沃,进口,XC90','/Static/images/n6.jpg','新华网','钱大帅',99,'','',1649560564,1649560473,2,0,0,0,'',1,0,0,1,'<p>【快讯|新款沃尔沃XC90 T8上市 售价不变】近日，沃尔沃针对旗下XC90 T8车型的动力系统进行了升级，换装了新的电机，最大功率提升至104kW（145马力），最大扭矩309牛·米，同时电池容量提升至18.8kWh，续航里程为59km（WLTC）。升级后新车售价保持不变，依旧为89.49万元。 &nbsp;</p><p>&nbsp;</p><p>电机和电池升级后，对于日常通勤和动力表现都有所提升，与2.0T发动机匹配后，系统综合最大功率达到335kW（提升47kW）、综合扭矩为709牛·米（提升69牛·米），0-100km/h加速时间缩短为5.5s（缩短0.3s），同时WLTC工况下的百公里综合油耗为2.86L/100km。</p><p>【快讯|新款沃尔沃XC90 T8上市 售价不变】近日，沃尔沃针对旗下XC90 T8车型的动力系统进行了升级，换装了新的电机，最大功率提升至104kW（145马力），最大扭矩309牛·米，同时电池容量提升至18.8kWh，续航里程为59km（WLTC）。升级后新车售价保持不变，依旧为89.49万元。 &nbsp;</p><p>&nbsp;</p><p>电机和电池升级后，对于日常通勤和动力表现都有所提升，与2.0T发动机匹配后，系统综合最大功率达到335kW（提升47kW）、综合扭矩为709牛·米（提升69牛·米），0-100km/h加速时间缩短为5.5s（缩短0.3s），同时WLTC工况下的百公里综合油耗为2.86L/100km。</p><p>【快讯|新款沃尔沃XC90 T8上市 售价不变】近日，沃尔沃针对旗下XC90 T8车型的动力系统进行了升级，换装了新的电机，最大功率提升至104kW（145马力），最大扭矩309牛·米，同时电池容量提升至18.8kWh，续航里程为59km（WLTC）。升级后新车售价保持不变，依旧为89.49万元。 &nbsp;</p><p>&nbsp;</p><p>电机和电池升级后，对于日常通勤和动力表现都有所提升，与2.0T发动机匹配后，系统综合最大功率达到335kW（提升47kW）、综合扭矩为709牛·米（提升69牛·米），0-100km/h加速时间缩短为5.5s（缩短0.3s），同时WLTC工况下的百公里综合油耗为2.86L/100km。</p><p>【快讯|新款沃尔沃XC90 T8上市 售价不变】近日，沃尔沃针对旗下XC90 T8车型的动力系统进行了升级，换装了新的电机，最大功率提升至104kW（145马力），最大扭矩309牛·米，同时电池容量提升至18.8kWh，续航里程为59km（WLTC）。升级后新车售价保持不变，依旧为89.49万元。 &nbsp;</p><p>&nbsp;</p><p>电机和电池升级后，对于日常通勤和动力表现都有所提升，与2.0T发动机匹配后，系统综合最大功率达到335kW（提升47kW）、综合扭矩为709牛·米（提升69牛·米），0-100km/h加速时间缩短为5.5s（缩短0.3s），同时WLTC工况下的百公里综合油耗为2.86L/100km。</p><p>【快讯|新款沃尔沃XC90 T8上市 售价不变】近日，沃尔沃针对旗下XC90 T8车型的动力系统进行了升级，换装了新的电机，最大功率提升至104kW（145马力），最大扭矩309牛·米，同时电池容量提升至18.8kWh，续航里程为59km（WLTC）。升级后新车售价保持不变，依旧为89.49万元。 &nbsp;</p><p>&nbsp;</p><p>电机和电池升级后，对于日常通勤和动力表现都有所提升，与2.0T发动机匹配后，系统综合最大功率达到335kW（提升47kW）、综合扭矩为709牛·米（提升69牛·米），0-100km/h加速时间缩短为5.5s（缩短0.3s），同时WLTC工况下的百公里综合油耗为2.86L/100km。</p>',2,'',2,1,2,2,2,1,2,'woerwojinkouwoerwoxc90xinnengyuanshangshi','wewjkwewxc90xnyss','沃尔沃针对旗下XC90 T8车型的动力系统进行了升级，换装了新的电机，最大功率提升至104kW（145马力），最大扭矩309牛·米，同时电池容量提升至18.8kWh，续航里程为59km（WLTC）。'),(49,0,1,'售28.20万起 2022款大众途昂/途昂X上市','','大众,途昂X','/Static/images/n7.jpg','新华网','钱大帅',99,'','',1649560666,1649560612,0,0,0,0,'',1,0,0,1,'<p>　　作为年代改款车型，2022款大众途昂基本延续了老款车型的设计风格，整体十分大气。在动力方面，动力方面，新车将搭载大众的EA888 2.0T发动机，和EA390 2.5T V6发动机，前者根据调校不同，提供最大功率为186马力和220马力，后者最大功率为299马力。传动方面，新车将全系匹配7速湿式双离合变速箱，并依旧支持全时四驱系统。</p><p>　　作为年代改款车型，2022款大众途昂基本延续了老款车型的设计风格，整体十分大气。在动力方面，动力方面，新车将搭载大众的EA888 2.0T发动机，和EA390 2.5T V6发动机，前者根据调校不同，提供最大功率为186马力和220马力，后者最大功率为299马力。传动方面，新车将全系匹配7速湿式双离合变速箱，并依旧支持全时四驱系统。</p><p>　　作为年代改款车型，2022款大众途昂基本延续了老款车型的设计风格，整体十分大气。在动力方面，动力方面，新车将搭载大众的EA888 2.0T发动机，和EA390 2.5T V6发动机，前者根据调校不同，提供最大功率为186马力和220马力，后者最大功率为299马力。传动方面，新车将全系匹配7速湿式双离合变速箱，并依旧支持全时四驱系统。</p><p>　　作为年代改款车型，2022款大众途昂基本延续了老款车型的设计风格，整体十分大气。在动力方面，动力方面，新车将搭载大众的EA888 2.0T发动机，和EA390 2.5T V6发动机，前者根据调校不同，提供最大功率为186马力和220马力，后者最大功率为299马力。传动方面，新车将全系匹配7速湿式双离合变速箱，并依旧支持全时四驱系统。　　作为年代改款车型，2022款大众途昂基本延续了老款车型的设计风格，整体十分大气。在动力方面，动力方面，新车将搭载大众的EA888 2.0T发动机，和EA390 2.5T V6发动机，前者根据调校不同，提供最大功率为186马力和220马力，后者最大功率为299马力。传动方面，新车将全系匹配7速湿式双离合变速箱，并依旧支持全时四驱系统。</p><p>　　作为年代改款车型，2022款大众途昂基本延续了老款车型的设计风格，整体十分大气。在动力方面，动力方面，新车将搭载大众的EA888 2.0T发动机，和EA390 2.5T V6发动机，前者根据调校不同，提供最大功率为186马力和220马力，后者最大功率为299马力。传动方面，新车将全系匹配7速湿式双离合变速箱，并依旧支持全时四驱系统。</p><p>　　作为年代改款车型，2022款大众途昂基本延续了老款车型的设计风格，整体十分大气。在动力方面，动力方面，新车将搭载大众的EA888 2.0T发动机，和EA390 2.5T V6发动机，前者根据调校不同，提供最大功率为186马力和220马力，后者最大功率为299马力。传动方面，新车将全系匹配7速湿式双离合变速箱，并依旧支持全时四驱系统。</p><p>　　作为年代改款车型，2022款大众途昂基本延续了老款车型的设计风格，整体十分大气。在动力方面，动力方面，新车将搭载大众的EA888 2.0T发动机，和EA390 2.5T V6发动机，前者根据调校不同，提供最大功率为186马力和220马力，后者最大功率为299马力。传动方面，新车将全系匹配7速湿式双离合变速箱，并依旧支持全时四驱系统。　　作为年代改款车型，2022款大众途昂基本延续了老款车型的设计风格，整体十分大气。在动力方面，动力方面，新车将搭载大众的EA888 2.0T发动机，和EA390 2.5T V6发动机，前者根据调校不同，提供最大功率为186马力和220马力，后者最大功率为299马力。传动方面，新车将全系匹配7速湿式双离合变速箱，并依旧支持全时四驱系统。</p>',2,'',2,1,2,2,2,1,2,'shou2820wanqi2022kuandazhongtuangtuangxshangshi','s2820wq2022kdztataxss','2022款途昂和2022款途昂X正式上市，其中2022款途昂共有7款配置车型，售价区间为29.20-40.20万元；2022款途昂X共推出9款配置车型，售价区间为28.20-39.20万元。'),(50,0,1,'售16.88万 领克06 PHEV SHERO开启抢订','','领克06','/Static/images/n8.jpg','新华网','钱大帅',99,'','',1649560833,1649560751,0,0,0,0,'',1,0,0,1,'<p>领克06 PHEV SHERO于21:06正式开启抢订，并限量发售266台，指导价格为16.88万元。新车基于领克06 PHEV打造，主要变化在于使用了粉紫拼色车身以及部分装饰套件，看起来有少女感。外观来看，新车采用全新的外观配色，让新车看上去相当时尚、前卫，预计会吸引不少女性消费者的青睐。当然，不排除一些男性用户也会产生兴趣。</p><p>领克06 PHEV SHERO于21:06正式开启抢订，并限量发售266台，指导价格为16.88万元。新车基于领克06 PHEV打造，主要变化在于使用了粉紫拼色车身以及部分装饰套件，看起来有少女感。外观来看，新车采用全新的外观配色，让新车看上去相当时尚、前卫，预计会吸引不少女性消费者的青睐。当然，不排除一些男性用户也会产生兴趣。领克06 PHEV SHERO于21:06正式开启抢订，并限量发售266台，指导价格为16.88万元。新车基于领克06 PHEV打造，主要变化在于使用了粉紫拼色车身以及部分装饰套件，看起来有少女感。外观来看，新车采用全新的外观配色，让新车看上去相当时尚、前卫，预计会吸引不少女性消费者的青睐。当然，不排除一些男性用户也会产生兴趣。</p><p>领克06 PHEV SHERO于21:06正式开启抢订，并限量发售266台，指导价格为16.88万元。新车基于领克06 PHEV打造，主要变化在于使用了粉紫拼色车身以及部分装饰套件，看起来有少女感。外观来看，新车采用全新的外观配色，让新车看上去相当时尚、前卫，预计会吸引不少女性消费者的青睐。当然，不排除一些男性用户也会产生兴趣。</p><p>领克06 PHEV SHERO于21:06正式开启抢订，并限量发售266台，指导价格为16.88万元。新车基于领克06 PHEV打造，主要变化在于使用了粉紫拼色车身以及部分装饰套件，看起来有少女感。外观来看，新车采用全新的外观配色，让新车看上去相当时尚、前卫，预计会吸引不少女性消费者的青睐。当然，不排除一些男性用户也会产生兴趣。领克06 PHEV SHERO于21:06正式开启抢订，并限量发售266台，指导价格为16.88万元。新车基于领克06 PHEV打造，主要变化在于使用了粉紫拼色车身以及部分装饰套件，看起来有少女感。外观来看，新车采用全新的外观配色，让新车看上去相当时尚、前卫，预计会吸引不少女性消费者的青睐。当然，不排除一些男性用户也会产生兴趣。</p><p>领克06 PHEV SHERO于21:06正式开启抢订，并限量发售266台，指导价格为16.88万元。新车基于领克06 PHEV打造，主要变化在于使用了粉紫拼色车身以及部分装饰套件，看起来有少女感。外观来看，新车采用全新的外观配色，让新车看上去相当时尚、前卫，预计会吸引不少女性消费者的青睐。当然，不排除一些男性用户也会产生兴趣。</p><p>&nbsp;</p><p>领克06 PHEV SHERO于21:06正式开启抢订，并限量发售266台，指导价格为16.88万元。新车基于领克06 PHEV打造，主要变化在于使用了粉紫拼色车身以及部分装饰套件，看起来有少女感。外观来看，新车采用全新的外观配色，让新车看上去相当时尚、前卫，预计会吸引不少女性消费者的青睐。当然，不排除一些男性用户也会产生兴趣。</p>',2,'',2,1,2,2,2,1,2,'shou1688wanlingke06phevsherokaiqiqiangding','s1688wlk06phevsherokqqd','领克06 PHEV SHERO于21:06正式开启抢订，并限量发售266台，指导价格为16.88万元。新车基于领克06 PHEV打造，主要变化在于使用了粉紫拼色车身以及部分装饰套件，看起来有少女感。'),(51,0,1,'售2.86-4.16万元 风光MINIEV实尚款上市','','风光MINIEV','/Static/images/n9.jpg','新华网','钱大帅',99,'','',1649561019,1649560870,2,0,0,0,'',1,0,0,1,'<p>3月8日，风光MINIEV(参数|询价)实尚款正式上市，新车共计推出3款车型，售价2.86-4.16万元，新车提供120km和180km两种续航里程。用户将享受五重权益：用户线上下订交9.9元享1000元新能源汽车下乡电费补贴（免费开一年）的轻享轻行礼；增换购用户还可享1000元补贴（含低速电动车和电瓶车增换购）的轻享置换礼。此外，所有购车用户均可享1688元交车大礼包的轻享购车礼、首付3888元风光 MINIEV开回家的轻享金融礼，和购车免购置税上绿牌不限行的轻享免税礼。</p><p>3月8日，风光MINIEV(参数|询价)实尚款正式上市，新车共计推出3款车型，售价2.86-4.16万元，新车提供120km和180km两种续航里程。用户将享受五重权益：用户线上下订交9.9元享1000元新能源汽车下乡电费补贴（免费开一年）的轻享轻行礼；增换购用户还可享1000元补贴（含低速电动车和电瓶车增换购）的轻享置换礼。此外，所有购车用户均可享1688元交车大礼包的轻享购车礼、首付3888元风光 MINIEV开回家的轻享金融礼，和购车免购置税上绿牌不限行的轻享免税礼。</p><p>3月8日，风光MINIEV(参数|询价)实尚款正式上市，新车共计推出3款车型，售价2.86-4.16万元，新车提供120km和180km两种续航里程。用户将享受五重权益：用户线上下订交9.9元享1000元新能源汽车下乡电费补贴（免费开一年）的轻享轻行礼；增换购用户还可享1000元补贴（含低速电动车和电瓶车增换购）的轻享置换礼。此外，所有购车用户均可享1688元交车大礼包的轻享购车礼、首付3888元风光 MINIEV开回家的轻享金融礼，和购车免购置税上绿牌不限行的轻享免税礼。</p><p>3月8日，风光MINIEV(参数|询价)实尚款正式上市，新车共计推出3款车型，售价2.86-4.16万元，新车提供120km和180km两种续航里程。用户将享受五重权益：用户线上下订交9.9元享1000元新能源汽车下乡电费补贴（免费开一年）的轻享轻行礼；增换购用户还可享1000元补贴（含低速电动车和电瓶车增换购）的轻享置换礼。此外，所有购车用户均可享1688元交车大礼包的轻享购车礼、首付3888元风光 MINIEV开回家的轻享金融礼，和购车免购置税上绿牌不限行的轻享免税礼。</p><p>3月8日，风光MINIEV(参数|询价)实尚款正式上市，新车共计推出3款车型，售价2.86-4.16万元，新车提供120km和180km两种续航里程。用户将享受五重权益：用户线上下订交9.9元享1000元新能源汽车下乡电费补贴（免费开一年）的轻享轻行礼；增换购用户还可享1000元补贴（含低速电动车和电瓶车增换购）的轻享置换礼。此外，所有购车用户均可享1688元交车大礼包的轻享购车礼、首付3888元风光 MINIEV开回家的轻享金融礼，和购车免购置税上绿牌不限行的轻享免税礼。3月8日，风光MINIEV(参数|询价)实尚款正式上市，新车共计推出3款车型，售价2.86-4.16万元，新车提供120km和180km两种续航里程。用户将享受五重权益：用户线上下订交9.9元享1000元新能源汽车下乡电费补贴（免费开一年）的轻享轻行礼；增换购用户还可享1000元补贴（含低速电动车和电瓶车增换购）的轻享置换礼。此外，所有购车用户均可享1688元交车大礼包的轻享购车礼、首付3888元风光 MINIEV开回家的轻享金融礼，和购车免购置税上绿牌不限行的轻享免税礼。</p><p>3月8日，风光MINIEV(参数|询价)实尚款正式上市，新车共计推出3款车型，售价2.86-4.16万元，新车提供120km和180km两种续航里程。用户将享受五重权益：用户线上下订交9.9元享1000元新能源汽车下乡电费补贴（免费开一年）的轻享轻行礼；增换购用户还可享1000元补贴（含低速电动车和电瓶车增换购）的轻享置换礼。此外，所有购车用户均可享1688元交车大礼包的轻享购车礼、首付3888元风光 MINIEV开回家的轻享金融礼，和购车免购置税上绿牌不限行的轻享免税礼。</p><p>3月8日，风光MINIEV(参数|询价)实尚款正式上市，新车共计推出3款车型，售价2.86-4.16万元，新车提供120km和180km两种续航里程。用户将享受五重权益：用户线上下订交9.9元享1000元新能源汽车下乡电费补贴（免费开一年）的轻享轻行礼；增换购用户还可享1000元补贴（含低速电动车和电瓶车增换购）的轻享置换礼。此外，所有购车用户均可享1688元交车大礼包的轻享购车礼、首付3888元风光 MINIEV开回家的轻享金融礼，和购车免购置税上绿牌不限行的轻享免税礼。</p><p>3月8日，风光MINIEV(参数|询价)实尚款正式上市，新车共计推出3款车型，售价2.86-4.16万元，新车提供120km和180km两种续航里程。用户将享受五重权益：用户线上下订交9.9元享1000元新能源汽车下乡电费补贴（免费开一年）的轻享轻行礼；增换购用户还可享1000元补贴（含低速电动车和电瓶车增换购）的轻享置换礼。此外，所有购车用户均可享1688元交车大礼包的轻享购车礼、首付3888元风光 MINIEV开回家的轻享金融礼，和购车免购置税上绿牌不限行的轻享免税礼。</p>',2,'',2,1,2,2,2,1,2,'shou286416wanyuanfengguangminievshishangkuanshangshi','s286416wyfgminievsskss','风光MINIEV(参数|询价)实尚款正式上市，新车共计推出3款车型，售价2.86-4.16万元，新车提供120km和180km两种续航里程。'),(52,0,1,'售29.59万元起 新款奔驰GLB正式上市','','奔驰,GLB','/Static/images/n10.jpg','新华网','钱大帅',99,'','',1649561259,1649561173,3,0,0,0,'',1,0,0,1,'<p>　　外观方面，新车与现款车型相比区别不大，依旧采用多边形前格栅搭配双条幅中网设计，两侧大灯组造型较为方正，内部还配备了“L型”的日间行车灯，提升辨识度。此外，新车前包围采用了三分式的散热开口设计，包围中下部分的银色护板则为新车增添了一份力量感。　　外观方面，新车与现款车型相比区别不大，依旧采用多边形前格栅搭配双条幅中网设计，两侧大灯组造型较为方正，内部还配备了“L型”的日间行车灯，提升辨识度。此外，新车前包围采用了三分式的散热开口设计，包围中下部分的银色护板则为新车增添了一份力量感。</p><p>　　外观方面，新车与现款车型相比区别不大，依旧采用多边形前格栅搭配双条幅中网设计，两侧大灯组造型较为方正，内部还配备了“L型”的日间行车灯，提升辨识度。此外，新车前包围采用了三分式的散热开口设计，包围中下部分的银色护板则为新车增添了一份力量感。　　外观方面，新车与现款车型相比区别不大，依旧采用多边形前格栅搭配双条幅中网设计，两侧大灯组造型较为方正，内部还配备了“L型”的日间行车灯，提升辨识度。此外，新车前包围采用了三分式的散热开口设计，包围中下部分的银色护板则为新车增添了一份力量感。</p><p>　　外观方面，新车与现款车型相比区别不大，依旧采用多边形前格栅搭配双条幅中网设计，两侧大灯组造型较为方正，内部还配备了“L型”的日间行车灯，提升辨识度。此外，新车前包围采用了三分式的散热开口设计，包围中下部分的银色护板则为新车增添了一份力量感。</p><p>　　外观方面，新车与现款车型相比区别不大，依旧采用多边形前格栅搭配双条幅中网设计，两侧大灯组造型较为方正，内部还配备了“L型”的日间行车灯，提升辨识度。此外，新车前包围采用了三分式的散热开口设计，包围中下部分的银色护板则为新车增添了一份力量感。　　外观方面，新车与现款车型相比区别不大，依旧采用多边形前格栅搭配双条幅中网设计，两侧大灯组造型较为方正，内部还配备了“L型”的日间行车灯，提升辨识度。此外，新车前包围采用了三分式的散热开口设计，包围中下部分的银色护板则为新车增添了一份力量感。</p><p>　　外观方面，新车与现款车型相比区别不大，依旧采用多边形前格栅搭配双条幅中网设计，两侧大灯组造型较为方正，内部还配备了“L型”的日间行车灯，提升辨识度。此外，新车前包围采用了三分式的散热开口设计，包围中下部分的银色护板则为新车增添了一份力量感。　　外观方面，新车与现款车型相比区别不大，依旧采用多边形前格栅搭配双条幅中网设计，两侧大灯组造型较为方正，内部还配备了“L型”的日间行车灯，提升辨识度。此外，新车前包围采用了三分式的散热开口设计，包围中下部分的银色护板则为新车增添了一份力量感。</p><p>　　外观方面，新车与现款车型相比区别不大，依旧采用多边形前格栅搭配双条幅中网设计，两侧大灯组造型较为方正，内部还配备了“L型”的日间行车灯，提升辨识度。此外，新车前包围采用了三分式的散热开口设计，包围中下部分的银色护板则为新车增添了一份力量感。</p><p>　　外观方面，新车与现款车型相比区别不大，依旧采用多边形前格栅搭配双条幅中网设计，两侧大灯组造型较为方正，内部还配备了“L型”的日间行车灯，提升辨识度。此外，新车前包围采用了三分式的散热开口设计，包围中下部分的银色护板则为新车增添了一份力量感。　　外观方面，新车与现款车型相比区别不大，依旧采用多边形前格栅搭配双条幅中网设计，两侧大灯组造型较为方正，内部还配备了“L型”的日间行车灯，提升辨识度。此外，新车前包围采用了三分式的散热开口设计，包围中下部分的银色护板则为新车增添了一份力量感。</p><p>　　外观方面，新车与现款车型相比区别不大，依旧采用多边形前格栅搭配双条幅中网设计，两侧大灯组造型较为方正，内部还配备了“L型”的日间行车灯，提升辨识度。此外，新车前包围采用了三分式的散热开口设计，包围中下部分的银色护板则为新车增添了一份力量感。　　外观方面，新车与现款车型相比区别不大，依旧采用多边形前格栅搭配双条幅中网设计，两侧大灯组造型较为方正，内部还配备了“L型”的日间行车灯，提升辨识度。此外，新车前包围采用了三分式的散热开口设计，包围中下部分的银色护板则为新车增添了一份力量感。</p><p>　　外观方面，新车与现款车型相比区别不大，依旧采用多边形前格栅搭配双条幅中网设计，两侧大灯组造型较为方正，内部还配备了“L型”的日间行车灯，提升辨识度。此外，新车前包围采用了三分式的散热开口设计，包围中下部分的银色护板则为新车增添了一份力量感。</p>',2,'',2,1,2,2,2,1,2,'shou2959wanyuanqixinkuanbenchiglbzhengshishangshi','s2959wyqxkbcglbzsss','我们从奔驰官方获悉，旗下新款GLB车型正式上市，新车共推出5款车型，售价区间为29.59-35.33万元，新车在动力以及配置方面进行了升级优化。'),(53,0,1,'售11.58万元起 五菱凯捷280T正式上市','','五菱,凯捷280T','/Static/images/n11.jpg','新华网','钱大帅',99,'','',1649561399,1649561332,0,0,0,0,'',1,0,0,1,'<p>2022年2月22日夜，上汽通用五菱旗下紧凑型MPV车型<a href=\"https://www.autohome.com.cn/5772/\">五菱凯捷</a>(<a href=\"https://car.autohome.com.cn/config/series/5772.html\">参数</a>|<a href=\"https://leads.autohome.com.cn/landingpage/views/pc/pcInquiry/id_10001344/channelid_29/?seriesid=5772&amp;eid=1|1|37|3|203736|302100\">询价</a>)280T在上海正式上市，新车为高功率版车型，动力表现更上一层楼。此次推出的280T车型共有2个配置版本可选，<strong>指导价区间为11.58-12.58万元</strong>。现在购车厂家还提供3年0息/低息超长贷、至高补贴6000元/台、至高3000元置换补贴等礼包方案</p><p>&nbsp;</p><p>　　在发布会现场，五菱线下体验重心Ling HOUSE、用户线上社交阵地LING Club、开放智能生态系统Ling OS和全新动力品牌Ling POWER也正式发布，五菱首个用户LING感基地将于崇礼建设。另外，据官方透露，五菱还将推出一款面向全球战略的宏光MINIEV。</p><p><strong>● 外观和内饰简介：</strong></p><p>　　高功率版五菱凯捷仍然沿用了此前“翼动美学”的设计理念，其所大量运用的凌厉线条给人的视觉效果是较为出众的，尤其是前脸的造型设计，给人一种犀利动感的风格。车身尺寸方面，新款车型没有变化，其长宽高分别为4875/1880/1700mm，轴距为2800mm。</p><p>2022年2月22日夜，上汽通用五菱旗下紧凑型MPV车型<a href=\"https://www.autohome.com.cn/5772/\">五菱凯捷</a>(<a href=\"https://car.autohome.com.cn/config/series/5772.html\">参数</a>|<a href=\"https://leads.autohome.com.cn/landingpage/views/pc/pcInquiry/id_10001344/channelid_29/?seriesid=5772&amp;eid=1|1|37|3|203736|302100\">询价</a>)280T在上海正式上市，新车为高功率版车型，动力表现更上一层楼。此次推出的280T车型共有2个配置版本可选，<strong>指导价区间为11.58-12.58万元</strong>。现在购车厂家还提供3年0息/低息超长贷、至高补贴6000元/台、至高3000元置换补贴等礼包方案</p><p>&nbsp;</p><p>　　在发布会现场，五菱线下体验重心Ling HOUSE、用户线上社交阵地LING Club、开放智能生态系统Ling OS和全新动力品牌Ling POWER也正式发布，五菱首个用户LING感基地将于崇礼建设。另外，据官方透露，五菱还将推出一款面向全球战略的宏光MINIEV。</p><p><strong>● 外观和内饰简介：</strong></p><p>　　高功率版五菱凯捷仍然沿用了此前“翼动美学”的设计理念，其所大量运用的凌厉线条给人的视觉效果是较为出众的，尤其是前脸的造型设计，给人一种犀利动感的风格。车身尺寸方面，新款车型没有变化，其长宽高分别为4875/1880/1700mm，轴距为2800mm。</p><p>2022年2月22日夜，上汽通用五菱旗下紧凑型MPV车型<a href=\"https://www.autohome.com.cn/5772/\">五菱凯捷</a>(<a href=\"https://car.autohome.com.cn/config/series/5772.html\">参数</a>|<a href=\"https://leads.autohome.com.cn/landingpage/views/pc/pcInquiry/id_10001344/channelid_29/?seriesid=5772&amp;eid=1|1|37|3|203736|302100\">询价</a>)280T在上海正式上市，新车为高功率版车型，动力表现更上一层楼。此次推出的280T车型共有2个配置版本可选，<strong>指导价区间为11.58-12.58万元</strong>。现在购车厂家还提供3年0息/低息超长贷、至高补贴6000元/台、至高3000元置换补贴等礼包方案</p><p>&nbsp;</p><p>　　在发布会现场，五菱线下体验重心Ling HOUSE、用户线上社交阵地LING Club、开放智能生态系统Ling OS和全新动力品牌Ling POWER也正式发布，五菱首个用户LING感基地将于崇礼建设。另外，据官方透露，五菱还将推出一款面向全球战略的宏光MINIEV。</p><p><strong>● 外观和内饰简介：</strong></p><p>　　高功率版五菱凯捷仍然沿用了此前“翼动美学”的设计理念，其所大量运用的凌厉线条给人的视觉效果是较为出众的，尤其是前脸的造型设计，给人一种犀利动感的风格。车身尺寸方面，新款车型没有变化，其长宽高分别为4875/1880/1700mm，轴距为2800mm。</p>',2,'',2,1,2,2,2,1,2,'shou1158wanyuanqiwulingkaijie280tzhengshishangshi','s1158wyqwlkj280tzsss','上汽通用五菱旗下紧凑型MPV车型五菱凯捷(参数|询价)280T在上海正式上市，新车为高功率版车型，动力表现更上一层楼。此次推出的280T车型共有2个配置版本可选，指导价区间为11.58-12.58万元。'),(54,0,1,'售248万元起 宾利飞驰2022款车型售价','','宾利,飞驰','/Static/images/n12.jpg','新华网','钱大帅',99,'','',1649561557,1649561432,40,0,0,0,'',1,0,0,1,'<p>宾利针对飞驰系列进行了产品扩充，此前曾在广州车展上亮相的飞驰Mulliner和飞驰PHEV车型也正式上市。其中飞驰Mulliner同样拥有V8、W12以及PHEV三种动力版本,同样在去年广州车展上亮相的添越S也公布价格为313.6万元，欧陆GT系列将在国内市场扩充为8款车型，依旧提供陈真4.0T V8发动机以及6.0T W12发动机，每种动力都拥有硬顶以及敞篷版车型，同时这4款车型也都分别提供了Mulliner定制版，共凑成8款车型。</p><p>宾利针对飞驰系列进行了产品扩充，此前曾在广州车展上亮相的飞驰Mulliner和飞驰PHEV车型也正式上市。其中飞驰Mulliner同样拥有V8、W12以及PHEV三种动力版本,同样在去年广州车展上亮相的添越S也公布价格为313.6万元，欧陆GT系列将在国内市场扩充为8款车型，依旧提供4.0T V8发动机以及6.0T W12发动机，每种动力都拥有硬顶以及敞篷版车型，同时这4款车型也都分别提供了Mulliner定制版，共凑成8款车型。</p><p>宾利针对飞驰系列进行了产品扩充，此前曾在广州车展上亮相的飞驰Mulliner和飞驰PHEV车型也正式上市。其中飞驰Mulliner同样拥有V8、W12以及PHEV三种动力版本,同样在去年广州车展上亮相的添越S也公布价格为313.6万元，欧陆GT系列将在国内市场扩充为8款车型，依旧提供4.0T V8发动机以及6.0T W12发动机，每种动力都拥有硬顶以及敞篷版车型，同时这4款车型也都分别提供了Mulliner定制版，共凑成8款车型。宾利针对飞驰系列进行了产品扩充，此前曾在广州车展上亮相的飞驰Mulliner和飞驰PHEV车型也正式上市。其中飞驰Mulliner同样拥有V8、W12以及PHEV三种动力版本,同样在去年广州车展上亮相的添越S也公布价格为313.6万元，欧陆GT系列将在国内市场扩充为8款车型，依旧提供4.0T V8发动机以及6.0T W12发动机，每种动力都拥有硬顶以及敞篷版车型，同时这4款车型也都分别提供了Mulliner定制版，共凑成8款车型。</p><p>宾利针对飞驰系列进行了产品扩充，此前曾在广州车展上亮相的飞驰Mulliner和飞驰PHEV车型也正式上市。其中飞驰Mulliner同样拥有V8、W12以及PHEV三种动力版本,同样在去年广州车展上亮相的添越S也公布价格为313.6万元，欧陆GT系列将在国内市场扩充为8款车型，依旧提供4.0T V8发动机以及6.0T W12发动机，每种动力都拥有硬顶以及敞篷版车型，同时这4款车型也都分别提供了Mulliner定制版，共凑成8款车型。宾利针对飞驰系列进行了产品扩充，此前曾在广州车展上亮相的飞驰Mulliner和飞驰PHEV车型也正式上市。其中飞驰Mulliner同样拥有V8、W12以及PHEV三种动力版本,同样在去年广州车展上亮相的添越S也公布价格为313.6万元，欧陆GT系列将在国内市场扩充为8款车型，依旧提供4.0T V8发动机以及6.0T W12发动机，每种动力都拥有硬顶以及敞篷版车型，同时这4款车型也都分别提供了Mulliner定制版，共凑成8款车型。</p><p>宾利针对飞驰系列进行了产品扩充，此前曾在广州车展上亮相的飞驰Mulliner和飞驰PHEV车型也正式上市。其中飞驰Mulliner同样拥有V8、W12以及PHEV三种动力版本,同样在去年广州车展上亮相的添越S也公布价格为313.6万元，欧陆GT系列将在国内市场扩充为8款车型，依旧提供4.0T V8发动机以及6.0T W12发动机，每种动力都拥有硬顶以及敞篷版车型，同时这4款车型也都分别提供了Mulliner定制版，共凑成8款车型。</p><p>宾利针对飞驰系列进行了产品扩充，此前曾在广州车展上亮相的飞驰Mulliner和飞驰PHEV车型也正式上市。其中飞驰Mulliner同样拥有V8、W12以及PHEV三种动力版本,同样在去年广州车展上亮相的添越S也公布价格为313.6万元，欧陆GT系列将在国内市场扩充为8款车型，依旧提供4.0T V8发动机以及6.0T W12发动机，每种动力都拥有硬顶以及敞篷版车型，同时这4款车型也都分别提供了Mulliner定制版，共凑成8款车型。</p>',2,'',2,1,2,2,2,1,2,'shou248wanyuanqibinlifeichi2022kuanchexingshoujia','s248wyqblfc2022kcxsj','宾利针对飞驰系列进行了产品扩充，此前曾在广州车展上亮相的飞驰Mulliner和飞驰PHEV车型也正式上市。其中飞驰Mulliner同样拥有V8、W12以及PHEV三种动力版本');

#
# Structure for table "qc_table_down"
#

DROP TABLE IF EXISTS `qc_table_down`;
CREATE TABLE `qc_table_down` (
  `Id` bigint(20) NOT NULL DEFAULT '0',
  `ModelId` int(11) NOT NULL DEFAULT '0',
  `CateId` int(11) NOT NULL DEFAULT '0',
  `Title` varchar(100) NOT NULL DEFAULT '',
  `STitle` varchar(60) NOT NULL DEFAULT '' COMMENT '短标题',
  `Tag` varchar(100) NOT NULL DEFAULT '' COMMENT 'Tag',
  `Pic` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `Source` varchar(50) NOT NULL DEFAULT '' COMMENT '来源',
  `Author` varchar(50) NOT NULL DEFAULT '' COMMENT '作者',
  `Sort` tinyint(3) NOT NULL DEFAULT '99',
  `Keywords` varchar(255) NOT NULL DEFAULT '',
  `Description` varchar(255) NOT NULL DEFAULT '',
  `TsAdd` bigint(20) NOT NULL DEFAULT '0',
  `TsUpdate` bigint(20) NOT NULL DEFAULT '0',
  `ReadNum` int(11) NOT NULL DEFAULT '0',
  `Coins` int(11) NOT NULL DEFAULT '0' COMMENT '需消费金币',
  `Money` int(11) NOT NULL DEFAULT '0' COMMENT '支付费用',
  `UserLevel` int(11) NOT NULL DEFAULT '0' COMMENT '浏览权限',
  `Color` varchar(10) NOT NULL DEFAULT '' COMMENT '颜色',
  `UserId` bigint(20) NOT NULL DEFAULT '0',
  `Good` int(11) NOT NULL DEFAULT '0',
  `Bad` int(11) NOT NULL DEFAULT '0',
  `State` tinyint(3) NOT NULL DEFAULT '1',
  `Content` text,
  `IsLink` tinyint(3) NOT NULL DEFAULT '2',
  `LinkUrl` varchar(255) NOT NULL DEFAULT '' COMMENT '外链地址',
  `IsBold` tinyint(3) NOT NULL DEFAULT '2',
  `IsPic` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否有缩略图',
  `IsSpuerRec` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否特推',
  `IsHeadlines` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否头条',
  `IsRec` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否推荐',
  `IsPost` tinyint(3) NOT NULL DEFAULT '1' COMMENT '允许评论',
  `IsDelete` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否删除',
  `PinYin` varchar(255) NOT NULL DEFAULT '',
  `PY` varchar(255) NOT NULL DEFAULT '',
  `Summary` varchar(255) DEFAULT '' COMMENT '摘要',
  `Size` varchar(255) NOT NULL DEFAULT '' COMMENT '软件大小',
  `Lang` varchar(255) NOT NULL DEFAULT '' COMMENT '软件语言',
  `Level` varchar(255) NOT NULL DEFAULT '' COMMENT '软件评级',
  `Company` varchar(255) NOT NULL DEFAULT '' COMMENT '软件厂商',
  `Auth` varchar(255) NOT NULL DEFAULT '' COMMENT '软件授权',
  `Platform` varchar(255) NOT NULL DEFAULT '' COMMENT '应用平台',
  `WebSite` varchar(255) NOT NULL DEFAULT '' COMMENT '官方网站',
  `Address` varchar(255) NOT NULL DEFAULT '' COMMENT '下载地址',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "qc_table_down"
#

INSERT INTO `qc_table_down` VALUES (43,0,24,'Adobe Photoshop 2021版本v22.0.0.1012','100%开源、自主研发、功能强大','Adobe,Photoshop','/Static/images/ps.png','','',99,'','',1649419838,1649419826,1,0,0,0,'',1,0,0,1,'<h3><strong>Photoshop 2021软件特色</strong></h3><p>1、支撑多种图画格局</p><p>Photoshop支撑的图画的图画格局包含PSD,EPS,DCS,TIF,JEPG,BMP,PCX,FLM,PDF,PICT,GIF,PNG,IFF,FPX,RAW和SCT等多种,运用Photoshop能够将某种格局的图画另存为别的格局,以到达特别的需要。</p><p>2、支撑多种色彩形式</p><p>Photoshop支撑的色彩形式包含位图形式、灰度形式、RBG形式、CMYK形式、Lab形式、索引色彩形式、双色调形式和多通道形式等，而且能够完成各种形式这间的变换，另外，运用Photoshop还能够恣意调整图画的尺度，分辨率及布巨细，既能够在不影响分辨率的情况下图画尺度，又能够在不影响图画尺度的情况下增减分辨率。</p><p>3、供给了强壮的挑选图画规模的功用</p><p>运用矩形，椭圆面罩和套取东西，能够挑选一个或多个不一样尺度，形状的挑选规模磁性大过东西能够根据挑选边缘的像素反差，使挑选规模紧贴要挑选的图画，运用戏法棒东西或色彩规模指令能够根据色彩来自动挑选所要有些，合作多种快捷键的运用，能够完成挑选规模的相加，相减和反选等作用。</p><p>4、能够对图画进行各种修改</p><p>如移动、仿制、张贴、剪切、铲除等，如果在修改时出了过错，还能够进行无限次吊销和康复，Photoshop还能够对图画进行恣意的旋转和变形，例如按固定方向翻转或旋转。</p><p>5、能够对图画进行色谐和色彩的调整</p><p>使色相，饱和度、亮度、对比度的调整变得简略简单，Photoshop能够独自对某一挑选规模进行调整，也能够对某一种选定色彩进行调整，运用色彩平衡倒序能够在彩色图画中改动色彩的混合，运用色阶和曲线指令能够别离对图画的高光，暗谐和中心调有些进行调整,这是传统的绘画窍门难以到达的作用。</p><p>6、供给了绘画功用</p><p>运用喷枪东西，笔刷东西、铅笔东西，直线东西，能够制造各种图形，经过自行设定的笔刷形状，巨细和压力，能够创立不一样的笔刷作用，运用突变东西能够产生多种突变作用，加深和减淡东西能够有挑选地改动图画的暴光度。</p><p>7.、运用Photoshop用户能够树立图层</p><p>布景层、文本层、调理层等多种图层，而且方便地对各个图层进行修改，用户能够对图层进行恣意的仿制、移动、 删去、翻转、兼并和组成，能够完成图层的摆放，还能够应用添加暗影等操作制造特技作用，调整图层可在不影响图画的一起，操控图层的透明度和饱和度等图画作用，文本层能够随时修改图画中的文本，用户还能够对不一样的色彩通道别离进行修改，运用蒙版能够精确地挑选规模,进行存储和载入操作。</p><p>8、Photoshop共供给了快到100种的滤镜</p><p>每种滤镜各不相同，用户能够运用这些滤镜完成各种特别作用，如运用风滤镜能够添加图画动感，运用浮雕滤镜呆以制造浮雕作用等。</p>',2,'',2,1,2,2,2,1,2,'adobephotoshop2021banbenv22001012','adobephotoshop2021bbv22001012','Photoshop 2021，超级无敌的官方图像修改器PS最新2021版本上市了，相信大家都已经看过了adobe之前公布的那段充满创意的广告视频，最新版Photoshop 2021将会为用户们带来更加舒适的操作体验，更多有趣的图像处理功能。','174.91MB','简体中文','5','某科技公司','免费软件','WinAll','http://www.q-cms.cn/','https://dldir1.qq.com/weixin/Windows/WeChatSetup.exe'),(79,0,24,'VMware WorkstationV15.5.6.16341506 官方中文正式版','100%开源、自主研发、功能强大','VMware,虚拟机','/Static/images/vm.png','','',99,'','',1649682358,1649682258,0,0,0,0,'',1,0,0,1,'<p>VMware Workstation 10.0.1正式发布，版本号为Build 1379776。这是WMware 10.0的维护版本，解决了一些已知的问题，所有VMware 10.0用户均可免费升级。</p><p>VMware Workstation 10 新增功能：<br>– 可以将Windows 8.1物理PC转变为虚拟机；Unity模式增强，与Windows 8.1 UI更改无缝配合工作；<br>– 加强控制，虚拟机将以指定的时间间隔查询服务器，从而将受限虚拟机的策略文件中的当前系统时间存储为最后受信任的时间戳；<br>– 在平板电脑运行时可以利用加速计、陀螺仪、罗盘以及环境光线传感器；<br>– 支持多达16个虚拟CPU、8 TB SATA磁盘和64 GB RAM；<br>– 新的虚拟SATA磁盘控制器；<br>– 现在支持20个虚拟网络；<br>– USB3流支持更快的文件复制；<br>– 改进型应用和Windows虚拟机启动时间；<br>– 固态磁盘直通；<br>– 增加多监视设置；<br>– VMware-KVM 提供了使用多个虚拟机的新界面。</p><p>v10.0：</p><p>1.最大支持虚拟16个CPU。<br>2.可以虚拟容量为2T的磁盘。<br>3.虚拟磁盘除了IDE和SCSI还支持SATA;<br>4.更好的支持USB3.0;<br>5.SSD穿透技术等等。<br>v9.0.2:<br>VMware9.0.2是一个维护版本，解决了一些已知的问题。所有的VMware Workstation 8用户可以免费升级。<br>v9.0.1:<br>&nbsp;</p><p>支持Ubuntu 12.10，解决的主要问题有修复了一些安全漏洞同时更新了三方插件，并且对于 Visual Studio 2012的插件已更新等等.</p>',2,'',2,1,2,2,2,1,2,'vmwareworkstationv155616341506guanfangzhongwenzhengshiban','vmwareworkstationv155616341506gfzwzsb','VMware是全球台式电脑及资料中心虚拟化解决方案的领导厂商。VMWare Workstation是该公司出品的“虚拟 PC”软件（即：大家常说的“虚拟机”），通过它可在一台电脑上同时运行更多的Microsoft Windows、Linux、Mac OS X、DOS系统。自 9.0.0 Build 812388开始，支持对于 Windows 8 的安装。','174.91MB','简体中文','5','某科技公司','免费软件','WinAll','http://www.q-cms.cn/','https://dldir1.qq.com/weixin/Windows/WeChatSetup.exe'),(80,0,24,'FileZilla(多线程ftp客户端)v3.57.0 官方简体中文版','100%开源、自主研发、功能强大','FileZilla,ftp客户端','/Static/images/fileZilla.png','','',99,'','',1649683605,1649683415,0,0,0,0,'',1,0,0,1,'<h3><strong>主要特点：</strong></h3><p>断点续传 (如果服务器支持)<br>· 自定义命令<br>· 站点管理<br>· 保存活动连接<br>· 暂检测连接超时<br>· 防火墙支持<br>· SOCKS4/5 和 HTTP1.1 代理支持<br>· SSL 安全连接<br>· SFTP 支持<br>· 上传/下载队列管理<br>· 支持文件拖放<br>· 多语言支持<br>· GSS 证明和Kerberos密码技术</p><h3><strong>filezilla中文乱码解决方案：</strong></h3><p>使用Filezilla client FTP客户端登陆某些FTP站点会出现中文乱码,原因是FTP服务器端编码与filezilla client端编码不一致造成的。<br>解决方法如下：<br>文件-站点管理-选中要登陆的站点-字符集-选择”强制UTF-8″ 或使用自定义字符集GB2312,二者之一定能解决中文显示乱码的问题。</p>',2,'',2,1,2,2,2,1,2,'filezilladuoxianchengftpkehuduanv3570guanfangjiantizhongwenban','filezilladxcftpkhdv3570gfjtzwb','FileZilla是一个快速，实用多功能和界面直观的FTP客户端。FileZilla 是一个免费的 FTP 客户端软件，虽然FileZilla中文版是免费软件，可功能却一点也不含糊，比起那些共享软件来有过之而无不及，在新的版本中作者改进了手动下载的界面和功能等，不过该软件暂时还是不支持断点续传功能。','174.91MB','简体中文','5','某科技公司','免费软件','WinAll','http://www.q-cms.cn/','https://dldir1.qq.com/weixin/Windows/WeChatSetup.exe'),(81,0,24,'腾讯QQ 9.5.9.28650 正式版','100%开源、自主研发、功能强大','腾讯,QQ','/Static/images/qq.png','','',99,'','',1649684688,1649684433,0,0,0,0,'',1,0,0,1,'<p>更新日志：</p><p>优化了部分体验问题，提升版本稳定性和使用体验。<br>&nbsp;</p><p>软件特色：</p><p>腾讯QQ2019通过云能力，让数据在不同的终端设备、不同的使用场景间无缝流动，竭力提供跨终端无缝体验。不用到处寻找腾讯QQ2019最新版官方下载了！腾讯QQ不仅仅是单纯意义的网络虚拟呼机，而是一种超高效的实用型即时通信工具！腾讯QQ2019的用户量已经超过了8亿人，在腾讯QQ上您可以进行，免费视频聊天交友、语音通话以及收发重要文件。欢迎进行腾讯QQ下载安装。</p><p>更新日志：</p><p>优化了部分体验问题，提升版本稳定性和使用体验。<br>&nbsp;</p><p>软件特色：</p><p>腾讯QQ2019通过云能力，让数据在不同的终端设备、不同的使用场景间无缝流动，竭力提供跨终端无缝体验。不用到处寻找腾讯QQ2019最新版官方下载了！腾讯QQ不仅仅是单纯意义的网络虚拟呼机，而是一种超高效的实用型即时通信工具！腾讯QQ2019的用户量已经超过了8亿人，在腾讯QQ上您可以进行，免费视频聊天交友、语音通话以及收发重要文件。欢迎进行腾讯QQ下载安装。</p><p>更新日志：</p><p>优化了部分体验问题，提升版本稳定性和使用体验。<br>&nbsp;</p><p>软件特色：</p><p>腾讯QQ2019通过云能力，让数据在不同的终端设备、不同的使用场景间无缝流动，竭力提供跨终端无缝体验。不用到处寻找腾讯QQ2019最新版官方下载了！腾讯QQ不仅仅是单纯意义的网络虚拟呼机，而是一种超高效的实用型即时通信工具！腾讯QQ2019的用户量已经超过了8亿人，在腾讯QQ上您可以进行，免费视频聊天交友、语音通话以及收发重要文件。欢迎进行腾讯QQ下载安装。</p><p>更新日志：</p><p>优化了部分体验问题，提升版本稳定性和使用体验。<br>&nbsp;</p><p>软件特色：</p><p>腾讯QQ2019通过云能力，让数据在不同的终端设备、不同的使用场景间无缝流动，竭力提供跨终端无缝体验。不用到处寻找腾讯QQ2019最新版官方下载了！腾讯QQ不仅仅是单纯意义的网络虚拟呼机，而是一种超高效的实用型即时通信工具！腾讯QQ2019的用户量已经超过了8亿人，在腾讯QQ上您可以进行，免费视频聊天交友、语音通话以及收发重要文件。欢迎进行腾讯QQ下载安装。</p>',2,'',2,1,2,2,2,1,2,'tengxunqq95928650zhengshiban','txqq95928650zsb','腾讯QQ的用户已经超过九亿人。如此热门的qq最新版本拥有在线文字，语音，视频聊天的功能以及办公必备的点对点断点文件续传、文件共享、文件离线传送，云存储。腾讯QQ还有邮箱功能，自定义面板等多种功能。','174.91MB','简体中文','5','某科技公司','免费软件','WinAll','http://www.q-cms.cn/','https://dldir1.qq.com/weixin/Windows/WeChatSetup.exe'),(82,0,24,'Chrome 99.0.4844.51 官方正式版','100%开源、自主研发、功能强大','谷歌,Chrome','/Static/images/chrome.jpg','','',99,'','',1649684770,1649684715,1,0,0,0,'',1,0,0,1,'<p>软件特色：</p><p>1、新版谷歌Chrome浏览器使用了额外的Loader，配置文件与程序文件被安置在同一个文件夹，适合U盘携带，或者经常重装的人群。</p><p>&nbsp;</p><p>2、用户可将谷歌Chrome浏览器设置为默认浏览器。设置之后不论在什么地方调用浏览器都不会出现丢失设置的情况。值得注意的是，用户设置默认浏览器之后，程序所在文件夹不能改名或者删除；</p><p>&nbsp;</p><p>3、新版谷歌Chrome浏览器对配置进行了优化：添加了一些常用的浏览器插件。其中一部分插件=是默认停用的，用户可视需要随时启用。</p><p>&nbsp;</p><p>4、新版谷歌Chrome浏览器新增了一个批处理文件“清除所有个人信息与自定义设置。bat”，能够快速的将所有此浏览器的浏览记录以及个人信息删除。以便重新定制并分发给其他用户。</p><p>&nbsp;</p><p>5、浏览器Loader使用c语言编写，从而减少垃圾文件产生以及资源占用。</p>',2,'',2,1,2,2,2,1,2,'chrome990484451guanfangzhengshiban','chrome990484451gfzsb','Google Chrome是基于更强大的JavaScript V8引擎极强高效超快的浏览器，google chrome是一款可让您更快速、轻松且安全地使用网络的浏览器。','174.91MB','简体中文','5','某科技公司','免费软件','WinAll','http://www.q-cms.cn/','https://dldir1.qq.com/weixin/Windows/WeChatSetup.exe'),(83,0,24,'Visual Studio Code 1.63.2.0 官方版','100%开源、自主研发、功能强大','vscode,微软','/Static/images/vscode.jpg','','',99,'','',1649684879,1649684831,0,0,0,0,'',1,0,0,1,'<p>功能介绍：</p><p>符合智能感知。</p><p>超越语法高亮和自动完成与智能感知，VsCode提供了基于变量类型，函数定义，并导入模块智能完成。</p><p>打印语句调试已成为过去。<br>&nbsp;</p><p>从编辑器直接调试代码。 启动或附加到正在运行的应用程序，并使用断点，调用堆栈和交互式控制台进行调试。</p><p>内置 Git 命令。<br>&nbsp;</p><p>与 Git 和其他 SCM 提供商合作从未如此简单。 从VsCode编辑器中直接查看差异，阶段文件和提交。 从任何托管的 SCM 服务推送和拉取。</p><p>可扩展和可定制。<br>&nbsp;</p><p>想要更多功能吗? 安装扩展以添加新语言，主题，调试程序以及连接到其他服务。 扩展程序在不同的进程中运行，确保它们不会减慢编辑器的速度。</p><p>以 JavaScript 为代表，过去我们调试 JS 的时候，需要使用<a href=\"https://dl.pconline.com.cn/sort/104.html\">浏览器</a> F12，代码上面需要利用 console.log 或 alert 对过程进行输出，习惯了例如 VS 编译器的开发人员会比较不习惯。如今可以使用 VS Code 进行开发，它开源免费，通过安装开发语言相关的插件，可以让VS Code实现相应的语法识别和代码提示，目前拓展商店已经提供了大多数编程语言的插件，可以随便下载，常用有 Script 有 JScript、EScript ,以及包括 PHP，Python 等其它语言。</p>',2,'',2,1,2,2,2,1,2,'visualstudiocode16320guanfangban','visualstudiocode16320gfb','Visual Studio Code中文版是一款可以编译web应用程序的软件，该软件主要集成与Visual Studio 软件中，使用的方式与VS有一定的类似，其主要的特色是拥有一个强大的调试器很大帮助程序员提高代码的编辑速度，减少输入代码进行循环调试等时间；','174.91MB','简体中文','5','某科技公司','免费软件','WinAll','http://www.q-cms.cn/','https://dldir1.qq.com/weixin/Windows/WeChatSetup.exe'),(84,0,24,'迅雷7 7.9.44.5056 官方正式版','100%开源、自主研发、功能强大','迅雷','/Static/images/xl.jpg','','',99,'','',1649685712,1649685670,0,0,0,0,'',1,0,0,1,'<p>迅雷7是使用超线程高速下载技术的免费下载工具。迅雷7做了特别的无限制高速通道下载优化。迅雷7官方版使用基于网格原理的先进超线程技术。迅雷7能够将存在于第三方服务器和计算机上的数据文件进行有效整合。迅雷7通过这种先进的超线程技术，用户能够以更快的速度从第三方服务器和计算机获取所需的数据文件。另外、用户在电脑上可能安装了各种安全卫士、系统优化类的软件，但是其不能解决下载遇到的问题。而在迅雷7官方下载正式版中，针对这一情况，专门提供了一款名为迅雷下载的诊断工具。其会自动检测迅雷7在下载过程中遇到的各种问题，比如：主程序验证，兼容，并以问题报告的显示告诉用户哪里出现问题。这为出现不明问题的用户提供了一个更好的解决方法。迅雷7还新增加了智能换肤、多通道加速下载、便捷网络检测修复和快速启动轻捷操作等全新功能。迅雷7还在UI界面和性能上有了巨大的改进和提升。并与迅雷会员衔接，打造全新的下载体验。</p>',2,'',2,1,2,2,2,1,2,'xunlei779445056guanfangzhengshiban','xl779445056gfzsb','迅雷7是使用超线程高速下载技术的免费下载工具。迅雷7做了特别的无限制高速通道下载优化。迅雷7官方版使用基于网格原理的先进超线程技术。','174.91MB','简体中文','5','某科技公司','免费软件','WinAll','http://www.q-cms.cn/','https://dldir1.qq.com/weixin/Windows/WeChatSetup.exe'),(85,0,24,'WPS 11.1.0.10495 最新版','100%开源、自主研发、功能强大','wps,office','/Static/images/wps.jpg','','',99,'','',1649685778,1649685744,0,0,0,0,'',1,0,0,1,'<p>功能介绍：</p><p><strong>WPS Office 2019个人版新增功能：</strong><br>&nbsp;</p><p><strong>1、组合整件</strong><br>&nbsp;</p><p>WPS各类文档打开更快捷。</p><p><strong>2、一个账号，随心访问</strong></p><p>一个账号多平台访问，有了WPS Office随时随地恢复办公。</p><p><strong>3、wps office全面支持PDF</strong></p><p>WPS阅读pdf文件更快捷</p><p><strong>4、标签可拖拽成窗</strong></p><p>管理更高效。</p><p><strong>5、全新视觉，个性化WPS</strong></p><p>WPS Office全新窗口背景视觉优化，可自定义界面字体，个性化WPS。</p><p><strong>6、工作区</strong></p><p>方便用户快速在不同标签进行切换。</p><p>&nbsp;</p><p>软件特色：</p><p>1、WPS Office模仿浏览器样式，多标签式文档打开方式，可以在标签里轻松切换，很是方便。</p><p>2、WPS可以轻松的制作PDF文件，文档直接转换PDF，不再需要额外下载pdf编辑器。</p><p>3、多平台支持，体积小，内存占用低。已推出WPS小程序。</p><p>4、WPS Office免费提供海量在线储蓄空间以及文档模板，在这方面金山做的越来越好。</p><p>5、金山WPS Office移动版完美支持多种文档格式，如doc.docx.wps.xls.xlsx.et.ppt.dps.pptx和txt文档的查看及编辑。</p><p>6、wps支持创建各种表单，比如通讯录收集表，订单统计表等。</p>',2,'',2,1,2,2,2,1,2,'wps111010495zuixinban','wps111010495zxb','WPS Office个人版是WPS官方首发的免费国产办公软件。WPS Office包含word文字、excel表格、ppt演示等功能。','174.91MB','简体中文','5','某科技公司','免费软件','WinAll','http://www.q-cms.cn/','https://dldir1.qq.com/weixin/Windows/WeChatSetup.exe'),(86,0,24,'爱奇艺 8.12.147.5525 官方正式版','100%开源、自主研发、功能强大','爱奇艺','/Static/images/qiy.jpg','','',99,'','',1649685856,1649685802,0,0,0,0,'',1,0,0,1,'<p>爱奇艺播放器官方下载电脑版是一款目前受网友喜欢，专注于为用户提供视频播放的客户端软件，爱奇艺播放器官方一直通过持续不断的技术精细研发、产品持续性根据用户需求而创新，力求为用户提供国内极其流畅清晰、界面友好的视觉体验。爱奇艺播放器官方下载电脑版始终以“用户体验”为生命，您可运行爱奇艺影音播放器，在线享受奇艺网站内全部免费高清正版视频。太平洋下载中心提供爱奇艺播放器官方下载。</p><p>&nbsp;</p><p>更新日志：</p><p>1.精彩剧集更新不断，超前付费解锁大结局</p><p>2.看视频赚积分，更多活动等你来参加</p><p>&nbsp;</p><p>功能介绍：</p><p>免费使用：爱奇艺安装免费，免费观看高清正版影视<br>&nbsp;</p><p>内容丰富：最新影视、最热综艺、旅游、纪录片，支持奇艺网全部内容</p>',2,'',2,1,2,2,2,1,2,'aiqiyi8121475525guanfangzhengshiban','aqy8121475525gfzsb','爱奇艺播放器官方下载电脑版是一款目前受网友喜欢，专注于为用户提供视频播放的客户端软件，爱奇艺播放器官方一直通过持续不断的技术精细研发、产品持续性根据用户需求而创新，力求为用户提供国内极其流畅清晰、界面友好的视觉体验。','174.91MB','简体中文','5','某科技公司','免费软件','WinAll','http://www.q-cms.cn/','https://dldir1.qq.com/weixin/Windows/WeChatSetup.exe'),(87,0,24,'360安全卫士 13.0.0.2004 官方正式版','100%开源、自主研发、功能强大','360安全卫士','/Static/images/360.jpg','','',99,'','',1649685926,1649685883,0,0,0,0,'',1,0,0,1,'<p>360安全卫士电脑版是目前国内免费的电脑杀毒安全软件，360安全卫士官方版提供木马查杀、清理插件、漏洞修复、清理垃圾等多种功能。360安全卫士最新版包含的系统全面诊断、流氓软件强力卸载等等多重功能，也获得了千千万万用户的一致好评。360安全卫士最新版还特别提供了360公司安全专家给用户专业的咨询，如今360安全卫士官方下载版在国内已经有了相当不错的影响力。本站为您提供360安全卫士电脑版官方下载。</p><p>360安全卫士电脑版是目前国内免费的电脑杀毒安全软件，360安全卫士官方版提供木马查杀、清理插件、漏洞修复、清理垃圾等多种功能。360安全卫士最新版包含的系统全面诊断、流氓软件强力卸载等等多重功能，也获得了千千万万用户的一致好评。360安全卫士最新版还特别提供了360公司安全专家给用户专业的咨询，如今360安全卫士官方下载版在国内已经有了相当不错的影响力。本站为您提供360安全卫士电脑版官方下载。</p><p>&nbsp;</p><p>360安全卫士电脑版是目前国内免费的电脑杀毒安全软件，360安全卫士官方版提供木马查杀、清理插件、漏洞修复、清理垃圾等多种功能。360安全卫士最新版包含的系统全面诊断、流氓软件强力卸载等等多重功能，也获得了千千万万用户的一致好评。360安全卫士最新版还特别提供了360公司安全专家给用户专业的咨询，如今360安全卫士官方下载版在国内已经有了相当不错的影响力。本站为您提供360安全卫士电脑版官方下载。360安全卫士电脑版是目前国内免费的电脑杀毒安全软件，360安全卫士官方版提供木马查杀、清理插件、漏洞修复、清理垃圾等多种功能。360安全卫士最新版包含的系统全面诊断、流氓软件强力卸载等等多重功能，也获得了千千万万用户的一致好评。360安全卫士最新版还特别提供了360公司安全专家给用户专业的咨询，如今360安全卫士官方下载版在国内已经有了相当不错的影响力。本站为您提供360安全卫士电脑版官方下载。</p>',2,'',2,1,2,2,2,1,2,'360anquanweishi13002004guanfangzhengshiban','360aqws13002004gfzsb','360安全卫士电脑版是目前国内免费的电脑杀毒安全软件，360安全卫士官方版提供木马查杀、清理插件、漏洞修复、清理垃圾等多种功能。','174.91MB','简体中文','5','某科技公司','免费软件','WinAll','http://www.q-cms.cn/','https://dldir1.qq.com/weixin/Windows/WeChatSetup.exe'),(88,0,24,'酷狗音乐 10.0.53.24820 中文免费版','100%开源、自主研发、功能强大','酷狗音乐,播放器','/Static/images/kg.jpg','','',99,'','',1649685996,1649685952,0,0,0,0,'',1,0,0,1,'<p>酷狗音乐推出2020视听资源遍布全球的酷狗音乐播放器。酷狗音乐软件内含海量电台和MV播放，视听资源遍布全球。酷狗音乐播放器提供海量在线正版音乐给用户试听。酷狗音乐还拥有更智能更先进的且国内屈指可数的高速音乐搜索引擎。酷狗下载安装非常方便且免费，用户可以利用酷狗音乐下载高品质音乐。酷狗音乐独创的卡拉OK歌词功能，以及手机铃声制作、MP3格式转换等功能，为用户提供了优质的一站式音乐服务。本站提供酷狗音乐播放器下载。</p><p>酷狗音乐推出2020视听资源遍布全球的酷狗音乐播放器。酷狗音乐软件内含海量电台和MV播放，视听资源遍布全球。酷狗音乐播放器提供海量在线正版音乐给用户试听。酷狗音乐还拥有更智能更先进的且国内屈指可数的高速音乐搜索引擎。酷狗下载安装非常方便且免费，用户可以利用酷狗音乐下载高品质音乐。酷狗音乐独创的卡拉OK歌词功能，以及手机铃声制作、MP3格式转换等功能，为用户提供了优质的一站式音乐服务。本站提供酷狗音乐播放器下载。酷狗音乐推出2020视听资源遍布全球的酷狗音乐播放器。酷狗音乐软件内含海量电台和MV播放，视听资源遍布全球。酷狗音乐播放器提供海量在线正版音乐给用户试听。酷狗音乐还拥有更智能更先进的且国内屈指可数的高速音乐搜索引擎。酷狗下载安装非常方便且免费，用户可以利用酷狗音乐下载高品质音乐。酷狗音乐独创的卡拉OK歌词功能，以及手机铃声制作、MP3格式转换等功能，为用户提供了优质的一站式音乐服务。本站提供酷狗音乐播放器下载。</p><p>酷狗音乐推出2020视听资源遍布全球的酷狗音乐播放器。酷狗音乐软件内含海量电台和MV播放，视听资源遍布全球。酷狗音乐播放器提供海量在线正版音乐给用户试听。酷狗音乐还拥有更智能更先进的且国内屈指可数的高速音乐搜索引擎。酷狗下载安装非常方便且免费，用户可以利用酷狗音乐下载高品质音乐。酷狗音乐独创的卡拉OK歌词功能，以及手机铃声制作、MP3格式转换等功能，为用户提供了优质的一站式音乐服务。本站提供酷狗音乐播放器下载。</p><p>&nbsp;</p><p>酷狗音乐推出2020视听资源遍布全球的酷狗音乐播放器。酷狗音乐软件内含海量电台和MV播放，视听资源遍布全球。酷狗音乐播放器提供海量在线正版音乐给用户试听。酷狗音乐还拥有更智能更先进的且国内屈指可数的高速音乐搜索引擎。酷狗下载安装非常方便且免费，用户可以利用酷狗音乐下载高品质音乐。酷狗音乐独创的卡拉OK歌词功能，以及手机铃声制作、MP3格式转换等功能，为用户提供了优质的一站式音乐服务。本站提供酷狗音乐播放器下载。</p>',2,'',2,1,2,2,2,1,2,'kugouyinle1005324820zhongwenmianfeiban','kgyl1005324820zwmfb','酷狗音乐推出2020视听资源遍布全球的酷狗音乐播放器。酷狗音乐软件内含海量电台和MV播放，视听资源遍布全球。酷狗音乐播放器提供海量在线正版音乐给用户试听。','174.91MB','简体中文','5','某科技公司','免费软件','WinAll','http://www.q-cms.cn/','https://dldir1.qq.com/weixin/Windows/WeChatSetup.exe'),(89,0,24,'抖音电脑版 1.0.4.782 官方版','100%开源、自主研发、功能强大','抖音','/Static/images/dy.png','','',99,'','',1649686070,1649686032,5,0,0,0,'',1,0,0,1,'<p>抖音电脑版让每一个人看见并连接更大的世界，鼓励表达、沟通和记录，激发创造，丰富人们的精神世界，让生活更美好。本站提供抖音电脑版下载。抖音电脑版是抖音官方首次推出的PC端软件版本，抖音短视频电脑版，超级方便实用的抖音pc客户端。作为现国内最受欢迎的短视频平台之一，每日都有新发现，每日都有新惊喜。智能根据用户喜好推荐，短视频风格多样，精彩纷呈，还有超优秀的美颜拍摄功能和新奇特效，让用户沉浸不能自拔抖音电脑版让每一个人看见并连接更大的世界，鼓励表达、沟通和记录，激发创造，丰富人们的精神世界，让生活更美好。本站提供抖音电脑版下载。抖音电脑版是抖音官方首次推出的PC端软件版本，抖音短视频电脑版，超级方便实用的抖音pc客户端。作为现国内最受欢迎的短视频平台之一，每日都有新发现，每日都有新惊喜。智能根据用户喜好推荐，短视频风格多样，精彩纷呈，还有超优秀的美颜拍摄功能和新奇特效，让用户沉浸不能自拔</p><p>抖音电脑版让每一个人看见并连接更大的世界，鼓励表达、沟通和记录，激发创造，丰富人们的精神世界，让生活更美好。本站提供抖音电脑版下载。抖音电脑版是抖音官方首次推出的PC端软件版本，抖音短视频电脑版，超级方便实用的抖音pc客户端。作为现国内最受欢迎的短视频平台之一，每日都有新发现，每日都有新惊喜。智能根据用户喜好推荐，短视频风格多样，精彩纷呈，还有超优秀的美颜拍摄功能和新奇特效，让用户沉浸不能自拔</p><p>&nbsp;</p><p>抖音电脑版让每一个人看见并连接更大的世界，鼓励表达、沟通和记录，激发创造，丰富人们的精神世界，让生活更美好。本站提供抖音电脑版下载。抖音电脑版是抖音官方首次推出的PC端软件版本，抖音短视频电脑版，超级方便实用的抖音pc客户端。作为现国内最受欢迎的短视频平台之一，每日都有新发现，每日都有新惊喜。智能根据用户喜好推荐，短视频风格多样，精彩纷呈，还有超优秀的美颜拍摄功能和新奇特效，让用户沉浸不能自拔</p><p>&nbsp;</p><p>抖音电脑版让每一个人看见并连接更大的世界，鼓励表达、沟通和记录，激发创造，丰富人们的精神世界，让生活更美好。本站提供抖音电脑版下载。抖音电脑版是抖音官方首次推出的PC端软件版本，抖音短视频电脑版，超级方便实用的抖音pc客户端。作为现国内最受欢迎的短视频平台之一，每日都有新发现，每日都有新惊喜。智能根据用户喜好推荐，短视频风格多样，精彩纷呈，还有超优秀的美颜拍摄功能和新奇特效，让用户沉浸不能自拔抖音电脑版让每一个人看见并连接更大的世界，鼓励表达、沟通和记录，激发创造，丰富人们的精神世界，让生活更美好。本站提供抖音电脑版下载。抖音电脑版是抖音官方首次推出的PC端软件版本，抖音短视频电脑版，超级方便实用的抖音pc客户端。作为现国内最受欢迎的短视频平台之一，每日都有新发现，每日都有新惊喜。智能根据用户喜好推荐，短视频风格多样，精彩纷呈，还有超优秀的美颜拍摄功能和新奇特效，让用户沉浸不能自拔</p><p>抖音电脑版让每一个人看见并连接更大的世界，鼓励表达、沟通和记录，激发创造，丰富人们的精神世界，让生活更美好。本站提供抖音电脑版下载。抖音电脑版是抖音官方首次推出的PC端软件版本，抖音短视频电脑版，超级方便实用的抖音pc客户端。作为现国内最受欢迎的短视频平台之一，每日都有新发现，每日都有新惊喜。智能根据用户喜好推荐，短视频风格多样，精彩纷呈，还有超优秀的美颜拍摄功能和新奇特效，让用户沉浸不能自拔</p>',2,'',2,1,2,2,2,1,2,'douyindiannaoban104782guanfangban','dydnb104782gfb','抖音电脑版让每一个人看见并连接更大的世界，鼓励表达、沟通和记录，激发创造，丰富人们的精神世界，让生活更美好。本站提供抖音电脑版下载。','174.91MB','简体中文','5','某科技公司','免费软件','WinAll','http://www.q-cms.cn/','https://dldir1.qq.com/weixin/Windows/WeChatSetup.exe');

#
# Structure for table "qc_table_product"
#

DROP TABLE IF EXISTS `qc_table_product`;
CREATE TABLE `qc_table_product` (
  `Id` bigint(20) NOT NULL DEFAULT '0',
  `ModelId` int(11) NOT NULL DEFAULT '0',
  `CateId` int(11) NOT NULL DEFAULT '0',
  `Title` varchar(100) NOT NULL DEFAULT '',
  `STitle` varchar(60) NOT NULL DEFAULT '' COMMENT '短标题',
  `Tag` varchar(100) NOT NULL DEFAULT '' COMMENT 'Tag',
  `Pic` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `Source` varchar(50) NOT NULL DEFAULT '' COMMENT '来源',
  `Author` varchar(50) NOT NULL DEFAULT '' COMMENT '作者',
  `Sort` tinyint(3) NOT NULL DEFAULT '99',
  `Keywords` varchar(255) NOT NULL DEFAULT '',
  `Description` varchar(255) NOT NULL DEFAULT '',
  `TsAdd` bigint(20) NOT NULL DEFAULT '0',
  `TsUpdate` bigint(20) NOT NULL DEFAULT '0',
  `ReadNum` int(11) NOT NULL DEFAULT '0',
  `Coins` int(11) NOT NULL DEFAULT '0' COMMENT '需消费金币',
  `Money` int(11) NOT NULL DEFAULT '0' COMMENT '支付费用',
  `UserLevel` int(11) NOT NULL DEFAULT '0' COMMENT '浏览权限',
  `Color` varchar(10) NOT NULL DEFAULT '' COMMENT '颜色',
  `UserId` bigint(20) NOT NULL DEFAULT '0',
  `Good` int(11) NOT NULL DEFAULT '0',
  `Bad` int(11) NOT NULL DEFAULT '0',
  `State` tinyint(3) NOT NULL DEFAULT '1',
  `Content` text,
  `IsLink` tinyint(3) NOT NULL DEFAULT '2',
  `LinkUrl` varchar(255) NOT NULL DEFAULT '' COMMENT '外链地址',
  `IsBold` tinyint(3) NOT NULL DEFAULT '2',
  `IsPic` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否有缩略图',
  `IsSpuerRec` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否特推',
  `IsHeadlines` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否头条',
  `IsRec` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否推荐',
  `IsPost` tinyint(3) NOT NULL DEFAULT '1' COMMENT '允许评论',
  `IsDelete` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否删除',
  `PinYin` varchar(255) NOT NULL DEFAULT '',
  `PY` varchar(255) NOT NULL DEFAULT '',
  `Summary` varchar(255) DEFAULT '' COMMENT '摘要',
  `factory` varchar(255) NOT NULL DEFAULT '' COMMENT '厂商',
  `level` varchar(255) NOT NULL DEFAULT '' COMMENT '级别',
  `energy` varchar(255) NOT NULL DEFAULT '' COMMENT '能源类型',
  `environment` varchar(255) NOT NULL DEFAULT '' COMMENT '环保标准',
  `marketTime` date NOT NULL DEFAULT '0000-00-00' COMMENT '上市时间',
  `maxpower` varchar(255) NOT NULL DEFAULT '' COMMENT '最大功率(kW)',
  `maxtorque` varchar(255) NOT NULL DEFAULT '' COMMENT '最大扭矩(N·m)',
  `engine` varchar(255) NOT NULL DEFAULT '' COMMENT '发动机',
  `transmission` varchar(255) NOT NULL DEFAULT '' COMMENT '变速箱',
  `size` varchar(255) NOT NULL DEFAULT '' COMMENT '长*宽*高(mm)',
  `Price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "qc_table_product"
#

INSERT INTO `qc_table_product` VALUES (55,0,23,'上汽奥迪-奥迪A7L','极简科技路线','奥迪,奥迪A7L','/Static/images/p1.jpg','','',99,'','',1649581042,1649581030,5,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'shangqiaodiaodia7l','sqadada7l','','上汽奥迪','中大型车','汽油','国VI','2022-01-01','180','370','2.0T 245马力 L4','7挡湿式双离合','5076*1908*1429',45.97),(56,0,23,'阿斯顿·马丁-阿斯顿·马丁DBX','六缸依旧澎湃','阿斯顿·马丁','/Static/images/p2.jpg','','',99,'','',1649584049,1649583875,0,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'asidunmadingasidunmadingdbx','asdmdasdmddbx','','阿斯顿·马丁','中大型SUV','汽油+48V轻混系统','国VI','2022-02-01','320','520','3.0T 435马力 L6','9挡手自一体','5039*1998*1680',196.80),(57,0,23,'阿尔法·罗密欧-Giulia','为情怀买单','阿尔法·罗密欧,Giulia','/Static/images/p3.jpg','','',99,'','',1649584255,1649584088,0,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'aerfaluomiougiulia','aeflmogiulia','','阿尔法·罗密欧','中型车','汽油','国VI','2022-03-01','206','400','2.0T 280马力 L4','8挡手自一体','4643*1860*1438',37.98),(58,0,23,'梅赛德斯-AMG-奔驰GLC轿跑','让你一次开到爽','梅赛德斯,奔驰GLC,AMG,轿跑','/Static/images/p4.jpg','','',99,'','',1649587678,1649587437,0,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'meisaidesiamgbenchiglcjiaopao','msdsamgbcglcjp','','梅赛德斯-AMG','中型SUV','汽油','国VI','2021-12-01','287','520','3.0T 390马力 V6','9挡手自一体','4749*1930*1587',68.82),(59,0,23,'比亚迪-驱逐舰05','基本胜任对美好生活的向往','比亚迪,驱逐舰05','/Static/images/p5.jpg','','',99,'','',1649588041,1649587827,0,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'biyadiquzhujian05','bydqzj05','','比亚迪','紧凑型车','插电式混合动力','国VI','2022-03-01','135','316','1.5L 110马力 L4','E-CVT无级变速','4780*1837*1495',11.98),(60,0,23,'宝马(进口)-宝马Z4','敞篷是一种生活态度','宝马Z4','/Static/images/p6.jpg','','',99,'','',1649588705,1649588287,4,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'baomajinkoubaomaz4','bmjkbmz4','','宝马（进口）','跑车','汽油','国VI','2021-01-01','145','320','2.0T 197马力 L4','8挡手自一体','4336*1867*1322',48.88),(61,0,23,'东风本田-本田CR-V','CRV居家好车儿','东风本田,本田CR-V','/Static/images/p7.jpg','','',99,'','',1649589178,1649589018,1,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'dongfengbentianbentiancrv','dfbtbtcrv','','东风本田','紧凑型SUV','汽油','国VI','2020-07-01','142','243','1.5T 193马力 L4','6挡手动','4621*1855*1679',16.98),(62,0,23,'上汽通用别克-昂科威','大空间科技座驾','上汽通用,别克,昂科威','/Static/images/p8.jpg','','',99,'','',1649589422,1649589255,0,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'shangqitongyongbiekeangkewei','sqtybkakw','','上汽通用别克','中型SUV','汽油+48V轻混系统','国VI','2021-10-01','155','270','1.5T 211马力 L4','9挡手自一体','4662*1883*1631',20.99),(63,0,23,'保时捷-Panamera新能源','破百4.4s，极速280km/h','保时捷,Panamera','/Static/images/p9.jpg','','',99,'','',1649589709,1649589447,0,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'baoshijiepanameraxinnengyuan','bsjpanameraxny','','保时捷','大型车','插电式混合动力','国VI','2022-04-01','340','700','2.9T 330马力 V6','8挡湿式双离合','5049*1937*1423',116.80),(64,0,23,'宾利-欧陆','舒适性绝对要打满分','宾利,欧陆','/Static/images/p10.jpg','','',99,'','',1649590074,1649589750,1,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'binlioulu','blol','','宾利','中大型SUV','汽油','国VI','2022-02-01','404','770','4.0T 549马力 V8','8挡手自一体','5125*1998*1728',269.90),(65,0,23,'上汽大众-朗逸','省心实用，销量冠军','上汽大众,朗逸','/Static/images/p11.jpg','','',99,'','',1649590315,1649590142,1,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'shangqidazhonglangyi','sqdzly','','上汽大众','上汽大众-朗逸','汽油','国VI','2021-10-01','83','145','1.5L 113马力 L4','6挡手自一体','4670*1806*1474',12.49),(66,0,23,'丰田(进口)-丰田86','唯有青春与梦想不可辜负','丰田86','/Static/images/p12.jpg','','',99,'','',1649590641,1649590483,1,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'fengtianjinkoufengtian86','ftjkft86','','丰田（进口）','跑车','汽油','国V','2019-04-01','147','205','2.0L 200马力 H4','6挡手动','4240*1775*1320',27.78),(67,0,23,'长安福特-蒙迪欧','有点壕，同级表现优异','长安福特,蒙迪欧','/Static/images/p13.jpg','','',99,'','',1649591011,1649590662,29,0,0,0,'',1,0,0,1,'',2,'',2,1,2,2,2,1,2,'changanfutemengdiou','caftmdo','','长安福特','中型车','汽油','国VI','2022-04-01','175','376','2.0T 238马力 L4','8挡自动','4935*1875*1500',15.98);

#
# Structure for table "qc_tag"
#

DROP TABLE IF EXISTS `qc_tag`;
CREATE TABLE `qc_tag` (
  `TagId` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL DEFAULT '',
  `Total` int(11) NOT NULL DEFAULT '0',
  `ReadNum` int(11) NOT NULL DEFAULT '0',
  `TsAdd` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TagId`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

#
# Data for table "qc_tag"
#

INSERT INTO `qc_tag` VALUES (6,'牛头人',1,0,0),(7,'鲁班大师',1,0,0),(10,'你坏',1,0,0),(11,'德鲁伊',1,0,0),(12,'宝马',2,0,1649513031),(13,'旅行车',1,0,1649513031),(14,'国产',1,0,1649513031),(15,'奔驰',2,0,1649560021),(16,'荷尔蒙',1,0,1649560021),(17,'X5',1,0,1649560229),(18,'大众',2,0,1649560414),(19,'凌渡L',1,0,1649560414),(20,'沃尔沃',1,0,1649560564),(21,'进口',1,0,1649560564),(22,'XC90',1,0,1649560564),(23,'途昂X',1,0,1649560666),(24,'领克06',1,0,1649560833),(25,'风光MINIEV',1,0,1649561019),(26,'GLB',1,0,1649561259),(27,'五菱',1,0,1649561399),(28,'凯捷280T',1,0,1649561399),(29,'宾利',2,0,1649561557),(30,'飞驰',1,0,1649561557),(31,'奥迪',1,0,1649582443),(32,'奥迪A7L',1,0,1649582443),(33,'阿斯顿·马丁',1,0,1649584049),(34,'阿尔法·罗密欧',1,0,1649584255),(35,'Giulia',1,0,1649584255),(36,'梅赛德斯',1,0,1649587678),(37,'奔驰GLC',1,0,1649587678),(38,'AMG',1,0,1649587678),(39,'轿跑',1,0,1649587678),(40,'比亚迪',1,0,1649588041),(41,'驱逐舰05',1,0,1649588041),(42,'宝马Z4',1,0,1649588705),(43,'东风本田',1,0,1649589178),(44,'本田CR-V',1,0,1649589178),(45,'上汽通用',1,0,1649589422),(46,'别克',1,0,1649589422),(47,'昂科威',1,0,1649589422),(48,'保时捷',1,0,1649589709),(49,'Panamera',1,0,1649589709),(50,'欧陆',1,0,1649590074),(51,'上汽大众',1,0,1649590315),(52,'朗逸',1,0,1649590315),(53,'丰田86',1,0,1649590641),(54,'长安福特',1,0,1649591011),(55,'蒙迪欧',1,0,1649591011),(56,'Adobe',1,0,1649678420),(57,'Photoshop',1,0,1649678420),(58,'VMware',1,0,1649682358),(59,'虚拟机',1,0,1649682358),(60,'腾讯',1,0,1649684688),(61,'QQ',1,0,1649684688),(62,'谷歌',1,0,1649684770),(63,'Chrome',1,0,1649684770),(64,'vscode',1,0,1649684879),(65,'微软',1,0,1649684879),(66,'迅雷',1,0,1649685712),(67,'wps',1,0,1649685778),(68,'office',1,0,1649685778),(69,'爱奇艺',1,0,1649685856),(70,'360安全卫士',1,0,1649685926),(71,'酷狗音乐',1,0,1649685996),(72,'播放器',1,0,1649685996),(73,'抖音',1,0,1649686070),(74,'FileZilla',1,0,1649686262),(75,'ftp客户端',1,0,1649686262);

#
# Structure for table "qc_tag_map"
#

DROP TABLE IF EXISTS `qc_tag_map`;
CREATE TABLE `qc_tag_map` (
  `TagMapId` int(11) NOT NULL AUTO_INCREMENT,
  `TagId` bigint(20) NOT NULL DEFAULT '0',
  `TableId` bigint(20) NOT NULL DEFAULT '0' COMMENT '内容ID',
  `ModelId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TagMapId`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

#
# Data for table "qc_tag_map"
#

INSERT INTO `qc_tag_map` VALUES (12,6,37,1),(13,10,37,1),(14,7,37,1),(15,11,37,1),(16,12,44,1),(17,13,44,1),(18,14,44,1),(19,15,45,1),(20,16,45,1),(21,12,46,1),(22,17,46,1),(23,18,47,1),(24,19,47,1),(25,20,48,1),(26,21,48,1),(27,22,48,1),(28,18,49,1),(29,23,49,1),(30,24,50,1),(31,25,51,1),(32,15,52,1),(33,26,52,1),(34,27,53,1),(35,28,53,1),(36,29,54,1),(37,30,54,1),(38,31,55,2),(39,32,55,2),(40,33,56,2),(41,34,57,2),(42,35,57,2),(43,36,58,2),(44,37,58,2),(45,38,58,2),(46,39,58,2),(47,40,59,2),(48,41,59,2),(49,42,60,2),(50,43,61,2),(51,44,61,2),(52,45,62,2),(53,46,62,2),(54,47,62,2),(55,48,63,2),(56,49,63,2),(57,29,64,2),(58,50,64,2),(59,51,65,2),(60,52,65,2),(61,53,66,2),(62,54,67,2),(63,55,67,2),(64,56,43,4),(65,57,43,4),(66,58,79,4),(67,59,79,4),(68,60,81,4),(69,61,81,4),(70,62,82,4),(71,63,82,4),(72,64,83,4),(73,65,83,4),(74,66,84,4),(75,67,85,4),(76,68,85,4),(77,69,86,4),(78,70,87,4),(79,71,88,4),(80,72,88,4),(81,73,89,4),(82,74,80,4),(83,75,80,4);

#
# Structure for table "qc_token"
#

DROP TABLE IF EXISTS `qc_token`;
CREATE TABLE `qc_token` (
  `Token` varchar(50) NOT NULL DEFAULT '',
  `UserId` bigint(20) NOT NULL DEFAULT '0',
  `Client` varchar(20) NOT NULL DEFAULT '',
  `Ts` bigint(20) NOT NULL DEFAULT '0',
  `TsExpire` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "qc_token"
#

INSERT INTO `qc_token` VALUES ('30f09893fe57a4c30746452fa254f784db4cb1af',1,'muLogin',1649471992,0),('6c574b9d3067bf6e15e7c9faebb1427d393842c6',1,'Web',1649820118,0),('cd55acd1df44e077c7538013dc1cc5b27a45e564',2,'Web',1649056845,0);

#
# Structure for table "qc_user"
#

DROP TABLE IF EXISTS `qc_user`;
CREATE TABLE `qc_user` (
  `UserId` bigint(20) NOT NULL AUTO_INCREMENT,
  `Phone` bigint(11) NOT NULL DEFAULT '0',
  `NickName` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `Head` varchar(255) NOT NULL DEFAULT '',
  `Password` varchar(32) NOT NULL DEFAULT '',
  `Name` varchar(20) NOT NULL DEFAULT '' COMMENT '名字',
  `Address` varchar(255) NOT NULL DEFAULT '',
  `Sex` tinyint(3) NOT NULL DEFAULT '1',
  `Mail` varchar(50) NOT NULL DEFAULT '',
  `MailCheck` tinyint(3) NOT NULL DEFAULT '2' COMMENT '验证邮箱',
  `Money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金钱',
  `Coins` bigint(20) NOT NULL DEFAULT '0' COMMENT '积分',
  `State` tinyint(3) NOT NULL DEFAULT '1',
  `TsAdd` bigint(20) NOT NULL DEFAULT '0',
  `IpAdd` varchar(20) NOT NULL DEFAULT '' COMMENT '注册IP',
  `GroupUserId` tinyint(3) NOT NULL DEFAULT '0' COMMENT '用户组',
  `GroupAdminId` tinyint(3) NOT NULL DEFAULT '0' COMMENT '后台管理组',
  `IsAdmin` tinyint(3) NOT NULL DEFAULT '2' COMMENT '是否管理员',
  `TsLast` bigint(20) NOT NULL DEFAULT '0',
  `IpLast` varchar(16) NOT NULL DEFAULT '',
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Data for table "qc_user"
#

INSERT INTO `qc_user` VALUES (1,18888888888,'管理员','','e10adc3949ba59abbe56e057f20f883e','','',1,'',2,0.00,0,1,0,'',1,1,1,1649820118,'127.0.0.1'),(2,16666666666,'老钱','/Static/upload/20220318/6676234295eb6ebb4.jpg','e10adc3949ba59abbe56e057f20f883e','','',1,'',2,0.00,0,1,0,'',1,3,1,1649056845,'127.0.0.1'),(3,15555555555,'小钱','','e10adc3949ba59abbe56e057f20f883e','','',1,'',2,0.00,0,1,0,'',1,3,1,0,''),(6,15656565656,'会员测试','3','e10adc3949ba59abbe56e057f20f883e','1','4',1,'2',2,0.00,0,2,0,'',3,0,2,0,''),(7,14545454545,'232323','','37693cfc748049e45d87b8c7d8b9aacd','','',2,'',2,0.00,0,1,1647836298,'127.0.0.1',1,0,2,0,'');
