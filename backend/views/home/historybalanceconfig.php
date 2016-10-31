<?php
/** @var $model HistoryBalanceConfigForm */
/** @var $form CActiveForm */
?>

<?php $form = $this->beginWidget('CActiveForm', $formConfig); ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr>
        <th colspan="2" style="text-align: center" class="title-th">
            <?php echo Yii::t('home', '翼支付'); ?>
        </th>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'bestCardNumbers'); ?></th>
        <td>
            <?php echo $form->textArea($model, 'bestCardNumbers', array('class' => 'text-input-bj','rows'=>10,'cols'=>180)); ?>
            <?php echo $form->error($model, 'bestCardNumbers'); ?>
            (<?php echo Yii::t('home','多张银行卡号以英文逗号分隔') ?>)
        </td>
    </tr>
    <tr>
        <th colspan="2" style="text-align: center" class="title-th">
            <?php echo Yii::t('home', '默认设置'); ?>
        </th>
    </tr>
    <tr>
        <th><?php echo $model->getAttributeLabel('currentPay') ?></th>
        <td>
            <?php echo $form->radioButtonList($model, 'currentPay', HistoryBalanceUse::showPlatform(), array('separator' => ' ')) ?>
        </td>
    </tr>
    <tr>
        <th></th>
        <td>
            <?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
