<?php 
//企业会员提现配置 视图
/* @var $form  CActiveForm */
/* @var $model RefConfigForm */
?>
<style>
   th.title-th  {text-align: center;}
</style>
<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
             <tr>
                    <th style="width: 250px">
                        <?php echo $form->labelEx($model,'introProportion');?>：
                    </th>
                    <td>
                        <?php echo $form->textField($model, 'introProportion',array('class'=>'text-input-bj  long')); ?>%
                        <?php echo $form->error($model,'introProportion');?>
                    </td>
                </tr>
                <tr>
                    <th style="width: 250px">
                        <?php echo $form->labelEx($model,'sellPercentage');?>：
                    </th>
                    <td>
                        <?php echo $form->textField($model, 'sellPercentage',array('class'=>'text-input-bj  long')); ?>%
                        <?php echo $form->error($model,'sellPercentage');?>
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
