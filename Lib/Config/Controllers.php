<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
/*
 * Name : Collection
 * Date : 20120107
 * Author : Qesy
 * QQ : 762264
 * Mail : 762264@qq.com
 *
 * (̅_̅_̅(̲̅(̅_̅_̅_̅_̅_̅_̅_̅()ڪے
 *
 */
class Controllers extends Base {
    
    public $Tmp = array(
        'Type' => '', //页面类型 index,cate,detail,page
        'Index' => '0', //索引ID
        'Html' => '', //模板代码
        'Compile' => '', //编译后的
        'CateRs' => array(),
        'TableRs' => array(),
        'PageRs' => array(),
        'ModelRs' => array(),
    
    );
    public $ModuleKv = array();
    public $CateKv = array();
    public $TmpPath;
    
    function __construct(){
        parent::__construct();
        $this->SysRs = $this->SysObj->getKv();
        $this->TmpPath = PATH_TEMPLATE.$this->SysRs['TmpPath'].'/';
        $this->CategoryObj->getTreeDetal();
        foreach($this->CategoryObj->CateArr as $v) $this->CateKv[$v['CateId']] = $v;
        $ModuleArr = $this->Sys_modelObj->getList();
        foreach($ModuleArr as $v){
            $this->ModuleKv[$v['KeyName']] = $v;
        }
    }
    
    public function tempRun($Type, $Index = '0'){
        $this->initTmp($Type, $Index)->include_Tmp()->label_Tmp()->global_Tmp()->self_Tmp()->menu_Tmp();
        $this->smenu_Tmp()->ssmenu_Tmp()->list_Tmp()->loop_Tmp();
        echo($this->Tmp['Compile']);
    }
    
    public function tempRunTest($Type, $Index = '0', $Html = ''){
        $this->initTmp($Type, $Index);
        
        $this->Tmp['Compile'] = $this->Tmp['Html'] = $Html;
        //var_dump($this->Tmp['Compile']);exit;
        $this->include_Tmp()->label_Tmp()->global_Tmp()->self_Tmp()->menu_Tmp();
        $this->smenu_Tmp()->ssmenu_Tmp()->list_Tmp()->loop_Tmp();
        echo($this->Tmp['Compile']);
    }

    public function initTmp($Type, $Index = '0'){
        $this->Tmp['Type'] = $Type;
        $this->Tmp['Index'] = $Index;
        switch($Type){
            case 'index':
                $Path = $this->SysRs['TmpIndex'];        
                break;
            case 'cate':                
                $CateRs = $this->CategoryObj->getOne($Index);                
                if(empty($CateRs)) $this->DieErr(1001);
                $this->Tmp['CateRs'] = $CateRs;
                $Path = $CateRs['TempList'];    
                break;
            case 'detail':
                $TableRs = $this->TableObj->SetCond(array('Id' => $this->Tmp['Index']))->ExecSelectOne();
                if(empty($TableRs)) $this->DieErr(1001);
                $ModelRs = $this->Sys_modelObj->getOne($TableRs['ModelId']);
                $TableRs = $this->Sys_modelObj->SetTbName('table_'.$ModelRs['KeyName'])->SetCond(array('Id' => $TableRs['Id']))->ExecSelectOne();
                $CateRs = $this->CategoryObj->getOne($TableRs['CateId']); 
                $Path = $CateRs['TempDetail'];    
                $this->Tmp['ModelRs'] = $ModelRs;
                $this->Tmp['CateRs'] = $CateRs;
                $this->Tmp['TableRs'] = $TableRs;
                break;
            case 'page':
                $PageRs = $this->PageObj->SetCond(array('PageId' => $Index))->ExecSelectOne();
                if(empty($PageRs)) $this->DieErr(1001);
                $this->Tmp['PageRs'] = $PageRs;
                $Path = $PageRs['TempDetail'];    
                break;
        }
        
        if(!file_exists($this->TmpPath.$Path) || !is_file( $this->TmpPath.$Path)) $this->DieErr(1054);
        $this->Tmp['Compile'] = $this->Tmp['Html'] = file_get_contents($this->TmpPath.$Path);
        
        
        return $this;
    }
    
    public function include_Tmp(){ // 包含
        preg_match_all("/{{include([\s\S.]*?)\/?}}/i",$this->Tmp['Compile'], $Matches); 
        $Replace = array();
        foreach($Matches[1] as $k => $v){
            $Data = self::_getKv($v);
            $Replace[] = @file_get_contents($this->TmpPath.$Data['filename']);         
        }
        $this->Tmp['Compile'] = str_replace($Matches[0], $Replace, $this->Tmp['Compile']);
        return $this;
    }
    
    public function global_Tmp(){ // 全局标签
        $Search = array('{{qcms:domain}}', '{{qcms:static}}', '{{qcms:pathImg}}', '{{qcms:pathJs}}', '{{qcms:pathCss}}', '{{qcms:Scheme}}');
        $Replace = array(URL_DOMAIN, URL_STATIC, URL_IMG, URL_JS, URL_CSS, $_SERVER['REQUEST_SCHEME']);
        foreach($this->SysRs as $k => $v){
            $Search[] = '{{qcms:'.$k.'}}';
            $Replace[] = $v;
        }
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }
    
