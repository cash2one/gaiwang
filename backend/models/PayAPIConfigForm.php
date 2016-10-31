<?php

/**
 *  支付接口配置 模型类
 *
 * @author zhenjun_xu <412530435@qq.com>
 */
class PayAPIConfigForm extends CFormModel {

    public $ipsEnable;
    public $gneteEnable;
    public $bestEnable;
    public $hiEnable;
    public $umEnable;
    public $umQuickEnable;
    public $tlzfEnable;
    public $tlzfKjEnable;
    public $ghtEnable;
    public $ghtKjEnable;
    public $ghtQuickEnable;
    public $ebcEnable;
    /** @var string 对账ip地址 */
    public $ip;

    const PAY_OPEN = 'true';
    const PAY_CLOSE = 'false';

    /**
     * 支付状态数组
     * @return array
     */
    static public function apiStatus() {
        return array(
            self::PAY_OPEN => Yii::t('home','开启'),
            self::PAY_CLOSE => Yii::t('home','关闭'),
        );
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules() {
        return array(
            array('ipsEnable,gneteEnable,bestEnable,hiEnable,umEnable,umQuickEnable,tlzfEnable,tlzfKjEnable,ghtEnable,ghtKjEnable,ghtQuickEnable,ebcEnable,ip', 'required'),
        );
    }

    public function attributeLabels() {
        return array(
            'ipsEnable' => Yii::t('home', '环迅支付开关'),
            'gneteEnable' => Yii::t('home', '银联支付开关'),
            'bestEnable' => Yii::t('home', '翼支付开关'),
            'hiEnable' => Yii::t('home', '汇卡支付开关'),
            'umEnable' => Yii::t('home', '联动优势支付开关'),
            'umQuickEnable' => Yii::t('home', '联动优势支付(快捷支付)开关'),
            'tlzfEnable' => Yii::t('home', '通联支付开关'),
            'tlzfKjEnable' => Yii::t('home', '通联支付KJ开关'),
            'ghtEnable' => Yii::t('home', '高汇通支付开关'),
            'ghtKjEnable' => Yii::t('home', '高汇通KJ支付开关'),
            'ghtQuickEnable' => Yii::t('home', '高汇通快捷支付开关'),
            'ebcEnable' => Yii::t('home', 'EBC钱包支付开关'),
            'ip' => Yii::t('home', '对账ip地址'),
        );
    }

}