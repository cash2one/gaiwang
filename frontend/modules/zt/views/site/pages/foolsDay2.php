<?php $this->pageTitle = "愚人节活动" . $this->pageTitle;?>
<style type='text/css'>
	/*=====
	    @Date:2016-03-29
	    @content:愚人节活动
		@author:林聪毅
	 =====*/
	.zt-wrap{width:100%; background:#fff; overflow: hidden;}
	.zt-con { width:968px; margin:0 auto; position:relative; }
	.zt-con a{ position:absolute;display:block;}
	.foolsDay2-01{height:348px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-01.jpg) top center no-repeat;}
	.foolsDay2-02{height:347px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-02.jpg) top center no-repeat;}
	.foolsDay2-03{height:517px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-03.jpg) top center no-repeat;}
	.foolsDay2-04{height:240px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-04.jpg) top center no-repeat;}
	.foolsDay2-05{height:240px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-05.jpg) top center no-repeat;}
	.foolsDay2-06{height:240px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-06.jpg) top center no-repeat;}
	.foolsDay2-07{height:239px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-07.jpg) top center no-repeat;}
	.foolsDay2-08{height:240px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-08.jpg) top center no-repeat;}
	.foolsDay2-09{height:240px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-09.jpg) top center no-repeat;}
	.foolsDay2-10{height:240px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-10.jpg) top center no-repeat;}

	.foolsDay2-11{height:513px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-11.jpg) top center no-repeat;}
	.foolsDay2-12{height:513px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-12.jpg) top center no-repeat;}
	.foolsDay2-13{height:327px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-13.jpg) top center no-repeat;}
	.foolsDay2-14{height:459px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-14.jpg) top center no-repeat;}
	.foolsDay2-15{height:337px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-15.jpg) top center no-repeat;}
	.foolsDay2-16{height:337px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-16.jpg) top center no-repeat;}
	.foolsDay2-17{height:520px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-17.jpg) top center no-repeat;}
	.foolsDay2-18{height:516px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-18.jpg) top center no-repeat;}
	.foolsDay2-19{height:396px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-19.jpg) top center no-repeat;}
	.foolsDay2-20{height:741px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-20.jpg) top center no-repeat;}

	.foolsDay2-21{height:451px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-21.jpg) top center no-repeat;}
	.foolsDay2-22{height:451px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-22.jpg) top center no-repeat;}
	.foolsDay2-23{height:489px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-23.jpg) top center no-repeat;}
	.foolsDay2-24{height:707px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-24.jpg) top center no-repeat;}
	.foolsDay2-25{height:706px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-25.jpg) top center no-repeat;}
	.foolsDay2-26{height:399px; background:url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/foolsDay2-26.jpg) top center no-repeat;}

	.foolsDay2-03 a{}
	.foolsDay2-03 .a1{width: 329px; height: 284px; left: -81px; top: 46px;}
	.foolsDay2-03 .a1:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/navHover-01.png) no-repeat;}
	.foolsDay2-03 .a2{width: 205px; height: 177px; left: 212px; top: 313px;}
	.foolsDay2-03 .a2:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/navHover-02.png) no-repeat;}
	.foolsDay2-03 .a3{width: 285px; height: 246px; left: 384px; top: 92px;}
	.foolsDay2-03 .a3:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/navHover-03.png) no-repeat;}
	.foolsDay2-03 .a4{width: 250px; height: 217px; left: 640px; top: 274px;}
	.foolsDay2-03 .a4:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/navHover-04.png) no-repeat;}
	.foolsDay2-03 .a5{width: 215px; height: 186px; left: 826px; top: 17px;}
	.foolsDay2-03 .a5:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/foolsDay2/navHover-05.png) no-repeat;}
	.foolsDay2-06 a{}
	.foolsDay2-06 .a1{width: 290px; height: 290px; left: -100px; top: 70px;}
	.foolsDay2-06 .a2{width: 360px; height: 260px; left: 740px; top: 100px;}
	.foolsDay2-08 a{}
	.foolsDay2-08 .a1{width: 510px; height: 220px; left: -70px; top: -60px;}
	.foolsDay2-08 .a2{width: 470px; height: 180px; left: 580px; top: 0px;}
	.foolsDay2-09 a{}
	.foolsDay2-09 .a1{width: 590px; height: 150px; left: -120px; top: 10px; z-index: 2;}
	.foolsDay2-09 .a2{width: 490px; height: 160px; left: 550px; top: 10px;}
	.foolsDay2-10 a{}
	.foolsDay2-10 .a1{width: 370px; height: 330px; left: -130px; top: -110px;}
	.foolsDay2-10 .a2{width: 270px; height: 270px; left: 810px; top: -70px;}

	.foolsDay2-12 a{width: 290px; height: 344px; top: 160px;}
	.foolsDay2-12 .a1{left: 10px;}
	.foolsDay2-12 .a2{left: 350px;}
	.foolsDay2-12 .a3{left: 660px;}
	.foolsDay2-13 a{}
	.foolsDay2-13 .a1{width: 240px; height: 320px; left: 30px; top: 0px;}
	.foolsDay2-13 .a2{width: 280px; height: 290px; left: 350px; top: 30px;}
	.foolsDay2-13 .a3{width: 290px; height: 320px; left: 660px; top: 0px;}
	.foolsDay2-14 a{}
	.foolsDay2-14 .a1{width: 260px; height: 340px; left: 180px; top: 6px;}
	.foolsDay2-14 .a2{width: 260px; height: 350px; left: 500px; top: 6px;}
	.foolsDay2-16 a{}
	.foolsDay2-16 .a1{width: 226px; height: 244px; left: -20px; top: 80px;}
	.foolsDay2-16 .a2{width: 210px; height: 270px; left: 280px; top: 50px;}
	.foolsDay2-16 .a3{width: 200px; height: 254px; left: 600px; top: 70px; z-index: 2;}
	.foolsDay2-17 a{}
	.foolsDay2-17 .a1{width: 244px; height: 280px; left: -70px; top: 0px; z-index: 2;}
	.foolsDay2-17 .a2{width: 286px; height: 240px; left: 740px; top: -60px;}
	.foolsDay2-17 .a3{width: 300px; height: 200px; left: 100px; top: 240px;}
	.foolsDay2-17 .a4{width: 230px; height: 270px; left: 430px; top: 180px;}
	.foolsDay2-17 .a5{width: 280px; height: 230px; left: 700px; top: 190px;}
	.foolsDay2-19 a{width: 222px; height: 382px; top: 10px;}
	.foolsDay2-19 .a1{left: -120px;}
	.foolsDay2-19 .a2{left: 102px;}
	.foolsDay2-19 .a3{left: 325px; z-index: 3;}
	.foolsDay2-20 a{}
	.foolsDay2-20 .a1{width: 580px; height: 430px; left: 470px; top: -90px; z-index: 2;}
	.foolsDay2-20 .a2{width: 1030px; height: 610px; left: -140px; top: 120px;}

	.foolsDay2-21 a{}
	.foolsDay2-21 .a1{width: 540px; height: 540px; left: 480px; top: 0px; z-index: 2;}
	.foolsDay2-21 .a2{width: 600px; height: 600px; left: -60px; top: 220px;}
	.foolsDay2-24 a{}
	.foolsDay2-24 .a1{width: 280px; height: 344px; left: 370px; top: 10px;}
	.foolsDay2-24 .a2{width: 220px; height: 330px; left: -60px; top: 200px;}
	.foolsDay2-24 .a3{width: 290px; height: 380px; left: 760px; top: 110px;}
	.foolsDay2-25 a{}
	.foolsDay2-25 .a1{width: 290px; height: 370px; left: -114px; top: -90px;}
	.foolsDay2-25 .a2{width: 520px; height: 510px; left: 220px; top: -240px;}
	.foolsDay2-25 .a3{width: 310px; height: 320px; left: 770px; top: -70px;}
	.foolsDay2-25 .a4{width: 280px; height: 300px; left: 130px; top: 320px;}
	.foolsDay2-25 .a5{width: 310px; height: 300px; left: 630px; top: 320px;}
