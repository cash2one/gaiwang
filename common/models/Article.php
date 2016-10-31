<?php

/**
 * 文章模型
 * @author_id binbin.liao <277250538@qq.com>
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $summary
 * @property integer $author_id
 * @property integer $category_id
 * @property string $thumbnail
 * @property string $content
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $sort
 * @property string $keywords
 * @property string $description
 */
class Article extends CActiveRecord {

    public static $menu2 = array();

    public function tableName() {
        return '{{article}}';
    }

    public function rules() {
        return array(
            array('title, alias, category_id', 'required'),
            array('category_id, sort', 'numerical', 'integerOnly' => true),
            array('title, alias, thumbnail, keywords', 'length', 'max' => 128),
            array('summary', 'length', 'max' => 256),
            array('alias,title', 'unique'),
            array('title, alias, summary, thumbnail, content, keywords, description', 'safe'),
            array('thumbnail', 'file', 'allowEmpty' => true, 'types' => 'jpg,jpeg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'tooLarge' => '上传图片最大不能超过1Mb,请重新上传'),
            array('title', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'category' => array(self::BELONGS_TO, 'ArticleCategory', 'category_id'),
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => Yii::t('article', '标题'),
            'alias' => '英文别名(URL美化用)',
            'summary' => Yii::t('article', '摘要'),
            'category_id' => Yii::t('article', '文章分类'),
            'thumbnail' => Yii::t('article', '图片'),
            'content' => Yii::t('article', '内容'),
            'sort' => Yii::t('article', '排序'),
            'keywords' => Yii::t('article', '关键字'),
            'description' => Yii::t('article', '描述'),
            'author_id' => Yii::t('article', '文章作者'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('title', $this->title, true);
        $criteria->compare('category_id', $this->category_id);
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

    protected function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->create_time = time();
                $this->author_id = Yii::app()->user->id;
            } else {
                $this->author_id = Yii::app()->user->id;
                $this->update_time = time();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 删除后的操作
     * 删除文章图片
     * 删除文章缓存
     */
    protected function afterDelete() {
        parent::afterDelete();
        if (isset($this->thumbnail))
            UploadedFile::delete(Yii::getPathOfAlias('uploads') . DS . $this->thumbnail);
        Tool::cache('article')->delete($this->alias);
        self::helpInfo(false);
    }

    /**
     * 生成帮助中心文章
     */
    public static function helpInfo($flag = true) {
        if ($flag) {
            $helpInfo = Tool::cache('article')->get('helpInfo');
            return !$helpInfo ? self::helpInfo(false) : $helpInfo;
        }
        // 获取帮助中心分类
        $categorys = Yii::app()->db->createCommand()
                ->select('id, name')
                ->from('{{article_category}}')
                ->where('parent_id=:p_id', array(':p_id' => 1))
                ->queryAll();
        if(empty($categorys))return;
        $ids = array();
        foreach ($categorys as $value){
            if($value['id'])$ids[] = $value['id'];
        }
        if(empty($ids))return;
        $category_id = implode(',', $ids);

        // 获取文章信息
        $articles = Yii::app()->db->createCommand()
                ->select('id, title, alias, category_id')
                ->from('{{article}}')
                ->where('category_id in(' . $category_id . ')')
                ->queryAll();

        // 拼接帮助中心为二维数组
        $info = array();
        foreach ($categorys as $key => $value) {
            foreach ($articles as $v) {
                if ($value['id'] == $v['category_id']) {
                    $info[$key]['id'] = $value['id'];
                    $info[$key]['name'] = $value['name'];
                    $info[$key]['child'][] = $v;
                }
            }
        }
        Tool::cache('article')->set('helpInfo', $info);
        return $info;
    }

    /**
     * 生成文章缓存
     * @param array $data 文章信息
     */
    public static function fileCache($alias, $flag = true) {
        if ($flag) {
            $fileCache = Tool::cache('article')->get($alias);
            return !$fileCache ? self::fileCache($alias, false) : $fileCache;
        }
        $article = Article::model()->find('alias=:alias', array(':alias' => $alias));
        if ($article === null)
            return array();
        Tool::cache('article')->set($alias, $article->attributes);
        return $article->attributes;
    }

    /**
     * 保存后的操作
     * 更新文章缓存
     * 更新帮助中心缓存
     */
    protected function afterSave() {
        parent::afterSave();
        self::fileCache($this->alias, false);
        self::helpInfo(false);
    }

    /**
     * 获取帮助中心数据 用于商城优化
     * @author:xiaoyan.luo
     */
    public static function getHelpInfo() {
        // 获取帮助中心分类
        $categorys = Yii::app()->db->createCommand()
            ->select('id, name')
            ->from('{{article_category}}')
            ->where('parent_id=:p_id', array(':p_id' => 1))
            ->order('sort ASC')
            ->limit(7) 
            ->queryAll();
        if(empty($categorys))return array();
        $ids = array();
        foreach ($categorys as $value){
            if($value['id'])$ids[] = $value['id'];
        }
        if(empty($ids))return array();
        $category_id = implode(',', $ids);
        // 获取文章信息
        $articles = Yii::app()->db->createCommand()
            ->select('id, title, alias, category_id')
            ->from('{{article}}')
            ->where('category_id in(' . $category_id . ')')
            ->queryAll();
        // 拼接帮助中心为二维数组
        $info = array();
        foreach ($categorys as $key => $value) {
            foreach ($articles as $v) {
                if ($value['id'] == $v['category_id']) {
                    $info[$key]['id'] = $value['id'];
                    $info[$key]['name'] = $value['name'];
                    $info[$key]['child'][] = $v;
                }
            }
        }
        return $info;
    }

    /**
     * 得到帮助中心的分类名称
     * @param int $cid 分类ID
     */
    public static function getCateName($cid){
        $cateName = Yii::app()->db->createCommand()
        ->select('id, name')
        ->from('{{article_category}}')
        ->where('id=:c_id', array(':c_id' => $cid))
        ->queryRow(); 
        return isset($cateName['name']) ? $cateName['name'] : '';
    }
}
