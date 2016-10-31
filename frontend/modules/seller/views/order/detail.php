<?php
/* @var $this Controller */
/* @var $model Order */
$member = Member::model()->find(array(
    'select' => 'id,gai_number,type_id,mobile,username',
    'condition' => 'id = :id',
    'params' =>array(':id' => $model->member_id),
));
?>
<script src="<?php echo DOMAIN ?>/js/artDialog/plugins/iframeTools.source.js" type="text/javascript"></script>
<?php $this->renderPartial('_msg'); ?>
<div class="mainContent">
    <div class="toolbar">
        <h3><?php echo Yii::t('sellerOrder', '订单详情'); ?>—<?php echo $model->code; ?></h3>
    </div>
    <h3 class="mt15 tableTitle"><?php echo Yii::t('sellerOrder', '收货人信息'); ?></h3>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
        <tbody>
            <tr>
                <th width="10%"><?php echo Yii::t('sellerOrder', '收货人'); ?></th>
                <td width="40%"><?php echo $model->consignee; ?></td>
                <th width="10%"><?php echo Yii::t('sellerOrder', '收货地址'); ?></th>
                <td width="40%"><?php echo $model->address; ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('sellerOrder', '联系方式'); ?></th>
                <td><?php echo $model->mobile; ?></td>
                <th><?php echo Yii::t('sellerOrder', '邮编'); ?></th>
                <td><?php echo $model->zip_code; ?></td>
            </tr>
        </tbody>
    </table>
    <h3 class="mt15 tableTitle"><?php echo Yii::t('sellerOrder', '订单信息'); ?></h3>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
        <tbody>
            <tr>
                <th width="10%"><?php echo Yii::t('sellerOrder', '订单编号'); ?></th>
                <td width="23%"> <?php echo $model->code; ?></td>
                <th width="10%"><?php echo Yii::t('sellerOrder', '下单时间'); ?></th>
                <td width="23%"><?php echo $this->format()->formatDatetime($model->create_time); ?></td>
                <th width="10%"><?php echo Yii::t('sellerOrder', '订单状态'); ?></th>
                <td width="24%"><?php echo $model::status($model->status); ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('sellerOrder', '支付方式'); ?></th>
                <td><?php echo $model::payType($model->pay_type); ?></td>
                <th><?php echo Yii::t('sellerOrder', '支付状态'); ?></th>
                <td><?php echo $model::payStatus($model->pay_status); ?></td>
                <th><?php echo Yii::t('sellerOrder', '总价'); ?></th>
                <td><?php echo HtmlHelper::formatPrice($orderPrice); ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('sellerOrder', '配送状态'); ?></th>
                <td>
                    <?php if ($model->delivery_status == Order::DELIVERY_STATUS_WAIT && $model->status == Order::STATUS_NEW): ?>
                        <?php echo $model::deliveryStatus($model->delivery_status); ?>
                        &nbsp;&nbsp;
                        <a onclick="consignment()" class="sellerBtn05" href="javascript:void(0)"><span><?php echo Yii::t('sellerOrder', '立即发货'); ?></span></a>
                    <?php else: ?>
                        <?php echo '无';?>
                    <?php endif;?>
                </td>
                <th><?php echo Yii::t('sellerOrder', '运费'); ?></th>
                <td>
                    <?php if ($model->freight): ?>
                        <?php echo HtmlHelper::formatPrice($model->freight); ?>
                        <?php if ($model->pay_status == Order::PAY_STATUS_NO && $model->status == Order::STATUS_NEW): ?>
                            <a onclick="freightEdit()"><?php echo Yii::t('sellerOrder', '编辑'); ?></a>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
                <th><?php echo Yii::t('sellerOrder', '返还'); ?></th>
                <td>
                    <?php
                        $orderGoods = array();
                        foreach ($model->orderGoods as $og) {
                            $orderGoods[] = $og->attributes;
                        }
                    ?>
                    <?php echo Common::convertSingle(Order::amountReturnBymember($model->attributes,$member->attributes,$orderGoods), $member->type_id); ?>
                    <?php echo Yii::t('sellerOrder', '盖网积分'); ?>
                </td>
            </tr>
            <?php if ($model->return_status != Order::RETURN_STATUS_NONE): ?>
                <tr>
                    <th><?php echo Yii::t('sellerOrder', '退货状态'); ?></th>
                    <td><?php echo Order::returnStatus($model->return_status); ?></td>
                    <th><?php echo Yii::t('sellerOrder', '协商扣除运费'); ?></th>
                    <td colspan="3"><?php echo $model->deduct_freight; ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <th><?php echo Yii::t('sellerOrder', '订单来源'); ?></th>
                <td colspan="5"><?php echo Order::sourceType($model->source) ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('sellerOrder', '买家留言'); ?></th>
                <td colspan="5"><?php echo $model->remark; ?></td>
            </tr>          
              <?php if ($model->status == Order::STATUS_CLOSE): ?>
            
                <tr>
                    <th><?php echo Yii::t('sellerOrder', '订单关闭原因'); ?></th>
                    <td colspan="5"><?php echo $model->extend_remark; ?></td>
                </tr>
            <?php endif; ?>
            <?php if ($model->refund_status != Order::REFUND_STATUS_NONE): ?>
                <tr>
                    <th><?php echo Yii::t('sellerOrder', '退款原因'); ?></th>
                    <td colspan="5"><?php echo $model->refund_reason; ?></td>
                </tr>
            <?php endif; ?>
            <?php if ($model->return_status != Order::RETURN_STATUS_NONE): ?>
                <tr>
                    <th><?php echo Yii::t('sellerOrder', '退货原因'); ?></th>
                    <td colspan="5"><?php echo $model->return_reason; ?></td>
                </tr>
            <?php endif; ?>
            <?php if ($model->is_right || !empty($model->rights_info)): // 维权信息 ?>
                <tr>
                    <th><?php echo $model->getAttributeLabel('rights_info') ?></th>
                    <td colspan="3">
                        <?php
                        $rightInfo = CJSON::decode($model->rights_info);
                        $refundIntegral = Common::convertSingle(array_sum($rightInfo));
                        ?>
                        <?php echo Yii::t('sellerOrder', "退还：{a}盖网积分",array('{a}'=>$refundIntegral)); ?>
                    </td>
                    <th><?php echo $model->getAttributeLabel('right_time') ?></th>
                    <td>
                        <?php if($model->right_time)echo $this->format()->formatDatetime($model->right_time); ?>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <h3 class="mt15 tableTitle"><?php echo Yii::t('sellerOrder', '商品信息'); ?></h3>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
        <tbody>
            <tr>
                <th width="20%" class="bgRed"><?php echo Yii::t('sellerOrder', '商品名称'); ?></th>
                <th width="10%" class="bgRed"><?php echo Yii::t('sellerOrder', '订单金额'); ?></th>
                <th width="5%" class="bgRed"><?php echo Yii::t('sellerOrder', '数量'); ?></th>
                <th width="10%" class="bgRed"><?php echo Yii::t('sellerOrder', '运费'); ?></th>
                <th width="15%" class="bgRed"><?php echo Yii::t('sellerOrder', '商品评价'); ?></th>
                <th width="40%" class="bgRed"><?php echo Yii::t('sellerOrder', '评价内容'); ?></th>
            </tr>
            <?php if (!empty($model->orderGoods)): ?>
                <?php foreach ($model->orderGoods as $val): ?>
                    <tr>
                        <td>
                            <div class="productArr01">
                                <?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $val->goods_picture, 'c_fill,h_32,w_32')) ?>
                                <?php echo CHtml::link($val->goods_name, $this->createAbsoluteUrl('/goods/' . $val->goods_id), array('target' => '_blank'));
                                ?>
                            </div>
                        </td>
                        <td class="ta_c"><b><?php echo HtmlHelper::formatPrice($val->gai_price * $val->quantity) ?></b></td>
                        <td class="ta_c"> <?php echo $val->quantity ?></td>
                        <td class="ta_c"><?php echo ($val->freight == 0.00) ? Yii::t('sellerOrder', '包邮') : $val->freight.' ('.FreightType::mode($val->mode).')'; ?></td>
                        <?php $comment = $val->getComment(); // 获取该订单以及该商品的评论 ?>
                        <td class="ta_c">
                            <?php if (isset($comment)): ?>
                                <span class="point p_d<?php echo $comment->score * 10; ?>"></span>&nbsp;<?php echo $comment->score; ?>分
                            <?php else: ?>
                                <span><?php echo Yii::t('sellerOrder', '暂无评分'); ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo (isset($comment) && $comment->status==Comment::STATUS_SHOW) ? Tool::banwordReplace($comment->content,'*') : Yii::t('sellerOrder', '暂无评价'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    

    
    <?php
    	if (!empty($model->shipping_code)){
    		$this->renderPartial('_expressinfo', array('orderDetail' => $model));
    	}
    
    ?>

    <?php if($model->status==Order::STATUS_NEW && $model->delivery_status==Order::DELIVERY_STATUS_SEND): ?>
    <h3 class="mt15 tableTitle"><?php echo Yii::t('sellerOrder', '其他操作'); ?></h3>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
        <tbody>
            <tr>
                <th width="10%"><?php echo Yii::t('sellerOrder', '注意'); ?></th>
                <td width="90%"><span class="attention"><?php echo Yii::t('sellerOrder', '订单还有{a}天将自动签收',array('{a}'=>'<font id="dTime">'.$showDay.'</font>')); ?></span></td>
            </tr>
            <tr>
                <td colspan="2"><a href="#" class="sellerBtn05"><span onclick="clickMe('<?php echo $model->code; ?>')"><?php echo Yii::t('sellerOrder', '延长签收'); ?></span></a>&nbsp;</td>
            </tr>
        </tbody>
    </table>
    <?php endif;?>
    <script>
        var myUrl = '<?php echo Yii::app()->createAbsoluteUrl('/seller/order/delaySign') ?>';
        function clickMe(code) {
            $.post(myUrl, {'code': code, 'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'},
                function (data) {
                    if (data) {
                        window.location.reload();
                    }
                });
        }
    </script>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
        <tbody>
            <tr>
                <td width="90%"><input type="submit" value="<?php echo Yii::t('sellerOrder', '返回"'); ?> name="yt0" class="sellerBtn06" onclick="javascript:history.go(-1);" ></td>
            </tr>
        </tbody>
    </table>
</div>
<script>
                            function consignment() {
                                var url = '<?php echo Yii::app()->createAbsoluteUrl('/seller/order/express/',array('code' =>$model->code)) ?>';
                                dialog = art.dialog.open(url, {'id': 'consignment', title: '<?php echo Yii::t('sellerOrder', '发货'); ?>', width: '600px', height: '200px', lock: true});
                            }
                            function freightEdit() {
                                var url = '<?php echo Yii::app()->createAbsoluteUrl('/seller/freightEdit/create', array('orderId' => $model->id)); ?>';
                                dialog = art.dialog.open(url, {'id': 'freightEdit', title: '<?php echo Yii::t('sellerOrder', '运费编辑'); ?>', width: '450px', height: '200px', lock: true});
                            }
                            function changeExpress() {
                                var url = '<?php echo Yii::app()->createAbsoluteUrl('/seller/order/changeExpress/',array('code' =>$model->code)) ?>';
                                dialog = art.dialog.open(url, {'id': 'changeExpress', title: '<?php echo Yii::t('sellerOrder', '修改物流信息'); ?>', width: '600px', height: '200px', lock: true});
                            }
</script>



