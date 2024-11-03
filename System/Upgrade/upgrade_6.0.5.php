<?php 
use Model\QC_Sys;

class Upgrade{
    
    public function Exec(){
        $SysObj = QC_Sys::get_instance();         
        $SysObj->SetTable("qc_sys")->SetInsert(array('Name' => 'BindPhone', 'Info' => 'BindPhone', 'AttrValue' => '', 'GroupId' => '9', 'AttrType' => 'input', 'Sort' => '9006', 'IsSys' => '1'))->ExecInsert();       
        // 调整数据库字段类型
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."file` MODIFY COLUMN `Img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `Name`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."file` MODIFY COLUMN `Ext` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `Size`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."label` MODIFY COLUMN `LabelCateId` int(11) NOT NULL DEFAULT 0 AFTER `LabelId`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."link` MODIFY COLUMN `Info` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `Sort`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."link` MODIFY COLUMN `LinkCateId` int(11) NOT NULL DEFAULT 0 AFTER `State`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."log_login` MODIFY COLUMN `UserId` bigint(20) NOT NULL DEFAULT 0 AFTER `LogLoginId`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."log_operate` MODIFY COLUMN `Query` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `Method`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."table_album` MODIFY COLUMN `Content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `State`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."table_album` MODIFY COLUMN `Summary` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '摘要' AFTER `PY`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."table_article` MODIFY COLUMN `Content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `State`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."table_article` MODIFY COLUMN `Summary` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '摘要' AFTER `PY`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."table_down` MODIFY COLUMN `Content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `State`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."table_down` MODIFY COLUMN `Summary` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '摘要' AFTER `PY`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."table_product` MODIFY COLUMN `Content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `State`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."table_product` MODIFY COLUMN `Summary` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '摘要' AFTER `PY`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."log_operate` DROP COLUMN `vv`;", array());
        $SysObj->exec("ALTER TABLE `".$SysObj->p_dbConfig ['Prefix']."log_operate` DROP COLUMN `ff`;", array());
    }
    
}
