<?php $this->pageTitle = "盖象商城-端午节"; ?>

<style>
    /*=====
    @Date:2016-05-25
    @content:端午节
	@author:林聪毅
 =====*/
    .zt-wrap{width:100%; background:#fff; overflow: hidden;}
    .zt-con { width:968px; margin:0 auto; position:relative; }
    .zt-con a{ position:absolute;display:block;}
    .dragonBoat-festival-01{height:410px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-01.jpg) top center no-repeat;}
    .dragonBoat-festival-02{height:410px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-02.jpg) top center no-repeat;}
    .dragonBoat-festival-03{height:558px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-03.jpg) top center no-repeat;}
    .dragonBoat-festival-04{height:346px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-04.jpg) top center no-repeat;}
    .dragonBoat-festival-05{height:346px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-05.jpg) top center no-repeat;}
    .dragonBoat-festival-06{height:504px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-06.jpg) top center no-repeat;}
    .dragonBoat-festival-07{height:524px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-07.jpg) top center no-repeat;}
    .dragonBoat-festival-08{height:356px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-08.jpg) top center no-repeat;}
    .dragonBoat-festival-09{height:320px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-09.jpg) top center no-repeat;}
    .dragonBoat-festival-10{height:388px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-10.jpg) top center no-repeat;}

    .dragonBoat-festival-11{height:702px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-11.jpg) top center no-repeat;}
    .dragonBoat-festival-12{height:407px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-12.jpg) top center no-repeat;}
    .dragonBoat-festival-13{height:432px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-13.jpg) top center no-repeat;}
    .dragonBoat-festival-14{height:368px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-14.jpg) top center no-repeat;}
    .dragonBoat-festival-15{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-15.jpg) top center no-repeat;}
    .dragonBoat-festival-16{height:616px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-16.jpg) top center no-repeat;}
    .dragonBoat-festival-17{height:600px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-17.jpg) top center no-repeat;}
    .dragonBoat-festival-18{height:676px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-18.jpg) top center no-repeat;}
    .dragonBoat-festival-19{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-19.jpg) top center no-repeat;}
    .dragonBoat-festival-20{height:466px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-20.jpg) top center no-repeat;}

    .dragonBoat-festival-21{height:488px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-21.jpg) top center no-repeat;}
    .dragonBoat-festival-22{height:672px; background:url(<?php echo ATTR_DOMAIN;?>/zt/dragonBoat-festival/dragonBoat-festival-22.jpg) top center no-repeat;}

    .dragonBoat-festival-03 a{}
    .dragonBoat-festival-03 .a1{width: 300px; height: 150px; left: 160px; top: 350px;}
    .dragonBoat-festival-03 .a2{width: 260px; height: 130px; left: 530px; top: 290px;}
    .dragonBoat-festival-03 .a3{width: 270px; height: 130px; left: -106px; top: 244px;}
    .dragonBoat-festival-03 .a4{width: 220px; height: 110px; left: 4px; top: 94px;}
    .dragonBoat-festival-03 .a5{width: 250px; height: 130px; left: 880px; top: 230px;}
    .dragonBoat-festival-03 .a6{width: 220px; height: 120px; left: 794px; top: 74px;}
    .dragonBoat-festival-04 a{}
    .dragonBoat-festival-04 .a1{width: 530px; height: 430px; left: -50px; top: 260px;}
    .dragonBoat-festival-04 .a2{width: 500px; height: 420px; left: 500px; top: 340px;}
    .dragonBoat-festival-06 a{}
    .dragonBoat-festival-06 .a1{width: 520px; height: 440px; left: -60px; top: 0px;}
    .dragonBoat-festival-06 .a2{width: 500px; height: 420px; left: 500px; top: 70px;}
    .dragonBoat-festival-07 a{}
    .dragonBoat-festival-07 .a1{width: 500px; height: 210px; left: 490px; top: 350px;}
    .dragonBoat-festival-08 a{}
    .dragonBoat-festival-08 .a1{width: 560px; height: 270px; left: 0px; top: 20px;}
    .dragonBoat-festival-08 .a2{width: 460px; height: 210px; left: 610px; top: 120px;}
    .dragonBoat-festival-09 a{}
    .dragonBoat-festival-09 .a1{width: 570px; height: 290px; left: -70px; top: 20px;}
    .dragonBoat-festival-09 .a2{width: 460px; height: 220px; left: 570px; top: 60px;}

    .dragonBoat-festival-11 a{width: 560px; height: 380px;}
    .dragonBoat-festival-11 .a1{left: -10px; top: 0px;}
    .dragonBoat-festival-11 .a2{left: 410px; top: 320px;}
    .dragonBoat-festival-12 a{width: 300px; height: 390px; top: -10px;}
    .dragonBoat-festival-12 .a1{left: -10px;}
    .dragonBoat-festival-12 .a2{left: 350px;}
    .dragonBoat-festival-12 .a3{left: 730px;}
    .dragonBoat-festival-13 a{width: 300px; height: 390px; top: 10px;}
    .dragonBoat-festival-13 .a1{left: -20px;}
    .dragonBoat-festival-13 .a2{left: 350px;}
    .dragonBoat-festival-13 .a3{left: 730px;}
    .dragonBoat-festival-15 a{}
    .dragonBoat-festival-15 .a1{width: 610px; height: 380px; left: -20px; top: 10px;}
    .dragonBoat-festival-15 .a2{width: 330px; height: 480px; left: 670px; top: 50px;}
    .dragonBoat-festival-16 a{}
    .dragonBoat-festival-16 .a1{width: 580px; height: 270px; left: 0px; top: 0px;}
    .dragonBoat-festival-16 .a2{width: 280px; height: 430px; left: 690px; top: 170px;}
    .dragonBoat-festival-16 .a3{width: 620px; height: 230px; left: -20px; top: 350px;}
    .dragonBoat-festival-17 a{width: 680px; height: 250px; top: 300px;}
    .dragonBoat-festival-17 .a1{left: 280px;}
    .dragonBoat-festival-18 a{}
    .dragonBoat-festival-18 .a1{width: 370px; height: 420px; left: -30px; top: 70px;}
    .dragonBoat-festival-18 .a2{width: 650px; height: 230px; left: 420px; top: 70px;}
    .dragonBoat-festival-18 .a3{width: 710px; height: 230px; left: 250px; top: 430px; z-index: 2;}

    .dragonBoat-festival-20 a{width: 230px; height: 460px;}
    .dragonBoat-festival-20 .a1{left: 100px; top: -120px;}
    .dragonBoat-festival-20 .a2{left: 360px; top: -30px;}
    .dragonBoat-festival-20 .a3{left: 630px; top: -120px;}
    .dragonBoat-festival-21 a{}
    .dragonBoat-festival-21 .a1{width: 340px; height: 390px; left: 70px; top: 20px;}
    .dragonBoat-festival-21 .a2{width: 370px; height: 320px; left: 550px; top: 90px;}

