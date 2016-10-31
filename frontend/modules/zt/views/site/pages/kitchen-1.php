<?php $this->pageTitle='盖象商城-中西厨房大PK'; ?>

<style>

/*=====
    @Date:2016-08-30
    @content:中西厨房大PK
	@author:林聪毅
 =====*/
.zt-wrap{width:100%; background:#fff; overflow: hidden;}
.zt-con { width:968px; margin:0 auto; position:relative; }
.zt-con a{ position:absolute;display:block;}
.kitchen-1-01{height:308px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-01.jpg) top center no-repeat;}
.kitchen-1-02{height:309px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-02.jpg) top center no-repeat;}
.kitchen-1-03{height:308px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-03.jpg) top center no-repeat;}
.kitchen-1-04{height:503px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-04.jpg) top center no-repeat;}
.kitchen-1-05{height:182px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-05.jpg) top center no-repeat;}
.kitchen-1-06{height:181px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-06.jpg) top center no-repeat;}
.kitchen-1-07{height:591px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-07.jpg) top center no-repeat;}
.kitchen-1-08{height:357px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-08.jpg) top center no-repeat;}
.kitchen-1-09{height:354px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-09.jpg) top center no-repeat;}
.kitchen-1-10{height:400px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-10.jpg) top center no-repeat;}

.kitchen-1-11{height:400px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-11.jpg) top center no-repeat;}
.kitchen-1-12{height:222px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-12.jpg) top center no-repeat;}
.kitchen-1-13{height:222px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-13.jpg) top center no-repeat;}
.kitchen-1-14{height:292px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-14.jpg) top center no-repeat;}
.kitchen-1-15{height:291px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-15.jpg) top center no-repeat;}
.kitchen-1-16{height:224px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-16.jpg) top center no-repeat;}
.kitchen-1-17{height:224px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-17.jpg) top center no-repeat;}
.kitchen-1-18{height:220px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-18.jpg) top center no-repeat;}
.kitchen-1-19{height:220px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-19.jpg) top center no-repeat;}
.kitchen-1-20{height:222px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-20.jpg) top center no-repeat;}

.kitchen-1-21{height:222px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-21.jpg) top center no-repeat;}
.kitchen-1-22{height:219px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-22.jpg) top center no-repeat;}
.kitchen-1-23{height:219px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-23.jpg) top center no-repeat;}
.kitchen-1-24{height:296px; background:url(<?php echo ATTR_DOMAIN;?>/zt/kitchen-1/kitchen-1-24.jpg) top center no-repeat;}

.kitchen-1-07 a{}
.kitchen-1-07 .a1{width: 550px; height: 320px; left: -80px; top: 240px;}
.kitchen-1-07 .a2{width: 510px; height: 420px; left: 530px; top: 150px;}
.kitchen-1-08 a{}
.kitchen-1-08 .a1{width: 550px; height: 320px; left: -70px; top: 20px;}
.kitchen-1-08 .a2{width: 460px; height: 330px; left: 580px; top: 20px;}
.kitchen-1-09 a{}
.kitchen-1-09 .a1{width: 510px; height: 320px; left: -40px; top: 20px;}
.kitchen-1-09 .a2{width: 500px; height: 240px; left: 530px; top: 60px;}
.kitchen-1-10 a{}
.kitchen-1-10 .a1{width: 530px; height: 280px; left: -50px; top: 70px;}
.kitchen-1-10 .a2{width: 500px; height: 350px; left: 540px; top: 10px;}

.kitchen-1-11 a{}
.kitchen-1-11 .a1{width: 570px; height: 340px; left: -100px; top: 10px;}
.kitchen-1-11 .a2{width: 480px; height: 360px; left: 550px; top: 10px;}
.kitchen-1-12 a{}
.kitchen-1-12 .a1{width: 480px; height: 280px; left: -10px; top: 50px;}
.kitchen-1-12 .a2{width: 500px; height: 300px; left: 530px; top: 30px;}
.kitchen-1-14 a{}
.kitchen-1-14 .a1{width: 550px; height: 360px; left: -70px; top: 180px;}
.kitchen-1-14 .a2{width: 550px; height: 360px; left: 530px; top: 150px;}
.kitchen-1-16 a{}
.kitchen-1-16 .a1{width: 540px; height: 430px; left: -70px; top: 60px;}
.kitchen-1-16 .a2{width: 620px; height: 350px; left: 500px; top: 60px;}
.kitchen-1-18 a{}
.kitchen-1-18 .a1{width: 550px; height: 340px; left: -70px; top: 60px;}
.kitchen-1-18 .a2{width: 520px; height: 350px; left: 500px; top: 60px;}
.kitchen-1-20 a{}
.kitchen-1-20 .a1{width: 550px; height: 350px; left: -70px; top: 60px;}
.kitchen-1-20 .a2{width: 520px; height: 350px; left: 500px; top: 60px;}
.kitchen-1-22 a{}
.kitchen-1-22 .a1{width: 550px; height: 350px; left: -70px; top: 60px;}
.kitchen-1-22 .a2{width: 600px; height: 350px; left: 500px; top: 60px;}
.kitchen-1-24 a{}
.kitchen-1-24 .more{width: 580px; height: 70px; left: 194px; top: 128px;}

