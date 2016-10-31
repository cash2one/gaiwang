<?php
/* @var $this SeckillFlowController */
Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero');
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
    .cancel{
        float: right;
    }
</style>
<div class="main clearfix">
    <div class="main">
        <?php echo CHtml::form($this->createAbsoluteUrl('/seckillFlow/order'), 'post', array('name' => 'SendOrderForm', 'id' => 'order_form'))
        ?>
        <span class="shopFlowPic_2"></span>

        <div class="shopFlBox">
            <span class="shopFlBox_title">
                <span class="shopFlBox_titleIcon"><?php echo Yii::t('orderFlow', '确认收货地址'); ?></span>
                <a href="<?php echo $this->createAbsoluteUrl('/member/address'); ?>"
                   title="<?php echo Yii::t('orderFlow', '管理收货地址'); ?>"><?php echo Yii::t('orderFlow', '管理收货地址'); ?></a>
            </span>
            <?php $this->renderPartial('_address', array('address' => $address, 'goods'=>$cartInfo['cartInfo'])) ?>
        </div>

        <div class="shopOrderlt">
            <table width="1200" border="0" cellspacing="0" cellpadding="0" class="shopFlowtitleTb">
                <tr>
                    <td width="438" align="center" valign="middle"><b><?php echo Yii::t('orderFlow', '商品'); ?></b></td>
                    <td width="150" align="center" valign="middle"><b><?php echo Yii::t('orderFlow', '单价(元)'); ?></b></td>
                    <td width="100" align="center" valign="middle"><b><?php echo Yii::t('orderFlow', '数量'); ?></b></td>
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
            foreach ($cartInfo['cartInfo'] as $k => $v):
                $orderTotalPrice = 0;//每一笔订单的总价
                ?>
                <span class="businessTip">
                    <span class="shBspic">
                        <?php echo Yii::t('orderFlow', '订单'); ?><?php echo $j ?>：<?php echo $v['storeName'] ?>
                    </span>　
                    <span class="sx_date"><?php echo Yii::t('orderFlow', '还剩<span id="clock"></span>,请尽快在这个时间内确认下单!'); ?></span>
                    <span class="cancel"><?php
                        echo CHtml::link('取消购买', array('/seckillFlow/cancel', 'goods_id'=>$goodsId), array('target' => '_self'));
                        ?></span>
                </span>
                <table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" class="shOrderTb"
                       id="con_<?php echo $k; ?>">
                    <?php $i = 1;
                    foreach ($v['goods'] as $key => $val):
                        $val['price'] = Common::rateConvert($val['price']);
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
                                    <font class="subtotal" data-key="<?php echo $key ?>" data-price="<?php echo number_format($val['price'] * $val['quantity'], 2, '.', '') ?>">
                                        <?php
                                        $subtotal = $val['price'] * $val['quantity'];
                                        $orderTotalPrice += $subtotal;
                                        $totalPrice += $subtotal;
                                        echo number_format($subtotal+$freight, 2, '.', '');
                                        ?>
                                    </font>
                                </b>
                            </td>
                        </tr>

                        <?php $i++;
                    endforeach; ?>
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
                        <p><?php echo Yii::t('orderFlow', '共{a}个订单', array('{a}' => count($cartInfo['cartInfo']))); ?></p>
                        <p><?php echo Yii::t('orderFlow', '总商品金额合计（含运费）'); ?>:
                            <span class="shopfl_jf"><?php echo HtmlHelper::formatPrice('') ?>
                                <b style="font-weight:normal" id="real_total">
                                    <?php echo number_format($totalPrice+$totalFreight, 2, '.', ''); ?>
                                </b>
                            </span>
                        </p>
                        <p>
                            <?php echo Yii::t('orderFlow', '实付（含运费）'); ?>:
                            <span class="shopfl_jf"><?php echo HtmlHelper::formatPrice('') ?>
                                <b style="font-weight:normal" id="pay_total">
                                    <?php
                                    echo number_format($totalPrice+$totalFreight, 2, '.', ''); ?>
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
                            <p class="address"><b><?php echo Yii::t('orderFlow', '寄送至'); ?>：</b><i
                                    id="confirm_address"><?php echo $address ?></i></p>
                            <p><b><?php echo Yii::t('orderFlow', '收货人'); ?>：</b><i
                                    id="confirm_buyer"><?php echo $va['real_name'], ' ', $va['mobile'] ?></i></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </span>
            </span>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>
<!-- -----------------主体 End--------------------------->
<?php echo CHtml::form('', 'post', array('class' => 'changeAddress')); //更换收货地址时候，刷新本页 ?>

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
                art.dialog({
                    icon: 'succeed',
                    content: '<?php echo Yii::t('member','超时确认，抢购已被取消！') ?>',
                    ok: function(){
                        location.href='<?php echo $this->createUrl('/goods/view',array('id' => $goodsId));?>';
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
    var validEnd = '<?php echo date('Y/m/d H:i:s', $validEnd) ?>';
    var validStart = '<?php echo date('Y/m/d H:i:s') ?>';
    $('#clock').countdown(validEnd, function(event) {
        $(this).html(event.strftime('%H:%M:%S'));
        if(isCancel == 0 && event.strftime('%H:%M:%S') == '00:00:00'){
            cancelOrder();
        }
    }, validStart);
</script>