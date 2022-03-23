<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class FormField extends ControllersAdmin {
    
    public function index_Action(){ //字段管理
        if(!$this->VeriObj->VeriPara($_GET, array('FormId'))) $this->Err(1001);
        $Rs = $this->Sys_formObj->getOne($_GET['FormId']);
        if(empty($Rs)) $this->Err(1003);
        $Arr = empty($Rs['FieldJson']) ? array() : json_decode($Rs['FieldJson'], true);
        $this->PageTitle2 = $this->BuildObj->FormTitle($Rs['Name'].'字段管理');
        $KeyArr = array(
            'Name' => array('Name' => '字段名', 'Td' => 'th'),
            'Comment' => array('Name' => '字段说明', 'Td' => 'th'),
            'Type' => array('Name' => '字段类型', 'Td' => 'th'),
        );
        $this->BuildObj->PrimaryKey = 'Field';
        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr);
        $this->LoadView('admin/common/list', $tmp);
    }
    
    public function add_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('FormId'))) $this->Err(1001);
        $Rs = $this->Sys_formObj->getOne($_GET['FormId']);
        if(empty($Rs)) $this->Err(1003);
        $Arr = empty($Rs['FieldJson']) ? array() : json_decode($Rs['FieldJson'], true);
        //$this->PageTitle2 = $this->BuildObj->FormTitle($Rs['Name'].'字段管理');
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Name', 'Comment', 'Type', 'Content'))) $this->Err(1001);
            $Arr[] = array('Name' => trim($_POST['Name']), 'Comment' => trim($_POST['Comment']), 'Type' => trim($_POST['Type']), 'Content' => trim($_POST['Content']));
        }
        
        $this->BuildObj->Arr = array(
            array('Name' =>'Name', 'Desc' => '字段名 (只能英文和数字)',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 6),
            array('Name' =>'Comment', 'Desc' => '字段说明',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 3),
            array('Name' =>'Type', 'Desc' => '字段类型',  'Type' => 'select', 'Data' => $this->FieldArr, 'Value' => 'input', 'Required' => 1, 'Col' => 3),
            array('Name' =>'Content', 'Desc' => '默认值',  'Type' => 'textarea', 'Value' => '', 'Required' => 0, 'Col' => 12, 'Row' => 4, 'Class' => 'Content'),
        );        
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function edit_Action(){
        
    }
    
    public function del_Action(){
        
    }
    
}