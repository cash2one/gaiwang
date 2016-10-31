<?php
/* @var $this OrderController */
/* @var $model Order */
?>


<?php $this->renderPartial('_exceptionsearch',array('model'=>$model)) ?>

<?php $this->widget('GridView', array(
    'id'=>'order-grid',
    'dataProvider'=>$model->searchException(),
    'itemsCssClass' => 'tab-reg',
    'columns'=>array(
        array(
            'name' => 'code',
            'value' => '$data->real_price>=20000?"<span class=\"ico_sb\">".$data->code."</span>":$data->code',
            'type' => 'raw',
        ),
        array(
            'name'=>'member_id',
            'header'=>'买家会员编号'
        ),
        array(
            'name'=>'store_id',
            'header'=>'商铺名称',
        ),
        array(
            'name'=>'refund_status',
            'value'=>'Order::refundStatus($data->refund_status)',
        ),
        array(
            'name'=>'return_status',
            'value'=>'Order::returnStatus($data->return_status)',
        ),
        array(
            'name'=>'create_time',
            'type'=>'dateTime'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'header' => Yii::t('order', '操作'),
            'viewButtonLabel' => Yii::t('order', '查看'),
            'viewButtonImageUrl' => false,
	        'buttons' => array(
	                'view' => array(
	                    'label' => Yii::t('user', '查看'),
	                    'visible' => "Yii::app()->user->checkAccess('Order.View')"
	                ),
	        )
        ),
    ),
)); ?>

<script type="text/javascript">
//隐藏导出菜单
function hide_excel(){
	if($("span.empty").html()=='没有找到数据.'){
		$("div.summary").hide();	
	}
}
setInterval('hide_excel()',1000);
</script>

<?php 
	$this->renderPartial('/layouts/_export', array(
	    'model' => $model,'exportPage' => $exportPage,'totalCount'=>$totalCount,
	));
?>