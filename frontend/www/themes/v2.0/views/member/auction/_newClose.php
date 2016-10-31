<div class="step-description status-cancel">
    <div class="order-status">
        <span class="title"><?php echo Yii::t('memberOrder', '订单状态'); ?></span>
        <span class="status-des"><?php echo Yii::t('memberOrder', '订单已关闭'); ?></span>
    </div>
    <div class="operation">
        <b class="order-tip"><?php echo date('Y-m-d H:i:s', $model->close_time);?> <?php echo Yii::t('memberOrder', '订单已关闭'); ?></b>
    </div>
</div>