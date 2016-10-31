<?php $this->pageTitle = "誓死不光棍_" . $this->pageTitle;?>

<script type="text/javascript">
    //隐藏头尾部
    $(function(){
        $('.header,.footer').hide();
    });
</script>

<script src="<?php echo DOMAIN; ?>/js/html5shiv.min.js" type="text/javascript"></script>
<script src="<?php echo DOMAIN; ?>/js/jquery.easing.1.3.js" type="text/javascript"></script>
<script src="<?php echo DOMAIN; ?>/js/jquery.scrollify.js" type="text/javascript"></script>
<script src="<?php echo DOMAIN; ?>/js/awardRotate.js" type="text/javascript"></script>

<style type="text/css">
/*=====
@Date:2014-11-03
@content:誓死不光棍
@author:林聪毅
=====*/
.zt-wrap{width:100%; background:#fff;}
.zt-con { width:1200px; margin:0 auto; position:relative; }
.zt-con a{ position:absolute;display:block;}
body{margin: 0;}
.shopping-02{height:326px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-02.jpg) top center no-repeat;}
.shopping-03{
    width: 100%; height:276px;
    background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-03.jpg) top center no-repeat;
    position: absolute; left: 0px; bottom: 0px; z-index: 3;}
.shopping-06{height:276px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-06.jpg) top center no-repeat;}
.shopping-07{
    width: 100%; height:231px;
    background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-07.jpg) top center no-repeat;
    position: absolute; left: 0px; bottom: 10px; z-index: 3;}
.shopping-09{
    width: 100%; height:231px;
    background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-09.jpg) top center no-repeat;
    position: absolute; left: 0px; bottom: 10px; z-index: 3;}
.shopping-11{
    width: 100%; height:230px;
    background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-11.jpg) top center no-repeat;
    position: absolute; left: 0px; bottom: 10px; z-index: 3;}
.shopping-14{
    width: 531px; height: 659px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-14.png) top center no-repeat;
    position: absolute; left: 58%; top: 26%; z-index: 2;}

.shopping-21{height:326px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-21.jpg) top center no-repeat;}
.shopping-23{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-23.jpg) top center no-repeat;}
.shopping-24{height:326px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-24.jpg) top center no-repeat;}
.shopping-25{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-25.jpg) top center no-repeat;}
.shopping-26{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-26.jpg) top center no-repeat;}
.shopping-27{height:326px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-27.jpg) top center no-repeat;}
.shopping-28{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-28.jpg) top center no-repeat;}
.shopping-29{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-29.jpg) top center no-repeat;}
.shopping-30{height:326px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-30.jpg) top center no-repeat;}

.shopping-31{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-31.jpg) top center no-repeat;}
.shopping-32{height:980px; position: relative; overflow: hidden;}
.shopping-33{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-33.jpg) top center no-repeat;}
.shopping-34{height:326px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-34.jpg) top center no-repeat;}
.shopping-35{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-35.jpg) top center no-repeat;}
.shopping-36{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-36.jpg) top center no-repeat;}
.shopping-37{height:326px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-37.jpg) top center no-repeat;}
.shopping-38{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-38.jpg) top center no-repeat;}
.shopping-39{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-39.jpg) top center no-repeat;}
.shopping-40{height:326px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-40.jpg) top center no-repeat; position: relative;}

.shopping-41{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-41.jpg) top center no-repeat;}
.shopping-42{height:338px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-42.jpg) top center no-repeat;}
.shopping-43{height:338px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-43.jpg) top center no-repeat;}
.shopping-44{height:304px; background:url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-44.jpg) top center no-repeat;}

ul{list-style: none;}
section{overflow: hidden;}
.part2,.part4,.part5,.part6,.part8,.part9,.part14{position: relative;}
.inner{position: relative;}
.inner>img{position: absolute; min-width: 1400px;}
.mouseHover{width: 101px; height: 85px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/mouseHover.png) no-repeat;}
.boom1{width: 94px; height: 267px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/boom-01.png) no-repeat; display: none; z-index: 2;}
.boom2{width: 94px; height: 267px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/boom-02.png) no-repeat; display: none; z-index: 2;}
.boom3{width: 94px; height: 267px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/boom-03.png) no-repeat; display: none; z-index: 2;}

