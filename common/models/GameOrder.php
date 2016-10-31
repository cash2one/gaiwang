<?php

/**
 * This is the model class for table "{{game_order}}".
 *
 * The followings are the available columns in table '{{game_order}}':
 * @property string $id
 * @property integer $member_id
 * @property string $real_name
 * @property string $mobile
 * @property integer $status
 * @property string $member_address
 * @property string $items_info
 * @property integer $delivery_time
 * @property integer $create_time
 * @property integer $update_time
 */
class GameOrder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{game_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('items_info, delivery_time', 'required'),
//			array('member_id, status, delivery_time, create_time, update_time', 'numerical', 'integerOnly'=>true),
			array('real_name, mobile', 'length', 'max'=>128),
			array('member_address, items_info', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, member_id, real_name, mobile, status, member_address, items_info, delivery_time, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'member_id' => '会员id',
			'real_name' => '姓名',
			'mobile' => '手机号',
			'status' => '是否发货',
			'member_address' => '收货地址',
			'items_info' => '获取商品信息',
			'delivery_time' => '发货时间',
			'create_time' => '下单时间',
			'update_time' => '更新时间',
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
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('real_name',$this->real_name,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('member_address',$this->member_address,true);
		$criteria->compare('items_info',$this->items_info,true);
		$criteria->compare('delivery_time',$this->delivery_time);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GameOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
