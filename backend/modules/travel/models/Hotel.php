<?php

/**
 * This is the model class for table "{{hotel}}".
 *
 * The followings are the available columns in table '{{hotel}}':
 * @property string $id
 * @property string $hotel_id
 * @property string $sale_state
 * @property string $chn_name
 * @property string $eng_name
 * @property string $chn_address
 * @property string $eng_address
 * @property string $introduce
 * @property string $telephone
 * @property string $web_site_url
 * @property string $star
 * @property string $layer_high
 * @property string $room_amount
 * @property string $pracice_date
 * @property string $fitment_date
 * @property string $parent_hotel_group
 * @property string $plate_id
 * @property string $city_code
 * @property string $distinct
 * @property string $business
 * @property string $foreign_info
 * @property string $check_in_time
 * @property string $check_out_time
 * @property string $no_smoking_floor
 * @property string $appearance_pic_url
 * @property string $service_fixture
 * @property string $room_fixture
 * @property string $free_service
 * @property string $other_fixture
 * @property string $longitude
 * @property string $latitude
 * @property string $traffic_info
 * @property integer $source
 * @property integer $sort
 * @property string $creater
 * @property string $updater
 * @property string $created_at
 * @property string $updated_at
 */
class Hotel extends CActiveRecord
{
    //手工hotel_id开始值
    const HAND_HOTEL_ID_STAR = 50000000;

    //销售状态
    const SALE_STATE_STOP = 0;
    const SALE_STATE_NORMAL = 1;

    //来源
    const SOURCE_API = 1;
    const SOURCE_BY_HAND = 2;

    //发布状态
    const STATUS_NO = 0;
    const STATUS_YES = 1;

