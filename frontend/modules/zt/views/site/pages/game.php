	<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.flexslider-min.js');
    $this->pageTitle = "超级盖商 - ".$this->pageTitle;
    ?>
	<style type="text/css">
		/*=====
		    @Date:2014-11-17
		    @content:
			@author:林聪毅
		 =====*/
		.zt-wrap{width:100%; background:#fff;}
		.zt-con { width:1110px; margin:0 auto; position:relative; }
		.zt-con a{ position:absolute;display:block;}
		.gate-business-01{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/game/gate-business-01.jpg) top center no-repeat;}
		.gate-business-02{height:300px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/gate-business-02.jpg) top center no-repeat;}
		.gate-business-03{height:300px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/gate-business-03.jpg) top center no-repeat;}
		.gate-business-04{height:299px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/gate-business-04.jpg) top center no-repeat;}
		.gate-business-05{height:300px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/gate-business-05.jpg) top center no-repeat;}
		.gate-business-06{height:289px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/gate-business-06.jpg) top center no-repeat;}
		.gate-business-07{height:458px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/gate-business-07.jpg) top center no-repeat;}
		.gate-business-08{height:458px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/gate-business-08.jpg) top center no-repeat;}
		.gate-business-09{height:519px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/gate-business-09.jpg) top center no-repeat;}
		.gate-business-10{height:518px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/gate-business-10.jpg) top center no-repeat;}

		.gate-business-11{height:1062px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/gate-business-11.jpg) top center no-repeat;}
		.gate-business-12{height:897px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/gate-business-12.jpg) top center no-repeat;}
		.gate-business-13{height:796px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/gate-business-13.jpg) top center no-repeat;}
		.gate-business-14{height:281px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/gate-business-14.jpg) top center no-repeat;}
		.gate-business-15{height:281px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/gate-business-15.jpg) top center no-repeat;}
		.gate-business-16{height:281px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/gate-business-16.jpg) top center no-repeat;}


		.flexslider{overflow: inherit; height: auto;}
		.flex-viewport{height: auto; left: -16px; top: 184px; z-index: 3;}
		.flexslider .slides li{height: auto; width: 1104px;}
		.flexslider .slides li a{height: auto;}
		.zt-con .flex-direction-nav li a.flex-prev {width: 160px; height: 100px; left:0px; top: 150px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/arrow-left.png) no-repeat; }
		.zt-con .flex-direction-nav li a.flex-next {width: 160px; height: 100px; right:40px; top: 150px; background:url(<?php echo ATTR_DOMAIN?>/zt/game/arrow-right.png) no-repeat; }
		.flex-direction-nav li a{display: block;width: 54px;height: 72px;top:-10px;overflow: hidden;cursor: pointer;position: absolute;}
		.flex-control-nav{top: 0px;}
		.flex-control-nav li a{width: 216px; height: 100px;}
		.flex-control-nav li:nth-child(1) a{background: url(<?php echo ATTR_DOMAIN?>/zt/game/bannerLable-01.png) no-repeat; left: 32px; top: 90px;}
		.flex-control-nav li:nth-child(2) a{background: url(<?php echo ATTR_DOMAIN?>/zt/game/bannerLable-02.png) no-repeat; left: 246px; top: 90px;}
		.flex-control-nav li:nth-child(3) a{background: url(<?php echo ATTR_DOMAIN?>/zt/game/bannerLable-03.png) no-repeat; left: 460px; top: 90px;}
		.flex-control-nav li:nth-child(4) a{background: url(<?php echo ATTR_DOMAIN?>/zt/game/bannerLable-04.png) no-repeat; left: 670px; top: 90px;}
		.flex-active{z-index: 2;}

	</style>
	<div class="zt-wrap">			
		<div class="gate-business-01"></div>
		<div class="gate-business-02"></div>
		<div class="gate-business-03"></div>
		<div class="gate-business-04"></div>
		<div class="gate-business-05"></div>
		<div class="gate-business-06"></div>
		<div class="gate-business-07"></div>
		<div class="gate-business-08"></div>
		<div class="gate-business-09"></div>
		<div class="gate-business-10"></div>

		<div class="gate-business-11"></div>
		<div class="gate-business-12"></div>
		<div class="gate-business-13">
			<div class="zt-con flexslider">					
				<ul class="slides">
					<li><img src="<?php echo ATTR_DOMAIN?>/zt/game/banner-01.jpg"></li>
					<li><img src="<?php echo ATTR_DOMAIN?>/zt/game/banner-02.jpg"></li>
					<li><img src="<?php echo ATTR_DOMAIN?>/zt/game/banner-03.jpg"></li>
					<li><img src="<?php echo ATTR_DOMAIN?>/zt/game/banner-04.jpg"></li>
				</ul>
			</div>
		</div>
		<div class="gate-business-14"></div>
		<div class="gate-business-15"></div>
		<div class="gate-business-16"></div>
		<div class="gate-business-17"></div>
		<div class="gate-business-18"></div>
	</div>  

	<!-- 返回顶部 end-->
	<script type="text/javascript">
	$(function(){
		$('.flexslider').flexslider({
			animation: "slide",
			directionNav: true,
			controlNav: true,
			slideshow: false,
			slideshowSpeed: 5000
		});
		$('.flex-control-nav li a').html('')
	})
	</script>