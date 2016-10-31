
<?php $this->pageTitle='盖象商城-礼品馆'?>
<style>

/*=====
    @Date:2016-10-25
    @content:
	@author:刘泉辉
 =====*/
.zt-wrap{width:100%; background:#fff; overflow: hidden; font-family: "Microsoft YaHei";}
.zt-wrap a{outline: none;}
.zt-con { width:1200px; margin:0 auto; position:relative; }
.zt-con a{ position:absolute;display:block;}
.gift-shop-01{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-01.jpg) top center no-repeat;}
.gift-shop-02{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-02.jpg) top center no-repeat;}
.gift-shop-03{height:300px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-03.jpg) top center no-repeat;}
.gift-shop-04{height:101px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-04.jpg) top center no-repeat;}
.gift-shop-05{height:195px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-05.jpg) top center no-repeat;}
.gift-shop-06{height:193px; background:url(<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-06.jpg) top center no-repeat;}

.gift-shop-slider-r a{left:14px;  width:111px; height:29px;border-radius: 6px;}
.gift-shop-slider-r .a1{top:130px;}
.gift-shop-slider-r .a2{top:166px;}
.gift-shop-slider-r .a3{top:202px;}
.gift-shop-slider-r .a4{top:238px;}
.gift-shop-slider-r .a5{top:274px;}
.gift-shop-slider-r .a6{top:310px;}
.gift-shop-slider-r .a7{top:346px;}

