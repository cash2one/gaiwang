<?php $this->pageTitle = "农贸市集_瓜果区_" . $this->pageTitle; ?>
<style type="text/css">
    /*=====
        @Date:2016-05-16
        @content:农贸市集--水果
        @author:林聪毅
     =====*/
    .zt-wrap{width:100%; background:#fff; overflow: hidden;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .farmer-market-4-01{height:168px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-01.jpg) top center no-repeat;}
    .farmer-market-4-02{height:167px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-02.jpg) top center no-repeat;}
    .farmer-market-4-03{height:168px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-03.jpg) top center no-repeat;}
    .farmer-market-4-04{height:167px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-04.jpg) top center no-repeat;}
    .farmer-market-4-05{height:274px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-05.jpg) top center no-repeat;}
    .farmer-market-4-06{height:588px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-06.jpg) top center no-repeat;}
    .farmer-market-4-07{height:308px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-07.jpg) top center no-repeat;}
    .farmer-market-4-08{height:376px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-08.jpg) top center no-repeat;}
    .farmer-market-4-09{height:618px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-09.jpg) top center no-repeat;}
    .farmer-market-4-10{height:247px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-10.jpg) top center no-repeat;}

    .farmer-market-4-11{height:360px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-11.jpg) top center no-repeat;}
    .farmer-market-4-12{height:294px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-12.jpg) top center no-repeat;}
    .farmer-market-4-13{height:294px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-13.jpg) top center no-repeat;}
    .farmer-market-4-14{height:246px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-14.jpg) top center no-repeat;}
    .farmer-market-4-15{height:358px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-15.jpg) top center no-repeat;}
    .farmer-market-4-16{height:304px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-16.jpg) top center no-repeat;}
    .farmer-market-4-17{height:304px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-17.jpg) top center no-repeat;}
    .farmer-market-4-18{height:242px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-18.jpg) top center no-repeat;}
    .farmer-market-4-19{height:352px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-19.jpg) top center no-repeat;}
    .farmer-market-4-20{height:252px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market-4/farmer-market-4-20.jpg) top center no-repeat;}

    .farmer-market-4-05 a{ width:70px; height:144px; top:64px;}
    .farmer-market-4-05 .a1{left:90px; }
    .farmer-market-4-05 .a2{left:226px; }
    .farmer-market-4-05 .a3{left:680px; }
    .farmer-market-4-05 .a4{left:818px; }
    .farmer-market-4-06 a{width: 990px; height: 410px; top: 140px;}
    .farmer-market-4-06 .a1{left: -20px;}
    .farmer-market-4-07 a{width: 470px; height: 270px; top: 20px;}
    .farmer-market-4-07 .a1{left: -20px;}
    .farmer-market-4-07 .a2{left: 500px;}
    .farmer-market-4-08 a{width: 300px; height: 320px; top: 10px;}
    .farmer-market-4-08 .a1{left: 0px;}
    .farmer-market-4-08 .a2{left: 350px;}
    .farmer-market-4-08 .a3{left: 670px;}
    .farmer-market-4-09 a{width: 990px; height: 440px; top: 140px;}
    .farmer-market-4-09 .a1{left: -20px;}
    .farmer-market-4-10 a{width: 500px; height: 210px; top: 10px;}
    .farmer-market-4-10 .a1{left: -30px;}
    .farmer-market-4-10 .a2{left: 500px;}

    .farmer-market-4-11 a{width: 310px; height: 320px; top: 0px;}
    .farmer-market-4-11 .a1{left: -20px;}
    .farmer-market-4-11 .a2{left: 350px;}
    .farmer-market-4-11 .a3{left: 690px;}
    .farmer-market-4-12 a{width: 1030px; height: 440px; top: 130px;}
    .farmer-market-4-12 .a1{left: -30px;}
    .farmer-market-4-14 a{width: 500px; height: 210px; top: 10px;}
    .farmer-market-4-14 .a1{left: -50px;}
    .farmer-market-4-14 .a2{left: 520px;}
    .farmer-market-4-15 a{width: 310px; height: 320px; top: 0px;}
    .farmer-market-4-15 .a1{left: -20px;}
    .farmer-market-4-15 .a2{left: 330px;}
    .farmer-market-4-15 .a3{left: 680px;}
    .farmer-market-4-16 a{width: 1030px; height: 470px; top: 120px;}
    .farmer-market-4-16 .a1{left: -30px;}
    .farmer-market-4-18 a{width: 480px; height: 210px; top: 10px;}
    .farmer-market-4-18 .a1{left: -10px;}
    .farmer-market-4-18 .a2{left: 500px;}
    .farmer-market-4-19 a{width: 310px; height: 270px; top: 20px;}
    .farmer-market-4-19 .a1{left: -20px;}
    .farmer-market-4-19 .a2{left: 330px;}
    .farmer-market-4-19 .a3{left: 680px;}






    .farmer-market-4-20 a{width: 150px; height: 60px; top: 126px;}
    .farmer-market-4-20 .a1{left: 318px;}
    .farmer-market-4-20 .backToTop{left: 494px;}
