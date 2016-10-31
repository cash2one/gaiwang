
<?php $this->pageTitle = "盖象商城-宠物用品" ;?>
<style>
/*=====
    @Date:2016-05-30
    @content:宠物用品
	@author:林聪毅
 =====*/
.zt-wrap{width:100%; background:#fff; overflow: hidden;}
.zt-con { width:968px; margin:0 auto; position:relative; }
.zt-con a{ position:absolute;display:block;}
.pet-01{height:393px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-01.jpg) top center no-repeat;}
.pet-02{height:392px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-02.jpg) top center no-repeat;}
.pet-03{height:363px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-03.jpg) top center no-repeat;}
.pet-04{height:543px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-04.jpg) top center no-repeat;}
.pet-05{height:414px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-05.jpg) top center no-repeat;}
.pet-06{height:753px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-06.jpg) top center no-repeat;}
.pet-07{height:776px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-07.jpg) top center no-repeat;}
.pet-08{height:786px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-08.jpg) top center no-repeat;}
.pet-09{height:350px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-09.jpg) top center no-repeat;}
.pet-10{height:522px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-10.jpg) top center no-repeat;}

.pet-11{height:460px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-11.jpg) top center no-repeat;}
.pet-12{height:716px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-12.jpg) top center no-repeat;}
.pet-13{height:569px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-13.jpg) top center no-repeat;}
.pet-14{height:482px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-14.jpg) top center no-repeat;}
.pet-15{height:410px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-15.jpg) top center no-repeat;}
.pet-16{height:509px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-16.jpg) top center no-repeat;}
.pet-17{height:544px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-17.jpg) top center no-repeat;}
.pet-18{height:196px; background:url(<?php echo ATTR_DOMAIN;?>/zt/pet/pet-18.jpg) top center no-repeat;}

.pet-03 a{}
.pet-03 .a1{width: 142px; height: 142px; left: 268px; top: 86px;}
.pet-03 .a2{width: 134px; height: 134px; left: 404px; top: 184px;}
.pet-03 .a3{width: 120px; height: 120px; left: 554px; top: 94px;}
.pet-03 .dog{width: 150px; height: 117px; display: block; position: absolute; left: 60px; top: 200px; background: url(<?php echo ATTR_DOMAIN;?>/zt/pet/dog.png) no-repeat;}
.pet-05 a{}
.pet-05 .a1{width: 500px; height: 300px; left: -10px; top: 70px;}
.pet-05 .a2{width: 470px; height: 300px; left: 530px; top: 80px;}
.pet-06 a{width: 300px; height: 420px; top: 60px;}
.pet-06 .a1{left: -30px;}
.pet-06 .a2{left: 330px;}
.pet-06 .a3{left: 690px;}
.pet-07 a{width: 300px; height: 420px; top: 174px;}
.pet-07 .a1{left: -30px;}
.pet-07 .a2{left: 330px;}
.pet-07 .a3{left: 690px;}
.pet-08 a{width: 300px; height: 420px; top: 188px;}
.pet-08 .a1{left: -30px;}
.pet-08 .a2{left: 330px;}
.pet-08 .a3{left: 690px;}
.pet-10 a{width: 260px; height: 350px; top: 160px;}
.pet-10 .a1{left: 26px;}
.pet-10 .a2{left: 316px;}
.pet-10 .a3{left: 600px;}

.pet-11 a{width: 260px; height: 350px; top: 20px;}
.pet-11 .a1{left: 26px;}
.pet-11 .a2{left: 316px;}
.pet-12 a{}
.pet-12 .a1{width: 360px; height: 330px; left: -30px; top: 180px;}
.pet-12 .a2{width: 430px; height: 100px; left: 480px; top: 180px;}
.pet-12 .a3{width: 430px; height: 150px; left: 490px; top: 320px; z-index: 2;}
.pet-12 .a4{width: 440px; height: 230px; left: 350px; top: 430px;}
.pet-13 a{width: 260px; height: 350px; top: 200px;}
.pet-13 .a1{left: 26px;}
.pet-13 .a2{left: 316px;}
.pet-13 .a3{left: 604px;}
.pet-14 a{width: 260px; height: 350px; top: 10px;}
.pet-14 .a1{left: 300px;}
.pet-14 .a2{left: 600px;}
.pet-16 a{width: 300px; height: 420px; top: 70px;}
.pet-16 .a1{left: 140px;}
.pet-16 .a2{left: 480px;}
.pet-17 a{width: 300px; height: 420px; top: 12px;}
.pet-17 .a1{left: 140px;}
.pet-17 .a2{left: 480px;}
.pet-18 .backToTop{width: 280px; height: 190px; left: 320px; top: 0px;}

.dog{
	animation: roundMove 1s linear;
}
@keyframes roundMove{
	0%{transform:translate(0,-180px);}
	25%{transform:translate(-80px,-150px);}
	50%{transform:translate(-120px,-90px);}
	75%{transform:translate(-80px,-60px);}
	100%{transform:translate(0,0);}
}
@-webkit-keyframes roundMove{
	0%{-webkit-transform:translate(0,-180px);}
	25%{-webkit-transform:translate(-80px,-150px);}
	50%{-webkit-transform:translate(-120px,-90px);}
	75%{-webkit-transform:translate(-80px,-60px);}
	100%{-webkit-transform:translate(0,0);}
}
@-moz-keyframes roundMove{
	0%{-moz-transform:translate(0,-180px);}
	25%{-moz-transform:translate(-80px,-150px);}
	50%{-moz-transform:translate(-120px,-90px);}
	75%{-moz-transform:translate(-80px,-60px);}
	100%{-moz-transform:translate(0,0);}
}

