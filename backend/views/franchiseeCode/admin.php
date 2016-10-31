<?php

/* @var $this StoreController */
/* @var $model Store */
$this->breadcrumbs = array('加盟商管理' => array('admin'), '生成预设加盟商编号');
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#franchisee-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model,)); ?>
<?php

$this->widget('GridView', array(
    'id' => 'franchisee-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'create_time',
            'value' => 'date("Y/m/d H:i:s", $data->create_time)'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'header' => Yii::t('store', '操作'),
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('store', '导出'),
                    'url' => 'Yii::app()->controller->createUrl("update", array("create_time"=>$data->create_time,"grid_mode"=>"export"))',
                    'visible' => "Yii::app()->user->checkAccess('FranchiseeCode.Update')", 
                ),
            )
        ),
    ),
));
?>
