<?php
/* @var $this AppTopicLifeController */
/* @var $model AppTopicLife */

$this->breadcrumbs = array(

    Yii::t('AppTopicCar', '臻至生活审核列表'),  Yii::t('AppTopicCar', '列表'));

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#app-topic-life-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->renderPartial('_search', array('model' => $model)); ?>


<?php $this->widget('GridView', array(
	'id'=>'app-topic-life-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
	'columns'=>array(
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'rele_time',
            'value'=>'date("Y/m/d H:i:s", $data->rele_time) ',
        ),
        array(
            'headerHtmlOptions' => array('width' => '15%'),
            'name'=>'title',
            'value'=>'$data->title',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'audit_status',
            'value'=>'AppTopicLife::getAuditStatus($data->audit_status)',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('AppTopicCar', '话题及评论审核'),
            'headerHtmlOptions' => array('width' => '15%'),
            'viewButtonImageUrl' => false,
            'template' =>'{AppTopicLifeTopicsAndComments}',
            'buttons' => array(
                'AppTopicLifeTopicsAndComments' => array(
                    'label' => Yii::t('AppTopicCar', '查看'),
                    'url'=>'Yii::app()->createUrl("AppTopicProblem/admin",array("life_topic_id"=>$data->id))',
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");')
                ),
            )
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('AppTopicCar', '操作'),
            'headerHtmlOptions' => array('width' => '15%'),
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'template' => '{audit}',
            'buttons' => array(
                'audit' => array(
                    'label' => Yii::t('AppTopicLife', '审核'),
                    'visible' => "Yii::app()->user->checkAccess('AppTopicLife.AuditTopics')",
                    'url' => 'Yii::app()->createUrl("AppTopicLife/AuditTopics",array("id"=>$data->id))'
                ),
            )
        )
	),
)); ?>
