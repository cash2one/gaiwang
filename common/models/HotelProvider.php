
<?php

/**
 * This is the model class for table "{{hotel_provider}}".
 *
 * The followings are the available columns in table '{{hotel_provider}}':
 * @property string $id
 * @property string $name
 * @property integer $sort
 */
class HotelProvider extends CActiveRecord {

    /**
     * @return string 相关数据库表名
     */
    public function tableName() {
        return '{{hotel_provider}}';
    }

    /**
     * @return array 模型属性的验证规则
     */
    public function rules() {
        return array(
            array('name', 'required'),
            array('member_id', 'required', 'on' => 'insert'),
            array('name, member_id', 'unique', 'on' => 'insert,update'),
            array('member_id', 'validateEnterpriseMember', 'on' => 'insert'),
            array('sort', 'numerical', 'integerOnly' => true),
            array('sort', 'compare', 'operator' => '<=', 'compareValue' => 255, 'message' => Yii::t('hotelProvider', '{attribute}值不在范围内')),
            array('name', 'length', 'max' => 128),
            array('id, name, sort', 'safe', 'on' => 'search'),
        );
    }

    /**
     * 验证企业会员
     * @param $attribute
     * @param $params
     * @author jianlin.lin
     */
    public function validateEnterpriseMember($attribute, $params) {
        if (!isset(Member::model()->with('enterprise')->findByPk($this->$attribute)->enterprise)) {
            $this->addError($attribute, $this->getAttributeLabel($attribute) . Yii::t('hotelProvider', '必须是企业会员'));
        }
    }

    /**
     * @return array 关系规则
     */
    public function relations() {
        return array(
            'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
        );
    }

    /**
     * @return array 自定义属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('HotelProvider', '供应商名称'),
            'sort' => Yii::t('HotelProvider', '排序'),
            'member_id' => Yii::t('HotelProvider', '所属企业'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->with = 'member';
        $criteria->compare('name', trim($this->name), true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'sort DESC',
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 获取供应商选项
     * @return array
     * @author jianlin.lin
     */
    public static function getProviderOptions() {
        $data = Yii::app()->db->createCommand()->select('id, name')->from('{{hotel_provider}}')->order('sort DESC')->queryAll();
        return CHtml::listData($data, 'id', 'name');
    }
}
