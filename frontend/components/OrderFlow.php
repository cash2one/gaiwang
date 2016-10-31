<?php

/**
 * 处理订单流的一些方法.
 * @author binbin.liao <277250538@qq.com>
 */
class OrderFlow
{

    /**
     * 生成订单
     * @param array $cartInfo 购物车信息
     * @param array $address 收货地址
     * @param array $info
     * @param bool $doTransaction
     * @return array
     * @throws CDbException
     * @throws Exception
     */
    public function createOrder(
        Array $cartInfo,
        Array $address,
        Array $info = array('freight_array' => array(),'storeFreight'=>array(), 'freight' => array(), 'message' => '', 'useRedMoneyInfo' => array(),'jfxjGoods'=>false),
        $doTransaction = true)
    {
        if (!$doTransaction) return $this->_createOrder($cartInfo, $address, $info);
        $goodsIds = $this->checkCart($cartInfo['cartInfo']);
        $tran = Yii::app()->db->beginTransaction();
        $result = false;
        try {

            //减少库存
            $res = $this->subStock($goodsIds);
            if (!$res) throw new Exception(Yii::t('orderFlow', '减库存失败，请重新确认或下单!'));
            if(!empty($goodsIds)){
                foreach($goodsIds as $v){
                   ActivityData::delGoodsCache($v['goods_id']);//删除商品页面缓存
                   ActivityData::deleteActivityGoodsStock($v['goods_id']);
                } 
            }
            
            //创建订单
            $orders = $this->_createOrder($cartInfo, $address, $info);
            if (!$orders) throw new Exception(Yii::t('orderFlow', '生成订单数据失败'));

            $tran->commit();
            $result = $orders;
        } catch (Exception $e) {
            $tran->rollback();
        }
        return $result;
    }

    /**
     * 检查购物车商品有效性
     * @param array $cartInfo
     * @return array
     * @throws Exception
     */
    public function checkCart(Array $cartInfo)
    {
        $goodsStock = array(); //订单商品数量
        foreach ($cartInfo as $k => $v) {
            foreach ($v['goods'] as $k2 => $v2) {
                if ($v2['status'] != Goods::STATUS_PASS) throw new Exception('购物车已有商品被下架');
                //if($v2['price']<=0) throw new CHttpException(503,' 怎么会有价格是'.$v['price'].'的商品呢？');
                if ($v2['quantity'] > $v2['stock']) throw new CHttpException(503, Yii::t('orderFlow', '购物车中有商品缺货，请重新确认或下单!'));
                //if ($v2['gai_price'] >= $v2['price']) throw new CHttpException(503,'gai_price error');
                $goodsStock[] = array(
                    'goods_id' => $v2['goods_id'],
                    'spec_id' => $v2['spec_id'],
                    'quantity' => $v2['quantity'],
                );
            }
        }
        return $goodsStock;
    }

    /**
     * 减少库存操作
     * @param array $goodsIds
     * @return int
     * @throws CDbException
     */
    public function subStock(Array $goodsIds)
    {
        $sql = '';
        foreach ($goodsIds as $v) {
            $sql .= "UPDATE gw_goods SET stock=stock-{$v['quantity']} WHERE (stock-{$v['quantity']}) >=0 AND id={$v['goods_id']};";
            $sql .= "UPDATE gw_goods_spec SET stock=stock-{$v['quantity']} WHERE (stock-{$v['quantity']}) >=0 AND id={$v['spec_id']};";
        }
        return Yii::app()->db->createCommand($sql)->execute();
    }

