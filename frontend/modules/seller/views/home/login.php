<!--[if lt IE 8]><script>window.location.href="http://seller.<?php echo SHORT_DOMAIN ?>/home/notSupported"</script><![endif]-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="" />
        <meta name="Description" content="" />
        <title><?php echo Yii::t('sellerHome', '盖象卖家平台登录'); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_DOMAIN; ?>global.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_DOMAIN; ?>seller.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_DOMAIN; ?>custom.css" />
        <?php Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero') ?>
    </head>
    <body>
        <div class="wrap">
            <div class="header bgb10">
                <div class="logowrap clearfix">
                    <?php echo CHtml::link(CHtml::image(DOMAIN . '/images/bg/seller_logo.jpg'), DOMAIN, array('class' => 'slogo')); ?>
                    <span class="logoTit">
                        <h1><?php echo Yii::t('sellerHome', '盖象卖家平台'); ?></h1>
                        <p>G-emall seller platform</p>
                    </span>
                </div>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'home-form',
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
            <div class="main bgfff clearfix">
                <div class="w1060">
                    <div class="sellerLogin">
                        <h1><?php echo Yii::t('sellerHome', '卖家登录'); ?></h1>
                        <dl class="clearfix">
                            <dt><?php echo $form->label($model, 'username'); ?>：</dt>
                            <dd>
                                <?php echo $form->textField($model, 'username', array('class' => 'inputtxt2', 'placeholder' => Yii::t('sellerHome', '用户名/会员编号/绑定手机号')));
                                ?>
                            </dd>
                            <dd style="height: 100%">
                                <?php
                                if (!empty($users)) {
                                    echo CHtml::label(
                                            Yii::t('memberHome', '{mobile}绑定了多个账号，请选择', array('{mobile}' => $model->username)), 'gai_number');

                                    echo CHtml::dropDownList('gai_number', '', $users, array('style' => 'position: absolute;'));
                                }
                                ?>
                                <?php echo $form->error($model, 'username'); ?>
                            </dd>
                        </dl>
                        <dl class="clearfix">
                            <dt><?php echo $form->label($model, 'password'); ?>：</dt>
                            <dd>
                                <?php echo $form->passwordField($model, 'password', array('class' => 'inputtxt2')); ?>

                            </dd>
                            <dd style="height: 100%"><?php echo $form->error($model, 'password'); ?></dd>
                        </dl>
                        <dl class="clearfix">
                            <dt><?php echo $form->labelEx($model, 'verifyCode'); ?>：</dt>
                            <dd>
                                <?php echo $form->textField($model, 'verifyCode', array('class' => 'w100 inputtxt2')); ?>
                                <span class="changeCode">
                                    <?php
                                    $this->widget('CCaptcha', array(
                                        'showRefreshButton' => false,
                                        'clickableImage' => true,
                                        'imageOptions' => array('alt' => Yii::t('sellerHome', '点击换图'),
                                            'title' => Yii::t('sellerHome', '点击换图'),
                                            'style' => 'margin-bottom:-12px;cursor:pointer')));
                                    ?>
                                </span>
                            </dd>
                            <dd style="height: 100%;">
                                <?php echo $form->error($model, 'verifyCode'); ?>
                            </dd>
                            <dd  class="checkbox01">
                                <input type="checkbox" name="assistant"/><?php echo Yii::t('sellerHome', '我是店小二'); ?>
                                | 语言: <?php echo CHtml::dropDownList('select_language',HtmlHelper::LANG_ZH_CN,HtmlHelper::languageInfo()) ?>
                            </dd>
                        </dl>
                        <dl class="do clearfix">
                            <?php echo CHtml::submitButton(Yii::t('sellerHome', '登录'), array('class' => 'sellerSubmitBtn')); ?>
                            <?php echo CHtml::link(Yii::t('sellerHome', '忘记密码？'), $this->createAbsoluteUrl('/member/home/resetPassword')); ?>
                        </dl>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
            <div class="footer clearfix">
                <p>
                    <?php echo CHtml::link(Yii::t('site', '关于盖象'), $this->createAbsoluteUrl('/about')); ?> |
                    <?php echo CHtml::link(Yii::t('site', '帮助中心'), $this->createAbsoluteUrl('/help')); ?>  |
                    <?php echo CHtml::link(Yii::t('site', '网站地图'), $this->createAbsoluteUrl('/sitemap')); ?>  | 
                    <?php echo CHtml::link(Yii::t('site', '诚聘英才'), $this->createAbsoluteUrl('/job')); ?>  | 
                    <?php echo CHtml::link(Yii::t('site', '联系客服'), $this->createAbsoluteUrl('/contact')); ?>  | 
                    <?php echo CHtml::link(Yii::t('site', '免责声明'), $this->createAbsoluteUrl('/statement')); ?>
                </p>
                <p><?php echo Tool::getConfig('site', 'copyright'); ?></p>
            </div>
        </div>
    </body>
  <?php if(time() < strtotime("2015-10-12")+3600*24*7):?>  
    <script>
    //成功样式的dialog弹窗提示
    art.dialog({
        icon: '提示',
        content: '<div style="line-height:1.8;font-size:15px"><h1 style="text-align:center">关于网站调整部分产品暂时下架通知</h1><p style="text-align:justify; text-indent:2em;">因网站调整需要，我们将于2015年10月12日（周一）对部分商家产品进行暂时下架，</p><p>下架周期为5-7个工作日，调整完成后将进行恢复，给您带来的不便，敬请谅解！</p><p style="text-align:right;">盖象商城</p><p style="text-align:right;">2015年10月10日</p></div>',
        ok: true,
        okVal:'<?php echo Yii::t('member','确定') ?>',
        title:'<?php echo Yii::t('member','消息') ?>'
    });     
    </script>
 <?php endif;?>
</html>