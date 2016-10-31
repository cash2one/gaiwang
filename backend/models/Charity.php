<?php

/**
 * 捐款模型
 * @author wencong.lin <wanyun_liu@163.com>
 *
 * The followings are the available columns in table '{{charity}}':
 * @property string $id
 * @property string $member_id
 * @property string $sign
 * @property string $qq
 * @property string $blessing
 * @property string $money
 * @property string $score
 * @property string $create_time
 * @property string $pay_type
 * @property string $ip
 * @property string $area
 * @property string $description
 * @property string $code
 * @property integer $status
 * @property string $pay_time
 */
class Charity extends CActiveRecord {

    public $endTime;

    const PAY_TYPE_SCORE = 1; //盖网积分
    const PAY_TYPE_IPS = 2; //IPS环迅支付

    /**
     * 支付类型状态
     * @param type $id
     */

    public static function getPayType($key = null) {
        $arr = array(
            self::PAY_TYPE_SCORE => Yii::t('charity', '盖网通积分'),
            self::PAY_TYPE_IPS => Yii::t('charity', 'IPS环迅支付'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    const STATUS_NO = 0;    // 未支付
    const STATUS_YES = 1;   // 支付成功
    const STATUS_FAILURE = 2; // 支付失败

    /**
     * 支付类型状态
     * @param type $id
     */

    public static function getPayStatus($key = null) {
        $arr = array(
            self::STATUS_NO => Yii::t('charity', '未支付'),
            self::STATUS_YES => Yii::t('charity', '支付成功'),
            self::STATUS_FAILURE => Yii::t('charity', '支付失败'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{charity}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('member_id, sign, qq, blessing, money, score, create_time, pay_type, ip, area, description, code, status, pay_time', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('member_id, create_time, pay_type, ip, pay_time', 'length', 'max' => 11),
            array('sign, blessing, area, code', 'length', 'max' => 128),
            array('qq', 'length', 'max' => 16),
            array('money, score', 'length', 'max' => 10),
            array('id, member_id, sign, qq, blessing, money, score, create_time, endTime, pay_type, ip, area, description, code, status, pay_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'member_id' => Yii::t('charity', '会员编号'),
            'sign' => Yii::t('charity', '捐献人署名'),
            'qq' => 'Qq',
            'blessing' => Yii::t('charity', '祝福语'),
            'money' => Yii::t('charity', '捐献金额'),
            'score' => Yii::t('charity', '捐献积分'),
            'create_time' => Yii::t('charity', '捐款时间'),
            'pay_type' => Yii::t('charity', '捐款方式'),
            'ip' => 'Ip',
            'area' => Yii::t('charity', '城市'),
            'description' => 'Description',
            'code' => 'Code',
            'status' => Yii::t('charity', '捐款状态'),
            'pay_time' => 'Pay Time',
        );
    }
    

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.sign', $this->sign, true);
        $criteria->compare('t.pay_type', $this->pay_type, true);
        $criteria->compare('t.status', $this->status);

        $searchDate = Tool::searchDateFormat($this->create_time, $this->endTime);
        $criteria->compare('t.create_time', ">=" . $searchDate['start']);
        $criteria->compare('t.create_time', "<" . $searchDate['end']);

        if (isset($this->member_id)) {
            $criteria->with = 'member';
            $criteria->compare('member.gai_number', $this->member_id, true);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Charity the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
