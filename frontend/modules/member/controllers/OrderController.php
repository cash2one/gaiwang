<?php

/**
 * 订单管理
 * 操作(订单列表，支付，取消订单，申请退款)
 * @author zhenjun_xu <412530435@qq.com>
 */
class OrderController extends MController
{

    public function init()
    {
        $this->pageTitle = Yii::t('memberOrder', '_用户中心_') . Yii::app()->name;
    }

    /**
     * 订单列表
     */
    public function actionAdmin()
    {

        $this->pageTitle = Yii::t('memberOrder', '我的订单') . $this->pageTitle;

        $model = new Order('search');
        $model->unsetAttributes(); // clear any default values
        $getOrder = $this->getQuery('Order');
		
		if (isset($_GET['Order']) && isset($_GET['Order']['code']) && trim($_GET['Order']['code'])!=''){//由于2.0版本搜索合并,所以要处理提交数据
			if( preg_match('/^\d+$/', trim($_GET['Order']['code'])) ){//纯数字是是订单号,否则是商品名称
				$getOrder['code'] = trim($_GET['Order']['code']);
				$getOrder['goods_name'] = '';
			}else{
				$getOrder['code'] = '';
				$getOrder['goods_name'] = trim($_GET['Order']['code']);
			}
		}
		
		$model->attributes = $getOrder;
        $c = $model->searchOrder($this->getUser()->id);
        //分页
        $count = $model->count($c);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($c);

        $orders = $model->findAll($c);
        $recentDate = array('start' => (time() - $model::RECENT_TIME), 'end' => time());
        //近期订单数量
        $recentOrderNum = Yii::app()->db->createCommand()->from('{{order}}')->select('count(*)')
            ->where('member_id=:mid and create_time>=:cTime and source_type!=:source_type', array(
                ':mid' => $this->getUser()->id,
                ':cTime' => $recentDate['start'],
                ':source_type'=>Order::SOURCE_TYPE_AUCTION,
            ))->queryScalar();
        //待收货
        $waitReceiveNum = Yii::app()->db->createCommand()->from('{{order}}')->select('count(*)')
            ->where('member_id=:mid and status=:status and delivery_status=:dStatus and refund_status=:refund_status and return_status=:return_status and source_type!=:source_type', array(
                ':mid' => $this->getUser()->id,
                ':status' => Order::STATUS_NEW,
                ':dStatus' => Order::DELIVERY_STATUS_SEND,
                ':refund_status' => Order::REFUND_STATUS_NONE,
                ':return_status' => Order::RETURN_STATUS_NONE,
                ':source_type'=>Order::SOURCE_TYPE_AUCTION
            ))->queryScalar();
        //退款中
        $refundNum = Yii::app()->db->createCommand()->from('{{order}}')->select('count(*)')
            ->where('member_id=:mid and refund_status=:refund_status and source_type!=:source_type', array(
                ':mid' => $this->getUser()->id,
                ':refund_status' => Order::REFUND_STATUS_PENDING,
                ':source_type'=>Order::SOURCE_TYPE_AUCTION
            ))->queryScalar();
        //待评价
        $waitCommentNum = Yii::app()->db->createCommand()->from('{{order}}')->select('count(*)')
            ->where('member_id=:mid and status=:status and is_comment=:isC and source_type!=:source_type', array(
                ':mid' => $this->getUser()->id,
                ':status' => Order::STATUS_COMPLETE,
                ':isC' => Order::IS_COMMENT_NO,
                ':source_type'=>Order::SOURCE_TYPE_AUCTION,
            ))->queryScalar();
		//待付款 2015-08-10
		$waitPayNum = Yii::app()->db->createCommand()->from('{{order}}')->select('count(*)')
            ->where('member_id=:mid and pay_status=:pay_status and status=:status and source_type!=:source_type', array(
                ':mid' => $this->getUser()->id,
                ':pay_status' => Order::PAY_STATUS_NO,
				':status' => Order::STATUS_NEW,
                ':source_type'=>Order::SOURCE_TYPE_AUCTION,
            ))->queryScalar();
		
		//待发货 2015-08-10	
		$waitSendNum = Yii::app()->db->createCommand()->from('{{order}}')->select('count(*)')
            ->where('member_id=:mid and pay_status=:pay_status and status=:status and delivery_status IN(:dWait, :dNot) and source_type !=:source_type', array(
                ':mid' => $this->getUser()->id,
                ':pay_status' => Order::PAY_STATUS_YES,
				':status' => Order::STATUS_NEW,
                ':dWait' => Order::DELIVERY_STATUS_WAIT,
                ':dNot' => Order::DELIVERY_STATUS_NOT,
                ':source_type'=>Order::SOURCE_TYPE_AUCTION,
            ))->queryScalar();
				
        $this->render('admin', array(
            'model' => $model,
            'orders' => $orders,
            'pages' => $pages,
            'recentOrderNum' => $recentOrderNum,
            'recentDate' => $recentDate,
            'waitReceiveNum' => $waitReceiveNum,
            'refundNum' => $refundNum,
            'waitCommentNum' => $waitCommentNum,
			'waitPayNum' => $waitPayNum,
			'waitSendNum' => $waitSendNum,
        ));
    }

