<?php

/**
 *  网签进度记录 模型
 *
 * The followings are the available columns in table '{{enterprise_log}}':
 * @property string $id
 * @property integer $status
 * @property string $content
 * @property string $auditor
 * @property string $enterprise_id
 * @property int $process
 * @property int $create_time
 * @property string $error_field
 *
 * The followings are the available model relations:
 * @property Enterprise $enterprise
 */
class EnterpriseLog extends CActiveRecord {

    const STATUS_PASS = 1;
    const STATUS_NO = 2;
    const STATUS_NOT_PASS = 3;
    const IS_REMARTS = 1;
    const IS_KEY_RETURN = 1;
    const NOT_KEY_RETURN = 0;

    /**
     * 审核状态
     * @param null $k
     * @return array|null
     */
    public static function getStatus($k = null) {
        $arr = array(
            self::STATUS_PASS => '通过',
            self::STATUS_NO => '未审核',
            self::STATUS_NOT_PASS => '不通过',
        );
        if ($k == null)
            return $arr;
        return isset($arr[$k]) ? $arr[$k] : null;
    }

    const PROCESS_ADD = 1;
    const PROCESS_CHECK_INFO_ZHAOSHANG = 2;
    const PROCESS_CHECK_INFO_ZHAOSHANG_OK = 3;
    const PROCESS_CHECK_INFO_FAWU = 4;
    const PROCESS_CHECK_INFO_FAWU_OK = 5;
    const PROCESS_CHECK_PAPER_ZHAOSHANG = 6;
    const PROCESS_CHECK_PAPER_ZHAOSHANG_OK = 7;
    const PROCESS_CHECK_PAPER_FAWU = 8;
    const PROCESS_CHECK_PAPER_FAWU_OK = 9;
    const PROCESS_LAST_OK = 10;
    const PROCESS_OPEN_STORE = 11;
    const PROCESS_OPEN_STORE_OK = 12;
    const PROCESS_CLOSE_STORE = 13;

    /**
     * 审核进度
     * @param null $k
     * @return array|null
     */
    public static function getProcess($k = null) {
        $arr = array(
            self::PROCESS_ADD => '会员提交资质电子档',
            self::PROCESS_CHECK_INFO_ZHAOSHANG => '等待招商专员审核资质电子档',
            self::PROCESS_CHECK_INFO_ZHAOSHANG_OK => '招商专员审核资质电子档成功',
            self::PROCESS_CHECK_INFO_FAWU => '等待法务专员审核资质电子档',
            self::PROCESS_CHECK_INFO_FAWU_OK => '法务专员审核资质电子档成功',
            self::PROCESS_CHECK_PAPER_ZHAOSHANG => '等待招商专员审核纸质合同资质',
            self::PROCESS_CHECK_PAPER_ZHAOSHANG_OK => '招商专员审核纸质合同资质成功',
            self::PROCESS_CHECK_PAPER_FAWU => '等待法务专员审核纸质合同资质',
            self::PROCESS_CHECK_PAPER_FAWU_OK => '法务专员审核纸质合同资质成功',
            self::PROCESS_LAST_OK => '纸质合同审核成功并归档',
            self::PROCESS_OPEN_STORE => '待开店',
            self::PROCESS_OPEN_STORE_OK => '开店成功',
            self::PROCESS_CLOSE_STORE => '关闭店铺',
        );
        if ($k == null)
            return $arr;
        return isset($arr[$k]) ? $arr[$k] : null;
    }

    public function tableName() {
        return '{{enterprise_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('status, content, auditor, enterprise_id', 'required' ),
            array('status', 'numerical', 'integerOnly' => true),
            array('content', 'length', 'max' => 256),
            array('auditor', 'length', 'max' => 128),
            array('enterprise_id', 'length', 'max' => 11),
            array('error_field', 'safe'),
            array('id, status, content, auditor, enterprise_id', 'safe', 'on' => 'search'),           
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'enterprise' => array(self::BELONGS_TO, 'Enterprise', 'enterprise_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('enterpriseLog', '主键'),
            'status' => Yii::t('enterpriseLog', '审核状态（1通过、2不通过）'),
            'content' =>$this->is_remarts?Yii::t('enterpriseLog', '添加备注'): Yii::t('enterpriseLog', '审核内容'),
            'auditor' => Yii::t('enterpriseLog', '审核人'),
            'enterprise_id' => Yii::t('enterpriseLog', '企业会员id'),
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('auditor', $this->auditor, true);
        $criteria->compare('enterprise_id', $this->enterprise_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array(
            //'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
