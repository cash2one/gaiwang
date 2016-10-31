<?php
/** @var Controller $this */
$this->pageTitle = '盖掌柜APP_'.$this->pageTitle;
$this->description = '盖掌柜手机客户端是一款商户的贴心好帮手，具有商品扫码上架、无线打印订单、订单物料追踪等流畅的购物体验，还具有手机客户端特有的“库存更新”、“扫码追踪”、“扫码上架”等特色功能。移动购物为您提供愉悦的网上商城购物体验';
$this->keywords = '盖掌柜手机客户端，盖象商城';
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
        if($(document).scrollTop()>=3900){
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(4).addClass("on");
        }
        if($(document).scrollTop()>=4800){
            $(".GXYX-rightNav li").removeClass("on");
            $(gxlis).eq(5).addClass("on");
        }
    })
</script>

<?php $this->renderPartial('_nav'); ?>
<!-- 头部end -->
       <?php 
           $iosUrl=AppVersion::getAppUrl(AppVersion::SYSTEM_TYPE_IOS,AppVersion::APP_TYPE_SKU_SHOPKEEPER);
           $androidUrl=AppVersion::getAppUrl(AppVersion::SYSTEM_TYPE_ANDROID,AppVersion::APP_TYPE_SKU_SHOPKEEPER);
        ?>
<!--主体start-->
<div class="coverTenpay-conter GXYX-conter">
    <div class="GZG01">
          <div class="gwkey-link">
		        <a class="link-05" <?php if(!empty($iosUrl)):?> href="<?php echo $iosUrl;?>" <?php endif;?>></a>
		        <a class="link-06" <?php if(!empty($androidUrl)):?> href="<?php echo $androidUrl;?>" <?php endif;?>></a>  
		  </div>   
    </div>
    <div class="GZG02">
        <div id="page1"></div>
    </div>
    <div class="GZG03"></div>
    <div class="GZG04"></div>
    <div class="GZG05">
        <div id="page2"></div>
    </div>
    <div class="GZG06"></div>
    <div class="GZG07">
        <div id="page3"></div>
    </div>
    <div class="GZG08"></div>
    <div class="GZG09">
        <div id="page4"></div>
    </div>
    <div class="GZG10"></div>
    <div class="GZG11">
        <div id="page5"></div>
    </div>
    <div class="GZG12"></div>
    <div class="GZG13">
        <div id="page6"></div>
    </div>
    <div class="GZG14"></div>
    <div class="GZG15">
        <div class="tCon">
            <a href="#gx-top-title" title=""></a>
        </div>
    </div>
    <div class="GXYX-rightNav">
        <div class="GXYX-rightNav-line"></div>
        <ul>
            <li>
                <a href="#page1">扫码上架</a>
            </li>
            <li>
                <a href="#page2">更新库存</a>
            </li>
            <li>
                <a href="#page3">准备送货</a>
            </li>
            <li>
                <a href="#page4">扫码送货</a>
            </li>
            <li>
                <a href="#page5">订单查询</a>
            </li>
            <li>
                <a href="#page6">订单跟踪</a>
            </li>
        </ul>
    </div>
</div>

