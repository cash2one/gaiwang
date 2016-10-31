<?php

/* @var $this StoreController */
/* @var $model Store */
$this->breadcrumbs = array(Yii::t('store', '店铺') => array('admin'), Yii::t('store', '列表'));
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#store-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php
//var_dump($model->search()->getData());
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php
$this->widget('GridView', array(
    'id' => 'store-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'member_id',
            'value' => '$data->member->gai_number'
        ),
        'name',
        'mobile',
        array(
            'name' => 'status',
            'value' => 'Store::status($data->status)'
        ),
        array(
            'name' => 'create_time',
            'value' => 'date("Y/m/d H:i:s", $data->create_time)'
        ),
        array(
            'name' => 'referrals_id',
            'value' => '$data->referrals_id ? (isset($data->referrals) ? $data->referrals->gai_number." | ". $data->referrals->username : "") : ""'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{updateRecommend}{pass}{reviewLog}',
            'header' => Yii::t('home', '操作'),
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'visible' => "Yii::app()->user->checkAccess('Store.Update')"
                ),
                'updateRecommend' => array(
                    'label' => Yii::t('store', '设推荐人'),
                    'url' => 'Yii::app()->createUrl("store/updateRecommend",array("id"=>$data->id))',
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                    'visible' => 'Yii::app()->user->checkAccess("Store.UpdateRecommend")',
                ),
                'pass' => array(
                    'label' => Yii::t('store', '审核通过'),
                    'url' => 'Yii::app()->createUrl("store/updateStatusPass",array("id"=>$data->id))',
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                    'visible' => "Yii::app()->user->checkAccess('Store.Update')"
                ),
                'reviewLog' => array(
                    'label' => Yii::t('store', '审核日志'),
                    'url' => 'Yii::app()->createUrl("store/reviewLog",array("id"=>$data->id))',
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                    'visible' => 'Yii::app()->user->checkAccess("Store.Update")',
                ),
            )
        ),
    ),
));
?>