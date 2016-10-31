<?php //$this->pageTitle == "攀枝花专题_" . $this->pageTitle;?>
<style type="text/css">
/*=====
@Date:2015-12-04
@content:攀枝花
@author:林聪毅
=====*/
.zt-wrap{width:100%; min-width:1200px; background:#fff; overflow:hidden;}
.zt-con { width:968px; margin:0 auto; position:relative; }
.zt-con a{ position:absolute;display:block;}
.panzhihua-01{height:343px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-01.jpg) top center no-repeat; position: relative;}
.panzhihua-02{height:342px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-02.jpg) top center no-repeat;}
.panzhihua-03{height:733px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-03.jpg) top center no-repeat;}
.panzhihua-04{height:292px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-04.jpg) top center no-repeat;}
.panzhihua-05{height:1040px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-05.jpg) top center no-repeat;}
.panzhihua-06{height:152px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-06.jpg) top center no-repeat;}
.panzhihua-07{height:152px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-07.jpg) top center no-repeat;}
.panzhihua-08{height:1071px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-08.jpg) top center no-repeat;}
.panzhihua-09{height:171px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-09.jpg) top center no-repeat;}
.panzhihua-10{height:171px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-10.jpg) top center no-repeat;}

.panzhihua-11{height:908px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-11.jpg) top center no-repeat;}
.panzhihua-12{height:266px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-12.jpg) top center no-repeat;}
.panzhihua-13{height:1069px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-13.jpg) top center no-repeat;}
.panzhihua-14{height:271px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-14.jpg) top center no-repeat;}
.panzhihua-15{height:1053px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-15.jpg) top center no-repeat;}
.panzhihua-16{height:156px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-16.jpg) top center no-repeat;}
.panzhihua-17{height:156px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-17.jpg) top center no-repeat;}
.panzhihua-18{height:1008px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-18.jpg) top center no-repeat;}
.panzhihua-19{height:114px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/panzhihua-19.jpg) top center no-repeat;}

.flower{position: absolute; display: none;}
.subBanner{width: 417px; height: 417px; position: absolute; opacity: 0; overflow: hidden;}
.label{width: 417px; height: 63px; position: absolute; opacity: 0;}
.inFo{opacity: 0;}
.goods{position: absolute; opacity: 0;}
.tips{position: absolute; opacity: 0;}

