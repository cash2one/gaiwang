<?php $this->pageTitle="盖象商城-行走的教科书";?>
<style>
<!--
/*=====
    @Date:2016-08-19
    @content:行走的教科书
	@author:林聪毅
 =====*/
.zt-wrap{width:100%; background:#fff; overflow: hidden;}
.zt-con { width:968px; margin:0 auto; position:relative; }
.zt-con a{ position:absolute;display:block;}
.walking-01{height:442px; background:url(<?php echo ATTR_DOMAIN;?>/zt/walking/walking-01.jpg) top center no-repeat;}
.walking-02{height:442px; background:url(<?php echo ATTR_DOMAIN;?>/zt/walking/walking-02.jpg) top center no-repeat;}
.walking-03{height:428px; background:url(<?php echo ATTR_DOMAIN;?>/zt/walking/walking-03.jpg) top center no-repeat;}
.walking-04{height:918px; background:url(<?php echo ATTR_DOMAIN;?>/zt/walking/walking-04.jpg) top center no-repeat;}
.walking-05{height:659px; background:url(<?php echo ATTR_DOMAIN;?>/zt/walking/walking-05.jpg) top center no-repeat;}
.walking-06{height:709px; background:url(<?php echo ATTR_DOMAIN;?>/zt/walking/walking-06.jpg) top center no-repeat;}
.walking-07{height:820px; background:url(<?php echo ATTR_DOMAIN;?>/zt/walking/walking-07.jpg) top center no-repeat;}
.walking-08{height:634px; background:url(<?php echo ATTR_DOMAIN;?>/zt/walking/walking-08.jpg) top center no-repeat;}
.walking-09{height:570px; background:url(<?php echo ATTR_DOMAIN;?>/zt/walking/walking-09.jpg) top center no-repeat;}
.walking-10{height:528px; background:url(<?php echo ATTR_DOMAIN;?>/zt/walking/walking-10.jpg) top center no-repeat;}

.wrap_link{width: 100%; height: 100%;}
.shoe{position: absolute;}
.arrow{width: 39px; height: 38px; background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/arrow.png) no-repeat; position: absolute;}
.walking-04 .shoe-01{width: 289px; height: 122px; background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe_wrap-01.png) no-repeat; left: 120px; top: 650px;}
.walking-04 .shoe-01:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe-01.png) no-repeat;}
.walking-04 .shoe-02{width: 333px; height: 132px; background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe_wrap-02.png) no-repeat; left: 700px; top: 650px;}
.walking-04 .shoe-02:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe-02.png) no-repeat;}
.walking-04 .arrow-01{left: 380px; top: 800px;}
.walking-04 .arrow-02{left: 1030px; top: 800px;}

.walking-05 .shoe-03{width: 331px; height: 163px; background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe_wrap-03.png) no-repeat; left: 100px; top: 350px;}
.walking-05 .shoe-03:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe-03.png) no-repeat;}
.walking-05 .shoe-04{width: 268px; height: 195px; background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe_wrap-04.png) no-repeat; left: 770px; top: 310px;}
.walking-05 .shoe-04:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe-04.png) no-repeat;}
.walking-05 .arrow-03{left: 380px; top: 530px;}
.walking-05 .arrow-04{left: 1000px; top: 500px;}

.walking-06 .shoe-05{width: 324px; height: 211px; background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe_wrap-05.png) no-repeat; left: 60px; top: 350px;}
.walking-06 .shoe-05:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe-05.png) no-repeat;}
.walking-06 .shoe-06{width: 379px; height: 182px; background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe_wrap-06.png) no-repeat; left: 700px; top: 400px;}
.walking-06 .shoe-06:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe-06.png) no-repeat;}
.walking-06 .arrow-05{left: 400px; top: 570px;}
.walking-06 .arrow-06{left: 1000px; top: 580px;}

.walking-07 .shoe-07{width: 344px; height: 141px; background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe_wrap-07.png) no-repeat; left: 90px; top: 400px;}
.walking-07 .shoe-07:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe-07.png) no-repeat;}
.walking-07 .shoe-08{width: 291px; height: 240px; background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe_wrap-08.png) no-repeat; left: 720px; top: 340px;}
.walking-07 .shoe-08:hover{background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe-08.png) no-repeat;}
.walking-07 .arrow-07{left: 400px; top: 570px;}
.walking-07 .arrow-08{left: 1000px; top: 580px;}

.shoe-row{width: 1127px; height: 142px; background: url(<?php echo ATTR_DOMAIN;?>/zt/walking/shoe-row.png) no-repeat; position: absolute; left: -80px; top: 220px; display: none;}
.walking-08 a{width: 216px; height: 230px; top: 10px;}
.walking-08 .a1{left: 0px;}
.walking-08 .a2{left: 228px;}
.walking-08 .a3{left: 456px;}
.walking-08 .a4{left: 684px;}
.walking-08 .a5{left: 914px;}
.walking-09 a{width: 130px; height: 70px;}
.walking-09 .a1{left: 57px; top: 159px;}
.walking-09 .a2{left: 234px; top: 159px;}
.walking-09 .a3{left: 411px; top: 159px;}
.walking-09 .a4{left: 588px; top: 159px;}
.walking-09 .a5{left: 765px; top: 159px;}
.walking-09 .a6{left: 57px; top: 266px;}
.walking-09 .a7{left: 234px; top: 266px;}
.walking-09 .a8{left: 411px; top: 266px;}
.walking-09 .a9{left: 588px; top: 266px;}
.walking-09 .a10{left: 765px; top: 266px;}
.walking-09 .a11{left: 57px; top: 374px;}
.walking-09 .a12{left: 234px; top: 374px;}
.walking-09 .a13{left: 411px; top: 374px;}
.walking-09 .a14{left: 588px; top: 374px;}
.walking-09 .a15{left: 765px; top: 374px;}
.walking-09 .a16{left: 57px; top: 480px;}
.walking-09 .a17{left: 234px; top: 480px;}
.walking-09 .a18{left: 411px; top: 480px;}
.walking-09 .a19{left: 588px; top: 480px;}
.walking-09 .a20{left: 765px; top: 480px;}

