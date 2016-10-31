<?php

/**
 * 订单流程控制器(显示订单信息,核对订单,支付订单,支付成功后的操作)
 * @author wyee <yanjie@gatewang.com>
 */
class OrderConfirmController extends WController
{
    public $layout = false;
    public $defaultAction = 'pay';
    public $uid; //会员id
    public $member; //会员信息
    public $orderId; //订单id
    public $freightInfo = array(); //运费模板信息
    public $freight = array(); //每种运费模板对应城市的运费


    public function beforeAction($action)
    {
        $this->uid = $this->getUser()->id;
        $this->orderId = isset($_GET['orderId']) ? $this->getQuery('orderId') : '';
        if (!$this->uid) {
            $this->redirect(array('home/logout'));
        }
        $this->member = Member::model()->findByPk($this->uid);
        return parent::beforeAction($action);
    }

    /**
     * 处理订单支付流程
     */
    public function actionPay()
    {
        $code = isset($_GET['code']) ? $this->getQuery('code') : '';
        if (empty($code)) {
            $orderModel = Order::model()->findByPk($this->orderId, array('select' => 'code'));
             if(!empty($orderModel)){
                $code = $orderModel->code;
                    }else{
                        throw new CHttpException(503, '订单号异常');
                    }
        }
        $result = $this->_checkOrder($code);
        $orders = $result['orders'];
        $totalPrice = $result['totalPrice'];
        $sourceType = $result['sourceType'];
        $isMoneyPay=$result['isMoneyPay'];

        // 订单表单
        $model = new OrderForm;
        $member = $this->member;
        $model->mobile = $member->mobile;
        $memberArray = array(
            'id' => $member['id'],
            'gai_number' => $member['gai_number'],
            'type_id' => $member['type_id'],
            'mobile' => $member['mobile'],
            'username' => $member['username'],
            'account_id' => $member['id'],
            'type' => AccountInfo::TYPE_CONSUME,
        );
        //当前会员余额(旧余额+新余额)
        $model->balance = AccountBalance::findRecord($memberArray, true); //会员消费账户
        $model->balanceHistory = AccountBalanceHistory::findRecord($memberArray, true); //会员历史消费账户
        if ($model->balanceHistory) {
            $model->accountMoney = $model->balanceHistory['today_amount'] + $model->balance['today_amount'];
        } else {
            $model->accountMoney = $model->balance['today_amount'];
        }
        $model->totalPrice = $totalPrice;
        $singlePayDetail = $model->singlePayDetail();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        // 支付表单提交
        if (isset($_POST['OrderForm'])) {
            $model->attributes = $this->getPost('OrderForm');
            if($model->payType==''){
                 throw new CHttpException(403,Yii::t('order', '您未选择支付方式，请先选择支付方式'));
              }
            //为了在线支付、代扣生成一个额外的流水号
            $parentCode = Tool::buildOrderNo(19, 8);
            $jf_price=0;
            foreach ($orders as $v) {
                //如果是再次支付，需要检查是否已经网银支付
                if(!empty($v['parent_code']) && ($v['pay_type']!=Order::PAY_TYPE_NO || $v['pay_type']!=Order::PAY_TYPE_JF)){
                     if($v['pay_type']==Order::PAY_ONLINE_UN){
                            $result = OnlinePayCheck::orderUinonCheck($v['parent_code'],$v['code'],OnlineWapPay::ORDER_TYPE_GOODS);
                      }else{ 
                            $result = OnlinePayCheck::payCheck($v['parent_code'], $v['pay_type'],$v['code'],OnlineWapPay::ORDER_TYPE_GOODS,$v['source']);
                            }
                    if (isset($result['status']) && $result['status']) {
                        throw new CHttpException(403,Yii::t('order', '您的订单已经支付，等待订单状态更新中'));
                    }
                } 
                   if($model->payType == 'JF'){
                      $pay_type=Order::PAY_TYPE_JF;
                      $jf_price=$totalPrice;
                   }else if($model->payType==OnlineWapPay::PAY_WAP_UNION){
                      $pay_type=Order::PAY_ONLINE_UN;
                    }else{
                      $pay_type=OnlinePayment::getPayType($model->payType);
                   }
                $res = Yii::app()->db->createCommand()->update('{{order}}', array(
                        'parent_code' => $parentCode,
                        'pay_type' =>$pay_type,
                		'jf_price' => $jf_price
                ), 'id=:id', array(':id' => $v->id));
                if(!$res) throw new CHttpException(503,'更新订单失败');
            }
            
            if($model->payType == 'JF') { // 积分支付
                //获取历史余额代扣金额
                OnlinePayment::payWithJF($orders, $totalPrice, $model->balance, $model->balanceHistory, $memberArray, $parentCode);
                $this->render('payok', array('payAccountJF' => Common::convertSingle($totalPrice, $memberArray['type_id']), 'payAccount' => $totalPrice, 'code' => $code));
                Yii::app()->end();
            }else{
                    //在线支付
                    $msg = OnlineWapPay::checkInterface($model->payType);
                    if ($msg) throw new CHttpException(503, $msg);
                    //如果是特殊商品，则支付部分
                    if($sourceType==Order::SOURCE_TYPE_SINGLE){
                        $totalPrice = isset($_POST['OrderForm']['jfPay']) ? $singlePayDetail['onlinePay'] : $totalPrice;
                    }
               if($model->payType == OnlineWapPay::PAY_UM_QUICK){
                        $param=array(
                                'service'=>'pay_req_shortcut',
                                'code' => $code,
                                'money' => $totalPrice,
                                'backUrl' => $this->createAbsoluteUrl('orderConfirm/onlinePayResult'),
                                'parentCode' => $parentCode,
                                'orderDate' => date('Ymd'),
                                'orderType' => OnlineWapPay::ORDER_TYPE_GOODS,
                        );
                        $resArr=OnlineWapPay::getTradeNo($param);
                        $rescode=$resArr['ret_code'];
                        $tradeno=$resArr['trade_no'];
                   if($rescode!=0000 || empty($tradeno)){
                       throw new CHttpException(503, '快捷支付参数有误！！！');
                   }else{
                       $gw=Yii::app()->user->gw;
                       $payAgreen=PayAgreement::getCardList($gw,PayAgreement::PAY_TYPE_UM);
                       if(empty($payAgreen)){
                           $url=UM_YIHTMLPAY_URL.'?tradeNo='.$tradeno.'&merCustId='.$gw;
                           header("Location:$url");
                       }else{
                            $this->render('umQuickBank', array('agr'=>$payAgreen,'tradeNo'=>$tradeno,'money'=>$totalPrice));
                         }
                       exit();
                   }
               } else if($model->payType == OnlinePay::PAY_GHT_QUICK){ //高汇通快捷支付
                    $param = array(
                            'parendCode'=>$parentCode,
                            'backUrl' =>'',
                            'amount' => $totalPrice,
                            'code' => $code,
                            'orderType' => OnlineWapPay::ORDER_TYPE_GOODS,
                        );
                    $gw = Yii::app()->user->gw;
                    $cardList = PayAgreement::getCardList($gw,  PayAgreement::PAY_TYPE_GHT);
                    if(empty($cardList)) throw new CHttpException (403,'请先绑卡再支付');
                    $this->render('ghtQuickBank',array('agr'=>$cardList,'money'=>$totalPrice,'parentCode'=>$parentCode));
                    Yii::app()->end();
               }else{ 
                    OnlineWapPay::redirectToPayShow('orderConfirm/payShow', $model->payType, $orders[0]['code'] , $totalPrice,$parentCode); //跳转到支付确认页面
                }
            }
        }

        $frConfig = $this->getConfig('freightlink');
        $frPhone = $this->getConfig('site', 'phone');
        $this->render('pay', array(
            'totalPrice' => $totalPrice,
            'model' => $model,
            'member' => $this->member,
            'sourceType' => $sourceType,
            'accountMoney' => $model->accountMoney,
            'isMoneyPay' =>$isMoneyPay,   
        ));
    }
    
