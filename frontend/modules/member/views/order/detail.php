<?php
/* @var $this OrderController */
/* @var $model Order */
$this->breadcrumbs = array(
    Yii::t('memberOrder', '买入管理') => array('order/admin'),
    Yii::t('memberOrder', '订单详情'),
);
Yii::app()->clientScript->registerScriptFile(DOMAIN . '/js/raty/lib/jquery.raty.min.js');
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberOrder','订单详情');?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox ">
                    <h3><?php echo Yii::t('memberOrder', '订单详情') . '—' . $model->code ?></h3>
                </div>
                <div class="mgtop20 upladBox pdbottom10 ">
                    <h3><?php echo Yii::t('memberOrder', '收货人信息'); ?></h3>
                </div>
                <table width="890" border="0" cellspacing="0" cellpadding="0" class="tableBank">
                    <tr>
                        <td width="80" height="35" align="center" class="dtEe">
                            <b><?php echo $model->getAttributeLabel('consignee') ?></b>
                        </td>
                        <td width="215" height="35" class="pdleft20 bgF4">
                            <?php echo CHtml::encode($model->consignee) ?>
                        </td>
                        <td width="80" height="35" align="center" class="dtEe">
                            <b><?php echo $model->getAttributeLabel('address') ?></b>
                        </td>
                        <td height="35" class="pdleft20 bgF4">
                            <?php echo $model->address ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="80" height="35" align="center" class="dtEe">
                            <b><?php echo $model->getAttributeLabel('mobile') ?></b>
                        </td>
                        <td width="215" height="35" class="pdleft20 bgF4">
                            <?php echo $model->mobile ?>
                        </td>
                        <td width="80" height="35" align="center" class="dtEe">
                            <b><?php echo $model->getAttributeLabel('zip_code') ?></b>
                        </td>
                        <td height="35" class="pdleft20 bgF4">
                            <?php echo $model->zip_code ?>
                        </td>
                    </tr>
                </table>

                <div class="mgtop10 upladBox pdbottom10 "><h3><?php echo Yii::t('memberOrder', '订单信息'); ?></h3></div>


                <table width="890" border="0" cellspacing="0" cellpadding="0" class="tableBank">
                    <tr>
                        <td width="80" height="35" align="center" class="dtEe">
                            <b><?php echo $model->getAttributeLabel('code') ?></b>
                        </td>
                        <td width="210" height="35" class="bgF4 pdleft20">
                            <?php echo $model->code ?>
                        </td>
                        <td width="80" height="35" align="center" class="dtEe">
                            <b><?php echo $model->getAttributeLabel('create_time') ?></b>
                        </td>
                        <td width="166" height="35" class="bgF4 pdleft20">
                            <?php echo $this->format()->formatDatetime($model->create_time) ?>
                        </td>
                        <td width="80" height="35" align="center" class="dtEe">
                            <b><?php echo $model->getAttributeLabel('status') ?></b>
                        </td>
                        <td width="180" height="35" class="bgF4 pdleft20">
                            <?php echo $model::status($model->status) ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="80" height="35" align="center" class="dtEe">
                            <b><?php echo $model->getAttributeLabel('pay_type') ?></b>
                        </td>
                        <td height="35" class="bgF4 pdleft20"><?php echo $model::payType($model->pay_type) ?></td>
                        <td width="80" height="35" align="center" class="dtEe">
                            <b><?php echo $model->getAttributeLabel('pay_status') ?></b>
                        </td>
                        <td height="35" class="bgF4 pdleft20"><?php echo $model::payStatus($model->pay_status) ?></td>
                        <td width="80" height="35" align="center" class="dtEe">
                            <b><?php echo Yii::t('memberOrder', '总价'); ?></b>
                        </td>
                        <td height="35" class="bgF4 pdleft20">
                            <?php echo Common::convertSingle($model->real_price) ?> <?php echo Yii::t('memberOrder', '盖网积分'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="80" height="35" align="center" class="dtEe">
                            <b><?php echo $model->getAttributeLabel('delivery_status') ?></b>
                        </td>
                        <td height="35" class="bgF4 pdleft20"><?php echo $model::deliveryStatus($model->delivery_status) ?></td>
                        <td width="80" height="35" align="center" class="dtEe">
                            <b><?php echo $model->getAttributeLabel('freight') ?></b>
                        </td>
                        <td height="35" class="bgF4 pdleft20">
                            <?php echo HtmlHelper::formatPrice($model->freight) ?>
                        </td>
                        <td width="80" height="35" align="center" class="dtEe">
                            <b><?php echo $model->getAttributeLabel('return') ?></b>
                        </td>
                        <td height="35" class="bgF4 pdleft20">
                            <?php echo Common::convertSingle(Order::amountReturnByMember($model->attributes,$this->model->attributes)); ?> <?php echo Yii::t('memberOrder', '盖网积分'); ?>
                        </td>
                    </tr>
                    <?php if ($model->refund_status != Order::REFUND_STATUS_NONE): // 退款状态 ?>
                        <tr>
                            <td width="80" height="35" align="center" class="dtEe">
                                <b><?php echo $model->getAttributeLabel('refund_status') ?></b>
                            </td>
                            <td height="35" class="bgF4 pdleft20"><?php echo $model::refundStatus($model->refund_status) ?></td>
                            <td width="80" height="35" align="center" class="dtEe">
                                <b><?php echo $model->getAttributeLabel('refund_reason') ?></b>
                            </td>

                            <?php if($model->is_right == Order::RIGHT_YES): ?>
                            <td height="35" class="bgF4 pdleft20">
                                <?php echo CHtml::encode($model->refund_reason) ?>
                            </td>
                            <td width="80" height="35" align="center" class="dtEe">
                                <b><?php echo $model->getAttributeLabel('right_time') ?></b>
                            </td>
                            <td height="35" class="bgF4 pdleft20">
                                <?php echo CHtml::encode($this->format()->formatDatetime($model->right_time)) ?>
                            </td>
                            <?php else: ?>
                            <td height="35" class="bgF4 pdleft20" colspan="4">
                                <?php echo CHtml::encode($model->refund_reason) ?>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endif; ?>
                    <?php if ($model->return_status != Order::RETURN_STATUS_NONE): // 退货状态 ?>
                        <tr>
                            <td width="80" height="35" align="center" class="dtEe">
                                <b><?php echo $model->getAttributeLabel('return_status') ?></b>
                            </td>
                            <td height="35" class="bgF4 pdleft20"><?php echo $model::returnStatus($model->return_status) ?></td>
                            <td width="80" height="35" align="center" class="dtEe">
                                <b><?php echo $model->getAttributeLabel('return_reason') ?></b>
                            </td>
                            <td height="35" class="bgF4 pdleft20">
                                <?php echo CHtml::encode($model->return_reason) ?>
                            </td>
                            <td width="80" height="35" align="center" class="dtEe">
                                <b><?php echo $model->getAttributeLabel('deduct_freight') ?></b>
                            </td>
                            <td height="35" class="bgF4 pdleft20">
                                <?php echo HtmlHelper::formatPrice($model->deduct_freight) ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td width="80" height="35" align="center" class="dtEe">
                            <b><?php echo $model->getAttributeLabel('remark') ?></b>
                        </td>
                        <td height="35" colspan="5" class="bgF4 pdleft20">
                            <?php echo CHtml::encode($model->remark); ?>
                        </td>
                    </tr>
                    <?php if (!empty($model->rights_info)): // 维权信息 ?>
                        <tr>
                            <td width="80" height="35" align="center" class="dtEe">
                                <b><?php echo $model->getAttributeLabel('rights_info') ?></b>
                            </td>
                            <td height="35" colspan="5" class="bgF4 pdleft20">
                                <?php
                                $rightInfo = CJSON::decode($model->rights_info);
                                $refundIntegral = Common::convertSingle(array_sum($rightInfo));
                                ?>
                                <?php echo Yii::t('memberOrder', "退还：{$refundIntegral}盖网积分"); ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>

                <div class="mgtop10 upladBox pdbottom10 "><h3><?php echo Yii::t('memberOrder', '商品信息'); ?></h3></div>

                <table width="890" border="0" cellpadding="0" cellspacing="0" class="integralTab purchaseOrder">
                    <tr>
                        <td width="256" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberOrder', '商品名称'); ?></b></td>
                        <td width="84" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberOrder', '单价'); ?></b></td>
                        <td width="68" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberOrder', '数量'); ?></b></td>
                        <td width="52" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberOrder', '运费'); ?></b></td>
                        <td width="113" align="center" class="tdBg"><b><?php echo Yii::t('memberOrder', '商品评价'); ?></b></td>
                        <td width="240" height="40" align="center" class="tdBg"><b><?php echo Yii::t('memberOrder', '评价内容'); ?></b></td>
                    </tr>
                    <?php if (!empty($model->orderGoods)): ?>
                        <?php foreach ($model->orderGoods as $v): ?>
                            <tr  class="bgF4">
                                <td height="140" align="center" valign="middle" class="tit">
                                    <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $v->goods_picture, 'c_fill,h_32,w_32')) ?>
                                    <p>
                                        <?php
                                        echo CHtml::link($v->goods_name, $this->createAbsoluteUrl('/goods/view', array('id' => $v->goods_id)), array('target' => '_blank'));
                                        if(ShopCart::checkHyjGoods($v->goods_id)){

                                            echo "<br/><font style='color:red'>(所购号码".$model->extend.")</font>";
                                        }
                                        ?>
                                    </p>
                                    <span style="color:#999;display: inline-block">
                                        <?php if(!empty($v->spec_value)): ?>
                                            <?php foreach(unserialize($v->spec_value) as $ksp=>$vsp): ?>
                                                <?php echo $ksp.':'.$vsp ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td height="140" align="center" valign="middle">
                                    <b class="red"><?php echo HtmlHelper::formatPrice($v->unit_price) ?></b>
                                </td>
                                <td height="140" align="center" valign="middle">
                                    <?php echo $v->quantity; ?>
                                </td>
                                <td height="140" align="center" valign="middle">
                                    <?php if ($v->freight_payment_type != Goods::FREIGHT_TYPE_MODE): ?>
                                        <?php echo Goods::freightPayType($v->freight_payment_type) ?>
                                    <?php else: ?>
                                        <?php echo HtmlHelper::formatPrice($v->freight).' ('.FreightType::mode($v->mode).')' ?>
                                    <?php endif; ?>
                                </td>
                                <?php $comment = $v->getComment(); // 获取该订单以及该商品的评论 ?>
                                <td height="140" align="center" valign="middle" >
                                    <?php if (isset($comment)): ?>
                                        <span class="point p_d<?php echo $comment->score * 10; ?>"></span>&nbsp;<?php echo $comment->score; ?>分
                                    <?php else: ?>
                                        <span><?php echo Yii::t('memberOrder','暂无评分');?></span>
                                    <?php endif; ?>
                                </td>
                                <td height="140" align="left" valign="middle" class="controlList">
                                    <?php echo isset($comment) ? $comment->content : Yii::t('memberOrder','暂无评价'); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
                <div class="mgtop10 upladBox pdbottom10 "><h3><?php echo Yii::t('memberOrder','物流信息');?></h3></div>
                <table width="890" border="0" cellspacing="0" cellpadding="0" class="tableBank">
                    <tr>
                        <td width="105" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberOrder','快递公司');?></b></td>
                        <td width="728" height="35" class="bgF4"><span class="mgleft30"><?php echo $model->express; ?></span></td>
                    </tr>
                    <tr>
                        <td width="105" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberOrder','物流单号');?></b></td>
                        <td height="35" class="bgF4"><span class="mgleft30"><?php echo $model->shipping_code; ?></span></td>
                    </tr>
                    <tr>
                        <td width="105" align="center" class="dtEe"><b><?php echo Yii::t('memberOrder','物流动态');?></b></td>
                        <td class="Logistics bgF4" id="express_status_block">
                            <span class="mgleft30" id="express_orstatus"><?php echo Yii::t('memberOrder','暂无物流状态');?></span>
                        </td>
                    </tr>
                </table>


                <?php if (!empty($model->shipping_code)): ?>
                    <script>
                        $("#express_orstatus").html('<?php echo Yii::t("order","正在查询物流信息.....");?>');
                        $.getJSON("<?php echo $this->createUrl('order/getExpressStatus', array('store_name' => $model->express, 'code' => $model->shipping_code, 'time' => time())); ?>", function(data) {
                            if (data.status != 200) {
                                $("#express_orstatus").html(data.message);
                            } else {
                                var ex_html = '';

                                $.each(data.data, function(i, item) {

                                    ex_html += '<p><span class="mgleft30">' + item.time + '</span><span class="mgleft30">' + item.context + '</span></p>';
                                });

                                $("#express_status_block").html(ex_html);

                            }
                        });

                    </script>

                <?php endif; ?>


                <?php if ($model->delivery_status == Order::DELIVERY_STATUS_SEND && $model->status == Order::STATUS_NEW): ?>
                    <div class="mgtop20 upladBox pdbottom10 "><h3><?php echo Yii::t('memberOrder','其它操作');?></h3></div>
                    <table width="890" border="0" cellspacing="0" cellpadding="0" class="tableBank">
                        <tr>
                            <td width="105" height="35" align="center" class="dtEe"><b><?php echo Yii::t('memberOrder','注意');?></b></td>
                            <td width="728" height="35" class="bgF4"><span class="orderDatialTip mgleft5"><span class="orderDatialTip_icon fl"></span><span class="fl"><?php echo Yii::t('memberOrder','您的订单还有<font id="has">{day}</font>天将自动签收',array('{day}'=>$showDay));?></span></span></td>
                        </tr>

                        <?php if ($model->delay_sign_count != 0) { ?>
                            <tr id="dis">
                                <td colspan="2" align="left" class="bgF4" style="padding:5px 0;">
                                    <span class="orderDatialBtn" onclick="clickMe('<?php echo $model->code; ?>')"><?php if(Yii::app()->language == 'en')echo 'Extend';?></span>
                                    <span class="mgtop5 fl mgleft14"><?php echo Yii::t('memberOrder','（每次可延长签收时间1天）您还可以延长签收时间 <font id="dTime">{day}</font> 次',array('{day}'=> $model->delay_sign_count));?></span>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php endif; ?>
            </div>
            <div class="mbDate1_b"></div>
        </div>

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">

            </div>
            <div class="mbDate1_b"></div>
        </div>

    </div>
</div>
<script>
                        var myUrl = '<?php echo Yii::app()->createAbsoluteUrl('/member/order/delaySign') ?>';
                        function clickMe(code) {
                            $.post(
                                    myUrl,
                                    {'code': code, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'},
                            function(data) {
                                if (data) {
                                    var a = $('#dTime').html();
                                    a = a - 1;
//                   $('#dTime').html(a);
//                   var day=$('#has').html();//天数
//                   day=day-1;
//                   $('#has').html(day);
                                    if ($('#dTime').html() == 0) {
                                        $('#dis').css('display', 'none');
                                    }
                                    window.location.reload();
                                }
                            }
                            );
                        }

</script>
