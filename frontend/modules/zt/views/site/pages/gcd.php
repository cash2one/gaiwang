<?php $this->pageTitle = "滚床单专题" . $this->pageTitle;?>
<style type='text/css'>
	/*=====
	    @Date:2016-04-12
	    @content:滚床单
		@author:林聪毅
	 =====*/
	.zt-wrap{width:100%; background:#fff; overflow: hidden;}
	.zt-con { width:968px; margin:0 auto; position:relative; }
	.zt-con a{ position:absolute;display:block;}
	.gcd-01{height:404px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gcd/gcd-01.jpg) top center no-repeat;}
	.gcd-02{height:402px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gcd/gcd-02.jpg) top center no-repeat;}
	.gcd-03{height:295px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gcd/gcd-03.jpg) top center no-repeat;}
	.gcd-04{height:294px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gcd/gcd-04.jpg) top center no-repeat;}
	.gcd-05{height:295px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gcd/gcd-05.jpg) top center no-repeat;}
	.gcd-06{height:312px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gcd/gcd-06.jpg) top center no-repeat;}
	.gcd-07{height:398px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gcd/gcd-07.jpg) top center no-repeat;}
	.gcd-08{height:453px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gcd/gcd-08.jpg) top center no-repeat;}
	.gcd-09{height:451px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gcd/gcd-09.jpg) top center no-repeat;}
	.gcd-10{height:453px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gcd/gcd-10.jpg) top center no-repeat;}

	.gcd-11{height:453px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gcd/gcd-11.jpg) top center no-repeat;}
	.gcd-12{height:429px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gcd/gcd-12.jpg) top center no-repeat;}
	.gcd-13{height:428px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gcd/gcd-13.jpg) top center no-repeat;}
	.gcd-14{height:404px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gcd/gcd-14.jpg) top center no-repeat;}
	.gcd-15{height:404px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gcd/gcd-15.jpg) top center no-repeat;}

	.gcd-04 a{}
	.gcd-04 .a1{width: 346px; height: 540px; left: -14px; top: 26px;}
	.gcd-04 .a2{width:320px; height:270px; left:659px; top:25px;}
	.gcd-04 .a2:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/gcd/hoverBg-01.png) no-repeat; background-position: 14px 30px;}
	.gcd-05 a{ width:320px; height:270px; top:3px;}
	.gcd-05 .a1{left:334px;}
	.gcd-05 .a1:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/gcd/hoverBg-02.png) no-repeat; background-position: 14px 30px;}
	.gcd-05 .a2{left:659px;}
	.gcd-05 .a2:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/gcd/hoverBg-03.png) no-repeat; background-position: 14px 30px;}
	.gcd-06 a{width: 330px; height: 500px; top: 20px;}
	.gcd-06 .a1{left: -10px;}
	.gcd-06 .a2{left: 320px;}
	.gcd-06 .a3{left: 650px;}
	.gcd-08 a{width: 454px; height: 610px; top: 290px;}
	.gcd-08 .a1{left: 22px;}
	.gcd-08 .a2{left: 490px;}
	.gcd-10 a{width: 454px; height: 610px; top: 6px;}
	.gcd-10 .a1{left: 22px;}
	.gcd-10 .a2{left: 490px;}

	.gcd-12 a{width: 454px; height: 610px; top: 232px;}
	.gcd-12 .a1{left: 22px;}
	.gcd-12 .a2{left: 490px;}
	.gcd-14 a{width: 454px; height: 610px; top: -4px;}
	.gcd-14 .a1{left: 22px;}
	.gcd-14 .a2{left: 490px;}
</style>
<script type="text/javascript">
	$(function(){
		/*头部广告位关闭*/
		$("#topBanner .close").click(function(){
			$("#topBanner").hide();
		})
		/*购物车列表*/	
		$('#myCart').hover(function(){
			$(this).find('.cartList').show();
		},function(){
			$(this).find('.cartList').delay(3000).hide();
		});
		/*菜单*/
		$("#allMenu").hover(function(){
			$("#menuList02").css('display','block');
		},function(){
			$("#menuList02").css('display','none');
		})
		$("#menuList02").hover(function(){
			$(this).css('display','block');
		},function(){
			$(this).css('display','none');
		})
		
		/*底部友情连接显示更多*/
		$("#morefLinks").click(function(){
			if($(this).hasClass('moreLinks')){
				$(".friendsLinks").css("height","auto");
				$(".friendsLinks").css("overflow"," ");
				$("#morefLinks").removeClass("moreLinks").addClass("lessLinks");
			}else{
				$(".friendsLinks").css("height","20px");
				$(".friendsLinks").css("overflow","hidden");
				$("#morefLinks").removeClass("lessLinks").addClass("moreLinks");
			}
		})
		
		/*回到顶部*/
		$("#backTop").click(function() {
			$('body,html').stop().animate({scrollTop: 0}, 500);
			return false;
		});
	})
