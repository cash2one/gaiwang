<?php
/* @var $this EnterpriseController */
/* @var $model Enterprise */
/* @var $form CActiveForm */
?>
<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo Yii::t('enterprise', '时间'); ?>：
            </th>
            <td colspan="2">
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
        </tbody></table>
    
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th><?php echo $form->label($model, 'store_name'); ?></th>
                <td><?php echo $form->textField($model, 'store_name', array('class' => 'text-input-bj  least')); ?></td>
                <th><?php echo $form->label($model, 'auditing'); ?></th>
                <td><?php echo $form->radioButtonList($model, 'auditing', EnterpriseLog::getStatus(), array('separator' => '')); ?></td>
            </tr>
        </tbody>
    </table>
    <?php echo CHtml::submitButton(Yii::t('enterprise', '搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>