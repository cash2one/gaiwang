<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberOrder', '买入管理') => array('order/admin'),
    Yii::t('memberOrder', '我的订单'),
);
?>
<script src="<?php echo DOMAIN ?>/js/artDialog/plugins/iframeTools.source.js" type="text/javascript"></script>
<?php $this->renderPartial('_msg'); ?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberOrder', '我的订单'); ?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="mgtop20 upladBox ">
                    <h3 class="mgleft14"><?php echo Yii::t('memberOrder', '我的订单'); ?></h3>

                    <p class="integaralbd pdbottom10">
                        <span class="mgleft14">
                            <?php echo Yii::t('memberOrder', '查找过去的消费订单记录。'); ?>
                        </span>
                    </p>
                </div>
                <div class="upladaapBoxBg mgtop20 ">
                    <?php $this->renderPartial('_search', array('model' => $model)); ?>
                    <div class="tipBox mgtop10">
                        <b><?php echo Yii::t('memberOrder', '盖网小助手'); ?>：</b>

                        <a href="<?php
                        echo $this->createAbsoluteUrl('order/admin', array(
                            'Order[create_time]' => $this->format()->formatDate($recentDate['start']),
                            'Order[end_time]' => $this->format()->formatDate($recentDate['end']),
                            'on' => 'recent'
                        ));
                        ?>" <?php if ($this->getParam('on') == 'recent') echo 'style="color:#C90000"' ?>>
                            <?php echo Yii::t('memberOrder', "近期订单") ?>(<?php echo $recentOrderNum ?>)
                        </a>

                        <a href="<?php
                        echo $this->createAbsoluteUrl('order/admin', array(
                            'Order[delivery_status]' => $model::DELIVERY_STATUS_SEND,
                            'Order[status]' => $model::STATUS_NEW,
                            'Order[return_status]' => $model::RETURN_STATUS_NONE,
                            'Order[refund_status]' => $model::REFUND_STATUS_NONE,
                            'on' => 'wait'))
                        ?>"
                           <?php if ($this->getParam('on') == 'wait') echo 'style="color:#C90000"' ?> >
                            <?php echo Yii::t('memberOrder', '待收货'); ?>（ <?php echo $waitReceiveNum ?>）
                        </a>

                        <a href="<?php
                        echo $this->createAbsoluteUrl('order/admin', array(
                            'Order[refund_status]' => $model::REFUND_STATUS_PENDING,
                            'Order[status]' => $model::STATUS_NEW,
                            'on' => 'refund'))
                        ?>"
                           <?php if ($this->getParam('on') == 'refund') echo 'style="color:#C90000"' ?> >
                            <?php echo Yii::t('memberOrder', '退款中'); ?>（ <?php echo $refundNum ?>）
                        </a>

                        <a href="<?php
                        echo $this->createAbsoluteUrl('order/admin', array(
                            'Order[is_comment]' => $model::IS_COMMENT_NO,
                            'Order[status]' => $model::STATUS_COMPLETE,
                            'on' => 'comment'))
                        ?>"
                           <?php if ($this->getParam('on') == 'comment') echo 'style="color:#C90000"' ?> >
                            <?php echo Yii::t('memberOrder', '待评价'); ?>（ <?php echo $waitCommentNum ?>）
                        </a>

                    </div>


                </div>
                <table width="890" border="0" cellpadding="0" cellspacing="0" class="integralTab purchaseOrder mgtop10">
                    <tr>
                        <td width="275" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberOrder', '商品'); ?></b>
                        </td>
                        <td width="110" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberOrder', '单价(元)'); ?></b>
                        </td>
                        <td width="70" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberOrder', '数量'); ?></b>
                        </td>
                        <td width="85" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberOrder', '运费'); ?></b>
                        </td>
                        <td width="105" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberOrder', '实付'); ?></b>
                        </td>
                        <td width="125" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberOrder', '状态'); ?></b>
                        </td>
                        <td width="120" height="40" align="center" class="tdBg">
                            <b><?php echo Yii::t('memberOrder', '操作'); ?></b>
                        </td>
                    </tr>
                    <?php /** @var $v Order */ ?>
                    <?php foreach ($orders as $k => $v): ?>
                        <?php
                        if($v['flag']==Order::FLAG_ONE && $v['create_time']<1401552000) continue; //历史特殊商品，跳过
                        $orderGoods = $v->orderGoods;
                        ?>
                        <tr name="tr_<?php echo $v->code ?>">
                            <td colspan="7" align="left" valign="middle" class="bgE5">
                                <b><?php echo Yii::t('memberOrder', '订单编号'); ?>： <?php echo $v->code ?></b>
                                <?php echo Yii::t('memberOrder', '下单时间'); ?>：
                                <?php echo $this->format()->formatDatetime($v->create_time) ?>&nbsp; &nbsp; &nbsp;
                                <?php echo Yii::t('memberOrder', '返还积分'); ?>：
                                <?php echo Common::convertSingle(Order::amountReturnByMember($v->attributes,$this->model->attributes,$orderGoods)); ?>
                                <?php echo Yii::t('memberOrder', '盖网积分'); ?>
                            </td>
                        </tr>
                        <?php $this->renderPartial('_ordergoods', array('order' => $v,'orderGoods'=>$orderGoods)) ?>
                    <?php endforeach; ?>
                    <?php $this->renderPartial('_return'); ?>
                    <tr>
                        <td height="35" colspan="7" align="center" valign="middle" class="bgF4">

                            <?php
                            $this->widget('LinkPager', array(
                                'pages' => $pages,
                                'jump' => false,
                                'firstPageLabel' => Yii::t('page', '首页'),
                                'prevPageLabel' =>  Yii::t('page', '上一页'),
                                'nextPageLabel' =>  Yii::t('page', '下一页'),
                                'lastPageLabel' =>  Yii::t('page', '尾页'),
                                'htmlOptions' => array('class' => 'pagination'),
                            ))
                            ?>

                        </td>
                    </tr>
                </table>

            </div>
            <div class="mbDate1_b"></div>
        </div>


    </div>
