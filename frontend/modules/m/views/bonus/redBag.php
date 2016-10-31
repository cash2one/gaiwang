<!doctype html>
<html>
<head>
    <title>盖象微商城Eshop_盖网红包</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="盖象商城" />
    <meta name="description" content="全国包邮,货到付款,提供最完美的购物体验！" />
    <link rel="icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <meta content="width=device-width, minimum-scale=1,initial-scale=1, maximum-scale=1, user-scalable=1;" id="viewport" name="viewport" /><!--离线应用的另一个技巧-->
    <meta content="yes" name="apple-mobile-web-app-capable" /><!--指定的iphone中safari顶端的状态条的样式-->
    <meta content="black" name="apple-mobile-web-app-status-bar-style" /><!--告诉设备忽略将页面中的数字识别为电话号码-->
    <meta content="telephone=no" name="format-detection" /><!--设置开始页面图片-->
    <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/global.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/comm.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/module.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/redBag.css"/>
    <script src="<?php echo DOMAIN; ?>/js/m/jquery.js"></script>
    <script src="<?php echo DOMAIN; ?>/js/m/jquery.touchslider.min.js"></script>
    <script src="<?php echo DOMAIN; ?>/js/m/template.js"></script>
    <script src="<?php echo DOMAIN; ?>/js/m/com.js"></script>

</head>
<body>
<div class="wrap" id="wrap">
    <div class="header" id="js-header">
        <div class="mainNav">
            <div class="topNav clearfix">
                <a class="icoBlack fl" href="javascript:history.go(-1);"></a>
                <!-- <a class="logo TxtTitle fl" href="javascript:void(0);"><img src="../images/bg/logo.gif" alt="盖象商城"/></a> -->
                <a class="TxtTitle fl" href="javascript:void(0);">盖网红包</a>
                <!-- <a class="icoMenu fr" href="javascript:void(0);"></a> -->
            </div>
            <div class="mainMenu">
                <i class="icoTriangle">箭</i>
                <div class="menuList clearfix">
                    <a class="item it01" href="<?php echo $this->createAbsoluteUrl('site/index');?>">首页</a>
                    <a class="item it02" href="<?php echo $this->createAbsoluteUrl('category/index');?>">分类</a>
                    <a class="item it03" href="<?php echo $this->createAbsoluteUrl('member/index');?>">我的盖网</a>
                    <a class="item it04" href="<?php echo $this->createAbsoluteUrl('cart/index');?>l">购物车</a>
                </div>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="container">
            <!-- RedBag Banner -->
            <div class="redBagBanner">
                <div class="item"><a href="#"><img src="<?php echo DOMAIN; ?>/images/m/temp/redBag_bannerImg01.png"/></a></div>
            </div>

            <div class="redBagCon mgtop20">
                <h1>盖网已<span class="yellow">送出红包</span></h1>
                <span class="line red"></span>
                <div class="redBagNum mgtop20 clearfix">
                    <div class="numItems">
                        <span class="item">0</span>
                        <span class="item on">3</span>
                        <span class="item on">1</span>
                        <span class="item on">9</span>
                        <span class="item on">3</span>
                        <span class="item on">个</span>
                    </div>
                </div>
                <div class="txtCon">
                    <div class="btnDiv"><a class="btnShare" href="shareStep.html"><span class="btn brown"><i class="btncon">马上分享给好友</i></span></a></div>
                    <p class="white txtC lh3">您的朋友拿到红包了吗? 好东西不能独享哦！</p>
                </div>

                <div class="redBagTit Tit02"></div>
                <div class="activeBox mgtop20">
                    <ul class="activeList clearfix">
                        <li>
                            <a class="item" href="redbagRegister.html">
                                <img src="<?php echo DOMAIN; ?>/images/m/temp/activeImg01.jpg" alt="注册送红包"/>
                                <p class="actName">注册送红包</p>
                                <i class="actIco"></i>
                            </a>
                        </li>
                        <li>
                            <a class="item" href="redbagQuare.html">
                                <img src="<?php echo DOMAIN; ?>/images/m/temp/activeImg02.jpg" alt="购物盖惠卷"/>
                                <p class="actName">购物盖惠卷</p>
                                <i class="actIco"></i>
                            </a>
                        </li>
                        <li>
                            <a class="item" href="shareStep.html">
                                <img src="<?php echo DOMAIN; ?>/images/m/temp/activeImg03.jpg" alt="分享抢红包"/>
                                <p class="actName"><span class="h1">分享</span><br/>抢红包</p>
                                <i class="actIco"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="coupons">
                    <div class="couponTit clearfix"><span class="yelline"></span><p class="titCon">大家都在<span class="yellow bigTit">抢!!</span></p></div>
                    <ul class="couponsList" id="goodlist">
                        <li class="clearfix">
                            <a class="item" href="javascript:void(0);" tag="2">
                                <img src="<?php echo DOMAIN; ?>/images/m/temp/couponImg01.png" alt="优惠券"/>
                                <!-- <div class="imgIntro">
                                    <p class="actName">满888使用<span class="white02">￥100</span></p>
                                    <p>10/11 - 12/31</p>
                                </div>-->
                                <div class="btn"><span class="btnYellow">免费领取</span></div>
                            </a>
                        </li>
                        <li class="clearfix">
                            <a class="item" href="javascript:void(0);" tag="3">
                                <img src="<?php echo DOMAIN; ?>/images/m/temp/couponImg01.png" alt="优惠券"/>
                                <!-- <div class="imgIntro">
                                    <p class="actName">满888使用<span class="white02">￥100</span></p>
                                    <p>10/11 - 12/31</p>
                                </div>-->
                                <div class="btn"><span class="btnYellow">免费领取</span></div>
                            </a>
                        </li>
                        <li class="clearfix">
                            <a class="item" href="javascript:void(0);" tag="1">
                                <img src="<?php echo DOMAIN; ?>/images/m/temp/couponImg01.png" alt="优惠券"/>
                                <!-- <div class="imgIntro">
                                    <p class="actName">满888使用<span class="white02">￥100</span></p>
                                    <p>10/11 - 12/31</p>
                                </div>-->
                                <div class="btn"><span class="btnYellow">免费领取</span></div>
                            </a>
                        </li>
                        <li class="clearfix">
                            <a class="item" href="javascript:void(0);" tag="2">
                                <img src="<?php echo DOMAIN; ?>/images/m/temp/couponImg01.png" alt="优惠券"/>
                                <!-- <div class="imgIntro">
                                    <p class="actName">满888使用<span class="white02">￥100</span></p>
                                    <p>10/11 - 12/31</p>
                                </div>-->
                                <div class="btn"><span class="btnYellow">免费领取</span></div>
                            </a>
                        </li>
                    </ul>
                    <div class="gxui-pages" pageurl="?page=@page" pagesize="9" count="4" url="/categoryList" container="#goodlist">
                        <span>上一页</span>
                        <a>上一页</a>
                        <div class="gxui-select"><span><b class="red">1</b>/9</span>
                            <del class="arrow-bottom"></del>
                            <select>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                            </select>
                        </div>
                        <a>下一页</a>
                        <span>下一页</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="footer">
        <!--<p class="copyright mgbot30 mgtop20">客户端 <br/>© m.gatewang.com</p> -->
    </div>
</div>
<!-- Float Navigation -->
<div class="floatNav">
    <!--<a class="floatCart item" href="cart.html">购物车</a>-->
    <a class="floatTop item" href="javascript:void(0)">返回顶部</a>
</div>

</body>
</html>
