<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Model extends ControllersAdmin {
    
    public function index_Action(){
        $Arr = $this->Sys_modelObj->getList();
        foreach($Arr as $k => $v){
            $Arr[$k]['IsSysView'] = ($v['IsSys'] == 1) ? '<i class="bi bi-check-lg text-success h5"></i>' : '<i class="bi bi-x-lg text-danger h5"></i>';
            $Arr[$k]['BtnArr'] = array(
                array('Desc' => '字段管理', 'Color' => 'success', 'Link' => $this->CommonObj->Url(array('admin', 'modelField', 'index'))),                
            );
        }
        $KeyArr = array(
            'ModelId' => array('Name' => 'ID', 'Td' => 'th'),
            'Name' => array('Name' => '模型名', 'Td' => 'th'),
            'KeyName' => array('Name' => '标识名', 'Td' => 'th'),
            'IsSysView' => array('Name' => '系统内置', 'Td' => 'th'),       
        );
        $this->BuildObj->PrimaryKey = 'ModelId';
        $this->BuildObj->TableTopBtnArr = array(
            array('Name' => '分类管理', 'Link' => $this->CommonObj->Url(array('admin', 'linkCate', 'index'))),
        );
        $this->BuildObj->NameAdd = '添加模型';

        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr);
        $this->LoadView('admin/common/list', $tmp);
    }
    
    public function add_Action(){
        if(!empty($_POST)){
            $DbConfig = DbConfig();
            if(!$this->VeriObj->VeriPara($_POST, array('Name', 'KeyName'))) $this->Err(1001);
            try{
                DB::$s_db_obj->beginTransaction();
                $this->Sys_modelObj->SetInsert(array('Name' => trim($_POST['Name']), 'KeyName' => trim($_POST['KeyName'])))->ExecInsert();
                $FieldArr = array();
                $FieldArr[] = '`Id` bigint(20) NOT NULL COMMENT \'\','.PHP_EOL;
                $FieldArr[] = '`Content` text COMMENT \'\','.PHP_EOL;
                $TableSql = 'CREATE TABLE `'.$DbConfig['Prefix'].'table_'.$_POST['KeyName'].'` ( '.PHP_EOL.implode('', $FieldArr).' PRIMARY KEY (`Id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT=\'\';';
                $this->SysObj->exec($TableSql, array());
                DB::$s_db_obj->commit();
            }catch (PDOException $e){
                DB::$s_db_obj->rollBack();
                $this->Err(1002);
            }
            $this->Sys_modelObj->cleanList();
            $this->Jump(array('admin', 'model', 'index'), 1888);
        }
        $this->BuildObj->Arr = array(
            array('Name' =>'Name', 'Desc' => '模型名字',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 6),
            array('Type' => 'htmlFill', 'Value' => '', 'Required' => 1, 'Col' => 6),
            array('Name' =>'KeyName', 'Desc' => '标识名字 (只能英文和数字)',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 6),
            
        );
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function edit_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('ModelId'))) $this->Err(1001);
        $Rs = $this->Sys_modelObj->SetCond(array('ModelId' => $_GET['ModelId']))->ExecSelectOne();
        if(empty($Rs)) $this->Err(1003);
        
        if(!empty($_POST)){
            $DbConfig = DbConfig();
            if(!$this->VeriObj->VeriPara($_POST, array('Name'))) $this->Err(1001);
            try{
                DB::$s_db_obj->beginTransaction();
                $this->Sys_modelObj->SetCond(array('ModelId' => $Rs['ModelId']))->SetUpdate(array('Name' => trim($_POST['Name'])))->ExecUpdate();                
                DB::$s_db_obj->commit();
            }catch (PDOException $e){
                DB::$s_db_obj->rollBack();
                $this->Err(1002);
            }
            $this->Sys_modelObj->cleanList();
            $this->Jump(array('admin', 'model', 'index'), 1888);
        }
        
        $this->BuildObj->Arr = array(
            array('Name' =>'Name', 'Desc' => '模型名字',  'Type' => 'input', 'Value' => $Rs['Name'], 'Required' => 1, 'Col' => 6),
            array('Type' => 'htmlFill', 'Value' => '', 'Required' => 1, 'Col' => 6),
            array('Name' =>'KeyName', 'Desc' => '标识名字 (只能英文和数字)',  'Type' => 'input', 'Value' => $Rs['KeyName'], 'Disabled' => 1, 'Col' => 6),
            
        );
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function del_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('ModelId'))) $this->Err(1001);
        $Rs = $this->Sys_modelObj->SetCond(array('ModelId' => $_GET['ModelId']))->ExecSelectOne();
        if(empty($Rs)) $this->Err(1003);
        if($Rs['IsSys'] == 1) $this->Err(1051);
        $DbConfig = DbConfig();
        $TableArr = $this->TableObj->query('show tables', array());
        $TableNameArr = array_column($TableArr, 'Tables_in_'.$DbConfig['Name']);
        if(in_array($DbConfig['Prefix'].'table_'.$Rs['KeyName'], $TableNameArr)){
            $Count = $this->Sys_modelObj->SetTbName('table_'.$Rs['KeyName'])->SetField('COUNT(*) AS c')->ExecSelectOne();
            if($Count['c'] > 0) $this->Err(1050);
            $HaveCate = $this->CategoryObj->SetCond(array('ModelId' => $Rs['ModelId']))->SetField('COUNT(*) AS c')->ExecSelectOne();
            if($HaveCate['c'] > 0) $this->Err(1050);
        }      
        
        try{
            DB::$s_db_obj->beginTransaction();
            if(in_array($DbConfig['Prefix'].'table_'.$Rs['KeyName'], $TableNameArr)){
                $this->SysObj->exec('DROP TABLE IF EXISTS `'.$DbConfig['Prefix'].'table_'.$Rs['KeyName'].'`;', array()); //删除原有表
            }
            $this->Sys_modelObj->SetCond(array('ModelId' => $Rs['ModelId']))->ExecDelete();
            DB::$s_db_obj->commit();
        }catch (PDOException $e){
            DB::$s_db_obj->rollBack();
            $this->Err(1002);
        }
        $this->Sys_modelObj->cleanList();
        $this->Jump(array('admin', 'model', 'index'), 1888);
    }
    
}