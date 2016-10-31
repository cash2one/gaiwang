<?php

/**
 * 卖家已卖出商品控制器(已卖出列表,备货,发货等操作)
 * @author binbin.liao  <277250538@qq.com>
 */
class OrderController extends SController
{

    public function init()
    {
        $this->pageTitle = Yii::t('sellerOrder', '_卖家平台_') . Yii::app()->name;
    }

    /**
     * 订单列表
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('sellerOrder', '已卖出商品') . $this->pageTitle;
        $model = new Order('search');
        $model->unsetAttributes();

        if (isset($_GET['Order'])) {
            $model->attributes = $this->getQuery('Order');    
        }

        $c = $model->searchSold($this->storeId);

        $count = $model->count($c);
        $pages = new CPagination($count);
        //$pages->pageSize = 2;
        $pages->applyLimit($c);

        $orders = $model->findAll($c);
        foreach($orders as $key => $value){
            $exchange = self::actionGetBackMoney($value['id']);
            $value->backMoney = $exchange['pay_price'];
            $value->exchangeTypeName = $exchange['exchange_type_name'];
            $value->exchangeType = $exchange['exchange_type'];
            $value->exchangeStatus = $exchange['exchange_status'];
            $value->isNew = $exchange['is_new'];
        }

        $recentDate = array('start' => (time() - $model::RECENT_TIME), 'end' => time());
        //近期订单数量
        $recentOrderNum = $model->countByAttributes(array('store_id' => $this->storeId), 'create_time>=' . $recentDate['start']);
        //未发货
        $notDeliverNum = $model->countByAttributes(array('store_id' => $this->storeId,
            'delivery_status' => $model::DELIVERY_STATUS_NOT, 'pay_status' => $model::PAY_STATUS_YES, 'status' => $model::STATUS_NEW));
        //已备货
        $waitDeliverNum = $model->countByAttributes(array('store_id' => $this->storeId,
            'delivery_status' => $model::DELIVERY_STATUS_WAIT, 'pay_status' => $model::PAY_STATUS_YES, 'status' => $model::STATUS_NEW));
        //已发货
        $recentDeliverNum = $model->countByAttributes(array('store_id' => $this->storeId,
            'delivery_status' => $model::DELIVERY_STATUS_SEND, 'status' => $model::STATUS_NEW));
        //退款中
        $refundNum = $model->countByAttributes(array('store_id' => $this->storeId,
            'refund_status' => $model::REFUND_STATUS_PENDING, 'status' => $model::STATUS_NEW));
        //退货中
        $returnNum = $model->countByAttributes(array('store_id' => $this->storeId, 'status' => $model::STATUS_NEW, 'return_status' => $model::RETURN_STATUS_PENDING));

        $this->render('index', array(
            'model' => $model,
            'orders' => $orders,
            'pages' => $pages,
            'recentOrderNum' => $recentOrderNum,
            'recentDate' => $recentDate,
            'notDeliverNum' => $notDeliverNum,
            'waitDeliverNum' => $waitDeliverNum,
            'recentDeliverNum' => $recentDeliverNum,
            'refundNum' => $refundNum,
            'returnNum' => $returnNum,
        ));
    }

    /**
     * ajax 备货
     */
    public function actionStockUp()
    {
        //检查店铺权限
        $this->checkAccess($this->storeId);
        $code = $this->getPost('code');
        $msg = array(); //返回json状态
        /** @var $model Order */
        $model = $this->loadModel($code, array(
            'pay_status' => Order::PAY_STATUS_YES,
            'delivery_status' => Order::DELIVERY_STATUS_NOT,
        ));

        //商品价格检查
        foreach ($model->orderGoods as $v) {
            if ($v['gai_price'] > $v['unit_price']) {
                $msg['error'] = Yii::t('sellerOrder', '备货失败，订单数据异常');
                echo CJSON::encode($msg);
                exit;
            }
        }

        //更新发货状态
        $rs = Yii::app()->db->createCommand()->update('{{order}}', array('delivery_status' => Order::DELIVERY_STATUS_WAIT, 'stockup_time' => time()), 'id=:id', array(':id' => $model->id));

        if ($rs) {
            //添加操作日志
            @$this->_saveSellerLog(SellerLog::CAT_MALL, SellerLog::logTypeUpdate, $model->id, '备货');
            $msg['success'] = '备货成功';
        } else {
            $msg['error'] = '备货失败,请检查库存';
        }

        exit(CJSON::encode($msg));
    }

