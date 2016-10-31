<?php

/**
 * 酒店客户模型
 * @author binbin.liao <277250538@qq.com>
 * The followings are the available columns in table '{{hotel_room}}':
 * @property string $id
 * @property string $name
 * @property string $hotel_id
 * @property integer $num
 * @property string $content
 * @property integer $sort
 * @property string $thumbnail
 * @property integer $status
 * @property integer $bed
 * @property integer $breadfast
 * @property string $unit_price
 * @property integer $network
 * @property integer $estimate_price
 * @property integer $estimate_back_credits
 * @property integer $gai_income
 * @property string $create_time
 * @property string $update_time
 * @property string $event_name
 * @property string $activities_price
 * @property string $activities_start
 * @property string $activities_end
 */
class HotelRoom extends CActiveRecord {

    const STATUS_UNPUBLISH = 0;     // 不发布
    const STATUS_PUBLISH = 1;       // 发布
    // 早餐
    const BREAKFAST_NO = 0;     // 无早餐
    const BREAKFAST_ONE = 1;    // 单早
    const BREAKFAST_BOTH = 2;   // 双早
    // 网络
    const NETWORK_NO = 0;       // 无网络
    const NETWORK_FREE = 1;     // 免费网络
    const NETWORK_CHARGE = 2;   // 收费网络
    // 床型
    const BED_BIG = 1;      // 大床
    const BED_BOTH = 2;     // 双床
    const BED_BIG_BOTH = 3; // 大床/双床
    // 床型要求
    const BED_BEST_TO_BIG = 1;  //尽量大床，可接受双床
    const BED_BEST_TO_BOTH = 2; //尽量双床，可接受大床
    const BED_MUST_BE_BIG = 3;  //务必大床，否则取消订单
    const BED_MUST_BE_BOTH = 4;  //务必双床，否则取消订单

    /**
     * 客房状态
     * @param integer|null $id
     * @return array|string
     */

