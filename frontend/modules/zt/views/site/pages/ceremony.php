<?php $this->pageTitle = "年货盛典_" . $this->pageTitle;?>
<style type="text/css">
    /*=====
    @Date:2015-12-29
    @content:年度盛典
	@author:林聪毅
 =====*/
    .zt-wrap{width:100%; background:#fff; overflow: hidden;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .ceremony-01{height:270px; background:url(<?php echo ATTR_DOMAIN;?>/zt/ceremony/ceremony-01.jpg) top center no-repeat;}
    .ceremony-02{height:270px; background:url(<?php echo ATTR_DOMAIN;?>/zt/ceremony/ceremony-02.jpg) top center no-repeat;}
    .ceremony-03{height:270px; background:url(<?php echo ATTR_DOMAIN;?>/zt/ceremony/ceremony-03.jpg) top center no-repeat;}
    .ceremony-04{height:270px; background:url(<?php echo ATTR_DOMAIN;?>/zt/ceremony/ceremony-04.jpg) top center no-repeat;}

    .firecracker{
        width: 255px; height: 415px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/ceremony/firecracker.png) no-repeat;
        position: absolute; left: 880px; top: 0px;
    }

    .ceremony-03 a{width: 236px; height: 104px;}
    .ceremony-03 .a1{width: 292px; height: 124px; left: -102px; top: -40px;}
    .ceremony-03 .a2{width: 292px; height: 124px; left: 191px; top: -40px;}
    .ceremony-03 .a3{width: 292px; height: 124px; left: 484px; top: -40px;}
    .ceremony-03 .a4{width: 292px; height: 124px; left: 778px; top: -40px;}
    .ceremony-03 .a5{left: -103px; top: 86px;}
    .ceremony-03 .a6{left: 133px; top: 86px;}
    .ceremony-03 .a7{left: 367px; top: 86px;}
    .ceremony-03 .a8{left: 601px; top: 86px;}
    .ceremony-03 .a9{left: 834px; top: 86px;}
    .ceremony-03 .a10{left: -103px; top: 192px;}
    .ceremony-03 .a11{left: 133px; top: 192px;}
    .ceremony-03 .a12{left: 367px; top: 192px;}
    .ceremony-03 .a13{left: 601px; top: 192px;}
    .ceremony-03 .a14{left: 834px; top: 192px;}
    .monkey{
        width: 155px; height: 215px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/ceremony/monkey.png) no-repeat;
        position: absolute; left: 1070px; top: -180px;
    }
    .firecracker{
        animation: onMove1 4s ease-in-out infinite;
        -webkit-animation: onMove1 4s ease-in-out infinite;
        -moz-animation: onMove1 4s ease-in-out infinite;
        -ms-animation: onMove1 4s ease-in-out infinite;
    }
    .monkey{
        animation: onMove2 2s ease-in-out infinite;
        -webkit-animation: onMove2 2s ease-in-out infinite;
        -moz-animation: onMove2 2s ease-in-out infinite;
        -ms-animation: onMove2 2s ease-in-out infinite;
    }
    @keyframes onMove1{
        0% 	{transform: translateX(0);}
        50% {transform: translateX(200px);}
        100% {transform: translateX(0);}
    }
    @-webkit-keyframes onMove1{
        0% 	{-webkit-transform: translateX(0);}
        50% {-webkit-transform: translateX(200px);}
        100% {-webkit-transform: translateX(0);}
    }
    @-moz-keyframes onMove1{
        0% 	{-moz-transform: translateX(0);}
        50% {-moz-transform: translateX(200px);}
        100% {-moz-transform: translateX(0);}
    }
    @-ms-keyframes onMove1{
        0% 	{-ms-transform: translateX(0);}
        50% {-ms-transform: translateX(200px);}
        100% {-ms-transform: translateX(0);}
    }

    @keyframes onMove2{
        0% 	{transform: translateY(0);}
        50% {transform: translateY(-100px);}
        100% {transform: translateY(0);}
    }
    @-webkit-keyframes onMove2{
        0% 	{-webkit-transform: translateY(0);}
        50% {-webkit-transform: translateY(-100px);}
        100% {-webkit-transform: translateY(0);}
    }
    @-moz-keyframes onMove2{
        0% 	{-moz-transform: translateY(0);}
        50% {-moz-transform: translateY(-100px);}
        100% {-moz-transform: translateY(0);}
    }
    @-ms-keyframes onMove2{
        0% 	{-ms-transform: translateY(0);}
        50% {-ms-transform: translateY(-100px);}
        100% {-ms-transform: translateY(0);}
    }

</style>

<div class="zt-wrap">
    <div class="ceremony-01">
        <div class="zt-con">
            <div class="firecracker"></div>
        </div>
    </div>
    <div class="ceremony-02"></div>
    <div class="ceremony-03">
        <div class="zt-con">
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/ceremony-01" class="a1" target="_blank"></a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/ceremony-02" class="a2" target="_blank"></a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/ceremony-03" class="a3" target="_blank"></a>
            <a href="http://zt.<?php echo SHORT_DOMAIN;?>/site/ceremony-04" class="a4" target="_blank"></a>
            <a href="http://active.g-emall.com/festive/detail/77" class="a5" target="_blank"></a>
            <a href="http://active.g-emall.com/festive/detail/82" class="a6" target="_blank"></a>
            <a href="http://active.g-emall.com/festive/detail/86" class="a7" target="_blank"></a>
            <a href="http://active.g-emall.com/festive/detail/78" class="a8" target="_blank"></a>
            <a href="http://active.g-emall.com/festive/detail/84" class="a9" target="_blank"></a>
            <a href="http://active.g-emall.com/festive/detail/85" class="a10" target="_blank"></a>
            <a href="http://active.g-emall.com/festive/detail/79" class="a11" target="_blank"></a>
            <a href="http://active.g-emall.com/festive/detail/83" class="a12" target="_blank"></a>
            <a href="http://active.g-emall.com/festive/detail/81" class="a13" target="_blank"></a>
            <a href="http://active.g-emall.com/festive/detail/80" class="a14" target="_blank"></a>
        </div>
    </div>
    <div class="ceremony-04">
        <div class="zt-con">
            <div class="monkey"></div>
        </div>
    </div>


</div>