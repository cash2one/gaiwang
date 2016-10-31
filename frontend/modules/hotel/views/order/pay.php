<?php
/**
 * @var Hotel $hotel 酒店实例
 * @var HotelOrder $model 酒店订单实例
 * @var OrderPayForm $orderPay 订单支付实例
 */
$hotel = $model->hotelPay;
?>
<div class="main">
    <!--酒店预订流程 begin-->
    <div class="clear mgtop10"></div>
    <div class="hotelBookingStepbg hbStep02">
        <span class="curr"><?php echo Yii::t('hotelOrder', '预订填写酒店信息'); ?></span>
        <span class="curr"><?php echo Yii::t('hotelOrder', '支付该订单'); ?></span><span><?php echo Yii::t('hotelOrder', '成功支付'); ?></span>
    </div>
    <div class="shopFlGgbox">
        <span class="shopflbgTitle"><?php echo Yii::t('hotelOrder', '我已核实订单，同意支付！'); ?></span>
        <div style="display:none; overflow:hidden;" id="shopflcomm_1">
            <table width="1140" cellspacing="0" cellpadding="0" border="0" class="shopflOrdertab">
                <tbody>
                    <tr>
                        <td width="15%" class="title"><?php echo Yii::t('hotelOrder', '订单号'); ?></td>
                        <td width="15%" class="title"><?php echo Yii::t('hotelOrder', '酒店名称'); ?></td>
                        <td width="15%" class="title"><?php echo Yii::t('hotelOrder', '客房名称'); ?></td>
                        <td width="10%" class="title"><?php echo Yii::t('hotelOrder', '客房单价'); ?></td>
                        <td width="15%" class="title"><?php echo Yii::t('hotelOrder', '客房数量'); ?></td>
                        <td width="15%" class="title"><?php echo Yii::t('hotelOrder', '入住时间'); ?></td>
                        <td width="15%" class="title"><?php echo Yii::t('hotelOrder', '离店时间'); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $model->code; ?></td>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="shopflOrdertabChiren">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="proInfo clearfix">
                                                <?php
                                                echo CHtml::link(CHtml::image(Tool::showImg(ATTR_DOMAIN . '/' . $hotel->thumbnail, 'c_fill,h_800,w_800'), $hotel->name, array('width' => '34', 'height' => '34')), $this->createAbsoluteUrl('/hotel/site/view', array('id' => $hotel->id)), array('class' => 'img', 'title' => $hotel->name)
                                                );
                                                ?>
                                                <?php
                                                echo CHtml::link($hotel->name, $this->createAbsoluteUrl('/hotel/site/view', array('id' => $hotel->id)), array('class' => 'txt', 'title' => $hotel->name, 'target' => '_blank')
                                                );
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td><?php echo $model->room_name; ?></td>
                        <td><?php echo $model->unit_price; ?></td>
                        <td><?php echo $model->rooms; ?></td>
                        <td><?php echo date('Y-m-d', $model->settled_time); ?></td>
                        <td><?php echo date('Y-m-d', $model->leave_time); ?></td>
                    </tr>
                </tbody>
            </table>
            <a id="shopFloddlBtn" class="shopFlupBtn" href="javascript:;"><?php echo Yii::t('hotelOrder', '收起详情'); ?></a>
        </div>

        <div id="shopflcomm_2">
            <span class="shopflbgBox">
                <table width="100%">
                    <tr>
                        <td width="75%">
                            <span class="shopgwLogo"><?php echo Yii::t('hotelOrder', '您正在付款的清单如下'); ?>：</span>
                            <table width="100%" class="mtbot15">
                                <tr>
                                    <td width="65%" class="rtbd">
                                        <div class="florder">
                                            <b><?php echo Yii::t('hotelOrder', '订单'); ?></b>|
                                            <a href="javascript:;"><?php echo $hotel->name; ?></a><span><?php echo Yii::t('hotelOrder', '客房'); ?>：<?php echo $model->room_name; ?></span>
                                        </div>
                                    </td>
                                    <td width="35%" class="meshOrder">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                        <td width="25%" class="bg">
                            <a href="javascript:;" title="<?php echo Yii::t('hotelOrder', '订单详情'); ?>" class="shopFloddlBtn">
                                <?php echo Yii::t('hotelOrder', '订单详情'); ?>
                            </a>
                            <p class="shopfl_jf">
                                <?php echo HtmlHelper::formatPrice('') ?>
                                <?php echo Chtml::label(Common::rateConvert($model->total_price), true, array('id' => 'totalPrice')) ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </span>
        </div>

        <script language="javascript">
            $(function() {
                // 显示了解活动详情
                $('#lottery_detail').click(function() {
                    var dialog = new Dialog({type: 'id', value: 'lottery_detail_text'}, {id: 'show_lottery_detail', title: '<?php echo Yii::t('hotelOrder', '活动详情'); ?>'});
                    dialog.show();
                });
                // 关闭了解活动详情
                $('#understandBtn').click(function() {
                    $('#show_lottery_detail .close').click();
                });

                // 参与抽奖，获取支付信息
                $('#participate_lottery').click(function () {
                    var checked = $(this).attr('checked') == 'checked' ? true : false;
                    $.get(
                        '<?php echo Yii::app()->createAbsoluteUrl('/hotel/order/pay'); ?>',
                        {code: '<?php echo $model->code; ?>', isLottery: checked},
                        function (res) {
                            if (res == null)
                                return;
                            $("#pay_integral_1").val(res.total_pay_integral);
                            $("#pay_integral_2").text(res.total_pay_integral);
                            $("#pay_price").text(res.total_pay_price);
                            $("#owe_integral").text(res.owe_integral);
                        },
                        'json'
                    );
                });
            });
        </script>

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
                'shadeContent' => Yii::t('hotelOrder','正在处理支付中,请稍候...'),
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
                           if($('.payMethodList .quickPayRadio:checked').length==0){
                                $('#quickPayFlag').remove();
                            }
                           {validJs}
                        }
                    }
                    ",
            ),
        ));
        ?>
        <?php $orderPay->needPassword = 1 ?>
        <?php echo $form->hiddenField($orderPay, 'needPassword'); ?>
        <div class="shopflIntegraltitle">
            <font><?php echo Yii::t('hotelOrder', '使用积分支付'); ?></font>
            <?php echo CHtml::link(Yii::t('hotelOrder', '使用帮助'), $this->createAbsoluteUrl('/help'), array('class' => 'shophelpTip', 'target' => '_blank')) ?>
        </div>
        <table width="1160" cellspacing="0" cellpadding="0" border="0" class="shopflIntegralTb">
            <tbody>
                <tr>
                    <td width="27">&nbsp;</td>
                    <td width="874" valign="top" colspan="2">
                        <label>
                            <?php echo $form->checkBox($model, 'is_lottery', array('id' => 'participate_lottery', 'value' => 1)); ?>&nbsp;
                            <span class="sweepstakes">
                                <b class="red">(<?php echo Yii::t('hotelOrder', '仅需') . $params['luckRation'] . Yii::t('hotelOrder', '积分'); ?>)</b>
                                <?php echo Yii::t('hotelOrder', '即可参与盖网抽奖活动'); ?>
                            </span>
                        </label>
                        <div><?php echo $form->error($model, 'is_lottery', array('inputID' => 'participate_lottery'), false); ?></div>
                    </td>
                    <td width="237" align="center">
                        <a class="btnEventDetail" id="lottery_detail" href="javascript:;"><?php echo Yii::t('hotelOrder', '了解活动详情'); ?></a>
                    </td>
                </tr>
                <tr>
                    <td width="27">&nbsp;</td>
                    <td width="170" valign="top" class="tdft">
                        <?php echo CHtml::activeRadioButton($orderPay, 'payWay', array('value' => OnlinePay::PAY_WAP_INTEGRAL, 'id' => 'integral_pay', 'uncheckValue' => null)) ?>
                        <?php echo CHtml::label(Yii::t('hotelOrder', '选择积分支付'), 'integral_pay'); ?>：
                    </td>
                    <td width="704" class="tdft">
                        <?php echo CHtml::textField('pay_integral_1', $payDetail['total_pay_integral'], array('class' => 'input_1', 'readonly' => 'readonly')); ?>
                        <?php echo Yii::t('hotelOrder', '积分'); ?>
                        <font class="shopfl_jf">=<?php echo HtmlHelper::formatPrice(''); ?>
                        <?php echo Chtml::label($payDetail['total_pay_price'], true, array('id' => 'pay_price')) ?>
                        </font>
                        <?php echo $form->error($orderPay, 'payWay', array('style' => 'font-size: 12px'), false, false); ?>
                        <?php echo $form->error($orderPay, 'orderAmount', array('style' => 'font-size: 12px'), false, false); ?>
                        <p class="canUse"><?php echo Yii::t('hotelOrder', '您当前可用盖网积分'); ?>
                            <b class="red"><?php echo $payDetail['surplus_integral'] ?></b>
                            <?php echo Yii::t('hotelOrder', '个，需付积分'); ?>
                            <b class="red">
                                <?php echo CHtml::label($payDetail['total_pay_integral'], true, array('id' => 'pay_integral_2')) ?><?php echo Yii::t('hotelOrder', '个'); ?>
                            </b>
                            <?php echo $form->error($orderPay, 'balance', array('style' => 'font-size: 12px'), false, false); ?>
                        </p>
                    </td>
                    <td width="237" align="center" class="tt" style="display: none"><p><?php echo Yii::t('hotelOrder', '还需付款'); ?>
                        <p class="shopfl_jf">
                            <?php echo Chtml::label($payDetail['owe_integral'], true, array('id' => 'owe_integral')) ?><?php echo Yii::t('hotelOrder', '个积分'); ?>
                        </p>
                    </td>
                </tr>
				
				
				<tr>
					<td colspan="4">
					
                <div class="shopflPasswordBox shopflPasswordBox2 showPassword">
                    <dl class="clearfix">
                        <dt><?php echo Yii::t('hotelOrder', '盖网支付密码'); ?>：</dt>
                        <dd>
                            <?php echo $form->passwordField($orderPay, 'password', array('class' => 'input_1 input_2')); ?>
                            <?php echo $form->error($orderPay, 'password'); ?>
                            <?php
                                echo CHtml::link(Yii::t('hotelOrder', '修改支付密码'), $this->createAbsoluteUrl('/member/member/password'), array(
                                    'class' => 'shopflxgBtn', 'target' => '_blank', 'title' => Yii::t('hotelOrder', '修改支付密码'))
                                );
                            ?>
                        </dd>
                    </dl>
					<div class="do">
						<?php echo CHtml::submitButton('', array('class' => 'shopflpaymentBtn shopflpaymentBtn3')); ?>
					</div>
                </div>
					</td>
				</tr>

                <tr>
                    <td width="27">&nbsp;</td>
                    <td colspan="3">
                        <span class="shopflonlinQQ">
                            <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $params['freightQQ']; ?>&amp;site=qq&amp;menu=yes" title="<?php echo Yii::t('hotelOrder', '联系客服'); ?>" class="shopflonlinBtn"></a>
                            <span>
                                <?php echo Yii::t('hotelOrder', '如您对酒店预订有任何问题，请联系盖网客服。客服电话'); ?>：
                                <font class="red"><?php echo $params['hotelServiceTel']; ?></font>
                            </span>
                        </span>
                        <span class="shopflonlinTip">
                            <?php echo Yii::t('hotelOrder', '如您的账号没有可支付积分，请使用以下方式支付或{a}后支付。', array('{a}' => CHtml::link(Yii::t('hotelOrder', '充值积分'), $this->createAbsoluteUrl('/member/recharge'), array('class' => 'ft005aa0', 'title' => Yii::t('hotelOrder', '充值积分'), 'target' => '_blank')))); ?>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- 支付方式切换-->
        <script type="text/javascript">
            $(function(){
                $(".ZF_way").click(function(){
                    $(".ZF_way").removeClass("ZF_way_sel");
                    $(this).addClass("ZF_way_sel");
                    if($(this).attr("tag")=="1"){
                        $(".ZF_way_main1").show();
                        $(".ZF_way_main2").hide();
                    }else{
                        $(".ZF_way_main2").show();
                        $(".ZF_way_main1").hide();
                    }
                });
            })
        </script>
        <div class="ZF_MK">
            <div class="main1box">
                <div class="ZF_title">
                    <div class="ZF_way ZF_way1 ZF_way_sel" tag="1">快捷支付</div>
                    <div class="ZF_way ZF_way2" tag="2">网银支付</div>
                    <div class="clear"></div>
                </div>
                <?php if (Tool::getConfig('payapi', 'umQuickEnable') === 'true'): ?>
                <div class="ZF_way_main1 ZF_way_main">
                    <div class="main1box">
                        <div class="payMethodList">
                            <input type="hidden" name="quickPay" id="quickPayFlag" value="<?php echo OnlinePay::PAY_UM_QUICK ?>"/>
                            <ul class="payType" style="margin:0 0 0 5px;">
                                <?php
                                //快捷支付
                                $cardList = PayAgreement::getCardList($this->getUser()->gw);
                                /** @var PayAgreement $v */
                                foreach($cardList as $v): ?>
                                    <li style="height: auto;">
                                        <?php echo CHtml::radioButton('OrderPayForm[payWay]','',array('id'=>'quickPay_'.$v->id,'class'=>'quickPayRadio','value'=>$v->id,'style'=>'float:left;margin:18px 0 0 5px;')) ?>
                                        <label for="<?php echo 'quickPay_'.$v->id ?>">
                                            <div class="<?php echo $v->bank ?> PMImg"></div>
                                            <div class="PMNum">****<?php echo $v->bank_num ?></div>
                                            <div class="PMType"><?php echo $v::getCardType($v->card_type) ?></div>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                                <li style="height: 50px;text-align:center;" >
                                    <?php echo CHtml::radioButton('OrderPayForm[payWay]','', array('value' => OnlinePay::PAY_UM_QUICK, 'uncheckValue' => null, 'id' => 'selUmQuick', 'checked' => false,'style'=>'float:left;margin:18px 0 0 5px;')); ?>
                                    <label for="selUmQuick">
                                        <span class="BEST" style="background-position: -11px -235px;width:75px"></span>
                                        <div class=""></div>
                                        <div class="PMNum"><strong style="color:#000;font-size: 12px;">支付并绑定银行卡</strong></div>
                                    </label>
                                </li>
                                <li style="height: 50px;text-align:center;">
                                    <a href="<?php echo $this->createUrl('/member/quickPay/bindCard',array('code'=>$this->getParam('code')));?>" title="添加银行卡">
                                        <img height="50" src="../images/bgs/plus_bank_cards.gif" />
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="clear"></div>
                        <div class="shopflPasswordBox showNext" >
                            <?php echo CHtml::submitButton('下一步', array('class' => 'shopflpaymentBtn shopflpaymentBtn2 shopflpaymentBtn3')); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="ZF_way_main2 ZF_way_main">
                    <?php $this->renderPartial('_internetbank', array('model' => $orderPay)); ?>
                    <div class="clear"></div>
                    <div class="shopflPasswordBox showNext" >
                        <?php echo CHtml::submitButton('下一步', array('class' => 'shopflpaymentBtn shopflpaymentBtn2 shopflpaymentBtn3')); ?>
                    </div>
                </div>

            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<div class="eventDetail_pop" id="lottery_detail_text" style="display: none">
    <div class="eventDetail_text">
        <div class="con">
            <?php
            echo Yii::t(
            'hotelOrder', '在盖象商城预订酒店，确认预订信息无误后，多种支付方式均可获得积分增值。同时，可以获得一次参与积分抽奖的机会。在支付页面打钩选择支付{lpi}个积分参与抽奖活动，可额外获得积分赠送。', array('{lpi}' => $params['luckRation'])
            );
            ?>
        </div>
        <div class="do"><input type="button" class="btnHasUnderstand" id="understandBtn" value="<?php echo Yii::t('hotelOrder', '我已了解'); ?>"/></div>
    </div>
</div>
<script>
    //积分与网银支付选择
    $(".showNext").hide();
    $(".payMethodList input,.bank input").click(function(){
        var type = $("#integral_pay").attr('type');
        if(type=='radio' || (type=='checkbox' && !$("#selJF").get(0).checked) ){
            $(".showPassword").hide();
        }
        $(".showNext").show();
    });
    $("#integral_pay").click(function(){
        if(this.type=='checkbox') return ; //如果是checkbox，则是积分+网银支付
        $(".showPassword").show();
        $(".showNext").hide();
    });
</script>