    /**
     * 订单详情
     */
    public function actionDetail()
    {
        $this->pageTitle = Yii::t('sellerOrder', '订单详情') . $this->pageTitle;
        $code = $this->getParam('code');
        $model = Order::model()->with(array(
            'orderGoods' => array(
                'select' => 'goods_name,goods_picture,freight,gai_price,quantity,goods_id,mode,spec_id,spec_value,gai_income,unit_price,order_id,ratio,activity_ratio,original_price'
            ),
        ))->find('code = :code', array(':code' => $code));
        if ($model === null)
            throw new CHttpException(403, '您访问的页面不存在！');

        $this->checkAccess($this->storeId); // 检查店铺权限
        $orderPrice = 0;//(供货价+运费)
        foreach ($model->orderGoods as $og) {
            $orderPrice += ($og->gai_price * $og->quantity);
        }
        $orderPrice += $model->freight;
        if ($model->delivery_time > 0) {
            $diffDay = floor((time() - $model->delivery_time) / 3600 / 24);
            $showDay = ($model->auto_sign_date ? $model->auto_sign_date : 10) - floor($diffDay);
        } else {
            $showDay = $model->auto_sign_date;
        }
        if ($showDay < 0) {
            $showDay = $diffDay;
        }

        $this->render('detail', array(
            'model' => $model,
            'orderPrice' => $orderPrice,
            'showDay' => $showDay,
        ));
    }

    /**
     * 填写发货物流信息
     */
    public function actionExpress($code)
    {
        $this->layout = 'dialog';
        /* @var $orderModel Order */
       $orderModel = $this->loadModel($code,array(
           'status'=>Order::STATUS_NEW,
           'pay_status'=>Order::PAY_STATUS_YES,
           'delivery_status'=>Order::DELIVERY_STATUS_WAIT,
       ));

        $this->checkAccess($orderModel->store_id); //检查权限
        $orderModel->setScenario('express');
        $orderModel->delivery_time = time();
        $orderModel->delivery_status = Order::DELIVERY_STATUS_SEND;
        $this->performAjaxValidation($orderModel);

        if (isset($_POST['Order'])) {
            $orderModel->attributes = $this->getPost('Order');
            if ($orderModel->save()) {
                $rs = OrderExpress::add($orderModel); //添加物流信息推送
                $msg = $rs!==true ? $rs :'操作成功';
                echo '<script> var success = "True";alert("'.$msg.'")</script>';
            } else {
                echo "<script>alert('订单数据异常，修改失败');</script>";
            }
        }
        $this->render('express', array('model' => $orderModel, 'orderId' => $orderModel->id,));
    }

