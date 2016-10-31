<?php

/**
 * 订单管理
 * @author wyee <yanjie@gatewang.com>
 */
class OrderController extends WController {
    
    public $order=true;

    /**
     * 我的订单
     */
    public function actionIndex() {
        $model = new Order('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['Order'])) {
            $model->attributes = $this->getQuery('Order');
        }
        $c = $model->searchOrder($this->getUser()->id);
        //分页
        $count = $model->count($c);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($c);
        $orders = $model->findAll($c);
        //搜索页面
        if ($this->getParam('search')) {
            $this->showTitle = Yii::t('order', '订单搜索');
            $this->render('search', array(
                'model' => $model,
                'orders' => $orders,
                'pages' => $pages,
                'on' => $this->getParam('on'),
            ));
        } else {
            $this->layout=false;
            $this->render('index', array(
                'model' => $model,
                'orders' => $orders,
                'pages' => $pages,
                'on' => $this->getParam('on'),
            ));
        }
    }

    /**
     * 订单详情
     * @param string $code 订单编号
     * @throws CHttpException
     */
    public function actionDetail($code) {
        $this->showTitle = Yii::t('order', '订单详情');
        $model = $this->getOrderModel($code);
        if ($model->delivery_time > 0) {
            $diffDay = floor((time() - $model->delivery_time));
            $showDay = ($model->auto_sign_date ? $model->auto_sign_date : 10);
            $showDay = strtotime('+' . $showDay . ' day') - floor($diffDay);
        } else {
            $showDay = strtotime('+' . $model->auto_sign_date . ' day');
        }
        if ($showDay < 0) {
            $showDay = $diffDay;
        }
        if (!$model)
            throw new CHttpException(403);
        $this->render('detail', array('model' => $model, 'showDay' => $showDay));
    }

    /**
     * 物流信息
     */
    public function actionLogistics() {
        $this->showTitle = Yii::t('order', '物流信息');
        $code = $this->getParam('code');
        $model = $this->getOrderModel($code);
        $this->render('logistics', array('model' => $model));
    }

    /**
     * 确认收货
     */
    public function actionSign() {
         if (!Yii::app()->request->isAjaxRequest)
            throw new CHttpException(404); 
        $order = $this->getOrderModel($this->getParam('code'), array(
            'status' => Order::STATUS_NEW,
            'sign_time' => array('', 0, null, ' '),
            'delivery_status' => Order::DELIVERY_STATUS_SEND,
        	'is_distribution' => Order::IS_DISTRIBUTION_NO,
            'pay_status' => Order::PAY_STATUS_YES,
            'refund_status' => array(Order::REFUND_STATUS_NONE, Order::REFUND_STATUS_FAILURE),
            'return_status' => array(Order::RETURN_STATUS_NONE, Order::RETURN_STATUS_FAILURE),
        ));
        $orderGoods=$order->orderGoods;
        $orderInfo=$order->attributes;
        $member=$this->model->attributes;
        $storeFields = array('m.gai_number', 'm.type_id', 'm.mobile', 'c.id', 'c.member_id', 'c.name',
            'c.province_id', 'c.city_id', 'c.district_id', 'c.referrals_id','c.mobile as store_mobile');
        $store = Yii::app()->db->createCommand()->select($storeFields)
        ->from('{{store}} c')
        ->leftJoin('{{member}} m', 'm.id = c.member_id')
        ->where('c.id=:id', array(':id' => $orderInfo['store_id']))->queryRow(); 
        //$msg = OnlineSign::order($orderInfo,$orderGoods,$member,$store);
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
     * 获取订单详情
     * @param int $code
     * @param array $condition 限制条件 = in
     * @return Order
     * @throws CHttpException
     */
    public function getOrderModel($code, Array $condition = array()) {
        if (!$code)
            throw new CHttpException(404);
        /** @var Order $model */
        $models = Order::model()->findAll('code=:code LIMIT 1 FOR UPDATE', array(':code' => $code));
        if (!empty($models)) {
            $model = $models[0];
        } else {
            throw new CHttpException(404, '请求的订单不存在.');
        }
        if ($model->member_id != $this->getUser()->id)
            throw new CHttpException(404, '不能处理别人的订单');
        foreach ($condition as $k => $v) {
            if (is_array($v)) {
                if (!isset($model->$k) || !in_array($model->$k, $v))
                    throw new CHttpException(404, $k . '请求的订单条件错误.');
            } else {
                if (!isset($model->$k) || $model->$k != $v)
                    throw new CHttpException(404, $k . '请求的订单条件错误.');
            }
        }
        return $model;
    }

    /**
     * 根据快递公司名字查询
     * store_name
     * code
     */
    public function actionGetExpressStatus() {
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
            $rs = $exp->search($express->code, $kd_code);
        }

        echo $rs;
    }

