<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Index extends ControllersAdmin {
    
    public function index_Action(){
        $LicenseRs = array();        
        if(!empty($this->SysRs['License'])){
            $LicenseJson = $this->getLicense($this->SysRs['License']);
            if(!empty($LicenseJson)) $LicenseRs = json_decode($LicenseJson, true);
        }        
        $FlowDataKV = $this->Stat_flowObj->GetIndexChart();
        $MaxDay = date('t');
        $Start = strtotime(date('Y-m-01'));
        for($i=0;$i<$MaxDay;$i++){
            $Date = date('Y-m-d', ($Start+86400*$i));
            $DataArr[$Date] = 0;
            if(isset($FlowDataKV[$Date])){
                $DataArr[$Date] = intval($FlowDataKV[$Date]['FlowNum']);               
            }
            $Total += $DataArr[$Date];
            
        }
        $tmp['DataArr'] = $DataArr;
        $tmp['Total'] = $Total;
        $tmp['LicenseRs'] = $LicenseRs;
        $tmp['Stat'] = $this->SysObj->GetStat();
        $this->LoadView('admin/index/index', $tmp);
    }
    
}