.shopping-01 .data1{}
.shopping-01 .data2{}
.shopping-01 .data3{}
.shopping-01 .data-logo1{
    width: 274px; height: 258px;
    position: absolute; left: 10%; top: 60%; z-index: 3;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/data-logo1.png) top center no-repeat;
}
.shopping-01 .data-logo2{
    width: 274px; height: 262px;
    position: absolute; left: 40%; top: 64%; z-index: 3;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/data-logo2.png) top center no-repeat;
}
.shopping-01 .data-logo3{
    width: 274px; height: 258px;
    position: absolute; left: 70%; top: 60%; z-index: 3;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/data-logo3.png) top center no-repeat;
}
.shopping-01 .mask-bg-01{
    width: 274px; height: 980px;
    position: absolute; left: 10%; bottom: 0px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/mask-bg-01.png) no-repeat; display: none;
}
.shopping-01 .mask-bg-02{
    width: 274px; height: 980px;
    position: absolute; left: 40%; bottom: 0px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/mask-bg-02.png) no-repeat; display: none;
}
.shopping-01 .mask-bg-03{
    width: 274px; height: 980px;
    position: absolute; left: 70%; bottom: 0px;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/mask-bg-03.png) no-repeat; display: none;
}
.shopping-01 span{display: block; display: none;}
.shopping-01 .lover{width: 226px; height: 316px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/lover.png) no-repeat; z-index: 2; display: none;}
.loverPos1{position: absolute; left: 12%; top: 52%;}
.loverPos2{position: absolute; left: 41%; top: 58%;}
.loverPos3{position: absolute; left: 72%; top: 52%;}
.shopping-01 .goods-01{
    width: 108px; height: 120px;
    position: absolute; left: 14%; top: 64%; z-index: 2;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/goods-01.png) no-repeat;
}
.shopping-01 .goods-02{
    width: 93px; height: 90px;
    position: absolute; left: 14%; top: 64%; z-index: 2;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/goods-02.png) no-repeat;
}
.shopping-01 .goods-03{
    width: 83px; height: 100px;
    position: absolute; left: 14%; top: 64%; z-index: 2;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/goods-03.png) no-repeat;
}
.shopping-01 .goods-04{
    width: 136px; height: 99px;
    position: absolute; left: 46%; top: 68%; z-index: 2;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/goods-04.png) no-repeat;
}
.shopping-01 .goods-05{
    width: 122px; height: 120px;
    position: absolute; left: 46%; top: 68%; z-index: 2;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/goods-05.png) no-repeat;
}
.shopping-01 .goods-06{
    width: 115px; height: 115px;
    position: absolute; left: 46%; top: 68%; z-index: 2;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/goods-06.png) no-repeat;
}
.shopping-01 .goods-07{
    width: 133px; height: 144px;
    position: absolute; left: 75%; top: 64%; z-index: 2;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/goods-07.png) no-repeat;
}
.shopping-01 .goods-08{
    width: 120px; height: 123px;
    position: absolute; left: 75%; top: 64%; z-index: 2;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/goods-08.png) no-repeat;
}
.shopping-01 .goods-09{
    width: 142px; height: 149px;
    position: absolute; left: 75%; top: 64%; z-index: 2;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/goods-09.png) no-repeat;
}
.shopping-02 .rotate{width: 550px; height: 550px; position: absolute; left: 6%; top: 4%;}
.shopping-02 .pointer{width: 119px; height: 141px; position: absolute; left: 30%; top: 26%; cursor: pointer;}
.shopping-03 a{}
.shopping-03 .a1{width: 230px; height: 230px; position: absolute; left: 20px; top: 0px;}
.shopping-03 .a2{width: 150px; height: 230px; position: absolute; left: 330px; top: 0px;}
.shopping-03 .a3{width: 210px; height: 230px; position: absolute; left: 500px; top: 0px;}
.shopping-03 .a4{width: 170px; height: 230px; position: absolute; left: 750px; top: 0px;}
.shopping-03 .a5{width: 170px; height: 230px; position: absolute; left: 1000px; top: 0px;}
.shopping-03 .sub-a1{width: 255px; height: 471px; top: -186px; left: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-sweepstake-01.png) no-repeat; display: none;}
.shopping-03 .sub-a2{width: 255px; height: 471px; top: -186px; left: -90px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-sweepstake-02.png) no-repeat; display: none;}
.shopping-03 .sub-a3{width: 255px; height: 471px; top: -186px; left: -20px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-sweepstake-03.png) no-repeat; display: none;}
.shopping-03 .sub-a4{width: 255px; height: 467px; top: -186px; left: -20px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-sweepstake-04.png) no-repeat; display: none;}
.shopping-03 .sub-a5{width: 255px; height: 466px; top: -286px; left: -40px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-sweepstake-05.png) no-repeat; display: none;}
.shopping-04>img{z-index: 2;}
.shopping-04 .shopping-05{position: absolute; right: 0; top: 0px;}
.shopping-04 .boom1pos{position: absolute; left: 56%; top: -30%;}
.shopping-04 .boom2pos{position: absolute; left: 64%; top: -30%;}
.shopping-04 .boom3pos{position: absolute; left: 72%; top: -30%;}
.shopping-06 .label-02{
    width: 260px; height: 494px;
    position: absolute; left: 14%; top: 6%; z-index: 2;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/label-02.png) no-repeat;
}
.shopping-07 .mouseHoverPos{position: absolute; left: -2%; top: 120px;}
.shopping-07 a{}
.shopping-07 .a1{width: 230px; height: 230px; position: absolute; left: 20px; top: 0px;}
.shopping-07 .a2{width: 280px; height: 230px; position: absolute; left: 430px; top: 0px;}
.shopping-07 .a3{width: 260px; height: 230px; position: absolute; left: 870px; top: 0px;}
.shopping-07 .sub-a1{width: 389px; height: 436px; top: -212px; left: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-wine-01.png) no-repeat; display: none;}
.shopping-07 .sub-a2{width: 389px; height: 436px; top: -212px; left: -20px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-wine-02.png) no-repeat; display: none;}
.shopping-07 .sub-a3{width: 389px; height: 436px; top: -212px; left: -70px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-wine-03.png) no-repeat; display: none;}
.shopping-08 .label-03{
    width: 407px; height: 438px;
    position: absolute; left: 14%; top: 12%; z-index: 2;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/label-03.png) no-repeat;
}
/*.shopping-09 .mouseHoverPos{position: absolute; left: -10%; top: 100px;}*/
.shopping-09 a{}
.shopping-09 .a1{width: 180px; height: 230px; position: absolute; left: -30px; top: 0px;}
.shopping-09 .a2{width: 140px; height: 230px; position: absolute; left: 166px; top: 0px;}
.shopping-09 .a3{width: 150px; height: 230px; position: absolute; left: 350px; top: 0px;}
.shopping-09 .a4{width: 150px; height: 230px; position: absolute; left: 520px; top: 0px;}
.shopping-09 .a5{width: 180px; height: 230px; position: absolute; left: 680px; top: 0px;}
.shopping-09 .a6{width: 160px; height: 230px; position: absolute; left: 890px; top: 0px;}
.shopping-09 .a7{width: 160px; height: 230px; position: absolute; left: 1060px; top: 0px;}
.shopping-09 .sub-a1{width: 245px; height: 414px; top: -184px; left: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-gentleman-01.png) no-repeat; display: none;}
.shopping-09 .sub-a2{width: 245px; height: 414px; top: -184px; left: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-gentleman-02.png) no-repeat; display: none;}
.shopping-09 .sub-a3{width: 245px; height: 414px; top: -184px; left: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-gentleman-03.png) no-repeat; display: none;}
.shopping-09 .sub-a4{width: 245px; height: 414px; top: -184px; left: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-gentleman-04.png) no-repeat; display: none;}
.shopping-09 .sub-a5{width: 245px; height: 414px; top: -184px; left: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-gentleman-05.png) no-repeat; display: none;}
.shopping-09 .sub-a6{width: 245px; height: 414px; top: -184px; left: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-gentleman-06.png) no-repeat; display: none;}
.shopping-09 .sub-a7{width: 245px; height: 414px; top: -184px; left: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-gentleman-07.png) no-repeat; display: none;}
/*.shopping-11 .mouseHoverPos{position: absolute; left: -6%; top: 100px;}*/
.shopping-11 a{}
.shopping-11 .a1{width: 250px; height: 230px; position: absolute; left: -10px; top: 0px;}
.shopping-11 .a2{width: 190px; height: 230px; position: absolute; left: 310px; top: 0px;}
.shopping-11 .a3{width: 220px; height: 230px; position: absolute; left: 630px; top: 0px;}
.shopping-11 .a4{width: 200px; height: 230px; position: absolute; left: 960px; top: 0px;}
.shopping-11 .sub-a1{width: 255px; height: 441px; top: -212px; left: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-eeyle-01.png) no-repeat; display: none;}
.shopping-11 .sub-a2{width: 255px; height: 441px; top: -212px; left: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-eeyle-02.png) no-repeat; display: none;}
.shopping-11 .sub-a3{width: 255px; height: 441px; top: -212px; left: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-eeyle-03.png) no-repeat; display: none;}
.shopping-11 .sub-a4{width: 255px; height: 441px; top: -212px; left: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/hover-eeyle-04.png) no-repeat; display: none;}
.shopping-12 .boom1pos{position: absolute; left: 32%; top: -30%;}
.shopping-12 .boom2pos{position: absolute; left: 40%; top: -30%;}
.shopping-12 .boom3pos{position: absolute; left: 48%; top: -30%;}


