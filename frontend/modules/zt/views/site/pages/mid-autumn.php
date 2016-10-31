<?php  $this->pageTitle='盖象商城-金秋送福袋'?>

<style>
/*=====
    @Date:2016-08-17
    @content:金秋送福袋
	@author:林聪毅
 =====*/
.zt-wrap{width:100%; background:#fff; overflow: hidden;}
.zt-con { width:968px; margin:0 auto; position:relative; }
.zt-con a{ position:absolute;display:block;}
.mid-autumn-01{height:292px; background:url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/mid-autumn-01.jpg) top center no-repeat;}
.mid-autumn-02{height:292px; background:url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/mid-autumn-02.jpg) top center no-repeat;}
.mid-autumn-03{height:292px; background:url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/mid-autumn-03.jpg) top center no-repeat;}
.mid-autumn-04{height:508px; background:url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/mid-autumn-04.jpg) top center no-repeat;}
.mid-autumn-05{height:240px; background:url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/mid-autumn-05.jpg) top center no-repeat;}
.mid-autumn-06{height:485px; background:url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/mid-autumn-06.jpg) top center no-repeat;}
.mid-autumn-07{height:426px; background:url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/mid-autumn-07.jpg) top center no-repeat;}
.mid-autumn-08{height:231px; background:url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/mid-autumn-08.jpg) top center no-repeat;}
.mid-autumn-09{height:954px; background:url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/mid-autumn-09.jpg) top center no-repeat;}
.mid-autumn-10{height:243px; background:url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/mid-autumn-10.jpg) top center no-repeat;}

.mid-autumn-11{height:372px; background:url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/mid-autumn-11.jpg) top center no-repeat;}
.mid-autumn-12{height:396px; background:url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/mid-autumn-12.jpg) top center no-repeat;}
.mid-autumn-13{height:465px; background:url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/mid-autumn-13.jpg) top center no-repeat;}
.mid-autumn-14{height:294px; background:url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/mid-autumn-14.jpg) top center no-repeat;}
.mid-autumn-15{height:294px; background:url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/mid-autumn-15.jpg) top center no-repeat;}

.mid-autumn-04 a{ width: 244px; height: 114px;}
.mid-autumn-04 .a1{left: 5px; top: 35px;}
.mid-autumn-04 .a2{left: 368px; top: 35px;}
.mid-autumn-04 .a3{left: 731px; top: 35px;}
.mid-autumn-04 .a4{left: 5px; top: 190px;}
.mid-autumn-04 .a5{left: 368px; top: 190px;}
.mid-autumn-04 .a6{left: 731px; top: 190px;}
.mid-autumn-04 .a7{left: 5px; top: 339px;}
.mid-autumn-04 .a8{left: 368px; top: 339px;}
.mid-autumn-04 .a9{left: 731px; top: 339px;}
.cp a{z-index: 3; display: -none;}
.cp a.off{opacity: 0; filter:alpha(opacity=0);transition: all 1s ;-webkit-transition: all 1s;}
.cp img{display: none; position: absolute; z-index: 2;}
.cp img.active{display: block;}
.mid-autumn-06 a{width: 297px; height: 350px; top: 20px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/gift-bag_big.png) no-repeat;}
.mid-autumn-06 .a1{left: -40px;}
.mid-autumn-06 .a2{left: 340px;}
.mid-autumn-06 .a3{left: 720px;}
.mid-autumn-06 a span{display: block; position: absolute; left: 70px; top: 100px;}
.mid-autumn-06 .a1 span{width: 137px; height: 126px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-01.png) no-repeat;}
.mid-autumn-06 .a2 span{width: 133px; height: 118px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-02.png) no-repeat;}
.mid-autumn-06 .a3 span{width: 133px; height: 118px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-03.png) no-repeat;}
.mid-autumn-06 .cp-01 img{left: -40px; top: 50px;}
.mid-autumn-06 .cp-02 img{left: 340px; top: 50px;}
.mid-autumn-06 .cp-03 img{left: 710px; top: 30px;}

