<?php

/**
 * This is the model class for table "{{franchisee_staff}}".
 *
 * The followings are the available columns in table '{{franchisee_staff}}':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $franchisee_id
 * @property string $mobile
 * @property string $remark
 * @property string $nickname
 * @property string $current_login_time
 * @property string $last_login_time
 * @property string $create_time
 * @property string $position
 * @property string $face_path
 * @property string $start_orders
 * @property string $end_orders
 * @property string $recharge_amount
 *
 * The followings are the available model relations:
 * @property FranchiseeGoodsOrder[] $franchiseeGoodsOrders
 * @property Franchisee $franchisee
 */
class FranchiseeStaff extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{franchisee_staff}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, salt, franchisee_id, mobile, remark, nickname, last_login_time, create_time, position, face_path, start_orders, end_orders, recharge_amount', 'required'),
			array('username, password, salt, nickname, position', 'length', 'max'=>128),
			array('franchisee_id, current_login_time, last_login_time, create_time, start_orders, end_orders', 'length', 'max'=>11),
			array('mobile', 'length', 'max'=>64),
			array('face_path', 'length', 'max'=>256),
			array('recharge_amount', 'length', 'max'=>18),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, salt, franchisee_id, mobile, remark, nickname, current_login_time, last_login_time, create_time, position, face_path, start_orders, end_orders, recharge_amount', 'safe', 'on'=>'search'),
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
			'franchiseeGoodsOrders' => array(self::HAS_MANY, 'FranchiseeGoodsOrder', 'franchisee_staff_id'),
			'franchisee' => array(self::BELONGS_TO, 'Franchisee', 'franchisee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '主键',
			'username' => '用户名',
			'password' => '密码',
			'salt' => '密钥',
			'franchisee_id' => '所属加盟商',
			'mobile' => '手机号码',
			'remark' => '备注',
			'nickname' => '昵称',
			'current_login_time' => '当前登录时间',
			'last_login_time' => '上次登录时间',
			'create_time' => '创建时间',
			'position' => '职位',
			'face_path' => '头像路径',
			'start_orders' => '开单数',
			'end_orders' => '结单数',
			'recharge_amount' => '充值金额',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('franchisee_id',$this->franchisee_id,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('current_login_time',$this->current_login_time,true);
		$criteria->compare('last_login_time',$this->last_login_time,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('face_path',$this->face_path,true);
		$criteria->compare('start_orders',$this->start_orders,true);
		$criteria->compare('end_orders',$this->end_orders,true);
		$criteria->compare('recharge_amount',$this->recharge_amount,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FranchiseeStaff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
