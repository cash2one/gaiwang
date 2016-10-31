<?php
/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('prepaidCard', '代收付管理') => array('admin'),
    Yii::t('prepaidCard', '代付')
);
?>
<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo Yii::t('user', '代付信息'); ?></td></tr></tbody>
    <tbody>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'bank_code'); ?>
            </th>
            <td class="odd">
                <?php echo $form->dropDownList($model,'bank_code',$model::bankList(),array('class'=>'text-input-bj  middle')) ?>
                <?php echo $form->error($model, 'bank_code'); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'account_no'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'account_no', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'account_no'); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="even">
                <?php echo $form->labelEx($model, 'account_name'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'account_name', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'account_name'); ?>
            </td>
        </tr>  
        <tr>
            <th style="width: 220px" class="even">
                <?php echo $form->labelEx($model, 'cardId'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'cardId', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'cardId'); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="even">
                <?php echo $form->labelEx($model, 'mobile'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'mobile'); ?>
            </td>
        </tr>
         <tr>
            <th style="width: 220px" class="even">
                <?php echo $form->labelEx($model, 'amout'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'amout', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'amout'); ?>
            </td>
        </tr>
                <?php echo $form->hiddenField($model, 'payment_type', array('class' => 'text-input-bj middle')); ?>
        <tr>
            <th class="odd"></th>
            <td class="odd"><?php echo CHtml::submitButton(Yii::t('user', '提交'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
