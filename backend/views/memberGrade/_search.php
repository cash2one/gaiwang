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
            <th align="right"><?php echo $form->label($model, 'name'); ?>：</th>
            <td><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <?php echo CHtml::submitButton(Yii::t('memberGrade','搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>

</div>