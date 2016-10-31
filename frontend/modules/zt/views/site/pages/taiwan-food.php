<?php $this->pageTitle = "台湾美食专题_".$this->pageTitle ?>
<style type="text/css">
	/*=====
	    @Date:2014-09-24
	    @content:台湾美食专题
		@author:林聪毅
	 =====*/
	.zt-wrap{width:100%; background:#fff;}
	.zt-con { width:968px; margin:0 auto; position:relative; }
	.zt-con a{ position:absolute;display:block;}
	.taiwan-01{height:479px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-01.jpg) top center no-repeat;}
	.taiwan-02{height:239px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-02.jpg) top center no-repeat;}
	.taiwan-03{height:359px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-03.jpg) top center no-repeat;}
	.taiwan-04{height:406px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-04.jpg) top center no-repeat;}
	.taiwan-05{height:1079px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-05.jpg) top center no-repeat;}
	.taiwan-06{height:360px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-06.jpg) top center no-repeat;}
	.taiwan-07{height:359px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-07.jpg) top center no-repeat;}
	.taiwan-08{height:432px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-08.jpg) top center no-repeat;}
	.taiwan-09{height:431px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-09.jpg) top center no-repeat;}
	.taiwan-10{height:483px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-10.jpg) top center no-repeat;}

	.taiwan-11{height:362px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-11.jpg) top center no-repeat;}
	.taiwan-12{height:361px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-12.jpg) top center no-repeat;}
	.taiwan-13{height:399px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-13.jpg) top center no-repeat;}
	.taiwan-14{height:501px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-14.jpg) top center no-repeat;}
	.taiwan-15{height:366px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-15.jpg) top center no-repeat;}
	.taiwan-16{height:366px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-16.jpg) top center no-repeat;}
	.taiwan-17{height:391px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-17.jpg) top center no-repeat;}
	.taiwan-18{height:498px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-18.jpg) top center no-repeat;}
	.taiwan-19{height:361px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-19.jpg) top center no-repeat;}
	.taiwan-20{height:361px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-20.jpg) top center no-repeat;}

	.taiwan-21{height:431px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-21.jpg) top center no-repeat;}
	.taiwan-22{height:432px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-22.jpg) top center no-repeat;}
	.taiwan-23{height:421px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-23.jpg) top center no-repeat;}
	.taiwan-24{height:366px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-24.jpg) top center no-repeat;}
	.taiwan-25{height:366px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-25.jpg) top center no-repeat;}
	.taiwan-26{height:431px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-26.jpg) top center no-repeat;}
	.taiwan-27{height:432px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-27.jpg) top center no-repeat;}
	.taiwan-28{height:358px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-28.jpg) top center no-repeat;}
	.taiwan-29{height:429px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-29.jpg) top center no-repeat;}
	.taiwan-30{height:429px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-30.jpg) top center no-repeat;}

	.taiwan-31{height:430px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-31.jpg) top center no-repeat;}
	.taiwan-32{height:432px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-32.jpg) top center no-repeat;}
	.taiwan-33{height:389px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-33.jpg) top center no-repeat;}
	.taiwan-34{height:388px; background:url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/taiwan-34.jpg) top center no-repeat;}

	.taiwan-05 .subnav{ width: 225px; height: 225px; z-index: 2;}
	.taiwan-05 .subnav1{ background: url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/subnav-1.png) no-repeat; left: 40px; top: 190px;}
	.taiwan-05 .subnav2{ background: url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/subnav-2.png) no-repeat; left: -50px; top: 470px;}
	.taiwan-05 .subnav3{ background: url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/subnav-3.png) no-repeat; left: 130px; top: 740px;}
	.taiwan-05 .subnav4{ background: url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/subnav-4.png) no-repeat; left: 710px; top: 160px;}
	.taiwan-05 .subnav5{ background: url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/subnav-5.png) no-repeat; left: 770px; top: 460px;}
	.taiwan-05 .subnav6{ background: url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/subnav-6.png) no-repeat; left: 630px; top: 740px;}
	.taiwan-05 .bigPic{ width: 746px; height: 746px; background: url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/info-1.png) no-repeat; left: 110px; top: 140px;}
	.taiwan-05 .layout{ width: 225px; height: 225px; z-index: 3; display: none;}
	.taiwan-05 .layout1{ background: url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/layout-1.png) no-repeat; left: 40px; top: 190px;}
	.taiwan-05 .layout2{ background: url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/layout-2.png) no-repeat; left: -50px; top: 470px;}
	.taiwan-05 .layout3{ background: url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/layout-3.png) no-repeat; left: 130px; top: 740px;}
	.taiwan-05 .layout4{ background: url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/layout-4.png) no-repeat; left: 710px; top: 160px;}
	.taiwan-05 .layout5{ background: url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/layout-5.png) no-repeat; left: 770px; top: 460px;}
	.taiwan-05 .layout6{ background: url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/layout-6.png) no-repeat; left: 630px; top: 740px;}
	.taiwan-08 a{ width:328px; height:400px; top:0px;}
	.taiwan-08 .a1{left:-53px; }
	.taiwan-08 .a2{left:316px; }
	.taiwan-08 .a3{right:-45px; }
	.taiwan-09 a{ width:328px; height:400px; top:0px;}
	.taiwan-09 .a1{left:-53px; }
	.taiwan-09 .a2{left:316px; }
	.taiwan-09 .a3{right:-45px; }
	.taiwan-10 a{ width:288px; height:360px; top:0px;}
	.taiwan-10 .a1{left:-115px; }
	.taiwan-10 .a2{left:188px; }
	.taiwan-10 .a3{left:490px; }
	.taiwan-10 .a4{right:-115px; }

	.taiwan-13 a{ width:288px; height:360px; top:0px;}
	.taiwan-13 .a1{left:-115px; }
	.taiwan-13 .a2{left:188px; }
	.taiwan-13 .a3{left:490px; }
	.taiwan-13 .a4{right:-115px; }
	.taiwan-14 a{ width:288px; height:360px; top:0px;}
	.taiwan-14 .a1{left:-115px; }
	.taiwan-14 .a2{left:188px; }
	.taiwan-14 .a3{left:490px; }
	.taiwan-14 .a4{right:-115px; }
	.taiwan-17 a{ width:288px; height:360px; top:0px;}
	.taiwan-17 .a1{left:-115px; }
	.taiwan-17 .a2{left:188px; }
	.taiwan-17 .a3{left:490px; }
	.taiwan-17 .a4{right:-115px; }
	.taiwan-18 a{ width:288px; height:360px; top:0px;}
	.taiwan-18 .a1{left:-115px; }
	.taiwan-18 .a2{left:188px; }
	.taiwan-18 .a3{left:490px; }
	.taiwan-18 .a4{right:-115px; }

	.taiwan-21 a{ width:328px; height:400px; top:0px;}
	.taiwan-21 .a1{left:-53px; }
	.taiwan-21 .a2{left:316px; }
	.taiwan-21 .a3{right:-45px; }
	.taiwan-22 a{ width:328px; height:400px; top:0px;}
	.taiwan-22 .a1{left:-53px; }
	.taiwan-22 .a2{left:316px; }
	.taiwan-22 .a3{right:-45px; }
	.taiwan-23 a{ width:288px; height:360px; top:0px;}
	.taiwan-23 .a1{left:-115px; }
	.taiwan-23 .a2{left:188px; }
	.taiwan-23 .a3{left:490px; }
	.taiwan-23 .a4{right:-115px; }
	.taiwan-26 a{ width:328px; height:400px; top:0px;}
	.taiwan-26 .a1{left:-53px; }
	.taiwan-26 .a2{left:316px; }
	.taiwan-26 .a3{right:-45px; }
	.taiwan-27 a{ width:328px; height:400px; top:0px;}
	.taiwan-27 .a1{left:-53px; }
	.taiwan-27 .a2{left:316px; }
	.taiwan-27 .a3{right:-45px; }
	.taiwan-28 a{ width:288px; height:360px; top:0px;}
	.taiwan-28 .a1{left:-115px; }
	.taiwan-28 .a2{left:188px; }
	.taiwan-28 .a3{left:490px; }
	.taiwan-28 .a4{right:-115px; }

	.taiwan-31 a{ width:328px; height:400px; top:0px;}
	.taiwan-31 .a1{left:-53px; }
	.taiwan-31 .a2{left:316px; }
	.taiwan-31 .a3{right:-45px; }
	.taiwan-32 a{ width:328px; height:400px; top:0px;}
	.taiwan-32 .a1{left:-53px; }
	.taiwan-32 .a2{left:316px; }
	.taiwan-32 .a3{right:-45px; }
	.taiwan-33 a{ width:288px; height:360px; top:0px;}
	.taiwan-33 .a1{left:-115px; }
	.taiwan-33 .a2{left:188px; }
	.taiwan-33 .a3{left:490px; }
	.taiwan-33 .a4{right:-115px; }
	.taiwan-34 a{ width: 510px; height: 190px; left: 230px; top: 40px;}
