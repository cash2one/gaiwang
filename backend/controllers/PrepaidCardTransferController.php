<?php

/**
 * 充值卡转账控制器
 * @author ling.wu
 */
class PrepaidCardTransferController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
    * 不作权限控制的action
    * @return string
    */
    public function allowedActions() {
       return 'getHistoryValue';
    }

    /**
     * 充值卡转账列表
     */
    public function actionAdmin()
    {
        $model = new PrepaidCardTransfer('search');
        $model->unsetAttributes();
        if (isset($_GET['PrepaidCardTransfer']))
            $model->attributes = $this->getParam('PrepaidCardTransfer');

        if ($model->transfer_gw) {
            $member_id = Yii::app()->db->createCommand()->select('id')->from('{{member}}')
                ->where('gai_number=:gai_number', array(':gai_number' => $model->transfer_gw))->queryScalar();
            $member_id ? ($model->transfer_member_id = $member_id) : ($model->transfer_member_id = -1);
        }
        if ($model->receiver_gw){
            $member_id = Yii::app()->db->createCommand()->select('id')->from('{{member}}')
                ->where('gai_number=:gai_number', array(':gai_number' => $model->receiver_gw))->queryScalar();
            $member_id ? ($model->receiver_member_id = $member_id) : ($model->receiver_member_id = -1);
        }

        $this->render('admin', compact('model'));
    }

    /**
     * 创建充值卡转帐申请
     */
    public function actionCreate(){
        $model = new PrepaidCardTransfer();
        $this->performAjaxValidation($model);
        if($this->isPost()){
            $model->attributes = $this->getParam('PrepaidCardTransfer');
            if($model->validate()){
                $model->author_ip = Tool::getIP();
                $model->author_id = Yii::app()->user->id;
                $model->author_name = Yii::app()->user->name;
                $model->create_time = time();

                $trans = Yii::app()->db->beginTransaction();
                try {
                    if($model->transfer_member_id == $model->receiver_member_id){
                        throw new Exception(Yii::t('PrepaidCardTransfer', '转账人不能与接收人相同！'));
                    }
                    if ($model->save(false)) {
                        $model->transfer_gw = $model->transfer->gai_number;
                        //检查历史余额并冻结积分
                        $this->checkAndFreeze($model);
                    }
                    @SystemLog::record(Yii::app()->user->name."添加充值卡转账申请：$model->id 成功");
                    $this->setFlash('success',Yii::t('PrepaidCardTransfer', '创建充值卡转账申请成功！'));
                    $trans->commit();
                    $this->redirect($this->createAbsoluteUrl('admin'));
                }catch (Exception $e){
                    $trans->rollback();
                    $this->setFlash('error',$e->getMessage());
                }
            }else{
                $this->setFlash('error',CHtml::errorSummary($model));
            }


        }
        $this->render('create',array('model'=>$model));
    }

    /**
     * 创建转帐申请
     */
    public function actionCreateTransfer()
    {
        $model = new PrepaidCardTransfer('createTransfer');
        $this->performAjaxValidation($model);
        if($this->isPost()){
            $model->attributes = $this->getParam('PrepaidCardTransfer');
            if($model->validate()){
                $model->author_ip = Tool::getIP();
                $model->author_id = Yii::app()->user->id;
                $model->author_name = Yii::app()->user->name;
                $model->create_time = time();
                $model->money = $model->value * 0.9;

                $trans = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save(false)) {
                        $model->transfer_gw = $model->transfer->gai_number;
                        //检查历史余额并冻结积分
                        $this->checkAndFreeze($model);
                    }
                    @SystemLog::record(Yii::app()->user->name."添加转账申请：$model->id 成功");
                    $this->setFlash('success',Yii::t('PrepaidCardTransfer', '创建转账申请成功！'));
                    $trans->commit();
                    $this->redirect($this->createAbsoluteUrl('admin'));
                }catch (Exception $e){
                    $trans->rollback();
                    $this->setFlash('error',$e->getMessage());
                }
            }else{
                $this->setFlash('error',CHtml::errorSummary($model));
            }


        }
        $model->setScenario('createTransfer'); //如果余额足，会丢失，所以重新设置
        $this->render('create',array('model'=>$model));
    }

    /**
     * 充值卡转帐申请审核
     * @param $id
     * @param $status
     */
    public function actionAudit($id,$status){
        if(is_numeric($id) && is_numeric($status) && in_array($status,array(PrepaidCardTransfer::STATUS_NO,PrepaidCardTransfer::STATUS_YES))){
            $model = PrepaidCardTransfer::model()->findByPk($id);
            $model->auditor_ip = Tool::getIP();
            $model->auditor_id = Yii::app()->user->id;
            $model->auditor_name = Yii::app()->user->name;
            $model->audit_time = time();
            $model->status = $status;
            if($this->doAudit($model)){
                @SystemLog::record(Yii::app()->user->name."充值卡转账审核操作：$model->id 成功");
                $this->setFlash('success','操作成功！');
            }
        }else{
            $this->setFlash('error','参数错误');
        }
        $this->redirect($this->createAbsoluteUrl('admin'));
    }

    /**
     * 审核操作
     * @param $model
     * @return bool
     * @throws CDbException
     */
    public function doAudit($model){
        $gai_number = $model->transfer->gai_number;
        $trans = Yii::app()->db->beginTransaction();
        $flag = false;
        try {
            if($model->save(false)) {
                //转账人冻结账户信息(旧)
                $freezeInfo = AccountBalanceHistory::findRecord(array('account_id' => $model->transfer_member_id, 'type' => AccountBalance::TYPE_FREEZE, 'gai_number' => $gai_number));

                $rs = bccomp($freezeInfo['today_amount'],$model->money,2);
                if ($rs == -1) {
                    throw new Exception(Yii::t('PrepaidCardTransfer', '冻结账户余额不足！'));
                }
                //转账人消费账户信息(旧)
                $consumeInfo = AccountBalanceHistory::findRecord(array('account_id' => $model->transfer_member_id, 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => $gai_number));
                $order_code = $this->createOrderCode($model->id);
                // 借方
                $debit = array(
                    'account_id' => $consumeInfo['account_id'],
                    'gai_number' => $consumeInfo['gai_number'],
                    'card_no' => $consumeInfo['card_no'],
                    'order_id' => $model->id,
                    'order_code' => $model->card_number?$model->card_number:$order_code,
                    'type' => AccountFlow::TYPE_CONSUME,
                    'debit_amount' => '-'.$model->money,
                    'operate_type' => AccountFlow::OPERATE_TYPE_TRANSFER_UNFREEZE,
                    'remark' => $model->card_number?'充值卡转账积分解冻，金额为：￥' . $model->money:'转账积分解冻，金额为：￥' . $model->money,
                    'node' => AccountFlow::MEMBER_HISTORY_BALANCE_UNFREEZE,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_OTHER_REFUND,
                );

                // 贷方
                $credit = array(
                    'account_id' => $freezeInfo['account_id'],
                    'gai_number' => $freezeInfo['gai_number'],
                    'card_no' => $freezeInfo['card_no'],
                    'order_id' => $model->id,
                    'order_code' => $model->card_number?$model->card_number:$order_code,
                    'type' => AccountFlow::TYPE_FREEZE,
                    'credit_amount' => '-'.$model->money,
                    'operate_type' => AccountFlow::OPERATE_TYPE_TRANSFER_UNFREEZE,
                    'remark' => $model->card_number?'充值卡转账积分解冻，金额为：￥' .$model->money:'转账积分解冻，金额为：￥' .$model->money,
                    'node' => AccountFlow::MEMBER_HISTORY_BALANCE_UNFREEZE_INTO,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_OTHER_REFUND,
                );
                //加转账人消费账户金额(旧)
                if(!AccountBalanceHistory::calculate(array('today_amount'=>$model->money),$consumeInfo['id']))
                    throw new Exception(Yii::t('PrepaidCardTransfer', '加消费账户金额失败！'));
                //减转账人冻结账户金额(旧)
                if(!AccountBalanceHistory::calculate(array('today_amount'=>'-'.$model->money),$freezeInfo['id']))
                    throw new Exception(Yii::t('PrepaidCardTransfer', '减冻结账户金额失败！'));

                // 当月的流水表（旧）
                $monthTable = AccountFlowHistory::monthTable();
                // 记录月流水表（旧）
                Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));
                Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit));

                if($model->status == PrepaidCardTransfer::STATUS_YES){
                    //接收人消费账户信息(旧)
                    $receiver_consumeInfo = AccountBalanceHistory::findRecord(array('account_id' => $model->receiver_member_id, 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => $model->receiver->gai_number));
                    if($model->card_number) {
                        $debit['type'] = AccountFlow::TYPE_CONSUME;
                        $debit['debit_amount'] = '-' . $model->money;
                        $debit['operate_type'] = AccountFlow::OPERATE_TYPE_CARD_RECHARGE;
                        $debit['remark'] ='使用积分充值卡充值，金额为：￥' . '-' . $model->money;
                        $debit['node'] = AccountFlow::BUSINESS_NODE_CARD_RECHARGE;
                        $debit['transaction_type'] = AccountFlow::TRANSACTION_TYPE_RECHARGE;
                        $debit['recharge_type'] = AccountFlow::RECHARGE_TYPE_CARD;
                        $debit['prepaid_card_no'] = $model->card_number;
                        $re_debit['order_id'] = '';
                        $re_debit['order_code'] = '';

                        $re_debit['account_id'] = $receiver_consumeInfo['account_id'];
                        $re_debit['gai_number'] = $receiver_consumeInfo['gai_number'];
                        $re_debit['card_no'] = $receiver_consumeInfo['card_no'];
                        $re_debit['type'] = AccountFlow::TYPE_CONSUME;
                        $re_debit['debit_amount'] = $model->money;
                        $re_debit['operate_type'] = AccountFlow::OPERATE_TYPE_CARD_RECHARGE;
                        $re_debit['remark'] = '使用积分充值卡充值，金额为：￥' . $model->money;
                        $re_debit['node'] = AccountFlow::BUSINESS_NODE_CARD_RECHARGE;
                        $re_debit['transaction_type'] = AccountFlow::TRANSACTION_TYPE_RECHARGE;
                        $re_debit['recharge_type'] = AccountFlow::RECHARGE_TYPE_CARD;
                        $re_debit['prepaid_card_no'] = $model->card_number;
                        $re_debit['order_id'] = $model->id;
                        $re_debit['order_code'] = $model->card_number;
                    }else{
                        $debit['type'] = AccountFlow::TYPE_CONSUME;
                        $debit['credit_amount'] = 0;
                        $debit['debit_amount'] = $model->money;
                        $debit['operate_type'] =  AccountFlow::OPERATE_TYPE_TRANSFER_MONEY;
                        $debit['remark'] =  '转账转出金额为：￥' . $model->money;
                        $debit['node'] =  AccountFlow::MEMBER_HISTORY_BALANCE_TRANSFER;
                        $debit['transaction_type'] = AccountFlow::TRANSACTION_TYPE_TRANSFER;

                        $re_debit['account_id'] = $receiver_consumeInfo['account_id'];
                        $re_debit['gai_number'] = $receiver_consumeInfo['gai_number'];
                        $re_debit['card_no'] = $receiver_consumeInfo['card_no'];
                        $re_debit['type'] = AccountFlow::TYPE_CONSUME;
                        $re_debit['credit_amount'] = $model->money;
                        $re_debit['order_id'] = $model->id;
                        $re_debit['order_code'] = $order_code;
                        $re_debit['operate_type'] = AccountFlow::OPERATE_TYPE_TRANSFER_MONEY;
                        $re_debit['remark'] = '转账转入金额为：￥' . $model->money;
                        $re_debit['node'] = AccountFlow::MEMBER_HISTORY_BALANCE_TRANSFER_INTO;
                        $re_debit['transaction_type'] = AccountFlow::TRANSACTION_TYPE_TRANSFER;
                    }

                    //减转账人消费账户金额(旧)
                    if(!AccountBalanceHistory::calculate(array('today_amount'=>'-'.$model->money),$consumeInfo['id']))
                        throw new Exception(Yii::t('PrepaidCardTransfer', '减消费账户金额失败！'));
                    //加接收人消费账户金额(旧)
                    if(!AccountBalanceHistory::calculate(array('today_amount'=>$model->money),$receiver_consumeInfo['id']))
                        throw new Exception(Yii::t('PrepaidCardTransfer', '加接收账户金额失败！'));
                    if($model->card_number) {
                        //修改充值卡所属人
                        Yii::app()->db->createCommand()->update('{{prepaid_card}}', array('member_id' => $model->receiver_member_id, 'use_time' => time()), 'number=:number', array(':number' => $model->card_number));
                    }

                    // 记录月流水表（旧）
                    Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));
                    Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($re_debit));

                    //检测借贷平衡
