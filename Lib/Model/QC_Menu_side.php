<?php
namespace Model;
use Helper\RedisKey;
use Helper\Redis;

defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
/*
 * Name 	: QC_Token
 * Date 	: 2022-03-15
 * Author 	: Qesy
 * QQ 		: 762264
 * Mail 	: 762264@qq.com
 * Company	: Shanghai Rong Yi Technology Co., Ltd.
 * Web		: http://www.sj-web.com.cn/
 * (̅_̅_̅(̲̅(̅_̅_̅_̅_̅_̅_̅_̅()ڪے
 *
 */
class QC_Menu_side extends \Db_pdo {
    public $TableName = 'menu_side';
    public $PrimaryKey = 'MenuSideId';
    
    public function getList(){
        $key = RedisKey::Menu_Side_String();
        if(Redis::$s_IsOpen == 1 && Redis::exists($key)){
            $Json = Redis::get($key);
            return json_decode($Json, true);
        }
        $Arr = $this->SetSort(array('Sort' => 'ASC', 'MenuSideId' => 'ASC'))->ExecSelect();
        if(Redis::$s_IsOpen == 1 && !empty($Arr)) Redis::set($key, json_encode($Arr));
        return $Arr;
    }
    
    public function cleanList(){
        if(Redis::$s_IsOpen != 1) return;
        $key = RedisKey::Menu_Side_String();
        Redis::del($key);
    }
}