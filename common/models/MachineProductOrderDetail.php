<?php

/**
 * 盖网通商城订单详情
 * @author LC
 * This is the model class for table "{{machine_product_order_detail}}".
 *
 * The followings are the available columns in table '{{machine_product_order_detail}}':
 * @property string $id
 * @property string $machine_product_order_id
 * @property integer $product_id
 * @property string $product_name
 * @property integer $quantity
 * @property integer $product_thumbnail_id
 * @property string $total_price
 * @property string $price
 * @property string $original_price
 * @property string $return_money
 * @property integer $sms_id
 * @property string $verify_code
 * @property integer $is_consumed
 * @property string $consume_time
 * @property string $remark
 * @property integer $gw_rate
 * @property integer $gt_rate
 * @property integer $back_rate
 */
class MachineProductOrderDetail extends CActiveRecord
{
	public $buy_create_time,$buy_end_time,$franchisee_id,$machine_id;	//下单时间
	
	const IS_CONSUMED_NO = 0;
	const IS_CONSUMED_YES = 1;
	/**
	 * 是否消费
	 * @param null $k
     * @return array|null
	 */
	public static function isConsume($k = null){
    	$arr = array(
            self::IS_CONSUMED_NO => Yii::t('machineProductOrder', '未消费'),
            self::IS_CONSUMED_YES => Yii::t('machineProductOrder', '已消费'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{machine_product_order_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('machine_product_order_id, product_id, product_name, product_thumbnail_id, total_price, price, original_price, return_money, sms_id, verify_code, consume_time, gw_rate, gt_rate, back_rate', 'required'),
			array('remark','safe'),
			array('product_id, quantity, product_thumbnail_id, sms_id, is_consumed, gw_rate, gt_rate, back_rate', 'numerical', 'integerOnly'=>true),
			array('machine_product_order_id', 'length', 'max'=>11),
			array('product_name', 'length', 'max'=>50),
			array('total_price, price, original_price, return_money, verify_code, consume_time', 'length', 'max'=>10),
			array('remark', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, machine_product_order_id, product_id, product_name, quantity, product_thumbnail_id, total_price, price, original_price, return_money, sms_id, verify_code, is_consumed, consume_time, remark, gw_rate, gt_rate, back_rate,buy_create_time,buy_end_time', 'safe', 'on'=>'search'),
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
			'machineProductOrder' => array(self::BELONGS_TO, 'MachineProductOrder', 'machine_product_order_id'),
			'machineProduct' => array(self::BELONGS_TO, 'MachineProduct', 'product_id'),
			'machineFileManage' => array(self::BELONGS_TO, 'MachineFileManage', 'product_thumbnail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'machine_product_order_id' => '盖网通订单id',
			'product_id' => '商品id',
			'product_name' => '商品名称',
			'quantity' => '数量',
			'product_thumbnail_id' => '商品缩略图id',
			'total_price' => '总价格',
			'price' => '零售价',
			'original_price' => '市场价',
			'return_money' => '返还金额',
			'sms_id' => '短信日志的id',
			'verify_code' => '消费验证码(5位)',
			'is_consumed' => '是否已消费（0、未消费  1、已消费）',
			'consume_time' => '消费时间',
			'remark' => '备注',
			'gw_rate' => '盖网收益率',
			'gt_rate' => '盖机收益率',
			'back_rate' => '返佣率',
		);
	}

	/**
	 * 卖家后台---加盟商管理 > 盖网机列表 > 产品交易记录
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
			'machineProductOrder' => array(
				'select'=>'code,create_time',
				'with' => array(
					'member'=>array('select'=>'gai_number')
				),
			),
			'machineFileManage'=>array(
				'select'=>'path',
			),
		);
		$criteria->compare('machineProductOrder.franchisee_id',$this->franchisee_id);
		$criteria->compare('machineProductOrder.machine_id',$this->machine_id);
		$criteria->compare('machineProductOrder.create_time','>='.strtotime($this->buy_create_time));
		if($this->buy_end_time)
		{
			$criteria->compare('machineProductOrder.create_time','<='.(strtotime($this->buy_end_time)+86399));
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//			'pagination' =>array(
//				'pageSize'=>1
//			)			
		));
	}
	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MachineProductOrderDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
