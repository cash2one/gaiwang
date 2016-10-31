<?php $this->pageTitle = "冬季清洁战活动_" . $this->pageTitle;?>
<style type="text/css">
    /*=====
    @Date:2015-12-17
    @content:冬季清洁战活动
	@author:林聪毅
 =====*/
    .hide{display: none;}
    .zt-wrap{width:100%; background:#fff; overflow: hidden;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .cleaning-01{height:572px; background:url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/cleaning-01.jpg) top center no-repeat;}
    .cleaning-02{height:571px; background:url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/cleaning-02.jpg) top center no-repeat;}
    .cleaning-03,.cleaning-08{position: relative;}

    .fixedBackground{width: 100%; height: 980px; background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/fixedBackground.jpg) no-repeat;}
    .bg1{position: fixed; top: 0px; left: 0px;}
    .bg2,.bg3{position: absolute; top: 0px; left: 0px;}
    .bg3{top: 636px;}

    .cleaning-01 .foo-01{
        width: 318px; height: 465px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/2.png) no-repeat;
        position: absolute; left: 10px; top: 180px;
    }
    .cleaning-01 .foo-02{
        width: 64px; height: 360px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/1.png) no-repeat;
        position: absolute; left: 530px; top: 60px;
    }
    .cleaning-01 .foo-03{
        width: 385px; height: 472px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/5.png) no-repeat;
        position: absolute; left: 610px; top: 130px;
    }
    .cleaning-01 .goods{
        width: 196px; height: 168px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/goods.jpg) no-repeat;
        position: absolute; left: -180px; top: 210px;
    }
    .cleaning-01 .titlePic{
        width: 421px; height: 111px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/title.png) no-repeat;
        position: absolute; left: 180px; top: 370px; z-index: 2;
    }
    .cleaning-02 a{width: 130px; height: 176px;}
    .cleaning-02 .a1{left: -130px; top: 170px; background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/navIcon-01.png) no-repeat;}
    .cleaning-02 .a2{left: 40px; top: 260px; background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/navIcon-02.png) no-repeat;}
    .cleaning-02 .a3{left: 240px; top: 250px; background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/navIcon-03.png) no-repeat;}
    .cleaning-02 .a4{left: 540px; top: 220px; background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/navIcon-04.png) no-repeat;}
    .cleaning-02 .a5{left: 740px; top: 190px; background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/navIcon-05.png) no-repeat;}
    .cleaning-02 .a6{left: 940px; top: 260px; background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/navIcon-06.png) no-repeat;}
    .cleaning-03 .part1{
        width: 988px; height: 939px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/part1.png) no-repeat; position: relative;
    }
    .cleaning-03 a{}
    .cleaning-03 .a1{width: 360px; height: 300px; left: 120px; top: 106px;}
    .cleaning-03 .a2{width: 360px; height: 270px; left: 530px; top: 134px;}
    .cleaning-03 .a3{width: 300px; height: 360px; left: 114px; top: 444px;}
    .cleaning-03 .a4{width: 360px; height: 350px; left: 504px; top: 494px;}
    .cleaning-04 .part2{
        width: 1049px; height: 1564px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/part2.png) no-repeat; position: relative;
    }
    .cleaning-04 a{width: 260px; height: 120px;}
    .cleaning-04 .a1{left: 180px; top: 320px;}
    .cleaning-04 .a2{left: 650px; top: 420px;}
    .cleaning-04 .a3{left: 100px; top: 660px;}
    .cleaning-04 .a4{left: 500px; top: 716px;}
    .cleaning-04 .a5{left: 100px; top: 970px;}
    .cleaning-04 .a6{left: 640px; top: 1150px;}
    .cleaning-04 .a7{left: 240px; top: 1280px;}
    .cleaning-05 .part3{
        width: 1219px; height: 712px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/part3.png) no-repeat; position: relative;
    }
    .cleaning-05 a{}
    .cleaning-05 .a1{width: 460px; height: 380px; left: 440px; top: 30px; z-index: 2;}
    .cleaning-05 .a2{width: 420px; height: 320px; left: 60px; top: 310px;}
    .cleaning-05 .a3{width: 350px; height: 300px; left: 610px; top: 376px; z-index: 3;}
    .cleaning-06 .part4{
        width: 1065px; height: 759px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/part4.png) no-repeat; position: relative;
    }
    .cleaning-06 a{}
    .cleaning-06 .a1{width: 370px; height: 170px; left: 190px; top: 260px;}
    .cleaning-06 .a2{width: 370px; height: 270px; left: 610px; top: 200px;}
    .cleaning-06 .a3{width: 400px; height: 280px; left: 120px; top: 444px;}
    .cleaning-06 .a4{width: 300px; height: 210px; left: 560px; top: 490px;}
    .cleaning-07 .part5{
        width: 1057px; height: 1106px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/part5.png) no-repeat; position: relative;
    }
    .cleaning-07 a{}
    .cleaning-07 .a1{width: 350px; height: 260px; left: 80px; top: 220px; z-index: 3;}
    .cleaning-07 .a2{width: 190px; height: 110px; left: 420px; top: 270px;}
    .cleaning-07 .a3{width: 270px; height: 320px; left: 690px; top: 290px;}
    .cleaning-07 .a4{width: 290px; height: 110px; left: 400px; top: 400px; z-index: 2;}
    .cleaning-07 .a5{width: 490px; height: 280px; left: 190px; top: 490px;}
    .cleaning-07 .a6{width: 550px; height: 200px; left: 90px; top: 790px}
    .cleaning-08 .part6{
        width: 1227px; height: 1616px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/part6.png) no-repeat; position: relative; left: -160px;
    }
    .cleaning-08 a{}
    .cleaning-08 .a1{width: 370px; height: 260px; left: 200px; top: 230px;}
    .cleaning-08 .a2{width: 400px; height: 260px; left: 670px; top: 250px;}
    .cleaning-08 .a3{width: 410px; height: 290px; left: 210px; top: 480px;}
    .cleaning-08 .a4{width: 360px; height: 260px; left: 690px; top: 500px;}
    .cleaning-08 .a5{width: 450px; height: 220px; left: 160px; top: 780px;}
    .cleaning-08 .a6{width: 500px; height: 180px; left: 630px; top: 810px;}
    .cleaning-08 .a7{width: 600px; height: 210px; left: 340px; top: 1000px;}
    .cleaning-08 .zt-end{
        width: 100%; height: 290px;
        background: url(<?php echo ATTR_DOMAIN;?>/zt/cleaning/zt-end.png) top center no-repeat;
        position: absolute; top: 1326px;
    }
    .backToTop{
        width: 100%; height: 140px; display: block;
        position: absolute; left: 0px; top: 150px;
    }

    .mg40{margin: 40px 0px;}
    .mgt0{margin-top: 0px;}
    .mgb0{margin-bottom: 0px;}

    .foo-01{
        animation:onMove1 1s ease-in-out 1;
        -moz-animation:onMove1 1s ease-in-out 1;
        -webkit-animation:onMove1 1s ease-in-out 1;
        -ms-animation:onMove1 1s ease-in-out 1;
        -o-animation:onMove1 1s ease-in-out 1;
    }
    .foo-02{
        animation:onMove1 1.5s ease-in-out 1;
        -moz-animation:onMove1 1.5s ease-in-out 1;
        -webkit-animation:onMove1 1.5s ease-in-out 1;
        -ms-animation:onMove1 1.5s ease-in-out 1;
        -o-animation:onMove1 1.5s ease-in-out 1;
    }
    .foo-03{
        animation:onMove1 2s ease-in-out 1;
        -moz-animation:onMove1 2s ease-in-out 1;
        -webkit-animation:onMove1 2s ease-in-out 1;
        -ms-animation:onMove1 2s ease-in-out 1;
        -o-animation:onMove1 2s ease-in-out 1;
    }
    @-webkit-keyframes onMove1 {
        0% 	{-webkit-transform: translateY(-650px)}
        70% {-webkit-transform: translateY(0px)}
        85% {-webkit-transform: translateY(-60px)}
        100%{-webkit-transform: translateY(0px)}
    }
    @-moz-keyframes onMove1 {
        0% 	{-moz-transform: translateY(-650px)}
        70% {-moz-transform: translateY(0px)}
        85% {-moz-transform: translateY(-60px)}
        100%{-moz-transform: translateY(0px)}
    }
    @-ms-keyframes onMove1 {
        0% 	{-ms-transform: translateY(-650px)}
        70% {-ms-transform: translateY(0px)}
        85% {-ms-transform: translateY(-60px)}
        100%{-ms-transform: translateY(0px)}
    }
    @-o-keyframes onMove1 {
        0% 	{-o-transform: translateY(-650px)}
        70% {-o-transform: translateY(0px)}
        85% {-o-transform: translateY(-60px)}
        100%{-o-transform: translateY(0px)}
    }
    .navIcon{
        animation:onMove2 2s ease-in-out infinite;
        -moz-animation:onMove2 2s ease-in-out infinite;
        -webkit-animation:onMove2 2s ease-in-out infinite;
        -ms-animation:onMove2 2s ease-in-out infinite;
        -o-animation:onMove2 2s ease-in-out infinite;
    }
    @-webkit-keyframes onMove2 {
        0% 	{-webkit-transform: translateY(-10px)}
        50% {-webkit-transform: translateY(10px)}
        100%{-webkit-transform: translateY(-10px)}
    }
    @-moz-keyframes onMove2 {
        0% 	{-moz-transform: translateY(-10px)}
        50% {-moz-transform: translateY(10px)}
        100%{-moz-transform: translateY(-10px)}
    }
    @-ms-keyframes onMove2 {
        0% 	{-ms-transform: translateY(-10px)}
        50% {-ms-transform: translateY(10px)}
        100%{-ms-transform: translateY(-10px)}
    }
    @-o-keyframes onMove2 {
        0% 	{-o-transform: translateY(-10px)}
        50% {-o-transform: translateY(10px)}
        100%{-o-transform: translateY(-10px)}
    }
