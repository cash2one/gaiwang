<?php

/**
 * 投诉建议模型
 * @author wanyun.liu <wanyun_liu@163.com>
 * 
 * This is the model class for table "{{complaint}}".
 *
 * The followings are the available columns in table '{{complaint}}':
 * @property integer $id
 * @property string $linkman
 * @property string $mobile
 * @property string $content
 * @property string $create_time
 * @property integer $source
 */
class Complaint extends CActiveRecord {

    const SOURCE_WEBCAT = 1;
    const SOURCE_MALL = 2;

    public static function getSource() {
        return array(
            self::SOURCE_WEBCAT => '微信',
            self::SOURCE_MALL => '商城'
        );
    }

    public static function showSource($var) {
        $datas = self::getSource();
        return $datas[$var];
    }

    public function tableName() {
        return '{{complaint}}';
    }

    public function rules() {
        return array(
            array('linkman, mobile, content, create_time', 'required'),
            array('source', 'numerical', 'integerOnly' => true),
            array('linkman', 'length', 'max' => 128),
            array('mobile', 'length', 'max' => 45),
            array('create_time', 'length', 'max' => 11),
            array('id, linkman, mobile, content, create_time, source', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'linkman' => '联系人',
            'mobile' => '联系电话',
            'content' => '内容',
            'create_time' => '创建时间',
            'source' => '来源', // （1微信、2网站）
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('linkman', $this->linkman, true);
        $criteria->compare('mobile', $this->mobile, true);

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

}
