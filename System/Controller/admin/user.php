<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class User extends ControllersAdmin {
    
    public function index_Action(){
        $Page = intval($_GET['Page']);
        if($Page < 1) $Page = 1;
        $Count = 0;
        $Limit = array(($Page-1)*$this->PageNum, $this->PageNum);
        $CondArr = array();
        if(!empty($_GET['GroupUserId'])) $CondArr['GroupUserId'] = $_GET['GroupUserId'];
        $Arr = $this->UserObj->SetCond($CondArr)->SetLimit($Limit)->SetSort(array('UserId' => 'DESC'))->ExecSelectAll($Count);
        
        $GroupUserArr = $this->Group_userObj->getList();
        $GroupUserKV = array_column($GroupUserArr, 'Name', 'GroupUserId');
        foreach($Arr as $k => $v){
            $Arr[$k]['GroupUserView'] = $GroupUserKV[$v['GroupUserId']];
            $Arr[$k]['IsEdit'] = $Arr[$k]['IsDel'] = ($v['GroupAdminId'] == 1 || $v['UserId'] == $this->LoginUserRs['UserId']) ? 2 : 1;
            $Arr[$k]['TsLastView'] = empty($v['TsLast']) ? '未登录' : date('Y-m-d H:i', $v['TsLast']);
            $Arr[$k]['IpLastView'] = empty($v['IpLast']) ? '未登录' : $v['IpLast'];
            $Arr[$k]['BtnArr'] = array(
                array('Name' => '文档', 'Link' => '#', 'Color' => 'success'),
                array('Name' => '提升', 'Link' => '#', 'Color' => 'danger'),
            );
        }
        $KeyArr = array(
            'Phone' => array('Name' => '账号', 'Td' => 'th'),
            //'Sn_Out' => array('Name' => '第三方订单号', 'Td' => 'th'),
            'NickName' => array('Name' => '昵称', 'Td' => 'th'),
            'GroupUserView' => array('Name' => '用户组', 'Td' => 'th'),
            'TsLastView' => array('Name' => '登录时间', 'Td' => 'th'),
            'IpLastView' => array('Name' => '登录IP', 'Td' => 'th'),
            
        );
        $this->BuildObj->PrimaryKey = 'UserId';
        $this->BuildObj->IsDel = false;
        //$this->BuildObj->IsDel = $this->BuildObj->IsAdd = $this->BuildObj->IsEdit = false;
        $PageBar = $this->CommonObj->PageBar($Count, $this->PageNum);
        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr, $PageBar);
        $this->LoadView('admin/common/list', $tmp);
    }
    
    public function add_Action(){
        
    }
    
    public function edit_Action(){
        
    }
    
    public function del_Action(){
        
    }
    
    
}