</style>

<div class="zt-wrap">
    <div class="cleaning-01">
        <div class="zt-con">
            <div class="foo-01"></div>
            <div class="foo-02"></div>
            <div class="foo-03"></div>
            <div class="goods"></div>
            <div class="titlePic"></div>
        </div>
    </div>
    <div class="cleaning-02">
        <div class="zt-con">
            <a href="#part1" class="a1 navIcon"></a>
            <a href="#part2" class="a2 navIcon"></a>
            <a href="#part3" class="a3 navIcon"></a>
            <a href="#part4" class="a4 navIcon"></a>
            <a href="#part5" class="a5 navIcon"></a>
            <a href="#part6" class="a6 navIcon"></a>
        </div>
    </div>
    <div class="fixedBackground bg1 hide"></div>
    <div class="cleaning-03 mg40 mgt0" id="part1">
        <div class="fixedBackground bg2"></div>
        <div class="zt-con">
            <div class="part1">
                <a href="http://www.g-emall.com/JF/162871.html" title="绣川高级树脂扫把簸箕套装 软毛笤帚畚箕套扫 魔术扫帚畚斗组合" class="a1" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/59445.html" title="【全场包邮】美丽雅 蓝旋风甩水地拖 HC050624" class="a2" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/148719.html" title="（飞利浦生活馆）EasySpeed 有尘袋吸尘器 FC5122/81" class="a3" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/330335.html" title="惠而浦蒸汽清洁机DT60（紫） 清洁机 地拖  杀菌 除螨 健康" class="a4" target="_blank"></a>
            </div>
        </div>
    </div>
    <div class="cleaning-04 mg40" id="part2">
        <div class="zt-con">
            <div class="part2">
                <a href="http://www.g-emall.com/JF/223598.html" title="贝乐洗碗布不沾油洗碗海绵百洁布神奇抹布厨房刷碗菜瓜布1片汉芬" class="a1" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/240946.html" title="可爱韩国挂式公主裙子擦手巾毛巾珊瑚绒厨房抹布加厚吸水创意包邮" class="a2" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/165632.html" title="威猛先生厨房重油污净双包装 500+500ml" class="a3" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/163187.html" title="妙洁 天然橡胶厚绒加长型保暖手套 均码" class="a4" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/187376.html" title="威露士妈妈壹选洗洁精护手配方1kgx3+洗手液" class="a5" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/165637.html" title="威猛先生（Mr Muscle） 高效净油啫哩 青柠香双包装 500g*2" class="a6" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/187389.html" title="蓝月亮 茶清洗洁精1kg*2瓶 绿茶精华 强力去油 温和不伤手 无残留" class="a7" target="_blank"></a>
            </div>
        </div>
    </div>
    <div class="cleaning-05 mg40" id="part3">
        <div class="zt-con">
            <div class="part3">
                <a href="http://www.g-emall.com/JF/156445.html" title="JSK玻璃清洁剂 家用擦玻璃水净亮水超强去污玻璃清洗液 450ml" class="a1" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/280800.html" title="世家双面擦窗器磁力擦玻璃器清洁刮窗器双层中空玻璃擦窗工具" class="a2" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/160186.html" title="bio-D泊欧涤英国进口家庭清洁去污天然玻璃及镜面清洁剂 500mL/瓶" class="a3" target="_blank"></a>
            </div>
        </div>
    </div>
    <div class="cleaning-06 mg40" id="part4">
        <div class="zt-con">
            <div class="part4">
                <a href="http://www.g-emall.com/JF/165597.html" title="威猛先生洁厕宝自动冲洗洁厕块四块装 清新青柠檬" class="a1" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/156454.html" title="JSK生物卫宝 马桶洁厕液洁厕剂瓷砖洗手盆清洁液洁厕灵洁厕宝 450ml" class="a2" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/165600.html" title="威猛先生强效洁厕液双包装500gx2" class="a3" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/59480.html" title="【全场包邮】马桶厕刷" class="a4" target="_blank"></a>
            </div>
        </div>
    </div>
    <div class="cleaning-07 mg40" id="part5">
        <div class="zt-con">
            <div class="part5">
                <a href="http://www.g-emall.com/JF/330193.html" title="小狗D-601除螨仪家用紫外线吸尘器床上杀菌床铺除螨虫小型除螨机" class="a1" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/330193.html" title="小狗D-601除螨仪家用紫外线吸尘器床上杀菌床铺除螨虫小型除螨机" class="a2" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/269791.html" title="UYEKI日本除螨剂专业除螨虫喷剂去螨喷雾剂床上杀螨虫菌防螨黄瓶" class="a3" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/269791.html" title="UYEKI日本除螨剂专业除螨虫喷剂去螨喷雾剂床上杀螨虫菌防螨黄瓶" class="a4" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/284164.html" title="Walch/威露士消毒液衣物除菌液香柠气息1.6Lx2衣物清洁" class="a5" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/265435.html" title="【珈琪】Bad Air Sponge 空气净化剂 去甲醛 空气净化 优化生活" class="a6" target="_blank"></a>
            </div>
        </div>
    </div>
    <div class="cleaning-08 mg40 mgb0" id="part6">
        <div class="fixedBackground bg3"></div>
        <div class="zt-con">
            <div class="part6">
                <a href="http://www.g-emall.com/JF/275855.html" title="【珈琪】Sandokkaebi洗衣机槽清洗剂 内缸筒内去污清洁消毒粉 山鬼洗衣机清洗剂450g  绝对正品 良心品质" class="a1" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/150660.html" title="蓝月亮 洁净洗衣液-薰衣草 2kg/瓶 本色" class="a2" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/187476.html" title="【买一瓶送一瓶】超能植翠低泡洗衣液2.5kg*2瓶装 超值10斤装正品" class="a3" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/156203.html" title="JSK内衣内裤洗衣液专用手洗内衣杀菌消毒洗液洗涤液清洗液 450ml" class="a4" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/187625.html" title="超能天然皂粉洗衣粉2.258kg*2袋 天然椰子油生产 泡沫少易漂清 馨香柔软 低泡易漂 专为高档 织物设计" class="a5" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/188953.html" title="薇姿otbaby婴儿紫叶草柔软洗衣皂 宝宝用抗菌BB皂无磷200g*4块 4块包装 婴幼儿洗衣皂" class="a6" target="_blank"></a>
                <a href="http://www.g-emall.com/JF/156448.html" title="JSK生物衣物柔顺剂 衣物护理清香抗静电 衣服衣物护理液 柔软剂  750ml" class="a7" target="_blank"></a>
            </div>
        </div>
        <div class="zt-end">
            <a href="javascript:void(0)" class="backToTop"></a>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        var scrollTop = 0;
        $(window).scroll(function(){
            scrollTop = $(document).scrollTop();
            if(scrollTop>=1500&&scrollTop<=7300){
                $('.bg1').show();
                $('.bg2,.bg3').hide();
            }
            else{
                $('.bg2,.bg3').show();
                $('.bg1').hide();
            }
        })
        $('.cleaning-02 a').hover(function(){
            $(this).toggleClass('navIcon');
        },function(){
            $(this).toggleClass('navIcon');
        })
    });

    /*回到顶部*/
    $(".backToTop").click(function() {
        $('body,html').stop().animate({scrollTop: 0}, 500);
        return false;
    });
</script>