    /**
     * ajax 关闭交易
     */
    public function actionCloseOrder()
    {
        $this->checkAccess($this->storeId); //检查权限
        $code = $this->getPost('code');
        $reason=$this->getPost('reason');     
        $model = $this->loadModel($code, array(
            'status' => Order::STATUS_NEW,
            'refund_status' => Order::REFUND_STATUS_NONE,
            'return_status' => Order::RETURN_STATUS_NONE,
        ));
        $order = $model->attributes;
        $member = Yii::app()->db->createCommand()
            ->select('id,gai_number,type_id,mobile,username')
            ->from('{{member}}')
            ->where('id=:id', array(':id' => $order['member_id']))
            ->queryRow();

        //如果这个订单是新订单,但是未支付的订单，可以随时关闭
        if ($order['pay_status'] == Order::PAY_STATUS_NO) {
            /**
             *  如果订单是第三方支付并且对账是不成功的,就把这个订单暂时锁定,不能操作.
             *  @author binbin.liao 新增 2014-11-26
             */
            if (in_array($order['pay_type'], array(Order::PAY_ONLINE_IPS, Order::PAY_ONLINE_UN, Order::PAY_ONLINE_BEST))) {
                $result = OnlinePayCheck::payCheck($order['parent_code'], $order['pay_type'],$order['code']);
                if($result['status']){
                    exit(json_encode(array('error' => '等待订单状态更新中,暂时不能关闭')));
                }
            }
            Yii::app()->db->createCommand()->update('{{order}}', array(
                'status' => Order::STATUS_CLOSE,
                'close_time' => time(),
                'extend_remark' =>$reason,
            ), 'id=:id', array(':id' => $order['id']));

            //把会员占用的红包金额还回去
            if($order['source_type'] ==Order::SOURCE_TYPE_HB){
                MemberAccount::model()->updateCounters(array('money'=>$order['other_price']),'member_id=:member_id',array(':member_id'=>$model->member_id));
            }
			
			//如果是活动商品,则redis清除缓存-李文豪 20150630
			$rs = Yii::app()->db->createCommand()->select('og.rules_setting_id, og.goods_id, o.code')->from('{{order}} o')->join('{{order_goods}} og','og.order_id=o.id')
			->andWhere('o.code = :code', array(':code'=>$code))
			->limit(1)
			->queryRow();
			if(!empty($rs) && $rs['rules_setting_id'] > 0 && $rs['goods_id']){
				 SeckillRedis::delCacheByGoods($rs['goods_id']);
				 ActivityData::deleteOrderCache(Yii::app()->user->id, $rs['goods_id']);//删除秒杀流程缓存
				 ActivityData::delGoodsCache($rs['goods_id']);//删除商品缓存
				 ActivityData::deleteActivityGoodsStock($rs['goods_id']);//删除库存缓存
				 
				 Yii::app()->db->createCommand()->delete('{{seckill_order_cache}}', "order_code='$rs[code]'");
			}
            //如果是拍卖商品，卖家关闭订单时要返还积分
            if($order['source_type'] == Order::SOURCE_TYPE_AUCTION) {
                //获取拍卖商品领先的价格记录
                $result = Yii::app()->db->createCommand()
                        ->select('id,balance_history,balance,flow_id,flow_code,is_return')
                        ->from('{{seckill_auction_record}}')
                        ->where('status=:status AND is_return=:return AND member_id=:memberId AND rules_setting_id=:rsid AND goods_id=:gid',
                                array(
                                    ':status'=>SeckillAuctionRecord::STATUS_ONE,
                                    ':return'=>SeckillAuctionRecord::IS_RETURN_NO,
                                    ':memberId'=>$order['member_id'],
                                    ':rsid'=>$rs['rules_setting_id'],
                                    ':gid'=>$rs['goods_id']
                                ))
                        ->queryRow();
                //积分未返还状态才会进行返还
                if($result['is_return'] == SeckillAuctionRecord::IS_RETURN_NO) {
                    if($result['balance_history'] > 0) {
                        SeckillAuctionRecord::returnBalanceHistory(array('account_id'=>$member['id'],'gai_number'=>$member['gai_number'],'type'=>AccountBalance::TYPE_CONSUME,'money'=>$result['balance_history'],'flow_id'=>$result['flow_id'],'flow_code'=>$result['flow_code']),AccountFlowHistory::monthTable());
                    }
                    if($result['balance'] > 0) {
                        SeckillAuctionRecord::returnBalance(array('account_id'=>$member['id'],'gai_number'=>$member['gai_number'],'type'=>AccountBalance::TYPE_CONSUME,'money'=>$result['balance'],'flow_id'=>$result['flow_id'],'flow_code'=>$result['flow_code']),AccountFlow::monthTable());
                    }
                }
                
            }
            $msg = array('success' => '关闭交易成功');
            exit(json_encode($msg));
        } else {
            if ($order['real_price'] < 0) {
                $msg['info'] = array('error' => '关闭交易失败-201');
                exit(json_encode($msg['info']));
            }
            $msg = OnlineClose::operate($order, $member);
            if ($msg['flag']) {
                //添加操作日志
                @$this->_saveSellerLog(SellerLog::CAT_MALL, SellerLog::logTypeUpdate, $order['id'], '关闭交易');
            }
            exit(json_encode($msg['info']));
        }
    }

    /**
     * ajax 批量设置已读
     */
    public function actionSetRead()
    {
        $ids = $this->getPost('ids');
        $result = Order::model()->updateAll(array('is_read' => Order::IS_READ_YES), 'id in(:ids)', array(':ids' => $ids));
        if ($result) {
            echo Yii::t('sellerOrder', '标记成功');
        }
    }

