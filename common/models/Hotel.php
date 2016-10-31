<?php

/**
 * 酒店模型
 * @author binbin.liao  <277250538@qq.com>
 * The followings are the available columns in table '{{hotel}}':
 * @property string  $id
 * @property string  $keywords
 * @property string  $description
 * @property string  $name
 * @property integer $level_id
 * @property integer $brand_id
 * @property string  $countries_id
 * @property string  $province_id
 * @property string  $city_id
 * @property string  $district_id
 * @property string  $street
 * @property string  $content
 * @property string  $address_id
 * @property string  $lng
 * @property string  $lat
 * @property integer $sort
 * @property string  $thumbnail
 * @property integer $status
 * @property string  $create_time
 * @property string  $update_time
 * @property integer $checkout_time
 * @property integer $parking_lot
 * @property integer $meeting_room
 * @property integer $pickup_service
 * @property integer $comments
 * @property integer $min_price
 * @property integer $max_price
 * @property integer $total_score
 */
class Hotel extends CActiveRecord {

    const CHECKOUT_TIME = 72; // 酒店默认最迟取消时间72小时
    const STATUS_UNPUBLISH = 0; // 未发布状态
    const STATUS_PUBLISH = 1; // 发布状态
    // 停车位
    const PARKING_LOT_NO = 0; // 无
    const PARKING_LOT_YES = 1; // 有
    // 会议室
    const MEETING_ROOM_NO = 0; // 无
    const MEETING_ROOM_YES = 1; // 有
    // 接机服务
    const PICKUP_SERVICE_NO = 0; // 无
    const MEETING_SERVICE_YES = 1; // 有

    /**
     * 获取酒店状态
     * @param null|integer $id
     * @return array|string
     */

