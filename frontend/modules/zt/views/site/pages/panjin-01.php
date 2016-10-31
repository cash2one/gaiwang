<?php $this->pageTitle = "盘锦专题_".$this->pageTitle ?>
<style type="text/css">
    /*=====
    @Date:2014-10-22
    @content:寻味野山珍
	@author:林聪毅
 =====*/
    .zt-wrap{width:100%; background:#fff;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .panjin-01-01{height:221px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-01.jpg) top center no-repeat;}
    .panjin-01-02{height:221px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-02.jpg) top center no-repeat;}
    .panjin-01-03{height:221px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-03.jpg) top center no-repeat;}
    .panjin-01-04{height:221px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-04.jpg) top center no-repeat;}
    .panjin-01-05{height:486px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-05.jpg) top center no-repeat;}
    .panjin-01-06{height:450px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-06.jpg) top center no-repeat;}
    .panjin-01-07{height:401px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-07.jpg) top center no-repeat;}
    .panjin-01-08{height:401px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-08.jpg) top center no-repeat;}
    .panjin-01-09{height:444px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-09.jpg) top center no-repeat;}
    .panjin-01-10{height:441px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-10.jpg) top center no-repeat;}

    .panjin-01-11{height:440px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-11.jpg) top center no-repeat;}
    .panjin-01-12{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-12.jpg) top center no-repeat;}
    .panjin-01-13{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-13.jpg) top center no-repeat;}
    .panjin-01-14{height:407px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-14.jpg) top center no-repeat;}
    .panjin-01-15{height:407px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-15.jpg) top center no-repeat;}
    .panjin-01-16{height:558px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-16.jpg) top center no-repeat;}
    .panjin-01-17{height:552px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-17.jpg) top center no-repeat;}
    .panjin-01-18{height:592px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-01/panjin-01-18.jpg) top center no-repeat;}

    .panjin-01-05 a{ width:960px; height:430px;}
    .panjin-01-05 .a1{left:0px; top:50px;}
    .panjin-01-06 a{ width:960px; height:430px;}
    .panjin-01-06 .a1{left:0px; top:10px;}
    .panjin-01-07 a{ width:600px; height:430px;}
    .panjin-01-07 .a1{left:160px; top:180px;}
    .panjin-01-09 a{ width:1000px; height:430px;}
    .panjin-01-09 .a1{left:-40px; top:10px;}
    .panjin-01-10 a{ width:1090px; height:440px;}
    .panjin-01-10 .a1{left:-30px; top:260px;}

    .panjin-01-13 a{}
    .panjin-01-13 .a1{ width:350px; height:400px; left:-70px; top:-74px;}
    .panjin-01-13 .a2{ width:376px; height:420px; left:310px; top:-94px;}
    .panjin-01-13 .a3{ width:360px; height:420px; left:700px; top:-94px;}
    .panjin-01-15 a{ width:770px; height:530px;}
    .panjin-01-15 .a1{left:-50px; top:-160px;}
    .panjin-01-16 a{ width:960px; height:430px;}
    .panjin-01-16 .a1{left:0px; top:100px;}
    .panjin-01-17 a{ width:960px; height:430px;}
    .panjin-01-17 .a1{left:20px; top:30px;}
    .panjin-01-18 a{ width: 140px; height: 160px;}
    .panjin-01-18 .a1{left: -60px; top: 66px;}
    .panjin-01-18 .a2{left: 98px; top: 66px;}
    .panjin-01-18 .a3{left: 258px; top: 66px;}
    .panjin-01-18 .a4{left: 416px; top: 66px;}
    .panjin-01-18 .a5{left: 576px; top: 66px;}
    .panjin-01-18 .a6{left: 732px; top: 66px;}
    .panjin-01-18 .a7{left: 890px; top: 66px;}
    .panjin-01-18 .a8{left: -60px; top: 284px;}
    .panjin-01-18 .a9{left: 98px; top: 284px;}
    .panjin-01-18 .a10{left: 258px; top: 284px;}
    .panjin-01-18 .a11{left: 416px; top: 284px;}
    .panjin-01-18 .a12{left: 576px; top: 284px;}
    .panjin-01-18 .a13{left: 732px; top: 284px;}
    .panjin-01-18 .a14{left: 890px; top: 284px;}
    .panjin-01-18 .a15{width: 250px; height: 150px; left: 359px; top: 446px;}
</style>

<div class="zt-wrap">
    <div class="panjin-01-01"></div>
    <div class="panjin-01-02"></div>
    <div class="panjin-01-03"></div>
    <div class="panjin-01-04"></div>
    <div class="panjin-01-05">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/175095.html" title="【东特特色食品旗舰店】盘锦舌尖上的野味 野生黑松露 野山菌专家 我们只做野生中的精品 220g" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-01-06">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/166325.html" title="【东特特色食品旗舰店】辽宁盘锦黑木耳 小碗耳 山木耳野生小木耳干货特产秋木耳精选 250g" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-01-07">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/170724.html" title="【东特特色食品旗舰店】盘锦 野生松茸 香格里拉采集 纯野生珍品" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-01-08"></div>
    <div class="panjin-01-09">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/171795.html" title="【东特特色食品旗舰店】盘锦 菇林锦怪-秋耳 野山菌 天然取材 天然 好营养 好美味（礼盒装）" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-01-10">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/171792.html" title="【东特特色食品旗舰店】盘锦 野山菌-野生红蘑 菇中之王 天然 好营养 好美味（礼盒装）" class="a1" target="_blank"></a>
        </div>
    </div>

    <div class="panjin-01-11"></div>
    <div class="panjin-01-12"></div>
    <div class="panjin-01-13">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/166826.html" title="【东特特色食品旗舰店】辽宁盘锦有机元蘑菇 250g" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/goods/206093.html" title="东北特产黄金耳【郑家屯】产自东北大森林野生黄金耳100g" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/166775.html" title="【东特特色食品旗舰店】辽宁盘锦有机榛蘑菇 250g" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-01-14"></div>
    <div class="panjin-01-15">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/213436.html" title="辽宁铁岭特产 坚果之王 野生铁岭特等大榛子1500g/桶   包邮" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-01-16">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/213101.html" title="辽宁铁岭特产 野生榛子77元/500g/袋  四袋起售  包邮" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-01-17">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/213421.html" title="辽宁铁岭特产 坚果之王  野生榛子179元/1000g/桶 两桶起售 包邮" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-01-18">
        <div class="zt-con">
            <a href="http://www.g-emall.com/shop/3287.html" title="盖象商城•生态盘锦O2O体验馆" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/1803.html" title="鑫凯户外" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/1456.html" title="柒号名品" class="a3" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/3075.html" title="东特特色食品旗舰店" class="a4" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/3074.html" title="利群有机食品旗舰店" class="a5" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/4053.html" title="盘锦科生农业旗舰店" class="a6" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/3136.html" title="乾农农业产品旗舰店" class="a7" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/2822.html" title="钰华数码旗舰店" class="a8" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/2821.html" title="光合蟹业旗舰店" class="a9" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/3132.html" title="一禾农家" class="a10" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/3774.html" title="易禅商贸" class="a11" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/2817.html" title="盘锦大米特产店" class="a12" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/1569.html" title="德福祥" class="a13" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/4165.html" title="红品土特产商行" class="a14" target="_blank"></a>
            <a href="javascript:void(0)" class="a15 backTop"></a>
        </div>
    </div>



</div>
<script type="text/javascript">
    /*回到顶部*/
    $(".backTop").click(function() {
        $('body,html').stop().animate({scrollTop: 0}, 500);
        return false;
    });
</script>