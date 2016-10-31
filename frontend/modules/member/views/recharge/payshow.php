<?php
/* @var $this ApplyCashController */
/** @var $model Recharge */
$this->breadcrumbs = array(
    Yii::t('memberRecharge', '积分管理'),
    Yii::t('memberRecharge', '积分充值'),
);
?>
<div class="mbRight">
    <div class="EntInfoTab">
        <ul class="clearfix">
            <li class="curr"><a href="javascript:;"><span><?php echo Yii::t('memberRecharge','核对支付信息'); ?></span></a></li>
        </ul>
    </div>
    <div class="mbRcontent">

        <div class="mbDate1">
            <div class="mbDate1_t"></div>
            <div class="mbDate1_c">
                <div class="clearfix"></div>
                <div class="mbBox">
                    <?php $this->renderPartial('application.views.layouts._payErrorTips') ?>

                    <h3><?php echo Yii::t('memberRecharge','订单提交成功，请您尽快付款！'); ?></h3>
                    <dl><dt><?php echo Yii::t('memberRecharge','订单号'); ?>：</dt>
                        <dd><?php echo $this->getParam('code') ?></dd>
                    </dl>
                    <dl><dt><?php echo Yii::t('memberRecharge','订单金额'); ?>：</dt>
                        <dd><?php echo HtmlHelper::formatPrice($this->getParam('money'),'span',array('style'=>'color:red;')) ?></dd>
                    </dl>
                    <dl><dt><?php echo Yii::t('memberRecharge','支付方式'); ?>：</dt>
                        <dd>
                            <?php
                            if($this->getParam('payType')==Recharge::PAY_TYPE_YINLIANG):
                                $this->widget('OnlinePay', array(
                                    'code' => $this->getParam('code'),
                                    'parentCode' => $this->getParam('code'),
                                    'money' => $this->getParam('money'),
                                    'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                    'payType' => Recharge::PAY_TYPE_YINLIANG,
                                    'orderType'=>OnlinePay::ORDER_TYPE_RECHARGE,
                                ));
                                echo '<span class="integaralXf2"></span>';
                            endif;
                            ?>
                            <?php
                            if($this->getParam('payType')==Recharge::PAY_TYPE_HUXUN):
                                $this->widget('OnlinePay', array(
                                    'code' => $this->getParam('code'),
                                    'money' => $this->getParam('money'),
                                    'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                    'payType' => Recharge::PAY_TYPE_HUXUN,
                                    'orderType'=>OnlinePay::ORDER_TYPE_RECHARGE,
                                    'parentCode' => $this->getParam('code'),
                                ));
                                echo '<span class="integaralXf1"></span>';
                            endif;
                            ?>
                            <?php
                            if($this->getParam('payType')==Recharge::PAY_TYPE_YI):
                                $this->widget('OnlinePay', array(
                                    'code' => $this->getParam('code'),
                                    'money' => $this->getParam('money'),
                                    'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                    'orderDate'=>$this->getParam('orderDate'),
                                    'parentCode'=>$this->getParam('code'),
                                    'payType' => Recharge::PAY_TYPE_YI,
                                    'orderType'=>OnlinePay::ORDER_TYPE_RECHARGE,
                                ));
                                echo '<span class="integaralXf3"></span>';
                            endif;
                            ?>
                            <?php
                            if($this->getParam('payType')==Recharge::PAY_TYPE_HI):
                                $this->widget('OnlinePay', array(
                                    'code' => $this->getParam('code'),
                                    'parentCode' => $this->getParam('code'),
                                    'money' => $this->getParam('money'),
                                    'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                    'payType' => Recharge::PAY_TYPE_HI,
                                    'orderType'=>OnlinePay::ORDER_TYPE_RECHARGE,
                                ));
                                echo '<span class="integaralXf4"></span>';
                            endif;
                            ?>
                            <?php
                            if($this->getParam('payType')==Recharge::PAY_TYPE_UM):
                                $this->widget('OnlinePay', array(
                                    'code' => $this->getParam('code'),
                                    'parentCode' => $this->getParam('code'),
                                    'money' => $this->getParam('money'),
                                    'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                    'payType' => Recharge::PAY_TYPE_UM,
                                    'orderType'=>OnlinePay::ORDER_TYPE_RECHARGE,
                                    'orderDate'=>$this->getParam('orderDate'),
                                ));
                                echo '<span class="integaralXf5"></span>';
                            endif;
                            ?>
                            <?php
                            if($this->getParam('payType')==Recharge::PAY_TYPE_UM_QUICK):
                                $this->widget('OnlinePay', array(
                                    'code' => $this->getParam('code'),
                                    'parentCode' => $this->getParam('code'),
                                    'money' => $this->getParam('money'),
                                    'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                    'payType' => Recharge::PAY_TYPE_UM_QUICK,
                                    'orderType'=>OnlinePay::ORDER_TYPE_RECHARGE,
                                    'orderDate'=>$this->getParam('orderDate'),
                                ));
                                echo '<span class="integaralXf5"></span>';
                            endif;
                            ?>
                            <?php
                            if($this->getParam('payType')==Recharge::PAY_TYPE_TL):
                                $this->widget('OnlinePay', array(
                                    'code' => $this->getParam('code'),
                                    'parentCode' => $this->getParam('code'),
                                    'money' => $this->getParam('money'),
                                    'backUrl' => $this->createAbsoluteUrl('/member/recharge/payResult'),
                                    'payType' => Recharge::PAY_TYPE_TL,
                                    'orderType'=>OnlinePay::ORDER_TYPE_RECHARGE,
                                    'orderDate'=>$this->getParam('orderDate'),
                                ));
                                echo '<span class="integaralXf6"></span>';
                            endif;
                            ?>
                        </dd>
                    </dl>
                    <hr/>
                    <a  href="#" class="surePayBtn" onclick="paySubmit()"><?php echo Yii::t('memberRecharge','确认支付'); ?></a>
                </div>

            </div>
            <div class="mbDate1_b"></div>
        </div>

    </div>
</div>

<script>
    function paySubmit(){
        var checkUrl = "<?php echo $this->createAbsoluteUrl('/member/recharge/check',
                    array(
                    'code'=>$this->getParam('code'),
                    'payType'=>$this->getParam('payType'))) ?>&SignMsg="+$(":input[name='SignMsg']").val();
        art.dialog({
            lock:true,
            icon:"warning",
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
                    document.location.href = "<?php echo $this->createAbsoluteUrl('/member/recharge/index')?>";
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