    public function self_Tmp(){ //替换自身需要的
        $Search = array();
        $Replace = array();
        switch($this->Tmp['Type']){
            case 'index':
                $Search = array('{{qcms:crumbs}}');
                $Replace = array('<li class="breadcrumb-item active">首页</li>');
                break;
            case 'cate':
                $Search = array('{{qcms:crumbs}}');
                $this->CategoryObj->getCrumbs($this->Tmp['Index']);
                $CrumbsArr = array('<li class="breadcrumb-item"><a href="/">首页</a></li>');
                foreach($this->CategoryObj->CateCrumbsArr as $k => $v){
                    if($k+1 < count($this->CategoryObj->CateCrumbsArr)){
                        $CrumbsArr[] = '<li class="breadcrumb-item"><a href="'.$this->createUrl('cate', $v['CateId'], $v['PinYin'], $v['PY']).'">'.$v['Name'].'</a></li>';
                    }else{
                        $CrumbsArr[] = '<li class="breadcrumb-item active">'.$v['Name'].'</li>';
                    }                    
                }
                $Replace = array(implode('', $CrumbsArr));
                foreach($this->Tmp['CateRs'] as $k => $v){
                    $Search[] = '{{qcms:Cate_'.$k.'}}';
                    $Replace[] = $v;
                }                
                break;
            case 'detail':                
                $Search = array('{{qcms:crumbs}}');
                $this->CategoryObj->getCrumbs($this->Tmp['CateRs']['CateId']);
                $CrumbsArr = array('<li class="breadcrumb-item"><a href="/">首页</a></li>');
                foreach($this->CategoryObj->CateCrumbsArr as $k => $v){
                    if($k+1 < count($this->CategoryObj->CateCrumbsArr)){
                        $CrumbsArr[] = '<li class="breadcrumb-item"><a href="'.$this->createUrl('cate', $v['CateId'], $v['PinYin'], $v['PY']).'">'.$v['Name'].'</a></li>';
                    }else{
                        $CrumbsArr[] = '<li class="breadcrumb-item active">'.$v['Name'].'</li>';
                    }
                }
                $Replace = array(implode('', $CrumbsArr));
                //$CateRs = $this->CategoryObj->getOne($Rs['CateId']); 
                foreach($this->Tmp['CateRs'] as $k => $v){
                    $Search[] = '{{qcms:Cate_'.$k.'}}';
                    $Replace[] = $v;
                }
                foreach($this->Tmp['TableRs'] as $k => $v){
                    $Search[] = '{{qcms:Detail_'.$k.'}}';
                    $Replace[] = $v;
                }
                $PreRs = $this->Sys_modelObj->SetTbName('table_'.$this->Tmp['ModelRs']['KeyName'])->SetCond(' WHERE Id < '.$this->Tmp['Index'])->SetLimit(' ORDER BY Id DESC LIMIT 0, 1')->ExecSelectOne();
                $NextRs = $this->Sys_modelObj->SetTbName('table_'.$this->Tmp['ModelRs']['KeyName'])->SetCond(' WHERE Id > '.$this->Tmp['Index'])->SetLimit(' ORDER BY Id ASC LIMIT 0, 1')->ExecSelectOne();
                $Search[] = '{{qcms:Detail_Prev}}';
                $Search[] = '{{qcms:Detail_Next}}';
                $Replace[] = empty($PreRs) ? '没有了' : '<a href="'.$this->createUrl('detail', $PreRs['Id'], $PreRs['PinYin'], $PreRs['PY']).'">'.$PreRs['Title'].'</a>';
                $Replace[] = empty($NextRs) ? '没有了' : '<a href="'.$this->createUrl('detail', $NextRs['Id'], $NextRs['PinYin'], $NextRs['PY']).'">'.$NextRs['Title'].'</a>';
                
                break;
            case 'page':
                $Search = array('{{qcms:crumbs}}');
                $CrumbsArr = array('<li class="breadcrumb-item"><a href="/">首页</a></li>');
                $CrumbsArr[] = '<li class="breadcrumb-item active">'.$this->Tmp['PageRs']['Name'].'</li>';
                $Replace = array(implode('', $CrumbsArr));
                foreach($this->Tmp['PageRs'] as $k => $v){
                    $Search[] = '{{qcms:Page_'.$k.'}}';
                    $Replace[] = $v;
                }
                break;
        }
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }
    
    public function label_Tmp(){ // 自定义标签
        preg_match_all("/{{label:([\w]*?)\/?}}/i",$this->Tmp['Compile'], $Matches);  
        if(!empty($Matches[1])){
            $Search = array();
            $Replace = array();
            foreach($Matches[1] as $v){
                $LabelRs = $this->LabelObj->getOne($v);
                if($LabelRs['State'] != 1) continue;
                $Search[] = '{{label:'.$v.'}}';                
                $Replace[] = $LabelRs['Content'];
            }
        }
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }
    
    public function menu_Tmp(){ // 菜单
        preg_match_all("/{{menu([\s\S.]*?)}}([\s\S.]*?){{\/menu}}/i", $this->Tmp['Compile'], $Matches);        
        $Search = array();
        $Replace = array();
        foreach($Matches[1] as $k => $v){
            $Para = self::_getKv($v);
            $PCateId = isset($Para['PCateId']) ? $Para['PCateId'] : '0';
            $Search[] = $Matches[0][$k];
            $Replace[] = self::_replaceCate($PCateId, $Matches[2][$k], 'Menu_');
        }
        
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }
    
    public function smenu_Tmp(){ // 二级菜单
        preg_match_all("/{{smenu([\s\S.]*?)}}([\s\S.]*?){{\/smenu}}/i", $this->Tmp['Compile'], $Matches);
        $Search = array();
        $Replace = array();
        foreach($Matches[1] as $k => $v){
            $Para = self::_getKv($v);
            $PCateId = isset($Para['PCateId']) ? $Para['PCateId'] : '0';
            $Search[] = $Matches[0][$k];
            $Replace[] = self::_replaceCate($PCateId, $Matches[2][$k], 'sMenu_');
        }
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }
    
