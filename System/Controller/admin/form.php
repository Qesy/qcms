<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Form extends ControllersAdmin {
    
    public function index_Action(){
        $Page = intval($_GET['Page']);
        if($Page < 1) $Page = 1;
        $Count = 0;
        $Limit = array(($Page-1)*$this->PageNum, $this->PageNum);
        $CondArr = array();
        $Arr = $this->Sys_formObj->SetCond($CondArr)->SetLimit($Limit)->SetSort(array('Sort' => 'ASC', 'FormId' => 'ASC'))->ExecSelectAll($Count);
        foreach($Arr as $k => $v){
            $Arr[$k]['KeyNameView'] = '<input class="form-control" disabled="disabled" type="text" value="{{Label:'.$v['KeyName'].'}}"/>';
            $Arr[$k]['Url'] = '<input class="form-control" disabled="disabled" type="text" value="'.$_SERVER['REQUEST_SCHEME'].'://'.URL_DOMAIN.'/index/form?KeyName='.$v['KeyName'].'"/>';
            $Arr[$k]['SortView'] = '<input class="form-control" type="text" value="'.$v['Sort'].'"/>';
            $Arr[$k]['IsLoginView'] = ($v['IsLogin'] == 1) ? '需登录' : '无需登录';
            $Arr[$k]['StateDefaultView'] = ($v['StateDefault'] == 1) ? '已审核' : '未审核';
            $Arr[$k]['BtnArr'] = array(
                array('Name' => '字段管理', 'Color' => 'success', 'Link' => $this->CommonObj->Url(array('admin', 'formField', 'index'))),
            );
        }
        $KeyArr = array(
            'FormId' => array('Name' => 'ID', 'Td' => 'th'),
            'Name' => array('Name' => '标签名', 'Td' => 'th'),
            'IsLoginView' => array('Name' => '是否需登录', 'Td' => 'th'),
            'StateDefaultView' => array('Name' => '数据默认状态', 'Td' => 'th'),
            'Url' => array('Name' => '访问地址', 'Td' => 'th', 'Style' => 'width:400px;'),
            'State' => array('Name' => '状态', 'Td' => 'th', 'Type' => 'Switch'),
            'SortView' => array('Name' => '排序', 'Td' => 'th', 'Style' => 'width:100px;'),
            
        );
        $this->BuildObj->PrimaryKey = 'FormId';

        //$this->BuildObj->IsDel = $this->BuildObj->IsAdd = $this->BuildObj->IsEdit = false;
        $PageBar = $this->CommonObj->PageBar($Count, $this->PageNum);
        $this->BuildObj->Js = 'var ChangeStateUrl="'.$this->CommonObj->Url(array('admin', 'api', 'FormState')).'";';
        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr, $PageBar);
        $this->LoadView('admin/common/list', $tmp);
    }
    
    public function add_Action(){
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Name', 'KeyName', 'TempDetail', 'IsLogin', 'StateDefault'))) $this->Err(1001);
            if(!$this->VeriObj->IsPassword($_POST['KeyName'], 1, 30)) $this->Err(1048);
            $Count = $this->Sys_formObj->SetCond(array('KeyName' => trim($_POST['KeyName'])))->SetField('COUNT(*) AS c')->ExecSelectOne();
            if($Count['c'] > 0) $this->Err(1004);
            $DbConfig = DbConfig();
            try{
                DB::$s_db_obj->beginTransaction();
                $this->Sys_formObj->SetInsert(array(
                    'Name' => $_POST['Name'],
                    'KeyName' => $_POST['KeyName'],
                    'TempDetail' => $_POST['TempDetail'],
                    'IsLogin' => $_POST['IsLogin'],
                    'StateDefault' => $_POST['StateDefault'],
                    'State' => 1,
                    'Sort' => 99,
                ))->ExecInsert();
                $FieldArr = array();
                $FieldArr[] = '`FormId` bigint(20) NOT NULL auto_increment COMMENT \'\','.PHP_EOL;
                $FieldArr[] = '`UserId` bigint(20) NOT NULL DEFAULT \'0\' COMMENT \'\','.PHP_EOL;
                $FieldArr[] = '`State` tinyint(3) NOT NULL DEFAULT \'2\' COMMENT \'\','.PHP_EOL;
                $FieldArr[] = '`TsAdd` bigint(20) NOT NULL DEFAULT \'0\' COMMENT \'\','.PHP_EOL;
                $TableSql = 'CREATE TABLE `'.$DbConfig['Prefix'].'_form_'.$_POST['KeyName'].'` ( '.PHP_EOL.implode('', $FieldArr).' PRIMARY KEY (`FormId`)) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT=\'\';';
                if ($this->SysObj->exec($TableSql, array()) === false) throw new PDOException(self::lang(1025));
                DB::$s_db_obj->commit();
            }catch (PDOException $e){
                DB::$s_db_obj->rollBack();
                $this->Err(1002);
            }

            $this->Jump(array('admin', 'form', 'index'), 1888);
        }
        $TempList = $this->getTemplate('form_');        
        $this->BuildObj->Arr = array(
            array('Name' =>'Name', 'Desc' => '表单名字',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 6),
            array('Name' =>'KeyName', 'Desc' => '调用名字 (只能英文和数字)',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 6),
            array('Name' =>'TempDetail', 'Desc' => '表单模板',  'Type' => 'select', 'Data' => $TempList, 'Value' => array_keys($TempList)[0], 'Required' => 1, 'Col' => 12),
            array('Name' =>'IsLogin', 'Desc' => '是否需要登录交',  'Type' => 'radio', 'Data' =>$this->IsArr, 'Value' => '2', 'Required' => 0, 'Col' => 3),
            array('Name' =>'StateDefault', 'Desc' => '默认已审核',  'Type' => 'radio', 'Data' =>$this->IsArr, 'Value' => '1', 'Required' => 0, 'Col' => 3),      
        );        
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function edit_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('FormId'))) $this->Err(1001);
        $Rs = $this->Sys_formObj->getOne($_GET['FormId']);
        if(empty($Rs)) $this->Err(1003);
        
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Name', 'TempDetail', 'IsLogin', 'StateDefault'))) $this->Err(1001);
            $Ret = $this->Sys_formObj->SetCond(array('FormId' => $Rs['FormId']))->SetUpdate(array(
                'Name' => $_POST['Name'],
                'TempDetail' => $_POST['TempDetail'],
                'IsLogin' => $_POST['IsLogin'],
                'StateDefault' => $_POST['StateDefault'],
            ))->ExecUpdate();
            if($Ret === false) $this->Err(1002);
            $this->Sys_formObj->clean($Rs['FormId']);
            $this->Jump(array('admin', 'form', 'index'), 1888);
        }
        $TempList = $this->getTemplate('form_');
        
        $this->BuildObj->Arr = array(
            array('Name' =>'Name', 'Desc' => '表单名字',  'Type' => 'input', 'Value' => $Rs['Name'], 'Required' => 1, 'Col' => 6),
            array('Name' =>'KeyName', 'Desc' => '调用名字 (只能英文和数字)',  'Disabled' => 1, 'Type' => 'input', 'Value' => $Rs['KeyName'], 'Required' => 1, 'Col' => 6),
            array('Name' =>'TempDetail', 'Desc' => '表单模板',  'Type' => 'select', 'Data' => $TempList, 'Value' => $Rs['TempDetail'], 'Required' => 1, 'Col' => 12),
            array('Name' =>'IsLogin', 'Desc' => '是否需要登录交',  'Type' => 'radio', 'Data' =>$this->IsArr, 'Value' => $Rs['IsLogin'], 'Required' => 0, 'Col' => 3),
            array('Name' =>'StateDefault', 'Desc' => '默认已审核',  'Type' => 'radio', 'Data' =>$this->IsArr, 'Value' => $Rs['StateDefault'], 'Required' => 0, 'Col' => 3),
        );
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function del_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('FormId'))) $this->Err(1001);
        $Rs = $this->Sys_formObj->getOne($_GET['FormId']);
        if(empty($Rs)) $this->Err(1003);
        $DbConfig = DbConfig();
        $Count = $this->Sys_formObj->SetTbName('form_'.$Rs['KeyName'])->SetField('COUNT(*) AS c')->ExecSelectOne();
        if($Count['c'] > 0) $this->Err(1050);
        try{
            DB::$s_db_obj->beginTransaction();            
            $this->SysObj->exec('DROP TABLE IF EXISTS `'.$DbConfig['Prefix'].'form_'.$Rs['KeyName'].'`;', array()); //删除原有表
            $this->Sys_formObj->SetCond(array('FormId' => $Rs['FormId']))->ExecDelete();
            DB::$s_db_obj->commit();
        }catch (PDOException $e){
            DB::$s_db_obj->rollBack();
            $this->Err(1002);
        }
        $this->Sys_formObj->clean($Rs['FormId']);
        $this->Jump(array('admin', 'form', 'index'), 1888);
    }
    

    
}