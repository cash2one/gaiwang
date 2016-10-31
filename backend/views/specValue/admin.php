<?php
/* @var $this SpecValueController */
/* @var $model SpecValue */

$this->breadcrumbs = array(
    Yii::t('specValue', '商品规格管理 ') => array('spec/admin'),
    Yii::t('specValue', '规格值管理'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#spec-value-grid').yiiGridView('update', {
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
<?php if ($this->getUser()->checkAccess('SpecValue.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/specValue/create', array('spec_id' => $model->spec_id)) ?>"><?php echo Yii::t('specValue', '添加规格值') ?></a>
<?php endif; ?>
<div class="c10"></div>

<?php
// 判断显示图片列
$specType = Spec::model()->findByPk($model->spec_id)->type;
$visible = ($specType == Spec::TYPE_TEXT) ? false : true;
// ===================
$this->widget('GridView', array(
    'id' => 'spec-value-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        array(
            'name' => 'spec_id',
            'value' => '$data->spec->name'
        ),
        array(
            'name' => 'thumbnail',
            'value' => 'CHtml::image(ATTR_DOMAIN.\'/\'.$data->thumbnail,$data->name,array("width"=>25,"height"=>25))',
            'type' => 'raw', //这里是原型输出
            'htmlOptions' => array(
                'width' => '25',
                'height' => '25',
                'style' => 'text-align:center',
            ),
            'visible' => $visible,
        ),
        'sort',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('SpecValue.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('SpecValue.Delete')"
                ),
            )
        ),
    ),
));
?>
