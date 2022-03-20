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
    public $IsArr = array('1' => '是', 2 => '否');
    public $OpenArr = array('1' => '开启', 2 => '关闭');
    public $IsShowArr = array('1' => '显示', 2 => '隐藏');
    public $StateArr = array('1' => '已发布', 2 => '未发布');
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
            'admin/user' => array('Name' => '会员中心', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'user'))),
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
            
            // 分类管理
            'admin/category/index' => array('Name' => '分类管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'index'))),
            'admin/category/add' => array('Name' => '添加分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'add'))),
            'admin/category/edit' => array('Name' => '修改分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'edit'))),
            'admin/category/del' => array('Name' => '删除分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'del'))),
            'admin/category/move' => array('Name' => '移动分类', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category', 'move'))),
            
            // 内容管理
            'admin/content/recovery' => array('Name' => '回收站', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', 'recovery'))),
            'admin/content/view' => array('Name' => '查看文章', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', 'view'))),
            'admin/content/restore' => array('Name' => '恢复文章', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', 'restore'))),
            'admin/content/tDelete' => array('Name' => '彻底删除', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', 'tDelete'))),
            
            // 会员管理
            'admin/user/index' => array('Name' => '会员管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'user', 'index'))),
            'admin/user/add' => array('Name' => '会员管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'user', 'add'))),
            'admin/user/edit' => array('Name' => '会员管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'user', 'edit'))),
            'admin/user/del' => array('Name' => '会员管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'user', 'del'))),
            /* 'admin/article/index' => array('Name' => '文章管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'article', 'index'))),
            'admin/article/add' => array('Name' => '添加文章', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'article', 'add'))),
            'admin/article/edit' => array('Name' => '修改文章', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'article', 'edit'))),
            'admin/article/del' => array('Name' => '删除文章', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'article', 'del'))),
            'admin/product/index' => array('Name' => '产品管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'product', 'index'))),
            'admin/product/add' => array('Name' => '添加产品', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'product', 'add'))),
            'admin/product/edit' => array('Name' => '修改产品', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'product', 'edit'))),
            'admin/product/del' => array('Name' => '删除产品', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'product', 'del'))),
            'admin/album/index' => array('Name' => '相册管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'album', 'index'))),
            'admin/album/add' => array('Name' => '添加相册', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'album', 'add'))),
            'admin/album/edit' => array('Name' => '修改相册', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'album', 'edit'))),
            'admin/album/del' => array('Name' => '删除相册', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'album', 'del'))),
            'admin/down/index' => array('Name' => '下载管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'down', 'index'))),
            'admin/down/add' => array('Name' => '添加下载', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'down', 'add'))),
            'admin/down/edit' => array('Name' => '修改下载', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'down', 'edit'))),
            'admin/down/del' => array('Name' => '删除下载', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'down', 'del'))), */
            
            // API
            'admin/api/ajaxUpload' => array('Name' => 'AJAX上传', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'ajaxUpload'))),
            'admin/api/ckUpload' => array('Name' => 'CkEditor上传', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'ckUpload'))),
            
            
            /* 'admin/approve' => array('Name' => '审核管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'approve'))),

            
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

            'admin/sys/index' => array('Name' => '系统设置', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'sys', 'index'))), */
            'index/signout' => array('Name' => '安全退出', 'Permission' => array('1', '2', '3'), 'Url' => $this->CommonObj->url(array('index', 'signout'))),

        );
        $ModelArr = $this->Sys_modelObj->getList();
        $RoleMenuArr = array(array('Key' => 'admin/category/index'),);
        foreach($ModelArr as $v) {
            $Para = array('ModelId' => $v['ModelId']);
            foreach(array('index', 'add', 'edit', 'del') as $mv){
                $Key = 'admin/content/'.$mv.'?'.http_build_query($Para);
                if($mv == 'index') $RoleMenuArr[] = array('Key' => $Key);                
                $this->MenuArr[$Key] = array('Name' => $v['Name'].'管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'content', $mv)), 'Para' => array('ModelId' => $v['ModelId']));
            }            
        }
        $RoleMenuArr[] = array('Key' => 'admin/content/recovery');
        //var_dump($this->MenuArr);exit;
        $this->RoleMenuArr = array(
            array('Key' => 'admin/index/index', 'subCont' => array('index'), 'Icon' => 'bi bi-house'),
            array('Key' => 'admin/index', 'subCont' => array('sys', 'admin', 'groupAdmin', 'log'), 'Icon' => 'bi bi-gear', 'Sub' => array(
                array('Key' => 'admin/sys/index'),
                array('Key' => 'admin/admin/index'),
                array('Key' => 'admin/groupAdmin/index'),
                array('Key' => 'admin/log/operate'),
                array('Key' => 'admin/log/login'),
            )),
            array('Key' => 'admin/content', 'subCont' => array('category', 'content'), 'Icon' => 'bi bi-layout-text-sidebar-reverse', 'Sub' => $RoleMenuArr),
            array('Key' => 'admin/user', 'subCont' => array('user'), 'Icon' => 'bi bi-person', 'Sub' => array(
                array('Key' => 'admin/user/index'),
            )),
            /* array('Key' => 'admin/website/index', 'subCont' => array('website'), 'Icon' => 'bi bi-columns-gap'),
            
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
            array('Key' => 'admin/sys/index', 'subCont' => array('sys'), 'Icon' => 'bi bi-gear'), */
            array('Key' => 'index/signout', 'subCont' => array('signout'), 'Icon' => 'bi bi-box-arrow-right'),
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
        $this->PageTitle2 = '<div class="tab-struct custom-tab-1">
                <ul role="tablist" class="nav nav-tabs">
                    <li class="active"><a class="tabBnt" href="#" data-index="0">'.$MenuRs['Name'].'</a></li>
                </ul></div>';

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
        
    }
    
    public function getTemplate($Prefix){
        $Files = scandir(PATH_TEMPLATE.$this->SysRs['TmpPath'].'/');
        $Template = array();
        foreach($Files as $v){
            if(in_array($v, array('.', '..'))) continue;
            if(is_dir(PATH_TEMPLATE.$v)) continue;
            if(strpos($v, $Prefix) !== 0 || substr($v, -5) != '.html') continue;
            $Template[$v] = $v;
        }
        return $Template;
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