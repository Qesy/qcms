<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Index extends ControllersAdmin {
    
    public function index_Action(){
        $LicenseRs = array();        
        if(!empty($this->SysRs['License'])){
            $LicenseJson = $this->getLicense($this->SysRs['License']);
            if(!empty($LicenseJson)) $LicenseRs = json_decode($LicenseJson, true);
        }        
        $tmp['LicenseRs'] = $LicenseRs;
        $tmp['Stat'] = $this->SysObj->GetStat();
        $this->LoadView('admin/index/index', $tmp);
    }
    
}