</style>	
	<div class="zt-wrap">			
		<div class="pet-01"></div>
		<div class="pet-02"></div>
		<div class="pet-03">
			<div class="zt-con">
				<a href="#part1" class="a1"></a>
				<a href="#part2" class="a2"></a>
				<a href="#part3" class="a3"></a>
				<span class="dog"></span>
			</div>
		</div>
		<div class="pet-04" id="part1"></div>
		<div class="pet-05">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/223744.html" title="[果脯屋]幼猫猫粮天然粮 好主人猫粮 1.5kg希腊橄榄油金枪鱼猫粮 幼猫粮" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/190029.html" title="[果脯屋]好主人 成猫猫粮牛肉+肝味通用猫主粮小颗粒10kg/500g*20包" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="pet-06">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/1047258.html" title="皇家猫粮K36幼猫猫粮2kg波斯猫布偶猫折耳宠物猫咪食物正品包邮z_UID213" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/599691.html" title="幼猫粮 75%鲜肉" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/599635.html" title="成猫粮  含72%鲜肉" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="pet-07">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/816711.html" title="宠物清洁用品怡亲膨润土猫砂柠檬香型猫砂5L除臭抗菌猫砂2包" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/710121.html" title="日本Sanmate砂美特膨润土猫砂10L" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/322128.html" title="猫砂盆" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="pet-08">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/814716.html" title="猫沐浴露 猫咪专用香波猫洗澡用品SOS猫咪沐浴露" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/199596.html" title="【雪貂留香】猫咪专用沐浴露 雪貂留香 杀菌除跳蚤灭虱猫猫洗澡宠物用品" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/795553.html" title="澳路雪猫喷鼻香波_h抗菌驱虫赛级猫专用宠物洗澡露400ml猫整洁用品包邮_UID301" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="pet-09" id="part2"></div>
		<div class="pet-10">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/1122490.html" title="迪比克泰迪狗粮成犬上宾博美比熊主粮小型犬自然粮美毛去泪痕2kg" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/190054.html" title="[果脯屋]好主人狗粮 幼犬狗粮天然粮 1.5kg鸡肉燕麦羊奶奶糕粮" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1095755.html" title="狗粮泰迪比熊贵宾博美雪纳瑞金毛 幼犬成中小型犬通用型天然粮3斤" class="a3" target="_blank"></a>
			</div>
		</div>

		<div class="pet-11">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/529139.html" title="海瑞特鲜肉狗粮（含63鲜肉）贵宾成犬" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1098929.html" title="【忘不了】耐威克泰迪狗粮成犬自然宠物粮5斤_79821" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="pet-12">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/801087.html" title="自动伸缩狗绳狗狗牵引绳金毛泰迪猫咪绳中型小型犬狗链子宠物用品" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/984752.html" title="狗碗狗盆狗狗用品狗食盆 猫碗宠物用品" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/622827.html" title="宠物玩具 狗狗训练网球 脚印图案 手抛球" class="a3" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/962274.html" title="宠物拾便器 加长手柄拾便器 狗狗夹便器 养宠必备 各犬型通用" class="a4" target="_blank"></a>
			</div>
		</div>
		<div class="pet-13">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/710597.html" title="狗狗洗澡盆宠物泰迪可折叠游泳池狗澡盆金毛大型犬浴盆" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/817298.html" title="狗狗洗澡刷子 五指手套宠物按摩刷 猫咪清洁用品工具" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/220407.html" title="【雪貂留香】狗狗沐浴露雪貂留香艾沐系列泰迪金毛比熊萨摩耶除菌止痒洗澡香波宠物用品" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="pet-14">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/817508.html" title="狗狗沐浴露泰迪金毛萨摩耶比熊宠物用品猫咪洗澡香波杀菌除臭止痒" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/205128.html" title="【卡露诗】卡露诗狗狗沐浴露 蓬松有型宠物香波留香久泰迪浴液宠物洗澡用品" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="pet-15" id="part3"></div>
		<div class="pet-16">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/998857.html" title="夏天猫窝狗窝柳编猫窝猫舍猫屋猫笼宠物窝草狗窝藤编泰迪窝小狗窝" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/998928.html" title="藤编猫窝夏柳编猫屋狗窝泰迪小型犬宠物窝可拆洗狗窝猫房子蒙古包" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="pet-17">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/816025.html" title="狗窝可拆洗泰迪比熊金毛宠物猫窝萨摩耶大型犬狗床" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1201861.html" title="狗窝可拆洗炎天泰迪犬金毛四时宠物窝年夜号狗床垫子萨摩耶狗狗用品_17083" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="pet-18">
			<div class="zt-con">
				<a href="javascript:void(0)" class="backToTop"></a>
			</div>
		</div>
	</div>   
   <!--------------主体 End------------>
   
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