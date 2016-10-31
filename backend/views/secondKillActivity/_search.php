<?php
/* @var $this SecondKillActivityController */
/* @var $model SecondKillActivity */
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
            <th><?php echo $form->label($model, 'category_id'); ?>：</th>
            <td><?php echo $form->dropDownList($model, 'category_id',CHtml::listData($model->getCategoryId(),'id','name'), array('class' => 'listbox')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'status'); ?>：</th>
            <td><?php echo $form->dropDownList($model, 'status', $model->getStatusArray(), array('class' => 'listbox', 'empty'=>'--请选择--')); ?></td>
        </tr>
    </table>
    <div class="c10"></div>
    <?php echo CHtml::submitButton('搜索', array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>
