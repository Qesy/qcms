<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class inlinkCate extends ControllersAdmin {
    
    public function index_Action(){
        $Arr = $this->Inlink_cateObj->getList();
        foreach($Arr as $k => $v){
            $Arr[$k]['SortView'] = '<input class="form-control" type="text" value="'.$v['Sort'].'"/>';
        }
        $KeyArr = array(
            'InlinkCateId' => array('Name' => 'ID', 'Td' => 'th'),
            'Name' => array('Name' => '分类名', 'Td' => 'th'),
            'SortView' => array('Name' => '排序', 'Td' => 'th', 'Style' => 'width:100px;'),
        );
        $this->BuildObj->PrimaryKey = 'InlinkCateId';
        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr);
        $this->LoadView('admin/common/list', $tmp);
    }
    
    public function add_Action(){
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Name'))) $this->Err(1001);
            $Ret = $this->Inlink_cateObj->SetInsert(array(
                'Name' => $_POST['Name'],
                'Sort' => 99,
            ))->ExecInsert();
            if($Ret === false) $this->Err(1002);
            $this->Inlink_cateObj->cleanList();
            $this->Jump(array('admin', 'inlinkCate', 'index'), 1888);
        }
        $this->BuildObj->Arr = array(
            array('Name' =>'Name', 'Desc' => '分类名',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 12),
        );
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function edit_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('InlinkCateId'))) $this->Err(1001);
        $Rs = $this->Inlink_cateObj->SetCond(array('InlinkCateId' => $_GET['InlinkCateId']))->ExecSelectOne();
        if(empty($Rs)) $this->Err(1003);
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Name'))) $this->Err(1001);
            $Ret = $this->Inlink_cateObj->SetCond(array('InlinkCateId' => $Rs['InlinkCateId']))->SetUpdate(array(
                'Name' => $_POST['Name'],
            ))->ExecUpdate();
            if($Ret === false) $this->Err(1002);
            $this->Inlink_cateObj->cleanList();
            $this->Jump(array('admin', 'inlinkCate', 'index'), 1888);
        }
        $this->BuildObj->Arr = array(
            array('Name' =>'Name', 'Desc' => '分类名',  'Type' => 'input', 'Value' => $Rs['Name'], 'Required' => 1, 'Col' => 12),
        );
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function del_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('InlinkCateId'))) $this->Err(1001);
        $Rs = $this->Inlink_cateObj->SetCond(array('InlinkCateId' => $_GET['InlinkCateId']))->ExecSelectOne();
        if(empty($Rs)) $this->Err(1003);
        $Count = $this->InlinkObj->SetCond(array('InlinkCateId' => $Rs['InlinkCateId']))->SetField('COUNT(*) AS c')->ExecSelectOne();
        if($Count['c'] != 0) $this->Err(1045);
        $Ret = $this->Inlink_cateObj->SetCond(array('InlinkCateId' => $Rs['InlinkCateId']))->ExecDelete();
        if($Ret === false) $this->Err(1002);
        $this->Inlink_cateObj->cleanList();
        $this->Jump(array('admin', 'inlinkCate', 'index'), 1888);
    }
    
}