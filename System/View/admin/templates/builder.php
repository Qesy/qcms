<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>
        <?=WEB_TITLE?>
    </title>
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
                        <h5 class="txt-light">
                            <?=$this->PageTitle?>
                        </h5>
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
                        <div class="panel panel-default card-view">
                            <div class="panel-heading mb-3 pb-2 d-flex justify-content-between align-items-center border-bottom">
                                <h5 class="txt-dark">
                                    <?=$this->PageTitle2?>
                                </h5>
                            </div>
                            <div class="panel-wrapper ">
                                <div class="panel-body">

                                    <div>
                                    <?
                                    foreach($LabelArr as $k => $v){
                                        $BtnColor = ($k == 'include') ? 'btn-primary' : 'btn-default';
                                        echo '<button class="btn '.$BtnColor.' mr-2 DisplayBtn" data="'.$k.'">'.$v.'</button>';
                                    }
                                    ?>
                                    </div>
                                    <div class="my-3 DemoDiv d-none" data="include">
                                        <h5 >引入页面</h5>
                                        <div class="mb-2">引入一些通用代码页面，比如一个网站的导航和底部都是一样的，就单独做一个组件，通过include标签引入</div>
                                        <textarea class="form-control text-dark mb-3 p-2" rows="5">{{include  filename='component_header.html'/}}</textarea>
                                        <h5 >标签说明</h5>
                                        <div>filename : 文件名</div>
                                    </div>
                                    <div class="my-3 DemoDiv d-none" data="label">
                                        <h5 >自定义标签</h5>
                                        <div class="mb-2">后台自定义一些文字，列表等代码，在网站任意地方调用，通常用于广告代码，特殊JS统计代码等</div>
                                        <textarea class="form-control text-dark mb-3 p-2" rows="5">{{label:testlabel}}</textarea>
                                        <h5 >标签说明</h5>
                                        <div>label : 标签调用名 （后台创建的时候命名）</div>
                                    </div>
                                    <div class="my-3 DemoDiv d-none" data="global">
                                        <h5 >全局标签</h5>
                                        <div class="mb-2">网站模板任何页面都可以调用的标签</div>
                                        <textarea class="form-control text-dark mb-3 p-2" rows="5">{{qcms:WebName}}</textarea>
                                        <h5 >标签说明</h5>
                                        <div>
                                            {{qcms:domain}} ： 网站域名<br>
                                            {{qcms:static}} ： 静态文件夹路径 （/Static/）<br>
                                            {{qcms:pathImg}} ： 图片文件夹路径 （/Static/images/）<br>
                                            {{qcms:pathJs}} ： JS文件夹路径 （/Static/scripts/）<br>
                                            {{qcms:pathCss}} ： CSS文件夹路径 （/Static/styles/）<br>
                                            {{qcms:Scheme}} ： 协议 （用于区分 http, https）<br>
                                            {{qcms:WebName}} ： 网站名字<br>
                                            {{qcms:Logo}} ： 网站LOGO图片地址<br>
                                            {{qcms:Email}} ： 电子邮箱<br>
                                            {{qcms:Icp}} ： ICP备案号<br>
                                            {{qcms:WaBeian}} ： 网安备案号<br>
                                            {{qcms:Keywords}} ： SEO关键字<br>
                                            {{qcms:Description}} ： SEO简介<br>
                                            {{qcms:Copyright}} ： 网站版权<br>
                                            {{qcms:RegLenMin}} ： 注册最小长度<br>
                                            {{qcms:RegLenMax}} ： 注册最大长度<br>
                                            {{qcms:StatsCode}} ： 统计代码<br>
                                            {{qcms:crumbs}} ： 面包屑地址<br>
                                        </div>
                                    </div>
                                    <div class="my-3 DemoDiv d-none" data="cate">
                                        <h5 >分类标签</h5>
                                        <div class="mb-2">分类页和详情页专属标签，比如分类名等</div>
                                        <textarea class="form-control text-dark mb-3 p-2" rows="5">{{qcms:Cate_Name}}</textarea>
                                        <h5 >标签说明</h5>
                                        <div>
                                            {{qcms:Cate_CateId}} ： 分类ID<br>
                                            {{qcms:Cate_PCateId}} ： 分类上级ID<br>
                                            {{qcms:Cate_Name}} ： 分类名<br>
                                            {{qcms:Cate_Pic}} ： 分类图片<br>
                                            {{qcms:Cate_IsShow}} ： 分类显示（1：显示，2：不显示）<br>
                                            {{qcms:Cate_IsLink}} ： 是否外链 （1：外链， 2 不是外链）<br>
                                            {{qcms:Cate_LinkUrl}} ： 外链地址<br>
                                            {{qcms:Cate_SeoTitle}} ： SEO标题<br>
                                            {{qcms:Cate_Keywords}} ： SEO关键字<br>
                                            {{qcms:Cate_Description}} ： SEO简介<br>
                                            {{qcms:Cate_Content}} ： 分类内容详情<br>
                                            {{qcms:Cate_PinYin}} ： 全拼<br>
                                            {{qcms:Cate_PY}} ： 拼音首字母<br>
                                        </div>
                                    </div>
                                    <div class="my-3 DemoDiv d-none" data="detail">
                                        <h5 >详情页标签</h5>
                                        <div class="mb-2">文章详情页面专属标签，比如文章标题，文章内容等</div>
                                        <textarea class="form-control text-dark mb-3 p-2" rows="5">{{qcms:Detail_Title}}</textarea>
                                        <h5 >标签说明</h5>
                                        <div>
                                            {{qcms:Detail_Id}} ： 详情ID<br>
                                            {{qcms:Detail_CateId}} ： 分类ID<br>
                                            {{qcms:Detail_Title}} ： 标题<br>
                                            {{qcms:Detail_STitle}} ：短标题<br>
                                            {{qcms:Detail_Tag}}： Tag<br>
                                            {{qcms:Detail_Pic}} ：图片<br>
                                            {{qcms:Detail_Source}} ： 来源<br>
                                            {{qcms:Detail_Author}} ： 作者<br>
                                            {{qcms:Detail_Keywords}} ： SEO关键字<br>
                                            {{qcms:Detail_Description}} ： SEO简介<br>
                                            {{qcms:Detail_TsAdd}} ： 添加时间（UNIX时间戳）<br>
                                            {{qcms:Detail_TsUpdate}} ： 最后更新时间（UNIX时间戳）<br>
                                            {{qcms:Detail_ReadNum}} ： 浏览次数<br>
                                            {{qcms:Detail_Coins}} ： 所需金币<br>
                                            {{qcms:Detail_Money}} ： 所需费用<br>
                                            {{qcms:Detail_Color}} ： 标题颜色<br>
                                            {{qcms:Detail_UserId}} ： 发布人ID<br>
                                            {{qcms:Detail_Good}} ： 好评数<br>
                                            {{qcms:Detail_Bad}} ： 差评数<br>
                                            {{qcms:Detail_Content}} ： 内容详情<br>
                                            {{qcms:Detail_IsLink}}  ： 是否外链 （1：外链， 2：不是外链）<br>
                                            {{qcms:Detail_LinkUrl}} ： 外链地址<br>
                                            {{qcms:Detail_IsBold}} ： 是否加粗 （1：加粗， 2：不加粗）<br>
                                            {{qcms:Detail_IsPic}} ： 是否有缩略图 （1：有， 2 没有）<br>
                                            {{qcms:Detail_IsSpuerRec}} ： 是否特推（1是， 2：不是）<br>
                                            {{qcms:Detail_IsHeadlines}} ： 是否头条（1是， 2：不是）<br>
                                            {{qcms:Detail_IsRec}} ： 是否推荐（1是， 2：不是）<br>
                                            {{qcms:Detail_PinYin}} ： 全拼<br>
                                            {{qcms:Detail_PY}} ： 拼音首字母<br>
                                            {{qcms:Detail_Prev}} : 上一篇<br>
                                            {{qcms:Detail_Next}} ： 下一篇<br>
                                        </div>
                                    </div>
                                    <div class="my-3 DemoDiv d-none" data="page">
                                        <h5 >单页标签</h5>
                                        <div class="mb-2">单页专属标签，比如单页名字，单页内容等</div>
                                        <textarea class="form-control text-dark mb-3 p-2" rows="5">{{qcms:Page_Name}}</textarea>
                                        <h5 >标签说明</h5>
                                        <div>
                                            {{qcms:Page_PageId}} ： 单页ID<br>
                                            {{qcms:Page_Name}} ： 单页名字<br>
                                            {{qcms:Page_SeoTitle}} ： SEO标题<br>
                                            {{qcms:Page_Keywords}} ： SEO关键字<br>
                                            {{qcms:Page_Description}} ： SEO简介<br>
                                            {{qcms:Page_Content}} ： 内容<br>
                                        </div>
                                    </div>

                                    <div class="my-3 DemoDiv d-none" data="menu">
                                        <h5 >一级菜单列表</h5>
                                        <div class="mb-2">一级菜单列表，循环列表</div>

