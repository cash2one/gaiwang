<?php
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'product-grid',
    'dataProvider' => $model,
    'title'=>'参与活动商品列表',
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'name'=> 'product_name',
            'value'=>'$data->product_name',
            'type'=>'raw',
        ),
        array(
            'name'=>  Yii::t('seckillRulesSetting','原价'),
            'value' => 'Product::getGoodsPrice($data->product_id)',
            'type' => 'raw'
        ),
        array(
            'name' => Yii::t('seckillRulesSetting','活动价'),
            'value' => 'Product::getGoodsActivePrice($data)',
            'type' => 'raw'
        ),
        array(
            'name'=>  Yii::t('seckillRulesSetting','链接'),
            'value' => 'DOMAIN."/JF/".$data->product_id.".html"',
            'type'=>'raw'
        )
//        array()
    ),
));
?>