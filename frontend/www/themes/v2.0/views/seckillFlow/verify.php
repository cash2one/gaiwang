<?php
/* @var $this SeckillFlowController */
Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/global.css');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/module.css');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/cart.css');
Yii::app()->clientScript->registerCoreScript('jquery');
?>
<script src="<?php echo $this->theme->baseUrl . '/js/jquery.SuperSlide.2.1.source.js' ?>" type="text/javascript"></script>
<!--------------------------主体---------------------------------->

<div class="pages-header">
    <div class="w1200">
        <div class="pages-logo">
            <a href="<?php echo DOMAIN ?>" title="<?php echo Yii::t('site', '盖象商城') ?>" class="gx-top-logo"
               id="gai_link">
                <img width="187" height="56" alt="<?php echo Yii::t('site', '盖象商城') ?>"
                     src="<?php echo $this->theme->baseUrl . '/'; ?>images/bgs/top_logo.png"/>
            </a>
        </div>
        <div class="pages-title icon-cart"><?php echo Yii::t('orderFlow', '确认订单'); ?></div>
        <div class="shopping-process clearfix">
            <div class="process-li icon-cart on"><?php echo Yii::t('orderFlow', '查看购物车'); ?></div>
            <span class="process-out on process-out01"></span>
            <div class="process-li icon-cart on"><?php echo Yii::t('orderFlow', '确认订单'); ?></div>
            <span class="process-out process-out02"></span>
            <div class="process-li icon-cart"><?php echo Yii::t('orderFlow', '支付'); ?></div>
            <span class="process-out process-out03"></span>
            <div class="process-li icon-cart"><?php echo Yii::t('orderFlow', '确认收货'); ?></div>
            <span class="process-out process-out04"></span>
            <div class="process-li icon-cart"><?php echo Yii::t('orderFlow', '完成'); ?></div>
        </div>
    </div>
</div>

