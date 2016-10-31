<?php

/**
 * This is the model class for table "{{transfer_order}}".
 *
 * The followings are the available columns in table '{{transfer_order}}':
 * @property string $id
 * @property string $order_num
 * @property string $machine_sn
 * @property string $machine_id
 * @property integer $source_type
 * @property double $account
 * @property string $pay_id
 * @property string $receive_id
 * @property integer $create_time
 */
class TransferOrder extends CActiveRecord
{
    const SOURCE_TYPE_GT = 1;//盖网通
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{transfer_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_num, source_type, account, pay_id, receive_id, create_time', 'required'),
			array('source_type, create_time', 'numerical', 'integerOnly'=>true),
			array('account', 'numerical'),
			array('order_num', 'length', 'max'=>32),
			array('machine_sn', 'length', 'max'=>64),
			array('machine_id, pay_id, receive_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_num, machine_sn, machine_id, source_type, account, pay_id, receive_id, create_time', 'safe', 'on'=>'search'),
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
			'order_num' => 'Order Num',
			'machine_sn' => 'Machine Sn',
			'machine_id' => 'Machine',
			'source_type' => 'Source Type',
			'account' => 'Account',
			'pay_id' => 'Pay',
			'receive_id' => 'Receive',
			'create_time' => 'Create Time',
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
		$criteria->compare('order_num',$this->order_num,true);
		$criteria->compare('machine_sn',$this->machine_sn,true);
		$criteria->compare('machine_id',$this->machine_id,true);
		$criteria->compare('source_type',$this->source_type);
		$criteria->compare('account',$this->account);
		$criteria->compare('pay_id',$this->pay_id,true);
		$criteria->compare('receive_id',$this->receive_id,true);
		$criteria->compare('create_time',$this->create_time);

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
	 * @return TransferOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
