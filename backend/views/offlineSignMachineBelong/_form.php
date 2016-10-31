<?php
/* @var $this OfflineSignMachineBelongController */
/* @var $model OfflineSignMachineBelong */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'offline-sign-machine-belong-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo Yii::t('offlineSignMachineBelong', '归属方信息'); ?></td>
    </tr>
    <tr><td colspan="2" class="odd"></td></tr>
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'belong_to'); ?>
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'belong_to', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'belong_to'); ?>
        </td>
    </tr>
    
    <tr>
        <th class="even"></th>
        <td colspan="2" class="even">
            <?php echo CHtml::submitButton(Yii::t('offlineSignMachineBelong', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>

<?php $this->endWidget(); ?>
