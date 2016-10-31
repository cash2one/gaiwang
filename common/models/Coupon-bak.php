<?php

/**
 * This is the model class for table "{{coupon}}".
 *
 * The followings are the available columns in table '{{coupon}}':
 * @property string $id
 * @property string $price
 * @property string $valid_start
 * @property string $valid_end
 * @property string $create_time
 * @property string $use_time
 * @property integer $status
 * @property string $coupon_activity_id
 * @property string $member_id
 *
 * The followings are the available model relations:
 * @property CouponActivity $couponActivity
 * @property Member $member
 */
class Coupon extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{coupon}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price, valid_start, valid_end, create_time, use_time, coupon_activity_id, member_id', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('price, valid_start, valid_end, use_time, coupon_activity_id, member_id', 'length', 'max'=>11),
			array('create_time', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, price, valid_start, valid_end, create_time, use_time, status, coupon_activity_id, member_id', 'safe', 'on'=>'search'),
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
			'couponActivity' => array(self::BELONGS_TO, 'CouponActivity', 'coupon_activity_id'),
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '主键',
			'price' => '面值',
			'valid_start' => '有效时间（开始）',
			'valid_end' => '有效时间（结束）',
			'create_time' => '创建时间',
			'use_time' => '使用时间',
			'status' => '状态（0未使用、1已使用）',
			'coupon_activity_id' => '所属活动',
			'member_id' => '所属会员',
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
		$criteria->compare('price',$this->price,true);
		$criteria->compare('valid_start',$this->valid_start,true);
		$criteria->compare('valid_end',$this->valid_end,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('use_time',$this->use_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('coupon_activity_id',$this->coupon_activity_id,true);
		$criteria->compare('member_id',$this->member_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Coupon the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    //状态（0未使用、1已使用）
    const STATE_FREE = 0;
    const STATE_USED = 1;

    public static function getCouponState($key = null){
        $arr = array(
            self::STATE_FREE => Yii::t('coupon', '未使用'),
            self::STATE_USED => Yii::t('coupon', '已使用'),
        );
        return $key == null ? $arr : $arr[$key];
    }
}