<textarea class="form-control text-dark mb-3 p-2" rows="5">
{{menu PCateId='0'}}
    <a href="{{qcms:Menu_Url}}">{{qcms:Menu_Name}}</a>
{{/menu}}
</textarea>
                                        <h5 >属性说明</h5>
                                        <div class="mb-2">
                                            PCateId : 上级分类ID （不填默认为0）
                                        </div>
                                        <h5 >标签说明</h5>
                                        <div>
                                            {{qcms:Menu_CateId}} ： 分类ID<br>
                                            {{qcms:Menu_PCateId}} ： 上级分类ID<br>
                                            {{qcms:Menu_Name}} ： 分类名字<br>
                                            {{qcms:Menu_Pic}} ： 分类图片<br>
                                            {{qcms:Menu_SeoTitle}} ： SEO标题<br>
                                            {{qcms:Menu_Keywords}} ： SEO关键字<br>
                                            {{qcms:Menu_Description}} ： SEO简介<br>
                                            {{qcms:Menu_Url}} ： 分类链接<br>
                                            {{qcms:Menu_HasSub}} ： 是否包含子分类 （1：是 0：否）<br>
                                            {{qcms:Menu_i}} ： 自曾数（从0开始）<br>
                                        </div>
                                    </div>

                                    <div class="my-3 DemoDiv d-none" data="smenu">
                                        <h5 >二级菜单列表</h5>
                                        <div class="mb-2">二级菜单列表，循环列表</div>

