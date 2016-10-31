<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('sellerOrder', '订单') => array('/seller/order'),
    Yii::t('sellerOrder', '列表'),
);
?>
<script src="<?php echo DOMAIN ?>/js/artDialog/plugins/iframeTools.source.js" type="text/javascript"></script>
<?php $this->renderPartial('_msg'); ?>
<div class="toolbar">
    <b><?php echo Yii::t('sellerOrder', '已卖出商品'); ?></b>
    <span><?php echo Yii::t('sellerOrder', '查询处理所有售出的商品'); ?></span>
</div>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<div class="gateAssistant mt15 clearfix">
    <b class="black"><?php echo Yii::t('sellerOrder', '盖网小助手'); ?>：</b>

    <a href="<?php echo $this->createAbsoluteUrl('order/index', array('Order[create_time]' => $this->format()->formatDate($recentDate['start']), 'on' => 'recent'));
?>"
       class="<?php echo $this->getParam('on') == 'recent' ? 'sellerBtn05' : 'sellerBtn02' ?>">
        <span><?php echo Yii::t('sellerOrder', '近期订单'); ?>(<?php echo $recentOrderNum; ?>)</span>
    </a>
    <a href="<?php
    echo $this->createAbsoluteUrl('order/index', array(
        'Order[status]' => $model::STATUS_NEW,
        'Order[pay_status]' => $model::PAY_STATUS_YES,
        'Order[delivery_status]' => $model::DELIVERY_STATUS_NOT,
        'on' => 'not'
    ))
    ?>" class="<?php echo $this->getParam('on') == 'not' ? 'sellerBtn05' : 'sellerBtn02' ?>">
        <span><?php echo Yii::t('sellerOrder', '未发货'); ?>(<?php echo $notDeliverNum; ?>)</span>
    </a>

    <a href="<?php
    echo $this->createAbsoluteUrl('order/index', array(
        'Order[status]' => $model::STATUS_NEW,
        'Order[pay_status]' => $model::PAY_STATUS_YES,
        'Order[delivery_status]' => $model::DELIVERY_STATUS_WAIT,
        'on' => 'wait'
    ))
    ?>" class="<?php echo $this->getParam('on') == 'wait' ? 'sellerBtn05' : 'sellerBtn02' ?>">
        <span><?php echo Yii::t('sellerOrder', '已备货'); ?>(<?php echo $waitDeliverNum; ?>)</span>
    </a>

    <a href="<?php
    echo $this->createAbsoluteUrl('order/index', array(
        'Order[status]' => $model::STATUS_NEW,
        'Order[pay_status]' => $model::PAY_STATUS_YES,
        'Order[delivery_status]' => $model::DELIVERY_STATUS_SEND,
        'on' => 'send'
    ))
    ?>" class="<?php echo $this->getParam('on') == 'send' ? 'sellerBtn05' : 'sellerBtn02' ?>">
        <span><?php echo Yii::t('sellerOrder', '已发货'); ?>(<?php echo $recentDeliverNum; ?>)</span>
    </a>

    <a href="<?php
    echo $this->createAbsoluteUrl('order/index', array(
        'Order[status]' => $model::STATUS_NEW,
        'Order[refund_status]' => $model::REFUND_STATUS_PENDING,
        'on' => 'refund'
    ))
    ?>" class="<?php echo $this->getParam('on') == 'refund' ? 'sellerBtn05' : 'sellerBtn02' ?>">
        <span><?php echo Yii::t('sellerOrder', '退款中'); ?>(<?php echo $refundNum; ?>)</span>
    </a>

    <a href="<?php
    echo $this->createAbsoluteUrl('order/index', array(
        'Order[status]' => $model::STATUS_NEW,
        'Order[return_status]' => $model::RETURN_STATUS_PENDING,
        'on' => 'return'
    ))
    ?>" class="<?php echo $this->getParam('on') == 'return' ? 'sellerBtn05' : 'sellerBtn02' ?>">
        <span><?php echo Yii::t('sellerOrder', '退货中'); ?>(<?php echo $returnNum; ?>)</span>
    </a>
