<?php 
	$baseUrl = Yii::app()->baseUrl;
	$cs = Yii::app()->clientScript;
	$cs->registerScriptFile($baseUrl . "/js/highcharts/highcharts.js");
	$cs->registerScriptFile($baseUrl . "/js/highcharts/HighChartsOption.js");
?>
<!--    <script src="http://restest.gatewang.com/Res/global/libs/Highcharts-2.3.3/js/highcharts.js" type="text/javascript"></script>-->
<!--    <script src="http://restest.gatewang.com/Res/global/JS/HighChartsOption.js" type="text/javascript"></script>-->
    <script type="text/javascript">
    $(function(){
    	//zuixia
        var chartCount;

            var selectedTime = '<?php echo date('Y-m')?>';

            var optionsCount = getChartOption("divCount", selectedTime + " 订单数量统计")
            $('#titleC').text(selectedTime + ' 订单数量概述（单位：个）');

            var width = $('#tableStatistics').width() - 30;
            optionsCount.chart.width = width;
			var data = eval('[<?php echo json_encode($orderData)?>]');
//			var data = eval('[{"Chart":[{"CreateOrderCount":"4","PayOrderCount":0,"SignOrderCount":"47"},{"CreateOrderCount":"14","PayOrderCount":0,"SignOrderCount":"91"},{"CreateOrderCount":"19","PayOrderCount":0,"SignOrderCount":"101"},{"CreateOrderCount":"12","PayOrderCount":0,"SignOrderCount":"96"},{"CreateOrderCount":"19","PayOrderCount":0,"SignOrderCount":"93"},{"CreateOrderCount":"39","PayOrderCount":0,"SignOrderCount":"54"},{"CreateOrderCount":"59","PayOrderCount":0,"SignOrderCount":"42"},{"CreateOrderCount":"2","PayOrderCount":0,"SignOrderCount":0},{"CreateOrderCount":0,"PayOrderCount":0,"SignOrderCount":0},{"CreateOrderCount":0,"PayOrderCount":0,"SignOrderCount":0},{"CreateOrderCount":0,"PayOrderCount":0,"SignOrderCount":0},{"CreateOrderCount":0,"PayOrderCount":0,"SignOrderCount":0},{"CreateOrderCount":0,"PayOrderCount":0,"SignOrderCount":0},{"CreateOrderCount":"1","PayOrderCount":0,"SignOrderCount":"1"},{"CreateOrderCount":0,"PayOrderCount":0,"SignOrderCount":"2"},{"CreateOrderCount":0,"PayOrderCount":0,"SignOrderCount":"3"},{"CreateOrderCount":"1","PayOrderCount":0,"SignOrderCount":"7"},{"CreateOrderCount":"22","PayOrderCount":0,"SignOrderCount":0},{"CreateOrderCount":"28","PayOrderCount":0,"SignOrderCount":0},{"CreateOrderCount":"10","PayOrderCount":0,"SignOrderCount":"1"},{"CreateOrderCount":"10","PayOrderCount":0,"SignOrderCount":"1"},{"CreateOrderCount":"6","PayOrderCount":0,"SignOrderCount":"3"},{"CreateOrderCount":"12","PayOrderCount":0,"SignOrderCount":0},{"CreateOrderCount":"15","PayOrderCount":0,"SignOrderCount":"1"},{"CreateOrderCount":"2","PayOrderCount":0,"SignOrderCount":"3"},{"CreateOrderCount":0,"PayOrderCount":0,"SignOrderCount":0},{"CreateOrderCount":0,"PayOrderCount":0,"SignOrderCount":0},{"CreateOrderCount":0,"PayOrderCount":0,"SignOrderCount":0},{"CreateOrderCount":0,"PayOrderCount":0,"SignOrderCount":0},{"CreateOrderCount":0,"PayOrderCount":0,"SignOrderCount":0},{"CreateOrderCount":0,"PayOrderCount":0,"SignOrderCount":0}]}]');
                    var date = new Date();
                    var CreateOrderCount = [];
                    var PayOrderCount = [];
                    var SignOrderCount = [];

                    var strtableCount = "";
                    optionsCount.series.splice(0, optionsCount.series.length);

                    try {
                        $.each(data[0].Chart, function (i, line) {
                            date.setTime(line.Time);
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

                    }
                    finally {
                        delete CreateOrderCount; CreateOrderCount = null;
                        delete PayOrderCount; PayOrderCount = null;
                        delete SignOrderCount; SignOrderCount = null;
                    }
    });
    </script>
    <script type="text/javascript">
        //饼状图

        $(function () {
            var optionsStorePie = getPieChartOption("divStorePie", "");
            var StoreData = [];
            optionsStorePie.series.splice(0, optionsStorePie.series.length);
            StoreData.push(["企业会员人数："+<?php echo $userData['store']?>, <?php echo $userData['store']?>]);
            StoreData.push(["普通会员人数："+<?php echo $userData['normal']?>, <?php echo $userData['normal']?>]);
            optionsStorePie.series.push({ type: "pie", name: "所占比例", data: StoreData });
            optionsStorePie.exporting = { enabled: false };
            optionsStorePie.plotOptions.pie.dataLabels.enabled = false;
            optionsStorePie.plotOptions.pie.pointPadding = 0;
            chartStorePie = new Highcharts.Chart(optionsStorePie);

            var optionsRegularPie = getPieChartOption("divRegularPie", "");
            var RegularData = [];
            optionsRegularPie.series.splice(0, optionsStorePie.series.length);
            RegularData.push(["正式会员人数："+<?php echo $userData['member']?>, <?php echo $userData['member']?>]);
            RegularData.push(["消费会员人数："+<?php echo $userData['use']?>, <?php echo $userData['use']?>]);
            optionsRegularPie.series.push({ type: "pie", name: "所占比例", data: RegularData });
            optionsRegularPie.exporting = { enabled: false };
            optionsRegularPie.plotOptions.pie.dataLabels.enabled = false;
            chartRegularPie = new Highcharts.Chart(optionsRegularPie);
        });
    
    </script>
   <script>
    //近30天热门商品分类排行
    $(document).ready(function(){

       var getUrl = "<?php echo Yii::app()->createUrl('statistics/getHotCat')?>";
       $.get(
            getUrl,
            {},
            function(data){
                if(data){
                   var data = eval(data);
                   var n = 0;
                    $('#forMe span').each(function(){
                         for(var i=0;i< data.length;i++){
                            //alert(data[i]); 
                            if(i == n){
                                $(this).html(data[n]);
                            }
                        }
                        n++;
                    });
                   
                }
            }
        );
    });
</script>     
<div class="line tjbox">
    <div class="line tjbox_nr">
        <div class="line onebox">
            <div class="line onebox_title">
            <a href="<?php echo Yii::app()->createUrl('statistics/memberCount')?>">
                <span>盖网通会员统计</span><img src="<?php echo Yii::app()->baseUrl?>/images/onetitle.png"width="25" height="25" alt="标题" /></a></div>
            <div class="line onebox_form">
                <div class="unit onebox_form1">
                    <div class="line usericon"><img src="<?php echo Yii::app()->baseUrl?>/images/usericon.png" width="134" height="82"alt="用户" /></div>
                    <div class="line usertitle">盖网通总用户数</div>
                    <div class="line usernumber"><?php echo $userData['total']?></div>
                </div>
                <div class="unit onebox_form2">
                    <div id="divStorePie" style="min-width: 100px; height: 100px; margin: 0 auto;">
                    </div>
                    <div id="divRegularPie" style="min-width: 100px; height: 100px; margin: 0 auto;">
                    </div>
                </div>
                <div class="unit onebox_form3">
                    <div class="line onebox_form3t">近30日会员数据</div>
                    <div class="line onebox_form3l">截止<?php echo date('Y-m-d')?></div>
                    <div class="line">
                        <div class="line zcbox">
                            <img src="<?php echo Yii::app()->baseUrl?>/images/usericon01.png" width="36" height="36"
                                alt="注册人数" /><span>注册人数：<?php echo $userData['register']?></span>
                        </div>
                        <div class="line zcbox">
                            <img src="<?php echo Yii::app()->baseUrl?>/images/usericon02.png" width="36" height="37"
                                alt="登录人数" /><span>登录人次：<?php echo $userData['load']?></span>
                        </div>
                        <div class="line zcbox">
                            <img src="<?php echo Yii::app()->baseUrl?>/images/usericon03.png" width="36" height="37"
                                alt="活跃人数" /><span>活跃用户数：47</span><div class="whyicon">
                                    <a href="#">
                                        <img src="<?php echo Yii::app()->baseUrl?>/images/whyicon.png" class="mt10" width="18"
                                            height="18" alt="近30天登录的人次" title="近30天登录的会员数量" /></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="line onebox">
            <div class="line onebox_title">
            <a href="<?php echo Yii::app()->createUrl('statistics/storeCount')?>">
                <span>盖网通商铺统计</span><img src="<?php echo Yii::app()->baseUrl?>/images/onetitle.png"
                    width="25" height="25" alt="标题"></a></div>
            <div class="line onebox_form">
                <div class="unit onebox_form1">
                    <div class="line shopicon"><img src="<?php echo Yii::app()->baseUrl?>/images/shopicon.png" width="141" height="86" alt="用户"></div>
                    <div class="line usertitle">商铺总数</div>
                    <div class="line usernumber"><?php echo $storeData['total']?></div>
                </div>
                <div class="unit onebox_form2">
                    <div class="line main1">
                        <div class="unit main01">
                            <div class="line c01 f14cf">近30日新增</div>
                            <div class="line c02 f32cr"><?php echo $storeData['addcount']?></div>
                        </div>
                        <div class="unit main01">
                            <div class="line c03 f14cf">审核中</div>
                            <div class="line c04 f32cr"><?php echo $storeData['confirmcount']?></div>
                        </div>
                        <div class="unit main01">
                            <div class="line c05 f14cf">经营中</div>
                            <div class="line c06 f32cr"><?php echo $storeData['shopping']?></div>
                        </div>
                    </div>
                    <div class="line main02">
                        <div class="unit main02_icon"><img src="<?php echo Yii::app()->baseUrl?>/images/shopiconone.png" width="92" height="74" alt="销量冠军"></div>
                        <div class="unit main02_nema"> 
                        	 销量总冠军<br>
                            <span><?php echo $storeData['NO1']?></span>
                        </div>
                    </div>
                </div>
                <div class="unit onebox_form3">
                    <div class="line onebox_form3t">近30日销量排行</div>
                    <div class="line onebox_form3l">截止<?php echo date('Y-m-d')?></div>
                    <div class="line">
                    	<?php for ($i=0;$i<3;$i++){?>
                        <div class="line zcbox">
                            <img src="<?php echo Yii::app()->baseUrl?>/images/shopicon0<?php echo $i+1?>.png" width="37" height="30" alt="排行第<?php echo $i+1?>位">
                            <span><?php echo isset($storeData['beforethree'][$i])?$storeData['beforethree'][$i]['name']:""?></span>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
        <div class="line onebox">
            <div class="line onebox_title">
	            <a href="<?php echo Yii::app()->createUrl('statistics/product')?>">
	                <span>盖网通商品统计</span><img src="<?php echo Yii::app()->baseUrl?>/images/onetitle.png" width="25" height="25" alt="标题">
	            </a>
            </div>
            <div class="line onebox_form">
                <div class="unit onebox_form1">
                    <div class="line waresicon"><img src="<?php echo Yii::app()->baseUrl?>/images/waresicon.png" width="100" height="87"alt="用户"></div>
                    <div class="line usertitle">商品总数</div>
                    <div class="line usernumber"><?php echo $goodsData['goodsnum']?></div>
                </div>
                <div class="unit onebox_form2">
                    <div class="line main1">
                        <div class="unit main01">
                            <div class="line c01 f14cf">近30日新增</div>
                            <div class="line c02 f32cr"><?php echo $goodsData['addnum']?></div>
                        </div>
                        <div class="unit main01">
                            <div class="line c03 f14cf">成交</div>
                            <div class="line c04 f32cr"><?php echo $goodsData['completenum']?></div>
                        </div>
                        <div class="unit main01">
                            <div class="line c05 f14cf">累计成交</div>
                            <div class="line c06 f32cr"><?php echo $goodsData['allnum']?></div>
                        </div>
                    </div>
                    <div class="line main02">
                        <div class="unit main02_icon">
                            <img src="<?php echo Yii::app()->baseUrl?>/images/waresm.png" width="82" height="67" alt="商品平均转化率"></div>
                        <div class="unit main03_nema">
                            <div class="line">
                                <span>商品平均转化率</span><div class="whyicon">
                                    <a href="#">
                                        <img src="<?php echo Yii::app()->baseUrl?>/images/whyicon.png" width="18" height="18"
                                            alt="这是什么？" title="下单商品总量/商品点击量"></a></div>
                            </div>
                            <div class="line">
                                <?php //echo $goodsData['rate']?>0.39 %
                            </div>
                        </div>
                    </div>
                </div>
                <div class="unit onebox_form3">
                    <div class="line onebox_form3t">
                        <span>热门分类排行</span><div class="whyicon">
                            <a href="#">
                                <img src="<?php echo Yii::app()->baseUrl?>/images/whyicon.png" class="mt15" width="18"
                                    height="18" alt="这是什么？" title="近30天销量最好的商品分类"></a></div>
                    </div>
                    <div class="line onebox_form3l">
                        截止 <?php echo date('Y-m-d');?></div>
                    <div class="line" id="forMe">
                        <div class="unit size1of2">
                                <div class="line phline">
                                    <img src="<?php echo Yii::app()->baseUrl?>/images/wares01.png" width="20" height="20"
                                    alt="排行第 1 "><span></span></div>
                                <div class="line phline">
                                    <img src="<?php echo Yii::app()->baseUrl?>/images/wares02.png" width="20" height="20"
                                    alt="排行第 2 "><span></span></div>
                                <div class="line phline">
                                    <img src="<?php echo Yii::app()->baseUrl?>/images/wares03.png" width="20" height="20"
                                    alt="排行第 3 "><span></span></div>
                                <div class="line phline">
                                    <img src="<?php echo Yii::app()->baseUrl?>/images/wares04.png" width="20" height="20"
                                    alt="排行第 4 "><span></span></div>
                                <div class="line phline">
                                    <img src="<?php echo Yii::app()->baseUrl?>/images/wares05.png" width="20" height="20"
                                    alt="排行第 5 "><span></span></div>
                        </div>
                        <div class="unit size1of2">
                                <div class="line phline">
                                    <img src="<?php echo Yii::app()->baseUrl?>/images/wares06.png" width="20" height="20"
                                    alt="排行第 6 "><span></span></div>
                                <div class="line phline">
                                    <img src="<?php echo Yii::app()->baseUrl?>/images/wares07.png" width="20" height="20"
                                    alt="排行第 7 "><span></span></div>
                                <div class="line phline">
                                    <img src="<?php echo Yii::app()->baseUrl?>/images/wares08.png" width="20" height="20"
                                    alt="排行第 8 "><span></span></div>
                                <div class="line phline">
                                    <img src="<?php echo Yii::app()->baseUrl?>/images/wares09.png" width="20" height="20"
                                    alt="排行第 9 "><span></span></div>
                                <div class="line phline">
                                    <img src="<?php echo Yii::app()->baseUrl?>/images/wares10.png" width="20" height="20"
                                    alt="排行第 10 "><span></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="line onebox">
            <div class="line onebox_title">
            <a href="<?php echo Yii::app()->createUrl('statistics/orderCount')?>">
                <span>盖网通订单统计</span><img src="<?php echo Yii::app()->baseUrl?>/images/onetitle.png"
                    width="25" height="25" alt="标题"></a></div>
            <div class="line onebox_form">
                <div id="divCount" class="us-log" style="min-width: 400px; height: 300px; margin: 0 auto">
                </div>
            </div>
        </div>
    </div>
</div>
