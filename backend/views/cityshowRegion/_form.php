<?php
/* @var $this CityshowRegionController */
/* @var $model CityshowRegion */
/* @var $form CActiveForm */
?>



<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'cityshowRegion-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('brand', '创建大区 ') : Yii::t('brand', '修改大区'); ?></td>
    </tr>
    <tr>
        <th style="width:220px"><?php echo $form->labelEx($model, 'name'); ?></th>
        <td>
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>

    <tr>
        <th><?php echo $form->labelEx($model, 'sort'); ?></th>
        <td>
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>

    <tr>
        <th><?php echo $form->labelEx($model, 'status'); ?></th>
        <td>
            <?php echo $form->radioButtonList($model, 'status', CityshowRegion::status(), array('separator' => '')); ?>
        </td>
    </tr>
    <tr>
        <th></th>
        <td colspan="2">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('brand', '添加 ') : Yii::t('brand', '编辑'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>

<?php $this->endWidget(); ?>
