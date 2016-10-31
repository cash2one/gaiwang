<?php
/**
 * @var AdvertController $this
 * @var Advert $model
 */
$this->breadcrumbs = array(
    Yii::t('advert', '广告位') => array('admin'),
    $model->isNewRecord ? Yii::t('advert', '新增') : Yii::t('advert', '修改')
);
?>
<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'advert-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => false,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('advert', '添加广告位') : Yii::t('advert', '修改广告位'); ?></td></tr></tbody>
    <tbody>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'name'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'code'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'code', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'code'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd">
                <?php echo $form->labelEx($model, 'content'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textArea($model, 'content', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'content'); ?>
            </td>
        </tr>
        <tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'type'); ?>
            </th>
            <td class="even">
                <?php echo $form->dropDownList($model, 'type', Advert::getAdvertType(), array('prompt' => '请选择', 'class' => 'text-input-bj')); ?>
                <?php echo $form->error($model, 'type'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd">
                <?php echo $form->labelEx($model, 'status'); ?>
            </th>
            <td class="odd">
                <?php echo $form->radioButtonList($model, 'status', Advert::getAdvertStatus(), array('separator' => '')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </td>
        </tr>
        <tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'width'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'width', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'width'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd">
                <?php echo $form->labelEx($model, 'height'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'height', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'height'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"></th>
            <td colspan="2" class="odd">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('advert', '新增') : Yii::t('advert', '保存'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>