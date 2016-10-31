<?php

/**
 * 酒店图片模型(多图上传)
 * @author binbin.liao  <277250538@qq.com>
 *
 * @property integer $target_id
 * @property string $path
 * @property integer  $type
 * @property integer  $sort
 */
class HotelPicture extends CActiveRecord {

    const TYPE_HOTEL = 1;
    const TYPE_ROOM = 2;

    public function tableName() {
        return '{{hotel_picture}}';
    }

    public function rules() {
        return array(
            array('target_id, path, type', 'required'),
            array('target_id, type, sort', 'numerical', 'integerOnly' => true),
        );
    }

    public function relations() {
        return array();
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'target_id' => Yii::t('hotelPicture', '所属对象'),
            'path' => Yii::t('hotelPicture', '图片列表'),
            'type' => Yii::t('hotelPicture', '类型'),
            'sort' => Yii::t('hotelPicture', '排序'),
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 在删除之后
     */
    public function afterDelete() {
        parent::afterDelete();
        if ($this->path) {
            UploadedFile::delete(Yii::getPathOfAlias('uploads') . DS . $this->path); // 删除文件
        }

    }

    /**
     * 获取组图数据
     * @param integer $belong 所属对象
     * @param integer $type 图片类型
     * @param integer $limit 查询条目 默认查询所有
     * @return array
     * @author jianlin.lin
     */
    public static function getPictures($belong, $type, $limit = -1) {
        $command = yii::app()->db->createCommand();
        $command->select('path')->from('{{hotel_picture}}')->where('target_id = :tid AND type = :type', array(':tid' => $belong, ':type' => $type))->limit($limit);
        return $command->queryAll();
    }
}

?>
