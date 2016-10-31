<?php
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'product-grid',
	'title'=>'积分日志',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'header' => Yii::t('wealth', '拥有者'),
            'value' => '$data->gai_number',
            'type' => 'raw',
        ),
        array(
            'name' => Yii::t('wealth', '拥有者类型'),
            'value' => 'Wealth::getOwner($data->owner)' 
        ),
        array(
            'name' => Yii::t('wealth', '收入类型'),
            'value' => 'Wealth::showType($data->type_id)'
        ),
        array(
            'type' => 'raw',
            'name' => Yii::t('wealth', '积分'),
            'value' => '$data->score'
        ),
        array(
            'type' => 'raw',
            'name' => Yii::t('wealth', '金额'),
            'value' => '$data->money'
        ),
        array(
            'name' => Yii::t('wealth', '积分来源'),
            'value' => 'Wealth::showSource($data->source_id)'
        ),
        array(
            'name' => Yii::t('wealth', '状态'),
            'type' => 'raw',
            'value' => 'Wealth::getStatus($data->status)'
        ),
        array(
            'name' => Yii::t('wealth', '创建时间'),
            'type' => 'raw',
            'value' => 'date("Y-m-d G:i:s",$data->create_time)'
        ),
        array(
            'name' => Yii::t('wealth', '备注'),
            'type' => 'raw',
            'value' => '$data->content'
        ),
    ),
));
?>