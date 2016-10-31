<?php

/**
 * This is the model class for table "{{franchisee_pre_consumption_record}}".
 *
 * The followings are the available columns in table '{{franchisee_pre_consumption_record}}':
 * @property string $id
 * @property string $franchisee_id
 * @property string $member_id
 * @property integer $record_type
 * @property integer $status
 * @property integer $is_distributed
 * @property string $spend_money
 * @property integer $gai_discount
 * @property integer $member_discount
 * @property string $distribute_money
 * @property string $create_time
 * @property string $remark
 * @property integer $machine_id
 * @property string $symbol
 * @property string $base_price
 */
class FranchiseeConsumptionPreRecord extends CActiveRecord {
    
    const STATUS_FAIL = 0;		//0表示没交易完成 交易失败
    const STATUS_FINISH = 1;		//已完成
    const STATUS_PARTIALLY_COMPLETED = 2;		//部分成功
    
    const IS_PROCESSED_YES = 1;   //已处理
    const IS_PROCESSED_NO = 0;   //没处理
    
    const IS_PAY_YES = 1; //已经支付
    const IS_PAY_NO = 0; //没支付
    
    const ForbidCacheName = 'ForbidVendingOrder';
    
	public static function getStatus($key = null) {
        $data = array(
            self::STATUS_FAIL => Yii::t('franchiseeConsumptionRecord','手动对账'),
            self::STATUS_FINISH => Yii::t('franchiseeConsumptionRecord','手动对账'),
            self::STATUS_PARTIALLY_COMPLETED => Yii::t('franchiseeConsumptionRecord','手动对账'),
        );
        return $key === null ? $data : $data[$key];
    }
    
    public static function getIsProcessed($key = null) {
        $data = array(
                self::HANDLE_CHECK => Yii::t('franchiseeConsumptionRecord','手动对账'),
                self::AUTO_CHECK => Yii::t('franchiseeConsumptionRecord','自动对账'),
        );
        return $key === null ? $data : $data[$key];
    }
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{franchisee_consumption_pre_record}}';
    }

//     /**
//      * @return array validation rules for model attributes.
//      */
//     public function rules() {
//         // NOTE: you should only define rules for those attributes that
//         // will receive user inputs.
//         return array(
//             array('franchisee_id, member_id, status, is_distributed, spend_money, gai_discount, member_discount, distribute_money, create_time, remark, machine_id, base_price', 'required'),
//             array('record_type, status, is_distributed, gai_discount, member_discount, machine_id', 'numerical', 'integerOnly' => true),
//             array('franchisee_id, member_id, create_time', 'length', 'max' => 11),
//             array('spend_money, distribute_money, base_price', 'length', 'max' => 10),
//             array('remark,start_time,end_time', 'length', 'max' => 255),
//             array('symbol,gai_number', 'length', 'max' => 20),
//             // The following rule is used by search().
//             // @todo Please remove those attributes that should not be searched.
//             array('franchisee_name,franchisee_code,start_time,end_time,mobile,franchisee_mobile,franchisee_province_id,franchisee_city_id,franchisee_district_id,status,gai_number', 'safe', 'on' => 'search'),
//         );
//     }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'franchisee' => array(self::BELONGS_TO, 'Franchisee', 'franchisee_id'),
            'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => '主键id',
            'code' => '装机编码',
            'activation_code' => '系统生成的激活码',
            'name' => '售货机名称',
            'status' => '状态',
            'is_activate' => '是否激活',
            'symbol' => '币种',
//             'country_id' => '加盟商名称',
//             'province_id' => '加盟商编号',
//             'city_id' => '账单时间',
//             'district_id' => '加盟商电话',
            'address' => '加盟商所在地区',
            'user_id' => '账单时间',
            'user_ip' => '查看类型',
            'setup_time'=>'安装时间',
            'remark'=>'备注',
            'device_id'=>'设备id'
        );
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FranchiseeConsumptionRecord the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    
}
