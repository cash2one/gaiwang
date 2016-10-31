<?php
// 切换加盟商视图
$this->breadcrumbs = array(
    Yii::t('sellerFranchiseeGoods', '查看商品') => array('/seller/franchiseeGoods/info')
);
?>
<div class="toolbar">
	<b><?php echo Yii::t('sellerFranchiseeGoods', '查看 {a} 的信息',array('{a}'=>$model->name));?></b>
	<span><?php echo Yii::t('sellerFranchiseeGoods','查看当前选定商品的基本信息。');?></span>
</div>
<?php echo CHtml::link(Yii::t('info', '编辑商品'),Yii::app()->createUrl('/seller/franchiseeGoods/update/'),array('class'=>'mt15 btnSellerEditor'));?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
	<tbody><tr>
			<th width="10%"><?php echo Yii::t('sellerFranchiseeGoods','商品名称');?></th>
			<td width="90%"><?php echo $model->name;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchiseeGoods','商品缩略图');?></th>
	<td><?php echo $model->thumbnail;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchiseeGoods','销售量');?></th>
	<td><?php echo $model->sales_volume;?> %</td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchiseeGoods','商品状态');?></th>
	<td><?php echo $model->status;?> %</td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchiseeGoods','商品内容');?></th>
	<td><?php echo $model->content ;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchiseeGoods','商品注释');?></th>
	<td><?php echo $model->comments;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchiseeGoods','商品得分');?></th>
	<td><?php echo $model->total_score;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchiseeGoods','商品创建时间');?></th>
	<td><?php echo $model->create_time;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchiseeGoods','商品修改时间');?></th>
	<td><?php echo $model->update_time?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchiseeGoods','商品折扣');?></th>
	<td><?php echo $model->discount;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchiseeGoods','会员价格');?></th>
	<td><?php echo $model->member_price;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchiseeGoods','商品价格');?></th>
	<td><?php echo $model->seller_price;?></td>
</tr>
</tbody></table>
				