<?php 
	$baseUrl = Yii::app()->baseUrl;
	$cs = Yii::app()->clientScript;
	$cs->registerScriptFile($baseUrl . "/js/highcharts/highcharts.js");
	$cs->registerScriptFile($baseUrl . "/js/highcharts/HighChartsOption.js");
?>    
    <script type="text/javascript">

        var chartInfo;
        var optionsInfo = getPieChartOption("divInfo", "");

        var chartAdd;
        var optionsAdd = getChartOption("divAdd", "新增商铺统计曲线");

        var chartTotal;
        var optionsTotal = getChartOption("divTotal", "商铺数量统计曲线");
        
        var nows = "<?php echo strtotime(date('Y-m-d')).'000';?>";
        var search = function () {
            var selectedTime = $('#monthpicker').val();
            $("#countInfoTitle").text(selectedTime + "商铺总数概述");
            $("#newInfoTitle").text(selectedTime + "新增商铺");

            var myUrl = "<?php echo Yii::app()->createUrl('statistics/getStoreCount')?>";
            jQuery.getJSON(myUrl, { minTime: selectedTime },
                function (data, state, xhr) {
                   
                    //var data = eval([data]);
                    var date = new Date();

                    var NewStoreCount = [];
                    var TotalStoreCount = [];
                    var ApplyingStoreCount = [];
                    var OnTrialStoreCount = [];
                    var PassStoreCount = [];
                    var ClosedStoreCount = [];
                    
                    var TodayNewStoreCount = 0;
                    var TodayTotalStoreCount = 0;
                    var TodayApplyingStoreCount = 0;
                    var TodayOnTrialStoreCount = 0;
                    var TodayPassStoreCount = 0;
                    var TodayClosedStoreCount = 0;
                   
                    
                    
                    
                    
                    var InfoData = [];
                    var strHtml = "";
                    var strtableAdd = "";
                    optionsInfo.series.splice(0, optionsInfo.series.length);
                    optionsAdd.series.splice(0, optionsAdd.series.length);
                    optionsTotal.series.splice(0, optionsTotal.series.length);

                    try {
                        

                        $.each(data.Chart, function (i, line) {
                            
                            date.setTime(line.Time+30200000);
                            var time = date.getTime();
                            NewStoreCount.push([time, line.NewStoreCount]);
                            TotalStoreCount.push([time, line.TotalStoreCount]);
                            ApplyingStoreCount.push([time, line.ApplyingStoreCount]);
                            if (line.OnTrialStoreCount == null && line.PassStoreCount == null) {
                                PassStoreCount.push([time, null]);
                            }
                            else {
                                PassStoreCount.push([time, (line.OnTrialStoreCount + line.PassStoreCount)]);
                            }
                            ClosedStoreCount.push([time, line.ClosedStoreCount]);
                            
                            TodayNewStoreCount += line.NewStoreCount;
                            TodayTotalStoreCount += line.TotalStoreCount;
                            TodayApplyingStoreCount += line.ApplyingStoreCount;
                            if (line.OnTrialStoreCount != null && line.PassStoreCount != null) {
                                TodayPassStoreCount += line.OnTrialStoreCount + line.PassStoreCount;
                            }
                            else {
                                TodayPassStoreCount = 0;
                            }
                            TodayClosedStoreCount += line.ClosedStoreCount;
                            
                            if (line.Time < nows) {
                                strHtml += "<tr>";
                                strHtml += "<td>" + line.StatisticsDate + "</td>";
                                strHtml += "<td>" + line.TotalStoreCount + "</td>";
                                strHtml += "<td>" + line.ApplyingStoreCount + "</td>";
                                strHtml += "<td>" + (line.OnTrialStoreCount + line.PassStoreCount) + "</td>";
                                strHtml += "<td>" + line.ClosedStoreCount + "</td>";
                                strHtml += "</tr>";
                                strtableAdd += "<tr>";
                                strtableAdd += "<td>" + line.StatisticsDate + "</td>";
                                strtableAdd += "<td>" + line.NewStoreCount + "</td>";
                                strtableAdd += "</tr>"
                            }
                        });
                        
                        InfoData.push(["审核中的商铺", TodayApplyingStoreCount]);
                        InfoData.push(["经营中的商铺", TodayPassStoreCount]);
                        InfoData.push(["关闭的商铺", TodayClosedStoreCount]);
                        optionsInfo.series.push({ type: "pie", name: "所占比例", data: InfoData });
                        optionsInfo.exporting = { enabled: false };
                        optionsInfo.plotOptions.pie.dataLabels.enabled = false;
                        chartInfo = new Highcharts.Chart(optionsInfo);
                        
                        optionsAdd.series.push({ name: "新增商铺数量", data: NewStoreCount });
                        optionsAdd.yAxis.title.text = "数量（家）";
                        optionsAdd.xAxis.title.text = "日期（日）";
                        optionsAdd.chart.width = $("#tableStatistics").width() * 0.9;
                        chartAdd = new Highcharts.Chart(optionsAdd);

                        optionsTotal.series.push({ name: "商铺总数量", data: TotalStoreCount });
                        optionsTotal.series.push({ name: "审核中的商铺总数量", data: ApplyingStoreCount });
                        optionsTotal.series.push({ name: "经营中的商铺总数量", data: PassStoreCount });
                        optionsTotal.series.push({ name: "关闭的商铺总数量", data: ClosedStoreCount });
                        
                        $("#txtNew").text(TodayNewStoreCount);
                        $("#txtTotal").text(TodayTotalStoreCount);
                        $("#txtAppling").text(TodayApplyingStoreCount);
                        $("#txtPass").text(TodayPassStoreCount);
                        $("#txtClose").text(TodayClosedStoreCount);
                        
                        optionsTotal.yAxis.title.text = "数量（家）";
                        optionsTotal.xAxis.title.text = "日期（日）";
                        optionsTotal.chart.width = $("#tableStatistics").width() * 0.9;
                        chartTotal = new Highcharts.Chart(optionsTotal);

                        $("#tableTotalData").html(strHtml);
                        $("#tableAddData").html(strtableAdd);
                        rowChangeColor();
                    }
                    finally {
                        delete NewStoreCount; NewStoreCount = null;
                        delete TotalStoreCount; TotalStoreCount = null;
                        delete ApplyingStoreCount; ApplyingStoreCount = null;
                        delete OnTrialStoreCount; OnTrialStoreCount = null;
                        delete AddStoreInfoCount; AddStoreInfoCount = null;
                        delete PassStoreCount; PassStoreCount = null;
                        delete ClosedStoreCount; ClosedStoreCount = null;
                        delete strHtml; strHtml = null;
                        delete strtableAdd; strtableAdd = null;
                    }
                });

        }
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

        
<div class="line tjbox">
    <div class="line title_one">
        <div class="unit title_oneimg">
            <img src="<?php echo Yii::app()->baseUrl?>/images/icon05.png" width="37" height="51" alt="icon1" /></div>
        <div class="unit title_onezi">商铺统计</div>
    </div>
    <div class="line tjbox_nr">
        <div class="line tjbox2">
            <div class="line title_two">
                <div class="unit title_twoimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon02.jpg" width="18" height="13" alt="icon2" /></div>
                <div class="unit title_twozi">截至到 <?php echo date('Y-m-d');?> 为止，最新的统计数据如下</div>
            </div>
            <div class="line tjbox_nr">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-tj">
                    <tr class="tab-tj-title">
                        <th>盖网通商铺总量（家）</th>
                        <th>审核中的商铺数量（家）</th>
                        <th>经营中的商铺数量（家）</th>
                        <th>关闭的商铺数量（家）</th>
                    </tr>
                    <tr>
                        <td class="tj-count"><?php echo $storeData['totalCount']?></td>
                        <td class="tj-count"><?php echo $storeData['confirmCount']?></td>
                        <td class="tj-count"><?php echo $storeData['shoppingCount']?></td>
                        <td class="tj-count"><?php echo $storeData['closeCount']?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="c10">
        </div>
        <div class="line tjbox2">
            <div class="line title_time">
                <div class="unit title_timeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon03.jpg" width="15" height="19" alt="time" /></div>
                <div class="unit title_timezi">选择日期查看详细数据信息</div>
            </div>
            <div class="line tjbox_nr">
                <table cellpadding="0" cellspacing="0" class="searchTable">
                    <tr>
                        <th>
                                                                  选择年月：
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
        <div class="tjtab" id="tableStatistics">
            <div class="tjtab_title">
                <ul id="tjtab_titleu">
                    <li id="cur" class="cur">商铺总数统计</li>
                    <li class="">新增商铺统计</li>
                </ul>
            </div>
            <div class="line" id="tjtab_con">
                <div class="tjtab_con_listbox" style="display: block;">
                    <div class="c10"></div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">商铺总数概述</div>
                    </div>
                    <div class="c10"></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-tj" >
                        <thead>
                            <tr class="tab-tj-title">
                                <th colspan="3">
                                    <span id="countInfoTitle"></span>
                                </th>
                            </tr>
                        </thead>
                        <tr>
                            <td rowspan="5" style="width: 50%;">
                                <div id="divInfo" style="min-width: 300px; height: 150px; margin: 0 auto;">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right; width: 200px;">商铺总数:</td>
                            <td style="text-align: left;"><span id="txtTotal"></span>家</td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">审核中的商铺:</td>
                            <td style="text-align: left;"><span id="txtAppling"></span>家</td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">经营中的商铺:</td>
                            <td style="text-align: left;"><span id="txtPass"></span>家</td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">关闭的商铺:
                            </td>
                            <td style="text-align: left;"><span id="txtClose"></span>家
                            </td>
                        </tr>
                    </table>
                    <div class="c10"></div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">商铺总数统计曲线表</div>
                    </div>
                    <div class="c10"></div>
                    <div id="divTotal" class="us-log" style="min-width: 400px; height: 300px; margin: 0 auto;"></div>
                    <div class="c10"></div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">商铺总数详情表</div>
                    </div>
                    <div class="c10"></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-tj">
                        <thead>
                            <tr class="tab-tj-title">
                                <th>日期</th>
                                <th>商铺总数量(家）</th>
                                <th>审核中的商铺总数量(家）</th>
                                <th>审核通过的商铺总数量(家）</th>
                                <th>关闭的商铺总数量(家）</th>
                            </tr>
                        </thead>
                        <tbody id="tableTotalData">
                        </tbody>
                    </table>
                </div>
                <div class="tjtab_con_listbox" style="display: none;">
                    <div class="c10">
                    </div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">新增商铺数量概述</div>
                    </div>
                    <div class="c10"></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-tj" id="tableStatistics">
                        <thead>
                            <tr class="tab-tj-title">
                                <th colspan="2">
                                    <span id="newInfoTitle"></span>
                                </th>
                            </tr>
                        </thead>
                        <tr>
                            <th style="text-align:right; width:50%">数量：</th>
                            <td  style="text-align:left"><span id="txtNew"></span>家</td>
                        </tr>
                    </table>
                    <div class="c10"></div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">新增商铺统计曲线图</div>
                    </div>
                    <div class="c10"></div>
                    <div id="divAdd" class="us-log" style="min-width: 400px; height: 300px; margin: 0 auto;"></div>
                    <div class="c10"></div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">新增商铺详情表</div>
                    </div>
                    <div class="c10"></div>
                    <table  width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-tj">
                        <thead>
                            <tr class="tab-tj-title">
                                <th>日期</th>
                                <th> 新增数量(家）</th>
                            </tr>
                        </thead>
                        <tbody id="tableAddData">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">        search(); </script>
