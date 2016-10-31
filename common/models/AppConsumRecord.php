<?php

/**
 * This is the model class for table "{{app_consum_record}}".
 *
 * The followings are the available columns in table '{{app_consum_record}}':
 * @property string $id
 * @property integer $app_type
 * @property integer $system_type
 * @property string $member_id
 * @property string $order_id
 * @property string $order_num
 * @property integer $order_type
 * @property double $amount
 * @property string $create_time
 */
class AppConsumRecord extends CActiveRecord
{
    const ORDER_TYPE_GW_ORDER = 1; //线上
    const ORDER_TYPE_FRANCHISEE = 2;//线下消费（盖网通）
    const ORDER_TYPE_SKU = 3;//SKU消费
    const ORDER_TYPE_EPTOK = 4; //便民服务
	//public $pay_type;
    
    public static function getOrderType($key = false) {
		$status = array(
				self::ORDER_TYPE_GW_ORDER => '商城订单',
				self::ORDER_TYPE_FRANCHISEE => '线下订单',
		        self::ORDER_TYPE_SKU => 'SKU订单',
		        self::ORDER_TYPE_EPTOK => '便民',
		);
		if ($key === false)
			return $status;
		if (!isset($status[$key]))
		    return false;
		return $status[$key];
	}
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{app_consum_record}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, app_type, member_id, order_num, order_type, amount, create_time', 'required'),
			array('app_type, system_type, order_type', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('id, member_id, order_id, create_time', 'length', 'max'=>11),
			array('order_num', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, app_type, system_type, member_id, order_id, order_num, order_type, amount, create_time', 'safe', 'on'=>'search'),
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
			'id' => '主键',
			'app_type' => 'APP类型',
			'system_type' => '系统类型',
			'member_id' => '会员',
			'order_id' => '订单主键',
			'order_num' => '订单号',
			'order_type' => '订单类型',
			'amount' => '消费金额',
			'create_time' => '创建时间',
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
		//$recharge_tablename = new Recharge();

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.app_type',$this->app_type);
		$criteria->compare('t.system_type',$this->system_type);
		$criteria->compare('t.member_id',$this->member_id,true);
		$criteria->compare('t.order_id',$this->order_id,true);
		$criteria->compare('t.order_num',$this->order_num,true);
		$criteria->compare('t.order_type',$this->order_type);
		$criteria->compare('t.amount',$this->amount);
		$criteria->compare('t.create_time',$this->create_time,true);

		//$criteria->select = 't.id,t.app_type,t.system_type,t.member_id,t.order_id,t.order_num,t.order_type,t.amount,t.create_time,r.pay_type';
		//$criteria->join = 'LEFT JOIN '.$recharge_tablename->tableName().' as r ON r.code = t.order_num';
		//$criteria->compare('r.pay_type',$this->pay_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AppConsumRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
