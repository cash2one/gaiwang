<?php
/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */

$this->breadcrumbs = array(
    Yii::t('prepaidCard', '积分返还充值卡') => array('index'),
    Yii::t('prepaidCard', '列表')
);
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#prepaid-card-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('PrepaidCard.CreateGeneral')): ?>
    <input id="Btn_Add" type="button" value="<?php echo Yii::t('prepaidCard', '添加返还卡'); ?>" class="regm-sub" onclick="location.href = '<?php echo Yii::app()->createAbsoluteUrl("/prepaidCard/createGeneral"); ?>'">
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'prepaid-card-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'number',
        array(
            'name' => 'value',
            'value' => 'PrepaidCard::showScore($data->value)',
            'type' => 'raw'
        ),
        array(
            'name' => 'owner_id',
            'value' => '$data->owner_id ? $data->owner->gai_number : ""'
        ),
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:is", $data->create_time)'
        ),
        'author_name',
        array(
            'name' => 'status',
            'value' => 'PrepaidCard::showStatus($data->status)'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{delete}',
            'viewButtonLabel' => Yii::t('prepaidCard', '查看'),
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'view' => array(
                    'label' => Yii::t('prepaidCard', '查看'),
        			'url'=>'Yii::app()->createUrl("prepaid-card/view",array("id"=>"$data->id","action"=>"index"),"&")',
                    'imageUrl' => false,
                    'visible' => "Yii::app()->user->checkAccess('PrepaidCard.View')"
                ),
                'delete' => array(
                    'label' => Yii::t('prepaidCard', '删除'),
                    'imageUrl' => false,
                    'visible' => 'Yii::app()->user->checkAccess("PrepaidCard.Delete") && ($data->status == PrepaidCard::STATUS_UNUSED)'
                )
            )
        ),
    ),
));
?>
