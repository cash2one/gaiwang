<?php

/* @var $this StoreArticleController */
/* @var $model StoreArticle */

$this->breadcrumbs = array('商铺' => array('admin'), '文章');
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#store-article-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model,)); ?>
<?php

$this->widget('GridView', array(
    'id' => 'store-article-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'store_id',
            'value' => '$data->store->name',
        ),
        'title',
        array(
            'name' => 'is_publish',
            'value' => 'StoreArticle::isPublish($data->is_publish)',
        ),
        array(
            'name' => 'status',
            'value' => 'StoreArticle::status($data->status)',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'header' => Yii::t('storeArticle', '操作'),
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('storeArticle', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('StoreArticle.Update')"
                ),
            )
        ),
    ),
));
?>
