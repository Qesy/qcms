<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Swiper extends ControllersAdmin {
    
    public function index_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('SwiperCateId'))) $this->Err(1001);
        $Page = intval($_GET['Page']);
        if($Page < 1) $Page = 1;
        $Count = 0;
        $Limit = array(($Page-1)*$this->PageNum, $this->PageNum);
        $CondArr = array('SwiperCateId' => $_GET['SwiperCateId']);
        $Arr = $this->SwiperObj->SetCond($CondArr)->SetLimit($Limit)->SetSort(array('Sort' => 'ASC', 'SwiperId' => 'ASC'))->ExecSelectAll($Count);

        foreach($Arr as $k => $v){            
            $Arr[$k]['PicView'] = '<a href="'.$v['Pic'].'" target="_blank"><img src="'.$v['Pic'].'" style="width:40px;heihght:40px;"/></a>';
            $Arr[$k]['TitleView'] = empty($v['Title']) ? '<span class="text-danger">无</span>' : $v['Title'];
            $Arr[$k]['LinkView'] = '<input class="form-control" disabled="disabled" type="text" value="'.$v['Link'].'"/>';
            $Arr[$k]['SortView'] = '<input class="form-control" type="text" value="'.$v['Sort'].'"/>';
        }
        $KeyArr = array(
            'SwiperId' => array('Name' => 'ID', 'Td' => 'th'),
            'Title' => array('Name' => '标题', 'Td' => 'th'),
            'PicView' => array('Name' => '图片', 'Td' => 'th', 'Style' => 'width:200px;'), 
            'LinkView' => array('Name' => '链接地址', 'Td' => 'th', 'Style' => 'width:400px;'),   
            'SortView' => array('Name' => '排序', 'Td' => 'th', 'Style' => 'width:100px;'),            
        );
        $this->BuildObj->PrimaryKey = 'SwiperId';
        $this->BuildObj->TableTopBtnArr = array(
            array('Desc' => '返回', 'Class' => 'default', 'Link' => $this->CommonObj->Url(array('admin', 'swiperCate', 'index'))),
        );
        $this->BuildObj->NameAdd = '添加图片';
        $PageBar = $this->CommonObj->PageBar($Count, $this->PageNum);
        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr, $PageBar, 'table-sm');
        $this->LoadView('admin/common/list', $tmp);
    }
    
    public function add_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('SwiperCateId'))) $this->Err(1001);
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Pic'))) $this->Err(1001);            
            $Ret = $this->SwiperObj->SetInsert(array(
                'Pic' => $_POST['Pic'],
                'Title' => $_POST['Title'],
                'Link' => $_POST['Link'],
                'SwiperCateId' => intval($_GET['SwiperCateId']),
                'Sort' => 99,
            ))->ExecInsert();
            if($Ret === false) $this->Err(1002);
            $this->Jump(array('admin', 'swiper', 'index'), 1888);
        }
        $this->BuildObj->Arr = array(
            array('Name' =>'Pic', 'Desc' => '上传图片',  'Type' => 'upload', 'Value' => '', 'Required' => 1, 'Col' => 12),
            array('Name' =>'Title', 'Desc' => '图片标题',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 6),            
            array('Name' =>'Link', 'Desc' => '链接地址',  'Type' => 'input', 'Value' => '', 'Required' => 1, 'Col' => 6),
        );
        $this->BuildObj->FormFooterBtnArr = array(
            array('Name' => 'back', 'Desc' => '返回', 'Type' => 'button', 'Class' => 'default'),
        );
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function edit_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('SwiperId', 'SwiperCateId'))) $this->Err(1001);
        $Rs = $this->SwiperObj->getOne($_GET['SwiperId']);
        if(empty($Rs)) $this->Err(1003);
        if(!empty($_POST)){
            if(!$this->VeriObj->VeriPara($_POST, array('Pic'))) $this->Err(1001);
            $Ret = $this->SwiperObj->SetCond(array('SwiperId' => $Rs['SwiperId']))->SetUpdate(array(
                'Pic' => $_POST['Pic'],
                'Title' => $_POST['Title'],
                'Link' => $_POST['Link'],
            ))->ExecUpdate();
            if($Ret === false) $this->Err(1002);
            $this->SwiperObj->clean($Rs['SwiperId']);
            $this->Jump(array('admin', 'swiper', 'index'), 1888);
        }
        
        $this->BuildObj->Arr = array(
            array('Name' =>'Pic', 'Desc' => '上传图片',  'Type' => 'upload', 'Value' => $Rs['Pic'], 'Required' => 1, 'Col' => 12),
            array('Name' =>'Title', 'Desc' => '图片标题',  'Type' => 'input', 'Value' => $Rs['Title'], 'Required' => 1, 'Col' => 6),
            array('Name' =>'Link', 'Desc' => '链接地址',  'Type' => 'input', 'Value' => $Rs['Link'], 'Required' => 1, 'Col' => 6),
        );
        $this->BuildObj->FormFooterBtnArr = array(
            array('Name' => 'back', 'Desc' => '返回', 'Type' => 'button', 'Class' => 'default'),
        );
        $this->BuildObj->Form('post', 'form-row');
        $this->LoadView('admin/common/edit');
    }
    
    public function del_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('SwiperId'))) $this->Err(1001);
        $Rs = $this->SwiperObj->getOne($_GET['SwiperId']);
        if(empty($Rs)) $this->Err(1003);
        $Ret = $this->SwiperObj->SetCond(array('SwiperId' => $Rs['SwiperId']))->ExecDelete();
        if($Ret === false) $this->Err(1002);
        $this->SwiperObj->clean($Rs['SwiperId']);
        $this->Jump(array('admin', 'swiper', 'index'), 1888);
    }
    
}