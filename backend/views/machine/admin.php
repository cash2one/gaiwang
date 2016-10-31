<?php

/* @var $this MachineController */
/* @var $model Machine */

$this->breadcrumbs = array(
    Yii::t('machine', '加盟商管理 ') => array('admin'),
    Yii::t('machine', '盖机列表'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
//	$('#machine-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
});
");
?>

<?php

$this->renderPartial('_search', array(
    'model' => $model,
));
?>
<style>
td.button-column a.regm-sub-b {
    font-family: "微软雅黑";
    line-height: 27px;
    background: url(../images/sub-fou.gif) no-repeat;
    height: 27px;
    width: 83px;
    text-align: center;
    color: #FFF;
    border: 0;
    display: inline-block;
}
</style>
<?php
$this->widget('GridView', array(
    'id' => 'machine-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        array(
            'name' => Yii::t('machine', '盖网通地区'),
            'value' => 'Region::getName($data->province_id, $data->city_id, $data->district_id)',
        ),
        'biz_name',
        'intro_member_id',
     	array(
    		'name' =>  Yii::t('machine', '状态'),
     		'value' => '($data->status == 1) ? "已激活":"未激活" ',
     	),
        array(
            'class' => 'CButtonColumn',
            'deleteConfirmation' => Yii::t('machine', '你确定要移除此推荐者吗？ '),
            'header' => Yii::t('machine', '操作'),
        	'template' => '{update}{Distribution}',
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('machine', '编辑绑定'),
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("/machine/create",array("id"=>$data->id))',
                    'visible' => "Yii::app()->user->checkAccess('Machine.Create')",
                    'options' => array(
                        'class' => 'regm-sub-b',
                    )
                ),
            	 'Distribution' => array(
            		'label' => Yii::t('machine', '收益分配'),
            		'imageUrl' => false,
            		'url'=>'Yii::app()->controller->createUrl("/machine/Distribution",array("id"=>$data->id))',
            		'visible' => "Yii::app()->user->checkAccess('Machine.Distribution')",
            		'options' => array(
            				'class' => 'regm-sub-b',
            		)
            	), 
            ),
        ),
    ),
));
?>

<?php 
	$this->renderPartial('/layouts/_export', array(
	    'model' => $model,'exportPage' => $exportPage,'totalCount'=>$totalCount,
	));
?>
