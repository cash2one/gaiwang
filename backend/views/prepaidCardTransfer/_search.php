<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'card_number'); ?>：</th>
            <td><?php echo $form->textField($model, 'card_number', array('class' => 'text-input-bj')); ?></td>

            <th><?php echo $form->label($model, 'transfer_gw'); ?>：</th>
            <td><?php echo $form->textField($model, 'transfer_gw', array('class' => 'text-input-bj')); ?></td>

            <th><?php echo $form->label($model, 'receiver_gw'); ?>：</th>
            <td><?php echo $form->textField($model, 'receiver_gw', array('class' => 'text-input-bj')); ?></td>

            <th><?php echo $form->label($model, 'status'); ?>：</th>
            <td><?php echo $form->dropDownList($model, 'status',PrepaidCardTransfer::getStatus(),array('empty' => Yii::t('member', '全部'), 'class' => 'text-input-bj')); ?></td>

        </tr>

    </table>

    <?php echo CHtml::submitButton('搜索', array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>
