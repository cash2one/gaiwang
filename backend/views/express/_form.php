<?php $this->breadcrumbs = array(
    Yii::t('express', '物流公司管理') => array('admin'),
    $model->isNewRecord ? Yii::t('express', '创建') : Yii::t('express', '修改')
    ); ?>
<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'express-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true
            ),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('express', '添加物流公司') : Yii::t('express', '修改物流公司'); ?></td></tr></tbody>
    <tbody>
        <tr><th colspan="2" class="odd"></th></tr>
        <tr>
            <th style="width: 220px" class="even"><?php echo $form->labelEx($model, 'name'); ?></th>
            <td class="even">
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"><?php echo $form->labelEx($model, 'code'); ?></th>
            <td class="odd">
                <?php echo $form->textField($model, 'code', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'code'); ?>
            </td>
        </tr>  
        <tr>
            <th class="even"><?php echo $form->labelEx($model, 'url'); ?></th>
            <td class="even">
                <?php echo $form->textField($model, 'url', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'url'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"></th>
            <td class="odd"><?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('express','添加'): Yii::t('express','保存'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>

