<?php
/* @var $this AttributeController */
/* @var $model Attribute */
$type_id=isset($_GET['type_id'])?$_GET['type_id']:'';
$this->breadcrumbs = array(
	Yii::t('type', '商品类型') => array('type/admin'),
    Yii::t('attribute', '商品属性') => array("attribute/admin&type_id=$type_id"),
    Yii::t('attribute', '管理'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#attribute-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<?php if (Yii::app()->user->checkAccess('Attribute.Create')): ?>
    <input id="Btn_Add" type="button" value="增加属性" class="regm-sub" onclick="location.href = '<?php echo Yii::app()->createAbsoluteUrl("/attribute/create", array('type_id' => $model->type_id)); ?>'">
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'attribute-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        array(
            'name' => 'type_id',
            'value' => '$data->typename->name',
        ),
        array(
            'name' => 'show',
            'value' => 'Attribute::getType($data->show)',
        ),
        array(
            'class' => 'CButtonColumn',
            'buttons' => array(
                'attributevalue' => array(
                    'label' => Yii::t('attribute', '属性值'),
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("/attributeValue/admin",array("attr_id"=>$data->id))',
                    'visible' => "Yii::app()->user->checkAccess('AttributeValue.Admin')"
                ),
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('Attribute.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Attribute.Delete')"
                ),
            ),
            'template' => '{update}{attributevalue}{delete}',
            'updateButtonLabel' => Yii::t('attribute', '编辑'),
            'updateButtonImageUrl' => false,
            'deleteButtonLabel' => Yii::t('attribute', '删除'),
            'deleteButtonImageUrl' => false,
        ),
    ),
));
?>
