
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



                            </div>
                            <div class="panel-wrapper ">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-4 mb-4">

                                            <form >
                                                  <div class="form-group">
                                                    <label for="InputPhone">账号</label>
                                                    <input type="input" class="form-control" id="Phone" placeholder="请输入你的账号">
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="InputPwd">密码</label>
                                                    <input type="password" class="form-control" id="Pwd" placeholder="请输入你的密码">
                                                  </div>
                                                  <button type="button" id="BindBtn" class="btn btn-primary mr-2">绑定账号</button>
                                                  <a type="href" href="https://www.q-cms.cn/" target="_blank" class="btn btn-success">注册</a>
                                                  <small>你还未绑定账号</small>
                                                </form>
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
            <a target="_blank" href="https://www.q-cms.cn/templates.html" class="btn btn-primary">去官网下载</a>
            <!-- <button type="button" class="btn btn-primary" id="installBtn">安装</button> -->
          </div>
        </div>
      </div>
    </div>

    <!-- jQuery -->
    <?=$this->LoadView('admin/common/js')?>
    <script type="text/javascript">
        $('#BindBtn').click(function(){
            if($('#Phone').val() == ''){
                alert('账号不能为空');return false;
            }
            if($('#Pwd').val() == ''){
                alert('密码不能为空');return false;
            }
            $.post('/admin/api/ajaxBind', {Phone:$('#Phone').val(), Pwd:$('#Pwd').val()}, function(Res){
                if(Res.Code != 0){
                    alert(Res.Msg); return;
                }
                alert('绑定账号成功');
                location.reload();
            }, 'json')
        })
    </script>
</body>
</html>
