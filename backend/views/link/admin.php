<?php
$this->breadcrumbs = array(
    Yii::t('link', '友情链接管理') => array('admin'),
    Yii::t('link', '友情链接列表'),
);
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#link-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if ($this->getUser()->checkAccess('Link.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/link/create') ?>">添加链接</a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'link-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        array(
            'type' => 'raw',
            'name' => 'url',
            'value' => 'CHtml::link($data->url, $data->url, array("target"=>"_black"))',
        ),
        'sort',
        array(
            'name' => 'position',
            'value' => '$data->position == link::POSITION_HOME ? "'.Yii::t('link','首页').'" : "'.Yii::t('link','默认').'"', 
        ),
        array(
            'class' => 'CButtonColumn',
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('Link.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Link.Delete')"
                ),
            ),
            'template' => '{update}{delete}',
            'updateButtonLabel' => '编辑',
            'updateButtonImageUrl' => false,
            'deleteButtonLabel' => '删除',
            'deleteButtonImageUrl' => false,
        ),
    ),
));
?>

