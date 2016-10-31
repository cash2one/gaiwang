<?php

/**
 * 流水表模型类
 * @author wanyun.liu <wanyun_liu@163.com>
 *
 * @property string $id
 * @property string $account_id
 * @property string $gai_number
 * @property string $card_no
 * @property string $date
 * @property string $create_time
 * @property integer $type
 * @property string $debit_amount
 * @property string $credit_amount
 * @property integer $operate_type
 * @property string $trade_spec
 * @property integer $trade_terminal_id
 * @property string $ratio
 * @property string $order_id
 * @property string $order_code
 * @property string $area_id
 * @property string $remark
 * @property string $province_id
 * @property string $city_id
 * @property string $district_id
 * @property integer $week
 * @property integer $week_day
 * @property string $ip
 * @property integer $hour
 * @property integer $moved
 * @property string $node
 * @property string $franchisee_id
 * @property integer $recharge_type
 * @property string $distribution_ratio
 * @property integer $transaction_type
 * @property string $parent_id
 * @property string $prepaid_card_no
 * @property string $current_balance
 * @property integer $flag
 * @property string $endTime
 */
class AccountFlow extends CActiveRecord {

    private static $_baseTableName = '{{account_flow}}';

    const TYPE_MERCHANT = 1; // 商家
    const TYPE_AGENT = 2; // 代理
    const TYPE_CONSUME = 3; // 消费
    const TYPE_RETURN = 4; // 待返还
    const TYPE_FREEZE = 5; //  冻结
    const TYPE_COMMON = 6; // 公共
    const TYPE_CASH = 8; //普通会员提现账户
    const TYPE_TOTAL = 9; // 总账户
    // 新操作类型
    const OPERATE_TYPE_ONLINE_ORDER_PAY = 1; // 1、线上订单支付
    const OPERATE_TYPE_ONLINE_ORDER_SIGN = 2; // 2、线上订单签收
    const OPERATE_TYPE_ONLINE_ORDER_REFUND = 3; // 3、线上订单退款
    const OPERATE_TYPE_ONLINE_ORDER_RETURN = 4; // 4、线上订单退货
    const OPERATE_TYPE_ONLINE_ORDER_CLOSE = 5; // 5、线上订单关闭
    const OPERATE_TYPE_ONLINE_ORDER_COMMENT = 6; // 6、线上订单评论
    const OPERATE_TYPE_ONLINE_ORDER_RIGHT = 7; // 7、线上订单维权
    const OPERATE_TYPE_HOTEL_ORDER_PAY = 8; // 8、酒店订单支付
    const OPERATE_TYPE_HOTEL_ORDER_VERIFY = 9; // 9、酒店订单确认
    const OPERATE_TYPE_HOTEL_ORDER_COMPLETE = 10; // 10、酒店订单完成
    const OPERATE_TYPE_HOTEL_ORDER_COMMENT = 11; // 11、酒店订单评论
    const OPERATE_TYPE_HOTEL_ORDER_CANCEL = 12; // 12、酒店订单取消
    const OPERATE_TYPE_EBANK_RECHARGE = 13; // 13、网银充值
    const OPERATE_TYPE_CARD_RECHARGE = 14; // 14、卡充值
    const OPERATE_TYPE_CASH_APPLY = 15; // 15、申请提现
    const OPERATE_TYPE_CASH_CANCLE = 16; // 16、撤消提现
    const OPERATE_TYPE_OFFLINE_ORDER_PAY = 17; // 17、线下订单支付
    const OPERATE_TYPE_OFFLINE_ORDER_CANCLE = 18; // 18、线下订单撤消
    const OPERATE_TYPE_OFFLINE_ORDER_RECON = 19; // 19、线下订单对账
    const OPERATE_TYPE_CASH_SUCCESS = 20; // 提现成功
    const OPERATE_TYPE_HONGBAO_APPLY = 21; // 红包金额申请
    const OPERATE_TYPE_ASSIGN_ONE = 22; // 调拨（代扣）
    const OPERATE_TYPE_ASSIGN_TWO = 13; // 调拨（网银支付）
    const OPERATE_TYPE_HONGBAO_RECHAGE = 24; //红包充值
    const OPERATE_TYPE_SIGN_TIAOZHENG = 34; //线上订单签收(调整)
    //线下业务新增操作类型
    const OPERATE_TYPE_GROUPBUY_PAY = 24; //线下团购支付
    const OPERATE_TYPE_GROUPBUY_COMPLETE = 25; //线下团购完成
    const OPERATE_TYPE_GROUPBUY_COMMENT = 26; //线下团购评论
    const OPERATE_TYPE_OFFLINE_ORDER_COMMENT = 27; //线下订单评论
    //线下售货机业务新增操作类型
    const OPERATE_TYPE_VENDING_MACHINE = 29; //线下售货机预消费
    const OPERATE_TYPE_VENDING_MACHINE_REFUND = 30; //线下售货机消费解冻
    //旧余额积分转账操作
    const OPERATE_TYPE_TRANSFER_FREEZE = 31; //积分转账冻结
    const OPERATE_TYPE_TRANSFER_UNFREEZE = 32; //积分转账解冻
    const OPERATE_TYPE_TRANSFER_MONEY = 33; //积分转账（出、入）
    //SKU订单
    const OPERATE_TYPE_SKU_PAY = 35;   //SKU订单支付
    const OPERATE_TYPE_SKU_SIGN = 36;   //SKU订单签收
    const OPERATE_TYPE_SKU_CANCEL = 37;   //SKU订单取消
    //游戏金币兑换
    const OPERATE_TYPE_GAME_EXCHANGE = 38;   //游戏兑换
    //便民服务订单
    const OPERATE_TYPE_EPTOK_PAY = 39;            //便民服务订单支付
    const OPERATE_TYPE_EPTOK_CONFIRM = 40;            //便民服务对账,分配
    const OPERATE_TYPE_EPTOK_CANCEL = 41;            //便民服务取消支付
    //盖讯通红包
    const OPERATE_TYPE_ENVELOPE_PAY = 44;   //支付红包
    const OPERATE_TYPE_ENVELOPE_GET = 45;   //获取红包
    const OPERATE_TYPE_ENVELOPE_UNFREEZE = 46;   //解冻红包
    //拍卖活动
    const OPERATE_TYPE_AUCTION_FREEZE = 47; //拍卖活动积分转账冻结
    const OPERATE_TYPE_AUCTION_UNFREEZE = 48; //拍卖活动积分转账解冻
    const OPERATE_TYPE_AUCTION_MONEY = 49; //拍卖活动积分扣除（转出、转入）
    //直充退现金
    const OPERATE_TYPE_REFUND_CASH = 57; //直充退现金
    //资金池账户分配
    const OPERATE_TYPE_CASH_POOLING = 60;

    const OPERATE_TYPE_COVER_CNC_RECHARGE = 63;   //盖讯通电话费充值
    const OPERATE_TYPE_COVER_CNC = 64;   //盖讯通电话费充值完成

    //业务节点
    /*     * 线上订单支付* */
    const BUSINESS_NODE_ONLINE_ORDER_PAY = '0101';   //消费支付
    const BUSINESS_NODE_ONLINE_ORDER_PAY_RED = '0102'; //红包优惠
    const BUSINESS_NODE_ONLINE_ORDER_FREEZE = '0111'; //消费冻结

    /*     * 线上订单签收* */
    const BUSINESS_NODE_ONLINE_ORDER_CONFIRM = '0201';   //确认消费
    const BUSINESS_NODE_ONLINE_ORDER_PAY_MERCHANT = '0211'; //支付货款
    const BUSINESS_NODE_ONLINE_ORDER_PROFIT = '0212';  //利润
    const BUSINESS_NODE_ONLINE_ORDER_DISTRIBUTION = '0213'; //收益分配
    const BUSINESS_NODE_ONLINE_ORDER_REWARD = '0214';  //消费奖励

    /*     * 线上订单退款* */
    const BUSINESS_NODE_ONLINE_ORDER_REFUND_RETURN = '0301'; //收回退款
    const BUSINESS_NODE_ONLINE_ORDER_REFUND_RED = '0302'; //收回红包
    const BUSINESS_NODE_ONLINE_ORDER_REFUND = '0311'; //退还订单金额

    /*     * 线上订单退货* */
    const BUSINESS_NODE_ONLINE_ORDER_RETURN_CASH = '0401'; //收回退货款
    const BUSINESS_NODE_ONLINE_ORDER_RETURN_RED = '0402'; //收回红包
    const BUSINESS_NODE_ONLINE_ORDER_RETURN_CANCEL = '0411'; //退还订单金额
    const BUSINESS_NODE_ONLINE_ORDER_RETURN_CHARGE = '0403'; //支付手续费
    const BUSINESS_NODE_ONLINE_ORDER_RETURN_CHARGE_SHOP = '0412'; //收取手续费

    /*     * 线上订单关闭* */
    const BUSINESS_NODE_ONLINE_ORDER_CLOSE_RETURN_CASH = '0501'; //收回退货款
    const BUSINESS_NODE_ONLINE_ORDER_CLOSE_CALL_RED = '0502'; //收回红包
    const BUSINESS_NODE_ONLINE_ORDER_CLOSE_REWARD_CANCEL = '0511'; //退还订单金额

    /*     * 线上订单评论* */
    const BUSINESS_NODE_ONLINE_ORDER_COMMENT_RETURN = '0601'; //积分解冻
    const BUSINESS_NODE_ONLINE_ORDER_COMMENT_UNFREEZE = '0611'; //解冻转入

