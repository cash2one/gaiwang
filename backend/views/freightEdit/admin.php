<?php
$this->breadcrumbs = array(
    Yii::t('order', '订单管理') => array('order/admin'),
    Yii::t('freightEdit', '运费编辑管理'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#franchisee-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>

<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'franchisee-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'code',
        'old_freight',
        'new_freight',
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d G:i:s",$data->create_time)',
        ),
        array(
            'type' => 'raw',
            'name' => Yii::t("freightEdit", "操作"),
            'value' => 'CHtml::link("查看订单",Yii::app()->createUrl("order/view",array("id"=>$data->order_id)))',
        ),
    ),
));
?>
