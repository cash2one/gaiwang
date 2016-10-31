
<?php $this->pageTitle="盖象商城-家居馆";?>
<style>

/*=====
    @Date:2016-09-30
    @content:
	@author:刘泉辉
 =====*/
.zt-wrap{width:100%; background:#f5f5f5; overflow: hidden; font-family: "Microsoft YaHei"}
.Museum-home-wrap{width: 1200px;margin:0 auto; position: relative;}
.Museum-home-wrap a{outline: none;}
.Museum-home-sidebar-r{position: fixed;right:50%;margin-right: -648px;z-index: 99;top:100px;display: none;}
.Museum-home-sidebar-r .items-header a{background-color: red;line-height: 36px;display: block;width: 48px;height: 36px;color: #fff;font-size: 12px;text-align: center;margin-bottom: 2px;}
.Museum-home-sidebar-r .items-bottom a{display: block;width: 48px;height: 36px;color: #fff;font-size: 12px;text-align: center;background-color: #acacac;margin-bottom: 2px;}
.Museum-home-sidebar-r .items-list a{display: block;width: 48px;height: 36px;color: #fff;font-size: 12px;text-align: center;background-color: #626262;margin-bottom: 2px;}
.Museum-home-sidebar-r .items-list .c1.cak-active{background-color: #f7a945;}
.Museum-home-sidebar-r .items-list .c1:hover{background-color: #f7a945;}
.Museum-home-sidebar-r .items-list .c2.cak-active{background-color: #19c8a9;}
.Museum-home-sidebar-r .items-list .c2:hover{background-color: #19c8a9;}
.Museum-home-sidebar-r .items-list .c3.cak-active{background-color: #f15453;}
.Museum-home-sidebar-r .items-list .c3:hover{background-color: #f15453;}
.Museum-home-sidebar-r .items-list .c4.cak-active{background-color: #64c333;}
.Museum-home-sidebar-r .items-list .c4:hover{background-color: #64c333;}
.Museum-home-sidebar-r .items-list .c5.cak-active{background-color: #0aa6e8;}
.Museum-home-sidebar-r .items-list .c5:hover{background-color: #0aa6e8;}
.Museum-home-sidebar-r .items-list .c6.cak-active{background-color: #ea5f8d;}
.Museum-home-sidebar-r .items-list .c6:hover{background-color: #ea5f8d;}
.Museum-home-sidebar-r .items-list .c7.cak-active{background-color: #009944;}
.Museum-home-sidebar-r .items-list .c7:hover{background-color: #009944;}
.Museum-home-sidebar-r .items-list .c8.cak-active{background-color: #000000;}
.Museum-home-sidebar-r .items-list .c8:hover{background-color: #000000;}
.Museum-home-slider{width: 240px;height: 450px;background-color: #c81623;float: left;}
.Museum-home-slider-item h2{font-size: 16px; color: #fff; padding-top: 8px;font-weight: normal;}
.Museum-home-slider-item{width: 198px;background: url(<?php echo ATTR_DOMAIN;?>/zt/Museum-home/item.png) repeat-x top left;margin-left: 12px;margin-top:8px;}
.Museum-home-slider-item p{line-height: 16px;}
.Museum-home-slider-item p a{color: #fff;font-size: 12px;display: block;width: 30%;float: left;text-align: left;}
.Museum-home-slider-item p a:hover{text-decoration: underline;}
.Museum-home-slider-item1 h2{font-size: 16px; color: #fff; padding-top: 8px;font-weight: normal;}
.Museum-home-slider-item1{width: 198px;margin-left: 12px;margin-top:8px;}
.Museum-home-slider-item1 p{line-height: 16px;}
.Museum-home-slider-item1 p a{color: #fff;font-size: 12px;display: block;width: 30%;float: left;text-align: left;}
.Museum-home-slider-item1 p a:hover{text-decoration: underline;}
.Museum-home-hotshop h1{font-size: 22px;color: #000;font-weight: normal;margin-bottom: 5px;}
/*幻灯片CSS开始*/
.Museum-home-banner{width:950px;height:450px;position: relative;float: left;margin-left: 10px;}
.Museum-home-banner_main{width:950px;height:auto;position: absolute;left:0;top:0;}
.Museum-home-banner_main li a img{display:block;width:950px;height:450px;position: absolute;left:0;top:0;}
.Museum-home-banner_span{width:950px;height:35px;position: absolute;left:0;bottom:0;zoom:1;}
.Museum-home-banner_span span{width:15px;height:15px;display:block;float:left;margin-left:10px;cursor: pointer;background: url(<?php echo ATTR_DOMAIN;?>/zt/Museum-home/dot.png) no-repeat left bottom;}
.Museum-home-banner_span p{width:100px;height:35px;margin:0 auto;}
.Museum-home-banner_span .Museum-home-banner_span_one{background: url(<?php echo ATTR_DOMAIN;?>/zt/Museum-home/dot.png) no-repeat left top;}
.Museum-home-banner_left{width:60px;height:90px;cursor: pointer;background:#000 url(<?php echo ATTR_DOMAIN;?>/zt/Museum-home/ad_ctr.png) no-repeat 5px -180px;filter:alpha(opacity:50);opacity:0.5;position: absolute;left:0;top:155px;display:none;}
.Museum-home-banner_left1{background:#000 url(<?php echo ATTR_DOMAIN;?>/zt/Museum-home/ad_ctr.png) no-repeat 3px top;}
.Museum-home-banner_right{width:60px;height:90px;cursor: pointer;background:#000 url(<?php echo ATTR_DOMAIN;?>/zt/Museum-home/ad_ctr.png) no-repeat -5px bottom;filter:alpha(opacity:50);opacity:0.5;position: absolute;right:0;top:155px;display:none;}
.Museum-home-banner_right1{background:#000 url(<?php echo ATTR_DOMAIN;?>/zt/Museum-home/ad_ctr.png) no-repeat -3px -90px;}
/*幻灯片css结束*/
.Museum-home-hotshop{margin-top:42px;}
.cak-top{margin-top:10px;}
.Museum-home-hotshop-list1 li{width: 240px;height: 340px;float: left;border:1px solid #dcdcdc;box-sizing: border-box;border-left: none;padding-top: 12px;}
.Museum-home-hotshop-list1 li:first-child{border-left: 1px solid #dcdcdc;}
.hotshop-listshop-img a{display: block;text-align: center;}
.hopshop-listshop-name{display: block;width: 210px;font-size: 15px;margin:14px auto 0px;overflow: hidden;line-height: 26px;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;}
.hopshop-listshop-name a:hover{color: red;text-decoration: underline;}
.hopshop-listshop-sale{margin-left: 12px;margin-top: 12px;}
.hopshop-listshop-sale a{color: red;font-size: 14px;}
.hopshop-listshop-sale a span{font-size: 18px;font-weight: bold;}
/*推荐店铺*/
.Museum-home-recommend-store{margin-top: 42px;}
.Museum-home-recommend-store h1{font-size: 22px;color: #000;font-weight: normal;margin-bottom: 5px;}
.cak_top1{margin-top:1px;}
.Museum-home-recommend-store-list1 li{float: left;width: 240px;height: 214px;background-color: #fff; border-left: 1px solid #f5f5f5; box-sizing: border-box; position: relative;}
.Museum-home-recommend-store-list1 li:first-child{border-left: none;}
.Museum-home-recommend-store-list1 li span{display: block;width: 176px;height: 176px;border-radius: 100%;overflow: hidden;margin:19px auto 0;}
.recommend-store-cover{width: 240px;height: 214px;background-color: #000;opacity: 0.8;filter:alpha(opacity=80); /* IE */-moz-opacity:0.8; /* 老版Mozilla */-khtml-opacity:0.8; /* 老版Safari */position: absolute;top:0;left:0;z-index: 10;color: #fff;text-align: center;font-size: 16px;display: none;}
.recommend-store-cover p{margin-top: 78px;}
.recommend-store-cover a{color: #fff;display: block;background-color: red;width: 110px;height: 30px;line-height: 30px;margin:9px auto 0;border-radius: 14px;}
.Museum-home-recommend-store-list1 li:hover > .recommend-store-cover{display: block;}
/*lL*/
.Museum-home-shoplist1{margin-top: 42px;}
.Museum-home-shoplist1-top{height: 36px;line-height: 36px;width: 1200px;}
.Museum-home-shoplist1-slide-l{float: left;width: 600px;}
.Museum-home-shoplist1-slide-r{float: right;width: 600px;text-align: right;}
.Museum-home-shoplist1-slide-r a{margin:0 10px;color: #666;font-size: 14px;}
.Museum-home-shoplist1-slide-r a:hover{text-decoration: underline;}
.Museum-home-shoplist1-slide-l{font-size: 22px;font-weight: normal;}
.Museum-home-shoplist1-slide-l .cak_shopc1{text-decoration: underline;font-weight: normal;margin-right: 5px;}
.Museum-home-shoplist1-main{margin-top: 1px;}
.Museum-home-shoplist1-main-left{width: 200px;height: 480px;float: left;position: relative;background-color: #f5f5f5;border-left:1px solid #e5e5e5;box-sizing: border-box;border-top:1px solid #e5e5e5;border-bottom: 1px solid #e5e5e5;}
.Museum-home-shoplist1-main-left .shop-main-top{display: block;}
.Museum-home-shoplist1-main-left:hover > .shop-main-top img{opacity: .7; filter: alpha(opacity=70);}
.Museum-home-shoplist1-main-left:hover > .left-item{color: red;}
.Museum-home-shoplist1-main-left .left-item{position: absolute; bottom: 168px; height: 30px; width: 100%; display: block; text-align: center; line-height: 30px; font-size: 14px; background: #fff; filter: alpha(opacity=80); background: rgba(255,255,255,.8); overflow: hidden;}
.shop-main-left-bottm{}
.shop-main-left-bottm h2{font-size: 18px; color: #000; margin-top: 30px; margin-left: 9px;font-weight: normal;}
.shop-main-left-bottm p{line-height: 22px;width: 92%;display: block;height: 22px;margin:0 auto;}
.shop-main-left-bottm p a{display: block;float: left;width: 33%;text-align: left;}
.shop-main-left-bottm p a:hover{color:#f15453;text-decoration: underline;}
.Museum-home-shoplist1-main-mid{width: 400px;float: left;height: 480px;}
.Museum-home-shoplist1-main-mid a{display: block;height: 240px;box-sizing: border-box;border-top:1px solid #e5e5e5;border-left:1px solid #e5e5e5;border-right: 1px solid #e5e5e5;border-bottom: 1px solid #e5e5e5;position: relative;background: -webkit-radial-gradient(#fff, #ebebeb); /* Safari 5.1 - 6.0 */ background: -o-radial-gradient(#fff, #ebebeb); /* Opera 11.6 - 12.0 */ background: -moz-radial-gradient(#fff, #ebebeb); /* Firefox 3.6 - 15 */ background: radial-gradient(#fff, #ebebeb); /* 标准的语法（必须放在最后） */}
.Museum-home-shoplist1-main-mid .mid-first{border-bottom: none;}
.Museum-home-shoplist1-main-mid a .shop-list-name{position: absolute;top:25px;left: 25px;width: 174px; font-size: 18px; z-index: 10; line-height: 24px; height: 24px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;}
.Museum-home-shoplist1-main-mid a img{position: absolute;bottom: 0px;right: 0px;z-index: 1;}
.Museum-home-shoplist1-main-mid a img:hover{transform: translateX(-10px); -webkit-transform: translateX(-10px); -ms-transform:translateX(-10px);/* IE 9 */ -moz-transform:translateX(-10px);/* Firefox */ -o-transform:translateX(-10px);/* Opera */ -webkit-transition: all 0.3s; -ms-transition: all 0.3s; -moz-transition: all 0.3s; -o-transition: all 0.3s; transition: all 0.3s;}
.Museum-home-shoplist1-main-right{width: 600px;height: 480px;float: left;}
.Museum-home-shoplist1-main-right .shop-first-list li a{border-bottom: none;}
.Museum-home-shoplist1-main-right ul li{float: left;width: 200px;height: 240px;}
.Museum-home-shoplist1-main-right ul li a{display: block;width: 200px;height: 240px;border-right: 1px solid #e5e5e5;border-top: 1px solid #e5e5e5;border-bottom: 1px solid #e5e5e5;box-sizing: border-box;position: relative;background-color: #fff;}
.shop-list-name{position: absolute;top:25px;left: 25px;width: 174px; font-size: 18px; z-index: 10; line-height: 24px; height: 24px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; color: #000;}
.shop-list-name1{position: absolute; top: 54px; left: 25px; width: 174px; font-size: 14px; z-index: 10; line-height: 18px; height: 18px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; color: #000;}
.Museum-home-shoplist1-main-right ul li a img{position: absolute;bottom: 0;right:0;z-index: 1;}
.Museum-home-shoplist1-main-right ul li a img:hover{transform: translateX(-10px); -webkit-transform: translateX(-10px); -ms-transform:translateX(-10px);/* IE 9 */ -moz-transform:translateX(-10px);/* Firefox */ -o-transform:translateX(-10px);/* Opera */ -webkit-transition: all 0.3s; -ms-transition: all 0.3s; -moz-transition: all 0.3s; -o-transition: all 0.3s; transition: all 0.3s;}
.Museum-home-moreshop a{color: #7a7a7a;font-size: 18px;text-align: center;display: block;width: 486px;margin:65px auto;position: relative;}
.Museum-home-moreshop a:before{content: " ";display: block;width: 97px;height: 1px;background-color: #7a7a7a;position: absolute;top:15px;left: 0px;}
.Museum-home-moreshop a:after{content: " ";display: block;width: 97px;height: 1px;background-color: #7a7a7a;position: absolute;top:15px;right: 0;}

/*楼层字体颜色*/
.onered{color: #f15453;}
.twogreen{color: #64c333;}
.threeblue{color: #0aa6e8;}
.fourpink{color: #ea5f8d;}
.fivebblue{color: #009944;}
.sixyellow{color: #f19149;}


</style>

	<div class="zt-wrap">			
          <div class="Museum-home-wrap" id="content">
                <!-- 侧方导航 -->
                <div class="Museum-home-sidebar-r" id="Museum-home-slider-menu">
                     <div class="items-header"><a href="###">导航</a></div>
                     <div class="items-list">
                          <a href="#cak1" class="c1">热销<br>精品</a>
                          <a href="#cak2" class="c2">推荐<br>店铺</a>
                          <a href="#cak3" class="c3">lF<br>家纺</a>
                          <a href="#cak4" class="c4">2F<br>生活用品</a>
                          <a href="#cak5" class="c5">3F<br>厨具</a>
                          <a href="#cak6" class="c6">4F<br>灯具</a>
                          <a href="#cak7" class="c7">5F<br>家具</a>
                          <a href="#cak8" class="c8">6F<br>家装建材</a>
                     </div>
                     <div class="items-bottom"><a href="###" class="cak-gotop">返回<br>顶部</a></div>
                </div>
                <!-- 轮播导航 start -->
                <div class="Museum-home-header clearfix">
                    <div class="Museum-home-slider">
                          <div class="Museum-home-slider-item1 ">
                                 <h2>家纺</h2>
                                 <p class="clearfix">
	                                 <a href="http://www.g-emall.com/search/search.html?q=床品套件&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">床品套件</a>
	                                 <a href="http://www.g-emall.com/search/search.html?q=被子被芯&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">被子枕芯</a>
	                                 <a href="http://www.g-emall.com/search/search.html?q=枕头枕芯&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">枕头枕芯</a>
                                 </p>
                                 <p class="clearfix">
	                                 <a href="http://www.g-emall.com/category/671.html" target="_blank">毛巾浴巾</a>
	                                 <a href="http://www.g-emall.com/search/search.html?q=毯子&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">毯子</a>
	                                 <a href="http://www.g-emall.com/category/665.html" target="_blank">窗帘窗纱</a>
                                 </p>
                          </div>
                          <div class="Museum-home-slider-item">
                                 <h2>生活用品</h2>
                                 <p class="clearfix">
	                                 <a href="http://www.g-emall.com/category/712.html" target="_blank">收纳用品</a>
	                                 <a href="http://www.g-emall.com/category/708.html" target="_blank">纸品湿巾</a>
	                                 <a href="http://www.g-emall.com/category/714.html" target="_blank">雨伞雨具</a>
                                 </p>
                                 <p class="clearfix">
	                                 <a href="http://www.g-emall.com/category/715.html" target="_blank">浴室用品</a>
	                                 <a href="http://www.g-emall.com/category/713.html" target="_blank">洗晒用品</a>
	                                 <a href="http://www.g-emall.com/category/705.html" target="_blank">清洁工具</a>
                                 </p>
                          </div>
                          <div class="Museum-home-slider-item">
                                 <h2>厨具</h2>
                                 <p class="clearfix">
	                                 <a href="http://www.g-emall.com/category/1204.html" target="_blank">烹饪锅具</a>
	                                 <a href="http://www.g-emall.com/search/search.html?q=刀具&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">刀具</a>
	                                 <a href="http://www.g-emall.com/category/784.html" target="_blank">砧板</a>
                                 </p>
                                 <p class="clearfix">
	                                 <a href="http://www.g-emall.com/category/1202.html" target="_blank">水具酒具</a>
	                                 <a href="http://www.g-emall.com/category/1203.html" target="_blank">餐具厨具</a>
	                                 <a href="http://www.g-emall.com/category/833.html" target="_blank">茶具</a>
                                 </p>
                          </div>
                          <div class="Museum-home-slider-item">
                                 <h2>灯具</h2>
                                 <p class="clearfix">
	                                 <a href="http://www.g-emall.com/category/659.html" target="_blank">台灯</a>
	                                 <a href="http://www.g-emall.com/category/661.html" target="_blank">吸顶灯</a>
	                                 <a href="http://www.g-emall.com/category/655.html" target="_blank">吊灯</a>
                                 </p>
                                 <p class="clearfix">
	                                 <a href="http://www.g-emall.com/category/1078.html" target="_blank">简灯射灯</a>
	                                 <a href="http://www.g-emall.com/category/657.html" target="_blank">节能灯</a>
	                                 <a href="http://www.g-emall.com/category/658.html" target="_blank">落地灯</a>
                                 </p>
                          </div>
                          <div class="Museum-home-slider-item">
                                 <h2>家具</h2>
                                 <p class="clearfix">
	                                 <a href="http://www.g-emall.com/category/1085.html" target="_blank">沙发</a>
	                                 <a href="http://www.g-emall.com/category/676.html" target="_blank">边桌茶几</a>
	                                 <a href="http://www.g-emall.com/category/1081.html" target="_blank">餐桌餐椅</a>
                                 </p>
                                 <p class="clearfix">
	                                 <a href="http://www.g-emall.com/category/825.html" target="_blank">床具</a>
	                                 <a href="http://www.g-emall.com/category/678.html" target="_blank">电脑桌椅</a>
	                                 <a href="http://www.g-emall.com/category/685.html" target="_blank">休闲椅</a>
                                 </p>
                          </div>
                          <div class="Museum-home-slider-item">
                                 <h2>家装建材</h2>
                                 <p class="clearfix">
	                                 <a href="http://www.g-emall.com/category/687.html" target="_blank">厨卫</a>
	                                 <a href="http://www.g-emall.com/category/688.html" target="_blank">橱柜</a>
	                                 <a href="http://www.g-emall.com/category/689.html" target="_blank">瓷砖</a>
                                 </p>
                                 <p class="clearfix">
	                                 <a href="http://www.g-emall.com/category/690.html" target="_blank">地板</a>
	                                 <a href="http://www.g-emall.com/category/699.html" target="_blank">油漆壁纸</a>
	                                 <a href="http://www.g-emall.com/category/700.html" target="_blank">园艺</a>
                                 </p>
                          </div>

                    </div>
                         <div class="Museum-home-banner">
					        <div class="Museum-home-banner_main">
					            <ul class="Museum-home-banner_ul">
					                <li><a href="###" class="img" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/lunbo-01.jpg"  alt="" /></a></li>
					                <!-- <li><a href="###" class="img" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/ad_nba.jpg"    alt="" /></a></li>
					                <li><a href="###" class="img" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/ad_stock.jpg"  alt="" /></a></li>
					                <li><a href="###" class="img" target="_blank"><img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/ad_auto.jpg"   alt="" /></a></li> -->
					            </ul>
					        </div>
					        <div class="Museum-home-banner_span">
					            <p> 
					                <!-- <span class="Museum-home-banner_span_one"></span> 
					                <span></span> 
					                <span></span>
					                <span></span> -->
					            </p> 
					        </div>
					    </div>
                </div>
                <!-- 轮播导航 end -->
                <!-- 热销商品start -->
                <div class="Museum-home-hotshop cak-item" id="cak1">
                     <h1>热销精品</h1>
                     <ul class="Museum-home-hotshop-list1 clearfix">
                         <li>
                             <div class="hotshop-listshop-img">
                                  <a href="http://www.g-emall.com/JF/1679218.html" title="贸达家纺" target="_blank">
                                    <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/hotshop-list-01.jpg"  alt="" />
                                  </a>
                             </div>
                             <p class="hopshop-listshop-name">
                                 <a href="http://www.g-emall.com/JF/1679218.html" target="_blank">【皇居喜品】埃及长绒棉贡缎活性印花四件套-7</a>
                             </p>
                             <p class="hopshop-listshop-sale">
                                <a href="http://www.g-emall.com/JF/1679218.html" target="_blank">惊喜价:<span>￥518</span></a>
                             </p>
                         </li>
                         <li>
                            <div class="hotshop-listshop-img">
                                  <a href="http://www.g-emall.com/JF/18948.html" title="宅享家居用品" target="_blank">
                                   <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/hotshop-list-02.jpg" alt="" />
                                  </a>
                            </div>
                             <p class="hopshop-listshop-name">
                                <a href="http://www.g-emall.com/JF/18948.html" target="_blank">【罗莱雅】全棉四件套/纯棉精梳棉环保印染四件套--花</a>
                             </p>
                             <p class="hopshop-listshop-sale">
                                 <a href="http://www.g-emall.com/JF/18948.html" target="_blank">惊喜价:<span>￥190</span></a>
                             </p>
                         </li>
                         <li>
                            <div class="hotshop-listshop-img">
                                  <a href="http://www.g-emall.com/JF/459583.html" title="家居生活用品店" target="_blank">
                                     <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/hotshop-list-03.jpg" alt="" />
                                  </a>
                            </div>
                             <p class="hopshop-listshop-name">
                               <a href="http://www.g-emall.com/JF/459583.html" target="_blank">纯棉床品四件套床单被套全棉床上套件1.5m/1.8m床</a>
                             </p>
                             <p class="hopshop-listshop-sale">
                                <a href="http://www.g-emall.com/JF/459583.html" target="_blank">惊喜价:<span>￥259</span></a>
                             </p>
                         </li>
                         <li>
                            <div class="hotshop-listshop-img">
                                  <a href="http://www.g-emall.com/JF/88653.html" title="上海彼天家纺有限公司" target="_blank">
                                      <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/hotshop-list-04.jpg" alt="" />
                                  </a>
                            </div>
                             <p class="hopshop-listshop-name">
                                 <a href="http://www.g-emall.com/JF/88653.html" target="_blank">【彼天家纺】2016秋冬新品全棉四件套斜纹纯棉</a>
                             </p>
                             <p class="hopshop-listshop-sale">
                                <a href="http://www.g-emall.com/JF/88653.html" target="_blank">惊喜价:<span>￥229</span></a>
                             </p>
                         </li>
                         <li>
                            <div class="hotshop-listshop-img">
                                  <a href="http://www.g-emall.com/JF/215796.html" title="贸达家纺" target="_blank">
                                      <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/hotshop-list-05.jpg" alt="" />
                                  </a>
                            </div>
                             <p class="hopshop-listshop-name">
                                   <a href="http://www.g-emall.com/JF/215796.html" target="_blank">【皇居喜品】天丝磨毛四件套欧式磨毛天丝包邮</a>
                             </p>
                             <p class="hopshop-listshop-sale">
                                   <a href="http://www.g-emall.com/JF/215796.html" target="_blank">惊喜价:<span>￥388</span></a>
                             </p>
                         </li>
                     </ul>
                     <ul class="Museum-home-hotshop-list1 cak-top clearfix">
                         <li>
                             <div class="hotshop-listshop-img">
                                  <a href="http://www.g-emall.com/JF/1063448.html" title="业彩电子电器" target="_blank">
                                        <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/hotshop-list-06.jpg" alt="" />
                                  </a>
                             </div>
                             <p class="hopshop-listshop-name">
                             <a href="http://www.g-emall.com/JF/1063448.html" target="_blank">博客(Bocca)台灯LED台灯 护眼台灯阅读灯五档光源</a>
                             </p>
                             <p class="hopshop-listshop-sale">
                                 <a href="http://www.g-emall.com/JF/1063448.html" target="_blank">惊喜价:<span>￥168</span></a>
                             </p>
                         </li>
                         <li>
                            <div class="hotshop-listshop-img">
                                  <a href="http://www.g-emall.com/JF/352408.html" title="慕馨家居" target="_blank">
                                     <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/hotshop-list-07.jpg" alt="" />
                                  </a>
                            </div>
                             <p class="hopshop-listshop-name">
                                 <a href="http://www.g-emall.com/JF/352408.html" target="_blank">牛津布收纳箱大号衣服整理箱钢架储物箱被子收纳盒66升</a>
                             </p>
                             <p class="hopshop-listshop-sale">
                                 <a href="http://www.g-emall.com/JF/352408.html" target="_blank">惊喜价:<span>￥38</span></a>
                             </p>
                         </li>
                         <li>
                            <div class="hotshop-listshop-img">
                                  <a href="http://www.g-emall.com/JF/205859.html" title="家居生活用品店" target="_blank">
                                   <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/hotshop-list-08.jpg" alt="" />
                                  </a>
                            </div>
                             <p class="hopshop-listshop-name">
                                  <a href="http://www.g-emall.com/JF/205859.html" target="_blank">韩国可爱公主风抽屉式化妆品收纳盒大号创意桌面收纳盒包邮</a>
                             </p>
                             <p class="hopshop-listshop-sale">
                                  <a href="http://www.g-emall.com/JF/205859.html" target="_blank">惊喜价:<span>￥59</span></a>
                             </p>
                         </li>
                         <li>
                            <div class="hotshop-listshop-img">
                                  <a href="http://www.g-emall.com/JF/250785.html" title="宝媒家居" target="_blank">
                                     <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/hotshop-list-09.jpg" alt="" />
                                  </a>
                            </div>
                             <p class="hopshop-listshop-name">
                                 <a href="http://www.g-emall.com/JF/250785.html" target="_blank">【寝圣】天然乳胶席梦思床垫5CM整块乳胶袋装弹簧</a>
                             </p>
                             <p class="hopshop-listshop-sale">
                                 <a href="http://www.g-emall.com/JF/250785.html" target="_blank">惊喜价:<span>￥4280</span></a>
                             </p>
                         </li>
                         <li>
						   <div class="hotshop-listshop-img">
						     <a href="http://www.g-emall.com/JF/268851.html" title="智尚家具" target="_blank">
						       <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/hotshop-list-10.jpg" alt="" />
						     </a>
						   </div>
						   <p class="hopshop-listshop-name">
						       <a href="http://www.g-emall.com/JF/268851.html" target="_blank">智尚家具 定制实木餐椅咖啡厅酒店高扶手靠背木椅子 EY13</a>
						   </p>
						   <p class="hopshop-listshop-sale">
						       <a href="http://www.g-emall.com/JF/268851.html" target="_blank">惊喜价:<span>￥288</span></a>
						   </p>
						</li>
                     </ul>

                </div>
                <!-- 热销商品end -->
                <!-- 推荐店铺start -->
                <div class="Museum-home-recommend-store cak-item" id="cak2">
                      <h1>推荐店铺</h1>
                      <ul class="Museum-home-recommend-store-list1 clearfix">
                         <li>
                            <span><img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/recommend-store-list02.jpg" alt="" /></span>
                            <div class="recommend-store-cover">
                                   <p>拓量家居</p>
                                   <a href="http://www.g-emall.com/shop/1459.html" target="_blank">点击进入</a>
                            </div>
                          </li>
                          <li>
                            <span><img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/recommend-store-list01.jpg" alt="" /></span>
                            <div class="recommend-store-cover">
                                   <p>贸达家纺</p>
                                   <a href="http://www.g-emall.com/shop/3327.html" target="_blank">点击进入</a>
                            </div>
                          </li> 
                          <li>
                            <span><img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/recommend-store-list03.jpg" alt="" /></span>
                            <div class="recommend-store-cover">
                                   <p>宅享家居网</p>
                                   <a href="http://www.g-emall.com/shop/23.html" target="_blank">点击进入</a>
                            </div>
                          </li>
                          <li>
                            <span><img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/recommend-store-list04.jpg" alt="" /></span>
                            <div class="recommend-store-cover">
                                   <p>老掌柜家居</p>
                                   <a href="http://www.g-emall.com/shop/8635.html" target="_blank">点击进入</a>
                            </div>
                          </li>
                          <li>
                            <span><img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/recommend-store-list05.jpg" alt="" /></span>
                            <div class="recommend-store-cover">
                                   <p>爱唯美家纺</p>
                                   <a href="http://www.g-emall.com/shop/5608.html" target="_blank">点击进入</a>
                            </div>
                          </li>
                      </ul>
                       <ul class="Museum-home-recommend-store-list1 cak_top1 clearfix">
                         <li>
                            <span><img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/recommend-store-list06.jpg" alt="" /></span>
                            <div class="recommend-store-cover">
                                   <p>特百惠家居用品店</p>
                                   <a href="http://www.g-emall.com/shop/10138.html" target="_blank">点击进入</a>
                            </div>
                          </li>
                          <li>
                            <span><img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/recommend-store-list07.jpg" alt="" /></span>
                            <div class="recommend-store-cover">
                                   <p>宝媒家居</p>
                                   <a href="http://www.g-emall.com/shop/4380.html" target="_blank">点击进入</a>
                            </div>
                          </li>
                          <li>
                            <span><img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/recommend-store-list08.jpg" alt="" /></span>
                            <div class="recommend-store-cover">
                                   <p>慕馨家居</p>
                                   <a href="http://www.g-emall.com/shop/4676.html" target="_blank">点击进入</a>
                            </div>
                          </li>
                          <li>
                            <span><img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/recommend-store-list09.jpg" alt="" /></span>
                            <div class="recommend-store-cover">
                                   <p>韩品汇-家居家装</p>
                                   <a href="http://www.g-emall.com/shop/3549.html" target="_blank">点击进入</a>
                            </div>
                          </li>
                          <li>
                            <span><img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/recommend-store-list10.jpg" alt="" /></span>
                            <div class="recommend-store-cover">
                                   <p>安居家具店</p>
                                   <a href="http://www.g-emall.com/shop/6634.html" target="_blank">点击进入</a>
                            </div>
                          </li>
                      </ul>
                </div>
                <!-- 推荐店铺end -->
                <!-- 商品lLstart -->
                <div class="Museum-home-shoplist1 cak-item" id="cak3">
                     <div class="Museum-home-shoplist1-top clearfix">
	                     <h1 class="Museum-home-shoplist1-slide-l"><span class="cak_shopc1 onered">1F</span>家纺</h1>
	                     <div class="Museum-home-shoplist1-slide-r">
	                         <a href="http://www.g-emall.com/search/search.html?q=四件套&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">四件套</a>
	                         <a href="http://www.g-emall.com/search/search.html?q=被芯&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">被子</a>
	                         <a href="http://www.g-emall.com/search/search.html?q=毛毯&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">毛毯</a>
	                         <a href="http://www.g-emall.com/category/1125.html" target="_blank">枕头</a>
	                         <a href="http://www.g-emall.com/search/search.html?q=蚕丝被&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">蚕丝被</a>
	                     </div>
                     </div>
                </div>
                <div class="Museum-home-shoplist1-main clearfix">
                           <div class="Museum-home-shoplist1-main-left">
                               <a href="http://www.g-emall.com/JF/1974052.html" class="shop-main-top"  target="_blank">
                                    <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list-01.jpg" alt="" />
                               </a>
                               <span class="left-item">纯棉夏凉被199元&nbsp;></span>
                               <div class="shop-main-left-bottm">
                                    <h2>特别推荐</h2>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=床品套件&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">床品套件</a>
	                                    <a href="http://www.g-emall.com/category/1079.html" target="_blank">抱枕靠垫</a>
	                                    <a href="http://www.g-emall.com/category/674.html" target="_blank">枕芯枕套</a>
                                    </p>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=博洋家纺&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">博洋家纺</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=罗莱家纺&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">罗莱家纺</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=水星家纺&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">水星家纺</a>
                                    </p>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=富安娜&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">富安娜</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=多喜爱&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">多喜爱</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=金号毛巾&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">金号毛巾</a>
                                    </p>
                               </div>
                           </div>
                           <div class="Museum-home-shoplist1-main-mid">
                               <a href="http://www.g-emall.com/JF/198724.html" class="mid-first"  target="_blank">
                                     <div class="shop-list-name onered">爱上自由呼吸</div>
                                     <div class="shop-list-name1">皇家花园四件套</div>
                                     <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list-02.png" alt="" />     
                               </a>
                               <a href="http://www.g-emall.com/JF/121026.html"  target="_blank">
                                     <div class="shop-list-name onered">韩式田园生活</div>
                                     <div class="shop-list-name1">绿薄格亚麻凉席</div>
                                     <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list-03.png" alt="" />     
                               </a>
                           </div>
                           <div class="Museum-home-shoplist1-main-right">
                               <ul class="shop-first-list clearfix">
                                    <li>
                                        <a href="http://www.g-emall.com/JF/369086.html"  target="_blank">
                                              <div class="shop-list-name">纯棉磨毛四件套</div>
                                              <div class="shop-list-name1 onered">圣诞麋鹿厚磨毛包邮</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list-04.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/1716277.html"  target="_blank">
                                              <div class="shop-list-name">活性印花四件套</div>
                                              <div class="shop-list-name1 onered">60支埃及长绒棉</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list-05.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/2533707.html"  target="_blank">
                                              <div class="shop-list-name">无印色织秋冬被</div>
                                              <div class="shop-list-name1 onered">自然会呼吸的面料</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list-06.jpg" alt="" />
                                        </a>
                                    </li>
                               </ul>
                               <ul class="clearfix">
                                    <li>
                                        <a href="http://www.g-emall.com/JF/256588.html"  target="_blank">
                                              <div class="shop-list-name">北极绒家纺四件套</div>
                                              <div class="shop-list-name1 onered">优质精梳棉面料</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list-07.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/777245.html"  target="_blank">
                                              <div class="shop-list-name">舒适亲肤毛巾</div>
                                              <div class="shop-list-name1 onered">天然柔软精梳纯棉</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list-08.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/288450.html"  target="_blank">
                                              <div class="shop-list-name">原生棉生态纺</div>
                                              <div class="shop-list-name1 onered">32支提花加绣花</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list-09.jpg" alt="" />
                                        </a>
                                    </li>
                               </ul>
                           </div>
                     </div>
                <!-- 1L商品lend -->
                <!-- 商品2Lstart -->
                <div class="Museum-home-shoplist1 cak-item" id="cak4">
                     <div class="Museum-home-shoplist1-top clearfix">
	                     <h1 class="Museum-home-shoplist1-slide-l"><span class="cak_shopc1 twogreen">2F</span>生活日用</h1>
	                     <div class="Museum-home-shoplist1-slide-r">
	                         <a href="http://www.g-emall.com/search/search.html?q=雨伞&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">雨伞</a>
	                         <a href="http://www.g-emall.com/search/search.html?q=收纳用品&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">收纳用品</a>
	                         <a href="http://www.g-emall.com/search/search.html?q=地毯&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">地毯</a>
	                         <a href="http://www.g-emall.com/search/search.html?q=浴室用品&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">浴室用品</a>
	                         <a href="http://www.g-emall.com/category/709.html" target="_blank">缝纫用品</a>
	                     </div>
                     </div>
                </div>
                <div class="Museum-home-shoplist1-main clearfix">
                           <div class="Museum-home-shoplist1-main-left">
                               <a href="http://www.g-emall.com/JF/1210687.html" class="shop-main-top" target="_blank">
                                    <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list2-01.jpg" alt="" />
                               </a>
                               <span class="left-item">防潮防虫米桶199元&nbsp;></span>
                               <div class="shop-main-left-bottm">
                                    <h2>特别推荐</h2>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=纸巾&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">纸巾</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=竹炭包&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">竹炭包</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=甲醛清除剂&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">甲醛清除剂</a>
                                    </p>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=遮阳伞" target="_blank">遮阳伞</a>
	                                    <a href="http://www.g-emall.com/category/713.html" target="_blank">洗晒用品</a>
	                                    <a href="http://www.g-emall.com/category/705.html" target="_blank">清洁工具</a>
                                    </p>
                                    <p>
	                                    <a href="http://www.g-emall.com/category/704.html" target="_blank">皮具护理</a>
	                                    <a href="http://www.g-emall.com/category/706.html" target="_blank">驱虫用品</a>
	                                    <a href="http://www.g-emall.com/category/782.html" target="_blank">隔热垫</a>
                                    </p>
                               </div>
                           </div>
                           <div class="Museum-home-shoplist1-main-mid">
                               <a href="http://www.g-emall.com/JF/174451.html" class="mid-first"  target="_blank">
                                     <div class="shop-list-name  twogreen">轻松收纳</div>
                                     <div class="shop-list-name1">台湾进口双层收纳篮</div>
                                     <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list2-02.png" alt="" />     
                               </a>
                               <a href="http://www.g-emall.com/JF/317593.html" target="_blank">
                                     <div class="shop-list-name twogreen">轻松分类</div>
                                     <div class="shop-list-name1">大号小号玻璃密封罐</div>
                                     <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list2-03.png" alt="" />     
                               </a>
                           </div>
                           <div class="Museum-home-shoplist1-main-right">
                               <ul class="shop-first-list clearfix">
                                    <li>
                                        <a href="http://www.g-emall.com/JF/71774.html"  target="_blank">
                                              <div class="shop-list-name">慢悠品厨房用品</div>
                                              <div class="shop-list-name1 twogreen">可伸缩沥水篮</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list2-04.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/365560.html"  target="_blank">
                                              <div class="shop-list-name">日式厨房用品</div>
                                              <div class="shop-list-name1 twogreen">带滑轮储物箱收纳架</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list2-05.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/538147.html"  target="_blank">
                                              <div class="shop-list-name">特大号塑料收纳箱</div>
                                              <div class="shop-list-name1 twogreen">好塑料做好箱</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list2-06.jpg" alt="" />
                                        </a>
                                    </li>
                               </ul>
                               <ul class="clearfix">
                                    <li>
                                        <a href="http://www.g-emall.com/JF/110779.html"  target="_blank">
                                              <div class="shop-list-name">超轻户外防晒折叠伞</div>
                                              <div class="shop-list-name1 twogreen">黑胶波点多色可选</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list2-07.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/142788.html"  target="_blank">
                                              <div class="shop-list-name">冰箱去味活性炭</div>
                                              <div class="shop-list-name1 twogreen">360度高效吸附异味</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list2-08.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/2461222.html" target="_blank">
                                              <div class="shop-list-name">塑料藤编收纳筐</div>
                                              <div class="shop-list-name1 twogreen">田园风3色可选</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list2-09.jpg" alt="" />
                                        </a>
                                    </li>
                               </ul>
                           </div>
                     </div>
                <!-- 2L商品lend -->
                <!-- 商品3Lstart -->
                <div class="Museum-home-shoplist1 cak-item" id="cak5">
                     <div class="Museum-home-shoplist1-top clearfix">
	                     <h1 class="Museum-home-shoplist1-slide-l"><span class="cak_shopc1 threeblue">3F</span>厨具</h1>
	                     <div class="Museum-home-shoplist1-slide-r">
	                         <a href="http://www.g-emall.com/search/search.html?q=刀具" target="_blank">刀具</a>
	                         <a href="http://www.g-emall.com/category/784.html" target="_blank">砧板</a>
	                         <a href="http://www.g-emall.com/category/1204.html" target="_blank">烹饪锅具</a>
	                         <a href="http://www.g-emall.com/search/search.html?q=炒锅&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">炒锅</a>
	                         <a href="http://www.g-emall.com/search/search.html?q=餐具&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">餐具</a>
	                     </div>
                     </div>
                </div>
                <div class="Museum-home-shoplist1-main clearfix">
                           <div class="Museum-home-shoplist1-main-left">
                               <a href="http://www.g-emall.com/JF/28613.html" class="shop-main-top"  target="_blank">
                                    <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list3-01.jpg" alt="" />
                               </a>
                               <span class="left-item">不锈钢锅3件套432元&nbsp;></span>
                               <div class="shop-main-left-bottm">
                                    <h2>特别推荐</h2>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=煎锅&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">煎锅</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=水壶&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">水壶</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=野餐炊具&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">野餐炊具</a>
                                    </p>
                                    <p>
	                                    <a href="http://www.g-emall.com/category/832.html" target="_blank">保温杯</a>
	                                    <a href="http://www.g-emall.com/category/835.html" target="_blank">玻璃杯</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=酒具&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">酒具</a>
                                    </p>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=爱仕达&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">爱仕达</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=双立人&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">双立人</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=苏泊尔&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">苏泊尔</a>
                                    </p>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=张小泉&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">张小泉</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=十八子&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">十八子</a>
                                    </p>
                               </div>
                           </div>
                           <div class="Museum-home-shoplist1-main-mid">
                               <a href="http://www.g-emall.com/JF/93682.html" class="mid-first"  target="_blank">
                                     <div class="shop-list-name threeblue">从此不再担心油温</div>
                                     <div class="shop-list-name1">苏泊尔无油烟不粘锅</div>
                                     <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list3-02.png" alt="" />     
                               </a>
                               <a href="http://www.g-emall.com/JF/209039.html"  target="_blank">
                                     <div class="shop-list-name threeblue">为高端吃货打造</div>
                                     <div class="shop-list-name1">抗菌切菜切肉砧板</div>
                                     <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list3-03.png" alt="" />     
                               </a>
                           </div>
                           <div class="Museum-home-shoplist1-main-right">
                               <ul class="shop-first-list clearfix">
                                    <li>
                                        <a href="http://www.g-emall.com/JF/2283783.html"  target="_blank">
                                              <div class="shop-list-name">不锈钢保温杯</div>
                                              <div class="shop-list-name1 threeblue">可刻字便携情侣</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list3-04.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/263530.html"  target="_blank">
                                              <div class="shop-list-name">不锈钢蒸锅</div>
                                              <div class="shop-list-name1 threeblue">加厚三层大汤锅</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list3-05.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/302236.html"  target="_blank">
                                              <div class="shop-list-name">微波炉架置物架</div>
                                              <div class="shop-list-name1 threeblue">空间智慧利用2层架子</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list3-06.jpg" alt="" />
                                        </a>
                                    </li>
                               </ul>
                               <ul class="clearfix">
                                    <li>
                                        <a href="http://www.g-emall.com/JF/301765.html"  target="_blank">
                                              <div class="shop-list-name">苏泊尔大汤煲</div>
                                              <div class="shop-list-name1 threeblue">耐高温陶瓷石锅</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list3-07.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/146030.html"  target="_blank">
                                              <div class="shop-list-name">好锅配好铲</div>
                                              <div class="shop-list-name1 threeblue">不锈钢铲勺漏锅铲</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list3-08.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/126998.html"  target="_blank">
                                              <div class="shop-list-name">德国进口刀具套装</div>
                                              <div class="shop-list-name1 threeblue">不锈钢套刀菜刀菜板组合</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list3-09.jpg" alt="" />
                                        </a>
                                    </li>
                               </ul>
                           </div>
                     </div>
                <!-- 3L商品lend -->
                <!-- 商品4Lstart -->
                <div class="Museum-home-shoplist1 cak-item" id="cak6">
                     <div class="Museum-home-shoplist1-top clearfix">
	                     <h1 class="Museum-home-shoplist1-slide-l"><span class="cak_shopc1 fourpink">4F</span>灯具</h1>
	                     <div class="Museum-home-shoplist1-slide-r">
	                         <a href="http://www.g-emall.com/category/659.html" target="_blank">台灯</a>
	                         <a href="http://www.g-emall.com/search/search.html?q=落地灯&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">落地灯</a>
	                         <a href="http://www.g-emall.com/category/661.html" target="_blank">吸顶灯</a>
	                         <a href="http://www.g-emall.com/category/655.html" target="_blank">吊灯</a>
	                         <a href="http://www.g-emall.com/category/1078.html" target="_blank">简灯</a>
	                         <a href="http://www.g-emall.com/category/1078.html" target="_blank">射灯</a>
	                     </div>
                     </div>
                </div>
                <div class="Museum-home-shoplist1-main clearfix">
                           <div class="Museum-home-shoplist1-main-left">
                               <a href="http://www.g-emall.com/JF/447836.html" class="shop-main-top" target="_blank">
                                    <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list4-01.jpg" alt="" />
                               </a>
                               <span class="left-item">led射灯43元&nbsp;></span>
                               <div class="shop-main-left-bottm">
                                    <h2>特别推荐</h2>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=护眼灯" target="_blank">护眼灯</a>
	                                    <a href="http://www.g-emall.com/category/654.html" target="_blank">LED灯</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=节能灯" target="_blank">节能灯</a>
                                    </p>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=应急灯&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">应急灯</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=手电&bid=-1&cid=0&min=0&max=0&f=name&order=0" target="_blank">手电</a>
                                    </p>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=飞利浦灯" target="_blank">飞利浦灯</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=欧普照明" target="_blank">欧普照明</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=雷士照明" target="_blank">雷士照明</a>
                                    </p>
                               </div>
                           </div>
                           <div class="Museum-home-shoplist1-main-mid">
                               <a href="http://www.g-emall.com/JF/1038205.html" class="mid-first" target="_blank">
                                     <div class="shop-list-name fourpink">节能护眼新升级</div>
                                     <div class="shop-list-name1">松下照明吸顶灯20/23W</div>
                                     <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list4-02.png" alt="" />     
                               </a>
                               <a href="http://www.g-emall.com/JF/212121.html" target="_blank">
                                     <div class="shop-list-name fourpink">学习阅读好帮手</div>
                                     <div class="shop-list-name1">led护眼台灯USB充电</div>
                                     <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list4-03.png" alt="" />     
                               </a>
                           </div>
                           <div class="Museum-home-shoplist1-main-right" >
                               <ul class="shop-first-list clearfix">
                                    <li>
                                        <a href="http://www.g-emall.com/JF/364509.html" target="_blank">
                                              <div class="shop-list-name">LED吸顶灯</div>
                                              <div class="shop-list-name1 fourpink">现代简约圆形吊灯</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list4-04.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/309197.html" target="_blank">
                                              <div class="shop-list-name">飞利浦led台灯</div>
                                              <div class="shop-list-name1 fourpink">儿童护眼台灯触摸灯</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list4-05.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/448056.html" target="_blank">
                                              <div class="shop-list-name">24wled吸顶灯</div>
                                              <div class="shop-list-name1 fourpink">现代简约中欧式温馨</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list4-06.jpg" alt="" />
                                        </a>
                                    </li>
                               </ul>
                               <ul class="clearfix">
                                    <li>
                                        <a href="http://www.g-emall.com/JF/226257.html" target="_blank">
                                              <div class="shop-list-name">护眼台灯</div>
                                              <div class="shop-list-name1 fourpink">天鹅LED学习阅读台灯</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list4-07.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/421636.html" target="_blank">
                                              <div class="shop-list-name">家用照明灯泡</div>
                                              <div class="shop-list-name1 fourpink">2W室内节能灯</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list4-08.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/1913023.html" target="_blank">
                                              <div class="shop-list-name">田园阳台灯</div>
                                              <div class="shop-list-name1 fourpink">原木创意卧室床头灯</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list4-09.jpg" alt="" />
                                        </a>
                                    </li>
                               </ul>
                           </div>
                     </div>
                <!-- 4L商品lend -->
                <!-- 商品5Lstart -->
                <div class="Museum-home-shoplist1 cak-item" id="cak7">
                     <div class="Museum-home-shoplist1-top clearfix">
	                     <h1 class="Museum-home-shoplist1-slide-l"><span class="cak_shopc1 fivebblue">5F</span>家具</h1>
	                     <div class="Museum-home-shoplist1-slide-r">
	                         <a href="http://www.g-emall.com/search/search.html?q=欧式家具" target="_blank">欧式家具</a>
	                         <a href="http://www.g-emall.com/search/search.html?q=中式家具" target="_blank">中式家具</a>
	                         <a href="http://www.g-emall.com/search/search.html?q=林氏木业" target="_blank">林氏木业</a>
	                         <a href="http://www.g-emall.com/search/search.html?q=全友家居" target="_blank">全友家居</a>
	                     </div>
                     </div>
                </div>
                <div class="Museum-home-shoplist1-main clearfix">
                           <div class="Museum-home-shoplist1-main-left">
                               <a href="http://www.g-emall.com/JF/276865.html" class="shop-main-top" target="_blank">
                                    <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list5-01.jpg" alt="" />
                               </a>
                               <span class="left-item">简约现代电脑桌297元&nbsp;></span>
                               <div class="shop-main-left-bottm">
                                    <h2>特别推荐</h2>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=沙发床" target="_blank">沙发床</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=儿童家具" target="_blank">儿童家具</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=边桌茶几" target="_blank">边桌/茶几</a>
                                    </p>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=储物柜" target="_blank">储物柜</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=电脑桌" target="_blank">电脑桌</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=书架" target="_blank">书架/层架</a>
                                    </p>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=休闲椅" target="_blank">休闲椅</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=鞋架" target="_blank">鞋架/鞋柜</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=衣橱" target="_blank">衣橱衣柜</a>
                                    </p>
                               </div>
                            </div>
                           <div class="Museum-home-shoplist1-main-mid">
                               <a href="http://www.g-emall.com/JF/268272.html" class="mid-first" target="_blank">
                                     <div class="shop-list-name fivebblue">享受生活从椅子开始</div>
                                     <div class="shop-list-name1">颜色可定制</div>
                                     <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list5-02.png" alt="" />     
                               </a>
                               <a href="http://www.g-emall.com/JF/57198.html" target="_blank">
                                     <div class="shop-list-name fivebblue">头层牛皮 舒适体验</div>
                                     <div class="shop-list-name1">带按摩功能的老板椅</div>
                                     <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list5-03.png" alt="" />     
                               </a>
                           </div>
                           <div class="Museum-home-shoplist1-main-right">
                               <ul class="shop-first-list clearfix">
                                    <li>
                                        <a href="http://www.g-emall.com/JF/1434900.html" target="_blank">
                                              <div class="shop-list-name">享受一抹阳光</div>
                                              <div class="shop-list-name1 fivebblue">铁艺户外桌椅组合</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list5-04.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/789551.html" target="_blank">
                                              <div class="shop-list-name">古典欧式真皮</div>
                                              <div class="shop-list-name1 fivebblue">1.8米双人实木床</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list5-05.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/197420.html" target="_blank">
                                              <div class="shop-list-name">全新睡眠体验</div>
                                              <div class="shop-list-name1 fivebblue">创意休闲懒人折叠椅</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list5-06.jpg" alt="" />
                                        </a>
                                    </li>
                               </ul>
                               <ul class="clearfix">
                                    <li>
                                        <a href="http://www.g-emall.com/JF/529830.html" target="_blank">
                                              <div class="shop-list-name">日式沙发床</div>
                                              <div class="shop-list-name1 fivebblue">多效能储物折叠沙发</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list5-07.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/126392.html" target="_blank">
                                              <div class="shop-list-name">正品楠竹换鞋凳</div>
                                              <div class="shop-list-name1 fivebblue">质保5年保障</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list5-08.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/376149.html" target="_blank">
                                              <div class="shop-list-name">内有乾坤大不同</div>
                                              <div class="shop-list-name1 fivebblue">简易组合连体书桌</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list5-09.jpg" alt="" />
                                        </a>
                                    </li>
                               </ul>
                           </div>
                     </div>
                <!-- 5L商品lend -->
                <!-- 商品6Lstart -->
                <div class="Museum-home-shoplist1 cak-item" id="cak8">
                     <div class="Museum-home-shoplist1-top clearfix">
	                     <h1 class="Museum-home-shoplist1-slide-l"><span class="cak_shopc1 sixyellow">6F</span>家装建材</h1>
	                     <div class="Museum-home-shoplist1-slide-r">
	                         <a href="http://www.g-emall.com/category/687.html" target="_blank">厨卫</a>
	                         <a href="http://www.g-emall.com/category/689.html" target="_blank">瓷砖</a>
	                         <a href="http://www.g-emall.com/category/690.html" target="_blank">地板</a>
	                         <a href="http://www.g-emall.com/category/699.html" target="_blank">油漆壁纸</a>
	                     </div>
                     </div>
                </div>
                <div class="Museum-home-shoplist1-main clearfix">
                           <div class="Museum-home-shoplist1-main-left">
                               <a href="http://www.g-emall.com/JF/2636072.html" class="shop-main-top" target="_blank">
                                    <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list6-01.jpg" alt="" />
                               </a>
                               <span class="left-item">超值厨卫套装1990元&nbsp;></span>
                               <div class="shop-main-left-bottm">
                                    <h2>特别推荐</h2>
                                    <p>
	                                    <a href="http://www.g-emall.com/category/688.html" target="_blank">橱柜</a>
	                                    <a href="http://www.g-emall.com/category/698.html" target="_blank">移门壁柜</a>
	                                    <a href="http://www.g-emall.com/category/691.html" target="_blank">电工用料</a>
                                    </p>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=五金工具&bid=-1&cid=0&min=0&max=0&f=name&order=1" target="_blank">五金工艺</a>
	                                    <a href="http://www.g-emall.com/category/700.html" target="_blank">园艺</a>
                                    </p>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=多乐士" target="_blank">多乐士</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=立邦" target="_blank">立邦</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=三棵树" target="_blank">三棵树</a>
                                    </p>
                                    <p>
	                                    <a href="http://www.g-emall.com/search/search.html?q=JOMOO" target="_blank">JOMOO</a>
	                                    <a href="http://www.g-emall.com/search/search.html?q=友莱卫浴" target="_blank">友莱卫浴</a>
                                    </p>
                               </div>
                           </div>
                           <div class="Museum-home-shoplist1-main-mid">
                               <a href="http://www.g-emall.com/goods/1334501.html" class="mid-first" target="_blank">
                                     <div class="shop-list-name sixyellow">官方10年质量保障</div>
                                     <div class="shop-list-name1">星级酒店指定卫浴品牌</div>
                                     <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list6-02.png" alt="" />     
                               </a>
                               <a href="http://www.g-emall.com/JF/458292.html" target="_blank">
                                     <div class="shop-list-name sixyellow">欧式落地浴柜</div>
                                     <div class="shop-list-name1">防水/防腐/防蛀/隔热</div>
                                     <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list6-03.png" alt="" />     
                               </a>
                           </div>
                           <div class="Museum-home-shoplist1-main-right">
                               <ul class="shop-first-list clearfix">
                                    <li>
                                        <a href="http://www.g-emall.com/JF/758761.html" target="_blank">
                                              <div class="shop-list-name">龙凤檀实木地板</div>
                                              <div class="shop-list-name1 sixyellow">享受绿色更环保</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list6-04.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/759123.html" target="_blank">
                                              <div class="shop-list-name">经典芬兰金啡</div>
                                              <div class="shop-list-name1 sixyellow">金牌亚洲 ID-STONE系列</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list6-05.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/1057082.html" target="_blank">
                                              <div class="shop-list-name">给绿植一个家</div>
                                              <div class="shop-list-name1 sixyellow">防腐木室外阶梯花架</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list6-06.jpg" alt="" />
                                        </a>
                                    </li>
                               </ul>
                               <ul class="clearfix">
                                    <li>
                                        <a href="http://www.g-emall.com/JF/578853.html" target="_blank">
                                              <div class="shop-list-name">撒银钩边3D壁纸</div>
                                              <div class="shop-list-name1 sixyellow">欧式田园风情芬芳格调</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list6-07.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/292611.html" target="_blank">
                                              <div class="shop-list-name">旋涡技术超强排水</div>
                                              <div class="shop-list-name1 sixyellow">防虫防臭纯铜芯深水封</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list6-08.jpg" alt="" />
                                        </a>
                                    </li>
                                     <li>
                                        <a href="http://www.g-emall.com/JF/392651.html" target="_blank">
                                              <div class="shop-list-name">美味新煮义</div>
                                              <div class="shop-list-name1 sixyellow">适合中国家庭的燃气灶</div>
                                              <img src="<?php echo ATTR_DOMAIN;?>/zt/Museum-home/shop-list6-09.jpg" alt="" />
                                        </a>
                                    </li>
                               </ul>
                           </div>
                     </div>
                <!-- 6L商品lend -->
                 <div class="Museum-home-moreshop">
                     <a href="http://www.g-emall.com/category/list/7.html">更多居家好货，请点这里</a>
                 </div>
          </div>
	</div>

	
<script>

// 轮播切换
$(document).ready(function(){
	var num=$('.Museum-home-banner_span span').length;
	var i_mun=0;
	var timer_banner=null;

	$('.Museum-home-banner_ul li:gt(0)').hide();//页面加载隐藏所有的li 除了第一个
	
//底下小图标点击切换
	$('.Museum-home-banner_span span').click(function(){
		$(this).addClass('Museum-home-banner_span_one')
			   .siblings('span').removeClass('Museum-home-banner_span_one');
		var i_mun1=$('.Museum-home-banner_span span').index(this);
		$('.Museum-home-banner_ul li').eq(i_mun1).fadeIn('slow')
			                   .siblings('li').fadeOut('slow');

		i_mun=i_mun1;
	});
	//自动播放函数
	function bannerMoveks(){
		timer_banner=setInterval(function(){
			move_banner()
		},4000)
	};
	bannerMoveks();//开始自动播放

	//鼠标移动到banner上时停止播放
	$('.Museum-home-banner').mouseover(function(){
		clearInterval(timer_banner);
	});

	//鼠标离开 banner 开启定时播放
	$('.Museum-home-banner').mouseout(function(){
		bannerMoveks();
	});
   function move_banner(){
			if(i_mun==num-1){
				i_mun=-1
			}
			//大图切换
			$('.Museum-home-banner_ul li').eq(i_mun+1).fadeIn('slow')
									   .siblings('li').fadeOut('slow');
			//小图切换
			$('.Museum-home-banner_span span').eq(i_mun+1).addClass('Museum-home-banner_span_one')
					   .siblings('span').removeClass('Museum-home-banner_span_one');
			i_mun++
		
		}

})

// 侧方导航
$(function(){
             $(".items-list").on("click","a",function(e){

                   if(e && e.preventDefault) {    
                  　　//阻止默认浏览器动作(W3C)    
                   　　e.preventDefault();    
                   } else {    
                    　//IE中阻止函数器默认动作的方式     
                    　window.event.returnValue = false; 
                   }
                  var index = $(this).index();
                  var t = $(".Museum-home-wrap .cak-item").eq(index).offset().top;
                  $("html , body").stop().animate({
                      scrollTop:t
                  })
             })
            var h = $(".Museum-home-sidebar-r").height();
            var h1 = $("#cak1").offset().top;
            $(window).scroll(function(){
                 if($(document).scrollTop() <= h1){
                    $(".Museum-home-sidebar-r").stop().animate({
                         height:0,
                         opacity: 0 
                    },500)
                 }
                 else{
                    $(".Museum-home-sidebar-r").show().stop().animate({
	                     height:h,
	                     opacity: 1     
                    },500)
                 }
            });
			
	$(window).scroll(function(){
        var top = $(document).scrollTop();                       //定义变量，获取滚动条的高度
        var menu = $("#Museum-home-slider-menu");                                   //定义变量，抓取#menu
        var items = $(".Museum-home-wrap").find(".cak-item");    //定义变量，查找.item
        var curId = "";                                          //定义变量，当前所在的楼层item #id 
        items.each(function(){
            var m = $(this);                                     //定义变量，获取当前类
            var itemsTop = m.offset().top;                       //定义变量，获取当前类的top偏移量
            
            if(top > itemsTop-100){
                curId = "#" + m.attr("id");
            }else{
                return false;
            }
        });
        //给相应的楼层设置cur,取消其他楼层的cur
        var curLink = menu.find(".cak-active");
        if( curId && curLink.attr("href") != curId ){
            curLink.removeClass("cak-active");
            menu.find( "[href=" + curId + "]" ).addClass("cak-active");
        }
    });

	 $(".cak-gotop").click(function() {
      $('body , html').stop().animate({scrollTop: 0}, 500);
      return false;
    });
      			
    })

</script>	
   <!--主体 End -->