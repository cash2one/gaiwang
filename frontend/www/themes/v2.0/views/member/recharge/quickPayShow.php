<?php
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/global.css');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/module.css');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/cart.css');
Yii::app()->clientScript->registerScriptFile($this->theme->baseUrl . '/js/jquery-1.9.1.js');
Yii::app()->clientScript->registerScriptFile($this->theme->baseUrl . '/js/layer/layer.js');
?>
<?php $this->renderPartial('//layouts//_msg'); ?>
<div class="member-contain clearfix">
    <div class="main-contain">
        <div class="return-record">
            <span><a href=""> <?php echo Yii::t('memberRecharge', '快捷支付验证'); ?></a></span>        
        </div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <?php echo CHtml::beginForm('') ?>
                <div class="orders-successfully">
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
                <?php echo CHtml::endForm(); ?>
            </div>
            <div class="mbDate1_b"></div>

        </div>

    </div>
    </div>
</div>
<?php
echo $this->renderPartial('//member//home//_sendMobileCodeJs');
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