</style>
	<div class="zt-wrap">			
		<div class="taiwan-01"></div>
		<div class="taiwan-02"></div>
		<div class="taiwan-03"></div>
		<div class="taiwan-04"></div>
		<div class="taiwan-05">
			<div class="zt-con">
                <?php echo CHtml::link('','javascript:void(0)',array('class'=>'subnav subnav1')) ?>
                <?php echo CHtml::link('','javascript:void(0)',array('class'=>'subnav subnav2')) ?>
                <?php echo CHtml::link('','javascript:void(0)',array('class'=>'subnav subnav3')) ?>
                <?php echo CHtml::link('','javascript:void(0)',array('class'=>'subnav subnav4')) ?>
                <?php echo CHtml::link('','javascript:void(0)',array('class'=>'subnav subnav5')) ?>
                <?php echo CHtml::link('','javascript:void(0)',array('class'=>'subnav subnav6')) ?>
                <?php echo CHtml::link('','javascript:void(0)',array('class'=>'bigPic')) ?>
                <?php echo CHtml::link('','#part1',array('class'=>'layout layout1')) ?>
                <?php echo CHtml::link('','#part2',array('class'=>'layout layout2')) ?>
                <?php echo CHtml::link('','#part3',array('class'=>'layout layout3')) ?>
                <?php echo CHtml::link('','#part4',array('class'=>'layout layout4')) ?>
                <?php echo CHtml::link('','#part5',array('class'=>'layout layout5')) ?>
                <?php echo CHtml::link('','#part6',array('class'=>'layout layout6')) ?>
			</div>
		</div>
		<div class="taiwan-06" id="part1"></div>
		<div class="taiwan-07"></div>
		<div class="taiwan-08">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>182424)),array('class'=>'a1','title'=> '台湾竹叶堂小凤酥（原味、葡萄、蔓越梅、芒果）','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>185985)),array('class'=>'a2','title'=> '台湾绿茶酥','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>186020)),array('class'=>'a3','title'=> '台湾健康果仁南瓜酥','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="taiwan-09">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>181296)),array('class'=>'a1','title'=> '台湾免税店直供正品 特产糕点 东方水姑娘凤梨酥250g 最佳办公室休闲零食','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>180460)),array('class'=>'a2','title'=> '台湾免税店直供正品 特产糕点 东方水姑娘释迦酥250g 最佳办公室休闲零食','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>180690)),array('class'=>'a3','title'=> '台湾进口 雪之恋五谷杂粮元气黄金酥条 新品促销3盒全国包邮','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="taiwan-10">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>182419)),array('class'=>'a1','title'=> '台湾庄家好手艺方块酥（黑糖、咸酥香葱、黑芝麻）','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>178316)),array('class'=>'a2','title'=> '【润品国际】台湾云林县 麦寮乡 麦寮花生方块酥 云林花生的故乡','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>180507)),array('class'=>'a3','title'=> '台湾蜜兰诺酥松派饼','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>199007)),array('class'=>'a4','title'=> '贝比佳蛋酥（布丁味、香蕉牛奶味）','target'=> '_blank')) ?>
			</div>
		</div>

		<div class="taiwan-11" id="part2"></div>
		<div class="taiwan-12"></div>
		<div class="taiwan-13">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>180644)),array('class'=>'a1','title'=> '台湾进口麻薯 雪之恋五谷综合麻糬三种口味300g','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>134832)),array('class'=>'a2','title'=> '皇族*阿里山综合小米麻糬250g三种口味可选（红豆、芋头、花生）','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>180444)),array('class'=>'a3','title'=> '台湾花之物语伴手礼','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>178503)),array('class'=>'a4','title'=> '【润品国际】年货果干櫻桃蕃茄送礼首选办公室必备零食营养美味','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="taiwan-14">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>188020)),array('class'=>'a1','title'=> '台湾珍果美元梅肉（黑砂糖、绿茶）','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>188035)),array('class'=>'a2','title'=> '台湾珍果美元多吃梅','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>180423)),array('class'=>'a3','title'=> '台湾牛轧糖夹心饼干','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>180515)),array('class'=>'a4','title'=> '台湾SSY海苔卷100%纯米制造120G','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="taiwan-15" id="part3"></div>
		<div class="taiwan-16"></div>
		<div class="taiwan-17">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>178453)),array('class'=>'a1','title'=> '匠果子台湾牛轧糖进口花生手工糖软牛轧糖 糖果零食喜糖牛奶糖','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>182303)),array('class'=>'a2','title'=> '台湾皇族牛轧糖250G','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>201193)),array('class'=>'a3','title'=> '台湾宝岛良品纯手工牛轧糖300G','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>186030)),array('class'=>'a4','title'=> '台湾利耕手工牛轧糖','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="taiwan-18">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>178403)),array('class'=>'a1','title'=> '【润品国际】年货台湾进口森永HILLO KITTY粒舒糖水果糖新年糖果','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>178497)),array('class'=>'a2','title'=> '【润品国际】年货糖果台湾进口森永香浓焦糖口味健康营养美味零食','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>180525)),array('class'=>'a3','title'=> '台湾巧克力系列','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>180107)),array('class'=>'a4','title'=> '【润品国际】台湾姜母茶进口黑金砖南姜汁黑糖古方手工红糖块','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="taiwan-19" id="part4"></div>
		<div class="taiwan-20"></div>

		<div class="taiwan-21">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>186103)),array('class'=>'a1','title'=> '台湾手工本土鸡蛋卷','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>187971)),array('class'=>'a2','title'=> '台湾西坞午茶蛋卷（芝麻口味、三星葱口味）','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>187804)),array('class'=>'a3','title'=> '台湾西坞手工芝麻蛋卷','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="taiwan-22">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>165433)),array('class'=>'a1','title'=> '台湾蛋卷（海苔味）112g','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>165370)),array('class'=>'a2','title'=> '牛葫芦台湾蛋卷（台湾特产）','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>182568)),array('class'=>'a3','title'=> '台湾大田海洋大炙若鱼酥香鱼卷礼盒104G','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="taiwan-23">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>225981)),array('class'=>'a1','title'=> '台湾进口皇族蛋卷180g','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>182430)),array('class'=>'a2','title'=> '台湾SSY牛奶棒（起司、巧克力）','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>178504)),array('class'=>'a3','title'=> '【润品国际】进口饼干台湾正哲胡椒荞麦风味活力酥饼干零食苏打饼','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>201329)),array('class'=>'a4','title'=> '台湾元气花青素米卷 12*8G','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="taiwan-24" id="part5"></div>
		<div class="taiwan-25"></div>
		<div class="taiwan-26">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>178396)),array('class'=>'a1','title'=> '【润品国际】宝岛蜜见台湾好味 休闲即食香菇酥 脱水果干 无添加','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>178409)),array('class'=>'a2','title'=> '润品国际宝岛蜜见台湾进口综合蔬果脱水果干地瓜干香芋干秋葵干','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>188016)),array('class'=>'a3','title'=> '台湾珍果美元芒果干','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="taiwan-27">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>178431)),array('class'=>'a1','title'=> '【润品国际】宝岛蜜见台湾好味 菠萝蜜脱水果干菠萝干','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>178426)),array('class'=>'a2','title'=> '台湾进口健康零食春鑫食品 奶油香酥条饼干 蒜香味奶油棒进口饼干','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>178517)),array('class'=>'a3','title'=> '台湾进口零食弘益海苔脆片五谷口味 五谷海苔脆片 海苔杏仁脆片','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="taiwan-28">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>182566)),array('class'=>'a1','title'=> '台湾大田海洋海苔南瓜籽香酥片（全素）50G','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>182562)),array('class'=>'a2','title'=> '台湾大田海洋鳕鱼海苔脆片原味60G','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>178508)),array('class'=>'a3','title'=> '润品国际 台湾进口薄脆饼干 意式坚果脆饼-【夏威夷果葡萄干】','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>178507)),array('class'=>'a4','title'=> '润品国际台湾进口酥脆美味薄脆饼干 法式杏仁切片','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="taiwan-29" id="part6"></div>
		<div class="taiwan-30"></div>

		<div class="taiwan-31">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>180693)),array('class'=>'a1','title'=> '【润品国际】台湾原装进口伂橙云赏有机高山乌龙茶台湾有机农产品','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>180695)),array('class'=>'a2','title'=> '【润品国际】台湾原装进口伂橙 芳第蜜香红茶 口感纯正','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>182491)),array('class'=>'a3','title'=> '阿里山-清香乌龙茶','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="taiwan-32">
			<div class="zt-con">					
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>182500)),array('class'=>'a1','title'=> '日月潭-台茶18号红玉','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>182347)),array('class'=>'a2','title'=> '台湾宝岛神农佛宝茶 台湾特产400G','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>178654)),array('class'=>'a3','title'=> '【润品国际】台湾原装进口 黑金砖 黑糖奶茶','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="taiwan-33">
			<div class="zt-con">
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>186104)),array('class'=>'a1','title'=> '台湾宝岛商社桂花乌龙奶茶','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>186107)),array('class'=>'a2','title'=> '台湾特选台湾古坑咖啡','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>186228)),array('class'=>'a3','title'=> '台湾台展焦糖咖啡30*20G','target'=> '_blank')) ?>
                <?php echo CHtml::link('',$this->createAbsoluteUrl('/goods/view',array('id'=>178633)),array('class'=>'a4','title'=> '台湾大尖山古坑速溶三合一咖啡礼盒装 17g*50包装正品古坑咖啡','target'=> '_blank')) ?>
			</div>
		</div>
		<div class="taiwan-34">
			<div class="zt-con">
                <?php echo CHtml::link('','javascript:void(0)',array()) ?>
			</div>
		</div>
	</div> 
	<!-- 返回顶部 end-->
	<script type="text/javascript">
	$(function(){
		var index = 0;
		$('.subnav').mousemove(function(){
			index = $(this).index();
			$('.layout').eq(index).show();
			$('.bigPic').css('background','url(<?php echo ATTR_DOMAIN?>/zt/taiwan-food/info-'+(index+1)+'.png)');
		})
		$('.layout').mouseout(function(){
			$('.layout').hide();
		})

		$('.taiwan-34 a').click(function(){
			$('body,html').stop().animate({scrollTop: 0}, 500);
			return false;
		})
	})
	</script>