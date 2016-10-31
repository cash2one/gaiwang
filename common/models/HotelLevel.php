<?php

/**
 * 酒店等级模型
 * @author binbin.liao <277250538@qq.com>
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $sort
 */
class HotelLevel extends CActiveRecord {

    public function tableName() {
        return '{{hotel_level}}';
    }

    public function rules() {
        return array(
            array('name', 'required'),
            array('name', 'unique'),
            array('description','filter','filter'=>array($o = new CHtmlPurifier(), 'purify')),
            array('sort', 'numerical', 'integerOnly' => true),
            array('sort', 'compare', 'operator' => '<=', 'compareValue' => 255, 'message' => Yii::t('hotelLevel', '{attribute}值不在范围内')),
            array('name, description', 'length', 'max' => 128),
            array('id, name, description, sort', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('hotelLevel', '名称'),
            'description' => Yii::t('hotelLevel', '描述'),
            'sort' => Yii::t('hotelLevel', '排序'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name, true);
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
     * 获取酒店级别选项数据
     * @return array
     */
    public static function getLevelOptions() {
        $res = Yii::app()->db->createCommand()->select('id, name')->from('{{hotel_level}}')->order('sort DESC')->queryAll();
        return CHtml::listData($res, 'id', 'name');
    }

}
