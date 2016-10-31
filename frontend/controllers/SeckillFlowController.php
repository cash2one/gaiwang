<?php

/**
 * 秒杀活动支付流控制器.
 * User: Administrator
 * Date: 2015/5/26
 * Time: 11:22
 * @author binbin.liao
 */
class SeckillFlowController extends Controller
{
    public $user_id;
    public $layout = 'main';
    public $freightInfo = array(); //运费模板信息
    public $freight = array(); //每种运费模板对应城市的运费
    public $setting_id = 0;

    public function beforeAction($action)
    {
        $this->user_id = $this->getUser()->id;
        if (empty($this->user_id)) {
            $this->redirect(array('/member/home/login'));
        }
        $member = Tool::getMemberLoginCache($this->user_id);
        if($member['mobile'] == false){
            throw new CHttpException(404, Yii::t('seckill', '抱歉,账号需要绑定手机号码才能购买！'));
        }
        if($this->action->id == 'close'){
            return parent::beforeAction($action);
        }

        if ($this->action->id == 'order') {
            $goods_select = unserialize(Tool::authcode($this->getPost('goods_select'), 'DECODE'));
            $gs = explode('-', $goods_select);
            $goods_id = $gs[0];
        } else {
            $goods_id = $this->getParam('goods_id');
        }

        if (!$goods_id) {
            throw new CHttpException(404, Yii::t('seckill', '抱歉,请求失败！'));
        }

        // 查询商品并检查
        $goodsData = ActivityData::getGoodsCache($goods_id);
        if(empty($goodsData) || empty($goodsData['goods'])){
            throw new CHttpException(503, Yii::t('seckill', '当前商品不存在!'));
        }
        if ($goodsData['goods']['life'] == Goods::LIFE_YES) {
            throw new CHttpException(503, Yii::t('seckill', '当前商品已经被删除!'));
        }
        if ($goodsData['goods']['is_publish'] == Goods::PUBLISH_NO) {
            throw new CHttpException(503, Yii::t('seckill', '当前商品已经下架!'));
        }
        if ($goodsData['goods']['status'] != Goods::STATUS_PASS) {
            throw new CHttpException(503, Yii::t('seckill', '当前商品审核未通过!'));
        }
        if ($goodsData['goods']['seckill_seting_id'] == false) {
            throw new CHttpException(503, Yii::t('seckill', '当前商品还没有参加活动!'));
        }
        $storeId = $this->getSession('storeId');
        if ($storeId > 0 && $storeId == $goodsData['goods']['store_id']) {
            throw new CHttpException(503, Yii::t('seckill', '不能购买自己店铺的商品!'));
        }
        if($this->setting_id == false){
            $this->setting_id = $goodsData['goods']['seckill_seting_id'];
        }

        // 初始化
        SeckillRedis::int($this->user_id, $goods_id, $this->setting_id);
        $site_config = $this->getConfig('site');
        $this->pageTitle = $site_config['name'];
        return parent::beforeAction($action);
    }


    /**
     * 入队列操作
     * @author binbin.liao
     */
    public function actionAddList()
    {
        $arr = array(); //要缓存的数据
        $arr['goods_id'] = $goods_id = $this->getParam('goods_id'); //商品id
        $arr['setting_id'] = $setting_id = $this->getParam('setting_id'); //活动规则id
        $arr['goods_spec_id'] = $this->getParam('spec_id'); //商品规格id
        $arr['quantity'] = $this->getParam('quantity', 1); //商品数量
        $arr['user_id'] = $this->user_id; //会员id
        $arr['create_time'] = time(); //购买时间
        $arr['is_process'] = SeckillRedis::IS_PROCESS_IN; //处理状态(0:待处理,1:已经处理)
        $arr['order_code'] = 0; //订单编号
        // 查询活动配置信息
        $setting = ActivityData::getActivityRulesSeting($setting_id);
        //入队之前进行条件检查
        ActivityData::checkBuyInfo($arr, $setting);

        // 入队列
        $status = SeckillRedis::addList($arr);
//        var_dump(SeckillRedis::$redis_list->getData(),SeckillRedis::getCache());exit;
        $this->redirect($this->createAbsoluteUrl('/seckillFlow/verify', array('goods_id' => $goods_id)));
    }

