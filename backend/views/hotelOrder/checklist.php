<?php
/* @var $this HotelOrderController */
/* @var $model HotelOrder */

$this->breadcrumbs = array(
    Yii::t('hotelOrder', '酒店订单') => array('admin'),
    Yii::t('hotelOrder', '订单核对列表'),
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
        artDialog.confirm('<?php echo Yii::t('hotelOrder', '你确认要取消此订单吗？'); ?>', function() {
            var url = '<?php echo urldecode(Yii::app()->createAbsoluteUrl("hotelOrder/deductFactorage", array("id" => '\'+orderid+\''))); ?>';
            dialog = art.dialog.open(url, {'id': 'selectBiz', title: '<?php echo Yii::t('hotelOrder', '选择是否扣除手续费'); ?>', width: '270px', height: '100px', lock: true});
        });
    }
    ;
    var jump = function(msg) {
        location.href = "<?php echo urldecode(Yii::app()->createAbsoluteUrl('/hotelOrder/newList', array('msg' => '"+msg+"'))); ?>";
    };
</script>
<?php
$this->widget('GridView', array(
    'id' => 'hotel-order-grid',
    'dataProvider' => $dataProvider,
    'itemsCssClass' => 'tab-reg',
    'ajaxUpdate' => false,
    'cssFile' => false,
    'columns' => array(
        'code',
        'hotel_name',
        'room_name',
        array(
            'name' => 'create_time',
            'value' => '$data->create_time ? date("Y-m-d H:i:s", $data->create_time) : ""'
        ),
        array(
            'name' => 'settled_time',
            'value' => '$data->settled_time ? date("Y-m-d", $data->settled_time) : ""'
        ),
        array(
            'name' => 'is_lottery',
            'value' => 'HotelOrder::getIsLottery($data->is_lottery)'
        ),
        array(
            'name' => 'unit_price',
            'value' => 'HtmlHelper::formatPrice($data->unit_price)',
            'htmlOptions' => array(
                'style' => 'color: #F60; font-weight: bold;',
            ),
        ),
        array(
            'name' => 'total_price',
            'value' => 'HtmlHelper::formatPrice($data->total_price)',
            'htmlOptions' => array(
                'style' => 'color: #F60; font-weight: bold;',
            ),
        ),
        array(
            'name' => 'unit_gai_price',
            'value' => 'HtmlHelper::formatPrice($data->unit_gai_price)',
            'htmlOptions' => array(
                'style' => 'color: #F60; font-weight: bold;',
            ),
        ),
        array(
            'name' => 'price_radio',
            'value' => 'HtmlHelper::formatPrice($data->price_radio)',
            'htmlOptions' => array(
                'style' => 'color: #F60; font-weight: bold;',
            ),
        ),
        array(
            'name' => 'gai_income',
            'value' => '$data->gai_income."%"',
            'htmlOptions' => array(
                'style' => 'color: #F60; font-weight: bold;',
            ),
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('hotelOrder', '操作'),
            'template' => '{view}{cancel}{checking}',
            'viewButtonLabel' => Yii::t('hotelOrder', '查看'),
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'view' => array(
                    'visible' => "Yii::app()->user->checkAccess('HotelOrder.View')"
                ),
                'cancel' => array(
                    'label' => Yii::t('hotelOrder', '取消'),
                    'url' => '"javascript:confirmCancle(\"$data->primaryKey\")"',
                    'visible' => "Yii::app()->user->checkAccess('HotelOrder.CancelVerifyOrder')",
                    'imageUrl' => false,
                ),
                'checking' => array(
                    'label' => Yii::t('hotelOrder', '对账'),
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createAbsoluteUrl("hotelOrder/orderChecking", array("id" => $data->id))',
                    'visible' => "Yii::app()->user->checkAccess('HotelOrder.OrderChecking')",
                    'options' => array(
                        'confirm' => Yii::t('hotelOrder', '确认订单对账？'),
                    )
                )
            )
        ),
    ),
));
?>
<?php $this->renderPartial('//layouts/_export', array('exportPage' => $exportPage, 'totalCount' => $totalCount)); ?>