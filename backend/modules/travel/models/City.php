<?php

/**
 * This is the model class for table "{{city}}".
 *
 * The followings are the available columns in table '{{city}}':
 * @property string $id
 * @property string $province_code
 * @property string $name
 * @property string $code
 * @property string $sort
 * @property string $creater
 * @property string $updater
 * @property string $created_at
 * @property string $updated_at
 */
class City extends CActiveRecord
{
    public $nation_id;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{city}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('province_code, name, code', 'required'),
            array('creater, created_at', 'required', 'on' => 'insert'),
            array('updater, updated_at', 'required', 'on' => 'update'),
            array('code', 'unique'),
            array('code', 'match', 'pattern' => '/^[A-Z]+$/', 'message' => '编码必须为大写字母'),
            array('province_code, code', 'length', 'max' => 32),
            array('name', 'length', 'max' => 128),
            array('creater, sort, updater, created_at, updated_at', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, province_code, name, code, creater, updater, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'province' => array(self::HAS_ONE, 'Province', '', 'on' => 'province_code=province.code', 'select' => 'nation_id,code,name'),
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
            'province_code' => '省份编码',
            'name' => '城市名',
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

        $criteria->with = array('province', 'province.nation');
        $criteria->compare('id', $this->id, true);
        $criteria->compare('province_code', $this->province_code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('creater', $this->creater, true);
        $criteria->compare('updater', $this->updater, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        if (!isset($_GET[ucfirst(Yii::app()->controller->id) . '_sort'])) {
            $criteria->order = 't.sort desc';
        }
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
     * @return City the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
