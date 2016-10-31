<?php
/* @var $this OrderController */
/* @var $model Order */
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come" id="tab1">
    <tr>
        <td colspan="6" class="title-th">
            <?php echo Yii::t('order', '收货人信息'); ?>
        </td>
    </tr>
    <tr>
        <th align="right">
            <?php echo $model->getAttributeLabel('consignee') ?>：
        </th>
        <td>
            <?php echo $model->consignee ?>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('address') ?>：
        </th>
        <td>
            <?php echo $model->address ?>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('mobile') ?>：
        </th>
        <td>
            <?php echo $model->mobile ?>
        </td>
    </tr>
    <tr>
        <th align="right">
            <?php echo Yii::t('order', '固定电话'); ?>：
        </th>
        <td>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('zip_code') ?>：
        </th>
        <td>
            <?php echo $model->zip_code ?>
        </td>
    </tr>
    <tr>
        <td colspan="6" class="title-th">
            <?php echo Yii::t('order', '订单信息'); ?>
        </td>
    </tr>
    <tr>
        <th align="right">
            <?php echo $model->getAttributeLabel('code') ?>：
        </th>
        <td>
            <?php echo $model->code ?>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('status') ?>：
        </th>
        <td>
            <?php echo $model::status($model->status) ?>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('pay_type') ?>：
        </th>
        <td>
            <?php echo $model::payType($model->pay_type) ?>
        </td>
    </tr>
    <tr>
        <th align="right">
            <?php echo $model->getAttributeLabel('pay_status') ?>：
        </th>
        <td>
            <?php echo $model::payStatus($model->pay_status) ?>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('order_type') ?>：
        </th>
        <td>
            <?php echo $model::orderType($model->order_type) ?>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('delivery_status') ?>：
        </th>
        <td>
            <?php echo $model::deliveryStatus($model->delivery_status) ?>
        </td>
    </tr>
    <tr>
        <th align="right">
            <?php echo $model->getAttributeLabel('create_time') ?>：
        </th>
        <td>
            <?php echo $this->format()->formatDatetime($model->create_time); ?>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('pay_time') ?>：
        </th>
        <td>
            <?php echo $model->pay_time ? $this->format()->formatDatetime($model->pay_time) : ''; ?>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('delivery_time') ?>：
        </th>
        <td>
            <?php echo $model->delivery_time ? $this->format()->formatDatetime($model->delivery_time) : ''; ?>
        </td>
    </tr>
    <tr>
        <th align="right">
            <?php echo $model->getAttributeLabel('sign_time') ?>：
        </th>
        <td>
            <?php echo $model->sign_time ? $this->format()->formatDatetime($model->sign_time) : ''; ?>
        </td>
        <th align="right">
            <?php echo Yii::t('order', '金额/积分'); ?>：
        </th>
        <td>
            ￥ <?php echo $model->real_price ?> / <span class="jf"><?php echo Common::convertSingle($model->real_price, $model->member->type_id) ?></span>盖网通积分
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('freight') ?>：
        </th>
        <td>
            ￥<?php echo $model->freight ?>
        </td>
    </tr>
    <tr>
        <th align="right">
            <?php echo $model->getAttributeLabel('express') ?>：
        </th>
        <td>
            <?php echo $model->express ?>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('return_status') ?>：
        </th>
        <td>
            <?php echo $model::returnStatus($model->return_status) ?>
            <?php echo!empty($model->return_reason) ? "(" . $model->getAttributeLabel('return_reason') . "：{$model->return_reason})" : ''; ?>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('refund_status') ?>：
        </th>
        <td>
            <?php echo $model::refundStatus($model->refund_status); ?>
            <?php echo!empty($model->refund_reason) ? "(" . $model->getAttributeLabel('refund_reason') . "：{$model->refund_reason})" : ''; ?>
        </td>
    </tr>
    <tr>
        <th align="right">
            <?php echo $model->getAttributeLabel('shipping_code') ?>：
        </th>
        <td>
            <?php echo $model->shipping_code ?>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('deduct_freight') ?>：
        </th>
        <td>
            <?php echo $model->deduct_freight ?>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('remark') ?>：
        </th>
        <td>
            <?php echo CHtml::encode($model->remark) ?>
        </td>
    </tr>
    <tr>
        <th align="right">
            <?php echo $model->getAttributeLabel('source') ?>：
        </th>
        <td>
            <?php echo Order::sourceType($model->source) ?>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('extend_remark') ?>：
        </th>
        <td>
            <?php echo CHtml::encode($model->extend_remark) ?>
        </td>
        <?php if($model->status == $model::STATUS_NEW && $model->return_status == $model::RETURN_STATUS_AGREE){?>
        <th align="right">
            <?php echo Yii::t('order', '操作') ?>：
        </th>
        <td>
            <?php echo CHtml::link(Yii::t('memberOrder', '取消退货'),  '#', array('class' => 'cancelReturn regm-sub', 'data_code' => $model->code));?>
        </td>
        <?php }?>
    </tr>
    <tr>
         <th align="right">
            <?php echo Yii::t('order', '商品类型') ?>：
        </th>
        <td colspan=5>
            <?php echo $model::orderSourceType($model->source_type) ?>
        </td>
    </tr>
    <tr>
        <td colspan="6" class="title-th">
            <?php echo Yii::t('order', '商品信息'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
                <tr >
                    <th style="text-align:left;width: 100px">
                        <?php echo Yii::t('order', '商品名称'); ?>
                    </th>
                    <th style="width: 100px;text-align:left">
                        <?php echo Yii::t('order', '数量'); ?>
                    </th>
                    <th style="width: 100px;text-align:left">
                        <?php echo Yii::t('order', '供货价'); ?>
                    </th>
                    <th style="width: 100px;text-align:left">
                        <?php echo Yii::t('order', '零售价'); ?>
                    </th>
                    <th style="width: 100px;text-align:left">
                        <?php echo Yii::t('order', '总价'); ?>
                    </th>
                    <th style="width: 100px;text-align:left">
                        <?php echo Yii::t('order', '运费'); ?>
                    </th>
                </tr>
                <?php /** @var $v OrderGoods */ ?>
                <?php foreach ($model->orderGoods as $v): ?>
                    <tr style="align:right">
                        <td>
                            <a href="<?php echo DOMAIN ?>/goods/<?php echo $v->goods_id ?>" target="_blank">
                                <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v->goods_picture, 'c_fill,h_60,w_60')) ?>
                                <?php echo $v->goods_name ?>
                            </a>
                            <span style="color:#999;display: inline-block;">
                                <?php if (!empty($v->spec_value)): ?>
                                    <?php foreach (unserialize($v->spec_value) as $ksp => $vsp): ?>
                                        <?php echo $ksp . ':' . $vsp ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </span>
                        </td>
                        <td>
                            <?php echo $v->quantity ?>
                        </td>
                        <td>
                            ￥ <?php echo $v->gai_price ?>
                        </td>
                        <td>
                            ￥<?php echo $v->unit_price ?>
                        </td>
                        <td>
                            ￥ <?php echo $v->total_price ?>
                        </td>
                        <td>
                            <?php if ($v->freight_payment_type != Goods::FREIGHT_TYPE_MODE): ?>
                                <?php echo Goods::freightPayType($v->freight_payment_type) ?>
                            <?php else: ?>
                                <?php echo $v->freight ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="6" class="title-th">
            <?php echo Yii::t('order', '买家信息'); ?>
        </td>
    </tr>
    <tr>
        <th align="right">
            <?php echo Yii::t('order', '买家会员编码'); ?>：
        </th>
        <td>
            <?php echo isset($model->member) ? $model->member->gai_number : '' ?>
        </td>
        <th align="right">
            买家盖网通积分余额：
        </th>
        <td>
            <?php echo isset($model->member) ?  HtmlHelper::formatPrice($model->member->getTotalNoCashNew()) : '' ?>
        </td>
        <th align="right">
            <?php echo Yii::t('order', '买家会员手机号'); ?>：
        </th>
        <td>
            <?php echo isset($model->member) ? $model->member->mobile : '' ?>
        </td>
    </tr>
    <tr>
        <td colspan="6" class="title-th">
            <?php echo Yii::t('order', '商铺信息'); ?>
        </td>
    </tr>
    <tr>
        <th align="right">
            <?php echo Yii::t('order', '商铺会员编码'); ?>：
        </th>
        <td>
            <?php echo isset($model->store) ? $model->store->member->gai_number : '' ?>
        </td>
        <th align="right">
            <?php echo Yii::t('order', '企业联系人手机号码'); ?>：
        </th>
        <td>
            <?php echo isset($model->store->member) ? $model->store->member->mobile : $model->store->mobile ?>
        </td>
        <th align="right">
        </th>
        <td>
        </td>
    </tr>
    <tr>
        <th align="right"><?php echo Yii::t('order', '商铺名称'); ?>：</th>
        <td><?php echo $model->store->name ?></td>
        <th align="right"><?php echo Yii::t('order', '商铺评分'); ?>：</th>
        <td><?php echo $model->store->avg_score ?></td>
        <th></th>
        <td></td>
    </tr>
    <?php if (!empty($model->rights_info)): ?>
        <tr>
            <td colspan="6" class="title-th">
                <?php echo Yii::t('order', '消费者维权信息'); ?>
            </td>
        </tr>
        <tr>
            <?php $rightInfo = CJSON::decode($model->rights_info); ?>
            <th align="right"><?php echo!empty($rightInfo['GaiPrice']) ? Yii::t('order', '退还供货总价') : Yii::t('order', '退还销售总价'); ?>：</th>
            <td>￥<?php echo!empty($rightInfo['GaiPrice']) ? $rightInfo['GaiPrice'] : $rightInfo['SalePrice']; ?></td>
            <th align="right"><?php echo Yii::t('order', '退还运费'); ?>：</th>
            <td>￥<?php echo $rightInfo['Fright']; ?></td>
            <th></th>
            <td></td>
        </tr>
    <?php endif; ?>
</table>
<script type='text/javascript'>
//取消退货
    $(".cancelReturn").click(function(){
        var order_code ="<?php echo $model->code;?>";
        art.dialog({
            icon: 'question',
            content: '<?php echo Yii::t('memberOrder', '你确定要取消退货么？'); ?>',
            ok: function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->createAbsoluteUrl('order/cancelReturn') ?>",
                    data: {
                        "YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
                        "code": order_code
                    },
                    success: function(msg) {
                        art.dialog({
                            icon: 'succeed',
                            content: msg,
                            ok: true,
                            lock: true,
                            okVal:'<?php echo Yii::t('member','确定') ?>',
                            title:'<?php echo Yii::t('member','消息') ?>'
                        });
                        location.reload();
                    }
                });
            },
            okVal:'<?php echo Yii::t('member','确定') ?>',
            title:'<?php echo Yii::t('member','消息') ?>',
            lock: true
        });
        return false;
    });
    $(document).ajaxError(function() {
        art.dialog({content: "<?php echo Yii::t('memberOrder', '操作失败，请重试'); ?>", okVal:'<?php echo Yii::t('member','确定') ?>',
            title:'<?php echo Yii::t('member','消息') ?>',ok: function() {
                document.location.reload();
            }});
    });
</script>