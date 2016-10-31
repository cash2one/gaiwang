<?php $this->breadcrumbs = array(Yii::t('complaint', '投诉建议') => array('admin'), Yii::t('complaint', '列表')); ?>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#complaint-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'complaint-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
		'linkman',
		'mobile',
		array('name' => 'source', 'value' =>'Complaint::showSource($data->source)'),
    	array(
    		  'name' => 'create_time',
    		  'value' => '$data->create_time ? date("Y-m-d", $data->create_time) : ""'
    		),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'deleteConfirmation' => Yii::t('Complaint', '确认删除'),
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '查看'),
                    'visible' => "Yii::app()->user->checkAccess('Complaint.Update')"
                ),
                /*'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Complaint.Delete')"
                ),*/
            )
        )
    ),
));
?>