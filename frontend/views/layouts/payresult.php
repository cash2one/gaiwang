<?php
/* @var $this Controller */
?>
<div class="main clearfix">
    <!--------------------------主体-------------------------->
    <div class="main">
        <span class="shopFlowPic_4"></span>

        <div class="shopFlGgbox">
            <?php if (!isset($result['errorMsg'])): ?>
                <div class="shopFlsucessBox">
                    <span class="shopflsucessIcon"><?php echo Yii::t('orderFlow', '恭喜，您已成功付款！'); ?></span>

                    <p><b>·</b>
                   <span><?php echo Yii::t('orderFlow', '付款金额'); ?>：
                       <font
                           class="red"> <?php echo $payAccount; ?><?php echo Yii::t('orderFlow', '积分'); ?></font></span>
                    </p>

                    <p><b>·</b>
                        <span><?php echo Yii::t('orderFlow', '您的订单商品将会在 2个工作日内发货， 7个工作日内收货，请耐心等待！'); ?></span></p>

                    <p class="curr"><b>·</b>
                        <?php echo CHtml::link(Yii::t('orderFlow', '查看订单详情'), array('/member/order/admin'), array('title' => '查看订单详情')) ?>
                    </p>

                </div>

            <?php else: ?>

                <div class="shopFlsucessBox">
                    <span class="shopflWrongIcon"><?php echo Yii::t('orderFlow', '抱歉，订单支付失败！'); ?></span>

                    <p><b>·</b><?php echo $result['errorMsg']; ?>
                        (<?php echo CHtml::link(Yii::t('orderFlow', '返回盖网'), DOMAIN, array('class' => 'ft005aa0')) ?>)
                    </p>

                    <p><b>·</b>
                        <?php echo Yii::t('orderFlow', '如您的账号没有可支付积分，请使用以下方式支付或{jf}后支付。',
                            array('{jf}' => CHtml::link(Yii::t('orderFlow', '充值积分'), $this->createAbsoluteUrl('/member/recharge/index'), array('class' => 'ft005aa0')))); ?>
                    </p>
                </div>
            <?php endif; ?>

            <span class="shopFlsucessJf"><p>
                    <?php //取客服配置
                    $fr_config = $this->getConfig('freightlink');
                    ?>
                    <a target="_blank"
                       href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $fr_config['freightQQ']; ?>&amp;site=qq&amp;menu=yes"
                       title="<?php echo Yii::t('orderFlow','联系客服'); ?>" class="shopflonlinBtn"></a>
                    <?php echo Yii::t('orderFlow','可联系盖网客服解决问题。客服电话'); ?>：<font class="red"><?php echo Tool::getConfig('site', 'phone') ?></font></span>
        </div>
    </div>
    <!-- -----------------主体 End--------------------------->
</div>