</style>

	<div class="zt-wrap">			
		<div class="foolsDay2-01"></div>
		<div class="foolsDay2-02"></div>
		<div class="foolsDay2-03">
			<div class="zt-con">					
				<a href="#part1" class="a1"></a>
				<a href="#part2" class="a2"></a>
				<a href="#part3" class="a3"></a>
				<a href="#part4" class="a4"></a>
				<a href="#part5" class="a5"></a>
			</div>
		</div>
		<div class="foolsDay2-04" id="part1"></div>
		<div class="foolsDay2-05"></div>
		<div class="foolsDay2-06">
			<div class="zt-con">	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 105719)), array('class' => 'a1', 'title' => '【挑逗食品】温州特产 干货特产 小虾干 精美袋装即食虾干 新鲜宁波虾 海鲜特产', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 158557)), array('class' => 'a2', 'title' => '【挑逗食品】温州特产 藤桥牌 藤桥熏鸡450g-500g 浙江特产温州名菜特色小吃美食熏鸡', 'target' => '_blank')) ?>						
			</div>
		</div>
		<div class="foolsDay2-07"></div>
		<div class="foolsDay2-08">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 87170)), array('class' => 'a1', 'title' => '【冷水箐】盐边油底肉坛装礼盒500g', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 272473)), array('class' => 'a2', 'title' => '【宝禄缘】阳光攀枝花-柳橙4000g', 'target' => '_blank')) ?>						
			</div>
		</div>
		<div class="foolsDay2-09">
			<div class="zt-con">	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 578257)), array('class' => 'a1', 'title' => '糖糖屋台湾进口零食 宏亚蜜兰诺77松塔休闲食品 七七饼干210g*3盒', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 562445)), array('class' => 'a2', 'title' => '樱桃爷爷台湾蔓越莓牛轧糖进口伴手礼零食手工休闲食品奶糖500g', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="foolsDay2-10">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 574584)), array('class' => 'a1', 'title' => '奶酪 内蒙古特产儿童干吃牛奶片阿妈妮牛初乳高钙羊奶贝500g*2件包邮', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 574238)), array('class' => 'a2', 'title' => '内蒙古特产特色正宗风干手撕牛肉干真空美食香辣原味小吃零食200g', 'target' => '_blank')) ?>						
			</div>
		</div>

		<div class="foolsDay2-11" id="part2"></div>
		<div class="foolsDay2-12">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 183416)), array('class' => 'a1', 'title' => '【韩品汇】Leaders丽得姿去细纹眼贴膜 去黑眼圈眼袋脂肪粒补水保湿眼膜贴一盒5片', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 183566)), array('class' => 'a2', 'title' => '【韩品汇】Nature Republic自然乐园芦荟爽肤水保湿收缩毛孔护肤品160ml', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 557518)), array('class' => 'a3', 'title' => 'innisfree/悦诗风吟绿茶籽精萃水份菁露 小绿瓶补水保湿肌底液', 'target' => '_blank')) ?>	
			</div>
		</div>
		<div class="foolsDay2-13">
			<div class="zt-con">	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 557022)), array('class' => 'a1', 'title' => 'innisfree/悦诗风吟绿茶矿物资喷雾 补水保湿爽肤水 韩国正品', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 557744)), array('class' => 'a2', 'title' => 'Kiehl\'s 科颜氏 牛油果眼霜14g 取细纹保湿淡化黑眼圈正品直邮 滋润 不长油脂粒 明星产品', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 476128)), array('class' => 'a3', 'title' => 'Laneige兰芝四合一卸妆多效洁面膏/洗面奶180ml 蓝洗', 'target' => '_blank')) ?>				
			</div>
		</div>
		<div class="foolsDay2-14">
			<div class="zt-con">	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 566966)), array('class' => 'a1', 'title' => '【浪漫满屋】韩国正品 HERA赫拉防水防汗防晒霜保湿SPF35PA+++ 70mlSPF50PA+++70ml化妆品', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 575048)), array('class' => 'a2', 'title' => 'The Face Shop金盏花爽肤水乳液2件套保湿补水韩国化妆品护肤套装', 'target' => '_blank')) ?>
			</div>
		</div>
		<div class="foolsDay2-15" id="part3"></div>
		<div class="foolsDay2-16">
			<div class="zt-con">	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 221977)), array('class' => 'a1', 'title' => '有机杂粮  辽宁特产500g*8  任意搭配  包邮', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 169736)), array('class' => 'a2', 'title' => '盘锦北稻有机大米 丰锦/稻花香 (5kg/袋) 自产自销', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 323246)), array('class' => 'a3', 'title' => '新疆黑蜂蜂巢素蜜 500g', 'target' => '_blank')) ?>				
			</div>
		</div>
		<div class="foolsDay2-17">
			<div class="zt-con">
			<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 53275)), array('class' => 'a1', 'title' => '檀山皇布袋沁州黄小米 袋装2500g', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 210615)), array('class' => 'a2', 'title' => '特级手工富硒六安瓜片100g', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 138133)), array('class' => 'a3', 'title' => '光照人欧盟有机认证茶园直销盒装韵香型有机铁观音茶叶', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 347303)), array('class' => 'a4', 'title' => '澳洲德运脱脂高钙成人奶粉 老年人早餐奶', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 364324)), array('class' => 'a5', 'title' => '斯里兰卡进口Dilmah迪尔玛阿萨姆红茶100g锡兰红茶罐装礼盒', 'target' => '_blank')) ?>
			</div>
		</div>
		<div class="foolsDay2-18"></div>
		<div class="foolsDay2-19" id="part4">
			<div class="zt-con">	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 433813)), array('class' => 'a1', 'title' => '儿童装男童套装2016春秋装新款英伦学院外贸精品领结衣服3-8岁', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 496731)), array('class' => 'a2', 'title' => '新款甜美百搭连衣裙', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 113108)), array('class' => 'a3', 'title' => '童装秋装2015新款 男童皮衣夹克外套韩版潮', 'target' => '_blank')) ?>				
			</div>
		</div>
		<div class="foolsDay2-20">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 560617)), array('class' => 'a1', 'title' => '时尚亲子装2016春装新款韩版母女装连衣裙春秋季童装女童长袖裙潮', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 505741)), array('class' => 'a2', 'title' => '裸粉色加厚韩版时尚连衣裙女童冬母女装颐贝贝亲子装春装2016款__UID92', 'target' => '_blank')) ?>					
			</div>
		</div>

		<div class="foolsDay2-21">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 179366)), array('class' => 'a1', 'title' => '童装韩版女童短袖连衣裙2015夏 儿童公主A字裙纯棉裙暑假出游裙', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 498820)), array('class' => 'a2', 'title' => '包邮2016新款韩版时尚甜心分体裙式亲子游泳衣 亲子装 母女装', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="foolsDay2-22"></div>
		<div class="foolsDay2-23" id="part5"></div>
		<div class="foolsDay2-24">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 81603)), array('class' => 'a1', 'title' => '【数码之家】爱国者DPF81数码相框 8寸高清 视频音乐高清电子相册 U盘直插像册 白色数码相框', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 251536)), array('class' => 'a2', 'title' => '官方正品 小米手环 安卓智能蓝牙手表防水穿戴腕带运动手环计步器', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 74263)), array('class' => 'a3', 'title' => 'MIFA F5 无线蓝牙音箱户外防水车载插卡迷你音响低音炮便携可电话（黄 蓝 红 绿）四色可选', 'target' => '_blank')) ?>					
			</div>
		</div>
		<div class="foolsDay2-25">
			<div class="zt-con">
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 301292)), array('class' => 'a1', 'title' => 'Sony/索尼 MDR-ZX110 入门监听头戴式耳机 手机耳机 折叠设计', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 74446)), array('class' => 'a2', 'title' => '【索尼Sony】【龙腾数码】索尼（SONY）ILCE-6000L 微单相机 白色/黑色', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 527330)), array('class' => 'a3', 'title' => 'y智能运动NFC健康手环手表计步器睡眠监测适配安卓苹果小米防水s_UID117', 'target' => '_blank')) ?>
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 296500)), array('class' => 'a4', 'title' => '【新众】原装正品国行微软 XBOX ONE 带体感 Kinect 游戏主机', 'target' => '_blank')) ?>	
				<?php echo CHtml::link('', $this->createAbsoluteUrl('/JF/view', array('id' => 60210)), array('class' => 'a5', 'title' => '【欧乐科】Nikon/尼康1 V1(含10-30mm镜头)可换镜套机（原装机器+送品牌4G SDHC原装内存卡+高速读卡器+高清贴膜+清洁套装+高级相机包） 尼康相机', 'target' => '_blank')) ?>
			</div>
		</div>
		<div class="foolsDay2-26"></div>
		
			
	</div>   
   