<?php echo CHtml::form($this->createAbsoluteUrl('/seckillFlow/order'), 'post', array('name' => 'SendOrderForm', 'id' => 'order_form')); ?>
<div class="shopping-pay">  
    <div class="orders-confirm">
        <?php $this->renderPartial('_address', array('address' => $address, 'goods'=>$cartInfo['cartInfo'], 'goods_select' => array($goods_select))) ?>
        
        <div class="orders-information">
            <p class="orders-information-title"><?php echo Yii::t('orderFlow', '确认商品信息'); ?></p>    
            <div class="orders-info-top clearfix">
                <span class="product-name"><?php echo Yii::t('orderFlow', '商品'); ?></span>
                <span class="product-price"><?php echo Yii::t('orderFlow', '单价（元）'); ?></span>
                <span class="product-num"><?php echo Yii::t('orderFlow', '数量'); ?></span>
                <span class="product-pre"><?php echo Yii::t('orderFlow', '优惠'); ?></span>
                <span class="product-subtotal"><?php echo Yii::t('orderFlow', '小计'); ?></span>
            </div>
            
            <div class="orders-info-center">
                <?php
					$j = 1;
					$totalPrice = 0; //总价，不包含运费
					$totalFreight = 0; //总运费
					foreach ($cartInfo['cartInfo'] as $k => $v):
						$orderTotalPrice = 0;//每一笔订单的总价
                ?>
                <div class="orders-info-item">
                    <p class="item-name icon-cart"><?php echo Yii::t('orderFlow', '店铺'); ?>： <?php echo $v['storeName'];?></p>
                    <p style="height:24px; line-height:24px;">
                      <span class="sx_date" style="color:#F00;"><?php echo Yii::t('orderFlow', '还剩<span id="clock"></span>,请尽快在这个时间内确认下单!'); ?></span>
                      <span class="cancel"><?php echo CHtml::link('取消购买', array('/seckillFlow/cancel', 'goods_id'=>$goodsId), array('target' => '_self', 'title'=>'取消购买')); ?></span>
                    </p>
                    
                    <?php $i = 1;
                        foreach ($v['goods'] as $key => $val):
                            $val['price'] = Common::rateConvert($val['price']);
							$seting = ActivityData::getActivityRulesSeting($val['rules_seting_id']);//优惠信息
                    ?>
                    <div class="item-info clearfix">
                        <div class="product-img">
						  <?php echo CHtml::link( CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $val['thumbnail'], 'c_fill,h_68,w_68')),array('/goods/view', 'id' => $val['goods_id']), array('target' => '_blank', 'width'=>68,'height'=>68) );
						?>      
                        </div>
                        <div class="product-name">
                            <p class="title"><?php echo CHtml::link($val['name'], array('/goods/view', 'id'=>$val['goods_id']), array('target' => '_blank')) ?></p>
                            <p class="txtle"><?php echo $val['spec'] ?></p>
                        </div>
                        <div class="product-price"><?php echo $val['price']; ?></div>
                        <div class="product-num"><?php echo $val['quantity']; ?></div>
                        <div class="product-pre">
						<?php if( !empty($seting) ){
						      if($seting['discount_rate']>0){ echo '已打: '.($seting['discount_rate']/10).'折';}else{ echo '固定价格: '.$seting['discount_price'].'元'; }
						}?>
                        </div>
                        <div class="product-subtotal"><?php echo $val['price']; ?></div>
                    </div>
                    
                    <div class="item-directions clearfix">
                        <div class="left">
                            <span><?php echo Yii::t('orderFlow', '补充说明'); ?>：</span>
                            <span><input type="text" name="message[<?php echo $k ?>]" class="input-problem" placeholder="<?php echo Yii::t('orderFlow', '选填，补充填写其他特殊需求'); ?>"/></span>
                            <span><?php echo Yii::t('orderFlow', '限制30字以内'); ?></span>
                        </div>
                        <div class="right">
                            
                            <p class="delivery">
                                <span class="favorable-name"><?php echo Yii::t('orderFlow', '运费'); ?>：</span>
                                <span class="favorable-box">
                                <?php
								  if ($val['freight_payment_type'] != Goods::FREIGHT_TYPE_MODE) {
									  echo Goods::freightPayType($val['freight_payment_type']);
								  } else {
									  if (count($this->freight[$key]) == 1) {
										  echo current($this->freight[$key]);
										  echo CHtml::hiddenField('freight[' . $key . ']', key($this->freight[$key]));
									  } else {
										  echo CHtml::dropDownList('freight[' . $key . ']', '', $this->freight[$key],
											  array('class' => 'freightSelect', 'data-key' => $key));
									  }
								  }
                                ?>
                                </span>
                                <?php
									if ($val['freight_payment_type'] != Goods::FREIGHT_TYPE_MODE) {
										$freight = '0.00';
									} else {
										$freight = explode('|', (key($this->freight[$key])));
										$freight = $freight[1];
									}
									$freight = Common::rateConvert($freight);
									$totalFreight += $freight;
                                ?>
                                <span class="favorable-price freight" data-key="<?php echo $key ?>"><?php echo $freight; ?></span>
                            </p>
                            
                        </div>
                    </div>
                    <p class="item-together"><?php echo Yii::t('orderFlow', '店铺合计'); ?>：（<?php echo Yii::t('orderFlow', '含运费'); ?>）
                      <?php echo HtmlHelper::formatPrice('') ?>
                      <span class="subtotal" data-key="<?php echo $key ?>" data-price="<?php echo number_format($val['price'] * $val['quantity'], 2, '.', '') ?>">
					  <?php
						  $subtotal = $val['price'] * $val['quantity'];
						  $orderTotalPrice += $subtotal;
						  $totalPrice += $subtotal;
						  echo number_format($subtotal+$freight, 2, '.', '');
					 ?>
                     </span></p>
                </div>
                <?php $i++; endforeach; ?>
                 
             </div>
             <?php $j++; endforeach;?>
       
        </div>
        
        <div class="orders-menu">
            <p class="menu-use">
            <p class="menu-price"><?php echo Yii::t('orderFlow', '实付款'); ?>： <?php echo HtmlHelper::formatPrice('') ?><span id="real_total">
			  <?php echo number_format($totalPrice+$totalFreight, 2, '.', ''); ?></span></p>
            <p class="menu-dete">
              <input type="hidden" value="<?php echo $totalPrice ?>" id="allPrice"/>
              <input type="hidden" value="<?php echo Tool::authcode(serialize($this->freight)) ?>" name="freight_array"/>
              <input type="hidden" value="<?php echo Tool::authcode(serialize($goods_select)) ?>" name="goods_select"/>
              <input type="submit" class="btn-dete" title="<?php echo Yii::t('orderFlow', '提交订单'); ?>" id="submitToPay" value="<?php echo Yii::t('orderFlow', '提交订单'); ?>"/></p>
            <div class="menu-address">
                <?php $select_address = $this->getSession('select_address'); ?>
                <?php foreach ($address as $va): ?>
                    <?php if ($select_address['id'] == $va['id']): ?>
                        <?php $address = implode(' ', array($va['province_name'], $va['city_name'], $va['district_name'], $va['street'])); ?>
                        <p class="address"><b><?php echo Yii::t('orderFlow', '寄送至'); ?>：</b>
                            <?php echo $address ?>
                        </p>
                        <p><b><?php echo Yii::t('orderFlow', '收货人'); ?>：</b>
                            <?php echo $va['real_name'], ' ', substr($va['mobile'], 0, 3) . '*****' . substr($va['mobile'], -3); ?>
                        </p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        
    </div>  
