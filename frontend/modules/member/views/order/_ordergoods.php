<?php
/* @var $this Controller */
/* @var $order Order */
/* @var $v OrderGoods */
?>
<?php $flag = true; //跨列标记         ?>
<?php foreach ($orderGoods as $v): ?>
    <tr  class="bgF4" name="tr_<?php echo $order->code ?>">
        <td  align="center" valign="middle" class="tit">
            <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v->goods_picture, 'c_fill,h_32,w_32')) ?>
            <p>
                <?php echo CHtml::link($v->goods_name, $this->createAbsoluteUrl('/JF/' . $v->goods_id), array('target' => '_blank'));
                if(ShopCart::checkHyjGoods($v->goods_id)){
                    echo "<br/><font style='color:red'>(所购号码".$order->extend.")</font>";
                }
                ?>
            </p>
            <span style="color:#999;display: inline-block;">
                <?php if (!empty($v->spec_value)): ?>
                    <?php foreach (unserialize($v->spec_value) as $ksp => $vsp): ?>
                        <?php echo $ksp . ':' . $vsp ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </span>
        </td>
        <td  align="center" valign="middle">
            <b>
                <?php
                echo $v['unit_price'];
                ?>
            </b>
        </td>
        <td  align="center" valign="middle"><b class="color1b"><?php echo $v['quantity'] ?></b></td>
        <td  align="center" valign="middle">
            <b class="color1b">
                <?php if ($v['freight_payment_type'] != Goods::FREIGHT_TYPE_MODE): ?>
                    <?php echo Goods::freightPayType($v['freight_payment_type']) ?>
                <?php else: ?>
                    <?php echo HtmlHelper::formatPrice($v['freight']) ?>
                <?php endif; ?>
            </b>
        </td>
        <?php $rowSpan = count($orderGoods) > 1 ? 'rowspan="' . count($orderGoods) . '"' : false ?>
        <?php if (($rowSpan && $flag) || $flag):  //和并列 || 显示  ?>
            <td  align="center" valign="middle" <?php echo $rowSpan ?>>
                <b class="red"><?php echo Common::convertSingle(sprintf('%0.2f', $order->pay_price), $this->model->type_id) ?>
                    <?php echo Yii::t('memberOrder', '积分'); ?></b>
                <p>
                    <b class="color1b">(<?php echo Yii::t('memberOrder', '含运费'); ?>：<br/>
                        <?php echo HtmlHelper::formatPrice($order->freight) ?>)</b>
                </p>
                <b class="red">
                    <?php
                    echo ($order->pay_status == Order::PAY_STATUS_YES && $order->source_type == Order::SOURCE_TYPE_HB) ? "(红包优惠:".Common::convertSingle($order->other_price,$this->model->type_id)."积分)" : '';
                    ?>
                </b>
            </td>
            <td  align="center" valign="middle" class="controlList" <?php echo $rowSpan ?>>
                <?php echo $order::status($order->status) ?><br/>
                <?php if ($order->status == $order::STATUS_NEW): //新订单才显示先关支付、物流状态 ?>
                    <?php echo $order::payStatus($order->pay_status) ?><br/>
                    <?php echo $order::deliveryStatus($order->delivery_status); ?><br/>
                    <?php if ($order->refund_status != $order::REFUND_STATUS_NONE): ?>
                        <?php echo $order::refundStatus($order->refund_status) ?>
                    <?php endif ?>
                <?php endif; ?>
                <?php
                switch ($order->return_status) {
                    case 1:
                        echo Order::returnStatus($order->return_status);
                        break;

                    case 2:
                        echo Order::returnStatus($order->return_status);
                        break;
                    case 3:
                        echo Order::returnStatus($order->return_status);
                        break;
                    case 4:
                        echo Order::returnStatus($order->return_status);
                        break;
                    default:
                        break;
                }
                if($order->is_right){
                    echo "<br/>".Order::rightStatus($order->is_right);
                }
                ?>
            </td>

            <td  align="center" valign="middle" class="controlList" <?php echo $rowSpan ?>>

                <?php if ($order->status == $order::STATUS_NEW && $order->pay_status == $order::PAY_STATUS_NO): //新订单，未支付 ?>
                    <?php
                    echo CHtml::link(Yii::t('memberOrder', '支付'), array('/order/pay', 'code' => $order->code));
                    echo CHtml::link(Yii::t('memberOrder', '取消订单'), '#', array('class' => 'cancelOrder', 'data_code' => $order->code))
                    ?>
                <?php endif; ?>

                <?php
                if ($order->status == $order::STATUS_NEW && $order->pay_status == $order::PAY_STATUS_YES && $order->delivery_status == $order::DELIVERY_STATUS_NOT &&
                    $order->refund_status == $order::REFUND_STATUS_NONE): //新订单，已支付，未发货
                    ?>
                    <?php echo CHtml::link(Yii::t('memberOrder', '申请退款'), '#', array('data_code' => $order->code, 'class' => 'refundOrder')); ?>
                <?php endif; ?>

                <?php if ($order->status == $order::STATUS_NEW && $order->pay_status == $order::PAY_STATUS_YES && $order->delivery_status == $order::DELIVERY_STATUS_SEND): //新订单，已支付，已出货
                    ?>
                    <?php if ($order->return_status == 0): ?>
                    <a href='javascript:ConfirmRePurcharse("<?php echo $order->code ?>",<?php echo $order->freight ?>,<?php echo $order->pay_price ?>)'><?php echo Yii::t('memberOrder', '协商退货'); ?></a>
                <?php endif; ?>
                    <?php if ($order->return_status == Order::RETURN_STATUS_NONE || $order->return_status == Order::RETURN_STATUS_FAILURE || $order->return_status == Order::RETURN_STATUS_CANCEL): ?>
                    <?php echo CHtml::link(Yii::t('memberOrder', '签收订单'), '#', array('data_code' => $order->code, 'class' => 'signOrder')); ?>
                <?php endif; ?>
                <?php endif; ?>

                <?php if ($order->status == $order::STATUS_COMPLETE && $order->delivery_status == $order::DELIVERY_STATUS_RECEIVE && $order->is_comment == $order::IS_COMMENT_NO)://已完成、已收货
                    ?>
                    <?php echo CHtml::link(Yii::t('memberOrder', '评价'), $this->createAbsoluteUrl('comment/evaluate', array('code' => $order->code)));
                    ?>
                <?php endif; ?>

                <?php
                    if($order->status == $order::STATUS_NEW && $order->return_status == $order::RETURN_STATUS_AGREE){
                        echo CHtml::link(Yii::t('memberOrder', '取消退货'),  '#', array('class' => 'cancelReturn', 'data_code' => $order->code));
                    }
                ?>

                <?php echo CHtml::link(Yii::t('memberOrder', '订单详情'), $this->createAbsoluteUrl('order/detail', array('code' => $order->code)));
                ?>
            </td>
        <?php endif; ?>

        <?php $flag = $rowSpan ? false : true; ?>

    </tr>
<?php endforeach; ?>
