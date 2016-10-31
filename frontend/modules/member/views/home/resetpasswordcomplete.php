<?php
$returnUrl = !empty($returnUrl) ? $returnUrl: Yii::app()->createUrl('/member/home/login');
?>
<div class="resetPass">
    <div class="top clearfix">
        <h2><span><?php echo Yii::t('memberHome','找回密码'); ?></span></h2>
    </div>
    <div class="resetPassCon">
        <div class="resetPassStep">
            <ul class="s2 clearfix">
                <li><?php echo Yii::t('memberHome','1.填写账户信息'); ?></li>
                <li><?php echo Yii::t('memberHome','2.成功获取新密码'); ?></li>
            </ul>
        </div>
        <div class="resetPassSuc">
            <h3><?php echo Yii::t('memberHome','恭喜您，密码成功设置！ 你可以使用新密码登录盖网！'); ?></h3>
            <div class="do">
                <?php echo CHtml::button(DOMAIN.'/images/bg/btnLoginNow.gif',
                    array('alt'=>Yii::t('memberHome','立即登录'),'value' => Yii::t('memberHome','立即登录'), 'class' => 'btnLoginNow',
                        'onclick'=>'javascript:document.location.href="'.$returnUrl.'"')) ?>
            </div>
        </div>
    </div>
</div>