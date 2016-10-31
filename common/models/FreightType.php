<?php

/**
 *  运费类型 模型
 *
 *  @author zhenjun_xu <412530435@qq.com>
 * The followings are the available columns in table '{{freight_type}}':
 * @property string $id
 * @property string $freight_template_id
 * @property integer $mode
 * @property string $default
 * @property string $default_freight
 * @property string $added
 * @property string $added_freight
 */
class FreightType extends CActiveRecord {
    //计费默认参数

    const PARAM_DEFAULT = '1.00';
    const PARAM_DEFAULT_FREIGHT = 0.00;
    const PARAM_ADDED = '1.00';
    const PARAM_ADDED_FREIGHT = 0.00;

    //运输类型（1快递，2EMS，3平邮）
    const MODE_FASTMAIL = 1; //快递
    const MODE_EMS = 2; //EMS
    const MODE_SURFACEMAIL = 3; //平邮

    /**
     * 运送方式 （1快递，2EMS，3平邮）
     * @param int|null $k
     * @return array|null
     */

    public static function mode($k = null) {
        $arr = array(
            self::MODE_FASTMAIL => Yii::t('freightTemplate', '快递'),
            self::MODE_EMS => Yii::t('freightTemplate', 'EMS'),
            self::MODE_SURFACEMAIL => Yii::t('freightTemplate', '平邮'),
        );
        if (is_numeric($k)) {
            return isset($arr[$k]) ? $arr[$k] : null;
        } else {
            return $arr;
        }
    }

    public function tableName() {
        return '{{freight_type}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('freight_template_id, mode, default, default_freight, added, added_freight', 'required'),
            array('mode', 'numerical', 'integerOnly' => true),
            array('id, freight_template_id', 'length', 'max' => 11),
            array('default,added','match','pattern'=>'/[0-9]+\.[0-9]+/','message'=>'输入格式(1.00或者0.00)'),
            array('default_freight,added_freight','compare','compareValue'=>'0','operator'=>'>=','message'=>'必须大于0'),//首费,续费不能为负数
            array('default, default_freight, added, added_freight', 'length', 'max' => 9),
            array('id, freight_template_id, mode, default, default_freight, added, added_freight', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'freightTemplate' => array(self::BELONGS_TO, 'FreightTemplate', 'freight_template_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('freightType', '主键'),
            'freight_template_id' => Yii::t('freightType', '运费模板'),
            'mode' => Yii::t('freightType', '运送方式'), //（1快递，2EMS，3平邮）
            'default' => Yii::t('freightType', '首量'),
            'default_freight' => Yii::t('freightType', '首费'),
            'added' => Yii::t('freightType', '续量'),
            'added_freight' => Yii::t('freightType', '续费'),
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('freight_template_id', $this->freight_template_id, true);
        $criteria->compare('mode', $this->mode);
        $criteria->compare('default', $this->default, true);
        $criteria->compare('default_freight', $this->default_freight, true);
        $criteria->compare('added', $this->added, true);
        $criteria->compare('added_freight', $this->added_freight, true);

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

    /**
     * 查询运输方式
     * @param int $freightTemplateId  运费模板id
     * @return array
     */
    public static function getFreightType($freightTemplateId) {
       $data= Yii::app()->db->createCommand()
                ->from('{{freight_type}}')
                ->where('freight_template_id='.$freightTemplateId)
                ->queryAll();
        return $data;
       
    }

}
