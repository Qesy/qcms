<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Content extends ControllersAdmin {
    
    public function index_Action(){
        $Page = intval($_GET['Page']);
        if($Page < 1) $Page = 1;
        $Count = 0;
        $Limit = array(($Page-1)*$this->PageNum, $this->PageNum);
        $CondArr = array();

        $Arr = $this->TableObj->SetCond($CondArr)->SetLimit($Limit)->SetSort(array('Sort' => 'ASC', 'Id' => 'Desc'))->ExecSelectAll($Count);

        $KeyArr = array(
            'Title' => array('Name' => '标题', 'Td' => 'th'),
            //'Sn_Out' => array('Name' => '第三方订单号', 'Td' => 'th'),
            'NickName' => array('Name' => '昵称', 'Td' => 'th'),
            'AdminGroupView' => array('Name' => '管理组', 'Td' => 'th'),
            'TsLastView' => array('Name' => '登录时间', 'Td' => 'th'),
            'IpLastView' => array('Name' => '登录IP', 'Td' => 'th'),
            
        );
        $this->BuildObj->PrimaryKey = 'UserId';
        //$this->BuildObj->IsDel = $this->BuildObj->IsAdd = $this->BuildObj->IsEdit = false;
        $PageBar = $this->CommonObj->PageBar($Count, $this->PageNum);
        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr, $PageBar);
        $this->LoadView('admin/common/list');
    }
    
    public function add_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('CateId', 'ModelId'))) $this->Err(1001);
        $ModelRs = $this->Sys_modelObj->getOne($_GET['ModelId']);
        if(empty($ModelRs)) $this->Err(1001);
        $Ts = time();
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Title'))) $this->Err(1001);
            try{
                DB::$s_db_obj->beginTransaction();
                $InsetArr = array(
                    'CateId' => intval($_POST['CateId']),
                    'Title' => trim($_POST['Title']),
                    'STitle' => trim($_POST['STitle']),
                    'Pic' => trim($_POST['Pic']),
                    'Source' => trim($_POST['Source']),
                    'Author' => trim($_POST['Author']),
                    'Sort' => intval($_POST['Sort']),
                    'Keywords' => trim($_POST['Keywords']),
                    'Description' => trim($_POST['Description']),
                    'TsAdd' => $Ts,
                    'TsUpdate' => empty($_POST['TsUpdate']) ? $Ts : strtotime($_POST['TsUpdate']),
                    'ReadNum' => intval($_POST['ReadNum']),
                    'Coins' => intval($_POST['Coins']),
                    'Money' => intval($_POST['Money']),
                    'UserLevel' => intval($_POST['UserLevel']),
                    'Good' => intval($_POST['Good']),
                    'Bad' => intval($_POST['Bad']),
                    'Color' => trim($_POST['Color']),
                    'UserId' => $this->LoginUserRs['UserId'],
                    
                );
                $this->TableObj->SetInsert($InsetArr)->ExecInsert();
                $InsertId = $this->TableObj->last_insert_id();
                DB::$s_db_obj->commit();
            }catch (PDOException $e){
                DB::$s_db_obj->rollBack();
            }
        }
        
        $this->CategoryObj->getTreeModelSelectHtml($ModelRs['ModelId']);        
        $CateHtml = '<label for="Input_CateId" class="mb-1">分类</label><select class="form-control" name="CateId" id="Input_CateId" >';
        $CateHtml .= '<option value="" >请选择分类</option>';
        $CateHtml .= $this->CategoryObj->CateTreeModelSelectHtml;
        $CateHtml .= '</select>';
        
        $GroupUserArr = $this->Group_userObj->getList();
        $GroupUserKv = array(0 => '开放浏览');
        foreach(array_column($GroupUserArr, 'Name', 'GroupUserId') as $k => $v) $GroupUserKv[$k] = $v;
        
        $AttrValArr = array('State', 'IsPost');
        $AttrArr = array('State' => '发布', 'IsPost' => '评论', 'IsLink' => '外链', 'IsBold' => '加粗');
        
        $AttrArr2 = array('IsSpuerRec' => '特推', 'IsHeadlines' => '头条', 'IsRec' => '推荐');
        $this->BuildObj->Arr = array(
            array(
                'Title' => '基本信息',
                'Form' => array(
                    array('Name' =>'CateId', 'Desc' => $CateHtml,  'Type' => 'diy', 'Value' => '', 'Required' => 1, 'Col' => 12),
                    array('Name' =>'Title', 'Desc' => '标题',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 6),
                    array('Name' =>'STitle', 'Desc' => '短标题',  'Type' => 'input', 'Value' => '', 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Attr', 'Desc' => '属性',  'Type' => 'checkbox', 'Data' => $AttrArr, 'Value' => implode('|', $AttrValArr), 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Pic', 'Desc' => '图片',  'Type' => 'upload', 'Value' => '', 'Required' => 0, 'Col' => 12),
                    array('Name' =>'Content', 'Desc' => '内容详情',  'Type' => 'editor', 'Value' => '', 'Required' => 0, 'Col' => 12),
                    array('Name' =>'LinkUrl', 'Desc' => '外链地址',  'Type' => 'hidden', 'Value' => '', 'Required' => 0, 'Col' => 12),
                )                
            ),  
            array(
                'Title' => '扩展信息',
                'Form' => array(
                    array('Name' =>'UserLevel', 'Desc' => '浏览权限',  'Type' => 'select', 'Data' => $GroupUserKv, 'Value' => '0', 'Required' => 0, 'Col' => 3),
                    array('Name' =>'TsUpdate', 'Desc' => '发布时间',  'Type' => 'input', 'Value' => date('Y-m-d H:i:s'), 'Required' => 0, 'Col' => 3),
                    array('Name' =>'ReadNum', 'Desc' => '浏览次数',  'Type' => 'input', 'Value' => '0', 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Sort', 'Desc' => '排序',  'Type' => 'input', 'Value' => '99', 'Required' => 0, 'Col' => 3), 
                    
                    array('Name' =>'Source', 'Desc' => '来源',  'Type' => 'input', 'Value' => '', 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Author', 'Desc' => '作者',  'Type' => 'input', 'Value' => '', 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Color', 'Desc' => '颜色',  'Type' => 'color', 'Value' => '', 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Attr2', 'Desc' => '附加属性',  'Type' => 'checkbox', 'Data' => $AttrArr2, 'Value' => '', 'Required' => 0, 'Col' => 3),
                    
                    array('Name' =>'Coins', 'Desc' => '金币费用',  'Type' => 'input', 'Value' => '0', 'Required' => 0, 'Col' => 3), 
                    array('Name' =>'Money', 'Desc' => '金钱费用',  'Type' => 'input', 'Value' => '0', 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Good', 'Desc' => '好评数',  'Type' => 'input', 'Value' => '0', 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Bad', 'Desc' => '差评数',  'Type' => 'input', 'Value' => '0', 'Required' => 0, 'Col' => 3),
                    
                    
                    array('Name' =>'Keywords', 'Desc' => '关键字',  'Type' => 'input', 'Value' => '', 'Required' => 0, 'Col' => 12),
                    array('Name' =>'Description', 'Desc' => '分类描述',  'Type' => 'textarea', 'Value' => '', 'Required' => 0, 'Col' => 12),
                    
                )
            ),
            
        );
        
        $this->PageTitle2 = $this->BuildObj->FormMultipleTitle();
        $this->BuildObj->FormMultiple('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function edit_Action(){
        
    }
    
    public function del_Action(){
        
    }
    
}