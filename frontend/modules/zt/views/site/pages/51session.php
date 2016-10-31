<?php $this->pageTitle = "五一黄金购活动" . $this->pageTitle;?>
<style type='text/css'>
	/*=====
	    @Date:2016-07-09
	    @content:5-1专场
		@author:林聪毅
	 =====*/
	.zt-wrap{width:100%; background:#fff; overflow: hidden;}
	.zt-con { width:968px; margin:0 auto; position:relative; }
	.zt-con a{ position:absolute;display:block;}
	.session51-01{height:171px; background:url(<?php echo ATTR_DOMAIN;?>/zt/session51/session51-01.jpg) top center no-repeat;}
	.session51-02{height:170px; background:url(<?php echo ATTR_DOMAIN;?>/zt/session51/session51-02.jpg) top center no-repeat;}
	.session51-03{height:171px; background:url(<?php echo ATTR_DOMAIN;?>/zt/session51/session51-03.jpg) top center no-repeat;}
	.session51-04{height:89px; background:url(<?php echo ATTR_DOMAIN;?>/zt/session51/session51-04.jpg) top center no-repeat;}
	.session51-05{height:88px; background:url(<?php echo ATTR_DOMAIN;?>/zt/session51/session51-05.jpg) top center no-repeat;}
	.session51-06{height:88px; background:url(<?php echo ATTR_DOMAIN;?>/zt/session51/session51-06.jpg) top center no-repeat;}
	.session51-07{height:87px; background:url(<?php echo ATTR_DOMAIN;?>/zt/session51/session51-07.jpg) top center no-repeat;}
	.session51-08{height:216px; background:url(<?php echo ATTR_DOMAIN;?>/zt/session51/session51-08.jpg) top center no-repeat;}

	.session51-04 a{ width:392px; height:174px; top:0px;}
	.session51-04 .a1{left:-107px; }
	.session51-04 .a2{left:287px; }
	.session51-04 .a3{left:680px; }
	.session51-06 a{ width:392px; height:174px; top:0px;}
	.session51-06 .a1{left:-107px; }
	.session51-06 .a2{left:287px; }
	.session51-06 .a3{left:680px; }
	.car{
		width: 83px; height: 66px; 
		background: url(<?php echo ATTR_DOMAIN;?>/zt/session51/car.png) no-repeat;
		position: absolute; left: 0px; top: 0px;
	}
</style>
	
	<div class="zt-wrap">			
		<div class="session51-01"></div>
		<div class="session51-02"></div>
		<div class="session51-03"></div>
		<div class="session51-04">
			<div class="zt-con">	
				<a href="http://active.g-emall.com/festive/detail/121" class="a1" target="_blank"></a>
				<a href="http://active.g-emall.com/festive/detail/125" class="a2" target="_blank"></a>
				<a href="http://active.g-emall.com/festive/detail/122" class="a3" target="_blank"></a>			
			</div>
		</div>
		<div class="session51-05"></div>
		<div class="session51-06">
			<div class="zt-con">	
				<a href="http://active.g-emall.com/festive/detail/123" class="a1" target="_blank"></a>
				<a href="http://active.g-emall.com/festive/detail/126" class="a2" target="_blank"></a>
				<a href="http://active.g-emall.com/festive/detail/124" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="session51-07"></div>
		<div class="session51-08">
			<div class="zt-con">
				<div class="car"></div>
			</div>
		</div>
	</div>   
   
<script type="text/javascript">
$(function(){
	var oLeft = [1030,770,570,280,30,-170];
	var oTop = [150,80,90,20,110,40];
	var timer = null;
	var i = 0;
	var len = oLeft.length;
	setInterval(function(){
		if (i>=len) {
			i=0
		};
		console.log(i)
		$('.car').css({'left':oLeft[i],'top':oTop[i]});
		i++;
	},500)
})
</script>	
