<?php
/**
 *  线下自动对账配置 模型类
 *
 * @author zhenjun_xu <412530435@qq.com>
 */
class CheckConfigForm extends CFormModel{
    
    public $totalCount;				//总消费次数
    public $minMoney;				//总消费次数内下限金额
    public $maxMoney;				//单笔消费上限金额
    public $maxRatio;				//金额比例
    public $days;					//天数
    
    /**
     * 验证规则
     * @return array
     */
    public function rules() {
        return array(
            array('totalCount,minMoney,maxMoney,maxRatio,days','required'),
            array('totalCount,days','numerical', 'integerOnly'=>true,'min'=>0,'message'=>Yii::t('home','{attribute} 需要是正整数')),
            array('maxRatio','numerical', 'integerOnly'=>true,'min'=>0,'max'=>100,'message'=>Yii::t('home','{attribute} 需要是正整数')),
            array('minMoney,maxMoney','numerical', 'min'=>0,'message'=>Yii::t('home','{attribute} 需要是正数')),
        );
    } 

    public function attributeLabels() {
        return array(
            'totalCount'  => Yii::t('home','总消费次数'),
            'minMoney'  => Yii::t('home','最小金额'),
            'maxMoney'  => Yii::t('home','最大金额'),
            'maxRatio'  => Yii::t('home','最大比率'),
            'days'      => Yii::t('home','天数'),
        );
    }
    
}