.panzhihua-01 .flower-01{
    width: 1920px; height: 1418px;
    left: 0px; top: 0px; z-index: 2;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/flower-01.png) no-repeat;
}
.panzhihua-01 .circle{
    width: 583px; height: 582px;
    position: absolute; left: 20%; top: 50px; display: none;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/circle.png) no-repeat;
}
.panzhihua-01 .banner{
    width: 689px; height: 333px;
    position: absolute; left: 14%; top: 260px; opacity: 0;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/banner.png) no-repeat;
}
.panzhihua-03 .zt-con{z-index: 3;}
.panzhihua-03 a{width: 88px; height: 87px; opacity: 0;}
.panzhihua-03 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/nav-01.png); left: -30px; top: 150px;}
.panzhihua-03 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/nav-02.png); left: 160px; top: 190px;}
.panzhihua-03 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/nav-03.png); left: 330px; top: 260px;}
.panzhihua-03 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/nav-04.png); left: 510px; top: 300px;}
.panzhihua-03 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/nav-05.png); left: 710px; top: 320px;}
.panzhihua-03 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/nav-06.png); left: 920px; top: 380px;}
.panzhihua-03 .navInfo-01{
    width: 66px; height: 130px; display: inline-block;
    position: absolute;	left: -20px; top: 290px; opacity: 0;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/navInfo-01.png) no-repeat;
}
.panzhihua-03 .navInfo-02{
    width: 57px; height: 126px; display: inline-block;
    position: absolute;	left: 170px; top: 340px; opacity: 0;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/navInfo-02.png) no-repeat;
}
.panzhihua-03 .navInfo-03{
    width: 57px; height: 231px; display: inline-block;
    position: absolute;	left: 340px; top: 410px; opacity: 0;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/navInfo-03.png) no-repeat;
}
.panzhihua-03 .navInfo-04{
    width: 57px; height: 126px; display: inline-block;
    position: absolute;	left: 520px; top: 450px; opacity: 0;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/navInfo-04.png) no-repeat;
}
.panzhihua-03 .navInfo-05{
    width: 56px; height: 169px; display: inline-block;
    position: absolute;	left: 730px; top: 470px; opacity: 0;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/navInfo-05.png) no-repeat;
}
.panzhihua-03 .navInfo-06{
    width: 56px; height: 146px; display: inline-block;
    position: absolute;	left: 940px; top: 530px; opacity: 0;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/navInfo-06.png) no-repeat;
}
.panzhihua-05 .flower-02{
    width: 290px; height: 274px;
    left: 880px; top: 0px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/flower-02.png) no-repeat;
}
.panzhihua-05 .subBanner-01{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/subBanner-01.png) no-repeat; left: 550px; top: 100px;}
.panzhihua-05 .label-01{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/label-01.png) no-repeat; left: 200px; top: 180px; z-index: 2;}
.panzhihua-05 .info-01{
    width: 287px; height: 336px;
    position: absolute; left: 40px; top: 80px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/info-01.png) no-repeat;
}
.panzhihua-05 .goods{left: 60px; top: 660px;}
.panzhihua-05 a{width: 197px; height: 309px; top: 0px;}
.panzhihua-05 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods1-01.png) no-repeat; left: 0px;}
.panzhihua-05 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods1-02.png) no-repeat; left: 220px;}
.panzhihua-05 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods1-03.png) no-repeat; left: 440px;}
.panzhihua-05 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods1-04.png) no-repeat; left: 660px;}
.panzhihua-05 .tips-01{
    width: 845px; height: 103px;
    left: -130px; top: 890px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/tips-01.png) no-repeat;
}
.panzhihua-06 .flower-03{
    width: 370px; height: 344px;
    left: -80px; top: -20px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/flower-03.png) no-repeat;
}
.panzhihua-08 .subBanner-02{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/subBanner-02.png) no-repeat; left: 550px; top: 80px;}
.panzhihua-08 .label-02{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/label-02.png) no-repeat; left: 200px; top: 180px; z-index: 2;}
.panzhihua-08 .info-02{
    width: 287px; height: 336px;
    position: absolute; left: 40px; top: 40px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/info-02.png) no-repeat;
}
.panzhihua-08 .cloud-01{
    width: 292px; height: 124px;
    position: absolute; left: 780px; top: 90px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/cloud-01.png) no-repeat;
}
.panzhihua-08 .cloud-02{
    width: 348px; height: 149px;
    position: absolute; left: 370px; top: 320px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/cloud-02.png) no-repeat;
}
.panzhihua-08 .goods{left: -40px; top: 660px;}
.panzhihua-08 a{width: 177px; height: 309px; top: 0px;}
.panzhihua-08 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods2-01.png) no-repeat; left: 0px;}
.panzhihua-08 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods2-02.png) no-repeat; left: 220px;}
.panzhihua-08 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods2-03.png) no-repeat; left: 440px;}
.panzhihua-08 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods2-04.png) no-repeat; left: 660px;}
.panzhihua-08 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods2-05.png) no-repeat; left: 880px;}
.panzhihua-08 .tips-02{
    width: 964px; height: 133px;
    left: -200px; top: 890px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/tips-02.png) no-repeat;
}
.panzhihua-09 .flower-04{
    width: 1281px; height: 457px;
    left: -80px; top: -20px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/flower-04.png) no-repeat;
}

