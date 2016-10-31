<?php
/** @var Controller $this */
$this->pageTitle = '盖象优选APP_'.$this->pageTitle;
$this->description = '盖象优选，一款给您提供更优惠、更优质、更新鲜的购物体验的APP。随时随地、每时每刻，轻松迈入指尖购物时代。盖象优选下载';
$this->keywords = '盖象优选，臻致生活，商品热卖，商务小礼，盖鲜汇';
?>
<script>
    //定位右边菜单
    $(window).scroll(function () {
        var gxlis=$(".GXYX-rightNav li");
        if($(document).scrollTop()>=500){
            $(".GXYX-rightNav").show();
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(0).addClass("on");
        }
        if($(document).scrollTop()<500){
            $(".GXYX-rightNav").hide();
        }
        if($(document).scrollTop()>=1300){
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(1).addClass("on");
        }
        if($(document).scrollTop()>=2200){
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(2).addClass("on");
        }
        if($(document).scrollTop()>=3100){
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(3).addClass("on");
        }
        if($(document).scrollTop()>=4200){
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(4).addClass("on");
        }
        if($(document).scrollTop()>=5200){
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(5).addClass("on");
        }
    })
</script>

<?php $this->renderPartial('_nav'); ?>
<!-- 头部end -->
   <?php 
       $iosUrl=AppVersion::getAppUrl(AppVersion::SYSTEM_TYPE_IOS,AppVersion::APP_TYPE_GAIWANGAPP);
       $androidUrl=AppVersion::getAppUrl(AppVersion::SYSTEM_TYPE_ANDROID,AppVersion::APP_TYPE_GAIWANGAPP);
     ?>
<!--主体start-->
<div class="coverTenpay-conter GXYX2-conter">
    <div class="GXYX2-01-01">
        <div class="gwkey-link">
		        <a class="link-01" <?php if(!empty($iosUrl)):?> href="<?php echo $iosUrl;?>" <?php endif;?>></a>
		        <a class="link-02" <?php if(!empty($androidUrl)):?> href="<?php echo $androidUrl;?>" <?php endif;?>></a>
		</div>
    </div>
    <div class="GXYX2-01-02"></div>
        <div class="GXYX2-01-03"></div>
		<div class="GXYX2-02">
			<div id="page1"></div>
		</div>
		<div class="GXYX2-03"></div>
		<div class="GXYX2-04"></div>
		<div class="GXYX2-05">
			<div id="page2"></div>
		</div>
		<div class="GXYX2-06"></div>
		<div class="GXYX2-07">
			<div id="page3"></div>
		</div>
		<div class="GXYX2-08"></div>
		<div class="GXYX2-09"></div>
		<div class="GXYX2-10">
            <div id="page4"></div>
        </div>
		<div class="GXYX2-11"></div>
		<div class="GXYX2-12"></div>
		<div class="GXYX2-13">
			<div id="page5"></div>
		</div>
		<div class="GXYX2-14"></div>
		<div class="GXYX-rightNav">
			<div class="GXYX-rightNav-line"></div>
			<ul>
				<li>
					<a href="#page1">新动</a>
				</li>
				<li>
					<a href="#page2">仕品</a>
				</li>
				<li>
					<a href="#page3">至优商旅</a>
				</li>
				<li>
					<a href="#page4">臻致生活</a>
				</li>
				<li>
					<a href="#page5">盖鲜汇</a>
				</li>
			</ul>
		</div>
	</div>
<!-- 主体end -->