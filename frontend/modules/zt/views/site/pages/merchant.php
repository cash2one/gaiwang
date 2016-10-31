<?php $this->pageTitle = "12月新商家_" . $this->pageTitle;?>
<style type="text/css">
    /*=====
    @Date:2015-12-25
    @content:12月新商家
	@author:林聪毅
 =====*/
    .zt-wrap{width:100%; background:#fff; overflow: hidden;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .merchant-01{height:365px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-01.jpg) top center no-repeat;}
    .merchant-02{height:365px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-02.jpg) top center no-repeat;}
    .merchant-03{height:298px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-03.jpg) top center no-repeat;}
    .merchant-04{height:293px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-04.jpg) top center no-repeat;}
    .merchant-05{height:357px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-05.jpg) top center no-repeat;}
    .merchant-06{height:514px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-06.jpg) top center no-repeat;}
    .merchant-07{height:343px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-07.jpg) top center no-repeat;}
    .merchant-08{height:296px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-08.jpg) top center no-repeat;}
    .merchant-09{height:290px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-09.jpg) top center no-repeat;}
    .merchant-10{height:347px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-10.jpg) top center no-repeat;}

    .merchant-11{height:339px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-11.jpg) top center no-repeat;}
    .merchant-12{height:293px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-12.jpg) top center no-repeat;}
    .merchant-13{height:291px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-13.jpg) top center no-repeat;}
    .merchant-14{height:345px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-14.jpg) top center no-repeat;}
    .merchant-15{height:343px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-15.jpg) top center no-repeat;}
    .merchant-16{height:351px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-16.jpg) top center no-repeat;}
    .merchant-17{height:457px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-17.jpg) top center no-repeat;}
    .merchant-18{height:353px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-18.jpg) top center no-repeat;}
    .merchant-19{height:343px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-19.jpg) top center no-repeat;}
    .merchant-20{height:350px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-20.jpg) top center no-repeat;}

    .merchant-21{height:663px; background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/merchant-21.jpg) top center no-repeat;}

    .merchant-01 .banner-01{
        width: 692px; height: 296px;
        position: absolute; left: 0px; top: 0px; z-index: 10;
    }
    .merchant-01 .banner-01 img{width: 100%;}
    .merchant-01 .banner-01 a{width: 692px; height: 294px;}
    .merchant-03 a{ width:160px; height:43px;}
    .merchant-03 .a1{left:50px; top:80px; background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/nav-01.png) no-repeat;}
    .merchant-03 .a1:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/navHover-01.png) no-repeat;}
    .merchant-03 .a2{left:290px; top:80px; background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/nav-02.png) no-repeat;}
    .merchant-03 .a2:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/navHover-02.png) no-repeat;}
    .merchant-03 .a3{left:520px; top:80px; background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/nav-03.png) no-repeat;}
    .merchant-03 .a3:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/navHover-03.png) no-repeat;}
    .merchant-03 .a4{left:750px; top:80px; background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/nav-04.png) no-repeat;}
    .merchant-03 .a4:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/navHover-04.png) no-repeat;}
    .merchant-03 .a5{left:50px; top:160px; background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/nav-05.png) no-repeat;}
    .merchant-03 .a5:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/navHover-05.png) no-repeat;}
    .merchant-03 .a6{left:290px; top:160px; background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/nav-06.png) no-repeat;}
    .merchant-03 .a6:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/navHover-06.png) no-repeat;}
    .merchant-03 .a7{left:520px; top:160px; background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/nav-07.png) no-repeat;}
    .merchant-03 .a7:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/navHover-07.png) no-repeat;}
    .merchant-03 .a8{left:750px; top:160px; background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/nav-08.png) no-repeat;}
    .merchant-03 .a8:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/navHover-08.png) no-repeat;}
    .merchant-04 a{width: 240px; height: 286px; top: 6px;}
    .merchant-04 .a1{left: 244px;}
    .merchant-04 .a2{left: 490px;}
    .merchant-04 .a3{left: 736px;}
    .merchant-05 a{width: 240px; height: 286px; top: 6px;}
    .merchant-05 .a1{left: -2px;}
    .merchant-05 .a2{left: 244px;}
    .merchant-05 .a3{left: 490px;}
    .merchant-05 .a4{left: 736px;}
    .merchant-06 a{width: 240px; height: 286px; top: 170px;}
    .merchant-06 .a1{left: -2px;}
    .merchant-06 .a2{left: 244px;}
    .merchant-06 .a3{left: 490px;}
    .merchant-06 .a4{left: 736px;}
    .merchant-07 a{width: 364px; height: 290px; top: 56px;}
    .merchant-07 .a1{left: 244px;}
    .merchant-07 .a2{left: 613px;}
    .merchant-08 a{width: 324px; height: 288px; top: 6px;}
    .merchant-08 .a1{left: -2px;}
    .merchant-08 .a2{left: 326px;}
    .merchant-08 .a3{left: 654px;}
    .merchant-09 a{width: 240px; height: 286px; top: 4px;}
    .merchant-09 .a1{left: -2px;}
    .merchant-09 .a2{left: 244px;}
    .merchant-09 .a3{left: 490px;}
    .merchant-09 .a4{left: 736px;}
    .merchant-10 a{width: 240px; height: 286px; top: 6px;}
    .merchant-10 .a1{left: -2px;}
    .merchant-10 .a2{left: 244px;}
    .merchant-10 .a3{left: 490px;}
    .merchant-10 .a4{left: 736px;}

    .merchant-11 a{width: 240px; height: 286px; top: 52px;}
    .merchant-11 .a1{left: 244px;}
    .merchant-11 .a2{left: 490px;}
    .merchant-11 .a3{left: 736px;}
    .merchant-12 a{width: 240px; height: 286px; top: 6px;}
    .merchant-12 .a1{left: -2px;}
    .merchant-12 .a2{left: 244px;}
    .merchant-12 .a3{left: 490px;}
    .merchant-12 .a4{left: 736px;}
    .merchant-13 a{width: 240px; height: 286px; top: 4px;}
    .merchant-13 .a1{left: -2px;}
    .merchant-13 .a2{left: 244px;}
    .merchant-13 .a3{left: 490px;}
    .merchant-13 .a4{left: 736px;}
    .merchant-14 a{width: 240px; height: 286px; top: 6px;}
    .merchant-14 .a1{left: -2px;}
    .merchant-14 .a2{left: 244px;}
    .merchant-14 .a3{left: 490px;}
    .merchant-14 .a4{left: 736px;}
    .merchant-15 a{width: 240px; height: 286px; top: 54px;}
    .merchant-15 .a1{left: 244px;}
    .merchant-15 .a2{left: 490px;}
    .merchant-15 .a3{left: 736px;}
    .merchant-16 a{width: 324px; height: 288px; top: 2px;}
    .merchant-16 .a1{left: -2px;}
    .merchant-16 .a2{left: 326px;}
    .merchant-16 .a3{left: 654px;}
    .merchant-17 a{width: 240px; height: 286px; top: 170px;}
    .merchant-17 .a1{left: -2px;}
    .merchant-17 .a2{left: 244px;}
    .merchant-17 .a3{left: 490px;}
    .merchant-17 .a4{left: 736px;}
    .merchant-18 a{width: 240px; height: 286px; top: 6px;}
    .merchant-18 .a1{left: -2px;}
    .merchant-18 .a2{left: 244px;}
    .merchant-18 .a3{left: 490px;}
    .merchant-18 .a4{left: 736px;}
    .merchant-19 a{width: 364px; height: 290px; top: 53px;}
    .merchant-19 .a1{left: 244px;}
    .merchant-19 .a2{left: 613px;}
    .merchant-20 a{width: 324px; height: 288px; top: 3px;}
    .merchant-20 .a1{left: -2px;}
    .merchant-20 .a2{left: 326px;}
    .merchant-20 .a3{left: 654px;}

    .merchant-21 a{width: 240px; height: 286px; top: 184px;}
    .merchant-21 .a1{left: -2px;}
    .merchant-21 .a2{left: 244px;}
    .merchant-21 .a3{left: 490px;}
    .merchant-21 .a4{left: 736px;}
    .merchant-21 .backToTop{width: 240px; height: 90px; left: 360px; top: 540px;}

    .flexslider{position:relative;height:640px;overflow:hidden;background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/bg/loading.gif) 50% no-repeat;}
    .flex-viewport{ height:auto; overflow:hidden;}
    .flexslider .slides{position:relative;z-index:1;}
    .flexslider .slides li{height:640px; text-align:center; }
    .flex-control-nav{position:absolute;bottom:10px;z-index:2;width:1200px;text-align:center; left:50%; margin-left:-600px;}
    .flex-control-nav li{display:inline-block;width:14px;height:14px;margin:0 5px;*display:inline;zoom:1;}
    .flex-control-nav a{display:inline-block;width:14px;height:14px;line-height:40px;overflow:hidden;background:url(<?php echo ATTR_DOMAIN;?>/zt/merchant/bg/dot.png) right 0 no-repeat;cursor:pointer;}
    .flex-control-nav .flex-active{background-position:0 0;}
    .flex-direction-nav{position:absolute; z-index:3; width:1200px; top:45%; left:50%; margin-left:-600px;}
    .flex-direction-nav li a{display:block;width:42px;height:118px;overflow:hidden;cursor:pointer;position:absolute;}
    .flex-direction-nav li a.flex-prev:hover,.flex-direction-nav li a.flex-next:hover{ opacity:1;}
    .flexslider .slides li a{ display:block; position:relative; width:100%; margin:0 auto; height:640px; background-position:center top;}
    .flexslider .slides li a img{ width:100%;}
    .flexslider .slides li a .dotbg{  width:1200px; margin:0 auto; position:absolute; height:40px; *height:30px; height:30px\0; overflow:hidden; background:#000; bottom:0; left:50%; margin-left:-600px; z-index:50;filter:alpha(opacity=60); opacity:0.6}


    .flexslider{overflow: inherit; width: 692px; height: auto; top: 284px; left: -2px;}
    .flexslider .slides li{height: 300px;}
    .flexslider .slides li a{height: auto;}
    .zt-con .flex-direction-nav li a.flex-prev {width: 70px; height: 70px; background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/arrow.png) top left no-repeat; top: -20px; left: 260px; opacity: 0.6;}
    .zt-con .flex-direction-nav li a.flex-next {width: 70px; height: 70px; background: url(<?php echo ATTR_DOMAIN;?>/zt/merchant/arrow.png) bottom left no-repeat; top: -20px; right: 260px; opacity: 0.6;}
    .flex-direction-nav li a{display: block;width: 54px;height: 72px;top:-10px;overflow: hidden;cursor: pointer;position: absolute;}
    .flex-control-nav{bottom: 20px;}
