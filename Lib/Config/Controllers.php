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
    public $SexArr = array('1' => '男', 2 => '女');
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
            'admin/category' => array('Name' => '分类管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'category'))),
            'admin/content' => array('Name' => '内容管理', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'index'))),
            'admin/user' => array('Name' => '会员中心', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'user'))),
            'admin/data' => array('Name' => '数据维护', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'data'))),
            'admin/assist' => array('Name' => '辅助插件', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'other'))),
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
            'admin/groupAdmin/del' => array('Name' => '删除管理组', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'groupAdmin', 'del'))),
            'admin/log/operate' => array('Name' => '操作日志', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'log', 'operate'))),
            'admin/log/login' => array('Name' => '登录日志', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'log', 'login'))),
            
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
            'admin/data/replace' => array('Name' => '批量替换', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'data', 'replace'))),
            'admin/data/highReplace' => array('Name' => '高级替换', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'data', 'highReplace'))),
            
            // API
            'admin/api/ajaxUpload' => array('Name' => 'AJAX上传', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'ajaxUpload'))),
            'admin/api/ckUpload' => array('Name' => 'CkEditor上传', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'ckUpload'))),
            'admin/api/userState' => array('Name' => '设置用户状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'userState'))),
            'admin/api/linkState' => array('Name' => '设置链接状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'linkState'))),
            'admin/api/pageState' => array('Name' => '设置单页状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'pageState'))),
            'admin/api/labelState' => array('Name' => '设置标签状态', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'labelState'))),
            'admin/api/tableField' => array('Name' => '查询表字段', 'Permission' => array('1', '2', '3'),'Url' => $this->CommonObj->url(array('admin', 'api', 'tableField'))),
            
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
            array('Key' => 'admin/index', 'subCont' => array('sys', 'admin', 'groupAdmin', 'log'), 'Icon' => 'bi bi-gear', 'Sub' => array(
                array('Key' => 'admin/sys/index'),
                array('Key' => 'admin/admin/index'),
                array('Key' => 'admin/groupAdmin/index'),
                array('Key' => 'admin/log/operate'),
                array('Key' => 'admin/log/login'),
            )),
            array('Key' => 'admin/category', 'subCont' => array('category', 'page', 'pageCate', 'labelCate', 'label', 'form', 'formField', ), 'Icon' => 'bi bi-list-ol', 'Sub' => array(
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
            array('Key' => 'admin/data', 'subCont' => array('data', 'model', 'modelField'), 'Icon' => 'bi bi-tools', 'Sub' => array(
                array('Key' => 'admin/model/index'),
                
                array('Key' => 'admin/data/replace'),
                array('Key' => 'admin/data/highReplace'),
            )),
            array('Key' => 'admin/assist', 'subCont' => array('linkCate', 'link', 'inlinkCate', 'inlink', 'file'), 'Icon' => 'bi bi-columns-gap', 'Sub' => array(
                //array('Key' => 'admin/linkCate/index'),
                array('Key' => 'admin/link/index'),
                array('Key' => 'admin/inlink/index'),
                array('Key' => 'admin/swiperCate/index'),
                array('Key' => 'admin/tag/index'),
                array('Key' => 'admin/file/index'),
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