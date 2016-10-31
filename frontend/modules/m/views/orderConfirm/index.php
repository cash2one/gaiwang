<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/global.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/comm.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/member.css" type="text/css"/>
    <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/m/jquery-2.1.1.min.js"></script>
    <title><?php echo $this->pageTitle ?>_确认订单（结算）</title>
</head>

<body>
<div class="wrap ODWrap">
    <div class="header" id="js-header">
        <div class="mainNav">
            <div class="topNav clearfix">
                <a class="icoBlack fl" href="javascript:history.go(-1);"></a>
                <a class="TxtTitle fl" href="javascript:void(0);"><?php echo $this->showTitle; ?></a>
            </div>
        </div>
    </div>
    <?php if (Yii::app()->user->hasFlash('message')): ?>
        <script type="text/javascript">
            alert('<?php echo Yii::app()->user->getFlash('message'); ?>');
        </script>
    <?php endif; ?>
    <?php echo CHtml::form($this->createAbsoluteUrl('orderConfirm/order'), 'post', array('name' => 'SendOrderForm', 'id' => 'order_form', 'onsubmit' => 'return checkAddress()')); ?>
    <div class="main">
        <a class="logisticsInfo ODInfo OCInfo2" href="javascript:void(0);"
           onclick="changeAddress()">
	    		<span id="address">
                    <?php if (!empty($address)): ?>
                        <?php $address = Address::getAddressById($address['id']); ?>
                        收货人：<?php echo $address['real_name'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $address['mobile']; ?><br/>
                        <?php echo $address['province_name'] . $address['city_name'] . $address['district_name'] . $address['street'] ?>
                    <?php endif; ?>
	    		</span>
        </a>

        <?php if (!empty($goods)): ?>
        <?php foreach ($goods as $key => $val): ?>
        <?php if ($key === 'goodsInfo'): ?>
        <div class="ODItem ODItem2 OCList">
            <ul>
                <?php if (!empty($val['storeName'])): ?>
                    <li>
                        <div class="OSlistTitle">
                            <div class="OSlistTitleLeft fl"><?php echo $val['storeName'] ?></div>
                            <div class="clear"></div>
                        </div>
                    </li>
                <?php endif; ?>
                <?php endif; ?>
                <!-- 产品列表 -->
                <?php if (!empty($val['goods']) && is_array($val['goods'])): ?>
                    <?php foreach ($val['goods'] as $k => $v): ?>
                        <li>
                            <a href="<?php echo $this->createAbsoluteUrl('goods/index', array('id' => $goodsId)); ?>"
                               title="" class="OSProducts">
                                <img width="80" class="fl" src="<?php echo Tool::showImg(IMG_DOMAIN . '/' . $v['thumbnail'], 'c_fill,h_150,w_150'); ?>"/>
                    <span class="OSProductsRight ODProductsRight fl">
                    <span class="OSProductsInfo"><?php echo Tool::truncateUtf8String($v['name'], 15); ?></span>
                    <span class="ODItem2Info">
                    <?php
                    if (isset($goodsSpec) && !empty($goodsSpec)) {
                        foreach ($goodsSpec as $s => $value) {
                            echo $s, ':', '&nbsp;', Tool::truncateUtf8String($value, 10); ?><br/>
                        <?php
                        }
                    }
                    ?>
                        <?php echo HtmlHelper::formatPrice($v['price']); ?>&nbsp;数量：<?php echo $goods['goodsCount']; ?>
                        <br/>
                        <?php $goodsPrice = bcmul($v['price'], $goods['goodsCount'], 2); ?>
                        <input type="hidden" name="goods_price" id="goods_price" value="<?php echo $goodsPrice; ?>"/>
                        </span>
                        </span>
                                <span class="clear"></span>
                            </a>
                        </li>
                        <?php
                        $totalPrice = $allTotalPrice;
                        $redMoney = $redAccount['memberRedAccount'];
                        $totalRedMoney = 0; //红包金额初始值为0
                        if (!empty($redAccount['use_red_money']) && $redAccount['use_red_money'] > 0) {
                            if ($redMoney > 0) {
                                if ($redMoney >= $redAccount['use_red_money']) {
                                    $totalRedMoney += $redAccount['use_red_money']; //计算合计红包金额
                                    $useMoney = $redAccount['use_red_money'];
                                    $redMoney -= $redAccount['use_red_money'];
                                } else {
                                    $totalRedMoney += $redMoney;
                                    $useMoney = $redMoney;
                                    $redMoney -= $redAccount['use_red_money'];
                                }
                                $payPrice = $totalPrice - $useMoney;
                            }else{
                                $totalRedMoney += $redAccount['use_red_money'];
                                $useMoney = $redAccount['use_red_money'];
                                $redMoney -= $redAccount['use_red_money'];
                                $payPrice = $totalPrice - $useMoney;
                            }
                        } else {
                            $payPrice = $totalPrice;
                            $totalRedMoney = 0;
                        }
                        ?>

                        <?php if (!empty($redAccount['use_red_money']) && $redAccount['use_red_money'] > 0 && !empty($v['at_name'])):
                            $ratio = bcdiv($v['activity_ratio'], 100, 5);
                            $useMoney = bcmul(bcmul($v['gai_sell_price'], $goods['goodsCount'], 2), $ratio, 2);
                            ?>
                            <li>
                                <span class="menberLeft fl"><?php echo $v['at_name'] ?></span>
                                <span class="menberRight fr">-<?php echo HtmlHelper::formatPrice($useMoney); ?></span>
                                <span class="clear"></span>
                            </li>
                        <?php endif; ?>

                        <li>
                    <span class="menberLeft fl">
                        	<?php
                            if ($v['freight_payment_type'] != Goods::FREIGHT_TYPE_MODE) {
                                echo Goods::freightPayType($v['freight_payment_type']);
                            } else {
                                if (count($this->freight[$k]) == 1) {
                                    echo current($this->freight[$k]);
                                    echo CHtml::hiddenField('freight[' . $k . ']', key($this->freight[$k]));
                                } else {
                                    echo CHtml::dropDownList('freight[' . $k . ']', '', $this->freight[$k],
                                        array('class' => 'freightSelect', 'data-key' => $k, 'id' => 'onfreight'));
                                }
                            }
                            ?>
                    </span>
                    <span class="menberRight fr">
                            <?php
                            if ($v['freight_payment_type'] != Goods::FREIGHT_TYPE_MODE) {
                                $freight = '0.00';
                            } else {
                                $freight = explode('|', (key($this->freight[$k])));
                                $freight = $freight[1];
                            }
                            $totalPrice = bcadd($totalPrice, $freight, 2);
                            echo HtmlHelper::formatPrice('');
                            echo '<span id="freightmoney">' . $freight . '</span>';
                            ?>
                     </span>
                            <span class="clear"></span>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php endforeach; ?>
                <?php endif; ?>

                <?php if(!empty($totalPrice)):?>
                <?php if (!empty($redAccount['use_red_money']) && $redAccount['use_red_money'] > 0 && !empty($v['at_name'])):?>
                    <li>
                        <span class="menberLeft fl">店铺合计</span>
                    <span class="menberRight fr d32f2f allPrice">
                        <?php echo HtmlHelper::formatPrice(bcsub($totalPrice, $totalRedMoney, 2)); ?>
                    </span>
                        <span class="clear"></span>
                    </li>
                <?php else: ?>
                <li>
                    <span class="menberLeft fl">店铺合计</span>
                    <span class="menberRight fr d32f2f allPrice">
                        <?php echo HtmlHelper::formatPrice($totalPrice); ?>
                    </span>
                    <span class="clear"></span>
                </li>
                <?php endif;?>
                <?php endif;?>
            </ul>
        </div>

    </div>
    <!-- 底部固定按钮 -->
    <div class="ODFooter">
        <div class="OSListBtn">
            <input type="hidden" value="<?php echo $payPrice; ?>" id="allPrice"/>
            <input type="hidden" value="<?php echo $totalRedMoney; ?>" id="totalRed">
            <input type="hidden" value="<?php echo $address['id'] ?>" name="address"/>
            <input type="hidden" value="<?php echo $freight; ?>" name="freight"/>
            <input type="hidden" value="<?php echo $goods['goodsCount']; ?>" name="quantity"/>
            <input type="hidden" value="<?php echo Tool::authcode(serialize($this->freight)) ?>" name="freight_array"/>
            <input type="hidden" value="<?php echo Tool::authcode(serialize($buyGoods)) ?>" name="goods"/>
            <input type="submit" class="OSListOnfirmBtn OCBtn" id="submitToPay"
                   value="去付款（合计:<?php echo HtmlHelper::formatPrice(bcsub($totalPrice, $totalRedMoney, 2)); ?>）"/>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>
<?php
Yii::app()->clientScript->scriptMap = array('jquery.js' => false, 'jquery.min.js' => false);
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/m/jquery-2.1.1.min.js', CClientScript::POS_HEAD);
?>
<script>
    //运费选择
    $(".freightSelect").change(function () {
        var freight = this.value.split('|');
        freight = parseFloat(freight[2]);
        $("#freightmoney").html(freight);
        allPrice = parseFloat($("#allPrice").val());
        totalRed = parseFloat($("#totalRed").val());
        var totalpriceJs = allPrice + freight - totalRed;
        $("#submitToPay").val("去付款（合计:<?php echo HtmlHelper::formatPrice('');?>" + totalpriceJs + ")");
    });

    function changeAddress() {
        <?php Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());?>
        location.href = '<?php echo $this->createUrl('address/index', array('goods' => $gs,'quantity' => $goods['goodsCount'])); ?>';
    }

    function checkAddress() {
        var address = $.trim($('#address').text());
        if (address.length > 0) {
            return true;
        } else {
            alert('请先设置收货地址');
            location.href = '<?php echo $this->createUrl('address/index', array('goods' => $gs,'quantity' => $goods['goodsCount'])); ?>';
            return false;
        }
    }
</script>
</body>
</html>