.panzhihua-11 .subBanner-03{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/subBanner-03.png) no-repeat; left: 550px; top: 80px;}
.panzhihua-11 .label-03{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/label-03.png) no-repeat; left: 200px; top: 180px; z-index: 2;}
.panzhihua-11 .info-03{
    width: 299px; height: 377px;
    position: absolute; left: 70px; top: 40px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/info-03.png) no-repeat;
}
.panzhihua-11 .goods{left: -40px; top: 640px;}
.panzhihua-11 a{width: 177px; height: 310px; top: 0px;}
.panzhihua-11 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods3-01.png) no-repeat; left: 0px;}
.panzhihua-11 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods3-02.png) no-repeat; left: 220px;}
.panzhihua-11 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods3-03.png) no-repeat; left: 440px;}
.panzhihua-11 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods3-04.png) no-repeat; left: 660px;}
.panzhihua-11 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods3-05.png) no-repeat; left: 880px;}
.panzhihua-13 .flower-05{
    width: 131px; height: 206px;
    left: -80px; top: -20px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/flower-05.png) no-repeat;
}
.panzhihua-13 .subBanner-04{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/subBanner-04.png) no-repeat; left: 550px; top: 80px;}
.panzhihua-13 .label-04{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/label-04.png) no-repeat; left: 200px; top: 180px; z-index: 2;}
.panzhihua-13 .info-04{
    width: 288px; height: 410px;
    position: absolute; left: 40px; top: 40px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/info-04.png) no-repeat;
}
.panzhihua-13 .goods{left: -40px; top: 660px;}
.panzhihua-13 a{width: 177px; height: 315px; top: 0px;}
.panzhihua-13 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods4-01.png) no-repeat; left: 0px;}
.panzhihua-13 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods4-02.png) no-repeat; left: 220px;}
.panzhihua-13 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods4-03.png) no-repeat; left: 440px;}
.panzhihua-13 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods4-04.png) no-repeat; left: 660px;}
.panzhihua-13 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods4-05.png) no-repeat; left: 880px;}
.panzhihua-13 .tips-04{
    width: 706px; height: 118px;
    left: -60px; top: 910px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/tips-04.png) no-repeat;
}
.panzhihua-14 .flower-06{
    width: 1282px; height: 440px;
    left: -80px; top: -20px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/flower-06.png) no-repeat;
}
.panzhihua-15 .subBanner-05{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/subBanner-05.png) no-repeat; left: 550px; top: 80px;}
.panzhihua-15 .label-05{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/label-05.png) no-repeat; left: 200px; top: 180px; z-index: 2;}
.panzhihua-15 .info-05{
    width: 299px; height: 300px;
    position: absolute; left: 40px; top: 120px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/info-05.png) no-repeat;
}
.panzhihua-15 .goods{left: -40px; top: 650px;}
.panzhihua-15 a{width: 177px; height: 315px; top: 0px;}
.panzhihua-15 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods5-01.png) no-repeat; left: 0px;}
.panzhihua-15 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods5-02.png) no-repeat; left: 220px;}
.panzhihua-15 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods5-03.png) no-repeat; left: 440px;}
.panzhihua-15 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods5-04.png) no-repeat; left: 660px;}
.panzhihua-15 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods5-05.png) no-repeat; left: 880px;}
.panzhihua-15 .tips-05{
    width: 941px; height: 41px;
    left: -180px; top: 910px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/tips-05.png) no-repeat;
}
.panzhihua-18 .flower-07{
    width: 1282px; height: 440px;
    left: -100px; top: 660px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/flower-06.png) no-repeat;
}
.panzhihua-18 .subBanner-06{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/subBanner-06.png) no-repeat; left: 550px; top: 100px;}
.panzhihua-18 .label-06{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/label-06.png) no-repeat; left: 200px; top: 180px; z-index: 2;}
.panzhihua-18 .info-06{
    width: 285px; height: 369px;
    position: absolute; left: 40px; top: 80px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/info-06.png) no-repeat;
}
.panzhihua-18 .goods{left: 60px; top: 750px;}
.panzhihua-18 a{width: 197px; height: 317px; top: 0px;}
.panzhihua-18 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods6-01.png) no-repeat; left: 0px;}
.panzhihua-18 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods6-02.png) no-repeat; left: 220px;}
.panzhihua-18 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods6-03.png) no-repeat; left: 440px;}
.panzhihua-18 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/goods6-04.png) no-repeat; left: 660px;}
.panzhihua-18 .tips-06{
    width: 840px; height: 113px;
    left: -130px; top: 530px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/panzhihua/tips-06.png) no-repeat;
}
</style>

