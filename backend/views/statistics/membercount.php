<?php 
	$baseUrl = Yii::app()->baseUrl;
	$cs = Yii::app()->clientScript;
	$cs->registerScriptFile($baseUrl . "/js/highcharts/highcharts.js");
	$cs->registerScriptFile($baseUrl . "/js/highcharts/HighChartsOption.js");
?>
    <script src="<?php Yii::app()->baseUrl?>/js/iframeTools.source.js" type="text/javascript"></script>
    <script type="text/javascript">
        var chartAdd;
        var chartTotal;
        var chartLogin;
        var chartStorePie;
        var chartRegularPie;
        var nows = "<?php echo strtotime(date('Y-m-d')).'000';?>";
        $(function () {
            var optionsStorePie = getPieChartOption("divStorePie", "");
            var StoreData = [];
            optionsStorePie.series.splice(0, optionsStorePie.series.length);
            StoreData.push(["企业会员人数："+<?php echo $data['store']?>, <?php echo $data['store']?>]);
            StoreData.push(["普通会员人数："+<?php echo $data['normal']?>, <?php echo $data['normal']?>]);
            optionsStorePie.series.push({ type: "pie", name: "所占比例", data: StoreData });
            optionsStorePie.exporting = { enabled: false };
            optionsStorePie.plotOptions.pie.dataLabels.enabled = false;
            optionsStorePie.plotOptions.pie.pointPadding = 0;
            chartStorePie = new Highcharts.Chart(optionsStorePie);

            var optionsRegularPie = getPieChartOption("divRegularPie", "");
            var RegularData = [];
            optionsRegularPie.series.splice(0, optionsStorePie.series.length);
            RegularData.push(["正式会员人数："+<?php echo $data['member']?>, <?php echo $data['member']?>]);
            RegularData.push(["消费会员人数："+<?php echo $data['use']?>, <?php echo $data['use']?>]);
            optionsRegularPie.series.push({ type: "pie", name: "所占比例", data: RegularData });
            optionsRegularPie.exporting = { enabled: false };
            optionsRegularPie.plotOptions.pie.dataLabels.enabled = false;
            chartRegularPie = new Highcharts.Chart(optionsRegularPie);
        });


        var search = function () {
            var selectedTime = $('#monthpicker').val();
            $('#titleR').text(selectedTime + ' 注册人数概述');
            $('#titleL').text(selectedTime + ' 登录人次概述');

            var optionsAdd = getChartOption("divAdd", selectedTime + " 注册人数统计");
            var optionsTotal = getChartOption("divTotal", selectedTime + " 会员总数统计");
            var optionsLogin = getChartOption("divLogin", selectedTime + " 登录人次统计");

            var width = $('#regStatistics').width() - 30;
            optionsAdd.chart.width = width;
            optionsTotal.chart.width = width;
            optionsLogin.chart.width = width;

            jQuery.getJSON('<?php echo Yii::app()->createUrl('statistics/getMemberCountOther')?>', { minTime: selectedTime },
                function (data, state, xhr) {
                    var date = new Date();
                    var AddCount = [];
                    var AddCountByPhone = [];
                    var AddCountByWebSite = [];
                    var AddCountByMachine = [];
                    var AddStoreInfoCount = [];
                    var TotalCount = [];
                    var TotalStoreInfoCount = [];
                    var RegularCount = [];
                    var ConsumeCount = [];
                    var LoginCount = [];
                    var LoginMemberCount = [];
                    optionsAdd.series.splice(0, optionsAdd.series.length);
                    optionsTotal.series.splice(0, optionsTotal.series.length);
                    optionsLogin.series.splice(0, optionsLogin.series.length);
                    var totalAddCount = 0;
                    var totalAddCountByPhone = 0;
                    var totalAddCountByWebSite = 0;
                    var totalAddCountByMachine = 0;
                    var totalAddStoreInfoCount = 0;
                    var totalLoginCount = 0;
                    var totalLoginMemberCount = 0;
                    var strtableR = "";
                    var strtableL = "";
                    var strtableT = "";
                    try {
                        $.each(data, function (i, line) {
                            date.setTime(line.Time+30200000);
                            var time = date.getTime();
                            AddCount.push([time, line.AddCount]);
                            AddCountByPhone.push([time, line.AddCountByPhone]);
                            AddCountByWebSite.push([time, line.AddCountByWebSite]);
                            AddCountByMachine.push([time, line.AddCountByMachine]);
                            AddStoreInfoCount.push([time, line.AddStoreInfoCount]);
                            TotalCount.push([time, line.TotalCount]);
                            TotalStoreInfoCount.push([time, line.TotalStoreInfoCount]);
                            RegularCount.push([time, line.RegularCount]);
                            ConsumeCount.push([time, line.ConsumeCount]);
                            LoginCount.push([time, line.LoginCount]);
                            LoginMemberCount.push([time, line.LoginMemberCount]);

                            //计算总值
                            if (line.Time < nows) {
                                totalAddCount += line.AddCount;
                                totalAddCountByMachine += line.AddCountByMachine;
                                totalAddCountByPhone += line.AddCountByPhone;
                                totalAddCountByWebSite += line.AddCountByWebSite;
                                totalAddStoreInfoCount += line.AddStoreInfoCount;
                                totalLoginCount += line.LoginCount;
                                totalLoginMemberCount += line.LoginMemberCount;

                                //table
                                strtableR += "<tr>";
                                strtableR += "<td>" + line.StatisticsDate + "</td>";
                                strtableR += "<td>" + line.AddCount + "</td>";
                                strtableR += "<td>" + line.AddCountByPhone + "</td>";
                                strtableR += "<td>" + line.AddCountByWebSite + "</td>";
                                strtableR += "<td>" + line.AddCountByMachine + "</td>";
                                strtableR += "<td>" + line.AddStoreInfoCount + "</td>";
                                strtableR += "</tr>";

                                strtableL += "<tr>";
                                strtableL += "<td>" + line.StatisticsDate + "</td>";
                                strtableL += "<td>" + line.LoginCount + "</td>";
                                strtableL += "<td>" + line.LoginMemberCount + "</td>";
                                strtableL += "</tr>";

                                strtableT += "<tr>";
                                strtableT += "<td>" + line.StatisticsDate + "</td>";
                                strtableT += "<td>" + line.TotalCount + "</td>";
                                strtableT += "<td>" + line.TotalStoreInfoCount + "</td>";
                                strtableT += "<td>" + line.RegularCount + "</td>";
                                strtableT += "<td>" + line.ConsumeCount + "</td>";
                                strtableT += "</tr>";
                            }
                        });
                        optionsAdd.series.push({ name: "注册总人数", data: AddCount });
                        optionsAdd.series.push({ name: "通过手机注册人数", data: AddCountByPhone });
                        optionsAdd.series.push({ name: "通过网站注册人数", data: AddCountByWebSite });
                        optionsAdd.series.push({ name: "通过盖机注册人数", data: AddCountByMachine });
                        optionsAdd.series.push({ name: "企业会员注册人数", data: AddStoreInfoCount });
                        optionsAdd.plotOptions.series.point.events.click = function () {
                            popDayRegStatics(this.x);
                        };
                        optionsAdd.xAxis.title.text = "日期（日）";
                        optionsAdd.yAxis.title.text = "人数（个）";
                        optionsAdd.chart.width = $("#regStatistics").width() * 0.9;
                        chartAdd = new Highcharts.Chart(optionsAdd);

                        $('#tdAddCount').text(totalAddCount);
                        $('#tdAddCountByMachine').text(totalAddCountByMachine);
                        $('#tdAddCountByPhone').text(totalAddCountByPhone);
                        $('#tdAddCountByWebSite').text(totalAddCountByWebSite);
                        $('#tdAddStoreInfoCount').text(totalAddStoreInfoCount);

                        optionsTotal.series.push({ name: "会员总数", data: TotalCount });
                        optionsTotal.series.push({ name: "企业会员总数", data: TotalStoreInfoCount });
                        optionsTotal.series.push({ name: "正式会员总数", data: RegularCount });
                        optionsTotal.series.push({ name: "消费会员总数", data: ConsumeCount });
                        optionsTotal.plotOptions.series.point.events.click = function () { };
                        optionsTotal.xAxis.title.text = "日期（日）";
                        optionsTotal.yAxis.title.text = "人数（个）";
                        optionsTotal.chart.width = $("#regStatistics").width() * 0.9;
                        chartTotal = new Highcharts.Chart(optionsTotal);

                        optionsLogin.series.push({ name: "登录总次数", data: LoginCount });
                        optionsLogin.series.push({ name: "登录总会员数", data: LoginMemberCount });
                        optionsLogin.plotOptions.series.point.events.click = function () {
                            popDayLoginStatics(this.x);
                        };
                        optionsLogin.xAxis.title.text = "日期（日）";
                        optionsLogin.yAxis.title.text = "人数（个）";
                        optionsLogin.chart.width = $("#regStatistics").width() * 0.9;
                        chartLogin = new Highcharts.Chart(optionsLogin);


                        $('#tdLoginCount').text(totalLoginCount);
                        $('#tdLoginMemberCount').text(totalLoginMemberCount);

                        $("#tableRData").html(strtableR);
                        $("#tableLData").html(strtableL);
                        $("#tableTData").html(strtableT);

                        rowChangeColor();
                    }
                    finally {
                        delete addData; addData = null;
                        delete AddCountByPhone; AddCountByPhone = null;
                        delete AddCountByWebSite; AddCountByWebSite = null;
                        delete AddCountByMachine; AddCountByMachine = null;
                        delete AddStoreInfoCount; AddStoreInfoCount = null;
                        delete TotalCount; TotalCount = null;
                        delete TotalStoreInfoCount; TotalStoreInfoCount = null;
                        delete RegularCount; RegularCount = null;
                        delete ConsumeCount; ConsumeCount = null;
                        delete LoginCount; LoginCount = null;
                        delete LoginMemberCount; LoginMemberCount = null;
                    }
                });
        }
    </script>
    <script type="text/javascript">
        var dialog = null;
        var popDayRegStatics = function (time) {
            var regDayStaticsUrl = "<?php echo urldecode(Yii::app()->createUrl('statistics/dayReg', array('time' => '"+time+"'))); ?>";
            dialog = art.dialog.open(regDayStaticsUrl, { 'id': 'regDayStaticsUrl', title: '注册记录', width: '800px', height: '620px', lock: true });
        }
        var doClose = function () {
            if (null != dialog) {
                dialog.close();
            }
        }

        var popDayLoginStatics = function (time) {
            var loginDayStaticsUrl = "<?php echo urldecode(Yii::app()->createUrl('statistics/dayLogin', array('time'=>'"+time+"')));?>";
            dialog = art.dialog.open(loginDayStaticsUrl, { 'id': 'popDayLoginStatics', title: '登录记录', width: '800px', height: '620px', lock: true });
        }
    </script>
    <script type="text/javascript">
    	//tab切换
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

        
<div class="line tjbox">
    <div class="line title_one">
        <div class="unit title_oneimg">
            <img src="<?php echo Yii::app()->baseUrl?>/images/icon01.png" width="37" height="51" alt="icon1" /></div>
        <div class="unit title_onezi">会员人数统计</div>
    </div>
    <div class="line tjbox_nr">
        <div class="line tjbox2">
            <div class="line title_two">
                <div class="unit title_twoimg">
                    <img src="<?php echo Yii::app()->baseUrl?>/images/icon02.jpg" width="18" height="13" alt="icon2" /></div>
                <div class="unit title_twozi">截至到 <?php echo date('Y-m-d')?> 为止，最新的统计数据如下</div>
            </div>
            <div class="line tjbox_nr">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-rs">
                    <tbody>
                        <tr>
                            <td colspan="2" class="tab-rs-zs">盖网通总用户(人):<span><?php echo $data['total']?></span></td>
                        </tr>
                        <tr>
                            <td style="width:50%">
                                <div id="divStorePie" style="min-width: 300px; height: 300px; margin: 0 auto;">
                                </div>
                            </td>
                            <td>
                                <div id="divRegularPie" style="min-width: 300px; height: 300px; margin: 0 auto;">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="c10">
        </div>
        <div class="line tjbox2">
            <div class="line title_time">
                <div class="unit title_timeimg">
                    <img src="<?php echo Yii::app()->baseUrl?>/images/icon03.jpg" width="15" height="19" alt="time" /></div>
                <div class="unit title_timezi"> 选择日期查看详细数据信息</div>
            </div>
            <div class="line tjbox_nr">
                <table cellpadding="0" cellspacing="0" class="searchTable">
                    <tr>
                        <th>选择年月：
                        <?php
	                      $this->widget('comext.timepicker.timepicker', array(
	                      	  'id' => 'monthpicker',
	                          'cssClass' => 'text-input-bj  least',
	                          'select'=>'date',
	                      	  'options' => array('dateFormat'=>'yy-mm','value'=>date('Y-m'))
	                      ));
	                    ?>
                        </th>
                    </tr>
                </table>
                <input type="button" class="reg-sub" value="搜索" onclick="search()" />
            </div>
        </div>
        <div class="c10">
        </div>
        <div class="tjtab"  id="regStatistics">
            <div class="tjtab_title">
                <ul id="tjtab_titleu">
                    <li id="cur" class="cur">注册人数统计</li>
                    <li class="">登录人次统计</li>
                    <li class="">会员总数统计</li>
                </ul>
            </div>
            <div class="line" id="tjtab_con">
                <!-- start -->
                <div class="tjtab_con_listbox" style="display: block;">
                    <div class="c10">
                    </div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">注册人数概括</div>
                    </div>
                    <div class="c10"></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-tj">
                        <tr class="tab-tj-title">
                            <th colspan="6" id="titleR">该月金额概述</th>
                        </tr>
                        <tr>
                            <th style="text-align: right;">总注册人数：</th>
                            <td id="tdAddCount"></td>
                            <th style="text-align: right;">通过手机注册人数：</th>
                            <td id="tdAddCountByPhone"></td>
                            <th style="text-align: right;">企业会员注册人数：</th>
                            <td id="tdAddStoreInfoCount"></td>
                        </tr>
                        <tr>
                            <th style="text-align: right;">通过网站注册人数：</th>
                            <td id="tdAddCountByWebSite"></td>
                            <th style="text-align: right;">通过盖机注册人数：</th>
                            <td id="tdAddCountByMachine"></td>
                            <td colspan="2"></td>
                        </tr>
                    </table>
                    <div class="c10">
                    </div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">注册人数统计曲线表</div>
                    </div>
                    <div class="c10"></div>
                    <div id="divAdd" class="us-log" style="min-width: 400px; height: 300px; margin: 0 auto"></div>
                    <div class="c10"></div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">注册人数详情表</div>
                    </div>
                    <div class="c10"></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-tj">
                        <thead>
                            <tr class="tab-tj-title">
                                <th>日期</th>
                                <th>注册总人数(人)</th>
                                <th>通过手机注册人数(人)</th>
                                <th>通过网站注册人数(人)</th>
                                <th>通过盖网机注册人数(人)</th>
                                <th>企业会员注册人数(人)</th>
                            </tr>
                        </thead>
                        <tbody id="tableRData">
                        </tbody>
                    </table>
                </div>
                <!-- start end -->
                <!-- start -->
                <div class="tjtab_con_listbox" style="display: none;">
                    <div class="c10">
                    </div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">登录人次概述</div>
                    </div>
                    <div class="c10"></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-tj">
                        <tr class="tab-tj-title">
                            <th colspan="4" id="titleL">登录人次概述</th>
                        </tr>
                        <tr>
                            <th style="text-align: right;">登录总人次：</th>
                            <td id="tdLoginCount"></td>
                            <th style="text-align: right;">登录总会员数：</th>
                            <td id="tdLoginMemberCount"></td>
                        </tr>
                    </table>
                    <div class="c10"></div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">登录人次统计曲线表</div>
                    </div>
                    <div class="c10"></div>
                    <div id="divLogin" class="us-log" style="min-width: 400px; height: 300px; margin: 0 auto"></div>
                    <div class="c10"></div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">登录人次详情表</div>
                    </div>
                    <div class="c10"></div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab-tj">
                        <thead>
                            <tr class="tab-tj-title">
                                <th>日期</th>
                                <th>登录总次数</th>
                                <th>登录会员数</th>
                            </tr>
                        </thead>
                        <tbody id="tableLData">
                        </tbody>
                    </table>
                </div>
                <!-- start end -->
                <!-- start -->
                <div class="tjtab_con_listbox" style="display: none;">
                    <div class="c10">
                    </div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">会员总数统计曲线表</div>
                    </div>
                    <div class="c10"></div>
                    <div id="divTotal" class="us-log" style="min-width: 400px; height: 300px; margin: 0 auto"></div>
                    <div class="c10"></div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">会员总数详情表</div>
                    </div>
                    <div class="c10"></div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab-tj">
                        <thead>
                            <tr class="tab-tj-title">
                                <th>日期</th>
                                <th>会员总数</th>
                                <th>企业会员总数</th>
                                <th>正式会员总数</th>
                                <th>消费会员总数</th>
                            </tr>
                        </thead>
                        <tbody id="tableTData">
                        </tbody>
                    </table>
                </div>
                <!-- start end -->
            </div>
        </div>
    </div>
</div>


    
    <script type="text/javascript">
        search();
    </script>

