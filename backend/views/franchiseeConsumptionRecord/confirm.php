<?php 
$this->breadcrumbs=array(
	Yii::t('franchiseeConsumptionRecord', '加盟商管理'),
	Yii::t('franchiseeConsumptionRecord', '加盟商对账确认单 （共 :count 条记录）',array(':count'=>count($records))),
);
?>
<script type="text/javascript">
	$(function(){
		$("#franchisee-batch_confirm-form").submit(function(e){
			  $("#btn_balance").hide();
			  art.dialog({
                  content: '对账中，请勿关闭窗口！',
                  cancel:false,
                  lock:true
              });
			});
		});
</script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'post',
	'id' => 'franchisee-batch_confirm-form',
)); ?>
<div class="border-info clearfix">
<div class="tip attention"><?php echo Yii::t('franchiseeConsumptionRecord', '注意！ 1、一旦确认对账，将不可还原！ 2、注意检查购物消费记录是否正确！3、注意查看应付金额是否正确！ 4、注意查看每一个应付给加盟商的合计是否正确！');?></div>
<input id="btn_balance" type="submit" class="regm-sub" value="确认对账">
</div>
<div class="c10"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-reg2">
		<tr class="tab-reg-title">
			<th><?php echo Yii::t('franchiseeConsumptionRecord', '消费会员');?></th>
			<th><?php echo Yii::t('franchiseeConsumptionRecord', '盖网通折扣');?></th>
			<th><?php echo Yii::t('franchiseeConsumptionRecord', '会员折扣');?></th>
			<th><?php echo Yii::t('franchiseeConsumptionRecord', '账单时间');?></th>
			<th><?php echo Yii::t('franchiseeConsumptionRecord', '消费金额');?></th>
			<th><?php echo Yii::t('franchiseeConsumptionRecord', '分配金额');?></th>
			<th><?php echo Yii::t('franchiseeConsumptionRecord', '应付金额');?></th>
		</tr>
	<?php 
	$check_ids = '';
	foreach ($records as $franchisee_id=>$record):?>
		<tr class="info">
			<td colspan="7"><?php echo Yii::t('franchiseeConsumptionRecord', '加盟商');?>：<span class="span-content"><?php echo $record['franchisee_name']?> </span>
			<?php echo Yii::t('franchiseeConsumptionRecord', '编码');?>：<span class="span-content"><?php echo $record['franchisee_code']?></span> 
			<?php echo Yii::t('franchiseeConsumptionRecord', '手机号码');?>：<span class="span-content"><?php echo $record['franchisee_mobile']?></span> 
			<?php echo Yii::t('franchiseeConsumptionRecord', '地区');?>：<span class="span-content"><?php echo $record['franchisee_province_name'].'&nbsp;'.$record['franchisee_city_name'].'&nbsp;'.$record['franchisee_district_name']?></span></td>
		</tr>
		<?php 
		$total_amount = 0;
		?>
		<?php foreach ($record['children'] as $child):?>
		<tr>
			<td><?php echo $child['gai_number']?></td>
			<td><?php echo $child['gai_discount']?> %</td>
			<td><?php echo $child['member_discount']?> %</td>
			<td><?php echo date('Y-m-d H:i:s',$child['create_time'])?></td>
			<td><span class="jf"> ¥<?php echo $child['spend_money']?> </span></td>
			<td><span class="jf"> ¥<?php echo $child['distribute_money']?> </span></td>
			<td><span class="jf">¥<?php 
			$fenpei_monty = $child['spend_money']-$child['distribute_money'];
			$total_amount += $fenpei_monty;
			$check_ids .= $child['id'].',';
			echo $fenpei_monty;
			?></span></td>
		</tr>
		<?php endforeach;?>
		<tr class="user">
			<td colspan="6">
			</td>
			<td>合计：<span class="jf"> ¥<?php echo $total_amount?> </span></td>
		</tr>
	<?php endforeach;?>
</table>
<?php echo CHtml::hiddenField('record_ids',substr($check_ids,0,strlen($check_ids)-1));?>
<?php $this->endWidget(); ?>