</div>

<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt15 sellerT3">
    <tr>
        <th width="43%" class="bgBlack">
            <span style="float: left">
                <input type="checkbox" class="checkAll"/>&nbsp;<?php echo Yii::t('sellerOrder', '全选'); ?>
            </span>
            <?php echo Yii::t('sellerOrder', '商品'); ?>
        </th>
        <th width="10%" class="bgBlack"><?php echo Yii::t('sellerOrder', '单价(元)'); ?></th>
        <th width="6%" class="bgBlack"><?php echo Yii::t('sellerOrder', '数量'); ?></th>
        <th width="6%" class="bgBlack"><?php echo Yii::t('sellerOrder', '运费'); ?></th>
        <th width="10%" class="bgBlack"><?php echo Yii::t('sellerOrder', '实付'); ?></th>
        <th width="15%" class="bgBlack"><?php echo Yii::t('sellerOrder', '状态'); ?></th>
        <th width="10%" class="bgBlack"><?php echo Yii::t('sellerOrder', '操作'); ?></th>
    </tr>
    <?php /** @var $v Order */ ?>
    <?php foreach ($orders as $k => $v): ?>
        <tr>
            <td colspan="7" align="left" valign="middle" class="bgE5">
                <?php if (!$v->is_read): ?>
                    <input type="checkbox" class="is_read" name="is_read" value="<?php echo $v->id ?>"/>&nbsp;
                <?php endif; ?>
                <b><?php echo Yii::t('sellerOrder', '订单编号'); ?>： <?php echo $v->code ?></b>
                <?php echo Yii::t('sellerOrder', '下单时间'); ?>：
                <?php echo $this->format()->formatDatetime($v->create_time) ?>&nbsp; &nbsp; &nbsp;
            </td>
        </tr>
        <?php if (empty($v->orderGoods)) continue; ?>
        <?php $this->renderPartial('_ordergoods', array('order' => $v)) ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="1"><input type="checkbox" class="checkAll"/>&nbsp;
            <a href="#" id="setAllRead" class="sellerBtn04"><span><?php echo Yii::t('sellerOrder', '批量标记为已读'); ?></span></a>
        </td>
        <td height="35" colspan="6" align="center" valign="middle" class="bgF4">

            <?php
            $this->widget('LinkPager', array(
                'pages' => $pages,
                'jump' => false,
                'htmlOptions' => array('class' => 'pagination'),
            ))
            ?>

        </td>
    </tr>
</table>
<!--<style type="text/css">
    textarea#confirmReason{
        border-color:red;border-width: 1px;
    }
