<?php
$this->breadcrumbs = array(
    Yii::t('franchiseeActivityCity', '加盟商城市管理') => array('admin'),
    Yii::t('franchiseeActivityCity', '线下活动城市'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#franchisee-activity-city-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('FranchiseeActivityCity.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/franchiseeActivityCity/create') ?>"><?php echo Yii::t('franchiseeActivityCity', '添加城市') ?></a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'franchisee-activity-city-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'id',
        array(
            'name' => 'province_id',
            'value' => 'Region::model()->getName($data->province_id)',
        ),
        array(
            'name' => 'city_id',
            'value' => 'Region::model()->getName($data->city_id)',
        ),
        array(
            'name' => 'default',
            'value' => 'FranchiseeActivityCity::getDefaultText($data->default)',
        ),
        array(
            'name' => 'create_time',
            'value' => 'date(\'Y-m-d H:i:s\', $data->create_time)',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('FranchiseeActivityCity.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('FranchiseeActivityCity.Delete')"
                ),
            )
        )
    ),
));
?>
