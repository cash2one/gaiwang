<?php
/**
 * 盖讯通红包剩余余额处理
 * @author liao jiawei <569114018@qq.com>
 * Date: 2016/2/17
 * Time: 10:29
 */

class GxtEnvelopeCommand extends CConsoleCommand{

    //返回剩余红包余额（非接口）
    public function actionBackEnvelopeList(){

        $startTime = strtotime('2016-02-01 00:00:00');
        $endTime = strtotime('2016-02-16 23:59:59');

        $sql = "SELECT a.gai_number,a.red_envelope_id,(a.credit_amount-SUM(b.debit_amount)) as money FROM gw_app_envelope as a LEFT JOIN gw_app_envelope as b ON a.red_envelope_id=b.red_envelope_id WHERE ( a.createtime BETWEEN $startTime and $endTime ) and a.credit_amount > 0 GROUP BY a.red_envelope_id HAVING money>0 ";
        $list = Yii::app()->db->createCommand($sql)->queryAll();

        $surplus = array();

        foreach($list as $key => $value){

                $member = Yii::app()->db->createCommand()
                    ->select()
                    ->from('{{member}}')
                    ->where('gai_number=:gai_number', array(':gai_number' => $value['gai_number']))
                    ->queryRow();   //获取帐号会员信息

                $appLog = array('red_envelope_id'=>$value['red_envelope_id'],
                    'gai_number'=>$value['gai_number'],
                    'debit_amount'=>$value['money'],
                    'envelope_type'=>$value['envelope_type'],
                    'code'=>Tool::buildOrderNo(20,'gxtrd'),
                    'createtime'=>time()
                );

                $trans = Yii::app()->db->beginTransaction();
                $flag = false;
                try{

                    Yii::app()->db->createCommand()->insert("{{app_envelope}}", $appLog);
                    $appLog['id'] = Yii::app()->db->getLastInsertID();

                    $balance = self::getMemberAccountInfo($member, AccountInfo::TYPE_CONSUME, false);//获取会员帐号
                    $balanceOnlineOrder = CommonAccount::getOnlineAccountForHistory(); //线上总账户
                    $flowTableName = AccountFlowHistory::monthTable(); //流水日志表名

                    $flowLog['member'] = AccountFlow::mergeFlowData($appLog, $balance, array(
                        //'credit_amount' => $getMoney,
                        'debit_amount' => -$value['money'],
                        'operate_type' => AccountFlow::OPERATE_TYPE_ENVELOPE_UNFREEZE,
                        'remark' => '退回红包金额：￥' . $value['money'],
                        'node' => AccountFlow::BUSINESS_NODE_ONLINE_ENVELOPE_BACK,
                        'transaction_type' => AccountFlow::TRANSACTION_TYPE_ENVELOPE,
                        'parent_id' => $value['envelope_type'],
                    ));
                    if (!AccountBalanceHistory::calculate(array('today_amount' => $value['money']), $balance['id'])) {
                        throw new Exception('UPDATE MEMBERACCOUNT ERROR');
                    }

                    $flowLog['onlineOrder'] = AccountFlow::mergeFlowData($appLog, $balanceOnlineOrder, array(
                        'credit_amount' => -$value['money'],
                        'operate_type' => AccountFlow::OPERATE_TYPE_ENVELOPE_UNFREEZE,
                        'remark' => $value['gai_number'].'退回红包金额：￥'. $value['money'],
                        'node' => AccountFlow::BUSINESS_NODE_ONLINE_ENVELOPE_UNFREEZE_BACK,
                        'transaction_type' => AccountFlow::TRANSACTION_TYPE_ENVELOPE,
                    ));
                    if (!AccountBalanceHistory::calculate(array('today_amount' => -$value['money']), $balanceOnlineOrder['id'])) {
                        throw new Exception('UPDATE OnlineAccount ERROR');
                    }

                    //写入流水
                    foreach ($flowLog as $log) {
                        Yii::app()->db->createCommand()->insert($flowTableName, $log);
                    }
                    $trans->commit();
                    $flag = true;
                }catch (Exception $e) {
                    $trans->rollback();
                    //记录错误代扣
                    HistoryBalanceUse::errorLog();
                    throw new Exception($e->getMessage());
                }
                if($flag == true){
                    echo 'red_envelope_id: '.$value['red_envelope_id'].'success'."\r\n";
                }else{
                    echo 'red_envelope_id: '.$value['red_envelope_id'].'-- fail'."\r\n";
                }

        }



    }

    /**
     * 取得会员账户信息
     * @param array|Member $member 会员数据
     * @param int $type 会员类型(消费,代理,商家...)
     * @param bool $isTrans 是否事务
     * @return array
     */
    protected static function getMemberAccountInfo($member, $type, $isTrans = true)
    {
        $arr = array('account_id' => $member['id'], 'type' => $type, 'gai_number' => $member['gai_number']);
        return AccountBalanceHistory::findRecord($arr, $isTrans);
    }
}