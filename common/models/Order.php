<?php

/**
 *  订单表  模型
 *
 * @author zhenjun_xu <412530435@qq.com>
 * The followings are the available columns in table '{{order}}':
 * @property string $id
 * @property string $code
 * @property string $member_id
 * @property string $consignee
 * @property string $address
 * @property string $mobile
 * @property string $zip_code
 * @property integer $pay_type
 * @property integer $mode
 * @property integer $status
 * @property integer $delivery_status
 * @property string $express
 * @property string $shipping_code
 * @property integer $pay_status
 * @property integer $order_type
 * @property string $freight
 * @property float $pay_price
 * @property string $real_price
 * @property string $return
 * @property integer $freight_payment_type
 * @property string $create_time
 * @property string $store_id
 * @property string $pay_time
 * @property string $delivery_time
 * @property string $sign_time
 * @property integer $refund_status
 * @property string $refund_reason
 * @property integer $return_status
 * @property string $return_reason
 * @property integer $is_read
 * @property integer $is_send_sms
 * @property integer $is_comment
 * @property integer $is_auto_sign
 * @property integer $auto_sign_date
 * @property integer $delay_sign_count
 * @property string $remark
 * @property string $deduct_freight
 * @property string $shipping_address_id
 * @property string $shipping_remark
 * @property string $obligation
 * @property string $refundPrice
 * @property integer $flag
 * @property integer $right_time
 * @property integer $is_right
 */
class Order extends CActiveRecord {

    const RED_RATIO= 0.04; //积分红包支付的时候使用的比率
    public static $referMoney = 0; //推荐者分配金额
    public static $agentMoney = 0; //代理都分配金额
    public static $gaiMoney = 0; //盖网公共账号分配金额
    public static $merReferMoney = 0; //商家推荐者分配金额
    public static $flexMoney = 0; //机动账户分配金额
    public static $gaiInMoney = 0; //盖网第一次收入
    public static $allIncome = 0; //总收益
    //异常查询使用
    public $exception = 0;  //0.下单未支付,1.支付未发货 2.发货未签收
    public $exception_time = 1; //天
    public $goods_name;  //商品名称，查询使用
    public $end_time;   //时间区间，查询使用
    public $order_goods; //订单商品的详细
    public $obligation;     // 责任方(维权使用)
    public $refundPrice;    // 退还金额(维权使用)
    public $rawFreight;     // 原始云分(维权使用)
    public $isExport;   //是否导出excel
    public $exportPageName = 'page'; //导出excel时的分页参数名
    public $exportLimit = 5000; //导出excel长度
    public $beginCreateTime;
    public $toCreateTime;
    public $beginPrice;
    public $toPrice;
    public $verifyCode;
    public $o_member_id, $o_store_id, $sum_gai_price, $sum_total_price, $sum_freight, $total_gai_price, $store_name, $sum_price, $member_name;   //导出用到的字段
    public $months,$orderCount,$account,$amount;
    public $exchange_id,$exchange_type,$exchange_status,$exchange_apply_time,$order_id,$exchange_examine_time,$exchange_reason,$exchange_money;//退换货的类型和状态
    public $exchange_description,$exchange_images,$logistics_company,$logistics_code,$logistics_description;//退换货的类型和状态
    public $backMoney;     //退款金额
    public $exchangeTypeName;
    public $exchangeType;
    public $exchangeStatus;
    public $isNew;
    public $exchange_code;
    //近期时间 ，一个月的时间戳，用于搜索

    const RECENT_TIME = 2592000;
    //是否查看
    const IS_READ_YES = 1;
    const IS_READ_NO = 0;
    const STATUS_NEW = 1;
    const STATUS_COMPLETE = 2;
    const STATUS_CLOSE = 3;
    //是否短信
    const SEND_SMS_OK = 1; //已发送信息
    const SEND_SMS_NO = 0; //未发送信息

    const EX_CHANGE_TIME = 864000;  //10天的时间
    //const EX_CHANGE_TIME = 300;  //5分钟的测试时间

    /**
     * 订单状态
     * 1新订单，2交易完成，3交易关闭
     * @param null $k
     * @return array|null
     */

