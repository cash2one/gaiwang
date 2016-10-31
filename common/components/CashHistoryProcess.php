<?php
/**
 * 提醒、兑现 处理 
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 14-4-19
 * Time: 下午3:58
 */
class CashHistoryProcess {

    /**
     * 代理会员兑现申请
     * @param array $data CashHistory data
     * @param array $member Member data
     * @return bool
     * @throws Exception
     */
    public static function memberCash(Array $data, Array $member) {
        $time = $data['apply_time'];
        $money = $data['money'] + $data['money'] * $data['factorage'] / 100; // 算出要提现的金额，加上手续费


        $transaction = Yii::app()->db->beginTransaction();
        try {

            // 会员代理账户
            $array = array(
                'account_id' => $member['id'],
                'type' => AccountBalance::TYPE_AGENT,
                'gai_number' => $member['gai_number'],
            );
            $agentAccount = AccountBalance::findRecord($array);

            if($agentAccount['today_amount']<$money){
                throw new Exception("金额校验失败");
            }
            // 会员冻结账户
            $array = array(
                'account_id' => $member['id'],
                'type' => AccountBalance::TYPE_FREEZE,
                'gai_number' => $member['gai_number'],
            );
            $freezeAccount = AccountBalance::findRecord($array);

            // 当月的流水表
            $monthTable = AccountFlow::monthTable();
            //获取可提现账户的余额，商家+代理
            $currentBalance = AccountBalance::getWithdrawBalance($member['id']);
            // 会员冻结流水
            $debit = array(
                'account_id' => $freezeAccount['account_id'],
                'gai_number' => $freezeAccount['gai_number'],
                'card_no' => $freezeAccount['card_no'],
                'date' => date('Y-m-d', $time),
                'create_time' => $time,
                'type' => $freezeAccount['type'],
                'credit_amount' => $money,
                'operate_type' => AccountFlow::OPERATE_TYPE_CASH_APPLY,
                'order_id' => $data['id'],
                'order_code' => $data['code'],
                'remark' => '代理兑现冻结',
                'node' => AccountFlow::BUSINESS_NODE_CASH_CHECK,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH,
                'current_balance'=>$currentBalance,
            );
            // 会员代理账户流水
            $credit = array(
                'account_id' => $agentAccount['account_id'],
                'gai_number' => $agentAccount['gai_number'],
                'card_no' => $agentAccount['card_no'],
                'date' => date('Y-m-d', $time),
                'create_time' => $time,
                'type' => $agentAccount['type'],
                'debit_amount' => $money,
                'operate_type' => AccountFlow::OPERATE_TYPE_CASH_APPLY,
                'order_id' => $data['id'],
                'order_code' => $data['code'],
                'remark' => '代理兑现',
                'node' => AccountFlow::BUSINESS_NODE_CASH_APPLY,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH,
                'current_balance'=>$currentBalance,
            );
            // 会员冻结账户余额更新
            AccountBalance::calculate(array('today_amount' => $money), $freezeAccount['id']);
            // 会员账户余额更新
            AccountBalance::calculate(array('today_amount' => -$money), $agentAccount['id']);
            //插入兑现数据
            if (!isset($data['id'])) {
                Yii::app()->db->createCommand()->insert('{{cash_history}}', $data);
                $cashHistoryId = Yii::app()->db->lastInsertID;
                $debit['order_id'] = $cashHistoryId;
                $credit['order_id'] = $cashHistoryId;
            }

            // 记录月流水表
            Yii::app()->db->createCommand()->insert($monthTable, $credit);
            Yii::app()->db->createCommand()->insert($monthTable, $debit);

            //检测借贷平衡

            $transaction->commit();
            $flag = true;
        } catch (Exception $e) {
            $transaction->rollBack();
            throw new Exception($e->getMessage());
            $flag = false;
        }
        return $flag;
    }

