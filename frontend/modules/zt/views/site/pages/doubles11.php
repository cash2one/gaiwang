<?php 

//Tool::pr(Vote::getVoteAll(Vote::TYPE_FZ_VOTE));
//echo Vote::getVoteAll(Vote::TYPE_FZ_VOTE);exit;




?>

<?php  $this->pageTitle="盖象商城-11.11巅峰钜惠"; ?>
<style>
/*=====
    @Date:2016-10-18
    @content:
	@author:刘泉辉
 =====*/
.zt-wrap{width:100%; background:#fff; overflow: hidden;}
.zt-con { width:1200px; margin:0 auto; position:relative; }
.zt-con a{ position:absolute;display:block;}
.double11-01{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_01.jpg) top center no-repeat;}
.double11-02{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_02.jpg) top center no-repeat;}
.double11-03{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_03.jpg) top center no-repeat;}
.double11-04{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_04.jpg) top center no-repeat;}
.double11-05{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_05.jpg) top center no-repeat;}
.double11-06{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_06.jpg) top center no-repeat;}
.double11-07{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_07.jpg) top center no-repeat;}
.double11-08{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_08.jpg) top center no-repeat;}
.double11-09{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_09.jpg) top center no-repeat;}
.double11-10{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_10.jpg) top center no-repeat;}
.double11-11{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_11.jpg) top center no-repeat;}
.double11-12{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_12.jpg) top center no-repeat;}
.double11-13{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_13.jpg) top center no-repeat;}
.double11-14{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_14.jpg) top center no-repeat;}
.double11-15{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_15.jpg) top center no-repeat;}
.double11-16{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_16.jpg) top center no-repeat;}
.double11-17{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_17.jpg) top center no-repeat;}
.double11-18{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_18.jpg) top center no-repeat;}
.double11-19{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_19.jpg) top center no-repeat;}
.double11-20{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_20.jpg) top center no-repeat;}
.double11-21{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_21.jpg) top center no-repeat;}
.double11-22{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_22.jpg) top center no-repeat;}
.double11-23{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_23.jpg) top center no-repeat;}
.double11-24{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_24.jpg) top center no-repeat;}
.double11-25{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_25.jpg) top center no-repeat;}
.double11-26{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_26.jpg) top center no-repeat;}
.double11-27{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_27.jpg) top center no-repeat;}
.double11-28{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_28.jpg) top center no-repeat;}
.double11-29{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_29.jpg) top center no-repeat;}
.double11-30{height:212px; background:url(<?php echo ATTR_DOMAIN;?>/zt/double11-16/double11_30.jpg) top center no-repeat;}


.double11-03 a{left:50%; margin-left: -196px;  width:390px; height:60px; top:185px;}

.double11-06 a{ width:195px; height:42px; top:-110px;}
.double11-06 .a1{ top:110px; left:78px;}
.double11-06 .a2{ top:169px; left:78px;}
.double11-06 .a3{ top:228px; left:78px;}

.double11-06 .b1{  top:110px; left:358px;}
.double11-06 .b2{  top:169px; left:358px;}
.double11-06 .b3{ top:228px; left:358px;}

.double11-06 .c1{  top:110px; left:639px;}
.double11-06 .c2{  top:169px; left:639px;}
.double11-06 .c3{ top:228px; left:639px;}
.double11-06 .c4{ top:288px; left:639px;}

.double11-06 .d1{  top:110px; left:914px;}
.double11-06 .d2{  top:169px; left:914px;}
.double11-06 .d3{ top:229px; left:914px;}

.double11-09 a{top:235px;  width:48px; height:18px;}
.double11-09 .a1{  left:60px;}
.double11-09 .a2{  left:109px;}
.double11-09 .a3{ left:306px;}
.double11-09 .a4{ left:355px;}
.double11-09 .a5{  left:552px;}
.double11-09 .a6{ left:601px;}
.double11-09 .a7{ left:797px;}
.double11-09 .a8{  left:847px;}
.double11-09 .a9{left:1044px;}
.double11-09 .a10{ left:1093px;}

