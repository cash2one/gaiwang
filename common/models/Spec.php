<?php

/**
 * 商品规格模型
 * @author wencong_lin <183482670@qq.com>
 * 
 * @property string $id
 * @property string $name
 * @property integer $type
 * @property integer $sort
 */
class Spec extends CActiveRecord {

    const TYPE_TEXT = 1;//文字类型
    const TYPE_IMG = 2; //图片类型

    /**
     * 获取规格类型
     * @return array
     */
    public static function type() {
        return array(
            self::TYPE_TEXT => Yii::t('spec', '文字'),
            self::TYPE_IMG => Yii::t('spec', '图片')
        );
    }

    public static function getTypeText($id) {
        $arr = self::type();
        return isset($arr[$id]) ? $arr[$id] : Yii::t('spec', '未知');
    }

    public function tableName() {
        return '{{spec}}';
    }

    public function rules() {
        return array(
            array('name, type', 'required'),
            array('name', 'unique'),
            array('type','verifyType'),
            array('type, sort', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 128),
            array('id, name, type, sort', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('spec', '规格名称'),
            'type' => Yii::t('spec', '类型'),
            'value' => Yii::t('value', '规格值'),
            'sort' => Yii::t('spec', '排序'),
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    protected function afterDelete() {
        parent::afterDelete();
        $specValues = SpecValue::model()->findAll(array(
            'condition' => 'spec_id = ' . $this->id
        ));
        if ($specValues) {
            foreach ($specValues as $sv)
                $sv->delete();
        }
    }
    
    /**
     * 验证规格类型是图片的数据只能保存一条.不可重复
     * @param type $attribute
     * @param type $params
     */
    public function verifyType($attribute, $params){
        $data = $this->findByAttributes(array('type' => self::TYPE_IMG));
        if($this->type == self::TYPE_IMG && isset($data))
            $this->addError($attribute, Yii::t('spec', '图片类型的规格数据已存在,不能重复添加类型为图片的规格数据！'));
    }

}
