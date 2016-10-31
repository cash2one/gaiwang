<?php

/**
 * 短信模板配置类
 * @author huabin.hong <huabin.hong@gwitdepartment.com>
 */
class SmsModelConfigForm extends CFormModel
{

    public $phoneVerifyContent;
    public $phonePasswordContent;
    public $phoneDynamicPassContent;
    public $addMemberContent;
    public $newMemberContent;
    public $newMemberNoContent;
    public $registerPhoneFailed;
    public $registerPhoneSucc;
    public $resetPass;
    public $applycash;
    public $applycashFail;
    public $payOrder;
    public $signOrderComGet;
    public $signOrderMemrefGet;
    public $signOrderMemrefstoreGet;
    public $cancelSucceedBuyer;
    public $refundSucceedBuyer;
    public $repurSucceedBuyer;
    public $usePrepaidcarSucceed;
    public $recoveryPrepaidcar; //回收充值卡
    public $createPrepaidcar;
    public $commentOrder;
    public $storeRecon;
    public $sellerNewOrder;
    public $storeOrderRightsUnsigned;
    public $storeOrderRightsSigned;
    public $memberOrderRights;
    public $hotelOrderPay;
    public $hotelOrderLotterPay;
    public $hotelOrderConfirm;
    public $hotelOrderRoomChange;
    public $hotelOrderLotterConfirm;
    public $hotelOrderCancle;
    public $hotelOrderLotterCancle;
    public $hotelOrderRefund;
    public $hotelOrderLotterRefund;
    public $hotelOrderCompleteReturn;
    public $hotelOrderCompletePrize;
    public $hotelOrderCompleteMemref;
    public $hotelOrderComment;
    public $contributionContent;
    public $offScoreConsumeMember;
    public $offScoreConsumeRef;
    public $offScoreConsume;
    public $paymentConsume;
    public $offScoreBizRecon;
    public $lotteryChance;
    public $lotteryWinNone;
    public $lotteryWinScore;
    public $lotteryWinGoods;
    public $machineOrderConsume; //盖网通--格子铺消费后的短信提醒
    public $machineOrderConsumeAfterVerify; //盖网通--格子铺消费验证后的短信提醒
    public $machineRedMoney ; //盖网通注册红包
    public $machineRestPass;
    public $weixinPay;
    public $machineShipmentFail; // 售货机出货失败
    public $isRedis; //是否启用redis
    public $signReturnMoney; //会员签收获得返还金额
    public $redRegister;//红包注册
    public $shareRegister;//分享注册
    public $offlineRegister;//线下注册送红包提示
    public $redCompensation; //红包补偿
    public $smsTo_13_14; //13.14活动短息
    public $theShopSucc; //开店成功信息
    public $mobilePrepaidRecharge;//手机话费或流量充值短信提示
    public $phoneVerifyContentId;
    public $phonePasswordContentId;
    public $phoneDynamicPassContentId;
    public $addMemberContentId;
    public $newMemberContentId;
    public $newMemberNoContentId;
    public $registerPhoneFailedId;
    public $registerPhoneSuccId;
    public $resetPassId;
    public $applycashId;
    public $applycashFailId;
    public $payOrderId;
    public $signOrderComGetId;
    public $signOrderMemrefGetId;
    public $signOrderMemrefstoreGetId;
    public $cancelSucceedBuyerId;
    public $refundSucceedBuyerId;
    public $repurSucceedBuyerId;
    public $usePrepaidcarSucceedId;
    public $recoveryPrepaidcarId;
    public $createPrepaidcarId;
    public $commentOrderId;
    public $storeReconId;
    public $sellerNewOrderId;
    public $storeOrderRightsUnsignedId;
    public $storeOrderRightsSignedId;
    public $memberOrderRightsId;
    public $hotelOrderPayId;
    public $hotelOrderLotterPayId;
    public $hotelOrderConfirmId;
    public $hotelOrderRoomChangeId;
    public $hotelOrderLotterConfirmId;
    public $hotelOrderCancleId;
    public $hotelOrderLotterCancleId;
    public $hotelOrderRefundId;
    public $hotelOrderLotterRefundId;
    public $hotelOrderCompleteReturnId;
    public $hotelOrderCompletePrizeId;
    public $hotelOrderCompleteMemrefId;
    public $hotelOrderCommentId;
    public $contributionContentId;
    public $offScoreConsumeMemberId;
    public $offScoreConsumeRefId;
    public $offScoreConsumeId;
    public $paymentConsumeId;
    public $offScoreBizReconId;
    public $lotteryChanceId;
    public $lotteryWinNoneId;
    public $lotteryWinScoreId;
    public $lotteryWinGoodsId;
    public $machineOrderConsumeId; //盖网通--格子铺消费后的短信提醒
    public $machineOrderConsumeAfterVerifyId; //盖网通--格子铺消费验证后的短信提醒
    public $machineRedMoneyId;
    public $machineRestPassId;
    public $weixinPayId;
    public $signReturnMoneyId; //会员签收获得返还金额
  
