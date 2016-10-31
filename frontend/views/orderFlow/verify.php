<?php
/* @var $this OrderFlowController */
$redMoney = $redAccount['memberRedAccount'];
$useTotalRedMoney = 0;
?>
<!--------------------------主体---------------------------------->
<style>
    .address_item {
        display: block;
        height: 45px;
        margin: 0 0 10px;
        width: 1200px;
    }

    .shopFlBox span.fr {
        display: block;
        float: right;
        line-height: 45px;
        text-align: right;
        width: 200px;
    }

    .shopFlBox span.fr a {
        margin: 0 25px 0 0;
    }

    .shopFlBox font {
        display: block;
        float: left;
        margin: 15px 0 0;
    }

    .shopFlBox input {
        display: inline;
        float: left;
        margin: 18px 10px 0 0;
    }
</style>
<div class="main clearfix">
    <div class="main">
        <?php echo CHtml::form($this->createAbsoluteUrl('/orderFlow/order'), 'post', array('name' => 'SendOrderForm', 'id' => 'order_form'))
        ?>
        <span class="shopFlowPic_2"></span>

        <div class="shopFlBox">
            <span class="shopFlBox_title">
                <span class="shopFlBox_titleIcon"><?php echo Yii::t('orderFlow', '确认收货地址'); ?></span>
                <!--<a title="添加新地址" id="add_Adress">添加新地址</a>-->
                <a href="<?php echo $this->createAbsoluteUrl('/member/address'); ?>"
                   title="<?php echo Yii::t('orderFlow', '管理收货地址'); ?>"><?php echo Yii::t('orderFlow', '管理收货地址'); ?></a>
            </span>
            <?php $this->renderPartial('_address', array('address' => $address, 'id' => $goods_select)) ?>
        </div>

        <div class="shopOrderlt">
            <table width="1200" border="0" cellspacing="0" cellpadding="0" class="shopFlowtitleTb">
                <tr>
                    <td width="438" align="center" valign="middle"><b><?php echo Yii::t('orderFlow', '商品'); ?></b></td>
                    <td width="150" align="center" valign="middle"><b><?php echo Yii::t('orderFlow', '单价(元)'); ?></b></td>
                    <td width="100" align="center" valign="middle"><b><?php echo Yii::t('orderFlow', '数量'); ?></b></td>
                    <td width="130" align="center" valign="middle"><b><?php echo Yii::t('orderFlow', '优惠'); ?></b></td>
                    <td width="100" align="center" valign="middle"><b><?php echo Yii::t('orderFlow', '配送方式'); ?></b></td>
                    <td width="100" align="center" valign="middle"><b><?php echo Yii::t('orderFlow', '运费(元)'); ?></b></td>
                    <td width="180" align="center" valign="middle"><b><?php echo Yii::t('orderFlow', '小计(元)'); ?></b>
                    </td>
                </tr>
            </table>

            <?php
            $j = 1;
            $totalPrice = 0; //总价，不包含运费
            $totalFreight = 0; //总运费
			$nowTime = time();
            foreach ($cartInfo['cartInfo'] as $k => $v):
                $orderTotalPrice = 0;//每一笔订单的总价
                ?>
                <span class="businessTip">
                    <span class="shBspic">
                        <?php echo Yii::t('orderFlow', '订单'); ?><?php echo $j ?>：<?php echo $v['storeName'] ?>
                    </span>　
                </span>
                <table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" class="shOrderTb" id="con_<?php echo $k; ?>">
                    <?php $i = 1;
                    foreach ($v['goods'] as $key => $val):					    
                        $val['price'] = Common::rateConvert($val['price']);
						
						$seting   = ActivityData::getActivityRulesSeting($val['seckill_seting_id']);
						$relation = ActivityData::getActivityProductRelation($val['goods_id']);
						$redPrice = 0;
						if($val['seckill_seting_id']>0 && isset($seting) && $seting['category_id']==1 && strtotime($seting['end_dateline'])>=$nowTime && $relation!=false){//参加活动的商品 秒杀除外
							$redPrice = number_format($val['price']*$seting['discount_rate']/100, 2, '.', '');
							/*if($seting['discount_rate']>0){//折扣价
								$rate = $seting['category_id']==1 ? (100-$seting['discount_rate']) : $seting['discount_rate'];
								$redPrice = number_format($val['price']*$rate/100, 2, '.', '');
							}else{//固定价格
								$redPrice = number_format($seting['discount_price'], 2, '.', '');
							}*/
						}
                        ?>
                        <tr>
                            <td width="40" align="center"></td>
                            <td width="68">
                                <?php echo CHtml::link(
                                    CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $val['thumbnail'], 'c_fill,h_54,w_54')),
                                    array('/goods/view', 'id' => $val['goods_id']), array('target' => '_blank')
                                ) ?>
                            </td>
                            <td width="330" align="left">
                                <p class="shNameTxt">
                                    <?php echo CHtml::link($val['name'], array('/goods/view', 'id'=>$val['goods_id']), array('target' => '_blank')) ?>
                                    <span class="spec"><?php echo $val['spec'] ?></span>
                                </p>
                            </td>
                            <td width="150" align="center" valign="middle">
                                <?php echo HtmlHelper::formatPrice('') ?>
                                <i class="price"> <?php echo $val['price']; ?></i>
                            </td>
                            <td width="100" align="center" valign="middle"><?php echo $val['quantity']; ?></td>
                            <td width="130" align="center" valign="middle">
                                <?php
                                    if(isset($val['special_name'])){
                                        echo $val['special_name'];
                                    }elseif($val['seckill_seting_id'] > 0 && isset($seting) && strtotime($seting['end_dateline'])>=$nowTime && $relation!=false){
                                        echo '<span title="'.$seting['name'].'">'. Tool::truncateUtf8String($seting['name'],8).'</span>';
                                    }else{
                                       echo Yii::t('orderFlow', '无');
                                    }
                                ?>
                            </td>
                            <td width="100" align="center" valign="middle">
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
                            </td>
                            <td width="100" align="center" valign="middle">

                                <?php
                                if ($val['freight_payment_type'] != Goods::FREIGHT_TYPE_MODE) {
                                    $freight = '0.00';
                                } else {
                                    $freight = explode('|', (key($this->freight[$key])));
                                    $freight = $freight[1];
                                }
                                $freight = Common::rateConvert($freight);
                                $totalFreight += $freight;
                                ?><?php echo HtmlHelper::formatPrice('') ?>
                                <span class="freight" data-key="<?php echo $key ?>"><?php echo $freight; ?></span>
                            </td>

                            <td width="180" align="center" valign="middle">
                                <b class="red"><?php echo HtmlHelper::formatPrice('') ?>
                                    <font class="subtotal" data-key="<?php echo $key ?>" data-price="<?php echo sprintf('%.2f', $val['price'] * $val['quantity']) ?>">
                                        <?php
                                        $subtotal = $val['price'] * $val['quantity'];
                                        $orderTotalPrice += $subtotal;
                                        $totalPrice += $subtotal - ($redPrice*$val['quantity']);
                                        echo sprintf('%0.2f', $subtotal+$freight);
                                        ?>
                                    </font>
                                </b>
                            </td>
                        </tr>

                        <?php $i++;  endforeach; ?>
                    <tr>
                        <td align="center">&nbsp;</td>
                        <td colspan="3"><?php echo Yii::t('orderFlow', '给卖家留言'); ?>:
                            <input type="text" name="message[<?php echo $k ?>]" class="shopflAddressinput" placeholder="<?php echo Yii::t('orderFlow', '选填，可以告诉卖家您对商品的特殊需求，如颜色、尺码等'); ?>"/></td>
                        <td align="center" valign="middle">&nbsp;</td>
                        <td colspan="2" align="center" valign="middle"></td>
                        <td colspan="3" align="center" valign="middle">
                            <?php echo Yii::t('orderFlow', '总积分'); ?>
                            <font class="shopfl_jf"><?php echo Common::convertSingle($orderTotalPrice) ?></font>
                            <?php echo Yii::t('orderFlow', '(不包含运费)'); ?>
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
                        </td>
                    </tr>
                </table>
                <?php
                $j++;
                endforeach;
            ?>

            <span class="playOrderBox">
			<hr>
                <span class="top">
                    <span class="text">
                        <?php $totalRedMoney = array_sum($redAccount['use_red_money']); ?>
                        <p><?php echo Yii::t('orderFlow', '共{a}个订单', array('{a}' => count($cartInfo['cartInfo']))); ?></p>
