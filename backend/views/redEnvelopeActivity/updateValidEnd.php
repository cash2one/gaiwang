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
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come" id="tab1">
    <tr>
        <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('redEnvelopeActivity', '基本信息'); ?></th>
    </tr>
    <?php if(isset($_GET['status'])): ?>
    <tr>
        <th colspan="2" style="text-align: center" >确定继续派送当前的红包？</th>
    </tr>
    <?php endif ?>
    <tr>
        <th style="text-align: right" >积分红包派发截止日期：</th>
        <td ><?php
                $this->widget('comext.timepicker.timepicker', array(
                    'id'=>'Activity_valid_end',
                    'model'=>$model,
                    'name' => 'valid_end',
                    'select'=>'date',
                    'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'text-input-bj  least readonly',
                    )
                ));?>
            <?php echo $form->error($model,'valid_end'); ?>
        </td>
    </tr>
    <tr>
        <th></th>
        <td>
            <?php echo CHtml::submitButton(Yii::t('redEnvelopeActivity', '更新'), array('class' => 'regm-sub')); ?>
            <input type="button" value="返回" name="back" class="regm-sub" onclick="javascript:history.go(-1);">    
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>