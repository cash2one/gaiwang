<?php
/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */
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
            <th><?php echo $form->label($model, 'req_id'); ?></th>
            <td><?php echo $form->textField($model, 'req_id', array('class' => 'text-input-bj  least')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'create_time'); ?></th>
            <td>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'startTime',
                    'language' => 'zh_cn',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'changeMonth' => true,
                        'changeYear' => true,
                    ),
                    'htmlOptions' => array(
                        //'readonly' => 'readonly',
                        'class' => 'text-input-bj  least',
                    )
                ));
                ?> -
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'endTime',
                    'language' => 'zh_cn',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'changeMonth' => true,
                        'changeYear' => true,
                    ),
                    'htmlOptions' => array(
                        //'readonly' => 'readonly',
                        'class' => 'text-input-bj  least',
                    )
                ));
                ?>
            </td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'account_no'); ?></th>
            <td><?php echo $form->textField($model, 'account_no', array('class' => 'text-input-bj  least')); ?></td>
        </tr>
    </table>
    <!--  
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'payment_type'); ?></th>
            <td><?php echo $form->radioButtonList($model, 'payment_type', ThirdPayment::getPaymentType(),  array('empty'=>array('0'=>Yii::t('order','全部')),'separator'=>'')); ?></td>
        </tr>
    </table>
    -->
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <td><?php echo CHtml::submitButton(Yii::t('thirdPayment', '搜索'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>