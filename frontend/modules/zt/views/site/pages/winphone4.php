<?php $this->pageTitle = "手机拍卖专场预告" . $this->pageTitle;?>
<style type='text/css'>
	/*=====
	    @Date:2016-04-27
	    @content:拍卖会
		@author:林聪毅
	 =====*/
	.zt-wrap{width:100%; background:#fff; overflow: hidden;}
	.zt-con { width:968px; margin:0 auto; position:relative; }
	.zt-con a{ position:absolute;display:block;}
	.winphone4-01{height:465px; background:url(<?php echo ATTR_DOMAIN;?>/zt/winphone4/winphone4-01.jpg) top center no-repeat;}
	.winphone4-02{height:465px; background:url(<?php echo ATTR_DOMAIN;?>/zt/winphone4/winphone4-02.jpg) top center no-repeat;}
	.winphone4-03{height:392px; background:url(<?php echo ATTR_DOMAIN;?>/zt/winphone4/winphone4-03.jpg) top center no-repeat;}
	.winphone4-04{height:432px; background:url(<?php echo ATTR_DOMAIN;?>/zt/winphone4/winphone4-04.jpg) top center no-repeat;}
	.winphone4-05{height:431px; background:url(<?php echo ATTR_DOMAIN;?>/zt/winphone4/winphone4-05.jpg) top center no-repeat;}
	.winphone4-06{height:342px; background:url(<?php echo ATTR_DOMAIN;?>/zt/winphone4/winphone4-06.jpg) top center no-repeat;}
	.winphone4-07{height:342px; background:url(<?php echo ATTR_DOMAIN;?>/zt/winphone4/winphone4-07.jpg) top center no-repeat;}
	.winphone4-08{height:295px; background:url(<?php echo ATTR_DOMAIN;?>/zt/winphone4/winphone4-08.jpg) top center no-repeat;}

	.winphone4-03 .time-box{width: 830px; height: 160px; color: #fff; position: absolute; left: 90px; top: 140px;}
	.winphone4-03 .time-box span{
		display: inline-block; 
		font-size: 100px;
	}
	.winphone4-03 .time-box .day,
	.winphone4-03 .time-box .hour,
	.winphone4-03 .time-box .min,
	.winphone4-03 .time-box .sec{width: 120px; text-align: center;}
	.winphone4-03 .time-box span.clip{margin: 0 28px; width: 40px;}
	.winphone4-03 .time-box .day{left: 0px;}
	.winphone4-03 .time-box .hour{left: 0px;}
	.winphone4-03 .time-box .min{left: 0px;}
	.winphone4-03 .time-box .sec{left: 0px;}
	.mgl10{margin-left: 10px;}
</style>
	
	<div class="zt-wrap">			
		<div class="winphone4-01"></div>
		<div class="winphone4-02"></div>
		<div class="winphone4-03">
			<div class="zt-con">
				<div class="time-box">
					<span class="day">12</span><span class="clip">：</span>
					<span class="hour">12</span><span class="clip">：</span>
					<span class="min">12</span><span class="clip">：</span>
					<span class="sec">12</span>
				</div>
			</div>
		</div>
		<div class="winphone4-04"></div>
		<div class="winphone4-05"></div>
		<div class="winphone4-06"></div>
		<div class="winphone4-07"></div>
		<div class="winphone4-08"></div>
	</div>
	<script type="text/javascript">
	$(function(){
		var timer = null;
		var time_start = new Date();
		var time_end = new Date('2016/05/09 08:00');
		if(time_start.getTime()>time_end.getTime()){
			$('.day,.hour,.min,.sec').html('00')
		}
		else{
			timeCounter()
			timer = setInterval(timeCounter,1000)
		}
		function timeCounter(){
			time_start = new Date();
			var time = time_end.getTime()-time_start.getTime();
			var day = Math.floor(time/86400000);//24*60*60*1000
			time = time - day*86400000;
			var hour = Math.floor(time/3600000);//60*60*1000
			time = time - hour*3600000;
			var min = Math.floor(time/60000);
			time = time - min*60000;
			var sec = Math.floor(time/1000);
			if (day < 10) {
                day = "0" + day;
            }
			if (hour < 10) {
                hour = "0" + hour;
            }
            if (min < 10) {
                min = "0" + min;
            }
            if (sec < 10) {
                sec = "0" + sec;
            }
            $('.day').html(day);
            $('.hour').html(hour);
            $('.min').html(min);
            $('.sec').html(sec);
		}
	})
	</script>   
  