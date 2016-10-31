<?php

$attr_id=isset($_GET['attr_id'])?$_GET['attr_id']:'';
$type_id=$model->attrName->type_id;
$this->breadcrumbs = array(
	Yii::t('type', '商品类型') => array('type/admin'),
    Yii::t('attribute', '商品属性') => array("attribute/admin&type_id=$type_id"),
    Yii::t('attributeValue', '商品属性值') => array("attribute-value/admin&attr_id=$attr_id"),
    Yii::t('attributeValue', '管理'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#attribute-value-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php if (Yii::app()->user->checkAccess('AttributeValue.Create')): ?>
    <input id="Btn_Add" type="button" value="增加属性值" class="regm-sub" onclick="location.href = '<?php echo Yii::app()->createAbsoluteUrl("/attributeValue/create", array('attr_id' => $model->attribute_id)); ?>'">
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'attribute-value-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        array(
            'name' => 'attribute_id',
            'value' => '$data->attrName->name',
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
                    'visible' => "Yii::app()->user->checkAccess('AttributeValue.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('AttributeValue.Delete')"
                ),
            )
        )
    ),
));
?>
