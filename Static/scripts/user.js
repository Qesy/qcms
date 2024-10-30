
var IsEditorCreat = false;
var URL_ROOT = "/";
var UploadBtn = {}, interval;
var UploadFilePathArr = [];
var SelectUploadName = '';
var FileViewArr = [];
var Limit = 24;
var AttrState = 2; //批量操作属性状态
var t1; // 时间定时器
$(function(){
    $('#PayModal').on('hidden.bs.modal', function (e) {
        console.log('关闭定时器');
        window.clearInterval(t1);
    })
    ContentLinkReset();
    $('#Attr_IsLink').change(function(){
        ContentLinkReset();
    })
    $('.browseBtn').on('click', function(){
        SelectUploadName = $(this).attr('data-name')
        $('#FileBrowseTitleView').html(`<a class="browseBackBtn" data-name="`+SelectUploadName+`" href="javascript:void(0);">根目录</a>`);
        browseFile('')

    })
    $('#FileBrowseView').on('dblclick', '.subBrowseBtn', function(){
        let Path = $(this).attr('data-path');
        $('#FileBrowseTitleView').html(`<a class="browseBackBtn" data-name="`+SelectUploadName+`" href="javascript:void(0);">根目录</a> > `+Path);
        browseFile(Path)
    })
    $('#FileBrowseTitleView').on('click', '.browseBackBtn', function(){
        $('#FileBrowseTitleView').html(`<a class="browseBackBtn" data-name="`+SelectUploadName+`" href="javascript:void(0);">根目录</a>`);
        browseFile('')
    })

    $('#FileBrowseView').on('dblclick', '.selectFileBtn', function(){
        $('#Img_'+SelectUploadName).val($(this).attr('src'));
        $('#FileBrowseModel').modal('hide');
    })

    $('#ContentbatchMoveBtn').click(function(){
        let Ids = getAllChecked();
        if(Ids.length == 0){
            alert('没有选中任何内容');
            return;
        }
        $('#selectContentIds').val(Ids.join(','))
        $('#ContentMoveModal').modal();
    })
    $('#ContentMoveSubmitBtn').click(function(){
        let Ids = $('#selectContentIds').val();
        if(Ids == '') {
            alert('没有选中任何内容');
            return;
        }
        let selectContentCateId = $('#selectContentCateId').val();
        $.post('/admin/api/contentMove', {Ids:Ids, ModelId:ModelId, CateId:$('#selectContentCateId').val()}, function(Res){
            if(Res.Code != 0){
                alert(Res.Msg);return;
            }
            location.reload();
        }, 'json')
    })

    $('#SelectAllBtn').change(function(){
        $('.CheckBoxOne').prop('checked' , $(this).prop('checked'))
    })
    $('#ContentbatchAttrAddBtn').click(function(){ //批量增加属性
        let Ids = getAllChecked();
        if(Ids.length == 0){
            alert('没有选中任何内容');
            return;
        }
        AttrState = 1;
        $('#ContentAttrTitleModal').html('批量增加属性')
        $('#ContentAttrModal').modal();
    })
    $('#ContentbatchAttrDelBtn').click(function(){ //批量删除属性
        let Ids = getAllChecked();
        if(Ids.length == 0){
            alert('没有选中任何内容');
            return;
        }
        AttrState = 2;
        $('#ContentAttrTitleModal').html('批量删除属性')
        $('#ContentAttrModal').modal();
    })
    $('#ContentBatchSubmitBtn').click(function(){
        let Ids = getAllChecked();
        if(Ids.length == 0){
            alert('没有选中任何内容');
            return;
        }
        let Attrs = [];
        $('.ContentAttrBatch:checked').each(function(index, item){
            Attrs.push($(this).val())
        })
        if(Attrs.length == 0){
            alert('没有选中任何属性');
            return;
        }
        $.post('/admin/api/contentAttr', {Ids:Ids.join(','), Attrs:Attrs.join(','), 'Val':AttrState}, function(Res){
            if(Res.Code != 0){
                alert(Res.Msg);return;
            }
            location.reload();
        }, 'json')
        console.log(Attrs)
    })

    $('.colorpicker').colorpicker();
	$('.StateBtn').click(function(){
        let _this = this;
        let ErrState = $(this).prop("checked") ? false : true; // 回滚结果
		$.get(ChangeStateUrl, {'Id':$(this).attr('data'), 'Status':$(this).attr('dataState'), 'Field':$(this).attr('dataField')}, function(Res){
			if(Res.Code != 0) {
                alert(Res.Msg);
                $(_this).prop("checked", ErrState);
                return;
            }
			location.reload();
		}, 'json')
	})

    $('.tabBnt').click(function(){
        let Index = $(this).attr('data-index');
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');
        $('#Key_'+Index).removeClass('d-none');
        $('#Key_'+Index).siblings().addClass('d-none');
    })
    if($('.Input_Editor').length >0 ){
        $.each($('.Input_Editor'), function(k, v){
            EditorCreate(this)
        })
    }
    $('#Button_Editor').click(function(){
        if(!IsEditorCreat){
            EditorCreate(document.querySelector('#Input_Content'));
            $(this).removeClass('btn-success').addClass('btn-default').html('卸载编辑器')
        }else{
            EditorDestroy();
            $(this).removeClass('btn-default').addClass('btn-success').html('加载编辑器')

        }
    })
    if($('.uploadDiv').length > 0){
        $.each($('.uploadDiv'), function(k, v){
            CreatUpload($(this).attr('data'))
        })
    }
    $('#Button_VeriBtn').click(function(){
        window.open('https://www.q-cms.cn/');
    })
    $('.SortInput').change(function(){
        $.post('/admin/api/sort', {'Index':$(this).attr('data-index'), 'Type' : $(this).attr('data-type'), 'Sort':$(this).val()}, function(Res){
            if(Res.Code != 0){
                alert(Res.Msg);return;
            }
            location.reload();
        }, 'json')
    })
    $('#ContentState1Btn').click(function(){
        contentState('State', '1');
    })
    $('#ContentState2Btn').click(function(){
        contentState('State', '2');
    })
    $('#ContentbatchDel1Btn').click(function(){
        contentState('IsDelete', '1');
    })
    $('#ContentbatchDel2Btn').click(function(){
        contentState('IsDelete', '2');
    })
    $('#ContentbatchSR1Btn').click(function(){
        contentState('IsSpuerRec', '1');
    })
    $('#ContentbatchSR2Btn').click(function(){
        contentState('IsSpuerRec', '2');
    })
    $('#ContentbatchHL1Btn').click(function(){
        contentState('IsHeadlines', '1');
    })
    $('#ContentbatchHL2Btn').click(function(){
        contentState('IsHeadlines', '2');
    })
    $('#ContentbatchRE1Btn').click(function(){
        contentState('IsRec', '1');
    })
    $('#ContentbatchRE2Btn').click(function(){
        contentState('IsRec', '2');
    })
    $('#ContentbatchDel3Btn').click(function(){ //彻底删除
        let Ids = getAllChecked();
        if(Ids.length == 0){
            alert('没有选中任何内容');
            return;
        }
        $.post('/admin/api/deleteRec', {Ids:Ids.join(',')}, function(Res){
            if(Res.Code != 0){
                alert(Res.Msg);return;
            }
            location.reload();
        }, 'json')
    })

})

