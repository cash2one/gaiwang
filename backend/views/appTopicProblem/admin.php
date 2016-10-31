<?php
/* @var $this AppTopicProblemController */
/* @var $model AppTopicProblem */

$this->breadcrumbs = array(
    Yii::t('AppTopicProblem', '臻至生活审核列表')=> array('AppTopicLife/admin'),
    Yii::t('AppTopicProblem', '查看回复')
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

<?php  $this->renderPartial('_search', array('model' => $model)); ?>

<?php $this->widget('GridView', array(
	'id'=>'app-topic-problem-grid',
	'dataProvider'=>$model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
	'columns'=>array(

        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'name',
            'value'=>'AppTopicProblem::getMemberName($data->member_id)',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'create_time',
            'value'=>'date("Y/m/d H:i:s", $data->create_time) ',
        ),
        array(
            'headerHtmlOptions' => array('width'=>'30%'),
            'name'=>'problem',
            'value'=>'AppTopicProblem::filteredProblem(mb_convert_encoding(rawurldecode($data->problem), "UTF-8","auto"))',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('AppTopicCar', '操作'),
            'headerHtmlOptions' => array('width' => '20%'),
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'template' => '{update}{delete}{comment}',
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('AppTopicProblem', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('AppTopicProblem.Update')",
                    'url' => 'Yii::app()->createUrl("AppTopicProblem/Update",array("id"=>$data->id,"life_topic_id"=>$data->life_topic_id))'
                ),
                'delete' => array(
                    'label' => Yii::t('AppTopicProblem', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('AppTopicProblem.Delete')",
                    'url' => 'Yii::app()->createUrl("AppTopicProblem/Delete",array("id"=>$data->id))',
                ),
                'comment' => array(
                    'label' => Yii::t('AppTopicProblem', '回复者'),
                    'visible' => "Yii::app()->user->checkAccess('AppTopicProblem.ReplyPeople')",
                    'url' => 'Yii::app()->createUrl("AppTopicProblem/ReplyPeople",array("parent_id"=>$data->id))',
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");')
                ),
            )
        )
	),
)); ?>
