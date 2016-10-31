<?php

class PayResultController extends Controller
{
    public $orderType;
    public $payType;

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $this->breadcrumbs = array(Yii::t('order', '订单管理 '), Yii::t('order', '手动对账'));
        $model = new PayResultForm();
        if (isset($_POST['PayResultForm'])) {
            $model->attributes = $_POST['PayResultForm'];
            $this->orderType = $model->orderType;
            $result = array();
            if($model->source==Order::ORDER_SOURCE_WAP && $model->payType==Order::PAY_ONLINE_UN){
                if($model->orderType!=OnlinePay::ORDER_TYPE_GOODS){
                    throw new CHttpException(404, '订单类型不对，请重新选择！');
                }else{
                $this->payType = OnlinePay::PAY_UNION;
                $result = OnlinePayCheck::orderUinonCheck($model->code);
              }
            }else{
              switch ($model->payType) {
                case Order::PAY_ONLINE_IPS:
                    $this->payType = OnlinePay::PAY_IPS;
                    $result = OnlinePayCheck::payCheck($model->code,Order::PAY_ONLINE_IPS);
                    break;
                case Order::PAY_ONLINE_UN:
                    $this->payType = OnlinePay::PAY_UNION;
                    $result = OnlinePayCheck::payCheck($model->code,Order::PAY_ONLINE_UN , $_POST['PayResultForm']['mainCode']);
                    break;
                case Order::PAY_ONLINE_BEST:
                    $this->payType = OnlinePay::PAY_BEST;
                    $result = OnlinePayCheck::payCheck($model->code,Order::PAY_ONLINE_BEST,$model->mainCode);
                    break;
                case Order::PAY_ONLINE_UM:
                    $this->payType = OnlinePay::PAY_UM;
                    $result = OnlinePayCheck::payCheck($model->code,Order::PAY_ONLINE_UM);
                    break;
                case Order::PAY_ONLINE_TLZF:
                    $this->payType = OnlinePay::PAY_TLZF;
                    $result = OnlinePayCheck::payCheck($model->code,Order::PAY_ONLINE_TLZF,$model->mainCode,$model->orderType,$model->source);
                    break;
                case Order::PAY_ONLINE_TLZFKJ:
                        $this->payType = OnlinePay::PAY_TLZFKJ;
                        $result = OnlinePayCheck::payCheck($model->code,Order::PAY_ONLINE_TLZFKJ,$model->mainCode,$model->orderType,$model->source);
                        break;
                case Order::PAY_ONLINE_GHT:
                    $this->payType = OnlinePay::PAY_GHT;
                    $result = OnlinePayCheck::payCheck($model->code,Order::PAY_ONLINE_GHT);
                    break;
                case Order::PAY_ONLINE_GHTKJ:
                    $this->payType = OnlinePay::PAY_GHTKJ;
                    $result = OnlinePayCheck::payCheck($model->code,Order::PAY_ONLINE_GHTKJ);
                    break;
                case Order::PAY_ONLINE_EBC:
                    $this->payType = OnlinePay::PAY_EBC;
                    $result = OnlinePayCheck::payCheck($model->code,Order::PAY_ONLINE_EBC,'',$model->orderType,$model->source);
                    break;
               case Order::PAY_ONLINE_WEIXIN:
                    $this->payType = OnlinePay::PAY_WAP_WEIXIN;
                   
                    $result = OnlinePayCheck::payCheck($model->code,Order::PAY_ONLINE_WEIXIN,'',$model->orderType,$model->source);
                    
                    if($result && isset($result['trade_state']) && $result['trade_state'] == "SUCCESS"){
                    	$mer_priv = json_decode(base64_decode($result['attach']),true);
                    	$result['status']=true;
                    	$result['gw'] = $mer_priv['gw'];
                    	$result['parentCode'] = $result['out_trade_no'];
                    	$result['code'] = $mer_priv['order_code'];
                    	$result['money'] = bcdiv($result['total_fee'], 100,2);
                    	$result['payTranNo'] = $result['transaction_id'];
                    }else{
                    	$result = false;
                    }
                    break;
            }
              }
            $payResult = $this->_pay($result,$this->payType,$model->code,$model->mainCode);
            if ($payResult===true) {
                $this->setFlash('success', '对账成功');
            } else {
                $this->setFlash('error', '对账失败:' . $payResult);
            }
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 执行对账
     * @param array $result
     * @param int $payType
     * @param string $parentCode 支付单号
     * @param string $mainCode 订单号
     * @return bool|string
     * @throws Exception
     */
    private function _pay($result,$payType,$parentCode,$mainCode){
        $payResult = false;
        if($result && $result['status']==true){

            $order = null;
            if ($this->orderType == PayResultForm::ORDER_TYPE_GOODS) {
                //强制修改支付单号
                if(!empty($mainCode)){
                    $sql = 'update gw_order set parent_code=:pCode WHERE code IN ('.$mainCode.')';
                    Yii::app()->db->createCommand($sql)->bindValue(':pCode',$parentCode)->execute();
                }

                $order = Order::model()->find(array(
                    'select' => 'member_id,code',
                    'condition'=>'parent_code=:code',
                    'params'=>array(':code'=>$parentCode),
                ));

            } else if ($this->orderType == PayResultForm::ORDER_TYPE_HOTEL) {
                //强制修改支付单号
                if(!empty($mainCode)){
                    $sql = 'update gw_hotel_order set parent_code=:pCode WHERE code IN ("'.$mainCode.'")';
                    Yii::app()->db->createCommand($sql)->bindValue(':pCode',$parentCode)->execute();
                }
                
                $order = HotelOrder::model()->find(array(
                    'select' => 'member_id,code',
                    'condition'=>'parent_code=:code',
                    'params'=>array(':code'=>$parentCode),
                ));
            } else if ($this->orderType == PayResultForm::ORDER_TYPE_RECHARGE) {
                //强制修改充值单号
                if(!empty($mainCode)){
                    $sql = 'update gw_recharge set code=:pCode WHERE code IN ('.$mainCode.')';
                    Yii::app()->db->createCommand($sql)->bindValue(':pCode',$parentCode)->execute();
                }
                $order = Recharge::model()->find(array(
                    'select' => 'member_id,code',
                    'condition'=>'code=:code',
                    'params'=>array(':code'=>$parentCode),
                ));

            }
            if ($order) {
                $member = Member::model()->find(array('select' => 'gai_number','condition'=>'id='.$order->member_id));
                $result['gw'] = $member->gai_number;
                $result['parentCode'] = $parentCode;
                $result['code'] = $order['code'];
            } else {
                throw new CHttpException(404, '找不到相关订单');
            }
            //单纯积分充值处理
            if ($this->orderType == PayResultForm::ORDER_TYPE_RECHARGE) {
                $order = Recharge::getOneByCode($result['code']);
                if(!$order) throw new CHttpException(404, '订单已经支付或者找不到相关订单');
                if ($order['money'] == $result['money']) {
                    if (RechargeProcess::operate($order, $result)){
                        $payResult = true;
                    }else{
                        $payResult = '对账失败';
                    }
                }else{
                    $payResult =  '订单金额不对';
                }
            }
            //订单支付处理
            if ($this->orderType == PayResultForm::ORDER_TYPE_GOODS) {
                $data = Order::getOrdersByParentCode($result['parentCode'],$result['code']);
                if(!$data) throw new CHttpException(404, '订单已经支付或者找不到相关订单');
                $payPrice = 0;
                foreach ($data as $order) {
                    $payPrice+=$order['pay_price'];
                }
                $status=Tool::floatcmp($payPrice, $result['money']);
                if ($status || in_array($data[0]['source_type'],array(Order::SOURCE_TYPE_JFXJ,Order::SOURCE_TYPE_SINGLE))) { //如果支付金额等于订单金额，或者是特殊商品的订单
                    if (OnlinePayment::payWithUnionPay($data, $result, $payType)) {
                        $payResult =  true;
                    }else{
                        $payResult =  '订单对账失败';
                    }
                }else{
                    $payResult = '订单金额不对150';
                }
            }
            //酒店订单
            if ($this->orderType == OnlinePay::ORDER_TYPE_HOTEL) {
                $order = HotelOrder::getOrderByCode($result['parentCode'],$result['code']);
                if(!$order) throw new CHttpException(404, '订单已经支付或者找不到相关订单');
                $lotteryPrice = $order['is_lottery'] == HotelOrder::IS_LOTTERY_YES ? $order['lottery_price'] : 0.00; // 抽奖支付金额
                $orderAmount = bcadd($order['total_price'], $lotteryPrice, HotelCalculate::SCALE); // 订单总额
                if ($orderAmount == $result['money']) {
                    if (HotelPayment::payWithThirdParty($order, $result) === true) {
                        $payResult = true;
                    }else{
                        $payResult =  '对账失败';
                    }
                }else{
                    $payResult = '订单金额不对';
                }
            }
        }else{
            $payResult = isset($result['info']) ? $result['info'] : json_encode($result);
        }
        return $payResult;
    }

    /**
     * 异常支付日志列表
     */
    public function actionExceptionPay(){
        $this->breadcrumbs = array(Yii::t('order', '订单管理 '), Yii::t('order', '异常支付'));
        $model=new PayResult('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['PayResult']))
            $model->attributes=$_GET['PayResult'];

        $this->render('exceptionPay',array(
            'model'=>$model,
        ));
    }

    /**
     * 查看日志信息
     * @param $id
     */
    public function actionView($id){
        $this->breadcrumbs = array(Yii::t('order', '订单管理 '), Yii::t('order', '异常支付'));
        $model = PayResult::model()->findByPk($id);
        $this->render('view',array(
            'model'=>$model,
        ));
    }

}