var browseFilePage = function(Page){
    $('#FileBrowseView').html('');
    let Start = ((Page-1)*Limit)
    let End = (Start+Limit) > FileViewArr.length ? FileViewArr.length : (Start+Limit);
    for(let i = Start; i< End; i++){
        let Val = FileViewArr[i];
        if(Val.Type == 'folder'){
            $('#FileBrowseView').append(`
                <div class="col-4 col-md-2 text-center"><image class="img-fluid subBrowseBtn" data-path="`+Val.Name+`" src="/Static/images/folder.png" ><div class="text-dark py-2 overflow-hidden">`+Val.Name+`</div></div>
            `);
        }else{
            $('#FileBrowseView').append(`
                <div class="col-4 col-md-2 text-center"><image class="img-fluid selectFileBtn" src="`+Val.Path+`" ><div class="text-dark py-2 overflow-hidden">`+Val.Name+`</div></div>
            `);
        }
    }
}

var browseFile = function(Path){
     $.post('/admin/api/fileBrowse', {'Path':Path}, function(Res){
        if(Res.Code != 0){
            alert(Res.Msg);return;
        }

        FileViewArr = Res.Data;
        browseFilePage(1);
       $("#FileBrowsePageModel").Pagination({
            page:1,
            count:Res.Data.length,
            limit:Limit,
            groups: 5,
            onPageChange:function (page) {
                browseFilePage(page);
            }
        });
        $('#FileBrowseModel').modal();
    }, 'json')
}

var contentState = function(Key, Val){
    let Ids = getAllChecked();
    if(Ids.length == 0){
        alert('没有选中任何内容');
        return;
    }
    $.post('/admin/api/contentState', {Ids:Ids.join(','), Key:Key, Val:Val}, function(Res){
        if(Res.Code != 0){
            alert(Res.Msg);return;
        }
        location.reload();
    }, 'json')
}

var getAllChecked = function(){
    let Ids = [];
    $('.CheckBoxOne:checked').each(function(index, item){
        Ids.push($(this).val())
    })
    return Ids;
}


var IsSuccess = function(Res){
    if(Res.Code != 0){
        alert(Res.Msg);
        return false;
    }
    return true;
}

