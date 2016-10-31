<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'link-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    )
        ));
?>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('link', '增加友情链接') : Yii::t('link', '修改友情链接'); ?></td>
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
            <?php echo $form->labelEx($model, 'url'); ?>
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'url', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'url'); ?>
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
        <th class="odd">
            <?php echo $form->labelEx($model, 'position'); ?>
        </th>
        <td class="odd">
            <?php echo $form->radioButtonList($model, 'position', Link::getPositionStatus(), array('separator' => '&nbsp;&nbsp;')); ?>
            <?php echo $form->error($model, 'position'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd"></th>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('link', '新增') : Yii::t('link', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>          
<?php $this->endWidget(); ?>