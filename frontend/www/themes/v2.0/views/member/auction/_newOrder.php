<div class="steps">
    <ul class="clearfix">
        <li class="step-item active"><?php echo Yii::t('memberOrder', '确认订单'); ?><i class="member-icon step-sep"></i></li>     
        <li class="step-item"><?php echo Yii::t('memberOrder', '付款'); ?><i class="member-icon step-sep"></i></li>    
        <li class="step-item"><?php echo Yii::t('memberOrder', '商家已经发货'); ?><i class="member-icon step-sep"></i></li>
        <li class="step-item"><?php echo Yii::t('memberOrder', '确认收货'); ?><i class="member-icon step-sep"></i></li>
        <li class="step-item"><?php echo Yii::t('memberOrder', '评价'); ?></li>
    </ul>
</div>
    
<div class="deal-time clearfix">
    <span><?php echo $this->format()->formatDatetime($model->create_time); ?></span>
</div>
<div class="step-description">
    <i class="member-icon angle angle-01"></i>
    <div class="order-status">
        <span class="title"><?php echo Yii::t('memberOrder', '订单状态'); ?></span>
        <span class="status-des"><?php echo Yii::t('memberOrder', '商品已拍下，等待买家付款'); ?></span>
    </div>
    <div class="operation">
        <b class="order-tip"><?php echo $this->format()->formatDatetime($model->create_time); ?> <?php echo Yii::t('memberOrder', '订单已确认'); ?></b>
        <br/>
        <span><?php echo Yii::t('memberOrder', '您可以'); ?></span>
        <?php echo CHtml::link(Yii::t('memberOrder', '去付款'), array('/order/payv2', 'code' => $model->code), array('class'=>'pay-btn'));?>
        <a href="javascript:void(0)" class="undo-btn" data_code="<?php echo $model->code;?>" id="orderCancel2"><?php echo Yii::t('memberOrder', '取消订单'); ?></a>
    </div>
</div>

<script language="javascript">
//ajax 取消订单
$("#orderCancel2").click(function() {
	var order_code = $(this).attr("data_code");
	
	layer.confirm('<?php echo Yii::t('memberOrder', '你确定要取消该订单么?'); ?>', {
		btn: ['<?php echo Yii::t('memberOrder', '确定'); ?>','<?php echo Yii::t('memberOrder', '取消'); ?>'], //按钮
		shade: false, //不显示遮罩
	    offset: 'auto'
	}, function(){
		//layer.load();
		$.ajax({
			type: "POST",
			url: "<?php echo $this->createAbsoluteUrl('order/cancel') ?>",
			data: {
				"YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
				"code": order_code
			},
			success: function(msg) {
				layer.alert(msg);
				location.reload();
			}
		});
	}, function(){
		layer.closeAll();
	});
});
</script>