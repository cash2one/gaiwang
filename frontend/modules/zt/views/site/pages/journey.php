<style tyle="text/css">

    /*=====
     @Date:2016-01-20
     @content:商旅春节活动
     @author:林聪毅
  =====*/
    .zt-wrap{width:100%; background:#fff; overflow: hidden;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .journey-01{height:204px; background:url(<?php echo ATTR_DOMAIN;?>/zt/journey/journey-01.jpg) top center no-repeat;}
    .journey-02{height:204px; background:url(<?php echo ATTR_DOMAIN;?>/zt/journey/journey-02.jpg) top center no-repeat;}
    .journey-03{height:203px; background:url(<?php echo ATTR_DOMAIN;?>/zt/journey/journey-03.jpg) top center no-repeat;}
    .journey-04{height:204px; background:url(<?php echo ATTR_DOMAIN;?>/zt/journey/journey-04.jpg) top center no-repeat;}
    .journey-05{height:825px; background:url(<?php echo ATTR_DOMAIN;?>/zt/journey/journey-05.jpg) top center no-repeat;}
    .journey-06{height:574px; background:url(<?php echo ATTR_DOMAIN;?>/zt/journey/journey-06.jpg) top center no-repeat;}
    .journey-07{height:525px; background:url(<?php echo ATTR_DOMAIN;?>/zt/journey/journey-07.jpg) top center no-repeat;}
    .journey-08{height:839px; background:url(<?php echo ATTR_DOMAIN;?>/zt/journey/journey-08.jpg) top center no-repeat;}
    .journey-09{height:1329px; background:url(<?php echo ATTR_DOMAIN;?>/zt/journey/journey-09.jpg) top center no-repeat;}
    .journey-10{height:338px; background:url(<?php echo ATTR_DOMAIN;?>/zt/journey/journey-10.jpg) top center no-repeat;}

    .journey-05 .cityList-01{width: 479px; height: 70px; position: absolute; left: 450px; top: 100px;}
    .cityList-01 .city{width: 25px; height: 50px; background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/cityList-01.png) no-repeat; top: 0px;}
    .cityList-01 .city.active{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/cityList-01-active.png) no-repeat;}
    .cityList-01 .city:first-child{height: 80px;}
    .cityList-01 .city-01{left: 0px; background-position: 0px 0px;}
    .cityList-01 .city-02{left: 40px; background-position: -40px 0px;}
    .cityList-01 .city-03{left: 80px; background-position: -82px 0px;}
    .cityList-01 .city-04{left: 120px; background-position: -124px 0px;}
    .cityList-01 .city-05{left: 160px; background-position: -166px 0px;}
    .cityList-01 .city-06{left: 200px; background-position: -208px 0px;}
    .cityList-01 .city-07{left: 240px; background-position: -250px 0px;}
    .cityList-01 .city-08{left: 280px; background-position: -290px 0px;}
    .cityList-01 .city-09{left: 320px; background-position: -332px 0px;}
    .cityList-01 .city-10{left: 360px; background-position: -372px 0px;}
    .cityList-01 .city-11{left: 400px; background-position: -414px 0px;}
    .cityList-01 .city-12{left: 440px; background-position: -456px 0px;}
    .journey-05 .hotelList{width: 1190px; height: 466px; position: absolute; left: -112px; top: 304px;}
    .hotelList>a>img{display: none;}
    /*.hotelList-01{display: none;}*/
    .hotelList-01 .pos1City-01{
        width: 230px; height: 466px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/pos1City-01.png) no-repeat;
        position: absolute; left: 0px; top: 0px;
    }
    .hotelList-01 a{width: 304px; height: 215px;}
    .hotelList-01 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel01-01.png) no-repeat; left: 240px; top: 10px;}
    .hotelList-01 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel01-02.png) no-repeat; left: 560px; top: 10px;}
    .hotelList-01 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel01-03.png) no-repeat; left: 880px; top: 10px;}
    .hotelList-01 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel01-04.png) no-repeat; left: 240px; top: 250px;}
    .hotelList-01 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel01-05.png) no-repeat; left: 560px; top: 250px;}
    .hotelList-01 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel01-06.png) no-repeat; left: 880px; top: 250px;}
    .hotelList-02{display: none;}
    .hotelList-02 .pos1City-02{
        width: 230px; height: 466px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/pos1City-02.png) no-repeat;
        position: absolute; left: 0px; top: 0px;
    }
    .hotelList-02 a{width: 304px; height: 215px;}
    .hotelList-02 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel02-01.png) no-repeat; left: 240px; top: 10px;}
    .hotelList-02 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel02-02.png) no-repeat; left: 560px; top: 10px;}
    .hotelList-02 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel02-03.png) no-repeat; left: 880px; top: 10px;}
    .hotelList-02 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel02-04.png) no-repeat; left: 240px; top: 250px;}
    .hotelList-02 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel02-05.png) no-repeat; left: 560px; top: 250px;}
    .hotelList-02 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel02-06.png) no-repeat; left: 880px; top: 250px;}
    .hotelList-03{display: none;}
    .hotelList-03 .pos1City-03{
        width: 230px; height: 466px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/pos1City-03.png) no-repeat;
        position: absolute; left: 0px; top: 0px;
    }
    .hotelList-03 a{width: 304px; height: 215px;}
    .hotelList-03 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel03-01.png) no-repeat; left: 240px; top: 10px;}
    .hotelList-03 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel03-02.png) no-repeat; left: 560px; top: 10px;}
    .hotelList-03 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel03-03.png) no-repeat; left: 880px; top: 10px;}
    .hotelList-03 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel03-04.png) no-repeat; left: 240px; top: 250px;}
    .hotelList-03 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel03-05.png) no-repeat; left: 560px; top: 250px;}
    .hotelList-03 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel03-06.png) no-repeat; left: 880px; top: 250px;}
    .hotelList-04{display: none;}
    .hotelList-04 .pos1City-04{
        width: 230px; height: 466px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/pos1City-04.png) no-repeat;
        position: absolute; left: 0px; top: 0px;
    }
    .hotelList-04 a{width: 304px; height: 215px;}
    .hotelList-04 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel04-01.png) no-repeat; left: 240px; top: 10px;}
    .hotelList-04 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel04-02.png) no-repeat; left: 560px; top: 10px;}
    .hotelList-04 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel04-03.png) no-repeat; left: 880px; top: 10px;}
    .hotelList-04 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel04-04.png) no-repeat; left: 240px; top: 250px;}
    .hotelList-04 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel04-05.png) no-repeat; left: 560px; top: 250px;}
    .hotelList-04 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel04-06.png) no-repeat; left: 880px; top: 250px;}
    .hotelList-05{display: none;}
    .hotelList-05 .pos1City-05{
        width: 230px; height: 466px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/pos1City-05.png) no-repeat;
        position: absolute; left: 0px; top: 0px;
    }
    .hotelList-05 a{width: 304px; height: 215px;}
    .hotelList-05 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel05-01.png) no-repeat; left: 240px; top: 10px;}
    .hotelList-05 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel05-02.png) no-repeat; left: 560px; top: 10px;}
    .hotelList-05 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel05-03.png) no-repeat; left: 880px; top: 10px;}
    .hotelList-05 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel05-04.png) no-repeat; left: 240px; top: 250px;}
    .hotelList-05 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel05-05.png) no-repeat; left: 560px; top: 250px;}
    .hotelList-05 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel05-06.png) no-repeat; left: 880px; top: 250px;}
    .hotelList-06{display: none;}
    .hotelList-06 .pos1City-06{
        width: 230px; height: 466px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/pos1City-06.png) no-repeat;
        position: absolute; left: 0px; top: 0px;
    }
    .hotelList-06 a{width: 304px; height: 215px;}
    .hotelList-06 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel06-01.png) no-repeat; left: 240px; top: 10px;}
    .hotelList-06 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel06-02.png) no-repeat; left: 560px; top: 10px;}
    .hotelList-06 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel06-03.png) no-repeat; left: 880px; top: 10px;}
    .hotelList-06 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel06-04.png) no-repeat; left: 240px; top: 250px;}
    .hotelList-06 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel06-05.png) no-repeat; left: 560px; top: 250px;}
    .hotelList-06 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel06-06.png) no-repeat; left: 880px; top: 250px;}
    .hotelList-07{display: none;}
    .hotelList-07 .pos1City-07{
        width: 230px; height: 466px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/pos1City-07.png) no-repeat;
        position: absolute; left: 0px; top: 0px;
    }
    .hotelList-07 a{width: 304px; height: 215px;}
    .hotelList-07 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel07-01.png) no-repeat; left: 240px; top: 10px;}
    .hotelList-07 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel07-02.png) no-repeat; left: 560px; top: 10px;}
    .hotelList-07 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel07-03.png) no-repeat; left: 880px; top: 10px;}
    .hotelList-07 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel07-04.png) no-repeat; left: 240px; top: 250px;}
    .hotelList-07 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel07-05.png) no-repeat; left: 560px; top: 250px;}
    .hotelList-07 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel07-06.png) no-repeat; left: 880px; top: 250px;}
    .hotelList-08{display: none;}
    .hotelList-08 .pos1City-08{
        width: 230px; height: 466px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/pos1City-08.png) no-repeat;
        position: absolute; left: 0px; top: 0px;
    }
    .hotelList-08 a{width: 304px; height: 215px;}
    .hotelList-08 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel08-01.png) no-repeat; left: 240px; top: 10px;}
    .hotelList-08 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel08-02.png) no-repeat; left: 560px; top: 10px;}
    .hotelList-08 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel08-03.png) no-repeat; left: 880px; top: 10px;}
    .hotelList-08 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel08-04.png) no-repeat; left: 240px; top: 250px;}
    .hotelList-08 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel08-05.png) no-repeat; left: 560px; top: 250px;}
    .hotelList-08 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel08-06.png) no-repeat; left: 880px; top: 250px;}
    .hotelList-09{display: none;}
    .hotelList-09 .pos1City-09{
        width: 230px; height: 466px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/pos1City-09.png) no-repeat;
        position: absolute; left: 0px; top: 0px;
    }
    .hotelList-09 a{width: 304px; height: 215px;}
    .hotelList-09 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel09-01.png) no-repeat; left: 240px; top: 10px;}
    .hotelList-09 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel09-02.png) no-repeat; left: 560px; top: 10px;}
    .hotelList-09 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel09-03.png) no-repeat; left: 880px; top: 10px;}
    .hotelList-09 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel09-04.png) no-repeat; left: 240px; top: 250px;}
    .hotelList-09 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel09-05.png) no-repeat; left: 560px; top: 250px;}
    .hotelList-09 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel09-06.png) no-repeat; left: 880px; top: 250px;}
    .hotelList-10{display: none;}
    .hotelList-10 .pos1City-10{
        width: 230px; height: 466px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/pos1City-10.png) no-repeat;
        position: absolute; left: 0px; top: 0px;
    }
    .hotelList-10 a{width: 304px; height: 215px;}
    .hotelList-10 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel10-01.png) no-repeat; left: 240px; top: 10px;}
    .hotelList-10 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel10-02.png) no-repeat; left: 560px; top: 10px;}
    .hotelList-10 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel10-03.png) no-repeat; left: 880px; top: 10px;}
    .hotelList-10 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel10-04.png) no-repeat; left: 240px; top: 250px;}
    .hotelList-10 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel10-05.png) no-repeat; left: 560px; top: 250px;}
    .hotelList-10 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel10-06.png) no-repeat; left: 880px; top: 250px;}
    .hotelList-11{display: none;}
    .hotelList-11 .pos1City-11{
        width: 230px; height: 466px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/pos1City-11.png) no-repeat;
        position: absolute; left: 0px; top: 0px;
    }
    .hotelList-11 a{width: 304px; height: 215px;}
    .hotelList-11 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel11-01.png) no-repeat; left: 240px; top: 10px;}
    .hotelList-11 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel11-02.png) no-repeat; left: 560px; top: 10px;}
    .hotelList-11 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel11-03.png) no-repeat; left: 880px; top: 10px;}
    .hotelList-11 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel11-04.png) no-repeat; left: 240px; top: 250px;}
    .hotelList-11 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel11-05.png) no-repeat; left: 560px; top: 250px;}
    .hotelList-11 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel11-06.png) no-repeat; left: 880px; top: 250px;}
    .hotelList-12{display: none;}
    .hotelList-12 .pos1City-12{
        width: 230px; height: 466px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/pos1City-12.png) no-repeat;
        position: absolute; left: 0px; top: 0px;
    }
    .hotelList-12 a{width: 304px; height: 215px;}
    .hotelList-12 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel12-01.png) no-repeat; left: 240px; top: 10px;}
    .hotelList-12 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel12-02.png) no-repeat; left: 560px; top: 10px;}
    .hotelList-12 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel12-03.png) no-repeat; left: 880px; top: 10px;}
    .hotelList-12 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel12-04.png) no-repeat; left: 240px; top: 250px;}
    .hotelList-12 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel12-05.png) no-repeat; left: 560px; top: 250px;}
    .hotelList-12 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/hotel12-06.png) no-repeat; left: 880px; top: 250px;}
    .fixedbg-01{
        height: 700px; background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/fixedbg-01.jpg) fixed top center no-repeat;
    }
    .journey-06 .ygfq{
        width: 225px; height: 82px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/ygfq.png) no-repeat;
        position: absolute; left: 220px; top: 130px; cursor: pointer;
    }
    .journey-06 .ygfq.active{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/ygfq-active.png) no-repeat;}
    .journey-06 .btfq{
        width: 225px; height: 82px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/btfq.png) no-repeat;
        position: absolute; left: 510px; top: 130px; cursor: pointer;
    }
    .journey-06 .btfq.active{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/btfq-active.png) no-repeat;}
    .journey-06 .travelList{width: 1200px; position: absolute; left: -110px; top: 290px;}
    .journey-06	.travelList-01{}
    .travelList img{position: absolute; left: 2px; top: 2px; display: none;}
    .travelList li{width: 182px; height: 253px; float: left; margin-right: 15px;}
    .travelList li a{width: 182px; height: 253px;}
    .travelList-01{display: -none;}
    .travelList-02{display: none;}
    .travelList-01 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/travel01-01.png) no-repeat;}
    .travelList-01 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/travel01-02.png) no-repeat;}
    .travelList-01 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/travel01-03.png) no-repeat;}
    .travelList-01 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/travel01-04.png) no-repeat;}
    .travelList-01 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/travel01-05.png) no-repeat;}
    .travelList-01 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/travel01-06.png) no-repeat;}
    .travelList-02 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/travel02-01.png) no-repeat;}
    .travelList-02 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/travel02-02.png) no-repeat;}
    .travelList-02 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/travel02-03.png) no-repeat;}
    .travelList-02 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/travel02-04.png) no-repeat;}
    .travelList-02 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/travel02-05.png) no-repeat;}
    .travelList-02 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/travel02-06.png) no-repeat;}

    .fixedbg-02{
        height: 700px; background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/fixedbg-02.jpg) fixed top center no-repeat;
    }
    .journey-07 .contactUs{
        width: 62px; height: 62px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/contactUs.png) no-repeat;
        position: absolute; left: 450px; top: 305px;
    }
    .contactUs{
        animation:onScale 2s linear infinite;
        -webkit-animation:onScale 2s linear infinite;
        -moz-animation:onScale 2s linear infinite;
        -o-animation:onScale 2s linear infinite;
    }
    @-webkit-keyframes onScale{
        0% 	{-webkit-transform: scale(1);}
        50% {-webkit-transform: scale(0.8);}
        100% {-webkit-transform: scale(1);}
    }
    @-moz-keyframes onScale{
        0% 	{-moz-transform: scale(1);}
        50% {-moz-transform: scale(0.8);}
        100% {-moz-transform: scale(1);}
    }
    @keyframes onScale{
        0% 	{transform: scale(1);}
        50% {transform: scale(0.8);}
        100% {transform: scale(1);}
    }
    @-o-keyframes onScale{
        0% 	{-o-transform: scale(1);}
        50% {-o-transform: scale(0.8);}
        100% {-o-transform: scale(1);}
    }


    .fixedbg-03{
        height: 700px; background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/fixedbg-03.jpg) fixed top center no-repeat;
    }
    .journey-08 .restaurantCityList{width: 1033px; height: 102px; position: absolute; left: -40px; top: 198px;}
    .restaurantCityList .city{width: 54px; height: 72px; background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/cityList-02.png) no-repeat;}
    .restaurantCityList .city.active{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/cityList-02-active.png) no-repeat;}
    .restaurantCityList .city-01{left: 0px; top: 28px; background-position: 0px -28px;}
    .restaurantCityList .city-02{left: 80px; top: 28px; background-position: -80px -28px;}
    .restaurantCityList .city-03{left: 168px; top: 28px; background-position: -168px -28px;}
    .restaurantCityList .city-04{left: 262px; top: 24px; background-position: -262px -24px;}
    .restaurantCityList .city-05{left: 364px; top: 18px; background-position: -364px -18px;}
    .restaurantCityList .city-06{left: 446px; top: 12px; background-position: -446px -12px;}
    .restaurantCityList .city-07{left: 526px; top: 4px; background-position: -526px -4px;}
    .restaurantCityList .city-08{left: 614px; top: 0px; background-position: -614px 0px;}
    .restaurantCityList .city-09{left: 702px; top: 0px; background-position: -702px 0px;}
    .restaurantCityList .city-10{left: 792px; top: 2px; background-position: -792px -2px;}
    .restaurantCityList .city-11{left: 892px; top: 8px; background-position: -892px -8px;}
    .restaurantCityList .city-12{left: 980px; top: 16px; background-position: -980px -16px;}
    .journey-08 .restaurantList{width: 1190px; height: 450px; position: absolute; left: -110px; top: 350px;}
    .restaurantList a{width: 382px; height: 216px; position: static; float: left; margin: 6px 6px;}
    /* .journey-08 .restaurantList-01{display: none;} */
    .restaurantList-01 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant01-01.png) no-repeat;}
    .restaurantList-01 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant01-02.png) no-repeat;}
    .restaurantList-01 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant01-03.png) no-repeat;}
    .restaurantList-01 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant01-04.png) no-repeat;}
    .restaurantList-01 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant01-05.png) no-repeat;}
    .restaurantList-01 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant01-06.png) no-repeat;}
    .journey-08 .restaurantList-02{display: none;}
    .restaurantList-02 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant02-01.png) no-repeat;}
    .restaurantList-02 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant02-02.png) no-repeat;}
    .restaurantList-02 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant02-03.png) no-repeat;}
    .restaurantList-02 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant02-04.png) no-repeat;}
    .restaurantList-02 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant02-05.png) no-repeat;}
    .restaurantList-02 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant02-06.png) no-repeat;}
    .journey-08 .restaurantList-03{display: none;}
    .restaurantList-03 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant03-01.png) no-repeat;}
    .restaurantList-03 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant03-02.png) no-repeat;}
    .restaurantList-03 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant03-03.png) no-repeat;}
    .restaurantList-03 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant03-04.png) no-repeat;}
    .restaurantList-03 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant03-05.png) no-repeat;}
    .restaurantList-03 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant03-06.png) no-repeat;}
    .journey-08 .restaurantList-04{display: none;}
    .restaurantList-04 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant04-01.png) no-repeat;}
    .restaurantList-04 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant04-02.png) no-repeat;}
    .restaurantList-04 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant04-03.png) no-repeat;}
    .journey-08 .restaurantList-05{display: none;}
    .restaurantList-05 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant05-01.png) no-repeat;}
    .restaurantList-05 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant05-02.png) no-repeat;}
    .restaurantList-05 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant05-03.png) no-repeat;}
    .restaurantList-05 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant05-04.png) no-repeat;}
    .restaurantList-05 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant05-05.png) no-repeat;}
    .restaurantList-05 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant05-06.png) no-repeat;}
    .journey-08 .restaurantList-06{display: none;}
    .restaurantList-06 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant06-01.png) no-repeat;}
    .restaurantList-06 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant06-02.png) no-repeat;}
    .restaurantList-06 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant06-03.png) no-repeat;}
    .restaurantList-06 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant06-04.png) no-repeat;}
    .restaurantList-06 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant06-05.png) no-repeat;}
    .restaurantList-06 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant06-06.png) no-repeat;}
    .journey-08 .restaurantList-07{display: none;}
    .restaurantList-07 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant07-01.png) no-repeat;}
    .restaurantList-07 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant07-02.png) no-repeat;}
    .restaurantList-07 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant07-03.png) no-repeat;}
    .restaurantList-07 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant07-04.png) no-repeat;}
    .restaurantList-07 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant07-05.png) no-repeat;}
    .restaurantList-07 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant07-06.png) no-repeat;}
    .journey-08 .restaurantList-08{display: none;}
    .restaurantList-08 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant08-01.png) no-repeat;}
    .restaurantList-08 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant08-02.png) no-repeat;}
    .restaurantList-08 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant08-03.png) no-repeat;}
    .restaurantList-08 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant08-04.png) no-repeat;}
    .restaurantList-08 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant08-05.png) no-repeat;}
    .restaurantList-08 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant08-06.png) no-repeat;}
    .journey-08 .restaurantList-09{display: none;}
    .restaurantList-09 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant09-01.png) no-repeat;}
    .restaurantList-09 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant09-02.png) no-repeat;}
    .restaurantList-09 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant09-03.png) no-repeat;}
    .restaurantList-09 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant09-04.png) no-repeat;}
    .restaurantList-09 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant09-05.png) no-repeat;}
    .restaurantList-09 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant09-06.png) no-repeat;}
    .journey-08 .restaurantList-10{display: none;}
    .restaurantList-10 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant10-01.png) no-repeat;}
    .restaurantList-10 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant10-02.png) no-repeat;}
    .restaurantList-10 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant10-03.png) no-repeat;}
    .restaurantList-10 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant10-04.png) no-repeat;}
    .restaurantList-10 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant10-05.png) no-repeat;}
    .restaurantList-10 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant10-06.png) no-repeat;}
    .journey-08 .restaurantList-11{display: none;}
    .restaurantList-11 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant11-01.png) no-repeat;}
    .restaurantList-11 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant11-02.png) no-repeat;}
    .restaurantList-11 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant11-03.png) no-repeat;}
    .restaurantList-11 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant11-04.png) no-repeat;}
    .restaurantList-11 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant11-05.png) no-repeat;}
    .restaurantList-11 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant11-06.png) no-repeat;}
    .journey-08 .restaurantList-12{display: none;}
    .restaurantList-12 .a1{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant12-01.png) no-repeat;}
    .restaurantList-12 .a2{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant12-02.png) no-repeat;}
    .restaurantList-12 .a3{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant12-03.png) no-repeat;}
    .restaurantList-12 .a4{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant12-04.png) no-repeat;}
    .restaurantList-12 .a5{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant12-05.png) no-repeat;}
    .restaurantList-12 .a6{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/restaurant12-06.png) no-repeat;}
    .journey-09 .ls-btngroup{width: 360px; height: 41px; position: absolute; left: 670px; top: 180px;}
    .ls-btngroup>div{width: 150px; height: 41px; cursor: pointer;}
    .ls-btngroup .gwls{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/gwls.png); float: left;}
    .ls-btngroup .gwls.active{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/gwls-active.png);}
    .ls-btngroup .gnls{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/gnls.png); float: right;}
    .ls-btngroup .gnls.active{background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/gnls-active.png);}
    .journey-09 .snacksList{width: 1180px; height: 1200px; position: absolute; left: -100px; top: 250px;}
    .snacksList ul:last-child{display: none;}
    .snacksList li{position: relative; margin-bottom: 20px;}
    .snacksList li:last-child{margin-bottom: 0px;}
    .snacksList li a{width: 216px; height: 254px; border: 2px solid #c9e0e7;}
    .snacksList li a:hover{border-color: #ff9419;}
    .snacksList .snacksList01-01{width: 1176px; height: 254px; background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/snacks01-01.png) no-repeat;}
    .snacksList01-01 a{top: 0px;}
    .snacksList01-01 .a1{left: 0px;}
    .snacksList01-01 .a2{left: 239px;}
    .snacksList01-01 .a3{left: 478px;}
    .snacksList01-01 .a4{left: 717px;}
    .snacksList01-01 .a5{left: 956px;}
    .snacksList .snacksList01-02{width: 1176px; height: 254px; background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/snacks01-02.png) no-repeat;}
    .snacksList01-02 a{top: 0px;}
    .snacksList01-02 .a1{left: 0px;}
    .snacksList01-02 .a2{left: 239px;}
    .snacksList01-02 .a3{left: 478px;}
    .snacksList01-02 .a4{left: 717px;}
    .snacksList01-02 .a5{left: 956px;}
    .snacksList .snacksList01-03{width: 1176px; height: 254px; background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/snacks01-03.png) no-repeat;}
    .snacksList01-03 a{top: 0px;}
    .snacksList01-03 .a1{left: 0px;}
    .snacksList01-03 .a2{left: 239px;}
    .snacksList01-03 .a3{left: 478px;}
    .snacksList01-03 .a4{left: 717px;}
    .snacksList01-03 .a5{left: 956px;}
    .snacksList .snacksList01-04{width: 1176px; height: 254px; background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/snacks01-04.png) no-repeat;}
    .snacksList01-04 a{top: 0px;}
    .snacksList01-04 .a1{left: 0px;}
    .snacksList01-04 .a2{left: 239px;}
    .snacksList01-04 .a3{left: 478px;}
    .snacksList01-04 .a4{left: 717px;}
    .snacksList01-04 .a5{left: 956px;}
    .snacksList .snacksList02-01{width: 1176px; height: 254px; background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/snacks02-01.png) no-repeat;}
    .snacksList02-01 a{top: 0px;}
    .snacksList02-01 .a1{left: 0px;}
    .snacksList02-01 .a2{left: 239px;}
    .snacksList02-01 .a3{left: 478px;}
    .snacksList02-01 .a4{left: 717px;}
    .snacksList02-01 .a5{left: 956px;}
    .snacksList .snacksList02-02{width: 1176px; height: 254px; background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/snacks02-02.png) no-repeat;}
    .snacksList02-02 a{top: 0px;}
    .snacksList02-02 .a1{left: 0px;}
    .snacksList02-02 .a2{left: 239px;}
    .snacksList02-02 .a3{left: 478px;}
    .snacksList02-02 .a4{left: 717px;}
    .snacksList02-02 .a5{left: 956px;}
    .snacksList .snacksList02-03{width: 1176px; height: 254px; background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/snacks02-03.png) no-repeat;}
    .snacksList02-03 a{top: 0px;}
    .snacksList02-03 .a1{left: 0px;}
    .snacksList02-03 .a2{left: 239px;}
    .snacksList02-03 .a3{left: 478px;}
    .snacksList02-03 .a4{left: 717px;}
    .snacksList02-03 .a5{left: 956px;}
    .snacksList .snacksList02-04{width: 1176px; height: 254px; background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/snacks02-04.png) no-repeat;}
    .snacksList02-04 a{top: 2px;}
    .snacksList02-04 .a1{left: 0px;}
    .snacksList02-04 .a2{left: 239px;}
    .snacksList02-04 .a3{left: 478px;}
    .snacksList02-04 .a4{left: 717px;}
    .snacksList02-04 .a5{left: 956px;}

    .fixedbg-04{
        height: 700px; background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/fixedbg-04.jpg) fixed top center no-repeat;
    }
    .journey-10 .backToTop{width: 200px; height: 50px; left: 384px; top: 218px;}
    .navRight{
        width: 208px; height: 235px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/journey/navRight.png) no-repeat;
        position: fixed; left: 80%; top: 20%; opacity: 0.5;
    }
    .navRight:hover{opacity: 1;}
    .navRight a{display: inline-block; position: absolute; left: 60px; font-family:'微软雅黑'; font-size: 20px;}
    .navRight .a1{top: 54px; color: #fff;}
    .navRight .a2{top: 90px; color: #288b81;}
    .navRight .a3{top: 126px; color: #fff;}
    .navRight .a4{top: 162px; color: #288b81;}
</style>
<div class="zt-wrap">
    <div class="journey-01"></div>
    <div class="journey-02"></div>
    <div class="journey-03"></div>
    <div class="journey-04"></div>
    <div class="journey-05" id="part1">
        <div class="zt-con">
            <div class="cityList-01">
                <a href="javascript:void(0)" class="city city-01 active"></a>
                <a href="javascript:void(0)" class="city city-02"></a>
                <a href="javascript:void(0)" class="city city-03"></a>
                <a href="javascript:void(0)" class="city city-04"></a>
                <a href="javascript:void(0)" class="city city-05"></a>
                <a href="javascript:void(0)" class="city city-06"></a>
                <a href="javascript:void(0)" class="city city-07"></a>
                <a href="javascript:void(0)" class="city city-08"></a>
                <a href="javascript:void(0)" class="city city-09"></a>
                <a href="javascript:void(0)" class="city city-10"></a>
                <a href="javascript:void(0)" class="city city-11"></a>
                <a href="javascript:void(0)" class="city city-12"></a>
            </div>
            <div class="hotelList hotelList-01">
                <div class="pos1City-01"></div>                
                <a href="http://hotel.bitgaiwang.com/site/view/632" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-01.png"/></a>
                <a href="http://hotel.bitgaiwang.com/site/view/1313" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-02.png"/></a>
                <a href="http://hotel.bitgaiwang.com/site/view/627" class="a3" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-01.png"/></a>
                <a href="http://hotel.bitgaiwang.com/site/view/638" class="a4" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-01.png"/></a>
                <a href="http://hotel.bitgaiwang.com/site/view/636" class="a5" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-01.png"/></a>
                <a href="http://hotel.bitgaiwang.com/site/view/1425" class="a6" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-01.png"/></a>
                
            </div>
            <div class="hotelList hotelList-02">
                <div class="pos1City-02"></div>
                <a href="http://hotel.bitgaiwang.com/site/view/301" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-03.png"/></a>
                <a href="http://hotel.bitgaiwang.com/site/view/700" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-03.png"/></a>
                <a href="http://hotel.bitgaiwang.com/site/view/813" class="a3" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-04.png"/></a>
                <a href="http://hotel.bitgaiwang.com/site/view/950" class="a4" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-05.png"/></a>
                <a href="http://hotel.bitgaiwang.com/site/view/622" class="a5" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-03.png"/></a>
                <a href="http://hotel.bitgaiwang.com/site/view/1433" class="a6" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-03.png"/></a>
            </div>
            <div class="hotelList hotelList-03">
                <div class="pos1City-03"></div>
                <a href="http://hotel.bitgaiwang.com/site/view/1428" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-03.png"/></a>
                <a href="http://hotel.bitgaiwang.com/site/view/1427" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-06.png"/></a>
                <a href="http://hotel.bitgaiwang.com/site/view/1298" class="a3" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-07.png"/></a>
                <a href="http://hotel.bitgaiwang.com/site/view/63" class="a4" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/39" class="a5" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/52" class="a6" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-08.png"/></a>
            </div>
            <div class="hotelList hotelList-04">
                <div class="pos1City-04"></div>
                <a href="http://hotel.bitgaiwang.com/site/view/258" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-09.png"/></a>
                <a href="http://hotel.bitgaiwang.com/site/view/925" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-10.png"/></a>
                <a href="http://hotel.bitgaiwang.com/site/view/924" class="a3" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/118.html" class="a4" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/912.html" class="a5" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/460.html" class="a6" target="_blank"></a>
            </div>
            <div class="hotelList hotelList-05">
                <div class="pos1City-05"></div>
                <a href="http://hotel.bitgaiwang.com/site/view/606" class="a1" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/1027" class="a2" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/13" class="a3" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/285" class="a4" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/111" class="a5" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/1424" class="a6" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/hotelInfo-11.png"/></a>
            </div>
            <div class="hotelList hotelList-06">
                <div class="pos1City-06"></div>
                <a href="http://hotel.bitgaiwang.com/site/view/3" class="a1" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/537" class="a2" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/366" class="a3" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/367" class="a4" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/114" class="a5" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/951" class="a6" target="_blank"></a>
            </div>
            <div class="hotelList hotelList-07">
                <div class="pos1City-07"></div>
                <a href="http://hotel.bitgaiwang.com/site/view/832" class="a1" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/1300" class="a2" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/1311" class="a3" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/731" class="a4" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/1249" class="a5" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/993" class="a6" target="_blank"></a>
            </div>
            <div class="hotelList hotelList-08">
                <div class="pos1City-08"></div>
                <a href="http://hotel.bitgaiwang.com/site/view/602" class="a1" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/335" class="a2" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/381" class="a3" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/642" class="a4" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/896" class="a5" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/1174" class="a6" target="_blank"></a>
            </div>
            <div class="hotelList hotelList-09">
                <div class="pos1City-09"></div>
                <a href="http://hotel.bitgaiwang.com/site/view/212" class="a1" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/293" class="a2" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/825" class="a3" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/379" class="a4" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/232" class="a5" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/488" class="a6" target="_blank"></a>
            </div>
            <div class="hotelList hotelList-10">
                <div class="pos1City-10"></div>
                <a href="http://hotel.bitgaiwang.com/site/view/890" class="a1" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/184" class="a2" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/185" class="a3" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/38" class="a4" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/43" class="a5" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/1133.html" class="a6" target="_blank"></a>
            </div>
            <div class="hotelList hotelList-11">
                <div class="pos1City-11"></div>
                <a href="http://hotel.bitgaiwang.com/site/view/281" class="a1" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/1325" class="a2" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/814" class="a3" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/93" class="a4" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/349" class="a5" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/350" class="a6" target="_blank"></a>
            </div>
            <div class="hotelList hotelList-12">
                <div class="pos1City-12"></div>
                <a href="http://hotel.bitgaiwang.com/site/view/92" class="a1" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/891" class="a2" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/1171" class="a3" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/647" class="a4" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/157" class="a5" target="_blank"></a>
                <a href="http://hotel.bitgaiwang.com/site/view/467" class="a6" target="_blank"></a>
            </div>
        </div>
    </div>
    <div class="fixedbg-01"></div>
    <div class="journey-06" id="part2">
        <div class="zt-con">
            <div class="ygfq active"></div>
            <div class="btfq"></div>
            <ul class="travelList travelList-01">
                <li>
                    <a href="http://www.bitgaiwang.com/JF/258196.html" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/ygfqInfo-01.png"/></a>
                </li>
                <li>
                    <a href="http://www.bitgaiwang.com/JF/400821.html" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/ygfqInfo-02.png"/></a>
                </li>
                <li>
                    <a href="http://www.bitgaiwang.com/JF/188740.html" class="a3" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/ygfqInfo-03.png"/></a>
                </li>
                <li>
                    <a href="http://www.bitgaiwang.com/JF/237005.html" class="a4" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/ygfqInfo-04.png"/></a>
                </li>
                <li>
                    <a href="http://www.bitgaiwang.com/JF/278509.html" class="a5" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/ygfqInfo-05.png"/></a>
                </li>
                <li>
                    <a href="http://www.bitgaiwang.com/JF/257984.html" class="a6" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/ygfqInfo-06.png"/></a>
                </li>
            </ul>
            <ul class="travelList travelList-02">
                <li>
                    <a href="http://www.bitgaiwang.com/JF/324329.html" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/btfqInfo-01.png"/></a>
                </li>
                <li>
                    <a href="http://www.bitgaiwang.com/JF/115619.html" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/btfqInfo-02.png"/></a>
                </li>
                <li>
                    <a href="http://www.bitgaiwang.com/JF/193266.html" class="a3" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/btfqInfo-03.png"/></a>
                </li>
                <li>
                    <a href="http://www.bitgaiwang.com/JF/334479.html" class="a4" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/btfqInfo-04.png"/></a>
                </li>
                <li>
                    <a href="http://www.bitgaiwang.com/JF/207311.html" class="a5" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/btfqInfo-05.png"/></a>
                </li>
                <li>
                    <a href="http://www.bitgaiwang.com/JF/207290.html" class="a6" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/journey/btfqInfo-06.png"/></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="fixedbg-02"></div>
    <div class="journey-07">
        <div class="zt-con">
            <div class="contactUs"></div>
        </div>
    </div>
    <div class="fixedbg-03"></div>
    <div class="journey-08" id="part3">
        <div class="zt-con">
            <div class="restaurantCityList">
                <a href="javascript:void(0)" class="city city-01"></a>
                <a href="javascript:void(0)" class="city city-02"></a>
                <a href="javascript:void(0)" class="city city-03"></a>
                <a href="javascript:void(0)" class="city city-04"></a>
                <a href="javascript:void(0)" class="city city-05"></a>
                <a href="javascript:void(0)" class="city city-06"></a>
                <a href="javascript:void(0)" class="city city-07"></a>
                <a href="javascript:void(0)" class="city city-08"></a>
                <a href="javascript:void(0)" class="city city-09"></a>
                <a href="javascript:void(0)" class="city city-10"></a>
                <a href="javascript:void(0)" class="city city-11"></a>
                <a href="javascript:void(0)" class="city city-12"></a>
            </div>
            <div class="restaurantList restaurantList-01">
                <a href="http://jms.bitgaiwang.com/5867.html" class="a1" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/8685.html" class="a2" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/7713.html" class="a3" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/12350.html" class="a4" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/12349.html" class="a5" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/8392.html" class="a6" target="_blank"></a>
            </div>
            <div class="restaurantList restaurantList-02">
                <a href="http://jms.bitgaiwang.com/9651.html" class="a1" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/6974.html" class="a2" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/3095.html" class="a3" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/732.html" class="a4" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/3502.html" class="a5" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/6455.html" class="a6" target="_blank"></a>
            </div>
            <div class="restaurantList restaurantList-03">
                <a href="http://jms.bitgaiwang.com/10703.html" class="a1" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/10702.html" class="a2" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/9673.html" class="a3" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/9461.html" class="a4" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/9289.html" class="a5" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/8107.html" class="a6" target="_blank"></a>
            </div>
            <div class="restaurantList restaurantList-04">
                <a href="http://jms.bitgaiwang.com/1775.html" class="a1" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/2940.html" class="a2" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/633.html" class="a3" target="_blank"></a>
            </div>
            <div class="restaurantList restaurantList-05">
                <a href="http://jms.bitgaiwang.com/1340.html" class="a1" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/763.html" class="a2" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/1113.html" class="a3" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/1445.html" class="a4" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/1410.html" class="a5" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/1749.html" class="a6" target="_blank"></a>
            </div>
            <div class="restaurantList restaurantList-06">
                <a href="http://jms.bitgaiwang.com/10934.html" class="a1" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/10613.html" class="a2" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/9795.html" class="a3" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/9639.html" class="a4" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/4316.html" class="a5" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/575.html" class="a6" target="_blank"></a>
            </div>
            <div class="restaurantList restaurantList-07">
                <a href="http://jms.bitgaiwang.com/7553.html" class="a1" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/7313.html" class="a2" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/1379.html" class="a3" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/8091.html" class="a4" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/7554.html" class="a5" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/7315.html" class="a6" target="_blank"></a>
            </div>
            <div class="restaurantList restaurantList-08">
                <a href="http://jms.bitgaiwang.com/9304.html" class="a1" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/9302.html" class="a2" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/7839.html" class="a3" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/7724.html" class="a4" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/7163.html" class="a5" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/3758.html" class="a6" target="_blank"></a>
            </div>
            <div class="restaurantList restaurantList-09">
                <a href="http://jms.bitgaiwang.com/8316.html" class="a1" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/1531.html" class="a2" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/550.html" class="a3" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/383.html" class="a4" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/6538.html" class="a5" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/5350.html" class="a6" target="_blank"></a>
            </div>
            <div class="restaurantList restaurantList-10">
                <a href="http://jms.bitgaiwang.com/8992.html" class="a1" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/8307.html" class="a2" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/8994.html" class="a3" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/6113.html" class="a4" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/382.html" class="a5" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/1708.html" class="a6" target="_blank"></a>
            </div>
            <div class="restaurantList restaurantList-11">
                <a href="http://jms.bitgaiwang.com/3631.html" class="a1" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/3630.html" class="a2" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/3209.html" class="a3" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/3069.html" class="a4" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/2950.html" class="a5" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/1830.html" class="a6" target="_blank"></a>
            </div>
            <div class="restaurantList restaurantList-12">
                <a href="http://jms.bitgaiwang.com/179.html" class="a1" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/115.html" class="a2" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/77.html" class="a3" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/92.html" class="a4" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/102.html" class="a5" target="_blank"></a>
                <a href="http://jms.bitgaiwang.com/285.html" class="a6" target="_blank"></a>
            </div>
        </div>
    </div>
    <div class="fixedbg-04"></div>
    <div class="journey-09" id="part4">
        <div class="zt-con">
            <div class="ls-btngroup">
                <div class="gwls active"></div>
                <div class="gnls"></div>
            </div>
            <div class="snacksList">
                <ul>
                    <li class="snacksList01-01">
                        <a href="http://www.bitgaiwang.com/JF/368736.html" class="a1" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/224026.html" class="a2" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/172278.html" class="a3" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/384535.html" class="a4" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/407644.html" class="a5" target="_blank"></a>
                    </li>
                    <li class="snacksList01-02">
                        <a href="http://www.bitgaiwang.com/JF/167858.html" class="a1" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/162403.html" class="a2" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/87622.html" class="a3" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/88937.html" class="a4" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/404658.html" class="a5" target="_blank"></a>
                    </li>
                    <li class="snacksList01-03">
                        <a href="http://www.bitgaiwang.com/JF/343936.html" class="a1" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/85137.html" class="a2" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/101402.html" class="a3" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/78133.html" class="a4" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/405849.html" class="a5" target="_blank"></a>
                    </li>
                    <li class="snacksList01-04">
                        <a href="http://www.bitgaiwang.com/JF/360484.html" class="a1" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/281994.html" class="a2" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/325832.html" class="a3" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/99025.html" class="a4" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/240041.html" class="a5" target="_blank"></a>
                    </li>
                </ul>
                <ul>
                    <li class="snacksList02-01">
                        <a href="http://www.bitgaiwang.com/JF/323820.html" class="a1" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/385263.html" class="a2" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/424330.html" class="a3" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/85948.html" class="a4" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/353375.html" class="a5" target="_blank"></a>
                    </li>
                    <li class="snacksList02-02">
                        <a href="http://www.bitgaiwang.com/JF/184621.html" class="a1" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/400011.html" class="a2" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/79667.html" class="a3" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/178409.html" class="a4" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/223302.html" class="a5" target="_blank"></a>
                    </li>
                    <li class="snacksList02-03">
                        <a href="http://www.bitgaiwang.com/JF/246986.html" class="a1" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/389363.html" class="a2" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/181296.html" class="a3" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/180644.html" class="a4" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/178453.html" class="a5" target="_blank"></a>
                    </li>
                    <li class="snacksList02-04">
                        <a href="http://www.bitgaiwang.com/JF/200584.html" class="a1" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/65976.html" class="a2" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/257559.html" class="a3" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/272473.html" class="a4" target="_blank"></a>
                        <a href="http://www.bitgaiwang.com/JF/329884.html" class="a5" target="_blank"></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="journey-10">
        <div class="zt-con">
            <a href="javascript:void(0)" class="backToTop"></a>
        </div>
    </div>
    <div class="navRight">
        <a href="#part1" class="a1">乐享酒店</a>
        <a href="#part2" class="a2">乐享旅途</a>
        <a href="#part3" class="a3">乐享餐厅</a>
        <a href="#part4" class="a4">乐享美食</a>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        //乐享酒店
        var cityList01Pos = 0;
        var cityIndex01 = 0;
        var cityOnoff01 = true;

        function listChange(_this,pos){
            if(_this.siblings().hasClass('active')){
                pos = _this.siblings('.active').css('backgroundPosition');
                _this.siblings('.active').removeClass('active').css({'backgroundPosition':pos});
            }
            pos = _this.css('backgroundPosition');
            _this.addClass('active');
            _this.css({'backgroundPosition':pos});
        }

        $('.cityList-01 .city').click(function(){
            var _this = $(this);
            if(cityOnoff01){
                listChange(_this,cityList01Pos);

                var _thisIndex = $(this).index();
                if(_thisIndex!=cityIndex01){
                    cityOnoff01 = false;
                    $('.hotelList').eq(cityIndex01).fadeOut(500,function(){
                        cityIndex01 = _thisIndex;
                        $('.hotelList').eq(cityIndex01).fadeIn(500,function(){
                            cityOnoff01 = true;
                        });
                    });
                }
            };
        })

        $('.hotelList a').hover(function(){
            $(this).find('img').show();
        },function(){
            $(this).find('img').hide();
        });
        //乐享旅途
        var travelOnoff = true;
        var aaa = true;
        $('.journey-06 .zt-con div').click(function(){
            if(!$(this).hasClass('active')&&travelOnoff){
                travelOnoff = false;
                $(this).addClass('active').siblings().removeClass('active');
                var travelIndex = $(this).index();
                $('.travelList').eq((travelIndex+1)%2).fadeOut(500,function(){
                    $('.travelList').eq(travelIndex).fadeIn(500,function(){
                        travelOnoff = true;
                    })
                })
            };
        })
        $('.travelList a').hover(function(){
            $(this).find('img').show();
        },function(){
            $(this).find('img').hide();
        });

        //乐享餐厅
        var cityList02Pos = $('.restaurantCityList .city-01').css('backgroundPosition');
        $('.restaurantCityList .city-01').addClass('active').css('backgroundPosition',cityList02Pos);
        var cityOnoff02 = true;
        var cityIndex02 = 0;
        $('.restaurantCityList .city').click(function(){
            var _this = $(this);
            if(cityOnoff02){
                listChange(_this,cityList02Pos);

                var _thisIndex = $(this).index();
                if(_thisIndex!=cityIndex02){
                    cityOnoff02 = false;
                    $('.restaurantList').eq(cityIndex02).fadeOut(500,function(){
                        cityIndex02 = _thisIndex;
                        $('.restaurantList').eq(cityIndex02).fadeIn(500,function(){
                            cityOnoff02 = true;
                        });
                    });
                }
            };
        })
        //乐享美食
        var snacksOnoff = true;
        $('.ls-btngroup div').click(function(){
            if(!$(this).hasClass('active')&&snacksOnoff){
                snacksOnoff = false;
                $(this).addClass('active').siblings().removeClass('active');
                var snacksIndex = $(this).index();
                $('.snacksList ul').eq((snacksIndex+1)%2).fadeOut(500,function(){
                    $('.snacksList ul').eq(snacksIndex).fadeIn(500,function(){
                        snacksOnoff = true;
                    })
                })
            };
        })


    })
    /*回到顶部*/
    $("#backTop,.backToTop").click(function() {
        $('body,html').stop().animate({scrollTop: 0}, 500);
        return false;
    });
</script>