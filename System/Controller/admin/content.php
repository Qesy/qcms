<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Content extends ControllersAdmin {
    
    public function index_Action(){
        $Page = intval($_GET['Page']);
        if($Page < 1) $Page = 1;
        $Count = 0;
        $Limit = array(($Page-1)*$this->PageNum, $this->PageNum);
        $CondArr = array('IsDelete' => 2);

        $Arr = $this->TableObj->SetCond($CondArr)->SetLimit($Limit)->SetSort(array('Sort' => 'ASC', 'Id' => 'Desc'))->ExecSelectAll($Count);
        $CateArr = $this->CategoryObj->SetCond(array('CateId' => array_column($Arr, 'CateId')))->SetField('CateId, Name')->ExecSelect();
        $CateKV = array_column($CateArr, 'Name', 'CateId');
        
        $UserArr = $this->UserObj->SetCond(array('UserId' => array_column($Arr, 'UserId')))->ExecSelect();
        $UserKv = array_column($UserArr, 'NickName', 'UserId');

        $GroupUserArr = $this->Group_userObj->getList();
        $GroupUserKv = array(0 => '开放浏览');
        foreach(array_column($GroupUserArr, 'Name', 'GroupUserId') as $k => $v) $GroupUserKv[$k] = $v;

        foreach($Arr as $k => $v){
            $Attr = array();
            if($v['IsLink'] == 1) $Attr[] = '外链';
            if($v['IsSpuerRec'] == 1) $Attr[] = '特推';
            if($v['IsHeadlines'] == 1) $Attr[] = '头条';
            if($v['IsRec'] == 1) $Attr[] = '推荐';
            if($v['IsPic'] == 1) $Attr[] = '图片';
            $AttrStr = empty($Attr) ? '' : '<span class="px-2 text-danger" style="font-size:.6rem;">[ '.implode(' ', $Attr).' ]</span>';
            $Arr[$k]['TsUpdateView'] = date('Y-m-d H:i', $v['TsUpdate']);
            $Arr[$k]['CateName'] = $CateKV[$v['CateId']];
            $Arr[$k]['UserLevelView'] = $GroupUserKv[$v['UserLevel']];
            $Arr[$k]['NickName'] = $UserKv[$v['UserId']];
            $Arr[$k]['StateView'] = $this->StateArr[$v['State']];
            $Arr[$k]['TitleView'] = '<span class="'.($v['IsBold'] == 2 ? '' : 'font-weight-bold').'">'.$v['Title'].'</span>'.$AttrStr;
            $Arr[$k]['BtnArr'] = array(
                array('Desc' => '预览', 'Color' => 'success'),                
            );
        }
        $KeyArr = array(
            'Id' => array('Name' => 'ID', 'Td' => 'th'),    
            'TitleView' => array('Name' => '标题', 'Td' => 'th'),            
            'CateName' => array('Name' => '分类名', 'Td' => 'th'),
            'ReadNum' => array('Name' => '浏览数', 'Td' => 'th'),
            'UserLevelView' => array('Name' => '权限', 'Td' => 'th'),
            'StateView' => array('Name' => '状态', 'Td' => 'th'),
            'TsUpdateView' => array('Name' => '更新时间', 'Td' => 'th'),
            'NickName' => array('Name' => '发布人', 'Td' => 'th'),
        );
        $this->BuildObj->PrimaryKey = 'Id';
        //$this->BuildObj->IsDel = $this->BuildObj->IsAdd = $this->BuildObj->IsEdit = false;
        $PageBar = $this->CommonObj->PageBar($Count, $this->PageNum);
        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr, $PageBar, 'table-sm');
        $this->LoadView('admin/common/list', $tmp);
    }
    
    public function add_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('ModelId'))) $this->Err(1001);
        $ModelRs = $this->Sys_modelObj->getOne($_GET['ModelId']);
        if(empty($ModelRs)) $this->Err(1001);
        $Ts = time();
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Title', 'CateId'))) $this->Err(1001);
            try{
                DB::$s_db_obj->beginTransaction();
                $State = isset($_POST['Attr']['State']) ? 1 : 2;
                $IsPost = isset($_POST['Attr']['IsPost']) ? 1 : 2;
                $IsLink = isset($_POST['Attr']['IsLink']) ? 1 : 2;
                $IsBold = isset($_POST['Attr']['IsBold']) ? 1 : 2;
                $IsPic = !empty($_POST['Pic']) ? 1 : 2;
                $IsSpuerRec = isset($_POST['Attr2']['IsSpuerRec']) ? 1 : 2;
                $IsHeadlines = isset($_POST['Attr2']['IsHeadlines']) ? 1 : 2;
                $IsRec = isset($_POST['Attr2']['IsRec']) ? 1 : 2;

                $InsetArr = array(
                    'ModelId' => $ModelRs['ModelId'],
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
                    'State' => $State,
                    'IsPost' => $IsPost,
                    'IsLink' => $IsLink,
                    'IsBold' => $IsBold,
                    'IsPic' => $IsPic,
                    'IsSpuerRec' => $IsSpuerRec,
                    'IsHeadlines' => $IsHeadlines,
                    'IsRec' => $IsRec,
                );
                $this->TableObj->SetInsert($InsetArr)->ExecInsert();
                $InsertId = $this->TableObj->last_insert_id();
                $Insert2Arr = array('Id' => $InsertId, 'Content' => trim($_POST['Content']));
                $this->Table_articleObj->SetTbName('table_'.$ModelRs['NameKey']) ->SetInsert($Insert2Arr)->ExecInsert();
                
                DB::$s_db_obj->commit();
            }catch (PDOException $e){
                DB::$s_db_obj->rollBack();
                $this->Err(1002);
            }
            $this->Jump(array('admin', 'content', 'index'));
        }
        
        $this->CategoryObj->getTreeModelSelectHtml($ModelRs['ModelId']);        
        $CateHtml = '<label for="Input_CateId" class="mb-1">分类<span class="text-danger ml-2" style="font-weight: 900;">*</span></label><select class="form-control" name="CateId" id="Input_CateId" required="required">';
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
                    array('Name' =>'Description', 'Desc' => '描述',  'Type' => 'textarea', 'Value' => '', 'Required' => 0, 'Col' => 12),
                    
                )
            ),
            
        );
        
        $this->PageTitle2 = $this->BuildObj->FormMultipleTitle();
        $this->BuildObj->FormMultiple('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function edit_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id'))) $this->Err(1001);               
        $Rs = $this->TableObj->SetCond(array('Id' => $_GET['Id']))->ExecSelectOne();
        if(empty($Rs)) $this->Err(1003);
        $_GET['ModelId'] = $Rs['ModelId'];
        $ModelRs = $this->Sys_modelObj->getOne($_GET['ModelId']);
        $Ts = time();
        
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Title', 'CateId'))) $this->Err(1001);
            try{
                DB::$s_db_obj->beginTransaction();
                $State = isset($_POST['Attr']['State']) ? 1 : 2;
                $IsPost = isset($_POST['Attr']['IsPost']) ? 1 : 2;
                $IsLink = isset($_POST['Attr']['IsLink']) ? 1 : 2;
                $IsBold = isset($_POST['Attr']['IsBold']) ? 1 : 2;
                $IsPic = !empty($_POST['Pic']) ? 1 : 2;
                $IsSpuerRec = isset($_POST['Attr2']['IsSpuerRec']) ? 1 : 2;
                $IsHeadlines = isset($_POST['Attr2']['IsHeadlines']) ? 1 : 2;
                $IsRec = isset($_POST['Attr2']['IsRec']) ? 1 : 2;
                
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
                    //'TsAdd' => $Ts,
                    'TsUpdate' => empty($_POST['TsUpdate']) ? $Ts : strtotime($_POST['TsUpdate']),
                    'ReadNum' => intval($_POST['ReadNum']),
                    'Coins' => intval($_POST['Coins']),
                    'Money' => intval($_POST['Money']),
                    'UserLevel' => intval($_POST['UserLevel']),
                    'Good' => intval($_POST['Good']),
                    'Bad' => intval($_POST['Bad']),
                    'Color' => trim($_POST['Color']),
                    'UserId' => $this->LoginUserRs['UserId'],
                    'State' => $State,
                    'IsPost' => $IsPost,
                    'IsLink' => $IsLink,
                    'IsBold' => $IsBold,
                    'IsPic' => $IsPic,
                    'IsSpuerRec' => $IsSpuerRec,
                    'IsHeadlines' => $IsHeadlines,
                    'IsRec' => $IsRec,
                );
                $this->TableObj->SetCond(array('Id' => $Rs['Id']))->SetUpdate($InsetArr)->ExecUpdate();
                $Insert2Arr = array('Content' => trim($_POST['Content']));
                $this->Table_articleObj->SetTbName('table_'.$ModelRs['NameKey']) ->SetCond(array('Id' => $Rs['Id']))->SetUpdate($Insert2Arr)->ExecUpdate();                
                DB::$s_db_obj->commit();
            }catch (PDOException $e){
                DB::$s_db_obj->rollBack();
                $this->Err(1002);
            }
            $this->Jump(array('admin', 'content', 'index'));
        }
        
        
        $ContentRs = $this->Table_articleObj->SetTbName('table_'.$ModelRs['NameKey'])->SetCond(array('Id' => $Rs['Id']))->ExecSelectOne();
        
        $this->CategoryObj->CateSelectId = $Rs['CateId'];
        $this->CategoryObj->getTreeModelSelectHtml($ModelRs['ModelId']);
        $CateHtml = '<label for="Input_CateId" class="mb-1">分类<span class="text-danger ml-2" style="font-weight: 900;">*</span></label><select class="form-control" name="CateId" id="Input_CateId" required="required">';
        $CateHtml .= '<option value="" >请选择分类</option>';
        $CateHtml .= $this->CategoryObj->CateTreeModelSelectHtml;
        $CateHtml .= '</select>';
        
        $GroupUserArr = $this->Group_userObj->getList();
        $GroupUserKv = array(0 => '开放浏览');
        foreach(array_column($GroupUserArr, 'Name', 'GroupUserId') as $k => $v) $GroupUserKv[$k] = $v;
        
        $AttrValArr = array();
        if($Rs['State'] == 1) $AttrValArr[] = 'State';
        if($Rs['IsPost'] == 1) $AttrValArr[] = 'IsPost';
        if($Rs['IsLink'] == 1) $AttrValArr[] = 'IsLink';
        if($Rs['IsBold'] == 1) $AttrValArr[] = 'IsBold';
        $AttrArr = array('State' => '发布', 'IsPost' => '评论', 'IsLink' => '外链', 'IsBold' => '加粗');
        $AttrValArr2 = array();
        if($Rs['IsSpuerRec'] == 1) $AttrValArr2[] = 'IsSpuerRec';
        if($Rs['IsHeadlines'] == 1) $AttrValArr2[] = 'IsHeadlines';
        if($Rs['IsRec'] == 1) $AttrValArr2[] = 'IsRec';
        $AttrArr2 = array('IsSpuerRec' => '特推', 'IsHeadlines' => '头条', 'IsRec' => '推荐');
        $this->BuildObj->Arr = array(
            array(
                'Title' => '基本信息',
                'Form' => array(
                    array('Name' =>'CateId', 'Desc' => $CateHtml,  'Type' => 'diy', 'Value' => $Rs['CateId'], 'Required' => 1, 'Col' => 12),
                    array('Name' =>'Title', 'Desc' => '标题',  'Type' => 'input', 'Value' => $Rs['Title'], 'Required' => 1, 'Col' => 6),
                    array('Name' =>'STitle', 'Desc' => '短标题',  'Type' => 'input', 'Value' => $Rs['STitle'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Attr', 'Desc' => '属性',  'Type' => 'checkbox', 'Data' => $AttrArr, 'Value' => implode('|', $AttrValArr), 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Pic', 'Desc' => '图片',  'Type' => 'upload', 'Value' => $Rs['Pic'], 'Required' => 0, 'Col' => 12),
                    array('Name' =>'Content', 'Desc' => '内容详情',  'Type' => 'editor', 'Value' => $ContentRs['Content'], 'Required' => 0, 'Col' => 12),
                    array('Name' =>'LinkUrl', 'Desc' => '外链地址',  'Type' => 'hidden', 'Value' => $Rs['LinkUrl'], 'Required' => 0, 'Col' => 12),
                )
            ),
            array(
                'Title' => '扩展信息',
                'Form' => array(
                    array('Name' =>'UserLevel', 'Desc' => '浏览权限',  'Type' => 'select', 'Data' => $GroupUserKv, 'Value' => $Rs['UserLevel'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'TsUpdate', 'Desc' => '发布时间',  'Type' => 'input', 'Value' => date('Y-m-d H:i:s', $Rs['TsUpdate']), 'Required' => 0, 'Col' => 3),
                    array('Name' =>'ReadNum', 'Desc' => '浏览次数',  'Type' => 'input', 'Value' => $Rs['ReadNum'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Sort', 'Desc' => '排序',  'Type' => 'input', 'Value' => $Rs['Sort'], 'Required' => 0, 'Col' => 3),
                    
                    array('Name' =>'Source', 'Desc' => '来源',  'Type' => 'input', 'Value' => $Rs['Source'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Author', 'Desc' => '作者',  'Type' => 'input', 'Value' => $Rs['Author'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Color', 'Desc' => '颜色',  'Type' => 'color', 'Value' => $Rs['Color'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Attr2', 'Desc' => '附加属性',  'Type' => 'checkbox', 'Data' => $AttrArr2, 'Value' => implode('|', $AttrValArr2), 'Required' => 0, 'Col' => 3),
                    
                    array('Name' =>'Coins', 'Desc' => '金币费用',  'Type' => 'input', 'Value' => $Rs['Coins'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Money', 'Desc' => '金钱费用',  'Type' => 'input', 'Value' => $Rs['Money'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Good', 'Desc' => '好评数',  'Type' => 'input', 'Value' => $Rs['Good'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Bad', 'Desc' => '差评数',  'Type' => 'input', 'Value' => $Rs['Bad'], 'Required' => 0, 'Col' => 3),
                    
                    
                    array('Name' =>'Keywords', 'Desc' => '关键字',  'Type' => 'input', 'Value' => $Rs['Keywords'], 'Required' => 0, 'Col' => 12),
                    array('Name' =>'Description', 'Desc' => '描述',  'Type' => 'textarea', 'Value' => $Rs['Description'], 'Required' => 0, 'Col' => 12),
                    
                )
            ),
            
        );
        
        $this->PageTitle2 = $this->BuildObj->FormMultipleTitle();
        $this->BuildObj->FormMultiple('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function del_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('ModelId', 'Id'))) $this->Err(1001);
        $ModelRs = $this->Sys_modelObj->getOne($_GET['ModelId']);
        if(empty($ModelRs)) $this->Err(1001);
        $Ts = time();
        $Rs = $this->TableObj->SetCond(array('Id' => $_GET['Id']))->ExecSelectOne();
        if(empty($Rs)) $this->Err(1003);
        $Ret = $this->TableObj->SetCond(array('Id' => $Rs['Id']))->SetUpdate(array('IsDelete' => 1))->ExecUpdate();
        if($Ret === false) $this->Err(1002);
        $this->Jump(array('admin', 'content', 'index'));
    }
    
    public function recovery_Action(){
        
        $Page = intval($_GET['Page']);
        if($Page < 1) $Page = 1;
        $Count = 0;
        $Limit = array(($Page-1)*$this->PageNum, $this->PageNum);
        $CondArr = array('IsDelete' => 1);
        
        $Arr = $this->TableObj->SetCond($CondArr)->SetLimit($Limit)->SetSort(array('Sort' => 'ASC', 'Id' => 'Desc'))->ExecSelectAll($Count);
        $CateArr = $this->CategoryObj->SetCond(array('CateId' => array_column($Arr, 'CateId')))->SetField('CateId, Name')->ExecSelect();
        $CateKV = array_column($CateArr, 'Name', 'CateId');
        
        $UserArr = $this->UserObj->SetCond(array('UserId' => array_column($Arr, 'UserId')))->ExecSelect();
        $UserKv = array_column($UserArr, 'NickName', 'UserId');
        
        $GroupUserArr = $this->Group_userObj->getList();
        $GroupUserKv = array(0 => '开放浏览');
        foreach(array_column($GroupUserArr, 'Name', 'GroupUserId') as $k => $v) $GroupUserKv[$k] = $v;
        
        foreach($Arr as $k => $v){
            $Attr = array();
            if($v['IsLink'] == 1) $Attr[] = '外链';
            if($v['IsSpuerRec'] == 1) $Attr[] = '特推';
            if($v['IsHeadlines'] == 1) $Attr[] = '头条';
            if($v['IsRec'] == 1) $Attr[] = '推荐';
            if($v['IsPic'] == 1) $Attr[] = '图片';
            $AttrStr = empty($Attr) ? '' : '<span class="px-2 text-danger" style="font-size:.6rem;">[ '.implode(' ', $Attr).' ]</span>';
            $Arr[$k]['TsUpdateView'] = date('Y-m-d H:i', $v['TsUpdate']);
            $Arr[$k]['CateName'] = $CateKV[$v['CateId']];
            $Arr[$k]['UserLevelView'] = $GroupUserKv[$v['UserLevel']];
            $Arr[$k]['NickName'] = $UserKv[$v['UserId']];
            $Arr[$k]['StateView'] = $this->StateArr[$v['State']];
            $Arr[$k]['TitleView'] = '<span class="'.($v['IsBold'] == 2 ? '' : 'font-weight-bold').'">'.$v['Title'].'</span>'.$AttrStr;
            $Arr[$k]['BtnArr'] = array(
                array('Desc' => '查看', 'Color' => 'success', 'Link' => $this->CommonObj->Url(array('admin', 'content', 'view')) ),
                array('Desc' => '还原', 'Color' => 'primary', 'Link' => $this->CommonObj->Url(array('admin', 'content', 'restore')) ),
                //array('Name' => '彻底删除', 'Color' => 'danger', 'Link' => $this->CommonObj->Url(array('admin', 'content', 'view')) ),
            );
        }
        $KeyArr = array(
            'TitleView' => array('Name' => '标题', 'Td' => 'th'),
            'CateName' => array('Name' => '分类名', 'Td' => 'th'),
            'ReadNum' => array('Name' => '浏览数', 'Td' => 'th'),
            'UserLevelView' => array('Name' => '权限', 'Td' => 'th'),
            'StateView' => array('Name' => '状态', 'Td' => 'th'),
            'TsUpdateView' => array('Name' => '更新时间', 'Td' => 'th'),
            'NickName' => array('Name' => '发布人', 'Td' => 'th'),
        );
        $this->BuildObj->PrimaryKey = 'Id';
        $this->BuildObj->NameDel = '彻底删除';
        $this->BuildObj->LinkDel = $this->CommonObj->Url(array('admin', 'content', 'tDelete'));
        $this->BuildObj->IsAdd = $this->BuildObj->IsEdit = false;
        $PageBar = $this->CommonObj->PageBar($Count, $this->PageNum);
        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr, $PageBar, 'table-sm');
        $this->LoadView('admin/common/list', $tmp);
    }
    
    public function view_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id'))) $this->Err(1001);
        $Rs = $this->TableObj->SetCond(array('Id' => $_GET['Id']))->ExecSelectOne();
        if(empty($Rs)) $this->Err(1003);
        $_GET['ModelId'] = $Rs['ModelId'];
        $ModelRs = $this->Sys_modelObj->getOne($_GET['ModelId']);
        $Ts = time();
        
        $ContentRs = $this->Table_articleObj->SetTbName('table_'.$ModelRs['NameKey'])->SetCond(array('Id' => $Rs['Id']))->ExecSelectOne();
        
        $this->CategoryObj->CateSelectId = $Rs['CateId'];
        $this->CategoryObj->getTreeModelSelectHtml($ModelRs['ModelId']);
        $CateHtml = '<label for="Input_CateId" class="mb-1">分类<span class="text-danger ml-2" style="font-weight: 900;">*</span></label><select class="form-control" name="CateId" id="Input_CateId" required="required">';
        $CateHtml .= '<option value="" >请选择分类</option>';
        $CateHtml .= $this->CategoryObj->CateTreeModelSelectHtml;
        $CateHtml .= '</select>';
        
        $GroupUserArr = $this->Group_userObj->getList();
        $GroupUserKv = array(0 => '开放浏览');
        foreach(array_column($GroupUserArr, 'Name', 'GroupUserId') as $k => $v) $GroupUserKv[$k] = $v;
        
        $AttrValArr = array();
        if($Rs['State'] == 1) $AttrValArr[] = 'State';
        if($Rs['IsPost'] == 1) $AttrValArr[] = 'IsPost';
        if($Rs['IsLink'] == 1) $AttrValArr[] = 'IsLink';
        if($Rs['IsBold'] == 1) $AttrValArr[] = 'IsBold';
        $AttrArr = array('State' => '发布', 'IsPost' => '评论', 'IsLink' => '外链', 'IsBold' => '加粗');
        $AttrValArr2 = array();
        if($Rs['IsSpuerRec'] == 1) $AttrValArr2[] = 'IsSpuerRec';
        if($Rs['IsHeadlines'] == 1) $AttrValArr2[] = 'IsHeadlines';
        if($Rs['IsRec'] == 1) $AttrValArr2[] = 'IsRec';
        $AttrArr2 = array('IsSpuerRec' => '特推', 'IsHeadlines' => '头条', 'IsRec' => '推荐');
        $this->BuildObj->Arr = array(
            array(
                'Title' => '基本信息',
                'Form' => array(
                    array('Name' =>'CateId', 'Desc' => $CateHtml,  'Type' => 'diy', 'Value' => $Rs['CateId'], 'Required' => 1, 'Col' => 12),
                    array('Name' =>'Title', 'Desc' => '标题',  'Type' => 'input', 'Value' => $Rs['Title'], 'Required' => 1, 'Col' => 6),
                    array('Name' =>'STitle', 'Desc' => '短标题',  'Type' => 'input', 'Value' => $Rs['STitle'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Attr', 'Desc' => '属性',  'Type' => 'checkbox', 'Data' => $AttrArr, 'Value' => implode('|', $AttrValArr), 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Pic', 'Desc' => '图片',  'Type' => 'upload', 'Value' => $Rs['Pic'], 'Required' => 0, 'Col' => 12),
                    array('Name' =>'Content', 'Desc' => '内容详情',  'Type' => 'editor', 'Value' => $ContentRs['Content'], 'Required' => 0, 'Col' => 12),
                    array('Name' =>'LinkUrl', 'Desc' => '外链地址',  'Type' => 'hidden', 'Value' => $Rs['LinkUrl'], 'Required' => 0, 'Col' => 12),
                )
            ),
            array(
                'Title' => '扩展信息',
                'Form' => array(
                    array('Name' =>'UserLevel', 'Desc' => '浏览权限',  'Type' => 'select', 'Data' => $GroupUserKv, 'Value' => $Rs['UserLevel'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'TsUpdate', 'Desc' => '发布时间',  'Type' => 'input', 'Value' => date('Y-m-d H:i:s', $Rs['TsUpdate']), 'Required' => 0, 'Col' => 3),
                    array('Name' =>'ReadNum', 'Desc' => '浏览次数',  'Type' => 'input', 'Value' => $Rs['ReadNum'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Sort', 'Desc' => '排序',  'Type' => 'input', 'Value' => $Rs['Sort'], 'Required' => 0, 'Col' => 3),
                    
                    array('Name' =>'Source', 'Desc' => '来源',  'Type' => 'input', 'Value' => $Rs['Source'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Author', 'Desc' => '作者',  'Type' => 'input', 'Value' => $Rs['Author'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Color', 'Desc' => '颜色',  'Type' => 'color', 'Value' => $Rs['Color'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Attr2', 'Desc' => '附加属性',  'Type' => 'checkbox', 'Data' => $AttrArr2, 'Value' => implode('|', $AttrValArr2), 'Required' => 0, 'Col' => 3),
                    
                    array('Name' =>'Coins', 'Desc' => '金币费用',  'Type' => 'input', 'Value' => $Rs['Coins'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Money', 'Desc' => '金钱费用',  'Type' => 'input', 'Value' => $Rs['Money'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Good', 'Desc' => '好评数',  'Type' => 'input', 'Value' => $Rs['Good'], 'Required' => 0, 'Col' => 3),
                    array('Name' =>'Bad', 'Desc' => '差评数',  'Type' => 'input', 'Value' => $Rs['Bad'], 'Required' => 0, 'Col' => 3),
                    
                    
                    array('Name' =>'Keywords', 'Desc' => '关键字',  'Type' => 'input', 'Value' => $Rs['Keywords'], 'Required' => 0, 'Col' => 12),
                    array('Name' =>'Description', 'Desc' => '分类描述',  'Type' => 'textarea', 'Value' => $Rs['Description'], 'Required' => 0, 'Col' => 12),
                    
                )
            ),
            
        );
        
        $this->PageTitle2 = $this->BuildObj->FormMultipleTitle();
        $this->BuildObj->IsSubmit = false;
        $this->BuildObj->IsBack = true;
        $this->BuildObj->FormMultiple('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function restore_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id'))) $this->Err(1001);

        $Rs = $this->TableObj->SetCond(array('Id' => $_GET['Id']))->ExecSelectOne();
        if(empty($Rs)) $this->Err(1003);
        $_GET['ModelId'] = $Rs['ModelId'];
        $Ret = $this->TableObj->SetCond(array('Id' => $Rs['Id']))->SetUpdate(array('IsDelete' => 2))->ExecUpdate();
        if($Ret === false) $this->Err(1002);
        $this->Jump(array('admin', 'content', 'recovery'));
    }
    
    public function tDelete_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id'))) $this->Err(1001);        
        $Rs = $this->TableObj->SetCond(array('Id' => $_GET['Id']))->ExecSelectOne();
        if(empty($Rs)) $this->Err(1003);
        $_GET['ModelId'] = $Rs['ModelId'];
        $Ret = $this->TableObj->SetCond(array('Id' => $Rs['Id']))->ExecDelete();
        if($Ret === false) $this->Err(1002);
        $this->Jump(array('admin', 'content', 'recovery'));
    }
}