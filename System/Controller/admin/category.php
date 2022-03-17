<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Category extends ControllersAdmin {
    
    public function index_Action(){
        $this->CategoryObj->getTreeDetal();
        $Arr = $this->CategoryObj->CateTreeDetail;
        $Level = 0;
        $TrClass = '';
        foreach($Arr as $k => $v){
            $IsPost = ($v['IsPost'] == 1) ? '<span class="text-danger mr-2">投稿</span>': '<span class="text-secondary mr-2">投稿</span>';
            $IsLink = ($v['IsLink'] == 1) ? '<span class="text-danger mr-2">外链</span>': '<span class="text-secondary mr-2">外链</span>';
            $IsShow = ($v['IsShow'] == 1) ? '<span class="text-danger mr-2">显示</span>': '<span class="text-secondary mr-2">显示</span>';
            $IsHasSub = ($v['HasSub']) ? '<i class="ml-2 bi bi-chevron-down ShowBtn" data-cateid="'.$v['CateId'].'"></i>' : '';
            $NameView = ($v['Level'] == 0) ? $v['Name'] : '<span style="padding-left:'.(30*$v['Level']).'px;"><span class="pr-2">├─</span>'.$v['Name'].'</span>';
            $Arr[$k]['NameView'] = $NameView .$IsHasSub;
            $Arr[$k]['AttrView'] = $IsPost.$IsLink.$IsShow;
            $Model = '文章模型';
            $Arr[$k]['ModelView'] = '<span class="text-secondary">'.$Model.'</span>';
            $Arr[$k]['SortView'] = '<input class="form-control" type="text" value="'.$v['Sort'].'"/>';
            $Arr[$k]['UserLevel'] = '<span class="text-secondary">开放浏览</span>';
            $Arr[$k]['BtnArr'] = array(
                array('Name' => '预览', 'Color' => 'success'),
                array('Name' => '内容', 'Color' => 'success'),
                array('Name' => '加子类'),
                array('Name' => '移动'),                
            );
            if($Level < $v['Level']){
                $Level = $v['Level'];
                $TrClass .= ' ShowDiv_'.$v['PCateId'].' ';
            }else{
                $Level = $v['Level'];
                $TrClass = ' ShowDiv_'.$v['PCateId'].' ';
            }
            //$TrClass .= ' SubShowDiv_'.$v['PCateId'].' ';
            $Arr[$k]['TrClass'] = ($v['Level'] == 0) ? ' SubShowDiv_'.$v['PCateId'].' '.$TrClass : ' SubShowDiv_'.$v['PCateId'].' d-none'.$TrClass;
        }
        $KeyArr = array(
            'NameView' => array('Name' => '分类名', 'Td' => 'th'),
            'ModelView' => array('Name' => '模型', 'Td' => 'th'),
            'AttrView' => array('Name' => '属性', 'Td' => 'th'), 
            'UserLevel' => array('Name' => '浏览权限', 'Td' => 'th'), 
            'SortView' => array('Name' => '排序', 'Td' => 'th', 'Style' => 'width:100px'),
        );
        $this->BuildObj->PrimaryKey = 'CateId';        
        $tmp['Table'] = $this->BuildObj->Table($Arr, $KeyArr, '', 'table-sm');
        $this->LoadView('admin/category/index', $tmp);
    }
    
    public function add_Action(){
        
    }
    
    public function edit_Action(){
        
    }
    
    public function del_Action(){
        
    }
    
    private function _getTreeHtml($Arr, $Tree){
        foreach($Tree as $k => $v){
            //$CateRs = $this->CategoryObj->getOne($k);
            $Arr[] = $this->CategoryObj->getOne($k);
        }
        return $Arr;
    }
    
}