    public static function status($k = null) {
        $arr = array(
            self::STATUS_NEW => Yii::t('order', '新订单'),
            self::STATUS_COMPLETE => Yii::t('order', '交易完成'),
            self::STATUS_CLOSE => Yii::t('order', '交易关闭'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    const PAY_STATUS_NO = 1;
    const PAY_STATUS_YES = 2;

    /**
     * 支付状态
     * （1未支付，2已支付）
     * @param null $k
     * @return array|null
     */
    public static function payStatus($k = null) {
        $arr = array(
            self::PAY_STATUS_NO => Yii::t('order', '未支付'),
            self::PAY_STATUS_YES => Yii::t('order', '已支付'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    const IS_DISTRIBUTION_NO = 0;
    const IS_DISTRIBUTION_YES = 1;
   
    /**
     * 分配状态
     * （0未分配，1已分配）
     * @param null $k
     * @return array|null
     */
    public static function isDistribution($k = null) {
    	$arr = array(
    			self::IS_DISTRIBUTION_NO => Yii::t('order', '未分配'),
    			self::IS_DISTRIBUTION_YES => Yii::t('order', '已分配'),
    	);
    	return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }
    
    
    //1未发货，2等待发货，3已出货，4签收

    const DELIVERY_STATUS_NOT = 1;
    const DELIVERY_STATUS_WAIT = 2;
    const DELIVERY_STATUS_SEND = 3;
    const DELIVERY_STATUS_RECEIVE = 4;

    /**
     * 配送状态
     * @param null $k
     * @return array|null
     */
    public static function deliveryStatus($k = null) {
        $arr = array(
            self::DELIVERY_STATUS_NOT => Yii::t('order', '未发货'),
            self::DELIVERY_STATUS_WAIT => Yii::t('order', '等待发货'),
            self::DELIVERY_STATUS_SEND => Yii::t('order', '已出货'),
            self::DELIVERY_STATUS_RECEIVE => Yii::t('order', '已签收'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    const REFUND_STATUS_NONE = 0;
    const REFUND_STATUS_PENDING = 1;
    const REFUND_STATUS_FAILURE = 2;
    const REFUND_STATUS_SUCCESS = 3;

    /**
     * 退款状态
     * 0无，1申请中，2失败，3成功
     * @param null $k
     * @return array|null
     */
    public static function refundStatus($k = null) {

        $arr = array(
            //self::REFUND_STATUS_NONE => Yii::t('order', '无'),
            self::REFUND_STATUS_PENDING => Yii::t('order', '申请退款中'),
            self::REFUND_STATUS_FAILURE => Yii::t('order', '退款失败'),
            self::REFUND_STATUS_SUCCESS => Yii::t('order', '退款成功'),
        );


        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    //0无，1协商中，2失败，3同意，4，成功

    const RETURN_STATUS_NONE = 0;
    const RETURN_STATUS_PENDING = 1;
    const RETURN_STATUS_FAILURE = 2;
    const RETURN_STATUS_AGREE = 3;
    const RETURN_STATUS_SUCCESS = 4;
    const RETURN_STATUS_CANCEL = 5;

    /**
     * 退货状态
     * @param null $k
     * @return array|null
     */
    public static function returnStatus($k = null) {
        $arr = array(
            //self::RETURN_STATUS_NONE => Yii::t('order', '无'),
            self::RETURN_STATUS_PENDING => Yii::t('order', '协商退货中'),
            self::RETURN_STATUS_FAILURE => Yii::t('order', '退货失败'),
            self::RETURN_STATUS_AGREE => Yii::t('order', '同意退货'),
            self::RETURN_STATUS_SUCCESS => Yii::t('order', '退货成功'),
            self::RETURN_STATUS_CANCEL => Yii::t('order', '取消退货'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    //1审核通过，2审核不通过，3等待买家退货，4等待卖家退款,5已取消,6已完成
    const EXCHANGE_STATUS_WAITING = 0;
    const EXCHANGE_STATUS_PASS = 1;
    const EXCHANGE_STATUS_NO = 2;
    const EXCHANGE_STATUS_RETURN = 3;
    const EXCHANGE_STATUS_REFUND = 4;
    const EXCHANGE_STATUS_CANCEL = 5;
    const EXCHANGE_STATUS_DONE = 6;
    //退换货类型 1为退货 2为退款
    const EXCHANGE_TYPE_RETURN = 1;
    const EXCHANGE_TYPE_REFUND = 2;


    /**
     * 退换货状态
     * @param null $k
     * @return array|null
     */
    public static function exchangeStatus($k = null) {
        $arr = array(
            self::EXCHANGE_STATUS_WAITING => Yii::t('order', '卖家审核中'),
            //self::EXCHANGE_STATUS_PASS => Yii::t('order', '审核通过'),
            self::EXCHANGE_STATUS_NO => Yii::t('order', '审核不通过'),
            self::EXCHANGE_STATUS_RETURN => Yii::t('order', '等待买家退货'),
            self::EXCHANGE_STATUS_REFUND => Yii::t('order', '等待卖家退款'),
            self::EXCHANGE_STATUS_CANCEL => Yii::t('order', '已取消'),
            self::EXCHANGE_STATUS_DONE => Yii::t('order', '已完成'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    //退换货原因
    const ECXHANGE_REASON_ONE = 1;
    const ECXHANGE_REASON_TWO = 2;
    const ECXHANGE_REASON_THREE = 3;
    const ECXHANGE_REASON_FOUR = 4;
    const ECXHANGE_REASON_FIVE = 5;
    const ECXHANGE_REASON_SIX = 6;
    const ECXHANGE_REASON_SEVEN = 7;
    const ECXHANGE_REASON_EIGHT = 8;
    const ECXHANGE_REASON_NINE = 9;
    const ECXHANGE_REASON_TEN = 10;

    /**
     * 退款/退货原因
     * @param null $k
     * @return array|null
     */
    public static function exchangeReason($k = null) {
        $arr = array(
            //self::ECXHANGE_REASON_ONE => Yii::t('order', '七天无理由退换货'),
            self::ECXHANGE_REASON_TWO => Yii::t('order', '退运费'),
            self::ECXHANGE_REASON_THREE => Yii::t('order', '收到商品破损'),
            self::ECXHANGE_REASON_FOUR => Yii::t('order', '商品错发/漏发'),
            self::ECXHANGE_REASON_FIVE => Yii::t('order', '商品需要维修'),
            self::ECXHANGE_REASON_SIX => Yii::t('order', '发票问题'),
            self::ECXHANGE_REASON_SEVEN => Yii::t('order', '收到商品与描述不符'),
            self::ECXHANGE_REASON_EIGHT => Yii::t('order', '商品质量问题'),
            self::ECXHANGE_REASON_NINE => Yii::t('order', '未按约定时间发货'),
            self::ECXHANGE_REASON_TEN => Yii::t('order', '收到假货'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    const PAY_TYPE_NO = 0; //无支付方式
    const PAY_TYPE_JF = 1;
    const PAY_ONLINE_IPS = 3; //环迅支付
    const PAY_ONLINE_UN = 4; //银联支付
    const PAY_ONLINE_BEST = 5; //翼支付
    const PAY_ONLINE_HI = 6; //汇卡支付
    const PAY_ONLINE_UM = 7; //联动优势
    const PAY_ONLINE_TLZF = 8; //通联支付
    const PAY_ONLINE_TLZFKJ = 12; //通联支付
    const PAY_ONLINE_GHT = 9; //高汇通支付
    const PAY_ONLINE_GHTKJ = 11; //高汇通积分支付
    const PAY_ONLINE_QUICK_GHTKJ=12;//高汇通快捷支付
    const PAY_ONLINE_EBC = 10; //EBC钱包支付
    const PAY_ONLINE_WEIXIN = 13; //微信支付

    /**
     * 支付方式
     * @param null $k
     * @return array|null
     */

    public static function payType($k = null) {
        $arr = array(
            self::PAY_TYPE_JF => Yii::t('order', '积分'),
            self::PAY_ONLINE_IPS => Yii::t('order', '环迅支付'),
            self::PAY_ONLINE_UN => Yii::t('order', '银联支付'),
            self::PAY_ONLINE_BEST => Yii::t('order', '翼支付'),
            self::PAY_ONLINE_HI => Yii::t('order', '汇卡支付'),
            self::PAY_ONLINE_UM => Yii::t('order', '联动优势'),
            self::PAY_ONLINE_TLZF => Yii::t('order', '通联支付'),
            self::PAY_ONLINE_TLZFKJ => Yii::t('order', '通联支付KJ'),
            self::PAY_ONLINE_GHT => Yii::t('order', '高汇通支付'),
            self::PAY_ONLINE_GHTKJ => Yii::t('order', '高汇通KJ支付'),
            self::PAY_ONLINE_QUICK_GHTKJ => Yii::t('order', '高汇通KJ快捷支付'),
            self::PAY_ONLINE_EBC => Yii::t('order', 'EBC钱包支付'),
        	self::PAY_ONLINE_WEIXIN => Yii::t('order', '微信支付'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    const ORDER_TYPE_UNCLEAR = 1;
    const ORDER_TYPE_JF = 2;

    /**
     * 订单类型
     * @param null $k
     * @return array|null
     */
    public static function orderType($k = null) {
        $arr = array(
            self::ORDER_TYPE_UNCLEAR => Yii::t('order', '不清楚'),
            self::ORDER_TYPE_JF => Yii::t('order', '积分兑换'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    /**
     * 订单类型 红包，积分现金
     * @param null $k
     * @return array|null
     */
    public static function orderSourceType($k = null) {
        $arr = array(
                self::SOURCE_TYPE_DEFAULT => Yii::t('order', '普通商品'),
                self::SOURCE_TYPE_SINGLE => Yii::t('order', '积分现金商品'),
                self::SOURCE_TYPE_HB => Yii::t('order', '红包商品'),
                self::SOURCE_TYPE_JFXJ => Yii::t('order', '普通商品的积分现金'),
                self::SOURCE_TYPE_AUCTION => Yii::t('order', '拍卖商品')
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    // 评论状态

    const IS_COMMENT_NO = 0;
    const IS_COMMENT_YES = 1;

    public function tableName() {

        return '{{order}}';
    }

    public static function getCommentStatus() {
        return array(
            self::IS_COMMENT_YES => '已评价',
            self::IS_COMMENT_NO => '未评价'
        );
    }

    // 责任方 1：消费者，2：商家

    const OBLIGATION_CUSTOMER = 1;
    const OBLIGATION_MERCHANT = 2;

    public static function obligation($k = null) {
        $arr = array(
            self::OBLIGATION_CUSTOMER => Yii::t('order', '消费者'),
            self::OBLIGATION_MERCHANT => Yii::t('order', '商家'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    //签收状态
    const IS_AUTO_SIGN_NO = 0; //不是自动签收
    const IS_AUTO_SIGN_YES = 1; //是自动签收

    /*     * *************** */
    const FLAG_ZERO = 0;    // 无
    const FLAG_ONE = 1;     // 45591特殊商品支付时标记
    //source_type   订单类型（1、【普通商品及专题商品】2、【大额商品（积分加现金）】3、【合约机商品】）4、红包 5，（积分+现金）专题商品 6 拍卖商品
    const SOURCE_TYPE_DEFAULT = 1;
    const SOURCE_TYPE_SINGLE  = 2;
    const SOURCE_TYPE_HYJ     = 3;
    const SOURCE_TYPE_HB      = 4;
    const SOURCE_TYPE_JFXJ     =5;
    const SOURCE_TYPE_AUCTION =6;

    /**
     * 订单来源 （1网站、2ANDROID客户端、3IOS客户端，4WAP端）
     */
    const ORDER_SOURCE_WEB = 1;
    const ORDER_SOURCE_ANDROID = 2;
    const ORDER_SOURCE_IOS = 3;
    const ORDER_SOURCE_WAP = 4;

    public static function sourceType($k = null) {
        $arr = array(
            self::ORDER_SOURCE_WEB => Yii::t('order', '网站'),
            self::ORDER_SOURCE_ANDROID => Yii::t('order', 'ANDROID客户端'),
            self::ORDER_SOURCE_IOS => Yii::t('order', 'IOS客户端'),
            self::ORDER_SOURCE_WAP => Yii::t('order', 'WAP端'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    public static function exchangeType($k = null) {
        $arr = array(
            self::EXCHANGE_TYPE_RETURN => Yii::t('order', '退货'),
            self::EXCHANGE_TYPE_REFUND => Yii::t('order', '退款不退货'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    /**
     * 订单删除状态，0.默认，1.回收站，2.彻底删除不显示了
     */
    const LIFE_DEFAULT = 0;
    const LIFE_RECYCLE = 1;
    const LIFE_DELETE = 2;

    public static function checkStatusTime($applyTime,$exchangeStatus){
        $time = $applyTime+self::EX_CHANGE_TIME - time();
        $times = date('Y-m-d H:i:s',$applyTime);
        if($exchangeStatus == self::EXCHANGE_STATUS_WAITING){
            $times .= "<br/><span class='red ddtime' values='".$time."'></span>";
        }
        return $times;
    }

    public static function setOrderGoodsList($OrderGoods){
        $html = '';
        foreach($OrderGoods as $key => $value){
            if($key > 0) $html .= '<br/>';
            $html .= $value['goods_name'];
        }
        return $html;
    }

    //异常订单操作
    const EXCEPTION_TYPE = 1; //跑数遗留问题,金额没有退回去

    public function rules() {
        return array(
            array('code, member_id, consignee, address, mobile', 'required'),
            array('pay_type, mode, status, delivery_status, pay_status, order_type, freight_payment_type, refund_status, return_status, is_read, is_send_sms, is_comment, is_auto_sign, auto_sign_date, delay_sign_count', 'numerical', 'integerOnly' => true),
            array('code', 'length', 'max' => 64),
            array('shipping_code', 'match', 'pattern' => '/^\w{5,50}+$/', 'on' => 'express'),
            array('shipping_code', 'required', 'on' => 'express'),
            array('member_id, create_time, store_id, pay_time, delivery_time, sign_time, shipping_address_id', 'length', 'max' => 11),
            array('consignee, address, express, shipping_code, refund_reason, return_reason, remark, shipping_remark,create_time,end_time', 'length', 'max' => 128),
            array('mobile, zip_code', 'length', 'max' => 16),
            array('extend_remark','length', 'max' => 256),
            array('freight, pay_price, real_price, return, deduct_freight', 'length', 'max' => 10),
            // 维权验证
            array('freight, obligation', 'required', 'on' => 'orderRight'),
            array('freight', 'numerical', 'on' => 'orderRight'),
            array('freight', 'verifyRefundPrice', 'on' => 'orderRight'),
            array('obligation', 'in', 'range' => array(self::OBLIGATION_CUSTOMER, self::OBLIGATION_MERCHANT), 'on' => 'orderRight'),
            array('id, code, member_id, consignee, address, mobile, zip_code, pay_type, mode, status,
                delivery_status, express, shipping_code, pay_status, order_type, freight, pay_price, real_price,
                return, freight_payment_type, create_time, store_id, pay_time, delivery_time,
                sign_time, refund_status, refund_reason, return_status, return_reason, is_read, is_send_sms,
                is_comment, is_auto_sign, auto_sign_date, delay_sign_count, remark, deduct_freight,flag,right_time,is_right,
                shipping_address_id, shipping_remark,exception,exception_time,goods_name,end_time,create_time,o_member_id,o_store_id,sum_gai_price,sum_total_price,sum_freight,toCreateTime,beginCreateTime,beginPrice,toPrice,total_gai_price', 'safe', 'on' => 'search'),
            array('return_reason,refund_reason,shipping_code', 'filter', 'filter' => array($ogj = new CHtmlPurifier(), 'purify')),
            array('exchange_type,exchange_apply_time,exchange_status,life','safe'),
            array('exchange_reason,exchange_description,exchange_money', 'required', 'on'=>'exchangeGoods,exchangeRefund'),
            array('exchange_money,exchange_reason', 'numerical', 'on'=>'exchangeGoods,exchangeRefund'),
            //array('exchange_images', 'required', 'message' => Yii::t('member', '请上传图片凭证'), 'on' => 'exchangeGoods'),
            array('exchange_images,code', 'safe', 'on'=>'exchangeGoods'),
            array('logistics_company,logistics_code', 'required', 'on'=>'exchangeExamine'),
            array('logistics_description,exchange_id', 'safe', 'on'=>'exchangeExamine'),
            //array('verifyCode', 'comext.validators.requiredExt'),
        );
    }

    /**
     * 验证维权退还总金额是否传出支付总金额
     * @param type $attribute
     * @param type $params
     */
    public function verifyRefundPrice($attribute, $params)
    {
        if ($this->$attribute < 0)
            $this->addError($attribute, Yii::t('order', '运费必须大于或等于 0 ！'));
        if (!($this->source_type == self::SOURCE_TYPE_HB && $this->obligation == Order::OBLIGATION_CUSTOMER)) {
            if ($this->pay_price < ($this->refundPrice + $this->freight))
                $this->addError($attribute, Yii::t('order', '退还总金额不得大于支付总金额！'));
        }
        if ($this->obligation == Order::OBLIGATION_CUSTOMER) {
            if ($this->freight - $this->rawFreight > 0) {
                $this->addError($attribute, Yii::t('order', '退还运费不得大于支付的运费！'));
            }
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
            'orderGoods' => array(self::HAS_MANY, 'OrderGoods', 'order_id'),
            'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
            'stockLog' => array(self::HAS_ONE, 'StockLog', 'order_id'),
        );
    }

    public function scopes() {
        return array(
            // 维权
            'rights' => array(
                // 满足条件，配送状态为已发货与退货状态为失败 或者 配送状态为已签收及签收时间在维权时间内
                'condition' => 't.is_right = :isRight AND t.status <> :status AND ((delivery_status = :statusSend AND return_status = :statusFailure) OR (delivery_status = :statusReceive  AND (sign_time+:deadline) > '.time().'  ))',
                'params' => array(
                    ':isRight' => self::RIGHT_NO,
                    ':status' => self::STATUS_CLOSE,
                    ':statusSend' => self::DELIVERY_STATUS_SEND,
                    ':statusFailure' => self::RETURN_STATUS_FAILURE,
                    ':statusReceive' => self::DELIVERY_STATUS_RECEIVE,
//                    ':isComment' => self::IS_COMMENT_NO,  //已经评论订单也可以维权
                    ':deadline' => $this->getRightDeadline(),
                )
            ),
        );
    }

    /**
     * @var  FreightType
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('order', '主键'),
            'code' => Yii::t('order', '订单编号'), //（商城内部使用）
            'member_id' => Yii::t('order', '所属会员'),
            'consignee' => Yii::t('order', '收货人'),
            'address' => Yii::t('order', '收货地址'),
            'mobile' => Yii::t('order', '手机号码'),
            'zip_code' => Yii::t('order', '邮编'),
            'pay_type' => Yii::t('order', '支付方式'), //（1积分，2网银）
            'mode' => Yii::t('order', '运送方式'), // （1快递，2EMS，3平邮） FreightType 表中有定义
            'status' => Yii::t('order', '状态'), //（1新订单，2交易完成，3交易关闭）
            'delivery_status' => Yii::t('order', '配送状态'), //（1未发货，2等待发货，3已出货，4签收）
            'express' => Yii::t('order', '发货物流'),
            'shipping_code' => Yii::t('order', '运单号'),
            'pay_status' => Yii::t('order', '支付状态'), //（1未支付，2已支付）
            'order_type' => Yii::t('order', '订单类型'), //（1暂不清楚，2积分兑换）
            'freight' => Yii::t('order', '运费'),
            'pay_price' => Yii::t('order', '支付金额'),
            'real_price' => Yii::t('order', '实际金额'),
            'return' => Yii::t('order', '返还积分'),
            'freight_payment_type' => Yii::t('order', '运输方式（1包邮，2运输方式，3运费模板）'),
            'create_time' => Yii::t('order', '下单时间'),
            'store_id' => Yii::t('order', '所属商家'),
            'pay_time' => Yii::t('order', '支付时间'),
            'delivery_time' => Yii::t('order', '发货时间'),
            'sign_time' => Yii::t('order', '签收时间'),
            'refund_status' => Yii::t('order', '退款状态'), //（0无，1申请中，2失败，3成功）
            'refund_reason' => Yii::t('order', '退款原因'),
            'return_status' => Yii::t('order', '退货状态'), //（0无，1协商中，2失败，3同意，4，成功）
            'return_reason' => Yii::t('order', '退货原因'),
            'is_read' => Yii::t('order', '是否查看'), //（0否，1是）
            'is_send_sms' => Yii::t('order', '短信发送（0未发，1已发）'),
            'is_comment' => Yii::t('order', '评论状态'), //（0未评论，1已评论）
            'is_auto_sign' => Yii::t('order', '自动签收（0否，1是）'),
            'auto_sign_date' => Yii::t('order', '自动签收天数'),
            'delay_sign_count' => Yii::t('order', '延迟签收次数'),
            'remark' => Yii::t('order', '客户留言'),
            'deduct_freight' => Yii::t('order', '协商扣除运费'),
            'shipping_address_id' => Yii::t('order', '发货地址'),
            'shipping_remark' => Yii::t('order', '发货备注'),
            'obligation' => Yii::t('order', '责任方'),
            'rights_info' => Yii::t('order', '维权信息'),
            'parent_code' => Yii::t('order', '母订单号'),
            'right_time' => Yii::t('order', '维权时间'),
            'is_right' => Yii::t('order', '是否已维权'),
            'extend_remark' => Yii::t('order', '关闭备注'),
            'exchange_money' => Yii::t('order', '退款金额'),
            'exchange_reason' => Yii::t('order', '退款原因'),
            'exchange_description' => Yii::t('order', '退款说明'),
            'exchange_images' => Yii::t('order', '上传凭证'),
            'logistics_company' => Yii::t('order', '物流公司'),
            'logistics_code' => Yii::t('order', '运单号'),
            'exchange_id' => Yii::t('order', '退货单号'),
            'exchange_type' => Yii::t('order', '退换货类型'),
            'exchange_apply_time' => Yii::t('order', '申请退换货时间'),
            'exchange_status' => Yii::t('order', '进度状态'),
            'verifyCode' => Yii::t('home', '验证码'),
            'source' => Yii::t('order', '来源'),
        );
    }

    public function search($isRead = null) {
        $criteria = new CDbCriteria;
        $criteria->compare('code', $this->code, true);
        if (!empty($this->status))
            $criteria->compare('t.status', $this->status);
        if (!empty($this->delivery_status))
            $criteria->compare('delivery_status', $this->delivery_status);
        if (!empty($this->pay_status))
            $criteria->compare('pay_status', $this->pay_status);
        $criteria->compare('order_type', $this->order_type);
        if ($this->refund_status !== '')
            $criteria->compare('refund_status', $this->refund_status);
        $criteria->compare('refund_reason', $this->refund_reason, true);
        if ($this->return_status !== '')
            $criteria->compare('return_status', $this->return_status);
        $criteria->compare('delay_sign_count', $this->delay_sign_count);

        // 下单时间
        $searchDate = Tool::searchDateFormat($this->beginCreateTime, $this->toCreateTime);
        $criteria->compare('t.create_time', ">=" . $searchDate['start']);
        $criteria->compare('t.create_time', "<=" . $searchDate['end']);
        // 价格区间
        if (isset($this->toPrice)) {
            if (isset($this->beginPrice))
                $criteria->compare('real_price', ">=" . $this->beginPrice);
            $criteria->compare('real_price', "<=" . $this->toPrice);
        }
        if ($isRead === self::IS_READ_NO)
            $criteria->compare('is_read', self::IS_READ_NO);


        //连表查询 盖网编号
        $criteria->select = 't.*,y.gai_number as member_id, z.name as store_id';
        $criteria->join = 'left join {{member}} as y on(t.member_id=y.id)';
        $criteria->compare('y.gai_number', $this->member_id);
        //店铺名称
        $criteria->join .= ' left join {{store}} as z on(t.store_id=z.id)';
        $criteria->compare('z.name', $this->store_id, true);

        $pagination = array(
            'pageSize' => 20, //分页
        );

        if (!empty($this->isExport)) {
            $criteria->select = 't.*,y.gai_number as member_id, z.name as store_id,g.total_gai_price';
            $criteria->join .= ' LEFT JOIN ( SELECT SUM(gai_price*quantity) as total_gai_price,
	                order_id FROM {{order_goods}} GROUP BY order_id) as g on g.order_id = t.id';
            $pagination['pageVar'] = $this->exportPageName;
            $pagination['pageSize'] = $this->exportLimit;
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pagination,
            'sort' => array('defaultOrder' => 't.id DESC', //设置默认排序
            ),
        ));
    }


    public function searchExport($is_read = null) {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('consignee', $this->consignee, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('zip_code', $this->zip_code, true);
        $criteria->compare('pay_type', $this->pay_type);
        $criteria->compare('mode', $this->mode);
        if (!empty($this->status))
            $criteria->compare('t.status', $this->status);
        if (!empty($this->delivery_status))
            $criteria->compare('delivery_status', $this->delivery_status);
        $criteria->compare('express', $this->express, true);
        $criteria->compare('shipping_code', $this->shipping_code, true);
        if (!empty($this->pay_status))
            $criteria->compare('pay_status', $this->pay_status);
        $criteria->compare('order_type', $this->order_type);
        $criteria->compare('freight', $this->freight, true);
        $criteria->compare('pay_price', $this->pay_price, true);
        $criteria->compare('real_price', $this->real_price, true);
        $criteria->compare('return', $this->return, true);
        $criteria->compare('freight_payment_type', $this->freight_payment_type);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('pay_time', $this->pay_time, true);
        $criteria->compare('delivery_time', $this->delivery_time, true);
        $criteria->compare('sign_time', $this->sign_time, true);
        if ($this->refund_status !== '')
            $criteria->compare('refund_status', $this->refund_status);
        $criteria->compare('refund_reason', $this->refund_reason, true);
        if ($this->return_status !== '')
            $criteria->compare('return_status', $this->return_status);
        $criteria->compare('return_reason', $this->return_reason, true);

        $criteria->compare('is_send_sms', $this->is_send_sms);
        $criteria->compare('is_comment', $this->is_comment);
        $criteria->compare('is_auto_sign', $this->is_auto_sign);
        $criteria->compare('auto_sign_date', $this->auto_sign_date);
        $criteria->compare('delay_sign_count', $this->delay_sign_count);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('deduct_freight', $this->deduct_freight, true);
        $criteria->compare('shipping_address_id', $this->shipping_address_id, true);
        $criteria->compare('shipping_remark', $this->shipping_remark, true);
        if (isset($_GET['start_create'])) { //下单时间
            $searchDate = Tool::searchDateFormat($_GET['start_create'], $_GET['end_create']);
            $criteria->compare('t.create_time', ">=" . $searchDate['start']);
            $criteria->compare('t.create_time', "<" . $searchDate['end']);
        }
        if (isset($_GET['start_price'])) { //价格区间
            $criteria->compare('real_price', ">=" . $_GET['start_price']);
            $criteria->compare('real_price', "<" . $_GET['end_price']);
        }


        if ($is_read === self::IS_READ_NO) {
            $criteria->compare('is_read', self::IS_READ_NO);
        }



        //连表查询 盖网编号
        $criteria->select = 't.*,y.gai_number as o_member_id, z.name as o_store_id,sum(og.gai_price*og.quantity) as sum_gai_price,sum(og.total_price) as sum_total_price,sum(og.freight) as sum_freight';
//        $criteria->select = 't.*,y.gai_number as member_id, z.name as store_id';
        $criteria->join = 'left join {{member}} as y on(t.member_id=y.id)';
        $criteria->compare('y.gai_number', $this->member_id, true);
        //店铺名称
        $criteria->join .= ' left join {{store}} as z on(t.store_id=z.id)';
        $criteria->compare('z.name', $this->store_id, true);


        //链表查订单  总销售价  总供货价  总运费
        $criteria->join .= ' left join {{order_goods}} as og on(t.id=og.order_id)';
        $criteria->group = 't.id';

        $pagination = array(
            'pageSize' => 20, //分页
        );

        if (!empty($this->isExport)) {
            $pagination['pageVar'] = $this->exportPageName;
            $pagination['pageSize'] = $this->exportLimit;
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pagination,
            'sort' => array('defaultOrder' => 't.id DESC', //设置默认排序
            ),
        ));
    }
    /**
     * 异常订单搜索
     * @return CActiveDataProvider
     */
    public function searchException() {
        $criteria = new CDbCriteria;
        //0.下单未支付,1.支付未发货 2.发货未签收
        switch ($this->exception) {
            case 0:
                $criteria->addCondition('pay_status=' . self::PAY_STATUS_NO);
                break;
            case 1:
                $criteria->addCondition('pay_status=' . self::PAY_STATUS_YES . ' and delivery_status=' . self::DELIVERY_STATUS_NOT);
                break;
            case 2:
                $criteria->addCondition('delivery_status=' . self::DELIVERY_STATUS_SEND);
                break;
        }


        $criteria->compare('t.create_time', "<" . (time() - $this->exception_time * 3600 * 24));

        //连表查询 盖网编号
        $criteria->select = 't.*,y.gai_number as member_id, z.name as store_id';
        $criteria->join = 'left join {{member}} as y on(t.member_id=y.id)';
        $criteria->compare('y.gai_number', $this->member_id, true);
        //店铺名称
        $criteria->join .= ' left join {{store}} as z on(t.store_id=z.id)';
        $criteria->compare('z.name', $this->store_id, true);


        $pagination = array(
            'pageSize' => 20, //分页
        );

        if (!empty($this->isExport)) {
            $pagination['pageVar'] = $this->exportPageName;
            $pagination['pageSize'] = $this->exportLimit;
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pagination,
            'sort' => array('defaultOrder' => 't.id DESC', //设置默认排序
            ),
        ));
    }

    /**
     * 异常退款,退货订单搜索列表
     * @return  CDbCriteria
     */
    public function search2RException() {
        $criteria = new CDbCriteria;

        $criteria->select = 't.*,y.gai_number as member_id, z.name as store_id';
        $criteria->condition = "
            t.refund_status = :refund_status
            AND t.pay_status = :pay_status
            AND t.`status` = :status
            AND (
                t.return_status = 1
                OR t.return_status = 2
                OR t.return_status = 3
            )
            AND oo.order_id IS NULL";
        $criteria->params = array(
            ':refund_status' => self::REFUND_STATUS_SUCCESS,
            ':pay_status' => self::PAY_STATUS_YES,
            ':status' => self::STATUS_CLOSE,
        );

        $criteria->join = ' left join {{member}} as y on(t.member_id=y.id)';
        //店铺名称
        $criteria->join .= ' left join {{store}} as z on(t.store_id=z.id)';

        $criteria->join .= ' left join {{order_operate_log}} as oo on(t.id=oo.order_id)';

        if ($this->code) {
            $criteria->compare('t.code', $this->code);
        } else {
            $criteria->addCondition("t.code=''");
        }
        $pagination = array(
            'pageSize' => 20, //分页
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pagination,
            'sort' => array('defaultOrder' => 't.id DESC', //设置默认排序
            ),
        ));
    }

    /**
     * 前台拍卖订单搜索列表
     * @param $member_id 会员id
     * @return CDbCriteria
     */
    public function searchAuctionOrder($member_id) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.member_id=:member_id');
        $criteria->params = array(':member_id' => $member_id);
        $criteria->compare('t.code', $this->code);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.pay_status', $this->pay_status);
        $criteria->compare('t.refund_status', $this->refund_status);
        $criteria->compare('t.return_status', $this->return_status);
        $criteria->compare('t.is_comment', $this->is_comment);
        $criteria->compare('t.source_type', Order::SOURCE_TYPE_AUCTION);

        if($this->delivery_status == Order::DELIVERY_STATUS_WAIT){//待发货
            $criteria->compare('t.delivery_status', array(Order::DELIVERY_STATUS_WAIT,Order::DELIVERY_STATUS_NOT));
        }else{
            $criteria->compare('t.delivery_status', $this->delivery_status);
        }

//        $criteria->compare('t.flag', Order::FLAG_ZERO); // 过滤掉其它特殊时区的垃圾订单
        //时间区间搜索
        $searchDate = Tool::searchDateFormat($this->create_time, $this->end_time);
        $criteria->compare('t.create_time', ">=" . $searchDate['start']);
        $criteria->compare('t.create_time', "<" . $searchDate['end']);
        //商品搜索
        if (!empty($this->goods_name)) {
            $criteria->join = 'LEFT JOIN {{order_goods}} as o ON o.order_id=t.id';
            $criteria->compare('o.goods_name', $this->goods_name, true);
        }

        //$criteria->join = 'LEFT JOIN {{seckill_auction}} as sa ON t.goods_id=sa.goods_id and t.rules_setting_id=sa.rules_setting_id';


        $criteria->order = 't.id DESC';
        return $criteria;
    }
    /*
     * 前台拍卖订单获取起拍价
     * @param $rulesSettingId 活动id
     * @param $goodsId 商品id
     * @return CDbCriteria
     * */
    public static function getAuctionStartPrice($rulesSettingId=0, $goodsId){
        $sql="select start_price from {{seckill_auction}} where rules_setting_id={$rulesSettingId} and goods_id={$goodsId}";
        $command= Yii::app()->db->createCommand($sql);
        $start_price=$command->queryRow();
        return $start_price['start_price'];
    }


    /**
     * 前台会员中心订单搜索列表
     * @param $member_id 会员id
     * @return CDbCriteria
     */
    public function searchOrder($member_id) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.member_id=:member_id');
        $criteria->params = array(':member_id' => $member_id);
        $criteria->compare('t.code', $this->code);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.pay_status', $this->pay_status);
        $criteria->compare('t.refund_status', $this->refund_status);
        $criteria->compare('t.return_status', $this->return_status);
        $criteria->compare('t.is_comment', $this->is_comment);
        $criteria->addNotInCondition('t.source_type',array( Order::SOURCE_TYPE_AUCTION));

        if($this->delivery_status == Order::DELIVERY_STATUS_WAIT){//待发货
            $criteria->compare('t.delivery_status', array(Order::DELIVERY_STATUS_WAIT,Order::DELIVERY_STATUS_NOT));
        }else{
		    $criteria->compare('t.delivery_status', $this->delivery_status);
	    }

//        $criteria->compare('t.flag', Order::FLAG_ZERO); // 过滤掉其它特殊时区的垃圾订单
        //时间区间搜索
        $searchDate = Tool::searchDateFormat($this->create_time, $this->end_time);
        $criteria->compare('t.create_time', ">=" . $searchDate['start']);
        $criteria->compare('t.create_time', "<" . $searchDate['end']);
        //$criteria->select='t.id,t.code,t.delivery_time,t.return,t.real_price,t.pay_price,t.jf_price,t.original_price,t.freight,t.is_right,t.create_time,t.source_type,t.other_price,t.status,t.express,t.shipping_code,t.pay_status,t.delivery_status,t.flag,t.refund_status,t.return_status,t.is_comment,t.source_type';
        //商品搜索
        if (!empty($this->goods_name)) {
            $criteria->join = 'LEFT JOIN {{order_goods}} as o ON o.order_id=t.id';
            $criteria->compare('o.goods_name', $this->goods_name, true);
        }

        $criteria->order = 't.id DESC';
        return $criteria;
    }

    /**
    * 前台会员中心退换货搜索列表
    * @param $member_id 会员id
    * @param $time 退换货时间 1为最近三个月 2为三个月前
    * @return CDbCriteria
    */
    public function searchExchange($member_id, $time=0) {
        $criteria = new CDbCriteria;
        $criteria->select = 't.*,e.exchange_id,e.exchange_code,e.order_id,e.exchange_type,e.exchange_apply_time,e.exchange_status,e.exchange_examine_time';
		$criteria->addCondition('t.member_id=:member_id');
		//$criteria->addCondition("(t.return_status>0 OR t.refund_status>0)");
		$criteria->addCondition("e.order_id > 0");
        $criteria->params = array(':member_id' => $member_id);
	    $criteria->join = ' LEFT JOIN {{order_exchange}} AS e ON e.order_id=t.id';

	    $recently = strtotime('-90 days');
        if($this->code != '' || $this->goods_name != ''){//商品搜索
	    if (!empty($this->goods_name)) {
			$criteria->join .= ' LEFT JOIN {{order_goods}} AS o ON o.order_id=t.id';
			$criteria->compare('o.goods_name', $this->goods_name, true);
			$criteria->group = 'o.goods_id';
	    }else{
			$criteria->compare('t.code', $this->code);
		}
	}else{//页面的三个下拉列表

	    if($this->exchange_type>0){//退货 退款
		    $criteria->compare('e.exchange_type', $this->exchange_type);
	    }
	    if($time > 0){//选择时间段
		    $criteria->compare('e.exchange_apply_time', $time == 1 ? ">=$recently" : "<$recently");
	    }
	    if(isset($this->exchange_status)){//选择退换货状态
		    $criteria->compare('e.exchange_status', $this->exchange_status);
        }
	}

        $criteria->order = 'e.exchange_id DESC';
        return $criteria;

    }

    /**
     * 商家后台已卖出商品搜索列表
     * @param $storeId 商家id
     * @return CDbCriteria
     */
    public function searchSold($storeId) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.store_id=:store_id');
        $criteria->params = array(':store_id' => $storeId);
        $criteria->compare('t.code', trim($this->code));
        if ($this->status !== null)
            $criteria->compare('t.status', $this->status);
        $criteria->compare('t.pay_status', $this->pay_status);
        $criteria->compare('t.delivery_status', $this->delivery_status);
        $criteria->compare('t.refund_status', $this->refund_status);
        $criteria->compare('t.return_status', $this->return_status);
        //时间区间搜索
        $searchDate = Tool::searchDateFormat($this->create_time, $this->end_time);
        $criteria->compare('t.create_time', ">=" . $searchDate['start']);
        $criteria->compare('t.create_time', "<" . $searchDate['end']);

        $criteria->select ='id,code,member_id,mode,status,delivery_status,pay_status,freight,freight_payment_type,create_time';
        
        //商品搜索
        if (!empty($this->goods_name)) {
            $criteria->join = 'LEFT JOIN {{order_goods}} as o ON o.order_id=t.id';
            $criteria->compare('o.goods_name', trim($this->goods_name), true);
        }

        $criteria->order = 't.id DESC';
        return $criteria;
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 查询订单信息
     * @param string $code 订单编号
     */
    public static function getOrderInfo($code = null) {
        $member_id = Yii::app()->user->id;
        if (!$code) {
            $where = "t.member_id={$member_id}  AND t.pay_status=" . self::PAY_STATUS_NO . " AND t.status=" . self::STATUS_NEW;
        } else {
            $where = "t.member_id={$member_id} AND t.code IN ({$code})";
            //            $where = array('and', 't.member_id=' . $member_id, array('in', 'code', $code));
            //            where(array('and', 'id=1', array('or', 'type=2', 'type=3')))
        }
        $data = Yii::app()->db->createCommand()->select('t.id AS orderId,t.code,t.member_id,t.consignee,t.address,t.mobile,t.store_id,t.zip_code,t.pay_price,t.freight AS allFreight,t1.*')
                ->from('{{order}} t')
                ->leftJoin('{{order_goods}} t1', 't.id=t1.order_id')
                ->where($where)
                ->queryAll();
//                Tool::pr($data);
        $orderInfo = array(); //组合成新的数组
        $orderInfo['amount'] = 0; //合计金额
        foreach ($data as $v) {
            $newData = array();
            $storeInfo = Yii::app()->db->createCommand()->select('name,id')
                    ->from('{{store}}')
                    ->where('id=' . $v['store_id'])
                    ->queryRow();
            $orderInfo[$v['store_id']]['orderId'] = $v['orderId'];
            $orderInfo[$v['store_id']]['store_name'] = $storeInfo['name'];
            $orderInfo[$v['store_id']]['code'] = $v['code'];
            $orderInfo[$v['store_id']]['goods_id'] = $v['goods_id'];
            $orderInfo[$v['store_id']]['spec_id'] = $v['spec_id'];
            $goodsInfo = Goods::getGoodsData($v['goods_id'], array('name', 'thumbnail', 'id', 'price', 'gai_price'));
            $newData[$v['goods_id'] . '-' . $v['spec_id']]['name'] = $goodsInfo['name'];
            $newData[$v['goods_id'] . '-' . $v['spec_id']]['thumbnail'] = $goodsInfo['thumbnail'];
            $newData[$v['goods_id'] . '-' . $v['spec_id']]['id'] = $goodsInfo['id'];
            $newData[$v['goods_id'] . '-' . $v['spec_id']]['quantity'] = $v['quantity'];
            $newData[$v['goods_id'] . '-' . $v['spec_id']]['Return'] = Common::calculate($v['gai_price'], $v['unit_price'], $v['gai_income'] / 100);
            $orderInfo[$v['store_id']]['consignee'] = $v['consignee'];
            $orderInfo[$v['store_id']]['address'] = $v['address'];
            $orderInfo[$v['store_id']]['mobile'] = $v['mobile'];
            $orderInfo[$v['store_id']]['store_id'] = $v['store_id'];
            $orderInfo[$v['store_id']]['allprice'] = $v['pay_price'];
            //            $amount += $v['pay_price'] + $v['allFreight'];

            if (empty($orderInfo[$v['store_id']]['goods']))
                $orderInfo[$v['store_id']]['goods'] = $newData;
            else
                $orderInfo[$v['store_id']]['goods'] += $newData;
//            var_dump($data);exit;
//            $orderInfo['amount'] += $v['unit_price'] * $v['quantity'] + $v['freight'];
            $orderInfo['amount'] += $v['unit_price'] * $v['quantity'];
        }
        $orderInfo['amount'] += $v['allFreight'];

        return $orderInfo;
    }

    /**
     * 支付订单详情
     * @param string $code 订单号
     */
    public static function orderInfo($code) {
        $member_id = Yii::app()->user->id;
        $data = Yii::app()->db->createCommand()->select('t.id AS orderId,t.code,t.member_id,t.consignee,t.address,t.mobile,t.store_id,t.zip_code,t.pay_price,t.freight AS allFreight,t1.*,t2.name as store_name')
                ->from('{{order}} t')
                ->leftJoin('{{order_goods}} t1', 't.id=t1.order_id')
                ->leftJoin('{{store}} t2', 't.store_id=t2.id')
                ->where(array('and', 't.member_id=' . $member_id, array('in', 't.code', $code)))
                ->queryAll();
        $orderInfo = array(); //组合成新的数组
        foreach ($data as $v) {
            $newData = array();
            $orderInfo[$v['store_id']]['orderId'] = $v['orderId'];
            $orderInfo[$v['store_id']]['store_name'] = $v['store_name'];
            $orderInfo[$v['store_id']]['code'] = $v['code'];
            $orderInfo[$v['store_id']]['goods_id'] = $v['goods_id'];
            $orderInfo[$v['store_id']]['spec_id'] = $v['spec_id'];
            $newData[$v['goods_id'] . '-' . $v['spec_id']]['name'] = $v['goods_name'];
            $newData[$v['goods_id'] . '-' . $v['spec_id']]['thumbnail'] = $v['goods_picture'];
            $newData[$v['goods_id'] . '-' . $v['spec_id']]['id'] = $v['goods_id'];
            $newData[$v['goods_id'] . '-' . $v['spec_id']]['quantity'] = $v['quantity'];
            $newData[$v['goods_id'] . '-' . $v['spec_id']]['Return'] = Common::calculate($v['gai_price'], $v['unit_price'], $v['gai_income'] / 100);
            $orderInfo[$v['store_id']]['consignee'] = $v['consignee'];
            $orderInfo[$v['store_id']]['address'] = $v['address'];
            $orderInfo[$v['store_id']]['mobile'] = $v['mobile'];
            $orderInfo[$v['store_id']]['store_id'] = $v['store_id'];
            $orderInfo[$v['store_id']]['allprice'] = $v['pay_price'];

            if (empty($orderInfo[$v['store_id']]['goods'])) {
                $orderInfo[$v['store_id']]['goods'] = $newData;
            } else {
                $orderInfo[$v['store_id']]['goods'] += $newData;
            }
        }

        return $orderInfo;
    }

    /**
     * 支付订单详情   不判断用户
     * @param string $code 订单号
     */
    public static function orderInfoAll($code) {
        $data = Yii::app()->db->createCommand()->select('t.id AS orderId,t.code,t.member_id,t.consignee,t.address,t.mobile,t.store_id,t.zip_code,t.pay_price,t.freight AS allFreight,t1.*,t2.name as store_name')
                ->from('{{order}} t')
                ->leftJoin('{{order_goods}} t1', 't.id=t1.order_id')
                ->leftJoin('{{store}} t2', 't.store_id=t2.id')
                ->where(array('in', 't.code', $code))
                ->queryAll();
        $orderInfo = array(); //组合成新的数组
//        $orderInfo['amount'] = 0; //合计金额
        foreach ($data as $v) {
            $newData = array();
            $orderInfo[$v['store_id']]['orderId'] = $v['orderId'];
            $orderInfo[$v['store_id']]['store_name'] = $v['store_name'];
            $orderInfo[$v['store_id']]['code'] = $v['code'];
            $orderInfo[$v['store_id']]['goods_id'] = $v['goods_id'];
            $orderInfo[$v['store_id']]['spec_id'] = $v['spec_id'];
            $newData[$v['goods_id'] . '-' . $v['spec_id']]['name'] = $v['goods_name'];
            $newData[$v['goods_id'] . '-' . $v['spec_id']]['thumbnail'] = $v['goods_picture'];
            $newData[$v['goods_id'] . '-' . $v['spec_id']]['id'] = $v['goods_id'];
            $newData[$v['goods_id'] . '-' . $v['spec_id']]['quantity'] = $v['quantity'];
            $newData[$v['goods_id'] . '-' . $v['spec_id']]['Return'] = Common::calculate($v['gai_price'], $v['unit_price'], $v['gai_income'] / 100);
            $orderInfo[$v['store_id']]['consignee'] = $v['consignee'];
            $orderInfo[$v['store_id']]['address'] = $v['address'];
            $orderInfo[$v['store_id']]['mobile'] = $v['mobile'];
            $orderInfo[$v['store_id']]['store_id'] = $v['store_id'];
            $orderInfo[$v['store_id']]['allprice'] = $v['pay_price'];
            //            $amount += $v['pay_price'] + $v['allFreight'];

            if (empty($orderInfo[$v['store_id']]['goods']))
                $orderInfo[$v['store_id']]['goods'] = $newData;
            else
                $orderInfo[$v['store_id']]['goods'] += $newData;

//            $orderInfo['amount'] += $v['pay_price'];
        }
//        $orderInfo['amount'] += $v['allFreight'];

        return $orderInfo;
    }

    /**
     * 统计总共支付金额
     * @param type $orderInfo
     * @return type
     */
    public static function amount($orderInfo) {
        $payPrice = 0; //总共支付金额
        foreach ($orderInfo as $v) {
            $payPrice+=$v['allprice'];
        }
        return $payPrice;
    }

    /**
     * 订单详情
     * @param type $orderId
     * @return type
     */
    public static function orderDetail($orderId) {
        $data = Yii::app()->db->createCommand()->select()->from('{{order}}')->where('id=' . $orderId)->queryAll();
        $orderGoods = OrderGoods::getOrderGoodsIn((array) $orderId);
        $newData = array(); //组合订单详情新数组
        foreach ($data as $val) {
            $newData['id'] = $val['id'];
            $newData['code'] = $val['code'];
            $newData['member_id'] = $val['member_id'];
            $newData['consignee'] = $val['consignee'];
            $newData['address'] = $val['address'];
            $newData['mobile'] = $val['mobile'];
            $newData['zip_code'] = $val['zip_code'];
            $newData['pay_type'] = self::payType($val['pay_type']);
            $newData['mode'] = $val['mode'];
            $newData['status'] = self::status($val['status']);
            $newData['delivery_status'] = self::deliveryStatus($val['delivery_status']);
            $newData['delivery_status_num'] = $val['delivery_status'];
            $newData['pay_status'] = self::payStatus($val['pay_status']);
            $newData['freight'] = $val['freight'];
            $newData['pay_price'] = $val['pay_price'];
            $newData['return'] = $val['return'];
            $newData['create_time'] = $val['create_time'];
            $newData['freight_payment_type'] = $val['freight_payment_type'];
            $newData['pay_time'] = $val['pay_time'];
            $newData['express'] = $val['express'];
            $newData['shipping_code'] = $val['shipping_code'];
            $newData['pay_time'] = $val['pay_time'];
            $newData['goods'] = $orderGoods;
        }
        //        $data['goods']=$orderGoods;
        return $newData;
    }

    /**
     * 发货后更新订单的物流,和快递单号
     * @param type $orderId 订单id
     * @param type $express 快递公司
     * @param type $shipping_code 快递单号
     * @return type
     */
    public static function updataShipping($orderId, $express, $shipping_code) {
        $f = Yii::app()->db->createCommand()->update('{{order}}', array(
            'express' => $express,
            'shipping_code' => $shipping_code,
            'delivery_time' => time(),
            'delivery_status' => self::DELIVERY_STATUS_SEND,
                ), 'id=:orderId', array(':orderId' => $orderId));
        return $f;
    }

    /**
     * 查询已卖出商品数据
     * @param inti $storeId 商家id
     * @return array 组合新的数组
     */
    public static function soldList($storeId) {

    }

    /**
     * 计算此订单要分发的差价.
     * @param type $orderId
     */
    public static function getBalance($orderId) {
        $model = self::model()->with('orderGoods')->findAll('t.id=' . $orderId);
        return $model;
    }

    /**
     * 最近售出商品
     * @param int $limit    条目限制    默认5条
     */
    public static function recentlySell($where = array(), $limit = 5) {
        $field = 'g.id, g.name, g.thumbnail, g.price, g.return_score,g.gai_sell_price,g.join_activity,g.activity_tag_id,at.status AS at_status';
        $order = Yii::app()->db->createCommand()->select($field)->from('{{order}} as o')
                ->join('{{order_goods}} as og', 'o.id = og.order_id And o.status = :oStatus', array(':oStatus' => Order::STATUS_COMPLETE))
                ->join('{{goods}} as g', 'og.goods_id = g.id And g.status = :gStatus And g.is_publish = :gPush', array(':gStatus' => Goods::STATUS_PASS, ':gPush' => Goods::PUBLISH_YES))
                ->join('{{activity_tag}} at','g.activity_tag_id=at.id')
                ->where($where)
                ->limit($limit)
                ->order('o.sign_time DESC')
                ->queryAll();
        return $order;
    }
    public static function adminOrderCount($goods_id,$rules_setting_id,$member_id){
        $sql = "SELECT  count(*) as c FROM {{seckill_auction_record}} where goods_id ={$goods_id} and rules_setting_id={$rules_setting_id} and member_id={$member_id}";
        $count = Yii::app()->db->createCommand($sql)->queryRow();
        return $count['c'];

    }
    /**
     * 计算总共要支付的金额
     * @param type $code
     */
    public static function countPay($code) {
        if (is_array($code)) {
            $code = $code;
        } else {
            $strpos = strripos($code, '|');
            if ($strpos === false) {
                $code = $code;
            } else {
                $code = substr($code, 0, $strpos);
                $code = explode('|', $code);
                $code = implode(',', $code);
            }
            $code = explode(',', $code);
        }

        $data = Yii::app()->db->createCommand()->select('pay_price,freight')
                ->from('{{order}}')
                ->where(array('in', 'code', $code))
                ->queryAll();
        $allMoney = 0;
        foreach ((array) $data as $v) {
            $allMoney+=($v['pay_price']);
        }
        return $allMoney;
    }

    /**
     * 待收货的订单数
     * @return int
     */
    public static function onWaitReceipt() {
        return Order::model()->count(array(
                    'condition' => 'member_id = :memberId and status = :status and delivery_status = :delivery_status',
                    'params' => array(
                        ':memberId' => Yii::app()->user->id,
                        ':status' => self::STATUS_NEW,
                        ':delivery_status' => self::DELIVERY_STATUS_SEND
                    )
        ));
    }

    /**
     * 待评价的订单数量
     * @return int
     */
    public static function onWaitComment() {
        return Order::model()->count(array(
                    'condition' => 'member_id = :memberId and status =:status and is_comment = :is_comment',
                    'params' => array(
                        ':memberId' => Yii::app()->user->id,
                        ':status' => self::STATUS_COMPLETE,
                        ':is_comment' => self::IS_COMMENT_NO
                    )
        ));
    }

    /**
     * 统计当前订单.支付成功后消费者要返回的金额
     * @param array $order 订单信息
     * @param array $orderGoods 订单商品信息
     * @param array $member 会员信息
     */
    public static function amountReturnByMember($order,$member=array(),$orderGoods = array()) {
        $memberType = MemberType::fileCache();
        if(empty($orderGoods)){
            //订单商品信息
            $fields = 'og.quantity,og.gai_price,og.unit_price,og.gai_income,og.order_id,og.goods_id,og.ratio,og.original_price';
            $orderGoods = Yii::app()->db->createCommand()
                ->select($fields)
                ->from('{{order_goods}} og')
                ->where('order_id=:orderId', array(':orderId' => $order['id']))
                ->queryAll();
        }
        //分配比率
        $ratio = CJSON::decode($order['distribution_ratio']);
        if (!isset($ratio)) {
            $ratio = self::getOldIssueRatio();
        }
        $inCome = OnlineCalculate::orderIncome($order, $orderGoods);
        if(empty($member)){
            $member = Yii::app()->db->createCommand()
                ->select('id,gai_number,type_id,mobile,username')
                ->from('{{member}}')
                ->where('id=:id', array(':id' => $order['member_id']))
                ->queryRow();
        }
        $return = OnlineCalculate::memberAssign($inCome['surplusAssign'], $member, $ratio['ratio'], $memberType);
        return $return['memberIncome'];
    }

    /**
     * 统计昨天的订单数据，每天运行一次 author rdj
     */
    public static function staticOrders() {
        $startDay = strtotime(date('Y-m-d 00:00:00')) - 86400; //昨天的开始时间
        $endDay = $startDay + 86399; //昨天的结束时间
        //新订单总供货价 ,总价sql
        $sql = "select count(1) as num,sum(g.total_price) as total_price,sum(g.gai_price) as gai_price,FROM_UNIXTIME(t.create_time,'%Y-%m-%d') as date" .
                " from {{order}} t left join {{order_goods}} g on t.id=g.order_id where" .
                " t.create_time between $startDay and $endDay and t.status=" . Order::STATUS_NEW . " group by date";
        $newDatas = Yii::app()->db->createCommand($sql)->queryRow();

        $newNum = $newDatas['num']; //新订单个数
        $newPrice = $newDatas['total_price']; //新订单总价
        $newGaiPrice = $newDatas['gai_price']; //新订单总供货价
        //支付订单总价，总供货价sql
        $sql2 = "select count(1) as num,sum(g.total_price) as total_price,sum(g.gai_price) as gai_price,FROM_UNIXTIME(t.pay_time,'%Y-%m-%d') as date" .
                " from {{order}} t left join {{order_goods}} g on t.id=g.order_id where" .
                " t.pay_time between $startDay and $endDay and t.pay_status=" . Order::PAY_STATUS_YES . " group by date";
        $payDatas = Yii::app()->db->createCommand($sql2)->queryRow();

        $payNum = $payDatas['num']; //支付订单个数
        $payPrice = $payDatas['total_price']; //支付订单总价
        $payGaiPrice = $payDatas['gai_price']; //支付订单总供货价

        $sql3 = "select count(1) as num,sum(g.total_price) as total_price,sum(g.gai_price) as gai_price,FROM_UNIXTIME(t.sign_time,'%Y-%m-%d') as date" .
                " from {{order}} t left join {{order_goods}} g on t.id=g.order_id where" .
                " t.sign_time between $startDay and $endDay and t.delivery_status=" . Order::DELIVERY_STATUS_RECEIVE . " group by date";
        $signDatas = Yii::app()->db->createCommand($sql3)->queryRow();

        $signNum = $signDatas['num']; //签收订单个数
        $signPrice = $signDatas['total_price']; //签收订单总价
        $signGaiPrice = $signDatas['gai_price']; //签收订单总供货价

        $insertTime = time(); //创建日期
        $staticTime = strtotime('-1 day'); //统计日期 统计的是昨天的数据，所以写统计日期是昨天，创建日期是今天
        $insertSql = "insert into {{gai_order_day}} (`id`,`create_order_count`,`pay_order_count`,`sign_order_count`,`create_order_gai_price`,`create_order_price`,`pay_order_gai_price`,`pay_order_price`,`sign_order_gai_price`,`sign_order_price`,`statistics_date`,`create_time`)" .
                " values ('','$newNum','$payNum','$signNum','$newGaiPrice','$newPrice','$payGaiPrice','$payPrice','$signGaiPrice','$signPrice',$startDay,$insertTime)";
        if (Yii::app()->st->createCommand($insertSql)->execute()) {
            echo date('Y-m-d', $startDay) . '数据插入成功';
        }
    }

    /**
     * 订单维权搜索
     * @return \CActiveDataProvider
     */
    public function searchRights() {
        $criteria = new CDbCriteria;
        $criteria->with = array('member', 'store');
        $criteria->compare('t.status', '<>' . self::STATUS_CLOSE);
        $this->code = !empty($this->code) ? $this->code : 'null';
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.is_right', self::RIGHT_NO);
        return new CActiveDataProvider($this->rights(), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15, //分页
            ),
            // 设置默认排序
            'sort' => array('defaultOrder' => 't.id DESC'),
        ));
    }

    /**
     * 获取维权期限时长
     * @return numerical
     */
    public function getRightDeadline() {
        $ActivistTime = Tool::getConfig('site', 'ordersActivistTime');
        $deadline = is_numeric($ActivistTime) ? $ActivistTime * (60 * 60 * 24) : 0;
        return $deadline;
    }

    /**
     * 获取订单价格
     * @return array 销售价总价|供货价总价
     */
    public function getOrderPrice() {
        $price = array();
        $price['sellTotalPrice'] = $this->pay_price - $this->freight;
        $sql = "SELECT SUM(og.gai_price * quantity) FROM {{order}} as o LEFT JOIN {{order_goods}} as og ON o.id = og.order_id WHERE o.id = {$this->id}";
        $price['gaiTotalPrice'] = Yii::app()->db->createCommand($sql)->queryScalar();
        return $price;
    }

    /**
     * 获取线上旧分配比率
     * @return array
     */
    public static function getOldIssueRatio() {
        return array(
            'ratio' => array(
                'move' => Tool::getConfig('allocation', 'onFlexible'), //机动
                'member' => Tool::getConfig('allocation', 'onConsume'), //消费者
                'mallCommon' => Tool::getConfig('allocation', 'onAgent'), //商城公共
                'agent' => Tool::getConfig('allocation', 'onAgent'), //代理
                'memberRefer' => Tool::getConfig('allocation', 'onRef'), //推荐者
                'businessRefer' => Tool::getConfig('allocation', 'onWeightAverage'), //默认三级推荐商家会员
                'businessRefer2' => Tool::getConfig('allocation', 'onWeightAverage2'), //二级推荐商家会员
                'businessRefer1' => Tool::getConfig('allocation', 'onWeightAverage1'), //一级推荐商家会员
                'middle_agent' => Tool::getConfig('allocation', 'middle_agent'), //跨一级居间商推荐
                'middle_agent2' => Tool::getConfig('allocation', 'middle_agent2'), //跨二级居间商推荐
                'gai' => Tool::getConfig('allocation', 'onGai'), //盖网
            ),
            'agentRatio' => array(
                'province' => Tool::getConfig('agentdist', 'province'), //省代理
                'city' => Tool::getConfig('agentdist', 'city'), //市代理
                'district' => Tool::getConfig('agentdist', 'district'), //区/县代理
            ),
        );
    }

    const RIGHT_NO = 0; //维权订单
    const RIGHT_YES = 1; //非维权订单

    /**
     * 退款状态
     * 0无，1申请中，2失败，3成功
     * @param null $k
     * @return array|null
     */

    public static function rightStatus($k = null) {
        $arr = array(
            self::RIGHT_NO => Yii::t('order', '无'),
            self::RIGHT_YES => Yii::t('order', '已维权'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : null) : $arr;
    }

    /**
     * 根据 parent_code 查找 订单及订单商品相关信息，
     * 如果 parent_code 找不到，则用 $code 来找
     * 用于网银对账
     * @param $parentCode
     * @param $code
     * @param bool $limitStatus 是否限制订单状态
     * @return array
     */
    public static function getOrdersByParentCode($parentCode,$code,$limitStatus=true){
        $orders = self::_getByParentCode($parentCode);
        if (!$orders){
            //如果根据parent_code找不到订单，则用$code 来找
            $order = Yii::app()->db->createCommand()
                ->select('parent_code')
                ->from('{{order}}')
                ->where('code=:code',array(':code'=>$code))
                ->queryRow();
            if($order){Order::
                $orders = self::_getByParentCode($order['parent_code']);
                //更新订单支付流水号
                foreach($orders as $v){
                    Yii::app()->db->createCommand()->update('{{order}}',array('parent_code'=>$parentCode),'id='.$v['id']);
                }
            }
        }
        if(!$orders) return null;
        foreach ($orders as $k=> &$order) {
            if($limitStatus && ($order['pay_status']!=Order::PAY_STATUS_NO || $order['status']==Order::STATUS_COMPLETE) ){
                unset($orders[$k]);
                continue;
            }
            $order['orderGoods'] = Yii::app()->db->createCommand()
                ->select('quantity,gai_price,unit_price,gai_income,order_id,goods_id,spec_id,rules_setting_id')
                ->from('{{order_goods}}')
                ->where('order_id=:id', array(':id' => $order['id']))
                ->queryAll();
        }
        return empty($order) ? null : $orders;
    }

    /**
     * 根据 parent_code 查找 订单信息
     * @param $parentCode
     * @return array
     */
    private static function _getByParentCode($parentCode){
        return  Yii::app()->db->createCommand()
            ->from('{{order}}')
            ->where('parent_code=:pCode', array(':pCode' => $parentCode))
            ->queryAll();
    }

    /**
     * 取消订单，库存回滚操作
     * @throws CDbException
     * @return int | bool
     */
    public function rollBackStock()
    {
        $sql = '';
        //查找是否已自动补回库存
        if (!empty($this->stockLog)) return true;
        foreach ($this->orderGoods as $v) {
            $sql .= "UPDATE gw_goods SET stock=stock+{$v['quantity']} WHERE  id={$v['goods_id']};";
            $sql .= "UPDATE gw_goods_spec SET stock=stock+{$v['quantity']} WHERE  id={$v['spec_id']};";
        }
        return  !empty($sql) ? Yii::app()->db->createCommand($sql)->execute() : false;
    }

    /**
     * 更新订单的缓存
     * @author LC
     */
    public function afterSave() {
    	parent::afterSave();
    	foreach ($this->orderGoods as $orderGoods)
    	{
    		ActivityTag::deleteCreateRedOrder($this->member_id, $orderGoods->goods_id, $orderGoods->spec_id);
            // 清除新活动缓存
            if($this->status == self::STATUS_CLOSE){
                ActivityData::deleteOrderCache($this->member_id, $orderGoods->goods_id);//删除秒杀流程缓存
                ActivityData::delGoodsCache($orderGoods->goods_id);//删除商品缓存
                ActivityData::deleteActivityGoodsStock($orderGoods->goods_id);//删除库存缓存
            }
    	}
    }

    /**
     * 查找某一商家在一个月内的销售额信息（用于居间商模块）
     * @param int $storeId 商家ID
     */
    public static function getDayOrderInfo($storeId,$dateStart,$dateEnd){
        $sql = "select count(id) as num,sum(t.real_price) as total_price,FROM_UNIXTIME(t.pay_time,'%Y-%m-%d') as date" .
                " from {{order}} t where" .
                " t.pay_time >= $dateStart and t.pay_time <= $dateEnd and t.status=" . Order::STATUS_COMPLETE . " and t.store_id=$storeId group by date";
        $dayData = Yii::app()->db->createCommand($sql)->queryAll();
          return $dayData;
    }

	 /**
     * 根据商品ID查找商家 用于我的订单
     * @param int $goodsId 商品ID
     */
    public static function getStoreInfo($goodsId){

		$goodsId = intval($goodsId);
        $name    = Yii::app()->db->createCommand()
                   ->select('s.name,s.id')
                   ->from('{{goods}} g')
				   ->join('{{store}} s', 'g.store_id=s.id')
                   ->where('g.id=:id', array(':id' => $goodsId))
                   ->queryRow();
          return $name;
    }

    /**
     * 根据订单号和用户ID获取对应的订单产品信息
     * @param $code
     * @param $user_id
     * @return bool|mixed
     * @author jiawei liao 569114018@qq.com
     */

    //,
    static public function getBackOrderInfo($code,$user_id){
        $result = $orderList = $newOrderList = $memberInfo = array();
        $result = array('total_freight'=>'','free_price'=>'');
        $memberInfo = Yii::app()->db->createCommand()
            ->select("o.code,o.store_id,o.create_time,o.pay_time,o.delivery_time,o.sign_time,o.real_price,o.pay_price,o.freight,o.member_id,o.consignee,o.address,o.mobile,o.remark,o.zip_code,o.express,o.shipping_code,o.freight,o.freight_payment_type,o.mode,s.name as store_name,s.mobile as store_mobile,r.name as store_city_name")
            ->from("{{order}} as o")
            ->join("{{store}} as s",'o.store_id=s.id')
            ->join("{{region}} as r",'s.city_id=r.id')
            ->where('o.code=:code and o.member_id=:member_id',array(':code'=>$code,':member_id'=>$user_id))
            ->queryRow();

        if(empty($memberInfo))  {       //预防恶意修改其他用户订单
            return false;
            die;
        }

        $orderList = Yii::app()->db->createCommand()
                    ->select("o.id,o.source_type,og.goods_id,og.goods_name,og.goods_picture,og.quantity,og.spec_value,og.unit_price,og.activity_ratio,og.freight,og.original_price,og.rules_setting_id")
                    ->from("{{order}} as o")
                    ->join("{{order_goods}} as og",'o.id=og.order_id')
                    ->where('o.code=:code',array(':code'=>$code))
                    ->queryAll();

        $result['orderList'] = $orderList;
        $result['memberInfo'] = $memberInfo;
        return $result;
    }

    /**
     * 根据商家获取退货相关信息，商家平台退货管理用，web2.0新版
     * @author jiawei.liao 569114018@qq.com
     * @param int $storeId 商家ID
     * @param int $exchangeType    '类型（1退货，2退款不退货）',
     * @param int $orderCode       订单code
     * @param int $timeType        查询时间的类型：0为不限制；1为指点时间后的；2为查指定时间前的；
     * @param int $exchangeStatus    新退换货表的状态，默认值是-1，为了获取全部状态
     */
    function getBackGoods($exchangeType=0,$orderCode=0,$timeType=0,$exchangeStatus=-1){
        $applyTime =  time()+86400*90;
        $criteria = new CDbCriteria;

        $criteria->select = "t.code,t.member_id,t.id,t.refund_status,t.refund_reason,t.return_status,t.return_reason,ex.exchange_type,ex.exchange_apply_time,ex.exchange_examine_time,ex.exchange_status,ex.exchange_id,ex.exchange_code,ex.exchange_reason ";

        $criteria->join = "right join {{order_exchange}} as ex on t.id=ex.order_id";
        $criteria->compare("t.store_id"," = " .$_SESSION['gatewang_storeId'] );
        if($orderCode > 0) $criteria->compare("t.code", $orderCode);

        if($exchangeStatus > -1){
            $criteria->addCondition("ex.exchange_status=".$exchangeStatus);
        }
        if($exchangeType > 0){
            $criteria->addCondition("ex.exchange_type=".$exchangeType);
        }

        if($timeType == 1){
            $criteria->addCondition("ex.exchange_apply_time > ".$applyTime);
        }elseif($timeType == 2){
            $criteria->addCondition("ex.exchange_apply_time < ".$applyTime);
        }


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20, //分页
            ),
            'sort' => array('defaultOrder' => 't.id DESC', //设置默认排序
        ),
        ));
    }

    /**
     * 获取退换货单详情，供商城2.0改版，商家后台用
     * @param $orderId      gw_order 里的主键ID
     * @param $storeId      商家ID
	 * @param $exchangeId   退换货表ID
     * @return array
     * @author jiawei.liao 569114018@qq.com
     */
    static function getBackOrderInfoForSeller($orderId, $storeId, $exchangeId){
        $result = array();
        $orderInfo = Yii::app()->db->createCommand()
		             ->select("o.refund_status,o.return_status,o.id,o.consignee,o.address,o.mobile,o.real_price,o.code,o.refund_reason,o.return_reason,o.pay_price,oe.*")
                     ->from("{{order}} as o")->leftJoin("{{order_exchange}} as oe","oe.order_id=o.id")
					 ->where('o.id=:oid and o.store_id=:store_id and oe.exchange_id=:eid',array(':oid'=>$orderId,':store_id'=>$storeId, ':eid'=>$exchangeId))
					 ->queryAll();

        $result['orderInfo'] = $orderInfo[count($orderInfo)-1];
        if($result['orderInfo']['exchange_images'] != ''){
            if(strpos($result['orderInfo']['exchange_images'],'|')){
                $result['orderInfo']['exchange_images'] = explode('|',$result['orderInfo']['exchange_images']);
            }else{
                $result['orderInfo']['exchange_images'] = array('0'=>$result['orderInfo']['exchange_images']);
            }
        }

        $result['goodsList'] = Yii::app()->db->createCommand()->select("g.id,g.name,o.unit_price,o.goods_picture,o.quantity,o.spec_value")->from("{{order_goods}} as o")->leftJoin("{{goods}} as g","g.id=o.goods_id")->where("o.order_id=:order_id",array(":order_id"=>$orderId))->queryAll();

        return $result;
    }

    /**
     * 卖家平台，退货管理提交后的处理
     * @param $orderId     订单ID
     * @param $exchangeType 业务类型 1为退货，2为退款不退货
     * @param $passStatus       提交操作的类型，1为通过，2为不通过
     * @param $returnStatus     提交操作的退换货单当前状态
     * @param string $backReason    商家拒绝原因
     * @param int $storeId      商家ID
     * @return array
     * @throws CDbException
     */
    static public function methodRequestForSeller($orderId,$exchangeType,$passStatus,$returnStatus,$backReason='',$storeId){
        //获取order_exchange表最后一条有效数据
        $exchange = Yii::app()->db->createCommand()->select("exchange_id")->from("{{order_exchange}}")->where("order_id=:order_id",array(':order_id'=>$orderId))->queryAll();
        $where = array(':id'=>$exchange[count($exchange)-1]['exchange_id']);

        if($passStatus == 1 ){   //  判断是否通过,1为通过，2为不通过
            $orderResult = Yii::app()->db->createCommand()->from("{{order}}")->where("id=:id",array('id'=>$orderId))->queryRow();
            $storeResult = Yii::app()->db->createCommand()->select('s.member_id,m.gai_number')->from('{{store}} as s')
                ->leftJoin("{{member}} as m",'s.member_id=m.id')->where('s.id=:id', array(':id' => $storeId))->queryRow();
            if($exchangeType == 1){  //判断为退货业务类型
                $newData = array('exchange_status'=>self::EXCHANGE_STATUS_RETURN,'exchange_examine_time'=>time());
                    //商家已经收到货,已经是同意退货
                    if($returnStatus == self::EXCHANGE_STATUS_REFUND){
                        $newData['exchange_status'] = self::EXCHANGE_STATUS_DONE;
                        $Exchange = ExchangeReturn::operate($orderResult,null,$storeResult);
                        if($Exchange['flag'] == true){
                            Yii::app()->db->createCommand()->update("{{order_exchange}}",$newData,"exchange_id=:id",$where);
                            Order::closeOder($orderResult['id']);//关闭订单
                            return $status = array('type'=>self::EXCHANGE_TYPE_RETURN,'status'=>self::EXCHANGE_STATUS_DONE,'exchange_id'=>$exchange[count($exchange)-1]['exchange_id']);
                        }else{
                            return array('type'=>self::EXCHANGE_TYPE_RETURN,'status'=>-1,'exchange_id'=>$exchange[count($exchange)-1]['exchange_id']);
                        }

                    }elseif($returnStatus == self::EXCHANGE_STATUS_WAITING){//商家同意退货，等待买家发货
                        $Transaction = Yii::app()->db->beginTransaction();
                        try{
                            Yii::app()->db->createCommand()->update("{{order_exchange}}",$newData,"exchange_id=:id",$where);
                            Yii::app()->db->createCommand()->update("{{order}}",array('return_status'=>self::EXCHANGE_STATUS_RETURN),"id=:id",array(':id'=>$orderId));
                                $Transaction->commit();
                                return $status = array('type'=>self::EXCHANGE_TYPE_RETURN,'status'=>self::EXCHANGE_STATUS_RETURN,'exchange_id'=>$exchange[count($exchange)-1]['exchange_id']);

                        }catch (Exception $e){
                            $Transaction->rollback();
                            return array('type'=>self::EXCHANGE_TYPE_RETURN,'status'=>-1,'exchange_id'=>$exchange[count($exchange)-1]['exchange_id']);
                        }
                    }
            }else{//判断为退款不退货业务类型
                $refund = ExchangeRefund::operate($orderResult,null,$storeResult);

                if($refund['flag'] == true){
                    $newData = array('exchange_status'=>6,'exchange_examine_time'=>time(),'exchange_done_time'=>time());
                    Yii::app()->db->createCommand()->update("{{order_exchange}}",$newData,"exchange_id=:id",$where);
                    Yii::app()->db->createCommand()->update("{{order}}",array('refund_status'=>Order::RETURN_STATUS_AGREE,'refund_time'=>time()),"id=:id",array(':id'=>$orderId));
                    Order::closeOder($orderResult['id']);//关闭订单
                    return array('type'=>self::EXCHANGE_TYPE_REFUND,'status'=>self::EXCHANGE_STATUS_DONE,'exchange_id'=>$exchange[count($exchange)-1]['exchange_id']);
                    die;
                }else{
                    return array('type'=>self::EXCHANGE_TYPE_REFUND,'status'=>-1,'exchange_id'=>$exchange[count($exchange)-1]['exchange_id']);
                }
            }

        }else{  //   审核不通过
            $newData = array('exchange_status'=>self::EXCHANGE_STATUS_NO,'exchange_examine_time'=>time(),'exchange_examine_reason'=>$backReason);
            if($exchangeType == 1){  //判断为退货业务类型
                $oldData = array('return_status'=>self::EXCHANGE_STATUS_NO,'return_reason'=>$backReason);
            }else{
                $oldData = array('refund_status'=>self::EXCHANGE_STATUS_NO,'refund_reason'=>$backReason);
            }
            $Transaction = Yii::app()->db->beginTransaction();
            try{
                Yii::app()->db->createCommand()->update("{{order}}",$oldData,"id=:id",array('id'=>$orderId));
                Yii::app()->db->createCommand()->update("{{order_exchange}}",$newData,"exchange_id=:id",$where);
                $Transaction->commit();
                return array('type'=>$exchangeType,'status'=>self::EXCHANGE_STATUS_NO,'exchange_id'=>$exchange[count($exchange)-1]['exchange_id']);
            }catch (Exception $e){
                $Transaction->rollback();
                return array('type'=>$exchangeType,'status'=>-1,'exchange_id'=>$exchange[count($exchange)-1]['exchange_id']);
            }
        }
    }

    /**
     * 关闭订单时添加关闭订单日期戳
     * @param $orderId
     * @return int
     */
    static public function closeOder($orderId){
        $data = array('close_time'=>time());
        return Yii::app()->db->createCommand()->update("{{order}}",$data,"id=:id",array(':id'=>$orderId));
    }

    /**EBC第三方网银直调专用
     * @param $parentCode
     * @return mixed
     */
    static public function getDataByParentCode($parentCode){
        return Yii::app()->db->createCommand()->select("store_id,source,code")->from("{{order}}")
            ->where('parent_code=:parent_code',array(':parent_code'=>$parentCode))->limit('1')->queryRow();
    }
}
