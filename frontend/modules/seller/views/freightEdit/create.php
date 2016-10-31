<?php
/* @var $this FreightEditController */
/* @var $model FreightEdit */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'freightEdit-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<?php // echo $form->errorSummary($model);  ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
    <tbody>
        <tr>
            <th width="10%"><?php echo $form->labelEx($model, 'old_freight'); ?></th>
            <td width="40%">
                <?php echo HtmlHelper::formatPrice($model->old_freight); ?>
            </td>
        </tr>
        <tr>
            <th width="10%"><?php echo $form->labelEx($model, 'new_freight'); ?></th>
            <td width="40%">
                <?php echo $form->textField($model, 'new_freight', array('class' => 'inputtxt1')); ?>
                <?php echo $form->error($model, 'new_freight'); ?>
            </td>
        </tr>       
        <?php echo $form->hiddenField($model, 'old_freight'); ?>
        <?php echo $form->hiddenField($model, 'order_id'); ?>
        <tr>
            <th width="10%"></th>
            <td> <?php echo CHtml::submitButton(Yii::t('sellerFreightEdit', '编辑'), array('class' => 'sellerBtn06')); ?></td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>