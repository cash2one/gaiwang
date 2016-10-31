<?php 
$this->breadcrumbs = array(
    Yii::t('sellerFranchisee', '加盟商管理'),
    Yii::t('sellerFranchisee', '盖网通商城订单'),
);
?>
<div class="toolbar">
<b><?php echo Yii::t('sellerFranchisee', '盖网通商城订单列表')?></b>
<span><?php echo Yii::t('sellerFranchisee', '盖网通订单数量列表查询')?>。</span>
</div>
<div class="seachToolbar">
<?php
        $form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createAbsoluteUrl($this->route),
            'method' => 'get',
        ));
        ?>
<table width="95%" cellspacing="0" cellpadding="0" border="0" class="sellerT5">
	<tbody>
		<tr>
				
				<td>
					<th width="8%"><?php echo $form->label($model, 'code')?>：</th>
					<td width="15%"><?php echo $form->textField($model, 'code', array('class'=>'inputtxt1', 'style'=>'width:225px;'))?></td>
					<th width="8%"><?php echo $form->label($model, 'phone')?>：</th>
					<td width="15%"><?php echo $form->textField($model, 'phone', array('class'=>'inputtxt1', 'style'=>'width:225px;'))?></td>
					<th width="8%"><?php echo $form->label($model, 'consume_time')?>：</th>
					<td>
					<?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'consume_time',
                            'language' => 'zh_cn',
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                            ),
                            'htmlOptions' => array(
                                'readonly' => 'readonly',
                                'class' => 'inputtxt1',
                                'style' => 'width:160px;'
                            )
                        ));
                    ?>
					&nbsp;-&nbsp;
					<?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'consume_end_time',
                            'language' => 'zh_cn',
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                            ),
                            'htmlOptions' => array(
                                'readonly' => 'readonly',
                                'class' => 'inputtxt1',
                                'style' => 'width:160px;'
                            )
                        ));
                    ?>
					&nbsp;&nbsp;<?php echo CHtml::submitButton(Yii::t('sellerFranchisee', '搜索'), array('class' => 'sellerBtn06','name'=>'')); ?>
					</td>
				</td>
		</tr>
		<tr>
				
				<td>
					<th><?php echo $form->label($model, 'consume_status')?>：</th>
					<td colspan="5">
						<?php 
							echo $form->radioButtonList($model, 'consume_status', CMap::mergeArray(array(''=>Yii::t('sellerFranchisee','全部')), MachineProductOrder::consumeStatus()), array('separator'=>''));
						?>
					</td>
				</td>
		</tr>
	</tbody>
</table>
<?php $this->endWidget(); ?>
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
	<tr>
		<th class="bgBlack" width="20%"><?php echo Yii::t('sellerFranchisee', '订单编号');?></th>
		<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee', '买家手机号');?></th>
		<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee', '会员编号');?></th>
		<th class="bgBlack" width="8%"><?php echo Yii::t('sellerFranchisee', '支付状态');?></th>
		<th class="bgBlack" width="12%"><?php echo Yii::t('sellerFranchisee', '支付时间');?></th>
		<th class="bgBlack" width="8%"><?php echo Yii::t('sellerFranchisee', '订单状态');?></th>
		<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee', '消费状态');?></th>
		<th class="bgBlack" width="12%"><?php echo Yii::t('sellerFranchisee', '消费时间');?></th>
		<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee', '操作');?></th>
	</tr>
	<?php foreach ($lists_data as $key=>$item):?>
	<tr <?php if($key%2):?>class="even"<?php endif;?>>
		<td class="ta_c"><b><?php echo $item->code?></b></td>
		<td class="ta_c"><?php echo $item->phone?></td>
		<td class="ta_c"><?php echo $item->member->gai_number?></td>
		<td class="ta_c"><?php echo MachineProductOrder::payStatus($item->pay_status)?></td>
		<td class="ta_c">2013-10-29 14:06:35</td>
		<td class="ta_c">
			<p><?php echo MachineProductOrder::status($item->status)?></p>
		</td>
		<td class="ta_c">
			<?php if($item->consume_status == MachineProductOrder::CONSUME_STATUS_NO):?>
			<span class="red"><?php echo MachineProductOrder::consumeStatus($item->consume_status)?></span>
			<?php else:?>
			<span><?php echo MachineProductOrder::consumeStatus($item->consume_status)?></span>
			<?php endif;?>
		</td>
		<td class="ta_c"><?php echo ($item->consume_time!=0)?date('Y-m-d H:i:s', $item->consume_time):''?></td>
		<td class="ta_c">
			<p><?php echo CHtml::link(Yii::t('sellerFranchisee', '订单详情'), array('machineOrderDetail','id'=>$item->id))?></p>
		</td>
	</tr>
	<?php endforeach;?>
</table>

<div class="page_bottom clearfix">
<?php
$this->widget('LinkPager', array(
    'pages' => $pager,
    'jump' => false,
    'htmlOptions' => array('class' => 'pagination'),
))
?>
</div>
