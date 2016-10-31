<?php
/* @var $this AppHomePictureController */

$this->breadcrumbs=array(
	Yii::t('AppHomePicture', '主题'),
	Yii::t('AppHomePicture', '欢迎页列表')=> array('AppHomePicture/admin'),
);

Yii::app()->clientScript->registerScript('search', "
$('#AppHomePicture-form').submit(function(){
	$('#AppHomePicture-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 $this->renderPartial('_search',array('model'=>$model));
 ?>
 <?php if (Yii::app()->user->checkAccess('AppHomePicture.Create')): ?>
    <a class="regm-sub" href="<?php  echo Yii::app()->createAbsoluteUrl('/appHomePicture/create') ?>">添加欢迎页</a> 
<!--       <button class="regm-sub" id="reset">添加欢迎页</button> -->
 <?php endif; ?>
 <?php
$this->widget('GridView', array(
		'id' => 'apphomepicture-grid',
		'dataProvider' => $model->search(),
		'cssFile' => false,
		'itemsCssClass' => 'tab-reg',
		'columns' => array(
				'id',
				'title',
				 array(
		           // 'headerHtmlOptions' => array('width' => '10%'),
		            'name'=>'start_time',
		            'value'=>'date("Y/m/d H:i:s", $data->start_time) ',
       			 ),
				 array(
		           // 'headerHtmlOptions' => array('width' => '20%'),
		            'name'=>'end_time',
		            'value'=>'date("Y/m/d H:i:s", $data->end_time) ',
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
									'visible' => "Yii::app()->user->checkAccess('AppHomePicture.Update')"
								),
								'delete'=>array(
									'label' => Yii::t('user', '删除'),
									'visible' => "Yii::app()->user->checkAccess('AppHomePicture.Delete')"
							    ),
						)
				)
		),
));
?>


