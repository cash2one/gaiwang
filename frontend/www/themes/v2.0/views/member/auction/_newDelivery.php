<?php
$express  = Express::getExpressUrl();//自助查询网址
$singTime = date('Y-m-d H:i:s', $model->delivery_time + $model->auto_sign_date*86400);//自动签收时间
?>
<div class="steps">
    <ul class="clearfix">
        <li class="step-item"><?php echo Yii::t('memberOrder', '确认订单'); ?><i class="member-icon step-sep"></i></li>  
        <li class="step-item"><?php echo Yii::t('memberOrder', '付款'); ?><i class="member-icon step-sep"></i></li>  
        <li class="step-item active"><?php echo Yii::t('memberOrder', '商家已经发货'); ?><i class="member-icon step-sep"></i></li>
        <li class="step-item"><?php echo Yii::t('memberOrder', '确认收货'); ?><i class="member-icon step-sep"></i></li>
        <li class="step-item"><?php echo Yii::t('memberOrder', '评价'); ?></li>
    </ul>
</div>
<div class="deal-time clearfix">
    <span><?php echo $this->format()->formatDatetime($model->create_time); ?></span>
    <span><?php echo $this->format()->formatDatetime($model->pay_time); ?></span>
    <span><?php echo $this->format()->formatDatetime($model->delivery_time); ?></span>
</div>
<div class="step-description">
    <i class="member-icon angle angle-03"></i>
    <div class="order-status">
        <span class="title"><?php echo Yii::t('memberOrder', '订单状态'); ?></span>
        <span class="status-des"><?php echo Yii::t('memberOrder', '商家已经发货，等待买家确认'); ?></span>
    </div>
    <div class="operation">
        <b class="order-tip"><?php echo $singTime; ?> <?php echo Yii::t('memberOrder', '订单将自动确认收货'); ?></b>
        <p class="tip"><?php echo Yii::t('memberOrder', '请收到货后仔细检查再确认收货，您一旦确认收货，则不能申请退换货服务。'); ?></p>
        <?php if($model->return_status == Order::RETURN_STATUS_NONE || $model->return_status == Order::RETURN_STATUS_FAILURE || $model->return_status == Order::RETURN_STATUS_CANCEL){?>
            <span><?php echo Yii::t('memberOrder', '您可以'); ?></span>
          <?php echo CHtml::link(Yii::t('memberOrder', '确认收货'), '#', array('data_code' => $model->code, 'class' => 'confirm-btn', 'id'=>'signOrder2')); ?>
        <?php }?>
        <?php if(!OrderExchange::checkOrderStatus($model->id) && OrderExchange::checkOrderCount($model->id)) echo CHtml::link(Yii::t('memberOrder', '申请退款/退货'), array('/member/exchangeGoods/BackGoods', 'code' => $model->code), array('class' => 'apply-btn'));?>
    </div>
    <div class="logistics-info">
        <b class="title"><?php echo Yii::t('memberOrder', '物流信息'); ?></b>
        <p>
            <span><?php echo Yii::t('memberOrder', '快递公司'); ?>：<?php echo $model->express;?></span>
            <span class="log-num"><?php echo Yii::t('memberOrder', '运单号'); ?>：<?php echo $model->shipping_code;?></span>
            <?php if($model->express != ''){?>
            <a href="<?php echo $express[$model->express]?>" target="_blank" class="ems-query"><?php echo Yii::t('memberOrder', '点击进入自助查询'); ?></a>
            <?php }?>
        </p>

        <p class="log-tip" id="log-tip"><?php echo Yii::t('memberOrder', '注：以上部分信息来自第三方'); ?></p>
        <p class="log-more"><a href="<?php echo $this->createAbsoluteUrl('exchangeGoods/lookupExpress', array('code' => $model->code, 'type'=>2));?>" target="_blank" class="ems-query" style=" margin-left:0;"><?php echo Yii::t('memberOrder', '点击查看更多物流信息'); ?></a></p>
    </div>
</div>
<script language="javascript">
//ajax 签收订单
$("#signOrder2").click(function() {
	var order_code = $(this).attr("data_code");
	
	layer.confirm('<?php echo Yii::t('memberOrder', '你确定要签收该订单么？'); ?>', {
		btn: ['<?php echo Yii::t('memberOrder', '确定'); ?>','<?php echo Yii::t('memberOrder', '取消'); ?>'], //按钮
		shade: false, //不显示遮罩
	    offset: 'auto'
	}, function(){
		//layer.load();
		$.ajax({
			type: "POST",
			url: "<?php echo $this->createAbsoluteUrl('order/sign') ?>",
			data: {
				"YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
				"code": order_code
			},
			success: function(msg) {
				layer.alert(msg);
				location.reload();
			},
			error: function(){
				layer.alert('<?php echo Yii::t('memberOrder', '退换货申请中或退换货成功状态,不能确认收货!'); ?>');
			}
		});
	}, function(){
		layer.closeAll();
	});
});

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