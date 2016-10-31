<?php

/**
 * 流水控制器
 * 操作 (列表，详情)
 * @author shengjie.zhang
 */
class AccountOfflineTransactionsController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    //线下交易银行卡支付交易成功后未异步返回生成流水的补增流水
    public function actionOfflineTransactions(){
        $this->render('offline');
    }
    //补增流水方法
    public function actionSupplementary(){
        if($this->isPost() && isset($_POST['pay_number'])){
            try{
                $data = $this->getParam('pay_number');
                $db = Yii::app()->db;
                $gt = Yii::app()->gt;
                $orderTable = FranchiseeConsumptionRecord::tableName();
                $preOrderTable = FranchiseeConsumptionPreRecord::tableName();
                $preOrder = $db->createCommand()
                    ->from($preOrderTable)
                    ->where('serial_number=:orderId',array(':orderId'=>$data))->queryRow();

                if(empty($preOrder))
                {
                    FranchiseeConsumptionPayResultLog::errorlog($data,$data,'没有此订单号');
                    throw new ErrorException('没有此订单号');
                }
                if(isset($preOrder) && isset($preOrder['machine_serial_number'])){
                    $machineNumber = $preOrder['machine_serial_number'];
                    $order = $db->createCommand()
                        ->from($orderTable)
                        ->where("serial_number = '{$data}' OR machine_serial_number = '{$machineNumber}'")
                        ->queryRow();
                }else{
                    $order = $db->createCommand()
                        ->from($orderTable)
                        ->where("serial_number = '{$data}'")
                        ->queryRow();
                }

                if($preOrder['is_pay']==FranchiseeConsumptionPreRecord::IS_PAY_YES || $preOrder['status']==FranchiseeConsumptionPreRecord::STATUS_FINISH || !empty($order)){
                    throw new ErrorException('该单号已经支付');
                }
//                请求联动数据，查看是否已经支付，只有支付完成才能生成流水
                $result = Umpay::_umPayResult($data);

                if(empty($result)){
                    throw new Exception('您的订单尚未支付！请重新支付！');
                }
                if(isset($result) && $result['status'] != true){
                    throw new Exception('您的订单已经支付，等待订单状态更新中');
                }
                IntegralOfflineNew::paymentSubmitPay($preOrder,AccountFlow::BUSINESS_NODE_EBANK_UM,'使用联动支付');
                $this->setFlash('success','补增流水成功');
                $this->render('offline');
            } catch(Exception $e){
                $this->setFlash('error',$e->getMessage());
                $this->render('offline');
            }

        }else{
            $this->render('offline');
        }
    }
    
    public function actionAppConsumRecord()
    {
        $model = new AppConsumRecord('search');
        $model->unsetAttributes();
        $this->render('AppConsumRecordList', array(
                'model' => $model,
        ));
    }

}
