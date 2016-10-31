<?php
/* @var $this KeywordController */
/* @var $model Keyword */ 
$this->breadcrumbs = array(
    Yii::t('feedback', '用户反馈管理') => array('admin'),
    Yii::t('feedback', '用户反馈列表'),
);

?>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#feedback-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>

<?php $this->renderPartial('_search', array('model' => $model,));?>

<div class="c10"></div>

<?php
$this->widget('GridView', array(
    'id' => 'feedback-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'gai_number',
         array(
            'name' => 'content',
            'value' => 'Tool::truncateUtf8String($data->content,50, "...")',
        ),   
        'username',        
        'mobile',
        array(
            'name' => 'created',
            'value' => 'date("Y-m-d H:i:s",$data->created)',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{view}{delete}',
            'deleteButtonImageUrl' => false,
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'view' => array(
                    'label' => Yii::t('user', '查看'),
                    'visible' => "Yii::app()->user->checkAccess('Feedback.View')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Feedback.Delete')"
                ),
            )
        )
    ),
));
?>
