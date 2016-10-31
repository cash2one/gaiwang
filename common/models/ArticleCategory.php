<?php

/**
 * 文章分类模型
 * @author binbin.liao <277250538@qq.com>
 * 
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $sort
 * @property string $keywords
 * @property string $description
 */
class ArticleCategory extends CActiveRecord {

    public function tableName() {
        return '{{article_category}}';
    }

    public function rules() {
        return array(
            array('parent_id, name', 'required'),
            array('name', 'unique'),
            array('sort', 'numerical', 'integerOnly' => true),
            array('name, keywords', 'length', 'max' => 128),
            array('description,name,keywords, description', 'safe'),
            array('id, name, parent_id, sort, keywords, description', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {

        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('articleCategory','分类名称'),
            'parent_id' => Yii::t('articleCategory','上级分类'),
            'sort' => Yii::t('articleCategory','排序'),
            'keywords' => Yii::t('articleCategory','关键词'),
            'description' => Yii::t('articleCategory','描述'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('keywords', $this->keywords, true);
        $criteria->compare('description', $this->description, true);
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

    /**
     * 格式化分类数组
     * @param array $categories 格式化后数组
     * @param array $models 分类模型数组
     * @param int $parentId 顶级分类id值
     * @param string $seperate 子类用到的分隔符
     */
    private static function formatCategories(&$categories, $models, $parentId = 0, $seperate = '') {
        foreach ($models as $k => $v) {
            if ($v['parent_id'] == $parentId) {
                $v['name'] = $seperate . $v['name'];
                $categories[] = $v;
                self::formatCategories($categories, $models, $v['id'], $seperate . "　");
            }
        }
    }

    /**
     * 获取分类树
     * @param boolean $flag 标记是否显示一级分类选项
     * @return array 返回分类数组树结构
     */
    public static function getTreeCategories($flag = false) {
        $models = self::model()->findAll();
        $categories = $finalCategories = array();
        self::formatCategories($categories, $models);
        if ($flag)
            $finalCategories[0] = '一级分类';
        foreach ($categories as $v)
            $finalCategories[$v['id']] = $v['name'];
        return $finalCategories;
    }

}
