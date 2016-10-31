<?php

/**
 * 订单管理
 *
 * 操作(搜索、查看)
 *  @author zhenjun_xu <412530435@qq.com>
 */
class OrderController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }
    
    /**
     * (non-PHPdoc)不做权限设置
     * @see RController::allowedActions()
     */
    public function allowedActions() {
        return 'cancelReturn';
    } 
   
   
    /**
     * 查看订单
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->breadcrumbs = array(Yii::t('order', '订单管理 '), Yii::t('order', '订单查看'));
        /** @var $model Order */
        $model = $this->loadModel($id);

        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * 订单列表
     */
    public function actionAdmin() {
        $this->breadcrumbs = array(Yii::t('order', '订单管理 '), Yii::t('order', '订单列表'));
        $model = new Order('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Order'])) {
            $model->attributes = $_GET['Order'];
            $model->beginCreateTime = $_GET['Order']['beginCreateTime'];
            $model->toCreateTime = $_GET['Order']['toCreateTime'];
            $model->beginPrice = $_GET['Order']['beginPrice'];
            $model->toPrice = $_GET['Order']['toPrice'];
        }

        $this->showExport = true;
        $this->exportAction = 'adminExport';

        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'order/adminExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;

        $this->render('admin', array(
            'model' => $model,
            'exportPage' => $exportPage,
            'totalCount' => $totalCount,
        ));
    }

    public function actionAdminExport() {
        set_time_limit(3600);
        @ini_set('memory_limit', '1048M');
        $model = new Order('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Order'])) {
            $model->attributes = $_GET['Order'];
        }

        @SystemLog::record(Yii::app()->user->name . "导出订单列表");

        $model->isExport = 1;
        $this->render('adminExport', array(
            'model' => $model,
        ));
    }

    /**
     * 未读订单
     */
    public function actionUnread() {
        $this->showExport = true;
        $this->exportAction = 'unreadExport';
        $this->breadcrumbs = array(Yii::t('order', '订单管理 '), Yii::t('order', '订单列表'));
        $model = new Order('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Order']))
            $model->attributes = $_GET['Order'];


        $totalCount = $model->search(Order::IS_READ_NO)->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'order/unreadExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;

        $this->render('unread', array('model' => $model, 'exportPage' => $exportPage, 'totalCount' => $totalCount,));
    }

    public function actionUnreadExport() {
        set_time_limit(3600);
        @ini_set('memory_limit', '1048M');
        $model = new Order('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Order']))
            $model->attributes = $_GET['Order'];


        @SystemLog::record(Yii::app()->user->name . "导出未读订单列表");

        $model->isExport = 1;
        $this->render('unreadExport', array(
            'model' => $model,
        ));
    }

    /**
     * 异常订单查询
     */
    public function actionException() {
        $this->breadcrumbs = array(Yii::t('order', '订单管理 '), Yii::t('order', '异常订单'));
        $model = new Order('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Order']))
            $model->attributes = $_GET['Order'];

        $this->showExport = true;
        $this->exportAction = 'exceptionExport';

        $totalCount = $model->searchException()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'order/exceptionExport';
        $exportPage->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;

        $this->render('exception', array(
            'model' => $model,
            'exportPage' => $exportPage,
            'totalCount' => $totalCount,
        ));
    }

    public function actionExceptionExport() {
        set_time_limit(3600);
        @ini_set('memory_limit', '1048M');
        $model = new Order('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Order']))
            $model->attributes = $_GET['Order'];

        @SystemLog::record(Yii::app()->user->name . "导出异常订单列表");

        $model->isExport = 1;
        $this->render('exceptionExport', array(
            'model' => $model,
        ));
    }

    /**
     * 订单维权
     */
    public function actionRights() {
        $this->breadcrumbs = array(Yii::t('order', '订单管理 '), Yii::t('order', '消费者维权订单'));
        $model = new Order('search');
        $model->unsetAttributes();
        if (isset($_GET['Order']))
            $model->attributes = $_GET['Order'];
        $this->render('rights', array(
            'model' => $model,
        ));
    }

    /**
     * 查看维权订单
     */
    public function actionRightView($id) {
        $model = Order::model()->rights()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, '请求的页面不存在.');
        $this->breadcrumbs = array(Yii::t('order', '订单管理 '), Yii::t('order', '查看维权订单' . $model->code));
        $model->setScenario('orderRight');  // 设置场景
        $returnPrice = $model->getOrderPrice();
        $obligation = array();
        // 已发货及申请退货失败
        if ($model->delivery_status == Order::DELIVERY_STATUS_SEND && $model->return_status == Order::RETURN_STATUS_FAILURE) {
            $obligation[Order::OBLIGATION_MERCHANT] = "销售价({$returnPrice['sellTotalPrice']})";
        } else if ($model->delivery_status == Order::DELIVERY_STATUS_RECEIVE) {
            // 已签收及订单未评论
            $obligation[Order::OBLIGATION_MERCHANT] = "销售价({$returnPrice['sellTotalPrice']})";
            $obligation[Order::OBLIGATION_CUSTOMER] = "供货价({$returnPrice['gaiTotalPrice']})";
        }
        $post = $this->getParam('Order');
        $model->obligation = !empty($post) ? $post['obligation'] : '';
        // 退还金额
        $model->refundPrice = $model->obligation == Order::OBLIGATION_CUSTOMER ? $returnPrice['gaiTotalPrice'] : $returnPrice['sellTotalPrice'];
        $model->rawFreight = $model->freight;   // 原始订单运费

        //计算待返还金额
        $member = $model->member;
        $memberType = MemberType::fileCache();
        $ratio = CJSON::decode($model['distribution_ratio']);
        $inCome = OnlineCalculate::orderIncome($model, $model->orderGoods);
        $return = OnlineCalculate::memberAssign($inCome['surplusAssign'], $member, $ratio['ratio'], $memberType);

        $this->performAjaxValidation($model);
        if (isset($_POST['Order'])) {
            $model->attributes = $_POST['Order'];
            if ($model->validate() && OrderRight::right($model->attributes, $model->refundPrice, $model->rawFreight, $model->obligation,$return['memberIncome'])) {
                @SystemLog::record(Yii::app()->user->name . "订单维权：" . $model->id);
                Yii::app()->user->setFlash('success', Yii::t('order', '订单维权成功！'));
                $this->redirect(array('view', 'id' => $model->id));
            } else {
                Yii::app()->user->setFlash('error', Yii::t('order', '订单异常，维权失败！'));
                $this->refresh();
            }
        }
        $model->obligation = 2;
        $this->render('rightview', array(
            'model' => $model,
            'obligation' => $obligation,
            'returnMoney' => $return['memberIncome']
        ));
    }

    /**
     * 关闭订单
     * @param $id
     * @throws CDbException
     * @throws CHttpException
     * @throws Exception
     */
    public function actionCloseOrder($id){
        
        $this->breadcrumbs = array(Yii::t('order', '订单管理 '), Yii::t('order', '订单关闭'));
        if(!is_numeric($id) ){
            Yii::app()->user->setFlash('error', Yii::t('order', '订单号错误！'));
            $this->redirect($this->createAbsoluteUrl('/order/admin'));
        }
        $model = $this->loadModel($id);
//        if($model->delivery_status != Order::DELIVERY_STATUS_NOT){
//            Yii::app()->user->setFlash('error', Yii::t('order', '订单不是未发货状态，不能关闭！'));
//            $this->redirect($this->createAbsoluteUrl('/order/admin'));
//        }
        $extend_remark = isset($_POST['Order']['extend_remark'])?$this->magicQuotes($_POST['Order']['extend_remark']):'';
        if(trim($extend_remark)){
            $this->checkPostRequest();
            $model->extend_remark = $extend_remark;
            if($model->pay_status == Order::PAY_STATUS_NO ){ //未支付
                $model->status = Order::STATUS_CLOSE;
                $model->close_time = time();
                $trans = Yii::app()->db->beginTransaction(); // 事务执行
                try {
                    if(!$model->update(array('extend_remark','status','close_time'))){
                        throw new Exception(Yii::t('order', '关闭失败'));
                    }
                    if (in_array($model->pay_type, array(Order::PAY_ONLINE_IPS, Order::PAY_ONLINE_UN, Order::PAY_ONLINE_BEST))) {
                        $result = OnlinePayCheck::payCheck($model->parent_code, $model->pay_type, $model->code);
                        if ($result['status']) {
                            throw new Exception(Yii::t('order', '等待订单状态更新中,暂时不能关闭！'));
                        }
                    }
                    $model->rollBackStock(); //库存回滚
                    //如果是红包订单,得把占用的红包金额给还回去
                    if ($model->source_type == Order::SOURCE_TYPE_HB) {
                        $otherPrice = $model->other_price;//红包使用金额
                        MemberAccount::model()->updateCounters(array('money' => $otherPrice), 'member_id=:member_id', array(':member_id' => $model->member_id));
                    }
                    $trans->commit();
                    @SystemLog::record(Yii::app()->user->name . "关闭交易：" . $model->id);
                    Yii::app()->user->setFlash('success', Yii::t('order', '关闭成功!'));
                    $this->redirect($this->createAbsoluteUrl('/order/admin'));
                } catch (Exception $e) {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', Yii::t('order', $e->getMessage()));
                    $this->redirect($this->createAbsoluteUrl('/order/admin'));
                }
            }elseif($model->pay_status == Order::PAY_STATUS_YES){ //已支付
                if(!$model->update(array('extend_remark'))){
                    Yii::app()->user->setFlash('error', Yii::t('order', '关闭失败!'));
                }else {
                    $order = $model->attributes;
                    $member = Yii::app()->db->createCommand()
                        ->select('id,gai_number,type_id,mobile,username')
                        ->from('{{member}}')
                        ->where('id=:id', array(':id' => $order['member_id']))
                        ->queryRow();
                    if ($order['real_price'] < 0) {
                        throw new Exception(Yii::t('order', '关闭失败!'));
                    }
                    $msg = OnlineClose::operate($order, $member);
                    if ($msg['flag']) {
                        //添加操作日志
                        @SystemLog::record(Yii::app()->user->name . "关闭交易：" . $model->id);
                        Yii::app()->user->setFlash('success', Yii::t('order', '关闭成功!'));
                        $this->redirect($this->createAbsoluteUrl('/order/admin'));
                    }else{
                        Yii::app()->user->setFlash('error', Yii::t('order', '关闭失败!').$msg['info']['error']);
                        $this->refresh();
                    }
                }
            }
        }else {
            if($this->isPost()){
                $model->addError('extend_remark',Yii::t('order', '备注不能为空!'));
            }
            $this->render('closeOrder', array('model' => $model));
        }
    }

    /**
     * 取消退货
     * 条件：新订单，退货状态（卖家已经同意退货）
     * @throws CHttpException
     */
    public function  actionCancelReturn(){
        if (!Yii::app()->request->isAjaxRequest) throw new CHttpException(404);
        $model = $this->GetOrderModel($this->getPost('code'), array(
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
    public function GetOrderModel($code,Array $condition = array())
    {
        if (!$code) throw new CHttpException(404);
        /** @var Order $model */
        $models = Order::model()->findAll('code=:code LIMIT 1 FOR UPDATE', array(':code' => $code));
        if (!empty($models)) {
            $model = $models[0];
        } else {
            throw new CHttpException(404, '请求的订单不存在.');
        }
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
