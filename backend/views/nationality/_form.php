<?php
/** @var CActiveForm $form */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'nationality-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <th width="120px"><?php echo $form->labelEx($model, 'name'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'sort'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('nationality', '新增') : Yii::t('nationality', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr> 
</table>
<?php $this->endWidget(); ?>