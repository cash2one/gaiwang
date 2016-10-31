<?php $this->pageTitle = "皖之道_" . $this->pageTitle ?>
<style type="text/css">
    /*=====
    @Date:2016-01-11
    @content:皖之道
	@author:林聪毅
 =====*/
    .zt-wrap{width:100%; background:#fff; overflow: hidden;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .health-feast-01{height:335px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-01.jpg) top center no-repeat;}
    .health-feast-02{height:334px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-02.jpg) top center no-repeat;}
    .health-feast-03{height:335px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-03.jpg) top center no-repeat;}
    .health-feast-04{height:321px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-04.jpg) top center no-repeat;}
    .health-feast-05{height:320px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-05.jpg) top center no-repeat;}
    .health-feast-06{height:321px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-06.jpg) top center no-repeat;}
    .health-feast-07{height:261px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-07.jpg) top center no-repeat;}
    .health-feast-08{height:260px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-08.jpg) top center no-repeat;}
    .health-feast-09{height:261px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-09.jpg) top center no-repeat;}
    .health-feast-10{height:260px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-10.jpg) top center no-repeat;}

    .health-feast-11{height:396px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-11.jpg) top center no-repeat;}
    .health-feast-12{height:396px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-12.jpg) top center no-repeat;}
    .health-feast-13{height:688px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-13.jpg) top center no-repeat;}
    .health-feast-14{height:822px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-14.jpg) top center no-repeat;}
    .health-feast-15{height:280px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-15.jpg) top center no-repeat;}
    .health-feast-16{height:280px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-16.jpg) top center no-repeat;}
    .health-feast-17{height:280px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-17.jpg) top center no-repeat;}
    .health-feast-18{height:233px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-18.jpg) top center no-repeat;}
    .health-feast-19{height:232px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-19.jpg) top center no-repeat;}
    .health-feast-20{height:233px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-20.jpg) top center no-repeat;}

    .health-feast-21{height:261px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-21.jpg) top center no-repeat;}
    .health-feast-22{height:260px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-22.jpg) top center no-repeat;}
    .health-feast-23{height:261px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-23.jpg) top center no-repeat;}
    .health-feast-24{height:441px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-24.jpg) top center no-repeat;}
    .health-feast-25{height:441px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-25.jpg) top center no-repeat;}
    .health-feast-26{height:714px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-26.jpg) top center no-repeat;}
    .health-feast-27{height:258px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-27.jpg) top center no-repeat;}
    .health-feast-28{height:258px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-28.jpg) top center no-repeat;}
    .health-feast-29{height:258px; background:url(<?php echo ATTR_DOMAIN;?>/zt/health-feast/health-feast-29.jpg) top center no-repeat;}

    .health-feast-04 a{ width:1260px; height:900px; top:0px;}
    .health-feast-04 .a1{left:-140px; }
    .health-feast-07 a{ width:1220px; height:900px; top:90px;}
    .health-feast-07 .a1{left:-140px; }

    .health-feast-12 a{height: 460px; top: -100px;}
    .health-feast-12 .a1{width: 530px; left: -80px;}
    .health-feast-12 .a2{width: 660px; left: 440px;}
    .health-feast-13 a{}
    .health-feast-13 .a1{width: 400px; height: 520px; left: -220px; top: 100px;}
    .health-feast-13 .a2{width: 400px; height: 480px; left: 250px; top: 150px;}
    .health-feast-13 .a3{width: 310px; height: 590px; left: 800px; top: 40px;}
    .health-feast-14 a{}
    .health-feast-14 .a1{width: 350px; height: 600px; left: -130px; top: 40px;}
    .health-feast-14 .a2{width: 400px; height: 500px; left: 290px; top: 140px;}
    .health-feast-14 .a3{width: 460px; height: 520px; left: 760px; top: 130px;}
    .health-feast-16 a{}
    .health-feast-16 .a1{width: 970px; height: 510px; left: 100px; top: 0px;}
    .health-feast-18 a{}
    .health-feast-18 .a1{width: 320px; height: 560px; left: -130px; top: 70px;}
    .health-feast-18 .a2{width: 310px; height: 570px; left: 330px; top: 60px;}
    .health-feast-18 .a3{width: 470px; height: 550px; left: 730px; top: 80px;}

    .health-feast-21 a{}
    .health-feast-21 .a1{width: 380px; height: 580px; left: -130px; top: 70px;}
    .health-feast-21 .a2{width: 310px; height: 510px; left: 330px; top: 140px;}
    .health-feast-21 .a3{width: 360px; height: 560px; left: 770px; top: 90px;}
    .health-feast-24 a{}
    .health-feast-24 .a1{width: 380px; height: 510px; left: -120px; top: 310px;}
    .health-feast-24 .a2{width: 390px; height: 510px; left: 340px; top: 310px;}
    .health-feast-24 .a3{width: 380px; height: 510px; left: 790px; top: 310px;}
    .health-feast-26 a{}
    .health-feast-26 .a1{width: 320px; height: 580px; left: -140px; top: 60px;}
    .health-feast-26 .a2{width: 400px; height: 580px; left: 340px; top: 60px;}
    .health-feast-26 .a3{width: 380px; height: 560px; left: 790px; top: 80px;}
