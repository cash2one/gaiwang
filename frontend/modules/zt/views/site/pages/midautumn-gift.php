<style type="text/css">
 /*=====
    @Date:2015-08-24
    @content:中秋大礼包专题
	@author:张睿
 =====*/
    .zt-wrap{width:100%; z-index:-100; }
    .zt-con {width:1200px; margin:0 auto; position:relative; }
    .zt-con a{position:absolute; display:block; }
    .bg-fixed{background:#041d17 url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/bg-fixed.jpg) top center no-repeat; width:1920px; height:1048px; position:fixed; top:292px; left:50%; margin-left:-960px; z-index:-1; }
    .midautumn-gift-01{height:254px; background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/midautumn-gift-01.png) top center no-repeat; }
    .midautumn-gift-02{height:254px; background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/midautumn-gift-02.png) top center no-repeat; }
    .midautumn-gift-03{height:253px; background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/midautumn-gift-03.png) top center no-repeat; }
    .midautumn-gift-04{height:254px; background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/midautumn-gift-04.png) top center no-repeat; }
    .midautumn-gift-05{height:511px; background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/midautumn-gift-05.png) top center no-repeat; }
    .midautumn-gift-06{height:513px; background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/midautumn-gift-06.png) top center no-repeat; }
    .midautumn-gift-07{height:514px; background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/midautumn-gift-07.png) top center no-repeat; }
    .midautumn-gift-08{height:514px; background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/midautumn-gift-08.png) top center no-repeat; }
    .midautumn-gift-09{height:514px; background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/midautumn-gift-09.png) top center no-repeat; }
    .midautumn-gift-10{height:558px; background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/midautumn-gift-10.png) top center no-repeat; }
    .midautumn-gift-11{height:557px; background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/midautumn-gift-11.png) top center no-repeat; }

    .midautumn-gift-05 a,.midautumn-gift-06 a,.midautumn-gift-07 a{width:222px; height:375px; left:175px; top:66px; }
    .midautumn-gift-05 .a1{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-1.png) 0 0 no-repeat; }
    .midautumn-gift-05 .a2{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-1.png) -222px 0 no-repeat; }
    .midautumn-gift-05 .a3{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-1.png) -444px 0 no-repeat; }

    .midautumn-gift-06 .a1{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-2.png) 0 0 no-repeat; }
    .midautumn-gift-06 .a2{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-2.png) -223px 0 no-repeat; }
    .midautumn-gift-06 .a3{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-2.png) -445px 0 no-repeat; }

    .midautumn-gift-07 .a1{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-3.png) 0 0 no-repeat; }
    .midautumn-gift-07 .a2{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-3.png) -222px 0 no-repeat; }
    .midautumn-gift-07 .a3{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-3.png) -444px 0 no-repeat; }

    .midautumn-gift-08 a,.midautumn-gift-09 a,.midautumn-gift-10 a{width:221px; height:375px; right:180px; top:63px; }
    .midautumn-gift-08 .a1{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-4.png) 0 0 no-repeat; }
    .midautumn-gift-08 .a2{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-4.png) -222px 0 no-repeat; display:none; }
    .midautumn-gift-08 .a3{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-4.png) -444px 0 no-repeat; display:none; }

    .midautumn-gift-09 .a1{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-5.png) 0 0 no-repeat; }
    .midautumn-gift-09 .a2{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-5.png) -222px 0 no-repeat; display:none; }
    .midautumn-gift-09 .a3{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-5.png) -444px 0 no-repeat; display:none; }

    .midautumn-gift-10 .a1{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-6.png) 0 0 no-repeat; }
    .midautumn-gift-10 .a2{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-6.png) -222px 0 no-repeat; display:none; }
    .midautumn-gift-10 .a3{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/mooncake-6.png) -444px 0 no-repeat; display:none; }

    .count-choice{display: none;}
    .count-choice2{width:138px; height:167px; position:absolute; right:31px; top:63px; }
    .count-1{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/count-choice.png) no-repeat -15px -22px; }
    .count-2{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/count-choice.png) no-repeat -153px -23px; }
    .count-3{background:url(<?php echo ATTR_DOMAIN;?>/zt/midautumn-gift/count-choice.png) no-repeat -291px -24px; }
    .count-choice a,.count-choice2 a{width:105px; height:37px; left:7px; }
    .zt-con .b1{top:-1px; }
    .zt-con .b2{top:46px; }
    .zt-con .b3{top:93px; }

    .midautumn-gift-11 a{width:295px; height:337px; top:127px; }
    .midautumn-gift-11 .a1{left:6px; }
    .midautumn-gift-11 .a2{left:303px; }
    .midautumn-gift-11 .a3{right:304px; }
    .midautumn-gift-11 .a4{right:6px; }
</style>

