<?php $this->pageTitle = "农贸市集_调味区_" . $this->pageTitle; ?>
<style type="text/css">
    /*=====
        @Date:2016-05-16
        @content:农贸市集--调味品区
        @author:林聪毅
     =====*/
    .zt-wrap{width:100%; background:#fff; overflow: hidden;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .farmer-market-2-01{height:334px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-01.jpg) top center no-repeat;}
    .farmer-market-2-02{height:334px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-02.jpg) top center no-repeat;}
    .farmer-market-2-03{height:274px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-03.jpg) top center no-repeat;}
    .farmer-market-2-04{height:552px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-04.jpg) top center no-repeat;}
    .farmer-market-2-05{height:536px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-05.jpg) top center no-repeat;}
    .farmer-market-2-06{height:536px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-06.jpg) top center no-repeat;}
    .farmer-market-2-07{height:592px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-07.jpg) top center no-repeat;}
    .farmer-market-2-08{height:267px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-08.jpg) top center no-repeat;}
    .farmer-market-2-09{height:267px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-09.jpg) top center no-repeat;}
    .farmer-market-2-10{height:268px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-10.jpg) top center no-repeat;}

    .farmer-market-2-11{height:268px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-11.jpg) top center no-repeat;}
    .farmer-market-2-12{height:312px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-12.jpg) top center no-repeat;}
    .farmer-market-2-13{height:312px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-13.jpg) top center no-repeat;}
    .farmer-market-2-14{height:269px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-14.jpg) top center no-repeat;}
    .farmer-market-2-15{height:269px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-15.jpg) top center no-repeat;}
    .farmer-market-2-16{height:269px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-16.jpg) top center no-repeat;}
    .farmer-market-2-17{height:269px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-17.jpg) top center no-repeat;}
    .farmer-market-2-18{height:574px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-18.jpg) top center no-repeat;}
    .farmer-market-2-19{height:269px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-19.jpg) top center no-repeat;}
    .farmer-market-2-20{height:269px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-20.jpg) top center no-repeat;}

    .farmer-market-2-21{height:269px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-21.jpg) top center no-repeat;}
    .farmer-market-2-22{height:269px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-22.jpg) top center no-repeat;}
    .farmer-market-2-23{height:222px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-23.jpg) top center no-repeat;}
    .farmer-market-2-24{height:222px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-24.jpg) top center no-repeat;}
    .farmer-market-2-25{height:222px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-25.jpg) top center no-repeat;}
    .farmer-market-2-26{height:222px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-26.jpg) top center no-repeat;}
    .farmer-market-2-27{height:250px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-2/farmer-market-2-27.jpg) top center no-repeat;}

    .farmer-market-2-03 a{ width:70px; height:144px; top:64px;}
    .farmer-market-2-03 .a1{left:90px; }
    .farmer-market-2-03 .a2{left:226px; }
    .farmer-market-2-03 .a3{left:680px; }
    .farmer-market-2-03 .a4{left:818px; }
    .farmer-market-2-04 a{width: 1070px; height: 530px; top: 26px;}
    .farmer-market-2-04 .a1{left: -50px;}
    .farmer-market-2-05 a{width: 520px; height: 520px; top: 16px;}
    .farmer-market-2-05 .a1{left: -46px;}
    .farmer-market-2-05 .a2{left: 498px;}
    .farmer-market-2-06 a{width: 520px; height: 520px; top: 16px;}
    .farmer-market-2-06 .a1{left: -46px;}
    .farmer-market-2-06 .a2{left: 498px;}
    .farmer-market-2-07 a{width: 1070px; height: 566px; top: 26px;}
    .farmer-market-2-07 .a1{left: -50px;}
    .farmer-market-2-08 a{width: 520px; height: 520px; top: 16px;}
    .farmer-market-2-08 .a1{left: -46px;}
    .farmer-market-2-08 .a2{left: 498px;}
    .farmer-market-2-10 a{width: 520px; height: 520px; top: 16px;}
    .farmer-market-2-10 .a1{left: -46px;}
    .farmer-market-2-10 .a2{left: 498px;}

    .farmer-market-2-12 a{width: 1070px; height: 566px; top: 58px;}
    .farmer-market-2-12 .a1{left: -50px;}
    .farmer-market-2-14 a{width: 520px; height: 520px; top: 20px;}
    .farmer-market-2-14 .a1{left: -46px;}
    .farmer-market-2-14 .a2{left: 498px;}
    .farmer-market-2-16 a{width: 520px; height: 520px; top: 18px;}
    .farmer-market-2-16 .a1{left: -46px;}
    .farmer-market-2-16 .a2{left: 498px;}
    .farmer-market-2-18 a{width: 1070px; height: 566px; top: 58px;}
    .farmer-market-2-18 .a1{left: -50px;}
    .farmer-market-2-19 a{width: 520px; height: 520px; top: 20px;}
    .farmer-market-2-19 .a1{left: -46px;}
    .farmer-market-2-19 .a2{left: 498px;}

    .farmer-market-2-21 a{width: 520px; height: 520px; top: 18px;}
    .farmer-market-2-21 .a1{left: -46px;}
    .farmer-market-2-21 .a2{left: 498px;}
    .farmer-market-2-23 a{width: 480px; height: 710px; top: 90px;}
    .farmer-market-2-23 .a1{left: -20px;}
    .farmer-market-2-23 .a2{left: 510px;}
    .farmer-market-2-27 a{width: 150px; height: 60px; top: 122px;}
    .farmer-market-2-27 .a1{left: 328px;}
    .farmer-market-2-27 .backToTop{left: 504px;}
