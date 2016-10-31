<?php
/* @var $this SpecialTopicController */
/* @var $model SpecialTopic */
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
            <th><?php echo $form->label($model, 'name'); ?>：</th>
            <td><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj')); ?></td>

            <th><?php echo $form->label($model, 'type'); ?>：</th>
            <td><?php echo $form->dropDownList($model, 'type',Activity::getType(), array('empty' => Yii::t('member', '全部'),'class' => 'text-input-bj')); ?></td>

            <th><?php echo $form->label($model, 'status'); ?>：</th>
            <td><?php echo $form->dropDownList($model, 'status',Activity::getStatus(),array('empty' => Yii::t('member', '全部'), 'class' => 'text-input-bj')); ?></td>
        </tr>

    </table>

    <?php echo CHtml::submitButton('搜索', array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>