    /**
     * 购买确认页面
     * @author binbin.liao
     */
    public function actionVerify($goods_id)
    {
        //获取缓存
        $info = SeckillRedis::getCache();
        if(Yii::app()->theme){
            $this->layout = 'miniMain';
        }
		//判断是否用了主题
		$newTheme = Yii::app()->theme;
		
        if(empty($info))
            throw new CHttpException(404,Yii::t('seckill', '抱歉,订单确认失败!'));
        //已下单,直接跳转支付
        if($info['is_process'] == SeckillRedis::IS_PROCESS_ORDER && $info['order_code']){
			
			if(isset($newTheme) && $newTheme->baseUrl == '/themes/v2.0'){
				$this->redirect($this->createAbsoluteUrl('/order/payv2', array('code' => $info['order_code'])));
			}else{
				$this->redirect($this->createAbsoluteUrl('/order/pay', array('code' => $info['order_code'])));
			}
			
            
        }
        $goods_select = $info['goods_id'] . '-' . $info['goods_spec_id'];
        // 检查活动是否满足条件
        $setting = ActivityData::getActivityRulesSeting($info['setting_id']);
        ActivityData::checkBuyInfo($info, $setting, true);
        //判断是否有间隔5分钟,如果大于5分钟,清除队列,删除缓存
        SeckillRedis::checkTime();
        //判断收货地址是否为空
        $address = Address::getMemberAddress($this->user_id);
        //判断地址  否则跳转到地址页面
        if (empty($address)) {
            $this->setFlash('error', Yii::t('member', '请先设置收货地址'));
            $this->turnbackRedirect('/member/address/index');
        }
        //设置默认收货地址
        if (!$this->getSession('select_address')) {
            foreach ($address as $k => $v) {
                if ($v['default']) {
                    $this->setSession('select_address', array('id' => $v['id'], 'city_id' => $v['city_id']));
                } else if ($k == 0) {
                    $this->setSession('select_address', array('id' => $v['id'], 'city_id' => $v['city_id']));
                }
            }
        }
        
        //检查订单记录--李文豪 20150624
		/*$quantity = Yii::app()->db->createCommand()->select('SUM(og.quantity) AS quantity')->from('{{order}} o')->join('{{order_goods}} og','og.order_id=o.id')
		->andWhere('og.goods_id = :goodsId', array(':goodsId'=>$info['goods_id']))
		->andWhere('o.member_id = :memberId', array(':memberId' => $info['user_id']))
		->andWhere('og.rules_setting_id = :setingId', array(':setingId'=>$info['setting_id']))
		->andWhere('o.status != '.Order::STATUS_CLOSE)
		->queryScalar();
		$buyNum = $info['quantity'] + $quantity;
		if($buyNum > $setting['buy_limit'] && $setting['buy_limit']>0){
			throw new CHttpException(404,Yii::t('seckill', '已达活动购买数量限制,请查看 我的订单 内容!'));
		}*/
		
		

        //检查库存跟会员购买数量
        $goodsInfo = Goods::getGoodsInfoBySec($info);
//        Tool::pr($goodsInfo);
        $this->freightInfo = $goodsInfo['freightInfo'];//运费相关信息
        $select_address = $this->getSession('select_address');
        $this->_computeFreight($select_address['city_id']); //运费计算
        if ($info['is_process'] == SeckillRedis::IS_PROCESS_IN) {
            //更新缓存中状态信息
            $info['is_process'] = SeckillRedis::IS_PROCESS_CONFIRM;
            SeckillRedis::setCache($info);
//            Tool::cache(SeckillRedis::SECKILL_LIST)->set(SeckillRedis::$redis_cache_key, serialize($info), 3600);
        }
        $validEnd = $info['create_time'] + SeckillRedis::TIME_INTERVAL_CONFIRM;
        $this->render('verify', array(
            'address' => $address,
            'cartInfo' => $goodsInfo,
            'goods_select' => $goods_select,
            'validEnd'=>$validEnd,
            'goodsId'=>$goods_id,
        ));
    }

