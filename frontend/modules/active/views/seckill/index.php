


<img style="display: none;" width="320" height="280" class="lazy" data-url="" >
<div class="main">
    <div class="seckillBanner"><div class="bannerItem"></div></div>
    <div class="seckillMain">
        <div class="seckillTag"></div>
        <div class="seckillOpt">
            <ul class="optList clearfix" id="container">
                <div id="content">

                </div>
                <div class="no_product" id="no_product" >目前没有任何活动商品</div>
            </ul>

        </div>
    </div>
</div>
<script type="text/javascript">
    /**
     * 时间倒计时
     * @param times
     * @param Element
     * @constructor
     */
    function GetRTime(times,Element){
        var t = times;
        var d=Math.floor(t/60/60/24);
        var h=Math.floor(t/60/60%24);
        var m=Math.floor(t/60%60);
        var s=Math.floor(t%60);
        Element.html("仅剩：" + d + " 天 " + h + " 时 "+ m + " 分 " +  s + " 秒 ");

    }
    var token = "<?php echo Yii::app()->request->csrfToken;?>";
    $(function(){
        var range = 100;             //距下边界长度/单位px
        var elemt = 500;           //插入元素高度/单位px
        var totalheight = 0;
        var pagenum = 1;
        var main = $("#content");                     //主体元素
        function add(datalist){
            var htmls = "";
            for(num=0; num < datalist.length; num++) {
                var starttime = datalist[num]['difference_start'];
                var endtime = datalist[num]['difference_end'];
                var attr_html = "endtime='"+endtime+"' starttime='"+starttime+"' stock='"+datalist[num]['stock']+"' ";

                htmls += "<li stock='"+datalist[num]['stock']+"' "+attr_html+" class='optItem ";
                if (datalist[num]['difference_start'] > 0) {
                    htmls += "build";
                }else{
                    if (datalist[num]['stock'] < 1) {
                        htmls += "soldOut";
                    }
                }

                htmls += " clearfix'><a "+attr_html+" href='" + datalist[num]['url'] + "'  class='itemImg fl' target='_blank' "

                htmls += "title='" + datalist[num]['product_name'];
                htmls += "'><img class='lazy'  data-url='";
                htmls += "<?php echo IMG_DOMAIN?>/" + datalist[num]['thumbnail'];
                htmls += "' alt='";
                htmls += datalist[num]['product_name'];
                htmls += "' width='280' height='280'/></a><div class='itemDec fr'><div class='titH1'title='"+datalist[num]['product_name']+"' ><span "+attr_html+" class='seckillTime ";
                if(datalist[num]['difference_start'] < 0){
                    htmls += "seckillTime2 "
                }
                htmls += " fl'><i class='sTimeIco' "+attr_html+" >仅剩："
                htmls += "00天00时00分00秒";
                htmls += "</i></span>"
                htmls += "<p>"+datalist[num]['product_name']+"</p>";
                htmls += "</div><p><span class='itemPrice'>秒杀价：<s class='pink'>￥<b>";

                htmls += datalist[num]['active_price'];

                htmls += "</b></s></span></p><p><span class='itemStock'>库存：" + datalist[num]['stock'];
                htmls += "</span></p><div class='itemBtn clearfix'>";

                htmls += "<a stock='"+datalist[num]['stock']+"' "+attr_html+" class='seckillPrompt fl' target='_blank' href='" + datalist[num]['url'] + "' >";
                if (datalist[num]['difference_start'] > 0) {
                    htmls += "即将开始</a></div>";
                }else{
                    htmls += "立即秒杀</a></div>";
                }
                if(datalist[num]['stock'] < 6 && datalist[num]['stock'] > 0 && starttime < 0){
                    htmls +="<span class='item_prompt'  >仅剩"+datalist[num]['stock']+"件，请尽快购买</span>";
                }
                htmls +="</div><i class='itemTag' ></i><span class='soldOutTag'></span></li>";
            }

            return htmls;
        }

        function runData(pagenum,limit){

		  $.ajax({
			  type: 'POST',
			  url: "<?php echo $this->createAbsoluteUrl('seckill/getListData')?>",
			  data: {'page': pagenum,'limit':limit, 'YII_CSRF_TOKEN': token},
			  dataType: 'json',
			  cache : false,
			  success: function(datas){

                    if (datas['status'] == 1) {
                        if(datas['datalist'] == ''){
                            return false;
                        }

                        var htmls = add(datas['datalist']);
                        main.append(htmls);

                        $('#no_product').css('display','none');

                        LAZY.init();
                        LAZY.run();
                        var itime = 1;
                        setInterval(function(){
                            $('.seckillTime').each(function(){
                                var starttime = $(this).attr('starttime');

                                if((starttime - itime) < 0){
                                    $(this).addClass('seckillTime2');
                                }
                            })
                            $(".optItem").each(function(){
                                var starttime = $(this).attr('starttime');
                                var endtime = $(this).attr('endtime');
                                var stock = $(this).attr('stock');

                                if((starttime - itime) > 0){
                                    $(this).addClass('build');
                                }else{
                                    $(this).removeClass('build');
                                    if(stock < 0){
                                        $(this).addClass('soldOut');
                                    }
                                }
                            })

                            $('a.seckillPrompt').each(function(){
                                var starttime = $(this).attr('starttime');
                                var endtime = $(this).attr('endtime');
                                var stock = $(this).attr('stock');
                                if(starttime - itime > 0){
                                    $(this).html("即将开始");
                                }else{
                                    if(stock > 0){
                                        $(this).html("立即秒杀");
                                    }else{
                                        $(this).html("卖光了");
                                    }
                                }
                            })

                            $('.sTimeIco').each(function(){
                                var starttime = datas['startTime'] - itime;
                                var endtime = datas['endTime'] - itime;
                                if(starttime > 0){
                                    GetRTime(starttime,$(this));
                                }else {
                                    if(endtime > 0){
                                        GetRTime(endtime,$(this));
                                    }else{
                                        $(this).html("仅剩：00 天 00 时 00 分 00 秒 ");
                                    }
                                }
                            })
                            itime++;
                        },1000);



                    }else if(datas['status'] == 3){
                        $('#no_product').css('display','block');
                    }
			  }
		  });

        }

        runData(pagenum,30);
        pagenum = pagenum+1;

        $(window).scroll(function() {
            var srollPos = $(window).scrollTop();    //滚动条距顶部距离(页面超出窗口的高度)
            totalheight = parseFloat($(window).height()) + parseFloat(srollPos);
            if ($(document).height() <= totalheight) {
                runData(pagenum,0);
                pagenum++;
            }
        })


    });
</script>