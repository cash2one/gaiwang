<?php
/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */

$this->breadcrumbs = array(
    Yii::t('prepaidCard', '代收付') => array('list'),
    Yii::t('prepaidCard', '代付申请记录')
);
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#third-payment-grid').yiiGridView('update', {
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
    'id' => 'third-payment-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'ajaxUpdate' => false,
    'columns' => array(
        'req_id',
        array(
            'name' => 'bank_code',
            'value' => 'ThirdPayment::bankList($data->bank_code)',
            'type' => 'raw'
        ),
        'account_no',
        'account_name',
        'amout',
        array(
            'name' => 'payment_type',
            'value' => 'ThirdPayment::getPaymentType($data->payment_type)',
            'type' => 'raw'
            ),
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i:s", $data->create_time)'
        ), 
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('thridPayment', '操作'),
            'template' => '{view}',
            'viewButtonLabel' => Yii::t('thridPayment', '对账'),
            'viewButtonImageUrl' => false,
            'buttons' => array(
              'view' => array(
                  'label' => Yii::t('thridPayment', '对账'),
                  'url'=>'Yii::app()->createUrl("third-payment/orderQuery",array("id"=>"$data->req_id"))',
                  'imageUrl' => false,
                  'visible' => "Yii::app()->user->checkAccess('ThridPayment.View')"
                       ), 
               )
            ),
    ),
));
?>
<?php $this->renderPartial('//layouts/_export', array('exportPage' => $exportPage, 'totalCount' => $totalCount)); ?>