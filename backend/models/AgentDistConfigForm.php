<?php
/**
 *  代理分配比率设置 模型类
 *
 * @author zhenjun_xu <412530435@qq.com>
 */
class AgentDistConfigForm extends CFormModel{
    
    public $province;
    public $city;
    public $district;
    public $factDist;
    public $factProvince;
    public $factCity;
    public $factDistrict;
    public $factPerson;

    /**
     * 验证规则
     * @return array
     */
    public function rules() {
        return array(
            array('province, city, district, factDist, factProvince, factCity, factDistrict, factPerson','required'),
            array('province, city, district, factDist, factProvince, factCity, factDistrict, factPerson','numerical','integerOnly'=>true,'min'=>0,'max'=>100),
        );
    }
    

    public function attributeLabels() {
        return array(
            //代理分配比率设置
            'province'  => Yii::t('home','省代理'),
            'city'  => Yii::t('home','市代理'),
            'district'  => Yii::t('home','区/县代理'),
            //手续费分配比率设置
            'factDist'  => Yii::t('home','分配比率'),
            'factProvince'  => Yii::t('home','省代理'),
            'factCity'  => Yii::t('home','市代理'),
            'factDistrict'  => Yii::t('home','区/县代理'),
            'factPerson'  => Yii::t('home','个人代理（推荐商家会员）'),

        );
    }
    
}