</style>-->
<div style="display: none;" id="confirmArea">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-come">
        <tbody>
            <tr>
                <th style="text-align: center;padding-bottom: 5px;font-size: 14px;" id="confimTitle" class="title-th even" colspan="3"></th>
            </tr>
            <tr>
                <td id="confirmDetail" colspan="2" class="odd">

                </td>
            </tr>
            <tr id="confirmTR" >
                <th class="even">
                    <?php echo Yii::t('cashHistory', '关闭订单原因'); ?>：
                </th>
                <td class="even" >
                    <textarea name="confirmReason" id="confirmReason" cols="50" rows="3" style="width: 95%;border:solid 1px #eee;" class="text-input-bj  text-area"></textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    var token = "<?php echo Yii::app()->request->csrfToken;?>";
    /**
     * ajax 操作订单 备货、取消订单等的公共方法
     * @param url
     * @param code
     * @param msg
     */
    function ajaxUpdateOrder(url, code, msg) {
        art.dialog({
            icon: 'question',
            title: '<?php echo Yii::t('sellerOrder', '消息') ?>',
            okVal: '<?php echo Yii::t('sellerOrder', '确定') ?>',
            cancelVal: '<?php echo Yii::t('sellerOrder', '取消') ?>',
            content: msg,
            lock: true,
            cancel: true,
            ok: function() {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: {code: code, YII_CSRF_TOKEN: "<?php echo Yii::app()->request->csrfToken ?>"},
                    success: function(data) {
                        if (data.success) {
                            art.dialog({icon: 'succeed', content: data.success});
                            location.reload();
                        } else {
                            art.dialog({icon: 'error', content: data.error});
                        }
                    }
                });
            }
        });
    }
    //关闭订单
    $(".closeOrder").click(function() {
        var code = $(this).attr("data-code");
        var url = '<?php echo Yii::app()->createAbsoluteUrl('/seller/order/closeOrder') ?>';
        var msg = '<?php echo Yii::t('sellerOrder', '您确认要取消此订单吗？'); ?>';
        $("#confimTitle").html(msg);
        art.dialog({     
            icon: 'question',
            title: '<?php echo Yii::t('sellerOrder', '消息') ?>',
            okVal: '<?php echo Yii::t('sellerOrder', '确定') ?>',
            cancelVal: '<?php echo Yii::t('sellerOrder', '取消') ?>',
            content: $("#confirmArea").html(),
            lock: true,
            cancel: true,
            ok: function() {
                var reason = $("#confirmReason").val();
                if (reason.length == 0 && status != 'transfering') {
                    alert("<?php echo Yii::t('sellerOrder', '请填写关闭订单原因信息'); ?>");
                    return false;
                }

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: {code: code, YII_CSRF_TOKEN: "<?php echo Yii::app()->request->csrfToken ?>",reason:reason},
                    success: function(data) {
                        if (data.success) {
                            art.dialog({icon: 'succeed', content: data.success});
                            location.reload();
                        } else {
                            art.dialog({icon: 'error', content: data.error});
                        }
                    }
                });
            }
        });
        return false;
    });
    //备货
    $(".stockup").click(function() {
        var code = $(this).attr("data-code");
        var url = '<?php echo Yii::app()->createAbsoluteUrl('/seller/order/stockUp') ?>';
        var msg = '<?php echo Yii::t('sellerOrder', '确定备货吗？'); ?>';
        ajaxUpdateOrder(url, code, msg);
        return false;
    });
    //同意退款
    $(".agreerefund").click(function() {
        var orderId = $(this).attr("data-code");//订单id
        var refundStatus = $(this).attr('data-agree');//同意退款
        var string = '<?php echo Yii::t('sellerOrder', '你确定同意退款？您需退给买家的货款为：'); ?>';
            string += $(this).attr('money') + '<?php echo Yii::t('sellerOrder', ' 元'); ?>'
        art.dialog({
            icon: 'question',
            content: string,
            ok: function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createAbsoluteUrl('/seller/order/refund') ?>",
                    data: {
                        "YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
                        "orderId": orderId,
                        "refundStatus": refundStatus
                    },
                    dataType: "json",
                    success: function(response) {
                        art.dialog({
                            icon: response.status,
                            content: response.msg,
                            ok: true
                        });
                        location.reload();
                    }
                });
            }
        });
        return false;
    });
    //不同意退款
    $(".disagreerefund").click(function() {
        var orderId = $(this).attr("data-code");//订单id
        var refundStatus = $(this).attr('data-disagree');//同意退款
        art.dialog({
            icon: 'question',
            content: '<?php echo Yii::t('sellerOrder', '你确定不同意退款？'); ?>',
            ok: function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createAbsoluteUrl('/seller/order/refund') ?>",
                    data: {
                        "YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
                        "orderId": orderId,
                        "refundStatus": refundStatus
                    },
                    success: function() {
                        art.dialog({
                            icon: 'succeed',
                            content: '<?php echo Yii::t('sellerOrder', '不同意退款'); ?>',
                            ok: true
                        });
                        location.reload();
                    }
                });
            }
        });
        return false;
    });
