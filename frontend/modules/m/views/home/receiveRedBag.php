<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $this->pageTitle;?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="盖象商城" />
    <meta name="description" content="全国包邮,货到付款,提供最完美的购物体验！" />
    <link rel="icon" href="<?php echo DOMAIN; ?>/images/favicon.ico" type="image/x-icon" />
    <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/favicon.ico" type="image/x-icon" />
    <meta content="width=device-width, minimum-scale=1,initial-scale=1, maximum-scale=1, user-scalable=1;" id="viewport" name="viewport" /><!--离线应用的另一个技巧-->
    <meta content="yes" name="apple-mobile-web-app-capable" /><!--指定的iphone中safari顶端的状态条的样式-->
    <meta content="black" name="apple-mobile-web-app-status-bar-style" /><!--告诉设备忽略将页面中的数字识别为电话号码-->
    <meta content="telephone=no" name="format-detection" /><!--设置开始页面图片-->
    <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/global.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/comm.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/module.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/redBag.css"/>
</head>
<body>
<div class="wrap" id="wrap">
    <div class="header" id="js-header">
        <div class="mainNav">
            <div class="topNav clearfix">
                <a class="icoBlack fl" href="javascript:history.go(-1);"></a>
                <!-- <a class="logo TxtTitle fl" href="javascript:void(0);"><img src="../images/bg/logo.gif" alt="盖象商城"/></a> -->
                <a class="TxtTitle fl" href="javascript:void(0);"><?php echo $this->showTitle; ?></a>
                <!-- <a class="icoMenu fr" href="javascript:void(0);"></a> -->
            </div>
        </div>
    </div>
    <?php if($flag):?>
    <div class="main">
        <div class="container redbg">
            <!-- RedBag Banner -->
            <div class="shareTips">
                <img class="imgItem h185" src="<?php echo DOMAIN; ?>/images/m/bg/shareredbg01.jpg" alt="分享领取红包"/>
                <img class="imgItem h185" src="<?php echo DOMAIN; ?>/images/m/bg/shareredbg02.jpg" alt="分享领取红包"/>
                <p class="imgTit yellow mgtop10">你可以通过微信分享</p>
                <img class="imgItem h190" src="<?php echo DOMAIN; ?>/images/m/bg/sharebywechat01.jpg" alt="分享领取红包"/>
                <img class="imgItem h185" src="<?php echo DOMAIN; ?>/images/m/bg/sharebywechat02.jpg" alt="分享领取红包"/>
                <p class="imgTit yellow mgtop10">你还可以通过浏览器分享</p>
                <img class="imgItem h270" src="<?php echo DOMAIN; ?>/images/m/bg/sharebyUC01.jpg" alt="分享领取红包"/>
                <img class="imgItem h245" src="<?php echo DOMAIN; ?>/images/m/bg/sharebyUC02.jpg" alt="分享领取红包"/>
            </div>
            <div class="msgTip white">
                <p>分享奖红包说明：</p>
                <p>1、好友通过您分享的页面成功领取红包，您将会获得一个58元红包，红包会自动发放到红包账户中；</p>
                <p>2、红包可以在盖象商城购物时使用；</p>
                <p>3、您分享的次数不设上限，同一个分享链接新注册数量不设上限，赠送的红包数量不设上限；</p>
                <p>4、您的账户与成功领取红包的好友账户视为绑定关系，您的账户为推荐人账户;</p>
                <p>5、红包最终解释权归盖网所有，如有任何疑问请咨询盖网客服；</p>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="main">
        <div class="container redbg">
            <!-- RedBag Banner -->
            <div class="redBagBanner02">
                <div class="item"><a href="#"><img src="<?php echo DOMAIN; ?>/images/m/temp/receiveredbag.jpg"/></a></div>
            </div>
            <?php
            $form = $this->beginWidget('ActiveForm', array(
                'id' => $this->id . '-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
                <div class="redBagCon mgtop20">
                    <div class="redBagLogin">
                        <div class="divInput">
                            <?php
                            echo $form->textField($model, 'mobile', array(
                                'class' => 'inputTxt', 'placeholder' => Yii::t('mhome', '请输入手机号码'),
                            ));
                            ?>
                            <?php echo $form->error($model, 'mobile'); ?>
                        </div>

                        <div class="divInput codeCon">
                            <?php
                            echo $form->textField($model, 'mobileVerifyCode', array(
                                'placeholder' => Yii::t('mhome', '请输入验证码'),
                                'class' => 'inputTxt',
                            ));
                            ?>
                            <a href="#" id="sendMobileCode">
                                <div class="sendCode">
                                    <span data-status="1">发送验证码</span>
                                </div>
                            </a>
                            <?php echo $form->error($model, 'mobileVerifyCode'); ?>
                        </div>

                        <div class="divInput codeCon">
                            <?php echo $form->passwordField($model, 'password', array('class' => 'inputTxt', 'placeholder' =>Yii::t('mhome', '设置登录密码'))); ?>
                            <input type="button" class="LFBut2" num="1"/>
                            <?php echo $form->error($model, 'password'); ?>
                        </div>

                        <div class="divInput">
                            <input class="inputTxt" name="referrals_member" type="text" value="<?php echo $gwNumber;?>" readonly/>
                        </div>

                        <div class="btnDiv">
                            <?php echo CHtml::submitButton(Yii::t('mhome','领取520元红包'), array('type'=>'submit','name'=>'yt0','value'=>'领取520元红包','class'=>'btnReceive'))?>
                        </div>
                        <?php $this->endwidget();?>
                        <p class="txtC lh3">
                            <a class="yellow" style="color: #FFCC02;" href="<?php echo $this->createUrl('home/login');?>">已经有账户,点击登录</a>
                        </p>
                    </div>
                    <?php  $this->renderPartial('_sendMobileCodeJs'); ?>
                    <script type="text/javascript">
                        $(function(){
                            //会员注册短信发送
                            sendMobileCode('#sendMobileCode','#home-form #Member_mobile');
                        });
                    </script>
                </div>
            <div class="msgTip white">
                <p>红包说明：</p>
                <p>1、每位新用户即可领取一个价值520元的红包；</p>
                <p>2、红包可以在盖象商城购物时使用；</p>
                <p>3、红包最终解释权归盖网所有，如有任何疑问请咨询盖网客服。</p>
            </div>
        </div>
    </div>
    <?php endif;?>
    <div class="footer">
        <!--<p class="copyright mgbot30 mgtop20">客户端 <br/>© m.gatewang.com</p> -->
    </div>
</div>
<!-- Float Navigation -->
<div class="floatNav">
    <!--<a class="floatCart item" href="cart.html">购物车</a>-->
    <a class="floatTop item" href="javascript:void(0)">返回顶部</a>
</div>
<script src="<?php echo DOMAIN; ?>/js/m/jquery.touchslider.min.js"></script>
<script src="<?php echo DOMAIN; ?>/js/m/template.js"></script>
<script src="<?php echo DOMAIN; ?>/js/m/com.js"></script>
<script type="text/javascript" src="<?php echo DOMAIN; ?>/js/m/member.js"></script>
</body>
</html>
