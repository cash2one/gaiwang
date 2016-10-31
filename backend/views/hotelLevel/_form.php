<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
));
?>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <th width="120px" align="right">
            <?php echo $form->labelEx($model, 'name'); ?>
        </th>
        <td>
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right">
            <?php echo $form->labelEx($model, 'description'); ?>
        </th>
        <td>
            <?php echo $form->textArea($model, 'description', array('class' => 'text-area text-area2')); ?>
            <?php echo $form->error($model, 'description'); ?>
        </td>
    </tr>
    <tr>
        <th width="130px" align="right">
            <?php echo $form->labelEx($model, 'sort'); ?>
        </th>
        <td>
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj short')); ?>
            <font color="red">（此处值越高则越靠前，最高值为255）</font>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('hotelLevel', '新增') : Yii::t('hotelLevel', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
