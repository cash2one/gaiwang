<?php

/**
 * 订单支付控制器
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class OrderController extends Controller {

    public $defaultAction = 'pay';
    public $uid; //会员id
    public $member; //会员信息

    public function beforeAction($action) {
        $this->uid = $this->getUser()->id;
        $url = Yii::app()->request->hostInfo . Yii::app()->request->url;
        if (!$this->uid) {
            $this->getUser()->setReturnUrl($url);
            $this->redirect(array('/member/home/login'));
        }
        $this->member = Member::model()->findByPk($this->uid);
        return parent::beforeAction($action);
    }
    /**
     * 处理订单支付流程
     * @param string $code 订单号 
     * $code格式(20140919182017275964,20140919182017275964)
     * @throws CHttpException
     */
    public function actionPay($code) {
        //如果使用主题，则用不同的layout
        if(Yii::app()->theme){
            $this->layout = 'miniMain';
        }
        $this->pageTitle = '订单支付_'.$this->pageTitle;
        // 验证订单准确性
        $result = $this->_checkOrder($code);
//        var_dump($result);
        // Tool::p($result);exit;
        $orders = $result['orders'];
        $totalPrice = $result['totalPrice'];
        $sourceType = $result['sourceType'];
        // 订单表单
        $model = new OrderForm;
        $member = $this->member;
        if(empty($member->mobile)){
            $this->setFlash('error','您需要绑定手机号码才能支付订单');
            $this->redirect(array('/member/member/update'));
        }
        $memberArray = array(
            'id' => $member['id'],
            'gai_number' => $member['gai_number'],
            'type_id' => $member['type_id'],
            'mobile' => $member['mobile'],
            'username' => $member['username'],
            'account_id'=>$member['id'],
            'type'=>AccountInfo::TYPE_CONSUME,
        );
        //当前会员余额(旧余额+新余额)
        $model->balance = AccountBalance::findRecord($memberArray,true);//会员消费账户
        $model->balanceHistory = AccountBalanceHistory::findRecord($memberArray,true); //会员历史消费账户
        if($model->balanceHistory){
            $model->accountMoney = $model->balanceHistory['today_amount'] + $model->balance['today_amount'];
        }else{
            $model->accountMoney = $model->balance['today_amount'];
        }
        $model->totalPrice = $totalPrice;
//        var_dump($model);
        $singlePayDetail = $model->singlePayDetail($result['integral_ratio']);
        //积分+现金
        $jfxj = $model->jfxj($result);
//        var_dump($jfxj);
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        // 支付表单提交
        if (isset($_POST['OrderForm'])) {
            $model->attributes = $this->getPost('OrderForm');

            //如果是积分支付，必须要验证支付密码
            if($model->payType=='JF' || isset($_POST['OrderForm']['jfPay']) ){
                $model->needPassword = 1; //
            }else{
                $model->needPassword = 0;
                $model->password3 = 1;
            }
            if ($model->validate()) { // 验证通过
                //为了在线支付、代扣生成一个额外的流水号
                $parentCode = Tool::buildOrderNo(19, 8);
                
                if($totalPrice == 0 && $model->payType != 'JF') {
                    throw new CHttpException(503, Yii::t('order', '此订单只能使用积分支付！'));
                }
                if($sourceType == Order::SOURCE_TYPE_HB && $totalPrice > 0){
                    if($model->payType == 'JF'){
                        throw new CHttpException(503,Yii::t('order','此订单只能使用网银支付！'));
                    }
                }
                //快捷支付
                if(isset($_POST['quickPay']) && $model->payType != 'JF' ){
                    $model->payType = $this->getPost('quickPay');
                }

                foreach ($orders as $v) {
                    //如果是再次支付，需要检查是否已经网银支付
                    if(!empty($v['parent_code']) && $model->payType!='JF'){
                        $result = OnlinePayCheck::payCheck($v['parent_code'], $v['pay_type'],$v['code'],OnlinePay::ORDER_TYPE_GOODS);
                        if (isset($result['status']) && $result['status']) {
                            throw new CHttpException(403,Yii::t('order', '您的订单已经支付，等待订单状态更新中'));
                        }
                    }
                    $res = Yii::app()->db->createCommand()->update('{{order}}', array(
                        'parent_code' => $parentCode,
                        'pay_type' =>$model->payType == 'JF' ? Order::PAY_TYPE_JF : OnlinePayment::getPayType($model->payType),
                    ), 'id=:id', array(':id' => $v->id));
                    if(!$res) throw new CHttpException(503,'更新订单失败');
                }

                if ($model->payType == 'JF' && $sourceType!=Order::SOURCE_TYPE_SINGLE) { // 积分支付
                    //获取历史余额代扣金额
                    OnlinePayment::payWithJF($orders, $totalPrice, $model->balance, $model->balanceHistory,$memberArray,$parentCode);
                    $this->render('application.views.layouts.payresult',array('payAccount'=>Common::convertSingle($totalPrice, $memberArray['type_id'])));
                    Yii::app()->end();
                } else {
                    //在线支付
                    $msg = OnlinePay::checkInterface($model->payType);
                    if ($msg) throw new CHttpException(503, $msg);

                    //如果是特殊商品，则支付部分
                    if($sourceType==Order::SOURCE_TYPE_SINGLE){
                        $totalPrice = isset($_POST['OrderForm']['jfPay']) ? $singlePayDetail['onlinePay'] : $totalPrice;
                    }
                    if($sourceType == Order::SOURCE_TYPE_JFXJ){
                        $totalPrice = isset($_POST['OrderForm']['jfPay']) ? $jfxj['onlinePay'] : $totalPrice;
                    }
                    if(isset($_POST['quickPay'])){
                        //获取getTradeNo
                        $param = array(
                            'orderType'=>OnlinePay::ORDER_TYPE_GOODS,
                            'code'=>$orders[0]['code'],
                            'parentCode'=>$parentCode,
                            'money'=>$totalPrice,
                            'goods_inf'=>$this->getUser()->gw,
                            'orderDate'=>date('Ymd'),
                            'backUrl'=>$this->createAbsoluteUrl('order/onlinePayResult'),
                        );
                        $tradeNo = OnlinePay::getUmTradeNo($param);

                        $this->redirect(array('order/quickPayShow',
                            'pay_type'=>$model->payType,
                            'code'=>$parentCode,
                            'money'=>$totalPrice,
                            'tradeNo'=>$tradeNo,
                            'quickPay'=>$_POST['OrderForm']['payType']
                        ));
                    }
                    OnlinePay::redirectToPayShow('order/payShow', $model->payType, $orders[0]['code'] , $totalPrice,$parentCode); //跳转到支付确认页面
                }
            }else{
                $this->setFlash('error',CHtml::errorSummary($model));
            }
        }

        $frConfig = $this->getConfig('freightlink');
        $frPhone = $this->getConfig('site', 'phone');
        $this->render('pay', array(
            'orders'=>$orders,
            'model'=>$model,
            'totalPrice'=>$totalPrice,
            'frConfig'=>$frConfig,
            'frPhone'=>$frPhone,
            'sourceType'=> $sourceType,
            'singlePayDetail'=> $singlePayDetail,
            'accountMoney'=> $model->accountMoney,
            'jfxj' => $jfxj,
        ));
    }

    /**
     * 验证订单有效性,并返回订单、相关商品数据
     * @param string $code
     * @throws CHttpException
     * @return array
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    private function _checkOrder($code) {
        $codes = explode(',', $code);
        $criteria = new CDbCriteria;
        $criteria->select = 'id, code, pay_price, real_price, pay_status,source_type,consignee,mobile,address,other_price,member_id,store_id,parent_code,pay_type,create_time,freight';
        $criteria->addInCondition('t.code', $codes);
        $criteria->compare('t.member_id', $this->uid);
        $criteria->compare('t.status', Order::STATUS_NEW);
        $criteria->with = array(
            'orderGoods' => array('select' => 'id, goods_id, goods_name, gai_price, unit_price, spec_id,quantity,activity_ratio,ratio,integral_ratio,special_topic_category,rules_setting_id'),
            'store' => array('select' => 'id, name, referrals_id'),
            'stockLog' => array('select' => 'id')
        );
        $orders = Order::model()->findAll($criteria);
       
        if(count($orders)> ShopCart::MAX_NUM_LIMIT){
            throw new CHttpException(503,'一次支付订单超过'.ShopCart::MAX_NUM_LIMIT.'个');
        }
        $totalPrice = 0;
        $flowTableName = AccountFlow::monthTable(); //流水日志表名
        //订单类型
        $sourceTypes = array();
        /** @var Order $order */
        foreach ($orders as $order) {
            if($order['pay_status']==Order::PAY_STATUS_YES){
                throw new CHttpException(503,Yii::t('order','您的订单：{code}已经支付',array('{code}'=>$order['code'])));
            }
            
            //20160815 出现负数订单，在此处多加判断
           if($order->pay_price <= 0){
            	throw new CHttpException(404, '订单商品价格异常');
            }       
            //如果不是普通订单，必须要绑定手机号码
            if($order['source_type']!=Order::SOURCE_TYPE_DEFAULT && !$this->member->mobile){
                $this->redirect(array('/member/member/update'));
            }
            $sourceTypes[] = $order['source_type'];
            $totalPrice += $order->pay_price;
            $stockLog = $order->stockLog;
            foreach ($order->orderGoods as $orderGoods) {
                // 关闭未支付的秒杀订单
                if($orderGoods->rules_setting_id>0){
                    if($this->closeSeckillOrder($order,$orderGoods->rules_setting_id,$orderGoods->goods_id));
                }
                //订单商品价格检查
//                if($orderGoods->gai_price >= $orderGoods->unit_price){
//                    throw new CHttpException(404,'订单商品价格异常');
//                }
                $integral_ratio = $orderGoods->integral_ratio;
                if($orderGoods->gai_price > $orderGoods->unit_price){
                    throw new CHttpException(404,'订单商品价格异常');
                }

                //订单库存检查,如果 stock_log库存日志有相关数据，说明订单支付前，库存已经回滚了
                if($stockLog){
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
        if(count($sourceTypes)!=1){
            throw new CHttpException(404, '不同的订单类别，不可以同时支付,请在会员中心分别支付订单');
        }
        return array('totalPrice' => $totalPrice, 'orders' => $orders,'sourceType'=>$sourceTypes[0],'integral_ratio'=>$integral_ratio);
     }

    public function closeSeckillOrder($order,$setting_id,$goods_id){
        $category_id = Yii::app()->db->createCommand()
            ->select('m.category_id')
            ->from('{{seckill_rules_seting}} s')
            ->join('{{seckill_rules_main}} m','s.rules_id=m.id')
            ->where('s.id=:id',array(':id'=>$setting_id))->queryScalar();
        if($category_id != 3){
            return false;
        }
        if(($order->create_time + SeckillRedis::TIME_INTERVAL_ORDER) > time()){
            return false;
        }
        /**
         *  如果订单是第三方支付并且对账是不成功的,就把这个订单暂时锁定,不能操作.
         *  @author binbin.liao 新增 2014-11-26
         */
        if (in_array($order->pay_type, array(Order::PAY_ONLINE_IPS, Order::PAY_ONLINE_UN, Order::PAY_ONLINE_BEST))) {
            $result = OnlinePayCheck::payCheck($order->parent_code, $order->pay_type,$order->code);
            if ($result['status']) {
                echo Yii::t('memberOrder', '等待订单状态更新中,暂时不能关闭');
                exit;
            }
        }
        ActivityData::deleteOrderCache($order->member_id, $goods_id);//删除秒杀流程缓存
        ActivityData::closeOrder($order->code);//关闭订单
        ActivityData::delGoodsCache($goods_id);//删除商品缓存
        ActivityData::deleteActivityGoodsStock($goods_id);//删除库存缓存
        throw new CHttpException(404, '订单已超时');
    }

    /**
     * 接收在线支付返回结果
     */
    public function actionOnlinePayResult()
    {
        $this->pageTitle = Yii::t('order', '在线支付结果') . $this->pageTitle;
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
            //联动优势支付
            $result = OnlinePay::umPayCheck();
        }else if(isset($_POST['payResult']) && $_POST['payResult']==1){
            //通联支付    
            $result = OnlinePay::tlzfPayCheck();
        }else{
            $result['money'] = $this->getParam('money');
            if(!$this->getParam('ok')){
                $result['errorMsg'] = '支付失败';
            }
        }
        $this->render('application.views.layouts.payresult', array('result' => $result, 'payAccount' => Common::convertSingle($result['money'])));
    }


    /**
     * 确认支付平台
     */
    public function actionPayShow()
    {
        $this->pageTitle = '确认支付平台_' . $this->pageTitle;
        $params = array(
            'backUrl' => 'order/onlinePayResult',
            'orderDesc' => '商品订单',
            'checkUrl' => 'order/check',
            'orderType' => OnlinePay::ORDER_TYPE_GOODS,
        );

        $payType = $this->getParam('payType')==OnlinePay::PAY_BEST ? Order::PAY_ONLINE_BEST :$this->getParam('payType');
        $result = OnlinePayCheck::payCheck($this->getParam('parentCode'), $payType,$this->getParam('code'));
        if (isset($result['status']) && $result['status']) {
            throw new CHttpException(403,Yii::t('order', '您的订单已经支付，等待订单状态更新中'));
        }
        $this->render('application.views.layouts.payshow', $params);
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
            $this->render('application.views.layouts.payresult', array('result' => $result, 'payAccount' => Common::convertSingle($money)));
        }
    }

    /**
     * 快捷支付验证
     * @throws CHttpException
     */
    public function actionQuickPayShow(){
        $this->pageTitle = Yii::t('memberRecharge','快捷支付验证_') . $this->pageTitle;
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
                $this->setFlash('error',Yii::t('order','支付失败:').$result);
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
    
    /**
     * v2.0 处理订单支付流程
     * @param string $code 订单号 
     * $code格式(20140919182017275964,20140919182017275964)
     * @throws CHttpException
     */
    public function actionPayv2($code)
    {
        $this->layout = 'miniMain';
        $this->pageTitle = '订单支付_' . $this->pageTitle;
        $paySession = $this->getSession('order_try_pay_'.$code);
        if($paySession){
             $this->setFlash('warning','您正在尝试再次支付，如果您已经支付过了该订单，订单状态却未能及时改变，请稍等一会儿刷新网页或者联系盖象商城客服，千万不要重复支付！');
        }
        // 验证订单准确性
        $result = $this->_checkOrder($code);
//        var_dump($result);
        // Tool::p($result);exit;
        $orders = $result['orders'];
        $totalPrice = $result['totalPrice'];
        $sourceType = $result['sourceType'];
        // 订单表单
        $model = new OrderForm;

        $member = $this->member;
        if(empty($member->mobile)){
            $this->setFlash('error','您需要绑定手机号码才能支付订单');
            $this->redirect(array('/member/member/mobile'));
        }
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        // 支付表单提交
        if (isset($_POST['OrderForm'])) {
            if(!$paySession){
                $this->setSession('order_try_pay_'.$code,'yes');
            }
            $post = $this->getPost('OrderForm');
            //计算精度的问题
            if(isset($post['jfPayCount']) && (float)bcsub($model->totalPrice,$post['jfPayCount'],2) ==  0 ){
                $post['payType'] = 'JF';
            }
            $model->attributes = $post;
            //如果是积分支付，必须要验证支付密码
            if ($model->payType == 'JF' || isset($_POST['OrderForm']['jfPay'])) {
                $model->needPassword = 1; //
            } else {
                $model->needPassword = 0;
//                $model->password3 = 1;//难道是为了防止不为空？可是你前面设置12345679.。。
            }
            //v2.0版，支持所有商品 支付+现金支付           
            if ($model->validate()) { // 验证通过
                //为了在线支付、代扣生成一个额外的流水号
                $parentCode = Tool::buildOrderNo(19, 8);

                if ($totalPrice == 0 && $model->payType != 'JF') {
                    throw new CHttpException(503, Yii::t('order', '此订单只能使用积分支付！'));
                }
                if ($sourceType == Order::SOURCE_TYPE_HB && $totalPrice > 0) {
                    if ($model->payType == 'JF') {
                        throw new CHttpException(503, Yii::t('order', '此订单只能使用网银支付！'));
                    }
                }
                //快捷支付
                if (isset($_POST['quickPay']) && $model->payType != 'JF') {
                    $model->payType = $this->getPost('quickPay');
                }
                //这里检测下允许的最大积分支付金额
                $discoutTotal = $model->getDiscount($orders, $model);
                if (bcsub($model->jfPayCount,$discoutTotal,2) > 0){
                    throw new CHttpException(503, Yii::t('orders', '超出积分允许支付金额'));
                }

            /***** 20160111增加银行直连支付  *****/
           if ($model->payType != 'JF') {
                $payArr=array();
                $thirdTypeArr=array();
                if(isset($post['bankType']) && $post['bankType']!=OnlineBankPay::PAY_BANK_NONE && isset($post['bankCode']) && !empty($post['bankCode'])){
                    $bankCode=$post['bankCode'];
                    //如果是支付宝、微信支付，只能用高汇通
                    if($bankCode =='ALIPAY' || $bankCode == 'WECHAT'){
                        $thirdTypeArr = array('code'=>$bankCode,'type'=>OnlinePay::PAY_GHT);
                        $model->payType = OnlinePay::PAY_GHT;
                    }else{
                        $sql="SELECT `type`,`code` from gw_bank where `name` IN (SELECT `name` from gw_bank where `code`='".$bankCode."') AND `status`=".OnlineBankPay::STATUS_YES;
                        $thirdTypes=Yii::app()->db->createCommand($sql)->queryAll();
                        if(!empty($thirdTypes)){
                            $thirdTypes=OnlineBankPay::checkPayType($thirdTypes);
                            $thirdTypeArr=$thirdTypes[array_rand($thirdTypes,1)];
                            $model->payType = $thirdTypeArr['type'];//第三方支付类别
                        }
                    }
                    //是否现金+积分支付判断
                    if(isset($post['jfPayCount']) && !empty($post['jfPayCount']) && (float)bcsub($model->totalPrice,$post['jfPayCount'],2) > 0 ){
                        $model->payType =OnlinePay::PAY_GHTKJ;
                    }
                
                }
           }
           /**** 银行直连支付END  *************/
                foreach ($orders as $v) {
                    //如果是再次支付，需要检查是否已经网银支付
                   if (!empty($v['parent_code']) && ($v['pay_type']!=Order::PAY_TYPE_NO || $v['pay_type']!=Order::PAY_TYPE_JF)) {
                        $result = OnlinePayCheck::payCheck($v['parent_code'], $v['pay_type'], $v['code'], OnlinePay::ORDER_TYPE_GOODS);
                        if (isset($result['status']) && $result['status']) {
                            throw new CHttpException(403, Yii::t('order', '您的订单已经支付，等待订单状态更新中'));
                        }
                    }
                    if($model->jfPayCount && $sourceType!=Order::SOURCE_TYPE_SINGLE){
                        $sourceType=order::SOURCE_TYPE_JFXJ;
                    }
                    //采用积分支付，则将source_type类型修改成积分加现金支付
                    $res = Yii::app()->db->createCommand()->update('{{order}}', array(
                        'parent_code' => $parentCode,
                        'pay_type' => $model->payType == 'JF' ? Order::PAY_TYPE_JF : OnlinePayment::getPayType($model->payType),
                        // 更新积分支付金额
                        'jf_price'=> $model->payType == 'JF' ? $model->jfPayCount : isset($post['jfPayCount']) ? $post['jfPayCount'] : 0 ,
                        'source_type'=> $sourceType,
//                        'real_price'=> $totalPrice - $model->jfPayCount,
                            ), 'id=:id', array(':id' => $v->id));
                    if (!$res)
                        throw new CHttpException(503, '更新订单失败');
                }
                if ($model->payType == 'JF' && $sourceType != Order::SOURCE_TYPE_SINGLE) { // 积分支付
                    //获取历史余额代扣金额
                    OnlinePayment::payWithJF($orders, $totalPrice, $model->balance, $model->balanceHistory, $memberArray, $parentCode);
                    $this->render('payresult', array('payAccount' => $totalPrice,'model'=>$orders[0]));
                    Yii::app()->end();
                } else {
                    //在线支付
                    $msg = OnlinePay::checkInterface($model->payType);
                    if ($msg)
                        throw new CHttpException(503, $msg);

                    //如果是特殊商品，则支付部分
//                    if ($sourceType == Order::SOURCE_TYPE_SINGLE) {
//                        $totalPrice = isset($_POST['OrderForm']['jfPay']) ? $model->jfPayCount : $totalPrice;
//                    } 
                    //积分+现金；在线支付金额为总额减去积分支付金额
                    if ($sourceType != Order::SOURCE_TYPE_HB) {
                        $totalPrice = isset($_POST['OrderForm']['jfPay']) ? bcsub($totalPrice, $model->jfPayCount,2) : $totalPrice;
                    }
            /**************增加网银直连（20160111）*****************/
               if(isset($post['bankType']) && $post['bankType']!=OnlineBankPay::PAY_BANK_NONE && isset($post['bankCode']) && !empty($post['bankCode'])){
                    $payArr=array(
                            'orderType' => OnlinePay::ORDER_TYPE_GOODS,
                            'code' => $orders[0]['code'],
                            'parentCode' => $parentCode,
                            'money' => $totalPrice,
                            'backUrl' => $this->createAbsoluteUrl('order/onlinePayResultv2'),
                            'bankType'=>$post['bankType'],//借记卡 or 信用卡
                            'bankCode'=>$thirdTypeArr['code'],//银行编码
                    );
                      OnlineBankPay::ThirdTypeCheck($model->payType,$payArr);
                      Yii::app()->end();
                }
           /**************************************************/
		           if (isset($_POST['quickPay'])) {
                        //获取getTradeNo
                        $param = array(
                            'orderType' => OnlinePay::ORDER_TYPE_GOODS,
                            'code' => $orders[0]['code'],
                            'parentCode' => $parentCode,
                            'money' => $totalPrice,
                            'goods_inf' => $this->getUser()->gw,
                            'orderDate' => date('Ymd'),
                            'backUrl' => $this->createAbsoluteUrl('order/onlinePayResult'),
                        );
                        $tradeNo = OnlinePay::getUmTradeNo($param);

                        $this->redirect(array('order/quickPayShowv2',
                            'pay_type' => $model->payType,
                            'code' => $orders[0]['code'],
                            'money' => $totalPrice,
                            'tradeNo' => $tradeNo,
                            'quickPay' => $_POST['OrderForm']['payType'],
                            'parentCode'=>$parentCode,
                            'auth'=>Tool::authcode($totalPrice.$parentCode,'ENCODE',false,3600), //校验码，一个小时内有效
                        ));
                    }
                    OnlinePay::redirectToPayShow('order/payShowv2', $model->payType, $orders[0]['code'], $totalPrice, $parentCode); //跳转到支付确认页面
                }
            } else {
                $this->setFlash('error', CHtml::errorSummary($model));
            }
        }
        $frConfig = $this->getConfig('freightlink');
        $frPhone = $this->getConfig('site', 'phone');
        $this->render('pay_v20', array(
            'orders' => $orders,
            'model' => $model, 
            'totalPrice' => $totalPrice,
            'frConfig' => $frConfig,
            'frPhone' => $frPhone,
            'sourceType' => $sourceType,
            //'singlePayDetail' => $singlePayDetail, //积分支付比例，这个计算不对 比例按照产品比例计算，而不是订单总额
            'balance' => $model->accountMoney,
//            'jfxj' => $jfxj,
        ));
    }  
    
    /**
     * v2.0确认支付页面
     * @throws CHttpException
     */
    public function actionPayShowv2()
    {

        OnlinePay::checkMoney();
        $this->layout = 'miniMain';
        $this->pageTitle = '订单支付_' . $this->pageTitle;
        $params = array(
            'backUrl' => 'order/onlinePayResultv2',
            'orderDesc' => '商品订单',
            'checkUrl' => 'order/checkv2',
            'orderType' => OnlinePay::ORDER_TYPE_GOODS,
        );

      /*   $payType = $this->getParam('payType') == OnlinePay::PAY_BEST ? Order::PAY_ONLINE_BEST : $this->getParam('payType');
        $result = OnlinePayCheck::payCheck($this->getParam('parentCode'), $payType, $this->getParam('code'));
        if (isset($result['status']) && $result['status']) {
            throw new CHttpException(403, Yii::t('order', '您的订单已经支付，等待订单状态更新中'));
        } */
        $this->render('payshowv2', $params);
    }
   
    /**
     * v2.0快捷支付验证
     * @throws CHttpException
     */
    public function actionQuickPayShowv2()
    {
	OnlinePay::checkMoney();
        $this->layout = 'miniMain';
        $this->pageTitle = Yii::t('memberRecharge', '快捷支付验证_') . $this->pageTitle;
        /** @var PayAgreement $model */
        $model = PayAgreement::model()->findByPk($this->getParam('quickPay'));
        if (!$model || $model->gw != $this->getUser()->gw) {
            throw new CHttpException(403, '快捷支付数据有误');
        }
        if (isset($_POST['verifyCode'])) {
            $param = array(
                'gw' => $this->getUser()->gw,
                'tradeNo' => $this->getParam('tradeNo'),
                'verify_code' => $this->getPost('verifyCode'),
                'busi_agreement_id' => $model->busi_agreement_id,
                'pay_agreement_id' => $model->pay_agreement_id,
            );
            $result = OnlinePay::checkUmVerifyCode($param);
            if ($result === true) {
                $this->redirect($this->createAbsoluteUrl('order/onlinePayResultv2', array('money' => $this->getParam('money'), 'ok' => 1,'code'=>$this->getParam('code'))));
            } else {
                $this->setFlash('error', Yii::t('order', '支付失败:') . $result);
            }
        }
        $this->render('quickPayShowv2', array('model' => $model));
    }
    
    /**
     * v2.0接收在线支付返回结果
     */
    public function actionOnlinePayResultv2()
    {
        $this->layout = 'miniMain';
        $this->pageTitle = Yii::t('order', '在线支付结果') . $this->pageTitle;
        $result = array(); //支付结果
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
        } else if (isset($_POST['mer_priv']) || isset($_GET['mer_priv'])) {
            //联动优势支付
            $result = OnlinePay::umPayCheck();
        } else if (isset($_POST['payResult']) && $_POST['payResult'] == 1) {
            //通联支付    
            $result = OnlinePay::tlzfPayCheck();
        } else if (isset($_GET['pay_result']) && $_GET['pay_result'] == 1) {
            //高汇通支付    
            $result = OnlinePay::ghtPayCheck();
        } else if (isset($_GET['returncode']) && $_GET['returncode'] == '00') {
            //EBC钱包支付  
            $result = OnlinePay::ebcPayCheck();
        }else {
            $result['money'] = $this->getParam('money');
            if (!$this->getParam('ok')) {
                $result['errorMsg'] = '支付失败';
            }
        }
        //订单号  
//        var_dump($result);exit;
        $model = new Order;
        if(isset($result['code']) || $this->getParam('code')){
            $code = isset($result['code']) ?  $result['code'] : $this->getParam('code');
            $model = $this->_getOrder($code);
            if(!$model) throw new CHttpException('503','支付遇到未知错误,请返回订单查看');
        }
        $goodsIdArr=array();
        foreach($model->orderGoods as $k => $v){
            $goodsIdArr[$k]=$v->goods_id;
         }   
        if(in_array(OrderMember::GOODS_ONE, $goodsIdArr) || in_array(OrderMember::GOODS_TWO, $goodsIdArr) || in_array(OrderMember::GOODS_THREE, $goodsIdArr)){
        	$this->layout = 'main2'; 	
            $this->redirect(array('addMember','code' => $code));
           }else{
              $this->render('payresult', array('result' => $result, 'payAccount' => $model->pay_price,'model'=>$model));
          }
    }
    /**
     * 取消订单展示页面
     * @param int $code
     * @throws CHttpException 
     */
    public function actionCancelOrder($code)
    {
        $this->layout = 'miniMain';
        $model = $this->_getOrder($code);
        if(!$model)  throw new CHttpException('404',  Yii::t('order','找不到相关的订单数据'));
        $endtime = $model->create_time+86400;
        if( $endtime < time() && $model->pay_status == Order::PAY_STATUS_NO){
            $trans = Yii::app()->db->beginTransaction();
            try{
                $model->rollBackStock(); //库存回滚
                $model->status = Order::STATUS_CLOSE;
                $model->close_time = time();
                
                if ($model->source_type == Order::SOURCE_TYPE_HB) {
                    $otherPrice = $model->other_price; //红包使用金额
                    MemberAccount::model()->updateCounters(array('money' => $otherPrice), 'member_id=:member_id', array(':member_id' => $model->member_id));
                }
                if ($model->save(false)) {
                    $this->setFlash('success',Yii::t('memberOrder', '取消订单成功'));
                } else {
                    throw new Exception(Yii::t('memberOrder', '取消订单失败'));
                }
                $trans->commit();
            } catch (CException $ex) {
                $trans->rollback();
            }
        }
//        if($model->status != Order::STATUS_CLOSE)  throw new CHttpException('503',  Yii::t('order','该订单未被取消'));
        $this->render('cancelorder',array('model'=>$model,'payAccount'=>$model->pay_price));
    }
    
    /**
     * 检查订单状态
     * @param $code
     * @param $money
     */
    public function actionCheckv2($code, $money)
    {
        $this->layout='miniMain';
        $orders =$this->_getOrder($code);
        $result = array();
        //$result = OnlinePay::ebcPayCheck();
        if ($orders && $orders->pay_status == Order::PAY_STATUS_NO) {
            $result['errorMsg'] = '您的订单还未支付';
        }
         if ($this->isAjax()) {
            echo json_encode($result);
        } else {
            $this->render('payresult', array('result' => $result, 'payAccount' => Common::convertSingle($money),'model'=>$orders));
        }
    }
    
    /**
     * 获取单个订单信息
     * @param int $code 订单号
     */
    protected function _getOrder($code)
    {
       if(is_numeric($code)){
           $criteria = new CDbCriteria;
            $criteria->select = 'id, code, pay_price,pay_time, real_price, pay_status,source_type,consignee,mobile,address,other_price,member_id,store_id,parent_code,pay_type,create_time,freight';
            $criteria->compare('t.code', $code);
//            $criteria->compare('t.pay_status', Order::PAY_STATUS_NO);
//            $criteria->compare('t.status', Order::STATUS_NEW);
            $criteria->with = array(
                'orderGoods' => array('select' => 'id, goods_id, goods_name, gai_price, unit_price, spec_id,quantity,activity_ratio,ratio,integral_ratio,special_topic_category,rules_setting_id'),
                'store' => array('select' => 'id, name, referrals_id'),
                'stockLog' => array('select' => 'id')
            );
            $orders = Order::model()->find($criteria);
            return $orders;
        }
       return false;
    }  

    /**
     * 检验订单号是否匹配用户ID及是否支付过
     */
    public function actionCheckOrderMem(){
         $code= $this->getParam('code');
         $memberId=$this->getUser()->id;
         $codeArr = Order::model()->find(array(
                 'select'=>'id,pay_status',
                 'condition'=>'member_id=:mid AND code=:code',
                 'params'=>array(':mid'=>$memberId,':code'=>$code),
         ));
         $res=array();
         if(!$codeArr){
         	 $res['errorMsg']='订单不存在';
         	 $res['errorCode']=1;
         }else if($codeArr && $codeArr->pay_status == Order::PAY_STATUS_NO){
             $res['errorMsg']='订单未支付';
             $res['errorCode']=2;
         }else{
         	 $res['errorMsg']='订单支付成功';
         	 $res['errorCode']=3;
         }
         if ($this->isAjax()) {
             echo json_encode($res);
         }
    }
    /**
     * 订单多用户录入
     */
    public function actionAddMember()
    {
    	   $model = new OrderMember();
    	   $code=$this->getParam('code');
    	   //$code='20160729140634977408';
    	   $this->performAjaxValidation($model);
    	   if (isset($_POST['code'])) { 
    	   	   $memberId=$this->getUser()->id;
    	   	   $codeArr=OrderMember::checkCode($code, $memberId);
    	   	   if(empty($codeArr))
    	   	   	  throw new Exception(Yii::t('memberOrder', '订单未支付，请刷新重试!'));
    	       $dataArr =$this->getPost('OrderMember');
    	       $saveDir = 'orderMember' . '/' . date('Y/n/j');
    	       $num=0;
    	       foreach($dataArr as $k => $v){ 
    	       	   $frontStr="identityImg_front_img_".$k;
    	       	   $backStr="identityImg_back_img_".$k;
    	           $frontImg=$_FILES[$frontStr];
    	           $backImg=$_FILES[$backStr]; 
    	           if(empty($frontImg) || empty($backImg) || empty($v['name']) || empty($v['sex']) || empty($v['identity_number']) || empty($v['mobile']) || empty($v['street']))
    	               continue;     
    	       	   $model = UploadedFile::uploadFile($model, 'identity_front_img', $saveDir,null,null,$frontStr);
    	       	   $model = UploadedFile::uploadFile($model, 'identity_back_img', $saveDir,null,null,$backStr);
    	       	   $res=Yii::app()->db->createCommand()->insert('{{order_member}}', array(
		    	       	   'member_id' => $memberId,
		    	       	   'code' => $code,
		    	       	   'real_name' => $v['name'],
		    	       	   'sex' => $v['sex'],
		    	       	   'identity_number' => $v['identity_number'],
		    	       	   'identity_front_img' => $model->identity_front_img,
		    	       	   'identity_back_img' => $model->identity_back_img,
		    	       	   'mobile' => $v['mobile'],
		    	       	   'street' => $v['street'],
		    	       	   'create_time' => time(),
    	       	   ));
    	       	   if($res){
    	       	   	  UploadedFile::saveFile('identity_front_img', $model->identity_front_img);
    	       	   	  UploadedFile::saveFile('identity_back_img', $model->identity_back_img);
    	       	      $num++;
    	       	   }
    	       }
    	       $tips=1;
    	       if($num!=0) $tips=2;
    	        $this->redirect(array('addMember','code' => $code,'tips'=>$tips)); 
    	   }     
    	    $this->layout = 'main2';
            $this->render('memberform',array('code' => $code,'model'=>$model));
    }
    
    
}
