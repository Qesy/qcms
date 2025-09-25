<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Plugin extends ControllersAdmin {   
    
    public function market_Action(){
        if(empty($this->SysRs['BindPhone'])){
            $this->LoadView('admin/templates/marketBind');
            return;
        }
        $Page = intval($_GET['Page']);
        if($Page < 1) $Page = 1;
        $PageNum = 12;
        $CateId = intval($_GET['CateId']);
        
        $pluginPaidRet = $this->apiRemotePlatform('apiRemote/pluginPaid', array());
        
        $tmp['PaidIDs'] = $pluginPaidRet['Data'];
        $Ret = $this->getPlugin($Page, $PageNum, $CateId);
        $CateArr = $this->getPluginCate();
        $tmp['CateArr'] = $CateArr['Data'];
        $tmp['Arr'] = $Ret['Data']['List'];
        $tmp['Page'] = $this->CommonObj->PageBar($Ret['Data']['Count'], $PageNum);
        $InstalledArr = $this->PluginObj->ExecSelect();
        $tmp['TempFolder'] = array_column($InstalledArr, 'NameKey', 'NameKey');        
        //$tmp['TempFolder'] = $this->getTempFolder();
        $this->LoadView('admin/plugin/market', $tmp);
    }
    
    public function installed_Action(){
        $Page = intval($_GET['Page']);
        if($Page < 1) $Page = 1;
        $Count = 0;
        $Limit = array(($Page-1)*$this->PageNum, $this->PageNum);
        $CondArr = array();
        $Arr = $this->PluginObj->SetCond($CondArr)->SetLimit($Limit)->SetSort(array('PluginId' => 'ASC'))->ExecSelectAll($Count);
        $PluginIds = array_column($Arr, 'PluginId');
        $Ret = $this->getPlugin($Page, count($PluginIds), 0, $PluginIds, 0);
        if($Ret['Code'] != 0) $this->ApiErr(1002);
        $OnlinePluginMap = array();
        foreach($Ret['Data']['List'] as $v){
            $OnlinePluginMap[$v['PluginId']] = $v;
        }
        $Json = array();
        foreach($Arr as $v){
            $OnlineRs = $OnlinePluginMap[$v['PluginId']];
            $Json[$v['PluginId']] = array(
                'LastVersion' => $OnlineRs['LastVersion'],
                'Version' => $v['Version'],
            );
        }
 
        foreach($Arr as $k => $v){
            $OnlineRs = $OnlinePluginMap[$v['PluginId']];
            $Desc = empty($OnlineRs['Content']) ? '暂无介绍' : $OnlineRs['Content'];
            $Arr[$k]['NameView'] = '<div class="d-flex"><img class="mr-2" src="'.$OnlineRs['Pic'].'" style="height:60px;"><div><span class="font-weight-bold">'.$OnlineRs['Name'].'</span><br>'.$Desc.'</div></div>';
            $Arr[$k]['TsView'] = '安装时间:'.date('Y-m-d', $v['TsAdd']).'<br>更新时间:'.date('Y-m-d', $v['TsUpdate']);
            $Arr[$k]['VersionView'] = '当前版本:'.$v['Version'].'<br>最新版本:'.$OnlineRs['LastVersion'];
            $IsDisabledUpdate = ($v['Version'] == $OnlineRs['LastVersion']) ? 1 : 0;
            $IsDisabledUninstall = ($v['State'] == '1') ? 1 : 0;
            $Config = json_decode($v['Config'], true);
            $Link = empty($Config) ? '#' : $this->CommonObj->Url(array('admin', 'plugin', 'config'));
            $IsDisabledConfig = ($Link == '#') ? 1 : 0;
            $Arr[$k]['BtnArr'] = array(
                array('Name' => 'Config', 'Link' => $Link, 'Para' => array('PluginId' => $v['PluginId']), 'Desc' => '设置插件', 'IsDisabled' => $IsDisabledConfig),
                array('Name' => 'Update', 'Type' => 'button', 'Desc' => '更新插件', 'IsDisabled' => $IsDisabledUpdate),
                array('Name' => 'Uninstall', 'Type' => 'button', 'Desc' => '卸载插件', 'IsDisabled' => $IsDisabledUninstall),
            );
        }
        $KeyArr = array(
            'NameView' => array('Name' => '插件名称', 'Td' => 'th'),
            'NameKey' => array('Name' => '插件文件夹', 'Td' => 'th'),
            'VersionView' => array('Name' => '当前版本', 'Td' => 'th'),
            'TsView' => array('Name' => '安装时间', 'Td' => 'th'),
            'State' => array('Name' => '状态', 'Td' => 'th', 'Type' => 'Switch'),
        );
        $this->BuildObj->PrimaryKey = 'PluginId';
        $PageBar = $this->CommonObj->PageBar($Count, $this->PageNum);
        $this->BuildObj->IsAdd = $this->BuildObj->IsEdit = $this->BuildObj->IsDel = false;
        $tmp['Json'] = $Json;
        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr, $PageBar, 'table-sm');
        $this->BuildObj->Js = 'var ChangeStateUrl="'.$this->CommonObj->Url(array('admin', 'api', 'pluginState')).'";';
        $this->LoadView('admin/plugin/installed', $tmp);
    }
    
    public function config_Action(){ //插件配置
        if(!$this->VeriObj->VeriPara($_GET, array('PluginId'))) $this->Err(1001);
        $PlugRs = $this->PluginObj->getOne($_GET['PluginId']);
        if(empty($PlugRs)) $this->Err(1026);
        $PlugPath = './Plugin/'.$PlugRs['NameKey'];
        $ConfigRs = json_decode($PlugRs['Config'], true);
        $ConfigMap = require_once $PlugPath.'/Lib/Config.php';
        $this->BuildObj->Arr = $ConfigMap['Form'];
        $RequireKey = array();
        foreach($this->BuildObj->Arr as $k =>$v){
            if($v['Required'] == 1) $RequireKey[] = $v['Name'];
        }
        if(!empty($_POST)){
            if(empty($this->BuildObj->Arr)) $this->Err(1038); //不需要修改
            if(!$this->VeriObj->VeriPara($_POST, $RequireKey)) $this->Err(1001);
            $Result = $this->PluginObj->SetCond(array('PluginId' => $PlugRs['PluginId']))->SetUpdate(array('Config' => json_encode($_POST)))->ExecUpdate();
            if($Result === false) $this->Err(1002);
            $this->PluginObj->clean($PlugRs['PluginId']);
            $this->Jump(array('admin', 'plugin', 'installed'));
        }
        foreach($this->BuildObj->Arr as $k => $v){
            if(isset($ConfigRs[$v['Name']])) $this->BuildObj->Arr[$k]['Value'] = $ConfigRs[$v['Name']];
        }
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
}