<?php

/**
 * 酒店热门地址模型
 * @author binbin.liao  <277250538@qq.com>
 * The followings are the available columns in table '{{hotel_address}}':
 * @property string $id
 * @property string $name
 * @property string $content
 * @property integer $sort
 * @property string $countries_id
 * @property string $province_id
 * @property string $city_id
 * @property string $lng
 * @property string $lat
 */
class HotelAddress extends CActiveRecord {

    public function tableName() {
        return '{{hotel_address}}';
    }

    public function rules() {
        return array(
            array('name, countries_id, province_id, city_id, lng, lat', 'required'),
            array('name', 'unique'),
            array('content','filter','filter'=>array($o = new CHtmlPurifier(), 'purify')),
            array('sort', 'numerical', 'integerOnly' => true),
            array('sort', 'compare', 'operator' => '<=', 'compareValue' => 255, 'message' => Yii::t('hotelAddress', '{attribute}值不在范围内')),
            array('name', 'length', 'max' => 128),
            array('id, name, content, sort, countries_id, province_id, city_id, lng, lat', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('hotelAddress', '名称'),
            'content' => Yii::t('hotelAddress', '说明'),
            'sort' => Yii::t('hotelAddress', '排序'),
            'countries_id' => Yii::t('hotelAddress', '国家'),
            'province_id' => Yii::t('hotelAddress', '省份'),
            'city_id' => Yii::t('hotelAddress', '城市'),
            'lng' => Yii::t('hotelAddress', '经度'),
            'lat' => Yii::t('hotelAddress', '纬度'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('name', trim($this->name), true);
        $criteria->compare('countries_id', $this->countries_id);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('city_id', $this->city_id);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'sort DESC, id DESC',
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 获取酒店热点选项数据
     * @return array
     */
    public static function getAddressOptions() {
        $res = yii::app()->db->createCommand()->select('id, name')->from('{{hotel_address}}')->order('sort DESC')->queryAll();
        return CHtml::listData($res, 'id', 'name');
    }

}
