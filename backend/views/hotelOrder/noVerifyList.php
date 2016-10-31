<?php
/* @var $this HotelOrderController */
/* @var $model HotelOrder */

$this->breadcrumbs = array(
    Yii::t('hotelOrder', '酒店订单') => array('admin'),
    Yii::t('hotelOrder', '待确认订单列表'),
);

Yii::app()->clientScript->registerScript('search', "
$('#hotel-order-form').submit(function(){
	$('#hotel-order-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<script type="text/javascript">
    function confirmCancle(orderid) {
        artDialog.confirm('<?php echo Yii::t('hotelOrder', '你确认要取消此订单吗？') ?>', function() {
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo urldecode(Yii::app()->createAbsoluteUrl("hotelOrder/cancelOrder", array("id" => '\'+orderid+\''))); ?>',
                data: {
                    'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken; ?>'
                },
                success: function(data, textStatus, jqXHR) {
                    var data = $.parseJSON(data);
                    var icon = 'error-red';
                    if (data.status) {
                        $.fn.yiiGridView.update("hotel-order-grid");
                        icon = 'succeed-red';
                    }
                    artDialog.alert(data.msg, null, icon);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown)
                },
                cache: false
            });
        });
    }
    ;
</script>
<?php
$this->widget('GridView', array(
    'id' => 'hotel-order-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'code',
        array(
            'name' => Yii::t('HotelOrder', '买家会员编号'),
            'value' => 'empty($data->member->gai_number) ? "" : $data->member->gai_number'
        ),
        'hotel_name',
        array(
            'type' => 'date',
            'name' => 'settled_time',
            'value' => '$data->settled_time'
        ),
        'contact',
        'mobile',
        array(
            'name' => 'pay_status',
            'value' => 'HotelOrder::getPayStatus($data->pay_status)',
            'cssClassExpression' => 'HotelOrderController::getPayStatusColor($data->pay_status)'
        ),
        array(
            'name' => 'total_price',
            'value' => 'HtmlHelper::formatPrice($data->total_price)',
            'htmlOptions' => array(
                'style' => 'color: #F60; font-weight: bold;',
            ),
        ),
        array(
            'type' => 'datetime',
            'name' => 'create_time',
            'value' => '$data->create_time'
        ),
        array(
            'name' => 'is_lottery',
            'value' => 'HotelOrder::getIsLottery($data->is_lottery)'
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('hotelOrder', '操作'),
            'template' => '{view}{verify}{cancel}',
            'viewButtonLabel' => Yii::t('hotelOrder', '查看'),
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'view' => array(
                    'visible' => "Yii::app()->user->checkAccess('HotelOrder.View')"
                ),
                'verify' => array(
                    'label' => Yii::t('hotelOrder', '确认'),
                    'url' => 'Yii::app()->createAbsoluteUrl("hotelOrder/verifyOrder", array("id"=>$data->primaryKey))',
                    'imageUrl' => false,
                    'visible' => '($data->pay_status == HotelOrder::PAY_STATUS_YES) && Yii::app()->user->checkAccess("HotelOrder.VerifyOrder")'
                ),
                'cancel' => array(
                    'label' => Yii::t('hotelOrder', '取消'),
                    'url' => '"javascript:confirmCancle(\"$data->primaryKey\")"',
                    'visible' => "Yii::app()->user->checkAccess('HotelOrder.CancelOrder')",
                    'imageUrl' => false,
                ),
            )
        ),
    ),
));
?>