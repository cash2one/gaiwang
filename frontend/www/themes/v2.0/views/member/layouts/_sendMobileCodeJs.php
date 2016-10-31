<?php
/**
 * 发送验证码的js
 */
?>
<style>
.phone_tips{ padding-left:10px;}
</style>
<script type="text/javascript">
    //ajax 获取语音验证码
//    var itv = null;
    function callPhone(btnId,mobileId){
        var mobile = $(mobileId).val();
        if (mobile && !mobile.match(/^1[34578]{1}\d{9}$/)) {
            alert('<?php echo Yii::t('memberHome', '抱歉，语音验证码暂时只支持大陆手机号'); ?>');
            return false;
        }
        if($(btnId).find('span').attr('data-status')==0){
            return false;
        }else{
            $(btnId).find('span').attr('data-status', '0');
            $(".phone_tips .getCallPhone").html("<?php echo Yii::t('memberHome', '正在请求……'); ?>");
            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl('/member/home/getMobileVerifyCall'); ?>",
                data: {"YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken; ?>", "mobile": mobile},
                success: function (msg) {
                    if (msg === 'success') {
                        startTimer2(btnId, 60, mobile);
                        alert("请耐心等待，您将会接到电话为您播报验证码");
                    } else {
                        $(".phone_tips .getCallPhone").html('获取失败，请重试');
                    }
                }
            });
        }
    }
    /**
     * 验证码倒计时  包含语音验证码的提示
     * @param btnId
     * @param  totalTime  倒计时的时间  秒
     * @param  mobileId 手机号Id
     */
    function startTimer2(btnId, totalTime, mobileId) {
        var val  = $(btnId).val();
        $(btnId).attr('disabled','disabled');
        var itv = setInterval(function () {
            totalTime--;
            if(totalTime < 10) totalTime = '0' + totalTime; 
            $(btnId).find('span').html('<?php echo Yii::t('memberHome', '重新发送'); ?>(' + totalTime + ')');
            if($(".phone_tips .getCallPhone").length==0){
                $(".phone_tips .getCallPhone").next('.errorMessage').remove();
                $(btnId).after('<span class="phone_tips" ><a href="javascript:void(0);" onclick="callPhone(\''+btnId+'\',\''+mobileId+'\')" class="getCallPhone red" >没收到短信？'+totalTime+'秒后点此获取语音验证码</a></span>');
            }else{
                if(totalTime>0){
                    $(".phone_tips .getCallPhone").html('没收到短信？'+totalTime+'秒后点此获取语音验证码');
                }else{
                    $(".phone_tips .getCallPhone").html('没收到短信？点此获取语音验证码');
                }
            }
            $(btnId).val('<?php echo Yii::t('memberHome', '发送中'); ?>('+totalTime+')');
            if (totalTime <= 0) {
                clearInterval(itv);
                itv = null;
                $(btnId).attr("data-status", "1").removeAttr('disabled');
                $(btnId).val("<?php echo Yii::t('memberHome', '再次发送'); ?>");
                $("#Member_mobile_vcode_em_").remove();
            }
        }, 1000);
    }

    /**
     * 验证码倒计时
     * @param btnId
     * @param  totalTime  倒计时的时间  秒
     */
    function startTimer(btnId, totalTime) {
        $(btnId).attr('disabled','disabled');
        $(btnId).val('<?php echo Yii::t('memberHome', '发送中'); ?>(' + totalTime + ')'); //即刻计时
        var itv = setInterval(function () {
            totalTime--;
            if(totalTime < 10) totalTime = '0' + totalTime; 
            $(btnId).val('<?php echo Yii::t('memberHome', '发送中'); ?>(' + totalTime + ')');
            if (totalTime <= 0) {
                clearInterval(itv);
                itv = null;
                $(btnId).attr("data-status", "1").removeAttr('disabled');
                $(btnId).val("<?php echo Yii::t('memberHome', '点击重新发送'); ?>");
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
    function sendMobileCode(btnId, mobileId,fn) {
        $(btnId).click(function () {
            $("#Member_mobile_vcode_em_").remove();
            $('#Member_mobileVerifyCode_em_').hide();
            var mobile = $(mobileId).val();

            if (!mobile) {
                //alert('<?php echo Yii::t('memberMember', '请输入手机号！') ?>');
                $(this).after('<span class="revise-message" id="Member_mobile_vcode_em_" style=""><?php echo Yii::t('memberMember', '您未设置手机号码') ?></span>');
                return false;
            }
            if (!mobile.match(/(^1[34578]{1}\d{9}$)|(^852\d{8}$)/)) {
                //alert('<?php echo Yii::t('memberMember', '请输入正确的您的手机号码'); ?>');
                $(this).after('<span class="revise-message" id="Member_mobile_vcode_em_" style=""><?php echo Yii::t('memberMember', '您设置的手机号码有误，请修改'); ?></span>');
                return false;
            }
            $(btnId).val('<?php echo Yii::t('memberMember','发送中...')?>');
//            startTimer(btnId,59);

            setTimeout(function () {
                if($(mobileId).next('.errorMessage:visible').text().length>0){
                    $(btnId).find('span').attr('data-status', '1').html("<?php echo Yii::t('memberMember', '获取验证码'); ?>");
                    return false;
                }
                if(typeof fn =='function'){
                    var rs = fn();
                    if(!rs){
                        return false;
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createUrl('/member/home/getMobileVerifyCode'); ?>",
                    data: {"YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken; ?>", "mobile": mobile},
                    success: function (msg) {
                        if (msg !== 'success') {
                            $(btnId).find('span').html('<?php echo Yii::t('memberHome', '发送失败,请重试'); ?>').attr('data-status', 1);
                        } else {
                            //clearInterval(itv);
                            <?php
                                echo Tool::getConfig('smsapi','ytxVoiceVerify')==SmsApiConfigForm::VOICE_VERIFY_YES ? 'startTimer2(btnId, 60, mobileId);':'startTimer(btnId,60);';
                            ?>
                            
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
                        <?php
                          echo Tool::getConfig('smsapi','ytxVoiceVerify')==SmsApiConfigForm::VOICE_VERIFY_YES ? 'startTimer2(btnId, 60, "");':'startTimer(btnId,60);';
                         ?>
                    } else {
                        $(btnId).find('span').html('<?php echo Yii::t('memberHome','发送失败'); ?>').attr('data-status', 1);
                    }
                }
            });
            return false;
        });
    }

    /**
     * ajax 发送验证码  联动支付
     * @param btnId 获取验证码的按钮id   <a href="#" class="sendMobileCode" id="sendMobileCode"><span data-status="1">获取验证码</span></a>
     */
    function sendQuickPay(btnId,param,url) {
        $(btnId).click(function () {

            if ($(btnId).find('span').attr('data-status') == 0) {
                alert('<?php echo Yii::t('memberHome', '请等待……'); ?>');
                return false;
            }
            $(btnId).find('span').attr('data-status', '0').html("<?php echo Yii::t('memberHome', '发送中……'); ?>");
            $.ajax({
                type: "POST",
                url: url,
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

    function timeDown(){
    }

</script>