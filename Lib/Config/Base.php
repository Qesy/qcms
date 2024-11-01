<?php
use Helper\Code;
use Helper\Build;
use Helper\Cookie;
use Helper\CurlQ;
use Helper\Veri;
use Helper\Common;
use Helper\Upload;
use Helper\IdCreate;

use Model\QC_Category;
use Model\QC_File;
use Model\QC_Group_admin;
use Model\QC_Group_user;
use Model\QC_Inlink;
use Model\QC_Inlink_cate;
use Model\QC_Label;
use Model\QC_Label_cate;
use Model\QC_Link;
use Model\QC_Link_cate;
use Model\QC_Log_login;
use Model\QC_Log_operate;
use Model\QC_Page;
use Model\QC_Page_cate;
use Model\QC_Photos;
use Model\QC_Site;
use Model\QC_Stat_flow;
use Model\QC_Swiper;
use Model\QC_Swiper_cate;
use Model\QC_Sys;
use Model\QC_Sys_form;
use Model\QC_Sys_model;
use Model\QC_Table;
use Model\QC_Table_album;
use Model\QC_Table_article;
use Model\QC_Table_down;
use Model\QC_Table_product;
use Model\QC_Tag;
use Model\QC_Tag_map;
use Model\QC_Token;
use Model\QC_User;
use Helper\Pinyin;
use Helper\WaterMask;
use Helper\Redis;
use Helper\RedisKey;

defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );

/*
 * Name : Collection
 * Date : 20120107
 * Author : Qesy
 * QQ : 762264
 * Mail : 762264@qq.com
 *
 * (̅_̅_̅(̲̅(̅_̅_̅_̅_̅_̅_̅_̅()ڪے
 *
 */
abstract class Base {
	public $CommonObj;	
	public $CookieObj; 
	public $CodeObj;
	public $BuildObj;
	public $CurlObj;
	public $VeriObj;
	public $UploadObj;
	public $PinYinObj;
	public $WaterMaskObj;
	
	public $CategoryObj;
	public $FileObj;
	public $Group_adminObj;
	public $Group_userObj;
	public $InlinkObj;
	public $Inlink_cateObj;
	public $LinkObj;
	public $Link_cateObj;
	public $LabelObj;
	public $Label_cateObj;
	public $Log_loginObj;
	public $Log_operateObj;
	public $PageObj;
	public $Page_cateObj;
	public $PhotosObj;
	public $SiteObj;
	public $Stat_flowObj;
	public $SwiperObj;
	public $Swiper_cateObj;
	public $SysObj;
	public $Sys_formObj;
	public $Sys_modelObj;
	public $TableObj;
	public $Table_albumObj;
	public $Table_articleObj;
	public $Table_downObj;
	public $Table_productObj;
	public $TagObj;
	public $Tag_mapObj;
	public $TokenObj;
	public $UserObj;
	
	public $PageNum = 20;
	public $TempArr = array();
	public $LanguageArr = array();
	public $BasicArr = array();
	
	public $SysRs;
	
	public $DefaultField = array(
	    'Index',
	    'Id',
	    'CateId',
	    'Title',
	    'STitle',
	    'Tag',
	    'Pic',
	    'Source',
	    'Author',
	    'Sort',
	    'Keywords',
	    'Description',
	    'TsAdd',
	    'TsUpdate',
	    'ReadNum',
	    'DownNum',
	    'Coins',
	    'Money',
	    'UserLevel',
	    'Color',
	    'UserId',
	    'Good',
	    'Bad',
	    'State',
	    'Content',
	    'IsLink',
	    'LinkUrl',
	    'IsBold',
	    'IsPic',
	    'IsSpuerRec',
	    'IsHeadlines',
	    'IsRec',
	    'IsPost',
	    'IsDelete',
	    'PinYin',
	    'PY',
	    'Summary',
	);
	function __construct() {
	    $this->CodeObj = Code::get_instance();
	    $this->BuildObj = Build::get_instance();
		$this->CookieObj = Cookie::get_instance();		
		$this->CurlObj = CurlQ::get_instance();
		$this->VeriObj = Veri::get_instance();
		$this->CommonObj = Common::get_instance();		
		$this->UploadObj = Upload::get_instance();
		$this->PinYinObj = Pinyin::get_instance();
		$this->WaterMaskObj = WaterMask::get_instance();
		
		$this->LanguageArr = require_once PATH_LIB .'Language/Cn/Error'.EXTEND;
		
		$this->CategoryObj = QC_Category::get_instance();
		$this->FileObj = QC_File::get_instance();
		$this->Group_adminObj = QC_Group_admin::get_instance();
		$this->Group_userObj = QC_Group_user::get_instance();
		$this->InlinkObj = QC_Inlink::get_instance();
		$this->Inlink_cateObj = QC_Inlink_cate::get_instance();
		$this->LinkObj = QC_Link::get_instance();
		$this->Link_cateObj = QC_Link_cate::get_instance();
		$this->LabelObj = QC_Label::get_instance();
		$this->Label_cateObj = QC_Label_cate::get_instance();
		$this->Log_loginObj = QC_Log_login::get_instance();
		$this->Log_operateObj = QC_Log_operate::get_instance();
		$this->PageObj = QC_Page::get_instance();
		$this->Page_cateObj = QC_Page_cate::get_instance();
		$this->PhotosObj = QC_Photos::get_instance();
		$this->SiteObj = QC_Site::get_instance();
		$this->Stat_flowObj = QC_Stat_flow::get_instance();
		$this->SwiperObj = QC_Swiper::get_instance();
		$this->Swiper_cateObj = QC_Swiper_cate::get_instance();
		$this->SysObj = QC_Sys::get_instance();
		$this->Sys_formObj = QC_Sys_form::get_instance();
		$this->Sys_modelObj = QC_Sys_model::get_instance();
		$this->TableObj = QC_Table::get_instance();
		$this->Table_albumObj = QC_Table_album::get_instance();
		$this->Table_articleObj = QC_Table_article::get_instance();
		$this->Table_downObj = QC_Table_down::get_instance();
		$this->Table_productObj = QC_Table_product::get_instance();
		$this->TagObj = QC_Tag::get_instance();
		$this->Tag_mapObj = QC_Tag_map::get_instance();
		$this->TokenObj = QC_Token::get_instance();
		$this->UserObj = QC_User::get_instance();
		
		$this->BasicArr = BasicArr();
		
		$RedisConf = Config::DbConfig('RedisConfig');
		$DbConf = Config::DbConfig();	  
		if($RedisConf['IsOpen'] == 1) Redis::exists('test');
		RedisKey::$s_projectKey = 'QCMS_'.$DbConf['Name'];
	}
	