</style>

<div class="zt-wrap">
    <div class="health-feast-01"></div>
    <div class="health-feast-02"></div>
    <div class="health-feast-03"></div>
    <div class="health-feast-04">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/368344.html" title="皖之道金花九号 金花黑茶即溶产品 盒装 45g" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="health-feast-05"></div>
    <div class="health-feast-06"></div>
    <div class="health-feast-07">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/361977.html" title="皖之道  生态燕麦 原味燕麦茶240g*2" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="health-feast-08"></div>
    <div class="health-feast-09"></div>
    <div class="health-feast-10"></div>

    <div class="health-feast-11"></div>
    <div class="health-feast-12">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/362520.html" title="皖之道 玫瑰荷叶茶袋装150g*2" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/362542.html" title="皖之道冬瓜荷叶茶 袋装 160g*2" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="health-feast-13">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/362701.html" title="皖之道 苦荞茶袋装 500g*2" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/368277.html" title="皖之道罐装雪菊 35g*2" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/362320.html" title="皖之道 大麦茶袋装300g*2" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="health-feast-14">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/362030.html" title="皖之道 袋装燕麦大枣茶500g" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/362005.html" title="皖之道 燕麦大枣茶240g*2" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/368351.html" title="皖之道金花九号 金花黑茶即溶饮品 盒装 45g*10" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="health-feast-15"></div>
    <div class="health-feast-16">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/362307.html" title="皖之道 燕麦片罐装 1kg*2" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="health-feast-17"></div>
    <div class="health-feast-18">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/364576.html" title="皖之道 燕麦片桶装 500g*3" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/368416.html" title="皖之道 即食燕麦片 桶装 380g*4" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/362098.html" title="皖之道 燕麦飘香 即冲燕麦 720g" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="health-feast-19"></div>
    <div class="health-feast-20"></div>

    <div class="health-feast-21">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/362178.html" title="皖之道 燕麦营养餐 720g*2" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/368242.html" title="皖之道燕麦素食面条200g*12" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/368252.html" title="皖之道袋装燕麦米 500g*4" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="health-feast-22"></div>
    <div class="health-feast-23"></div>
    <div class="health-feast-24">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/368293.html" title="皖之道罐装 红枸杞 170g*2" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/368299.html" title="皖之道罐装 黑枸杞80g" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/368325.html" title="皖之道袋装 大红枣 500g*2" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="health-feast-25"></div>
    <div class="health-feast-26">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/368332.html" title="皖之道 花生油 1.8L*3" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/364544.html" title="皖之道 乳清蛋白质粉 900g" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/368268.html" title="皖之道罐装玛咖片 110g*2" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="health-feast-27"></div>
    <div class="health-feast-28"></div>
    <div class="health-feast-29"></div>
</div> 