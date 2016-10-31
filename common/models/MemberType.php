<?php

/**
 *  会员类型模型
 * @author qinghao.ye <qinghaoye@sina.com>
 */
class MemberType extends CActiveRecord {

    const EXCHANGE_YES = 1;
    const EXCHANGE_NO = 0;
    
    const MEMBER_OFFICAL=2;//正式会员
    const MEMBER_EXPENSE=1;//消费会员
    public function tableName() {
        return '{{member_type}}';
    }

    public function rules() {
        return array(
            array('name, ratio', 'required'),
            array('exchange, sort', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 128),
            array('ratio', 'length', 'max' => 5),
            array('name, exchange', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('memberType', '名称'),
            'exchange' => Yii::t('memberType', '兑换现金'),
            'ratio' => Yii::t('memberType', '兑换比率'),
            'sort' => Yii::t('memberType', '排序'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name, true);
        $criteria->compare('exchange', $this->exchange);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'sort DESC',
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 获取是否兑换
     * @return array
     */
    public static function getExchange() {
        return array(
            self::EXCHANGE_YES => Yii::t('memberType', '是'),
            self::EXCHANGE_NO => Yii::t('memberType', '否')
        );
    }
    
    /**
     * 获取会员类型
     * @param null|int $id
     * @return array|string
     */
    public static function getMemberType($id = null) {
        $arr = array(
            self::MEMBER_EXPENSE => Yii::t('memberType', '消费会员'),
            self::MEMBER_OFFICAL => Yii::t('memberType', '正式会员'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotelOrder', '未知'));
    }

    /**
     * GridView中显示状态信息
     * @param int $key
     */
    public static function showExchange($key) {
        $exchange = self::getExchange();
        return $exchange[$key];
    }

    /**
     * 保存后的操作
     */
    protected function afterSave() {
        parent::afterSave();
        self::fileCache(false);
    }

    /**
     * 删除后的操作
     */
    protected function afterDelete() {
        parent::afterDelete();
        self::fileCache(false);
    }

    /**
     * 缓存会员类型
     * 用于前面页面中积分的兑换，换算
     * @param boolean $flag
     * @param return array
     */
    public static function fileCache($flag = true) {
        if ($flag) {
            $types = Tool::cache('common')->get('memberType');
            return !$types ? self::fileCache(false) : $types;
        }
        $types = self::model()->findAll();
        $array = array();
        foreach ($types as $type) {
            $array[$type->id] = $type->ratio;
            if ('消费会员' === $type->name) {
                $array['default'] = $type->ratio;
                $array['defaultType'] = $type->id;
            } elseif ('正式会员' === $type->name) {
                $array['official'] = $type->ratio;
                $array['officialType'] = $type->id;
            }
        }
        Tool::cache('common')->set('memberType', $array, 86400);
        return $array;
    }

}
