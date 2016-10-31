<?php
/** @var Controller $this */
$this->pageTitle = '盖讯通APP_'.$this->pageTitle;
$this->description = '盖讯通，让你我更贴近';
$this->keywords = '盖讯通，堪比微信！赶紧下载盖讯通APP,聊天，语音，图片，发积分红包，群聊等功能一样都不能少！';
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
        if($(document).scrollTop()>=3900){
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(4).addClass("on");
        }
        if($(document).scrollTop()>=5000){
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(5).addClass("on");
        }
    })
</script>
  <?php $this->renderPartial('_nav'); ?>
<!-- 头部end -->
  <?php 
       $iosUrl=AppVersion::getAppUrl(AppVersion::SYSTEM_TYPE_IOS,AppVersion::APP_TYPE_COVER_PAPER);
       $androidUrl=AppVersion::getAppUrl(AppVersion::SYSTEM_TYPE_ANDROID,AppVersion::APP_TYPE_COVER_PAPER);
     ?>
<!--主体start-->
<div class="coverTenpay-conter GXT-conter">
    <div class="GXT01">
         <div class="gwkey-link">   
		        <a class="link-07" <?php if(!empty($iosUrl)):?> href="<?php echo $iosUrl;?>" <?php endif;?>></a>
		        <a class="link-08" <?php if(!empty($androidUrl)):?> href="<?php echo $androidUrl;?>" <?php endif;?>></a>
	     </div>
    </div>
    <div class="GXT02">
        <div id="page1"></div>
    </div>
    <div class="GXT03"></div>
    <div class="GXT04"></div>
    <div class="GXT05">
        <div id="page2"></div>
    </div>
    <div class="GXT06"></div>
    <div class="GXT07">
        <div id="page3"></div>
    </div>
    <div class="GXT08"></div>
    <div class="GXT09"><div id="page4"></div></div>
    <div class="GXT10"></div>
    <div class="GXT11"></div>
    <div class="GXT12">
        <div id="page5"></div>
    </div>
    <div class="GXT13"></div>
    <div class="GXT14">
        <div id="page6"></div>
    </div>
    <div class="GXT15"></div>
    <div class="GXT16"></div>
    <div class="GXT17">
        <div class="tCon">
            <a href="#gx-top-title" title=""></a>
        </div>
    </div>
    <div class="GXT18"></div>
    <div class="GXYX-rightNav GXT-rightNav">
        <div class="GXYX-rightNav-line"></div>
        <ul>
            <li>
                <a href="#page1">即时聊天</a>
            </li>
            <li>
                <a href="#page2">发送红包</a>
            </li>
            <li>
                <a href="#page3">好友尽在掌握</a>
            </li>
            <li>
                <a href="#page4">动态消息</a>
            </li>
            <li>
                <a href="#page5">我的盖象主页</a>
            </li>
            <li>
                <a href="#page6">积分红包</a>
            </li>
        </ul>
    </div>
</div>