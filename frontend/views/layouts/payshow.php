<?php
/* @var $this orderController */
/** @var $model Order */
/**
 * 需要传三个参数过来
 * @var string $backUrl 支付返回地址 orderFlow/onlinePayResult;
 * @var string $orderDesc 订单描述：商品订单
 * @var string $checkUrl  检查支付情况地址 orderFlow/check
 * @var string $orderType 订单类型
 *
 */
?>
<link href="<?php echo CSS_DOMAIN; ?>module.css" rel="stylesheet" type="text/css" />
<?php if(Yii::app()->theme) Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery-1.9.1.js')?>
<script src="<?php echo DOMAIN ?>/js/artDialog/jquery.artDialog.js?skin=aero" type="text/javascript"></script>
<style>
    .payType dd span {
        background: url("../images/bg/mbgifpic.gif") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
        display: block;
        height: 31px;
        margin-left: 40px;
        width: 101px;
    }
    .payType dd span.IPS {
        background-position: -16px -41px;
    }
    .payType dd span.UP {
        background-position: -15px -6px;
    }
    .payType dd span.BEST {
        background-position: -11px -152px;
    }
    .payType dd span.UM {
        background-position: -11px -235px;
    }
    .payType dd span.TLZF {
        background-position: -11px -280px;
    }
    .payType dd span.HI {
        width:135px;
        background-position: -11px -190px;
    }
   .payType dd span.GHT {
        background-position: -11px -322px;
    }
   .payType dd span.EBC {
        background-position: -11px -370px;
    }
    #payErrorTips dl dd{
        font-weight: normal;
    }
</style>
<div class="main">
<div class="shopFlGgbox">
<div class="shopPayBox">
    <?php $this->renderPartial('application.views.layouts._payErrorTips') ?>
	<h3><?php echo Yii::t('orderFlow','订单提交成功，请您尽快付款！'); ?></h3>
	<p class="tips"><?php echo Yii::t('orderFlow','订单提交成功，请确认订单信息'); ?></p>
	<div class="dlBox clearfix">
		<dl class="fl"><dt><?php echo Yii::t('orderFlow','支付订单号'); ?>：</dt><dd class="orderNum"><?php echo $this->getParam('code') ?></dd></dl>
		<dl class="fr"><dt><?php echo Yii::t('orderFlow','应付款金额'); ?>：</dt><dd class="orderSum"><?php echo HtmlHelper::formatPrice($this->getParam('money')) ?></dd></dl>
                <dl class="payType">
                    <dt></dt>
                    <dd>
                        <?php
                        if($this->getParam('payType')==OnlinePay::PAY_UNION):
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'payType' => OnlinePay::PAY_UNION,
                                'parentCode'=>$this->getParam('parentCode'),
                                'orderType' => $orderType,
                            ));
                            echo '<span class="UP"></span>';
                        endif;
                        ?>
                        <?php
                        if($this->getParam('payType')==OnlinePay::PAY_IPS):
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'payType' => OnlinePay::PAY_IPS,
                                'parentCode'=>$this->getParam('parentCode'),
                                'orderType' => $orderType,
                            ));
                            echo '<span class="IPS"></span>';
                        endif;
                        ?>
                        <?php
                        if ($this->getParam('payType') == OnlinePay::PAY_BEST):
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => OnlinePay::PAY_BEST,
                                'orderType' => $orderType,
                                'orderDesc'=>$orderDesc,
                            ));
                            echo '<span class="BEST"></span>';
                        endif;
                        ?>
                        <?php
                        if($this->getParam('payType')==OnlinePay::PAY_HI):
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'payType' => OnlinePay::PAY_HI,
                                'orderType' => $orderType,
                                'parentCode'=>$this->getParam('parentCode'),
                            ));
                            echo '<span class="HI"></span>';
                        endif;
                        ?>
                        <?php
                        if ($this->getParam('payType') == OnlinePay::PAY_UM):
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => OnlinePay::PAY_UM,
                                'orderType' => $orderType,
                                'orderDesc'=>$orderDesc,
                            ));
                            echo '<span class="UM" ></span>';
                        endif;
                        ?>
                        <?php
                        if ($this->getParam('payType') == OnlinePay::PAY_UM_QUICK):
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => OnlinePay::PAY_UM_QUICK,
                                'orderType' => $orderType,
                                'orderDesc'=>$orderDesc,
                            ));
                            echo '<span class="UM" ></span>';
                        endif;
                        ?>
                         <?php
                        if ($this->getParam('payType') == OnlinePay::PAY_TLZF):
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => OnlinePay::PAY_TLZF,
                                'orderType' => $orderType,
                                'orderDesc'=>$orderDesc,
                            ));
                            echo '<span class="TLZF" ></span>';
                        endif;
                        ?>
                         <?php
                        if ($this->getParam('payType') == OnlinePay::PAY_GHT):
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => OnlinePay::PAY_GHT,
                                'orderType' => $orderType,
                                'orderDesc'=>$orderDesc,
                            ));
                            echo '<span class="GHT" ></span>';
                        endif;
                        ?>
                         <?php
                        if ($this->getParam('payType') == OnlinePay::PAY_EBC):
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => OnlinePay::PAY_EBC,
                                'orderType' => $orderType,
                                'orderDesc'=>$orderDesc,
                            ));
                            echo '<span class="EBC" ></span>';
                        endif;
                        ?>
                    </dd>
                </dl>
	</div>				
	<hr/>
	<?php echo CHtml::button(Yii::t('orderFlow','确认支付'),array('onclick'=>'paySubmit()','class'=>'surePayBtn')) ?>
</div>
</div>
</div>
<script>
    function paySubmit(){
        var checkUrl = "<?php echo $this->createAbsoluteUrl($checkUrl,
                    array(
                    'code'=>$this->getParam('code'),
                    'money'=>$this->getParam('money'),
                        ))
                ?>&SignMsg="+$(":input[name='SignMsg']").val();
        art.dialog({
            lock:true,
            icon:"warning",
            okVal:'<?php echo Yii::t('member','确定') ?>',
            title:'<?php echo Yii::t('member','消息') ?>',
            content:'<?php echo Yii::t('memberRecharge','请您在新打开的网上银行页面进行支付，支付完成前请不要关闭该窗口。</br>完成付款后请根据您的情况点击下面的按钮。'); ?>',
            button:[{
                name: '<?php echo Yii::t('memberRecharge','已完成支付'); ?>',
                callback: function () {
                    document.location.href = checkUrl;
                },
                focus: true
            },{
                name:'<?php echo Yii::t('memberRecharge','付款遇到问题'); ?>',
                callback:function(){
                    $("#payErrorTips").show();
                }
            },{
                name:'<?php echo Yii::t('memberRecharge','选择其他支付方式'); ?>',
                callback:function(){
                    document.location.href = "<?php echo $this->createAbsoluteUrl('order/pay',array('code'=>$this->getParam('code')))?>";
                }
            }
            ]
        });
        document.SendOrderForm.submit();
        //循环对账
        window.countTime = 0;
        setTimeout(function () {
            window.si = setInterval(function () {
                countTime++;
                if(countTime>360) clearInterval(si); //大约半个小时后不再对账
                $.ajax({
                    url: checkUrl,
                    dataType:'json',
                    success: function (rs) {
                        if (typeof rs.errorMsg == 'undefined') {
                            document.location.href = checkUrl;
                        }
                    }
                });
            }, 5000); //每隔5秒对账一次
        }, 1000 * 10);//10秒之后去对账
    }
</script>