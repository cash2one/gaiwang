<?php

/**
 * This is the model class for table "{{eptok_mobile_flow_recharge_config}}".
 *
 * The followings are the available columns in table '{{eptok_mobile_flow_recharge_config}}':
 * @property string $id
 * @property string $province_id
 * @property integer $operator
 * @property string $price
 * @property string $amount
 * @property string $pay_percent
 * @property integer $update_time
 * @property integer $un_province_id
 * @property string $use_target
 * @property string $un_percent
 */
class MobileFlowRechargeConfig extends CActiveRecord
{
	public  $id;
	public  $province_id;
	public  $operator;
	public  $price;
	public  $amount;
	public  $pay_percent;
	public  $update_time;
	public  $un_province_id;
	public  $use_target;
	public  $un_percent;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{eptok_mobile_flow_recharge_config}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operator, update_time, un_province_id', 'numerical', 'integerOnly'=>true),
			array('province_id, use_target', 'length', 'max'=>11),
			array('price', 'length', 'max'=>6),
			array('amount', 'length', 'max'=>10),
			array('pay_percent, un_percent', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, province_id, operator, price, amount, pay_percent, update_time, un_province_id, use_target, un_percent', 'safe', 'on'=>'search'),
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
			'province_id' => '省份id',
			'operator' => '0未知,1移动,2联通,3电信',
			'price' => '价格',
			'amount' => '流量值(MB,G)',
			'pay_percent' => '盖网折扣',
			'update_time' => 'Update Time',
			'un_province_id' => '平台省份id',
			'use_target' => '使用范围,省市区id',
			'un_percent' => '平台折扣',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('province_id',$this->province_id,true);
		$criteria->compare('operator',$this->operator);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('pay_percent',$this->pay_percent,true);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('un_province_id',$this->un_province_id);
		$criteria->compare('use_target',$this->use_target,true);
		$criteria->compare('un_percent',$this->un_percent,true);
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EptokMobileFlowRechargeConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
