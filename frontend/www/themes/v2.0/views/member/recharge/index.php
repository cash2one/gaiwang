<style>
    .next-btn {
        background: #c20005 none repeat scroll 0 0;
        color: #fff;
        cursor: pointer;
        font-family: "宋体";
        font-size: 16px;
        font-weight: bold;
        height: 40px;
        margin-top: 20px;
        text-align: center;
        width: 130px;
    }
    .no-quick-pay {
        border-top: 1px solid #eaeaea;
        color: #dcdcdc;
        font-family: "微软雅黑";
        font-size: 20px;
        line-height: 4em;
        margin-top: 10px;
        text-align: center;
    }
    .recharge-cards .orders-payments .orders-payments-item.on, .recharge-cards .orders-payments .orders-payments-item{background:none}
    .recharge-cards .orders-payments .orders-payments-item.second{padding-left: 52px;}
    .card-type.deposit {background: #70b2cd;}
    .card-type {
        display: inline-block;
        padding: 3px 5px;
        margin-top: 3px;
        color: #fff;
        vertical-align: middle;
    }
    .card-num {
        display: inline-block;
        margin: 0 12px;
        vertical-align: middle;
    }

</style>
<!--主体start-->
<div class="member-contain clearfix">

    <div class="main-contain">
        <div class="return-record">
            <span class="not"><a href="<?php echo $this->createAbsoluteUrl('/member/prepaidCard/use') ?>"><?php echo Yii::t('memberPrepaidCard', '积分充值卡') ?></a></span>
            <span><a href="<?php echo Yii::app()->createAbsoluteUrl('member/recharge/index') ?>"><?php echo Yii::t('memberPrepaidCard', '第三方充值') ?></a></span>
        </div>

        <div class="recharge-cards">
            <div class="cards-box">
                <p class="cards-title"><?php echo Yii::t('memberPrepaidCard', '如何使用第三方平台充值？') ?></p>
                <div class="revise-progress party">
                    <div class="revise-item on">
                        <p class="number">1</p>
                        <p class="title"><?php echo Yii::t('memberPrepaidCard', '填写充值金额') ?></p>
                        <span class="on"></span>
                    </div>
                    <div class="revise-item on">
                        <p class="number">2</p>
                        <p class="title"><?php echo Yii::t('memberPrepaidCard', '选择充值平台') ?></p>
                        <span class="on"></span>
                    </div>
                    <div class="revise-item on">
                        <p class="number">3</p>
                        <p class="title"><?php echo Yii::t('memberPrepaidCard', '完成第三方平台的支付流程') ?></p>
                        <span class="on"></span>
                    </div>
                    <div class="revise-item on">
                        <p class="number">4</p>
                        <p class="title"><?php echo Yii::t('memberPrepaidCard', '充值完成') ?></p>
                    </div>
                </div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => $this->id . '-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'afterValidate' => "js:function(form, data, hasError){
                        if (!hasError) {
                           if($('.quickPayRadio:checked').length==0){
                                $('#quickPayFlag').remove();
                            }
                           return true;
                        }else {
                            layer.close(window.loader);
                        }
                    }",
                    ),
                ));
                $model->gai_number = Yii::app()->user->gw;
                $model->money = 100;
                $model->score = Common::convertSingle('100', $this->getSession('typeId'));
                ?>
                <div class="cards-conter">
                    <div class="cards-info">
                        <div style="height:32px;margin-top:15px;"><span class="cards-left"><i>*</i><?php echo Yii::t('memberPrepaidCard', 'GW号') ?>：</span>
                            <?php echo $form->textField($model, 'gai_number', array('class' => 'input-name')); ?>
                            <span class="input-prompt"><?php echo Yii::t('memberPrepaidCard', '默认显示用户的GW号码，可填入GW号码为其他会员充值') ?></span>
                            <?php echo $form->error($model, 'gai_number') ?>
                        </div>                            

                        <div style="height:32px;margin-top:15px;"><span class="cards-left"><i>*</i><?php echo Yii::t('memberPrepaidCard', '充值金额') ?>：</span>
                            <?php echo $form->textField($model, 'money', array('class' => 'input-password')); ?>
                            <span class="input-prompt"><?php echo Yii::t('memberPrepaidCard', '默认填写100金额，可填写其他正整数，建议输入100以上的数字') ?></span>
                            <?php echo $form->error($model, 'money') ?>
                        </div>

                    </div>
                </div>

                <!--支付方式-->
                <div class="orders-payments"> 
                    <!--快捷支付开始-->
                    <?php if ($payConfig['umQuickEnable'] === 'true'): ?>
                    <input type="hidden" name="quickPay" id="quickPayFlag" value="<?php echo OnlinePay::PAY_UM_QUICK ?>"/>
                    <?php $cardList = PayAgreement::getCardList($this->getUser()->gw, PayAgreement::PAY_TYPE_UM);$countlist = count($cardList);?>                                       
                    <?php foreach ($cardList as $k => $v): ?>
                        <label for="quickPay_<?php echo $v->id ?>">
                            <div class="orders-payments-item second">
                                <div class="pay-type clearfix">
                                    <?php if ($k == 0): ?>
                                        <input type="radio" name="Recharge[pay_type]" value="<?php echo $v->id ?>" class="radio quickPayRadio" id="quickPay_<?php echo $v->id ?>" checked="checked"/>
                                    <?php else: ?>
                                        <input type="radio" name="Recharge[pay_type]" value="<?php echo $v->id ?>" class="radio quickPayRadio" id="quickPay_<?php echo $v->id ?>"/>
                                    <?php endif; ?>
                                    <i class="bank-logo <?php echo $v->bank ?>"></i>
                                    <span class="card-num">****<?php echo $v->bank_num ?></span>
                                    <span class="card-type deposit"><?php echo $v::getCardType($v->card_type) ?></span>                                    
                                </div>
                            </div>
                        </label>
                    <?php endforeach; ?>
                    <?php endif ?>
                    <!--快捷支付结束-->
                    <!--网银支付开始-->
                    <?php if ($payConfig['bestEnable'] === 'true'): ?>
                        <label for="selNEST">
                            <div class="orders-payments-item second">
                                <?php if ($payConfig['umQuickEnable'] === 'true' && $countlist != 0): ?>
                                    <input type="radio" name="Recharge[pay_type]" value="<?php echo OnlinePay::PAY_BEST ?>" id="selNEST"/>
                                <?php else: ?>
                                    <input type="radio" name="Recharge[pay_type]" value="<?php echo OnlinePay::PAY_BEST ?>" id="selNEST" checked="checked"/>
                                <?php endif; ?>
                                <i class="common-bank-logo BEST"></i>
                            </div>
                        </label>
                    <?php endif;
                    if ($payConfig['umEnable'] === 'true'): ?>
                        <label for="selUM">
                            <div class="orders-payments-item second">
                                <input type="radio" name="Recharge[pay_type]" value="<?php echo OnlinePay::PAY_UM ?>" id="selUM"/>
                                <i class="common-bank-logo UM"></i>
                            </div>
                        </label>
                    <?php endif;
                    if ($payConfig['ipsEnable'] === 'true'): ?>
                        <label for="selIPS">
                            <div class="orders-payments-item second">
                                <input type="radio" class="radio" name="Recharge[pay_type]" value="<?php echo OnlinePay::PAY_IPS ?>" id="selIPS"/>
                                <i class="common-bank-logo IPS"></i>
                            </div>
                        </label>
                    <?php endif;
                    if ($payConfig['gneteEnable'] === 'true'): ?>
                        <label for="selUN">
                            <div class="orders-payments-item second">
                                <input type="radio" name="Recharge[pay_type]" value="<?php echo OnlinePay::PAY_UNION ?>" id="selUN"/>
                                <i class="common-bank-logo UP"></i>
                            </div>
                        </label>
                    <?php endif;
                    if ($payConfig['hiEnable'] === 'true'): ?>
                        <label for="selHI">
                            <div class="orders-payments-item second">
                                <input type="radio" name="Recharge[pay_type]" value="<?php echo OnlinePay::PAY_HI ?>" id="selHI"/>
                                <i class="common-bank-logo HI"></i>
                            </div>
                        </label>
                    <?php endif;
                    if ($payConfig['tlzfEnable'] === 'true'): ?>
                                            <label for="selTLZF">
                            <div class="orders-payments-item second">
                                <input type="radio" name="Recharge[pay_type]" value="<?php echo OnlinePay::PAY_TLZF ?>" id="selTLZF"/>
                                <i class="common-bank-logo TLZF"></i>
                            </div>
                        </label>
                    <?php endif;
                    if ($payConfig['ghtEnable'] === 'true'): ?>
                        <label for="selGHT">
                            <div class="orders-payments-item second">
                                <input type="radio" name="Recharge[pay_type]" value="<?php echo OnlinePay::PAY_GHT ?>" id="selGHT"/>
                                <i class="common-bank-logo GHT"></i>
                            </div>
                        </label>
                    <?php endif;
                    if ($payConfig['ebcEnable'] === 'true'): ?>
                        <label for="selEBC">
                            <div class="orders-payments-item second">
                                <input type="radio" name="Recharge[pay_type]" value="<?php echo OnlinePay::PAY_EBC ?>" id="selEBC"/>
                                <i class="common-bank-logo EBC"></i>
                            </div>
                        </label>
                <?php endif; ?>      
                <!--网银支付结束-->
                </div>
                <!--支付方式结束-->
            </div>
            
            <div class="cards-play"> 
                <?php if ($payConfig['umQuickEnable'] === 'true'): ?>
                    <div class="orders-payments-item third">
                        <div class="orders-payments-top clearfix">
                            <div class="left icon-cart">快捷支付</div>
                            <a target="_blank" href="<?php echo $this->createUrl('quickPay/bindCards'); ?>"><div class="right icon-cart">绑定银行卡</div></a>
                        </div>                    
                    </div>
                <?php endif; ?>
                <div class="cards-message">
                    <p class="message-title">说明：</p>
                    <p>1、如需帮其他会员充值积分，可输入其他会员的GW号完成充值流程。</p>
                </div>
            </div>            
        </div>
        <?php echo CHtml::submitButton('下一步', array('class' => 'next-btn', 'id' => 'next-btn')); ?>
        <?php $this->endWidget() ?>
    </div>
</div>
<!-- 主体end -->