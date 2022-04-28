
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
                            <div class="panel-heading mb-3 pb-2 d-flex justify-content-between align-items-center border-bottom">

<h5 class="txt-dark"><?=$this->PageTitle2?></h5>



                            </div>
                            <div class="panel-wrapper ">
                                <div class="panel-body">
                                    <div class="row">
                                        <?
                                        foreach($Arr as $k => $v){
                                        ?>
                                        <div class="col-lg-2 mb-4">
                                            <a href="javascript:void(0);" class="tempViewBtn" data-index="<?=$k?>">
                                                        <div class="border mb-2" >
                                                            <img alt="image" class="img-fluid" src="<?=$v['Pic']?>">
                                                        </div>
                                                        <div class="file-name">
                                                            <div class="text-nowrap overflow-hidden "><span class="float-right"><?=$this->CommonObj->Size($v['Size'])?></span><span class="font-weight-bold"><?=empty($v['Name']) ? '未命名' : $v['Name']?></span></div>

                                                        </div>
                                                    </a>


                                        </div>
                                        <? } ?>

                                    </div>
                                    <?=$Page?>
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
    <div class="modal" tabindex="-1" id="tempViewModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body border-bottom">
            <p>Modal body text goes here.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-primary" id="installBtn">安装</button>
          </div>
        </div>
      </div>
    </div>

    <!-- jQuery -->
    <?=$this->LoadView('admin/common/js')?>
    <script type="text/javascript">
        var TemplateArr = <?=json_encode($Arr)?>;
        var SelectIndex = -1;
        $(function(){
            $('.tempViewBtn').click(function(){
                SelectIndex = $(this).attr('data-index');
                $('#tempViewModal .modal-title').html(TemplateArr[SelectIndex]['Name']);
                $('#tempViewModal .modal-body').html(`
                    <img class="img-fluid" src="`+TemplateArr[SelectIndex]['Pic']+`"/>
                `);
                $('#tempViewModal').modal();
            })
            $('#installBtn').click(function(){
                $.get('/admin/api/installTemplate', {TemplatesId:TemplateArr[SelectIndex]['TemplatesId']}, function(Res){
                    if(Res.Code != 0){
                        alert(Res.Msg);return;
                    }
                    alert('安装成功');
                    $('#tempViewModal').modal('hide');
                }, 'json')
            })
        })
    </script>
</body>
</html>
