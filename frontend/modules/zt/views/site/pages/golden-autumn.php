<style type="text/css">
    /*=====
    @Date:2015-09-01
    @content:金秋礼包专题
	@author:张睿
 =====*/
    .zt-wrap{width:100%;}
    .zt-con {width:1100px; margin:0 auto; position:relative; }
    .zt-con a{position:absolute; display:block; }
    .zt-wrap>div{margin-bottom: 17px;}
    .zt-wrap .golden-autumn-01{height:299px; background:url(<?php echo ATTR_DOMAIN;?>/zt/golden-autumn/golden-autumn-01.jpg) top center no-repeat; margin-bottom: 0;}
    .golden-autumn-02{height:299px; background:url(<?php echo ATTR_DOMAIN;?>/zt/golden-autumn/golden-autumn-02.jpg) top center no-repeat; }
    .golden-autumn-03{height:270px; background:url(<?php echo ATTR_DOMAIN;?>/zt/golden-autumn/golden-autumn-03.jpg) top center no-repeat; }
    .golden-autumn-04{height:431px; background:url(<?php echo ATTR_DOMAIN;?>/zt/golden-autumn/golden-autumn-04.jpg) top center no-repeat; }
    .golden-autumn-05{height:430px; background:url(<?php echo ATTR_DOMAIN;?>/zt/golden-autumn/golden-autumn-05.jpg) top center no-repeat; }
    .golden-autumn-06{height:431px; background:url(<?php echo ATTR_DOMAIN;?>/zt/golden-autumn/golden-autumn-06.jpg) top center no-repeat; }
    .golden-autumn-07{height:432px; background:url(<?php echo ATTR_DOMAIN;?>/zt/golden-autumn/golden-autumn-07.jpg) top center no-repeat; }
    .golden-autumn-08{height:429px; background:url(<?php echo ATTR_DOMAIN;?>/zt/golden-autumn/golden-autumn-08.jpg) top center no-repeat; }
    .golden-autumn-09{height:431px; background:url(<?php echo ATTR_DOMAIN;?>/zt/golden-autumn/golden-autumn-09.jpg) top center no-repeat; }
    .zt-wrap .fixed_bg{background: url(<?php echo ATTR_DOMAIN;?>/zt/golden-autumn/fixed_bg.jpg) top center no-repeat; width:1920px; height:100%; position:fixed; top:50%;margin-top: -262px; left:50%; margin-left:-960px; z-index:-1; -ms-transition:all 1s ease;-webkit-transition:all 1s ease;-moz-transition:all 1s ease;-o-transition:all 1s ease;transition:all 1s ease;filter:alpha(opacity=100);-webkit-opacity:1;-moz-opacity:1; opacity:1;}
    .fixed_bg.hidden{filter:alpha(opacity=0);-webkit-opacity:0;-moz-opacity:0; opacity:0;}
    .golden-autumn-03 a{width:544px; height:270px; top:0;}
    .golden-autumn-03 .a1{left: 0;}
    .golden-autumn-03 .a2{right: 0;}
    .golden-autumn-04 a,.golden-autumn-05 a,.golden-autumn-06 a,.golden-autumn-07 a,.golden-autumn-08 a,.golden-autumn-09 a{width:1100px; height:430px; top:0;left: 0;}

</style>

<div class="zt-wrap">
    <div class="fixed_bg"></div>
    <div class="golden-autumn-01"></div>
    <div class="golden-autumn-02"></div>
    <div class="golden-autumn-03">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/213644.html" title="金粉大礼包（一份）" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/goods/213647.html" title="金粉大礼包（五份）" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="golden-autumn-04">
        <div class="zt-con">
            <a href="http://active.g-emall.com/festive/detail/23" title="月满金秋-情满盖象" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="golden-autumn-05">
        <div class="zt-con">
            <a href="http://active.g-emall.com/festive/detail/9" title="缤纷鲜果季 鲜果专场全场8折" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="golden-autumn-06">
        <div class="zt-con">
            <a href="http://active.g-emall.com/festive/detail/24" title="与酒神共舞" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="golden-autumn-07">
        <div class="zt-con">
            <a href="http://active.g-emall.com/festive/detail/17" title="醉赢人生 白酒专场 低至7折" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="golden-autumn-08">
        <div class="zt-con">
            <a href="http://active.g-emall.com/festive/detail/15" title="中秋茶之韵 茶叶专场全场8折" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="golden-autumn-09">
        <div class="zt-con">
            <a href="http://active.g-emall.com/festive/detail/29" title="中秋佳节 干果零食8折抢" class="a1" target="_blank"></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    //本专题js
    $(window).scroll(function(){
        if($(window).scrollTop()<=600){
            $(".fixed_bg").addClass("hidden");
        }else if($(window).scrollTop()>600){
            $(".fixed_bg").removeClass("hidden");
        }
    });
</script>
