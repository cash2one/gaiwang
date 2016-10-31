<?php 
//积分兑现配置 视图
/* @var $form  CActiveForm */
/* @var $model CreditsConfigForm */
?>
<style>
   th.title-th  {text-align: center;}
</style>
<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
             <tr>
                    <th style="width: 180px">
                        <?php echo $form->labelEx($model,'scoreCashUnit');?>：
                    </th>
                    <td>
                        <?php echo $form->textField($model, 'scoreCashUnit',array('class'=>'text-input-bj  long')); ?>%
                        <?php echo $form->error($model,'scoreCashUnit');?>
                    </td>
                </tr>
                <tr>
                    <th style="width: 180px">
                        <?php echo $form->labelEx($model,'scoreCashFactorage');?>：
                    </th>
                    <td>
                        <?php echo $form->textField($model, 'scoreCashFactorage',array('class'=>'text-input-bj  long')); ?>%
                        <?php echo $form->error($model,'scoreCashFactorage');?>
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
