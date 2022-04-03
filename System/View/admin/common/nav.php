<nav class="navbar navbar-inverse fixed-top">
    <div class="d-flex align-items-center">

        <a href="/admin/index/index.html"><!-- <img class="pull-left" src="<?= URL_IMG ?>logo.svg" alt="brand" style="height:24px;
        margin-right: 20px;
        margin-left: 4px;
        "> --><svg class="logo mx-3" style="fill: #1572E8!important;width: 98px;height: 24px;" >
                  <use xlink:href="/Static/images/logo.svg#layer"/>
                </svg></a>
        <a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block mr-20 pull-left" href="javascript:void(0);">
        <i class="ti-layers"></i>
    </a>


    </div>
    <ul class="nav navbar-right top-nav pull-right">
        <li>
            <a href="<?=$_SERVER['REQUEST_SCHEME'].'://'.URL_DOMAIN?>/" target="_blank">
            <i class="bi bi-grid h5"></i> 网站主页
            </a>
        </li>
        <li>
            <a href="http://bbs.q-cms.cn/" target="_blank">
            <i class="bi bi-chat-text h5"></i> 官网论坛
            </a>
        </li>
        <li class="dropdown">
            <a href="#" class="pr-0" data-toggle="dropdown"><img src="<?= (empty($this->LoginUserRs['Head']) ? URL_IMG . 'head.png' : $this->LoginUserRs['Head']) ?>" alt="user_auth" class="user-auth-img rounded-circle"></a>
            <ul class="dropdown-menu " data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                <li>
                    <a class="dropdown-item py-1" href="<?= $this->CommonObj->url(array('admin', 'user', 'edit')).'?UserId='.$this->LoginUserRs['UserId'] ?>"><i class="icon-user"></i> 个人资料</a>
                </li>
                <li>
                    <a class="dropdown-item py-1" href="<?= $this->CommonObj->url(array('index', 'adminLogout')) ?>"><i class="icon-power"></i> 安全退出</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>