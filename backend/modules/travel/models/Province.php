<?php

/**
 * This is the model class for table "{{province}}".
 *
 * The followings are the available columns in table '{{province}}':
 * @property string $id
 * @property string $nation_id
 * @property string $name
 * @property string $code
 * @property string $sort
 * @property string $creater
 * @property string $updater
 * @property string $created_at
 * @property string $updated_at
 */
class Province extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{province}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nation_id, code, name', 'required'),
            array('creater, created_at', 'required', 'on' => 'insert'),
            array('updater, updated_at', 'required', 'on' => 'update'),
            array('nation_id, sort, creater, updater, created_at, updated_at', 'length', 'max' => 11),
            array('code', 'unique'),
            array('code', 'match' ,'pattern'=>'/^[A-Z]+$/', 'message'=>'编码必须为大写字母'),
            array('name', 'length', 'max' => 128),
            array('code', 'length', 'max' => 32),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nation_id, name, code, creater, updater, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'nation' => array(self::BELONGS_TO, 'Nation', 'nation_id', 'select' => 'id,name'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'nation_id' => '国家',
            'name' => '省份名',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('nation_id', $this->nation_id, true);
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
     * @return Province the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getProvince($id)
    {
        $provinces = Yii::app()->tr->createCommand()
            ->from('{{province}}')
            ->where('nation_id=:nation_id', array(':nation_id' => $id))
            ->queryAll();
        if (!$provinces) {
            return null;
        }
        return $provinces;
    }

    /**
     * 此省份下是否有城市
     * @param int $provinceCode 省份code
     * @return bool
     */
    public static function hasCity($provinceCode)
    {
        $count = Yii::app()->tr->createCommand()
            ->select('count(id) as count')
            ->from('{{city}}')
            ->where('province_code=:province_code', array(':province_code' => $provinceCode))
            ->queryScalar();
        return ($count > 0) ? true : false;
    }
}
