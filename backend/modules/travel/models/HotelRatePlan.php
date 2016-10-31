<?php

/**
 * This is the model class for table "{{hotel_rate_plan}}".
 *
 * The followings are the available columns in table '{{hotel_rate_plan}}':
 * @property string $id
 * @property string $hotel_id
 * @property string $room_id
 * @property string $rate_plan_id
 * @property string $rate_plan_name
 * @property string $bed_type
 * @property string $commend_level
 * @property string $pay_method
 * @property string $supply_name
 * @property string $notices
 * @property string $creater
 * @property string $updater
 * @property string $created_at
 * @property string $updated_at
 */
class HotelRatePlan extends CActiveRecord
{
    const HAND_RATE_PLAN_ID_STAR = 50000000;


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{hotel_rate_plan}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hotel_id, room_id, rate_plan_id, rate_plan_name, bed_type, commend_level, pay_method, supply_name, notices, created_at', 'required'),
			array('hotel_id, room_id, rate_plan_id, commend_level, pay_method, notices, creater, updater, created_at, updated_at', 'length', 'max'=>11),
			array('rate_plan_name, bed_type, supply_name', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hotel_id, room_id, rate_plan_id, rate_plan_name, bed_type, commend_level, pay_method, supply_name, notices, creater, updater, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'id' => '主键id',
			'hotel_id' => '酒店id',
			'room_id' => '房间id',
			'rate_plan_id' => '价格计划ID',
			'rate_plan_name' => '价格计划名称',
			'bed_type' => '床型',
			'commend_level' => '推荐级别',
			'pay_method' => '支付方式',
			'supply_name' => '供应商',
			'notices' => '通知',
			'creater' => '创建人',
			'updater' => '更新人',
			'created_at' => '创建时间',
			'updated_at' => '更新时间',
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
		$criteria->compare('hotel_id',$this->hotel_id,true);
		$criteria->compare('room_id',$this->room_id,true);
		$criteria->compare('rate_plan_id',$this->rate_plan_id,true);
		$criteria->compare('rate_plan_name',$this->rate_plan_name,true);
		$criteria->compare('bed_type',$this->bed_type,true);
		$criteria->compare('commend_level',$this->commend_level,true);
		$criteria->compare('pay_method',$this->pay_method,true);
		$criteria->compare('supply_name',$this->supply_name,true);
		$criteria->compare('notices',$this->notices,true);
		$criteria->compare('creater',$this->creater,true);
		$criteria->compare('updater',$this->updater,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->tr;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HotelRatePlan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * 生成手工添加价格计划ID
     * @return int
     */
    public static function createHandRatePlanID()
    {
        $id = Yii::app()->tr->createCommand()->select('max(rate_plan_id)')->from('{{hotel_rate_plan}}')->queryScalar();
        if ($id && $id > self::HAND_RATE_PLAN_ID_STAR) {
            return $id + 1;
        } else {
            return self::HAND_RATE_PLAN_ID_STAR + 1;
        }
    }
}
