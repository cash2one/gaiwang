<?php
/* @var $this SpecController */
/* @var $model Spec */

$this->breadcrumbs = array(
    Yii::t('spec', '商品规格管理 ') => array('admin'),
    Yii::t('spec', '规格管理'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#spec-grid').yiiGridView('update', {
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
<?php if ($this->getUser()->checkAccess('Spec.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/spec/create') ?>"><?php echo Yii::t('spec', '添加商品规格') ?></a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'spec-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        array(
            'name' => 'type',
            'value' => 'Spec::getTypeText($data->type)'
        ),
        'value',
        'sort',
        array(
            'class' => 'CButtonColumn',
            'buttons' => array(
                'specValue' => array(
                    'label' => Yii::t('spec', '规格值'),
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("/specValue/admin",array("spec_id"=>$data->id))',
                    'visible' => "Yii::app()->user->checkAccess('SpecValue.Admin')"
                ),
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => '($data->type!=Spec::TYPE_IMG && Yii::app()->user->checkAccess("Spec.Update")) ? true : false',
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => '($data->type!=Spec::TYPE_IMG && Yii::app()->user->checkAccess("Spec.Delete")) ? true : false',
                ),
            ),
            'template' => '{specValue}{update}{delete}',
            'updateButtonLabel' => Yii::t('spec', '编辑'),
            'updateButtonImageUrl' => false,
            'deleteButtonLabel' => Yii::t('spec', '删除'),
            'deleteButtonImageUrl' => false,
        )
    ),
));
?>
