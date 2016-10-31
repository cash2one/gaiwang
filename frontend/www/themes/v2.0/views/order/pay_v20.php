<?php
    Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/global.css');
    Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/module.css');
    Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/cart.css');
    $validEnd = false;
    $orderCache = ActivityData::getOrderCacheByCode($this->getParam('code'));
    if(!empty($orderCache)){
        $validEnd = $orderCache['create_time'] + SeckillRedis::TIME_INTERVAL_ORDER;
    }
?>
<script>
    $(function(){
        //快捷支付布局
        $(".qp-list li:nth-child(3n+1)").css("margin-left","7px");
        //控制点击单选按钮
        $(".radio").click(function(){
            var need  = $('.need-pay').remove(),parent = $(this).parent();
            parent.css("border-color","#c20005"); 
            parent.append(need);
            $(".radio").not(this).parent().css("border-color","#eaeaea");
        })
       //控制其他付款方式显示与隐藏
        if($("#e-bank .pay-type").length>3){
            $("#e-bank .pay-type").each(function(index){
                if(index>=3){
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
        });

        //显示更多在线支付银行
		$(".bankMore").click(function(){
			var num=$(this).attr("tag");
			$(this).removeClass("bankMoreSel");
			if(num==1){
				$(".bankCard-li-height").css("height","auto")
				$(this).addClass("bankMoreSel");
				$(this).attr("tag","2")
				$(this).find("span").text("收起");
			}else{
				$(".bankCard-li-height").css("height","150px")
				$(this).find("span").text("更多在线支付银行");
				$(this).attr("tag","1")
			}	
		});
    })
    </script>
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
<?php
    $exflag=false;
    $discoutTotalArr = $model->getDiscount($orders,$model,true);
    if($discoutTotalArr===0) $exflag=true;
    $discoutTotal=$discoutTotalArr['discoutTotal'];
    $dayMoney=$discoutTotalArr['dayMoney'];
?>
<!--主体start-->
<!--<script src="<?php //echo DOMAIN.'/js/jquery.blockUI.js'?>"></script>-->
<div class="shopping-bg">
    <div class="shopping-pay">
        <div class="order-submit">
            <?php
                $form = $this->beginWidget('ActiveForm', array(
                    'id' => 'order-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'beforeValidateAttribute'=>"js:function(form, attribute){
                             $('#OrderForm_password3').attr('disabled',true);
                             return true;
                         }",
                        'afterValidateAttribute' => "js:function(form,data,hasError){
                            $('#OrderForm_password3').attr('disabled',false);
                        }",
                        //如果密码框是隐藏状态，则不需要密码验证
                        'beforeValidate' => "js:function(form){
                            window.loader = layer.load();
                            if($('#OrderForm_password3:hidden').length){

                                $('#OrderForm_needPassword').val(0);
                                 $('#OrderForm_password3').val(12345679);
                                  $('.input-boxs').attr('disabled',true);
                            }else{

                             $('#OrderForm_password3').attr('disabled',true);
                                var jf = $('#OrderForm_jfPayCount').val();
                                var total = $model->totalPrice;
                                if(!Number(parseFloat(total-jf).toFixed(2))){
                                    $('.balance-pay').append('<input value=\"JF\" class=\"gs-moreInfo\" name=\"OrderForm[payType]\" id=\"OrderForm_payType\" type=\"radio\" checked=\"checked\">');
                                }
                                $('#OrderForm_needPassword').val(1);
                            }
                            return true;
                        }",
                        'afterValidate' => "js:function(form, data, hasError){
                            if(!$('#selJF').prop('checked')){
                                $('#OrderForm_jfPayCount').val(0);
                            }
                            if (!hasError) {
                                if($('#e-bank .quickPayRadio:checked').length==0){
                                    $('#quickPayFlag').remove();
                                }
                                //layer.load();
                                //$.blockUI({ message: '<div class=\"pay-tip\"><p style=\"padding:35px;\">正在处理支付中,请稍候...</p></div>' });
                                return true;
                            } else {

                              $('#OrderForm_password3').attr('disabled',false);
                                layer.close(window.loader);
                            }
                        }
                        ",
                        'class'=>"pay-contain"
                    ),
                    'htmlOptions'=>array('class'=>'pay-contain')
                ));
            ?>
            <?php echo $form->hiddenField($model, 'totalPrice'); ?>
            <?php echo $form->error($model, 'totalPrice'); ?>
            <?php $model->needPassword = 1 ?>
            <?php echo $form->hiddenField($model, 'needPassword'); ?>
            <?php echo $form->hiddenField($model, 'code', array('value' => $this->getParam('code'))); ?>
            <div class="order-box">
                <div class="orders-title clearfix">
                    <?php if($validEnd): ?>
                        <span class="sx_date"><i class="icon-cart"></i>还剩<span id="clock"></span>,请尽快在这个时间内完成支付!</span>
                    <?php elseif($sourceType == Order::SOURCE_TYPE_AUCTION):?>
                        <span class="sx_date"><i class="icon-cart"></i><?php echo Yii::t('order','商品拍卖成功，请您于72小时内完成支付 （逾期订单将被取消）')?></span>
                    <?php else:?>
                        <span><i class="icon-cart"></i><?php echo Yii::t('order','订单提交成功，请您于24小时内完成支付 （逾期订单将被取消）')?></span>
                    <?php endif; ?>
                    <div class="right">
                        <?php echo Yii::t('order','应付金额')?>：<span class="pay-num"><?php echo HtmlHelper::formatPrice($model->totalPrice); ?></span>
                    </div>
                </div>
                <div class="orders-info clearfix">
                    <?php 
                        //获取订单第一个产品的名称
                        $orderGoods = $orders[0]->orderGoods;
                    ?>
                    <p class="product"><?php echo Yii::t('order','盖象商城')?> -- <?php echo $orderGoods[0]->goods_name?> <?php if(count($orders) > 1) echo Yii::t('order','等多件商品')?></p>
                    <p class="money"><?php echo Yii::t('order','交易金额')?>：<?php echo Common::rateConvert($model->totalPrice)?><?php echo Yii::t('order','元')?></p>
                    <p class="time"><?php echo Yii::t('order','购买时间')?>：<?php echo date('Y年m月d日 H:i:s')?></p>
                    <p class="address"><?php echo Yii::t('order','收货地址')?>：<?php echo $orders[0]->address?>，<?php echo $orders[0]->consignee.Yii:: t('order','(收)')?> <?php echo $orders[0]->mobile?></p>
                </div>
            </div> 
            <?php if($validEnd == false && ($orders[0]['source_type'] != Order::SOURCE_TYPE_HB || $totalPrice == 0) && $sourceType != Order::SOURCE_TYPE_AUCTION): ?>
            <div class="pay-type balance-pay">
                    <?php $maxmoney = $discoutTotal > $balance ? $balance : $discoutTotal;?>
                    <?php
                        echo $form->checkBox($model, 'jfPay', array('value' => 'JFPay', 'uncheckValue' => null, 'id' => 'selJF', 'checked' => '','class'=>'checkbox','disabled'=>$maxmoney>0 ? "" : "disabled"));
                    ?>
                    <span class="pay-txt"><?php echo Yii::t('order','使用账户余额')?></span>
                    <?php echo $form->textField($model,'jfPayCount',array('autocomplete'=>'off','class'=>'input-box','value'=>Common::rateConvert($discoutTotal>$balance ? $balance : $discoutTotal)))?>
                    <!-- //用于阻止 chrome表单自动填充的占位符 -->
                    <input class='fn-hide gs-brandBut' type="text" />
                    <input class='fn-hide gs-brandBut' type="password"/>
                    <!-- //用于阻止 chrome表单自动填充的占位符 -->
                    <!--<input name="selectAccount" class="input-box" type="text" id="selectAccount"  onpaste="return false;" autocomplete="off"/>--> 

                    <!--  
                    <span class="input-tip"><?php echo Yii::t('order','元,最多可以输入')?><b class="max-num"><?php echo Common::rateConvert($maxmoney); ?></b><?php echo Yii::t('order','元')?></span>
                    -->
                    
                    <!-- 不可用积分支付时--隐藏掉 -->
                    <?php if(!$exflag):?>
                    <span class="input-tip"><?php echo Yii::t('order','元,本次最多可以使用')?><b class="max-num"><?php echo Common::rateConvert($maxmoney); ?></b><?php echo Yii::t('order','元')?>
                       <?php echo Yii::t('order',',本日可用余额')?><b class="max-num"><?php echo Common::rateConvert($dayMoney); ?></b><?php echo Yii::t('order','元')?>
                    </span>
                    <?php endif;?>
                    <!--不可用积分支付时--隐藏掉  -->
                    <?php CHtml::$errorContainerTag='span';echo $form->error($model,'jfPayCount',array('class'=>'error-tip','id'=>'account-money'))?>
                    <span class="balance"><?php echo Yii::t('order','余额')?>:<b class="balance-num"><?php echo $balance;?></b><?php echo Yii::t('order','元')?></span>
                    <!--<span class="error-tip" id="account-money"></span>-->
                    <script type="text/javascript">
                        var discount = <?php echo Common::rateConvert($model->totalPrice) ?>; //订单总额
                        var max = <?php echo Common::rateConvert($maxmoney)?>; //允许积分支付金额
                        var count; //用户输入金额
                        $("#selJF").click(function(){
                            $(".radio").attr('checked',false);
                            if($(this).prop("checked")){
                                $("#ghtpay").css("display","block");
                                $("#otherpay").css("display","none");
                                $(this).parent().css("border-color","#c20005");
                                $('#pay-password').show();
                                $('#OrderForm_password3').val();
                                $('.error-tip').hide();
                                count = $('#OrderForm_jfPayCount').val();
                                if(count == discount){ 
                                    $('#next-btn').show();
                                }
                                if(count>max){
                                    $('#OrderForm_jfPayCount').val(max);
                                    count = max;
                                }
                                $('.still-pay').text('<?php echo HtmlHelper::formatPrice(false) ?>'+ parseFloat(discount-count).toFixed(2));
                            }else{
                                	$("#ghtpay").css("display","none");
                                    $("#otherpay").css("display","block");
                                $('#pay-password,#account-money').hide();
                                $(this).parent().css("border-color","#eaeaea");
                                var isshow=true;
                                if($('#OrderForm_jfPayCount').val() == <?php echo $model->totalPrice?>){
                                    $('.radio').each(function(){
                                        if($(this).prop("checked")){
                                            isshow = false;;
                                        }
                                    })
                                    if(isshow) $('#next-btn').hide();
                                }
                                $('.still-pay').text('<?php echo HtmlHelper::formatPrice(false) ?>'+ parseFloat(discount).toFixed(2));
                            }
                        })
                        $('#OrderForm_jfPayCount').blur(function(){
                            if(!((/^[0-9]*\.?[0-9]+$/).test($(this).val()))){
                                $(this).val(<?php echo $maxmoney;?>);
                            }
                            count = $(this).val();
                            if(count>max){
                                $(this).val(max);
                                count = max;
                            }
                            $(this).val(Number(count).toFixed(2));
                            if($('#selJF').prop('checked')){
                                $('.still-pay').text('<?php echo HtmlHelper::formatPrice(false) ?>'+ parseFloat(discount-count).toFixed(2));
                            }

                        }).focus(function(){
                            $('#account-money').hide();
                        })
                    </script>
                </div>
            <?php else:?>
                <div class="goods-list-info"></div>
            <?php endif;?>
            <div id="e-bank">
            <?php  $countlist = 0;?>
             <?php if($sourceType != Order::SOURCE_TYPE_SINGLE):?>
                <!-- 快捷支付开始 -->
                <?php  if(Tool::getConfig('payapi','umQuickEnable') === 'true'): ?>
                <input type="hidden" name="quickPay" id="quickPayFlag" value="<?php echo OnlinePay::PAY_UM_QUICK ?>"/>
                <?php $cardList = PayAgreement::getCardList($this->getUser()->gw,  PayAgreement::PAY_TYPE_UM); $countlist = count($cardList);?>
                <?php foreach ($cardList as $k=>$v):?>
                <div class="pay-type clearfix">
                    <?php
                        if($k==0){
                           echo CHtml::radioButton('OrderForm[payType]', 'true', array(
                                'id' => 'quickPay_' . $v->id,
                                'value' => $v->id,
                                'class' => 'radio quickPayRadio',
                            )); 
                        } else {
                            echo CHtml::radioButton('OrderForm[payType]', '', array(
                                'id' => 'quickPay_' . $v->id,
                                'value' => $v->id,
                                'class' => 'radio quickPayRadio',
                            ));
                        }
                    ?>
                    <!--<input type="radio" class="radio" name="payment"/>-->
                    <b class="type-name"><?php echo Yii::t('order','银行卡')?></b>
                    <i class="bank-logo <?php echo $v->bank?>"></i>
                    <span class="card-num">****<?php echo $v->bank_num ?></span>
                    <span class="card-type deposit"><?php echo $v::getCardType($v->card_type) ?></span>
                    <?php if($k==0):?><span class="need-pay" style="display:inline;"><?php echo Yii::t('order', '还需要支付') ?>：<b class="still-pay"><?php echo HtmlHelper::formatPrice($model->totalPrice) ?></b></span><?php endif;?>
                </div>
                <?php endforeach;?>
                <?php endif; ?>
                <!--快捷支付结束-->
                <?php endif;?>
                
                
                <!--网银开始-->
                    <?php echo $this->renderPartial('_bankpay_v20',array('model'=>$model,'form'=>$form,'hasquick'=>$countlist,'soureType'=>$sourceType))?>
                <!-- 网银结束 -->
            </div>

            <div id="pay-password" class="pay-password">
                <label for="password" class="label"><?php echo Yii::t('order','盖象支付密码')?>：</label>
                <?php echo $form->passwordField($model, 'password3', array('class' => 'input-box','value'=>'','maxlength'=>20)) ?>
                <?php echo $form->hiddenField($model, 'password3', array('class' => 'input-boxs')) ?>
                <?php echo $form->hiddenField($model, 'token', array('id' => 'hidden_time'))?>
                <a href="<?php echo $this->createUrl('member/member/setPwd3')?>" target="_blank" class="forgot-pwd"><?php echo Yii::t('order','忘记支付密码？')?></a>
                <span class="pop-message">
                    <?php CHtml::$errorContainerTag='span';echo $form->error($model,'password3',array('class'=>'errorMessage'))?>
                </span>
            </div>
                <?php echo CHtml::submitButton('下一步', array('class' => 'next-btn','id'=>'next-btn')); ?>
            <?php $this->endWidget()?>           
        </div>
    </div>
