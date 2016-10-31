
        <script type="text/javascript">
            document.domain = '<?php echo SHORT_DOMAIN ?>';
        </script>
    <?php 
	$baseUrl = Yii::app()->baseUrl;
	$cs = Yii::app()->clientScript;
	$cs->registerScriptFile($baseUrl . "/js/highcharts/highcharts.js");
	$cs->registerScriptFile($baseUrl . "/js/highcharts/HighChartsOption.js");
    ?>
    <script src="<?php Yii::app()->baseUrl?>/js/iframeTools.source.js" type="text/javascript"></script>
    <script src="<?php Yii::app()->baseUrl?>/js/jquery.DatePicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var bodyWidth = $(".main").width();
            var ws = bodyWidth - 9;
            $(".t-com").width(ws);
            $(window).resize(function () {
                var bodyWidth = $(".main").width();
                var ws = bodyWidth - 9;
                $(".ws").width(ws);
            });
        });
     
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tab-come ').each(function () {
                $(this).find('tr:even td').addClass('even');
                $(this).find('tr:odd td').addClass('odd');
                $(this).find('tr:even th').addClass('even');
                $(this).find('tr:odd th').addClass('odd');
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tab-reg ').each(function () {
                $(this).find('tr:even td').css("background", "#eee");
                $(this).find('tr:odd td').css("background", "#fff");
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var $thi = $('body,html').find("#u_title li");
            $($thi).hover(function () {
                $(this).addClass("cur").siblings().removeClass("cur");
                var $as = $("#con .con_listbox").eq($("#u_title li").index(this));
                $as.show().siblings().hide();
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tab-reg2').find('.info').hover(function () {
                $(this).find('td').css({ "background": "rgba(255, 184, 0, 0.2)" });
                $(this).next('.user').find('td').css({ "background": "rgba(255, 184, 0, 0.2)" });
            }, function () {
                $(this).find('td').removeAttr("style");
                $(this).next('.user').find('td').removeAttr("style");
            });

            $('.tab-reg2').find('.user').hover(function () {
                $(this).find('td').css({ "background": "rgba(255, 184, 0, 0.2)" });
                $(this).prev().find('td').css({ "background": "rgba(255, 184, 0, 0.2)" });
            }, function () {
                $(this).find('td').removeAttr("style");
                $(this).prev().find('td').removeAttr("style");
            });
        });
    </script>
   
    <script type="text/javascript">
        var chartCount;
        var chartPrice;
        var nows = "<?php echo strtotime(date('Y-m-d')).'000';?>";
        var search = function () {
            var selectedTime = $('#monthpicker').val();

            var optionsCount = getChartOption("divCount", selectedTime + " 订单数量统计")
            var optionsPrice = getChartOption("divPrice", selectedTime + " 订单价格及供货价统计");
            $('#titleC').text(selectedTime + ' 订单数量概述（单位：个）');
            $('#titleP').text(selectedTime + ' 订单金额概述（单位：￥）');

            var width = $('#tableStatistics').width() - 30;
            optionsCount.chart.width = width;
            optionsPrice.chart.width = width;
            var url3 = "<?php echo Yii::app()->createUrl('statistics/orderCount2')?>";
            jQuery.getJSON(url3, { minTime: selectedTime },
                function (data) {
                   var data = eval([data]);
                    var date = new Date();
                    var CreateOrderCount = [];
                    var PayOrderCount = [];
                    var SignOrderCount = [];
                    var CreateOrderGaiPrice = [];
                    var CreateOrderPrice = [];
                    var PayOrderGaiPrice = [];
                    var PayOrderPrice = [];
                    var SignOrderGaiPrice = [];
                    var SignOrderPrice = [];

                    var strtableCount = "";
                    var strtablePrice = "";

                    optionsCount.series.splice(0, optionsCount.series.length);
                    optionsPrice.series.splice(0, optionsPrice.series.length);

                    //本月总量统计
                    var totalCreateOrderCount = 0;
                    var totalPayOrderCount = 0;
                    var totalSignOrderCount = 0;
                    var totalCreateOrderGaiPrice = 0;
                    var totalCreateOrderPrice = 0;
                    var totalPayOrderGaiPrice = 0;
                    var totalPayOrderPrice = 0;
                    var totalSignOrderGaiPrice = 0;
                    var totalSignOrderPrice = 0;
                    try {
                        $.each(data[0].Chart, function (i, line) {
                            
                  
                            date.setTime(line.Time+30200000);
                            CreateOrderCount.push([
                                date.getTime(),
                                line.CreateOrderCount
                            ]);
                            PayOrderCount.push([
                                date.getTime(),
                                line.PayOrderCount
                            ]);
                            SignOrderCount.push([
                                date.getTime(),
                                line.SignOrderCount
                            ]);

                            CreateOrderGaiPrice.push([
                                date.getTime(),
                                line.CreateOrderGaiPrice
                            ]);
                            CreateOrderPrice.push([
                                date.getTime(),
                                line.CreateOrderPrice
                            ]);
                            PayOrderGaiPrice.push([
                                date.getTime(),
                                line.PayOrderGaiPrice
                            ]);
                            PayOrderPrice.push([
                                date.getTime(),
                                line.PayOrderPrice
                            ]);
                            SignOrderGaiPrice.push([
                                date.getTime(),
                                line.SignOrderGaiPrice
                            ]);
                            SignOrderPrice.push([
                                date.getTime(),
                                line.SignOrderPrice
                            ]);

                            //本月总数
                            totalCreateOrderCount += line.CreateOrderCount;

                            totalCreateOrderGaiPrice += line.CreateOrderGaiPrice;
                            totalCreateOrderPrice += line.CreateOrderPrice;
                            totalPayOrderCount += line.PayOrderCount;
                            totalPayOrderGaiPrice += line.PayOrderGaiPrice;
                            totalPayOrderPrice += line.PayOrderPrice;
                            totalSignOrderCount += line.SignOrderCount;
                            totalSignOrderGaiPrice += line.SignOrderGaiPrice;
                            totalSignOrderPrice += line.SignOrderPrice;

                            //table
                            if (line.Time < nows) {
                                strtableCount += "<tr>";
                                strtableCount += "<td>" + line.StatisticsDate + "</td>";
                                strtableCount += "<td>" + line.CreateOrderCount + "</td>";
                                strtableCount += "<td>" + line.PayOrderCount + "</td>";
                                strtableCount += "<td>" + line.SignOrderCount + "</td>";
                                strtableCount += "</tr>";

                                strtablePrice += "<tr>";
                                strtablePrice += "<td>" + line.StatisticsDate + "</td>";
                                strtablePrice += "<td>" + line.CreateOrderGaiPrice + "</td>";
                                strtablePrice += "<td>" + line.CreateOrderPrice + "</td>";
                                strtablePrice += "<td>" + line.PayOrderGaiPrice + "</td>";
                                strtablePrice += "<td>" + line.PayOrderPrice + "</td>";
                                strtablePrice += "<td>" + line.SignOrderGaiPrice + "</td>";
                                strtablePrice += "<td>" + line.SignOrderPrice + "</td>";
                                strtablePrice += "</tr>";
                            }
                        });
                        optionsCount.series.push({ name: "新订单数量", data: CreateOrderCount });
                        optionsCount.series.push({ name: "支付订单数量", data: PayOrderCount });
                        optionsCount.series.push({ name: "签收订单数量", data: SignOrderCount });
                        optionsCount.plotOptions.series.point.events.click = function () {
                            switch (this.series.name) {
                                case "新订单数量":
                                    popDayStatics(this.x, 1, "日新订单记录");
                                    break;
                                case "支付订单数量":
                                    popDayStatics(this.x, 2, "日支付订单记录");
                                    break;
                                case "签收订单数量":
                                    popDayStatics(this.x, 3, "日签收订单记录");
                                    break;
                            };
                        };
                        optionsCount.xAxis.title.text = "日期（日）";
                        optionsCount.yAxis.title.text = "订单数";
                        optionsCount.chart.width = $("#tableStatistics").width() * 0.9;
                        chartCount = new Highcharts.Chart(optionsCount);

                        optionsPrice.series.push({ name: "新订单总供货价", data: CreateOrderGaiPrice });
                        optionsPrice.series.push({ name: "新订单总价", data: CreateOrderPrice });
                        optionsPrice.series.push({ name: "支付订单总供货价", data: PayOrderGaiPrice });
                        optionsPrice.series.push({ name: "支付订单总价", data: PayOrderPrice });
                        optionsPrice.series.push({ name: "签收订单总供货价", data: SignOrderGaiPrice });
                        optionsPrice.series.push({ name: "签收订单总价", data: SignOrderPrice });
                        optionsPrice.plotOptions.series.point.events.click = function () {
                            switch (this.series.name) {
                                case "新订单总供货价":
                                case "新订单总价":
                                    popDayStatics(this.x, 1, "日新订单记录");
                                    break;
                                case "支付订单总供货价":
                                case "支付订单总价":
                                    popDayStatics(this.x, 2, "日支付订单记录");
                                    break;
                                case "签收订单总供货价":
                                case "签收订单总价":
                                    popDayStatics(this.x, 3, "日签收订单记录");
                                    break;
                            };
                        };
                        optionsPrice.xAxis.title.text = "日期（日）";
                        optionsPrice.yAxis.title.text = "价格（￥）";
                        optionsPrice.chart.width = $("#tableStatistics").width() * 0.9;
                        chartPrice = new Highcharts.Chart(optionsPrice);

                        //总数赋值
                        $('#tdCreateOrderCount').text(totalCreateOrderCount);
                        $('#tdPayOrderCount').text(totalPayOrderCount);
                        $('#tdSignOrderCount').text(totalSignOrderCount);
                        $('#tdCreateOrderGaiPrice').text(totalCreateOrderGaiPrice);
                        $('#tdCreateOrderPrice').text(totalCreateOrderPrice);
                        $('#tdPayOrderGaiPrice').text(totalPayOrderGaiPrice);
                        $('#tdPayOrderPrice').text(totalPayOrderPrice);
                        $('#tdSignOrderGaiPrice').text(totalSignOrderGaiPrice);
                        $('#tdSignOrderPrice').text(totalSignOrderPrice);

                        $("#tableCountData").html(strtableCount);
                        $("#tablePriceData").html(strtablePrice);
                        rowChangeColor();
                    }
                    finally {
                        delete CreateOrderCount; CreateOrderCount = null;
                        delete PayOrderCount; PayOrderCount = null;
                        delete SignOrderCount; SignOrderCount = null;
                        delete CreateOrderGaiPrice; CreateOrderGaiPrice = null;
                        delete CreateOrderPrice; CreateOrderPrice = null;
                        delete PayOrderGaiPrice; PayOrderGaiPrice = null;
                        delete PayOrderPrice; PayOrderPrice = null;
                        delete SignOrderGaiPrice; SignOrderGaiPrice = null;
                        delete SignOrderPrice; SignOrderPrice = null;
                    }
                });
        };

        var dialog = null;
        var popDayStatics = function (time, type, title) {
           // var DayStaticsUrl = '/Statistics/DayGaiOrderStatics' + '?dateTime=' + time + '&type=' + type;
            var DayStaticsUrl = "<?php echo urldecode(Yii::app()->createUrl('statistics/dayGaiOrderStatics', array('time' => '"+time+"','type'=>'"+type+"'))); ?>";
            dialog = art.dialog.open(DayStaticsUrl, { 'id': 'DayStaticsUrl', title: title, width: '800px', height: '620px', lock: true });
        };
        var doClose = function () {
            if (null != dialog) {
                dialog.close();
            }
        };
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var $thi = $('body,html').find("#tjtab_titleu li");
            $($thi).hover(function () {
                $(this).addClass("cur").siblings().removeClass("cur");
                var $as = $("#tjtab_con .tjtab_con_listbox").eq($("#tjtab_titleu li").index(this));
                $as.show().siblings().hide();
            });
        });

        var rowChangeColor = function () {
            $('.tab-tj ').each(function () {
                $(this).find('tr:even td').css("background", "#fafafa");
                $(this).find('tr:odd td').css("background", "#fff");
            });
        };

        $(document).ready(function () {
            rowChangeColor();
        });
    </script>
    <div class="main">
        