//                    if (!DebitCredit::checkFlowByCode($monthTable, $model->card_number?$model->card_number:$order_code)) {
//                        throw new Exception('DebitCredit Error!', '009');
//                    }
                    $flag = true;
                }
            }else{
                throw new Exception(Yii::t('PrepaidCardTransfer', '状态保存失败！'));
            }
            $trans->commit();
        }catch (Exception $e){
            $trans->rollback();
            $this->setFlash('error',$e->getMessage().CHtml::errorSummary($model));
        }

        // 接收人发送短信
        $re_member= $model->receiver;
        if (true === $flag && $re_member->mobile && $model->card_number) {
            $totalMoney = Member::getTotalPrice(AccountInfo::TYPE_CONSUME, $re_member->id, $re_member->gai_number);
            $temp = Tool::getConfig('smsmodel', 'usePrepaidcarSucceed');
            $time= date('Y/m/d H:i:s', time());
            $msg = strtr($temp, array(
                '{0}' => $re_member->gai_number,
                '{1}' => $time,
                '{2}' => $model->card_number,
                '{3}' => $model->value,
                '{4}' => Common::convertSingle($totalMoney, $re_member->type_id)
            ));
            $datas = array($re_member->gai_number, $time, $model->card_number, $model->value);
            $tmpId = $this->getConfig('smsmodel','usePrepaidcarSucceedId');
            SmsLog::addSmsLog($re_member->mobile, $msg, $model->card_number, SmsLog::TYPE_CARD_RECHARGE,null,true, $datas, $tmpId); // 记录并短息日志
        }

        return $flag;
    }

    /**
     * 创建旧余额转账订单号
     * @param $id
     * @return string
     */
    public function createOrderCode($id){
        $len = strlen($id);
        $str ='LSZZ1' . str_repeat('0',(11-$len)) . $id;
        return $str;
    }


    /**
     * 检查并冻结积分
     * @param $model
     * @throws Exception
     */
    public function checkAndFreeze($model){

        //消费账户信息(旧)
        $consumeInfo = AccountBalanceHistory::findRecord(array('account_id'=>$model->transfer_member_id,'type'=>AccountBalance::TYPE_CONSUME,'gai_number'=>$model->transfer_gw));
        $model->history_money = $consumeInfo['today_amount'];
        if($model->transfer_member_id == $model->receiver_member_id){
            throw new Exception(Yii::t('PrepaidCardTransfer', '转账人不能与接收人相同！'));
        }
        if($consumeInfo['today_amount'] < $model->money){
            throw new Exception(Yii::t('PrepaidCardTransfer', '转账人余额不足！'));
        }else{
            //冻结账户信息(旧)
            $freezeInfo = AccountBalanceHistory::findRecord(array('account_id'=>$model->transfer_member_id,'type'=>AccountBalance::TYPE_FREEZE,'gai_number'=>$model->transfer_gw));

            //减消费账户金额(旧)
            if(!AccountBalanceHistory::calculate(array('today_amount'=>'-'.$model->money),$consumeInfo['id']))
                throw new Exception(Yii::t('PrepaidCardTransfer', '减消费账户金额失败！'));
            //增加冻结账户金额(旧)
            if(!AccountBalanceHistory::calculate(array('today_amount'=>$model->money),$freezeInfo['id']))
                throw new Exception(Yii::t('PrepaidCardTransfer', '增加冻结账户金额失败！'));

            $order_code = $this->createOrderCode($model->id);
            // 借方
            $debit = array(
                'account_id' => $consumeInfo['account_id'],
                'gai_number' => $consumeInfo['gai_number'],
                'card_no' => $consumeInfo['card_no'],
                'order_id' => $model->id,
                'order_code' => $model->card_number?$model->card_number:$order_code,
                'type' => AccountFlow::TYPE_CONSUME,
                'debit_amount' => $model->money,
                'operate_type' =>AccountFlow::OPERATE_TYPE_TRANSFER_FREEZE,
                'remark' => $model->card_number?'充值卡转账积分冻结，金额为：￥' .$model->money:('转账积分冻结，金额为：￥' .$model->money),
                'node' => AccountFlow::MEMBER_HISTORY_BALANCE_FREEZE,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_OTHER_REFUND,
            );

            // 贷方
            $credit = array(
                'account_id' => $freezeInfo['account_id'],
                'gai_number' => $freezeInfo['gai_number'],
                'card_no' => $freezeInfo['card_no'],
                'order_id' => $model->id,
                'order_code' => $model->card_number?$model->card_number:$order_code,
                'type' => AccountFlow::TYPE_FREEZE,
                'credit_amount' => $model->money,
                'operate_type' => AccountFlow::OPERATE_TYPE_TRANSFER_FREEZE,
                'remark' => $model->card_number?'充值卡转账积分冻结，金额为：￥' .$model->money:('转账积分冻结，金额为：￥' .$model->money),
                'node' => AccountFlow::MEMBER_HISTORY_BALANCE_FREEZE_INTO,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_OTHER_REFUND,
            );

            // 当月的流水表（旧）
            $monthTable = AccountFlowHistory::monthTable();
            // 记录月流水表（旧）
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit));

            //检测借贷平衡
            if (!DebitCredit::checkFlowByCode($monthTable, $model->card_number)) {
                throw new Exception('DebitCredit Error!', '009');
            }
        }
    }

    /**
     * 获取历史余额
     */
    public function actionGetHistoryValue(){
        if($this->isAjax()){
            $gw = $this->getParam('transfer_gw');
            $money =  AccountBalanceHistory::getTodayAmountByGaiNumber($gw);
            echo Common::convertSingle($money,MemberType::MEMBER_OFFICAL);
        }
    }

}
