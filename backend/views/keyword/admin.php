<?php
/* @var $this KeywordController */
/* @var $model Keyword */

$this->breadcrumbs = array(
    Yii::t('keyword', '商品搜索管理') => array('admin'),
    Yii::t('keyword', '商品搜索列表'),
);
?>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#keyword-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>

<?php $this->renderPartial('_search', array('model' => $model,)); ?>

<div class="c10"></div>

<?php
$this->widget('GridView', array(
    'id' => 'keyword-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'id',
        'name',
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{delete}',
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('InterestCategory.Delete')"
                ),
            )
        )
    ),
));
?>
