<?php $this->pageTitle = "家纺专题_" . $this->pageTitle;?>
<style type="text/css">
    /*=====
    @Date:2015-11-16
    @content:家纺首页
	@author:林聪毅
 =====*/
    .zt-wrap{width:100%; background:#fff;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .homeTextiles-01{height:190px; background:url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles/homeTextiles-01.jpg) top center no-repeat;}
    .homeTextiles-02{height:190px; background:url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles/homeTextiles-02.jpg) top center no-repeat;}
    .homeTextiles-03{height:190px; background:url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles/homeTextiles-03.jpg) top center no-repeat;}
    .homeTextiles-04{height:190px; background:url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles/homeTextiles-04.jpg) top center no-repeat;}
    .homeTextiles-05{height:190px; background:url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles/homeTextiles-05.jpg) top center no-repeat;}

    .homeTextiles-01 .layout{
        width: 1401px; height: 0px;
        position: relative; left: -20%; top: 70px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles/layout.png) no-repeat; display: none; z-index: 2;
    }
    .homeTextiles-01 a{z-index: 2;}
    .homeTextiles-01 .a1{width: 271px; height: 209px; left: 140px; top: 70px;}
    .homeTextiles-01 .a2{width: 258px; height: 228px; left: 250px; top: 300px;}
    .homeTextiles-01 .a3{width: 344px; height: 277px; left: 560px; top: 150px;}
    .homeTextiles-01 .a4{width: 317px; height: 262px; left: 1040px; top: 180px;}
    .homeTextiles-01 .a5{width: 378px; height: 239px; left: 480px; top: 520px;}
    .homeTextiles-01 .a6{width: 246px; height: 185px; left: 880px; top: 530px;}
    .homeTextiles-02 a{ }
    .homeTextiles-02 .a1{width:1000px; height:620px; top:100px; left:100px; }
    .homeTextiles-02 .a2{
        width: 116px; height: 33px;
        left: 980px; top: 570px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles/back.png) no-repeat; z-index: 3;
    }
    .onScale:hover{
        animation:onScale 3s linear infinite;
        -moz-animation:onScale 3s linear infinite;
        -webkit-animation:onScale 3s linear infinite;
        -ms-animation:onScale 3s linear infinite;
        -o-animation:onScale 3s linear infinite;
    }
    @-webkit-keyframes onScale {
        0% 	{-webkit-transform: scale(1);}
        50% {-webkit-transform: scale(1.1);}
        100%{-webkit-transform: scale(1);}
    }
    @-moz-keyframes onScale {
        0% 	{-moz-transform: scale(1);}
        50% {-moz-transform: scale(1.1);}
        100%{-moz-transform: scale(1);}
    }
    @-ms-keyframes onScale {
        0% 	{-ms-transform: scale(1);}
        50% {-ms-transform: scale(1.1);}
        100%{-ms-transform: scale(1);}
    }
    @-o-keyframes onScale {
        0% 	{-o-transform: scale(1);}
        50% {-o-transform: scale(1.1);}
        100%{-o-transform: scale(1);}
    }


</style>

<div class="zt-wrap">
    <div class="homeTextiles-01">
        <div class="zt-con">
            <div class="layout">
                <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/homeTextiles-5" class="a1" target="_blank">
                    <img src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles/homeTextiles-5.png" class="onScale" />
                </a>
                <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/homeTextiles-1" class="a2" target="_blank">
                    <img src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles/homeTextiles-1.png" class="onScale" />
                </a>
                <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/homeTextiles-4" class="a3" target="_blank">
                    <img src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles/homeTextiles-4.png" class="onScale" />
                </a>
                <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/homeTextiles-2" class="a4" target="_blank">
                    <img src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles/homeTextiles-2.png" class="onScale" />
                </a>
                <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/homeTextiles-6" class="a5" target="_blank">
                    <img src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles/homeTextiles-6.png" class="onScale" />
                </a>
                <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/homeTextiles-3" class="a6" target="_blank">
                    <img src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles/homeTextiles-3.png" class="onScale" />
                </a>
            </div>
        </div>
    </div>
    <div class="homeTextiles-02">
        <div class="zt-con">
            <a href="javascript:void(0)" class="a1"></a>
        </div>
    </div>
    <div class="homeTextiles-03"></div>
    <div class="homeTextiles-04"></div>
    <div class="homeTextiles-05"></div>
</div>

<script type="text/javascript">
    $(function(){
        $('.footer').hide();
        $('.homeTextiles-02 a').mouseover(function(){
         $('.layout').show().stop(true,false).animate({'height':818},500);
         });
         $('.layout').mouseleave(function(){
         $('.layout').animate({'height':0},1000,function(){
         $(this).hide();
         });
         })
    })
</script>