</div>
<?php echo CHtml::endForm(); ?> 
<!-- -----------------主体 End--------------------------->

<script>
    //运费选择
    $(".freightSelect").change(function () {
        var freight = this.value.split('|');
        freight = parseFloat(freight[2]);
        var goodsKey = $(this).attr('data-key');
        //运费显示
        $(".freight").each(function () {
            var domEle = this;
            if ($(domEle).attr('data-key') == goodsKey) {
                $(domEle).text(freight);
            }
        });

        $("#real_total").text('');
        var total_price = 0.00; ////总计
        //小计
        $(".subtotal").each(function () {
            var domEle = this;
            if ($(domEle).attr('data-key') == goodsKey) {
                $(domEle).text(function (index, val) {
                    return (parseFloat($(domEle).attr('data-price')) + freight).toFixed(2);
                });
            }
            total_price += parseFloat($(domEle).text());
        });
        $("#real_total").text(total_price.toFixed(2));
        /*秒杀没有这两项
		var total_red = parseFloat($('#pay_with_yh').text());
        if( isNaN(total_red)){
            total_red = 0.00;
        }
        $('#pay_total').text((parseFloat($("#real_total").text()) - total_red).toFixed(2));
		*/
    });
</script>
<script src="<?php echo DOMAIN.'/js/tool.js'?>"></script>
<script src="<?php echo DOMAIN ?>/js/jquery.countdown.min.js"></script>
<script>
    var isCancel = 0;
    function cancelOrder(){
        isCancel = 1;
        jQuery.ajax({
            type:"GET",async:false,
            url:"<?php echo $this->createUrl('seckillFlow/cancel');?>",
            data: {
                "goods_id":"<?php echo $goodsId;?>"
            },
            success: function() {
				layer.alert('<?php echo Yii::t('member','超时确认，抢购已被取消！') ?>', {
					skin: 1,closeBtn: 0
				}, function(){
					location.href='<?php echo $this->createUrl('/goods/view',array('id' => $goodsId));?>';
				});
            },
            error: function() {
                location.href='<?php echo $this->createUrl('/member/order/admin');?>';
            }
        });
    }
    var validEnd = '<?php echo date('Y/m/d H:i:s', $validEnd) ?>';
    var validStart = '<?php echo date('Y/m/d H:i:s') ?>';
    $('#clock').countdown(validEnd, function(event) {
        $(this).html(event.strftime('%H:%M:%S'));
        if(isCancel == 0 && event.strftime('%H:%M:%S') == '00:00:00'){
            cancelOrder();
        }
    }, validStart);
</script>