    /**
     * 秒杀订单创建
     * @param $cartInfo
     * @param $address
     * @param $info
     * @author binbin.liao
     */
    public function seckillOrder($cartInfo, $address, $info)
    {
        $goodsIds = $this->checkCart($cartInfo['cartInfo']);
        $tran = Yii::app()->db->beginTransaction();
        try {
            //减少库存
            $res = $this->subStock($goodsIds);
            if (!$res) throw new Exception(Yii::t('orderFlow', '减库存失败，请重新确认或下单!'));
            foreach ($cartInfo['cartInfo'] as $k => $v) {
                /**
                 * 插入订单主表
                 */
                //订单总运费
                $orderFreight = $this->_computeOrderFreight($v, $info['freight_array'], $info['freight']);
                //订单总价格
                $allPrice = array_sum($v['storeAllPrice']) + $orderFreight;
                //原始订单总价格
                $originalPrice = array_sum($v['originalPrice']) + $orderFreight;
                //会员实际支付订单总价格
                $payPrice = $allPrice;
                $orderData = array(
                    'code' => Tool::buildOrderNo(),
                    'member_id' => Yii::app()->user->id,
                    'consignee' => $address['real_name'],
                    'address' => implode(' ', array($address['province_name'], $address['city_name'], $address['district_name'], $address['street'])),
                    'mobile' => $address['mobile'],
                    'zip_code' => $address['zip_code'],
                    'status' => Order::STATUS_NEW,
                    'delivery_status' => Order::DELIVERY_STATUS_NOT,
                    'pay_status' => Order::PAY_STATUS_NO,
                    'pay_price' => $payPrice, //会员支付订单金额 加上运费 如果是红包订单减去红包金额
                    'real_price' => $allPrice, //实际订单金额 加上运费
                    'original_price' => $payPrice,//原始订单金额,加上运费的
                    'return' => array_sum($v['storeAllReturn']),
                    'create_time' => time(),
                    'auto_sign_date' => Tool::getConfig('site', 'automaticallySignTimeOrders'), //自动签收天数,
                    'delay_sign_count' => Tool::getConfig('site', 'extendMaximumNum'), //会员延迟签收次数,
                    'remark' => isset($info['message'][$k]) ? Tool::banwordReplace($info['message'][$k]) : '',
                    'store_id' => $k,
                    'freight' => $orderFreight,
                    'order_type' => Order::ORDER_TYPE_JF,
                    'distribution_ratio' => CJSON::encode(Order::getOldIssueRatio()),
                    'service_type' => ($v['serviceType'] == Enterprise::SIGNING_TYPE_SERVICE_FEE) ? Enterprise::SIGNING_TYPE_SERVICE_FEE : Enterprise::SIGNING_TYPE_OLD,
                    'source' => Order::ORDER_SOURCE_WEB,//订单类型
                    'source_type' => Order::SOURCE_TYPE_DEFAULT, //订单类型（1、【普通商品及专题商品】2、【大额商品（积分加现金）】3、【合约机商品】4、【红包订单】）
                    'extend' => isset($v['extend']) ? $v['extend'] : '',
                );
                Yii::app()->db->createCommand()->insert('{{order}}', $orderData);
                /**
                 * 插入订单商品信息表
                 */
                $orderId = Yii::app()->db->lastInsertID;
                //$results = $orderData['code'];
                foreach ($cartInfo['cartInfo'][$k]['goods'] as $k2 => $v2) {
                    //单个商品的运费计算
                    $goodsFreight = $this->_computeGoodsFreight($k2, $info['freight'], $info['freight_array']);
                    if ($goodsFreight) {
                        $tmpFreight = explode('|', $goodsFreight);
                        $oneFreight = $tmpFreight[1];
                    } else {
                        $oneFreight = 0.00;
                    }
                    //规格属性
                    $spec = '';
                    if (!empty($v2['spec_name']) && !empty($v2['spec_value'])) {
                        $spec = serialize(array_combine($v2['spec_name'], $v2['spec_value']));
                    }

                    $goodsData = array(
                        'goods_id' => $v2['goods_id'],
                        'order_id' => $orderId,
                        'quantity' => $v2['quantity'],
                        'unit_score' => Common::convert($v2['price']),
                        'total_score' => $v2['returnScore'],
                        'gai_price' => $this->_calGaiPrice($v2, $orderData),//兼容以前的商品数据(按照公式重新计算供货价)
                        'unit_price' => $v2['price'],
                        'original_price' => $v2['original_price'],
                        'total_price' => $v2['price'] * $v2['quantity'],
                        'gai_income' => $v2['gai_income'],
                        'spec_value' => $spec,
                        'spec_id' => $v2['spec_id'],
                        'freight' => $oneFreight,
                        'freight_payment_type' => $v2['freight_payment_type'],
                        'mode' => isset($tmpFreight[0]) ? $tmpFreight[0] : 0,
                        'goods_name' => $v2['name'],
                        'goods_picture' => $v2['thumbnail'],
                        'ratio' => Category::getCategoryServiceFeeRate($v2['g_category_id']),//商品对应分类的服务费率
                        'integral_ratio' => isset($v2['integral_ratio']) ? $v2['integral_ratio'] : $v2['jf_pay_ratio'],
                        'rules_setting_id'=>$v2['rules_seting_id'],
                    );
                    Yii::app()->db->createCommand()->insert('{{order_goods}}', $goodsData);
                }
            }
            $tran->commit();
        } catch (Exception $e) {
            $tran->rollback();
        }
        return $orderData['code'];
    }

