<?php $this->pageTitle = "盘锦专题_".$this->pageTitle ?>
<style type="text/css">
    /*=====
    @Date:2014-07-09
    @content:五谷杂粮
	@author:林聪毅
 =====*/
    .zt-wrap{width:100%; background:#fff;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .panjin-05-01{height:239px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-01.jpg) top center no-repeat;}
    .panjin-05-02{height:238px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-02.jpg) top center no-repeat;}
    .panjin-05-03{height:239px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-03.jpg) top center no-repeat;}
    .panjin-05-04{height:488px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-04.jpg) top center no-repeat;}
    .panjin-05-05{height:331px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-05.jpg) top center no-repeat;}
    .panjin-05-06{height:329px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-06.jpg) top center no-repeat;}
    .panjin-05-07{height:218px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-07.jpg) top center no-repeat;}
    .panjin-05-08{height:216px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-08.jpg) top center no-repeat;}
    .panjin-05-09{height:540px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-09.jpg) top center no-repeat;}
    .panjin-05-10{height:269px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-10.jpg) top center no-repeat;}

    .panjin-05-11{height:269px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-11.jpg) top center no-repeat;}
    .panjin-05-12{height:351px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-12.jpg) top center no-repeat;}
    .panjin-05-13{height:350px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-13.jpg) top center no-repeat;}
    .panjin-05-14{height:351px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-14.jpg) top center no-repeat;}
    .panjin-05-15{height:330px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-15.jpg) top center no-repeat;}
    .panjin-05-16{height:330px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-16.jpg) top center no-repeat;}
    .panjin-05-17{height:330px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-17.jpg) top center no-repeat;}
    .panjin-05-18{height:337px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-18.jpg) top center no-repeat;}
    .panjin-05-19{height:338px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-19.jpg) top center no-repeat;}
    .panjin-05-20{height:337px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-20.jpg) top center no-repeat;}

    .panjin-05-21{height:308px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-21.jpg) top center no-repeat;}
    .panjin-05-22{height:546px; background:url(<?php echo ATTR_DOMAIN;?>/zt/panjin-05/panjin-05-22.jpg) top center no-repeat;}

    .panjin-05-04 a{ width:319px; height:319px; top:0px;}
    .panjin-05-04 .a1{left:0px; }
    .panjin-05-04 .a2{left:325px; }
    .panjin-05-04 .a3{right:0px; }
    .panjin-05-05 a{ width:960px; height:520px; top:122px;}
    .panjin-05-05 .a1{left:4px; }
    .panjin-05-07 a{ width:480px; height:386px; top:0px;}
    .panjin-05-07 .a1{left:0px; }
    .panjin-05-07 .a2{left:485px; }
    .panjin-05-09 a{ width:960px; height:520px; top:2px;}
    .panjin-05-09 .a1{left:4px; }
    .panjin-05-10 a{ width:480px; height:386px; top:0px;}
    .panjin-05-10 .a1{left:0px; }
    .panjin-05-10 .a2{left:485px; }

    .panjin-05-13 a{}
    .panjin-05-13 .a1{ width:430px; height:230px; left:310px; top:-100px; z-index: 1;}
    .panjin-05-13 .a2{ width:510px; height:320px; left:240px; top:124px; z-index: 2;}
    .panjin-05-14 a{ width:490px; height:216px; top:110px; z-index: 3;}
    .panjin-05-14 .a1{left:290px; }
    .panjin-05-15 a{ width:420px; height:300px; top:126px;}
    .panjin-05-15 .a1{left:278px; }
    .panjin-05-16 a{ width:380px; height:240px; top:102px;}
    .panjin-05-16 .a1{left:76px; }
    .panjin-05-16 .a2{left:465px; }
    .panjin-05-17 a{ width:400px; height:280px; top:36px;}
    .panjin-05-17 .a1{left:248px; }
    .panjin-05-18 a{ width:410px; height:250px; top:196px;}
    .panjin-05-18 .a1{left:288px; }
    .panjin-05-19 a{ width:470px; height:266px; top:116px;}
    .panjin-05-19 .a1{left:260px; }
    .panjin-05-20 a{ width:460px; height:270px; top:48px;}
    .panjin-05-20 .a1{left:312px; }
    .panjin-05-21 a{ width:108px; height:202px; top:100px;}
    .panjin-05-21 .a1{left:462px; }
    .panjin-05-22 a{ width: 140px; height: 160px;}
    .panjin-05-22 .a1{left: -60px; top: 88px;}
    .panjin-05-22 .a2{left: 98px; top: 88px;}
    .panjin-05-22 .a3{left: 256px; top: 88px;}
    .panjin-05-22 .a4{left: 414px; top: 88px;}
    .panjin-05-22 .a5{left: 572px; top: 88px;}
    .panjin-05-22 .a6{left: 732px; top: 88px;}
    .panjin-05-22 .a7{left: 890px; top: 88px;}
    .panjin-05-22 .a8{left: -60px; top: 304px;}
    .panjin-05-22 .a9{left: 98px; top: 304px;}
    .panjin-05-22 .a10{left: 256px; top: 304px;}
    .panjin-05-22 .a11{left: 414px; top: 304px;}
    .panjin-05-22 .a12{left: 572px; top: 304px;}
    .panjin-05-22 .a13{left: 732px; top: 304px;}
    .panjin-05-22 .a14{left: 890px; top: 304px;}

