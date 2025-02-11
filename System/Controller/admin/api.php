<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Api extends ControllersAdmin {

    public function ajaxBind_Action(){
        if(!$this->VeriObj->VeriPara($_POST, array('Phone', 'Pwd'))) $this->ApiErr(1001, '缺少参数');
        $Ret = $this->loginPlatform(trim($_POST['Phone']), $_POST['Pwd']);
        if($Ret['Code'] != 0) $this->ApiErr(1000, $Ret['Msg'].'('.$Ret['Code'].')');
        $Result = $this->SysObj->SetCond(array('Name' => 'BindPhone'))->SetUpdate(array('AttrValue' => trim($_POST['Phone'])))->ExecUpdate();
        if($Result === false) $this->Err(1002);
        $this->SysObj->cleanList();
        $this->ApiSuccess();
    }
    
    public function ajaxUnBind_Action(){
        $Result = $this->SysObj->SetCond(array('Name' => 'BindPhone'))->SetUpdate(array('AttrValue' => ''))->ExecUpdate();
        if($Result === false) $this->Err(1002);
        $this->SysObj->cleanList();
        $this->ApiSuccess();
    }
    
    public function ajaxUpload_Action(){
        //$Ret = $this->UploadObj->upload_file($_FILES['filedata']);
        $Ret = self::p_upload($_FILES['filedata']);
        if($Ret['Code'] != 0) {
            $this->CommonObj->ApiErr($Ret['Code'], $Ret['Msg']);
        }
        $ext = substr ( strrchr ( $_FILES['filedata'] ['name'], '.' ), 1 );
        $this->FileObj->SetInsert(array(
            'UserId' => $this->LoginUserRs['UserId'],
            'Name' => $_FILES['filedata']['name'],
            'Img' => $Ret['Url'],
            'Size' => $_FILES['filedata']['size'],
            'Ext' => $ext,
            'Ts' => time(),
        ))->ExecInsert();
        $this->CommonObj->ApiSuccess($Ret['Url']);
    }

    public function ckUpload_Action(){
        $msg = array();
        //$Ret = $this->UploadObj->upload_file($_FILES['upload']);
        $Ret = self::p_upload($_FILES['upload']);
        if($Ret['Code'] != 0) {
            $msg['uploaded'] = false;
            $msg['error'] = array('message' => $Ret['Msg']);
            $msg['url'] = '';
            echo json_encode($msg);exit;
        }
        $ext = substr ( strrchr ( $_FILES['upload'] ['name'], '.' ), 1 );
        $this->FileObj->SetInsert(array(
            'UserId' => $this->LoginUserRs['UserId'],
            'Name' => $_FILES['upload']['name'],
            'Img' => $Ret['Url'],
            'Size' => $_FILES['upload']['size'],
            'Ext' => $ext,
            'Ts' => time(),
        ))->ExecInsert();

        $msg['uploaded'] = true;
        $msg['error'] = array('message' => 'no error');
        $msg['url'] = $Ret['Url'];
        echo json_encode($msg);
    }

    public function fileBrowse_Action(){
        //if(!$this->VeriObj->VeriPara($_POST, array('Path'))) $this->ApiErr(1001);
        $Path = empty($_POST['Path']) ? '' : $_POST['Path'].'/';
        $Files = scandir(PATH_STATIC.'upload/'.$Path);
        $Folder = array();
        foreach($Files as $v){
            if(in_array($v, array('.', '..'))) continue;
            $Type = is_dir(PATH_STATIC.'upload/'.$Path.$v) ? 'folder' : 'file';
            if($Type == 'file'){
                $ext = substr ( strrchr ( $v, '.' ), 1 );
                if($ext == 'html') continue;
            }

            $Folder[] = array('Name' => $v, 'Type' => $Type, 'Path' => URL_STATIC.'upload/'.$Path.$v);
        }
        $this->ApiSuccess($Folder);
    }

    public function fileClean_Action(){
        $Arr = $this->FileObj->SetCond(array('IsDel' => 1))->ExecSelect();
        try{
            DB::$s_db_obj->beginTransaction();
            $this->FileObj->SetCond(array('FileId' => array_column($Arr, 'FileId')))->ExecDelete();
            foreach($Arr as $v){
                $FilePath = realpath(substr($v['Img'], 1));
                if(!file_exists($FilePath)) continue;
                if(!@unlink($FilePath)) throw new PDOException('删除文件失败');
            }
            DB::$s_db_obj->commit();
        }catch(PDOException $e){
            DB::$s_db_obj->rollBack();
            $this->ApiErr(1002);
        }
        $this->ApiSuccess();
    }

    public function fileDel_Action(){
        if(!$this->VeriObj->VeriPara($_POST, array('Ids'))) $this->ApiErr(1001);
        $Ids = explode('|', $_POST['Ids']);
        $Arr = $this->FileObj->SetCond(array('FileId' => $Ids))->ExecSelect();
        try{
            DB::$s_db_obj->beginTransaction();
            $this->FileObj->SetCond(array('FileId' => $Ids))->ExecDelete();
            foreach($Arr as $v){
                $FilePath = realpath(substr($v['Img'], 1));
                if(file_exists($FilePath)){
                    if(!@unlink($FilePath)) throw new PDOException('删除文件失败');
                }
            }
            DB::$s_db_obj->commit();
        }catch(PDOException $e){
            DB::$s_db_obj->rollBack();
            $this->ApiErr(1002);
        }
        $this->ApiSuccess();
    }

    public function userState_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id', 'Status', 'Field'))) $this->ApiErr(1001);
        $DataArr = array($_GET['Field'] => $_GET['Status']);
        if($_GET['Id'] == $this->LoginUserRs['UserId']) $this->ApiErr(1047);
        $Ret = $this->UserObj->SetCond(array('UserId' => $_GET['Id']))->SetUpdate($DataArr)->ExecUpdate();
        if($Ret === false) $this->Err(1002);
        $this->UserObj->clean($_GET['Id']);
        $this->CommonObj->ApiSuccess();
    }

    public function linkState_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id', 'Status', 'Field'))) $this->ApiErr(1001);
        $DataArr = array($_GET['Field'] => $_GET['Status']);
        $Ret = $this->LinkObj->SetCond(array('LinkId' => $_GET['Id']))->SetUpdate($DataArr)->ExecUpdate();
        if($Ret === false) $this->Err(1002);
        $this->LinkObj->clean($_GET['Id']);
        $this->CommonObj->ApiSuccess();
    }

    public function pageState_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id', 'Status', 'Field'))) $this->ApiErr(1001);
        $DataArr = array($_GET['Field'] => $_GET['Status']);
        $Ret = $this->PageObj->SetCond(array('PageId' => $_GET['Id']))->SetUpdate($DataArr)->ExecUpdate();
        if($Ret === false) $this->Err(1002);
        $this->PageObj->clean($_GET['Id']);
        $this->CommonObj->ApiSuccess();
    }

    public function labelState_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id', 'Status', 'Field'))) $this->ApiErr(1001);
        $DataArr = array($_GET['Field'] => $_GET['Status']);
        $Rs = $this->LabelObj->SetCond(array('LabelId' => $_GET['Id']))->ExecSelectOne();
        $Ret = $this->LabelObj->SetCond(array('LabelId' => $_GET['Id']))->SetUpdate($DataArr)->ExecUpdate();
        if($Ret === false) $this->Err(1002);
        $this->LabelObj->clean($Rs['KeyName']);
        $this->CommonObj->ApiSuccess();
    }

    public function formState_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id', 'Status', 'Field'))) $this->ApiErr(1001);
        $DataArr = array($_GET['Field'] => $_GET['Status']);
        $Rs = $this->Sys_formObj->SetCond(array('FormId' => $_GET['Id']))->ExecSelectOne();
        $Ret = $this->Sys_formObj->SetCond(array('FormId' => $_GET['Id']))->SetUpdate($DataArr)->ExecUpdate();
        if($Ret === false) $this->Err(1002);
        $this->Sys_formObj->clean($Rs['KeyName']);
        $this->CommonObj->ApiSuccess();
    }

    public function formDataState_Action($FormId = 0){
        if(empty($FormId)) $this->ApiErr(1001);
        if(!$this->VeriObj->VeriPara($_GET, array('Id', 'Status', 'Field'))) $this->ApiErr(1001);
        $FormRs = $this->Sys_formObj->SetCond(array('FormId' => $FormId))->ExecSelectOne();
        if(empty($FormRs))  $this->ApiErr(1003);
        $DataArr = array($_GET['Field'] => $_GET['Status']);
        $Ret = $this->Sys_formObj->SetTbName('form_'.$FormRs['KeyName'])->SetCond(array('FormListId' => $_GET['Id']))->SetUpdate($DataArr)->ExecUpdate();
        if($Ret === false) $this->Err(1002);
        $this->CommonObj->ApiSuccess();
    }

    public function inlinkState_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id', 'Status', 'Field'))) $this->ApiErr(1001);
        $DataArr = array($_GET['Field'] => $_GET['Status']);
        $Ret = $this->InlinkObj->SetCond(array('InlinkId' => $_GET['Id']))->SetUpdate($DataArr)->ExecUpdate();
        if($Ret === false) $this->Err(1002);
        $this->InlinkObj->cleanList();
        $this->CommonObj->ApiSuccess();
    }

    public function tableField_Action(){ //获取表字段
        if(!$this->VeriObj->VeriPara($_POST, array('TableName'))) $this->ApiErr(1001);
        $FieldArr = $this->SysObj->query('SHOW FULL COLUMNS FROM '.$_POST['TableName'], array());
        $this->ApiSuccess($FieldArr);
    }

    public function contentStateOne_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id', 'Status', 'Field'))) $this->ApiErr(1001);
        $DataArr = array($_GET['Field'] => $_GET['Status']);
        $TableRs = $this->TableObj->SetCond(array('Id' => $_GET['Id']))->ExecSelectOne();        
        $ModelRs = $this->Sys_modelObj->getOne($TableRs['ModelId']);
        $Ret = $this->TableObj->SetTbName('table_'.$ModelRs['KeyName'])->SetCond(array('Id' => $_GET['Id']))->SetUpdate($DataArr)->ExecUpdate();
        if($Ret === false) $this->ApiErr(1002);
        $this->ApiSuccess();
    }
    
    public function contentState_Action(){ // 批量发布内容
        if(!$this->VeriObj->VeriPara($_POST, array('Ids', 'Key', 'Val'))) $this->ApiErr(1001);
        if(!in_array($_POST['Key'], array('State', 'IsSpuerRec', 'IsHeadlines', 'IsRec', 'IsDelete'))) $this->ApiErr(1001);
        $Ids = explode(',', $_POST['Ids']);

        $TableRs = $this->TableObj->SetCond(array('Id' => $Ids[0]))->ExecSelectOne();
        $ModelRs = $this->Sys_modelObj->getOne($TableRs['ModelId']);

        $Ret = $this->TableObj->SetTbName('table_'.$ModelRs['KeyName'])->SetCond(array('Id' => $Ids))->SetUpdate(array($_POST['Key'] => $_POST['Val']))->ExecUpdate();
        if($Ret === false) $this->ApiErr(1002);
        $this->ApiSuccess();
    }

    public function contentAttr_Action(){ //批量设置属性
        if(!$this->VeriObj->VeriPara($_POST, array('Ids', 'Attrs', 'Val'))) $this->ApiErr(1001);
        $AllowArr = array('IsSpuerRec', 'IsHeadlines', 'IsRec', 'IsBold');
        $NameArr = explode(',', $_POST['Attrs']);
        $Ids = explode(',', $_POST['Ids']);
        $UpdateArr = array();
        foreach($NameArr as $v){
            if(!in_array($v, $AllowArr)) continue;
            $UpdateArr[$v] = intval($_POST['Val']);
        }
        $TableRs = $this->TableObj->SetCond(array('Id' => $Ids[0]))->ExecSelectOne();
        $ModelRs = $this->Sys_modelObj->getOne($TableRs['ModelId']);

        $Ret = $this->TableObj->SetTbName('table_'.$ModelRs['KeyName'])->SetCond(array('Id' => $Ids))->SetUpdate($UpdateArr)->ExecUpdate();
        if($Ret === false) $this->ApiErr(1002);
        $this->ApiSuccess();
    }

    public function contentMove_Action(){ //移动内容
        if(!$this->VeriObj->VeriPara($_POST, array('Ids', 'CateId', 'ModelId'))) $this->ApiErr(1001);
        $Ids = explode(',', $_POST['Ids']);
        $ModelRs = $this->Sys_modelObj->getOne($_POST['ModelId']);
        $Ret = $this->TableObj->SetTbName('table_'.$ModelRs['KeyName'])->SetCond(array('Id' => $Ids))->SetUpdate(array('CateId' => $_POST['CateId']))->ExecUpdate();
        if($Ret === false) $this->ApiErr(1002);
        $this->ApiSuccess();
    }

    public function deleteRec_Action(){ // 彻底删除
        if(!$this->VeriObj->VeriPara($_POST, array('Ids'))) $this->ApiErr(1001);
        $Ids = explode(',', $_POST['Ids']);
        $TableRs = $this->TableObj->SetCond(array('Id' => $Ids[0]))->ExecSelectOne();
        $ModelRs = $this->Sys_modelObj->getOne($TableRs['ModelId']);
        try{
            DB::$s_db_obj->beginTransaction();
            $this->TableObj->SetTbName('table_'.$ModelRs['KeyName'])->SetCond(array('Id' => $Ids))->ExecDelete();
            $this->TableObj->SetCond(array('Id' => $Ids))->ExecDelete();
            if($ModelRs['KeyName'] == 'album'){ //相册表删除
                $this->PhotosObj->SetCond(array('Id' => $Ids))->ExecDelete();
            }
            $this->FileObj->SetCond(array('FType' => 2, 'IndexId' => $Ids))->SetUpdate(array('IsDel' => 1))->ExecUpdate();

            DB::$s_db_obj->commit();
        }catch (PDOException $e){
            DB::$s_db_obj->rollBack();
            $this->ApiErr(1002);
        }
        $this->ApiSuccess();
    }

    public function installTemplate_Action(){ // 安装模版
        if(!$this->VeriObj->VeriPara($_GET, array('TemplatesId'))) $this->ApiErr(1001);
        $Ret = $this->apiRemotePlatform('apiRemote/templateInfo', array('TemplatesId' => $_GET['TemplatesId']));
        if($Ret['Code'] != 0) $this->ApiErr(1000, $Ret['Msg']); // 获取模版信息错误       
        $FileName = 'QCms_'.$Ret['Data']['NameKey'].'_template.zip';
        $Path = './Static/tmp/';
        $CmsUpdatePath = $Path.'QCms_'.$Ret['Data']['NameKey'].'_template';
        if(!file_exists($Path.$FileName)){ // 本地没有就下载
            $DownRet = file_get_contents(trim($Ret['Data']['Address']));
            if($DownRet === false) $this->ApiErr(1016);            
            $WriteRet = @file_put_contents($Path.$FileName, $DownRet);
            if($WriteRet === false) $this->ApiErr(1017);        
        }
        
        $UnZipRet = $this->CommonObj->UnZip($Path.$FileName, $CmsUpdatePath); // 解压并把文件COPY到对应目录
        if($UnZipRet === false) $this->ApiErr(1018); 
        $CopyRet = $this->CommonObj->DirCopy($CmsUpdatePath.'/Template', './Template');
        $CopyRet2 = $this->CommonObj->DirCopy($CmsUpdatePath.'/Static', './Static');
        if(file_exists($CmsUpdatePath.'/Root')){ // 特殊上传文件
            $this->CommonObj->DirCopy($CmsUpdatePath.'/Root', './');
        }
        if($CopyRet === false || $CopyRet2 === false) $this->ApiErr(1019);
        
        $DbConfig = Config::DbConfig();
        $InitPath = $CmsUpdatePath.'/Data/init.json'; // 数据结构字段增加（模型字段添加）
        if(file_exists($InitPath)){ 
            $Json = file_get_contents($InitPath);
            $JsonArr = empty($Json) ? array() : json_decode($Json, true);
            try{
                DB::$s_db_obj->beginTransaction();
                foreach($JsonArr as $k => $v){
                    if($v['IsSys'] != 1){ // 非系统内置，创建表
                        $this->Sys_modelObj->CreateTable($k);
                    }
                    foreach($v['FieldJson'] as $sv){
                        list($FieldType, $FieldDefault) = $this->Sys_modelObj->GetField($sv['Type']);
                        $AddField = array('Name' => $sv['Name'], 'Comment' => $sv['Comment'], 'Type' => $sv['Type'], 'Content' => $sv['Content'], 'NotNull' => $sv['NotNull'], 'IsList' => $sv['IsList'], 'Data' => $sv['Data']);
                        $this->Sys_modelObj->exec('alter table `'.$DbConfig['Prefix'].'table_'.$v['KeyName'].'` add '.$AddField['Name'].' '.$FieldType.' not null '.$FieldDefault.' COMMENT "'.$AddField['Comment'].'";', array());
                    }
                }
                DB::$s_db_obj->commit();
            }catch(PDOException $e){
                DB::$s_db_obj->rollBack();
                $this->ApiErr(1002);
            }
            
        }
        $SqlPath = $CmsUpdatePath.'/Data/data.sql'; // 刷新数据库数据
        if(file_exists($SqlPath)){
            try{
                DB::$s_db_obj->beginTransaction();
                $this->SysObj->ImportSql($SqlPath);
                $this->SysObj->SetCond(array('Name' => 'TmpPath'))->SetUpdate(array('AttrValue' => $Ret['Data']['NameKey']))->ExecUpdate();
                $PathMobileUpdate = file_exists('./Template/'.$Ret['Data']['NameKey'].'_mobile') ? array('AttrValue' => $Ret['Data']['NameKey'].'_mobile') : array('AttrValue' => '');
                $this->SysObj->SetCond(array('Name' => 'TmpPathMobile'))->SetUpdate($PathMobileUpdate)->ExecUpdate();
                DB::$s_db_obj->commit();
            }catch (PDOException $e){
                DB::$s_db_obj->rollBack();
                $this->ApiErr(1002);
            }
            $this->SysObj->cleanList();
        }
        $this->ApiSuccess();
    }
    
    public function paytp_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('TemplatesId'))) $this->ApiErr(1001);
        $Ret = $this->apiRemotePlatform('apiRemote/paytp', array('TemplatesId' => $_GET['TemplatesId']));
        if($Ret['Code'] != 0) $this->ApiErr(1000, $Ret['Msg']); // 获取模版信息错误       
        $this->ApiSuccess($Ret['Data']);
    }
    
    public function payStatus_Action(){
        if(!$this->VeriObj->VeriPara($_POST, array('OrderId'))) $this->ApiErr(1001);
        $Ret = $this->apiRemotePlatform('apiRemote/payStatus', array('OrderId' => $_POST['OrderId']));
        if($Ret['Code'] != 0) $this->ApiErr(1000, $Ret['Msg']); // 获取模版信息错误
        $this->ApiSuccess($Ret['Data']);
    }

    public function sort_Action(){ // 排序
        if(!$this->VeriObj->VeriPara($_POST, array('Index', 'Type', 'Sort'))) $this->ApiErr(1001);
        if($_POST['Type'] == 'category'){
            $Ret = $this->CategoryObj->SetCond(array('CateId' => $_POST['Index']))->SetUpdate(array('Sort' => intval($_POST['Sort'])))->ExecUpdate();
            if($Ret === false) $this->ApiErr(1002);
            $this->CategoryObj->cleanList();
            $this->CategoryObj->clean($_POST['Index']);
            $this->ApiSuccess();
        }elseif($_POST['Type'] == 'pageCate'){
            $Ret = $this->Page_cateObj->SetCond(array('PageCateId' => $_POST['Index']))->SetUpdate(array('Sort' => intval($_POST['Sort'])))->ExecUpdate();
            if($Ret === false) $this->ApiErr(1002);
            $this->Page_cateObj->cleanList();
            $this->ApiSuccess();
        }elseif($_POST['Type'] == 'page'){
            $Ret = $this->PageObj->SetCond(array('PageId' => $_POST['Index']))->SetUpdate(array('Sort' => intval($_POST['Sort'])))->ExecUpdate();
            if($Ret === false) $this->ApiErr(1002);
            $this->ApiSuccess();
        }elseif($_POST['Type'] == 'form'){
            $Ret = $this->Sys_formObj->SetCond(array('FormId' => $_POST['Index']))->SetUpdate(array('Sort' => intval($_POST['Sort'])))->ExecUpdate();
            if($Ret === false) $this->ApiErr(1002);
            $this->ApiSuccess();
        }elseif($_POST['Type'] == 'labelCate'){
            $Ret = $this->Label_cateObj->SetCond(array('LabelCateId' => $_POST['Index']))->SetUpdate(array('Sort' => intval($_POST['Sort'])))->ExecUpdate();
            if($Ret === false) $this->ApiErr(1002);
            $this->Label_cateObj->cleanList();
            $this->ApiSuccess();
        }elseif($_POST['Type'] == 'label'){
            $Rs = $this->LabelObj->SetCond(array('LabelId' => $_POST['Index']))->ExecSelectOne();
            $Ret = $this->LabelObj->SetCond(array('LabelId' => $_POST['Index']))->SetUpdate(array('Sort' => intval($_POST['Sort'])))->ExecUpdate();
            if($Ret === false) $this->ApiErr(1002);
            $this->LabelObj->clean($Rs['KeyName']);
            $this->ApiSuccess();
        }elseif($_POST['Type'] == 'linkCate'){
            $Ret = $this->Link_cateObj->SetCond(array('LinkCateId' => $_POST['Index']))->SetUpdate(array('Sort' => intval($_POST['Sort'])))->ExecUpdate();
            if($Ret === false) $this->ApiErr(1002);
            $this->Link_cateObj->cleanList();
            $this->ApiSuccess();
        }elseif($_POST['Type'] == 'link'){
            $Ret = $this->LinkObj->SetCond(array('LinkId' => $_POST['Index']))->SetUpdate(array('Sort' => intval($_POST['Sort'])))->ExecUpdate();
            if($Ret === false) $this->ApiErr(1002);
            $this->LinkObj->clean($_POST['Index']);
            $this->ApiSuccess();
        }elseif($_POST['Type'] == 'inlinkCate'){
            $Ret = $this->Inlink_cateObj->SetCond(array('InLinkCateId' => $_POST['Index']))->SetUpdate(array('Sort' => intval($_POST['Sort'])))->ExecUpdate();
            if($Ret === false) $this->ApiErr(1002);
            $this->Inlink_cateObj->cleanList();
            $this->ApiSuccess();
        }elseif($_POST['Type'] == 'inlink'){
            $Ret = $this->InlinkObj->SetCond(array('InLinkId' => $_POST['Index']))->SetUpdate(array('Sort' => intval($_POST['Sort'])))->ExecUpdate();
            if($Ret === false) $this->ApiErr(1002);
            $this->InlinkObj->cleanList();
            $this->ApiSuccess();
        }elseif($_POST['Type'] == 'swiperCate'){
            $Ret = $this->Swiper_cateObj->SetCond(array('SwiperCateId' => $_POST['Index']))->SetUpdate(array('Sort' => intval($_POST['Sort'])))->ExecUpdate();
            if($Ret === false) $this->ApiErr(1002);
            $this->ApiSuccess();
        }elseif($_POST['Type'] == 'swiper'){
            $Ret = $this->SwiperObj->SetCond(array('SwiperId' => $_POST['Index']))->SetUpdate(array('Sort' => intval($_POST['Sort'])))->ExecUpdate();
            if($Ret === false) $this->ApiErr(1002);
            $this->SwiperObj->clean($Rs['SwiperId']);
            $this->ApiSuccess();
        }elseif($_POST['Type'] == 'site'){
            $Ret = $this->SiteObj->SetCond(array('SiteId' => $_POST['Index']))->SetUpdate(array('Sort' => intval($_POST['Sort'])))->ExecUpdate();
            if($Ret === false) $this->ApiErr(1002);
            $this->SiteObj->cleanList();
            $this->ApiSuccess();
        }elseif($_POST['Type'] == 'sys'){
            $Ret = $this->SysObj->SetCond(array('Name' => $_POST['Index']))->SetUpdate(array('Sort' => intval($_POST['Sort'])))->ExecUpdate();
            if($Ret === false) $this->ApiErr(1002);
            $this->SysObj->clean($_POST['Index']);
            $this->ApiSuccess();
        }

    }



}