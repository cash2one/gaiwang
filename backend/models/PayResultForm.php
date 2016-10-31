<?php
/**
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 2014/11/17
 * Time: 15:33
 */

class PayResultForm extends CFormModel {

    public $code;
    public $payType;
    public $orderType;
    /** @var  string 订单号 英文逗号分隔 */
    public $mainCode;
    public $source;
    /**
     * 订单类型，与frontend/components/OnlinePay.php 中定义的一致
     */
    const ORDER_TYPE_RECHARGE = 0; //积分充值
    const ORDER_TYPE_GOODS = 1; //商品订单支付
    const ORDER_TYPE_HOTEL = 2; //酒店订单

    public static function OrderType($k=null)
    {
        $arr = array(
            self::ORDER_TYPE_RECHARGE => '积分充值',
            self::ORDER_TYPE_GOODS => '商品订单支付',
            self::ORDER_TYPE_HOTEL => '酒店订单',
        );
        return isset($arr[$k]) ? $arr[$k] : $arr;
    }



    /**
     * 验证规则
     * @return array
     */
    public function rules() {
        return array(
            array('code,payType,orderType,source', 'required'),
            array('mainCode', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'code' => Yii::t('home', '支付单号'),
            'payType' => Yii::t('home', '支付接口'),
            'orderType' => Yii::t('home', '订单类型'),
            'mainCode' => Yii::t('home', '订单编号'),
            'source' => Yii::t('home', '订单来源'),
        );
    }

} 