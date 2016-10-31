<script type="text/javascript">
var SUCCESS_CONTENT = "<?php echo Yii::t('sellerFranchisee', '发送成功');?>";
var ERROR_CONTENT = "<?php echo Yii::t('sellerFranchisee', '发送失败');?>";
var VERIFY_SUCCESS_CONTENT = "<?php echo Yii::t('sellerFranchisee', '验证成功');?>";
var VERIFY_ERROR_CONTENT = "<?php echo Yii::t('sellerFranchisee', '	验证码不正确');?>！";
var VERIFY_ERROR_CONTENT_TWO = "<?php echo Yii::t('sellerFranchisee', '网络异常，请重试！');?>！";

function reSendSms(id)
{
	var url = '<?php echo $this->createUrl('resendSms',array('id'=>''))?>'+id;
	var dialog = art.dialog({
        content: '<?php echo Yii::t('sellerFranchisee', '确定重发短信吗')."？"?>',
        ok: function(){
        		$.get(url,function(data){
            			var curContent,icon;
						if(data == 1)
						{
							curContent = SUCCESS_CONTENT;
							icon = 'succeed';
						}
						else
						{
							curContent = ERROR_CONTENT;
							icon = 'error';
						}
						dialog.close();
						_myTip(curContent,icon);
            		});
        		return false;
            },
        cancel: true
    });
	return false;
}

function verifyConsumed(id)
{
	var dialog = art.dialog({
        title: '<?php echo Yii::t('sellerFranchisee', '验证消费')?>',
        content: '<?php echo Yii::t('sellerFranchisee', '验证码')?>：<input type="text" id="verify_code" class="inputtxt1"><br/><div class="errorMessage" id="verify_code_em_" style="display:none"></div>',
        ok:function(){
        		var url = '<?php echo $this->createUrl('verifyConsumed')?>';
        		var verify_code = $("#verify_code").val();
	        	$.get(url,{id:id,verify_code:verify_code},function(data){
	    			var curContent,icon;
					if(data == 1)
					{
						curContent = VERIFY_SUCCESS_CONTENT;
						icon = 'succeed';
						dialog.close();
						_myTip(curContent,icon);
						window.location.reload();
					}
					else if(data == 2)
					{
						curContent = VERIFY_ERROR_CONTENT;
						$("#verify_code_em_").html(curContent).show();
					}
					else
					{
						curContent = VERIFY_ERROR_CONTENT_TWO;
						$("#verify_code_em_").html(curContent).show();
					}
	    		});
				return false;
            },
        cancel:true,
        okVal:'<?php echo Yii::t('sellerFranchisee', '验证')?>',
        lock:true
    });
	return false;
}

function _myTip(content,icon)
{
	art.dialog({
		content:content,
		icon:icon,
		ok:true,
		time:5,
		fixed:true,
		width:200,
		height:60,
		drag: false,
	    resize: false,
		left: '99%',
	    top: '99%'
	});
}
</script>
<div class="toolbar">
	<h3><?php echo Yii::t('sellerFranchisee', '盖网通商城订单详情')?>-<?php echo $model->code?></h3>
</div>
<h3 class="mt10 tableTitle"><?php echo Yii::t('sellerFranchisee', '买家信息')?></h3>
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top:7px;" class="sellerT3">
	<tbody>
		<tr>
				<th width="10%"><?php echo Yii::t('sellerFranchisee', '买家ID')?>：</th>
				<td width="40%"><?php echo $model->member->gai_number?> </td>
				<th width="10%"><?php echo Yii::t('sellerFranchisee', '手机号码')?>：</th>
				<td width="40%"><?php echo $model->phone?></td>
		</tr>
	</tbody>
