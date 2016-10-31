<?php
    Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/global.css');
    Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/module.css');
    Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/cart.css');
    Yii::app()->clientScript->registerScriptFile($this->theme->baseUrl . '/js/jquery-1.9.1.js');
?>
<style>
    .order-cancel .order-title span {        
        font-size: 17px;
    }
    .order-cancel .order-message-box {
        padding: 20px 0 0 345px;
    }
</style>
<div class="member-contain clearfix">
    <div class="main-contain">
        <div class="return-record">
            <span><a href=""> <?php echo Yii::t('memberRecharge', '积分充值结果'); ?></a></span>        
        </div>
        <div class="mbRcontent">

            <div class="mbDate1">
                <div class="mbDate1_t"></div>
                <div class="mbDate1_c">
                    <div class="clearfix"></div>
                    <span class="successicon">
                        <?php if (!isset($result['errorMsg'])): ?>
                            <div class="order-cancel">
                                <div class="order-title-on"><span><i class="icon-cart"></i><?php echo Yii::t('memberRecharge', '您已经成功充值积分'); ?></span></div>
                                <div class="order-message clearfix">
                                    <div class="order-message-box">
                                        <a class="again" href="<?php echo $this->createAbsoluteUrl('/member/recharge/index') ?>"><?php echo Yii::t('memberRecharge','继续充值')?></a>
                                        <a class="check" href="<?php echo $this->createUrl('/member/site/index')?>"><?php echo Yii::t('memberRecharge','我的盖象')?></a>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="order-cancel">
                                <div class="order-title"><span><i class="icon-cart"></i><?php echo Yii::t('memberRecharge', '很遗憾，您的积分充值失败，请重新充值！'); ?></span></div>
                                <div class="order-message clearfix">
                                    <!--<div class="order-message-title"><?php // echo $result['errorMsg']; ?></div>-->
                                    <div class="order-message-box">
                                        <a class="again" href="<?php echo $this->createAbsoluteUrl('/member/recharge/index') ?>"><?php echo Yii::t('memberRecharge','重新充值')?></a>
                                        <a class="check" href="<?php echo $this->createUrl('/member/site/index')?>"><?php echo Yii::t('memberRecharge','我的盖象')?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </span>

                </div>
                <div class="mbDate1_b"></div>
            </div>
        </div>
    </div>
</div>
