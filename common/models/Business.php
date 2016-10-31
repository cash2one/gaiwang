<?php

/**
 * This is the model class for table "{{business}}".
 *
 * The followings are the available columns in table '{{business}}':
 * @property integer $id
 * @property string $cont
 * @property string $store
 */
class Business extends CActiveRecord {

    public $branch;       //分公司名称
    public $create_time;   //创建时间
    public $update_time;  //更新时间
    public $gai_number;   //盖网会员编号

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return '{{business}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('store', 'required'),
            array('store', 'length', 'max'=>20,'min'=>2),
//            array('year,month,day,num','length','max'=>4,'min'=>1),
//            array('year,month,day,num','numerical', 'integerOnly'=>true,'min'=>0,'message'=>Yii::t('home','{attribute} 需要是正整数')),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cont, store', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cont' => 'Cont',
            'store' => '母公司/总公司',
            'branch' => '分公司',
            'storeAgent' => '总公司代理人',
            'branchAgent' => '分公司代理人',
            'storeA' => '甲方',
            'storeB' => '乙方',
            'year' => '年',
            'month' => '月',
            'day' => '日',
            'num' => '份数',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('cont', $this->cont, true);
        $criteria->compare('store', $this->store, true);
        $criteria->order = 'update_time desc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Business the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->create_time = time();
                $this->update_time = time();
                if(isset(Yii::app()->User->gw)){
                        $this->gai_number = Yii::app()->User->gw;
                    }
            } else {
                $this->update_time = time();
            }
            return true;
        } else
            return false;
    }

}
