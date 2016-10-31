<?php

/* @var $this EnterpriseController */
/* @var $model Enterprise */
$this->breadcrumbs = array(Yii::t('enterprise', '开店管理') => array('storeAdmin'), Yii::t('enterprise', '列表'));

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
<script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
<?php $this->renderPartial('_storesearch', array('model' => $model)); ?>


<?php
$this->widget('GridView', array(
    'id' => 'enterprise-grid',
    'dataProvider' => $model->searchStore(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'ajaxUpdate' => false,
    'filter'=>$model,
    'columns' => array(
		array(
            'name' => Yii::t('enterprise', '更新时间'),
            'value' => 'empty($data->au_time)?date("Y-m-d G:i:s",$data->create_time):date("Y-m-d G:i:s",$data->au_time)',
            'filter'=>false,
        ),
        array(
            'name'=>'store_name',
            'filter'=>false,
        ),
        array(
            'name'=>'enterprise_type',
            'value'=>'Enterprise::getEnterpriseType($data->enterprise_type)',
            'filter'=>false,
        ),
        array(
            'name'=>Yii::t('enterprise','经营类目'),
            'value'=>'$data->cat_name',
            'filter'=>false,
        ),
        array(
            'name'=>'开店模式',
            'value'=>'Store::getMode($data->mode)',
            'filter'=>false,

        ),
        array(
            'name' => 'store_status',
            'value' => 'Store::status($data->store_status)',
            'filter'=>Store::status(),
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{openStore}{closeStore}{progress}',
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'openStore' => array(
                    'label' => Yii::t('enterprise', '开店'),
                	'url'	=>'Yii::app()->createUrl("enterprise/storeOpen", array("id"=>$data->id))',
                    'visible' => '!in_array($data->store_status,array(Store::STATUS_PASS,Store::STATUS_ON_TRIAL))  and '."Yii::app()->user->checkAccess('Enterprise.StoreOpen')",
                    'options' => array(
                        'class' => 'regm-sub-a',
                        'onclick' => 'return confirm("' . Yii::t('member', '确认为商家开店?') . '")',
                    )
                ),
                'closeStore' => array(
                    'label' => Yii::t('enterprise', '关店'),
                    'url'	=>'Yii::app()->createUrl("enterprise/storeClose", array("id"=>$data->id))',
                    'visible' => 'in_array($data->store_status,array(Store::STATUS_PASS,Store::STATUS_ON_TRIAL)) and '."Yii::app()->user->checkAccess('Enterprise.StoreClose')",
                    'options' => array(
                        'class' => 'regm-sub-a',
                        'onclick' => 'return confirm("' . Yii::t('member', '确认关闭商家店铺?') . '")',
                    )
                ),
                'progress' => array(
                    'label' => Yii::t('enterprise', '网店记录'),
                	'url'	=>'Yii::app()->createUrl("enterprise/progress", array("id"=>$data->id))',
                    'visible' => "Yii::app()->user->checkAccess('Enterprise.Progress')",
                    'options' => array(
                        'class' => 'regm-sub-a',
                		'act'=>'openProgress',
                    )
                ),
            )
        )
    ),
));
?>
<script  type="text/javascript">
var dialog = null;
$("a[act='openProgress']").click(function() {
        dialog = art.dialog.open($(this).attr('href'), { 'id': 'progress', title: '查看详情', width: '90%', height: '80%', lock: true });
        return false;
    });

</script>