<textarea class="form-control text-dark mb-3 p-2" rows="5">
{{smenu PCateId='0'}}
    <a href="{{qcms:sMenu_Url}}">{{qcms:sMenu_Name}}</a>
{{/smenu}}
</textarea>
                                        <h5 >属性说明</h5>
                                        <div class="mb-2">
                                            PCateId : 上级分类ID （不填默认为0）
                                        </div>
                                        <h5 >标签说明</h5>
                                        <div>
                                            {{qcms:sMenu_CateId}} ： 分类ID<br>
                                            {{qcms:sMenu_PCateId}} ： 上级分类ID<br>
                                            {{qcms:sMenu_Name}} ： 分类名字<br>
                                            {{qcms:sMenu_Pic}} ： 分类图片<br>
                                            {{qcms:sMenu_SeoTitle}} ： SEO标题<br>
                                            {{qcms:sMenu_Keywords}} ： SEO关键字<br>
                                            {{qcms:sMenu_Description}} ： SEO简介<br>
                                            {{qcms:sMenu_Url}} ： 分类链接<br>
                                            {{qcms:sMenu_HasSub}} ： 是否包含子分类 （1：是 0：否）<br>
                                            {{qcms:sMenu_i}} ： 自曾数（从0开始）<br>
                                        </div>
                                    </div>
                                    <div class="my-3 DemoDiv d-none" data="ssmenu">
                                        <h5 >三级菜单列表</h5>
                                        <div class="mb-2">三级菜单列表，循环列表</div>

<textarea class="form-control text-dark mb-3 p-2" rows="5">
{{ssmenu PCateId='0'}}
    <a href="{{qcms:ssMenu_Url}}">{{qcms:ssMenu_Name}}</a>
{{/ssmenu}}
</textarea>
                                        <h5 >属性说明</h5>
                                        <div class="mb-2">
                                            PCateId : 上级分类ID （不填默认为0）
                                        </div>
                                        <h5 >标签说明</h5>
                                        <div>
                                            {{qcms:ssMenu_CateId}} ： 分类ID<br>
                                            {{qcms:ssMenu_PCateId}} ： 上级分类ID<br>
                                            {{qcms:ssMenu_Name}} ： 分类名字<br>
                                            {{qcms:ssMenu_Pic}} ： 分类图片<br>
                                            {{qcms:ssMenu_SeoTitle}} ： SEO标题<br>
                                            {{qcms:ssMenu_Keywords}} ： SEO关键字<br>
                                            {{qcms:ssMenu_Description}} ： SEO简介<br>
                                            {{qcms:ssMenu_Url}} ： 分类链接<br>
                                            {{qcms:ssMenu_HasSub}} ： 是否包含子分类 （1：是 0：否）<br>
                                            {{qcms:ssMenu_i}} ： 自曾数（从0开始）<br>
                                        </div>
                                    </div>

                                    <div class="my-3 DemoDiv d-none" data="list">
                                        <h5 >列表标签</h5>
                                        <div class="mb-2">列表形式调用内容数据</div>