    /**
     * ajax 取消订单
     * 条件： 新订单、未支付
     */
    public function actionCancel()
    {

        if (!Yii::app()->request->isAjaxRequest) throw new CHttpException(404);
        /** @var Order $model */
        $model = $this->loadModel($this->getPost('code'), array(
            'status' => Order::STATUS_NEW,
            'pay_status' => Order::PAY_STATUS_NO,
        ));
       if($model->source_type == Order::SOURCE_TYPE_AUCTION && $model->pay_status == Order::PAY_STATUS_NO){
            echo Yii::t('memberOrder', '拍卖订单付款前不能取消');
            exit;
        }

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
            //再查询订单状态,并加行锁
            $sql = "select pay_status,status from {{order}} where id = {$model->id} limit 1 for update";
            $data = Yii::app()->db->createCommand($sql)->queryRow();
            if($data['pay_status']!= Order::PAY_STATUS_NO || $data['status']!=Order::STATUS_NEW){
                throw new Exception("该订单不满足取消条件");
            }
            $model->status = $model::STATUS_CLOSE;
            $model->close_time = time();
            $model->extend_remark = "买家关闭订单";
            $model->rollBackStock(); //库存回滚

            //如果是红包订单,得把占用的红包金额给还回去
            if($model->source_type == Order::SOURCE_TYPE_HB){
                $otherPrice = $model->other_price;//红包使用金额
                MemberAccount::model()->updateCounters(array('money'=>$otherPrice),'member_id=:member_id',array(':member_id'=>$model->member_id));
            }

            if($model)
            if ($model->save(false)) {
				//如果是活动商品,则redis清除缓存-李文豪 20150624
				$rs = Yii::app()->db->createCommand()->select('og.rules_setting_id, og.goods_id, o.code')->from('{{order}} o')->join('{{order_goods}} og','og.order_id=o.id')
				->andWhere('o.code = :code', array(':code'=>$this->getPost('code')))
				->limit(1)
				->queryRow();
				if(!empty($rs) && $rs['rules_setting_id'] > 0 && $rs['goods_id']){
					 SeckillRedis::delCacheByGoods($rs['goods_id']);
					 ActivityData::deleteOrderCache(Yii::app()->user->id, $rs['goods_id']);//删除秒杀流程缓存
                     ActivityData::delGoodsCache($rs['goods_id']);//删除商品缓存
                     ActivityData::deleteActivityGoodsStock($rs['goods_id']);//删除库存缓存
					 
					 Yii::app()->db->createCommand()->delete('{{seckill_order_cache}}', "order_code='$rs[code]'");
				}
				
                echo Yii::t('memberOrder', '取消订单成功');
            } else {
                throw new Exception(Yii::t('memberOrder', '取消订单失败'));
            }
            $trans->commit();
        } catch (Exception $e) {
            $trans->rollback();
            echo ($e->getMessage());
        }
    }

    /**
     * ajax 申请退款
     * 条件：新订单，已经支付、未发货
     */
    public function actionRefund()
    {
        if (!Yii::app()->request->isAjaxRequest) throw new CHttpException(404);
        $model = $this->loadModel($this->getPost('code'), array(
            'status' => Order::STATUS_NEW,
            'pay_status' => Order::PAY_STATUS_YES,
            'delivery_status' => Order::DELIVERY_STATUS_NOT,
        ));
        if ($model) {
            $model->refund_status = $model::REFUND_STATUS_PENDING;
            $model->refund_reason = Tool::filter_script($this->getPost('reason'));
            $model->apply_refund_time = time(); //协商退款时间
            if ($model->save(false)) {
				//为了兼容V2.0版本,写入gw_order_exchange表 2015-09-07 李文豪
				$result = Yii::app()->db->createCommand()->select('id,pay_price,freight')->from('{{order}}')
                          ->where('code=:code', array(':code'=>$this->getPost('code')))
                          ->queryRow();
				$exchange['member_id']            = $this->getUser()->id;
				$exchange['order_id']             = $result['id'];
				$exchange['exchange_type']        = Order::EXCHANGE_TYPE_REFUND;
				$exchange['exchange_apply_time']  = time();
				$exchange['exchange_reason']      = 1;
				$exchange['exchange_money']       = $result['pay_price']-$result['freight'];
				$exchange['exchange_description'] = Tool::filter_script($this->getPost('resons'));
				Yii::app()->db->createCommand()->insert("{{order_exchange}}",$exchange);
				
                echo Yii::t('memberOrder', '申请退款已经提交成功');
            }
        } else {
            echo Yii::t('memberOrder', '申请退款提交失败');
        }
    }

    /**
     * 订单详情
     * @param string $code 订单编号
     * @throws CHttpException
     */
    public function actionDetail($code)
    {
        $this->pageTitle = Yii::t('memberOrder', '订单详情') . $this->pageTitle;
        $model = $this->loadModel($code);
        if ($model->delivery_time > 0) {
            $diffDay = floor((time() - $model->delivery_time) / 3600 / 24);
            $showDay = ($model->auto_sign_date ? $model->auto_sign_date : 10) - floor($diffDay);
        } else {
            $showDay = $model->auto_sign_date;
        }
        if ($showDay < 0) {
            $showDay = $diffDay;
        }
        if (!$model)
            throw new CHttpException(403);
        $this->render('detail', array('model' => $model, 'showDay' => $showDay));
    }
	
	/**
     * 订单详情 V2.0版本
     * @param string $code 订单编号
     * @throws CHttpException
     */
    public function actionNewDetail($code)
    {    
	    $this->layout = 'exchange';
        $this->pageTitle = Yii::t('memberOrder', '订单详情') . $this->pageTitle;
        $model = $this->loadModel($code);
        $Exchange = OrderExchange::checkOrderById($model->id);
        if ($model->delivery_time > 0) {
            $diffDay = floor((time() - $model->delivery_time) / 3600 / 24);
            $showDay = ($model->auto_sign_date ? $model->auto_sign_date : 10) - floor($diffDay);
        } else {
            $showDay = $model->auto_sign_date;
        }
        if ($showDay < 0) {
            $showDay = $diffDay;
        }
		
		$store = Yii::app()->db->createCommand()->select('id,name,province_id,city_id,district_id,street,mobile')->from('{{store}}')
					 ->where('id=:id', array(':id'=>$model->store_id))
					 ->queryRow();
		
        if (!$model)
            throw new CHttpException(403);
        $this->render('detail', array('model' => $model, 'showDay' => $showDay, 'store'=>$store,'exchange'=>$Exchange));
    }

    /**
     * 协商退货
     * 条件：新订单、已支付、已发货
     */
    public function actionReturn()
    {
        $model = $this->loadModel($this->getPost('orderId'), array(
            'status' => Order::STATUS_NEW,
            'pay_status' => Order::PAY_STATUS_YES,
            'delivery_status' => Order::DELIVERY_STATUS_SEND,
        ));

        $model->return_reason = Tool::filter_script($this->getPost('resons')); //退货原因
        $model->return_status = Order::REFUND_STATUS_PENDING; //协商退货状态
        $model->deduct_freight = $this->getPost('deductFrei'); //退货运费
        $model->apply_return_time = time(); //协商退货时间
        if ($this->getPost('deductFrei') > $model->pay_price && $this->getPost('deductFrei') >= 0) {
            //如果运费大于销售价.返回管理页
            $this->setFlash('error', Yii::t('memberOrder', '退还运费不能大于支付费用并且不能为负数'));
            $this->redirect(array('admin'));
        }
        if ($model->save()) {
			//为了兼容新的退换货流程 需要写入gw_order_exchange表 李文豪 2015-08-25
            $orderId = Yii::app()->db->createCommand()->select('id')->from('{{order}}')
                           ->where('code=:code', array(':code'=>$this->getPost('orderId')))
                           ->queryScalar();
			$exchange['member_id']            = $this->getUser()->id;
			$exchange['order_id']             = $orderId;
			$exchange['exchange_type']        = Order::EXCHANGE_TYPE_RETURN;
			$exchange['exchange_apply_time']  = time();
			$exchange['exchange_reason']      = 1;
			$exchange['exchange_money']       = $this->getPost('deductFrei');
			$exchange['exchange_description'] = Tool::filter_script($this->getPost('resons'));
			Yii::app()->db->createCommand()->insert("{{order_exchange}}",$exchange);
			
            $this->setFlash('success', Yii::t('memberOrder', '已申请退货,商家审核中,请稍候'));
            $this->redirect(array('admin'));
        }
        $this->renderPartial('_return');
    }

    /**
     * ajax 签收订单
     * 条件：未签收、新订单、已支付、已发货
     *
     */
    public function actionSign()
    {
        if (!Yii::app()->request->isAjaxRequest) throw  new CHttpException(404);
        $order = $this->loadModel($this->getPost('code'), array(
            'status' => Order::STATUS_NEW,
            'sign_time' => array('', 0, null, ' '),
            'delivery_status' => Order::DELIVERY_STATUS_SEND,
        	'is_distribution' => Order::IS_DISTRIBUTION_NO,
            'pay_status' => Order::PAY_STATUS_YES,
            'refund_status' => array(Order::REFUND_STATUS_NONE, Order::REFUND_STATUS_FAILURE),
            'return_status' => array(Order::RETURN_STATUS_NONE, Order::RETURN_STATUS_FAILURE,Order::RETURN_STATUS_CANCEL),
        ));

        $storeFields = array('m.gai_number', 'm.type_id', 'm.mobile', 'c.id', 'c.member_id', 'c.name',
            'c.province_id', 'c.city_id', 'c.district_id', 'c.referrals_id','c.mobile as store_mobile');
        $store = Yii::app()->db->createCommand()->select($storeFields)
            ->from('{{store}} c')
            ->leftJoin('{{member}} m', 'm.id = c.member_id')
            ->where('c.id=:id', array(':id' => $order['store_id']))->queryRow();
        //$msg = OnlineSign::order($order->attributes, $order->orderGoods, $this->model->attributes, $store);
        //签收分配改为任务自动执行  @todo OrderAutoDistributionCommand
        $signRes=Yii::app()->db->createCommand()->update('{{order}}', array(
        		'delivery_status' => Order::DELIVERY_STATUS_RECEIVE,
        		'status' => Order::STATUS_COMPLETE,
        		'sign_time' => time()), 'id=:orderId', array(':orderId' =>$order['id']));
        if($signRes){
        	echo Yii::t('memberOrder', '签收订单成功');
            exit;
        }else{
        	echo Yii::t('memberOrder', '签收订单失败');
            exit;
         }     
    }

    /**
     * 延迟签收
     * @throws CHttpException
     */
    public function actionDelaySign()
    {
        if (!Yii::app()->request->isAjaxRequest) throw  new CHttpException(404);
        $data = $this->loadModel($this->getPost('code'), array('delivery_status' => Order::DELIVERY_STATUS_SEND));
        if ($data) {
            $delay = array();
            $delaySignCount = $data->delay_sign_count - 1; //签收次数
            $autoSignDate = $data->auto_sign_date + 1; //自动签收天数
            $delay['delay_sign_count'] = $delaySignCount;
            $delay['auto_sign_date'] = $autoSignDate;
            $res = Yii::app()->db->createCommand()->update('{{order}}', $delay, 'id=:id', array(':id' => $data->id));
            if ($res) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            throw new CHttpException(503, Yii::t('memberOrder', '这个订单不能延迟签收'));
        }
    }

    /**
     * 根据快递公司名字查询
     * store_name
     * code
     */
    public function actionGetExpressStatus()
    {
        $kd_code = $this->getParam('code'); //快递单号
        $rs = Yii::app()->db->createCommand('select data from gw_order_express where shipping_code=:code')
            ->bindValue(':code',$kd_code)->queryScalar();
        if(!$rs){
            Yii::import('common.vendor.ExpressSearch');
            $kd_store_name = $this->getParam('store_name'); //快递公司名称

            $express = Express::model()->find("name='{$kd_store_name}'");
            if (empty($express->code)) {
                echo json_encode(array('message' => Yii::t('memberOrder', '快递公司不存在')));
                exit();
            } elseif (empty($kd_code)) {
                echo json_encode(array('message' => Yii::t('memberOrder', '运单号不能为空')));
                exit();
            }

            $exp = new ExpressSearch(Yii::app()->params['ExpressApiKey'], Yii::app()->params['ExpressApiHost']);

            $rs = $exp->search($kd_store_name, $kd_code,$express->code);
        }
        echo $rs;
    }

    /**
     * 取消退货
     * 条件：新订单，退货状态（卖家已经同意退货）
     * @throws CHttpException
     */
    public function  actionCancelReturn(){
        if (!Yii::app()->request->isAjaxRequest) throw new CHttpException(404);
        $model = $this->loadModel($this->getPost('code'), array(
            'status' => Order::STATUS_NEW,
            'return_status' => Order::RETURN_STATUS_AGREE,
        ));
        if ($model) {
            $model->return_status = $model::RETURN_STATUS_CANCEL;
            if ($model->save(false)) {
				//兼容新版本的退换货流程,更新gw_order_exchange表 李文豪 2015-08-27
				$orderId = Yii::app()->db->createCommand()->select('id')->from('{{order}}')
                           ->where('code=:code', array(':code'=>$this->getPost('code')))
						   ->order('create_time DESC')
					       ->limit('1')
                           ->queryScalar();
				Yii::app()->db->createCommand()->update('{{order_exchange}}', array('exchange_status'=>Order::EXCHANGE_STATUS_CANCEL), 'order_id=:id', array(':id' => $orderId));
				
                echo Yii::t('memberOrder', '取消退货成功');
            }
        } else {
            echo Yii::t('memberOrder', '取消退货失败');
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
