<?php

/**
 * 加盟商文章模型
 * @author wencong.lin <183482670@qq.com>
 *
 * @property string $id
 * @property integer $author_id
 * @property string $create_time
 * @property string $franchisee_id
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property string $views
 * @property string $thumbnail
 * @property string $external_links
 */
class FranchiseeArtile extends CActiveRecord {

    const STATUS_DRAFT = 0;
    const STATUS_RELEASE = 1;
    public $oldLogo;

    /**
     * 加盟商文章状态
     * @return array
     */
    public static function status() {
        return array(
            self::STATUS_DRAFT => Yii::t('franchiseeArtile', '草稿'),
            self::STATUS_RELEASE => Yii::t('franchiseeArtile', '发布'),
        );
    }

    public function tableName() {
        return '{{franchisee_artile}}';
    }

    public function rules() {
        return array(
            array('title, content, external_links', 'required'),
            array('author_id, status', 'numerical', 'integerOnly' => true),
            array('create_time, franchisee_id, views', 'length', 'max' => 11),
            array('title, thumbnail, external_links', 'length', 'max' => 128),
            array('create_time', 'default', 'value' => new CDbExpression('UNIX_TIMESTAMP()'), 'on' => 'insert'),
            array('id, author_id, create_time, franchisee_id, title, content, status, views, thumbnail, external_links', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'author_id' => Yii::t('franchiseeArtile', '作者ID'),
            'create_time' => Yii::t('franchiseeArtile', '创建时间'),
            'franchisee_id' => Yii::t('franchiseeArtile', '加盟商'),
            'title' => Yii::t('franchiseeArtile', '标题'),
            'content' => Yii::t('franchiseeArtile', '内容'),
            'status' => Yii::t('franchiseeArtile', '状态'),
            'views' => Yii::t('franchiseeArtile', '浏览数'),
            'thumbnail' => Yii::t('franchiseeArtile', '新闻图片'),
            'external_links' => Yii::t('franchiseeArtile', '外部链接'),
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('author_id', $this->author_id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('franchisee_id', $this->franchisee_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('views', $this->views, true);
        $criteria->compare('thumbnail', $this->thumbnail, true);
        $criteria->compare('external_links', $this->external_links);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 
     * @param type $id  加盟商ID
     * @return type 加盟商名称
     */
    public static function getFranchiseeById($id) {
        $name = '';
        if (isset($id)) {
            $data = yii::app()->db->createCommand()
                    ->select('name')
                    ->from('{{franchisee}}')
                    ->where('id = :id', array(':id' => $id))
                    ->queryRow();
            $name = $data['name'];
        }

        return $name;
    }

    /**
     * 删除后的操作
     * 删除当前加盟商文章图片
     */
    protected function afterDelete() {
        parent::afterDelete();
        if (isset($this->thumbnail)){
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $this->thumbnail);
        }
    }
    
    

}