</style>
<div class="zt-wrap">           
    <div class="farmer-market-4-01"></div>
    <div class="farmer-market-4-02"></div>
    <div class="farmer-market-4-03"></div>
    <div class="farmer-market-4-04"></div>
    <div class="farmer-market-4-05">
        <div class="zt-con">
            <a href="<?php echo Yii::app()->createUrl('zt/site/farmer-market-1')?>" class="a1" target="_blank"></a>
            <a href="<?php echo Yii::app()->createUrl('zt/site/farmer-market-2')?>" class="a2" target="_blank"></a>
            <a href="<?php echo Yii::app()->createUrl('zt/site/farmer-market-3')?>" class="a3" target="_blank"></a>
            <a href="javascript:void(0)" class="a4" target="_blank"></a>
        </div>
    </div>
    <div class="farmer-market-4-06">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>195912)),array('class'=>'a1','title'=> '周大农家庭农场 生鲜果蔬 山竹一份750g','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-4-07">
        <div class="zt-con">                    
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>856305)),array('class'=>'a1','title'=> '【南国屋】海南三亚新奇水果_U20斤_n菠萝蜜_n多省空运包邮_e礼盒装_UID243','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>633286)),array('class'=>'a2','title'=> '海南三亚 红心火龙果 新鲜水果 红肉 3斤大果2-4个 现摘现发 顺丰空运','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-4-08">
        <div class="zt-con">                    
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>877458)),array('class'=>'a1','title'=> '海南三亚特产贵妃芒5斤_红金龙芒果_小贵妃芒果新奇水果_68524','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>881208)),array('class'=>'a2','title'=> '海南特产新鲜榴莲4斤至4.5斤一个顺丰空运包邮 汁多肉甜 水份十足，入口化渣 味美香甜 脆 口感超正赞 新鲜水果 本店只做精品新鲜水果 请放心购买','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>866004)),array('class'=>'a3','title'=> '【特价包邮】新鲜海南木瓜 红心木瓜 8斤装','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-4-09">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>285986)),array('class'=>'a1','title'=> '特级临海蜜桔 5斤装 新鲜水果蜜橘柑橘宫川橘子桔子装包邮','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-4-10">
        <div class="zt-con">                    
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>971758)),array('class'=>'a1','title'=> '四川不知火丑柑5斤_Q丑柑丑橘丑八怪新奇水果国产橘子_UID316','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>756216)),array('class'=>'a2','title'=> '包邮特价 伦晚脐橙 橙子 小果5斤装','target'=> '_blank')) ?>
        </div>
    </div>

    <div class="farmer-market-4-11">
        <div class="zt-con">                    
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>484455)),array('class'=>'a1','title'=> '【包邮】新鲜水果橙子 红肉脐橙正宗秭归血橙12个装','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>297767)),array('class'=>'a2','title'=> '新鲜水果 云南蒙自枇杷果 400g装','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>195907)),array('class'=>'a3','title'=> '周大农家庭农场 生鲜果蔬 石榴一份约750g','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-4-12">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>682688)),array('class'=>'a1','title'=> '烟台苹果栖霞苹果新鲜水果绿色特产红富士苹果5斤优选','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-4-13"></div>
    <div class="farmer-market-4-14">
        <div class="zt-con">                    
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>745407)),array('class'=>'a1','title'=> '【包邮】新疆一级香梨 新鲜水果正宗库尔勒香梨5斤装脆甜梨皮薄多汁','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>406956)),array('class'=>'a2','title'=> '山东特产烟台莱阳梨水果梨贡梨新鲜莱阳梨现货6KG装','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-4-15">
        <div class="zt-con">                    
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>207654)),array('class'=>'a1','title'=> '柒号名品 山东烟台鸭梨香梨梨子新鲜水果老婆梨大头梨4斤','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>284044)),array('class'=>'a2','title'=> '【熟田律色】金艳猕猴桃 黄心 奇异果 水果 30个简易装 全国包邮','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>778590)),array('class'=>'a3','title'=> '现摘云南无籽夏黑葡萄水果新奇黑提黑加仑红提子巨峰红提青提顺丰i_UN海口美兰屹帆咖啡厅百货','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-4-16">
        <div class="zt-con">
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>828075)),array('class'=>'a1','title'=> '【越南进口甜红心木瓜8斤装】 超甜新鲜有机水果番木瓜青木瓜多汁pk海南瓜','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-4-17"></div>
    <div class="farmer-market-4-18">
        <div class="zt-con">                    
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>764748)),array('class'=>'a1','title'=> '泰国进口芒果 5斤装 青皮香芒 玉芒 芒果 象牙芒 青芒 新鲜水果 包邮','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>110789)),array('class'=>'a2','title'=> '进口李子约1斤精品李子新鲜水果','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-4-19">
        <div class="zt-con">                    
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>366533)),array('class'=>'a1','title'=> '新鲜进口水果 泰国迷你小菠萝凤梨 4个真空包装','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>752098)),array('class'=>'a2','title'=> '泰国青柠檬 无籽进口柠檬新鲜水果皮薄多汁原生态时令清香绿柠檬','target'=> '_blank')) ?>
            <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>978747)),array('class'=>'a3','title'=> '新西兰 佳沛 甜心绿果 6粒 猕猴桃 新鲜水果','target'=> '_blank')) ?>
        </div>
    </div>
    <div class="farmer-market-4-20">
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