<?php
/**
 * 翻译英文模型
 * @author qinghao.ye <qinghaoye@sina.com>
 * The followings are the available columns in table '{{translate}}':
 * @property string $category
 * @property string $cn
 * @property string $en
 * @property integer $num
 * @property string $last_time
 * @property string $controller
 * @property string $action
 */
class Translate extends CActiveRecord {

    public function tableName() {
        return '{{translate}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('category, cn', 'required'),
            array('num', 'numerical', 'integerOnly' => true),
            array('category, controller, action', 'length', 'max' => 50),
            array('cn', 'length', 'max' => 255),
            array('en, last_time', 'safe'),
            array('category, cn, en, num, last_time, controller, action', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'category' => Yii::t('translate', 'model名称'),
            'cn' => Yii::t('translate', '简体中文'),
            'en' => Yii::t('translate', '英文'),
            'num' => Yii::t('translate', '翻译次数'),
            'create_time' => Yii::t('translate', 'Create Time'),
            'last_time' => Yii::t('translate', 'Last Time'),
            'controller' => Yii::t('translate', 'Controller'),
            'action' => Yii::t('translate', 'Action'),
            'is_backend' => Yii::t('translate', '后台模块'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('category', $this->category, true);
        $criteria->compare('cn', $this->cn, true);
        $criteria->compare('en', $this->en, true);
        $criteria->compare('num', $this->num);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('last_time', $this->last_time, true);
        $criteria->compare('controller', $this->controller, true);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('is_backend', $this->is_backend, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array(
            //'defaultOrder'=>' DESC', //设置默认排序
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
