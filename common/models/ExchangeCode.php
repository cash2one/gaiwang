<?php

/**
 * 红包充值兑换码模型
 * @author shengjie.zhang
 * 
 * The followings are the available columns in table '{{exchange_code}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class ExchangeCode extends CActiveRecord {

    const RECHARGE_NO = 0;
    const RECHARGE_YES = 1;

    public function tableName() {
        return '{{exchange_code}}';
    }


    //红包活动类型

    const TYPE_REGISTER = 1; //注册送红包
    const TYPE_SHARE = 2; //分享送红包
    const TYPE_RECHARGE = 3; //充值红包
/**
 * 获取红包类型
 * @param int $k
 * @return string
 */
    public static function getType($k = null) {
        $array = array(
            self::TYPE_REGISTER => '注册送红包',
            self::TYPE_SHARE => '分享送红包',
            self::TYPE_RECHARGE => '充值红包',
        );
        if (is_numeric($k)) {
            return isset($array[$k]) ? $array[$k] : null;
        } else {
            return $array;
        }
    }
    /**
     * 获取兑换状态
     * @param int $k 
     * @return string
     */
    public static function status($k = null) {
        $array = array(
            self::RECHARGE_NO => '未兑换',
            self::RECHARGE_YES => '已兑换',
        );
        if (is_numeric($k)) {
            return isset($array[$k]) ? $array[$k] : null;
        } else {
            return $array;
        }
    }

    public function rules() {
        return array(
            array('name', 'required','on'=>'required'),           
            array('name', 'length', 'max'=>12),
             array('name', 'match', 'pattern' =>'/[0-9]{12}/', 'message' => '兑换码须由12位纯数字','on'=>'required'),
           array('name', 'match', 'pattern' =>'/[0-9]{12}/', 'message' => '兑换码须由12位纯数字','on'=>'norequired'),
//            array('name', 'length', 'max' => 128),
            array('name,status,money,account,time', 'safe'),
            array('money','check_money'),
//            array('money', 'match', 'pattern' =>'/[0-9]{0,5}/', 'message' => '金额必须大于0且小于10000'),
            array('money', 'required'),
        );
    }
    public function check_money($attribute,$params){
        $reg='/^[0-9]+(\.[0-9]{1,2})?$/';
        if(!preg_match($reg,$this->money)){
            $this->addError($attribute, '金额格式不对，必须是数字，如100.00');
        }
        if($this->money<=0 || $this->money>10000){
            $this->addError($attribute, '金额必须大于0且小于或等于10000');
        }
            
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => '兑换码',
            'status' => '兑换状态',
            'money' => '面值',
            'account' => '兑换账号（GW号）',
            'time' => '兑换时间',
            'type' => '兑换类型',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('status', $this->status, TRUE);
        $criteria->compare('money', $this->money, true);
        $criteria->compare('account', $this->account, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('type', $this->type, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
