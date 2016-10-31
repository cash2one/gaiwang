<?php

/**
 * 城市大区 模型
 * @property string $id
 * @property string $name
 * @property integer $status
 * @property string $sort
 */
class CityshowRegion extends CActiveRecord
{
    const STATUS_SHOW = 1;
    const STATUS_HIDE = 2;

    /**
     * 大区状态
     * @param int | null $k
     * @return array|mixed|null
     */
    public static function status($k = null)
    {
        $a = array(
            self::STATUS_SHOW => '显示',
            self::STATUS_HIDE => '隐藏',
        );
        if ($k == null) return $a;
        return isset($a[$k]) ? $a[$k] : null;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{cityshow_region}}';
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
            array('status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 32),
            array('sort', 'length', 'max' => 10),
            array('name', 'unique'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, status, sort', 'safe', 'on' => 'search'),
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
            'name' => '大区名称',
            'status' => '状态', //（1.显示，2.隐藏）
            'sort' => '排序',
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
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'sort DESC'
            ),
        ));
    }

    /**
     * 得到所有大区 为下拉菜单
     * @param int $status 大区状态
     * @return array
     */
    public static function getShowCityRegion($status = self::STATUS_SHOW)
    {
        if($status===null){
            $models = CityshowRegion::model()->findAll();
        }else{
            $models = CityshowRegion::model()->findAll(array('condition' => 'status = :s',
                'params' => array(':s' => $status), 'order' => 'sort desc','limit' => '7'));
        }
        
        $areaArr = array();
        foreach ($models as $v) {
            $areaArr[$v->id] = $v->name;
        }
        return $areaArr;
    }

    /**
     * 根据大区ID得到name
     * @param int $rid 大区ID
     * @return mixed
     */
    public static function getRegionName($rid)
    {
        return Yii::app()->db->createCommand()
            ->select('name')
            ->from('{{cityshow_region}}')
            ->where('id = :id', array(':id' => $rid))
            ->queryScalar();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CityshowRegion the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
