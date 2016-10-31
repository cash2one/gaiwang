<?php

/**
 * This is the model class for table "{{franchisee_brand}}".
 *
 * The followings are the available columns in table '{{franchisee_brand}}':
 * @property string $id
 * @property string $name
 * @property string $pinyin
 * @property integer $sort
 *
 * The followings are the available model relations:
 * @property FranchiseeGroupbuy[] $franchiseeGroupbuys
 */
class FranchiseeBrand extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{franchisee_brand}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, pinyin', 'required'),
            array('name', 'unique', 'message' => '加盟商品牌已存在'),
            array('sort', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 128),
            array('pinyin', 'length', 'max' => 64),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, pinyin, sort', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'franchiseeGroupbuys' => array(self::HAS_MANY, 'FranchiseeGroupbuy', 'franchisee_brand_id'),
            'franchisee'=>array(self::HAS_MANY,'Franchisee','franchisee_brand_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('franchiseeBrand', '品牌序号'),
            'name' => Yii::t('franchiseeBrand', '品牌名称'),
            'pinyin' => Yii::t('franchiseeBrand', '品牌名称（首字母）'),
            'sort' => Yii::t('franchiseeBrand', '排序'),
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('pinyin', $this->pinyin, true);
        $criteria->compare('sort', $this->sort);
        $criteria->order = 'sort asc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'pinyin ASC',
            ),
        ));
    }

    public function search2($py = null) {
        $criteria = new CDbCriteria;
        if ($py) {
            $criteria->addCondition('t.pinyin=:py');
            $criteria->params = array(':py' => $py);
        }else{
            $criteria->compare('t.id', $this->id,true);
        }
        
        $criteria->order = 't.id DESC';
        return $criteria;
    }

    public static function getFranchiseeBrandName($id) {
        $data = self::model()->findByPk($id);
        if ($data) {
            return $data->name;
        } else {
            return '';
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FranchiseeBrand the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
