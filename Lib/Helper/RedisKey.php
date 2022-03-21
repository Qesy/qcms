<?php

namespace Helper;

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
class RedisKey {
	public Static $s_projectKey = 'QCms';

	public static function Table_HM($Table, $PrimaryId){
	    return self::$s_projectKey.'_Table_'.$Table.'_HM_'.$PrimaryId;
	}

	public static function Sys_Arr_HM(){
	    return self::$s_projectKey.'_Sys_Arr_HM';
	}
	
	public static function Group_Admin_Arr_HM(){
	    return self::$s_projectKey.'_Group_Admin_Arr_HM';
	}
	
	public static function Group_User_Arr_HM(){
	    return self::$s_projectKey.'_Group_User_Arr_HM';
	}
	
	public static function Sys_Model_Arr_HM(){
	    return self::$s_projectKey.'Sys_Model_Arr_HM';
	}
	
	public static function Category_String(){
	    return self::$s_projectKey.'_Category_String';
	}
	
	public static function Link_Cate_String(){
	    return self::$s_projectKey.'_Link_Cate_String';
	}

}