<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class ModelField extends ControllersAdmin {

    public function index_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('ModelId'))) $this->Err(1001);
        $Rs = $this->Sys_modelObj->getOne($_GET['ModelId']);

        if(empty($Rs)) $this->Err(1003);
        $Arr = empty($Rs['FieldJson']) ? array() : json_decode($Rs['FieldJson'], true);
        foreach($Arr as $k => $v){
            $Arr[$k]['Index'] = $k;
            $Arr[$k]['NotNullView'] = ($v['NotNull'] == 1) ? '<iconpark-icon size="1.2rem" name="check" class="text-success"></iconpark-icon>' : '<iconpark-icon size="1.2rem" name="close" class="text-danger"></iconpark-icon>';
            $Arr[$k]['IsList'] = ($v['IsList'] == 1) ? '<iconpark-icon size="1.2rem" name="check" class="text-success"></iconpark-icon>' : '<iconpark-icon size="1.2rem" name="close" class="text-danger"></iconpark-icon>';
        }
        $this->PageTitle2 = $this->BuildObj->FormTitle($Rs['Name'].'字段管理');
        $KeyArr = array(
            'Name' => array('Name' => '字段名', 'Td' => 'th'),
            'Comment' => array('Name' => '字段说明', 'Td' => 'th'),
            'Type' => array('Name' => '字段类型', 'Td' => 'th'),
            'NotNullView' => array('Name' => '不能为空', 'Td' => 'th'),
            'IsList' => array('Name' => '列表显示', 'Td' => 'th'),
        );
        $this->BuildObj->PrimaryKey = 'Index';
        $this->BuildObj->TableTopBtnArr = array(
            array('Desc' => '返回', 'Link' => $this->CommonObj->Url(array('admin', 'model', 'index')), 'Class' => 'default'),
        );
        //$this->BuildObj->IsEdit = false;
        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr, '', 'table-sm');
        $this->LoadView('admin/common/list', $tmp);
    }

    public function add_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('ModelId'))) $this->Err(1001);
        $Rs = $this->Sys_modelObj->SetCond(array('ModelId' => $_GET['ModelId']))->ExecSelectOne();
        if(empty($Rs)) $this->Err(1003);
        $Arr = empty($Rs['FieldJson']) ? array() : json_decode($Rs['FieldJson'], true);
        //$this->PageTitle2 = $this->BuildObj->FormTitle($Rs['Name'].'字段管理');
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Name', 'Comment', 'Type'))) $this->Err(1001);
            if(!$this->VeriObj->IsPassword($_POST['Name'], 1, 20)) $this->Err(1048);
            if(in_array($_POST['Name'], $this->DefaultField)) $this->Err(1053);
            $NameArr = array_column($Arr, 'Name');
            if(in_array(trim($_POST['Name']), $NameArr)) $this->Err(1004);
            $DbConfig = Config::DbConfig();
            $AddField = array(
                'Name' => $this->CommonObj->SafeInput(trim($_POST['Name'])), 
                'Comment' => $this->CommonObj->SafeInput(trim($_POST['Comment'])), 
                'Type' => $this->CommonObj->SafeInput(trim($_POST['Type'])), 
                'Content' => $this->CommonObj->SafeInput(trim($_POST['Content'])), 
                'NotNull' => intval($_POST['NotNull']), 
                'IsList' => intval($_POST['IsList']), 
                'Data' => $this->CommonObj->SafeInput(trim($_POST['Data']))                
            );
            $Arr[] = $AddField;
            list($FieldType, $FieldDefault) = $this->Sys_modelObj->GetField($AddField['Type']);
            try{
                DB::$s_db_obj->beginTransaction();
                $this->Sys_modelObj->SetCond(array('ModelId' => $Rs['ModelId']))->SetUpdate(array('FieldJson' => json_encode($Arr, JSON_UNESCAPED_UNICODE)))->ExecUpdate();
                $this->Sys_modelObj->exec('alter table `'.$DbConfig['Prefix'].'table_'.$Rs['KeyName'].'` add '.$AddField['Name'].' '.$FieldType.' not null '.$FieldDefault.' COMMENT "'.$AddField['Comment'].'";', array());
                DB::$s_db_obj->commit();
            }catch (PDOException $e){
                DB::$s_db_obj->rollBack();
                $this->Err(1002);
            }
            $this->Sys_modelObj->cleanList();
            $this->Jump(array('admin', 'modelField', 'index'), 1888);
        }

        $this->BuildObj->Arr = array(
            array('Name' =>'Comment', 'Desc' => '字段说明',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 6),
            array('Name' =>'Name', 'Desc' => '字段名 (只能英文和数字)',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 3),
            array('Name' =>'Type', 'Desc' => '字段类型',  'Type' => 'select', 'Data' => $this->FieldArr, 'Value' => 'input', 'Required' => 1, 'Col' => 3),
            array('Name' =>'Data', 'Desc' => '选择值(数据类型为select、radio、checkbox 时填写)',  'Type' => 'input', 'Value' => '', 'Required' => 0, 'Col' => 12),
            array('Name' =>'Content', 'Desc' => '默认值',  'Type' => 'textarea', 'Value' => '', 'Required' => 0, 'Col' => 12, 'Row' => 4, 'Class' => 'Content'),
            array('Name' =>'NotNull', 'Desc' => '不能为空',  'Type' => 'radio', 'Data' => $this->IsArr, 'Value' => '1', 'Required' => 0, 'Col' => 12),
            array('Name' =>'IsList', 'Desc' => '列表显示',  'Type' => 'radio', 'Data' => $this->IsArr, 'Value' => '2', 'Required' => 0, 'Col' => 12),
        );
        $this->BuildObj->FormFooterBtnArr = array(
            array('Name' => 'back', 'Desc' => '返回', 'Type' => 'button', 'Class' => 'default'),
        );
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }

    public function edit_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('ModelId'))) $this->Err(1001);
        if(!isset($_GET['Index'])) $this->Err(1001);
        $Rs = $this->Sys_modelObj->getOne($_GET['ModelId']);
        if(empty($Rs)) $this->Err(1003);
        $Arr = empty($Rs['FieldJson']) ? array() : json_decode($Rs['FieldJson'], true);
        $Index = intval($_GET['Index']);
        $FieldRs = $Arr[$Index];
        if(!isset($Arr[$Index])) $this->Err(1048);
        $DbConfig = Config::DbConfig();
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Comment'))) $this->Err(1001);
            $AddField = array(
                'Name' => $this->CommonObj->SafeInput(trim($FieldRs['Name'])),
                'Comment' => $this->CommonObj->SafeInput(trim($_POST['Comment'])),
                'Type' => $this->CommonObj->SafeInput(trim($FieldRs['Type'])),
                'Content' => $this->CommonObj->SafeInput(trim($_POST['Content'])),
                'NotNull' => intval($_POST['NotNull']),
                'IsList' => intval($_POST['IsList']),
                'Data' => $this->CommonObj->SafeInput(trim($_POST['Data'])),
            );
            $Arr[$Index] = $AddField;

            list($FieldType, $FieldDefault) = $this->Sys_modelObj->GetField($AddField['Type']);

            try{
                DB::$s_db_obj->beginTransaction();
                $this->Sys_modelObj->SetCond(array('ModelId' => $Rs['ModelId']))->SetUpdate(array('FieldJson' => json_encode($Arr, JSON_UNESCAPED_UNICODE)))->ExecUpdate();
                $this->Sys_modelObj->exec('ALTER TABLE `'.$DbConfig['Prefix'].'table_'.$Rs['KeyName'].'` MODIFY COLUMN '.$FieldRs['Name'].' '.$FieldType.' not null '.$FieldDefault.' COMMENT "'.$AddField['Comment'].'";', array());
                DB::$s_db_obj->commit();
            }catch (PDOException $e){
                DB::$s_db_obj->rollBack();
                $this->Err(1002);
            }
            $this->Sys_modelObj->clean($Rs['ModelId']);
            $this->Jump(array('admin', 'modelField', 'index'), 1888);
        }
        $FieldRs = $Arr[$Index];
        $this->BuildObj->Arr = array(
            array('Name' =>'Comment', 'Desc' => '字段说明',  'Type' => 'input', 'Value' => $FieldRs['Comment'], 'Required' => 1, 'Col' => 6),
            array('Name' =>'Name', 'Desc' => '字段名 (只能英文和数字)',  'Type' => 'input', 'Value' => $FieldRs['Name'], 'Disabled' => 1, 'Col' => 3),

            array('Name' =>'Type', 'Desc' => '字段类型',  'Type' => 'select', 'Data' => $this->FieldArr, 'Value' => $FieldRs['Type'], 'Disabled' => 1, 'Col' => 3),
            array('Name' =>'Content', 'Desc' => '默认值',  'Type' => 'textarea', 'Value' => $FieldRs['Content'], 'Required' => 0, 'Col' => 12, 'Row' => 4, 'Class' => 'Content'),
            array('Name' =>'Data', 'Desc' => '选择值(数据类型为select、radio、checkbox 时填写)',  'Type' => 'input', 'Value' => $FieldRs['Data'], 'Required' => 0, 'Col' => 12),
            array('Name' =>'NotNull', 'Desc' => '不能为空',  'Type' => 'radio', 'Data' => $this->IsArr, 'Value' => $FieldRs['NotNull'], 'Required' => 0, 'Col' => 12, 'Row' => 4, 'Class' => 'Content'),
            array('Name' =>'IsList', 'Desc' => '列表显示',  'Type' => 'radio', 'Data' => $this->IsArr, 'Value' => $FieldRs['IsList'], 'Required' => 0, 'Col' => 12),
        );
        $this->BuildObj->FormFooterBtnArr = array(
            array('Name' => 'back', 'Desc' => '返回', 'Type' => 'button', 'Class' => 'default'),
        );
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }

    public function del_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('ModelId'))) $this->Err(1001);
        if(!isset($_GET['Index'])) $this->Err(1001);
        $Rs = $this->Sys_modelObj->getOne($_GET['ModelId']);
        if(empty($Rs)) $this->Err(1003);
        $Arr = empty($Rs['FieldJson']) ? array() : json_decode($Rs['FieldJson'], true);
        $Index = intval($_GET['Index']);
        if(!isset($Arr[$Index])) $this->Err(1048);
        $DbConfig = Config::DbConfig();
        $FieldRs = $Arr[$Index];
        array_splice($Arr, $Index, 1);
        $FieldArr = $this->Sys_modelObj->query('SHOW FULL COLUMNS FROM `'.$DbConfig['Prefix'].'table_'.$Rs['KeyName'].'`', array());
        $FieldNameArr = array_column($FieldArr, 'Field');
        try{
            DB::$s_db_obj->beginTransaction();
            $this->Sys_modelObj->SetCond(array('ModelId' => $Rs['ModelId']))->SetUpdate(array('FieldJson' => json_encode($Arr, JSON_UNESCAPED_UNICODE)))->ExecUpdate();
            if(in_array($FieldRs['Name'], $FieldNameArr)){
                $this->Sys_modelObj->exec('ALTER TABLE `'.$DbConfig['Prefix'].'table_'.$Rs['KeyName'].'` DROP '.$FieldRs['Name'].';', array());
            }
            DB::$s_db_obj->commit();
        }catch(PDOException $e){
            DB::$s_db_obj->rollBack();
            $this->Err(1002);
        }
        $this->Sys_modelObj->clean($Rs['ModelId']);
        $this->Sys_modelObj->cleanList();
        $this->Jump(array('admin', 'modelField', 'index'), 1888);
    }


}