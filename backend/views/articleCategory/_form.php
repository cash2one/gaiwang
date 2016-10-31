<?php
/* @var $this ArticleCategoryController */
/* @var $model ArticleCategory */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'articleCategory-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'name'); ?>：
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'parent_id'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->dropDownList($model, 'parent_id', ArticleCategory::getTreeCategories(true), array('class' => 'text-input-bj middle')); ?>
        </td>
    </tr>
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'sort'); ?>：
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj middle')); ?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'keywords'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->textArea($model, 'keywords', array('class' => 'text-input-bj middle')); ?>
        </td>
    </tr>
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'description'); ?>：
        </th>
        <td class="even">
            <?php echo $form->textArea($model, 'description', array('class' => 'text-input-bj middle')); ?>
        </td>
    </tr>
    <tr>
        <th class="odd"></th>
        <td class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('articleCategory', '添加') : Yii::t('articleCategory', '编辑'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>