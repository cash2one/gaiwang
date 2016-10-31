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
     * ajax 发送验证码，登录前的
     * @param btnId 获取验证码的按钮id   <a href="#" class="sendMobileCode" id="sendMobileCode"><span data-status="1">获取验证码</span></a>
     * @param mobileId  手机号码的input id
     * @param fn function 发送短信前回调
     */
    function sendMobileCode(btnId, mobileId) {
        $(btnId).click(function () {
            $("#Member_mobile_vcode_em_").remove();
            var mobile = $(mobileId).val();

            if (!mobile) {
                //alert('<?php echo Yii::t('memberHome', '请输入手机号！') ?>');
                $(this).after('<div class="errorMessage" id="Member_mobile_vcode_em_" style=""><?php echo Yii::t('memberHome', '请输入手机号！') ?></div>');
                return false;
            }
            if (!mobile.match(/(^\d{11}$)|(^852\d{8}$)/)) {
                //alert('<?php echo Yii::t('memberHome', '请输入正确的您的手机号码'); ?>');
                //$(this).after('<div class="errorMessage" id="Member_mobile_vcode_em_" style=""><?php echo Yii::t('memberHome', '请输入正确的手机号'); ?></div>');
                return false;
            }

            if ($(btnId).find('span').attr('data-status') == 0) {
                //alert('<?php echo Yii::t('memberHome', '请等待……'); ?>');
                $(this).after('<div class="errorMessage" id="Member_mobile_vcode_em_" style=""><?php echo Yii::t('memberHome', '请等待……'); ?></div>');
                return false;
            }
            $(btnId).find('span').attr('data-status', '0').html("<?php echo Yii::t('memberHome', '发送中……'); ?>");
            setTimeout(function () {
                if($(mobileId).next('.errorMessage:visible').text().length>0){
                    $(btnId).find('span').attr('data-status', '1').html("<?php echo Yii::t('memberHome', '获取验证码'); ?>");
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createUrl('/hongbao/site/getMobileVerifyCode'); ?>",
                    data: {"YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken; ?>", "mobile": mobile},
                    success: function (msg) {
                        if (msg === 'success') {
                            startTimer(btnId, 60);
                        } else {
                            $(btnId).find('span').html('<?php echo Yii::t('memberHome', '发送失败,请重试'); ?>').attr('data-status', 1);
                        }
                    }
                });
            }, 3000);

            $("#Member_mobile_vcode_em_").remove();
            return false;
        });
    }


    /**
     * ajax 发送验证码 登录后的验证
     * @param btnId 获取验证码的按钮id   <a href="#" class="sendMobileCode" id="sendMobileCode"><span data-status="1">获取验证码</span></a>
     */
    function sendMobileCode2(btnId) {
        $(btnId).click(function () {

            if ($(btnId).find('span').attr('data-status') == 0) {
                alert('<?php echo Yii::t('memberHome', '请等待……'); ?>');
            	//$(this).after('<div class="errorMessage" id="Member_mobile_vcode_em_" style="">请等待……</div>');
                return false;
            }
            $(btnId).find('span').attr('data-status', '0').html("<?php echo Yii::t('memberHome', '发送中……'); ?>");
            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl('/member/applyCash/getMobileVerifyCode'); ?>",
                data: {"YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken; ?>"},
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
</script>