<?php
/* @var $this BitUpdateLogController */
/* @var $model BitUpdateLog */
/* @var $form CActiveForm */
?>
<?php
/* @var $this MemberController */
/* @var $model Member */
/* @var $bankModel BankAccount */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr>
        <th colspan="2" style="text-align: center" class="title-th">
            <?php if ($model->isNewRecord): ?>
                <?php echo Yii::t('member', '添加'); ?>
            <?php else: ?>
                <?php echo Yii::t('member', '修改'); ?>
            <?php endif; ?>
        </th>
    </tr>
    <tr>
        <th style="width: 220px"><?php echo $form->labelEx($model, 'content'); ?></th>
        <td>
            <?php echo $form->textArea($model, 'content', array('class' => 'text-input-bj','rows'=>'10','cols'=>'180')) ?>
            <?php echo $form->error($model, 'content') ?>
        </td>
    </tr>
    <tr>
        <th style="width: 220px"><?php echo $form->labelEx($model, 'code'); ?></th>
        <td>
            <?php echo $form->textArea($model, 'code', array('class' => 'text-input-bj','rows'=>'10','cols'=>'180')) ?>
            <?php echo $form->error($model, 'code') ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'dev') ?></th>
        <td>
            <?php echo $form->textField($model, 'dev', array('class' => 'text-input-bj middle')) ?>
            <?php echo $form->error($model, 'dev') ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'test'); ?></th>
        <td>
            <?php echo $form->textField($model, 'test', array('class' => 'text-input-bj middle')) ?>
            <?php echo $form->error($model, 'test') ?>
        </td>
    </tr>
    <tr>
        <th></th>
        <td><?php echo CHtml::submitButton($model->isNewRecord?Yii::t('member', '添加'):Yii::t('member', '更新'), array('class' => 'reg-sub')) ?></td>
    </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>