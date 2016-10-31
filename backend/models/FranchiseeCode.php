<?php

/**
 * This is the model class for table "{{franchisee_code}}".
 *
 * The followings are the available columns in table '{{franchisee_code}}':
 * @property string $id
 * @property string $code
 * @property integer $status
 * @property string $create_time
 */
class FranchiseeCode extends CActiveRecord {

    public $endTime;  //结束时间
    public $num;   //预设生成加盟商个数
    public $isExport;   //是否导出excel

    const USED = 1;
    const UNUSED = 0;
    const NUMBER = 100;  //批量生成预设加盟商个数

    public static function getStatic($key = null) {
        $arr = array(
            self::USED => Yii::t('Franchisee', '已使用'),
            self::UNUSED => Yii::t('Franchisee', '未使用'),
        );
        return isset($key) ? $arr[$key] : $arr;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{franchisee_code}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('num', 'numerical', 'integerOnly' => true, 'message' => Yii::t('Franchisee', '{attribute} 需要是正整数')),
            array('id, num,code, status, create_time', 'safe', 'on' => 'search'),
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
            'code' => Yii::t('Franchisee', '加盟商编号'),
            'status' => Yii::t('Franchisee', '是否使用'),
            'create_time' => Yii::t('Franchisee', '创建时间'),
            'endTime' => Yii::t('Franchisee', '结束时间'),
            'num' => Yii::t('Franchisee', '生成预设加盟商编号个数'),
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
        $criteria->compare('code', $this->code, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('create_time', '>=' . strtotime($this->create_time));
        if ($this->endTime)
            $criteria->compare('create_time', '<' . (strtotime($this->endTime) + 86400));
        $criteria->order = 'create_time desc';
        $criteria->group = 'create_time';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    
    public function exportSearch() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('create_time',$this->create_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize'=>  self::NUMBER),
        ));
    }
    
    /**
     * 查询预设生成加盟商数据
     */
    public static function expotFranchiseeCode($time){
        $data = self::model()->findAllByAttributes(array('create_time'=>$time));
        if(empty($data))
            return false;
        return $data;
    }

    /**
     * 生成唯一编码
     * @return string
     */
    public static function generateUniqueCode() {
        $code = str_pad(mt_rand(), Franchisee::FRANCHISEE_CODE_LENGTH, '0', STR_PAD_LEFT);
        if (self::model()->exists('code = :code', array(':code' => $code)))
            self::generateUniqueCode();
        return $code;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FranchiseeCode the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
