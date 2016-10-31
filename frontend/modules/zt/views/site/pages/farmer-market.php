<?php $this->pageTitle = "盖象商城-农贸市集" ?>
<style>
/*=====
    @Date:2016-05-31
    @content:农贸市集首页
	@author:林聪毅
 =====*/
.zt-wrap{width:100%; background:#fff; overflow: hidden;}
.zt-con { width:968px; margin:0 auto; position:relative; }
.zt-con a{ position:absolute;display:block;}
.farmer-market-01{height:540px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market/farmer-market-01.jpg) top center no-repeat;}
.farmer-market-02{height:270px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market/farmer-market-02.jpg) top center no-repeat;}
.farmer-market-03{height:270px; background:url(<?php echo ATTR_DOMAIN;?>/zt/farmer-market/farmer-market-03.jpg) top center no-repeat;}

.farmer-market-02 a{ width:180px; height:180px; top:38px;}
.farmer-market-02 .a1{left:72px; }
.farmer-market-02 .a2{left:288px; }
.farmer-market-02 .a3{left:506px; }
.farmer-market-02 .a4{left:720px; }

</style>

	<div class="zt-wrap">			
		<div class="farmer-market-01"></div>
		<div class="farmer-market-02">
			<div class="zt-con">					
				 <a href="<?php echo Yii::app()->createUrl('zt/site/farmer-market-1')?>" class="a1" target="_blank"></a>
                 <a href="<?php echo Yii::app()->createUrl('zt/site/farmer-market-2')?>" class="a2" target="_blank"></a>
                 <a href="<?php echo Yii::app()->createUrl('zt/site/farmer-market-3')?>" class="a3" target="_blank"></a>
                 <a href="<?php echo Yii::app()->createUrl('zt/site/farmer-market-4')?>" class="a4" target="_blank"></a>
			</div>
		</div>
		<div class="farmer-market-03"></div>
	</div>   
   <!--------------主体 End------------>