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
    public $OpenArr = array('1' => '开启', 2 => '关闭');
    public $EditorArr = array('ckeditor' => 'ckeditor');
}
class ControllersAdmin extends Controllers {

    public $PageTitle;
    public $PageTitle2;
    public $Module = 'admin';
    public $LoginUserRs = array();
    public $MenuArr = array();
    public $RoleMenuArr = array();
    public $BreadCrumb = array();
    function __construct(){
        parent::__construct();
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
            'admin/content' => array('Name' => '内容管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'index'))),
            // 用户首页
            'admin/index/index' => array('Name' => '用户首页', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'index', 'index'))),
            // 系统管理
            'admin/sys/index' => array('Name' => '基本设置', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'sys', 'index'))),
            'admin/admin/index' => array('Name' => '管理员管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'admin', 'index'))),
            'admin/admin/add' => array('Name' => '添加管理员', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'admin', 'add'))),
            'admin/admin/edit' => array('Name' => '修改管理员', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'admin', 'edit'))),
            'admin/admin/del' => array('Name' => '删除管理员', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'admin', 'del'))),
            'admin/groupAdmin/index' => array('Name' => '管理组管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'groupAdmin', 'index'))),
            'admin/groupAdmin/add' => array('Name' => '添加管理组', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'groupAdmin', 'add'))),
            'admin/groupAdmin/edit' => array('Name' => '修改管理组', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'groupAdmin', 'edit'))),
            'admin/groupAdmin/del' => array('Name' => '删除管理组管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'groupAdmin', 'del'))),
            'admin/log/operate' => array('Name' => '操作日志', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'log', 'operate'))),
            'admin/log/login' => array('Name' => '登录日志', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'log', 'login'))),
            
            // 内容管理
            'admin/category/index' => array('Name' => '分类管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'index'))),
            
            'admin/approve' => array('Name' => '审核管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'approve'))),

            
            'admin/index/qrCode' => array('Name' => '获取二维码', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'index', 'qrCode'))),
            

            //CMS系统管理
            'admin/cms' => array('Name' => 'CMS系统', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'cms'))),
            'admin/cms/index' => array('Name' => '版本管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'cms', 'index'))),
            'admin/cms/add' => array('Name' => '发布版本', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'cms', 'add'))),
            'admin/cms/edit' => array('Name' => '修改版本', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'cms', 'edit'))),
            'admin/cms/del' => array('Name' => '删除版本', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'cms', 'del'))),
            // 网站
            'admin/website/index' => array('Name' => '网站列表', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'website', 'index'))),
            'admin/website/add' => array('Name' => '网站添加', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'website', 'add'))),
            'admin/website/edit' => array('Name' => '网站修改', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'website', 'edit'))),
            'admin/website/del' => array('Name' => '网站删除', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'website', 'del'))),
            // API
            'admin/api/ajaxUpload' => array('Name' => 'AJAX上传', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'ajaxUpload'))),
            'admin/api/userState' => array('Name' => '设置用户状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'userState'))),
            'admin/api/cmsState' => array('Name' => '设置CMS状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'cmsState'))),
            'admin/api/plugState' => array('Name' => '设置插件状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'plugState'))),
            'admin/api/verState' => array('Name' => '设置版本状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'verState'))),
            'admin/api/verIsShow' => array('Name' => '设置版本上下线', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'verIsShow'))),
            'admin/api/check' => array('Name' => '检测是否购买过', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'check'))),
            'admin/api/orderSubmit' => array('Name' => '提交订单', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'orderSubmit'))),
            'admin/api/getOrder' => array('Name' => '获取订单信息', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'getOrder'))),
            'admin/api/orderPay' => array('Name' => '订单支付', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'orderPay'))),
            // DEV
            'admin/dev/index' => array('Name' => '开发者管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'dev', 'index'))),
            'admin/dev/edit' => array('Name' => '开发者修改', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'dev', 'edit'))),
            'admin/dev/del' => array('Name' => '开发者删除', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'dev', 'del'))),
            'admin/apply/index' => array('Name' => '开发者资料', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'apply', 'index'))),
            // 插件
            'admin/plug/index' => array('Name' => '插件市场', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'plug', 'index'))),
            'admin/plug/used' => array('Name' => '已购插件', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'plug', 'used'))),
            'admin/plug/myplug' => array('Name' => '插件发布', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'plug', 'myplug'))),
            'admin/plug/add' => array('Name' => '插件添加', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'plug', 'add'))),
            'admin/plug/edit' => array('Name' => '插件修改', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'plug', 'edit'))),
            'admin/plugver/index' => array('Name' => '插件版本管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'plugver', 'index'))),
            'admin/plugver/add' => array('Name' => '插件版本添加', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'plugver', 'add'))),
            'admin/plugver/edit' => array('Name' => '插件版本修改', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'plugver', 'edit'))),

            // 订单
            'admin/order/index' => array('Name' => '订单中心', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'order', 'userMonth'))),

            // 审核管理
            'admin/approve/plug' => array('Name' => '插件审核', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'approve', 'plug'))),
            'admin/approve/plugver' => array('Name' => '插件版本审核', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'approve', 'plugver'))),
            // 用户
            'admin/user' => array('Name' => '用户管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'admin'))),
            'admin/profile/index' => array('Name' => '个人资料', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'profile', 'index'))),
            
            'admin/admin/edit' => array('Name' => '用户修改', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'admin', 'edit'))),
            'admin/admin/del' => array('Name' => '用户删除', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'admin', 'del'))),
            // 订单
            'admin/order/index' => array('Name' => '订单中心', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'order', 'index'))),

            'admin/sys/index' => array('Name' => '系统设置', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'sys', 'index'))),
            'index/signout' => array('Name' => '安全退出', 'Permission' => array('1', '2', '3'), 'Url' => $this->CommonObj->url(array('index', 'signout'))),

        );
        $this->RoleMenuArr = array(
            array('Key' => 'admin/index/index', 'subCont' => array('index'), 'Icon' => 'bi bi-house'),
            array('Key' => 'admin/index', 'subCont' => array('sys', 'admin', 'groupAdmin', 'log'), 'Icon' => 'bi bi-gear', 'Sub' => array(
                array('Key' => 'admin/sys/index'),
                array('Key' => 'admin/admin/index'),
                array('Key' => 'admin/groupAdmin/index'),
                array('Key' => 'admin/log/operate'),
                array('Key' => 'admin/log/login'),
            )),
            array('Key' => 'admin/content', 'subCont' => array('category'), 'Icon' => 'bi bi-layout-text-sidebar-reverse', 'Sub' => array(
                array('Key' => 'admin/category/index'),
            )),
            array('Key' => 'admin/website/index', 'subCont' => array('website'), 'Icon' => 'bi bi-columns-gap'),
            /* array('Key' => 'admin/plug', 'subCont' => array('plug', 'plugver'), 'Icon' => 'bi bi-puzzle', 'Sub' => array(
                array('Key' => 'admin/plug/index'),
                array('Key' => 'admin/plug/used'),
                array('Key' => 'admin/plug/myplug'),

            )), */
            array('Key' => 'admin/order/index', 'subCont' => array('order'), 'Icon' => 'bi bi-layout-text-sidebar-reverse'),
            //array('Key' => 'admin/profile/index', 'subCont' => array('profile')),
            array('Key' => 'admin/apply/index', 'subCont' => array('apply'), 'Icon' => 'bi bi-journal-medical'),
            array('Key' => 'admin/user', 'subCont' => array('admin', 'dev'), 'Icon' => 'bi bi-people', 'Sub' => array(
                array('Key' => 'admin/admin/index'),
                array('Key' => 'admin/dev/index'),
            )),
            array('Key' => 'admin/approve', 'subCont' => array('approve'), 'Icon' => 'bi bi-list-check', 'Sub' => array(
                array('Key' => 'admin/approve/plug'),
                array('Key' => 'admin/approve/plugver'),
            )),
            array('Key' => 'admin/cms', 'subCont' => array('cms'), 'Icon' => 'bi bi-gem'),
            array('Key' => 'admin/sys/index', 'subCont' => array('sys'), 'Icon' => 'bi bi-gear'),
            array('Key' => 'index/signout', 'subCont' => array('signout'), 'Icon' => 'bi bi-box-arrow-right'),
        );
        $Url = implode('/', array($this->Module, Router::$s_Controller, Router::$s_Method));

        if(!isset($this->MenuArr[$Url])) $this->CommonObj->Err('没有此页面');
        $MenuRs = $this->MenuArr[$Url];

        if(!in_array($UserRs['GroupAdminId'], $MenuRs['Permission'])) $this->CommonObj->Err('没有权限');
        $this->PageTitle = $MenuRs['Name'];
        $this->PageTitle2 = '<div class="tab-struct custom-tab-1">
                <ul role="tablist" class="nav nav-tabs">
                    <li class="active"><a class="tabBnt" href="#" data-index="0">'.$MenuRs['Name'].'</a></li>
                </ul></div>';

        foreach($this->RoleMenuArr as $v){
            if(in_array(Router::$s_Controller, $v['subCont'])){
                $this->MenuArr[$v['Key']]['IsActive'] = true;
                $this->BreadCrumb[] = $this->MenuArr[$v['Key']];
                if(!empty($v['Sub'])){
                    $this->BreadCrumb[] = $this->MenuArr[$Url];
                }
                break;
            }
        }
        
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