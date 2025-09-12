<?php
namespace Model;
use Helper\RedisKey;
use Helper\Redis;

defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
/*
 * Name 	: QC_Sys_model
 * Date 	: 2022-03-17
 * Author 	: Qesy
 * QQ 		: 762264
 * Mail 	: 762264@qq.com
 * Company	: Shanghai Rong Yi Technology Co., Ltd.
 * Web		: http://www.sj-web.com.cn/
 * (̅_̅_̅(̲̅(̅_̅_̅_̅_̅_̅_̅_̅()ڪے
 *
 */
class QC_Sys_model extends \Db_pdo {
	public $TableName = 'sys_model';
	public $PrimaryKey = 'ModelId';
	
	public function getList(){	    
	    $key = RedisKey::Sys_Model_Arr_HM();
	    $FieldArr = array();
	    if(Redis::$s_IsOpen == 1 && Redis::exists($key)) {
	        $FieldArr = Redis::hGetAll($key);
	    }else{
	        $Arr = $this->SetField('ModelId')->SetSort(array('ModelId' => 'ASC'))->ExecSelect();
	        $FieldArr = array_column($Arr, 'ModelId');
	        if(Redis::$s_IsOpen == 1 && !empty($Arr)) Redis::hMset($key, $FieldArr);
	    }
	    $DataArr = array();
	    foreach($FieldArr as $v){
	        $DataArr[$v] = $this->getOne($v);
	    }
	    return $DataArr;
	}
	
	public function cleanList(){
	    if(Redis::$s_IsOpen != 1) return;
	    $key = RedisKey::Sys_Model_Arr_HM();
	    $FieldArr = array();
	    if(Redis::exists($key)) {
	        $FieldArr = Redis::hGetAll($key);
	    }else{
	        $Arr = $this->SetField('ModelId')->ExecSelect();
	        $FieldArr = array_column($Arr, 'ModelId');
	        //if(!empty($Arr)) Redis::hMset($key, $FieldArr);
	    }
	    foreach($FieldArr as $v){
	        $this->clean($v);
	    }
	    Redis::del($key);
	}
	
	public function CreateTable($KeyName){
	    $FieldStr = "
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
                  `DownNum` int(11) NOT NULL DEFAULT '0',
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
                  ";
	    $DbConfig = \Config::DbConfig();
	    $TableSql = 'CREATE TABLE `'.$DbConfig['Prefix'].'table_'.$KeyName.'` ( '.PHP_EOL.$FieldStr.' PRIMARY KEY (`Id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT=\'\';';
	    $this->exec($TableSql, array());
	}
	
	public function GetField($FieldType){ // 获取字段类型
	    $FieldType = 'varchar(255)';
	    $FieldDefault = "DEFAULT ''";
	    if(in_array($FieldType, array('textarea', 'editor'))){
	        $FieldType = 'text';
	        $FieldDefault = '';
	    }elseif(in_array($FieldType, array('number', 'datetime'))){
	        $FieldType = 'bigint(20)';
	        $FieldDefault = "DEFAULT '0'";
	    }elseif(in_array($FieldType, array('date'))){
	        $FieldType = 'date';
	        $FieldDefault = "DEFAULT '0000-00-00'";
	    }elseif(in_array($FieldType, array('money'))){
	        $FieldType = 'decimal(10,2)';
	        $FieldDefault = "DEFAULT '0.00'";
	    }
	    return array($FieldType, $FieldDefault);
	}
}