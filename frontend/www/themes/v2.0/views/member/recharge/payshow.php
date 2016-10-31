<?php
    Yii::app()->clientScript->registerScriptFile($this->theme->baseUrl . '/js/layer/layer.js');
?>
<!--主体start-->
<style>
    .pay-confirm-btn {
        background: #b50005 none repeat scroll 0 0;
        border: medium none;
        color: #fff;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        height: 40px;
        margin: 0 0 20px 25px;
        width: 130px;
    }
</style>
<div class="member-contain clearfix">
    <div class="main-contain">
        <div class="return-record">
            <span><a href=""> <?php echo Yii::t('memberRecharge', '核对支付信息'); ?></a></span>        
        </div>
        <div class="mbRcontent">

            <div class="mbDate1">
                <div class="mbDate1_t"></div>
                <div class="mbDate1_c">
                    <div class="clearfix"></div>
                    <div class="mbBox">
                        <?php $this->renderPartial('application.views.layouts._payErrorTips') ?>

                        <h2 style=""><?php echo Yii::t('memberRecharge', '订单提交成功，请您尽快付款！'); ?></h2>
                        <hr/>
                        <dl style="margin-top: 10px;"><dt><?php echo Yii::t('memberRecharge', '订单号'); ?>：<?php echo $this->getParam('code') ?></dt>                            
                        </dl>
                        <dl style="margin-top: 10px;"><dt><?php echo Yii::t('memberRecharge', '订单金额'); ?>：<?php echo HtmlHelper::formatPrice($this->getParam('money'), 'span', array('style' => 'color:red;')) ?></dt>
                        </dl>
                        <dl style="margin-top: 10px;"><dt><?php echo Yii::t('memberRecharge', '支付方式'); ?>：
                            <!--<dd>-->
                                <?php
                                if ($this->getParam('payType') == OnlinePay::PAY_UNION):
                                    echo '<i class="common-bank-logo UP"></i>';
                                    $this->widget('OnlinePay', array(
                                        'code' => $this->getParam('code'),
                                        'money' => $this->getParam('money'),
                                        'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                        'payType' => OnlinePay::PAY_UNION,
                                        'parentCode' => $this->getParam('code'),
                                        'orderType' => OnlinePay::ORDER_TYPE_RECHARGE,
                                    ));
                                endif;
                                ?>
                                <?php
                                if ($this->getParam('payType') == OnlinePay::PAY_IPS):
                                    echo '<i class="common-bank-logo IPS"></i>';
                                    $this->widget('OnlinePay', array(
                                        'code' => $this->getParam('code'),
                                        'money' => $this->getParam('money'),
                                        'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                        'payType' => OnlinePay::PAY_IPS,
                                        'parentCode' => $this->getParam('code'),
                                        'orderType' => OnlinePay::ORDER_TYPE_RECHARGE,
                                    ));
                                endif;
                                ?>
                                <?php
                                if ($this->getParam('payType') == OnlinePay::PAY_BEST):
                                    echo '<i class="common-bank-logo BEST"></i>';
                                    $this->widget('OnlinePay', array(
                                        'code' => $this->getParam('code'),
                                        'money' => $this->getParam('money'),
                                        'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                        'orderDate' => $this->getParam('orderDate'),
                                        'parentCode' => $this->getParam('code'),
                                        'payType' => OnlinePay::PAY_BEST,
                                        'orderType' => OnlinePay::ORDER_TYPE_RECHARGE,
                                    ));
                                endif;
                                ?>
                                <?php
                                if ($this->getParam('payType') == OnlinePay::PAY_HI):
                                    echo '<i class="common-bank-logo HI"></i>';
                                    $this->widget('OnlinePay', array(
                                        'code' => $this->getParam('code'),
                                        'money' => $this->getParam('money'),
                                        'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                        'payType' => OnlinePay::PAY_HI,
                                        'orderType' => OnlinePay::ORDER_TYPE_RECHARGE,
                                        'parentCode' => $this->getParam('code'),
                                    ));
                                endif;
                                ?>
                                <?php
                                if ($this->getParam('payType') == OnlinePay::PAY_UM):
                                    echo '<i class="common-bank-logo UM"></i>';
                                    $this->widget('OnlinePay', array(
                                        'code' => $this->getParam('code'),
                                        'money' => $this->getParam('money'),
                                        'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                        'orderDate' => $this->getParam('orderDate'),
                                        'parentCode' => $this->getParam('code'),
                                        'payType' => OnlinePay::PAY_UM,
                                        'orderType' => OnlinePay::ORDER_TYPE_RECHARGE,
                                    ));
                                endif;
                                ?>
                                <?php
                                if ($this->getParam('payType') == OnlinePay::PAY_UM_QUICK):
                                    echo '<i class="common-bank-logo UM"></i>';
                                    $this->widget('OnlinePay', array(
                                        'code' => $this->getParam('code'),
                                        'money' => $this->getParam('money'),
                                        'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                        'orderDate' => $this->getParam('orderDate'),
                                        'parentCode' => $this->getParam('code'),
                                        'payType' => OnlinePay::PAY_UM_QUICK,
                                        'orderType' => OnlinePay::ORDER_TYPE_RECHARGE,
                                    ));
                                endif;
                                ?>
                                <?php
                                if ($this->getParam('payType') == OnlinePay::PAY_TLZF || $this->getParam('payType') == OnlinePay::PAY_TLZFKJ):
                                    echo '<i class="common-bank-logo TLZF"></i>';
                                    $this->widget('OnlinePay', array(
                                        'code' => $this->getParam('code'),
                                        'money' => $this->getParam('money'),
                                        'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                        'orderDate' => $this->getParam('orderDate'),
                                        'parentCode' => $this->getParam('code'),
                                        'payType' => $this->getParam('payType'),
                                        'orderType' => OnlinePay::ORDER_TYPE_RECHARGE,
                                    ));
                                endif;
                                ?> 
                                <?php
                                if ($this->getParam('payType') == OnlinePay::PAY_GHT || $this->getParam('payType') == OnlinePay::PAY_GHTKJ):
                                    echo '<i class="common-bank-logo GHT"></i>';
                                    $this->widget('OnlinePay', array(
                                        'code' => $this->getParam('code'),
                                        'money' => $this->getParam('money'),
                                        'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                        'orderDate' => $this->getParam('orderDate'),
                                        'parentCode' => $this->getParam('code'),
                                        'payType' => $this->getParam('payType'),
                                        'orderType' => OnlinePay::ORDER_TYPE_RECHARGE,
                                    ));
                                endif;
                                ?>  
                                <?php
                                if ($this->getParam('payType') == OnlinePay::PAY_EBC):
                                    echo '<i class="common-bank-logo EBC"></i>';
                                    $this->widget('OnlinePay', array(
                                        'code' => $this->getParam('code'),
                                        'money' => $this->getParam('money'),
                                        'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                        'orderDate' => $this->getParam('orderDate'),
                                        'parentCode' => $this->getParam('code'),
                                        'payType' => OnlinePay::PAY_EBC,
                                        'orderType' => OnlinePay::ORDER_TYPE_RECHARGE,
                                    ));
                                endif;
                                ?>
                            </dt>
                        </dl>
                        <hr/>
                        <?php echo CHtml::button(Yii::t('orderFlow', '确认支付'), array('onclick' => 'paySubmit()', 'class' => 'pay-confirm-btn')) ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<script>
    function paySubmit() {
        var checkUrl = "<?php
                        echo $this->createAbsoluteUrl('/member/recharge/check', array(
                            'code' => $this->getParam('code'),
                            'payType' => $this->getParam('payType')))
                        ?>&SignMsg=" + $(":input[name='SignMsg']").val();        
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
                 document.location.href = "<?php echo $this->createAbsoluteUrl('/member/recharge/index') ?>";
            }
        })
        document.SendOrderForm.submit();
        //循环对账
        window.countTime = 0;
        setTimeout(function () {
            window.si = setInterval(function () {
                countTime++;
                if (countTime > 360)
                    clearInterval(si); //大约半个小时后不再对账
                $.ajax({
                    url: checkUrl,
                    dataType: 'json',
                    success: function (rs) {
                        if (typeof rs.errorMsg == 'undefined') {
                            document.location.href = checkUrl;
                        }
                    }
                });
            }, 5000); //每隔5秒对账一次
        }, 1000 * 20);//二十秒之后去对账
        return false;
    }
</script>