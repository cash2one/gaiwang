<?php

/**
 * 订单支付表单模型
 * @author jianlin_lin <hayeslam@163.com>
 */
class OrderPayForm extends CFormModel
{
    public $balance; // 会员账户余额
    public $password;
    public $orderAmount; // 订单总额
    public $payWay;
    /**
     * @var int 是否需要验证密码，0 不需要，1 需要
     */
    public $needPassword = 1;

    /**
     * 返回属性的验证规则
     * @return array
     * @author jianlin.lin
     */
    public function rules()
    {
        return array(
            array('password, payWay, orderAmount', 'required'),
            array('balance', 'balanceValidate'),
            array('orderAmount', 'compare', 'operator' => '>', 'compareValue' => 0, 'message' => Yii::t('orderPayForm', '订单总额异常')),
            array('password', 'passwordValidate'),
            array('payWay', 'in', 'range' => array_keys(OnlinePay::getPayWayList()), 'message' => Yii::t('orderPayForm', '请选择正确的支付方式')),
            array('needPassword','safe'),
        );
    }

    /**
     * 支付密码验证
     * @param string $attribute
     * @param array $params
     * @author jianlin.lin
     */
    public function passwordValidate($attribute, $params)
    {
        if($this->needPassword==0) return;
        /** @var Member $member */
        $member = Member::model()->findByPk(Yii::app()->user->id);
        if (!isset($member->password3))
            $this->addError($attribute, Yii::t('orderPayForm', '您还未设置支付密码'));
        if (!$member->validatePassword3($this->password))
            $this->addError($attribute, Yii::t('orderPayForm', '您输入的支付密码有误'));
    }

    /**
     * 账户余额验证
     * @param $attribute
     * @param $params
     * @author jianlin.lin
     */
    public function balanceValidate($attribute, $params) {
        if (($this->balance < $this->orderAmount) && $this->payWay==OnlinePay::PAY_WAP_INTEGRAL)
            $this->addError($attribute, Yii::t('orderForm', '帐户积分不够支付'));
    }

    /**
     * 返回属性的标签
     * @return array
     * @author jianlin.lin
     */
    public function attributeLabels()
    {
        return array(
            'balance' => Yii::t('orderPayForm', '账户余额'),
            'password' => Yii::t('orderPayForm', '支付密码'),
            'orderAmount' => Yii::t('orderPayForm', '订单总额'),
            'payWay' => Yii::t('orderPayForm', '支付方式'),
        );
    }

    /**
     * 获取支付方式描述
     * @return string
     * @author jianlin.lin
     */
    public function getPayWay()
    {
        $array = OnlinePay::getPayWayList();
        return isset($array[$this->payWay]) ? $array[$this->payWay] : Yii::t('orderPayForm', '未知');
    }

}