    public static function getStatus($id = null) {
        $arr = array(
            self::STATUS_UNPUBLISH => Yii::t('hotelRoom', '不发布'),
            self::STATUS_PUBLISH => Yii::t('hotelRoom', '发布'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotelRoom', '未知'));
    }

    /**
     * 早餐
     * @param integer|null $id
     * @return array|string
     */
    public static function getBreakfast($id = null) {
        $arr = array(
            self::BREAKFAST_NO => Yii::t('hotelRoom', '无早餐'),
            self::BREAKFAST_ONE => Yii::t('hotelRoom', '单早'),
            self::BREAKFAST_BOTH => Yii::t('hotelRoom', '双早'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotelRoom', '未知'));
    }

    /**
     * 网络
     * @param integer|null $id
     * @return array|string
     */
    public static function getNetwork($id = null) {
        $arr = array(
            self::NETWORK_NO => Yii::t('hotelRoom', '无网络'),
            self::NETWORK_FREE => Yii::t('hotelRoom', '免费网络'),
            self::NETWORK_CHARGE => Yii::t('hotelRoom', '收费网络'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotelRoom', '未知'));
    }

    /**
     * 床型
     * @param integer|null $id
     * @return array|string
     */
    public static function getBed($id = null) {
        $arr = array(
            self::BED_BIG => Yii::t('hotelRoom', '大床'),
            self::BED_BOTH => Yii::t('hotelRoom', '双床'),
            self::BED_BIG_BOTH => Yii::t('hotelRoom', '大床/双床'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotelRoom', '未知'));
    }

    /**
     * 获取床型文本
     * @param integer $id
     * @return array|string
     */
    public static function getBedRequire($id = null) {
        $arr = self::getBedRequireArr();
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotelRoom', '未知'));
    }

    /**
     * 床型要求数据
     * @return array
     */
    public static function getBedRequireArr() {
        return $arr = array(
            self::BED_BEST_TO_BIG => Yii::t('hotelRoom', '尽量大床，可接受双床'),
            self::BED_BEST_TO_BOTH => Yii::t('hotelRoom', '尽量双床，可接受大床'),
            self::BED_MUST_BE_BIG => Yii::t('hotelRoom', '务必大床，否则取消订单'),
            self::BED_MUST_BE_BOTH => Yii::t('hotelRoom', '务必双床，否则取消订单'),
        );
    }

    public function tableName() {
        return '{{hotel_room}}';
    }

    public function rules() {
        return array(
            array('name, num, bed, breadfast, network, unit_price, estimate_price, gai_income', 'required'),
            array('name', 'unique', 'criteria' => array('condition' => 'hotel_id = :hid', 'params' => array(':hid' => $this->hotel_id))),
            array('thumbnail', 'required', 'on' => 'insert'),
            array('num, sort, status, bed, breadfast, network, gai_income', 'numerical', 'integerOnly' => true),
            array('unit_price, estimate_price, estimate_back_credits', 'numerical'),
            array('activities_price', 'numerical'),
            array('name, thumbnail, event_name', 'length', 'max' => 128),
            array('create_time, update_time, enter_count', 'length', 'max' => 11),
            array('num, sort, gai_income', 'length', 'max' => 3),
            array('num', 'compare', 'operator' => '>', 'compareValue' => 0),
            array('status, bed, breadfast, network', 'length', 'max' => 1),
            array('unit_price, estimate_price, estimate_back_credits, activities_price', 'length', 'max' => 9),
            array('unit_price, gai_income', 'compare', 'operator' => '>', 'compareValue' => 0),
//            array('activities_price', 'compare', 'operator' => '>', 'compareValue' => 0, 'allowEmpty' => !(int)$this->activities_price),
//            array('activities_price', 'compare', 'operator' => '>=', 'compareAttribute' => 'estimate_price', 'allowEmpty' => !(int)$this->activities_price),
            array('gai_income', 'compare', 'operator' => '<=', 'compareValue' => 100),
            array('estimate_price', 'compare', 'operator' => '>', 'compareValue' => 0),
            array('estimate_price', 'compare', 'operator' => '<', 'compareAttribute' => 'unit_price'),
            array('activities_start', 'activeTimeDetection'),
            array('activities_end', 'safe', 'on' => 'insert, update'),
            array('status', 'in', 'range' => array_keys(self::getStatus())),
            array('bed', 'in', 'range' => array_keys(self::getBed())),
            array('breadfast', 'in', 'range' => array_keys(self::getBreakfast())),
            array('network', 'in', 'range' => array_keys(self::getNetwork())),
            array('name, event_name, content', 'filter', 'filter' => array($o = new CHtmlPurifier(), 'purify')),
            array('thumbnail', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'allowEmpty' => true,
                'tooLarge' => Yii::t('hotelRoom', '{attribute}最大不超过1MB，请重新上传!')),
            array('id, name, hotel_id, num, content, sort, thumbnail, status, bed, breadfast, unit_price, network, estimate_price,
                    estimate_back_cre, gai_income, create_time, update_time, event_name, activities_price, activities_start, activities_end,
                    enter_count', 'safe', 'on' => 'search'
            ),
            array('activities_price', 'validateActivitiesPrice', 'on' => 'insert,update'),
        );
    }

    /**
     * 活动时间检测
     * @param $attribute
     * @param $params
     */
    public function activeTimeDetection($attribute, $params) {
        if (!empty($this->$attribute)) {
            if (!strtotime($this->activities_start))
                $this->addError('activities_start', $this->getAttributeLabel('activities_start') . Yii::t('hotelRoom', '时间格式错误.'));
            if (strtotime($this->activities_start) < time())
                $this->addError('activities_start', $this->getAttributeLabel('activities_start') . Yii::t('hotelRoom', '必须在当前时间之后.'));
            if (empty($this->event_name))
                $this->addError('event_name', $this->getAttributeLabel('event_name') . Yii::t('hotelRoom', '不能为空.'));
            if (empty($this->activities_price))
                $this->addError('activities_price', $this->getAttributeLabel('activities_price') . Yii::t('hotelRoom', '不能为空.'));
            if ($this->activities_end && !strtotime($this->activities_end))
                $this->addError('activities_end', $this->getAttributeLabel('activities_end') . Yii::t('hotelRoom', '时间格式错误.'));
            if ($this->activities_end && strtotime($this->activities_end) < strtotime($this->activities_start)) {
                $this->addError('activities_end', $this->getAttributeLabel('activities_end') . Yii::t('hotelRoom', '必须在{start_time}之后.', array('{start_time}' => $this->getAttributeLabel('activities_start'))));
            }
        }
    }

    public function relations() {
        return array(
            'hotel' => array(self::BELONGS_TO, 'Hotel', 'hotel_id'),
            'pictures' => array(self::HAS_MANY, 'HotelPicture', 'target_id', 'condition' => 'type=' . HotelPicture::TYPE_ROOM)
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('hotelRoom', 'ID'),
            'name' => Yii::t('hotelRoom', '客房名称'),
            'hotel_id' => Yii::t('hotelRoom', '所属酒店'),
            'num' => Yii::t('hotelRoom', '客房数量'),
            'content' => Yii::t('hotelRoom', '简介'),
            'sort' => Yii::t('hotelRoom', '排序'),
            'thumbnail' => Yii::t('hotelRoom', '客房封面图片'),
            'status' => Yii::t('hotelRoom', '发布状态'),
            'bed' => Yii::t('hotelRoom', '床型'),
            'breadfast' => Yii::t('hotelRoom', '早餐'),
            'unit_price' => Yii::t('hotelRoom', '单价'),
            'network' => Yii::t('hotelRoom', '网络'),
            'estimate_price' => Yii::t('hotelRoom', '预估供货价'),
            'estimate_back_credits' => Yii::t('hotelRoom', '预估返还积分'),
            'gai_income' => Yii::t('hotelRoom', '盖网通收益'),
            'create_time' => Yii::t('hotelRoom', '创建时间'),
            'update_time' => Yii::t('hotelRoom', '最后修改时间'),
            'event_name' => Yii::t('hotelRoom', '特定活动名称'),
            'activities_price' => Yii::t('hotelRoom', '特定活动价格'),
            'activities_start' => Yii::t('hotelRoom', '特定活动开始时间'),
            'activities_end' => Yii::t('hotelRoom', '特定活动结束时间'),
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->create_time = time();
            } else {
                $this->update_time = time();
            }
            $this->activities_start = strtotime($this->activities_start);
            $this->activities_end = strtotime($this->activities_end);
            // 计算预估返还积分
            $this->estimate_back_credits = Common::convertReturn($this->estimate_price, $this->unit_price, $this->gai_income / 100, 'hotelOnConsume');
            return true;
        } else {
            return false;
        }
    }

    /**
     * 在保存之后
     */
    public function afterSave() {
        parent::afterSave();
        // 更新酒店最大、最小价格
        $this->updateHotelExtentPrice();
    }

    /**
     * 在删除之后
     */
    public function afterDelete() {
        parent::afterDelete();
        // 更新酒店最大、最小价格
        $this->updateHotelExtentPrice();
        // 删除客房封面图片
        if ($this->thumbnail)
            UploadedFile::delete(Yii::getPathOfAlias('att') . DS . $this->thumbnail);
        // 删除客房所属的图集
        foreach ($this->pictures as $picture) {
            $picture->delete();
        }
    }

    /**
     * 更新对应酒店最小、最大价格
     */
    private function updateHotelExtentPrice() {
        $res = Yii::app()->db->createCommand()
                ->select('min(`unit_price`) as min_price, max(`unit_price`) as max_price')
                ->from('{{hotel_room}}')
                ->where('hotel_id = ' . $this->hotel_id . ' AND status = ' . self::STATUS_PUBLISH)
                ->queryRow();
        if (!empty($res)) {
            Hotel::model()->updateByPk($this->hotel_id, $res);
        }
    }

    /**
     * 酒店活动是否开始
     * @param int $startTime    酒店活动开始时间
     * @param int $endTime      酒店活动结束时间
     * @return boolean          返回true则有效，false 则无效
     */
    public static function isActivity($startTime, $endTime) {
        if ($startTime > 0) {
            if (!empty($endTime))
                return $startTime <= time() && $endTime >= time();
            return $startTime <= time();
        }
        return false;
    }

    /**
     * 酒店活动价验证
     * @param $attribute
     * @param $params
     */
    public function validateActivitiesPrice($attribute, $params) {
        if (!empty($this->activities_price)) {
            if ($this->activities_price < $this->estimate_price) {
                $this->addError($attribute, "活动价要大于供货价！");
            }

            if ($this->unit_price < $this->activities_price) {
                $this->addError($attribute, "活动价要小于单价！");
            }
        }
    }

}