    /**
     * 商家提现申请
     * @param array $data CashHistory data
     * @param array $member Member data
     * @return bool
     */
    public static function enterpriseCash(Array $data, Array $member) {
        $time = $data['apply_time'];
        $money = $data['money'] + $data['money'] * $data['factorage'] / 100; // 算出要提现的金额，加上手续费

        $transaction = Yii::app()->db->beginTransaction();
        try {
            // 会员商家账户
            $array = array(
                'account_id' => $member['id'],
                'type' => AccountBalance::TYPE_MERCHANT,
                'gai_number' => $member['gai_number'],
            );
            $enterpriseAccount = AccountBalance::findRecord($array);

            if($enterpriseAccount['today_amount']<$money){
                throw new Exception("金额校验失败");
            }
            // 会员冻结账户
            $array = array(
                'account_id' => $member['id'],
                'type' => AccountBalance::TYPE_FREEZE,
                'gai_number' => $member['gai_number'],
            );
            $freezeAccount = AccountBalance::findRecord($array);

            // 当月的流水表
            $monthTable = AccountFlow::monthTable();
            //获取可提现账户的余额，商家+代理
            $currentBalance = AccountBalance::getWithdrawBalance($member['id']);
            //'current_balance'=>$currentBalance,
            //商家流水
            $credit = array(
                'account_id' => $enterpriseAccount['account_id'],
                'gai_number' => $enterpriseAccount['gai_number'],
                'card_no' => $enterpriseAccount['card_no'],
                'create_time' => $time,
                'type' => $enterpriseAccount['type'],
                'debit_amount' => $money,
                'operate_type' => AccountFlow::OPERATE_TYPE_CASH_APPLY,
                'order_id' => $data['id'],
                'order_code' => $data['code'],
                'remark' => '商家提现',
                'node' => AccountFlow::BUSINESS_NODE_CASH_APPLY,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH,
                'current_balance'=>$currentBalance,
            );

            // 冻结账户流水
            $debit = array(
                'account_id' => $freezeAccount['account_id'],
                'gai_number' => $freezeAccount['gai_number'],
                'card_no' => $freezeAccount['card_no'],
                'type' => $freezeAccount['type'],
                'credit_amount' => $money,
                'operate_type' => AccountFlow::OPERATE_TYPE_CASH_APPLY,
                'order_id' => $data['id'],
                'order_code' => $data['code'],
                'remark' => '商家提现冻结',
                'node' => AccountFlow::BUSINESS_NODE_CASH_CHECK,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH,
                'current_balance'=>$currentBalance,
            );
            // 冻结账余额更新
            AccountBalance::calculate(array('today_amount' => $money), $freezeAccount['id']);
            // 企业会员余额更新
            AccountBalance::calculate(array('today_amount' => -$money), $enterpriseAccount['id']);
            //插入兑现数据
            if (!isset($data['id'])) {
                Yii::app()->db->createCommand()->insert('{{cash_history}}', $data);
                $cashHistoryId = Yii::app()->db->lastInsertID;
                $debit['order_id'] = $cashHistoryId;
                $credit['order_id'] = $cashHistoryId;
            }

            // 记录月流水表
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit));
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));

            // 检测借贷平衡

            $transaction->commit();
            $flag = true;
        } catch (Exception $e) {
            $transaction->rollBack();
            $flag = false;
        }
        return $flag;
    }
    
    /**
     * 兑现完成处理
     * @param array $data
     * @param array $member
     * @return boolean
     * @throws Exception
     */
    public static function memberCashEnd($data, $member) {
        // 当月的流水表
        $monthTable = AccountFlow::monthTable();
        $money = $data['money'] + $data['money'] * $data['factorage'] / 100; // 算出要兑现的金额，加上手续费
        // 会员冻结账户
        $array = array(
            'account_id' => $member['id'],
            'type' => AccountBalance::TYPE_FREEZE,
            'gai_number' => $member['gai_number'],
        );
        $freezeAccount = AccountBalance::findRecord($array);
        //获取可提现账户的余额，商家+代理
        $currentBalance = AccountBalance::getWithdrawBalance($member['id']);
        // 冻结账户流水
        $debit = array(
            'account_id' => $freezeAccount['account_id'],
            'gai_number' => $freezeAccount['gai_number'],
            'card_no' => $freezeAccount['card_no'],
            'type' => $freezeAccount['type'],
            'debit_amount' => $money,
            'operate_type' => AccountFlow::OPERATE_TYPE_CASH_SUCCESS,
            'order_id' => $data['id'],
            'order_code' => $data['code'],
            'remark' => '代理兑现成功',
            'node' => AccountFlow::BUSINESS_NODE_CASH_CONFIRM,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH,
            'current_balance'=>$currentBalance,
        );

        $transaction = Yii::app()->db->beginTransaction();
        try {
            //加锁
            self::_checkStatus($data);
            // 冻结账户余额
            AccountBalance::calculate(array('today_amount' => -$money), $freezeAccount['id']);
            // 记录月流水表
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));
            //修改状态
            Yii::app()->db->createCommand()->
                update('{{cash_history}}', array('update_time'=>time(),'reason' => $data['reason'], 'status' => $data['status']), "id='{$data['id']}'");

            $transaction->commit();
            $flag = true;
        } catch (Exception $e) {
            $transaction->rollBack();
            $flag = false;
        }
        return $flag;
    }
    /**
     * 提现成功处理
     * @param array $data CashHistory
     * @param array $member Member
     * @return boolean
     * @throws Exception
     */
    public static function enterpriseCashEnd($data, $member) {
    	//return true;
        // 当月的流水表
        $monthTable = AccountFlow::monthTable();
        $money = $data['money'] + $data['money'] * $data['factorage'] / 100; // 算出要兑现的金额，加上手续费
        // 会员冻结账户
        $array = array(
            'account_id' => $member['id'],
            'type' => AccountBalance::TYPE_FREEZE,
            'gai_number' => $member['gai_number'],
        );
        $freezeAccount = AccountBalance::findRecord($array);
        //获取可提现账户的余额，商家+代理
        $currentBalance = AccountBalance::getWithdrawBalance($member['id']);
        // 冻结账户流水
        $debit = array(
            'account_id' => $freezeAccount['account_id'],
            'gai_number' => $freezeAccount['gai_number'],
            'card_no' => $freezeAccount['card_no'],
            'type' => $freezeAccount['type'],
            'debit_amount' => $money,
            'operate_type' => AccountFlow::OPERATE_TYPE_CASH_SUCCESS,
            'order_id' => $data['id'],
            'order_code' => $data['code'],
            'remark' => '商家提现成功',
            'node' => AccountFlow::BUSINESS_NODE_CASH_CONFIRM,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH,
            'current_balance'=>$currentBalance,
        );
        $transaction = Yii::app()->db->beginTransaction();
        try {
            //加锁
            self::_checkStatus($data);
            // 冻结账户
            AccountBalance::calculate(array('today_amount' => -$money), $freezeAccount['id']);
            // 记录月流水表
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));
            //修改状态
            Yii::app()->db->createCommand()->
                update('{{cash_history}}', array('update_time'=>time(),'reason' => $data['reason'], 'status' => $data['status']), "id='{$data['id']}'");
            //检测借贷平衡

            $transaction->commit();
            $flag = true;
        } catch (Exception $e) {
            $transaction->rollBack();
            $flag = false;
        }
        return $flag;
    }
    /**
     * 兑现失败
     * @param array $data CashHistory
     * @param array $member Member
     * @return bool
     */
    public static function memberCashFailed($data, $member) {
        // 当月的流水表
        $monthTable = AccountFlow::monthTable();
        $time = $data['apply_time'];
        // 会员代理账户
        $array = array(
            'account_id' => $member['id'],
            'type' => AccountBalance::TYPE_AGENT,
            'gai_number' => $member['gai_number'],
        );
        $agentAccount = AccountBalance::findRecord($array);
        
        // 会员冻结账户
        $array = array(
            'account_id' => $member['id'],
            'type' => AccountBalance::TYPE_FREEZE,
            'gai_number' => $member['gai_number'],
        );
        $freezeAccount = AccountBalance::findRecord($array);

        $money = $data['money'] + $data['money'] * $data['factorage'] / 100; // 算出要兑现的金额，加上手续费
        //获取可提现账户的余额，商家+代理
        $currentBalance = AccountBalance::getWithdrawBalance($member['id']);
        // 会员冻结流水
        $debit = array(
            'account_id' => $freezeAccount['account_id'],
            'gai_number' => $freezeAccount['gai_number'],
            'card_no' => $freezeAccount['card_no'],
            'type' => $freezeAccount['type'],
            'credit_amount' => -$money,
            'operate_type' => AccountFlow::OPERATE_TYPE_CASH_CANCLE,
            'order_id' => $data['id'],
            'order_code' => $data['code'],
            'remark' => '代理兑现冻结',
            'node' => AccountFlow::BUSINESS_NODE_CASH_CANCEL,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH_CANCEL,
            'current_balance'=>$currentBalance,
        );
        // 会员代理账户流水
        $credit = array(
            'account_id' => $agentAccount['account_id'],
            'gai_number' => $agentAccount['gai_number'],
            'card_no' => $agentAccount['card_no'],
            'type' => $agentAccount['type'],
            'debit_amount' => -$money,
            'operate_type' => AccountFlow::OPERATE_TYPE_CASH_CANCLE,
            'order_id' => $data['id'],
            'order_code' => $data['code'],
            'remark' => '代理兑现失败',
            'node' => AccountFlow::BUSINESS_NODE_CASH_BACK,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH_CANCEL,
            'current_balance'=>$currentBalance,
        );

        $transaction = Yii::app()->db->beginTransaction();
        try {
            //加锁
            self::_checkStatus($data);

            // 冻结账户回滚
            AccountBalance::calculate(array('today_amount' => -$money), $freezeAccount['id']);
            // 代理账户回滚
            AccountBalance::calculate(array('today_amount' => $money), $agentAccount['id']);
            // 记录月流水表
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit));
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));
            //修改状态
            Yii::app()->db->createCommand()->
                    update('{{cash_history}}', array('update_time'=>time(),'reason' => $data['reason'], 'status' => $data['status']), "id='{$data['id']}'");