    /*     * 线上订单维权* */
    const BUSINESS_NODE_ONLINE_ORDER_RIGHT_REFUND = '0701'; //收回退货款
    const BUSINESS_NODE_ONLINE_ORDER_RIGHT_CALL_RED = '0702'; //收回红包
    const BUSINESS_NODE_ONLINE_ORDER_RIGHT_RETURN_CASH = '0711'; //商户退还货款
    const BUSINESS_NODE_ONLINE_ORDER_RIGHT_REWARD = '0703';  //收回奖励
    const BUSINESS_NODE_ONLINE_ORDER_RIGHT_RETURN_REWARD = '0712'; //退还奖励
    const BUSINESS_NODE_ONLINE_ORDER_RIGHT_RETURN_ORDER = '0713'; //退还订单金额
    const BUSINESS_NODE_ONLINE_ORDER_RIGHT_PAY_CHARGE = '0704'; //支付手续费
    const BUSINESS_NODE_ONLINE_ORDER_RIGHT_GET_CHARGE = '0714'; //收取手续费

    /*     * 酒店订单支付* */
    const BUSINESS_NODE_HOTEL_ORDER_BOOK = '0801'; //预订酒店
    const BUSINESS_NODE_HOTEL_ORDER_CHECK = '0811'; //预订冻结

    /*     * 酒店订单确认* */
    const BUSINESS_NODE_HOTEL_ORDER_CONFIRM = '0901'; //收回订单差额
    const BUSINESS_NODE_HOTEL_ORDER_RETURN = '0911';  //订单差额返还

    /*     * 酒店订单完成* */
    const BUSINESS_NODE_HOTEL_ORDER_FINISH = '1001';  //酒店订单完成
    const BUSINESS_NODE_HOTEL_ORDER_PROFIT = '1011'; //利润
    const BUSINESS_NODE_HOTEL_ORDER_COST = '1012'; //订单成本
    const BUSINESS_NODE_HOTEL_ORDER_DISTRIBUTION = '1013'; //收益分配
    const BUSINESS_NODE_HOTEL_ORDER_LOTTERY = '1014'; //中奖
    const BUSINESS_NODE_HOTEL_ORDER_REWARD = '1015'; //消费奖励

    /*     * 酒店订单评论* */
    const BUSINESS_NODE_HOTEL_ORDER_COMMENT_RETURN = '1101';  //积分解冻
    const BUSINESS_NODE_HOTEL_ORDER_COMMENT_UNFREEZE = '1111'; //解冻转入

    /*     * 酒店订单取消* */
    const BUSINESS_NODE_HOTEL_ORDER_CANCEL = '1201'; //取消订单
    const BUSINESS_NODE_HOTEL_ORDER_CANCEL_RETURN = '1211'; //退还订单金额
    const BUSINESS_NODE_HOTEL_ORDER_CANCEL_CHARGE = '1202'; //支付手续费
    const BUSINESS_NODE_HOTEL_ORDER_CANCEL_GET_CHARGE = '1212'; //收取手续费

    /*     * 线下订单消费* */
    const BUSINESS_NODE_OFFLINE_ORDER_PAY = '1701'; //消费支付
    const BUSINESS_NODE_OFFLINE_ORDER_PAY_CHECK = '1711'; //消费冻结

    /*     * 线下订单撤消* */
    const BUSINESS_NODE_OFFLINE_ORDER_CANCEL = '1801'; //取消订单
    const BUSINESS_NODE_OFFLINE_ORDER_CANCEL_CHECK = '1811'; //返还货款


    /*     * 线下订单对账* */
    const BUSINESS_NODE_OFFLINE_ORDER_CONFIRM = '1901'; //确认消费
    const BUSINESS_NODE_OFFLINE_ORDER_PAY_CASH = '1911'; //支付货款
    const BUSINESS_NODE_OFFLINE_ORDER_REWARD = '1912'; //线下消费奖励
    const BUSINESS_NODE_OFFLINE_ORDER_DISTRIBUTION_AGENT = '1913'; //分配(代理)
    const BUSINESS_NODE_OFFLINE_ORDER_DISTRIBUTION = '1914'; //利润
    const BUSINESS_NODE_OFFLINE_ORDER_DISTRIBUTION_OTHER = '1915'; //分配（其它）

    /*     * 直充* */
    const BUSINESS_NODE_EBANK_HUANXUN = '1311'; //环讯支付
    const BUSINESS_NODE_EBANK_GUANGZHOUYINLIAN = '1312'; //广州银联
    const BUSINESS_NODE_EBANK_YI = '1313';  //翼支付
    const BUSINESS_NODE_EBANK_HI = '1314';  //汇卡支付
    const BUSINESS_NODE_EBANK_POS = '1315';  //POS机刷卡
    const BUSINESS_NODE_EBANK_UM = '1316';  //联动优势
    const BUSINESS_NODE_EBANK_TL = '1317';  //通联支付
    const BUSINESS_NODE_EBANK_GHT = '1318';  //高汇通支付
    const BUSINESS_NODE_EBANK_WEIXIN = '1319'; //微信支付
    const BUSINESS_NODE_EBANK_EBC = '1331';	   //EBC钱包支付

    /*     * 卡充* */
    const BUSINESS_NODE_CARD_RECHARGE = '1401';  //卡充


    /*     * 提现* */
    const BUSINESS_NODE_CASH_APPLY = '1501';  //申请提现
    const BUSINESS_NODE_CASH_CHECK = '1511';  //核对提现

    /*     * 提现打回* */
    const BUSINESS_NODE_CASH_BACK = '1601';   //打回提现申请
    const BUSINESS_NODE_CASH_CANCEL = '1611';  //取消提现

    /*     * 提现成功* */
    const BUSINESS_NODE_CASH_CONFIRM = '2001';  //确认提现

    /*     * 红包金额申请* */
    const BUSINESS_NODE_HONGBAO_APPLY = '2111'; //红包申请
    /** 红包金额充值 */
    const BUSINESS_NODE_HONGBAO_PAY = '2801'; //红包金额转出
    const BUSINESS_NODE_HONGBAO_RECHAGE = '2811'; //红包金额充值
    //调拨 代扣
    const BUSINESS_NODE_ASSIGN_ONE = '2211';
    //调拨（网银支付)
    const BUSINESS_NODE_ASSIGN_TWO = '1332';

