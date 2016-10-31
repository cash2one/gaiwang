<?php
/**
 * 微信支付返回结果
 * @author zhaoxiang.liu
 * 平台->商户
 */
class WeiXinGxAppResController extends Controller
{
	public function actionGxAppPay(){
		try {
		//	$logId = Fun::addLog('weixn--gxappPay');
			//验证数据处理；
			$result = WeiXinPayGXAPP::acceptParams();
			
			$tradeStateMsg = array(
					'SUCCESS'=>'支付成功',//1
					'REFUND'=>'转入退款',
					'NOTPAY'=>'未支付',
					'CLOSED'=>'已关闭',
					'REVOKED'=>'已撤销（刷卡支付）',
					'USERPAYING'=>'用户支付中',//2
					'PAYERROR'=>'支付失败',
			);
			
			if(!isset($result['result_code']) || $result['result_code'] !='SUCCESS'){
				throw new Exception($tradeStateMsg[$result['result_code']]);
			}
			
			$mer_priv = json_decode(base64_decode($result['attach']),true);
			$result['gw'] = $mer_priv['gw'];
			$result['parentCode'] = $result['out_trade_no'];
			$result['code'] = $mer_priv['order_code'];
			$result['orderType'] = OnlinePay::ORDER_TYPE_GOODS;
			//保存推送数据结果
			Process::savePayResult($result,Order::PAY_ONLINE_WEIXIN);
			 $orders =  Order::getOrdersByParentCode($result['parentCode'],$result['code']);
			if (empty($orders)) throw new Exception('没有此订单号'.$result['parentCode']."PPP".$result['code']);
			
			$payPrice = 0;
			foreach ($orders as $order) {
				$payPrice =bcadd($payPrice,bcsub($order['pay_price'],$order['jf_price'],2),2);
			}
			$status = Tool::floatcmp($payPrice, bcdiv($result['total_fee'], 100,2));
			$result['money'] = bcdiv($result['total_fee'], 100,2);
			$result['payTranNo'] = $result['transaction_id'];
			if ($status || in_array($orders[0]['source_type'],array(Order::SOURCE_TYPE_JFXJ,Order::SOURCE_TYPE_SINGLE))) { //如果支付金额等于订单金额，或者是特殊商品的订单
				$payType = OnlinePay::PAY_WAP_WEIXIN;
				if (OnlinePayment::payWithUnionPay($orders, $result, $payType)) {
					@SystemLog::record("回调成功".$result['parentCode']."PPP".$result['code'].'::weixn-gxAppPay--2--debug');
					WeiXinPayGXAPP::formartResultXml();
				}else{
					throw new Exception('对账失败');
				}
			}else{
				$message = $status."PP".$orders[0]['source_type']."PP".$result['gw']."PP".$result['parentCode']."PP".$result['code']."PP".$payPrice."PP".$result['total_fee'];
				throw new Exception($message.'订单金额不对');
			}
			WeiXinPayGXAPP::formartResultXml();
		} catch (Exception $e) {
			$msg = $e->getMessage();
		//	Fun::addLog($msg.'::weixn-gtPay--1--debug');
			@SystemLog::record($msg.'::weixn-gxAppPay--1--debug');
			if($msg!='签名失败' && $msg!='参数格式校验错误')
			{
				WeiXinPayGXAPP::formartResultXml($msg);
			}else{
				WeiXinPayGXAPP::formartResultXml($msg);
			}
		}
		
	}
}
?>