    public $nation_id;
    public $province_code;


    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{hotel}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('hotel_id, sale_state, chn_name, chn_address, introduce, telephone, star,  layer_high, room_amount, city_code, distinct,  other_fixture, longitude, latitude, traffic_info, source, created_at', 'required'),
            array('source, nation_id, sort', 'numerical', 'integerOnly' => true),
            array('hotel_id, sale_state, star, layer_high, room_amount, parent_hotel_group, plate_id, check_in_time, check_out_time, no_smoking_floor, longitude, latitude, creater, updater, created_at, updated_at', 'length', 'max' => 11),
            array('chn_name, eng_name, web_site_url, pracice_date, fitment_date, foreign_info', 'length', 'max' => 128),
            array('chn_address, eng_address, appearance_pic_url,  service_fixture, room_fixture, free_service, other_fixture', 'length', 'max' => 256),
            array('telephone, city_code, distinct, business,province_code', 'length', 'max' => 32),
            //  array('telephone', 'comext.validators.isMobile', 'errMsg' => '请输入正确的手机号码'),
            array('appearance_pic_url', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'allowEmpty' => $this->getScenario() == 'update' ? true : true, 'tooLarge' => '{thumbnail}最大不超过1MB，请重新上传!'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, hotel_id, sale_state, source, chn_name, eng_name, chn_address, eng_address, introduce, telephone, web_site_url, star, layer_high, room_amount, pracice_date, fitment_date, parent_hotel_group, plate_id, city_code, distinct, business, foreign_info, check_in_time, check_out_time, no_smoking_floor, appearance_pic_url, service_fixture, room_fixture, free_service, other_fixture, longitude, latitude, traffic_info, source, creater, updater, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'mCity' => array(self::HAS_ONE, 'City', '', 'on' => 't.city_code=mCity.code', 'select' => 'province_code,code,name'),
            //  'province' => array(self::HAS_ONE, 'Province', '', 'on' => 'mCity.province_code=province.code', 'select' => 'nation_id,code,name'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '主键id',
            'hotel_id' => '酒店ID',
            'sale_state' => '销售状态',
            'chn_name' => '中文名',
            'eng_name' => '英文名',
            'chn_address' => '中文地址',
            'eng_address' => '英文地址',
            'introduce' => '介绍',
            'telephone' => '电话',
            'web_site_url' => '网址',
            'star' => '星级',
            'layer_high' => '层高',
            'room_amount' => '房间数量',
            'pracice_date' => '开业时间',
            'fitment_date' => '装修时间',
            'parent_hotel_group' => '酒店集团',
            'plate_id' => '品牌',
            'city_code' => '城市',
            'distinct' => '行政区',
            'business' => '商业区',
            'foreign_info' => '国籍',
            'check_in_time' => '入住时间',
            'check_out_time' => '退房时间',
            'no_smoking_floor' => '无烟楼层',
            'appearance_pic_url' => '外观图',
            'service_fixture' => '服务条款',
            'room_fixture' => '房间条款',
            'free_service' => '免费服务',
            'other_fixture' => '其它条款',
            'longitude' => '经度',
            'latitude' => '纬度',
            'traffic_info' => '交通信息',
            'source' => '来源',
            'sort' => '首页推荐排序',
            'creater' => '创建人',
            'updater' => '更新人',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'nation_id' => '国家',
            'province_code' => '省份',
        );
    }

    /**
     * 获取销售状态
     * @param null $key
     * @return array|string
     */
    public static function getSaleState($key = null)
    {
        $arr = array(
            self::SALE_STATE_STOP => '停止',
            self::SALE_STATE_NORMAL => '正常',

        );
        return ($key != null) ? (isset($arr[$key]) ? $arr[$key] : '') : $arr;
    }

    /**
     * 获取酒店来源
     * @param null $key
     * @return array|string
     */
    public static function getSource($key = null)
    {
        $arr = array(
            self::SOURCE_API => 'API',
            self::SOURCE_BY_HAND => '手工',
        );
        return $key ? (isset($arr[$key]) ? $arr[$key] : '') : $arr;
    }

    /**
     * 获取酒店发布状态
     * @param null $key
     * @return array|string
     */
    public static function getStatus($key =null){
        $arr = array(
            self::STATUS_NO => '未发布',
            self::STATUS_YES => '已发布',

        );
        return ($key != null) ? (isset($arr[$key]) ? $arr[$key] : '') : $arr;
    }

    /**
     * 搜索
     * @return CActiveDataProvider
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('mCity', 'mCity.province', 'mCity.province.nation');
        $criteria->compare('id', $this->id, true);
        $criteria->compare('hotel_id', $this->hotel_id, true);
        $criteria->compare('sale_state', $this->sale_state, true);
        $criteria->compare('chn_name', $this->chn_name, true);
        $criteria->compare('eng_name', $this->eng_name, true);
        $criteria->compare('chn_address', $this->chn_address, true);
        $criteria->compare('eng_address', $this->eng_address, true);
        $criteria->compare('introduce', $this->introduce, true);
        $criteria->compare('telephone', $this->telephone, true);
        $criteria->compare('web_site_url', $this->web_site_url, true);
        $criteria->compare('star', $this->star, true);
        $criteria->compare('layer_high', $this->layer_high, true);
        $criteria->compare('room_amount', $this->room_amount, true);
        $criteria->compare('pracice_date', $this->pracice_date, true);
        $criteria->compare('fitment_date', $this->fitment_date, true);
        $criteria->compare('parent_hotel_group', $this->parent_hotel_group, true);
        $criteria->compare('plate_id', $this->plate_id, true);
        $criteria->compare('city_code', $this->city_code, true);
        $criteria->compare('distinct', $this->distinct, true);
        $criteria->compare('business', $this->business, true);
        $criteria->compare('foreign_info', $this->foreign_info, true);
        $criteria->compare('check_in_time', $this->check_in_time, true);
        $criteria->compare('check_out_time', $this->check_out_time, true);
        $criteria->compare('no_smoking_floor', $this->no_smoking_floor, true);
        $criteria->compare('appearance_pic_url', $this->appearance_pic_url, true);
        $criteria->compare('service_fixture', $this->service_fixture, true);
        $criteria->compare('room_fixture', $this->room_fixture, true);
        $criteria->compare('free_service', $this->free_service, true);
        $criteria->compare('other_fixture', $this->other_fixture, true);
        $criteria->compare('longitude', $this->longitude, true);
        $criteria->compare('latitude', $this->latitude, true);
        $criteria->compare('traffic_info', $this->traffic_info, true);
        $criteria->compare('source', $this->source);
        $criteria->compare('creater', $this->creater);
        $criteria->compare('updater', $this->updater);
        $criteria->compare('created_at', $this->created_at);
        $criteria->compare('updated_at', $this->updated_at);
        $criteria->compare('province.code', $this->province_code);
        $criteria->compare('nation.id', $this->nation_id);
        //    $criteria->order = 't.sort asc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection()
    {
        return Yii::app()->tr;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Hotel the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 生成手工添加酒店ID
     * @return int
     */
    public static function createHandHotelID()
    {
        $id = Yii::app()->tr->createCommand()->select('max(hotel_id)')->from('{{hotel}}')->queryScalar();
        if ($id && $id > self::HAND_HOTEL_ID_STAR) {
            return $id + 1;
        } else {
            return self::HAND_HOTEL_ID_STAR + 1;
        }
    }
}
