<?php
/* @var $this AppTopicProblemController */
/* @var $model AppTopicProblem */

$this->breadcrumbs = array(
    Yii::t('AppTopicProblem', '查看评论'),
    Yii::t('AppTopicProblem', '回复者')
);


Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#app-topic-problem-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->widget('GridView', array(
    'id'=>'app-topic-problem-grid',
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'dataProvider'=>$model->search(),
    'columns'=>array(
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'name',
            'value'=>'$data->name',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'create_time',
            'value'=>'date("Y/m/d H:i:s", $data->create_time) ',
        ),
        array(
            'headerHtmlOptions' => array('width'=>'30%'),
            'name'=>'problem',
            'value'=>'mb_convert_encoding(rawurldecode($data->problem), "UTF-8","auto")',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('AppTopicCar', '操作'),
            'headerHtmlOptions' => array('width' => '20%'),
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'template' => '{update}{delete}',
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('AppTopicProblem', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('AppTopicProblem.UpdateReplyPeople')",
                    'url' => 'Yii::app()->createUrl("AppTopicProblem/UpdateReplyPeople",array("id"=>$data->id,"life_topic_id"=>$data->life_topic_id,"parent_id"=>$data->parent_id))',
                ),
                'delete' => array(
                    'label' => Yii::t('AppTopicProblem', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('AppTopicProblem.Delete')",
                    'url' => 'Yii::app()->createUrl("AppTopicProblem/Delete",array("id"=>$data->id))',
                ),

            )
        )
    ),
)); ?>