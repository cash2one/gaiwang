<?php
/* @var $this RedActivityTagController */
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
    <?php if( $this->action->id == 'create' || $this->action->id == 'updateName'):?>
    <tr>
        <th><?php echo $form->labelEx($model, 'name'); ?></th>
        <td>
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <?php endif ?>
    <?php if( $this->action->id == 'create' || $this->action->id == 'updateRatio'):?>
    <tr>
        <th class="odd"><?php echo $form->labelEx($model, 'ratio'); ?></th>
        <td>
            <?php echo $form->textField($model, 'ratio', array('class' => 'text-input-bj  middle')); ?> %<span style="color: red">（提示:百分比的比例为0-100,千分比例设置:'0.1',万分比例设置:'0.01'）</span>
            <?php echo $form->error($model, 'ratio'); ?>
        </td>
    </tr>
    <?php endif ?>
    <tr>
        <th></th>
        <td>
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('redActivityTag', '添加') : Yii::t('redActivityTag', '保存'), array('class' => 'regm-sub')); ?>
            <?php if($this->action->id != 'create'): ?>
            <input type="button" value="返回" name="back" class="regm-sub" onclick="javascript:history.go(-1);">
            <?php endif ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
