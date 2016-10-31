<?php

/**
 * This is the model class for table "{{gft_nopwd_pay_limit_setting}}".
 *
 * The followings are the available columns in table '{{gft_nopwd_pay_limit_setting}}':
 * @property string $id
 * @property string $pay_limit
 * @property string $author_id
 * @property string $create_time
 * @property string $update_time
 */
class GftNopwdPayLimitSetting extends CActiveRecord {

    const GFT_NOPWD_PAY_LIMIT_SETTING_CACHE_KEY = 'gft_nopwd_pay_limit_setting_cache';
    const IS_OPEN = 1;  //开启
    const IS_CLOSE = 0; //关闭

    public static function getStatus($key = null) {
        $arr = array(
            self::IS_CLOSE => Yii::t('nopwd', '关闭'),
            self::IS_OPEN => Yii::t('nopwd', '开启'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : "";
        } else {
            return $arr;
        }
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return self::getTableName();
    }

    public static function getTableName() {
        return '{{gft_nopwd_pay_limit_setting}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pay_limit, author_id', 'required'),
            array('pay_limit', 'unique'),
            array('pay_limit', 'numerical'),
            array('pay_limit, author_id, create_time, update_time', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, pay_limit, author_id, create_time, update_time', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate() {

        if ($this->isNewRecord) {
            $this->create_time = time();
        }

        $this->update_time = time();
        $this->author_id = Yii::app()->user->id;
        return true;
    }

    public function afterSave() {

        self::syncRedis();
        return true;
    }

    public function afterDelete() {

        self::syncRedis();
        return true;
    }

    /**
     * 同步缓存
     */
    public static function syncRedis() {

        $dataArr = Yii::app()->db->createCommand()
                ->select('id,pay_limit')
                ->from(self::getTableName())
                ->order('pay_limit asc')
                ->queryAll();

        $cacheDataArr = array();
        foreach ((array) $dataArr as $key => $value) {
            $cacheDataArr[$value['id']] = $value['pay_limit'];
        }

        $cacheKey = self::GFT_NOPWD_PAY_LIMIT_SETTING_CACHE_KEY;
        $fullCacheKey = $cacheKey . 'config';
        $string = serialize($cacheDataArr);

        if (Tool::cache($fullCacheKey)->get($cacheKey)) {
            Tool::cache($fullCacheKey)->set($cacheKey, $string);
        } else {
            Tool::cache($fullCacheKey)->add($cacheKey, $string);
        }

        //更新orderapi项目redis网站配置缓存
        Tool::orderApiPost('config/updateCache', array(
            'configName' => $fullCacheKey,
            'value' => $string
        ));
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
            'pay_limit' => '免密支付额度',
            'author_id' => '操作人id',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
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
        $criteria->compare('pay_limit', $this->pay_limit, true);
        $criteria->compare('author_id', $this->author_id, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GftNopwdPayLimitSetting the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
