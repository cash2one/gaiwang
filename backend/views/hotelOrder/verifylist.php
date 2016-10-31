<?php
/* @var $this HotelOrderController */
/* @var $model HotelOrder */

$this->breadcrumbs = array(
    Yii::t('hotelOrder', '酒店订单') => array('admin'),
    Yii::t('hotelOrder', '确认订单列表'),
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
            'class' => 'CButtonColumn',
            'header' => Yii::t('hotelOrder', '操作'),
            'template' => '{view}{cancel}{complete}',
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
                'complete' => array(
                    'label' => Yii::t('hotelOrder', '核对'),
                    'url' => 'Yii::app()->createAbsoluteUrl("hotelOrder/OrderCheck", array("id"=>$data->primaryKey))',
                    'imageUrl' => false,
                    'visible' => "Yii::app()->user->checkAccess('HotelOrder.OrderCheck')",
                )
            )
        ),
    ),
));
?>