<!--                        <p>--><?php //echo Yii::t('orderFlow', '总商品积分（含运费）'); ?><!--:-->
<!--                            <span class="shopfl_jf">-->
<!--                                <b style="font-weight:normal" id="real_total">-->
<!--                                    --><?php //echo sprintf('%.2f',Common::convertSingle($totalPrice+$totalFreight)); ?>
<!--                                </b>-->
<!--                            </span>-->
<!--                        </p>-->
<!--                        <p>--><?php //echo Yii::t('orderFlow', '实付积分（含运费）'); ?><!--:-->
<!--                            <span class="shopfl_jf">-->
<!--                                <b style="font-weight:normal" id="real_total">-->
<!--                                    --><?php //echo sprintf('%.2f',Common::convertSingle(($totalPrice+$totalFreight)-$totalRedMoney)); ?>
<!--                                </b>-->
<!--                            </span>-->
<!--                        </p>-->
                        <p><?php echo Yii::t('orderFlow', '总商品金额合计（含运费）'); ?>:
                            <span class="shopfl_jf"><?php echo HtmlHelper::formatPrice('') ?>
                                <b style="font-weight:normal" id="real_total">
                                    <?php echo sprintf('%.2f',$totalPrice+$totalFreight); ?>
                                </b>
                            </span>
                        </p>
                        <?php if( $totalRedMoney > 0): ?>
                            <p>
                                <?php echo Yii::t('orderFlow', '红包优惠合计'); ?>:
                                <span class="shopfl_jf">-<?php echo HtmlHelper::formatPrice('') ?>
                                    <b style="font-weight:normal" id="pay_with_yh">
                                        <?php echo sprintf('%.2f',$useTotalRedMoney); ?>
                                    </b>
                                </span>
                            </p>
                        <?php endif; ?>
                        <p>
                            <?php echo Yii::t('orderFlow', '实付（含运费）'); ?>:
                            <span class="shopfl_jf"><?php echo HtmlHelper::formatPrice('') ?>
                                <b style="font-weight:normal" id="pay_total">
                                    <?php //-$useTotalRedMoney 这版暂是没有盖网价,所以不需要减去红包
                                    echo sprintf('%.2f',($totalPrice+$totalFreight));?>
                                </b>
                            </span>
                        </p>
                    </span>
                    <input type="hidden" value="<?php echo $totalPrice ?>" id="allPrice"/>
                    <input type="hidden" value="<?php echo Tool::authcode(serialize($this->freight)) ?>" name="freight_array"/>
                    <input type="hidden" value="<?php echo Tool::authcode(serialize($goods_select)) ?>" name="goods_select"/>
                    <input type="submit" class="playOrderBtn" title="<?php echo Yii::t('orderFlow', '提交订单'); ?>" id="submitToPay" value=""/>
                </span>

                <span class="bottom">
                    <?php $select_address = $this->getSession('select_address'); ?>
                    <?php foreach ($address as $va): ?>
                        <?php if ($select_address['id'] == $va['id']): ?>
                            <?php $address = implode(' ', array($va['province_name'], $va['city_name'], $va['district_name'], $va['street'])); ?>
                            <p class="address"><b><?php echo Yii::t('orderFlow', '寄送至'); ?>：</b>
                            <i id="confirm_address"><?php echo $address ?></i></p>
                            <p><b><?php echo Yii::t('orderFlow', '收货人'); ?>：</b>
                            <i id="confirm_buyer"><?php echo $va['real_name'], ' ', $va['mobile'] ?></i></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </span>
            </span>
            <?php if(ShopCart::checkSourceType($val['goods_id'])==Order::SOURCE_TYPE_DEFAULT): ?>
            <div class="shopFlreturnBox">
                <?php echo CHtml::link(Yii::t('orderFlow', '返回购物车'), $this->createAbsoluteUrl('/orderFlow'), array('class' => 'shopFlreturnBtn')); ?>
            </div>
            <?php endif; ?>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>
