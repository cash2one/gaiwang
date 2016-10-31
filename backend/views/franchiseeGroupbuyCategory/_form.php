<?php
/* @var $this FranchiseeGroupbuyCategoryController */
/* @var $model FranchiseeGroupbuyCategory */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id.'-form',
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
            <?php echo $form->dropDownList($model, 'parent_id', FranchiseeGroupbuyCategory::getTreeCategories(TRUE), array('class' => 'text-input-bj middle')); ?>
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
        <th class="odd"></th>
        <td class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('franchiseeGroupbuyCategory', '添加') : Yii::t('franchiseeGroupbuyCategory', '重命名'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>