<?php
/* @var $this ArticleController */
/* @var $model Article */
$this->breadcrumbs = array(
    Yii::t('article', '文章') => array('admin'),
    Yii::t('article', '列表'),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#article-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php if (Yii::app()->user->checkAccess('Article.Create')): ?>
    <input id="Btn_Add" type="button" value="添加文章" class="regm-sub" onclick="location.href = '<?php echo Yii::app()->createAbsoluteUrl("/article/create"); ?>'">
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'article-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'name'=>'title',
            'value'=>'CHtml::link("$data->title","http://help.'.SHORT_DOMAIN.'/article/".$data->alias.".html",array("target"=>"_blank"))',
            'type'=>'raw'
        ),
        'alias',
        array(
            'name' => 'author_id',
            'value' => '!empty($data->author->username) ? $data->author->username : ""',
        ),
        array(
            'name' => 'category_id',
            'value' => '!empty($data->category->name) ? $data->category->name : ""',
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
                    'visible' => "Yii::app()->user->checkAccess('Article.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Article.Delete')"
                ),
            )
        )
    ),
));
?>
