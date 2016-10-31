<?php
/**
 * @var HotelRoomController $this
 * @var HotelRoom $model
 */
$this->breadcrumbs = array(
    Yii::t('hotel', '酒店管理') => array('hotel/admin'),
    Yii::t('hotel', '酒店房间管理') => array('hotelRoom/admin','hotelId'=>$model->hotel_id),
    Yii::t('hotel', '房间列表'),
);

$baseUrl = Yii::app()->baseUrl;
Yii::app()->clientScript->registerCssFile($baseUrl.'/css/jqtransform.css');
Yii::app()->clientScript->registerCssFile($baseUrl.'/js/swf/js/skins/blue.css?4.1.5');
Yii::app()->clientScript->registerScriptFile($baseUrl . "/js/jquery.jqtransform.js");
Yii::app()->clientScript->registerScriptFile($baseUrl . "/js/dateutil.js");
Yii::app()->clientScript->registerScriptFile($baseUrl . "/js/calendar.js");

?>

<a href="#" class="sl_back"></a>

<div class="sld_title sld_title2">酒店名称：深圳皇冠假日酒店<span>房间型号：<span>高级房</span></span></div>
<div class="c"></div>

<script type="text/javascript">
    var cal = null;
    $(document).ready(function () {
        //日期控件
        cal = new Calendar({
            "div": $("#duty_div"),
            "dateSpan": $("#dateSp"),
            "dateClick": function (ds) {
                //alert(ds);
            },
            "dateCreate": function (ds, td, isYet) {
                if (isYet) {
                    return;
                }
                if (ds == "2015-04-01"
                    || ds == "2015-04-02"
                    || ds == "2015-04-03"
                    || ds == "2015-04-04"
                    || ds == "2015-04-05"
                    || ds == "2015-04-14"
                    || ds == "2015-04-16") {
                    var tdInfo = $("<div class='tdInfo'>单   价：<span>￥120-150</span><p>供货价：<span>￥100-120</span><p>库   存： 10</div>");
                    $(td).find(".tdDiv").append($(tdInfo));
                } else {
                    $(td).find(".tdDiv").append("<div class='tdWS'>未设置</div>");
                }
            }
        });

        $("#left").click(function () {
            cal.preMonth();
        });
        $("#right").click(function () {
            cal.nextMonth();
        });
    })
</script>
<div class="container-main-table1-tab" id="duty_div">
    <div class="sj_title">
        <input type="button" id="left" class="up_month"/>
        <span id="dateSp"></span>
        <input type="button" id="right" class="next_month"/>
    </div>
</div>
