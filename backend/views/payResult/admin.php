<?php
/* @var $this PayResultController */
/* @var $model PayResultForm */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'payResult-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
<div class="border-info clearfix">
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody>
        <tr>
            <th align="right">
                <?php echo $form->labelEx($model, 'code'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'code', array('size' => 60, 'maxlength' => 64, 'class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model,'code') ?>
            </td>
        </tr>
        <tr>
            <th align="right">
                <?php echo $form->labelEx($model, 'mainCode'); ?>：
            </th>
            <td>
                <?php echo $form->textArea($model, 'mainCode', array('size' => 60, 'maxlength' => 64, 'class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model,'mainCode') ?>(英文逗号分隔，可留空)
            </td>
        </tr>
        <tr>
            <th class="odd"  align="right">
                <?php echo $form->labelEx($model, 'payType'); ?>：
            </th>
            <td class="odd">
                <?php
                $payTypes = Order::payType();
                unset($payTypes[1]);
                unset($payTypes[2]);
                unset($payTypes[10]);
                ?>
                <?php echo $form->radioButtonList($model,'payType',$payTypes,array('separator'=>' ')) ?>
                <?php echo $form->error($model,'payType') ?>
            </td>
        </tr>
        <tr>
            <th align="right">
                <?php echo $form->labelEx($model, 'orderType'); ?>：
            </th>
            <td>
                <?php echo $form->radioButtonList($model,'orderType',$model::OrderType(),array('separator'=>' ')) ?>
                <?php echo $form->error($model,'orderType') ?>
            </td>
        </tr>
         <tr>
            <th align="right">
                <?php echo $form->labelEx($model, 'source'); ?>：
            </th>
            <td>
                <?php echo $form->radioButtonList($model,'source',Order::sourceType(),array('separator'=>' ')) ?>
                <?php echo $form->error($model,'source') ?>
            </td>
        </tr>
        </tbody>
    </table>

    <div class="c10">
    </div>
    <?php echo CHtml::submitButton('提交', array('class' => 'reg-sub')) ?>
</div>
<div class="c10">
    <?php echo CHtml::link('异常支付日志',array('exceptionPay'),array('style'=>'color: rgb(0, 0, 255);')); ?>
</div>
<?php $this->endWidget(); ?>
