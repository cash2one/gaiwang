<?php

/**
 * 酒店订单各个角色分配金额计算类
 * @author jianlin_lin <hayeslam@163.com>
 */
class HotelCalculate {

    /**
     * 运算数值范围
     */
    const SCALE = 2;

    /**
     *  bcmul(1,9,self::SCALE) 乘法，1 * 9 取两位小数
     *  bcdiv(1,2,self::SCALE) 除法，1 / 2 取两位小数
     *  bcsub(5,2,self::SCALE) 减法，5 - 2 取两位小数
     *  bcadd(2,3,self::SCALE) 加法，2 + 3 取两位小数
     */

    /**
     * 订单金额算出
     * @param array $order 订单
     * @return array 订单总分配金额、盖网首次收益金额、剩余待分配金额
     */
    public static function orderIncome($order) {
        $orderPrice = self::price($order);
        // 无抽奖，总分配金额
        $totalAssign = $orderPrice['difference']; // 销售价总价与供货总价的差额
        if ($order['is_lottery'] == HotelOrder::IS_LOTTERY_YES) {
            $bonus = self::obtainBonus($order); // 奖金
            // 参与抽奖，总分配金额计算公式： (销售价总价 + 抽奖支付金额) - (供货总价 + 活动奖金)
            $formula1 = bcadd($orderPrice['total'], $order['lottery_price'], self::SCALE);
            $formula2 = bcadd($orderPrice['gai'], $bonus, self::SCALE);
            $totalAssign = bcsub($formula1, $formula2, self::SCALE);
        }
        // 商旅首次收益金额
        $businessTravelIncome = bcmul($totalAssign, ($order['gai_income'] / 100), self::SCALE);
        // 剩余待分配金额
        $surplusAssign = bcsub($totalAssign, $businessTravelIncome, self::SCALE);

        return array(
            'totalAssign' => $totalAssign,
            'businessTravelIncome' => $businessTravelIncome,
            'surplusAssign' => $surplusAssign,
            'gaiPrice' => $orderPrice['gai'],
        );
    }

    public static function distribution($order,$businessTravelIncome ,$memberResult, $memberReferResult, $ratio) {
        $orderPrice = self::price($order);
        $lotteryPrice = $order['is_lottery'] == HotelOrder::IS_LOTTERY_YES ? $order['lottery_price'] : 0;
        $expend = bcadd($orderPrice['total'], $lotteryPrice, self::SCALE); // 订单总额 + 支付抽奖金额
        $bonus = self::obtainBonus($order); // 奖金
        // 分配金额
        $allotmentMoney = bcadd($orderPrice['gai'], ($memberResult['memberIncome'] + $memberReferResult['memberReferIncome'] + $businessTravelIncome['businessTravelIncome']), self::SCALE);
        $earnings = bcsub($expend ,bcadd($allotmentMoney, $bonus, self::SCALE), self::SCALE);
        $gaiRatio = (100 - $ratio['member'] - $ratio['memberRefer'] - $businessTravelIncome['businessTravelRatio']) / 100;
        $memberRatio = $ratio['member'] / 100;
        $recommenderRatio = $ratio['memberRefer'] / 100;

        return array(
            'expend' => $expend,
            'costing' => $orderPrice['gai'],
            'gaiEarnings' => $earnings,
            'gaiRatio' => $gaiRatio,
            'memberEarnings' => $memberResult['memberIncome'],
            'memberRatio' => $memberRatio,
            'recommenderEarnings' => $memberReferResult['memberReferIncome'],
            'recommenderRatio' => $recommenderRatio,
            'businessTravelIncome' => $businessTravelIncome['businessTravelIncome'],
            'businessTravelRatio' => $ratio['business'],
        );
    }

    /**
     * 商旅收益
     * @param $price
     * @param $ratio
     * @return array
     */
    public static function businessTravelAssign($price,$ratio,$orderResult){
        $businessTravelIncome = bcmul($price,($ratio['business'] / 100),self::SCALE);
        $businessTravelIncome  = bcadd($businessTravelIncome,$orderResult['businessTravelIncome'],self::SCALE);
        return array(
            'businessTravelIncome' => $businessTravelIncome,
            'businessTravelRatio' => $ratio['business'],
        );
    }

