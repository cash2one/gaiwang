<?php
/* @var $this OrderController */
/* @var $model Order */
$this->breadcrumbs = array(
    Yii::t('memberOrder', '买入管理') => array('auction/admin'),
    Yii::t('memberOrder', '订单详情'),
);
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/raty/lib/jquery.raty.min.js');
$status    = $model->status;
$payStatus = $model->pay_status;
?>
<div class="member-contain clearfix">
    <div class="crumbs">
        <span><?php echo Yii::t('memberOrder', '您的位置'); ?>：</span>
        <a href="<?php echo $this->createAbsoluteUrl('/member/site/index'); ?>"><?php echo Yii::t('memberOrder', '首页'); ?></a>
        <span>&gt</span>
        <a href="<?php echo $this->createAbsoluteUrl('/member/auction/admin'); ?>"><?php echo Yii::t('memberOrder', '订单中心'); ?></a>
        <span>&gt</span>
        <a href="javascript:;"><?php echo Yii::t('memberOrder', '订单详情'); ?></a>
    </div>

    <?php if($model->status == Order::STATUS_NEW && $model->pay_status == Order::PAY_STATUS_NO){//新订单 未支付 ?>
        <?php $this->renderPartial('_newOrder', array('model' => $model)); ?>

    <?php }else if($model->pay_status == Order::PAY_STATUS_YES && ($model->delivery_status == Order::DELIVERY_STATUS_NOT || $model->delivery_status == Order::DELIVERY_STATUS_WAIT) &&
        (($model->return_status == Order::RETURN_STATUS_NONE || $model->return_status == Order::RETURN_STATUS_FAILURE) && ($model->refund_status == Order::REFUND_STATUS_NONE || $model->refund_status == Order::REFUND_STATUS_FAILURE)) ){//已付款 未发货或等待出货 申请退换货失败或未申请?>
        <?php $this->renderPartial('_newPay', array('model' => $model)); ?>

    <?php }else if($model->pay_status == Order::PAY_STATUS_YES && $model->delivery_status == Order::DELIVERY_STATUS_SEND && ($model->refund_status == Order::REFUND_STATUS_NONE || $model->return_status == Order::RETURN_STATUS_NONE && $model->refund_status != Order::REFUND_STATUS_SUCCESS)){//已付款 已发货?>
        <?php $this->renderPartial('_newDelivery', array('model' => $model)); ?>

    <?php }else if($model->delivery_status == Order::DELIVERY_STATUS_RECEIVE && $model->is_comment == Order::IS_COMMENT_NO ){//已签收 未评论?>
        <?php $this->renderPartial('_newReceive', array('model' => $model)); ?>

    <?php }else if($model->status == Order::PAY_STATUS_YES && $model->is_comment == Order::IS_COMMENT_YES){//已完成 已评论?>
        <?php $this->renderPartial('_newComment', array('model' => $model)); ?>

    <?php }else if($model->refund_status == Order::REFUND_STATUS_PENDING || $model->return_status == Order::RETURN_STATUS_PENDING || $model->return_status == Order::RETURN_STATUS_AGREE){//退货或退款中?>
        <?php $this->renderPartial('_newExchange', array('model' => $model,'exchange'=>$exchange)); ?>

    <?php }else if($model->status == Order::STATUS_CLOSE || $model->refund_status == Order::REFUND_STATUS_SUCCESS){ //订单已关闭?>
        <?php $this->renderPartial('_newClose', array('model' => $model)); ?>

    <?php }?>

    <div class="order-details">
        <div class="order-header">
            <span class="title"><?php echo Yii::t('memberOrder', '订单信息'); ?></span>
            <span class="order-num"><?php echo $model->getAttributeLabel('code') ?>：<?php echo $model->code; ?></span>
            <?php //echo CHtml::link(Yii::t('site','更多'),array('/member/order/detail', 'code'=>$model->code),array('id'=>'order-more','class'=>'more')); ?>
            <a href="javascript:void(0);" id="order-more" class="more"><?php echo Yii::t('memberOrder', '更多'); ?></a>
            <div class="order-more-box">
                <p><?php echo Yii::t('member', '成交时间')?>： <?php echo $this->format()->formatDatetime($model->create_time); ?></p>
                <?php if($model->pay_time>0){?>
                    <p><?php echo Yii::t('member', '付款时间')?>： <?php echo $this->format()->formatDatetime($model->pay_time); ?></p>
                <?php }?>
                <?php if($model->delivery_time>0){?>
                    <p><?php echo Yii::t('member', '发货时间')?>： <?php echo $this->format()->formatDatetime($model->delivery_time); ?></p>
                <?php }?>
                <?php if($model->sign_time>0){?>
                    <p><?php echo Yii::t('member', '完结时间')?>： <?php echo $this->format()->formatDatetime($model->sign_time); ?></p>
                <?php }?>
            </div>
        </div>
        <div class="order-des">
            <p><?php echo Yii::t('memberOrder', '收货人名')?>： <?php echo CHtml::encode($model->consignee) ?>，<?php echo $model->mobile ?></p>
            <p><?php echo Yii::t('memberOrder', '收货地址')?>： <?php echo $model->address ?></p>
            <p><?php echo Yii::t('memberOrder', '买家留言')?>： <?php echo CHtml::encode($model->remark); ?></p>
            <p><?php echo Yii::t('memberOrder', '商家名称')?>： <?php echo $store['name'];?></p>
            <p><?php echo Yii::t('memberOrder', '商家城市')?>： <?php echo Region::getName($store['province_id'], $store['city_id'], $store['district_id']);?></p>
            <p><?php echo Yii::t('memberOrder', '联系电话')?>： <?php echo $store['mobile'];?></p>
        </div>
        <table class="order-tab">
            <thead>
            <tr class="col-name">
                <th class="product"><?php echo Yii::t('memberOrder', '商品')?></th>
                <th class="price"><?php echo Yii::t('memberOrder', '单价')?></th>
                <th class="quantity"><?php echo Yii::t('memberOrder', '数量')?></th>
                <th class="privilege"><?php echo Yii::t('memberOrder', '优惠')?></th>
                <th class="freight"><?php echo Yii::t('memberOrder', '运费（元）')?></th>
                <th class="operation"><?php echo Yii::t('memberOrder', '操作')?></th>
            </tr>
            </thead>
            <tbody>
            <tr class="sep-row">
                <td colspan="6"></td>
            </tr>
            <tr class="order-hd">
                <td colspan="6">
                    <b class="dealtime"><?php echo date('Y-m-d H:i:s',$model->create_time);?></b>
                    <span class="order-num"><?php echo Yii::t('memberOrder', '订单号')?>：<?php echo $model->code;?></span>
                    <a href="<?php echo $this->createAbsoluteUrl('/shop/' . $store['id']);?>" class="shop link"><?php echo $store['name'];?></a>
                </td>
            </tr>
            <?php if (!empty($model->orderGoods)):
                $count    = count($model->orderGoods);
                $payMoney = $model->pay_price;
                $freight  = $model->freight;
                ?>
                <?php foreach ($model->orderGoods as $k=>$v):
                //$payMoney += $v->unit_price*$v->quantity;
                $discount  = '<p>无</p>';
                $actName   = '';
                if($v->rules_setting_id > 0){//有参加活动
                    $setting = ActivityData::getActiveBySettingId($v->rules_setting_id);
                    if(!empty($setting)){
                        $actName   = '<p>'.$setting['name'].'</p>';
                        if($setting['category_id'] == ActivityData::ACTIVE_RED){//红包活动
                            $discount = '<p>'.Yii::t('memberOrder', '红包消费比例: ').($setting['discount_rate']).'%</p>';
                        }else{//应节活动 秒杀活动
                            if($setting['discount_rate'] > 0){//商品打折
                                $discount = '<p>'.Yii::t('memberOrder', '商品打折: ').($setting['discount_rate']/10).Yii::t('memberOrder', '折').'</p>';
                            }else{//限定价格
                                $discount = '<p>'.Yii::t('memberOrder', '限定价格 : ').($setting['discount_price']).Yii::t('memberOrder', '元').'</p>';
                            }
                        }
                    }
                }
                ?>
                <?php if($k<1){?>
                <tr class="order-bd">
                    <td class="product">
                        <a href="<?php echo $this->createAbsoluteUrl('/JF/' . $v['goods_id']);?>" title="<?php echo $v->goods_name;?>" target="_blank"><?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v->goods_picture, 'c_fill,h_90,w_90'),'',array('width'=>88, 'height'=>88)); ?></a>
                        <div class="product-txt">
                            <?php
                            echo CHtml::link($v->goods_name, $this->createAbsoluteUrl('/goods/view', array('id' => $v->goods_id)), array('target' => '_blank'));
                            if(ShopCart::checkHyjGoods($v->goods_id)){

                                echo "<br/><font style='color:red'>(所购号码".$model->extend.")</font>";
                            }
                            ?>
                            <?php if(!empty($v->spec_value)): ?>
                                <?php foreach(unserialize($v->spec_value) as $ksp=>$vsp): ?>
                                    <?php echo '<p class="color-classify">'.$ksp.':'.$vsp.'</p>' ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="price"><?php echo HtmlHelper::formatPrice($v->unit_price) ?></td>
                    <td class="quantity"><?php echo $v->quantity; ?></td>
                    <td class="privilege">
                        <?php echo $actName, $discount;?>
                    </td>
                    <td class="freight" rowspan="<?php echo $count;?>">
                        <?php
                        echo Common::rateConvert($model->freight);
                        /*if ($model->freight_payment_type != Goods::FREIGHT_TYPE_MODE){
                            echo Goods::freightPayType($model->freight_payment_type);
                        }else{
                            echo HtmlHelper::formatPrice($model->freight).' <p>'.FreightType::mode($model->mode).'</p>';
                        }*/ ?>
                    </td>
                    <td class="operation operation2" rowspan="<?php echo $count;?>">
                        <?php if($model->status == Order::STATUS_NEW && $model->pay_status == Order::PAY_STATUS_YES ){ //新订单 已支付 ?>
                            <?php if(!OrderExchange::checkOrderStatus($model->id) && OrderExchange::checkOrderCount($model->id)) echo CHtml::link(Yii::t('memberOrder', '退款/退货'), array('/member/exchangeGoods/BackGoods', 'code' => $model->code), array('class' => 'link'));?>
                        <?php }?>
                    </td>
                </tr>
            <?php }else{?>
                <tr class="order-bd">
                    <td class="product">
                        <a href="<?php echo $this->createAbsoluteUrl('/JF/' . $v['goods_id']);?>" title="<?php echo $v->goods_name;?>" target="_blank"><?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v->goods_picture, 'c_fill,h_90,w_90'),'',array('width'=>88, 'height'=>88)); ?></a>
                        <div class="product-txt">
                            <?php
                            echo CHtml::link($v->goods_name, $this->createAbsoluteUrl('/goods/view', array('id' => $v->goods_id)), array('target' => '_blank'));
                            if(ShopCart::checkHyjGoods($v->goods_id)){

                                echo "<br/><font style='color:red'>(所购号码".$model->extend.")</font>";
                            }
                            ?>
                            <?php if(!empty($v->spec_value)): ?>
                                <?php foreach(unserialize($v->spec_value) as $ksp=>$vsp): ?>
                                    <?php echo '<p class="color-classify">'.$ksp.':'.$vsp.'</p>' ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="price"><?php echo HtmlHelper::formatPrice($v->unit_price) ?></td>
                    <td class="quantity"><?php echo $v->quantity; ?></td>
                    <td class="privilege"><?php echo $actName, $discount;?></td>
                </tr>
            <?php }?>
            <?php endforeach;?>
            <?php endif;?>

            <tr class="pay-sum">
                <td colspan="6">
                    <?php /*
				    $jf = '0.00';
					$xj = HtmlHelper::formatPrice($model->pay_price);
				    if($model->jf_price > 0){
					    $jf = Common::convertSingle(sprintf('%0.2f', $model->pay_price-$model->jf_price), $this->model->type_id);
						$xj = HtmlHelper::formatPrice($model->jf_price);
					}
				  */?>
                    <!--<p class="remark">(<?php /*echo Yii::t('memberOrder', '注')*/?>：<?php /*echo Yii::t('memberOrder', '现金')*/?><?php /*echo $xj; */?> + <?php /*echo $jf; */?><?php /*echo Yii::t('memberOrder', '积分')*/?>)</p>-->
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>