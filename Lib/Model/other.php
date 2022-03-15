use Model\QC_Log_login;
use Model\QC_Sys;
use Model\QC_Token;
use Model\QC_User;
use Model\QC_User_company;
use Model\QC_User_model;
use Model\QC_User_personal;

public $Log_loginObj;
public $SysObj;
public $TokenObj;
public $UserObj;
public $User_companyObj;
public $User_modelObj;
public $User_personalObj;

$this->Log_loginObj = QC_Log_login::get_instance();
$this->SysObj = QC_Sys::get_instance();
$this->TokenObj = QC_Token::get_instance();
$this->UserObj = QC_User::get_instance();
$this->User_companyObj = QC_User_company::get_instance();
$this->User_modelObj = QC_User_model::get_instance();
$this->User_personalObj = QC_User_personal::get_instance();

