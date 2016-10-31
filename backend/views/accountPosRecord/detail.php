
<?php
$this->breadcrumbs = array(
    Yii::t('offlineSignStore', ' POS差异流水对账') => array('admin'),
    Yii::t('offlineSignStore', ' 查看详情'),
);
?>
<style type="text/css">
    *{
        margin:0px;
        padding: 0px;
    }
    .wrap{
        margin:10px auto;


    }
    .wrap .wrapLeft{
        border:1px solid #999;

    }
    .wrap .wrapLeft,.wrap .wrapRight{
        float: left;
        width: 30%;
    }
    .wrap .wrapRight{
        border:1px solid #999;

    }
    .wrap table{
        text-align: center;
        line-height: 40px;
        width: 100%;
        border: none;


    }
    .wrap tr td{
        border-bottom:1px solid #999;
    }
</style>
<body>
<div class="wrap">
    <div class="wrapLeft">
        <table>
            <tbody>
            <tr><td>系统数据</td></tr>
            <?php if(!empty($posModel)):?>
            <tr><td>加盟商名称:<?php echo $agentName?></td></tr>
            <tr><td>消费者GW帐号:<?php  echo $MemberInfo['gai_number'];?></td></tr>
            <tr><td>消费者手机:<?php echo $posModel['phone'];?></td></tr>
                <tr><td>消费金额:<?php echo $posModel['amount']?></td></tr>
                <tr><td>银行卡号:<?php echo '*******'.($posModel['card_num'] < 999 ? '0'.$posModel['card_num']:$posModel['card_num'] );?></td></tr>
                <tr><td>盖机名称:<?php echo $machineName?></td></tr>
            <?php endif;?>
            </tbody>
        </table>
    </div>
    <div class="wrapRight">
        <table>
            <tbody>
            <tr><td>通联数据</td></tr>
            <?php if(!empty($callbackData)):?>
            <tr><td>交易账号:<?php echo '*******'.substr($callbackData->交易账号, -4 , 4)?></td></tr>
            <tr><td>交易发生日:<?php echo $callbackData->交易发生日?></td></tr>
            <tr><td>POS交易流水号:<?php echo $callbackData->POS交易流水号?></td></tr>
            <tr><td>交易时间:<?php echo $model['transaction_datetime'];?></td></tr>
            <tr><td>消费金额:<?php echo $callbackData->交易金额?></td></tr>
            <tr><td>清算日:<?php echo $callbackData->清算日?></td></tr>
            <tr><td>商户号:<?php echo $callbackData->商户号?></td></tr>
            <tr><td>商户帐号:<?php echo $callbackData->商户帐号?></td></tr>
            <?php endif;?>
            </tbody>
        </table>
    </div>
    <div class="wrapRight">
        <table>
            <tbody>
            <tr><td>增补数据(操作人ID：<?php echo !empty($LogPos)?$LogPos->userId:'';?>  操作人名称：<?php echo !empty($LogPos)?$LogPos->username:'';?>)</td></tr>
            <?php if(!empty($LogPos)):?>
                <tr><td>装机编号:<?php echo $LogPos->ShopID;?></td></tr>
                <tr><td>GW帐号:<?php echo $LogPos->Name?></td></tr>
                <tr><td>消费金额:<?php echo $LogPos->Amount?></td></tr>
                <tr><td>手机号码:<?php echo $LogPos->UserPhone?></td></tr>
                <tr><td>银行卡号:<?php echo '*******'.substr($LogPos->CardNum, -4 , 4)?></td></tr>
                <tr><td>增补时间:<?php echo date("Y-m-d H:i:s",$LogPos->time)?></td></tr>
            <?php endif;?>
            </tbody>
        </table>
    </div>
</div>
</body>