    public function ssmenu_Tmp(){ // 三级菜单
        preg_match_all("/{{ssmenu([\s\S.]*?)}}([\s\S.]*?){{\/ssmenu}}/i", $this->Tmp['Compile'], $Matches);
        $Search = array();
        $Replace = array();
        foreach($Matches[1] as $k => $v){
            $Para = self::_getKv($v);
            $PCateId = isset($Para['PCateId']) ? $Para['PCateId'] : '0';
            $Search[] = $Matches[0][$k];
            $Replace[] = self::_replaceCate($PCateId, $Matches[2][$k], 'ssMenu_');
        }
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }
    
    public function list_Tmp(){ // 列表
        preg_match_all("/{{list([\s\S.]*?)}}([\s\S.]*?){{\/list}}/i", $this->Tmp['Compile'], $Matches);
        $Search = array();
        $Replace = array();
        foreach($Matches[1] as $k => $v){
            $Para = self::_getKv($v);
            $Ret['Module'] = !isset($Para['Module']) ? 'article' : $Para['Module'];
            $Ret['Row'] = !isset($Para['Row']) ? '10' : $Para['Row'];
            if($Ret['Row'] > 100) $Ret['Row'] = 100;
            $Ret['CateId'] = !isset($Para['CateId']) ? '0' : $Para['CateId'];
            $Ret['Sort'] = !isset($Para['Sort']) ? 'Id' : $Para['Sort'];
            $Ret['SortType'] = !isset($Para['SortType']) ? 'DESC' : $Para['SortType'];
            $Ret['Keyword'] = !isset($Para['Keyword']) ? '' : $Para['Keyword'];
            $Ret['Ids'] = !isset($Para['Ids']) ? '' : $Para['Ids'];
            $Ret['Attr'] = !isset($Para['Attr']) ? '' : $Para['Attr'];
            $Ret['Page'] = !isset($Para['Page']) ? '1' : $Para['Page'];
            $Search[] = $Matches[0][$k];
            $Replace[] = self::_replaceList($Ret, $Matches[2][$k], 'List_');
        }
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        //var_dump($Matches);exit;
        return $this;
    }
    
    public function loop_Tmp(){ // 万能查询
        preg_match_all("/{{loop([\s\S.]*?)}}([\s\S.]*?){{\/loop}}/i", $this->Tmp['Compile'], $Matches);
        $Search = array();
        $Replace = array();
        foreach($Matches[1] as $k => $v){
            $Para = self::_getKv($v);
            if(empty($Para['sql'])) return $this; 
            $Search[] = $Matches[0][$k];
            $Replace[] = self::_replaceLoop($Para['sql'], $Matches[2][$k], 'Loop_');
        }
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }
    
    public function slide_Tmp(){ // 幻灯片
        return $this;
    }
    
    public function createUrl($Type, $Index, $PinYin, $PY, $Ts = 0){
        switch($Type){
            case 'cate':
                $Url = $this->SysObj->getOne('UrlList')['AttrValue'];
                $RetUrl = str_replace(array('{CateId}', '{PinYin}', '{PY}'), array($Index, $PinYin, $PY), $Url);
                break;
            case 'detail':
                $Url = $this->SysObj->getOne('UrlDetail')['AttrValue'];
                $Y = date('Y', $Ts);
                $m = date('m', $Ts);
                $d = date('d', $Ts);
                $RetUrl = str_replace(array('{Id}', '{PinYin}', '{PY}', '{Y}', '{M}', '{D}'), array($Index, $PinYin, $PY, $Y, $m, $d), $Url);
                break;
            case 'page':
                $Url = $this->SysObj->getOne('UrlPage')['AttrValue'];
                $RetUrl = str_replace(array('{PageId}', '{PinYin}', '{PY}'), array($Index, $PinYin, $PY), $Url);
                break;
        }
        return '/'.$Type.'/'.$RetUrl;
    }
    
    private function _replaceLoop($Sql, $Html, $Pre){
        //var_dump($Html);exit;
        $Arr = $this->Sys_modelObj->query($Sql, array());
        $Compile = '';
        if(empty($Arr)) return $Compile;
        $Keys = array_keys($Arr[0]);

        $Search = array();
        foreach($Keys as $v) $Search[] = '{{qcms:'.$Pre.$v.'}}';
        foreach($Arr as $k => $v){
            $Replace = array();
            foreach($Keys as $sv) $Replace[] = $v[$sv];
            $Compile .= str_replace($Search, $Replace, $Html);
        }
        return $Compile;
    }
    
