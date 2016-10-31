<?php 
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/styles/cart.css');
    $hotel = $model->hotelPay;
?>
<!--主体start-->
<div class="shopping-bg">
    <div class="shopping-pay">
        <?php
        /** @var CActiveForm $form */
        $form = $this->beginWidget('ActiveForm', array(
            'id' => $this->id . '-form',
            'action' => Yii::app()->createAbsoluteUrl($this->route, array('code' => $model->code)),
            'method' => 'post',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
//                'shadeContent' => Yii::t('hotelOrder','正在处理支付中,请稍候...'),
                //如果密码框是隐藏状态，则不需要密码验证
                'beforeValidate'=>"js:function(form){
                    if($('#OrderPayForm_password:hidden').length){                    
                        $('#OrderPayForm_needPassword').val(0);
                        $('#OrderPayForm_password').val(12345679);
                    }else{
                        $('#OrderPayForm_needPassword').val(1);
                    }
                    return true;
            }",
                'afterValidate' => "js:function(form, data, hasError){
                        if (!hasError) {
                           if($('#e-bank .quickPayRadio:checked').length==0){
                                $('#quickPayFlag').remove();
                            }
                        }
                        return true;
                    }
                    ",
            ),
            'htmlOptions'=>array('class'=>'order-submit'),
        ));
        ?>
        <?php $orderPay->needPassword = 1 ?>
        <?php echo $form->hiddenField($orderPay, 'needPassword'); ?>
        <div style="display: none"><?php echo $form->checkBox($model, 'is_lottery', array('id' => 'participate_lottery', 'value' => 0)); ?></div>
            <div class="order-box">
                <div class="orders-title clearfix">
                    <span><i class="icon-cart"></i><?php echo Yii::t('hotelOrder','订单提交成功，请您于24小时内完成支付 （逾期订单将被取消）')?></span>
                    <div class="right">
                        <?php echo Yii::t('hotelOrder','应付金额')?>：
                        <span class="pay-num">
                            <?php echo HtmlHelper::formatPrice('') ?>
                            <?php echo Chtml::label(Common::rateConvert($model->total_price), true, array('id' => 'totalPrice')) ?>
                        </span>
                    </div>
                </div>
                <div class="orders-info clearfix">
                    <p class="product"><?php echo Yii::t('hotelOrder','盖象商城')?> -- <?php echo $hotel->name .'---'. $model->room_name?></p>
                    <p class="money"><?php echo Yii::t('hotelOrder','交易金额')?>：<?php echo HtmlHelper::formatPrice($model->total_price); ?></p>
                    <p class="time"><?php echo Yii::t('hotelOrder','入住时间')?>：<?php echo date('Y年m月d H:i:s', $model->settled_time); ?></p>
                    <p class="time"><?php echo Yii::t('hotelOrder','离店时间')?>：<?php echo date('Y年m月d H:i:s', $model->leave_time); ?></p>
                </div> 