<textarea class="form-control text-dark mb-3 p-2" rows="5">
{{list Module='article' CateId='1' Row='10'}}
    <a href="{{qcms:ssMenu_Url}}">{{qcms:ssMenu_Name}}</a>
{{/list}}
</textarea>
                                        <h5 >属性说明</h5>
                                        <div class="mb-2">
                                            Module : 模型调用名，默认 ：article （article：文章, product:产品， album：相册， down：下载 ）<br>
                                            Row：行数，默认：10<br>
                                            CateId : 分类ID， 默认：0 （模型下所有文章）<br>
                                            Sort ： 排序方式， 默认 ：default （default：按排序正序，ReadNum：按阅读数倒叙，TsUpdate：按更新时间倒叙， Good：按好评倒叙）<br>
                                        </div>
                                        <h5 >标签说明</h5>
                                        <div>
                                            {{qcms:List_Id}} ： 内容ID<br>
{{qcms:List_Title}} ： 标题<br>
{{qcms:List_STitle}} ： 短标题<br>
{{qcms:List_Tag}} ： Tag<br>
{{qcms:List_Pic}} ： 图片<br>
{{qcms:List_Source}} ： 来源<br>
{{qcms:List_Author}} ： 作者<br>
{{qcms:List_Keywords}} ： SEO关键字<br>
{{qcms:List_Description}} ： SEO简介<br>
{{qcms:List_TsAdd}} ： 添加时间<br>
{{qcms:List_TsUpdate}} ： 更新时间<br>
{{qcms:List_ReadNum}} ： 阅读数量<br>
{{qcms:List_Coins}} ： 所需金币<br>
{{qcms:List_Money}} ： 所需费用<br>
{{qcms:List_Color}} ： 标题颜色<br>
{{qcms:List_UserId}} ： 用户ID<br>
{{qcms:List_Good}} ： 好评数<br>
{{qcms:List_Bad}} ： 差评数<br>
{{qcms:List_IsLink}} ： 是否外链 （1：外链， 2：不是外链）<br>
{{qcms:List_LinkUrl}} ： 外链地址<br>
{{qcms:List_IsBold}} ： 是否加粗 （1：加粗， 2：不加粗）<br>
{{qcms:List_IsPic}} ： 是否有缩略图 （1：有， 2 没有）<br>
{{qcms:List_IsSpuerRec}} ： 是否特推（1是， 2：不是）<br>
{{qcms:List_IsHeadlines}} ： 是否头条（1是， 2：不是）<br>
{{qcms:List_IsRec}} ： 是否特推（1是， 2：不是）<br>
{{qcms:List_PinYin}} ： 拼音全拼<br>
{{qcms:List_PY}} ： 拼音首字母<br>
{{qcms:List_i}} ： 自曾数（从0开始）<br>
{{qcms:List_Url}} ： 内容地址<br>
{{qcms:List_CateId}} ： 分类ID<br>
{{qcms:List_CateName}} ： 分类名<br>
{{qcms:List_CatePic}} ： 分类图片<br>
{{qcms:List_CateUrl}} ： 分类地址<br>
                                        </div>
                                    </div>


                                    <div class="my-3 DemoDiv d-none" data="loop">
                                        <h5 >万能标签</h5>
                                        <div class="mb-2">列表形式调用数据库里任何数据</div>

<textarea class="form-control text-dark mb-3 p-2" rows="5">
{{loop sql='select * from qc_user'}}
    用户昵称：{{qcms:Loop_NickName}}
    用户头像： <img src="{{qcms:Loop_Head}}" style="height: 100px;width:100px;" />
{{/loop}}
</textarea>
                                        <h5 >属性说明</h5>
                                        <div class="mb-2">
                                            sql : SQL语句
                                        </div>
                                        <h5 >标签说明</h5>
                                        <div>
                                            {{qcms:loop_字段名}} ： 字段名就是标签，字段意思请查看数据库字段
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
    <script type="text/javascript">
        var SelectLabel = 'include';
        $(function(){
            DemoDivView();
            $('.DisplayBtn').click(function(){

                SelectLabel = $(this).attr('data');
                DemoDivView();
            })
        })

        var DemoDivView = function(){
            $('.DisplayBtn').removeClass('btn-primary').addClass('btn-default');
            $('.DisplayBtn[data='+SelectLabel+']').removeClass('btn-default').addClass('btn-primary');
            $('.DemoDiv').addClass('d-none');
            $('.DemoDiv[data='+SelectLabel+']').removeClass('d-none');
        }
    </script>
</body>

</html>