	public function GetLogo($Class, $Style){
	    return '
            <svg class="'.$Class.'" viewBox="0 0 93.3 22.7" xmlns="http://www.w3.org/2000/svg" style="'.$Style.'">
            <g id="logo" transform="translate(-313.125 -293)">
                <path id="layer_79" class="st0" d="M366.6,293.1l4.6,22.5h-4.8l-3-14.2l-8.8,14.2h-5.1l13.6-22.5L366.6,293.1z M379.3,301.5
                    l-6.3,14.1l-1.5-7.4l6.9-15.1h6.8l-5,22.5h-4.1L379.3,301.5z"/>
                <path id="layer_80" class="st0" d="M349.8,311.5l-2.4,4.2h-9.8c-2.8,0-3.5-1.3-2.8-3.9l4.2-15.6c0.7-1.8,2.4-3,4.4-3l17.5,0
                    l-2.6,4.3l-14.2-0.1l-3.5,12.9c-0.2,0.8,0.1,1.2,0.8,1.2L349.8,311.5z"/>
                <path id="layer_81" class="st0" d="M406.5,293l-1.5,6.9h-4.6l0.8-3.3h-9.9l-1.2,5.7l14.5,0l-3,13.2l-19,0l1.6-7.1l4.6,0l-0.7,3.1
                    h9.8l1.2-5.4h-14.4l2.9-13.1L406.5,293z"/>
                <path id="layer_82" class="st0" d="M325.8,315.7h7L321.5,304L325.8,315.7z"/>
                <path id="layer_83" class="st0" d="M336.7,297.1c0.7-2.6-0.5-4-3.7-4h-10c-3.1,0-5.1,1.3-5.8,4l-4,14.6c-0.7,2.6,0.5,3.9,3.6,3.9
                    h7.4l-1.3-3.9h-3.4c-0.8,0-1.2-0.4-1-1.2l3.7-13.6h7.3c0.9,0,1.2,0.4,1,1.2l-2.9,10.8l4.4,4.6l0.5-1.9L336.7,297.1z"/>
            </g>
            </svg>
        ';
	}
	
	public function IdCreate(){ //创建ID	    
	    return IdCreate::createOnlyId();
	}
	
	public function ApiErr($ErrCode, $Desc = ''){
	    $Str = ($ErrCode == 1000) ? $Desc : $this->LanguageArr [$ErrCode];
	    $this->CommonObj->ApiErr($ErrCode, $Str);
	}
	
	public function ApiSuccess($Data = array()){
	    $this->CommonObj->ApiSuccess($Data);
	}
	
	public function Err($ErrCode, $Desc = ''){
	    $Str = ($ErrCode == 1000) ? $Desc : $this->LanguageArr [$ErrCode];
	    $this->CommonObj->Err($Str);
	}
	
	public function DieErr($ErrCode, $Desc = ''){
	    $Str = ($ErrCode == 1000) ? $Desc : $this->LanguageArr [$ErrCode];
	    die($Str);
	}
	
	public function Jump($UrlArr, $ErrCode = 1000, $Desc = ''){
	    $Str = ($ErrCode == 1000) ? $Desc : $this->LanguageArr [$ErrCode];
	    $this->CommonObj->Success($this->CommonObj->Url($UrlArr), $Str);
	}
	
	public function LoadView($Temp, $Data = array()) { // -- Name : 加载模版 --
	    if (! is_file ( PATH_SYS . 'View/' . $Temp . EXTEND )) die ( PATH_SYS . 'View/' . $Temp . EXTEND . ' not found !' );
	    $this->TempArr = empty ( $Data ) ? $this->TempArr : array_merge($this->TempArr, $Data);
	    foreach ( $this->TempArr as $Key => $Val ) $$Key = $Val;
	    require PATH_SYS . 'View/' . $Temp . EXTEND;
	}
	
	public static function InsertFuncArray(array $ControllerArr) { // -- Name : 回调函数 --
		$ParaArr = isset ( $ControllerArr ['ParaArr'] ) ? $ControllerArr ['ParaArr'] : array ();
		$Class = new $ControllerArr ['Name'] ();
		call_user_func_array ( array (& $Class, $ControllerArr ['Method'] . '_Action'), $ParaArr );
	}
}
?>