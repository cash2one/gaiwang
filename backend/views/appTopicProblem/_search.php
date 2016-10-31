<?php
/* @var $this AppTopicProblemController */
/* @var $model AppTopicProblem */
/* @var $form CActiveForm */
?>


<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl("AppTopicProblem/Admin",array("life_topic_id"=>$model->life_topic_id)),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
        <tr>
            <th><?php echo $form->label($model, 'name'); ?>：</th>
            <td>
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  least')); ?>
            </td>
            <th><?php echo $form->label($model, 'create_time'); ?>：</th>
            <td>
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'create_time',
                    'select'=>'date',
                ));
                ?> -
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'end_create_time',
                    'select'=>'date'
                ));
                ?>
            </td>
        </tr>
        </tbody>
    </table>
    <?php echo CHtml::submitButton('搜索', array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>