<div class="zt-wrap">
    <div class="panzhihua-01">
        <div class="flower flower-01"></div>
        <div class="zt-con">
            <div class="circle"></div>
            <div class="banner"></div>
        </div>
    </div>
    <div class="panzhihua-02"></div>
    <div class="panzhihua-03">
        <div class="zt-con">
            <a href="#part1" class="a1"></a>
            <a href="#part2" class="a2"></a>
            <a href="#part3" class="a3"></a>
            <a href="#part4" class="a4"></a>
            <a href="#part5" class="a5"></a>
            <a href="#part6" class="a6"></a>
            <span class="navInfo-01"></span>
            <span class="navInfo-02"></span>
            <span class="navInfo-03"></span>
            <span class="navInfo-04"></span>
            <span class="navInfo-05"></span>
            <span class="navInfo-06"></span>
        </div>
    </div>
    <div class="panzhihua-04" id="part1"></div>
    <div class="panzhihua-05">
        <div class="zt-con">
            <div class="flower flower-02"></div>
            <div class="subBanner subBanner-01">
                <div class="label label-01"></div>
            </div>
            <div class="inFo info-01"></div>
            <div class="goods">
                <a href="http://www.g-emall.com/JF/113484.html" title="" class="a1" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/113177.html" title="" class="a2" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/102036.html" title="" class="a3" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/113488.html" title="" class="a4" target="_blank"></a>
            </div>
            <div class="tips tips-01"></div>
        </div>
    </div>
    <div class="panzhihua-06" id="part2">
        <div class="zt-con">
            <div class="flower flower-03"></div>
        </div>
    </div>
    <div class="panzhihua-07"></div>
    <div class="panzhihua-08">
        <div class="zt-con">
            <div class="flower flower-04"></div>
            <div class="subBanner subBanner-02">
                <div class="label label-02"></div>
            </div>
            <div class="cloud-01"></div>
            <div class="cloud-02"></div>
            <div class="inFo info-02"></div>
            <div class="goods">
                <a href="http://www.g-emall.com/JF/280076.html" title="" class="a1" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/279207.html" title="" class="a2" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/284104.html" title="" class="a3" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/280668.html" title="" class="a4" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/285165.html" title="" class="a5" target="_blank"></a>
            </div>
            <div class="tips tips-02"></div>
        </div>
    </div>
    <div class="panzhihua-09" id="part3">
        <div class="zt-con">
            <div class="flower flower-04"></div>
        </div>
    </div>
    <div class="panzhihua-10"></div>

    <div class="panzhihua-11">
        <div class="zt-con">
            <div class="subBanner subBanner-03">
                <div class="label label-03"></div>
            </div>
            <div class="inFo info-03"></div>
            <div class="goods">
                <a href="http://www.g-emall.com/JF/111196.html" title="" class="a1" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/111190.html" title="" class="a2" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/110448.html" title="" class="a3" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/110464.html" title="" class="a4" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/111193.html" title="" class="a5" target="_blank"></a>
            </div>
            <div class="tips tips-03"></div>
        </div>
    </div>
    <div class="panzhihua-12" id="part4"></div>
    <div class="panzhihua-13">
        <div class="zt-con">
            <div class="flower flower-05"></div>
            <div class="subBanner subBanner-04">
                <div class="label label-04"></div>
            </div>
            <div class="inFo info-04"></div>
            <div class="goods">
                <a href="http://www.g-emall.com/JF/275923.html" title="" class="a1" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/271499.html" title="" class="a2" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/259849.html" title="" class="a3" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/271850.html" title="" class="a4" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/276781.html" title="" class="a5" target="_blank"></a>
            </div>
            <div class="tips tips-04"></div>
        </div>
    </div>
    <div class="panzhihua-14" id="part5">
        <div class="zt-con">
            <div class="flower flower-06"></div>
        </div>
    </div>
    <div class="panzhihua-15">
        <div class="zt-con">
            <div class="subBanner subBanner-05">
                <div class="label label-05"></div>
            </div>
            <div class="inFo info-05"></div>
            <div class="goods">
                <a href="http://www.g-emall.com/JF/111472.html" title="" class="a1" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/111483.html" title="" class="a2" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/111411.html" title="" class="a3" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/111404.html" title="" class="a4" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/111407.html" title="" class="a5" target="_blank"></a>
            </div>
            <div class="tips tips-05"></div>
        </div>
    </div>
    <div class="panzhihua-16" id="part6"></div>
    <div class="panzhihua-17"></div>
    <div class="panzhihua-18">
        <div class="zt-con">
            <div class="flower flower-07"></div>
            <div class="subBanner subBanner-06">
                <div class="label label-06"></div>
            </div>
            <div class="inFo info-06"></div>
            <div class="tips tips-06"></div>
            <div class="goods">
                <a href="http://www.g-emall.com/JF/110495.html" title="" class="a1" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/110488.html" title="" class="a2" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/110477.html" title="" class="a3" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/110492.html" title="" class="a4" target="_blank"></a>
            </div>
        </div>
    </div>
    <div class="panzhihua-19"></div>
