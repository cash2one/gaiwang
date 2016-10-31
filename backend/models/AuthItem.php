<?php

/**
 * 管理员角色模型
 * @author wanyun.liu <wanyun_liu@163.com>
 * 
 * @property string $name
 * @property string $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 */
class AuthItem extends CActiveRecord {

    const TYPE_ADMIN = 2;

    public function tableName() {
        return '{{auth_item}}';
    }

    public function rules() {
        return array(
            array('name, description', 'required'),
            array('name, description', 'unique'),
            array('name', 'length', 'max' => 64),
            array('type', 'length', 'max' => 11),
            array('description, bizrule, data', 'safe'),
            array('name, type, description, bizrule, data', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'name' => '角色编号',
            'type' => 'Type',
            'description' => '角色名称',
            'bizrule' => 'Bizrule',
            'data' => 'Data',
        );
    }
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'assigments' => array(self::HAS_ONE,'AuthAssignment',array('itemname'=>'name'),'joinType'=>'JOIN'),
            'authItemChild' => array(self::HAS_ONE,'AuthItemChild',array('parent'=>'name'),'joinType'=>'JOIN'),
        );
    }

    /**
     * 手动设置主键 【with 需要设置主键】
     * @author xuegang.liu@g-email.com
     * @since  2015-08-26T18:34:47+0800
     */
    public function primaryKey(){
        return "name";
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name, true);
        $criteria->compare('type', self::TYPE_ADMIN);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