    /**
     * 消费者应分配金额算出
     * @param float $price 订单除去盖网收益后的剩余待分配金额
     * @param array $member 消费者
     * @param array $ratio 分配比率
     * @param array $memberType 会员类型
     * @return array 消费者收益金额、盖网收益金额
     */
    public static function memberAssign($price, $member, $ratio, $memberType) {
        $originalIncome = bcmul($price, ($ratio['member'] / 100), self::SCALE);
        // 作为正式会员，全部分配完
        if ($member['type_id'] == $memberType['officialType'])
            return array(
                'memberIncome' => $originalIncome,
                'gaiIncome' => 0
            );
        // 作为消费会员，分配不完，剩余进盖网
        $consumerIncome = bcmul(bcdiv($originalIncome, $memberType['official'], self::SCALE), $memberType['default'], self::SCALE);
        return array(
            'memberIncome' => $consumerIncome,
            'gaiIncome' => bcsub($originalIncome, $consumerIncome, self::SCALE)
        );
    }

    /**
     * 消费者推荐应分配金额算出
     * @param float $price 订单除去盖网收益后的剩余待分配金额
     * @param mixed $recommender 推荐者会员
     * @param array $ratio 分配比率
     * @param array $memberType 会员类型
     * @return array 消费者推荐人收益、盖网收益
     */
    public static function memberReferAssign($price, $recommender = null, $ratio, $memberType) {
        $original = bcmul($price, ($ratio['memberRefer'] / 100), self::SCALE);
        // 没有推荐者，全部进盖网
        if (!$recommender)
            return array(
                'memberReferIncome' => 0,
                'gaiIncome' => $original,
            );
        // 有推荐者，如果推荐者是正式会员，全部分配完
        if ($recommender['type_id'] == $memberType['officialType'])
            return array(
                'memberReferIncome' => $original,
                'gaiIncome' => 0
            );
        // 有推荐者，如果推荐者是消费会员，分配不完，剩余进盖网
        $memberRefer = bcmul(bcdiv($original, $memberType['official'], self::SCALE), $memberType['default'], self::SCALE);
        return array(
            'memberReferIncome' => $memberRefer,
            'gaiIncome' => bcsub($original, $memberRefer, self::SCALE)
        );
    }

    /**
     * 酒店公共角色应分配金额算出
     * @param float $price 订单除去盖网收益后的剩余待分配金额
     * @param array $ratio 分配比率
     * @return array 酒店公共角色收益金额
     */
    public static function hotelCommonAssign($price, $ratio) {
        // 防止旧数据余留下来的分配计算不吻合
        $ratio['hotelCommon'] = isset($ratio['hotelCommon']) ? $ratio['hotelCommon'] : $ratio['agent'];
        return array(
            'hotelCommonIncome' => bcmul(($ratio['hotelCommon'] / 100), $price, self::SCALE)
        );
    }

    /**
     * 机动账户应分配金额算出
     * @param float $price 订单除去盖网收益后的剩余待分配金额
     * @param array $ratio 分配比率
     * @return array 机动收益金额
     */
    public static function moveAssign($price, $ratio) {
        return array(
            'moveIncome' => bcmul(($ratio['move'] / 100), $price, self::SCALE)
        );
    }

    /**
     * 盖网账户应分配金额
     * @param float $price 订单除去盖网收益后的剩余待分配金额
     * @param array $ratio 分配比率
     * @return array 盖网收益金额
     */
    public static function gaiAssign($price, $ratio) {
        return array(
            'gaiIncome' => bcmul(($ratio['gai'] / 100), $price, self::SCALE)
        );
    }

    /**
     * 商家推荐应分配金额算出（酒店中不存在商家，盖网相当于商家，该角色分配金额归属盖网）
     * @param float $price 订单除去盖网收益后的剩余待分配金额
     * @param array $ratio 分配比率
     * @return array 商家推荐人收益、盖网收益
     */
    public static function businessReferAssign($price, $ratio) {
        return array(
            'businessReferIncome' => 0,
            'gaiIncome' => bcmul(($ratio['businessRefer'] / 100), $price, self::SCALE)
        );
    }

