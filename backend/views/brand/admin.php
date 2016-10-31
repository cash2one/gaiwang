<?php
/* @var $this BrandController */
/* @var $model Brand */

$this->breadcrumbs = array(Yii::t('brand', '品牌 ') => array('admin'), '列表');

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#brand-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if ($this->getUser()->checkAccess('Brand.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/brand/create') ?>"><?php echo Yii::t('brand', '添加品牌') ?></a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'brand-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        array(
            'name' => 'logo',
            'value' => '$data->logo ? CHtml::image(IMG_DOMAIN.\'/\'.$data->logo, $data->name, array("width" => 100,"height" => 35, "style" => "display: inline-block")) : ""',
            'type' => 'raw',
            'htmlOptions' => array(
                'width' => '150',
                'style' => 'text-align:center',
            )
        ),
        array(
            'name' => 'status',
            'value' => 'Brand::showStatus($data->status)'
        ),
        'code',
        array(
            'name'=>'mobile',
            'value'=>'$data->mobile'
        ),
        array(
            'name' => 'store_id',
            'value' => '$data->storeName'
        ),
        array(
            'name' => 'category_id',
            'value' => 'isset($data->category) ? $data->category->name: ""'
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('brand', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('Brand.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('brand', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Brand.Delete')"
                ),
            )
        )
    ),
));
?>