function CreatUpload(DomId){
    UploadBtn[DomId] = $("#uploadImg_"+DomId);
    new AjaxUpload(UploadBtn[DomId], {
        action: "/admin/api/ajaxUpload.html",
        name: "filedata",
        onSubmit : function(file, ext){
            this.disable();
        },
        onComplete: function(file, response){
            var jsonArr = JSON.parse(response);
            if(jsonArr.Code != 0){
                this.enable();
                alert(jsonArr.Msg);return;
            }
            window.clearInterval(interval);
            this.enable();
            UploadFilePathArr.push(jsonArr.Data);
            $('#Input_FilePaths').val(UploadFilePathArr.join('|'));
            $("#Img_"+DomId).val(jsonArr.Data)
        }
    });
    $("#ViewImg_"+DomId).click(function(){ window.open($("#Img_"+DomId).val()); });
}

function ChartsFull(Title, DomIdStr, Categories, Series){
    Highcharts.chart(DomIdStr, {
        chart: {type: 'column'},
        title: {
            text: Title
        },
        subtitle: {
            //text: 'Source: WorldClimate.com'
        },
        xAxis: {
            categories: Categories,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: '量 (个/条)'
            }
        },
        series: Series
    });
}
function ChartsLineFull(Title, DomIdStr, Categories, Series){
    Highcharts.chart(DomIdStr, {
        title: {text: Title},
        xAxis: {
            categories: Categories,
            crosshair: true
        },
        yAxis: {
            title: {text: '量 (个/条)'}
        },
        series: Series,
    });
}

function barChart(DomID, Keys, Data){
	var barChart = document.getElementById(DomID).getContext('2d');
	var myBarChart = new Chart(barChart, {
		type: 'bar',
		data: {
			labels: Keys,
			datasets:Data,
		},
		/*{
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			datasets : [{
				label: "Sales",
				backgroundColor: 'rgb(23, 125, 255)',
				borderColor: 'rgb(23, 125, 255)',
				data: [3, 2, 9, 5, 4, 6, 4, 6, 7, 8, 7, 4],
			}],
		}*/
		options: {
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			},
		}
	});
}

function ContentLinkReset(){
    if($('#Attr_IsLink').prop("checked")){
        $('#Input_LinkUrl').parent().removeClass('d-none');
        $('#Input_Content').parent().addClass('d-none');
    }else{
        $('#Input_LinkUrl').parent().addClass('d-none');
        $('#Input_Content').parent().removeClass('d-none');
    }
}


function EditorDestroy(){
    IsEditorCreat = false;
    editor.destroy()
    .catch( error => {
        console.log( error );
    });
}


function EditorCreate(Dom){
    IsEditorCreat = true;
    //ClassicEditor.create( document.querySelector( Dom ), {
    ClassicEditor.create( Dom, {

    toolbar: {
      items: [
        'heading',
            '|',
            'bold',
            'italic',
            'link',
            'bulletedList',
            'numberedList',
            '|',
            'outdent',
            'indent',
            '|',
            'imageUpload',
            'blockQuote',
            'insertTable',
            'mediaEmbed',
            'undo',
            'redo',
            'alignment',
            'code',
            'codeBlock',
            'fontFamily',
            'fontColor',
            'fontBackgroundColor',
            'findAndReplace',
            'fontSize',
            'highlight',
            'htmlEmbed',
            'horizontalLine',
            'imageInsert',
            'pageBreak',
            'removeFormat',
            'specialCharacters',
            'sourceEditing',
            'superscript',
            'subscript',
            'strikethrough',
            //'restrictedEditingException',
            //'todoList',
            'underline'

      ]
    },
     /*ckfinder: {
      uploadUrl: '/admin/api/ckUpload.html',
      height:'300',
     }*/
    })
  .then( editor => {
    window.editor = editor;
    editor.plugins.get('FileRepository').createUploadAdapter = (loader)=>{
        return new UploadAdapter(loader);
    };

  } )
  .catch( err => {
    console.log('no editor');
  });



}

class UploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }
    upload() {
        return new Promise((resolve, reject) => {
        const data = new FormData();
        this.loader.file.then(realFile => {
            data.append('upload', realFile);
            data.append('allowSize', 10);//允许图片上传的大小/兆
            $.ajax({
                url: '/admin/api/ckUpload.html',
                type: 'POST',
                data: data,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function (Res) {
                    if (Res.uploaded) {
                        UploadFilePathArr.push(Res.url);
                        $('#Input_FilePaths').val(UploadFilePathArr.join('|'));
                        resolve({
                            default: Res.url
                        });
                    } else {
                        reject(data.msg);
                    }

                }
            });
        })



    });
    }
    abort() {
    }
}

var GetPayStatus = function (OrderId){
    t1 = window.setInterval(function() {
      $.post('/admin/api/payStatus.html', {'OrderId':OrderId}, function(Res){
        console.log('等待支付...');
        if(Res.Code != 0){
          $('#QrCodeModal').modal('hide');
          alert(Res.Msg);
          window.clearInterval(t1)
          return;
        }
        if(Res.Data == 1){
          $('#QrCodeModal').modal('hide');
          alert('购买成功');
          window.clearInterval(t1)
          location.reload();
          return;
        }
      }, 'json')
    },2000);
}