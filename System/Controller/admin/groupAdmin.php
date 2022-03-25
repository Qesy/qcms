<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class GroupAdmin extends ControllersAdmin {
    
    public function index_Action(){
        $Arr = $this->Group_adminObj->SetSort(array('GroupAdminId' => 'ASC'))->ExecSelect();
        foreach($Arr as $k => $v){
            $Arr[$k]['IsEdit'] = $Arr[$k]['IsDel'] = ($v['IsSys'] == 1) ? 2 : 1;
            $Arr[$k]['BtnArr'] = array(
                array('Desc' => '组用户', 'Link' => $this->CommonObj->Url(array('admin', 'admin', 'index')), 'Color' => 'success'),
            );
        }
        $KeyArr = array(
            'GroupAdminId' => array('Name' => 'ID', 'Td' => 'th'),         
            'Name' => array('Name' => '管理组', 'Td' => 'th'),            
        );
        $this->BuildObj->PrimaryKey = 'GroupAdminId';
        //$this->BuildObj->IsDel = $this->BuildObj->IsAdd = $this->BuildObj->IsEdit = false;

        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr, '', 'table-sm');
        $this->LoadView('admin/common/list', $tmp);
    }
    
    public function add_Action(){
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Name'))) $this->Err(1001);
            $Permission = empty($_POST['Permission']) ? '' : implode('|', array_keys($_POST['Permission']));
            $Ret = $this->Group_adminObj->SetInsert(array('Name' => $_POST['Name'], 'IsSys' => 2, 'Permission' => $Permission))->ExecInsert();
            if($Ret === false) $this->Err(1002);
            $this->Group_adminObj->cleanList();
            $this->Jump(array('admin', 'groupAdmin', 'index'), 1888);
        }
        $this->BuildObj->Arr = array(
            array('Name' =>'Name', 'Desc' => '管理组',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 12),            
        );  
        $DataArr = self::_MenuPermission();
        foreach($DataArr as $k => $v){
            $Data = array_column($v['SubArr'], 'Name', 'Url');
            $this->BuildObj->Arr[] = array('Name' =>'Permission', 'Desc' => $v['Name'],  'Type' => 'checkbox', 'Data' => $Data, 'Value' => '', 'Required' => 1, 'Col' => 12);
        }
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function edit_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('GroupAdminId'))) $this->Err(1001);
        $Rs = $this->Group_adminObj->getOne($_GET['GroupAdminId']);
        if(empty($Rs)) $this->Err(1003);
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Name'))) $this->Err(1001);
            $Permission = empty($_POST['Permission']) ? '' : implode('|', array_keys($_POST['Permission']));
            $Ret = $this->Group_adminObj->SetCond(array('GroupAdminId' => $Rs['GroupAdminId']))->SetUpdate(array('Name' => $_POST['Name'], 'Permission' => $Permission))->ExecUpdate();
            if($Ret === false) $this->Err(1002);
            $this->Group_adminObj->clean($Rs['GroupAdminId']);
            $this->Jump(array('admin', 'groupAdmin', 'index'), 1888);
        }
        $this->BuildObj->Arr = array(
            array('Name' =>'Name', 'Desc' => '管理组',  'Type' => 'input', 'Value' => $Rs['Name'], 'Required' => 1, 'Col' => 12),
        );
        $DataArr = self::_MenuPermission();
        foreach($DataArr as $k => $v){
            $Data = array_column($v['SubArr'], 'Name', 'Url');
            $this->BuildObj->Arr[] = array('Name' =>'Permission', 'Desc' => $v['Name'],  'Type' => 'checkbox', 'Data' => $Data, 'Value' => $Rs['Permission'], 'Required' => 1, 'Col' => 12);
        }
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function del_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('GroupAdminId'))) $this->Err(1001);
        $Rs = $this->Group_adminObj->getOne($_GET['GroupAdminId']);
        if(empty($Rs)) $this->Err(1003);
        if($Rs['IsSys'] == 1) $this->Err(1042);
        $UserCount = $this->UserObj->SetCond(array('IsAdmin' => 1, 'GroupAdminId' => $Rs['GroupAdminId']))->SetField('COUNT(*) AS c')->ExecSelectOne();
        if($UserCount['c'] > 0) $this->Err(1043);
        $Ret = $Ret = $this->Group_adminObj->SetCond(array('GroupAdminId' => $Rs['GroupAdminId']))->ExecDelete();
        if($Ret === false) $this->Err(1002);
        $this->Group_adminObj->clean($Rs['GroupAdminId']);
        $this->Group_adminObj->cleanList();
        $this->Jump(array('admin', 'groupAdmin', 'index'), 1888);
    }
    
    private function _MenuPermission(){
        $DataArr = array();
        foreach($this->MenuArr as $k => $v){
            $KArr = explode('/', $k);
            if($KArr[0] != 'admin') continue;
            $Name = '';
            switch($KArr[1]){
                case 'admin':
                    $Name = '管理员管理';
                    break;
                case 'groupAdmin':
                    $Name = '管理组管理';
                    break;
                case 'user':
                    $Name = '用户管理';
                    break;
                case 'groupUser':
                    $Name = '用户组管理';
                    break;
                default:
                    $Name = '其他管理';
                    break;
            }
            if(!isset($DataArr[$KArr[1]])) $DataArr[$KArr[1]] = array('Name' => $Name, 'SubArr' => array());
            $DataArr[$KArr[1]]['SubArr'][] = $v;
        }
        return $DataArr;
    }
    
    
}