<!--                <div class="gft-pay">
                    <img src="../images/bgs/gft-code.jpg" width="80px" height="80px" alt="盖付通二维码" />
                    <p>盖付通扫码支付</p>
                </div>               -->
            </div> 
              <?php 
                    $flag=true;
                    $memberInfo=MemberPoint::getMemberPoint($model->member->id, $orderPay->balance);
                    //Tool::pr($memberInfo);
                    if(!empty($memberInfo)){
	                    $limitMoney=$memberInfo['dayLimitMoney'];
	                    $exFlag=bcsub($limitMoney,$payDetail['total_pay_price'],2);
	                    $flag= $exFlag >= 0 ? true : false; 
                    }  
                 ?>     
            <div class="pay-contain">
               <?php if($flag):?>              
                <div class="pay-type balance-pay">
                    <?php echo CHtml::activeRadioButton($orderPay, 'payWay', array('value' => OnlinePay::PAY_WAP_INTEGRAL, 'id' => 'integral_pay', 'uncheckValue' => null,'class'=>'integral_pay')) ?>
                    <?php echo CHtml::label(Yii::t('hotelOrder', '使用账户余额'), 'integral_pay',array('class'=>'pay-txt')); ?>：
                    <!--<input type="checkbox" name="payment" class="checkbox"/>-->
                    <?php echo CHtml::textField('pay_integral_1', $payDetail['total_pay_price'], array('class' => 'input-box', 'readonly' => 'readonly')); ?>
                    <span class="input-tip">元，余额：<b class="balance-num"><?php echo $orderPay->balance; ?></b>元，本日可用余额：<b class="balance-num"><?php echo $limitMoney ?></b>元</span>            
                </div>
                <?php endif;?>
                <div id="e-bank">
                    <!-- 快捷支付开始 -->
                    <?php if (Tool::getConfig('payapi', 'umQuickEnable') === 'true'): ?>
                        <input type="hidden" name="quickPay" id="quickPayFlag" value="<?php echo OnlinePay::PAY_UM_QUICK ?>"/>
                        <?php $cardList = PayAgreement::getCardList($this->getUser()->gw); ?>
                        <?php foreach ($cardList as $k => $v): ?>
                            <div class="pay-type clearfix">
                                <?php
                                if ($k == 0) {
                                    echo CHtml::radioButton('OrderPayForm[payWay]', 'true', array(
                                        'id' => 'quickPay_' . $v->id,
                                        'value' => $v->id,
                                        'class' => 'radio quickPayRadio',
                                        'style' => 'border-color: rgb(194, 0, 5)'
                                    ));
                                } else {
                                    echo CHtml::radioButton('OrderPayForm[payWay]', '', array(
                                        'id' => 'quickPay_' . $v->id,
                                        'value' => $v->id,
                                        'class' => 'radio quickPayRadio',
                                    ));
                                }
                                ?>
                                <!--<input type="radio" class="radio" name="payment"/>-->
                                <b class="type-name"><?php echo Yii::t('order', '银行卡') ?></b>
                                <i class="bank-logo <?php echo $v->bank ?>"></i>
                                <span class="card-num">****<?php echo $v->bank_num ?></span>
                                <span class="card-type deposit"><?php echo $v::getCardType($v->card_type) ?></span>
                            </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <?php $cardList = array();  ?>
                    <?php endif; ?>
                    <!--快捷支付结束-->
                    <!--网银开始-->
                    <?php echo $this->renderPartial('_internetbank', array('model' => $orderPay, 'form' => $form, 'hasquick' => count($cardList))) ?>
                    <!-- 网银结束 -->
                </div>                 
                <div class="operation-box clearfix">
                    <a href="javascript:void(0)" id="others-pay" class="operation-controls show-others"/><?php echo Yii::t('order', '其他付款方式') ?></a>
                    <?php if (Tool::getConfig('payapi', 'umQuickEnable') === 'true'): ?>
                    <a href="<?php echo $this->createUrl('/member/quickPay/bindCards'); ?>" target="_blank" class="operation-controls add-bank-card">+ <?php echo Yii::t('order', '添加银行卡') ?></a>
                    <?php endif; ?>
                    <a href="<?php echo $this->createUrl('/help/article/payment') ?>" target="_blank" class="about-payment"><?php echo Yii::t('order', '关于支付') ?>？</a>
                </div>
                <div id="pay-password" class="pay-password">
                    <label for="password" class="label"><?php echo Yii::t('hotelOrder','盖象支付密码')?>:</label>
                    <?php echo $form->passwordField($orderPay, 'password', array('class' => 'input-box')); ?>
                    <?php
                        echo CHtml::link(Yii::t('hotelOrder', '修改支付密码'), $this->createAbsoluteUrl('/member/member/setPwd3'), array(
                            'class' => 'forgot-pwd', 'target' => '_blank', 'title' => Yii::t('hotelOrder', '忘记支付密码?'))
                        );
                    ?>
                    <?php CHtml::$errorContainerTag='span'; echo $form->error($orderPay, 'password',array('class'=>'errorMessage')); ?>
                </div>
                 <?php echo CHtml::submitButton('下一步', array('class' => 'next-btn')); ?>
                <!--<input type="button" id="next-btn" class="next-btn" value="下一步" />-->
            </div>                        
        <?php $this->endWidget()?>
    </div>
</div>
<script>
    $(function(){
        $('input[type=radio]').click('on',function(){
           if($(this).hasClass('integral_pay')){
                $(this).parent().css("border-color","#c20005"); 
                $(this).parent().find(".input-box").attr("required",true);
                $('.radio').parent().css("border-color","#eaeaea");
                $("#pay-password").show();
           } else {
               $('#integral_pay').parent().css("border-color","#eaeaea");
                $("#pay-password").hide();
           }
        });
        //控制点击单选按钮
        $(".radio").click(function(){
            $(this).parent().css("border-color","#c20005").find(".need-pay").show();
            $(".radio").not(this).parent().css("border-color","#eaeaea").find(".need-pay").hide();
        })

        //控制其他付款方式显示与隐藏
        if($("#e-bank .pay-type").size()>3){
            $("#e-bank .pay-type").each(function(){
                if($(this).index()>=4){
                    $(this).hide();
                }
            })
            $("#others-pay").show();
        }else{
            $("#others-pay").hide();
        }

        $("#others-pay").click(function(){
            $("#e-bank .pay-type").each(function(){
                if($(this).css("display")=="none"){
                    $(this).show();
                }
            })
            $(this).hide();
        })

        //点击“下一步”按钮提交表单的同时出现弹窗
//        $("#next-btn").click(function(){
//            this.form.submit();
//            $("#pay-confirm").show();
//        })

    })
</script>
<!-- 主体end -->