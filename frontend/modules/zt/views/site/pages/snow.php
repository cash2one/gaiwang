<?php $this->pageTitle = "冬季护肤_" . $this->pageTitle;?>

<link href="http://www.g-emall.com/css/global.css" rel="stylesheet" type="text/css">
<link href="http://www.g-emall.com/css/module.css" rel="stylesheet" type="text/css">
<script src="http://www.g-emall.com/js/jquery-1.9.1.js" type="text/javascript"></script>
<script src="http://www.g-emall.com/js/jquery.gate.common.js" type="text/javascript"></script>
<script src="http://www.g-emall.com/js/jquery.flexslider-min.js"></script>
<style type="text/css">
    /*=====
    @Date:2015-12-01
    @content:冬季护肤
	@author:林聪毅
 =====*/
    .zt-wrap{width:100%; background:#fff;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .snow-01{height:148px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-01.jpg) top center no-repeat;}
    .snow-02{height:149px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-02.jpg) top center no-repeat;}
    .snow-03{height:148px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-03.jpg) top center no-repeat;}
    .snow-04{height:249px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-04.jpg) top center no-repeat;}
    .snow-05{height:249px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-05.jpg) top center no-repeat;}
    .snow-06{height:249px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-06.jpg) top center no-repeat;}
    .snow-07{height:318px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-07.jpg) top center no-repeat;}
    .snow-08{height:318px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-08.jpg) top center no-repeat;}
    .snow-09{height:344px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-09.jpg) top center no-repeat;}
    .snow-10{height:344px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-10.jpg) top center no-repeat;}

    .snow-11{height:337px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-11.jpg) top center no-repeat;}
    .snow-12{height:337px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-12.jpg) top center no-repeat;}
    .snow-13{height:223px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-13.jpg) top center no-repeat;}
    .snow-14{height:222px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-14.jpg) top center no-repeat;}
    .snow-15{height:223px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-15.jpg) top center no-repeat;}
    .snow-16{height:222px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-16.jpg) top center no-repeat;}
    .snow-17{height:278px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-17.jpg) top center no-repeat;}
    .snow-18{height:278px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-18.jpg) top center no-repeat;}
    .snow-19{height:180px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-19.jpg) top center no-repeat;}
    .snow-20{height:180px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-20.jpg) top center no-repeat;}

    .snow-21{height:180px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-21.jpg) top center no-repeat;}
    .snow-22{height:368px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-22.jpg) top center no-repeat;}
    .snow-23{height:217px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-23.jpg) top center no-repeat;}
    .snow-24{height:217px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-24.jpg) top center no-repeat;}
    .snow-25{height:218px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-25.jpg) top center no-repeat;}
    .snow-26{height:218px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-26.jpg) top center no-repeat;}
    .snow-27{height:400px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-27.jpg) top center no-repeat;}
    .snow-28{height:454px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-28.jpg) top center no-repeat;}
    .snow-29{height:672px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-29.jpg) top center no-repeat;}
    .snow-30{height:376px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-30.jpg) top center no-repeat;}

    .snow-31{height:376px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-31.jpg) top center no-repeat;}
    .snow-32{height:325px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-32.jpg) top center no-repeat;}
    .snow-33{height:325px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-33.jpg) top center no-repeat;}
    .snow-34{height:614px; background:url(<?php echo ATTR_DOMAIN;?>/zt/snow/snow-34.jpg) top center no-repeat;}

    #snowbox:hover{cursor: default;}

    .snow-07 a{}
    .snow-07 .a1{width: 390px; height: 580px; left: 16px; top: 40px;}
    .snow-07 .a2{width: 380px; height: 400px; left: 600px; top: 0px;}
    .snow-09 a{width: 460px; height: 400px; left: 540px; top: -40px; z-index: 2;}
    .snow-10 a{width: 600px; height: 440px; left: 0px; top: -90px;}

    .snow-11 a{width: 280px; height: 490px; left: 690px; top: 30px;}
    .snow-12 a{width: 420px; height: 390px; left: 0px; top: -80px;}
    .snow-15 a{width: 700px; height: 400px; left: 10px; top: -50px;}
    .snow-17 a{}
    .snow-17 .a1{width: 280px; height: 460px; left: -50px; top: 30px;}
    .snow-17 .a2{width: 350px; height: 390px; left: 230px; top: 100px;}
    .snow-17 .a3{width: 370px; height: 400px; left: 650px; top: 90px;}
    .snow-19 a{width: 280px; height: 440px; top: 60px;}
    .snow-19 .a1{left: 294px;}
    .snow-19 .a2{left: 640px;}

    .snow-23 a{}
    .snow-23 .a1{width: 510px; height: 390px; left: -60px; top: 10px;}
    .snow-23 .a2{width: 510px; height: 350px; left: 500px; top: 20px;}
    .snow-25 a{}
    .snow-25 .a1{width: 510px; height: 290px; left: -60px; top: 50px;}
    .snow-25 .a2{width: 460px; height: 370px; left: 560px; top: 50px;}
    .snow-27 a{}
    .snow-27 .a1{width: 480px; height: 340px; left: -30px; top: 50px;}
    .snow-27 .a2{width: 540px; height: 290px; left: 480px; top: 120px;}
    .snow-29 a{}
    .snow-29 .a1{width: 310px; height: 600px; left: -40px; top: 10px;}
    .snow-29 .a2{width: 300px; height: 610px; left: 350px; top: 0px;}
    .snow-29 .a3{width: 290px; height: 580px; left: 730px; top: 30px;}
    .snow-30 a{}
    .snow-30 .a1{width: 310px; height: 500px; left: -40px; top: 140px;}
    .snow-30 .a2{width: 300px; height: 540px; left: 350px; top: 100px;}
    .snow-30 .a3{width: 290px; height: 530px; left: 730px; top: 110px;}
    .snow-32 a{}
    .snow-32 .a1{width: 310px; height: 530px; left: -40px; top: 50px;}
    .snow-32 .a2{width: 300px; height: 540px; left: 350px; top: 40px;}
    .snow-32 .a3{width: 330px; height: 490px; left: 690px; top: 90px;}
    .snow-34 a{width: 220px; height: 90px; left: 240px; top: 90px;}