    /*     * 线下团购、到店消费相关的业务节点* */
    //线下团购支付
    const BUSINESS_NODE_GROUPBUY_PAY = '2401'; //消费支付
    const BUSINESS_NODE_GROUPBUY_FREEZE = '2411'; //消费冻结
    //线下团购完成
    const BUSINESS_NODE_GROUPBUY_CONFIRM = '2501'; //确认消费
    const BUSINESS_NODE_GROUPBUY_PAY_MERCHANT = '2511'; //支付货款
    const BUSINESS_NODE_GROUPBUY_REWARD = '2512'; //消费奖励
    const BUSINESS_NODE_GROUPBUY_DISTRIBUTION_AGENT = '2513'; //分配(代理)
    const BUSINESS_NODE_GROUPBUY_DISTRIBUTION = '2514'; //利润
    const BUSINESS_NODE_GROUPBUY_DISTRIBUTION_OTHER = '2515'; //分配（其它）
    //线下团购评论
    const BUSINESS_NODE_GROUPBUY_COMMENT_RETURN = '2601'; //积分解冻
    const BUSINESS_NODE_GROUPBUY_COMMENT_UNFREEZE = '2611'; //解冻转入
    //线下订单消费(到店消费)
    const BUSINESS_NODE_OFFLINE_STORE_ORDER_PAY = '1703'; //消费支付
    const BUSINESS_NODE_OFFLINE_STORE_ORDER_FREEZE = '1712'; //消费冻结
    //线下订单对账(到店消费)
    const BUSINESS_NODE_OFFLINE_STORE_ORDER_CONFIRM = '1902'; //确认消费
    const BUSINESS_NODE_OFFLINE_STORE_ORDER_PAY_CASH = '1916'; //支付货款
    const BUSINESS_NODE_OFFLINE_STORE_ORDER_REWARD = '1917'; //线下消费奖励
    const BUSINESS_NODE_OFFLINE_STORE_ORDER_DISTRIBUTION_AGENT = '1918'; //分配(代理)
    const BUSINESS_NODE_OFFLINE_STORE_ORDER_DISTRIBUTION = '1919'; //利润
    const BUSINESS_NODE_OFFLINE_STORE_ORDER_DISTRIBUTION_OTHER = '1920'; //分配（其它）
    //线下订单评论(到店消费)
    const BUSINESS_NODE_OFFLINE_STORE_ORDER_COMMENT_RETURN = '2701'; //积分解冻
    const BUSINESS_NODE_OFFLINE_STORE_ORDER_COMMENT_UNFREEZE = '2711'; //解冻转入
    //线下售货机
    const BUSINESS_NODE_OFFLINE_VENDING_MACHINE = '2901'; //积分冻结
    const BUSINESS_NODE_OFFLINE_VENDING_MACHINE_FREEZE = '2911';  //冻结转入
    const BUSINESS_NODE_OFFLINE_VENDING_MACHINE_REFUND = '3001';  //解冻转入
    const BUSINESS_NODE_OFFLINE_VENDING_MACHINE_REFUND_UNFREEZE = '3011'; //积分解冻
    const BUSINESS_NODE_OFFLINE_VENDING_MACHINE_PAY = '1705';   //线下支付（售货机）
    //会员旧余额冻结(申请)
    const MEMBER_HISTORY_BALANCE_FREEZE = '3101'; //积分冻结
    const MEMBER_HISTORY_BALANCE_FREEZE_INTO = '3111'; //积分冻结转入
    //会员旧余额解冻(通过或不通过)
    const MEMBER_HISTORY_BALANCE_UNFREEZE = '3201'; //积分解冻
    const MEMBER_HISTORY_BALANCE_UNFREEZE_INTO = '3211'; //积分解冻转入
    //会员旧余额转账
    const MEMBER_HISTORY_BALANCE_TRANSFER = '3301'; //积分转账转出
    const MEMBER_HISTORY_BALANCE_TRANSFER_INTO = '3302'; //积分转账转入
    //线上订单签收调整
    const TIAOZHENG_NODE_OUT = '3401'; //调整转出
    const TIAOZHENG_NODE_IN = '3411'; //调整转入
    //SKU订单支付
    const BUSINESS_NODE_SKU_PAY_PAY = '3501';  //SKU订单支付-消费支付
    const BUSINESS_NODE_SKU_PAY_FREEZE = '3511';  //SKU订单支付-消费冻结
    //SKU订单签收
    const BUSINESS_NODE_SKU_SIGN_CONFIRM = '3601'; //SKU订单签收-确认消费
    const BUSINESS_NODE_SKU_SIGN_PAYMENT = '3611'; //SKU订单签收-支付货款
    const BUSINESS_NODE_SKU_SIGN_PROFIT = '3612';  // SKU订单签收-利润
    const BUSINESS_NODE_SKU_SIGN_DISTRIBUTION_MEMBER = '3613';  // SKU订单签收-会员消费奖励
    const BUSINESS_NODE_SKU_SIGN_DISTRIBUTION = '3614';  // SKU订单签收-收益分配 -其它角色
    //SKU订单取消
    const BUSINESS_NODE_SKU_CANCEL_REFUND = '3701';   //SKU订单取消-收回退款
    const BUSINESS_NODE_SKU_CANCEL_RETURN = '3711';    //SKU订单取消-退还订单金额
    const BUSINESS_NODE_SKU_CANCEL_PAY_CHARGE = '3702';    //SKU订单取消-支付手续费
    const BUSINESS_NODE_SKU_CANCEL_GET_CHARGE = '3712';    //SKU订单取消-收取手续费
    //游戏兑换
    const BUSINESS_NODE_GAME_EXCHANGE = '3801';    //游戏兑换
    const BUSINESS_NODE_GAME_INCOME = '3811';    //游戏收益
    //便民服务订单支付
    const BUSINESS_NODE_EPTOK_PAY_PAY = '3901';  //消费支付
    const BUSINESS_NODE_EPTOK_PAY_FREEZE = '3911';  //消费冻结
    //便民服务对账，分配
    const BUSINESS_NODE_EPTOK_PAY_CONFIRM = '4001';  //确认消费
    const BUSINESS_NODE_EPTOK_PAYMENT = '4011';  //支付货款
    const BUSINESS_NODE_EPTOK_PAY_INCOME = '4012';  //公司利润
    //便民服务对账，分配
    const BUSINESS_NODE_EPTOK_CANCEL_REFUND = '4101';  //收回退款
    const BUSINESS_NODE_EPTOK_CANCEL_RETURN = '4111';  //退货订单金额

    /*     * 盖讯通红包支付* */
    const BUSINESS_NODE_ONLINE_ENVELOPE_PAY = '4401';   //消费支付
    const BUSINESS_NODE_ONLINE_ENVELOPE_FREEZE = '4411'; //消费冻结
    const BUSINESS_NODE_ONLINE_ENVELOPE_PROFIT = '4501'; //确认领取
    const BUSINESS_NODE_ONLINE_ENVELOPE_UNFREEZE = '4511'; //总账户转至会员入账
    const BUSINESS_NODE_ONLINE_ENVELOPE_BACK = '4601'; //回收红包
    const BUSINESS_NODE_ONLINE_ENVELOPE_UNFREEZE_BACK = '4611'; //退还订单金额

    /* 拍卖活动 */
    const BUSINESS_NODE_AUCTION_FREEZE = '4701'; //拍卖活动积分冻结
    const BUSINESS_NODE_AUCTION_FREEZE_INTO = '4711'; //拍卖活动积分冻结转入
    const BUSINESS_NODE_AUCTION_UNFREEZE = '4801'; //拍卖活动积分解冻
    const BUSINESS_NODE_AUCTION_UNFREEZE_INTO = '4811'; //拍卖活动积分解冻转入
    const BUSINESS_NODE_AUCTION_BALANCE_TRANSFER = '4901'; //中标未支付冻结积分扣除(会员冻结账号转出)
    const BUSINESS_NODE_AUCTION_BALANCE_TRANSFER_INTO = '4911'; //中标未支付冻结积分增加(总帐户帐号转入)

    //盖讯通电话费充值
    const BUSINESS_NODE_COVER_CNC_PAY = '6301'; //消费
    const BUSINESS_NODE_COVER_CNC_FREEZE = '6311'; //消费冻结
    //盖讯通电话费充值完成
    const BUSINESS_NODE_COVER_CNC_CONFIRM = '6401'; //确认消费
    const BUSINESS_NODE_COVER_CNC_PROFIT = '6412'; //利润

    //直充退现金
    const BUSINESS_NODE_REFUND_CASH = 5711; //订单取消积分退现金
    //资金池账户分配
    const BUSINESS_NODE_CASH_POOLING_OUT = 6001;   //资金池账户转出
    const BUSINESS_NODE_CASH_POOLING_INPUT = 6011;   //会员转入
    //事务类型
    const TRANSACTION_TYPE_CONSUME = 1;  //消费
    const TRANSACTION_TYPE_DISTRIBUTION = 2; //分配
    const TRANSACTION_TYPE_REFUND = 3; //退款
    const TRANSACTION_TYPE_RETURN = 4; //退货
    const TRANSACTION_TYPE_ORDER_CANCEL = 5; //取消订单
    const TRANSACTION_TYPE_COMMENT = 6; //评论
    const TRANSACTION_TYPE_RIGHTS = 7; //维权
    const TRANSACTION_TYPE_ORDER_CONFIRM = 8; //订单确认
    const TRANSACTION_TYPE_RECHARGE = 9;  //充值
    const TRANSACTION_TYPE_CASH = 10; //提现
    const TRANSACTION_TYPE_CASH_CANCEL = 11; //取消提现
    const TRANSACTION_TYPE_CASH_HONGBAO_APPLY = 12; //红包申请
    const TRANSACTION_TYPE_ASSIGN = 13;  //调拨
    const TRANSACTION_TYPE_CASH_HONGBAO_RECHARGE = 14; //红包充值
    const TRANSACTION_TYPE_OTHER_REFUND = 15; //其它退款
    const TRANSACTION_TYPE_TRANSFER = 16; //旧余额转账
    const TRANSACTION_TYPE_TIAOZHENG = 17; //调整
    const TRANSACTION_TYPE_ENVELOPE = 18;  //盖讯通红包
    const TRANSACTION_TYPE_FREEZE = 19;  //冻结

    /**
     *   `recharge_type` '充值类型',
     */
    const RECHARGE_TYPE_BANK = 1; //直充
    const RECHARGE_TYPE_CARD = 2; //卡充
    const FLAG_SPECIAL = 1; //特殊的流水，不显示

    /**
     * @var string 搜索用
     */

    public $endTime;
    public $month;
    public $isExport; //是否导出excel
    public $pcode; //商城支付单号
    public $parent_code; //酒店支付单号
    public $fcode; //盖网通支付单号
    public $allcode;//支付单号汇总
    public $payType;//支付类别

    /**
     * 返回支付节点类别
     * @param string $k
     * @return Ambigous <string, string, unknown>
     */
    public static function returnNode($k = null) {
        $arr = array(
                self::BUSINESS_NODE_EBANK_HUANXUN => Yii::t('order', '环讯支付'),
                self::BUSINESS_NODE_EBANK_GUANGZHOUYINLIAN => Yii::t('order', '广州银联'),
                self::BUSINESS_NODE_EBANK_YI => Yii::t('order', '翼支付'),
                self::BUSINESS_NODE_EBANK_HI => Yii::t('order', '汇卡支付'),
                self::BUSINESS_NODE_EBANK_UM => Yii::t('order', '联动优势'),
                self::BUSINESS_NODE_EBANK_TL => Yii::t('order', '通联支付'),
                self::BUSINESS_NODE_EBANK_GHT => Yii::t('order', '高汇通支付'),
        );
        return is_numeric($k) ? (isset($arr[$k]) ? $arr[$k] : '') : '';
    }

    /**
     * 当前月份表
     * @return string
     */

    public function tableName() {
        $month = Yii::app()->user->getState('accountFlowMonth');
        if (empty($month))
            return self::monthTable();
        $this->month = $month;
        return self::$_baseTableName . '_' . str_replace('-', '', $month);
    }