</style>

	<div class="zt-wrap">			
		<div class="dragonBoat-festival-01"></div>
		<div class="dragonBoat-festival-02"></div>
		<div class="dragonBoat-festival-03">
			<div class="zt-con">
				<a href="#part1" class="a1" title=""></a>
				<a href="#part2" class="a2" title=""></a>
				<a href="#part3" class="a3" title=""></a>
				<a href="#part4" class="a4" title=""></a>
				<a href="#part5" class="a5" title=""></a>
				<a href="#part6" class="a6" title=""></a>
			</div>
		</div>
		<div class="dragonBoat-festival-04" id="part1">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/436810.html" title="德国knoppers牛奶榛子巧克力威化饼干(10连包)进口饼干零食" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/214999.html" title="日本进口零食bourbon布尔本手造巧克力曲奇饼干手工制作朱古力粒" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="dragonBoat-festival-05"></div>
		<div class="dragonBoat-festival-06">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/291639.html" title="桃哈多 蜡笔小新(巧克力味）" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/114504.html" title="韩国进口糖果 LINSHIJIA林食佳吉时豆什锦糖438克韩国零食" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="dragonBoat-festival-07" id="part2">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/1028080.html" title="特产粽子 手工营养新鲜肉粽子茶香粽紫米粽 4对多种风味端午节礼品真空包装组合" class="a1" target="_blank"></a>
			</div>
		</div>
		<div class="dragonBoat-festival-08">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/1028171.html" title="特产粽子 手工营养新鲜肉粽子凉粽 4对风味端午节礼品真空包装组合" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1028141.html" title="特产粽子 手工营养新鲜肉粽子紫米粽 4对风味端午节礼品真空包装组合" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="dragonBoat-festival-09">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/1028205.html" title="特产粽子 手工营养新鲜茶香粽子小米粽125g*4对风味端午节礼品真空包装组合" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1028277.html" title="特产粽子 手工新鲜肉粽子小米粽4对风味端午节礼品真空包装组合" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="dragonBoat-festival-10" id="part3"></div>

		<div class="dragonBoat-festival-11">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/305928.html" title="佳节送礼精品武夷山大红袍礼盒" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/305844.html" title="佳节送礼精品 金骏眉武夷红茶 茶叶礼盒 木盒装" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="dragonBoat-festival-12">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/305873.html" title="2006年勐库戎氏（母树茶）500g" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/305815.html" title="布朗乔木-云南勐海七子饼茶（生茶）357g" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/305794.html" title="巴达老树普洱茶（生茶）紧压茶357g" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="dragonBoat-festival-13">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/305943.html" title="2006年双江勐库戎氏七子饼特级普洱（熟饼）145g" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/305839.html" title="01年孔雀之乡七子饼-特级普洱（熟饼）357g" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/305865.html" title="2007年孔雀之乡七子饼-越陈越香 357g" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="dragonBoat-festival-14" id="part4"></div>
		<div class="dragonBoat-festival-15">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/406298.html" title="韩国红之宏尊红参浓缩液 青少年高中高考学生营养保健品 送四星红枣" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/461873.html" title="盖网特供  新疆红枣和田丝路虹富硒雪枣 四星级450g" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="dragonBoat-festival-16">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/566039.html" title="海参珍品干货刺参野生海参礼盒300g" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/368299.html" title="皖之道罐装 黑枸杞80g" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/191734.html" title="天丰茵子牌羊胎盘胶囊" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="dragonBoat-festival-17" id="part5">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/534396.html" title="ACTWIN 爱可吻 舒适防滑 轻便休闲运动男鞋 15101—0910" class="a1" target="_blank"></a>
			</div>
		</div>
		<div class="dragonBoat-festival-18">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/542743.html" title="ACTWIN 爱可吻 英伦舒适防滑 一脚蹬轻便黑色休闲男鞋 15101—1101" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/542682.html" title="ACTWIN 爱可吻 英伦舒适防滑 一脚蹬轻便浅棕色休闲男鞋 15101—1015" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/534480.html" title="ACTWIN 爱可吻 英伦舒适防滑 一脚蹬轻便休闲男鞋 15101—1012" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="dragonBoat-festival-19" id="part6"></div>
		<div class="dragonBoat-festival-20">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/1113692.html " title="原装进口 VELOTAC AUTO VX 0W40超级全合成性能车润滑油4L" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1113574.html" title="原装进口 VELOTAC AUTO VR 10W60超级全合成性能车润滑油4L" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1113757.html" title="原装进口 VELOTAC  AUTO  V  5W30高级全合成性能车润滑油4L" class="a3" target="_blank"></a>
			</div>
		</div>

		<div class="dragonBoat-festival-21">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/153978.html" title="伊新 车内净化多功能一体机 太阳能自动供电" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/180697.html" title="尚雅风 车内净化便携机 双核双动力" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="dragonBoat-festival-22"></div>
	</div>   
   <!--------------主体 End------------>