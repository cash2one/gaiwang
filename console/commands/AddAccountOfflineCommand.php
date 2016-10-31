<?php
/**
 * Created by PhpStorm.
 * User: Gatewang
 * Date: 2015/8/21
 * Time: 16:16
 */
//自动搜索银行卡联动支付已支付未生成流水订单
class AddAccountOfflineCommand extends CConsoleCommand {
    public function  actionRun(){
        set_time_limit(0);
        $db = Yii::app()->db;
        $gt = Yii::app()->gt;
        $orderTable = FranchiseeConsumptionRecord::tableName();
        $preOrderTable = FranchiseeConsumptionPreRecord::tableName();
        //        查询一天之内的所有未支付订单
        $time1 = time()-300;
        $time2 = $time1-300;
        $limit =10;
        $id = 0;
            while(true){
                if($id > 0){
                    $sql = "select * from gw_franchisee_consumption_pre_record where is_pay = 0 and create_time >= {$time2} and create_time <= {$time1}  and id > {$id} ORDER by id asc limit {$limit}";
                }else{
                    $sql = "select * from gw_franchisee_consumption_pre_record where is_pay = 0 and create_time >= {$time2} and create_time <= {$time1} ORDER by id asc limit {$limit}";
                }
                $result =  Yii::app()->db->createCommand($sql)->queryAll();
                if(isset($result)){
                    foreach($result as $k =>$v){
                        $sn = $v['serial_number'];
                        $order = $db->createCommand()
                            ->from($orderTable)
                            ->where("serial_number = '{$sn}'")
                            ->queryRow();
                        if(!$order){
                            try{
                                $returnResult = Umpay::_umPayResult($v['serial_number']);
                                if($returnResult['status'] == true){
                                    IntegralOfflineNew::paymentSubmitPay($v,AccountFlow::BUSINESS_NODE_EBANK_UM,'使用联动支付');
                                }
                            } catch(Exception $e){
                                continue;
                            }

                        }
                    }
                }

                $id = !empty($result)?$v['id']:0;

                if($id == 0){
                    sleep(60);
                    if($time1 > time()-600){
                        $time1 = time()-300;
                        $time2 =$time1 -300;
                    }else{
                        $time2 = $time2+300;
                        $time1 = $time1+300;
                    }
                }
            }
        }
}