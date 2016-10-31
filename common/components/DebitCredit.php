<?php

/**
 * 借贷法则类
 * @author wanyun.liu
 */
class DebitCredit {

    /**
     * 记录操作前的账户余额日志
     * @param type $info
     */
    public static function log($info) {
        $logFile = 'runtime/debitCreditLog.txt';
        $str = "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n";
        $str .= "id:" . $info['id'] . "\t\t" . "account_id:" . $info['account_id'] . "\t\t" . "gai_number:" . (isset($info['gai_number']) ? $info['gai_number'] : '') . "\t\t" . "name:" . $info['name'] . "\t\t" . "debit_yesterday_amount_cash:" . $info['debit_yesterday_amount_cash'] . "\t\t" . "credit_yesterday_amount_cash:" . $info['credit_yesterday_amount_cash'] . "\t\t" . "debit_today_amount_cash:" . $info['debit_today_amount_cash'] . "\t\t" . "credit_today_amount_cash:" . $info['credit_today_amount_cash'] . "\t\t" . "debit_yesterday_amount_nocash:" . $info['debit_yesterday_amount_nocash'] . "\t\t" . "credit_yesterday_amount_nocash:" . $info['credit_yesterday_amount_nocash'] . "\t\t" . "debit_today_amount_nocash:" . $info['debit_today_amount_nocash'] . "\t\t" . "credit_today_amount_nocash:" . $info['credit_today_amount_nocash'] . "\t\t" . "debit_yesterday_amount:" . $info['debit_yesterday_amount'] . "\t\t" . "credit_yesterday_amount:" . $info['credit_yesterday_amount'] . "\t\t" . "debit_today_amount:" . $info['debit_today_amount'] . "\t\t" . "credit_today_amount:" . $info['today_amount'] . "\t\t" . "return_amount:" . $info['return_amount'] . "\t\t" . "owner_type:" . $info['owner_type'] . "\t\t\n";
        $str .= "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n";
        file_put_contents($logFile, $str, FILE_APPEND);
    }

    /**
     * 余额表是否有负数
     * 返回true就说明没有负数
     * @author LC
     */
    public static function checkNonnegative()
    {
    	$accountBalanceTable = ACCOUNT.'.{{account_balance}}';
    	$sql = "SELECT id FROM $accountBalanceTable WHERE credit_today_amount<0";
    	$result = Yii::app()->db->createCommand($sql)->queryScalar();
    	return $result ? false : true;
    }


    /**
     * 某个GW号的流水平衡,从开始到现在,只检测贷方余额(每天凌晨执行),查询出有问题的账号
     * @param String $gai_number  传GW号或者盖网公共账户的名称
     * @author LC
     */
    public static function checkGaiNumberFlowAll($gai_number, $type=null)
    {
    	$flowTable = ACCOUNT.'.'.AccountFlow::hashTable($gai_number);
    	$accountBalanceTable = ACCOUNT.'.{{account_balance}}';

    	$sql = "SELECT a.card_no,a.today_amount-IFNULL(SUM(credit_amount)-SUM(debit_amount),0)  AS t
FROM $accountBalanceTable a
LEFT JOIN $flowTable b ON b.card_no=a.card_no
WHERE a.gai_number = '$gai_number' AND a.type <> 9 ";
    	if($type !== null)
    	{
    		$sql .= " AND a.type = $type ";
    	}
$sql .= "GROUP BY card_no HAVING t<>0;";
    	$accountBalances = Yii::app()->db->createCommand($sql)->queryAll();

    	if(empty($accountBalances))
    	{
    		return true;
    	}
    	else
    	{
    		die;		//如果不为空说明有账号异常，采取报警措施
    	}
    }

    /**
     * 检测某个订单号的发生额是否平衡
     * 返回true说明正常
     * @param string $flowTable  当前流水号所在的流水表名称(月份表)
     * @param string $code  订单号
     * @return bool
     * @author LC
     */
    public static function checkFlowByCode($flowTable ,$code)
    {
    	//排除验证的操作类型
    	$removeOperateTypes = array(
    		AccountFlow::OPERATE_TYPE_EBANK_RECHARGE,
    		AccountFlow::OPERATE_TYPE_CARD_RECHARGE,
    		AccountFlow::OPERATE_TYPE_CASH_SUCCESS,
    		AccountFlow::OPERATE_TYPE_ASSIGN_ONE,
    		AccountFlow::OPERATE_TYPE_ASSIGN_TWO,
    		23   //财务要求将原来的23节点改为13，兼容旧的类型
    	);
    	$sql = "SELECT SUM(credit_amount)-SUM(debit_amount) AS t FROM $flowTable WHERE order_code='$code' AND operate_type NOT IN (".implode(',', $removeOperateTypes).") HAVING SUM(credit_amount)-SUM(debit_amount) <> 0";
    	$result = Yii::app()->db->createCommand($sql)->queryScalar();
    	return $result ? false : true;
    }
}
