<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Develop extends ControllersAdmin {
    
    public function templates_Action(){
        if(empty($this->SysRs['BindPhone'])){
            $this->LoadView('admin/templates/marketBind');
            return;
        }
        $Page = intval($_GET['Page']);
        if($Page < 1) $Page = 1;
        $PageNum = 12;
        $CateId = intval($_GET['CateId']);
        $InstalledArr = $this->TemplatesObj->ExecSelect();
        $InstalledIds = array_column($InstalledArr, 'TemplatesId');
        $Ret = $this->apiRemotePlatform('apiRemote/devTemplates', array('P' => $Page));
        if($Ret['Code'] != 0) {
            $this->CommonObj->LogWrite($Ret['Msg']);
            $this->Err(1000, $Ret['Msg']);
        }
        foreach($Ret['Data']['List'] as $k => $v){
            $Ret['Data']['List'][$k]['NameView'] = '<span class="font-weight-bold">'.$v['Name'].'</span>';
            $Ret['Data']['List'][$k]['StateView'] = '<span class="badge badge-'.$this->StateDevColorMap[$v['State']].'">'.$this->StateDevMap[$v['State']].'</span>';
            $IsDisabled = in_array($v['TemplatesId'], $InstalledIds) ? 1 : 0;
            $Ret['Data']['List'][$k]['BtnArr'] = array(
                array('Name' => 'Install', 'Desc' => '安装', 'IsDisabled' => $IsDisabled),
            );
        }
        $KeyArr = array(
            'TemplatesId' => array('Name' => 'ID', 'Td' => 'th'),
            'Name' => array('Name' => '模版名称', 'Td' => 'th'),
            'NameKey' => array('Name' => '文件夹', 'Td' => 'th'),
            'Price' => array('Name' => '价格', 'Td' => 'th'),
            'BuyNum' => array('Name' => '购买数', 'Td' => 'th'),
            'StateView' => array('Name' => '状态', 'Td' => 'th'),            
        );
        $this->BuildObj->PrimaryKey = 'TemplatesId';
        $PageBar = $this->CommonObj->PageBar($Ret['Data']['Count'], $this->PageNum);
        $this->BuildObj->IsAdd = $this->BuildObj->IsEdit = $this->BuildObj->IsDel = false;
        $tmp['Table'] = $this->BuildObj->Table($Ret['Data']['List'], $KeyArr, $PageBar, 'table-sm');        
        $this->LoadView('admin/develop/templates', $tmp);
    }
    
    public function plugin_Action(){
        if(empty($this->SysRs['BindPhone'])){
            $this->LoadView('admin/templates/marketBind');
            return;
        }
        $Page = intval($_GET['Page']);
        if($Page < 1) $Page = 1;
        $PageNum = 12;
        $CateId = intval($_GET['CateId']);
        $InstalledArr = $this->PluginObj->ExecSelect();
        $InstalledPluginsIds = array_column($InstalledArr, 'PluginId');
        $Ret = $this->apiRemotePlatform('apiRemote/devPlugin', array('P' => $Page));
        if($Ret['Code'] != 0) {
            $this->CommonObj->LogWrite($Ret['Msg']);
            $this->Err(1000, $Ret['Msg']);
        }
        foreach($Ret['Data']['List'] as $k => $v){
            $Ret['Data']['List'][$k]['NameView'] = '<span class="font-weight-bold">'.$v['Name'].'</span>';
            $Ret['Data']['List'][$k]['StateView'] = '<span class="badge badge-'.$this->StateDevColorMap[$v['State']].'">'.$this->StateDevMap[$v['State']].'</span>';
            $IsDisabled = in_array($v['PluginId'], $InstalledPluginsIds) ? 1 : 0;
            $Ret['Data']['List'][$k]['BtnArr'] = array(
                array('Name' => 'Install', 'Desc' => '安装', 'IsDisabled' => $IsDisabled),
            );
        }
        $KeyArr = array(
            'PluginId' => array('Name' => 'ID', 'Td' => 'th'),
            'NameView' => array('Name' => '插件名称', 'Td' => 'th'),
            'NameKey' => array('Name' => '文件夹', 'Td' => 'th'),
            'Price' => array('Name' => '价格', 'Td' => 'th'),
            'BuyNum' => array('Name' => '购买数', 'Td' => 'th'),
            'StateView' => array('Name' => '状态', 'Td' => 'th'),
        );
        $this->BuildObj->PrimaryKey = 'PluginId';
        $PageBar = $this->CommonObj->PageBar($Ret['Data']['Count'], $this->PageNum);
        $this->BuildObj->IsAdd = $this->BuildObj->IsEdit = $this->BuildObj->IsDel = false;
        $tmp['Table'] = $this->BuildObj->Table($Ret['Data']['List'], $KeyArr, $PageBar, 'table-sm');
        $this->LoadView('admin/develop/plugin', $tmp);
    }
    
}