    /**
     * 直接购买时-确认订单
     */
    public function actionIndex()
    {
        $goodsId = $this->getPost('g_id');
        $specId = $this->getPost('spec_id');
        $quantity = $this->getPost('number');
        if(empty($goodsId) && empty($specId) && empty($quantity)){
            if(isset($_GET['quantity']) && isset($_GET['goods'])){
                $gs_id = $this->getQuery('goods');
                $arr = explode('-', $gs_id);
                $goodsId = $arr[0];
                $specId = $arr[1];
                $quantity = $this->getQuery('quantity');
            }
        }
        $model = GoodsSpec::model()->findByPk($specId,array('select' => 'spec_name,spec_value'));
        $goodsSpec = array();
        if(!empty($model->spec_name) && !empty($model->spec_value)){
            $goodsSpec = array_combine($model->spec_name,$model->spec_value);
        }
        $goodsInfo = Goods::getGoodsInfo($goodsId,$quantity,$specId);//商品信息
        $gs = $goodsId . '-' . $specId;
        $buyGoods[] = $gs;
        $address = Address::getMemberAddress($this->getUser()->id);
        //判断地址  否则跳转到地址页面
        if (empty($address)) {
            $this->setFlash('message', Yii::t('member', '请先设置收货地址'));
            $this->redirect(array('address/create','goods' => $gs,'quantity' => $quantity));
        }
        //设置收货地址session
        foreach ($address as $k => $v) {
            if ($v['default']) {
                $this->setSession('default_address', array('id' => $v['id'], 'city_id' => $v['city_id']));
            }
        }
        $redAccount = $this->_getRedAccount($goodsInfo); //获取红包账户余额及订单可用红包信息
        $this->freightInfo = $goodsInfo['freightInfo']; //运费相关信息
        $select_address = $this->getSession('select_address');
        $default_address =  $this->getSession('default_address');
        if(!empty($select_address)){
            $this->setSession('default_address',null);
            $default_address = $this->getSession('default_address');
        }
        $address = !empty($select_address) ? $select_address : $default_address;
        $freight = $this->_computeFreight($address['city_id']); //运费计算
        $goodsPrice = 0;
        if(!empty($goodsInfo['goodsInfo']['storeAllPrice'] )){
            foreach($goodsInfo['goodsInfo']['storeAllPrice'] as $price){
                $goodsPrice += $price;
            }
        }
        $this->render('index', array(
            'gs' => $gs,
            'goods' => $goodsInfo,
            'address' => $address,
            'goodsSpec' => $goodsSpec,
            'quantity' => $quantity,
            'redAccount' => $redAccount,
            'freight' => $freight,
            'goodsId' => $goodsId,
            'allTotalPrice' => $goodsPrice,
            'buyGoods' => $buyGoods,
        ));
    }

