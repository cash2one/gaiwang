<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo Yii::t('sellerDesign','选择经纬度'); ?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/Mapcss.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/tablestyle.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/conStyle.css" />

    <?php Yii::app()->clientScript->registerCoreScript('jquery') ?>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.js" type="text/javascript"></script>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.iframeTools.js" type="text/javascript"></script>

    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/library/CityList/1.2/src/CityList_min.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/library/MarkerTool/1.2/src/MarkerTool_min.js"
            charset="gb2312"></script>
    <script type="text/javascript">

        var btnCancelClick = function () {
            art.dialog.close();
        }
    </script>
</head>
<body>
<div class="search-publicbox">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
        <tr>
            <th>
                <?php echo Yii::t('sellerDesign','地址搜索'); ?>：
            </th>
            <td>
                <input type="text" id="txtAddr" class="small" value="" />
                <input type="button" value="<?php echo Yii::t('sellerDesign','搜索'); ?>" onclick="SearchAddr()" class="input_submit_d1" />
                <input type="button" value="<?php echo Yii::t('sellerDesign','取消'); ?>" class="input_submit_d1" id="btnCancel" onclick="btnCancelClick()" />
            </td>
        </tr>
        <tr>
            <th>
                <?php echo Yii::t('sellerDesign','当前城市'); ?>:
            </th>
            <?php $position = Tool::getPosition();  ?>
            <td>
                <input type="text" id="txtCurrentCity" class="small" disabled="disabled" value="<?php echo $position['city_name'] ?>" />
                <input type="button" value="<?php echo Yii::t('sellerDesign','修改'); ?>" onclick="changeCity()" class="input_submit_d1" />
                <div style="width: 400px; height: 300px; margin-bottom: 20px; border: 1px solid gray;
                            overflow-y: auto; display: none; position: absolute; z-index: 999; background-color: White"
                     id="city_container">
                </div>
                <input type="button" value="<?php echo Yii::t('sellerDesign','设置标记'); ?>" onclick="mark_click()" class="input_submit_d1" />
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="c10">
</div>
<div id="allmap" style="width: 720px; height: 420px;">
</div>
<script type="text/javascript">

    function initMap() {
        createMap();
        setMapEvent();
        addMapControl();
        createCL();
        createMark();
    }

    function createMap() {
        var map = new BMap.Map("allmap"); //在百度地图容器中创建一个地图
        var point = new BMap.Point('', ''); //定义一个中心点坐标
        map.centerAndZoom(point, 12); //设定地图的中心点和坐标并将地图显示在地图容器中
        map.centerAndZoom("<?php echo $position['city_name'] ?>", 12);                   // 初始化地图,设置城市和地图级别。
        window.map = map; //将map变量存储在全局
    }

    function createCL() {
        // 创建CityList对象，并放在city_container节点内
        var myCl = new BMapLib.CityList({ "container": "city_container", "map": map });

        // 给城市点击时，添加切换地图视野的操作
        myCl.addEventListener("cityclick", function (e) {
            $('#txtCurrentCity').val(e.name);
            $('#city_container').css('display', 'none');
            // 由于此时传入了map对象，所以点击的时候会自动帮助地图定位，不需要下面的地图视野切换语句
            // map.centerAndZoom(e.center, e.level);
        });

        window.myCL = myCl;
    }

    function createMark() {
        var mkrTool = new BMapLib.MarkerTool(map, { autoClose: true });
        mkrTool.addEventListener("markend", function (evt) {
            var mkr = evt.marker;

            var p = artDialog.open.origin;
            if (p && p.onSelected) {
                p.onSelected(mkr.point.lat, mkr.point.lng);
            }
            p.doClose();
            //$('#POS_Y').val(mkr.point.lat);
            //$('#POS_X').val(mkr.point.lng);
        });

        var marker1 = new BMap.Marker(new BMap.Point('', ''));  // 创建标注
        map.addOverlay(marker1);              // 将标注添加到地图中

        window.mkrTool = mkrTool;
    }

    //地图事件设置函数：
    function setMapEvent() {
        map.enableDragging(); //启用地图拖拽事件，默认启用(可不写)
        map.enableScrollWheelZoom(); //启用地图滚轮放大缩小
        map.enableDoubleClickZoom(); //启用鼠标双击放大，默认启用(可不写)
        map.enableKeyboard(); //启用键盘上下左右键移动地图
    }

    //地图控件添加函数：
    function addMapControl() {
        //向地图中添加缩放控件
        var ctrl_nav = new BMap.NavigationControl({ anchor: BMAP_ANCHOR_TOP_LEFT, type: BMAP_NAVIGATION_CONTROL_LARGE });
        map.addControl(ctrl_nav);
        //向地图中添加缩略图控件
        var ctrl_ove = new BMap.OverviewMapControl({ anchor: BMAP_ANCHOR_BOTTOM_RIGHT, isOpen: 1 });
        map.addControl(ctrl_ove);
        //向地图中添加比例尺控件
        var ctrl_sca = new BMap.ScaleControl({ anchor: BMAP_ANCHOR_BOTTOM_LEFT });
        map.addControl(ctrl_sca);
    }

    initMap();

    var SearchAddr = function () {
        var addr = $('#txtAddr').val();

        var local = new BMap.LocalSearch(map, {
            renderOptions: { map: map }
        });
        local.search(addr);
    };

    var changeCity = function () {
        $('#city_container').css('display', 'block');
    };

    var mark_click = function () {
        mkrTool.open(); //打开工具
    }

</script>
</body>
</html>