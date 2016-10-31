<?php

/**
 * 酒店品牌模型
 * @author binbin.liao <277250538@qq.com>
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $sort
 * @property integer $logo
 */
class HotelBrand extends CActiveRecord {

    public function tableName() {
        return '{{hotel_brand}}';
    }

    public function rules() {
        return array(
            array('name', 'required'),
            array('name', 'unique'),
            array('name, description', 'length', 'max' => 128),
            array('description','filter','filter'=>array($o = new CHtmlPurifier(), 'purify')),
            array('sort', 'numerical', 'integerOnly' => true),
            array('sort', 'compare', 'operator' => '<=', 'compareValue' => 255, 'message' => Yii::t('hotelBrand', '{attribute}值不在范围内')),
            array('logo', 'file', 'allowEmpty' => $this->getScenario() == 'update' ? true : false, 'types' => 'jpg,jpeg,gif,png',
                'maxSize' => 1024 * 1024 * 1, 'tooLarge' => Yii::t('hotelBrand', '上传图片最大不能超过1Mb,请重新上传')
            ),
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
            'name' => Yii::t('hotelBrand', '名称'),
            'description' => Yii::t('hotelBrand', '描述'),
            'sort' => Yii::t('hotelBrand', '排序'),
            'logo' => Yii::t('hotelBrand', '标识'),
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
     * 删除之后的操作
     */
    protected function afterDelete() {
        parent::afterDelete();
        if (isset($this->logo))
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $this->logo);
    }

}