    public function actionOrder()
    {
        //订单商品数组 goods_id - spec_id
        $buy_goods = unserialize(Tool::authcode($this->getPost('goods'), 'DECODE'));
        $gsArr  = explode('-',$buy_goods[0]);
        $goodsId = $gsArr[0];
        $specId = $gsArr[1];
        $quantity  = $this->getPost('quantity');
        if (empty($buy_goods)) throw new CHttpException(503, Yii::t('cart', '请重新购买'));
        //收货地址
        $address = Address::getAddressById($this->getPost('address'));
        if (empty($address)) throw new CHttpException(503, Yii::t('cart', '收货地址为空'));
        //所有结算商品的运费方式
        $freight_array = unserialize(Tool::authcode($this->getPost('freight_array'), 'DECODE'));
        //会员所选的运费方式
        $freight = $this->getPost('freight');
        //购物车所选商品
        $goodsInfo = Goods::getGoodsInfo($goodsId,$quantity,$specId, ' for update');
        $redAccount = $this->_getRedAccount($goodsInfo); //检查红包账户余额是否够支付订单
        $useRedMoneyInfo = $redAccount['use_red_money'];
        //生成订单操作
        $orderFlow = new QuickOrder();
        $info = array('freight_array' => $freight_array, 'freight' => $freight, 'useRedMoneyInfo' => $useRedMoneyInfo);
        $orderCode = $orderFlow->createOrder($goodsInfo, $address, $info);
        if (!empty($orderCode)) {
            $this->redirect(array('orderConfirm/pay', 'code' => implode(',', $orderCode)));
        } else {
            throw new CHttpException(503, '生成订单失败');
        }
    }