    /**
     * 商家协商退货
     */
    public function actionReturn()
    {
        $orderId = $this->getParam('orderId');
        $freight = $this->getParam('freight');
        $returnInfo['orderId'] = $orderId;
        $returnInfo['freight'] = $freight;
        $returnInfo['backMoney'] = self::actionGetBackMoney($orderId);
        if ($this->getParam('repit')) {
            $repit = $this->getParam('repit');
            $model = Order::model()->findByPk($orderId);
            $this->checkAccess($model->store_id); //检查权限
            if ($repit == 'disagree') {
                $model->return_status = Order::RETURN_STATUS_FAILURE; //协商退货失败
                $res = false;
                $exchangeData = array('exchange_status'=>2,'exchange_examine_time'=>time());
            } else {
                $model->return_status = Order::RETURN_STATUS_AGREE; //同意退货 
                $res = true;
                $exchangeData = array('exchange_status'=>3,'exchange_examine_time'=>time());
            }

            $one = OrderExchange::checkOrderById($model->id);//兼容gw_order_exchange表数据 廖佳伟 2015-10-23
            if(!empty($one)){
                Yii::app()->db->createCommand()->update("{{order_exchange}}",$exchangeData,'order_id=:order_id',array(':order_id'=>$model->id));
            }

            if ($model->save()) {
                //添加操作日志
                @$this->_saveSellerLog(SellerLog::CAT_MALL, SellerLog::logTypeUpdate, $orderId, '协商退货');

                echo '<script> var success = "' . $res . '";</script>';
            }
        }

        $this->renderPartial('return', array('returnInfo' => $returnInfo));
    }

    public function actionSignReturn($code)
    {
        $this->checkAccess($this->storeId); //检查权限
        $model = $this->loadModel($code, array(
            'return_status' => Order::RETURN_STATUS_AGREE,
            'pay_status' => Order::PAY_STATUS_YES,
            'delivery_status' => Order::DELIVERY_STATUS_SEND,
            'status' => Order::STATUS_NEW,
        ));
        $member = Yii::app()->db->createCommand()
            ->select('id,gai_number,type_id,mobile,username')
            ->from('{{member}}')
            ->where('id=:id', array(':id' => $model['member_id']))
            ->queryRow();
        $storeFields = array('m.gai_number', 'm.type_id', 'm.mobile', 'c.id', 'c.member_id', 'c.name');
        if ($model['deduct_freight'] > $model['real_price']) {
            $this->setFlash('error', '退货手续费不能大于支付总额');
            $this->redirect(array('/seller/order/index'));
            Yii::app()->end();
        }
        //执行方法
        $status = OnlineReturn::operate($model, $member);
        if ($status['flag']) {
            $this->setFlash('success', $status['info']);
        } else {
            $this->setFlash('error', $status['info']);
        }
        $this->redirect(array('/seller/order/index'));
    }

    /**
     * 商家确认签收退货的操作,包括更新状态,和退款
     */
    public function actionSignReturnNew($code)
    {
        $this->checkAccess($this->storeId); //检查权限
        $model = $this->loadModel($code, array(
            'return_status' => Order::RETURN_STATUS_AGREE,
            'pay_status' => Order::PAY_STATUS_YES,
            'delivery_status' => Order::DELIVERY_STATUS_SEND,
            'status' => Order::STATUS_NEW,
        ));
        $member = Yii::app()->db->createCommand()
            ->select('id,gai_number,type_id,mobile,username')
            ->from('{{member}}')
            ->where('id=:id', array(':id' => $model['member_id']))
            ->queryRow();
        $storeFields = array('m.gai_number', 'm.type_id', 'm.mobile', 'c.id', 'c.member_id', 'c.name');
        if ($model['deduct_freight'] > $model['real_price']) {
            $this->setFlash('error', '退货手续费不能大于支付总额');
            $this->redirect(array('/seller/order/index'));
            Yii::app()->end();
        }
        $store = Yii::app()->db->createCommand()
            ->select('s.member_id,m.gai_number')
            ->from('{{store}} as s')
            ->leftJoin("{{member}} as m",'s.member_id=m.id')
            ->where('s.id=:id', array(':id' => $model->store_id))
            ->queryRow();
        //执行方法
        $status = ExchangeReturn::operate($model, $member, $store);
        if ($status['flag']) {
            $this->setFlash('success', $status['info']);
        } else {
            $this->setFlash('error', $status['info']);
        }
        $this->redirect(array('/seller/order/index'));
    }


