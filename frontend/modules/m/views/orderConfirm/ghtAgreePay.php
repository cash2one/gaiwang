<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>member.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>global.css" type="text/css"/>
	<script type="text/javascript" src="<?php echo DOMAIN; ?>/js/m/jquery-2.1.1.min.js"></script>
    <title><?php echo $this->pageTitle ?>_U快捷付款</title>
    <?php 
          //根据银行卡签约id取得一条签约信息
           $pgid=$this->getParam('id');
           $model=PayAgreement::model()->findByPk($pgid);
    ?>
</head>
<body>
   <div class="mbRight">
     <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberRecharge', '快捷支付验证'); ?></span></a>
            </li>
        </ul>
    </div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
               <form  id="fromSubmit" method="post" action=<?php echo Yii::app()->createAbsoluteUrl('/m/orderConfirm/agreementPay');?> >
                <div class="clearfix"></div>
                <div class="clear"></div>
                <div class="payMethodList">
                    <ul>
                        <li style="height: 100px;width:230px">
                            <div class="<?php echo $model->bank ?> PMImg"></div>
                            <div class="PMNum">****<?php echo substr($model->bank_num,-4) ?></div>
                            <div class="PMType"><?php echo PayAgreement::getCardType($model->card_type) ?></div>
                            <div class="clear"></div>
                            <div class="PMInfo">预留手机号码<span><?php echo $model->mobile ?></span></div>
                        </li>
                    </ul>
                </div>
                <div class="clear"></div>
                <div class="mgtop20 upladBox error">
                    <span class="fl mgtop5">
					<label for="Recharge_verifyCode" class="required">手机验证码 <span class="required">*</span></label></span>
                    <input type="text" id="Recharge_verifyCode" name="vericode" style="width:100px;" class="integaralIpt2">
                    <input type="hidden" name="money" value="<?php echo $this->getParam('money')?>">
                    <input type="hidden" name="parentCode" value="<?php echo $this->getParam('parentCode')?>">
                    <input type="hidden" name="auth" value="<?php echo $this->getParam('auth')?>">
                    <input type="hidden" name="flag" value="<?php echo OnlinePay::PAY_GHT_QUICK?>">
                    <input type="hidden" name="cardId" value="<?php echo $model->id?>">
                    <input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken;?>"/>
                    <a href="javascript:;" class="sendCode02" id="sendMobileCode" style="float:left;"><span data-status="1">获取验证码</span></a>
                    <input type="hidden" name="reqMsgId" id="reqMsgId" value="">
                </div>
                <div class="mgtop20 upladBox error">
                    <span class="fl mgtop5">
                        支付订单：<?php echo $this->getParam('parentCode'); ?>
                    </span>
                </div>
                <div class="mgtop20 upladBox error">
                    <span class="fl mgtop5">
                        金额：<?php echo HtmlHelper::formatPrice($this->getParam('money')); ?>
                        </span>
                </div>
                <div class="upladBox">
                    <input type="submit" value="确认支付"  class ="integaralBtn4">
                </div>
                </form> 
            </div>
            <div class="mbDate1_b"></div>

        </div>

    </div>
</div>
<?php
echo $this->renderPartial('_sendMobileCodeJs');
?>
<script type="text/javascript">
    $(function () {
        sendGhtQuickPay("#sendMobileCode",{
    	    moblie: "<?php echo $model->mobile;?>",
            YII_CSRF_TOKEN:"<?php echo Yii::app()->request->csrfToken ?>"
        });
        $("#fromSubmit").submit(function(){
            if($("#Recharge_verifyCode").val().length==0){
                alert('手机验证码不得为空');
                return false;
            }
        });
    });

</script>
</body>
</html>