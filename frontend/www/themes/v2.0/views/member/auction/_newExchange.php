<?php
$express  = Express::getExpressUrl();//自助查询网址

?>
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
        <span class="status-des"><?php echo Yii::t('memberOrder', '退换货中'); ?></span>
    </div>
    <div class="operation">
        <b class="order-tip"><?php echo Yii::t('memberOrder', '此商品正进行退换货'); ?></b>
        <?php if($model->return_status == Order::RETURN_STATUS_PENDING || $model->return_status == Order::RETURN_STATUS_AGREE){//退货?>
          <?php echo CHtml::link(Yii::t('memberOrder', '您可以查看退换货记录'), $this->createAbsoluteUrl('exchangeGoods/returnGoods', array('code' => $model->code)), array('class'=>'record-query')); ?>
        <?php }else if($model->refund_status == Order::REFUND_STATUS_PENDING){//退款不退货?>
          <?php echo CHtml::link(Yii::t('memberOrder', '您可以查看退换货记录'), $this->createAbsoluteUrl('exchangeGoods/waitReturnNullGoods', array('id' => $exchange['exchange_id'])), array('class'=>'record-query')); ?>
        <?php }?>
    </div>
    <div class="logistics-info">
        <b class="title"><?php echo Yii::t('memberOrder', '物流信息'); ?></b>
        <?php if($model->express && $model->shipping_code){?>
        <p>
            <span><?php echo Yii::t('memberOrder', '快递公司'); ?>：<?php echo $model->express;?> </span>
            <span class="log-num"><?php echo Yii::t('memberOrder', '运单号'); ?>：<?php echo $model->shipping_code;?> </span>
            <a href="<?php echo $express[$model->express]?>" target="_blank" class="ems-query"><?php echo Yii::t('memberOrder', '点击进入自助查询'); ?></a>
        </p>
        
        <p class="log-tip" id="log-tip"><?php echo Yii::t('memberOrder', '注：以上部分信息来自第三方'); ?></p>
        <p class="log-more"><a href="<?php echo $this->createAbsoluteUrl('exchangeGoods/lookupExpress', array('code' => $model->code, 'type'=>2));?>" target="_blank" class="ems-query" style=" margin-left:0;"><?php echo Yii::t('memberOrder', '点击查看更多物流信息'); ?></a></p>
        <script language="javascript">

		  $(document).ready(function(e) {
			  var url = "<?php echo $this->createUrl('order/getExpressStatus', array('store_name'=>$model->express, 'code'=>$model->shipping_code, 'time'=>time())); ?>";
			  
			  $.getJSON(url, function(data) {
				  if (data.status != 200) {
					  $("#log-tip").before(data.message);
				  } else {
					  var html = '';
					  $.each(data.data, function(i, item) {
						  if(i<3){
							  html += '<p>';
							  html += '<i class="member-icon address"></i> <span>'+ item.time +' '+ item.context + '</span></p>';
						  }
					  });
		  
					  $("#log-tip").before(html);
				  }
			  });	
		  });
					  
		</script>
        <?php }else{?>
        <p class="log-tip"> <?php echo Yii::t('memberOrder', '暂无物流信息'); ?></p>
        <?php }?>
    </div>
</div>