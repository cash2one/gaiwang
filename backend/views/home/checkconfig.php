<?php 
//线下自动对账配置 
/* @var $form  CActiveForm */
/* @var $model ShopCashConfigForm */
?>
<style>
   th.title-th  {text-align: center;}
</style>
<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
             <tr>
				<th style="width: 180px">
					<?php echo $form->labelEx($model,'totalCount');?>：
				</th>
				<td>
					<?php echo $form->textField($model, 'totalCount',array('class'=>'text-input-bj  long')); ?>
					<?php echo $form->error($model,'totalCount');?>
				</td>
			</tr>
             <tr>
				<th style="width: 180px">
					<?php echo $form->labelEx($model,'minMoney');?>：
				</th>
				<td>
					<?php echo $form->textField($model, 'minMoney',array('class'=>'text-input-bj  long')); ?>
					<?php echo $form->error($model,'minMoney');?>
				</td>
			</tr>
             <tr>
				<th style="width: 180px">
					<?php echo $form->labelEx($model,'maxMoney');?>：
				</th>
				<td>
					<?php echo $form->textField($model, 'maxMoney',array('class'=>'text-input-bj  long')); ?>
					<?php echo $form->error($model,'maxMoney');?>
				</td>
			</tr>
			<tr>
				<th style="width: 180px">
					<?php echo $form->labelEx($model,'maxRatio');?>：
				</th>
				<td>
					<?php echo $form->textField($model, 'maxRatio',array('class'=>'text-input-bj  long')); ?>%
					<?php echo $form->error($model,'maxRatio');?>
				</td>
			</tr>
			<tr>
				<th style="width: 180px">
					<?php echo $form->labelEx($model,'days');?>：
				</th>
				<td>
					<?php echo $form->textField($model, 'days',array('class'=>'text-input-bj  long')); ?>
					<?php echo $form->error($model,'days');?>
				</td>
			</tr>
            <tr>
                <td colspan="2">
                    <?php echo CHtml::submitButton(Yii::t('home','保存'),array('class'=>'reg-sub'))?>
                </td>
            </tr>
        </tbody>
</table>
<?php $this->endWidget(); ?>
