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

<?php
    Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/global.css');
    Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/module.css');
    Yii::app()->clientScript->registerCssFile($this->theme->baseUrl . '/styles/cart.css');
    Yii::app()->clientScript->registerScriptFile($this->theme->baseUrl . '/js/jquery-1.9.1.js');
    Yii::app()->clientScript->registerScriptFile($this->theme->baseUrl . '/js/layer/layer.js');
?>
<div class="pages-header">
    <div class="w1200">
        <div class="pages-logo">
            <a href="<?php echo DOMAIN ?>" title="<?php echo Yii::t('site', '盖象商城') ?>" class="gx-top-logo"
               id="gai_link">
                <img width="187" height="56" alt="<?php echo Yii::t('site', '盖象商城') ?>"
                     src="<?php echo $this->theme->baseUrl . '/'; ?>images/bgs/top_logo.png"/>
            </a>
        </div>
        <div class="pages-title"><?php echo Yii::t('order', '支付'); ?></div>
        <div class="shopping-process clearfix">
            <div class="process-li icon-cart on"><?php echo Yii::t('order', '查看购物车'); ?></div>
            <span class="process-out process-out01"></span>

            <div class="process-li icon-cart on"><?php echo Yii::t('order', '确认订单'); ?></div>
            <span class="process-out process-out02"></span>

            <div class="process-li icon-cart on"><?php echo Yii::t('order', '支付'); ?></div>
            <span class="process-out process-out03"></span>

            <div class="process-li icon-cart"><?php echo Yii::t('order', '确认收货'); ?></div>
            <span class="process-out process-out04"></span>

            <div class="process-li icon-cart"><?php echo Yii::t('order', '完成'); ?></div>
        </div>
    </div>
</div>
<!--<script src="<?php //echo DOMAIN ?>/js/artDialog/jquery.artDialog.js?skin=aero" type="text/javascript"></script>-->
<!--主体start-->
<div class="shopping-bg">
    <div class="shopping-pay">
        <div class="orders-successfully">
            <div class="orders-title"><span><i class="icon-cart"></i><?php echo Yii::t('orderflow','订单提交成功，请您确认订单信息，尽快付款！')?></span></div>
            <div class="orders-message clearfix">
                <div class="left">
                    <?php $this->renderPartial('_payErrorTips') ?>
                    <p class="order-number"><?php echo Yii::t('orderflow','支付订单号')?>：<?php echo $this->getParam('code')?></p>
                    <div class="e-bank">
                        <span class="bank-type"><?php echo OnlinePay::getPayWayList($this->getParam('payType'))?></span>
                        <!--<i class="common-bank-logo BEST"></i>-->
                        <?php
                        if ($this->getParam('payType') == OnlinePay::PAY_UNION):
                            echo '<i class="common-bank-logo UP"></i>';
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'payType' => OnlinePay::PAY_UNION,
                                'parentCode' => $this->getParam('parentCode'),
                                'orderType' => $orderType,
                            ));
                        endif;
                        ?>
                        <?php
                        if ($this->getParam('payType') == OnlinePay::PAY_IPS):
                            echo '<i class="common-bank-logo IPS"></i>';
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'payType' => OnlinePay::PAY_IPS,
                                'parentCode' => $this->getParam('parentCode'),
                                'orderType' => $orderType,
                            ));
                        endif;
                        ?>
                        <?php
                        if ($this->getParam('payType') == OnlinePay::PAY_BEST):
                            echo '<i class="common-bank-logo BEST"></i>';
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => OnlinePay::PAY_BEST,
                                'orderType' => $orderType,
                                'orderDesc' => $orderDesc,
                            ));
                        endif;
                        ?>
                        <?php
                        if ($this->getParam('payType') == OnlinePay::PAY_HI):
                            echo '<i class="common-bank-logo HI"></i>';
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'payType' => OnlinePay::PAY_HI,
                                'orderType' => $orderType,
                                'parentCode' => $this->getParam('parentCode'),
                            ));
                        endif;
                        ?>
                        <?php
                        if ($this->getParam('payType') == OnlinePay::PAY_UM):
                            echo '<i class="common-bank-logo UM"></i>';
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => OnlinePay::PAY_UM,
                                'orderType' => $orderType,
                                'orderDesc' => $orderDesc,
                            ));
                        endif;
                        ?>
                        <?php
                        if ($this->getParam('payType') == OnlinePay::PAY_UM_QUICK):
                            echo '<i class="common-bank-logo UM"></i>';
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => OnlinePay::PAY_UM_QUICK,
                                'orderType' => $orderType,
                                'orderDesc' => $orderDesc,
                            ));
                        endif;
                        ?>
                        <?php
                        if ($this->getParam('payType') == OnlinePay::PAY_TLZF || $this->getParam('payType') == OnlinePay::PAY_TLZFKJ):
                            echo '<i class="common-bank-logo TLZF"></i>';
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => $this->getParam('payType'),
                                'orderType' => $orderType,
                                'orderDesc' => $orderDesc,
                            ));
                        endif;
                        ?> 
                         <?php
                        if ($this->getParam('payType') == OnlinePay::PAY_GHT || $this->getParam('payType') == OnlinePay::PAY_GHTKJ):
                            echo '<i class="common-bank-logo GHT"></i>';
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => $this->getParam('payType'),
                                'orderType' => $orderType,
                                'orderDesc' => $orderDesc,
                            ));
                        endif;
                        ?>  
                         <?php
                        if ($this->getParam('payType') == OnlinePay::PAY_EBC):
                            echo '<i class="common-bank-logo EBC"></i>';
                            $this->widget('OnlinePay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => OnlinePay::PAY_EBC,
                                'orderType' => $orderType,
                                'orderDesc' => $orderDesc,
                            ));
                        endif;
                        ?>
                    </div>
                </div>
                <div class="right">
                    <?php echo Yii::t('orderflow','应付金额')?>：<span><?php echo HtmlHelper::formatPrice($this->getParam('money')) ?></span>
                </div>
            </div>
            <?php echo CHtml::button(Yii::t('orderFlow','确认支付'),array('onclick'=>'paySubmit()','class'=>'pay-confirm-btn')) ?>
        </div>
    </div>
</div>
<!-- 主体end -->
<script>
    function paySubmit(){
        var checkUrl = "<?php echo $this->createAbsoluteUrl($checkUrl,
                    array(
                    'code'=>$this->getParam('code'),
                    'money'=>$this->getParam('money'),
                        ))
                ?>&SignMsg="+$(":input[name='SignMsg']").val();
        layer.open({
            title:'<?php echo Yii::t('member','订单支付')?>',
            content:'<?php echo Yii::t('memberRecharge','请您在新打开的网上银行页面进行支付，支付完成前请不要关闭该窗口。</br>完成付款后请根据您的情况点击下面的按钮。'); ?>',
            btn:['已完成支付','选择其他支付方式'],
            area: 'auto',
            maxWidth:'700px',
            yes:function(index){
                 document.location.href = checkUrl;
            },
            cancel:function(index){
                 document.location.href = "<?php echo $this->createAbsoluteUrl('order/payv2',array('code'=>$this->getParam('code')))?>";
            }
        })
        
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