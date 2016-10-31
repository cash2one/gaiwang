<div class="main" style="margin-top: 20px;">
    <div class="shopFlGgbox">
        <?php if ($result == 'succeed'): ?>
            <div class="shopFlsucessBox">
                <span class="shopflsucessIcon"><?php echo Yii::t('hotelOrder', '恭喜，您已成功付款！'); ?></span>
                <p>
                    <b>·</b><span><?php echo Yii::t('hotelOrder', '付款金额'); ?>:<font class="red"> <?php echo HtmlHelper::formatPrice($order['total_price']) ?></font></span>
                    <?php if ($order['is_lottery'] == HotelOrder::IS_LOTTERY_YES): ?>
                        <br/><b>·</b><span><?php echo Yii::t('hotelOrder', '抽奖金额'); ?>:<font class="red"> <?php echo HtmlHelper::formatPrice($order['lottery_price']) ?></font></span>
                    <?php endif; ?>
                </p>
                <p class="curr">
                    <b>·</b><?php echo CHtml::link(Yii::t('hotelOrder', '查看订单详情'), $this->createAbsoluteUrl('/member/hotelOrder/index'), array('title' => Yii::t('hotelOrder', '查看订单详情'))) ?>
                </p>
            </div>
        <?php else: ?>
            <div class="shopFlsucessBox">
                <span class="shopflWrongIcon"><?php echo Yii::t('hotelOrder', '抱歉，您付款失败！'); ?></span>
                <p>
                    <b>·</b>
                    <?php echo CHtml::link(Yii::t('hotelOrder', '(返回盖网)'), $this->createAbsoluteUrl('/'), array('class' => 'ft005aa0', 'title' => Yii::t('hotelOrder', '(返回盖网)'))) ?>
                </p>
                <p>
                    <b>·</b>
                    <?php echo Yii::t('hotelOrder', '如您的账号没有可支付积分，请使用以下方式支付或{a}充值积分后支付。',array('{a}'=>'<a class="ft005aa0" title=Yii::t("hotelOrder","充值积分") href="javascript:;"></a>')); ?>
                </p>
            </div>
        <?php endif; ?>
        <span class="shopFlsucessJf">
            <p>
                <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $fr_config['freightQQ']; ?>&amp;site=qq&amp;menu=yes" title="<?php echo Yii::t('hotelOrder', '联系客服'); ?>" class="shopflonlinBtn"></a>
                <?php echo Yii::t('hotelOrder', '可联系盖网客服解决问题。客服电话'); ?>：<font class="red"><?php echo Tool::getConfig('site','phone') ?></font>
            </p>
        </span>
    </div>
</div>