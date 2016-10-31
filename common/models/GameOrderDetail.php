<?php

/**
 * This is the model class for table "{{game_order_detail}}".
 *
 * The followings are the available columns in table '{{game_order_detail}}':
 * @property string $id
 * @property integer $store_id
 * @property integer $member_id
 * @property string $real_name
 * @property string $mobile
 * @property string $member_address
 * @property string $order_id
 * @property string $fruit_name
 * @property integer $num
 * @property integer $award_time
 * @property integer $is_price
 * @property string $comment
 * @property integer $comment_status
 * @property integer $comment_time
 */
class GameOrderDetail extends CActiveRecord
{
	const COMMENT_IS = 1;//以评论
	const COMMENT_NO = 0;//未评论

	public $store_name;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{game_order_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('store_id, member_id, real_name, mobile, order_id, fruit_name, num, award_time', 'required'),
			array('store_id, member_id, num, award_time, is_price, comment_status, comment_time', 'numerical', 'integerOnly'=>true),
			array('real_name, mobile, fruit_name', 'length', 'max'=>128),
			array('order_id', 'length', 'max'=>11),
			array('member_address, comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, store_id, member_id, real_name, mobile, member_address, order_id, fruit_name, num, award_time, is_price, comment, comment_status, comment_time', 'safe', 'on'=>'search'),
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
			'store_id' => '店铺ID',
			'member_id' => '会员id',
			'real_name' => '姓名',
			'mobile' => '手机号',
			'member_address' => '收货地址',
			'order_id' => '总订单id',
			'fruit_name' => '水果名称',
			'num' => '水果数量',
			'award_time' => '领奖时间',
			'is_price' => '惊喜大奖0否,1是',
			'comment' => '评论',
			'comment_status' => '评论状态0未评论，1已评论',
			'comment_time' => '评论时间',
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
		$criteria->compare('store_id',$this->store_id);
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('real_name',$this->real_name,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('member_address',$this->member_address,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('fruit_name',$this->fruit_name,true);
		$criteria->compare('num',$this->num);
		$criteria->compare('award_time',$this->award_time);
		$criteria->compare('is_price',$this->is_price);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('comment_status',$this->comment_status);
		$criteria->compare('comment_time',$this->comment_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GameOrderDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
