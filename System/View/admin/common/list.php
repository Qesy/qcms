
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?=$this->SysRs['WebName']?> - 网站后台</title>
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
                            foreach($this->BreadCrumb as $v){
                                echo '<li class="'.($v['IsActive'] ? 'active' : '').'"><a href="'.$v['Url'].'"><span>'.$v['Name'].'</span></a></li>';
                            }
                            ?>
                        </ol>
                    </div>
                    <!-- /Breadcrumb -->
                </div>
                <!-- /Title -->
                <div class="row" style="min-height: 600px;">
<div class="col-sm-12">
                        <div class="panel panel-default card-view" >
                            <div class="panel-heading mb-3 d-flex justify-content-between align-items-center">

<h5 class="txt-dark"><?=$this->PageTitle2?></h5>
                                    <span ><?
        if($this->BuildObj->IsAdd){
        ?>
        <a href="<?=$this->BuildObj->LinkAdd?>" class="btn btn-primary btn-sm"><?=$this->BuildObj->NameAdd?></a>
      <? } ?>
      <?
      foreach($this->BuildObj->TableTopBtnArr as $v){
        echo '<a href="'.$v['Link'].'" class="btn btn-'.$v['Class'].' btn-sm ml-2 table_top_'.$v['Name'].'">'.$v['Desc'].'</a>';
      }
      ?></span>


                            </div>
                            <div class="panel-wrapper ">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <div id="myTable_wrapper" class="table table-hover  mb-0 no-footer"><div id="myTable_filter" class="dataTables_filter"></div>
                                                <div class="mb-2"><?=$this->HeadHtml?></div>
                                                <?=$Table?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
