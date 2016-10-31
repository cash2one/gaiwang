<?php

/**
 *  店铺文章 模型
 * @author wencong_lin<183482670@qq.com>
 *
 * The followings are the available columns in table '{{store_article}}':
 * @property string $id
 * @property string $store_id
 * @property string $title
 * @property string $content
 * @property string $keywords
 * @property string $description
 * @property string $create_time
 * @property string $update_time
 * @property integer $is_publish
 * @property integer $status
 * @property integer $sort
 */
class StoreArticle extends CActiveRecord {

    const IS_PUBLISH_NO = 0; // 不发布
    const IS_PUBLISH_YES = 1; // 发布
    const STATUS_AUDIT = 0; // 未审核
    const STATUS_THROUGH = 1; // 审核通过
    const STATUS_NOTTHROUGH = 2; // 审核不通过

    /**
     * 文章发布
     * @param $key
     * @return array|null
     */

    public static function isPublish($key = null) {
        $arr = array(
            self::IS_PUBLISH_NO => Yii::t('storeArticle', '不发布'),
            self::IS_PUBLISH_YES => Yii::t('storeArticle', '发布'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    /**
     * 文章状态
     * @param $key
     * @return array|null
     */
    public static function status($key = null) {
        $arr = array(
            self::STATUS_AUDIT => Yii::t('storeArticle', '未审核'),
            self::STATUS_THROUGH => Yii::t('storeArticle', '审核通过'),
            self::STATUS_NOTTHROUGH => Yii::t('storeArticle', '审核不通过'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    public function tableName() {
        return '{{store_article}}';
    }

    public function rules() {
        return array(
            array('title, content, keywords, description, is_publish, sort', 'required'),
            array('is_publish, status, sort', 'numerical', 'integerOnly' => true),
            array('store_id, create_time, update_time', 'length', 'max' => 11),
            array('title, keywords', 'length', 'max' => 128),
            array('description', 'length', 'max' => 258),
            array('id, store_id, title, content, keywords, description, create_time, update_time, is_publish, status, sort', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'store_id' => Yii::t('storeArticle', '商家名称'),
            'title' => Yii::t('storeArticle', '标题'),
            'content' => Yii::t('storeArticle', '内容'),
            'keywords' => Yii::t('storeArticle', '关键字'),
            'description' => Yii::t('storeArticle', '描述'),
            'create_time' => Yii::t('storeArticle', '创建时间'),
            'update_time' => Yii::t('storeArticle', '更新时间'),
            'is_publish' => Yii::t('storeArticle', '是否发布'),
            'status' => Yii::t('storeArticle', '状态'),
            'sort' => Yii::t('storeArticle', '排序'),
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.status', $this->status);
        if (isset($this->store_id)) {
            $criteria->with = 'store';
            $criteria->compare('store.name', $this->store_id, true);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function gender($key = null) {
        $arr = array(
            self::IS_PUBLISH_YES => Yii::t('storeArticle', '发布'),
            self::IS_PUBLISH_NO => Yii::t('storeArticle', '不发布'),
        );
        if (is_numeric($key)) {
            return isset($arr[$key]) ? $arr[$key] : null;
        } else {
            return $arr;
        }
    }

    protected function beforeSave() {

        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->create_time = time();
            } else {
                $this->update_time = time();
            }
            return true;
        } else {
            return false;
        }
    }

}

