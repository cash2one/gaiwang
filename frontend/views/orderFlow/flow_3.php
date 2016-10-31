<?php
/* @var $this Controller */
?>
<!--------------------------主体---------------------------------->

<script>
    $(function() {
        selectPay();
    });
    function paySubmit() {

        var password3 = $('#password3').val();
        if ('' == password3) {
            $('#error').addClass('shopwongset');
            $('#error').html('<?php echo Yii::t('orderFlow', '请输入支付密码'); ?>');
            return false;
        }
        $('#error').removeClass('shopwongset').html('<?php echo Yii::t('orderFlow', '正在提交支付订单请稍后！'); ?>');

        var url = "<?php echo urldecode($this->createAbsoluteUrl('/orderFlow/validatePassword3')); ?>";

        $.post(url, {password3: password3, YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>'}, function(data) {
            if (typeof data.msg=="undefined" ) {
                $('#payForm').submit();
            } else {
                $('#error').addClass('shopwongset');
                $('#error').html(data.msg);
                return false;
            }
        },"json");
    }




</script>
<div class="main clearfix">
    <?php echo CHtml::form($this->createAbsoluteUrl('/orderFlow/processPay'), 'post', array('id' => 'payForm', 'name' => 'payForm')) ?>
    <div class="main">

        <span class="shopFlowPic_3"></span>
        <div class="shopFlGgbox">

            <span class="shopflbgTitle"><?php echo Yii::t('orderFlow', '我已核实订单，同意支付！'); ?></span>
            <div id="shopflcomm_1" style="display:none; overflow:hidden;">
                <table width="1140" border="0" cellspacing="0" cellpadding="0" class="shopflOrdertab">
                    <tr>
                        <td width="20%" class="title"><?php echo Yii::t('orderFlow', '订单号'); ?></td>
                        <td width="40%" class="title"><?php echo Yii::t('orderFlow', '商品名称'); ?></td>
                        <td width="25%" class="title"><?php echo Yii::t('orderFlow', '收货地址'); ?></td>
                        <td width="15%" class="title"><?php echo Yii::t('orderFlow', '订单总价'); ?></td>
                    </tr>
                    <?php
                    $amount = $orderInfo['amount'];
                    unset($orderInfo['amount']);
                    foreach ($orderInfo as $v):
                        ?>

                        <tr>
                            <td align="center" valign="middle"><?php echo $v['code'] ?></td>
                            <td>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="shopflOrdertabChiren">
                                    <?php foreach ($v['goods'] as $val): ?>
                                        <tr>
                                            <td>
                                                <div class="proInfo clearfix">
                                                    <a href="<?php echo Yii::app()->createAbsoluteUrl('/goods/view/' . $val['id']) ?>" class="img" target="_blank" ><?php echo CHtml::image(Tool::showImg(IMG_DOMAIN . '/' . $val['thumbnail'], 'c_fill,h_34,w_34'), $val['name'], array('width' => '34', 'height' => '34')) ?></a>
                                                    <?php echo CHtml::link($val['name'], Yii::app()->createAbsoluteUrl('/goods/' . $val['id']), array('target' => '_blank')) ?>    <?php echo Yii::t('orderFlow', '商家'); ?>：<?php echo $v['store_name']; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </table>
                            </td>

                            <td align="center" valign="middle"><?php echo $v['address'] ?></td>
                            <td align="center" valign="middle"> <?php echo HtmlHelper::formatPrice(sprintf('%0.2f', $v['allprice'])) ?></td>
                        </tr>


                        <input type="hidden" name="code[]" value="<?php echo $v['code'] ?>">
                    <?php endforeach; ?>

                </table>
                <a href="javascript:;" class="shopFlupBtn" id="shopFloddlBtn"><?php echo Yii::t('orderFlow', '收起详情'); ?></a> </div>
            <div id="shopflcomm_2" >
                <span class="shopflbgBox">

                    <table width="100%">
                        <tr>
                            <td width="75%">
                                <span class="shopgwLogo"><?php echo Yii::t('orderFlow', '您正在付款的清单如下'); ?>：</span>
                                <table width="100%" class="mtbot15">
                                    <tr>
                                        <td width="65%" class="rtbd">
                                            <?php
                                            $i = 1;
                                            foreach ($orderInfo as $v):
                                                $oneGoods = current($v['goods']); //订单的第一个商品
                                                ?>
                                                <div class="florder">
                                                    <b><?php echo Yii::t('orderFlow', '订单'); ?><?php echo $i; ?></b> |<?php echo CHtml::link($oneGoods['name'], Yii::app()->createAbsoluteUrl('/goods/' . $oneGoods['id']), array('target' => '_blank')) ?></a><span><?php echo Yii::t('orderFlow', '商家'); ?>：<?php echo $v['store_name'] ?></span>
                                                </div>
                                                <?php
                                                $i++;
                                            endforeach;
                                            ?>
                                        </td>
                                        <td width="35%" class="meshOrder">
                                            <b><?php echo Yii::t('orderFlow', '合并{a}笔订单', array('{a}' => count($orderInfo))); ?></b>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="25%" class="bg">
                                <a href="javascript:showhidediv(name)" title="<?php echo Yii::t('orderFlow', '订单详情'); ?>" class="shopFloddlBtn" ><?php echo Yii::t('orderFlow', '订单详情'); ?></a>
                                <p><?php echo Yii::t('orderFlow', '实含运费'); ?></p>
                                <p class="shopfl_jf"><?php echo HtmlHelper::formatPrice($amount); ?></p>
                            </td>
                        </tr>
                    </table>
                </span>
            </div>

            <div class="shopflIntegraltitle"><font><?php echo Yii::t('orderFlow', '使用积分支付');  echo $amount;?></font>　
                <?php echo CHtml::link(Yii::t('orderFlow', '使用帮助'), $this->createAbsoluteUrl('/help'), array('class' => 'shophelpTip', 'title' => Yii::t('orderFlow', '使用帮助'))) ?>
            </div>
            <table width="1160" border="0" cellspacing="0" cellpadding="0" class="shopflIntegralTb">
                <tr>
                    <td width="27">&nbsp;</td>
                    <td width="150" valign="top" class="tdft">
                        <input type="radio" name="payType" id="selpayType" value="jf" class="mgright5" checked="checked" /><?php echo Yii::t('orderFlow', '选择积分支付'); ?>：</td>
                    <td width="704" class="tdft">
                        <input type="text" name="selectAccount" class="input_1" value="<?php echo Common::convert($amount) ?>" readonly="readonly"/> <?php echo Yii::t('orderFlow', '积分'); ?><font class="shopfl_jf">=<?php echo  HtmlHelper::formatPrice($amount) ?></font>
                        <p class="canUse">
                            <?php echo Yii::t('orderFlow', '您当前可用盖网积分{a}个', array('{a}' => Common::convertSingle(Member::getAccount()))); ?>
                        </p>
                    </td>
                    <td width="237" align="center" class="tt"><div style="display: none"><p><?php echo Yii::t('orderFlow', '还需付款'); ?></p><p class="shopfl_jf">￥<?php echo $amount; ?></p></div></td>
                </tr>
                <tr>
                    <td width="27">&nbsp;</td>
                    <td colspan="3">
                        <span class="shopflonlinQQ">
                            <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $fr_config['freightQQ']; ?>&amp;site=qq&amp;menu=yes" title="<?php echo Yii::t('orderFlow', '联系客服'); ?>" class="shopflonlinBtn"></a>
                            <span><?php echo Yii::t('orderFlow', '可联系盖网客服，修改运费。客服电话'); ?>：<font class="red"><?php echo $frPhone; ?></font></span>
                        </span>

                        <span class="shopflonlinTip">
                            <?php echo Yii::t('orderFlow', '如您的账号没有可支付积分，请使用以下方式支付或{a}后支付。', array('{a}' => CHtml::link(Yii::t('orderFlow', '充值积分'), $this->createAbsoluteUrl('/member/recharge'), array('class' => 'ft005aa0', 'title' => '充值积分', 'target' => '_blank')))); ?>
                        </span>
                    </td>
                </tr>
            </table>

            <?php $this->renderPartial('/layouts/_payTips',array('bankPay'=>'application.views.orderFlow._bankpay')) ?>


        </div>
    </div>
    <?php echo CHtml::endForm() ?>
</div>
<!-- -----------------主体 End--------------------------->