<?php
/* @var $this PayController */
/* @var $model OrderForm */
/** @var $form CActiveForm */
//$validEnd = Tool::cache('PaycheckTime')->get($this->getParam('code'));
$validEnd = false;
$orderCache = ActivityData::getOrderCacheByCode($this->getParam('code'));
if(!empty($orderCache)){
    $validEnd = $orderCache['create_time'] + SeckillRedis::TIME_INTERVAL_ORDER;
}
Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero');
?>

<script src="<?php echo DOMAIN.'/js/jquery.blockUI.js'?>"></script>
<div class="main clearfix">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'order-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            //如果密码框是隐藏状态，则不需要密码验证
            'beforeValidate'=>"js:function(form){
                if($('#OrderForm_password3:hidden').length){
                    $('#OrderForm_needPassword').val(0);
                     $('#OrderForm_password3').val(12345679);
                }else{
                    $('#OrderForm_needPassword').val(1);
                }
                return true;
            }",
            'afterValidate' => "js:function(form, data, hasError){
                        if (!hasError) {
                            if($('.payMethodList .quickPayRadio:checked').length==0){
                                $('#quickPayFlag').remove();
                            }
                          $.blockUI({ message: '<div class=\"pay-tip\"><p>正在处理支付中,请稍候...</p></div>' });
                           return true;
                        }
                    }
                    ",
        ),
    ));
    ?>
    <?php echo $form->hiddenField($model, 'totalPrice'); ?>
    <?php echo $form->error($model, 'totalPrice'); ?>
    <?php $model->needPassword = 1 ?>
    <?php echo $form->hiddenField($model, 'needPassword'); ?>
    <?php echo $form->hiddenField($model, 'code', array('value' => $this->getParam('code'))); ?>
    <div class="main">
        <span class="shopFlowPic_3"></span>
        <div class="shopFlGgbox">
            <span class="shopflbgTitle"><?php echo Yii::t('order', '我已核实订单，同意支付！'); ?></span>
            <div id="shopflcomm_1" style="display:none; overflow:hidden;">
                <table width="1140" border="0" cellspacing="0" cellpadding="0" class="shopflOrdertab">
                    <tr>
                        <td width="20%" class="title"><?php echo Yii::t('order', '订单号'); ?></td>
                        <td width="40%" class="title"><?php echo Yii::t('order', '商品名称'); ?></td>
                        <td width="25%" class="title"><?php echo Yii::t('order', '收货地址'); ?></td>
                        <td width="15%" class="title"><?php echo Yii::t('order', '订单总价'); ?></td>
                    </tr>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td align="center" valign="middle"><?php echo $order->code ?></td>
                            <td>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="shopflOrdertabChiren">
                                    <?php foreach ($order->orderGoods as $goods): ?>
                                
                                        <tr>
                                            <td>
                                                <div class="proInfo clearfix">
                                                    <a href="<?php echo $this->createAbsoluteUrl('/goods/view/', array('id' => $goods->goods_id)) ?>" class="img" target="_blank" >
                                                        <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $goods->goods_picture, 'c_fill,h_34,w_34'), $goods->goods_name, array('width' => '34', 'height' => '34')) ?>
                                                    </a>
                                                    <?php echo CHtml::link($goods->goods_name, $this->createAbsoluteUrl('/goods/view', array('id' => $goods->goods_id)), array('target' => '_blank')) ?>
                                                    <?php echo Yii::t('order', '商家'); ?>：<?php echo $order->store->name; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </td>
                            <td align="center" valign="middle"><?php echo $order->address ?></td>
                            <td align="center" valign="middle"><?php echo HtmlHelper::formatPrice(sprintf('%0.2f', $order->pay_price)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <a href="javascript:;" class="shopFlupBtn" id="shopFloddlBtn"><?php echo Yii::t('order', '收起详情'); ?></a> </div>
            <div id="shopflcomm_2" >
                <span class="shopflbgBox">
                    <table width="100%">
                        <tr>
                            <td width="75%">
                                <span class="shopgwLogo"><?php echo Yii::t('order', '您正在付款的清单如下'); ?>：</span>
                                <table width="100%" class="mtbot15">
                                    <tr>
                                        <td width="65%" class="rtbd">
                                            <?php foreach ($orders as $k => $order): ?>
                                                <?php $goods = $order->orderGoods; ?>
                                                <div class="florder">
                                                    <b><?php echo Yii::t('order', '订单'); ?><?php echo $k+1; ?></b> |
                                                    <?php echo CHtml::link($goods[0]->goods_name, $this->createAbsoluteUrl('/goods/view/', array('id' => $goods[0]->goods_id)), array('target' => '_blank')) ?>
                                                    <span><?php echo Yii::t('order', '商家'); ?>：<?php echo $order->store->name; ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </td>
                                        <td width="35%" class="meshOrder">
                                            <b><?php echo Yii::t('order', '支付{a}笔订单', array('{a}' => count($orders))); ?></b>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="25%" class="bg">
                                <a title="<?php echo Yii::t('order', '订单详情'); ?>" class="shopFloddlBtn" ><?php echo Yii::t('order', '订单详情'); ?></a>
                                <p><?php echo Yii::t('order', '实含运费'); ?></p>
                                <p class="shopfl_jf"><?php echo HtmlHelper::formatPrice($totalPrice); ?></p>
                            </td>
                        </tr>
                    </table>
                </span>
            </div>
            <?php if($validEnd): ?>
                <br/><span class="sx_date">还剩<span id="clock"></span>,请尽快在这个时间内完成支付!</span>
            <?php endif; ?>
            <?php if($validEnd == false && ($orders[0]['source_type'] != Order::SOURCE_TYPE_HB || $totalPrice == 0)): ?>
            <div class="shopflIntegraltitle">
                <font><?php echo Yii::t('order', '使用积分支付'); ?></font>　
                <?php echo CHtml::link(Yii::t('order', '使用帮助'), $this->createAbsoluteUrl('/help'), array('class' => 'shophelpTip', 'title' => Yii::t('order', '使用帮助'))) ?>
            </div>

            <table width="1160" border="0" cellspacing="0" cellpadding="0" class="shopflIntegralTb">
                <tr>
                    <td width="27">&nbsp;</td>
                    <td width="150" valign="top" class="tdft">
                        <?php
                        if($sourceType==Order::SOURCE_TYPE_SINGLE || $sourceType == Order::SOURCE_TYPE_JFXJ){
                            echo $form->checkBox($model,'jfPay',array('value' => 'JFPay', 'uncheckValue' => null, 'id' => 'selJF', 'checked' => 'checked'));
                        }else{
                            echo $form->radioButton($model, 'payType', array('value' => 'JF', 'uncheckValue' => null, 'id' => 'selJF', 'checked' => 'checked'));
                        }
                        ?>
                        <label for="selJF"><?php echo Yii::t('order', '选择积分支付'); ?>：</label>
                    </td>
                    <td width="704" class="tdft">
                        <?php
                             if($sourceType == Order::SOURCE_TYPE_SINGLE){//特殊商品支付
                                 $totalPrice = $singlePayDetail['jfPay'] * 1;
                             }
                             if($sourceType == Order::SOURCE_TYPE_JFXJ){//积分+现金
                                 $totalPrice = $jfxj['jfPay'] * 1;
                                 $singlePayDetail['onlinePay'] = $jfxj['onlinePay'];
                                 $singlePayDetail['jfPay'] = $jfxj['jfPay'];
                             }
                         ?>
                        <input type="text" name="selectAccount" class="input_1" value="<?php echo Common::convert($totalPrice) ?>" readonly="readonly"/>
                        <?php echo Yii::t('order', '积分'); ?><font class="shopfl_jf">=<?php echo HtmlHelper::formatPrice($totalPrice) ?></font>
                        <p class="canUse">
                            <?php echo Yii::t('order', '您当前可用盖网积分{a}个', array('{a}' => Common::convertSingle($accountMoney))); ?>
                        </p>
                    </td>
                    <td width="237" align="center" class="tt">
                        <div id="onlinePay" style="display: none"><p><?php echo Yii::t('singlePay', '还需在线付款'); ?></p>
                            <p class="shopfl_jf" ><?php echo HtmlHelper::formatPrice($singlePayDetail['onlinePay']) ?></p>
                        </div>
                    </td>
                </tr>
				<tr>
					<td colspan="4">
						<div class="shopflPasswordBox shopflPasswordBox2  showPassword">
							<dl class="clearfix">
								<dt><?php echo Yii::t('order', '盖网支付密码'); ?>：</dt>
								<dd>
									<p>
										<?php echo $form->passwordField($model, 'password3', array('class' => 'input_1')) ?>
										<?php echo CHtml::link(Yii::t('order', '修改支付密码'), $this->createAbsoluteUrl('/member/member/password'), array('class' => 'shopflxgBtn', 'title' => Yii::t('order', '修改支付密码'))) ?>
									</p>
									<span id="error" class=""><?php echo $form->error($model, 'password3'); ?></span>
								</dd>
							</dl>
							<div class="do">
								<?php echo $form->hiddenField($model, 'totalPrice'); ?>
								<?php echo $form->hiddenField($model, 'code', array('value' => $this->getParam('code'))); ?>
								<?php echo CHtml::submitButton('', array('class' => 'shopflpaymentBtn')); ?>
							</div>
						</div>
					</td>
				</tr>
                <tr>
                    <td width="27">&nbsp;</td>
                    <td colspan="3">
                        <span class="shopflonlinQQ">
                            <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $frConfig['freightQQ']; ?>&amp;site=qq&amp;menu=yes" title="<?php echo Yii::t('order', '联系客服'); ?>" class="shopflonlinBtn"></a>
                            <span><?php echo Yii::t('order', '可联系盖网客服，修改运费。客服电话'); ?>：<font class="red"><?php echo $frPhone; ?></font></span>
                        </span>
                        <span class="shopflonlinTip">
                            <?php echo Yii::t('order', '如您的账号没有可支付积分，请使用以下方式支付或{a}后支付。', array('{a}' => CHtml::link(Yii::t('order', '充值积分'), $this->createAbsoluteUrl('/member/recharge'), array('class' => 'ft005aa0', 'title' => '充值积分', 'target' => '_blank')))); ?>
                        </span>
                    </td>
                </tr>
            </table>
            <?php else: ?>
                <script>
                    //暂时红包商品支付默认选择翼支付.不使用积分支付
                    $(function(){
                        $('#selBEST').attr('checked','checked');
                    });
                </script>
            <?php endif; ?>
			<!-- 支付方式切换-->
				<script type="text/javascript">
					$(function(){
						$(".ZF_way").click(function(){
							$(".ZF_way").removeClass("ZF_way_sel");
							$(this).addClass("ZF_way_sel");
							if($(this).attr("tag")=="1"){
								$(".ZF_way_main1").show();
								$(".ZF_way_main2").hide();
								
								var wayCheck = $('.ZF_way_main1').find('input[type="radio"]:checked').val();
								if(typeof(wayCheck) == 'undefined' ){
								    $(".ZF_way_main1").find(".showNext").hide();
								}else{
								    $(".ZF_way_main1").find(".showNext").show();
								}
							}else{
								$(".ZF_way_main2").show();
								$(".ZF_way_main1").hide();
								
								var wayCheck = $('.ZF_way_main2').find('input[type="radio"]:checked').val();
								if(typeof(wayCheck) == 'undefined' ){
								    $(".ZF_way_main2").find(".showNext").hide();
								}else{
								    $(".ZF_way_main2").find(".showNext").show();
								}
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
					<div class="ZF_way_main1 ZF_way_main">
						<?php if (Tool::getConfig('payapi','umQuickEnable') === 'true'): ?>
						<!--<div class="shopflIntegraltitle">
							<font>使用快捷支付</font>
						</div>-->
						<div>
							<div>
								<?php if($totalPrice != 0 || in_array($sourceType,array(Order::SOURCE_TYPE_JFXJ,Order::SOURCE_TYPE_SINGLE))): ?>
									<div class="payMethodList">
										<input type="hidden" name="quickPay" id="quickPayFlag" value="<?php echo OnlinePay::PAY_UM_QUICK ?>"/>
										<ul class="payType" style="margin:0 0 0 5px;">
											<?php
											//快捷支付
											$cardList = PayAgreement::getCardList($this->getUser()->gw);
											/** @var PayAgreement $v */
											foreach($cardList as $v): ?>
												<li style="height: auto;">
													<?php echo CHtml::radioButton('OrderForm[payType]','',array(
														'id'=>'quickPay_'.$v->id,
														'value'=>$v->id,
														'style'=>'float:left;margin:18px 0 0 5px;',
														'class'=>'quickPayRadio',
													)) ?>
													<label for="<?php echo 'quickPay_'.$v->id ?>">
														<div class="<?php echo $v->bank ?> PMImg"></div>
														<div class="PMNum">****<?php echo $v->bank_num ?></div>
														<div class="PMType"><?php echo $v::getCardType($v->card_type) ?></div>
													</label>
												</li>
											<?php endforeach; ?>

											<li style="height: 50px;text-align:center;" >
												<?php echo $form->radioButton($model, 'payType', array('value' => OnlinePay::PAY_UM_QUICK, 'uncheckValue' => null, 'id' => 'selUmQuick', 'checked' => false,'style'=>'float:left;margin:18px 0 0 5px;')); ?>
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
                                    <div class="shopflPasswordBox showNext">
                                        <div class="do">
                                            <?php echo CHtml::submitButton('下一步', array('class' => 'shopflpaymentBtn shopflpaymentBtn2')); ?>
                                        </div>
                                    </div>
									<?php
								else:?>
									<style>
										.shopFlGgbox #tabs1 .main1box .shopflPasswordBox{border-top: none};
									</style>
								<?php endif ?>
							</div>
						</div>
						<?php endif; ?>
					</div>
					<div class="ZF_way_main2 ZF_way_main">
						<div>
							<div>
								<?php if($totalPrice != 0 || in_array($sourceType,array(Order::SOURCE_TYPE_JFXJ,Order::SOURCE_TYPE_SINGLE))): ?>
								<?php
										echo $this->renderPartial('_bankpay', array('form' => $form, 'model' => $model,'cardList'=>$cardList));
								 else:?>
									<style>
										.shopFlGgbox #tabs1 .main1box .shopflPasswordBox{border-top: none};
									</style>
								  <?php endif ?>
							  
								<div class="shopflPasswordBox showNext">
									<div class="do">
										<?php echo CHtml::submitButton('下一步', array('class' => 'shopflpaymentBtn shopflpaymentBtn2')); ?>
									</div>
								</div>
							  
							</div>
						</div>
					</div>
				</div>
			</div>
			

        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>

<?php if($sourceType==Order::SOURCE_TYPE_SINGLE || $sourceType == Order::SOURCE_TYPE_JFXJ): //特殊商品支付提醒?>
<?php Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero') ?>
<script>
    $("#onlinePay").show();
    $(".showPassword .shopflpaymentBtn").hide(); //隐藏确定付款按钮
    $("#selJF").click(function(){
        if(this.checked){
            $("#onlinePay .shopfl_jf").html("<?php echo HtmlHelper::formatPrice($singlePayDetail['onlinePay']); ?>");
        }else{
            $("#onlinePay .shopfl_jf").html("<?php echo HtmlHelper::formatPrice($singlePayDetail['onlinePay'] + $singlePayDetail['jfPay']); ?>");
        }
    });
    $(".shopflpaymentBtn").click(function(){
        if (!$("input[name='OrderForm[payType]']:checked").length) {
            $('#error').addClass('shopwongset');
            $('#error').html('<?php echo Yii::t('order', '请选择在线支付方式'); ?>');
            return false;
        }
    });

    art.dialog({
        icon: 'succeed',
        content: '<dl style="font-size:14px;"><dt><h1><?php echo Yii::t('order','该订单有以下支付方式'); ?></h1></dt><dd>1.<?php echo Yii::t('singlePay','部分积分+在线支付'); ?></dd><dd>2.<?php echo Yii::t('singlePay','全额在线支付'); ?></dd></dl>',
        ok: true,
        okVal:'<?php echo Yii::t('member','确定') ?>',
        title:'<?php echo Yii::t('member','消息') ?>',
        lock:true
    });

</script>
<?php endif; ?>

<script>

    //积分与网银支付选择
    $(".showNext").hide();
    $(".payMethodList input,.bank input").click(function(){
        var type = $("#selJF").attr('type');
        if(type=='radio' || (type=='checkbox' && !$("#selJF").get(0).checked) ){
            $(".showPassword").hide();
        }
        $(".showNext").show();
    });
    $("#selJF").click(function(){
       if(this.type=='checkbox') return ; //如果是checkbox，则是积分+网银支付
        $(".showPassword").show();
        $(".showNext").hide();
    });
</script>
<?php if($validEnd): ?>
    <script src="<?php echo DOMAIN ?>/js/jquery.countdown.min.js"></script>
    <script>
        var isClose = 0;
        function closeOrder(){
            isClose = 1;
            jQuery.ajax({
                type:"POST",async:false,
                url:"<?php echo $this->createUrl('seckillFlow/close');?>",
                data: {
                    "YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
                    "code":"<?php echo $this->getParam('code');?>"
                },
                success: function() {
                    art.dialog({
                        icon: 'succeed',
                        content: '<?php echo Yii::t('member','订单超时，已被取消！') ?>',
                        ok: function(){
                            location.href='<?php echo $this->createUrl('/member/order/detail',array('code' => $this->getParam('code')));?>';
                        },
                        okVal:'<?php echo Yii::t('member','确定') ?>',
                        title:'<?php echo Yii::t('member','消息') ?>'
                    });
                },
                error: function() {
                    location.href='<?php echo $this->createUrl('/member/order/admin');?>';
                }
            });
        }
        <?php if($validEnd && $validEnd <= time()): ?>closeOrder();<?php endif; ?>

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