<!-- -----------------主体 End--------------------------->
<?php echo CHtml::form('', 'post', array('class' => 'changeAddress')); //更换收货地址时候，刷新本页 ?>
<?php foreach ($goods_select as $v): ?>
    <input type="hidden" value="<?php echo $v ?>" name="goods_select[]"/>
<?php endforeach; ?>
<?php echo CHtml::endForm() ?>
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
        var total_red = parseFloat($('#pay_with_yh').text());
        if( isNaN(total_red)){
            total_red = 0.00;
        }
        $('#pay_total').text((parseFloat($("#real_total").text()) - total_red).toFixed(2));
    });
</script>
<script src="<?php echo DOMAIN.'/js/tool.js'?>"></script>
<script>
    $(function(){
        $('#is_red').click(function(){
            var real = parseFloat($('#real_total').text());//支付的金额
            var red_account = parseFloat($('#red-account').text());//红包金额
            if ($('#is_red').is(':checked')){
                var pay = real - red_account;
                $('#pay_total').html(tool.price_format(pay));
            }else{
                $('#pay_total').html(tool.price_format(real));
            }
        });
    });
</script>
<script>
    function cal_select_is_red() {
        var redTotal = 0;
        var useRedTotal = 0;
        $('.useRed').each(function () {
            //计算未√选使用红包金额
            if (!$(this).find('input[class="is_use_red"]').is(':checked')) {
                redTotal += Number($(this).find('span.redMoney').html());
            } else {
                useRedTotal += Number($(this).find('span.redMoney').html());
            }
        });

        //更新优惠金额
        $('#pay_with_yh').html(useRedTotal.toFixed(2));
        //更新实付金额
        var real_total = Number($('#real_total').html());
        var pay_yh = Number($('#pay_with_yh').html());
        var pay_real = real_total -pay_yh;
        $('#pay_total').html(pay_real.toFixed(2));
    }
    function selectUseRed(){
        setTimeout('cal_select_is_red()', 100);
    }
</script>