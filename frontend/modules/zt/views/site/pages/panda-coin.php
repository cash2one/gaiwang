
<?php  $this->pageTitle="盖象商城-熊猫币";?>
<style>
/*=====
    @Date:2016-07-29
    @content:熊猫币
	@author:林聪毅
 =====*/
.zt-wrap{width:100%; background:#fff; overflow: hidden;}
.zt-con { width:968px; margin:0 auto; position:relative; }
.zt-con a{ position:absolute;display:block;}
.panda-coin-01{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-01.jpg) top center no-repeat;}
.panda-coin-02{height:326px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-02.jpg) top center no-repeat;}
.panda-coin-03{height:548px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-03.jpg) top center no-repeat;}
.panda-coin-04{height:500px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-04.jpg) top center no-repeat;}
.panda-coin-05{height:500px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-05.jpg) top center no-repeat;}
.panda-coin-06{height:510px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-06.jpg) top center no-repeat;}
.panda-coin-07{height:514px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-07.jpg) top center no-repeat;}
.panda-coin-08{height:514px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-08.jpg) top center no-repeat;}
.panda-coin-09{height:749px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-09.jpg) top center no-repeat;}
.panda-coin-10{height:802px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-10.jpg) top center no-repeat;}

.panda-coin-11{height:853px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-11.jpg) top center no-repeat;}
.panda-coin-12{height:240px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-12.jpg) top center no-repeat;}
.panda-coin-13{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-13.jpg) top center no-repeat;}
.panda-coin-14{height:301px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-14.jpg) top center no-repeat;}
.panda-coin-15{height:308px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-15.jpg) top center no-repeat;}
.panda-coin-16{height:343px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-16.jpg) top center no-repeat;}
.panda-coin-17{height:275px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/panda-coin-17.jpg) top center no-repeat;}