.shine{
	animation: shine 0.8s infinite;
	-webkit-animation: shine 0.8s infinite;
	-moz-animation: shine 0.8s infinite;
}
@keyframes shine{
	0%,100%{opacity: 1;}
	50%{opacity: 0;}
}
@-webkit-keyframes shine{
	0%,100%{opacity: 1;}
	50%{opacity: 0;}
}
@-moz-keyframes shine{
	0%,100%{opacity: 1;}
	50%{opacity: 0;}
}
.slideUp{
	display: block;
	animation: slideUp .8s forwards;
	-webkit-animation: slideUp .8s forwards;
	-moz-animation: slideUp .8s forwards;
}
@keyframes slideUp{
	0%{transform:translateY(20px);opacity: 0;}
	100%{transform:translateY(-10px);opacity: 1;}
}
@-webkit-keyframes slideUp{
	0%{-webkit-transform:translateY(20px);opacity: 0;}
	100%{-webkit-transform:translateY(-10px);opacity: 1;}
}
@-moz-keyframes slideUp{
	0%{-moz-transform:translateY(20px);opacity: 0;}
	100%{-moz-transform:translateY(-10px);opacity: 1;}
}
-->
</style>
	<div class="zt-wrap">			
		<div class="walking-01"></div>
		<div class="walking-02"></div>
		<div class="walking-03"></div>
		<a href="<?php echo $this->createAbsoluteUrl('/zt/site/walking_detail#part1');?>" target="_blank">
			<div class="walking-04">
				<div class="zt-con">
					<div class="shoe shoe-01"></div>
					<div class="arrow arrow-01 shine"></div>
					<div class="shoe shoe-02"></div>
					<div class="arrow arrow-02 shine"></div>
				</div>
			</div>
		</a>
		<a href="<?php echo $this->createAbsoluteUrl('/zt/site/walking_detail#part2');?>" target="_blank">
			<div class="walking-05">
				<div class="zt-con">
					<div class="shoe shoe-03"></div>
					<div class="arrow arrow-03 shine"></div>
					<div class="shoe shoe-04"></div>
					<div class="arrow arrow-04 shine"></div>
				</div>
			</div>
		</a>
		<a href="<?php echo $this->createAbsoluteUrl('/zt/site/walking_detail#part3');?>" target="_blank">
			<div class="walking-06">
				<div class="zt-con">
					<div class="shoe shoe-05"></div>
					<div class="arrow arrow-05 shine"></div>
					<div class="shoe shoe-06"></div>
					<div class="arrow arrow-06 shine"></div>
				</div>
			</div>
		</a>
		<a href="<?php echo $this->createAbsoluteUrl('/zt/site/walking_detail#part4');?>" target="_blank">
			<div class="walking-07">
				<div class="zt-con">
					<div class="shoe shoe-07"></div>
					<div class="arrow arrow-07 shine"></div>
					<div class="shoe shoe-08"></div>
					<div class="arrow arrow-08 shine"></div>
				</div>
			</div>
		</a>
		<div class="walking-08">
			<div class="zt-con">
				<div class="shoe-row">
					<a href="http://www.g-emall.com/JF/2281721.html" title="adidas阿迪三叶草 中性 史密斯经典休闲鞋 M20324" class="a1" target="_blank"></a>
					<a href="http://www.g-emall.com/JF/2284567.html" title="【乐淘鞋城】BEAU 女式 韩版休闲小白鞋 21012白色" class="a2" target="_blank"></a>
					<a href="http://www.g-emall.com/JF/2282446.html" title="【乐淘鞋城】EGE 男式 英伦复古铆钉克罗心休闲皮鞋 8059黑色" class="a3" target="_blank"></a>
					<a href="http://www.g-emall.com/JF/2285995.html" title="【乐淘鞋城】RDL甜美真皮女鞋牛皮尖头高跟鞋细跟职业鞋秋冬季低帮鞋蝴蝶结女鞋 21152QQM-W008粉色" class="a4" target="_blank"></a>
					<a href="http://www.g-emall.com/JF/2284889.html" title="【乐淘鞋城】VANS万斯 中性 情侣款休闲硫化鞋 VN000D5IB8C1" class="a5" target="_blank"></a>
				</div>
			</div>
		</div>
		<div class="walking-09">
			<div class="zt-con">
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=159887" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160685" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160642" class="a3" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160686" class="a4" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160689" class="a5" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160594" class="a6" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160636" class="a7" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160691" class="a8" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160723" class="a9" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160612" class="a10" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160647" class="a11" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160701" class="a12" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160649" class="a13" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160646" class="a14" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160684" class="a15" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160721" class="a16" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160643" class="a17" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160697" class="a18" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160690" class="a19" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/product/1467.html?cid=160652" class="a20" target="_blank"></a>
			</div>
		</div>
		<div class="walking-10"></div>
	</div>   
   <!--------------主体 End------------>
<script type="text/javascript">
$(function(){
	var scrollTop = 0;
	$(window).scroll(function(){
		scrollTop = $(document).scrollTop();
		if(scrollTop>=4300){
			$('.shoe-row').addClass('slideUp');
		}
	})
})
</script>