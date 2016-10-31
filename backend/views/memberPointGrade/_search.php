<?php
/* @var $this MemberGradeController */
/* @var $model MemberGrade */
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
            <th align="right"><?php echo $form->label($model, 'grade_name'); ?>：</th>
            <td><?php echo $form->textField($model, 'grade_name', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th align="right"><?php echo $form->label($model, 'grade_point'); ?>：</th>
            <td><?php echo $form->textField($model, 'grade_point', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <?php echo CHtml::submitButton(Yii::t('MemberPointGrade','搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>

</div>