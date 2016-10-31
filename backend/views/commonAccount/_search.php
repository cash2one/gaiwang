<?php
/* @var $this CommonAccountController */
/* @var $model CommonAccount */
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
                <th><?php echo $form->label($model, 'name'); ?></th>
                <td><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  least')); ?></td>
                </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
                <th><?php echo $form->label($model, 'type'); ?></th>
                <td><?php echo $form->radioButtonList($model, 'type', CommonAccount::getType(), array('separator' => '')); ?></td>
                </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
    <?php /** 
        <tr>
                <th><?php echo $form->label($model, 'cash'); ?></th>
                <td>
                    <?php echo $form->textField($model, 'cash', array('class' => 'text-input-bj  least')); ?> -
                    <?php echo $form->textField($model, 'maxMoney', array('class' => 'text-input-bj  least')); ?>
                </td>
            </tr>
        */ ?>
    </table>
    <?php echo CHtml::submitButton(Yii::t('user', '搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>