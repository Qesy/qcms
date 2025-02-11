(function ($) {

    let Name = "Pagination";

    $.fn.Pagination = function (options) {
        let myDoom = this;
        // 默认值
        options = options || {};
        options.page = options.page || 1;   // 当前页数
        options.count = options.count || 1;       // 总数量
        options.limit = options.limit || 10;      // 每页数量
        options.groups = options.groups || 5;     // 连续出现几个页码按钮
        options.prev = options.prev || '<i class="bi bi-chevron-left"></i>';   // 自定义上一页按钮
        options.next = options.next || '<i class="bi bi-chevron-right"></i>';   // 自定义下一页按钮
        options.first = options.first || '<i class="bi bi-chevron-bar-left"></i>';   // 自定义首页按钮
        options.last = options.last || '<i class="bi bi-chevron-bar-right"></i>';     // 自定义尾页按钮
        options.onPageChange = options.onPageChange || function (page) {console.log(page)};

        let PageFloat = Math.floor(options.groups / 2), // 页码浮动量    10/2 = 5
            maxPage = Math.ceil(options.count / options.limit), // 总页数
            pageListHtml = "";

        let i = options.page - PageFloat;
        if (options.page + PageFloat > maxPage ){ i = maxPage - (PageFloat * 2);} // 100 - 5 * 2 = 90
        if (i < 1){i = 1 ;}

        do {
            let Selected = "";
            if (i === options.page){
                Selected = 'active';
            }
            pageListHtml += '<li class="page-item page-list '+Selected+'"><a class="page-link" href="#">'+i+'</a></li>';
            i ++;
            // 判断显示页数
            // i 小于 当前页 + 页码浮动量
            // let a = (i <= (options.nowPage + PageFloat));
            // 如果当前页 - 页码浮动量 小于0 则i 小于 在之前的基础上再多 (浮动 + 2 - 当前页) 个分页
            // let b = (options.nowPage - PageFloat <= 0 && i < (options.nowPage + PageFloat + (PageFloat + 2 - options.nowPage) ));
            // i 永远 小于最大页数
            // let c = (i <= maxPage);
            // debugger;
        }while ((i <= (options.page + PageFloat) || options.page - PageFloat <= 0 && i < (options.page + PageFloat + (PageFloat + 2 - options.page) ))  && i <= maxPage )

        let html = '<nav aria-label="Page navigation">' +
            '<ul class="pagination">' +
            '<li class="page-item"><a href="#" class="page-link pager-item" aria-label="first" title="回到首页"><span aria-hidden="true">'+ options.first +'</span></a></li>' +
            '<li class="page-item"><a href="#" class="page-link pager-item" aria-label="prev" title="上一页"><span aria-hidden="true">'+ options.prev +'</span></a></li>' +
            pageListHtml +
            '<li class="page-item"><a href="#" class="page-link pager-item" aria-label="next" class="下一页"><span aria-hidden="true">'+ options.next +'</span></a></li>' +
            '<li class="page-item"><a href="#" class="page-link pager-item" aria-label="last" title="前往尾页"><span aria-hidden="true">'+ options.last +'</span></a></li>' +
            '</ul></nav>';


        // 清空之前的内容然后再添加新内容
        myDoom.off('click');
        myDoom.empty();
        myDoom.append(html);

        // 切换页码
        myDoom.on('click', '.pagination .page-list', function() {
            options.page = parseInt($(this).text());
            myDoom.Pagination(options);
            options.onPageChange(parseInt($(this).text()));
        });
        // 首页、尾页、上一页、下一页
        myDoom.on('click','.pagination .pager-item',function () {
            let label = $(this).attr('aria-label');
            let page = 1;
            if (label === 'first'){
                page = 1;
            }
            else if (label === 'prev'){
                page = options.page - 1;
                if (page < 1 )    page = 1;
            }else if (label === 'next'){
                page = options.page +1;
                if (page > maxPage) page = maxPage;
            }else if (label === 'last'){
                page = maxPage;
            }
            options.page = page;
            myDoom.Pagination(options);
            options.onPageChange(page);
        })
    }
}(jQuery));