    /**
     * 最终创建订单
     * @param $cartInfo
     * @param $address
     * @param $info
     * @return array
     * @throws Exception
     */
    private function _createOrder($cartInfo, $address, $info)
    {
        $results = array();
//        //组装计算会员分配金额数据
//        $ratio = Order::getOldIssueRatio();//分配比率
//        //会员类型
//        $memberType = MemberType::fileCache();
//        $memberData = Yii::app()->db->createCommand()->select('type_id')->from('{{member}}')->where('id=:id', array(':id' => Yii::app()->user->id))->queryRow();
//        $infoArr =array('ratio'=>$ratio['ratio'],'memberType'=>$memberType,'member'=>$memberData);
        
		$nowTime = time();
		
		foreach ($cartInfo['cartInfo'] as $k => $v) {
            /**
             * 插入订单主表
             */
            //订单总运费
            if(isset($info['storeFreight'])){
                $orderFreight = isset($info['storeFreight'][$k]) ? $info['storeFreight'][$k]: 0.00;
            }else{
                $orderFreight = $this->_computeOrderFreight($v, $info['freight_array'], $info['freight']);
            }
            //订单总价格
            $allPrice = array_sum($v['storeAllPrice']) + $orderFreight;
            //原始订单总价格
            $originalPrice = array_sum($v['originalPrice']) + $orderFreight;
            //会员实际支付订单总价格
            $payPrice = (isset($info['useRedMoneyInfo'][$k]) && $info['useRedMoneyInfo'][$k] > 0) ? ($allPrice - $info['useRedMoneyInfo'][$k]) : $allPrice;
            //$payPrice = $allPrice;
			//订单的第一个商品id
            $goodsOne = current($cartInfo['cartInfo'][$k]['goods']);
            
            $goodsOneId = $goodsOne['goods_id'];
			$prID = $redRate = 0;
            if($goodsOne['seckill_seting_id'] > 0){
                $redSeting = ActivityData::getActivityRulesSeting($goodsOne['seckill_seting_id']);
		        $relation  = ActivityData::getRelationInfo($goodsOne['seckill_seting_id'], $goodsOne['goods_id']);
				$prID      = ActivityData::getActivityProductRelation($goodsOne['goods_id']);
				
				if(isset($redSeting) && $redSeting['category_id']==1 && strtotime($redSeting['end_dateline'])>=$nowTime && $prID!=false){//红包活动改掉original_price为实际支付价2015-07-16
				    $actRate = 100-$redSeting['discount_rate']; 
				    
				    $originalPrice = number_format(array_sum($v['originalPrice'])*$actRate/100,2,'.','') + $orderFreight;
// 					$originalPrice = number_format($originalPrice*$actRate/100,2,'.','');
				}
            }
            
            //订单类型
            $sourceType = (isset($info['useRedMoneyInfo'][$k]) && $info['useRedMoneyInfo'][$k] > 0) ? Order::SOURCE_TYPE_HB : (ShopCart::checkSourceType($goodsOneId));
            //$sourceType = (isset($seting) && $seting['category_id'] == 1) ? Order::SOURCE_TYPE_HB : (ShopCart::checkSourceType($goodsOneId));
            //普通商品自定义积分支付比例，当做特殊商品处理
            if ($info['jfxjGoods']){
                $sourceType = Order::SOURCE_TYPE_SINGLE;
            }
            //检查是否是积分+现金订单
            if (isset($goodsOne['special_topic_category_id']) && ($goodsOne['special_topic_category_id'] > 0) && (isset($goodsOne['integral_ratio']) && $goodsOne['integral_ratio'] != 100 && $goodsOne['integral_ratio'] != 0)) {
                if (isset($redSeting) && isset($relation) && $redSeting['category_id']==1 && $relation['status']==1 &&  strtotime($redSeting['end_dateline'])>=$nowTime) {
                    throw new Exception('商品信息有误！,不能是红包商品，同时又是专题商品。');
                }
                $sourceType = Order::SOURCE_TYPE_JFXJ;
            }
            $orderData = array(
                'code' => Tool::buildOrderNo(),
                'member_id' => Yii::app()->user->id,
                'consignee' => $address['real_name'],
                'address' => implode(' ', array($address['province_name'], $address['city_name'], $address['district_name'], $address['street'])),
                'mobile' => $address['mobile'],
                'zip_code' => $address['zip_code'],
                'status' => Order::STATUS_NEW,
                'delivery_status' => Order::DELIVERY_STATUS_NOT,
                'pay_status' => Order::PAY_STATUS_NO,
                'pay_price' => $payPrice, //会员支付订单金额 加上运费 如果是红包订单减去红包金额
                'real_price' => $allPrice, //实际订单金额 加上运费
                'original_price' => $originalPrice,//原始订单金额,加上运费的
                'return' => array_sum($v['storeAllReturn']),
//                'return'=>OnlineCalculate::orderByFront(array('real_price'=>$allPrice,'pay_price'=>$payPrice,'original_price'=>$originalPrice,'freight'=>$orderFreight,'source_type'=>$sourceType),$cartInfo['cartInfo'][$k]['goods'],$infoArr),
                'create_time' => time(),
                'auto_sign_date' => Tool::getConfig('site', 'automaticallySignTimeOrders'), //自动签收天数,
                'delay_sign_count' => Tool::getConfig('site', 'extendMaximumNum'), //会员延迟签收次数,
                'remark' => isset($info['message'][$k]) ? Tool::banwordReplace($info['message'][$k]) : '',
                'store_id' => $k,
                'freight' => $orderFreight,
                'order_type' => Order::ORDER_TYPE_JF,
                'distribution_ratio' => CJSON::encode(Order::getOldIssueRatio()),
                'service_type' => ($v['serviceType'] == Enterprise::SIGNING_TYPE_SERVICE_FEE) ? Enterprise::SIGNING_TYPE_SERVICE_FEE : Enterprise::SIGNING_TYPE_OLD,
                'source' => Order::ORDER_SOURCE_WEB,//订单类型
                'source_type' => $sourceType, //订单类型（1、【普通商品及专题商品】2、【大额商品（积分加现金）】3、【合约机商品】4、【红包订单】）
                'extend' => isset($v['extend']) ? $v['extend'] : '',
                'other_price' => (isset($info['useRedMoneyInfo'][$k]) && $info['useRedMoneyInfo'][$k] > 0) ? ($info['useRedMoneyInfo'][$k]) : 0, //使用红包金额
            );
            Yii::app()->db->createCommand()->insert('{{order}}', $orderData);
            /**
             * 插入订单商品信息表
             */
            $orderId = Yii::app()->db->lastInsertID;
            $results[$orderId] = $orderData['code'];
            foreach ($cartInfo['cartInfo'][$k]['goods'] as $k2 => $v2) {               
                //单个商品的运费计算
                $goodsFreight = $this->_computeGoodsFreight($k2, $info['freight'], $info['freight_array']);
                if ($goodsFreight) {
                    $tmpFreight = explode('|', $goodsFreight);
                    $oneFreight = $tmpFreight[1];
                } else {
                    $oneFreight = 0.00;
                }
                //规格属性
                $spec = '';
                if (!empty($v2['spec_name']) && !empty($v2['spec_value'])) {
                    $spec = serialize(array_combine($v2['spec_name'], $v2['spec_value']));
                }
                //红包商品购买数量只能购买一个,假如前端的js没有限制住.服务端再做一次验证 @author binbin.liao
                /*if ($v2['join_activity'] == Goods::JOIN_ACTIVITY_YES && !empty($v2['activity_tag_id']) && $v2['at_status'] == Activity::STATUS_ON) {
                    $quantity = 1;
                } else {
                    $quantity = $v2['quantity'];
                }*/
                
                $quantity = $v2['quantity'];
                if($v2['seckill_seting_id']>0){
                    $seting = ActivityData::getActivityRulesSeting($v2['seckill_seting_id']);
					$prID   = ActivityData::getActivityProductRelation($v2['goods_id']);
                    if(!empty($seting) && $seting['buy_limit']>0 && strtotime($seting['end_dateline'])>=$nowTime && $prID!=false){
                        $quantity = $v2['quantity']>$seting['buy_limit'] ? $seting['buy_limit'] : $v2['quantity'];
                    }
                    
                    $redRate = isset($seting) && $seting['category_id']==1 ? $seting['discount_rate'] : 0;
                    //如果是红包活动,则修改original_price为优惠后的价格
                    if(isset($seting) && $seting['category_id']==1 && strtotime($seting['end_dateline'])>=$nowTime && $prID!=false){
						$actRate              = 100-$seting['discount_rate']; 
                        //$v2['price'] = number_format($v2['price']*$actRate/100,2,'.','');
						$v2['original_price'] = number_format($v2['original_price']*$actRate/100,2,'.','');
						//$v2['unit_price']     = number_format($v2['price']*$actRate/100,2,'.','');
                    }
                }

                $goodsData = array(
                    'goods_id' => $v2['goods_id'],
                    'order_id' => $orderId,
                    'quantity' => $quantity,
                    'unit_score' => Common::convert($v2['price']),
                    'total_score' => $v2['returnScore'],
                    'gai_price' => $this->_calGaiPrice($v2, $orderData),//兼容以前的商品数据(按照公式重新计算供货价)
                    'unit_price' => $v2['price'],
                    'original_price' => $v2['original_price'],
                    'total_price' => $v2['price'] * $v2['quantity'],
                    'gai_income' => $v2['gai_income'],
                    'spec_value' => $spec,
                    'spec_id' => $v2['spec_id'],
                    'freight' => $oneFreight,
                    'freight_payment_type' => $v2['freight_payment_type'],
                    'mode' => isset($tmpFreight[0]) ? $tmpFreight[0] : 0,
                    'goods_name' => $v2['name'],
                    'goods_picture' => $v2['thumbnail'],
                    'activity_ratio' => (isset($info['useRedMoneyInfo'][$k]) && $info['useRedMoneyInfo'][$k] > 0) ? $redRate : 0,
                    'ratio' => Category::getCategoryServiceFeeRate($v2['g_category_id']),//商品对应分类的服务费率
                    'integral_ratio' => isset($v2['integral_ratio']) ? $v2['integral_ratio'] : $v2['jf_pay_ratio'],
                    'special_topic_category' => ($sourceType == Order::SOURCE_TYPE_JFXJ) ? $v2['special_topic_category_id'] : '0',
                    'rules_setting_id'=> $v2['seckill_seting_id'] ? $v2['seckill_seting_id'] : 0,
                );
           
                Yii::app()->db->createCommand()->insert('{{order_goods}}', $goodsData);
                ActivityTag::deleteCreateRedOrder($orderData['member_id'], $goodsData['goods_id'], $goodsData['spec_id']);
            }
        }
        //减掉使用了的红包金额
        if (isset($info['useRedMoneyInfo']) && $info['useRedMoneyInfo']) {
            MemberAccount::subtractMoney(array_sum($info['useRedMoneyInfo']), Yii::app()->user->id);
        }
		
        return array_unique($results);
    }

