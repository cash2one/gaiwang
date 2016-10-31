<?php $this->breadcrumbs = array(Yii::t('repairs', '电话报修') => array('admin'), Yii::t('repairs', '列表')); ?>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#repairs-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'repairs-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
		'merchant',
		'address',
		'mobile',
		array('name' => 'status', 'value' =>'Repairs::showStatus($data->status)'),
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
            'deleteConfirmation' => Yii::t('Repairs', '确认删除'),
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '查看'),
                    'visible' => "Yii::app()->user->checkAccess('Repairs.Update')"
                ),
                /*'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Repairs.Delete')"
                ),*/
            )
        )
    ),
));
?>