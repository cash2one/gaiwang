<?php
/* @var $this AccountFlowController */
/* @var $model AccountFlow */
/* @var $form CActiveForm */
?>

<div class="border-info clearfix">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
          <!--      <th><?php /*echo $form->label($model, 'terminal_number'); */?></th>
                <td><?php /*echo $form->textField($model, 'terminal_number', array('class' => 'text-input-bj  least')); */?></td>-->
                <th><?php echo $form->label($model, 'terminal_transaction_serial_number'); ?></th>
                <td><?php echo $form->textField($model, 'terminal_transaction_serial_number', array('class' => 'text-input-bj  least')); ?></td>
                <th><?php echo $form->label($model, 'status'); ?></th>
                <td><?php echo $form->dropDownList($model, 'status', PosAudit::getProcessType(), array('empty' => '全部',)); ?></td>
            </tr>
            <tr>
                <th><?php echo $form->label($model, 'transaction_time'); ?></th>
                <td>
                    <?php
                        $model->startTime = !empty($model->startTime)?date("Y-m-d",$model->startTime):'';
                        $model->endTime = !empty($model->endTime)?date("Y-m-d",$model->endTime):'';
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'startTime',
                        'language' => 'zh_cn',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => 'readonly',
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
                        ),
                        'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'text-input-bj  least',
                        )
                    ));
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php echo CHtml::submitButton('搜索', array('class' => 'reg-sub','id'=>'serach-btn')); ?>
    <?php $this->endWidget(); ?>
</div>