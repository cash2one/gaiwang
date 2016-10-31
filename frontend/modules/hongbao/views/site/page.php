<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="盖网,网上购物,网上商城,积分兑换,积分消费,手机,笔记本,电脑,数码,服装,手表,化妆品,保健品,盖象商城" />
        <meta name="Description" content="盖网,盖象商城-中国最大的网上购物及积分兑换消费商城，便捷，诚信的服务,为您提供愉悦的网上商城购物体验!" />
       <style type="text/css">
		*{margin:0;padding:0;list-style-type:none;}
		a,img{border:0;}
	
		.clearfix:after {clear: both; content: '.';display: block;visibility: hidden;height: 0;}
		.clearfix {display: inline-block;}
		* html .clearfix {height: 1%;}
		.clearfix {display: block;}
		*+html .clearfix{min-height:1%;}
		.bg01{width:100%;padding-top:470px;height:155px;background:url(/images/bgs/jjkc01.jpg) top center no-repeat;}
		/* colockbox */
		.colockbox{width:410px;height:123px;margin:0px auto;background:url(/images/bgs/jjopenbg.png) no-repeat;}
		.colockbox span{float:left;font-family:Arial, Helvetica, sans-serif;display:block;width:98px;height:100px;line-height:100px;font-size:80px;text-align:center;color:#ffffff;}		
		.day{margin-left: 15px;} 
		.hour{margin-left:6px;}
		.minute{margin-left:52px;}
		.second{margin-left:47px;}
	
</style>
</head>
<body>
<div class="wrap">
	<div class="bg01">
		<div class="colockbox clearfix" id="demo01">
			<!-- <span class="day">-</span> -->
			<span class="hour">-</span>
			<span class="minute">-</span>
			<span class="second">-</span>
		</div>
	</div>
	<div style="background:url(/images/bgs/jjkc02.jpg) top center no-repeat;height:600px;"></div>
	<div style="background:url(/images/bgs/jjkc03.jpg) top center no-repeat;height:333px;overflow:hidden;">
		<div style="width:1200px;margin:0 auto">
			<a style="display:block;width:500px;height:120px;margin:187px auto;" href="http://www.g-emall.com"> </a>
		</div>
	</div>
</div>
<script type="text/javascript" src="http://www.g-emall.com/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
	$(function(){
		countDown("2015/1/26 21:13:14","#demo01 .day","#demo01 .hour","#demo01 .minute","#demo01 .second");
	});
	
	function countDown(time,day_elem,hour_elem,minute_elem,second_elem){
		//if(typeof end_time == "string")
		var end_time = new Date(time).getTime(),//月份是实际月份-1
		//current_time = new Date().getTime(),
		sys_second = (end_time-new Date().getTime())/1000;
		var timer = setInterval(function(){
			if (sys_second > 0) {
				sys_second -= 1;
				var day = Math.floor((sys_second / 3600) / 24);
				var hour = Math.floor((sys_second / 3600) % 24);
				var minute = Math.floor((sys_second / 60) % 60);
				var second = Math.floor(sys_second % 60);
				day_elem && $(day_elem).text(day);//计算天
				$(hour_elem).text(hour<10?"0"+hour:hour);//计算小时
				$(minute_elem).text(minute<10?"0"+minute:minute);//计算分
				$(second_elem).text(second<10?"0"+second:second);// 计算秒
			} else { 
				clearInterval(timer);
			}
		}, 1000);
	}
</script>

</body>
</html>
