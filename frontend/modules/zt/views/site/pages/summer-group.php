<?php $this->pageTitle = "盖象商城-夏日拼团" ;?>
<style>
/*=====
    @Date:2016-06-22
    @content:夏日拼团
	@author:林聪毅
 =====*/
.zt-wrap{width:100%; background:#fff; overflow: hidden;}
.zt-con { width:968px; margin:0 auto; position:relative; }
.zt-con a{ position:absolute;display:block;}
.summer-group-01{height:281px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-01.jpg) top center no-repeat;}
.summer-group-02{height:282px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-02.jpg) top center no-repeat;}
.summer-group-03{height:281px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-03.jpg) top center no-repeat;}
.summer-group-04{height:191px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-04.jpg) top center no-repeat;}
.summer-group-05{height:1117px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-05.jpg) top center no-repeat;}
.summer-group-06{height:420px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-06.jpg) top center no-repeat;}
.summer-group-07{height:387px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-07.jpg) top center no-repeat;}
.summer-group-08{height:390px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-08.jpg) top center no-repeat;}
.summer-group-09{height:390px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-09.jpg) top center no-repeat;}
.summer-group-10{height:392px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-10.jpg) top center no-repeat;}

.summer-group-11{height:389px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-11.jpg) top center no-repeat;}
.summer-group-12{height:392px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-12.jpg) top center no-repeat;}
.summer-group-13{height:412px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-13.jpg) top center no-repeat;}
.summer-group-14{height:353px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-14.jpg) top center no-repeat;}
.summer-group-15{height:227px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-15.jpg) top center no-repeat;}
.summer-group-16{height:240px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-16.jpg) top center no-repeat;}
.summer-group-17{height:196px; background:url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/summer-group-17.jpg) top center no-repeat;}

.summer-group-05 .item{width: 137px; height: 124px; background: url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/item.png) no-repeat; top: 0px;}
.summer-group-05 .item1{background-position: 0px 0px; left: 70px;}
.summer-group-05 .item2{background-position: -137px 0px; left: 240px;}
.summer-group-05 .item3{background-position: -274px 0px; left: 410px;}
.summer-group-05 .item4{background-position: -411px 0px; left: 580px;}
.summer-group-05 .item5{background-position: -548px 0px; left: 750px;}
.summer-group-05 .panelGroup div{width: 955px; height: 940px; position: absolute; left: 0px; top: 160px; opacity: 0; filter:alpha(opacity=0);
	transform: rotateY(90deg);
	-webkit-transform: rotateY(90deg);
	-moz-transform: rotateY(90deg);
}
.summer-group-05 .panel1{background: url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/panel1.png) no-repeat;}
.summer-group-05 .panel2{background: url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/panel2.png) no-repeat;}
.summer-group-05 .panel3{background: url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/panel3.png) no-repeat;}
.summer-group-05 .panel4{background: url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/panel4.png) no-repeat;}
.summer-group-05 .panel5{background: url(<?php echo ATTR_DOMAIN;?>/zt/summer-group/panel5.png) no-repeat;} 
.summer-group-05 .panelGroup .aniRotate{
	transition: 1s; 
	-webkit-transition: 1s; 
	-moz-transition: 1s;
	transform: rotateY(0deg);
	-webkit-transform: rotateY(0deg);
	-moz-transform: rotateY(0deg);
	opacity: 1;
	filter:alpha(opacity=100)
}
.summer-group-05 .panel1 .a1{width: 210px; height: 350px; left: 180px; top: 120px;}
.summer-group-05 .panel1 .a2{width: 220px; height: 350px; left: 570px; top: 130px;}
.summer-group-05 .panel1 .a3{width: 230px; height: 380px; left: 360px; top: 340px; z-index: 2;}
.summer-group-05 .panel1 .a4{width: 240px; height: 390px; left: 160px; top: 480px;}
.summer-group-05 .panel1 .a5{width: 290px; height: 380px; left: 520px; top: 510px;}

.summer-group-05 .panel2 .a1{width: 270px; height: 390px; left: 90px; top: 80px;}
.summer-group-05 .panel2 .a2{width: 270px; height: 390px; left: 580px; top: 90px;}
.summer-group-05 .panel2 .a3{width: 240px; height: 400px; left: 360px; top: 330px; z-index: 2;}
.summer-group-05 .panel2 .a4{width: 240px; height: 400px; left: 150px; top: 490px;}
.summer-group-05 .panel2 .a5{width: 320px; height: 400px; left: 520px; top: 490px;}

