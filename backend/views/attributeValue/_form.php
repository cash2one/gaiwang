<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'attributeValue-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true, //客户端验证
        ),
)); ?>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">

    <tr>
        <th width="120px" align="right" class="odd">
            <?php echo $form->labelEx($model, 'name'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>

    <tr>
        <th width="120px" align="right" class="even">
            <?php echo $form->labelEx($model, 'sort'); ?>：
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj')); ?>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('attributeValue', '新增') : Yii::t('attributeValue', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
