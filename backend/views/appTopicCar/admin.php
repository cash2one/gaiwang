<?php
/* @var $this AppTopicCarController */
/* @var $model AppTopicCar */

$this->breadcrumbs = array(
		Yii::t('AppTopicCar', '主题'),
		 Yii::t('AppTopicCar', '新动'));
Yii::app()->clientScript->registerScript('search', "
$('#AppTopicCar-form').submit(function(){
	$('#AppTopicCar-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('AppTopicCar.Create')): ?>
    <a class="regm-sub" href="<?php echo $this->createAbsoluteUrl('/AppTopicCar/create/') ?>"><?php echo Yii::t('AppTopic', '添加新动专题') ?></a>
<?php  endif; ?>
<div class="c10"></div>

<?php $this->widget('GridView', array(
    'id' => 'AppTopicCar-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'headerHtmlOptions' => array('width' => '20%'),
            'name'=>'title',
            'value'=>'$data->title',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'create_time',
            'value'=>'date("Y/m/d H:i:s", $data->create_time) ',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'status',
            'value'=>'AppTopicCar::getPublish($data->status)',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'author',
            'value'=>'$data->author',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('AppTopicCar', '专题评论'),
            'headerHtmlOptions' => array('width' => '10%'),
            'viewButtonImageUrl' => false,
            'template' =>'{AppTopicCarComment}',
            'buttons' => array(
                'AppTopicCarComment' => array(
                    'label' => Yii::t('AppTopicCar', '查看评论'),
                	'visible' => "Yii::app()->user->checkAccess('AppTopicCarComment.Admin')",
                    'url'=>'Yii::app()->createUrl("AppTopicCarComment/Admin",array("topic_id"=>$data->id))',
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");')
                ),
            )
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('AppTopicCar', '操作'),
            'headerHtmlOptions' => array('width' => '10%'),
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'template' => '{update}{delete}',
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('AppTopicCar', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('AppTopicCar.Update')",
                   'url' => 'Yii::app()->createUrl("AppTopicCar/Update",array("id"=>$data->id))',
                ),
                'delete' => array(
                    'label' => Yii::t('AppTopicCar', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('AppTopicCar.Delete')",
                	'url' => 'Yii::app()->createUrl("AppTopicCar/Delete",array("id"=>$data->id))',
                ),
            )
        )
    ),
)); ?>
