<?php

/**
 * 线上订单各个角色分配金额计算类
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class OnlineCalculate
{

    // 保留小数位
    static $median = 2;

    /**
     * *******************************************************************
     *  bcmul(1,9,2) 乘法，1 * 9 取两位小数
     *  bcdiv(1,2,2) 除法，1 / 2 取两位小数
     *  bcsub(5,2,2) 减法，5 - 2 取两位小数
     *  bcadd(2,3,2) 加法，2 + 3 取两位小数
     * *******************************************************************
     */

    /**
     * 订单金额算出
     * @param array $order 订单
     * @param array $orderGoods 订单商品信息
     * @return array 订单总分配金额、盖网首次收益金额、剩余待分配金额
     */
    public static function orderIncome($order, $orderGoods)
    {
        switch ($order['source_type']) {
            //如果订单是红包类型就启用红包类型的算法
            case Order::SOURCE_TYPE_HB:
                return self::orderIncomeByRed($order, $orderGoods);
                break;
            default:
                return self::orderIncomeByDefault($order, $orderGoods);
        }
    }

    /**
     * 默认计算订单分配金额的方法
     * @param $order
     * @param $orderGoods
     * @return array
     * @author binbin.liao
     */
    public static function orderIncomeByDefault($order, $orderGoods)
    {
        $gaiBaseIncome = 0; //盖网首次收入
        $gaiPrice = 0; //总供货价
        foreach ($orderGoods as $og) {
            // 单商品利润  = 销售价 - 供货价
            $balance = bcsub($og['original_price'], $og['gai_price'], self::$median);
            //盖网首次收益 += 单商品利润 * 数量 * 收益比
            $gaiBaseIncome += bcmul(bcmul($balance, $og['quantity'], self::$median), bcdiv($og['gai_income'], 100, self::$median), self::$median);
            $gaiPrice += $og['gai_price'] * $og['quantity'];
        }
        // 总分配金额 = 订单总价格 - 运费 - 总供货价
        $totalAssign = bcsub(bcsub($order['original_price'], $order['freight'], self::$median), $gaiPrice, self::$median);

        // 剩余待分配金额 = 总分配金额 - 盖网收益
        $surplusAssign = bcsub($totalAssign, $gaiBaseIncome, self::$median);
        //剩余待分配金额金额不能小于0
        if($surplusAssign<0){
            throw new Exception('surplusAssign error');
        }
        return array(
            'totalAssign' => $totalAssign, //总分配金额
            'gaiBaseIncome' => $gaiBaseIncome, //盖网首次收益金额
            'surplusAssign' => $surplusAssign, //可分配金额
            'gaiPrice' => $gaiPrice, //供货价
            'freight' => $order['freight'], //运费
        );
    }

    /**
     * 使用红包支付的订单,分配金额计算
     * @param $order
     * @param $orderGoods
     * @return array
     * @author binbin.liao
     */
    public static function orderIncomeByRed($order, $orderGoods)
    {
        $totalAssign = 0;
        $gaiPrice = 0;
        $balance = 0;//单品利润
        $gaiBaseIncome = 0;
        foreach ($orderGoods as $og) {
            //利润 = (商家售价 - 供货价) * 销售数量
            $balance = bcmul(bcsub($og['original_price'], $og['gai_price'], self::$median), $og['quantity'], self::$median);
            //盖网首次收益
            $gaiBaseIncome += bcmul($balance, bcdiv($og['gai_income'], 100, self::$median), self::$median);
            //供货价
            $gaiPrice += $og['gai_price'] * $og['quantity'];
            //总分配金额
            $totalAssign += $balance;
        }

        // 剩余待分配金额 = 总分配金额 - 盖网首次收益
        $surplusAssign = bcsub($totalAssign, $gaiBaseIncome, self::$median);
        return array(
            'totalAssign' => $totalAssign * 1, //总分配金额
            'gaiBaseIncome' => $gaiBaseIncome * 1, //盖网首次收益金额
            'surplusAssign' => $surplusAssign * 1, //可分配金额
            'gaiPrice' => $gaiPrice * 1, //供货价
            'freight' => $order['freight'], //运费
        );
    }

    /**
     * 创建订单时,计算对应订单分配的金额,这样就不必在会员中心那里再计算了
     * @param array $order 订单数据
     * @param array $orderGoods 订单商品数据
     * @param $memberId 会员id
     * @return mixed
     * @author binbin.liao
     */
    public static function orderByFront(array $order = array('real_price' => 0, 'pay_price' => 0, 'freight' => 0, 'source_type' => ''), array $orderGoods, $memberId)
    {
        $ratio = Order::getOldIssueRatio();//分配比率
        //查询会员类型
        $memberType = MemberType::fileCache();
        $memberData = Yii::app()->db->createCommand()->select('type_id')->from('{{member}}')->where('id=:id', array(':id' => $memberId))->queryRow();
        $newOrderGoods = array();
        foreach ($orderGoods as $k => $v) {
            $newOrderGoods[$k] = array(
                'unit_price' => $v['price'],
                'quantity' => $v['quantity'],
                'gai_income' => $v['gai_income'],
                'ratio' => $v['ratio'],
                'gai_price' => self::calGaiPrice($v['price'], $v['g_category_id']),
            );
        }
        $assign = self::orderIncome($order, $newOrderGoods);
        $memberAssign = self::memberAssign($assign['surplusAssign'], $memberData, $ratio['ratio'], $memberType);
        return Common::convertSingle($memberAssign['memberIncome'], $memberData['type_id']);
    }

    /**
     * 消费者应分配金额算出
     * @param float $price 订单除去盖网收益后的剩余待分配金额
     * @param array $member 消费者
     * @param array $ratio 分配比率
     * @param array $memberType 会员类型
     * @return array 消费者收益金额、盖网收益金额
     */
    public static function memberAssign($price, $member, $ratio, $memberType)
    {
        $originalIncome = bcmul(($ratio['member'] / 100), $price, self::$median);
        // 作为正式会员，全部分配完
        if ($member['type_id'] == $memberType['officialType'])
            return array(
                'memberIncome' => $originalIncome,
                'gaiIncome' => 0
            );
        // 作为消费会员，分配不完，剩余进盖网
        $consumerIncome = bcmul(bcdiv($originalIncome, $memberType['official'], self::$median), $memberType['default'], self::$median);
        return array(
            'memberIncome' => $consumerIncome,
            'gaiIncome' => bcsub($originalIncome, $consumerIncome, self::$median)
        );
    }

    /**
     * 机动账户应分配金额算出
     * @param float $price 订单除去盖网收益后的剩余待分配金额
     * @param array $ratio 分配比率
     * @return array 机动收益金额
     */
    public static function moveAssign($price, $ratio)
    {
        return array(
            'moveIncome' => bcmul(($ratio['move'] / 100), $price, self::$median)
        );
    }

    /**
     * 代理应分配金额算出
     * @param float $price 订单除去盖网收益后的剩余待分配金额
     * @param array $store 商家
     * @param array $ratio 代理分配比率
     * @param array $agentRatio 个人代理分配比率
     * @return array 市代分配金额，省个人代理分配金额，市个人代理分配金额，区个人代理分配金额
     */
    public static function agentAssign($price, $ratio, $agentRatio, $provinceMember, $cityMember, $districtMember)
    {
        $originalIncome = bcmul(($ratio['agent'] / 100), $price, self::$median);
        $districtRatio = $districtMember['id'] ? $agentRatio['district'] : 0;
        $cityRatio = $cityMember['id'] ? $agentRatio['city'] - $districtRatio : 0;
        $provinceRatio = $provinceMember['id'] ? $agentRatio['province'] - $cityRatio - $districtRatio : 0;

        $districtPrice = bcmul($originalIncome, ($districtRatio / 100), self::$median); //区代理分配的金额
        $cityPrice = bcmul($originalIncome, ($cityRatio / 100), self::$median); //市代理分配的金额
        $provincePrice = bcmul($originalIncome, $provinceRatio / 100, self::$median); //省代理分配的金额

        return array(
            'agentIncome' => bcsub($originalIncome, bcadd($districtPrice, bcadd($cityPrice, $provincePrice, self::$median), self::$median), self::$median),
            'agentOriginal' => $originalIncome,
            'provinceIncome' => $provincePrice,
            'cityIncome' => $cityPrice,
            'districtIncome' => $districtPrice,
            'ratio' => array(
                'province' => $provinceRatio,
                'city' => $cityRatio,
                'district' => $districtRatio
            )
        );
    }

    /**
     * 消费者推荐应分配金额算出
     * @param float $price 订单除去盖网收益后的剩余待分配金额
     * @param array $ratio 分配比率
     * @param array $memberType 会员类型
     * @param array $recommender 推荐者会员
     * @return array 消费者推荐人收益、盖网收益
     */
    public static function memberReferAssign($price, $ratio, $memberType, $recommender = null)
    {
        $original = bcmul(($ratio['memberRefer'] / 100), $price, self::$median);
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
        $memberRefer = bcmul(bcdiv($original, $memberType['official'], self::$median), $memberType['default'], self::$median);
        return array(
            'memberReferIncome' => $memberRefer,
            'gaiIncome' => bcsub($original, $memberRefer, self::$median)
        );
    }

    /**
     * 盖网账户应分配金额
     * @param float $price 订单除去盖网收益后的剩余待分配金额
     * @param array $ratio 分配比率
     * @return array 盖网收益金额
     */
    public static function gaiAssign($price, $ratio)
    {
        return array(
            'gaiIncome' => bcmul(($ratio['gai'] / 100), $price, self::$median)
        );
    }

    /**
     * 商家推荐应分配金额算出
     * @param float $price 订单除去盖网收益后的剩余待分配金额
     * @param array $ratio 分配比率
     * @param array $memberType 会员类型
     * @param array $recommender 商家推荐者
     * @return array 商家推荐人收益、盖网收益
     */
    public static function businessReferAssign($price, $ratio, $memberType, $recommender = null)
    {
        $originalIncome = bcmul(($ratio['businessRefer'] / 100), $price, self::$median);
        // 无商家推荐者，全部进盖网
        if (!$recommender) {
            return array(
                'businessReferIncome' => 0,
                'gaiIncome' => $originalIncome,
            );
        }
        // 有商家推荐者
        if ($recommender['type_id']) {
            return array(
                'businessReferIncome' => $originalIncome,
                'gaiIncome' => 0
            );
        }
//        // 有商家推荐者，如果是消费会员，分配不完，剩余进盖网
//        $memberReferIncome = bcmul(bcdiv($originalIncome, $memberType['official'], self::$median), $memberType['default'], self::$median);
//        return array(
//            'businessReferIncome' => $memberReferIncome,
//            'gaiIncome' => bcsub($originalIncome, $memberReferIncome, self::$median)
//        );
    }

    /**
     * 商城公共分配
     * @param float $price
     * @param array $ratio
     * @return array
     */
    public static function mall($price, $ratio)
    {
        return array(
            'mallIncome' => bcmul(($ratio['mallCommon'] / 100), $price, self::$median)
        );
    }

    /**
     * 分配完各角色后，待分配总金额中最终还剩余的金额算出
     * @param float $totalAssign 总分配
     * @param array $member 消费者
     * @param array $move 机动
     * @param array $gai 盖网公共
     * @param array $businessRefer 商家推荐
     * @param array $memberRefer 消费者推荐
     * @param array $agent 代理
     * @return float 剩余金额
     */
    public static function surplusPrice($totalAssign, $member, $move, $gai, $businessRefer, $memberRefer, $agent)
    {
//        unset($agent['agentOriginal']);
        $sum = bcadd(bcadd(bcadd(bcadd(bcadd(array_sum($member), array_sum($move), self::$median), array_sum($businessRefer), self::$median), array_sum($memberRefer), self::$median), array_sum($agent), self::$median), array_sum($gai), self::$median);
        return bcsub($totalAssign, $sum, self::$median);
    }

    /**
     * 盖网公共账户最终的收入金额算出
     * @param array $gaiResult 盖网公共
     * @param array $memberResult 消费者
     * @param array $businessReferResult 商家推荐
     * @param array $orderResult 订单
     * @return array 最终金额
     */
    public static function gaiFinalIncome($gaiResult, $memberResult, $memberReferResult, $businessReferResult, $orderResult, $surplusPrice)
    {
        $var1 = bcadd($gaiResult['gaiIncome'], $memberResult['gaiIncome'], self::$median);
        $var2 = bcadd($var1, $businessReferResult['gaiIncome'], self::$median);
        $var3 = bcadd($var2, $orderResult['gaiBaseIncome'], self::$median);
        return bcadd(bcadd($var3, $surplusPrice, self::$median), $memberReferResult['gaiIncome'], self::$median);
    }

    /**
     * 计算商品的供货价
     * @param float $unitPrice 商品销售价
     * @param $categoryId 商品分类id
     * @return float
     * @author binbin.liao
     */
    public static function calGaiPrice($unitPrice, $categoryId)
    {
        //服务费率
        $fee = Category::getCategoryServiceFeeRate($categoryId);
        $fee = bcdiv($fee, 100, 2);
        //计算供货价 = 销售价 - (销售价*服务费率)
        $gai_price = bcsub($unitPrice, bcmul($unitPrice, $fee, 2), 2);
        return $gai_price * 1;
    }

}
