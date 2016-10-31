<?php
/**
 *  商品属性值模型
 * @author binbin.liao <277250538@qq.com>
 * The followings are the available columns in table '{{attribute_value}}':
 * @property string $id
 * @property string $name
 * @property string $attribute_id
 * @property integer $sort
 */
class AttributeValue extends CActiveRecord {

    public function tableName() {
        return '{{attribute_value}}';
    }

    public function rules() {
        return array(
            array('name', 'required'),
            array('name','safe'),
            array('sort', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 128),
            array('id, name, attribute_id, sort', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'attrName'=>array(self::BELONGS_TO,'Attribute','attribute_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('attributeValue', '主键'),
            'name' => Yii::t('attributeValue', '属性值'),
            'attribute_id' => Yii::t('attributeValue', '所属属性'),
            'sort' => Yii::t('attributeValue', '排序'),
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('attribute_id', $this->attribute_id, true);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array(
            'defaultOrder'=>'id DESC', //设置默认排序
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
