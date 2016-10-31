<?php
/* @var $this ArticleCategoryController */
/* @var $model ArticleCategory */
$this->breadcrumbs = array(
    Yii::t('articleCategory', '文章分类') => array('admin'),
    Yii::t('articleCategory', '列表'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#article-category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('ArticleCategory.Create')): ?>
    <input id="Btn_Add" type="button" value="添加分类" class="regm-sub" onclick="location.href = '<?php echo Yii::app()->createAbsoluteUrl("/articleCategory/create"); ?>'">
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'article-category-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'summaryText' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'id',
        'name',
        array(
            'name' => 'parent_id',
            'value' => '($data->parent_id>0 && $pk = ArticleCategory::model()->findByPk($data->parent_id))?$pk->name : "一级分类"'
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}',
            'updateButtonImageUrl' => false,
//            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('ArticleCategory.Update')"
                ),
//                'delete' => array(
//                    'label' => Yii::t('user', '删除'),
//                    'visible' => "Yii::app()->user->checkAccess('ArticleCategory.Delete')"
//                ),
            )
        )
    ),
));
?>

