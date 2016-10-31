<?php
$this->breadcrumbs = array(
    Yii::t('memberRole', '会员角色管理') => array('admin'),
    $model->isNewRecord ? Yii::t('memberRole', '新增') : Yii::t('memberRole', '修改')
);
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'memberRole-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('memberRole', '添加会员角色') : Yii::t('memberRole', '修改会员角色'); ?></td></tr></tbody>
    <tbody>
        <tr>
            <th style="text-align: center" class="odd">
                <?php echo $form->labelEx($model, 'name'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: center" class="even">
                <?php echo $form->labelEx($model, 'code'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'code', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'code'); ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: center" class="odd">
                <?php echo $form->labelEx($model, 'thumbnail'); ?>
            </th>
            <td class="odd">
                <?php echo $form->fileField($model,'thumbnail'); ?>
                <span style="color: Red;">* </span> <?php echo Yii::t('memberRole', '请上传22X22像素的图片');?><br /><br />
                <?php if(!$model->isNewRecord): ?>
                 <?php echo CHtml::image(ATTR_DOMAIN.'/'.$model->thumbnail) ?>
                <?php endif; ?>
                <?php echo $form->error($model,'thumbnail') ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: center" class="even">
                <?php echo $form->labelEx($model, 'deadline'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'deadline', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'deadline'); ?>
            </td>
        </tr>
        <tr>
            <th style="text-align: center" class="odd">
                <?php echo $form->labelEx($model, 'description'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textArea($model, 'description', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'description'); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="odd">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('memberRole', '新增') : Yii::t('memberRole', '保存'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>