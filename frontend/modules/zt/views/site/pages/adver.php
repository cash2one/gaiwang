<?php $this->pageTitle = "广告位专题" . $this->pageTitle;?>
<style type='text/css'>
	/*=====
	    @Date:2016-04-08
	    @content:广告位秒杀
		@author:林聪毅
	 =====*/
	.zt-wrap{width:100%; background:#fff; overflow: hidden;}
	.zt-con { width:968px; margin:0 auto; position:relative; }
	.zt-con a{ position:absolute;display:block;}
	.adver-01{height:592px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-01.jpg) top center no-repeat;}
	.adver-02{height:442px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-02.jpg) top center no-repeat;}
	.adver-03{height:442px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-03.jpg) top center no-repeat;}
	.adver-04{height:582px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-04.jpg) top center no-repeat;}
	.adver-05{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-05.jpg) top center no-repeat;}
	.adver-06{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-06.jpg) top center no-repeat;}
	.adver-07{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-07.jpg) top center no-repeat;}
	.adver-08{height:456px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-08.jpg) top center no-repeat;}
	.adver-09{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-09.jpg) top center no-repeat;}
	.adver-10{height:454px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-10.jpg) top center no-repeat;}

	.adver-11{height:458px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-11.jpg) top center no-repeat;}
	.adver-12{height:458px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-12.jpg) top center no-repeat;}
	.adver-13{height:456px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-13.jpg) top center no-repeat;}
	.adver-14{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-14.jpg) top center no-repeat;}
	.adver-15{height:250px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-15.jpg) top center no-repeat;}
	.adver-16{height:585px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-16.jpg) top center no-repeat;}
	.adver-17{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-17.jpg) top center no-repeat;}
	.adver-18{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-18.jpg) top center no-repeat;}
	.adver-19{height:458px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-19.jpg) top center no-repeat;}
	.adver-20{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-20.jpg) top center no-repeat;}

	.adver-21{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-21.jpg) top center no-repeat;}
	.adver-22{height:462px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-22.jpg) top center no-repeat;}
	.adver-23{height:458px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-23.jpg) top center no-repeat;}
	.adver-24{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-24.jpg) top center no-repeat;}
	.adver-25{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-25.jpg) top center no-repeat;}
	.adver-26{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-26.jpg) top center no-repeat;}
	.adver-27{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-27.jpg) top center no-repeat;}
	.adver-28{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-28.jpg) top center no-repeat;}
	.adver-29{height:456px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-29.jpg) top center no-repeat;}
	.adver-30{height:922px; background:url(<?php echo ATTR_DOMAIN;?>/zt/adver/adver-30.jpg) top center no-repeat;}

	.adver-04 a{width:294px; height:440px; top:134px;}
	.adver-04 .a1{left:-112px; }
	.adver-04 .a2{left:188px; }
	.adver-04 .a3{left:488px; }
	.adver-04 .a4{left:786px; }
	.adver-05 a{width:294px; height:440px; top:10px;}
	.adver-05 .a1{left:-112px; }
	.adver-05 .a2{left:188px; }
	.adver-05 .a3{left:488px; }
	.adver-05 .a4{left:786px; }
	.adver-06 a{width:294px; height:440px; top:10px;}
	.adver-06 .a1{left:-112px; }
	.adver-06 .a2{left:188px; }
	.adver-06 .a3{left:488px; }
	.adver-06 .a4{left:786px; }
	.adver-07 a{width:294px; height:440px; top:10px;}
	.adver-07 .a1{left:-112px; }
	.adver-07 .a2{left:188px; }
	.adver-07 .a3{left:488px; }
	.adver-07 .a4{left:786px; }
	.adver-08 a{width:294px; height:440px; top:10px;}
	.adver-08 .a1{left:-112px; }
	.adver-08 .a2{left:188px; }
	.adver-08 .a3{left:488px; }
	.adver-08 .a4{left:786px; }
	.adver-09 a{width:294px; height:440px; top:10px;}
	.adver-09 .a1{left:-112px; }
	.adver-09 .a2{left:188px; }
	.adver-09 .a3{left:488px; }
	.adver-09 .a4{left:786px; }
	.adver-10 a{width:294px; height:440px; top:10px;}
	.adver-10 .a1{left:-112px; }
	.adver-10 .a2{left:188px; }
	.adver-10 .a3{left:488px; }
	.adver-10 .a4{left:786px; }

	.adver-11 a{width:294px; height:440px; top:10px;}
	.adver-11 .a1{left:-112px; }
	.adver-11 .a2{left:188px; }
	.adver-11 .a3{left:488px; }
	.adver-11 .a4{left:786px; }
	.adver-12 a{width:294px; height:440px; top:10px;}
	.adver-12 .a1{left:-112px; }
	.adver-12 .a2{left:188px; }
	.adver-12 .a3{left:488px; }
	.adver-12 .a4{left:786px; }
	.adver-13 a{width:294px; height:440px; top:10px;}
	.adver-13 .a1{left:-112px; }
	.adver-13 .a2{left:188px; }
	.adver-13 .a3{left:488px; }
	.adver-13 .a4{left:786px; }
	.adver-14 a{width:294px; height:440px; top:10px;}
	.adver-14 .a1{left:-112px; }
	.adver-14 .a2{left:188px; }
	.adver-14 .a3{left:488px; }
	.adver-14 .a4{left:786px; }
	.adver-15 a{width: 590px; height: 230px; top: 10px;}
	.adver-15 .a1{left: -110px;}
	.adver-15 .a2{left: 490px;}
	.adver-16 a{width:294px; height:440px; top:136px;}
	.adver-16 .a1{left:-112px; }
	.adver-16 .a2{left:188px; }
	.adver-16 .a3{left:488px; }
	.adver-16 .a4{left:786px; }
	.adver-17 a{width:294px; height:440px; top:10px;}
	.adver-17 .a1{left:-112px; }
	.adver-17 .a2{left:188px; }
	.adver-17 .a3{left:488px; }
	.adver-17 .a4{left:786px; }
	.adver-18 a{width:294px; height:440px; top:10px;}
	.adver-18 .a1{left:-112px; }
	.adver-18 .a2{left:188px; }
	.adver-18 .a3{left:488px; }
	.adver-18 .a4{left:786px; }
	.adver-19 a{width:294px; height:440px; top:10px;}
	.adver-19 .a1{left:-112px; }
	.adver-19 .a2{left:188px; }
	.adver-19 .a3{left:488px; }
	.adver-19 .a4{left:786px; }
	.adver-20 a{width:294px; height:440px; top:12px;}
	.adver-20 .a1{left:-112px; }
	.adver-20 .a2{left:188px; }
	.adver-20 .a3{left:488px; }
	.adver-20 .a4{left:786px; }
	.adver-21 a{width:294px; height:440px; top:12px;}
	.adver-21 .a1{left:-112px; }
	.adver-21 .a2{left:188px; }
	.adver-21 .a3{left:488px; }
	.adver-21 .a4{left:786px; }
	.adver-22 a{width:294px; height:440px; top:12px;}
	.adver-22 .a1{left:-112px; }
	.adver-22 .a2{left:188px; }
	.adver-22 .a3{left:488px; }
	.adver-22 .a4{left:786px; }
	.adver-23 a{width:294px; height:440px; top:12px;}
	.adver-23 .a1{left:-112px; }
	.adver-23 .a2{left:188px; }
	.adver-23 .a3{left:488px; }
	.adver-23 .a4{left:786px; }
	.adver-24 a{width:294px; height:440px; top:12px;}
	.adver-24 .a1{left:-112px; }
	.adver-24 .a2{left:188px; }
	.adver-24 .a3{left:488px; }
	.adver-24 .a4{left:786px; }
	.adver-25 a{width:294px; height:440px; top:12px;}
	.adver-25 .a1{left:-112px; }
	.adver-25 .a2{left:188px; }
	.adver-25 .a3{left:488px; }
	.adver-25 .a4{left:786px; }
	.adver-26 a{width:294px; height:440px; top:12px;}
	.adver-26 .a1{left:-112px; }
	.adver-26 .a2{left:188px; }
	.adver-26 .a3{left:488px; }
	.adver-26 .a4{left:786px; }
	.adver-27 a{width:294px; height:440px; top:12px;}
	.adver-27 .a1{left:-112px; }
	.adver-27 .a2{left:188px; }
	.adver-27 .a3{left:488px; }
	.adver-27 .a4{left:786px; }
	.adver-28 a{width:294px; height:440px; top:12px;}
	.adver-28 .a1{left:-112px; }
	.adver-28 .a2{left:188px; }
	.adver-28 .a3{left:488px; }
	.adver-28 .a4{left:786px; }
	.adver-29 a{width: 590px; height: 230px; top: 10px;}
	.adver-29 .a1{left: -110px;}
	.adver-29 .a2{left: 490px;}
	.adver-30 a{width: 400px; height: 270px; top: 580px;}
	.adver-30 .backToTop{left: 300px;}
