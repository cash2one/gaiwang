<?php

/**
 * 会员中心充值卡充值表单
 *  @author wanyun.liu <wanyun_liu@163.com>
 */
class PrepaidCardForm extends CFormModel {

    public $number;
    public $password;
    public $verifyCode;
    public $gaiNumber;
    private $_model;
    private $_member;

    public function rules() {
        return array(
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
            array('number, password, verifyCode', 'required', 'message' => '{attribute}' . Yii::t('prepaidCard', '不能为空') . '！'),
            array('password', 'authenticate'),
            array('gaiNumber', 'isExist', 'allowEmpty' => true),
            array('gaiNumber, number, password', 'safe')
        );
    }

    public function attributeLabels() {
        return array(
            'gaiNumber' => Yii::t('prepaidCard', '会员GW号'),
            'number' => Yii::t('prepaidCard', '充值卡号'),
            'password' => Yii::t('prepaidCard', '充值密码'),
            'verifyCode' => Yii::t('prepaidCard', '验证码'),
        );
    }

    /**
     * 验证充值者是否存在
     * @param type $attribute
     * @param type $params
     */
    public function isExist($attribute, $params) {
        if ($this->gaiNumber) {
            $this->_member = Member::model()->find(array(
                'select' => 'id',
                'condition' => 'gai_number=:gw',
                'params' => array(':gw' => $this->gaiNumber)
            ));
            if ($this->_member === null)
                $this->addError($attribute, Yii::t('prepaidCard', '无效GW号'));
        }
    }

    /**
     * 验证充值卡信息
     * @param type $attribute
     * @param type $params
     */
    public function authenticate($attribute, $params) {
        $this->_model = PrepaidCard::model()->find('number=:number and status=:status', array(
            ':number' => $this->number,
            ':status' => PrepaidCard::STATUS_UNUSED
        ));
        if ($this->_model === null)
            $this->addError('password', Yii::t('prepaidCard', '错误的充值卡帐号或密码'));
        if ($this->_model && (Tool::authcode($this->_model->password, 'DECODE') != $this->password))
            $this->addError('password', Yii::t('prepaidCard', '错误的充值卡帐号或密码'));
    }

    /**
     * 充值操作
     * 事务处理
     * 更新会员不可兑现积分
     * 更新当前充值卡信息，标识已用
     */
    public function recharge() {
        if ($this->_model === null)
            return false;
        $prepaidCard = array(
            'id' => $this->_model->id,
            'number' => $this->_model->number,
            'value' => $this->_model->value,
            'type' => $this->_model->type,
            'version' => $this->_model->version
        );
        $memberFields = array('mobile', 'id', 'type_id', 'gai_number', 'username');
        $uid = $this->_member ? $this->_member->id : Yii::app()->user->id;
        $member = Yii::app()->db->createCommand()->select($memberFields)
                        ->from('{{member}}')->where('id=:id', array(':id' => $uid))->queryRow();

        // 为他人充值时，记录充值者
        $recharger = $this->_member ? Yii::app()->user->gw : '';
        if ($member == null)
            return false;
        $memberType = MemberType::fileCache();
        if ($memberType == null)
            return false;
        return PrepaidCardUse::recharge($prepaidCard, $member, $memberType, true, true, $recharger);
    }

}
