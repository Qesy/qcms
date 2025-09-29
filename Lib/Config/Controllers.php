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
        'FormRs' => array(),

    );

    public $ModelKv = array();
    public $CateKv = array();
    public $TmpPath; //模板路径
    public $TmpName; //模板名称 （为了调用静态文件路径）
    public $PageTmp = 1;
    public $CountTmp = 0; //分页用
    public $CateFieldArr = array();
    public $SwiperFieldArr = array();

    protected $p_RemoteKey = 'qcms$GHK346';
    function __construct(){
        parent::__construct();
        $this->SysRs = $this->SysObj->getKv();
        $this->CateFieldArr = empty($this->SysRs['CategoryFieldJson']) ? array() : json_decode($this->SysRs['CategoryFieldJson'], true);
        $this->SwiperFieldArr = empty($this->SysRs['SwiperFieldJson']) ? array() : json_decode($this->SysRs['SwiperFieldJson'], true);
        if($this->CommonObj->isMobile() && !empty($this->SysRs['TmpPathMobile'])){
            $TmpName = $this->SysRs['TmpPathMobile'];
        }else{
            $TmpName = $this->SysRs['TmpPath'];
        }
        $this->TmpName = $TmpName;
        $this->TmpPath = PATH_TEMPLATE.$TmpName.'/';
        $this->CategoryObj->getTreeDetal();
        foreach($this->CategoryObj->CateTreeDetail as $v) $this->CateKv[$v['CateId']] = $v;
        $ModelArr = $this->Sys_modelObj->getList();
        foreach($ModelArr as $v){
            $this->ModelKv[$v['KeyName']] = $v;
        }
        $this->PageTmp = (intval($_GET['Page']) < 1) ? 1 : intval($_GET['Page']);

    }

    public function tempRun($Type, $Index = '0', $Page = 1){
        $this->PageTmp = $Page;
        $this->initTmp($Type, $Index)->include_Tmp()->label_Tmp()->global_Tmp()->self_Tmp()->get_Tmp()->photo_Tmp()->menu_Tmp();
        $this->smenu_Tmp()->ssmenu_Tmp()->list_Tmp()->link_Tmp()->tag_Tmp()->loop_Tmp()->slide_Tmp()->if_Tmp()->date_Tmp();
        $this->substr_Tmp()->math_Tmp()->replace_Tmp()->thumb_Tmp();
        return $this->Tmp['Compile'];
    }

    public function tempRunTest($Type, $Index = '0', $Html = ''){
        Router::$s_Method = $Type;
        $this->initTmp($Type, $Index);
        $this->Tmp['Compile'] = $this->Tmp['Html'] = $Html;
        $this->include_Tmp()->label_Tmp()->global_Tmp()->self_Tmp()->get_Tmp()->photo_Tmp()->menu_Tmp();
        $this->smenu_Tmp()->ssmenu_Tmp()->list_Tmp()->link_Tmp()->tag_Tmp()->loop_Tmp()->slide_Tmp()->if_Tmp()->date_Tmp();
        $this->substr_Tmp()->math_Tmp()->replace_Tmp()->thumb_Tmp();
        return $this->Tmp['Compile'];
    }

    public function initTmp($Type, $Index = '0'){
        $this->Tmp['Type'] = $Type;
        $this->Tmp['Index'] = $Index;
        switch($Type){
            case 'index':
                $Path = $this->SysRs['TmpIndex'];
                break;
            case 'search':
                $Path = $this->SysRs['TmpSearch'];
                break;
            case 'form':
                $Rs = $this->Sys_formObj->getOne(trim($Index));
                if(empty($Rs)) $this->DieErr(1001);
                $this->Tmp['FormRs'] = $Rs;
                $Path = $Rs['TempDetail'];
                break;
            case 'cate':
                $CateRs = $this->CategoryObj->getOne($Index);
                $CateRsT = $this->CateKv[$Index];
                $CateRs['HasSub'] = $CateRsT['HasSub'];
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
                $CateRsT = $this->CateKv[$TableRs['CateId']];
                $CateRs['HasSub'] = $CateRsT['HasSub'];
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
            $Replace[] = @file_get_contents($this->TmpPath.trim($Data['filename']));
        }
        $this->Tmp['Compile'] = str_replace($Matches[0], $Replace, $this->Tmp['Compile']);
        return $this;
    }

    public function date_Tmp(){
        preg_match_all("/{{date([\s\S.]*?)\/?}}/i",$this->Tmp['Compile'], $Matches);
        $Replace = array();
        foreach($Matches[1] as $k => $v){
            $Para = self::_getKv($v);

            $Replace[] = ($Para['format'] == 'special') ? $this->CommonObj->TimeView($Para['time']) : date($Para['format'], $Para['time']);
        }
        $this->Tmp['Compile'] = str_replace($Matches[0], $Replace, $this->Tmp['Compile']);
        return $this;
    }

    public function substr_Tmp(){ //截取字符串
        preg_match_all("/{{cut([\s\S.]*?)\/?}}/i",$this->Tmp['Compile'], $Matches);
        $Replace = array();
        foreach($Matches[1] as $k => $v){
            $Para = self::_getKv($v);
            $Len = isset($Para['Len']) ? intval($Para['Len']) : 0;
            $Replace[] = ($Len > 0) ? mb_substr(strip_tags($Para['Str']), 0, $Len) : $Para['Str'];
        }
        $this->Tmp['Compile'] = str_replace($Matches[0], $Replace, $this->Tmp['Compile']);
        return $this;
    }

    public function thumb_Tmp(){ //缩略图
        preg_match_all("/{{thumb([\w\W]*?)\/?}}/i",$this->Tmp['Compile'], $Matches);
        if(!empty($Matches[1])){
            $Search = array();
            $Replace = array();
            $SysThumbArr = explode('|', $this->SysRs['ThumbSize']);
            foreach($Matches[1] as $v){
                $Para = self::_getKv($v);
                $Width = intval($Para['Width']);
                $Height = intval($Para['Height']);
                $Img = trim($Para['Img']);
                if(!in_array($Width.'x'.$Height, $SysThumbArr) || strpos($Img, 'Static/upload/') === false){
                    $Replace[] = $Img;
                }else{
                    $ext = substr ( strrchr ( $Img, '.' ), 1 );
                    $NewPath = substr($Img, 0, -(strlen($ext)+1)).'_'.$Width.'_'.$Height.'.'.$ext;
                    $Replace[] = str_replace('Static/upload/', 'Static/upload/thumb/', $NewPath);
                }
            }
        }
        $this->Tmp['Compile'] = str_replace($Matches[0], $Replace, $this->Tmp['Compile']);
        return $this;
    }

    public function replace_Tmp(){
        preg_match_all("/{{replace([\s\S.]*?)\/?}}/i", $this->Tmp['Compile'], $Matches);
        $Replace = array();
        foreach($Matches[1] as $k => $v){
            $Para = self::_getKv($v);
            $SubStr = $Para['Str'];
            $SubSearch = explode('|', $Para['Search']) ;
            $SubReplace = explode('|', $Para['Replace']) ;
            $Replace[] = str_replace($SubSearch, $SubReplace, $SubStr);
        }
        $this->Tmp['Compile'] = str_replace($Matches[0], $Replace, $this->Tmp['Compile']);
        return $this;
    }

    public function math_Tmp(){ //数学标签
        preg_match_all("/{{math([\s\S.]*?)\/?}}/i", $this->Tmp['Compile'], $Matches);
        $Search = array();
        $Replace = array();
        $Result = 0;
        foreach($Matches[1] as $k => $v){
            if(strpos($v, '+') !== false){
                $Arr = self::_getKv2If($v, '\+');
                $Result = intval($Arr[0]) + intval($Arr[1]);
            }elseif(strpos($v, '-') !== false){
                $Arr = self::_getKv2If($v, '-');
                $Result = intval($Arr[0]) - intval($Arr[1]);
            }elseif(strpos($v, '*') !== false){
                $Arr = self::_getKv2If($v, '\*');
                $Result = intval($Arr[0]) * intval($Arr[1]);
            }elseif(strpos($v, '/') !== false){
                $Arr = self::_getKv2If($v, '\/');
                $Result = intval($Arr[0]) / intval($Arr[1]);
            }elseif(strpos($v, '%') !== false){
                $Arr = self::_getKv2If($v, '%');
                $Result = intval($Arr[0]) % intval($Arr[1]);
            }else{ // 匹配不到直接返回
                return $this;
            }
            $Search[] = $Matches[0][$k];
            $Replace[] = $Result;
        }
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }

    public function global_Tmp(){ // 全局标签
        $Search = array('{{qcms:Domain}}', '{{qcms:Static}}', '{{qcms:PathImg}}', '{{qcms:PathJs}}', '{{qcms:PathCss}}', '{{qcms:Scheme}}', '{{qcms:PathTemplate}}', '{{qcms:Method}}');
        $Replace = array(URL_DOMAIN, URL_STATIC, URL_IMG, URL_JS, URL_CSS, $_SERVER['REQUEST_SCHEME'], URL_STATIC.'templates/'.$this->TmpName.'/', Router::$s_Method);
        foreach($this->SysRs as $k => $v){
            $Search[] = '{{qcms:'.$k.'}}';
            $Replace[] = $v;
        }

        $Search[] = '{{qcms:Search}}';
        $Replace[] = !empty($_GET['Search']) ? trim($_GET['Search']) : '';


        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }

    public function self_Tmp(){ //替换自身需要的
        $Search = array();
        $Replace = array();
        switch($this->Tmp['Type']){
            case 'index':
                $Search = array('{{qcms:Crumbs}}', '{{qcms:Cate_TCateId}}');
                $Replace = array('<nav aria-label="breadcrumb"><ol class="breadcrumb">
                    <li class="breadcrumb-item active">首页</li>
                </ol></nav>', '0');
                break;
            case 'cate':
                $Search = array('{{qcms:Crumbs}}');
                $this->CategoryObj->getCrumbs($this->Tmp['Index']);
                $CrumbsArr = array('<li class="breadcrumb-item"><a href="/">首页</a></li>');
                foreach($this->CategoryObj->CateCrumbsArr as $k => $v){
                    if($k+1 < count($this->CategoryObj->CateCrumbsArr)){
                        if( $v['IsLink'] == 1) continue;
                        $CrumbsArr[] = '<li class="breadcrumb-item"><a href="'.$this->createUrl('cate', $v['CateId'], $v['PinYin'], $v['PY']).'">'.$v['Name'].'</a></li>';
                    }else{
                        $CrumbsArr[] = '<li class="breadcrumb-item active">'.$v['Name'].'</li>';
                    }
                }
                $Replace = array('<nav aria-label="breadcrumb"><ol class="breadcrumb">'.implode('', $CrumbsArr).'</ol></nav>');
                if(empty($this->Tmp['CateRs']['TCateId'])) $this->Tmp['CateRs']['TCateId'] = $this->Tmp['CateRs']['CateId'];
                foreach($this->Tmp['CateRs'] as $k => $v){
                    $Search[] = '{{qcms:Cate_'.$k.'}}';
                    $Replace[] = $v;
                }
                $TopCateRs = $this->CategoryObj->getOne($this->Tmp['CateRs']['TCateId']);
                $TopCateRsT = $this->CateKv[$this->Tmp['CateRs']['TCateId']];
                $TopCateRs['HasSub'] = $TopCateRsT['HasSub'];
                $TopCateRs['TCateId'] = $TopCateRs['CateId'];
                foreach($TopCateRs as $k => $v){
                    $Search[] = '{{qcms:TopCate_'.$k.'}}';
                    $Replace[] = $v;
                }
                //当前分类地址
                $Search[] = '{{qcms:Cate_Url}}';
                $Replace[] = $this->createUrl('cate', $this->Tmp['CateRs']['CateId'], $this->Tmp['CateRs']['PinYin'], $this->Tmp['CateRs']['PY']);
                //顶级分类地址
                $Search[] = '{{qcms:TopCate_Url}}';
                $Replace[] = $this->createUrl('cate', $TopCateRs['CateId'], $TopCateRs['PinYin'], $TopCateRs['PY']);
                break;
            case 'form':
                $Search = array('{{qcms:FormName}}', '{{qcms:Cate_TCateId}}');
                $Replace = array($this->Tmp['FormRs']['Name'], -1);
                break;
            case 'search':
                $Search = array('{{qcms:Crumbs}}', '{{qcms:Cate_TCateId}}');
                $Replace = array('<nav aria-label="breadcrumb"><ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">首页</a></li>
                    <li class="breadcrumb-item active">搜索页</li>
                </ol></nav>', -1);
                break;
            case 'detail':
                $Search = array('{{qcms:Crumbs}}');
                $this->CategoryObj->getCrumbs($this->Tmp['CateRs']['CateId']);
                $CrumbsArr = array('<li class="breadcrumb-item"><a href="/">首页</a></li>');
                foreach($this->CategoryObj->CateCrumbsArr as $k => $v){
                    if($k+1 < count($this->CategoryObj->CateCrumbsArr)){
                        if( $v['IsLink'] == 1) continue;
                        $CrumbsArr[] = '<li class="breadcrumb-item"><a href="'.$this->createUrl('cate', $v['CateId'], $v['PinYin'], $v['PY']).'">'.$v['Name'].'</a></li>';
                    }else{
                        $CrumbsArr[] = '<li class="breadcrumb-item active">'.$v['Name'].'</li>';
                    }
                }
                $Replace = array('<nav aria-label="breadcrumb"><ol class="breadcrumb">'.implode('', $CrumbsArr).'</ol></nav>');
                //$CateRs = $this->CategoryObj->getOne($Rs['CateId']);
                if(empty($this->Tmp['CateRs']['TCateId'])) $this->Tmp['CateRs']['TCateId'] = $this->Tmp['CateRs']['CateId'];
                foreach($this->Tmp['CateRs'] as $k => $v){
                    $Search[] = '{{qcms:Cate_'.$k.'}}';
                    $Replace[] = $v;
                }
                $TopCateRs = $this->CategoryObj->getOne($this->Tmp['CateRs']['TCateId']);
                $TopCateRsT = $this->CateKv[$this->Tmp['CateRs']['TCateId']];
                $TopCateRs['HasSub'] = $TopCateRsT['HasSub'];
                $TopCateRs['TCateId'] = $TopCateRs['CateId'];
                foreach($TopCateRs as $k => $v){
                    $Search[] = '{{qcms:TopCate_'.$k.'}}';
                    $Replace[] = $v;
                }

                foreach($this->Tmp['TableRs'] as $k => $v){
                    $Search[] = '{{qcms:Detail_'.$k.'}}';
                    if($k == 'Content' && $this->SysRs['IsOpenInLink'] == 1){
                        $InlinkArr = $this->InlinkObj->getList();
                        $InSearch = $InReplace = array();
                        foreach($InlinkArr as $iKey => $iVal){
                            if($iVal['State'] != 1) continue;
                            $InSearch[] = $iVal['Name'];
                            $InReplace[] = '<a class="Inlink" href="'.$iVal['Url'].'" '.(($iVal['IsBlank'] == 1) ? 'target="_blank"' : '').'>'.$iVal['Name'].'</a>';
                        }
                        $Replace[] = str_replace($InSearch, $InReplace, $v);
                    }elseif($k == 'Tag'){
                        $TagArr = explode(',', $v);
                        $TagStrArr = array();
                        foreach($TagArr as $tv){
                            if(empty($tv)) continue;
                            $TagStrArr[] = '<a class="btn btn-default btn-sm mr-2" href="'.$this->CommonObj->Url(array('index', 'search')).'?Search='.$tv.'">'.$tv.'</a>';
                        }
                        $Replace[] =  implode('', $TagStrArr);
                    }else{
                        $Replace[] = $v;
                    }
                }
                $PreRs = $this->Sys_modelObj->SetTbName('table_'.$this->Tmp['ModelRs']['KeyName'])->SetCond(' WHERE Id < '.$this->Tmp['Index'])->SetLimit(' ORDER BY Id DESC LIMIT 0, 1')->ExecSelectOne();
                $NextRs = $this->Sys_modelObj->SetTbName('table_'.$this->Tmp['ModelRs']['KeyName'])->SetCond(' WHERE Id > '.$this->Tmp['Index'])->SetLimit(' ORDER BY Id ASC LIMIT 0, 1')->ExecSelectOne();
                $Search[] = '{{qcms:Detail_TimeAdd}}';
                $Search[] = '{{qcms:Detail_TimeUpdate}}';
                $Search[] = '{{qcms:Detail_Prev}}';
                $Search[] = '{{qcms:Detail_Next}}';
                $Search[] = '{{qcms:Detail_DownAddress}}';
                $Search[] = '{{qcms:Detail_Url}}';
                $Search[] = '{{qcms:Cate_Url}}';
                $Search[] = '{{qcms:TopCate_Url}}';


                //$Search[] = '{{qcms:Cate_HasSub}}';
                $Replace[] = date('Y-m-d H:i:s', $this->Tmp['TableRs']['TsAdd']);
                $Replace[] = date('Y-m-d H:i:s', $this->Tmp['TableRs']['TsUpdate']);
                $Replace[] = empty($PreRs) ? '没有了' : '<a href="'.$this->createUrl('detail', $PreRs['Id'], $PreRs['PinYin'], $PreRs['PY']).'">'.$PreRs['Title'].'</a>';
                $Replace[] = empty($NextRs) ? '没有了' : '<a href="'.$this->createUrl('detail', $NextRs['Id'], $NextRs['PinYin'], $NextRs['PY']).'">'.$NextRs['Title'].'</a>';
                $Replace[] = $this->CommonObj->Url(array('index', 'down', $this->Tmp['Index']));
                $Replace[] = self::createUrl('detail', $this->Tmp['TableRs']['Id'], $this->Tmp['TableRs']['PinYin'], $this->Tmp['TableRs']['PY']);//$Url,
                $Replace[] = self::createUrl('cate', $this->Tmp['CateRs']['CateId'], $this->Tmp['CateRs']['PinYin'], $this->Tmp['CateRs']['PY']);//$Url,
                $Replace[] = $this->createUrl('cate', $TopCateRs['CateId'], $TopCateRs['PinYin'], $TopCateRs['PY']);
                break;
            case 'page':
                $Search = array('{{qcms:Crumbs}}', '{{qcms:Cate_TCateId}}');
                $CrumbsArr = array('<li class="breadcrumb-item"><a href="/">首页</a></li>');
                $CrumbsArr[] = '<li class="breadcrumb-item active">'.$this->Tmp['PageRs']['Name'].'</li>';
                $Replace = array('<nav aria-label="breadcrumb"><ol class="breadcrumb">'.implode('', $CrumbsArr).'</ol></nav>', -1);
                foreach($this->Tmp['PageRs'] as $k => $v){
                    $Search[] = '{{qcms:Page_'.$k.'}}';
                    $Replace[] = $v;
                }
                break;
        }
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }

    public function get_Tmp(){ //获取单条数据详情
        preg_match_all("/{{get([\s\S.]*?)}}([\s\S.]*?){{\/get}}/i", $this->Tmp['Compile'], $Matches);
        $Search = array();
        $Replace = array();
        $CateIds = $PageIds = $DetailIds = $SwiperIds = array();
        foreach($Matches[1] as $k => $v){ //一次性把数据全提取出来
            $Para = self::_getKv($v);
            $Type = isset($Para['Type']) ? trim($Para['Type']) : 'cate';
            $Index = isset($Para['Index']) ? intval($Para['Index']) : 0;
            if($Index == 0) continue;
            switch($Type){
                case 'cate':
                    $CateIds[] = $Index;
                    break;
                case 'page':
                    $PageIds[] = $Index;
                    break;
                case 'detail':
                    $DetailIds[] = $Index;
                    break;
                case 'swiper':
                    $SwiperIds[] = $Index;
                    break;
            }
            $CateArr = $PageArr = $DetailArr = array();
            if(!empty($CateIds)){
                $CateArr = $this->CategoryObj->SetCond(array('CateId' => $CateIds))->SetIndex('CateId')->ExecSelect();
            }
            if(!empty($PageIds)){
                $PageArr = $this->PageObj->SetCond(array('PageId' => $PageIds))->SetIndex('PageId')->ExecSelect();
            }
            if(!empty($SwiperIds)){
                $SwiperArr = $this->SwiperObj->SetCond(array('SwiperId' => $SwiperIds))->SetIndex('SwiperId')->ExecSelect();
            }
            if(!empty($DetailIds)){
                $ModleArr = $this->Sys_modelObj->getList();
                $TablesArr = $this->TableObj->SetCond(array('Id' => $DetailIds))->ExecSelect();
                $TableKV = array();
                foreach($TablesArr as $v){
                    if(!isset($TableKV[$v['ModelId']])){
                        $TableKV[$v['ModelId']] = array($v['Id']);
                    }else{
                        $TableKV[$v['ModelId']][] = $v['Id'];
                    }
                }
                foreach($TableKV as $ModleId => $Ids){
                    $DataArr = $this->Sys_modelObj->SetTbName('table_'.$ModleArr[$ModleId]['KeyName'])->SetCond(array('Id' => $Ids))->ExecSelect();
                    foreach($DataArr as $v){
                        $DetailArr[$v['Id']] = $v;
                    }
                }
            }
        }
        foreach($Matches[1] as $k => $v){
            $Para = self::_getKv($v);
            $Type = isset($Para['Type']) ? $Para['Type'] : 'cate';
            $Index = isset($Para['Index']) ? $Para['Index'] : 0;
            $Search[] = $Matches[0][$k];
            switch($Type){
                case 'cate':
                    if(!isset($CateArr[$Index])){
                        $Replace[] = '';
                    }else{
                        $Replace[] = self::_replaceOne($Type, $CateArr[$Index], $Matches[2][$k], 'Get_');
                    }
                    break;
                case 'detail':

                    if(!isset($DetailArr[$Index])){
                        $Replace[] = '';
                    }else{
                        $Replace[] = self::_replaceOne($Type, $DetailArr[$Index], $Matches[2][$k], 'Get_');
                    }
                    break;
                case 'page':
                    if(!isset($PageArr[$Index])){
                        $Replace[] = '';
                    }else{
                        $Replace[] = self::_replaceOne($Type, $PageArr[$Index], $Matches[2][$k], 'Get_');
                    }
                    break;
                case 'swiper':
                    if(!isset($SwiperArr[$Index])){
                        $Replace[] = '';
                    }else{
                        $Replace[] = self::_replaceOne($Type, $SwiperArr[$Index], $Matches[2][$k], 'Get_');
                    }
                    break;
                default:
                    $Replace[] = '';
                    break;
            }
        }

        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }

    public function label_Tmp(){ // 自定义标签
        preg_match_all("/{{label:([\w\W]*?)\/?}}/i",$this->Tmp['Compile'], $Matches);
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

    public function if_Tmp(){ //IF标签
        preg_match_all("/{{if([\s\S.]*?)}}([\s\S.]*?){{\/if}}/i", $this->Tmp['Compile'], $Matches);
        $Search = array();
        $Replace = array();
        $ok = false;
        foreach($Matches[1] as $k => $v){
            if(strpos($v, '>=') !== false){
                $Arr = self::_getKv2If($v, '>=');
                $ok = ($Arr[0] >= $Arr[1]) ? true : false;
            }elseif(strpos($v, '<=') !== false){
                $Arr = self::_getKv2If($v, '<=');
                $ok = ($Arr[0] <= $Arr[1]) ? true : false;
            }elseif(strpos($v, '==') !== false){
                $Arr = self::_getKv2If($v, '==');
                $ok = ($Arr[0] == $Arr[1]) ? true : false;
            }elseif(strpos($v, '>') !== false){
                $Arr = self::_getKv2If($v, '>');
                $ok = ($Arr[0] > $Arr[1]) ? true : false;
            }elseif(strpos($v, '<') !== false){
                $Arr = self::_getKv2If($v, '<');
                $ok = ($Arr[0] < $Arr[1]) ? true : false;
            }elseif(strpos($v, '!=') !== false){
                $Arr = self::_getKv2If($v, '!=');
                $ok = ($Arr[0] != $Arr[1]) ? true : false;
            }else{ // 匹配不到直接返回
                return $this;
            }
            $ContArr = explode('{{else}}', $Matches[2][$k]);
            if(count($ContArr) == 1) $ContArr[1] = '';
            $Search[] = $Matches[0][$k];
            $Replace[] = ($ok) ? $ContArr[0] : $ContArr[1];
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
            $PCateId = isset($Para['PCateId']) ? intval($Para['PCateId']) : '0';
            $Row = isset($Para['Row']) ? intval($Para['Row']) : '0';
            $Start = !isset($Para['Start']) ? 0 : intval($Para['Start']);
            $Search[] = $Matches[0][$k];
            $Replace[] = self::_replaceCate($PCateId, $Start, $Row, $Matches[2][$k], 'Menu_');
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
            $PCateId = isset($Para['PCateId']) ? intval($Para['PCateId']) : '0';
            $Row = isset($Para['Row']) ? intval($Para['Row']) : '0';
            $Start = !isset($Para['Start']) ? 0 : intval($Para['Start']);
            $Search[] = $Matches[0][$k];
            $Replace[] = self::_replaceCate($PCateId, $Start, $Row, $Matches[2][$k], 'sMenu_');
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
            $PCateId = isset($Para['PCateId']) ? intval($Para['PCateId']) : '0';
            $Row = isset($Para['Row']) ? intval($Para['Row']) : '0';
            $Start = !isset($Para['Start']) ? 0 : intval($Para['Start']);
            $Search[] = $Matches[0][$k];
            $Replace[] = self::_replaceCate($PCateId, $Start, $Row, $Matches[2][$k], 'ssMenu_');
        }
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }

    public function tag_Tmp(){ // 菜单
        preg_match_all("/{{tag([\s\S.]*?)}}([\s\S.]*?){{\/tag}}/i", $this->Tmp['Compile'], $Matches);
        $Search = array();
        $Replace = array();
        foreach($Matches[1] as $k => $v){
            $Para = self::_getKv($v);
            $Row = isset($Para['Row']) ? intval($Para['Row']) : '0';
            $Search[] = $Matches[0][$k];
            $Replace[] = self::_replaceTag($Row, $Matches[2][$k], 'Tag_');
        }
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }

    public function photo_Tmp(){ //相册
        if($this->Tmp['Type'] != 'detail' || $this->Tmp['ModelRs']['KeyName'] != 'album') return $this;
        preg_match_all("/{{photo([\s\S.]*?)}}([\s\S.]*?){{\/photo}}/i", $this->Tmp['Compile'], $Matches);
        $Search = array();
        $Replace = array();
        foreach($Matches[1] as $k => $v){
            $Para = self::_getKv($v);
            $Index = isset($Para['Index']) ? intval($Para['Index']) : $this->Tmp['Index'];
            $Row = isset($Para['Row']) ? intval($Para['Row']) : 0;
            $Search[] = $Matches[0][$k];
            $Replace[] = self::_replacePhoto($Index, $Row, $Matches[2][$k], 'Photo_');
        }
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }

    public function link_Tmp(){
        preg_match_all("/{{link([\s\S.]*?)}}([\s\S.]*?){{\/link}}/i", $this->Tmp['Compile'], $Matches);
        $Search = array();
        $Replace = array();
        foreach($Matches[1] as $k => $v){
            $Para = self::_getKv($v);
            if(!empty($Para['LinkCateId'])) $Ret['LinkCateId'] = intval($Para['LinkCateId']);
            if(!empty($Para['IsIndex'])) $Ret['IsIndex'] = intval($Para['IsIndex']);
            $Ret['Row'] = !isset($Para['Row']) ? '100' : intval($Para['Row']);
            $Search[] = $Matches[0][$k];
            $Replace[] = self::_replaceLink($Ret, $Matches[2][$k], 'Link_');
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
            $Ret['Model'] = empty($Para['Model']) ? 'article' : $Para['Model'];
            $Ret['Row'] = !isset($Para['Row']) ? '10' : intval($Para['Row']);
            if($Ret['Row'] > 100) $Ret['Row'] = 100;
            $Ret['CateId'] = !isset($Para['CateId']) ? '0' : intval($Para['CateId']);
            $Ret['Sort'] = !isset($Para['Sort']) ? 'Id' : $Para['Sort'];
            $Ret['SortType'] = !isset($Para['SortType']) ? 'DESC' : $Para['SortType'];
            $Ret['Keyword'] = !isset($Para['Keyword']) ? '' : $Para['Keyword'];
            $Ret['Search'] = !isset($Para['Search']) ? '' : $Para['Search'];
            $Ret['Ids'] = !isset($Para['Ids']) ? '' : $Para['Ids'];
            $Ret['Start'] = !isset($Para['Start']) ? 0 : intval($Para['Start']);
            $Ret['Attr'] = !isset($Para['Attr']) ? '' : $Para['Attr'];
            $Ret['IsPage'] = !isset($Para['IsPage']) ? '-1' : intval($Para['IsPage']); //是否开启分页
            $Search[] = $Matches[0][$k];
            $Replace[] = self::_replaceList($Ret, $Matches[2][$k], 'List_');
            if($this->Tmp['Type'] == 'cate' && $Ret['IsPage'] == 1){
                $Search[] = '{{qcms:List_PageBar}}';
                $UrlArr = array('Default' => $this->SysRs['UrlList'], 'Page' => $this->SysRs['UrlListPage']);
                $Replace[] = $this->CommonObj->PageBarTemplate($this->CountTmp, $Ret['Row'], $this->PageTmp, $this->Tmp['CateRs'], $UrlArr, $this->CommonObj->isMobile());
             } elseif ($this->Tmp['Type'] == 'search' && $Ret['IsPage'] == 1) {
                $Search[] = '{{qcms:List_PageBar}}';
                $Replace[] = $this->CommonObj->PageBar($this->CountTmp, $Ret['Row'], $this->CommonObj->isMobile());
             } elseif ($this->Tmp['Type'] == 'index' && $Ret['IsPage'] == 1) {
                 $Search[] = '{{qcms:List_PageBar}}';
                 $UrlArr = array('Default' => '/', 'Page' => 'index_{Page}');
                 $Replace[] = $this->CommonObj->PageBarTemplate($this->CountTmp, $Ret['Row'], $this->PageTmp, array(), $UrlArr, $this->CommonObj->isMobile());
             }
        }
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
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
            if(!$this->CommonObj->IsSafeQuery($Para['sql'])) {
                $Replace[] = $Matches[0][$k];
            }else{
                $Replace[] = self::_replaceLoop($Para['sql'], $Matches[2][$k], 'Loop_');
            }
        }
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }

    public function slide_Tmp(){ // 幻灯片
        preg_match_all("/{{slide([\s\S.]*?)}}([\s\S.]*?){{\/slide}}/i", $this->Tmp['Compile'], $Matches);
        $Search = array();
        $Replace = array();
        foreach($Matches[1] as $k => $v){
            $Para = self::_getKv($v);
            $Ret['SwiperCateId'] = !isset($Para['SwiperCateId']) ? '0' : intval($Para['SwiperCateId']);
            $Search[] = $Matches[0][$k];
            $Replace[] = self::_replaceSlide($Ret['SwiperCateId'], $Matches[2][$k], 'Slide_');
        }
        $this->Tmp['Compile'] = str_replace($Search, $Replace, $this->Tmp['Compile']);
        return $this;
    }

    public function createUrl($Type, $Index, $PinYin, $PY, $Ts = 0){
        switch($Type){
            case 'cate':
                $Url = $this->SysRs['UrlList'];
                $RetUrl = str_replace(array('{CateId}', '{PinYin}', '{PY}'), array($Index, $PinYin, $PY), $Url);
                break;
            case 'detail':
                $Url = $this->SysRs['UrlDetail'];
                $Y = date('Y', $Ts);
                $m = date('m', $Ts);
                $d = date('d', $Ts);
                $RetUrl = str_replace(array('{Id}', '{PinYin}', '{PY}', '{Y}', '{M}', '{D}'), array($Index, $PinYin, $PY, $Y, $m, $d), $Url);
                break;
            case 'page':
                $Url = $this->SysRs['UrlPage'];
                $RetUrl = str_replace(array('{PageId}', '{PinYin}', '{PY}'), array($Index, $PinYin, $PY), $Url);
                break;
        }
        return '/'.$Type.'/'.$RetUrl;
    }

    protected function p_upload($FileData){
        $Ret = $this->UploadObj->upload_file($FileData);
        if($this->SysRs['WaterMaskIsOpen'] != 1) return $Ret; //未开启水印
        if($Ret['Code'] != 0) return $Ret;
        $ext = substr ( strrchr ( $FileData['name'], '.' ), 1 );
        if(!in_array(strtolower($ext), array('jpg', 'png', 'gif'))) return $Ret;
        $this->WaterMaskObj->waterType = ($this->SysRs['WaterMaskType'] == 1) ? 1 : 0;
        $this->WaterMaskObj->fontFile = realpath('./Static/fonts/msyh.ttc');
        $this->WaterMaskObj->waterImg = realpath('.'.$this->SysRs['WaterMaskPic']);
        if($this->WaterMaskObj->waterType == 1){
            if(empty($this->SysRs['WaterMaskPic']) || !file_exists($this->WaterMaskObj->waterImg)) return $Ret;
        }else{
            if(!file_exists($this->WaterMaskObj->fontFile)) return $Ret;
        }

        $this->WaterMaskObj->waterStr = $this->SysRs['WaterMaskTxt'];
        $this->WaterMaskObj->pos = $this->SysRs['WaterMaskPostion'];
        $this->WaterMaskObj->transparent = $this->SysRs['WaterMaskFontOpacity'];
        $this->WaterMaskObj->fontSize = $this->SysRs['WaterMaskFontSize'];
        $this->WaterMaskObj->fontColor = explode(',', $this->SysRs['WaterMaskFontColor']);
        $this->WaterMaskObj->setSrcImg(realpath('.'.$Ret['Url']) );
        $this->WaterMaskObj->output();
        return $Ret;
    }

    private function _replaceSlide($SwiperCateId, $Html, $Pre){
        $Arr = $this->SwiperObj->getList($SwiperCateId);
        $Compile = '';
        $Search = array(
            '{{qcms:'.$Pre.'SwiperId}}',
            '{{qcms:'.$Pre.'Pic}}',
            '{{qcms:'.$Pre.'Title}}',
            '{{qcms:'.$Pre.'Link}}',
            '{{qcms:'.$Pre.'Sort}}',
            '{{qcms:'.$Pre.'Summary}}',
            '{{qcms:'.$Pre.'i}}',
            '{{qcms:'.$Pre.'n}}',
            '{{qcms:'.$Pre.'m}}',
        );
        foreach($this->SwiperFieldArr as $v){
            $Search[] = '{{qcms:'.$Pre.$v['Name'].'}}';
        }
        foreach($Arr as $k => $v){
            $Replace = array(
                $v['SwiperId'],
                $v['Pic'],
                $v['Title'],
                $v['Link'],
                $v['Sort'],
                $v['Summary'],
                ($k+1),
                $k,
                $k%2,
            );
            foreach($this->SwiperFieldArr as $FieldRs){
                $Replace[] = $v[$FieldRs['Name']];
            }
            $Compile .= str_replace($Search, $Replace, $Html);
        }
        return $Compile;
    }

    private function _replaceLoop($Sql, $Html, $Pre){
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

    private function _replacePhoto($Index, $Row, $Html, $Pre){
        $Rs = $this->PhotosObj->SetCond(array('Id' => $Index))->ExecSelectOne();
        $Photos = empty($Rs['Photos']) ? array() : json_decode($Rs['Photos'], true);
        $Compile = '';
        $Search = array('{{qcms:'.$Pre.'Name}}', '{{qcms:'.$Pre.'Path}}', '{{qcms:'.$Pre.'Size}}', '{{qcms:'.$Pre.'i}}', '{{qcms:'.$Pre.'n}}', '{{qcms:'.$Pre.'m}}');
        foreach($Photos as $k => $v){
            if(!empty($Row) && $k>=$Row) continue;
            $Replace = array($v['Name'], $v['Path'], $v['Size'], ($k+1), $k, $k%2);
            $Compile .= str_replace($Search, $Replace, $Html);
        }
        return $Compile;
    }

    private function _replaceLink($Ret, $Html, $Pre){
        $CondArr = array('State' => 1);
        if(isset($Ret['LinkCateId'])) $CondArr['LinkCateId'] = $Ret['LinkCateId'];
        if(isset($Ret['IsIndex'])) $CondArr['IsIndex'] = $Ret['IsIndex'];
        $Arr = $this->LinkObj->SetCond($CondArr)->SetSort(array('Sort' => 'ASC', 'LinkId' => 'ASC'))->SetCond($CondArr)->SetLimit(array(0, $Ret['Row']))->SetIsDebug(0)->ExecSelect();
        $Compile = '';
        $Search = array();
        $Search[] =  '{{qcms:'.$Pre.'i}}';
        $Search[] =  '{{qcms:'.$Pre.'n}}';
        $Search[] =  '{{qcms:'.$Pre.'m}}';
        $Search[] =  '{{qcms:'.$Pre.'Name}}';
        $Search[] =  '{{qcms:'.$Pre.'Logo}}';
        $Search[] =  '{{qcms:'.$Pre.'Link}}';
        $Search[] =  '{{qcms:'.$Pre.'Info}}';
        $Search[] =  '{{qcms:'.$Pre.'Mail}}';
        $Search[] =  '{{qcms:'.$Pre.'IsIndex}}';
        foreach($Arr as $k => $v){
            $Replace = array();
            $Replace[] =  ($k+1);
            $Replace[] =  $k;
            $Replace[] =  $k%2;
            $Replace[] = $v['Name'];
            $Replace[] = $v['Logo'];
            $Replace[] = $v['Link'];
            $Replace[] = $v['Info'];
            $Replace[] = $v['Mail'];
            $Replace[] = $v['IsIndex'];
            $Compile .= str_replace($Search, $Replace, $Html);
        }
        return $Compile;
    }

    private function _replaceList($Ret, $Html, $Pre){
        $ModelRs = $this->ModelKv[$Ret['Model']];
        $CondArr = array('IsDelete' => 2, 'State' => 1);
        if(!empty($Ret['CateId'])){
            $CateIds = explode(',', $Ret['CateId']);
            $AllSubCateIdArr = array();
            foreach($CateIds as $v){
                $this->CategoryObj->getAllCateId($v, $ModelRs['ModelId']);
                $AllSubCateIdArr = array_merge($AllSubCateIdArr, $this->CategoryObj->AllSubCateIdArr);
            }
            $CondArr['CateId'] = $AllSubCateIdArr;
        }
        if(!empty($Ret['Keyword'])){
            $TagArr = $this->TagObj->SetCond(array('Name' => explode(',', $Ret['Keyword'])))->ExecSelect();
            $TagIds = array_column($TagArr, 'TagId');
            $TagMap = $this->Tag_mapObj->SetCond(array('TagId' => $TagIds, 'ModelId' => $ModelRs['ModelId']))->SetLimit(array(0, ($Ret['Row']+1)))->SetSort(array('TagMapId' => 'DESC'))->ExecSelect();
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
        if(!empty($Ret['Search'])){
            $CondArr['Title LIKE'] = $Ret['Search'];
        }

        $Limit = ($Ret['IsPage'] != 1) ? array($Ret['Start'], $Ret['Row']) : array(($this->PageTmp-1)*$Ret['Row'], $Ret['Row']);
        $Count = 0;
        $Sort = array('Sort' => 'ASC', 'Id' => 'DESC');
        if($Ret['Sort'] == 'ReadNum'){
            $Sort = array('ReadNum' => 'DESC', 'Id' => 'DESC');
        }elseif($Ret['Sort'] == 'TsUpdate'){
            $Sort = array('TsUpdate' => 'DESC', 'Id' => 'DESC');
        }elseif($Ret['Sort'] == 'Good'){
            $Sort = array('Good' => 'DESC', 'Id' => 'DESC');
        }
        $FieldArr = empty($ModelRs['FieldJson']) ? array() : json_decode($ModelRs['FieldJson'], true);
        $ListField = $this->DefaultField;
        foreach($FieldArr as $v){
            if($v['IsList'] == 1) $ListField[] = $v['Name'];
        }
        $ListField = array_diff($ListField, array('Content', 'Index'));

        if($Ret['IsPage'] == 1){
            $Arr = $this->Sys_modelObj->SetTbName('table_'.$ModelRs['KeyName'])->SetField(implode(', ', $ListField))->SetCond($CondArr)->SetSort($Sort)->SetLimit($Limit)->SetIsDebug(0)->ExecSelectAll($Count);
            $this->CountTmp = $Count;
        }else{
            $Arr = $this->Sys_modelObj->SetTbName('table_'.$ModelRs['KeyName'])->SetField(implode(', ', $ListField))->SetCond($CondArr)->SetSort($Sort)->SetLimit($Limit)->SetIsDebug(0)->ExecSelect();
        }

        $Compile = '';
        $Search = array();
        foreach($ListField as $v){
            $Search[] =  '{{qcms:'.$Pre.$v.'}}';
        }
        $Search[] =  '{{qcms:'.$Pre.'i}}';
        $Search[] =  '{{qcms:'.$Pre.'n}}';
        $Search[] =  '{{qcms:'.$Pre.'m}}';
        $Search[] =  '{{qcms:'.$Pre.'CateName}}';
        $Search[] =  '{{qcms:'.$Pre.'CateNameEn}}';
        $Search[] =  '{{qcms:'.$Pre.'CatePic}}';
        $Search[] =  '{{qcms:'.$Pre.'CateUrl}}';
        $Search[] =  '{{qcms:'.$Pre.'Url}}';
        $Search[] =  '{{qcms:'.$Pre.'TimeAdd}}';
        $Search[] =  '{{qcms:'.$Pre.'TimeUpdate}}';
        $Search[] =  '{{qcms:'.$Pre.'DateAdd}}';
        $Search[] =  '{{qcms:'.$Pre.'DateUpdate}}';
        foreach($Arr as $k => $v){
            $CateRs = $this->CateKv[$v['CateId']];
            $UrlCate = self::createUrl('cate', $CateRs['CateId'], $CateRs['PinYin'], $CateRs['PY']);//$Url,
            $UrlDetail = self::createUrl('detail', $v['Id'], $v['PinYin'], $v['PY']);//$Url,
            $Replace = array();
            foreach($ListField as $sv){
                if($sv == 'Tag'){
                    $TagArr = explode(',', $v[$sv]);
                    $TagStrArr = array();
                    foreach($TagArr as $tv){
                        if(empty($tv)) continue;
                        $TagStrArr[] = '<a class="btn btn-default btn-sm mr-2" href="'.$this->CommonObj->Url(array('index', 'search')).'?Search='.$tv.'">'.$tv.'</a>';
                    }
                    $Replace[] =  implode('', $TagStrArr);
                }elseif($sv == 'Color'){
                    $Replace[] =  empty($v[$sv]) ? '' : 'color:'.$v[$sv].';';
                }else{
                    $Replace[] =  $v[$sv];
                }
            }
            $Replace[] =  ($k+1);
            $Replace[] =  $k;
            $Replace[] =  $k%2;
            $Replace[] = $CateRs['Name'];
            $Replace[] = $CateRs['NameEn'];
            $Replace[] = $CateRs['Pic'];
            $Replace[] = ($CateRs['IsLink'] == 1) ? $CateRs['LinkUrl'] : $UrlCate; // 分类地址
            $Replace[] = ($v['IsLink'] == '1') ? $v['LinkUrl'] : $UrlDetail;
            $Replace[] = date('Y-m-d H:i:s', $v['TsAdd']);
            $Replace[] = date('Y-m-d H:i:s', $v['TsUpdate']);
            $Replace[] = date('Y-m-d', $v['TsAdd']);
            $Replace[] = date('Y-m-d', $v['TsUpdate']);
            $Compile .= str_replace($Search, $Replace, $Html);
        }
        return $Compile;
    }

    private function _replaceTag($Row, $Html, $Pre){
        if($Row > 100) $Row = 100;
        $TagArr = $this->TagObj->SetLimit(array(0, $Row))->SetSort(array('Total' => 'DESC'))->ExecSelect();

        $Search = array(
            '{{qcms:'.$Pre.'TagId}}',
            '{{qcms:'.$Pre.'Name}}',
            '{{qcms:'.$Pre.'Total}}',
            '{{qcms:'.$Pre.'Url}}',
            '{{qcms:'.$Pre.'i}}',
            '{{qcms:'.$Pre.'n}}',
            '{{qcms:'.$Pre.'m}}',
        );

        foreach($TagArr as $k => $v){
            $Link = $this->CommonObj->Url(array('index', 'search')).'?Search='.$v['Name'];
            $Replace = array(
                $v['TagId'],
                $v['Name'],
                $v['Total'],
                $Link,
                ($k+1),
                $k,
                $k%2,
            );
            $Compile .= str_replace($Search, $Replace, $Html);
        }
        return $Compile;
    }

    private function _replaceCate($PCateId, $Start, $Row, $Html, $Pre){
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
            '{{qcms:'.$Pre.'TCateId}}',
            '{{qcms:'.$Pre.'Name}}',
            '{{qcms:'.$Pre.'NameEn}}',
            '{{qcms:'.$Pre.'ModelId}}',
            '{{qcms:'.$Pre.'Pic}}',
            '{{qcms:'.$Pre.'SeoTitle}}',
            '{{qcms:'.$Pre.'Keywords}}',
            '{{qcms:'.$Pre.'Description}}',
            '{{qcms:'.$Pre.'Url}}',
            '{{qcms:'.$Pre.'HasSub}}',
            '{{qcms:'.$Pre.'i}}',
            '{{qcms:'.$Pre.'n}}',
            '{{qcms:'.$Pre.'m}}',
        );
        foreach($this->CateFieldArr as $v){
            $Search[] = '{{qcms:'.$Pre.$v['Name'].'}}';
        }
        $End = $Start+$Row;
        foreach($CateArr as $k => $v){
            if($Row >0){
                if($k < $Start || $k >= $End) continue;
            }
            //if($Row >0 && $k >= $Row) continue;
            $Url = ($v['IsLink'] == 1) ? $v['LinkUrl'] : self::createUrl('cate', $v['CateId'], $v['PinYin'], $v['PY']);
            $TCateId = empty($v['TCateId']) ? $v['CateId'] : $v['TCateId'];
            $Replace = array(
                $v['CateId'],
                $v['PCateId'],
                $TCateId,
                $v['Name'],
                $v['NameEn'],
                $v['ModelId'],
                $v['Pic'],
                $v['SeoTitle'],
                $v['Keywords'],
                $v['Description'],
                $Url,//$Url,
                $v['HasSub'],
                ($k+1),
                $k,
                $k%2,
            );
            foreach($this->CateFieldArr as $FieldRs){
                $Replace[] = $v[$FieldRs['Name']];
            }
            $Compile .= str_replace($Search, $Replace, $Html);
        }
        return $Compile;
    }

    private function _replaceOne($Type, $Rs, $Html, $Pre){
        $Search = $Replace = array();
        foreach($Rs as $k => $v){
            $Search[] = '{{qcms:'.$Pre.$k.'}}';
            $Replace[] = $v;
        }
        $Search[] = '{{qcms:'.$Pre.'TimeAdd}}';
        $Search[] = '{{qcms:'.$Pre.'TimeUpdate}}';
        $Replace[] = date('Y-m-d H:i:s', $Rs['TsAdd']);
        $Replace[] = date('Y-m-d H:i:s', $Rs['TsUpdate']);
        switch($Type){
            case 'cate':
                $Search[] = '{{qcms:'.$Pre.'Url}}';
                $Url = ($Rs['IsLink'] == 1) ? $Rs['LinkUrl'] : self::createUrl('cate', $Rs['CateId'], $Rs['PinYin'], $Rs['PY']);
                $Replace[] = $Url;
                break;
            case 'page':
                $Search[] = '{{qcms:'.$Pre.'Url}}';
                $Replace[] = self::createUrl('page', $Rs['PageId'], $Rs['PinYin'], $Rs['PY']);
                break;
            case 'detail':
                $Search[] = '{{qcms:'.$Pre.'Url}}';
                $Url = ($Rs['IsLink'] == 1) ? $Rs['LinkUrl'] : self::createUrl('detail', $Rs['Id'], $Rs['PinYin'], $Rs['PY']);//$Url,
                $Replace[] = $Url;
                break;
        }
        $Compile = str_replace($Search, $Replace, $Html);
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

    private function _getKv2If2($Str, $CondStr){ // if专用获取参数
        $Str = str_replace(' ', '', $Str);
        preg_match("/\'([\w\W]*?)\'".$CondStr."\'([\w\W]*?)\'/i",$Str, $Matches);
        if(empty($Matches[0])) return array();
        return array($Matches[1], $Matches[2]);
    }

    private function _getKv2If($Str, $CondStr){ // if专用获取参数
        $Str = str_replace(' ', '', $Str);
        preg_match("/\'([\w\W]*?)\'".$CondStr."\'([\w\W]*?)\'/i",$Str, $Matches);
        if(empty($Matches[0])) return array();
        return array($Matches[1], $Matches[2]);
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
    public $ModelKeyNameArr = array(
        'index' => '管理',
        'add' => '添加',
        'edit' => '修改',
        'del' => '删除',
    );

    public $CategoryFieldArr = array(
        'CateId',
        'PCateId',
        'TCateId',
        'Name',
        'Pic',
        'ModelId',
        'IsPost',
        'IsShow',
        'UserLevel',
        'IsLink',
        'LinkUrl',
        'TempList',
        'TempDetail',
        'SeoTitle',
        'Keywords',
        'Description',
        'Content',
        'IsCross',
        'Sort',
        'PinYin',
        'PY',
        'NameEn'
    );

    public $SwiperFieldArr = array(
        'SwiperId',
        'SwiperCateId',
        'Pic',
        'Title',
        'Link',
        'Sort',
        'Summary'
    );

    public $IsArr = array('1' => '是', 2 => '否');
    public $OpenArr = array('1' => '开启', 2 => '关闭');
    public $IsShowArr = array('1' => '显示', 2 => '隐藏');
    public $StateArr = array('1' => '已发布', 2 => '未发布');
    public $SexArr = array('1' => '男', 2 => '女');
    public $StateDevMap = array(1 => '已审核', 2 => '开发中', 3 => '待审核', 4 => '已拒绝');
    public $StateDevColorMap = array(1 => 'success', 2 => 'warning', 3 => 'info', 4 => 'danger');
    public $EditorArr = array('ckeditor' => 'ckeditor');
    public $LangArr = array('Cn' => '中文');
    public $SiteArr = array();
    public $PermissionArr = array();
    public $HeadHtml = '';
    public $DevRs = array();
    function __construct(){
        parent::__construct();
        self::_postKey();
        self::_getUpdate();
        $Token = $this->CookieObj->get('Token', 'User');
        $TokenRs = $this->TokenObj->getOne($Token);
        if(empty($TokenRs)) $this->Jump(array('index', 'adminLogout'), 1007);
        $UserRs = $this->UserObj->getOne($TokenRs['UserId']);
        if(empty($UserRs) || $UserRs['GroupAdminId'] == -1) $this->Jump(array('index', 'adminLogout'), 1007);
        $this->LoginUserRs = $UserRs;
        $this->SysRs = $this->SysObj->getKv();
        $GroupAdminRs = $this->Group_adminObj->getOne($this->LoginUserRs['GroupAdminId']);
        $this->PermissionArr = empty($GroupAdminRs['Permission']) ? array() : explode('|', $GroupAdminRs['Permission']);
        $this->BuildObj->UploadUrl = $this->CommonObj->Url(array('admin', 'api', 'ajaxUpload'));
        $this->UploadObj->set(explode('|', $this->SysRs['AllowUploadType']), 2048);
        if(!empty($this->SysRs['BindPhone'])){ // 绑定平台账号
            $DevRs = $this->apiRemotePlatform('apiRemote/devInfo', array());
            if($DevRs['Code'] == 0) $this->DevRs = $DevRs['Data'];
        }
        $this->MenuArr = array(
            /***一级***/
            'admin/sys' => array('Name' => '系统管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'sys'))),
            'admin/category' => array('Name' => '分类管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category'))),
            'admin/content' => array('Name' => '内容管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content'))),
            'admin/user' => array('Name' => '会员中心', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'user'))),
            'admin/data' => array('Name' => '数据维护', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'data'))),
            'admin/assist' => array('Name' => '辅助管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'assist'))),
            'admin/front' => array('Name' => '页面设计', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'front'))),
            'admin/templates' => array('Name' => '模板管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'templates'))),
            // 用户首页
            'admin/index/index' => array('Name' => '用户首页', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'index', 'index'))),
            'admin/index/upgrade' => array('Name' => '系统升级', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'index', 'upgrade'))),
            'admin/index/upgradeManual' => array('Name' => '系统升级', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'index', 'upgradeManual'))),
            // 系统管理
            'admin/sys/index' => array('Name' => '基本设置', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'sys', 'index'))),
            'admin/sys/license' => array('Name' => '系统授权', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'sys', 'license'))),
            'admin/sys/check' => array('Name' => '环境检测', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'sys', 'check'))),
            'admin/sys/redis' => array('Name' => 'Redis设置', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'sys', 'redis'))),
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
            'admin/sysField/index' => array('Name' => '系统变量管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'sysField', 'index'))),
            'admin/sysField/add' => array('Name' => '添加系统变量', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'sysField', 'add'))),
            'admin/sysField/edit' => array('Name' => '修改系统变量', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'sysField', 'edit'))),
            'admin/sysField/del' => array('Name' => '删除系统变量', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'sysField', 'del'))),

            'admin/categoryField/index' => array('Name' => '分类字段管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'categoryField', 'index'))),
            'admin/categoryField/add' => array('Name' => '添加分类字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'categoryField', 'add'))),
            'admin/categoryField/edit' => array('Name' => '修改分类字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'categoryField', 'edit'))),
            'admin/categoryField/del' => array('Name' => '删除分类字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'categoryField', 'del'))),

            'admin/swiperField/index' => array('Name' => '幻灯片字段管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'swiperField', 'index'))),
            'admin/swiperField/add' => array('Name' => '添加幻灯片字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'swiperField', 'add'))),
            'admin/swiperField/edit' => array('Name' => '修改幻灯片字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'swiperField', 'edit'))),
            'admin/swiperField/del' => array('Name' => '删除幻灯片字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'swiperField', 'del'))),

            // 分类管理
            'admin/category/index' => array('Name' => '分类管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'index'))),
            'admin/category/add' => array('Name' => '添加分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'add'))),
            'admin/category/edit' => array('Name' => '修改分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'edit'))),
            'admin/category/del' => array('Name' => '删除分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'del'))),
            'admin/category/move' => array('Name' => '移动分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'move'))),
            'admin/category/empty' => array('Name' => '清空分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'empty'))),
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
            //'admin/content/recovery' => array('Name' => '回收站', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', 'recovery'))),
            //'admin/content/view' => array('Name' => '查看文章', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', 'view'))),
            //'admin/content/restore' => array('Name' => '恢复文章', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', 'restore'))),
            //'admin/content/tDelete' => array('Name' => '彻底删除', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', 'tDelete'))),
            //'admin/content/photos' => array('Name' => '照片管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', 'photos'))),
            //'admin/content/photoDel' => array('Name' => '照片删除', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', 'photoDel'))),
            //'admin/content/photoSort' => array('Name' => '照片排序', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', 'photoSort'))),

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
            'admin/front/index' => array('Name' => '页面管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'front', 'index'))),
            'admin/front/add' => array('Name' => '添加模板', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'front', 'add'))),
            'admin/front/edit' => array('Name' => '修改模板', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'front', 'edit'))),
            'admin/front/del' => array('Name' => '删除模板', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'front', 'del'))),
            'admin/front/builder' => array('Name' => '代码生成器', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'front', 'builder'))),
            'admin/front/test' => array('Name' => '模板标签测试', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'front', 'test'))),
            'admin/front/api' => array('Name' => 'API接口调试', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'front', 'api'))),
            'admin/templates/market' => array('Name' => '模板市场', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'templates', 'market'))),
            'admin/templates/installed' => array('Name' => '已安装模版', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'templates', 'installed'))),
            'admin/plugin/index' => array('Name' => '插件管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'plugin', 'index'))),
            'admin/plugin/market' => array('Name' => '插件市场', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'plugin', 'market'))),
            'admin/plugin/config' => array('Name' => '设置管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'plugin', 'config'))),
            'admin/plugin/installed' => array('Name' => '已安装插件', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'plugin', 'installed'))),

            'admin/develop/index' => array('Name' => '开发中心', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'develop', 'index'))),
            'admin/develop/templates' => array('Name' => '模版开发', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'develop', 'templates'))),
            'admin/develop/plugin' => array('Name' => '插件开发', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'develop', 'plugin'))),
            // API
            'admin/api/ajaxUpload' => array('Name' => 'AJAX上传', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'ajaxUpload'))),
            'admin/api/ajaxBind' => array('Name' => 'AJAX绑定账号', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'ajaxBind'))),
            'admin/api/ajaxUnBind' => array('Name' => 'AJAX解绑账号', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'ajaxUnBind'))),
            'admin/api/batchUpload' => array('Name' => '批量上传', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'batchUpload'))),
            'admin/api/ckUpload' => array('Name' => 'CkEditor上传', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'ckUpload'))),
            'admin/api/userState' => array('Name' => '设置用户状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'userState'))),
            'admin/api/linkState' => array('Name' => '设置链接状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'linkState'))),
            'admin/api/pageState' => array('Name' => '设置单页状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'pageState'))),
            'admin/api/labelState' => array('Name' => '设置标签状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'labelState'))),
            'admin/api/formState' => array('Name' => '设置表单状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'formState'))),
            'admin/api/formDataState' => array('Name' => '设置表单回复状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'formDataState'))),
            'admin/api/inlinkState' => array('Name' => '设置内链状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'inlinkState'))),
            'admin/api/tableField' => array('Name' => '查询表字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'tableField'))),
            'admin/api/sort' => array('Name' => '排序通用模块', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'sort'))),
            'admin/api/contentStateOne' => array('Name' => '文章操作', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'contentStateOne'))),
            'admin/api/contentState' => array('Name' => '文章批量操作', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'contentState'))),
            'admin/api/deleteRec' => array('Name' => '彻底删除', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'deleteRec'))),
            'admin/api/emptyRec' => array('Name' => '清空回收站', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'emptyRec'))),
            'admin/api/fileDel' => array('Name' => '附件删除', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'fileDel'))),
            'admin/api/fileClean' => array('Name' => '清除无效附件', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'fileClean'))),
            'admin/api/fileBrowse' => array('Name' => '浏览上传目录', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'fileBrowse'))),
            'admin/api/contentAttr' => array('Name' => '批量操作内容属性', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'contentAttr'))),
            'admin/api/contentMove' => array('Name' => '批量移动内容', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'contentMove'))),
            'admin/api/templateInstall' => array('Name' => '安装模板', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'templateInstall'))),
            'admin/api/templateUpgrade' => array('Name' => '升级模板', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'templateUpgrade'))),
            'admin/api/templateInstallData' => array('Name' => '安装模板数据', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'templateInstallData'))),
            'admin/api/templateDelete' => array('Name' => '删除模版', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'templateDelete'))),
            'admin/api/pluginInstall' => array('Name' => '安装插件', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'pluginInstall'))),
            'admin/api/pluginUpgrade' => array('Name' => '升级插件', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'pluginUpgrade'))),
            'admin/api/pluginUnInstall' => array('Name' => '卸载插件', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'pluginUnInstall'))),
            'admin/api/pluginState' => array('Name' => '设置插件状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'pluginState'))),
            'admin/api/paytp' => array('Name' => '购买模板', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'paytp'))),
            'admin/api/payplugin' => array('Name' => '购买插件', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'payplugin'))),
            'admin/api/payStatus' => array('Name' => '获取订单状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'payStatus'))),
            'admin/api/templatesGetVerion' => array('Name' => '获取模版版本', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'templatesGetVerion'))),
            'admin/api/pluginGetVerion' => array('Name' => '获取插件版本', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'pluginGetVerion'))),
            'index/adminLogout' => array('Name' => '安全退出', 'Permission' => array('1', '2', '3'), 'Url' => $this->CommonObj->url(array('index', 'adminLogout'))),
        );

        // 动态模块
        $ModelArr = $this->Sys_modelObj->getList();
        $RoleMenuArr = array();
        foreach($ModelArr as $v) {
            $Para = array('ModelId' => $v['ModelId']);
            $KeyArr = array();
            foreach(array('index', 'add', 'edit', 'del', 'recovery', 'view', 'restore', 'tDelete', 'photos', 'photoDel', 'photoSort') as $mv){
                $Key = 'admin/content/'.$mv.'?'.http_build_query($Para);
                $KeyArr[$v['ModelId']][] = $Key;
                $this->MenuArr[$Key] = array('Name' => $v['Name'].$this->ModelKeyNameArr[$mv], 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', $mv)), 'Para' => array('ModelId' => $v['ModelId']));
            }
            $RoleMenuArr[] = array('Key' => $KeyArr[$v['ModelId']][0], 'alias' => $KeyArr[$v['ModelId']]);
        }

        // 动态插件 (6.0.5版本才支持)
        $MenuSide = array();
        if($this->CommonObj->compare_versions('6.0.5', $this->SysRs['Version'])){ 
            $MenuSide = $this->Menu_sideObj->getList();
        }
        $MenuTree = array();
        foreach($MenuSide as $k => $v){
            if($v['PId'] != 0) continue;
            $v['Sub'] = array();
            $MenuTree[$v['MenuSideId']] = $v;
            $Key = 'Plugin/'.$v['NameKey'];
            $this->MenuArr[$Key] = array('Name' => $v['Name'], 'Permission' => array('1', '2', '3'), 'Url' => $this->CommonObj->url(array('admin', 'plugin', $v['NameKey'])), 'Para' => array());
        }

        foreach($MenuSide as $k => $v){
            if($v['PId'] == 0) continue;
            $MenuTree[$v['PId']]['Sub'][] = $v;
            $Key = 'Plugin/'.$v['NameKey'].'/'.$v['Url'];
            $this->MenuArr[$Key] = array('Name' => $v['Name'], 'Permission' => array('1', '2', '3'), 'Url' => $this->CommonObj->url(explode('/', $Key)), 'Para' => array());
        }

        $this->RoleMenuArr = array(
            array('Key' => 'admin/index/index', 'subCont' => array('index'), 'Icon' => 'home'),
            array('Key' => 'admin/category', 'subCont' => array('category', 'page', 'pageCate', 'labelCate', 'label', 'form', 'formField', 'formData'), 'Icon' => 'ordered-list', 'Sub' => array(
                array('Key' => 'admin/category/index', 'alias' => array('admin/category/index', 'admin/category/add', 'admin/category/edit', 'admin/category/move')),
                array('Key' => 'admin/page/index', 'alias' => array('admin/page/index', 'admin/page/add', 'admin/page/edit', 'admin/pageCate/index', 'admin/pageCate/add', 'admin/pageCate/edit')),
                array('Key' => 'admin/form/index', 'alias' => array('admin/form/index', 'admin/form/add', 'admin/form/edit', 'admin/form/code', 'admin/formField/index', 'admin/formField/add', 'admin/formField/edit', 'admin/formData/index')),
                array('Key' => 'admin/label/index', 'alias' => array('admin/label/index', 'admin/label/add', 'admin/label/edit', 'admin/labelCate/index', 'admin/labelCate/add', 'admin/labelCate/edit')),
            )),
            array('Key' => 'admin/content', 'subCont' => array('content'), 'Icon' => 'log', 'Sub' => $RoleMenuArr),
            array('Key' => 'admin/user', 'subCont' => array('user', 'groupUser'), 'Icon' => 'peoples', 'Sub' => array(
                array('Key' => 'admin/user/index', 'alias' => array('admin/user/index', 'admin/user/add', 'admin/user/edit')),
                array('Key' => 'admin/groupUser/index', 'alias' => array('admin/groupUser/index', 'admin/groupUser/add', 'admin/groupUser/edit')),
            )),
            array('Key' => 'admin/data', 'subCont' => array('data', 'model', 'modelField', 'database', 'redisManage', 'sysField', 'categoryField', 'swiperField'), 'Icon' => 'tool', 'Sub' => array(
                array('Key' => 'admin/model/index', 'alias' => array('admin/model/index', 'admin/model/add', 'admin/model/edit', 'admin/modelField/index', 'admin/modelField/add', 'admin/modelField/edit')),
                array('Key' => 'admin/sysField/index', 'alias' => array('admin/sysField/index', 'admin/sysField/add', 'admin/sysField/edit')),
                array('Key' => 'admin/categoryField/index', 'alias' => array('admin/categoryField/index', 'admin/categoryField/add', 'admin/categoryField/edit')),
                array('Key' => 'admin/swiperField/index', 'alias' => array('admin/swiperField/index', 'admin/swiperField/add', 'admin/swiperField/edit')),
                array('Key' => 'admin/database/index', 'alias' => array('admin/database/index')),
                array('Key' => 'admin/redisManage/index', 'alias' => array('admin/redisManage/index')),
                array('Key' => 'admin/data/replace', 'alias' => array('admin/data/replace')),
                array('Key' => 'admin/data/highReplace', 'alias' => array('admin/data/highReplace')),
            )),
            array('Key' => 'admin/assist', 'subCont' => array('linkCate', 'link', 'inlinkCate', 'inlink', 'file', 'swiper', 'swiperCate', 'tag'), 'Icon' => 'page-template', 'Sub' => array(
                array('Key' => 'admin/link/index', 'alias' => array('admin/link/index', 'admin/link/add', 'admin/link/edit', 'admin/linkCate/index', 'admin/linkCate/add', 'admin/linkCate/edit')),
                array('Key' => 'admin/inlink/index', 'alias' => array('admin/inlink/index', 'admin/inlink/add', 'admin/inlink/edit', 'admin/inlinkCate/index', 'admin/inlinkCate/add', 'admin/inlinkCate/edit')),
                array('Key' => 'admin/swiperCate/index', 'alias' => array('admin/swiperCate/index', 'admin/swiperCate/add', 'admin/swiperCate/edit', 'admin/swiper/index', 'admin/swiper/add', 'admin/swiper/edit')),
                array('Key' => 'admin/tag/index', 'alias' => array('admin/tag/index', 'admin/tag/list')),
                array('Key' => 'admin/file/index', 'alias' => array('admin/file/index')),
            )),
            array('Key' => 'admin/front', 'subCont' => array('front'), 'Icon' => 'bydesign', 'Sub' => array(
                array('Key' => 'admin/front/index', 'alias' => array('admin/front/index', 'admin/front/add', 'admin/front/edit')),
                array('Key' => 'admin/front/builder', 'alias' => array('admin/front/builder')),
                array('Key' => 'admin/front/test', 'alias' => array('admin/front/test')),
                array('Key' => 'admin/front/api', 'alias' => array('admin/front/api')),
            )),
            array('Key' => 'admin/templates', 'subCont' => array('templates'), 'Icon' => 'web-page', 'Sub' => array(
                array('Key' => 'admin/templates/market', 'alias' => array('admin/templates/market')),
                array('Key' => 'admin/templates/installed', 'alias' => array('admin/templates/installed')),
            )),
            array('Key' => 'admin/plugin/index', 'subCont' => array('plugin'), 'Icon' => 'components', 'Sub' => array(
                array('Key' => 'admin/plugin/market', 'alias' => array('admin/plugin/market')),
                array('Key' => 'admin/plugin/installed', 'alias' => array('admin/plugin/installed', 'admin/plugin/config')),
            )),

        );
        if(!empty($this->DevRs)){
            array_push($this->RoleMenuArr, array('Key' => 'admin/develop/index', 'subCont' => array('develop'), 'Icon' => 'code', 'Sub' => array(
                array('Key' => 'admin/develop/templates', 'alias' => array('admin/develop/templates')),
                array('Key' => 'admin/develop/plugin', 'alias' => array('admin/develop/plugin')),
            )));
        }

        foreach($MenuTree as $k => $v){
            $Key = 'Plugin/'.$v['NameKey'];
            $PluginMenu = array('Key' => $Key, 'subCont' => array('Plugin/'.$v['NameKey'].'/index'), 'Icon' => 'api-app', 'Sub' => array());
            foreach($v['Sub'] as $sk => $sv){
                if($sv['IsShow'] != '1') continue;
                $Key = 'Plugin/'.$sv['NameKey'].'/'.$sv['Url'];
                $PluginMenu['Sub'][] = array('Key' => $Key, 'alias' => array($Key));
            }
            array_push($this->RoleMenuArr, $PluginMenu);
        }

        array_push($this->RoleMenuArr,
            array('Key' => 'admin/sys', 'subCont' => array('sys', 'admin', 'groupAdmin', 'log', 'site'), 'Icon' => 'setting-two', 'Sub' => array(
                array('Key' => 'admin/sys/index', 'alias' => array('admin/sys/index')),
                array('Key' => 'admin/sys/license', 'alias' => array('admin/sys/license')),
                array('Key' => 'admin/sys/check', 'alias' => array('admin/sys/check')),
                array('Key' => 'admin/sys/redis', 'alias' => array('admin/sys/redis')),
                array('Key' => 'admin/site/index', 'alias' => array('admin/site/index', 'admin/site/add', 'admin/site/edit')),
                array('Key' => 'admin/admin/index', 'alias' => array('admin/admin/index', 'admin/admin/add', 'admin/admin/edit')),
                array('Key' => 'admin/groupAdmin/index', 'alias' => array('admin/groupAdmin/index', 'admin/groupAdmin/add', 'admin/groupAdmin/edit')),
                array('Key' => 'admin/log/operate', 'alias' => array('admin/log/operate')),
                array('Key' => 'admin/log/login', 'alias' => array('admin/log/login')),
            )),
            array('Key' => 'index/adminLogout', 'subCont' => array('signout'), 'Icon' => 'logout')
         );

        $Url = implode('/', array($this->Module, Router::$s_Controller, Router::$s_Method));

        if(Router::$s_IsPlug){
            $Url = implode('/', array('Plugin', Router::$s_PlusKeyName, Router::$s_Controller, Router::$s_Method));
        }
        $Key = '';
        foreach($this->MenuArr as $k => $v){
            if(strpos($k, $Url) === 0){
                if(!empty($v['Para'])){
                    $GetPara = array();
                    foreach($v['Para'] as $pk => $pv) $GetPara[$pk] = $_GET[$pk];
                    $Key = $Url.'?'.http_build_query($GetPara);
                }else{
                    $Key = $k;
                }
            }
        }

        if(!isset($this->MenuArr[$Key])) $this->Err(1056);
        $MenuRs = $this->MenuArr[$Key];

        if($this->LoginUserRs['GroupAdminId'] != 1 && !in_array($Key, $this->PermissionArr)) $this->Err(1005);
        $this->PageTitle = $MenuRs['Name'];
        $this->PageTitle2 = $this->BuildObj->FormTitle($MenuRs['Name']);

        foreach($this->RoleMenuArr as $v){
            $subContMatch = Router::$s_IsPlug ? 'Plugin/'.Router::$s_PlusKeyName.'/'.Router::$s_Controller : Router::$s_Controller;
            if(in_array($subContMatch, $v['subCont'])){
                $this->MenuArr[$v['Key']]['IsActive'] = 'active';
                $this->BreadCrumb[] = $this->MenuArr[$v['Key']];
                if(empty($v['Sub'])) continue;
                foreach($v['Sub'] as $sv){
                    if(in_array($Key, $sv['alias'])){
                        $this->MenuArr[$sv['Key']]['IsActive'] = 'active';
                        $this->BreadCrumb[] = $this->MenuArr[$Url];
                        break;
                    }
                }
                //$this->BreadCrumb[] = $this->MenuArr[$Key];
                break;
            }
        }
        $this->SiteArr = $this->SiteObj->getList();
        if(!isset($this->SysRs['TmpPathMobile'])){
            $this->SysObj->SetInsert(array('Name' => 'TmpPathMobile', 'Info' => '手机模板路径', 'AttrValue' => '', 'GroupId' => 2, 'AttrType' => 'select', 'Sort' => '2010', 'IsSys' => 1))->ExecInsert();
            $this->SysObj->cleanList();
        }
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

    public function getTempFolder(){ // 获取模板文件夹
        $Files = scandir(PATH_TEMPLATE);
        $Folder = array();
        foreach($Files as $v){
            if(in_array($v, array('.', '..'))) continue;
            if(!is_dir(PATH_TEMPLATE.$v)) continue;
            $Folder[$v] = $v;
        }
        return $Folder;
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

    public function setRedis($Host, $Password, $Port, $IsOpen){ //设置Redis服务接口
        $Ret = array('Code' => 0, 'Data' => array(), 'Msg' => '');
        $Extensions = get_loaded_extensions();
        if($IsOpen == 1){
            if(!in_array('redis', $Extensions)) {
                $Ret['Code'] = '1001';
                $Ret['Msg'] = 'Redis extension does not exist';
                return $Ret;
            }
            try {
                $redisObj = new \Redis();
                $redisObj->connect ($Host, $Port);
                $redisObj->auth ($Password);
                $redisObj->ping();
            } catch ( Exception $e ) {
                $Msg = iconv('gbk', 'utf-8', $e->getMessage());
                $Ret['Code'] = '1002';
                $Ret['Msg'] = $e->getMessage();
                return $Ret;
            }
        }
        $RedisConfig = array(
            'Host' => $Host,
            'Password' => $Password,
            'Port' => $Port,
            'IsOpen' => $IsOpen,
        );
        $ConfIniPath = PATH_LIB.'Config/Config.ini';
        $ConfRs = parse_ini_file($ConfIniPath, true);
        $ConfRs['RedisConfig'] = $RedisConfig;
        $Ret = $this->CommonObj->writeIni($ConfIniPath, $ConfRs, true);
        if($Ret === false) {
            $Ret['Code'] = '1001';
            $Ret['Msg'] = '写入配置文件失败';
            return $Ret;
        }
        return $Ret;
    }

    public function apiRemotePlatform($ApiUrl, $ParaArr){ // 平台需登录接口
        $Para = array_merge(array('Phone' => $this->SysRs['BindPhone'], 'Ts' => time()), $ParaArr);
        ksort($Para);
        $Para['Sign'] = md5($this->CommonObj->HttpBuildQueryQ($Para).'|'.$this->p_RemoteKey);
        $Json = $this->CurlObj->SetUrl($this->PlatformUrl.$ApiUrl)->SetDebug(false)->SetPara($Para)->SetIsPost(true)->SetIsHttps(true)->SetIsJson(true)->Execute();
        $Ret = json_decode($Json, true);
        return $Ret;
    }

    public function loginPlatform($Phone, $Pwd){ // 绑定平台账户
        $Para = array('Phone' => $Phone, 'Pwd' => $Pwd);
        $Json = $this->CurlObj->SetUrl($this->PlatformUrl.'api/login.html')->SetDebug(false)->SetPara($Para)->SetIsPost(true)->SetIsHttps(true)->SetIsJson(false)->Execute();
        $Ret = json_decode($Json, true);
        return $Ret;
    }

    public function getPlugin($Page, $PageNum, $CateId = 0, $PluginIds = array(), $State = 1){
        $Para = array('Domain' => URL_DOMAIN, 'Page' => $Page, 'PageNum' => $PageNum, 'CateId' => $CateId, 'PluginIds' => implode('|', $PluginIds));
        if($State == 1){
            $Para['State'] = 1;
        }
        $Json = $this->CurlObj->SetUrl($this->PlatformUrl.'client/plugin.html')->SetDebug(false)->SetPara($Para)->SetIsPost(false)->SetIsHttps(true)->SetIsJson(true)->Execute();
        $Ret = json_decode($Json, true);
        return $Ret;
    }

    public function getPluginCate(){
        $Json = $this->CurlObj->SetUrl($this->PlatformUrl.'client/pluginCate.html')->SetPara(array('Domain' => URL_DOMAIN))->SetIsPost(false)->SetIsHttps(true)->SetIsJson(true)->Execute();
        $Ret = json_decode($Json, true);
        return $Ret;
    }

    public function getDevTemplaites($Page, $PageNum, $CateId = 0, $TemplatesIds = array()){
        $Para = array('Domain' => URL_DOMAIN, 'P' => $Page, 'PageNum' => $PageNum, 'CateId' => $CateId, 'TemplatesIds' => implode('|', $TemplatesIds));
        $Json = $this->CurlObj->SetUrl($this->PlatformUrl.'client/templates.html')->SetDebug(false)->SetPara($Para)->SetIsPost(false)->SetIsHttps(true)->SetIsJson(true)->Execute();
        $Ret = json_decode($Json, true);
        return $Ret;
    }

    public function getTemplaites($Page, $PageNum, $CateId = 0, $TemplatesIds = array(), $State = 1){
        $Para = array('Domain' => URL_DOMAIN, 'P' => $Page, 'PageNum' => $PageNum, 'CateId' => $CateId, 'TemplatesIds' => implode('|', $TemplatesIds));
        if($State == 1){
            $Para['State'] = 1;
        }
        $Json = $this->CurlObj->SetUrl($this->PlatformUrl.'client/templates.html')->SetDebug(false)->SetPara($Para)->SetIsPost(false)->SetIsHttps(true)->SetIsJson(true)->Execute();
        $Ret = json_decode($Json, true);
        return $Ret;
    }

    public function getTemplaitesCate(){
        $Json = $this->CurlObj->SetUrl($this->PlatformUrl.'client/templatesCate.html')->SetPara(array('Domain' => URL_DOMAIN))->SetIsPost(false)->SetIsHttps(true)->SetIsJson(true)->Execute();
        $Ret = json_decode($Json, true);
        return $Ret;
    }

    public function getVerUpdate(){
        $Params = array('Domain' => URL_DOMAIN, 'Version' => $this->SysRs['Version']);
        //$Params['IsDev'] = '1';
        $Json = $this->CurlObj->SetUrl($this->PlatformUrl.'client/getUpdate.html')->SetPara($Params)->SetIsPost(false)->SetIsHttps(true)->SetIsJson(true)->Execute();
        $Ret = json_decode($Json, true);
        return $Ret;
    }

    public function createTable($TablePre, $TableArr, $IsDropTable = false ){ //创建插件数据表
        $Tables = $this->SysObj->query('SHOW TABLES', array());
        $HaveTableArr = array_column($Tables, 'Tables_in_redcms');
        foreach($TableArr as $k => $v){
            $TableName = $TablePre.$k;
            if(in_array($TableName, $HaveTableArr)) throw new PDOException(self::lang(1020));
            if(count($v['Field']) == 0) throw new PDOException(self::lang(1023));
            $NameArr = array_column($v['Field'], 'Field');
            if(!isset($v['PrimaryKey']) || !in_array($v['PrimaryKey'], $NameArr)) throw new PDOException(self::lang(1024));
            $FieldArr = array();
            foreach($v['Field'] as $sv){
                $Default = ($sv['Extra'] == 'auto_increment') ? $sv['Extra'] : 'DEFAULT \''.$sv['Default'].'\'';
                if($sv['Type'] == 'date') $Default = 'DEFAULT \'1970-01-01\'';
                if(in_array($sv['Type'], array('blob', 'text', 'geometry', 'json'))) $Default = '';
                $Comment = 'COMMENT \''.$sv['Comment'].'\'';
                $IsNotNull = (in_array($sv['Type'], array('text'))) ? '' : 'NOT NULL';
                $FieldArr[] = '`'.$sv['Field'].'` '.$sv['Type'].' '.$IsNotNull.' '.$sv['Extra'].' '.$Default.' '.$Comment.','.PHP_EOL;
            }
            $TableSql = 'CREATE TABLE IF NOT EXISTS `'.$TableName.'` ( '.PHP_EOL.implode('', $FieldArr).' PRIMARY KEY (`'.$v['PrimaryKey'].'`)) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT=\''.$v['Comment'].'\';';
            if($IsDropTable) $this->SysObj->exec('DROP TABLE IF EXISTS `'.$TableName.'`;', array()); //删除原有表
            if ($this->SysObj->exec($TableSql, array()) === false) throw new PDOException(self::lang(1025));
        }
    }

    public function delTable($TablePre, $TableArr){ //删除插件数据表
        $Tables = $this->SysObj->query('SHOW TABLES', array());
        $DBConfig = Config::DbConfig();
        $HaveTableArr = array_column($Tables, 'Tables_in_'.$DBConfig['Name']);
        foreach($TableArr as $k => $v){
            $TableName = strtolower($TablePre.$k);
            if(!in_array($TableName, $HaveTableArr)) continue;
            $TableSql = 'DROP TABLE IF EXISTS '.$TableName.';';
            if($this->SysObj->exec($TableSql, array()) === false) throw new PDOException(self::lang(1029));
        }
    }

    public function lang($LangCode){ //代码转文字
        return isset($this->LanguageArr[$LangCode]) ? $this->LanguageArr[$LangCode] : $this->LanguageArr[1889];
    }

    private function _getUpdate(){
        $pTime = $this->CookieObj->get('UpdateTs', 'User');
        if(empty($pTime) || time() - $pTime > 3600){
            $Ret = self::getVerUpdate();
            $IsUpdate = empty($Ret['Data']) ? 2 : 1;
            $this->CookieObj->set(array('UpdateTs' => time(), 'IsUpdate' => $IsUpdate), 'User');
        }
    }

    private function _postKey(){
        $pTime = $this->CookieObj->get('Ts', 'User');
        if(empty($pTime) || time() - $pTime > 3600){
            $key = self::getKey();
            $this->CurlObj->SetUrl($this->PlatformUrl.'client/updata.html')->SetPara(array('Key' => $key, 'Domain' => $_SERVER['REQUEST_SCHEME'].'://'.URL_DOMAIN.'/'))->SetIsPost(true)->SetIsHttps(true)->SetIsJson(true)->Execute();
            $this->CookieObj->set(array('Ts' => time()), 'User');
        }

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

class ControllersApi extends Base {
    public $PostData = array();
    public $ModelKv = array();
    function __construct(){
        parent::__construct();
        $this->SysRs = $this->SysObj->getKv();
        $ModelArr = $this->Sys_modelObj->getList();
        foreach($ModelArr as $v){
            $this->ModelKv[$v['KeyName']] = $v;
        }
    }
}

class ControllersPlugAdmin extends ControllersAdmin {

    public function __construct(){
        parent::__construct();
        $this->BuildObj->Module = 'Plugin/'.Router::$s_PlusKeyName;
    }
}

class ControllersPlug extends Base {
    public function __construct(){
        parent::__construct();
        $this->BuildObj->Module = 'Plugin/'.Router::$s_PlusKeyName;
    }
}

class ControllersInstall extends Base {

    public function __construct(){
        $this->CodeObj = \Helper\Code::get_instance();
        $this->BuildObj = \Helper\Build::get_instance();
        $this->CookieObj = \Helper\Cookie::get_instance();
        $this->CurlObj = \Helper\CurlQ::get_instance();
        $this->VeriObj = \Helper\Veri::get_instance();
        $this->CommonObj = \Helper\Common::get_instance();
        $this->UploadObj = \Helper\Upload::get_instance();
        $this->LanguageArr = require_once PATH_LIB .'Language/Cn/Error'.EXTEND;
    }

}
?>