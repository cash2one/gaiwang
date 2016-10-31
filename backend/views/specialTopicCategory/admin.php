<?php
/* @var $this SpecialTopicCategoryController */
/* @var $model SpecialTopicCategory */

$this->breadcrumbs = array(
    '专题管理' => array('/specialTopic/admin'),
    '专题分类',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#special-topic-category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php if ($this->getUser()->checkAccess('SpecialTopicCategory.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/specialTopicCategory/create', array('specialId' => $this->specialId)) ?>"><?php echo Yii::t('specialTopicCategory', '添加分类'); ?></a>
    <div class="c10"></div>
<?php endif; ?>
<?php
$this->widget('GridView', array(
    'id' => 'special-topic-category-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'name',
        array(
            'type' => 'raw',
            'name' => 'thumbnail',
            'value' => 'CHtml::image(ATTR_DOMAIN . "/" . $data->thumbnail, $data->name, array("width" => "220", "height" => "40"))',
        ),
        'integral_ratio',
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{list}',
            'updateButtonImageUrl' => false,
            'htmlOptions' => array('class' => 'tc'),
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('specialTopicCategory', '【编辑】'),
                    'url' => 'Yii::app()->createAbsoluteUrl("/specialTopicCategory/update", array("id" => $data->primaryKey, "specialId" => $data->special_topic_id))',
                    'visible' => "Yii::app()->user->checkAccess('SpecialTopicCategory.Update')"
                ),
                'list' => array(
                    'label' => Yii::t('specialTopicCategory', '【商品列表】'),
                    'url' => 'Yii::app()->createAbsoluteUrl("/specialTopicGoods/admin", array("categoryId" => $data->primaryKey))',
                    'visible' => "Yii::app()->user->checkAccess('SpecialTopicGoods.Admin')"
                ),
            ),
        ),
    ),
));
?>