   /**
     * 银行支付-确认支付平台
     */
    public function actionPayShow()
    {
        OnlinePay::checkMoney();
        $this->pageTitle = '确认支付平台_' . $this->pageTitle;
        $params = array(
            'backUrl' => 'orderConfirm/onlinePayResult',
            'orderDesc' => '商品订单',
            'checkUrl' => 'orderConfirm/check',
            'orderType' => OnlineWapPay::ORDER_TYPE_GOODS,
        );
        $this->render('bankpay', $params);
    }
    
    /**
     * 联动优势支付-(U一键支付)
     */
    public function actionUmQuickPay()
    {
        $this->pageTitle = 'U支付平台_' . $this->pageTitle; 
        $tradeNo = $this->getParam('tradeNo');
        $gw=$this->getParam('gw');
        $payAgreen=PayAgreement::model()->findAll(array(
        'condition' => 'gw = :gw',
        'params' => array(':gw' => Yii::app()->user->gw),
      ));
		$this->render('umQuickBank', array('agr'=>$payAgreen,'tradeNo'=>$tradeNo));
    }
    
    /**
     * 联动优势支付-(U一键协议支付)处理数据
     */
    public function actionAgreementPay()
    {
        //提交支付信息操作
        if($this->getParam("flag")==2){ //U付快捷支付
              $bankArr=$_POST;
              $bankArr['paygw']=$this->getUser()->gw;
              $resArr=OnlineWapPay::bankConfirm($bankArr);
              $resArr['money'] = sprintf('%0.2f', $resArr['amount'] / 100);
              if(isset($resArr['ret_code']) && $resArr['ret_code']=='0000'){
                   $this->render('umQuickOk', array('result'=>$resArr));
              }else{
                   $resArr['errorMsg']="很遗憾！您的付款失败<br />(".$resArr['ret_msg'].")";
                   $this->render('umQuickOk', array('result'=>$resArr));
              }       
          } elseif ($this->getParam('flag') == OnlinePay::PAY_GHT_QUICK){ //高汇通支付
            OnlinePay::checkMoney(); //验证通过
            $info = array();
            $info['amount'] = (float)$this->getParam('money') * 100; //支付金额
            $info['reqMsgId'] = $this->getParam('parentCode'); //流水号
            $info['messageId'] = $this->getParam('vericode'); //验证码
            $info['messageCode'] = $this->getParam('reqMsgId'); // 短信流水号
            $cardId = $this->getParam('cardId'); 
            $info['bindId'] = PayAgreement::model()->findByPk($cardId)->bindid; //绑卡ID
            $info['userId'] = Yii::app()->getUser()->gw; // 支付用户
            $info['productName'] = '盖象支付产品';
            $ghtPay = new GhtPay;
            $xmlData = $ghtPay->set_data($info, 'pay');
//            var_dump($xmlData);exit;
//        print_r($xmlData);
            $key = substr(Tool::buildOrderNo(19), 0, 16); //对称密钥
            $encryptData = GhtPay::encrypt($xmlData, $key); //
            $encryptKey = GhtPay::rsaEncrypt($key);
            $signData = GhtPay::create_sign($xmlData);
            $postData=array(
                'encryptData'=>$encryptData,
                'encryptKey'=>$encryptKey,
                'merchantId'=> GHT_QUICK_PAY_MERCHANTID,
                'signData'=>$signData,
                'tranCode'=> $ghtPay->payType['pay'],
                'callBack'=>'http://www.gnet-mall.net/reslog/log'
            );
            $httpsUrl = new HttpClient('http','8081');
            $result = $httpsUrl->quickPost(GHT_QUICK_PAY_URL,$postData);
            var_dump($result);
            var_dump($_REQUEST);exit;
            Yii::app()->end();
          }
          else{
            //获取手机验证码操作，需在提交页面做判断
            if ($this->isAjax()){
                $msg=$_POST;
                $msg['paygw']=$this->getUser()->gw;
                $vericode=OnlineWapPay::getVericode($msg);
                if(isset($vericode['ret_code']) && $vericode['ret_code']=='0000'){
                     echo "success";
                     exit;
                  }
            }
            if($this->getParam('type') == PayAgreement::PAY_TYPE_GHT){
                $this->render('ghtAgreePay');
                Yii::app()->end();
            }
            $this->render('umAgreePay');
        }
        
    }
    
    
    
