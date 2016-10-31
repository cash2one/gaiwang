<?php
$returnUrl = !empty($returnUrl) ? $returnUrl: Yii::app()->createUrl('/member/home/login');
?>
<div class="pages-header">
    <div class="w1200">
        <div class="pages-logo"><a href="<?php echo DOMAIN; ?>"><img src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/images/temp/register_logo.jpg" width="213" height="86" /></a></div>
        <div class="pages-title icon-cart"><?php echo Yii::t('memberHome', '找回密码') ?></div>
        <div class="pages-top">
            <?php echo CHtml::link(Yii::t('site','注册'),array('/member/home/register'),array('id'=>'register_')); ?>|
            <?php echo CHtml::link(Yii::t('site','登录'),array('/member/home/login'),array('id'=>'login_')); ?>
        </div>
    </div>
</div>
<div class="main w1200">
    <div class="status status03"></div>
    <div class="setPassword-success">
        <div class="title icon-cart"><?php echo Yii::t('memberHome', '密码设置成功！') ?></div>
        <div class="message">
            <p><?php echo Yii::t('memberHome', '盖网帐号') ?> <span><?php echo $g_num ?></span> <?php echo Yii::t('memberHome', '的密码已设置成功，') ?><br /><?php echo Yii::t('memberHome', '现在您可登录盖象商城！') ?></p>
        </div>
        <div class="determine">

            <?php echo CHtml::button('',
                array('alt'=>Yii::t('memberHome','马上登录'),'value' => Yii::t('memberHome','马上登录'), 'class' => 'btn-dete',
                    'onclick'=>'javascript:document.location.href="'.$returnUrl.'"')) ?>
        </div>
    </div>
</div>