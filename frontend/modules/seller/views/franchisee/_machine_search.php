<?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route,array('mid'=>$_REQUEST['mid'])),
        'method' => 'get',
		'id'	=> 'machine_form',
    ));
?>
<div class="seachToolbar">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sellerT5">
		<tr>
				<th width="8%"><label for="FranchiseeConsumptionRecord_gai_number"><?php echo Yii::t('sellerFranchisee','会员编号')?></label>：</th>
				<td width="20%">
					<?php echo $form->textField($model, 'gai_number', array('class' => 'inputtxt1','style'=>'width:90%;')); ?>
				</td>
				<th width="8%"><?php echo Yii::t('sellerFranchisee', '开始时间')?>：</th>
				<td width="20%">
		            <?php  
				    $this->widget('zii.widgets.jui.CJuiDatePicker', array(  
				        'model'=>$model,  
				        'attribute'=>'start_time',  
						'options' => array(
							'dateFormat'=>'yy-m-d', //database save format
						),
				        'htmlOptions'=>array(  
				            'readonly'=>'readonly',  
							'class' => 'inputtxt1',
							'style'	=>'width:90%;',
				        ) ,
						'language' => 'zh_cn', //语言设置中文
				    ));?> 
				</td>
				<th width="8%"><?php echo Yii::t('sellerFranchisee', '结束时间')?>：</th>
				<td width="20%">
					<?php  
				    $this->widget('zii.widgets.jui.CJuiDatePicker', array(  
				        'model'=>$model,  
				        'attribute'=>'end_time',  
						'options' => array(
								'dateFormat'=>'yy-m-d', //database save format
						),
				        'htmlOptions'=>array(  
				            'readonly'=>'readonly',  
							'class' => 'inputtxt1',
							'style'	=>'width:90%;',
				        ) ,
						'language' => 'zh_cn', //语言设置中文
				    ));?> 
				</td>
				<td width="16%"><input type="submit" class="sellerBtn06" value="<?php echo Yii::t('sellerFranchisee', '搜索')?>"/></td>
		</tr>
	</table>
</div>
<?php $this->endWidget(); ?>

<div style="clear:both;"></div>