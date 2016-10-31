<?php

/**
 * OrderConfigForm设置模型类
 * @author csj
 */
class OrderConfigForm extends CFormModel{
    public $stock_time;
    public $specialGoods;
    public $hyjGoods;
    public $payJfRatio;
    public $shopId_13_14;
    
    public function rules(){
        return array(
            array('stock_time','required'),
            array('stock_time,specialGoods,payJfRatio,hyjGoods,shopId_13_14','safe'),
        );
    }
    
    public function attributeLabels(){
        return array(
            'stock_time' => Yii::t('home','下单暂减库存保留时间（s）'),
            'specialGoods' => Yii::t('home','特殊商品(只能使用部分积分支付)'),
            'hyjGoods' => Yii::t('home','合约机商品'),
            'payJfRatio' => Yii::t('home','特殊商品使用积分支付比例'),
            'shopId_13_14' => Yii::t('home','13/14活动商家ID'),
        );
    }
}
?>
