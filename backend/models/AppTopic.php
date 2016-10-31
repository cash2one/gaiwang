<?php

/**
 * 程序日志模型类
 * @author wanyun.liu <wanyun_liu@163.com>
 * 
 * @property integer $id
 * @property string $level
 * @property string $category
 * @property integer $logtime
 * @property string $message
 */
class AppTopic extends CActiveRecord {
    const FINE_LIVING = 1;  //臻致生活
    const BUSINESS_GIFT = 2; //商务小礼
    const  FRESH_COLLECTION = 3;//盖鲜汇
    const IS_PUBLISH_TRUE = 1;                                 //已发布
    const IS_PUBLISH_FALSE = 0;                                 //未发布
    public $title;
    public $min_title;
    public $detail_content;
    public $sort;
    public $status;
    public $category;
    public $main_img;
    public function tableName() {
        return '{{app_topic}}';
    }

       /**
     * 是否发布
     * @param null $key
     * @return array
     */
       public static function getPublish($key = null){
        $data = array(
            self::IS_PUBLISH_FALSE => Yii::t('AppHotCategory','未发布'),
            self::IS_PUBLISH_TRUE => Yii::t('AppHotCategory','已发布'),
            );
        return $key === null ? $data : $data[$key];
    }

    public function attributeLabels() {
        return array(
            'id' => '主键',
            'title' => '专题标题',
            'min_title' => '子标题',
            'detail_content' => '内容详情',
            'sort' => '排序',
            'status' => '是否发布',
            'category' => '主题分类',
            'main_img'=>'专题图片',
            'create_time'=> '创建时间',
            'update_time'=>'更新时间'
            );
    }
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title,status,category,sort', 'required'),
            array('main_img','required','on'=>'create'),
             array('status, sort, category', 'numerical', 'integerOnly'=>true),
             array('title', 'length', 'max'=>35),
        	array('title', 'length', 'max'=>35),
            // array('create_time, update_time', 'length', 'max'=>10),
            // array('picture', 'length', 'max'=>128),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, min_title, detail_content, sort, status, category, main_img,create_time,update_time', 'safe'),
            );
    }

    public function search($categoryId) {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('min_title', $this->min_title,true);
        $criteria->compare('category', $this->category, true);
        $criteria->addCondition('category=' .$categoryId);
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