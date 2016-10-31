
<!DOCTYPE html>
<html>
<head>
    <title><?php echo Yii::t('User','盖网代理管理系统—用户登录')?></title>
</head>

<body>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo Yii::t('User','盖网代理管理系统—用户登录')?></title>
    <link href="<?php echo $this->module->assetsUrl ?>/css/site.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->module->assetsUrl ?>/css/header.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->module->assetsUrl ?>/css/css.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->module->assetsUrl ?>/css/style.css" rel="stylesheet" type="text/css" />
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
</head>
<body class="body">
    <!-- header -->
    <div class="header">
        <div class="headbox">
            <div class="login_header">
                <!-- logo_box -->
                <div class="unit logo_box">
                    <a href="#">
                        <img src=<?php echo Yii::app()->language=='en'?$this->module->assetsUrl."/images/logo_en.jpg":$this->module->assetsUrl."/images/logo.jpg"?> width="263" height="60" alt="logo" /></a></div>
                <!-- logo_box end -->
            </div>
        </div>
    </div>
    <!-- header end -->
    <!-- main -->
    <div class="main_login">
        <div class="container_login line">
            <div class="login_left unit">
                <img src="<?php echo $this->module->assetsUrl ?>/images/login-img467x256.jpg" width="467" height="256" alt="登录图片" />
            </div>
            <?php echo Yii::app()->language=='en'?'<div class="login_right_en unit">':'<div class="login_right unit">'?>
                <div class="loginbox">
			               <?php
			                $form = $this->beginWidget('CActiveForm', array(
			                    'id' => 'login-form',
			                    'enableAjaxValidation' => false,
			                    'enableClientValidation' => true,
			                    'clientOptions'=>array(
			                            'validateOnSubmit'=>true,
			                    ),
			                ));
			                ?>
			                <div class="line admin">
                            <?php echo $form->label($model, 'username')?>:
                            <?php echo $form->textField($model, 'username', array('class'=>'logink_en','placeholder'=>Yii::t('User','会员编号 / 用户名')))?>
                            <div class="warn"><?php echo $form->error($model, 'username'); ?></div>
                        	</div>
                        <div class="line pass">
                            <?php echo $form->label($model, 'password')?>:<?php echo Yii::app()->language=='en'?"&nbsp;&nbsp;&nbsp;":""?>
                            <?php echo $form->passwordField($model, 'password', array('class'=>'logink_en','placeholder'=>Yii::t('User','请输入您的密码')))?>
                            <div class="warn"><?php echo $form->error($model, 'password'); ?></div>
                        </div>
                        <?php if (LoginForm::captchaRequirement()): ?>
                        <div class="line" style="width:300px;height:50px;">
                        	<?php echo $form->label($model, 'verifyCode')?>
                        	<?php echo $form->textField($model, 'verifyCode'); ?>
                        	<?php $this->widget('CCaptcha', array('showRefreshButton' => false, 'clickableImage' => true, 'imageOptions' => array('alt' => Yii::t('User','点击换图'), 'title' => Yii::t('User','点击换图'), 'style' => 'margin-bottom:-12px;cursor:pointer'))); ?>
                            <div class="warn"><?php echo $form->error($model, 'verifyCode'); ?>
                            </div>
                        </div>
                        <?php endif;?>
                        <div class="line">
                            <input type="submit" name="" class='<?php echo Yii::app()->language=='en'?"login_button_en":"login_button"?>' value="" />
                        </div>
                         <?php $this->endWidget(); ?>
                     </div>   
                </div>
            </div>
    </div>
    <!-- main end -->
    <!-- foot -->
    <div class="footer">
        <?php echo Yii::app()->language=='en'?'<div class="info_en">':'<div class="info">'?>
            <a href="#"><?php echo Yii::t('User','关于盖网')?> </a><span>|</span> <a href="#"><?php echo Yii::t('User','帮助中心')?> </a><span>|</span> <a href="#">
                <?php echo Yii::t('User','网站地图')?> </a><span>|</span> <a href="#"><?php echo Yii::t('User','诚聘英才')?> </a><span>|</span> <a href="#"><?php echo Yii::t('User','联系客服')?>
            </a><span>|</span> <a href="#"><?php echo Yii::t('User','免责申明')?> </a>
        </div>
        <div class="gw">
            Copyright©gatewang.com &nbsp;&nbsp;<?php echo Yii::t('User','粤')?>ICP<?php echo Yii::t('User','备')?>13045334<?php echo Yii::t('User','号')?>-1</div>
    </div>
    <!-- foot end -->
</body>

</body>
</html>
    <style>
        .login_right_en { width:349px; height:286px; background:url(/images/login-boxbj_en.jpg) no-repeat; margin-left:55px; _margin-left:50px;}
        .login_button_en { border:none; background:url(/images/login-but_en.jpg) no-repeat; width:94px; height:34px; cursor:pointer; float:right;}
        .logink_en { background:#eee; width:130px; height:30px; border:1px solid #d2d2d2; line-height:30px; padding:0 10px 0;}
        .info_en { height: 25px;line-height: 25px;text-align: center; width:550px; margin:auto; padding-top:30px;}
        .info_en a { float:left; display:inline-block; color:#666;}
        .info_en span { float:left; margin:0 5px;}
    </style>
