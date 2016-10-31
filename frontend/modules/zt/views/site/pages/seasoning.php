<?php $this->pageTitle = "四川调料专题_".$this->pageTitle ?>
<style type="text/css">
    /*=====
    @Date:2014-07-09
    @content:四川调料专题
	@author:林聪毅
 =====*/
    .zt-wrap{width:100%; background:#fff;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .seasoning-01{height:455px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-01.jpg) top center no-repeat;}
    .seasoning-02{height:451px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-02.jpg) top center no-repeat;}
    .seasoning-03{height:242px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-03.jpg) top center no-repeat;}
    .seasoning-04{height:284px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-04.jpg) top center no-repeat;}
    .seasoning-05{height:558px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-05.jpg) top center no-repeat;}
    .seasoning-06{height:310px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-06.jpg) top center no-repeat;}
    .seasoning-07{height:310px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-07.jpg) top center no-repeat;}
    .seasoning-08{height:312px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-08.jpg) top center no-repeat;}
    .seasoning-09{height:312px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-09.jpg) top center no-repeat;}
    .seasoning-10{height:235px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-10.jpg) top center no-repeat;}

    .seasoning-11{height:235px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-11.jpg) top center no-repeat;}
    .seasoning-12{height:470px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-12.jpg) top center no-repeat;}
    .seasoning-13{height:537px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-13.jpg) top center no-repeat;}
    .seasoning-14{height:536px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-14.jpg) top center no-repeat;}
    .seasoning-15{height:416px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-15.jpg) top center no-repeat;}
    .seasoning-16{height:412px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-16.jpg) top center no-repeat;}
    .seasoning-17{height:683px; background:url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/seasoning-17.jpg) top center no-repeat;}

    .seasoning-01 a{ width:253px; height:234px; background: url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/cooker.png) no-repeat;}
    .seasoning-01 .a1{left:400px; top:200px; }
    .cooker{
        animation:shake 2s linear infinite;
        -moz-animation:shake 2s linear infinite;
        -webkit-animation:shake 2s linear infinite;
        -ms-animation:shake 2s linear infinite;
        -o-animation:shake 2s linear infinite;
    }
    @-webkit-keyframes shake{
        0%{-webkit-transform:rotate(0deg)}
        50%{-webkit-transform:rotate(15deg)}
        100%{-webkit-transform:rotate(0deg)}
    }
    @-moz-keyframes shake{
        0%{-moz-transform:rotate(0deg)}
        50%{-moz-transform:rotate(15deg)}
        100%{-moz-transform:rotate(0deg)}
    }
    @-ms-keyframes shake{
        0%{-ms-transform:rotate(0deg)}
        50%{-ms-transform:rotate(15deg)}
        100%{-ms-transform:rotate(0deg)}
    }
    @-o-keyframes shake{
        0%{-o-transform:rotate(0deg)}
        50%{-o-transform:rotate(15deg)}
        100%{-o-transform:rotate(0deg)}
    }
    .seasoning-02 a{ width:93px; height:111px; background: url(<?php echo ATTR_DOMAIN;?>/zt/seasoning/chili.png) no-repeat;}
    .seasoning-02 .a1{left:-350px; top:340px; }
    .seasoning-04 a{ width: 150px; height: 140px; top: 0px;}
    .seasoning-04 .a1{left: -80px;}
    .seasoning-04 .a2{left: 138px;}
    .seasoning-04 .a3{left: 326px;}
    .seasoning-04 .a4{left: 524px; width: 180px;}
    .seasoning-04 .a5{left: 724px;}
    .seasoning-04 .a6{left: 920px;}
    .seasoning-05 a{ width:180px; height:60px; top:397px;}
    .seasoning-05 .a1{left:868px; }
    .seasoning-05 .a2{width: 1020px; height: 280px; left: -170px; top: 220px;}
    .seasoning-07 a{ width:180px; height:40px; left:888px;}
    .seasoning-07 .a1{ top:38px; }
    .seasoning-07 .a2{ top:84px; }
    .seasoning-07 .a3{ top:130px; }
    .seasoning-07 .a3{ width: 1060px; height: 320px; left: -180px; top: -120px;}
    .seasoning-09 a{ width:180px; height:40px; left:888px;}
    .seasoning-09 .a1{ top:102px; }
    .seasoning-09 .a2{ top:148px; }
    .seasoning-09 .a3{ width: 1050px; height: 300px; left: -170px; top: -100px;}

    .seasoning-11 a{ width:180px; height:60px; top:190px;}
    .seasoning-11 .a1{left:888px; }
    .seasoning-11 .a2{ width: 1060px; height: 290px; left: -170px; top: -20px;}
    .seasoning-12 a{ width: 160px; height: 40px;}
    .seasoning-12 .a1{ left: 110px; top: 266px;}
    .seasoning-12 .a2{ left: 110px; top: 306px;}
    .seasoning-12 .a3{ left: 440px; top: 263px;}
    .seasoning-12 .a4{ left: 440px; top: 304px;}
    .seasoning-12 .a5{ left: 744px; top: 278px;}
    .seasoning-13 a{ width:182px; height:60px; top:410px;}
    .seasoning-13 .a1{left:892px; }
    .seasoning-13 .a2{ width: 1050px; height: 290px; left: -170px; top: 210px;}
    .seasoning-14 a{ width: 220px; height: 280px; top: 16px;}
    .seasoning-14 .a1{ left: -70px;}
    .seasoning-14 .a2{ left: 220px;}
    .seasoning-14 .a3{ left: 520px;}
    .seasoning-14 .a4{ left: 820px;}
    .seasoning-15 a{ width:180px; height:40px; left:876px;}
    .seasoning-15 .a1{ top:378px; }
    .seasoning-15 .a2{ top:428px; }
    .seasoning-15 .a3{ width: 1060px; height: 300px; left: -170px; top: 200px;}
    .seasoning-16 a{ width: 250px; height: 240px; top: 184px;}
    .seasoning-16 .a1{ left: -10px;}
    .seasoning-16 .a2{ left: 360px;}
    .seasoning-16 .a3{ left: 690px;}
    .seasoning-17 a{ width:580px; height:290px; top:260px;}
    .seasoning-17 .a1{left:300px; }