<div class="zt-wrap">
    <div class="bg-fixed"></div>
    <div class="midautumn-gift-01"></div>
    <div class="midautumn-gift-02"></div>
    <div class="midautumn-gift-03"></div>
    <div class="midautumn-gift-04"></div>
    <div class="midautumn-gift-05">
        <div class="zt-con">
            <div class="count-choice count-1">
                <a href="javascript:void(0);" class="b1"></a>
                <a href="javascript:void(0);" class="b2"></a>
                <a href="javascript:void(0);" class="b3"></a>
            </div>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 198567)), array('title' => '【盖网礼献】金装双黄纯白莲蓉  广式员工月礼盒饼糕点', 'class' => 'a1', 'target' => '_blank'))?>
        </div>
    </div>
    <div class="midautumn-gift-06">
        <div class="zt-con">
            <div class="count-choice count-1">
                <a href="javascript:void(0);" class="b1"></a>
                <a href="javascript:void(0);" class="b2"></a>
                <a href="javascript:void(0);" class="b3"></a>
            </div>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 198555)), array('title' => '【盖网礼献】陈皮豆沙月饼礼盒  广式月饼糕点', 'class' => 'a1', 'target' => '_blank'))?>
        </div>
    </div>
    <div class="midautumn-gift-07">
        <div class="zt-con">
            <div class="count-choice count-1">
                <a href="javascript:void(0);" class="b1"></a>
                <a href="javascript:void(0);" class="b2"></a>
                <a href="javascript:void(0);" class="b3"></a>
            </div>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 198578)), array('title' => '【盖网礼献】双黄纯白莲蓉月饼中秋月饼礼盒 广式月饼', 'class' => 'a1', 'target' => '_blank'))?>
        </div>
    </div>
    <div class="midautumn-gift-08">
        <div class="zt-con">
            <div class="count-choice2 count-1">
                <a href="javascript:void(0);" class="b1"></a>
                <a href="javascript:void(0);" class="b2"></a>
                <a href="javascript:void(0);" class="b3"></a>
            </div>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 205097)), array('title' => '盖象中秋大礼包一（5份以下 9.5折）', 'class' => 'a1', 'target' => '_blank'))?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 205250)), array('title' => '盖象中秋大礼包一（5-10份 9折）', 'class' => 'a2', 'target' => '_blank'))?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 205277)), array('title' => '盖象中秋大礼包一（10份以上 8.5折）', 'class' => 'a3', 'target' => '_blank'))?>
        </div>
    </div>
    <div class="midautumn-gift-09">
        <div class="zt-con">
            <div class="count-choice2 count-1">
                <a href="javascript:void(0);" class="b1"></a>
                <a href="javascript:void(0);" class="b2"></a>
                <a href="javascript:void(0);" class="b3"></a>
            </div>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 205283)), array('title' => '盖象中秋大礼包组合二（5份以下 9.5折）', 'class' => 'a1', 'target' => '_blank'))?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 205287)), array('title' => '盖象中秋大礼包组合二（5-10份 9折）', 'class' => 'a2', 'target' => '_blank'))?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 205292)), array('title' => '盖象中秋大礼包组合二（10份以上 8.5折）', 'class' => 'a3', 'target' => '_blank'))?>
        </div>
    </div>
    <div class="midautumn-gift-10">
        <div class="zt-con">
            <div class="count-choice2 count-1">
                <a href="javascript:void(0);" class="b1"></a>
                <a href="javascript:void(0);" class="b2"></a>
                <a href="javascript:void(0);" class="b3"></a>
            </div>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 205297)), array('title' => '盖象中秋大礼包三（5份以下 9.5折）', 'class' => 'a1', 'target' => '_blank'))?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 205301)), array('title' => '盖象中秋大礼包三（5-10份 9折）', 'class' => 'a2', 'target' => '_blank'))?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 205304)), array('title' => '盖象中秋大礼包三（10份以上 8.5折）', 'class' => 'a3', 'target' => '_blank'))?>
        </div>
    </div>
    <div class="midautumn-gift-11">
        <div class="zt-con">
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 144059)), array('title' => '维拉马萨VILLAMASSA 柠檬酒700ml', 'class' => 'a1', 'target' => '_blank'))?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 200366)), array('title' => '【良品铺子】手造麻薯组合1050g 7种口味台湾糕点小吃', 'class' => 'a2', 'target' => '_blank'))?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 144331)), array('title' => '【新农哥】【新农哥_四季平安A套餐】坚果零食炒货端午节礼盒大礼包1948g', 'class' => 'a3', 'target' => '_blank'))?>
            <?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 138959)), array('title' => '【相思莲】相思莲 大礼盒 红糖 百合 莲子 薏米 小香菇 东北黑木耳', 'class' => 'a4', 'target' => '_blank'))?>
        </div>
    </div>
    <script type="text/javascript">
        //本专题js
        $(window).scroll(function(){
            if($(window).scrollTop()<=292){
                var ztTop = $(".zt-wrap").offset().top;
                var topHeight = ztTop-$(window).scrollTop();
                $(".bg-fixed").css("top",topHeight+"px");
            }else if($(window).scrollTop()>292){
                $(".bg-fixed").css("top",0);
            }
        });
        $(".count-choice").find("a").hover(function(){
            var countIndex = $(this).index()+1;
            $(this).parent().attr("class","count-choice count-"+countIndex);
            $(this).parent().next().attr("class","a"+countIndex);
        });
        $(".count-choice2").find("a").hover(function(){
            var countIndex = $(this).index()+1;
            $(this).parent().attr("class","count-choice2 count-"+countIndex);
            $(this).parent().nextAll().css("display","none");
            $(this).parent().nextAll().eq(countIndex-1).css("display","block");
        });

    </script>
</div>