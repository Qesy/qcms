<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Index extends ControllersAdmin {
    
    public function index_Action(){  
        if(!empty($this->SysRs['License'])){
            $LicenseJson = $this->getLicense($this->SysRs['License']);
            $LicenseRs = empty($LicenseJson) ? array() : json_decode($LicenseJson, true);
            if(empty($LicenseRs) || strpos(URL_DOMAIN, $LicenseRs['Domain']) === false){
                $LicenseRs = array();
            }
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
    
    public function verUpdate_Action(){       
        $Ret = $this->getVerUpdate();        
        if(!empty($_POST) && !empty($Ret['Data'])){
            $DownRet = @file_get_contents($Ret['Data']['AddressPatch']);
            if($DownRet === false) $this->Err(1016);
            $Path = './Static/tmp/';
            $FileName = 'QCms_v'.$Ret['Data']['Version'].'_update.zip';
            $WriteRet = @file_put_contents($Path.$FileName, $DownRet);
            if($WriteRet === false) $this->Err(1017);
            $CmsUpdatePath = $Path.'QCms_v'.$Ret['Data']['Version'].'_update';
            $UnZipRet = $this->CommonObj->UnZip($Path.$FileName, $CmsUpdatePath);
            if($UnZipRet === false) $this->Err(1018);
            $CopyRet = $this->CommonObj->DirCopy($CmsUpdatePath, './');
            if($CopyRet === false) $this->Err(1019);
            $Ret = $this->SysObj->SetCond(array('Name' => 'Version'))->SetUpdate(array('AttrValue' => $Ret['Data']['Version']))->ExecUpdate();
            if($Ret === false) $this->Err(1002);
            $this->Jump(array('admin', 'index', 'verUpdate'), 1888);
        }
        if(empty($Ret['Data'])){
            $VersionUpdate = '无更新版本';
        }else{
            $VersionUpdate = $Ret['Data']['Version'];
        }        
        $this->BuildObj->Arr = array(
            array('Name' =>'Version', 'Desc' => '当前版本',  'Type' => 'input', 'Value' => $this->SysRs['Version'], 'Required' => 1, 'Col' => 6),
            array('Type' =>'htmlFill', 'Col' => 6),
            array('Name' =>'VersionUpdate', 'Desc' => '升级版本',  'Type' => 'input', 'Value' => $VersionUpdate, 'Required' => 1, 'Col' => 6),             
            array('Type' =>'htmlFill', 'Col' => 6),            
        );
        $this->BuildObj->NameSubmit = '立即升级';
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
}