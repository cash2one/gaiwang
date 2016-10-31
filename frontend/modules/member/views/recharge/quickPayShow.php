<?php
/** @var $model PayAgreement */
$this->breadcrumbs = array(
    Yii::t('memberRecharge', '积分管理'),
    Yii::t('memberRecharge', '快捷支付验证'),
);
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberRecharge', '快捷支付验证'); ?></span></a>
            </li>
        </ul>
    </div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
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
				<div class="clear"></div>
                <div class="mgtop20 upladBox error">
                    <span class="fl mgtop5">
                        支付订单：<?php echo $this->getParam('code'); ?>
                    <span>
                </div>
				<div class="clear"></div>
                <div class="mgtop20 upladBox error">
                    <span class="fl mgtop5">
                        金额：<?php echo HtmlHelper::formatPrice($this->getParam('money')); ?>
                        <span>
                </div>
                <div class="upladBox">
                    <?php echo CHtml::submitButton(Yii::t('memberRecharge', '提交'), array('class' => 'integaralBtn4')) ?>
                </div>
                <?php echo CHtml::endForm(); ?>
            </div>
            <div class="mbDate1_b"></div>

        </div>

    </div>
</div>
<?php
echo $this->renderPartial('/home/_sendMobileCodeJs');
?>
<script type="text/javascript">
    $(function () {
        sendQuickPay("#sendMobileCode",{
            tradeNo:"<?php echo $this->getParam('tradeNo') ?>",
            usr_busi_agreement_id:"<?php echo $model->busi_agreement_id ?>",
            usr_pay_agreement_id:"<?php echo $model->pay_agreement_id ?>",
            YII_CSRF_TOKEN:"<?php echo Yii::app()->request->csrfToken ?>"
        },"<?php echo Yii::app()->createUrl('/member/recharge/getQuickPayCode') ?>");

        $(".mbDate1_c form").submit(function(){
            if($("#Recharge_verifyCode").val().length==0){
                alert('手机验证码不得为空');
                return false;
            }
        });
    });

</script>