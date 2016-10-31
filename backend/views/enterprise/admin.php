<?php

/* @var $this EnterpriseController */
/* @var $model Enterprise */
$this->breadcrumbs = array(Yii::t('enterprise', '企业信息') => array('admin'), Yii::t('enterprise', '列表'));

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#enterprise-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php

$this->widget('GridView', array(
    'id' => 'enterprise-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'name',
        'link_man',
        'mobile',
        array(
            'name' => 'auditing',
            'value' => 'Enterprise::auditingArr($data->auditing)'
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{view}{progress}',
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'view' => array(
                    'label' => Yii::t('enterprise', '查看详情'),
                    'visible' => "Yii::app()->user->checkAccess('Enterprise.View')",
                    'options' => array(
                        'class' => 'regm-sub-a',
                    )
                ),
                'progress' => array(
                    'label' => Yii::t('enterprise', '审核进度'),
                    'visible' => "Yii::app()->user->checkAccess('Enterprise.progress')",
                    'options' => array(
                        'class' => 'regm-sub-a',
                    )
                ),
            )
        )
    ),
));
?>
