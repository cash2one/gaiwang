<?php

/**
 * This is the model class for table "{{franchisee_goods_order_to_call_info}}".
 *
 * The followings are the available columns in table '{{franchisee_goods_order_to_call_info}}':
 * @property string $id
 * @property string $create_time
 * @property integer $status
 * @property string $franchisee_goods_order_id
 * @property string $franchisee_id
 * @property string $content
 * @property string $member_id
 * @property string $amount
 * @property string $table_name
 * @property string $member_mobile
 * @property string $member_name
 * @property string $member_level
 *
 * The followings are the available model relations:
 * @property Franchisee $franchisee
 * @property FranchiseeGoodsOrder $franchiseeGoodsOrder
 * @property Member $member
 */
class FranchiseeGoodsOrderToCallInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{franchisee_goods_order_to_call_info}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, status, franchisee_goods_order_id, franchisee_id, content, member_id, amount, table_name, member_mobile, member_name, member_level', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('create_time, franchisee_goods_order_id, franchisee_id, member_id', 'length', 'max'=>11),
			array('content, table_name, member_mobile, member_name', 'length', 'max'=>128),
			array('amount', 'length', 'max'=>18),
			array('member_level', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, create_time, status, franchisee_goods_order_id, franchisee_id, content, member_id, amount, table_name, member_mobile, member_name, member_level', 'safe', 'on'=>'search'),
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
			'franchisee' => array(self::BELONGS_TO, 'Franchisee', 'franchisee_id'),
			'franchiseeGoodsOrder' => array(self::BELONGS_TO, 'FranchiseeGoodsOrder', 'franchisee_goods_order_id'),
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'create_time' => '创建时间',
			'status' => '状态（0呼叫中、1已处理）',
			'franchisee_goods_order_id' => '呼叫的线下商品订单id',
			'franchisee_id' => '加盟商id',
			'content' => '呼叫的内容',
			'member_id' => '会员id',
			'amount' => '消费金额',
			'table_name' => '台号名称',
			'member_mobile' => '会员手机号',
			'member_name' => '会员名称',
			'member_level' => 'Member Level',
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
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('franchisee_goods_order_id',$this->franchisee_goods_order_id,true);
		$criteria->compare('franchisee_id',$this->franchisee_id,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('table_name',$this->table_name,true);
		$criteria->compare('member_mobile',$this->member_mobile,true);
		$criteria->compare('member_name',$this->member_name,true);
		$criteria->compare('member_level',$this->member_level,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FranchiseeGoodsOrderToCallInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
