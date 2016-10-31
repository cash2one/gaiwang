<?php

/**
 * This is the model class for table "{{nation}}".
 *
 * The followings are the available columns in table '{{nation}}':
 * @property string $id
 * @property string $name
 * @property integer $sort
 * @property string $creater
 * @property string $updater
 * @property string $created_at
 * @property string $updated_at
 */
class Nation extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{nation}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, sort', 'required'),
            array('name','unique'),
            array('creater, created_at', 'required', 'on' => 'insert'),
            array('updater, updated_at', 'required', 'on' => 'update'),
            array('sort', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 128),
            array('creater, updater, created_at, updated_at', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, sort, creater, updater, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'id' => '主键',
            'name' => '名称',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('sort', $this->sort);
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
     * @return Nation the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getId($name)
    {
        $sql = "select id from h_nation where name = '{$name}'";
        $ids = Yii::app()->tr->createCommand($sql)->queryAll();
        if (!$ids) {
            return null;
        }
        return $ids[0]['id'];
    }

    /**
     * 此国家下是否有省份
     * @param int $nationId 国家ID
     * @return bool
     */
    public static function hasProvince($nationId)
    {
        $count = Yii::app()->tr->createCommand()
            ->select('count(id) as count')
            ->from('{{province}}')
            ->where('nation_id=:nation_id', array(':nation_id' => $nationId))
            ->queryScalar();
        return ($count > 0) ? true : false;
    }

}
