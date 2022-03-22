<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Api extends ControllersAdmin {
    
    public function ajaxUpload_Action(){
        $Ret = $this->UploadObj->upload_file($_FILES['filedata']);
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
        $Ret = $this->UploadObj->upload_file($_FILES['upload']);
        if($Ret['Code'] != 0) {
            $msg['uploaded'] = false;
            $msg['error'] = array('message' => $Ret['Msg']);
            $msg['url'] = '';
            echo json_encode($msg);exit;
        }
        $ext = substr ( strrchr ( $_FILES['upload'] ['name'], '.' ), 1 );
        $this->FileObj->SetInsert(array(
            'UserId' => $this->LoginUserRs['UserId'],
            'Name' => $_FILES['filedata']['name'],
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
    
    public function tableField_Action(){ //获取表字段
        if(!$this->VeriObj->VeriPara($_POST, array('TableName'))) $this->ApiErr(1001);
        $FieldArr = $this->TableObj->query('SHOW FULL COLUMNS FROM '.$_POST['TableName'], array());
        $this->ApiSuccess($FieldArr);
    }
    
}