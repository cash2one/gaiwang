 <script type="text/javascript">
            document.domain = '<?php echo SHORT_DOMAIN ?>';
        </script>
    <?php 
	$baseUrl = Yii::app()->baseUrl;
	$cs = Yii::app()->clientScript;
	$cs->registerScriptFile($baseUrl . "/js/highcharts/highcharts.js");
	$cs->registerScriptFile($baseUrl . "/js/highcharts/HighChartsOption.js");
        $cs->registerScriptFile($baseUrl . "/js/iframeTools.js");
        $cs->registerScriptFile($baseUrl . "/js/jquery.DatePicker.min.js");
    ?>
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
        var chartProduct;
        var optionsProduct = getChartOption("divProduct", "商品数量统计");
        var nows = "<?php echo strtotime(date('Y-m-d')).'000';?>";
        
        var search = function () {
            var selectedTime = $('#monthpicker').val();
            $("#countInfoTitle").text(selectedTime + "商品数量概述");
            var getUrl = "<?php echo Yii::app()->createUrl('statistics/ajaxProduct')?>";

            jQuery.getJSON(getUrl, { minTime: selectedTime },
                function (data, state, xhr) {
                    var datas = eval([data]);
    
                    var date = new Date();
                    var NewProductCount = [];
                    var PublishProductCount = [];
                    var SignProductCount = [];
                    var OrderedProductCount = [];
                    var PayedProductCount = [];
                    var ConversionrateAvg = [];
                    var strTable = "";
                    optionsProduct.series.splice(0, optionsProduct.series.length);
                    //本月总量统计
                    var totalNewProductCount = 0;
                    var totalPublishProductCount = 0;
                    var totalSignProductCount = 0;
                    var totalOrderedProductCount = 0;
                    var totalPayedProductCount = 0;
                    var totalConversionrateAvg = 0;
                    
                    try {
                        $.each(datas[0].Chart, function (i, line) {

                            date.setTime(line.Time+30200000);
                            var time = date.getTime();
                            NewProductCount.push([time, line.NewProductCount]);
                            PublishProductCount.push([time, line.PublishProductCount]);
                            SignProductCount.push([time, line.SignProductCount]);
                            OrderedProductCount.push([time, line.OrderedProductCount]);
                            PayedProductCount.push([time, line.PayedProductCount]);
                            ConversionrateAvg.push([time, line.ConversionrateAvg * 100]);
                            
                            totalNewProductCount += line.NewProductCount;
                            totalPublishProductCount += line.PublishProductCount;
                            totalSignProductCount += line.SignProductCount;
                            totalOrderedProductCount += line.OrderedProductCount;
                            totalPayedProductCount += line.PayedProductCount;
                            totalConversionrateAvg += line.ConversionrateAvg * 100;
                            if (line.Time < nows) {
                                strTable += "<tr>";
                                strTable += "<td>" + line.StatisticsDate + "</td>";
                                strTable += "<td>" + line.NewProductCount + "</td>";
                                strTable += "<td>" + line.PublishProductCount + "</td>";
                                strTable += "<td>" + line.OrderedProductCount + "</td>";
                                strTable += "<td>" + line.PayedProductCount + "</td>";
                                strTable += "<td>" + line.SignProductCount + "</td>";
                                strTable += "<td>" + parseInt(line.ConversionrateAvg * 100) + "%</td>";
                                strTable += "</tr>";
                            }
                        });
                        optionsProduct.series.push({ name: "新录入商品总数量", data: NewProductCount });
                        optionsProduct.series.push({ name: "新上架商品数量", data: PublishProductCount });
                        optionsProduct.series.push({ name: "下单商品数量", data: OrderedProductCount });
                        optionsProduct.series.push({ name: "支付商品的数量", data: PayedProductCount });
                        optionsProduct.series.push({ name: "签收商品数量", data: SignProductCount });
                        optionsProduct.series.push({ name: "平均转化率", data: ConversionrateAvg});
                        
                        $("#textNew").text(totalNewProductCount);
                        $("#textPublish").text(totalPublishProductCount);
                        $("#textOrder").text(totalOrderedProductCount);
                        $("#textPay").text(totalPayedProductCount);
                        $("#textSign").text(totalSignProductCount);
                        $("#textAvg").text(totalConversionrateAvg);
                        
                        optionsProduct.yAxis.title.text = "件数(件)";
                        optionsProduct.xAxis.title.text = "日期(日)";
                        optionsProduct.chart.width = $("#divProduct").width() * 0.9;
                        chartProduct = new Highcharts.Chart(optionsProduct);
                        
                        $("#tableData").html(strTable);
                        //rowChangeColor();
                    }
                    finally {
                        delete NewProductCount; NewProductCount = null;
                        delete PublishProductCount; PublishProductCount = null;
                        delete SignProductCount; SignProductCount = null;
                        delete OrderedProductCount; OrderedProductCount = null;
                        delete PayedProductCount; PayedProductCount = null;
                        delete ConversionrateAvg; ConversionrateAvg = null;
                        delete strTable; strTable = null;
                    }
                });

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
        <div class="unit title_onezi">商品数量统计</div>
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
                            选择年月：<input type="text" class="text-input-bj  least" id="monthpicker" value="<?php echo date('Y-m')?>" />
                        </th>
                    </tr>
                </table>
                <input type="button" class="reg-sub" value="搜索" onclick="search()" />
            </div>
        </div>
        <div class="c10">
        </div>
        <div class="line tjbox2">
            <div class="line title_two">
                <div class="unit title_twoimg">
                    <img src="<?php echo Yii::app()->baseUrl?>/images/icon02.jpg" width="18" height="13" alt="icon2" /></div>
                <div class="unit title_twozi">
                    商品数量概述</div>
            </div>
            <div class="line tjbox_nr">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-tj">
                    <tr class="tab-tj-title">
                        <th colspan="4">
                            <span id="countInfoTitle"></span>
                        </th>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            新增商品总数量:
                        </td>
                        <td style="text-align: left;">
                            <span id="textNew"></span>件
                        </td>
                        <td style="text-align: right;">
                            发布商品数量:
                        </td>
                        <td style="text-align: left;">
                            <span id="textPublish"></span>件
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            下单商品数量:
                        </td>
                        <td style="text-align: left;">
                            <span id="textOrder"></span>件
                        </td>
                        <td style="text-align: right;">
                            支付商品的数量:
                        </td>
                        <td style="text-align: left;">
                            <span id="textPay"></span>件
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            签收商品数量:
                        </td>
                        <td style="text-align: left;">
                            <span id="textSign"></span>件
                        </td>
                        <td style="text-align: right;">
                            平均转化率:
                        </td>
                        <td style="text-align: left;">
                            <span id="textAvg"></span>%
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="c10">
        </div>
        <div class="line tjbox2">
            <div class="line title_two">
                <div class="unit title_twoimg">
                    <img src="<?php echo Yii::app()->baseUrl?>/images/icon02.jpg" width="18" height="13" alt="icon2" /></div>
                <div class="unit title_twozi">
                    商品数量统计曲线表</div>
            </div>
            <div class="line tjbox_nr">
                <div id="divProduct" class="us-log" style="min-width: 400px; height: 300px; margin: 0 auto">
                </div>
            </div>
        </div>
        <div class="c10">
        </div>
        <div class="line tjbox2">
            <div class="line title_two">
                <div class="unit title_twoimg">
                    <img src="<?php echo Yii::app()->baseUrl?>/images/icon02.jpg" width="18" height="13" alt="icon2" /></div>
                <div class="unit title_twozi">
                    商品数量详情表</div>
            </div>
            <div class="c10">
            </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-tj">
                <thead>
                    <tr class="tab-tj-title">
                        <th>
                            日期
                        </th>
                        <th>
                            新增商品总数量(件)
                        </th>
                        <th>
                            发布商品数量(件)
                        </th>
                        <th>
                            下单商品数量(件)
                        </th>
                        <th>
                            支付商品的数量(件)
                        </th>
                        <th>
                            签收商品数量(件)
                        </th>
                        <th>
                            平均转化率<img src="<?php echo Yii::app()->baseUrl?>/images/tj-ts.png" title="转化率：下单商品总量/商品点击量*100%"
                                alt="提示" style="display: inline" />
                        </th>
                    </tr>
                </thead>
                <tbody id="tableData">
                </tbody>
            </table>
        </div>
    </div>
</div>


    </div>
    
    <script type="text/javascript">     
    $(document).ready(function(){
        search();
    });    
    </script>
    <script type="text/javascript">
        (function (global, document, $, undefined) {
            $('#monthpicker').datePicker({ 
                followOffset:[0, 24], 
                altFormat: 'yyyy-mm',
                showMode: 1, 
            });
        })(this, document, jQuery); </script>


