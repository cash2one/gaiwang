<?php

/**
 * This is the model class for table "{{franchisee_groupbuy_picture}}".
 *
 * The followings are the available columns in table '{{franchisee_groupbuy_picture}}':
 * @property string $id
 * @property string $path
 * @property string $franchisee_groupbuy_id
 * @property integer $sort
 *
 * The followings are the available model relations:
 * @property FranchiseeGroupbuy $franchiseeGroupbuy
 */
class FranchiseeGroupbuyPicture extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{franchisee_groupbuy_picture}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sort', 'numerical', 'integerOnly' => true),
            array('path', 'length', 'max' => 255),
            array('franchisee_groupbuy_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, path, franchisee_groupbuy_id, sort', 'safe', 'on' => 'search'),
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
            'franchiseeGroupbuy' => array(self::BELONGS_TO, 'FranchiseeGroupbuy', 'franchisee_groupbuy_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'path' => '列表图片',
            'franchisee_groupbuy_id' => 'Franchisee Groupbuy',
            'sort' => 'Sort',
        );
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->franchisee_groupbuy_id = FranchiseeGroupbuy::model()->id;
                $this->path = FranchiseeGroupbuy::model()->thumbnail;
                $this->sort = 0;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
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
        $criteria->compare('path', $this->path, true);
        $criteria->compare('franchisee_groupbuy_id', $this->franchisee_groupbuy_id, true);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => empty($this->pageSize) ? 20 : $this->pageSize, //分页
            ),
            'sort' => array(//'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }

    public function searchAll()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('franchisee_groupbuy_id', $this->franchisee_groupbuy_id, true);
        $criteria->compare('path', $this->path);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
            'sort' => array(//'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FranchiseeGroupbuyPicture the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 查询团购对应的图片列表
     * @param $franchisee_groupbuy_id 团购id
     * @return CActiveRecord[]
     */
    public static function getImgList($franchisee_groupbuy_id)
    {
        return self::model()->findAll('franchisee_groupbuy_id=:franchisee_groupbuy_id', array(':franchisee_groupbuy_id' => $franchisee_groupbuy_id));
    }
}
