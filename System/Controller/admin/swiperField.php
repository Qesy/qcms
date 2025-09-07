<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class SwiperField extends ControllersAdmin {
    
    public function index_Action(){
        if(!isset($this->SysRs['SwiperFieldJson'])) {
            $this->SysObj->SetInsert(array(
                'Name' => 'SwiperFieldJson',
                'Info' => '幻灯片字段管理',
                'AttrValue' => json_encode(array()),
                'GroupId' => 9,
                'AttrType' => 'textarea',
                'Sort' => 99,
                'IsSys' => 1,
            ))->ExecInsert();
            $this->SysObj->cleanList();
            $this->SysRs = $this->SysObj->getKv();
        }
        $Arr = json_decode($this->SysRs['SwiperFieldJson'], true);
        foreach($Arr as $k => $v){
            $Arr[$k]['Index'] = $k;
            $Arr[$k]['NotNullView'] = ($v['NotNull'] == 1) ? '<iconpark-icon size="1.2rem" name="check" class="text-success"></iconpark-icon>' : '<iconpark-icon size="1.2rem" name="close" class="text-danger"></iconpark-icon>';
            $Arr[$k]['IsList'] = ($v['IsList'] == 1) ? '<iconpark-icon size="1.2rem" name="check" class="text-success"></iconpark-icon>' : '<iconpark-icon size="1.2rem" name="close" class="text-danger"></iconpark-icon>';
        }
        $this->PageTitle2 = $this->BuildObj->FormTitle('幻灯片字段管理');
        $KeyArr = array(
            'Name' => array('Name' => '字段名', 'Td' => 'th'),
            'Comment' => array('Name' => '字段说明', 'Td' => 'th'),
            'Type' => array('Name' => '字段类型', 'Td' => 'th'),
            'NotNullView' => array('Name' => '不能为空', 'Td' => 'th'),
            //'IsList' => array('Name' => '列表显示', 'Td' => 'th'),
        );
        $this->BuildObj->PrimaryKey = 'Index';
        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr, '', 'table-sm');
        $this->LoadView('admin/common/list', $tmp);
    }
    
    public function add_Action(){
        $Arr = empty($this->SysRs['SwiperFieldJson']) ? array() : json_decode($this->SysRs['SwiperFieldJson'], true);
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Name', 'Comment', 'Type'))) $this->Err(1001);
            if(!$this->VeriObj->IsPassword($_POST['Name'], 1, 20)) $this->Err(1048);
            if(in_array($_POST['Name'], $this->SwiperFieldArr)) $this->Err(1053);
            $NameArr = array_column($Arr, 'Name');
            if(in_array(trim($_POST['Name']), $NameArr)) $this->Err(1004);
            $DbConfig = Config::DbConfig();
            $AddField = array('Name' => trim($_POST['Name']), 'Comment' => trim($_POST['Comment']), 'Type' => trim($_POST['Type']), 'Content' => trim($_POST['Content']), 'NotNull' => $_POST['NotNull'], 'Data' => trim($_POST['Data']));
            $Arr[] = $AddField;
            
            $FieldType = 'varchar(255)';
            $FieldDefault = "DEFAULT ''";
            if(in_array($AddField['Type'], array('textarea', 'editor'))){
                $FieldType = 'text';
                $FieldDefault = '';
            }elseif(in_array($AddField['Type'], array('number', 'datetime'))){
                $FieldType = 'bigint(20)';
                $FieldDefault = "DEFAULT '0'";
            }elseif(in_array($AddField['Type'], array('date'))){
                $FieldType = 'date';
                $FieldDefault = "DEFAULT '0000-00-00'";
            }elseif(in_array($AddField['Type'], array('money'))){
                $FieldType = 'decimal(10,2)';
                $FieldDefault = "DEFAULT '0.00'";
            }
            try{
                DB::$s_db_obj->beginTransaction();
                $this->SysObj->SetCond(array('Name' => 'SwiperFieldJson'))->SetUpdate(array('AttrValue' => json_encode($Arr)))->ExecUpdate();
                $this->Sys_modelObj->exec('alter table `'.$DbConfig['Prefix'].'swiper` add '.$AddField['Name'].' '.$FieldType.' not null '.$FieldDefault.' COMMENT "'.$AddField['Comment'].'";', array());
                DB::$s_db_obj->commit();
            }catch (PDOException $e){
                DB::$s_db_obj->rollBack();
                $this->Err(1002);
            }
            $this->SysObj->cleanList();
            $Arr = $this->Swiper_cateObj->ExecSelect();
            foreach($Arr as $v){
                $this->SwiperObj->clean($v['SwiperCateId']);
            }
            $this->Jump(array('admin', 'swiperField', 'index'), 1888);
        }
        
        $this->BuildObj->Arr = array(
            array('Name' =>'Comment', 'Desc' => '字段说明',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 6),
            array('Name' =>'Name', 'Desc' => '字段名 (只能英文和数字)',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 3),
            array('Name' =>'Type', 'Desc' => '字段类型',  'Type' => 'select', 'Data' => $this->FieldArr, 'Value' => 'input', 'Required' => 1, 'Col' => 3),
            array('Name' =>'Data', 'Desc' => '选择值(数据类型为select、radio、checkbox 时填写, 例 男|女|未知)',  'Type' => 'input', 'Value' => '', 'Required' => 0, 'Col' => 12),
            array('Name' =>'Content', 'Desc' => '默认值',  'Type' => 'textarea', 'Value' => '', 'Required' => 0, 'Col' => 12, 'Row' => 4, 'Class' => 'Content'),
            array('Name' =>'NotNull', 'Desc' => '不能为空',  'Type' => 'radio', 'Data' => $this->IsArr, 'Value' => '1', 'Required' => 0, 'Col' => 12),
        );
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function edit_Action(){
        if(!isset($_GET['Index'])) $this->Err(1001);
        $Arr = empty($this->SysRs['SwiperFieldJson']) ? array() : json_decode($this->SysRs['SwiperFieldJson'], true);
        $Index = intval($_GET['Index']);
        if(!isset($Arr[$Index])) $this->Err(1048);
        $Rs = $Arr[$Index];
        if(!empty($_POST)){
            $Arr[$Index]['Comment'] = trim($_POST['Comment']);
            $Arr[$Index]['Data'] = trim($_POST['Data']);
            $Arr[$Index]['Content'] = trim($_POST['Content']);
            $Arr[$Index]['NotNull'] = trim($_POST['NotNull']);
            $Ret = $this->SysObj->SetCond(array('Name' => 'SwiperFieldJson'))->SetUpdate(array('AttrValue' => json_encode($Arr)))->ExecUpdate();
            if($Ret === false) $this->Err(1002);
            $this->SysObj->cleanList();
            $this->Jump(array('admin', 'swiperField', 'index'), 1888);
        }
        $this->BuildObj->Arr = array(
            array('Name' =>'Comment', 'Desc' => '字段说明',  'Type' => 'input', 'Value' => $Rs['Comment'], 'Required' => 1, 'Col' => 6),
            array('Name' =>'Name', 'Desc' => '字段名 (只能英文和数字)',  'Type' => 'input', 'Value' => $Rs['Name'], 'Disabled' => 1, 'Col' => 3),
            array('Name' =>'Type', 'Desc' => '字段类型',  'Type' => 'select', 'Data' => $this->FieldArr, 'Value' => $Rs['Type'], 'Disabled' => 1, 'Col' => 3),
            array('Name' =>'Data', 'Desc' => '选择值(数据类型为select、radio、checkbox 时填写, 例 男|女|未知)',  'Type' => 'input', 'Value' => $Rs['Data'], 'Required' => 0, 'Col' => 12),
            array('Name' =>'Content', 'Desc' => '默认值',  'Type' => 'textarea', 'Value' => $Rs['Content'], 'Required' => 0, 'Col' => 12, 'Row' => 4, 'Class' => 'Content'),
            array('Name' =>'NotNull', 'Desc' => '不能为空',  'Type' => 'radio', 'Data' => $this->IsArr, 'Value' => $Rs['NotNull'], 'Required' => 0, 'Col' => 12),
        );
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function del_Action(){
        if(!isset($_GET['Index'])) $this->Err(1001);
        
        $Arr = empty($this->SysRs['SwiperFieldJson']) ? array() : json_decode($this->SysRs['SwiperFieldJson'], true);
        $Index = intval($_GET['Index']);
        if(!isset($Arr[$Index])) $this->Err(1048);
        $DbConfig = Config::DbConfig();
        $FieldRs = $Arr[$Index];
        array_splice($Arr, $Index, 1);
        $FieldArr = $this->Sys_modelObj->query('SHOW FULL COLUMNS FROM `'.$DbConfig['Prefix'].'swiper`', array());
        $FieldNameArr = array_column($FieldArr, 'Field');
        try{
            DB::$s_db_obj->beginTransaction();
            $this->SysObj->SetCond(array('Name' => 'SwiperFieldJson'))->SetUpdate(array('AttrValue' => json_encode($Arr)))->ExecUpdate();
            if(in_array($FieldRs['Name'], $FieldNameArr)){
                $this->Sys_modelObj->exec('ALTER TABLE `'.$DbConfig['Prefix'].'swiper` DROP '.$FieldRs['Name'].';', array());
            }
            DB::$s_db_obj->commit();
        }catch(PDOException $e){
            DB::$s_db_obj->rollBack();
            $this->Err(1002);
        }
        $this->SysObj->cleanList();

        $Arr = $this->Swiper_cateObj->ExecSelect();
        foreach($Arr as $v){
            $this->SwiperObj->clean($v['SwiperCateId']);
        }
        $this->Jump(array('admin', 'swiperField', 'index'), 1888);
    }
}