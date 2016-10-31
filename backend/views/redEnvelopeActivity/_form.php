<?php
/* @var $this RedEnvelopeActivityController */
/* @var $model Activity */
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come" id="tab1">
    <tr>
        <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('redEnvelopeActivity', '基本信息'); ?></th>
    </tr>

    <tr>
        <th width="100" class="odd"><?php echo $form->labelEx($model, 'type'); ?></th>
        <td>
            <?php echo $form->dropDownList($model,'type',Activity::getType()) ?>
            <?php echo $form->error($model, 'type'); ?>
        </td>
    </tr>
    <tr>
        <th width="100" class="odd"><?php echo $form->labelEx($model, 'money'); ?></th>
        <td>
            <?php echo $form->textField($model, 'money', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'money'); ?>
        </td>
    </tr>
    <tr>
        <th width="100" class="odd"><?php echo $form->labelEx($model, 'valid_end'); ?></th>
        <td>
            <?php
            $this->widget('comext.timepicker.timepicker', array(
                'id'=>'Activity_valid_end',
                'model'=>$model,
                'name' => 'valid_end',
                'select'=>'date',
                'htmlOptions' => array(
                    'readonly' => 'readonly',
                    'class' => 'text-input-bj  least readonly',
                )
            ));
            ?>
            <?php echo $form->error($model, 'valid_end'); ?>
        </td>
    </tr>
    <tr>
        <th width="100" class="odd"><?php echo $form->labelEx($model, 'status'); ?></th>
        <td>
            <?php echo $form->radioButtonList($model, 'status', $model::getStatus(), array('separator' => '')); ?>&nbsp;<span style="color: red" >（如为开启状态，则其它同类型活动会停止）</span>
            <?php echo $form->error($model, 'status') ?>
        </td>
    </tr>
    <tr>
        <th></th>
        <td>
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('redEnvelopeActivity', '添加') : Yii::t('redEnvelopeActivity', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
