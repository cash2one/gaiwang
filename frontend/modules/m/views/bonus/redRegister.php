<!doctype html>
<html>
<head>
    <title>盖象微商城Eshop_盖网红包_注册奖红包</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="盖象商城"/>
    <meta name="description" content="全国包邮,货到付款,提供最完美的购物体验！"/>
    <link rel="icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon"/>
    <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon"/>
    <meta content="width=device-width, minimum-scale=1,initial-scale=1, maximum-scale=1, user-scalable=1;" id="viewport"
          name="viewport"/>
    <!--离线应用的另一个技巧-->
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <!--指定的iphone中safari顶端的状态条的样式-->
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <!--告诉设备忽略将页面中的数字识别为电话号码-->
    <meta content="telephone=no" name="format-detection"/>
    <!--设置开始页面图片-->
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
                <a class="TxtTitle fl" href="javascript:void(0);">注册奖红包</a>
                <!-- <a class="icoMenu fr" href="javascript:void(0);"></a> -->
            </div>
            <div class="mainMenu">
                <i class="icoTriangle">箭</i>

                <div class="menuList clearfix">
                    <a class="item it01" href="<?php echo $this->createAbsoluteUrl('site/index'); ?>">首页</a>
                    <a class="item it02" href="<?php echo $this->createAbsoluteUrl('category/index'); ?>">分类</a>
                    <a class="item it03" href="<?php echo $this->createAbsoluteUrl('member/index'); ?>">我的盖网</a>
                    <a class="item it04" href="<?php echo $this->createAbsoluteUrl('cart/index'); ?>">购物车</a>
                </div>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="container">
            <div class="redBagCon mgtop20">
                <div class="redBagTit Tit04"></div>
                <div class="txtCon">
                    <p class="white txtC lh2">成功注册为盖网会员，可获得积分<span class="yellow">红包</span><i
                            class="ico_redbag"></i><span class="yellow">一个！！</span></p>

                    <p class="white txtC lh2">积分红包消费无障碍，想怎么买就怎么买。</p>
                </div>
                <div class="registerStep mgtop20">
                    <p class="blue lh2">成为盖网会员<span class="bigTit">四大好处</span>：</p>

                    <div class="stepPPT">
                        <ul class="pptList clearfix">
                            <li class="clearfix">
                                <dl>
                                    <dt><i class="bigTit">1.</i>注册即送积分红包</dt>
                                    <dd class="icoArrow"></dd>
                                </dl>
                            </li>
                            <li class="clearfix">
                                <dl>
                                    <dt><i class="bigTit">2.</i>尊享VIP特权</dt>
                                    <dd class="icoArrow"></dd>
                                </dl>
                            </li>
                            <li class="clearfix">
                                <dl>
                                    <dt><i class="bigTit">3.</i>享受会员优惠券</dt>
                                    <dd class="icoArrow"></dd>
                                </dl>
                            </li>
                            <li class="clearfix">
                                <dl>
                                    <dt><i class="bigTit">4.</i>会员绑定有奖励</dt>
                                    <dd class="icoArrow"></dd>
                                </dl>
                            </li>
                        </ul>
                    </div>
                    <div class="btnDiv">
                        <a class="btnYellow02" href="<?php echo $this->createUrl('/m/home/register'); ?>">马上注册会员</a>
                        <i class="ico_vip">vip</i>
                    </div>
                    <p class="blue lh3">注册奖红包说明：</p>

                    <p class="lh2">
                        1、每位新用户只奖励一个注册红包；<br/>
                        2、注册获得的红包是盖网积分红包，可在购物结算时使用；<br/>
                        3、符合赠送条件的用户，红包会自动发放到红包账户；<br/>
                        4、红包可以在盖象商城购物时使用；<br/>
                        5、红包不与盖惠券同时使用；<br/>
                        6、红包最终解释权归盖网所有，如有任何疑问请咨询盖网客服。

                    </p>
                </div>
                <div class="coupons">
                    <div class="couponTit clearfix"><span class="yelline"></span>

                        <p class="titCon">大家都在<span class="yellow bigTit">抢!!</span></p></div>
                    <ul class="couponsList" id="goodlist">
                        <?php
                        if ($data) {
                            foreach ($data as $value) {
                                ?>
                                <li class="clearfix">
                                    <a class="item" href="javascript:void(0);" tag="2">
                                        <img src="<?php echo ATTR_DOMAIN . '/' . $value['thumbnail']; ?>" alt="优惠券"/>
                                        <div class="imgIntro">
                                            <p class="actName">满<?php echo $value['condition'];?>使用<span class="white02"><?php echo '￥'.$value['price'];?></span></p>
                                            <p><?php echo date('m/d', $value['valid_start']) . ' - ' . date('m/d', $value['valid_end'])?></p>
                                        </div>
                                        <div class="btn"><span class="btnYellow" onclick="javascript:alert('JS效果')">免费领取</span></div>
                                    </a>
                                </li>
                            <?php
                            }
                        }
                        ?>
                    </ul>
                    <?php
                    $this->widget('WLinkPager', array(
                        'pages' => $pages,
                        'jump' => true,
                        'prevPageLabel' =>  Yii::t('page', '上一页'),
                        'nextPageLabel' =>  Yii::t('page', '下一页'),
                    ))

                    ?>
                    <!--<div class="gxui-pages" pageurl="?page=@page" pagesize="9" count="4" url="/categoryList" container="#goodlist">
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
                    </div>-->
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
