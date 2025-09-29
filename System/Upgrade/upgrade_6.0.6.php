<?php 
use Model\QC_Sys;

class Upgrade{
    
    public function Exec(){
        $SysObj = QC_Sys::get_instance();         
        $DbConfig = Config::DbConfig();	   
        // 修改数据库字符集
        $SysObj->exec("ALTER DATABASE ".$DbConfig['Name']." CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;", array());
        
        // 修改数据表字符集
        $TableArr = $SysObj->query("SHOW TABLES;", array());
        $TableNames = array_column($TableArr, 'Tables_in_'.$DbConfig['Name']);
        foreach($TableNames as $v){
            $SysObj->exec("ALTER TABLE ".$v." CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;", array());
        }
        
        // 修改指定字段字符集
        $ContentTables = array('table_article', 'table_product', 'table_album', 'table_down');
        foreach($ContentTables as $v){
            $SysObj->exec("ALTER TABLE `".$DbConfig['Prefix'].$v."` MODIFY COLUMN `Title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '';", array());
            $SysObj->exec("ALTER TABLE `".$DbConfig['Prefix'].$v."` MODIFY COLUMN `STitle` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '';", array());
            $SysObj->exec("ALTER TABLE `".$DbConfig['Prefix'].$v."` MODIFY COLUMN `Content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;", array());
        }
        // 修改分类字段
        $SysObj->exec("ALTER TABLE `".$DbConfig['Prefix']."category` MODIFY COLUMN `Name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '';", array());
        $SysObj->exec("ALTER TABLE `".$DbConfig['Prefix']."category` MODIFY COLUMN `Content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;", array());
        
        // 修改单页字段
        $SysObj->exec("ALTER TABLE `".$DbConfig['Prefix']."page` MODIFY COLUMN `Name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '';", array());
        $SysObj->exec("ALTER TABLE `".$DbConfig['Prefix']."page` MODIFY COLUMN `Content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;", array());
        
        // 幻灯片
        $SysObj->exec("ALTER TABLE `".$DbConfig['Prefix']."swiper` MODIFY COLUMN `Title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '';", array());
        $SysObj->exec("ALTER TABLE `".$DbConfig['Prefix']."swiper` MODIFY COLUMN `Summary` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '';", array());
        
        // 添加插件菜单表
        $SysObj->exec("CREATE TABLE `".$DbConfig['Prefix']."menu_side` (
          `MenuSideId` bigint(20) NOT NULL AUTO_INCREMENT,
          `PId` bigint(20) NOT NULL DEFAULT '0',
          `PluginId` bigint(20) NOT NULL DEFAULT '0',
          `NameKey` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `Name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
          `Icons` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
          `Url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
          `Para` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
          `Sort` int(11) NOT NULL DEFAULT '0',
          `IsShow` tinyint(3) NOT NULL DEFAULT '2',
          PRIMARY KEY (`MenuSideId`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ", array());
        
        // 添加插件表
        $SysObj->exec("CREATE TABLE `".$DbConfig['Prefix']."plugin` (
          `PluginId` int(11) NOT NULL DEFAULT '0',
          `NameKey` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
          `Version` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '版本号',
          `State` tinyint(3) NOT NULL DEFAULT '2',
          `TsAdd` bigint(20) NOT NULL DEFAULT '0',
          `TsUpdate` bigint(20) NOT NULL DEFAULT '0',
          `Config` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置',
          `CronType` tinyint(3) NOT NULL DEFAULT '0' COMMENT '运行模式 1 间隔 2 定时',
          `IntervalTime` int(11) NOT NULL DEFAULT '0' COMMENT '间隔时间',
          `FixedTime` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '固定时间',
          `TsLastCron` int(11) NOT NULL DEFAULT '0' COMMENT '最后执行时间',
          PRIMARY KEY (`PluginId`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ", array());
        
        // 添加模版表
        $SysObj->exec("CREATE TABLE `".$DbConfig['Prefix']."templates` (
          `TemplatesId` int(11) NOT NULL DEFAULT '0',
          `NameKey` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
          `Version` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '版本号',
          `TsAdd` bigint(20) NOT NULL DEFAULT '0',
          `TsUpdate` bigint(20) NOT NULL DEFAULT '0',
          PRIMARY KEY (`TemplatesId`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ", array());
    }
    
}