    /**
     * 取消抢购
     * @param $goods_id
     */
    public function actionCancel($goods_id)
    {
        //获取缓存
        $info = SeckillRedis::getCache(true);
        // 未支付的清除缓存及order_cache
        if($info['is_process'] < SeckillRedis::IS_PROCESS_ORDER){
            ActivityData::deleteOrderCache($this->user_id, $goods_id);//删除秒杀流程缓存
        }
        if (!Yii::app()->request->isAjaxRequest){
            if($info['is_process'] == SeckillRedis::IS_PROCESS_ORDER && $info['order_code']){
                $this->redirect($this->createAbsoluteUrl('/order/pay',array('code'=>$info['order_code'])));
            }else{
                $this->redirect($this->createAbsoluteUrl('/goods/view',array('id'=>$goods_id)));
            }
        }
    }

    public function actionClose()
    {
        if (!Yii::app()->request->isAjaxRequest) throw new CHttpException(404);
        /** @var Order $model */
        $model = $this->loadModel($this->getPost('code'), array(
            'status' => Order::STATUS_NEW,
            'pay_status' => Order::PAY_STATUS_NO,
        ));
        /**
         *  如果订单是第三方支付并且对账是不成功的,就把这个订单暂时锁定,不能操作.
         *  @author binbin.liao 新增 2014-11-26
         */
        if (in_array($model->pay_type, array(Order::PAY_ONLINE_IPS, Order::PAY_ONLINE_UN, Order::PAY_ONLINE_BEST))) {
            $result = OnlinePayCheck::payCheck($model->parent_code, $model->pay_type,$model->code);
            if ($result['status']) {
                echo Yii::t('memberOrder', '等待订单状态更新中,暂时不能关闭');
                exit;
            }
        }
        $trans = Yii::app()->db->beginTransaction(); // 事务执行
        try {
            $model->status = $model::STATUS_CLOSE;
            $model->rollBackStock(); //库存回滚

            //如果是红包订单,得把占用的红包金额给还回去
            if($model->source_type == Order::SOURCE_TYPE_HB){
                $otherPrice = $model->other_price;//红包使用金额
                MemberAccount::model()->updateCounters(array('money'=>$otherPrice),'member_id=:member_id',array(':member_id'=>$model->member_id));
            }

            if ($model->save(false)) {
                echo Yii::t('memberOrder', '取消订单成功');
            } else {
                throw new Exception(Yii::t('memberOrder', '取消订单失败'));
            }
            $trans->commit();
        } catch (Exception $e) {
            $trans->rollback();
        }
    }

