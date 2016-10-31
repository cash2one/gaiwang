<?php

/**
 * 会员级别模型
 * @author wencong.lin <183482670@qq.com>
 * 
 * The followings are the available columns in table '{{member_grade}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class MemberGrade extends CActiveRecord {
    //第一个会员级别的id
    const FIRST_ID = 1;

    public function tableName() {
        return '{{member_grade}}';
    }

    public function rules() {
        return array(
            array('name', 'required'),
            array('name', 'unique'),
            array('name', 'length', 'max' => 128),
            array('description', 'length', 'max' => 256),
            array('id, name, description', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('memberGrade', '会员级别'),
            'description' => Yii::t('memberGrade', '描述'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