</div>

<script src="/js/jsencrypt.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

    $('#OrderForm_password3').blur(function(){
        var value = $("#OrderForm_password3").val();
        if (value == '' || value.length < 6 ){
            return false;
        }
        var token = "<?php $RsaPassword = new RsaPassword(); echo $RsaPassword->generateSalt('21');?>";
        var pubkey = "<?php echo $RsaPassword->public_key;?>";
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey(pubkey);
        var encrypted = encrypt.encrypt(JSON.stringify({"encrypt": "yes", "password": value+token}));
        $('.input-boxs').val(encrypted);
        $('#hidden_time').val(token);
    });
</script>

<script type="text/javascript">
    $('.radio').click(function(){
        $('#next-btn').show();
    })
</script>
<?php if ($validEnd): ?>
    <script src="<?php echo DOMAIN ?>/js/jquery.countdown.min.js"></script>
    <script>
        var isClose = 0;
        function closeOrder(){
            isClose = 1;
            jQuery.ajax({
                type:"POST",async:false,
                url:"<?php echo $this->createUrl('seckillFlow/close'); ?>",
                data: {
                    "YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
                    "code":"<?php echo $this->getParam('code'); ?>"
                },
                success: function() {
                    layer.open({
                        btn:['确定'],
                        content:'<?php echo Yii::t('member', '订单超时，已被取消！') ?>',
                        title:'<?php echo Yii::t('member', '消息') ?>',
                        yes:function(index){
                            location.href='<?php echo $this->createUrl('/member/order/newDetail', array('code' => $this->getParam('code'))); ?>';
                        },
                        cancel:function(index){
                            location.href='<?php echo $this->createUrl('/member/order/newDdetail', array('code' => $this->getParam('code'))); ?>';
                        }
                    });
                },
                error: function() {
                    location.href='<?php echo $this->createUrl('/member/order/admin'); ?>';
                }
            });
        }
    <?php if ($validEnd && $validEnd <= time()): ?>closeOrder();<?php endif; ?>

        var validEnd = '<?php echo date('Y/m/d H:i:s', $validEnd) ?>';
        var validStart = '<?php echo date('Y/m/d H:i:s') ?>';
        $('#clock').countdown(validEnd, function(event) {
            $(this).html(event.strftime('%H:%M:%S'));
            if(isClose == 0 && event.strftime('%H:%M:%S') == '00:00:00'){
                closeOrder();
            }
        }, validStart);
    </script>
<?php endif; ?>
<!-- 主体end -->