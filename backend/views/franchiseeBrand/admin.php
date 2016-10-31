<?php
/* @var $this FranchiseeBrandController */
/* @var $model FranchiseeBrand */

$this->breadcrumbs = array(
    Yii::t('', '加盟商管理') => array('admin'),
    Yii::t('', '加盟商品牌'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#franchisee-brand-grid').yiiGridView('update', {
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
<?php if (Yii::app()->user->checkAccess('FranchiseeBrand.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/franchiseeBrand/create') ?>"><?php echo Yii::t('franchisee', '添加品牌') ?></a>
<?php endif; ?>
<style>
    td.button-column a.regm-sub-b {
        font-family: "微软雅黑";
        line-height: 27px;
        background: url(../images/sub-fou.gif) no-repeat;
        height: 27px;
        width: 83px;
        text-align: center;
        color: #FFF;
        border: 0;
        display: inline-block;
    }
</style>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'franchisee-brand-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
//	'filter'=>$model,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
//		'id',
//		'name',
        array(
            'name' => 'name',
            'value' => '$data->name',
            'htmlOptions' => array('width' => '35%'),
        ),
        array(
            'name' => 'pinyin',
            'value' => '$data->pinyin',
            'htmlOptions' => array('width' => '35%'),
        ),
        array(
            'class' => 'CButtonColumn',
            'deleteConfirmation' => Yii::t('machine', '你确定要删除该品牌吗？ '),
            'header' => Yii::t('machine', '操作'),
            'template' => '{update} {delete}',
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('machine', '编辑'),
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("/franchiseeBrand/update",array("id"=>$data->id))',
                    'visible' => "Yii::app()->user->checkAccess('FranchiseeBrand.Update')",
                    'options' => array(
                        'class' => 'regm-sub-b',
                    )
                ),
                'delete' => array(
                    'label' => Yii::t('machine', '删除'),
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("/franchiseeBrand/delete",array("id"=>$data->id))',
                    'visible' => '$data->id && Yii::app()->user->checkAccess("franchiseeBrand.Delete")',
                    'options' => array(
                        'class' => 'regm-sub-a',
                    ),
                ),
            ),
        ),
    ),
));
?>