    /**
     * 搜索用月份列表
     * @return array
     */
    public static function getMonth() {
        $date = '2015-01-01';
        $unixTime = strtotime($date);
        list($startDate['y'], $startDate['m']) = explode("-", $date);
        list($endDate['y'], $endDate['m']) = explode("-", date('Y-m', time()));
        $num = abs($startDate['y'] - $endDate['y']) * 12 + $endDate['m'] - $startDate['m'];
        $month = array();
        for ($i = 0; $i <= $num; $i++) {
            $monthTime = date('Y-m', $unixTime + (31 * $i * 86400));
            $month[$monthTime] = $monthTime;
        }
        return $month;
    }

    public function rules() {
        return array(
            array('create_time,endTime', 'length', 'max' => 20),
            array('remark', 'length', 'max' => 255),
            array('type,operate_type', 'numerical', 'integerOnly' => true),
            array('gai_number,create_time,endTime,remark, type, card_no, month, order_code, operate_type', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'month' => '月份',
            'id' => '主键',
            'account_id' => '所属账号',
            'gai_number' => 'GW号',
            'card_no' => '卡号',
            'date' => '日期',
            'create_time' => '创建时间',
            'type' => '类型', //（1商家、2代理、3消费、4待返还、5冻结、6、盖网公共、9总账户）
            'debit_amount' => '借方发生额',
            'credit_amount' => '贷方发生额',
            'operate_type' => '交易类型', //（1、线上订单支付2、线上订单签收3、线上订单退款4、线上订单退货5、线上订单关闭6、线上订单评论7、线上订单维权8、酒店订单支付9、酒店订单确认10、酒店订单完成11、酒店订单评论12、酒店订单取消13、网银充值14、卡充值15、申请提现16、撤消提现17、线下订单支付18、线下订单撤消19、线下订单对账20、提现成功）
            'trade_spec' => '地点',
            'trade_terminal_id' => '所属终端',
            'ratio' => '比率',
            'order_id' => '订单ID',
            'order_code' => '订单编号',
            'area_id' => '区域类型',
            'remark' => '备注',
            'province_id' => '省份',
            'city_id' => '城市',
            'district_id' => '区/县',
            'week' => '第几周',
            'week_day' => '星期几',
            'ip' => '客户IP',
            'hour' => '小时',
            'moved' => '是否搬送', //（0否、1是）
            'node' => '业务节点',
            'franchisee_id' => '加盟商ID',
            'recharge_type' => '充值类型',
            'distribution_ratio' => '分配比率',
            'transaction_type' => '事务类型',
            'parent_id' => 'Parent',
            'prepaid_card_no' => '充值卡编号',
            'current_balance' => '当前余额',
            'flag' => '标识', //（0无、1特殊）1特殊是代扣的流水，不在前台显示给会员看
            'pcode'=>'商城支付单号',
            'parent_code'=>'酒店支付单号',
            'fcode' =>'盖网通支付单号',
            'allcode'=>'支付单号',
            'payType'=>'支付平台'
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('operate_type', $this->operate_type);
        $criteria->compare('remark', $this->remark, true);
        $searchDate = Tool::searchDateFormat($this->create_time, $this->endTime);
        $criteria->compare('create_time', ">=" . $searchDate['start']);
        $criteria->compare('create_time', "<" . $searchDate['end']);

        $fields = '`id`,`type`,`remark`, `create_time`, `debit_amount`, `credit_amount`, `by_gai_number`,`order_code`,`operate_type`';
        $sql = 'SELECT ' . $fields . ' FROM ' . self::monthTable() . ' WHERE account_id = :mid
            AND flag = 0 AND create_time>=:create_time AND (type IN (:t1) or (type = :t5 and node in( :node1 , :node2,:node3))) :condition
            UNION ALL SELECT ' . $fields . ' FROM ' . self::hashTable(Yii::app()->user->gw) . '
            WHERE account_id = :mid AND flag = 0 AND (type IN (:t1) or (type = :t5 and node in( :node1 , :node2,:node3))) :condition';
        $sqlCount = 'SELECT COUNT(*) FROM ( ' . $sql . ' ) AS a';
        $params = array(
            ':mid' => Yii::app()->user->id,
            ':create_time' => strtotime(date('Y-m-d')),
            ':t1' => self::TYPE_CONSUME,
            //            ':t2' => self::TYPE_RETURN,
            ':t5' => self::TYPE_FREEZE,
            ':node1' => AccountFlow::BUSINESS_NODE_OFFLINE_VENDING_MACHINE_FREEZE,
            ':node2' => AccountFlow::BUSINESS_NODE_OFFLINE_VENDING_MACHINE_REFUND_UNFREEZE,
            ':node3' => AccountFlow::BUSINESS_NODE_OFFLINE_VENDING_MACHINE_PAY
        );
        //搜索
        $params = array_merge($params, $criteria->params);
        $sql = str_replace(':condition', empty($criteria->condition) ? '' : ' and ' . $criteria->condition, $sql);
        $sqlCount = str_replace(':condition', empty($criteria->condition) ? '' : ' and ' . $criteria->condition, $sqlCount);

        $count = Yii::app()->db->createCommand($sqlCount)->bindValues($params)->queryScalar();
        $command = Yii::app()->db->createCommand($sql);
        return new CSqlDataProvider($command, array(
            'params' => $params,
            'totalItemCount' => $count,
            'sort' => array(
                'defaultOrder' => 'create_time DESC',
            ),
        ));
    }

    /**
     * 账户明细搜索
     * @return CSqlDataProvider
     */
    public function searchForStore() {
        $criteria = new CDbCriteria;
        $criteria->compare('operate_type', $this->operate_type);
        $criteria->compare('remark', $this->remark, true);
        $searchDate = Tool::searchDateFormat($this->create_time, $this->endTime);
        $criteria->compare('create_time', ">=" . $searchDate['start']);
        $criteria->compare('create_time', "<" . $searchDate['end']);

        return self::searchFlow($criteria, array(self::TYPE_MERCHANT, self::TYPE_AGENT));
    }

    /**
     * 后台列表
     * @return CActiveDataProvider
     */
    public function backendSearch() {
        $criteria = new CDbCriteria;
        $criteria->compare('t.gai_number', $this->gai_number, true);
        $criteria->compare('t.card_no', $this->card_no, true);
        $criteria->compare('t.type', $this->type);
        $criteria->compare('t.operate_type', $this->operate_type);
        $criteria->compare('t.order_code', $this->order_code, true);
        $criteria->compare('t.node', $this->node, true);
        $criteria->compare('t.transaction_type', $this->transaction_type, true);
        $criteria->select = 't.*,o.parent_code AS pcode,ho.parent_code,f.serial_number AS fcode,
                CONCAT(IFNULL(o.parent_code,""),IFNULL(ho.parent_code,""),IFNULL(f.serial_number,"")) as allcode,
                CONCAT(IFNULL(o.pay_type,""),IFNULL(ho.pay_type,"")) as payType';
        $criteria->join  ='left join gaiwang.{{order}} as o on t.order_code = o.`code` ';
        $criteria->join .='left join gaiwang.{{hotel_order}} as ho on t.order_code = ho.`code`';
        $criteria->join .='left join gaiwang.{{franchisee_consumption_record}} as f on t.order_code = f.`serial_number`';
        $pagination = array();
        if (!empty($this->isExport)) {
            $pagination['pageSize'] = 5000;
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pagination,
            'sort' => array(
                'defaultOrder' => 't.id DESC',
            ),
        ));
    }

    /**
     * 查询流水公共方法
     * @param CDbCriteria $criteria				//查询类
     * @param int/array $type				//角色类型
     * @return CSqlDataProvider
     */
    public static function searchFlow($criteria, $type) {
        $uid = Yii::app()->user->id;       //登录会员id
        $now = strtotime(date('Y-m-d'));      //当前时间
        $monthTable = self::monthTable();      //当月表
        $memberTable = self::hashTable(Yii::app()->user->gw); //会员流水表

        $sqType = is_numeric($type) ? 'type = ' . $type : 'type in (' . implode(",", $type) . ')';

        $sqlTime = ' AND create_time >= ' . $now;
        $sql = 'SELECT
                *
            FROM
                ' . $monthTable . '
            WHERE
                account_id = ' . $uid . $sqlTime . '
            AND ' . $sqType . ' :condition
            UNION ALL
                SELECT
                    *
                FROM
                    ' . $memberTable . '
                WHERE
                    account_id = ' . $uid . '
                AND ' . $sqType . ' :condition';

        $sqlCount = '
                select count(*) from (
                SELECT
                        *
                    FROM
                        ' . $monthTable . '
                    WHERE
                        account_id = ' . $uid . $sqlTime . '
                    AND ' . $sqType . ' :condition
                    UNION ALL
                        SELECT
                            *
                        FROM
                            ' . $memberTable . '
                        WHERE
                            account_id = ' . $uid . '
                        AND ' . $sqType . ' :condition
                ) as a
                        ';
        //搜索
        $sql = str_replace(':condition', empty($criteria->condition) ? '' : ' and ' . $criteria->condition, $sql);
        $sqlCount = str_replace(':condition', empty($criteria->condition) ? '' : ' and ' . $criteria->condition, $sqlCount);

        $count = Yii::app()->db->createCommand($sqlCount)->bindValues($criteria->params)->queryScalar();
        $command = Yii::app()->db->createCommand($sql);
        return new CSqlDataProvider($command, array(
            'params' => $criteria->params,
            'totalItemCount' => $count,
            'sort' => array(
                'defaultOrder' => 'create_time DESC',
            ),
        ));
    }

    //代理后台查询代理进账明细
    public function searchAgent() {
        $criteria = new CDbCriteria;
        $searchDate = Tool::searchDateFormat($this->create_time, $this->endTime);
        $criteria->compare('create_time', ">=" . $searchDate['start']);
        $criteria->compare('create_time', "<" . $searchDate['end']);

        return self::searchFlow($criteria, array(self::TYPE_AGENT));
    }

    //商家后台查询后台查询代理进账明细
    public function searchSeller() {
        $criteria = new CDbCriteria;
        $searchDate = Tool::searchDateFormat($this->create_time, $this->endTime);
        $criteria->compare('create_time', ">=" . $searchDate['start']);
        $criteria->compare('create_time', "<" . $searchDate['end']);
        return self::searchFlow($criteria, array(self::TYPE_MERCHANT));
    }

    public function getDbConnection() {
        return Yii::app()->ac;
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getType() {
        return array(
            self::TYPE_MERCHANT => '商家',
            self::TYPE_AGENT => '代理',
            self::TYPE_CONSUME => '消费',
            self::TYPE_RETURN => '待返还',
            self::TYPE_FREEZE => '冻结',
            self::TYPE_COMMON => '公共',
            self::TYPE_TOTAL => '总账户',
            self::TYPE_CASH => '普通会员提现账户',
                //self::OPERATE_TYPE_ENVELOPE_PAY=>'盖象通红包'
        );
    }

    public static function showType($key) {
        $typies = self::getType();
        return isset($typies[$key]) ? $typies[$key] : '';
    }

    public static function getOperateType() {
        return array(
            self::OPERATE_TYPE_ONLINE_ORDER_PAY => '线上订单支付',
            self::OPERATE_TYPE_ONLINE_ORDER_SIGN => '线上订单签收',
            self::OPERATE_TYPE_ONLINE_ORDER_REFUND => '线上订单退款',
            self::OPERATE_TYPE_ONLINE_ORDER_RETURN => '线上订单退货',
            self::OPERATE_TYPE_ONLINE_ORDER_CLOSE => '线上订单关闭',
            self::OPERATE_TYPE_ONLINE_ORDER_COMMENT => '线上订单评论',
            self::OPERATE_TYPE_ONLINE_ORDER_RIGHT => '线上订单维权',
            self::OPERATE_TYPE_HOTEL_ORDER_PAY => '酒店订单支付',
            self::OPERATE_TYPE_HOTEL_ORDER_VERIFY => '酒店订单确认',
            self::OPERATE_TYPE_HOTEL_ORDER_COMPLETE => '酒店订单完成',
            self::OPERATE_TYPE_HOTEL_ORDER_COMMENT => '酒店订单评论',
            self::OPERATE_TYPE_HOTEL_ORDER_CANCEL => '酒店订单取消',
            self::OPERATE_TYPE_EBANK_RECHARGE => '网银充值',
            self::OPERATE_TYPE_CARD_RECHARGE => '充值卡充值',
            self::OPERATE_TYPE_CASH_APPLY => '申请提现',
            self::OPERATE_TYPE_CASH_CANCLE => '撤消提现',
            self::OPERATE_TYPE_OFFLINE_ORDER_PAY => '线下订单支付',
            self::OPERATE_TYPE_OFFLINE_ORDER_CANCLE => '线下订单撤消',
            self::OPERATE_TYPE_OFFLINE_ORDER_RECON => '线下订单对账',
            self::OPERATE_TYPE_CASH_SUCCESS => '提现成功',
            self::OPERATE_TYPE_ASSIGN_ONE => '调拨（代扣）',
//             self::OPERATE_TYPE_ASSIGN_TWO => '调拨（网银支付）',   //调拨节点调整为13，删除重复数据。@author LC
            self::OPERATE_TYPE_GROUPBUY_PAY => '线下团购支付',
            self::OPERATE_TYPE_GROUPBUY_COMPLETE => '线下团购完成',
            self::OPERATE_TYPE_GROUPBUY_COMMENT => '线下团购评论',
            self::OPERATE_TYPE_OFFLINE_ORDER_COMMENT => '线下订单评论',
            self::OPERATE_TYPE_HONGBAO_APPLY => '红包金额申请',
            self::OPERATE_TYPE_HONGBAO_RECHAGE => '红包金额充值',
            self::OPERATE_TYPE_VENDING_MACHINE => '线下售货机预消费',
            self::OPERATE_TYPE_VENDING_MACHINE_REFUND => '线下售货机消费解冻',
            self::OPERATE_TYPE_TRANSFER_FREEZE => '积分转账冻结',
            self::OPERATE_TYPE_TRANSFER_UNFREEZE => '积分转账解冻',
            self::OPERATE_TYPE_TRANSFER_MONEY => '积分转账',
            self::OPERATE_TYPE_SIGN_TIAOZHENG => '线上订单签收(调整)',
            self::OPERATE_TYPE_SKU_PAY => 'SKU订单支付',
            self::OPERATE_TYPE_SKU_SIGN => 'SKU订单签收',
            self::OPERATE_TYPE_SKU_CANCEL => 'SKU订单取消',
            self::OPERATE_TYPE_GAME_EXCHANGE => '游戏兑换',
            self::OPERATE_TYPE_EPTOK_PAY => '便民服务订单支付',
            self::OPERATE_TYPE_EPTOK_CONFIRM => '便民服务对账',
            self::OPERATE_TYPE_EPTOK_CANCEL => '便民服务取消支付',
            self::OPERATE_TYPE_ENVELOPE_PAY => '支付盖讯通红包',
            self::OPERATE_TYPE_ENVELOPE_GET => '获取盖讯通红包',
            self::OPERATE_TYPE_ENVELOPE_UNFREEZE => '退回盖讯通红包',
            self::OPERATE_TYPE_AUCTION_FREEZE => '拍卖活动积分冻结',
            self::OPERATE_TYPE_AUCTION_UNFREEZE => '拍卖活动积分解冻',
            self::OPERATE_TYPE_AUCTION_MONEY => '拍卖活动积分扣除',
            self::OPERATE_TYPE_REFUND_CASH => '直充退现金',
            self::OPERATE_TYPE_COVER_CNC_RECHARGE => '盖讯通电话费充值',
            self::OPERATE_TYPE_COVER_CNC => '盖讯通电话费充值完成',
        );
    }

    public static function getOperateTypeOther() {
        return array(
            self::OPERATE_TYPE_ONLINE_ORDER_PAY => '线上订单支付',
            self::OPERATE_TYPE_ONLINE_ORDER_COMMENT => '线上订单评论',
            self::OPERATE_TYPE_ONLINE_ORDER_REFUND => '线上订单退款',
            self::OPERATE_TYPE_HOTEL_ORDER_PAY => '酒店订单支付',
            self::OPERATE_TYPE_HOTEL_ORDER_CANCEL => '酒店订单取消',
            self::OPERATE_TYPE_EBANK_RECHARGE => '网银充值',
            self::OPERATE_TYPE_CASH_APPLY => '申请提现',
            self::OPERATE_TYPE_OFFLINE_ORDER_PAY => '线下订单支付',
            self::OPERATE_TYPE_OFFLINE_ORDER_CANCLE => '线下订单撤消',
        );
    }

    public static function showOperateType($key) {
        $operateTypes = self::getOperateType();
        return isset($operateTypes[$key]) ? $operateTypes[$key] : $key;
    }

    /**
     * 事务类型
     * @param type $key
     * @return string
     */
    public static function showTransactinnType($key) {
        $transTypes = array(
            self::TRANSACTION_TYPE_CONSUME => '消费',
            self::TRANSACTION_TYPE_DISTRIBUTION => '分配',
            self::TRANSACTION_TYPE_REFUND => '退款',
            self::TRANSACTION_TYPE_RETURN => '退货',
            self::TRANSACTION_TYPE_ORDER_CANCEL => '取消订单',
            self::TRANSACTION_TYPE_COMMENT => '评论',
            self::TRANSACTION_TYPE_RIGHTS => '维权',
            self::TRANSACTION_TYPE_ORDER_CONFIRM => '订单确认',
            self::TRANSACTION_TYPE_RECHARGE => '充值',
            self::TRANSACTION_TYPE_CASH => '提现',
            self::TRANSACTION_TYPE_CASH_CANCEL => '取消提现',
            self::TRANSACTION_TYPE_ASSIGN => '调拨',
            self::TRANSACTION_TYPE_CASH_HONGBAO_APPLY => '红包申请',
            self::TRANSACTION_TYPE_CASH_HONGBAO_RECHARGE => '红包充值',
            self::TRANSACTION_TYPE_OTHER_REFUND => '其它退款',
            self::TRANSACTION_TYPE_TRANSFER => '旧余额转账',
            self::TRANSACTION_TYPE_TIAOZHENG => '调整',
            self::TRANSACTION_TYPE_ENVELOPE => '盖讯通红包',
            self::TRANSACTION_TYPE_FREEZE => '冻结',
        );
        return $transTypes[$key];
    }

    /**
     * 获取业务节点内容
     * @author LC
     */
    public static function getBusinessNode() {
        return array(
            self::BUSINESS_NODE_ONLINE_ORDER_PAY => '消费支付',
            self::BUSINESS_NODE_ONLINE_ORDER_FREEZE => '消费冻结',
            self::BUSINESS_NODE_ONLINE_ORDER_CONFIRM => '确认消费',
            self::BUSINESS_NODE_ONLINE_ORDER_PAY_MERCHANT => '支付货款',
            self::BUSINESS_NODE_ONLINE_ORDER_PROFIT => '利润',
            self::BUSINESS_NODE_ONLINE_ORDER_DISTRIBUTION => '收益分配',
            self::BUSINESS_NODE_ONLINE_ORDER_REWARD => '消费奖励',
            self::BUSINESS_NODE_ONLINE_ORDER_REFUND_RETURN => '收回退款',
            self::BUSINESS_NODE_ONLINE_ORDER_REFUND => '退还订单金额',
            self::BUSINESS_NODE_ONLINE_ORDER_RETURN_CASH => '收回退货款',
            self::BUSINESS_NODE_ONLINE_ORDER_RETURN_CANCEL => '退还订单金额',
            self::BUSINESS_NODE_ONLINE_ORDER_RETURN_CHARGE => '支付手续费',
            self::BUSINESS_NODE_ONLINE_ORDER_RETURN_CHARGE_SHOP => '收取手续费',
            self::BUSINESS_NODE_ONLINE_ORDER_CLOSE_RETURN_CASH => '收回退货款',
            self::BUSINESS_NODE_ONLINE_ORDER_CLOSE_REWARD_CANCEL => '退还订单金额',
            self::BUSINESS_NODE_ONLINE_ORDER_COMMENT_RETURN => '积分解冻',
            self::BUSINESS_NODE_ONLINE_ORDER_COMMENT_UNFREEZE => '解冻转入',
            self::BUSINESS_NODE_ONLINE_ORDER_RIGHT_REFUND => '收回退货款',
            self::BUSINESS_NODE_ONLINE_ORDER_RIGHT_RETURN_CASH => '商户退还货款',
            self::BUSINESS_NODE_ONLINE_ORDER_RIGHT_REWARD => '收回奖励',
            self::BUSINESS_NODE_ONLINE_ORDER_RIGHT_RETURN_REWARD => '退还奖励',
            self::BUSINESS_NODE_ONLINE_ORDER_RIGHT_RETURN_ORDER => '退还订单金额',
            self::BUSINESS_NODE_ONLINE_ORDER_RIGHT_PAY_CHARGE => '支付手续费',
            self::BUSINESS_NODE_ONLINE_ORDER_RIGHT_GET_CHARGE => '收取手续费',
            self::BUSINESS_NODE_ONLINE_ORDER_PAY_RED => '红包优惠',
            self::BUSINESS_NODE_ONLINE_ORDER_CLOSE_CALL_RED => '收回红包',
            self::BUSINESS_NODE_ONLINE_ORDER_REFUND_RED => '收回红包',
            self::BUSINESS_NODE_ONLINE_ORDER_RETURN_RED => '收回红包',
            self::BUSINESS_NODE_HOTEL_ORDER_BOOK => '预订酒店',
            self::BUSINESS_NODE_HOTEL_ORDER_CHECK => '预订冻结',
            self::BUSINESS_NODE_HOTEL_ORDER_CONFIRM => '收回订单差额',
            self::BUSINESS_NODE_HOTEL_ORDER_RETURN => '订单差额返还',
            self::BUSINESS_NODE_HOTEL_ORDER_FINISH => '订单完成',
            self::BUSINESS_NODE_HOTEL_ORDER_PROFIT => '利润',
            self::BUSINESS_NODE_HOTEL_ORDER_COST => '订单成本',
            self::BUSINESS_NODE_HOTEL_ORDER_LOTTERY => '中奖',
            self::BUSINESS_NODE_HOTEL_ORDER_REWARD => '消费奖励',
            self::BUSINESS_NODE_HOTEL_ORDER_DISTRIBUTION => '收益分配',
            self::BUSINESS_NODE_HOTEL_ORDER_COMMENT_RETURN => '积分解冻',
            self::BUSINESS_NODE_HOTEL_ORDER_COMMENT_UNFREEZE => '解冻转入',
            self::BUSINESS_NODE_HOTEL_ORDER_CANCEL => '取消订单',
            self::BUSINESS_NODE_HOTEL_ORDER_CANCEL_RETURN => '退还订单金额',
            self::BUSINESS_NODE_HOTEL_ORDER_CANCEL_CHARGE => '支付手续费',
            self::BUSINESS_NODE_HOTEL_ORDER_CANCEL_GET_CHARGE => '收取手续费',
            self::BUSINESS_NODE_OFFLINE_ORDER_PAY => '消费支付',
            self::BUSINESS_NODE_OFFLINE_ORDER_PAY_CHECK => '消费冻结',
            self::BUSINESS_NODE_OFFLINE_ORDER_CANCEL => '取消订单',
            self::BUSINESS_NODE_OFFLINE_ORDER_CANCEL_CHECK => '返还货款',
            self::BUSINESS_NODE_OFFLINE_ORDER_CONFIRM => '确认消费',
            self::BUSINESS_NODE_OFFLINE_ORDER_PAY_CASH => '支付货款',
            self::BUSINESS_NODE_OFFLINE_ORDER_REWARD => '线下消费奖励',
            self::BUSINESS_NODE_OFFLINE_ORDER_DISTRIBUTION_AGENT => '分配(代理)',
            self::BUSINESS_NODE_OFFLINE_ORDER_DISTRIBUTION => '利润',
            self::BUSINESS_NODE_OFFLINE_ORDER_DISTRIBUTION_OTHER => '分配（其它）',
            self::BUSINESS_NODE_EBANK_HUANXUN => '环讯支付',
            self::BUSINESS_NODE_EBANK_GUANGZHOUYINLIAN => '广州银联',
            self::BUSINESS_NODE_EBANK_YI => '翼支付',
            self::BUSINESS_NODE_EBANK_HI => '汇卡支付',
            self::BUSINESS_NODE_EBANK_UM => '联动优势',
            self::BUSINESS_NODE_CARD_RECHARGE => '卡充',
            self::BUSINESS_NODE_CASH_APPLY => '申请提现',
            self::BUSINESS_NODE_CASH_CHECK => '核对提现',
            self::BUSINESS_NODE_CASH_BACK => '打回提现申请',
            self::BUSINESS_NODE_CASH_CANCEL => '取消提现',
            self::BUSINESS_NODE_CASH_CONFIRM => '确认提现',
            self::BUSINESS_NODE_ASSIGN_ONE => '调拨（代扣）',
            self::BUSINESS_NODE_ASSIGN_TWO => '调拨（网银支付）',
            self::BUSINESS_NODE_HONGBAO_APPLY => '红包申请',
            self::BUSINESS_NODE_GROUPBUY_PAY => '消费支付',
            self::BUSINESS_NODE_GROUPBUY_FREEZE => '消费冻结',
            self::BUSINESS_NODE_HONGBAO_PAY => '红包转出',
            self::BUSINESS_NODE_HONGBAO_RECHAGE => '红包金额充值',
            self::BUSINESS_NODE_OFFLINE_VENDING_MACHINE => '积分冻结',
            self::BUSINESS_NODE_OFFLINE_VENDING_MACHINE_FREEZE => '冻结转入',
            self::BUSINESS_NODE_OFFLINE_VENDING_MACHINE_REFUND => '积分解冻',
            self::BUSINESS_NODE_OFFLINE_VENDING_MACHINE_REFUND_UNFREEZE => '解冻转入',
            self::BUSINESS_NODE_OFFLINE_VENDING_MACHINE_PAY => '线下支付（售货机）',
            self::MEMBER_HISTORY_BALANCE_FREEZE => '旧余额积分冻结',
            self::MEMBER_HISTORY_BALANCE_FREEZE_INTO => '旧余额积分冻结转入',
            self::MEMBER_HISTORY_BALANCE_UNFREEZE => '旧余额积分解冻',
            self::MEMBER_HISTORY_BALANCE_UNFREEZE_INTO => '旧余额积分解冻转入',
            self::MEMBER_HISTORY_BALANCE_TRANSFER => '旧余额转账转出',
            self::MEMBER_HISTORY_BALANCE_TRANSFER_INTO => '旧余额转账转入',
            self::TIAOZHENG_NODE_OUT => '调整转出',
            self::TIAOZHENG_NODE_IN => '调整转入',
            self::BUSINESS_NODE_SKU_PAY_PAY => 'SKU订单支付-消费支付',
            self::BUSINESS_NODE_SKU_PAY_FREEZE => 'SKU订单支付-消费冻结',
            self::BUSINESS_NODE_SKU_SIGN_CONFIRM => 'SKU订单签收-确认消费',
            self::BUSINESS_NODE_SKU_SIGN_PAYMENT => 'SKU订单签收-支付货款',
            self::BUSINESS_NODE_SKU_SIGN_PROFIT => 'SKU订单签收-利润',
            self::BUSINESS_NODE_SKU_SIGN_DISTRIBUTION_MEMBER => 'SKU订单签收-会员消费奖励',
            self::BUSINESS_NODE_SKU_SIGN_DISTRIBUTION => 'SKU订单签收-收益分配 -其它角色',
            self::BUSINESS_NODE_SKU_CANCEL_REFUND => 'SKU订单取消-收回退款',
            self::BUSINESS_NODE_SKU_CANCEL_RETURN => 'SKU订单取消-退还订单金额',
            self::BUSINESS_NODE_SKU_CANCEL_PAY_CHARGE => 'SKU订单取消-支付手续费',
            self::BUSINESS_NODE_SKU_CANCEL_GET_CHARGE => 'SKU订单取消-收取手续费',
            self::BUSINESS_NODE_GAME_EXCHANGE => '游戏金币兑换',
            self::BUSINESS_NODE_GAME_INCOME => '游戏收益',
            self::BUSINESS_NODE_EPTOK_PAY_PAY => '便民服务-消费支付',
            self::BUSINESS_NODE_EPTOK_PAY_FREEZE => '便民服务-消费冻结',
            self::BUSINESS_NODE_EPTOK_PAY_CONFIRM => '便民服务-确认消费',
            self::BUSINESS_NODE_EPTOK_PAYMENT => '便民服务-支付货款',
            self::BUSINESS_NODE_EPTOK_PAY_INCOME => '便民服务-利润',
            self::BUSINESS_NODE_EPTOK_CANCEL_REFUND => '便民服务-收回退款',
            self::BUSINESS_NODE_EPTOK_CANCEL_RETURN => '便民服务-退货金额',
            self::BUSINESS_NODE_AUCTION_FREEZE => '拍卖活动积分冻结',
            self::BUSINESS_NODE_AUCTION_FREEZE_INTO => '拍卖活动积分冻结转入',
            self::BUSINESS_NODE_AUCTION_UNFREEZE => '拍卖活动积分解冻',
            self::BUSINESS_NODE_AUCTION_UNFREEZE_INTO => '拍卖活动积分解冻转入',
            self::BUSINESS_NODE_AUCTION_BALANCE_TRANSFER => '拍卖活动中标未支付冻结积分扣除',
            self::BUSINESS_NODE_AUCTION_BALANCE_TRANSFER_INTO => '拍卖活动中标未支付冻结积分转入总帐',
            self::BUSINESS_NODE_REFUND_CASH => '订单取消积分退现金',
        );
    }

    /**
     * 获取单个业务节点内容
     * @author LC
     */
    public static function showBusinessNode($key) {
        $businessNodes = self::getBusinessNode();
        return $businessNodes[$key];
    }

    /**
     * 按月创建表
     * @return string
     */
    public static function monthTable() {
        $time = date('Ym', time());
        $table = self::$_baseTableName . '_' . $time;
        $baseTable = self::$_baseTableName;

        $exist = Yii::app()->ac->createCommand("SHOW TABLES LIKE '$table'")->queryScalar();
        if ( $exist === false ) {
            $sql = "CREATE TABLE IF NOT EXISTS $table LIKE $baseTable;";
            Yii::app()->ac->createCommand($sql)->execute();
        }

        return ACCOUNT . '.' . $table;
    }

    /**
     * 散列创建表
     * @param type $string
     * @return string
     */
    public static function hashTable($string) {
        $suffix = self::getHash($string);
        $table = self::$_baseTableName . '_' . $suffix;
        $baseTable = self::$_baseTableName;
        $sql = "CREATE TABLE IF NOT EXISTS $table LIKE $baseTable;";
        Yii::app()->ac->createCommand($sql)->execute();
        // 同步结构
        self::tableSyn($baseTable, $table);
        return ACCOUNT . '.' . $table;
    }

    /**
     * 生成散列表字串
     * @param type $string
     * @return string
     */
    public static function getHash($string) {
        $string = md5($string);
        return substr($string, 0, 2);
    }

    /**
     * 合并流水数据
     * @param array $order 订单属性
     * @param array $balance 余额表属性
     * @param array $flow 需要替换的流水属性
     * @return array 流水表数据
     */
    public static function mergeFlowData($order = null, $balance, $flow) {
        return array_merge(array(
            'account_id' => $balance['account_id'],
            'gai_number' => $balance['gai_number'],
            'card_no' => $balance['card_no'],
            'type' => $balance['type'],
            'order_id' => isset($order) ? $order['id'] : 0,
            'order_code' => isset($order) ? $order['code'] : '',
            'date' => date('Y-m-d', time()),
            'create_time' => time(),
            'week' => date('W', time()),
            'week_day' => date('N', time()),
            'hour' => date('G', time()),
            'ip' => Tool::getIP(),
                ), $flow);
    }

    /**
     * 翻译+货币转换
     * @param $content
     * @return string
     */
    public static function formatContent($content) {
        $content = str_replace('￥', '¥', $content); //统一货币符号
        $reStr = preg_replace_callback('/(¥\d+?.\d+?元)|(\d+?.\d+?元)|(¥\d+?.\d+?)/U', function ($matches) {
            if (preg_match('/\d+?.\d+?/U', $matches[0], $priceArr)) {
                return HtmlHelper::formatPrice($priceArr[0]);
            }
            return $matches[0];
        }, $content);
        return Yii::t('accountFlow', $reStr ? $reStr : $content);
    }

    /**
     * 账户明细中的金额显示
     * @param float $credit 贷方发生额
     * @param float $debit 借方发生额
     * @return string
     */
    public static function showPrice($credit, $debit) {
        if ($debit == 0) {
            return HtmlHelper::formatPrice($credit);
        } else {
            return HtmlHelper::formatPrice(-$debit, 'span', array('style' => 'color:red'));
        }
    }

    /**
     * 将月流水表转移到散列表中
     * Enter description here ...
     * 昨天的数据转移，每天凌晨执行
     * @author LC
     */
    public static function moveHashTable() {
        $yesterday = strtotime(date('Y-m-d 00:00:00')) - 1;
        $time = date('Ym', $yesterday);
        $baseTableName = '{{account_flow}}';
        $flowTable = $baseTableName . '_' . $time;
        $sql = "SELECT * FROM $flowTable WHERE create_time<=$yesterday AND moved=0 ORDER BY gai_number LIMIT 5000";
        $dataQuery = Yii::app()->ac->createCommand($sql)->queryAll();

        //将数据按照会员名称进行排列
        $data = array();
        foreach ($dataQuery as $row) {
            $row['remark'] = Tool::magicQuotes($row['remark']);
            $data[$row['gai_number']][] = $row;
        }
        foreach ($data as $key => $row) {
            //创建hash表
            $hashTable = AccountFlow::hashTable($key);
            $insertSql = "INSERT INTO $hashTable VALUES";
            $updateSql = "UPDATE $flowTable SET `moved`=1 WHERE id IN (";
            foreach ($row as $item) {
                $updateSql .= $item['id'] . ',';
                $item['id'] = '';
                $item['moved'] = 1;
                $insertSql .= "('" . implode("','", $item) . "'),";
            }
            $insertSql = substr($insertSql, 0, -1);
            $updateSql = substr($updateSql, 0, -1) . ")";
            $transaction = Yii::app()->ac->beginTransaction();
            try {
                Yii::app()->ac->createCommand($insertSql)->execute();
                Yii::app()->ac->createCommand($updateSql)->execute();
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
    }

    /**
     * 检测之前未转移的流水记录，将之转移到hash表中
     * @author LC
     */
    public static function checkHashTable() {
        $yesterday = strtotime(date('Y-m-d 00:00:00')) - 1;
        $baseTableName = '{{account_flow}}';

        $beginY = 2015;
        $beginM = 1;
        $y = date('Y', $yesterday);
        $m = date('n', $yesterday);
        $m = ($y - $beginY) * 12 + $m;
        while ($beginM <= $m && $beginY <= $y) {
            $curMonth = $beginM % 12;
            $curMonth = ($curMonth == 0) ? 12 : $curMonth . '-';

            $curTableTime = $beginY . sprintf("%02d", $curMonth);
            $flowTable = $baseTableName . '_' . $curTableTime;
            $sql = "SELECT * FROM $flowTable WHERE create_time<=$yesterday AND moved=0 ORDER BY gai_number";

            $dataQuery = Yii::app()->ac->createCommand($sql)->queryAll();
            //将数据按照会员名称进行排列
            $data = array();
            foreach ($dataQuery as $row) {
                $row['remark'] = Tool::magicQuotes($row['remark']);
                $data[$row['gai_number']][] = $row;
            }
            foreach ($data as $key => $row) {
                //创建hash表
                $hashTable = AccountFlow::hashTable($key);
                $insertSql = "INSERT INTO $hashTable VALUES";
                $updateSql = "UPDATE $flowTable SET `moved`=1 WHERE id IN (";
                foreach ($row as $item) {
                    $updateSql .= $item['id'] . ',';
                    $item['id'] = '';
                    $item['moved'] = 1;
                    $insertSql .= "('" . implode("','", $item) . "'),";
                }
                $insertSql = substr($insertSql, 0, -1);
                $updateSql = substr($updateSql, 0, -1) . ")";
                $transaction = Yii::app()->ac->beginTransaction();
                try {
                    Yii::app()->ac->createCommand($insertSql)->execute();
                    Yii::app()->ac->createCommand($updateSql)->execute();
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

            if ($curMonth == 12) {
                $beginY++;
            }
            $beginM++;
        }
    }

    /**
     * 同步表结构
     * @param $source_name
     * @param $target_name
     */
    public static function tableSyn($source_name, $target_name) {
        $table_source = Yii::app()->ac->createCommand("SHOW columns FROM " . $source_name)->queryAll();
        $table_target = Yii::app()->ac->createCommand("SHOW columns FROM " . $target_name)->queryAll();

        foreach ($table_source as $key => $val) {
            $columns_source[$key] = $val['Field'];
        }
        foreach ($table_target as $key => $val) {
            $columns_target[$key] = $val['Field'];
        }
        $diff_field = array_diff($columns_source, $columns_target);
        if (!empty($diff_field))
            foreach ($diff_field as $key => $val) {
                $sql = "ALTER table " . $target_name;
                $sql .= " ADD COLUMN `" . $val . "` " . $table_source[$key]['Type'] . " " . ($table_source[$key]['Null'] == 'YES' ? 'NULL' : 'NOT NULL');
                if ($table_source[$key]['Default'] == null) {
                    $sql .= " DEFAULT NULL ";
                } else {
                    $sql .= " DEFAULT " . $table_source[$key]['Default'];
                }
                $sql .= " AFTER `" . $table_source[$key - 1]['Field'] . "`";
                if ($table_source[$key]['Key'] == 'MUL') {
                    $sql .= ", ADD INDEX (`" . $val . "`) ";
                }
                $sql .= ";";
                Yii::app()->ac->createCommand($sql)->execute();
            }
    }

    /**
     * 与流水固定数据合并
     * @param array $field
     * @return array
     */
    public static function mergeField(Array $field, $time = null) {
        if ($time === null)
            $time = time();
        $publicArr = array(
            'date' => date('Y-m-d', $time),
            'create_time' => $time,
            'week' => date('W', $time),
            'week_day' => date('N', $time),
            'hour' => date('G', $time),
            'ip' => Tool::ip2int(Yii::app()->request->userHostAddress),
        );
        return CMap::mergeArray($publicArr, $field);
    }

    /**
     * 金额退款流水账处理(售货机)
     * @param string $monthTable gw_account_flow 流水表表名
     * @param array $balance 用户余额表
     * @param float $money 金额
     * @param string $code 订单号
     * @param int $orderId 订单id
     * @param string $remark 备注
     * @return bool
     * @throws Exception
     */
    public static function returnAccounts($monthTable, Array $freezingBalanceRes, $money, $code, $orderId, $remark = '退款金额') {
        if ($freezingBalanceRes['today_amount'] < $money) {
            return false;
        }
        $time = time();
        $balance = AccountBalance::findRecord(array('account_id' => $freezingBalanceRes['account_id'], 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => $freezingBalanceRes['gai_number']));

        //借方(消费会员)
        $debit = array(
            'account_id' => $balance['account_id'],
            'gai_number' => $balance['gai_number'],
            'card_no' => $balance['card_no'],
            'type' => $balance['type'],
            'debit_amount' => '-' . $money,
            'operate_type' => AccountFlow::OPERATE_TYPE_VENDING_MACHINE_REFUND,
            'order_id' => $orderId,
            'order_code' => $code,
            'remark' => $remark,
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_VENDING_MACHINE_REFUND,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_RETURN,
            'week' => date('W', $time),
            'week_day' => date('w', $time),
            'ip' => Tool::getIP(),
            'hour' => date('G', $time),
        );

        //贷方(冻结会员)
        $credit = array(
            'account_id' => $freezingBalanceRes['account_id'],
            'gai_number' => $freezingBalanceRes['gai_number'],
            'card_no' => $freezingBalanceRes['card_no'],
            'type' => $freezingBalanceRes['type'],
            'credit_amount' => '-' . $money,
            'operate_type' => AccountFlow::OPERATE_TYPE_VENDING_MACHINE_REFUND,
            'order_id' => $orderId,
            'order_code' => $code,
            'remark' => $remark,
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_VENDING_MACHINE_REFUND_UNFREEZE,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_RETURN,
            'week' => date('W', $time),
            'week_day' => date('w', $time),
            'ip' => Tool::getIP(),
            'hour' => date('G', $time),
        );
        $db = Yii::app()->db;
        $accountBalanceTable = AccountBalance::tableName();
        //转移金额
        $sql = 'update ' . ACCOUNT . '.' . $accountBalanceTable . ' set today_amount=today_amount+' . $money . ',last_update_time = ' . $time . ' where id=' . $balance['id'];
        $sql .= ';update ' . ACCOUNT . '.' . $accountBalanceTable . ' set today_amount=today_amount-' . $money . ',last_update_time = ' . $time . ' where id=' . $freezingBalanceRes['id'];
        $db->createCommand($sql)->execute();
        // 借贷流水1.按月
        if ($db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit)) &&
                $db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit)))
            return true;
        else
            return false;
    }

    /**
     * 金额冻结流水账处理
     * @param string $monthTable gw_account_flow 流水表表名
     * @param array $balance 用户余额表
     * @param float $money 金额
     * @param string $code 订单号
     * @param int $orderId 订单id
     * @param string $remark 备注
     * @return bool
     * @throws Exception
     */
    public static function freezingAccounts($monthTable, Array $balance, $money, $code, $orderId, $remark = '金额冻结') {
        if ($balance['today_amount'] < $money) {
            return false;
        }
        $time = time();
        $freezingBalanceRes = AccountBalance::findRecord(array('account_id' => $balance['account_id'], 'type' => AccountBalance::TYPE_FREEZE, 'gai_number' => $balance['gai_number']));

        //借方(消费会员)
        $debit = array(
            'account_id' => $balance['account_id'],
            'gai_number' => $balance['gai_number'],
            'card_no' => $balance['card_no'],
            'type' => $balance['type'],
            'debit_amount' => $money,
            'operate_type' => AccountFlow::OPERATE_TYPE_VENDING_MACHINE,
            'order_id' => $orderId,
            'order_code' => $code,
            'remark' => $remark,
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_VENDING_MACHINE,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
            'week' => date('W', $time),
            'week_day' => date('w', $time),
            'ip' => Tool::getIP(),
            'hour' => date('G', $time),
        );

        //贷方(冻结会员)
        $credit = array(
            'account_id' => $freezingBalanceRes['account_id'],
            'gai_number' => $freezingBalanceRes['gai_number'],
            'card_no' => $freezingBalanceRes['card_no'],
            'type' => $freezingBalanceRes['type'],
            'credit_amount' => $money,
            'operate_type' => AccountFlow::OPERATE_TYPE_VENDING_MACHINE,
            'order_id' => $orderId,
            'order_code' => $code,
            'remark' => $remark,
            'node' => AccountFlow::BUSINESS_NODE_OFFLINE_VENDING_MACHINE_FREEZE,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
            'week' => date('W', $time),
            'week_day' => date('w', $time),
            'ip' => Tool::getIP(),
            'hour' => date('G', $time),
        );
        $db = Yii::app()->db;
        $accountBalanceTable = AccountBalance::tableName();
        //转移金额
        $sql = 'update ' . ACCOUNT . '.' . $accountBalanceTable . ' set today_amount=today_amount-' . $money . ',last_update_time = ' . $time . ' where id=' . $balance['id'];
        $sql .= ';update ' . ACCOUNT . '.' . $accountBalanceTable . ' set today_amount=today_amount+' . $money . ',last_update_time = ' . $time . ' where id=' . $freezingBalanceRes['id'];
        $db->createCommand($sql)->execute();
        // 借贷流水1.按月
        if ($db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit)) &&
                $db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit)))
            return true;
        else
            return false;
    }

    public static function CashPooling($balanceRes, $member) {
        //创建订单编号 作为标识
        $order_code = 'ZJC'.Tool::buildOrderNo();
        //代理余额
        $agent = AccountBalance::findRecord(
                        array(
                            'account_id' => $member['id'],
                            'type' => AccountBalance::TYPE_AGENT,
                            'gai_number' => $member['gai_number']
                        )
        );
        $money = $balanceRes['today_amount'];

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $account_flow_table = AccountFlow::monthTable();
            $timeStamp = time();
            $result = AccountBalance::calculate(array('today_amount' => -$money), $balanceRes['id']);
            if (!$result) {
                throw new Exception("扣除资金池金额失败");
            }
            $debit = array(
                'account_id' => $balanceRes['account_id'],
                'gai_number' => $balanceRes['gai_number'],
                'type' => $balanceRes['type'],
                'current_balance' => $balanceRes['today_amount'],
                'debit_amount' => $money,
                'operate_type' => AccountFlow::OPERATE_TYPE_CASH_POOLING,
                'order_id' => '',
                'order_code' =>$order_code,
                'remark' => '资金池金额转入代理账户',
                'node' => AccountFlow::BUSINESS_NODE_CASH_POOLING_OUT,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
                'flag' => 0,
                'date' => date('Y-m-d', $timeStamp),
                'create_time' => $timeStamp,
                'week' => date('W', $timeStamp),
                'week_day' => date('N', $timeStamp),
                'hour' => date('G', $timeStamp),
            );
            Yii::app()->db->createCommand()->insert($account_flow_table, $debit);

            $member_result = AccountBalance::calculate(array('today_amount' => $money), $agent['id']);
            if (!$member_result) {
                throw new Exception("增加代理金额失败");
            }
            $credit = array(
                'account_id' => $agent['account_id'],
                'gai_number' => $agent['gai_number'],
                'type' => $agent['type'],
                'current_balance' => $agent['today_amount'],
                'credit_amount' => $money,
                'operate_type' => AccountFlow::OPERATE_TYPE_CASH_POOLING,
                'order_id' => '',
                'order_code' =>$order_code,
                'remark' => '资金池金额转入代理账户',
                'node' => AccountFlow::BUSINESS_NODE_CASH_POOLING_INPUT,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH,
                'flag' => 0,
                'date' => date('Y-m-d', $timeStamp),
                'create_time' => $timeStamp,
                'week' => date('W', $timeStamp),
                'week_day' => date('N', $timeStamp),
                'hour' => date('G', $timeStamp),
            );
            Yii::app()->db->createCommand()->insert($account_flow_table, $credit);
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            throw new Exception($e . '(资金池金额转入代理账户失败)');
            return false;
        }
    }

}
