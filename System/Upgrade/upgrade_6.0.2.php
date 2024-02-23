<?php 
use Model\QC_Sys;

class Upgrade{
    
    public function Exec(){
        $SysObj = QC_Sys::get_instance();       
        $SysObj->SetTable("qc_sys")->SetInsert(array('Name' => 'UrlListPage', 'Info' => '分类分页地址命名规则', 'AttrValue' => 'list_{CateId}_{Page}.html', 'GroupId' => '2', 'AttrType' => 'input', 'Sort' => '2060', 'IsSys' => '1'))->ExecInsert();       
    }
    
}
