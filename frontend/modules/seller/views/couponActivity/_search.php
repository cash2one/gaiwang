<?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    	'id' => '_search_coupon'
    ));
?>
<div class="seachToolbar">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sellerT5">
		<tr>
			<th><?php echo Yii::t('sellerCouponActivity', '时间：');?></th>
			<td>
				<?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'valid_start',
                        'language' => 'zh_cn',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'inputtxt1',
                            'style' => 'width:35%'
                        )
                    ));
				?>
				&nbsp;-
				<?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'valid_end',
                        'language' => 'zh_cn',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'inputtxt1',
                            'style' => 'width:35%'
                        )
                    ));
				?>
			</td>
			<th><?php echo Yii::t('sellerCouponActivity', '关键词：');?></th>
			<td>
				<?php echo $form->textField($model, 'name', array('class' => 'inputtxt1','style'=>'width:90%;')); ?>
			</td>
			<th><?php echo Yii::t('sellerCouponActivity', '状态：');?></th>
			<td>
				<?php echo $form->radioButtonList($model, 'status', CouponActivity::getCouponStatus(),array('separator' => ' ','onclick' => 'javascript:$("#_search_coupon").submit()')); ?>
				<?php echo $form->radioButtonList($model, 'state', CouponActivity::getCouponState(),array('separator' => ' ','onclick' => 'javascript:$("#_search_coupon").submit()')); ?>
			</td>
			<td>
				<input type="submit" class="sellerBtn06" value="<?php echo Yii::t('sellerCouponActivity', '搜索');?>"/>
			</td>
			<td>
				<?php 
					if ($model->gaiMoney - $model->shopMoney < 0) {
						$href = "javascript:alert('".Yii::t('sellerCouponActivity','授权金额不足，无法创建盖惠券')."')";
					} else {
						$href = Yii::app()->createUrl('/seller/couponActivity/create');
					}
				?>
				<a class="mt15 btnSellerAdd" href="<?php echo $href?>" ><?php echo Yii::t('sellerCouponActivity', '盖惠券')?></a>
			</td>
		</tr>
	</table>
</div>
<?php $this->endWidget(); ?>