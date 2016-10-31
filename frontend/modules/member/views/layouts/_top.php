<?php
/* @var $this Controller */
//$account = Member::account($this->model);
$account = $this->account;
?>
<div class="navWrap">
    <div class="navContent otherMenu" >
        <a href="<?php echo DOMAIN; ?>"  target="_blank">
            <img class="mbLogo"src="<?php echo DOMAIN; ?>/images/bg/member_logo.jpg"  width="148" height="40" alt="<?php echo Yii::t('member', '盖象商城'); ?>" />
        </a>
        <ul class="menav">
            <li><?php echo CHtml::link(Yii::t('member', '商城首页'), DOMAIN, array('target' => '_blank')) ?></li>
            <li><?php echo CHtml::link(Yii::t('member', '积分兑换'), array('/jf'), array('target' => '_blank')) ?></li>
            <li><?php echo CHtml::link(Yii::t('member', '线下服务'), array('/jms'), array('target' => '_blank')) ?></li>
            <li><?php echo CHtml::link(Yii::t('member', '酒店预订'), array('/hotel'), array('target' => '_blank')) ?></li>
        </ul>
        <div class="menavRiht">
            <span class="memberName"><?php echo Yii::t('member', 'HI,欢迎来到盖象！'); ?><?php echo $this->getUser()->name ?></span> |
            <span><?php echo Yii::t('member','我的积分');?>:<?php echo $account['integral']; ?></span> |
            <span><?php echo Yii::t('member','冻结积分');?>:<?php echo $account['freeze']; ?></span> |
            <?php echo CHtml::link(Yii::t('member', '退出'), $this->createAbsoluteUrl('/member/home/logout')); ?> |
        </div>
    </div>
</div>