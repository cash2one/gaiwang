<?php
/* @var $this AssistantController */
/* @var $model Assistant */

$this->breadcrumbs=array(
	Yii::t('sellerAssistant','店小二管理'),
	Yii::t('sellerAssistant','店小二列表'),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#assistant-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>
<div class="toolbar">
    <h3><?php echo Yii::t('sellerAssistant','店小二列表'); ?></h3>
</div>

<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
<?php echo CHtml::link(Yii::t('sellerAssistant','店小二'),
    $this->createAbsoluteUrl('/seller/assistant/create'),array('class'=>'mt15 btnSellerAdd')); ?>

<?php $this->widget('GridView', array(
	'id'=>'assistant-grid',
	'dataProvider'=>$model->search($this->getUser()->id),
    'itemsCssClass' => 'mt15 sellerT3 goodsIndex',
    'cssFile'=>false,
    'pager'=>array(
        'class'=>'LinkPager',
        'htmlOptions'=>array('class'=>'pagination'),
    ),
    'pagerCssClass'=>'page_bottom clearfix',
	'columns'=>array(
		'username',
		'real_name',
		'mobile',
		array('name'=>'status','value'=>'$data::status($data->status)'),
		/*
		'avatar',
		'sex',
		'mobile',
		'email',
		'status',
		'logins',
		'description',
		'sort',
		'create_time',
		'update_time',
		*/
		array(
			'class'=>'CButtonColumn',
            'header' => Yii::t('sellerAssistant','操作'),
            'template'=>'{update}&nbsp;&nbsp;{delete}',
            'deleteButtonLabel' => '<span>'.Yii::t('sellerAssistant','删除').'</span>',
            'updateButtonLabel' => '<span>'.Yii::t('sellerAssistant','编辑').'</span>',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'updateButtonOptions'=>array('class'=>'sellerBtn03'),
            'deleteButtonOptions'=>array('class'=>'sellerBtn01'),
		),
	),
)); ?>
