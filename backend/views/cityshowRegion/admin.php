<?php
/* @var $this CityshowRegionController */
/* @var $model CityshowRegion */

$this->breadcrumbs=array(
	'城市馆大区'=>array('admin'),
	'列表',
);
?>
<?php if ($this->getUser()->checkAccess('CityshowRegion.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/cityshowRegion/create') ?>"><?php echo Yii::t('brand', '添加大区') ?></a>
<?php endif; ?>
<div class="c10"></div>

<?php $this->widget('GridView', array(
	'id'=>'cityshow-region-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'cssFile' => false,
	'itemsCssClass' => 'tab-reg',
	'columns'=>array(
		'id',
		'name',
		array(
            'name'=>'status',
            'value'=>'CityshowRegion::status($data->status)',
            'filter'=>CityshowRegion::status(),
        ),
		'sort',
		array(
			'class'=>'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('brand', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('CityshowRegion.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('brand', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('CityshowRegion.Delete')"
                ),
            )
		),
	),
)); ?>