</style>
	
	<div class="zt-wrap">			
		<div class="kitchen-1-01"></div>
		<div class="kitchen-1-02"></div>
		<div class="kitchen-1-03"></div>
		<a href="<?php echo $this->createAbsoluteUrl('/zt/site/kitchen-2')?>" target='_blank'><div class="kitchen-1-04"></div></a>
		<div class="kitchen-1-05"></div>
		<div class="kitchen-1-06"></div>
		<div class="kitchen-1-07">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/559204.html" title="格力TOSOT/大松 GDF-2001 迷你电饭煲家用2L不粘锅电饭煲 迷你苹果煲 小功率 小型电饭煲 格力正品" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/383948.html" title="魅尚水果冰淇淋机家用全自动冰激凌机雪糕机迷你刨冰机多功能" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="kitchen-1-08">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/687223.html" title="【Gree/格力】格力TOSOT大松GDCF-4001Ca电饭煲家用4L智能IH电饭锅多功能 三维立体加热 4L大容量 预约定时 高端触控屏 正品" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/383927.html" title="魅尚迷你电动果汁杯榨果汁机家用全自动榨汁机 便携USB" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="kitchen-1-09">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/1607238.html" title="【Gree/格力】格力TOSOT/大松电磁炉GC-21XSM 家用多功能智 高档触摸式送汤炒锅 格力原厂直供 超薄触摸屏 彩晶面板 二级能效" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/558211.html" title="苏格伦家用净水器 水龙头净水器过滤器 净水机小家电" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="kitchen-1-10">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/383660.html" title="MAXSOME魅尚迷你电饭煲1.5L学生电饭煲1-2人小电饭煲宿舍煲" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/382616.html" title="【主打爆款】加热技术真破壁机调理养生机 家用破壁料理机" class="a2" target="_blank"></a>
			</div>
		</div>

		<div class="kitchen-1-11">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/510710.html" title="红外线聚能灶 煤气灶 高聚能真低碳节能燃气灶 JZT-223" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/305570.html" title="金满圆 玻璃破壁机多功能料理机粉粹机真破壁加热高端养生" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="kitchen-1-12">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/383480.html" title="魅尚保温电水壶不锈钢烧水壶电热水壶烧开水壶电茶壶" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/382397.html" title="新款 绞肉机家用金属齿轮商用电动蒜泥碎肉碎菜机料理机" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="kitchen-1-13"></div>
		<div class="kitchen-1-14">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/2075281.html" title="哲品陶瓷茶点盘点心盘带盖 客厅创意三层糖果盘子干果罐拾趣配件" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/286588.html" title="越美窑 景德镇陶瓷56头陶瓷餐具套装 龙腾盛世釉中彩碗碟套装 高档骨瓷餐具" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="kitchen-1-15"></div>
		<div class="kitchen-1-16">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/1300812.html" title="哲品陶瓷餐具套装福碗 家用饭碗汤碗菜盘调味酱碟子实木筷6件套组" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1607920.html" title="友来福 深夏六出 象牙瓷 创意欧式厨房 家居用品套装" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="kitchen-1-17"></div>
		<div class="kitchen-1-18">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/468990.html" title="哲品花果茶具配件调味罐套装创意糖盐透明玻璃瓶带盖含木勺子底座" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/470420.html" title="友来福 象牙瓷烟灰缸创意奢华 陶瓷客厅摆件 复古欧式时尚雪茄烟灰缸个性圆" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="kitchen-1-19"></div>
		<div class="kitchen-1-20">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/207083.html" title="哲品家居 景德镇陶瓷 白瓷罗纹钵四碗四筷餐具礼品套装 限区包邮" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/470464.html" title="友来福 深夏六出 象牙瓷筷子筒  欧式陶瓷筷子筒套装 筷子架 筷子托 E049" class="a2" target="_blank"></a>
			</div>
		</div>

		<div class="kitchen-1-21"></div>
		<div class="kitchen-1-22">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/480373.html" title="魅尚极速磨刀神器家用多功能菜刀电动砂轮金刚石磨刀机定角万能" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1609892.html" title="友来福 象牙瓷欧式咖啡杯套装 英式茶杯茶具杯碟 欧美陶瓷红茶杯下午茶杯子" class="a2" target="_blank"></a>
			</div>
		</div>
		<div class="kitchen-1-23"></div>
		<div class="kitchen-1-24">
			<div class="zt-con">
				<a href="http://active.g-emall.com/festive/detail/244" class="more" target="_blank"></a>
			</div>
		</div>
	</div>   
   <!--------------主体 End------------>
 