<?php
/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */

$this->breadcrumbs = array(
    Yii::t('prepaidCard', '积分返还充值卡') => array('index'),
    Yii::t('prepaidCard', '添加')
);
?>
<div class="tip attention">
    积分返还充值卡：会员使用该充值卡充值后，不会自动的从消费会员升级为正式会员！
</div>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'prepaidCard-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo Yii::t('user', '添加充值卡信息'); ?></td></tr></tbody>
    <tbody>
        <tr>
            <th style="width: 220px" class="odd"><?php echo $form->labelEx($model, 'value'); ?>：</th>
            <td class="odd">
                <?php echo $form->textField($model, 'value', array('class' => 'text-input-bj middle')); ?>
                <?php echo $form->error($model, 'value'); ?>
                （单位：1盖网通积分）
            </td>
        </tr>
        <tr>
            <th class="even"></th>
            <td class="even"><?php echo CHtml::submitButton(Yii::t('user', '添加'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
