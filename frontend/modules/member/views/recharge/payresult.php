<?php
/* @var $this ApplyCashController */
/** @var $model Recharge */
$this->breadcrumbs = array(
    Yii::t('memberRecharge', '积分管理'),
    Yii::t('memberRecharge', '积分充值'),
);
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberRecharge','积分充值结果'); ?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="clearfix"></div>
                <span class="successicon">
                    <?php if(!isset($result['errorMsg']) ): ?>
                        <dl>
                            <dt>
                                <img src="<?php echo DOMAIN ?>/images/bg/seller_iconSuccess.gif" width="71" height="70">
                            </dt>
                            <dd>
                                <p class="name"><?php echo Yii::t('memberRecharge','您已经成功充值积分'); ?></p>
                            </dd>
                        </dl>
                    <?php else: ?>
                        <dl>
                            <dt><?php echo Yii::t('memberRecharge','很遗憾，您的积分充值失败,请刷新重试！'); ?></dt>
                            <dd><?php echo $result['errorMsg']; ?></dd>
                        </dl>
                    <?php endif; ?>
				</span>

            </div>
            <div class="mbDate1_b"></div>

        </div>

    </div>
</div>