<div class="line tjbox">
    <div class="line title_one">
        <div class="unit title_oneimg">
            <img src="<?php echo Yii::app()->baseUrl?>/images/icon06.png" width="37" height="51" alt="icon1" /></div>
        <div class="unit title_onezi">订单统计</div>
    </div>
    <div class="line tjbox_nr">
        <div class="line tjbox2">
            <div class="line title_time">
                <div class="unit title_timeimg">
                    <img src="<?php echo Yii::app()->baseUrl?>/images/icon03.jpg" width="15" height="19" alt="time" /></div>
                <div class="unit title_timezi">
                    选择日期查看详细数据信息</div>
            </div>
            <div class="line tjbox_nr">
                <table cellpadding="0" cellspacing="0" class="searchTable">
                    <tr>
                        <th>
                            选择年月：<input type="text" class="text-input-bj  least" id="monthpicker" value="<?php echo date('Y-m');?>" />
                        </th>
                    </tr>
                </table>
                <input type="button" class="reg-sub" value="搜索" onclick="search()" />
            </div>
        </div>
        <div class="c10">
        </div>
        <div class="tjtab" id="tableStatistics">
            <div class="tjtab_title">
                <ul id="tjtab_titleu">
                    <li id="cur" class="cur">订单数量统计</li>
                    <li class="">订单金额统计</li>
                </ul>
            </div>
            <div class="line" id="tjtab_con">
                <div class="tjtab_con_listbox" style="display: block;">
                    <div class="c10">
                    </div>
                    <div class="line title_three">
                        <div class="unit title_threeimg">
                            <img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">
                            订单数量概述</div>
                    </div>
                    <div class="c10">
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-tj">
                        <tr class="tab-tj-title">
                            <th colspan="6" id="titleC">
                                该月金额概述
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: right;">
                                新订单数量：
                            </th>
                            <td id="tdCreateOrderCount">
                            </td>
                            <th style="text-align: right;">
                                支付订单数量：
                            </th>
                            <td id="tdPayOrderCount">
                            </td>
                            <th style="text-align: right;">
                                签收订单数量：
                            </th>
                            <td id="tdSignOrderCount">
                            </td>
                        </tr>
                    </table>
                    <div class="c10">
                    </div>
                    <div class="line title_three">
                        <div class="unit title_threeimg">
                            <img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">
                            订单数量统计曲线表</div>
                    </div>
                    <div class="c10">
                    </div>
                    <div id="divCount" class="us-log" style="min-width: 400px; height: 300px; margin: 0 auto">
                    </div>
                    <div class="c10">
                    </div>
                    <div class="line title_three">
                        <div class="unit title_threeimg">
                            <img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">
                            订单数量详情表</div>
                    </div>
                    <div class="c10">
                    </div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab-tj">
                        <thead>
                            <tr class="tab-tj-title">
                                <th>
                                    日期
                                </th>
                                <th>
                                    新订单数量
                                </th>
                                <th>
                                    支付订单数量
                                </th>
                                <th>
                                    签收订单数量
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tableCountData">
                        </tbody>
                    </table>
                </div>
                <div class="tjtab_con_listbox" style="display: none;">
                    <div class="c10">
                    </div>
                    <div class="line title_three">
                        <div class="unit title_threeimg">
                            <img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">
                            订单金额概述</div>
                    </div>
                    <div class="c10">
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-tj">
                        <tr class="tab-tj-title">
                            <th colspan="6" id="titleP">
                                该月金额概述
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: right;">
                                新订单供货价：
                            </th>
                            <td id="tdCreateOrderGaiPrice">
                            </td>
                            <th style="text-align: right;">
                                支付订单供货价：
                            </th>
                            <td id="tdPayOrderGaiPrice">
                            </td>
                            <th style="text-align: right;">
                                签收订单供货价：
                            </th>
                            <td id="tdSignOrderGaiPrice">
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: right;">
                                新订单总价：
                            </th>
                            <td id="tdCreateOrderPrice">
                            </td>
                            <th style="text-align: right;">
                                支付订单总价：
                            </th>
                            <td id="tdPayOrderPrice">
                            </td>
                            <th style="text-align: right;">
                                签收订单总价：
                            </th>
                            <td id="tdSignOrderPrice">
                            </td>
                        </tr>
                    </table>
                    <div class="c10">
                    </div>
                    <div class="line title_three">
                        <div class="unit title_threeimg">
                            <img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">
                            订单金额统计曲线表</div>
                    </div>
                    <div class="c10">
                    </div>
                    <div id="divPrice" class="us-log" style="min-width: 400px; height: 300px; margin: 0 auto">
                    </div>
                    <div class="c10">
                    </div>
                    <div class="line title_three">
                        <div class="unit title_threeimg">
                            <img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">
                            订单金额详情表</div>
                    </div>
                    <div class="c10">
                    </div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab-tj">
                        <thead>
                            <tr class="tab-tj-title">
                                <th>
                                    日期
                                </th>
                                <th>
                                    新订单总供货价
                                </th>
                                <th>
                                    新订单总价
                                </th>
                                <th>
                                    支付订单总供货价
                                </th>
                                <th>
                                    支付订单总价
                                </th>
                                <th>
                                    签收订单总供货价
                                </th>
                                <th>
                                    签收订单总价
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tablePriceData">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


    </div>
    
    <script type="text/javascript">
        //search();
        $(document).ready(function(){
           search(); 
        });
    </script>
    <script type="text/javascript">
        (function (global, document, $, undefined) {
            $('#monthpicker').datePicker({
                followOffset: [0, 24],
                altFormat: 'yyyy-mm',
                showMode: 1,
               // minDate: '2012-08-24',
               // maxDate: '2014-01-02'
            });
        })(this, document, jQuery);
    </script>


