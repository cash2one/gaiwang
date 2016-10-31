<?php

/* @var $this FranchiseeArtileController */
/* @var $model FranchiseeArtile */

$this->breadcrumbs = array(
    Yii::t('offlineSignMachineBelong', '加盟商管理 ') => array('admin'),
    Yii::t('offlineSignMachineBelong', '归属方信息列表'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#offline-sign-machine-belong-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('OfflineSignMachineBelong.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('offline-sign-machine-belong/create') ?>"><?php echo Yii::t('OfflineSignMachineBelong', '新增归属方') ?></a>
<?php endif; ?>

<?php

$this->widget('GridView', array(
    'id' => 'offline-sign-machine-belong-grid',
    'dataProvider' => $model->search(),
    // 'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
			'htmlOptions' => array('class' => 'tc'),
			'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '100px'),
			'name' => 'create_time',
			'value' => 'date("Y-m-d H:i:s",$data->create_time)',
		),
		array(
			'htmlOptions' => array('class' => 'tc'),
			'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '150px'),
			'name' => 'belong_to',
			// 'value' => '$data->enterprise_name',
		),
		array(
			'htmlOptions' => array('class' => 'tc'),
			'headerHtmlOptions' => array('class' => 'tabletd tc','width' => '80px'),
			'name' => 'number',
			// 'value' => 'OfflineSignStore::getApplyType($data->apply_type)',
		),
		array(
			'class'=>'CButtonColumn',
            'updateButtonImageUrl' => true,
            // 'deleteButtonImageUrl' => false,
			'header' => Yii::t('Public','操作'),
			'template'=>'{update}',
			'buttons'=>array(
                'update'=>array(
                    'label' => Yii::t('OfflineSignStore','编辑'),
                    'visible' => 'Yii::app()->user->checkAccess("OfflineSignMachineBelong.Update")',
                    'url' => 'Yii::app()->controller->createUrl("offlineSignMachineBelong/update", array("id"=>$data->id))',
                    'imageUrl' => false
                ),
			),
		),
    ),
));
?>
