<?php
/** @var $this OrderFlowController */
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/global.css');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/module.css');
Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/cart.css');
Yii::app()->clientScript->registerCoreScript('jquery');
?>
<script src="<?php echo $this->theme->baseUrl . '/js/jquery.SuperSlide.2.1.source.js' ?>" type="text/javascript"></script>
<div class="pages-header">
    <div class="w1200">
        <div class="pages-logo">
            <a href="<?php echo DOMAIN ?>" title="<?php echo Yii::t('site', '盖象商城') ?>" class="gx-top-logo"
               id="gai_link">
                <img width="187" height="56" alt="<?php echo Yii::t('site', '盖象商城') ?>"
                     src="<?php echo $this->theme->baseUrl . '/'; ?>images/bgs/top_logo.png"/>
            </a>
        </div>
        <div class="pages-title icon-cart">确认订单</div>
        <div class="shopping-process clearfix">
            <div class="process-li icon-cart on">查看购物车</div>
            <span class="process-out on process-out01"></span>
            <div class="process-li icon-cart on">确认订单</div>
            <span class="process-out process-out02"></span>
            <div class="process-li icon-cart">支付</div>
            <span class="process-out process-out03"></span>
            <div class="process-li icon-cart">确认收货</div>
            <span class="process-out process-out04"></span>
            <div class="process-li icon-cart">完成</div>
        </div>
    </div>
</div>

