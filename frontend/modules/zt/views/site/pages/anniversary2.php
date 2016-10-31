<?php $this->pageTitle = "盖象周年庆_" . $this->pageTitle;?>
<style type="text/css">
    /*=====
    @Date:2016-01-19
    @content:盖象周年庆
	@author:林聪毅
 =====*/
    .zt-wrap{width:100%; background:#fff; overflow: hidden;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .anniversary-01{height:919px; background:url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/anniversary-01.jpg) top center no-repeat;}
    .anniversary-02{height:535px; background:url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/anniversary-02.jpg) top center no-repeat;}
    .anniversary-03{height:534px; background:url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/anniversary-03.jpg) top center no-repeat;}
    .anniversary-04{height:545px; background:url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/anniversary-04.jpg) top center no-repeat;}
    .anniversary-05{height:544px; background:url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/anniversary-05.jpg) top center no-repeat;}
    .anniversary-06{height:546px; background:url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/anniversary-06.jpg) top center no-repeat;}
    .anniversary-07{height:545px; background:url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/anniversary-07.jpg) top center no-repeat;}
    .anniversary-08{height:545px; background:url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/anniversary-08.jpg) top center no-repeat;}
    .anniversary-09{height:537px; background:url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/anniversary-09.jpg) top center no-repeat;}
    .anniversary-10{height:551px; background:url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/anniversary-10.jpg) top center no-repeat;}

    .anniversary-11{height:551px; background:url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/anniversary-11.jpg) top center no-repeat;}
    .anniversary-12{height:648px; background:url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/anniversary-12.jpg) top center no-repeat;}

    .zt-con img{position: absolute; display: none;}

    .anniversary-02 .icon-01{
        width: 284px; height: 285px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/icon-01.png) no-repeat;
        position: absolute; left: 780px; top: 0px; display: none;
    }
    .anniversary-02 a{}
    .anniversary-02 .a1{width: 180px; height: 220px; left: 50px; top: 200px;}
    .anniversary-02 .a1 img{left: -32px; top: -18px;}
    .anniversary-02 .a2{width: 180px; height: 180px; left: 780px; top: 318px;}
    .anniversary-02 .a2 img{left: -47px; top: -52px;}
    .anniversary-03 a{}
    .anniversary-03 .a1{width: 120px; height: 220px; left: -4px; top: -20px;}
    .anniversary-03 .a1 img{left: -77px; top: -26px;}
    .anniversary-03 .a2{width: 190px; height: 130px; left: 770px; top: 50px;}
    .anniversary-03 .a2 img{left: -18px; top: -51px;}
    .anniversary-03 .a3{width: 160px; height: 140px; left: 168px; top: 188px;}
    .anniversary-03 .a3 img{left: -29px; top: -35px;}
    .anniversary-03 .a4{width: 150px; height: 140px; left: 574px; top: 190px;}
    .anniversary-03 .a4 img{left: -35px; top: -37px;}
    .anniversary-04 .icon-02{
        width: 284px; height: 285px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/icon-02.png) no-repeat;
        position: absolute; left: -140px; top: 0px;	display: none;
    }
    .anniversary-04 a{}
    .anniversary-04 .a1{width: 150px; height: 180px; left: 480px; top: 96px;}
    .anniversary-04 .a1 img{left: -53px; top: -36px;}
    .anniversary-04 .a2{width: 120px; height: 180px; left: 820px; top: 128px;}
    .anniversary-04 .a2 img{left: -62px; top: -26px;}
    .anniversary-04 .a3{width: 220px; height: 170px; left: 600px; top: 330px;}
    .anniversary-04 .a3 img{left: -34px; top: -59px;}
    .anniversary-05 a{}
    .anniversary-05 .a1{width: 180px; height: 160px; left: 764px; top: -10px;}
    .anniversary-05 .a1 img{left: -21px; top: -28px;}
    .anniversary-05 .a2{width: 140px; height: 160px; left: 736px; top: 214px;}
    .anniversary-05 .a2 img{left: -55px; top: -44px;}
    .anniversary-06 .icon-03{
        width: 286px; height: 284px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/icon-03.png) no-repeat;
        position: absolute; left: 750px; top: 0px; display: none;
    }
    .anniversary-06 a{}
    .anniversary-06 .a1{width: 110px; height: 250px; left: 140px; top: 114px;}
    .anniversary-06 .a1 img{left: -79px; top: -9px;}
    .anniversary-06 .a2{width: 210px; height: 200px; left: 720px; top: 280px;}
    .anniversary-06 .a2 img{left: -38px; top: -39px;}
    .anniversary-06 .a3{width: 150px; height: 210px; left: -10px; top: 394px;}
    .anniversary-06 .a3 img{left: -68px; top: -43px;}
    .anniversary-07 a{}
    .anniversary-07 .a1{width: 240px; height: 160px; left: -6px; top: 134px;}
    .anniversary-07 .a1 img{left: -11px; top: -50px;}
    .anniversary-07 .a2{width: 160px; height: 200px; left:800px; top: 88px;}
    .anniversary-07 .a2 img{left: -52px; top: -34px;}
    .anniversary-08 .icon-04{
        width: 284px; height: 285px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/icon-04.png) no-repeat;
        position: absolute; left: 780px; top: 0px; display: none;
    }
    .anniversary-08 a{}
    .anniversary-08 .a1{width: 90px; height: 160px; left: 210px; top: 20px;}
    .anniversary-08 .a1 img{left: -62px; top: -20px;}
    .anniversary-08 .a2{width: 170px; height: 150px; left: -40px; top: 90px;}
    .anniversary-08 .a2 img{left: -31px; top: -33px;}
    .anniversary-08 .a3{width: 190px; height: 140px; left: 370px; top: 156px;}
    .anniversary-08 .a3 img{left: -24px; top: -43px;}
    .anniversary-08 .a4{width: 120px; height: 190px; left: 178px; top: 224px;}
    .anniversary-08 .a4 img{left: -68px; top: -31px;}
    .anniversary-09 a{}
    .anniversary-09 .a1{width: 130px; height: 280px; left: 66px; top: -110px;}
    .anniversary-09 .a1 img{left: -69px; top: -4px;}
    .anniversary-09 .a2{width: 90px; height: 170px; left: -42px; top: 150px;}
    .anniversary-09 .a2 img{left: -60px; top: -20px;}
    .anniversary-09 .a3{width: 170px; height: 210px; left: 154px; top: 160px;}
    .anniversary-09 .a3 img{left: -40px; top: -11px;}
    .anniversary-10 .icon-05{
        width: 288px; height: 287px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/icon-05.png) no-repeat;
        position: absolute; left: 0px; top: 0px; display: none;
    }
    .anniversary-10 a{}
    .anniversary-10 .a1{width: 120px; height: 200px; left: 664px; top: 100px;}
    .anniversary-10 .a1 img{left: -69px; top: -25px;}
    .anniversary-10 .a2{width: 100px; height: 200px; left: 870px; top: 260px;}
    .anniversary-10 .a2 img{left: -77px; top: -23px;}
    .anniversary-10 .a3{width: 260px; height: 150px; left: -100px; top: 416px;}
    .anniversary-10 .a3 img{left: -13px; top: -67px;}

    .anniversary-11 .a1{width: 90px; height: 150px; left: 890px; top: -31px;}
    .anniversary-11 .a1 img{left: -60px; top: -29px;}
    .anniversary-11 .a2{width: 160px; height: 190px; left: 120px; top: 164px;}
    .anniversary-11 .a2 img{left: -59px; top: -60px;}
    .anniversary-11 .a3{width: 130px; height: 230px; left: 830px; top: 136px;}
    .anniversary-11 .a3 img{left: -72px; top: -25px;}
    .anniversary-12 .backToTop{
        width: 235px; height: 67px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/anniversary2/backToTop.png) no-repeat;
        left: 400px; top: 250px;
    }


