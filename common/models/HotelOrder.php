<?php

/**
 * 酒店订单模型
 * @author jianlin_lin <hayeslam@163.com>
 *
 * The followings are the available columns in table '{{hotel_order}}':
 * @property string $id
 * @property string $amount_returned
 * @property string $code
 * @property string $member_id
 * @property string $hotel_id
 * @property string $hotel_name
 * @property string $room_id
 * @property string $room_name
 * @property string $breakfast
 * @property string $bed
 * @property string $settled_time
 * @property string $leave_time
 * @property string $earliest_time
 * @property string $latest_time
 * @property string $latest_cancel_time
 * @property integer $rooms
 * @property integer $peoples
 * @property string $people_infos
 * @property string $contact
 * @property string $mobile
 * @property string $unit_price
 * @property string $unit_gai_price
 * @property string $payed_price
 * @property string $unpay_price
 * @property string $total_price
 * @property integer $pay_status
 * @property integer $status
 * @property string $score
 * @property string $comment
 * @property string $create_time
 * @property string $pay_time
 * @property string $confirm_time
 * @property string $comment_time
 * @property integer $is_lottery
 * @property string $lottery_price
 * @property string $lottery_radio
 * @property string $price_radio
 * @property integer $gai_income
 * @property string $refund_radio
 * @property string $complete_time
 * @property string $live_time
 * @property integer $is_recon
 * @property string $refund
 * @property string $confirm_user
 * @property string $recon_user
 * @property string $recon_time
 * @property string $remark
 * @property string $distribution_ratio
 * @property string $extend
 * @property string $parent_code
 * @property string $cancle_time
 * @property integer $is_check
 * @property string $check_time
 * @property string $hotel_provider_id
 * @property string $check_user
 * @property string $check_remark
 * @property string $source
 * @property integer $pay_type
 * @property string $reserveRoomId
 * @property string $is_sign
 * @property string $sign_remark
 * @property string $sign_user
 * @property string $sign_time
 *
 * relations
 * @property Hotel $hotel
 * @property Hotel $hotelPay
 * @property HotelRoom $room
 * @property HotelProvider $provider
 * @property Member $member
 */
class HotelOrder extends CActiveRecord {

    public $isExport;   // 是否导出Excel
    public $exportLimit = 5000; // 导出Excel长度
    public $minPrice;   // 最低价
    public $maxPrice;   // 最高价
    public $startTime;  // 开始时间
    public $endTime;    // 结束时间
    public $hotelName;  // 酒店名称
    public $memberNumber;   // 会员编码
    public $sortWay;    // 排序方式
    public $timeout;    // 订单处理超时
    public $reserveRoomId;  // 预定客房ID
    public $type_id; // 会员类型

    public $createTimeStart; //订单创建开始日期
    public $createTimeEnd; //订单创建结束日期

    public $cancel_clause;//不可取消条款

    const IS_COMMENT_NO = 0.0; // 没有评论默认为0.0
    // 支付状态
    const PAY_STATUS_NO = 0; // 未支付
    const PAY_STATUS_YES = 1; // 已支付
    // 订单状态
    const STATUS_NEW = 0; // 新订单
    const STATUS_VERIFY = 1; // 订单确认
    const STATUS_SUCCEED = 2; // 订单完成
    const STATUS_CLOSE = 3; // 订单关闭
    // 是否抽奖
    const IS_LOTTERY_NO = 0; // 否
    const IS_LOTTERY_YES = 1; // 是
    // 是否核对
    const IS_CHECK_NO = 0; // 否
    const IS_CHECK_YES = 1; // 是
    // 是否对账
    const IS_RECON_NO = 0; // 否
    const IS_RECON_YES = 1; // 是
    // 条件排序
    const SORT_DESC_TIME = 0;
    const SORT_DESC_PAYSTATUS = 1;
    const SORT_DESC_TOTALPRICE = 2;
    // 订单来源
    const SOURCE_WEB = 1; // 网站
    const SOURCE_ANDROID = 2; // ANDROID
    const SOURCE_IOS = 3; // IOS

    //订单签收状态
    const IS_SIGN_NO = 0; //否
    const IS_SIGN_YES = 1; //是

    public function tableName() {
        return '{{hotel_order}}';
    }

