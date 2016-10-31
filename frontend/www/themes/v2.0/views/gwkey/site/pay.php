<?php
/** @var Controller $this */
$this->pageTitle = '盖付通APP_'.$this->pageTitle;
$this->description = '盖付通是广州涌智信息科技有限公司推出的，免费安装在用户手机上的安全认证产品。通过使用盖付通，在您进行线下盖网通积分消费支付的时候，可以选择使用盖付通的动态密码进行支付，安全方便，确保您的账户更加安全。盖付通下载';
$this->keywords = '盖付通，使用简单，安全性高，低成本，容易获取';
?>
<script>
    //定位右边菜单
    $(window).scroll(function () {
        var gxlis=$(".GXYX-rightNav li");
        if($(document).scrollTop()>=400){
            $(".GXYX-rightNav").show();
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(0).addClass("on");
        }
        if($(document).scrollTop()<400){
            $(".GXYX-rightNav").hide();
        }
        if($(document).scrollTop()>=1400){
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(1).addClass("on");
        }
        if($(document).scrollTop()>=2100){
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(2).addClass("on");
        }
        if($(document).scrollTop()>=2800){
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(3).addClass("on");
        }
        if($(document).scrollTop()>=3500){
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(4).addClass("on");
        }
        if($(document).scrollTop()>=4200){
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(5).addClass("on");
        }
    })
</script>

<?php $this->renderPartial('_nav'); ?>
<!-- 头部end -->
   <?php 
       $iosUrl=AppVersion::getAppUrl(AppVersion::SYSTEM_TYPE_IOS,AppVersion::APP_TYPE_TOKEN);
       $androidUrl=AppVersion::getAppUrl(AppVersion::SYSTEM_TYPE_ANDROID,AppVersion::APP_TYPE_TOKEN);
     ?>
<!--主体start-->
<div class="coverTenpay-conter">
    <div class="coverTenpay01">
         <div class="gwkey-link">
		        <a class="link-03" <?php if(!empty($iosUrl)):?> href="<?php echo $iosUrl;?>" <?php endif;?>></a>
		        <a class="link-04" <?php if(!empty($androidUrl)):?> href="<?php echo $androidUrl;?>" <?php endif;?>></a>
		 </div>
     </div>
    <div class="coverTenpay02">
        <div id="page1"></div>
    </div>
    <div class="coverTenpay03"></div>
    <div class="coverTenpay04">
        <div id="page2"></div>
    </div>
    <div class="coverTenpay05"></div>
    <div class="coverTenpay06">
        <div id="page3"></div>
    </div>
    <div class="coverTenpay07"></div>
    <div class="coverTenpay08">
        <div id="page4"></div>
    </div>
    <div class="coverTenpay09"></div>
    <div class="coverTenpay10">
        <div id="page5"></div>
    </div>
    <div class="coverTenpay11"></div>
    <div class="coverTenpay12">
        <div id="page6"></div>
    </div>
    <div class="coverTenpay13"></div>
    <div class="coverTenpay14">
        <div class="tCon">
            <a href="#gx-top-title" title=""></a>
        </div>
    </div>
    <div class="GXYX-rightNav GXYX-rightNav2">
        <div class="GXYX-rightNav2-line"></div>
        <ul>
            <li>
                <a href="#page1">扫码支付</a>
            </li>
            <li>
                <a href="#page2">线下消费</a>
            </li>
            <li>
                <a href="#page3">安全保障</a>
            </li>
            <li>
                <a href="#page4">安全支付</a>
            </li>
            <li>
                <a href="#page5">消费无障碍</a>
            </li>
            <li>
                <a href="#page6">热门手游</a>
            </li>
        </ul>
    </div>
</div>
<!-- 主体end -->