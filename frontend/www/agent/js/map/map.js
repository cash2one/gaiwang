/**
 * lng：经度
 * lat：纬度
 * type：适用类型
 * cityname：默认显示城市
 * level：地图等级
 * url：访问地址
 * api：地图api
 */
//显示地图
function _doMap(lng,lat,type,cityname,level,url,api){
	if(type=='use'){
		if(lng==''||lat==''){
			alert('请提经度控件和纬度控件的id');
			return false;
		}

		var lngval = $('#'+lng).val();
		var latval = $('#'+lat).val();
		var sCityname = $('#'+cityname).val()==undefined?"广州":$('#'+cityname).val();
		url = createUrl(url, {lng:lngval,lat:latval,api:api,cityname:encodeURIComponent(sCityname)});
		
	}else{
		var lngval = lng;														
		var latval = lat;
		var sCityname = $('#'+cityname).val()==undefined?"广州":$('#'+cityname).val();
		url = createUrl(url, {lng:lngval,lat:latval,api:api,cityname:encodeURIComponent(sCityname),level:level});
	}

	art.dialog.open(url,{
		title: "盖机地图坐标(当前坐标："+lngval+","+latval+")",
		lock: true,
		width: 740,
		height: 630,
		init:function(){},
		ok:function(){
			var iframe = this.iframe.contentWindow;
			if(!iframe.document.body){
				alert("iframe还没有加载完毕!");
				return false;
			}

			if(type=='use'){
				var newLng = iframe.document.getElementById('lng').value;		//经度
				var newLat = iframe.document.getElementById('lat').value;		//纬度
				
				$('#'+lng).val(newLng);		//赋新值
				$('#'+lat).val(newLat);		//赋新值
			}
		},
		cancel:true
	});
}

/*
 * 生成url的js方法
 */
function createUrl(route, param)
{
	var urlFormat = "/";
	
	if(route.slice(-1)!=urlFormat) route = route+urlFormat;	
	
	for(var key in param)
	{
		route += key+urlFormat+param[key]+urlFormat;
	}
	return route;
}