</style>

<div class="zt-wrap">
    <div class="merchant-01">
        <div class="zt-con flexslider">
            <div class="banner-01">
                <a href="javascript:void(0)" class="refresh"><img src="<?php echo ATTR_DOMAIN;?>/zt/merchant/banner-01.jpg"/></a>
            </div>
            <ul class="slides">
                <li>
                    <a href="http://www.g-emall.com/goods/380589.html  " class="a2" target="_blank">
                        <img src="<?php echo ATTR_DOMAIN;?>/zt/merchant/banner-02.jpg"/>
                    </a>
                </li>
                <li>
                    <a href="http://www.g-emall.com/goods/377692.html " class="a3" target="_blank">
                        <img src="<?php echo ATTR_DOMAIN;?>/zt/merchant/banner-03.jpg"/>
                    </a>
                </li>
                <li>
                    <a href="http://www.g-emall.com/goods/376900.html" class="a4" target="_blank">
                        <img src="<?php echo ATTR_DOMAIN;?>/zt/merchant/banner-04.jpg"/>
                    </a>
                </li>
                <li>
                    <a href="http://www.g-emall.com/JF/366924.html " class="a5" target="_blank">
                        <img src="<?php echo ATTR_DOMAIN;?>/zt/merchant/banner-05.jpg"/>
                    </a>
                </li>
                <li>
                    <a href="http://www.g-emall.com/goods/363224.html" class="a6" target="_blank">
                        <img src="<?php echo ATTR_DOMAIN;?>/zt/merchant/banner-06.jpg"/>
                    </a>
                </li>
                <li>
                    <a href="http://www.g-emall.com/goods/367503.html" class="a7" target="_blank">
                        <img src="<?php echo ATTR_DOMAIN;?>/zt/merchant/banner-07.jpg"/>
                    </a>
                </li>
                <li>
                    <a href="http://www.g-emall.com/goods/361098.html" class="a8" target="_blank">
                        <img src="<?php echo ATTR_DOMAIN;?>/zt/merchant/banner-08.jpg"/>
                    </a>
                </li>
                <li>
                    <a href="http://www.g-emall.com/goods/379940.html" class="a9" target="_blank">
                        <img src="<?php echo ATTR_DOMAIN;?>/zt/merchant/banner-09.jpg"/>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="merchant-02"></div>
    <div class="merchant-03">
        <div class="zt-con">
            <a href="#part1" class="a1"></a>
            <a href="#part2" class="a2"></a>
            <a href="#part3" class="a3"></a>
            <a href="#part4" class="a4"></a>
            <a href="#part5" class="a5"></a>
            <a href="#part6" class="a6"></a>
            <a href="#part7" class="a7"></a>
            <a href="#part8" class="a8"></a>
        </div>
    </div>
    <div class="merchant-04" id="part1">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5550.html?cid=0&min=0&max=0&order=0" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5545.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5559.html" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-05">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5646.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5548.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/2716.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5546.html" class="a4" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-06" id="part5">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5624.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5576.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5640.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5602.html" class="a4" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-07" id="part2">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5607.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5627.html" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-08">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5638.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5631.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5589.html" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-09">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5579.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5625.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5615.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5586.html" class="a4" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-10">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5604.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5553.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5537.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5588.html" class="a4" target="_blank"></a>
        </div>
    </div>

    <div class="merchant-11" id="part6">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5577.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5603.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5608.html" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-12">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5601.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5643.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5620.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5632.html" class="a4" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-13">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5534.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5637.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5590.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5630.html" class="a4" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-14">

        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5628.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5584.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5629.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5544.html" class="a4" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-15" id="part3">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5633.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5538.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5593.html" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-16">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5641.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5617.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5595.html" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-17" id="part7">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/2913.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5606.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5618.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5585.html" class="a4" target="_blank"></a>
        </div></div>
    <div class="merchant-18">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5635.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5650.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5564.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5621.html" class="a4" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-19" id="part4">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5622.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5611.html" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="merchant-20">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5543.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5580.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/4934.html" class="a3" target="_blank"></a>
        </div>
    </div>

    <div class="merchant-21" id="part8">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/product/5591.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5587.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5636.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/5599.html" class="a4" target="_blank"></a>
            <a href="javascript:void(0)" class="backToTop" ></a>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('.flexslider').flexslider({
            animation: "slide",
            directionNav: true,
            controlNav: true,
            slideshow: true,
            pauseOnHover: true,
            slideshowSpeed: 3000
        });
        $('.refresh').click(function(){
            $(this).parent('.banner-01').fadeOut(500);
        })
    });

    /*回到顶部*/
    $(".backToTop").click(function() {
        $('body,html').stop().animate({scrollTop: 0}, 500);
        return false;
    });

</script>