</style>

<div class="zt-wrap">
    <div class="seasoning-01">
        <div class="zt-con">
            <a href="javascript:void(0)" class="a1 cooker"></a>
        </div>
    </div>
    <div class="seasoning-02">
        <div class="zt-con">
            <a href="javascript:void(0)" class="a1 chili"></a>
        </div>
    </div>
    <div class="seasoning-03"></div>
    <div class="seasoning-04">
        <div class="zt-con">
            <a href="#part1" class="a1"></a>
            <a href="#part2" class="a2"></a>
            <a href="#part3" class="a3"></a>
            <a href="#part4" class="a4"></a>
            <a href="#part5" class="a5"></a>
            <a href="#part6" class="a6"></a>
        </div>
    </div>
    <div class="seasoning-05" id="part1">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/187021.html" title="元圆缘 老鸭汤炖汤料350g 正宗四川炖汤高汤料 袋装厨房调料" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/187021.html" title="元圆缘 老鸭汤炖汤料350g 正宗四川炖汤高汤料 袋装厨房调料" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="seasoning-06" id="part2"></div>
    <div class="seasoning-07">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/198381.html" title="元圆缘 香辣干锅调味料150g 正宗四川麻辣味干锅 袋装厨房调料" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/177033.html" title="元圆缘 香辣干锅调味料300g 正宗四川麻辣味干锅 袋装厨房调料" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/214023.html" title="元圆缘 香辣干锅调味料3500g 正宗四川麻辣味干锅 桶装厨房调料" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/214023.html" title="元圆缘 香辣干锅调味料3500g 正宗四川麻辣味干锅 桶装厨房调料" class="a4" target="_blank"></a>
        </div>
    </div>
    <div class="seasoning-08" id="part3"></div>
    <div class="seasoning-09">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/204825.html" title="元圆缘 酸辣酱调味料320g 正宗四川酸辣酱 辣椒酱 瓶装厨房调料" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/214054.html" title="元圆缘 酸辣酱调味料3500g 正宗四川酸辣酱 辣椒酱 桶装厨房调料" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/214054.html" title="元圆缘 酸辣酱调味料3500g 正宗四川酸辣酱 辣椒酱 桶装厨房调料" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="seasoning-10" id="part4"></div>

    <div class="seasoning-11">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/171768.html" title="福猴 郫县豆瓣200g 四川正宗豆瓣 郫县豆瓣酱 袋装厨房调料" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/171768.html" title="福猴 郫县豆瓣200g 四川正宗豆瓣 郫县豆瓣酱 袋装厨房调料" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="seasoning-12">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/182952.html" title="福猴 红油郫县豆瓣500g 四川正宗豆瓣 郫县豆瓣酱 罐装厨房调料" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/204782.html" title="福猴 红油郫县豆瓣1000g 四川正宗豆瓣 郫县豆瓣酱 罐装厨房调料" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/204792.html" title="金福猴 红油郫县豆瓣450g 四川正宗豆瓣 郫县豆瓣酱 瓶装厨房调料 两件包邮" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/182936.html" title="金福猴 红油郫县豆瓣750g 四川正宗豆瓣 郫县豆瓣酱 瓶装厨房调料" class="a4" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/171734.html" title="金福猴 红油郫县豆瓣1100g 四川正宗豆瓣 郫县豆瓣酱 瓶装厨房调料" class="a5" target="_blank"></a>
        </div>
    </div>
    <div class="seasoning-13" id="part5">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/204806.html" title="福猴 泡红米椒800g 四川特产泡小米椒 泡菜调料 泡椒凤爪辣椒 泡辣椒" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/204806.html" title="福猴 泡红米椒800g 四川特产泡小米椒 泡菜调料 泡椒凤爪辣椒 泡辣椒" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="seasoning-14">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/204852.html" title="福猴 泡小米椒208g 四川特产泡小米椒 泡菜调料 泡椒凤爪辣椒 泡辣椒" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/213998.html" title="福猴 泡小米椒300g 四川特产泡小米椒 泡菜调料 泡椒凤爪辣椒 泡辣椒" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/193948.html" title="元圆缘 青椒鱼调味料300g 正宗四川青椒鱼调味料 袋装厨房调料" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/165775.html" title="福猴 泡小米椒500g 四川特产泡小米椒 泡菜调料 泡椒凤爪辣椒 泡辣椒" class="a4" target="_blank"></a>
        </div>
    </div>
    <div class="seasoning-15" id="part6">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/198416.html" title="福猴 鱼酸菜400g 四川特产鱼酸菜 泡菜调料 老坛泡制 川菜调味料" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/194006.html" title="福猴 鱼酸菜2000g 四川特产鱼酸菜 泡菜调料 老坛泡制 川菜调味料" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/170199.html" title="福猴 泡豇豆1000g 四川特产泡菜 泡酸豆角 下饭泡菜" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="seasoning-16">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/204841.html" title="福猴 泡萝卜2000g 四川特产泡酸萝卜 泡菜调料 老坛泡制 川菜调味料" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/187662.html" title="福猴 泡黄姜2000g 四川特产泡黄姜 泡菜调料 嫩姜泡制 川菜调味料" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/170199.html" title="福猴 泡豇豆1000g 四川特产泡菜 泡酸豆角 下饭泡菜" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="seasoning-17">
        <div class="zt-con">
            <a class="a1 backTop" href="javascript:void(0)"></a>
        </div>
    </div>



</div>

<script type="text/javascript">
    $(function(){

        var timer = null;

        timer = setInterval(function(){
            $('.chili').animate({'left':140,'top':540,opacity:0},2000,function(){
                $('.chili').css({'left':-350,'top':340,opacity:1})
            });
        },2000)

        $('.backTop').click(function(){
            $('body,html').stop().animate({scrollTop: 0}, 1000);
            return false;
        })
    })
</script>