    /**
     * 接收在线支付返回结果
     */
    public function actionOnlinePayResult()
    {
        $this->pageTitle = Yii::t('order', '在线支付结果') . $this->pageTitle;
        $result = array();//支付结果
        $content = array();
        if (isset($_POST['UPTRANSEQ'])) {
            //翼支付
           $result = OnlineWapPay::bestPayCheck();
        }else if(isset($_GET['error_code']) && $_GET['error_code']==0000){
           //联动优势支付（U支付）
          $result = OnlineWapPay::umPayCheck(); 
       }else if(isset($_POST['payResult']) && $_POST['payResult']==1){
           //通联支付
          $result = OnlineWapPay::tlzfPayCheck(); 
       }else if(isset($_POST['respCode'])){
           //银联支付 
          $result=OnlineWapPay::unionFrontPayCheck(); 
       }
       else{
              $result['errorMsg']="无法接受银行返回的信息！";
         }     
        $this->render('payok', array('result' => $result,'payAccount' => $result['money'],'code'=>$this->getParam('code')?$this->getParam('code'):$result['code']));
    }
    
    /**
     * 检查订单状态
     * @param $code
     * @param $money
     */
    public function actionCheck($code, $money)
    {
        $orders = Yii::app()->db->createCommand()->select('id')
        ->from("{{order}}")
        ->where('code=:code and pay_status=:status', array(':code' => $code, ':status' => Order::PAY_STATUS_YES))
        ->queryRow();
        $result = array();
        if (!$orders) {
            $result['errorMsg'] = '您的订单还未支付';
        }
        if ($this->isAjax()) {
            echo json_encode($result);
        } else {
            $this->render('payok', array('result' => $result,'payAccount' => $money));
        }
    }

