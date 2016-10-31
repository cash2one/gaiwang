<?php
/* @var $this StoreController */
/* @var $model Store */
/* @var $form CActiveForm */
?>
<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
    ));
    ?>
<!--	<table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
                <th><?php // echo $form->label($model, 'code');  ?></th>
                <td><?php // echo $form->textField($model, 'code', array('class' => 'text-input-bj  least'));  ?></td>
        </tr>
    </table>-->
<!--    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
                <th><?php // echo $form->label($model, 'status');  ?></th>
                <td><?php // echo $form->radioButtonList($model, 'status', FranchiseeCode::getStatic(), array('separator' => ''));  ?></td>
        </tr>
    </table>   -->
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'create_time'); ?></th>
            <td><?php $this->widget('comext.timepicker.timepicker', array('model' => $model, 'name' => 'create_time')); ?></td>
        </tr>
    </table>     
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'endTime'); ?></th>
            <td><?php $this->widget('comext.timepicker.timepicker', array('model' => $model, 'name' => 'endTime')); ?></td>
        </tr>
    </table>
    <?php echo CHtml::submitButton(Yii::t('store', '搜索'), array('class' => 'reg-sub')); ?>
    <?php if(Yii::app()->user->checkAccess('FranchiseeCode.Create')):?>
    <?php echo CHtml::link(Yii::t('store', '生成'), Yii::app()->controller->createUrl("create"), array('class' => 'reg-sub')); ?>
    <?php endif;?>
    <?php $this->endWidget(); ?>
</div>