</style>

<div class="zt-wrap">
    <div class="panjin-05-01"></div>
    <div class="panjin-05-02"></div>
    <div class="panjin-05-03"></div>
    <div class="panjin-05-04"></div>
    <div class="panjin-05-05">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/221977.html" title="有机杂粮  辽宁特产500g*8  任意搭配  包邮" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-05-06"></div>
    <div class="panjin-05-07">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/234216.html" title="辽宁特产五谷营养豆浆豆250g/盒*12盒" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/goods/229886.html" title="辽宁黑山特产  滋补米粥500g*8" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-05-08"></div>
    <div class="panjin-05-09">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/229883.html" title="辽宁黑山特产  黑八宝450g*8" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-05-10">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/170850.html" title="【乾农农业产品旗舰店】盘锦特产 罐装 蒙田有机荞麦米 生态草原  健康好粮 500g" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/goods/170854.html" title="【乾农农业产品旗舰店】盘锦特产 罐装 蒙田有机绿豆 生态草原  健康好粮 500g" class="a2" target="_blank"></a>
        </div>
    </div>

    <div class="panjin-05-11"></div>
    <div class="panjin-05-12"></div>
    <div class="panjin-05-13">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/171175.html" title="【乾农农业产品旗舰店】盘锦特产 罐装 蒙田有机小米 生态草原 健康好粮 500g" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/goods/170536.html" title="辽西特产辽西杂粮辽宁朝阳特产化石鸟有机杂粮450g*8袋（真空）礼盒装" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-05-14">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/170833.html" title="【乾农农业产品旗舰店】盘锦特产 罐装 蒙田有机白玉米糁 生态草原  健康好粮 500g" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-05-15">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/209017.html" title="东北特产有机芡实米【郑家屯】有机芡实米500g真空包装" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-05-16">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/170857.html" title="【乾农农业产品旗舰店】盘锦特产 罐装 蒙田有机黄玉米糁 生态草原  健康好粮 500g" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/goods/170845.html" title="盘锦特产 罐装 蒙田有机红豆 生态草原  健康好粮 500g" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-05-17">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/190285.html" title="【盘锦特产】【杂粮粥米】真空包装混合杂粮粥米品【新粥道】八宝粥米460g*6盒/箱礼盒装" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-05-18">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/269287.html" title="有机杂粮 450g*8  精品 包邮" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-05-19">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/269197.html" title="多彩花生  900g*4/箱" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="panjin-05-20">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/221480.html" title="【东特特色食品旗舰店】辽宁特产  四色小米450*8 包邮" class="a1" target="_blank"></a>
        </div>
    </div>

    <div class="panjin-05-21">
        <div class="zt-con">
            <a href="javascript:void(0)" class="a1 backTop"></a>
        </div>
    </div>
    <div class="panjin-05-22">
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