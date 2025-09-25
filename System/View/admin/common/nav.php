<nav class="navbar navbar-inverse fixed-top">
    <div class="d-flex align-items-center">

        <a href="/admin/index/index.html">
            <?=$this->GetLogo('logo mx-3', 'fill:#1572E8; width: 98px; height: 24px;');?>
        </a>

        <a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block mr-20 pull-left" href="javascript:void(0);">
        <i class="ti-layers"></i>
    </a>


    </div>
    <ul class="nav navbar-right top-nav pull-right">
        <li>
            <a href="<?=$_SERVER['REQUEST_SCHEME'].'://'.URL_DOMAIN?>/" target="_blank" >
            <iconpark-icon name="home" size="1.1rem" class="mr-1"></iconpark-icon><span>网站主页</span>
            </a>
        </li>
        <li class="dropdown <?=empty($this->SiteArr) ? 'd-none' : ''?>">
            <a href="#" data-toggle="dropdown" >
            <iconpark-icon name="branch-one" size="1.1rem" class="mr-1"></iconpark-icon>切换站点 <iconpark-icon name="down" size="1.2rem"></iconpark-icon>
            </a>
            <ul class="dropdown-menu " data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                <?
                foreach($this->SiteArr as $v){
                ?>
                <li>
                    <a class="dropdown-item py-1" href="<?=$v['WebSite'].'index/muLogin.html?Secret='.md5($v['Secret'])?>">
                        <iconpark-icon name="star"></iconpark-icon>
                        <?=$v['Name']?>
                    </a>
                </li>
                <? } ?>
            </ul>
        </li>
        <li>
            <a href="http://bbs.q-cms.cn/" target="_blank" >
            <iconpark-icon name="communication" size="1.1rem" class="mr-1"></iconpark-icon>官网论坛
            </a>
        </li>
        <li>
            <a href="<?=$this->CommonObj->Url(array('admin', 'index', 'upgrade'))?>" >
            <?
            if($this->CookieObj->get('IsUpdate', 'User') == '1'){
                echo '<iconpark-icon name="update-rotation-i9a4hm9k" size="1.1rem" class="mr-1 text-primary"></iconpark-icon>';
            }else{
                echo '<iconpark-icon name="update-rotation" size="1.1rem" class="mr-1"></iconpark-icon>';
            }
            ?>
             系统升级
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