</div>

<script>
    //ajax 取消订单
    $(".cancelOrder").click(function() {
        var order_code = $(this).attr("data_code");
        art.dialog({
            icon: 'question',
            content: '<?php echo Yii::t('memberOrder', '你确定要取消该订单么？'); ?>',
            ok: function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->createAbsoluteUrl('order/cancel') ?>",
                    data: {
                        "YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
                        "code": order_code
                    },
                    success: function(msg) {
                        art.dialog({
                            icon: 'succeed',
                            content: msg,
                            ok: true,
                            okVal:'<?php echo Yii::t('member','确定') ?>',
                            title:'<?php echo Yii::t('member','消息') ?>'
                        });
                        location.reload();
                    }
                });
            },
            okVal:'<?php echo Yii::t('member','确定') ?>',
            title:'<?php echo Yii::t('member','消息') ?>'
        });
        return false;
    });
    //ajax 申请退款
    $(".refundOrder").click(function() {
        var order_code = $(this).attr("data_code");
        art.dialog({
            icon: 'question',
            content: '<?php echo Yii::t('memberOrder', '您确认要退款吗？'); ?>',
            okVal:'<?php echo Yii::t('member','确定') ?>',
            title:'<?php echo Yii::t('member','消息') ?>',
            ok: function() {
                art.dialog({
                    icon: 'question',
                    content: '<?php echo Yii::t('memberOrder', '退款原因？'); ?><br/><textArea id="refund_reason" rows="5" cols="50" style="border:1px solid #ccc; padding:8px;"><?php echo Yii::t('memberOrder', '发货速度太慢了'); ?></textArea>',
                    ok: function() {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo $this->createAbsoluteUrl('order/refund') ?>",
                            data: {
                                "YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
                                "code": order_code,
                                "reason": $("#refund_reason").val()
                            },
                            success: function(msg) {
                                art.dialog({
                                    icon: 'succeed',
                                    content: msg,
                                    ok: true,
                                    okVal:'<?php echo Yii::t('member','确定') ?>',
                                    title:'<?php echo Yii::t('member','消息') ?>'
                                });
                                location.reload();
                            }
                        });
                    },
                    okVal:'<?php echo Yii::t('member','确定') ?>',
                    title:'<?php echo Yii::t('member','消息') ?>'
                });
            }
        });
        return false;
    });

    //ajax 签收订单
    $(".signOrder").click(function() {
        var order_code = $(this).attr("data_code");
        art.dialog({
            icon: 'question',
            content: '<?php echo Yii::t('memberOrder', '你确定要签收该订单么？'); ?>',
            ok: function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->createAbsoluteUrl('order/sign') ?>",
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
            title:'<?php echo Yii::t('member','消息') ?>'
        });
        return false;
    });
    //取消退货
    $(".cancelReturn").click(function(){
        var order_code = $(this).attr("data_code");
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
    $(document).ajaxStart(function(o) {
       if(window.unreadMessageNum) return false;
        art.dialog({
            lock: true,
            content: '<?php echo Yii::t('memberOrder', '正在提交请求,请稍后...'); ?>',
            okVal:'<?php echo Yii::t('member','确定') ?>',
            title:'<?php echo Yii::t('member','消息') ?>'
        });
    });
    $(document).ajaxError(function() {
        art.dialog({content: "<?php echo Yii::t('memberOrder', '操作失败，请重试'); ?>", okVal:'<?php echo Yii::t('member','确定') ?>',
            title:'<?php echo Yii::t('member','消息') ?>',ok: function() {
                document.location.reload();
            }});
    });
</script>
<script type='text/javascript'>
    function ConfirmRePurcharse(orderid, intDeductFrei, totalPrice)
    {
        $('#hdOrderId').val(orderid);
        $('#txtDeductFrei').val(intDeductFrei);
        artDialog.confirm(document.getElementById('ctxRePurcharse'), function() {
            $('#hdDeductFrei').val(window.parent.document.getElementById('txtDeductFrei').value);
            $('#hdResons').val(window.parent.document.getElementById('txtResons').value);
            var dedFrei = parseFloat($('#hdDeductFrei').val());
            if (dedFrei <= totalPrice && dedFrei >= 0)
            {
                $('#rePurcharseForm').submit();
            }
            else
            {
                artDialog.alert("<?php echo Yii::t('memberOrder', '扣除运费必须不能为负且不能大于总费用！'); ?>", null, "warning-red");
            }
        },'','<?php echo Yii::app()->language; ?>');
    }
</script>