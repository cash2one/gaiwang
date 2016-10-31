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
            <?php echo $this->format()->formatDatetime($model->create_time) ?>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('pay_time') ?>：
        </th>
        <td>
            <?php echo $this->format()->formatDatetime($model->pay_time) ?>
        </td>
        <th align="right">
            <?php echo $model->getAttributeLabel('delivery_time') ?>：
        </th>
        <td>
            <?php echo $this->format()->formatDatetime($model->delivery_time) ?>
        </td>
    </tr>
    <tr>
        <th align="right">
            <?php echo $model->getAttributeLabel('sign_time') ?>：
        </th>
        <td>
            <?php echo $this->format()->formatDatetime($model->sign_time) ?>
        </td>
        <th align="right">
            <?php echo Yii::t('order', '金额/积分'); ?>：
        </th>
        <td>
            ￥ <?php echo $model->real_price ?> / <span class="jf"><?php echo Common::convert($model->real_price) ?></span>盖网通积分
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
            <?php echo $model::refundStatus($model->refund_status) ?>
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
        <td colspan="6" class="title-th">
            <?php echo Yii::t('order', '商品信息'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
                <tr>
                    <th>
                        <?php echo Yii::t('order', '商品名称'); ?>
                    </th>
                    <th style="width: 80px">
                        <?php echo Yii::t('order', '数量'); ?>
                    </th>
                    <th style="width: 100px">
                        <?php echo Yii::t('order', '供货价'); ?>
                    </th>
                    <th style="width: 100px">
                        <?php echo Yii::t('order', '零售价'); ?>
                    </th>
                    <th style="width: 100px">
                        <?php echo Yii::t('order', '总价'); ?>
                    </th>
                    <th style="width: 100px">
                        <?php echo Yii::t('order', '运费'); ?>
                    </th>
                </tr>
                <?php /** @var $v OrderGoods */ ?>
                <?php foreach ($model->orderGoods as $v): ?>
                    <tr align="center">
                        <td align="left">
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
            0.0
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
            <?php
                $enterPri = Enterprise::model()->find(array(
                    'select' =>'mobile',
                    'condition' =>'id = :id',
                    'params' => array(':id' => $model->store->member->enterprise_id),
                ));
                echo isset($enterPri->mobile) ? $enterPri->mobile : $model->store->mobile
            ?>
        </td>
        <th align="right">
        </th>
        <td>
        </td>
    </tr>
    <tr>
        <th align="right">
            <?php echo Yii::t('order', '商铺名称'); ?>：
        </th>
        <td>
            <?php echo $model->store->name ?>
        </td>
        <th align="right">
            <?php echo Yii::t('order', '商铺评分'); ?>：
        </th>
        <td>
            <?php echo $model->store->avg_score ?>
        </td>
        <th>
        </th>
        <td>
        </td>
    </tr>
</table>
<?php
// 维权表单
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => "js:function(form, data, hasError) {
            if (hasError != true) {
                return confirm('确认要对此订单维权？');
            }
        }"
    ),
        ));
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come" id="tab1">
    <tr>
        <td class="title-th" colspan="2">消费者维权信息</td>
    </tr>
    <tr>
        <th align="right">退还价格：</th>
        <td id="ReturnTip">
            <?php echo $form->radioButtonList($model, 'obligation', $obligation, array('separator' => '')); ?>
        </td>
    </tr>
    <tr>
        <th align="right">退还运费：</th>
        <td>
            <?php echo $form->textField($model, 'freight', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'freight'); ?>
        </td>
    </tr>

    <?php if($model->is_comment==$model::IS_COMMENT_YES): ?>
    <tr>
        <th align="right">已签收订单，返还金额：<?php echo HtmlHelper::formatPrice($returnMoney) ?> </th>
        <td>
            维权将会扣除
        </td>
    </tr>
    <?php endif; ?>

    <tr>
        <th align="right"></th>
        <td ><?php echo CHtml::submitButton(Yii::t('user', '维权'), array('class' => 'regm-sub')); ?></td>
    </tr>
</table>
<?php $this->endWidget(); ?>