<?php 
use Model\QC_Sys;

class Upgrade{
    
    public function Exec(){
        $SysObj = QC_Sys::get_instance();       
        $SysObj->SetTable("qc_sys")->SetCond(array('Name' => 'Version'))->SetUpdate(array('AttrValue' => '6.0.3'))->ExecUpdate();       
    }
    
}
