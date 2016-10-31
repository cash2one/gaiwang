<?php
/* @var $this RedActivityTagController */
/* @var $model Activity */
/* @var $form CActiveForm */
?>

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
        <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('redCompensation', '基本信息'); ?></th>
    </tr>

    <tr>
        <th>红包类型<span class="required">&nbsp;*</span>:</th>
        <td>
            <?php echo $form->dropDownList($model, 'type',Activity::getStartActivityType(), array('empty' => Yii::t('redCompensation', '请选择类型'),'class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'type'); ?>
        </td>
    </tr>
    <tr>
        <th>红包面额:</th>
        <td id="Coupon_money">0</td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model,'gai_number') ?>:</th>
        <td>
            <?php echo $form->textField($model, 'gai_number', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'gai_number'); ?>
        </td>
    </tr>
    <?php if($this->action->id == 'BatchCreate'):
        foreach ($modelArr as $k => $Coupon ): ?>
        <tr>
            <th><?php echo $form->labelEx($Coupon,'gai_number') ?>:</th>
            <td>
                <?php echo $form->textField($Coupon, "[arr][$k]gai_number", array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($Coupon, "[arr][$k]gai_number"); ?>
            </td>
        </tr>
        <?php endforeach ?>
    <?php endif ?>
    <tr>
        <th> <?php echo $form->checkBox($model, 'choice_sms'); ?> </th>
        <td> 使用自定义短信通知 <?php echo $form->error($model, 'choice_sms'); ?></td>
    </tr>
    <tr style="display: none" id="sms_content">
        <th><?php echo $form->labelEx($model, 'sms_content'); ?>:</th>
        <td>
            <?php echo $form->textArea($model, 'sms_content', array('class' => 'text-input-bj  middle','Placeholder'=>Yii::t('redCompensation','请输入短信内容'))); ?>
            <?php echo $form->error($model, 'sms_content'); ?>
        </td>
    </tr>

    <tr>
        <th></th>
        <td>
            <?php echo CHtml::submitButton( Yii::t('redCompensation', '确定'), array('class' => 'regm-sub')); ?>
            <?php echo CHtml::link(Yii::t('redCompensation', '取消'),$this->createAbsoluteUrl('admin'),array('class' => 'regm-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    $("#Coupon_type").change(function(){
        var type = $('#Coupon_type').val();
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