</script>

	<div class="zt-wrap">			
		<div class="gcd-01"></div>
		<div class="gcd-02"></div>
		<div class="gcd-03"></div>
		<div class="gcd-04">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 547127)), array('class' => 'a1', 'title' => '尚牌避孕套36只超薄保险安全套情趣型G点润滑男用女用byt计生用品', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 545266)), array('class' => 'a2', 'title' => 'KEY极致丝滑润滑啫喱60ML 阴道润滑剂房事润滑油 成人用品情趣用品性用品', 'target' => '_blank')) ?>
			</div>
		</div>
		<div class="gcd-05">
			<div class="zt-con">	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 620863)), array('class' => 'a1', 'title' => '【杰士邦】(更多润滑)日本进口 零感避孕套超薄情趣成人用品安全套', 'target' => '_blank')) ?>				
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 85779)), array('class' => 'a2', 'title' => 'viplife家纺 韩版全棉 床单款四件套 被套200*230', 'target' => '_blank')) ?>
			</div>
		</div>
		<div class="gcd-06">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 632322)), array('class' => 'a1', 'title' => '杜蕾斯旗舰店 爽滑快感人体润滑剂 男女房事用润滑油情趣成人用品', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 482396)), array('class' => 'a2', 'title' => '【viplife】VIPLIFE纯棉四件套 全棉床单被套200*230cm 专柜正品 2016新品首发', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 632317)), array('class' => 'a3', 'title' => '杜蕾斯 亲昵装12只正品安全套 润滑型避孕套 情趣成人用品', 'target' => '_blank')) ?>
			</div>
		</div>
		<div class="gcd-07"></div>
		<div class="gcd-08">
			<div class="zt-con">	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 442334)), array('class' => 'a1', 'title' => 'RIO锐澳鸡尾酒【包邮】275ml*6瓶套餐 6口味', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 638044)), array('class' => 'a2', 'title' => '序柔女士睡袍夏真蕾丝丝绸睡衣女性感丝质吊带睡裙两件套浴袍女夏', 'target' => '_blank')) ?>
			</div>
		</div>
		<div class="gcd-09"></div>
		<div class="gcd-10">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 638509)), array('class' => 'a1', 'title' => '舒绸坊真丝睡衣女夏天性感吊带睡裙桑蚕丝绸蕾丝品牌杭州高档中裙 6A级桑蚕丝 精美蕾丝花边 性感舒适 清凉透气', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 612940)), array('class' => 'a2', 'title' => '梦陇波尔多干红葡萄酒2014 赵薇酒庄 梦陇红酒', 'target' => '_blank')) ?>
			</div>
		</div>

		<div class="gcd-11"></div>
		<div class="gcd-12">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 584065)), array('class' => 'a1', 'title' => '南极人正品功能保健内裤英国卫裤性感男士生理裤头平角抗菌抑菌', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 535793)), array('class' => 'a2', 'title' => '养生玛咖枸杞茶肾阴虚阳虚养肾茶保健固精五宝茶玛卡枸杞茶男女滋', 'target' => '_blank')) ?>
			</div>
		</div>
		<div class="gcd-13"></div>
		<div class="gcd-14">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 608975)), array('class' => 'a1', 'title' => '玛卡片同仁堂进口秘鲁玛卡玛咖片男用玛卡精片男性正品保健品MACAF_UID236', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 507460)), array('class' => 'a2', 'title' => '优乐盒 男士磁疗卫裤莫代尔保健保暖内裤 大码透气增大平角裤 K019', 'target' => '_blank')) ?>
			</div>
		</div>
		<div class="gcd-15"></div>
	</div>   
   
