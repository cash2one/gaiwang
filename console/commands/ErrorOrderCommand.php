<?php
/**
*异常订单退款
*/
class ErrorOrderCommand extends CConsoleCommand
{
	/**
	 * @author: wyee<yanjie.wang@g-emall.com>
	 * @sine: 2016年7月22日
	 * 商城订单号20160620211815099786
	 * 用户支付了3832，但实际扣款3835.78，需要做退款操作
	 */
	public function actionDo(){
		$code = '20160722114121422236';
		$sql = "select * from {{order}} where code = '".$code."'";
		$data = Yii::app()->db->createCommand($sql)->queryRow();
		//先将订单支付金额改为3835.78
		Yii::app()->db->createCommand()->update('{{order}}', array(
		'pay_price'=>18,
		'real_price'=>18,
		'jf_price'=>18,
		'original_price'=>18
		), 'id='.$data['id']);
		
		$dataArr=Yii::app()->db->createCommand($sql)->queryRow();
		
		//构造退款的流水
		if ($data['refund_status'] == Order::REFUND_STATUS_SUCCESS)
		    throw new Exception($data['code'] . '订单已经退款成功,请不要重复操作');
		
		$member = Yii::app()->db->createCommand()
		->select('id,gai_number,type_id,mobile,username')
		->from('{{member}}')
		->where('id=:id', array(':id' => $data['member_id']))
		->queryRow();
		$data = Yii::app()->db->createCommand($sql)->queryRow();
		$msg = OnlineRefund::operate($dataArr, $member);
		echo $msg['info'];
	}
	
	
  /**
	* @author: chen.luo
	* @sine: 2016年8月18日下午2:22:29
	* 商城订单号20160813002928348431
	* 由于系统异常，用户支付了-169，需要做关闭操作,由于当前购买的GW号账户余额为0，为避免账户出现负数，先通过GW24778382转账后再进行对应的关闭操作
	* php yiic.php errorOrder do20160818
	*/
	public function actionDo20160818()
	{
	    $code = '20160813002928348431';
	    $sql = "select * from {{order}} where code = '".$code."'";	    	    
	    $order=Yii::app()->db->createCommand($sql)->queryRow();
	    
	    $flowTableName = AccountFlow::monthTable(); //流水按月分表日志表名
	    //流水记录
	    $flowLog = array();
	    $trans = Yii::app()->db->beginTransaction(); // 事务执行
	    try {
	        
	        //再次查询订单状态,并加行锁,避免重复操作
	        $sql = "select code,id,refund_status from {{order}} where id = {$order['id']} limit 1 for update";
	        $data = Yii::app()->db->createCommand($sql)->queryRow();
	        if ($data['refund_status'] == Order::REFUND_STATUS_SUCCESS)
	            throw new Exception($order['code'] . '订单已经退款成功,请不要重复操作');

	        $member = Yii::app()->db->createCommand()
	        ->select()
	        ->from('{{member}}')
	        ->where('id=:id', array(':id' => $order['member_id']))
	        ->queryRow();
	        //余额账户
	        $balanceMember = OnlineRefund::getMemberAccountInfo($member, AccountInfo::TYPE_CONSUME, false); //会员消费账户
	        $balanceOnlineOrder = CommonAccount::getOnlineAccount(); //线上总账户
	        $returnPrice = $order['pay_price'];
	        $chongzhi = ($balanceMember['today_amount']+$returnPrice)*-1; //需要充值的钱
	        if($chongzhi > 0)
	        {
	            //余额不够扣，需要先充值
	            //GW24778382先扣钱
	            $outMember = Yii::app()->db->createCommand()
        	        ->select()
        	        ->from('{{member}}')
        	        ->where('gai_number=:gai_number', array(':gai_number' => 'GW24778382'))
        	        ->queryRow();
	            $outMemberBalance = OnlineRefund::getMemberAccountInfo($outMember, AccountInfo::TYPE_CONSUME, false);
	            if($outMemberBalance['today_amount'] < $chongzhi)
	            {
	                throw new Exception('ERROR');
	            }
	            $flowLog['outMember'] = AccountFlow::mergeFlowData($order, $outMemberBalance, array(
    	            'debit_amount' => $chongzhi,
    	            'operate_type' => AccountFlow::OPERATE_TYPE_SIGN_TIAOZHENG,
    	            'remark' => '余额调整：￥' . $chongzhi,
    	            'node' => AccountFlow::TIAOZHENG_NODE_OUT,
    	            'transaction_type' => AccountFlow::TRANSACTION_TYPE_TIAOZHENG,
	                'flag' => AccountFlow::FLAG_SPECIAL,
	                'order_code'=>$order['code'].'-ADJ'
    	        ));
	            
	            if (!AccountBalance::calculate(array('today_amount' => -$chongzhi), $outMemberBalance['id'])) {
	                throw new Exception('UPDATE MEMBERACCOUNT ERROR');
	            }
	            
	            //会员加钱
	            $flowLog['inMember'] = AccountFlow::mergeFlowData($order, $balanceMember, array(
	                'credit_amount' => $chongzhi,
	                'operate_type' => AccountFlow::OPERATE_TYPE_SIGN_TIAOZHENG,
	                'remark' => '余额调整：￥' . $chongzhi,
	                'node' => AccountFlow::TIAOZHENG_NODE_IN,
	                'transaction_type' => AccountFlow::TRANSACTION_TYPE_TIAOZHENG,
	                'flag' => AccountFlow::FLAG_SPECIAL,
	                'order_code'=>$order['code'].'-ADJ'
	            ));
	            if (!AccountBalance::calculate(array('today_amount' => $chongzhi), $balanceMember['id'])) {
	                throw new Exception('UPDATE MEMBERACCOUNT ERROR');
	            }
	        }
	        //更新订单的状态
	        $updateArr = array('status' => Order::STATUS_CLOSE, 'refund_status' => Order::REFUND_STATUS_SUCCESS, 'refund_time' => time());
	        if (!Yii::app()->db->createCommand()->update('{{order}}', $updateArr, 'id = :id', array(':id' => $order['id']))) {
	            throw new Exception('UPDATE ORDER ERROR');
	        }
	        
	        
	        //会员
	        $flowLog['member'] = AccountFlow::mergeFlowData($order, $balanceMember, array(
	            'debit_amount' => -$returnPrice,
	            'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_REFUND,
	            'remark' => '申请退款金额：￥' . $returnPrice,
	            'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_REFUND_RETURN,
	            'transaction_type' => AccountFlow::TRANSACTION_TYPE_REFUND,
	            'flag' => AccountFlow::FLAG_SPECIAL
	        ));
	        
	        if (!AccountBalance::calculate(array('today_amount' => $returnPrice), $balanceMember['id'])) {
	            throw new Exception('UPDATE MEMBERACCOUNT ERROR');
	        }
	        
	        //暂收账
	        $flowLog['onlineOrder'] = AccountFlow::mergeFlowData($order, $balanceOnlineOrder, array(
	            'credit_amount' => -$returnPrice,
	            'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_REFUND,
	            'remark' => '申请退款成功',
	            'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_REFUND,
	            'transaction_type' => AccountFlow::TRANSACTION_TYPE_REFUND,
	            'flag' => AccountFlow::FLAG_SPECIAL
	        ));
	        if (!AccountBalance::calculate(array('today_amount' => -$returnPrice), $balanceOnlineOrder['id'])) {
	            throw new Exception('UPDATE OnlineAccount ERROR');
	        }
	        
	        //写入流水
	        foreach ($flowLog as $log) {
	            Yii::app()->db->createCommand()->insert($flowTableName, $log);
	        }
	        
	        // 检测借贷平衡
	        if (!DebitCredit::checkFlowByCode($flowTableName, $order['code'])) {
	            throw new Exception('DebitCredit Error!', '009');
	        }
	        
	        //还原库存
	        OnlineRefund::ReductionInventory($order['id']);
	        $trans->commit();
	        echo 'success';
	    }catch (Exception $e) {
            $trans->rollback();
            $content = $e->getMessage().$e->getFile().$e->getLine();
            $content = iconv("utf-8","gb2312//IGNORE",$content);
            echo $content;
        }
	}
	