.mid-autumn-07 a{width: 246px; height: 229px; top: 20px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/gift-bag_mid.png) no-repeat;}
.mid-autumn-07 .a1{left: -110px;}
.mid-autumn-07 .a2{left: 200px;}
.mid-autumn-07 .a3{left: 520px;}
.mid-autumn-07 .a4{left: 850px;}
.mid-autumn-07 a span{display: block; position: absolute; left: 54px; top: 82px;}
.mid-autumn-07 .a1 span{width: 123px; height: 107px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-04.png) no-repeat;}
.mid-autumn-07 .a2 span{width: 123px; height: 107px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-05.png) no-repeat;}
.mid-autumn-07 .a3 span{width: 127px; height: 110px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-06.png) no-repeat;}
.mid-autumn-07 .a4 span{width: 124px; height: 107px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-07.png) no-repeat;} 
.mid-autumn-07 .cp-04 img{left: -120px; top: 50px;}
.mid-autumn-07 .cp-05 img{left: 180px; top: 80px;}
.mid-autumn-07 .cp-06 img{left: 520px; top: 40px;}
.mid-autumn-07 .cp-07 img{left: 870px; top: 40px;}

.mid-autumn-09 .cpAni_wrap{}
.cpAni_wrap div{}
.cpwrap_mid img{display: none;}
.cpwrap_mid .gift_bag_sm.off{opacity: 0; filter:alpha(opacity=0);transition: all 1s ;-webkit-transition: all 1s;}
.cpwrap_mid img.active{display: block;}
.cpAni_wrap .border_ani{border-right: 138px solid transparent; border-left: 138px solid transparent; transition: all 2s ;-webkit-transition: all 2s;}
.cpAni_wrap.active .border_ani{border-color: #bc1e1e; border-right: 138px solid transparent; border-left: 138px solid transparent;}
.cpAni_wrap .bg_ani{width: 276px; height: 180px; transition: all 2s ;-webkit-transition: all 2s;}
.cpAni_wrap.active .bg_ani{background-color: #bc1e1e;}
.cpAni_wrap .cpwrap_top{width: 0; height: 0;border-bottom: 80px solid #f1ff92; border-left: 138px solid transparent;}
.cpAni_wrap .cpwrap_mid{background-color: #f1ff92; position: relative;}
.cpAni_wrap .cpwrap_bot{width: 0; height: 0;border-top: 80px solid #f1ff92;}
.cpAni_wrap .gift_bag_sm{width: 211px; height: 231px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/gift-bag_sm.png) no-repeat; position: absolute; left: 40px; top: -30px;}
.cpAni_wrap .cpAniTitle{width: 276px; height: 136px;}
.cpAni-01{left: 78px; top: 0px;}
.cpAni-01 span{width: 100px; height: 81px; display: block; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniInfo-01.png) no-repeat; position: absolute; left: 48px; top: 66px;}
.cpAni-01 img{position: absolute; left: 10px; top: -20px;}
.cpAni_wrap .cpAniTitle-01{background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniTitle-01.png) no-repeat; position: absolute; left: 2px; bottom: -4px;}
.cpAni-02{left: 356px; top: 0px;}
.cpAni-02 span{width: 100px; height: 81px; display: block; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniInfo-02.png) no-repeat; position: absolute; left: 48px; top: 66px;}
.cpAni-02 img{position: absolute; left: 10px; top: 0px;}
.cpAni_wrap .cpAniTitle-02{background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniTitle-02.png) no-repeat; position: absolute; left: 2px; bottom: -4px;}
.cpAni-03{left: 634px; top: 0px;}
.cpAni-03 span{width: 100px; height: 81px; display: block; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniInfo-03.png) no-repeat; position: absolute; left: 48px; top: 66px;}
.cpAni-03 img{position: absolute; left: 70px; top: -60px;}
.cpAni_wrap .cpAniTitle-03{background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniTitle-03.png) no-repeat; position: absolute; left: 2px; bottom: -4px;}
.cpAni-04{left: -62px; top: 262px;}
.cpAni-04 span{width: 105px; height: 83px; display: block; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniInfo-04.png) no-repeat; position: absolute; left: 48px; top: 66px;}
.cpAni-04 img{position: absolute; left: 30px; top: -30px;}
.cpAni_wrap .cpAniTitle-04{background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniTitle-04.png) no-repeat; position: absolute; left: -2px; bottom: -3px;}
.cpAni-05{left: 217px; top: 262px;}
.cpAni-05 span{width: 99px; height: 83px; display: block; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniInfo-05.png) no-repeat; position: absolute; left: 48px; top: 66px;}
.cpAni-05 img{position: absolute; left: 30px; top: -30px;}
.cpAni_wrap .cpAniTitle-05{background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniTitle-05.png) no-repeat; position: absolute; left: 6px; bottom: -6px;}
.cpAni-06{left: 495px; top: 262px;}
.cpAni-06 span{width: 106px; height: 83px; display: block; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniInfo-06.png) no-repeat; position: absolute; left: 48px; top: 66px;}
.cpAni-06 img{position: absolute; left: 40px; top: -30px;}
.cpAni_wrap .cpAniTitle-06{background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniTitle-06.png) no-repeat; position: absolute; left: 5px; bottom: -6px;}
.cpAni-07{left: 773px; top: 262px;}
.cpAni-07 span{width: 104px; height: 83px; display: block; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniInfo-07.png) no-repeat; position: absolute; left: 48px; top: 66px;}
.cpAni-07 img{position: absolute; left: 20px; top: -10px;}
.cpAni_wrap .cpAniTitle-07{background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniTitle-07.png) no-repeat; position: absolute; left: 5px; bottom: -6px;}
.cpAni-08{left: 78px; top: 524px;}
.cpAni-08 span{width: 98px; height: 82px; display: block; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniInfo-08.png) no-repeat; position: absolute; left: 48px; top: 66px;}
.cpAni-08 img{position: absolute; left: 60px; top: -20px;}
.cpAni_wrap .cpAniTitle-08{background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniTitle-08.png) no-repeat; position: absolute; left: 6px; bottom: -9px;}
.cpAni-09{left: 356px; top: 524px;}
.cpAni-09 span{width: 101px; height: 82px; display: block; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniInfo-09.png) no-repeat; position: absolute; left: 48px; top: 66px;}
.cpAni-09 img{position: absolute; left: -8px; top: -20px;}
.cpAni_wrap .cpAniTitle-09{background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniTitle-09.png) no-repeat; position: absolute; left: 5px; bottom: -8px;}
.cpAni-10{left: 634px; top: 524px;}
.cpAni-10 span{width: 98px; height: 82px; display: block; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniInfo-10.png) no-repeat; position: absolute; left: 48px; top: 66px;}
.cpAni-10 img{position: absolute; left: 50px; top: -30px;}
.cpAni_wrap .cpAniTitle-10{background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAniTitle-10.png) no-repeat; position: absolute; left: 9px; bottom: -8px;}


