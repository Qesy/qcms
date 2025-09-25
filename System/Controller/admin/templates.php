<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Templates extends ControllersAdmin {

    public function market_Action(){
        if(empty($this->SysRs['BindPhone'])){
            $this->LoadView('admin/templates/marketBind');
            return;
        }
        $Page = intval($_GET['Page']);
        if($Page < 1) $Page = 1;
        $PageNum = 12;
        $CateId = intval($_GET['CateId']);
        
        $templatesPaidRet = $this->apiRemotePlatform('apiRemote/templatesPaid', array());
        $tmp['PaidIDs'] = $templatesPaidRet['Data'];
        $Ret = $this->getTemplaites($Page, $PageNum, $CateId);
        $CateArr = $this->getTemplaitesCate();
        $tmp['CateArr'] = $CateArr['Data'];
        $tmp['Arr'] = $Ret['Data']['List'];
        $tmp['Page'] = $this->CommonObj->PageBar($Ret['Data']['Count'], $PageNum);
        $InstalledArr = $this->TemplatesObj->ExecSelect();
        $tmp['TempFolder'] = array_column($InstalledArr, 'NameKey', 'NameKey');        
        //$tmp['TempFolder'] = $this->getTempFolder();
        $this->LoadView('admin/templates/market', $tmp);
    }
    
    public function installed_Action(){
        $Page = intval($_GET['Page']);
        if($Page < 1) $Page = 1;
        $Count = 0;
        $Limit = array(($Page-1)*$this->PageNum, $this->PageNum);
        $CondArr = array();
        $Arr = $this->TemplatesObj->SetCond($CondArr)->SetLimit($Limit)->SetSort(array('TemplatesId' => 'ASC'))->ExecSelectAll($Count);
        $TemplatesIds = array_column($Arr, 'TemplatesId');
        $Ret = $this->getTemplaites($Page, count($TemplatesIds), 0, $TemplatesIds, 0);
        if($Ret['Code'] != 0) $this->ApiErr(1002);
        $OnlineTempMap = array();
        foreach($Ret['Data']['List'] as $v){
            $OnlineTempMap[$v['TemplatesId']] = $v;
        }
        $Json = array();
        foreach($Arr as $v){
            $OnlineRs = $OnlineTempMap[$v['TemplatesId']];
            $Json[$v['TemplatesId']] = array(
                'LastVersion' => $OnlineRs['LastVersion'],
                'Version' => $v['Version'],
            );
        }
        foreach($Arr as $k => $v){
            $OnlineRs = $OnlineTempMap[$v['TemplatesId']];
            $Desc = empty($OnlineRs['Content']) ? '暂无介绍' : $OnlineRs['Content'];
            $Arr[$k]['Name'] = '<div class="d-flex"><img class="mr-2" src="'.$OnlineRs['Pic'].'" style="height:60px;"><div><span class="font-weight-bold">'.$OnlineRs['Name'].'</span><br>'.$Desc.'</div></div>';
            $Arr[$k]['TsView'] = '安装时间:'.date('Y-m-d', $v['TsAdd']).'<br>更新时间:'.date('Y-m-d', $v['TsUpdate']);
            $Arr[$k]['VersionView'] = '当前版本:'.$v['Version'].'<br>最新版本:'.$OnlineRs['LastVersion'];
            $IsDisabledUpdate = ($v['Version'] == $OnlineRs['LastVersion']) ? 1 : 0;
            $IsDisabledInstallData = ($this->SysRs['TmpPath'] != $v['NameKey']) ? 1 : 0;
            $IsDisabledDel = ($this->SysRs['TmpPath'] == $v['NameKey']) ? 1 : 0;
            $Arr[$k]['BtnArr'] = array(
                array('Name' => 'Update', 'Type' => 'button', 'Desc' => '更新模版', 'IsDisabled' => $IsDisabledUpdate),
                //array('Name' => 'ReInstall', 'Type' => 'button', 'Desc' => '重新安装'),
                array('Name' => 'InstallData', 'Type' => 'button', 'Desc' => '测试数据', 'IsDisabled' => $IsDisabledInstallData),
                array('Name' => 'Del', 'Type' => 'button', 'Desc' => '删除模版', 'IsDisabled' => $IsDisabledDel),
            );
        }
        $KeyArr = array(
            'Name' => array('Name' => '模版名称', 'Td' => 'th'),
            'NameKey' => array('Name' => '模版文件夹', 'Td' => 'th'),
            'VersionView' => array('Name' => '当前版本', 'Td' => 'th'),
            'TsView' => array('Name' => '安装时间', 'Td' => 'th'),
        );
        $this->BuildObj->PrimaryKey = 'TemplatesId';
        $PageBar = $this->CommonObj->PageBar($Count, $this->PageNum);
        $this->BuildObj->IsAdd = $this->BuildObj->IsEdit = $this->BuildObj->IsDel = false;
        $tmp['Json'] = $Json;
        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr, $PageBar, 'table-sm');
        $this->LoadView('admin/templates/installed', $tmp);
    }
}