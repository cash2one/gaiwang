<div class="steps">
    <ul class="clearfix">
        <li class="step-item"><?php echo Yii::t('memberOrder', '确认订单'); ?><i class="member-icon step-sep"></i></li>        
        <li class="step-item active"><?php echo Yii::t('memberOrder', '付款'); ?><i class="member-icon step-sep"></i></li>        
        <li class="step-item"><?php echo Yii::t('memberOrder', '商家已经发货'); ?><i class="member-icon step-sep"></i></li>        
        <li class="step-item"><?php echo Yii::t('memberOrder', '确认收货'); ?><i class="member-icon step-sep"></i></li>  
        <li class="step-item"><?php echo Yii::t('memberOrder', '评价'); ?></li>
    </ul>
</div>
<div class="deal-time clearfix">
    <span><?php echo $this->format()->formatDatetime($model->create_time); ?></span>
    <span><?php echo $this->format()->formatDatetime($model->pay_time); ?></span>
</div>
<div class="step-description">
    <i class="member-icon angle angle-02"></i>
    <div class="order-status">
        <span class="title"><?php echo Yii::t('memberOrder', '订单状态'); ?></span>
        <span class="status-des"><?php echo Yii::t('memberOrder', '买家已付款，等待商家发货'); ?></span>
    </div>
    <div class="operation">
        <b class="order-tip"><?php echo $this->format()->formatDatetime($model->pay_time); ?> <?php echo Yii::t('memberOrder', '订单已付款'); ?></b>
        <br/>
        <?php if(!OrderExchange::checkOrderStatus($model->id) && OrderExchange::checkOrderCount($model->id)){ ?>
        <span><?php echo Yii::t('memberOrder', '您可以'); ?></span>
        <?php echo CHtml::link(Yii::t('memberOrder', '申请退款/退货'), array('/member/exchangeGoods/BackGoods', 'code' => $model->code), array('class' => 'apply-btn'));?>
    <?php } ?>
    </div>
</div>