.double11-11 a{top:-10px;  width:48px; height:18px;}
.double11-11 .a1{  left:60px;}
.double11-11 .a2{  left:109px;}
.double11-11 .a3{ left:306px;}
.double11-11 .a4{ left:355px;}
.double11-11 .a5{  left:552px;}
.double11-11 .a6{ left:601px;}
.double11-11 .a7{ left:795px;}
.double11-11 .a8{  left:844px;}
.double11-11 .a9{left:1040px;}
.double11-11 .a10{ left:1089px;}

.double11-12 a{top:41px;  width:48px; height:17px;}
.double11-12 .a1{  left:58px;}
.double11-12 .a2{  left:107px;}
.double11-12 .a3{ left:304px;}
.double11-12 .a4{ left:353px;}
.double11-12 .a5{  left:549px;top:42px;}
.double11-12 .a6{ left:598px;top:42px;}
.double11-12 .a7{ left:795px;}
.double11-12 .a8{  left:844px;}
.double11-12 .a9{left:1043px;}
.double11-12 .a10{ left:1092px;}

.double11-14 a{left:50%; margin-left:189px; width:113px; top:24px; height:43px;border-radius: 42px;}

.double11-16 a{ width:113px; top:85px; height:43px;border-radius: 42px;}
.double11-16 .a1{ left:360px;}
.double11-16 .a2{ left:920px;}

.double11-18 a{ width:113px; top:12px; height:43px;border-radius: 42px;}
.double11-18 .a1{ left:360px;}
.double11-18 .a2{ left:920px;}

.double11-20 a{ width:113px; top:28px; height:43px;border-radius: 42px;}
.double11-20 .a1{ left:789px;}
.double11-20 .a2{ left:920px;}
.double11-20 .a3{width:315px; top:-166px; height:356px; left:142px; border-radius: 0px;}

.double11-21 .a1{ left:167px; width:279px; top:13px; height:247px;}
.double11-21 .a2{ left:701px; width:345px; top:13px; height:249px; transform: rotate(-13deg); -ms-transform:rotate(-13deg);/* IE 9 */-moz-transform:rotate(-13deg); /* Firefox */-webkit-transform:rotate(-13deg); /* Safari 和 Chrome */-o-transform:rotate(-13deg); 	/* Opera */ }

.double11-22 a{ width:113px; height:43px;border-radius: 42px;}
.double11-22 .a1{ left:146px;top:139px;}
.double11-22 .a2{ left:273px;top:139px;}
.double11-22 .a3{ left:711px;top:143px;}
.double11-22 .a4{ left:838px;top:143px;}

.double11-23 .a1{ left:191px; width:250px; top:-68px; height:345px;}
.double11-23 .a2{ left:637px; width:468px; top:-42px; height:301px;}

.double11-24 a{ top:113px; width:113px; height:43px;border-radius: 42px;}
.double11-24 .a1{ left:152px;}
.double11-24 .a2{ left:280px;}
.double11-24 .a3{ left:716px;}
.double11-24 .a4{ left:844px;}

.double11-27 a{ width:113px; top:207px; height:43px;border-radius: 42px;}
.double11-27 .a1{ left:364px;}
.double11-27 .a2{ left:938px; top:205px;}

.double11-29 a{ width:113px; top:137px; height:43px;border-radius: 42px;}
.double11-29 .a1{ left:336px;}
.double11-29 .a2{ left:919px;}


.double11-30 a{ width:200px; top:90px; height:33px;border-radius: 42px;}
.double11-30 .a1{ left:86px;}
.double11-30 .a2{ left:366px;}
.double11-30 .a3{ left:628px;}
.double11-30 .a4{ left:899px;}

