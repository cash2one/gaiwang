<?php

/**
 *  积分兑现配置 模型
 *
 * @author zhenjun_xu <412530435@qq.com>
 */
class CreditsConfigForm  extends CFormModel{
    
    public $scoreCashUnit;
    public $scoreCashFactorage;
    
    public function rules(){
        return array(
            array('scoreCashUnit,scoreCashFactorage','required'),
            array('scoreCashUnit','numerical', 'integerOnly'=>true,'min'=>0,'message'=>Yii::t('home','{attribute} 需要是正整数')),
            array('scoreCashFactorage','match','pattern'=>'/^(:?(:?\d+.\d+)|(:?\d+))$/','message'=>Yii::t('home','{attribute} 需要是正数')),
        );
    }
    
    public function attributeLabels(){
       return array(
           'scoreCashUnit' => Yii::t('home','会员积分兑现倍数'),
           'scoreCashFactorage' => Yii::t('home','会员积分兑现手续费'),
       ); 
    }
}