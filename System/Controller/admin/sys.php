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
        $UrlListDesc = '<span class="text-dark">
            <span class="mr-3 font-weight-bold">{CateId}</span>分类ID<br>
            <span class="mr-3 font-weight-bold">{PinYin}</span>拼音+分类ID<br>
            <span class="mr-3 font-weight-bold">{PY}</span>拼音部首+分类ID<br>
        </span>
        ';
        $UrlDetailDesc = '<span class="text-dark">
        	<span class="mr-3 font-weight-bold">{Y}、{M}、{D}</span>年月日<br>
            <span class="mr-3 font-weight-bold">{Id}</span>文章ID<br>
            <span class="mr-3 font-weight-bold">{PinYin}</span>拼音+文章ID<br>
            <span class="mr-3 font-weight-bold">{PY}</span>拼音部首+文章ID<br>
        </span>
        ';
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
        $this->BuildObj->Arr[1]['Form'][] = array('Desc' => '规则说明',  'Type' => 'html', 'Value' => $UrlListDesc, 'Required' => 1, 'Col' => 6);
        $this->BuildObj->Arr[1]['Form'][] = array('Desc' => '规则说明',  'Type' => 'html', 'Value' => $UrlDetailDesc, 'Required' => 1, 'Col' => 6);
        $this->PageTitle2 = $this->BuildObj->FormMultipleTitle();
        $this->BuildObj->FormMultiple('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
}