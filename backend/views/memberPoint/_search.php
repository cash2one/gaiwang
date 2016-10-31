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
            <th align="right"><?php echo $form->label($model, 'member_id'); ?>：</th>
            <td><?php echo $form->textField($model, 'member_id', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'grade_id') ?></th>
            <td>
                <?php echo $form->dropDownList($model, 'grade_id', CHtml::listData(MemberPointGrade::model()->findAll(), 'id', 'grade_name'), array('empty' => Yii::t('member', '全部'), 'class' => 'text-input-bj')); ?>
            </td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'special_type') ?></th>
            <td>
              <td>
                <?php echo $form->radioButtonList($model, 'special_type', array('0' => Yii::t('member', '否'), '1' => Yii::t('member', '是')), array('empty' => Yii::t('member', '全部'), 'separator' => '')) ?>
            </td>
        </tr>
    </table>
    <?php echo CHtml::submitButton(Yii::t('memberGrade','搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>

</div>