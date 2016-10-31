<?php  echo $this->pageTitle="盖象商城-职场达人秀"; ?>

<style>
/*=====
    @Date:2016-08-11
    @content:职场达人秀
	@author:林聪毅
 =====*/
.zt-wrap{width:100%; background:#fff; overflow: hidden;}
.zt-con { width:968px; margin:0 auto; position:relative; }
.zt-con a{ position:absolute;display:block;}
.office-stationery-01{height:169px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-01.jpg) top center no-repeat;}
.office-stationery-02{height:169px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-02.jpg) top center no-repeat;}
.office-stationery-03{height:169px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-03.jpg) top center no-repeat;}
.office-stationery-04{height:169px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-04.jpg) top center no-repeat;}
.office-stationery-05{height:223px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-05.jpg) top center no-repeat;}
.office-stationery-06{height:223px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-06.jpg) top center no-repeat;}
.office-stationery-07{height:222px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-07.jpg) top center no-repeat;}
.office-stationery-08{height:223px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-08.jpg) top center no-repeat;}
.office-stationery-09{height:223px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-09.jpg) top center no-repeat;}
.office-stationery-10{height:257px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-10.jpg) top center no-repeat;}

.office-stationery-11{height:256px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-11.jpg) top center no-repeat;}
.office-stationery-12{height:257px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-12.jpg) top center no-repeat;}
.office-stationery-13{height:257px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-13.jpg) top center no-repeat;}
.office-stationery-14{height:256px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-14.jpg) top center no-repeat;}
.office-stationery-15{height:257px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-15.jpg) top center no-repeat;}
.office-stationery-16{height:257px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-16.jpg) top center no-repeat;}
.office-stationery-17{height:257px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-17.jpg) top center no-repeat;}
.office-stationery-18{height:257px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-18.jpg) top center no-repeat;}
.office-stationery-19{height:258px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-19.jpg) top center no-repeat;}
.office-stationery-20{height:258px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-20.jpg) top center no-repeat;}

.office-stationery-21{height:258px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-21.jpg) top center no-repeat;}
.office-stationery-22{height:256px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-22.jpg) top center no-repeat;}
.office-stationery-23{height:256px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-23.jpg) top center no-repeat;}
.office-stationery-24{height:256px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-24.jpg) top center no-repeat;}
.office-stationery-25{height:257px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-25.jpg) top center no-repeat;}
.office-stationery-26{height:258px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-26.jpg) top center no-repeat;}
.office-stationery-27{height:257px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-27.jpg) top center no-repeat;}
.office-stationery-28{height:257px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-28.jpg) top center no-repeat;}
.office-stationery-29{height:258px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-29.jpg) top center no-repeat;}
.office-stationery-30{height:257px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-30.jpg) top center no-repeat;}

.office-stationery-31{height:214px; background:url(<?php echo ATTR_DOMAIN;?>/zt/office-stationery/office-stationery-31.jpg) top center no-repeat;}

.office-stationery-05 a{width: 190px; height: 60px;}
.office-stationery-05 .a1{left: 444px; top: 210px;}
.office-stationery-05 .a2{left: 744px; top: 268px;}
.office-stationery-05 .a3{left: 744px; top: 382px;}
.office-stationery-05 .a4{left: 82px; top: 506px;}
.office-stationery-05 .a5{left: 796px; top: 610px;}
.office-stationery-05 .a6{left: 846px; top: 480px;}
.office-stationery-05 .a7{left: 842px; top: 184px;}
.office-stationery-10 a{width: 346px; height: 414px; top: 158px;}
.office-stationery-10 .a1{left: 29px;}
.office-stationery-10 .a2{left: 377px;}
.office-stationery-10 .a3{left: 724px;}

.office-stationery-13 a{width: 346px; height: 414px; top: 148px;}
.office-stationery-13 .a1{left: -103px;}
.office-stationery-13 .a2{left: 244px;}
.office-stationery-13 .a3{left: 590px;}
.office-stationery-16 a{width: 346px; height: 414px; top: 152px;}
.office-stationery-16 .a1{left: 29px;}
.office-stationery-16 .a2{left: 377px;}
.office-stationery-16 .a3{left: 724px;}
.office-stationery-19 a{width: 346px; height: 414px; top: 140px;}
.office-stationery-19 .a1{left: -103px;}
.office-stationery-19 .a2{left: 244px;}
.office-stationery-19 .a3{left: 590px;}

.office-stationery-22 a{width: 346px; height: 414px; top: 138px;}
.office-stationery-22 .a1{left: 29px;}
.office-stationery-22 .a2{left: 377px;}
.office-stationery-22 .a3{left: 724px;}
.office-stationery-25 a{width: 346px; height: 414px; top: 152px;}
.office-stationery-25 .a1{left: -103px;}
.office-stationery-25 .a2{left: 244px;}
.office-stationery-25 .a3{left: 590px;}
.office-stationery-28 a{width: 346px; height: 414px; top: 142px;}
.office-stationery-28 .a1{left: 29px;}
.office-stationery-28 .a2{left: 377px;}
.office-stationery-28 .a3{left: 724px;}