.summer-group-05 .panel3 .a1{width: 250px; height: 420px; left: 130px; top: 60px;}
.summer-group-05 .panel3 .a2{width: 250px; height: 430px; left: 600px; top: 50px;}
.summer-group-05 .panel3 .a3{width: 240px; height: 440px; left: 360px; top: 290px; z-index: 2;}
.summer-group-05 .panel3 .a4{width: 240px; height: 400px; left: 150px; top: 480px;}
.summer-group-05 .panel3 .a5{width: 270px; height: 400px; left: 520px; top: 480px;}

.summer-group-05 .panel4 .a1{width: 210px; height: 360px; left: 170px; top: 110px;}
.summer-group-05 .panel4 .a2{width: 180px; height: 370px; left: 590px; top: 110px;}
.summer-group-05 .panel4 .a3{width: 240px; height: 360px; left: 360px; top: 360px; z-index: 2;}
.summer-group-05 .panel4 .a4{width: 240px; height: 340px; left: 150px; top: 540px;}
.summer-group-05 .panel4 .a5{width: 280px; height: 360px; left: 520px; top: 530px;}

.summer-group-05 .panel5 .a1{width: 270px; height: 360px; left: 90px; top: 120px;}
.summer-group-05 .panel5 .a2{width: 200px; height: 390px; left: 580px; top: 90px;}
.summer-group-05 .panel5 .a3{width: 240px; height: 370px; left: 360px; top: 360px; z-index: 2;}
.summer-group-05 .panel5 .a4{width: 240px; height: 340px; left: 150px; top: 530px;}
.summer-group-05 .panel5 .a5{width: 320px; height: 350px; left: 520px; top: 530px;}

.summer-group-07 a{width: 246px; height: 356px; top: 0px;}
.summer-group-07 .a1{left: -14px;}
.summer-group-07 .a2{left: 236px;}
.summer-group-07 .a3{left: 486px;}
.summer-group-07 .a4{left: 736px;}
.summer-group-08 a{width: 246px; height: 356px; top: 0px;}
.summer-group-08 .a1{left: -14px;}
.summer-group-08 .a2{left: 236px;}
.summer-group-08 .a3{left: 486px;}
.summer-group-08 .a4{left: 736px;}
.summer-group-09 a{width: 246px; height: 356px; top: 0px;}
.summer-group-09 .a1{left: -14px;}
.summer-group-09 .a2{left: 236px;}
.summer-group-09 .a3{left: 486px;}
.summer-group-09 .a4{left: 736px;}
.summer-group-10 a{width: 246px; height: 356px; top: 0px;}
.summer-group-10 .a1{left: -14px;}
.summer-group-10 .a2{left: 236px;}
.summer-group-10 .a3{left: 486px;}
.summer-group-10 .a4{left: 736px;}

.summer-group-11 a{width: 246px; height: 356px; top: 0px;}
.summer-group-11 .a1{left: -14px;}
.summer-group-11 .a2{left: 236px;}
.summer-group-11 .a3{left: 486px;}
.summer-group-11 .a4{left: 736px;}
.summer-group-12 a{width: 246px; height: 356px; top: 0px;}
.summer-group-12 .a1{left: -14px;}
.summer-group-12 .a2{left: 236px;}
.summer-group-12 .a3{left: 486px;}
.summer-group-12 .a4{left: 736px;}
.summer-group-14 a{width: 220px; height: 220px; top: 110px;}
.summer-group-14 .a1{left: 102px;}
.summer-group-14 .a2{left: 370px;}
.summer-group-14 .a3{left: 636px;}
.summer-group-15 a{width: 220px; height: 220px; top: -6px;}
.summer-group-15 .a1{left: -18px;}
.summer-group-15 .a2{left: 242px;}
.summer-group-15 .a3{left: 504px;}
.summer-group-15 .a4{left: 764px;}
.summer-group-16 a{width: 220px; height: 220px; top: -7px;}
.summer-group-16 .a1{left: 102px;}
.summer-group-16 .a2{left: 370px;}
.summer-group-16 .a3{left: 636px;}
.summer-group-17 .backToTop{width: 256px; height: 66px; left: 350px; top: 26px;}

</style>

<script type="text/javascript">

$(function(){

	/*回到顶部*/
	$("#backTop").click(function() {
		$('body,html').stop().animate({scrollTop: 0}, 500);
		return false;
	});
})

</script>