    /**
     * 生成订单页面
     * @author binbin.liao
     */
    public function actionOrder()
    {
        //获取缓存
        $info = SeckillRedis::getCache();
        if(empty($info))
            throw new CHttpException(404,Yii::t('seckill', '抱歉,订单生成失败!'));
        // 检查活动是否满足条件
        $setting = ActivityData::getActivityRulesSeting($info['setting_id']);
        ActivityData::checkBuyInfo($info, $setting, true);
//        Tool::pr($info);
        if (isset($info) && $info['is_process'] == SeckillRedis::IS_PROCESS_CONFIRM) {
            // 检查实时库存
            $stockNow = ActivityData::getActivityGoodsStock($info['goods_id'], $info['goods_spec_id'], 'flush');
            if($stockNow < $info['quantity']){
                throw new CHttpException(404, Yii::t('seckill', '抱歉,商品库存不足或者已售完！'));
            }
            //订单商品数组 goods_id - spec_id
            $goods_select = unserialize(Tool::authcode($this->getPost('goods_select'), 'DECODE'));
            if (empty($goods_select)) throw new CHttpException(503, Yii::t('orderFlow', '请重新提交购物车'));
            //收货地址
            $address = Address::getAddressById($this->getPost('address'));
            if (empty($address)) throw new CHttpException(503, Yii::t('orderFlow', '收货地址为空'));
            //所有结算商品的运费方式
            $freight_array = unserialize(Tool::authcode($this->getPost('freight_array'), 'DECODE'));
            //会员所选的运费方式
            $freight = $this->getPost('freight');

            $goodsInfo = Goods::getGoodsInfoBySec($info, ' FOR UPDATE');
//            Tool::pr($goodsInfo);
            //生成订单操作
            $orderFlow = new OrderFlow();
            $infos = array('freight_array' => $freight_array, 'freight' => $freight, 'message' => $this->getPost('message'));
            $orderCode = $orderFlow->seckillOrder($goodsInfo, $address, $infos);
//        Tool::pr($orderCode);
            if (!empty($orderCode)) {
                //更新缓存中状态
                $info['is_process'] = SeckillRedis::IS_PROCESS_ORDER;
                $info['order_code'] = $orderCode;
                SeckillRedis::setCache($info);//更新秒杀缓存
                ActivityData::delGoodsCache($info['goods_id']);//删除商品页面缓存
                //给支付页面提示用
//                Tool::cache('PaycheckTime')->set($orderCode, $info['create_time'] + SeckillRedis::TIME_INTERVAL_ORDER,1800);
                //刷新库存缓存
                ActivityData::deleteActivityGoodsStock($info['goods_id']);
				
				$newTheme = $this->theme;
				if(isset($newTheme) && $newTheme->baseUrl == '/themes/v2.0'){
					$this->redirect(array('/order/payv2', 'code' => implode(',', array($orderCode))));
				}else{
					$this->redirect(array('/order/pay', 'code' => implode(',', array($orderCode))));
				}
                
            } else {
                throw new CHttpException(503, '生成订单失败');
            }
        } else {
            throw new CHttpException(503, '您还有未完成的订单,请在会员中心处理');
        }

    }

    /**
     * 计算运费
     * @param int $city_id
     */
    private function _computeFreight($city_id)
    {
        if (!empty($this->freightInfo)) {
            foreach ($this->freightInfo as $v) {
                $freight = ComputeFreight::compute($v['freight_template_id'], $v['size'], $v['weight'], $city_id, $v['valuation_type'], $v['quantity']);
                foreach ($freight as $k2 => $v2) {
                    $fid = $v['goods_id'] . '-' . $v['spec_id'];
                    $this->freight[$fid][$k2 . '|' . $v2['fee'] . '|' . Common::rateConvert($v2['fee'])] = $v2['name'];
                }
            }
        }
    }

    /**
     * 获取订单 for update
     * @param int $code
     * @param array $condition 限制条件 = in
     * @return Order
     * @throws CHttpException
     */
    public function loadModel($code, Array $condition = array())
    {
        if (!$code) throw new CHttpException(404);
        /** @var Order $model */
        $models = Order::model()->findAll('code=:code AND member_id =:member_id LIMIT 1 FOR UPDATE', array(':code' => $code,':member_id'=>$this->getUser()->id));
        if (!empty($models)) {
            $model = $models[0];
        } else {
            throw new CHttpException(404, '请求的订单不存在.');
        }
        if ($model->member_id != $this->getUser()->id) throw new CHttpException(404, '不能处理别人的订单');
        foreach ($condition as $k => $v) {
            if (is_array($v)) {
                if (!isset($model->$k) || !in_array($model->$k, $v)) throw new CHttpException(404, $k . '请求的订单条件错误.');
            } else {
                if (!isset($model->$k) || $model->$k != $v) throw new CHttpException(404, $k . '请求的订单条件错误.');
            }
        }
        return $model;
    }
}