</table>
<h3 class="mt15 tableTitle"><?php echo Yii::t('sellerFranchisee', '订单信息')?></h3>
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top:7px;" class="sellerT3">
	<tbody>
		<tr>
				<th width="10%"><?php echo Yii::t('sellerFranchisee', '订单编号')?>: </th>
				<td width="40%"><?php echo $model->code?></td>
				<th width="10%"><?php echo Yii::t('sellerFranchisee', '下单时间')?>：</th>
				<td width="40%"> <?php echo date('Y-m-d H:i:s',$model->create_time)?></td>
		</tr>
		<tr>
				<th><?php echo Yii::t('sellerFranchisee', '订单状态')?>：</th>
				<td><?php echo MachineProductOrder::status($model->status)?></td>
				<th><?php echo Yii::t('sellerFranchisee', '支付方式')?>：</th>
				<td><?php echo MachineProductOrder::payType($model->pay_type)?></td>										
		</tr>
		<tr>
				<th><?php echo Yii::t('sellerFranchisee', '支付状态')?>：</th>
				<td><?php echo MachineProductOrder::payStatus($model->pay_status)?> </td>
				<th><?php echo Yii::t('sellerFranchisee', '总价')?>：</th>
				<td><b class="red">
				<?php if($model->symbol == MachineProductOrder::RMB):?>
				￥<?php echo $model->real_price.Yii::t('sellerFranchisee', '元')?>
				<?php elseif ($model->symbol == MachineProductOrder::HKD):?>
				<?php echo $model->real_price.Yii::t('sellerFranchisee', '港元')?>
				<?php endif;?>
				</b></td>										
		</tr>
	</tbody>
</table>
<h3 class="mt15 tableTitle"><?php echo Yii::t('sellerFranchisee', '商品信息')?></h3>
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top:7px;" class="sellerT3">
	<tbody>
		<tr>
				<th width="40%"><?php echo Yii::t('sellerFranchisee', '名称')?></th>
				<th width="10%"><?php echo Yii::t('sellerFranchisee', '零售价')?></th>
				<th width="10%"><?php echo Yii::t('sellerFranchisee', '订单数量')?></th>
				<th width="10%"><?php echo Yii::t('sellerFranchisee', '库存量')?></th>
				<th width="10%"><?php echo Yii::t('sellerFranchisee', '消费状态')?> </th>
				<th width="20%"><?php echo Yii::t('sellerFranchisee', '操作')?></th>
		</tr>
		<?php foreach ($model->machineProductOrderDetail as $detail):?>
		<tr>
				<td>
					<div class="productArr01">
						<a class="img" target="_blank" href="<?php echo $this->createAbsoluteUrl('/goods/view',array('id'=>$detail->product_id))?>">
						<?php echo CHtml::image(MachineFileManage::getUrlById($detail->product_thumbnail_id), $detail->product_name, array('width'=>32,'height'=>32))?>
						</a>
						<?php echo CHtml::link($detail->product_name, $this->createAbsoluteUrl('/goods/view',array('id'=>$detail->product_id)), array('class'=>'name','target'=>'_blank'));?>
					</div>
				</td>
				<td class="ta_c"><b class="red">
				<?php if($model->symbol == MachineProductOrder::RMB):?>
				￥<?php echo $detail->price.Yii::t('sellerFranchisee', '元')?>
				<?php elseif ($model->symbol == MachineProductOrder::HKD):?>
				<?php echo $detail->price.Yii::t('sellerFranchisee', '港元')?>
				<?php endif;?>
				</b></td>
				<td class="ta_c"><?php echo $detail->quantity?></td>		
				<td class="ta_c"><?php echo $detail->machineProduct->stock?></td>
				<td class="ta_c"><b <?php if($detail->is_consumed == MachineProductOrderDetail::IS_CONSUMED_YES):?>style="color:#6C0"<?php else:?>class="orange"<?php endif;?>><?php echo MachineProductOrderDetail::isConsume($detail->is_consumed)?></b></td>
				<td class="ta_c">
					<?php if($detail->is_consumed == MachineProductOrderDetail::IS_CONSUMED_YES):?>
					<span style="color:#6C0">
					<?php echo Yii::t('sellerFranchisee', '消费时间')?>：<?php echo date('Y-m-d H:i:s', $detail->consume_time)?>
					</span>
					<?php else:?>
					<a href="#" class="sellerBtn04" onclick="return verifyConsumed(<?php echo $detail->id?>)"><span><?php echo Yii::t('sellerFranchisee', '验证消费')?></span></a>
					<a href="#" class="sellerBtn04" onclick="return reSendSms(<?php echo $detail->id?>)"><span><?php echo Yii::t('sellerFranchisee', '重发短信')?></span></a>
					<?php endif;?>
				</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>