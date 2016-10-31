<?php $this->pageTitle = "闺蜜专题_".$this->pageTitle ?>
<style type="text/css">
    /*=====
    @Date:2014-07-09
    @content:
	@author:林聪毅
 =====*/
    body{overflow-y: hidden; }
    .zt-wrap{width:100%; background:#fff;}
    .zt-con { width:1200px; margin:0 auto; position:relative; }
    .zt-con a,.zt-con span{ position:absolute;display:block;}
    .appointment-01{height:384px; background: url(<?php echo ATTR_DOMAIN;?>/zt/appointment/appointment-01.jpg) top center no-repeat; z-index: 2; position: relative;}
    .liner{
        width: 1457px; height: 880px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/appointment/line.png);
        position: relative; left: 18%; top: -100px;
        z-index: 1;
    }
    .appointment-01 a{
        position: absolute;
        font-family: '微软雅黑','宋体'; font-size: 14px; font-weight: bold;
        width: 200px; height: 102px; line-height: 102px; font-size: 18px; text-align: center; z-index: 4;
    }
    .appointment-01 .a1{left: -7%; top: 180px;}
    .appointment-01 .a2{left: 7%; top: 60px;}
    .appointment-01 .a3{left: 33%; top: 50px;}
    .appointment-01 .a4{left: 47%; top: 40px;}
    .appointment-01 .a5{left: 66%; top: 70px;}
    .appointment-01 .a6{left: 70%; top: 210px;}
    .appointment-01 .a7{left: 84%; top: 290px;}

    .appointment-02{height:335px; background: url(<?php echo ATTR_DOMAIN;?>/zt/appointment/appointment-02.jpg) top center no-repeat; z-index: 2;}
    .appointment-03{height:197px; background: url(<?php echo ATTR_DOMAIN;?>/zt/appointment/appointment-03.jpg) top center no-repeat; z-index: 2;}
    .appointment-03 .zt-con{top: -240px;}
    .appointment-03 .span1{width: 268px; height: 443px; left: -230px; top: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/appointment/nipic1.png) no-repeat; z-index: 3;}
    .appointment-03 .span2{width: 190px; height: 429px; left: 1350px; top: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/appointment/nipic2.png) no-repeat; z-index: 3;}
    .appointment-03 .span3{width: 289px; height: 349px; left: 480px; top: 90px; background: url(<?php echo ATTR_DOMAIN;?>/zt/appointment/nipic3.png) no-repeat; z-index: 3;}
    .appointment-03 .span4{width: 252px; height: 212px; left: -340px; top: 100px; background: url(<?php echo ATTR_DOMAIN;?>/zt/appointment/nipic4.png) no-repeat; z-index: 4;}
    .appointment-03 .span5{width: 145px; height: 212px; left: 1400px; top: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/appointment/nipic5.png) no-repeat; z-index: 4;}

    .nipic{
        animation:swing 4s linear infinite;
        -webkit-animation:swing 4s linear infinite;
        -moz-animation:swing 4s linear infinite;
        -ms-animation:swing 4s linear infinite;
        -o-animation:swing 4s linear infinite;
    }

    .scale{
        animation:onScale 10s linear infinite;
        -webkit-animation:onScale 10s linear infinite;
        -moz-animation:onScale 10s linear infinite;
        -ms-animation:onScale 10s linear infinite;
        -o-animation:onScale 10s linear infinite;
    }

    @-webkit-keyframes swing{
        0% 	{-webkit-transform: rotate(2deg);}
        50% {-webkit-transform: rotate(-2deg);}
        100% {-webkit-transform: rotate(2deg);}
    }
    @-moz-keyframes swing{
        0% 	{-moz-transform: rotate(2deg);}
        50% {-moz-transform: rotate(-2deg);}
        100% {-moz-transform: rotate(2deg);}
    }
    @-ms-keyframes swing{
        0% 	{-ms-transform: rotate(2deg);}
        50% {-ms-transform: rotate(-2deg);}
        100% {-ms-transform: rotate(2deg);}
    }
    @-o-keyframes swing{
        0% 	{-o-transform: rotate(2deg);}
        50% {-o-transform: rotate(-2deg);}
        100% {-o-transform: rotate(2deg);}
    }

    @-webkit-keyframes onScale{
        0% 	{-webkit-transform: scale(0.7);}
        50% {-webkit-transform: scale(0.75);}
        100% {-webkit-transform: scale(0.7);}
    }
    @-moz-keyframes onScale{
        0% 	{-moz-transform: scale(0.7);}
        50% {-moz-transform: scale(0.75);}
        100% {-moz-transform: scale(0.7);}
    }
    @-ms-keyframes onScale{
        0% 	{-ms-transform: scale(0.7);}
        50% {-ms-transform: scale(0.75);}
        100% {-ms-transform: scale(0.7);}
    }
    @-o-keyframes onScale{
        0% 	{-o-transform: scale(0.7);}
        50% {-o-transform: scale(0.75);}
        100% {-o-transform: scale(0.7);}
    }
</style>

<div class="zt-wrap">
    <div class="appointment-01">
        <div class="liner scale">
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/appointment-1" class="a1" target="_blank">美妆护肤</a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/appointment-2" class="a2" target="_blank">闺蜜衣橱</a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/appointment-3" class="a3" target="_blank">睡衣派对</a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/appointment-4" class="a4" target="_blank">吃货狂欢</a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/appointment-5" class="a5" target="_blank">不醉不归</a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/appointment-6" class="a6" target="_blank">摄影数码</a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/appointment-7" class="a7" target="_blank">血拼扫货</a>
        </div>
    </div>
    <div class="appointment-02"></div>
    <div class="appointment-03">
        <div class="zt-con">
            <span class="span1 nipic"></span>
            <span class="span2 nipic"></span>
            <span class="span3 nipic"></span>
            <span class="span4 nipic"></span>
            <span class="span5 nipic"></span>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        var timer = null;
        //var onOff = 1;
        $('.appointment-01 a').hover(function(){
            var _this = $(this);
            $(this).css('background','url(<?php echo ATTR_DOMAIN;?>/zt/appointment/frame.png) no-repeat');
            timer = setInterval(function(){
                var oFont = parseInt(_this.css('font-size'));

                if(oFont<22){
                    _this.animate({'font-size':22},500);

                }
                else{
                    _this.animate({'font-size':18},500);
                }
            },500)
        },function(){
            clearInterval(timer);
            $(this).css('background','none');
            $(this).animate({'font-size':18},500);
        })
        $('.header,.footer').hide();

        /*$(window).resize(function(){

         })*/

        var i = 0;
        var len = $('.appointment-01 a').length;
        var cache = 0;
        var oLeft = 0;
        var currentWidth = document.body.clientWidth;
        if(currentWidth<1600){
            var proportion = currentWidth/1800+5;
            var linerLeft = $('.liner').offset().left;
            var finalLeft = linerLeft/proportion;
            $('.liner').css({'left':finalLeft});
        }


    })
</script>