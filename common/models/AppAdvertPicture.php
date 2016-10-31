<?php

/**
 * APP广告管理模型
 * @author qinghao.ye <qinghaoye@sina.com>
 * @property string $id
 * @property string $name
 * @property string $advert_id
 * @property string $start_time
 * @property string $end_time
 * @property integer $sort
 * @property integer $status
 * @property integer $target_type
 * @property string $target
 * @property integer $group
 * @property integer $seat
 * @property string $text
 * @property string $picture
 */
class AppAdvertPicture extends CActiveRecord {

    public function tableName() {
        return '{{app_advert_picture}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('name, advert_id, start_time, sort, status, target_type, target, group, seat', 'required'),
            array('sort, status, target_type, group, seat', 'numerical', 'integerOnly' => true),
            array('name, target, picture', 'length', 'max' => 128),
            array('advert_id, start_time, end_time', 'length', 'max' => 11),
            array('text', 'safe'),
            array('id, name, advert_id, start_time, end_time, sort, status, target_type, target, group, seat, text, picture', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'appAdvert' => array(self::BELONGS_TO, 'AppAdvert', 'advert_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('appAdvertPicture', '主键'),
            'name' => Yii::t('appAdvertPicture', '名称'),
            'advert_id' => Yii::t('appAdvertPicture', '所属广告'),
            'start_time' => Yii::t('appAdvertPicture', '开始时间'),
            'end_time' => Yii::t('appAdvertPicture', '结束时间'),
            'sort' => Yii::t('appAdvertPicture', '排序'),
            'status' => Yii::t('appAdvertPicture', '状态'),
            'target_type' => Yii::t('appAdvertPicture', '目标类型'),
            'target' => Yii::t('appAdvertPicture', '目标'),
            'group' => Yii::t('appAdvertPicture', '小组'),
            'seat' => Yii::t('appAdvertPicture', '位置'),
            'text' => Yii::t('appAdvertPicture', '文字内容'),
            'picture' => Yii::t('appAdvertPicture', '图片'),
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('advert_id', $this->advert_id);
        $criteria->compare('start_time', $this->start_time);
        $criteria->compare('end_time', $this->end_time);
        $criteria->compare('status', $this->status);
        $criteria->compare('text', $this->text, true);

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
    /**
     * 保存之后处理 
     */
    protected function afterSave() {
        parent::afterSave();
        AppAdvert::generateRelevantCache($this->advert_id); //生成广告缓存
    }
    
    /**
     * 删除后的操作
     * 删除当前记录的图片或flash文件
     */
    protected function afterDelete() {
        parent::afterDelete();
        if ($this->picture)
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $this->picture);
    }
    /**
     * 获取状态数组或名称
     * @param  integer $key
     * @return mixed
     */
    const STATUS_ENABLE = 1;
    const STATUS_DISABLED = 0;
    public static function getStatus($key = false) {
        $status = array(
            self::STATUS_ENABLE => Yii::t('appAdvertPicture', '启用'),
            self::STATUS_DISABLED => Yii::t('appAdvertPicture', '禁用')
        );
        if ($key === false)
            return $status;
        return $status[$key];
    }
    
    /**
     * 获取目标数组或名称
     * @param  integer $key
     * @return mixed
     */
    const TYPE_URL = 1;
    const TYPE_GOODS = 2;
    const TYPE_GOODS_CATEGORY = 3;
    public static function getTargetType($key = false) {
        $target = array(
            self::TYPE_URL => Yii::t('appAdvertPicture', '网址'),
            self::TYPE_GOODS => Yii::t('appAdvertPicture', '商品'),
            self::TYPE_GOODS_CATEGORY => Yii::t('appAdvertPicture', '商品分类')
        );
        if ($key === false)
            return $target;
        return $target[$key];
    }
}
