<?php
/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */

$this->breadcrumbs = array(
    Yii::t('prepaidCard', '积分返还充值卡') => array('detail'),
    Yii::t('prepaidCard', '使用记录')
);
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#prepaid-card-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_searchused', array('model' => $model)); ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'prepaid-card-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'ajaxUpdate' => false,
    'cssFile' => false,
    'columns' => array(
        'number',
        'value',
        'money',
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i:s", $data->create_time)'
        ),
        array(
            'name' => 'member_id',
            'value' => 'isset($data->member) ? $data->member->gai_number : ""'
        ),
        array(
            'name' => 'use_time',
            'value' => 'date("Y-m-d H:i:s", $data->use_time)'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'viewButtonLabel' => Yii::t('prepaidCard', '查看'),
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'view' => array(
                    'label' => Yii::t('prepaidCard', '查看'),
        			'url'=>'Yii::app()->createUrl("prepaid-card/view",array("id"=>"$data->id","action"=>"detail"),"&")',
                    'imageUrl' => false,
                    'visible' => "Yii::app()->user->checkAccess('PrepaidCard.View')"
                ),
            )
        ),
    ),
));
?>
<?php $this->renderPartial('//layouts/_export', array('exportPage' => $exportPage, 'totalCount' => $totalCount)); ?>
