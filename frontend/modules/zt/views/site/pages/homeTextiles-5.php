<?php $this->pageTitle = "家纺专题_" . $this->pageTitle;?>

<script src="<?php echo DOMAIN; ?>/js/zt/index.js" type="text/javascript"></script>
<script type="text/javascript">
    //隐藏头尾部
    $(function(){
        $('.header,.footer').hide();
    });
</script>

<style type="text/css">
body {
    margin: 0;
}

a {
    text-decoration: none;
}

a img {
    border: none;
}

body {
    background: #fff8f6;
    font-family: "Microsoft YaHei", SimSun, Arial, Helvetica;
    min-width: 1500px;
}

.sidebar {
    display: none;
    width: 180px;
    height: 290px;
    padding-top: 145px;
    background: #fff8f6 url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/sidebar.jpg) center top no-repeat;
}
.sidebar a {
    display: block;
    width: 100%;
    height: 40px;
    margin-bottom: 13px;
}

.sidebar-fixed {
    position: fixed;
    left: 20px;
    top: 20%;
    z-index: 100;
}

.marry-bg {
    background-color: #fff8f6;
    background-position: center top;
    background-repeat: no-repeat;
}

.marry1 {
    height: 300px;
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/marry_01.jpg);
}

.marry2-1 {
    height: 197px;
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/marry_02_01.jpg);
}

.marry2-2 {
    height: 197px;
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/marry_02_02.jpg);
}

.marry3-1 {
    height: 240px;
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/marry_04_01.jpg);
}

.marry3-2 {
    height: 240px;
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/marry_04_02.jpg);
}

.marry4 {
    height: 300px;
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/marry_06.jpg);
}

.marry5 {
    height: 302px;
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/marry_08.jpg);
}

.marry6 {
    height: 302px;
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/marry_10.jpg);
}

.marry7 {
    height: 302px;
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/marry_12.jpg);
}

.marry8 {
    height: 532px;
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/marry_14.jpg);
}

.marry9 {
    height: 262px;
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/marry_16.jpg);
}
.marry9 .accordion {
    position: relative;
    width: 1100px;
    margin: 0 auto;
    height: 219px;
    overflow: hidden;
    padding-top: 43px;
}
.marry9 .accordion .accordion-right {
    float: right;
    width: 358px;
    height: 219px;
    overflow: hidden;
}
.marry9 .accordion .item {
    position: relative;
    float: left;
    width: 86px;
    height: 219px;
    overflow: hidden;
}
.marry9 .accordion .item .cover {
    position: absolute;
    display: block;
    width: 86px;
    height: 219px;
    background-position: center top;
    background-repeat: no-repeat;
    z-index: 2;
    border: 0;
}
.marry9 .accordion .item .cover1 {
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/cover1.png);
}
.marry9 .accordion .item .cover2 {
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/cover2.png);
}
.marry9 .accordion .item .cover3 {
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/cover3.png);
}
.marry9 .accordion .item .cover4 {
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/cover4.png);
}

.marry-box {
    position: relative;
    width: 1100px;
    height: 388px;
    margin: 0 auto;
    background-color: #ccc;
    background-repeat: no-repeat;
}
.marry-box img {
    position: absolute;
    width: 50%;
    height: 100%;
}
.marry-box a:hover .img-default {
    display: none;
}
.marry-box a:hover .img-hover {
    display: block;
}

.img-default {
    display: block;
}

.img-hover {
    display: none;
}

.box-triangle {
    position: absolute;
    top: 50%;
    margin-top: -27px;
    width: 0;
    height: 0;
    border: 27px solid transparent;
    z-index: 2;
}

.box-left {
    background-position: right top;
}
.box-left img {
    left: 0;
    top: 0;
}
.box-left .box-triangle {
    right: 50%;
    border-right-color: #fdda06;
}

.box-right {
    background-position: left top;
}
.box-right img {
    right: 0;
    top: 0;
}
.box-right .box-triangle {
    left: 50%;
    border-left-color: #fdda06;
}

.box1 {
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/marry_20.jpg);
}

.box2 {
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/marry_21.jpg);
}

.box3 {
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/marry_22.jpg);
}

.box4 {
    background-image: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/marry_23.jpg);
}

