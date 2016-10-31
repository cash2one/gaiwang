<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>
<div class="border-info clearfix">
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo $form->label($model,'code'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model,'code',array('size'=>60,'maxlength'=>64,'class'=>'text-input-bj  middle')); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo Yii::t('order','商铺名称'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model,'store_id',array('size'=>11,'maxlength'=>11,'class'=>'text-input-bj  least')); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo Yii::t('order','买家会员编码'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model,'member_id',array('size'=>11,'maxlength'=>11,'class'=>'text-input-bj  least')); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo $form->label($model,'create_time'); ?>：
            </th>
            <td colspan="2">
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'beginCreateTime',
                    'select'=>'date',
                ));
                ?> -
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'toCreateTime',
                    'select'=>'date'
                ));
                ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo $form->label($model,'status'); ?>：
            </th>
            <td colspan="2" id="tdOrderStatus">
                <?php echo $form->radioButtonList($model,'status',$model::status(),
                    array('empty'=>array('0'=>Yii::t('order','全部')),'separator'=>'')) ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo $form->label($model,'pay_status'); ?>：
            </th>
            <td id="tdPay">
                <?php echo $form->radioButtonList($model,'pay_status',$model::payStatus(),
                    array('empty'=>array('0'=>Yii::t('order','全部')),'separator'=>'')) ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo $form->label($model,'delivery_status'); ?>：
            </th>
            <td colspan="3" id="tdShipping">
                <?php echo $form->radioButtonList($model,'delivery_status',$model::deliveryStatus(),
                    array('empty'=>array('0'=>Yii::t('order','全部')),'separator'=>'')) ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo $form->labelEx($model,'refund_status'); ?>：
            </th>
            <td id="tdRefund">
                <?php echo $form->radioButtonList($model,'refund_status',$model::refundStatus(),
                    array('empty'=>array(0=>Yii::t('order','全部')),'separator'=>'')) ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo $form->labelEx($model,'return_status'); ?>：
            </th>
            <td colspan="3" id="tdRePurcharse">
                <?php echo $form->radioButtonList($model,'return_status',$model::returnStatus(),
                    array('empty'=>Yii::t('order','全部'),'separator'=>'')) ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo Yii::t('order','订单价格'); ?>：
            </th>
            <td colspan="2">
                <?php echo $form->textField($model,'beginPrice',array('class'=>'text-input-bj  least')); ?> -
                <?php echo $form->textField($model,'toPrice',array('class'=>'text-input-bj  least')); ?>
            </td>
        </tr>
        </tbody></table>
    <div class="c10">
    </div>
    <?php echo CHtml::submitButton('搜索',array('class'=>'reg-sub')) ?>
</div>
<div class="c10">
</div>
<?php $this->endWidget(); ?>
<script>
    $(":input[name$=create]").addClass('least').removeClass('middle');
</script>