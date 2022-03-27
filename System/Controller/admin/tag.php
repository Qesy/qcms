<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Tag extends ControllersAdmin {
    
    public function index_Action(){
        $Page = intval($_GET['Page']);
        if($Page < 1) $Page = 1;
        $Count = 0;
        $Limit = array(($Page-1)*$this->PageNum, $this->PageNum);
        $CondArr = array();
        $Arr = $this->TagObj->SetCond($CondArr)->SetLimit($Limit)->SetSort(array('Total' => 'DESC', 'TagId' => 'ASC'))->ExecSelectAll($Count);
        
        $KeyArr = array(
            'TagId' => array('Name' => 'ID', 'Td' => 'th'),
            'Name' => array('Name' => '名字', 'Td' => 'th'),
            'Total' => array('Name' => '数量', 'Td' => 'th'),
        );
        $this->BuildObj->PrimaryKey = 'TagId';
        $this->BuildObj->IsDel = $this->BuildObj->IsAdd = $this->BuildObj->IsEdit = false;
        $PageBar = $this->CommonObj->PageBar($Count, $this->PageNum);
        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr, $PageBar, 'table-sm');
        $this->LoadView('admin/common/list', $tmp);
    }
    
}