    private function _replaceList($Ret, $Html, $Pre){
        $ModuleRs = $this->ModuleKv[$Ret['Module']];
        $CondArr = array();
        if(!empty($Ret['CateId'])){
            $CateIds = explode(',', $Ret['CateId']);
            $AllSubCateIdArr = array();
            foreach($CateIds as $v){
                $this->CategoryObj->getAllCateId($v, $ModuleRs['ModelId']);
                $AllSubCateIdArr = array_merge($AllSubCateIdArr, $this->CategoryObj->AllSubCateIdArr);
            }
            $CondArr['CateId'] = $AllSubCateIdArr;
        }
        if(!empty($Ret['Keyword'])){
            $TagArr = $this->TagObj->SetCond(array('Name' => explode(',', $Ret['Keyword'])))->ExecSelect();
            $TagIds = array_column($TagArr, 'TagId');
            $TagMap = $this->Tag_mapObj->SetCond(array('TagId' => $TagIds, 'ModelId' => $ModuleRs['ModelId']))->SetLimit(array(0, ($Ret['Row']+1)))->SetSort(array('TagMapId' => 'DESC'))->ExecSelect();
            $CondArr['Id'] = array_column($TagMap, 'TableId');
        }
        if(!empty($Ret['Ids'])){
            $Ids = explode(',', $Ret['Ids']);
            $CondArr['Id'] = !isset($CondArr['Id']) ? $Ids : array_merge($Ids, $CondArr['Id']);
        }
        if(!empty($Ret['Attr'])){
            $Attr = explode(',', $Ret['Attr']);
            if(in_array('hl', $Attr)) $CondArr['IsHeadlines'] = 1; //头条
            if(in_array('sr', $Attr)) $CondArr['IsSpuerRec'] = 1; //特推
            if(in_array('re', $Attr)) $CondArr['IsRec'] = 1; //推荐
            if(in_array('il', $Attr)) $CondArr['IsLink'] = 1; //外链
            if(in_array('ib', $Attr)) $CondArr['IsBold'] = 1; //加粗
            if(in_array('ip', $Attr)) $CondArr['IsPic'] = 1; //带图
        }
        $Limit = array(($Ret['Page']-1)*$Ret['Row'], $Ret['Row']);
        $Count = 0;
        $Sort = array('Sort' => 'ASC', 'Id' => 'DESC');
        if($Ret['Sort'] == 'ReadNum'){
            $Sort = array('ReadNum' => 'DESC', 'Id' => 'DESC');
        }elseif($Ret['Sort'] == 'TsUpdate'){
            $Sort = array('TsUpdate' => 'DESC', 'Id' => 'DESC');
        }elseif($Ret['Sort'] == 'Good'){
            $Sort = array('Good' => 'DESC', 'Id' => 'DESC');
        }
        $FieldArr = empty($ModuleRs['FieldJson']) ? array() : json_decode($ModuleRs['FieldJson'], true);
        $ListField = $this->DefaultField;
        foreach($FieldArr as $v){
            if($v['IsList'] == 1) $ListField[] = $v['Name'];
        }
        $ListField = array_diff($ListField, array('Content', 'Index'));
        $Arr = $this->Sys_modelObj->SetTbName('table_'.$ModuleRs['KeyName'])->SetField(implode(', ', $ListField))->SetCond($CondArr)->SetSort($Sort)->SetLimit($Limit)->SetIsDebug(0)->ExecSelect();
        $Compile = '';
        $Search = array();
        foreach($ListField as $v){
            $Search[] =  '{{qcms:'.$Pre.$v.'}}';
        }
        $Search[] =  '{{qcms:'.$Pre.'i}}';
        $Search[] =  '{{qcms:'.$Pre.'CateName}}';
        $Search[] =  '{{qcms:'.$Pre.'CatePic}}';
        $Search[] =  '{{qcms:'.$Pre.'CateUrl}}';        
        $Search[] =  '{{qcms:'.$Pre.'Url}}';
        foreach($Arr as $k => $v){
            
            $CateRs = $this->CateKv[$v['CateId']];
            $UrlCate = self::createUrl('cate', $CateRs['CateId'], $CateRs['PinYin'], $CateRs['PY']);//$Url,
            $UrlDetail = self::createUrl('detail', $v['Id'], $v['PinYin'], $v['PY']);//$Url,
            $Replace = array();
            foreach($ListField as $sv){
                $Replace[] =  $v[$sv];
            }
            $Replace[] =  $k;
            $Replace[] = $CateRs['Name'];
            $Replace[] = $CateRs['Pic'];
            $Replace[] = ($CateRs['IsLink'] == 1) ? $CateRs['LinkUrl'] : $UrlCate; // 分类地址
            $Replace[] = ($v['IsLink'] == '1') ? $v['LinkUrl'] : $UrlDetail;
            $Compile .= str_replace($Search, $Replace, $Html);
        }        
        return $Compile;
    }
    
    private function _replaceCate($PCateId, $Html, $Pre){
        $Arr = $this->CategoryObj->CateTreeDetail;
        $CateArr = array();
        foreach($Arr as $k => $v){
            if($v['PCateId'] != $PCateId || $v['IsShow'] != 1) continue;
            $CateArr[] = $v;
        }
        $Compile = '';
        $Search = array(
            '{{qcms:'.$Pre.'CateId}}',
            '{{qcms:'.$Pre.'PCateId}}',
            '{{qcms:'.$Pre.'Name}}',
            '{{qcms:'.$Pre.'ModelId}}',
            '{{qcms:'.$Pre.'Pic}}',
            '{{qcms:'.$Pre.'SeoTitle}}',
            '{{qcms:'.$Pre.'Keywords}}',
            '{{qcms:'.$Pre.'Description}}',
            '{{qcms:'.$Pre.'Url}}', 
            '{{qcms:'.$Pre.'HasSub}}',
            '{{qcms:'.$Pre.'i}}',
        );
        foreach($CateArr as $k => $v){
            $Url = ($v['IsLink'] == 1) ? $v['LinkUrl'] : $v['UrlList'];
            $Replace = array(
                $v['CateId'],
                $v['PCateId'],
                $v['Name'],
                $v['ModelId'],
                $v['Pic'],
                $v['SeoTitle'],
                $v['Keywords'],
                $v['Description'],
                self::createUrl('cate', $v['CateId'], $v['PinYin'], $v['PY']),//$Url,
                $v['HasSub'],
                $k,
            );
            $Compile .= str_replace($Search, $Replace, $Html);
        }
        return $Compile;
    }
    
    private function _getKv($Str){
        preg_match_all("/([\w]*?)=\'([\w\W]*?)\'/i",$Str, $Matches); 
        if(empty($Matches[0])) return array();
        $Ret = array();
        for($i=0;$i<count($Matches[0]);$i++){
            $Ret[$Matches[1][$i]] = $Matches[2][$i];
        }
        return $Ret;
    }
    
    
}

class ControllersAdmin extends Controllers {

