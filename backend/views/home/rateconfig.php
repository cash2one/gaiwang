<?php
//汇率配置视图
/* @var $form  CActiveForm */
/* @var $model RefConfigForm */
?>
<style>
    th.title-th  {text-align: center;}
</style>
<?php $form = $this->beginWidget('CActiveForm', $formConfig); ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr>
            <th colspan="2" class="title-th even"><?php echo Yii::t('home', '汇率配置'); ?></th>
        </tr>
        <tr>
            <th style="width: 250px">
                <?php echo $form->labelEx($model, 'hkRate'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'hkRate', array('class' => 'text-input-bj')); ?>
                <?php echo $form->error($model, 'hkRate'); ?><?php echo Yii::t('home', '元RMB'); ?>
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')) ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
