<?php
/* @var $this Controller */
/* @var $order Order */
/* @var $v OrderGoods */

$flag     = true; //跨列标记
$validEnd = false;
$now      = time();
$blank    = 0;
?>
<?php foreach ($orderGoods as $k=>$v):?>
    <tr class="order-bd">

        <td class="product">
            <a href="<?php echo $this->createAbsoluteUrl('/JF/' . $v->goods_id);?>" title="<?php echo $v['goods_name'];?>" target="_blank"><?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v->goods_picture, 'c_fill,h_90,w_90'),'',array('width'=>88, 'height'=>88, 'class'=>'product-img')); ?></a>
            <div class="product-txt">
                <a href="<?php echo $this->createAbsoluteUrl('/JF/' . $v->goods_id);?>" class="product-name link" target="_blank"><?php echo $v['goods_name'];?>
                    <?php
                    if(ShopCart::checkHyjGoods($v->goods_id)){
                        echo "<br/><font style='color:red'>(所购号码".$order->extend.")</font>";
                    }
                    ?></a>
                <p class="color-classify">
                    <?php if (!empty($v->spec_value)): ?>
                        <?php foreach (unserialize($v->spec_value) as $ksp => $vsp): ?>
                            <?php echo $ksp . ':' . $vsp ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </p>
            </div>
        </td>
        <td class="price"><?php echo  Order::getAuctionStartPrice($v['rules_setting_id'],$v['goods_id'])?> </td>
        <td class="quantity"><?php echo $v['quantity'] ?></td>
        <?php $rowSpan = count($orderGoods) > 1 ? 'rowspan="' . count($orderGoods) . '"' : false; ?>
        <?php if (($rowSpan && $flag) || $flag):  //和并列 || 显示  ?>
            <td class="payment" <?php echo $rowSpan ?>>
                <!--<p><b class="actual-pay"><?php echo HtmlHelper::formatPrice(sprintf('%0.2f', $order->pay_price));?></b></p>-->
                <b class="actual-pay">
                    <?php //echo Common::convertSingle(sprintf('%0.2f', $order->pay_price), $this->model->type_id),Yii::t('memberOrder', '积分'); ?>
                    <?php echo HtmlHelper::formatPrice(sprintf('%0.2f', $order->pay_price)); ?>
                </b>
                <p>（<?php echo Yii::t('memberOrder', '含运费'); ?>： <?php echo HtmlHelper::formatPrice($order->freight); ?>）</p>
                <p><?php  echo ($order->pay_status == Order::PAY_STATUS_YES && $order->source_type == Order::SOURCE_TYPE_HB) ? "(红包优惠:".Common::convertSingle($order->other_price,$this->model->type_id)."积分)" : '';  ?></p>
            </td>
            <td class="status" <?php echo $rowSpan ?>>
                <p><?php echo $order::status($order->status) ?></p>
                <?php if ($order->status == $order::STATUS_NEW): //新订单才显示先关支付、物流状态 ?>
                    <p><?php echo $order::payStatus($order->pay_status) ?></p>
                    <p><?php echo $order::deliveryStatus($order->delivery_status); ?></p>
                    <?php if ($order->refund_status > $order::REFUND_STATUS_NONE): ?>
                        <p><?php //echo $order::refundStatus($order->refund_status) ?></p>
                    <?php endif ?>
                <?php endif; ?>
                <?php

                if($order->return_status > 0){
                    echo "<p>".Order::returnStatus($order->return_status).'</p>';
                }else{
                    echo "<p>".Order::refundStatus($order->refund_status).'</p>';
                }

                if($order->is_right){
                    echo "<p>".Order::rightStatus($order->is_right).'</p>';
                }
                ?>
                <?php echo CHtml::link(Yii::t('memberOrder', '订单详情'), $this->createAbsoluteUrl('order/newDetail', array('code' => $order->code)), array('target'=>'_blank'));?>

                <?php if ($order->status == $order::STATUS_NEW && $order->pay_status == $order::PAY_STATUS_YES && $order->delivery_status == $order::DELIVERY_STATUS_SEND): //新订单,已支付,已发货
                    $url = $logistics['express']!='' ? $this->createUrl('order/getExpressStatus', array('store_name'=>$logistics['express'], 'code'=>$logistics['shipping_code'], 'time'=>$now)) : '';
                    ?>
                    <div class="logistics-area" data-value="<?php echo $logistics['k'];?>">
                        <a href="javascript:void(0);" class="logistics link" id="link_<?php echo $logistics['k'];?>"><?php echo Yii::t('memberOrder', '物流信息');?></a>
                        <input type="hidden" id="url_<?php echo $logistics['k'];?>" value="<?php echo $url;?>" />
                        <input type="hidden" id="exp_<?php echo $logistics['k'];?>" value="<?php echo $this->createAbsoluteUrl('exchangeGoods/lookupExpress', array('code' => $order->code,'type'=>1));?>" />
                        <div class="logistics-details" id="logistics_<?php echo $logistics['k'];?>">
                            <?php if($logistics['express']){?>
                                <span class="logistics-title"><?php echo $logistics['express'];?>&nbsp;&nbsp;<?php echo Yii::t('memberOrder', '运单号');?>：<?php echo $logistics['shipping_code'];?></span>
                                <ul id="express_<?php echo $logistics['k'];?>">
                                </ul>
                            <?php }else{?>
                                <span class="logistics-title"><?php echo Yii::t('memberOrder', '暂无物流相关信息');?></span>
                            <?php }?>
                        </div>
                    </div>
                <?php endif;?>
            </td>
            <td class="operation" <?php echo $rowSpan ?>>
                <?php if ($order->status == $order::STATUS_NEW && $order->pay_status == $order::PAY_STATUS_YES && $order->delivery_status == $order::DELIVERY_STATUS_SEND): /*新订单，已支付，已出货*/ ?>
                    <?php if ($order->return_status == Order::RETURN_STATUS_NONE || $order->return_status == Order::RETURN_STATUS_FAILURE || $order->return_status == Order::RETURN_STATUS_CANCEL): ?>
                        <?php
                        //if($order->is_auto_sign == 1) {//如果是自动签收,则显示时间
                        $autoDate = $order->auto_sign_date > 0 ?  $order->auto_sign_date : 10;
                        $t = ($order->delivery_time + $autoDate * 86400) - $now;
                        if($t>0){
                            $d = floor($t/86400);
                            $h = floor($t/3600%24);
                            $m = floor($t/60%60);
                            $s = $t%60;
                            echo "<p class=\"remain-time\" id=\"".$order->id."\" data-time=\"{$t}\">剩{$d}天{$h}小时{$m}分钟{$s}秒</p>";
                            $blank = 1;
                        }
                        //}
                        ?>
                    <?php endif;?>
                <?php endif;?>

                <?php if ($order->status == $order::STATUS_NEW && $order->pay_status == $order::PAY_STATUS_NO): //新订单，未支付 ?>
                    <?php
                    $orderCache = ActivityData::getOrderCacheByCode($order->code);
                    if(!empty($orderCache)){//秒杀支付,显示剩余时间
                        $validEnd = $orderCache['create_time'] + SeckillRedis::TIME_INTERVAL_ORDER;
                        $t = $validEnd - $now;
                        if($t>0){
                            $d = floor($t/86400);
                            $h = floor($t/3600);
                            $m = floor($t/60%60);
                            $s = $t%60;
                            echo "<p class=\"remain-time remain-time2\" id=\"".$order->id."\" data-time=\"{$t}\">剩{$d}天{$h}小时{$m}分钟{$s}秒</p>";
                            $blank = 1;
                        }
                    }else{//普通订单,24小时不支付则被系统取消
                        $t = ($order->create_time + 259200) - $now;
                        if($t>0){
                            $d = floor($t/86400);
                            $h = floor($t/3600);
                            $m = floor($t/60%60);
                            $s = $t%60;
                            echo "<p class=\"remain-time remain-time2\" id=\"".$order->id."\" data-time=\"{$t}\">剩{$d}天{$h}小时{$m}分钟{$s}秒</p>";
                            $blank = 1;
                        }
                    }
                    echo CHtml::link(Yii::t('memberOrder', '去付款'), array('/order/payv2', 'code' => $order->code), array('class'=>'pay-btn'));
                  // echo CHtml::link(Yii::t('memberOrder', '取消订单'), 'javascript:void(0);', array('class' => 'pay-btn cancelOrder', 'data_code' => $order->code));
                    ?>
                <?php endif; ?>

                <?php
                if ($order->status == $order::STATUS_NEW && $order->pay_status == $order::PAY_STATUS_YES && $order->delivery_status < $order::DELIVERY_STATUS_SEND &&
                    ($order->refund_status == $order::REFUND_STATUS_NONE || $order->refund_status == $order::REFUND_STATUS_FAILURE || $order->refund_status == $order::REFUND_STATUS_FAILURE || $order->return_status == $order::RETURN_STATUS_NONE) ): //新订单，已支付，未发货
                    ?>
                    <?php if(!OrderExchange::checkOrderStatus($order->id) && OrderExchange::checkOrderCount($order->id)) echo CHtml::link(Yii::t('memberOrder', '退款/退货'), array('/member/exchangeGoods/BackGoods', 'code' => $order->code), array('class' => 'pay-btn refundOrder', 'target'=>'_blank')); ?>
                    <?php /*echo CHtml::link(Yii::t('memberOrder', '提醒卖家发货'), 'javascript:void(0);', array('data_code' => $order->code, 'class' => 'remind-btn'));*/ ?>
                <?php endif; ?>

                <?php if ($order->status == $order::STATUS_NEW && $order->pay_status == $order::PAY_STATUS_YES && $order->delivery_status == $order::DELIVERY_STATUS_SEND): /*新订单，已支付，已出货*/ ?>
                    <?php if ($order->return_status == $order::RETURN_STATUS_NONE || $order->refund_status == $order::REFUND_STATUS_FAILURE || $order->return_status == $order::RETURN_STATUS_FAILURE || $order->return_status == $order::RETURN_STATUS_NONE): ?>
                        <?php if(!OrderExchange::checkOrderStatus($order->id) && OrderExchange::checkOrderCount($order->id)) echo CHtml::link(Yii::t('memberOrder', '退款/退货'), array('/member/exchangeGoods/BackGoods', 'code' => $order->code), array('class' => 'pay-btn refundOrder', 'target'=>'_blank')); ?>
                    <?php endif; ?>
                    <?php if ($order->return_status == Order::RETURN_STATUS_NONE || $order->return_status == Order::RETURN_STATUS_FAILURE || $order->return_status == Order::RETURN_STATUS_CANCEL): ?>
                        <?php echo CHtml::link(Yii::t('memberOrder', '确认收货'), 'javascript:void(0);', array('data_code' => $order->code, 'class' => 'confirm-btn signOrder')); ?>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($order->status == $order::STATUS_COMPLETE && $order->delivery_status == $order::DELIVERY_STATUS_RECEIVE && $order->is_comment == $order::IS_COMMENT_NO):/*已完成、已收货*/ ?>
                    <?php echo CHtml::link(Yii::t('memberOrder', '我要评价'), $this->createAbsoluteUrl('comment/evaluate', array('code' => $order->code)), array('class'=>'evaluate-btn')); ?>
                <?php endif; ?>
                <?php if ($order->status == $order::STATUS_COMPLETE && $order->delivery_status == $order::DELIVERY_STATUS_RECEIVE && $order->is_comment == $order::IS_COMMENT_YES):/*已完成、已收货*/?>
                    <?php
                    //已经修改过的订单不显示修改订单
                    $edit = Comment::model()->find(array('select'=>'id,order_id,is_edit','condition'=>'order_id=:order_id','params'=>array('order_id'=>$v->order_id)));
                    if(!$edit->is_edit):
                        ?>
                        <?php echo CHtml::link(Yii::t('memberOrder', '修改评价'), $this->createAbsoluteUrl('comment/edit', array('code' => $order->id)), array('class'=>'evaluate-btn'));?>
                    <?php endif;  endif;?>

                <?php
                if($order->status == $order::STATUS_NEW && $order->return_status == $order::RETURN_STATUS_AGREE){
                    echo CHtml::link(Yii::t('memberOrder', '取消退货'),  'javascript:void(0);', array('class' => 'pay-btn cancelReturn', 'data_code' => $order->code));
                }
                ?>
                <?php if($blank){
                    echo '<div class="height10px"></div>';
                }?>
            </td>
        <?php endif; ?>
    </tr>
    <?php $flag = $rowSpan ? false : true; ?>
<?php endforeach; ?>
