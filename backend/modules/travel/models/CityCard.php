<?php

/**
 * This is the model class for table "{{city_card}}".
 *
 * The followings are the available columns in table '{{city_card}}':
 * @property string $id
 * @property string $name
 * @property string $name_en
 * @property string $city_name
 * @property string $city_code
 * @property string $description
 * @property string $picture
 * @property string $creater
 * @property integer $updater
 * @property string $created_at
 * @property string $updated_at
 */
class CityCard extends CActiveRecord
{
                    public $province,$nation,$city;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{city_card}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,name_en,city_name,created_at', 'required'),
			array('updater', 'numerical', 'integerOnly'=>true),
			array('name, name_en,city_name,city_code description, picture', 'length', 'max'=>255),
			array(' creater, created_at, updated_at', 'length', 'max'=>11),
			array('nation,province,city','length','max'=>128),
			array('id, name, province,nation,name_en, city_code, description, picture, creater, updater, created_at, updated_at', 'safe', 'on'=>'search'),
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
                                               // 'city' => array(self::BELONGS_TO, 'City', 'on' => 'city_code = city.code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '状态',
			'name' => '城市名称名片',
			'name_en' => '英文名',
                                                          'city_name'=>'所属城市',
			'city_code' => '城市编码',
			'description' => '主题介绍',
			'picture' => '主题图片',
			'creater' => 'Creater',
			'updater' => 'Updater',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
                                                          'nation'=>'国家',
                                                          'province'=>'省份',
                                                          'city'=>'城市'
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('city_code',$this->city_code,true);
                                       $criteria->compare('city_name',$this->city_name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('picture',$this->picture,true);		
		$criteria->compare('creater',$this->creater,true);
		$criteria->compare('updater',$this->updater);
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
	 * @return CityCard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
