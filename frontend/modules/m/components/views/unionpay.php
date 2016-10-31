<?php
/** @var $model Recharge */
/**
 * 银联支付 v36 接口提交订单支付
 * 需要传三个参数过来
 * @var string $code 订单编号
 * @var float $money 订单金额
 * @var string $backUrl  支付结果接收URL
 * @var string $parentCode 母订单串
 * @var int $orderType 订单类型
 */
?>
<?php
$Reserved01 = implode('XXX',array($orderType,$code,Tool::ip2int(Yii::app()->request->userHostAddress),Yii::app()->user->gw));
$resultUrl=Tool::getConfig('payapi','ip').'unionWappay';
$money=$money*100;
$certId=RsaPay::getSignCertId ();
$params = array(
		'version' => '5.0.0',			//版本号
		'encoding' => 'utf-8',			//编码方式
		'certId' =>$certId,	//证书ID
		'txnType' => '01',			    //交易类型	
		'txnSubType' => '01',		    //交易子类
		'bizType' => '000201',		    //业务类型
		'frontUrl' =>$backUrl,  	    //前台通知地址
		'backUrl' => $resultUrl,		//后台通知地址	
		'signMethod' => '01',		    //签名方法
		'channelType' => '08',		    //渠道类型，07-PC，08-手机
		'accessType' => '0',		    //接入类型
		'merId' =>UNION_WAPPAY_MID,	    //商户代码
		'orderId' => $parentCode,      //商户订单号
		'txnTime' => $orderDate,	//订单发送时间
		'txnAmt' => $money,		        //交易金额，单位分
		'currencyCode' => '156',	    //交易币种
		'defaultPayType' => '0001',	    //默认支付方式	
		'reqReserved' =>$Reserved01,    //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
		);
$params=RsaPay::unionSign($params);
?>

<form method="post" name="SendOrderForm"  action="<?php echo SDK_FRONT_TRANS_URL ?>">
    <?php foreach($params as $k => $v):?>
     <input type="hidden" name="<?php echo $k ?>" id="<?php echo $k ?>" value="<?php echo $v; ?>">
    <?php endforeach;?>
</form>