    /**
     * 获取支付状态
     * @param null|int $id
     * @return array|string
     */
    public static function getPayStatus($id = null) {
        $arr = array(
            self::PAY_STATUS_NO => Yii::t('hotelOrder', '未支付'),
            self::PAY_STATUS_YES => Yii::t('hotelOrder', '已支付'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotelOrder', '未知'));
    }

    /**
     * 获取订单状态
     * @param null|int $id
     * @return array|string
     */
    public static function getOrderStatus($id = null) {
        $arr = array(
            self::STATUS_NEW => Yii::t('hotelOrder', '新订单'),
            self::STATUS_VERIFY => Yii::t('hotelOrder', '订单确认'),
            self::STATUS_SUCCEED => Yii::t('hotelOrder', '订单完成'),
            self::STATUS_CLOSE => Yii::t('hotelOrder', '订单关闭'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotelOrder', '未知'));
    }

    /**
     * 是否抽奖
     * @param null|int $id
     * @return array|string
     */
    public static function getIsLottery($id = null) {
        $arr = array(
            self::IS_LOTTERY_NO => Yii::t('hotelOrder', '否'),
            self::IS_LOTTERY_YES => Yii::t('hotelOrder', '是'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotelOrder', '未知'));
    }

    /**
     * 获取排序
     * @param null|int $id
     * @return array|string
     */
    public static function getSortWay($id = null) {
        $arr = array(
            self::SORT_DESC_TIME => Yii::t('hotelOrder', '入住时间顺序优先'),
            self::SORT_DESC_PAYSTATUS => Yii::t('hotelOrder', '支付状态倒序优先'),
            self::SORT_DESC_TOTALPRICE => Yii::t('hotelOrder', '总价倒序优先'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotelOrder', '未知'));
    }

    /**
     * 是否签收
     * @param null|int $id
     * @return array|string
     */
    public static function getIsSign($id = null) {
        $arr = array(
            self::IS_SIGN_NO => Yii::t('hotelOrder', '未签收'),
            self::IS_SIGN_YES => Yii::t('hotelOrder', '已签收'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotelOrder', '未知'));
    }

    /**
     * 是否核对
     * @param null|int $id
     * @return array|string
     */
    public static function getIsCheck($id = null) {
        $arr = array(
            self::IS_CHECK_NO => Yii::t('hotelOrder', '未核对'),
            self::IS_CHECK_YES => Yii::t('hotelOrder', '已核对'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotelOrder', '未知'));
    }

    /**
     * 是否对账
     * @param null|int $id
     * @return array|string
     */
    public static function getIsRecon($id = null) {
        $arr = array(
            self::IS_RECON_NO => Yii::t('hotelOrder', '未对账'),
            self::IS_RECON_YES => Yii::t('hotelOrder', '已对账'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotelOrder', '未知'));
    }

    /**
     * 订单来源
     * @param null|int $id
     * @return array|string
     */
    public static function getSource($id = null) {
        $arr = array(
            self::SOURCE_WEB => Yii::t('hotelOrder', '网站'),
            self::SOURCE_ANDROID => Yii::t('hotelOrder', '安卓客户端'),
            self::SOURCE_IOS => Yii::t('hotelOrder', '苹果客户端'),
        );
        return is_null($id) ? $arr : (isset($arr[$id]) ? $arr[$id] : Yii::t('hotelOrder', '未知'));
    }

    public function rules() {
        return array(
            array('rooms, peoples, pay_status, status, is_lottery, gai_income, is_recon', 'numerical', 'integerOnly' => true),
            array('amount_returned, unit_price, unit_gai_price, payed_price, unpay_price, total_price, lottery_price, lottery_radio, price_radio, refund_radio, refund', 'length', 'max' => 10),
            array('code', 'length', 'max' => 32),
            array('member_id, hotel_id, room_id, settled_time, leave_time, create_time, pay_time, confirm_time, comment_time, complete_time, recon_time', 'length', 'max' => 11),
            array('earliest_time, latest_time', 'length', 'max' => 64),
            array('contact, confirm_user, recon_user', 'length', 'max' => 128),
            array('mobile', 'length', 'max' => 16),
            // 预定酒店
            array('rooms, settled_time, leave_time, earliest_time, contact, mobile, peoples, people_infos, bed', 'required', 'on' => 'insert'),
            array('bed,remark', 'safe'),
            array('rooms', 'validateRooms', 'on' => 'insert, orderVerify'),
            array('rooms', 'compare', 'operator' => '>', 'compareValue' => 0, 'message' => Yii::t('hotelOrder', '房数不能为0'), 'on' => 'checkRooms'),
            array('rooms', 'numerical', 'on' => 'checkRooms'),
            array('rooms', 'compare', 'operator' => '>', 'compareValue' => 0, 'message' => Yii::t('hotelOrder', '房间数量必须大于 0'), 'on' => 'orderVerify, orderCheck'), // 房间数量必须大于 0
            array('contact', 'match', 'pattern' => '/^[a-zA-Z\{4e00}-\x{9fa5}]+$/u', 'message' => Yii::t('hotelOrder', '联系人只能是中英文'), 'on' => 'insert'),
            array('mobile', 'match', 'pattern' => '/^0{0,1}(13[0-9]|15[0-9]|18[0-9])[0-9]{8}$/', 'message' => Yii::t('hotelOrder', '请输入正确的联系号码'), 'on' => 'insert'),
            array('settled_time, leave_time', 'validityCheckInDate', 'on' => 'insert, orderVerify'),
            array('settled_time', 'validateLatestCheckInTime', 'on' => 'insert'),
            array('earliest_time, latest_time, bed, remark', 'filter', 'filter' => array($o = new CHtmlPurifier(), 'purify'), 'on' => 'insert'),
            array('peoples', 'validateCheckInNumber', 'on' => 'insert'),
            array('cancel_clause','required', 'requiredValue'=>true,'message'=>'请确认是否同意该条款', 'on'=>'checkRooms'),//必须选择条款才能下订单
            // 订单支付
            array('is_lottery', 'in', 'range' => array_keys(self::getIsLottery()), 'message' => Yii::t('hotelOrder', '请确认是否抽奖'), 'on' => 'orderPay'),
            // 订单评论
            array('score, comment', 'required', 'on' => 'comment'),
            array('comment', 'filter', 'filter' => array($o = new CHtmlPurifier(), 'purify'), 'on' => 'comment'),
            array('score', 'in', 'range' => array(1, 2, 3, 4, 5), 'on' => 'comment', 'message' => Yii::t('hotelOrder', '请为该酒店打分')),
            // 核对、确认，订单
            array('rooms, settled_time, leave_time, hotel_id, room_id, price_radio, unit_gai_price, hotel_provider_id', 'required', 'on' => 'orderVerify'),
            array('unit_gai_price, hotel_provider_id, price_radio, check_remark', 'required', 'on' => 'orderCheck'),
            array('hotel_id, room_id, hotel_provider_id', 'numerical', 'integerOnly' => true, 'on' => 'orderVerify'),
            array('price_radio, unit_gai_price', 'numerical', 'on' => 'orderVerify'),
            array('price_radio', 'compare', 'operator' => '>', 'compareValue' => 1, 'on' => 'orderVerify, orderCheck'), // 供货系数必须大于 1
            array('price_radio', 'compare', 'operator' => '<=', 'compareValue' => 2, 'on' => 'orderVerify, orderCheck'), // 供货系数必须小于等于 2
            array('unit_price', 'validateTotalPrice', 'on' => 'orderVerify'),
            array('unit_gai_price', 'compare', 'operator' => '>', 'compareValue' => 0, 'on' => 'orderVerify, orderCheck'), // 供货价必须大于 0
            array('unit_gai_price', 'validateGaiPrice', 'on' => 'orderVerify, orderCheck'),
            array('hotel_provider_id', 'validateEnterpriseMember', 'on' => 'orderVerify, orderCheck'),
            array('check_remark', 'filter', 'filter' => array($o = new CHtmlPurifier(), 'purify'), 'on' => 'orderCheck'),
            // 完成订单
            array('live_time', 'required', 'on' => 'orderComplete'),
            array('live_time', 'validateLiveTime', 'on' => 'orderComplete'),
            // 搜索订单
            array('code, status, hotel_name, startTime, endTime', 'safe', 'on' => 'frontSearch'),
            array('code, hotelName, memberNumber, startTime, endTime, maxPrice, minPrice, sortWay, isExport, exportLimit, timeout, createTimeStart, createTimeEnd', 'safe', 'on' => 'search'),
            //签收订单
            array('is_sign, sign_remark, sign_user, sign_time', 'required', 'on' => 'orderSign'),
            array('is_sign,sign_time', 'numerical' ,'integerOnly'=>true),
        );
    }

    /**
     * 酒店订单完成，验证最终入住时间
     * @param $attribute
     * @param $params
     */
    public function validateLiveTime($attribute, $params) {
        if (strtotime($this->live_time) > $this->leave_time) {
            $this->addError($attribute, "入住时间应在离开时间之前");
        }
    }

    /**
     * 预定酒店，客房数量验证
     * @param $attribute
     * @param $params
     */
    public function validateRooms($attribute, $params) {
        if ($this->getScenario() == 'insert') {
            $num = (int) Yii::app()->db->createCommand()->select('num')->from('{{hotel_room}}')->where('id = :id', array(':id' => $this->reserveRoomId))->queryScalar();
            if ($num != 0 && $this->$attribute > $num) {
                $this->addError($attribute, "预定房数不能超过{$num}间");
            }
        }
    }

    /**
     * 当天最晚入住时间验证
     * @param $attribute
     * @param $params
     */
    public function validateLatestCheckInTime($attribute, $params) {
        $latestStr = Tool::getConfig('hotelparams', 'latestStayTime');
        $latestTime = strtotime("{$this->$attribute} {$latestStr}");
        if ($latestStr != '' && $latestTime !== false && time() >= $latestTime && date('Y-m-d') == $this->$attribute) {
            $this->addError($attribute, Yii::t('hotelOrder', "当日预订入住酒店，请在当日的{$latestStr}以前预订"));
        }
    }

    /**
     * 有效的入住日期验证
     * @param $attribute
     * @param $params
     */
    public function validityCheckInDate($attribute, $params) {
        $settledTime = strtotime($this->settled_time);
        $leaveTime = strtotime($this->leave_time);
        if ($settledTime === false || $leaveTime === false)
            $this->addError($attribute, Yii::t('hotelOrder', "请输入合法日期"));
        if ($this->getScenario() == 'insert' && $attribute == 'settled_time' && $settledTime < strtotime(date('Y-m-d')))
            $this->addError($attribute, Yii::t('hotelOrder', "入住时间只能是今天或以后"));
        if ($settledTime >= $leaveTime) {
            $attrName = $this->getAttributeLabel($attribute);
            $this->addError($attribute, Yii::t('hotelOrder', "请填写正确的") . $attrName);
        }
    }

    /**
     * 验证入住人数
     * @param $attribute
     * @param $params
     */
    public function validateCheckInNumber($attribute, $params) {
        if ($this->$attribute != count($this->people_infos))
            $this->addError($attribute, $this->getAttributeLabel($attribute) . Yii::t('hotelOrder', '与住客信息人数不相等'));
    }

    /**
     * 验证订单确认后的总金额是否超出
     * @param string $attribute
     * @param array $params
     */
    public function validateTotalPrice($attribute, $params) {
        $time = array('settled_time' => strtotime($this->settled_time), 'leave_time' => strtotime($this->leave_time));
        $orderPrice = HotelCalculate::price(array_merge($this->attributes, $time));
        if ($orderPrice['total'] > $this->total_price)
            $this->addError($attribute, Yii::t('hotelOrder', '订单总价已超出支付总价'));
    }

    /**
     * 验证供货价
     * @param string $attribute
     * @param array $params
     */
    public function validateGaiPrice($attribute, $params) {
        if ($this->is_lottery == self::IS_LOTTERY_NO && $this->unit_gai_price > $this->unit_price)
            $this->addError($attribute, $this->getAttributeLabel($attribute) . Yii::t('hotelOrder', '必须小于或者等于 "{price}"', array('{price}' => $this->unit_price)));
        if ($this->is_lottery == self::IS_LOTTERY_YES && $this->unit_gai_price * $this->price_radio > $this->unit_price)
            $this->addError($attribute, $this->getAttributeLabel($attribute) . Yii::t('hotelOrder', '与系数相乘不能大于 "{price}"', array('{price}' => $this->unit_price)));
    }

    /**
     * 验证企业会员
     * @param $attribute
     * @param $params
     * @author jianlin.lin
     */
    public function validateEnterpriseMember($attribute, $params) {
        $enterprise_id = Yii::app()->db->createCommand()
                ->select('e.id as eid')
                ->from('{{hotel_provider}} as h')
                ->leftJoin('{{member}} as m', 'h.member_id=m.id')
                ->leftJoin('{{enterprise}} as e', 'm.enterprise_id=e.id')
                ->where('h.id=:hid', array(':hid' => $this->hotel_provider_id))
                ->queryScalar();
        if (!$enterprise_id) {
            $this->addError($attribute, $this->getAttributeLabel($attribute) . Yii::t('hotelOrder', '必须是企业会员'));
        }
    }

    public function relations() {
        return array(
            'hotel' => array(self::BELONGS_TO, 'Hotel', 'hotel_id'),
            'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
            'room' => array(self::BELONGS_TO, 'HotelRoom', 'room_id'),
            'hotelPay' => array(self::BELONGS_TO, 'Hotel', 'hotel_id', 'select' => 'id, name, thumbnail'),
            'provider' => array(self::BELONGS_TO, 'HotelProvider', 'hotel_provider_id'),
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     *  在保存之前
     * @return bool
     */
    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord || $this->getScenario() == 'orderVerify') {
                $this->settled_time = strtotime($this->settled_time);
                $this->leave_time = strtotime($this->leave_time);
            }
            if ($this->isNewRecord) {
                $this->people_infos = json_encode($this->people_infos);
                $this->create_time = time();
            }
            return true;
        }
        return false;
    }

    public function attributeLabels() {
        return array(
            // 表字段属性
            'id' => Yii::t('hotelOrder', '主键'),
            'amount_returned' => Yii::t('hotelOrder', '返还积分'), // 数据已金钱计，显示已积分计
            'code' => Yii::t('hotelOrder', '编号'),
            'member_id' => Yii::t('hotelOrder', '所属会员'),
            'hotel_id' => Yii::t('hotelOrder', '酒店'),
            'hotel_name' => Yii::t('hotelOrder', '酒店名称'),
            'room_id' => Yii::t('hotelOrder', '客房'),
            'room_name' => Yii::t('hotelOrder', '客房名称'),
            'breakfast' => Yii::t('hotelOrder', '早餐'),
            'bed' => Yii::t('hotelOrder', '床型要求'),
            'settled_time' => Yii::t('hotelOrder', '入住日期'),
            'leave_time' => Yii::t('hotelOrder', '退房日期'),
            'earliest_time' => Yii::t('hotelOrder', '最早到达'),
            'latest_time' => Yii::t('hotelOrder', '最迟到达'),
            'rooms' => Yii::t('hotelOrder', '房间数量'),
            'peoples' => Yii::t('hotelOrder', '到店人数'),
            'people_infos' => Yii::t('hotelOrder', '入住人'),
            'contact' => Yii::t('hotelOrder', '联系人'),
            'mobile' => Yii::t('hotelOrder', '联系号码'),
            'unit_price' => Yii::t('hotelOrder', '销售单价'),
            'unit_gai_price' => Yii::t('hotelOrder', '供货价'),
            'payed_price' => Yii::t('hotelOrder', '已支付'),
            'unpay_price' => Yii::t('hotelOrder', '未支付'),
            'total_price' => Yii::t('hotelOrder', '总价'),
            'pay_status' => Yii::t('hotelOrder', '支付状态'),
            'status' => Yii::t('hotelOrder', '订单状态'),
            'score' => Yii::t('hotelOrder', '评分'),
            'comment' => Yii::t('hotelOrder', '评论内容'),
            'create_time' => Yii::t('hotelOrder', '下单时间'),
            'pay_time' => Yii::t('hotelOrder', '支付时间'),
            'confirm_time' => Yii::t('hotelOrder', '确认时间'),
            'comment_time' => Yii::t('hotelOrder', '评论时间'),
            'is_lottery' => Yii::t('hotelOrder', '是否抽奖'),
            'lottery_price' => Yii::t('hotelOrder', '抽奖金额'),
            'lottery_radio' => Yii::t('hotelOrder', '抽奖系数'),
            'price_radio' => Yii::t('hotelOrder', '供货价系数'),
            'gai_income' => Yii::t('hotelOrder', '盖网通收入'),
            'refund_radio' => Yii::t('hotelOrder', '手续费率'),
            'complete_time' => Yii::t('hotelOrder', '完成时间'),
            'live_time' => Yii::t('hotelOrder', '最终入住时间'),
            'is_recon' => Yii::t('hotelOrder', '是否对账'),
            'refund' => Yii::t('hotelOrder', '手续费'),
            'confirm_user' => Yii::t('hotelOrder', '确认人'),
            'recon_user' => Yii::t('hotelOrder', '对账人'),
            'recon_time' => Yii::t('hotelOrder', '对账时间'),
            'remark' => Yii::t('hotelOrder', '特殊要求'),
            'distribution_ratio' => Yii::t('hotelOrder', '分配比率'),
            'extend' => Yii::t('hotelOrder', '扩展信息'),
            'parent_code' => Yii::t('hotelOrder', '网银单号'),
            'cancle_time' => Yii::t('hotelOrder', '取消时间'),
            'is_check' => Yii::t('hotelOrder', '是否核对'),
            'check_time' => Yii::t('hotelOrder', '核对时间'),
            'hotel_provider_id' => Yii::t('hotelOrder', '供应商'),
            'check_user' => Yii::t('hotelOrder', '核对人'),
            'check_remark' => Yii::t('hotelOrder', '核对备注'),
            'source' => Yii::t('hotelOrder', '订单来源'),
            'pay_type' => Yii::t('hotelOrder', '支付方式'),
            // 表单附加属性
            'TimeOfArrival' => Yii::t('hotelOrder', '到店时间'),
            // 模型自定义属性
            'minPrice' => Yii::t('hotelOrder', '最小价格'),
            'maxPrice' => Yii::t('hotelOrder', '最大价格'),
            'statrTime' => Yii::t('hotelOrder', '开始时间'),
            'endTime' => Yii::t('hotelOrder', '结束时间'),
            'hotelName' => Yii::t('hotelOrder', '酒店名称'),
            'memberNumber' => Yii::t('hotelOrder', '盖网通编号'),
            'sortWay' => Yii::t('hotelOrder', '排序方式'),
            'timeout' => Yii::t('hotelOrder', '确认时间超过设置时长的订单'),
            'is_sign' => '是否签收',
            'sign_remark' => '签收备注',
            'sign_user' => '签收人',
            'sign_time' => '签收时间',
            'cancel_clause' => '取消条款',
        );
    }

    /**
     * 搜索
     * @return CActiveDataProvider
     */
    public function search() {
        $action = Yii::app()->controller->getAction()->id;
        $criteria = new CDbCriteria;
        if ($action == 'newList') {
            $criteria->compare('t.status', self::STATUS_NEW);       // 新订单
            $criteria->compare('t.pay_status', $this->pay_status);  // 支付状态
            $criteria->compare('t.is_sign', self::IS_SIGN_NO);     //是否签收
        }else if ($action == 'noVerifyList') {
            $criteria->compare('t.status', self::STATUS_NEW);       // 新订单
            $criteria->compare('t.pay_status', $this->pay_status);  // 支付状态
            $criteria->compare('t.is_sign', self::IS_SIGN_YES);     //是否签收
        } else if ($action == 'verifyList') {
            $criteria->compare('t.status', self::STATUS_VERIFY);        // 订单状态为确认
            $criteria->compare('t.pay_status', self::PAY_STATUS_YES);   // 支付状态为已支付
            $criteria->compare('t.is_check', self::IS_CHECK_NO);        // 核对状态为未核对
            $criteria->compare('t.is_recon', self::IS_RECON_NO);        // 对账状态为未对账
        } else if ($action == 'checkList' || $action == 'checkListExport') {
            $criteria->compare('t.status', self::STATUS_VERIFY);        // 订单状态为确认
            $criteria->compare('t.pay_status', self::PAY_STATUS_YES);   // 支付状态为已支付
            $criteria->compare('t.is_check', self::IS_CHECK_YES);       // 核对状态为已核对
            $criteria->compare('t.is_recon', self::IS_RECON_NO);        // 对账状态为未对账
        } else if ($action == 'checkingList') {
            $criteria->compare('t.status', self::STATUS_VERIFY);        // 订单状态为确认
            $criteria->compare('t.pay_status', self::PAY_STATUS_YES);   // 支付状态为已支付
            $criteria->compare('t.is_check', self::IS_CHECK_YES);       // 核对状态为已核对
            $criteria->compare('t.is_recon', self::IS_RECON_YES);       // 对账状态为已对账
        } else {
            if ($this->timeout) {
                $duration = 60 * Tool::getConfig('hotelparams', 'duration');
                $criteria->compare('t.status', self::STATUS_VERIFY);    // 订单状态为确认
                $criteria->addCondition("t.confirm_time - t.create_time > '$duration'");
            } else {
                $criteria->compare('t.status', $this->status);          // 订单状态
                $criteria->compare('t.pay_status', $this->pay_status);  // 支付状态为已支付
            }
        }

        $criteria->compare('code', $this->code, true);  // 订单编号
        $criteria->compare('t.hotel_name', $this->hotelName, true);   // 酒店名称
        $criteria->compare('m.gai_number', $this->memberNumber, true); // 会员编码
        // 入住、完成，时间范围
        $searchDate = Tool::searchDateFormat($this->startTime, $this->endTime);
        if ($action == 'admin' || $action = 'checkList') {
            $criteria->compare('t.settled_time', ">=" . $searchDate['start']);
            $criteria->compare('t.settled_time', "<=" . $searchDate['end']);
        } else if ($action == 'checkingList') {
            $criteria->compare('t.complete_time', ">=" . $searchDate['start']);
            $criteria->compare('t.complete_time', "<=" . $searchDate['end']);
        }
        //搜索订单创建日期
        $searchCreateDate = Tool::searchDateFormat($this->createTimeStart, $this->createTimeEnd);
        $criteria->compare('t.create_time', ">=" . $searchCreateDate['start']);
        $criteria->compare('t.create_time', "<=" . $searchCreateDate['end']);


        // 订单总价区间
        if (isset($this->maxPrice)) {
            $criteria->compare('total_price', "<=" . $this->maxPrice);
            if (isset($this->minPrice)) {
                $criteria->compare('total_price', ">=" . $this->minPrice);
            }
        }

        // 订单排序方式
        if (array_key_exists($this->sortWay, HotelOrder::getSortWay())) {
            if ($this->sortWay == self::SORT_DESC_TOTALPRICE) {
                $criteria->order = 't.total_price DESC';
            } elseif ($this->sortWay == self::SORT_DESC_PAYSTATUS) {
                $criteria->order = 't.pay_status DESC';
            } else {
                $criteria->order = 't.settled_time DESC';
            }
        }
        $criteria->select = 't.*,m.type_id,m.gai_number';
        $criteria->join = 'left join gw_member as m on t.member_id=m.id';

        // 导出 Excel
        $pagination = array();
        if (!empty($this->isExport)) {
            $pagination['pageVar'] = 'page';
            $pagination['pageSize'] = $this->exportLimit;
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pagination,
            'sort' => array(
                'defaultOrder' => 't.create_time DESC', // 设置默认排序
            ),
        ));
    }

    /**
     * 前台搜索
     * @return CActiveDataProvider
     */
    public function frontSearch() {
        $criteria = new CDbCriteria;
        $criteria->select = "t.id, t.code, t.amount_returned, t.hotel_id, t.hotel_name, t.room_name, t.total_price,
            t.settled_time, t.leave_time, t.pay_status, t.status, t.score, t.create_time";
        $criteria->compare('t.member_id', Yii::app()->user->id);
        $criteria->compare('t.code', trim($this->code), true);
        $criteria->compare('t.hotel_name', trim($this->hotel_name), true);
        $criteria->compare('t.status', $this->status);
        $criteria->with = array('hotel' => array('select' => 'hotel.thumbnail'));
        $searchDate = Tool::searchDateFormat($this->startTime, $this->endTime);
        $criteria->compare('t.create_time', ">=" . $searchDate['start']);
        $criteria->compare('t.create_time', "<" . $searchDate['end']);

        return new CActiveDataProvider('HotelOrder', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 5,
                'pageVar' => 'page',
            ),
            'sort' => array(
                'defaultOrder' => 't.create_time DESC',
            )
                )
        );
    }

    /**
     * 解析订单住客信息
     * @param array $infoStr 订单住客信息 json 数据
     * @param boolean $gn 获取所有住客姓名 默认获取住客所有信息
     * @param string $gNeedle 组分隔符 默认：“、”
     * @param string $iNeedle 项隔符 默认：“，”
     * @param string $kvNeedle 键值分隔符 默认：“：”
     * @return string
     * @author jianlin.lin
     */
    public static function analysisLodgerInfo($infoStr, $gn = false, $gNeedle = '、', $iNeedle = '，', $kvNeedle = '：') {
        $string = '';
        $info = json_decode($infoStr, true);
        if (is_array($info) && !empty($info)) {
            $count = count($info);
            foreach ($info as $i => $lodger) {
                foreach ((array) $lodger as $key => $val) {
                    if ($gn === true) {
                        if ($key == 'name')
                            $string .= $val . $iNeedle;
                    } else {
                        $string .= LodgerInfo::getKeyName($key) . $kvNeedle . $val . $iNeedle;
                    }
                }
                $string = trim($string, $iNeedle);
                $string .= $count > 1 && $count != $i ? $gNeedle : '';
            }
            $string = trim($string, $gNeedle);
        }
        return $string;
    }

    /**
     * 获取分配比例
     * @return array
     */
    public static function getHotelConfigInfo() {
        $allocation = Tool::getConfig('allocation');
        $hotelparams = Tool::getConfig('hotelparams');
        return array(
            'member' => $allocation['hotelOnConsume'], // 消费者
            'memberRefer' => $allocation['hotelOnRef'], // 推荐者
            'business' => $allocation['hotelOnBusinessTravel'], // 商旅收益
            'travelCompanyId' => $hotelparams['hotelOnBusinessTravelMemberId'], // 商旅ID
            'gaiIncome' => isset($allocation['hotelOnGaiIncome'])?$allocation['hotelOnGaiIncome']:0, //盖网通收益
        );
    }

    /**
     * 支付详细信息
     * @return mixed
     */
    public function paymentDetails() {
        /** @var Member $member 会员实例 */
        $member = $this->member;
        // 会员消费者账户余额
        $accountBalance = AccountBalance::getAccountAllBalance($member->gai_number, AccountInfo::TYPE_CONSUME);
        $lotteryIntegral = Tool::getConfig('hotelparams', 'luckRation'); // 抽奖支付金额
        $lotteryPrice = $this->is_lottery == 'true' || $this->is_lottery == '1' ? Common::reverseSingle($lotteryIntegral, $member->type_id) : 0.00; // 抽奖支付金额
        $totalPayPrice = $this->total_price + $lotteryPrice; // 总支付金额
        // 支付详细数据
        $data = array();
        $data['total_pay_price'] = Common::rateConvert($totalPayPrice); // 需要支付的金额
        $data['total_pay_integral'] = Common::convertSingle($totalPayPrice, $member->type_id); // 需要支付的积分
        $data['surplus_integral'] = Common::convertSingle($accountBalance, $member->type_id); // 会员消费者账户剩余积分
        $data['owe_integral'] = $accountBalance < $totalPayPrice ? Common::convertSingle($totalPayPrice - $accountBalance, $member->type_id) : '0.00'; // 还需付积分
        return $data;
    }

    /**
     * 获取加锁的订单
     * @param $code 网银订单号
     * @return mixed
     * @author jianlin.lin
     */
    public static function getOrderByLock($code) {
        $command = Yii::app()->db->createCommand();
        $command->where = 'parent_code = :pcode And status = :status And pay_status = :pstatus FOR UPDATE';
        $command->params = array(':pcode' => $code, ':status' => self::STATUS_NEW, ':pstatus' => self::PAY_STATUS_NO);
        return $command->from('{{hotel_order}}')->queryRow();
    }
    
    /**
     * 根据 parent_code 查找 订单及订单商品相关信息，
     * 如果 parent_code 找不到，则用 code 来找
     * @param $parentCode
     * @param $code
     * @return array
     * @author wyee
     * @date 20160509
     */
    public static function getOrderByCode($parentCode,$code){
        $order=self::_getByCode($parentCode);
        if (!$order){
            //如果根据parent_code找不到订单，则用code 来找
            $order=self::_getByCode($code,'code');
            if($order){
                Yii::app()->db->createCommand()->update('{{hotel_order}}',array('parent_code'=>$parentCode),'id='.$order['id']);
            }
        }
        return empty($order) ? null : $order;
    }
    
    /**
     * 根据 parent_code 查找 酒店订单信息
     * @param $parentCode
     * @return array
     */
    private static function _getByCode($code,$codeField='parent_code'){
        $command = Yii::app()->db->createCommand();
        $command->where =$codeField.' = :pcode  And pay_status = :pstatus FOR UPDATE';
        $command->params = array(':pcode' => $code, ':pstatus' => self::PAY_STATUS_NO);
        return $command->from('{{hotel_order}}')->queryRow();
    }

    /**
     * 获取酒店评论
     * @param integer $id 酒店ID
     * @param integer $pageSize 分页大小
     * @return CActiveDataProvider
     */
    public static function getComment($id, $pageSize = 10) {
        $criteria = new CDbCriteria;
        $criteria->select = "id, score, comment, comment_time";
        $criteria->condition = 't.status = :status And t.hotel_id = :hid And t.score != :score';
        $criteria->params = array(':status' => HotelOrder::STATUS_SUCCEED, ':hid' => $id, ':score' => 0);
        $criteria->order = 'comment_time DESC';
        $criteria->with = array(
            'member' => array('alias' => 'm', 'select' => 'm.head_portrait, m.gai_number'),
            'room' => array('alias' => 'r', 'select' => 'r.name'),
        );
        return new CActiveDataProvider('HotelOrder', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => $pageSize,
            ),
        ));
    }
    
    /**
     * 获取跟进详情
     * @param type $orderId
     */
    public static function getOrderFollow($orderId){
        $follows = HotelOrderFollow::model()->findAllByAttributes(array(),'order_id=:orderId',array(':orderId'=>$orderId));
        $view = '';
        foreach ($follows as $k=>$v)
        {
            $view .= '时间:'.date("Y-m-d H:i:s", $v['create_time']).', 操作人:'.$v['creater'].', 订单状态:'.HotelOrder::getOrderStatus($v['status']).', 跟进内容:'.$v['content']."\n";
        }
        return $view;
    }

}