</script>
<script>
    //批量设置已读
    $(".checkAll").click(function() {
        if (this.checked) {
            $(".is_read").attr("checked", "checked");
        } else {
            $(".is_read").removeAttr("checked");
        }
    });
    $("#setAllRead").click(function() {
        var $is_read = $(":input[name='is_read']:checked");
        if ($is_read.length == 0) {
            art.dialog({
                icon: 'warning',
                content: '<?php echo Yii::t('sellerOrder', '请选择订单'); ?>',
                ok: true,
                lock: true
            });
            return false;
        }
        var orderIds = [];
        $is_read.each(function() {
            orderIds.push($(this).val());
        });
        var url = "<?php echo $this->createAbsoluteUrl('/seller/order/setRead') ?>";
        $.post(url, {ids: orderIds.join(','), YII_CSRF_TOKEN: "<?php echo Yii::app()->request->csrfToken ?>"}, function(data) {
            art.dialog({icon: 'succeed', content: data});
            location.reload();
        });
        return false;
    });

    //确认协商退货
    function ConfirmAGRePurcharse(orderId, deductFreight) {
        var url = '/order/return/orderId/' + orderId + '/freight/' + deductFreight;
        dialog = art.dialog.open(url, {'id': 'SureOrderRepur', title: '<?php echo Yii::t('sellerOrder', '退货协商'); ?>', width: '500px', height: '145px', lock: true});
    }

    //确认签收退货
    /*
     $(".agreeReturn").click(function () {
     var orderId = $(this).attr("data-code");//订单id
     art.dialog({
     icon: 'question',
     content: '<?php echo Yii::t('sellerOrder', '你确认签收退货吗？'); ?>',
     ok: function () {
     $.ajax({
     type: "POST",
     url: "<?php echo Yii::app()->createAbsoluteUrl('/seller/order/signReturn') ?>",
     data: {
     "YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
     "orderId": orderId
     },
     success: function () {
     art.dialog({
     icon: 'succeed',
     content: '<?php echo Yii::t('sellerOrder', '退款成功'); ?>',
     ok: true
     });
     location.reload();
     }
     });
     }
     });
     return false;
     });
     */

    /**
     * 获取Excel
     */
    function getExcel() {
        var url = window.location.href.replace("order/index", "order/excel/t/"+Math.random());
        window.open(url);
    }

    var goodsReturn = function(repit) {
        if (repit) {
            art.dialog({
                icon: 'succeed',
                content: '<?php echo Yii::t('sellerOrder', '退货成功'); ?>',
                lock: true,
                ok: function() {
                    location.reload();
                }
            });
            location.reload();
        } else {
            art.dialog({
                icon: 'error',
                content: '<?php echo Yii::t('sellerOrder', '不同意退货'); ?>',
                lock: true,
                ok: function() {
                    location.reload();
                }
            });
        }
    }

    //签收确认收货
    function ConfirmDelete(money) {
        var string = "<?php echo Yii::t('sellerOrder', '确认签收退货吗? 您需退给买家的货款为：'); ?>";
            string += money + "<?php echo Yii::t('sellerOrder', ' 元'); ?>";
        var flag = confirm(string);
        if (flag) {
            art.dialog({
                title: '<?php echo Yii::t('sellerOrder', '签收退货'); ?>',
                content: '<?php echo Yii::t('sellerOrder', '签收退货正在操作中...'); ?>',
                lock: true
            });
            return true;
        } else {
            return false;
        }
    }

    $(document).ajaxStart(function() {
        art.dialog({
            lock: true,
            content: '<?php echo Yii::t('sellerOrder', '正在提交请求，请稍后……'); ?>'
        });
    });
    $(document).ajaxError(function() {
        art.dialog({
            content: "<?php echo Yii::t('sellerOrder', '操作失败，请重试'); ?>",
            ok: function() {
                document.location.reload();
            }});
    });

</script>