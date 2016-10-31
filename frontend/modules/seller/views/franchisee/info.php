<?php
// 切换加盟商视图
$this->breadcrumbs = array(
    Yii::t('sellerFranchisee', '查看加盟商') => array('/seller/franchisee/info')
);
?>
<div class="toolbar">
	<b><?php echo Yii::t('sellerFranchisee', '查看 {a} 的信息',array('{a}'=>$model->name));?></b>
	<span><?php echo Yii::t('sellerFranchisee','查看当前选定加盟商的基本信息。');?></span>
</div>
<?php echo CHtml::link(Yii::t('info', '编辑加盟商'),Yii::app()->createUrl('/seller/franchisee/update/'),array('class'=>'mt15 btnSellerEditor'));?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
	<tbody><tr>
			<th width="10%"><?php echo Yii::t('sellerFranchisee','商家名称');?></th>
			<td width="90%"><?php echo $model->name;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchisee','商家英文名');?></th>
	<td><?php echo $model->alias_name;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchisee','盖网折扣');?></th>
	<td><?php echo $model->gai_discount;?> %</td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchisee','会员折扣');?></th>
	<td><?php echo $model->member_discount;?> %</td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchisee','地区');?></th>
	<td><?php echo Region::getName($model->province_id,$model->city_id,$model->district_id);?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchisee','地址');?></th>
	<td><?php echo $model->street;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchisee','简介');?></th>
	<td><?php echo $model->summary;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchisee','主营');?></th>
	<td><?php echo $model->main_course;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchisee','商家Logo');?></th>
	<td><img src="<?php echo ATTR_DOMAIN.'/'.$model->logo;?>" width="120" height="120"/></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchisee','手机号码');?></th>
	<td><?php echo $model->mobile;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchisee','QQ');?></th>
	<td><?php echo $model->qq;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchisee','传真');?></th>
	<td><?php echo $model->fax;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchisee','邮政编码');?></th>
	<td><?php echo $model->zip_code;?></td>
</tr>
<tr>
	<th><?php echo Yii::t('sellerFranchisee','盖网机公告');?></th>
	<td><?php echo $model->notice;?></td>
</tr>
<?php if(!empty($infos)){ ?>
	<tr>
	    <th><?php echo Yii::t('store','补充协议记录'); ?></th>
	    <td>
	        <?php echo Yii::t('store','协议签订时间')," : ", date("Y-m-d",$infos->confirm_time) ?>
	        <?php echo CHtml::link(Yii::t('store','查看协议详情'),$toUrl,array('target'=>'_blank')); ?>
	    </td>
	</tr>
<?php } ?>
</tbody></table>
				