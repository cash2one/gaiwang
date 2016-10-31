<?php

/**
 *  运费模板 模型
 *
 *  @author zhenjun_xu <412530435@qq.com>
 * The followings are the available columns in table '{{freight_template}}':
 * @property string $id
 * @property string $name
 * @property string $store_id
 * @property string $store_address_id
 * @property integer $valuation_type
 * @property string $create_time
 */
class FreightTemplate extends CActiveRecord {

    const VALUATION_TYPE_NUM = 1;
    const VALUATION_TYPE_WEIGHT = 2;
    const VALUATION_TYPE_BULK = 3;

    /**
     * 计价方式
     * @param null $k
     * @return array|null
     */
    public static function valuationType($k = null) {
        $arr = array(
            self::VALUATION_TYPE_NUM => Yii::t('freightTemplate', '按件数'),
            self::VALUATION_TYPE_WEIGHT => Yii::t('freightTemplate', '按重量'),
            self::VALUATION_TYPE_BULK => Yii::t('freightTemplate', '按体积'),
        );
        if (is_numeric($k)) {
            return isset($arr[$k]) ? $arr[$k] : null;
        } else {
            return $arr;
        }
    }

    /**
     * 计价方式的计量单位
     * @param $k
     * @return array|null
     */
    public static function unit($k) {
        $arr = array(
            self::VALUATION_TYPE_NUM => Yii::t('freightTemplate', '件'),
            self::VALUATION_TYPE_WEIGHT => Yii::t('freightTemplate', 'kg'),
            self::VALUATION_TYPE_BULK => Yii::t('freightTemplate', 'm³'),
        );
        if (is_numeric($k)) {
            return isset($arr[$k]) ? $arr[$k] : null;
        } else {
            return $arr;
        }
    }

    public function tableName() {
        return '{{freight_template}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('name, store_id, store_address_id, valuation_type', 'required'),
            array('valuation_type', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 128),
            array('create_time', 'default', 'value' => time()),
            array('store_id, store_address_id, create_time', 'length', 'max' => 11),
            array('id, name, store_id, store_address_id, valuation_type, create_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'freightType' => array(self::HAS_MANY, 'FreightType', 'freight_template_id'),
            'StoreAddress'=>array(self::BELONGS_TO,'StoreAddress','store_address_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('freightTemplate', '主键'),
            'name' => Yii::t('freightTemplate', '模板名称'),
            'store_id' => Yii::t('freightTemplate', '所属商家'),
            'store_address_id' => Yii::t('freightTemplate', '发货地址'),
            'valuation_type' => Yii::t('freightTemplate', '计价方式'), //（1按件数，2按重量，3按体积）
            'create_time' => Yii::t('freightTemplate', '创建时间'),
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('store_id', $this->store_id, true);
        $criteria->compare('store_address_id', $this->store_address_id, true);
        $criteria->compare('valuation_type', $this->valuation_type);
        $criteria->compare('create_time', $this->create_time, true);

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
     * 查询运费模板信息
     * @param int $freight_template_id 运费模板id
     * @return array $info
     */
    public static function getFreightInfo($freight_template_id, $field = null) {
        $data = Yii::app()->db->createCommand()->select('t.*,t0.*')
                        ->from('{{freight_template}} AS t')
                        ->leftJoin('{{freight_type}} AS t0', 't0.freight_template_id=t.id')
                        ->where('t.id=' . $freight_template_id)->queryAll();
//        Tool::pr($data);
        if ($data) {
            $info = array();
            foreach ($data as $k => $v) {
                $info[$k]['name'] = $v['name'];
                $info[$k]['store_id'] = $v['store_id'];
                $info[$k]['store_address_id'] = $v['store_address_id'];
                $info[$k]['valuation_type'] = $v['valuation_type'];
                $info[$k]['create_time'] = $v['valuation_type'];
                $info[$k]['default_freight'] = $v['default_freight'];
                $info[$k]['mode'] = $v['mode'];
            }
            if ($field) {
                return $info[0][$field];
            } else {
                return $info;
            }
        }
    }

}
