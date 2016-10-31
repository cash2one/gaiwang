<?php
// 切换加盟商视图
$this->breadcrumbs = array(
    Yii::t('sellerFranchiseeGoods', '查看商品') => array('/seller/franchiseeGoods/info')
);
?>
<div class="toolbar">
	<b><?php echo Yii::t('sellerFranchiseeGoods', '查看订单详情');?></b>
</div>

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
	<tbody>
	<tr>
			<th ><?php echo Yii::t('sellerFranchiseeGoods','订单编号');?></th>
			<td ><?php echo $model->code;?></td>

			<th><?php echo Yii::t('sellerFranchiseeGoods','顾客手机');?></th>
			<td><?php echo $model->mobile;?></td>
			
			<th><?php echo Yii::t('sellerFranchiseeGoods','开单方式');?></th>
			<td><b class="red"><?php echo FranchiseeGoodsOrder::getOpentype($model->open_type);?></b></td>
	</tr>

	<tr>
			<th><?php echo Yii::t('sellerFranchiseeGoods','销售总价');?></th>
			<td>￥<?php echo $model->seller_price;?></td>
			
			<th><?php echo Yii::t('sellerFranchiseeGoods','支付总价');?></th>
			<td><b class="red">￥<?php echo $model->pay_price;?></b></td>
			
			<th><?php echo Yii::t('sellerFranchiseeGoods','订单状态');?></th>
			<td><b class="red"><?php echo FranchiseeGoodsOrder::getStatus($model->status);?></b></td>
	</tr>
</tbody></table>


<div class="toolbar">
	<b><?php echo Yii::t('sellerFranchiseeGoods', '顾客信息');?></b>
</div>

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
	<tbody>
	<tr>
			<th ><?php echo Yii::t('sellerFranchiseeGoods','盖网编号');?></th>
			<td ><?php echo $model->member->gai_number;?></td>

			<th><?php echo Yii::t('sellerFranchiseeGoods','用户名');?></th>
			<td><?php echo $model->member->username;?></td>
	</tr>
</tbody></table>



<div class="toolbar">
	<b><?php echo Yii::t('sellerFranchiseeGoods', '商品\服务清单');?></b>
</div>


<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
<tbody>
	<tr>
		<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','商品名称');?></th>
		<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','缩略图');?></th>
		<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','售价');?></th>
		<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','折扣');?></th>
		<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','会员价');?></th>
		<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee','支付金额');?></th>
		<th class="bgBlack" width="5%"><?php echo Yii::t('sellerFranchisee','支付状态');?></th>
		<th class="bgBlack" width="5%"><?php echo Yii::t('sellerFranchisee','购买类型');?></th>
		<th class="bgBlack" width="5%"><?php echo Yii::t('sellerFranchisee','数量');?></th>
	</tr>
							
	<?php foreach ($model->franchiseeGoodsOrderDetails as $data):?>
	<tr class="even">
		<td class="ta_c"><?php echo $data->name;  ?></td>
		<td class="ta_c"><?php echo CHtml::image(IMG_DOMAIN.DS.$data->thumbnail) ;  ?></td>
		<td class="ta_c"><?php echo HtmlHelper::formatPrice($data->seller_price);  ?></td>
		<td class="ta_c"><?php echo $data->discount;  ?></td>
		<td class="ta_c"><?php echo HtmlHelper::formatPrice($data->member_price);  ?></td>
		<td class="ta_c"><b class="red"><?php echo $data->type==FranchiseeGoodsOrderDetail::TYPE_GROUPBUY?Yii::t('sellerFranchisee', '团购商品'):HtmlHelper::formatPrice($data->price);  ?></b></td>
		<td class="ta_c"><b class="red"><?php echo FranchiseeGoodsOrderDetail::getStatus($data->status);  ?></b></td>
		<td class="ta_c"><b class="red"><?php echo FranchiseeGoodsOrderDetail::getType($data->type);  ?></b></td>
		<td class="ta_c"><?php echo $data->quantity;  ?></td>
	</tr>
	<?php endforeach;?>
							
</tbody></table>
				