</style>
<div class="zt-wrap">           
    <div class="farmer-market-2-01"></div>
    <div class="farmer-market-2-02"></div>
    <div class="farmer-market-2-03">
        <div class="zt-con">
            <a href="<?php echo Yii::app()->createUrl('zt/site/farmer-market-1')?>" class="a1" target="_blank"></a>
            <a href="javascript:void(0)" class="a2" target="_blank"></a>
            <a href="<?php echo Yii::app()->createUrl('zt/site/farmer-market-3')?>" class="a3" target="_blank"></a>
            <a href="<?php echo Yii::app()->createUrl('zt/site/farmer-market-4')?>" class="a4" target="_blank"></a>
        </div>
    </div>
    <div class="farmer-market-2-04">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>932036)),array('class'=>'a1','title'=> '广西巴马山茶油 物理压榨油一级茶籽油帝瑶1.8l*2瓶食用油','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-2-05">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>944683)),array('class'=>'a1','title'=> '【沈郎乡】【有机山茶油】山茶油 2L 低温冷榨 纯天然 有机认证产品 油 食用油 有机油 油茶重点企业 6935685200015','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>793611)),array('class'=>'a2','title'=> '(包邮)【胡姬花花生油5L】古法小榨  非转基因 纯正花生油','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-2-06">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>685957)),array('class'=>'a1','title'=> '【鲁花】5S压榨一级花生油4L 一级品质 食用油','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>355995)),array('class'=>'a2','title'=> '【五月食品】食用油 悦生合非转基因一级压榨 农家自产风味5L*2桶 花生油','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-2-07">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>908556)),array('class'=>'a1','title'=> '包邮！小肥羊火锅底料清汤火锅料160g 液态并非粉状 百味火锅','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-2-08">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>908271)),array('class'=>'a1','title'=> '四川清汤火锅底料 120g养生菌汤料三鲜汤底料 火锅店专用调味品','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>806391)),array('class'=>'a2','title'=> '泰国进口丽尔泰冬荫功酱1KG春季火锅底料冬阴功汤调味品多省包邮','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-2-09"></div>
    <div class="farmer-market-2-10">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>528718)),array('class'=>'a1','title'=> '椒之焰清油火锅底料350克无渣火锅底料麻辣火锅料成都味道','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>503892)),array('class'=>'a2','title'=> '【创代推荐】正宗重庆特产德庄清油青一色火锅底料300g克绿藤椒麻辣','target'=> '_blank')) ?>
        </div>
    </div>

    <div class="farmer-market-2-11"></div>
    <div class="farmer-market-2-12">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>875229)),array('class'=>'a1','title'=> '老恒和调味品年货礼盒装 酿造酱油米醋料酒大礼包 年货礼品','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-2-13"></div>
    <div class="farmer-market-2-14">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>862025)),array('class'=>'a1','title'=> '厨房调味料组合套餐 鲍鱼汁/浓缩鸡汁/番茄酱/豆捞酱油 【4瓶装】','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>847439)),array('class'=>'a2','title'=> '【吃货·大食堂】3000g厨邦天然鲜调味品礼盒装 酱油辣酱蚝油鸡粉5份产品组合 送礼套装','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-2-15"></div>
    <div class="farmer-market-2-16">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>731982)),array('class'=>'a1','title'=> '【送2瓶180天】千禾有机酱油食醋东坡红特级老抽15°糯米料酒套装i_UID224','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>180445)),array('class'=>'a2','title'=> '台湾进口酱油 瑞春酱油五虎酱5瓶装 西螺名产 调味调料厨房佐餐','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-2-17"></div>
    <div class="farmer-market-2-18">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>915602)),array('class'=>'a1','title'=> '海南特产黄灯笼辣椒酱/金永丰150g灯笼辣椒酱/辣椒酱/厨房调味酱','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-2-19">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>891341)),array('class'=>'a1','title'=> '吉喷鼻香居下饭豆豉四川特产喷鼻香辣椒酱下饭酱拌面酱菜调料210g*2f_UID345','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>233614)),array('class'=>'a2','title'=> '4袋包邮四川特产 成都巧酿坊郫县豆瓣酱1公斤辣椒酱川菜之魂调料','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-2-20"></div>

    <div class="farmer-market-2-21">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>399200)),array('class'=>'a1','title'=> '【创代推荐】东北特产 香其豆瓣酱600g 黄豆酱 大豆酱','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>885302)),array('class'=>'a2','title'=> '大山合五香香菇酱210g 下饭菜香辣酱 菌菇蘑菇酱 拌饭拌面伴侣','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-2-22"></div>
    <div class="farmer-market-2-23">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>861928)),array('class'=>'a1','title'=> '烧烤调料组合套装 辣椒粉 烧烤粉 孜然粉 椒盐粉 五香粉 100g*5包','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>861906)),array('class'=>'a2','title'=> '户外烧烤调料组合套餐 辣椒粉孜然粉椒盐粉五香粉芝麻 5瓶装','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-2-24"></div>
    <div class="farmer-market-2-25"></div>
    <div class="farmer-market-2-26"></div>
    <div class="farmer-market-2-27">
        <div class="zt-con">                    
            <a href="<?php echo Yii::app()->createUrl('zt/site/farmer-market')?>" class="a1"></a>
            <a href="javascript:void(0)" class="backToTop"></a>
        </div>
    </div>
</div>  
<!-- 返回顶部 end-->
<script type="text/javascript">
$(function(){
    /*回到顶部*/
    $("#backTop,.backToTop").click(function() {
        $('body,html').stop().animate({scrollTop: 0}, 500);
        return false;
    });
})
</script>