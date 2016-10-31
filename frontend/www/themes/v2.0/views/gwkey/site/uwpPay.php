<?php
/** @var Controller $this */
$this->pageTitle = 'UWP盖付通APP_'.$this->pageTitle;
$this->description = 'UWP盖付通APP';
$this->keywords = 'UWP盖付通手机客户端，盖象商城';
?>

	<script>
		//定位右边菜单
		$(window).scroll(function () {
			var gxlis=$(".GXYX-rightNav3 li");
			if($(document).scrollTop()>=300){
				$(".GXYX-rightNav3").show();
				$(".GXYX-rightNav3 li").removeClass("on");
				$(gxlis).eq(0).addClass("on");
			}
			if($(document).scrollTop()<300){
				$(".GXYX-rightNav3").hide();
			}
			if($(document).scrollTop()>=1300){
				$(".GXYX-rightNav3 li").removeClass("on");
				$(gxlis).eq(1).addClass("on");
			}
			if($(document).scrollTop()>=2100){
				$(".GXYX-rightNav3 li").removeClass("on");
				$(gxlis).eq(2).addClass("on");
			}
			if($(document).scrollTop()>=2800){
				$(".GXYX-rightNav3 li").removeClass("on");
				$(gxlis).eq(3).addClass("on");
			}
			if($(document).scrollTop()>=3500){
				$(".GXYX-rightNav3 li").removeClass("on");
				$(gxlis).eq(4).addClass("on");
			}
		})
	</script>

<?php $this->renderPartial('_nav'); ?>
<!-- 头部end -->
  	
  	<!--主体start-->
	<div class="coverTenpay-conter UWP-conter">
		<div class="UWP01"></div>
		<div class="UWP02">
		    <div id="page1"></div>
		</div>
		<div class="UWP03"></div>
		<div class="UWP04">
		    <div id="page2"></div>
		</div>
		<div class="UWP05"></div>
		<div class="UWP06">
		    <div id="page3"></div>
		</div>
		<div class="UWP07">
		    <div id="page4"></div>
		</div>
		<div class="UWP08"></div>
		<div class="UWP09">
		    <div id="page5"></div>
		</div>
		<div class="UWP10"></div>
		<div class="UWP11"></div>
		<div class="UWP12"></div>
		<div class="GXYX-rightNav3 GXT-rightNav">
			<div class="UWP-rightNav-line"></div>
			<ul>
				<li>
					<a href="#page1">Windows Hello</a>
				</li>
				<li>
					<a href="#page2">跨平台操作</a>
				</li>
				<li>
					<a href="#page3">扫码支付</a>
				</li>
				<li>
					<a href="#page4">安全保障</a>
				</li>
				<li>
					<a href="#page5">安全支付</a>
				</li>
			</ul>
		</div>
	</div>
    <!-- 主体end -->