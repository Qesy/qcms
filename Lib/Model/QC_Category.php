<?php
namespace Model;
use Helper\RedisKey;
use Helper\Redis;

defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
/*
 * Name 	: QC_Category
 * Date 	: 2022-03-17
 * Author 	: Qesy
 * QQ 		: 762264
 * Mail 	: 762264@qq.com
 * Company	: Shanghai Rong Yi Technology Co., Ltd.
 * Web		: http://www.sj-web.com.cn/
 * (̅_̅_̅(̲̅(̅_̅_̅_̅_̅_̅_̅_̅()ڪے
 *
 */
class QC_Category extends \Db_pdo {
	public $TableName = 'category';
	public $PrimaryKey = 'CateId';
	public $CateArr = array();
	public $CateTreeDetail = array();
	public $CateTreeIndex = 0;
	
	public function getList(){
	    $key = RedisKey::Category_String();
	    if(Redis::$s_IsOpen == 1 && Redis::exists($key)){
	        $Json = Redis::get($key);
	        return json_decode($Json, true);
	    }
	    $Arr = $this->SetSort(array('Sort' => 'ASC', 'CateId' => 'ASC'))->SetField('CateId, PCateId, Name, IsShow, LinkType, LinkUrl, Sort')->ExecSelect();
	    if(!empty($Arr) && Redis::$s_IsOpen == 1) Redis::set($key, json_encode($Arr));
	    return $Arr;
	}
	
	public function cleanTree(){
	    if(Redis::$s_IsOpen != 1) return;
	    $key = RedisKey::Category_String();
	    Redis::del($key);
	}
	
	public function getTree(){
	    $this->CateArr = $this->getList();
	    return self::_Tree(array(), 0);
	}
	
	public function getTreeDetal(){
	    $this->CateArr = $this->getList();
	    return self::_TreeDetail(0, 0);
	}
	
	private function _TreeDetail($PCateId, $Level, $PIndex = 0){	
	    foreach($this->CateArr as $k => $v){
	        if($v['PCateId'] == $PCateId){
	            $this->CateTreeDetail[$PIndex]['HasSub'] = true; //设置父分类有子分类
	            $CateRs = $this->getOne($v['CateId']);
	            $CateRs['Level'] = $Level;
	            $CateRs['HasSub'] = false;
	            $this->CateTreeDetail[$this->CateTreeIndex] = $CateRs;
	            unset($this->CateArr[$k]);
	            $Index = $this->CateTreeIndex;	
	            $this->CateTreeIndex++;
	            $NewLevel = $Level+1;	 
	            self::_TreeDetail($v['CateId'], $NewLevel, $Index);
	        }
	    }
	}
	
	private function _Tree($Node, $PCateId){ 	    
	    foreach($this->CateArr as $v){
	        if($v['PCateId'] == $PCateId){
	            $Node[$v['CateId']] = array();
	            unset($this->CateArr[$v['CateId']]);
	            $Node[$v['CateId']] = self::_Tree($Node[$v['CateId']], $v['CateId']);
	        }
	    }
	    return $Node;
	}
}