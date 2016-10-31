<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'interestCategory-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    )
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('interestCategory', '增加兴趣爱好分类') : Yii::t('interestCategory', '修改兴趣爱好分类'); ?></td>
    </tr>
    <tr>
        <th width="25%" class="odd"><?php echo $form->labelEx($model, 'name'); ?></th>
        <td class="odd">
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd"></th>
        <td class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('interestCategory', '创建') : Yii::t('interestCategory', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>

<?php $this->endWidget(); ?>
