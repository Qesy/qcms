<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Sys extends ControllersAdmin {
    
    public function index_Action(){ //系统设置
        if(!empty($_POST)){
            try {
                DB::$s_db_obj->beginTransaction();
                
                foreach($_POST as $k => $v){
                    $this->SysObj->SetCond(array('Name' => $k))->SetUpdate(array('AttrValue' => $v))->ExecUpdate();
                }
                
                DB::$s_db_obj->commit();
            }catch (PDOException $e){
                DB::$s_db_obj->rollBack();
                $this->Err(1002);
            }
            $this->SysObj->cleanList();
            $this->Jump(array('admin', 'sys', 'index'), 1888);
        }
        $Files = scandir(PATH_TEMPLATE);
        $Folder = array();
        foreach($Files as $v){
            if(in_array($v, array('.', '..'))) continue;
            if(!is_dir(PATH_TEMPLATE.$v)) continue;
            $Folder[$v] = $v;
        }
        $SysArr = $this->SysObj->getList();
        $FormArr = array();
        $TempList = $this->getTemplate('index_');
 
        foreach($SysArr as $v){
            $DataArr = ($v['AttrType'] == 'radio') ? $this->OpenArr : array();
            if($v['Name'] == 'TmpPath') $DataArr = $Folder;
            if($v['Name'] == 'Editor') $DataArr = $this->EditorArr;
            if($v['Name'] == 'TmpIndex') $DataArr = $TempList;
            $FormArr[$v['GroupId']][] = array('Name' => $v['Name'], 'Desc' => $v['Info'],  'Type' => $v['AttrType'], 'Data' => $DataArr, 'Value' => $v['AttrValue'], 'Col' => 12);;
        }
        $this->BuildObj->Arr = array(
            
            array(
                'Title' => '核心设置',
                'Form' => $FormArr[1]                
            ),
            array(
                'Title' => '扩展设置',
                'Form' => $FormArr[2]                        
            ),
            array(
                'Title' => '附件设置',
                'Form' => $FormArr[3]
            )
        );
        $this->PageTitle2 = $this->BuildObj->FormMultipleTitle();
        $this->BuildObj->FormMultiple('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
}