.mid-autumn-11 a{width: 211px; height: 231px; top: 0px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/gift-bag_sm.png) no-repeat;}
.mid-autumn-11 .a1{left: -120px;}
.mid-autumn-11 .a2{left: 130px;}
.mid-autumn-11 .a3{left: 380px;}
.mid-autumn-11 .a4{left: 630px;}
.mid-autumn-11 .a5{left: 880px;}
.mid-autumn-11 a span{display: block; position: absolute; top: 78px;}
.mid-autumn-11 .a1 span{width: 140px; height: 88px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-08.png) no-repeat; left: 24px;}
.mid-autumn-11 .a2 span{width: 106px; height: 88px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-09.png) no-repeat; left: 44px;}
.mid-autumn-11 .a3 span{width: 104px; height: 88px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-10.png) no-repeat; left: 44px;}
.mid-autumn-11 .a4 span{width: 144px; height: 88px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-11.png) no-repeat; left: 24px;}
.mid-autumn-11 .a5 span{width: 137px; height: 88px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-12.png) no-repeat; left: 24px;}
.mid-autumn-11 .cp-08 img{left: -120px; top: 20px;}
.mid-autumn-11 .cp-09 img{left: 130px; top: 40px;}
.mid-autumn-11 .cp-10 img{left: 370px; top: 50px;}
.mid-autumn-11 .cp-11 img{left: 630px; top: 50px;}
.mid-autumn-11 .cp-12 img{left: 870px; top: 40px;}
.mid-autumn-12 a{width: 211px; height: 231px; top: 40px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/gift-bag_sm.png) no-repeat;}
.mid-autumn-12 .a1{left: -120px;}
.mid-autumn-12 .a2{left: 130px;}
.mid-autumn-12 .a3{left: 380px;}
.mid-autumn-12 .a4{left: 630px;}
.mid-autumn-12 .a5{left: 880px;}
.mid-autumn-12 a span{display: block; position: absolute; top: 78px;}
.mid-autumn-12 .a1 span{width: 147px; height: 88px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-13.png) no-repeat; left: 24px;}
.mid-autumn-12 .a2 span{width: 136px; height: 88px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-14.png) no-repeat; left: 30px;}
.mid-autumn-12 .a3 span{width: 137px; height: 88px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-15.png) no-repeat; left: 30px;}
.mid-autumn-12 .a4 span{width: 140px; height: 88px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-16.png) no-repeat; left: 30px;}
.mid-autumn-12 .a5 span{width: 98px; height: 88px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-17.png) no-repeat; left: 50px;}
.mid-autumn-12 .cp-13 img{left: -120px; top: 70px;}
.mid-autumn-12 .cp-14 img{left: 120px; top: 90px;}
.mid-autumn-12 .cp-15 img{left: 370px; top: 100px;}
.mid-autumn-12 .cp-16 img{left: 630px; top: 60px;}
.mid-autumn-12 .cp-17 img{left: 870px; top: 50px;}
.mid-autumn-13 a{width: 211px; height: 231px; top: 40px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/gift-bag_sm.png) no-repeat;}
.mid-autumn-13 .a1{left: -120px;}
.mid-autumn-13 .a2{left: 130px;}
.mid-autumn-13 .a3{left: 380px;}
.mid-autumn-13 .a4{left: 630px;}
.mid-autumn-13 .a5{left: 880px;}
.mid-autumn-13 a span{display: block; position: absolute; top: 78px;}
.mid-autumn-13 .a1 span{width: 103px; height: 89px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-18.png) no-repeat; left: 44px;}
.mid-autumn-13 .a2 span{width: 103px; height: 89px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-19.png) no-repeat; left: 44px;}
.mid-autumn-13 .a3 span{width: 103px; height: 89px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-20.png) no-repeat; left: 44px;}
.mid-autumn-13 .a4 span{width: 138px; height: 89px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-21.png) no-repeat; left: 34px;}
.mid-autumn-13 .a5 span{width: 100px; height: 89px; background: url(<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpInfo-22.png) no-repeat; left: 50px;}
.mid-autumn-13 .cp-18 img{left: -100px; top: 50px;}
.mid-autumn-13 .cp-19 img{left: 130px; top: 90px;}
.mid-autumn-13 .cp-20 img{left: 380px; top: 90px;}
.mid-autumn-13 .cp-21 img{left: 630px; top: 100px;}
.mid-autumn-13 .cp-22 img{left: 890px; top: 60px;}

