<style>.tab-come th {
    text-align: center;
}</style>
<div class="form">
<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>
     <script type="text/javascript" src="/js/EMSwitchBox.js"></script>
    <script type="text/javascript">
 $(document).ready(
     function () {
         $('.show-checkbox').EMSwitchBox({ onLabel: '开', offLabel: '关' });
     });
    </script>
    <table width="100%" border="0" class="tab-come" cellspacing="1" cellpadding="0">
        <tbody>
            <tr>
                <th colspan="4" class="title-th even">
                    <?php echo Yii::t('home','密码及注册服务短信'); ?>
                </th>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'phoneVerifyContent');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'phoneVerifyContent',array('class' => 'text-input-bj  text-area','style' => 'height:30px;'))?>
                    <?php echo $form->error($model,'phoneVerifyContent');?>                  
                </td>
                <th style="width: 200px;">
                    <?php echo $form->labelEx($model,'phoneVerifyContentId');?>：  
                </th>
                <td>
                       <?php echo $form->textField($model,'phoneVerifyContentId',array('class' => 'text-input-bj  text-area','style' => 'height:30px;'))?>
                    <?php echo $form->error($model,'phoneVerifyContentId');?>
                </td>
         
               
            </tr>          
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'phonePasswordContent');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'phonePasswordContent',array('class' => 'text-input-bj  text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'phonePasswordContent');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'phonePasswordContentId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'phonePasswordContentId',array('class' => 'text-input-bj  text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'phonePasswordContentId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'phoneDynamicPassContent');?>
                </th>
                <td style="width: 800px">
                    <?php echo $form->textField($model,'phoneDynamicPassContent',array('class' => 'text-input-bj  text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'phoneDynamicPassContent');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'phoneDynamicPassContentId');?>
                </th>
                <td>
                    <?php echo $form->textField($model,'phoneDynamicPassContentId',array('class' => 'text-input-bj  text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'phoneDynamicPassContentId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'addMemberContent');?>：
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'addMemberContent',array('class' => 'text-input-bj  text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'addMemberContent');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'addMemberContentId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'addMemberContentId',array('class' => 'text-input-bj  text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'addMemberContentId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'registerPhoneFailed');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'registerPhoneFailed',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'registerPhoneFailed');?>
                </td>
                 <th style="width: 200px">
                    <?php echo $form->labelEx($model,'registerPhoneFailedId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'registerPhoneFailedId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'registerPhoneFailedId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'registerPhoneSucc');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'registerPhoneSucc',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'registerPhoneSucc');?>
                </td>
                 <th style="width: 200px">
                    <?php echo $form->labelEx($model,'registerPhoneSuccId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'registerPhoneSuccId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'registerPhoneSuccId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'resetPass');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'resetPass',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'resetPass');?>
                </td>
                    <th style="width: 200px">
                    <?php echo $form->labelEx($model,'resetPassId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'resetPassId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'resetPassId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'newMemberContent');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'newMemberContent',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'newMemberContent');?>
                </td>
                    <th style="width: 200px">
                    <?php echo $form->labelEx($model,'newMemberContentId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'newMemberContentId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'newMemberContentId');?>
                </td>
            </tr>
               <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'newMemberNoContent');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'newMemberNoContent',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'newMemberNoContent');?>
                </td>
                    <th style="width: 200px">
                    <?php echo $form->labelEx($model,'newMemberNoContentId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'newMemberNoContentId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'newMemberNoContentId');?>
                </td>
            </tr>
            <tr>
                <th colspan="4" class="title-th even">
                    <?php echo Yii::t('home','商品订单相关短信配置'); ?>
                </th>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'applycash');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'applycash',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'applycash');?>
                </td>
                   <th style="width: 200px">
                    <?php echo $form->labelEx($model,'applycashId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'applycashId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'applycashId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'applycashFail');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'applycashFail',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'applycashFail');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'applycashFailId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'applycashFailId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'applycashFailId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'payOrder');?>：
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'payOrder',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'payOrder');?>
                </td>
                   <th style="width: 200px">
                    <?php echo $form->labelEx($model,'payOrderId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'payOrderId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'payOrderId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'signOrderComGet');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'signOrderComGet',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'signOrderComGet');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'signOrderComGetId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'signOrderComGetId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'signOrderComGetId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'signOrderMemrefGet');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'signOrderMemrefGet',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'signOrderMemrefGet');?>
                </td>
                 <th style="width: 200px">
                    <?php echo $form->labelEx($model,'signOrderMemrefGetId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'signOrderMemrefGetId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'signOrderMemrefGetId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'signOrderMemrefstoreGet');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'signOrderMemrefstoreGet',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'signOrderMemrefstoreGet');?>
                </td>
                  <th style="width: 200px">
                    <?php echo $form->labelEx($model,'signOrderMemrefstoreGetId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'signOrderMemrefstoreGetId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'signOrderMemrefstoreGetId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'cancelSucceedBuyer');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'cancelSucceedBuyer',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'cancelSucceedBuyer');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'cancelSucceedBuyerId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'cancelSucceedBuyerId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'cancelSucceedBuyerId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'refundSucceedBuyer');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'refundSucceedBuyer',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'refundSucceedBuyer');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'refundSucceedBuyerId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'refundSucceedBuyerId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'refundSucceedBuyerId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'repurSucceedBuyer');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'repurSucceedBuyer',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'repurSucceedBuyer');?>
                </td>
                 <th style="width: 200px">
                    <?php echo $form->labelEx($model,'repurSucceedBuyerId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'repurSucceedBuyerId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'repurSucceedBuyerId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'usePrepaidcarSucceed');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'usePrepaidcarSucceed',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'usePrepaidcarSucceed');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'usePrepaidcarSucceedId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'usePrepaidcarSucceedId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'usePrepaidcarSucceedId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'usePrepaidcarSucceed');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'usePrepaidcarSucceed',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'usePrepaidcarSucceed');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'usePrepaidcarSucceedId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'usePrepaidcarSucceedId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'usePrepaidcarSucceedId');?>
                </td>
            </tr>
             <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'recoveryPrepaidcar');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'recoveryPrepaidcar',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'recoveryPrepaidcar');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'recoveryPrepaidcarId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'recoveryPrepaidcarId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'recoveryPrepaidcarId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                     <?php echo $form->labelEx($model,'commentOrder');?>
                </th>
                <td style="width:200px">
                    <?php echo $form->textField($model,'commentOrder',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'commentOrder');?>
                </td>
                <th style="width: 200px">
                     <?php echo $form->labelEx($model,'commentOrderId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'commentOrderId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'commentOrderId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'storeRecon');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'storeRecon',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'storeRecon');?>
                </td>
                 <th style="width: 200px">
                    <?php echo $form->labelEx($model,'storeReconId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'storeReconId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'storeReconId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'sellerNewOrder');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'sellerNewOrder',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'sellerNewOrder');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'sellerNewOrderId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'sellerNewOrderId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'sellerNewOrderId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'storeOrderRightsUnsigned');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'storeOrderRightsUnsigned',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'storeOrderRightsUnsigned');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'storeOrderRightsUnsignedId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'storeOrderRightsUnsignedId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'storeOrderRightsUnsignedId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'storeOrderRightsSigned');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'storeOrderRightsSigned',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'storeOrderRightsSigned');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'storeOrderRightsSignedId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'storeOrderRightsSignedId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'storeOrderRightsSignedId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'memberOrderRights');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'memberOrderRights',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'memberOrderRights');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'memberOrderRightsId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'memberOrderRightsId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'memberOrderRightsId');?>
                </td>
            </tr>
             <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'signReturnMoney');?><span class="required">*</span>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'signReturnMoney',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'signReturnMoney');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'signReturnMoneyId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'signReturnMoneyId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'signReturnMoneyId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'smsTo_13_14');?>
                </th>
                <td>
                    <?php echo $form->textField($model,'smsTo_13_14',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'smsTo_13_14');?>
                </td>
                
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'mobilePrepaidRecharge');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'mobilePrepaidRecharge',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'mobilePrepaidRecharge');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'mobilePrepaidRechargeId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'mobilePrepaidRechargeId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'mobilePrepaidRechargeId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'auctionEndRemindContent');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'auctionEndRemindContent',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'auctionEndRemindContent');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'auctionEndRemindContentId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'auctionEndRemindContentId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'auctionEndRemindContentId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'auctionMorethanAgentPriceRemindContent');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'auctionMorethanAgentPriceRemindContent',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'auctionMorethanAgentPriceRemindContent');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'auctionMorethanAgentPriceRemindContentId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'auctionMorethanAgentPriceRemindContentId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'auctionMorethanAgentPriceRemindContentId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'auctionAgentPriceLackOfBalanceRemindContent');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'auctionAgentPriceLackOfBalanceRemindContent',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'auctionAgentPriceLackOfBalanceRemindContent');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'auctionAgentPriceLackOfBalanceRemindContentId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'auctionAgentPriceLackOfBalanceRemindContentId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'auctionAgentPriceLackOfBalanceRemindContentId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'auctionUnsoldContent');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'auctionUnsoldContent',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'auctionUnsoldContent');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'auctionUnsoldContentId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'auctionUnsoldContentId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'auctionUnsoldContentId');?>
                </td>
            </tr>
            <tr>
                <th colspan="4" class="title-th even">
                    <?php echo Yii::t('home','酒店订单相关短信配置'); ?>
                </th>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderPay');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'hotelOrderPay',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderPay');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderPayId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'hotelOrderPayId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderPayId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderLotterPay');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'hotelOrderLotterPay',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderLotterPay');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderLotterPayId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'hotelOrderLotterPayId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderLotterPayId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderConfirm');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'hotelOrderConfirm',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderConfirm');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderConfirmId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'hotelOrderConfirmId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderConfirmId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderRoomChange');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'hotelOrderRoomChange',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderRoomChange');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderRoomChangeId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'hotelOrderRoomChangeId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderRoomChangeId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderLotterConfirm');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'hotelOrderLotterConfirm',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderLotterConfirm');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderLotterConfirmId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'hotelOrderLotterConfirmId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderLotterConfirmId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderCancle');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'hotelOrderCancle',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderCancle');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderCancleId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'hotelOrderCancleId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderCancleId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderLotterCancle');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'hotelOrderLotterCancle',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderLotterCancle');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderLotterCancleId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'hotelOrderLotterCancleId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderLotterCancleId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderRefund');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'hotelOrderRefund',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderRefund');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderRefundId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'hotelOrderRefundId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderRefundId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderLotterRefund');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'hotelOrderLotterRefund',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderLotterRefund');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderLotterRefundId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'hotelOrderLotterRefundId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderLotterRefundId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                   <?php echo $form->labelEx($model,'hotelOrderCompleteReturn');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'hotelOrderCompleteReturn',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderCompleteReturn');?>
                </td>
                <th style="width: 200px">
                   <?php echo $form->labelEx($model,'hotelOrderCompleteReturnId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'hotelOrderCompleteReturnId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderCompleteReturnId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderCompletePrize');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'hotelOrderCompletePrize',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderCompletePrize');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderCompletePrizeId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'hotelOrderCompletePrizeId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderCompletePrizeId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderCompleteMemref');?>
                </th>
                <td style="width:200px">
                    <?php echo $form->textField($model,'hotelOrderCompleteMemref',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderCompleteMemref');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderCompleteMemrefId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'hotelOrderCompleteMemrefId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderCompleteMemrefId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderComment');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'hotelOrderComment',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderComment');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'hotelOrderCommentId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'hotelOrderCommentId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'hotelOrderCommentId');?>
                </td>
            </tr>
            <tr>
                <th colspan="4" class="title-th even">
                    <?php echo Yii::t('home','其他相关短信配置'); ?>
                </th>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'contributionContent');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'contributionContent',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'contributionContent');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'contributionContentId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'contributionContentId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'contributionContentId');?>
                </td>
            </tr>
             <th colspan="4" class="title-th even">
                    <?php echo Yii::t('home','开店相关短信配置'); ?>
             </th>
             <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'theShopSucc');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'theShopSucc',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'theShopSucc');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'theShopSuccId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'theShopSuccId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'theShopSuccId');?>
                </td>
            </tr>
                                         
            <tr>
                <th colspan="4" class="title-th even">
                    <?php echo Yii::t('home','线下加盟商对账'); ?>
                </th>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'offScoreConsumeMember');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'offScoreConsumeMember',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'offScoreConsumeMember');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'offScoreConsumeMemberId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'offScoreConsumeMemberId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'offScoreConsumeMemberId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'offScoreConsumeRef');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'offScoreConsumeRef',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'offScoreConsumeRef');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'offScoreConsumeRefId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'offScoreConsumeRefId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'offScoreConsumeRefId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'offScoreConsume');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'offScoreConsume',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'offScoreConsume');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'offScoreConsumeId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'offScoreConsumeId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'offScoreConsumeId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'paymentConsume');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'paymentConsume',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'paymentConsume');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'paymentConsumeId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'paymentConsumeId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'paymentConsumeId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'offScoreBizRecon');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'offScoreBizRecon',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'offScoreBizRecon');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'offScoreBizReconId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'offScoreBizReconId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'offScoreBizReconId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'machineOrderConsume');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'machineOrderConsume',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'machineOrderConsume');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'machineOrderConsumeId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'machineOrderConsumeId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'machineOrderConsumeId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'machineOrderConsumeAfterVerify');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'machineOrderConsumeAfterVerify',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'machineOrderConsumeAfterVerify');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'machineOrderConsumeAfterVerifyId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'machineOrderConsumeAfterVerifyId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'machineOrderConsumeAfterVerifyId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'machineRedMoney');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'machineRedMoney',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'machineRedMoney');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'machineRedMoneyId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'machineRedMoneyId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'machineRedMoneyId');?>
                </td>
            </tr>
                  <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'machineRestPass');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'machineRestPass',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'machineRestPass');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'machineRestPassId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'machineRestPassId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'machineRestPassId');?>
                </td>
            </tr>

            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'weixinPay');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'weixinPay',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'weixinPay');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'weixinPayId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'weixinPayId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'weixinPayId');?>
                </td>
            </tr>





            <tr>
                <th colspan="4" class="title-th even">
                    <?php echo Yii::t('home','盖网通抽奖相关短信'); ?>
                </th>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'lotteryChance');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'lotteryChance',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'lotteryChance');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'lotteryChanceId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'lotteryChanceId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'lotteryChanceId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'lotteryWinNone');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'lotteryWinNone',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'lotteryWinNone');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'lotteryWinNoneId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'lotteryWinNoneId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'lotteryWinNoneId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'lotteryWinScore');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'lotteryWinScore',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'lotteryWinScore');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'lotteryWinScoreId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'lotteryWinScoreId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'lotteryWinScoreId');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'lotteryWinGoods');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'lotteryWinGoods',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'lotteryWinGoods');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'lotteryWinGoodsId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'lotteryWinGoodsId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'lotteryWinGoodsId');?>
                </td>
            </tr>
             <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'roolInMoney');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'roolInMoney',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'roolInMoney');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'roolInMoneyId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'roolInMoneyId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'roolInMoneyId');?>
                </td>
            </tr>
               <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'roolOutMoney');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'roolOutMoney',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'roolOutMoney');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'roolOutMoneyId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'roolOutMoneyId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'roolOutMoneyId');?>
                </td>
            </tr>
             <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'gaiVerifyContent');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'gaiVerifyContent',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'gaiVerifyContent');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'gaiVerifyContentId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'gaiVerifyContentId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'gaiVerifyContentId');?>
                </td>
            </tr>
            <tr>
                <th colspan="4" class="title-th even">
                    <?php echo Yii::t('home','售货机相关短信提示内容'); ?>
                </th>
            </tr>
             <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'machinePayFail');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'machinePayFail',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'machinePayFail');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'machinePayFailId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'machinePayFailId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'machinePayFailId');?>
                </td>
            </tr>
              </tr>
             <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'machineShipmentFail');?>
                </th>
                <td style="width:800px">
                    <?php echo $form->textField($model,'machineShipmentFail',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'machineShipmentFail');?>
                </td>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'machineShipmentFailId');?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'machineShipmentFailId',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'machineShipmentFailId');?>
                </td>
            </tr>
            <tr>
                <th colspan="4" class="title-th even">
                    <?php echo Yii::t('home','红包活动短信提示内容'); ?>
                </th>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'redRegister');?>
                </th>
                <td>
                    <?php echo $form->textField($model,'redRegister',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'redRegister');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'shareRegister');?>
                </th>
                <td>
                    <?php echo $form->textField($model,'shareRegister',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'shareRegister');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'offlineRegister');?>
                </th>
                <td>
                    <?php echo $form->textField($model,'offlineRegister',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'offlineRegister');?>
                </td>
            </tr>
            <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'redCompensation');?>
                </th>
                <td>
                    <?php echo $form->textField($model,'redCompensation',array('class' => 'text-input-bj text-area','style' => 'height:30px;'));?>
                    <?php echo $form->error($model,'redCompensation');?>
                </td>
            </tr>

             <tr>
                <th style="width: 200px">
                    <?php echo $form->labelEx($model,'isRedis');?>
                </th>
                <td>
                   <?php echo $form->checkBox($model,'isRedis',array('class' => 'show-checkbox'))?>
                    <?php echo $form->error($model,'isRedis');?>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <?php echo CHtml::submitButton(Yii::t('home','保存'),array('class' => 'reg-sub'))?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php $this->endWidget();?>
</div>