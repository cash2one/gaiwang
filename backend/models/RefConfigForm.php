<?php
/**
 *  推荐商家会员配置 模型类
 *
 * @author zhenjun_xu <412530435@qq.com>
 */
class RefConfigForm extends CFormModel{
    
    public $introProportion;
    public $sellPercentage;
    
    /**
     * 验证规则
     * @return array
     */
    public function rules() {
        return array(
            array('introProportion,sellPercentage','required'),
            array('introProportion','numerical', 'integerOnly'=>true,'min'=>0,'message'=>Yii::t('home','{attribute} 需要是正整数')),
            array('sellPercentage','match','pattern'=>'/^(:?(:?\d+.\d+)|(:?\d+))$/','message'=>Yii::t('home','{attribute} 需要是正数')),
        );
    }
    

    public function attributeLabels() {
        return array(
            'introProportion'  => Yii::t('home','城市代理获得入驻金额'),
            'sellPercentage'  => Yii::t('home','推荐会员获得商家销售总额'),
        );
    }
    
}