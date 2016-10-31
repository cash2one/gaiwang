<?php
/**
 *  企业会员提现配置 模型类
 *
 * @author zhenjun_xu <412530435@qq.com>
 */
class ShopCashConfigForm extends CFormModel{
    
    public $applyCashUnit;
    public $applyCashFactorage;
    public $applyCashGwnumbers;
    
    /**
     * 验证规则
     * @return array
     */
    public function rules() {
        return array(
            array('applyCashGwnumbers','length'),
            array('applyCashUnit,applyCashFactorage','required'),
            array('applyCashUnit','numerical', 'integerOnly'=>true,'min'=>0,'message'=>Yii::t('home','{attribute} 需要是正整数')),
            array('applyCashFactorage','match','pattern'=>'/^(:?(:?\d+.\d+)|(:?\d+))$/','message'=>Yii::t('home','{attribute} 需要是正数')),
        );
    }
    

    public function attributeLabels() {
        return array(
            'applyCashUnit'  => Yii::t('home','企业会员提现最低限额'),
            'applyCashFactorage'  => Yii::t('home','企业会员提现手续费'),
            'applyCashGwnumbers'  => Yii::t('home','不包括的企业会员'),
        );
    }
    
}