    public $machinePayFail; //售货机支付失败
    public $machinePayFailId;
     public $machineShipmentFailId; 
    public $theShopSuccId; //开店成功信息
    public $mobilePrepaidRechargeId;//手机话费或流量充值短信提示
    public $roolOutMoney; //会员转账（转出）
    public $roolOutMoneyId;
    public $roolInMoney; //会员转账（转入）
    public $roolInMoneyId;
    public $gaiVerifyContent; //盖网通短信验证
    public $gaiVerifyContentId;
    
    public $auctionEndRemindContent; //活动结束时的提醒内容
    public $auctionEndRemindContentId;
    public $auctionMorethanAgentPriceRemindContent;//代理出价被超越时的提醒内容
    public $auctionMorethanAgentPriceRemindContentId;
    public $auctionAgentPriceLackOfBalanceRemindContent;//设置了代理价,但是系统出价的时候,发现积分不够扣了,提醒内容
    public $auctionAgentPriceLackOfBalanceRemindContentId;
    public $auctionUnsoldContent;//拍卖活动流拍内容
    public $auctionUnsoldContentId;


    
    public function rules()
    {
        return array(
            array('phoneVerifyContent, phonePasswordContent, phoneDynamicPassContent, addMemberContent,newMemberContent, newMemberNoContent,registerPhoneFailed, registerPhoneSucc, resetPass,
                applycash, applycashFail, payOrder, signOrderComGet, signOrderMemrefGet, signOrderMemrefstoreGet, cancelSucceedBuyer, refundSucceedBuyer, repurSucceedBuyer,
                usePrepaidcarSucceed,recoveryPrepaidcar,createPrepaidcar, commentOrder, storeRecon, sellerNewOrder, storeOrderRightsUnsigned, storeOrderRightsSigned, memberOrderRights,
                hotelOrderPay, hotelOrderLotterPay, hotelOrderConfirm, hotelOrderRoomChange, hotelOrderLotterConfirm, hotelOrderCancle, hotelOrderLotterCancle,machineShipmentFail,
                hotelOrderRefund, hotelOrderLotterRefund, hotelOrderCompleteReturn, hotelOrderCompletePrize, hotelOrderCompleteMemref, hotelOrderComment,roolOutMoney,roolInMoney,gaiVerifyContent,
                contributionContent, offScoreConsumeMember, offScoreConsumeRef, offScoreConsume,paymentConsume, offScoreBizRecon, lotteryChance,machinePayFail,
                lotteryWinNone, lotteryWinScore, lotteryWinGoods, machineOrderConsume, machineOrderConsumeAfterVerify,machineRedMoney,machineRestPass,shareRegister,redRegister,offlineRegister,redCompensation,smsTo_13_14,theShopSucc,mobilePrepaidRecharge,
                auctionEndRemindContent, auctionMorethanAgentPriceRemindContent, auctionAgentPriceLackOfBalanceRemindContent, auctionUnsoldContent,weixinPay', 'required'),
            array('phoneVerifyContent, phonePasswordContent, phoneDynamicPassContent, addMemberContent,newMemberContent, newMemberNoContent, registerPhoneFailed, registerPhoneSucc, resetPass,
                applycash, applycashFail, payOrder, signOrderComGet, signOrderMemrefGet, signOrderMemrefstoreGet, cancelSucceedBuyer, refundSucceedBuyer, repurSucceedBuyer,
                usePrepaidcarSucceed,recoveryPrepaidcar,createPrepaidcar, commentOrder, storeRecon, sellerNewOrder, storeOrderRightsUnsigned, storeOrderRightsSigned, memberOrderRights,
                hotelOrderPay, hotelOrderLotterPay, hotelOrderConfirm, hotelOrderRoomChange, hotelOrderLotterConfirm, hotelOrderCancle, hotelOrderLotterCancle,
                hotelOrderRefund, hotelOrderLotterRefund, hotelOrderCompleteReturn, hotelOrderCompletePrize, hotelOrderCompleteMemref, hotelOrderComment,roolOutMoney,roolInMoney,gaiVerifyContent,
                contributionContent, offScoreConsumeMember, offScoreConsumeRef, offScoreConsume, paymentConsume,offScoreBizRecon, lotteryChance,machinePayFail,machineShipmentFail,
                lotteryWinNone, lotteryWinScore, lotteryWinGoods, machineOrderConsume, machineOrderConsumeAfterVerify,machineRedMoney,machineRestPass,weixinPay,isRedis,signReturnMoney,redRegister,shareRegister,offlineRegister,redCompensation,smsTo_13_14,theShopSucc,mobilePrepaidRecharge,
                auctionEndRemindContent, auctionMorethanAgentPriceRemindContent, auctionAgentPriceLackOfBalanceRemindContent, auctionEndRemindContentId, auctionMorethanAgentPriceRemindContentId, auctionAgentPriceLackOfBalanceRemindContentId, 
                phoneVerifyContentId,phonePasswordContentId, phoneDynamicPassContentId, addMemberContentId, newMemberContentId, newMemberNoContentId, registerPhoneFailedId, registerPhoneSuccId, resetPassId,
                applycashId, applycashFailId, payOrderId, signOrderComGetId, signOrderMemrefGetId, signOrderMemrefstoreGetId, cancelSucceedBuyerId, refundSucceedBuyerId, repurSucceedBuyerId,
                usePrepaidcarSucceedId,recoveryPrepaidcarId,createPrepaidcarId, commentOrderId, storeReconId, sellerNewOrderId, storeOrderRightsUnsignedId, storeOrderRightsSignedId, memberOrderRightsId,
                hotelOrderPayId, hotelOrderLotterPayId, hotelOrderConfirmId, hotelOrderRoomChangeId, hotelOrderLotterConfirmId, hotelOrderCancleId, hotelOrderLotterCancleId,mobilePrepaidRechargeId,
                  hotelOrderRefundId, hotelOrderLotterRefundId, hotelOrderCompleteReturnId, hotelOrderCompletePrizeId, hotelOrderCompleteMemrefId, hotelOrderCommentId,roolOutMoneyId,roolInMoneyId,gaiVerifyContentId
                contributionContentId, offScoreConsumeMemberId, offScoreConsumeRefId, offScoreConsumeId,paymentConsumeId, offScoreBizReconId, lotteryChanceId,machinePayFailId,machineShipmentFailId,
                lotteryWinNoneId, lotteryWinScoreId, lotteryWinGoodsId, machineOrderConsumeId, machineOrderConsumeAfterVerifyId,machineRedMoneyId,machineRestPassId,weixinPayId,theShopSuccId,signReturnMoneyId,auctionUnsoldContent,auctionUnsoldContentId
                ', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'phoneVerifyContent' => Yii::t('home', '短信验证码内容'),
            'phonePasswordContent' => Yii::t('home', '短信临时密码内容'),
            'phoneDynamicPassContent' => Yii::t('home', '短信动态密码内容'),
            'addMemberContent' => Yii::t('home', '添加新会员短信内容'),
            'newMemberContent'=>Yii::t('home','新会员短信内容(有临时密码)'),
            'newMemberNoContent'=>  Yii::t('home','新会员短信内容(无临时密码)'),
            'registerPhoneFailed' => Yii::t('home', '通过短信注册失败'),
            'registerPhoneSucc' => Yii::t('home', '通过短信注册成功'),
            'resetPass' => Yii::t('home', '重设密码短信内容'),
            'applycash' => Yii::t('home', '积分兑换申请'),
            'applycashFail' => Yii::t('home', '积分兑换失败'),
            'payOrder' => Yii::t('home', '支付订单'),
            'signOrderComGet' => Yii::t('home', '签收订单商家提示'),
            'signOrderMemrefGet' => Yii::t('home', '签收订单推荐者提示'),
            'signOrderMemrefstoreGet' => Yii::t('home', '签收订单推荐商家会员提示'),
            'cancelSucceedBuyer' => Yii::t('home', '卖家关闭交易买家提示'),
            'refundSucceedBuyer' => Yii::t('home', '买家退款成功买家提示'),
            'repurSucceedBuyer' => Yii::t('home', '买家退货成功买家提示'),
            'usePrepaidcarSucceed' => Yii::t('home', '充值卡充值'),
            'recoveryPrepaidcar' =>  Yii::t('home','回收充值卡'),
            'createPrepaidcar' => Yii::t('home', '批发充值卡'),
            'commentOrder' => Yii::t('home', '评价订单'),
            'storeRecon' => Yii::t('home', '企业会员对账提示'),
            'sellerNewOrder' => Yii::t('home', '卖家新订单提示'),
            'storeOrderRightsUnsigned' => Yii::t('home', '消费者维权商家提示(未签收)'),
            'storeOrderRightsSigned' => Yii::t('home', '消费者维权商家提示(已签收)'),
            'memberOrderRights' => Yii::t('home', '消费者维权买家提示'),
            'mobilePrepaidRecharge'=> Yii::t('home', '手机话费或流量充值提示'),
            'hotelOrderPay' => Yii::t('home', '酒店订单支付提示'),
            'hotelOrderLotterPay' => Yii::t('home', '酒店订单及抽奖支付提示'),
            'hotelOrderConfirm' => Yii::t('home', '酒店订单确认提示'),
            'hotelOrderRoomChange' => Yii::t('home', '酒店订单换房确认'),
            'hotelOrderLotterConfirm' => Yii::t('home', '酒店订单确认及中奖提示'),
            'hotelOrderCancle' => Yii::t('home', '酒店订单取消提示'),
            'hotelOrderLotterCancle' => Yii::t('home', '酒店订单及抽奖取消提示'),
            'hotelOrderRefund' => Yii::t('home', '酒店订单退订提示'),
            'hotelOrderLotterRefund' => Yii::t('home', '酒店订单及抽奖退订提示'),
            'hotelOrderCompleteReturn' => Yii::t('home', '酒店订单完成返还积分提示'),
            'hotelOrderCompletePrize' => Yii::t('home', '酒店订单完成获得中奖提示'),
            'hotelOrderCompleteMemref' => Yii::t('home', '酒店订单完成推荐者提示'),
            'hotelOrderComment' => Yii::t('home', '酒店订单评价提示'),
            'contributionContent' => Yii::t('home', '爱心捐款短信内容'),
            'offScoreConsumeMember' => Yii::t('home', '线下对账-消费者返回积分'),
            'offScoreConsumeRef' => Yii::t('home', '线下对账-推荐者获得积分'),
            'offScoreConsume' => Yii::t('home', '积分消费扣除积分提醒'),
            'paymentConsume' => Yii::t('home', '银行卡消费提醒'),
            'offScoreBizRecon' => Yii::t('home', '线下对账-加盟商提醒短信'),
            'lotteryChance' => Yii::t('home', '获得抽奖机会提醒'),
            'lotteryWinNone' => Yii::t('home', '未中奖提醒'),
            'lotteryWinScore' => Yii::t('home', '中奖积分提醒'),
            'lotteryWinGoods' => Yii::t('home', '中奖商品提醒'),
            'machineOrderConsume' => Yii::t('home', '格子铺消费后的短信提醒'),
            'machineOrderConsumeAfterVerify' => Yii::t('home', '格子铺消费验证成功后的短信'),
            'machineRedMoney'=>  Yii::t('home','盖网通会员红包'),
            'machineRestPass'=>Yii::t('home','盖网通管理员重置密码'),
            'weixinPay'=>Yii::t('home','微信支付'),
            'isRedis' => Yii::t('home', '是否启用Redis'),
            'signReturnMoney' => Yii::t('home', '会员签收获得返还金额短信提示'),
            'redRegister'=>Yii::t('home', '红包活动注册短信提示'),
            'shareRegister'=>Yii::t('home','分享注册短信提示'),
            'offlineRegister'=>Yii::t('home','线下红包活动注册短信提示'),
            'redCompensation' => Yii::t('home','红包补偿短信提示'),
            'smsTo_13_14' => Yii::t('home','购买13/14活动商品短信'),
            'theShopSucc'=>Yii::t('home','开店成功商家短信'),
            'machinePayFail'=>  Yii::t('home','售货机支付失败提示短信'),
            'machineShipmentFail'=>  Yii::t('home','售货机出货失败退款短信'),
            'auctionEndRemindContent' => Yii::t('home','活动结束时的提醒内容'),
            'auctionMorethanAgentPriceRemindContent' => Yii::t('home','代理出价被超越时的提醒内容'),
            'auctionAgentPriceLackOfBalanceRemindContent' => Yii::t('home','代理价余额不足时的提醒内容'),
            'auctionUnsoldContent' => Yii::t('home','活动商品流拍提醒内容'),
            'auctionEndRemindContentId' => Yii::t('home','活动结束时的提醒内容模板id'),
            'auctionMorethanAgentPriceRemindContentId' => Yii::t('home','代理出价被超越时的提醒内容模板id'),
            'auctionAgentPriceLackOfBalanceRemindContentId' => Yii::t('home','代理价余额不足时的提醒内容模板id'),
            'auctionUnsoldContentId' => Yii::t('home','活动商品流拍提醒内容模板id'),
            'phoneVerifyContentId' => Yii::t('home', '短信验证码内容模板id'),
            'phonePasswordContentId' => Yii::t('home', '短信临时密码内容模板id'),
            'phoneDynamicPassContentId' => Yii::t('home', '短信动态密码内容模板id'),
            'addMemberContentId' => Yii::t('home', '添加新会员短信内容模板id'),
            'newMemberContentId'=>Yii::t('home','新会员短信内容(有临时密码)模板id'),
            'newMemberNoContentId'=>  Yii::t('home','新会员短信内容(无临时密码)模板id'),
            'registerPhoneFailedId' => Yii::t('home', '通过短信注册失败模板id'),
            'registerPhoneSuccId' => Yii::t('home', '通过短信注册成功模板id'),
            'resetPassId' => Yii::t('home', '重设密码短信内容模板id'),
            'applycashId' => Yii::t('home', '积分兑换申请模板id'),
            'applycashFailId' => Yii::t('home', '积分兑换失败模板id'),
            'payOrderId' => Yii::t('home', '支付订单模板id'),
            'signOrderComGetId' => Yii::t('home', '签收订单商家提示模板id'),
            'signOrderMemrefGetId' => Yii::t('home', '签收订单推荐者提示模板id'),
            'signOrderMemrefstoreGetId' => Yii::t('home', '签收订单推荐商家会员提示模板id'),
            'cancelSucceedBuyerId' => Yii::t('home', '卖家关闭交易买家提示模板id'),
            'refundSucceedBuyerId' => Yii::t('home', '买家退款成功买家提示模板id'),
            'repurSucceedBuyerId' => Yii::t('home', '买家退货成功买家提示模板id'),
            'usePrepaidcarSucceedId' => Yii::t('home', '充值卡充值模板id'),
            'createPrepaidcarId' => Yii::t('home', '批发充值卡模板id'),
            'commentOrderId' => Yii::t('home', '评价订单模板id'),
            'storeReconId' => Yii::t('home', '企业会员对账提示模板id'),
            'sellerNewOrderId' => Yii::t('home', '卖家新订单提示模板id'),
            'storeOrderRightsUnsignedId' => Yii::t('home', '消费者维权商家提示(未签收)模板id'),
            'storeOrderRightsSignedId' => Yii::t('home', '消费者维权商家提示(已签收)模板id'),
            'memberOrderRightsId' => Yii::t('home', '消费者维权买家提示模板id'),
            'mobilePrepaidRechargeId'=> Yii::t('home', '手机话费或流量充值提示模板id'),
            'hotelOrderPayId' => Yii::t('home', '酒店订单支付提示模板id'),
            'hotelOrderLotterPayId' => Yii::t('home', '酒店订单及抽奖支付提示模板id'),
            'hotelOrderConfirmId' => Yii::t('home', '酒店订单确认提示模板id'),
            'hotelOrderRoomChangeId' => Yii::t('home', '酒店订单换房确认模板id'),
            'hotelOrderLotterConfirmId' => Yii::t('home', '酒店订单确认及中奖提示模板id'),
            'hotelOrderCancleId' => Yii::t('home', '酒店订单取消提示模板id'),
            'hotelOrderLotterCancleId' => Yii::t('home', '酒店订单及抽奖取消提示模板id'),
            'hotelOrderRefundId' => Yii::t('home', '酒店订单退订提示模板id'),
            'hotelOrderLotterRefundId' => Yii::t('home', '酒店订单及抽奖退订提示模板id'),
            'hotelOrderCompleteReturnId' => Yii::t('home', '酒店订单完成返还积分提示模板id'),
            'hotelOrderCompletePrizeId' => Yii::t('home', '酒店订单完成获得中奖提示模板id'),
            'hotelOrderCompleteMemrefId' => Yii::t('home', '酒店订单完成推荐者提示模板id'),
            'hotelOrderCommentId' => Yii::t('home', '酒店订单评价提示模板id'),
            'contributionContentId' => Yii::t('home', '爱心捐款短信内容模板id'),
            'offScoreConsumeMemberId' => Yii::t('home', '线下对账-消费者返回积分模板id'),
            'offScoreConsumeRefId' => Yii::t('home', '线下对账-推荐者获得积分模板id'),
            'offScoreConsumeId' => Yii::t('home', '积分消费扣除积分提醒模板id'),
        	'paymentConsumeId' => Yii::t('home', '银行卡消费提醒模板id'),
            'offScoreBizReconId' => Yii::t('home', '线下对账-加盟商提醒短信模板id'),
            'lotteryChanceId' => Yii::t('home', '获得抽奖机会提醒模板id'),
            'lotteryWinNoneId' => Yii::t('home', '未中奖提醒模板id'),
            'lotteryWinScoreId' => Yii::t('home', '中奖积分提醒模板id'),
            'lotteryWinGoodsId' => Yii::t('home', '中奖商品提醒模板id'),
            'machineOrderConsumeId' => Yii::t('home', '格子铺消费后的短信提醒模板id'),
            'machineOrderConsumeAfterVerifyId' => Yii::t('home', '格子铺消费验证成功后的短信模板id'),
            'machineRedMoneyId'=>  Yii::t('home','盖网通会员红包模板id'),
             'machineRestPassId'=>Yii::t('home','盖网通管理员重置密码模板id'),
             'weixinPayId'=>Yii::t('home','微信支付模板id'),
             'signReturnMoneyId' => Yii::t('home', '会员签收获得返还金额短信提示模板id'),
                 'theShopSuccId'=>Yii::t('home','开店成功商家短信模板id'),
            'machinePayFailId'=>  Yii::t('home','售货机支付失败提示短信模板id'),
             'machineShipmentFailId'=>  Yii::t('home','售货机出货失败退款短信模板id'),
            'recoveryPrepaidcarId' =>  Yii::t('home','回收充值卡模板id'),
            'roolInMoney'=>  Yii::t('home','盖网通会员转账（转入）'),
             'roolOutMoney'=>  Yii::t('home','盖网通会员转账（转出）'),
             'roolInMoneyId'=>  Yii::t('home','盖网通会员转账（转入）模板id'),
             'roolOutMoneyId'=>  Yii::t('home','盖网通会员转账（转出）模板id'),
            'gaiVerifyContent'=>  Yii::t('home','盖网通短信验证码'),
             'gaiVerifyContentId'=>  Yii::t('home','盖网通短信验证码模板id'),
        );
    }

}

?>
