<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'attribute-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
        ));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <th width="120px" align="right" class="odd">
            <?php echo $form->labelEx($model, 'name'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>

    <tr>
        <th width="120px" align="right" class="even">
            <?php echo $form->labelEx($model, 'show'); ?>：
        </th>
        <td class="even">
            <?php echo $form->radioButtonList($model, 'show', array('0' => Yii::t('attribute', '不显示'), '1' => Yii::t('attribute', '显示')), array('separator' => '&nbsp;&nbsp;', 'value' => $model->show)); ?>
            <?php echo $form->error($model, 'show'); ?>
        </td>
    </tr>

    <tr>
        <th width="120px" align="right" class="odd">
            <?php echo $form->labelEx($model, 'sort'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj')); ?>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>

    <tr>
        <td>
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('attribute', '新增') : Yii::t('attribute', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