</style>

<audio autoplay="autoplay" loop="loop">
    <source src="<?php echo ATTR_DOMAIN;?>/zt/snow/LetItGo.mp3" type="audio/mp3">
    <embed height="100" width="100" src="<?php echo ATTR_DOMAIN;?>/zt/snow/LetItGo.mp3">
</audio>
<div class="zt-wrap">
    <div class="snow-01"></div>
    <div class="snow-02"></div>
    <div class="snow-03"></div>
    <div class="snow-04"></div>
    <div class="snow-05"></div>
    <div class="snow-06"></div>
    <div class="snow-07">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/255907.html" title="欧莱雅旗舰店女士护肤套装 清润葡萄籽柔肤水 乳液膜力面霜 包邮" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/234974.html" title="澳洲gm绵羊油ve面霜250g家庭装 原装进口纯天然" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="snow-08"></div>
    <div class="snow-09">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/275796.html" title="百雀羚爽肤水 水嫩倍现盈透精华水100ml*2瓶装化妆柔肤水保湿补水" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="snow-10">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/246461.html" title="可莱丝NMF针剂水库面膜贴10片 保湿补水嫩白淡斑春夏韩国正品男女 李多海推荐 天然保湿因子 肌肤水润清透" class="a1" target="_blank"></a>
        </div>
    </div>

    <div class="snow-11">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/306552.html" title="FANCL 无添加胶原修护乳液 30ml 滋润/水润 两款可选" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="snow-12">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/111848.html" title="水密码 冰川矿泉系列 睡眠面膜/免洗面膜 补水保湿 美白抗皱 丹姿正品" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="snow-13"></div>
    <div class="snow-14"></div>
    <div class="snow-15">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/84409.html" title="专柜正品 Dove多芬 美白滋润身体霜300ML" class="a1" target="_blank"></a>
        </div>
    </div>
    <div class="snow-16"></div>
    <div class="snow-17">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/161686.html" title="Kiehls科颜氏 契尔氏全身保湿护肤乳润肤露250ml 保湿乳液" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/157734.html" title="韩国自然乐园naturerepublic芦荟胶 完美祛痘保湿面霜 300ml" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/165847.html" title="专柜正品 佰草集舒悦新颜精油套装（薰衣草+天竺葵）" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="snow-18"></div>
    <div class="snow-19">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/161494.html" title="娇韵诗 柔美身体护理油100ml 提拉紧致 精油 预防身体" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/67019.html" title="Bodyskin生姜精油5ml 泡脚身体按摩推背足浴暖宫暖身" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="snow-20"></div>

    <div class="snow-21"></div>
    <div class="snow-22"></div>
    <div class="snow-23">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/332589.html" title="拍2发3欧丽源手膜 白皙去角质牛奶蜂蜜手腊手摸手蜡手部护理 护手霜" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/140705.html" title="Kiehls科颜氏 契尔氏 滋润护手霜 150ML 美白保湿细润保湿" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="snow-24"></div>
    <div class="snow-25">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/169129.html" title="资生堂美润护手霜100g*3瓶套装 深层补水保湿防干纹 肌肤干裂粗糙" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/236132.html" title="澳洲木瓜膏lucas papaw15g神奇番万用润唇膏婴儿孕妇可用" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="snow-26"></div>
    <div class="snow-27">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/75873.html" title="Elizabeth Arden雅顿显效8小时润唇膏SPF15/经典润泽唇霜3.7g" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/181870.html" title="SEPHORA  丝芙兰蜜吻润唇球" class="a2" target="_blank"></a>
        </div>
    </div>
    <div class="snow-28"></div>
    <div class="snow-29">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/250711.html" title="日本SANA豆乳洗面奶卸妆洁面乳150g 美白补水控油" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/168516.html" title="Olay玉兰油 水漾动力保湿洁面乳125g 洗面奶 补水保湿 深层清洁" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/269542.html" title="婴儿天然燕麦洗发沐浴露二合一  美国Aveeno Baby正品宝宝洗发沐浴露 无泪配方 温和滋润" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="snow-30">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/269562.html" title="婴儿燕麦精华泡澡粉 美国进口正品 Aveeno Baby宝宝泡澡粉 天然温和 滋润肌肤 缓解湿疹 预防干痒" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/315177.html" title="玉兰油沐浴露 美白清爽沐浴露720mlX2 沐浴清爽保湿正品" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/134228.html" title="【韩多美】                韩多美善肌花漾甜心美肌香氛沐浴露 美白保湿补水女士香水沐浴乳 粉色玫瑰樱花沐浴露" class="a3" target="_blank"></a>
        </div>
    </div>

    <div class="snow-31"></div>
    <div class="snow-32">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/243137.html" title="资生堂正品水之密语凝润水护洗发水护发素洗护套装600ml*3 补水" class="a1" target="_blank"></a>
            <a href="http://www.g-emall.com/JF/250413.html" title="韩国进口 爱茉莉 绿吕 防脱控油去屑洗发水护发素 无硅油套装" class="a2" target="_blank"></a>
            <a href="http://www.g-emall.com/shop/product/4311.html?cid=26198" title="" class="a3" target="_blank"></a>
        </div>
    </div>
    <div class="snow-33"></div>
    <div class="snow-34">
        <div class="zt-con">
            <a href="javascript:void(0)" class="a1 backToTop"></a>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function($){
        $.fn.snow = function(options){
            var $flake = $('<span id="snowbox" />').css({'position': 'fixed','z-index':'1', 'top': '-50px'}).html('&#10052;'),
                documentHeight 	= $(window).height(),
                documentWidth	= $(document).width(),
                defaults = {
                    minSize		: 10,
                    maxSize		: 20,
                    newOn		: 1000,
                    flakeColor	: "#fff" /* 此处可以定义雪花颜色，若要白色可以改为#FFFFFF */
                },
                options	= $.extend({}, defaults, options);
            var interval= setInterval( function(){
                var startPositionLeft = Math.random() * documentWidth - 100,
                    startOpacity = 0.5 + Math.random(),
                    sizeFlake = options.minSize + Math.random() * options.maxSize,
                    endPositionTop = documentHeight - 200,
                    endPositionLeft = startPositionLeft - 250 + Math.random() * 500,
                    durationFall = documentHeight * 10 + Math.random() * 5000;
                $flake.clone().appendTo('body').css({
                    //top: $('.header').height(),
                    left: startPositionLeft,
                    opacity: startOpacity,
                    'font-size': sizeFlake,
                    color: options.flakeColor
                }).animate({
                    top: endPositionTop,
                    left: endPositionLeft,
                    opacity: 0.2
                },durationFall,'linear',function(){
                    $(this).remove()
                });
            }, options.newOn);
        };
    })(jQuery);
    $(function(){
        $.fn.snow({
            minSize: 5, /* 定义雪花最小尺寸 */
            maxSize: 50,/* 定义雪花最大尺寸 */
            newOn: 300  /* 定义密集程度，数字越小越密集 */
        });
    });

    /*回到顶部*/
    $(".backToTop").click(function() {
        $('body,html').stop().animate({scrollTop: 0}, 500);
        return false;
    });
</script>