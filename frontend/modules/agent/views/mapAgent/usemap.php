<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
            body, html,#allmap {width: 740px;height: 595px;overflow: hidden;margin:0;}
            html {
                font-family: Arial, Verdana, sans-serif;
                font-size: 12px;
                color:#666;
            }
            body, form, html, ul, li {
                margin:0px;
                padding:0px;
            }
            table{
                border:1px solid #ccc;
                width:9%;
            }
            td{
                width:16%;
                border:1px solid #fff;
            }
            .button {
                background: -moz-linear-gradient(center top , #FFFFFF, #DDDDDD) repeat scroll 0 0 rgba(0, 0, 0, 0);
                border: 1px solid #999999;
                border-radius: 5px 5px 5px 5px;
                box-shadow: 0 1px 0 rgba(255, 255, 255, 0.7), 0 -1px 0 rgba(0, 0, 0, 0.09);
                color: #333333;
                cursor: pointer;
                display: inline-block;
                letter-spacing: 2px;
                line-height: 1;
                margin-left: 15px;
                overflow: visible;
                padding: 6px 8px;
                text-align: center;
                text-shadow: 0 1px 1px #FFFFFF;
                transition: box-shadow 0.2s linear 0s;
                width: auto;
                background: -moz-linear-gradient(center top , #33BBEE, #2288CC) repeat scroll 0 0 rgba(0, 0, 0, 0);
                border: 1px solid #3399DD;
                color: #FFFFFF;
                text-shadow: -1px -1px 1px #1C6A9E;
            }
            .tdwidth{
                width:70px;
            }
        </style>
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo $api ?>"></script>
        <script type="text/javascript" src="http://api.map.baidu.com/library/CityList/1.2/src/CityList_min.js"></script>
        <script type="text/javascript" src="http://api.map.baidu.com/library/MarkerTool/1.2/src/MarkerTool_min.js" charset="utf-8"></script>
        <title></title>
    </head>
    <body>
        <table style="border:1px solid #ccc;width:99%;">
            <tr>
                <td class='tdwidth'>当前城市</td>
                <td class='tdwidth'><label><a href="javascript::;" onclick="createBCityList()" id="city_name">未知城市</a></label></td>
                <td class='tdwidth'>地址搜索</td>
                <td style='width:200px'><input type="text" id="address" style='width:99%'/></td>
                <td class='tdwidth'><input type="button" value="搜索" class="button" onclick="doSearch()"/></td>
                <td style='width:150px'><input type="button" id="sign" value="设置标注" onclick="setSign()" class="button"/></td>
            </tr>
        </table>
        <input type="hidden" id="lng" /><input type="hidden" id="lat" />
        <div style="width: 500px; height: 460px; margin-bottom: 20px; border: 1px solid gray;overflow-y: auto; display: none; position: absolute; z-index:999; background-color:White" id="city_container"></div>
        <div id="allmap"></div>
    </body>
</html>
<script type="text/javascript">

// 百度地图API功能
    var map = new BMap.Map("allmap");
    map.enableScrollWheelZoom();                            										//启用滚轮放大缩小
    map.addControl(new BMap.NavigationControl());  													//添加默认缩放平移控件
    map.addControl(new BMap.ScaleControl());                    									// 添加默认比例尺控件
    map.addControl(new BMap.MapTypeControl({mapTypes: [BMAP_NORMAL_MAP, BMAP_HYBRID_MAP]}));     	//2D图，卫星图
    map.addControl(new BMap.OverviewMapControl());             									  	//添加默认缩略地图控件
    map.addControl(new BMap.OverviewMapControl({isOpen: true, anchor: BMAP_ANCHOR_BOTTOM_RIGHT}));   	//右下角，打开缩略地图

//创建一个自动完成的对象
    var ac = new BMap.Autocomplete({"input": "address", "location": map});

    var addr;
    ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
        var _value = e.item.value;
        addr = _value.province + _value.city + _value.district + _value.street + _value.business;
        doSearch();
    });

//查询
    function doSearch() {
        var addr = document.getElementById('address').value;
        if (addr == "")
            return;
        map.clearOverlays();
        var local = new BMap.LocalSearch(map, {
            renderOptions: {map: map}
        });
        local.search(addr);
    }

//创建城市列表
    function createBCityList() {
        var cityList = new BMapLib.CityList({"container": "city_container", "map": map});
        var cityName = document.getElementById('city_name');					//选中的城市
        var cityContainer = document.getElementById('city_container');			//城市容器

        cityList.addEventListener("cityclick", function(e) {
            cityName.innerHTML = e.name;
            cityContainer.style.display = "none";
        });

        if (cityContainer.style.display == "none") {
            cityContainer.style.display = "";
        } else {
            cityContainer.style.display = "none";
        }
        window.CityList = cityList;
    }

//地图监控事件：click
    map.addEventListener("click", getLngLat);
    function getLngLat(e) {
        if (!openSign)
            return;

        //清空地图上的标注
        map.clearOverlays();

        //创建标注
        var marker = new BMap.Marker(new BMap.Point(e.point.lng, e.point.lat));  // 创建标注
        map.addOverlay(marker);              // 将标注添加到地图中

        document.getElementById('lng').value = e.point.lng;
        document.getElementById('lat').value = e.point.lat;
    }

//是否能够设置标注
    var openSign = false;
    function setSign() {
        if (openSign) {
            document.getElementById('sign').value = "设置标注";
            openSign = false;
            //map.setDefaultCursor("url('bird.cur')");
        } else {
            document.getElementById('sign').value = "取消设置标注";
            openSign = true;
            //map.setDefaultCursor("url('bird2.cur')");
        }
    }

<?php if ($lng != '' && $lat != '') { ?>
        map.centerAndZoom(new BMap.Point(<?php echo $lng ?>, <?php echo $lat ?>), 14);
        var marker = new BMap.Marker(new BMap.Point(<?php echo $lng ?>, <?php echo $lat ?>));  // 创建标注
        map.addOverlay(marker);              // 将标注添加到地图中
<?php } else { ?>
    <?php if ($cityname == '') { ?>
            map.centerAndZoom("广州", 12);
    <?php } else { ?>
            map.centerAndZoom("<?php echo $cityname ?>", 12);
    <?php } ?>
        /**
         var myCity = new BMap.LocalCity();							//得到所在城市的对象
         myCity.get(function(r){
         alert(r.name);
         map.centerAndZoom(new BMap.Point(r.center.lng, r.center.lat), 14);		//先设置地图和地图级别
         map.setCenter(r.name);		
         });
         */
<?php } ?>
</script>
