<?php

/**
 * 兴趣爱好模型
 * @author jianlin_lin <hayeslam@163.com>
 *
 * @property integer $id
 * @property string $name
 * @property integer $category_id
 */
class Interest extends CActiveRecord {

    public function tableName() {
        return '{{interest}}';
    }

    public function rules() {
        return array(
            array('name', 'required'),
            array('name', 'unique'),
            array('category_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 128),
            array('name', 'checkName', 'on' => 'insert,update'),
            array('id, name, category_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('interest', '爱好名称'),
            'category_id' => Yii::t('interest', '所属分类'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('category_id', $this->category_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 检查爱好名称是否已存在
     * @param type $attribute
     * @param type $params
     */
    public function checkName($attribute, $params) {
        if ($this->find('name = :name And category_id = :catid', array('name' => $this->name, 'catid' => $this->category_id)))
            $this->addError($attribute, Yii::t('interest', '相同分类不可重复相同爱好名称！'));
    }

}
