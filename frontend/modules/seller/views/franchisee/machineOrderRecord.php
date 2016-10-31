<?php
$this->breadcrumbs = array(
		Yii::t('sellerFranchisee', '加盟商') => array('/seller/franchisee/'),
    	Yii::t('sellerFranchisee', '盖网机列表') => array('/seller/franchisee/machineList'),
		Yii::t('sellerFranchisee', '产品交易记录'),
);
?>
<div class="toolbar">
	<b><?php echo $machine_name?></b>
	<span><?php echo Yii::t('sellerFranchisee', '产品交易记录');?></span>
</div>
<?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route,array('mid'=>$_REQUEST['mid'])),
        'method' => 'get',
		'id'	=> 'machine_form',
    ));
?>
<div class="seachToolbar">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sellerT5"S>
		<tr>
				<th><?php echo Yii::t('sellerFranchisee', '下单时间')?>：</th>
					<td>
					<?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'buy_create_time',
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
                            'attribute' => 'buy_end_time',
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
	</table>
</div>
<?php $this->endWidget(); ?>

<div style="clear:both;"></div>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
	<tr>
		<th class="bgBlack" width="20%"><?php echo Yii::t('sellerFranchisee', '商品图片');?></th>
		<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee', '商品名称');?></th>
		<th class="bgBlack" width="10%"><?php echo Yii::t('sellerFranchisee', '订单编号');?></th>
		<th class="bgBlack" width="8%"><?php echo Yii::t('sellerFranchisee', '会员编号');?></th>
		<th class="bgBlack" width="12%"><?php echo Yii::t('sellerFranchisee', '下单时间');?></th>
	</tr>
	<?php foreach ($lists_data as $key=>$item):?>
	<tr <?php if($key%2):?>class="even"<?php endif;?>>
		<td class="ta_c"><b><?php echo CHtml::image(MachineFileManage::getUrlByPath($item->machineFileManage->path),$item->product_name,array('width'=>80,'height'=>'80'))?></b></td>
		<td class="ta_c"><?php echo $item->product_name?></td>
		<td class="ta_c"><?php echo $item->machineProductOrder->code?></td>
		<td class="ta_c"><?php echo $item->machineProductOrder->member->gai_number?></td>
		<td class="ta_c"><?php echo date('Y-m-d H:i:s', $item->machineProductOrder->create_time)?></td>
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