.w1100 {
    width: 1100px;
    margin: 0 auto;
    overflow: hidden;
}
.w1100 .container {
    margin: 0 -10px;
}
.w1100 .item {
    float: left;
    margin-left: 10px;
    margin-right: 10px;
    background: #fff;
}
.w1100 .item a {
    display: block;
    width: 353px;
    height: 435px;
    overflow: hidden;
    color: #000;
    text-align: center;
}
.w1100 .item img {
    width: 100%;
    height: 304px;
}
.w1100 .item:hover .img-default {
    display: none;
}
.w1100 .item:hover .img-hover {
    display: block;
}
.w1100 .item-tit {
    font-size: 18px;
    margin: 10px 0;
}
.w1100 .item-price {
    font-style: normal;
    font-size: 25px;
    color: #c5071c;
}
.w1100 .item-store {
    width: 100%;
    line-height: 37px;
    margin: 10px 0 15px;
    background: #fdda06;
}

.foot-links {
    width: 966px;
    margin: 0 auto;
    height: 173px;
    padding-top: 62px;
    overflow: hidden;
}
.foot-links .item {
    float: left;
    margin: 0 15px;
    width: 131px;
    line-height: 61px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/bg/footer-link-bgs.png) center top no-repeat;
    text-align: center;
}
.foot-links .item a {
    font-size: 20px;
    color: #000;
}
.foot-links .hover1:hover {
    background-position: 0 -62px;
}
.foot-links .hover2:hover {
    background-position: 0 -124px;
}
.foot-links .hover3:hover {
    background-position: 0 -186px;
}
.foot-links .hover4:hover {
    background-position: 0 -248px;
}
.foot-links .hover5:hover {
    background-position: 0 -310px;
}
.foot-links .hover6:hover {
    background-position: 0 -372px;
}

</style>

<!DOCTYPE html>
<html lang="cmn-hans">

<head>
    <meta charset="UTF-8">
    <title>婚嫁馆</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
<div id="sidebarFixed" class="sidebar sidebar-fixed">
    <a href="#part1"></a>
    <a href="#part2"></a>
    <a href="#part3"></a>
    <a href="#part4"></a>
</div>
<div class="marry-bg marry1"></div>
<div class="marry-bg marry2-1"></div>
<div class="marry-bg marry2-2"></div>
<div class="marry-bg marry3-1"></div>
<div class="marry-bg marry3-2"></div>
<div id="part1" class="marry-bg marry4"></div>
<div class="marry-box box1 box-left">
    <a href="http://www.g-emall.com/goods/198751.html" target="_blank" title="贡缎提花四件套-情深意浓（大红）">
        <img class="img-default" src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/product1.jpg">
        <img class="img-hover" src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/product1-1.jpg">
    </a>
    <div class="box-triangle"></div>
</div>
<div id="part2" class="marry-bg marry5"></div>
<div class="marry-box box2 box-right">
    <a href="http://www.g-emall.com/JF/187918.html" target="_blank" title="全棉提加印四件套-美丽邂逅（砖红）">
        <img class="img-default" src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/product2.jpg" alt="全棉提加印四件套-美丽邂逅（砖红）">
        <img class="img-hover" src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/product2-1.jpg" alt="全棉提加印四件套-美丽邂逅（砖红）">
    </a>
    <div class="box-triangle"></div>
</div>
<div id="part3" class="marry-bg marry6"></div>
<div class="marry-box box3 box-left">
    <a href="http://www.g-emall.com/JF/146484.html" target="_blank" title="奢华蚕丝棉提花四件套 浪漫花语大红">
        <img class="img-default" src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/product3.jpg" alt="奢华蚕丝棉提花四件套 浪漫花语大红">
        <img class="img-hover" src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/product3-1.jpg" alt="奢华蚕丝棉提花四件套 浪漫花语大红">
    </a>
    <div class="box-triangle"></div>
</div>
<div id="part4" class="marry-bg marry7"></div>
<div class="marry-box box4 box-right">
    <a href="http://www.g-emall.com/goods/146500.html
" target="_blank" title="如家家居 奢华天丝棉花边款四件套 玫瑰风情">
        <img class="img-default" src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/product4.jpg" alt="如家家居 奢华天丝棉花边款四件套 玫瑰风情">
        <img class="img-hover" src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/product4-1.jpg" alt="如家家居 奢华天丝棉花边款四件套 玫瑰风情">
    </a>
    <div class="box-triangle"></div>
