<?php

/**
 * This is the model class for table "{{business}}".
 *
 * The followings are the available columns in table '{{business}}':
 * @property string $id
 * @property string $city_code
 * @property string $name
 * @property string $code
 * @property string $sort
 * @property string $creater
 * @property string $updater
 * @property string $created_at
 * @property string $updated_at
 */
class Business extends CActiveRecord
{
    public $nation_id;
    public $province_code;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{business}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('city_code, name, code, created_at', 'required'),
            array('city_code, code', 'length', 'max' => 32),
            array('code', 'match' ,'pattern'=>'/^[A-Z]+$/', 'message'=>'编码必须为大写字母'),
            array('name', 'length', 'max' => 128),
            array('creater, sort, updater, created_at, updated_at', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, city_code, name, code, creater, updater, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'city' => array(self::BELONGS_TO, 'City', '', 'on' => 'city_code=city.code', 'select' => 'province_code,code,name'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'city_code' => '城市编码',
            'name' => '商业区名',
            'code' => '编码',
            'sort' => '排序',
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

        $criteria->with = array('city');
		$criteria->compare('id', $this->id, true);
		$criteria->compare('city_code', $this->city_code, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('code', $this->code, true);
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
     * @return Business the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
