<?php
/* @var $this AppHomePictureController */

$this->breadcrumbs=array(
	Yii::t('AppBrands', '品牌馆'),
	Yii::t('AppBrands', '品牌馆专题列表')=> array('AppBrands/admin'),
);

Yii::app()->clientScript->registerScript('search', "
$('#AppBrands-form').submit(function(){
	$('#AppBrands-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 $this->renderPartial('_search',array('model'=>$model));
 ?>
 <?php if (Yii::app()->user->checkAccess('AppBrands.Create')): ?>
    <a class="regm-sub" href="<?php  echo Yii::app()->createAbsoluteUrl('/AppBrands/create') ?>">添加专题</a> 
<!--       <button class="regm-sub" id="reset">添加欢迎页</button> -->
 <?php endif; ?>
 <?php
$this->widget('GridView', array(
		'id' => 'AppBrands-grid',
		'dataProvider' => $model->search(),
		'cssFile' => false,
		'itemsCssClass' => 'tab-reg',
		'columns' => array(
				'id',
				'title',
				 array(
		           // 'headerHtmlOptions' => array('width' => '10%'),
		            'name'=>'status',
		            'value'=>'AppBrands::getPublish($data->status)',
		        ),
				array(
					//'headerHtmlOptions' => array('width' => '10%'),
					'name'=>'create_time',
					'value'=>'date("Y/m/d H:i:s", $data->create_time) ',
				),
				'sort',
				array(
						'class' => 'CButtonColumn',
						'header' => Yii::t('home', '操作'),
						'template' => '{update}{delete}{goods}',
						'updateButtonImageUrl' => false,
						'deleteButtonImageUrl' => false,
						'buttons' => array(
								'update' => array(
									'label' => Yii::t('user', '编辑'),
									'visible' => "Yii::app()->user->checkAccess('AppBrands.Update')"
								),
								'delete'=>array(
									'label' => Yii::t('user', '删除'),
									'visible' => "Yii::app()->user->checkAccess('AppBrands.Delete')"
							    ),
								'goods'=>array(
									'label'	=>Yii::t('AppBrands','商品'),
									'url'=>'Yii::app()->createUrl("AppBrandsGoods/Admin",array("brands_id"=>$data->id))',
									'visible' => "Yii::app()->user->checkAccess('AppBrandsGoods.Admin')"
								),
						)
				)
		),
));
?>


