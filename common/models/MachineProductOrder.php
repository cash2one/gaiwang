<?php

/**
 * 盖网通商城订单
 * @author LC
 * This is the model class for table "{{machine_product_order}}".
 *
 * The followings are the available columns in table '{{machine_product_order}}':
 * @property string $id
 * @property string $code
 * @property string $machine_id
 * @property string $member_id
 * @property string $phone
 * @property integer $pay_type
 * @property integer $status
 * @property integer $pay_status
 * @property integer $consume_status
 * @property string $pay_price
 * @property string $real_price
 * @property string $original_price
 * @property string $return_money
 * @property string $create_time
 * @property string $pay_time
 * @property string $consume_time
 * @property integer $is_read
 * @property string $ip_address
 * @property string $remark
 * @property string $franchisee_id
 * @property string $symbol
 * @property string $base_price
 */
class MachineProductOrder extends CActiveRecord
{
	public $consume_end_time;
	public $gai_numbers;//买家会员编号
        public $fname;//加盟商名称
        public $fnum;//加盟商编号
        public $province_id;//省
        public $city_id;//市
        public $district_id;//区
        public $min_price;//最小价格 价格区间
        public $max_price;//最大价格
        
        
        
	const PAY_TYPE_JF = 1;
    const PAY_TYPE_BANK = 2;
	/**
     * 支付方式
     * @param null $k
     * @return array|null
     */
    public static function payType($k = null) {
        $arr = array(
            self::PAY_TYPE_JF => Yii::t('machineProductOrder', '积分'),
            self::PAY_TYPE_BANK => Yii::t('machineProductOrder', '网银'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }
    
    const STATUS_NEW = 1;
    const STATUS_COMPLETE = 2;
    const STATUS_CLOSE = 3;
	/**
     * 订单状态
     * 1新订单，2交易完成，3交易关闭
     * @param null $k
     * @return array|null
     */

    public static function status($k = null) {
        $arr = array(
            self::STATUS_NEW => Yii::t('machineProductOrder', '新订单'),
            self::STATUS_COMPLETE => Yii::t('machineProductOrder', '交易完成'),
            self::STATUS_CLOSE => Yii::t('machineProductOrder','交易关闭'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }  

	const PAY_STATUS_NO = 1;
    const PAY_STATUS_YES = 2;

    /**
     * 支付状态
     * （1未支付，2已支付）
     * @param null $k
     * @return array|null
     */
    public static function payStatus($k = null) {
        $arr = array(
            self::PAY_STATUS_NO => Yii::t('machineProductOrder', '未支付'),
            self::PAY_STATUS_YES => Yii::t('machineProductOrder', '已支付'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }
    
    const CONSUME_STATUS_NO = 1;
    const CONSUME_STATUS_YES = 2;
    const CONSUME_STATUS_EXPIRE = 3;
    /**
     * 消费状态
     * （1、未消费，2、已消费, 3、已过期）
     * @param null $k
     * @return array|null
     */
    public static function consumeStatus($k = null){
    	$arr = array(
            self::CONSUME_STATUS_NO => Yii::t('machineProductOrder', '未消费'),
            self::CONSUME_STATUS_YES => Yii::t('machineProductOrder', '已消费'),
            self::CONSUME_STATUS_EXPIRE => Yii::t('machineProductOrder', '已过期'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }
    
    const RMB = 'RMB';		//人民币
    const HKD = 'HKD';		//港币
    /**
     * 将人民币转化成港币
     */
    public static function convertHKD($money, $base_price)
    {
    	return $money*$base_price/100;
    }
    
    const READ_YES = 1;
    
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{machine_product_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, machine_id, member_id, phone, status, pay_status, consume_status, pay_price, real_price, original_price, return_money, create_time, pay_time, consume_time, ip_address, franchisee_id, base_price', 'required'),
			array('remark', 'safe'),
			array('pay_type, status, pay_status, consume_status, is_read', 'numerical', 'integerOnly'=>true),
			array('code, phone', 'length', 'max'=>50),
			array('machine_id, member_id, ip_address, franchisee_id', 'length', 'max'=>11),
			array('pay_price, real_price, original_price, return_money, create_time, pay_time, consume_time, base_price', 'length', 'max'=>10),
			array('remark', 'length', 'max'=>255),
			array('symbol', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, machine_id, member_id, phone, pay_type, status, pay_status, consume_status, pay_price, real_price, original_price, return_money, create_time, pay_time, consume_time, is_read, ip_address, remark, franchisee_id, symbol, base_price, consume_end_time', 'safe', 'on'=>'search'),
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
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
			'machineProductOrderDetail' => array(self::HAS_MANY, 'MachineProductOrderDetail', 'machine_product_order_id'),
            'franchisee' => array(self::BELONGS_TO,'Franchisee','franchisee_id'),
			'machine' => array(self::BELONGS_TO, 'Machine', 'machine_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => Yii::t('machineProductOrder', '订单编号'),
			'machine_id' => '盖机id',
			'member_id' => '会员id',
			'phone' => Yii::t('machineProductOrder', '手机号码'),
			'pay_type' => '支付方式（1积分，2网银）',
			'status' => '状态(1新订单，2交易完成)',
			'pay_status' => '支付状态（1未支付，2已支付）',
			'consume_status' => Yii::t('machineProductOrder', '消费状态'),
			'pay_price' => '支付金额',
			'real_price' => '实际金额',
			'original_price' => '市场价',
			'return_money' => '返还金额',
			'create_time' => '创建时间',
			'pay_time' => '支付时间',
			'consume_time' => Yii::t('machineProductOrder', '消费时间'),
			'is_read' => '是否查看（0否，1是)',
			'ip_address' => 'ip地址',
			'remark' => 'Remark',
			'franchisee_id' => '加盟商id',
			'symbol' => '币种',
			'base_price' => '换算成人民币的汇率，如果是港币为78，人民币为100,具体数值在网站配置里取',
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
		$criteria->with = array(
			'member'=>array('select'=>'gai_number'),
		);
		
		$criteria->compare('code',$this->code,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('consume_status',$this->consume_status);
		
		$criteria->compare('consume_time','>='.strtotime($this->consume_time));
		if($this->consume_end_time)
		{
			$criteria->compare('consume_time','<='.(strtotime($this->consume_end_time)+86399));
		}
		
		$criteria->compare('franchisee_id',$this->franchisee_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//			'pagination' =>array(
//				'pageSize'=>1
//			)
		));
	}
        
        
        /*
         * 盖网后台管理--盖网通商城订单 搜索
         */
        public function searchOrder(){
                $criteria=new CDbCriteria;
	
                $criteria->with = array(
                    'franchisee'=>array('select'=>'code,name,province_id,city_id,district_id'),
                    'member'=>array('select'=>'gai_number'),
                );
		$criteria->compare('t.code',$this->code,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('consume_status',$this->consume_status);
		$criteria->compare('t.status',$this->status);
                $criteria->compare('franchisee.code',$this->fnum,true);
                $criteria->compare('franchisee.name',$this->fname,true);
                
                $criteria->compare('franchisee.province_id', $this->province_id);
                $criteria->compare('franchisee.city_id', $this->city_id);
                $criteria->compare('franchisee.district_id', $this->district_id);
                
                $criteria->compare('gai_number', $this->gai_numbers,true);
                
		$criteria->compare('consume_time','>='.strtotime($this->consume_time));
		if($this->consume_end_time)
		{
			$criteria->compare('consume_time','<='.(strtotime($this->consume_end_time)+86399));
		}
		
		$criteria->compare('franchisee_id',$this->franchisee_id);
                $criteria->compare('member_id', $this->member_id);
                
                $criteria->compare('t.real_price','>='.$this->min_price);
                $criteria->compare('t.real_price', '<'.$this->max_price);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' =>array(
				'pageSize'=>10
			)
		));
        }
        
        

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MachineProductOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
