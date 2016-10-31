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
            <th><?php echo $form->label($model, 'gai_number'); ?>：</th>
            <td><?php echo $form->textField($model, 'gai_number', array('class' => 'text-input-bj')); ?></td>
        </tr>

    </table>

    <?php echo CHtml::submitButton('搜索', array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>