	/**
	 * @author: chen.luo
	 * @sine: 2016年8月18日下午2:22:29
	 * 商城订单号20160813002928348431
	 * 上一次补流水从GW24778382出钱，现在原路退回，从GW8629101出钱
	 * php yiic.php errorOrder do20161021
	 */
	public function actionDo20161021()
	{
	    $returnPrice = 169;
	    $order['id'] = 770799;
	    $order['code'] = '20160813002928348431-ADJ';
	    
	    $flowTableName = AccountFlow::monthTable(); //流水按月分表日志表名
	    //流水记录
	    $flowLog = array();
	    $trans = Yii::app()->db->beginTransaction(); // 事务执行
	    try {
	        //GW24778382 钱退回
	        $outMember = Yii::app()->db->createCommand()
	        ->select()
	        ->from('{{member}}')
	        ->where('gai_number=:gai_number', array(':gai_number' => 'GW24778382'))
	        ->queryRow();
	        $outMemberBalance = OnlineRefund::getMemberAccountInfo($outMember, AccountInfo::TYPE_CONSUME, false);
	        $flowLog['outMember'] = AccountFlow::mergeFlowData($order, $outMemberBalance, array(
	            'debit_amount' => -$returnPrice,
	            'operate_type' => AccountFlow::OPERATE_TYPE_SIGN_TIAOZHENG,
	            'remark' => '调账增加：￥' . $returnPrice,
	            'node' => AccountFlow::TIAOZHENG_NODE_OUT,
	            'transaction_type' => AccountFlow::TRANSACTION_TYPE_TIAOZHENG,
	            'flag' => AccountFlow::FLAG_SPECIAL,
	            'order_code'=>$order['code']
	        ));
	        
	        if (!AccountBalance::calculate(array('today_amount' => $returnPrice), $outMemberBalance['id'])) {
	            throw new Exception('UPDATE MEMBERACCOUNT ERROR');
	        }
	         
	        //原路退回
	        $member = array('account_id' => 2182620, 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => 'GW27907624');
	        $balanceMember = AccountBalance::findRecord($member);
	        
	        //会员
	        $flowLog['member'] = AccountFlow::mergeFlowData($order, $balanceMember, array(
	            'credit_amount' => -$returnPrice,
	            'operate_type' => AccountFlow::OPERATE_TYPE_SIGN_TIAOZHENG,
	            'remark' => '调账扣除：￥' . $returnPrice,
	            'node' => AccountFlow::TIAOZHENG_NODE_IN,
	            'transaction_type' => AccountFlow::TRANSACTION_TYPE_TIAOZHENG,
	            'flag' => AccountFlow::FLAG_SPECIAL
	        ));
	         
	        //GW8629101 出钱
	        $gaiIncomBalance = CommonAccount::getEarningsAccount();
	        $flowLog['gaiIncomBalance'] = AccountFlow::mergeFlowData($order, $gaiIncomBalance, array(
	            'debit_amount' => $returnPrice,
	            'operate_type' => AccountFlow::OPERATE_TYPE_SIGN_TIAOZHENG,
	            'remark' => '调账扣除：￥' . $returnPrice,
	            'node' => AccountFlow::TIAOZHENG_NODE_OUT,
	            'transaction_type' => AccountFlow::TRANSACTION_TYPE_TIAOZHENG,
	            'flag' => AccountFlow::FLAG_SPECIAL,
	            'order_code'=>$order['code']
	        ));
	        if (!AccountBalance::calculate(array('today_amount' => -$returnPrice), $gaiIncomBalance['id'])) {
	            throw new Exception('UPDATE MEMBERACCOUNT ERROR 1');
	        }
	         
	        //会员
	        $flowLog['member2'] = AccountFlow::mergeFlowData($order, $balanceMember, array(
	            'credit_amount' => $returnPrice,
	            'operate_type' => AccountFlow::OPERATE_TYPE_SIGN_TIAOZHENG,
	            'remark' => '调账增加：￥' . $returnPrice,
	            'node' => AccountFlow::TIAOZHENG_NODE_IN,
	            'transaction_type' => AccountFlow::TRANSACTION_TYPE_TIAOZHENG,
	            'flag' => AccountFlow::FLAG_SPECIAL
	        ));
	         
	        //写入流水
	        foreach ($flowLog as $log) {
	            Yii::app()->db->createCommand()->insert($flowTableName, $log);
	        }
	        
	        // 检测借贷平衡
	        if (!DebitCredit::checkFlowByCode($flowTableName, $order['code'])) {
	            throw new Exception('DebitCredit Error!', '009');
	        }
	        
	        $trans->commit();
	        echo 'success';
	    }catch (Exception $e) {
            $trans->rollback();
            $content = $e->getMessage().$e->getFile().$e->getLine();
            $content = iconv("utf-8","gb2312//IGNORE",$content);
            echo $content;
        }
	    
	    
	}

}