</div>
<div class="marry-bg marry8"></div>
<div class="w1100">
    <div class="container">
        <div class="item">
            <a href="http://www.g-emall.com/JF/27533.html" target="_blank" title="布拉格恋人（红色）婚庆家纺床品">
                <img class="img-default" width="353px" height="304px" src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/product5.jpg" alt="布拉格恋人（红色）婚庆家纺床品">
                <img class="img-hover" width="353px" height="304px" src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/product5-1.jpg" alt="布拉格恋人（红色）婚庆家纺床品">
                <p class="item-tit">婚庆家纺床品布拉格恋人（红色）</p>
                <em class="item-price">囍庆价：2680</em>
                <p class="item-store">美莱婚庆用品商行</p>
            </a>
        </div>
        <div class="item">
            <a href="http://www.g-emall.com/goods/27523.html" target="_blank" title="婚庆床上用品 绸缎纯棉婚庆 龙凤双喜红">
                <img class="img-default" width="353px" height="304px" src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/product6.jpg" alt="婚庆床上用品 绸缎纯棉婚庆 龙凤双喜红">
                <img class="img-hover" width="353px" height="304px" src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/product6-1.jpg" alt="婚庆床上用品 绸缎纯棉婚庆 龙凤双喜红">
                <p class="item-tit">婚庆床上用品 绸缎纯棉婚庆 龙凤双喜红</p>
                <em class="item-price">囍庆价：1180</em>
                <p class="item-store">美莱婚庆用品商行</p>
            </a>
        </div>
        <div class="item">
            <a href="http://www.g-emall.com/JF/143009.html" target="_blank" title="极品奢华婚庆大红十件套 国色天香">
                <img class="img-default" width="353px" height="304px" src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/product7.jpg" alt="极品奢华婚庆大红十件套 国色天香">
                <img class="img-hover" width="353px" height="304px" src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/product7.jpg" alt="极品奢华婚庆大红十件套 国色天香">
                <p class="item-tit">极品奢华婚庆大红十件套 国色天香</p>
                <em class="item-price">囍庆价：1660</em>
                <p class="item-store">如家家居馆</p>
            </a>
        </div>
    </div>
</div>
<div class="marry-bg marry9">
    <div class="accordion">
        <div class="accordion-right" id="marrySlider">
            <div class="item open">
                <a class="cover cover1" href="http://www.g-emall.com/shop/1837.html" target="_blank"></a>
                <a href="http://www.g-emall.com/shop/1837.html" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/marry-slide1.jpg"></a>
            </div>
            <div class="item">
                <a class="cover cover2" href="http://www.g-emall.com/shop/1801.html" target="_blank"></a>
                <a href="http://www.g-emall.com/shop/1801.html" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/marry-slide2.jpg"></a>
            </div>
            <div class="item">
                <a class="cover cover4" href="http://www.g-emall.com/shop/424.html" target="_blank"></a>
                <a href="http://www.g-emall.com/shop/424.html" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/homeTextiles-5/temp/marry-slide4.jpg"></a>
            </div>
        </div>
    </div>
</div>
<div class="foot-links">
    <div class="item hover1">
        <div class="link"><a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/homeTextiles-5">浪漫婚嫁馆</a></div>
    </div>
    <div class="item hover2">
        <div class="link"><a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/homeTextiles-1">缤纷儿童馆</a></div>
    </div>
    <div class="item hover3">
        <div class="link"><a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/homeTextiles-3">雅致现代馆</a></div>
    </div>
    <div class="item hover4">
        <div class="link"><a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/homeTextiles-2">田园韩式馆</a></div>
    </div>
    <div class="item hover5">
        <div class="link"><a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/homeTextiles-4">奢华欧式馆</a></div>
    </div>
    <div class="item hover6">
        <div class="link"><a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/homeTextiles-6">经典美式馆</a></div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/index.js"></script>
<script>
    $('#sidebarFixed').sidebar(500);
    $('#marrySlider').accordion({
        itemClassName: 'item',
        delay: 300,
        width_closed: 86,
        width_opened: 186
    });
</script>
</body>

</html>
