<?php
class BackOrderController extends SController{

    public function beforeAction($action){
        $this->pageTitle = Yii::t('sellerOrder', '_卖家平台_') . Yii::app()->name;

        return parent::beforeAction($action);
    }

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CaptchaAction',
                'height' => '30',
                'width' => '70',
                'minLength' => 4,
                'maxLength' => 4,
                'offset' => 3,
                'testLimit' => 30,
            ),
            'captcha2' => array(
                'class' => 'CaptchaAction',
                'height' => '30',
                'width' => '70',
                'minLength' => 4,
                'maxLength' => 4,
                'offset' => 3,
                'testLimit' => 30,
            ),
        );
    }

    /**
     * 退货管理
     */
    public function actionIndex(){
        $model = new Order('search');
        $this->render('index',array('model'=>$model));
    }

    /**
     * 退货详情
     */
    public function actionBackGoodsInfo(){
        $orderId    = $this->getParam('order_id',0);
		$exchangeId = $this->getParam('exchange_id',0);
        $order = Order::getBackOrderInfoForSeller($orderId,$this->getSession('storeId'), $exchangeId);
        $model = new Order();
        $this->render('backgoodsinfo',array('order'=>$order,'model'=>$model));
    }

    /**
     * 商家提交控制器方法
     */
    public function actionMethodBack(){
        if($this->isPost()){
            $exchangeType = $this->getParam('exchange_type');
            $passStatus = $this->getParam('pass_status');
            $backReason = $this->getParam('back_reason','');
            $verifyCode = $this->getParam('verify_code','');
            $type = 'succeed';

            if($verifyCode != ''){
                if($verifyCode != $this->createAction('captcha')->getVerifyCode()){
                    echo json_encode(array('type'=>$type,'content'=>'验证码不正确！','url'=>''));die;
                }
            }

        $request = Order::methodRequestForSeller($this->getParam('order_id'),$exchangeType,$passStatus,$this->getParam('return_status'),$backReason,$this->getSession('storeId'));

            switch($request['status']){
                case -1 :
                    $comment = '很遗憾，本次操作失败，请重新提交！';
                    $type = 'error';
                    break;
                case Order::EXCHANGE_STATUS_NO :
                    $comment = ($request['type'] == Order::EXCHANGE_TYPE_RETURN) ? '退换货申请不通过，操作成功' : '退款申请不通过，操作成功。';
                    break;
                case Order::EXCHANGE_STATUS_DONE :
                    $comment = ($request['type'] == Order::EXCHANGE_TYPE_RETURN) ? '提交成功，本次退货服务已完成！' : '提交成功，本次退款服务已完成！';;
                    break;
                default :
                    $comment = ($request['type'] == Order::EXCHANGE_TYPE_RETURN) ? '提交成功，本次退货服务已通过审核！' : '提交成功，本次退款服务已通过审核！';
                    break;
            }
            echo json_encode(array('type'=>$type,'content'=>$comment,'url'=>$this->createAbsoluteUrl("/seller/backOrder/backgoodsinfo",array('order_id'=>$this->getParam('order_id'),'exchange_id'=>$request['exchange_id']))));
        }
    }

    /**
     * 根据快递公司名字查询
     * store_name
     * code
     */
    public function actionGetExpressStatus()
    {
        Yii::import('common.vendor.ExpressSearch');
        $kd_store_name = $this->getParam('store_name'); //快递公司名称
        $kd_code = $this->getParam('code'); //快递单号
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
        echo $rs;
    }

}
?>