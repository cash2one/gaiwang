<?php

/**
 * 专题活动模型
 * @author jianlin_lin <hayeslam@163.com>
 *
 * The followings are the available columns in table '{{special_topic}}':
 * @property string $id
 * @property string $name
 * @property string $views
 * @property string $summary
 * @property string $create_time
 * @property string $thumbnail
 * @property string $start_time
 * @property string $end_time
 * @property integer $discount
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $author_id
 * @property string $author_name
 * @property string $ip
 */
class SpecialTopic extends CActiveRecord {

    public function tableName() {
        return '{{special_topic}}';
    }

    /**
     * @return array 模型属性的验证规则
     */
    public function rules() {
        return array(
            array('name, discount', 'required'),
            array('name', 'length', 'max' => 5, 'min' => 2),
            array('start_time, end_time, thumbnail', 'required', 'on' => 'insert'),
            array('start_time', 'checkDateTime', 'on' => 'insert'),
            array('discount', 'compare', 'operator' => '>', 'compareValue' => 0), // 折扣必须大于 0
            array('discount', 'compare', 'operator' => '<=', 'compareValue' => 100), // 折扣必须小于等于 100
            array('thumbnail', 'file', 'types' => 'jpg,gif,png,bmp', 'maxSize' => 1024 * 1024 * 2,
                'tooLarge' => Yii::t('specialTopic', '文件图片大于2M，上传失败！请上传小于2M的文件图片！'), 'allowEmpty' => true),
            array('discount', 'numerical', 'integerOnly' => true),
            array('thumbnail', 'length', 'max' => 128),
            array('views, create_time, start_time, end_time, author_id, ip', 'length', 'max' => 11),
            array('summary, title, keywords, description', 'length', 'max' => 255),
            array('author_name', 'length', 'max' => 56),
            array('name, start_time, end_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * 检查活动时间
     */
    public function checkDateTime($attribute, $params) {
        if ($this->start_time >= $this->end_time)
            $this->addError('start_time', '活动开始时间不得大于或等于结束时间！');
    }

    /**
     * @return array 关系规则
     */
    public function relations() {
        return array(
            'specialTopicCategory' => array(self::HAS_MANY, 'SpecialTopicCategory', 'special_topic_id'),
        );
    }

    /**
     * @return array 自定义属性标签 (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('specialTopic', '主键'),
            'name' => Yii::t('specialTopic', '名称'),
            'views' => Yii::t('specialTopic', '浏览量'),
            'summary' => Yii::t('specialTopic', '摘要'),
            'create_time' => Yii::t('specialTopic', '创建时间'),
            'thumbnail' => Yii::t('specialTopic', 'Banner图片'),
            'start_time' => Yii::t('specialTopic', '开始时间'),
            'end_time' => Yii::t('specialTopic', '结束时间'),
            'discount' => Yii::t('specialTopic', '折扣'),
            'title' => Yii::t('specialTopic', '标题'),
            'keywords' => Yii::t('specialTopic', '关键词'),
            'description' => Yii::t('specialTopic', '说明'),
            'author_id' => Yii::t('specialTopic', '作者'),
            'author_name' => Yii::t('specialTopic', '作者名称'),
            'ip' => Yii::t('specialTopic', 'IP'),
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('name', $this->name, true);
        $searchDate = Tool::searchDateFormat($this->start_time, $this->end_time);
        $criteria->compare('start_time', ">=" . $searchDate['start']);
        $criteria->compare('end_time', "<" . $searchDate['end']);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, // 分页
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC', //设置默认排序
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 获取专题分类商品
     */
    public function getSpecialTopicGoods() {
        $data = array();
        $specialCategory = Yii::app()->db->createCommand()->from('{{special_topic_category}}')->where('special_topic_id = :stid', array(':stid' => $this->id))->queryAll();
        foreach ($specialCategory as $key => $category) {
            $data[$key] = $category;
            $specialGoods = Yii::app()->db->createCommand()->from('{{special_topic_goods}}')->select('goods_id, special_price')
                    ->where('special_topic_id = :stid AND special_topic_category_id = :stcid', array(':stid' => $this->id, ':stcid' => $category['id']))
                    ->queryAll();
            if (!empty($specialGoods)) {
                $gids = $stg = array();
                foreach ($specialGoods as $sg) {
                    $gids[] = $sg['goods_id'];
                    $stg[$sg['goods_id']] = $sg;
                }
                $goods = Yii::app()->db->createCommand()->from('{{goods}}')->select('id, name, price, thumbnail')
                        ->where('status = :status AND is_publish = :push and life=:life', array(':status' => Goods::STATUS_PASS, ':push' => Goods::PUBLISH_YES,':life'=>Goods::LIFE_NO))
                        ->andWhere(array('in', 'id', $gids))
                        ->limit(10)
                        ->queryAll();
                foreach ($goods as $k => $v) {
                    if (array_key_exists($v['id'], $stg)) {
                        $data[$key]['goods'][$k] = $v;
                        $data[$key]['goods'][$k]['special_price'] = $stg[$v['id']]['special_price'];
                    }
                }
            }
        }
        return $data;
    }

    /**
     * 保存之后的操作
     * @return boolean
     */
    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->create_time = time();
            } else {
                
            }
            $this->author_id = Yii::app()->user->id;
            $this->author_name = Yii::app()->getUser()->name;
            $this->ip = Tool::ip2int($_SERVER['REMOTE_ADDR']);
            return true;
        }
        else
            return false;
    }

    /**
     * 删除之后的操作
     */
    public function afterDelete() {
        parent::afterDelete();
        if (!empty($this->thumbnail))
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $this->thumbnail);
        $specialCategory = $this->specialTopicCategory;
        foreach ($specialCategory as $category) {
            $category->delete(); // 删除相应专题分类
        }
    }

    /**
     * 根据时间，获取有效的专题活动个数
     * @param string $time
     * @return mixed
     */
    public static function effectiveTopicNum($time=''){
        if(!$time) $time = time();
        $sql = 'select count(*) from gw_special_topic where end_time>'.$time;
        return Yii::app()->db->createCommand($sql)->queryScalar();
    }

}