</style>

	<div class="zt-wrap">			
		<div class="adver-01"></div>
		<div class="adver-02"></div>
		<div class="adver-03"></div>
		<div class="adver-04">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 648408)), array('class' => 'a1', 'title' => 'Banner轮播图（第一屏）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 648443)), array('class' => 'a2', 'title' => 'Banner轮播图（第二屏）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 648466)), array('class' => 'a3', 'title' => 'Banner轮播图（第三屏）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 648496)), array('class' => 'a4', 'title' => 'Banner轮播图（第四屏）', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-05">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 648510)), array('class' => 'a1', 'title' => 'Banner轮播图（第五屏）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 648533)), array('class' => 'a2', 'title' => '副焦点广告（上图右侧）-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 648546)), array('class' => 'a3', 'title' => '副焦点广告（上图右侧）-2', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 648562)), array('class' => 'a4', 'title' => '副焦点广告（上图右侧）-3', 'target' => '_blank')) ?>
			</div>
		</div>
		<div class="adver-06">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 648572)), array('class' => 'a1', 'title' => '发现美食-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 648596)), array('class' => 'a2', 'title' => '发现美食-2', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 648613)), array('class' => 'a3', 'title' => '发现美食-3', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 648625)), array('class' => 'a4', 'title' => '发现美食-4', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-07">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 648642)), array('class' => 'a1', 'title' => '发现美食-5', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649175)), array('class' => 'a2', 'title' => '地方特产左侧广告-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649190)), array('class' => 'a3', 'title' => '地方特产左侧广告-2', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649196)), array('class' => 'a4', 'title' => '地方特产左侧广告-3', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-08">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649206)), array('class' => 'a1', 'title' => '地方特产-右侧商品推荐-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649214)), array('class' => 'a2', 'title' => '地方特产-右侧商品推荐-2', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649224)), array('class' => 'a3', 'title' => '地方特产-右侧商品推荐-3', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649238)), array('class' => 'a4', 'title' => '地方特产-右侧商品推荐-4', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-09">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649250)), array('class' => 'a1', 'title' => '酒饮冲调左侧广告-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649260)), array('class' => 'a2', 'title' => '酒饮冲调-右侧商品推荐-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649267)), array('class' => 'a3', 'title' => '酒饮冲调-右侧商品推荐-2', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649280)), array('class' => 'a4', 'title' => '酒饮冲调-右侧商品推荐-3', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-10">
			<div class="zt-con">	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649286)), array('class' => 'a1', 'title' => '酒饮冲调-右侧商品推荐-4', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649293)), array('class' => 'a2', 'title' => '酒饮冲调-右侧商品推荐-5', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649304)), array('class' => 'a3', 'title' => '酒饮冲调-右侧商品推荐-6', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649313)), array('class' => 'a4', 'title' => '酒饮冲调-右侧商品推荐-7', 'target' => '_blank')) ?>				
			</div>
		</div>

		<div class="adver-11">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649321)), array('class' => 'a1', 'title' => '酒饮冲调-右侧商品推荐-8', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649332)), array('class' => 'a2', 'title' => '粮油调味左侧广告-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649341)), array('class' => 'a3', 'title' => '粮油调味左侧广告-2', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649349)), array('class' => 'a4', 'title' => '粮油调味左侧广告-3', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-12">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649360)), array('class' => 'a1', 'title' => '粮油调味-右侧商品推荐-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649370)), array('class' => 'a2', 'title' => '粮油调味-右侧商品推荐-2', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649380)), array('class' => 'a3', 'title' => '粮油调味-右侧商品推荐-3', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649415)), array('class' => 'a4', 'title' => '粮油调味-右侧商品推荐-4', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-13">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649424)), array('class' => 'a1', 'title' => '休闲食品左侧广告-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649434)), array('class' => 'a2', 'title' => '休闲食品-右侧商品推荐-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649444)), array('class' => 'a3', 'title' => '休闲食品-右侧商品推荐-2', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649455)), array('class' => 'a4', 'title' => '休闲食品-右侧商品推荐-3', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-14">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649465)), array('class' => 'a1', 'title' => '休闲食品-右侧商品推荐-4', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649472)), array('class' => 'a2', 'title' => '休闲食品-右侧商品推荐-5', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649485)), array('class' => 'a3', 'title' => '休闲食品-右侧商品推荐-6', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649492)), array('class' => 'a4', 'title' => '休闲食品-右侧商品推荐-7', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-15">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649502)), array('class' => 'a1', 'title' => '休闲食品-右侧商品推荐-8', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/shop/view', array('id' => 6051)), array('class' => 'a2', 'target' => '_blank')) ?>	
			</div>
		</div>
		<div class="adver-16">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649540)), array('class' => 'a1', 'title' => '手机首页轮播图（第一屏）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649556)), array('class' => 'a2', 'title' => '手机首页轮播图（第二屏）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649566)), array('class' => 'a3', 'title' => '手机首页轮播图（第三屏）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649582)), array('class' => 'a4', 'title' => '手机首页轮播图（第四屏）', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-17">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649588)), array('class' => 'a1', 'title' => '手机首页轮播图（第五屏）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649613)), array('class' => 'a2', 'title' => '副焦点广告（上图右侧）-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649627)), array('class' => 'a3', 'title' => '副焦点广告（上图右侧）-2', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649639)), array('class' => 'a4', 'title' => '副焦点广告（上图右侧）-3', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-18">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649660)), array('class' => 'a1', 'title' => '热门推荐(后台设置首页推荐)-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649672)), array('class' => 'a2', 'title' => '热门推荐(后台设置首页推荐)-2', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649684)), array('class' => 'a3', 'title' => '热门推荐(后台设置首页推荐)-3', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649696)), array('class' => 'a4', 'title' => '热门推荐(后台设置首页推荐)-4', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-19">
			<div class="zt-con">	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649707)), array('class' => 'a1', 'title' => '热门推荐(后台设置首页推荐)-5', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649732)), array('class' => 'a2', 'title' => '手机楼层左上方广告', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649745)), array('class' => 'a3', 'title' => '手机楼层左下方广告', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649759)), array('class' => 'a4', 'title' => '手机楼层中部大广告-（第一屏）', 'target' => '_blank')) ?>				
			</div>
		</div>
		<div class="adver-20">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649768)), array('class' => 'a1', 'title' => '手机楼层中部大广告-（第二屏）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649777)), array('class' => 'a2', 'title' => '手机楼层中部大广告-（第三屏）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649790)), array('class' => 'a3', 'title' => '手机楼层产品-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649805)), array('class' => 'a4', 'title' => '手机楼层产品-2', 'target' => '_blank')) ?>					
			</div>
		</div>

		<div class="adver-21">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649817)), array('class' => 'a1', 'title' => '手机楼层产品-3', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649823)), array('class' => 'a2', 'title' => '手机楼层产品-4', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649830)), array('class' => 'a3', 'title' => '手机楼层产品-5', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649846)), array('class' => 'a4', 'title' => '摄影摄像楼层左上方广告', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-22">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649863)), array('class' => 'a1', 'title' => '摄影摄像楼层中上方广告（第一屏）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649870)), array('class' => 'a2', 'title' => '摄影摄像楼层中上方广告（第二屏）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649880)), array('class' => 'a3', 'title' => '摄影摄像楼层中上方广告（第三屏）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649890)), array('class' => 'a4', 'title' => '摄影摄像楼层右上方广告', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-23">
			<div class="zt-con">	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649903)), array('class' => 'a1', 'title' => '摄影摄像楼层商品-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649920)), array('class' => 'a2', 'title' => '摄影摄像楼层商品-2', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649932)), array('class' => 'a3', 'title' => '摄影摄像楼层商品-3', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649943)), array('class' => 'a4', 'title' => '摄影摄像楼层商品-4', 'target' => '_blank')) ?>				
			</div>
		</div>
		<div class="adver-24">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649949)), array('class' => 'a1', 'title' => '摄影摄像楼层商品-5', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649958)), array('class' => 'a2', 'title' => '手机配件楼层左上方广告', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649975)), array('class' => 'a3', 'title' => '手机配件楼层左下方广告', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649990)), array('class' => 'a4', 'title' => '手机配件楼层中部大广告（第一帧）', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-25">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 649996)), array('class' => 'a1', 'title' => '手机配件楼层中部大广告（第二帧）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650007)), array('class' => 'a2', 'title' => '手机配件楼层中部大广告（第三帧）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650018)), array('class' => 'a3', 'title' => '手机配件商品1-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650032)), array('class' => 'a4', 'title' => '手机配件商品1-2', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-26">
			<div class="zt-con">	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650047)), array('class' => 'a1', 'title' => '手机配件商品1-3', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650061)), array('class' => 'a2', 'title' => '手机配件商品1-4', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650071)), array('class' => 'a3', 'title' => '手机配件商品1-5', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650080)), array('class' => 'a4', 'title' => '数码配件楼层左上方广告', 'target' => '_blank')) ?>				
			</div>
		</div>
		<div class="adver-27">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650088)), array('class' => 'a1', 'title' => '数码配件楼层中上方广告（第一帧）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650105)), array('class' => 'a2', 'title' => '数码配件楼层中上方广告（第二帧）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650116)), array('class' => 'a3', 'title' => '数码配件楼层中上方广告（第三帧）', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650131)), array('class' => 'a4', 'title' => '数码配件楼层右上方广告', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-28">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650142)), array('class' => 'a1', 'title' => '数码配件商品1-1', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650151)), array('class' => 'a2', 'title' => '数码配件商品1-2', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650166)), array('class' => 'a3', 'title' => '数码配件商品1-3', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650184)), array('class' => 'a4', 'title' => '数码配件商品1-4', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-29">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/goods/view', array('id' => 650196)), array('class' => 'a1', 'title' => '数码配件商品1-5', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/shop/view', array('id' => 6051)), array('class' => 'a2',  'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="adver-30">
			<div class="zt-con">					
				<a href="javascript:void(0)" class="backToTop" title=""></a>
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
