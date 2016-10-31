<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body, html,#allmap {width: 740px;height: 630px;overflow: hidden;margin:0;}
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo $api?>"></script>
<title>添加普通标注点</title>
</head>
<body>
<div id="allmap"></div>
</body>
</html>
<script type="text/javascript">

// 百度地图API功能
var map = new BMap.Map("allmap");
map.enableScrollWheelZoom();                            										//启用滚轮放大缩小
map.addControl(new BMap.NavigationControl());  													//添加默认缩放平移控件
map.addControl(new BMap.ScaleControl());                    									// 添加默认比例尺控件
map.addControl(new BMap.MapTypeControl({mapTypes: [BMAP_NORMAL_MAP,BMAP_HYBRID_MAP]}));     	//2D图，卫星图
map.addControl(new BMap.OverviewMapControl());             									  	//添加默认缩略地图控件
map.addControl(new BMap.OverviewMapControl({isOpen:true, anchor: BMAP_ANCHOR_BOTTOM_RIGHT}));   	//右下角，打开缩略地图

<?php if($lng!=''&&$lat!=''){?>
map.centerAndZoom(new BMap.Point(<?php echo $lng?>, <?php echo $lat?>), <?php echo $level?>);
var marker = new BMap.Marker(new BMap.Point(<?php echo $lng?>, <?php echo $lat?>));  // 创建标注
map.addOverlay(marker);              // 将标注添加到地图中

//创建信息窗口
var infoWindow = new BMap.InfoWindow("<p style='font-size:14px;'>这里可以显示一些信息，比如详细地址等！</p>");
marker.addEventListener("click", function(){this.openInfoWindow(infoWindow);});
<?php }else{?>
	<?php if ($cityname==''){?>
	map.centerAndZoom("广州",12);
	<?php }else{?>
	map.centerAndZoom("<?php echo $cityname?>",12);
	<?php }?>
<?php }?>

</script>