.shopping-14 .a1{width: 130px; height: 260px; position: absolute; left: 220px; top: 0px; z-index: 4;}
.shopping-14 .a2{width: 80px; height: 250px; position: absolute; left: 354px; top: 98px; z-index: 4;}
.shopping-14 .a3{width: 110px; height: 120px; position: absolute; left: 26px; top: 230px; z-index: 5;}
.shopping-14 .a4{width: 110px; height: 120px; position: absolute; left: 334px; top: 360px; z-index: 4;}
.shopping-14 .a5{width: 100px; height: 90px; position: absolute; left: 150px; top: 234px; z-index: 4;}
.shopping-14 .a6{width: 180px; height: 190px; position: absolute; left: 80px; top: 330px; z-index: 4;}
.shopping-14 .a7{width: 100px; height: 110px; position: absolute; left: 238px; top: 446px; z-index: 5;}
.shopping-14 .a8{width: 84px; height: 146px; position: absolute; left: 250px; top: 280px; z-index: 5;}
.shopping-14 .a9{width: 110px; height: 150px; position: absolute; left: 110px; top: 90px; z-index: 4;}
.shopping-15 a{width: 610px; height: 502px; left: 120px; top: -500px; display: none;}
.shopping-15 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/cosmetic-01.png) no-repeat;}
.shopping-15 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/cosmetic-02.png) no-repeat;}
.shopping-15 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/cosmetic-03.png) no-repeat;}
.shopping-15 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/cosmetic-04.png) no-repeat;}
.shopping-15 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/cosmetic-05.png) no-repeat;}
.shopping-15 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/cosmetic-06.png) no-repeat;}
.shopping-15 .a7{background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/cosmetic-07.png) no-repeat;}
.shopping-15 .a8{background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/cosmetic-08.png) no-repeat;}
.shopping-15 .a9{background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/cosmetic-09.png) no-repeat;}
.shopping-16 a{}
.shopping-16 .a1{width: 300px; height: 170px; display: inline-block; left: 27%; top: 0; z-index: 3}
.shopping-16 .a2{width: 170px; height: 700px; display: inline-block; left: 27%; top: 12%; z-index: 2;}
.shopping-16 .a3{width: 210px; height: 210px; display: inline-block; left: 16%; top: 15%;}
.shopping-16 .a4{width: 200px; height: 200px; display: inline-block; left: 16%; top: 47%;}
.shopping-16 .a5{width: 210px; height: 210px; display: inline-block; left: 16%; top: 68%; z-index: 3;}
.shopping-16 .a6{width: 460px; height: 150px; display: inline-block; left: 52%; top: 0;}
.shopping-16 .a7{width: 300px; height: 150px; display: inline-block; left: 52%; top: 16%; z-index: 2;}
.shopping-16 .a8{width: 310px; height: 760px; display: inline-block; left: 62%; top: 12%;}
.shopping-16 .a9{width: 300px; height: 240px; display: inline-block; left: 52%; top: 68%; z-index: 2;}
.shopping-17 a{}
.shopping-17 .a1{width: 204px; height: 300px; left: 8%; top: 5%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/food-01.png) no-repeat;}
.shopping-17 .a2{width: 300px; height: 266px; left: 6%; top: 48%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/food-02.png) no-repeat;}
.shopping-17 .a3{width: 380px; height: 141px; left: 22%; top: 80%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/food-03.png) no-repeat;}
.shopping-17 .a4{width: 345px; height: 180px; left: 56%; top: 76%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/food-04.png) no-repeat;}
.shopping-17 .a5{width: 211px; height: 209px; left: 76%; top: 60%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/food-05.png) no-repeat;}
.shopping-17 .a6{width: 214px; height: 211px; left: 78%; top: 34%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/food-06.png) no-repeat;}
.shopping-17 .a7{width: 144px; height: 190px; left: 74%; top: 10%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/food-07.png) no-repeat;}
.shopping-18 .label-04{
    width: 624px; height: 473px;
    position: absolute; left: 44%; top: 220px; z-index: 2;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/label-04.png) no-repeat;
}
.shopping-18 .boom1pos{position: absolute; left: 60%; top: -30%}
.shopping-18 .boom2pos{position: absolute; left: 68%; top: -30%}
.shopping-18 .boom3pos{position: absolute; left: 76%; top: -30%}
.shopping-19 a{}
.shopping-19 .a1{width: 299px; height: 151px; left: 18%; top: 28%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/clean-01.png) no-repeat;}
.shopping-19 .a2{width: 357px; height: 140px; left: 18%; top: 42%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/clean-02.png) no-repeat;}
.shopping-19 .a3{width: 363px; height: 139px; left: 24%; top: 56%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/clean-03.png) no-repeat;}
.shopping-19 .a4{width: 338px; height: 135px; left: 30%; top: 76%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/clean-04.png) no-repeat;}
.shopping-19 .a5{width: 248px; height: 130px; left: 46%; top: 28%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/dinner-01.png) no-repeat;}
.shopping-19 .a6{width: 232px; height: 140px; left: 65%; top: 27%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/dinner-02.png) no-repeat;}
.shopping-19 .a7{width: 284px; height: 100px; left: 46%; top: 48%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/dinner-03.png) no-repeat;}
.shopping-19 .a8{width: 247px; height: 130px; left: 66%; top: 46%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/dinner-04.png) no-repeat;}
.shopping-19 .a9{width: 418px; height: 102px; left: 52%; top: 68%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/dinner-05.png) no-repeat;}

