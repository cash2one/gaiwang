<?php

/**
 * This is the model class for table "{{hotel_room}}".
 *
 * The followings are the available columns in table '{{hotel_room}}':
 * @property string $id
 * @property string $hotel_id
 * @property string $room_id
 * @property string $name
 * @property integer $num
 * @property string $acreage
 * @property integer $floor
 * @property integer $max_num_of_persons
 * @property string $equipment
 * @property string $equipment_desc
 * @property string $has_net
 * @property string $flag_add_bed
 * @property string $bed_type
 * @property string $add_bed_num
 * @property string $remark
 * @property string $creater
 * @property string $updater
 * @property string $created_at
 * @property string $updated_at
 */
class HotelRoom extends CActiveRecord
{
    const HAND_HOTEL_ROOM_ID_STAR = 50000000;
    public $roomPicture;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{hotel_room}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('hotel_id, room_id, roomPicture, name, num, acreage, max_num_of_persons, equipment_desc, has_net, flag_add_bed, bed_type, add_bed_num, created_at', 'required'),
            array('num, floor, max_num_of_persons, add_bed_num, acreage', 'numerical', 'integerOnly' => true),
            array('hotel_id, room_id, creater, updater, created_at, updated_at', 'length', 'max' => 11),
            array('name, acreage, equipment, equipment_desc, flag_add_bed, bed_type, remark', 'length', 'max' => 128),
            array('has_net, add_bed_num', 'length', 'max' => 56),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, hotel_id, room_id, name, num, acreage, floor, max_num_of_persons, equipment, equipment_desc, has_net, flag_add_bed, bed_type, add_bed_num, remark, creater, updater, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
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
            'name' => '名称',
            'num' => '数量',
            'acreage' => '面积',
            'floor' => '楼层',
            'max_num_of_persons' => '最大入住人数',
            'equipment' => '房间设备',
            'equipment_desc' => '设备描述',
            'has_net' => '网络',
            'flag_add_bed' => '加床',
            'bed_type' => '床型',
            'add_bed_num' => '加床数量',
            'roomPicture' => '房间图片',
            'remark' => '备注',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('hotel_id', $this->hotel_id, true);
        $criteria->compare('room_id', $this->room_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('num', $this->num);
        $criteria->compare('acreage', $this->acreage, true);
        $criteria->compare('floor', $this->floor);
        $criteria->compare('max_num_of_persons', $this->max_num_of_persons);
        $criteria->compare('equipment', $this->equipment, true);
        $criteria->compare('equipment_desc', $this->equipment_desc, true);
        $criteria->compare('has_net', $this->has_net, true);
        $criteria->compare('flag_add_bed', $this->flag_add_bed, true);
        $criteria->compare('bed_type', $this->bed_type, true);
        $criteria->compare('add_bed_num', $this->add_bed_num, true);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('creater', $this->creater, true);
        $criteria->compare('updater', $this->updater, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
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
     * @return HotelRoom the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function createHandHotelRoomId()
    {
        $id = Yii::app()->tr->createCommand()->select('max(room_id)')->from('{{hotel_room}}')->queryScalar();
        if ($id && $id > self::HAND_HOTEL_ROOM_ID_STAR) {
            return $id + 1;
        } else {
            return self::HAND_HOTEL_ROOM_ID_STAR + 1;
        }
    }
}