.gift-shop-slider-r{position: relative;}
.gift-shop-slider-r .gift-shop-gotop{position: absolute;display: block;top:418px;left:14px; width:111px; height:29px;border-radius: 6px;}
.gift-shop-content{width: 1200px;margin:0 auto 88px;}
.gift-shop-list-title{border-bottom: 2px solid #000;}
.gift-shop-list-title h2{display: block;float: left;font-size: 24px;color: #000;font-weight: normal;line-height: 45px;}
.gift-shop-list-title h2 span{color:#646464;font-size: 14px;margin-left: 16px;}
.gift-shop-list-title .right{display: block;float: right;margin-right: 14px;margin-top: 13.5px;}
.gift-shop-list-title .right a{display: block;padding: 0px 3px;border:1px solid #525252;float: left;font-size: 14px;color: #525252;margin: 0px 6px;}
.gift-shop-banner a{display: block;width: 163px;height: 50px;line-height: 50px;float: left;text-align: center;font-size: 16px;color: #303030;}
.gift-shop-banner .active{background-color: #000;color: #fff;}
.gift-shop-banner{width: 489px;margin:0 auto;}
.gift-shop-main{margin-top: 35px;}
.gift-shop-main li{float: left;width: 400px;text-align: center;}
.gift-shop-name{font-size: 15px;color: #303030;line-height: 32px;}
.gift-shop-sale{text-align: center; line-height: 32px; margin-bottom: 10px;}
.gift-shop-main-list .list1{display: none;}
.gift-shop-sale span{font-size: 16px;color: red;font-weight: bold;}
.gift-shop-sale a{background-color: red;color: #fff;font-size: 15px;padding: 2px 8px;margin-left:22px;}
.gift-shop-list{margin-top: 40px;}
/*右侧导航*/
.gift-shop-slider-r{display: block;width: 138px;height: 458px;position: fixed;top:100px;left: 50%;display: none;margin-left: 627px;background:url(<?php echo ATTR_DOMAIN;?>/zt/gift-shop/slider-r.jpg) no-repeat;}
/*幻灯片CSS开始*/
.cak_Carousel{width:1200px;height:400px;margin:0 auto;position: relative;display: none;}
.cak_Carousel_main{width:1200px;height:auto;position: absolute;left:0;top:0;}
.cak_Carousel_main li a img{display:block;width:1200px;height:400px;position: absolute;left:0;top:0;}
.cak_Carousel_span{width:1200px;height:35px;position: absolute;left:0;bottom:0;zoom:1;}
.cak_Carousel_span span{width:15px;height:15px;display:block;float:left;margin-left:10px;background: url(<?php echo ATTR_DOMAIN;?>/zt/gift-shop/dot.png) no-repeat left bottom;}
.cak_Carousel_span p{width:100px;height:35px;margin:0 auto;}
.cak_Carousel_span .cak_Carousel_span_one{background: url(<?php echo ATTR_DOMAIN;?>/zt/gift-shop/dot.png) no-repeat left top;}
.cak_Carousel_left{width:60px;height:90px;cursor: pointer;background:#000 url(<?php echo ATTR_DOMAIN;?>/zt/gift-shop/ad_ctr.png) no-repeat 5px -180px;filter:alpha(opacity:50);opacity:0.5;position: absolute;left:0;top:155px;display:none;}
.cak_Carousel_left1{background:#000 url(<?php echo ATTR_DOMAIN;?>/zt/gift-shop/ad_ctr.png) no-repeat 3px top;}
.cak_Carousel_right{width:60px;height:90px;cursor: pointer;background:#000 url(<?php echo ATTR_DOMAIN;?>/zt/gift-shop/ad_ctr.png) no-repeat -5px bottom;filter:alpha(opacity:50);opacity:0.5;position: absolute;right:0;top:155px;display:none;}
.cak_Carousel_right1{background:#000 url(<?php echo ATTR_DOMAIN;?>/zt/gift-shop/ad_ctr.png) no-repeat -3px -90px;}
/*幻灯片css结束*/
</style>
	<div class="zt-wrap">
	     <!-- top-start -->
         <div class="gift-shop-01"></div>
         <div class="gift-shop-02"></div>
         <div class="gift-shop-03"></div>
         <div class="gift-shop-04"></div>
         <!-- top-end -->
         <!-- 轮播start -->
	    <div class="cak_Carousel">
	        <div class="cak_Carousel_main">
	            <ul class="cak_Carousel_ul">
	                <li><a href="javascript:void(0)" class="img"><img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/ad_yuetu.jpg"  alt="微创意" /></a></li>
	                <li><a href="javascript:void(0)" class="img"><img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/ad_nba.jpg"    alt="微创意" /></a></li>
	                <li><a href="javascript:void(0)" class="img"><img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/ad_stock.jpg"  alt="微创意" /></a></li>
	                <li><a href="javascript:void(0)" class="img"><img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/ad_auto.jpg"   alt="微创意" /></a></li>
	            </ul>
	        </div>
	        <p class="cak_Carousel_left"></p>
	        <p class="cak_Carousel_right"></p>
	        <div class="cak_Carousel_span">
	            <p> 
	                <span class="cak_Carousel_span_one"></span> 
	                <span></span> 
	                <span></span>
	                <span></span>
	            </p> 
	        </div>
	    </div>
         <!-- 轮播end -->
         <!-- main-start -->
         <div class="gift-shop-content">
             <div class="gift-shop-slider-r">
                   <div class="zt-con">
						<a href="#cak_shoplist1"  class="a1" target="_blank"></a>
						<a href="#cak_shoplist2"  class="a2" target="_blank"></a>
						<a href="#cak_shoplist3"  class="a3" target="_blank"></a>
						<a href="#cak_shoplist4"  class="a4" target="_blank"></a>
						<a href="#cak_shoplist5"  class="a5" target="_blank"></a>
						<a href="#cak_shoplist6"  class="a6" target="_blank"></a>
						<a href="#cak_shoplist7"  class="a7" target="_blank"></a>
				   </div>
				   <a href="javascript:void(0)"  class="gift-shop-gotop" target="_blank"></a>
             </div>
             <!-- 热门礼品-start -->
             <div class="gift-shop-list" id="cak_shoplist1">
                    <div class="gift-shop-list-title clearfix">
                          <h2>热门礼品<span>送礼就要送好礼</span></h2>
                    </div>
             </div>
             <div class="gift-shop-banner clearfix">
                     <a href="javascript:void(0)" class="active">超值推荐</a>
                     <a href="javascript:void(0)">特色产品</a>
                     <a href="javascript:void(0)">大礼包</a>
             </div>
             <div class="gift-shop-main-list">
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list-01.jpg">
		                     <p class="gift-shop-name">安溪铁观音茶叶茶具礼盒装</p>
		                     <p class="gift-shop-sale clearfix"><span>￥169.00</span><a href="http://www.g-emall.com/JF/1824022.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-02.jpg">
		                     <p class="gift-shop-name">五谷杂粮礼盒组合装</p>
		                     <p class="gift-shop-sale clearfix"><span>￥176.00</span><a href="http://www.g-emall.com/JF/255929.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-03.jpg">
		                     <p class="gift-shop-name">法国乔治男爵起泡酒</p>
		                     <p class="gift-shop-sale clearfix"><span>￥266.00</span><a href="http://www.g-emall.com/JF/53883.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-04.jpg">
		                     <p class="gift-shop-name">广西特产海鸭蛋50枚装</p>
		                     <p class="gift-shop-sale clearfix"><span>￥168.00</span><a href="http://www.g-emall.com/JF/1435771.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-05.jpg">
		                     <p class="gift-shop-name">东北特产人参长白山6年龄参</p>
		                     <p class="gift-shop-sale clearfix"><span>￥238.00</span><a href="http://www.g-emall.com/JF/2519300.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-06.jpg">
		                     <p class="gift-shop-name">坚果炒货零食高档礼品盒组合</p>
		                     <p class="gift-shop-sale clearfix"><span>￥588.00</span><a href="http://www.g-emall.com/JF/2539957.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-07.jpg">
		                     <p class="gift-shop-name">贵州茅台酱香白酒</p>
		                     <p class="gift-shop-sale clearfix"><span>￥1080.00</span><a href="http://www.g-emall.com/JF/281132.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-08.jpg">
		                     <p class="gift-shop-name">内蒙古特产原味牛肉干454g</p>
		                     <p class="gift-shop-sale clearfix"><span>￥120.00</span><a href="http://www.g-emall.com/JF/1407871.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-09.jpg">
		                     <p class="gift-shop-name">广西巴马土特产正中水晶米500g</p>
		                     <p class="gift-shop-sale clearfix"><span>￥16.90</span><a href="http://www.g-emall.com/JF/408852.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-10.jpg">
		                     <p class="gift-shop-name">金珠贡米有机纯粮酒</p>
		                     <p class="gift-shop-sale clearfix"><span>￥289.00</span><a href="http://www.g-emall.com/JF/2619375.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-11.jpg">
		                     <p class="gift-shop-name">盘锦即食海参 野生海参500g</p>
		                     <p class="gift-shop-sale clearfix"><span>￥380.00</span><a href="http://www.g-emall.com/JF/174542.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-12.jpg">
		                     <p class="gift-shop-name">蜀道香麻辣猪肉脯100g*2袋</p>
		                     <p class="gift-shop-sale clearfix"><span>￥32.00</span><a href="http://www.g-emall.com/JF/2501135.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-13.jpg">
		                     <p class="gift-shop-name">休闲零食组合7袋种坚果礼盒装</p>
		                     <p class="gift-shop-sale clearfix"><span>￥128.00</span><a href="http://www.g-emall.com/JF/1881516.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-14.jpg">
		                     <p class="gift-shop-name">德国浓缩果汁_嘉云硬糖组合装</p>
		                     <p class="gift-shop-sale clearfix"><span>￥168.00</span><a href="http://www.g-emall.com/JF/2474477.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-15.jpg">
		                     <p class="gift-shop-name">野生菌食用菌菇干货礼品组合装</p>
		                     <p class="gift-shop-sale clearfix"><span>￥288.00</span><a href="http://www.g-emall.com/JF/2624792.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-16.jpg">
		                     <p class="gift-shop-name">享食者零食12袋坚果干果组合装</p>
		                     <p class="gift-shop-sale clearfix"><span>￥128.00</span><a href="http://www.g-emall.com/JF/2608659.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-17.jpg">
		                     <p class="gift-shop-name">盘锦即食海参 野生海参500g</p>
		                     <p class="gift-shop-sale clearfix"><span>￥146.00</span><a href="http://www.g-emall.com/JF/2583782.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list1-18.jpg">
		                     <p class="gift-shop-name">东北特产山珍礼盒大礼包</p>
		                     <p class="gift-shop-sale clearfix"><span>￥152.00</span><a href="http://www.g-emall.com/JF/118435.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
                    
             </div>
             <!-- 热门礼品-end -->
             <!-- 创意礼物-start -->
             <div class="gift-shop-list" id="cak_shoplist2">
                    <div class="gift-shop-list-title clearfix">
                          <h2>创意礼物<span>花一点心思，留一点难忘回忆</span></h2>
                          <div class="right clearfix">
                             <a href="http://www.g-emall.com/search/search.html?q=%E6%9D%AF%E5%AD%90" target="_blank">杯子</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E5%8F%B0%E7%81%AF" target="_blank">台灯</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E6%91%86%E4%BB%B6" target="_blank">摆件</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E6%8F%92%E8%8A%B1" target="_blank">插花</a>
                          </div>
                    </div>
             </div>
             <div class="gift-shop-banner clearfix">
                     <a href="javascript:void(0)" class="active">创意DIY</a>
                     <a href="javascript:void(0)">专属定制</a>
                     <a href="javascript:void(0)">创意礼品</a>
             </div>
             <div class="gift-shop-main-list">
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-01.jpg">
		                     <p class="gift-shop-name">罗比罗丹创意玻璃水杯</p>
		                     <p class="gift-shop-sale clearfix"><span>￥375.20</span><a href="http://www.g-emall.com/JF/2579392.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-02.jpg">
		                     <p class="gift-shop-name">女生合用创意diy定制心跳杯</p>
		                     <p class="gift-shop-sale clearfix"><span>￥537.42</span><a href="http://www.g-emall.com/JF/2488044.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-03.jpg">
		                     <p class="gift-shop-name">润饰现代北欧摆件创意陶瓷工艺灯</p>
		                     <p class="gift-shop-sale clearfix"><span>￥288.55</span><a href="http://www.g-emall.com/JF/2462323.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-04.jpg">
		                     <p class="gift-shop-name">创意礼品定制ttghc925银领带夹</p>
		                     <p class="gift-shop-sale clearfix"><span>￥286.00</span><a href="http://www.g-emall.com/JF/2352592.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-05.jpg">
		                     <p class="gift-shop-name">定制新婚庆礼品送朋友结婚礼物</p>
		                     <p class="gift-shop-sale clearfix"><span>￥199.00</span><a href="http://www.g-emall.com/JF/585334.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-06.jpg">
		                     <p class="gift-shop-name">水母摆件送灯光底座创意礼物</p>
		                     <p class="gift-shop-sale clearfix"><span>￥127.60</span><a href="http://www.g-emall.com/JF/2390273.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-07.jpg">
		                     <p class="gift-shop-name">手工金雕画 定制挂画</p>
		                     <p class="gift-shop-sale clearfix"><span>￥4588.00</span><a href="http://www.g-emall.com/JF/111088.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-08.jpg">
		                     <p class="gift-shop-name">高端定制指南针袖扣袖钉</p>
		                     <p class="gift-shop-sale clearfix"><span>￥99.00</span><a href="http://www.g-emall.com/JF/1784178.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-09.jpg">
		                     <p class="gift-shop-name">紫魅鳄鱼皮时尚挂饰钥匙扣</p>
		                     <p class="gift-shop-sale clearfix"><span>￥216.00</span><a href="http://www.g-emall.com/JF/248264.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-10.jpg">
		                     <p class="gift-shop-name">可定制logo商务签字笔礼物套装</p>
		                     <p class="gift-shop-sale clearfix"><span>￥203.28</span><a href="http://www.g-emall.com/JF/590110.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-11.jpg">
		                     <p class="gift-shop-name">ELA珠宝定制18K玫瑰金戒指</p>
		                     <p class="gift-shop-sale clearfix"><span>￥898.80</span><a href="http://www.g-emall.com/JF/963734.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-12.jpg">
		                     <p class="gift-shop-name">欧诗漫珍珠白水光沁白礼盒</p>
		                     <p class="gift-shop-sale clearfix"><span>￥398.00</span><a href="http://www.g-emall.com/JF/1928867.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-13.jpg">
		                     <p class="gift-shop-name">泰国工艺品特色木雕 十二层烛台</p>
		                     <p class="gift-shop-sale clearfix"><span>￥359.00</span><a href="http://www.g-emall.com/JF/1523493.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-14.jpg">
		                     <p class="gift-shop-name">古蜀乌木鱼尾梅花梳</p>
		                     <p class="gift-shop-sale clearfix"><span>￥138.00</span><a href="http://www.g-emall.com/JF/122710.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-15.jpg">
		                     <p class="gift-shop-name">家英创意LED带夜光万年历温度计</p>
		                     <p class="gift-shop-sale clearfix"><span>￥35.00</span><a href="http://www.g-emall.com/JF/666416.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-16.jpg">
		                     <p class="gift-shop-name">创意太空星球星空棒棒糖10支</p>
		                     <p class="gift-shop-sale clearfix"><span>￥37.80</span><a href="http://www.g-emall.com/JF/832793.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-17.jpg">
		                     <p class="gift-shop-name">木雕太阳创意墙饰壁挂立体挂件</p>
		                     <p class="gift-shop-sale clearfix"><span>￥607.20</span><a href="http://www.g-emall.com/JF/2690552.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list2-18.jpg">
		                     <p class="gift-shop-name">美式田园复古工业风餐馆创意壁灯</p>
		                     <p class="gift-shop-sale clearfix"><span>￥296.00</span><a href="http://www.g-emall.com/JF/1924440.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
                    
             </div>
             <!-- 创意礼物-end -->
             <!-- 商务送礼-start -->
             <div class="gift-shop-list" id="cak_shoplist3">
                    <div class="gift-shop-list-title clearfix">
                          <h2>商务送礼<span>送礼更要送“面子”</span></h2>
                          <div class="right clearfix">
                             <a href="http://www.g-emall.com/search/search.html?q=%E8%8C%97%E8%8C%B6" target="_blank">茗茶</a>
                             <a href="http://www.g-emall.com/search/search.html?q=沉香" target="_blank">沉香</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E6%94%B6%E8%97%8F%E5%93%81" target="_blank">收藏品</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E5%90%8D%E9%85%92" target="_blank">名酒</a>
                          </div>
                    </div>
             </div>
             <div class="gift-shop-banner clearfix">
                     <a href="javascript:void(0)" class="active">送客户</a>
                     <a href="javascript:void(0)">送上司</a>
                     <a href="javascript:void(0)">送同事</a>
             </div>
             <div class="gift-shop-main-list">
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-01.jpg">
		                     <p class="gift-shop-name">流云香道倒流香熏炉</p>
		                     <p class="gift-shop-sale clearfix"><span>￥215.00</span><a href="http://www.g-emall.com/JF/241784.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-02.jpg">
		                     <p class="gift-shop-name">木吉 印度小叶紫檀手镯</p>
		                     <p class="gift-shop-sale clearfix"><span>￥279.00</span><a href="http://www.g-emall.com/JF/1673134.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-03.jpg">
		                     <p class="gift-shop-name">意大利原瓶原装进口红酒2支装礼盒</p>
		                     <p class="gift-shop-sale clearfix"><span>￥278.00</span><a href="http://www.g-emall.com/JF/2598034.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-04.jpg">
		                     <p class="gift-shop-name">罗比罗丹硕果累累杯工艺品杯子</p>
		                     <p class="gift-shop-sale clearfix"><span>￥420.00</span><a href="http://www.g-emall.com/JF/162245.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-05.jpg">
		                     <p class="gift-shop-name">苹果手机Apple iPhone 6Splus </p>
		                     <p class="gift-shop-sale clearfix"><span>￥6488.00</span><a href="http://www.g-emall.com/JF/303559.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-06.jpg">
		                     <p class="gift-shop-name">中国风青花瓷茶具套装</p>
		                     <p class="gift-shop-sale clearfix"><span>￥295.00</span><a href="http://www.g-emall.com/JF/1444045.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-07.jpg">
		                     <p class="gift-shop-name">风水阁桃木木雕雕刻一帆风顺帆船</p>
		                     <p class="gift-shop-sale clearfix"><span>￥700.00</span><a href="http://www.g-emall.com/JF/2551273.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-08.jpg">
		                     <p class="gift-shop-name">POLO万向轮拉杆箱男女行李箱</p>
		                     <p class="gift-shop-sale clearfix"><span>￥855.00</span><a href="http://www.g-emall.com/JF/811839.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-09.jpg">
		                     <p class="gift-shop-name">手工金雕画 定制挂画 宁静致远</p>
		                     <p class="gift-shop-sale clearfix"><span>￥7239.00</span><a href="http://www.g-emall.com/JF/111135.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-10.jpg">
		                     <p class="gift-shop-name">最新款立体声4.1无线蓝牙耳机</p>
		                     <p class="gift-shop-sale clearfix"><span>￥220.00</span><a href="http://www.g-emall.com/JF/244458.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-11.jpg">
		                     <p class="gift-shop-name">印度小叶紫檀满金星木手串</p>
		                     <p class="gift-shop-sale clearfix"><span>￥598.00</span><a href="http://www.g-emall.com/JF/770203.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-12.jpg">
		                     <p class="gift-shop-name">  32.5cm天然沉香礼盒</p>
		                     <p class="gift-shop-sale clearfix"><span>￥160.00</span><a href="http://www.g-emall.com/JF/253259.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-13.jpg">
		                     <p class="gift-shop-name">无印U型颈枕良品专柜同款颈部靠枕</p>
		                     <p class="gift-shop-sale clearfix"><span>￥169.00</span><a href="http://www.g-emall.com/JF/443922.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-14.jpg">
		                     <p class="gift-shop-name">lovo乐我家纺办公室简约卡通靠枕</p>
		                     <p class="gift-shop-sale clearfix"><span>￥100.30</span><a href="http://www.g-emall.com/JF/2609885.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-15.jpg">
		                     <p class="gift-shop-name">【雀巢咖啡】 醇品200g</p>
		                     <p class="gift-shop-sale clearfix"><span>￥129.80</span><a href="http://www.g-emall.com/JF/2975342.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-16.jpg">
		                     <p class="gift-shop-name">6种口味组合装c礼盒</p>
		                     <p class="gift-shop-sale clearfix"><span>￥151.20</span><a href="http://www.g-emall.com/JF/1941712.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-17.jpg">
		                     <p class="gift-shop-name">杜鹃花盆栽花卉室内绿色植物</p>
		                     <p class="gift-shop-sale clearfix"><span>￥66.15</span><a href="http://www.g-emall.com/JF/1647363.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list3-18.jpg">
		                     <p class="gift-shop-name">南极人眼部按摩器护眼仪</p>
		                     <p class="gift-shop-sale clearfix"><span>￥86.00</span><a href="http://www.g-emall.com/JF/2079926.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
                    
             </div>
             <!-- 商务送礼-end -->
             <!-- 长辈送礼-start -->
             <div class="gift-shop-list" id="cak_shoplist4">
                    <div class="gift-shop-list-title clearfix">
                          <h2>长辈送礼<span>一份好礼，十分孝心</span></h2>
                          <div class="right clearfix">
                             <a href="http://www.g-emall.com/search/search.html?q=%E5%85%BB%E7%94%9F%E4%BF%9D%E5%81%A5" target="_blank">养生保健</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E6%8C%89%E6%91%A9" target="_blank">按摩产品</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E6%9C%8D%E9%A5%B0%E9%85%8D%E9%A5%B0" target="_blank">服饰配饰</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E5%85%BB%E7%94%9F%E9%A3%9F%E5%93%81" target="_blank">食品</a>
                          </div>
                    </div>
             </div>
             <div class="gift-shop-banner clearfix">
                     <a href="javascript:void(0)" class="active">送妈妈</a>
                     <a href="javascript:void(0)">送爸爸</a>
                     <a href="javascript:void(0)">送长辈</a>
             </div>
             <div class="gift-shop-main-list">
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-01.jpg">
		                     <p class="gift-shop-name">泰国进口乳胶高低枕头</p>
		                     <p class="gift-shop-sale clearfix"><span>￥800.00</span><a href="http://www.g-emall.com/JF/417280.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-02.jpg">
		                     <p class="gift-shop-name">北京同仁堂白燕丝冰糖燕窝胶</p>
		                     <p class="gift-shop-sale clearfix"><span>￥495.00</span><a href="http://www.g-emall.com/JF/2501370.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-03.jpg">
		                     <p class="gift-shop-name">康豪8558足浴盆全自动按摩加热</p>
		                     <p class="gift-shop-sale clearfix"><span>￥360.00</span><a href="http://www.g-emall.com/JF/288639.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-04.jpg">
		                     <p class="gift-shop-name">特级野生黑枸杞 珍稀品种</p>
		                     <p class="gift-shop-sale clearfix"><span>￥800.00</span><a href="http://www.g-emall.com/JF/110158.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-05.jpg">
		                     <p class="gift-shop-name">AUX/奥克斯20A家用多功能搅拌机</p>
		                     <p class="gift-shop-sale clearfix"><span>￥554.00</span><a href="http://www.g-emall.com/JF/83977.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-06.jpg">
		                     <p class="gift-shop-name">Formia芳美亚发饰韩国饰品发夹</p>
		                     <p class="gift-shop-sale clearfix"><span>￥248.00</span><a href="http://www.g-emall.com/JF/208352.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-07.jpg">
		                     <p class="gift-shop-name">高档陶瓷骨瓷内胆保温杯</p>
		                     <p class="gift-shop-sale clearfix"><span>￥281.00</span><a href="http://www.g-emall.com/JF/2646019.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-08.jpg">
		                     <p class="gift-shop-name">崂乡茶叶 简装手工扁茶100g</p>
		                     <p class="gift-shop-sale clearfix"><span>￥388.00</span><a href="http://www.g-emall.com/JF/2749872.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-09.jpg">
		                     <p class="gift-shop-name">新品智高手环手表可穿戴</p>
		                     <p class="gift-shop-sale clearfix"><span>￥288.00</span><a href="http://www.g-emall.com/JF/2581765.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-10.jpg">
		                     <p class="gift-shop-name">秋季男士休闲鞋真皮男鞋牛筋底</p>
		                     <p class="gift-shop-sale clearfix"><span>￥275.00</span><a href="http://www.g-emall.com/JF/2654872.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-11.jpg">
		                     <p class="gift-shop-name">贝朗皮具汉姆斯胸包男真皮小背包</p>
		                     <p class="gift-shop-sale clearfix"><span>￥168.00</span><a href="http://www.g-emall.com/JF/89138.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-12.jpg">
		                     <p class="gift-shop-name">【室雅兰香】字画书画 行书 条幅</p>
		                     <p class="gift-shop-sale clearfix"><span>￥171.00</span><a href="http://www.g-emall.com/JF/2175797.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-13.jpg">
		                     <p class="gift-shop-name">全磁疗保健枕一对 养生保健</p>
		                     <p class="gift-shop-sale clearfix"><span>￥298.00</span><a href="http://www.g-emall.com/JF/362372.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-14.jpg">
		                     <p class="gift-shop-name"> 宜兴紫砂茶具9件套装礼盒</p>
		                     <p class="gift-shop-sale clearfix"><span>￥880.00</span><a href="http://www.g-emall.com/JF/692321.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-15.jpg">
		                     <p class="gift-shop-name">想真有机杂粮组合薏米粗粮食五谷</p>
		                     <p class="gift-shop-sale clearfix"><span>￥189.00</span><a href="http://www.g-emall.com/JF/275977.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-16.jpg">
		                     <p class="gift-shop-name">无糖无添蔗糖食品礼盒大礼包</p>
		                     <p class="gift-shop-sale clearfix"><span>￥278.00</span><a href="http://www.g-emall.com/JF/1822813.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-17.jpg">
		                     <p class="gift-shop-name">正品老人头新款商务正装真皮男鞋</p>
		                     <p class="gift-shop-sale clearfix"><span>￥318.00</span><a href="http://www.g-emall.com/JF/1171233.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list4-18.jpg">
		                     <p class="gift-shop-name">济福生牌中江丹参茶三高养生茶叶</p>
		                     <p class="gift-shop-sale clearfix"><span>￥136.00</span><a href="http://www.g-emall.com/JF/1596734.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
                    
             </div>
             <!-- 长辈送礼-end -->
             <!-- 情侣礼物-start -->
             <div class="gift-shop-list" id="cak_shoplist5">
                    <div class="gift-shop-list-title clearfix">
                          <h2>情侣礼物<span>夺取芳心的法宝，表白心声的首选</span></h2>
                          <div class="right clearfix">
                             <a href="http://www.g-emall.com/search/search.html?q=%E5%AE%B6%E5%B1%85%E6%9C%8D" target="_blank">家居服</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E9%A6%99%E6%B0%B4" target="_blank">香水</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E5%B7%A7%E5%85%8B%E5%8A%9B" target="_blank">巧克力</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E6%83%85%E4%BE%A3%E9%A5%B0%E5%93%81" target="_blank">情侣饰品</a>
                          </div>
                    </div>
             </div>
             <div class="gift-shop-banner clearfix">
                     <a href="javascript:void(0)" class="active">送女友</a>
                     <a href="javascript:void(0)">送男友</a>
                     <a href="javascript:void(0)">结婚礼物</a>
             </div>
             <div class="gift-shop-main-list">
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-01.jpg">
		                     <p class="gift-shop-name">Dior/迪奥蜜斯花漾淡喷鼻香氛</p>
		                     <p class="gift-shop-sale clearfix"><span>￥1099.52</span><a href="http://www.g-emall.com/JF/1439265.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-02.jpg">
		                     <p class="gift-shop-name">香奈儿 炫亮魅力丝绒唇膏3.5g</p>
		                     <p class="gift-shop-sale clearfix"><span>￥293.00</span><a href="http://www.g-emall.com/JF/58942.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-03.jpg">
		                     <p class="gift-shop-name">伊泰莲娜丽晶 复古镶钻珍珠首饰</p>
		                     <p class="gift-shop-sale clearfix"><span>￥316.00</span><a href="http://www.g-emall.com/JF/115210.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-04.jpg">
		                     <p class="gift-shop-name">新家园创意保温杯情侣礼品套装</p>
		                     <p class="gift-shop-sale clearfix"><span>￥238.00</span><a href="http://www.g-emall.com/JF/2589809.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-05.jpg">
		                     <p class="gift-shop-name">诺梵黑松露形巧克力零食大礼包</p>
		                     <p class="gift-shop-sale clearfix"><span>￥128.00</span><a href="http://www.g-emall.com/JF/1982289.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-06.jpg">
		                     <p class="gift-shop-name">新品ELLE女包花色PVC手提包</p>
		                     <p class="gift-shop-sale clearfix"><span>￥508.80</span><a href="http://www.g-emall.com/JF/2355384.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-07.jpg">
		                     <p class="gift-shop-name">佳能 EOS 60D 单反套机</p>
		                     <p class="gift-shop-sale clearfix"><span>￥6488.00</span><a href="http://www.g-emall.com/JF/22924.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-08.jpg">
		                     <p class="gift-shop-name">女生女友送男生男友老公创意小礼</p>
		                     <p class="gift-shop-sale clearfix"><span>￥238.00</span><a href="http://www.g-emall.com/JF/918848.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-09.jpg">
		                     <p class="gift-shop-name">七匹狼钱包男短款真皮</p>
		                     <p class="gift-shop-sale clearfix"><span>￥117.30</span><a href="http://www.g-emall.com/JF/2271481.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-10.jpg">
		                     <p class="gift-shop-name">男士皮带自动扣腰带真皮皮带</p>
		                     <p class="gift-shop-sale clearfix"><span>￥399.00</span><a href="http://www.g-emall.com/JF/167994.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-11.jpg">
		                     <p class="gift-shop-name">飞科电动剃须刀男豪华礼盒装</p>
		                     <p class="gift-shop-sale clearfix"><span>￥299.00</span><a href="http://www.g-emall.com/JF/553369.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-12.jpg">
		                     <p class="gift-shop-name">  高档奢华清凉竹纤维男士平角裤</p>
		                     <p class="gift-shop-sale clearfix"><span>￥68.00</span><a href="http://www.g-emall.com/JF/273057.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-13.jpg">
		                     <p class="gift-shop-name">送礼婚庆生日巧克力糖果礼盒</p>
		                     <p class="gift-shop-sale clearfix"><span>￥202.80</span><a href="http://www.g-emall.com/JF/2482034.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-14.jpg">
		                     <p class="gift-shop-name"> 欧式情侣镀金天鹅摆件结婚礼物</p>
		                     <p class="gift-shop-sale clearfix"><span>￥168.00</span><a href="http://www.g-emall.com/JF/693921.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-15.jpg">
		                     <p class="gift-shop-name">jeancard台湾木质婚礼蛋糕音乐盒</p>
		                     <p class="gift-shop-sale clearfix"><span>￥268.00</span><a href="http://www.g-emall.com/JF/345468.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-16.jpg">
		                     <p class="gift-shop-name">红酒杯珐琅结婚礼物</p>
		                     <p class="gift-shop-sale clearfix"><span>￥475.00</span><a href="http://www.g-emall.com/JF/1679792.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-17.jpg">
		                     <p class="gift-shop-name">款新娘结婚收腰鱼尾婚纱</p>
		                     <p class="gift-shop-sale clearfix"><span>￥569.00</span><a href="http://www.g-emall.com/JF/2690500.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list5-18.jpg">
		                     <p class="gift-shop-name">晶生爱珠宝 24k金箔玫瑰胸花</p>
		                     <p class="gift-shop-sale clearfix"><span>￥320.00</span><a href="http://www.g-emall.com/JF/337843.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
                    
             </div>
             <!-- 情侣礼物-end -->
             <!-- 朋友礼物-start -->
             <div class="gift-shop-list" id="cak_shoplist6">
                    <div class="gift-shop-list-title clearfix">
                          <h2>朋友礼物<span>礼物常往来，友谊地久天长</span></h2>
                          <div class="right clearfix">
                             <a href="http://www.g-emall.com/search/search.html?q=%E6%89%8B%E6%9C%BA%E6%95%B0%E7%A0%81" target="_blank">手机数码</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E9%92%B1%E5%8C%85" target="_blank">钱包</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E9%9E%8B%E5%AD%90" target="_blank">鞋子</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E6%89%8B%E6%8F%90%E5%8C%85" target="_blank">包包</a>
                          </div>
                    </div>
             </div>
             <div class="gift-shop-banner clearfix">
                     <a href="javascript:void(0)" class="active">送闺蜜</a>
                     <a href="javascript:void(0)">送基友</a>
                     <a href="javascript:void(0)">送知己</a>
             </div>
             <div class="gift-shop-main-list">
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-01.jpg">
		                     <p class="gift-shop-name">周大福CoCo Cat系列小猫珍珠吊坠</p>
		                     <p class="gift-shop-sale clearfix"><span>￥998.00</span><a href="http://www.g-emall.com/JF/2238822.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-02.jpg">
		                     <p class="gift-shop-name"> NIKE耐克 女子运动内衣</p>
		                     <p class="gift-shop-sale clearfix"><span>￥379.00</span><a href="http://www.g-emall.com/JF/1677812.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-03.jpg">
		                     <p class="gift-shop-name">OSM欧诗漫珍珠白营养美肤礼盒</p>
		                     <p class="gift-shop-sale clearfix"><span>￥286.00</span><a href="http://www.g-emall.com/JF/2606146.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-04.jpg">
		                     <p class="gift-shop-name">迪奥口红 克里斯汀迪奥全新烈艳</p>
		                     <p class="gift-shop-sale clearfix"><span>￥238.00</span><a href="http://www.g-emall.com/JF/136559.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-05.jpg">
		                     <p class="gift-shop-name">vme舞魅 优雅尖头水钻T型高跟鞋</p>
		                     <p class="gift-shop-sale clearfix"><span>￥2740.00</span><a href="http://www.g-emall.com/JF/662828.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-06.jpg">
		                     <p class="gift-shop-name">Clinie可莱丝水库补水面膜</p>
		                     <p class="gift-shop-sale clearfix"><span>￥110.00</span><a href="http://www.g-emall.com/JF/172683.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-07.jpg">
		                     <p class="gift-shop-name">杰威尔男士护肤品礼盒套装</p>
		                     <p class="gift-shop-sale clearfix"><span>￥389.00</span><a href="http://www.g-emall.com/JF/1907327.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-08.jpg">
		                     <p class="gift-shop-name">克雷斯丹尼男士真皮钱包</p>
		                     <p class="gift-shop-sale clearfix"><span>￥638.00</span><a href="http://www.g-emall.com/JF/162156.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-09.jpg">
		                     <p class="gift-shop-name">欧美个性iPhone6手机壳</p>
		                     <p class="gift-shop-sale clearfix"><span>￥98.00</span><a href="http://www.g-emall.com/JF/2505999.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-10.jpg">
		                     <p class="gift-shop-name">汽车用品汽车头枕 护颈枕</p>
		                     <p class="gift-shop-sale clearfix"><span>￥99.00</span><a href="http://www.g-emall.com/JF/217059.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-11.jpg">
		                     <p class="gift-shop-name">宜博魅影狂蛇2代LOL无线游戏鼠标</p>
		                     <p class="gift-shop-sale clearfix"><span>￥258.00</span><a href="http://www.g-emall.com/JF/2614732.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-12.jpg">
		                     <p class="gift-shop-name">  漫威 蜘蛛侠英雄系列</p>
		                     <p class="gift-shop-sale clearfix"><span>￥130.00</span><a href="http://www.g-emall.com/JF/154096.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-13.jpg">
		                     <p class="gift-shop-name">秘密花园减压涂鸦书</p>
		                     <p class="gift-shop-sale clearfix"><span>￥58.00</span><a href="http://www.g-emall.com/JF/791794.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-14.jpg">
		                     <p class="gift-shop-name"> Kindle Paperwhite3电子书阅读器</p>
		                     <p class="gift-shop-sale clearfix"><span>￥958.00</span><a href="http://www.g-emall.com/JF/986322.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-15.jpg">
		                     <p class="gift-shop-name">好丽友派60枚大包装</p>
		                     <p class="gift-shop-sale clearfix"><span>￥115.00</span><a href="http://www.g-emall.com/JF/1721507.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-16.jpg">
		                     <p class="gift-shop-name">三国款义勇仁500ml中国名酒</p>
		                     <p class="gift-shop-sale clearfix"><span>￥657.00</span><a href="http://www.g-emall.com/JF/2633026.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-17.jpg">
		                     <p class="gift-shop-name">吉列剃须刀泡沫210g</p>
		                     <p class="gift-shop-sale clearfix"><span>￥39.00</span><a href="http://www.g-emall.com/JF/1037652.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list6-18.jpg">
		                     <p class="gift-shop-name">大德  天然马拉OK沉香手串</p>
		                     <p class="gift-shop-sale clearfix"><span>￥518.00</span><a href="http://www.g-emall.com/JF/2761018.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
                    
             </div>
             <!-- 朋友礼物-end -->
             <!-- 孩子礼物-start -->
             <div class="gift-shop-list" id="cak_shoplist7">
                    <div class="gift-shop-list-title clearfix">
                          <h2>孩子礼物<span>满足孩子最简单的愿望</span></h2>
                          <div class="right clearfix">
                             <a href="http://www.g-emall.com/search/search.html?q=%E6%AF%9B%E7%BB%92%E7%8E%A9%E5%85%B7" target="_blank">毛绒娃娃</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E7%AB%A5%E8%A3%85" target="_blank">童装</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E5%84%BF%E7%AB%A5%E7%8E%A9%E5%85%B7" target="_blank">玩具</a>
                             <a href="http://www.g-emall.com/search/search.html?q=%E5%A5%B6%E7%B2%89" target="_blank">奶粉</a>
                          </div>
                    </div>
             </div>
             <div class="gift-shop-banner clearfix">
                     <a href="javascript:void(0)" class="active">送女孩</a>
                     <a href="javascript:void(0)">送男孩</a>
                     <a href="javascript:void(0)">送婴儿</a>
             </div>
             <div class="gift-shop-main-list">
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-01.jpg">
		                     <p class="gift-shop-name">3d箱 迪斯尼索菲亚立体儿童拉杆箱</p>
		                     <p class="gift-shop-sale clearfix"><span>￥299.00</span><a href="http://www.g-emall.com/JF/410613.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-02.jpg">
		                     <p class="gift-shop-name"> HPPLGG朱莉娅公主抱座椅</p>
		                     <p class="gift-shop-sale clearfix"><span>￥204.00</span><a href="http://www.g-emall.com/JF/2649464.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-03.jpg">
		                     <p class="gift-shop-name">儿童节电子琴带麦克风3-6岁1礼物</p>
		                     <p class="gift-shop-sale clearfix"><span>￥273.00</span><a href="http://www.g-emall.com/JF/1598902.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-04.jpg">
		                     <p class="gift-shop-name">HappyPrince韩国婴儿韩版发套</p>
		                     <p class="gift-shop-sale clearfix"><span>￥79.04</span><a href="http://www.g-emall.com/JF/1765119.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-05.jpg">
		                     <p class="gift-shop-name">玩具Hello Kitty猫 1米 毛绒公仔</p>
		                     <p class="gift-shop-sale clearfix"><span>￥212.00</span><a href="http://www.g-emall.com/JF/7381.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-06.jpg">
		                     <p class="gift-shop-name">船鼠女童连衣裙秋冬韩版儿童冬裙</p>
		                     <p class="gift-shop-sale clearfix"><span>￥184.00</span><a href="http://www.g-emall.com/JF/2816435.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-07.jpg">
		                     <p class="gift-shop-name">金儿童玩具遥控飞机直升飞机</p>
		                     <p class="gift-shop-sale clearfix"><span>￥169.00</span><a href="http://www.g-emall.com/JF/2649461.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-08.jpg">
		                     <p class="gift-shop-name">2016秋款童装男童迷彩外套</p>
		                     <p class="gift-shop-sale clearfix"><span>￥138.00</span><a href="http://www.g-emall.com/JF/2356622.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-09.jpg">
		                     <p class="gift-shop-name">双鹰正品1:12吉普牧马人遥控车</p>
		                     <p class="gift-shop-sale clearfix"><span>￥235.00</span><a href="http://www.g-emall.com/JF/184950.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-10.jpg">
		                     <p class="gift-shop-name">好孩子儿童自行车运动型儿童单车</p>
		                     <p class="gift-shop-sale clearfix"><span>￥619.00</span><a href="http://www.g-emall.com/JF/113869.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-11.jpg">
		                     <p class="gift-shop-name">新乐新 益智拼插拼装积木</p>
		                     <p class="gift-shop-sale clearfix"><span>￥109.00</span><a href="http://www.g-emall.com/JF/2545097.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-12.jpg">
		                     <p class="gift-shop-name">星儿童积木玩具益智变形机器人</p>
		                     <p class="gift-shop-sale clearfix"><span>￥96.00</span><a href="http://www.g-emall.com/JF/138478.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
              <div class="list1">
                     <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-13.jpg">
		                     <p class="gift-shop-name">有机棉新生儿玩具衣服礼盒</p>
		                     <p class="gift-shop-sale clearfix"><span>￥399.00</span><a href="http://www.g-emall.com/JF/2622865.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-14.jpg">
		                     <p class="gift-shop-name">BACIUZZI帕琦婴儿推车婴儿车</p>
		                     <p class="gift-shop-sale clearfix"><span>￥2950.00</span><a href="http://www.g-emall.com/JF/1410014.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-15.jpg">
		                     <p class="gift-shop-name">2016男女童新生婴儿宝宝内衣</p>
		                     <p class="gift-shop-sale clearfix"><span>￥393.75</span><a href="http://www.g-emall.com/JF/1005151.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>
		             <ul class="gift-shop-main clearfix">
		                 <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-16.jpg">
		                     <p class="gift-shop-name">好孩子宽口径PPSU奶瓶婴儿奶瓶</p>
		                     <p class="gift-shop-sale clearfix"><span>￥129.00</span><a href="http://www.g-emall.com/JF/2649887.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-17.jpg">
		                     <p class="gift-shop-name">Merries 日本花王妙而舒纸尿裤</p>
		                     <p class="gift-shop-sale clearfix"><span>￥728.00</span><a href="http://www.g-emall.com/JF/1994816.html" target="_blank">点击抢购</a></p>  
		                 </li>
		                  <li>
		                     <img src="<?php echo ATTR_DOMAIN;?>/zt/gift-shop/gift-shop-list7-18.jpg">
		                     <p class="gift-shop-name">荷兰本土进口牛栏4段婴幼儿奶粉</p>
		                     <p class="gift-shop-sale clearfix"><span>￥145.00</span><a href="http://www.g-emall.com/JF/231269.html" target="_blank">点击抢购</a></p>  
		                 </li>
		             </ul>        
              </div>
                    
             </div>
             <!-- 孩子礼物-end -->
         </div>
         <!-- main-end -->
         <!-- bottom-start -->
         <div class="gift-shop-05"></div>
         <div class="gift-shop-06"></div>
         <!-- bottom-end -->
         <script type="text/javascript">
             //轮播start
             $(document).ready(function(){
					var num=$('.cak_Carousel_span span').length;
					var i_mun=0;
					var timer_banner=null;

					$('.cak_Carousel_ul li:gt(0)').hide();//页面加载隐藏所有的li 除了第一个
					
				//底下小图标点击切换
					$('.cak_Carousel_span span').click(function(){
						$(this).addClass('cak_Carousel_span_one')
							   .siblings('span').removeClass('cak_Carousel_span_one');
						var i_mun1=$('.cak_Carousel_span span').index(this);
						$('.cak_Carousel_ul li').eq(i_mun1).fadeIn('slow')
							                   .siblings('li').fadeOut('slow');

						i_mun=i_mun1;
					});
					
				//左边箭头点击时切换
					$('.cak_Carousel_left').click(function(){
						if(i_mun==0){
							i_mun=num
						}
						//大图切换
						$('.cak_Carousel_ul li').eq(i_mun-1).fadeIn('slow')
												   .siblings('li').fadeOut('slow');
						//小图切换
						$('.cak_Carousel_span span').eq(i_mun-1).addClass('cak_Carousel_span_one')
								   .siblings('span').removeClass('cak_Carousel_span_one');

						i_mun--
					});

					//左边按钮移动到其上时更换背景图片
				    $('.cak_Carousel_left').mouseover(function(){
						
						$('.cak_Carousel_left').addClass('cak_Carousel_left1');
					});

					//左边按钮移动到其上时还原背景图片
					$('.cak_Carousel_left').mouseout(function(){
						
						$('.cak_Carousel_left').removeClass('cak_Carousel_left1');
					});

				//右边箭头点击时切换
					$('.cak_Carousel_right').click(function(){
						move_banner()
						
					});

					//右边按钮移动到其上时更换背景图片
					$('.cak_Carousel_right').mouseover(function(){
						
						$('.cak_Carousel_right').addClass('cak_Carousel_right1');
					});

					//右边按钮移动到其上时更换背景图片
					$('.cak_Carousel_right').mouseout(function(){
						
						$('.cak_Carousel_right').removeClass('cak_Carousel_right1');
					});
					
				   //鼠标移动到幻灯片上时 显示左右切换案例
					$('.cak_Carousel').mouseover(function(){
						$('.cak_Carousel_left').show();
						$('.cak_Carousel_right').show();
					});

				  //鼠标离开幻灯片上时 隐藏左右切换案例
					$('.cak_Carousel').mouseout(function(){
						$('.cak_Carousel_left').hide();
						$('.cak_Carousel_right').hide();
					});
					
					//自动播放函数
					function bannerMoveks(){
						timer_banner=setInterval(function(){
							move_banner()
						},4000)
					};
					bannerMoveks();//开始自动播放

					//鼠标移动到banner上时停止播放
					$('.cak_Carousel').mouseover(function(){
						clearInterval(timer_banner);
					});

					//鼠标离开 banner 开启定时播放
					$('.cak_Carousel').mouseout(function(){
						bannerMoveks();
					});


				//banner 右边点击执行函数
				   function move_banner(){
							if(i_mun==num-1){
								i_mun=-1
							}
							//大图切换
							$('.cak_Carousel_ul li').eq(i_mun+1).fadeIn('slow')
													   .siblings('li').fadeOut('slow');
							//小图切换
							$('.cak_Carousel_span span').eq(i_mun+1).addClass('cak_Carousel_span_one')
									   .siblings('span').removeClass('cak_Carousel_span_one');

							i_mun++
						
						}

				})

             //轮播end
             
             // tab切换
             $(function(){
				  function tabs(tabTit,on,tabCon){
				  $(tabCon).each(function(){
				    $(this).children().eq(0).show();
				    });
				  $(tabTit).each(function(){
				    $(this).children().eq(0).addClass(on);
				    });
				     $(tabTit).children().hover(function(){
				        $(this).addClass(on).siblings().removeClass(on);
				         var index = $(tabTit).children().index(this);
				         $(tabCon).children().eq(index).show().siblings().hide();
				    });
				     }
				    tabs(".gift-shop-banner","active",".gift-shop-main-list");
				   });
             // 右侧导航
             // 侧方导航
			$(function(){
			             $(".gift-shop-slider-r a").click(function(e){
			                   if(e && e.preventDefault) {    
			                  　　//阻止默认浏览器动作(W3C)    
			                   　　e.preventDefault();    
			                   } else {    
			                    　//IE中阻止函数器默认动作的方式     
			                    　window.event.returnValue = false; 
			                   }
			                  var index = $(this).index();
			                  var t = $(".gift-shop-content .gift-shop-list").eq(index).offset().top;
			                  $("html , body").stop().animate({
			                      scrollTop:t
			                  })
			             })
			            var h = $(".gift-shop-slider-r").height();
			            var h1 = $("#cak_shoplist1").offset().top;
			            // var h2 = $(".Museum-home-header").offset().top;
			            $(window).scroll(function(){
			                 if($(document).scrollTop() <= h1){
			                    $(".gift-shop-slider-r").stop().animate({
			                         height:0,
			                         opacity: 0 
			                    },500)
			                 }
			                 else{
			                    $(".gift-shop-slider-r").show().stop().animate({
				                     height:h,
				                     opacity: 1     
			                    },500)
			                 }
			            })

			            /*回到顶部*/
					$(".gift-shop-gotop").click(function() {
						$('body,html').stop().animate({scrollTop: 0}, 500);
						return false;
					});
			        })

         </script>     
	</div>   
   <!--主体 End -->