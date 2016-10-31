<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'interest-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    )
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('interest', '增加兴趣爱好') : Yii::t('interest', '修改兴趣爱好'); ?></td>
    </tr>
    <tr>
        <th width="25%" class="odd"><?php echo $form->labelEx($model, 'name'); ?></th>
        <td class="odd">
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <tr>
        <th class="even"><?php echo $form->labelEx($model, 'category_id'); ?></th>
        <td class="even">
            <?php echo $form->dropDownList($model, 'category_id', InterestCategory::model()->getCategoryList(), array('class' => 'text-input-bj middle valid')); ?>
        </td>
    </tr>
    <tr>
        <th class="odd"></th>
        <td class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('interest', '创建') : Yii::t('interest', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
