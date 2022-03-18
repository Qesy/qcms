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
}