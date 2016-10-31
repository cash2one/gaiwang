<?php

/**
 * 专题分类模型类
 * @author jianlin_lin <hayeslam@163.com>
 * {{special_topic_category}} 模型
 *
 * The followings are the available columns in table '{{special_topic_category}}':
 * @property string $id
 * @property string $name
 * @property string $special_topic_id
 * @property string $thumbnail
 * @property float  $integral_ratio
 */
class SpecialTopicCategory extends CActiveRecord {

    public function tableName() {
        return '{{special_topic_category}}';
    }

    /**
     * @return array 模型属性的验证规则
     */
    public function rules() {
        return array(
            array('name', 'required'),
            array('name', 'checkCategoryName', 'on' => 'insert'),
            array('thumbnail', 'required', 'on' => 'insert'),
            array('name', 'length', 'max' => 12),
            array('special_topic_id', 'length', 'max' => 11),
            array('thumbnail', 'length', 'max' => 128),
            array('integral_ratio','length','max'=>6),
            array('integral_ratio','numerical'),
            array('integral_ratio','compare','compareValue'=>0,'operator'=>'>','message'=>Yii::t('specialTopicCategory','必须大于0')),
            array('integral_ratio','compare','compareValue'=>100,'operator'=>'<=','message'=>Yii::t('specialTopicCategory','小于或等于100')),
            array('integral_ratio','match','pattern'=>'/^\d\d?\.?\d?\d?[0-9]?$/','message'=>Yii::t('specialTopicCategory','积分支付比例数值填写有误')),
            array('thumbnail', 'file', 'types' => 'jpg,gif,png,bmp', 'maxSize' => 1024 * 1024 * 2,
                'tooLarge' => Yii::t('specialTopicCategory', '文件大于2M，上传失败！请上传小于2M的文件！'), 'allowEmpty' => true),
        );
    }

    /**
     * 检查分类名称
     * 判断是否在同个专题下与其他分类名称一样
     */
    public function checkCategoryName() {
        $exists = $this->exists('special_topic_id = :stid AND name = :name', array(':stid' => $this->special_topic_id, ':name' => $this->name));
        if ($exists)
            $this->addError('name', $this->getAttributeLabel('name') . '不可重复！');
    }

    /**
     * @return array 数组的关系规则
     */
    public function relations() {
        return array(
            'specialTopic' => array(self::BELONGS_TO, 'SpecialTopic', 'special_topic_id'),
            'specialTopicGoods' => array(self::HAS_MANY, 'SpecialTopicGoods', 'special_topic_category_id'),
            'specialTopicGoodsLimit' => array(self::HAS_MANY, 'SpecialTopicGoods', 'special_topic_category_id', 'limit' => 10),
        );
    }

    /**
     * @return array 自定义属性标签(名称= >标签)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('specialTopicCategory', '主键'),
            'name' => Yii::t('specialTopicCategory', '名称'),
            'special_topic_id' => Yii::t('specialTopicCategory', '所属专题'),
            'thumbnail' => Yii::t('specialTopicCategory', '缩略图'),
            'integral_ratio'=>Yii::t('specialTopicCategory', '积分支付比例'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('special_topic_id', $this->special_topic_id);  // 所属专题ID
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
     * 删除之后的操作
     */
    public function afterDelete() {
        parent::afterDelete();
        if (!empty($this->thumbnail))
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $this->thumbnail);
        $specialGoods = $this->specialTopicGoods;
        foreach ($specialGoods as $goods) {
            $goods->delete(); // 删除相应专题商品
        }
    }

}
