<?php

/**
 * 售货机相关命令 
 * @author lhao <wanyun_liu@163.com>
 */
class VendingCommand extends CConsoleCommand
{
    
    //售货机退货命令 SKU出来就取消
    public function actionReturn()
    {
        while(true)
        {
            try{
                $db = Yii::app()->db;
                $time = time();
                $over_time = $time - 600;//5分钟
                
                $sql = "SELECT fcpr.* FROM gw_franchisee_consumption_pre_record fcpr LEFT JOIN gw_franchisee_consumption_record fcr ON fcr.serial_number = fcpr.serial_number  WHERE fcpr.success_amount=0 AND fcpr.is_pay = 1 AND fcpr.record_type = 4 AND fcpr.status = 0  AND fcr.id IS NULL and fcpr.create_time<{$over_time} LIMIT 10 ";
                $preOrders = $db->createCommand($sql)->queryAll();
                if(!empty($preOrders))
                {
                    $machineids = array();
                    foreach($preOrders as $k=>$val)
                    {
                        $sql = 'select * from gaitong.gt_vending_machine where id = '.$val['machine_id'];
                        $machine = $db->createCommand($sql)->queryRow();
                        $this->preConsumeConfirm($val, $machine);
                    }
        
                }
            }catch (Exception $e){
                $this->addLog('vendingReturn.log',$e->getMessage());
                return false;
            }
            sleep(10);
        }
    }
    
    
    /**
     * 售货机返回金额
     */
    protected  function preConsumeConfirm($preOrder,array $machine)
    {
        try{
            $money = 0;
            $successNum = 0;
            $recordType = $preOrder['record_type'];
            IntegralOfflineNew::$time = time();
            $amountData = Symbol::exchangeMoney($money, $preOrder['symbol']);
            $amount = $amountData['amount'];
            $base_price = $amountData['base_price'];
            //预消费订单
            $preOrderTable = FranchiseeConsumptionPreRecord::tableName();
            $orderTable = FranchiseeConsumptionRecord::model()->tableName();
             
            $db = Yii::app()->db;

            $member = $db->createCommand()
                        ->select("id,gai_number,status,type_id,mobile")
                        ->from(Member::tableName())
                        ->where("id = '{$preOrder['member_id']}'")
                        ->queryRow();
    
            $freezingBalanceRes = AccountBalance::findRecord(array('account_id' => $member['id'], 'type' => AccountBalance::TYPE_FREEZE, 'gai_number' => $member['gai_number']));
            if($freezingBalanceRes['today_amount']<$preOrder['amount'])
                IntegralOfflineNew::throwErrorMessage('预消费订单有出错，请联系相关人员处理');
            //开启事务
    
            $returnAmount = floatval(bcsub($preOrder['amount'],$amount,2));
    
    
            $franchisee = $db->createCommand()
            ->select('id,member_id,name,member_discount,gai_discount,street,province_id,city_id,district_id')
            ->from('{{franchisee}}')
            ->where('id=:id',array(':id'=>$machine['franchisee_id']))
            ->queryRow();
            if(empty($franchisee))
                IntegralOfflineNew::throwErrorMessage('没有对应的供应商');
    
            $memberDiscount = $franchisee['member_discount'] / 100;
            $gaiwangDiscount = $franchisee['gai_discount'] / 100;
            //分配金额公式:金额 * (会员-盖网)
            $distributeMoney = ( $memberDiscount==0 || $memberDiscount - $gaiwangDiscount<0 )?0:bcmul($amount, ($memberDiscount - $gaiwangDiscount), 2);//分配金额公式:金额 * (会员-盖网)
    
    
            $remark = IntegralOfflineNew::getContent(IntegralOfflineNew::REANCHISEE_CONSUMPTION_RECORD_CONTENT, array(
                    $member['gai_number'], $franchisee['name'], $machine['name'], IntegralOfflineNew::formatPrice($amount), IntegralOfflineNew::formatPrice($distributeMoney), $franchisee['gai_discount'], $franchisee['member_discount'], IntegralOfflineNew::formatPrice(($amount - $distributeMoney)),
            ),$recordType);
            //开启事务
            $transaction = $db->beginTransaction();
            $accountFlowTable = AccountFlow::monthTable(IntegralOfflineNew::$time);
    
            $recordGoodsTable = FranchiseeConsumptionRecordGoods::tableName();
            $recordGoods = $db->createCommand()
            ->select("id,vending_goods_id,pay_num,success_num,fail_num")
            ->from($recordGoodsTable)
            ->where("serial_number = '{$preOrder['serial_number']}'")
            ->queryRow();
            if(empty($recordGoods))IntegralOfflineNew::throwErrorMessage("订单商品没有此次下单数据");
            if($recordGoods['pay_num']<$successNum)IntegralOfflineNew::throwErrorMessage("成功的数量比下单数量还大");
            $failNum = $recordGoods['pay_num'] - $successNum;
            $sql = 'update '.$recordGoodsTable.' set success_num = '.$successNum.' , fail_num = '.$failNum.' where id = '.$recordGoods['id'];
            $db->createCommand($sql)->execute();

            $goods = $db->createCommand()
            ->select("id,machine_id,stock,status,sold,name")
            ->from(VendingMachineGoods::tableName())
            ->where("id = {$recordGoods['vending_goods_id']}")
            ->queryRow();
            if(empty($goods))IntegralOfflineNew::throwErrorMessage('商品不存在或已下架');
            if($goods['stock']<$successNum)IntegralOfflineNew::throwErrorMessage('商品库存不够');
            if($goods['machine_id']!=$machine['id'])IntegralOfflineNew::throwErrorMessage('此商品不在此机器上，商品参数错误，不能消费!');
            //扣减库存
            VendingMachineGoods::sellGoods($goods,$successNum,$member['id']);
    
            
            //更新预消费订单状态
            $sql = 'update '.$preOrderTable.' set status = 2 where id = '.$preOrder['id'];
            $db->createCommand($sql)->execute();
            
            //退款处理
            if($returnAmount>0)
            {
                $recordId  = isset($recordId)?$recordId:0;
                AccountFlow::returnAccounts($accountFlowTable,$freezingBalanceRes,$returnAmount,$preOrder['serial_number'],$recordId);
                if(isset($goods) && !empty($member['mobile']))
                {
                    $smsContent = '您好，您在'.$machine['name'].'售货机购买的商品'.$goods['name'].'有'.$failNum.'件未能成功出货，现在返回¥'.$returnAmount.'金额到你'.$member['gai_number'].'的账号上，请留意查看账户。';
                    $datas = array($machine['name'],$goods['name'],$failNum,$returnAmount,$member['gai_number']);
                    $tmpId = Tool::getConfig('smsmodel','machineShipmentFailId');
                    SmsLog::addSmsLog($member['mobile'], $smsContent, $preOrder['id'], SmsLog::TYPE_VENDING_RETURN,null,true, $datas, $tmpId);
                }
            }
            if (!DebitCredit::checkFlowByCode($accountFlowTable, $preOrder['serial_number'])) {
                throw new ErrorException('Code DebitCredit Error!', '010');
            }
            $transaction->commit();
            return true;
        }catch (Exception $e){
            if(isset($transaction))$transaction->rollBack();
            $this->addLog('vendingReturn.log',$e->getMessage(),$preOrder);
            throw new Exception($e->getMessage());
            return false;
        }
    }
    
    /**
     * 记录访问日志
     * @param $fileName
     * @param string $content
     * @param array $array
     */
    protected function addLog($fileName,$content='',$array=array()){
        $root = Yii::getPathOfAlias('root');
        //        $num = date("Ym").(date("W")-date("W",strtotime(date("Y-m-01"))));
        $num = date("mda");
        $path = $root .DS.'api'. DS . 'runtime' . DS . $fileName.'-'.$num;
        $str = PHP_EOL."------------------------------------------" .PHP_EOL.
        "ctr: , time: " . date("m-d H:i:s") .
        PHP_EOL . $content;
        if(!empty($array)){
            $str .= PHP_EOL;
            $str .= var_export($array, TRUE);
        }
        $str .= PHP_EOL;
        @file_put_contents($path, $str, FILE_APPEND);
    }
}