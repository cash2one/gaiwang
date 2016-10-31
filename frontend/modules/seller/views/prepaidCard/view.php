<?php
/* @var $this CardController */
/* @var $model PrepaidCard */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('sellerPrepaidCard', '充值卡') => array('/seller/prepaidCard'),
    Yii::t('sellerPrepaidCard', '详情'),
);
?>
<div class="toolbar">
    <h3><?php echo Yii::t('sellerPrepaidCard', '充值卡详情');?>-<?php echo $model->number; ?></h3>
</div>
<h3 class="mt15 tableTitle"><?php echo Yii::t('sellerPrepaidCard', '充值卡信息');?></h3>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
    <tbody>
        <tr>
            <th width="10%"><?php echo Yii::t('sellerPrepaidCard', '卡号');?></th>
            <td width="30%"><?php echo $model->number; ?></td>
            <th width="10%"><?php echo Yii::t('sellerPrepaidCard', '密码');?></th>
            <td width="50%"><?php echo Tool::authcode($model->password,'DECODE'); ?></td>
        </tr>
        <tr>
            <th><?php echo Yii::t('sellerPrepaidCard', '盖网积分');?></th>
            <td><?php echo $model->value; ?></td>
            <th><?php echo Yii::t('sellerPrepaidCard', '实际金额');?></th>
            <td>￥<?php echo $model->money; ?></td>
        </tr>
        <tr>
            <th><?php echo Yii::t('sellerPrepaidCard', '使用状态');?></th>
            <td>
                <?php if ($model->status == PrepaidCard::STATUS_UNUSED): ?>
                    <span class="sellerRedBg"><?php echo Yii::t('sellerPrepaidCard', '未使用');?></span>
                <?php elseif ($model->status == PrepaidCard::STATUS_USED): ?>
                    <span class="sellerGreenBg"><?php echo Yii::t('sellerPrepaidCard', '已使用');?></span>
                <?php endif; ?>
            </td>
            <th><?php echo Yii::t('sellerPrepaidCard', '是否对账');?></th>
            <td>
                <?php if ($model->is_recon == PrepaidCard::RECON_NO): ?>
                    <span class="sellerRedBg"><?php echo Yii::t('sellerPrepaidCard', '未对账');?></span>
                <?php elseif ($model->is_recon == PrepaidCard::RECON_YES): ?>
                    <span class="sellerGreenBg"><?php echo Yii::t('sellerPrepaidCard', '已对账');?></span>
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>
<h3 class="mt15 tableTitle"><?php echo Yii::t('sellerPrepaidCard', '卖出信息');?></h3>
<?php if ($model->is_recon == PrepaidCard::RECON_YES): ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
        <tbody>
            <tr>
                <th width="10%"><?php echo Yii::t('sellerPrepaidCard', '卖出时间');?></th>
                <td width="90%"><?php if ($model->sale_time): ?><?php echo date('Y-m-d H:i:s', $model->sale_time); ?><?php endif; ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('sellerPrepaidCard', '卖出备注');?></th>
                <td><?php echo $model->sale_remark; ?></td>
            </tr>
        </tbody>
    </table>
    <h3 class="mt15 tableTitle"><?php echo Yii::t('sellerPrepaidCard', '使用者信息');?></h3>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
        <tbody>
            <tr>
                <th width="10%"><?php echo Yii::t('sellerPrepaidCard', '会员编号');?></th>
                <td width="90%"><?php echo $model->member_id ? $model->member->gai_number : ""; ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('sellerPrepaidCard', '使用时间');?></th>
                <td><?php if ($model->use_time): ?><?php echo date('Y-m-d H:i:s', $model->use_time); ?><?php endif; ?></td>
            </tr>
        </tbody>
    </table>
<?php else: ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'prepaidCard-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
        <tbody>
            <tr>
                <th width="10%"><?php echo $form->labelEx($model, 'sale_time'); ?></th>
                <td width="90%">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'sale_time',
                        'language' => 'zh_cn',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'inputtxt1',
                            'value' => $model->sale_time ? date('Y-m-d', $model->sale_time) : ''
                        )
                    ));
                    ?>
                    <?php echo $form->error($model, 'sale_time'); ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $form->labelEx($model, 'sale_remark'); ?></th>
                <td>
                    <?php echo $form->textArea($model, 'sale_remark', array('class' => 'inputtxt1')); ?>
                    <?php echo $form->error($model, 'sale_remark'); ?>
                </td>
            </tr>
        </tbody>
    </table>
    <h3 class="mt15 tableTitle"><?php echo Yii::t('sellerPrepaidCard', '使用者信息');?></h3>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
        <tbody>
            <tr>
                <th width="10%"><?php echo Yii::t('sellerPrepaidCard', '会员编号');?></th>
                <td width="90%"><?php echo $model->member_id ? $model->member->gai_number : ""; ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('sellerPrepaidCard', '使用时间');?></th>
                <td><?php if ($model->use_time): ?><?php echo date('Y-m-d H:i:s', $model->use_time); ?><?php endif; ?></td>
            </tr>
        </tbody>
    </table>
    <div class="profileDo mt15">
        <?php echo CHtml::submitButton(Yii::t('sellerPrepaidCard', '保存'), array('class' => 'sellerInputBtn01', 'style' => 'border:none;')); ?>
    </div>
    <?php $this->endWidget(); ?>
<?php endif; ?>