    public static function getStatus($id = null) {
        $arr = array(
            self::STATUS_UNPUBLISH => Yii::t('hotel', '未发布'),
            self::STATUS_PUBLISH => Yii::t('hotel', '已发布'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotel', '未知'));
    }

    /**
     * 获取停车位
     * @param null|integer $id
     * @return string|array
     */
    public static function getParkingLot($id = null) {
        $arr = array(
            self::PARKING_LOT_NO => Yii::t('hotel', '无停车位'),
            self::PARKING_LOT_YES => Yii::t('hotel', '有停车位'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotel', '未知'));
    }

    /**
     * 获取会议室
     * @param null|integer $id
     * @return string|array
     */
    public static function getMeetingRoom($id = null) {
        $arr = array(
            self::MEETING_ROOM_NO => Yii::t('hotel', '无会议室'),
            self::MEETING_ROOM_YES => Yii::t('hotel', '有会议室'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotel', '未知'));
    }

    /**
     * 获取接机服务
     * @param null|integer $id
     * @return array|string
     */
    public static function getPickupService($id = null) {
        $arr = array(
            self::PICKUP_SERVICE_NO => Yii::t('hotel', '无接机服务'),
            self::MEETING_SERVICE_YES => Yii::t('hotel', '有接机服务'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotel', '未知'));
    }

    public function tableName() {
        return '{{hotel}}';
    }

    public function rules() {
        return array(
            array('name', 'unique'),
            array('name,countries_id, province_id, city_id, district_id, phone, content,street, lng, lat, address_id, level_id, brand_id, grade_id', 'required'),
            array('thumbnail', 'required', 'on' => 'insert'),
            array('status, parking_lot, meeting_room, pickup_service', 'in', 'range' => array(0, 1)),
            array('status', 'checkRoomsStatus', 'on' => 'update'),
            array('level_id, brand_id, countries_id, province_id, city_id, district_id, address_id, grade_id, sort, status, checkout_time, parking_lot, meeting_room, pickup_service', 'numerical', 'integerOnly' => true),
            array('description', 'length', 'max' => 256),
            array('level_id, brand_id, grade_id, sort, checkout_time', 'length', 'max' => 3),
            array('sort', 'checkSort'),
            array('keywords, name, street, lng, lat, phone', 'length', 'max' => 128),
//            array('phone', 'match', 'pattern' => '/^(1(([35][0-9])|(47)|[8][0123456789]))\d{8}$/', 'message' => Yii::t('hotel', '请输入正确的联系方式')),
            array('phone', 'match', 'pattern' => '/^0\d{2,4}(\-)?\d{7,8}$/', 'message' => Yii::t('hotel', '请输入正确的联系方式')),
            array('countries_id, province_id, city_id, district_id, address_id, create_time, update_time, comments, total_score, enter_count', 'length', 'max' => 11),
            array('parking_lot, meeting_room, pickup_service', 'length', 'max' => 1),
            array('min_price, max_price', 'length', 'max' => 10),
            array('name, street, lng, lat, content, keywords, description', 'filter', 'filter' => array($o = new CHtmlPurifier(), 'purify')),
            array('thumbnail', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'allowEmpty' => true,
                'tooLarge' => Yii::t('hotel', '{attribute}最大不超过1MB，请重新上传!')),
            array('id, keywords, description, name, level_id, brand_id,countries_id, province_id, city_id, district_id, street, content, address_id, lng, lat, sort, thumbnail, status, create_time, update_time, checkout_time, parking_lot, meeting_room, pickup_service', 'safe', 'on' => 'search'),
        );
    }

    /**
     * 检查 该酒店有没有房间或者有没有发布状态的房间，如没有，则不能更改为发布状态
     * @param $attribute
     * @param $params
     */
    public function checkRoomsStatus($attribute, $params) {
        if ($this->status == self::STATUS_PUBLISH) {
            $count = Yii::app()->db->createCommand()
            ->select('count(distinct id) as count')
            ->from('{{hotel_room}}')
            ->where('status = :status and hotel_id = :hotel_id', array(':status' => HotelRoom::STATUS_PUBLISH, ':hotel_id' => $this->id))
            ->queryScalar();
            if (!$count)
                $this->addError($attribute, '该酒店没有房间或者没有发布状态的房间,请检查！');
        }
    }

    /**
     * 检查排序值
     * @param $attribute
     * @param $params
     */
    public function checkSort($attribute, $params) {
        if ($this->sort < 0 || $this->sort > 255)
            $this->addError($attribute, '请输入0-255之间的数字！');
    }

    public function relations() {
        return array(
            'pictures' => array(self::HAS_MANY, 'HotelPicture', 'target_id', 'condition' => 'pictures.`type`=' . HotelPicture::TYPE_HOTEL),
            'countries' => array(self::BELONGS_TO, 'Region', 'countries_id'),
            'province' => array(self::BELONGS_TO, 'Region', 'province_id'),
            'city' => array(self::BELONGS_TO, 'Region', 'city_id'),
            'district' => array(self::BELONGS_TO, 'Region', 'district_id'),
            'level' => array(self::BELONGS_TO, 'HotelLevel', 'level_id'),
            'brand' => array(self::BELONGS_TO, 'HotelBrand', 'brand_id'),
            'address' => array(self::BELONGS_TO, 'HotelAddress', 'address_id'),
            'rooms' => array(self::HAS_MANY, 'HotelRoom', 'hotel_id','condition' => 'room.status=' . HotelRoom::STATUS_PUBLISH),
            'room'=> array(self::HAS_MANY, 'HotelRoom', 'hotel_id',),
            'maxPrice' => array(self::STAT, 'HotelRoom', 'hotel_id', 'select' => 'MAX(unit_price)'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'keywords' => Yii::t('hotel', '关键词'),
            'description' => Yii::t('hotel', '描述'),
            'name' => Yii::t('hotel', '酒店名称'),
            'level_id' => Yii::t('hotel', '等级'),
            'brand_id' => Yii::t('hotel', '酒店品牌'),
            'countries_id' => Yii::t('hotel', '国家'),
            'province_id' => Yii::t('hotel', '省份'),
            'city_id' => Yii::t('hotel', '城市'),
            'district_id' => Yii::t('hotel', '区/县'),
            'street' => Yii::t('hotel', '详细地址'),
            'content' => Yii::t('hotel', '简介'),
            'address_id' => Yii::t('hotel', '热门地址'),
            'lng' => Yii::t('hotel', '经度'),
            'lat' => Yii::t('hotel', '纬度'),
            'sort' => Yii::t('hotel', '排序'),
            'thumbnail' => Yii::t('hotel', '酒店封面图片'),
            'status' => Yii::t('hotel', '状态'),
            'create_time' => Yii::t('hotel', '创建时间'),
            'update_time' => Yii::t('hotel', '更新时间'),
            'checkout_time' => Yii::t('hotel', '允许最晚退房时间(前小时)'),
            'parking_lot' => Yii::t('hotel', '停车场'),
            'meeting_room' => Yii::t('hotel', '会议室'),
            'pickup_service' => Yii::t('hotel', '接机服务'),
            'grade_id' => Yii::t('hotel', '允许会员级别可见'),
            'comments' => Yii::t('hotel', '评论数'),
            'min_price' => Yii::t('hotel', '最低价'),
            'max_price' => Yii::t('hotel', '最高价'),
            'phone' => Yii::t('hotel', '联系电话'),
            'total_score' => Yii::t('hotel', '总评分'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name, true);
        $criteria->compare('brand_id', $this->brand_id);
        $criteria->compare('level_id', $this->level_id);
        $criteria->compare('countries_id', $this->countries_id);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('status', $this->status);
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
     * 在保存之前
     * @return bool
     */
    public function beforeSave() {
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

    /**
     * 在删除之前
     * @return bool
     */
    public function beforeDelete() {
        parent::beforeDelete();
        $rooms = HotelRoom::model()->findAll('hotel_id = :hid', array(':hid' => $this->id));
        // 删除该酒店所属的客房
        foreach ($rooms as $room) {
            $room->delete();
        }
        return true;
    }

    /**
     * 在删除之后
     */
    public function afterDelete() {
        parent::afterDelete();
        // 删除酒店封面图片
        if ($this->thumbnail)
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $this->thumbnail);
        // 删除酒店所属的图集
        foreach ($this->pictures as $picture) {
            $picture->delete();
        }
    }

    /**
     * 获取现有酒店的所有的省份数据
     * @return array
     */
    public static function getHotelProvinces() {
        $pids = CHtml::listData(Hotel::model()->findAll(array('group' => 'province_id')), 'id', 'province_id');
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $pids);
        return CHtml::listData(Region::model()->findAll($criteria), 'id', 'name');
    }

    /**
     * 获取现有酒店的所有的城市数据
     * @return array
     */
    public static function getHotelCitys() {
        $cids = CHtml::listData(Hotel::model()->findAll(array('group' => 'city_id')), 'id', 'city_id');
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $cids);
        return CHtml::listData(Region::model()->findAll($criteria), 'id', 'name');
    }

    /**
     * 获取热门酒店数据
     * @param integer $limit 查询条目
     * @return array
     */
    public static function getHotelByHot($limit = 10) {
        return yii::app()->db->createCommand()
        ->select('id, name, thumbnail, comments, total_score, min_price')
        ->from('{{hotel}} as h')
        ->where('status = :status', array(':status' => Hotel::STATUS_PUBLISH))
        ->order('enter_count DESC')
        ->limit($limit)
        ->queryAll();
    }

    /**
     * 最新酒店信息
     * @param integer $limit 查询条目
     * @return array
     */
    public static function getHotelByNew($limit = 10) {
        return yii::app()->db->createCommand()
        ->select('id, name, thumbnail, comments, total_score, min_price')
        ->from('{{hotel}} as h')
        ->where('status = :status', array(':status' => Hotel::STATUS_PUBLISH))
        ->order('create_time DESC')
        ->limit($limit)
        ->queryAll();
    }

    /**
     * 获取酒店所属客房
     * @param mixed $hotelId 酒店ID
     * @param mixed $limit
     * @return array
     */
    public static function getRooms($hotelId, $limit = -1) {
        $command = Yii::app()->db->createCommand()
        ->select('id, name, hotel_id, bed, breadfast, network, unit_price, estimate_back_credits, activities_start, activities_end, activities_price')
        ->from('{{hotel_room}}')
        ->where('status = :status', array(':status' => self::STATUS_PUBLISH))
        ->order('sort DESC, unit_price DESC')
        ->limit($limit);
        if (is_array($hotelId)) {
            $command->andWhere(array('in', 'hotel_id', $hotelId));
        } else {
            $command->andWhere('hotel_id = :hid', array(':hid' => $hotelId));
        }
        $command->limit = $limit;
        return $command->queryAll();
    }

}