.office-stationery-31 .backToTop{width: 290px; height: 110px; left: 364px; top: 60px;}

</style>

	<div class="zt-wrap">			
		<div class="office-stationery-01"></div>
		<div class="office-stationery-02"></div>
		<div class="office-stationery-03"></div>
		<div class="office-stationery-04"></div>
		<div class="office-stationery-05">
			<div class="zt-con">
				<a href="#part1" class="a1"></a>
				<a href="#part2" class="a2"></a>
				<a href="#part3" class="a3"></a>
				<a href="#part4" class="a4"></a>
				<a href="#part5" class="a5"></a>
				<a href="#part6" class="a6"></a>
				<a href="#part7" class="a7"></a>
			</div>
		</div>
		<div class="office-stationery-06"></div>
		<div class="office-stationery-07"></div>
		<div class="office-stationery-08"></div>
		<div class="office-stationery-09"></div>
		<div class="office-stationery-10" id="part1">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/1647342.html" title="富贵竹水培办公室盆栽竹子绿色植物盆景水生植物室内绿植转运竹" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1911083.html" title="联想一体机/台式机电脑Lenovo/联想 AIO 300 双核G4400T/20英寸屏" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/2067941.html" title="50674_科润电脑椅家用休闲椅子特价座椅网布人体工学转椅人员会议办公椅_63429" class="a3" target="_blank"></a>
			</div>
		</div>

		<div class="office-stationery-11"></div>
		<div class="office-stationery-12"></div>
		<div class="office-stationery-13" id="part2">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/1915339.html" title="得力/deli 5109 资料册 A4 100页文件夹 袋式资料夹 文件收纳夹" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/2023993.html" title="Midea/美的饮水机立式冷热冰热YR1226S-W制冷热家用双门正品特价" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1525849.html" title="室内花卉 盆景植物 发财树盆栽 客厅创意花草 大型绿植 净化空气 本店发财树 树形漂亮 叶子饱满 一盆包邮" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="office-stationery-14"></div>
		<div class="office-stationery-15"></div>
		<div class="office-stationery-16" id="part3">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/2023623.html" title="电表箱装饰画遮挡推拉式配电箱壁画餐厅客厅电闸液压上翻式挂画" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/2053676.html" title="美的可充电池式led小台灯护眼学习卧室床头书桌USB带夹子夹式夹灯" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/2067200.html" title="【双品】生意办公家具钢制文件柜铁皮柜档案柜资料柜_财政根据柜" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="office-stationery-17"></div>
		<div class="office-stationery-18"></div>
		<div class="office-stationery-19" id="part4">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/2004285.html" title="郑板桥水墨国画客厅装饰画新中式书房玄关沙发背景墙挂画三联壁画" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1976052.html" title="806_Rigal投影仪家用_办公投影机高清1080P_商务3D手机无线wifi" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1813031.html" title="爱优尚年夜万年轻_盆栽花卉室内_室内好养净化空气植物_吸甲醛植物" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="office-stationery-20"></div>

		<div class="office-stationery-21"></div>
		<div class="office-stationery-22" id="part5">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/1888381.html" title="年夜绿萝吊兰绿植盆栽花卉室内吸甲醛净化空气办公桌面年夜盆水培育提拔物_72368" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1804920.html" title="华硕台式机电脑K20CE 台式机家庭娱乐商务办公电脑独立显卡分期" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1692005.html" title="中诺C282 话务专用耳机电话机 呼叫中心坐席客服耳麦座机 电脑录音" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="office-stationery-23"></div>
		<div class="office-stationery-24"></div>
		<div class="office-stationery-25" id="part6">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/2238785.html" title="卷帘铝合金防水遮光办公室厨房洗手间免打孔_FdTlr" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/1885896.html" title="高档青花瓷花瓶_家居润饰品【年夜号】_景德镇陶磁器_现代家饰摆件_lsXrW" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/215377.html" title="迈卓 天道酬勤 张玉柱书法作品100%大师真迹 字画书法办公室横幅 商业励志真迹豪华家装 送亲朋领导 不含框 已装裱四尺180*80" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="office-stationery-26"></div>
		<div class="office-stationery-27"></div>
		<div class="office-stationery-28" id="part7">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/1959745.html" title="松下电话机KX-TG70CN数字无绳电话中文无线座机家用 子母机一拖一" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/69479.html" title="【苹果Apple】【龙腾数码】Apple 配备Retina显示屏的MacBook Pro MF839CH/A 13.3英寸宽屏笔记本电脑" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/439372.html" title="君子兰" class="a3" target="_blank"></a>
			</div>
		</div>
		<div class="office-stationery-29"></div>
		<div class="office-stationery-30"></div>

		<div class="office-stationery-31">
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