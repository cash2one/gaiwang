<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="<?php echo $this->theme->baseUrl; ?>/styles/global.css" rel="stylesheet" type="text/css" />
<link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/styles/module.css" rel="stylesheet" type="text/css"/>
<script>
	document.domain = "<?php echo substr(DOMAIN, 11) ?>";
</script>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

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
</head>
<body>

<div class="pdTab4-inp clearfix">
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
    <?php echo Yii::t('goods', '咨询商品'); ?>:    
    <?php echo $form->textArea($guestbook, 'content', array('class' => 'mess_textbox','style'=>'width:715px')); ?>
    <?php echo $form->error($guestbook, 'content'); ?>
    
    <div class="pdTab4-inpDiv clearfix">
      <div class="pdTab4-inp-left"><?php echo $form->labelEx($guestbook, 'verifyCode'); ?>：
      <?php echo $form->textField($guestbook, 'verifyCode', array('class'=>'pdTab4-yzm')); ?>
      </div>
        <div class="pdTab4-inp-yzmNum"><a onclick="changeVeryfyCode()" class="changeCode" style="cursor: pointer">
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
        </a></div>
		<?php echo $form->error($guestbook, 'verifyCode'); ?>
    </div>
    <?php echo CHtml::submitButton(Yii::t('guestbook', '发表咨询'), array('class' => 'pdTab4-inp-but')); ?>
    <?php $this->endWidget(); ?>
</div>

</body>
</html>