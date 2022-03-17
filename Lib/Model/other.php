use Model\QC_Category;
use Model\QC_Group_admin;
use Model\QC_Group_user;
use Model\QC_Log_login;
use Model\QC_Log_operate;
use Model\QC_Sys;
use Model\QC_Sys_attr;
use Model\QC_Token;
use Model\QC_User;
use Model\QC_User_company;
use Model\QC_User_model;
use Model\QC_User_personal;

public $CategoryObj;
public $Group_adminObj;
public $Group_userObj;
public $Log_loginObj;
public $Log_operateObj;
public $SysObj;
public $Sys_attrObj;
public $TokenObj;
public $UserObj;
public $User_companyObj;
public $User_modelObj;
public $User_personalObj;

$this->CategoryObj = QC_Category::get_instance();
$this->Group_adminObj = QC_Group_admin::get_instance();
$this->Group_userObj = QC_Group_user::get_instance();
$this->Log_loginObj = QC_Log_login::get_instance();
$this->Log_operateObj = QC_Log_operate::get_instance();
$this->SysObj = QC_Sys::get_instance();
$this->Sys_attrObj = QC_Sys_attr::get_instance();
$this->TokenObj = QC_Token::get_instance();
$this->UserObj = QC_User::get_instance();
$this->User_companyObj = QC_User_company::get_instance();
$this->User_modelObj = QC_User_model::get_instance();
$this->User_personalObj = QC_User_personal::get_instance();

