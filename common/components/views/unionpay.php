<?php
/** @var $model Recharge */
/**
 * ����֧�� v36 �ӿ��ύ����֧��
 * ��Ҫ��������������
 * @var string $code �������
 * @var float $money �������
 * @var string $backUrl  ֧���������URL
 * @var string $parentCode ĸ������
 * @var int $orderType ��������
 */
?>
<?php
$EntryMode = '';
$strPKey = UNION_MER_KEY;
$MerId = UNION_MEMBER_ID; //�̻�ID����
$OrderNo = $parentCode; //ÿ���ύ�Ķ�����Ҫ��һ�����������ʾ�������ظ�
$OrderAmount = $money; //��������ʽ��Ԫ.�Ƿ�
$CurrCode = "CNY"; //���Ҵ��룬ֵΪ��CNY
$CallBackUrl = $backUrl; //֧���������URL��Ҫ�����Լ��Ľ���URL��д
$ResultMode = "0";
$BankCode = "";
// $parentCode �������ͬʱ������֧�������ĸ������
$Reserved01 = implode('XXX',array($orderType,$code,Tool::ip2int(Yii::app()->request->userHostAddress),Yii::app()->user->gw));
$Reserved02 = '';
$type = "B2C";
$SourceText = $MerId . $OrderNo . $OrderAmount . $CurrCode . $type . $CallBackUrl . $ResultMode . $BankCode . $EntryMode . $Reserved01 . $Reserved02;
//��ԭʼ��Ϣ���м���
$SignedMsg = md5($SourceText . md5($strPKey));
?>
<form method="post" name="SendOrderForm"  action="<?php echo UNION_PAY_URL ?>" target="_blank">
    <input type="hidden" name="SignMsg" value="<?php echo $SignedMsg; ?>">
    <input type='hidden' name="MerId" value="<?php echo $MerId; ?>">
    <input type='hidden' name="OrderNo" value="<?php echo $OrderNo; ?>">
    <input type='hidden' name="OrderAmount" value="<?php echo $OrderAmount; ?>">
    <input type='hidden' name="CurrCode" value="<?php echo $CurrCode; ?>">
    <input type='hidden' name="CallBackUrl" value="<?php echo $CallBackUrl; ?>">
    <input type='hidden' name="ResultMode" value="<?php echo $ResultMode; ?>">
    <input type='hidden' name="OrderType" value="<?php echo $type; ?>">
    <input type='hidden' name="BankCode" value="<?php echo $BankCode; ?>">
    <input type='hidden' name="EntryMode" value="<?php echo $EntryMode; ?>">
    <input type='hidden' name="Reserved01" value="<?php echo $Reserved01; ?>">
    <input type='hidden' name="Reserved02" value="<?php echo $Reserved02; ?>">
</form>