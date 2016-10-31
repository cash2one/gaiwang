<?php

/**
 * 广告管理模型
 * @author qinghao.ye <qinghaoye@sina.com>
 * @property string $id
 * @property string $advert_id
 * @property string $title
 * @property string $start_time
 * @property string $end_time
 * @property integer $sort
 * @property integer $status
 * @property string $link
 * @property string $picture
 * @property string $text
 * @property string $flash
 * @property integer $group
 * @property integer $seat
 * @property string $target
 * @property string $background
 * @property string $advertType
 */
class AdvertPicture extends CActiveRecord {

    const STATUS_ENABLE = 1;    // 状态开启
    const STATUS_DISABLED = 0;  // 状态禁用
    const TARGET_BLANK = '_blank';
    const TARGET_SELF = '_self';

    public $advertType; // 广告类型

    public function tableName() {
        return '{{advert_picture}}';
    }

    public function rules() {
        return array(
            array('title, start_time, link', 'required'),
            array('picture', 'comext.validators.requiredExt', 'allowEmpty' => $this->advertType != Advert::TYPE_IMAGE && $this->advertType != Advert::TYPE_SLIDE, 'on' => 'insert,app'),
            array('flash', 'comext.validators.requiredExt', 'allowEmpty' => $this->advertType != Advert::TYPE_FLASH, 'on' => 'insert,app'),
            array('text', 'comext.validators.requiredExt', 'allowEmpty' => $this->advertType != Advert::TYPE_TEXT, 'on' => 'app'),
            array('link', 'url'),
            array('sort, status, group, seat', 'numerical', 'integerOnly' => true),
            array('advert_id, start_time, end_time', 'length', 'max' => 11),
            array('title, link', 'length', 'max' => 128),
            array('background,target', 'length', 'max' => 56),
            array('text', 'length', 'max' => 256),
            array('picture', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'allowEmpty' => true,
                'tooLarge' => Yii::t('advertPicture', Yii::t('advertPicture', '图片 最大不超过1MB，请重新上传!'))
            ),
            array('flash', 'file', 'types' => 'swf,fla,flv', 'maxSize' => 1024 * 1024 * 10, 'allowEmpty' => true,
                'tooLarge' => Yii::t('advertPicture', Yii::t('advertPicture', 'Flash 最大不超过10MB，请重新上传!'))
            ),
//            用于盖象APP商品绑定
            array('good_id','required','on'=>'app,appUpdate'),
            array('good_id','checkGoodsId','on'=>'app,appUpdate'),
//            array('good_id','numerical','min'=>1,'on'=>'app,appUpdate'),

        );
    }

    /**
     * 验证字段是否填写
     * @param type $attribute
     * @param type $params
     */
    public function checkPassword($attribute, $params) {
        if (!CPasswordHelper::verifyPassword($this->originalPassword, $this->_oldPassword))
            $this->addError($attribute, Yii::t('user', '原始密码不正确'));
    }

    /**
     * 检查商品是否已上架、是否通过审核
     * @param $attribute
     * @param $params
     */
    public function checkGoodsId($attribute, $params){
        $goods = Goods::model()->findByPk(array('id' => $this->good_id));
        if(!is_numeric($this->good_id)){
            $this->addError($attribute, Yii::t('user', '商品id必须为数字！'));
        }
        if(empty($goods)){
            $this->addError($attribute, Yii::t('user', '该商品不存在，请重新选择商品！'));
        }
        if ($goods['is_publish'] == Goods::PUBLISH_NO || $goods['status'] != Goods::STATUS_PASS) {
            $this->addError($attribute, Yii::t('user', '该商品未上架或未通过审核，请重新选择商品！'));
        }
    }

    public function relations() {
        return array(
            'advert' => array(self::BELONGS_TO, 'Advert', 'advert_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('advertPicture', '主键'),
            'advert_id' => Yii::t('advertPicture', '所属广告位'),
            'title' => Yii::t('advertPicture', '名称'),
            'start_time' => Yii::t('advertPicture', '开始时间'),
            'end_time' => Yii::t('advertPicture', '结束时间'),
            'sort' => Yii::t('advertPicture', '排序'),
            'status' => Yii::t('advertPicture', '状态'),
            'link' => Yii::t('advertPicture', '链接'),
            'picture' => Yii::t('advertPicture', '图片'),
            'text' => Yii::t('advertPicture', '文本内容'),
            'flash' => Yii::t('advertPicture', 'FLASH'),
            'group' => Yii::t('advertPicture', '小组'),
            'seat' => Yii::t('advertPicture', '位置'),
            'target' => Yii::t('advertPicture', '打开方式'),
            'background' => Yii::t('advertPicture', '背景颜色'),
            'good_id'=>Yii::t('advertPicture', '绑定商品ID'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('advert_id', $this->advert_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array(
                'defaultOrder' => 'end_time DESC, sort DESC', //设置默认排序
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 必须条件
     * @param int $time 时间
     */
    public function must($time = null) {
        $time = is_null($time) ? time() : $time;
        $this->getDbCriteria()->mergeWith(array(
            'condition' => 'status = :status And start_time <= :start_time And end_time >= :end_time',
            'order' => 'sort DESC, start_time DESC, id DESC',
            'params' => array(':status' => AdvertPicture::STATUS_ENABLE, ':start_time' => $time, ':end_time' => $time),
        ));
        return $this;
    }

    /**
     * 获取状态数组或名称
     * @param  integer $key
     * @return mixed
     */
    public static function getStatus($key = false) {
        $status = array(
            self::STATUS_ENABLE => Yii::t('advertPicture', '启用'),
            self::STATUS_DISABLED => Yii::t('advertPicture', '禁用')
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
    public static function getTarget($key = false) {
        $target = array(
            self::TARGET_BLANK => Yii::t('advertPicture', '新窗口'),
            self::TARGET_SELF => Yii::t('advertPicture', '本窗口')
        );
        if ($key === false)
            return $target;
        return $target[$key];
    }

    protected function loadAdvertModel($id) {
        return Advert::model()->find(array(
                    'select' => 'id',
                    'condition' => 'id=:id',
                    'params' => array(':id' => $id)
        ));
    }

    /**
     * 保存之后处理 
     */
    protected function afterSave() {
        parent::afterSave();
        $this->advert->setCache();
    }

    /**
     * 删除后的操作
     * 删除当前记录的图片或flash文件
     */
    protected function afterDelete() {
        parent::afterDelete();
        if ($this->flash)
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $this->flash);
        if ($this->picture)
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $this->picture);
        $this->advert->setCache();
    }

    /**
     * 广告是否有效
     * @param int $startTime    广告开始时间
     * @param int $endTime      广告结束时间
     * @return boolean          返回true则有效，false则过期
     */
    public static function isValid($startTime, $endTime) {
        if (!empty($endTime))
            return $startTime <= time() && $endTime >= time();
        return $startTime <= time();
    }

}
