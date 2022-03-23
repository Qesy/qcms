use Model\QC_Category;
use Model\QC_File;
use Model\QC_Group_admin;
use Model\QC_Group_user;
use Model\QC_Inlink;
use Model\QC_Inlink_cate;
use Model\QC_Label;
use Model\QC_Label_cate;
use Model\QC_Link;
use Model\QC_Link_cate;
use Model\QC_Log_login;
use Model\QC_Log_operate;
use Model\QC_Page;
use Model\QC_Page_cate;
use Model\QC_Sys;
use Model\QC_Sys_attr;
use Model\QC_Sys_form;
use Model\QC_Sys_model;
use Model\QC_Table;
use Model\QC_Table_album;
use Model\QC_Table_article;
use Model\QC_Table_down;
use Model\QC_Table_product;
use Model\QC_Token;
use Model\QC_User;

public $CategoryObj;
public $FileObj;
public $Group_adminObj;
public $Group_userObj;
public $InlinkObj;
public $Inlink_cateObj;
public $LabelObj;
public $Label_cateObj;
public $LinkObj;
public $Link_cateObj;
public $Log_loginObj;
public $Log_operateObj;
public $PageObj;
public $Page_cateObj;
public $SysObj;
public $Sys_attrObj;
public $Sys_formObj;
public $Sys_modelObj;
public $TableObj;
public $Table_albumObj;
public $Table_articleObj;
public $Table_downObj;
public $Table_productObj;
public $TokenObj;
public $UserObj;

$this->CategoryObj = QC_Category::get_instance();
$this->FileObj = QC_File::get_instance();
$this->Group_adminObj = QC_Group_admin::get_instance();
$this->Group_userObj = QC_Group_user::get_instance();
$this->InlinkObj = QC_Inlink::get_instance();
$this->Inlink_cateObj = QC_Inlink_cate::get_instance();
$this->LabelObj = QC_Label::get_instance();
$this->Label_cateObj = QC_Label_cate::get_instance();
$this->LinkObj = QC_Link::get_instance();
$this->Link_cateObj = QC_Link_cate::get_instance();
$this->Log_loginObj = QC_Log_login::get_instance();
$this->Log_operateObj = QC_Log_operate::get_instance();
$this->PageObj = QC_Page::get_instance();
$this->Page_cateObj = QC_Page_cate::get_instance();
$this->SysObj = QC_Sys::get_instance();
$this->Sys_attrObj = QC_Sys_attr::get_instance();
$this->Sys_formObj = QC_Sys_form::get_instance();
$this->Sys_modelObj = QC_Sys_model::get_instance();
$this->TableObj = QC_Table::get_instance();
$this->Table_albumObj = QC_Table_album::get_instance();
$this->Table_articleObj = QC_Table_article::get_instance();
$this->Table_downObj = QC_Table_down::get_instance();
$this->Table_productObj = QC_Table_product::get_instance();
$this->TokenObj = QC_Token::get_instance();
$this->UserObj = QC_User::get_instance();

