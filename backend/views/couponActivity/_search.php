<div class="border-info clearfix search-form">
	<?php
	    $form = $this->beginWidget('CActiveForm', array(
	        'action' => Yii::app()->createUrl($this->route),
	        'method' => 'get',
	    	'id' => '_search_coupon'
	    ));
	?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="searchTable">
			<tr>
				<th><?php echo Yii::t('sellerCouponActivity', '时间：');?></th>
				<td>
					<?php
	                    $this->widget('comext.timepicker.timepicker', array(
		                    'model' => $model,
		                    'name' => 'valid_start',
		                    'select'=>'date',
		                    'htmlOptions' => array(
		                            'readonly' => 'readonly',
		                            'class' => 'text-input-bj  least readonly',
		                    )
		                ));
					?>
					&nbsp;-
					<?php
						$this->widget('comext.timepicker.timepicker', array(
		                    'model' => $model,
		                    'name' => 'valid_end',
		                    'select'=>'date',
		                    'htmlOptions' => array(
		                            'readonly' => 'readonly',
		                            'class' => 'text-input-bj  least readonly',
		                    )
		                ));
					?>
				</td>
                <th><?php echo $model->getAttributeLabel('storeName')?></th>
                <td>
                    <?php echo $form->textField($model, 'storeName', array('class' => 'text-input-bj')); ?>
                </td>
				<th><?php echo Yii::t('sellerCouponActivity', '关键词：');?></th>
				<td>
					<?php echo $form->textField($model, 'name', array('class' => 'text-input-bj')); ?>
				</td>
				<th><?php echo Yii::t('sellerCouponActivity', '状态：');?></th>
				<td>
					<?php echo $form->radioButtonList($model, 'status', CouponActivity::getCouponStatus(),array('separator' => ' ','onclick' => 'javascript:$("#_search_coupon").submit()')); ?>
				</td>
				<td>
					<?php echo CHtml::submitButton(Yii::t('sellerCouponActivity', '搜索'), array('class' => 'reg-sub')); ?>
				</td>
			</tr>
		</table>
	<?php $this->endWidget(); ?>
</div>