<div class="zt-wrap">			
		<div class="summer-group-01"></div>
		<div class="summer-group-02"></div>
		<div class="summer-group-03"></div>
		<div class="summer-group-04"></div>
		<div class="summer-group-05">
			<div class="zt-con">
				<a href="javascript:void(0)" class="item item1"></a>
				<a href="javascript:void(0)" class="item item2"></a>
				<a href="javascript:void(0)" class="item item3"></a>
				<a href="javascript:void(0)" class="item item4"></a>
				<a href="javascript:void(0)" class="item item5"></a>
				<div class="panelGroup">
					<div class="panel1">
						<a href="http://www.g-emall.com/goods/1111297.html" title="菲拉格慕蓝色经典男士淡香水100ml" class="a1" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/1111258.html" title="菲拉格慕甜心魔力梦中情人小也女士淡香水清新持久留香氛生日礼物" class="a2" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/1111179.html" title="思妍丽/Decleor 橙花香薰精油 舒缓修复美白补水深层护理法国正品" class="a3" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/1181980.html" title="智能声波电动牙刷SG-909 3档变频充电式带底座 /3刷头" class="a4" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/1181364.html" title="日本 狮王LION SYSTEMA 静音 电动牙刷" class="a5" target="_blank"></a>
					</div>
					<div class="panel2">
						<a href="http://www.g-emall.com/goods/1302156.html" title="女童连衣裙 2016新款夏装 中大童欧根纱露肩公主裙" class="a1" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/1301116.html" title="2016夏季新款童裙女童欧根纱无袖连衣裙中大童韩版碎花公主裙" class="a2" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/1301342.html" title="2016童装夏季新款女童雪纺衫小飞袖连衣裙中大童韩版印花公主裙子" class="a3" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/1300513.html" title="2016夏女童欧美连衣裙 吊带漏肩新款童裙背心绣花大童公主裙" class="a4" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/1299445.html" title="2016新款童装中大童棉麻娃娃衫女童连衣裙童裙韩版" class="a5" target="_blank"></a>
					</div>
					<div class="panel3">
						<a href="http://www.g-emall.com/goods/1293801.html" title="2016俏丽町中老年女装新款连衣裙大码妈妈装修身显瘦印花连衣裙3XL4XL5XL" class="a1" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/1293458.html" title="2016夏季新款名媛女装两件套连衣裙中裙蕾丝短袖套裙纱网裙套装女" class="a2" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/1359494.html" title="2016俏丽町新款女装夏装连衣裙两件套夏季韩版衣服时尚套装阔腿裤裙女潮" class="a3" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/1291664.html" title="孕妇装夏季纯棉t恤雪纺裙加内衬可哺乳两件套装外出孕妇连衣裙舒适女装" class="a4" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/1292973.html" title="韩版2016夏新款短袖中长款大T恤裙休闲修身纯棉开叉加长体恤女简单女装" class="a5" target="_blank"></a>
					</div>
					<div class="panel4">
						<a href="http://www.g-emall.com/goods/66597.html" title="韩国专柜 兰芝豹纹气垫BB霜 送替换装 13#象牙白 21#自然白 两色可选" class="a1" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/349661.html" title="专柜正品 法国施蒂魔力修颜BB霜 50ml 两色可选" class="a2" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/348542.html" title="专柜正品 法国施蒂魅惑浓郁眼线膏" class="a3" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/347903.html" title="专柜正品 法国施蒂水晶闪亮唇冻 15g 四色可选" class="a4" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/66935.html" title="韩国专柜 可莱丝/Clinie 蜗牛舒缓AC抗敏面膜贴 10片装" class="a5" target="_blank"></a>
					</div>
					<div class="panel5">
						<a href="http://www.g-emall.com/goods/134228.html" title="【韩多美】韩多美善肌花漾甜心美肌香氛沐浴露 美白保湿补水女士香水沐浴乳 粉色玫瑰樱花沐浴露" class="a1" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/1256158.html" title="【韩多美】韩多美松茸蜗牛修复舒敏蚕丝面膜6片 春夏补水保湿亮肤紧肤细毛孔" class="a2" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/132137.html" title="【法迪瑞娜】正品法迪瑞娜红茶/黑茶抗衰驻颜修护补水蚕丝面膜28ml*5片 保湿紧致滋养抗氧化 提拉抗皱修护补水保湿滋润" class="a3" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/111848.html" title="水密码 冰川矿泉系列 睡眠面膜/免洗面膜 补水保湿 美白抗皱 丹姿正品" class="a4" target="_blank"></a>
						<a href="http://www.g-emall.com/goods/115281.html" title="馥珮洗面奶水感透白洗颜泥120g 男女控油美白补水保湿爽肤洁面乳 补水洗面奶 清洁、补水、美白" class="a5" target="_blank"></a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="summer-group-06"></div>
		<div class="summer-group-07">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/1106818.html" title="玫瑰阿胶糕 100g" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1106603.html" title="红枣阿胶糕 100g" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/57822.html" title="兰芝 水滴敏感肌肤专用防晒霜50ml " class="a3" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1342050.html" title="珍嗖啦酵素果冻 一盒" class="a4" target="_blank"></a>
			</div>
		</div>
		<div class="summer-group-08">
			<div class="zt-con">
				<a href="http://www.g-emall.com/goods/109618.html" title="COCO香型香水小姐沐浴露" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/163611.html" title="可莱丝Clinie NMF针剂水库面膜 10片装" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1327379.html" title="韩版连衣裙女夏2016俏丽町新款短袖印花半身裙中长款修身显瘦两件套装裙" class="a3" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1305319.html" title="2016俏丽町夏装新款欧根纱雪纺花边收腰连衣裙女装甜美无袖背心打底裙子" class="a4" target="_blank"></a>
			</div>
		</div>
		<div class="summer-group-09">
			<div class="zt-con">
				<a href="http://www.g-emall.com/goods/1302336.html" title="2016俏丽町夏新款女短袖连衣裙民族风宽松大码棉麻复古刺绣连衣裙" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/716763.html" title="BB宝宝袜子 儿童全棉婴儿袜子男童女童宝宝袜纯棉（3双）" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/716722.html" title="儿童全棉婴儿袜子批发春秋冬男童女童宝宝袜纯棉 BB防滑地板袜子（3双）" class="a3" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/716812.html" title="品牌全棉卡通提花女童打底裤米若克同款脚底猫儿童连裤袜" class="a4" target="_blank"></a>
			</div>
		</div>
		<div class="summer-group-10">
			<div class="zt-con">
				<a href="http://www.g-emall.com/goods/718712.html" title="2016年春装新款糖果色小脚破洞仿牛仔裤打底裤" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/718573.html" title="新款韩版童装女童打底裤立体感裤子" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/617362.html" title="正品山拓COOLMAX速干防臭户外袜子男士排汗快干袜船袜短袜" class="a3" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/459491.html" title="弹性男女户外运动护脚踝" class="a4" target="_blank"></a>
			</div>
		</div>

		<div class="summer-group-11">
			<div class="zt-con">
				<a href="http://www.g-emall.com/goods/57837.html" title="韩国专柜 兰芝 雪纱防晒隔离霜SPF26 PA+美白清透 30ml 60#绿色 40#紫色 两色可选" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/57816.html" title="韩国专柜 兰芝 4合一多效洁面乳洗面奶180ML" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/274780.html" title="【贝维诗】贝维诗无硅油防脱发生姜洗发水正品无硅男女士控油去油姜汁脂溢性 无硅油配方 控油防脱发 温和不刺激 男女通用型" class="a3" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/207730.html" title="3ce 三只眼黑管口红 十四色可选" class="a4" target="_blank"></a>
			</div>
		</div>
		<div class="summer-group-12">
			<div class="zt-con">
				<a href="http://www.g-emall.com/goods/250517.html" title="【恩惠小屋】韩国正品恩惠小屋彩妆3CE 三只眼修容定妆粉饼 美白遮瑕 防晒控油 3色" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/113015.html" title="【丹姿】丹姿 收缩毛孔细致洗面奶 美白补水深层清洁去黑头 洁面乳男女正品" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/1122663.html" title="韩国DENTALPROJECT漱口水去口臭除细菌清新口气正250ml" class="a3" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/1127941.html" title="韩国进口欧志姆O-ZONE孕产妇健齿牙膏无氟月子孕妇专用牙膏防孕吐" class="a4" target="_blank"></a>
			</div>
		</div>
		<div class="summer-group-14">
			<div class="zt-con">
				<a href="http://www.g-emall.com/shop/8324.html" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/8745.html" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/7191.html" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="summer-group-15">
			<div class="zt-con">
				<a href="http://www.g-emall.com/shop/1082.html" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/2197.html" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/5877.html" class="a3" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/2613.html" class="a4" target="_blank"></a>
			</div>
		</div>
		<div class="summer-group-16">
			<div class="zt-con">
				<a href="http://www.g-emall.com/shop/8184.html" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/8322.html" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/6503.html" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="summer-group-17">
			<div class="zt-con">
				<a href="javascript:void(0)" class="backToTop"></a>
			</div>
		</div>
		
			
	</div>   
   <!--------------主体 End------------>
   
   <script type="text/javascript">
$(function(){
	$('.panel1').addClass('aniRotate');
	var index = 0;
	var len = $('.item').length;
	var timer = null;
	function aniRotate(){
		index++;
		if (index>=len) {
			index = 0;
		}
		$('.panelGroup div').removeClass('aniRotate');
		$('.panelGroup div').eq(index).addClass('aniRotate');
	}
	timer = setInterval(aniRotate,3000);
	$('.item').hover(function(){
		clearInterval(timer);
	},function(){
		timer = setInterval(aniRotate,3000);
	})
	$('.item').click(function(){
		index = $(this).index();
		$('.panelGroup div').removeClass('aniRotate');
		$('.panelGroup div').eq(index).addClass('aniRotate');
	})
	/*回到顶部*/
	$("#backTop,.backToTop").click(function() {
		$('body,html').stop().animate({scrollTop: 0}, 500);
		return false;
	});
})
</script>