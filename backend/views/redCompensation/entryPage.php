<?php
$this->breadcrumbs = array(
    '红包充值兑换管理' => array('admin'),
    '录入兑换码'
);
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
        <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('redCompensation', '基本信息'); ?></th>
    </tr>


   <tr>
        <th><?php echo $form->labelEx($model,'money') ?>:</th>
        <td>
            <?php echo $form->textField($model, 'money', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'money'); ?>
        </td>
    </tr> 
       <tr>
        <th><?php echo $form->labelEx($model,'name') ?>:</th>
        <td>
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr> 

    <?php if($this->action->id == 'entryPage'):
        foreach ($modelArr as $k => $Coupon ): ?>
        <tr>
            <th><?php echo $form->labelEx($Coupon,'name') ?>:</th>
            <td>
                <?php echo $form->textField($Coupon, "[arr][$k]name", array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($Coupon, "[arr][$k]name"); ?>
            </td>
        </tr>
        <?php endforeach ?>
    <?php endif ?>


    <tr>
        <th></th>
        <td>
            <?php echo CHtml::submitButton( Yii::t('redCompensation', '确定'), array('class' => 'regm-sub')); ?>
            <?php echo CHtml::link(Yii::t('redCompensation', '取消'),$this->createAbsoluteUrl('ExchangeCode'),array('class' => 'regm-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    $("#ExchangeCode_type").change(function(){
        var type = $('#ExchangeCode_type').val();
        $.get("<?php echo Yii::app()->createUrl('redCompensation/getActivityMoney'); ?>",
            "type=" + type,
            function (data) {
                if(data){
                    $('#Coupon_money').html(data);
                }
            }
        );
    });

    $('#Coupon_choice_sms').change(function(){
       if($('#Coupon_choice_sms').attr("checked")){
           $('#sms_content').show();
       }else{
           $('#sms_content').hide();
           $('#Coupon_sms_content').val('');
       }
    });

</script>

