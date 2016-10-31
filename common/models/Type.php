<?php

/**
 * 商品类型 模型 跟商品分类关联的
 * @author binbin.liao  <277250538@qq.com>
 * The followings are the available columns in table '{{type}}':
 * @property string $id
 * @property string $name
 * @property integer $sort
 */
class Type extends CActiveRecord {

    public function tableName() {
        return '{{type}}';
    }

    public function rules() {
        return array(
            array('name', 'required'),
            array('name','unique'),
            array('name, sort', 'safe'),
            array('sort', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 128),
            array('id, name, sort', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('type', 'ID'),
            'name' => Yii::t('type', '名称'),
            'sort' => Yii::t('type', '排序'),
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
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

    public function afterDelete() {
        parent::afterDelete();
        TypeBrand::model()->deleteAll('type_id IN('.$this->id.')');//删除与品牌的关联数据
        TypeSpec::model()->deleteAll('type_id IN('.$this->id.')');//删除与规格关联数据
        $attrdata=  Attribute::model()->findAll('type_id='.$this->id);//查询这个类型下的所有属性
        //删除属性对应的属性值数据
        foreach ($attrdata as $v){
            AttributeValue::model()->deleteAll('attribute_id='.$v->id);
        }
        Attribute::model()->deleteAll('type_id IN('.$this->id.')');//删除与属性对应的数据
    }
}
