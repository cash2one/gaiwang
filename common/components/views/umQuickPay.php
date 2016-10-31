<?php
/** @var $model Recharge */
/**
 * 联动优势
 *
 * @var string $code 订单编号
 * @var float $money 订单金额
 * @var string $backUrl  支付结果接收URL
 * @var string $parentCode 母订单串
 * @var int $orderType 订单类型
 * @var int $orderDate 订单日期
 */
?>
<?php
$gw = Yii::app()->user->gw;
//商户数据包 //多个订单同时用在线支付额外的母订单串
$attach = implode('XXX',array($orderType,$code,Tool::ip2int(Yii::app()->request->userHostAddress),$gw));
//Server to Server 返回页面URL
$serverUrl = Tool::getConfig('payapi','ip').'umpay';

$params = array(
    'service'=>'req_front_page_pay',
    'charset'=>'UTF-8',
    'mer_id'=>UM_MEMBER_ID,
    'ret_url'=>$backUrl,
    'notify_url'=>$serverUrl,
    'version'=>'4.0',
    'order_id'=>$parentCode,
    'mer_date'=>$orderDate,
    'amount'=>$money*100,
    'amt_type'=>'RMB',
    'mer_priv'=>$attach,
    'interface_type'=>'01',
    'goods_inf'=>$gw,
    'mer_cust_id'=>$gw,
);

$plain = RsaPay::plain($params);
$sign = RsaPay::sign($plain,Yii::getPathOfAlias('common') . '/rsaFile/um.key.pem');
?>
<form action="<?php echo UM_PAY_URL ?>" method="get" id="frm1" target="_blank" name="SendOrderForm">
    <?php foreach($params as $k=>$v): ?>
        <input  type="hidden"  name="<?php echo $k ?>" value="<?php echo $v ?>"/>
    <?php endforeach; ?>
    <input  type="hidden"  name="sign_type" value="RSA"/>
    <input  type="hidden"  name="sign" value="<?php echo $sign; ?>"/>

</form>