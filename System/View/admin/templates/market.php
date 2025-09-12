
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
                            <div class="panel-heading mb-3 pb-2 d-flex justify-content-between align-items-center border-bottom">

<h5 class="txt-dark"><?=$this->PageTitle2?></h5>
<span>
    <span class="mr-2">平台账号：<?=$this->SysRs['BindPhone']?></span>
    <button type="button" class="btn btn-primary btn-sm UnBindBtn">解绑</button>
</span>


                            </div>
                            <div class="panel-wrapper ">
                                <div class="panel-body">
                                    <div class="px-3 my-4 <?=(count($CateArr) == 0) ? 'd-none' : ''?>">
                                        <div class="row border py-3">
                                            <?
                                            foreach($CateArr as $v){

                                                ?>
                                                <div class="col-3 text-center py-1 "><a href="<?=$this->CommonObj->Url(array('admin', 'templates', 'market')).'?CateId='.$v['TemplatesCateId']?>" class="<?=(isset($_GET['CateId']) && $v['TemplatesCateId'] == $_GET['CateId']) ? 'text-primary font-weight-bold' : 'text-muted'?>"><?=$v['Name']?> (<span > <?=$v['c']?></span> )</a></div>
                                                <?
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?
                                        foreach($Arr as $k => $v){
                                        ?>
                                        <div class="col-lg-2 mb-4">
                                            <?
                                            if(isset($TempFolder[$v['NameKey']])){
                                            ?>
                                            <span class="position-absolute btn btn-danger btn-sm " style="right:1rem;top:0px;">已安装</span>
                                            <? } ?>
                                            <div >
                                                    <div class="border mb-2 tempViewBtn" data-index="<?=$k?>">
                                                        <img alt="image" class="img-fluid" src="<?=$v['Pic']?>">
                                                    </div>
                                                    <div class="file-name">

                                                        <div class="text-nowrap overflow-hidden py-1"><span class="float-right d-none"><?=$this->CommonObj->Size($v['Size'])?></span><span class="font-weight-bold overflow-hidden"><?=empty($v['Name']) ? '未命名' : $v['Name']?></span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="text-danger h5 mb-0">&yen; <?=number_format($v['Price'], 2)?></span>
                                                            <span>
                                                                <?
                                                                if(in_array($v['TemplatesId'], $PaidIDs)){
                                                                    if(isset($TempFolder[$v['NameKey']])){
                                                                        echo '<button class="btn btn-sm btn-success" data-index="'.$k.'" disabled="disabled">安装</button>';
                                                                    }else{
                                                                        echo '<button class="btn btn-sm btn-success InstallBtn " data-index="'.$k.'">安装</button>';
                                                                    }

                                                                }else{
                                                                    echo '<button class="btn btn-sm btn-primary  BuyBtn" data-index="'.$k.'">购买</button>';
                                                                }
                                                                ?>

                                                            </span>
                                                        </div>

                                                    </div>
                                            </div>


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
            <!-- <a target="_blank" href="https://www.q-cms.cn/templates.html" class="btn btn-primary">去官网下载</a>
            <button type="button" class="btn btn-primary" id="installBtn">安装</button> -->
          </div>
        </div>
      </div>
    </div>

    <div class="modal" tabindex="-1" id="PayModal">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">微信扫码支付</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <div id="QrCode"></div>
            <div id="QrCodeStr" class="text-dark">请用微信扫描此二维码并支付</div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">支付完成</button>
          </div>
        </div>
      </div>
    </div>

    <!-- jQuery -->
    <?=$this->LoadView('admin/common/js')?>
    <script type="text/javascript">
        var TemplateArr = <?=json_encode($Arr)?>;
        var TempFolder = <?=json_encode($TempFolder)?>;
        var SelectIndex = -1;
        var PlatformUrl = '<?=$this->PlatformUrl?>';
        $(function(){
            $('.UnBindBtn').click(function(){
                $.get('/admin/api/ajaxUnBind', {}, function(Res){
                    if(Res.Code != 0){
                        alert(Res.Msg);return;
                    }
                    alert('解绑成功');
                    location.reload();
                }, 'json')
            })
            $('.tempViewBtn').click(function(){ // 查看演示
                SelectIndex = $(this).attr('data-index');
                let NameKey = TemplateArr[SelectIndex]['NameKey'];
                $('#tempViewModal .modal-title').html(TemplateArr[SelectIndex]['Name']);
                $('#tempViewModal .modal-body').html(`
                    <img class="img-fluid" src="`+TemplateArr[SelectIndex]['Pic']+`"/>
                `);
                if(typeof TempFolder[NameKey] == 'undefined'){
                    $('#installBtn').html('安装');
                    $('#installBtn').addClass('btn-primary').removeClass('btn-danger').removeAttr("disabled");
                }else{
                    $('#installBtn').html('已安装');
                    $('#installBtn').addClass('btn-danger').removeClass('btn-primary').attr("disabled", "disabled");
                }
                $('#tempViewModal').modal();
            })
            $('.InstallBtn').click(function(){ // 安装
                if(!confirm("安装模板覆盖数据库，请先备份数据库，再安装")) return;
                let Index = $(this).attr('data-index');
                let NameKey = TemplateArr[Index]['NameKey'];
                if(typeof TempFolder[NameKey] != 'undefined'){
                    alert('已安装，请先删除，再安装');return;
                }
                $('#LoadingModel').modal();
                $.get('/admin/api/installTemplate', {TemplatesId:TemplateArr[Index]['TemplatesId']}, function(Res){
                    if(Res.Code != 0){
                        alert(Res.Msg);
                        $('#LoadingModel').modal('hide');
                        return;
                    }
                    alert('安装成功');
                    location.reload();
                }, 'json')
            })
            $('.BuyBtn').click(function(){
                let Index = $(this).attr('data-index');
                $.get('/admin/api/paytp', {TemplatesId:TemplateArr[Index]['TemplatesId']}, function(Res){
                    if(Res.Code != 0){
                        alert(Res.Msg);return;
                    }
                    $('#QrCode').html('<img src="'+PlatformUrl+Res.Data.Path+'">');
                    $('#QrCodeStr').html(Res.Data.Body);
                    $('#PayModal').modal('show')
                    GetPayStatus(Res.Data.OrderId)
                }, 'json')
            })
        })
    </script>
</body>
</html>