    /**
     * 验证订单有效性,并返回订单、相关商品数据
     * @param string $code
     * @throws CHttpException
     * @return array
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    private function _checkOrder($code)
    {
        $codes = explode(',', $code);
        $criteria = new CDbCriteria;
        $criteria->select = 'id, code, pay_type, source, parent_code, pay_price, real_price, pay_status,source_type,consignee,mobile,address,other_price,member_id';
        $criteria->addInCondition('t.code', $codes);
        $criteria->compare('t.member_id', $this->uid);
        $criteria->compare('t.status', Order::STATUS_NEW);
        $criteria->with = array(
            'orderGoods' => array('select' => 'id, goods_id, goods_name, gai_price, unit_price, spec_id,quantity,activity_ratio,ratio,integral_ratio,special_topic_category,rules_setting_id'),
            'store' => array('select' => 'id, name, referrals_id'),
            'stockLog' => array('select' => 'id')
        );
        $orders = Order::model()->findAll($criteria);
        if (count($orders) > ShopCart::MAX_NUM_LIMIT) {
            throw new CHttpException(503, '一次支付订单超过' . ShopCart::MAX_NUM_LIMIT . '个');
        }
        $totalPrice = 0;
        $flowTableName = AccountFlow::monthTable(); //流水日志表名
        //订单类型
        $sourceTypes = array();
        $isMoneyPay=false;//积分支付
        /** @var Order $order */
        foreach ($orders as $order) {
            if ($order['pay_status'] == Order::PAY_STATUS_YES) {
                throw new CHttpException(503, Yii::t('order', '您的订单：{code}已经支付', array('{code}' => $order['code'])));
            }
            
            //20160815 出现负数订单，在此处多加判断
            if($order->pay_price <= 0){
            	throw new CHttpException(404, '订单商品价格异常');
            } 
            
            $sourceTypes[] = $order['source_type'];
            $totalPrice += $order->pay_price;
            $stockLog = $order->stockLog;
            foreach ($order->orderGoods as $orderGoods){
                /*是否是秒杀商品和积分现金商品*/
                 if($orderGoods->special_topic_category>0 || $orderGoods->rules_setting_id>0){
                    throw new CHttpException(404, '请到PC端付款！');
                } 
                //订单商品价格检查
                if($orderGoods->gai_price > $orderGoods->unit_price){
                    throw new CHttpException(404, '订单商品价格异常');
                }
                //当积分支付比例大于100时，用现金支付 
                if($orderGoods->integral_ratio > 100){
                    $isMoneyPay=true;
                }
                
                //订单库存检查,如果 stock_log库存日志有相关数据，说明订单支付前，库存已经回滚了
                if ($stockLog) {
                    $goodsSpec = GoodsSpec::model()->find(array('select' => 'stock', 'condition' => 'id=:id',
                        'params' => array(':id' => $orderGoods->spec_id),
                    ));
                    if (isset($goodsSpec->stock) && $goodsSpec->stock < $orderGoods->quantity)
                        throw new CHttpException(404, '订单中有商品库存不足');
                }
            }
        }
        if (count($orders) !== count($codes))
            throw new CHttpException(404, '有异常的订单');
        $sourceTypes = array_unique($sourceTypes);
        //判断订单类型，不能同时支付不同类型的订单
        if (count($sourceTypes) != 1) {
            throw new CHttpException(404, '不能同时支付这几个订单,请在会员中心分别支付订单');
        }
       /*  if($sourceTypes[0]!=Order::SOURCE_TYPE_DEFAULT){
            throw new CHttpException(404, '请到PC端付款！');
        } */
        return array('totalPrice' => $totalPrice, 'isMoneyPay'=>$isMoneyPay,'orders' => $orders, 'sourceType' => $sourceTypes[0]);
    }

    /**
     * 获取用户红包余额及订单可用红包信息
     * @param $goods array 商品信息数组
     * @param bool $flag 标志 是否判断用户红包余额足够支付该订单
     * @return mixed 红包信息数组
     * @throws CHttpException
     * @author xiaoyan.luo
     */
    private function _getRedAccount($goods,$flag = true)
    {
        $arr = array(); //订单能使用的红包金额
        $redType = false;
        //获取会员红包金额
        $redAccount = RedEnvelopeTool::getRedAccount($this->getUser()->id);
            $useRed = 0; //能使用的红包上限
            if(!empty($goods['goodsInfo']['goods'])){
                foreach ($goods['goodsInfo']['goods'] as $k2 => $v2) {
                    if($v2['join_activity'] == Goods::JOIN_ACTIVITY_YES && $v2['at_status'] == ActivityTag::STATUS_ON){
                    $ratio = bcdiv($v2['activity_ratio'], 100, 5);
                    $useRed += bcmul(bcmul($v2['gai_sell_price'], $goods['goodsCount'], 2), $ratio, 2);
                    $redType = true;
                }
                  }
                  $arr = $useRed;
            }
        if($flag){
            if($redAccount < $useRed) {
                if ($redType) {
                    throw new CHttpException(503, Yii::t('orderFlow', '您的红包：{0}元，订单所需红包：{1}元，不足以支付订单！', array('{0}' => $redAccount, '{1}' => $useRed)));
                }
            }
        }

        $newArr['memberRedAccount'] = $redAccount;
        $newArr['use_red_money'] = $arr;

        return $newArr;
    }

    /**
     * 计算运费
     * @param int $city_id
     *
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
     * 高汇通发送短信
     */
    public function actionSendMobileCode(){
        if($this->isAjax()){
            $postData=$_REQUEST;
            $info=array();
            $info['reqMsgId']=$postData['reqid'];
            $info['mobilePhone']=$postData['mobile'];
            $info['userId']=$this->model->gai_number;
            $ghtPay = new GhtPay();
            $result=$ghtPay->getHttpData($info,'mobile');
            exit(CJSON::encode($result['error']));
        }
    }   
}
