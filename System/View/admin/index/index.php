
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?=WEB_TITLE?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <?=$this->LoadView('admin/common/meta')?>
</head>

<body>
    <!--/Preloader-->
    <div class="wrapper">
            <!-- Top Menu Items -->
            <?=$this->LoadView('admin/common/nav')?>
            <!-- /Top Menu Items -->

            <!-- Left Sidebar Menu -->
            <?=$this->LoadView('admin/common/sidebar')?>
            <!-- /Left Sidebar Menu -->

        <!-- Main Content -->
        <div class="page-wrapper">
            <div class="container-fluid">

                <!-- Title -->
                <div class="row heading-bg  bg-primary">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-light"><?=$this->PageTitle?></h5>
                    </div>
                    <!-- Breadcrumb -->
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="index.html">用户中心</a></li>
                            <?
                            //var_dump($this->BreadCrumb);exit;
                            foreach($this->BreadCrumb as $v){
                                echo '<li class="'.($v['IsActive'] ? 'active' : '').'"><a href="'.$v['Url'].'"><span>'.$v['Name'].'</span></a></li>';
                            }
                            ?>
                        </ol>
                    </div>
                    <!-- /Breadcrumb -->
                </div>
                <!-- /Title -->
                <div class="row">
                    <div class="col-12 col-md-3">
                        <a href="<?=$this->CommonObj->Url(array('admin', 'website', 'index'))?>">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper ">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box bg-yellow">
                                        <div class="row ma-0">
                                            <div class="col-5 text-center pa-0 icon-wrap-left">
                                                <i class="icon-diamond txt-light"></i>
                                            </div>
                                            <div class="col-7 text-center data-wrap-right">
                                                <h6 class="txt-light">网站数量</h6>
                                                <span class="txt-light counter counter-anim"><?=$Rs['WebNum']?>个</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <div class="col-12 col-md-3">
                        <a href="<?=$this->CommonObj->Url(array('user', 'plug', 'used'))?>">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper ">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box bg-green">
                                        <div class="row ma-0">
                                            <div class="col-5 text-center pa-0 icon-wrap-left">
                                                <i class="icon-puzzle txt-light"></i>
                                            </div>
                                            <div class="col-7 text-center data-wrap-right">
                                                <h6 class="txt-light">已购插件</h6>
                                                <span class="txt-light counter counter-anim"><?=$Rs['PlugNum']?>个</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper ">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box bg-red">
                                        <div class="row ma-0">
                                            <div class="col-5 text-center pa-0 icon-wrap-left">
                                                <i class="icon-arrow-down-circle txt-light"></i>
                                            </div>
                                            <div class="col-7 text-center data-wrap-right">
                                                <h6 class="txt-light">下载次数</h6>
                                                <span class="txt-light counter counter-anim"><?=$Rs['PlugNum']?>次</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper ">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box bg-pink">
                                        <div class="row ma-0">
                                            <div class="col-5 text-center pa-0 icon-wrap-left">
                                                <i class="icon-speech txt-light"></i>
                                            </div>
                                            <div class="col-7 text-center data-wrap-right">
                                                <h6 class="txt-light">评论数</h6>
                                                <span class="txt-light counter counter-anim">0条</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h6 class="panel-title txt-dark"><i class="icon-share mr-10"></i>网站流量统计</h6>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper ">
                                <div id="morris_extra_line_chart" class="morris-chart" style="height:442px;"></div>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
            <!-- Footer -->
            <?=$this->LoadView('admin/common/footer')?>
            <!-- /Footer -->

        </div>
        <!-- /Main Content -->

    </div>
    <!-- jQuery -->
    <?=$this->LoadView('admin/common/js')?>



</body>
</html>