    public $PageTitle;
    public $PageTitle2;
    public $Module = 'admin';
    public $LoginUserRs = array();
    public $MenuArr = array();
    public $RoleMenuArr = array();
    public $BreadCrumb = array();
    public $FieldArr = array(
        'input' => '单行文本',
        'textarea' => '多行文本',
        'editor' => 'HTML富文本',
        'number' => '整数类型',
        'money' => '金额类型',
        'date' => '日期类型',
        'datetime' => '时间类型',
        'upload' => '上传图片类型',
        'select' => 'Option下拉框',
        'radio' => '单选框',
        'checkbox' => '多选框',
    );
    public $IsArr = array('1' => '是', 2 => '否');
    public $OpenArr = array('1' => '开启', 2 => '关闭');
    public $IsShowArr = array('1' => '显示', 2 => '隐藏');
    public $StateArr = array('1' => '已发布', 2 => '未发布');
    public $SexArr = array('1' => '男', 2 => '女');
    public $EditorArr = array('ckeditor' => 'ckeditor');
    public $SiteArr = array();
    public $HeadHtml = '';
    function __construct(){
        parent::__construct();
        self::_postKey();
        $Token = $this->CookieObj->get('Token', 'User');
        $TokenRs = $this->TokenObj->getOne($Token);
        if(empty($TokenRs)) $this->Jump(array('index', 'adminLogout'), 1007);
        $UserRs = $this->UserObj->getOne($TokenRs['UserId']);
        if(empty($UserRs) || $UserRs['GroupAdminId'] == -1) $this->Jump(array('index', 'adminLogout'), 1007);
        $this->LoginUserRs = $UserRs;
        $this->SysRs = $this->SysObj->getKv();
        $this->BuildObj->UploadUrl = $this->CommonObj->Url(array('admin', 'api', 'ajaxUpload'));
        
        $this->MenuArr = array(
            /***一级***/
            'admin/index' => array('Name' => '系统管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'index'))),
            'admin/category' => array('Name' => '分类管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category'))),
            'admin/content' => array('Name' => '内容管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'index'))),
            'admin/user' => array('Name' => '会员中心', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'user'))),
            'admin/data' => array('Name' => '数据维护', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'data'))),
            'admin/assist' => array('Name' => '辅助插件', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'other'))),
            'admin/templates' => array('Name' => '模板管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'templates'))),
            // 用户首页
            'admin/index/index' => array('Name' => '用户首页', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'index', 'index'))),
            // 系统管理
            'admin/sys/index' => array('Name' => '基本设置', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'sys', 'index'))),
            'admin/sys/license' => array('Name' => '系统授权', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'sys', 'license'))),
            'admin/sys/check' => array('Name' => '环境检测', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'sys', 'check'))),
            'admin/admin/index' => array('Name' => '管理员管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'admin', 'index'))),
            'admin/admin/add' => array('Name' => '添加管理员', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'admin', 'add'))),
            'admin/admin/edit' => array('Name' => '修改管理员', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'admin', 'edit'))),
            'admin/admin/del' => array('Name' => '删除管理员', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'admin', 'del'))),
            'admin/groupAdmin/index' => array('Name' => '管理组管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'groupAdmin', 'index'))),
            'admin/groupAdmin/add' => array('Name' => '添加管理组', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'groupAdmin', 'add'))),
            'admin/groupAdmin/edit' => array('Name' => '修改管理组', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'groupAdmin', 'edit'))),
            'admin/groupAdmin/del' => array('Name' => '删除管理组', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'groupAdmin', 'del'))),
            'admin/log/operate' => array('Name' => '操作日志', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'log', 'operate'))),
            'admin/log/login' => array('Name' => '登录日志', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'log', 'login'))),
            'admin/site/index' => array('Name' => '多站点管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'site', 'index'))),
            'admin/site/add' => array('Name' => '添加站点', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'site', 'add'))),
            'admin/site/edit' => array('Name' => '修改站点', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'site', 'edit'))),
            'admin/site/del' => array('Name' => '删除站点', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'site', 'del'))),
            
            // 分类管理
            'admin/category/index' => array('Name' => '分类管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'index'))),
            'admin/category/add' => array('Name' => '添加分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'add'))),
            'admin/category/edit' => array('Name' => '修改分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'edit'))),
            'admin/category/del' => array('Name' => '删除分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'del'))),
            'admin/category/move' => array('Name' => '移动分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'move'))),
            // 单页管理
            'admin/pageCate/index' => array('Name' => '单页分类管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'pageCate', 'index'))),
            'admin/pageCate/add' => array('Name' => '添加单页分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'pageCate', 'add'))),
            'admin/pageCate/edit' => array('Name' => '修改单页分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'pageCate', 'edit'))),
            'admin/pageCate/del' => array('Name' => '删除单页分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'pageCate', 'del'))),
            'admin/page/index' => array('Name' => '单页管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'page', 'index'))),
            'admin/page/add' => array('Name' => '添加单页', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'page', 'add'))),
            'admin/page/edit' => array('Name' => '修改单页', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'page', 'edit'))),
            'admin/page/del' => array('Name' => '删除单页', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'page', 'del'))),
            // 自定义标签
            'admin/labelCate/index' => array('Name' => '标签分类管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'labelCate', 'index'))),
            'admin/labelCate/add' => array('Name' => '添加标签分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'labelCate', 'add'))),
            'admin/labelCate/edit' => array('Name' => '修改标签分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'labelCate', 'edit'))),
            'admin/labelCate/del' => array('Name' => '删除标签分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'labelCate', 'del'))),
            'admin/label/index' => array('Name' => '标签管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'label', 'index'))),
            'admin/label/add' => array('Name' => '添加标签', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'label', 'add'))),
            'admin/label/edit' => array('Name' => '修改标签', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'label', 'edit'))),
            'admin/label/del' => array('Name' => '删除标签', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'label', 'del'))),
            // 内容管理
            'admin/content/recovery' => array('Name' => '回收站', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', 'recovery'))),
            'admin/content/view' => array('Name' => '查看文章', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', 'view'))),
            'admin/content/restore' => array('Name' => '恢复文章', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', 'restore'))),
            'admin/content/tDelete' => array('Name' => '彻底删除', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', 'tDelete'))),
            
            // 会员管理
            'admin/user/index' => array('Name' => '会员管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'user', 'index'))),
            'admin/user/add' => array('Name' => '添加会员', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'user', 'add'))),
            'admin/user/edit' => array('Name' => '修改会员', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'user', 'edit'))),
            'admin/user/upgrade' => array('Name' => '提升会员', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'user', 'upgrade'))),
            'admin/groupUser/index' => array('Name' => '会员组管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'groupUser', 'index'))),
            'admin/groupUser/add' => array('Name' => '添加会员组', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'groupUser', 'add'))),
            'admin/groupUser/edit' => array('Name' => '修改会员组', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'groupUser', 'edit'))),
            'admin/groupUser/del' => array('Name' => '删除会员组', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'groupUser', 'del'))),
            //辅助插件
            'admin/linkCate/index' => array('Name' => '友情链接分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'linkCate', 'index'))),
            'admin/linkCate/add' => array('Name' => '增加友情链接分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'linkCate', 'add'))),
            'admin/linkCate/edit' => array('Name' => '修改友情链接分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'linkCate', 'edit'))),
            'admin/linkCate/del' => array('Name' => '删除友情链接分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'linkCate', 'del'))),
            'admin/link/index' => array('Name' => '友情链接', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'link', 'index'))),
            'admin/link/add' => array('Name' => '添加友情链接', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'link', 'add'))),
            'admin/link/edit' => array('Name' => '修改友情链接', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'link', 'edit'))),
            'admin/link/del' => array('Name' => '删除友情链接', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'link', 'del'))),
            'admin/inlinkCate/index' => array('Name' => '内联分类管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'inlinkCate', 'index'))),
            'admin/inlinkCate/add' => array('Name' => '添加内联分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'inlinkCate', 'add'))),
            'admin/inlinkCate/edit' => array('Name' => '修改内联分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'inlinkCate', 'edit'))),
            'admin/inlinkCate/del' => array('Name' => '删除内联分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'inlinkCate', 'del'))),
            'admin/inlink/index' => array('Name' => '内联管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'inlink', 'index'))),
            'admin/inlink/add' => array('Name' => '添加内联', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'inlink', 'add'))),
            'admin/inlink/edit' => array('Name' => '修改内联', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'inlink', 'edit'))),
            'admin/inlink/del' => array('Name' => '删除内联', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'inlink', 'del'))),
            
            'admin/swiperCate/index' => array('Name' => '幻灯片', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'swiperCate', 'index'))),
            'admin/swiperCate/add' => array('Name' => '添加幻灯片', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'swiperCate', 'add'))),
            'admin/swiperCate/edit' => array('Name' => '修改幻灯片', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'swiperCate', 'edit'))),
            'admin/swiperCate/del' => array('Name' => '删除幻灯片', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'swiperCate', 'del'))),
            'admin/swiper/index' => array('Name' => '图片管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'swiper', 'index'))),
            'admin/swiper/add' => array('Name' => '添加图片', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'swiper', 'add'))),
            'admin/swiper/edit' => array('Name' => '修改图片', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'swiper', 'edit'))),
            'admin/swiper/del' => array('Name' => '删除图片', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'swiper', 'del'))),
            'admin/tag/index' => array('Name' => 'Tag管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'tag', 'index'))),
            'admin/tag/list' => array('Name' => 'Tag内容管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'tag', 'list'))),
            'admin/file/index' => array('Name' => '附件管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'file', 'index'))),
            
            //数据维护
            'admin/model/index' => array('Name' => '模型管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'model', 'index'))),
            'admin/model/add' => array('Name' => '添加模型', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'model', 'add'))),
            'admin/model/edit' => array('Name' => '修改模型', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'model', 'edit'))),
            'admin/model/del' => array('Name' => '删除模型', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'model', 'del'))),
            
            'admin/modelField/index' => array('Name' => '字段管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'modelField', 'index'))),
            'admin/modelField/add' => array('Name' => '添加字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'modelField', 'add'))),
            'admin/modelField/edit' => array('Name' => '修改字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'modelField', 'edit'))),
            'admin/modelField/del' => array('Name' => '删除字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'modelField', 'del'))),
            
            'admin/form/index' => array('Name' => '自定义表单', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'form', 'index'))),
            'admin/form/add' => array('Name' => '添加自定义表单', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'form', 'add'))),
            'admin/form/edit' => array('Name' => '修改自定义表单', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'form', 'edit'))),
            'admin/form/del' => array('Name' => '删除自定义表单', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'form', 'del'))),
            'admin/form/code' => array('Name' => '获取表单代码', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'form', 'code'))),
            'admin/formField/index' => array('Name' => '字段管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'formField', 'index'))),
            'admin/formField/add' => array('Name' => '添加字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'formField', 'add'))),
            'admin/formField/edit' => array('Name' => '修改字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'formField', 'edit'))),
            'admin/formField/del' => array('Name' => '删除字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'formField', 'del'))),
            
            'admin/formData/index' => array('Name' => '表单数据管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'formData', 'index'))),
            //'admin/formData/add' => array('Name' => '添加字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'formField', 'add'))),
            'admin/formData/edit' => array('Name' => '修改表单数据', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'formData', 'edit'))),
            'admin/formData/del' => array('Name' => '删除表单数据', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'formData', 'del'))),
            
            'admin/database/index' => array('Name' => '数据库管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'database', 'index'))),
            'admin/database/backups' => array('Name' => '数据库备份', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'database', 'backups'))),
            'admin/database/restore' => array('Name' => '数据库恢复', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'database', 'restore'))),
            'admin/database/del' => array('Name' => '数据库删除', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'database', 'del'))),
            
            'admin/redisManage/index' => array('Name' => 'Redis管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'redisManage', 'index'))),
            'admin/redisManage/edit' => array('Name' => 'Redis修改', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'redisManage', 'edit'))),
            'admin/redisManage/del' => array('Name' => 'Redis删除', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'redisManage', 'del'))),
            'admin/redisManage/empty' => array('Name' => 'Redis清空', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'redisManage', 'empty'))),            
            
            'admin/data/replace' => array('Name' => '批量替换', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'data', 'replace'))),
            'admin/data/highReplace' => array('Name' => '高级替换', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'data', 'highReplace'))),
            
            //模板管理
            'admin/templates/index' => array('Name' => '模板管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'templates', 'index'))),
            'admin/templates/add' => array('Name' => '添加模板', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'templates', 'add'))),
            'admin/templates/edit' => array('Name' => '修改模板', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'templates', 'edit'))),
            'admin/templates/del' => array('Name' => '删除模板', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'templates', 'del'))),
            'admin/templates/builder' => array('Name' => '代码生成器', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'templates', 'builder'))),
            'admin/templates/test' => array('Name' => '模板标签测试', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'templates', 'test'))),
            // API
            'admin/api/ajaxUpload' => array('Name' => 'AJAX上传', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'ajaxUpload'))),
            'admin/api/ckUpload' => array('Name' => 'CkEditor上传', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'ckUpload'))),
            'admin/api/userState' => array('Name' => '设置用户状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'userState'))),
            'admin/api/linkState' => array('Name' => '设置链接状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'linkState'))),
            'admin/api/pageState' => array('Name' => '设置单页状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'pageState'))),
            'admin/api/labelState' => array('Name' => '设置标签状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'labelState'))),
            'admin/api/formDataState' => array('Name' => '设置表单回复状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'formDataState'))),
            'admin/api/tableField' => array('Name' => '查询表字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'tableField'))),
            'admin/api/sort' => array('Name' => '排序通用模块', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'sort'))),
            
            'admin/api/contentState' => array('Name' => '文章批量操作', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'contentState'))),
            'admin/api/deleteRec' => array('Name' => '彻底删除', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'deleteRec'))),
            
            'index/adminLogout' => array('Name' => '安全退出', 'Permission' => array('1', '2', '3'), 'Url' => $this->CommonObj->url(array('index', 'adminLogout'))),

        );
        $ModelArr = $this->Sys_modelObj->getList();
        $RoleMenuArr = array();
        foreach($ModelArr as $v) {
            $Para = array('ModelId' => $v['ModelId']);
            foreach(array('index', 'add', 'edit', 'del') as $mv){
                $Key = 'admin/content/'.$mv.'?'.http_build_query($Para);
                if($mv == 'index') $RoleMenuArr[] = array('Key' => $Key);                
                $this->MenuArr[$Key] = array('Name' => $v['Name'].'管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', $mv)), 'Para' => array('ModelId' => $v['ModelId']));
            }            
        }
        //$RoleMenuArr[] = array('Key' => 'admin/content/recovery');
        //var_dump($this->MenuArr);exit;
        $this->RoleMenuArr = array(
            array('Key' => 'admin/index/index', 'subCont' => array('index'), 'Icon' => 'bi bi-house'),
            
            array('Key' => 'admin/category', 'subCont' => array('category', 'page', 'pageCate', 'labelCate', 'label', 'form', 'formField', 'formData'), 'Icon' => 'bi bi-list-ol', 'Sub' => array(
                array('Key' => 'admin/category/index'),
                array('Key' => 'admin/page/index'),
                array('Key' => 'admin/form/index'),
                array('Key' => 'admin/label/index'),
            )),
            array('Key' => 'admin/content', 'subCont' => array('content'), 'Icon' => 'bi bi-layout-text-sidebar-reverse', 'Sub' => $RoleMenuArr),
            array('Key' => 'admin/user', 'subCont' => array('user', 'groupUser'), 'Icon' => 'bi bi-person', 'Sub' => array(
                array('Key' => 'admin/user/index'),
                array('Key' => 'admin/groupUser/index'),
            )),
            array('Key' => 'admin/data', 'subCont' => array('data', 'model', 'modelField', 'database', 'redisManage'), 'Icon' => 'bi bi-tools', 'Sub' => array(
                array('Key' => 'admin/model/index'),
                array('Key' => 'admin/database/index'),
                array('Key' => 'admin/redisManage/index'),
                array('Key' => 'admin/data/replace'),
                array('Key' => 'admin/data/highReplace'),
            )),
            array('Key' => 'admin/assist', 'subCont' => array('linkCate', 'link', 'inlinkCate', 'inlink', 'file', 'swiper', 'swiperCate', 'tag'), 'Icon' => 'bi bi-columns-gap', 'Sub' => array(
                //array('Key' => 'admin/linkCate/index'),
                array('Key' => 'admin/link/index'),
                array('Key' => 'admin/inlink/index'),
                array('Key' => 'admin/swiperCate/index'),
                array('Key' => 'admin/tag/index'),
                array('Key' => 'admin/file/index'),
            )),
            array('Key' => 'admin/templates', 'subCont' => array('templates'), 'Icon' => 'bi bi-code-slash', 'Sub' => array(
                array('Key' => 'admin/templates/index'),
                array('Key' => 'admin/templates/builder'),
                array('Key' => 'admin/templates/test'),
            )),
            array('Key' => 'admin/index', 'subCont' => array('sys', 'admin', 'groupAdmin', 'log', 'site'), 'Icon' => 'bi bi-gear', 'Sub' => array(
                array('Key' => 'admin/sys/index'),
                array('Key' => 'admin/sys/license'),
                array('Key' => 'admin/sys/check'),
                array('Key' => 'admin/site/index'),
                array('Key' => 'admin/admin/index'),
                array('Key' => 'admin/groupAdmin/index'),
                array('Key' => 'admin/log/operate'),
                array('Key' => 'admin/log/login'),
            )),
            array('Key' => 'index/adminLogout', 'subCont' => array('signout'), 'Icon' => 'bi bi-box-arrow-right'),
        );
        $Url = implode('/', array($this->Module, Router::$s_Controller, Router::$s_Method));
        $Key = '';
        foreach($this->MenuArr as $k => $v){
            if(strpos($k, $Url) === 0){
                if(isset($v['Para'])){
                    $GetPara = array();
                    foreach($v['Para'] as $pk => $pv) $GetPara[$pk] = $_GET[$pk];
                    $Key = $Url.'?'.http_build_query($GetPara);
                }else{
                    $Key = $k;
                }
            }
        }
        //var_dump($Key);exit;
        if(!isset($this->MenuArr[$Key])) $this->CommonObj->Err('没有此页面');
        $MenuRs = $this->MenuArr[$Key];        
        if(!in_array($UserRs['GroupAdminId'], $MenuRs['Permission'])) $this->CommonObj->Err('没有权限');
        $this->PageTitle = $MenuRs['Name'];
        $this->PageTitle2 = $this->BuildObj->FormTitle($MenuRs['Name']);

        foreach($this->RoleMenuArr as $v){
            if(in_array(Router::$s_Controller, $v['subCont'])){
                $this->MenuArr[$v['Key']]['IsActive'] = true;
                $this->BreadCrumb[] = $this->MenuArr[$v['Key']];
                if(!empty($v['Sub'])){
                    $this->BreadCrumb[] = $this->MenuArr[$Key];
                }
                break;
            }
        }
        $this->SiteArr = $this->SiteObj->getList();
        
    }
    
    public function getTemplate($Prefix = ''){
        $Files = scandir(PATH_TEMPLATE.$this->SysRs['TmpPath'].'/');
        $Template = array();
        foreach($Files as $v){
            if(in_array($v, array('.', '..'))) continue;
            if(is_dir(PATH_TEMPLATE.$v)) continue;
            if((!empty($Prefix) && strpos($v, $Prefix) !== 0) || substr($v, -5) != '.html') continue;
            $Template[$v] = $v;
        }
        return $Template;
    }
    
    public function getLicense($LicenseStr){
        $pk = self::_pvKey();
        return $this->_sslDecrypt($LicenseStr, $pk, 'public');
    }
    
    public function getKey(){
        $pk = self::_pvKey();
        $Token = $this->CookieObj->get('Token', 'User');
        $Rs = array('Token' => $Token, 'Domain' => URL_DOMAIN);
        $key = $this->_sslEncrypt(json_encode($Rs) , $pk, 'public');
        return $key;
    }
    
    private function _postKey(){
        $key = self::getKey();
        $this->CurlObj->SetUrl('https://www.q-cms.cn/client/updata.html')->SetPara(array('Key' => $key))->SetIsPost(true)->SetIsHttps(true)->SetIsJson(true)->Execute();
    }
    
    private function _pvKey(){
        return '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA0rwpQg7QurxLuMP3knkD
O0dXouHcp6+lwjQuDiRDzNflCQ7L8tSLg5CZiUlyF1LvinyP9addBIF+LC0h/bHr
SWZhlA3bTBeIY4bFIe5bWYA+Aqo8/iHWkJIO+1HkcU1E0AJejBTwvOlNWaWtlkth
vQ4CvboRoLsyQ8YI2tBYF2DOSqEjzH/5pQmo7E1nFrOrovG3uZmULfkgdihY8M0H
SRniif+15/8FV7u7hXCLNmj7zfZl4fHz96HWbzkudnn7ciY/R21JAdBgekya5lgE
R6LXQzX/zL3NwvCd/hiT0XgdYW6rGH3qYL36d44Hziw/2PWC7psfZ3TrUwFzYRmg
oQIDAQAB
-----END PUBLIC KEY-----';
    }
    
    private function _sslEncrypt($Data, $Key, $Type = 'private', $ReturnType = 'base64') { // $Type: private, public
        if($Type == 'private'){
            $Ret = openssl_private_encrypt($Data, $encrypted, $Key);
        }else{
            $Ret = openssl_public_encrypt($Data, $encrypted, $Key);
        }
        return ($ReturnType == 'base64') ? base64_encode($encrypted) : bin2hex($encrypted);
    }
    private function _sslDecrypt($Source, $Key, $Type = 'private', $ReturnType = 'base64') {
        $encrypted = '';
        $SourceNew = ($ReturnType == 'base64') ? base64_decode($Source) : hex2bin($Source);
        if($Type == 'private'){
            $Ret = openssl_private_decrypt($SourceNew, $encrypted, $Key);
        }else{
            $Ret = openssl_public_decrypt($SourceNew, $encrypted, $Key);
        }
        return $encrypted;
    }
    
    function __destruct(){       
        if($this->SysRs['OpenLog'] == 1){
            $this->Log_operateObj->SetInsert(array(
                'UserId' => $this->LoginUserRs['UserId'],
                'Url' => URL_CURRENT,
                'Method' => $_SERVER['REQUEST_METHOD'],
                'Query' => http_build_query($_GET),
                'Ip' => $this->CommonObj->ip(),
                'Ts' => time(),
            ))->ExecInsert();
        }
    }

}
class ControllersUser extends Base {
}
?>