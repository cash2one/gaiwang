<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come" id="tab1">
    <tr>
        <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('RedEnvelopeActivity', '基本信息'); ?></th>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'money'); ?></th>
        <td>
            <?php echo $form->textField($model, 'money', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'money'); ?>
        </td>
    </tr>
    <tr>
        <th></th>
        <td>
            <?php echo CHtml::submitButton(Yii::t('RedEnvelopeActivity', '添加'), array('class' => 'reg-sub')); ?>
            <input type="button" value="返回" name="back" class="reg-sub" onclick="javascript:history.go(-1);">            
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