</style>
	
	<div class="zt-wrap">			
		<div class="mid-autumn-01"></div>
		<div class="mid-autumn-02"></div>
		<div class="mid-autumn-03"></div>
		<div class="mid-autumn-04">
			<div class="zt-con">
				<a href="http://www.g-emall.com/shop/2278.html" class="a1" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/5699.html" class="a2" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/2844.html" class="a3" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/7697.html" class="a4" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/2793.html" class="a5" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/3265.html" class="a6" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/7204.html" class="a7" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/5916.html" class="a8" target="_blank"></a>
				<a href="http://www.g-emall.com/shop/1729.html" class="a9" target="_blank"></a>
			</div>
		</div>
		<div class="mid-autumn-05"></div>
		<div class="mid-autumn-06 cp">
			<div class="zt-con">
				<div class="cp_wrap cp-01">
					<a href="http://www.g-emall.com/JF/2074435.html" title="溪儿小铺金秋福袋（安慕希酸奶+盘锦蟹田大米+华美月饼）营养组合" class="a1" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-01.png">
				</div>
				<div class="cp_wrap cp-02">
					<a href="http://www.g-emall.com/JF/2074300.html" title="溪儿小铺 金秋福袋（盘锦大米+河蟹+月饼）经典组合" class="a2" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-02.png">
				</div>
				<div class="cp_wrap cp-03">
					<a href="http://www.g-emall.com/JF/2209733.html" title="颂月+如意+祝福礼盒组合" class="a3" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-03.png">
				</div>
			</div>
		</div>
		<div class="mid-autumn-07 cp">
			<div class="zt-con">
				<div class="cp_wrap cp-04">
					<a href="http://www.g-emall.com/JF/2209595.html" title="御礼+至尊+悦礼礼盒组合" class="a1" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-04.png">
				</div>
				<div class="cp_wrap cp-05">
					<a href="http://www.g-emall.com/JF/2209363.html" title="无蔗糖+绿茶素饼+金秋时节礼盒组合" class="a2" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-05.png">
				</div>
				<div class="cp_wrap cp-06">
					<a href="http://www.g-emall.com/JF/2209089.html" title="如意+月尚中秋+团圆大礼包组合" class="a3" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-06.png">
				</div>
				<div class="cp_wrap cp-07">
					<a href="http://www.g-emall.com/JF/2208697.html" title="团圆+珍情+思念礼盒组合" class="a4" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-07.png">
				</div>
			</div>
		</div>
		<div class="mid-autumn-08"></div>
		<div class="mid-autumn-09">
			<div class="zt-con">
				<a href="http://www.g-emall.com/JF/2066118.html" class="cpAni_wrap cpAni-01" title="【伊通河】有机大米组合优惠套装 全国包邮">
					<div class="cpwrap_top border_ani"></div>
					<div class="cpwrap_mid bg_ani">
						<div class="gift_bag_sm"><span></span></div>
						<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAni-01.png">
					</div>
					<div class="cpwrap_bot border_ani">
						<div class="cpAniTitle cpAniTitle-01"></div>
					</div>
				</a>
				<a href="http://www.g-emall.com/JF/2192629.html" class="cpAni_wrap cpAni-02" title="【想真】想真有机芝麻糊米糊五谷宝宝营养粉婴幼儿食品辅食组合米糊营养品">
					<div class="cpwrap_top border_ani"></div>
					<div class="cpwrap_mid bg_ani">
						<div class="gift_bag_sm"><span></span></div>
						<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAni-02.png">
					</div>
					<div class="cpwrap_bot border_ani">
						<div class="cpAniTitle cpAniTitle-02"></div>
					</div>
				</a>
				<a href="http://www.g-emall.com/JF/2193489.html" class="cpAni_wrap cpAni-03" title="【想真有机清凉夏日组合】 有机绿豆400g+有机红小豆400g+有机黑豆400g">
					<div class="cpwrap_top border_ani"></div>
					<div class="cpwrap_mid bg_ani">
						<div class="gift_bag_sm"><span></span></div>
						<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAni-03.png">
					</div>
					<div class="cpwrap_bot border_ani">
						<div class="cpAniTitle cpAniTitle-03"></div>
					</div>
				</a>
				<a href="http://www.g-emall.com/JF/2194057.html" class="cpAni_wrap cpAni-04" title="【想真有机营养米套餐组合】有机薏仁400g+黑米400g+糙米400g">
					<div class="cpwrap_top border_ani"></div>
					<div class="cpwrap_mid bg_ani">
						<div class="gift_bag_sm"><span></span></div>
						<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAni-04.png">
					</div>
					<div class="cpwrap_bot border_ani">
						<div class="cpAniTitle cpAniTitle-04"></div>
					</div>
				</a>
				<a href="http://www.g-emall.com/JF/2150537.html" class="cpAni_wrap cpAni-05" title="内蒙牛肉干168g明前二级龙井茶100g东北特级小秋耳500g 超值福袋一">
					<div class="cpwrap_top border_ani"></div>
					<div class="cpwrap_mid bg_ani">
						<div class="gift_bag_sm"><span></span></div>
						<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAni-05.png">
					</div>
					<div class="cpwrap_bot border_ani">
						<div class="cpAniTitle cpAniTitle-05"></div>
					</div>
				</a>
				<a href="http://www.g-emall.com/JF/2150800.html" class="cpAni_wrap cpAni-06" title="东北特级香菇400g美国青豌豆400g龙井明前特级绿茶100克 超值福袋二">
					<div class="cpwrap_top border_ani"></div>
					<div class="cpwrap_mid bg_ani">
						<div class="gift_bag_sm"><span></span></div>
						<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAni-06.png">
					</div>
					<div class="cpwrap_bot border_ani">
						<div class="cpAniTitle cpAniTitle-06"></div>
					</div>
				</a>
				<a href="http://www.g-emall.com/JF/2150862.html" class="cpAni_wrap cpAni-07" title="东北特级小秋耳500g特级香菇干400g雨前二级龙井茶500g超值福袋三">
					<div class="cpwrap_top border_ani"></div>
					<div class="cpwrap_mid bg_ani">
						<div class="gift_bag_sm"><span></span></div>
						<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAni-07.png">
					</div>
					<div class="cpwrap_bot border_ani">
						<div class="cpAniTitle cpAniTitle-07"></div>
					</div>
				</a>
				<a href="http://www.g-emall.com/JF/2203178.html" class="cpAni_wrap cpAni-08" title="组合套餐 富硒大米+生态茶油+原生态土鸡蛋">
					<div class="cpwrap_top border_ani"></div>
					<div class="cpwrap_mid bg_ani">
						<div class="gift_bag_sm"><span></span></div>
						<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAni-08.png">
					</div>
					<div class="cpwrap_bot border_ani">
						<div class="cpAniTitle cpAniTitle-08"></div>
					</div>
				</a>
				<a href="http://www.g-emall.com/goods/2074194.html" class="cpAni_wrap cpAni-09" title="溪儿小铺 金秋福袋 （青岛虾仁干+盘锦正宗河蟹+海兔干）海鲜组合">
					<div class="cpwrap_top border_ani"></div>
					<div class="cpwrap_mid bg_ani">
						<div class="gift_bag_sm"><span></span></div>
						<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAni-09.png">
					</div>
					<div class="cpwrap_bot border_ani">
						<div class="cpAniTitle cpAniTitle-09"></div>
					</div>
				</a>
				<a href="http://www.g-emall.com/JF/2074305.html" class="cpAni_wrap cpAni-10" title="溪儿小铺 金秋福袋（盘锦大米+河蟹+虾干）钜惠组合">
					<div class="cpwrap_top border_ani"></div>
					<div class="cpwrap_mid bg_ani">
						<div class="gift_bag_sm"><span></span></div>
						<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cpAni-10.png">
					</div>
					<div class="cpwrap_bot border_ani">
						<div class="cpAniTitle cpAniTitle-10"></div>
					</div>
				</a>
			</div>
		</div>
		<div class="mid-autumn-10"></div>

		<div class="mid-autumn-11 cp">
			<div class="zt-con">
				<div class="cp_wrap cp-08">
					<a href="http://www.g-emall.com/JF/2074002.html" title="溪儿小铺 金秋福袋（巧克力礼盒+坚果礼盒+安慕希）零食组合" class="a1" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-08.png">
				</div>
				<div class="cp_wrap cp-09">
					<a href="http://www.g-emall.com/JF/2239295.html" title="新疆特产三件宝 特级红枣夹核桃+长寿果+无花果组合零食 休闲食品" class="a2" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-09.png">
				</div>
				<div class="cp_wrap cp-10">
					<a href="http://www.g-emall.com/JF/2239957.html" title="三件宝新疆特产 和田枣+巴旦木+纸皮核桃组合 干果休闲零食" class="a3" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-10.png">
				</div>
				<div class="cp_wrap cp-11">
					<a href="http://www.g-emall.com/JF/2240549.html" title="果特加零食 长寿果+巴西松子+纸皮核桃组合 坚果炒货食品" class="a4" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-11.png">
				</div>
				<div class="cp_wrap cp-12">
					<a href="http://www.g-emall.com/JF/2241287.html" title="新疆特产 干无花果+红枣夹核桃+昆仑雪菊组合 休闲零食干果食品" class="a5" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-12.png">
				</div>
			</div>
		</div>
		<div class="mid-autumn-12 cp">
			<div class="zt-con">
				<div class="cp_wrap cp-13">
					<a href="http://www.g-emall.com/JF/2241816.html" title="零食三件宝 千层酥夹心饼干+吐司蛋糕+红枣夹核桃组合 零食休闲食品" class="a1" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-13.png">
				</div>
				<div class="cp_wrap cp-14">
					<a href="http://www.g-emall.com/JF/2151076.html" title="牛肉干三味组合504g芝麻蜜汁猪肉脯600g手撕烤鱿鱼条500g超值福袋五" class="a2" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-14.png">
				</div>
				<div class="cp_wrap cp-15">
					<a href="http://www.g-emall.com/JF/2151000.html" title="牛肉干三味组合504g芝麻蜜汁猪肉脯600g美国青豌豆400g超值福袋四" class="a3" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-15.png">
				</div>
				<div class="cp_wrap cp-16">
					<a href="http://www.g-emall.com/JF/2203954.html" title="组合套餐 澳洲牛排+儿童牛排+牛肉零食" class="a4" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-16.png">
				</div>
				<div class="cp_wrap cp-17">
					<a href="http://www.g-emall.com/JF/2081826.html" title="腐竹家庭组合优惠装组合装【金秋福袋】" class="a5" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-17.png">
				</div>
			</div>
		</div>
		<div class="mid-autumn-13 cp">
			<div class="zt-con">
				<div class="cp_wrap cp-18">
					<a href="http://www.g-emall.com/JF/2081884.html" title="香菇腐竹家庭装组合装【金秋福袋】" class="a1" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-18.png">
				</div>
				<div class="cp_wrap cp-19">
					<a href="http://www.g-emall.com/JF/2263094.html" title="【果脯屋】金秋超值神秘福袋特级礼包福袋一" class="a2" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-19.png">
				</div>
				<div class="cp_wrap cp-20">
					<a href="http://www.g-emall.com/JF/2263741.html" title="【果脯屋】超值神秘福袋大礼包二" class="a3" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-20.png">
				</div>
				<div class="cp_wrap cp-21">
					<a href="http://www.g-emall.com/JF/2264004.html" title="【果脯屋】超值福袋大礼包三" class="a4" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-21.png">
				</div>
				<div class="cp_wrap cp-22">
					<a href="http://www.g-emall.com/JF/2264344.html" title="【果脯屋】超级爆好福袋四" class="a5" target="_blank"><span></span></a>
					<img src="<?php echo ATTR_DOMAIN;?>/zt/mid-autumn/cp-22.png">
				</div>
			</div>
		</div>
		<a href="https://member.g-emall.com/home/quickRegister"><div class="mid-autumn-14"></div></a>
		<a href="https://member.g-emall.com/home/quickRegister"><div class="mid-autumn-15"></div></a>
	</div>   
   <!--------------主体 End------------>
<!-- 返回顶部 end-->
<script type="text/javascript">
$(function(){
	$('.cp a').hover(function(){
		$(this).addClass('off').siblings('img').addClass('active');
	},function(){
		$(this).removeClass('off').siblings('img').removeClass('active');
	})
	$('.cpAni_wrap').hover(function(){
		$(this).find('.gift_bag_sm').addClass('off').siblings('img').addClass('active');
	},function(){
		$(this).find('.gift_bag_sm').removeClass('off').siblings('img').removeClass('active');
	})
	var onOff = true;
	var timer = null;
	var i = 0;
	var len = $('.cpAni_wrap').length;
	timer = setInterval(function(){
		$('.cpAni_wrap').eq(i).toggleClass('active');
		if(onOff){
			if(i<len-1){
				/*$('.cpAni_wrap').eq(i).addClass('active');*/
				i++;
			}
			else{
				onOff = !onOff;
			}
		}
		else{
			if(i>0){
				/*$('.cpAni_wrap').eq(i).removeClass('active');*/
				i--;
			}
			else{
				onOff = !onOff;
			}
		}
	},1000)
	
	
})
</script>