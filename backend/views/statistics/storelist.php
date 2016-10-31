   <?php 
	$baseUrl = Yii::app()->baseUrl;
	$cs = Yii::app()->clientScript;
        $cs->registerScriptFile($baseUrl . "/js/iframeTools.js");
        $cs->registerScriptFile($baseUrl . "/js/jquery.DatePicker.min.js");
    ?>
    <script type="text/javascript">
        var search = function () {
            var selectedTime = $('#monthpicker').val();
            var myUrl = "<?php echo Yii::app()->createUrl('statistics/getStoreListData')?>";
            jQuery.getJSON(myUrl, { minTime: selectedTime },

                function (data, state, xhr) {
                    //alert(data);
                    var tableOrderLists = "";
                    //var tableViewLists = "";
                    try {
                        $.each(data.OrderLists, function (i, line) {
                            tableOrderLists += "<tr>";
                            tableOrderLists += "<td>" + i + "</td>";
                            tableOrderLists += "<td><a href='" + '/Shop/' + "?id=" + line.StoreId + "' target='+_blank+'>" + line.StoreName + "</a></td>";
                            tableOrderLists += "<td>" + line.SuccessOrderCount + "</td>";
                            tableOrderLists += "<td>" + line.SuccessOrderPrice + "</td>";
                            tableOrderLists += "<td>" + line.SuccessGaiPrice + "</td>";
                            tableOrderLists += "</tr>";
                        });
                        $("#OrderListData").html(tableOrderLists);

//                        $.each(data.ViewLists, function (i, line) {
//                            tableViewLists += "<tr>";
//                            tableViewLists += "<td>" + i + "</td>";
//                            tableViewLists += "<td><a href='" + '/Shop/Index.html' + "?id=" + line.StoreId + "' target='+_blank+'>" + line.StoreName + "</a></td>";
//                            tableViewLists += "<td>" + line.PageViewCount + "</td>";
//                            tableViewLists += "<td>" + line.UserViewCount + "</td>";
//                            tableViewLists += "</tr>";
//                        });
//                        $("#ViewListData").html(tableViewLists);
                        rowChangeColor();
                    }
                    finally {
                        delete tableOrderLists; tableOrderLists = "";
                        //delete tableViewLists; tableViewLists = ""
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
        
<div class="line tjbox">
    <div class="line title_one">
        <div class="unit title_oneimg">
            <img src="<?php echo Yii::app()->baseUrl?>/images/icon05.png" width="37" height="51" alt="icon1" /></div>
        <div class="unit title_onezi">商铺排行</div>
    </div>
    <div class="line tjbox_nr">
        <div class="line tjbox2">
            <div class="line title_time">
                <div class="unit title_timeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon03.jpg" width="15" height="19" alt="time" /></div>
                <div class="unit title_timezi">选择日期查看详细数据信息</div>
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
        <div class="tjtab">
            <div class="tjtab_title">
                <ul id="tjtab_titleu">
                    <li id="cur" class="cur">访问量TOP20</li>
                    <li class="">订单量TOP20</li>
                </ul>
            </div>
            <div class="line" id="tjtab_con">
                <div class="tjtab_con_listbox" style="display: block;">
                    <!-- start -->
                    <div class="c10"></div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi">访问量TOP20详情表</div>
                    </div>
                    <div class="c10"></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-tj">
                        <thead>
                            <tr class="tab-tj-title">
                                <th>排行</th>
                                <th> 商铺</th>
                                <th>PV</th>
                                <th>UV</th>
                            </tr>
                        </thead>
                        <tbody id="ViewListData">
                        </tbody>
                    </table>
                </div>
                <div class="tjtab_con_listbox" style="display: none;">
                    <div class="c10">
                    </div>
                    <div class="line title_three">
                        <div class="unit title_threeimg"><img src="<?php echo Yii::app()->baseUrl?>/images/icon04.jpg" width="16" height="16" alt="icon03" /></div>
                        <div class="unit title_threezi"> 订单量TOP20详情表</div>
                    </div>
                    <div class="c10"></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-tj">
                        <thead>
                            <tr class="tab-tj-title">
                                <th>排行</th>
                                <th>商铺</th>
                                <th>成交订单总数量</th>
                                <th>成交订单总金额</th>
                                <th>成交订单总供货价</th>
                            </tr>
                        </thead>
                        <tbody id="OrderListData">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"> 
    search(); 
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
