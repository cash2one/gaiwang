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
<?php if(Yii::app()->theme) Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery-1.9.1.js')?>
<?php $this->renderPartial('application.modules.member.views.layouts._msg'); ?>
<div class="main">
    <div class="shopFlGgbox">
        <div class="shopPayBox">
            <?php $this->renderPartial('application.views.layouts._payErrorTips') ?>
            <h3><?php echo Yii::t('orderFlow', '订单提交成功，请您尽快付款！'); ?></h3>

            <p class="tips"><?php echo Yii::t('orderFlow', '订单提交成功，请确认订单信息'); ?></p>

            <div class="dlBox clearfix">
                <dl class="fl">
                    <dt><?php echo Yii::t('orderFlow', '支付订单号'); ?>：</dt>
                    <dd class="orderNum"><?php echo $this->getParam('code') ?></dd>
                </dl>
                <dl class="fr">
                    <dt><?php echo Yii::t('orderFlow', '应付款金额'); ?>：</dt>
                    <dd class="orderSum"><?php echo HtmlHelper::formatPrice($this->getParam('money')) ?></dd>
                </dl>
                <?php echo CHtml::beginForm('') ?>
                <div class="clearfix"></div>
                <div class="clear"></div>
                <div class="payMethodList">
                    <ul>
                        <li style="height: auto">
                            <div class="<?php echo $model->bank ?> PMImg"></div>
                            <div class="PMNum">****<?php echo $model->bank_num ?></div>
                            <div class="PMType"><?php echo $model::getCardType($model->card_type) ?></div>
                            <div class="clear"></div>
                            <div class="PMInfo">预留手机号码<span><?php echo $model->mobile ?></span></div>
                        </li>
                    </ul>
                </div>
                <div class="clear"></div>
                <div class="mgtop20 upladBox error">
                    <span class="fl mgtop5">
					<label for="Recharge_verifyCode" class="required">手机验证码 <span class="required">*</span></label></span>
                    <input type="text" id="Recharge_verifyCode" name="verifyCode" style="width:100px;" class="integaralIpt2">
                    <a href="#" class="sendCode02" id="sendMobileCode" style="float:left;"><span data-status="1">获取验证码</span></a>
                    <span>
                </div>

            </div>
            <hr/>
            <?php echo CHtml::submitButton(Yii::t('orderFlow', '确认支付'), array( 'class' => 'surePayBtn')) ?>
            <?php echo CHtml::endForm(); ?>
        </div>
    </div>
</div>
<?php
echo $this->renderPartial('application.modules.member.views.home._sendMobileCodeJs');
?>
<script type="text/javascript">
    $(function () {
        sendQuickPay("#sendMobileCode",{
            tradeNo:"<?php echo $this->getParam('tradeNo') ?>",
            usr_busi_agreement_id:"<?php echo $model->busi_agreement_id ?>",
            usr_pay_agreement_id:"<?php echo $model->pay_agreement_id ?>",
            YII_CSRF_TOKEN:"<?php echo Yii::app()->request->csrfToken ?>"
        },"<?php echo $this->createAbsoluteUrl('order/getQuickPayCode') ?>");

        $(".dlBox form").submit(function(){
            if($("#Recharge_verifyCode").val().length==0){
                alert('手机验证码不得为空');
                return false;
            }
        });
        
    });

</script>