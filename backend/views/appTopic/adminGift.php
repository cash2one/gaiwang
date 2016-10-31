<?php
/* @var $this AppHotCategoryController */
/* @var $model AppHotCategory */
$this->breadcrumbs = array(Yii::t('AppTopic', '主题') => array('admin'), Yii::t('AppTopic', '商务小礼'));
Yii::app()->clientScript->registerScript('search', "
$('#AppHotCategory-form').submit(function(){
	$('#AppTopic-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('AppTopic.Create')): ?>
    <a class="regm-sub" href="<?php echo $this->createAbsoluteUrl('/AppTopic/create/id/2') ?>"><?php echo Yii::t('AppTopic', '添加主题专题') ?></a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'AppTopic-grid',
    'dataProvider' => $model->search(AppTopic::BUSINESS_GIFT),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'headerHtmlOptions' => array('width' => '25%'),
            'name'=>'title',
            'value'=>'$data->title',
        ),
        array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'min_title',
            'value'=>'$data->min_title',
        ),
         array(
            'headerHtmlOptions' => array('width' => '10%'),
            'name'=>'sort',
            'value'=>'$data->sort',
        ),
        array(
            'headerHtmlOptions' => array('width' => '15%'),
            'name'=>'status',
            'value'=>'AppTopic::getPublish($data->status)',
        ),
        array(
            'headerHtmlOptions' => array('width' => '15%'),
            'name'=>'create_time',
            'value'=>'date("Y/m/d H:i:s", $data->create_time) ',
        ),
        array(
            'headerHtmlOptions' => array('width' => '15%'),
            'name'=>'update_time',
            'value'=>'date("Y/m/d H:i:s", $data->update_time) ',
        ),
      
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('AppTopic', '操作'),
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'visible' => "Yii::app()->user->checkAccess('AppTopic.Update')",
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                ),
                'delete' => array(
                    'label' => Yii::t('AppHotCategory', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('AppTopic.Delete')"
                ),
                'view' => array(
                    'visible' => 'false'
                )
            )
        )
    ),
));
?>