<div class="shopping-pay">
    <?php echo CHtml::form($this->createAbsoluteUrl('/orderFlow/order'), 'post', array('name' => 'SendOrderForm', 'id' => 'order_form')) ?>
    <div class="orders-confirm">

        <?php $this->renderPartial('_address', array('address' => $address, 'goods_select' => $goods_select)) ?>

        <div class="orders-information">
            <p class="orders-information-title">确认商品信息</p>
            <div class="orders-info-top clearfix">
                <span class="product-name">商品</span>
                <span class="product-price">单价（元）</span>
                <span class="product-num">数量</span>
                <span class="product-pre">优惠</span>
                <span class="product-subtotal">小计</span>
            </div>
            <?php
            $j = 1;
            $totalPrice = 0; //总价，不包含运费
            $totalFreight = 0; //总运费
            $nowTime = time();
            $redMoney = $redAccount['memberRedAccount'];
            $useTotalRedMoney = 0; //红包使用总额
            foreach ($cartInfo['cartInfo'] as $k => $v):
                $orderTotalPrice = 0;//每一笔订单的总价，包含运费
                $storeFreight = isset($this->storeFreight[$k])?$this->storeFreight[$k]:0; //每一笔订单的总运费
                $totalFreight += $storeFreight;
                $orderTotalPrice += $storeFreight;
            ?>
            <div class="orders-info-center">
                <div class="orders-info-item">
                    <p class="item-name icon-cart">店铺：<?php echo Chtml::link(Tool::truncateUtf8String($v['storeName'],10),array('shop/view','id'=>$k),array('target'=>'_blank')) ?></p>

                    <?php
                    $i = 1;
                    foreach ($v['goods'] as $key => $val):
                        //小计
                        $subTotal = sprintf('%.2f', $val['price'] * $val['quantity']);
                        $val['price'] = Common::rateConvert($val['price']);
                        $seting = ActivityData::getActivityRulesSeting($val['seckill_seting_id']);
                        $relation = ActivityData::getActivityProductRelation($val['goods_id']);
                        $redPrice = 0;
                        if ($val['seckill_seting_id'] > 0 && isset($seting) && $seting['category_id'] == 1 && strtotime($seting['end_dateline']) >= $nowTime && $relation != false) {//参加活动的商品 秒杀除外
                            $redPrice = number_format($val['price'] * $seting['discount_rate'] / 100, 2, '.', '');
                        }
                        $orderTotalPrice += $subTotal - ($redPrice*$val['quantity']);
                        $totalPrice += $subTotal - ($redPrice*$val['quantity']);
                        ?>
                        <div class="item-info clearfix">
                            <div class="product-img">
                                <?php
                                echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $val['thumbnail'], 'c_fill,h_68,w_68'),$val['name'],array('width'=>68,'height'=>68));
                                ?>
                            </div>
                            <div class="product-name">
                                <p class="title">
                                    <?php echo CHtml::link(Tool::truncateUtf8String($val['name'],20), array('/goods/view', 'id'=>$val['goods_id']), array('target' => '_blank')) ?>
                                </p>
                                <p class="txtle"><?php echo $val['spec'] ?></p>
                            </div>
                            <div class="product-price"><?php echo $val['price']; ?></div>
                            <div class="product-num"><?php echo $val['quantity']; ?></div>
                            <div class="product-pre">
                                <?php
                                //优惠
                                if(isset($val['special_name'])){
                                    echo $val['special_name'];
                                }elseif($val['seckill_seting_id'] > 0 && isset($seting) && strtotime($seting['end_dateline'])>=$nowTime && $relation!=false){
                                    echo '<span title="'.$seting['name'].'">'. Tool::truncateUtf8String($seting['name'],8).'</span>';
                                }else{
                                    echo Yii::t('orderFlow', '无');
                                }
                                ?>
                            </div>
                            <div class="product-subtotal">
                                <?php
                                //显示小计、隐藏单个商品运费
                                echo Common::rateConvert($subTotal);
                                if ($val['freight_payment_type'] == Goods::FREIGHT_TYPE_MODE) {
                                    current($this->freight[$key]);
                                    echo CHtml::hiddenField('freight[' . $key . ']', key($this->freight[$key]));
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        $i++;
                    endforeach; ?>

                    <div class="item-directions clearfix">
                        <div class="left">
                            <span>补充说明：</span>
                            <span> <input type="text" name="message[<?php echo $k ?>]" class="input-problem" placeholder="<?php echo Yii::t('orderFlow', '选填，补充填写其他特殊需求'); ?>" maxlength="30"/></span>
                            <span>限制30字以内</span>
                        </div>
                        <div class="right">

                            <p class="delivery">
                                <span class="favorable-name">运费：</span>
                                <span class="favorable-price">
                                    <?php
                                    echo HtmlHelper::formatPrice($storeFreight)
                                    ?>
                                </span>
                                <?php
                                echo '<br/>';
                                if (!empty($redAccount['use_red_money']) && $redAccount['use_red_money'][$k] > 0) {
                                    if ($redMoney > 0) {
                                        $str = '<div class="useRed">'.Yii::t('orderFlow', '使用红包抵扣') . '&nbsp;&nbsp;';
                                        if ($redMoney >= $redAccount['use_red_money'][$k]) {
                                            echo $str .CHtml::checkBox('is_use_red['.$k.']', true, array('style'=>'display:none','value' => 1,'class'=>'is_use_red','data-value'=>$redAccount['use_red_money'][$k],'onclick'=>'selectUseRed()')) . '&nbsp;'. HtmlHelper::formatPrice('') .'<span class="redMoney">'. $redAccount['use_red_money'][$k]."</span></div>";
                                            $useTotalRedMoney +=$redAccount['use_red_money'][$k]; //计算合计红包金额
                                            $redMoney -= $redAccount['use_red_money'][$k];
                                        } else {
                                            echo $str .CHtml::checkBox('is_use_red['.$k.']', true, array('style'=>'display:none','value' => 1,'class'=>'is_use_red','data-value'=>$redMoney,'onclick'=>'selectUseRed()')) . '&nbsp;'. HtmlHelper::formatPrice('') .'<span class="redMoney">'. $redMoney.'</span></div>';
                                            $useTotalRedMoney += $redMoney;
                                            $redMoney -= $redAccount['use_red_money'][$k];
                                        }
                                    } else {
                                        echo Yii::t('orderFlow', '您没有领取红包,优惠金额为0');
                                    }
                                }
                                ?>
                            </p>

                        </div>
                    </div>
                    <p class="item-together">店铺合计：（含运费）<span><?php echo HtmlHelper::formatPrice($orderTotalPrice) ?></span></p>
                </div>
            </div>
                <?php
                $j++;
            endforeach;
            ?>

        </div>

        <div class="orders-menu">
            <p class="menu-use">
                <?php $totalRedMoney = array_sum($redAccount['use_red_money']); ?>
                <?php if ($totalRedMoney > 0): ?>
                    <?php echo Yii::t('orderFlow', '红包优惠合计'); ?>:
                    <span class="shopfl_jf">-<?php echo HtmlHelper::formatPrice('') ?>
                        <b style="font-weight:normal" id="pay_with_yh">
                            <?php echo sprintf('%.2f', $useTotalRedMoney); ?>
                        </b>
                    </span>
                <?php endif; ?>
            </p>
            <p class="menu-price">实付款：<span><?php echo HtmlHelper::formatPrice($totalPrice+$totalFreight) ?></span></p>
            <p class="menu-dete">
                <?php if(stripos(Yii::app()->request->urlReferrer,'orderFlow')!==false): ?>
                <?php echo CHtml::link('返回购物车修改',array('orderFlow/view')); ?>
                <?php endif; ?>
                <input type="hidden" value="<?php echo $totalPrice ?>" id="allPrice"/>
                <input type="hidden" value="<?php echo Tool::authcode(serialize($this->freight)) ?>" name="freight_array"/>
                <input type="hidden" value="<?php echo Tool::authcode(serialize($goods_select)) ?>" name="goods_select"/>
                <input type="hidden" value="<?php echo Tool::authcode(serialize($this->storeFreight)) ?>" name="store_freight"/>
                <input type="submit" class="btn-dete" value="提交订单" name="">
            </p>
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
    <?php echo CHtml::endForm(); ?>
</div>
<?php echo CHtml::form('', 'post', array('class' => 'changeAddress')); //更换收货地址时候，刷新本页 ?>
<?php foreach ($goods_select as $v): ?>
    <input type="hidden" value="<?php echo $v ?>" name="goods_select[]"/>
<?php endforeach; ?>
<?php echo CHtml::endForm() ?>

<script type="text/javascript">
    //遮罩，前端防止重复提交
    $("#order_form").submit(function(){
        if(!$("input[name='address']:checked").size()){
            layer.alert("收货地址不能为空");
            return false
        }else{
            layer.load();
        }
    });
</script>