    /**
     * 申请退款,操作
     * @return bool
     * @throws Exception
     */
    public function actionRefund()
    {
        if (!Yii::app()->request->isAjaxRequest)
            throw new CHttpException('404', '页面不存在！');
        $this->checkAccess($this->storeId); // 检查权限

        $export = array('status' => 'error', 'msg' => '');
        $code = $this->getPost('orderId');
        $model = $this->loadModel($code, array(
            'refund_status' => Order::REFUND_STATUS_PENDING,
            'status' => Order::STATUS_NEW,
            'pay_status' => Order::PAY_STATUS_YES,
        ));
        $order = $model->attributes;
        $refundStatus = $this->getPost('refundStatus'); // 退款状态
        if ($refundStatus == Order::REFUND_STATUS_SUCCESS) {
            //同意退款
            $member = Yii::app()->db->createCommand()
                ->select('id,gai_number,type_id,mobile,username')
                ->from('{{member}}')
                ->where('id=:id', array(':id' => $order['member_id']))
                ->queryRow();
            // 执行
            $msg = OnlineRefund::operate($order, $member);

            if ($msg['flag']) {
                Order::closeOder($order['id']);
                // 添加操作日志
                @$this->_saveSellerLog(SellerLog::CAT_MALL, SellerLog::logTypeUpdate, $order['id'], '申请退款');
                $export['status'] = 'succeed';
                $export['msg'] = $msg['info'];

            } else {
                $export['status'] = 'error';
                $export['msg'] = $msg['info'];
            }
        } elseif ($refundStatus == Order::REFUND_STATUS_FAILURE) {
            //不同意退款
            $res = Yii::app()->db->createCommand()->update('{{order}}', array('refund_status' => Order::REFUND_STATUS_FAILURE), 'id=:id', array(':id' => $order['id']));
            if ($res) {
                $export['status'] = 'succeed';
                $export['msg'] = Yii::t('order', '您选择了不同意退款！');
            }
        }
        echo CJSON::encode($export);
    }
    /**
     * 2.0版申请退款,操作
     * @return bool
     * @throws Exception
     */
    public function actionRefundNew()
    {
        if (!Yii::app()->request->isAjaxRequest)
            throw new CHttpException('404', '页面不存在！');
        $this->checkAccess($this->storeId); // 检查权限

        $export = array('status' => 'error', 'msg' => '');
        $code = $this->getPost('orderId');
        $model = $this->loadModel($code, array(
            'refund_status' => Order::REFUND_STATUS_PENDING,
            'status' => Order::STATUS_NEW,
            'pay_status' => Order::PAY_STATUS_YES,
        ));
        $order = $model->attributes;
        $refundStatus = $this->getPost('refundStatus'); // 退款状态
        if ($refundStatus == Order::REFUND_STATUS_SUCCESS) {
            //同意退款
            $member = Yii::app()->db->createCommand()
                ->select('id,gai_number,type_id,mobile,username')
                ->from('{{member}}')
                ->where('id=:id', array(':id' => $order['member_id']))
                ->queryRow();
            $store = Yii::app()->db->createCommand()
                ->select('s.member_id,m.gai_number')
                ->from('{{store}} as s')
                ->leftJoin("{{member}} as m",'s.member_id=m.id')
                ->where('s.id=:id', array(':id' => $model->store_id))
                ->queryRow();
            // 执行
            $msg = ExchangeRefund::operate($order, $member, $store);
            if ($msg['flag']) {
                Order::closeOder($order['id']);
                // 添加操作日志
                @$this->_saveSellerLog(SellerLog::CAT_MALL, SellerLog::logTypeUpdate, $order['id'], '申请退款');
                $export['status'] = 'succeed';
                $export['msg'] = $msg['info'];
                $exchangeData = array('exchange_status'=>6,'exchange_examine_time'=>time());

            } else {
                $export['status'] = 'error';
                $export['msg'] = $msg['info'];
            }
        } elseif ($refundStatus == Order::REFUND_STATUS_FAILURE) {
            //不同意退款
            $res = Yii::app()->db->createCommand()->update('{{order}}', array('refund_status' => Order::REFUND_STATUS_FAILURE), 'id=:id', array(':id' => $order['id']));
            if ($res) {
                $export['status'] = 'succeed';
                $export['msg'] = Yii::t('order', '您选择了不同意退款！');
                $exchangeData = array('exchange_status'=>2,'exchange_examine_time'=>time());
            }
        }
        $one = OrderExchange::checkOrderById($model->id);//同步gw_order_exchange表数据 廖佳伟 2015-11-04
        if(!empty($one)){
            Yii::app()->db->createCommand()->update("{{order_exchange}}",$exchangeData,'order_id=:order_id',array(':order_id'=>$model->id));
        }
        echo CJSON::encode($export);
    }


