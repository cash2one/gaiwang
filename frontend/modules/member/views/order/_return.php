
<form action='<?php echo Yii::app()->createAbsoluteUrl('/member/order/return') ?>' method='post' id='rePurcharseForm'>
    <input type="hidden" id="hdOrderId" name="orderId" />
    <input type="hidden" id="hdDeductFrei" name="deductFrei" />
    <input type="hidden" id="hdResons" name="resons" />
    <input type='hidden' name='YII_CSRF_TOKEN' value="<?php echo Yii::app()->request->csrfToken;?>">
</form>

<div class="return" id="ctxRePurcharse" style='display: none;'>
    <div class='consultReturn'>
        <h2><?php echo Yii::t('memberOrder','此订单只有一次申请退款机会，请慎用！');?></h2>
        <p class="txt"><?php echo Yii::t('memberOrder','经与商家协商同意进行退货，商家扣除{0}元运费后退款。',array('{0}'=>CHtml::textField('freight', '', array('class' => 'integaralIpt4','id'=>'txtDeductFrei','style' => 'width:50px'))));?> <?php //echo CHtml::textField('freight', '', array('class' => 'integaralIpt4','id'=>'txtDeductFrei','style' => 'width:50px')) ?> </p>
        <p class="txt01"><?php echo Yii::t('memberOrder','退货原因');?>: <?php echo CHtml::textField('returnReson', '', array('class' => 'integaralIpt4','id'=>'txtResons','style' => 'width:250px')); ?></p>
    </div>
</div>
