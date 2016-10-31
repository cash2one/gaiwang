<?php
/* @var $this RegionController */
/* @var $model Region */
$this->breadcrumbs = array(Yii::t('region', '地区') => array('index'), '列表');

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#type-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if ($this->checkAccess('Region.Create')): ?>
    <input id="Btn_Add" type="button" value="<?php echo Yii::t('region', '添加地区'); ?>" class="regm-sub" onclick="location.href = '<?php echo $this->createAbsoluteUrl("/region/create"); ?>'">
<?php endif; ?>
<div class="c10"></div>

<?php
$this->widget('GridView', array(
    'id' => 'type-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        array(
            'type' => 'raw',
            'name' => 'parentName',
            'value' => 'empty($data->parent_id) ? "" : $data->parent->name',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'deleteConfirmation' => Yii::t('regon', '请慎重操作删除地区数据！'),
            'buttons' => array(
                'update' => array(
                    'visible' => 'Yii::app()->user->checkAccess("Region.Update")'
                ),
                'delete' => array(
                    'visible' => 'Yii::app()->user->checkAccess("Region.Delete")'
                ),
            )
        ),
    ),
));
?>
