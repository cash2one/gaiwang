<?php

/**
 * 酒店订单控制器
 * @author wencong.lin <183482670@qq.com>
 */
class OrderController extends Controller {

    /**
     * Action 之前的操作
     * @param CAction $action
     * @return bool
     */
    public function beforeAction($action) {
        if (!$this->getUser()->id) {
            Yii::app()->user->setReturnUrl(Yii::app()->request->hostInfo . Yii::app()->request->getUrl());
            $this->redirect(array('/member/home/login'));
        }
        //设置seo
        $seo = $this->getConfig('seo');
        $this->pageTitle = $seo['hotelTitle'];
        $this->keywords = $seo['hotelKeyword'];
        $this->description = $seo['hotelDescription'];
        return parent::beforeAction($action);
    }

    /**
     * 预定客房
     * @param integer $id 客房ID
     * @throws CHttpException
     * @author jianlin.lin
     */
    public function actionCreate($id)
    {
        // 检查重复提交
        $this->checkPostRequest();

        /** @var HotelOrder $hotelOrder */
        $hotelOrder = new HotelOrder;
        $hotelOrder->reserveRoomId = $id; // 预定的客房ID
        $hotelOrder->rooms = 1; // 初始客房数量
        $memberId = $this->getUser()->id;
        $peoples = array();

        $lodgers = isset($_POST['LodgerInfo']['lodger']) ? $_POST['LodgerInfo']['lodger'] : array(array());
        unset($lodgers['replace']);
        foreach ($lodgers as $i => $lodger) {
            $lid = isset($lodger['id']) ? $lodger['id'] : 0;
            $data = array_merge($lodger, array('member_id' => $memberId));
            /** @var $lodgerModels LodgerInfo */
            $lodgerInfo = new LodgerInfo;
            $lodgerInfo->attributes = $data;
            $findRes = $lodgerInfo->find('member_id = :mid And (id = :id OR token = :token)', array(':mid' => $memberId, ':id' => $lid, ':token' => $lodgerInfo->getTokenStr()));
            if ($findRes !== null) {
                $lodgerModels[$i] = $findRes;
                $lodgerModels[$i]->attributes = $data;
            } else {
                $lodgerModels[$i] = $lodgerInfo;
            }
            if (isset($_POST['LodgerInfo']))
                $peoples[] = $lodgerModels[$i]->dataCompound();
        }
        $hotelOrder->people_infos = $peoples; // 入住信息
        $this->performAjaxValidationTabular($hotelOrder, $lodgerModels, array('name', 'nationality'));

        // 预定的酒店客房信息
        $room = yii::app()->db->createCommand()
            ->select('h.id AS hotel_id, h.thumbnail AS hotel_thumb, h.name AS hotel_name, l.name as level_name, p.name as province_name, c.name as city_name, h.street, h.checkout_time,
             r.id, r.name, r.bed, r.breadfast, r.num, r.unit_price, r.thumbnail, r.content, r.estimate_back_credits, r.activities_price, r.activities_start, r.activities_end, r.gai_income, r.estimate_price')
            ->from('{{hotel_room}} as r')
            ->leftJoin('{{hotel}} as h', 'r.hotel_id = h.id')
            ->leftJoin('{{hotel_level}} as l', 'h.level_id = l.id')
            ->leftJoin('{{region}} as p', 'h.province_id = p.id')
            ->leftJoin('{{region}} as c', 'h.city_id = c.id')
            ->where('r.id = :rid ', array(':rid' => $id))
            ->queryRow();

        if (empty($room))
            throw new CHttpException(400, Yii::t('hotelOrder', '请求的页面不存在！'));
        
        
        $hotelOrder->scenario='checkRooms'; // 设置场景，房间数不能为0
        if (isset($_POST['HotelOrder'])) {
            // 属性赋值
            $hotelOrder->attributes = $this->getPost('HotelOrder');
            $bedId = $hotelOrder->bed;
            // 判断该客房是否在活动期间，是则使用活动特价
            $room['unit_price'] = HotelRoom::isActivity($room['activities_start'], $room['activities_end']) ? $room['activities_price'] : $room['unit_price'];
            $checkInDay = HotelCalculate::liveDays(strtotime($hotelOrder->leave_time), strtotime($hotelOrder->settled_time)); // 入住天数
            $totalPrice = $room['unit_price'] * $hotelOrder->rooms * $checkInDay;
            $hotelOrder->code = Tool::buildOrderNo(22, 'H');
            $hotelOrder->member_id = $memberId;
            $hotelOrder->hotel_id = $room['hotel_id'];
            $hotelOrder->hotel_name = $room['hotel_name'];
            $hotelOrder->room_id = $room['id'];
            $hotelOrder->room_name = $room['name'];
            $hotelOrder->breakfast = HotelRoom::getBreakfast($room['breadfast']);
            $hotelOrder->bed = isset($bedId) ? HotelRoom::getBedRequire($bedId) : HotelRoom::getBed($room['bed']);
            $hotelOrder->unit_price = $room['unit_price'];
            $hotelOrder->unit_gai_price = $room['estimate_price'];
            $hotelOrder->payed_price = 0.00;
            $hotelOrder->unpay_price = $totalPrice;
            $hotelOrder->total_price = $totalPrice;
            $hotelOrder->pay_status = HotelOrder::PAY_STATUS_NO;
            $hotelOrder->status = HotelOrder::STATUS_NEW;
            $hotelOrder->price_radio = $this->getConfig('hotelparams', 'orderRation'); // 酒店参数配置 -> 酒店供价比例
            $hotelOrder->refund_radio = $this->getConfig('hotelparams', 'checkOutFees');
            $hotelOrder->gai_income = $room['gai_income'];
            $hotelOrder->distribution_ratio = CJSON::encode(HotelOrder::getHotelConfigInfo()); // 酒店分配比例
            $hotelOrder->source = HotelOrder::SOURCE_WEB;

            // 模型验证
            $valid = $hotelOrder->validate();
            foreach($lodgerModels as $i => $item) {
                $tabularValid = $lodgerModels[$i]->validate();
                if (!$tabularValid)
                    $valid = $tabularValid;
            }

            // 数据保存
            if($valid && $hotelOrder->save(false)) {
                /** @var $lodger LodgerInfo */
                foreach ($lodgerModels as $lodger) {
                    if (!$lodger->isNewRecord) {
                        if ($lodger->getTokenStr() == $lodger->token)
                            continue;
                    }
                    $lodger->save(false);
                }
                $this->redirect(array('pay', 'code' => $hotelOrder->code));
            }
            $hotelOrder->bed = $bedId;
        }

        // 过往房客信息
        $criteria = array(
            'select' => 'id, name, more',
            'condition' => 'member_id = :mid', 'order' => 'id desc', 'group'=>'name','limit' => 10,
            'params' => array(':mid' => $memberId)
        );
        $pastGuests = LodgerInfo::model()->findAll($criteria);

        $this->pageTitle = Yii::t('hotelOrder', '客房预定') . '_' . $this->pageTitle;
        $this->render('create', array(
            'room' => $room,
            'model' => $hotelOrder,
            'lodgerModels' => $lodgerModels,
            'pastGuests' => $pastGuests
        ));
    }

    /**
     * 预定酒店入住详细
     * @throws CHttpException
     * @author jianlin.lin
     */
    public function actionCheckingInDetail()
    {
        // 不是AJAX请求则抛出异常
        if (!Yii::app()->request->isAjaxRequest)
            throw new CHttpException(400, Yii::t('hotelOrder', '请求的页面不存在！'));

        $room_id = base64_decode($this->getParam('room_id'));
        $room = yii::app()->db->createCommand()
            ->select('unit_price, estimate_back_credits, activities_start, activities_end, activities_price')
            ->from('{{hotel_room}}')
            ->where('id = :rid ', array(':rid' => $room_id))
            ->queryRow();

        if (empty($room))
            throw new CHttpException(400, Yii::t('hotelOrder', '没有数据！'));

        $settledTime = strtotime($this->getParam('settled_time', null)); // 入住时间
        $leaveTime = strtotime($this->getParam('leave_time', null)); // 离店时间
        $requestCount = (int) $this->getParam('room_count', 1);
        $roomCount = $requestCount ? $requestCount : 1;

        if ($settledTime === false && $leaveTime === false) {
            $settledTime = strtotime(date('Y-m-d'));
            $leaveTime = strtotime(date('Y-m-d') . " + 1day");
        } else if ($settledTime > $leaveTime || $settledTime == $leaveTime) {
            $settledTime = strtotime(date('Y-m-d', $settledTime));
            $leaveTime = strtotime(date('Y-m-d', $settledTime) . " + 1day");
        } else if ($settledTime === false) {
            $leaveTime = strtotime(date('Y-m-d', $leaveTime));
            $settledTime = strtotime(date('Y-m-d', $leaveTime) . " - 1day");
        }
        $liveDays = HotelCalculate::liveDays($leaveTime, $settledTime);

        // 如果是特价活动期间的客房，则用特价，否则用原价
        $room['unit_price'] = HotelRoom::isActivity($room['activities_start'], $room['activities_end']) ? $room['activities_price'] : $room['unit_price'];
        $unitPrice = Common::rateConvert($room['unit_price']);

        $msg['result'] = 'succeed';
        $msg['room_count'] = $roomCount;
        $msg['unit_price'] = $unitPrice;
        $msg['total_price'] = $unitPrice * $roomCount * $liveDays;
        $msg['refund'] = $room['estimate_back_credits'] * $roomCount * $liveDays;
        $msg['settled_time'] = date('Y-m-d', $settledTime);
        $msg['leave_time'] = date('Y-m-d', $leaveTime);
        echo CJSON::encode($msg);
    }

    /**
     * 酒店订单支付
     * @param string $code 订单号
     * @throws CHttpException
     */
    public function actionPay($code)
    {
        $this->checkPostRequest();  //检查重复提交
        $sql = "SELECT * FROM {{hotel_order}} WHERE code = :code And member_id = :mid And status = :status And pay_status = :payStatus FOR UPDATE";
        /** @var HotelOrder $model 酒店订单实例 */
        $model = HotelOrder::model()->findBySql($sql, array(
            ':code' => $code, ':mid' => Yii::app()->user->id, ':status' => HotelOrder::STATUS_NEW, ':payStatus' => HotelOrder::PAY_STATUS_NO)
        );
        // 数据异常抛出错误
        if ($model == null) {
        	throw new CHttpException(404, Yii::t('hotelOrder', '找不到该订单数据！'));
        }

        $model->setScenario('orderPay');
        $model->attributes = $this->getPost('HotelOrder');
        $model->lottery_price = 0;  // 抽奖支付金额
        $model->lottery_radio = 0;  // 中奖的比率
        $member = $model->member;   // 会员属性

        // 如果抽奖
        if ($model->is_lottery == HotelOrder::IS_LOTTERY_YES) {
            $lotteryPayIntegral = $this->getConfig('hotelparams', 'luckRation'); // 抽奖支付积分
            $model->lottery_price = Common::reverseSingle($lotteryPayIntegral, $member->type_id); // 参与抽奖要支付的金额
            $model->lottery_radio = $this->getConfig('hotelparams', 'luckMoneyRation'); // 中奖比率
        }

        $orderPay = new OrderPayForm;
        $orderPay->payWay = OnlinePay::PAY_WAP_INTEGRAL;
        $orderPay->attributes = $this->getPost('OrderPayForm');

        // 订单总额
        $orderAmount = bcadd($model->total_price, $model->lottery_price, HotelCalculate::SCALE);
        $orderPay->orderAmount = $orderAmount;
        $orderPay->balance = AccountBalance::getAccountAllBalance($member->gai_number, AccountInfo::TYPE_CONSUME);

        $this->performAjaxValidation(array($model, $orderPay));

        // ajax 获取支付详细信息
        if (Yii::app()->request->isAjaxRequest) {
            $lottery = $this->getQuery('isLottery', null);
            if (!is_null($lottery)) {
                $model->is_lottery = $lottery;
                $details = $model->paymentDetails();
                echo CJSON::encode($details);
            }
            Yii::app()->end();
        }

        if (isset($_POST['HotelOrder']))
        {
            //快捷支付
            if(isset($_POST['quickPay']) && $orderPay->payWay != OnlinePay::PAY_WAP_INTEGRAL){
                $orderPay->payWay = $this->getPost('quickPay');
            }
            $model->pay_type = $orderPay->payWay;
            $model->parent_code = Tool::buildOrderNo(19, 8);
            // 保存订单数据
            if ($model->save())
            {
                //如果使用积分支付，必须验证密码
                if($orderPay->payWay == OnlinePay::PAY_WAP_INTEGRAL){
                    $orderPay->needPassword = 1;
                }
                if ($orderPay->validate()) {
                    // 选择支付方式
                    if ($orderPay->payWay == OnlinePay::PAY_WAP_INTEGRAL) {
                        $result = HotelPayment::payWithIntegration($model->attributes, $member->attributes);
                        $this->redirect(array('/hotel/order/view', 'code' => $model->code, 'result' => $result === true ? 'succeed' : 'error'));
                    } else {
                        if(isset($_POST['quickPay'])){
                            //获取getTradeNo
                            $param = array(
                                'orderType'=>OnlinePay::ORDER_TYPE_HOTEL,
                                'code'=>$model->code,
                                'parentCode'=>$model->parent_code,
                                'money'=>$orderAmount,
                                'goods_inf'=>$this->getUser()->gw,
                                'orderDate'=>date('Ymd'),
                                'backUrl'=>$this->createAbsoluteUrl('order/onlinePayResult'),
                            );
                            $tradeNo = OnlinePay::getUmTradeNo($param);

                            $this->redirect(array('order/quickPayShow',
                                'pay_type'=>$model->pay_type,
                                'code'=>$model->parent_code,
                                'money'=>$orderAmount,
                                'tradeNo'=>$tradeNo,
                                'quickPay'=>$_POST['OrderPayForm']['payWay']
                            ));
                        }
                        //  网银支付
                        //通联支付需要订单创建的时间，用于对账
                        $createTime='';
                        if($orderPay->payWay == OnlinePay::PAY_TLZF){
                             $TimeArr=HotelOrder::model()->find(array(
                              'select'=>'create_time',
                              'condition'=>'parent_code=:parent_code AND code=:code',
                              'params'=>array(':parent_code'=>$model->parent_code,':code'=>$code)
                          ));
                            $createTime=$TimeArr->create_time;
                        } 
                        $msg = OnlinePay::checkInterface($orderPay->payWay);
                        if ($msg) throw new CHttpException(503, $msg);
                        OnlinePay::redirectToPayShow('order/payShow', $orderPay->payWay,$code , $orderAmount ,$model->parent_code,$createTime);
                    }
                }
            }
        }
        // 参数
        $this->pageTitle = Yii::t('hotelOrder', '订单支付') . '_' . $this->pageTitle;
        $payDetail = $model->paymentDetails();
        $params['luckRation'] = $this->getConfig('hotelparams', 'luckRation'); // 抽奖支付积分
        $params['freightQQ'] = $this->getConfig('freightlink', 'freightQQ'); // 客服QQ
        $params['hotelServiceTel'] = $this->getConfig('hotelparams', 'hotelServiceTel'); // 酒店服务电话
        $this->render('pay', array(
            'model' => $model,
            'orderPay' => $orderPay,
            'payDetail' => $payDetail,
            'params' => $params
        ));
    }

    /**
     * 支付完成后显示
     * @param $code
     * @param $result
     * @throws CHttpException
     */
    public function actionView($code, $result)
    {
        $order = yii::app()->db->createCommand()
            ->select('id, code, unit_price, total_price, is_lottery, lottery_price')
            ->from('{{hotel_order}}')
            ->where('code = :code', array(':code' => $code))
            ->queryRow();

        if (empty($order))
            throw new CHttpException(404, Yii::t('hotelOrder', '您支付的订单不存在！'));
        //取客服配置
        $fr_config = $this->getConfig('freightlink');

        $this->render('view', array(
            'order' => $order,
            'result' => $result,
            'fr_config' => $fr_config,
        ));
    }

    /**
     * 确认支付平台
     */
    public function actionPayShow()
    {
        //$this->layout='//layouts/main';
        $this->pageTitle = Yii::t('hotelOrder','确认支付平台') . '_' . $this->pageTitle;
        $params = array(
            'backUrl' => 'order/onlinePayResult',
            'orderDesc' => '酒店订单',
            'checkUrl' => 'order/check',
            'orderType' => OnlinePay::ORDER_TYPE_HOTEL,
        );
        $this->render('application.views.layouts.payshow', $params);
    }

    /**
     * 接收在线支付返回结果
     */
    public function actionOnlinePayResult()
    {
        $this->pageTitle = Yii::t('hotelOrder', '在线支付结果') . $this->pageTitle;
        $result = array();//支付结果
        $content = array();
        if (isset($_POST['SystemSSN'])) {
            //银联
            $result = OnlinePay::unionPayCheck();
        } else if (isset($_GET['ipsbillno'])) {
            //环迅支付
            $result = OnlinePay::ipsPayCheck();
        } else if (isset($_POST['UPTRANSEQ'])) {
            //翼支付
            $result = OnlinePay::bestPayCheck();
        } else if (isset($_POST['encryStr'])) {
            //汇卡支付
            $result = OnlinePay::hiPayCheck();
        }else if(isset($_POST['mer_priv']) || isset($_GET['mer_priv'])){
            $result = OnlinePay::umPayCheck();
        }else if(isset($_POST['payResult']) && $_POST['payResult']==1){
            //通联支付    
            $result = OnlinePay::tlzfPayCheck();
        }else if(isset($_GET['pay_result']) && $_GET['pay_result']==1){
            //高汇通支付    
            $result = OnlinePay::ghtPayCheck();
        }
        else{
            $result['money'] = $this->getParam('money');
            if(!$this->getParam('ok')){
                $result['errorMsg'] = '支付失败';
            }
        }
        $this->render('application.views.layouts.payresult', array('result' => $result, 'payAccount' => Common::convertSingle($result['money'])));
    }

    /**
     * 检查订单是否已经支付
     * @param $code
     * @param $money
     */
    public function actionCheck($code, $money)
    {
        $result = array();
        $order = Yii::app()->db->createCommand()->select('code, pay_status')->where('code="'.$code.'"')->from('{{hotel_order}}')->queryRow();
        if ($order) {
            $result['money'] = $money;
            if ($order['pay_status'] == HotelOrder::PAY_STATUS_NO) {
                $result['errorMsg'] = Yii::t('hotelOrder', '您的订单:{code} 还未支付', array('{code}' => $order['code']));
            }
        }
        $this->render('application.views.layouts.payresult', array('result' => $result, 'payAccount' => Common::convertSingle($money)));
    }

    /**
     * 通用的ajax表单验证
     * @param CModel $model
     * @param CModel $models
     * @param array $validateAttribitus
     * @author jianlin.lin
     */
    protected function performAjaxValidationTabular($model, $models, $validateAttribitus) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $this->id . '-form') {
            $error = CActiveForm::validate($model);
            if (!empty($models)) {
                $tErr = CActiveForm::validateTabular($models, $validateAttribitus, false);
                $tArr = CJSON::decode($tErr, true);
                $modelName = CHtml::modelName(LodgerInfo::model());
                foreach ($validateAttribitus as $attribute) {
                    foreach ($tArr as $eid => $err) {
                        if (strpos($eid, $attribute) !== false) {
                            $id = str_replace($modelName, "{$modelName}_lodger", $eid);
                            $tArr[$id] = $err;
                            unset($tArr[$eid]);
                        }
                    }
                }
                $merge = array_merge(CJSON::decode($error, true), $tArr);
                $error = CJSON::encode($merge);
            }
            echo $error;
            Yii::app()->end();
        }
    }

    /**
     * 快捷支付验证
     * @throws CHttpException
     */
    public function actionQuickPayShow(){
        $this->pageTitle = Yii::t('hotelOrder','快捷支付验证_') . $this->pageTitle;
        /** @var PayAgreement $model */
        $model = PayAgreement::model()->findByPk($this->getParam('quickPay'));
        if(!$model || $model->gw!=$this->getUser()->gw){
            throw new CHttpException(403,'快捷支付数据有误');
        }
        if(isset($_POST['verifyCode'])){
            $param = array(
                'gw'=>$this->getUser()->gw,
                'tradeNo'=>$this->getParam('tradeNo'),
                'verify_code'=>$this->getPost('verifyCode'),
                'busi_agreement_id'=>$model->busi_agreement_id,
                'pay_agreement_id'=>$model->pay_agreement_id,
            );
            $result = OnlinePay::checkUmVerifyCode($param);
            if($result===true){
                $this->redirect($this->createAbsoluteUrl('order/onlinePayResult',array('money'=>$this->getParam('money'),'ok'=>1)));
            }else{
                $this->setFlash('error',Yii::t('hotelOrder','支付失败:').$result);
            }
        }
        $this->render('application.views.layouts.quickPayShow',array('model'=>$model));
    }
    /**
     * 获取快捷支付验证码
     */
    public function actionGetQuickPayCode(){
        if($this->isAjax()){
            $param = array(
                'tradeNo'=>$this->getPost('tradeNo'),
                'gw'=>$this->getUser()->gw,
                'busi_agreement_id'=>$this->getPost('usr_busi_agreement_id'),
                'pay_agreement_id'=>$this->getPost('usr_pay_agreement_id'),
            );
            if(OnlinePay::getUmVerifyCode($param)){
                echo 'success';
            }
        }
    }
}
