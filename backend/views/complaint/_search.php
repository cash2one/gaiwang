<?php
/* @var $this ComplaintController */
/* @var $model Complaint */
/* @var $form CActiveForm */
?>
<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th align="right"><?php echo $form->label($model, 'linkman'); ?>：</th>
            <td><?php echo $form->textField($model, 'linkman', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th align="right"><?php echo $form->label($model, 'mobile'); ?>：</th>
            <td><?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <?php echo CHtml::submitButton(Yii::t('brand', '搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>