//            Yii::app()->db->createCommand()->insert('{{sms_log}}', $sms);

            //检测借贷平衡
            $transaction->commit();
            $flag = true;
        } catch (Exception $e) {
            $transaction->rollBack();
            $flag = false;
        }
        return $flag;
    }

    /**
     * 商家提现失败
     * @param array $data CashHistory data
     * @param array $member Member data
     * @return bool
     */
    public static function enterpriseCashFailed($data, $member) {
        $money = $data['money'] + $data['money'] * $data['factorage'] / 100; // 算出要提现的金额，加上手续费
        $time = $data['apply_time'];

        // 会员商家账户
        $array = array(
            'account_id' => $member['id'],
            'type' => AccountBalance::TYPE_MERCHANT,
            'gai_number' => $member['gai_number'],
        );
        $enterpriseAccount = AccountBalance::findRecord($array);
        
        // 会员冻结账户
        $array = array(
            'account_id' => $member['id'],
            'type' => AccountBalance::TYPE_FREEZE,
            'gai_number' => $member['gai_number'],
        );
        $freezeAccount = AccountBalance::findRecord($array);

        // 当月的流水表
        $monthTable = AccountFlow::monthTable();
        //获取可提现账户的余额，商家+代理
        $currentBalance = AccountBalance::getWithdrawBalance($member['id']);
        //商家流水
        $credit = array(
            'account_id' => $enterpriseAccount['account_id'],
            'gai_number' => $enterpriseAccount['gai_number'],
            'card_no' => $enterpriseAccount['card_no'],
            'type' => $enterpriseAccount['type'],
            'debit_amount' => -$money,
            'operate_type' => AccountFlow::OPERATE_TYPE_CASH_CANCLE,
            'order_id' => $data['id'],
            'order_code' => $data['code'],
            'remark' => '商家提现失败',
            'node' => AccountFlow::BUSINESS_NODE_CASH_BACK,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH_CANCEL,
            'current_balance'=>$currentBalance,
        );

        // 冻结账户流水
        $debit = array(
            'account_id' => $freezeAccount['account_id'],
            'gai_number' => $freezeAccount['gai_number'],
            'card_no' => $freezeAccount['card_no'],
            'type' => $freezeAccount['type'],
            'credit_amount' => -$money,
            'operate_type' => AccountFlow::OPERATE_TYPE_CASH_CANCLE,
            'order_id' => $data['id'],
            'order_code' => $data['code'],
            'remark' => '商家提现冻结',
            'node' => AccountFlow::BUSINESS_NODE_CASH_CANCEL,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH_CANCEL,
            'current_balance'=>$currentBalance,
        );

        $transaction = Yii::app()->db->beginTransaction();
        try {
            //加锁
            self::_checkStatus($data);
            // 冻结账余额更新
            AccountBalance::calculate(array('today_amount' => -$money), $freezeAccount['id']);
            // 企业会员余额更新
            AccountBalance::calculate(array('today_amount' => $money), $enterpriseAccount['id']);
            // 记录月流水表
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit));
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));
            
            //修改状态
            Yii::app()->db->createCommand()->
                    update('{{cash_history}}', array('update_time'=>time(),'reason' => $data['reason'], 'status' => $data['status']), "id='{$data['id']}'");

            // 检测借贷平衡

            $transaction->commit();
            $flag = true;
        } catch (Exception $e) {
            $transaction->rollBack();
            Tool::pr($e->getMessage());exit;
            $flag = false;
        }
        return $flag;
    }


    /**
     * 检查重复提交
     * @param $data
     * @throws Exception
     */
    private static function  _checkStatus($data){
        $checkStatus = Yii::app()->db->createCommand('select status from gw_cash_history where id='.$data['id'].' for update')->queryRow();
        if(!$checkStatus){
            throw new Exception('找不到数据');
        }
        if($checkStatus['status']==$data['status']){
            throw new Exception('重复提交了');
        }
        if($checkStatus['status']>$data['status']){
            throw new Exception("不能做回滚操作");
        }
    }
    
          /**
     * 普通会员提现申请
     * @param array $data CashHistory data
     * @param array $member Member data
     * @return bool
     */
    public static function ordinaryMemberCash(Array $data, Array $member) {
        $time = $data['apply_time'];
        $money = $data['money'] + $data['money'] * $data['factorage'] / 100; // 算出要提现的金额，加上手续费

        $transaction = Yii::app()->db->beginTransaction();
        try {
            // 普通会员账户
            $array = array(
                'account_id' => $member['id'],
                'type' => AccountBalance::TYPE_CASH,
                'gai_number' => $member['gai_number'],
            );
            $memberAccount = AccountBalance::findRecord($array);

            if($memberAccount['today_amount']<$money){
                throw new Exception("金额校验失败");
            }
            // 会员冻结账户
            $array = array(
                'account_id' => $member['id'],
                'type' => AccountBalance::TYPE_FREEZE,
                'gai_number' => $member['gai_number'],
            );
            $freezeAccount = AccountBalance::findRecord($array);

            // 当月的流水表
            $monthTable = AccountFlow::monthTable();
            //获取可提现账户的余额，普通会员
            $currentBalance = AccountBalance::getMemberBalance($member['id']);
          
            //'current_balance'=>$currentBalance,
            //会员流水
            $credit = array(
                'account_id' => $memberAccount['account_id'],
                'gai_number' => $memberAccount['gai_number'],
                'card_no' => $memberAccount['card_no'],
                'create_time' => $time,
                'type' => $memberAccount['type'],
                'debit_amount' => $money,
                'operate_type' => AccountFlow::OPERATE_TYPE_CASH_APPLY,
                'order_id' => $data['id'],
                'order_code' => $data['code'],
                'remark' => '普通会员提现',
                'node' => AccountFlow::BUSINESS_NODE_CASH_APPLY,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH,
                'current_balance'=>$currentBalance,
            );

            // 冻结账户流水
            $debit = array(
                'account_id' => $freezeAccount['account_id'],
                'gai_number' => $freezeAccount['gai_number'],
                'card_no' => $freezeAccount['card_no'],
                'type' => $freezeAccount['type'],
                'credit_amount' => $money,
                'operate_type' => AccountFlow::OPERATE_TYPE_CASH_APPLY,
                'order_id' => $data['id'],
                'order_code' => $data['code'],
                'remark' => '普通会员提现冻结',
                'node' => AccountFlow::BUSINESS_NODE_CASH_CHECK,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH,
                'current_balance'=>$currentBalance,
            );
            // 冻结账余额更新
            AccountBalance::calculate(array('today_amount' => $money), $freezeAccount['id']);
            // 企业会员余额更新
            AccountBalance::calculate(array('today_amount' => -$money), $memberAccount['id']);
            //插入兑现数据
            if (!isset($data['id'])) {
                Yii::app()->db->createCommand()->insert('{{cash_history}}', $data);
                $cashHistoryId = Yii::app()->db->lastInsertID;
                $debit['order_id'] = $cashHistoryId;
                $credit['order_id'] = $cashHistoryId;
            }

            // 记录月流水表
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit));
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));

            // 检测借贷平衡

            $transaction->commit();
            $flag = true;
        } catch (Exception $e) {
            var_dump($e->getMessage());
            $transaction->rollBack();
            $flag = false;
        }
        return $flag;
    }

      /**
     * 普通会员提现成功处理
     * @param array $data CashHistory
     * @param array $member Member
     * @return boolean
     * @throws Exception
     */
    public static function ordinaryMemberCashEnd($data, $member) {
        // 当月的流水表
        $monthTable = AccountFlow::monthTable();
        $money = $data['money'] + $data['money'] * $data['factorage'] / 100; // 算出要兑现的金额，加上手续费
        // 会员冻结账户
        $array = array(
            'account_id' => $member['id'],
            'type' => AccountBalance::TYPE_FREEZE,
            'gai_number' => $member['gai_number'],
        );
        $freezeAccount = AccountBalance::findRecord($array);
        //获取可提现账户的余额，普通会员
        $currentBalance = AccountBalance::getMemberBalance($member['id']);
        // 冻结账户流水
        $debit = array(
            'account_id' => $freezeAccount['account_id'],
            'gai_number' => $freezeAccount['gai_number'],
            'card_no' => $freezeAccount['card_no'],
            'type' => $freezeAccount['type'],
            'debit_amount' => $money,
            'operate_type' => AccountFlow::OPERATE_TYPE_CASH_SUCCESS,
            'order_id' => $data['id'],
            'order_code' => $data['code'],
            'remark' => '普通会员提现成功',
            'node' => AccountFlow::BUSINESS_NODE_CASH_CONFIRM,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH,
            'current_balance'=>$currentBalance,
        );
        $transaction = Yii::app()->db->beginTransaction();
        try {
            //加锁
            self::_checkStatus($data);
            // 冻结账户
            AccountBalance::calculate(array('today_amount' => -$money), $freezeAccount['id']);
            // 记录月流水表
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));
            //修改状态
            Yii::app()->db->createCommand()->
                update('{{cash_history}}', array('update_time'=>time(),'reason' => $data['reason'], 'status' => $data['status']), "id='{$data['id']}'");
            //检测借贷平衡

            $transaction->commit();
            $flag = true;
        } catch (Exception $e) {
            $transaction->rollBack();
            $flag = false;
        }
        return $flag;
    }
     /**
     * 普通会员提现失败
     * @param array $data CashHistory data
     * @param array $member Member data
     * @return bool
     */
    public static function ordinaryMemberCashFailed($data, $member) {
        $money = $data['money'] + $data['money'] * $data['factorage'] / 100; // 算出要提现的金额，加上手续费
        $time = $data['apply_time'];

        // 会员商家账户
        $array = array(
            'account_id' => $member['id'],
            'type' => AccountBalance::TYPE_CASH,
            'gai_number' => $member['gai_number'],
        );
        $memberAccount = AccountBalance::findRecord($array);
        
        // 会员冻结账户
        $array = array(
            'account_id' => $member['id'],
            'type' => AccountBalance::TYPE_FREEZE,
            'gai_number' => $member['gai_number'],
        );
        $freezeAccount = AccountBalance::findRecord($array);

        // 当月的流水表
        $monthTable = AccountFlow::monthTable();
        //获取可提现账户的余额，会员
        $currentBalance = AccountBalance::getMemberBalance($member['id']);
        //会员流水
        $credit = array(
            'account_id' => $memberAccount['account_id'],
            'gai_number' => $memberAccount['gai_number'],
            'card_no' => $memberAccount['card_no'],
            'type' => $memberAccount['type'],
            'debit_amount' => -$money,
            'operate_type' => AccountFlow::OPERATE_TYPE_CASH_CANCLE,
            'order_id' => $data['id'],
            'order_code' => $data['code'],
            'remark' => '普通会员提现失败',
            'node' => AccountFlow::BUSINESS_NODE_CASH_BACK,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH_CANCEL,
            'current_balance'=>$currentBalance,
        );

        // 冻结账户流水
        $debit = array(
            'account_id' => $freezeAccount['account_id'],
            'gai_number' => $freezeAccount['gai_number'],
            'card_no' => $freezeAccount['card_no'],
            'type' => $freezeAccount['type'],
            'credit_amount' => -$money,
            'operate_type' => AccountFlow::OPERATE_TYPE_CASH_CANCLE,
            'order_id' => $data['id'],
            'order_code' => $data['code'],
            'remark' => '普通会员提现冻结',
            'node' => AccountFlow::BUSINESS_NODE_CASH_CANCEL,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_CASH_CANCEL,
            'current_balance'=>$currentBalance,
        );

        $transaction = Yii::app()->db->beginTransaction();
        try {
            //加锁
            self::_checkStatus($data);
            // 冻结账余额更新
            AccountBalance::calculate(array('today_amount' => -$money), $freezeAccount['id']);
            // 企业会员余额更新
            AccountBalance::calculate(array('today_amount' => $money), $memberAccount['id']);
            // 记录月流水表
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit));
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));
            
            //修改状态
            Yii::app()->db->createCommand()->
                    update('{{cash_history}}', array('update_time'=>time(),'reason' => $data['reason'], 'status' => $data['status']), "id='{$data['id']}'");

            // 检测借贷平衡

            $transaction->commit();
            $flag = true;
        } catch (Exception $e) {
            $transaction->rollBack();
            Tool::pr($e->getMessage());exit;
            $flag = false;
        }
        return $flag;
    }
}
