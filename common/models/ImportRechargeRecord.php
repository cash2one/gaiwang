<?php

/**
 * This is the model class for table "{{import_recharge_record}}".
 *
 * The followings are the available columns in table '{{import_recharge_record}}':
 * @property integer $id
 * @property integer $member_id
 * @property string $gai_number
 * @property string $mobile
 * @property string $code
 * @property string $money
 * @property string $money_before
 * @property string $money_after
 * @property integer $status
 * @property string $detail
 * @property integer $create_time
 */
class ImportRechargeRecord extends CActiveRecord
{
    const STATUS = 0;
    const STATUS_PASS = 1;
    const STATUS_FAIL = 2;
    const STATUS_OTHER = 3;
    
    const RECORD_STATUS_YES = 1;//已充值
    const RECORD_STATUS_NO = 2;//未充值
    
    const SEND_SMS_YES = 1;//发送
    const SEND_SMS_NO = 0;//不发送


    public $gaiNumber;
    public $num;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{import_recharge_record}}';
    }
    
    /**
     * 审核状态用文字标示
     * @param null|int $status 查询出来的状态(0 未充值,1 充值成功 2 充值失败)
     * @return array|null
     */

    public static function getStatus($status = null) {
        $arr = array(
            self::STATUS => Yii::t('goods', '未充值'),
            self::STATUS_PASS => Yii::t('goods', '充值成功'),
            self::STATUS_FAIL => Yii::t('goods', '充值失败'),
        );
        if (is_numeric($status)) {
            return isset($arr[$status]) ? $arr[$status] : null;
        } else {
            return $arr;
        }
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mobile, money', 'required','on'=>'required'),
            array('mobile', 'match', 'pattern' =>'/^8|(1[3|4|5|8][0-9]\d{4,8})$/', 'message' => '请输入正确的手机号码','on'=>'required'),
            array('mobile', 'match', 'pattern' =>'/^8|(1[3|4|5|8][0-9]\d{4,8})$/', 'message' => '请输入正确的手机号码','on'=>'notrequired'),
            array('money', 'match', 'pattern' =>'/^([1-9][\d]{0,7}|0)(\.[\d]{1,2})?$/', 'message' => '请输入8位整数积分','on'=>'required'),
            array('money', 'match', 'pattern' =>'/^([1-9][\d]{0,7}|0)(\.[\d]{1,2})?$/', 'message' => '请输入8位整数积分','on'=>'notrequired'),
            array('member_id, status, create_time', 'numerical', 'integerOnly'=>true),
            array('gai_number', 'length', 'max'=>32),
            array('mobile', 'length', 'max'=>128),
            array('code', 'length', 'max'=>256),
            array('money, money_before, money_after', 'length', 'max'=>18),
            array('num,gaiNumber,id, member_id, gai_number, mobile, code, money, money_before, money_after, status, detail, create_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('gaiNumber,id, member_id, gai_number, mobile, code, money, money_before, money_after, status, detail, create_time', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            
        );
    }
    
    

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'member_id' => '盖网id',
            'gai_number' => 'GW账号',
            'mobile' => '手机号码',
            'code' => '加密串',
            'money' => '积分',
            'money_before' => '充值前金额',
            'money_after' => '充值后金额',
            'status' => '充值结果（2为失败，1为成功）',
            'detail' => '相关数据',
            'create_time' => '时间',
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('member_id',$this->member_id);
        $criteria->compare('gai_number',$this->gai_number,true);
        $criteria->compare('mobile',$this->mobile,true);
        $criteria->compare('code',$this->code,true);
        $criteria->compare('money',$this->money,true);
        $criteria->compare('money_before',$this->money_before,true);
        $criteria->compare('money_after',$this->money_after,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('detail',$this->detail,true);
        $criteria->compare('create_time',$this->create_time);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ImportRechargeRecord the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}