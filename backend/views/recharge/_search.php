<?php
/* @var $this RechargeController */
/* @var $model Recharge */
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
            <th><?php echo $form->label($model, 'member_id'); ?></th>
            <td><?php echo $form->textField($model, 'member_id', array('class' => 'text-input-bj  least')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'code'); ?></th>
            <td><?php echo $form->textField($model, 'code', array('class' => 'text-input-bj  least')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'create_time'); ?></th>
            <td>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'create_time',
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
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'status'); ?></th>
            <td><?php echo $form->radioButtonList($model, 'status', Recharge::getStatus(), array('separator' => '', 'empty' => Yii::t('recharge', '全部'))); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'pay_type'); ?></th>
            <td><?php echo $form->radioButtonList($model, 'pay_type', Recharge::getPayType(), array('separator' => '', 'empty' => Yii::t('recharge', '全部'))); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <td><?php echo CHtml::submitButton(Yii::t('recharge', '搜索'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>