/*tab 切换 所有涉及到tab切换的请套用此方法*/
function setTab(name,cursel,n){
	for(i=1;i<=n;i++){
		var menu=$("#"+name+i);
		var con=$("#tabCon_"+name+"_"+i);
		if(i==cursel){
			$("#"+name+i).addClass("curr");
			$("#tabCon_"+name+"_"+i).css({"display":'block'});
		}else{
			$("#"+name+i).removeClass("curr");
			$("#tabCon_"+name+"_"+i).css({"display":'none'});
		}
	}
}

/*针对ie6.7 升级浏览器提示*/
$(function(){
	if(navigator.appName == "Microsoft Internet Explorer"){
		if(navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE6.0" || navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE7.0"){
			$("body").prepend('<div class="icon_v browserSug">温馨提示：您当前使用的浏览器版本过低，兼容性和安全性较差，盖象商城建议您升级: <a class="red" href="http://windows.microsoft.com/zh-cn/windows/upgrade-your-browser">IE8浏览器</a></div>');
		}
	}
	
})