.coin{position: absolute;}
.panda-coin-02 .coin-01{width: 212px; height: 213px; background: url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/_coin-01.png) no-repeat; left: 150px; top: 40px;}
.panda-coin-02 .coin-02{width: 212px; height: 212px; background: url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/_coin-02.png) no-repeat; left: 390px; top: 0px;}
.panda-coin-02 .coin-03{width: 214px; height: 215px; background: url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/_coin-03.png) no-repeat; left: 630px; top: 40px;}
.panda-coin-02 .coin.bounce{
	animation: bounce 0.8s linear 0s 1 forwards;
	-webkit-animation: bounce 0.8s linear 0s 1 forwards;
	-moz-animation: bounce 0.8s linear 0s 1 forwards;
}
@keyframes bounce{
	0%{transform:translateY(-30px);}
	33%{transform:translateY(0px);}
	66%{transform:translateY(-10px);}
	100%{transform:translateY(0px);}
}
@-webkit-keyframes bounce{
	0%{-webkit-transform:translateY(-30px);}
	33%{-webkit-transform:translateY(0px);}
	66%{-webkit-transform:translateY(-10px);}
	100%{-webkit-transform:translateY(0px);}
}
@-moz-keyframes bounce{
	0%{-moz-transform:translateY(30px);}
	33%{-moz-transform:translateY(0px);}
	66%{-moz-transform:translateY(-10px);}
	100%{-moz-transform:translateY(0px);}
}
.panda-coin-04 .coin-01{width: 245px; height: 245px; background: url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/coin-01.png) no-repeat; left: 526px; top: 120px;}
.panda-coin-05 .coin-02{width: 247px; height: 247px; background: url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/coin-02.png) no-repeat; left: 28px; top: 102px;}
.panda-coin-06 .coin-03{width: 238px; height: 238px; background: url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/coin-03.png) no-repeat; left: 510px; top: 120px;}
.coin.on{
	animation: slide_left 1s ease-out 0s 1 forwards;
	-webkit-animation: slide_left 1s ease-out 0s 1 forwards;
	-moz-animation: slide_left 1s ease-out 0s 1 forwards;
}
@keyframes slide_left{
	from{transform:translateX(180px);}
	to{transform:translateX(0px);}
}
@-webkit-keyframes slide_left{
	from{-webkit-transform:translateX(180px);}
	to{-webkit-transform:translateX(-0px);}
}
@-moz-keyframes slide_left{
	from{-moz-transform:translateX(180px);}
	to{-moz-transform:translateX(0px);}
}
.panda-coin-08 a{width: 420px; height: 44px; left: 506px;}
.panda-coin-08 .a1{top: 208px;}
.panda-coin-08 .a2{top: 252px;}
.panda-coin-08 .a3{top: 298px;}
.panda-coin-09 a{width: 420px; height: 84px; top: 492px;}
.panda-coin-09 .a1{left: 530px;}
.panda-coin-10 a{width: 420px; height: 84px; top: 626px;}
.panda-coin-10 .a1{left: 530px;}
.panda-coin-10 .tips{width: 386px; height: 55px; background: url(<?php echo ATTR_DOMAIN;?>/zt/panda-coin/tips.png) no-repeat; position: absolute; left: 550px; top: 550px;}
.panda-coin-10 .tips.bounce{
	animation: bounce 0.8s linear 0s 1 forwards;
	-webkit-animation: bounce 0.8s linear 0s 1 forwards;
	-moz-animation: bounce 0.8s linear 0s 1 forwards;
}
.panda-coin-11 a{width: 420px; height: 84px; top: 550px;}
.panda-coin-11 .a1{left: 530px;}
</style>
	
	<div class="zt-wrap">			
		<div class="panda-coin-01"></div>
		<div class="panda-coin-02">
			<div class="zt-con">
				<div class="bounce coin coin-01"></div>
				<div class="bounce coin coin-02"></div>
				<div class="bounce coin coin-03"></div>
			</div>
		</div>
		<div class="panda-coin-03"></div>
		<div class="panda-coin-04">
			<div class="zt-con">
				<div class="coin coin-01"></div>
			</div>
		</div>
		<div class="panda-coin-05">
			<div class="zt-con">
				<div class="coin coin-02"></div>
			</div>
		</div>
		<div class="panda-coin-06">
			<div class="zt-con">
				<div class="coin coin-03"></div>
			</div>
		</div>
		<div class="panda-coin-07"></div>
		<div class="panda-coin-08">
			<div class="zt-con">
				<a href="http://www.g-emall.com/goods/51578.html" title="2014版熊猫1盎司圆形银币 2014银猫 猫币优惠抄底" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/114835.html" title="2015年熊猫银币（1oz）" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/1765924.html" title="【收藏必备】2016年熊猫银币 30g熊猫银币 重大改版，盎司改克" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="panda-coin-09">
			<div class="zt-con">
				<a href="http://www.g-emall.com/goods/1233985.html" title="【收藏必备】熊猫纪念银币 三只有故事的熊猫 2014.2015.2016版（三枚装）" class="a1" target="_blank"></a>
			</div>
		</div>
		<div class="panda-coin-10">
			<div class="zt-con">
				<div class="tips"></div>
				<a href="http://www.g-emall.com/goods/850508.html" title="【收藏必备】熊猫纪念银币 三只有故事的熊猫 2014.2015.2016版（一盒15枚）" class="a1" target="_blank"></a>
			</div>
		</div>

		<div class="panda-coin-11">
			<div class="zt-con">
				<a href="http://www.g-emall.com/goods/1766799.html" title="【收藏必备】2013年2014年版熊猫银币 精品礼盒装24枚" class="a1" target="_blank"></a>
			</div>
		</div>
		<div class="panda-coin-12"></div>
		<div class="panda-coin-13"></div>
		<div class="panda-coin-14"></div>
		<div class="panda-coin-15"></div>
		<div class="panda-coin-16"></div>
		<div class="panda-coin-17"></div>
	</div>   
   <!--------------主体 End------------>
<!-- 返回顶部 end-->
<script type="text/javascript">
$(function(){
	var scrollTop = 0;
	$(window).scroll(function(){
		scrollTop = $(document).scrollTop();
		console.log(scrollTop);
		if(scrollTop>=900&&scrollTop<=1900){
			$('.panda-coin-04 .coin-01').addClass('on');
		}
		else{
			$('.panda-coin-04 .coin-01').removeClass('on');
		}
		if(scrollTop>=1400&&scrollTop<=2300){
			$('.panda-coin-05 .coin-02').addClass('on');
		}
		else{
			$('.panda-coin-05 .coin-02').removeClass('on');
		}
		if(scrollTop>=1800&&scrollTop<=2800){
			$('.panda-coin-06 .coin-03').addClass('on');
		}
		else{
			$('.panda-coin-06 .coin-03').removeClass('on');
		}
		if(scrollTop>=4500&&scrollTop<=5400){
			$('.panda-coin-10 .tips').addClass('bounce');
		}
		else{
			$('.panda-coin-10 .tips').removeClass('bounce');
		}
	})
})
</script>