</div>

<script type="text/javascript">
$(function(){
    var i = 0;
    /*导航栏描述文字-----top*/
    var navInfoTop = [];
    var navInfoLen = $('.panzhihua-03 span').length;
    for(i=0;i<navInfoLen;i++){
        navInfoTop.push(parseInt($('.panzhihua-03 span').eq(i).css('top')));
    }
    /*各层大图标标签----left*/
    var arrLabel = [];
    var labelLen = $('.label').length;
    for(i=0;i<labelLen;i++){
        arrLabel.push(parseInt($('.label').eq(i).css('left')));
    }
    /*各板块描述文字----left*/
    var inFoLeft = [];
    var inFoLen = $('.inFo').length;
    for(i=0;i<inFoLen;i++){
        inFoLeft.push(parseInt($('.inFo').eq(i).css('left')));
    }
    /*各商品区高度----top*/
    var goodsTop = [];
    var goodsLen = $('.goods').length;
    for(i=0;i<goodsLen;i++){
        goodsTop.push(parseInt($('.goods').eq(i).css('top')));
    }
    /*优惠提示区----left*/
    var arrTips = [];
    var tipsLen = $('.tips').length;
    for(i=0;i<tipsLen;i++){
        arrTips.push(parseInt($('.tips').eq(i).css('left')));
    }


    $('.flower-01').fadeIn(2000);
    $('.circle').fadeIn(1000,function(){
        $('.banner').animate({'opacity':1,'top':200},1500);
    });

    /*导航栏效果*/
    function navInfoMove(index){
        if(index<navInfoLen){
            $('.panzhihua-03 .a'+(index+1)).stop(false,true).animate({'opacity':1},100,function(){
                $(this).siblings('span').eq(index).stop(false,true).animate({'opacity':1,'top':navInfoTop[index]-40},100,
                    function(){
                        index++;
                        navInfoMove(index);
                    });
            });
        }
    }
    /*各层元素效果*/
    function subBannerFn(index){
        $('.subBanner').eq(index).stop(true,false).animate({'opacity':1},800,function(){
            $(this).find('.label').stop(true,false).animate({'opacity':1,'left':arrLabel[index]-300},800,function(){
                $(this).stop(true,false).animate({'left':parseInt($(this).css('left'))+100},300);
            });
            $(this).siblings('.inFo').stop(true,false).animate({'opacity':1,'left':inFoLeft[index]+100},500);
        });
    }
    /*各层商品区效果*/
    function goodsFn(index){
        $('.goods').eq(index).stop(true,false).animate({'opacity':1,'top':goodsTop[index]-100},500,function(){
            $(this).siblings('.tips').animate({'opacity':1,'left':arrTips[index]+200},500);
        });
    }


    var st = 0;
    var onOff1 = true,
        onOff2 = true,onOff3 = true,
        onOff4 = true,onOff5 = true,
        onOff6 = true,onOff7 = true,
        onOff8 = true,onOff9 = true,
        onOff10 = true,onOff11 = true,
        onOff12 = true,onOff13 = true;
    $(window).scroll(function(){
        st = $(document).scrollTop();
        /*导航栏效果触发条件*/
        if(st>=400&&st<1600){
            if(onOff1){
                navInfoMove(0);
                onOff1 = false;
            }
        }
        else{
            $('.panzhihua-03 .zt-con a').css({'opacity':0});
            for(i=0;i<navInfoLen;i++){
                $('.panzhihua-03 span').eq(i).css({
                    'opacity':0,
                    'top':navInfoTop[i]
                });
            }
            onOff1 = true;
        }
        /*part1效果触发条件*/
        if(st>=1200&&st<=3000){
            $('.flower-02').show(2000);
            if(onOff2){
                subBannerFn(0);
                onOff2 = false;
            }
        }
        else{
            $('.subBanner').eq(0).css({'opacity':0})
                .find('.label').css({'opacity':0,'left':arrLabel[0]})
                .parent().siblings('.inFo').css({'opacity':0,'left':inFoLeft[0]});
            onOff2 = true;
        }
        if(st>=1700&&st<3000){
            if(onOff3){
                goodsFn(0);
                onOff3 = false;
            }
        }
        else{
            $('.goods').eq(0).css({'opacity':0,'top':goodsTop[0]})
                .siblings('.tips').css({'opacity':0,'left':arrTips[0]});
            onOff3 = true;
        }
        /*part2效果触发条件*/
        if(st>=2500&&st<4000){
            $('.flower-03').show(1000);
            if(onOff4){
                subBannerFn(1);
                onOff4 = false;
            }
        }
        else{
            $('.subBanner').eq(1).css({'opacity':0})
                .find('.label').css({'opacity':0,'left':arrLabel[1]})
                .parent().siblings('.inFo').css({'opacity':0,'left':inFoLeft[1]});
            onOff4 = true;
        }
        if(st>=3000&&st<4400){
            if(onOff5){
                goodsFn(1);
                onOff5 = false;
            }
        }
        else{
            $('.goods').eq(1).css({'opacity':0,'top':goodsTop[1]})
                .siblings('.tips').css({'opacity':0,'left':arrTips[1]});
            onOff5 = true;
        }
        /*part3效果触发条件*/
        if(st>=4000&&st<5300){
            $('.flower-04').show(1000);
            if(onOff6){
                subBannerFn(2);
                onOff6 = false;
            }
        }
        else{
            $('.subBanner').eq(2).css({'opacity':0})
                .find('.label').css({'opacity':0,'left':arrLabel[2]})
                .parent().siblings('.inFo').css({'opacity':0,'left':inFoLeft[2]});
            onOff6 = true;
        }
        if(st>=4500&&st<5600){
            if(onOff7){
                goodsFn(2);
                onOff7 = false;
            }
        }
        else{
            $('.goods').eq(2).css({'opacity':0,'top':goodsTop[2]})
                /*.siblings('.tips').css({'opacity':0,'left':arrTips[2]})*/;
            onOff7 = true;
        }
        /*part4效果触发条件*/
        if(st>=5100&&st<6500){
            $('.flower-05').show(1000);
            if(onOff8){
                subBannerFn(3);
                onOff8 = false;
            }
        }
        else{
            $('.subBanner').eq(3).css({'opacity':0})
                .find('.label').css({'opacity':0,'left':arrLabel[3]})
                .parent().siblings('.inFo').css({'opacity':0,'left':inFoLeft[3]});
            onOff8 = true;
        }
        if(st>=5700&&st<7000){
            if(onOff9){
                goodsFn(3);
                onOff9 = false;
            }
        }
        else{
            $('.goods').eq(3).css({'opacity':0,'top':goodsTop[3]})
                .siblings('.tips').css({'opacity':0,'left':arrTips[3]});
            onOff9 = true;
        }
        /*part5效果触发条件*/
        if(st>=6400&&st<7800){
            $('.flower-06').show(1000);
            if(onOff10){
                subBannerFn(4);
                onOff10 = false;
            }
        }
        else{
            $('.subBanner').eq(4).css({'opacity':0})
                .find('.label').css({'opacity':0,'left':arrLabel[4]})
                .parent().siblings('.inFo').css({'opacity':0,'left':inFoLeft[4]});
            onOff10 = true;
        }
        if(st>=7000&&st<8300){
            if(onOff11){
                goodsFn(4);
                onOff11 = false;
            }
        }
        else{
            $('.goods').eq(4).css({'opacity':0,'top':goodsTop[4]})
                .siblings('.tips').css({'opacity':0,'left':arrTips[4]});
            onOff11 = true;
        }
        /*part5效果触发条件*/
        if(st>=7800){
            if(onOff12){
                subBannerFn(5);
                onOff12 = false;
            }
        }
        else{
            $('.subBanner').eq(5).css({'opacity':0})
                .find('.label').css({'opacity':0,'left':arrLabel[5]})
                .parent().siblings('.inFo').css({'opacity':0,'left':inFoLeft[5]});
            onOff12 = true;
        }
        if(st>=8400){
            $('.flower-07').show(1000);
            if(onOff13){
                goodsFn(5);
                onOff12 = false;
            }
        }
        else{
            $('.goods').eq(5).css({'opacity':0,'top':goodsTop[5]})
                .siblings('.tips').css({'opacity':0,'left':arrTips[5]});
            onOff13 = true;
        }
    })

})
</script>