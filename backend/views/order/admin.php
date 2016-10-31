<?php
/* @var $this OrderController */
/* @var $model Order */
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#order-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
//	return false;
});
");
?>

<div class="search-form" >
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<?php
?>
<?php
$this->widget('GridView', array(
    'id' => 'order-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'name' => 'code',
            'value' => '$data->real_price>=20000?"<span class=\"ico_sb\">".$data->code."</span>":$data->code',
            'type' => 'raw',
        ),
        'member_id',
        array(
            'header' => '查看充值记录',
            'value' => '"<a href=\"javascript:prepaidCardUsedLookUp(\'$data->member_id\')\" >查看充值记录</a>"',
//        	'value'=>'"<a href=\"/?r=recharge/admin&Recharge[member_id]=$data->member_id\" target=\"_blank\" >查看充值记录</a>"',
            'type' => 'raw'
        ),
        'store_id',
        array(
            'name' => 'status',
            'value' => '"<span class=\"status\" data-status=\"$data->status\">".Order::status($data->status)."</span>"',
            'type' => 'raw',
        ),
        array(
            'name' => 'delivery_status',
            'value' => 'Order::deliveryStatus($data->delivery_status)',
        ),
        array(
            'name' => 'pay_status',
            'value' => 'Order::payStatus($data->pay_status)',
        ),
        array(
            'name' => 'refund_status',
            'value' => 'Order::refundStatus($data->refund_status)',
        ),
        array(
            'name' => 'return_status',
            'value' => 'Order::returnStatus($data->return_status)',
        ),
        array('name' => 'create_time', 'type' => 'dateTime'),
        array(
            'name' => 'sign_time',
            'value' => '$data->sign_time ? date("Y-m-d H:i:s", $data->sign_time) : ""'
        ),
        array(
            'name'=>'支付单号',
            'value'=>'$data->parent_code'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{close}',
            'htmlOptions' => array('style'=>'width:120px','class'=>'button-column'),
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'view' => array(
                    'label' => Yii::t('user', '查看'),
                    'visible' => "Yii::app()->user->checkAccess('Order.View')"
                ),
                'close' => array(
                    'label' => Yii::t('user', '关闭'),
                    'url' =>'Yii::app()->createAbsoluteUrl("order/closeOrder",array("id"=>$data->id))',
                    'visible' => '($data->status != Order::STATUS_CLOSE) '." && Yii::app()->user->checkAccess('Order.closeOrder') && ".'Order::IS_COMMENT_NO==$data->is_comment'
                ),
            )
        ),
    ),
));
?>
<script>
    function prepaidCardUsedLookUp(gai_number) {
        //弹出添加等窗口    
        var dialog = art.dialog({id: 'N3690', title: '充值记录', width: '90%', height: '90%', background: '#333', opacity: 0.40});
        $.ajax({
            url: "<?php echo $this->createUrl('recharge/admin') ?>&Recharge[member_id]=" + gai_number,
            success: function(data) {
                dialog.content(data);
                $(".aui_state_focus").css('width', '90%');
                $(".aui_content").css('width', '90%');

            },
            cache: false
        });
    }
    //设置订单状态不同的颜色
    setInterval(function() {
        $(".status").each(function(att, value) {
            switch (parseInt($(this).attr('data-status'))) {
                case <?php echo Order::STATUS_CLOSE ?>:
                    $(this).css('color', 'red');
                    break;
                case <?php echo Order::STATUS_NEW ?>:
                    $(this).css('color', 'blue');
                    break;
                case <?php echo Order::STATUS_COMPLETE ?>:
                    $(this).css('color', 'green');
                    break;
            }
        });
    }, 1000);

    //隐藏导出菜单
    function hide_excel() {
        if ($("span.empty").html() == '没有找到数据.') {
            $("div.summary").hide();
        }
    }
    setInterval('hide_excel()', 1000);

</script>

<?php
$this->renderPartial('/layouts/_export', array(
    'model' => $model, 'exportPage' => $exportPage, 'totalCount' => $totalCount,
));
?>