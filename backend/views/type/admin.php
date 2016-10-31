<?php
$this->breadcrumbs = array(
    Yii::t('type', '商品类型') => array('admin'),
    Yii::t('type', '管理'),
);


Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#type-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php if ($this->getUser()->checkAccess('Type.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/type/create') ?>">新增类型</a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'type-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'id',
        'name',
        'sort',
        array(
            'class' => 'CButtonColumn',
            'header' => '操作',
            'buttons' => array(
                'attr' => array(
                    'label' => '属性',
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("/attribute/admin",array("type_id"=>$data->id))',
                    'visible' => "Yii::app()->user->checkAccess('Attribute.Admin')"
                ),
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('Type.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Type.Delete')"
                ),
            ),
            'template' => '{update}{attr}{delete}',
            'updateButtonLabel' => '编辑',
            'updateButtonImageUrl' => false,
            'deleteButtonLabel' => '删除',
            'deleteButtonImageUrl' => false,
            'deleteConfirmation' => '删除数据这条数据下的所有属性数据也会删除,确认删除吗?', //自定义删除提示消息
        ),
    ),
));
?>
