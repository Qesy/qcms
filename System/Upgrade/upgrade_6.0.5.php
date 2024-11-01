<?php 
use Model\QC_Sys;

class Upgrade{
    
    public function Exec(){
        $SysObj = QC_Sys::get_instance();         
        $SysObj->SetTable("qc_sys")->SetInsert(array('Name' => 'BindPhone', 'Info' => 'BindPhone', 'AttrValue' => '', 'GroupId' => '9', 'AttrType' => 'input', 'Sort' => '9006', 'IsSys' => '1'))->ExecInsert();       
    }
    
}
