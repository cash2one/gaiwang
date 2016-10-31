<?php
/* @var $this orderController */
/** @var $model Order */
/**
 * 需要传三个参数过来
 * @var string $backUrl 支付返回地址 orderFlow/onlinePayResult;
 * @var string $orderDesc 订单描述：商品订单
 * @var string $checkUrl 检查支付情况地址 orderFlow/check
 * @var string $orderType 订单类型
 *
 */

?>
<?php
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/global.css');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/module.css');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/cart.css');
Yii::app()->clientScript->registerScriptFile($this->theme->baseUrl . '/js/jquery-1.9.1.js');
Yii::app()->clientScript->registerScriptFile($this->theme->baseUrl . '/js/layer/layer.js');
?>
<?php $this->renderPartial('//layouts//_msg'); ?>
<div class="pages-header">
    <div class="w1200">
        <div class="pages-logo">
            <a href="<?php echo DOMAIN ?>" title="<?php echo Yii::t('site', '盖象商城') ?>" class="gx-top-logo"
               id="gai_link">
                <img width="187" height="56" alt="<?php echo Yii::t('site', '盖象商城') ?>"
                     src="<?php echo $this->theme->baseUrl . '/'; ?>images/bgs/top_logo.png"/>
            </a>
        </div>
        <div class="pages-title"><?php echo Yii::t('order', '支付'); ?></div>
        <div class="shopping-process clearfix">
            <div class="process-li icon-cart on"><?php echo Yii::t('order', '查看购物车'); ?></div>
            <span class="process-out process-out01"></span>

            <div class="process-li icon-cart on"><?php echo Yii::t('order', '确认订单'); ?></div>
            <span class="process-out process-out02"></span>

            <div class="process-li icon-cart on"><?php echo Yii::t('order', '支付'); ?></div>
            <span class="process-out process-out03"></span>

            <div class="process-li icon-cart"><?php echo Yii::t('order', '确认收货'); ?></div>
            <span class="process-out process-out04"></span>

            <div class="process-li icon-cart"><?php echo Yii::t('order', '完成'); ?></div>
        </div>
    </div>
</div>
<!--主体start-->
<div class="shopping-bg">
    <div class="shopping-pay">
        <?php echo CHtml::beginForm();?>
        <div class="orders-successfully">
            <div class="orders-title"><span><i class="icon-cart"></i><?php echo Yii::t('order', '订单提交成功，请您确认订单信息，尽快付款！') ?></span></div>
            <div class="orders-message clearfix">
                <div class="left">
                    <p class="order-number"><?php echo Yii::t('orderFlow', '支付订单号'); ?>：<?php echo $this->getParam('code') ?></p>
                    <div class="order-bank icon-cart">
                        <div class="bank-name">
                            <i class="qp-bank-logo bank-logo <?php echo $model->bank?>"></i>
                            <span class="bank-info number">****<?php echo $model->bank_num ?></span>
                            <div class="txtr"><span><?php echo $model::getCardType($model->card_type) ?></span></div>
                        </div>
                        <div class="bank-phone"><?php echo Yii::t('orderFlow','预留手机号码')?>：<?php echo substr_replace($model->mobile,'****',3,4) ?></div>
                    </div>
                </div>
                <div class="right">
                    <?php echo Yii::t('orderFlow','应付金额')?>：<span><?php echo HtmlHelper::formatPrice($this->getParam('money')) ?></span>
                </div>
            </div>

            <div class="order-box clearfix">
                <div class="left"><?php echo Yii::t('orderFlow','预留手机验证码')?>：</div>
                <div class="center">
                    <input name="verifyCode" type="text" class="input-code" id="Recharge_verifyCode" />
                    <input type="submit" class="btn-dete" value="确定支付" />
                </div>
                <div class="right">
                    <a href="javascript:" class="btn-send" id="sendMobileCode" style="display:inline-block;text-align: center"><span data-status="1" style="font-weight: normal;">获取验证码</span></a>
                    <!--<input name="" type="button" class="btn-send" value="获取验证码" id="sendMobileCode" data-status="1"/>-->
                </div>
            </div>
        </div>
        <?php echo CHtml::endForm();?>
    </div>
</div>
<!-- 主体end -->
<?php
echo $this->renderPartial('//member//home//_sendMobileCodeJs');
?>
<?php //$ajaxUrl = $this->createAbsoluteUrl('/member/quickPay/sendMsg'); ?>
<script>
// $("#sendMobileCode").click(function(){
//         var mobile=$("#PayAgreement_mobile").val();
//          $.ajax({ 
//                 type:"POST",
//         url:"<?php //echo $ajaxUrl; ?>",
//         dataType:'json',
//         data: {
//            "mobilePhone":mobile,
//            "YII_CSRF_TOKEN":'<?php //echo Yii::app()->request->csrfToken ?>',
//        },
//         success:function(data){
//             console.log(data);
//             return;
//             if(data.respCode=='000000'){
//                 $("#sendReqMsgId").val(data.payMsgId);
//                 }else{
//                   alert(data.resMsg);
//               }
//           }
//       });
//         })
</script>
<script type="text/javascript">
    
    $(function () {
        sendQuickPay("#sendMobileCode",{
            tradeNo:"<?php echo $this->getParam('tradeNo') ?>",
            usr_busi_agreement_id:"<?php echo $model->busi_agreement_id ?>",
            usr_pay_agreement_id:"<?php echo $model->pay_agreement_id ?>",
            YII_CSRF_TOKEN:"<?php echo Yii::app()->request->csrfToken ?>"
        },"<?php echo $this->createAbsoluteUrl('order/getQuickPayCode') ?>");
//
        $(".shopping-pay form").submit(function(){
            if($("#Recharge_verifyCode").val().length==0){
                layer.open({
                    title:'错误信息',
                    icon: 2,
                    content:'手机验证码不得为空'
                })
                return false;
            }
        });
        
    });

</script>