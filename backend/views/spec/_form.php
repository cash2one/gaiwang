<?php
/* @var $this SpecController */
/* @var $model Spec */
/* @var $form CActiveForm */
?>


<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'spec-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
        ));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('spec', '添加商品规格 ') : Yii::t('spec', '修改商品规格'); ?></td>
    </tr>
    <tr><td colspan="2" class="odd"></td></tr>
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'name'); ?>
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'type'); ?>
        </th>
        <td class="odd">
            <?php echo $form->radioButtonList($model, 'type', Spec::type(), array('separator' => '')); ?>
            <?php echo $form->error($model, 'type'); ?>
        </td>
    </tr>
    <tr>
        <th class="even">
            <?php echo $form->labelEx($model, 'sort'); ?>
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd"></th>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('spec', '新增 ') : Yii::t('spec', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>          
<?php $this->endWidget(); ?>