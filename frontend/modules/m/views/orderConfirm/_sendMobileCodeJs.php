<?php
/**
 * 发送验证码的js
 */
?>
<script type="text/javascript">
    /**
     * 验证码倒计时
     * @param btnId
     * @param  totalTime  倒计时的时间  秒
     */
    function startTimer(btnId, totalTime) {
        var itv = null;
        itv = setInterval(function () {
            totalTime--;
            $(btnId).find('span').html('<?php echo Yii::t('memberHome', '重新发送'); ?>(' + totalTime + ')');
            if (totalTime <= 0) {
                clearInterval(itv);
                itv = null;
                $(btnId).find('span').attr("data-status", "1");
                $(btnId).find('span').html("<?php echo Yii::t('memberHome', '再次发送'); ?>");
                $("#Member_mobile_vcode_em_").remove();
            }
        }, 1000);
    }
    /**
     * ajax 发送验证码  联动支付
     * @param btnId 获取验证码的按钮id   <a href="#" class="sendMobileCode" id="sendMobileCode"><span data-status="1">获取验证码</span></a>
     */
    function sendQuickPay(btnId,param) {
        $(btnId).click(function () {
            if ($(btnId).find('span').attr('data-status') == 0) {
                alert('<?php echo Yii::t('memberHome', '请等待……'); ?>');
                return false;
            }
            $(btnId).find('span').attr('data-status', '0').html("<?php echo Yii::t('memberHome', '发送中……'); ?>");
            $.ajax({
                type: "POST",
                 url: "<?php echo $this->createAbsoluteUrl('orderConfirm/agreementPay') ?>",
                data: param,
                success: function (msg) {
                    if (msg === 'success') {
                        startTimer(btnId, 60);
                    } else {
                        $(btnId).find('span').html('<?php echo Yii::t('memberHome','发送失败'); ?>').attr('data-status', 1);
                    }
                }
            });
            return false;
        });
    }

    function sendGhtQuickPay(btnId,param){
        $(btnId).click(function () {
            if ($(btnId).find('span').attr('data-status') == 0) {
                alert('<?php echo Yii::t('memberHome', '请等待……'); ?>');
                return false;
            }
            $(btnId).find('span').attr('data-status', '0').html("<?php echo Yii::t('memberHome', '发送中……'); ?>");
            $.ajax({
                type: "POST",
                url: "<?php echo $this->createAbsoluteUrl('orderConfirm/sendMsg') ?>",
                data: param,
                dateType:'json',
                success: function (msg) {
                    msg = eval("("+msg+")");
                    if (msg.result) {
                        $('#reqMsgId').val(msg.reqMsgId);
                        startTimer(btnId, 60);
                    } else {
                        $(btnId).find('span').html('<?php echo Yii::t('memberHome', '发送失败'); ?>').attr('data-status', 1);
                    }
                }
            });
            return false;
        });
    }

</script>