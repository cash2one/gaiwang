<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come" id="tab1">
    <tr>
        <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('PrepaidCardTransfer', '基本信息'); ?></th>
    </tr>
    <?php if($this->action->id == 'create' ): ?>
    <tr>
        <th><?php echo $form->labelEx($model, 'card_number'); ?></th>
        <td>
            <?php echo $form->textField($model, 'card_number', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'card_number'); ?>
        </td>
    </tr>
    <?php endif ?>
    <?php if($this->action->id == 'CreateTransfer'): ?>
        <tr>
            <th><?php echo $form->labelEx($model, 'transfer_gw'); ?></th>
            <td>
                <div>
                    <div style="float: left">
                    <?php echo $form->textField($model, 'transfer_gw', array('class' => 'text-input-bj  middle')); ?>
                    </div>
                    <div style="float:left">
                    <?php echo $form->error($model, 'transfer_gw'); ?>
                    </div>
                </div>
                <div style="clear: both">
                (历史余额：<span id="historyMoney"><?php echo $model->history_money?Common::convertSingle($model->history_money,MemberType::MEMBER_OFFICAL):0 ?></span>积分)
                </div>
            </td>
        </tr>
        <tr>
            <th><?php echo $form->labelEx($model, 'value'); ?></th>
            <td>
                <div style="float: left"><?php echo $form->textField($model, 'value', array('class' => 'text-input-bj  middle')); ?></div>
                <div style="float: left"> <?php echo $form->error($model, 'value'); ?></div>
            </td>
        </tr>
    <?php endif ?>
    <tr>
        <th class="odd"><?php echo $form->labelEx($model, 'receiver_gw'); ?></th>
        <td>
            <?php echo $form->textField($model, 'receiver_gw', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'receiver_gw'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd"><?php echo $form->labelEx($model, 'remark'); ?></th>
        <td>
            <?php echo $form->textArea($model, 'remark', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'remark'); ?>
        </td>
    </tr>

    <tr>
        <th></th>
        <td>
            <?php echo  CHtml::submitButton(Yii::t('PrepaidCardTransfer', '添加') , array('class' => 'regm-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>

<?php if($this->action->id == 'CreateTransfer'): ?>
    <script type="text/javascript">
        $('#PrepaidCardTransfer_transfer_gw').change(function(){
            var tr_gw = $('#PrepaidCardTransfer_transfer_gw').val();
            var check = /^GW[0-9]{8}$/;
            if (check.test(tr_gw)) {
                $.post("<?php echo Yii::app()->createAbsoluteUrl('prepaidCardTransfer/getHistoryValue') ?>",{transfer_gw:tr_gw},function(result){
                    $('#historyMoney').html(result);
                });
            }
        });
    </script>
<?php endif ?>
