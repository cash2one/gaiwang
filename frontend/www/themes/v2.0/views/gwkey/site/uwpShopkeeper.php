<?php
/** @var Controller $this */
$this->pageTitle = 'UWP盖掌柜APP_'.$this->pageTitle;
$this->description = 'UWP盖掌柜手机客户端是一款商户的贴心好帮手，具有商品扫码上架、无线打印订单、订单物料追踪等流畅的购物体验，还具有手机客户端特有的“库存更新”、“扫码追踪”、“扫码上架”等特色功能。移动购物为您提供愉悦的网上商城购物体验';
$this->keywords = 'UWP盖掌柜手机客户端，盖象商城';
?>
<script>
		//定位右边菜单
		$(window).scroll(function () {
			var gxlis=$(".GXYX-rightNav li");
			if($(document).scrollTop()>=300){
				$(".GXYX-rightNav").show();
				$(".GXYX-rightNav li").removeClass("on");
				$(gxlis).eq(0).addClass("on");
			}
			if($(document).scrollTop()<300){
				$(".GXYX-rightNav").hide();
			}
			if($(document).scrollTop()>=1200){
				$(".GXYX-rightNav li").removeClass("on");
				$(gxlis).eq(1).addClass("on");
			}
			if($(document).scrollTop()>=2000){
				$(".GXYX-rightNav li").removeClass("on");
				$(gxlis).eq(2).addClass("on");
			}
			if($(document).scrollTop()>=2700){
				$(".GXYX-rightNav li").removeClass("on");
				$(gxlis).eq(3).addClass("on");
			}
			if($(document).scrollTop()>=3400){
				$(".GXYX-rightNav li").removeClass("on");
				$(gxlis).eq(4).addClass("on");
			}
			if($(document).scrollTop()>=4100){
				$(".GXYX-rightNav li").removeClass("on");
				$(gxlis).eq(5).addClass("on");
			}
            if($(document).scrollTop()>=4800){
				$(".GXYX-rightNav li").removeClass("on");
				$(gxlis).eq(5).addClass("on");
			}
		})
	</script>

<?php $this->renderPartial('_nav'); ?>
<!-- 头部end -->
    <!-- 头部end -->
  	
  	<!--主体start-->
	<div class="coverTenpay-conter UWP-conter">
		<div class="UWPG01"></div>
		<div class="UWPG02">
		    <div id="page1"></div>
		</div>
		<div class="UWPG03"></div>
		<div class="UWPG04">
		    <div id="page2"></div>
		</div>
		<div class="UWPG05"></div>
		<div class="UWPG06">
		    <div id="page3"></div>
		</div>
		<div class="UWPG07">
		    <div id="page4"></div>
		</div>
		<div class="UWPG08"></div>
		<div class="UWPG09">
		    <div id="page5"></div>
		</div>
		<div class="UWPG10"></div>
		<div class="UWPG11">
		    <div id="page6"></div>
		</div>
		<div class="UWPG12"></div>
		<div class="UWPG13"></div>
		<div class="UWPG14"></div>
		<div class="GXYX-rightNav GXT-rightNav">
			<div class="GXYX-rightNav-line"></div>
			<ul>
				<li>
					<a href="#page1">Windows Hello</a>
				</li>
				<li>
					<a href="#page2">跨平台操作</a>
				</li>
				<li>
					<a href="#page3">扫码上架</a>
				</li>
				<li>
					<a href="#page4">更新库存</a>
				</li>
				<li>
					<a href="#page5">准时送货</a>
				</li>
				<li>
					<a href="#page6">订单查询</a>
				</li>
			</ul>
		</div>
	</div>
    <!-- 主体end -->