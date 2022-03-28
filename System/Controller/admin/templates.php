<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Templates extends ControllersAdmin {
    
    public $TempType = array(
        'index' => '首页',
        'list' => '列表',
        'detail' => '详情',
        'form' => '表单',
        'component' => '组件',
        'page' => '单页',
    );
    public $TempModelType = array(
        'article' => '文章',
        'product' => '产品',
        'album' => '相册',
        'down' => '下载',
        'default' => '默认',
        'main' => '主要',
        'cover' => '封面',
    );
    
    public function index_Action(){
        $TempList = $this->getTemplate();
        $Arr = array();
        $Desc = $Desc2 = '';
        $i = 0;
        foreach($TempList as $v){
            $i++;
            $FileArr = explode('_', substr($v, 0, -5));
            $Desc = $this->TempType[$FileArr[0]];            
            $Desc2 = isset($this->TempModelType[$FileArr[1]]) ? $this->TempModelType[$FileArr[1]] : '未知';
            $Desc3 = isset($FileArr[2]) ? $FileArr[2] : '';      
            $FilePath = PATH_TEMPLATE.$this->SysRs['TmpPath'].'/'.$v;
            $Size = $this->CommonObj->Size(filesize($FilePath));
            $Ts = filemtime($FilePath);
            $Arr[] = array('Id' => $i, 'Name' => $v, 'Desc' => $Desc3.$Desc2.$Desc, 'Size' => $Size, 'TsView' => date('Y-m-d H:i:s', $Ts));
        }
        $KeyArr = array(
            'Id' => array('Name' => 'ID', 'Td' => 'th'),
            'Name' => array('Name' => '文件名', 'Td' => 'th'),
            'Desc' => array('Name' => '描述'),
            'Size' => array('Name' => '大小'),
            'TsView' => array('Name' => '修改时间'),           
        );
        $this->BuildObj->PrimaryKey = 'Name';
        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr, '', 'table-sm');
        $this->LoadView('admin/common/list', $tmp);
    }
    
    public function add_Action(){
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Type', 'KeyName'))) $this->Err(1001);
            $File = $_POST['Type'].'_'.$_POST['KeyName'].'.html';
            $FilePath = PATH_TEMPLATE.$this->SysRs['TmpPath'].'/'.$File;
            $Ret = @file_put_contents($FilePath, $_POST['Html']);
            if($Ret === false) $this->Err(1002);
            $this->Jump(array('admin', 'templates', 'index'), 1888);
        }
        $this->BuildObj->Arr = array(
            array('Name' =>'Type', 'Desc' => '模板类型',  'Type' => 'select', 'Data' => $this->TempType, 'Value' => 'index', 'Required' => 1, 'Col' => 6),
            array('Name' =>'KeyName', 'Desc' => '模板名字 (article_diy)',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 6),  
            array('Name' =>'Html', 'Desc' => '模板HTML',  'Type' => 'textarea', 'Value' => '', 'Required' => 1, 'Col' => 12, 'Row' => 20),  
        );
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function edit_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Name'))) $this->Err(1001);
        $FilePath = PATH_TEMPLATE.$this->SysRs['TmpPath'].'/'.trim($_GET['Name']);
        if(!file_exists($FilePath)) $this->Err(1035);
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Type', 'KeyName'))) $this->Err(1001);
            $File = $_POST['Type'].'_'.$_POST['KeyName'].'.html';
            $NewFilePath = PATH_TEMPLATE.$this->SysRs['TmpPath'].'/'.$File;
            $Ret = @file_put_contents($NewFilePath, $_POST['Html']);
            if($File != trim($_GET['Name'])) @unlink($FilePath); // 如果改名了，就删除旧的文件
            if($Ret === false) $this->Err(1002);
            $this->Jump(array('admin', 'templates', 'index'), 1888);
        }
        $FileNameArr = explode('_', trim($_GET['Name']));
        $KeyName = substr(trim($_GET['Name']), strlen($FileNameArr[0])+1, -5);
        $Html = file_get_contents($FilePath);
        $this->BuildObj->Arr = array(
            array('Name' =>'Type', 'Desc' => '模板类型',  'Type' => 'select', 'Data' => $this->TempType, 'Value' => $FileNameArr[0], 'Required' => 1, 'Col' => 6),
            array('Name' =>'KeyName', 'Desc' => '模板名字 (article_diy)',  'Type' => 'input', 'Value' => $KeyName, 'Required' => 1, 'Col' => 6),
            array('Name' =>'Html', 'Desc' => '模板HTML',  'Type' => 'textarea', 'Value' => $Html, 'Required' => 1, 'Col' => 12, 'Row' => 20),
        );
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function del_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Name'))) $this->Err(1001);
        $FilePath = PATH_TEMPLATE.$this->SysRs['TmpPath'].'/'.trim($_GET['Name']);
        if(!file_exists($FilePath)) $this->Err(1035);
        $FilePath = PATH_TEMPLATE.$this->SysRs['TmpPath'].'/'.trim($_GET['Name']);
        @unlink($FilePath);
        $this->Jump(array('admin', 'templates', 'index'), 1888);
    }
    
}