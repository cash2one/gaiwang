<?php
/* @var $this SpecialTopicController */
/* @var $model SpecialTopic */

$this->breadcrumbs = array(
    '专题管理' => array('admin'),
    '专题列表',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#special-topic-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<div class="c10"></div>
<?php if ($this->getUser()->checkAccess('specialTopic.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/specialTopic/create') ?>"><?php echo Yii::t('specialTopic', '添加专题'); ?></a>
    <div class="c10"></div>
<?php endif; ?>
<?php
$this->widget('GridView', array(
    'id' => 'special-topic-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'name',
        'summary',
        'views',
        array(
            'type' => 'datetime',
            'name' => 'start_time',
            'value' => '$data->start_time'
        ),
        array(
            'type' => 'datetime',
            'name' => 'end_time',
            'value' => '$data->end_time'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}{viewCategory}{welfare}{seckill}',
            'header' => Yii::t('home', '操作'),
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'htmlOptions' => array('class' => 'tc'),
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('specialTopic', '【编辑】'),
                    'visible' => "Yii::app()->user->checkAccess('SpecialTopic.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('specialTopic', '【删除】'),
                    'visible' => "Yii::app()->user->checkAccess('SpecialTopic.Delete')"
                ),
                'viewCategory' => array(
                    'label' => Yii::t('specialTopic', '【查看分类】'),
                    'url' => 'Yii::app()->createAbsoluteUrl("/specialTopicCategory/admin", array("specialId" => $data->primaryKey))',
                    'visible' => "Yii::app()->user->checkAccess('SpecialTopicCategory.Admin')"
                ),
                'welfare' => array(
                    'label' => Yii::t('specialTopic', '【红包管理】'),
//                    'url' => 'Yii::app()->createAbsoluteUrl("/specialTopic/welfare", array("id" => $data->primaryKey))',
                    'visible' => "Yii::app()->user->checkAccess('SpecialTopic.Welfare')"
                ),
                'seckill' => array(
                    'label' => Yii::t('specialTopic', '【秒杀活动管理】'),
//                    'url' => 'Yii::app()->createAbsoluteUrl("/specialTopic/seckill", array("id" => $data->primaryKey))',
                    'options' => array('class' => 'view'),
                    'visible' => "Yii::app()->user->checkAccess('SpecialTopic.Seckill')"
                ),
            ),
        ),
    ),
));
?>