    /**
     * 导出Excel
     */
    public function actionExcel()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

        Yii::import('comext.PHPExcel.*');


        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()
            ->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        $model = new Order('search');
        $model->unsetAttributes();
        if (isset($_GET['Order']))
            $model->attributes = $this->getQuery('Order');
        /** @var CDbCriteria $c */
        $c = $model->searchSold($this->storeId);
        $c->select = 't.id,t.code,t.consignee,t.mobile,t.address,t.real_price,t.return,t.status,t.delivery_status,t.pay_status,t.freight';
        $orders = $model->findAll($c);
        //输出表头
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '订单编号')
            ->setCellValue('B1', '收货人')
            ->setCellValue('C1', '电话')
            ->setCellValue('D1', '详细地址')
            ->setCellValue('E1', '商品编号')
            ->setCellValue('F1', '商品名称')
            ->setCellValue('G1', '供货价')
            ->setCellValue('H1', '零售价')
            ->setCellValue('I1', '数量')
            ->setCellValue('J1', '金额-不含运费')
            ->setCellValue('K1', '运费')
            ->setCellValue('L1', '返回积分')
            ->setCellValue('M1', '订单状态')
            ->setCellValue('N1', '支付状态')
            ->setCellValue('O1', '发货状态');

//		print_r($orders);die;

        $num = 1;
        foreach ($orders as $key => $row) {
//             $gai_price = 0;
//             //计算总供货价+运费
            $orderGoods = $row['orderGoods'];
//             foreach ($orderGoods as $row1) {
//                 $gai_price += $row1['gai_price']*$row1['quantity']+$row1['freight'];

//             }
			$n=0;
            foreach ($orderGoods as $row1) {
                $num++;
                $specstr='';
                if ($row1->spec_value) {
                    $spec=  unserialize($row1->spec_value);
                    foreach ($spec as $ks => $vs) {
                        $specstr .= $ks . ':' . $vs . ' ';
                    }
                }
                $original_price = $row1['original_price']>0?$row1['original_price']:$row1['unit_price'];
                $totalPaice = $original_price*$row1['quantity'];
                $freight = $row['freight']>0?'¥' . $row['freight']:'包邮';
                if($n!=0) $freight='';
                $return = $n==0?$row['return']:'';
                //显式指定内容类型
//				$objPHPExcel->getActiveSheet()->getStyle('A'.$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $num, ' ' . $row['code'])
                    ->setCellValue('B' . $num, $row['consignee'])
                    ->setCellValue('C' . $num, ' ' . $row['mobile'])
                    ->setCellValue('D' . $num, $row['address'])
                    ->setCellValue('E' . $num, $row1['goods_id'])
                    ->setCellValue('F' . $num, $row1['goods_name'].' '.$specstr)
                    ->setCellValue('G' . $num, '¥' . $row1['gai_price'])
                    ->setCellValue('H' . $num, '¥' . $original_price)
                    ->setCellValue('I' . $num, $row1['quantity'])
                    ->setCellValue('J' . $num, '¥' . $totalPaice)
                    ->setCellValue('K' . $num, $freight)
                    ->setCellValue('L' . $num, $return)
                    ->setCellValue('M' . $num, Order::status($row['status']))
                    ->setCellValue('N' . $num, Order::payStatus($row['pay_status']))
                    ->setCellValue('O' . $num, Order::deliveryStatus($row['delivery_status']));
                 $n++;
            }
        }


        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle("代理进账明细");

        $name = date('YmdHis' . rand(0, 99999));
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    /**
     * 延迟签收
     */
    public function actionDelaySign()
    {
        if (!Yii::app()->request->isAjaxRequest)
            return false;
        $code = $this->getParam('code');
        $data = Order::model()->find(
            array(
                'select' => 'delay_sign_count,auto_sign_date',
                'condition' => 'code = :code',
                'params' => array(':code' => $code),
            ));
        if ($data) {
            $delay = array();
            $autoSignDate = $data->auto_sign_date + 1; //自动签收天数
            $delay['auto_sign_date'] = $autoSignDate;
            $res = Yii::app()->db->createCommand()->update('{{order}}', $delay, 'code=:code', array(':code' => $code));
            if ($res) {
                echo 1;
            } else {
                echo 0;
            }
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

//        $rs = $exp->search($express->code, $kd_code);
            $rs = $exp->search($kd_store_name, $kd_code,$express->code);

        }
        echo $rs;
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
        $models = Order::model()->findAll('code=:code LIMIT 1 FOR UPDATE', array(':code' => $code));
        if (!empty($models)) {
            $model = $models[0];
        } else {
            throw new CHttpException(404, '请求的订单不存在.');
        }
        if ($model->store_id != $this->storeId) throw new CHttpException(404, '不能处理别人的订单');
        foreach ($condition as $k => $v) {
            if (is_array($v)) {
                if (!isset($model->$k) || !in_array($model->$k, $v)) throw new CHttpException(404, $k . '请求的订单条件错误.');
            } else {
                if (!isset($model->$k) || $model->$k != $v) throw new CHttpException(404, $k . '请求的订单条件错误.');
            }
        }
        return $model;
    }

    public function actionChangeExpress($code){
        $this->layout = 'dialog';
        /* @var $orderModel Order */
        $orderModel = $this->loadModel($code,array(
            'status'=>Order::STATUS_NEW,
            'pay_status'=>Order::PAY_STATUS_YES,
            'delivery_status'=>Order::DELIVERY_STATUS_SEND,
        ));

        $this->checkAccess($orderModel->store_id); //检查权限
        $orderModel->setScenario('express');
        $this->performAjaxValidation($orderModel);
        if (isset($_POST['Order'])) {
            $orderModel->attributes = $this->getPost('Order');
            if ($orderModel->save()) {
                $rs = OrderExpress::updated($orderModel);
                $msg = $rs!==true ? $rs :'操作成功';
                echo '<script> var success = "True";alert("'.$msg.'")</script>';
            } else {
                echo "<script>alert('订单数据异常，修改失败');</script>";
            }
        }
        $this->render('express', array('model' => $orderModel, 'orderId' => $orderModel->id,));
    }

    /**
     * 获取退货退款单的香港数据。
     * @author jiawei.liao 569114018@qq.com
     */
    public static function actionGetBackMoney($orderId){
        $resultArr =array();
        $result = Yii::app()->db->createCommand()->select('exchange_money,exchange_type,exchange_status')->from("{{order_exchange}}")
            ->where("order_id=:order_id",array(':order_id'=>$orderId))->order('exchange_id DESC')->limit(1)->queryRow();

        $resultOld = Yii::app()->db->createCommand()->select('pay_price,refund_status,return_status')->from("{{order}}")
            ->where("id=:order_id",array(':order_id'=>$orderId))->limit(1)->queryRow();
        if(!empty($result)){
            $resultArr['pay_price'] = $result['exchange_money'];
            $resultArr['exchange_type'] = $result['exchange_type'];
            $resultArr['exchange_status'] = $result['exchange_status'];
            $resultArr['is_new'] = true;
            $resultArr['exchange_type_name'] = $result['exchange_type'] == Order::EXCHANGE_TYPE_RETURN ? Yii::t('order','退货'):Yii::t('order','退款');
        }else{
            $resultArr['pay_price'] = $resultOld['pay_price'];
            $resultArr['is_new'] = false;
            if($resultOld['refund_status'] > 0){
                $resultArr['exchange_type'] = Order::EXCHANGE_TYPE_RETURN;
                $resultArr['exchange_status'] = $resultOld['refund_status'];
                $resultArr['exchange_type_name'] = Yii::t('order','退货');
            }else{
                $resultArr['exchange_type'] = Order::EXCHANGE_TYPE_REFUND;
                $resultArr['exchange_status'] = $resultOld['return_status'];
                $resultArr['exchange_type_name'] = Yii::t('order','退款');
            }
        }
        return $resultArr;
    }

}

?>
