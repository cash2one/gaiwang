<?php
/* @var $this CharityController */
/* @var $model Charity */

$this->breadcrumbs = array(
    Yii::t('charity', '盖网通公益 ') => array('admin'),
    Yii::t('charity', '募捐列表'),
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
");
?>

<?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'charity-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'name' => 'member_id',
            'value' => '!$data->member ? "" : $data->member->gai_number',
        ),
        'sign',
        'money',
        'score',
        'area',
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i:s",$data->create_time)',
        ),
        array(
            'name' => 'pay_type',
            'value' => 'Charity::getPayType($data->pay_type)',
        ),
        array(
            'name' => 'status',
            'value' => 'Charity::getPayStatus($data->status)',
        ),
//        'type',
//        array(
//            'name' => 'status',
//            'value' => 'Brand::showStatus($data->status)'
//        ),
    ),
));
?>