    /**
     * 分配完各角色后，待分配总金额中最终还剩余的金额算出
     * @param float $totalAssign 总分配
     * @param array $member 消费者
     * @param array $memberRefer 消费者推荐
     * @param array $businessRefer 商家推荐
     * @param array $hotelCommon 酒店公共
     * @param array $move 机动
     * @param array $gai 盖网公共
     * @return float 剩余金额
     */
    public static function surplusPrice($totalAssign, $member, $memberRefer, $businessRefer, $hotelCommon, $move, $gai) {
        $var1 = bcadd(array_sum($member), array_sum($memberRefer), self::SCALE);
        $var2 = bcadd($var1, array_sum($businessRefer), self::SCALE);
        $var3 = bcadd($var2, array_sum($hotelCommon), self::SCALE);
        $var4 = bcadd($var3, array_sum($move), self::SCALE);
        $sum = bcadd($var4, array_sum($gai), self::SCALE);
        return bcsub($totalAssign, $sum, self::SCALE);
    }

    /**
     * 盖网公共账户最终的收入金额算出
     * @param array $gaiResult 盖网公共
     * @param array $memberResult 消费者
     * @param array $memberReferResult 消费者推荐会员
     * @param array $businessReferResult 商家推荐
     * @param array $orderResult 订单
     * @param float $surplusPrice 各角色分配后剩余金额
     * @return float 最终金额
     */
    public static function gaiFinalIncome($gaiResult, $memberResult, $memberReferResult, $businessReferResult, $orderResult, $surplusPrice) {
        $var1 = bcadd($gaiResult['gaiIncome'], $memberResult['gaiIncome'], self::SCALE);
        $var2 = bcadd($var1, $businessReferResult['gaiIncome'], self::SCALE);
        $var3 = bcadd($var2, $orderResult['gaiBaseIncome'], self::SCALE);
        return bcadd(bcadd($var3, $surplusPrice, self::SCALE), $memberReferResult['gaiIncome'], self::SCALE);
    }

    /**
     * 订单价格计算
     * @param array $order 酒店订单记录属性
     * @return array
     * @author jianlin.lin
     */
    public static function price($order) {
        $quantity = self::getQuantity($order);
        $price['total'] = $order['unit_price'] * $quantity;
        $price['gai'] = $order['unit_gai_price'] * $quantity;
        $price['difference'] = $price['total'] - $price['gai'];
        return $price;
    }

    /**
     * 酒店订单获得奖金
     * @param array $order 酒店订单属性
     * @return float
     */
    public static function obtainBonus($order) {
        $bonus = sprintf("%.2f", 0);
        if ($order['is_lottery'] == HotelOrder::IS_LOTTERY_YES) {
            // 奖金公式：(客房单价 - (实际供货价 * 供货价系数)) + (抽奖支付金额 * 奖金比例)
            $formula1 = bcsub($order['unit_price'], bcmul($order['unit_gai_price'], $order['price_radio'], self::SCALE), self::SCALE);
            $formula2 = bcmul($order['lottery_price'], $order['lottery_radio'], self::SCALE);
            $res = bcadd($formula1, $formula2, self::SCALE);
            $bonus = $res < 0 ? 0.00 : $res; // 如果结果出现负数，则返回 0.00
        }
        return $bonus;
    }

    /**
     * 计算入住天数
     * @param int $leave 离开时间
     * @param int $settled 入住时间
     * @return int
     */
    public static function liveDays($leave, $settled) {
        $days = ($leave - $settled) / (60 * 60 * 24);
        return abs($days);
    }

    /**
     * 获取酒店订单的入住天数与房间数的积
     * @param $order    酒店订单属性
     * @return int
     */
    public static function getQuantity($order) {
        return $order['rooms'] * self::liveDays($order['leave_time'], $order['settled_time']);
    }

    /**
     * 差额
     * @param array $order      新订单数据
     * @param array $rawOrder   原订单数据
     * @return array
     * @author jianlin.lin
     */
    public static function difference($order, $rawOrder) {
        $quantity = self::getQuantity($order);
        $arr = array('room_chae' => 0, 'total_chae' => 0, 'return_chae' => 0, 'total_price' => bcmul($order['unit_price'], $quantity, self::SCALE));
        $totalChae = $rawOrder['total_price'] - $arr['total_price'];
        if ($totalChae > 0 && $quantity) {
            $arr['room_chae'] = abs($rawOrder['unit_price'] - $order['unit_price']);
            $arr['total_chae'] = $arr['return_chae'] = $totalChae;
        }
        return $arr;
    }

}
