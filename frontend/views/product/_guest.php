<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
<!--<link href="--><?php //echo CSS_DOMAIN ?><!--global.css" rel="stylesheet" type="text/css"/>-->
<link href="<?php echo CSS_DOMAIN ?>module.css" rel="stylesheet" type="text/css"/>
<!--<link href="--><?php //echo CSS_DOMAIN; ?><!--custom.css" rel="stylesheet" type="text/css"/>-->
    <script>
        document.domain = "<?php echo substr(DOMAIN, 11) ?>";
    </script>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<script src="<?php echo DOMAIN ?>/js/jquery.gate.common.js" type="text/javascript"></script>
</head>
<body>
<div class="messConsulting" style="width:850px; padding: 15px 50px; overflow: hidden;">
    <?php
    /** @var CActiveForm $form */
    $form = $this->beginWidget('ActiveForm', array(
        'id' => $this->id . '-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <span class="title"><?php echo Yii::t('goods', '咨询商品'); ?>: </span>
    <script>
        //点击旁边的刷选验证码
        function changeVeryfyCode() {
            jQuery.ajax({
                url: "<?php echo Yii::app()->createUrl('/member/home/captcha/refresh/1') ?>",
                dataType: 'json',
                cache: false,
                success: function (data) {
                    jQuery('#verifyCodeImg').attr('src', data['url']);
                    jQuery('body').data('captcha.hash', [data['hash1'], data['hash2']]);
                }
            });
            return false;
        }
    </script>
    <?php echo $form->textArea($guestbook, 'content', array('class' => 'mess_textbox','style'=>'width:860px')); ?>
    <?php echo $form->error($guestbook, 'content'); ?>
<!--    --><?php //echo $form->hiddenField($guestbook, 'goodsName', array('value' => $goods['name'])) ?>
    <div class="VerifiCode">
        <?php echo $form->labelEx($guestbook, 'verifyCode'); ?>：
        <?php echo $form->textField($guestbook, 'verifyCode'); ?>&nbsp;
        <a onclick="changeVeryfyCode()" class="changeCode" style="cursor: pointer">
            <?php
            $this->widget('CCaptcha', array(
                'showRefreshButton' => false,
                'clickableImage' => true,
                'id' => 'verifyCodeImg',
                'imageOptions' => array(
                    'alt' => Yii::t('home', '点击换图'),
                    'title' => Yii::t('home', '点击换图'),
                )
            ));
            ?>
        </a>
        <?php echo $form->error($guestbook, 'verifyCode'); ?>
    </div>
    <p><?php echo CHtml::submitButton(Yii::t('guestbook', '发表咨询'), array('class' => 'btnMessConsult')); ?></p>
    <?php $this->endWidget(); ?>
</div>
</body>
</html>