<?php

/**
 * This is the model class for table "{{hotel_picture}}".
 *
 * The followings are the available columns in table '{{hotel_picture}}':
 * @property string $id
 * @property string $hotel_id
 * @property string $room_id
 * @property string $path
 * @property integer $type
 * @property integer $size_type
 * @property integer $sort
 * @property string $creater
 * @property string $created_at
 */
class HotelPicture extends CActiveRecord
{
    const TYPE_FANG_XING = 8;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{hotel_picture}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hotel_id, path, type, creater, created_at', 'required'),
			array('type, size_type, sort', 'numerical', 'integerOnly'=>true),
			array('hotel_id, room_id, creater, created_at', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hotel_id, room_id, path, type, size_type, sort, creater, created_at', 'safe', 'on'=>'search'),
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
            'pType' => array(self::BELONGS_TO,'BaseInfo','','on'=>'t.type=pType.code','select'=>'name','condition'=>'pType.type="HotelImageType"'),
            'hotelRoom' => array(self::BELONGS_TO,'HotelRoom','','on'=>'t.room_id=hotelRoom.room_id','select'=>'hotelRoom.name'),
            'hotel' => array(self::BELONGS_TO,'Hotel','','on'=>'t.hotel_id=hotel.hotel_id','select'=>'hotel.chn_name'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '主键id',
			'hotel_id' => '酒店ID',
			'room_id' => '房间ID',
			'path' => '图片',
			'type' => '类型',
			'size_type' => 'Size Type',
			'sort' => '排序',
			'creater' => '创建人',
			'created_at' => '创建时间',
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

        $criteria->with = array('pType','hotelRoom','hotel');
		$criteria->compare('id',$this->id);
		$criteria->compare('t.hotel_id',$this->hotel_id);
		$criteria->compare('room_id',$this->room_id);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('t.type',$this->type);
		$criteria->compare('size_type',$this->size_type);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('creater',$this->creater);
		$criteria->compare('created_at',$this->created_at);

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
	 * @return HotelPicture the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
