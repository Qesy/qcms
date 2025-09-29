<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Api extends ControllersAdmin {

    public function ajaxBind_Action(){
        if(!$this->VeriObj->VeriPara($_POST, array('Phone', 'Pwd'))) $this->ApiErr(1001, '缺少参数');
        $Ret = $this->loginPlatform(trim($_POST['Phone']), $_POST['Pwd']);
        if($Ret['Code'] != 0) $this->ApiErr(1000, $Ret['Msg'].'('.$Ret['Code'].')');
        $Result = $this->SysObj->SetCond(array('Name' => 'BindPhone'))->SetUpdate(array('AttrValue' => $this->CommonObj->SafeInput(trim($_POST['Phone']))))->ExecUpdate();
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
        $DataArr = array($_GET['Field'] => $this->CommonObj->SafeInput($_GET['Status']));
        if($_GET['Id'] == $this->LoginUserRs['UserId']) $this->ApiErr(1047);
        $Ret = $this->UserObj->SetCond(array('UserId' => $_GET['Id']))->SetUpdate($DataArr)->ExecUpdate();
        if($Ret === false) $this->Err(1002);
        $this->UserObj->clean($_GET['Id']);
        $this->CommonObj->ApiSuccess();
    }

    public function linkState_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id', 'Status', 'Field'))) $this->ApiErr(1001);
        $DataArr = array($_GET['Field'] => $this->CommonObj->SafeInput($_GET['Status']));
        $Ret = $this->LinkObj->SetCond(array('LinkId' => $_GET['Id']))->SetUpdate($DataArr)->ExecUpdate();
        if($Ret === false) $this->Err(1002);
        $this->LinkObj->clean($_GET['Id']);
        $this->CommonObj->ApiSuccess();
    }

    public function pageState_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id', 'Status', 'Field'))) $this->ApiErr(1001);
        $DataArr = array($_GET['Field'] => $this->CommonObj->SafeInput($_GET['Status']));
        $Ret = $this->PageObj->SetCond(array('PageId' => $_GET['Id']))->SetUpdate($DataArr)->ExecUpdate();
        if($Ret === false) $this->Err(1002);
        $this->PageObj->clean($_GET['Id']);
        $this->CommonObj->ApiSuccess();
    }

    public function labelState_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id', 'Status', 'Field'))) $this->ApiErr(1001);
        $DataArr = array($_GET['Field'] => $this->CommonObj->SafeInput($_GET['Status']));
        $Rs = $this->LabelObj->SetCond(array('LabelId' => $_GET['Id']))->ExecSelectOne();
        $Ret = $this->LabelObj->SetCond(array('LabelId' => $_GET['Id']))->SetUpdate($DataArr)->ExecUpdate();
        if($Ret === false) $this->Err(1002);
        $this->LabelObj->clean($Rs['KeyName']);
        $this->CommonObj->ApiSuccess();
    }

    public function formState_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id', 'Status', 'Field'))) $this->ApiErr(1001);
        $DataArr = array($_GET['Field'] => $this->CommonObj->SafeInput($_GET['Status']));
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
        $DataArr = array($_GET['Field'] => $this->CommonObj->SafeInput($_GET['Status']));
        $Ret = $this->Sys_formObj->SetTbName('form_'.$FormRs['KeyName'])->SetCond(array('FormListId' => $_GET['Id']))->SetUpdate($DataArr)->ExecUpdate();
        if($Ret === false) $this->Err(1002);
        $this->CommonObj->ApiSuccess();
    }

    public function inlinkState_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('Id', 'Status', 'Field'))) $this->ApiErr(1001);
        $DataArr = array($_GET['Field'] => $this->CommonObj->SafeInput($_GET['Status']));
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
        $DataArr = array($_GET['Field'] => $this->CommonObj->SafeInput($_GET['Status']));
        $TableRs = $this->TableObj->SetCond(array('Id' => $_GET['Id']))->ExecSelectOne();
        $ModelRs = $this->Sys_modelObj->getOne($TableRs['ModelId']);
        $Ret = $this->TableObj->SetTbName('table_'.$ModelRs['KeyName'])->SetCond(array('Id' => $_GET['Id']))->SetUpdate($DataArr)->ExecUpdate();
        if($Ret === false) $this->ApiErr(1002);
        $this->ApiSuccess();
    }

    public function contentState_Action(){ // 批量发布内容
        if(!$this->VeriObj->VeriPara($_POST, array('Ids', 'Key', 'Val'))) $this->ApiErr(1001);
        if(!in_array($_POST['Key'], array('State', 'IsDelete'))) $this->ApiErr(1001);
        $Ids = explode(',', $_POST['Ids']);

        $TableRs = $this->TableObj->SetCond(array('Id' => $Ids[0]))->ExecSelectOne();
        $ModelRs = $this->Sys_modelObj->getOne($TableRs['ModelId']);
        try{
            DB::$s_db_obj->beginTransaction();
            $this->TableObj->SetTbName('table_'.$ModelRs['KeyName'])->SetCond(array('Id' => $Ids))->SetUpdate(array($_POST['Key'] => $this->CommonObj->SafeInput($_POST['Val'])))->ExecUpdate();
            if($_POST['Key'] == 'IsDelete'){ // 批量删除/恢复设置tag (发布状态不操作Tag)
                $Arr = $this->TableObj->SetTbName('table_'.$ModelRs['KeyName'])->SetCond(array('Id' => $Ids))->SetField('Id, Tag')->ExecSelect();
                foreach ($Arr as $v){ // 批量设置TAG
                    if($_POST['Val'] == 1){ // 删除
                        $this->TagObj->DeleteTag($v['Id']);
                    }else{
                        $this->TagObj->RunUpdate($v['Tag'], '', $v['Id'], $TableRs['ModelId']);
                    }
                }
            }

            DB::$s_db_obj->commit();
        }catch (PDOException $e){
            DB::$s_db_obj->rollBack();
            $this->ApiErr(1002);
        }
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
        $CateId = intval($_POST['CateId']);
        $CateRs = $this->CategoryObj->getOne($CateId);
        if(empty($CateRs)) $this->ApiErr(1003);
        $Ret = $this->TableObj->SetTbName('table_'.$ModelRs['KeyName'])->SetCond(array('Id' => $Ids))->SetUpdate(array('CateId' => $CateRs['CateId']))->ExecUpdate();
        if($Ret === false) $this->ApiErr(1002);
        $this->ApiSuccess();
    }

    public function deleteRec_Action(){ // 彻底删除
        if(!$this->VeriObj->VeriPara($_POST, array('Ids'))) $this->ApiErr(1001);
        $Ids = explode(',', $_POST['Ids']);
        $TableRs = $this->TableObj->SetCond(array('Id' => $Ids[0]))->ExecSelectOne();
        $ModelRs = $this->Sys_modelObj->getOne($TableRs['ModelId']);
        $Arr = $this->TableObj->SetTbName('table_'.$ModelRs['KeyName'])->SetCond(array('Id' => $Ids, 'IsDelete' => '1'))->SetField('Id, IsDelete')->ExecSelect();
        $Ids = array_column($Arr, 'Id');
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

    public function emptyRec_Action(){ // 清空回收站
        if(!$this->VeriObj->VeriPara($_POST, array('ModelId'))) $this->ApiErr(1001);
        $ModelRs = $this->Sys_modelObj->getOne(trim($_POST['ModelId']));
        if(empty($ModelRs)) $this->ApiErr(1003);
        $Arr = $this->TableObj->SetTbName('table_'.$ModelRs['KeyName'])->SetCond(array('IsDelete' => '1'))->SetField('Id, IsDelete')->ExecSelect();
        $Ids = array_column($Arr, 'Id');
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


    public function templateInstall_Action(){ // 安装模版、只能安装不能升级(从模版市场安装)
        if(!$this->VeriObj->VeriPara($_GET, array('TemplatesId', 'Version'))) $this->ApiErr(1001);

        // 判断模版是否已安装
        $IsInstalled = $this->TemplatesObj->SetCond(array('TemplatesId' => trim($_GET['TemplatesId'])))->ExecSelectOne();
        if(!empty($IsInstalled)){ // 模版已安装过
            $this->ApiErr(1057);
        }

        // 获取模版信息
        $IsDev = empty($_GET['IsDev']) ? 2 : trim($_GET['IsDev']);
        $Params = array('TemplatesId' => trim($_GET['TemplatesId']), 'Version' => trim($_GET['Version']), 'IsDev' => $IsDev); // 默认安装最新版本
        $Ret = $this->apiRemotePlatform('apiRemote/templateInfo', $Params);
        if($Ret['Code'] != 0) $this->ApiErr(1000, $Ret['Msg']); // 获取模版信息错误

        // 保存模版
        $FileName = 'QCms_'.$Ret['Data']['NameKey'].'_'.$Ret['Data']['Version'].'_template.zip';
        $Path = './Static/tmp/';
        $CmsUpdatePath = $Path.'QCms_'.$Ret['Data']['NameKey'].'_'.$Ret['Data']['Version'].'_template';
        if(!file_exists($Path.$FileName)){ // 本地没有就下载 (改为一律下载)
            $DownRet = file_get_contents(trim($Ret['Data']['Address']));
            if($DownRet === false) $this->ApiErr(1016);
            $WriteRet = @file_put_contents($Path.$FileName, $DownRet);
            if($WriteRet === false) $this->ApiErr(1017);
        }

        $UnZipRet = $this->CommonObj->UnZip($Path.$FileName, $CmsUpdatePath); // 解压并把文件COPY到对应目录
        if($UnZipRet === false) $this->ApiErr(1018);
        $CopyRet = $this->CommonObj->DirCopy($CmsUpdatePath.'/Template', './Template');
        $CopyRet2 = $this->CommonObj->DirCopy($CmsUpdatePath.'/Static', './Static/templates');
        if(file_exists($CmsUpdatePath.'/Root')){ // 特殊上传文件
            $this->CommonObj->DirCopy($CmsUpdatePath.'/Root', './');
        }
        if($CopyRet === false || $CopyRet2 === false) $this->ApiErr(1019);

        // 安装模版数据库操作
        $DbConfig = Config::DbConfig();
        $InitPath = $CmsUpdatePath.'/Data/init.json'; // 数据结构字段增加（模型字段添加）
        $Ts = time();
        try{
            DB::$s_db_obj->beginTransaction();
            // 插入安装模版记录
            $InsertMap = array(
                'TemplatesId' => $Ret['Data']['TemplatesId'],
                'NameKey' => $Ret['Data']['NameKey'],
                'Version' => $Ret['Data']['Version'],
                'TsAdd' => $Ts,
                'TsUpdate' => $Ts,
            );
            $this->TemplatesObj->SetInsert($InsertMap)->ExecReplace();

            // 设置为使用当前模版
            $this->SysObj->SetCond(array('Name' => 'TmpPath'))->SetUpdate(array('AttrValue' => $Ret['Data']['NameKey']))->ExecUpdate();
            $PathMobileUpdate = file_exists('./Template/'.$Ret['Data']['NameKey'].'_mobile') ? array('AttrValue' => $Ret['Data']['NameKey'].'_mobile') : array('AttrValue' => '');
            $this->SysObj->SetCond(array('Name' => 'TmpPathMobile'))->SetUpdate($PathMobileUpdate)->ExecUpdate();

            // 创建数据表和字段
            if(file_exists($InitPath)){
                $Json = file_get_contents($InitPath);
                $JsonArr = empty($Json) ? array() : json_decode($Json, true);

                foreach($JsonArr as $k => $v){
                    // 非系统内置：创建表+增加字段

                    if($v['IsSys'] != 1){
                        // 添加模型表&字段
                        $FieldArr = array();
                        foreach($v['FieldJson'] as $sv){
                            $FieldArr[] = array('Name' => $sv['Name'], 'Comment' => $sv['Comment'], 'Type' => $sv['Type'], 'Content' => $sv['Content'], 'NotNull' => $sv['NotNull'], 'IsList' => $sv['IsList'], 'Data' => $sv['Data']);
                        }
                        $this->Sys_modelObj->SetInsert(array('ModelId' => $v['ModelId'], 'KeyName' => $k, 'Name' => $v['Name'], 'IsSys' => '2', 'FieldJson' => json_encode($FieldArr)))->ExecInsert();
                        // 创建自定义表
                        $this->Sys_modelObj->CreateTable($k);
                        // 添加自定义表字段
                        foreach($v['FieldJson'] as $sv){
                            list($FieldType, $FieldDefault) = $this->Sys_modelObj->GetField($sv['Type']);
                            $this->Sys_modelObj->exec('alter table `'.$DbConfig['Prefix'].'table_'.$v['KeyName'].'` add '.$sv['Name'].' '.$FieldType.' not null '.$FieldDefault.' COMMENT "'.$sv['Comment'].'";', array());
                        }
                        continue;
                    }

                    // 系统内置：增加字段
                    $Rs = $this->Sys_modelObj->getOne($v['ModelId']);
                    $FieldArr = empty($Rs['FieldJson']) ? array() : json_decode($Rs['FieldJson'], true);
                    foreach($v['FieldJson'] as $sv){
                        list($FieldType, $FieldDefault) = $this->Sys_modelObj->GetField($sv['Type']);
                        $FieldArr[] = array('Name' => $sv['Name'], 'Comment' => $sv['Comment'], 'Type' => $sv['Type'], 'Content' => $sv['Content'], 'NotNull' => $sv['NotNull'], 'IsList' => $sv['IsList'], 'Data' => $sv['Data']);
                        $this->Sys_modelObj->exec('alter table `'.$DbConfig['Prefix'].'table_'.$v['KeyName'].'` add '.$sv['Name'].' '.$FieldType.' not null '.$FieldDefault.' COMMENT "'.$sv['Comment'].'";', array());
                    }
                    $this->Sys_modelObj->SetCond(array('ModelId' => $v['ModelId']))->SetUpdate(array('FieldJson' => json_encode($FieldArr)))->ExecUpdate();
                }
            }
            DB::$s_db_obj->commit();
        }catch (PDOException $e){
            DB::$s_db_obj->rollBack();
            $this->ApiErr(1002);
        }
        $this->SysObj->cleanList();
        $this->ApiSuccess();
    }

    public function templateUpgrade_Action(){ // 升级模版
        if(!$this->VeriObj->VeriPara($_GET, array('TemplatesId', 'Version'))) $this->ApiErr(1001);

        // 获取模版信息
        $Params = array('TemplatesId' => trim($_GET['TemplatesId']));
        $IsInstalled = $this->TemplatesObj->SetCond($Params)->ExecSelectOne();
        if(!empty($IsInstalled)){ // 模版已安装过
            $this->ApiErr(1057);
        }
        if(!$this->CommonObj->compare_versions($IsInstalled['Version'], trim($_GET['Version']))){
            $this->ApiErr(1058);
        }
        $Params['Version'] = trim($_GET['Version']); // 默认安装最新版本
        $Ret = $this->apiRemotePlatform('apiRemote/templateInfo', $Params);
        if($Ret['Code'] != 0) $this->ApiErr(1000, $Ret['Msg']); // 获取模版信息错误

        // 保存模版
        $FileName = 'QCms_'.$Ret['Data']['NameKey'].'_'.$Ret['Data']['Version'].'_template.zip';
        $Path = './Static/tmp/';
        $CmsUpdatePath = $Path.'QCms_'.$Ret['Data']['NameKey'].'_'.$Ret['Data']['Version'].'_template';
        if(!file_exists($Path.$FileName)){ // 本地没有就下载 (改为一律下载)
            $DownRet = file_get_contents(trim($Ret['Data']['Address']));
            if($DownRet === false) $this->ApiErr(1016);
            $WriteRet = @file_put_contents($Path.$FileName, $DownRet);
            if($WriteRet === false) $this->ApiErr(1017);
        }

        $UnZipRet = $this->CommonObj->UnZip($Path.$FileName, $CmsUpdatePath); // 解压并把文件COPY到对应目录
        if($UnZipRet === false) $this->ApiErr(1018);
        $CopyRet = $this->CommonObj->DirCopy($CmsUpdatePath.'/Template', './Template');
        $CopyRet2 = $this->CommonObj->DirCopy($CmsUpdatePath.'/Static', './Static/templates');
        if(file_exists($CmsUpdatePath.'/Root')){ // 特殊上传文件
            $this->CommonObj->DirCopy($CmsUpdatePath.'/Root', './');
        }
        if($CopyRet === false || $CopyRet2 === false) $this->ApiErr(1019);
        // 升级模版只升级文件，不操作数据库
        $this->ApiSuccess();
    }

    public function templateInstallData_Action(){ // 安装模版数据
        if(!$this->VeriObj->VeriPara($_GET, array('TemplatesId'))) $this->ApiErr(1001);
        $IsHave = $this->TemplatesObj->SetCond(array('TemplatesId' => trim($_GET['TemplatesId'])))->ExecSelectOne();
        if($this->SysRs['TmpPath'] != $IsHave['NameKey']) $this->ApiErr(1001);
        if(empty($IsHave)) $this->ApiErr(1003);
        $Path = './Static/tmp/';
        $CmsUpdatePath = $Path.'QCms_'.$IsHave['NameKey'].'_'.$IsHave['Version'].'_template';
        $SqlPath = $CmsUpdatePath.'/Data/data.sql'; // 刷新数据库数据
        if(!file_exists($SqlPath)) $this->ApiErr(1035);
        try{
            DB::$s_db_obj->beginTransaction();
            $this->SysObj->ImportSql($SqlPath);

            DB::$s_db_obj->commit();
        }catch (PDOException $e){
            DB::$s_db_obj->rollBack();
            $this->ApiErr(1002);
        }

        $this->ApiSuccess();
    }

    public function templateDelete_Action(){ // 删除模版
        if(!$this->VeriObj->VeriPara($_GET, array('TemplatesId'))) $this->ApiErr(1001);
        $Rs = $this->TemplatesObj->SetCond(array('TemplatesId' => trim($_GET['TemplatesId'])))->ExecSelectOne();
        if(empty($Rs)) $this->ApiErr(1003);
        $DbConfig = Config::DbConfig();
        $Path = './Static/tmp/';
        $CmsUpdatePath = $Path.'QCms_'.$Rs['NameKey'].'_'.$Rs['Version'].'_template';
        $InitPath = $CmsUpdatePath.'/Data/init.json'; // 数据结构字段增加（模型字段添加）
        try{
            DB::$s_db_obj->beginTransaction();
            // 删除模版安装记录
            $this->TemplatesObj->SetCond(array('TemplatesId' => trim($_GET['TemplatesId'])))->ExecDelete();

            // 删除创建的表和字段
            if(file_exists($InitPath)){
                $Json = file_get_contents($InitPath);
                $JsonArr = empty($Json) ? array() : json_decode($Json, true);
                foreach($JsonArr as $k => $v){

                    if($v['IsSys'] != 1){ // 非系统内置，直接删除
                        $this->Sys_modelObj->DeleteTable($k); // 删除表和字段
                        $this->Sys_modelObj->SetCond(array('KeyName' => $k))->ExecDelete(); // 删除字段表
                        continue;
                    }
                    // 删除自定义字段（系统表）
                    foreach($v['FieldJson'] as $sv){
                        $this->Sys_modelObj->exec('alter table `'.$DbConfig['Prefix'].'table_'.$v['KeyName'].'` DROP COLUMN `'.$sv['Name'].'`;', array());
                    }
                    $FieldNames = array_column($v['FieldJson'], 'Name');
                    $SysModelRs = $this->Sys_modelObj->getOne($v['ModelId']);
                    $FieldArr = empty($SysModelRs['FieldJson']) ? array() : json_decode($SysModelRs['FieldJson'], true);
                    foreach($FieldArr as $sk => $sv){
                        if(in_array($sv['Name'], $FieldNames)) unset($FieldArr[$sk]);
                    }
                    $this->Sys_modelObj->SetCond(array('ModelId' => $v['ModelId']))->SetUpdate(array('FieldJson' => json_encode($FieldArr)))->ExecUpdate();
                }
            }

            // 删除模版
            $TempPath = './Template/'.$Rs['NameKey'];
            if(file_exists($TempPath)){
                if ($this->CommonObj->rrmdir($TempPath) === false) throw new PDOException($this->lang(1030));
            }
            $TempPathMobile = './Template/'.$Rs['NameKey'].'_mobile';
            if(file_exists($TempPathMobile)){
                if ($this->CommonObj->rrmdir($TempPathMobile) === false) throw new PDOException($this->lang(1030));
            }
            // 删除静态文件
            $TempPathStatic = './Static/templates/'.$Rs['NameKey'];
            if(file_exists($TempPathStatic)){
                if ($this->CommonObj->rrmdir($TempPathStatic) === false) throw new PDOException($this->lang(1030));
            }
            $TempPathMobileStatic = './Static/templates/'.$Rs['NameKey'].'_mobile';
            if(file_exists($TempPathMobileStatic)){
                if ($this->CommonObj->rrmdir($TempPathMobileStatic) === false) throw new PDOException($this->lang(1030));
            }
            // 删除临时文件
            $Temp = './Static/tmp/QCms_'.$Rs['NameKey'].'_'.$Rs['Version'].'_template';
            if(file_exists($Temp)){
                if ($this->CommonObj->rrmdir($Temp) === false) throw new PDOException($this->lang(1030));
            }
            // 删除压缩包文件
            if(file_exists($Temp.'.zip')){
                if (unlink($Temp.'.zip') === false) throw new PDOException($this->lang(1030));
            }

            DB::$s_db_obj->commit();
        }catch (PDOException $e){
            DB::$s_db_obj->rollBack();
            $this->ApiErr(1002);
        }
        $this->Sys_modelObj->cleanList();
        $this->ApiSuccess();
    }

    public function pluginInstall_Action(){ // 安装插件(从插件市场安装)
        if(!$this->VeriObj->VeriPara($_GET, array('PluginId', 'Version'))) $this->ApiErr(1001);

        // 判断插件是否已安装
        $IsInstalled = $this->PluginObj->SetCond(array('PluginId' => trim($_GET['PluginId'])))->ExecSelectOne();
        if(!empty($IsInstalled)){
            $this->ApiErr(1037);
        }

        // 获取插件信息
        $IsDev = empty($_GET['IsDev']) ? 2 : trim($_GET['IsDev']);
        $Params = array('PluginId' => trim($_GET['PluginId']), 'Version' => trim($_GET['Version']), 'IsDev' => $IsDev);
        $Ret = $this->apiRemotePlatform('apiRemote/pluginInfo', $Params);
        if($Ret['Code'] != 0) $this->ApiErr(1000, $Ret['Msg']);

        // 保存插件
        $FileName = 'QCms_'.$Ret['Data']['NameKey'].'_'.$Ret['Data']['Version'].'_plugin.zip';
        $Path = './Static/tmp/';
        if(!file_exists($Path.$FileName)){ // 本地没有就下载 (改为一律下载)
            $DownRet = file_get_contents(trim($Ret['Data']['Address']));
            if($DownRet === false) $this->ApiErr(1016);
            $WriteRet = @file_put_contents($Path.$FileName, $DownRet);
            if($WriteRet === false) $this->ApiErr(1017);
        }
        $PlugPath = './Plugin/'.$Ret['Data']['NameKey'];
        $UnZipRet = $this->CommonObj->UnZip($Path.$FileName, $PlugPath); // 解压并把文件COPY到对应目录
        if($UnZipRet === false) $this->ApiErr(1018); // 解压压缩包失败
        $CopyRet = $this->CommonObj->DirCopy($PlugPath.'/Static', './Static/plugin/'.$Ret['Data']['NameKey']);
        if($CopyRet === false) $this->ApiErr(1019); // Copy静态文件失败

        // 初始化数据库
        $ConfigMap = require_once $PlugPath.'/Lib/Config.php';
        $SettingMap = array_column($ConfigMap['Form'], 'Value', 'Name');
        $Cron = $ConfigMap['Cron'];
        if(!isset($Cron['CronType'])) $Cron = array('CronType' => '-1', 'Interval' => 0, 'Time' => '00:00:00', 'TsLastCron' => 0);
        require_once $PlugPath.'/Lib/Install.php';
        $InstallObj = new Install();
        if(!method_exists($InstallObj, 'init')) $this->ApiErr(1033);
        if(!method_exists($InstallObj, 'upgrade')) $this->ApiErr(1033);
        $DbConfig = Config::DbConfig();
        $Ts = time();
        try{
            DB::$s_db_obj->beginTransaction();

            // 创建需要的表
            $TablePre = $DbConfig['Prefix'].'plugin_'.$Ret['Data']['NameKey'].'_';
            $this->createTable($TablePre, $ConfigMap['Data'], 1);

            // 插入插件表
            $PluginInsertMap = array(
                'PluginId' => $Ret['Data']['PluginId'],
                'NameKey' => $Ret['Data']['NameKey'],
                'Version' => $Ret['Data']['Version'],
                'State' => '1',
                'TsAdd' => $Ts,
                'TsUpdate' => $Ts,
                'Config' => json_encode($SettingMap),
                'CronType' => $Cron['CronType'],
                'IntervalTime' => $Cron['IntervalTime'],
                'FixedTime' => $Cron['FixedTime'],
                'TsLastCron' => $Cron['TsLastCron'],
            );

            $this->PluginObj->SetInsert($PluginInsertMap)->ExecInsert();

            // 插入菜单

            if(count($ConfigMap['SideBar']) > 0){ //如果没分类就不用插入了
                $this->Menu_sideObj->SetInsert(array( //插入父分类
                    'PId' => 0,
                    'PluginId' => $Ret['Data']['PluginId'],
                    'NameKey' => $Ret['Data']['NameKey'],
                    'Name' => $Ret['Data']['Name'],
                    'Icons' => 'api-app',
                    'Url' => '#', //附件父分类不需要链接
                    'Para' => '{}',
                    'Sort' => '99',
                    'IsShow' => 1,
                ))->ExecInsert();
                $InsertId = $this->Menu_sideObj->last_insert_id();
                foreach($ConfigMap['SideBar'] as $k => $v){
                    $this->Menu_sideObj->SetInsert(array(
                        'PId' => $InsertId,
                        'PluginId' => $Ret['Data']['PluginId'],
                        'NameKey' => $Ret['Data']['NameKey'],
                        'Name' => $v['Name'],
                        'Icons' => '', //附件子分类不需图标
                        'Url' => implode('/', $v['Url']),
                        'Para' => empty($v['Para']) ? '{}' : json_encode($v['Para']),
                        'Sort' => '99',
                        'IsShow' => $v['IsShow'],
                    ))->ExecInsert();
                }
            }
            $InstallObj->init(); //执行安装程序
            DB::$s_db_obj->commit();
        }catch (PDOException $e){
            DB::$s_db_obj->rollBack();
            $this->ApiErr(1002);
        }
        $this->Menu_sideObj->cleanList();
        $this->ApiSuccess();
    }

    public function pluginUpgrade_Action(){ // 升级插件
        if(!$this->VeriObj->VeriPara($_GET, array('PluginId', 'Version'))) $this->ApiErr(1001);

        // 安装测试
        $IsInstalled = $this->PluginObj->SetCond(array('PluginId' => trim($_GET['PluginId'])))->ExecSelectOne();
        if(empty($IsInstalled)) { // 插件未安装
            $this->ApiErr(1026);
        }elseif($IsInstalled['Version'] == trim($_GET['Version'])){ // 判断版本
            $this->ApiErr(1037);
        }

        // 版本比较
        if(!$this->CommonObj->compare_versions($IsInstalled['Version'], trim($_GET['Version']))){
            $this->ApiErr(1058);
        }

        // 获取插件信息
        $Params = array('PluginId' => trim($_GET['PluginId']), 'Version' => trim($_GET['Version']));
        $Ret = $this->apiRemotePlatform('apiRemote/pluginInfo', $Params);
        if($Ret['Code'] != 0) $this->ApiErr(1000, $Ret['Msg']);

        // 保存插件
        $FileName = 'QCms_'.$Ret['Data']['NameKey'].'_'.$Ret['Data']['Version'].'_plugin.zip';
        $Path = './Static/tmp/';
        if(!file_exists($Path.$FileName)){ // 本地没有就下载 (改为一律下载)
            $DownRet = file_get_contents(trim($Ret['Data']['Address']));
            if($DownRet === false) $this->ApiErr(1016);
            $WriteRet = @file_put_contents($Path.$FileName, $DownRet);
            if($WriteRet === false) $this->ApiErr(1017);
        }
        $PlugPath = './Plugin/'.$Ret['Data']['NameKey'];
        $UnZipRet = $this->CommonObj->UnZip($Path.$FileName, $PlugPath); // 解压并把文件COPY到对应目录
        if($UnZipRet === false) $this->ApiErr(1018); // 解压压缩包失败
        $CopyRet = $this->CommonObj->DirCopy($PlugPath.'/Static', './Static/plugin/'.$Ret['Data']['NameKey']);
        if($CopyRet === false) $this->ApiErr(1019); // Copy静态文件失败

        // 执行升级程序
        require_once $PlugPath.'/Lib/Install.php';
        $InstallObj = new Install();
        if(!method_exists($InstallObj, 'init')) $this->ApiErr(1033);
        if(!method_exists($InstallObj, 'upgrade')) $this->ApiErr(1033);

        try{
            DB::$s_db_obj->beginTransaction();
            $InstallObj->upgrade(); //执行安装程序
            DB::$s_db_obj->commit();
        }catch (PDOException $e){
            DB::$s_db_obj->rollBack();
            $this->ApiErr(1002);
        }
        $this->PluginObj->clean($IsInstalled['PluginId']);
        $this->Menu_sideObj->cleanList();
        $this->ApiSuccess();
    }

    public function pluginUnInstall_Action(){ // 删除插件(从插件市场安装)
        if(!$this->VeriObj->VeriPara($_GET, array('PluginId'))) $this->ApiErr(1001);
        $LocalPlusRs = $this->PluginObj->getOne($_GET['PluginId']);
        if(empty($LocalPlusRs)) $this->ApiErr(1026);
        if($LocalPlusRs['State'] != 2) $this->ApiErr(1028);

        $PlugPath = './Plugin/'.$LocalPlusRs['NameKey'];
        $StaticPath = './Static/plugin/'.$LocalPlusRs['NameKey'];
        $ConfigMap = require_once $PlugPath.'/Lib/Config.php';
        $DbConfig = Config::DbConfig();

        //先清空数据库
        try{
            DB::$s_db_obj->beginTransaction();
            // 删除插件安装数据
            $this->PluginObj->SetCond(array('PluginId' => $LocalPlusRs['PluginId']))->ExecDelete();

            // 删除创建的数据表
            $TablePre = $DbConfig['Prefix'].'plugin_'.$LocalPlusRs['NameKey'].'_';

            $this->delTable($TablePre, $ConfigMap['Data']);

            // 删除菜单
            $this->Menu_sideObj->SetCond(array('PluginId' => $LocalPlusRs['PluginId']))->ExecDelete();

            // 删除文件
            if(file_exists($PlugPath)){
                if ($this->CommonObj->rrmdir($PlugPath) === false) throw new PDOException($this->lang(1030));
            }
            if(file_exists($StaticPath)){
                if ($this->CommonObj->rrmdir($StaticPath) === false) throw new PDOException($this->lang(1030));
            }
            $FilePath = './Static/tmp/QCms_'.$LocalPlusRs['NameKey'].'_'.$LocalPlusRs['Version'].'_plugin.zip';
            if(file_exists($FilePath)){
                if (unlink($FilePath) === false) throw new PDOException($this->lang(1030));
            }

            DB::$s_db_obj->commit();
        }catch(PDOException $e){
            DB::$s_db_obj->rollBack();
            $this->ApiErr(1000, $e->getMessage());
        }
        $this->PluginObj->clean($LocalPlusRs['PluginId']);
        $this->Menu_sideObj->cleanList();
        $this->ApiSuccess();
    }

    public function pluginState_Action(){ // 设置插件状态
        if(!$this->VeriObj->VeriPara($_GET, array('Id', 'Status', 'Field'))) $this->ApiErr(1001);
        $DataArr = array($_GET['Field'] => $this->CommonObj->SafeInput($_GET['Status']));
        try{
            DB::$s_db_obj->beginTransaction();
            $this->PluginObj->SetCond(array('PluginId' => $_GET['Id']))->SetUpdate($DataArr)->ExecUpdate();
            $this->Menu_sideObj->SetCond(array('PluginId' => $_GET['Id'], 'PId' => '0'))->SetUpdate(array('IsShow' => $_GET['Status']))->ExecUpdate();
            DB::$s_db_obj->commit();
        }catch (PDOException $e){
            DB::$s_db_obj->rollBack();
            $this->Err(1002);
        }
        $this->Menu_sideObj->cleanList();
        $this->CommonObj->ApiSuccess();
    }

    public function paytp_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('TemplatesId'))) $this->ApiErr(1001);
        $Ret = $this->apiRemotePlatform('apiRemote/paytp', array('TemplatesId' => $_GET['TemplatesId']));
        if($Ret['Code'] != 0) $this->ApiErr(1000, $Ret['Msg']); // 获取模版信息错误
        $this->ApiSuccess($Ret['Data']);
    }

    public function payplugin_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('PluginId'))) $this->ApiErr(1001);
        $Ret = $this->apiRemotePlatform('apiRemote/payPlugin', array('PluginId' => $_GET['PluginId']));
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

    public function templatesGetVerion_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('TemplatesId'))) $this->ApiErr(1001);
        $Ret = $this->apiRemotePlatform('apiRemote/devTemplatesVersion', array('TemplatesId' => $_GET['TemplatesId']));
        if($Ret['Code'] != 0){
            $this->CommonObj->LogWrite('Code:'.$Ret['Code'].';'.$Ret['Msg']);
            $this->ApiErr(1000, $Ret['Msg']);
        }
        $this->ApiSuccess($Ret['Data']);
    }

    public function pluginGetVerion_Action(){
        if(!$this->VeriObj->VeriPara($_GET, array('PluginId'))) $this->ApiErr(1001);
        $Ret = $this->apiRemotePlatform('apiRemote/devPluginVersion', array('PluginId' => $_GET['PluginId']));
        if($Ret['Code'] != 0){
            $this->CommonObj->LogWrite('Code:'.$Ret['Code'].';'.$Ret['Msg']);
            $this->ApiErr(1000, $Ret['Msg']);
        }
        $this->ApiSuccess($Ret['Data']);
    }
}