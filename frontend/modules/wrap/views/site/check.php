<?php
/**
 * @author qinghao.ye <qinghaoye@sina.com>
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="<?php echo empty($this->keywords) ? '' : $this->keywords; ?>" />
        <meta name="Description" content="<?php echo empty($this->description) ? '' : $this->description; ?>" />
        <meta name="renderer" content="webkit">
        <title><?php echo empty($this->title) ? '' : $this->title; ?></title>
        <link rel="shortcut icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
        <link rel="icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">

        <link rel="stylesheet" type="text/css" href="<?php echo CSS_DOMAIN; ?>global.css" />
        <script>
            document.domain = "<?php echo substr(DOMAIN, 11) ?>";
        </script>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <!--<script src="<?php echo DOMAIN; ?>/js/jquery-gate.js" type="text/javascript"></script>-->
        <style>
            table, td{border: 0;}
            .center{text-align:center;}
            .input-text{width: 120px;}
            .errorMessage{color: red;}
            .submit{width: 80px;height: 28px;}
            #check-body{width: 100%;height: 30px; background-color: gray; padding: 20px 0;}
            #check-div{max-width:300px;margin: 0 auto; background-color: wheat;}
            #check-table{width:100%;}
            #check-table tr{height: 32px;line-height: 30px;}
        </style>
    </head>
    <body>
        <form id="check-form" method="post" action="<?php echo Yii::app()->createAbsoluteUrl('wrap/site/check');?>" enctype="multipart/form-data">
            <input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken; ?>" />
            <div id="check-body">
                <div id="check-div">
                    <?php if($error != false): ?>
                    <span class="errorMessage" style="display: block;padding: 5px 0 0 5px;"><?php echo Yii::t('wrapCheck',$error);?></span>
                    <?php endif;?>
                    <table id="check-table">
                        <tr>
                            <th class="center" colspan="2">登陆验证</th>
                        </tr>
                        <tr>
                            <td class="center">手机号:</td>
                            <td>
                                <input id="mobile" class="input-text" type="text" value="<?php if(!empty($data)&&$data['mobile'])echo $data['mobile'];?>" name="check[mobile]" />
                                <a href="#" id="sendMobileCode">
                                    <span data-status="1">[<?php echo Yii::t('wrapCheck','获取验证码'); ?>]</span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="center">验证码:</td>
                            <td>
                                <input id="code" class="input-text" type="text" value="" name="check[code]" />
                            </td>
                        </tr>
                        <tr>
                            <td class="center" colspan="2">
                                <input class="submit" type="submit" value="验证" name="yt0"/>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
        
        <script type="text/javascript">
            $(function () {
                sendMobileCode2("#sendMobileCode");
            });
            /**
             * 验证码倒计时
             * @param btnId
             * @param  totalTime  倒计时的时间  秒
             */
            function startTimer(btnId, totalTime) {
                var itv = null;
                itv = setInterval(function () {
                    totalTime--;
                    $(btnId).find('span').html('<?php echo Yii::t('wrapCheck', '重新发送'); ?>(' + totalTime + ')');
                    if (totalTime <= 0) {
                        clearInterval(itv);
                        itv = null;
                        $(btnId).find('span').attr("data-status", "1");
                        $(btnId).find('span').html("<?php echo Yii::t('wrapCheck', '再次发送'); ?>");
                        $(".errorMessage").remove();
                    }
                }, 1000);
            }

            /**
             * ajax 发送验证码 登录后的验证
             * @param btnId 获取验证码的按钮id   <a href="#" class="sendMobileCode" id="sendMobileCode"><span data-status="1">获取验证码</span></a>
             */
            function sendMobileCode2(btnId) {
                totalTime = <?php echo $totalTime;?>;
                $(btnId).click(function () {
                    $(".errorMessage").remove();
                    var mobile = $('#mobile').val();
                    if (!mobile) {
                        $('#sendMobileCode').after('<div class="errorMessage"><?php echo Yii::t('wrapCheck', '请输入手机号！') ?></div>');
                        return false;
                    }
                    if (!mobile.match(/(^\d{11}$)|(^852\d{8}$)/)) {
                        $('#sendMobileCode').after('<div class="errorMessage"><?php echo Yii::t('wrapCheck', '请输入正确的手机号'); ?></div>');
                        return false;
                    }
                    if ($(btnId).find('span').attr('data-status') == 0) {
                        alert('<?php echo Yii::t('wrapCheck', '请等待…'); ?>');
                        return false;
                    }
                    $(btnId).find('span').attr('data-status', '0').html("<?php echo Yii::t('wrapCheck', '发送中…'); ?>");
                    $.ajax({
                        type: "POST",
                        url: "<?php echo Yii::app()->createUrl('/wrap/site/getCode'); ?>",
                        data: {"YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken; ?>","mobile":mobile},
                        success: function (msg) {
                            if (msg === 'success') {
                                startTimer(btnId, totalTime);
                            } else {
                                $(btnId).find('span').html('<?php echo Yii::t('wrapCheck','发送失败'); ?>').attr('data-status', 1);
                                $('#sendMobileCode').after('<div class="errorMessage">'+msg+'</div>');
                            }
                        }
                    });
                    return false;
                });
            }
        </script>
    </body>
</html>