.shopping-20 a{}
.shopping-20 .a1{width: 332px; height: 244px; left: 4%; top: 30%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shower-01.png) no-repeat;}
.shopping-20 .a2{width: 402px; height: 204px; left: 32%; top: 30%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shower-02.png) no-repeat;}
.shopping-20 .a3{width: 439px; height: 228px; left: 20%; top: 48%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shower-03.png) no-repeat;}
.shopping-20 .a4{width: 549px; height: 206px; left: 2%; top: 70%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shower-04.png) no-repeat;}
.shopping-20 .a5{width: 642px; height: 245px; left: 42%; top: 68%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/shower-05.png) no-repeat;}
.shopping-21 a{}
.shopping-21 .a1{width: 191px; height: 350px; left: 6%; top: 10%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/light-01.png) no-repeat;}
.shopping-21 .a2{width: 382px; height: 248px; left: 6%; top: 66%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/light-02.png) no-repeat;}
.shopping-21 .a3{width: 360px; height: 200px; left: 64%; top: 72%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/light-03.png) no-repeat;}
.shopping-21 .a4{width: 226px; height: 320px; left: 74%; top: 10%; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/light-04.png) no-repeat;}
.shopping-22{position: absolute; left: 26%; top: 4%;}
.shopping-22 .label-05{
    width: 220px; height: 210px;
    position: absolute; left: 48%; top: 64%; z-index: 2;
    background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/label-05.png) no-repeat;
}
.shopping-23 .zt-con{top: 75%;}
.shopping-23 ul{margin: 0 auto;}
.shopping-23 ul.wd760{width: 760px;}
.shopping-23 ul.wd800{width: 800px;}
.shopping-23 ul.wd930{width: 930px;}
.shopping-23 ul.wd990{width: 990px;}
.shopping-23 ul.wd1030{width: 1030px;}
.shopping-23 ul li{float: left; margin: 6px;}
.shopping-23 ul li a{color: #4f4840; text-decoration: none; font-family: '微软雅黑'; font-weight: bold; padding: 4px 8px; border: 2px solid #4f4840; position: static;}
.sub-nav{width: 30px; height: 400px; position: fixed; right: 100px; top: 20%; z-index: 100;}
.sub-nav ul{width: 30px;}
.sub-nav ul li{width: 30px; height: 30px;}
.sub-nav ul li a{width: 23px; height: 23px; background: url(<?php echo ATTR_DOMAIN;?>/zt/shopping/dot.png) left top no-repeat; display: block}
.sub-nav ul li a.active{background-position: left bottom;}
.onScale{
    animation:onScale 20s linear infinite;
    -moz-animation:onScale 20s linear infinite;
    -webkit-animation:onScale 20s linear infinite;
    -ms-animation:onScale 20s linear infinite;
    -o-animation:onScale 20s linear infinite;
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

.onJump{
    animation:onJump 1s ease-in-out infinite;
    -moz-animation:onJump 1s ease-in-out infinite;
    -webkit-animation:onJump 1s ease-in-out infinite;
    -ms-animation:onJump 1s ease-in-out infinite;
    -o-animation:onJump 1s ease-in-out infinite;
}
@-webkit-keyframes onJump {
    0% 	{-webkit-transform: translateY(0);}
    50% {-webkit-transform: translateY(-50px);}
    100%{-webkit-transform: translateY(0);}
}
@-moz-keyframes onJump {
    0% 	{-moz-transform: translateY(0);}
    50% {-moz-transform: translateY(-50px);}
    100%{-moz-transform: translateY(0);}
}
@-ms-keyframes onJump {
    0% 	{-ms-transform: translateY(0);}
    50% {-ms-transform: translateY(-50px);}
    100%{-ms-transform: translateY(0);}
}
@-o-keyframes onJump {
    0% 	{-o-transform: translateY(0);}
    50% {-o-transform: translateY(-50px);}
    100%{-o-transform: translateY(0);}
}

.backToMain{width: 20px; height: 130px; padding: 8px; background: #f31993; position: absolute; left: 4%; top: 30%; box-shadow: 0px 0px 20px #ef1d90; z-index: 99;}
.backToMain a{text-decoration: none; font-weight: bold; font-family: '微软雅黑'; color: #fff;}
</style>


<section class="panel part1" data-section-name="part1">
    <div class="inner shopping-01">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-01.jpg"/>
        <div class="backToMain">
            <a href="<?php echo DOMAIN;?>">返回商城首页</a>
        </div>
        <div class="data1">
            <a href="javascript:void(0)" class="data-logo1"></a>
            <div class="mask-bg-01"></div>
            <span class="lover loverPos1"></span>
            <span class="goods-01"></span>
            <span class="goods-02"></span>
            <span class="goods-03"></span>
        </div>
        <div class="data2">
            <a href="javascript:void(0)" class="data-logo2"></a>
            <div class="mask-bg-02"></div>
            <span class="lover loverPos2"></span>
            <span class="goods-04"></span>
            <span class="goods-05"></span>
            <span class="goods-06"></span>
        </div>
        <div class="data3">
            <a href="javascript:void(0)" class="data-logo3"></a>
            <div class="mask-bg-03"></div>
            <span class="lover loverPos3"></span>
            <span class="goods-07"></span>
            <span class="goods-08"></span>
            <span class="goods-09"></span>
        </div>
    </div>
</section>
<section class="panel part2" data-section-name="part2">
    <div class="inner shopping-02">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-02.jpg"/>
        <div class="rotate">
            <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/rotate.png" id="rotate"/>
            <div class="pointer"><img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/pointer.png"/></div>
        </div>

    </div>
    <div class="shopping-03">
        <div class="zt-con">
            <div class="a1">
                <a href="http://www.g-emall.com/JF/222998.html" class="sub-a1" target="_blank"></a>
            </div>
            <div class="a2">
                <a href="http://www.g-emall.com/JF/224059.html" class="sub-a2" target="_blank"></a>
            </div>
            <div class="a3">
                <a href="http://www.g-emall.com/goods/58060.html" class="sub-a3" target="_blank"></a>
            </div>
            <div class="a4">
                <a href="http://www.g-emall.com/goods/257019.html" class="sub-a4" target="_blank"></a>
            </div>
            <div class="a5">
                <a href="http://www.g-emall.com/goods/232878.html" class="sub-a5" target="_blank"></a>
            </div>
        </div>
    </div>
</section>
<section class="panel part3" data-section-name="part3">
    <div class="inner shopping-04">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-04.png" class="onScale" />
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-05.png" class="shopping-05" />
        <div class="boom1 boom1pos"></div>
        <div class="boom2 boom2pos"></div>
        <div class="boom3 boom3pos"></div>
    </div>
</section>
<section class="panel part4" data-section-name="part4">
    <div class="inner shopping-06">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-06.jpg" class="onScale" />
        <div class="label-02"></div>
    </div>
    <div class="shopping-07">
        <div class="zt-con">
            <div class="mouseHover mouseHoverPos"></div>
            <div class="a1">
                <a href="http://www.g-emall.com/JF/165063.html" class="sub-a1" target="_blank"></a>
            </div>
            <div class="a2">
                <a href="http://www.g-emall.com/JF/144006.html" class="sub-a2" target="_blank"></a>
            </div>
            <div class="a3">
                <a href="http://www.g-emall.com/JF/269891.html" class="sub-a3" target="_blank"></a>
            </div>
        </div>
    </div>
</section>
<section class="panel part5" data-section-name="part5">
    <div class="inner shopping-08">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-08.jpg" class="onScale" />
        <div class="label-03"></div>
    </div>
    <div class="shopping-09">
        <div class="zt-con">
            <!-- <div class="mouseHover mouseHoverPos"></div> -->
            <div class="a1">
                <a href="http://www.g-emall.com/JF/201762.html" class="sub-a1" target="_blank"></a>
            </div>
            <div class="a2">
                <a href="http://www.g-emall.com/JF/215606.html" class="sub-a2" target="_blank"></a>
            </div>
            <div class="a3">
                <a href="http://www.g-emall.com/JF/66330.html" class="sub-a3" target="_blank"></a>
            </div>
            <div class="a4">
                <a href="http://www.g-emall.com/JF/248240.html" class="sub-a4" target="_blank"></a>
            </div>
            <div class="a5">
                <a href="http://www.g-emall.com/JF/71826.html" class="sub-a5" target="_blank"></a>
            </div>
            <div class="a6">
                <a href="http://www.g-emall.com/goods/64810.html" class="sub-a6" target="_blank"></a>
            </div>
            <div class="a7">
                <a href="http://www.g-emall.com/JF/64801.html" class="sub-a7" target="_blank"></a>
            </div>
        </div>
    </div>
</section>
<section class="panel part6" data-section-name="part6">
    <div class="inner shopping-10">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-10.jpg"/>
    </div>
    <div class="shopping-11">
        <div class="zt-con">
            <!-- <div class="mouseHover mouseHoverPos"></div> -->
            <div class="a1">
                <a href="http://www.g-emall.com/JF/64760.html" class="sub-a1" target="_blank"></a>
            </div>
            <div class="a2">
                <a href="http://www.g-emall.com/JF/151021.html" class="sub-a2" target="_blank"></a>
            </div>
            <div class="a3">
                <a href="http://www.g-emall.com/JF/109131.html" class="sub-a3" target="_blank"></a>
            </div>
            <div class="a4">
                <a href="http://www.g-emall.com/JF/61819.html" class="sub-a4" target="_blank"></a>
            </div>
        </div>
    </div>
</section>
<section class="panel part7" data-section-name="part7">
    <div class="inner shopping-12">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-12.jpg"/>
        <div class="boom1 boom1pos"></div>
        <div class="boom2 boom2pos"></div>
        <div class="boom3 boom3pos"></div>
    </div>
</section>
<section class="panel part8" data-section-name="part8">
    <div class="inner shopping-13">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-13.jpg"/>
    </div>
    <div class="shopping-14">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/112612.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/129225.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/104525.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/54559.html" class="a4" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/66833.html" class="a5" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/136559.html" class="a6" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/150731.html" class="a7" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/106761.html" class="a8" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/111482.html" class="a9" target="_blank"></a>
        </div>
    </div>
    <div class="shopping-15">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/112612.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/129225.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/104525.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/54559.html" class="a4" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/66833.html" class="a5" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/136559.html" class="a6" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/150731.html" class="a7" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/106761.html" class="a8" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/111482.html" class="a9" target="_blank"></a>
        </div>
    </div>
</section>
<section class="panel part9" data-section-name="part9">
    <div class="inner shopping-16">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-16.jpg"/>
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/267287.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/107115.html  " class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/152400.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/84275.html" class="a4" target="_blank"></a>
            <a href="http://www.g-emall.com/goods/198090.html" class="a5" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/103445.html" class="a6" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/144781.html" class="a7" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/242495.html" class="a8" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/266950.html" class="a9" target="_blank"></a>
        </div>
    </div>
</section>
<section class="panel part10" data-section-name="part10">
    <div class="inner shopping-17">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-17.jpg"/>
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/168730.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/40047.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/40579.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/148420.html" class="a4" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/128678.html" class="a5" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/232341.html" class="a6" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/111058.html" class="a7" target="_blank"></a>
        </div>
    </div>
</section>
<section class="panel part11" data-section-name="part11">
    <div class="inner shopping-18">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-18.jpg" class="onScale" />
        <div class="boom1 boom1pos"></div>
        <div class="boom2 boom2pos"></div>
        <div class="boom3 boom3pos"></div>
        <div class="label-04"></div>
    </div>
</section>
<section class="panel part12" data-section-name="part12">
    <div class="inner shopping-19">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-19.jpg" />
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/4478.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/144472.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/goods/152172.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/141825.html" class="a4" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/202041.html" class="a5" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/24456.html" class="a6" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/75654.html" class="a7" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/132126.html" class="a8" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/135417.html" class="a9" target="_blank"></a>
        </div>
    </div>
</section>
<section class="panel part13" data-section-name="part13">
    <div class="inner shopping-20">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-20.jpg" />
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/134228.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/goods/109621.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/212101.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/123385.html" class="a4" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/123157.html" class="a5" target="_blank"></a>
        </div>
    </div>
</section>
<section class="panel part14" data-section-name="part14">
    <div class="inner shopping-21">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-21.jpg" />
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/255524.html" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/202803.html" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/202348.html" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/231681.html" class="a4" target="_blank"></a>
        </div>
    </div>
    <div class="shopping-22">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-22.png" class="onScale" />
        <div class="label-05"></div>
    </div>
</section>
<section class="panel part15" data-section-name="part15">
    <div class="inner shopping-23">
        <img src="<?php echo ATTR_DOMAIN;?>/zt/shopping/shopping-23.jpg" />
        <div class="backToMain">
            <a href="<?php echo DOMAIN;?>">返回商城首页</a>
        </div>
        <div class="zt-con">
            <ul class="wd760">
                <li><a href="http://www.g-emall.com/shop/2766.html" class="a1" target="_blank">金粉世家</a></li>
                <li><a href="http://www.g-emall.com/shop/4124.html" class="a2" target="_blank">盖小象《智能手机数码》</a></li>
                <li><a href="http://www.g-emall.com/shop/2078.html" class="a3" target="_blank">聚通百业</a></li>
                <li><a href="http://www.g-emall.com/shop/2131.html" class="a4" target="_blank">完美世界</a></li>
                <li><a href="http://www.g-emall.com/shop/3074.html" class="a5" target="_blank">利群有机食品旗舰店</a></li>
                <li><a href="http://www.g-emall.com/shop/2793.html" class="a6" target="_blank">果脯屋</a></li>
            </ul>
            <ul class="wd930">
                <li><a href="http://www.g-emall.com/JF/201762.html" class="a1" target="_blank">广州滴答贸易</a></li>
                <li><a href="http://www.g-emall.com/shop/2227.html" class="a2" target="_blank">诺一良品</a></li>
                <li><a href="http://www.g-emall.com/shop/1227.html" class="a3" target="_blank">郴州市汇利电子</a></li>
                <li><a href="http://www.g-emall.com/JF/71826.html" class="a4" target="_blank">龙腾数码</a></li>
                <li><a href="http://www.g-emall.com/shop/91.html" class="a5" target="_blank">金华市畅想企业</a></li>
                <li><a href="http://www.g-emall.com/shop/1229.html" class="a6" target="_blank">三亩花生地</a></li>
                <li><a href="http://www.g-emall.com/JF/109131.html" class="a7" target="_blank">连诚易科技</a></li>
                <li><a href="http://www.g-emall.com/shop/1555.html" class="a8" target="_blank">雅捷服饰</a></li>
            </ul>
            <ul class="wd990">
                <li><a href="http://www.g-emall.com/shop/68.html" class="a1" target="_blank">四川康福瑞贸易有限公司</a></li>
                <li><a href="http://www.g-emall.com/shop/2142.html" class="a2" target="_blank">雨露贸易商行</a></li>
                <li><a href="http://www.g-emall.com/shop/4297.html" class="a3" target="_blank">美励包包馆</a></li>
                <li><a href="http://www.g-emall.com/shop/3442.html" class="a4" target="_blank">八号店</a></li>
                <li><a href="http://www.g-emall.com/shop/2710.html" class="a5" target="_blank">德洋行饰品</a></li>
                <li><a href="http://www.g-emall.com/shop/1179.html" class="a6" target="_blank">梯航运动专营店</a></li>
                <li><a href="http://www.g-emall.com/shop/3051.html" class="a7" target="_blank">卓牧Jomilk羊奶旗舰店</a></li>
            </ul>
            <ul class="wd1030">
                <li><a href="http://www.g-emall.com/shop/517.html" class="a1" target="_blank">周大农家庭农场</a></li>
                <li><a href="http://www.g-emall.com/shop/1965.html" class="a2" target="_blank">唇色食品</a></li>
                <li><a href="http://www.g-emall.com/shop/2878.html" class="a3" target="_blank">皇庭家居生活馆</a></li>
                <li><a href="http://www.g-emall.com/shop/2631.html" class="a4" target="_blank">成都蓝茉花园科技有限公司</a></li>
                <li><a href="http://www.g-emall.com/shop/3626.html" class="a5" target="_blank">吉象食品</a></li>
                <li><a href="http://www.g-emall.com/shop/174.html" class="a6" target="_blank">江西赣花油脂有限公司</a></li>
                <li><a href="http://www.g-emall.com/shop/1147.html" class="a7" target="_blank">得の屋旗舰店</a></li>
            </ul>
            <ul class="wd800">
                <li><a href="http://www.g-emall.com/shop/1489.html" class="a1" target="_blank">景德镇名堂陶瓷</a></li>
                <li><a href="http://www.g-emall.com/shop/2197.html" class="a2" target="_blank">豪马盛妆旗舰店</a></li>
                <li><a href="http://www.g-emall.com/shop/2414.html" class="a3" target="_blank">AVON雅芳品牌店</a></li>
                <li><a href="http://www.g-emall.com/shop/3478.html" class="a4" target="_blank">中山文联灯饰</a></li>
                <li><a href="http://www.g-emall.com/shop/718.html" class="a5" target="_blank">欧希旗舰店</a></li>
                <li><a href="http://www.g-emall.com/shop/7.html" class="a6" target="_blank">梓铖电子</a></li>
            </ul>
        </div>
    </div>
</section>
<div class="sub-nav">
    <ul>
        <li><a class="sub-nav-1" href="#"></a></li>
        <li><a class="sub-nav-2" href="#"></a></li>
        <li><a class="sub-nav-3" href="#"></a></li>
        <li><a class="sub-nav-4" href="#"></a></li>
        <li><a class="sub-nav-5" href="#"></a></li>
        <li><a class="sub-nav-6" href="#"></a></li>
        <li><a class="sub-nav-7" href="#"></a></li>
        <li><a class="sub-nav-8" href="#"></a></li>
        <li><a class="sub-nav-9" href="#"></a></li>
        <li><a class="sub-nav-10" href="#"></a></li>
        <li><a class="sub-nav-11" href="#"></a></li>
        <li><a class="sub-nav-12" href="#"></a></li>
        <li><a class="sub-nav-13" href="#"></a></li>
        <li><a class="sub-nav-14" href="#"></a></li>
        <li><a class="sub-nav-15" href="#"></a></li>
    </ul>
</div>

<script type="text/javascript">
$(function(){
    /*初始化滚动页面*/
    var pageIndex = -1;
    $(".panel").css({"height":($(window).height()+16)});
    $.scrollify({
        section:".panel",
        scrollbars:false
    });
    /*控制页面banner大小*/
    var oWinWid = 1400;
    var oWinHei = $(window).height();
    initWindow();
    function initWindow(){
        if($(window).width()<oWinWid){
            $('.inner>img,.inner').css({'height':oWinHei,'width':oWinWid});
            $('.inner>img').css({'left':-(oWinWid-$(window).width())/2})
            $('.inner .zt-con').css({'left':-(oWinWid-$(window).width())/2});
            $('.shopping-22>img').css({'width':550,'height':550});
        }else{
            $('.inner>img,.inner').css({'height':$(window).height(),'width':$(window).width()});
        }
    }
    $(window).resize(function(){
        initWindow();
    })

    /*右侧导航点击事件*/
    var i = 0;
    var oLen = $('section').length;
    var tar = '';
    for(i=0;i<=oLen;i++){
        $('.sub-nav-'+i).click(function(e) {
            e.preventDefault();
            tar = '#part'+($(this).parent('li').index()+1);
            $.scrollify("move",tar);
        });
    }
    /*点击炮弹跳转事件*/
    $('.boom1,.data-logo1').click(function(e){
        e.preventDefault();
        $.scrollify("move",'#part3');
    })
    $('.boom2,.data-logo2').click(function(e){
        e.preventDefault();
        $.scrollify("move",'#part7');
    })
    $('.boom3,.data-logo3').click(function(e){
        e.preventDefault();
        $.scrollify("move",'#part11');
    })
    /*抽奖转盘*/
    var rotateTimeOut = function (){
        $('#rotate').rotate({
            angle:0,
            animateTo:2160,
            duration:8000,
            callback:function (){
                alert('网络超时，请检查您的网络设置！');
            }
        });
    };
    var bRotate = false;

    var rotateFn = function (awards, angles, txt){
        bRotate = !bRotate;
        $('#rotate').stopRotate();
        $('#rotate').rotate({
            angle:0,
            animateTo:angles+1800,
            duration:2000,
            callback:function (){
                alert(txt);
                bRotate = !bRotate;
            }
        })
    };

    $('.pointer').click(function (){

        if(bRotate)return;
        var now = "<?php echo time()?>";
        if(now > 1489964400){ 
            alert("活动已过期！");
            return;
        }

        isGuest = "<?php echo $this->getUser()->isGuest?>";
        if(isGuest){
            alert("请登录后再抽奖！");
            return;
        }

        $.ajax({
            type:"get",async:false,timeout:5000,dataType:"json",
            url:"<?php echo $this->createAbsoluteUrl("vote/shopping")?>",
            data:{type:"gg"},
            error:function(data){
                console.log(data);
            },
            success:function(data){
                if(data.status == 0){
                    alert(data.msg)
                }
                if(data.status == 1){
                    rotateFn(data.id, data.angle, data.msg);
                }

            }
        })
    });


    /*第一炮*/
    var oTop = 0;
    var onOff = true;
    $('.data-logo1').hover(function(){
        if(onOff){
            onOff=!onOff
            $(this).siblings('div').stop(true,false).slideDown(500);
            $(this).siblings('.lover').show().animate({'top':'46%'},800);
            $(this).siblings('.goods-01').show().animate({'left':'8%','top':'10%'},800);
            $(this).siblings('.goods-02').show().animate({'left':'22%','top':'14%'},800);
            $(this).siblings('.goods-03').show().animate({'left':'18%','top':'2%'},800,function(){onOff=!onOff});
        }
    },function(){
        $(this).siblings('div').stop(true,false).slideUp(500);
        $(this).siblings('.lover').hide().stop(true,false).css({'top':'52%'});
        $(this).siblings('.goods-01,.goods-02,.goods-03').hide().css({'left':'14%','top':'64%'});
    })
    /*第二炮*/
    $('.data-logo2').hover(function(){
        if(onOff){
            onOff=!onOff
            $(this).siblings('div').stop(true,false).slideDown(500);
            $(this).siblings('.lover').show().animate({'top':'52%'},800);
            $(this).siblings('.goods-04').show().animate({'left':'52%','top':'20%'},800);
            $(this).siblings('.goods-05').show().animate({'left':'38%','top':'18%'},800);
            $(this).siblings('.goods-06').show().animate({'left':'50%','top':'2%'},800,function(){onOff=!onOff});
        }
    },function(){
        $(this).siblings('div').stop(true,false).slideUp(500);
        $(this).siblings('.lover').hide().css({'top':'58%'});
        $(this).siblings('.goods-04,.goods-05,.goods-06').hide().css({'left':'46%','top':'68%'});
    })
    /*第三炮*/
    $('.data-logo3').hover(function(){
        if(onOff){
            onOff=!onOff
            $(this).siblings('div').stop(true,false).slideDown(500);
            oTop = parseInt($(this).siblings('.lover').css('top'));
            $(this).siblings('.lover').show().animate({'top':'46%'},800);
            $(this).siblings('.goods-07').show().animate({'left':'70%','top':'16%'},800);
            $(this).siblings('.goods-08').show().animate({'left':'82%','top':'14%'},800);
            $(this).siblings('.goods-09').show().animate({'left':'74%','top':'4%'},800,function(){onOff=!onOff});
        }
    },function(){
        $(this).siblings('div').stop(true,false).slideUp(500);
        $(this).siblings('.lover').hide().css({'top':'52%'});
        $(this).siblings('.goods-07,.goods-08,.goods-09').hide().css({'left':'75%','top':'64%'});
    })

    $('.shopping-03 div').mouseover(function(){
        $(this).children('a').show();
    });
    $('.shopping-03 a').mouseout(function(){
        $(this).hide();
    })
    $('.shopping-07 div').mouseover(function(){
        $(this).children('a').show();
    });
    $('.shopping-07 a').mouseout(function(){
        $(this).hide();
    })

    $('.shopping-09 div').mouseover(function(){
        $(this).children('a').show();
    });
    $('.shopping-09 a').mouseout(function(){
        $(this).hide();
    })

    $('.shopping-11 div').mouseover(function(){
        $(this).children('a').show();
    });
    $('.shopping-11 a').mouseout(function(){
        $(this).hide();
    })
    var oIndex;
    $('.shopping-14 a').mouseover(function(){
        oIndex = $(this).index();
        $('.shopping-15 a').hide();

        $('.shopping-15 a').eq(oIndex).show();
    })
    $('.shopping-15 a').mouseout(function(){
        $(this).hide();
    })
    $('.shopping-16 .zt-con,.shopping-17 .zt-con,.shopping-19 .zt-con,.shopping-20 .zt-con,.shopping-21 .zt-con').css({'height':$(window).height(),'width':$(window).width()})
})
</script>