    /**
     * 店铺评价,以及此店铺下的商品评价
     */
    public function actionComment($code) {
        $this->showTitle = Yii::t('order', '订单评价');
        $model = new Comment;
        $orderModel = Order::model()
               ->with(array('orderGoods' => array(
                                     'select' => 'goods_name,goods_picture,goods_id,spec_value,quantity,unit_price,gai_income,gai_price,original_price,ratio,activity_ratio')))
               ->find('code =:code ', array(':code' => $code));
        $storeModel = Store::model()->find('t.id=:id', array(':id' => $orderModel->store_id));      
        //防止重复提交
        $this->checkPostRequest();
        //验证订单评论有效性
        $this->_check($orderModel);
        $order = $orderModel->attributes;
        $orderGoods = array();
        foreach ($orderModel->orderGoods as $v) {
            $orderGoods[] = $v->attributes;
        }
        if (isset($_POST['Comment'])) {
            if (!empty($_POST['Comment'][0]['content']))
                $_POST['Comment'][0]['content'] = Tool::banwordReplace(CHtml::encode($_POST['Comment'][0]['content']));  //评论过滤
            $valid = true;
            $models = array();
            foreach ($_POST['Comment'] as $j => $model) {
                if (isset($_POST['Comment'][$j])) {
                    $model = new Comment;
                    $model->attributes = $_POST['Comment'][$j];
                    $models[] = $_POST['Comment'][$j];
                    $valid = $model->validate(array('content', 'score')) && $valid;
                }
            }
            $storeModel->attributes = $_POST['StoreRating'];
            $valid = $storeModel->validate(array('description_math', 'service_attitude', 'speed_of_delivery')) && $valid;
            //计算待返还金额
            $member = $this->model->attributes;
            $account = Yii::app()->ac->createCommand()
                ->select('credit_amount')
                ->from('gw_account_flow_'.date('Ym',$order['sign_time']))
                ->where('account_id = :mid and order_id=:oid and node=:node')
                ->bindValues(array(':mid'=>$member['id'],':oid'=>$order['id'],':node'=>AccountFlow::BUSINESS_NODE_ONLINE_ORDER_REWARD))
                ->queryScalar();
            $return['memberIncome'] = $account!==false ? $account : 0.00;
            // 商家评论
            $storeRate = array();
            $storeRate['description_match'] = $storeModel->description_match;
            $storeRate['serivice_attitude'] = $storeModel->serivice_attitude;
            $storeRate['speed_of_delivery'] = $storeModel->speed_of_delivery;
            $storeRate['order_id'] = $order['id'];
            $storeRate['create_time'] = time();
            $storeRate['store_id'] = $order['store_id'];
            $storeRate['member_id'] = $order['member_id'];
           //商品评论
            $goodsRate = array(); 
            if ($valid) {
                foreach ($models as $k => $v) {
                    $goods['score'] = $v['score'];
                    $goods['content'] = $v['content'];
                    $goods['order_id'] = $order['id'];
                    $goods['store_id'] = $order['store_id'];
                    $goods['goods_id'] = $v['goods_id'];
                    $goods['member_id'] = $order['member_id'];
                    $goods['create_time'] = time();
                    $goods['status'] = Comment::STATUS_SHOW;
                    $goods['spec_value'] = Tool::authcode($v['spec_value'], 'DECODE');
                    $goodsRate[$k] = $goods;
                }
                //执行方法
                $msg = OnlineComment::operate($order, $member, $return, $storeRate, $goodsRate);
                if ($msg['flag']) {
                    $this->setFlash('flags', Yii::t('memberComment', $msg['info']));
                    $this->redirect(array('index'));
                } else {
                    $this->setFlash('flags', Yii::t('memberComment', $msg['info']));
                    $this->redirect(array('index'));
                }
            }
        }
        
        $this->render('comment', array(
            'model' => $model,
            'store' => $storeModel,
            'order' => $orderModel,
        ));
    }

    /**
     * 评论之前对订单做检查
     * @param $model 订单模型
     * @throws CHttpException
     */
    private function _check($model) {
        $condition = array(
            'pay_status' => Order::PAY_STATUS_YES,
            'delivery_status' => Order::DELIVERY_STATUS_RECEIVE,
            'is_comment' => Order::IS_COMMENT_NO,
            'sign_time' => array('', ' ', null, 0),
        );
        foreach ($condition as $k => $v) {
            if (is_array($v)) {
                if (!isset($model->$k) || in_array($model->$k, $v))
                    throw new CHttpException(404, $k . '请求的订单条件错误.');
            } else {
                if (!isset($model->$k) || $model->$k != $v)
                    throw new CHttpException(404, $k . '请求的订单条件错误.');
            }
        }
    }

}
