<?php

/**
 * This is the model class for table "{{hot_address}}".
 *
 * The followings are the available columns in table '{{hot_address}}':
 * @property string $id
 * @property string $name
 * @property string $introduce
 * @property string $city_code
 * @property string $longitude
 * @property string $latitude
 * @property string $creater
 * @property string $updater
 * @property string $created_at
 * @property string $updated_at
 */
class HotAddress extends CActiveRecord
{
    public $nation_id;
    public $province_code;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{hot_address}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, nation_id, province_code, city_code, longitude, latitude, creater, created_at', 'required'),
            array('name', 'length', 'max' => 128),
            array('city_code, longitude, latitude', 'length', 'max' => 32),
            array('creater, updater, created_at, updated_at', 'length', 'max' => 11),
            array('introduce', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, introduce, nation_id, province_code, city_code, longitude, latitude, creater, updater, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'city' => array(self::HAS_ONE, 'City', '', 'on' => 't.city_code=city.code', 'select' => 'province_code,code,name'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => '地址名称',
            'introduce' => '介绍',
            'city_code' => '城市编码',
            'longitude' => '经度',
            'latitude' => '纬度',
            'creater' => '创建人',
            'updater' => '更新人',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'nation_id' => '国家',
            'province_code' => '省份',
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
        $criteria->with = array('city', 'city.province', 'city.province.nation');
        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('introduce', $this->introduce, true);
        $criteria->compare('city_code', $this->city_code, true);
        $criteria->compare('longitude', $this->longitude, true);
        $criteria->compare('latitude', $this->latitude, true);
        $criteria->compare('creater', $this->creater);
        $criteria->compare('updater', $this->updater);
        $criteria->compare('created_at', $this->created_at);
        $criteria->compare('updated_at', $this->updated_at);
        $criteria->compare('province.code', $this->province_code);
        $criteria->compare('nation.id', $this->nation_id);
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
     * @return HotAddress the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
