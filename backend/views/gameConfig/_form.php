<?php
$this->breadcrumbs = array(
    '游戏配置管理',
    '撤销兑换金币'
);
?>

<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'gameConfig-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come" id="tab1">
    <tr>
        <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('redCompensation', '基本信息'); ?></th>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model,'member_id') ?>:</th>
        <td>
            <?php echo $form->textField($model, 'member_id', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'member_id'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model,'expenditure') ?>:</th>
        <td>
            <?php echo $form->textField($model, 'expenditure', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'expenditure'); ?>
        </td>
    </tr>

    <tr>
        <th></th>
        <td>
            <?php echo CHtml::submitButton( Yii::t('redCompensation', '确定'), array('class' => 'regm-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