</style>

<div class="zt-wrap">
    <div class="anniversary-01"></div>
    <div class="anniversary-02">
        <div class="zt-con">
            <div class="icon-01"></div>
            <a href="http://www.g-emall.com/JF/72611.html" title="【包邮】五常大米 东北大米 长粒香5KG1袋(另送有机稻花香2.5kg)农场直供" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood1-01.png"></a>
            <a href="http://www.g-emall.com/JF/82022.html" title="包邮【百草味】零食坚果干果 碧根果190gx4袋 美国山核桃长寿果" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood1-02.png"></a>
        </div>
    </div>
    <div class="anniversary-03">
        <div class="zt-con">
            <a href="http://www.g-emall.com/goods/24456.html" title="【美尚美】【赣花】有机认证 野山茶油2L 农家茶籽油 食用油 单瓶平装" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood1-03.png"></a>
            <a href="http://www.g-emall.com/JF/143042.html" title="【康源食品】东阿阿胶 桃花姬 阿胶糕 300g 即食阿胶 固元膏 滋补上品官方直营 正品保障，" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood1-04.png"></a>
            <a href="http://www.g-emall.com/JF/295774.html" title="优选广西桂林特产 金桔5斤装 滑皮金桔香脆小金桔果新鲜水果包邮" class="a3" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood1-05.png"></a>
            <a href="http://www.g-emall.com/JF/103011.html" title="原生态老树六堡茶" class="a4" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood1-06.png"></a>
        </div>
    </div>
    <div class="anniversary-04">
        <div class="zt-con">
            <div class="icon-02"></div>
            <a href="http://www.g-emall.com/JF/72440.html" title="美的蒸汽挂烫机正品特价家用挂式电熨斗熨烫全国联保YGJ15B3" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood2-01.png"></a>
            <a href="http://www.g-emall.com/JF/64206.html" title="九阳豆浆机DJ13B-D58SG" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood2-02.png"></a>
            <a href="http://www.g-emall.com/JF/101805.html" title="电炖锅 电炖盅 隔水炖 煮粥锅 预约定时 一锅四胆 DDG-D658 厂家降价促销 小家电家用电器" class="a3" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood2-03.png"></a>
        </div>
    </div>
    <div class="anniversary-05">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/246474.html" title="飞科FH6651旅行电吹风负离子孕妇吹风机大功率家用冷热折叠吹风筒" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood2-04.png"></a>
            <a href="http://www.g-emall.com/JF/148719.html" title="（飞利浦生活馆）EasySpeed 有尘袋吸尘器 FC5122/81" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood2-05.png"></a>
        </div>
    </div>
    <div class="anniversary-06">
        <div class="zt-con">
            <div class="icon-03"></div>
            <a href="http://www.g-emall.com/JF/268946.html" title="【美的/Midea】美的取暖器小太阳家用NPS10-13A可升降摇头2小时定时、" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood3-01.png"></a>
            <a href="http://www.g-emall.com/JF/87733.html" title="正品包邮 膳魔师THERMOS保温壶桶杯保温饭盒焖烧杯 SK-3000 470ml" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood3-02.png"></a>
            <a href="http://www.g-emall.com/JF/176867.html" title="韩国进口伊诺威车载森林浴机 车载空气净化器 植物杀菌素 芬多精" class="a3" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood3-03.png"></a>
        </div>
    </div>
    <div class="anniversary-07">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/81724.html" title="真体格足浴盆全自动按摩加热电动泡脚盆泡脚足疗机足浴器" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood3-04.png"></a>
            <a href="http://www.g-emall.com/JF/123907.html" title="沁园703净水壶家用厨房净水器自来水过滤器净水杯滤水壶滤水器 正品" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood3-05.png"></a>
        </div>
    </div>
    <div class="anniversary-08">
        <div class="zt-con">
            <div class="icon-04"></div>
            <a href="http://www.g-emall.com/JF/64810.html" title="蓝歌H26S立体声蓝牙耳机 通用型 迷你双耳运动型 无线可听歌 正品" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood4-01.png"></a>
            <a href="http://www.g-emall.com/JF/197659.html" title="倍思手机自拍杆线控自牌杆神器苹果iphone5s 6自拍器后视镜韩国 七天包退 时尚自拍 后置妆镜 正品保证 授权商家" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood4-02.png"></a>
            <a href="http://www.g-emall.com/JF/333216.html" title="超大毛球球加厚针织粗毛线帽韩国秋冬天保暖护耳帽子女韩版新款潮" class="a3" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood4-03.png"></a>
            <a href="http://www.g-emall.com/JF/210663.html" title="【数码之家】索爱智能手表M703 手机可插卡电话儿童蓝牙手环安卓苹果通用版" class="a4" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood4-04.png"></a>
        </div>
    </div>
    <div class="anniversary-09">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/339909.html" title="【初慕】修身无缝美体塑身秋衣套装8002" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood4-05.png"></a>
            <a href="http://www.g-emall.com/JF/161589.html" title="佰仕通 正品手机平板通用迷你充电宝 移动电源12000毫安大容量" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood4-06.png"></a>
            <a href="http://www.g-emall.com/JF/312463.html" title="十字纹真皮女包单肩手提斜挎女士包" class="a3" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood4-07.png"></a>
        </div>
    </div>
    <div class="anniversary-10">
        <div class="zt-con">
            <div class="icon-05"></div>
            <a href="http://www.g-emall.com/JF/56020.html" title="两包包邮 日本原装进口花王妙而舒Merries腰贴式尿不湿纸尿裤L(54片)三倍透气" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood5-01.png"></a>
            <a href="http://www.g-emall.com/JF/13769.html" title="【艾利客】【艾利客】 最新面粉到货！小麦面粉 俄罗斯食品 面粉 饺子粉 馒头粉 原" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood5-02.png"></a>
            <a href="http://www.g-emall.com/JF/172436.html" title="适之宝皇家泰国进口乳胶枕头纯天然按摩成人学生颈椎枕护颈保健枕" class="a3" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood5-03.png"></a>
        </div>
    </div>

    <div class="anniversary-11">
        <div class="zt-con">
            <a href="http://www.g-emall.com/JF/150087.html" title="【康源食品】德国原装进口 莱茵堡低脂纯牛奶1L/盒早餐高营养健康" class="a1" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood5-04.png"></a>
            <a href="http://www.g-emall.com/JF/105323.html" title="【汇购优品】包邮 日本象印 CH-DSH10C 防空烧+保温 电热水壶/电热水瓶 正品包邮 1L   J057" class="a2" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood5-05.png"></a>
            <a href="http://www.g-emall.com/JF/369886.html" title="首席官品牌拉杆箱子 万向轮超轻商务拉链箱20/24/28寸行李箱男女密码箱登机箱男女旅行箱" class="a3" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/anniversary2/hoverGood5-06.png"></a>
        </div>
    </div>
    <div class="anniversary-12">
        <div class="zt-con">
            <a href="javascript:void(0)" class="backToTop"></a>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        var scrollTop = 0;
        $(window).scroll(function(){
            scrollTop = $(document).scrollTop();
            if (scrollTop>=600) {
                $('.icon-01').fadeIn(500).animate({
                    'left':360,
                    'top':30
                },1000);
            }
            if (scrollTop>=1700) {
                $('.icon-02').fadeIn(500).animate({
                    'left':90,
                    'top':20
                },800);
            }
            if (scrollTop>=2700) {
                $('.icon-03').fadeIn(500).animate({
                    'left':482,
                    'top':38
                },800);
            }
            if (scrollTop>=3800) {
                $('.icon-04').fadeIn(500).animate({
                    'left':590,
                    'top':30
                },800);
            }
            if (scrollTop>=4900) {
                $('.icon-05').fadeIn(500).animate({
                    'left':290,
                    'top':20
                },1000);
            }
        })

        $('.zt-con a').hover(function(){
            $(this).find('img').show();
        },function(){
            $(this).find('img').hide();
        })
    });

    /*回到顶部*/
    $(".backToTop").click(function() {
        $('body,html').stop().animate({scrollTop: 0}, 500);
        return false;
    });
</script>