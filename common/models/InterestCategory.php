<?php

/**
 * 兴趣爱好分类模型
 * @author jianlin_lin <hayeslam@163.com>
 * 
 * @property integer $id
 * @property string $name
 */
class InterestCategory extends CActiveRecord {

    public function tableName() {
        return '{{interest_category}}';
    }

    public function rules() {
        return array(
            array('name', 'required'),
            array('name', 'length', 'max' => 128),
            array('name', 'unique', 'on' => 'insert,update'),
            array('id, name', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'interest'=>array(self::HAS_MANY,'Interest','category_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('interestCategory', '分类名称'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 获取兴趣爱好分类
     * @return array
     */
    public function getCategoryList() {
        $model = InterestCategory::model()->findAll();
        return CHtml::listData($model, 'id', 'name');
    }

    /**
     * 获取分类名称
     * @param type $id
     * @return string
     */
    public function getCategoryName($id) {
        $name = InterestCategory::model()->find('id = :id', array('id' => $id))->name;
        return empty($name) ? Yii::t('interestCategory', '未知分类') : $name;
    }

}
