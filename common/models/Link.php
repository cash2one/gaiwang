<?php

/**
 * 友情链接模型
 * @author jianlin_lin <hayeslam@163.com>
 * 
 * @property integer $id
 * @property string $url
 * @property integer $sort
 */
class Link extends CActiveRecord {

    const POSITION_DEFAULT = 0;
    const POSITION_HOME = 1;
    const POSITION_HOME_MAX = 50; // 首页只显示50条友情链接信息

    /**
     * 获取友情链接位置状态或文本
     * @param int $id
     */
    public static function getPositionStatus($id = null) {
        $arr = array(
            self::POSITION_DEFAULT => Yii::t('link', '默认'),
            self::POSITION_HOME => Yii::t('link', '首页'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('link', '未知'));
    }

    public function tableName() {
        return '{{link}}';
    }

    public function rules() {
        return array(
            array('name, url, sort, position', 'required'),
            array('sort', 'numerical', 'integerOnly' => true),
            array('name, url', 'length', 'max' => 128),
            array('name, url', 'unique', 'on' => 'insert'),
            array('url', 'url'),
            array('position', 'validationIndexNum', 'on' => 'insert, update'),
            array('id, name, url, sort', 'safe', 'on' => 'search'),
        );
    }

    /**
     * 验证首页条目
     * @param type $attribute
     * @param type $params
     */
    public function validationIndexNum($attribute, $params) {
        if ($this->$attribute == self::POSITION_HOME) {
            $sql = "SELECT COUNT(*) FROM {{link}} WHERE position = " . self::POSITION_HOME;
            $num = Yii::app()->db->createCommand($sql)->queryScalar();
            if ($num >= self::POSITION_HOME_MAX)
                $this->addError($attribute, '目前首页只显示' . self::POSITION_HOME_MAX . '条友情链接');
        }
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('link', '网站名称'),
            'url' => Yii::t('link', '网站地址'),
            'sort' => Yii::t('link', '排序'),
            'position' => Yii::t('link', '位置'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name, true);
        $criteria->compare('url', $this->url, true);
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
     * 缓存友情链接数据
     * 前台调用，减少数据库查询
     * @param boolean $flag
     * @param return array
     */
    public static function fileCache($flag = true) {
        if ($flag) {
            $cacheFile = Tool::cache('common')->get('link');
            return !$cacheFile ? self::fileCache(false) : $cacheFile;
        }
        $cacheFile = Yii::app()->db->createCommand()
                ->select(array('name', 'url'))
                ->from('{{link}}')
                ->where('position', array('position' => self::POSITION_HOME))
                ->order('sort asc')
                ->limit(self::POSITION_HOME_MAX)
                ->queryAll();
        Tool::cache('common')->set('link', $cacheFile);
        return $cacheFile;
    }

    public static function linkFileCache($flag = true) {
        
        if ($flag) {
            $cacheFile = Tool::cache('list')->get('links');
            Tool::pr($cacheFile);
            return !$cacheFile ? self::linkFileCache(false) : $cacheFile;
        }

        $cacheFile = Yii::app()->db->createCommand()
                ->select(array('name', 'url', 'position'))
                ->from('{{link}}')
                ->order('sort asc')
                ->queryAll();
        Tool::cache('list')->set('links', $cacheFile);
        return $cacheFile;
    }

    /**
     * 删除后的操作
     */
    protected function afterDelete() {
        parent::afterDelete();
        self::fileCache(false);
        self::linkFileCache(false);
    }

    /**
     * 保存后的操作
     */
    protected function afterSave() {
        parent::afterSave();
        self::fileCache(false);
        self::linkFileCache(false);
    }

}
