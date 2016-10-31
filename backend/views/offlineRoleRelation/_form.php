<?php
$this->breadcrumbs = array(
    Yii::t('offlineRole', '线下角色') => array('admin'),
    $model->isNewRecord ? Yii::t('offlineRole', '新增') : Yii::t('offlineRole', '修改')
);
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'offlineRole-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => false,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('offlineRole', '添加角色') : Yii::t('offlineRole', '修改角色'); ?></td></tr></tbody>
    <tbody>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'role_name'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'role_name', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'role_name'); ?>
            </td>
        </tr>
        <tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'rate'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'rate', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'rate'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"></th>
            <td colspan="2" class="odd">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('offlineRole', '新增') : Yii::t('offlineRole', '保存'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>