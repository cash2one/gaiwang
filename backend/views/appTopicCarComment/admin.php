<?php
/* @var $this AppTopicCarCommentController */
/* @var $model AppTopicCarComment */

$this->breadcrumbs = array(
    Yii::t('AppTopicCarComment', '新动')=> array('AppTopicCar/admin'),
    Yii::t('AppTopicCarComment', '查看评论')
);


Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#app-topic-car-comment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->renderPartial('_search', array('model' => $model)); ?>
<!-- search-form -->

<?php $this->widget('GridView', array(
    'id'=>'app-topic-car-comment-grid',
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
            'name'=>'content',
            'value'=>'AppTopicProblem::filteredProblem(mb_convert_encoding(rawurldecode($data->content), "UTF-8","auto"))',
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
                    'label' => Yii::t('AppTopicCarComment', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('AppTopicCarComment.Update')",
                    'url' => 'Yii::app()->createUrl("AppTopicCarComment/Update",array("id"=>$data->id,"topic_id"=>$data->topic_id))',
                ),
                'delete' => array(
                    'label' => Yii::t('AppTopicCarComment', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('AppTopicCarComment.Delete')",
                    'url' => 'Yii::app()->createUrl("AppTopicCarComment/Delete",array("id"=>$data->id))',
                ),
                'comment' => array(
                    'label' => Yii::t('AppTopicCarComment', '回复者'),
                    'visible' => "Yii::app()->user->checkAccess('AppTopicCarComment.ReplyPeople')",
                    'url' => 'Yii::app()->createUrl("AppTopicCarComment/ReplyPeople",array("parent_id"=>$data->id,"topic_id"=>$data->topic_id))',
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");')
                ),
            )
        )
    ),
)); ?>


