<?php

/**
 * 商品规格值模型
 * @author wencong_lin <183482670@qq.com>
 * 
 * @property string $id
 * @property string $name
 * @property string $spec_id
 * @property string $thumbnail
 * @property integer $sort
 */
class SpecValue extends CActiveRecord {

    public function tableName() {
        return '{{spec_value}}';
    }

    public function rules() {
        return array(
            array('name', 'required'),
            array('name', 'unique'),
            array('sort', 'numerical', 'integerOnly' => true),
            array('name, thumbnail', 'length', 'max' => 128),
            array('spec_id', 'length', 'max' => 11),
            array('type', 'safe'),
            array('id, name, spec_id, thumbnail, sort', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'spec' => array(self::BELONGS_TO, 'Spec', 'spec_id')
        );
    }

    public function attributeLabels() {
        return array(
            'sort' => Yii::t('specValue', '排序'),
            'name' => Yii::t('specValue', '名称'),
            'spec_id' => Yii::t('specValue', '商品规格'),
            'thumbnail' => Yii::t('specValue', '图片'),
        );
    }

    public function search() {

        $criteria = new CDbCriteria;
//        $criteria->with = 'spec';
        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('spec_id', $this->spec_id, true);
        $criteria->compare('thumbnail', $this->thumbnail, true);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * 设置规格值
     * @param object $model
     */
    public static function setSpecValue($model) {
        $specValus = Yii::app()->db->createCommand()
                ->select(array('name'))
                ->from($model->tableName())
                ->where('spec_id=:sid', array(':sid' => $model->spec_id))
                ->queryColumn();
        $array = implode(',', $specValus);

        Spec::model()->updateByPk($model->spec_id, array('value' => $array));
    }

    protected function afterDelete() {
        parent::afterDelete();
        if ($this->thumbnail)
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $this->thumbnail);
    }

}
