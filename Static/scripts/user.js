$(function(){
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
    ClassicEditor.create( document.querySelector( '.Input_Editor' ), {
    toolbar: {
      items: [
        'heading',
        '|',
        'Alignment',
        'fontColor',
        'Highlight',
        'fontSize',
        'bold',
        'italic',
        'link',
        'removeFormat',
        'bulletedList',
        'numberedList',
        'imageUpload',
        'blockQuote',
        'insertTable',
        'mediaEmbed',
        'undo',
        'redo',
        'Image toolbar',
      ]
    },
     ckfinder: {
      uploadUrl: '/admin/api/ckUpload.html',
      height:'300',
     }
    })
  .then( editor => {
    window.editor = editor;
  } )
  .catch( err => {
    console.log('no editor');
    //console.error( err.stack );
  });

})


var IsSuccess = function(Res){
    if(Res.Code != 0){
        alert(Res.Msg);
        return false;
    }
    return true;
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
