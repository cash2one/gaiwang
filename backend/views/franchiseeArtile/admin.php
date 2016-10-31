<?php

/* @var $this FranchiseeArtileController */
/* @var $model FranchiseeArtile */

$this->breadcrumbs = array(
    Yii::t('franchiseeArtile', '加盟商管理 ') => array('admin'),
    Yii::t('franchiseeArtile', '加盟商文章列表'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#franchisee-artile-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php

$this->renderPartial('_search', array(
    'model' => $model,
));
?>

<?php

$this->widget('GridView', array(
    'id' => 'franchisee-artile-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'title',
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i",$data->create_time)',
        ),
        array(
            'name' => 'franchisee_id',
            'value' => 'FranchiseeArtile::getFranchiseeById($data->franchisee_id)',
        ),
        'views',
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('FranchiseeArtile.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('FranchiseeArtile.Delete')"
                ),
            )
        )
    ),
));
?>
