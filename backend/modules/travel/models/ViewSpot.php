<?php

/**
 * This is the model class for table "{{view_spot}}".
 *
 * The followings are the available columns in table '{{view_spot}}':
 * @property string $id
 * @property string $city_card_id
 * @property string $name
 * @property string $description
 * @property string $picture
 * @property string $creater
 * @property string $updater
 * @property string $created_at
 * @property string $updated_at
 */
class ViewSpot extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{view_spot}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('city_card_id, name,name_en, description, picture,creater, created_at', 'required'),
            array('city_card_id, creater, updater, created_at, updated_at', 'length', 'max' => 11),
            array('name, picture', 'length', 'max' => 128),
        
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, city_card_id, name,name_en, description, picture, creater, updater, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'city_card_id' => '城市名片id',
            'name' => '景点名称',
            'name_en' => '英文名称',
            'description' => '景点介绍',
            'picture' => '景点图片',
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
        $criteria->compare('city_card_id', $this->city_card_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('name_en', $this->name_en, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('picture', $this->picture, true);
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
     * @return ViewSpot the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