    /**
     * 计算每个订单的运费
     * @param array $cartInfo 当前店铺的商品
     * @param array $freightArr 当前购物车所有商品的运费模板数据
     * @param array $freight 会员选择的运费方式
     * @throws Exception
     * @return float
     */
    private function _computeOrderFreight($cartInfo, $freightArr, $freight)
    {
        $freightTotal = array(); //选择的店铺的总运费模板数组
        foreach ($cartInfo['goods'] as $k => $v) {
            if (isset($freight[$k])) {
                $freightTotal[$k] = $freight[$k];
            }
        }
        if (empty($freightTotal))
            return 0.00;
        //查找安全的运费模板数据
        $newFreight = 0.00;
        foreach ($freightTotal as $k2 => $v2) {
            if (isset($freightArr[$k2][$v2])) {
                $tmpFreight = explode('|', $v2);
                $newFreight += $tmpFreight[1];
            } else {
                throw new Exception('运费被恶意修改');
            }
        }
        return $newFreight;
    }

    /**
     * 计算单个商品的运费
     * @param string $goodsKey goods_id - spec_id
     * @param $freight
     * @param $freightArr
     * @return bool|array
     * @throws Exception
     */
    private function _computeGoodsFreight($goodsKey, $freight, $freightArr)
    {
        foreach ($freightArr as $k => $v) {
            if ($goodsKey == $k) {
                if (isset($v[$freight[$k]])) {
                    return $freight[$k];
                } else {
                    throw new Exception('运费被恶意修改');
                }
            }
        }
        return false;
    }

    /**
     * 计算供货价
     * @param array $good 商品数据
     * @param array $orderData 订单数据
     * @return string
     * @author binbin.liao
     */
    private function _calGaiPrice(array $good, array $orderData)
    {
        /**
         * 因为红包计算供货价要用商家售价,所以兼容不同订单.使用original_price
         * 在普通订单中,price, original_price是一样的
         * 在红包订单中.price保存的盖网提供的售价,original_price保存的商家提供的售价
         */
        $unitPrice = $good['original_price'];
        //服务费率
        $fee = Category::getCategoryServiceFeeRate($good['g_category_id']);
        $fee = bcdiv($fee, 100, 2);
        //计算供货价 = 商家售价 - (商家售价*服务费率)
        $gai_price = bcsub($unitPrice, bcmul($unitPrice, $fee, 2), 2);
        return $gai_price * 1;
    }
}