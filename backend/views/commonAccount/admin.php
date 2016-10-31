<?php

/* @var $this CommonAccountController */
/* @var $model CommonAccount */
$this->breadcrumbs = array(
    '共有账号' => array('admin'),
    '列表',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#common-account-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
//	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model,)); ?>
<?php

$this->widget('GridView', array(
    'id' => 'common-account-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'name',
        array(
            'name' => 'type',
            'value' => 'CommonAccount::showType($data->type)'
        ),
//        array(
//            'name' => 'city_id',
//            'value' => '!empty($data->dis->name)?$data->dis->name:""'
//        ),
        array(
            'name' => 'gai_number',
            'value' => '$data->gai_number',
        ),
    ),
));
?>


<?php 
	$this->renderPartial('/layouts/_export', array(
	    'model' => $model,'exportPage' => $exportPage,'totalCount'=>$totalCount,
	));
?>