.prompt-box{
	position: fixed;
	width: 500px;
	top:50%;
	left: 50%;
	margin-left: -250px;
	margin-top: -25%;
	z-index: 101;
	background-color: #fff;
	border:5px solid #f5f5f5;
	display: none;
	-webkit-user-select:none;
    -moz-user-select:none;
    -ms-user-select:none;
    user-select:none;
}
.cover{
	background-color: #000;
	opacity: 0.5;
	width: 100%;
	height: 100%;
	z-index: 100;
	top:0px;
	left:0px;
	position: absolute;
	display: none;
}
.vote-title{
	background-color: #BFD8EF;
	height: 36px;
	line-height: 36px;
}
.vote-title h2{
   display: block;
   float: left;
   width: 80%;
   padding-left: 10px;
   box-sizing: border-box;
}
.vote-title span{
   display: block;
   float: right;
   width: 20%;
   padding-right:12px;
   box-sizing: border-box;
   font-size: 16px;
}
.vote-title span a{
	display: block;
	width: 22px;
	height: 22px;
	text-align: center;
	line-height: 22px;
	border-radius: 22px;
	float: right;
	margin-top: 7px;
	color: #666;
}
.vote-title span a:hover{
	color: #000;
}
.prompt-box ul{
	width: 90%;
	margin:0 auto;
}
.prompt-box ul li{
	line-height: 32px;
	border-bottom:1px dotted #ccc;
    font-size: 12px;
}
.prompt-box ul .vote-last-list{
	border-bottom: none;
}
.prompt-box ul li .shop-num{
	margin-right:4px;
}
.prompt-box ul li  label{
	float: left;
	width: 80%;
}
.prompt-box ul li .vote-list-right{
   float: right;
   width: 20%;
   text-align: right;
   color: #666;
}
.signIn-box{width: 400px; height: 200px; background-color: #fff; border-radius: 10px; position: fixed; left: 50%; top: 50%; margin-left: -200px; margin-top: -100px; display: none; z-index: 101;}
.signIn-box p{line-height: 2; font-size: 20px; text-align: center; padding: 20px 0; margin: 0 20px; border-bottom: 1px solid #aeaeae;}
.signIn-box a{width: 100px; height: 40px; line-height: 40px; text-align: center; color: #fff; background-color: #277ced; border-radius: 4px; margin: 20px auto; display: block;}
</style>

	<div class="zt-wrap">			
         <div class="double11-01"></div>
         <div class="double11-02"></div>
         <div class="double11-03">
           <div class="zt-con">
                <!-- 签到 -->
				<a href="javascript:void(0)" class="a1 signIn"></a>
		    </div>
         </div>
         <div class="double11-04"></div>
         <div class="double11-05"></div>
         <div class="double11-06">
           <div class="zt-con">
				<a href="javascript:void(0)" class="a1" target="_blank"></a>
				<a href="javascript:void(0)" class="a2" target="_blank"></a>
				<a href="javascript:void(0)" class="a3" target="_blank"></a>

				<a href="http://active.g-emall.com/festive/detail/349" class="b1" target="_blank"></a>
				<a href="http://active.g-emall.com/festive/detail/355" class="b2" target="_blank"></a>
				<a href="http://active.g-emall.com/festive/detail/353" class="b3" target="_blank"></a>

				<a href="javascript:void(0)" class="c1" target="_blank"></a>
				<a href="javascript:void(0)" class="c2" target="_blank"></a>
				<a href="javascript:void(0)" class="c3" target="_blank"></a>
				<a href="javascript:void(0)" class="c4" target="_blank"></a>

				<a href="javascript:void(0)" class="d1" target="_blank"></a>
				<a href="javascript:void(0)" class="d2" target="_blank"></a>
		    </div>
         </div>
         <div class="double11-07"></div>
         <div class="double11-08"></div>
         <div class="double11-09">
            <div class="zt-con">
				<a href="javascript:void(0)" class="a1 votebtn" data-attr="1"></a>
				<a href="http://www.g-emall.com/goods/2687872.html" title="冬季弹力牛仔裤男加绒加厚保暖裤大码男装修身直筒长裤子" class="a2 voteItem" target="_blank"></a>
				<a href="javascript:void(0)" class="a3 votebtn" data-attr="2"></a>
				<a href="http://www.g-emall.com/goods/2123278.html" title="【慕思兰】秋冬新款女式牛仔裤青少年中腰韩版修身弹力裤百搭显瘦铅笔裤" class="a4 voteItem" target="_blank"></a>
				<a href="javascript:void(0)" class="a5 votebtn" data-attr="3"></a>
				<a href="http://www.g-emall.com/JF/198724.html"  title="贡缎提花四件套-皇家花园" class="a6 voteItem" target="_blank"></a>
				<a href="javascript:void(0)" class="a7 votebtn" data-attr="4"></a>
				<a href="http://www.g-emall.com/goods/2653491.html" title="秋冬加绒女装上衣休闲韩版修身百搭加厚翻领中长款牛仔外套长袖" class="a8 voteItem" target="_blank"></a>
				<a href="javascript:void(0)" class="a9 votebtn" data-attr="5"></a>
				<a href="http://www.g-emall.com/goods/177450.html" title="萌宝宝 小学生书包2-6年级双肩背包减负儿童书包" class="a10 voteItem" target="_blank"></a>
		    </div>
         </div>
         <div class="double11-10"></div>
         <div class="double11-11">
           <div class="zt-con">
				<a href="javascript:void(0)" class="a1 votebtn" data-attr="6"></a>
				<a href="http://www.g-emall.com/goods/2481187.html" title="品牌聚拢调整无痕无钢圈一片式小胸性感拉丝前扣胸罩内衣套装" class="a2 voteItem" target="_blank"></a>
				<a href="javascript:void(0)" class="a3 votebtn" data-attr="7"></a>
				<a href="http://www.g-emall.com/JF/366910.html"  title="韩国正品 MEDIHEAL/美迪惠尔可莱丝NMF针剂水库面膜贴保湿补水10片" class="a4 voteItem" target="_blank"></a>
				<a href="javascript:void(0)" class="a5 votebtn" data-attr="8"></a>
				<a href="http://www.g-emall.com/JF/1380048.html"  title="【两包组合】Moony 4-8公斤宝宝 日本尤妮佳纸尿裤 S84片" class="a6 voteItem" target="_blank"></a>
				<a href="javascript:void(0)" class="a7 votebtn" data-attr="9"></a>
				<a href="http://www.g-emall.com/goods/2254295.html"  title="2016新款男士商务牛仔裤休闲直筒修身牛仔裤男大码长裤子" class="a8 voteItem" target="_blank"></a>
				<a href="javascript:void(0)" class="a9 votebtn" data-attr="10"></a>
				<a href="http://www.g-emall.com/goods/2684255.html"  title="男装 毛呢外套 新款男士羊毛时尚带帽QL878" class="a10 voteItem" target="_blank"></a>
		    </div>
         </div>
         <div class="double11-12">
            <div class="zt-con">
				<a href="javascript:void(0)" class="a1 votebtn" data-attr="11"></a>
				<a href="http://www.g-emall.com/goods/124711.html"  title="法国皙奈儿sacellec干细胞臻宠保湿水" class="a2 voteItem" target="_blank"></a>
				<a href="javascript:void(0)" class="a3 votebtn" data-attr="12"></a>
				<a href="http://www.g-emall.com/goods/2347273.html"  title="【古思图箱包】古思图品牌高端旅行箱　防刮硬箱子铝框行李箱万向轮拉杆箱登机箱包男女旅游箱" class="a4 voteItem" target="_blank"></a>
				<a href="javascript:void(0)" class="a5 votebtn" data-attr="13"></a>
				<a href="http://www.g-emall.com/JF/109885.html"  title="2015新款春夏男士休闲裤时尚韩版修身长裤男裤直筒微小脚布裤纯棉" class="a6 voteItem" target="_blank"></a>
				<a href="javascript:void(0)" class="a7 votebtn" data-attr="14"></a>
				<a href="http://www.g-emall.com/goods/1733979.html"  title="七猩猩--泰国进口食品　德乌敦茉莉香米1000g袋装粒粒纯香度92%大米" class="a8 voteItem" target="_blank"></a>
				<a href="javascript:void(0)" class="a9 votebtn" data-attr="15"></a>
				<a href="http://www.g-emall.com/JF/353299.html"  title="韩国正品 进口2P纳米黄金洗衣球 纳米无洗涤剂杀菌抗菌 负离子纳米去污 免洗衣粉 1盒两个" class="a10 voteItem" target="_blank"></a>
		    </div>
         </div>
         <div class="double11-13"></div>
         <div class="double11-14">
            <div class="zt-con">
				<a href="http://www.g-emall.com/goods/2619503.html" title="2016秋冬新款儿童羽绒服男童羽绒棉中长眼镜款外套" class="a1" target="_blank"></a>
		    </div>
         </div>
         <div class="double11-15"></div>
         <div class="double11-16">
            <div class="zt-con">
				<a href="http://www.g-emall.com/JF/1558739.html" title="泰国进口茉莉香米5KG装" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/309891.html" title="【啄木鸟包包】啄木鸟真皮男包男士手提包真皮横款商务斜挎公文包男士包包单肩包 盖粉推荐" class="a2" target="_blank"></a>
		    </div>
         </div>
         <div class="double11-17"></div>
         <div class="double11-18">
            <div class="zt-con">
				<a href="http://www.g-emall.com/goods/2424929.html" title="秋季绅士英伦格子休闲西装外套 小方格男士外穿西服 男秋冬外套" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/2385154.html" title="【吾之语】吾之语 韩版水洗棉床品四件套系列" class="a2" target="_blank"></a>
		    </div>
         </div>
         <div class="double11-19"></div>
         <div class="double11-20">
            <div class="zt-con">
				<a href="http://www.g-emall.com/JF/2685910.html" title="【浪漫满屋】雪花秀 雨润夜间修复睡眠面膜120ml 急救面膜 保湿 提亮肤色正品  两件装（AS）" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/2686053.html" title="【浪漫满屋】雪花秀 雨润夜间修复睡眠面膜120ml 急救面膜 保湿 提亮肤色正品  三件装（AS）" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/goods/2451245.html" title="【浪漫满屋】雪花秀 雨润夜间修复睡眠面膜120ml 急救面膜 保湿 提亮肤色正品（AS）" class="a3" target="_blank"></a>
		    </div>
         </div>
         <div class="double11-21">
               <div class="zt-con">
				<a href="http://www.g-emall.com/goods/2710051.html" title="女靴 裸靴  细跟单靴尖头深口真皮短靴 大码女靴QL7126" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/2533831.html" title="【吾之语】吾之语 水洗棉MISS YOU系列秋冬被 D1314" class="a2" target="_blank"></a>
		    </div>
         </div>
         <div class="double11-22">
            <div class="zt-con">
				<a href="http://www.g-emall.com/JF/2774651.html" title="真皮裸靴 2双 细跟单靴尖头深口真皮短靴 大码女靴QL7126" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/2884903.html" title="【（三对装）女靴 裸靴 细跟单靴尖头深口真皮短靴 大码女靴QL7126" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/2788710.html" title="吾之语 水洗棉MISS YOU系列秋冬被 D1314（2件装）" class="a3" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/2788783.html" title="【吾之语】吾之语 水洗棉MISS YOU系列秋冬被 D1314（3件装）" class="a4" target="_blank"></a>
		    </div>
         </div>
         <div class="double11-23">
           <div class="zt-con">
				<a href="http://www.g-emall.com/goods/2347273.html" title="【古思图箱包】古思图品牌高端旅行箱　防刮硬箱子铝框行李箱万向轮拉杆箱登机箱包男女旅游箱" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/2315217.html" title="盛富葵花籽油-木兰秋狝精装礼盒" class="a2" target="_blank"></a>
		    </div>
         </div>
         <div class="double11-24">
             <div class="zt-con">
				<a href="http://www.g-emall.com/JF/2842683.html" title="【古思图箱包】古思图品牌旅行箱　防刮硬箱子铝框行李箱万向轮拉杆箱登机箱包 2件装" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/2842681.html" title="【古思图箱包】古思图品牌旅行箱　防刮硬箱子铝框行李箱万向轮拉杆箱登机箱包 3件装" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/2772936.html" title="盛富葵花籽油-木兰秋狝精装礼盒2提组" class="a3" target="_blank"></a>
				<a href="http://www.g-emall.com/JF/2883317.html" title="（3提装）盛富葵花籽油-木兰秋狝精装礼盒" class="a4" target="_blank"></a>
		    </div>
         </div>
          <div class="double11-25"></div>
          <div class="double11-26"></div>
          <div class="double11-27">
             <div class="zt-con">
				<a href="http://www.g-emall.com/shop/1837.html" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/1869.html" class="a2" target="_blank"></a>
		    </div>
          </div>
          <div class="double11-28"></div>
          <div class="double11-29">
            <div class="zt-con">
				<a href="http://www.g-emall.com/shop/3626.html" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/3920.html" class="a2" target="_blank"></a>
		    </div>
          </div>
          <div class="double11-30">
             <div class="zt-con">
				<a href="<?php echo Yii::app()->createUrl('zt/site/double11-2')?>" class="a1" target="_blank"></a>
				<a href="<?php echo Yii::app()->createUrl('zt/site/double11-3')?>" class="a2" target="_blank"></a>
				<a href="<?php echo Yii::app()->createUrl('zt/site/double11-1')?>" class="a3" target="_blank"></a>
				<a href="http://active.g-emall.com/festive/detail/279" title="【乐游】乐游 迷彩九点双拼" class="a4" target="_blank"></a>
		    </div>
          </div>

          <!--签到成功提示框-->
          <div class="signIn-box">
          	<p id="textCon"></p>
          	<a href="javascript:void(0)" class="confirm">确定</a>
          </div>

          <!-- 投票成功提示框 -->
          <div class="prompt-box">
               <div class="vote-title clearfix">
                     <h2>11.11我最喜欢单品当前投票结果</h2><span><a href="javacript:void(0)" class="vote-box-back">X</a></span>
               </div>
               <ul class="vote-detail">    
               </ul>
          </div>
          <div class="cover"></div>
          
	</div> 
   <!--主体 End -->
   
<script type="text/javascript">
$(function(){

	//签到

	$('.confirm').click(function(){
		$(".cover").hide();
		$('.signIn-box').hide();
	})
	
	$('.signIn').click(function(){
		$.ajax({
            type: "POST", 
            url: "<?php echo $this->createUrl('vote/double11') ?>",
            data: {YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>'},
            dataType:"json",
            success: function(data) {
                if(data.status==1){
                    $("#textCon").html("签到成功，<br/>并获得20元红包!");
                    $(".cover").show();
            		$('.signIn-box').show();
                 }else{
                	$("#textCon").html(data.msg);
                    $(".cover").show();
             		$('.signIn-box').show();
                 }  
               },
            error:function(msg){
                  alert(data.msg);
                }
          });
	})
	
	//投票
	var i = 0;
	var oLen = $('.voteItem').length;
    var _votes=[<?php echo Vote::getVoteAll(Vote::TYPE_FZ_VOTE);?>];

	var content = '';	//拼接li内容
	for(i=0;i<oLen;i++){		
		var _title = $('.voteItem').eq(i).attr('title');//各个商品的title
		content += 	'<li class="clearfix">'+
						'<label for="">'+(i+1)+'.'+_title+'</label>'+
						'<span  class="vote-list-right"><span id=goods_'+(i+1)+' class="shop-num">'+_votes[i]+'</span>票</span>'+
					'</li>';
	   }
	 $('.vote-detail').append(content);
	 
	 $(".votebtn").click(function(){
		var voteType=$(this).attr("data-attr");
		$.ajax({
            type: "POST", 
            url: "<?php echo $this->createUrl('vote/double11Vote') ?>",
            data: {voteType: voteType ,YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>'},
            dataType:"json",
            success: function(data){
                var num=$("#goods_"+voteType).html();
                if(data.status==1){
                	num=Number(num)+1;
                    $("#goods_"+voteType).html(num);
                  }else{
                	$("#textCon").html(data.msg);
                    $(".cover").show();
              		$('.signIn-box').show();
                  }
                },
            error:function(msg){
                  alert(data.msg);
                }
          });
        $(".cover").fadeIn();
		$(".prompt-box").fadeIn(); 
	})

	//投票统计框关闭
	$(".vote-box-back").click(function(){
		$(".cover").fadeOut();
		$(".prompt-box").fadeOut();
	})
})
</script>